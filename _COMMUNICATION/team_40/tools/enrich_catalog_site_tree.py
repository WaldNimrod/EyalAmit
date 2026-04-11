#!/usr/bin/env python3
"""
מעדכן catalog.json קיים: מוסיף/מחדש site_tree_tags ומרנדר gallery.html — בלי הרצת CLIP מחדש.
"""
from __future__ import annotations

import argparse
import json
import sys
from datetime import datetime, timezone
from pathlib import Path

from site_tree_tags import (
    SiteTreeContext,
    default_site_tree_path,
    render_gallery_html,
    tags_for_entry,
)


def main() -> None:
    ap = argparse.ArgumentParser(description=__doc__)
    ap.add_argument(
        "--catalog-dir",
        type=Path,
        required=True,
        help="תיקייה עם catalog.json (ולרוב media/, gallery.html)",
    )
    ap.add_argument("--site-tree", type=Path, default=None, help="נתיב ל־site-tree.json")
    args = ap.parse_args()

    cat_dir = args.catalog_dir.resolve()
    cat_path = cat_dir / "catalog.json"
    if not cat_path.is_file():
        print(f"Missing {cat_path}", file=sys.stderr)
        sys.exit(1)

    data = json.loads(cat_path.read_text(encoding="utf-8"))
    entries = data.get("entries")
    if not isinstance(entries, list):
        print("Invalid catalog.json: no entries list", file=sys.stderr)
        sys.exit(1)

    st_path = (args.site_tree or default_site_tree_path()).resolve()
    if not st_path.is_file():
        print(f"WARN: site-tree not found at {st_path}", flush=True)
        st_ctx = None
    else:
        st_ctx = SiteTreeContext.load(st_path)

    for e in entries:
        e["site_tree_tags"] = tags_for_entry(e, st_ctx) if st_ctx else []

    meta = data.setdefault("meta", {})
    meta["version"] = max(int(meta.get("version", 0)), 5)
    meta["site_tree_json"] = str(st_path)
    meta["site_tree_enriched_utc"] = datetime.now(timezone.utc).isoformat()

    cat_path.write_text(json.dumps(data, ensure_ascii=False, indent=2), encoding="utf-8")
    print(f"Updated {cat_path}", flush=True)

    all_path = cat_dir / "catalog.all.json"
    if all_path.is_file():
        alldata = json.loads(all_path.read_text(encoding="utf-8"))
        all_entries = alldata.get("entries")
        if isinstance(all_entries, list):
            for e in all_entries:
                e["site_tree_tags"] = tags_for_entry(e, st_ctx) if st_ctx else []
            ameta = alldata.setdefault("meta", {})
            ameta["site_tree_json"] = str(st_path)
            ameta["site_tree_enriched_utc"] = meta["site_tree_enriched_utc"]
            all_path.write_text(
                json.dumps(alldata, ensure_ascii=False, indent=2), encoding="utf-8"
            )
            print(f"Updated {all_path}", flush=True)

    thr = float((meta.get("thresholds") or {}).get("relevance_min", 0.065))
    n = len(entries)
    html = render_gallery_html(entries, relevance_threshold=thr, included_count=n)
    gpath = cat_dir / "gallery.html"
    gpath.write_text(html, encoding="utf-8")
    print(f"Wrote {gpath}", flush=True)


if __name__ == "__main__":
    main()
