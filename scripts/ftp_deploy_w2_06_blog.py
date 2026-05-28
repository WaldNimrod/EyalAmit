#!/usr/bin/env python3
"""
Deploy WP-W2-06 Blog Migration artifacts to uPress staging via FTP/FTPS.

Uploads (targeted — only W2-06 new/changed files):
  Theme (changed files):
    page-templates/tpl-blog-archive.php
    page-templates/tpl-blog-single.php
    template-parts/blocks/block-blog-card.php
    inc/wave2-w2-06.php
    assets/css/ea-blog.css
    functions.php   (require_once wave2-w2-06 added)
    style.css       (Version 1.4.0)
  Mu-plugin:
    ea-blog-shortcode-cleanup.php
  WXR (for wp-admin import):
    site/exports/blog-legacy.wxr → wp-content/uploads/ea-blog-seed/blog-legacy.wxr

Usage (from repo root):
  pip install -r scripts/requirements-upress.txt
  python3 scripts/ftp_deploy_w2_06_blog.py
  python3 scripts/ftp_deploy_w2_06_blog.py --dry-run
"""
from __future__ import annotations

import argparse
import sys
from pathlib import Path

from upress_ftp_env import (
    connect_ftp,
    ftp_cwd_to_wordpress_root,
    ftp_ensure_cwd,
    ftp_upload_file,
)


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true")
    args = ap.parse_args()

    root = Path(__file__).resolve().parents[1]
    theme = root / "site" / "wp-content" / "themes" / "ea-eyalamit"
    mu    = root / "site" / "wp-content" / "mu-plugins"
    wxr   = root / "site" / "exports" / "blog-legacy.wxr"

    # (local_path, remote_path_relative_to_wp_root)
    files: list[tuple[Path, str]] = [
        # Theme — W2-06 changed/new files only
        (theme / "page-templates/tpl-blog-archive.php",          "wp-content/themes/ea-eyalamit/page-templates/tpl-blog-archive.php"),
        (theme / "page-templates/tpl-blog-single.php",           "wp-content/themes/ea-eyalamit/page-templates/tpl-blog-single.php"),
        (theme / "template-parts/blocks/block-blog-card.php",    "wp-content/themes/ea-eyalamit/template-parts/blocks/block-blog-card.php"),
        (theme / "inc/wave2-w2-06.php",                          "wp-content/themes/ea-eyalamit/inc/wave2-w2-06.php"),
        (theme / "assets/css/ea-blog.css",                       "wp-content/themes/ea-eyalamit/assets/css/ea-blog.css"),
        (theme / "functions.php",                                 "wp-content/themes/ea-eyalamit/functions.php"),
        (theme / "style.css",                                     "wp-content/themes/ea-eyalamit/style.css"),
        # Mu-plugin — shortcode cleanup
        (mu / "ea-blog-shortcode-cleanup.php",                   "wp-content/mu-plugins/ea-blog-shortcode-cleanup.php"),
        # WXR — for wp-admin import
        (wxr,                                                     "wp-content/uploads/ea-blog-seed/blog-legacy.wxr"),
    ]

    # Validate all local files exist before connecting
    missing = [str(f) for f, _ in files if not f.is_file()]
    if missing:
        raise SystemExit("Missing local files:\n" + "\n".join(f"  {m}" for m in missing))

    if args.dry_run:
        print("Dry-run — would upload:")
        for local, remote in files:
            print(f"  {local.relative_to(root)} -> {remote}")
        return

    ftp, remote_rr = connect_ftp(timeout=120)

    try:
        for local_path, remote_rel in files:
            remote_rel = remote_rel.replace("\\", "/")
            parent     = str(Path(remote_rel).parent.as_posix())
            name       = Path(remote_rel).name
            ftp.cwd("/")
            ftp_cwd_to_wordpress_root(ftp, remote_rr)
            ftp_ensure_cwd(ftp, parent)
            ftp_upload_file(ftp, local_path, name)
            print(f"OK  {remote_rel}", flush=True)
    finally:
        ftp.quit()

    print()
    print("Done: W2-06 blog artifacts deployed to uPress staging.")
    print()
    print("Next steps:")
    print("  1. WP Admin → כלים → ייבוא → WordPress")
    print("     Locate: wp-content/uploads/ea-blog-seed/blog-legacy.wxr (or upload from disk)")
    print("     Map author → eyaladmin (Eyal)")
    print("  2. Deploy 301 rules: copy site/blog-301-rules.htaccess lines into staging .htaccess")
    print("     OR import site/blog-301-redirection-plugin.json via Redirection plugin")
    print("  3. Verify: bash scripts/verify-301-blog.sh")
    print("  4. AC sweep: curl 54 /blog/* URLs → expect 200")


if __name__ == "__main__":
    main()
