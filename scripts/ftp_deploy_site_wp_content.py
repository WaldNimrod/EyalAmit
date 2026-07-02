#!/usr/bin/env python3
"""
Deploy canonical site/wp-content artifacts to uPress staging via FTP/FTPS.

Uploads:
  - site/wp-content/themes/ea-eyalamit/  -> wp-content/themes/ea-eyalamit/
  - site/wp-content/mu-plugins/ea-staging-noindex.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m2-auto-activate-child.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m2-ensure-fluent-active.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m2-seed-shell-once.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m3-team80-placeholder-content-once.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m3-seed-instances-once.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m2-ia-slug-fixups-once.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m3-g5g7-q16-rest-dedupe-once.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m3-r2-featured-sample-once.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-m4-g2348-governance-once.php -> wp-content/mu-plugins/
  - site/wp-content/mu-plugins/ea-w2-05-shop-pages-seed-once.php -> wp-content/mu-plugins/
  Optional (--upload-wxr):
  - site/exports/m2-pages-seed.wxr -> wp-content/uploads/ea-m2-seed/m2-pages-seed.wxr

Reads connection from local/.env.upress (see docs/project/UPRESS_WORDPRESS_STANDARD_v2.md §12).

Usage (repo root):
  pip install -r scripts/requirements-upress.txt
  python3 scripts/ftp_deploy_site_wp_content.py
  python3 scripts/ftp_deploy_site_wp_content.py --upload-wxr
  python3 scripts/ftp_deploy_site_wp_content.py --dry-run
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
    ap.add_argument("--dry-run", action="store_true", help="List files only, no FTP.")
    ap.add_argument(
        "--upload-wxr",
        action="store_true",
        help="Also upload site/exports/m2-pages-seed.wxr for wp-admin import (path uploads/ea-m2-seed/).",
    )
    args = ap.parse_args()

    root = Path(__file__).resolve().parents[1]
    theme_src = root / "site" / "wp-content" / "themes" / "ea-eyalamit"
    mu_noindex = root / "site" / "wp-content" / "mu-plugins" / "ea-staging-noindex.php"
    mu_activate = root / "site" / "wp-content" / "mu-plugins" / "ea-m2-auto-activate-child.php"
    mu_fluent = root / "site" / "wp-content" / "mu-plugins" / "ea-m2-ensure-fluent-active.php"
    mu_seed = root / "site" / "wp-content" / "mu-plugins" / "ea-m2-seed-shell-once.php"
    mu_tree = root / "site" / "wp-content" / "mu-plugins" / "ea-m2-site-tree-lock-sync-once.php"
    mu_m3_80 = root / "site" / "wp-content" / "mu-plugins" / "ea-m3-team80-placeholder-content-once.php"
    mu_m3_inst = root / "site" / "wp-content" / "mu-plugins" / "ea-m3-seed-instances-once.php"
    mu_m2_ia = root / "site" / "wp-content" / "mu-plugins" / "ea-m2-ia-slug-fixups-once.php"
    mu_m3_g5g7 = root / "site" / "wp-content" / "mu-plugins" / "ea-m3-g5g7-q16-rest-dedupe-once.php"
    mu_m3_r2 = root / "site" / "wp-content" / "mu-plugins" / "ea-m3-r2-featured-sample-once.php"
    mu_m4_g2348 = root / "site" / "wp-content" / "mu-plugins" / "ea-m4-g2348-governance-once.php"
    mu_w2_05_shop = root / "site" / "wp-content" / "mu-plugins" / "ea-w2-05-shop-pages-seed-once.php"
    mu_w2_07_qr = root / "site" / "wp-content" / "mu-plugins" / "ea-w2-07-qr-seed-once.php"
    mu_w2_07_qr_data = root / "site" / "wp-content" / "mu-plugins" / "ea-w2-07-qr-content-data.php"
    mu_w2_09_redirects = root / "site" / "wp-content" / "mu-plugins" / "ea-w209-legacy-301-redirects.php"
    mu_w2_15_cf7 = root / "site" / "wp-content" / "mu-plugins" / "ea-w2-15-cf7-contact-form-once.php"
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
    if not mu_tree.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_tree}")
    if not mu_m3_80.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_m3_80}")
    if not mu_m3_inst.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_m3_inst}")
    if not mu_m2_ia.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_m2_ia}")
    if not mu_m3_g5g7.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_m3_g5g7}")
    if not mu_m3_r2.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_m3_r2}")
    if not mu_m4_g2348.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_m4_g2348}")
    if not mu_w2_07_qr.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_w2_07_qr}")
    if not mu_w2_07_qr_data.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_w2_07_qr_data}")
    if not mu_w2_09_redirects.is_file():
        raise SystemExit(f"Missing mu-plugin: {mu_w2_09_redirects}")

    files: list[tuple[Path, str]] = []
    for f in sorted(theme_src.rglob("*")):
        if f.is_file():
            rel = f.relative_to(theme_src).as_posix()
            files.append((f, f"wp-content/themes/ea-eyalamit/{rel}"))
    files.append((mu_noindex, "wp-content/mu-plugins/ea-staging-noindex.php"))
    files.append((mu_activate, "wp-content/mu-plugins/ea-m2-auto-activate-child.php"))
    files.append((mu_fluent, "wp-content/mu-plugins/ea-m2-ensure-fluent-active.php"))
    files.append((mu_seed, "wp-content/mu-plugins/ea-m2-seed-shell-once.php"))
    files.append((mu_tree, "wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php"))
    files.append((mu_m3_80, "wp-content/mu-plugins/ea-m3-team80-placeholder-content-once.php"))
    files.append((mu_m3_inst, "wp-content/mu-plugins/ea-m3-seed-instances-once.php"))
    files.append((mu_m2_ia, "wp-content/mu-plugins/ea-m2-ia-slug-fixups-once.php"))
    files.append((mu_m3_g5g7, "wp-content/mu-plugins/ea-m3-g5g7-q16-rest-dedupe-once.php"))
    files.append((mu_m3_r2, "wp-content/mu-plugins/ea-m3-r2-featured-sample-once.php"))
    files.append((mu_m4_g2348, "wp-content/mu-plugins/ea-m4-g2348-governance-once.php"))
    files.append((mu_w2_05_shop, "wp-content/mu-plugins/ea-w2-05-shop-pages-seed-once.php"))
    files.append((mu_w2_07_qr, "wp-content/mu-plugins/ea-w2-07-qr-seed-once.php"))
    files.append((mu_w2_07_qr_data, "wp-content/mu-plugins/ea-w2-07-qr-content-data.php"))
    files.append((mu_w2_09_redirects, "wp-content/mu-plugins/ea-w209-legacy-301-redirects.php"))
    files.append((mu_w2_15_cf7, "wp-content/mu-plugins/ea-w2-15-cf7-contact-form-once.php"))
    # Blog shortcode cleanup (strips legacy [vc_*] from content + excerpts) + author display-name fix.
    files.append((root / "site" / "wp-content" / "mu-plugins" / "ea-blog-shortcode-cleanup.php", "wp-content/mu-plugins/ea-blog-shortcode-cleanup.php"))
    files.append((root / "site" / "wp-content" / "mu-plugins" / "ea-w2-10-author-displayname-once.php", "wp-content/mu-plugins/ea-w2-10-author-displayname-once.php"))
    files.append((root / "site" / "wp-content" / "mu-plugins" / "ea-w2-10-nav-repair-canonical-once.php", "wp-content/mu-plugins/ea-w2-10-nav-repair-canonical-once.php"))
    # W1-02: SEO entity schema (extends Yoast @graph with Person/ProfessionalService/Service).
    files.append((root / "site" / "wp-content" / "mu-plugins" / "ea-w2-seo-schema.php", "wp-content/mu-plugins/ea-w2-seo-schema.php"))
    # W2-14-E (team_110): seed the 19 Mokesh memorial photos into the media library.
    files.append((root / "site" / "wp-content" / "mu-plugins" / "ea-w2-14e-mokesh-media-seed-once.php", "wp-content/mu-plugins/ea-w2-14e-mokesh-media-seed-once.php"))
    # WP-04: default OG/Twitter image (extends Yoast when a page has none).
    files.append((root / "site" / "wp-content" / "mu-plugins" / "ea-w2-og-default.php", "wp-content/mu-plugins/ea-w2-og-default.php"))
    # WP-06: one-time DB migration to scrub the seeded brand «סטודיו נשימה מעגלית».
    files.append((root / "site" / "wp-content" / "mu-plugins" / "ea-w2-06-brand-migration-once.php", "wp-content/mu-plugins/ea-w2-06-brand-migration-once.php"))
    files.append((root / "site" / "wp-content" / "mu-plugins" / "ea-w2-06b-blog-title-brand-once.php", "wp-content/mu-plugins/ea-w2-06b-blog-title-brand-once.php"))
    # WP-W2-17 T4 (D-2): sitemap hygiene — exclude redirect-source shells + test pages,
    # disable noise child-sitemaps (Yoast filters).
    files.append((root / "site" / "wp-content" / "mu-plugins" / "ea-w2-17-sitemap-exclusions.php", "wp-content/mu-plugins/ea-w2-17-sitemap-exclusions.php"))
    # WP-W2-17 T3 (D-1): one-time Yoast metadesc backfill for rollup routes with no value,
    # so Yoast is the single source of truth (pairs with the Yoast-first guard in
    # inc/wave2-w2-09.php's ea_w2_09_meta_description()).
    files.append((root / "site" / "wp-content" / "mu-plugins" / "ea-w2-17-metadesc-backfill-once.php", "wp-content/mu-plugins/ea-w2-17-metadesc-backfill-once.php"))

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
