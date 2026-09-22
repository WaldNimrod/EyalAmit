---
id: S007_POST_TEMPLATE_SETTINGS
schema_version: aos_v1_team_messaging
type: SETTINGS (team_100)
status: APPROVED team_00 2026-09-22 — Team 10 implement after T-ALIGN-SWEEP; no theme FTP from the dirty shared tree
authority: team_00 notes 2026-09-21 + dummy approved 2026-09-22 + alignment canon locked on /snoring-sleep-apnea/ 2026-09-20
---

# תבנית פוסט חדש — קובץ הגדרות (מקור להקשר)

**זה הקובץ שסוכן קורא לפני כל יצירה / עריכה / תחזוקה של פוסט חדש.**  
לא ממציאים לייאאוט. לא נוגעים ב־Gutenberg בשביל סדר השורות. לא מוסיפים `font-size`.

| מה | איפה |
|---|---|
| הקובץ הזה | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/POST-TEMPLATE-SETTINGS.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/POST-TEMPLATE-SETTINGS.md) |
| פוסט דמה (JSON) | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/post-template/DUMMY-WEEK-OF-BREATH.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/post-template/DUMMY-WEEK-OF-BREATH.json) |
| סקיצה ויזואלית (שתי תצוגות: לאייל / מבנה) | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-sketches/SKETCH-NEW-POST-DUMMY.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-sketches/SKETCH-NEW-POST-DUMMY.html) |
| מאגר תמונות לדמה | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/build/media-filter.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/build/media-filter.html) — 939 שנשלחו לאייל. לא ממציאים גלריה שלישית. |
| דוגמת שורות חיה (קאנון יישור) | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/snoring-sleep-apnea-defaults.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/snoring-sleep-apnea-defaults.php) |
| CSS קאנון | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/chapters.css](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/chapters.css) שורות 88, 198–202, 408–427 |
| טיפוגרפיה | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md) |
| עמוד חי לאימות יישור | http://eyalamit-co-il-2026.s887.upress.link/snoring-sleep-apnea/ |

אישור נימרוד: **2026-09-22** על  
[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-sketches/SKETCH-NEW-POST-DUMMY.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-sketches/SKETCH-NEW-POST-DUMMY.html).

העתק חי של ה־JSON יישב תחת  
`site/wp-content/themes/ea-eyalamit/inc/data/blog/{slug}.json`  
והרנדרר ימפה `part` לחלקים הקיימים ב־`template-parts/chapters/parts/`. **אין FTP תמה מהעץ הראשי המלוכלך** — רק מהעץ המבודד אחרי T-ALIGN-SWEEP.

---

## 1. קאנון יישור (מעמוד דום נשימה, 20.9.2026)

team_00 על צילומים חיים: «כל העמוד מנצל רק כמחצית הרוחב» / «ג רחב יותר».

| שכבה | ערך נעול | מה אסור |
|---|---|---|
| `.wrap` | `max-width: 1200px`, `padding-inline: 48px` | כרטיס צר ממורכז (~920px) כמו בסקיצה הישנה |
| כותרת H2 | על ה־wrap, יישור **start** (ב־RTL ימין). רחבה מהגוף — זו ההסטה | H2 באותו רוחב כמו הפסקה |
| גוף קריאה | `.intro-body` / `.prose` = **82ch ממורכז** בתוך ה־wrap (~212px לכל צד ב־1200) | 65ch צמוד לקצה, או 42rem בתוך כרטיס |
| שורת split | שני טורים על כל רוחב ה־wrap | טקסט בשליש עמוד בגלל תמונה |
| תמונה קטנה בתוך טקסט | `float_image` — הטקסט עוטף | עמודה שגונבת רוחב לכל גובה הסיפור |
| גלריה / CTA | כל רוחב ה־wrap / פס מלא | כפתור בתוך עמודת קריאה צרה |
| הירו | `.phero__in` 1200px; H1 עד 32ch; sub עד 54ch; start | H1 ממורכז בכרטיס |

פוסט היסטורי: הירו as-is, **לא** ממירים ל־JSON. פוסט חדש בלבד.

---

## 2. מודל שורות

העמוד = `hero` + מערך `rows[]`.  
**סדר השורות בדף = סדר המערך.** סוכן משנה סדר ע״י העברת אובייקט במערך, לא ע״י CSS ולא ע״י גרירה בעורך.

כל שורה:

```json
{
  "id": "r03",
  "part": "prose",
  "bg": "ivory-2",
  "title": "כותרת המשנה — H2",
  "body": "<p>HTML מותר: p, ul, li, strong, em, a.tlink, h3, blockquote.</p>",
  "images": ["img-01"]
}
```

- `id` יציב (`r01`…) — לא משנים אחרי פרסום; רק סדר במערך.
- `part` רק מהטבלה בסעיף 4.
- `bg` רק מהטבלה בסעיף 3.
- שורה בלי תוכן אמיתי — **מוחקים מהמערך**, לא משאירים ריקה.

---

## 3. ארבעה רקעים לשורה

שמות ה־JSON הם השמות היחידים. המיפוי ל־CSS הקיים:

| `bg` | מחלקת CSS חיה | מתי |
|---|---|---|
| `ivory` | `.sec` על `--ivory` `#fffffa` | ברירת מחדל לקריאה |
| `ivory-2` | `.sec.sec--alt` על `--ivory-2` `#efeae1` | שורה שנייה בקצב, אחרי ivory |
| `dark` | `.sec.sec--dark` | ציטוט / הבלטה. H2 ו־lead לבנים |
| `cta` | `.cta-band.cta-band--row` | **רק** ל־`part: cta` |

אין רקע חמישי בלי פסיקה ב־SSOT. לא גרדיאנט חדש, לא hex ב־JSON.

---

## 4. חלקים (`part`) — תבנית, לא תוכן חופשי

| `part` | מה זה | מדיה | חלק PHP קיים |
|---|---|---|---|
| `prose` | H2 (אופציונלי) + גוף 82ch. `center: true` רק למשפט פתיחה בלי H2 רגיל | אופציונלי `float` → `img-NN` | `parts/prose.php` |
| `split` | טקסט + תמונה אחת בטור. `zoom: true` לצילום מסמך | חובה תמונה אחת | `parts/split.php` |
| `gallery` | רשת 2–8 תמונות מתוך `media[]` | `images: ["img-02","img-03",…]` | `parts/gallery.php` |
| `photo-slot` | מקום שמור בלי קובץ | תווית בלבד | `parts/photo-slot.php` |
| `cta` | פס כהה + כפתור ל־`/contact/` | אין | `parts/cta.php` |
| `quote` | ציטוט קצר על רקע `dark` או `ivory-2` | אין | `parts/testi-cards.php` או `blockquote` ב־prose |
| `video` | סרט 16:9 אחרי H2. יוטיוב **או** mp4 מקומי + פוסטר | `video.youtube` ו/או `video.file` + `video.poster` | `parts/videoblk.php` |

חלקים מעמוד דום נשימה **שלא** נכנסים לפוסט חדש כברירת מחדל: `toc`, `dd` (אקורדיון שאלות). אם יידרשו — פסיקה ב־SSOT קודם.

---

## 5. מדיה — מקומות מובנים

| סלוט | מפתח | כלל |
|---|---|---|
| תמונה ראשית | `hero.image` | מחרוזת ריקה = הירו לוגו/כהה. **לא דיוקן כברירת מחדל.** אם יש קובץ — הוא ההירו |
| תמונות תוכן | `media[img-01…img-08]` | **N = 1 עד 8.** מזהים קבועים. שורה מצביעה על המזהה, לא על נתיב כפול |
| סרט | `video` + שורת `part: video` | חובה בפוסט דמה כדי לראות את הבלוק. בפוסט חי — רק כשיש סרט אמיתי |
| CTA | שורת `part: cta` | לפחות אחת בפוסט חדש. מותר לשכפל (כמו בדום נשימה) בלי נוסח חדש |

קובץ חסר: `photo-slot` או `pending: true` בגלריה — פלייסהולדר «ממתין», לא המצאת תמונה.

**דמה לאייל:** התמונות נבחרות **רק** מתוך 939 של סינון המדיה (`mediaId939` + `pool`). הטקסט לורם איפסום. הסרט — סרט הבית (`wDQoJauqsRM`) או `ea-home-hero-720-muted.mp4`. לא ממתינים לפלייסהולדר בדוגמה שמוגשת לאייל.

אחרי מימוש חי: קבצים ב־`site/wp-content/themes/ea-eyalamit/assets/images/blog/{slug}/`. ב־JSON רק `id` + `file` יחסי.

---

## 6. איך סוכן עובד (חובה)

1. לקרוא **את הקובץ הזה** במלואו.
2. להעתיק את `DUMMY-WEEK-OF-BREATH.json` → `{slug}.json`.
3. למלא `title`, `hero`, `media[]`, `rows[]`. תוכן אמיתי רק ממקור אייל; דמה רק כשסומנים `"dummy": true`.
4. לסדר שורות במערך. לבדוק שאין שתי שורות `ivory` רצופות בלי סיבה — הקצב הרגיל מתחלף `ivory` / `ivory-2`.
5. לחבר תמונות דרך `img-01`…`img-08` בלבד.
6. לא לגעת ב־`chapters.css` ולא להוסיף מחלקה חדשה בשביל פוסט בודד.
7. אחרי מימוש: רנדרר PHP קורא JSON ומעביר `args` ל־`get_template_part`. הערות באנגלית בראש הרנדרר + קישור לקובץ הזה.
8. פוסט היסטורי — לא ממירים.

קריטריון «פוסט מוכן»: JSON תקין לפי הסכימה למטה, לפחות שורת `prose` אחת, לפחות `cta` אחת, מספר תמונות תוכן ≤ 8. דמה שמוגש לאייל: הירו מלא + 1–8 תמונות מ־939 + שורת `video` חיה — לא ריבועי «ממתין».

---

## 7. סכימה (שדות)

```
ea-post-v1
  schema, dummy, slug, title, category, date, author
  hero { chap, image, imageAlt }
  media[] { id, file, alt, cap, pending }
  rows[]  { id, part, bg, title?, body?, center?, images?, float?, zoom?,
            cta_label?, cta_url? }
```

`id` של מדיה חייב להתאים ל־`^img-0[1-8]$`.  
`bg` ∈ `ivory|ivory-2|dark|cta`.  
`part` ∈ `prose|split|gallery|photo-slot|cta|quote|video`.  
`video` { youtube?, file?, poster?, cap? } — לפחות מקור אחד.
