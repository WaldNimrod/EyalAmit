"""Decisions with pictures (team_00, 2026-09-28: «כל החלטה יש להביא לי עם קישור לצפייה או סקיצה המציגה את ההבדלים —
האישור הוא ויזואלי, לא בטקסט»). Each open question from the map validation, as option A / option B rendered from the
map's own examples, with the site's six-column grid drawn over each one.

    python3 tools/decisions_view.py map-source.html decisions.html
"""
import copy, sys
from bs4 import BeautifulSoup
from proofnav import keep_nav

SRC, OUT = sys.argv[1], sys.argv[2]
s = BeautifulSoup(open(SRC, encoding="utf-8").read(), "lxml")
rows = {r["id"]: r for r in s.select(".cm-row")}
appr = lambda t, i: rows[t].select(".cm-full > .cm-spec.cm-appr")[i]
today = lambda t, i: rows[t].select(".cm-full > .cm-spec:not(.cm-appr):not(.cm-prop)")[i]
RULER = ('<div class="dq-ruler" aria-hidden="true"><div>' + "".join(f"<i>{n}</i>" for n in range(1, 7)) + "</div></div>")


def variant(spec, add_cls="", ruler=True):
    sp = copy.copy(spec)
    for b in sp.select(".cm-dummy__badge"):
        b.decompose()
    top = [c for c in sp.children if getattr(c, "name", None)][0]
    if add_cls:
        top["class"] = top.get("class", []) + add_cls.split()
    top["style"] = (top.get("style", "") + ";position:relative").lstrip(";")
    if ruler:
        top.append(BeautifulSoup(RULER, "lxml").div)
    sp["class"] = ["cm-spec"]
    return str(sp)


def synth_button(style):
    return ('<div class="cm-spec"><section class="sec" style="position:relative"><div class="wrap">'
            '<h2 class="h2" style="margin:0 0 14px">כותרת לדוגמה</h2>'
            '<p style="margin:0 0 20px;max-width:none">שורת טקסט לדוגמה מעל הכפתור.</p>'
            f'<p style="margin:0"><a class="btn btn--terra" style="{style}">לתיאום שיחת היכרות</a></p></div>'
            + RULER + "</section></div>")


Q = [
    ("ש-1", "מרווח הנשימה בטקסט ותמונה",
     "הטקסט מתרחק מהתמונה בתוך הטורים שלו, ולכן קצה הטקסט הגלוי לא נוגע בקו רשת (הקופסה כן על הרשת).",
     [("א — כמו שאישרת: עם מרווח נשימה (מומלץ)", variant(appr("T-06", 0))),
      ("ב — בלי מרווח: הטקסט עד קו הרשת, צמוד לתמונה", variant(appr("T-06", 0), "dq-nopad"))]),
    ("ש-2א", "טקסט על תמונה בבולטים — ימין או יישור בלוק",
     "בשורות קצרות יישור בלוק פותח רווחים בין מילים.",
     [("א — טקסט תצוגה, מיושר לימין (מומלץ)", variant(appr("T-13", 0))),
      ("ב — יישור בלוק, כמו טקסט רץ", variant(appr("T-13", 0), "dq-just"))]),
    ("ש-2ב", "הפסקה בפס הקריאה לפעולה — ימין או יישור בלוק", "",
     [("א — כמו היום, מיושרת לימין", variant(appr("T-08", 0))),
      ("ב — יישור בלוק, כמו כל טקסט רץ (מומלץ)", variant(appr("T-08", 0), "dq-just"))]),
    ("ש-3", "רוחב פס הקריאה לפעולה",
     "הקווים הוורודים הם הרשת של כל האתר (1104). היום הפס בנוי על 1120 — הטקסט והכפתור זזים מהקווים.",
     [("א — כמו היום: 1120", variant(appr("T-08", 0))),
      ("ב — ברוחב התוכן 1104, על הרשת של כל האתר (מומלץ)", variant(appr("T-08", 0), "dq-1104"))]),
    ("ש-4", "כפתור ברוחב התווית",
     "מחוץ להירו ולפס הקריאה לפעולה, הכפתור לפי אורך התווית ולא ממלא טורים.",
     [("א — לפי התווית, מתחיל בקו הטור (מומלץ)", synth_button("")),
      ("ב — ממלא שני טורים בדיוק", synth_button("display:inline-flex;justify-content:center;width:calc((100% - 50px) / 6 * 2 + 10px)"))]),
    ("ש-6א", "תמונת הירו — מילוי או התאמה", "",
     [("א — תמיד מילוי: התמונה ממלאת את הבאנר (מומלץ)", variant(appr("T-01", 3))),
      ("ב — התאמה: התמונה שלמה, עם שוליים כהים", variant(appr("T-01", 3), "dq-fit"))]),
    ("ש-6ב", "התמונה ביצירת קשר — מילוי או התאמה", "להמחשה המסגרת כאן ריבועית, כדי שההבדל ייראה: במילוי התמונה נחתכת, בהתאמה רואים אותה שלמה עם שוליים.",
     [("א — מילוי: נחתכת למסגרת", variant(appr("T-31", 0), "dq-sq")),
      ("ב — התאמה: התמונה שלמה (וריאנט לבחירה, מומלץ לאפשר)", variant(appr("T-31", 0), "dq-sq dq-fit"))]),
]
NOVIS = [
    ("ש-5", "«סרטון שעוד לא הגיע» — באיזה טיפוס רשום", "זו החלטה על סדר המפה בלבד — המראה זהה בשתי האפשרויות. "
     "ההמלצה: רק תחת «ממתין לתוכן». כך זה נראה:", variant(today("T-27", 0), ruler=False)),
    ("ש-7", "«כל עמוד מקבל סרט משלו» ככלל של טיפוס הווידאו", "החלטה שלך מ־27.9 (D8) — רק לרשום אותה בכללי הטיפוס. אין הבדל חזותי.", ""),
    ("ש-8", "קובץ הקאנון לפי 18 הטיפוסים", "סידור מסמך — המפה עצמה לא משתנה. אין הבדל חזותי.", ""),
]

blocks = []
for qid, title, note, opts in Q:
    blocks.append(f'<div class="cm-group" id="{qid}"><span>{qid}</span><h2>{title}</h2></div>'
                  + (f'<div class="dq-note">{note}</div>' if note else ""))
    for lab, html in opts:
        blocks.append(f'<div class="av-ex">{lab}</div>{html}')
for qid, title, note, html in NOVIS:
    blocks.append(f'<div class="cm-group" id="{qid}"><span>{qid}</span><h2>{title}</h2></div><div class="dq-note">{note}</div>{html}')

head = ('<div class="cm-proof-head"><h1>החלטות מבדיקת המפה — לבחירה בעין</h1>'
        '<p>לכל שאלה: אפשרות א ואפשרות ב, מצוירות מהדוגמאות של המפה, עם רשת ששת הטורים של האתר (קווים ורודים). '
        'ענה לפי מזהה, למשל «ש-1 א, ש-3 ב».</p></div>')
keep_nav(s, "decisions.html")
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
.dq-note{font-family:Heebo,sans-serif;background:#fbf6ee;color:#2f2013;padding:10px 24px;font-size:.95rem;border-bottom:1px solid #e6dccf}
.av-ex{font-family:Heebo,sans-serif;background:#3f7a52;color:#fff;padding:9px 24px;font-size:.95rem;margin-top:18px}
.dq-ruler{position:absolute;inset:0;pointer-events:none;z-index:60}
.dq-ruler>div{position:absolute;top:0;bottom:0;left:50%;transform:translateX(-50%);width:min(1104px,calc(100% - 96px));
  display:grid;grid-template-columns:repeat(6,minmax(0,1fr));column-gap:10px;direction:rtl}
.dq-ruler i{border-inline:1px solid rgba(230,30,110,.8);font:600 .75rem/1 Heebo,sans-serif;font-style:normal;color:#e61e6e;
  text-align:center;padding-top:4px;text-shadow:0 0 3px #fff}
@media(max-width:760px){.dq-ruler{display:none}}
.dq-nopad .split2>:not(.split2__m){padding-inline:0!important}
.dq-just .whom__p,.dq-just .cta-band__p,.dq-just .cta-band__txt p{text-align:justify!important;text-align-last:start!important}
.dq-1104 .cta-band__in{max-width:1104px!important;width:min(1104px,calc(100% - 96px))!important;padding-inline:0!important;margin-inline:auto!important;box-sizing:border-box}
/* The hero heights are svh; fix them to a 900-high screen so the page reads the same in any window. */
header.phero.cm-h-m{min-height:594px!important;height:594px!important}
.dq-fit .phero__media{object-fit:contain!important;background:#1d140d}
.dq-sq .ea-contact-portrait img{aspect-ratio:1/1!important;height:auto!important}
.dq-fit .ea-contact-portrait img{object-fit:contain!important;background:#f3ece2}
"""
s.head.append(css)
open(OUT, "w", encoding="utf-8").write(str(s))
print("questions:", len(Q) + len(NOVIS))
