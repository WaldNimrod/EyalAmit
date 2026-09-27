"""Open proposals (team_00, 2026-09-27: «דף הצעות פתוחות עדכני של כל מה שלא סגור»): every proposal still waiting for a
ruling, numbered O-n, grouped by the current type, plus the open decisions that have no picture. Whatever is approved
leaves this page and shows in the map instead.

    python3 tools/open_view.py map-source.html open.html
"""
import sys
from bs4 import BeautifulSoup
from proofnav import keep_nav
from canon_types import GROUPS_LITE

SRC, OUT = sys.argv[1], sys.argv[2]

DECISIONS = [
    ("החלטה", "תוכן עניינים — כלל לפי אורך העמוד",
     "מ-2,000 מילים ו-8 כותרות משנה — תמיד (שאלות נפוצות, מוקש, שלושת עמודי הספרים, העמוד באנגלית, טיפול, ודום נשימה שכבר יש בו); "
     "1,400–2,000 מילים ו-9 כותרות — המלצה (השיטה, סדנאות, שיעורים, סאונד הילינג); מתחת ל-1,400 — בלי."),
    ("החלטה", "יצירת קשר — ההירו", "העמוד אושר (O-17). הקטע לבדו נכנס במסך; עם ההירו הקטן העמוד כ-1,000 פיקסלים — להקטין את ההירו, לוותר עליו, או להשאיר."),
    ("סבב הבא", "אקורדיון (שאלות נפוצות, מונחים)", "הטורים אושרו (2–5); העיצוב — בסבב הבא, אחרי שנסגור את השאר."),
    ("שלב הבא", "תמונה צפה", "גודל אחד — שני טורים (אושר כעיקרון, מחוץ לשלב הזה)."),
    ("טרם שורטט", "פס תמונה וציטוט על תמונה; אודות עם תצרף; סטודיו", "הטקסט על התמונה על הרשת; התצרף לפי חלוקה של שלושה (K-3.2)."),
]

s = BeautifulSoup(open(SRC, encoding="utf-8").read(), "lxml")
rows = {r["id"]: r for r in s.select(".cm-row")}
oldname = lambda t: next(rows[t].select_one(".c-name").stripped_strings)
label = lambda sp: sp.find_previous_sibling(class_="cm-variant").get_text().replace("הצעה לאישור — ", "")

import json, os
IDS_PATH = os.path.join(os.path.dirname(os.path.abspath(__file__)), "open_ids.json")
IDS = json.load(open(IDS_PATH, encoding="utf-8"))


def oid(o, sp):
    top = [c for c in sp.children if getattr(c, "name", None) and "cm-dummy__badge" not in (c.get("class") or [])][0]
    key = o + "|" + " ".join(c for c in top.get("class", []) if c.startswith("cm-"))
    if key not in IDS:
        IDS[key] = IDS["_next"]
        IDS["_next"] += 1
    return IDS[key]


blocks, n = [], 0
dec = "".join(f'<li><b>{k}</b> <b>{t}</b> — {d}</li>' for k, t, d in DECISIONS)
for tid, name, olds in GROUPS_LITE:
    props = [(o, sp) for o in olds if o in rows for sp in rows[o].select(".cm-full > .cm-spec.cm-prop")]
    if not props:
        continue
    blocks.append(f'<div class="cm-group" id="{tid}"><span>{tid}</span><h2>{name}</h2></div>')
    for o, sp in props:
        n += 1
        k = oid(o, sp)
        was = f" · היה {o} «{oldname(o)}»" if o != tid else ""
        blocks.append(f'<div class="av-ex" id="O-{k}"><b>O-{k}</b> {label(sp)}{was}</div>{sp}')


def rgb(h):
    h = h.lstrip("#")
    return tuple(int(h[i:i + 2], 16) for i in (0, 2, 4))


def ratio(a, b):
    f = lambda v: (v / 255) / 12.92 if v / 255 <= 0.03928 else ((v / 255 + 0.055) / 1.055) ** 2.4
    lum = lambda c: 0.2126 * f(c[0]) + 0.7152 * f(c[1]) + 0.0722 * f(c[2])
    la, lb = lum(rgb(a)), lum(rgb(b))
    return (max(la, lb) + 0.05) / (min(la, lb) + 0.05)


head = ('<div class="cm-proof-head"><h1>הצעות פתוחות</h1>'
        f'<p>כל מה שעוד לא נסגר — {n} הצעות עם תמונה. המזהה O-n של הצעה קבוע ולא משתנה; מה שמאושר עובר למפה ויוצא מכאן, והמספר שלו לא חוזר.</p>'
        f'<h2>החלטות בלי תמונה</h2><ul class="av-rules">{dec}</ul></div>')
keep_nav(s, "open.html")
main = s.find("main")
main.clear()
main.append(BeautifulSoup(head + "".join(blocks), "lxml").body)
main.body.unwrap()
css = s.new_tag("style")
css.string = """
.cm-proof-head{font-family:Heebo,sans-serif;background:#1d140d;color:#f3ece2;padding:20px 24px}
.cm-proof-head h1{margin:0 0 6px;font-size:1.4rem;font-weight:500;color:#f3ece2}
.cm-proof-head p{margin:0 0 6px;font-size:.9rem;opacity:.9;max-width:110ch}
.cm-proof-head h2{margin:14px 0 6px;font-size:1.05rem;font-weight:600;color:#f3ece2}
.av-rules{margin:0;padding-inline-start:18px;font-size:.9rem;line-height:1.7;max-width:130ch}
.cm-group span{letter-spacing:0!important}
.av-ex{font-family:Heebo,sans-serif;background:#3f7a52;color:#fff;padding:9px 24px;font-size:.95rem;margin-top:18px}
.av-ex b{background:#fff;color:#3f7a52;padding:1px 8px;border-radius:3px;margin-inline-end:8px;font-family:ui-monospace,Menlo,monospace;direction:ltr;unicode-bidi:isolate}
.cm-prop .btn{padding:var(--cm-btn-pad-block) var(--cm-btn-pad-inline)!important;box-shadow:none}
"""
s.head.append(css)
open(OUT, "w", encoding="utf-8").write(str(s))
json.dump(IDS, open(IDS_PATH, "w", encoding="utf-8"), ensure_ascii=False, indent=2)
print("open proposals:", n)
