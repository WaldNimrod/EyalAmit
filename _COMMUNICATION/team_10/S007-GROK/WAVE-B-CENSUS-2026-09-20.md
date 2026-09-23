# גל ב — מפקד חי · 2026-09-20

**סטייג'ינג:** http://eyalamit-co-il-2026.s887.upress.link (HTTP; TLS לא תקין בכוונה)  
**תמה חיה:** 1.5.97  
**מקור עץ:** [_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv)  
**מנוע מפקד:** Cursor Grok (HTML GET בלי follow-redirect + CDP 390/768/1440). אימות אחרי מימוש — מנוע אחר.  
**זה מסמך מדידה.** הוא לא מאשר קוד. סקיצות: [SKETCH-GALLERY.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-sketches/SKETCH-GALLERY.html)

**שער נימרוד 2026-09-21:** אושר — פירורים, nowrap, סרגל 88→56, CMP, href עם 301, מרווח שנהב ב־`/contact/`. **נדחה** — מילוי `--terra-dk` על `.cta-band` (שינוי צבע). **ממתין** — טינט עדין (~10% terra על `--dark-grad` הקיים); לא מממשים עד אישור הסקיצה המתוקנת. מנדט: [MANDATE-WAVE-B-APPROVED-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/MANDATE-WAVE-B-APPROVED-2026-09-21.md)

צילומי **לפני** (לא Git): [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-shots/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-shots/)  
JSON גולמי: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-b-census/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-b-census/)

---

## היקף שנמדד

| מה | תוצאה |
|---|---|
| שורות מפת האתר | 157 |
| HTTP 200 (בלי follow) | 141 |
| HTTP 301 (כינויי עץ ישנים) | 16 — כולם ליעד חי באתר החדש. לא דף חסר. |
| משפחות (200) | Chapters 28 · בלוג 55 · QR 49 · GP `tpl-content` (`/about/`, `/press/`) 2 · EN 1 · בית 1 · other/learning 20 |
| overflow אופקי (CDP) | 0 ב־29 URL × 390/1440 |
| `.nav` Chapters | 72px קבוע, מנוחה וגלילה |
| `.nav` ב־`/about/` `/press/` `/en/` | אין — כותרת GeneratePress |

16 ה־301 הם כינויים (`/muzeh/`, `/tools-and-accessories/`, `/hashita/`, `/services/…`) ולא כשל מפקד.

---

## סעיף 2 — פירורים

**חי:** אין רכיב פירורים נראה. CDP `crumb = null` בכל 29 העמודים שנמדדו ב־390 (בית, שיטה, שיעורים, טיפול, חנות, FAQ, אודות, עיתונות, EN, QR, בלוג, ספרים, למידה).  
JSON-LD `BreadcrumbList` מופיע ב־HTML של כל ה־141 (Yoast/Rank) — זה סכמה למנועי חיפוש, לא שביל על המסך.  
הערת `books-v2.css` על breadcrumb — CSS בלבד, לא markup חי.

**המלצה:** רכיב אחד, מקור `ea_canonical_nav_items()`, מעל H1, RTL, `--fs-sm` / `--fw-body`.  
**בלי** `/`, `/en/`, `/qr/*`.  
דוגמאות עץ:  
- `/method/` → בית / השיטה  
- `/lessons/` → בית / שיעורי דיג׳רידו  
- `/learning/therapist-training/` → בית / לימוד והכשרה / הכשרות למטפלים  
- `/books/tsva-bekahol/` → בית / ספרים / צבע בכחול וזרוק לים  
- `/eyal-amit/mokesh-dahiman/` → בית / אייל עמית / מוקש דהימן — לזכרו  
- `/about/` `/press/` (GP) — אותו רכיב מעל H1 אם נכנסים להיקף; אחרת רק Chapters. **המלצת ברירת מחדל: Chapters + ספרי-ילד + למידה + FAQ/פרטיות/צור-קשר. לא QR, לא בית, לא EN.**

**לא לגעת:** L1 חדש. `--fs-nav`. JSON-LD הקיים.

**סיכון:** שביל ארוך במובייל (ספרים + כותרת עברית). סקיצה מראה wrap ל־שורה שנייה בלי overflow.

---

## סעיף 3 — בלוקים כהים «כמו פוטר»

**חי:** אין `#000` ב־inline באמצע עמוד. שלוש משפחות:

| מחלקה | רקע חי (computed) | איפה | נראה כמו פוטר? |
|---|---|---|---|
| `.foot` | `var(--dark)` = `#0E0905` | כל Chapters | זה הפוטר. **לא לגעת.** |
| `.cta-band` | `var(--dark-grad)` `#0B0703→#2A1A0C` | 21 עמודי Chapters (חזרות: `/repair/` שישה פסים, `/didgeridoos/` ארבעה, ספרי-ילד שלושה) | כן — פס כהה מלא-רוחב על רקע שנהב |
| `.sec--dark` | אותו `--dark-grad` | בית (אחד), `/lessons/` (אחד, 1135px), `/contact/` CTA | `/contact/` יושב מיד מעל הפוטר |
| `.start` | `var(--dark)` = **אותו צבע כמו הפוטר** | בית «איך מתחילים» | כן — זהה לפוטר, לא גרדיאנט |
| `.hero` בית | `rgb(0, 0, 0)` | רק גיבור מדיה עליון | לא אמצע-עמוד |

דוגמה חיה: [clean-repair-cta-1440.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-shots/clean-repair-cta-1440.png) · [clean-contact-dark-1440.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-shots/clean-contact-dark-1440.png) · [clean-home-cta-1440.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-shots/clean-home-cta-1440.png)

**המלצה (בלי פלטה חדשה):**  
- פוטר נשאר `--dark`.  
- `.start` בבית: מ־`--dark` ל־`--dark-grad` (כבר קיים) כדי שלא יהיה שכפול מדויק של הפוטר.  
- `.cta-band` באמצע קטלוג (`/repair/` ודומיו): רקע `--terra-dk` (`#9A4F2B`) במקום גרדיאנט כמעט-שחור — נשאר כהה, לא נראה כפוטר שני.  
- `.cta-band` / `.sec--dark` **סופי** של עמוד (לפני פוטר, כמו `/contact/`): נשאר `--dark-grad` + מרווח שנהב 32px מעל `.foot` כדי שלא ידבקו.

**לא לגעת:** `--dark` / `--dark-grad` / `--terra-dk` כערכים. פוטר. גיבור שחור עליון.

**סיכון:** שישה פסי תיקון יהפכו לטרה-קוטה חוזר — עדיין פסים, אבל לא «שני פוטרים».

---

## סעיף 4א — שבירת כותרות (`cbDIDG`)

**חי:** המילה `cbDIDG` עצמה **לא נשברת** ב־390/768/1440 (Range על הטוקן = שורה אחת).  
H1 שמכילים את הביטוי (רק ארבעה 200):

| URL | H1 חי 390 | מה קורה |
|---|---|---|
| `/method/` | שיטת cbDIDG / של אייל עמית | שתי שורות; «שיטת cbDIDG» ביחד, «של אייל עמית» יורד. [צילום](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-shots/clean-method-h1-390.png) |
| `/lessons/` | שיעורי נגינה בדיג'רידו / לפי שיטת cbDIDG של / אייל עמית | `<br>` במקור + wrap של «אייל עמית». [צילום](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-shots/clean-lessons-hero-390.png) |
| `/learning/therapist-training/` | מטפלים ומנחים / בשיטת cbDIDG | `<br>` במקור; הביטוי שלם בשורה האחרונה. [צילום](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-shots/clean-training-h1-390.png) |
| `/` | שתי שורות; cbDIDG עם «של אייל עמית» בשורה השנייה בדסקטופ | טוקן שלם |

**המלצה:** `<span lang="en" class="ea-nowrap">cbDIDG</span>` (ביטוח; היום כבר לא נשבר) + nowrap על יחידת «שיטת cbDIDG» בלבד. **לא** nowrap על כל ה־H1 (יחתוך ב־390). לא משנים `--fs-h1`.

**לא לגעת:** 4ב גופן אנגלי. כותרות בלוג עם «spoken stories» וכו'.

**סיכון:** nowrap על «שיטת cbDIDG» ב־390 בשיטה — נמדד כבר נכנס לשורה אחת (32.3px). אם ייחתך — רק הטוקן הלטיני נשאר nowrap.

---

## סעיף 8 — href ל־eyalamit.co.il

19 כתובות ייחודיות ב־HTML החי. סיווג לפי GET בלי follow בסטטייג'ינג + מפת 301.

**להחליף (יש 301 חי בסטטייג'ינג):**

| נמצא ב | יעד חי אחרי 301 |
|---|---|
| `/faq/` (פוסט נשים מנגנות) | `/blog/נשים-מנגנות-בדיגרידו-אישה-מנגנת-בדיג/` |
| `/faq/` דיג׳רידו למכירה | `/didgeridoos/` |
| `/faq/` תיקים | `/bags/` |
| `/faq/` סטנד רצפה | `/stand-floor/` |
| `/faq/` סטנדים לאחסון | `/stands-storage/` |
| `/faq/` תיקון | `/repair/` |
| פוסט מוקש | `/eyal-amit/mokesh-dahiman/` |
| פוסט ריברסינג | `/treatment/` |
| פוסט ספר חדש (Blog/…) | פוסט `/את-הספר-החדש-שלי-לא-תמצאו-ברשתות-הספרים/` |
| פוסט סטודיו | `/books/vekatavta/` |
| טור 49 | `/contact/` |
| טור 40 מוזה | `/books/` |

**חניה (אין יעד חי/301 תקין — לא ממציאים):**

| נמצא ב | href | למה |
|---|---|---|
| פוסט צוותא | `wp-content/uploads/2014/07/צוותא-אייל-עמית.jpg` | 404 סטייג'ינג ופרוד |
| טור 47 | `/books/כושי-בלאנטיס/` | 404. העמוד החי הוא `/books/kushi-blantis/` — **לא מחליפים בלי אישור**, זה לא בטבלת ה־301 |
| פוסט סיפורים מהנייר | שלושה `/shop/shows/…` | סטייג'ינג 404; פרוד 308 לעמוד הבית / נתיב משובש |
| `/learning/courses-external/` | `https://www.eyalamit.co.il/` | דף הבית של הפרוד — לא עמוד קורס. לא מחליפים בלי להבין את הכוונה |

**לא לגעת:** `Theme URI` ב־`style.css`. הערות מקור ב־PHP. 16 כינויי מפת האתר שכבר 301.

---

## סעיף 17 — גובה סרגל

**חי:** `.nav{height:72px}` תמיד. אחרי גלילה: `data-s="1"`, רקע `rgba(20,14,9,.95)`, **גובה נשאר 72**.  
[מנוחה 1440](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-shots/clean-nav-rest-1440.png) · [גלילה 1440](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-shots/clean-nav-scrolled-1440.png)

`--fs-nav` נעול (18.36px). JS כבר כותב `data-s` ב־`ea-chapters.js`.  
`.phero--media .phero__in` משתמש ב־`calc(72px + 16px)` — חובה לעדכן עם הגובה הגבוה.

**המלצה:** מנוחה **88px**, גלילה **56px**, פונט הסרגל בלי שינוי. ריפוד הירו `calc(88px + 16px)` כדי ששיעורים לא יחזרו מאחורי הסרגל הגבוה. GP (`/about/` `/press/` `/en/`) — מחוץ לסעיף (אין `.nav`).

**סיכון:** שורת L1 בדסקטופ כבר מלאה; גובה נוסף לא דוחק אותה. כיווץ ל־56 עלול לחתוך וורדמרק אם לא מיושרים ל־center.

---

## סעיף 7 — עוגיות / CMP

**חי:**  
- דיאלוג גל א פתוח בכניסה ראשונה (`#ea-cookie-notice`, `localStorage ea_cookie_notice_ack`). כפתור יחיד «הבנתי».  
- `gtag` = function **לפני** האישור. `G-MRXESK7QJF` ב־141/141 עמודי 200 מ־`wave2-stage-b.php`.  
- Google Fonts נטענים בלי שער.  
- מדיניות: «אין באנר הסכמה בסגנון GDPR ואין חסימת מדידה».

[צילום דיאלוג 390](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-shots/before-cookie-390.png)

**המלצת CMP (טקסט לאישור, לא קוד):**

| קטגוריה | מה | ברירת מחדל |
|---|---|---|
| הכרחי | וורדפרס / הפעלת האתר | תמיד. אין מתג. |
| מדידה | GA4 `G-MRXESK7QJF` + גופני Google באותם עמודים שכבר טוענים אותם | כבוי עד אישור |

- דחייה = לא טוענים `gtag.js`.  
- אישור = כמו היום.  
- מחליפים את דיאלוג גל א (לא באנר שני). מפתח אחסון חדש (`ea_cookie_cmp`) כדי שמי שלחץ «הבנתי» בגל א יראה את הבחירה.  
- כפתורים: «אישור מדידה» + «המשך בלי מדידה» + קישור «מדיניות הפרטיות».  
- לעדכן בפרטיות את «אין חסימת מדידה».  
- לא Cookiebot. לא ממציאים GDPR / זכות להישכח.  
- לא חוסמים את האתר מאחורי הקיר.

---

## מה מחוץ לגל ב

קבוצה ג (סרטונים, קובץ שמע, תמונות בלוג, תגיות). 4ב גופן. FAQ/עדויות ב־L1. באנר WP-EI-05. סולם `--fs-*`.

---

## שער

אין CSS / markup / FTP עד אישור הסקיצות ב־[SKETCH-GALLERY.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-sketches/SKETCH-GALLERY.html). סעיף 8 (href בלבד) יכול אחרי אישור הטבלה בלי סקיצה.
