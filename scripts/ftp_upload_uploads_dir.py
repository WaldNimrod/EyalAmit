#!/usr/bin/env python3
"""
Upload a local directory tree to wp-content/uploads/ on uPress staging via FTP.

Usage (repo root):
  python3 scripts/ftp_upload_uploads_dir.py /tmp/ea-uploads-staging
  python3 scripts/ftp_upload_uploads_dir.py /tmp/ea-uploads-staging --dry-run
"""
from __future__ import annotations

import argparse
import sys
from pathlib import Path

from upress_ftp_env import connect_ftp, ftp_ensure_cwd, ftp_upload_file


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("src_dir", help="Local directory to upload (its contents go under wp-content/uploads/)")
    ap.add_argument("--dry-run", action="store_true")
    args = ap.parse_args()

    src = Path(args.src_dir).resolve()
    if not src.is_dir():
        raise SystemExit(f"Not a directory: {src}")

    files = sorted(f for f in src.rglob("*") if f.is_file())
    if not files:
        raise SystemExit(f"No files found under {src}")

    if args.dry_run:
        print("Dry-run — would upload:")
        for f in files:
            rel = f.relative_to(src).as_posix()
            print(f"  -> wp-content/uploads/{rel}")
        return

    ftp, remote_rr = connect_ftp(timeout=120)

    for local_path in files:
        rel = local_path.relative_to(src).as_posix()
        remote_rel = f"wp-content/uploads/{rel}"
        parent = str(Path(remote_rel).parent.as_posix())
        name = local_path.name
        ftp.cwd("/")
        from upress_ftp_env import ftp_cwd_to_wordpress_root
        ftp_cwd_to_wordpress_root(ftp, remote_rr)
        ftp_ensure_cwd(ftp, parent)
        ftp_upload_file(ftp, local_path, name)
        print(f"OK: {remote_rel}", flush=True)

    ftp.quit()
    print(f"Done: uploaded {len(files)} files to wp-content/uploads/.", flush=True)


if __name__ == "__main__":
    main()
