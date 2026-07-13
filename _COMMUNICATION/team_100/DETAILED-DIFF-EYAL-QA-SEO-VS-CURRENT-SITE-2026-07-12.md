---
id: DETAILED-DIFF-EYAL-QA-SEO-VS-CURRENT-SITE-2026-07-12
from_team: team_100
to_team: team_00
date: 2026-07-12
type: detailed-diff
purpose: "Requested by נמרוד following AOS_DECIDE Q3 (scope): full section-by-section diff between Eyal's two ChatGPT-assisted documents (QA spec + SEO spec) and the CURRENT LIVE SITE CODE, for a team discussion to decide item-by-item what changes and what stays. Rule given: תוכן (content/copy/claims) → per Eyal's wording. עיצוב/קוד/מבנה עמוד (design/code/structure) → default to our existing plan, but every item still needs individual review."
method: "6 parallel Explore agents, each read the live theme PHP/CSS files directly (not just prior reports) and compared file:line evidence against the QA/SEO doc text."
supersedes_partially: INTAKE-EYAL-WHATSAPP-SNORING-ANCHOR-QA-SEO-2026-07-12.md — item C2 (Mokesh memorial) is corrected below: the content already exists verbatim, it is not a new draft we'd need from Eyal.
---

# דיף מפורט — שני מסמכי אייל (QA + SEO) מול קוד האתר החי

## 0. התגלית הכי חשובה — תשתית כפולה (ולפעמים משולשת) בכל האתר

לפני כל שורה בטבלאות למטה, זה מה שצריך להבין: **האתר מריץ שתי מערכות תוכן/עיצוב מקבילות שהתפתחו במקביל**, ולפעמים שלוש:

- **"Wave2"** (הישנה) — `template-parts/blocks/block-topnav.php`, `page-templates/tpl-service.php`, `template-method.php`, `template-treatment.php` וכו'.
- **"Chapters"** (החדשה, **זו שבאמת פעילה היום**) — `template-parts/chapters/section-nav.php`, `inc/chapters/defaults/*.php`, מנותבת דרך `inc/chapters/chapters-routing.php` בעדיפות **103** ב-`template_include` — כלומר **גוברת** על Wave2 (עדיפות 100) כמעט בכל עמוד.

התוצאה בפועל: `ea_chapters_enabled()` ברירת המחדל שלה `true` וללא override בשום מקום בקוד → **כמעט כל עמוד באתר (treatment, method, lessons, sound-healing, faq, books, repair, shop, eyal-amit, mokesh, contact...) בפועל מוגש דרך Chapters**, ו-Wave2 הוא קוד מת עבור העמודים האלה (הוא עדיין פעיל רק ב-`/shop`, עמודי מוצר בודדים, ו-`/qr`).

**זה קריטי כי:** דוח ה-QA של אייל (שנכתב עם ChatGPT) לפעמים "בודק" מבנה שקיים **רק בקוד המת**. הדוגמה הכי בולטת: מבנה ה-13 הסעיפים בדיוק שדוח ה-QA מבקש לעמוד "טיפול בדיג'רידו" (Hero→Intro→What→Who→Process→Self-healing→Differentiation→Personal story→Research→Testimonials→FAQ→CTA→Disclaimer→Footer) **קיים כמעט מדויק** — אבל רק בקובץ `template-treatment.php` שהוא **תבנית יתומה שלא מנותבת אליה אף עמוד חי**, עם תוכן שונה לגמרי מ-`treatment.md` (סיפור טראומה אישי + ציטוט מחקר BMJ שלא קיימים במקור). כלומר ה-QA doc "נכון" ביחס לקוד מת, ו"לא נכון" ביחס למה שגולש רואה בפועל.

**מקרה דומה, חמור יותר, בעמוד ההנצחה למוקש:** קיים implementation מלא (וידאו, Schema, גלריית 19 תמונות, 4 פוסטים מפייסבוק) בקובץ `inc/wave2-w2-14e.php` — אבל עדיפות הניתוב (103 מול 102) גורמת לגרסת ה-Chapters (ללא וידאו) לנצח. **המלצת team_100 (לא רק על התוכן — זו שאלת ארכיטקטורה עצמאית):** יש כאן חוב טכני אמיתי, לא קשור לשני המסמכים של אייל, שכדאי להכריע עליו בנפרד — האם לאחד לשיטה אחת (Chapters) ולמחוק Wave2/wave2-w2-14e, או להעביר את הרכיבים הטובים (הוידאו, ה-Schema, קרוסלת ה-testimonials) מהקוד המת אל Chapters.

---

## 1. מצב לפי אשכול — טבלת-על

| אשכול | % התאמה גס | הפער האמיתי הכי גדול |
|---|---|---|
| Global/Nav/SEO טכני | ~55% | פריטי "לימוד והכשרה" בתפריט הם `href="#"` מתים; אין footer disclaimer גלובלי; אין FAQPage/Book schema; hero video לא lazy-load (יש לו `autoplay`) |
| דף הבית | ~50% | סעיף 03 (וידאו) **חסר לגמרי**; ה-Trust Line לא ב-Hero; מבנה 12 הסעיפים לא תואם לסדר בקוד; שמות ממליצים לא לחיצים |
| טיפול + שיטה | ~40% (חי) / ~90% (קוד מת) | מבנה ה-13-סעיפים שה-QA מבקש קיים רק בתבנית יתומה; קרוסלת 8 הכרטיסים ל-method חסרה (הרכיב קיים, פשוט לא מחובר) |
| שיעורים + סאונד הילינג + FAQ | ~65% | FAQPage schema **חסר לגמרי** (הדוח מגדיר "חובה"); הקטגוריות ב-FAQ לא תואמות את המקור המדויק |
| חנות/תיקון/ספרים | ~70% | Product+Book schema **חסרים לגמרי**; אקורדיון "קטע לקריאה" בספרים לא ממומש (מוצג פתוח); שבירות שורה ידניות ב"וכתבת" נמחקו; 3 איותים שונים לספר "צבע בכחול" |
| אודות/מוקש/אנגלית/צור קשר | ~75% | **עדכון 2026 למוקש כבר קיים במלואו, מילה במילה — לא צריך תוכן חדש מאייל.** הפער האמיתי: אין embed בפועל לוידאו הטריילר (קיים בקוד מת), ואין Person schema למוקש. עמוד אנגלית מסומן בקוד עצמו כ"ממתין לתוכן סופי מאייל". |

---

## 2. תיקון לדוח הקודם (INTAKE מ-12/7)

בדוח הראשון סימנתי (C2) שעדכון 2026 לעמוד ההנצחה למוקש הוא "תוכן רגיש שצריך ניסוח מאושר מאייל". **זה שגוי — התוכן כבר קיים, מילה במילה**, כולל כל שלושת הביטויים הרגישים ("מוזנח", "אכול טרמיטים", "מאורת שיכורים") ב-`inc/chapters/defaults/mokesh-defaults.php:236`. אין צורך לבקש מאייל ניסוח חדש — **רק לוודא איתו שהוא עדיין מאשר את הניסוח הקיים לפני שממשיכים לבנות עליו** (embed וידאו, Schema וכו').

---

## 3. סעיפים לדיון — מסווגים לפי הכלל שלך

### 3.A — תוכן (Content) → לפי אייל

| # | נושא | המסמכים אומרים | קיים כרגע | לדיון |
|---|---|---|---|---|
| 1 | Meta descriptions כמעט בכל עמוד | ניסוח ספציפי לכל עמוד (SEO doc) | ניסוח **שונה** בפועל בכל עמוד שנבדק (home, treatment, method, sound-healing, lessons, faq, repair) — נזרע פעם אחת ע"י `ea-m3-team80-placeholder-content-once.php` / `ea-w2-17-metadesc-backfill-once.php`, לא עודכן מול הדוח של אייל | האם ניסוח ה-meta description הוא "תוכן" (אייל) או "SEO טכני" (אנחנו)? יש כאן אזור אפור — מומלץ להכריע עקרונית פעם אחת, לא עמוד-עמוד |
| 2 | H1/H2 wording במספר עמודים | ניסוחים מדויקים (home, treatment, method, lessons) | קרוב אך לא זהה כמעט בכל מקום (למשל method H1 מוסיף "של אייל עמית") | לפי אייל אם הוא רוצה נוסח מדויק; לרוב הפרש קוסמטי |
| 3 | "מהנדס אלקטרוניקה" על עמוד /repair | ה-SEO doc מבקש למקם את אייל כך בדיוק על עמוד התיקונים | הניסוח הזה קיים ב-4 עמודים אחרים (about, didgeridoos, muzza, kushi-blantis) אבל **לא** ב-repair עצמו | האם להוסיף שם גם — ניסוח, לא מבנה |
| 4 | ניסוח "לא מכשיר רפואי" מול "מכשיר פיזיותרפי" | כבר עלה ב-AOS_DECIDE Q2 — עדיין פתוח | — | ממתין להכרעתך |
| 5 | וידוא עם אייל: עדכון 2026 למוקש עדיין מאושר כפי שכתוב | — | כבר קיים מילה-במילה (סעיף 2 למעלה) | לא תוכן חדש — רק אישור שהניסוח הקיים בתוקף |

### 3.B — עיצוב/קוד/מבנה עמוד (Design/Code/Structure) → ברירת מחדל שלנו, אך לבחון כל סעיף

| # | נושא | חסר/שונה | המלצת team_100 |
|---|---|---|---|
| 1 | **החלטת ארכיטקטורה עצמאית: איחוד Wave2/Chapters** | שתי מערכות מקבילות, בלבול ניתוב, קוד מת עם רכיבים טובים (וידאו מוקש, קרוסלת testimonials) | להכריע קודם על זה — לפני שממשיכים לדון בפערים הספציפיים, כי חלק מהם ייפתרו אוטומטית ברגע שמאחדים מערכת |
| 2 | דף הבית — סעיף 03 (וידאו) | חסר לגמרי, רק hero-background-loop קיים | לבנות (רכיב `videoblk.php` כבר קיים ומשמש את /treatment — ניתן לעשות reuse) |
| 3 | דף הבית — Trust Line ב-Hero | קיים בעמוד, לא במקום הנכון (לא ב-Hero, לא מעל הקיפול) | להזיז שדה קיים, לא לכתוב טקסט חדש |
| 4 | שמות ממליצים לחיצים בקרוסלה | ה-href כבר קיים בdata source, פשוט לא מחובר ל-markup | Quick fix — נתונים קיימים |
| 5 | קרוסלת 8 כרטיסים ל-/method | הרכיב `testimonials.php` כבר בשימוש ב-/treatment — פשוט לא מחובר ל-/method | Quick fix |
| 6 | FAQPage schema | חסר **לגמרי** באתר (0 hits בקוד), הדוח מגדיר "חובה" | לבנות — Schema.org טכני, אין כאן תלות באייל |
| 7 | Book schema + Product schema | חסרים **לגמרי** | לבנות |
| 8 | Course schema ל-/lessons | קיים רק Service גנרי | לשדרג לטיפוס Course |
| 9 | Person schema למוקש | חסר לגמרי (רק VideoObject בקוד מת) | לבנות, יחד עם פתרון סעיף 1 (איחוד מערכות) |
| 10 | אקורדיון "קטע לקריאה" בעמודי ספרים | מוצג פתוח לצמיתות, לא כ-`<details>` סוגר כמו ב-FAQ | הרכיב הנכון (`faq.php` accordion) כבר קיים באתר — reuse |
| 11 | שבירות שורה ידניות ב"וכתבת" (10 דברים) | נמחקו בבנייה, הפכו לפסקה רציפה | לתקן — טכני, לא תוכן (המילים עצמן לא השתנו) |
| 12 | וידאו lazy-load בדף הבית | יש `autoplay` בפועל (הפוך מהדרישה) | לתקן — Core Web Vitals |
| 13 | גופן FAQ במובייל מתחת ל-16px בעמוד ה-FAQ הראשי (14.4px) | ה-mini-FAQ המוטמעים בעמודי שירות כן עומדים בדרישה — רק העמוד המרכזי לא | Quick CSS fix |
| 14 | קישורי "לימוד והכשרה" בתפריט (הכשרות/קורסים/הרצאות/סדנאות) | כל 4 הקישורים ב-Chapters נav הם `href="#"` מתים | להחליט: יש כבר תוכן אמיתי בקוד ה-Wave2 המקביל (3/4 יש, 1 ממתין ל-URL חיצוני מאייל) — ניתן לחבר | (יש כאן גם תלות תוכן חלקית — "קורסים" ממתין ל-URL מאייל לפי הערה בקוד) |
| 15 | Footer medical disclaimer גלובלי | קיים רק כתוכן-עמוד ב-2 עמודים, לא ב-footer עצמו | להחליט אם להעביר ל-footer רוחבי (כמו ב-Wave2 legacy) או להשאיר כמות שהוא |
| 16 | דף `/faq` — קטגוריות (10 קטגוריות מוצר/שירות) מול "רפואי/טכני/לוגיסטי/כלים" | לא תואם בכלל לתיאור המקורי מהמסמך (וגם לא תואם במדויק את FAQ FINAL.md המקורי — הוא מקבץ 2 קטגוריות מקור ל-"general" אחד) | לבחון מול FAQ FINAL.md המקורי (לא מול התיאור הכללי) |
| 17 | slug של הספר "צבע בכחול" — 3 איותים שונים | `tsva-bekahol` (קוד) / `tzava-be-kachol` (SEO doc) / `tsva-bechol-ve-zorek-layam` תחת `/muzeh/` (QA doc מקור) | להכריע איות אחד קנוני |
| 18 | סלאגים מקוננים (`/books/kushi-blantis/`) מול שטוחים (`/kushi-blantis`) | SEO doc מבקש שטוח, בקוד זה מקונן תחת `/books/` | להחליט אם משנים מבנה URL (משפיע על redirects אם כבר בפרודקשן) |
| 19 | `/mokesh-dahiman` שטוח מול `/eyal-amit/mokesh-dahiman/` מקונן | דומה לסעיף 18 — כבר יש 301 redirect מהשטוח למקונן | סביר שזה כבר פתור (ה-redirect קיים), רק לוודא |

### 3.C — "New-Ask" אמיתי (לא קיים כלל, לא רק שונה)

- דף `/snoring-sleep-apnea` עצמו — כבר בטיפול (CP-01, האינטייק הקודם).
- FAQPage schema, Book schema, Product schema, Course schema — ראו 3.B.
- וידאו section בדף הבית — ראו 3.B.
- Person schema למוקש — ראו 3.B.
- "Micro" hero layer בעמוד השיעורים (Hero H1→Sub→Micro→CTA) — שדה כזה לא קיים בכלל במערכת ה-Chapters.

---

## 4. נספח — טבלאות מלאות מכל 6 הסוכנים

הטבלאות המלאות (כולל כל file:line ציטוט) נשמרו בפלט הסוכנים בתמליל הסשן. אם תרצו אותן כקובץ נספח נפרד למסך/הדפסה לקראת הדיון — תגידו ואפיק קובץ ייעודי (יהיה ארוך, ~19 עמודים מודפסים).

---

*נכתב על ידי team_100. אין שינויי קוד/אתר בסשן זה — קריאה, השוואה וניתוח בלבד, ב-6 סוכני Explore מקבילים שקראו את קוד ה-theme בפועל.*
