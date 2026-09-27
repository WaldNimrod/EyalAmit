"""Merge-and-align proposal (team_00, 2026-09-27): similar types become variants of one type, and every conflict with
what is already approved is caught now, not during the reset.

Takes the map's own examples (no second copy of the markup): for each proposed type, one live example of every old
type it absorbs, numbered M-<type>.n. The surviving ID of a merged type is the lowest old number in it; the others
retire like T-02/T-03. Findings that cut across types are numbered A-n.

    python3 tools/merge_view.py ea-canon-map.html merge.html
"""
import sys
from bs4 import BeautifulSoup
from proofnav import keep_nav

SRC, OUT = sys.argv[1], sys.argv[2]

# (new id, name, [(old id, variant values it becomes, use-the-approved-example?)], variants, note)
MERGE = [
    ("T-01", "הירו", [("T-01", "כבר מאוחד ומאושר", True)], [], "ללא שינוי."),
    ("T-04", "פסקת טקסט", [("T-04", "הבסיס — מאושר", True), ("T-05", "קיפול: עם «להמשך קריאה»", False),
                            ("T-07", "תמונה צפה: עם", False)],
     [("קיפול", "בלי · עם (שדה: מספר שורות גלויות)"), ("תמונה צפה", "בלי · עם — גודל אחד (ראו A-3)")],
     "הקיפול והתמונה הצפה הם תוספות על אותה פסקה, לא מבנה אחר."),
    ("T-06", "טקסט ותמונה", [("T-06", "הבסיס — מאושר", True), ("T-16", "תמונות: תצרף שלוש", False),
                             ("T-17", "רקע: כהה · תמונה: מילוי · עם כפתור", False)],
     [("תמונות", "אחת · תצרף שלוש (גדולה ושתיים קטנות)"), ("כפתור", "בלי · עם (שדה חדש לטיפוס)")],
     "האודות של דף הבית והסטודיו הם טקסט ליד תמונה — עם יותר תמונות או עם כפתור."),
    ("T-10", "פס תמונה ברוחב מלא", [("T-10", "תוכן: כותרת, טקסט וכפתור", False), ("T-12", "תוכן: ציטוט ושם", False)],
     [("תוכן על התמונה", "כותרת, טקסט וכפתור · ציטוט ושם")],
     "שני הטיפוסים הם תמונה על כל רוחב המסך עם טקסט עליה; רק התוכן שונה."),
    ("T-09", "כרטיסים", [("T-09", "תמונה: בלי · טורים: 2", False), ("T-13", "תמונה: עגולה · טורים: 4", False),
                        ("T-14", "תמונה: רחבה עם טקסט עליה · טורים: 2", False),
                        ("T-15", "רקע: תמונה · פריט: צעד עם סמל · טורים: 3", False),
                        ("T-24", "תמונה: כריכה 3:4 · הכרטיס כולו קישור", False),
                        ("T-25", "תמונה: 3:2 · טורים: 4 · הכרטיס כולו קישור", False),
                        ("T-35", "תמונה: 3:2 · תאריך · הכרטיס כולו קישור", False)],
     [("טורים", "2 · 3 · 4"), ("תמונה", "בלי · עגולה · 3:2 · כריכה 3:4 · רחבה עם טקסט עליה"),
      ("קישור", "בלי · הכרטיס כולו קישור")],
     "שבעה טיפוסים שכולם אותו דבר: רשת פריטים שווים. ההבדלים הם מספר טורים, צורת תמונה ואם הכרטיס לחיץ."),
    ("T-11", "רשת תמונות", [("T-11", "צורה: לרוחב 4:3 · 3 בשורה / לאורך 3:4 · 4 בשורה", False)],
     [("צורת התמונה", "לרוחב — 3 בשורה · לאורך — 4 בשורה (כמו בטקסט ותמונה)")],
     "הדיוקנאות בעמוד התיקון הופכים לוריאנט מוגדר ולא לחריגה."),
    ("T-18", "המלצות", [("T-18", "פריסה: גלילה", False), ("T-19", "פריסה: רשת", False),
                        ("T-20", "פריסה: בתוך הקריאה (בלי כותרת ושם)", False)],
     [("פריסה", "גלילה · רשת · בתוך הקריאה")], "אותם כרטיסי ציטוט בשלוש פריסות."),
    ("T-21", "אקורדיון", [("T-21", "תוכן: שאלות ותשובות", False), ("T-22", "תוכן: מונחים עם תגית", False)],
     [("תוכן", "שאלות · מונחים"), ("היקף", "מלא לפי נושאים · רגיל · מקוצר (בית)")],
     "רשימה שכל פריט בה נפתח ללחיצה — שאלה או מונח."),
    ("T-29", "רשימת שנים", [("T-29", "פריט: שנה ואירוע", False), ("T-32", "פריט: שנה, מקור וקישור", False)],
     [("פריט", "שנה ואירוע · שנה, מקור וקישור")], "ציר הזמן ורשימת העיתונות הם אותה רשימה: שנה ומה קרה בה."),
    ("T-26", "וידאו", [("T-26", "עם כותרת וטקסט", False), ("T-36", "בלי כותרת — בתוך הקריאה", False)],
     [("כותרת וטקסט", "עם · בלי")], "«ממתין לתוכן» (T-27) הוא מצב, לא טיפוס — ראו A-5."),
    ("T-08", "פס קריאה לפעולה", [("T-08", "מאושר", True)], [], "ללא שינוי."),
    ("T-23", "תוכן עניינים", [("T-23", "", False)], [], "נשאר טיפוס — אין לו אח."),
    ("T-28", "הטמעות פייסבוק", [("T-28", "", False)], [], "נשאר טיפוס — עמוד אחד. שאלה: להשאיר או לוותר (A-8)."),
    ("T-31", "יצירת קשר", [("T-31", "", False)], [], "נשאר טיפוס — טופס קבוע בעמוד אחד."),
]
TEMPLATES = [
    ("P-1", "עמוד קוד מודפס (QR)", ["T-33"], "זו תבנית של עמוד שלם, לא בלוק בתוך עמוד."),
    ("P-2", "פוסט בלוג", ["T-34", "T-37"], "וריאנט: ארכיון (הקיים) · חדש (התבנית שאושרה). תבנית עמוד, לא בלוק."),
]
FINDINGS = [
    ("A-1", "רקע שאינו מאושר",
     "15 טיפוסים יושבים היום על הרקע החלופי (שמנת כהה, ivory-2), שאינו אחד מחמשת הגוונים שאושרו. "
     "הצעה: כל רקע חלופי הופך ל«חול», ו«רקע» הוא וריאנט משותף לכל הטיפוסים — אותם חמישה גוונים ואותם צבעי טקסט."),
    ("A-2", "כותרות ממורכזות",
     "ב-11 טיפוסים הכותרת ממורכזת (כרטיסים, רשתות, המלצות, אקורדיון מונחים ועוד). זה סותר את הכלל שאושר בפסקה: "
     "כותרת מיושרת לימין בטורים 1–6. הצעה: אותו כלל לכל הטיפוסים — אין כותרת ממורכזת."),
    ("A-3", "תמונה צפה בשני גדלים",
     "קטנה בעמוד דום נשימה, גדולה פי שניים בעמוד התיקון. הצעה: גודל אחד — שני טורים מתוך השישה."),
    ("A-4", "כפתורים קבועים בשלושה סגנונות",
     "פס התמונה — כפתור חול קבוע; הטור הכהה — כפתור מתאר קבוע; שלושת הצעדים — כפתור מלא קבוע. "
     "הצעה: סגנון הכפתור הוא וריאנט משותף — מלא או מתאר — וכל הכפתורים לפי כלל הכפתורים שאושר."),
    ("A-5", "ממתין לתוכן — שלוש צורות",
     "מסגרת וידאו ריקה (T-27), מקום שמור לתמונה (T-30), ותמונה ממתינה ברשת התמונות. "
     "הצעה: מצב אחד משותף — «ממתין לתוכן» — לכל תמונה או סרטון, באותו מראה; לא טיפוס."),
    ("A-6", "הגדלה בלחיצה רק בעמוד אחד",
     "רק בטקסט ותמונה בעמוד דום נשימה ובתמונה הצפה. הצעה: וריאנט משותף «הגדלה בלחיצה» לכל תמונה בודדת."),
    ("A-7", "רשת תמונות ורשת כרטיסים",
     "רשת תמונות עם כיתוב קרובה מאוד לכרטיסים עם תמונה בלי קישור. השארתי אותן נפרדות — גלריה היא אוסף תמונות, "
     "כרטיס הוא פריט תוכן. אם תעדיף, אפשר לאחד."),
    ("A-8", "טיפוסים של עמוד אחד",
     "תוכן עניינים, הטמעות פייסבוק ויצירת קשר — כל אחד בעמוד אחד ובלי אח. נשארים טיפוסים; שאלה אם הטמעות "
     "פייסבוק נחוצות בכלל."),
    ("A-9", "תבניות עמוד אינן טיפוסים",
     "עמוד QR ופוסט בלוג הם עמודים שלמים שבנויים מטיפוסים, לא בלוקים. הצעה: שכבה נפרדת במפה — «תבניות עמוד»."),
]


def examples(s, tid, approved):
    full = s.find(id=tid).select_one(".cm-full")
    specs = full.select(".cm-spec.cm-appr") if approved else full.select(".cm-spec:not(.cm-appr):not(.cm-prop)")
    return specs[0] if specs else None


s = BeautifulSoup(open(SRC, encoding="utf-8").read(), "lxml")
names = {r["id"]: r.select_one(".c-name").get_text() for r in s.select(".cm-row")}
blocks, n_old = [], 0
for nid, name, olds, variants, note in MERGE:
    absorbed = [o for o, _, _ in olds if o != nid]
    sub = ("מאחד: " + " · ".join(f"{o} {names.get(o, '')}" for o, _, _ in olds)) if absorbed else "טיפוס קיים"
    card = f'<div class="av-card"><p class="mv-note">{note}</p>'
    if variants:
        card += "<dl>" + "".join(f"<dt>{a}</dt><dd>{b}</dd>" for a, b in variants) + "</dl>"
    card += "</div>"
    blocks.append(f'<div class="cm-group" id="{nid}"><span>{nid} · {sub}</span><h2>{name}</h2></div>{card}')
    for k, (old, vals, appr) in enumerate(olds, 1):
        spec = examples(s, old, appr)
        n_old += 1
        exid = f"M-{nid[2:]}.{k}"
        was = "" if old == nid else f"היה {old} «{names.get(old, '')}» → "
        blocks.append(f'<div class="av-ex" id="{exid}"><b>{exid}</b> {was}{vals}</div>' + (str(spec) if spec else ""))
for pid, name, olds, note in TEMPLATES:
    blocks.append(f'<div class="cm-group" id="{pid}"><span>{pid} · תבנית עמוד · מאחד: '
                  + " · ".join(f"{o} {names.get(o, '')}" for o in olds) + f'</span><h2>{name}</h2></div>'
                  f'<div class="av-card"><p class="mv-note">{note}</p></div>')
    n_old += len(olds)

states = ["T-27", "T-30"]
n_old += len(states)
fnd = "".join(f'<li id="{i}"><b>{i}</b> <b>{t}</b> — {d}</li>' for i, t, d in FINDINGS)
head = ('<div class="cm-proof-head"><h1>איחוד ויישור קו — הצעה לאישור</h1>'
        f'<p>{n_old} הטיפוסים של היום הופכים ל-<b>{len(MERGE)} טיפוסים</b>, <b>{len(TEMPLATES)} תבניות עמוד</b> '
        'ומצב משותף אחד («ממתין לתוכן»). טיפוס שמתאחד שומר את המספר הנמוך מבין שלו; המספרים האחרים יוצאים משימוש. '
        'לכל דוגמה מזהה M-xx.n — הדוגמאות הן האתר של היום, והטקסט בפס הירוק אומר איזה וריאנט הן הופכות להיות.</p>'
        f'<h2>חריגות ובעיות שנתפסו</h2><ul class="av-rules">{fnd}</ul></div>')

keep_nav(s, "merge.html")
main = s.find("main")
main.clear()
main.append(BeautifulSoup(head + "".join(blocks), "lxml").body)
main.body.unwrap()
css = s.new_tag("style")
css.string = """
.cm-proof-head{font-family:Heebo,sans-serif;background:#1d140d;color:#f3ece2;padding:20px 24px}
.cm-proof-head h1{margin:0 0 6px;font-size:1.4rem;font-weight:500;color:#f3ece2}
.cm-proof-head p{margin:0 0 6px;font-size:.9rem;opacity:.9;max-width:100ch}
.cm-proof-head h2{margin:14px 0 6px;font-size:1.05rem;font-weight:600;color:#f3ece2}
.av-rules{margin:0;padding-inline-start:18px;font-size:.9rem;line-height:1.7;max-width:120ch}
.av-rules b:first-child,.av-ex b{font-family:ui-monospace,Menlo,monospace;direction:ltr;unicode-bidi:isolate}
.av-card{font-family:Heebo,sans-serif;background:#fbf6ee;color:#2f2013;padding:12px 24px;border-bottom:1px solid #e6dccf}
.av-card dl{display:grid;grid-template-columns:max-content 1fr;gap:3px 16px;margin:6px 0 0;font-size:.92rem}
.av-card dt{font-weight:600;color:#9a4f2b}.av-card dd{margin:0}
.mv-note{margin:0;font-size:.95rem}
.cm-group span{letter-spacing:0!important}
.av-ex{font-family:Heebo,sans-serif;background:#3f7a52;color:#fff;padding:9px 24px;font-size:.95rem;margin-top:18px}
.av-ex b{background:#fff;color:#3f7a52;padding:1px 8px;border-radius:3px;margin-inline-end:8px}
"""
s.head.append(css)
open(OUT, "w", encoding="utf-8").write(str(s))
print("types:", len(MERGE), "templates:", len(TEMPLATES), "old types covered:", n_old)
