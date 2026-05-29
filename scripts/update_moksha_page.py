#!/usr/bin/env python3
"""
WP-W2-07 — Update the existing /about/moksha page (ID 181) content via REST.

Content source: docs/.../תוכן לאתר 25.5.26/מוקש דהימן/ומה היום.docx (extracted).
Adds: the migrated text + a rehosted image + a link back to /about.
Does NOT recreate the page. Uses wp_rest_client helpers for auth.

Usage (repo root):
  python3 scripts/update_moksha_page.py            # update page 181
  python3 scripts/update_moksha_page.py --dry-run  # print the HTML only
"""
from __future__ import annotations

import argparse
import re
import sys
import zipfile
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent))
from wp_rest_client import _request  # noqa: E402

ROOT = Path(__file__).resolve().parents[1]
DOCX = ROOT / "docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/מוקש דהימן/ומה היום.docx"
MOKSHA_PAGE_ID = 181
IMAGE_URL = "/wp-content/uploads/ea-legacy/moksha/mukesh-dhiman-7-1024x792.jpg"


def extract_paragraphs() -> list[str]:
    import html
    z = zipfile.ZipFile(DOCX)
    xml = z.read("word/document.xml").decode("utf-8")
    xml = re.sub(r"</w:p>", "\n", xml)
    xml = re.sub(r"<[^>]+>", "", xml)
    paras = [html.unescape(x).strip() for x in xml.split("\n") if x.strip()]
    # First two lines are the duplicated heading "ומה היום".
    dedup: list[str] = []
    for p in paras:
        if dedup and dedup[-1] == p:
            continue
        dedup.append(p)
    return dedup


def build_html() -> str:
    paras = extract_paragraphs()
    heading = paras[0] if paras else "ומה היום"
    body = paras[1:]
    parts = [
        '<div class="ea-moksha-today ea-service-prose">',
        f"<h2>{heading}</h2>",
        f'<figure class="ea-moksha-figure">'
        f'<img class="ea-qr-img" src="{IMAGE_URL}" '
        f'alt="מוקש דהימן — רישיקש, הודו" loading="lazy" />'
        f"</figure>",
    ]
    for p in body:
        parts.append(f"<p>{p}</p>")
    parts.append(
        '<p class="ea-moksha-back">'
        '<a class="ea-text-link" href="/about/">חזרה לעמוד אודות אייל עמית</a></p>'
    )
    parts.append("</div>")
    return "\n".join(parts)


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true")
    args = ap.parse_args()

    html_content = build_html()
    if args.dry_run:
        print(html_content)
        return

    # Confirm the target page is the moksha page before overwriting.
    page = _request("GET", f"/wp/v2/pages/{MOKSHA_PAGE_ID}?context=edit")
    slug = page.get("slug", "")
    print(f"Target page {MOKSHA_PAGE_ID}: slug={slug!r} title={page.get('title',{}).get('rendered','')!r}")
    if slug != "moksha":
        raise SystemExit(f"Refusing: page {MOKSHA_PAGE_ID} slug is {slug!r}, expected 'moksha'.")

    res = _request("POST", f"/wp/v2/pages/{MOKSHA_PAGE_ID}", {"content": html_content})
    link = res.get("link", "")
    print(f"✅ Updated moksha page {MOKSHA_PAGE_ID} → {link}")


if __name__ == "__main__":
    main()
