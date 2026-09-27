"""The approved view: everything approved so far by type / variant / field / rule, numbered, with the six-column grid.

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
# The approved view (team_00, 2026-09-27): everything approved so far, laid out by the canon terms — type, variant
# (values), shared variant, field, rule — each example numbered T-xx.n so a reply can point at it exactly.
# `ex` lists (index among the type's approved examples in the map, variant values shown) — the text is the canon.
RULES = [
    ("R-1", "רשת", "ששה טורים על רוחב התוכן, מרווח 10 פיקסלים. טור 1 הוא הימני. כל רכיב יושב על קווי הרשת."),
    ("R-2", "טקסט רץ", "יישור בלוק מימין לשמאל, השורה האחרונה לימין — תמיד, בכל האתר. לא כותרות, תוויות וכפתורים."),
    ("R-3", "כפתורים", "ריווח מצומצם סביב הטקסט בכל הכפתורים."),
    ("R-4", "טלפון", "מתחת ל-761 פיקסלים כל טיפוס עובר לטור אחד. כפתור ההירו ופס הקריאה לפעולה — משמאל."),
    ("R-5", "חלוקות", "פריטים שמחולקים — לפי רשימה נעולה לפי מספר (1–5, עמוד «חלוקות»); 6–10 מורכבים מהשורות שבה; "
            "מעל 10 או מספר לא ידוע — מספר קבוע בשורה (1, 2, 3 או 6). אין אלמנט מחוץ לרשת."),
    ("R-6", "טקסט על הרשת", "תווית וכותרת בטורים 1–6, טקסט רץ בטורים 2–5; טקסט ממורכז — ביישור בלוק, השורה האחרונה במרכז."),
    ("R-7", "תמונה", "בכל טיפוס שיש בו תמונה יש וריאנט לדרך חישוב גודל התמונה — מילוי או התאמה (תמונה מלאה), לכל אלמנט; הגדלה בלחיצה — ברירת מחדל לכל תמונה שאינה רקע."),
]
TERMS = ("<b>טיפוס</b> — בלוק עם מבנה משלו · <b>וריאנט</b> — בחירה לכל שימוש מרשימה סגורה · "
         "<b>וריאנט משותף</b> — חל על כל הטיפוסים שיש בהם אותו דבר · <b>שדה</b> — תוכן שממלאים · "
         "<b>כלל</b> — התנהגות אוטומטית, אף אחד לא בוחר")
TYPES = [
    dict(tid="T-01", name="הירו", box=".phero__in",
         variants=[("גובה", "גדול 92% · בינוני 66% · קטן 44% (מינימום — טקסט ארוך מגדיל)"),
                   ("מדיה", "תמונה · סרטון · בלי"), ("מיקום הכפתור", "למטה · למעלה")],
         shared=[("התאמת תמונה", "תמיד מילוי")],
         fields="תווית · כותרת · תת-כותרת · מדיה · כפתור (תווית וקישור)",
         rules=["טקסט בטורים 1–4, כפתור בטורים 5–6 בשורה אחת",
                "כפתור למטה — מיושר לתחתית; למעלה — ראשו בקו אחד עם ראש הכותרת",
                "בטלפון: טור אחד, הכפתור משמאל"],
         ex=[(0, "גובה: גדול · מדיה: סרטון · כפתור: למטה"), (1, "גובה: גדול · מדיה: תמונה · כפתור: למטה"),
             (2, "גובה: גדול · מדיה: תמונה · כפתור: למעלה"), (3, "גובה: בינוני · מדיה: תמונה · כפתור: למטה"),
             (4, "גובה: קטן · מדיה: תמונה · כפתור: למטה")]),
    dict(tid="T-08", name="פס קריאה לפעולה", box=".cta-band__in",
         variants=[("רקע", "חול · כהה")], shared=[],
         fields="כותרת · טקסט · כפתור (תווית וקישור)",
         rules=["פס נמוך; טקסט בטורים 1–4, כפתור בטורים 5–6 בשורה אחת, מיושר לתחתית",
                "הלוגו גדול ודהוי ברקע, צמוד לקצה המסך", "בטלפון: טור אחד, הכפתור משמאל"],
         ex=[(0, "רקע: חול"), (1, "רקע: כהה")]),
    dict(tid="T-04", name="פסקת טקסט", box="section > .wrap",
         variants=[], shared=[("רקע", "שמנת (ברירת מחדל) · חול · זית · טרקוטה · כהה — לכל גוון סט צבעי טקסט משלו")],
         fields="תווית · כותרת · טקסט",
         rules=["תווית וכותרת בטורים 1–6, טקסט רץ בטורים 2–5",
                "צבע הקישור שונה תמיד מצבע הטקסט; צבע הכותרת לפי הרקע",
                "כל צבע עובר את תקן הנגישות ב-10% לפחות"],
         ex=[(2, "רקע: שמנת"), (3, "רקע: חול"), (4, "רקע: זית"), (5, "רקע: טרקוטה"), (6, "רקע: כהה")]),
    dict(tid="T-06", name="טקסט ותמונה", box=".split2, .cm-sp-after",
         variants=[("צורת התמונה", "לרוחב 5:4 — חלוקה 3+3 · לאורך 4:5 — טקסט 4, תמונה 2"),
                   ("צד התמונה", "שמאל (ברירת מחדל) · ימין")],
         shared=[("התאמת תמונה", "מילוי · התאמה — עוד אין דוגמה מאושרת"), ("רקע", "כמו בפסקת הטקסט")],
         fields="תווית · כותרת · טקסט · תמונה · המשך טקסט (רשות)",
         rules=["מרווח נשימה בצד הטקסט שפונה לתמונה, בתוך הטורים שלו",
                "התמונה תמיד מיושרת למעלה; טקסט קצר ממורכז לגובה התמונה",
                "המשך טקסט: מתחת לזוג, בטורים 2–5", "בטלפון: טקסט, תמונה, המשך טקסט"],
         ex=[(0, "צורה: לרוחב · צד: שמאל · טקסט קצר"), (1, "צורה: לרוחב · צד: ימין · טקסט ארוך"),
             (2, "צורה: לרוחב · צד: ימין · עם המשך טקסט"), (3, "צורה: לאורך · צד: שמאל"),
             (4, "צורה: לאורך · צד: ימין")]),
]


def dl(rows):
    return "".join(f"<dt>{a}</dt><dd>{b}</dd>" for a, b in rows)


s = BeautifulSoup(open(SRC, encoding="utf-8").read(), "lxml")
blocks, n_ex = [], 0
for T in TYPES:
    specs = s.find(id=T["tid"]).select_one(".cm-full").select(".cm-spec.cm-appr")
    card = (f'<div class="av-card"><dl>'
            + (f'<dt class="av-h">וריאנטים</dt><dd></dd>{dl(T["variants"])}' if T["variants"] else "")
            + (f'<dt class="av-h">וריאנטים משותפים</dt><dd></dd>{dl(T["shared"])}' if T["shared"] else "")
            + f'<dt class="av-h">שדות</dt><dd>{T["fields"]}</dd>'
            + '<dt class="av-h">כללים</dt><dd><ul>' + "".join(f"<li>{r}</li>" for r in T["rules"]) + "</ul></dd></dl></div>")
    blocks.append(f'<div class="cm-group" id="{T["tid"]}"><span>{T["tid"]}</span><h2>{T["name"]}</h2></div>{card}')
    for k, (idx, vals) in enumerate(T["ex"], 1):
        spec = specs[idx]
        for c in spec.select(T["box"]):
            grid = s.new_tag("div", attrs={"class": "cm-grid", "aria-hidden": "true"})
            for n in range(1, 7):
                i = s.new_tag("i")
                i.string = str(n)
                grid.append(i)
            c.append(grid)
        exid = f'{T["tid"]}.{k}'
        blocks.append(f'<div class="av-ex" id="{exid}"><b>{exid}</b> {vals}</div>' + str(spec))
        n_ex += 1

rules = "".join(f'<li id="{i}"><b>{i}</b> <b>{t}</b> — {d}</li>' for i, t, d in RULES)
head = ('<div class="cm-proof-head"><h1>מה אושר — לפי טיפוס, וריאנט, שדה וכלל</h1>'
        f'<p>{TERMS}</p><p>לכל דוגמה מזהה (למשל T-06.3) ולכל כלל כללי מזהה (R-1) — אפשר להפנות אליהם ישירות. '
        'הרשת (קווים ורודים) מוצגת מרוחב 761 פיקסלים ומעלה. טור 1 הוא הימני.</p>'
        f'<h2>כללים לכל האתר</h2><ul class="av-rules">{rules}</ul></div>')

keep_nav(s, "grid-proof.html")
main = s.find("main")
main.clear()
main.append(BeautifulSoup(head + "".join(blocks), "lxml").body)
main.body.unwrap() if main.body else None

css = s.new_tag("style")
css.string = """
.cm-proof-head{font-family:Heebo,sans-serif;background:#1d140d;color:#f3ece2;padding:20px 24px}
.cm-proof-head h1{margin:0 0 6px;font-size:1.4rem;font-weight:500;color:#f3ece2}
.cm-proof-head p{margin:0 0 6px;font-size:.9rem;opacity:.85;max-width:100ch}
.cm-proof-head h2{margin:14px 0 6px;font-size:1.05rem;font-weight:600;color:#f3ece2}
.av-rules{margin:0;padding-inline-start:18px;font-size:.9rem;line-height:1.7}
.av-rules b:first-child,.av-ex b{font-family:ui-monospace,Menlo,monospace;direction:ltr;unicode-bidi:isolate}
.av-card{font-family:Heebo,sans-serif;background:#fbf6ee;color:#2f2013;padding:14px 24px;border-bottom:1px solid #e6dccf}
.av-card dl{display:grid;grid-template-columns:max-content 1fr;gap:3px 16px;margin:0;font-size:.92rem}
.av-card dt{font-weight:600;color:#6b5f55}.av-card dt.av-h{color:#9a4f2b;margin-top:6px}
.av-card dd{margin:0}.av-card ul{margin:0;padding-inline-start:18px}
.av-ex{font-family:Heebo,sans-serif;background:#2d5f8a;color:#fff;padding:9px 24px;font-size:.95rem;margin-top:18px}
.av-ex b{background:#fff;color:#2d5f8a;padding:1px 8px;border-radius:3px;margin-inline-end:8px}
.phero__in,.cta-band__in,.split2,.cm-sp-after{position:relative}
.cm-grid{position:absolute;inset:0;grid-column:1/-1!important;grid-row:auto!important;padding:0!important;align-self:stretch!important;justify-self:stretch!important;display:grid;grid-template-columns:repeat(6,minmax(0,1fr));
  column-gap:var(--cm-gap);direction:rtl;pointer-events:none;z-index:50}
/* A space-division ruler, not content cards (team_00): only the column edges are drawn. */
.cm-grid i{border-inline:1px solid rgba(230,30,110,.8);font:600 .75rem/1 Heebo,sans-serif;font-style:normal;
  color:#e61e6e;text-align:center;padding-top:4px;text-shadow:0 0 3px #fff}
@media(max-width:760px){.cm-grid{display:none}}
"""
s.head.append(css)
open(OUT, "w", encoding="utf-8").write(str(s))
print("types:", len(TYPES), "examples:", n_ex)
