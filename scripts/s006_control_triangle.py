#!/usr/bin/env python3
"""s006_control_triangle.py — the gate before Eyal ever sees the form.

team_00 rule: Eyal receives the HTML form only after full control of exact
consistency between three things — the live site, the form, and the tracker.
Two of the three agreeing proves nothing: the form is generated FROM the tracker,
so they can agree perfectly while both describe a site that does not exist.

Checks, all as positive assertions (§5.1 — a harness that finds nothing must not
be read as a harness that found nothing wrong):

  A  tracker → form   every item waiting on Eyal is offered to him
  B  form → tracker   nothing is asked of him that the tracker does not carry
  C  tracker → live   every page the tracker calls submitted answers 200
  D  tracker → live   each page's own QA claim still holds in the served HTML
  E  live → theme     no page is still being served a stale theme asset

Usage:  python3 scripts/s006_control_triangle.py [--form hub/dist/s006-review.html]
Exit:   0 all pass · 1 any mismatch (nothing is sent to Eyal)
"""
from __future__ import annotations

import argparse
import csv
import json
import os
import re
import subprocess
import sys
from pathlib import Path

REPO = Path(__file__).resolve().parent.parent
SNAP = REPO / '_COMMUNICATION/team_100/S006/tracker'
BASE = 'http://eyalamit-co-il-2026.s887.upress.link'

# Each page that claims to be submitted must still prove itself in the served
# HTML. The marker is the thing Eyal actually asked for, not a generic string.
LIVE_MARKERS = {
    'R1-10': ('phero__lede', 'שלוש הפסקאות בהירו'),
    'R1-22': ('youtube-nocookie', 'נגן הסרט'),
    'R1-23': ('ea-cf-topic', 'שדה «נושא הפנייה» — חייב להיעדר'),
    'R1-25': ('ea-faq-toc.js', 'סקריפט תפריט הנושאים'),
    'R1-28': ('gallery--doc', 'תצוגת מסמך מוגדלת'),
}
ABSENT = {'R1-23'}          # markers that must NOT appear


def rows(name):
    with (SNAP / name).open(encoding='utf-8-sig') as fh:
        return list(csv.DictReader(fh))


def fetch(path):
    r = subprocess.run(['curl', '-sk', '--max-time', '25', f'{BASE}{path}'],
                       capture_output=True, text=True)
    c = subprocess.run(['curl', '-sk', '-o', '/dev/null', '-w', '%{http_code}',
                        '--max-time', '20', f'{BASE}{path}'],
                       capture_output=True, text=True)
    return c.stdout.strip(), r.stdout


SEMVER = re.compile(r'ea-eyalamit/[^"\']*?([\w.-]+\.(?:css|js))\?ver=(\d+\.\d+\.\d+)')


def theme_version() -> str:
    css = (REPO / 'site/wp-content/themes/ea-eyalamit/style.css').read_text(
        encoding='utf-8', errors='ignore')
    m = re.search(r'^Version:\s*(\S+)', css, re.M)
    return m.group(1) if m else ''


def stale_assets(body: str, want: str) -> list[str]:
    """Theme assets served at a version older than the one we just shipped.

    Only SEMANTIC versions are judged. style.css is also enqueued a second time
    with a cache-busting timestamp (?ver=1788866882) from outside the theme —
    GeneratePress or a plugin, not functions.php, which enqueues it once at
    :120. That second copy is a permanent feature of the site, present back when
    it was on 1.5.20, so requiring «every version string equals X» would fail on
    it forever and teach us to ignore the check. team_110 raised this before the
    first run rather than after.
    """
    return sorted({f'{f}?ver={v}' for f, v in SEMVER.findall(body) if v != want})


def main() -> int:
    ap = argparse.ArgumentParser()
    ap.add_argument('--form', default='hub/dist/s006-review.html')
    args = ap.parse_args()

    html = (REPO / args.form).read_text(encoding='utf-8')
    m = re.search(r'window\.S006_CONFIG\s*=\s*(\{.*?\});', html, re.S)
    if not m:
        print('לא נמצא S006_CONFIG בטופס', file=sys.stderr)
        return 2
    cfg = json.loads(m.group(1))
    form_items = {i['id'] for i in cfg.get('items', [])}
    # A config entry with no path is a form section, not a page — «הערות כלליות»
    # is free text Eyal may add, and there is nothing live to fetch for it.
    form_pages = {p['key'] for p in cfg.get('pages', []) if (p.get('path') or '').strip()}
    form_sections = {p['key'] for p in cfg.get('pages', []) if not (p.get('path') or '').strip()}

    tr = {r['#']: r for r in rows('latest.csv')}
    items = rows('latest-items.csv')
    waiting = {f"{i['__page__']}/{i['#']}" for i in items
               if (i.get('סטטוס סעיף') or '').strip() == 'ממתין לאייל'
               and i['__page__'].startswith('R1-')}

    fails, lines = [], []

    missing = waiting - form_items
    lines.append(f"A  טרקר→טופס   {len(waiting)-len(missing)}/{len(waiting)} סעיפים ממתינים מוצגים")
    if missing:
        fails.append(f'A: סעיפים שממתינים לאייל ואינם בטופס — {sorted(missing)}')

    extra = form_items - waiting
    lines.append(f"B  טופס→טרקר   {len(form_items)-len(extra)}/{len(form_items)} סעיפים בטופס מגובים בטרקר")
    if extra:
        fails.append(f'B: סעיפים בטופס שאינם «ממתין לאייל» בטרקר — {sorted(extra)}')

    want_ver = theme_version()
    ok_live = fresh = 0
    for key in sorted(form_pages):
        row = tr.get(key)
        if not row:
            fails.append(f'C: {key} בטופס ואינו בטרקר')
            continue
        code, body = fetch(row['נתיב'])
        if code != '200':
            fails.append(f'C: {key} {row["נתיב"]} → HTTP {code}')
            continue
        ok_live += 1
        stale = stale_assets(body, want_ver)
        if stale:
            fails.append(f'E: {key} מוגש עם נכס ישן — {stale}')
        else:
            fresh += 1
        marker = LIVE_MARKERS.get(key)
        if marker:
            tok, what = marker
            present = tok in body
            want = key not in ABSENT
            if present != want:
                fails.append(
                    f'D: {key} — {what}: {"נמצא ואסור" if present else "לא נמצא"} ({tok})')
    lines.append(f"C  טרקר→חי     {ok_live}/{len(form_pages)} עמודי הטופס מחזירים 200"
                 + (f"  (+{len(form_sections)} סקשן טקסט חופשי, ללא נתיב)" if form_sections else ""))
    checked = [k for k in form_pages if k in LIVE_MARKERS]
    lines.append(f"D  ראיית QA    {len(checked)} עמודים נבדקו מול הסימן שאייל ביקש")

    lines.append(f"E  טריות נכסים {fresh}/{len(form_pages)} עמודים — כל נכס בגרסה סמנטית הוא {want_ver}")

    print('\n'.join('  ' + l for l in lines))
    if fails:
        print('\n  ✗ אי-התאמות:', file=sys.stderr)
        for f in fails:
            print(f'    · {f}', file=sys.stderr)
        print('\n  הטופס לא עובר לאייל.', file=sys.stderr)
        return 1
    print('\n  ✓ שלושת המקורות תואמים. הטופס כשיר להעברה.')
    return 0


if __name__ == '__main__':
    raise SystemExit(main())
