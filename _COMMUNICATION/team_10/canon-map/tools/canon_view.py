"""The canon map (team_00, 2026-09-27: «ננעל את השלב הזה, נעדכן את המפה חזרה יפה למצב המקורי, לפי הסוגים העדכניים,
בלי סימוני הגריד, ונעשה דף הצעות פתוחות עדכני של כל מה שלא סגור»).

Reads map-source.html (every capture, built by tools/build.py) and writes the clean map: the current types after the
merge, one row each, grouped in tabs; per type its variants, fields, rules and uses; examples = what is approved, then
today's site for every old type it absorbed (the feasibility proof). No proposals here — they live in open.html.

    python3 tools/canon_view.py map-source.html ea-canon-map.html
"""
import json, os, re, sys
from bs4 import BeautifulSoup

SRC, OUT = sys.argv[1], sys.argv[2]
HERE = os.path.dirname(os.path.abspath(__file__))
USES = json.load(open(os.path.join(HERE, "uses.json"), encoding="utf-8"))
DEFS = {int(k): v for k, v in json.load(open(os.path.join(HERE, "type-defs.json"), encoding="utf-8")).items()}

from canon_types import GROUPS, SITE_RULES, A, P, O, buttons_html
EXTRA = {"S-2": buttons_html}
STATUS_CLS = {A: "st-a", P: "st-p", O: "st-o"}

s = BeautifulSoup(open(SRC, encoding="utf-8").read(), "lxml")
rows_src = {r["id"]: r for r in s.select(".cm-row")}
oldname = lambda t: next(rows_src[t].select_one(".c-name").stripped_strings)
approved = lambda t: rows_src[t].select(".cm-full > .cm-spec.cm-appr")
today = lambda t: rows_src[t].select(".cm-full > .cm-spec:not(.cm-appr):not(.cm-prop)")
label = lambda sp: (sp.find_previous_sibling(class_="cm-variant").get_text() if sp.find_previous_sibling(class_="cm-variant") else "")


def mini(sp):
    m = BeautifulSoup(str(sp), "lxml").div
    for b in m.select(".cm-dummy__badge"):
        b.decompose()
    return "".join(str(c) for c in m.children)


tabs, panels, total = [], [], 0
for gi, (gname, types) in enumerate(GROUPS, 1):
    tabs.append(f'<button type="button" class="cm-tab" data-g="g{gi}">{gname}</button>')
    rows = []
    for tid, name, olds, status, definition, variants, fields, rules in types:
        total += 1
        used = sorted({u for o, _ in olds for u in USES.get(o, [])})
        n = len(used)
        count = f"{n} עמודים" if n > 1 else ("עמוד אחד" if n == 1 else "כרגע לא בשימוש")
        if tid == "S-2":  # every button on the site; no old id to census
            count = "כמעט כל עמוד"
        link = lambda p: f'<a href="{p}" target="_blank">{p}</a>'
        uses_html = ('<ul class="cm-uses">' + "".join(f"<li>{link(p)}</li>" for p in used[:10]) + "</ul>"
                     + (f'<details class="cm-more"><summary>ועוד {n - 10}</summary><ul class="cm-uses">'
                        + "".join(f"<li>{link(p)}</li>" for p in used[10:]) + "</ul></details>" if n > 10 else "")) if n else ""
        if tid == "S-2":
            uses_html = "<p>כל כפתור באתר — כמעט בכל עמוד. אין מזהה ישן לספור אותו לפיו.</p>"
        own = (approved(olds[0][0]) or today(olds[0][0])) if olds else []
        ex, first = [], (own[0] if own else None)
        if tid in EXTRA:
            ex.append(EXTRA[tid]())
            first = first or BeautifulSoup(EXTRA[tid](), "lxml").select_one(".cm-spec")
        for o, becomes in olds:
            for sp in approved(o):
                first = first or sp
                ex.append(f'<div class="cm-variant cm-v-a">מאושר — {label(sp).replace("מאושר — ", "")}</div>{sp}')
        for o, becomes in olds:
            t = today(o)
            if not t:
                continue
            first = first or t[0]
            was = f"{o} «{oldname(o)}»" + (f" → {becomes}" if becomes else "") if o != tid or becomes else ""
            ex.append(f'<div class="cm-variant">היום באתר{" — " + was if was else ""}</div>{t[0]}')
        absorbed = [o for o, _ in olds if o != tid]
        merged = (f'<p class="cm-muted">מאחד את: {" · ".join(f"{o} «{oldname(o)}»" for o, _ in olds)}</p>' if absorbed else "")
        var_html = "".join(f"<dt>{a}</dt><dd>{b}</dd>" for a, b in variants) or "<dt>—</dt><dd>אין וריאנטים</dd>"
        rows.append(
            f'<details class="cm-row" id="{tid}"><summary class="cm-sum" role="row">'
            f'<span class="c-id">{tid}</span><span class="c-name">{name}<small class="cm-st {STATUS_CLS[status]}">{status}</small></span>'
            f'<span class="c-desc">{definition}</span><span class="c-use">{count}</span>'
            f'<span class="c-thumb"><span class="cm-mini"><span class="cm-mini__in">{mini(first) if first else ""}</span></span></span>'
            f'</summary><div class="cm-full"><div class="cm-type"><p class="cm-def">{definition}</p>{merged}'
            f'<div class="cm-cols"><section><h3>וריאנטים</h3><dl class="cm-props">{var_html}</dl>'
            f'<h3>כללים</h3><ul class="cm-rules">{"".join(f"<li>{r}</li>" for r in rules)}</ul></section>'
            f'<section><h3>שדות</h3><p>{fields}</p><h3>שימושים באתר — {count}</h3>{uses_html}</section></div></div>'
            + "".join(ex) + "</div></details>")
    panels.append(f'<section class="cm-panel" id="g{gi}"><div class="cm-group"><span>קבוצה {gi} מתוך {len(GROUPS)}</span><h2>{gname}</h2></div>'
                  f'<div class="cm-table" role="table"><div class="cm-thead" role="row"><span>מזהה</span><span>שם</span><span>תיאור</span>'
                  f'<span>שימושים באתר</span><span>תצוגה</span></div>{"".join(rows)}</div></section>')

top = s.select_one("header.cm-top")
top.clear()
top.append(BeautifulSoup(
    '<h1>מפת הקאנון — טיפוסי התוכן</h1>'
    f'<p>{total} טיפוסים, תבניות ומצבים, אחרי האיחוד. שורה לכל אחד; לחיצה פותחת וריאנטים, כללים, שדות, שימושים ודוגמאות. '
    'דוגמה כחולה — מאושרת; «היום באתר» — הוכחת ההיתכנות מהעמוד החי. הצעות שעוד לא נסגרו — בעמוד «הצעות פתוחות». בכל הדוגמאות הרקע יושר לגוון הקאנוני הקרוב ו«ממתין לתוכן» מוצג במראה האחיד — במפה בלבד, לא באתר.</p>'
    '<p class="cm-rules-top">' + " · ".join(f"<b>{a}:</b> {b}" for a, b in SITE_RULES) + "</p>", "lxml").body)
top.body.unwrap()
nav = s.select_one("nav.cm-tabs")
pgs = nav.select_one(".cm-pgs")
for t in nav.select(".cm-tab"):
    t.decompose()
for t in reversed(tabs):
    nav.insert(0, BeautifulSoup(t, "lxml").button)
main = s.find("main")
main.clear()
main.append(BeautifulSoup("".join(panels), "lxml").body)
main.body.unwrap()
css = s.new_tag("style")
css.string = """
.cm-st{display:inline-block;margin-inline-start:8px;font:600 .7rem/1 Heebo,sans-serif;padding:3px 7px;border-radius:3px;vertical-align:2px}
.st-a{background:#2d5f8a;color:#fff}.st-p{background:#dbe7f1;color:#2d5f8a}.st-o{background:#efe3c9;color:#7a5418}
.cm-v-a{background:#2d5f8a!important;color:#fff!important}
.cm-rules{margin:0;padding-inline-start:18px}
.cm-rules-top{font-size:.85rem;opacity:.85;line-height:1.7;max-width:150ch}
.cm-rules-top b{color:#f3ece2}
.c-desc{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
"""
s.head.append(css)
html = str(s)
open(OUT, "w", encoding="utf-8").write(html)
print("rows:", total, "groups:", len(GROUPS), "host occurrences:", html.count("s887.upress.link"))
