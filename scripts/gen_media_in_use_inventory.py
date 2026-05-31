#!/usr/bin/env python3
"""
WP-W2-09 (team_20) — Regenerate the in-use media inventory after W2-01..08 are live.

The 2026-05-26 inventory (in_use_count=7) is stale (predates W2-02 pages + W2-06 blog).
This crawls the LIVE new-site (home + all published pages/posts via REST), extracts every
referenced media URL (theme assets under /wp-content/themes/ + uploads under
/wp-content/uploads/), unions with the W2-06 localized blog media already present in
wp-content/uploads/, dedups, verifies each returns HTTP 200, and writes the regenerated
inventory to _COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-REGEN-2026-05-30.json.

AC-01: every in-use item -> 200 (the script exits non-zero if any in-use URL != 200).
"""
from __future__ import annotations

import datetime
import json
import re
import sys
import time
import urllib.request
from concurrent.futures import ThreadPoolExecutor
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
sys.path.insert(0, str(ROOT / "scripts"))
import wp_rest_client as wp  # noqa: E402

BASE = "http://eyalamit-co-il-2026.s887.upress.link"
OUT = ROOT / "_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-REGEN-2026-05-30.json"

UA = {"User-Agent": "ea-w209-media-inventory"}

# media URL patterns referenced in rendered HTML
MEDIA_RE = re.compile(
    r"https?://[^\s\"'<>()]+?/wp-content/(?:uploads|themes)/[^\s\"'<>()]+?"
    r"\.(?:jpe?g|png|gif|webp|svg|avif|ico|mp4|webm|woff2?|ttf|eot|css|js)",
    re.IGNORECASE,
)


def fetch(url: str) -> tuple[int, bytes]:
    # retry transient failures (staging host intermittently times out under load)
    for attempt in range(3):
        try:
            r = urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=25)
            return r.status, r.read()
        except urllib.error.HTTPError as e:
            return e.code, b""
        except Exception:
            time.sleep(1 + attempt)
    return 0, b""


def head_code(url: str) -> int:
    for attempt in range(3):
        try:
            r = urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=25)
            return r.status
        except urllib.error.HTTPError as e:
            return e.code
        except Exception:
            time.sleep(1 + attempt)
    return 0


def list_rendered_urls() -> list[str]:
    urls = [BASE + "/"]
    for kind in ("pages", "posts"):
        page = 1
        while True:
            st, data = wp._request_raw(
                "GET", f"/wp/v2/{kind}?per_page=100&page={page}&status=publish&_fields=link"
            )
            if st != 200 or not isinstance(data, list) or not data:
                break
            urls += [d["link"] for d in data if d.get("link")]
            if len(data) < 100:
                break
            page += 1
    # de-dup preserving order
    seen, out = set(), []
    for u in urls:
        if u not in seen:
            seen.add(u)
            out.append(u)
    return out


def normalize(u: str) -> str:
    # strip query/fragment + cache-busters; keep scheme+host+path
    u = u.split("#", 1)[0].split("?", 1)[0]
    return u


def main() -> int:
    rendered = list_rendered_urls()
    print(f"crawling {len(rendered)} live pages/posts...", file=sys.stderr)

    referenced: set[str] = set()

    def scan(u: str) -> set[str]:
        st, body = fetch(u)
        if st != 200:
            return set()
        return {normalize(m) for m in MEDIA_RE.findall(body.decode("utf-8", "replace"))}

    with ThreadPoolExecutor(max_workers=12) as ex:
        for s in ex.map(scan, rendered):
            referenced |= s

    # union with W2-06 localized blog media present in repo uploads/
    uploads_dir = ROOT / "site/wp-content/uploads"
    repo_uploads: list[str] = []
    if uploads_dir.is_dir():
        for f in uploads_dir.rglob("*"):
            if f.is_file() and f.suffix.lower() in (
                ".jpg", ".jpeg", ".png", ".gif", ".webp", ".svg", ".avif", ".ico",
                ".mp4", ".webm",
            ):
                rel = f.relative_to(uploads_dir).as_posix()
                repo_uploads.append(f"{BASE}/wp-content/uploads/{rel}")

    # in-use scope = media served from the NEW-SITE host only (theme + uploads). Absolute
    # references to external/legacy hosts (blog.muzza.co.il, old www.eyalamit.co.il) are
    # NOT new-site in-use media — they are content-quality items reported separately.
    new_host = BASE.split("://", 1)[1]
    in_use = {u for u in (referenced | set(repo_uploads)) if new_host in u}
    external = sorted((referenced | set(repo_uploads)) - in_use)
    all_media = sorted(in_use)

    with ThreadPoolExecutor(max_workers=12) as ex:
        codes = list(ex.map(head_code, all_media))

    items = []
    not_200 = []
    for url, code in zip(all_media, codes):
        in_uploads = "/wp-content/uploads/" in url
        items.append(
            {
                "url": url,
                "kind": "uploads" if in_uploads else "theme",
                "http_status": code,
                "status": "in_use",
            }
        )
        if code != 200:
            not_200.append((url, code))

    inv = {
        "generated": datetime.datetime.now().isoformat(timespec="seconds"),
        "generated_by": "scripts/gen_media_in_use_inventory.py (W2-09 regen)",
        "base": BASE,
        "method": "crawl live pages/posts (REST link list) ∪ W2-06 repo uploads; keep in-use only",
        "crawled_pages": len(rendered),
        "in_use_count": len(items),
        "referenced_from_html": len(referenced),
        "repo_uploads_union": len(set(repo_uploads)),
        "all_200": len(not_200) == 0,
        "non_200": [{"url": u, "http_status": c} for u, c in not_200],
        "external_references_count": len(external),
        "external_references": external,
        "items": items,
    }
    OUT.write_text(json.dumps(inv, ensure_ascii=False, indent=2), encoding="utf-8")
    print(f"WROTE {OUT.relative_to(ROOT)}", file=sys.stderr)
    print(f"  in_use_count={len(items)}  all_200={inv['all_200']}", file=sys.stderr)
    for u, c in not_200:
        print(f"  NON-200 {c}: {u}", file=sys.stderr)
    return 0 if not not_200 else 2


if __name__ == "__main__":
    raise SystemExit(main())
