#!/usr/bin/env python3
"""
Remove temporary legacy MU-plugins (extraction / PHP8 hacks).

Run ONLY after setting the site to PHP 7.4 (or 8.0) in uPress panel — see message in docs.

Deletes on legacy production (EYAL_LEGACY_*):
  - wp-content/mu-plugins/ea-legacy-php8-disable-plugins.php
  - wp-content/mu-plugins/ea-legacy-force-safe-theme.php

Usage (EyalAmit.co.il-2026 repo root):
  python3 scripts/ftp_legacy_remove_extraction_mode.py
  python3 scripts/ftp_legacy_remove_extraction_mode.py --dry-run
"""
from __future__ import annotations

import argparse
import sys
from pathlib import Path

from upress_ftp_env import connect_ftp_legacy_production, ftp_cwd_to_wordpress_root


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true")
    args = ap.parse_args()

    names = (
        "ea-legacy-php8-disable-plugins.php",
        "ea-legacy-force-safe-theme.php",
    )

    if args.dry_run:
        print("Would delete from wp-content/mu-plugins/:")
        for n in names:
            print(f"  {n}")
        return

    ftp, remote_rr = connect_ftp_legacy_production(timeout=90)
    try:
        ftp.cwd("/")
        ftp_cwd_to_wordpress_root(ftp, remote_rr)
        ftp.cwd("wp-content/mu-plugins")
        for n in names:
            try:
                ftp.delete(n)
                print(f"Deleted: {n}", flush=True)
            except Exception as e:
                print(f"SKIP {n}: {e}", file=sys.stderr, flush=True)
        ftp.quit()
    except Exception:
        try:
            ftp.quit()
        except Exception:
            pass
        raise
    print("Done: extraction MU-plugins removed. Site should use normal theme + plugins.", flush=True)


if __name__ == "__main__":
    main()
