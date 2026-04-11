#!/usr/bin/env python3
"""
Upload PHP 8.3 compatibility hotfix + MU-plugin to legacy production.

Source (sibling repo): ../eyalamit.co.il-legacy/hotfix-php83-core/
  - wp-includes/script-loader.php, class-wp-editor.php, formatting.php (PHP 8 magic_quotes)
  - mu-plugins/ea-legacy-php8-disable-plugins.php (disables LayerSlider etc. on PHP 8)

Credentials: local/.env.upress — EYAL_LEGACY_* (see docs/project/EYAL_ENV_VARS_REFERENCE.md §2.1).

Usage (from EyalAmit.co.il-2026 repo root):
  pip install -r scripts/requirements-upress.txt
  python3 scripts/ftp_legacy_deploy_hotfix.py --dry-run
  python3 scripts/ftp_legacy_deploy_hotfix.py
"""
from __future__ import annotations

import argparse
import sys
from pathlib import Path

from upress_ftp_env import (
    connect_ftp_legacy_production,
    ftp_cwd_to_wordpress_root,
    ftp_ensure_cwd,
    ftp_upload_file,
)


def _hotfix_base(root: Path) -> Path:
    return root.parent / "eyalamit.co.il-legacy" / "hotfix-php83-core"


def _bridge_widgets(root: Path) -> Path:
    return (
        root.parent
        / "eyalamit.co.il-legacy"
        / "hotfix-php83-core"
        / "wp-content"
        / "themes"
        / "bridge"
        / "widgets"
    )


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument(
        "--dry-run",
        action="store_true",
        help="Print paths only; no FTP.",
    )
    args = ap.parse_args()

    root = Path(__file__).resolve().parents[1]
    base = _hotfix_base(root)
    inc = base / "wp-includes"
    files = [
        (inc / "script-loader.php", "wp-includes/script-loader.php"),
        (inc / "class-wp-editor.php", "wp-includes/class-wp-editor.php"),
        (inc / "formatting.php", "wp-includes/formatting.php"),
        (inc / "load.php", "wp-includes/load.php"),
        (
            inc / "rest-api" / "class-wp-rest-request.php",
            "wp-includes/rest-api/class-wp-rest-request.php",
        ),
        (
            base / "mu-plugins" / "ea-legacy-php8-disable-plugins.php",
            "wp-content/mu-plugins/ea-legacy-php8-disable-plugins.php",
        ),
        (
            base / "mu-plugins" / "ea-legacy-force-safe-theme.php",
            "wp-content/mu-plugins/ea-legacy-force-safe-theme.php",
        ),
    ]
    bw = _bridge_widgets(root)
    for name in ("relate_posts_widget.php", "latest_posts_menu.php"):
        files.append(
            (
                bw / name,
                f"wp-content/themes/bridge/widgets/{name}",
            )
        )
    toolset_forms = (
        base
        / "wp-content"
        / "plugins"
        / "types"
        / "vendor"
        / "toolset"
        / "toolset-common"
        / "lib"
        / "enlimbo.forms.class.php"
    )
    files.append(
        (
            toolset_forms,
            "wp-content/plugins/types/vendor/toolset/toolset-common/lib/enlimbo.forms.class.php",
        )
    )
    for local, _ in files:
        if not local.is_file():
            raise SystemExit(f"Missing hotfix file: {local}")

    if args.dry_run:
        print("Dry-run — would upload to legacy production (EYAL_LEGACY_* in .env.upress):")
        for local, remote in files:
            print(f"  {local} -> {remote}")
        return

    ftp, remote_rr = connect_ftp_legacy_production(timeout=120)
    try:
        for local, remote_rel in files:
            remote_rel = remote_rel.replace("\\", "/")
            parent = str(Path(remote_rel).parent.as_posix())
            name = Path(remote_rel).name
            ftp.cwd("/")
            ftp_cwd_to_wordpress_root(ftp, remote_rr)
            ftp_ensure_cwd(ftp, parent)
            ftp_upload_file(ftp, local, name)
            print(f"OK: {remote_rel}", flush=True)
        ftp.quit()
    except Exception:
        try:
            ftp.quit()
        except Exception:
            pass
        raise
    print("Done: legacy hotfix + MU-plugin uploaded.", flush=True)


if __name__ == "__main__":
    main()
