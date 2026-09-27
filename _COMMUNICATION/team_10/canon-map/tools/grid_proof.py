"""Temporary grid-proof page: the elements reviewed so far, with the six-column grid drawn over them.

team_00, 2026-09-27: every sketch must show the six-column grid, to prove the design sits on it.
Takes the approved / proposed examples straight from the built canon map (no second copy of the
markup) and draws the columns over each element's own grid container: the overlay spans grid lines 1 to -1,
so it covers exactly the columns the element itself uses.

    python3 tools/grid_proof.py ea-canon-map.html grid-proof.html
"""
import sys
from bs4 import BeautifulSoup
from proofnav import keep_nav

SRC, OUT = sys.argv[1], sys.argv[2]
PICK = [("T-01", "cm-appr", ".phero__in", "הירו"), ("T-08", "cm-appr", ".cta-band__in", "פס קריאה לפעולה"), ("T-04", "cm-appr", "section > .wrap", "פסקת טקסט"), ("T-04", "cm-prop", "section > .wrap", "פסקת טקסט — חמשת הגוונים (הצעה)")]

s = BeautifulSoup(open(SRC, encoding="utf-8").read(), "lxml")
blocks = []
for tid, kind, box, title in PICK:
    full = s.find(id=tid).select_one(".cm-full")
    blocks.append(f'<div class="cm-group"><span>{tid}</span><h2>{title}</h2></div>')
    for spec in full.select(f".cm-spec.{kind}"):
        label = spec.find_previous_sibling(class_="cm-variant")
        for c in spec.select(box):
            grid = s.new_tag("div", attrs={"class": "cm-grid", "aria-hidden": "true"})
            for n in range(1, 7):
                i = s.new_tag("i")
                i.string = str(n)
                grid.append(i)
            c.append(grid)
        blocks.append((str(label) if label else "") + str(spec))

keep_nav(s, "grid-proof.html")
main = s.find("main")
main.clear()
main.append(BeautifulSoup(
    '<div class="cm-proof-head"><h1>הוכחת רשת — זמני</h1>'
    '<p>ששת הטורים מצוירים על המיכל של כל רכיב, בתוך רוחב התוכן שלו. טור 1 הוא הימני. '
    'רק הרכיבים שעבדנו עליהם. הרשת מוצגת מרוחב 761 פיקסלים ומעלה — בטלפון הרכיבים בטור אחד.</p></div>'
    + "".join(blocks), "lxml").body)
main.body.unwrap() if main.body else None

css = s.new_tag("style")
css.string = """
.cm-proof-head{font-family:Heebo,sans-serif;background:#1d140d;color:#f3ece2;padding:20px 24px}
.cm-proof-head h1{margin:0 0 6px;font-size:1.4rem;font-weight:500;color:#f3ece2}
.cm-proof-head p{margin:0;font-size:.9rem;opacity:.85;max-width:90ch}
.phero__in,.cta-band__in{position:relative}
.cm-grid{position:absolute;inset:0;grid-column:1/-1!important;grid-row:auto!important;display:grid;grid-template-columns:repeat(6,minmax(0,1fr));
  column-gap:var(--cm-gap);direction:rtl;pointer-events:none;z-index:50}
/* A space-division ruler, not content cards (team_00): only the column edges are drawn. */
.cm-grid i{border-inline:1px solid rgba(230,30,110,.8);font:600 .75rem/1 Heebo,sans-serif;font-style:normal;
  color:#e61e6e;text-align:center;padding-top:4px;text-shadow:0 0 3px #fff}
@media(max-width:760px){.cm-grid{display:none}}
"""
s.head.append(css)
open(OUT, "w", encoding="utf-8").write(str(s))
print("blocks:", len(blocks))
