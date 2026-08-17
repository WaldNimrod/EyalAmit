VERDICT: PASS

## חוזה (ארבעה סעיפים)

| סעיף | תוצאה | ראיה |
|------|--------|------|
| 1. התאמת מקור | **CONFIRMED** | מחרוזות עיקריות ב־`treatment-defaults.php` מצוטטות מ־`treatment.md` עם הערות `מקור: content 13.8.26/...`. דוגמה: «סטודיו נשימה מעגלית בפרדס חנה» — שורה 556 במקור; «עייפות או חוסר יציבות אנרגטית» — שורה 111. פלייסהולדר וידאו: `כאן ייכנס סרטון מפגש` — הוראת team_00, לא תוכן אייל. שאלות CPAP/נחירות בגרסה המוצעת — מבנק CPT (`treatment-16..20`), כמתוכנן. |
| 2. האנק לא ממופה | **CONFIRMED** | שינויי ערכת נושא: `chapters-render.php`, `treatment-defaults.php`, `treatment-eyal-defaults.php` (חדש), `videoblk-placeholder.php` (חדש), `faq-inline.php` (חדש) — כולם ברשימה המותרת. |
| 3. Provenance | **CONFIRMED** | כל סקשן ב־`treatment-defaults.php` נושא `/* S006 · מקור: ... SECTION NN */`; bleed: `quote is SECTION 10`; `faq_eyal_items`: `15 questions from SECTION 10 only`; `chapters-render.php`: `S006 R1-02`. |
| 4. פלט ריק | **CONFIRMED** | שתי כתובות החזירו HTTP 200 + HTML מלא. |

## בדיקות HTML חיות — שתי הגרסאות

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | כפתור הירו → `/contact/` | **CONFIRMED** | `<a class="btn btn--gw" href="/contact/">לתיאום שיחת היכרות</a>` (proposed + eyal) |
| 2 | אין «עובדת הוותק» / «שעוסק בתחום מאז 1999 בשיטת» | **CONFIRMED** | שני המחרוזות absent בשתי הגרסאות |
| 3 | «למי זה מתאים» + שני הסעיפים, אין `.rcard` | **CONFIRMED** | `עייפות או חוסר יציבות אנרגטית` ✓ · `מתמודד עם מחלה` ✓ · `.rcard count: 0` |
| 4 | אין `ea-home-hero-720`; יש פלייסהולדר | **CONFIRMED** | `ea-home-hero-720: False` · `<p class="ea-pending-approval__title">כאן ייכנס סרטון מפגש</p>` |
| 5 | שירי אלקבץ → Facebook | **CONFIRMED** | `href="https://www.facebook.com/share/p/1E7ndvYyrp/"` |
| 6 | «סטודיו נשימה מעגלית» בסקשן «מי זה אייל עמית» | **CONFIRMED** | נמצא בצ'אנק about בשתי הגרסאות |
| 7 | אפס כרטיסי המלצה ריקים | **CONFIRMED** | 26 `<figure class="tmq">` (שכפול קרוסלה), **13 שמות ייחודיים**, `empty cards=0` |

## רק המוצעת (`/treatment/`)

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| 8 | `<section class="bleed">` + «הנשימה היא לכולם.» | **CONFIRMED** | `<section class="bleed" ...><p class="bleed__q r">הנשימה היא לכולם.</p>` |
| 9 | אקורדיון נראה >15 / CPAP | **CONFIRMED** | `data-faq-category="treatment"` ✓ · `ea-faq-item count: 20` · שאלה: `האם דיג'רידו באמת עוזר לנחירות?` |

## רק גרסת המסמך (`?compare=eyal`)

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| 10 | אין `<section class="bleed">` | **CONFIRMED** | `section bleed present: False` |
| 11 | אין `data-faq-category="treatment"`; 15 FAQ | **CONFIRMED** | `data-faq-category=treatment: False` · `ea-faq-item: 15` · `dd__item: 3` (לא נספרו) · CPAP absent מהאקורדיון הנראה |

## מתג שתי הגרסאות

**CONFIRMED** — `ea_chapters_treatment_compare_eyal()` ב־`chapters-render.php` טוען `treatment-eyal-defaults.php` ב־`?compare=eyal`, ומדלג על ACF overlay ל־`/treatment/` כדי ששתי הגרסאות נשלטות מקבצי PHP.
