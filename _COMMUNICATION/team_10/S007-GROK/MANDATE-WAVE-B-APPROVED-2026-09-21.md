# מנדט צוות 10 — גל ב (סעיפים שאושרו) · 2026-09-21

**מזמין:** מנהל מבצע מול נימרוד.  
**מבצע:** צוות 10 — Composer.  
**מאמת:** המנוע הזה אחרי FTP, לא הבונה.  
**אישור נימרוד (2026-09-21):** פירורים, nowrap, סרגל 88→56, CMP, קישורים עם 301, ומרווח שנהב ב־`/contact/`.  
**לא במנדט:** טינט על בלוקים כהים באמצע עמוד — סקיצה מתוקנת ממתינה לאישור. לא מילוי `--terra-dk`.

סטייג'ינג: http://eyalamit-co-il-2026.s887.upress.link (HTTP). תמה חיה **1.5.97**. bump ל־**1.5.98** ב־`site/wp-content/themes/ea-eyalamit/style.css` אחרי קריאת ה־Version. commit רק קבצי התמה + המנדט + as-made. FTP `python3 scripts/ftp_deploy_site_wp_content.py`. בלי `git add -A`, בלי `local/`, בלי `_aos/`. בלי `--fs-*`. בלי L1 חדש. בלי נוסח מומצא.

מפקד: [WAVE-B-CENSUS-2026-09-20.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/WAVE-B-CENSUS-2026-09-20.md)  
סקיצות: [SKETCH-GALLERY.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-sketches/SKETCH-GALLERY.html)

---

## WB-02 פירורים — אושר

רכיב אחד מעל H1. מקור העץ: `ea_canonical_nav_items()` ב־`inc/ea-canonical-nav.php`. RTL. `--fs-sm` / `--fw-body`. צבע: על הירו כהה — `rgba(255,255,255,.82)` + קישור `--terra-lt`.

**לא מציגים** ב־`/`, `/en/`, `/qr/*`.

דוגמאות:
- `/method/` → בית / השיטה
- `/lessons/` → בית / שיעורי דיג׳רידו
- `/learning/therapist-training/` → בית / לימוד והכשרה / הכשרות למטפלים
- `/books/tsva-bekahol/` → בית / ספרים / צבע בכחול וזרוק לים
- פוסט בלוג → בית / בלוג דיג׳רידו / כותרת הפוסט

הזרקה: `template-parts/chapters/parts/phero.php`, `mokesh-hero.php`, `section-hero.php` (בית מוחרג), וב־GP מעל H1 אם יש H1 יחיד ב־`/about/` `/press/` `/faq/` `/privacy/` `/contact/` (contact הוא Chapters). שביל ארוך ב־390 יורד שורה, לא overflow.

הצלחה: CDP `nav[aria-label]` נראה מעל H1 ב־`/method/` `/lessons/`; נעדר ב־`/` וב־`/qr/qr1/`.

## WB-03a מרווח שנהב בצור קשר — אושר

רק `/contact/`: פס שנהב 32px (`--ivory`) מיד מעל `.foot`, כמו בסקיצה שאושרה. לא משנים את רקע ה־CTA. לא נוגעים בצבע הפוטר. לא `--terra-dk`. לא טינט על `.cta-band` כללי. אם `.ea-wave2-contact__nap` כבר יושב בין ה־CTA לפוטר — עדיין להבטיח 32px שנהב מעל הפוטר, בלי להכפיל מרווחים מוגזמים.

הצלחה: צילום `/contact/` — פס שנהב בין הבלוק הכהה האחרון לפוטר.

## WB-04a nowrap — אושר

`<span lang="en" class="ea-nowrap">cbDIDG</span>` ו־nowrap על יחידת «שיטת cbDIDG» ב־H1 של `/method/` `/lessons/` `/learning/therapist-training/` `/` (כותרת הבית). CSS: `.ea-nowrap{white-space:nowrap}`. **לא** nowrap על כל ה־H1. לא `--fs-h1`.

מקורות כותרת: `method-defaults.php`, `lessons-defaults.php`, `therapist-training-defaults.php`, `home-defaults.php`. אם H1 נבנה ב־PHP מ־title HTML — העטיפה שם. `ea_chapters_kses_e` חייב לאפשר `span` עם `class` **וגם** `lang` (היום אין `lang` ב־allowlist).

הצלחה: Range על `cbDIDG` = שורה אחת ב־390; אין overflow אופקי.

## WB-17 סרגל 88→56 — אושר

- `.nav{height:88px}` + `transition` כולל height.
- `.nav[data-s="1"]{height:56px}` (JS `data-s` כבר קיים ב־`ea-chapters.js`).
- `--fs-nav` לא נוגעים.
- `.phero--media .phero__in` → `calc(88px + 16px)`.
- `.phero{padding:calc(88px + var(--sec))…}`.
- `faq-toc.css` fallback `--ea-faq-toc-top` 72→88 (JS ממשיך למדוד חי).
- לא לגעת ב־`gap: …72px` של גריד, לא ב־padding של `.cta-band`.

הצלחה: מנוחה 88±1, אחרי גלילה 56±1. `/lessons/` 390: H1 לא מאחורי הסרגל (gap ≥ 16).

## WB-07 CMP — אושר

להחליף את דיאלוג גל א (לא באנר שני). מפתח חדש `ea_cookie_cmp`: `accept` | `reject`. להתעלם מ־`ea_cookie_notice_ack` ישן.

| קטגוריה | התנהגות |
|---|---|
| הכרחי | תמיד. אין מתג. |
| מדידה | GA4 + גופני Google רק אם `accept` |

כפתורים (מתוך הסקיצה, לא ממציאים חוק): «אישור מדידה» / «המשך בלי מדידה» + קישור `/privacy/`. כותרת וגוף כמו היום (יידוע גל א).

PHP לא רואה `localStorage`. חובה גם עוגיית first-party `ea_cookie_cmp=accept|reject` (path=/, SameSite=Lax, לא HttpOnly) כדי ש־`wp_head` יוכל לשער. JS כותב localStorage + cookie ביחד.

- דחייה: לא מדפיסים `gtag.js` / לא מפעילים את גוף ה־GA4 ב־`ea_wave2_print_analytics_head`.
- אישור: כמו היום (אחרי רענון או הזרקה מיידית — רענון פשוט יותר).
- גופנים: לא להדפיס `fonts.googleapis.com` מ־`functions.php` / `chapters-enqueue.php` / `wave2-stage-b.php` עד `accept` (fallback מערכת כבר ב־`--hf`/`--bf`).
- פרטיות `privacy-defaults.php` — להחליף רק את המשפט «אין באנר הסכמה בסגנון GDPR ואין חסימת מדידה» במשפט: «בכניסה הראשונה ניתן לאשר או לדחות מדידה (Google Analytics 4 וגופני Google). עוגיות הכרחיות לפעולת האתר נשארות תמיד. אין באנר הסכמה בסגנון GDPR.» באנר WP-EI-05 נשאר.

הצלחה: כניסה ראשונה — דיאלוג פתוח, `typeof gtag !== 'function'` עד אישור. אחרי דחייה — אין `gtag/js?id=G-MRXESK7QJF` ב־HTML. אחרי אישור — gtag נטען. טעינה חוזרת לא פותחת דיאלוג.

## WB-08 href עם 301 — אושר

החלפה מדויקת של `href` בלבד. לא משנים טקסט עוגן. חניה לא נוגעים.

| קובץ / מקום | ישן | חדש |
|---|---|---|
| `inc/data/ea-faq-seed.json` + `lessons-defaults.php` פוסט נשים מנגנות | `https://www.eyalamit.co.il/Blog/…נשים-מנגנות…` | הנתיב החי אחרי 301 בסטטייג'ינג: `/blog/` + slug העברי שנמדד |
| FAQ seed דיג׳רידו למכירה | URL לגסי ארוך | `/didgeridoos/` |
| FAQ seed תיקים | לגסי | `/bags/` |
| FAQ seed סטנד רצפה | לגסי | `/stand-floor/` |
| FAQ seed סטנדים אחסון | לגסי | `/stands-storage/` |
| FAQ seed תיקון | לגסי | `/repair/` |
| תוכן פוסט מוקש (חי) | לגסי מוקש | `/eyal-amit/mokesh-dahiman/` |
| פוסט ריברסינג | לגסי | `/treatment/` |
| פוסט ספר חדש Blog | לגסי Blog | הנתיב החי שנמדד (`/את-הספר-החדש-שלי-לא-תמצאו-ברשתות-הספרים/`) |
| פוסט סטודיו | `/shop/books/וכתבת/` | `/books/vekatavta/` |
| טור 49 | `/צור-קשר/` | `/contact/` |
| טור 40 מוזה | לגסי מוזה | `/books/` |

**חניה — אסור להחליף:** תמונת צוותא 404; שלושה `/shop/shows/…`; `https://www.eyalamit.co.il/` ב־`/learning/courses-external/`; `/books/כושי-בלאנטיס/` (העמוד החי `/books/kushi-blantis/` לא בטבלת 301 — בלי אישור נפרד).

הצלחה: GET ל־`/faq/` בלי follow — 0 `href` ל־`www.eyalamit.co.il` בששת קישורי הכלים/תיקון/בלוג שאושרו. החניות נשארות.

---

## אסור

- לא `--terra-dk` על `.cta-band`. לא טינט כללי עד אישור הסקיצה המתוקנת.
- לא `--fs-*`. לא L1 חדש. לא Cookiebot. לא נוסח GDPR.
- לא קבוצה ג.

## מסירה

`_COMMUNICATION/team_10/S007-GROK/WAVE-B-ASMADE-2026-09-21.md`: קבצים, גרסת תמה 1.5.98, קומיט, שורת FTP.
