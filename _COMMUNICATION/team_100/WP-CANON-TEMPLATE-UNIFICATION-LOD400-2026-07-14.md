---
id: WP-CANON-TEMPLATE-UNIFICATION-LOD400-2026-07-14
from_team: team_100
to_team: team_00
date: 2026-07-14
type: wp-build-spec
wp: WP-CANON-TEMPLATE-UNIFICATION
lod_status: LOD400
lod_target: LOD400
parent_lod300: _COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md
authoring_team: team_100
consuming_team: team_110
authorized_by: "team_00 (נמרוד), בצ'אט 14/7: 'ולידציה מול קומפוזר - אחרי pass מלא - ממשיכים' — אישור מפורש להתחיל Phase 2 (LOD400), לאחר שהוכרעו כל 3 השאלות הפתוחות של LOD300 (§4 שם)."
gate_status: "עודכן 14/7 — ולידציה חוצת-מנוע ראשונה: FAIL (F90-01/02/03 + 4 minor). תוקן. delta-validation שנייה: PASS_WITH_FINDINGS — F90-01..07 סגורים, ממצא אופציונלי אחד (D90-01) גם תוקן. LOD400 build-ready מבחינת team_90. עדיין כמה החלטות-משנה קטנות ממתינות ל-team_00 (§0.2) — לא חוסמות build, חוסמות רק את סגירת T6 בפועל (במיוחד §0.2 החלטה 1: tpl-home.php/stage-b)."
---

# LOD400 — WP-CANON-TEMPLATE-UNIFICATION: מפרט בנייה מלא (Wave2 → Chapters)

## 0. מטרת המסמך, מבנה, ומתודולוגיה

זהו **שלב 2 מתוך 2** של WP-CANON-TEMPLATE-UNIFICATION — מפרט בנייה מלא, ברמת קובץ/פונקציה/שורה, לכל 8 המשימות (T1, T2, T3, T3b, T4, T5, T6, T7), בהמשך ישיר ל-LOD300 (`WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md`) ולשלוש ההכרעות ש-team_00 קיבל בו (§4 שם: many-to-many ל-FAQ; שיקול-דעת הנדסי לטריילר מוקש; אילוץ-URL קשיח ל-`/qr`).

**הרף שהמסמך הזה נמדד מולו** — team_100 קבע אותו לעצמו כסמכות-ולידציה (`_aos/governance/team_100.md`): *"לוודא שכל spec מפורט מספיק כדי שכל מפתח ג'וניור או agent טרי יוכל לממש בלי פערים, ניחושים או הנחות."* בשונה מ-LOD300 (שאסר במפורש שמות-פונקציה/מספרי-שורה בגוף), LOD400 **דורש** את הפירוט הזה — זה כל הטעם של השלב.

**איך נבנה המסמך:** שישה תת-מסמכים נחקרו ונכתבו במקביל, כל אחד ע"י מחקר-קוד עצמאי וישיר בריפו (grep מדויק, קריאת קבצים מלאה, בדיקות חיות מול staging דרך `qa_probe.mjs`/curl) — לא הרחבה של הנחות LOD300 בלי אימות חוזר:

| חלק | משימות | קובץ מקור |
|---|---|---|
| §1 | T1 — מדיה מוקש דהימן | `lod400-T1-mokesh.md` |
| §2 | T2 — FAQ many-to-many | `lod400-T2-faq.md` |
| §3 | T3 — תבנית מוצר | `lod400-T3-product.md` |
| §4 | T3b — עמודי ספרים | `lod400-T3b-books.md` |
| §5 | T4 + T5 — schema, `/shop`, `/qr` | `lod400-T4-T5-schema-routes.md` |
| §6 | T6 + T7 — מחיקת Wave2, QA | `lod400-T6-T7-cleanup-qa.md` |

**המחקר המקביל הזה העלה ממצאים מהותיים שחורגים מעבר ל"מילוי פרטים" ל-LOD300 — חלקם מתקנים אותו.** §0.1-§0.3 למטה הם **קריאת-חובה** לפני שאר המסמך — הם מרכזים את מה ש-team_00 צריך לדעת בלי לקרוא ~2,600 שורות של מפרט מפורט, ואת ההחלטות שעדיין פתוחות.

---

### 0.1 ממצאים חדשים שמתקנים את LOD300 (לא רק מרחיבים אותו)

| # | ממצא | היכן | משמעות |
|---|---|---|---|
| **F-1** | **LOD300 §7 (נספח ראיות T6) לא היה שלם.** 9 תיקונים/תוספות (D-1 עד D-9 ב-§6.2 למטה) — הכי משמעותיים: (א) `wave2-w2-09.php` **אינו** ראוטר-תבנית כמו "אחיו" — הוא תשתית SEO חיה כלל-אתרית (favicon + meta-description fallback) שמחיקתה תשבור את הפאביקון **בכל האתר**; (ב) `wave2-stage-b.php` הוא תלות-אסטים משותפת ש-**Chapters עצמה שואבת ממנה היום בפועל** (אומת חי: `/treatment/` טוען גם `chapters.css` וגם `ea-tokens.css`); (ג) `wave2-w2-02.php` נושא 5 חוקי 301-redirect חיים שלא כפולים במקום אחר. | §6 (T6), §0.2 החלטה 1 | סדר-המחיקה של T6 השתנה מהותית לעומת "מחקו את כל 12/13 הקבצים ברצף" — ר' §6.2-§6.3. |
| **F-2** | **פער-scope אמיתי: `/press` אין לו בעלים באף אחד מ-8 המשימות.** אותו קובץ שמנתב את `/qr` (`inc/wave2-w2-07.php`) מנתב גם `/press`, אבל `/press` אינו מוזכר ב-LOD200/LOD300 כלל, ואינו ב-route map של Chapters. | §6.2 (D-9), §0.2 החלטה 2 | דורש הכרעה קטנה: לפתוח מעקב נפרד (מומלץ) או להרחיב את T5. |
| **F-3** | **T2 תיקן שני פרטים ב-LOD300 עצמו:** המאגר המרכזי מכיל **79** שאלות, לא "~62"; ולעמוד `lessons` **יש** section FAQ כבר היום (בנוי כפרוזה, לא כאקורדיון) — LOD300 C-4 טעה בקביעה "אין section FAQ בכלל". המשמעות המעשית: `lessons` מצטרף לפורט הרגיל של 11 העמודים (לא נשאר מקרה-קצה נפרד), רק `method` נשאר יוצא-דופן אמיתי. | §2 (T2) §0 | לא משנה החלטה — משנה רק את גודל/צורת העבודה. |
| **F-4** | **באג קיים, לא-קשור-ל-WP-הזה, שחוסם קריטריון-קבלה של T3:** `ea-ab-testing.js` נטען פעמיים בכל 6 עמודי W2-05 היום (כולל `/shop`) — גורם כבר עכשיו לקליק כפול על כפתור ה-WhatsApp הצף. תוקן כתיקון-מקדים בתוך T3 עצמה (שורה אחת, §3 §2.4). | §3 (T3) §2.4 | לא דורש הכרעה — כבר כלול בספסיפיקציה כתיקון-חובה. |
| **F-5** | **`/qr` — הבשורה הטובה: המכשול הארכיטקטוני המשוער ב-LOD300 לא קיים בפועל.** 48 עמודי ה-QR הם עמודי WordPress אמיתיים עם permalink-היררכי סטנדרטי (`post_parent`+`post_name`) — **אין שום rewrite rule מותאם-אישית באתר**. המשמעות: מנגנון "pattern-route" חדש (§5, T5) יכול להבטיח שימור-URL **מבנית**, לא רק "נבדק ועבד" — כי הוא אף פעם לא נוגע ב-`post_name`/`post_parent`, רק קובע איזה template מרנדר. **דיוק (ולידציה חוצת-מנוע 14/7, F90-05):** ה"הבטחה המבנית" תלויה בכך ששורות-העמוד ב-DB ומבנה ה-permalinks לא משתנים ע"י מישהו אחר — לא הבטחה בלתי-תלויה-בכלום; ר' T5 §4.3. | §5 (T5) §4 | האילוץ הקשיח של team_00 (LOD300 §4 Q3) ניתן למימוש נקי, לא רק "מגבלה שצריך לעקוף". |

### 0.2 החלטות קטנות שעדיין פתוחות (לא חוסמות את הגשת המסמך לולידציה)

בניגוד לשלוש השאלות הפתוחות של LOD300 (שם ההחלטה השפיעה על צורת-הבנייה עצמה), אלה **החלטות-סקופ/סיכון קטנות** שהתגלו תוך כדי כתיבת ה-LOD400 — team_100 ממליץ המלצה מפורשת בכל אחת, וממשיך לבנות לפיה, אבל הן דורשות אישור קצר לפני שT6 (מחיקה בפועל) נסגר:

| # | החלטה | המלצת team_100 | חוסם? |
|---|---|---|---|
| 1 | `tpl-home.php` + `wave2-stage-b.php` (מנגנון ה-rollback, F-1): הקפאה-ובידוד (לשמר כארטיפקט חירום קפוא, לא מקור-אמת חי) מול שחזור-Chapters-native מלא מול מחיקה-בסיכון-מקובל | **הקפאה-ובידוד** — עלות נמוכה, רשת-ביטחון אמיתית ל-production חי (ר' §6.3) | לא לתחילת הבנייה; **כן** לפני שT6 סוגר את `tpl-home.php`/`stage-b` בפועל |
| 2 | `/press` (F-2): לפתוח מעקב/WP נפרד ולא לחסום T6, מול להרחיב את T5 עכשיו כדי לכלול אותו | **מעקב נפרד, לא לחסום** — `/press` לא היה בסקופ המקורי, וזו תוספת אמיתית לא רק ניקוי | לא — T6 יכול להתקדם במלואו למעט `wave2-w2-07.php` (שנשאר עד `/press` ייפתר בנפרד) |
| 3 | קבלה מפורשת ש-T6 לא יהיה "100% מחיקת Wave2" במחזור הזה (בגלל #2) | **לקבל, מתועד ב-roadmap.yaml** | לא |
| 4 | `/qr` hub page (עמוד `/qr/` עצמו, ריק לגמרי היום): לבנות רשת-קישורים אמיתית לכל 48 העמודים (שיפור-תוכן קטן, סיכון אפסי) מול להשאיר ריק (פורט טהור) | **לבנות את הרשת** — עלות זניחה, שימוש חוזר מלא ב-`bookcard.php` הקיים | לא |

**איך אני ממשיך:** בונה לפי ההמלצות למעלה (זהה לרוח שבה team_00 האציל את Q2 ב-LOD300 — "שיקול-דעת הנדסי"), ומסמן את כל השורות הרלוונטיות בקוד/במסמך בבירור כך שאפשר לשנות כיוון בלי לחפש. החלטה #1 בלבד דורשת חתימה קצרה ומפורשת של team_00 לפני שT6 בפועל נוגע ב-`tpl-home.php`.

### 0.3 סדר-תלויות בין המשימות (למי שבונה בפועל)

```
T1 ─────────────────────────────────────┐
T2 ──┬── (חוזה: ea_faq_query_items) ──► T4 (FAQPage)
     │
T3b ─┴── (חוזה: ea_chapters_field)  ──► T4 (Book)
T3 ──────────────────────────────────────┤
T5 (shop, qr) ── עצמאי, יכול לרוץ מיידית ┤
                                          ▼
                          T6 (מחיקה) ── שער-כניסה: T1,T2,T3,T3b,T5 בנויים+PASS
                                          ▼
                                     T7 (QA מלא)
```

T5 (גם `/shop` וגם `/qr`) **אינו** תלוי בכלום — יכול להתחיל היום. T4 חסום עד ש-T2 ו-T3b נועלים חוזה-נתונים סופי. T6 הוא שער-סגירה — לא מתחיל לפני שכל השאר PASS מתועד (ר' §6.3 שער-כניסה מלא).

### 0.4 יומן-תיקונים — סבב ולידציה חוצת-מנוע ראשון (14/7)

`team_90` (cursor-composer) בדק את הטיוטה המקורית של המסמך הזה מול הקוד החי, ב-2 ריצות עצמאיות (אחת ע"י team_00 ישירות, אחת ע"י team_100 — ר' `_COMMUNICATION/team_90/VERDICT-WP-CANON-LOD400-2026-07-14.md`) — **verdict: FAIL**, 2 blockers + 1 major + 4 minor. כל 7 הממצאים תוקנו **בתוך** המסמך הזה (לא סבב-כתיבה נפרד):

| # | חומרה | מה נמצא | איפה תוקן |
|---|---|---|---|
| F90-01 | **blocker** | T6 מוחקת `wave2-w2-05.php` בלי לשמר 3 פונקציות-accessor ש-`product-cta.php` (T3) קורא להן ישירות — קריסה `Call to undefined function` בכל 5 עמודי המוצר | §3.5.5 (T6, קובץ חדש `chapters-commerce.php`) |
| F90-02 | **blocker** | T6 מוחקת `wave2-w2-03.php` בלי לשמר את ה-enqueue של מעקב GA4 — אובדן-שקט של `book_purchase_click` בכל 3 עמודי הספר | §3.5.5 (T6, אותו קובץ) |
| F90-03 | major | T4 (Book schema) מניח שדות (`price`/`genre`/URLs) שT3b מעולם לא סיפקה כשדות נפרדים — רק כטקסט-כפתור | §3.0.f + §3.1/3.2/3.3 (T3b, שדות חדשים) + §2.3 (T4, חוזה נעול) |
| F90-04 | minor | T4 קורא לפונקציה בשם placeholder (`ea_chapters_faq_items`) שלא קיימת — T2 בנה `ea_faq_query_items` | §2.2 (T4) |
| F90-05 | minor | ניסוח "לנצח/מבנית" ל-`/qr` הוצג כמוחלט מדי | §0.1 F-5, T5 §4.3, T5 מטרות |
| F90-06 | minor (אופציונלי) | ציטוט שורה `234-242` — בפועל `234-241` | T3, T4 |
| F90-07 | minor | T4/T7 עדיין ציטטו "~62 שאלות" ו-"lessons ללא FAQ" — נוסח שT2 עצמה כבר תיקנה (§0 שם) | §2.2 (T4), §5.3 (T7) |

**מצב אחרי התיקון:** delta-validation של team_90 חזרה `PASS_WITH_FINDINGS` — F90-01/02/03 (וגם F90-04..07) **סגורים**. ממצא נוסף אחד, קטן ואופציונלי, עלה בסבב הזה: `ea_wave2_wa_url()` ב-§3.5.5 סומן "verbatim" אך בפועל פושט (חסר default-message + הקבוע `EA_WAVE2_WHATSAPP_E164`) — לא משפיע על 5 עמודי המוצר (שתמיד מעבירים הודעה מפורשת), אך יכול להשפיע על קוראים-בלי-ארגומנט אחרים כמו כפתור ה-WhatsApp הצף. **תוקן** — הפונקציה עכשיו verbatim באמת. **תוקן גם באופן עצמאי (לא ע"י team_90):** ל-4 הפונקציות ב-§3.5.5 נוספו `function_exists()`/`defined()` guards — המקור אין לו, אבל בלעדיהם, חלון-המעבר שבו `chapters-commerce.php` ו-`wave2-w2-05.php`/`wave2-stage-b.php` טעונים בו-זמנית (בדיוק מה ש-§3.6 דורשת: ליצור את הראשון "לפני" מחיקת השני) היה גורם ל-PHP fatal "Cannot redeclare function" — לא כפילות תמימה.

---

# T1 — פורט מדיה של עמוד מוקש דהימן (LOD400)

> ממשיך ישיר את LOD300 §2 T1. כל ההחלטות שכבר הוכרעו שם (מיקום הגלריה/הטריילר במוקאפ המאושר, האצלת ההכרעה הטכנית של רכיב הווידאו לשיקול-דעת הנדסי) **לא** נפתחות מחדש כאן — הן מיושמות. המסמך הזה קובע קבצים, פונקציות, שורות וקוד מדויקים, לפי הרף שteam_100 עצמו קבע: "לוודא שכל spec מפורט מספיק כדי שכל מפתח ג'וניור או agent טרי יוכל לממש בלי פערים, ניחושים או הנחות".

## 0. תקציר מנהלים

מוקש דהימן טקסטואלי לגמרי היום ב-Chapters (20 סעיפים, 7 מתוך 19 תמונות המקור מפוזרות בתוך הטקסט, אפס טריילר, אפס גלריה, אפס פייסבוק, אפס schema). המשימה: להשתיל את שכבת המדיה של Wave2 (`inc/wave2-w2-14e.php`) לתוך `inc/chapters/defaults/mokesh-defaults.php`, **לא** כהעתקה 1:1 אלא במבנה הילידי (native) של Chapters — ולבנות Person schema חדש למוקש שלא קיים היום באף גרסה.

בעומק המחקר לקראת ה-LOD400 הזה עלו **שני ממצאים לא-טריוויאליים** שמשנים את אופן היישום (לא את התוצאה המאושרת):

1. **הקריאה ל-hero הכללי (`phero.php`) קשיחה בקוד**, לא מונעת-נתונים — `page-templates/tpl-chapters-page.php:43` קורא ל-`template-parts/chapters/parts/phero` בשם קבוע, לא לפי שדה במערך. המשמעות: איך שלא תוכרע השאלה הטכנית (הרחבה/ייעודי), **נדרש template חדש** לעמוד מוקש (`tpl-chapters-mokesh.php`) — יש לכך תקדים ישיר וכבר-קיים בקוד (`tpl-chapters-method.php`, `tpl-chapters-en.php`). ר' §3.
2. **איסור SEO קיים ומתועד: "no VideoObject on the muted hero loop"** (`SEO-GEO-EXECUTION-PLAN-2026-06-20.md:74`, אוכף אוטומטית ע"י `scripts/qa/seo_probe.mjs` Check 9 — "prohibition lint"). מיקום הטריילר שאושר במוקאפ (בתוך ה-hero) מתנגש, לכאורה, עם המדיניות הזו. ר' §3.4 לפתרון המוצע.

שני הממצאים האלה **לא** דורשים חזרה ל-team_00 — הם ברמת ביצוע (LOD400), נופלים תחת "שיקול-דעת הנדסי" שכבר הואצל (§4 Q2 ב-LOD300), ונפתרים כאן במפורש עם נימוק, לא בשתיקה.

## 1. מטרה

להשתיל את שכבת המדיה המלאה של עמוד ההנצחה למוקש דהימן (טריילר יוטיוב, גלריית 19 תמונות, 4 הטמעות פייסבוק, VideoObject schema) מ-Wave2 (`inc/wave2-w2-14e.php`) לתוך המבנה הילידי של Chapters (`inc/chapters/defaults/mokesh-defaults.php` + רכיבי `template-parts/chapters/parts/`), ולבנות Person schema חדש למוקש — כך ש-`/eyal-amit/mokesh-dahiman/` יגיע לשוויון-תכונות מלא מול הגרסה שכבר קיימת (ומוצללת) ב-Wave2, בלי תלות בקבצי Wave2 שb-T6 עתידים להימחק.

## 2. קבצים ליצירה/שינוי

### 2.1 טבלת סיכום

| # | קובץ | פעולה | למה |
|---|---|---|---|
| 1 | `template-parts/chapters/parts/mokesh-hero.php` | **חדש** | hero ייעודי לעמוד מוקש — וריאנט וידאו של `phero.php` |
| 2 | `template-parts/chapters/parts/fbembeds.php` | **חדש** | רכיב Chapters גנרי חדש — רשת הטמעות פייסבוק |
| 3 | `page-templates/tpl-chapters-mokesh.php` | **חדש** | קלון של `tpl-chapters-page.php`, שורה אחת שונה |
| 4 | `assets/js/ea-mokesh.js` | שינוי (2 שורות) | סלקטור CSS מתעדכן ל-class החדש |
| 5 | `inc/chapters/defaults/mokesh-defaults.php` | שינוי (נתונים) | `phero` מקבל `yt_id`; 2 סעיפים חדשים מוכנסים |
| 6 | `inc/chapters/chapters-enqueue.php` | שינוי (הוספת פונקציה) | enqueue מתוזמן ל-`ea-mokesh.js`, מקושר ל-Chapters לא ל-Wave2 |
| 7 | `assets/css/chapters.css` | שינוי (הוספה בסוף) | 2 בלוקים חדשים: hero-וידאו + fbgrid |
| 8 | `inc/chapters/chapters-render.php` | שינוי (שורה 49) | route map — template של מוקש |
| 9 | `site/wp-content/mu-plugins/ea-w2-seo-schema.php` | שינוי (הוספת בלוק) | Person(מוקש) + VideoObject, gated לעמוד מוקש בלבד |
| 10 | `scripts/qa/seo_probe.config.json` | שינוי (הוספת route) | מאניפסט QA לא מכיר כרגע ב-mokesh-dahiman כלל |

**לא נוגעים:** `inc/wave2-w2-14e.php`, `mu-plugins/ea-w2-14e-mokesh-media-seed-once.php` — אלה קבצי-מקור ל-porting בלבד, מחיקתם היא T6. `template-parts/chapters/parts/gallery.php` — נעשה בו שימוש חוזר **ללא שינוי** (אימות: תומך ב-19 items ישירות, כולל breakpoints רספונסיביים קיימים ב-`chapters.css:683-684`). אין שדות ACF חדשים לרשום — כל משפחת `tpl-chapters-page.php`/`tpl-chapters-mokesh.php` קוראת ישירות ממערך ה-defaults (`$ea_d['phero']`, `$ea_d['sections']`), לא דרך `ea_chapters_field()`/`ea_chapters_rows()` — כך שאין נתיב ACF חי לעמוד הזה כלל, היום ואחרי השינוי.

### 2.2 קובץ חדש #1 — `template-parts/chapters/parts/mokesh-hero.php`

וריאנט-וידאו ל-`phero.php`, **לא** תוספת לרכיב הכללי (ר' נימוק מלא ב-§3). משתמש ב-classes קיימים של `.phero`/`.phero--media` (אפס CSS חדש בשבילם) + 3 classes חדשים וממוקדי-עמוד (`mokesh-hero`, `mokesh-hero__yt`, `mokesh-hero__unmute`).

**מבנה ה-DOM קריטי:** ה-mount של YouTube (`#ea-mokesh-trailer`) חייב להיות **בתוך wrapper נפרד** (`.mokesh-hero__yt`), לא לשאת את ה-class ישירות על עצמו. הסיבה: YouTube IFrame API **מחליף** את האלמנט המקורי ב-`<iframe>` חדש (לא מוסיף iframe בתוכו) — אם ה-class יישב ישירות על ה-mount, הוא ייעלם ברגע ש-JS מחליף את האלמנט, וטריק ה-cover-fill ב-CSS (§2.8) יפסיק לעבוד. זו בדיוק המבנה ש-Wave2 כבר פתר נכון (`inc/wave2-w2-14e.php:471-473`: `<div class="ea-mem-hero__media"><div id="ea-mokesh-trailer">…</div></div>`) — מפר את זה תוך "פישוט" ל-div בודד היא תקלה שקטה קלאסית.

```php
<?php
/**
 * Chapters part — Mokesh memorial hero (video variant of .phero--media). Page-specific,
 * NOT a generic reusable part — see LOD400 T1 §3 for the extend-vs-bespoke rationale.
 * $args: chap, title (limited HTML via ea_chapters_kses_e), sub, media (poster/fallback
 * image url — ALSO the no-JS/reduced-motion/API-blocked fallback), media_alt, yt_id.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$media = $a['media'] ?? '';
$yt_id = $a['yt_id'] ?? '';
?>
<header class="phero phero--media mokesh-hero">
	<?php if ( $media ) : ?>
		<img class="phero__media" src="<?php echo esc_url( $media ); ?>" alt="<?php echo esc_attr( $a['media_alt'] ?? '' ); ?>">
	<?php endif; ?>
	<?php if ( $yt_id ) : ?>
		<div class="mokesh-hero__yt" aria-hidden="true">
			<div id="ea-mokesh-trailer" data-ytid="<?php echo esc_attr( $yt_id ); ?>"></div>
		</div>
	<?php endif; ?>
	<span class="phero__sc" aria-hidden="true"></span>
	<span class="arcs" aria-hidden="true"></span>
	<div class="phero__in">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<h1 class="phero__h"><?php ea_chapters_kses_e( $a['title'] ?? '' ); ?></h1>
		<?php if ( ! empty( $a['sub'] ) ) : ?><p class="phero__s"><?php echo esc_html( $a['sub'] ); ?></p><?php endif; ?>
	</div>
	<?php if ( $yt_id ) : ?>
		<button type="button" class="mokesh-hero__unmute" data-ea-mokesh-unmute aria-pressed="false" hidden>
			<span class="mokesh-hero__unmute-icon" aria-hidden="true"></span>
			<span class="mokesh-hero__unmute-label">הפעלת קול</span>
		</button>
	<?php endif; ?>
</header>
```

הבדל מכוון מ-`phero.php` המקורי: **אין** `.phero__media-cue` (חץ-גלילה) — Wave2 גם לא היה לו אחד ב-hero הזה; לא נוסף.

### 2.3 קובץ חדש #2 — `template-parts/chapters/parts/fbembeds.php`

נבנה **גנרי** (לא ממוקד-מוקש), במקביל-מכוון ל-`gallery.php` (args זהים: `chap/title/lead/alt/id/items[]`) — למרות שהצרכן היחיד היום הוא מוקש. הנימוק שונה מהנימוק ל-hero (ר' §3.3): אין כאן "מס הפשטה" אמיתי — התבנית (רשת iframes ברוחב קבוע) פשוטה מספיק שגנריות לא עולה כלום, בניגוד לווידאו שם multi-provider הוא בעיה אמיתית.

**חשוב:** ה-iframe **לא** עובר דרך `wp_kses_post()` — kses מסיר תגי `<iframe>` כברירת מחדל. המרקאפ נכתב ישירות ב-PHP (בדיוק כמו ב-Wave2 המקורי, `inc/wave2-w2-14e.php:562`); רק ה-`href` הדינמי עובר `rawurlencode()` לפני הכנסה ל-query string.

```php
<?php
/**
 * Chapters part — Facebook post embeds grid (.fbgrid). $args: chap, title, lead,
 * alt (bg tint, default true — matches gallery.php's own default), id, items[ { href, title } ].
 * Built generically (mirrors gallery.php's contract) though today's only consumer is
 * mokesh-defaults.php (4 posts, WP-CANON T1).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
$alt   = array_key_exists( 'alt', $a ) ? ! empty( $a['alt'] ) : true;
?>
<section class="sec<?php echo $alt ? ' sec--alt' : ''; ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap center">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap chap--c r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
		<?php if ( ! empty( $a['lead'] ) ) : ?><p class="lead r" style="margin-top:14px"><?php echo esc_html( $a['lead'] ); ?></p><?php endif; ?>
		<div class="fbgrid r">
			<?php
			foreach ( $items as $it ) :
				$href = $it['href'] ?? '';
				if ( ! $href ) {
					continue;
				}
				?>
				<div class="fbgrid__item">
					<iframe class="fbgrid__frame" src="https://www.facebook.com/plugins/post.php?href=<?php echo rawurlencode( $href ); ?>&amp;show_text=true&amp;width=500&amp;locale=he_IL" width="500" height="640" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" loading="lazy" title="<?php echo esc_attr( $it['title'] ?? 'פוסט פייסבוק' ); ?>"></iframe>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
```

### 2.4 קובץ חדש #3 — `page-templates/tpl-chapters-mokesh.php`

קלון מדויק של `page-templates/tpl-chapters-page.php` (67 שורות). **שינוי יחיד בפועל** בלולאת הרינדור: שורה 43 המקורית

```php
get_template_part( 'template-parts/chapters/parts/phero', null, $ea_phero );
```

הופכת ל-

```php
get_template_part( 'template-parts/chapters/parts/mokesh-hero', null, $ea_phero );
```

כל שאר הקובץ (nav, לולאת ה-sections הגנרית שמפעילה `gallery`/`fbembeds`/`prose`/`split`/`timeline`/`bleed` לפי `'part'` שבמערך, footer) **זהה מילה-במילה**. בנוסף: להוסיף בראש הקובץ `$GLOBALS['ea_chapters_type'] = 'mokesh';` (הגנתי — לא נדרש בפועל כי `ea_chapters_type()` כבר פותר את זה נכון דרך ה-route map, אבל תואם את התקדים ב-`tpl-chapters-method.php:16`), ולעדכן את ה-doc comment + `Template Name:` header (`Template Name: פרקים — מוקש דהימן (Chapters Memorial)`) כך ש-WP-admin יציג שם משמעותי אם מישהו יבחר template ידנית.

**תקדים לדפוס הזה (קובץ template ייעודי לroute בודד) כבר קיים בקוד היום** — `tpl-chapters-method.php` ו-`tpl-chapters-en.php`, שניהם רשומים ב-`ea_chapters_route_map()` עם `template` שונה מ-`tpl-chapters-page`. אין כאן המצאת דפוס חדש.

**מנגנון הניתוב עצמו לא משתנה כלל** — `inc/chapters/chapters-routing.php:18-37` (`ea_chapters_template_include()`) כבר עושה `locate_template('page-templates/' . $map[$slug]['template'] . '.php')` לפי מה שה-route map מחזיר; שינוי הערך במפה (§2.9) מספיק, בלי לגעת בקובץ הניתוב עצמו.

### 2.5 שינוי #4 — `assets/js/ea-mokesh.js` (2 שורות)

הקובץ **נשאר באותו שם ובאותו מיקום** — מותאם, לא מוחלף. שתי שורות בלבד דורשות שינוי (שאר 129 השורות **ללא שינוי**, כולל ה-guard ל-`prefers-reduced-motion`, לוגיקת ה-unmute, וה-loader של ה-IFrame API):

| שורה | היום | אחרי |
|---|---|---|
| 33 | `var hero = mount.closest('.ea-mem-hero');` | `var hero = mount.closest('.mokesh-hero');` |
| 96 | `hero.classList.add('ea-mem-hero--playing');` | `hero.classList.add('mokesh-hero--playing');` |

(אימות: `.ea-mem-hero--playing` לא מוגדר באף מקום ב-CSS — hook רדום גם היום; הפורט שומר על אותה תכונה, לא מוסיף ולא מסיר תלות.)

### 2.6 שינוי #5 — `inc/chapters/defaults/mokesh-defaults.php`

**(א) `phero` — הוספת `yt_id` בלבד, שאר השדות ללא שינוי:**

```php
'phero' => array(
	'chap'      => 'לזכרו · 1950 – 2020',
	'title'     => 'מוקש <em>דהימן</em>',
	'sub'       => "מוקש דהימן היה אמן-נגר, בונה דיג'רידו ומורה מרישיקש שבהודו, שכבר בתחילת שנות השבעים הקדיש את חייו למלאכת בנייתו של הדיג'רידו ולהפצתו ככלי נשימה, ריפוי וחיבור ללב.",
	'media'     => 'assets/images/chapters/mokesh-eyal.jpg', // fallback/poster — no-JS, reduced-motion, API-blocked
	'media_alt' => "מוקש דהימן עם אייל עמית ברישיקש, הודו",
	'yt_id'     => 'kf4NKSdYi9E', // הטריילר הרשמי — MUKESH: The Art of Shanti Living (ערוץ Kuthli Studio)
),
```

**(ב) הכנסת סעיף גלריה חדש — מיד אחרי הסעיף עם `'chap' => 'הסרط'` / `'title' => 'The Art of Shanti Living'`** (האינדקס ה-13-י במערך `sections`, 0-based index 12 בקובץ הנוכחי — הסעיף שמסתיים ב-`</p>",\n\t\t\t\t),\n\t\t\t),` ממש לפני הסעיף "תפנית חדה בעלילה"). מיקום זה מדויק מהמוקאפ המאושר (`t1-mokesh-gallery-video-placement_mockup.html`, `filmMarker`). הכיתוב (chap/title) מועתק **מילה-במילה** מ-Wave2 (`inc/wave2-w2-14e.php:519-520`) — לא הומצא כיתוב חדש:

```php
/* NEW — 19-photo memorial gallery (WP-CANON T1). Copy verbatim from Wave2
   (inc/wave2-w2-14e.php:519-520). Placement: immediately after "הסרط"/"The Art
   of Shanti Living", per team_00-approved mockup (t1-mokesh-gallery-video-placement_mockup.html). */
array(
	'part' => 'gallery',
	'args' => array(
		'chap'  => 'תיעוד',
		'title' => 'מוקש, רישיקש והדרך',
		'items' => array(
			array( 'image' => 'assets/images/mokesh/mokesh-01.jpeg', 'alt' => "מוקש דהימן, מאסטר הדיג'רידו מרישיקש" ),
			array( 'image' => 'assets/images/mokesh/mokesh-02.jpeg', 'alt' => "מוקש דהימן מנגן בדיג'רידו ארוך, כורע בנוף גבעות רישיקש" ),
			array( 'image' => 'assets/images/mokesh/mokesh-03.jpeg', 'alt' => "בית המלאכה של מוקש דהימן סמוך לגדת הגנגס ברישיקש" ),
			array( 'image' => 'assets/images/mokesh/mokesh-04.jpeg', 'alt' => "מוקש דהימן מלמד תלמידים לנגן בדיג'רידו סביב מדורה, בית המלאכה ברישיקש" ),
			array( 'image' => 'assets/images/mokesh/mokesh-05.jpeg', 'alt' => "מוקש דהימן נושם בדיג'רידו בחצר בית המלאכה" ),
			array( 'image' => 'assets/images/mokesh/mokesh-06.jpeg', 'alt' => 'סאדהו מנגן בכלי נשיפה, רישיקש' ),
			array( 'image' => 'assets/images/mokesh/mokesh-07.jpeg', 'alt' => "כפר קוטלי למרגלות ההימלאיה, מקום הסטודיו החדש של מוקש" ),
			array( 'image' => 'assets/images/mokesh/mokesh-08.jpeg', 'alt' => 'מבנה העץ הפתוח של הסטודיו בקוטלי בעת הקמתו' ),
			array( 'image' => 'assets/images/mokesh/mokesh-09.jpeg', 'alt' => 'מוקש דהימן יושב במרפסת ביתו בקוטלי, נוף ההרים ברקע' ),
			array( 'image' => 'assets/images/mokesh/mokesh-10.jpeg', 'alt' => "מוקש דהימן עם משפחתו, תיעוד נדיר מקוטלי" ),
			array( 'image' => 'assets/images/mokesh/mokesh-11.jpeg', 'alt' => 'מוקש דהימן מתחבק עם אורחים ליד הרכב, ביקור משפחתי בהודו' ),
			array( 'image' => 'assets/images/mokesh/mokesh-12.jpeg', 'alt' => "מוקש דהימן יושב ומנגן בדיג'רידו ארוך ליד מנדלה בחול" ),
			array( 'image' => 'assets/images/mokesh/mokesh-13.jpeg', 'alt' => 'אייל עמית עם מוקש דהימן ואורחת, ברחוב ברישיקש' ),
			array( 'image' => 'assets/images/mokesh/mokesh-14.jpeg', 'alt' => "גדת נהר הגנגס ברישיקש, מקום טקס הפרידה ממוקש" ),
			array( 'image' => 'assets/images/mokesh/mokesh-15.jpeg', 'alt' => 'מוקש דהימן ואשתו אניטה יחד, רגע משפחתי' ),
			array( 'image' => 'assets/images/mokesh/mokesh-16.jpeg', 'alt' => 'אייל עמית עם שניים מבניו של מוקש דהימן' ),
			array( 'image' => 'assets/images/mokesh/mokesh-17.jpeg', 'alt' => "אייל עמית חוזר לרישיקש לסגור מעגל, 2026" ),
			array( 'image' => 'assets/images/mokesh/mokesh-18.jpeg', 'alt' => 'מוקש דהימן בתפילה על גדת הגנגס' ),
			array( 'image' => 'assets/images/mokesh/mokesh-19.jpeg', 'alt' => 'מוקש דהימן בדרך יער בקוטלי, מברך לשלום' ),
		),
	),
),
```

**חשוב מאוד — קרא לפני מימוש:** 7 מתוך 19 השורות למעלה (01, 03, 05, 07, 10, 14, 17) הן **טקסט alt קיים, מאושר, כבר-חי בעמוד** — הועתקו מילה-במילה מהמופעים הבודדים שלהן במערך `sections` הנוכחי (ר' §6.1 — **אסור** לנסח alt חדש להן, זה ייצור סתירה בין שתי הופעות של אותה תמונה). 12 השאר (02, 04, 06, 08, 09, 11, 12, 13, 15, 16, 18, 19) הן **טיוטה** שנכתבה כאן על בסיס צפייה ישירה בקבצים — סבירה ומבוססת-חזותית, אך **לא מאומתת** מול אייל לגבי זהות מדויקת (למשל: מס' 06 — דמות עם טורבן כתום שמנגנת בכלי נשיפה קטן; ייתכן שזה מוקש עצמו וייתכן שזה אחד הסאדהואים שמוזכרים בטקסט כמבקרים אצלו — נכתב בזהירות כ"סאדהו" ולא "מוקש" מהסיבה הזו). ר' §6.1 להנחיה מלאה.

**(ג) הכנסת סעיף פייסבוק חדש — מיד אחרי הסעיף עם `'chap' => 'ממשיכי הדرך'`** (הסעיף האחרון לפני "דברי הספד" הסוגר). כיתוב מועתק מילה-במילה מ-Wave2 (`inc/wave2-w2-14e.php:557-558`), וכתובות ה-URL מועתקות מילה-במילה מ-`ea_w2_14e_mokesh_fb_posts()`:

```php
/* NEW — 4 Facebook post embeds (WP-CANON T1). Copy verbatim from Wave2
   (inc/wave2-w2-14e.php:557-558, urls from ea_w2_14e_mokesh_fb_posts()).
   Placement: immediately after "ממשיכי הדرך", before the closing "דברי הספד". */
array(
	'part' => 'fbembeds',
	'args' => array(
		'chap'  => 'מהקהילה',
		'title' => 'מתוך הפייסבוק',
		'items' => array(
			array( 'href' => 'https://www.facebook.com/IsraelDidgCenter/posts/pfbid02G6viGTqgqTHFv36najD6n9T6yskVpC5UfWx1RzrbNTqNMfTYRKrJkzkqHH2taffXl' ),
			array( 'href' => 'https://www.facebook.com/eyal.amit.muzza/posts/pfbid033bDz4Wj8Pc6K3nF58VuXBUHkfoNKPZa4wTsxhPSUVHANHwZT3rAqj1oUAGXzwTm6l' ),
			array( 'href' => 'https://www.facebook.com/eyal.amit.muzza/posts/pfbid0zekNyNV6dztxGnwQKaLg9GhSAwSsjMWR2jaqQtAkZMLAHWNhKem12AknNrsCAJZRl' ),
			array( 'href' => 'https://www.facebook.com/gemma.calaf/posts/pfbid0gsUdiLtCCghgQp9RuyPncdb4NRojZ3k5LdxMqfeNPinvQd9x6Y7j6Jrp9VUThqiEl' ),
		),
	),
),
```

לא מתווספת `'alt' => false` מפורש לא לגלריה ולא ל-fbembeds — שתיהן נשענות במכוון על ברירת המחדל של הרכיב עצמו (`true` — רקע מוצלל-קלות), עקבי עם השימוש הקיים היחיד ב-`gallery.php` (`galleries-defaults.php`, שגם הוא לא מעביר `alt` מפורש).

### 2.7 שינוי #6 — `inc/chapters/chapters-enqueue.php`

הוספת פונקציה חדשה, עצמאית מזו הקיימת (לא נוגעים ב-`ea_chapters_enqueue_assets()` הקיימת בכלל):

```php
/**
 * Enqueue the Mokesh memorial hero trailer script — scoped to /eyal-amit/mokesh-dahiman/
 * only. Ported from inc/wave2-w2-14e.php's ea_w2_14e_assets() (WP-CANON T1). The Wave2
 * enqueue call is intentionally left in place (harmless double-registration under the
 * same 'ea-mokesh' handle — WP dedupes by handle) until T6 removes that file; see
 * LOD400 T1 §6 for the sequencing note T6 must respect.
 */
function ea_chapters_mokesh_enqueue_assets() {
	if ( is_admin() || 'mokesh-dahiman' !== ea_chapters_current_slug() ) {
		return;
	}
	wp_enqueue_script(
		'ea-mokesh',
		get_stylesheet_directory_uri() . '/assets/js/ea-mokesh.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_chapters_mokesh_enqueue_assets', 101 );
```

(handle `'ea-mokesh'`, deps `array()`, in-footer `true` — זהה בדיוק לרישום המקורי ב-`inc/wave2-w2-14e.php:194-200`, רק ה-gate שונה: לפי slug של Chapters, לא לפי `ea_w2_14e_is_page()`.)

### 2.8 שינוי #7 — `assets/css/chapters.css`

הוספה בסוף הקובץ (אחרי הבלוק הקיים `/* ── image gallery (.gallery / .gfig) … ── */`, שכיום הבלוק האחרון בקובץ, שורה 689):

```css
/* ── MOKESH MEMORIAL HERO — video variant of .phero--media, mokesh-dahiman only (WP-CANON T1) ── */
.mokesh-hero__yt{position:absolute;inset:0;z-index:0;overflow:hidden}
.mokesh-hero__yt iframe,.mokesh-hero__yt #ea-mokesh-trailer{position:absolute;top:50%;inset-inline-start:50%;transform:translate(-50%,-50%);width:100vw;height:56.25vw;min-width:177.78vh;min-height:100vh;border:0;pointer-events:none}
.mokesh-hero__unmute{position:absolute;z-index:2;inset-block-end:24px;inset-inline-end:24px;display:inline-flex;align-items:center;gap:8px;padding-block:8px;padding-inline:16px;background:rgba(20,14,9,.6);color:#fff;border:1px solid var(--sand);border-radius:100px;font-family:var(--bf);font-size:.78rem;cursor:pointer}
.mokesh-hero__unmute:hover,.mokesh-hero__unmute:focus-visible{background:rgba(20,14,9,.85)}
.mokesh-hero__unmute-icon::before{content:"\1F507"}
.mokesh-hero__unmute.is-on .mokesh-hero__unmute-icon::before{content:"\1F50A"}
@media(prefers-reduced-motion:reduce){.mokesh-hero__yt{display:none}}

/* ── Facebook post embeds grid (.fbgrid) — mokesh-dahiman only today, built generic ── */
.fbgrid{display:flex;flex-wrap:wrap;gap:16px;justify-content:center;margin-top:54px}
.fbgrid__item{flex:0 1 500px;max-width:100%}
.fbgrid__frame{display:block;width:100%;max-width:500px;height:640px;border:0}
```

הערות תכן ל-CSS הזה:
- ה-`100vw/56.25vw/177.78vh/100vh` (שורה 2 בבלוק) הם **בדיוק** הערכים הקיימים כבר ב-`assets/css/w2-14e-catalog.css:414-427` — טריק ה-cover-fill ל-iframe יוטיוב (`object-fit` לא אמין מספיק על iframe בכל הדפדפנים; זה הפתרון שכבר QA-אושר). לא לשנות את המספרים.
- `@media(prefers-reduced-motion:reduce)` ברמת CSS הוא **הקשחה נוספת**, לא רק פורט — ea-mokesh.js כבר בודק את זה ב-JS (`window.matchMedia(...).matches`) ולא יוצר את הנגן כשמופחת; שכבת ה-CSS מוסיפה ביטחון (defense-in-depth) גם למקרה שה-JS ירוץ בכל זאת.
- `var(--sand)`/`var(--bf)` הם משתני Chapters קיימים (`chapters.css:16-17`) — לא token חדש, D-14-compliant.

### 2.9 שינוי #8 — `inc/chapters/chapters-render.php` שורה 49

```diff
-		'mokesh-dahiman' => array( 'template' => 'tpl-chapters-page',  'type' => 'mokesh' ),
+		'mokesh-dahiman' => array( 'template' => 'tpl-chapters-mokesh', 'type' => 'mokesh' ),
```

זו שורה אחת, וזו **גם** נקודת ה-rollback הממוקדת של כל T1: שינוי חד-כיווני שלה בחזרה ל-`'tpl-chapters-page'` מבטל את כל שכבת המדיה החדשה באופן מיידי, בלי לגעת בשום קובץ אחר, ובלי תלות במנגנון ה-rollback הנפרד של האתר כולו (`tpl-home.php` / `EA_CHAPTERS_FRONT`, ר' LOD300 C-3) — שתי רשתות ביטחון עצמאיות.

### 2.10 שינוי #9 — `site/wp-content/mu-plugins/ea-w2-seo-schema.php`

מנוע ה-schema היחיד באתר (`wpseo_schema_graph` filter — "ONE schema engine, no hand-rolled second @graph", לפי ה-doc header של הקובץ עצמו, שורות 3-9). **זו הסיבה** ש-VideoObject ו-Person(מוקש) נכנסים **לכאן**, לא כ-`<script>` נפרד כמו ש-Wave2 עשה (`inc/wave2-w2-14e.php:458-468`) — ר' §3.4 לנימוק המלא כולל התנגשות-המדיניות שהתגלתה.

הוספה בתוך `ea_w2_seo_schema_graph()`, אחרי בלוק ה-Product הקיים (סביב שורה 147, לפני ה-`return $graph;`):

```php
// --- Person + VideoObject: Mokesh Dahiman memorial page only (WP-CANON T1) ---
// Routed through Yoast's single @graph (not a hand-rolled second <script>, per this
// file's own "ONE schema engine" policy) — AND per the "no VideoObject on the muted
// hero loop" prohibition (SEO-GEO-EXECUTION-PLAN-2026-06-20.md:74; enforced by
// scripts/qa/seo_probe.mjs Check 9). The node below is anchored to the trailer as a
// named, independently-identifiable work ('about' → the Person it documents,
// 'publisher' → the business) — NOT described as "the hero decoration". Field values
// deliberately avoid the literal substring "hero" in any key/id/url (see LOD400 T1 §3.4).
if ( is_page() ) {
	$obj  = get_queried_object();
	$slug = ( $obj && isset( $obj->post_name ) ) ? (string) $obj->post_name : '';
	if ( 'mokesh-dahiman' === $slug ) {
		$mokesh_id  = $site . '#/schema/person/mokesh-dahiman';
		$mokesh_img = get_stylesheet_directory_uri() . '/assets/images/mokesh/mokesh-01.jpeg';

		$graph[] = array(
			'@type'         => 'Person',
			'@id'           => $mokesh_id,
			'name'          => 'מוקש דהימן',
			'alternateName' => 'Mukesh Dhiman',
			'description'   => "אמן-נגר ובונה דיג'רידו מרישיקש, הודו (1950–2020) — מורו של אייל עמית.",
			'url'           => home_url( '/eyal-amit/mokesh-dahiman/' ),
			'image'         => $mokesh_img,
			'birthDate'     => '1950',
			'deathDate'     => '2020-10-11',
			'knowsAbout'    => array( "בניית דיג'רידו בעבודת יד", 'נשימה מעגלית', 'מסורת הדיג׳רידו ברישיקש' ),
			'affiliation'   => array(
				'@type' => 'Organization',
				'name'  => 'Jungle Vibes',
			),
		);

		$graph[] = array(
			'@type'        => 'VideoObject',
			'@id'          => $site . '#/schema/video/mukesh-trailer',
			'name'         => 'MUKESH - The Art of Shanti Living | Official Trailer',
			'description'  => 'הטריילר הרשמי לסרט התיעודי על מוקש דהימן, מאסטר הדיג׳רידו מרישיקש, מאת אייל וגיא עמית.',
			'uploadDate'   => '2019-11-19T14:41:31-08:00',
			'thumbnailUrl' => 'https://i.ytimg.com/vi/kf4NKSdYi9E/maxresdefault.jpg',
			'embedUrl'     => 'https://www.youtube-nocookie.com/embed/kf4NKSdYi9E',
			'contentUrl'   => 'https://youtu.be/kf4NKSdYi9E',
			'about'        => array( '@id' => $mokesh_id ),
			'publisher'    => array( '@id' => $biz_id ),
		);
	}
}
```

שים לב: **בלי `@context` על הצמתים החדשים** — אף צומת קיים בקובץ הזה (Person/ProfessionalService/Service/Product) לא נושא `@context` משלו; הוא מוצהר פעם אחת ברמת ה-wrapper של Yoast. הוספת `@context` per-node תהיה חריגה לא-עקבית, לא רק מיותרת. `duration` הושמט במכוון (Google ממליץ, לא מחייב; לא קיים ערך מאומת — Wave2 המקורי גם השמיט אותו; ר' §6.4).

**הרחבה אופציונלית, לא-חוסמת (דלגו אם רוצים להישאר עם השטח הכי קטן):** לינק `knows` דו-כיווני בין אייל למוקש. **לא** לערוך את מערך ה-Person של אייל (שורות 41-51) ישירות — זה יצור `@id` תלוי (`mokesh_id`) שמופיע על **כל** עמוד באתר (אייל הוא global), בעוד מוקש רק על עמוד אחד — הפרה של check 8 (dangling-@id) בכל שאר האתר. אם רוצים בכל זאת, לתקן **רק בתוך הבלוק המותנה למעלה**, אחרי ששני הצמתים כבר ב-`$graph[]`:

```php
foreach ( $graph as &$node ) {
	if ( isset( $node['@id'] ) && $node['@id'] === $person_id ) {
		$node['knows'] = array( '@id' => $mokesh_id );
		break;
	}
}
unset( $node );
```

### 2.11 שינוי #10 — `scripts/qa/seo_probe.config.json`

`/eyal-amit/mokesh-dahiman/` **לא קיים כלל** במאניפסט הזה היום (ה-`_comment` בקובץ מצהיר את זה מפורשות — "measured but explicitly OUT of the CR1-4 rollup... and is NOT included here"). בלי רשומה, Check 7 (per-route expected @type) פשוט לא ירוץ נגד העמוד הזה — אף אחד לא יאמת אוטומטית שה-Person/VideoObject באמת נמצאים שם. להוסיף לתוך `"routes"`:

```json
{
  "name": "mokesh-dahiman",
  "path": "/eyal-amit/mokesh-dahiman/",
  "expectedTypes": ["Person", "ProfessionalService", "VideoObject", "WebPage", "BreadcrumbList", "WebSite"],
  "note": "WP-CANON T1 (2026-07-14+). Person here checks presence of the @type only (satisfied by the global Eyal node too) — the Mokesh-specific @id must be verified separately (LOD400 T1 §5). VideoObject = the official trailer (kf4NKSdYi9E), deliberately NOT framed as hero decoration — see LOD400 T1 §3.4 for the 'no VideoObject on the muted hero loop' prohibition this must not trip."
}
```

## 3. ההכרעה הטכנית: הרחבת רכיב כללי מול פתרון ייעודי

team_00 האציל את זה במפורש ל"שיקול-דעת הנדסי" (LOD300 §4 Q2: "אין העדפה מפורשת — יוכרע הנדסית ב-LOD400"). **הכרעה: אפשרות 2 — פתרון ייעודי (bespoke), מותאם למבנה הקבצים של Chapters — לא הרחבת `phero.php` ולא `videoblk.php` לתמיכה כללית ב-YouTube.**

### 3.1 מה בדיוק "ייעודי" אומר כאן — לא Wave2 בהעתק-הדבק

חשוב להפריד: "בחר בפתרון הייעודי" **לא** אומר "תשאיר את `inc/wave2-w2-14e.php` כמו שהוא ותסמוך עליו". זה אומר: בונים גרסה **native ל-Chapters** — קובץ template חדש, רכיב חדש, CSS בקובץ המאוחד `chapters.css` — שמשתמשת מחדש בקוד ה-JS וה-CSS ש-Wave2 **כבר פתר נכון ו-QA-אישר** (טריק ה-cover-fill ל-iframe, לוגיקת ה-unmute, ה-guard ל-reduced-motion), אבל חיה לגמרי בתוך המערכת של Chapters, בלי תלות בקובץ ש-T6 עתיד למחוק.

### 3.2 ממצא ארכיטקטוני שמחייב בכל מקרה template חדש

`page-templates/tpl-chapters-page.php:43` קורא ל-hero כך:

```php
get_template_part( 'template-parts/chapters/parts/phero', null, $ea_phero );
```

זו קריאה **קשיחה בשם**, לא מונעת-נתונים כמו לולאת ה-`sections` (`'part' => $ea_s['part']`). המשמעות: **גם אם** ההכרעה הייתה "הרחיבו את `phero.php` עצמו לתמיכה ב-YouTube", עדיין צריך template נפרד או תנאי בתוך `tpl-chapters-page.php` (שמריץ את כל שאר ~19 סוגי העמודים) כדי ש-`phero.php` ידע *מתי* להציג וידאו — כי אין מנגנון היום שמעביר "השתמש ב-variant אחר של ה-hero" per-page. שתי האפשרויות (הרחבה או ייעודי) **גוזרות אותה עלות ארכיטקטונית מינימלית**: template ייעודי. זה בדיוק מה ש-`tpl-chapters-method.php` ו-`tpl-chapters-en.php` כבר עושים עבור routes אחרים — יש תקדים חי, לא המצאה.

מכיוון שעלות-הבסיס זהה בשתי האפשרויות, ההכרעה בפועל מצטמצמת לשאלה: **האם `phero.php` (המשותף ל-~19 סוגי עמוד) צריך לקבל args חדשים לתמיכת-וידאו (self-hosted/YouTube), או שעדיף hero נפרד קטן שהתכונה הזו לא נוגעת בו בכלל?**

### 3.3 הנימוקים בפועל

**בעד ייעודי (ההכרעה):**
1. **אין צרכן שני.** נסרקו כל 8 משימות ה-LOD200/LOD300 (T1–T7) — אף עמוד אחר לא צריך hero-וידאו של YouTube. T3/T3b (מוצרים/ספרים) לא כוללים טריילרים; T5 (/qr, /shop) גם לא. הרחבת `phero.php` היום היא הכללה (generalization) בלי צרכן שני שיאמת את החוזה — YAGNI קלאסי.
2. **הקוד הקיים כבר עובד ו-QA-אושר.** `ea-mokesh.js` + הפתרון ב-`w2-14e-catalog.css` כבר עברו אישור team_190/team_90 (`VERDICT_MOKESH_PHASE2_FINAL_v1.md`, `VERDICT_MOKESH_FINAL-VALIDATE_CURSOR-COMPOSER_2026-06-21.md`). פורט-מותאם של קוד מוכח נמוך-סיכון יותר מכתיבת שכבת-הפשטה חדשה (multi-provider: self-hosted מול YouTube, אולי Vimeo בעתיד) על עמוד רגיש (memorial page, מתויג "SENSITIVE" בקוד המקור עצמו).
3. **רדיוס-נזק (blast radius) מוכל.** `phero.php` מרונדר על ~19 סוגי עמודים שונים. שינוי בו — גם תוספת-args "בטוחה" — פותח את הדלת לרגרסיה חוצת-אתר. קובץ ייעודי חדש לא יכול לפגוע באף עמוד אחר, מבנית.
4. **תרבות-ההנדסה של הפרויקט כבר מעדיפה את זה.** ה-doc comment המקורי של Wave2 עצמו (`inc/wave2-w2-14e.php:16`): "D-14: zero new tokens/atoms/keyframes" — עקרון מוצהר של מינימום-הפשטה-חדשה בזמן porting. בחירה בהרחבה כללית כאן תסתור את הרוח הזו.
5. **גם ה-fallback משתפר תוך כדי.** ל-Wave2 המקורי fallback ל-gradient ריק (ea-mokesh.js: "the dignified gradient hero remains"). הגרסה המוצעת כאן (§2.2) נשענת על `.phero__media` הקיים — כשה-JS/YouTube לא נטענים, מוצגת תמונה אמיתית (אייל+מוקש), לא gradient ריק. שיפור אמיתי, בזכות המבנה של Chapters, לא למרותו.

**נגד הרחבת `phero.php`:** תצטרך תשתית-ניתוב-וידאו (`video_provider`, self-hosted מול YouTube, אולי `loop`/`autoplay` שונים), עיצוב-מחדש של מנגנון ה-unmute (`phero.php` הכללי לא כולל כפתור unmute כלל היום — ה-mute-toggle היחיד באתר הוא `#soundtg` בנאב, ומקושר קשיח ל-class `.hero__media` של דף הבית — ראה §6.3), וכל זה בלי צרכן שני שיוודא שההפשטה נכונה.

### 3.4 ממצא נוסף שהתגלה במחקר: התנגשות עם מדיניות SEO קיימת — "אין VideoObject על ה-hero המושתק"

זה **לא** שיקול חזותי (המוקאפ כבר אישר את המיקום ב-hero) — זו התנגשות בין שני דברים שכל אחד מהם כבר הוכרע בנפרד:

- **המוקאפ המאושר** (LOD300 §2 T1, §4 Q2) ממקם את הטריילר **בתוך ה-hero** ("Hero — היום: תמונה סטטית / הצעה: טריילר וידאו (אותו סלוט, משודרג)").
- **מדיניות SEO קיימת ומתועדת**, שנקבעה *לפני* שה-VideoObject המקורי של Wave2 נבנה (`_COMMUNICATION/team_100/SEO-GEO-EXECUTION-PLAN-2026-06-20.md:74`, בתוך WP-02): "*It explicitly honors the prohibitions (no `areaServed:Israel` default, no precise geo until D2, no self-serving AggregateRating, **no VideoObject on the muted hero loop**).*" האיסור הזה **נאכף אוטומטית** ע"י `scripts/qa/seo_probe.mjs` Check 9 (`checkProhibitionLint`, שורות 382-397; הרגקס הספציפי ב-390-391) — "prohibition lint" עם 4 דפוסים אסורים, אחד מהם `VideoObject-on-hero`.

**מה זה אומר בפועל:** ה-VideoObject המקורי של Wave2 (`inc/wave2-w2-14e.php:458-468`) הוא, במובן המהותי, בדיוק התבנית שהאיסור הזה נועד למנוע — schema על וידאו-רקע מושתק שמתנגן אוטומטית, לא וידאו שהמשתמש בוחר לצפות בו. (הרגקס עצמו ב-Check 9 חלש למעשה — הוא מחפש את המחרוזת המילולית "hero" בתוך ה-JSON, וה-JSON של Wave2 לא מכיל אותה בפועל, אז מבחינה מכנית טהורה הוא לא נתפס. אבל **זו לא הדרך הנכונה לקרוא כלל-מדיניות** — הכוונה המתועדת ברורה, ועקיפה מכנית של regex חלש היא בדיוק סוג הפער ש-LOD400 אמור לעצור, לא לנצל.)

**הפתרון המוצע (מיושם ב-§2.10):**
1. שדות ה-VideoObject (`name`/`description`/`thumbnailUrl`/`embedUrl`/`contentUrl`) ממשיכים לתאר **את הטריילר עצמו** כיצירה עצמאית ובעלת-שם — לא "את קישוט ה-hero". זה כבר נכון בערכים המקוריים של Wave2 (אף שדה לא מזכיר "hero").
2. **הוספת `'about' => {'@id' => מוקש}`** — עוגן סמנטי מפורש שמקשר את הווידאו ל"מה שהוא מתעד" (מוקש), לא ל"איפה הוא יושב על העמוד".
3. **אף מפתח `@id`/מפתח-מערך לא נושא את המילה המילולית "hero"** — נבחר `#/schema/video/mukesh-trailer`, לא, למשל, `#/schema/video/mokesh-hero-trailer`.
4. שינוי-הבית: מ-`<script>` נפרד ומנותק (Wave2) ל-node בתוך ה-`@graph` המאוחד היחיד של Yoast — עצמו כבר הפחתת-סיכון (יישור עם "ONE schema engine", לא רק עם האיסור הספציפי).

**מה זה לא פותר, ומה צריך QA אמיתי אחרי המימוש** (ר' גם §5, §6.2): הפתרון למעלה עונה על הכוונה המתועדת ברמה סבירה, אבל **זו קריאה שלי (agent), לא הכרעה של team_00 או של team_80/SEO** — הצוות שכתב את המדיניות הזו לא נועץ בשלב הזה. ממליץ במפורש: **team_190/team_90 ירוצו את `seo_probe.mjs` Check 9 נגד העמוד החי אחרי המימוש ויוודאו 0 hits בפועל**, ואם יש להם הסתייגות מהותית מעבר לבדיקה המכנית — זו שאלה שחוזרת ל-team_80 (מחברי המדיניות המקורית), לא נפתרת שוב כאן.

## 4. רצף בנייה מדורג

הרצף בנוי כך שצעדים 1-6 **לא נוגעים בניתוב החי בכלל** — אפס השפעה על המשתמש עד צעד 7 (נקודת ה-activation היחידה, שורה אחת, הפיכה מיידית).

1. **בניית 2 קבצי ה-part החדשים** (§2.2, §2.3) — `mokesh-hero.php`, `fbembeds.php`. בלי caller, בלי סיכון.
2. **בניית `tpl-chapters-mokesh.php`** (§2.4) — קלון + שורה אחת. עדיין לא מקושר לניתוב.
3. **עדכון `ea-mokesh.js`** (§2.5) — 2 שורות.
4. **עדכון `mokesh-defaults.php`** (§2.6) — `yt_id` + 2 סעיפים חדשים. בשלב הזה אפשר לבדוק ידנית: לשנות זמנית קובץ dev מקומי שמצביע ל-template החדש (או סביבת staging נפרדת), לוודא רינדור נכון **לפני** שמפעילים בפועל.
5. **עדכון `chapters-enqueue.php`** (§2.7).
6. **עדכון `chapters.css`** (§2.8).
7. **⚡ הפעלה — עדכון `chapters-render.php` שורה 49** (§2.9). זה הרגע היחיד שמשנה מה שמשתמש אמיתי רואה. הפיך מיידית (revert שורה אחת).
8. **הוספת ה-schema** ל-`ea-w2-seo-schema.php` (§2.10) — עצמאי מהניתוב (mu-plugin רץ תמיד), אפשר גם *לפני* צעד 7 בלי סיכון, אבל הגיוני לוודא קודם שהעמוד באמת מציג את הטריילר לפני שמתעדים אותו ב-schema.
9. **עדכון `seo_probe.config.json`** (§2.11) — אחרון, אחרי שה-schema כבר קיים ואפשר לוודא נגדו.
10. **מעבר QA מלא** — ר' §5.

## 5. קריטריוני קבלה (בדיקים וקונקרטיים)

| # | קריטריון | איך בודקים |
|---|---|---|
| 1 | ה-hero מציג את הטריילר כרקע מושתק ומתנגן אוטומטית, דסקטופ+מובייל | `preview_start`/דפדפן, `/eyal-amit/mokesh-dahiman/`, לוודא ה-iframe מתמלא ללא black-bars/עיוות ביחס-רוחב |
| 2 | כשה-DevTools מדמה `prefers-reduced-motion: reduce` — התמונה הסטטית (`mokesh-eyal.jpg`) מוצגת, **אין** בקשת רשת ל-`youtube.com/iframe_api` | Network tab, סנן `iframe_api` |
| 3 | כשה-JS מנוטרל לגמרי — התמונה הסטטית מוצגת, שום דבר לא שבור | DevTools → Disable JavaScript → reload |
| 4 | כפתור "הפעלת קול" מופיע אחרי שהנגן מוכן, מחליף טקסט/אייקון בלחיצה, `aria-pressed` מתעדכן | לחיצה ידנית + inspect ה-attribute |
| 5 | גלריית 19 התמונות מרונדרת ב-grid הקיים (3→2→1 לפי breakpoint), **ממוקמת בדיוק** בין "The Art of Shanti Living" ל"תפנית חדה בעלילה" | `read_page`/`get_page_text` על סדר הכותרות בעמוד |
| 6 | כל 19 קובצי התמונה מחזירים HTTP 200, ל-19 יש `alt` לא-ריק | `read_network_requests` בדפדפן / `curl -I` על כל URL |
| 7 | 4 הטמעות הפייסבוק מרונדרות, **ממוקמות בדיוק** בין "הרוח של מוקש חיה וקיימת" ל"דברי הספד", `locale=he_IL` בכל `src` | inspect ה-DOM |
| 8 | Schema: fetch ה-HTML החי, לחלץ את בלוק `yoast-schema-graph` (regex ב-`seo_probe.mjs:126-145` כבר עושה את זה), לוודא: צומת `Person` יחיד עם `@id` שמכיל `mokesh-dahiman` ו-`name":"מוקש דהימן"`; צומת `VideoObject` יחיד עם `kf4NKSdYi9E` בכל שלושת שדות ה-URL | הרצת `node scripts/qa/seo_probe.mjs` נגד ה-route החדש (אחרי §2.11), או בדיקה ידנית |
| 9 | `seo_probe.mjs` Check 9 (prohibition lint) מחזיר **0 hits** על העמוד הזה — כולל `VideoObject-on-hero` | הרצת הסקריפט, לקרוא `details` בפלט |
| 10 | `seo_probe.mjs` Check 8 (dangling `@id`) — 0 רפרנסים תלויים, כולל אם מומש ה-`knows` האופציונלי | אותה הרצה |
| 11 | **רגרסיה — שאר האתר לא השתנה.** להריץ `seo_probe.mjs` על 2-3 routes אחרים (`/treatment/`, `/`) לפני ואחרי, ה-`@graph` שלהם זהה (אלא אם מומש ה-`knows` האופציונלי, ואז רק שדה `knows` נוסף לצומת Person של אייל) | diff על הפלט |
| 12 | `inc/wave2-w2-14e.php` — diff ריק. `mu-plugins/ea-w2-14e-mokesh-media-seed-once.php` — diff ריק | `git diff` |
| 13 | `ea-mokesh.js` נטען **פעם אחת** בעמוד (לא כפול, למרות ששני מנגנוני enqueue קיימים באותה תקופת מעבר) | view-source, לספור `<script src=".../ea-mokesh.js">` |
| 14 | ציון Lighthouse Performance על העמוד לא צונח מתחת ל-0.85 (בייסליין נוכחי בלי וידאו: 0.93-0.94, `scripts/qa/reports/lh_mokesh-dahiman_.json`) | הרצת Lighthouse אחרי המימוש |
| 15 | אין horizontal overflow ב-375/390/414px | `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` |
| 16 | Rollback: שינוי שורה 49 חזרה ל-`tpl-chapters-page` משחזר מיידית את הגרסה הטקסטואלית-בלבד, בלי לגעת בקובץ אחר | בדיקה ידנית, סביבת dev |

## 6. Edge cases / סיכונים לתשומת לב

### 6.1 12 התמונות הבלתי-מנוצלות — alt text הוא טיוטה, לא תוכן סופי

הטבלה ב-§2.6(ב) מספקת alt text לכל 19 התמונות, אבל **7 בלבד** (01, 03, 05, 07, 10, 14, 17) הם טקסט **קיים ומאושר** (מועתק מהמופעים הבודדים הנוכחיים באותו קובץ). 12 השאר הם **תיאור-חזותי גולמי** שנכתב תוך כדי מחקר ה-LOD400 הזה (נצפו ישירות דרך Read tool) — לא אימות עובדתי מול אייל לגבי זהות/מיקום/הקשר. שתי דוגמאות לזהירות הדרושה: מס' 06 (דמות עם טורבן כתום מנגנת בכלי נשיפה) — לא ברור אם זה מוקש עצמו או אחד הסהדואים המוזכרים בטקסט כמבקרים; מס' 13 (סלפי עם 3 אנשים ליד תריס-חנות) — הזהות של האיש המבוגר באמצע לא ודאית. **המלצה:** מעבר QA קל (לא מחייב את אייל אישית — יכול להיות team_110/team_100 שמכירים את החומר) על 12 השורות המסומנות לפני publish, לא לפני שהמבנה/הפריסה עובדים. זה **לא** חוסם את שאר T1 (בדיוק כמו ש-C-2 ב-LOD300 לא חסם את T3) — זו הערת-תוכן, לא ארכיטקטורה.

### 6.2 "VideoObject-on-hero" — הפתרון כאן הוא קריאה הנדסית, לא הכרעת-מדיניות

ר' §3.4 המלא. לחזור בקצרה: הפתרון המוצע (framing סמנטי דרך `about`, הימנעות מהמילה "hero" ב-IDs, ראוטינג דרך ה-graph המאוחד) **סביר** אבל לא אושר ע"י מי שכתב את המדיניות המקורית (team_80, `SEO-GEO-EXECUTION-PLAN-2026-06-20.md`). זה הסיכון הכי-לא-טריוויאלי בכל המשימה הזו — לא כי הוא סביר שיישבר, אלא כי הוא **שקט**: אם מישהו לא ירוץ Check 9 בפועל אחרי ה-deploy, אף אחד לא ידע אם הפתרון עבד.

### 6.3 אין התנגשות עם כפתור-ה-mute הגלובלי בנאב, אבל שווה לאמת

`assets/js/ea-chapters.js:82-98` — הכפתור `#soundtg` בנאב מחפש `document.querySelector('.hero__media')` (class מדויק, **לא** `.phero__media`). בעמוד מוקש אין אף אלמנט עם `.hero__media` (גם היום, גם אחרי השינוי) — אז `#soundtg` נכנס ל-branch `sndBtn.setAttribute('hidden', '')` ומסתתר, כפי שהוא כבר עושה היום. הכפתור **החדש** (`.mokesh-hero__unmute`) הוא מנגנון נפרד לגמרי, בלי אינטראקציה. אין תיקון נדרש כאן — רק וידוא חזותי שהנאב לא מציג שני כפתורי-קול בו-זמנית.

### 6.4 שדות schema שהושמטו במכוון — לא "נשכחו"

`duration` על ה-VideoObject: מומלץ ע"י Google, לא חובה; אין ערך מאומת (Wave2 המקורי גם השמיט). `deathPlace`/`birthPlace` על ה-Person: לא נכללו — היו דורשים Place object מקונן בלי תרומה SEO משמעותית ביחס לסיכון-ולידציה. `sameAs` על ה-Person של מוקש: לא נמצא פרופיל-רשת מאומת **שלו אישית** (רק דף הפייסבוק של הסרט, שקושר סמנטית ל-VideoObject/יצירה, לא לאדם) — לא הומצא קישור.

### 6.5 פערי אמון בגלריה מול Wave2 — קרופ 4:3 מול מסונרי חופשי

`gallery.php`/`.gfig` (chapters.css:686) כופה `aspect-ratio:4/3;object-fit:cover` על כל תמונה. הגרסה המקורית של Wave2 (`w2-14e-catalog.css:506-521`) השתמשה ב-CSS columns masonry (`columns:3 240px`) ששימרה יחס-רוחב טבעי בלי קרופ. LOD300 כבר קבע ש"גלריה מתאימה ישירות, ללא בעיה" — זו לא שאלה פתוחה — אבל **התוצאה החזותית תהיה שונה** מ-Wave2 (חלק מהתמונות הפורטרטיות/נופיות ייחתכו בקרופ 4:3). מציין את זה כדי שבבדיקת QA חזותית לא יראו את זה כ"רגרסיה" מפתיעה — זו תוצאה ידועה וסבירה של השימוש ברכיב הקיים.

### 6.6 רצף T6 — לא למחוק את ה-enqueue הישן לפני שהחדש חי

`inc/wave2-w2-14e.php`'s `ea_w2_14e_assets()` עדיין ירשום את `ea-mokesh.js` על העמוד הזה (הבדיקה שלו מבוססת-slug, לא מבוססת-ניתוב שניצח בפועל) — זו עובדה קיימת **גם היום**, לא תופעת-לוואי של T1. כרגע זה לא-מזיק כי אין `#ea-mokesh-trailer` בעמוד. **אחרי** T1, שני מנגנוני ה-enqueue (Wave2 הישן + Chapters החדש, §2.7) ירוצו בו-זמנית — לא-מזיק (handle זהה, WP מבטל-כפילויות), אבל **T6 חייב לוודא שה-enqueue של Chapters (§2.7) כבר חי ועובד לפני מחיקת `inc/wave2-w2-14e.php`** — אחרת נגרם רגרסיה שקטה: הטריילר מפסיק להיטען כי אף enqueue לא נשאר. להעביר את ההערה הזו במפורש ל-spec של T6.

### 6.7 תלות חיצונית (out of scope לתקן, אבל שווה תיעוד)

4 הטמעות הפייסבוק תלויות בזמינות הפוסטים המקוריים ובזמינות `facebook.com/plugins/post.php` עצמו — תלות חיצונית שלא בשליטת הפרויקט (פוסט שנמחק/פרטיות-שהשתנתה יהפוך iframe ל-placeholder ריק/שבור, בלי שגיאת build). לא ניתן ולא צריך "לתקן" — QA חזותי אחרי deploy צריך לכלול בדיקה ש-4 ה-iframes אכן מציגים תוכן, לא ריקים.

---

*נספח קבצים שנקראו לצורך המחקר (ר' גם LOD300 §7): `inc/wave2-w2-14e.php`, `inc/chapters/defaults/mokesh-defaults.php`, `template-parts/chapters/parts/{gallery,videoblk,phero,prose,split,bleed,timeline}.php`, `assets/js/{ea-chapters,ea-mokesh}.js`, `mu-plugins/ea-w2-seo-schema.php`, `mu-plugins/ea-w2-14e-mokesh-media-seed-once.php`, `inc/chapters/{chapters-render,chapters-routing,chapters-enqueue}.php`, `page-templates/{tpl-chapters-page,tpl-chapters-method,tpl-chapters-en}.php`, `assets/css/{chapters,w2-14e-catalog}.css`, `scripts/qa/{seo_probe.mjs,seo_probe.config.json}`, `_COMMUNICATION/team_100/SEO-GEO-EXECUTION-PLAN-2026-06-20.md`, `_COMMUNICATION/team_80/SEO-GEO-RESEARCH-SYNTHESIS-2026-07-02.md`, `assets/images/mokesh/mokesh-{01..19}.jpeg` (נצפו חזותית), `scripts/qa/reports/lh_mokesh-dahiman_.json`.*

---

# T2 — פורט סינון-לפי-קטגוריה ל-FAQ (LOD400)

## 0. שני תיקונים למצב-ההתחלה שה-LOD300 מתאר (מאומת מול קוד חי, 14/7)

לפני כל השאר — כמו שה-LOD300 עצמו תיקן את ה-LOD200 ב-§1 (C-1..C-5), המחקר לקראת LOD400 העלה שני תיקונים למה שה-LOD300 עצמו קובע. שניהם מהותיים לתכנון ה-migration ולא ניתן "לפרוט" בלעדיהם:

**תיקון 1 — המאגר המרכזי מכיל 79 שאלות, לא ~62.** נספרו במדויק (`grep -c "'category' =>"` על `block-faq-list.php`, מאומת פעמיים): **79 פריטים**, לא "~62" כפי שה-LOD300 §7 מעריך. פילוח מדויק לפי קטגוריה:

| קטגוריה | מס' פריטים | יש עמוד mini-FAQ תואם? |
|---|---|---|
| treatment | 15 | כן |
| general | 15 | לא — מוצג רק ב-/faq |
| lessons | 8 | כן (ר' תיקון 2 למטה) |
| sound-healing | 8 | כן |
| bags | 7 | כן |
| method | 6 | כן (עמוד קיים, אך ר' §4.2) |
| repair | 6 | כן |
| didgeridoos | 5 | כן |
| stands-storage | 5 | כן |
| stand-floor | 4 | כן |
| **סה"כ** | **79** | |

**תיקון 2 — לעמוד `lessons` יש section FAQ כבר היום; ה-LOD300 C-4 שגוי בנקודה הזו.** ה-LOD300 קובע: *"לעמוד lessons (שיעורים) אין section FAQ בכלל כרגע."* בפועל (`inc/chapters/defaults/lessons-defaults.php:179-187`) יש section עם הכותרת "שאלות נפוצות" ו-8 זוגות שאלה-תשובה — אך הוא בנוי כ-`'part' => 'prose'` (טקסט חופשי עם `<strong>שאלה</strong><p>תשובה</p>` ידני), **לא** כ-`'part' => 'faq'` (רכיב האקורדיון שמשתמשים בו 10 העמודים האחרים). כלומר `lessons` נמצא **בדיוק באותו מצב כמו `method`** — "FAQ-כפרוזה" — לא "העדר FAQ מוחלט". זה משנה את הטיפול המוצע (ר' §4.2): `lessons` לא צריך החלטה נפרדת, הוא מצטרף לתבנית הפורט הרגילה של 10 העמודים, ורק `method` נשאר יוצא-דופן אמיתי (בגלל מבנה תבנית שונה — ר' להלן).

בנוסף: תוכן ה-`lessons`-prose כמעט זהה מילה-במילה לתוכן קטגוריית `lessons` שכבר קיימת במאגר המרכזי (8=8, השאלה הראשונה זהה כמעט לגמרי) — כלומר אין כאן תוכן חדש שצריך להמציא, רק מנגנון רינדור שצריך להחליף.

---

## 1. מטרה

לאחד את מנגנון ה-FAQ לכדי מקור-אמת יחיד עם קטגוריות **many-to-many** אמיתיות: 10 עמודי ה-mini-FAQ (ו-`lessons`) עוברים ממערך PHP קשיח ומוכפל לשליפה דינמית מהמאגר המרכזי לפי קטגוריה, ו-`method` מקבל section FAQ מובנה (אקורדיון) במקום פרוזה, כך שכל שאלה יכולה להיות משויכת לקטגוריה אחת או יותר ולהופיע בכל מקום רלוונטי בלי כפילות תוכן.

---

## 2. החלטת ארכיטקטורה: taxonomy אמיתי — לא שדה-מערך

### הממצא שמכריע את ההחלטה: יש כבר CPT רדום בשם `ea_faq`

ב-`functions.php:330-413`, בפונקציה `ea_eyalamit_register_m3_instance_cpts()` (hook: `init`, priority 9), **כבר רשום** custom post type בשם `ea_faq` (functions.php:345-361, תוויות "שאלות נפוצות (אינסטנסים)"), **לצד** ה-CPTs `ea_gallery` (363-377) ו-`ea_testimonial` (379-393). מיד אחריו, `register_taxonomy('ea_testimonial_cat', array('ea_testimonial'), …)` (functions.php:396-411) מחובר ל-`ea_testimonial` — אבל **אף taxonomy לא נרשם עבור `ea_faq`**. שלושת ה-CPTs נרשמו יחד תחת קומנטר אחד ("M3 — רישום CPT לאינסטנסי FAQ, גלריות והמלצות (קטלוג מרכזי)") — כוונת-מקור ברורה לתשתית קטלוג משותפת לשלושתם, אך רק ה-testimonials הושלמו (taxonomy + צריכה בפועל דרך `ea_chapters_testimonials()`, `chapters-render.php:310-332`).

ה-CPT `ea_faq` עצמו **רדום היום** — נצרך רק ע"י `page-templates/template-faq-catalog.php` (Wave2, "Template Name: FAQ — קטלוג (M2)", `menu_order`-based, מוצג רק אם עמוד עדיין משתמש בתבנית הזו ידנית — לא זו התבנית שרצה היום ב-`/faq`, ר' `chapters-route-map()` ב-`chapters-render.php:39`, ש-Chapters מנצחת שם). אין שום מנגנון שמאכלס אותו בפוסטים בפועל היום — לא אומת ישירות מול ה-DB (אין גישת WP-CLI/DB מסביבה זו), **חובה לאמת לפני מיגרציה** (ר' §5 שלב 0).

### שתי האופציות — טבלת החלטה

| | **א' — taxonomy אמיתי** (`ea_faq_cat` על `ea_faq`) | **ב' — שדה `categories[]` במערך ה-PHP הקיים** |
|---|---|---|
| עבודה חדשה | להשלים taxonomy על CPT שכבר קיים (מראה `ea_testimonial_cat` — pattern מוכר, 15 שורות קוד) | לשנות `'category' => 'x'` ל-`'categories' => ['x','y']` ב-79+ פריטים ולשנות את לוגיקת הסינון |
| **UI לעריכה (הדרישה המפורשת בסעיף 7 למטה)** | **native**: checkbox meta-box בעריכת פוסט, בדיוק כמו testimonials — 0 קוד UI חדש | **אין** — כל שינוי תוכן/שיוך דורש עריכת קובץ PHP + deploy; אייל/מפעיל תוכן לא יכול לגעת בזה |
| Migration | כתיבת ~98 פוסטים אמיתיים (ר' §0 + §4) — עבודה חד-פעמית עם script אידמפוטנטי | עריכת מערך PHP במקום — ללא DB writes |
| ניקיון ארכיטקטוני | משלים תשתית M3 שכבר קיימת; לא נוצר מנגנון FAQ שלישי במקביל | משאיר את CPT `ea_faq` תלוי-באוויר לנצח — "רפאים" בקוד לכל מפתח עתידי |
| T4 (FAQPage schema, המשימה הבאה בתור) | `WP_Query` + `tax_query` רגיל — ישיר | צריך ללקט ידנית לפי `categories[]` מהמערך — יותר שברירי |
| עלות ביצוע (render) | שאילתת DB אחת (~90 שורות, `no_found_rows=true`) — זניחה בסדר-גודל הזה | בזיכרון, ללא DB — מהיר יותר תיאורטית, לא משמעותי בנפח הזה |
| Git-diffability של תוכן | תוכן עובר ל-DB — אינו posts-controlled בגיט (ר' סיכון §7 R12) | תוכן נשאר בגיט, diff-able ב-PR |

### ההחלטה: **אופציה א' — `ea_faq_cat` taxonomy אמיתי על ה-CPT `ea_faq` הקיים**

נימוקים, בסדר משקל:

1. **זו לא בחירה בין "לבנות תשתית חדשה" ל"להשתמש במה שיש" — יש כבר M3-scaffold חצי-גמור בדיוק לתפקיד הזה.** להשלים אותו (taxonomy אחד + שתי פונקציות עזר) הוא פחות קוד מלשנות 79+ ערכי מערך ולבנות מנגנון סינון many-to-many-בתוך-PHP-array מאפס.
2. **הדרישה המפורשת של המשימה — "admin UX for assigning multiple categories to a question"** — מקבלת פתרון **מובנה של וורדפרס, ללא קוד UI חדש**, בדיוק ע"י מירור `ea_testimonial_cat`. באופציה ב' השאלה הזו נשארת פתוחה לגמרי (אין תשובה בלי לבנות מסך ניהול מותאם אישית).
3. **מחזק את T4** (schema FAQPage), שממתין ל-T2 (LOD300 §2 T4: "לא ניתן להתחיל בפועל לפני ש-T2... נועלות את המבנה הסופי") — taxonomy אמיתי + `WP_Query` הוא הבסיס הכי טבעי לבניית FAQPage schema אח"כ.
4. המחיר (migration חד-פעמית + תלות ב-DB) הוא עלות **קבועה וחד-פעמית**, מול עלות **מתמשכת** (UI-לא-קיים, CPT-רדום-לנצח) באופציה ב'.

**סטייה אחת מודעת ממירור `ea_testimonial_cat` 1:1:** `ea_testimonial_cat` נרשם עם `'public' => true` (מייצר ארכיון ציבורי `/testimonial-cat/{term}/`). ל-`ea_faq_cat` מוצע `'public' => false` — נמנעים מיצירת ~13 עמודי ארכיון ציבוריים חדשים, לא מעוצבים (אין להם template ייעודי, ייפלו ל-`archive.php`/`index.php` הגנרי של הערכה) ומהווים תוכן-כפול (duplicate content) מול `/faq` ומול עמודי ה-mini-FAQ עצמם. `show_ui`/`show_in_rest`/`show_admin_column` נשארים `true` — כל היכולת הניהולית וה-REST נשמרת, רק אין URL ציבורי חדש. ר' §7 R9.

`hierarchical => true` (זהה ל-`ea_testimonial_cat`) — לא כי לקטגוריות FAQ יש היררכיה סמנטית (אין), אלא כי זה קובע את **צורת ה-UI**: `true` = תיבות סימון (checkbox, כמו "קטגוריות") שמציגות תמיד את הרשימה המלאה והסגורה של הקטגוריות; `false` = תיבת "תגיות" חופשית עם auto-complete, שמאפשרת יצירת מונחים חדשים "תוך כדי" — מסוכן לטעויות הקלדה/כפילויות (`sound-healing` מול `Sound Healing` מול `sound_healing`) בטקסונומיה קטנה וסגורה (13 מונחים, לא צפויה לגדול). `hierarchical => true` הוא הבחירה הבטוחה יותר כאן, ומראה מדויק את `ea_testimonial_cat`.

---

## 3. קבצים לשינוי/יצירה — מדויק

### 3.1 `functions.php` — הוספת `register_taxonomy('ea_faq_cat', …)`

**מיקום מדויק:** בתוך `ea_eyalamit_register_m3_instance_cpts()` (מתחילה בשורה 330), **מיד אחרי** הבלוק הקיים `register_taxonomy('ea_testimonial_cat', …)` (שורות 396-411), **לפני** ה-`}` הסוגר של הפונקציה (שורה 412).

```php
	register_taxonomy(
		'ea_faq_cat',
		array( 'ea_faq' ),
		array(
			'labels'             => array(
				'name'          => __( 'קטגוריות שאלות נפוצות', 'ea-eyalamit' ),
				'singular_name' => __( 'קטגוריה', 'ea-eyalamit' ),
			),
			'public'             => false, // WP-CANON T2 — במכוון שונה מ-ea_testimonial_cat; ר' LOD400 §2, §7 R9.
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_rest'       => true,
			'show_admin_column'  => true,
			'hierarchical'       => true,
			'rewrite'            => false,
		)
	);
```

אין צורך לשנות את רישום ה-CPT `ea_faq` עצמו (שורות 345-361) — הוא כבר תקין ומלא (`show_ui`, `show_in_rest`, `supports` כולל `title`+`editor`, בדיוק מה שצריך לשאלה/תשובה).

**⚠ סיכון SEO נלווה לשינוי הזה, לא ל-taxonomy עצמו:** ל-CPT `ea_faq` יש כבר `'public' => true`, `'publicly_queryable' => true`, `'exclude_from_search' => false` ו-rewrite `faq-item` (functions.php:331-343, 356). ברגע שיהיו בו פוסטים בסטטוס `publish` (נדרש כדי שהשליפה בפרונט תעבוד — ר' §3.2), **כל אחת מ-~98 השאלות מקבלת URL ציבורי, ניתן-לאינדוקס באופן עצמאי** (`/faq-item/{slug}/`) — תופעת-לוואי של רישום ה-CPT המקורי, לא משהו ש-T2 ממציא, אבל T2 הוא מה שיפעיל אותה בפועל לראשונה. ר' §7 R7 להחלטה נדרשת לפני go-live.

### 3.2 `functions.php` — שתי פונקציות עזר חדשות

**מיקום מדויק:** מיד אחרי `ea_eyalamit_render_instance_catalog()` (מסתיימת בשורה 475), לפני `ea_eyalamit_galleries_catalog_template()` (שורה 483). ממוקם שם במכוון — לצד הפונקציה המקבילה (SSOT קיים לשליפת אינסטנסי-קטלוג לפי `tax_query`, אותו קונבנציה בדיוק).

```php
/**
 * כל מונחי ea_faq_cat כ-[slug => name], לפי סדר-יצירה (term_id ASC) — תואם
 * לסדר שבו סקריפט ה-migration יוצר את המונחים (ר' inc/cli/class-ea-faq-migrate-command.php),
 * כדי לשמר את סדר-התצוגה הקיים היום ב-/faq בלי תלות בפלאגין מיון נוסף. WP-CANON T2.
 *
 * @return array<string,string> slug => name
 */
function ea_faq_get_categories() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}
	$cache = array();
	$terms = get_terms( array(
		'taxonomy'   => 'ea_faq_cat',
		'hide_empty' => false,
		'orderby'    => 'term_id',
		'order'      => 'ASC',
	) );
	if ( ! is_wp_error( $terms ) ) {
		foreach ( $terms as $t ) {
			$cache[ $t->slug ] = $t->name;
		}
	}
	return $cache;
}

/**
 * פריטי ea_faq מפורסמים, מסוננים (OR — many-to-many) לפי $cat_slugs כשהוא לא ריק.
 * $cat_slugs ריק = כל הקטלוג (זהה להתנהגות /faq היום ללא סינון). WP-CANON T2.
 *
 * שים לב: post_content נשמר עם תגי <p>/<ul> מוכנים מראש (אותה קונבנציה בדיוק
 * שכבר קיימת ב-$faq_data של block-faq-list.php היום) — מוחזר גולמי, בלי
 * להעביר דרך the_content (שמריץ wpautop ועלול לעטוף-כפול <p> בתוך <p>).
 * הצריכה בצד הקורא חייבת להישאר wp_kses_post() בלבד, בדיוק כמו היום.
 *
 * @param string[] $cat_slugs
 * @return array<int,array{id:int,q:string,a:string,categories:string[]}>
 */
function ea_faq_query_items( array $cat_slugs = array() ) {
	$qargs = array(
		'post_type'      => 'ea_faq',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
		'no_found_rows'  => true,
	);
	if ( ! empty( $cat_slugs ) ) {
		$qargs['tax_query'] = array(
			array(
				'taxonomy' => 'ea_faq_cat',
				'field'    => 'slug',
				'terms'    => array_map( 'sanitize_title', $cat_slugs ),
				'operator' => 'IN',
			),
		);
	}
	$out = array();
	foreach ( get_posts( $qargs ) as $p ) {
		$out[] = array(
			'id'         => $p->ID,
			'q'          => get_the_title( $p ),
			'a'          => (string) $p->post_content,
			'categories' => wp_get_post_terms( $p->ID, 'ea_faq_cat', array( 'fields' => 'slugs' ) ),
		);
	}
	return $out;
}
```

### 3.3 חדש: `inc/data/ea-faq-seed.json` — תוכן ה-migration

**קובץ חדש**, מראה במדויק את התקדים הקיים ב-`inc/data/ea-testimonials-fb.json` (טקסט עברי עם הרבה גרשים/גרשיים — JSON נמנע מכאב-ראש ה-escaping הידני שקיים היום בתוך `block-faq-list.php`, שם רואים בפועל שני מוסכמות שונות של גרש בעברית — `'` (ASCII) מול `׳` (Hebrew geresh, U+05F3) — מוכח מהשוואת `treatment-defaults.php` מול `block-faq-list.php` לאותה שאלה בדיוק. ר' §7 R1).

**סכימה:**
```json
{
  "items": [
    {
      "seed_key": "treatment-01",
      "categories": ["treatment"],
      "q": "מה זה בעצם טיפול בדיג'רידו?",
      "a": "<p>...</p>"
    }
  ]
}
```
- `seed_key` — מזהה יציב, ייחודי, לצורך אידמפוטנטיות (ר' §3.4) — מוסכמה מוצעת: `{קטגוריה-ראשונה}-{מספר-סידורי דו-ספרתי}`.
- `categories` — מערך slugs (תמיכה ב-many-to-many כבר בשלב ה-seed, גם אם ברוב הפריטים הקיימים יהיה איבר יחיד — ר' §4.3 להערה שלא בוצע שיוך-כפול בפועל בשלב זה).
- `a` — HTML מוכן עם `<p>`/`<ul>` (מוסכמת ה-`'a'` הקיימת של המאגר המרכזי, לא מוסכמת `faq.php` שעוטפת ב-`<p>` בעצמה — ר' §7 R2, קריטי).

**איך ממלאים אותו — לא תמלול ידני, extraction script חד-פעמי:** מכיוון שרוב התוכן (79 מתוך ~98 הפריטים הסופיים) כבר קיים פעמיים בקוד (במאגר המרכזי וב-10 הקבצים המקומיים), מוצע סקריפט חד-פעמי (Node או PHP standalone, לא חלק מהתבנית בזמן ריצה) שקורא את שני המקורות ומפיק **טיוטת** JSON עם `bank_text`+`local_text` זה-לצד-זה לכל שאלה תואמת, להכרעת בעל-תוכן (ר' §5 שלב 2) — לא מכניס תוכן סופי אוטומטית. שלוש קטגוריות הספרים (`vekatavta`/`kushi-blantis`/`tsva-bekahol`, 18 פריטים) ושאלת ה"בונוס" של `method` (ר' §4.2) הן תוכן חדש למאגר (יש רק עותק מקומי אחד, אין מה להשוות).

### 3.4 חדש: `inc/cli/class-ea-faq-migrate-command.php` — פקודת WP-CLI למיגרציה

**קובץ חדש**, נטען מ-`functions.php` רק בתוך guard (`if ( defined('WP_CLI') && WP_CLI )`), כדי שלא ייטען כלל בבקשת דפדפן רגילה. אין כרגע שום תקדים ל-WP-CLI custom command בערכה הזו — זהו הראשון. אם אין גישת WP-CLI לסביבת ה-hosting (יש לאמת — הכתובת `s887.upress.link` מרמזת WP Engine, שבד"כ מספק SSH+WP-CLI, אבל לא הונחה בוודאות מסביבה זו), החלופה: אותה לוגיקה כ-script חד-פעמי המופעל ע"י מפתח דרך admin-ajax/admin-post מוגן ב-`current_user_can('manage_options')`, שנמחק אחרי הרצה אחת.

```php
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'ea-faq migrate', 'Ea_Faq_Migrate_Command' );
}

class Ea_Faq_Migrate_Command {
	/**
	 * Migrates inc/data/ea-faq-seed.json into ea_faq posts + ea_faq_cat terms.
	 * Idempotent: skips any seed_key that already has a matching _ea_faq_seed_key post.
	 *
	 * ## OPTIONS
	 * [--dry-run] — print planned inserts, write nothing.
	 *
	 * ## EXAMPLES
	 *     wp ea-faq migrate --dry-run
	 *     wp ea-faq migrate
	 */
	public function __invoke( $args, $assoc_args ) {
		$dry  = isset( $assoc_args['dry-run'] );
		$path = get_stylesheet_directory() . '/inc/data/ea-faq-seed.json';
		$raw  = json_decode( (string) file_get_contents( $path ), true );
		if ( empty( $raw['items'] ) ) {
			WP_CLI::error( 'ea-faq-seed.json missing or empty.' );
		}

		// 1) terms — create in seed-file order (drives ea_faq_get_categories() display order).
		$cat_slugs_seen = array();
		foreach ( $raw['items'] as $item ) {
			foreach ( (array) $item['categories'] as $slug ) {
				$cat_slugs_seen[ $slug ] = true;
			}
		}
		foreach ( array_keys( $cat_slugs_seen ) as $slug ) {
			if ( ! term_exists( $slug, 'ea_faq_cat' ) ) {
				WP_CLI::log( ( $dry ? '[dry-run] would create term: ' : 'creating term: ' ) . $slug );
				if ( ! $dry ) {
					wp_insert_term( $slug, 'ea_faq_cat', array( 'slug' => $slug ) ); // name set in step 3 below.
				}
			}
		}

		// 2) posts — idempotent via _ea_faq_seed_key postmeta.
		foreach ( $raw['items'] as $item ) {
			$existing = get_posts( array(
				'post_type'   => 'ea_faq',
				'post_status' => 'any',
				'meta_key'    => '_ea_faq_seed_key',
				'meta_value'  => $item['seed_key'],
				'numberposts' => 1,
				'fields'      => 'ids',
			) );
			if ( ! empty( $existing ) ) {
				WP_CLI::log( 'skip (exists): ' . $item['seed_key'] );
				continue;
			}
			WP_CLI::log( ( $dry ? '[dry-run] would create post: ' : 'creating post: ' ) . $item['seed_key'] );
			if ( $dry ) {
				continue;
			}
			$post_id = wp_insert_post( array(
				'post_type'    => 'ea_faq',
				'post_status'  => 'publish',
				'post_title'   => $item['q'],
				'post_content' => $item['a'],
			), true );
			if ( is_wp_error( $post_id ) ) {
				WP_CLI::warning( $item['seed_key'] . ': ' . $post_id->get_error_message() );
				continue;
			}
			update_post_meta( $post_id, '_ea_faq_seed_key', $item['seed_key'] );
			wp_set_object_terms( $post_id, $item['categories'], 'ea_faq_cat', false );
		}
		WP_CLI::success( $dry ? 'Dry run complete.' : 'Migration complete.' );
	}
}
```

**הערה על שמות מונחים (`name`) לעומת slugs:** הקוד לעיל יוצר מונחים עם `slug` בלבד (שם ברירת-מחדל = slug מוצג). יש להוסיף מיפוי `slug => label בעברית` (ר' טבלת §0 + 3 הקטגוריות החדשות בטבלת §4.1) ולעדכן כל מונח שנוצר עם `wp_update_term($term_id, 'ea_faq_cat', ['name' => $label])` — אחרת תיבות הסימון ב-wp-admin יציגו slugs (`sound-healing`) במקום עברית ("סאונד הילינג בדיג'רידו"). פרט מכוון שהושמט מהשלד לעיל לשם קריאות — **לא לשכוח בזמן המימוש בפועל.**

### 3.5 `template-parts/blocks/block-faq-list.php` — שכתוב לוגיקת הסינון (הקובץ המרכזי)

**שינוי 1 — מקור הנתונים (מחליף את שורות 20-454, ~435 שורות מתכווצות ל-2):**

היום:
```php
$faq_categories = array( 'treatment' => "טיפול בדיג'רידו", … ); // 13 שורות קשיחות
$faq_data = array( array('category'=>'treatment','q'=>…,'a'=>…), … ); // ~420 שורות קשיחות
```
מוצע:
```php
$faq_categories = ea_faq_get_categories(); // [slug => name] אמיתי, מה-DB
$faq_data       = ea_faq_query_items();    // כל הפריטים המפורסמים; כל item['categories'] הוא מערך
```

**שינוי 2 — נרמול ארגומנטים (מחליף שורות 16-18):**

היום:
```php
$ea_faq_only_category = ( isset( $args['ea_faq_only_category'] ) && '' !== $args['ea_faq_only_category'] )
	? (string) $args['ea_faq_only_category']
	: '';
```
מוצע:
```php
// WP-CANON T2 — מנרמל את הארג' הישן (יחיד) ואת החדש (מערך) לרשימה פנימית אחת.
// Back-compat מכוון: inc/wave2-w2-04.php:338 ו-inc/wave2-w2-05.php:421 עדיין קוראים
// לבלוק הזה עם 'ea_faq_only_category' יחיד — ר' §7 R5, אסור לשבור את זה.
$ea_only_cats = array();
if ( isset( $args['ea_faq_only_categories'] ) && is_array( $args['ea_faq_only_categories'] ) ) {
	$ea_only_cats = array_values( array_filter( array_map( 'sanitize_title', $args['ea_faq_only_categories'] ) ) );
} elseif ( isset( $args['ea_faq_only_category'] ) && '' !== $args['ea_faq_only_category'] ) {
	$ea_only_cats = array( sanitize_title( (string) $args['ea_faq_only_category'] ) );
}
$ea_view_chap  = isset( $args['ea_faq_view_chap'] ) ? (string) $args['ea_faq_view_chap'] : '';
$ea_view_title = isset( $args['ea_faq_view_title'] ) ? (string) $args['ea_faq_view_title'] : '';
```

**שינוי 3 — ה-branch של view-only (מחליף שורות 456-475):** מוסיף heading אופציונלי (`chap`/`title`) שהיה חסר לגמרי היום בברירת המחדל (ר' §7 R3 — פער קונקרטי, לא קוסמטי: ה-10 עמודים מציגים כותרת section היום דרך `faq.php`; המעבר ל-view-only branch הזה, כמו-שהוא-היום, ימחק את הכותרת) — והחלפת ההשוואה היחידה ל-`array_intersect`:

```php
<?php if ( ! empty( $ea_only_cats ) ) :
	$ea_only_items = array_filter(
		$faq_data,
		static function ( $item ) use ( $ea_only_cats ) {
			return (bool) array_intersect( $ea_only_cats, $item['categories'] );
		}
	);
	?>
	<section class="ea-faq-list ea-faq-list--view-only" data-block="faq-list" data-faq-category="<?php echo esc_attr( implode( ' ', $ea_only_cats ) ); ?>">
		<div class="ea-faq-list__inner">
			<?php if ( '' !== $ea_view_chap ) : ?><span class="chap chap--c r"><?php echo esc_html( $ea_view_chap ); ?></span><?php endif; ?>
			<?php if ( '' !== $ea_view_title ) : ?><h2 class="h2 r"><?php echo esc_html( $ea_view_title ); ?></h2><?php endif; ?>
			<div class="ea-faq-category">
				<?php foreach ( $ea_only_items as $item ) : ?>
					<details class="ea-faq-item ea-entrance" data-category="<?php echo esc_attr( implode( ' ', $item['categories'] ) ); ?>">
						<summary class="ea-faq-item__question"><?php echo esc_html( $item['q'] ); ?></summary>
						<div class="ea-faq-item__answer"><?php echo wp_kses_post( $item['a'] ); ?></div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php return; endif; ?>
```
(`chap`/`h2` משתמשים באותם class names בדיוק ש-`chapters.css` כבר מגדיר עבור `faq.php` — ר' §7 R4 לגבי ה-wrapper החיצוני, שנשאר `.ea-faq-list` ולא `.sec/.wrap.center`, במכוון, כדי לתאום את התקדים הקיים כבר ב-/faq עצמו.)

**שינוי 4 — הלולאה הראשית (סעיף לא-view-only, שורות ~481-489 ו-~504-512):** שתי ההשוואות `$item['category'] === $slug` → `in_array( $slug, $item['categories'], true )` (גם ב-loop של בניית ה-TOC וגם ב-loop הראשי של רינדור הקטגוריות). זה בדיוק מה שגורם לשאלה בעלת שתי קטגוריות להופיע **פעמיים** ב-/faq — פעם בכל section — התנהגות שאושרה במפורש במוקאפ המאושר של team_00 (`t2-faq-category-model_mockup.html` שורה 139: "אותה שאלה מופיעה תחת שתי הקטגוריות בו-זמנית").

### 3.6 `template-parts/chapters/parts/faqblock.php` — הרחבת ה-args passthrough

היום (15-19) מעביר רק `cat` יחיד. מוצע — תמיכה גם ב-`cats` (מערך) וגם ב-heading אופציונלי, back-compat מלא עם `cat`:

```php
<?php
defined( 'ABSPATH' ) || exit;
$a = isset( $args ) && is_array( $args ) ? $args : array();

$ea_fb_args = array();
if ( ! empty( $a['cats'] ) && is_array( $a['cats'] ) ) {
	$ea_fb_args['ea_faq_only_categories'] = $a['cats'];
} elseif ( ! empty( $a['cat'] ) ) {
	$ea_fb_args['ea_faq_only_category'] = $a['cat'];
}
if ( ! empty( $a['chap'] ) ) {
	$ea_fb_args['ea_faq_view_chap'] = $a['chap'];
}
if ( ! empty( $a['title'] ) ) {
	$ea_fb_args['ea_faq_view_title'] = $a['title'];
}

get_template_part( 'template-parts/blocks/block', 'faq-list', $ea_fb_args );
```

### 3.7 `template-parts/chapters/parts/faq.php` — מיותר לאחר הפורט, מוצע למחיקה

מאומת: `'part' => 'faq'` (מפנה ל-קובץ הזה) מופיע **רק** ב-10 קבצי ה-`-defaults.php` שהמשימה הזו מפרטת (grep ממצה על כל `inc/chapters/defaults/*.php`). אחרי §3.8/§3.9 (למטה), 0 קריאות נותרות אליו. מוצע למחוק אותו כחלק מ-T2 (לא להשאיר קוד מת חדש — בדיוק הרוח של כל יוזמת WP-CANON) — ולא כחלק מ-T6, כי T2 הוא מה שיוצר את המצב-המת הזה. סיכון נמוך: גיט שומר היסטוריה, ואין תלות חיצונית מתועדת.

### 3.8 עשרת קבצי ה-`*-defaults.php` (+`lessons-defaults.php`) — פורט מכני

לכל אחד מ-11 הקבצים: להחליף את בלוק ה-`'part' => 'faq'` (או, ל-`lessons`, את בלוק ה-`'part' => 'prose'` שמזוהה כ-FAQ) בבלוק `'part' => 'faqblock'` עם `cats` + אותם `chap`/`title` שכבר קיימים היום (כדי לא לאבד את הכותרת). ר' טבלה מלאה + מספרי שורה מדויקים ב-§4.1.

### 3.9 `method-defaults.php` + `page-templates/tpl-chapters-method.php` — מקרה מיוחד אמיתי

מפורט במלואו ב-§4.2 — כולל למה זה לא "עוד אחד מ-11" (תבנית קבועת-מפתחות, לא `'sections' => array()`).

---

## 4. פורטינג — 10 עמודי mini-FAQ + `lessons` + `method`

### 4.1 הטבלה המלאה — 11 העמודים ה"רגילים" (כולל `lessons`)

כל אחד מהשורות למטה מקבל **את אותו שינוי מכני**: להחליף את הבלוק שמצוין ב"קובץ:שורה" ב-`array( 'part' => 'faqblock', 'args' => array( 'chap' => …, 'title' => …, 'cats' => array( '{slug}' ) ) )`, שומר את `chap`/`title` הקיימים היום מילה-במילה.

| # | עמוד (slug) | קובץ + שורת-עוגן לבלוק הישן | קטגוריה חדשה | פריטים מקומיים היום | פריטים במאגר היום | הערה |
|---|---|---|---|---|---|---|
| 1 | `/treatment/` | `treatment-defaults.php:150` (`/* FAQ */` עד `),` הסוגר) | `treatment` | 15 | 15 | תוכן שונה בניסוח בין המקורות — ר' §7 R1, לדוגמה מצוטטת |
| 2 | `/sound-healing/` | `sound-healing-defaults.php:121` | `sound-healing` | 8 | 8 | כמעט-זהה, רק חסר `<p>` wrapping מקומית — ר' §7 R2 |
| 3 | `/bags/` | `bags-defaults.php:139` | `bags` | 7 | 7 | |
| 4 | `/didgeridoos/` | `didgeridoos-defaults.php:140` | `didgeridoos` | 5 | 5 | |
| 5 | `/repair/` | `repair-defaults.php:135` (יש גם `'id' => 'faq'` בשורה 141 — לשמר, יש אנקור `#faq` פעיל) | `repair` | 6 | 6 | כמעט-זהה, פיסוק שונה בלבד |
| 6 | `/stands-storage/` | `stands-storage-defaults.php:174` | `stands-storage` | 5 | 5 | |
| 7 | `/stand-floor/` | `stand-floor-defaults.php:123` | `stand-floor` | 4 | 4 | |
| 8 | `/vekatavta/` | `vekatavta-defaults.php:115` | `vekatavta` **(חדשה)** | 7 | 0 | ספר — אין מקבילה במאגר, מונח חדש |
| 9 | `/kushi-blantis/` | `kushi-blantis-defaults.php:116` | `kushi-blantis` **(חדשה)** | 6 | 0 | ספר — אין מקבילה במאגר, מונח חדש |
| 10 | `/tsva-bekahol/` | `tsva-bekahol-defaults.php:99` | `tsva-bekahol` **(חדשה)** | 5 | 0 | ספר — אין מקבילה במאגר, מונח חדש |
| 11 | `/lessons/` | `lessons-defaults.php:179` — **`'part' => 'prose'`, לא `'faq'`!** להחליף גם את סוג ה-part | `lessons` | 8 (כ-prose) | 8 | ר' §0 תיקון 2 — LOD300 C-4 שגוי כאן; זו לא "אין FAQ", זו "FAQ-כפרוזה", אותו מנגנון פורט בדיוק |

**מונח `general` (15 פריטים במאגר) — לא נוגעים בו כאן.** אין עמוד mini-FAQ תואם; ממשיך להופיע רק ב-/faq (סינון ריק = כל הקטלוג).

**דוגמה קונקרטית לפער-ניסוח (למקבל ההחלטה בשלב המיגרציה, §3.3/§5):** השאלה "מה זה בעצם טיפול בדיג'רידו?" — גרסת המאגר (`block-faq-list.php:40`): *"טיפול בדיג'רידו הוא תהליך **אישי** שבו עובדים באופן אקטיבי עם הנשימה, **באמצעות נגינה בדיג'רידו ככלי עבודה**."* גרסת העמוד (`treatment-defaults.php:156`): *"טיפול בדיג׳רידו הוא תהליך שבו עובדים באופן אקטיבי עם הנשימה **היומיומית**, **באמצעות תרגול בדיג׳רידו, למידה וליווי אישי**."* — לא variant טיפוגרפי, שני ניסוחים ממשיים לאותה שאלה (וגם מוסכמת גרש שונה: `'` מול `׳`). המלצה: ברירת-מחדל = **גרסת העמוד המקומי** כקנוני (בד"כ המפורטת/העדכנית יותר, ר' גם `method` בהמשך), אבל **כל שורה בסקריפט ה-extraction (§3.3) צריכה עבור-על אנושי לפני שהיא נכנסת ל-seed JSON** — לא merge אוטומטי עיוור.

### 4.2 `method` — המקרה המיוחד האמיתי

**זה לא "עוד אחד מ-11" — סיבה ארכיטקטונית של ממש, לא רק תוכן.** `method-defaults.php` (מוחזר ע"י `ea_chapters_defaults()`, `chapters-render.php:127-136`) **אינו** מכיל מפתח `'sections' => array(…)` בכלל — הוא מערך שטוח עם מפתחות קבועים (`phero_*`, `split_*`, `mag_*`, `uniq_*`, `bleed_*`, `whom_*`, `testi_*`, `cta_*`). זה כי `method` מנותב ל-`tpl-chapters-method` (`chapters-render.php:34`, לא `tpl-chapters-page` הגנרי), ו-`page-templates/tpl-chapters-method.php` (102 שורות) קורא ל-`get_template_part()` בפירוש, ברצף קשיח לפי שם — **אין** לולאה גנרית שמפרשת `'part' => 'x'` (בהשוואה ל-`tpl-chapters-page.php:45-58`, שכן יש בה לולאה כזו). המשמעות המעשית: **אי אפשר "לפרוט" את `method` רק ע"י עריכת ה-defaults array — חובה לערוך את קובץ ה-PHP template עצמו.**

**מיקום ה-FAQ היום:** `method-defaults.php:83-114`, קטע בתוך המחרוזת הענקית `split_body` (השרשור הארוך שמתחיל בשורה 32) — `<h3>שאלות נפוצות על השיטה</h3>` (שורה 83) ואז 7 (!) זוגות `<p><strong>שאלה</strong></p><p>תשובה…</p>` עד שורה 114, אחריו שורה ריקה (115) ואז `<h3>מה אנשים חווים לאורך הדרך</h3>` (116, ה-testimonials).

**ממצא נוסף — 7 שאלות בעמוד, רק 6 במאגר.** קטגוריית `method` במאגר המרכזי מכילה 6 פריטים (בדוק, ר' §0). ב-`split_body` יש **7**: השאלה החריגה — *"האם השיטה מתאימה גם למקרים שאינם קשורים ישירות לנשימה, כמו מערכת העיכול, מערכת העצבים או המערכת ההורמונלית?"* (`method-defaults.php:106-109`) — **לא קיימת במאגר בכלל.** אם המיגרציה תסתמך על המאגר בלבד, השאלה הזו תיעלם משם. חובה להוסיף אותה כפריט חדש בקטגוריית `method` ב-seed JSON (ר' §3.3).

**מהלך הפורט — שני שינויים נפרדים:**

**(א) `method-defaults.php`** — להסיר את שורות 83-114 (כולל ה-`<h3>` עצמו) מתוך שרשור `split_body`, כך שהפרוזה תמשיך ישר מ"...לאורך המפגש..." (שורה 81) ל-"מה אנשים חווים לאורך הדרך" (116) בלי הקטע שהוצא.

**(ב) `page-templates/tpl-chapters-method.php`** — הוספת קריאה חדשה ל-`faqblock`, במיקום מדויק: **אחרי** הקריאה ל-`reveals` (whom, שורות 75-79, "למי השיטה מתאימה") **ולפני** הקריאה ל-`testimonials` (testi, שורות 81-85, "מה אנשים חווים"). המיקום הזה נגזר ישירות מסדר-התוכן המקורי שהערת ה-docblock (`method-defaults.php:11`) עצמה מתעדת: *"...how-a-session-works, FAQ, what-people-experience..."* — FAQ בין "איך עובד מפגש" ל"מה אנשים חווים" — ו-`testi_title` (שורה 173 של הקובץ, "מה אנשים חווים לאורך הדרך") הוא ה-match המילולי ל-"what-people-experience". להוסיף בין שורה 79 ל-81:

```php
	get_template_part( 'template-parts/chapters/parts/faqblock', null, array(
		'cats'  => array( 'method' ),
		'chap'  => 'שאלות נפוצות',
		'title' => 'שאלות נפוצות על השיטה',
	) );
```

(`chap`/`title` שאולים מ-`<h3>שאלות נפוצות על השיטה</h3>` שהוסר משלב א' — כך אין אובדן כותרת.)

---

## 5. רצף בנייה מדורג (כולל מיגרציה)

0. **Pre-flight (לפני שורת קוד אחת):**
   a. לאמת ב-staging: `wp post list --post_type=ea_faq --format=count` (או שווה-ערך ב-wp-admin: תפריט "שאלות נפוצות (אינסטנסים)") — לוודא 0 פוסטים היום (הנחת-העבודה של §2; אם לא 0, לעצור ולברר מה כבר שם לפני שממשיכים).
   b. לאמת חזותית (browser QA, `qa_probe.mjs` לפי המנדט הקבוע של הריפו — לא curl) את `/faq/` היום: להריץ Console/DevTools ולבדוק אם ל-`.ea-faq-item`/`.ea-faq-list` יש בכלל CSS פעיל. יש חשד מבוסס-קוד (לא מאומת חי מסביבה זו — ניווט דפדפן לסביבת ה-staging נחסם באופן טכני בסשן הזה) שהעיצוב שלהם תלוי ב-`w2-04-service.css`/`ea-atoms.css`, שנטענים רק כש-`ea_w2_04_is_wave2_page()`/`ea_wave2_is_active_view()` מחזירים `true` — כלומר סביר שלא נטענים היום בעמוד `/faq` (Chapters-routed). ר' §7 R4 — קריטי לבצע **לפני** שמפזרים את אותם class names ל-11 עמודים נוספים.
1. **Taxonomy:** להוסיף את בלוק `register_taxonomy('ea_faq_cat', …)` (§3.1), לפרוס, לוודא ב-wp-admin שמופיעה תת-תפריט "קטגוריות שאלות נפוצות" תחת "שאלות נפוצות (אינסטנסים)", עדיין ריקה ממונחים.
2. **Extraction + עיבור-על אנושי:** להריץ סקריפט חד-פעמי (§3.3) שמפיק טיוטת `ea-faq-seed.json` עם `bank_text`/`local_text` צמודים; בעל-תוכן (team_100 או אייל) בוחר נוסח סופי לכל שורה; להוסיף את 18 פריטי הספרים + פריט ה-`method` החדש (§4.2) שאין להם מקבילה קיימת; לשמור JSON סופי (בלי שדות `bank_text`/`local_text` העזר).
3. **Migration dry-run:** `wp ea-faq migrate --dry-run` (§3.4) — לבדוק את הפלט (כמה מונחים/פוסטים ייווצרו, מול הציפייה: 13 מונחים, ~98 פוסטים).
4. **Migration אמיתית:** `wp ea-faq migrate` בסטייג'ינג; לתקן שמות מונחים בעברית (הערה ב-§3.4); לבדוק ידנית 5 פוסטים אקראיים ב-wp-admin (כותרת=שאלה, תוכן=תשובה, מונחים משויכים נכון).
5. **פונקציות עזר:** להוסיף `ea_faq_get_categories()`+`ea_faq_query_items()` (§3.2).
6. **`block-faq-list.php`:** ארבעת השינויים (§3.5) — מקור נתונים, נרמול args, view-only branch, לולאות הסינון.
7. **`faqblock.php`:** הרחבת ה-passthrough (§3.6).
8. **11 קבצי ה-defaults ה"רגילים":** פורט מכני לפי טבלת §4.1, אחד בכל פעם, עם בדיקה חזותית מיידית אחרי כל אחד (`qa_probe.mjs` על אותו עמוד — השוואת ספירת-שאלות לפני/אחרי כ-smoke test).
9. **`method`:** שני השינויים מ-§4.2 (עריכת prose + עריכת template).
10. **מחיקת `faq.php`:** אחרי שכל 12 הקריאות הישנות (10+lessons+method הישן) הוחלפו, ואומת שאין קריאה נותרת (`grep -rn "parts/faq'" .`).
11. **QA מלא (מקדים ל-T7):** לעבור בדפדפן על `/faq/` + כל 11 העמודים; לוודא ספירת-שאלות תואמת; לבדוק תרחיש many-to-many אחד אמיתי (לשייך שאלה קיימת לשתי קטגוריות ב-wp-admin, לוודא הופעה בשני המקומות).

---

## 6. קריטריוני קבלה (Acceptance Criteria)

1. **wp-admin:** בעריכת פוסט מסוג "שאלה נפוצה", יש meta-box "קטגוריות שאלות נפוצות" עם checkbox לכל אחד מ-13 המונחים; סימון 2+ ושמירה — משויך בפועל (מאומת דרך `wp_get_post_terms()` או תצוגת ה-admin column).
2. **`/faq/`:** מספר השאלות המוצגות = מספר הפוסטים המפורסמים ב-`ea_faq` (בדיקת ספירה, לא תוכן-מדויק); כל 13 הקטגוריות (כולל 3 קטגוריות הספרים) מופיעות ככותרות section כשיש להן תוכן.
3. **כל אחד מ-11 עמודי ה-mini-FAQ (הטבלה ב-§4.1):** מציג **רק** את שאלות הקטגוריה שלו, עם אותה כותרת section (`chap`/`title`) שהייתה קיימת לפני הפורט — מספר שאלות זהה למספר לפני הפורט (טבלת §4.1, עמודת "פריטים מקומיים היום"), אלא אם עבר-על-התוכן שינה במכוון.
4. **`/method/`:** מציג section "שאלות נפוצות על השיטה" כאקורדיון (`<details>`, לא פרוזה) עם 7 שאלות, ממוקם בין "למי השיטה מתאימה" ל"מה אנשים חווים לאורך הדרך".
5. **תרחיש many-to-many קונקרטי:** שיוך שאלה קיימת לשתי קטגוריות ב-wp-admin (למשל treatment+method) → מופיעה תחת שתי הכותרות ב-/faq **וגם** בעמודים `/treatment/` ו-`/method/` בנפרד — בלי לשכפל את הפוסט עצמו (post ID יחיד).
6. **Back-compat:** `inc/wave2-w2-04.php:ea_w2_04_render_faq()` ו-`inc/wave2-w2-05.php` (הקריאה המקבילה) ממשיכים לרוץ בלי PHP fatal/warning כשנקראים עם `ea_faq_only_category` יחיד (גם אם לא מוצגים בפועל בניתוב היום) — לבדוק ע"י קריאה ישירה לפונקציה ב-WP-CLI `wp eval`, לא רק דרך הדפדפן.
7. **קטגוריה ריקה:** מחיקת/עריכת מונח כך שנשאר ללא פוסטים לא גורמת לשגיאה בעמוד המקביל — מציג "תוכן בהכנה — אין עדיין שאלות מפורסמות בקטגוריה זו" (ההודעה הקיימת כבר, `block-faq-list.php:515`), לא דף לבן.
8. **0 שגיאות/warnings** ב-PHP error log בזמן טעינת `/faq/` וכל 11 העמודים (baseline standard).
9. **`template-parts/chapters/parts/faq.php`:** 0 קריאות נותרות בקוד (מאומת `grep`), הקובץ נמחק.

---

## 7. Edge cases / סיכונים

| # | סיכון | חומרה | מיטיגציה מוצעת |
|---|---|---|---|
| **R1** | **פערי ניסוח בין המאגר לעותקים המקומיים** — לא טעות הקלדה, ניסוחים שונים ממש (לדוגמה מלאה ב-§4.1). מיזוג אוטומטי-עיוור עלול לפרסם תוכן שלא עבר אישור. | גבוה | עבור-על אנושי חובה לכל item ב-seed JSON (§5 שלב 2), לא אוטומציה מלאה |
| **R2** | **התנגשות מוסכמת HTML:** `faq.php` עוטף `$it['a']` ב-`<p>` בעצמו (שורה 20); רינדור המאגר לא עוטף (מצפה ש-`'a'` כבר מכיל `<p>`/`<ul>`). פורט-בטעות דרך `faq.php` (או שמירת seed-תוכן בלי `<p>` משלו) ↦ `<p>` מקוננים/פסקאות שנעלמות. | גבוה (regression חזותי שקט) | כל 11 העמודים חייבים לעבור **רק** דרך `faqblock`→`block-faq-list.php` (§3.5/3.6), לא `faq.php`; `a` ב-seed JSON תמיד עם `<p>` מפורש (§3.3) |
| **R3** | **אובדן כותרת section:** ה-view-only branch הקיים היום (`block-faq-list.php:456-475`) לא מרנדר `chap`/`h2` בכלל. פורט נאיבי (רק להחליף `'part'` בלי להוסיף heading, §3.5 שינוי 3) מוחק חזותית כותרת "שאלות נפוצות" מ-11 עמודים בבת אחת. | גבוה | תוקן בעיצוב עצמו (§3.5 שינוי 3) — לא להתעלם ולדלג על התוספת |
| **R4** | **תלות CSS ב-Wave2:** `.ea-faq-item`/`.ea-faq-list`/`.ea-faq-category` מוגדרים רק ב-`w2-04-service.css`+`ea-atoms.css`, שניהם gated מאחורי גילוי-Wave2 (`ea_w2_04_is_wave2_page()`/`ea_wave2_is_active_view()`) שכנראה `false` בעמודי Chapters. **חשד סביר, לא מאומת חי** (ניווט לדפדפן נחסם בסביבה זו) שהאקורדיון ב-/faq כבר לא מעוצב היום. אם כן — T2 מפזר בעיה קיימת ל-11 עמודים נוספים. | **קריטי לבדוק לפני build** | Pre-flight חובה (§5 שלב 0b) עם `qa_probe.mjs`; אם מאושר — להעביר/לשכפל את כללי `.ea-faq-*` הרלוונטיים אל `chapters.css` (מנתק את Chapters-FAQ מתלות ב-Wave2 CSS לגמרי — מועיל גם ל-T6, ר' R6 למטה) |
| **R5** | **Back-compat ארג':** `inc/wave2-w2-04.php:338`, `inc/wave2-w2-05.php:421` קוראים ל-`block-faq-list.php` עם `ea_faq_only_category` יחיד, ישירות (לא דרך `faqblock.php`). שני קבצי Wave2 האלה עדיין `require_once`-ים תמיד (functions.php:872,877) — לא מתים ברמת PHP, גם אם לא מגיעים בניתוב היום. שינוי חוזה הארג' בלי לשמר תאימות ↦ שבירה שקטה כש/אם T6 טרם רץ. | בינוני | הנרמול המוצע (§3.5 שינוי 2) תומך בשני הארגומנטים; לבדוק דרך `wp eval` (Acceptance #6), לא להניח |
| **R6** | **`ea_faq` CPT לא מאומת ריק** — אין גישת DB/WP-CLI מסביבת המחקר הזו לאשר 0 פוסטים היום. | בינוני | Pre-flight חובה (§5 שלב 0a); סקריפט המיגרציה אידמפוטנטי ומגונן ב-`_ea_faq_seed_key` בכל מקרה |
| **R7** | **URL ציבורי חדש לכל שאלה** (`/faq-item/{slug}/`, ~98 יחידות) הופך live+indexable ברגע הפרסום (תופעת-לוואי של רישום ה-CPT הקיים, `functions.php:331-343`, לא המצאה של T2). ~98 עמודים דקים/כפולי-תוכן בלי החלטה = סיכון SEO אמיתי. | בינוני-גבוה (SEO) | להכריע במפורש (team_00/אייל) לפני go-live: noindex לסינגלים + canonical ל-`/faq/#{anchor}`, או לקבל את זה כהזדמנות (כל שאלה יכולה לשאת Question/Answer schema עצמאי — משרת את T4). ברירת מחדל מוצעת עד להכרעה: **noindex** |
| **R8** | **`hierarchical=>true` נועד ל-UI, לא לסמנטיקה** — אם מפתח עתידי ינסה להגדיר "קטגוריית-אב" ל-FAQ (ניצול ה-hierarchy), זה יסתור את ההנחה שכל 13 המונחים שטוחים. | נמוך | תיעוד מפורש בהערת קוד ליד ה-`register_taxonomy` (§3.1 — כבר כלול בהצעה) |
| **R9** | **סטייה מ-`ea_testimonial_cat`:** `public=>false` ל-`ea_faq_cat` (§2) שונה מהתקדים המדויק שהמשימה ביקשה למראות. | נמוך (מכוון, מנומק) | מתועד במפורש כסטייה מודעת (§2) — לא שגיאה |
| **R10** | **סדר תצוגת קטגוריות** — ל-WP terms אין "menu_order" מובנה כמו לפוסטים. הסתמכות על `orderby=>'term_id'` (סדר-יצירה) דורשת שסקריפט ה-migration ייצור מונחים **בסדר הנכון** (התואם את הסדר החזותי הקיים היום ב-/faq: treatment→lessons→sound-healing→method→didgeridoos→bags→stands-storage→stand-floor→repair→general→[3 ספרים]) — טעות סדר בסקריפט = שינוי שקט בסדר הקטגוריות ב-/faq. | בינוני | לציין את סדר-היצירה הנדרש כפרמטר מפורש בקובץ ה-seed JSON (סדר ה-`items` הראשונים לכל קטגוריה חדשה קובע), לא להסתמך על סדר case-by-case |
| **R11** | **Git-diffability:** תוכן FAQ עובר מקובץ-ערכה (PR-reviewable) ל-DB rows. אובדן audit-trail אם לא מטופל. | נמוך | קובץ ה-seed JSON (§3.3) נשאר בגיט לצמיתות כ"תמונת-מצב הראשונית" השחזורה; לשקול גיבוי תקופתי (`wp export --post_type=ea_faq`) אם audit-trail שוטף חשוב לצוות |
| **R12** | **ביצועים** — זניח בנפח הזה (~98 שורות, `no_found_rows=true`, אותה צורת שאילתה בדיוק כמו `ea_eyalamit_render_instance_catalog` הקיימת). | זניח | אין צורך ב-caching נוסף בשלב זה |

---

*נכתב כסעיף LOD400 עצמאי (T2 בלבד) — מיועד לאיחוד לתוך מסמך LOD400 מלא של WP-CANON-TEMPLATE-UNIFICATION לצד סעיפי T1/T3/T3b/T4/T5/T6/T7. כל הממצאים בו מאומתים ישירות מול קוד המקור בריפו (`site/wp-content/themes/ea-eyalamit/`), נכון ל-2026-07-14. לא בוצע כל שינוי בקבצי האתר — מסמך זה הוא תוצר מחקר/תכנון בלבד.*

---

# T3 — פורט תבנית מוצר (מחיר, CTA, גלריה) — LOD400

> פריטה ברמת LOD400 (build spec מלא) של T3 מתוך `WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md` §2. מבוסס על מחקר קוד ישיר בריפו `EyalAmit.co.il-2026`, תיאטרון `site/wp-content/themes/ea-eyalamit/`. **מחקר בלבד — לא בוצע שום שינוי קוד באתר בסשן הזה.** כל שם קובץ/פונקציה/מספר שורה במסמך אומת ישירות מול הקוד הקיים (לא הונח).

---

## 0. תקציר ממצאי המחקר (הקשר לפני 6 הסעיפים המבוקשים)

- **הניתוב מאומת:** `ea_chapters_route_map()` (`inc/chapters/chapters-render.php:40-44`) ממפה את 5 הסלאגים (`didgeridoos`, `bags`, `stands-storage`, `stand-floor`, `repair`) לתבנית `tpl-chapters-page` — כולם. הפילטר `ea_chapters_template_include()` רץ ב-`template_include` עדיפות **103** (`inc/chapters/chapters-routing.php:41`) ומנצח את `ea_w2_05_template_include()` שרץ בעדיפות **100** (`inc/wave2-w2-05.php:89`). לכן `page-templates/tpl-shop-item.php` (ה-shell של Wave2) קיים על הדיסק אך **בלתי-נגיש** ל-5 הסלאגים האלה היום — קוד מת בפועל, לא נמחק (T6).
- **מנגנון הרינדור של Chapters:** `page-templates/tpl-chapters-page.php:41-60` מרנדר קודם `phero` (H1), ואז לולאה על מערך `sections` — כל איבר `['part'=>X,'args'=>Y]` נטען דרך `get_template_part('template-parts/chapters/parts/'.X, null, Y)`. **אין `while(have_posts())` בתבנית הזו** — חשוב לסעיף ה-post-ID למטה.
- **מקור התוכן:** `inc/chapters/defaults/{slug}-defaults.php` — מערך PHP סטטי (`require`), נטען דרך `ea_chapters_defaults()` (`inc/chapters/chapters-render.php:127-136`).
- **המצב היום בפועל בכל 5 העמודים:** כל אחד מ-5 קבצי ה-defaults מסתיים בסקשן `'part' => 'cta'` גנרי יחיד (מרונדר ע"י `template-parts/chapters/parts/cta.php`, המשותף ל-**15** עמודים באתר — ר' §2 להיגיון "אל תיגע"). אין מחיר, אין הבחנה רכישה/יצירת-קשר, אין גלריה.
- **פונקציות Wave2 הרלוונטיות — כולן כבר טעונות תמיד**, ללא תלות בניתוב, כי `functions.php:857` (`wave2-stage-b.php`) ו-`functions.php:877` (`wave2-w2-05.php`) הם `require_once` בלתי-מותנים:
  - `ea_w2_05_price( $post_id )` — `inc/wave2-w2-05.php:261-265` — קורא `ea_product_price` postmeta, `trim`, נופל ל-`'מחיר לפי התאמה'` כשריק.
  - `ea_w2_05_gi_url_map()` / `ea_w2_05_gi_url( $slug )` — `inc/wave2-w2-05.php:234-253` — מפת URL-י חשבונית-ירוקה, **ריקה לכל 5 המוצרים היום** (כל ערך `''`).
  - `ea_wave2_wa_url( $msg = '' )` — `inc/wave2-stage-b.php:22-27` — בונה `https://wa.me/972524822842?text=...`.
- **התאמת ה-postmeta ל-schema כבר קיימת ותלוית-postmeta בלבד:** `mu-plugins/ea-w2-seo-schema.php:119-147` — הצומת `Product`/`Offer` מתווסף בכל `is_page()` שבו `metadata_exists('post','ea_product_price')` אמת, ומוסיף `offers` רק כש-`is_numeric($price)` (כלומר לא כשהמחיר הוא מחרוזת ה-fallback). **קוד זה תלוי-postmeta בלבד, לא בתבנית/מנוע-רינדור** — אומת ישירות (זה בדיוק מה שהתבקש לאמת). המשמעות: ברגע שאייל יזין מחיר מספרי אמיתי, ה-Offer schema יופיע אוטומטית ב-5 העמודים בלי שום שינוי קוד נוסף.
- **פער אמיתי שנמצא, לא ידוע קודם:** **אין שום מנגנון בזמן ריצה להזנת `ea_product_price` מ-wp-admin** — נבדק בגריפ מקיף (`add_meta_box`, `register_post_meta`, `acf_add_local_field_group`) בכל התיאטרון וב-mu-plugins: אין תוצאה עבור `ea_product_price`. הדרך היחידה להזין ערך היא פאנל ה-"Custom Fields" הגולמי המובנה של וורדפרס (זמין כברירת מחדל ל-post type `page`, אך דורש הפעלה חד-פעמית ב-Preferences → Panels של עורך הבלוקים). זהו מצב **קיים כבר ב-Wave2**, לא נוצר ע"י T3 — ר' §6.
- **באג קיים שנמצא (לא נגרם ע"י T3, אך חוסם את קריטריון הקבלה שלה):** `assets/js/ea-ab-testing.js` **נטען פעמיים** בכל 6 עמודי W2-05 (5 מוצרים + `/shop`) תחת שני handles שונים לאותו קובץ — ר' §6 לפירוט המלא ולתיקון המוצע.

---

## 1. מטרה

לפרסם מחיר (`ea_product_price` postmeta) וכפתור רכישה/יצירת-קשר (עם נפילה חינה ל-WhatsApp/טופס בהיעדר קישור סליקה) בחמשת עמודי המוצר ב-Chapters, תוך שימוש חוזר מלא בלוגיקת ה-PHP הקיימת של Wave2 (לא שכתוב) ובתבנית ה-CTA המוכחת-חיה של `contact.php` — ללא נגיעה ברכיב ה-CTA הגנרי המשותף ל-15 עמודים אחרים. גלריה אינה נבנית עכשיו (אין תמונות אמיתיות, ר' §4).

---

## 2. קבצים לשינוי/יצירה — מדויק

### 2.1 קובץ חדש: `template-parts/chapters/parts/product-cta.php`

רכיב Chapters ייעודי חדש (**לא** הרחבה של `cta.php` הקיים — ר' נימוק ב-§6.7). המעטפת המבנית (`.sec`/`.wrap`/`.h2`/`.chap`) היא Chapters-נייטיבית; שורת המחיר וכפתורי ה-CTA משתמשים **ב-CSS הקיים של Wave2 כפי שהוא** (`.ea-product-price`, `.ea-cta-ab`, `.ea-cta-pill`, `.ea-cta-pill--primary`, `.ea-cta-pill--whatsapp`) — כל המחלקות האלה **כבר טעונות בפועל** ב-5 העמודים האלה היום (ר' §2.3), ולכן **לא נדרש שום CSS חדש**. זהו בדיוק אותו דפוס-ערבוב שכבר קיים וחי היום ב-`template-parts/chapters/parts/contact.php:76-79` (הכפתור "דברו איתי בוואטסאפ" — עטיפה `.sec`/Chapters, כפתור `.ea-cta-pill`/Wave2) — לא דפוס חדש שאני ממציא, אלא תבנית מוכחת שכבר בפרודקשן.

**חוזה ה-`$args` (לצירוף ל-docblock בראש הקובץ):**

| מפתח | סוג | חובה | תיאור |
|---|---|---|---|
| `slug` | string | **כן** | סלאג המוצר: `didgeridoos`\|`bags`\|`stands-storage`\|`stand-floor`\|`repair` — משמש לחישוב ה-GI URL, ה-`data-product-slug`, וכתובת ה-contact fallback |
| `title` | string | לא | כותרת H2 |
| `body` | string | לא | פסקת טקסט תומכת (plain text — `esc_html`, לא HTML, תואם בדיוק לאיך שה-`body` הקיים בסקשן ה-`cta` הישן מוזן היום בכל 5 הקבצים) |
| `price_note` | string | לא | הערת-קטן מתחת למחיר (לא בשימוש בשלב זה — ר' §6.2) |
| `gi_label` | string | לא | טקסט כפתור חשבונית-ירוקה; ברירת מחדל `'לרכישה מאובטחת'` (תואם ברירת המחדל של Wave2) |
| `contact_label` | string | לא | טקסט כפתור יצירת-קשר; ברירת מחדל `'לתיאום והתאמה'` |
| `alt` | bool | לא | רקע `.sec--alt` (ברירת מחדל `false`) — ר' §3 שלב 3 לקביעה לכל עמוד |
| `id` | string | לא | עוגן anchor |

**תוכן הקובץ המלא המוצע:**

```php
<?php
/**
 * Chapters part — product price + purchase/contact CTA (WP-CANON-TEMPLATE-UNIFICATION T3).
 * Reuses (does NOT duplicate) the Wave2 accessors — single source of truth for price,
 * the Green-Invoice URL map, and the WhatsApp URL builder:
 *   ea_w2_05_price()   — inc/wave2-w2-05.php:261-265
 *   ea_w2_05_gi_url()  — inc/wave2-w2-05.php:250-253 (map: inc/wave2-w2-05.php:234-241)
 *   ea_wave2_wa_url()  — inc/wave2-stage-b.php:22-27
 * Structural wrapper (.sec/.wrap/.chap/.h2) is Chapters-native; the price line + CTA
 * buttons reuse Wave2's .ea-product-price / .ea-cta-pill / .ea-cta-ab classes verbatim —
 * same mixing pattern already shipped in template-parts/chapters/parts/contact.php:76-79.
 * Zero new CSS: w2-05-shop.css + ea-atoms.css (which define all classes used here) are
 * already enqueued on these 5 pages today via ea_w2_05_assets() (slug-gated, template-
 * independent) and ea_wave2_enqueue_assets() (ea_wave2_shell-gated, set unconditionally
 * for every Chapters view by inc/chapters/chapters-routing.php's template_redirect hook).
 * data-* attributes match ea_w2_05_render_cta()'s contract exactly, so the already-loaded
 * assets/js/ea-ab-testing.js wires the A/B display + GA4 product_cta_click automatically
 * — zero new JS. (Prerequisite: the double-enqueue fix in §2.4 must land first, or the
 * click event double-fires — see LOD400 §6.3.)
 *
 * $args:
 *   slug          (string, REQUIRED) — didgeridoos|bags|stands-storage|stand-floor|repair
 *   title         (string) — H2 heading
 *   body          (string, plain text) — supporting paragraph
 *   price_note    (string, optional) — small print under the price line
 *   gi_label      (string, optional) — Green-Invoice button label; default 'לרכישה מאובטחת'
 *   contact_label (string, optional) — contact/form button label; default 'לתיאום והתאמה'
 *   alt           (bool, optional) — sec--alt background; default false
 *   id            (string, optional) — section anchor id
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a    = isset( $args ) && is_array( $args ) ? $args : array();
$slug = isset( $a['slug'] ) ? (string) $a['slug'] : '';
$alt  = ! empty( $a['alt'] );

// Reuse — NOT duplicate — the Wave2 accessors (single source of truth).
// get_queried_object_id() (not get_the_ID()): tpl-chapters-page.php has no have_posts()/
// the_post() Loop, so global $post is not guaranteed populated. get_queried_object_id()
// is the pattern already proven elsewhere in this exact codebase for the same situation
// (ea_chapters_current_slug(), inc/chapters/chapters-render.php:85; and the schema Product
// node, mu-plugins/ea-w2-seo-schema.php:121).
$post_id = get_queried_object_id();
$price   = function_exists( 'ea_w2_05_price' ) ? ea_w2_05_price( $post_id ) : '';
$gi      = ( '' !== $slug && function_exists( 'ea_w2_05_gi_url' ) ) ? ea_w2_05_gi_url( $slug ) : '';
$wa      = function_exists( 'ea_wave2_wa_url' )
	? ea_wave2_wa_url( 'היי אייל, מתעניין/ת במוצר מהאתר ואשמח לפרטים' )
	: 'https://wa.me/972524822842';
$contact = home_url( '/contact?subject=product-' . rawurlencode( $slug ) );
?>
<section class="sec<?php echo $alt ? ' sec--alt' : ''; ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap center">
		<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
		<?php if ( ! empty( $a['body'] ) ) : ?><p class="lead r" style="margin-top:14px"><?php echo esc_html( $a['body'] ); ?></p><?php endif; ?>

		<p class="ea-product-price r" data-product-price style="margin-top:32px"><?php echo esc_html( $price ); ?></p>
		<?php if ( ! empty( $a['price_note'] ) ) : ?>
			<p class="ea-product-price__note r"><?php echo esc_html( $a['price_note'] ); ?></p>
		<?php endif; ?>

		<?php if ( '' !== $gi ) : ?>
			<div class="ea-cta-ab r" data-ea-product-cta data-product-slug="<?php echo esc_attr( $slug ); ?>" data-cta-type="green_invoice">
				<a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( $gi ); ?>" target="_blank" rel="noopener" data-ea-product-cta-link>
					<?php echo esc_html( ! empty( $a['gi_label'] ) ? $a['gi_label'] : 'לרכישה מאובטחת' ); ?>
				</a>
			</div>
		<?php else : ?>
			<div class="ea-cta-ab r" data-ea-product-cta data-product-slug="<?php echo esc_attr( $slug ); ?>" data-cta-type="contact" data-ea-page="product-<?php echo esc_attr( $slug ); ?>">
				<a class="ea-cta-pill ea-cta-pill--primary ea-cta-ab__form" href="<?php echo esc_url( $contact ); ?>" data-ea-ab-form data-ea-product-cta-link>
					<?php echo esc_html( ! empty( $a['contact_label'] ) ? $a['contact_label'] : 'לתיאום והתאמה' ); ?>
				</a>
				<a class="ea-cta-pill ea-cta-pill--whatsapp ea-cta-ab__wa" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener noreferrer" data-ea-ab-wa data-ea-product-cta-link>
					שליחת הודעה ב‑WhatsApp
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
```

**מה נבדק/אומת לפני שהצענו את הקובץ הזה (לא הנחות):**
- `.ea-cta-pill` (בסיס) + `.ea-cta-pill--primary` מוגדרים ב-`assets/css/ea-atoms.css:516,535`.
- `.ea-cta-pill--whatsapp`, `.ea-product-price`, `.ea-product-price__note`, `.ea-cta-ab` מוגדרים ב-`assets/css/w2-05-shop.css:196-230`.
- responsive מובנה כבר: `w2-05-shop.css:325-331` הופך `.ea-cta-ab` לעמודה במובייל (≤600px) ומרחיב כפתורים ל-100% — לא נדרש CSS נוסף למובייל.
- `.sec--alt`/`.sec--dark` הן שתי המחלקות המשנות היחידות הקיימות ל-`.sec` (`assets/css/chapters.css:99-103`) — לא הומצאה מחלקה לא-קיימת (`.sec--closing` **אינה** קיימת ולכן לא נעשה בה שימוש).
- ניגודיות פלטה: `--ea-ink:#2E2B28` (Wave2, `ea-tokens.css:12`) קרוב מאוד ל-`--ink:#2f2013` של Chapters (`chapters.css:18`); `--ea-font:'Heebo'...` (`ea-tokens.css:31`) זהה לגופן הבסיס של Chapters. ההבדל הצבעוני היחיד הנראה-לעין הוא `--ea-olive:#6E6F4A` (כפתור WhatsApp) מול `--terra:#B5663D` (מבטא Chapters) — סטייה מקובלת (כפתורי WhatsApp ירוקים הם קונבנציה מוכרת ברשת) וכבר קיימת ב-`contact.php` היום.

### 2.2 חמשת קבצי ה-defaults — `inc/chapters/defaults/{slug}-defaults.php`

**שינוי זהה בעיקרון בכל 5 הקבצים:** הסקשן האחרון במערך `sections` (כיום `'part' => 'cta'`) **מוחלף** (לא נוסף בנוסף) ב-`'part' => 'product-cta'`, באותו מיקום בדיוק (הסקשן האחרון לפני הרינדור מסתיים, ישירות אחרי הפרוזה הסוגרת). **לא מתווסף סקשן שני** — Wave2 עצמו (10-block contract, `inc/wave2-w2-05-content.php:45-53`) גם מחזיק בלוק `cta` יחיד, לא שניים; הכפלת ה-CTA (גנרי + ספציפי) הייתה יוצרת בלבול UX ולא תואמת את כוונת המקור.

הכותרת (`title`), הגוף (`body`) וטקסט הכפתור (`cta_label` → `contact_label`) **מועתקים verbatim** מהסקשן הקיים — אין המצאת קופי חדש.

#### 2.2.1 `didgeridoos-defaults.php` — שורות 176-185 (לפני → אחרי)

לפני:
```php
		/* CTA */
		array(
			'part' => 'cta',
			'args' => array(
				'title'     => "לבחור כלי זה לא רק לקנות כלי",
				'body'      => "זה לבחור משהו שתעבוד איתו לאורך זמן. משהו שיתאים לנשימה שלך, לקצב שלך, ולדרך שלך. אם זה מדויק לך, אפשר לעצור רגע, להגיע, ולהרגיש.",
				'cta_label' => "לתיאום הגעה ובחירת כלי",
				'cta_url'   => "/contact/",
			),
		),
```
אחרי:
```php
		/* Product price + purchase/contact CTA (T3) */
		array(
			'part' => 'product-cta',
			'args' => array(
				'slug'          => 'didgeridoos',
				'title'         => "לבחור כלי זה לא רק לקנות כלי",
				'body'          => "זה לבחור משהו שתעבוד איתו לאורך זמן. משהו שיתאים לנשימה שלך, לקצב שלך, ולדרך שלך. אם זה מדויק לך, אפשר לעצור רגע, להגיע, ולהרגיש.",
				'contact_label' => "לתיאום הגעה ובחירת כלי",
			),
		),
```

#### 2.2.2–2.2.5 שאר 4 העמודים — אותו דפוס בדיוק, ערכים מדויקים לפי הקובץ

| קובץ | שורות (לפני) | `slug` | `title` (מועתק verbatim) | `body` (מועתק verbatim) | `contact_label` (מ-`cta_label` הישן) |
|---|---|---|---|---|---|
| `bags-defaults.php` | 178-187 | `bags` | `שווה לשמור עליו כמו שצריך.` | `תיק נכון עושה את ההבדל בין כלי שנשמר לאורך שנים, לבין כלי שנשחק עם הזמן. אפשר להתאים תיק לפי סוג הכלי והאופן שבו אתה משתמש בו.` | `לתיאום והתאמה של תיק לדיג'רידו` |
| `stands-storage-defaults.php` | 190-199 | `stands-storage` | `רוצים סטנד שמתאים בדיוק לדיג'רידו שלכם?` | `אפשר להזמין סטנד לאחסון דיג'רידו, לתלייה על הקיר או בעמידה על הרצפה, עם התאמה לפי הצורך והמרחב. כל סטנד נבנה בעבודת יד, ומתוכנן להחזיק את הכלי בצורה יציבה, בטוחה ונגישה לאורך זמן.` | `לתיאום והזמנה` |
| `stand-floor-defaults.php` | 138-147 | `stand-floor` | `רוצה לבדוק אם זה מתאים לך?` | `אם אתה מנגן בישיבה נמוכה ומרגיש שהכלי לא יציב, הסטנד הזה יכול לשנות את החוויה בצורה מאוד פשוטה. אפשר ליצור קשר, לשאול, ולהבין אם זה מתאים לך ולסוג הכלי שלך.` | `ליצירת קשר` |
| `repair-defaults.php` | 164-173 | `repair` | `יש לך דיג'רידו שצריך בדיקה?` | `אפשר להביא אותו לבדיקה ולקבל הערכת מצב מקצועית, הסבר על אפשרויות התיקון ומתן הצעת מחיר לפני תחילת העבודה.` | `לתיאום בדיקה לכלי` |

בכל 5 המקרים: `'part' => 'cta'` → `'part' => 'product-cta'`, מפתח `'cta_url'` **מוסר לגמרי** (הכתובות מחושבות פנימית ב-`product-cta.php` מתוך `slug` — בדיוק כמו ש-`ea_w2_05_render_cta()` מתעלם מפרמטר URL חיצוני ומחשב הכל מה-`$slug`), ומתווסף `'slug' => '<הסלאג המדויק>'`.

### 2.3 קבצים שנקראים אך **לא משתנים** (לצמצום בלבול)

| קובץ | תפקיד | שינוי? |
|---|---|---|
| `template-parts/chapters/parts/cta.php` | הרכיב הגנרי המשותף ל-15 עמודים | **לא** — נשאר בדיוק כפי שהוא, כדי לא לפגוע ב-10 העמודים האחרים שמשתמשים בו |
| `assets/css/chapters.css` | עיצוב Chapters | **לא** — אין תוספת; כל ה-CSS הנדרש כבר קיים ב-`w2-05-shop.css`/`ea-atoms.css` |
| `assets/css/w2-05-shop.css`, `assets/css/ea-atoms.css` | עיצוב Wave2 (כבר טעון בפועל בכל 5 העמודים) | **לא** |
| `assets/js/ea-ab-testing.js` | חיווט A/B + GA4 `[data-ea-product-cta]` | **לא** — הסלקטור הוא attribute-based, כבר מכסה את המבנה החדש |
| `mu-plugins/ea-w2-seo-schema.php` | Product/Offer schema | **לא** — כבר תלוי-postmeta בלבד, יתעורר לבד |
| `inc/wave2-w2-05.php` (הפונקציות `ea_w2_05_price`/`ea_w2_05_gi_url`) | מקור אמת יחיד למחיר/GI-URL | **לא** — נקרא, לא מועתק (חוץ מהתיקון הממוקד ב-§2.4) |
| `inc/wave2-stage-b.php` (`ea_wave2_wa_url`) | בניית קישור WhatsApp | **לא** |

### 2.4 תיקון קטן, מוצדק: `inc/wave2-w2-05.php` — הסרת enqueue כפול (חוסם קריטריון קבלה של T3 עצמה)

**הממצא:** `ea_w2_05_assets()` (`inc/wave2-w2-05.php:167-195`) עושה `wp_enqueue_script('ea-ab-testing', .../ea-ab-testing.js, ..., true)` (שורות 186-193), בתנאי `ea_w2_05_is_commerce_view()` — בדיקה מבוססת-סלאג-בלבד, אמת לכל 6 סלאגי W2-05 (5 מוצרים + `shop`) **ללא תלות בתבנית המנצחת בניתוב**.

**בו-זמנית**, `ea_wave2_enqueue_assets()` (`inc/wave2-stage-b.php:80-140`) עושה `wp_enqueue_script('ea-wave2-ab-testing', .../ea-ab-testing.js, ..., true)` (שורה 116) — **אותו קובץ מקור בדיוק**, תחת **handle שונה**. התנאי שלה, `ea_wave2_is_active_view()` (`wave2-stage-b.php:55-75`), בודק `get_query_var('ea_wave2_shell', false)` — וזה **תמיד `true`** לכל 6 סלאגי W2-05, כי `ea_w2_05_is_wave2_page()` עצמו קובע את המשתנה הזה ב-`template_redirect` (`inc/wave2-w2-05.php:94-98`), **ללא תלות ב-Chapters בכלל**.

שני ה-handles השונים לאותו קובץ מקור ⇒ שני תגי `<script>` נפרדים ⇒ ה-IIFE של `ea-ab-testing.js` **רץ פעמיים** בכל טעינת עמוד, על **כל 6** עמודי W2-05 — כולל `/shop`. זה קורה **כבר היום**, בלי קשר ל-T3 (הכפתור הצף `.ea-whatsapp-float[data-ea-ab]`, המרונדר בלי תנאי ב-`wp_footer` עדיפות 15 — `inc/wave2-stage-b.php:373-390` — כבר סופג קליק כפול ב-`whatsapp_cta_click`/`generate_lead` בכל 6 העמודים האלה היום). **T3 יורש את הבאג הזה** לכפתור ה-`data-ea-product-cta` החדש שלו, ומפר את קריטריון הקבלה "קליק אחד = אירוע GA4 אחד" (§5) — לכן התיקון נכלל כאן, לא מוצע כ"נחמד שיהיה".

**התיקון (בטוח: `ea_wave2_enqueue_assets()` כבר מכסה במלואה את אותם 6 עמודים, כולל `/shop`, ללא תלות בשינוי):**

מחיקת שורות 186-193 מ-`inc/wave2-w2-05.php` (התגובה + קריאת ה-`wp_enqueue_script`), משאירים את `}` (שורה 194) ו-`add_action(...)` (שורה 195):

לפני:
```php
	wp_enqueue_style(
		'ea-w2-05-shop',
		$uri . '/assets/css/w2-05-shop.css',
		array( 'ea-eyalamit-services' ),
		$ver
	);
	// Canonical A/B mechanism (eyal_cta_variant). Wires [data-ea-product-cta].
	wp_enqueue_script(
		'ea-ab-testing',
		$uri . '/assets/js/ea-ab-testing.js',
		array(),
		$ver,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_w2_05_assets', 28 );
```
אחרי:
```php
	wp_enqueue_style(
		'ea-w2-05-shop',
		$uri . '/assets/css/w2-05-shop.css',
		array( 'ea-eyalamit-services' ),
		$ver
	);
	// ea-ab-testing.js is NOT enqueued here: ea_wave2_enqueue_assets() (wave2-stage-b.php)
	// already covers every W2-05 slug under handle 'ea-wave2-ab-testing', because
	// ea_w2_05's own template_redirect handler (this file, ea_w2_05_is_wave2_page()) sets
	// ea_wave2_shell=true for the same 6 slugs. A second enqueue here double-fires the
	// script's IIFE (duplicate GA4 events) — fixed as part of WP-CANON-TEMPLATE-UNIFICATION T3.
}
add_action( 'wp_enqueue_scripts', 'ea_w2_05_assets', 28 );
```

`services.css`/`w2-05-shop.css` (השורות מעל) **נשארות** — הן עדיין המקור היחיד ל-`.ea-product-price`/`.ea-cta-pill--whatsapp`/`.ea-cta-ab`.

---

## 3. רצף בנייה — צעד-אחר-צעד לכל 5 העמודים

1. **צור** את `template-parts/chapters/parts/product-cta.php` (תוכן מלא ב-§2.1). פעולה חד-פעמית, משותפת ל-5 העמודים.
2. **תקן** את `inc/wave2-w2-05.php` לפי §2.4 (הסרת ה-enqueue הכפול). פעולה חד-פעמית — בצע **לפני** שלב 4, כדי שבדיקת "אירוע GA4 יחיד" (§5) תעבור מהריצה הראשונה.
3. **קבע** את ערך `alt` הנכון לכל עמוד: פתח כל אחד מ-5 קבצי ה-defaults ובדוק את מצב ה-`alt`/רקע של הסקשן **שלפני** הסקשן האחרון (הפרוזה הסוגרת) — אם הוא `sec--alt` (רקע `--ivory-2`), הסקשן החדש צריך `'alt' => false` (כדי לשמור על אפקט "פסים" מתחלף); אם הוא לבן/ברירת-מחדל, הסקשן החדש צריך `'alt' => true`. (בכל 5 הקבצים היום הסקשן הקודם לסקשן ה-CTA הוא פרוזה סוגרת ללא `'alt'=>true` מפורש = רקע ברירת מחדל ⇒ ברירת המחדל הצפויה לכל 5 העמודים היא `'alt' => true`, אך יש לאמת ויזואלית בכל עמוד בנפרד ולא להניח.)
4. **ערוך** את חמשת קבצי ה-defaults לפי §2.2 — טבלת הערכים המדויקת ניתנה שם לכל עמוד. ניתן לבצע כ-5 עריכות עצמאיות (אין תלות בין הקבצים).
5. **QA לכל עמוד בנפרד** לפי קריטריוני הקבלה ב-§5 — אין לסמן T3 כ-DONE עד ש-5/5 עברו.
6. **QA רגרסיה משותף** (חד-פעמי, לא לכל עמוד): פתח עמוד שמשתמש עדיין ב-`cta.php` הגנרי (למשל `/treatment/`) ווודא שהוא מרונדר ללא שינוי — מוודא ש-§2.3 (cta.php לא נגע) אכן החזיק.
7. **תעד** ב-handoff/WP-tracking את התלות קדימה ל-T6 (ר' §6.4) — לא לבצע עכשיו, רק לוודא שהיא לא הולכת לאיבוד.

---

## 4. גלריה — מה קורה עכשיו מול מה יקרה כשיהיו תמונות אמיתיות

**מה שלא נבנה עכשיו, ולמה בכוונה:** אף סקשן `'part' => 'gallery'` **אינו** מתווסף לאף אחד מ-5 קבצי ה-defaults בשלב הזה. הסיבה אינה טכנית אלא תוכנית: ל-Wave2 עצמו, בגרסת ה-gallery block שלו (`ea_w2_05_render_gallery()`, `inc/wave2-w2-05.php:592-614`), **אין תוכן אמיתי** — הוא מרנדר `$count` (ברירת מחדל 6) ריבועים אפורים ריקים `<span class="ea-gallery-tile ea-gallery-tile--placeholder">` (מוגדר ב-`w2-05-shop.css:242-248`), `aria-hidden="true"` על כל ה-grid. זו בדיוק התופעה שתועדה כ-C-2 ב-LOD300 §1: "placeholder, לא תמונות. אין תוכן גלריה אמיתי לפרוט." **פורטים את הבלוק הזה כמו שהוא ל-Chapters אומר לשכפל 6 ריבועים אפורים ריקים ל-5 עמודים — תוספת קוד שמייצרת אפס ערך למשתמש, בניגוד לרוח T3 (שמטרתה להסיר בדיוק את הפער בין "מה שנראה בנוי" ל"מה שיש בו תוכן אמיתי").** ההחלטה: **לא לשלוח שום גלריה/placeholder בשלב הזה.**

**מה קורה כשאייל מספק תמונות אמיתיות (עתידי, מחוץ לסקופ של T3 הזו):** רכיב הגלריה של Chapters **כבר קיים ומוכן** — `template-parts/chapters/parts/gallery.php` — ומקבל `$args = [chap, title, lead, alt, id, items:[{image, alt, cap}]]`, פותר נתיבי תמונה דרך `ea_chapters_resolve_img()` (תומך גם ב-attachment ID של ACF וגם בנתיב יחסי לתיאטרון). **כשהתמונות יגיעו, הפעולה היחידה הנדרשת היא הוספת סקשן אחד** למערך `sections` בכל אחד מ-5 קבצי ה-defaults, לדוגמה:

```php
array(
    'part' => 'gallery',
    'args' => array(
        'chap'  => "תמונות",
        'title' => "כלים מהסטודיו",
        'items' => array(
            array( 'image' => 'assets/images/chapters/<שם-קובץ-אמיתי-1>.jpg', 'alt' => '<תיאור>', 'cap' => '<כיתוב, אופציונלי>' ),
            array( 'image' => 'assets/images/chapters/<שם-קובץ-אמיתי-2>.jpg', 'alt' => '<תיאור>' ),
            // ... שאר התמונות
        ),
    ),
),
```

**אין צורך בשום קוד PHP/CSS/JS חדש** באותו שלב עתידי — `gallery.php`, `ea_chapters_resolve_img()`, וה-CSS של `.gallery`/`.gfig` כבר קיימים ומשומשים בהצלחה במקומות אחרים בריפו (כולל גלריית ספרים, T1-מוקש עתידית). המיקום המומלץ בזרימת העמוד: מיד אחרי סקשן ה-`split`/`mag` המציג את בית-המלאכה/מבנה המוצר (סקשן 02-03 בכל 5 הקבצים), **לפני** ה-`product-cta` הסוגר — כך שהמחיר/כפתור-הרכישה עדיין הסקשן האחרון בעמוד (המשכיות מבנית עם המצב הנוכחי). זו החלטת-תוכן/מיקום שדורשת את העין של team_00 כשהתמונות בפועל יגיעו — לא נבנה לה מוקאפ כרגע (תואם LOD300: "זו החלטת-תוכן חיצונית, לא נבנה לה מוקאפ").

---

## 5. קריטריוני קבלה — לכל עמוד (בדיק/כן-לא)

הרשימה הבאה **זהה בצורתה** לכל אחד מ-5 העמודים; הערכים המשתנים (`{slug}`) מוצגים כפרמטר. יש להריץ את כל 8 הבדיקות בנפרד על `/didgeridoos/`, `/bags/`, `/stands-storage/`, `/stand-floor/`, `/repair/` (סטייג'ינג — **לא** production, שעדיין מריץ Bridge theme לא-קשור, ר' LOD300 C-1).

1. **רינדור בסיסי:** העמוד עדיין נטען דרך Chapters (`phero__media`/`.sec` נוכחים ב-DOM; שום סמן Wave2-shell כמו `.ea-service-hero`/`.ea-gallery-tile` לא מופיע מתבנית `tpl-shop-item` — הוא עדיין בלתי-נגיש).
2. **מחיר, מצב ריק (המצב היום):** כש-`ea_product_price` postmeta לא מוגדר לעמוד `{slug}` — הטקסט בתוך `.ea-product-price` הוא **בדיוק** `מחיר לפי התאמה`, מילה במילה.
3. **מחיר, מצב מוגדר:** הזנת ערך postmeta (למשל `"450 ₪"`, ידנית דרך פאנל Custom Fields — ר' §6.2) גורמת לטקסט בתוך `.ea-product-price` להשתנות ל-**אותו ערך המדויק**, ללא עיצוב/פרסור נוסף.
4. **CTA, מצב GI ריק (המצב היום לכל 5 המוצרים):** בתוך `[data-ea-product-cta][data-cta-type="contact"]` מופיעים **בדיוק 2** קישורים: (א) `href` שווה בדיוק ל-`/contact?subject=product-{slug}` (ללא target חדש); (ב) `href` שמתחיל ב-`https://wa.me/972524822842?text=` (נפתח בטאב חדש, `target="_blank"`).
5. **CTA, מצב GI מוגדר (עתידי, נבדק ע"י עריכת `ea_w2_05_gi_url_map()` זמנית ב-QA):** ברגע שממלאים ערך לא-ריק ל-`{slug}` במפה — התצוגה עוברת ל-**כפתור יחיד** `[data-cta-type="green_invoice"]`, `href` שווה בדיוק לערך שהוזן, `target="_blank" rel="noopener"`. שני כפתורי ה-contact/WhatsApp **נעלמים**.
6. **מעקב GA4 — אחד, לא שניים:** קליק על כל כפתור בתוך `[data-ea-product-cta]` יורה **בדיוק אירוע `product_cta_click` אחד** (`{product_slug:"{slug}", cta_type:"contact"|"green_invoice"}`) — לא שניים (בודק את תיקון §2.4).
7. **גלריה — היעדרות מכוונת:** 0 (אפס) איברי `.ea-gallery-tile` או `.gfig` בעמוד — אין placeholder, אין שאריות מהבלוק הישן.
8. **Schema — תצפית, לא שינוי:** רק כש-`ea_product_price` = ערך מספרי טהור (למשל `"450"`, לא `"450 ₪"`), ה-JSON-LD ב-`<head>` מכיל צומת `Product`/`offers` תואם; כשהערך הוא `"מחיר לפי התאמה"` או ריק — **אין** מפתח `offers` (מונע Offer מזויף במחיר 0).

**רגרסיה (חד-פעמי, לא per-page):** `/treatment/` (או כל עמוד אחר מתוך 10 המשתמשים ב-`cta.php` הגנרי) ממשיך לרנדר את הסקשן הגנרי שלו ללא שינוי — מוודא ש-§2.3 החזיק.

---

## 6. Edge cases וסיכונים

1. **קישורי GreenInvoice ריקים לכל 5 המוצרים היום — נפילה חינה מאומתת, לא רק מוצהרת.** `ea_w2_05_gi_url_map()` (`inc/wave2-w2-05.php:234-241`) מחזירה `''` לכל חמשת הסלאגים. `product-cta.php` (§2.1) קורא לאותה פונקציה בדיוק (`ea_w2_05_gi_url($slug)`) ומבצע את **אותו ענף if/else** ש-`ea_w2_05_render_cta()` מבצע — `'' !== $gi` ⇒ כפתור GI יחיד; אחרת ⇒ זוג כפתורים contact+WhatsApp. זו לא סימולציה של ההתנהגות — זו **קריאה לאותה פונקציית-מקור**, כך שברגע שממלאים שורה אחת במפה (`inc/wave2-w2-05.php:234-241` — "one-line-per-product edit" כפי שה-docblock הקיים בקובץ כבר מתאר), **כל 5 עמודי Chapters הופכים אוטומטית** לכפתור-רכישה יחיד, בלי לגעת בקוד Chapters כלל. אין נקודת-דריפט בין שתי גרסאות של אותה מפה.

2. **אין ממשק wp-admin ידידותי להזנת `ea_product_price` — מצב קיים מ-Wave2, לא נפתר ע"י T3.** אומת (גריפ מקיף) שאין `add_meta_box`/`register_post_meta`/שדה ACF בשם `ea_product_price` בכל התיאטרון או ב-mu-plugins. הדרך היחידה להזין ערך היא פאנל "Custom Fields" הגולמי של וורדפרס לעמודים (זמין כברירת מחדל ל-post type `page`, אך דורש הפעלה חד-פעמית תחת Preferences → Panels → Additional בעורך הבלוקים, ואז שדה טקסט גולמי בשם `ea_product_price` ללא label ידידותי). **T3 אינה בונה מטא-בוקס נוח יותר** — זהו בדיוק אותו מצב שכבר קיים ב-Wave2 (ה-fallback הריק לכל 5 המוצרים מוכיח שגם שם מעולם לא הוזן ערך אמיתי). אם רוצים ממשק נוח יותר — זו משימה נפרדת קטנה (מטא-בוקס/שדה ACF), לא בסקופ של T3.

3. **באג enqueue כפול, קיים כבר היום, מתוקן כחלק מ-T3 (§2.4) — ולא רק "נחמד שיהיה".** ר' §2.4 לפירוט המלא: `ea-ab-testing.js` נטען פעמיים (handles `ea-ab-testing` + `ea-wave2-ab-testing`, אותו קובץ מקור) בכל 6 עמודי W2-05 היום, בלי קשר ל-T3 — גורם כבר עכשיו לקליק כפול על הכפתור הצף `.ea-whatsapp-float`. אם לא מתוקן **לפני** ש-T3 מוסיפה את `[data-ea-product-cta]` החדש, קריטריון קבלה #6 (§5) נכשל אוטומטית. התיקון (§2.4) בטוח: `ea_wave2_enqueue_assets()` כבר מכסה במלואה את אותם 6 עמודים ללא תלות בשינוי.

4. **תלות-קדימה שחייבת להישמר עבור T6 (מחיקת Wave2) — לא לתקן עכשיו, רק לתעד שלא תלך לאיבוד.** `product-cta.php` קורא ישירות ל-`ea_w2_05_price()`, `ea_w2_05_gi_url()`/`ea_w2_05_gi_url_map()` (שלושתם ב-`inc/wave2-w2-05.php`) ול-`ea_wave2_wa_url()` (ב-`inc/wave2-stage-b.php`). T6 (LOD300 §2, "מחיקת Wave2") מתכננת למחוק את שני הקבצים האלה במלואם. **אם T6 תמחק אותם כלשונם בלי להעביר את שלוש הפונקציות האלה למקום קבוע אחר (למשל קובץ `inc/chapters/chapters-commerce.php` חדש) — כל 5 עמודי המוצר יקרסו ב-`Call to undefined function`.** יש לוודא שמסמך ה-LOD400 של T6 כולל את שלוש הפונקציות האלה ברשימת "מה שורד/עובר דירה" ולא ברשימת "מה נמחק".

5. **סטייה ויזואלית מקובלת, לא סיכון אמיתי:** כפתור WhatsApp ירוק-זית (`--ea-olive:#6E6F4A`) בתוך עמוד עם מבטא טרה-קוטה (`--terra:#B5663D`) — אותו טרייד-אוף בדיוק כבר קיים וחי היום ב-`contact.php`. גוונים כמעט זהים בין `--ea-ink`/`--ink` וגופן זהה (Heebo) בשתי המערכות — נבדק בפועל, לא הונח.

6. **QA ויזואלי אמיתי עדיין נדרש, למרות "אפס CSS חדש".** זו הפעם הראשונה שה-arrangement הספציפי הזה (מחיר ממורכז + זוג כפתורים, בתוך `.sec.center` של Chapters) נרנדר בפועל — `contact.php` הוא תבנית שונה (טופס דו-עמודות + עמודת WhatsApp צדדית, לא מחיר+כפתור ממורכזים). מומלץ screenshot pass אחד לכל 5 העמודים לפני סגירת T3, במיוחד ברוחב מובייל (≤600px, שם `.ea-cta-ab` עובר ל-column לפי `w2-05-shop.css:325-331`).

7. **למה לא להרחיב את `cta.php` הגנרי במקום ליצור קובץ חדש:** `cta.php` משמש **15** עמודים (`about`, `bags`, `didgeridoos`, `galleries`, `kushi-blantis`, `lessons`, `media`, `muzza`, `repair`, `stands-storage`, `stand-floor`, `sound-healing`, `treatment`, `tsva-bekahol`, `vekatavta` — נבדק בגריפ ישיר). כל שינוי בחוזה שלו (למשל הוספת `price`/`ctas[]` array) הוא שינוי בעל רדיוס-נזק של 15 עמודים במקום 5, תמורת אותה תועלת. קובץ ייעודי חדש מבודד את כל הסיכון ל-5 העמודים הרלוונטיים בלבד — הבחירה הבטוחה יותר למשימה שה-LOD300 עצמו מתאר כ"מכנית ברובה... אין כאן החלטה חזותית שדורשת את העין של team_00".

8. **בונוס לא-מתוכנן, לתשומת לב מי שכותב את LOD400 של T4:** ברגע שמחיר מספרי אמיתי יוזן לאחד מ-5 העמודים, צומת `Product`/`Offer` schema.org יופיע אוטומטית (`mu-plugins/ea-w2-seo-schema.php:119-147`, כבר תלוי-postmeta-בלבד, ר' §0) — **בלי שום עבודת schema נוספת נדרשת**. LOD300 T4 מגדיר את הסקופ שלו כ-FAQPage+Book בלבד; אין צורך לשכפל את זה עבור Product — הוא כבר "שילם על עצמו" ברגע ש-T3 חושפת את המחיר לעין.

---

*נכתב ע"י team_100 (LOD400, פירוט T3 בלבד מתוך WP-CANON-TEMPLATE-UNIFICATION) · 2026-07-14 · מבוסס על מחקר קוד ישיר ב-`EyalAmit.co.il-2026`, לא על הנחות. המשך ישיר של §2 T3 ב-`WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md`.*

---

# LOD400 — T3b: התאמת עמודי הספרים (וכתבת / כושי בלאנטיס / צבע בכחול וזרוק לים)

מקורות: LOD300 §2 T3b, §1 C-2/C-5, §7 (נספח ראיות T3b) — `_COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md`. מוקאפ מאושר-חתום: `_COMMUNICATION/team_35/WP-W2-10-E/elevation/mockup/commerce-book-detail.html` (עותק ה-elevation, לא עותק ה-S1 הבסיסי).

## 1. מטרה

לפרוט שלושה פערים מאושרים וחתומים (מחיר-על-גבי-כפתור-הרכישה, זוג כפתורי רכישה מפוצלים מודפס/דיגיטלי עם מעקב GA4, גלריה עם תמונה אמיתית אחת) מגרסת ה-Wave2 של עמוד פרטי-ספר (`ea_w2_05_render_book_detail()`) אל שלושת עמודי הספרים החיים ב-Chapters — תוך הרחבה מינימלית, אחורה-תואמת, של רכיבי Chapters קיימים (`phero.php`, `cta.php`), לא שכפול CSS/HTML של Wave2 ולא בניית רכיב מקבילי חדש.

## 2. קבצים מדויקים ליצירה/שינוי

**אין קובץ PHP חדש.** כל השינויים הם הרחבה של 2 רכיבי Chapters משותפים קיימים + תוספת CSS אחת קטנה + עריכת 3 קבצי ה-defaults. שיקול הדעת המפורט לכך (למה לא רכיב `bookcta.php` נפרד) מובא בתחילת §3.0.

| קובץ | סוג שינוי | תמצית |
|---|---|---|
| `site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/phero.php` | שינוי (1 מקום, שורה 25) | ארג' אופציונלי חדש `cta_slug` → מוסיף `target="_blank" rel="noopener noreferrer" data-ea-book-purchase data-ea-book-slug="…" aria-label="…"` לכפתור ה-CTA היחיד שבכותרת (Hero), **רק כשמועבר** — אפס שינוי לכל שאר קוראי הרכיב באתר |
| `site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/cta.php` | שינוי (שורות 19-21) | ארג'ים אופציונליים חדשים `cta2_label`/`cta2_url` (כפתור שני, לרצועת-CTA מפוצלת) + `cta_slug` (מעקב) — אפס שינוי כשלא מועברים (כל שאר קריאות ה-part באתר, שאינן ספרים, נשארות זהות) |
| `site/wp-content/themes/ea-eyalamit/assets/css/chapters.css` | שינוי (הוספת כלל חדש ליד שורה 510) | כלל CSS חדש `.cta-band__act-group{display:flex;gap:16px;flex-wrap:wrap}` — מופעל רק כש-`cta2_label` קיים; לא נוגע בכלל הקיים `.cta-band__act` |
| `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/vekatavta-defaults.php` | שינוי | מחיר-על-כפתור בהירו, כפתור-CTA-הביניים הופך למפוצל+מעקב, SECTION 05 (שורות 144-153) הופך מ-prose לרכיב `gallery` עם תמונה אמיתית, תיקון קישור-הדפסה ב-SECTION 06, מעקב על ה-CTA הסופי |
| `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/kushi-blantis-defaults.php` | שינוי | מחיר-על-כפתור בהירו + **קישור הדפסה אמיתי במקום Wave2's ebook URL**, תיקון הטקסט-מציין-מקום המילולי "קישור יתווסף בהמשך" ב-SECTION 06 לקישור אמיתי, כפתור-CTA-הביניים הופך למפוצל+מעקב, גלריה **חדשה** (הסקשן לא קיים היום כלל), מעקב על ה-CTA הסופי |
| `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/tsva-bekahol-defaults.php` | שינוי — **חסום חלקית, ר' §4** | מחיר-על-כפתור בהירו (בטוח, לא תלוי ב-URL), כפתור-CTA-הביניים הופך למפוצל+מעקב **עם URL זמני מסומן בבירור**, גלריה **חדשה**, מעקב על ה-CTA הסופי **עם אותו URL זמני**. SECTION 06 (רכישה, שורות 132-141) **נשאר ללא שינוי** — ר' §4 |

קבצי Wave2 (`inc/wave2-w2-05.php`, `inc/wave2-w2-03-content.php`, `inc/wave2-w2-03.php`) הם **קריאה בלבד** במשימה הזו — מקור-אמת להעתקה, לא נוגעים בהם. הם ימחקו במסגרת T6, אחרי שהתלות המתועדת ב-§6 (הערה 2) תיפתר.

### עובדה חשובה שמפשטת את המשימה: אין צורך ב-enqueue חדש ל-JS

`assets/js/ea-book-purchase.js` (מנגנון המעקב GA4 `book_purchase_click`, על בסיס `[data-ea-book-purchase]` + `data-ea-book-slug`) **כבר נטען היום, בפועל, בשלושת עמודי הספרים החיים** — אומת ישירות מול staging (14/7):

```
curl -sk https://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/      → <script id="ea-w2-03-purchase-js" src=".../ea-book-purchase.js?ver=1.5.6">
curl -sk https://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/  → אותו script tag
curl -sk https://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/   → אותו script tag
grep -c "data-ea-book-purchase" בשלושתם → 0 (אפס תגי מעקב בפועל, למרות שהסקריפט טעון)
```

הסיבה: ה-enqueue (`ea_w2_03_purchase_assets()` ב-`inc/wave2-w2-03.php:166-178`, על ה-hook `wp_enqueue_scripts` עדיפות 28) מותנה ב-`ea_w2_03_is_wave2_page()` — פונקציה שבודקת רק **slug + post_parent** של העמוד המבוקש (ילד של עמוד ששמו-סלאג `books`), **לא** באיזה template בסופו של דבר רינדר את הדף. Chapters מנצחת ב-`template_include` (עדיפות 103 מול 100), אבל ה-JS מוזרם בכל זאת כי ה-gate שלו לא תלוי בניצחון הזה. המשמעות המעשית: **אין למשימה הזו שום שלב "enqueue"** — כל מה שצריך הוא להוסיף את שני ה-data-attributes לכפתורים עצמם; ברגע שהם קיימים ב-HTML, המעקב פועל מיידית, ללא שינוי ב-JS או ב-enqueue. (סיכון-גב הנובע מהעובדה הזו — ר' §6 הערה 2.)

## 3. רצף בנייה שלב-אחר-שלב

**סדר מחייב:** §3.0 (שינויי התשתית המשותפת) קודם לכל עבודה על קובץ defaults ספציפי — 3.1/3.2/3.3 מניחים ש-`cta_slug`/`cta2_label`/`cta2_url` כבר קיימים ב-`phero.php`/`cta.php`.

### 3.0 — שינויי תשתית משותפים (unaified לשלושת הספרים)

**למה לא רכיב `bookcta.php` נפרד:** נשקלה האופציה לבנות part חדש ייעודי לכפתור-מפוצל. הוחלט **נגד** — `cta.php` הקיים כבר מספק בדיוק את מעטפת ה-`.cta-band.cta-band--row` (רקע כהה, `--dark-grad`, מוט לוגו) שכבר בשימוש היום גם ב-CTA-הביניים וגם בסגירה של שלושת עמודי הספרים; הרחבה שלו בשני ארגומנטים אופציונליים (`cta2_label`/`cta2_url`) משיגה כפתור-שני מבלי לגעת כלל בהתנהגות הקיימת עבור עשרות הקריאות האחרות שלו באתר (עמוד הבית, method, treatment וכו' — אף אחת מהן לא מעבירה `cta2_label`, ולכן לא רואה שום שינוי). קובץ חדש היה מכפיל קוד (רקע, מוט לוגו, מבנה `wrap`) ללא תועלת.

**3.0.a — `template-parts/chapters/parts/phero.php`, שורות 24-26 (מצב נוכחי):**

```php
<?php if ( ! empty( $a['cta_label'] ) ) : ?>
    <p class="phero__cta"><a class="btn btn--gw" href="<?php echo esc_url( $a['cta_url'] ?? '#' ); ?>"><?php echo esc_html( $a['cta_label'] ); ?></a></p>
<?php endif; ?>
```

**להחליף ב:**

```php
<?php if ( ! empty( $a['cta_label'] ) ) : ?>
    <p class="phero__cta"><a class="btn btn--gw" href="<?php echo esc_url( $a['cta_url'] ?? '#' ); ?>"<?php if ( ! empty( $a['cta_slug'] ) ) : ?> target="_blank" rel="noopener noreferrer" data-ea-book-purchase data-ea-book-slug="<?php echo esc_attr( sanitize_title( $a['cta_slug'] ) ); ?>" aria-label="<?php echo esc_attr( $a['cta_label'] . ' (נפתח בלשונית חדשה)' ); ?>"<?php endif; ?>><?php echo esc_html( $a['cta_label'] ); ?></a></p>
<?php endif; ?>
```

עדכן גם את דוקבלוק הקובץ (שורה 5, `$args:`) להוסיף `cta_slug (optional — marks the CTA as an external, GA4-tracked purchase link: adds target=_blank/rel=noopener + data-ea-book-purchase/data-ea-book-slug + aria-label suffix. Do not pass for internal/same-site links.)`.

**3.0.b — `template-parts/chapters/parts/cta.php`, שורות 19-21 (מצב נוכחי):**

```php
<?php if ( ! empty( $a['cta_label'] ) ) : ?>
    <div class="cta-band__act r r2"><a class="btn btn--terra" href="<?php echo esc_url( $a['cta_url'] ?? '#' ); ?>"><?php echo esc_html( $a['cta_label'] ); ?></a></div>
<?php endif; ?>
```

**להחליף ב:**

```php
<?php if ( ! empty( $a['cta_label'] ) ) : ?>
    <div class="cta-band__act r r2<?php echo ! empty( $a['cta2_label'] ) ? ' cta-band__act-group' : ''; ?>">
        <a class="btn btn--terra"
            href="<?php echo esc_url( $a['cta_url'] ?? '#' ); ?>"
            <?php if ( ! empty( $a['cta_slug'] ) ) : ?>target="_blank" rel="noopener noreferrer" data-ea-book-purchase data-ea-book-slug="<?php echo esc_attr( sanitize_title( $a['cta_slug'] ) ); ?>" aria-label="<?php echo esc_attr( $a['cta_label'] . ' (נפתח בלשונית חדשה)' ); ?>"<?php endif; ?>><?php echo esc_html( $a['cta_label'] ); ?></a>
        <?php if ( ! empty( $a['cta2_label'] ) ) : ?>
            <a class="btn btn--gw"
                href="<?php echo esc_url( $a['cta2_url'] ?? '#' ); ?>"
                <?php if ( ! empty( $a['cta_slug'] ) ) : ?>target="_blank" rel="noopener noreferrer" data-ea-book-purchase data-ea-book-slug="<?php echo esc_attr( sanitize_title( $a['cta_slug'] ) ); ?>" aria-label="<?php echo esc_attr( $a['cta2_label'] . ' (נפתח בלשונית חדשה)' ); ?>"<?php endif; ?>><?php echo esc_html( $a['cta2_label'] ); ?></a>
        <?php endif; ?>
    </div>
<?php endif; ?>
```

עדכן דוקבלוק (שורה 4, `$args:`) להוסיף `cta2_label, cta2_url (optional — renders a second button for a split CTA), cta_slug (optional — see phero.php's identical convention)`.

**3.0.c — `assets/css/chapters.css`, להוסיף ליד שורה 510 (אחרי `.cta-band--row .cta-band__act{flex:0 0 auto}`):**

```css
.cta-band__act-group{display:flex;gap:16px;flex-wrap:wrap;justify-content:flex-end}
```

(`justify-content:flex-end` כי `.cta-band--row` הוא `text-align:right` — RTL; שני הכפתורים ייושרו לימין כמו הכפתור הבודד היום. ב-mobile, `flex-wrap:wrap` נותן להם ליפול זה מתחת לזה — לבדוק ידנית ב-QA, ר' §5.)

**3.0.d — תמונת גלריה משותפת:** הקובץ `assets/images/kushi-02-eyal-italy.jpg` (קיים בפועל בריפו, 50KB) הוא התמונה האמיתית היחידה ש-Wave2's approved render (`ea_w2_05_render_book_detail()` שורה 1049) משתמש בה — ולמעשה **אותה תמונה בדיוק, המשותפת לשלושת הספרים** (לא תמונה ייחודית לכל ספר). זו לא טעות פורטינג — זה בדיוק מה שהגרסה המאושרת עושה. נשתמש באותה תמונה, באותו אופן, בשלושתם. (יש גם קובץ נוסף לא-בשימוש `assets/images/kushi-04-sinai.jpg` [266KB] — לא ידוע אם רלוונטי תמטית לאיזה ספר; זו החלטת תוכן של אייל, לא נבחר כאן. ר' גם C-2 ב-LOD300: אין תמונות אמיתיות נוספות "לפרוט" — צריך חומר חדש מאייל.)

**3.0.e — החלטה מפורשת: מנגנון `faq_idx` (curated-subset) לא משוכפל.** `ea_w2_05_book_map()` (`inc/wave2-w2-05.php` שורות 756/775/795) מגדיר `faq_idx` — תת-קבוצה אצורה של 4 שאלות מתוך מאגר ה-FAQ המלא של כל ספר (למשל וכתבת: אינדקסים `(0,2,5,6)` מתוך 7; כושי בלאנטיס: `(0,1,2,3)` מתוך 6; צבע בכחול: `(0,1,2,4)` מתוך 5) — משמש רק בתוך `ea_w2_05_render_book_detail()` (שורות 1040-1047) כדי לצמצם את ה-FAQ למראה קומפקטי יותר במוקאפ ה-hi-fi. **שלושת קבצי ה-defaults של Chapters כבר מציגים היום את מאגר ה-FAQ המלא** (לא מצומצם) לכל ספר — זה תוכן אמיתי, לא כפילות. LOD300 §2 T3b מונה במפורש 3 פערים בלבד (מחיר-על-כפתור, כפתור-מפוצל+מעקב, גלריה) — **לא** כולל צמצום FAQ. **אל תצמצמו את מערך ה-`faq` בשום אחד משלושת קבצי ה-defaults** — השארתו המלאה היא ההחלטה המפורשת כאן, לא מקרה שנשמט.

**3.0.f — תיקון (ולידציה חוצת-מנוע team_90, 14/7, F90-03): שדות-schema עליונים, נפרדים מה-CTA, בכל אחד מ-3 קבצי ה-defaults.** §2.2/§2.3-3.1/3.2/3.3 למטה מטמיעים מחיר וקישורי-רכישה **בתוך טקסט הכפתורים** (`cta_label`, `cta_url`, `cta2_url`) — זה נכון ומספיק לצורך ה-UI, אבל T4 (schema.org Book) צריך לקרוא אותם ערכים **כשדות נקיים**, לא לפרסר טקסט-כפתור. team_90 מצא ש-T4 היה בנוי על שמות-שדה placeholder שT3b (כפי שנוסח במקור) מעולם לא סיפק בפועל — זה תוקן: **כל אחד מ-3 קבצי ה-defaults מקבל, בנוסף ל-`phero`/`sections` הקיימים, שדות עליונים חדשים** (siblings, לא מקוננים):

```php
// נוסף לראש כל אחד מ-3 קבצי ה-defaults, לפני return array('phero'=>..., 'sections'=>...):
'price'          => 79,      // int, בלי ₪ — אותו מספר שכבר ב-cta_label; ר' §3.1-3.3 לערך המדויק לכל ספר
'buy_print_url'  => 'https://www.mendele.co.il/product/vekatavta/', // זהה ל-cta_url הקיים
'buy_ebook_url'  => 'https://www.mendele.co.il/product/vekatavta/', // זהה ל-cta2_url הקיים
'genre'          => null,    // להעתיק מ-ea_w2_05_book_map()['genre'] (inc/wave2-w2-05.php:737+) בזמן המימוש — לא אומת ערך מדויק במחקר הזה
'meta_year'      => null,    // להעתיק מ-$m['meta'] (שורת "יצא לאור") — כנ"ל
'meta_pages'     => null,    // להעתיק מ-$m['meta'] (שורת "עמודים") — כנ"ל; וכתבת: כבר ידוע 252 (מוזכר ב-SECTION 06 הקיים)
```

השדות האלה **לא** מוצגים ב-UI (לא חלק מ-`sections`) — הם קיימים אך ורק כדי ש-T4 יוכל לקרוא אותם דרך `ea_chapters_field()` בלי לפרסר HTML ובלי תלות ב-`wave2-w2-05.php`. הערכים המדויקים ל-`price`/`buy_print_url`/`buy_ebook_url` לכל ספר ניתנים ב-§3.1/3.2/3.3 למטה (זהים למה שכבר נכתב שם ב-`cta_label`/`cta_url`/`cta2_url`); `genre`/`meta_year`/`meta_pages` מסומנים `null` בכוונה — יש להעתיקם מ-`ea_w2_05_book_map()` (קריאה בלבד, הקובץ עדיין קיים עד T6) בזמן המימוש בפועל, כי לא אומתו ערכיהם המדויקים במחקר ה-LOD400 הזה. `isbn` מושמט לגמרי (לא קיים בשום מקור, ר' T4 §2.3).

---

### 3.1 — וכתבת (vekatavta) — אין חסימה; ה-URL כבר נכון היום

קובץ: `inc/chapters/defaults/vekatavta-defaults.php`. מחיר מאושר: **79 ₪**. `print_url == ebook_url == https://www.mendele.co.il/product/vekatavta/` (שני הפורמטים נמכרים מאותו דף מנדלי — כך בדיוק ב-`ea_w2_05_book_map()`, לא טעות; שני הכפתורים יובילו לאותו יעד, מובחנים רק בטקסט).

1. **הירו (שורות 18-26).** שורה 24: `'cta_label' => 'לרכישת הספר',` → `'cta_label' => 'לרכישת הספר · 79 ₪',` (מפריד `·` = middle dot, כפי שב-Wave2 המאושר, לא מקף). שורה 25 (`cta_url`) — **ללא שינוי**, כבר נכון. הוסף שורה חדשה אחרי 25: `'cta_slug'  => 'vekatavta',`.

2. **CTA-ביניים, SECTION 09 (שורות 106-113).** מצב נוכחי:
   ```php
   array(
       'part' => 'cta',
       'args' => array(
           'title'     => 'אם הגעת עד כאן, כנראה שזה לא סתם.',
           'cta_label' => 'לרכישת הספר',
           'cta_url'   => 'https://www.mendele.co.il/product/vekatavta/',
       ),
   ),
   ```
   להחליף ב:
   ```php
   array(
       'part' => 'cta',
       'args' => array(
           'title'      => 'אם הגעת עד כאן, כנראה שזה לא סתם.',
           'cta_label'  => 'לרכישת הספר המודפס',
           'cta_url'    => 'https://www.mendele.co.il/product/vekatavta/',
           'cta2_label' => 'ספר אלקטרוני',
           'cta2_url'   => 'https://www.mendele.co.il/product/vekatavta/',
           'cta_slug'   => 'vekatavta',
       ),
   ),
   ```

3. **גלריה, SECTION 05 (שורות 144-153).** מצב נוכחי — `'part' => 'prose'` עם משפט כיתוב בלבד, אין תמונות:
   ```php
   array(
       'part' => 'prose',
       'args' => array(
           'chap'   => 'גלריה',
           'title'  => 'גלריה',
           'center' => true,
           'body'   => '<p>גלריית תמונות מתוך הספר, מתוך רגעים מהדרך, ומהמפגש של הסיפורים עם העולם.</p>',
       ),
   ),
   ```
   להחליף ב (`'part' => 'gallery'`, ר' `template-parts/chapters/parts/gallery.php`):
   ```php
   array(
       'part' => 'gallery',
       'args' => array(
           'chap'  => 'גלריה',
           'title' => 'גלריה',
           'lead'  => 'גלריית תמונות מתוך הספר, מתוך רגעים מהדרך, ומהמפגש של הסיפורים עם העולם. תמונות נוספות יתווספו עם קבלת החומרים.',
           'items' => array(
               array( 'image' => 'assets/images/kushi-02-eyal-italy.jpg', 'alt' => 'מהעולם של הספר וכתבת' ),
           ),
       ),
   ),
   ```
   (השורה הראשונה של ה-`lead` היא הכיתוב הקיים, verbatim — לא הומצא טקסט חדש; רק הוצמד לו משפט "תמונות נוספות..." שאול verbatim מ-`ea_w2_03_render_gallery_placeholder()` הקיים ב-`inc/wave2-w2-03.php` שורה 240.)

4. **SECTION 06 — רכישה (שורות 133-142), תיקון עקביות.** מצב נוכחי מפנה עותק מודפס ל-`/contact/` בזמן שה-CTA-ים החדשים מובילים ישירות למנדלי — אי-עקביות מיותרת מרגע שיש URL אמיתי וודאי (ללא חסימה, בניגוד ל-tsva-bekahol). שורת ה-body הנוכחית:
   ```php
   'body'  => '<p>"וכתבת" זמין לרכישה בשתי גרסאות:</p><p>גרסה מודפסת (לפרטים והזמנה - <a class="tlink" href="/contact/">צרו קשר</a>)</p><p>גרסה דיגיטלית: <a class="tlink" href="https://www.mendele.co.il/product/vekatavta/">לרכישת הספר בגרסה דיגיטלית</a></p><p>ספר של 252 עמודים, 46 סיפורים אמיתיים מחייו של אייל עמית.</p>',
   ```
   להחליף ב:
   ```php
   'body'  => '<p>"וכתבת" זמין לרכישה בשתי גרסאות:</p><p>גרסה מודפסת: <a class="tlink" href="https://www.mendele.co.il/product/vekatavta/" target="_blank" rel="noopener noreferrer">לרכישת הספר המודפס</a></p><p>גרסה דיגיטלית: <a class="tlink" href="https://www.mendele.co.il/product/vekatavta/" target="_blank" rel="noopener noreferrer">לרכישת הספר בגרסה דיגיטלית</a></p><p>ספר של 252 עמודים, 46 סיפורים אמיתיים מחייו של אייל עמית.</p>',
   ```
   (זה עובר דרך `wp_kses_post()` ב-`prose.php` — `target`/`rel` על `<a>` מותרים כברירת מחדל ב-`wp_kses_post`; ר' בדיקת-קבלה §5.)

5. **CTA סופי, SECTION 12 (שורות 178-186).** הוסף `'cta_slug' => 'vekatavta',` בתוך ה-`args`. שאר הארגומנטים ללא שינוי.

6. **FAQ (שורות 116-131) — ללא שינוי כלל.** ר' §3.0.e.

7. **שדות-schema עליונים (חדש — §3.0.f, סוגר F90-03).** להוסיף לראש הקובץ, siblings ל-`phero`/`sections`:
   ```php
   'price'         => 79,
   'buy_print_url' => 'https://www.mendele.co.il/product/vekatavta/',
   'buy_ebook_url' => 'https://www.mendele.co.il/product/vekatavta/',
   'genre'         => null, // להעתיק מ-ea_w2_05_book_map()['vekatavta']['genre'] בזמן המימוש
   'meta_year'     => null, // כנ"ל
   'meta_pages'    => 252,  // כבר ידוע — מוזכר ב-SECTION 06 הקיים ("ספר של 252 עמודים")
   ```

---

### 3.2 — כושי בלאנטיס (kushi-blantis) — קישור הדפסה אמיתי כבר קיים, לא "בקרוב"

קובץ: `inc/chapters/defaults/kushi-blantis-defaults.php`. מחיר מאושר: **69 ₪**. `print_url = https://mrng.to/MTUiO3vkIg` (קישור Morning אמיתי, כבר קיים היום ב-`ea_w2_05_book_map()` — **לא בשימוש בשום מקום בקובץ ה-defaults הנוכחי**). `ebook_url = https://www.mendele.co.il/product/kushibelantis/` (כבר נכון בקובץ הקיים).

זה הספר שבו LOD300 מציין במפורש שהגרסה הנוכחית מציגה **טקסט מציין-מקום מילולי** ("קישור יתווסף בהמשך") למרות שקישור פעיל קיים וממתין — הפער הכי "מוכן-לתיקון-מיידי" מבין שלושת הספרים.

1. **הירו (שורות 19-27).** שורה 25: `'cta_label' => 'לרכישת הספר הדיגיטלי',` → `'cta_label' => 'לרכישת הספר · 69 ₪',`. שורה 26: `'cta_url'   => 'https://www.mendele.co.il/product/kushibelantis/',` → `'cta_url'   => 'https://mrng.to/MTUiO3vkIg',` — **שינוי URL אמיתי, לא רק טקסט**: בגרסה המאושרת כפתור ה-Hero תמיד מוביל ל-`print_url` (ר' `inc/wave2-w2-05.php` שורה 1063: `href="<?php echo esc_url( $print_url ); ?>"`, קבוע לכל שלושת הספרים), לא ל-ebook URL כמו שקיים היום. הוסף שורה חדשה: `'cta_slug'  => 'kushi-blantis',`.

2. **SECTION 06 — רכישה (שורות 66-74) — התיקון המרכזי של הספר הזה.** מצב נוכחי:
   ```php
   'body'  => '<p>הספר זמין לרכישה כספר מודפס וכספר דיגיטלי.</p><p>לרכישת הספר המודפס – קישור יתווסף בהמשך<br>לרכישת הספר הדיגיטלי – <a class="tlink" href="https://www.mendele.co.il/product/kushibelantis/">לרכישה דרך מנדלי</a></p>',
   ```
   להחליף ב (מסיר את הטקסט-מציין-מקום, מכניס קישור אמיתי):
   ```php
   'body'  => '<p>הספר זמין לרכישה כספר מודפס וכספר דיגיטלי.</p><p>לרכישת הספר המודפס – <a class="tlink" href="https://mrng.to/MTUiO3vkIg" target="_blank" rel="noopener noreferrer">לרכישה דרך מורנינג</a><br>לרכישת הספר הדיגיטלי – <a class="tlink" href="https://www.mendele.co.il/product/kushibelantis/" target="_blank" rel="noopener noreferrer">לרכישה דרך מנדלי</a></p>',
   ```

3. **CTA-ביניים, SECTION 09 (שורות 106-114).** מצב נוכחי:
   ```php
   array(
       'part' => 'cta',
       'args' => array(
           'title'     => 'רוצה להתחיל לקרוא כבר עכשיו?',
           'cta_label' => 'לרכישת הספר הדיגיטלי',
           'cta_url'   => 'https://www.mendele.co.il/product/kushibelantis/',
       ),
   ),
   ```
   להחליף ב:
   ```php
   array(
       'part' => 'cta',
       'args' => array(
           'title'      => 'רוצה להתחיל לקרוא כבר עכשיו?',
           'cta_label'  => 'לרכישת הספר המודפס',
           'cta_url'    => 'https://mrng.to/MTUiO3vkIg',
           'cta2_label' => 'ספר אלקטרוני',
           'cta2_url'   => 'https://www.mendele.co.il/product/kushibelantis/',
           'cta_slug'   => 'kushi-blantis',
       ),
   ),
   ```

4. **גלריה — סקשן חדש (לא קיים היום כלל).** הכנס מיד **אחרי** השורה 131 (`),` הסוגר את בלוק ה-FAQ) ולפני השורה 133 (הערת `/* SECTION 12 — CTA סופי */`):
   ```php

       /* SECTION 05 — גלריה (new; real image wired per T3b). */
       array(
           'part' => 'gallery',
           'args' => array(
               'chap'  => 'גלריה',
               'title' => 'גלריה',
               'lead'  => 'תמונות מהעולם של הספר. תמונות נוספות יתווספו עם קבלת החומרים.',
               'items' => array(
                   array( 'image' => 'assets/images/kushi-02-eyal-italy.jpg', 'alt' => 'מהעולם של הספר כושי בלאנטיס' ),
               ),
           ),
       ),
   ```

5. **CTA סופי, SECTION 12 (שורות 133-141).** הוסף `'cta_slug' => 'kushi-blantis',` בתוך ה-`args`. שאר הארגומנטים (`cta_url` נשאר `mendele.co.il/product/kushibelantis/` — זה הכפתור היחיד/הכללי בסגירה, לא צריך לשנותו ל-mrng.to; ב-Wave2 המאושר גם כפתור הסגירה מוביל ל-`print_url`, אז לשם דיוק מלא ניתן לשקול גם כאן `mrng.to/MTUiO3vkIg` — **המלצה: כן, יישרו את ה-cta_url של הסגירה ל-`https://mrng.to/MTUiO3vkIg`** לעקביות עם ה-Hero, תואם 1:1 את הגרסה המאושרת).

6. **FAQ (שורות 116-131) — ללא שינוי כלל.** ר' §3.0.e.

7. **שדות-schema עליונים (חדש — §3.0.f, סוגר F90-03).** להוסיף לראש הקובץ:
   ```php
   'price'         => 69,
   'buy_print_url' => 'https://mrng.to/MTUiO3vkIg',
   'buy_ebook_url' => 'https://www.mendele.co.il/product/kushibelantis/',
   'genre'         => null, // להעתיק מ-ea_w2_05_book_map()['kushi-blantis']['genre'] בזמן המימוש
   'meta_year'     => null, // כנ"ל
   'meta_pages'    => null, // כנ"ל
   ```

---

### 3.3 — צבע בכחול וזרוק לים (tsva-bekahol) — ר' §4 לחסימה; שאר העבודה **לא** חסומה

קובץ: `inc/chapters/defaults/tsva-bekahol-defaults.php`. מחיר מאושר: **59 ₪** (בטוח להוסיף — לא תלוי בשאלת ה-URL). **כתובת הרכישה (print_url/ebook_url) חסומה — ר' §4 לפירוט המלא; הצעדים כאן משתמשים ב-URL-הזמני הנוכחי ומסמנים אותו בבירור בקוד עצמו.**

1. **הירו (שורות 19-27).** שורה 25: `'cta_label' => 'לרכישת הספר הדיגיטלי',` → `'cta_label' => 'לרכישת הספר · 59 ₪',` (בטוח, בצע). שורה 26 (`cta_url`) — **השאירו את הערך הקיים `https://www.mendele.co.il/product/tsvabacholvezorekleyam/` ללא שינוי** (זה כבר ה-URL החי היום; לא רגרסיה). הוסף שורה חדשה `'cta_slug'  => 'tsva-bekahol',` **וגם** קומנטר PHP מיד מעל שורת ה-`cta_url`:
   ```php
   // C-5 PENDING — Eyal must confirm the correct Mendele URL before this is
   // considered final. Two candidates exist for the SAME book: this one
   // ('tsvabacholvezorekleyam', currently live) vs Wave2's approved book map
   // ('tzvabekahol', inc/wave2-w2-05.php:753). Do NOT change without his answer.
   // See _COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md §1 C-5.
   'cta_url'   => 'https://www.mendele.co.il/product/tsvabacholvezorekleyam/',
   ```

2. **CTA-ביניים, SECTION 09 (שורות 143-152) — שדרוג מבני מ-prose ל-cta מפוצל.** מצב נוכחי (לא אפילו רצועת CTA אמיתית — טקסט prose עם קישור מוטבע):
   ```php
   array(
       'part' => 'prose',
       'args' => array(
           'chap'   => 'רוצה להתחיל כבר עכשיו?',
           'title'  => 'רוצה להתחיל כבר עכשיו?',
           'center' => true,
           'body'   => "<p><a class=\"tlink\" href=\"https://www.mendele.co.il/product/tsvabacholvezorekleyam/\">לרכישת הספר הדיגיטלי</a></p>",
       ),
   ),
   ```
   להחליף ב:
   ```php
   // C-5 PENDING — both URLs below are the CURRENT LIVE placeholder; see the
   // identical note on the hero cta_url above. Do not resolve unilaterally.
   array(
       'part' => 'cta',
       'args' => array(
           'title'      => 'רוצה להתחיל כבר עכשיו?',
           'cta_label'  => 'לרכישת הספר המודפס',
           'cta_url'    => 'https://www.mendele.co.il/product/tsvabacholvezorekleyam/',
           'cta2_label' => 'ספר אלקטרוני',
           'cta2_url'   => 'https://www.mendele.co.il/product/tsvabacholvezorekleyam/',
           'cta_slug'   => 'tsva-bekahol',
       ),
   ),
   ```

3. **גלריה — סקשן חדש (לא קיים היום כלל; מותר להתקדם, אינו תלוי ב-C-5).** מצא את שורה 130 (הערת `/* SECTION 11 — כתבות מהעיתונות (image gallery omitted — media gap; no caption text) */`) — **החלף את הערת ה-comment הזו** בסקשן ממשי:
   ```php
       /* SECTION 05 — גלריה (new; real image wired per T3b; not blocked by C-5). */
       array(
           'part' => 'gallery',
           'args' => array(
               'chap'  => 'גלריה',
               'title' => 'גלריה',
               'lead'  => 'תמונות מהעולם של הספר. תמונות נוספות יתווספו עם קבלת החומרים.',
               'items' => array(
                   array( 'image' => 'assets/images/kushi-02-eyal-italy.jpg', 'alt' => 'מהעולם של הספר צבע בכחול וזרוק לים' ),
               ),
           ),
       ),
   ```

4. **CTA הסגירה (שורות 166-175) — הרצועה בפועל, בסוף SECTION 12.** הוסף `'cta_slug' => 'tsva-bekahol',` בתוך ה-`args`, והוסף את אותה הערת C-5-PENDING מעל ה-`cta_url` הקיים (שורה 173). ה-body/title הקיימים נשארים.

5. **בלוק ה-prose שלפני (שורות 154-164) — ללא שינוי.** יש כאן טקסט-סגירה כפול (prose ואז cta-band) שלא קיים באותה צורה בשני הספרים האחרים — זו לא טעות, רק מבנה שונה במעט; לא לגעת, לא לאחד עם הבלוק שאחריו.

6. **SECTION 06 — רכישה (שורות 132-141) — נשאר ללא שום שינוי.** בניגוד לוכתבת (שם התיקון בטוח כי ה-URL כבר ודאי) ולכושי בלאנטיס (שם היה טקסט-מציין-מקום ברור לתיקון), כאן ה-body הנוכחי מפנה עותק מודפס ל-`https://www.eyalamit.co.il/contact` — וזו בדיוק מסגרת ה-fallback שאין לגעת בה כל עוד לא ידוע איזה משני מועמדי ה-URL נכון. **אל תחליפו את קישור ה-`/contact` הזה בקישור מנדלי ישיר** — זה בדיוק הניחוש האסור. השאירו את הסקשן הזה בדיוק כפי שהוא; יתעדכן (אם בכלל) רק אחרי שC-5 ייפתר, ר' §4.

7. **FAQ (שורות 99-128) — ללא שינוי כלל.** ר' §3.0.e.

8. **שדות-schema עליונים (חדש — §3.0.f, סוגר F90-03). כפוף לאותה חסימת C-5 כמו קישורי הרכישה בעמוד הזה — לא לפתור כאן בנפרד.**
   ```php
   // C-5 PENDING — אותה הערה כמו על cta_url למעלה. אל תפתרו כאן בנפרד.
   'price'         => 59,
   'buy_print_url' => 'https://www.mendele.co.il/product/tsvabacholvezorekleyam/',
   'buy_ebook_url' => 'https://www.mendele.co.il/product/tsvabacholvezorekleyam/',
   'genre'         => null, // להעתיק מ-ea_w2_05_book_map()['tsva-bekahol']['genre'] בזמן המימוש
   'meta_year'     => null, // כנ"ל
   'meta_pages'    => null, // כנ"ל
   ```

## 4. חסימה חיצונית מפורשת — כתובת הרכישה של "צבע בכחול וזרוק לים" (C-5)

**זו עובדה שצריך לברר מול אייל, לא שאלת עיצוב, ולא משהו ש-LOD400 הזה פותר בעצמו.**

קיימות שתי כתובות מנדלי **שונות בפועל** עבור אותו ספר, אצל אותו ספק (Mendele), משתי מקורות-אמת סותרים בקוד:

| מקור | קובץ | ערך |
|---|---|---|
| מפת המוצרים המאושרת של Wave2 (`ea_w2_05_book_map()`) | `inc/wave2-w2-05.php` שורות 752-756 | `https://www.mendele.co.il/product/**tzvabekahol**/` (גם `print` וגם `ebook`) |
| תוכן המקור הגולמי + Chapters החי היום | `inc/wave2-w2-03-content.php` שורה 205 + `inc/chapters/defaults/tsva-bekahol-defaults.php` (הירו שורה 26, ושאר המקומות) | `https://www.mendele.co.il/product/**tsvabacholvezorekleyam**/` |

אומת ישירות מול ה-URL החי ב-staging (14/7): `curl -sk https://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/ | grep mendele.co.il/product` מחזיר **רק** `tsvabacholvezorekleyam` — כלומר, ל-Chapters היום יש רק תשובה אחת בפועל, אבל אין דרך לדעת אם היא ה-*נכונה*, או שמא Wave2's ebook/print map (`tzvabekahol`) הוא הגרסה המדויקת יותר (למשל כי היא נכתבה מאוחר יותר, בזמן ה-elevation ל-hi-fi, כשמישהו כבר ישב מול ה-asset manifest האמיתי של אייל).

**המשמעות המחייבת ל-LOD400 (חוזר גם ב-§3.3):**
1. **אל תנחשו איזה מהשניים נכון.** אל תבחרו אחד "כי הוא כבר חי" ואל תבחרו אחד "כי הוא במקור המאושר יותר" — שניהם מקורות-אמת לגיטימיים בקוד, וזו בדיוק ההגדרה של קונפליקט שדורש תשובה חיצונית, לא הכרעה הנדסית.
2. **החסימה מוגבלת לערך ה-URL בלבד, לא לכל בניית העמוד.** שאר שלוש הפעולות של T3b (מחיר-על-כפתור, מבנה כפתור מפוצל + מעקב GA4, גלריה) **ממשיכות ומתבצעות במלואן** על tsva-bekahol באותו מחזור עבודה כמו שני הספרים האחרים — פשוט תוך שימוש ב-URL הנוכחי-החי (`tsvabacholvezorekleyam`) כערך זמני, מסומן bright-line בקוד (הערות `C-5 PENDING` בשלוש נקודות: הירו, CTA-ביניים, CTA-סגירה — ר' §3.3 סעיפים 1/2/4).
3. **מה קורה אחרי שאייל עונה:** אם התשובה מאשרת את ה-URL הנוכחי (`tsvabacholvezorekleyam`) — אין צורך בשום שינוי קוד, רק להסיר את שלוש הערות ה-`C-5 PENDING`. אם התשובה מצביעה על `tzvabekahol` — יש להחליף את הערך בשלוש הנקודות (חיפוש-והחלפה מכני, שורה אחת כל פעם) ולהריץ מחדש את בדיקות-הקבלה של §5 (במיוחד: לחיצה על שלושת הכפתורים, אימות שה-URL היעד תואם למה שנקבע). **אין תלות בשום קובץ אחר** — זה שינוי מבודד לשלושה literal strings בקובץ אחד.
4. **מי עונה:** אייל (או מי שמנהל את חשבון המנדלי) — לא team_00, לא team_100, לא team_110. זו עובדה חיצונית לפרויקט, לא החלטת מוצר/עיצוב.

## 5. קריטריוני קבלה (Acceptance Criteria) לפי ספר

בדיקה בדפדפן אמיתי מול staging (`https://eyalamit-co-il-2026.s887.upress.link/...`), לא רק `curl` — לפי משמעת ה-QA של הפרויקט (`_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs`), כי חלק מהקריטריונים כאן (עטיפת-שורה של שני כפתורים ב-mobile) הם עניין של box-model רינדור, לא HTML גולמי.

**משותף לשלושת הספרים:**
- [ ] כפתור ה-Hero מציג `לרכישת הספר · {מחיר} ₪` (79 / 69 / 59 בהתאמה), נפתח בלשונית חדשה, ולחיצה עליו יוצרת אירוע `book_purchase_click` עם `book_slug` נכון ב-`window.dataLayer` (או קריאת `gtag`, לפי הזמין) — נבדק דרך קונסולת הדפדפן.
- [ ] סקשן ה-CTA-ביניים מציג **שני** כפתורים ("לרכישת הספר המודפס" / "ספר אלקטרוני"), שניהם נפתחים בלשונית חדשה, שניהם יורים `book_purchase_click` עם אותו `book_slug`.
- [ ] ב-viewport מובייל (375px) שני הכפתורים בסקשן הביניים נשברים לשתי שורות בצורה נקייה (לא נחתכים, לא גולשים אופקית) — `.cta-band__act-group{flex-wrap:wrap}`.
- [ ] כפתור ה-CTA הסופי (סגירת העמוד) יורה `book_purchase_click` עם `book_slug` נכון.
- [ ] סקשן "גלריה" מוצג עם תמונה אמיתית אחת נראית (לא ריבוע אפור), עם alt-text תקין; לבדוק חזותית שהרקע (`sec--alt`) לא מתנגש עם הסקשן השכן (אם מתנגש — הסר `'alt' => false` בארגומנטים כתיקון קוסמטי קל).
- [ ] מאגר ה-FAQ המלא (לא מצומצם) עדיין מוצג במלואו — מספר הפריטים זהה למספר שהיה לפני העריכה.
- [ ] תיבת "קטע מתוך הספר" (`<details class="prose-acc">`) **נשארת סגורה כברירת מחדל** בטעינת העמוד — ר' §6 הערה 1 לנימוק.
- [ ] `view-source` על העמוד: הקישורים ב-SECTION 06 (רכישה) נושאים בפועל `target="_blank" rel="noopener noreferrer"` (אימות ש-`wp_kses_post()` לא סינן את התכונות).
- [ ] אין שגיאת PHP/JS בקונסולה; ה-body class `ea-wave2-shell` עדיין קיים (מעיד שה-JS מוסיף שהוא עדיין מוזרם כראוי — ר' §6 הערה 2).

**וכתבת (vekatavta) בלבד:**
- [ ] שני כפתורי ה-CTA-ביניים מובילים שניהם ל-`mendele.co.il/product/vekatavta/` (יעד זהה בכוונה).
- [ ] SECTION 06: "גרסה מודפסת" מוביל כעת ישירות למנדלי (לא ל-`/contact/`).

**כושי בלאנטיס (kushi-blantis) בלבד:**
- [ ] כפתור ה-Hero וכפתור "לרכישת הספר המודפס" בסקשן הביניים מובילים שניהם ל-`https://mrng.to/MTUiO3vkIg` (לא עוד למנדלי).
- [ ] SECTION 06: הטקסט "קישור יתווסף בהמשך" **נעלם לחלוטין** מהעמוד — הוחלף בקישור אמיתי.
- [ ] כפתור "ספר אלקטרוני" ממשיך להוביל ל-`mendele.co.il/product/kushibelantis/` (ללא שינוי).

**צבע בכחול וזרוק לים (tsva-bekahol) בלבד:**
- [ ] כל כפתורי הרכישה (הירו, שני כפתורי-הביניים, כפתור-הסגירה) מובילים כולם לאותה כתובת: `mendele.co.il/product/tsvabacholvezorekleyam/` (ה-URL-הזמני, זהה למה שחי היום — **אין רגרסיה**, רק תוספת מחיר+מעקב+מבנה-כפתור-כפול סביב אותו יעד).
- [ ] שלוש הערות `C-5 PENDING` קיימות בקוד (הירו / CTA-ביניים / CTA-סגירה) — ניתנות לאיתור מיידי בחיפוש `grep -n "C-5 PENDING"`.
- [ ] SECTION 06 (רכישה) **לא השתנה כלל** לעומת מצב לפני העריכה — עדיין מפנה עותק מודפס ל-`/contact`.
- [ ] גלריה מוצגת (לא תלויה בפתרון C-5).

## 6. Edge cases / סיכונים

**1. ברירת המחדל הסגורה של תיבת "קטע מתוך הספר" — נשארת כפי שהיא, זו לא תקלה.**
LOD300 §2 T3b מזהה את ההבדל הזה במפורש ("בגרסה המאושרת פתוחה כברירת מחדל; ב-Chapters סגורה כברירת מחדל [בחירת עיצוב מכוונת בקוד Chapters, לא תקלה]") אבל **לא** מונה אותו כאחד משלושת הפערים לתיקון. שלושת קבצי ה-defaults מיישמים כבר היום `'collapsible' => true` בלי `open` (ב-`prose.php` שורות 31-35, ה-`<details>` לא מקבל תכונת `open` בכלל בענף ה-collapsible) — התנהגות אחידה, מכוונת, קיימת בשלושת הספרים. **הספסיפיקציה הזו לא נוגעת בהתנהגות הזו.** אל תוסיפו `open` כדי "להתאים" למוקאפ ה-hi-fi (ששם התיבה פתוחה) — זה בדיוק הפרט שה-LOD300 קבע שהוא כוונה, לא חוב.

**2. תלות חבויה חוצת-משימות: מחיקת `inc/wave2-w2-03.php` ב-T6 תשבור את המעקב שנבנה כאן, אם לא תטופל שם.**
כפי שתועד ב-§2, ה-JS שמניע את המעקב כולו מוזרם על ידי קובץ Wave2 (`inc/wave2-w2-03.php`), לא על ידי שום קובץ Chapters. אם T6 ("מחיקת Wave2") ימחק את הקובץ הזה כחלק מ"ניקוי כל קבצי `wave2-w2-0X`" בלי להעביר (re-home) את `ea_w2_03_purchase_assets()` ואת ה-gate שלה (`ea_w2_03_is_wave2_page()` / `ea_w2_03_book_slugs()` / `ea_w2_03_current_view()`) למקום שנשלט על ידי Chapters — כל המעקב שנבנה במשימה הזו יפסיק לפעול בשקט (ה-data-attributes עדיין יהיו ב-HTML, אבל הסקריפט שמאזין להם לא יטען). **יש לוודא שמפרט ה-LOD400 של T6 מטפל בקובץ הזה במפורש כ"עדיין-חי" (לא מועמד מחיקה גורף), או שהוא מעביר את ה-enqueue + פונקציית ה-gate ל-`inc/chapters/` לפני שהקובץ נמחק.** זו לא בעיה להיום — זו נקודת-בדיקה שחובה לכלול ב-checklist של T6.

**3. קישור ה-Morning של כושי בלאנטיס (`mrng.to/MTUiO3vkIg`) זהה לקישור חבילת-3-הספרים.**
`ea_w2_05_book_map()['kushi-blantis']['buy']['print']` ו-`ea_w2_05_book_bundle()['url']` (`inc/wave2-w2-05.php` שורות 772 ו-810) הם **אותו URL, מילה במילה**. ייתכן שזה תקין (מנדלי/Morning weiterleiten לדף כללי, או שהקישור מכוון ל"החנות" ולא למוצר ספציפי), וייתכן שזה copy-paste ישן שלא תוקן. **זה חלק מהנתונים שכבר אושרו וחתומים (2/6) — לא C-5 שני** (אין כאן שני מקורות-אמת סותרים, רק חשד לכפילות מקרית בתוך מקור-אמת אחד) — ולכן **לא** נחסם כאן. מומלץ ש-team_100/אייל יאמתו את זה בנפרד, מתישהו, לא כחלק מ-T3b.

**4. סקשן 06 (רכישה) הישן נשאר קיים, ומעתה יושב ליד כפתורים אמיתיים חדשים — פוטנציאל לבלבול חזותי, במיוחד ב-tsva-bekahol.**
בשלושת הספרים יש עכשיו **שני מקומות שונים** שמדברים על "איך קונים": הכפתורים החדשים (הירו + ביניים + סגירה, תמיד מובילים ל-URL אמיתי/מעודכן) וסקשן ה-prose הישן "רכישת הספר" (SECTION 06, טקסט חופשי עם קישורי `tlink` פשוטים בתוך הפסקה). ל-וכתבת ו-כושי בלאנטיס תוקן הפער הזה כחלק מה-build (ר' §3.1.4, §3.2.2) — אבל ב-**tsva-bekahol זה נשאר במפורש לא-מתוקן** (ר' §3.3.6), כלומר לצופה בעמוד תהיה, זמנית, פסקת prose שמפנה רכישה מודפסת ל-`/contact` **ממש ליד** כפתורי CTA חדשים שמפנים ישירות למנדלי. זו לא סתירה טכנית (שני נתיבי רכישה תקפים יכולים להתקיים זה לצד זה), אבל היא בלבול-מוצר קטן שכדאי ש-Eyal/team_100 יהיו מודעים אליו כתופעת-לוואי זמנית של חסימת C-5 — ייעלם ברגע שה-URL ייפתר ו-SECTION 06 יתעדכן בעקבותיו (לא כלול כאן, ר' §4 סעיף 3).

**5. `gallery.php` לא תומך ב"ריבועים אפורים עם טקסט placeholder" — הוחלט במודע לא לשחזר את זה.**
הגרסה המאושרת של Wave2 מציגה גלריה של 4 משבצות: תמונה אמיתית אחת + 3 משבצות אפורות עם הטקסט "[תמונה — נדרש מאייל]". רכיב ה-`gallery.php` הקיים ב-Chapters (`items[{image,alt,cap}]`) פשוט **מדלג** (`continue`) על כל item בלי `image` תקין — אין לו יכולת רינדור-placeholder מובנית. הוחלט (ר' §3.0.d) שלא להרחיב את `gallery.php` בשביל זה, ולהציג במקום זאת גלריה כנה של תמונה אחת אמיתית + משפט "תמונות נוספות יתווספו". זו סטייה מודעת מהפרזנטציה המדויקת של המוקאפ (התוכן/יכולת זהים; העיצוב המדויק של "משבצות ריקות מסומנות" לא). אם בעתיד team_00 יחליט שהוא כן רוצה את אפקט ה-4-משבצות המדויק — זו הרחבה נפרדת ומכוונת ל-`gallery.php` (ארגומנט חדש כמו `placeholder_count`), לא חלק מ-T3b.

**6. לא נבדק כאן: התנגשות alt-background חזותית בין הגלריה החדשה לסקשנים שכנים.**
מיקום ההכנסה שנבחר לגלריה החדשה (מיד אחרי ה-FAQ) זהה בשלושת הספרים לצורך עקביות, אבל לא אומת חזותית מול הרקע (`sec`/`sec--alt`) של הסקשנים הממש-שכנים בכל ספר בנפרד (הם שונים מעט מספר לספר, כי לכל ספר יש מבנה-סקשנים שונה במקצת). ר' checkbox ייעודי ב-§5 לתיקון קוסמטי חד-שורתי (`alt` boolean) אם נדרש.

---

# WP-CANON — LOD400: T4 (schema.org) + T5 (/shop, /qr)

**הערת scope:** מסמך זה הוא פריטת LOD400 ל-T4 ו-T5 **בלבד**, כפי שהוגדרו ב-LOD300 (`WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md` §2). T1/T2/T3/T3b/T6/T7 נפרטים במסמכים מקבילים נפרדים. T4 תלוי במפורש בתוצרי LOD400 של T2 ו-T3b (ר' §2.0 למטה) — לא מכריע מחדש את ההחלטות שלהם, רק צורך את הצורה הסופית שלהם. T5 (גם /shop וגם /qr) **אינו** תלוי ב-T2/T3/T3b ויכול להתחיל מיידית, במקביל.

כל נתיב קובץ הוא יחסי ל-`site/wp-content/themes/ea-eyalamit/` אלא אם צוין אחרת (למשל `mu-plugins/...` הוא יחסי ל-`site/wp-content/`).

---

## 1. מטרות

**T4 — schema.org חדש (FAQPage, Book):** להוסיף למנוע ה-schema היחיד של האתר (`mu-plugins/ea-w2-seo-schema.php`, שמתלכד לתוך ה-`@graph` של Yoast דרך `wpseo_schema_graph`) שני צמתי `@type` חדשים — `FAQPage` על גבי מבנה ה-FAQ המאוחד שT2 בונה, ו-`Book` על שלושת עמודי הספרים — כדי שהתוכן שכבר קיים בעמודים האלה יהיה קריא-מכונה למנועי חיפוש ו-AI, בלי לשכפל תוכן ובלי ליצור מקור-אמת שני.

**T5 — איחוד /shop ו-/qr:** להעביר את שני הנתיבים האחרונים שעדיין מוצגים ע"י Wave2 (`/shop` ו-`/qr` על 48 עמודי-הבת שלו) לרינדור דרך Chapters, כשעבור `/qr` האילוץ המכריע (team_00, 14/7) הוא ש**כל כתובת `/qr/qrN/` הקיימת ממשיכה להסתיים ב-200 בדיוק כפי שהיא** — כי היא מודפסת פיזית כקוד QR בתוך ספרים שכבר יצאו לאור ולא ניתן להנפיק להם קודים חדשים. **דיוק לשוני (תוקן לפי ולידציה חוצת-מנוע, F90-05):** "מובטח מבנית" כאן פירושו מובטח **כל עוד שורות-העמוד ב-DB (`post_name`/`post_parent`) ומבנה ה-permalinks של האתר לא משתנים** — לא הבטחה מוחלטת בלתי-תלויה-בכלום. ר' §4.3 להלן לפירוט המלא.

---

## 2. T4 — schema.org: FAQPage + Book

### 2.0 תלות: מה T4 *לא* מכריע

T4 **אינו** קובע:
- את שם/מבנה השדה שT2 בוחר עבור הקטגוריה המרובה (many-to-many) של כל שאלה — LOD300 §4 Q1 קבע "אופציה ב׳", והמוקאפ שהוצג ל-team_00 (`t2-faq-category-model_mockup.html`) הראה קונקרטית `category: ["treatment", "method"]` (מפתח קיים, ערכו הופך למערך) — אך זו עדיין הצעה במוקאפ, לא נעילה. הבנייה בפועל של T4 **חייבת** להתאים את שמות השדות למה ש-T2 בפועל בונה ב-LOD400 שלו.
- את שמות השדות שT3b בוחר לנתוני הספר (מחיר, קישורי רכישה, מספר עמודים וכו') בגרסת ה-Chapters.

מה שכן נקבע כאן, וזה מספיק כדי לבנות עליו בלי לחכות ל-100% מהפרטים של T2/T3b: **צורת ה-JSON-LD המדויקת** (זו לא החלטה פנים-פרויקטלית — זו הספסיפיקציה של schema.org/Google עצמם), **נקודת ההרחבה המדויקת בקוד**, וה**חוזה** (contract) שT4 צריך שT2/T3b יחשפו כדי להתחבר אליו בלי שכפול-נתונים.

### 2.1 מנגנון הבסיס הקיים (אומת בקוד)

קובץ יחיד: `mu-plugins/ea-w2-seo-schema.php`. mu-plugin, רץ בכל בקשה, לא תלוי ב-Wave2/Chapters. פונקציה יחידה — `ea_w2_seo_schema_graph( $graph, $context )` — מחוברת ל-`add_filter( 'wpseo_schema_graph', 'ea_w2_seo_schema_graph', 20, 2 )` (שורה 151). זהו hook של Yoast SEO (השם `wpseo_schema_graph` הוא Yoast, לא קוד מקומי) — "מנוע schema יחיד" כפי שכתוב במפורש בדוקבלוק של הקובץ (שורה 7-8: "so there is ONE schema engine, no hand-rolled second @graph").

דפוס הקוד הקיים (חוזר על עצמו עבור Person / ProfessionalService / Service / Product):
- כל צומת הוא `array` עם `@type` + `@id` (מזהה קנוני בתבנית `home_url('/') . '#/schema/{type}/{slug-or-id}'`, למשל `$person_id = $site . '#/schema/person/eyal-amit'`, שורה 29).
- זיהוי "האם אנחנו בעמוד הרלוונטי" נעשה בשתי דרכים קיימות, שתיהן שימושיות ל-T4:
  1. **רשימת סלאגים קשיחה** (בשימוש עבור Service, שורות 99-103: `$services = array('treatment'=>..., 'sound-healing'=>..., 'lessons'=>...)`, נבדק מול `get_queried_object()->post_name`).
  2. **קיום postmeta** (בשימוש עבור Product, שורה 122: `metadata_exists('post', $pid, 'ea_product_price')`).
- צמתים מפנים אחד לשני דרך `@id` בלבד (למשל Product's `brand` → `array('@id' => $biz_id)`) — לא משכפלים שדות.
- `$graph[] = array(...)` מוסיף; הפונקציה תמיד `return $graph;` בסוף (שורה 149).

**נקודת ההרחבה ל-T4:** בתוך `ea_w2_seo_schema_graph()`, אחרי הבלוק הקיים של Product (אחרי שורה 147, לפני `return $graph;` בשורה 149) — להוסיף שני בלוקים חדשים, FAQPage ו-Book, באותו סגנון קוד בדיוק (אותה קונבנציית `@id`, אותו דפוס `is_page()` + `get_queried_object()`).

### 2.2 FAQPage — מבנה מדויק

**מבנה JSON-LD (schema.org, קבוע):**
```json
{
  "@type": "FAQPage",
  "@id": "https://eyalamit.co.il/#/schema/faqpage/{slug}",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "טקסט השאלה — חייב להיות זהה לטקסט הגלוי בעמוד",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "טקסט התשובה — HTML מוגבל מותר (p/a/ul/li/strong/b/em/i/br), תואם למדיניות גוגל"
      }
    }
  ]
}
```
כללים מחייבים של schema.org/Google שחייבים להישמר (לא ניתנים למשא-ומתן פנים-פרויקטלי, אלה כללי הפורמט עצמו):
1. `mainEntity` הוא **מערך שטוח** של `Question` — גם אם התצוגה החזותית מקבצת שאלות תחת כותרות-קטגוריה (כמו ה-TOC הקיים ב-`block-faq-list.php`), ה-JSON-LD לא מקנן לפי קטגוריה.
2. `Question.name` חייב להיות **הטקסט הגלוי בפועל** בעמוד (לא ניסוח שונה/מקוצר) — זו דרישת "schema תואם תוכן גלוי" של גוגל.
3. `acceptedAnswer` — **תשובה אחת בלבד** לכל שאלה (לא `suggestedAnswer`, לא נדרש כאן).
4. **אסור** לכלול ב-`mainEntity` שאלה שלא מוצגת בפועל בעמוד הזה — כולל שלא להזרים את כל 79 השאלות של הבנק המרכזי לתוך עמוד mini-FAQ מסונן. זו לא רק "practice טוב" — Google מטפל בפער בין schema לתוכן גלוי כהפרת מדיניות spam (structured-data policy), עם סיכון אמיתי להסרת ה-rich result כליל מהאתר. **לכן: ה-FAQPage node של כל עמוד חייב לקרוא בדיוק את אותה תת-קבוצה מסוננת שהעמוד בפועל מרנדר — לא שאילתה נפרדת.**
5. באותה שאלה **מותר** להופיע ב-`mainEntity` של יותר מעמוד אחד (זה בדיוק המשמעות התפעולית של ה-many-to-many שT2 בונה — שאלה שמתויגת גם `treatment` וגם `method` תופיע, כדין, גם ב-FAQPage של `/treatment/` וגם ב-FAQPage של `/method/`). זה לא תוכן כפול בעיני גוגל — זה per-page markup תואם-תוכן, בכל עמוד בנפרד.

**אילו עמודים מקבלים FAQPage (מיפוי סלאג → אילו קטגוריות מוצגות בו):**

| סלאג עמוד | קטגוריה/ות שT2 מציג בו (היום) | סטטוס למיפוי |
|---|---|---|
| `faq` | הכול (ללא סינון — כל 79 השאלות) | ודאי — הקטלוג המלא |
| `treatment` | `treatment` | ודאי — שם הקטגוריה כבר קיים בבנק המרכזי |
| `sound-healing` | `sound-healing` | ודאי |
| `didgeridoos` | `didgeridoos` | ודאי |
| `bags` | `bags` | ודאי |
| `stands-storage` | `stands-storage` | ודאי |
| `stand-floor` | `stand-floor` | ודאי |
| `repair` | `repair` | ודאי |
| `lessons` | `lessons` (כבר קיימת בבנק המרכזי) | **ודאי** — מצטרף לפורט הרגיל (ר' תיקון T2 §0 תיקון 2: ל-`lessons` יש section FAQ כבר היום, כפרוזה, לא "אין FAQ כלל" כפי שLOD300 C-4 טעה לקבוע) |
| `method` | `method` | **ודאי, אחרי שT2 §4.2 הופך אותו לאקורדיון מובנה** (מקרה-קצה ארכיטקטוני אמיתי, ר' שם — לא "מותנה", פשוט תלוי-סדר) |
| `vekatavta` / `kushi-blantis` / `tsva-bekahol` | **לא ידוע** | **ממצא חדש מ-authoring הזה (ר' למטה) — T2 צריך להכריע** |

**ממצא חדש שהתגלה תוך כדי כתיבת המסמך הזה, לתשומת לב T2:** שלושת עמודי הספרים (`vekatavta`, `kushi-blantis`, `tsva-bekahol`) נמצאים ברשימת עמודי mini-FAQ ש-T2 מפרט (§4.1 שם) — אבל הבנק המרכזי (`block-faq-list.php`) מגדיר רק 10 קטגוריות קיימות (`treatment`, `lessons`, `sound-healing`, `method`, `didgeridoos`, `bags`, `stands-storage`, `stand-floor`, `repair`, `general`) — **ואף אחת מהן לא נקראת `vekatavta`/`kushi-blantis`/`tsva-bekahol`**. כלומר: ה-FAQ המקומי-כרגע של שלושת עמודי הספר לא ימופה אוטומטית לקטגוריה קיימת בבנק המרכזי — T2 צריך להכריע אם השאלות שלהם עוברות לקטגוריית `general`, אם נפתחות 3 קטגוריות ספר-ייעודיות חדשות, או אחר. **T4 לא מכריע כאן — רק מדגיש שזו החלטה נוספת שT2 צריך, מעבר להחלטת ה-many-to-many עצמה.**

**קוד המחשה (לא patch מילולי — ממחיש את הצורה שT4 צריך מ-T2):**
```php
// בתוך ea_w2_seo_schema_graph(), אחרי בלוק ה-Product הקיים:
$ea_faq_pages = (array) apply_filters( 'ea_seo_faq_page_categories', array(
    'faq'            => array(),                 // ריק = ללא סינון, כל השאלות
    'treatment'      => array( 'treatment' ),
    'sound-healing'  => array( 'sound-healing' ),
    'didgeridoos'    => array( 'didgeridoos' ),
    'bags'           => array( 'bags' ),
    'stands-storage' => array( 'stands-storage' ),
    'stand-floor'    => array( 'stand-floor' ),
    'repair'         => array( 'repair' ),
    // vekatavta/kushi-blantis/tsva-bekahol/lessons/method — T2 להשלים לפי ההכרעות שלו.
) );
if ( is_page() ) {
    $ea_slug = (string) get_queried_object()->post_name;
    if ( isset( $ea_faq_pages[ $ea_slug ] ) && function_exists( 'ea_faq_query_items' ) ) {
        $ea_items = ea_faq_query_items( $ea_faq_pages[ $ea_slug ] ); // שם סופי, ננעל עם T2 — ר' חוזה למטה
        if ( ! empty( $ea_items ) ) {
            $graph[] = ea_w2_seo_schema_faqpage_node( $ea_items, $ea_slug );
        }
    }
}
```

**החוזה עם T2 — נעול (תיקון F90-04, ולידציה חוצת-מנוע 14/7):** T2 §3.2 בונה בדיוק את הפונקציה הזו — `ea_faq_query_items( array $cat_slugs = array() ): array<{id,q,a,categories}>` (`functions.php`, ליד `ea_eyalamit_render_instance_catalog()`) — **זה השם הסופי בפועל, לא placeholder.** גרסה קודמת של הסעיף הזה קראה לו `ea_chapters_faq_items()` (שם-placeholder שלא הצטלב עם T2 בפועל) — תוקן כאן לשם הנכון. T4 קורא לו ישירות, `array_map`-ל-`{name,text}` בתוך `ea_w2_seo_schema_faqpage_node()` למטה (השדות `q`/`a` שT2 מחזיר תואמים ישירות לפונקציית הבנייה).

**פונקציית בנייה (builder) מומלצת, `mu-plugins/ea-w2-seo-schema.php`:**
```php
function ea_w2_seo_schema_faqpage_node( array $items, string $slug ) {
    $site = home_url( '/' );
    $entities = array();
    foreach ( $items as $it ) {
        if ( empty( $it['q'] ) || empty( $it['a'] ) ) { continue; }
        $entities[] = array(
            '@type'          => 'Question',
            'name'           => wp_strip_all_tags( (string) $it['q'] ),
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => wp_kses_post( (string) $it['a'] ), // HTML קיים כבר תואם למדיניות גוגל (p/a/ul/li/strong)
            ),
        );
    }
    return array(
        '@type'      => 'FAQPage',
        '@id'        => $site . '#/schema/faqpage/' . $slug,
        'mainEntity' => $entities,
    );
}
```

**הערת מדיניות גוגל (לניהול ציפיות, לא חוסמת בנייה):** מאוגוסט 2023 גוגל מגביל תצוגת rich result עשיר (accordion בתוצאות חיפוש) עבור FAQPage כמעט אך ורק לאתרי ממשל/בריאות מוכרים — **אתר כמו זה לא צפוי לקבל accordion בגוגל גם עם המימוש הזה.** ה-markup עדיין בעל ערך אמיתי (AEO/GEO — מנועי AI כמו ChatGPT/Perplexity, Bing, ה-Knowledge Graph, וכן מסמך האסטרטגיה המקורי של אייל שהזמין את T4 מלכתחילה) — רק שהתוצאה הנראית-לעין בגוגל עצמו לא תהיה "כוכביות/אקורדיון". שווה תקשור לEyal/team_00 כדי שהציפייה תהיה מדויקת.

### 2.3 Book — מבנה מדויק

**מבנה JSON-LD (schema.org, קבוע):**
```json
{
  "@type": "Book",
  "@id": "https://eyalamit.co.il/#/schema/book/{slug}",
  "name": "שם הספר",
  "url": "https://eyalamit.co.il/books/{slug}/",
  "image": "כתובת כריכה",
  "author": { "@id": "https://eyalamit.co.il/#/schema/person/eyal-amit" },
  "publisher": { "@type": "Organization", "name": "מוזה הוצאה לאור", "url": "https://eyalamit.co.il/books/" },
  "inLanguage": "he",
  "genre": "טקסט חופשי — כבר קיים כ'genre' בנתוני Wave2",
  "datePublished": "YYYY",
  "numberOfPages": 128,
  "offers": [
    { "@type": "Offer", "price": "59", "priceCurrency": "ILS", "url": "קישור רכישה מודפס", "availability": "https://schema.org/InStock" },
    { "@type": "Offer", "price": "59", "priceCurrency": "ILS", "url": "קישור רכישה דיגיטלי", "availability": "https://schema.org/InStock" }
  ]
}
```

**מיפוי שדות → מקור (הנתונים כבר קיימים בפועל היום ב-Wave2, ב-`ea_w2_05_book_map()`, `inc/wave2-w2-05.php:737-798` — טרם הועברו ל-Chapters; T3b הוא זה שמעביר אותם):**

| שדה schema.org | סוג נדרש | מקור נתון קיים (Wave2, לפני T3b) | פער? |
|---|---|---|---|
| `name` | Text | `$book['title']` | אין |
| `author` | Person | `@id` לצומת ה-Person הקיים (`#/schema/person/eyal-amit`) — **לא** ליצור Person חדש | אין |
| `publisher` | Organization | טקסט חופשי "מוזה הוצאה לאור" (`inc/wave2-w2-05.php:889` ועוד) — **אף פעם לא מעוצב כישות schema** | קטן — Organization inline חדש, בלי `@id` נפרד (לא נדרש reuse בין ספרים) |
| `genre` | Text/URL | `$m['genre']` (למשל "רומן פנטזיה") | אין |
| `datePublished` | Date | `$m['meta']` שורת "יצא לאור" (למשל "2001") — **שנה בלבד, לא תאריך מלא** | אין — פורמט "YYYY" הוא ISO-8601 חלקי תקין |
| `numberOfPages` | Integer | `$m['meta']` שורת "עמודים" (למשל "128") — **cast ל-int** | אין |
| `inLanguage` | Text | קבוע `"he"` (כל 3 הספרים בעברית) | אין |
| `image` | URL | `ea_w2_05_cover_url($m['cover'])` | אין |
| `offers[].price` + `.url` | Offer | `$m['price']` + `$m['buy']['print']` / `$m['buy']['ebook']` | **תלוי ב-T3b + C-5** (ר' למטה) |
| `isbn` | Text | **לא קיים בשום מקום בקוד** — אומת בחיפוש מלא בריפו | **פער תוכן אמיתי — ר' למטה** |

**שני פערים אמיתיים, לא החלטות עיצוב — לא ל-T4 להכריע:**
1. **ISBN — נעדר לגמרי.** נסרק כל הריפו (theme + mu-plugins + תוכן) — אין אף אזכור ISBN לאף אחד משלושת הספרים. schema.org לא מחייב `isbn` (השדה אופציונלי), אז **T4 פשוט משמיט את השדה** אם לא יסופק. אם team_00/אייל ירצו בכל זאת — זו בקשת-תוכן חיצונית מאייל, באותו אופן בדיוק כמו C-5 (לא שאלת ארכיטקטורה). לא חוסם את הבנייה.
2. **קישורי רכישה (offers) — תלוי ב-T3b + C-5.** LOD300 C-5 מתעד שלעמוד "צבע בכחול וזרוק לים" יש שני קישורי Mendele שונים בפועל בין Wave2 ל-Chapters (סלאג `tzvabekahol` מול `tsvabacholvezorekleyam`) — עדיין ממתין לתשובת אייל. **T4 לא בוחר איזה קישור נכון — קורא ל-`ea_chapters_field()` עם שם השדה הסופי שT3b בוחר, מה שיהיה הערך שם באותו רגע.** אם C-5 עדיין לא נפתר בזמן שT4 נבנה בפועל, `offers[].url` פשוט מצביע למה שכרגע חי בעמוד (ולא ל"תשובה נכונה" שעדיין לא קיימת) — אין כאן חסם, יש כאן "תוצאה תלוית-קלט-חיצוני".

**חוזה עם T3b — נעול (תיקון F90-03, ולידציה חוצת-מנוע 14/7):** גרסה קודמת של הסעיף הזה השאירה את שמות השדות כ-placeholder ("הבנאי ימפה לשמות שT3b בפועל קבע") — אבל T3b, כפי שנכתב בפועל, מטמיע את המחיר בתוך טקסט הכפתור (`'cta_label' => '… · 79 ₪'`) ואת קישורי הרכישה בתוך `cta_url`/`cta2_url` — **אף פעם לא כשדות עצמאיים שאפשר לקרוא להם**. זו הייתה סתירה אמיתית, לא רק חוסר-ניסוח. **תוקן**: T3b §3.0.g (חדש, ר' שם) מוסיף לכל אחד מ-3 קבצי ה-defaults **שדות עליונים נפרדים**, בדיוק בשמות הבאים — **אלה השמות הסופיים, לא placeholder עוד**:

| שדה ב-defaults array | מקביל schema.org | מקור הערך |
|---|---|---|
| `'price'` (int, בלי סימן ₪) | `offers[].price` | T3b §3.0.g — כבר קיים בטקסט ה-`cta_label`, מוצא כאן גם כשדה נקי |
| `'buy_print_url'` | `offers[0].url` | T3b §3.0.g — אותו ערך בדיוק כמו `cta_url`/`cta2_url` הקיימים |
| `'buy_ebook_url'` | `offers[1].url` | T3b §3.0.g — אותו ערך בדיוק |
| `'genre'` | `genre` | **לשלוף מ-`ea_w2_05_book_map()['genre']` (`inc/wave2-w2-05.php:737+`, קריאה בלבד, קובץ עדיין קיים עד T6) — להעתיק את הערך המילולי בזמן המימוש, לא צוטט כאן כי לא אומת ישירות במחקר ה-LOD400 הזה** |
| `'meta_year'` | `datePublished` | כנ"ל — מ-`$m['meta']` שורת "יצא לאור" |
| `'meta_pages'` | `numberOfPages` | כנ"ל — מ-`$m['meta']` שורת "עמודים" (וכתבת: כבר ידוע 252, מוזכר בטקסט הקיים ב-SECTION 06) |
| `'isbn'` | `isbn` | לא קיים בשום מקור — להשמיט (ר' §2 סעיף הפערים למעלה) |

T4 קורא לכל השדות האלה **אך ורק** דרך `ea_chapters_field( $field_name, $post_id )` / `ea_chapters_defaults()` (שכבת ה-accessor הקיימת של Chapters, `inc/chapters/chapters-render.php:145-154`) — **לא** דרך `ea_w2_05_book_map()` או כל פונקציה אחרת מ-`wave2-w2-05.php` ישירות, כדי לא ליצור תלות-ריצה חדשה בקובץ שT6 עתיד למחוק.

**פונקציית בנייה (builder) מומלצת:**
```php
function ea_w2_seo_schema_book_node( string $slug, int $post_id ) {
    $site = home_url( '/' );
    $node = array(
        '@type'      => 'Book',
        '@id'        => $site . '#/schema/book/' . $slug,
        'name'       => get_the_title( $post_id ),
        'url'        => get_permalink( $post_id ),
        'author'     => array( '@id' => $site . '#/schema/person/eyal-amit' ),
        'publisher'  => array( '@type' => 'Organization', 'name' => 'מוזה הוצאה לאור', 'url' => home_url( '/books/' ) ),
        'inLanguage' => 'he',
    );
    // שמות השדות הבאים = placeholder; להתאים לשמות הסופיים שT3b קובע:
    $genre = ea_chapters_field( 'genre', $post_id );
    if ( $genre )           { $node['genre'] = $genre; }
    $year = ea_chapters_field( 'meta_year', $post_id );
    if ( $year )             { $node['datePublished'] = (string) $year; }
    $pages = ea_chapters_field( 'meta_pages', $post_id );
    if ( is_numeric( $pages ) ) { $node['numberOfPages'] = (int) $pages; }
    $cover = ea_chapters_img( 'cover', 'full' );
    if ( $cover )            { $node['image'] = $cover; }
    $isbn = ea_chapters_field( 'isbn', $post_id ); // ריק עד שיסופק ע"י אייל — לא שדה חובה
    if ( $isbn )              { $node['isbn'] = $isbn; }

    $offers = array();
    $price      = ea_chapters_field( 'price', $post_id );
    $print_url  = ea_chapters_field( 'buy_print_url', $post_id );
    $ebook_url  = ea_chapters_field( 'buy_ebook_url', $post_id );
    foreach ( array( $print_url, $ebook_url ) as $url ) {
        if ( $url && is_numeric( $price ) ) {
            $offers[] = array(
                '@type'         => 'Offer',
                'price'         => (string) $price,
                'priceCurrency' => 'ILS',
                'url'           => $url,
                'availability'  => 'https://schema.org/InStock',
            );
        }
    }
    if ( $offers ) { $node['offers'] = count( $offers ) === 1 ? $offers[0] : $offers; }

    return $node;
}

// טריגר בתוך ea_w2_seo_schema_graph():
$ea_book_slugs = array( 'vekatavta', 'kushi-blantis', 'tsva-bekahol' );
if ( is_page() ) {
    $ea_obj = get_queried_object();
    if ( $ea_obj instanceof WP_Post && in_array( $ea_obj->post_name, $ea_book_slugs, true ) ) {
        $graph[] = ea_w2_seo_schema_book_node( $ea_obj->post_name, (int) $ea_obj->ID );
    }
}
```
זיהוי העמוד נעשה ברשימת-סלאגים קשיחה (כמו `$services` הקיים באותו קובץ) — **לא** לפי postmeta (בניגוד ל-Product), כי אין עדיין שם-שדה מוסכם מ-T3b וקבוצת 3 הספרים יציבה/נדירת-שינוי, בדיוק כמו קבוצת ה-3 שירותים הקיימת כבר באותו סגנון באותו קובץ.

**הערת ציפיות (כמו FAQPage):** ל-Book **אין** סוג rich-result ייעודי בגוגל (בשונה מ-Product/FAQPage/Review) — ה-markup תורם ל-Knowledge Graph כללי, למנועי AI, ול-Bing, אבל לא צפוי להניב badge/rich-snippet ספציפי בגוגל. שווה לתקשר גם את זה.

---

## 3. T5 — /shop: פורט מדויק

### 3.1 מצב קיים (אומת בקוד)

- ניתוב: `inc/wave2-w2-05.php`, `ea_w2_05_slugs()` (שורות 30-39) — `'shop' => 'tpl-shop-archive'`, top-level בלבד (`post_parent === 0`, נבדק ב-`ea_w2_05_current_slug()` שורות 46-60). מנותב ב-`ea_w2_05_template_include()` על `template_include` **עדיפות 100** (שורה 89).
- Template: `page-templates/tpl-shop-archive.php` — מעטפת 14 שורות, `get_header()` + topnav + `while(have_posts()){the_post(); the_content();}` + footer. אין HTML אמיתי בקובץ עצמו.
- התוכן האמיתי מוזרק דרך `add_filter('the_content', 'ea_w2_05_inject_content', 9)` (שורה 222) → `ea_w2_05_render_archive()` (שורות 626-652) → `ea_w2_05_catalog_cards()` (שורות 660-704): מערך קשיח של 5 מוצרים (`slug`,`title`,`excerpt`) + מחיר **נגזר בזמן ריצה** מ-`get_post_meta( $page->ID, 'ea_product_price', true )` על כל אחד מ-5 עמודי המוצר (כרגע ריק לכולם → נופל ל"מחיר לפי התאמה").
- **קריטי:** Chapters כבר מנצחת ב-`/qr` שווה-ערך — 5 עמודי המוצר עצמם (`didgeridoos`/`bags`/`stands-storage`/`stand-floor`/`repair`) **כבר** ב-`ea_chapters_route_map()` (`inc/chapters/chapters-render.php:40-44`) ומנצחים היום בפועל (LOD300 C-1, אומת חי ב-14/7). `/shop` עצמו הוא ה-slug היחיד מ-5+1 שעדיין **לא** ברשימה.

### 3.2 המנגנון — תוספת מכנית, בלי מנגנון חדש

מכיוון ש-`/shop` הוא slug שטוח ברמה עליונה (`post_parent === 0`), הוא **כבר** תואם 1:1 את המנגנון הקיים של `ea_chapters_route_map()` — אותו מנגנון בדיוק שכבר מנצח היום עבור 5 עמודי המוצר. אין צורך במנגנון ניתוב חדש כלל.

**שינויים:**

1. **`inc/chapters/chapters-render.php`** — להוסיף שורה אחת ל-`ea_chapters_route_map()` (אחרי `'repair'`, שורה 44):
   ```php
   'shop' => array( 'template' => 'tpl-chapters-page', 'type' => 'shop' ),
   ```
   מעדיפות 103 (Chapters) > 100 (Wave2) — Chapters מנצחת אוטומטית, **אותו מנגנון בדיוק** שכבר מוכיח את עצמו על 5 המוצרים.

2. **קובץ חדש: `inc/chapters/defaults/shop-defaults.php`** — `phero` (כותרת "כלים ואביזרים לדיג'רידו" + טקסט מבוא, מועתק מ-`ea_w2_05_render_archive()` שורות 632-633) + `sections` עם **פריט אחד**, part קיים ולא חדש: `bookcard` (`template-parts/chapters/parts/bookcard.php`) — ר' §3.3.

3. **בתוך `shop-defaults.php` עצמו** — 5 המוצרים **משוכפלים במכוון** (לא נקראים מ-`ea_w2_05_catalog_cards()`), כדי **לא** ליצור תלות-ריצה חדשה בקובץ שT6 עתיד למחוק כליל:
   ```php
   $ea_shop_defs = array(
       array( 'slug' => 'didgeridoos',    'title' => "כלי דיג'רידו למכירה",              'excerpt' => 'כלים בעבודת יד, מותאמים לצליל ולנשימה.' ),
       array( 'slug' => 'bags',           'title' => "תיקים לדיג'רידו",                   'excerpt' => 'הגנה ונשיאה נוחה לכלי, בעבודת יד.' ),
       array( 'slug' => 'stands-storage', 'title' => "סטנדים לאחסון דיג'רידו",            'excerpt' => 'תלייה או עמידה — אחסון יציב ובטוח.' ),
       array( 'slug' => 'stand-floor',    'title' => "סטנד רצפתי לנגינה בישיבה נמוכה",     'excerpt' => 'יציבות ונוחות לנגינה בישיבה על הרצפה.' ),
       array( 'slug' => 'repair',         'title' => "תיקון וחידוש דיג'רידו",             'excerpt' => 'שירות תיקון מקצועי לכלי דיגי\'רידו.' ),
   );
   $ea_shop_items = array();
   foreach ( $ea_shop_defs as $d ) {
       $price = '';
       $page  = get_page_by_path( $d['slug'] );
       if ( $page instanceof WP_Post ) {
           $meta  = get_post_meta( $page->ID, 'ea_product_price', true );
           $price = is_string( $meta ) ? trim( $meta ) : '';
       }
       $ea_shop_items[] = array(
           'title' => $d['title'],
           'blurb' => $d['excerpt'],
           'url'   => home_url( '/' . $d['slug'] . '/' ),
           'meta'  => '' !== $price ? $price . ' ₪' : 'מחיר לפי התאמה',
           // 'cover' מכוון ריק — אין תמונות אמיתיות למוצרים היום (LOD300 C-2); bookcard.php
           // כבר נופל בחן לפלייסהולדר מעוצב כש-cover ריק (ר' §3.3) — לא regression, פשוט משקף
           // את המצב האמיתי, וישתפר אוטומטית ברגע שT3 יזין תמונות אמיתיות ל-gallery.
       );
   }
   return array(
       'phero' => array( 'chap' => 'חנות', 'title' => "כלים ואביזרים לדיג'רידו", 'sub' => 'כלים בעבודת יד, תיקים, סטנדים, וכן שירות תיקון וחידוש.' ),
       'sections' => array(
           array( 'part' => 'bookcard', 'args' => array( 'chap' => 'המוצרים', 'title' => 'כל המוצרים', 'items' => $ea_shop_items, 'alt' => false ) ),
       ),
   );
   ```
   *(הערה: אותו postmeta lookup `ea_product_price` בדיוק כמו היום — אם T3 ישנה איך המחיר נשמר, השורה הזו צריכה להתעדכן בהתאם; זו נקודת-תיאום עם T3, לא חסם.)*

### 3.3 שימוש חוזר ב-`bookcard.php` — לא חלק חדש

`template-parts/chapters/parts/bookcard.php` (כבר קיים, משמש היום את `/books/`) מקבל בדיוק `items[{cover,title,blurb,url,meta}]` — צורת נתונים גנרית של "רשת כרטיסי-קישור", לא ספציפית לספרים למרות השם. נופל בחן ל-placeholder מעוצב (`.ph.ph--d`) כש-`cover` ריק (שורות 32-36 בקובץ) — בדיוק המצב של 5 המוצרים היום (אין תמונות אמיתיות, LOD300 C-2). **אין צורך בקומפוננטה חדשה** — שימוש-חוזר 1:1. (שם המחלקה `.bookcard`/`.bookcards` נשאר כפי שהוא — שינוי-שם קוסמטי הוא nice-to-have נפרד, לא נדרש כאן ולא מומלץ באותו WP כדי לצמצם diff.)

---

## 4. T5 — /qr: מנגנון הניתוב המוצע

### 4.1 ממצא יסוד — איך `/qr/qrN/` באמת עובד היום (זה משנה את כל התכנון)

נחקר לעומק (לא רק § הראיות של LOD300): **48 עמודי ה-QR + עמוד ה-hub `qr` הם עמודי WordPress אמיתיים (`post_type=page`) בטבלת `wp_posts` — לא כתובות מדומות שקוד בונה.**

מקור: `mu-plugins/ea-w2-07-qr-seed-once.php` — mu-plugin שרץ **פעם אחת** (`add_action('init', 'ea_w2_07_qr_seed_maybe_run', 28)`, שורה 155; מוגן ב-option flag `ea_w2_07_qr_seeded_v3` + transient lock), קורא ל-`mu-plugins/ea-w2-07-qr-content-data.php` (78KB, `return array('qr1'=>array('title'=>...,'html'=>...), ..., 'qr48'=>...)` — **אומת: בדיוק 48 מפתחות**, מיוצר ע"י סקריפט חיצוני, "DO NOT EDIT BY HAND"), ויוצר עם `wp_insert_post()`:
- עמוד הורה יחיד: `post_title='QR'`, `post_name='qr'`, `post_parent=0`, **תוכן ריק** (`<p></p>`), **בלי** `_wp_page_template` (שורה 126).
- 48 עמודי-בת: `post_name={qr1..qr48}`, `post_parent=`(מזהה עמוד ה-hub), `post_content=`התוכן האמיתי מהמיגרציה, `_wp_page_template='page-templates/tpl-qr.php'` (שורות 132-140).

**שלוש עובדות קריטיות שאומתו ישירות בקוד, לא הונחו:**

1. **אין אף rewrite rule מותאם-אישית באתר עבור /qr.** נסרק *כל* קובץ ב-theme וב-mu-plugins אחר `add_rewrite_rule` / `add_rewrite_tag` / `add_rewrite_endpoint` — **אפס תוצאות**. המשמעות: הצורה `/qr/qrN/` אינה תוצר של קוד ניתוב כלשהו באתר הזה — היא **תוצר סטנדרטי ומובנה של WordPress core**: permalink של עמוד-בן היררכי = `/{slug-הורה}/{slug-בן}/`, נגזר אוטומטית מ-`post_parent`+`post_name`, בדיוק כמו שכל אתר WordPress עם pretty permalinks מתנהג עם עמודי-בת, ללא צורך בקוד נוסף.

2. **`inc/wave2-w2-07.php` לא "מנתב" את `/qr/qrN/` בשום מובן אמיתי.** הפונקציה היחידה שם שמזיזה template (`ea_w2_07_template_include`, `template_include@100`, שורות 65-74) מטפלת **רק** ב-`/press` (`ea_w2_07_is_press()`). `ea_w2_07_is_qr()` (שורות 36-48) משמשת **אך ורק** לתפקידים קוסמטיים: body class (שורה 91-101), הסתרת כותרת GeneratePress (120-123), sidebar layout (109-112), enqueue של `w2-07-heritage.css` (128-141). **אף אחת מהפונקציות האלה לא בוחרת את ה-template בפועל.**

3. **בחירת ה-template של כל אחד מ-48 העמודים נעשית ע"י ליבת WordPress עצמה**, דרך ה-postmeta `_wp_page_template` שכל עמוד נושא — מנגנון סטנדרטי (`get_page_template()`) שמריץ **לפני** ש-`template_include` filter chain בכלל מופעל; ה-`template_include` filters (Wave2 בעדיפות 100, Chapters בעדיפות 103) רק *מקבלים הזדמנות לדרוס* את מה שליבת ה-WP כבר בחרה — הם לא הסיבה שהכתובת עצמה נפתרת לעמוד הנכון.

**המשמעות המעשית העמוקה:** שאלת "מי מרנדר את `/qr/qrN/`" (Wave2 / Chapters) **מנותקת לגמרי, מבנית, משאלת "האם הכתובת פותרת ל-200"**. הכתובת פותרת נכון כל עוד קיימים עמוד עם אותו `post_name`+`post_parent` — בלי קשר לאיזה template מוצמד לו. זה בדיוק מה שהופך את דרישת team_00 (§4.3 למטה) לניתנת-להבטחה באופן קשיח, לא רק "בפועל עבד בבדיקה".

**ראיה תומכת נוספת:** `mu-plugins/ea-w209-legacy-301-redirects.php` (מנגנון ה-301/410 הקיים והמתפקד של האתר) כבר מכיל היום ערך 410 קבוע לכתובת QR ישנה-בסלאג-עברי (`/qr/פרק-א/`, שורה 22) ממיגרציה קודמת — מוכיח שהצוות כבר טיפל פעם אחת בדיוק בסוג הזה של שאלה (סלאג QR ישן שהוחלף), ושיש כלי redirect/410 עובד וזמין **אם אי-פעם יידרש**. **העיצוב המוצע כאן לא נוגע בקובץ הזה כלל ולא מוסיף לו שורה** — כי (ר' §4.3) אף סלאג לא משתנה.

### 4.2 המנגנון המוצע

שני חלקים נפרדים, כי ל-hub (עמוד יחיד, top-level) ול-48 הילדים (parent+N pattern) יש צרכים שונים מהותית:

#### 4.2.1 עמוד ה-hub `/qr/` — מנגנון קיים, בלי תוספת תשתית

`qr` הוא slug שטוח, top-level (`post_parent=0`) — **בדיוק** כמו `/shop/` (§3) ו-3 עמודי הספרים. שום דבר חדש לא נדרש כאן ברמת המנגנון:

1. **`inc/chapters/chapters-render.php`**, `ea_chapters_route_map()` — שורה חדשה:
   ```php
   'qr' => array( 'template' => 'tpl-chapters-page', 'type' => 'qr-hub' ),
   ```
2. **קובץ חדש: `inc/chapters/defaults/qr-hub-defaults.php`** — `phero` + section יחיד `bookcard` (שוב שימוש-חוזר, §3.3) עם רשת של עד 48 כרטיסי-קישור, אחד לכל עמוד-בת:
   ```php
   $ea_qr_data_file = WPMU_PLUGIN_DIR . '/ea-w2-07-qr-content-data.php';
   $ea_qr_items = array();
   if ( is_readable( $ea_qr_data_file ) ) {
       $ea_qr_pages = (array) include $ea_qr_data_file; // אותו מקור-אמת שהזריע את העמודים עצמם
       // מיון מספרי לפי המספר שאחרי 'qr' (לא מיון-מחרוזת — qr10 לא לפני qr2).
       uksort( $ea_qr_pages, function( $a, $b ) {
           return (int) substr( $a, 2 ) <=> (int) substr( $b, 2 );
       } );
       foreach ( $ea_qr_pages as $ea_slug => $ea_page ) {
           $ea_qr_items[] = array(
               'title' => $ea_page['title'],
               'url'   => home_url( '/qr/' . $ea_slug . '/' ),
           );
       }
   }
   return array(
       'phero'    => array( 'chap' => 'QR', 'title' => 'דפי ה-QR', 'sub' => 'כל עמוד קשור לקוד QR מודפס באחד הספרים.' ),
       'sections' => array(
           array( 'part' => 'bookcard', 'args' => array( 'items' => $ea_qr_items, 'alt' => false ) ),
       ),
   );
   ```
   **הערה חשובה על scope:** עמוד ה-hub **כיום ריק בפועל** (`<p></p>` בלבד, בלי template ייעודי — נופל ל-`page.php` ברירת-המחדל של GeneratePress, בלי שום UI משמעותי). בניית רשת-קישורים אמיתית כאן היא **שיפור תוכן אמיתי, לא רק פורט** — אבל בסיכון-רגרסיה אפסי (אין שום "מצב חי" לשבור) ובעלות-בנייה זניחה (שימוש חוזר מלא ב-`bookcard.php` + קריאה ישירה לאותו קובץ-נתונים שכבר קיים). **אלטרנטיבה שמרנית יותר** (אם team_110/team_100 מעדיפים שT5 יישאר "פורט טהור" בלי תוספת UI): להשאיר `qr-hub-defaults.php` עם `sections => array()` (עמוד ריק, מזוהה כ-Chapters לצורך "אפס Wave2" של LOD300, אך בלי רשת). **המלצה: לבנות את הרשת** — זה בדיוק סוג ה"ניקיון תוך כדי איחוד" שה-WP הזה נועד לאפשר, ואין לו עלות סיכון.

#### 4.2.2 48 עמודי-הבת — מנגנון pattern-route חדש (הליבה של T5/qr)

זה החלק שבאמת חסר ב-Chapters היום. **החלטה מפורשת: לא לדחוס את 48 גופי ה-HTML הגולמיים (שמכילים `<iframe>` מוטבע, `<img>` ותלות ב-wpautop לפורמט) לתוך דפוס ה-`sections`/typed-parts הרגיל של Chapters.** הסיבה: דפוס ה-`sections` (`ea_chapters_field`/`ea_chapters_rows`, `wp_kses_post($a['body'])` ישירות בתוך `prose.php`) מיועד לתוכן שנכתב-ביד ומוזרק כ-args קבועים בקובץ defaults — **לא** עובר דרך ה-`the_content` filter chain של וורדפרס. שכתוב 48 גופי-HTML גולמיים ל-args מובנים היה: (א) עבודה לא-פרופורציונלית להיקף של משימת איחוד-ניתוב, (ב) סיכון אמיתי לנאמנות-תוכן (פורמט תלוי-wpautop עלול להישבר), ו-(ג) מיותר — כי יש פתרון נקי בהרבה.

**הפתרון: template ייעודי חדש, לא דפוס sections.**

1. **`inc/chapters/chapters-render.php`** — פונקציית מפה חדשה, לצד `ea_chapters_route_map()` הקיימת, **באותה פילוסופיה מוצהרת שכבר כתובה בדוקבלוק של הפונקציה הקיימת** ("Filterable so the set can grow without touching the router"):
   ```php
   /**
    * "הורה + N ילדים ממוספרים" routes — parent-slug ⇐ template+type, לא סלאג בודד.
    * מיועד לתוכן שבו כל עמוד-בת נושא post_content אמיתי משלו (לא sections מובנים).
    *
    * @return array<string,array{template:string,type:string}>
    */
   function ea_chapters_pattern_routes() {
       return (array) apply_filters( 'ea_chapters_pattern_routes', array(
           'qr' => array( 'template' => 'tpl-chapters-qr', 'type' => 'qr' ),
       ) );
   }
   ```
   וכן הרחבת `ea_chapters_is_view()` הקיימת (שורות 93-101) כדי שגם ה-pattern route תיחשב "Chapters view" (נדרש עבור enqueue של CSS/JS, ר' סעיף 3 למטה):
   ```php
   function ea_chapters_is_view() {
       if ( ! ea_chapters_enabled() ) { return false; }
       if ( is_front_page() && is_page() ) { return true; }
       if ( isset( ea_chapters_route_map()[ ea_chapters_current_slug() ] ) ) { return true; }
       // חדש: התאמת pattern-route (הורה+ילד).
       if ( is_page() ) {
           $post = get_queried_object();
           if ( $post instanceof WP_Post && $post->post_parent ) {
               $parent_slug = get_post_field( 'post_name', (int) $post->post_parent );
               if ( isset( ea_chapters_pattern_routes()[ $parent_slug ] ) ) { return true; }
           }
       }
       return false;
   }
   ```

2. **`inc/chapters/chapters-routing.php`** — הרחבת `ea_chapters_template_include()` הקיימת (שורות 18-37) בענף נוסף, **אחרי** ההתאמה השטוחה הקיימת (סדר: slug מדויק קודם, pattern-route אח"כ — מוציא-שולל הדדית מבנית, הסדר לא משנה בפועל אבל נשמר מפורש לבהירות):
   ```php
   function ea_chapters_template_include( $tpl ) {
       if ( ! ea_chapters_enabled() ) { return $tpl; }
       if ( is_front_page() && is_page() ) {
           $t = locate_template( 'page-templates/tpl-chapters-home.php' );
           return $t ? $t : $tpl;
       }
       if ( is_page() ) {
           $map  = ea_chapters_route_map();
           $slug = ea_chapters_current_slug();
           if ( isset( $map[ $slug ] ) ) {
               $t = locate_template( 'page-templates/' . $map[ $slug ]['template'] . '.php' );
               if ( $t ) { return $t; }
           }
           // חדש: pattern-route — הורה+ילד (למשל /qr/qrN/).
           $post = get_queried_object();
           if ( $post instanceof WP_Post && $post->post_parent ) {
               $parent_slug = get_post_field( 'post_name', (int) $post->post_parent );
               $patterns    = ea_chapters_pattern_routes();
               if ( isset( $patterns[ $parent_slug ] ) ) {
                   $t = locate_template( 'page-templates/' . $patterns[ $parent_slug ]['template'] . '.php' );
                   if ( $t ) { return $t; }
               }
           }
       }
       return $tpl;
   }
   ```
   **חשוב: תנאי ה-guard `if ( ! ea_chapters_enabled() ) { return $tpl; }` נשאר ראשון, ללא שינוי** — ר' §4.4 (תאימות ל-rollback).

3. **קובץ חדש: `page-templates/tpl-chapters-qr.php`** — אותה "מעטפת" עצמאית (`<html>`/`wp_head`/nav/footer) כמו `tpl-chapters-page.php`, אבל **הגוף קורא ל-`the_content()` אמיתי על הפוסט הנשאל בפועל** — בדיוק כמו `tpl-qr.php` היום — ולא לולאת `sections`:
   ```php
   <?php
   /**
    * Template: תוכן QR בודד תחת /qr/{slug}/. פרק Chapters מלא (nav/phero/footer),
    * אבל הגוף מרנדר את ה-post_content האמיתי של העמוד (the_content אמיתי, לא sections
    * מובנים) — נאמנות מלאה לתוכן שכבר קיים, בלי שכתוב-מבנה.
    */
   defined( 'ABSPATH' ) || exit;
   $GLOBALS['ea_chapters_type'] = 'qr'; // seam קיים ומתועד ב-ea_chapters_type() — טוען qr-defaults.php
   ?><!DOCTYPE html>
   <html <?php language_attributes(); ?>>
   <head>
   <meta charset="<?php bloginfo( 'charset' ); ?>" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <?php wp_head(); ?>
   </head>
   <body <?php body_class(); ?>>
   <?php wp_body_open(); ?>
   <a class="ea-skip-link screen-reader-text" href="#chapters-main">דלג לתוכן העמוד</a>
   <?php get_template_part( 'template-parts/chapters/section', 'nav' ); ?>
   <main id="chapters-main">
       <?php
       get_template_part( 'template-parts/chapters/parts/phero', null, array(
           'chap'  => 'QR',
           'title' => get_the_title(), // כותרת אמיתית של העמוד הזה, לא ברירת מחדל משותפת
       ) );
       while ( have_posts() ) : the_post(); ?>
           <section class="sec">
               <div class="wrap">
                   <div class="intro-body r r2"><?php the_content(); ?></div>
                   <p class="r" style="margin-top:var(--ea-space-8, 32px)">
                       <a class="tlink" href="<?php echo esc_url( home_url( '/qr/' ) ); ?>">← כל דפי ה-QR</a>
                   </p>
               </div>
           </section>
       <?php endwhile; ?>
   </main>
   <?php get_template_part( 'template-parts/chapters/section', 'footer' ); wp_footer(); ?>
   </body>
   </html>
   ```
   שימוש ב-`the_content()` **אמיתי** (לא `get_the_content()`/העתקה ידנית) הוא מכוון — מפעיל את שרשרת ה-filters התקנית של וורדפרס (`wpautop` וכו') בדיוק כמו היום, כך שהפלט הרנדר-מוצג זהה-בפועל למה שהיה קודם, רק בתוך מעטפת Chapters.

4. **קובץ חדש (זעיר): `inc/chapters/defaults/qr-defaults.php`** — רק chrome משותף, לא תוכן:
   ```php
   <?php
   defined( 'ABSPATH' ) || exit;
   return array( 'phero' => array( 'chap' => 'QR' ) ); // fallback בלבד; ה-template דורס title/sub בפועל
   ```

5. **CSS — פער ממצא-קוד קונקרטי, לא השערה:** גופי ה-QR מכילים בפועל **60 תגיות `<iframe>`** (הטמעות YouTube) ו-**12 תגיות `<img class="ea-qr-img">`** (נספר ישירות ב-`ea-w2-07-qr-content-data.php`). כרגע הן מקבלות עיצוב-רספונסיבי מ-`assets/css/w2-07-heritage.css` (שורות 27-48: `.ea-qr-img{max-width:100%;...}` + `.ea-qr-embed--video{aspect-ratio:16/9;...}` + `.ea-qr-embed--video iframe{position:absolute;inset:0;width:100%;height:100%}`) — קובץ ש-`tpl-chapters-qr.php` **לא** יטען (כי הוא לא ב-Wave2 shell). **`assets/css/chapters.css` הנוכחי נבדק — אין בו כלל שהתאמה ל-iframe גולמי בתוך `.intro-body`.** בלי טיפול, סרטוני YouTube בתוך גוף QR יירנדרו ברוחב קבוע (ברירת המחדל של YouTube, כ-560px) בלי scale רספונסיבי — overflow אמיתי במובייל. **תיקון מדויק, זול:** להעתיק את 3 חוקי ה-CSS (`.ea-qr-img`, `.ea-qr-embed--video`, `.ea-qr-embed--video iframe`) מ-`w2-07-heritage.css` (שורות 27-48) אל `assets/css/chapters.css` **verbatim** (אותם שמות מחלקה בדיוק — המחלקות האלה כבר קיימות ב-HTML המאוחסן עצמו, אין צורך לגעת בתוכן, רק להוסיף את הכללים ליעד ה-CSS החדש).

### 4.3 ערבות שימור ה-URL — הצהרה חד-משמעית (הקריטריון החשוב ביותר)

**הבטחה (דויקה — ולידציה חוצת-מנוע 14/7, F90-05):** כל אחת מ-48 כתובות `/qr/qrN/` הקיימות (וכן `/qr/` עצמו) ממשיכה להחזיר 200 עם אותו תוכן מהותי, בכל שלב של המימוש הזה — כולל תרחיש rollback חירום — **כל עוד שורות-העמוד ב-`wp_posts` (`post_name`/`post_parent`) ומבנה ה-permalinks של האתר לא משתנים.** זו לא הבטחה מותנית-מטושטשת — זה בדיוק מה ש"מבנית, לא רק נבדק ועבד" אומר בפועל: המנגנון המוצע כאן לא נוגע בשום שלב בשורות ה-DB עצמן (ר' סעיף 2 למטה) ולכן אינו יכול לשבור אותן — אבל אם **מישהו אחר**, מחוץ למנגנון הזה, ישנה/ימחק שורת-עמוד או ישנה permalink structure, שום עיצוב קוד לא יכול להבטיח נגד זה. נאמנות-תוכן (מה שכתוב בעמוד) היא שאלה נפרדת משאלת פענוח-ה-URL עצמה.

**למה ההבטחה הזו מוכחת מבנית, לא רק "נבדקה ועבדה":**

1. הכתובת `/qr/qrN/` **לא** נגזרת מקוד-ניתוב כלשהו — היא נגזרת אך ורק מ-`post_name`+`post_parent` של רשומת עמוד אמיתית ב-`wp_posts` (§4.1, אומת: אין אף `add_rewrite_rule` בריפו).
2. **המנגנון המוצע כאן (§4.2) לא נוגע — בשום שלב, בשום קובץ — ב-`post_name`, `post_parent`, `post_status`, או ה-ID של אף אחד מ-49 העמודים (ה-hub + 48 הילדים).** כל השינוי מתמצה בהוספת קוד PHP חדש לחלוטין (2 קבצים חדשים + 2 תוספות קטנות לקבצים קיימים) שקובע **אך ורק** "איזה template מרנדר" — שכבה שרצה *אחרי* שהכתובת כבר נפתרה בהצלחה לעמוד הנכון ע"י ליבת וורדפרס.
3. **המנגנון גם לא נוגע ב-`_wp_page_template` postmeta הקיים** (`page-templates/tpl-qr.php`) על אף אחד מ-48 העמודים — הדריסה קורית ברמת `template_include` filter (עדיפות 103), לא ברמת ה-postmeta. גם אם `ea-w2-07-qr-seed-once.php` ירוץ שוב בעתיד (למשל reset ידני) ויכתוב מחדש `_wp_page_template=tpl-qr.php` — הניתוב של Chapters ימשיך לדרוס אותו נכון, כי הוא לא תלוי בערך הזה כלל.
4. **מכיוון שה-URL נגזר אך ורק מ-(1), ומעולם לא מ"מי מרנדר" — כתובת שנשארת עמוד אמיתי עם אותו post_name/post_parent ממשיכה לפענח לאותה כתובת בהצלחה, בלי שום תלות בשינוי ה-template.** זו לא תוצאה של בדיקה — זו תוצאה הכרחית של איך וורדפרס עצמו בנוי.
5. **גם תרחיש rollback חירום מכוסה אוטומטית:** אם `EA_CHAPTERS_FRONT` יוחזר ל-`false` (מנגנון ה-rollback הרשמי של האתר, LOD300 C-3) — `ea_chapters_template_include()` חוזר `$tpl` הגולמי מיד בשורה הראשונה (`if ( ! ea_chapters_enabled() ) return $tpl;`), ה-pattern-route **כלל לא נבדק**, ו-48 העמודים נופלים חזרה בדיוק לרינדור המקורי (`tpl-qr.php`, שנשאר בקוד בלי שינוי עד T6) — **אותה כתובת מדויקת, בלי redirect, בלי שינוי.**
6. **אפס redirect חדש נדרש ואפס נוצר.** אף slug לא זז, לא שונה, לא נמחק. `mu-plugins/ea-w209-legacy-301-redirects.php` (מנגנון ה-301/410 הפעיל של האתר) **לא נוגע כלל** במהלך הזה — אין לו אפילו שורה אחת חדשה להוסיף, כי אין כתובת שדורשת redirect.
7. **מה כן חייב להישאר בלתי-נוגע, בפירוש, כתנאי להבטחה:** (א) `mu-plugins/ea-w2-07-qr-seed-once.php` — לא נמחק/מבוטל (הוא הביטוח שהעמודים קיימים מלכתחילה, ואף מסוגל ל"תקן את עצמו" אם עמוד נמחק בטעות — idempotent); (ב) `mu-plugins/ea-w2-07-qr-content-data.php` — לא נערך (גם ה-hub grid ב-§4.2.1 רק *קורא* ממנו); (ג) הפוסטים עצמם ב-DB — לא נמחקים/משוכפלים/משונים בשום שלב של T5 או T6 (T6 מוחק **קבצי קוד** של Wave2, לא רשומות DB — ר' §4.5).

**שיטת אימות (נדרש לביצוע בפועל ע"י הבנאי, לפני ואחרי):**

- **רמת DB (ההוכחה החזקה ביותר — מוכיחה שהמנגנון לא נגע בנתונים, לא רק שהתוצאה נראית תקינה):**
  ```
  SELECT ID, post_name, post_parent, post_status
  FROM wp_posts
  WHERE post_type='page' AND (post_name='qr' OR post_parent = (SELECT ID FROM wp_posts WHERE post_name='qr' AND post_parent=0 LIMIT 1))
  ORDER BY post_name;
  ```
  להריץ **לפני** כל שינוי קוד ולשמור את הפלט (רשימת 49 (או כמה שבאמת קיימים) שורות: ID/post_name/post_parent/post_status). להריץ **שוב אחרי** הפריסה. **הפלטים חייבים להיות זהים ל-100%, שורה-שורה.** (הערה: המספר בפועל עשוי להיות ≤48 — התוכן מגדיר בדיוק 48 מפתחות, אבל ייתכן שלא כולם פורסמו/קיימים בפועל בסביבה נתונה; לא להניח 48, **לספור בפועל**.)
- **רמת HTTP (ההוכחה התפקודית — מה שמשתמש-קצה חווה בפועל):** לפני כל שינוי קוד, לאסוף baseline מלא: לכל כתובת `/qr/` + `/qr/qrN/` הקיימת בפועל — `HTTP status` (ציפייה: 200), וכן snapshot של התוכן המהותי (כותרת + טקסט הגוף בפועל — לא ה-HTML הקוסמטי סביבו, שאמור להשתנות בכוונה) — למשל hash של הפלט של `get_the_title()`+`the_content()` הגולמי, או פשוט diff טקסטואלי של תוכן ה-`<main>`. אחרי הפריסה: לחזור על אותה איסוף, מול **אותה רשימת כתובות בדיוק**. שני קריטריונים: (א) **אף כתובת לא נעלמה מהרשימה ואף אחת לא נוספה** (b) **סטטוס 200 בכולן**, (ג) **התוכן המהותי (כותרת+גוף, כולל תגיות `<iframe>`/`<img>` המוטמעות) זהה** — שינוי בעיצוב-הסביבה (nav/footer/טיפוגרפיה) **צפוי ותקין**, שינוי בטקסט/כותרת/קישורים/מדיה בגוף **הוא regression**. הכלי המומלץ: `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` (הכלי הייעודי הקיים לפרויקט, ר' CLAUDE.md — **לא curl בלבד**, כי בדיקת layout/responsive של ה-iframe/img הרספונסיבי מ-§4.2.2 סעיף 5 דורשת רינדור אמיתי, לא רק HTML גולמי).

### 4.4 תאימות למנגנון ה-rollback הקיים (C-3)

LOD300 C-3 מזהיר ש-`tpl-home.php` הוא מנגנון ה-rollback הרשמי של האתר (`EA_CHAPTERS_FRONT` flag) ושמחיקתו בלי תחליף מסירה רשת ביטחון תפעולית. **העיצוב כאן לא רק "לא פוגע" ברשת הזו — הוא נבנה *בתוך* אותו gate בדיוק** (`ea_chapters_enabled()` בשורה הראשונה של `ea_chapters_template_include()`, ר' §4.2.2 סעיף 2). המשמעות: `/shop` ו-`/qr` **מקבלים את יכולת ה-rollback החירומית באופן אוטומטי, בלי קוד נוסף**, פשוט כי הם ממוקמים בתוך אותה פונקציית filter קיימת. שום מנגנון rollback נפרד לא נדרש עבור T5 — הוא כבר קיים ומכסה את זה מרגע שהקוד נכנס לאותה פונקציה.

### 4.5 מה בכלל **לא** נוגעים בו (רשימה מפורשת)

- `mu-plugins/ea-w2-07-qr-content-data.php` — קריאה בלבד (ע"י ה-hub grid, §4.2.1), אפס עריכה.
- `mu-plugins/ea-w2-07-qr-seed-once.php` — נשאר בדיוק כפי שהוא; ממשיך להיות רשת-הביטחון שמבטיחה שהעמודים קיימים.
- כל רשומת `wp_posts`/`wp_postmeta` של 49 עמודי ה-QR — כולל `_wp_page_template` הקיים עליהם (`page-templates/tpl-qr.php`) — לא משתנה.
- `mu-plugins/ea-w209-legacy-301-redirects.php` — אפס שורות חדשות.
- `inc/wave2-w2-07.php` — לא נערך ב-T5 (הפונקציות הקוסמטיות שלו, `ea_w2_07_body_class`/`ea_w2_07_assets` וכו', **ימשיכו לרוץ** גם אחרי הפריסה — כי `ea_w2_07_is_qr()` מזהה לפי `post_parent`/slug, בלי קשר לאיזה template בסוף ניצח. זה **לא** רגרסיה חדשה: זו בדיוק אותה תופעה שכבר קיימת היום, בלי שנגעו בה, עבור 5 עמודי המוצר מאז שהם עברו ל-Chapters (LOD300 C-1) — `w2-07-heritage.css`/`w2-05` המקבילים ימשיכו להיטען וקלאסים קוסמטיים ימשיכו להתווסף ל-`body`, בלי השפעה נראית-לעין כי אין להם מה "לתפוס" ב-markup החדש. הניקוי המלא (הסרת הקבצים/ה-hooks עצמם) הוא באחריות T6 במפורש — לא כאן.

---

## 5. רצף בנייה שלב-אחר-שלב

**חסימות תלות:** שלבי T5 (5.1–5.2) אינם תלויים ב-T2/T3/T3b וניתנים לביצוע/בדיקה באופן עצמאי ומיידי. שלבי T4 (5.3) **חסומים** עד ש-T2 וT3b ינעלו את הצורה הסופית של הנתונים שלהם (LOD300 §2 T4, "תלות").

### 5.1 — T5 /shop (יכול לרוץ מיידית, עצמאי)
1. להוסיף שורת `'shop'` ל-`ea_chapters_route_map()` (`inc/chapters/chapters-render.php`).
2. ליצור `inc/chapters/defaults/shop-defaults.php` (§3.2).
3. QA חזותי: `/shop/` מציג רשת של 5 כרטיסים תקינה, לוחצים לכל אחד מ-5 עמודי המוצר, מחיר מציג נכון (בין אם ריק ("מחיר לפי התאמה") ובין אם T3 כבר הזין ערך עד לשלב הזה).
4. אין שינוי תשתית — אין שלב "רק אחרי X".

### 5.2 — T5 /qr (יכול לרוץ מיידית, עצמאי, אך פנימית מסודר)
1. **Baseline קודם לכל שינוי קוד** (§4.3): להריץ ולשמור SELECT ה-DB + סריקת HTTP/תוכן על כל כתובות ה-`/qr/*` הקיימות בפועל בסביבת staging.
2. להוסיף `.ea-qr-img`/`.ea-qr-embed--video`/`.ea-qr-embed--video iframe` אל `assets/css/chapters.css` (§4.2.2 סעיף 5) — שלב עצמאי, אפס תלות בשאר.
3. להוסיף `ea_chapters_pattern_routes()` ולהרחיב `ea_chapters_is_view()` ב-`inc/chapters/chapters-render.php` (§4.2.2 סעיף 1).
4. להרחיב `ea_chapters_template_include()` ב-`inc/chapters/chapters-routing.php` עם ענף ה-pattern-route (§4.2.2 סעיף 2).
5. ליצור `page-templates/tpl-chapters-qr.php` (§4.2.2 סעיף 3).
6. ליצור `inc/chapters/defaults/qr-defaults.php` (§4.2.2 סעיף 4).
7. QA על **כתובת אחת בודדת** קודם (למשל `/qr/qr2/`, שכולל iframe מוטבע — ר' התוכן שנקרא ב-§4.2.2) — לוודא רינדור תקין, iframe רספונסיבי, כותרת נכונה, קישור "כל דפי ה-QR" עובד — לפני שממשיכים.
8. להוסיף שורת `'qr'` ל-`ea_chapters_route_map()` + ליצור `inc/chapters/defaults/qr-hub-defaults.php` (§4.2.1) — ה-hub.
9. QA מלא: לעבור על **כל** כתובות ה-`/qr/qrN/` הקיימות (לא מדגם) + `/qr/` עצמו.
10. **אימות שימור-URL** (§4.3): לחזור על ה-SELECT + סריקת ה-HTTP/תוכן מ-שלב 1, ולוודא זהות מלאה (DB) + 200+תוכן-זהה בכולן (HTTP).
11. QA rollback: להפעיל זמנית `EA_CHAPTERS_FRONT=false` (או filter מקביל) בסביבת staging, לוודא ש-`/qr/qrN/` נופל חזרה לרינדור Wave2 המקורי בהצלחה, ואז להחזיר ל-true.

### 5.3 — T4 schema (חסום עד T2 + T3b, לבנות רק אחרי)
1. לוודא ש-T2 חושף accessor טהור למאגר ה-FAQ המסונן (§2.2, "חוזה") ו-T3b חושף שמות שדה עקביים דרך `ea_chapters_field()`/`ea_chapters_defaults()` לכל ספר (§2.3, "חוזה").
2. להוסיף `ea_w2_seo_schema_faqpage_node()` + לוגיקת הטריגר ל-`mu-plugins/ea-w2-seo-schema.php` (§2.2) — למפות את מיפוי הסלאג→קטגוריה/ות **בפועל** לפי מה שT2 בפועל קבע (כולל הכרעת T2 לגבי 3 עמודי הספר ו-lessons/method, ר' §2.2).
3. להוסיף `ea_w2_seo_schema_book_node()` + לוגיקת הטריגר (§2.3) — למפות שמות שדה בפועל לפי מה שT3b בפועל קבע.
4. אימות פורמלי: להריץ כל אחד מ-11 (או פחות, תלוי בהכרעת T2 ל-lessons/method) עמודי FAQ + 3 עמודי הספר דרך [Google Rich Results Test](https://search.google.com/test/rich-results) (או Schema.org Validator כחלופה לא-תלויה בגוגל) — אפס שגיאות/אזהרות חוסמות.
5. לוודא ש-Product/Service/Person הקיימים (הבלוקים שכבר יש בקובץ) ממשיכים לפעול ללא שינוי — regression check על ה-`@graph` הקיים.

---

## 6. קריטריוני קבלה נבדקים

### T5 — /shop
- **AC-SHOP-01:** `/shop/` מרונדר ע"י `tpl-chapters-page.php` (לא `tpl-shop-archive.php`) — לאמת דרך `body_class()` (`ea-chapters` קיים) או inspect ישיר.
- **AC-SHOP-02:** רשת של בדיוק 5 כרטיסים, כל אחד מקשר לכתובת המוצר הנכונה (`/didgeridoos/`, `/bags/`, `/stands-storage/`, `/stand-floor/`, `/repair/`).
- **AC-SHOP-03:** מחיר מוצג נכון per-product — אם `ea_product_price` ריק, מציג "מחיר לפי התאמה"; אם מלא (בעקבות T3), מציג את הערך + "₪".
- **AC-SHOP-04:** אפס תלות-קוד חדשה של `inc/chapters/*` בפונקציות מ-`inc/wave2-w2-05.php` (בדיקה: `grep` על `shop-defaults.php` לא מוצא קריאה לאף `ea_w2_05_*`).

### T5 — /qr (הקריטי ביותר)
- **AC-QR-01 (שימור URL — DB):** SELECT ה-DB מ-§4.3 מניב תוצאה **זהה, שורה-שורה**, לפני ואחרי הפריסה — אותו מספר עמודים, אותם `ID`/`post_name`/`post_parent`/`post_status`.
- **AC-QR-02 (שימור URL — HTTP, 100%):** לכל כתובת `/qr/qrN/` שהחזירה 200 **לפני** השינוי — מחזירה 200 **אחרי** השינוי, ללא יוצא מן הכלל. אפס 404, אפס 500, אפס redirect לא-מכוון.
- **AC-QR-03 (נאמנות תוכן):** לכל כתובת — כותרת (`get_the_title()`) וטקסט-הגוף המהותי (כולל כל קישור/iframe/img שהיה מוטמע) זהים לפני/אחרי; רק ה"מעטפת" (nav/footer/טיפוגרפיה/CSS) מותר שתשתנה.
- **AC-QR-04 (רספונסיביות מדיה):** לפחות דף QR אחד עם iframe מוטבע (למשל `qr2`) ולפחות דף אחד עם `<img class="ea-qr-img">` נבדקים חזותית ברוחב מובייל (375px) — בלי overflow אופקי, בלי iframe שחורג מרוחב ה-container. (משתמשים ב-`qa_probe.mjs`, לא curl בלבד — ר' CLAUDE.md.)
- **AC-QR-05 (חזרה מ-rollback):** עם `EA_CHAPTERS_FRONT=false`, כל 48 הכתובות ממשיכות להחזיר 200 (רינדור Wave2 המקורי, `tpl-qr.php`) — ללא שינוי כתובת.
- **AC-QR-06 (hub):** `/qr/` מציג רשת קישורים לכל העמודים הקיימים בפועל (לא רק 48 בהנחה — הספירה בפועל), ממוינת מספרית (qr1, qr2, ... qr10, לא qr1,qr10,qr2...).
- **AC-QR-07 (אפס שינוי בקבצי redirect/seed):** `git diff` על `mu-plugins/ea-w209-legacy-301-redirects.php` ריק; `git diff` על `mu-plugins/ea-w2-07-qr-content-data.php` ו-`mu-plugins/ea-w2-07-qr-seed-once.php` ריק.
- **AC-QR-08 (Chapters CSS מלא):** בדיקה חזותית שאין כלל CSS "שבור"/חסר — במיוחד אזורי iframe/img בגוף (ר' AC-QR-04).

### T4 — FAQPage
- **AC-FAQ-01:** בכל עמוד עם FAQPage node — `mainEntity` מכיל **בדיוק** את השאלות המוצגות חזותית בעמוד (לא פחות, לא יותר) — נבדק ידנית מול תצוגת ה-accordion.
- **AC-FAQ-02:** Google Rich Results Test (או Schema.org Validator) — 0 שגיאות על כל עמוד שנבדק.
- **AC-FAQ-03:** שאלה שמתויגת ביותר מקטגוריה אחת (many-to-many, T2) מופיעה כראוי בכל עמוד רלוונטי שבו היא מוצגת בפועל — לא רק בעמוד "הראשי" שלה.
- **AC-FAQ-04:** עמוד ללא תוכן FAQ גלוי (למשל `lessons`/`method` אם T2 לא נותן להם FAQ מובנה) — **לא** מקבל צומת FAQPage כלל (לא צומת ריק).

### T4 — Book
- **AC-BOOK-01:** לכל אחד מ-3 עמודי הספרים — צומת `Book` יחיד עם `@id` ייחודי, `author` מפנה ל-`@id` הקיים של Person (לא Person כפול).
- **AC-BOOK-02:** `isbn` מושמט (לא `""`/`null`) כשאין נתון מקור — לא ערך מזויף.
- **AC-BOOK-03:** `datePublished`/`numberOfPages`/`price` תואמים בדיוק למה שT3b בפועל מציג בעמוד (לא ערך שונה/היסטורי).
- **AC-BOOK-04:** Google Rich Results Test / Schema.org Validator — 0 שגיאות.

---

## 7. Edge cases / סיכונים

1. **מספר עמודי QR בפועל ≠ 48 בהכרח.** קובץ הנתונים מגדיר בדיוק 48 מפתחות, אבל ה-seed הוא idempotent ולא כופה שכולם פורסמו/נשארו `publish` — **הבנאי חייב לספור בפועל** (AC-QR-06/§4.3), לא להניח.
2. **תלות ב-`chapters.css` שלא נבדקה מול real device Safari/iOS RTL** — הוספת CSS ל-iframe/img (§4.2.2 סעיף 5) היא verbatim מקובץ קיים ופעיל, אבל שילוב עם `.intro-body`'s existing typography (`chapters.css`) לא נבדק חזותית עד לביצוע בפועל — QA חובה, לא ניתן להניח תקינות מקוד בלבד.
3. **ה-hub `/qr/` כרגע ריק לגמרי — בניית רשת חדשה (§4.2.1) חורגת מ"פורט טהור" אל "שיפור תוכן".** מתועד כהחלטה מפורשת עם אלטרנטיבה שמרנית (עמוד ריק) — team_100/team_110 צריכים לאשר את הכיוון (מומלץ: לבנות את הרשת) לפני ביצוע, לא רק "לגלות" את זה ב-QA.
4. **וידאו YouTube בתוך גוף QR (60 הטמעות) תלוי בזמינות YouTube בזמן טעינה** — לא סיכון חדש (קיים גם היום ב-`tpl-qr.php`), אבל שווה לציין שהוא נשאר קיים גם אחרי הפורט (לא מוחלף ב-self-hosted video block כמו ב-T1 — QR לא בטווח T1).
5. **תמונות QR (`/wp-content/uploads/ea-legacy/qr/...`) הן קישורים ישירים למערכת קבצים, לא attachments במדיה-ליברי של WP** — לא בטווח T5 לתקן, אבל אם קובץ פיזי חסר בשרת, ה-`<img>` ישבר בלי קשר לפורט (לא regression חדש, קיים כבר).
6. **T4 חסום על 2 תלויות במקביל (T2 + T3b) — לא אחת.** אם אחת מהן מתעכבת, T4 לא יכול "להתחיל חלקית" בצורה משמעותית (אין טעם לממש FAQPage בלי Book, כי שניהם תלויים באותה נקודת-הרחבה בקובץ; אפשר טכנית לפצל ל-2 commits נפרדים אם רק אחת מהתלויות מוכנה קודם — לא נדרש לחכות לשתיהן יחד אם הבנאי מעדיף לפצל).
7. **הממצא החדש בסעיף 2.2 (3 עמודי הספר לא ממופים לאף קטגוריית-FAQ מרכזית קיימת) הוא תוספת-scope קטנה ל-T2 שהתגלתה כאן, לא ב-LOD300 עצמו.** שווה לוודא שT2 מודע לזה לפני שהוא נועל LOD400 משלו — אחרת T4 ייתקע בדיוק בנקודה הזו.
8. **Cache/CDN:** אם קיים page cache בפרודקשן (לא אומת ב-repo זה), כל פריסה של T5 (וT4) דורשת flush מפורש — לא ספציפי ל-T5/qr, אך רלוונטי לרצף הבנייה בפועל.
9. **`bookcard.php` בשימוש-חוזר לשלושה הקשרים שונים (ספרים/shop/qr-hub) — אם עתידית מישהו "משפר" את `bookcard.php` בהקשר הספרים בלבד (למשל T3b), לוודא שהשינוי לא שובר את השימוש ב-/shop וב-/qr.** לא סיכון מיידי, אבל שווה comment בקוד (`bookcard.php`) שמזכיר את 3 הצרכנים.

---

*נכתב ע"י team_100 (agent sub-session) · 2026-07-14 · פריטת LOD400 ל-T4+T5 בלבד, בהמשך ל-`WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md`. כל ממצאי הקוד במסמך זה אומתו ישירות מול הריפו (grep/read מלאים על הקבצים המצוינים) בסשן זה — לא הועתקו מה-LOD300 בלי בדיקה חוזרת.*

---

# LOD400 — WP-CANON: T6 (מחיקת Wave2) + T7 (QA מלא)

## 0. מטרת המסמך, היקף, ומתודולוגיה

מסמך זה הוא פריטת LOD400 (רמת ביצוע מלאה) של T6 ו-T7 בלבד מתוך WP-CANON-TEMPLATE-UNIFICATION, בהמשך ישיר ל-LOD300 (`WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md`). לפי הנחיית team_00, זהו "שלב 2" שמתחיל רק לאחר אישור מפורש נפרד את תחילתו — מסמך זה מוכן להצגה לאישור זה, אך **אינו** אישור-בפועל לביצוע.

**לפני הכתיבה, בוצע מחקר-קוד חי מלא** על כל 11 קבצי ה-template, 12 קבצי ה-`inc/wave2-w2-*.php`, ו-`inc/wave2-stage-b.php` שמפורטים במשימה — כולל grep מדויק לשם-קובץ **וגם** grep לטוקן-בסיס (בלי `.php`) כדי לתפוס הפניות דינמיות (`locate_template('page-templates/' . $var . '.php')`), קריאה מלאה של כל שרשרת ה-`template_include` (13 רישומים, עדיפויות 90–105), ובדיקות חיות (curl) מול ה-staging (`https://eyalamit-co-il-2026.s887.upress.link`). המסקנה: **נספח הראיות של LOD300 §7 T6 נכון ברובו, אך לא שלם** — נמצאו 9 ממצאים (D-1 עד D-9, §2 למטה) שמתקנים או מרחיבים אותו באופן שמשנה בפועל את סדר/היקף המחיקה. ההמלצות בסעיפים 3–8 בנויות על הממצאים המתוקנים, לא על הנספח המקורי כלשונו.

---

## 1. מטרות

**T6:** למחוק את כל קוד ה-Wave2 שהפך לכפול/מת בפועל לאחר שהניתוב של Chapters ניצח אותו — **רק** לאחר שהתלויות (T1–T5, T3b) נבנו ואומתו, **רק** לפי סדר שמבודד תחילה כל קובץ שממלא תפקיד שאינו "ניתוב תבנית גרידא" (rollback, SEO ראש-האתר, redirects, תוכן משותף), ו**בלי** לאבד אף יכולת חיה (rollback, redirect, SEO) שאין לה עדיין מחליף ב-Chapters.

**T7:** לאמת שהאיחוד לא שבר דבר — קישורים, עקביות ויזואלית, `target="_blank"` אחיד, ממשקי-העריכה של אייל, ואפס סטיית-תוכן (`content-diff.mjs`) — על כל משטח חדש שנוצר ב-T1/T2/T3/T3b/T5 ספציפית, לפני שה-WP נסגר.

---

## 2. ממצאי אימות — תיקונים ותוספות ל-§7 (LOD300)

| # | ממצא | מקור בקוד | משמעות ל-T6 |
|---|---|---|---|
| **D-1** | "12 קבצי `wave2-w2-*.php`" בפועל **13** — `inc/wave2-w2-04-content.php` (114KB, **הגדול ביותר מכל קובצי ה-Wave2**) חסר גם מרשימת המשימה וגם מ-LOD300 §7 T6 (שממנה גם היא, כנראה בטעות — מונה "12" אך שמות רק 11). נדרש `require_once` ע"י `wave2-w2-04.php:20`, בדיוק כמו `w2-03-content`/`w2-05-content`. | `inc/wave2-w2-04.php:20` | להוסיף לרשימת המחיקה, יחד עם `wave2-w2-04.php` (§3.6). |
| **D-2** | `wave2-stage-b.php` הוא **לא** רק "לוגיקת asset-enqueue שמתייחסת למספר מהקבצים" (כפי שתואר במשימה) — הוא (א) מנוע-הרינדור/התוכן המלא של דף-הבית הלגאסי (`ea_wave2_render_home_blocks`, `ea_wave2_set_home_block_context` — 12 בלוקים, טקסט עברי מלא), **וגם** (ב) תשתית אסטים משותפת שדפי **Chapters עצמם תלויים בה היום בפועל**. `chapters-routing.php:47-51` מסמן כל תצוגת Chapters כ-`ea_wave2_shell=true` בכוונה ("since they are force-routed without template meta"), מה שגורם ל-`ea_wave2_is_active_view()` (stage-b) להחזיר `true` גם על עמודי Chapters — ומכאן ש-`ea_wave2_enqueue_assets()`, `ea_wave2_dequeue_unused_styles()`, `ea_wave2_disable_emojis()`, `ea_wave2_body_class()`, `ea_wave2_body_open_extras()` (skip-link + scroll-progress) פועלים גם על Chapters. **אומת חי (14/7):** `/treatment/` (עמוד Chapters היום) טוען בו-זמנית `chapters.css` **וגם** `ea-tokens.css`/`ea-atoms.css`/`ea-animations.css`; `/shop/` (Wave2 היום) טוען רק את השלישייה האחרונה, ללא `chapters.css`. | `inc/chapters/chapters-routing.php:44-51`; `inc/wave2-stage-b.php:55-75,80-140`; curl חי | `wave2-stage-b.php` לא ניתן למחיקה כלל עד שמישהו קובע במפורש אילו מהפלטים שלו Chapters עדיין צריכה, ומעביר אותם למקום Chapters-native. ר' §3.2. |
| **D-3** | `ea_wave2_is_active_view()` (stage-b, שורות 56-71) מכיל רשימה קשיחה של **14** קבצי template — 7 מתוכם (`tpl-stage-b-test.php`, `tpl-content.php`, `tpl-books.php`, `tpl-qr.php`, `tpl-blog-archive.php`, `tpl-blog-single.php`, `tpl-en-landing.php`) **מחוץ** ל-11 הקבצים שב-scope של T6 (וגם מחוץ ל-LOD300 §7). כל עוד קבצים אלה חיים, `wave2-stage-b.php` לא יכול להימחק — גם לאחר שכל 11+13 קבצי ה-scope נעלמים. | `inc/wave2-stage-b.php:56-71` | סעיף 3.7 להלן. |
| **D-4** | `tpl-qr.php` הוא Wave2 **חי בפועל** (משרת עד 48 עמודי-בת `/qr/qrN/`) — לא דרך ניתוב-קוד, אלא דרך שיוך-תבנית ברמת ה-DB (`_wp_page_template` postmeta; `wave2-w2-07.php:36-48` רק מסמן shell, לא מנתב). **אינו** ברשימת ה-11 קבצים של T6, למרות ש-LOD300 T5 קובע יעד מפורש "אפס Wave2" ל-`/qr`. פער-scope אמיתי בין T5 ל-T6. | `inc/wave2-w2-07.php:9-14,36-48`; `inc/wave2-stage-b.php:67` | סעיף 3.7. |
| **D-5** | `template-book-detail.php` (**לא** `tpl-book-detail.php`!) הוא שכבה שלישית, עוד יותר ישנה — התיעוד בקוד מכנה אותה במפורש **"Wave1"** — עם ניתוב עצמאי (`functions.php` עדיפות 94) ל-slugs ישנים (`tsva-bechol-ve-zorek-layam`, `vekatavt`) ששונים מה-slugs החיים היום (`tsva-bekahol`, `vekatavta`). מחוץ ל-scope של 11 הקבצים; קיים סיכוי סביר שהיא כבר יתומה לחלוטין (אין page עם ה-slug הישן), אך זה עובדה ברמת ה-DB שלא ניתנת לאימות מסטטי-קוד בלבד. | `functions.php:507-521,539-554,656-663` | סעיף 3.7 + נדרשת בדיקת DB/wp-admin ישירה (§4). |
| **D-6** | **`wave2-w2-09.php` איננו ראוטר-תבנית בכלל** — בניגוד לכל 11 "אחיו" במשימה. הקובץ מספק שתי פונקציות **חיות, כלל-אתריות**: (א) fallback ל-`<meta name="description">` לכל route שיואסט (Yoast) לא מכסה — **כולל ענף ייעודי לעמודי Chapters** (`ea_chapters_defaults()['phero']['sub']`, שורות 112-120 — כלומר הקובץ *כבר עודכן* להכיר את Chapters!) ולעמוד `/en`; (ב) `<link rel="icon">` ל**כל האתר** (מתקן 404 של `/favicon.ico`, שנבדק ב-Lighthouse). מחיקתו תסיר את הפאביקון מכל האתר (כולל עמודי Chapters) ותשבור את ה-fallback של תיאור-מטא. | `inc/wave2-w2-09.php:63-191` (כל הקובץ) | **לא נמחק** — מועבר/משוכתב-שם. ר' §3.3. |
| **D-7** | `wave2-w2-02.php` נושא לוגיקת **301 redirect חיה** (`ea_w2_02_legacy_redirects`, עדיפות 2) עבור `/אייל-עמית-אודות/`, `/about/`, `/about/moksha/`, `/mokesh-dahiman/`, `/mokesh/` → `/eyal-amit/` או `/eyal-amit/mokesh-dahiman/`. קיים מנגנון redirect **נפרד ומקביל**, `mu-plugins/ea-w209-legacy-301-redirects.php` (עדיפות 0, GENERATED מ-135 החלטות redirect) — אך **אינו** כולל את חמשת אלה (יש חפיפה חלקית ומטעה: `/אייל-עמית-אודות/` מופיע בשני הקבצים עם **יעדים שונים** — w209 שולח ל-`/about/`, w2-02 שולח ל-`/eyal-amit/`; מכיוון ש-w209 רץ קודם ו-`exit`, כרגע יש שרשרת דו-קפיצתית בפועל, לא קפיצה-אחת כפי שההערה ב-w2-02 טוענת). מחיקת `wave2-w2-02.php` בלי להעביר קודם את 5 חוקי ה-redirect שלו למנגנון הקבוע — **תשבור בפועל** URLs שסביר שגוגל כבר אינדקס. | `inc/wave2-w2-02.php:163-199`; `mu-plugins/ea-w209-legacy-301-redirects.php:38-67` | חובה: להעתיק/למזג את 5 חוקי ה-redirect אל `ea-w209-legacy-301-redirects.php` (או מנגנון-redirect קבוע מקביל) **לפני** מחיקת `wave2-w2-02.php`. עקרון זה כללי — ר' §3.1. |
| **D-8** | לפחות שני קבצים נוספים מתוך 12 ה-inc נושאים לוגיקה לא-ניתובית שממשיכה לפעול **גם אחרי** שהניתוב שלהם מוצל: `wave2-w2-06.php` — פילטרים על `the_author`/`get_the_author_display_name` שכופים "אייל עמית" כשם הכותב על **כל** פוסט (`is_singular('post')`, בלי תלות בתבנית שרינדרה) — עדיין רלוונטי כי `/blog/` כבר מוצל ע"י Chapters (`chapters-routing.php:92`, עדיפות 105 > 100) אבל הפילטר הזה ממשיך לפעול על הפלט של Chapters. `wave2-w2-08.php` — hreflang (`wp_head`, עדיפות 5) לעמוד `/en` — גם הוא כבר מוצל ע"י Chapters (`en` קיים ב-route map, עדיפות 103) אך ה-hook ממשיך להיות רלוונטי בפועל. | `inc/wave2-w2-06.php:108-119`; `inc/wave2-w2-08.php:159` | **עיקרון מנחה כללי ל-T6** (לא רק לשני אלה): נתק ניתוב-תבנית ≠ קובץ מת. יש לבדוק **כל hook בנפרד**, לא רק `template_include`. ר' §3.0. |
| **D-9** | `wave2-w2-07.php` מכיל שני משטחים בלתי-תלויים: `/qr` (בטיפול T5, ר' D-4) **ו-`/press`** — `/press` **אינו** ב-route map של Chapters (`chapters-render.php:32-58`, נבדק ואין ערך `press`) **ואינו** מוזכר באף אחת מ-T1–T7. פער-בעלות אמיתי, לא רק שרידי-קוד. | `inc/wave2-w2-07.php:18-29,65-74`; `inc/chapters/chapters-render.php:32-58` | ר' §3.7 + §8 (החלטה נדרשת). |

**מסקנת §2:** נספח הראיות של LOD300 §7 T6 עדיין נכון לגבי הטענה המרכזית — 10 מתוך 11 קבצי ה-template כבר מוצלים היום, קובץ אחד (`tpl-shop-archive.php`) עדיין חי (מ`/shop`), ו-`tpl-home.php` הוא ה-rollback. אבל הוא **לא שלם**: ה"עוד 12 קבצי inc" אינם קבוצה הומוגנית של "עוד ניתוב מת" — לפחות שלושה מהם (`w2-02`, `w2-06`, `w2-09`) נושאים פונקציונליות חיה ולא-ניתובית, ו-`stage-b` הוא תלות משותפת עם Chapters, לא רק עם `tpl-home.php`.

---

## 3. T6 — סדר המחיקה המדויק

### 3.0 עיקרון מנחה (חל על כל השלבים למטה)

לכל קובץ: **אל תשאל "האם ה-template_include שלו מוצל?" — שאל "מה כל hook רשום בקובץ הזה עושה, ואיזה מהם ממשיך לפעול גם כשה-template המוצל לא מרונדר?"** (D-6, D-7, D-8 מוכיחים שזה לא תיאורטי). לכל קובץ ב-§3.6 יש טור "hooks לא-ניתוביים לבדוק" — זו לא הערת שוליים, זו שאלת חסימה.

### 3.1 שער כניסה — תנאי-סף לפני **כל** מחיקה בתהליך הזה

1. T1, T2, T3, T3b, T5 בנויים, ועברו את ה-Validator שלהם (team_90 + team_190, cross-engine מול team_110 — לפי Iron Rule #1) — **לא** רק "built", אלא PASS מתועד.
2. T7 §5 רץ פעם ראשונה על המצב **שלפני** מחיקה כלשהי (baseline — כדי שסטייה שתתגלה אחרי מחיקה תיוחס נכון למחיקה, לא ל-T1–T5).
3. ההחלטה על tpl-home.php/stage-b (§3.2) ננעלה בחתימת team_00.
4. ההחלטה על wave2-w2-09.php (§3.3) בוצעה (זו לא שאלה פתוחה — זו עבודת-בנייה קטנה שחייבת לקרות, לא להתקבל כהחלטה).

### 3.2 המקרה המיוחד: `tpl-home.php` + `wave2-stage-b.php` (מנגנון ה-rollback)

**שרשרת האמת שאומתה בקוד (לא רק ההערה בקוד — נבדקה שרשרת ה-priority בפועל):** בדף הבית, `ea_eyalamit_home_dashboard_template` (עדיפות 99, `functions.php:211-224`) קובע `template-home-dashboard.php`, ואז `ea_w2_02_template_include` (עדיפות 100, `wave2-w2-02.php:44-51`) **דורס אותו ללא-תנאי** ל-`tpl-home.php`, ואז `ea_chapters_template_include` (עדיפות 103) דורס שוב ל-`tpl-chapters-home.php` **רק אם** `ea_chapters_enabled()`. כשה-flag `EA_CHAPTERS_FRONT` מוגדר `false`, עדיפות 103 מחזירה את ה-`$tpl` כפי שקיבלה — כלומר `tpl-home.php`. **המסקנה: `tpl-home.php` אכן ה-rollback האמיתי של דף-הבית — הטענה ב-LOD300 C-3 מאומתת ומדויקת.** (אגב-ממצא: `template-home-dashboard.php` — קובץ #11 ברשימת המשימה — כבר מת היום גם ללא Chapters, כי עדיפות 100 תמיד דורסת את עדיפות 99 בדף הבית; אין לו תפקיד ב-rollback ומתאים לקבוצה A הרגילה, §3.4).

אבל ה-rollback לא "רק tpl-home.php" — `tpl-home.php` הוא **shell בן 12 שורות** שקורא ל-`ea_wave2_render_home_blocks()`, המוגדרת **בתוך** `wave2-stage-b.php:339` יחד עם כל תוכן-הבלוקים העברי (`ea_wave2_set_home_block_context()`, 12 בלוקים). כלומר: אי-אפשר "לשמור את tpl-home.php ולמחוק את stage-b" — הם יחידה אחת מבחינת ה-rollback. ובכיוון ההפוך: **stage-b לא ניתן למחיקה מהסיבה השנייה, הבלתי-תלויה-ב-rollback, שכבר תועדה ב-D-2: Chapters עצמה שואבת ממנו אסטים חיים היום.**

**שלוש אפשרויות שנשקלו:**

| אפשרות | עלות | סיכון |
|---|---|---|
| א. לבנות rollback מלא Chapters-native (12 בלוקים מחדש כתבנית קבועה) | גבוהה — שכפול-תוכן קבוע, בדיוק הבעיה ש-T6 בא לפתור | נמוך |
| ב. מחיקה מלאה + חתימת accepted-risk | ~אפס | גבוה — אתר production חי, אפס רשת-ביטחון ברמת קוד |
| **ג. "הקפאה ובידוד" (המלצתי)** | נמוכה | נמוך, בתנאי שהבידוד (ר' למטה) בוצע קודם |

**המלצה (ג), עם נימוק:** לשמר את `tpl-home.php` + **רק** את פונקציות-התוכן/רינדור של stage-b (`ea_wave2_render_home_blocks`, `ea_wave2_set_home_block_context`, `ea_wave2_home_block_slugs`, `ea_wave2_wa_url` והבלוקים ב-`template-parts/blocks/block-*.php` שהן קוראות להם) — **כארטיפקט קפוא, מסומן במפורש כ"חירום-בלבד, לא מקור-אמת לתוכן חי"**, מועבר לתיקייה/שם שלא מתנגש עם "מחיקת Wave2" הכוללת (למשל `inc/emergency-rollback-home.php`). זול לתחזק (קפוא = לא נערך יותר), ומספק רשת-ביטחון אמיתית על אתר production חי — בלי לשעתק תוכן שיצטרך תחזוקה כפולה קדימה. **תנאי-קדם הכרחי לפני שזה תקף בכלל:** יש לבודד קודם את Chapters מ-`ea_wave2_shell`/`ea_wave2_is_active_view()` (D-2) — כלומר להעביר ל-`chapters-enqueue.php` כל מה ש-Chapters בפועל עדיין צריכה מ-stage-b (ככל הנראה: כלום מבחינת CSS — `chapters.css` לא מפנה ל-`var(--ea-*)` בכלל ומגדיר `:root` משלו; ה-JS של Chapters (`ea-chapters.js`) כבר מיישם burger/mobile-nav עצמאי; אך **כפתור ה-WhatsApp הצף** (`ea_wave2_render_whatsapp_float`, `wp_footer` עדיפות 15, **ללא תנאי `is_active_view` כלל** — פועל אתר-רחב היום) חייב החלטת-מוצר מפורשת: להעביר ל-hook קבוע נפרד, לא תלוי ב-stage-b). לאחר הבידוד, חלק ה-**enqueue** של stage-b נמחק; חלק ה-**רינדור** קפוא ונשאר.

**דורש חתימת team_00 קצרה** (לא שאלה פתוחה מורכבת — אישור לכך ששני קבצים קפואים, בעלות-תחזוקה כמעט-אפס, נשארים כביטוח, במקום מחיקה מלאה או שחזור-מלא).

### 3.3 המקרה המיוחד: `wave2-w2-09.php` — **לא נמחק, מועבר**

לפי D-6: זהו קוד SEO/ראש-אתר חי וכלל-אתרי (favicon + meta-description fallback, כולל ענף ש**כבר** מכיר את Chapters). הפעולה הנדרשת: **rename + relocate**, לא מחיקה — למשל ל-`inc/seo-head-fallbacks.php` (שם שלא מרמז Wave2), תוך שמירת שתי הפונקציות כלשונן (`ea_w2_09_meta_description`, `ea_w2_09_favicon` + התלות ב-`ea_w2_08_is_en_page` — יש לבדוק את זה מול תוצאת §3.7 D-9: אם `wave2-w2-08.php` נשאר חי (בגלל `/en`), התלות תישאר תקינה; אם הוא נמחק, יש לגלגל את הבדיקה הזו פנימה). זו עבודת-בנייה קטנה, לא מחיקה — יש לבצע אותה **לפני** שמתייחסים ל-`wave2-w2-09.php` כאל "נמחק" בכל דיווח/checklist.

### 3.4 קבוצה A — תבניות עצמאיות, ללא תלות-חוזרת (9 קבצים)

כל הקבצים האלה מוצללים היום (§7 LOD300 + אימות D-לעיל), ואף קובץ אחר בריפו לא תלוי בהם חזרה (הם רק *נקראים*, לא *קוראים* לאחרים מחוץ ל-`get_header`/`get_footer`/`the_content`). בטוח למחוק אותם **תוך השארת ה-routers (12 קבצי ה-inc) פעילים** — כי כל router בודק `is_readable`/`$t truthy` לפני החזרה, ומחזיר `$tpl` ללא שינוי אם הקובץ נעלם; מכיוון שה-slug כבר ב-route map של Chapters (עדיפות 103 > 100), Chapters תמיד תתפוס את הבקשה בכל מקרה. סדר פנימי לא קריטי (אין תלות ביניהם) — מומלץ אלפביתי לפשטות מעקב:

1. `template-faq-catalog.php`
2. `template-home-dashboard.php` (מת גם ללא Chapters — ר' §3.2)
3. `template-method.php`
4. `template-treatment.php`
5. `tpl-book-detail.php`
6. `tpl-contact.php`
7. `tpl-faq.php`
8. `tpl-service.php`
9. `tpl-shop-item.php`

**אימות לפני המחיקה הזו:** §4, אצווה 1.

### 3.5 קבוצה B — תלוי-T5: `tpl-shop-archive.php`

הקובץ **היחיד מבין ה-11 שעדיין חי בפועל היום** (משרת `/shop`). מותנה **אך ורק** בסגירת T5 (מעבר `/shop` ל-Chapters). ברגע ש-T5 חי בפרודקשן/staging ואומת (כולל תוספת `/shop` ל-`content-diff.mjs` PAGE_MAP, ר' §5.6), הקובץ מצטרף לאותו טיפול כמו קבוצה A. **אל תמחק את הקובץ הזה כחלק מ"אצווה 1" גורפת** — יש למחוק אותו בנפרד, אחרי אימות ספציפי ש-T5 חי (§4 אצווה 2).

### 3.5.5 — תיקון (ולידציה חוצת-מנוע team_90, 14/7, F90-01 + F90-02): שחזור-מקום לפונקציות מסחר, לפני קבוצה C

**team_90 מצא, וזה תוקן כאן:** הטבלה ב-§3.6 (למטה) נוסחה במקור כ"מחק יחד" עבור `wave2-w2-05.php` ו-`wave2-w2-03.php`, בלי לשמר את הפונקציות שT3 וT3b **כבר הזהירו** במפורש שהן תלויות בהן (T3 §6 הערה 4; T3b §6 הערה 2). כפי שהיה מנוסח, מפתח שהיה מבצע את T6 כלשונו היה גורם ל-`Call to undefined function` על כל 5 עמודי המוצר (F90-01) ולאובדן-שקט של מעקב GA4 `book_purchase_click` על כל 3 עמודי הספרים (F90-02).

**התיקון:** קובץ חדש, `inc/chapters/chapters-commerce.php`, נוצר **לפני** שקבוצה C (§3.6) נוגעת ב-`wave2-w2-05.php`/`wave2-w2-03.php` — מכיל 4 פונקציות, מועברות **verbatim** (לא נכתבות מחדש), עם `require_once` חדש מ-`functions.php` (לצד ה-`require_once` הקיימים ל-Wave2, שיוסרו כשהקבצים המקוריים יימחקו):

```php
<?php
/**
 * Chapters-owned home for commerce accessors that must survive the Wave2 deletion (T6).
 * Relocated verbatim — WP-CANON-TEMPLATE-UNIFICATION T6, closing team_90 cross-engine
 * findings F90-01 (product pages) / F90-02 (book purchase GA4 tracking).
 * Consumers: template-parts/chapters/parts/product-cta.php (T3);
 *            phero.php/cta.php's cta_slug extension (T3b, via the script enqueued below).
 */
defined( 'ABSPATH' ) || exit;

// --- from inc/wave2-w2-05.php:234-265 (verbatim). function_exists() guards are NEW here
// (המקור אין לו) — הכרחי כי chapters-commerce.php ו-wave2-w2-05.php שניהם טעונים בו-זמנית
// בחלון-המעבר (הקובץ הזה נוצר "לפני" ש-§3.6 מוחקת את wave2-w2-05.php) — בלי guard, טעינה
// כפולה של שם-פונקציה זהה היא PHP fatal "Cannot redeclare function", לא רק כפילות תמימה. ---
if ( ! function_exists( 'ea_w2_05_gi_url_map' ) ) {
	function ea_w2_05_gi_url_map() {
		return array(
			'didgeridoos'    => '',
			'bags'           => '',
			'stands-storage' => '',
			'stand-floor'    => '',
			'repair'         => '',
		);
	}
}
if ( ! function_exists( 'ea_w2_05_gi_url' ) ) {
	function ea_w2_05_gi_url( $slug ) {
		$map = ea_w2_05_gi_url_map();
		return isset( $map[ $slug ] ) ? trim( (string) $map[ $slug ] ) : '';
	}
}
if ( ! function_exists( 'ea_w2_05_price' ) ) {
	function ea_w2_05_price( $post_id ) {
		$price = get_post_meta( $post_id, 'ea_product_price', true );
		$price = is_string( $price ) ? trim( $price ) : '';
		return '' !== $price ? $price : 'מחיר לפי התאמה';
	}
}

// --- from inc/wave2-stage-b.php:14,22-27 (genuinely verbatim — תוקן לפי delta-validation
// D90-01: הגרסה הקודמת כאן פישטה את ברירת-המחדל והקבוע, מה שהיה עלול לשנות התנהגות
// לקוראים-בלי-ארגומנט אחרים חוץ מ-product-cta.php, כמו כפתור ה-WhatsApp הצף) ---
if ( ! defined( 'EA_WAVE2_WHATSAPP_E164' ) ) {
	define( 'EA_WAVE2_WHATSAPP_E164', '972524822842' );
}
if ( ! function_exists( 'ea_wave2_wa_url' ) ) {
	function ea_wave2_wa_url( $msg = '' ) {
		$msg = ( '' !== $msg ) ? $msg : 'היי אייל, הגעתי דרך האתר ואשמח לקבל פרטים';
		return 'https://wa.me/' . EA_WAVE2_WHATSAPP_E164 . '?text=' . rawurlencode( $msg );
	}
}

// --- from inc/wave2-w2-03.php:166-178, re-gated (Chapters-native slug check —
// replaces the legacy ea_w2_03_is_wave2_page() parent/slug lookup with a flat
// list, since Chapters already knows exactly which 3 slugs are books) ---
function ea_chapters_book_purchase_assets() {
	if ( is_admin() ) {
		return;
	}
	if ( ! is_page( array( 'vekatavta', 'kushi-blantis', 'tsva-bekahol' ) ) ) {
		return;
	}
	wp_enqueue_script(
		'ea-book-purchase',
		get_stylesheet_directory_uri() . '/assets/js/ea-book-purchase.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_chapters_book_purchase_assets', 20 );
```

**חוזה ללא שינוי ב-T3/T3b:** `product-cta.php` (T3 §2.1) וההרחבות ל-`phero.php`/`cta.php` (T3b §3.0) **ממשיכים לקרוא לאותם שמות-פונקציה בדיוק** — אין לשנות אף שורת קוד בהם; הפונקציות פשוט מוגדרות עכשיו במקום אחר.

**קריטריון-קבלה חדש ל-T7** (נוסף גם ב-§5.4/§5.5 להלן): אחרי T6, לוודא בדפדפן ש-(א) כל 5 עמודי המוצר מציגים מחיר+CTA תקינים, אפס PHP fatal; (ב) לחיצה על כפתור רכישה בכל אחד מ-3 עמודי הספר עדיין יורה `book_purchase_click` ב-GA4 (network tab / dataLayer) — **לפני** ש-T6 נחשב סגור.

### 3.6 קבוצה C — קבצי `inc/wave2-w2-*.php` + תוכן (per-hook verification חובה, D-8/D-7/D-6)

| קובץ | מה עוד יש בו מעבר לניתוב-תבנית (D-8/D-7 style) | פעולה |
|---|---|---|
| `wave2-w2-02.php` | **301 redirects חיים** (D-7) — 5 חוקים, לא כפולים במקום אחר | **קודם**: להעתיק את 5 החוקים ל-`ea-w209-legacy-301-redirects.php` (או שווה-ערך קבוע). **אז** מחק. |
| `wave2-w2-03.php` + `wave2-w2-03-content.php` | ניתוב **וגם** enqueue-חי של מעקב GA4 (`ea_w2_03_purchase_assets()`) — **לא** "ניתוב בלבד" כפי שנוסח במקור (F90-02, תוקן) | **קודם**: לוודא ש-`chapters-commerce.php` (§3.5.5) כבר קיים ופעיל. **אז** מחק יחד, אחרי אצווה A/B |
| `wave2-w2-04.php` + `wave2-w2-04-content.php` (D-1, ה"קובץ ה-12/13 החסר") | `the_content` filter — תלוי-slug, ממילא moot כש-Chapters לא קוראת ל-`the_content()` | מחק יחד |
| `wave2-w2-05.php` + `wave2-w2-05-content.php` | `the_content` filter — כנ"ל, **וגם** 3 פונקציות-accessor ש-`product-cta.php` (T3) קורא להן ישירות (F90-01, תוקן) | **קודם**: לוודא ש-`chapters-commerce.php` (§3.5.5) כבר קיים ופעיל. **אז** מחק יחד, רק אחרי §3.5 (המקור למפת ה-shop) |
| `wave2-w2-06.php` | פילטר `the_author`/`get_the_author_display_name` (D-8) — עדיין פעיל על Chapters `/blog/` | **קודם**: העבר את הפילטר (2 שורות) למקום קבוע (functions.php או קובץ ה-SEO-fallback החדש מ-§3.3). **אז** מחק את שאר הקובץ. |
| `wave2-w2-07.php` | `/qr` (בטיפול T5) + `/press` (D-9, **ללא בעלים**) | **לא נמחק בפאזה הזו** — ר' §3.7 |
| `wave2-w2-08.php` | hreflang ל-`/en` (D-8) — `/en` כבר מוצל אך ה-hook עדיין רלוונטי | **לא נמחק בפאזה הזו** — ר' §3.7 (אלא אם team_00 מחליט ש-`/en` יוצא מ-scope; במקרה זה, קודם להעביר את ה-hreflang כמו הפילטר של w2-06) |
| `wave2-w2-09.php` | **הכול** (D-6) | **לא נמחק — מועבר** (§3.3), לפני שאר הקבוצה |
| `wave2-w2-14e.php` | ניתוב בלבד; שים לב — משרת גם `moksha` (slug ישן, כנראה כבר יתום — ר' D-5-adjacent) | מחק אחרי אצווה A |

**סדר מומלץ בתוך קבוצה C:** קודם 03/04/05/14e (ניתוב-בלבד, אחרי חילוץ התוכן הנדרש), אז 02 ו-06 (אחרי שהחילוץ הידני שלהם בוצע), 09 מטופל בנפרד כבר ב-§3.3 (מוקדם, לא כאן). 07/08 נשארים מחוץ למחזור הזה (§3.7).

### 3.7 קבוצה D — שיורית, **מחוץ ל-scope הזה** (`/qr`, `/press`, וה"זנב" של w2-06/07/08)

זהו הממצא המרכזי של §2: T6 כפי שהוגדר ("למחוק את כל 12 קבצי ה-`wave2-w2-*.php`") **אינו בר-ביצוע במלואו** במסגרת T1–T5 כפי שהם מוגדרים היום, כי:
- `wave2-w2-07.php` לא ניתן למחיקה מלאה עד ש-`/qr` **וגם** `/press` שניהם חיים ב-Chapters. `/qr` בטיפול T5; **`/press` חסר בעלים בכל LOD200/LOD300**.
- `wave2-w2-06.php`/`wave2-w2-08.php` — לאחר חילוץ ה-hooks הלא-ניתוביים (§3.6), שרידי הניתוב שלהם (`/blog`, `/en`) כבר מתים בפועל (Chapters מנצחת בעדיפות) — ז"א ניתן למחוק את **שאר** הקובץ (אחרי החילוץ) גם בלי מיגרציית `/blog`/`/en` פורמלית, כי אין להם עוד תפקיד חי. זה **שונה** מ-`wave2-w2-07.php`, שבו `/press` באמת עדיין מנותב על ידו בלבד.

**המלצה:** אל תחסום את כל T6 בגלל `/press`. בצע את §3.2–3.6 במלואם (כולל מחיקת wave2-w2-06.php/08.php אחרי חילוץ ה-hooks שלהם — הניתוב שבתוכם כבר מת גם בלי מיגרציה פורמלית ל-`/blog`/`/en`), השאר את `wave2-w2-07.php` **כפי שהוא** (או גזום ל-`/press` בלבד, אם team_110 מעדיף לגזום את ענף ה-`/qr` המת-כבר-בפועל-לאחר-T5 החוצה כבר עכשיו), ופתח מעקב מפורש (WP חדש או סעיף ב-roadmap.yaml) ל"`/press` → Chapters" כתנאי למחיקה הסופית של `wave2-w2-07.php` ושל `tpl-content.php`. זה מונע מ-T6 להיתקע על תלות שלא הייתה ידועה כשה-WP נפתח.

### 3.8 קבוצה אחרונה — `wave2-stage-b.php` עצמו

רק אחרי: (א) קבוצות A+B+C הושלמו; (ב) הבידוד של Chapters מ-`ea_wave2_shell`/enqueue הושלם ואומת (§3.2); (ג) הוחלט מה קפוא (rollback) ומה נמחק. בפועל: **חלק** מהקובץ (enqueue/dequeue/emoji/body-class הגנרי) נמחק; **חלק** (רינדור הבית) קפוא במקום נפרד. "מחיקת stage-b.php" כפעולה אחת-לאחת **אינה** הפעולה הנכונה בהינתן D-2.

### 3.9 טבלת סיכום סדר

| שלב | מה | תלוי ב-אימות |
|---|---|---|
| 0 | שער כניסה (§3.1) | T1–T5+T3b PASS מתועד |
| 1 | חילוץ: redirects מ-w2-02 (D-7), פילטר-author מ-w2-06 (D-8), rename w2-09 (D-6) | code review, לא QA-רץ |
| 2 | קבוצה A — 9 templates | אצווה 1 (§4) |
| 3 | קבוצה B — `tpl-shop-archive.php` | אצווה 2 (§4), רק אחרי T5 חי |
| 4 | קבוצה C (חלקי, כולל w2-04-content החסר) | אצווה 3 (§4) |
| 5 | בידוד Chapters מ-stage-b enqueue (בנייה, לא מחיקה) | QA ויזואלי מלא על כל עמודי Chapters |
| 6 | קפאת tpl-home.php + חלק-רינדור stage-b | חתימת team_00 |
| 7 | מחיקת חלק-enqueue של stage-b | אצווה 4 (§4) |
| — | קבוצה D (w2-07 /press, ואפשרי w2-06/08 השיורי) | **מחוץ ל-WP הזה** — מעקב נפרד |

---

## 4. T6 — בדיקת אימות לפני כל אצווה

**עיקרון:** grep סטטי **הכרחי אך לא מספיק** — WordPress מאפשר שיוך-תבנית ידני לעמוד ב-wp-admin (`_wp_page_template` postmeta) שלא מופיע בשום `template_include` filter בקוד (זה בדיוק המנגנון ש-`tpl-qr.php` נשען עליו, D-4). כל אצווה דורשת **שלוש** שכבות בדיקה, לא רק אחת:

**(א) grep סטטי — לפני כל מחיקה, לכל קובץ באצווה:**
```bash
# שם-קובץ מדויק
grep -rn "<שם-קובץ>" --include="*.php" site/wp-content/themes/ea-eyalamit/
# טוקן-בסיס (בלי .php) — תופס concatenation דינמי, כמו tpl-book-detail ב-w2-03.php:94
grep -rn "<שם-בלי-סיומת>" --include="*.php" site/wp-content/themes/ea-eyalamit/
```
תוצאה מצופה: אפס הפניות **חוץ** מ-(1) הקובץ עצמו, (2) הרשומה שכבר מזוהה כ"router מוצל" (ומתועד ככזה בטבלת §3.6/§3.4).

**(ב) בדיקת DB/wp-admin — פר-קובץ, לא רק פר-slug:**
בהיעדר גישת `wp-cli`/DB ישירה מסביבת המחקר הזו (אומת: `wp` אינו מותקן), יש להריץ ב-wp-admin (או query ישיר אם יש גישה) עבור **כל** קובץ שעומד להימחק:
```sql
SELECT p.ID, p.post_title, p.post_name, pm.meta_value
FROM wp_postmeta pm JOIN wp_posts p ON p.ID = pm.post_id
WHERE pm.meta_key = '_wp_page_template'
  AND pm.meta_value LIKE '%<שם-קובץ>%';
```
תוצאה מצופה: אפס שורות, **או** שורות ששייכות אך ורק לעמודים ש-Chapters כבר תופסת (לפי route map, §2 הטבלה). זו הבדיקה היחידה שהייתה חושפת את `tpl-qr.php` (D-4) לפני נזק.

**(ג) smoke-test חי — אחרי כל מחיקה באצווה, על **כל** ה-URL-ים הרלוונטיים (לא רק אחד לדוגמה):**
```bash
# לכל path רלוונטי לאצווה:
curl -sk --max-time 15 -o /dev/null -w "HTTP:%{http_code}\n" "https://eyalamit-co-il-2026.s887.upress.link<path>"
# ואז — סמן שהתבנית הנכונה עדיין מרונדרת (לא רק 200; יכול להיות 200 עם עמוד לבן/שגיאת PHP מוסתרת):
curl -sk --max-time 15 "https://eyalamit-co-il-2026.s887.upress.link<path>" | grep -oE "chapters\.css|ea-wave2-shell|class=\"ea-chapters" | sort -u
```
ואם יש שינוי ב-CSS/JS מוזרק (למשל אחרי §3.8 שלב 7): להריץ `qa_probe.mjs` (לא curl בלבד — curl לא רואה overflow/layout, ר' CLAUDE.md) על **כל** ה-URL-ים שנגעו:
```bash
node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs \
  --base https://eyalamit-co-il-2026.s887.upress.link \
  --paths /,/method/,/treatment/,/sound-healing/,/lessons/,/faq/,/eyal-amit/,/eyal-amit/mokesh-dahiman/,/books/vekatavta/,/books/kushi-blantis/,/books/tsva-bekahol/,/didgeridoos/,/bags/,/stands-storage/,/stand-floor/,/repair/,/contact/ \
  --shots
```
**Exit code 1 = STOP** — אין ממשיכים לאצווה הבאה עד שהסיבה מובנת.

**מיפוי אצוות → קבצים (תואם §3.9):**
- אצווה 1 (לפני קבוצה A): grep על 9 הקבצים + smoke-test על method/treatment/faq/contact/eyal-amit + 5 עמודי מוצר + 3 עמודי ספר (כל ה-slugs שה-9 קבצים "היו" משרתים).
- אצווה 2 (לפני קבוצה B): grep + DB check על `tpl-shop-archive.php` **וגם** אימות מפורש ש-`/shop` כבר מרונדר Chapters (לא רק "T5 סומן הושלם" — לבדוק live).
- אצווה 3 (לפני קבוצה C): grep על כל 13 קבצי ה-inc (כולל ה-04-content שנמצא, D-1) + חזרה מפורשת על שלב "1" (חילוץ redirects/filter/rename) לפני שנוגעים בקבצים עצמם.
- אצווה 4 (לפני §3.8 שלב 7): full `qa_probe.mjs` על **כל** עמודי Chapters (לא רק המדגם למעלה) + בדיקה ידנית שכפתור ה-WhatsApp הצף עדיין קיים איפה שהוחלט שהוא צריך להיות.

---

## 5. T7 — צ'קליסט QA קונקרטי, ממופה לכל משטח חדש

### 5.1 כללי (site-wide, לפי LOD200 §6)

- [ ] **קישורים שבורים** — זחילה מלאה של האתר (לא רק העמודים שהשתנו): ניווט, פוטר, קישורים פנימיים בתוך תוכן, קישורי redirect (כולל 5 החוקים שהועברו מ-w2-02, D-7 — לבדוק שהם עדיין 301 נכון אחרי המעבר).
- [ ] **עקביות ויזואלית** — עמודים שעברו ל-Chapters ב-T3/T3b/T5 נראים **עקביים** עם עמודי Chapters הוותיקים יותר (לא "טלאי" מזוהה) — השוואה חזותית צד-לצד, לא רק "זה לא שבור".
- [ ] **`target="_blank"` אחיד** — לכל קישור-יוצא (Mendele/רכישה, YouTube, Facebook embeds, WhatsApp) — לבדוק `rel="noopener noreferrer"` נלווה בכולם, לא רק ב-`ea-whatsapp-float` (שכבר יש לו את זה, `wave2-stage-b.php:378-379`). לבדוק ספציפית את כפתורי-הרכישה הכפולים החדשים ב-T3b (מודפס/דיגיטלי) ואת קישורי-הרכישה החדשים ב-T3 (5 מוצרים).
- [ ] **`content-diff.mjs`** על **כל** עמוד ב-`PAGE_MAP` (`scripts/qa/content-diff.mjs`) — 0% סטייה. **לפני ההרצה**: להוסיף ל-`PAGE_MAP` את `/shop/` ואת עמודי `/qr/qrN/` (אומת: אף אחד מהם לא קיים היום ב-`PAGE_MAP` — `grep -n "'/shop\|'/qr" scripts/qa/content-diff.mjs` מחזיר ריק) — אחרת T5 לא מקבל את בדיקת סטיית-התוכן שהוא זקוק לה.
- [ ] **`qa_probe.mjs`** ריצה מלאה (כל ה-viewports) על כל ה-URL-ים שהשתנו — לא רק absent-strings, גם overflow (הכי רלוונטי ל-T1: גלריה + וידאו הם הסיכון הכי גבוה ל-horizontal-overflow בכל ה-WP).
- [ ] **Sitemap hygiene** — אחרי שקבצי Wave2 נמחקים, `mu-plugins/ea-w2-17-sitemap-exclusions.php` (התשתית הקיימת ל"הדרת URL-ים ישנים מה-sitemap") רלוונטי גם ל-URL-ים חדשים שנוצרו/בוטלו ב-T5/T6 — לבדוק אם רשימת ה-14 הנתיבים בו (`ea_w217_redirect_source_paths()`) צריכה תוספת.

### 5.2 T1 — מוקש דהימן (`/eyal-amit/mokesh-dahiman/`)

- [ ] טריילר יוטיוב מוטמע ומתנגן (כל פתרון שנבחר, §4 Q2 ב-LOD300 — הרחבת רכיב או פתרון ייעודי) — **ואין שני מסלולי-קוד לאותו דבר** (אם הוחלט על הרחבת הרכיב הכללי, לוודא שהפתרון הייעודי הישן נמחק ולא נשאר במקביל).
- [ ] גלריית 19 תמונות מלאה (לא 7) מוצגת, לא רק תמונות בודדות בתוך טקסט.
- [ ] 4 הטמעות פייסבוק מוצגות ותקינות.
- [ ] `VideoObject` schema קיים ותקין (בדיקה ב-Google Rich Results Test).
- [ ] `Person` schema **חדש** למוקש קיים, תקין, **ולא מתנגש** עם ה-Person schema הקיים של אייל עמית עצמו (`mu-plugins/ea-w2-seo-schema.php:40-51`) — לבדוק שני ה-schema-ים יחד באותו עמוד/אתר.
- [ ] מיקום: גלריה אחרי "הסרט", הטמעות פייסבוק אחרי "ממשיכי הדרך" (לפי המוקאפ המאושר).
- [ ] `content-diff.mjs` — 0% סטייה מול המקור (`מוקש דהימן...docx`), **גם אחרי** הוספת שכבת המדיה (המדיה לא אמורה לגעת בטקסט — לוודא).
- [ ] `qa_probe.mjs` — אפס horizontal-overflow בכל viewport (זה העמוד עם הכי הרבה תוספת-תוכן חדשה מכל ה-WP).

### 5.3 T2 — FAQ many-to-many

- [ ] כל 79 השאלות במאגר המרכזי שמרו על שיוך-קטגוריה נכון אחרי המעבר ל-many-to-many (לא איבדו/שכפלו שיוכים) — **מספר מתוקן, ר' T2 §0 תיקון 1 (F90-07)**.
- [ ] כל 11 עמודי ה-mini-FAQ (treatment, sound-healing, bags, vekatavta, kushi-blantis, repair, didgeridoos, stands-storage, tsva-bekahol, stand-floor, **וגם `lessons`**) מציגים דרך הרכיב המשותף + סינון-קטגוריה — **ולא** מערך/פרוזה-ידניים מקומיים כפולים. לבדוק בפועל שהתוכן הכפול הוסר מכל אחד מ-11 קבצי `inc/chapters/defaults/*-defaults.php`, לא רק שנוסף לו מנגנון חדש לצידו.
- [ ] `lessons` **הצטרף לפורט הרגיל** (יש לו section FAQ כבר היום, כפרוזה — לא "ללא FAQ section" כפי ש-LOD300 C-4 טעה לקבוע, ר' T2 §0 תיקון 2 / F90-07) ו-`method` (מקרה-קצה ארכיטקטוני אמיתי, template נפרד) קיבל את שני השינויים הספציפיים שT2 §4.2 מפרטת — לא הוגרו אוטומטית "כמו כולם".
- [ ] `FAQPage` schema מתעדכן נכון מול המבנה **החדש** (many-to-many): שאלה עם 2+ קטגוריות מייצרת רשומת-schema **אחת**, לא כפולה.

### 5.4 T3 — תבנית מוצר (5 עמודים: didgeridoos, bags, stands-storage, stand-floor, repair)

- [ ] מחיר מוצג בכל אחד מ-5 העמודים (היה חסר ב-Chapters לפני).
- [ ] כפתור WhatsApp/צור-קשר — משתמש **באותו** דפוס פעיל מ-`template-parts/chapters/parts/contact.php` (לא מומש מחדש) — לבדוק שה-URL ותוכן ההודעה המוטמעת נכונים לכל מוצר.
- [ ] גלריה: אם עד מועד ה-QA אייל עדיין לא סיפק תמונות אמיתיות (C-2) — לוודא שהקוד **מדלג** על סקשן-הגלריה (לא מציג ריבועים אפורים ריקים). זו בדיקת-regression אמיתית, לא תיאורטית.
- [ ] אם קישורי-הסליקה האמיתיים הוזנו עד מועד ה-QA — לבדוק שכל 5 מפנים למקום הנכון (מותנה, כנראה N/A במועד הקרוב).

### 5.5 T3b — עמודי ספרים (`/books/vekatavta/`, `/books/kushi-blantis/`, `/books/tsva-bekahol/`)

- [ ] מחיר-על-גבי-כפתור-הרכישה מוצג (תואם למוקאפ המאושר).
- [ ] שני כפתורי רכישה נפרדים (מודפס/דיגיטלי), עם מעקב-לחיצה **פעיל בפועל** — לבדוק אירוע-מעקב יורה בפועל (network tab / analytics-config), לא רק שהכפתור קיים ויזואלית.
- [ ] "כושי בלאנטיס" — טקסט "קישור יתווסף בהמשך" **הוסר**, קישור אמיתי במקומו.
- [ ] גלריה — תמונה אמיתית אחת + טיפול נכון ב-3 ה-placeholder (לפי המוקאפ המאושר, לא ריבועים אפורים).
- [ ] "קטע לקריאה" מתקפל — נבדק במצב שבו **הוחלט** (פתוח/סגור כברירת מחדל) — לוודא שהמצב שהוחלט הוא הנבדק, לא הנחה.
- [ ] "צבע בכחול וזרוק לים" — קישור הרכישה תואם לתשובת אייל שהתקבלה בפועל (C-5) — לוודא שהתשובה התקבלה **ויושמה**, לא רק "יש קישור כלשהו".
- [ ] `Book` schema קיים ותקין על שלושת העמודים.
- [ ] `content-diff.mjs` — 0% סטייה מול 3 מקורות הספרים.

### 5.6 T5 — `/shop` ו-`/qr`

- [ ] `/shop` מרונדר Chapters (לא `tpl-shop-archive.php`) — grid של 5 כרטיסי מוצר, קישורים ל-5 עמודי המוצר תקינים.
- [ ] **כל** כתובת `/qr/qrN/` הקיימת (יש להוציא רשימה מלאה — עד 48, דרך sitemap חי או DB — לא לדגום) ממשיכה לעבוד **בדיוק** כפי שהודפסה (ישירות או ב-redirect קבוע) — זהו האילוץ הקשיח מ-§4 Q3 ב-LOD300; בדיקה חלקית/מדגמית **אינה מספיקה** כאן, כי קודי QR מודפסים ובלתי-ניתנים-לתיקון.
- [ ] `/shop/` ו-כל `/qr/qrN/` **נוספו** ל-`content-diff.mjs` PAGE_MAP (אומת חסרים היום) כדי שרגרסיה עתידית תיתפס אוטומטית.

### 5.7 ממשקי העריכה של אייל

- [ ] `hub/dist/page-review.html`, `hub/dist/media-intake.html`, `hub/dist/content-intake.html` — נוצרים ע"י `scripts/build_eyal_client_hub.py` (argparse; `python3 scripts/build_eyal_client_hub.py --help` לדגלים המדויקים). **יש להריץ מחדש** אחרי שT1–T5+T3b נוחתים, כדי שהם ישקפו את עץ-האתר/מבנה-התוכן המאוחד — לא רק לוודא שהם "לא שבורים" במובן הישן.
- [ ] בדיקה ידנית: כל שלושת הקבצים נטענים ללא שגיאת קונסול, עץ-הניווט הפנימי שלהם תואם את מבנה-האתר **שאחרי** האיחוד (לא Wave2-era).

### 5.8 פקודות מוכנות להרצה

```bash
# content-diff — כל עמודי ה-PAGE_MAP (אחרי הוספת /shop + /qr):
node scripts/qa/content-diff.mjs --base https://eyalamit-co-il-2026.s887.upress.link

# qa_probe — כל העמודים שהשתנו + מוקש בנפרד (סיכון overflow גבוה):
node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs \
  --base https://eyalamit-co-il-2026.s887.upress.link \
  --paths /,/shop/,/method/,/treatment/,/faq/,/eyal-amit/,/eyal-amit/mokesh-dahiman/,/books/vekatavta/,/books/kushi-blantis/,/books/tsva-bekahol/,/didgeridoos/,/bags/,/stands-storage/,/stand-floor/,/repair/,/contact/ \
  --shots

# regenerate Eyal's editing interfaces:
python3 scripts/build_eyal_client_hub.py
```

---

## 6. קריטריוני קבלה

### 6.1 T6

1. אפס הפניה חיה (grep סטטי **וגם** dynamic-token, §4-א) בכל קוד התבנית/theme לכל אחד מ-9+1 קבצי ה-template שנמחקו (§3.4-3.5), **חוץ** מהתיעוד/היסטוריה (git log, מסמכי _COMMUNICATION).
2. אפס שורה ב-`_wp_page_template` postmeta (§4-ב) שמצביעה על קובץ שנמחק.
3. כל 5 חוקי ה-redirect מ-`wave2-w2-02.php` (D-7) קיימים ופעילים במקום הקבוע החדש — 301 מאומת חי לכל אחד מה-5 URL-ים.
4. `wave2-w2-09.php` **לא נמחק** — הועבר/שוכתב-שם, שתי הפונקציות שלו (favicon, meta-description fallback) פעילות בדיוק כמו לפני, על **כל** סוגי העמודים (Wave2 הנותר, Chapters, /en).
5. `tpl-home.php` + חלק-הרינדור של `wave2-stage-b.php` — קיימים, קפואים, מתועדים במפורש כ"חירום בלבד", וניתנים להפעלה בפועל (בדיקת rollback אמיתית: הגדרת `EA_CHAPTERS_FRONT=false` בסביבת בדיקה, ווידוא שדף-הבית עדיין מרונדר תקין — לא test תיאורטי).
6. Chapters אינה תלויה עוד ב-`ea_wave2_shell`/`ea_wave2_is_active_view()`/enqueue-functions של `wave2-stage-b.php` — `curl` על עמוד Chapters מציג `chapters.css` **בלבד** מבין השניים (לא `ea-tokens.css` לצידו) — היפוך מפורש של הבדיקה החיה שביססה את D-2.
7. `wave2-w2-07.php` (ו-`tpl-content.php`, `tpl-qr.php` אם רלוונטי) — אם נותרו בכוונה (§3.7), מתועדים ב-roadmap.yaml/WP נפרד כחוב-ידוע, לא "נשכחו".
8. כל 13 קבצי ה-`wave2-w2-*.php`/`-content.php` שבאמת נמחקו (לא כולל 07 אם נשאר בכוונה) — מאומתים ב-`git log --diff-filter=D` שאכן נמחקו, לא רק "רוקנו".

### 6.2 T7

1. `content-diff.mjs` — 0% סטייה על **כל** רשומה ב-PAGE_MAP המעודכן (כולל `/shop`, כולל כל `/qr/qrN/` שנוספו).
2. `qa_probe.mjs` — exit code 0 על כל ה-URL-ים שנבדקו, בכל viewport, כולל אפס forbidden-substring ואפס horizontal-overflow.
3. אפס 404 חדש על קישור פנימי כלשהו באתר (לפני/אחרי diff של זחילה מלאה).
4. 100% מ-`target="_blank"` הקישורים-היוצאים החדשים (T3, T3b) נושאים גם `rel="noopener noreferrer"`.
5. כל אחד מ-5 קריטריוני ה-QA הספציפיים ב-§5.2–5.6 מסומן PASS בנפרד (לא "QA כללי עבר" — לכל T יש חתימת-PASS משלו).
6. שלושת ממשקי-העריכה של אייל (§5.7) נטענים ללא שגיאה ומשקפים את מבנה-האתר המאוחד.
7. בדיקת ה-rollback בפועל (6.1 סעיף 5) בוצעה בסביבת בדיקה נפרדת מפרודקשן/staging חי, ותועדה.

---

## 7. Edge cases / סיכונים

1. **קאש/CDN שמצביע על אסטים שנמחקו.** 13 קובצי CSS/JS מוזרקים אך-ורק ע"י `wave2-stage-b.php` (`ea-animations.css`, `ea-atoms.css`, `ea-mobile-nav.css`, `ea-mobile-variants.css`, `ea-tokens.css`, `home-front.css`, `testimonials-carousel.css`, `ea-ab-testing.js`, `ea-entrance.js`, `ea-hero.js`, `ea-mobile-nav.js`, `ea-scroll.js`, `ea-testimonials.js`) — אם ה-enqueue-כלל שלהם נמחק (§3.8) בלי לפנות קודם קאש/CDN, דפדפנים עם HTML-ישן-בקאש עדיין ינסו לטעון אותם (404 שקט, לא קריטי אך מלוכלך). לתאם ניקוי-קאש בזמן הפריסה.
2. **מנועי חיפוש עם URL-ים מאונדקסים של Wave2.** לתשתית הקיימת (`ea-w209-legacy-301-redirects.php`, `ea-w2-17-sitemap-exclusions.php`) יש כבר תקדים מלא לטיפול במקרה הזה (135 החלטות redirect + הדרת-sitemap פעילה) — **אין להמציא מנגנון חדש**, להרחיב את הקיים. סיכון קונקרטי: אם `/shop`/`/qr/qrN/` הישנים (לפני T5) כבר אינדקסו ב-Google עם ה-markup הישן של Wave2, ו-URL השתנה או שה-markup השתנה מהותית — לבדוק ב-Search Console (לא רק בקוד) שאין ירידת-דירוג פתאומית אחרי הפריסה.
3. **שיוך-תבנית ידני ב-wp-admin, בלתי-נראה ל-grep.** זה בדיוק מה ש-D-4 (`tpl-qr.php`) חשף. לפני כל מחיקה, בדיקת ה-DB (§4-ב) היא **לא אופציונלית** — grep סטטי לבדו כבר הראה שהוא מפספס תלויות אמיתיות בפרויקט הזה.
4. **קבצים ששמם "wave2-w2-*" אך תפקידם אינו Wave2.** D-6 (`w2-09`) הוא הדוגמה החמורה, אך העיקרון (§3.0) חל על כל קובץ עתידי דומה — אל תסמכו על מוסכמת-שם.
5. **`EA_CHAPTERS_FRONT=false` בפרודקשן בטעות, אחרי ש-`tpl-home.php`/stage-b "קפואים" אך לא נבדקו בפועל.** אם ה-rollback "קפוא" אבל אף פעם לא הופעל-בפועל בבדיקה (6.1.5), יש סיכון שהוא ישבר בשקט (תלות ב-פונקציה/asset שנמחק בטעות תוך כדי §3.8) בדיוק ברגע שהוא הכי נחוץ — כשל-אמון ברשת-הביטחון. **חובה** להריץ בדיקת rollback אמיתית לפני שה-WP נסגר, לא רק לוודא שהקבצים "קיימים על הדיסק".
6. **`/press` נשאר תלוי-Wave2 ללא תאריך-סיום.** אם אף אחד לא פותח WP/מעקב ל-`/press` (D-9), `wave2-w2-07.php` ו-`tpl-content.php` נשארים "חוב זמני" שהופך קל לקבוע — בדיוק התבנית שה-WP הזה כולו קם כדי לתקן. יש לפתוח מעקב מפורש, לא להשאיר כ"נודע ונשכח".
7. **התנגשות `Person` schema (T1) מול `Person` schema קיים (אייל עמית).** שני `Person` schema-ים באותו אתר (ואולי באותו עמוד, אם מוקש מוזכר גם בעמוד-אודות של אייל) עלולים ליצור עמימות עבור Google — לבדוק בפועל ב-Rich Results Test, לא רק תיקוף-סכימה טכני.
8. **סטיית ה-mockup המאושר לעומת המימוש בפועל ב-T3b.** LOD300 מציינת שהמוקאפ המאושר (WP-W2-10-E) הוא **הבסיס**, לא המפרט הסופי — יש **שני עותקים** של אותו מוקאפ בריפו (`_COMMUNICATION/team_35/WP-W2-10-E/elevation/mockup/` וגם `_COMMUNICATION/team_35/WP-W2-10-E/mockup/`), עם ה-LOD300 מצטט במפורש את **elevation** כ"העדכני מבין השניים". סיכון: מישהו ב-team_110 עובד בטעות מהעותק הישן. לוודא איזה עותק שימש בפועל.

---

## 8. סיכום החלטות נדרשות מ-team_00/team_100 לפני ביצוע

| # | החלטה | המלצתי | חייב team_00? |
|---|---|---|---|
| 1 | tpl-home.php + stage-b — הקפאה-ובידוד מול שחזור-מלא מול מחיקה-בסיכון-מקובל (§3.2) | הקפאה-ובידוד | כן — חתימה קצרה |
| 2 | wave2-w2-09.php — rename+relocate (§3.3) | לבצע כפי שהוצע | לא — עבודת-בנייה, לא שאלה |
| 3 | wave2-w2-02.php redirects — מיזוג ל-w209 (D-7) | לבצע כפי שהוצע | לא — עבודת-בנייה |
| 4 | `/press` (D-9) — WP/מעקב נפרד, לא לחסום T6 | לפתוח מעקב, לא לחסום | כן — קצר, רק לאשר את הגישה |
| 5 | היקף T6 בפועל — לקבל שהוא לא "100% מחיקת Wave2" במחזור הזה (קבוצה D נשארת) | לקבל, מתועד | כן |

---

*נכתב ע"י team_100 · 2026-07-14 · המשך ישיר של `WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md` §2 T6/T7 ו-§7 · מבוסס על מחקר-קוד חי + בדיקות staging חיות, לא רק על נספח הראיות של LOD300 כלשונו (ר' §2 לתיקונים).*
---

## 7. Builder / Validator

מאשרר מחדש את ההצעה מ-LOD200 §5 / LOD300 §6, ללא שינוי: **Builder** — team_110 (Domain Architect); **Validator** — team_90 (full-site audit) + team_190 (constitutional), cross-engine מול team_110 לפי Iron Rule #1. team_110 טרם קיבל את המסמך הזה — ייכנס לתמונה רק אחרי שהמסמך עצמו עובר ולידציה חוצת-מנוע (team_100 בונה, מנוע שונה מוודא — Iron Rule #1 חל גם על תהליך כתיבת ה-Spec עצמו, לא רק על מימושו).

## 8. מעקב סגירה — LOD400 exit criteria

- [x] כל 8 המשימות פורטו לרמת קובץ/פונקציה/שורה (§1–§6)
- [x] כל שאלה פתוחה שנותרה מ-LOD300 (§4 שם) יושמה בפועל בספסיפיקציה (many-to-many ל-T2; שיקול-דעת מוכרע ומנומק ל-T1; אילוץ-URL מבני ל-T5)
- [x] כל 5 התיקונים שסומנו ב-LOD300 (C-1..C-5) טופלו במפורש בתוך המשימה הרלוונטית (T3/T5 עבור C-1; T3 עבור C-2; T6 עבור C-3; T2 עבור C-4; T3b עבור C-5, נשאר חסום-חיצוני כמתועד)
- [x] כל קריטריון-קבלה לכל משימה הוא בדיק וקונקרטי (checklist, לא פרוזה)
- [ ] **ולידציה חוצת-מנוע (cursor-composer) — טרם בוצעה.** נדרשת לפי הנחיית team_00 (14/7: "ולידציה מול קומפוזר - אחרי pass מלא - ממשיכים") לפני שהמסמך נחשב סגור.
- [ ] אישור team_00 קצר על §0.2 החלטה 1 (tpl-home.php/stage-b) — לא חוסם ולידציה, חוסם תחילת T6 בפועל
- [ ] team_110 טרם אישר "ניתן לביצוע מהעיצוב הזה" — יקרה אחרי הולידציה חוצת-המנוע, לא לפני

**מסקנה:** המסמך מוכן להגשה לולידציה חוצת-מנוע. הוא **אינו** עדיין LOD500/מוכן-לבנייה בפועל — שני התנאים האחרונים ברשימה למעלה עדיין פתוחים.

---

*נכתב ע"י team_100 · 2026-07-14 · מאחד שישה תת-מסמכי מחקר-קוד עצמאיים (§1–§6) שנכתבו במקביל לגבי WP-CANON-TEMPLATE-UNIFICATION, בהמשך ישיר ל-`WP-CANON-TEMPLATE-UNIFICATION-LOD300-2026-07-14.md`. כל ממצא במסמך מבוסס על קריאת-קוד ישירה ו/או בדיקה חיה מול staging — לא על הנחות שלא אומתו מחדש, גם כשהן חוזרות על LOD300.*
