#!/usr/bin/env python3
"""בדיקה: דף POC st-book-kushi משקף את המסמך המאושר (לא את דמו tpl-secondary הישן).

מקור אמת: docs/.../2026-04-06--st-book-kushi--content--from-eyal.md
דף POC: hub/src/mockups/poc/poc-kushi-blantis-st-book-kushi-2026-04-06.html

Usage (שורש הריפו):
    python3 scripts/verify_kushi_intake_poc_parity.py
"""

from __future__ import annotations

import sys
from pathlib import Path

REPO = Path(__file__).resolve().parent.parent
HTML_PATH = REPO / "hub/src/mockups/poc/poc-kushi-blantis-st-book-kushi-2026-04-06.html"

# מחרוזות חובה מהמסמך המאושר (לא מהדמו הסינתטי)
MUST_HAVE = [
    'data-site-layer="meta"',
    'data-hub-non-content="true"',
    "hub-meta-stack",
    "tpl-book-detail",
    "<h1>כושי בלאנטיס</h1>",
    "רומן פנטזיה מאת אייל עמית על התעוררות",
    "ספר התעוררות עם עלילה סיפורית חזקה",
    "לרכישת הספר המודפס",
    "https://mrng.to/MTUiO3vkIg",
    "לרכישת הספר האלקטרוני",
    "https://www.mendele.co.il/product/kushibelantis/",
    "קטע לקריאה מתוך הספר",
    "מתוך העולם של כושי בלאנטיס",
    "2026-04-06--st-book-kushi--content--from-eyal.md",
    "./st-book-kushi-wp-media/cover/kushi-blantis-cover-full.jpg",
    "./st-book-kushi-wp-media/gallery/01-kushi-blantis-1.jpg",
]

MUST_NOT_HAVE = [
    "הרפתקאה צבעונית לילדים",
    "ספר ילדים בעברית רהוטה",
]


def main() -> int:
    html = HTML_PATH.read_text(encoding="utf-8")
    for s in MUST_HAVE:
        if s not in html:
            print(f"[FAIL] חסר ב־HTML (מאושר): {s[:72]!r}…", file=sys.stderr)
            return 1
    for s in MUST_NOT_HAVE:
        if s in html:
            print(f"[FAIL] נמצא שארית דמו ישן (לא לאשר): {s!r}", file=sys.stderr)
            return 1
    print("[OK] st-book-kushi POC ↔ מסמך מאושר (כותרת, גוף, שני קישורי רכישה, גלריה).")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
