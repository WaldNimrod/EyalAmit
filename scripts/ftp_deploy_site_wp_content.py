#!/usr/bin/env python3
"""
Deploy canonical site/wp-content artifacts to uPress staging via FTP/FTPS.

Uploads:
  - site/wp-content/themes/ea-eyalamit/  -> wp-content/themes/ea-eyalamit/
  - every site/wp-content/mu-plugins/*.php except MU_PLUGIN_DENYLIST
    (WAIT-WAVE 2026-08-18: glob + explicit denylist, so new ea-*-once.php cannot be skipped)
  Optional (--upload-wxr):
  - site/exports/m2-pages-seed.wxr -> wp-content/uploads/ea-m2-seed/m2-pages-seed.wxr

Reads connection from local/.env.upress (see docs/project/UPRESS_WORDPRESS_STANDARD_v2.md §12).

⚠ This uploads the WORKING TREE, not a git ref, and never prunes. Two consequences
that have already bitten (see assert_clean_tree): an uncommitted edit ships and then
exists only on one machine, and an older checkout ships and silently reverts the live
site. Since 2026-09-18 the script therefore refuses a dirty site/ and records the
deployed commit in _COMMUNICATION/team_100/S006/DEPLOY-LOG.md.

Usage (repo root):
  pip install -r scripts/requirements-upress.txt
  python3 scripts/ftp_deploy_site_wp_content.py
  python3 scripts/ftp_deploy_site_wp_content.py --upload-wxr
  python3 scripts/ftp_deploy_site_wp_content.py --dry-run
  python3 scripts/ftp_deploy_site_wp_content.py --allow-dirty "hotfix, committing next"
"""
from __future__ import annotations

import argparse
import datetime
import subprocess
import sys
from pathlib import Path

from upress_ftp_env import (
    connect_ftp,
    ftp_cwd_to_wordpress_root,
    ftp_ensure_cwd,
    ftp_upload_file,
)

# Filename → reason. Empty as of WAIT-WAVE: every ea-*.php on disk is staging-safe
# (once-plugins are self-guarded). Add a name here only with a written reason.
MU_PLUGIN_DENYLIST: dict[str, str] = {
    "ea-s006-strip-team80-seo-once.php": (
        "S006 R2 W1: held back from this wave by decision. (The original reason said "
        "'untracked'; it has been tracked since fabd106, so the file is in git — it is "
        "the deploy that is withheld, not the file that is missing.)"
    ),
}

DEPLOY_LOG = "_COMMUNICATION/team_100/S006/DEPLOY-LOG.md"


def _git(root: Path, *args: str) -> str:
    """Run git in the repo and return stripped stdout ('' on any failure)."""
    try:
        out = subprocess.run(
            ["git", *args], cwd=root, capture_output=True, text=True, timeout=20
        )
    except Exception:
        return ""
    return out.stdout.strip() if out.returncode == 0 else ""


def assert_clean_tree(root: Path, allow_dirty: str | None) -> str:
    """Refuse to deploy from a dirty working tree, and report what will ship.

    This script uploads the working tree on disk, NOT a git ref. That has already
    cost this project twice on 2026-09-06: commit 887d270 retroactively rescued 44
    files that staging was serving while they existed only as uncommitted edits on
    one machine, and fabd106 rescued 25 more including two untracked mu-plugins.
    Either an uncommitted edit ships and lives nowhere but one laptop, or an older
    checkout ships and silently reverts the live site.

    So: a dirty `site/` stops the deploy, and every deploy records the commit whose
    tree actually went to the server.
    """
    head = _git(root, "rev-parse", "HEAD")
    branch = _git(root, "rev-parse", "--abbrev-ref", "HEAD")
    if not head:
        raise SystemExit(
            "Refusing to deploy: cannot read git HEAD. The server would receive an "
            "unidentifiable tree."
        )

    dirty = _git(root, "status", "--porcelain", "--", "site/")
    if dirty:
        if not allow_dirty:
            raise SystemExit(
                "Refusing to deploy: uncommitted changes under site/.\n"
                + dirty
                + "\n\nThis script ships the working tree, so these edits would go live "
                "while existing in no commit — exactly the failure that produced the "
                "887d270 and fabd106 rescue commits.\n"
                "Commit them, or re-run with --allow-dirty 'written reason'."
            )
        print(f"WARN: deploying a DIRTY tree. Reason given: {allow_dirty}", file=sys.stderr)
        print(dirty, file=sys.stderr)

    print(f"Deploying tree of commit {head[:12]} on branch {branch}"
          f"{' + UNCOMMITTED EDITS' if dirty else ''}", flush=True)
    return head


def record_deploy(root: Path, head: str, count: int, dirty_reason: str | None) -> None:
    """Append what actually shipped, so the server's state is reconstructible."""
    log = root / DEPLOY_LOG
    stamp = datetime.datetime.now().astimezone().isoformat(timespec="seconds")
    branch = _git(root, "rev-parse", "--abbrev-ref", "HEAD") or "?"
    version = ""
    style = root / "site/wp-content/themes/ea-eyalamit/style.css"
    if style.is_file():
        for line in style.read_text(errors="replace").splitlines()[:20]:
            if line.lower().startswith("version:"):
                version = line.split(":", 1)[1].strip()
                break
    note = f" · DIRTY: {dirty_reason}" if dirty_reason else ""
    line = f"- {stamp} · `{head[:12]}` · {branch} · theme {version or '?'} · {count} files{note}\n"
    try:
        if not log.exists():
            log.parent.mkdir(parents=True, exist_ok=True)
            log.write_text(
                "# Deploy log — what actually reached the server\n\n"
                "Written by `scripts/ftp_deploy_site_wp_content.py`. The script uploads the\n"
                "working tree, not a git ref, so this file is the record of which commit's\n"
                "tree is live. A line marked DIRTY shipped edits that were in no commit.\n\n"
            )
        with log.open("a") as fh:
            fh.write(line)
        print(f"Recorded in {DEPLOY_LOG}", flush=True)
    except Exception as e:  # never fail a completed deploy over bookkeeping
        print(f"WARN: could not write deploy log: {e}", file=sys.stderr)


def collect_mu_plugin_files(mu_dir: Path) -> tuple[list[tuple[Path, str]], list[tuple[str, str]], list[str]]:
    """Return (upload_pairs, denied, orphans). orphans must be empty."""
    if not mu_dir.is_dir():
        raise SystemExit(f"Missing mu-plugins dir: {mu_dir}")
    on_disk = sorted(p for p in mu_dir.glob("*.php") if p.is_file())
    uploads: list[tuple[Path, str]] = []
    denied: list[tuple[str, str]] = []
    named = {p.name for p in on_disk}
    for p in on_disk:
        if p.name in MU_PLUGIN_DENYLIST:
            denied.append((p.name, MU_PLUGIN_DENYLIST[p.name]))
            continue
        uploads.append((p, f"wp-content/mu-plugins/{p.name}"))
    orphans = sorted(MU_PLUGIN_DENYLIST.keys() - named)
    return uploads, denied, orphans


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true", help="List files only, no FTP.")
    ap.add_argument(
        "--upload-wxr",
        action="store_true",
        help="Also upload site/exports/m2-pages-seed.wxr for wp-admin import (path uploads/ea-m2-seed/).",
    )
    ap.add_argument(
        "--allow-dirty",
        metavar="REASON",
        help="Deploy even though site/ has uncommitted changes. Requires a written reason, "
        "which is printed and recorded in the deploy log.",
    )
    args = ap.parse_args()

    root = Path(__file__).resolve().parents[1]
    head = assert_clean_tree(root, args.allow_dirty)
    theme_src = root / "site" / "wp-content" / "themes" / "ea-eyalamit"
    mu_dir = root / "site" / "wp-content" / "mu-plugins"
    if not theme_src.is_dir():
        raise SystemExit(f"Missing theme dir: {theme_src}")
    mu_uploads, mu_denied, mu_orphans = collect_mu_plugin_files(mu_dir)
    if mu_orphans:
        raise SystemExit(
            "MU_PLUGIN_DENYLIST names missing from disk: " + ", ".join(mu_orphans)
        )
    must = mu_dir / "ea-staging-noindex.php"
    if not must.is_file():
        raise SystemExit(f"Missing required mu-plugin: {must}")

    files: list[tuple[Path, str]] = []
    for f in sorted(theme_src.rglob("*")):
        if f.is_file():
            rel = f.relative_to(theme_src).as_posix()
            files.append((f, f"wp-content/themes/ea-eyalamit/{rel}"))
    files.extend(mu_uploads)

    wxr = root / "site" / "exports" / "m2-pages-seed.wxr"
    if args.upload_wxr:
        if not wxr.is_file():
            raise SystemExit(f"Missing WXR: {wxr}")
        files.append((wxr, "wp-content/uploads/ea-m2-seed/m2-pages-seed.wxr"))

    if args.dry_run:
        print("Dry-run — would upload:")
        for _local, remote in files:
            print(f"  -> {remote}")
        if mu_denied:
            print("Dry-run — denylist (not uploaded):")
            for name, reason in mu_denied:
                print(f"  skip {name} — {reason}")
        on_disk = {p.name for p in mu_dir.glob("*.php")}
        uploaded = {Path(remote).name for _l, remote in mu_uploads}
        denied_names = {n for n, _r in mu_denied}
        leftover = sorted(on_disk - uploaded - denied_names)
        if leftover:
            raise SystemExit("Orphan mu-plugins (not upload, not denylist): " + ", ".join(leftover))
        print(f"mu-plugins coverage: {len(uploaded)} upload · {len(denied_names)} denylist · 0 orphan")
        return

    ftp, remote_rr = connect_ftp(timeout=90)

    try:
        nl = set(ftp.nlst())
    except Exception as e:
        ftp.quit()
        raise SystemExit(f"FTP nlst failed at WordPress root: {e}") from e
    if "wp-content" not in nl and "wp-config.php" not in nl:
        print(
            "WARN: neither wp-content nor wp-config.php in CWD — check UPRESS_FTP_REMOTE_ROOT.",
            file=sys.stderr,
        )

    for local_path, remote_rel in files:
        remote_rel = remote_rel.replace("\\", "/")
        if "\n" in remote_rel or "\r" in remote_rel:
            print(f"WARN: skip FTP (newline in path): {remote_rel}", flush=True)
            continue
        parent = str(Path(remote_rel).parent.as_posix())
        name = Path(remote_rel).name
        if "\n" in name or "\r" in name:
            print(f"WARN: skip FTP (newline in filename): {name!r}", flush=True)
            continue
        ftp.cwd("/")
        ftp_cwd_to_wordpress_root(ftp, remote_rr)
        ftp_ensure_cwd(ftp, parent)
        ftp_upload_file(ftp, local_path, name)
        print(f"OK: {remote_rel}", flush=True)

    ftp.quit()
    record_deploy(root, head, len(files), args.allow_dirty)
    print("Done: FTP deploy site/wp-content (child theme + mu-plugins).", flush=True)
    print(
        "Tip: hit staging homepage once (HTTP) so ea-m2-auto-activate-child.php switches theme; "
        "then import WXR / menus / forms via wp-cli or admin as documented.",
        file=sys.stderr,
    )
    if args.upload_wxr:
        print(
            "WXR on server: Media Library path uploads/ea-m2-seed/m2-pages-seed.wxr — "
            "wp-admin → כלים → ייבוא → WordPress (או העלאה מהמחשב).",
            file=sys.stderr,
        )


if __name__ == "__main__":
    main()
