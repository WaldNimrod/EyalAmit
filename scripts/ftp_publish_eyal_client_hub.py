#!/usr/bin/env python3
"""
Upload hub/dist/ to uPress via FTP/FTPS (Client Hub Standard v1.1).

By default **prunes** the remote hub tree: deletes files on the server that are not present
in the local dist (removes stale pages/assets from old hub versions).

Reads local/.env.upress — UPRESS_EYAL_HUB_PATH (default ea-eyal-hub) relative to WordPress root
(see docs/project/UPRESS_WORDPRESS_STANDARD_v2.md §12 + docs/project/EYAL_ENV_VARS_REFERENCE.md §2).

Usage (repo root):
  pip install -r scripts/requirements-upress.txt
  python3 scripts/ftp_publish_eyal_client_hub.py
  python3 scripts/ftp_publish_eyal_client_hub.py --dry-run
  python3 scripts/ftp_publish_eyal_client_hub.py --no-prune   # upload only; leaves remote junk
"""
from __future__ import annotations

import argparse
import os
import time
from pathlib import Path

from upress_ftp_env import (
    connect_ftp,
    eyal_hub_relative_path,
    ftp_cwd_to_wordpress_root,
    ftp_delete_hub_file,
    ftp_ensure_cwd,
    ftp_list_hub_remote_files,
    ftp_upload_file,
)

# Heavy binary assets (mostly the ~200 legacy JPGs under files/team40/ea-legacy-curated/media/)
# that dominate transfer time and occasionally time out. Uploaded LAST so the core hub —
# HTML pages + CSS/JS/JSON — is live even if a heavy transfer needs a retry (core-first order).
_HEAVY_EXTS = frozenset(
    {"jpg", "jpeg", "png", "gif", "webp", "svg", "mp4", "mov", "pdf", "zip", "tif", "tiff", "ico"}
)


def _is_heavy_media(rel_posix: str) -> bool:
    p = rel_posix.lower()
    ext = p.rsplit(".", 1)[-1] if "." in p else ""
    return ext in _HEAVY_EXTS


def collect_files(dist: Path) -> list[tuple[Path, str]]:
    out: list[tuple[Path, str]] = []
    for f in sorted(dist.rglob("*")):
        if f.is_file():
            rel = f.relative_to(dist).as_posix()
            out.append((f, rel))
    # Core-first: text/config assets before heavy binaries, path-sorted within each group.
    out.sort(key=lambda fr: (1 if _is_heavy_media(fr[1].replace("\\", "/")) else 0, fr[1]))
    return out


def _reconnect(old_ftp):
    """Tear down a (possibly wedged) session and open a fresh one at the WordPress root."""
    try:
        old_ftp.quit()
    except Exception:
        try:
            old_ftp.close()
        except Exception:
            pass
    return connect_ftp(timeout=120)


def upload_one(ftp, remote_rr: str, hub_rel: str, local_path: Path, rel_posix: str) -> None:
    if "\n" in rel_posix or "\r" in rel_posix:
        print(f"WARN: skip FTP (newline in path): {rel_posix}", flush=True)
        return
    parent = str(Path(rel_posix).parent.as_posix())
    name = Path(rel_posix).name
    if "\n" in name or "\r" in name:
        print(f"WARN: skip FTP (newline in filename): {name!r}", flush=True)
        return
    ftp.cwd("/")
    ftp_cwd_to_wordpress_root(ftp, remote_rr)
    ftp_ensure_cwd(ftp, hub_rel)
    if parent and parent != ".":
        ftp_ensure_cwd(ftp, parent)
    ftp_upload_file(ftp, local_path, name)
    print(f"OK: {hub_rel}/{rel_posix}", flush=True)


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true")
    ap.add_argument(
        "--no-prune",
        action="store_true",
        help="Do not delete remote files missing from local dist (not recommended).",
    )
    ap.add_argument(
        "--max-retries",
        type=int,
        default=3,
        help="Per-file upload attempts before giving up on that file (reconnects between attempts). Default 3.",
    )
    args = ap.parse_args()
    max_retries = max(1, args.max_retries)

    root = Path(__file__).resolve().parents[1]
    dist = root / "hub/dist"
    if not dist.is_dir():
        raise SystemExit(
            f"Missing {dist} — run: python3 scripts/build_eyal_client_hub.py [--mirror-docs]"
        )

    hub_rel = eyal_hub_relative_path()
    files = collect_files(dist)
    if not files:
        raise SystemExit(f"Refusing publish: {dist} has no files.")

    local_rels = set()
    for _lp, rel in files:
        rp = rel.replace("\\", "/")
        if "\n" not in rp and "\r" not in rp:
            local_rels.add(rp)

    if args.dry_run:
        from upress_ftp_env import load_upress_dotenv

        load_upress_dotenv()
        remote_rr = (os.getenv("UPRESS_FTP_REMOTE_ROOT") or "").strip()
        print("Dry-run — would upload to:", hub_rel, "under WP root; FTP remote_root:", remote_rr or "/")
        for _l, r in files:
            rn = r.replace("\\", "/")
            print(f"  -> {hub_rel}/{rn}")
        if args.no_prune:
            print("Dry-run: --no-prune → remote orphans would be left in place.")
        else:
            print("Dry-run: on real publish, remote files not in dist would be DELETEd (prune).")
        return

    ftp, remote_rr = connect_ftp(timeout=120)

    if not args.no_prune:
        try:
            remote_files = ftp_list_hub_remote_files(ftp, remote_rr, hub_rel)
        except Exception as e:
            ftp.quit()
            raise SystemExit(f"Failed to list remote hub for prune: {e}") from e
        orphans = sorted(remote_files - local_rels)
        for rel in orphans:
            try:
                ftp.cwd("/")
                ftp_delete_hub_file(ftp, remote_rr, hub_rel, rel)
                print(f"PRUNE: {hub_rel}/{rel}", flush=True)
            except Exception as ex:
                print(f"WARN: could not delete {hub_rel}/{rel}: {ex}", flush=True)

    failed: list[str] = []
    uploaded = 0
    for local_path, rel in files:
        rel_posix = rel.replace("\\", "/")
        for attempt in range(1, max_retries + 1):
            try:
                ftp.cwd("/")
                upload_one(ftp, remote_rr, hub_rel, local_path, rel_posix)
                uploaded += 1
                break
            except Exception as ex:
                print(
                    f"WARN: upload attempt {attempt}/{max_retries} failed for {rel_posix}: {ex}",
                    flush=True,
                )
                if attempt < max_retries:
                    time.sleep(min(8, 2 * attempt))  # backoff before reconnect
                    try:
                        ftp, remote_rr = _reconnect(ftp)
                        print("  → reconnected FTP session; retrying", flush=True)
                    except Exception as rex:
                        print(f"  → reconnect failed: {rex}", flush=True)
                else:
                    failed.append(rel_posix)

    try:
        ftp.quit()
    except Exception:
        pass

    if failed:
        print(
            f"WARN: {len(failed)} file(s) failed after {max_retries} attempts "
            f"({uploaded}/{len(files)} uploaded OK). Core hub pages/assets upload first, "
            f"so the site is live; re-run to retry the remaining (heavy media):",
            flush=True,
        )
        for rel_posix in failed:
            print(f"  FAILED: {rel_posix}", flush=True)
        raise SystemExit(1)

    print(f"Done: Eyal client hub FTP publish ({uploaded}/{len(files)} files).", flush=True)


if __name__ == "__main__":
    main()
