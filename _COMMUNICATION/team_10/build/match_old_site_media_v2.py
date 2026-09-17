#!/usr/bin/env python3
"""Second-pass matcher: join against a FULL crawl of the live media library
(exact legacy_relative / media_details.file comparison) instead of per-file
fuzzy search. Nimrod flagged the 100/319 search-based match rate as too low;
verified: search only matches on title/caption/description text, not on the
original filename, so it silently misses attachments whose filename was
never mentioned in a text field (confirmed via direct slug lookup on
mukesh.jpg, found here but missed by the free-text search approach).
Requires /tmp/full_media_crawl.json — a full paginated crawl of
/wp-json/wp/v2/media, retried per-page until each page returns its expected
count (single-pass pagination on this live site is confirmed unreliable:
first attempt returned 914 of 1192 total, with erratic per-page counts)."""
import json
import re
from pathlib import Path

REPO = Path("/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026")
CATALOG = REPO / "hub" / "dist" / "files" / "team40" / "ea-legacy-curated" / "catalog.all.json"
CRAWL = Path("/tmp/full_media_crawl.json")
OUT = Path(__file__).parent / "old_site_metadata_matched.json"


def strip_html(s):
    return re.sub(r"<[^>]+>", "", s or "").strip()


def norm(s):
    return (s or "").strip().lower()


def main():
    catalog = json.loads(CATALOG.read_text(encoding="utf-8"))
    entries = catalog["entries"]
    crawl = json.loads(CRAWL.read_text(encoding="utf-8"))
    print(f"{len(entries)} local old-site catalog entries to match against {len(crawl)} live attachments")

    by_relpath = {}
    by_basename = {}
    for item in crawl:
        f = ((item.get("media_details") or {}).get("file") or "")
        if not f:
            continue
        rec = {
            "wp_id": item["id"],
            "title": strip_html((item.get("title") or {}).get("rendered", "")),
            "alt_text": item.get("alt_text", ""),
            "caption": strip_html((item.get("caption") or {}).get("rendered", "")),
            "description": strip_html((item.get("description") or {}).get("rendered", "")),
            "matched_file": f,
        }
        by_relpath[norm(f)] = rec
        base = norm(f.rsplit("/", 1)[-1])
        # keep first; a colliding basename across folders is rare and the
        # relpath match (checked first) already covers the precise case
        by_basename.setdefault(base, rec)

    matched = {}
    unmatched = []
    match_method = {"relpath": 0, "basename": 0}
    for i, e in enumerate(entries):
        key = e.get("public_id") or e.get("entry_id") or e.get("legacy_relative") or f"row-{i}"
        rel = e.get("legacy_relative", "")
        if not rel:
            unmatched.append(key)
            continue
        rec = by_relpath.get(norm(rel))
        method = "relpath"
        if not rec:
            rec = by_basename.get(norm(rel.rsplit("/", 1)[-1]))
            method = "basename"
        if rec:
            matched[key] = dict(rec, legacy_relative=rel)
            match_method[method] += 1
        else:
            unmatched.append(key)

    print(f"\nDONE. matched: {len(matched)} / {len(entries)}. unmatched: {len(unmatched)}")
    print(f"  by exact relative path: {match_method['relpath']}")
    print(f"  by basename fallback:   {match_method['basename']}")
    OUT.write_text(json.dumps({"matched": matched, "unmatched": unmatched}, ensure_ascii=False), encoding="utf-8")
    print(f"Wrote {OUT}")


if __name__ == "__main__":
    main()
