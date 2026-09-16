#!/usr/bin/env python3
"""Per-file search match against the old site's media API — NOT bulk pagination.
Bulk offset/page pagination on this API was confirmed unreliable (same request
repeated gives different counts; the collection is actively changing under a
live production site, and default sort isn't stable across requests even with
orderby=id&order=asc). A targeted search-by-filename for each of our 315 known
local files is slower but deterministic per-lookup."""
import json
import re
import time
import urllib.parse
import urllib.request
from pathlib import Path

REPO = Path("/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026")
CATALOG = REPO / "hub" / "dist" / "files" / "team40" / "ea-legacy-curated" / "catalog.all.json"
OUT = Path(__file__).parent / "old_site_metadata_matched.json"
BASE = "https://www.eyalamit.co.il/wp-json/wp/v2/media"


def strip_html(s):
    return re.sub(r"<[^>]+>", "", s or "").strip()


def search_term_from_relative(rel: str) -> str:
    name = rel.rsplit("/", 1)[-1]
    name = re.sub(r"\.[A-Za-z0-9]+$", "", name)
    name = re.sub(r"[-_]?\d+x\d+$", "", name)  # strip trailing -300x200 size suffix
    return name[:60]


def fetch(url, retries=2):
    for attempt in range(retries + 1):
        try:
            req = urllib.request.Request(url, headers={"User-Agent": "EA-S006-M09-metadata/1.0"})
            with urllib.request.urlopen(req, timeout=15) as resp:
                return json.loads(resp.read().decode("utf-8"))
        except Exception as e:
            if attempt == retries:
                return None
            time.sleep(1)


def main():
    catalog = json.loads(CATALOG.read_text(encoding="utf-8"))
    entries = catalog["entries"]
    print(f"{len(entries)} local old-site catalog entries to match")

    matched = {}
    unmatched = []
    for i, e in enumerate(entries):
        key = e.get("public_id") or e.get("entry_id") or e.get("legacy_relative") or f"row-{i}"
        rel = e.get("legacy_relative", "")
        if not rel:
            unmatched.append(key)
            continue
        term = search_term_from_relative(rel)
        url = f"{BASE}?search={urllib.parse.quote(term)}&per_page=20"
        results = fetch(url)
        if not results:
            unmatched.append(key)
            time.sleep(0.15)
            continue
        # match on the tail of media_details.file against our relative path's filename
        rel_name = rel.rsplit("/", 1)[-1].lower()
        hit = None
        for r in results:
            f = ((r.get("media_details") or {}).get("file") or "").lower()
            if f.rsplit("/", 1)[-1] == rel_name or rel.lower() in f:
                hit = r
                break
        if hit:
            matched[key] = {
                "wp_id": hit["id"],
                "title": strip_html((hit.get("title") or {}).get("rendered", "")),
                "alt_text": hit.get("alt_text", ""),
                "caption": strip_html((hit.get("caption") or {}).get("rendered", "")),
                "description": strip_html((hit.get("description") or {}).get("rendered", "")),
                "matched_file": (hit.get("media_details") or {}).get("file", ""),
                "legacy_relative": rel,
            }
        else:
            unmatched.append(key)
        if (i + 1) % 25 == 0:
            print(f"  {i+1}/{len(entries)} — matched so far: {len(matched)}")
        time.sleep(0.12)

    print(f"\nDONE. matched: {len(matched)} / {len(entries)}. unmatched: {len(unmatched)}")
    OUT.write_text(json.dumps({"matched": matched, "unmatched": unmatched}, ensure_ascii=False), encoding="utf-8")
    print(f"Wrote {OUT}")


if __name__ == "__main__":
    main()
