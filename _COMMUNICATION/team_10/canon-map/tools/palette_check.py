"""Temporary palette check: the approved text paragraph (T-04) on every palette tone, with measured contrast.

team_00, 2026-09-27: allow several canonical background tones from the palette, each with text that
meets accessibility for every role; whatever fails is forbidden. WCAG AA: 4.5:1 for eyebrow, body and
link (normal-size text), 3:1 for the heading (large text).

    python3 tools/palette_check.py ea-canon-map.html palette-check.html
"""
import copy, sys
from bs4 import BeautifulSoup
from proofnav import keep_nav

SRC, OUT = sys.argv[1], sys.argv[2]
NEED = {"eyebrow": 4.5, "heading": 3.0, "body": 4.5, "link": 4.5}
MARGIN = 1.10  # passes, but within 10% of the threshold: one small colour tweak away from failing (team_90)
ROLE_HE = {"eyebrow": "תווית", "heading": "כותרת", "body": "טקסט", "link": "קישור"}
SETS = {
    "light": ("כהה — כמו היום", {"eyebrow": "#B05F38", "heading": "#2f2013", "body": "#67482d", "link": "#9A4F2B"}),
    "light-strong": ("כהה, תווית וקישור בשוקולד (הצעה)", {"eyebrow": "#5C3A2E", "heading": "#2f2013", "body": "#67482d", "link": "#5C3A2E"}),
    "dark": ("בהיר — כמו היום ברקע הכהה", {"eyebrow": "#D08A5E", "heading": "#ffffff", "body": "#EBEBEA", "link": "#D08A5E"}),
    "white": ("לבן מלא (הצעה)", {"eyebrow": "#ffffff", "heading": "#ffffff", "body": "#ffffff", "link": "#ffffff"}),
}
# team_00 approved five tones; each has its own text set: link differs from body, heading suits the background.
FIVE = [  # (name, bg, {role: colour})
    ("ivory", "#fffffa", {"eyebrow": "#9A4F2B", "heading": "#2f2013", "body": "#67482d", "link": "#9A4F2B"}),
    ("sand", "#D8C7B5", {"eyebrow": "#7A3418", "heading": "#2f2013", "body": "#4a3220", "link": "#7A3418"}),
    ("olive", "#575838", {"eyebrow": "#F6D38A", "heading": "#FFE8C2", "body": "#ffffff", "link": "#F6D38A"}),
    ("terra", "#874321", {"eyebrow": "#F6D38A", "heading": "#FFE8C2", "body": "#ffffff", "link": "#F6D38A"}),
    ("dark", "#2A1A0C", {"eyebrow": "#D08A5E", "heading": "#FFE8C2", "body": "#EBEBEA", "link": "#D08A5E"}),
]
TONES = [  # (name, hex, source)
    ("ivory", "#fffffa", "Chapters"), ("ivory-2", "#efeae1", "Chapters"), ("sand", "#D8C7B5", "שניהם"),
    ("terra-lt", "#D08A5E", "Chapters"), ("terra", "#B5663D", "Chapters"), ("terracotta", "#A44E2B", "אייל"),
    ("brick", "#AB3A2B", "אייל"), ("terra-dk", "#9A4F2B", "Chapters"), ("earth", "#8A5A44", "אייל"),
    ("olive", "#6E6F4A", "אייל"), ("chocolate", "#5C3A2E", "אייל"), ("ink", "#2E2B28", "אייל"),
    ("dark", "#2A1A0C", "Chapters — הגוון הבהיר ביותר של הגרדיאנט הכהה"),
]


def rgb(h):
    h = h.lstrip("#")
    return tuple(int(h[i:i + 2], 16) for i in (0, 2, 4))


def lum(c):
    f = lambda v: (v / 255) / 12.92 if v / 255 <= 0.03928 else ((v / 255 + 0.055) / 1.055) ** 2.4
    return 0.2126 * f(c[0]) + 0.7152 * f(c[1]) + 0.0722 * f(c[2])


def ratio(a, b):
    la, lb = lum(rgb(a)), lum(rgb(b))
    return (max(la, lb) + 0.05) / (min(la, lb) + 0.05)


s = BeautifulSoup(open(SRC, encoding="utf-8").read(), "lxml")
base = None
for spec in s.find(id="T-04").select(".cm-full > .cm-spec.cm-appr"):
    sec = spec.find("section")
    if "sec--dark" not in sec.get("class", []):
        base = sec
        break
assert base is not None

# Elements that are not tone backgrounds but sit at the threshold today (team_90, measured live, 2026-09-28).
ELEMENTS = [("תווית על שמנת (היום)", "#B05F38", "#fffffa", 4.5), ("כפתור טרקוטה — לבן על #B05F38 (--terra-btn)", "#ffffff", "#B05F38", 4.5)]
elems = "".join(f"<li>{n}: {ratio(a, b):.2f}{' ⚠ גבולי' if ratio(a, b) < t * MARGIN else ''}</li>" for n, a, b, t in ELEMENTS)
five = []
for name, bg, S in FIVE:
    r = {k: ratio(S[k], bg) for k in NEED}
    assert all(r[k] >= NEED[k] * MARGIN for k in NEED), (name, r)
    assert S["link"].lower() != S["body"].lower(), name
    five.append(f'<li><b>{name}</b> <code>{bg}</code> — ' + " · ".join(f"{ROLE_HE[k]} {r[k]:.2f}" for k in NEED) + "</li>")

blocks, passed = [], 0
for name, hexv, src in TONES:
    results = {}
    for key, (label, S) in SETS.items():
        r = {role: ratio(S[role], hexv) for role in NEED}
        results[key] = (all(r[k] >= NEED[k] for k in r), r)
    ok = [k for k in SETS if results[k][0]]
    use = next((k for k in ("light", "dark", "light-strong", "white") if k in ok), None)
    show = use or max(SETS, key=lambda k: min(results[k][1][x] / NEED[x] for x in NEED))
    S = SETS[show][1]
    r = results[show][1]
    passed += bool(use)
    cells = " · ".join(f'{ROLE_HE[k]} {r[k]:.2f}{"" if r[k] >= NEED[k] * MARGIN else (" ⚠ גבולי" if r[k] >= NEED[k] else " ✗")}' for k in NEED)
    marginal = bool(use) and any(r[k] < NEED[k] * MARGIN for k in NEED)
    verdict = (f'<b class="pc-ok">מותר</b>{" <b class=pc-warn>— גבולי</b>" if marginal else ""} — טקסט: {SETS[use][0]}' if use
               else f'<b class="pc-no">אסור</b> — גם הסט הטוב ביותר ({SETS[show][0]}) נכשל')
    sec = copy.copy(base)
    sec["class"] = [c for c in sec.get("class", []) if c not in ("sec--alt", "sec--dark")] + ["pc-sec"]
    sec["style"] = (f"background:{hexv};--pc-eyebrow:{S['eyebrow']};--pc-heading:{S['heading']};"
                    f"--pc-body:{S['body']};--pc-link:{S['link']}")
    for g in sec.select(".cm-grid"):
        g.decompose()
    blocks.append(f'<div class="pc-label"><span class="pc-swatch" style="background:{hexv}"></span>'
                  f'<b>{name}</b> <code>{hexv}</code> <small>({src})</small> — {verdict}<br><small>{cells}</small></div>'
                  f'<div class="cm-spec{"" if use else " pc-forbidden"}">{sec}</div>')

keep_nav(s, "palette-check.html")
main = s.find("main")
main.clear()
intro = (f'<div class="cm-proof-head"><h1>בדיקת גוונים — זמני</h1><p>פסקת הטקסט המאושרת על כל גוון בשתי '
         f'המניפות (Chapters ואייל), עם יחס הניגודיות הנמדד לכל תפקיד טקסט. סף WCAG AA: 4.5 לתווית, טקסט וקישור; '
         f'3 לכותרת (טקסט גדול). «גבולי» = עובר בפחות מ-10% מעל הסף — כל שינוי קטן בצבע מחייב להריץ את הבדיקה מחדש. <b>מותרים: {passed} מתוך {len(TONES)}.</b></p>'
         f'<p><b>רכיבים גבוליים היום (לא רקע):</b></p><ul>{elems}</ul>'
         f'<p><b>חמשת הגוונים שנבחרו, כל אחד עם סט הטקסט שלו — כולם מעל הסף ב-10% לפחות:</b></p><ul>{"".join(five)}</ul></div>')
main.append(BeautifulSoup(intro + "".join(blocks), "lxml").body)
main.body.unwrap()
css = s.new_tag("style")
css.string = """
.cm-proof-head{font-family:Heebo,sans-serif;background:#1d140d;color:#f3ece2;padding:20px 24px}
.cm-proof-head h1{margin:0 0 6px;font-size:1.4rem;font-weight:500;color:#f3ece2}
.cm-proof-head p{margin:0;font-size:.9rem;opacity:.9;max-width:95ch}
.pc-label{font-family:Heebo,sans-serif;font-size:.9rem;color:#2f2013;padding:14px 24px 8px;background:#fff;border-top:1px solid #e6dccf}
.pc-label code{direction:ltr;unicode-bidi:isolate;font-size:.8rem}
.pc-swatch{display:inline-block;width:14px;height:14px;border-radius:3px;border:1px solid #0003;vertical-align:-2px;margin-inline-end:6px}
.pc-ok{color:#2d6b3f}.pc-no{color:#a3261b}.pc-warn{color:#b3700a}
.pc-sec .chap{color:var(--pc-eyebrow)!important}
.pc-sec .h2{color:var(--pc-heading)!important}
.pc-sec .intro-body p,.pc-sec .intro-body li{color:var(--pc-body)!important}
.pc-sec .intro-body a,.pc-sec .tlink{color:var(--pc-link)!important;border-bottom-color:currentColor!important}
.pc-forbidden{position:relative}
.pc-forbidden::after{content:"אסור";position:absolute;top:10px;inset-inline-end:10px;background:#a3261b;color:#fff;
  font:600 .8rem Heebo,sans-serif;padding:4px 10px;border-radius:3px}
"""
s.head.append(css)
open(OUT, "w", encoding="utf-8").write(str(s))
print(f"allowed {passed} of {len(TONES)}")
