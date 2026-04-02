#!/usr/bin/env python3
"""
Deploy canonical site/wp-content artifacts to uPress staging via FTP.

Uploads:
  - site/wp-content/themes/ea-eyalamit/  -> wp-content/themes/ea-eyalamit/
  - site/wp-content/mu-plugins/ea-staging-noindex.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m2-auto-activate-child.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m2-ensure-fluent-active.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m2-seed-shell-once.php -> wp-content/mu-plugins/
  Optional (--upload-wxr):
  - site/exports/m2-pages-seed.wxr -> wp-content/uploads/ea-m2-seed/m2-pages-seed.wxr (ייבוא ב-wp-admin: כלים → ייבוא)

Reads connection from local/staging.credentials.md (same shape as ftp_sync_wp_config_db_password.py).

Usage (repo root):
  python3 scripts/ftp_deploy_site_wp_content.py
  python3 scripts/ftp_deploy_site_wp_content.py --upload-wxr
  python3 scripts/ftp_deploy_site_wp_content.py --dry-run

Requires: FTP from this machine (port open); **נתיב מרוחק** in credentials = FTP root where wp-config.php lives.
"""
from __future__ import annotations

import argparse
import io
import re
import sys
from pathlib import Path


def parse_ftp_block(md: str) -> dict[str, str]:
    out: dict[str, str] = {}
    for label, key in (
        ("**Host:**", "ftp_host"),
        ("**Port:**", "ftp_port"),
        ("**Username:**", "ftp_user"),
        ("**Password:**", "ftp_password"),
    ):
        m = re.search(re.escape(label) + r"\s*([^\n]+)", md)
        if m:
            out[key] = m.group(1).strip()
    # Remote path (Hebrew doc)
    m = re.search(
        r"\*\*נתיב מרוחק \(remote path\):\*\*\s*([^\n]+)",
        md,
    )
    if m:
        out["ftp_remote_root"] = m.group(1).strip()
    else:
        m = re.search(r"\*\*[Rr]emote [Pp]ath:\*\*\s*([^\n]+)", md)
        if m:
            out["ftp_remote_root"] = m.group(1).strip()
    if "ftp_remote_root" not in out:
        out["ftp_remote_root"] = "/"
    for k in ("ftp_host", "ftp_user", "ftp_password"):
        if k not in out:
            raise SystemExit(f"Missing {k} in local/staging.credentials.md (see staging.credentials.example.md).")
    return out


def ftp_ensure_cwd(ftp, path: str) -> None:
    """CD to path from current root, creating directories as needed (relative segments)."""
    path = path.strip().replace("\\", "/")
    if path in ("", "/"):
        return
    parts = [p for p in path.split("/") if p and p != "."]
    for p in parts:
        try:
            ftp.cwd(p)
        except Exception:
            try:
                ftp.mkd(p)
            except Exception:
                pass
            ftp.cwd(p)


def ftp_upload_file(ftp, local: Path, remote_name: str) -> None:
    with open(local, "rb") as f:
        ftp.storbinary(f"STOR {remote_name}", f)


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true", help="List files only, no FTP.")
    ap.add_argument(
        "--upload-wxr",
        action="store_true",
        help="Also upload site/exports/m2-pages-seed.wxr for wp-admin import (path uploads/ea-m2-seed/).",
    )
    args = ap.parse_args()

    root = Path(__file__).resolve().parents[1]
    cred_path = root / "local" / "staging.credentials.md"
    if not cred_path.is_file():
        raise SystemExit(f"Missing {cred_path} — copy from staging.credentials.example.md")

    c = parse_ftp_block(cred_path.read_text(encoding="utf-8"))
    theme_src = root / "site" / "wp-content" / "themes" / "ea-eyalamit"
    mu_noindex = root / "site" / "wp-content" / "mu-plugins" / "ea-staging-noindex.php"
    mu_activate = root / "site" / "wp-content" / "mu-plugins" / "ea-m2-auto-activate-child.php"
    mu_fluent = root / "site" / "wp-content" / "mu-plugins" / "ea-m2-ensure-fluent-active.php"
    mu_seed = root / "site" / "wp-content" / "mu-plugins" / "ea-m2-seed-shell-once.php"
    if not theme_src.is_dir():
        raise SystemExit(f"Missing theme dir: {theme_src}")
    if not mu_noindex.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_noindex}")
    if not mu_activate.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_activate}")
    if not mu_fluent.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_fluent}")
    if not mu_seed.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_seed}")

    files: list[tuple[Path, str]] = []
    for f in sorted(theme_src.rglob("*")):
        if f.is_file():
            rel = f.relative_to(theme_src).as_posix()
            files.append((f, f"wp-content/themes/ea-eyalamit/{rel}"))
    files.append((mu_noindex, "wp-content/mu-plugins/ea-staging-noindex.php"))
    files.append((mu_activate, "wp-content/mu-plugins/ea-m2-auto-activate-child.php"))
    files.append((mu_fluent, "wp-content/mu-plugins/ea-m2-ensure-fluent-active.php"))
    files.append((mu_seed, "wp-content/mu-plugins/ea-m2-seed-shell-once.php"))

    wxr = root / "site" / "exports" / "m2-pages-seed.wxr"
    if args.upload_wxr:
        if not wxr.is_file():
            raise SystemExit(f"Missing WXR: {wxr}")
        files.append((wxr, "wp-content/uploads/ea-m2-seed/m2-pages-seed.wxr"))

    if args.dry_run:
        print("Dry-run — would upload:")
        for _local, remote in files:
            print(f"  -> {remote}")
        return

    import ftplib

    host = c["ftp_host"]
    port = int(c.get("ftp_port") or "21")
    user = c["ftp_user"]
    pw = c["ftp_password"]
    remote_root = c["ftp_remote_root"].strip() or "/"

    ftp = ftplib.FTP()
    ftp.connect(host, port, timeout=90)
    ftp.login(user, pw)

    if remote_root and remote_root != "/":
        ftp_ensure_cwd(ftp, remote_root)

    # Sanity: wp-config or wp-content should exist on staging
    try:
        nl = set(ftp.nlst())
    except Exception as e:
        raise SystemExit(f"FTP nlst failed at remote root: {e}") from e
    if "wp-content" not in nl and "wp-config.php" not in nl:
        print(
            "WARN: neither wp-content nor wp-config.php in FTP root — check נתיב מרוחק.",
            file=sys.stderr,
        )

    for local_path, remote_rel in files:
        remote_rel = remote_rel.replace("\\", "/")
        parent = str(Path(remote_rel).parent.as_posix())
        name = Path(remote_rel).name
        ftp.cwd("/")
        if remote_root and remote_root != "/":
            ftp_ensure_cwd(ftp, remote_root.strip("/"))
        ftp_ensure_cwd(ftp, parent)
        ftp_upload_file(ftp, local_path, name)
        print(f"OK: {remote_rel}", flush=True)

    ftp.quit()
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
