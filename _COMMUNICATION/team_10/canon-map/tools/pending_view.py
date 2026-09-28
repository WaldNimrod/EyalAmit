"""What is waiting for team_00 right now — one page, every item with its picture (team_00, 2026-09-28: «איפה המידע
המלא? השאלה והתוכנית לאישור? באיזה ארטיפקט?»).

    python3 tools/pending_view.py map-source.html pending.html
"""
import copy, sys
from bs4 import BeautifulSoup
from proofnav import keep_nav

SRC, OUT = sys.argv[1], sys.argv[2]
s = BeautifulSoup(open(SRC, encoding="utf-8").read(), "lxml")
rows = {r["id"]: r for r in s.select(".cm-row")}
today = lambda t, i=0: rows[t].select(".cm-full > .cm-spec:not(.cm-appr):not(.cm-prop)")[i]
appr = lambda t, i=0: rows[t].select(".cm-full > .cm-spec.cm-appr")[i]


def mini(spec):
    sp = copy.copy(spec)
    for b in sp.select(".cm-dummy__badge"):
        b.decompose()
    inner = "".join(str(c) for c in sp.children)
    return f'<span class="pv-mini"><span class="pv-mini__in">{inner}</span></span>'


def row(rid, color, label, now, options):
    opts = "".join(f'<figure class="pv-opt"><figcaption>{t}</figcaption>{mini(sp)}</figure>' for t, sp in options)
    return (f'<div class="pv-row pv-{color}"><div class="pv-id"><b>{rid}</b><span>{label}</span></div>'
            f'<figure class="pv-opt pv-now"><figcaption>היום באתר</figcaption>{mini(now)}</figure>'
            f'<div class="pv-arrow">←</div><div class="pv-opts">{opts}</div></div>')


q5 = (f'<div class="cm-group" id="Q5"><span>1 · שאלה</span><h2>ש-5 — «סרטון שעוד לא הגיע»: באיזה טיפוס הוא רשום במפה</h2></div>'
      '<div class="dq-note">היום הוא רשום פעמיים — תחת «וידאו» ותחת «ממתין לתוכן». המראה זהה בשתי האפשרויות; ההחלטה היא רק '
      'איפה הוא יושב במפה. <b>א</b> — רק תחת «ממתין לתוכן» (מצב של כל תמונה או סרטון שעוד לא הגיעו) — מומלץ. '
      '<b>ב</b> — רק תחת «וידאו» (וריאנט של בלוק וידאו). כך הוא נראה:</div>'
      + str(appr("T-27")))

plan = (
    '<div class="cm-group" id="PLAN"><span>2 · תוכנית לאישור</span><h2>איך בוחרים טיפוס לכל שורה בכל עמוד — לקראת האיפוס</h2></div>'
    '<div class="dq-note"><b>שלב 1 — סיווג אוטומטי.</b> סקריפט עובר על כל 136 העמודים החיים, שורה אחרי שורה, מזהה ממה היא בנויה היום '
    'ומציע לה טיפוס ווריאנט מהקאנון. לכל שורה צבע:<br>'
    '<span class="pv-dot pv-green"></span><b>ירוק</b> — אין שאלה: הטיפוס והוריאנט נובעים מהכללים. מאשרים בלחיצה אחת לכל העמוד.<br>'
    '<span class="pv-dot pv-yellow"></span><b>צהוב</b> — בחירה: הכללים מתירים כמה צורות. מוצגות 2–3 סקיצות קטנות, בוחרים בלחיצה על תמונה.<br>'
    '<span class="pv-dot pv-red"></span><b>אדום</b> — אין התאמה: שורה שלא מתאימה לשום טיפוס. בוחרים טיפוס קיים, וריאנט חדש או מחיקה.<br>'
    '<b>שלב 2 — דף החלטות אחד</b>, מסודר לפי עמוד, כמו הסקיצה למטה. הבחירות נשמרות בדף, ובסוף לוחצים «שלח» ואני מקבל אותן כרשימה. '
    '<b>שלב 3</b> — הרשימה המאושרת עוברת להטמעה יחד עם צוות 90. פוסטי הבלוג (52) ועמודי ה-QR (48) הם תבניות — עוברים אוטומטית.</div>'
    '<div class="pv-mock"><div class="pv-page"><h3>עמוד: <a href="/method/" target="_blank">/method/</a> — השיטה</h3>'
    '<div class="pv-allgreen"><span class="pv-dot pv-green"></span>9 שורות ירוקות — <u>לאשר את כולן</u> · <u>להציג</u></div>'
    + row("method.4", "yellow", "טקסט ותמונה — איזו חלוקה?", today("T-06"), [("א — תמונה לרוחב, 3+3", appr("T-06", 0)), ("ב — תמונה לאורך, 4+2", appr("T-06", 3))])
    + '</div><div class="pv-page"><h3>עמוד: <a href="/" target="_blank">/</a> — דף הבית</h3>'
    '<div class="pv-allgreen"><span class="pv-dot pv-green"></span>11 שורות ירוקות — <u>לאשר את כולן</u> · <u>להציג</u></div>'
    + row("home.7", "yellow", "למי מתאים — איזו חלוקה לארבעה?", today("T-13"), [("א — 2+2", appr("T-13", 0)), ("ב — גדול, שניים, גדול", appr("T-13", 1)), ("ג — גדול ושלושה", appr("T-13", 2))])
    + '</div></div>'
    '<div class="dq-note">הסקיצה למעלה היא דוגמה לצורת הדף; המספרים (9, 11) לדוגמה. הספירה האמיתית — ירוק / צהוב / אדום — תגיע אחרי הסיווג.</div>')

t90 = ('<div class="cm-group" id="T90"><span>3 · לפתוח</span><h2>סשן צוות 90 של האתר</h2></div>'
       '<div class="dq-note">הסשן «90- הכנה לעלייה לאוויר אייל עמית» כבר לא מופיע בין הסשנים הפעילים. בלעדיו אין את נתיב 2 של הבדיקה '
       '(המפה מול האתר החי) ואין דחיפה. יש לפתוח אותו מחדש — והוא ימשיך מהמנדט '
       '<code>_COMMUNICATION/team_10/canon-validation/LANE-2-MAP-VS-SITE.md</code>.</div>')

head = ('<div class="cm-proof-head"><h1>ממתין לך</h1><p>כל מה שמחכה להחלטה שלך, במקום אחד, כל פריט עם התמונה שלו. '
        'ענה לפי המספר, למשל «1 א, 2 מאושר».</p></div>')
keep_nav(s, "pending.html")
main = s.find("main")
main.clear()
main.append(BeautifulSoup(head + q5 + plan + t90, "lxml").body)
main.body.unwrap()
css = s.new_tag("style")
css.string = """
.cm-proof-head{font-family:Heebo,sans-serif;background:#1d140d;color:#f3ece2;padding:20px 24px}
.cm-proof-head h1{margin:0 0 6px;font-size:1.4rem;font-weight:500;color:#f3ece2}
.cm-proof-head p{margin:0;font-size:.95rem;opacity:.9}
.cm-group span{letter-spacing:0!important}
.dq-note{font-family:Heebo,sans-serif;background:#fbf6ee;color:#2f2013;padding:12px 24px;font-size:.95rem;line-height:1.8;border-bottom:1px solid #e6dccf}
.pv-dot{display:inline-block;width:12px;height:12px;border-radius:50%;margin-inline-end:6px;vertical-align:-1px}
.pv-green{background:#3f8a52}.pv-yellow{background:#e0a526}.pv-red{background:#c0392b}
.pv-mock{background:#f3ece2;padding:18px 24px;font-family:Heebo,sans-serif}
.pv-page{background:#fff;border:1px solid #e6dccf;border-radius:6px;padding:14px 16px;margin-bottom:16px}
.pv-page h3{margin:0 0 10px;font-size:1.05rem}
.pv-allgreen{padding:8px 0;border-bottom:1px solid #eee;margin-bottom:10px}
.pv-row{display:grid;grid-template-columns:160px 250px 30px 1fr;gap:14px;align-items:center;padding:10px;border-radius:6px;border-inline-start:6px solid #e0a526;background:#fffaf0}
.pv-id b{display:block;font-family:ui-monospace,Menlo,monospace;direction:ltr;text-align:right}
.pv-id span{font-size:.9rem}
.pv-arrow{font-size:1.4rem;color:#9A4F2B;text-align:center}
.pv-opts{display:flex;gap:12px;flex-wrap:wrap}
.pv-opt{margin:0;cursor:pointer}
.pv-opt figcaption{font-size:.8rem;margin-bottom:4px}
.pv-opts .pv-opt:hover .pv-mini{outline:3px solid #3f7a52}
.pv-mini{display:block;width:230px;height:130px;overflow:hidden;position:relative;border:1px solid #ddd;border-radius:4px;background:#fffffa}
.pv-mini__in{position:absolute;top:0;right:0;width:1440px;transform:scale(.16);transform-origin:top right;pointer-events:none}
@media(max-width:760px){.pv-row{grid-template-columns:1fr}.pv-arrow{display:none}}
"""
s.head.append(css)
open(OUT, "w", encoding="utf-8").write(str(s))
print("ok")
