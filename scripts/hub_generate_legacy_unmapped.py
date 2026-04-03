#!/usr/bin/env python3
"""
Generate hub/data/legacy-unmapped.json from CONTENT-SSOT-INVENTORY.csv vs hub/data/site-tree.json.

A published legacy page is "mapped" if its canonical URL (https://www.eyalamit.co.il/<slug_hint>/) appears
as legacyUrl on any site-tree node. Slug hints are percent-encoded paths as stored in the CSV.

Usage (repo root):
  python3 scripts/hub_generate_legacy_unmapped.py
  python3 scripts/hub_generate_legacy_unmapped.py --dry-run

Re-run after enriching site-tree.json with more legacyUrl values.
"""
from __future__ import annotations

import argparse
import csv
import json
import re
import sys
from pathlib import Path

REPO = Path(__file__).resolve().parents[1]
CSV_PATH = REPO / "docs/project/team-100-preplanning/CONTENT-SSOT-INVENTORY.csv"
TREE_PATH = REPO / "hub/data/site-tree.json"
OUT_PATH = REPO / "hub/data/legacy-unmapped.json"

BASE = "https://www.eyalamit.co.il"


def norm_url(u: str) -> str:
    u = u.strip().rstrip("/")
    if u.endswith("/"):
        u = u[:-1]
    return u


def tree_legacy_urls(tree: dict) -> set[str]:
    out: set[str] = set()
    for n in tree.get("nodes", []):
        lu = n.get("legacyUrl")
        if isinstance(lu, str) and lu.strip():
            out.add(norm_url(lu.strip()))
    return out


def row_url(slug_hint: str) -> str:
    s = (slug_hint or "").strip().strip("/")
    if not s:
        return ""
    return norm_url(f"{BASE}/{s}")


def skip_slug(slug: str, title: str) -> bool:
    sl = slug.lower()
    if not sl:
        return True
    if sl in ("sample-page",):
        return True
    if re.match(r"^wp-", sl):
        return True
    return False


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true")
    args = ap.parse_args()

    if not CSV_PATH.is_file():
        print(f"Missing {CSV_PATH}", file=sys.stderr)
        sys.exit(1)
    if not TREE_PATH.is_file():
        print(f"Missing {TREE_PATH}", file=sys.stderr)
        sys.exit(1)

    tree = json.loads(TREE_PATH.read_text(encoding="utf-8"))
    mapped = tree_legacy_urls(tree)

    unmapped: list[dict] = []
    with CSV_PATH.open(encoding="utf-8-sig", newline="") as f:
        reader = csv.DictReader(f)
        for row in reader:
            if row.get("type") != "page":
                continue
            if (row.get("status_wp") or "").lower() != "publish":
                continue
            slug = (row.get("slug_hint") or "").strip()
            if skip_slug(slug, row.get("title_clean") or ""):
                continue
            url = row_url(slug)
            if not url:
                continue
            if norm_url(url) in mapped or url in mapped:
                continue
            unmapped.append(
                {
                    "wpId": row.get("id", ""),
                    "titleHe": row.get("title_clean", ""),
                    "legacyUrl": url + "/",
                }
            )

    payload = {
        "schemaVersion": 1,
        "generatedNoteHe": "נוצר ע״י scripts/hub_generate_legacy_unmapped.py — עמודי publish באתר הישן שלא נמצא legacyUrl תואם בעץ החדש.",
        "items": sorted(unmapped, key=lambda x: (x.get("titleHe") or "")),
    }

    if args.dry_run:
        print(json.dumps(payload, ensure_ascii=False, indent=2)[:4000])
        print(f"\n… total items: {len(unmapped)}", flush=True)
        return

    OUT_PATH.write_text(json.dumps(payload, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")
    print(f"OK: {OUT_PATH} ({len(unmapped)} items)", flush=True)


if __name__ == "__main__":
    main()
