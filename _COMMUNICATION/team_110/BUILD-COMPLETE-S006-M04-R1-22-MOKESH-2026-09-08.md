---
id: BUILD-COMPLETE-S006-M04-R1-22-MOKESH-2026-09-08
schema_version: aos_v1_team_messaging
from_team: team_110
to_team: team_100
cc: [team_00, team_90]
date: 2026-09-08
type: build-complete
milestone: S006
mandate: M-04 (מתוקן) · R1-22 מוקש
base: bad9c3e
engine: claude-opus-5 (builder)
status: שלוש הפעולות סגורות · לא נפרס · לא נדחף · שתי נקודות לאישורך
---

# M-04 · שלוש הפעולות סגורות

פעולה 3 כבר מקומטת (`bad9c3e`). כאן פעולות 1 ו-2, אחרי שתי ההכרעות שלך.

## קבצים — שלושה

| קובץ | |
|---|---|
| `parts/mokesh-video.php` | **חדש** — ה-embed |
| `parts/mokesh-portrait.php` | **חדש** — דיוקן + כיתוב (ראו «היקף» למטה) |
| `inc/chapters/defaults/mokesh-defaults.php` | חיווט שני החלקים + provenance |

**אפס CSS · אפס JS · אפס קבצים משותפים.** לא נגעתי ב-`mokesh-hero.php` · `videoblk*` ·
`fbembeds` · `split.php` · `chapters-render.php`.
**→ `Version` אינו נדרש למנדט הזה.**

## פעולה 1 — ה-embed

```html
<iframe src="https://www.youtube-nocookie.com/embed/kf4NKSdYi9E"
        title="MUKESH: The Art of Shanti Living"
        loading="lazy" referrerpolicy="strict-origin-when-cross-origin"
        allowfullscreen style="position:absolute;inset:0;…;border:0"></iframe>
```

- **`<iframe>` פשוט, לא `YT.Player` שני** — כפי שאישרת. אינסטנס שני היה נלחם על אובייקט
  ה-API הגלובלי שנגן ההירו כבר מחזיק.
- `yt_id` **זהה ל-`phero.yt_id`** שכבר בקובץ — אומת בקוד, לא הועתק ביד.
- `title` = שם הסרט מהערוץ הרשמי, כפי שכבר רשום בהערת `phero.yt_id`. **מקור, לא ניסוח.**
- יחס 16/9 קבוע → אין קפיצת פריסה בטעינה.

## פעולה 2 — הכיתוב

שלוש שורות, `dir="ltr"`, **בייטים מאומתים בהקסה**:

```
Jungle Vibes - Rishikesh India
… 20 2D 20 …   ← רווח · HYPHEN-MINUS · רווח
```

המקף הוא `2D` ולא en-dash. אין תרגום, אין ניקוד, אין שינוי.
ה-`<figcaption>` הוא **ילד תקין של `<figure>`**, ויושב **מחוץ** לקופסה המעוגלת של `.figr`
כדי ש-`overflow:hidden` לא יחתוך אותו.

**התוכן הקיים של הסקשן לא נגע:** `part` הוחלף מ-`split` ל-`mokesh-portrait`, וכל שאר
הארגומנטים **זהים בבייט** (sha256 לפני/אחרי). 20 הסקשנים האחרים — סדר ותוכן זהים. `phero` — זהה.

---

## 🔴 שתי נקודות שדורשות את אישורך בדיעבד

### 1. נדרש חלק חדש **שני**, ולא רק `mokesh-video`

אישרת חלק חדש אחד בשם `mokesh-video`. **הכיתוב לא ניתן לבנייה בלעדיו:**
`split.php` פולט `<figure>` חשוף — **אין בו `<figcaption>` ואין ארגומנט `cap`** — והוא
נטען ע״י **שישה** קובצי defaults. הרחבתו הייתה נוגעת בעמודים מאושרים/ממתינים (§4).

*(הערה: גם לפי ההנחה המקורית שלך — `phero.media` — הכיתוב היה דורש עריכה של
`mokesh-hero.php`, שאסרת עליי במפורש. הפעולה לא הייתה ניתנת לבנייה בשום מסלול בלי חלק חדש.)*

`mokesh-portrait.php` הוא **עותק נאמן של `split.php`** — אותן מחלקות, אותו escaping, אותו
`ea_replace_retired_brand`, אותו `ea_chapters_content_img_alt` — **פלוס** ה-figcaption.
**עלות ידועה:** שינוי עתידי ב-`split.php` לא יזלוג לכאן. אם תעדיף במקום זאת להרחיב את
`split.php` בארגומנט `cap` אופציונלי — זו חריגה מוצהרת מ-§4 והכרעה שלך, ואני מבצע.

### 2. מיקום ה-embed — שמתי **אחרי** `sections[0]`, לא מעליו

המנדט אמר «לצד/**מעל** `sections[0]`». שמתי אותו **מתחת** לפסקת הפתיחה, ב-`[1]`.

**הנימוק:** ההירו עצמו נגמר בווידאו (הרקע המתנגן). embed מיד מתחתיו היה מציב שני נגני
וידאו רצוף בלי שורת טקסט ביניהם. אייל ביקש «די בהתחלה, **לצד טקסט הפתיחה**» — אחרי
הפסקה הפותחת עדיין «די בהתחלה», והטקסט שלו מקבל את הפתיחה.

**אם תעדיף מעל — זו הזזה של רשומה אחת במערך.** אומר ולא מחליט בשקט.

---

## 🪤 מלכודת שנתפסה לפני שנפרסה — תמונה שבורה

חלק שאינו רשום ב-`$map` של `chapters-render.php` **אינו מקבל `ea_chapters_resolve_img()`**.
`'split'` רשום שם (שורה 423, `'image' => 'img'`); `mokesh-portrait` — לא. כלומר הנתיב
היחסי `assets/images/mokesh/mokesh-01.jpeg` היה מוגש **כמו שהוא**, ותמונת הדיוקן של מוקש
הייתה נשברת בעמוד ההנצחה.

**התיקון נשאר בתוך החלק שלי** — `ea_chapters_resolve_img()` נקרא בתוך `mokesh-portrait.php`
במקום להוסיף את החלק ל-`$map` המשותף. בטוח לקריאה כפולה: `ea_chapters_asset_url()` מחזיר
URL מוחלט ללא שינוי. אומת ברינדור: `https://…/assets/images/mokesh/mokesh-01.jpeg`.

## ראיות

- `php -l` נקי על שלושת הקבצים.
- 22 סקשנים (21 + ה-embed). ציר הזמן עדיין אחרון, הגלריה לפניו.
- שני החלקים החדשים מוזכרים **רק** ב-`mokesh-defaults.php` — אף עמוד אחר לא נוגע בהם.
- רונדרו שניהם בבידוד; ה-HTML בדוח המלא.

לא פרסתי · לא דחפתי · לא נגעתי בטרקר.
