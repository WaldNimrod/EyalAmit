"""Grid compositions (team_00, 2026-09-27): every allowed way to lay N items on the six columns, shown one by one so each
can be approved or struck, before every divided type inherits them.

team_00's definitions: 1 — full width. 2 — half/half, or 4+2 either way (1+5 is struck). 3 — three equal, or one tall
(two rows over two columns) beside two half-height items of four columns, the tall one on either side. 4 — two rows of
two; two small and two large; one large and three small (three thirds and one below is struck). 5 — one large and four
small, the large first or last (tried both as one row and as a tall one), or one tall beside a quartet of halves.
More than 5 — no template of its own (team_00: «לא צריך תבנית למעל 5. 6 זה 3+3 או 4+2 וכו׳»): rows built from the
layouts above. A list of more than 10, or of unknown length (blog, gallery, testimonials), is exempt: pick a
per-row count that fits the grid (1, 2, 3 or 6) and leave the remainder as it falls (team_00).

    python3 tools/grids_view.py ea-canon-map.html grids.html
"""
import sys
from bs4 import BeautifulSoup
from proofnav import keep_nav

SRC, OUT = sys.argv[1], sys.argv[2]

# Each layout: (id, label, [(col_span, row_span), ...]). Row height is one unit; a tall item spans two.
L = lambda *a: list(a)
LAYOUTS = [
    ("1 פריט", [("K-1.1", "רוחב מלא", L((6, 1)))]),
    ("2 פריטים", [("K-2.1", "חצי וחצי — 3+3", L((3, 1), (3, 1))),
                  ("K-2.2", "4+2 — הגדול מימין", L((4, 1), (2, 1))),
                  ("K-2.3", "2+4 — הגדול משמאל", L((2, 1), (4, 1)))]),
    ("3 פריטים", [("K-3.1", "שלושה שווים — 2+2+2", L((2, 1), (2, 1), (2, 1))),
                  ("K-3.2", "אחד גבוה מימין (2 טורים, שתי שורות) ושניים בחצי גובה ב-4 טורים", L((2, 2), (4, 1), (4, 1))),
                  ("K-3.3", "אחד גבוה משמאל ושניים בחצי גובה ב-4 טורים", "tall-end", L((4, 1), (2, 2), (4, 1)))]),
    ("4 פריטים", [("K-4.1", "שתי שורות של 2 — 3+3 / 3+3", L((3, 1), (3, 1), (3, 1), (3, 1))),
                  ("K-4.2", "שניים גדולים ושניים קטנים — 2+1+1+2", L((2, 1), (1, 1), (1, 1), (2, 1))),
                  ("K-4.3", "אחד גדול ושלושה קטנים — 3+1+1+1, הגדול ראשון", L((3, 1), (1, 1), (1, 1), (1, 1))),
                  ("K-4.4", "אחד גדול ושלושה קטנים — 1+1+1+3, הגדול אחרון", L((1, 1), (1, 1), (1, 1), (3, 1)))]),
    ("5 פריטים", [("K-5.1", "אחד גדול וארבעה קטנים בשורה אחת — 2+1+1+1+1, הגדול ראשון", L((2, 1), (1, 1), (1, 1), (1, 1), (1, 1))),
                  ("K-5.2", "אותו דבר, הגדול אחרון — 1+1+1+1+2", L((1, 1), (1, 1), (1, 1), (1, 1), (2, 1))),
                  ("K-5.3", "אחד גבוה מימין ורביעייה לידו — כל אחד 2 טורים ובחצי גובה", L((2, 2), (2, 1), (2, 1), (2, 1), (2, 1))),
                  ("K-5.4", "אחד גבוה משמאל ורביעייה לידו", "tall-end", L((2, 1), (2, 1), (2, 2), (2, 1), (2, 1))),
                  ]),
]

s = BeautifulSoup(open(SRC, encoding="utf-8").read(), "lxml")
imgs = [i["src"] for i in s.select(".gallery img")][3:30]  # photos, not the book covers at the start

blocks = []
for title, rows in LAYOUTS:
    blocks.append(f'<div class="cm-group"><span>חלוקה</span><h2>{title}</h2></div>')
    for row in rows:
        kid, label, items = row[0], row[1], row[-1]
        cells = []
        for n, (c, r) in enumerate(items):
            cells.append(f'<figure class="kg__i" style="grid-column:span {c};grid-row:span {r}" data-c="{c}">'
                         f'<img src="{imgs[n % len(imgs)]}" alt=""><b>{n + 1}</b></figure>')
        ruler = '<div class="cm-grid" aria-hidden="true">' + "".join(f"<i>{k}</i>" for k in range(1, 7)) + "</div>"
        blocks.append(f'<div class="av-ex" id="{kid}"><b>{kid}</b> {label}</div>'
                      f'<div class="cm-spec cm-prop"><section class="sec"><div class="wrap"><div class="kg-box"><div class="kg">{"".join(cells)}</div>{ruler}</div>'
                      f'</div></section></div>')

head = ('<div class="cm-proof-head"><h1>חלוקות הרשת — כל האפשרויות לפי מספר פריטים</h1>'
        '<p>כל פריט יושב על ששת הטורים; גובה שורה אחיד, ופריט גבוה תופס שתי שורות. נפסלו: 1+5 בשניים, ו«שלושה שלישים ואחד מתחת» '
        'בארבעה. כל אפשרות עם מזהה — מאשרים, פוסלים, ואז כל טיפוס שמחלק פריטים (כרטיסים, תמונות, המלצות וכו׳) יורש מהרשימה. '
        'בטלפון: שני טורים; פריט רחב (3 טורים ומעלה) או גבוה תופס את שניהם. <b>מעל חמישה אין תבנית משלו</b> — מרכיבים משורות שברשימה (שישה = 3+3 או 4+2 וכו׳). <b>רשימה של יותר מעשרה, או שמספרה לא ידוע מראש</b> (בלוג, גלריה, המלצות): פטורה — בוחרים מספר בשורה שעומד ברשת (1, 2, 3 או 6) וזהו; השארית נשארת כמו שהיא.</p></div>')

keep_nav(s, "grids.html")
main = s.find("main")
main.clear()
main.append(BeautifulSoup(head + "".join(blocks), "lxml").body)
main.body.unwrap()
css = s.new_tag("style")
css.string = """
.cm-proof-head{font-family:Heebo,sans-serif;background:#1d140d;color:#f3ece2;padding:20px 24px}
.cm-proof-head h1{margin:0 0 6px;font-size:1.4rem;font-weight:500;color:#f3ece2}
.cm-proof-head p{margin:0;font-size:.9rem;opacity:.9;max-width:110ch}
.cm-group span{letter-spacing:0!important}
.av-ex{font-family:Heebo,sans-serif;background:#3f7a52;color:#fff;padding:9px 24px;font-size:.95rem;margin-top:18px}
.av-ex b{background:#fff;color:#3f7a52;padding:1px 8px;border-radius:3px;margin-inline-end:8px;font-family:ui-monospace,Menlo,monospace;direction:ltr;unicode-bidi:isolate}
.kg-box{position:relative}
.kg{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));grid-auto-rows:170px;grid-auto-flow:row dense;gap:var(--cm-gap)}
.kg__i{position:relative;margin:0;overflow:hidden;border-radius:4px;background:#e6dccf}
.kg__i img{width:100%;height:100%;object-fit:cover;display:block}
.kg__i b{position:absolute;top:8px;inset-inline-start:8px;background:#1d140dcc;color:#fff;font:600 .8rem/1 Heebo,sans-serif;padding:5px 8px;border-radius:3px}
.cm-grid{position:absolute;inset:0;display:grid;grid-template-columns:repeat(6,minmax(0,1fr));
  column-gap:var(--cm-gap);direction:rtl;pointer-events:none;z-index:5}
.cm-grid i{border-inline:1px solid rgba(230,30,110,.8);font:600 .75rem/1 Heebo,sans-serif;font-style:normal;color:#e61e6e;
  text-align:center;padding-top:4px;text-shadow:0 0 3px #fff}
@media(max-width:760px){
 .kg{grid-template-columns:repeat(2,minmax(0,1fr));grid-auto-rows:130px}
 .kg__i{grid-column:span 1!important;grid-row:span 1!important}
 .kg__i:is([data-c="3"],[data-c="4"],[data-c="6"]){grid-column:1/-1!important}
 .cm-grid{display:none}
}
"""
s.head.append(css)
open(OUT, "w", encoding="utf-8").write(str(s))
print("layouts:", sum(len(r) for _, r in LAYOUTS))
