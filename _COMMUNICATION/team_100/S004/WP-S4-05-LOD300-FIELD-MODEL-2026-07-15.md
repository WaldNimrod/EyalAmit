---
id: WP-S4-05-LOD300-FIELD-MODEL-2026-07-15
lod_status: LOD300
date: 2026-07-15
from_team: team_100
to_team: team_00
type: wp-design-spec
wp: WP-S4-05
authoring_team: team_100
phase_owner: team_100
authorized_by: "team_00 2026-06-22 Option B (ACF פנימי לכל העמודים) + 2026-07-15 תוכנית רצף חבילות S004"
parent_index: _COMMUNICATION/team_100/S004/S004-PACKAGE-SEQUENCE-INDEX-2026-07-15.md
---

# WP-S4-05 — LOD300: הכרעת מודל-השדות לשחזור עריכת wp-admin לעמודי Chapters

> **מטרת המסמך:** להכריע את **מודל השדות** (field model) שבו יוחזרו יכולת העריכה ב-wp-admin לכל «העמודים החשובים» של מערכת Chapters, שנעלמה בשקט במיגרציית 2026-06-22 (ראו אינדקס-אב §1). זהו מסמך **החלטה** (LOD300); ה-spec המבצע המלא (קבצים, שדות, שורות, AC) נמצא ב-`WP-S4-05-LOD400-2026-07-15.md`.

---

## 1. רקע קוד מאומת (מה בדיוק שבור, ולמה)

### 1.1 חוזה ה-accessors קיים ותקין
ב-[chapters-render.php](../../../site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php) קיימות שלוש נקודות-גישה שמממשות דפוס **«ACF-אם-קיים-אחרת-ברירת-מחדל»**:

```
ea_chapters_field( $name )   → get_field($name) אם לא-ריק, אחרת defaults[$name]
ea_chapters_rows( $name )    → have_rows() ACF Pro │ ea_chapters_assemble_rows() free-ACF │ defaults[$name]
ea_chapters_img( $name )     → attachment-id/array/url מ-ACF, אחרת asset_url(defaults[$name])
```

המנגנון כבר תומך ב-override מלא **ובנפילה בטוחה** (אף פעם לא מסך לבן). זו התשתית שעליה נבנה WP-S4-05.

### 1.2 שני מסלולי-הגשה שונים — וזהו שורש הדריפט
בדיקת התבניות חושפת ש**לא כל עמודי Chapters שווים** — יש **שני** מסלולי הגשה:

| מסלול | תבנית | איך התוכן מגיע לחלקי-התצוגה | מצב עריכה נוכחי |
|-------|-------|------------------------------|------------------|
| **A — flat-key (accessor-driven)** | [tpl-chapters-home.php](../../../site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-home.php), [tpl-chapters-method.php](../../../site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-method.php) | כל שדה נקרא במפורש דרך `ea_chapters_field()/rows()/img()` | **home** נערך (יש `group_chapters_home`); **method** *לא* נערך (אין קבוצת שדות) |
| **B — sections-array (defaults-driven)** | [tpl-chapters-page.php](../../../site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-page.php), [tpl-chapters-mokesh.php](../../../site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-mokesh.php) | קורא `$d['sections']` **ישירות** מ-`ea_chapters_defaults()` ומריץ `foreach` — **אינו קורא accessors כלל** | **אף עמוד לא נערך** — ACF כלל לא משתתף |

**מסקנה מחייבת:** רוב העמודים החשובים (treatment, sound-healing, lessons, about, snoring, כל עמודי המוצר והספרים, faq, contact, mokesh) רצים על מסלול **B**, שבו התבנית שולפת את מערך ה-`sections` הישר מקובץ ה-defaults ומעולם לא נוגעת ב-ACF. לכן:
- **method** נדרש רק **רישום קבוצת שדות** (התבנית כבר קוראת accessors).
- **מסלול B** נדרש גם רישום שדות **וגם שכבת-שיכוב (overlay)** שתזליג ערכי ACF לתוך מערך ה-`sections` לפני ה-`foreach`.

### 1.3 מבנה ה-`sections` (הטרוגני)
כל עמוד מסלול-B הוא: מפתח `phero` (סקלרי, hero עליון) + מערך `sections[]` שכל איבר בו הוא `array( 'part' => <type>, 'args' => <assoc> )`. סוגי ה-`part` שנצפו בקטלוג המלא (ראו LOD400 §קטלוג): `prose, split, steps, reveals, dd, bleed, videoblk, testimonials, faqblock, cta, gallery, timeline, mag, lead, bookcard, product-cta, contact, fbembeds, phero/hero`. מספר הסקשנים לעמוד נע בין **1** (contact) ל-**~20** (treatment, mokesh).

---

## 2. אילוץ רישוי: זמינות ACF Pro (ממצא מאומת)

| מקור שנבדק | ממצא |
|-------------|------|
| `site/wp-content/plugins/**` (Glob מלא) | **אין** תוסף ACF כלל (רק `wordpress-importer` ואחרים). ACF מסופק בסביבת uPress/סטייג'ינג, לא ב-repo. |
| grep `acf_pro / flexible_content / advanced-custom-fields-pro` בכל ה-repo | מופיע **רק** בקבצי מיומנות (`.cursor/skills/wp-phpstan/**`) — לא בקוד ולא בתוספים. |
| [M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md](../M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) | «**ACF PRO** — שקול ל-G3+... **לא חובה ב-M2**». כלומר Pro **לא** אושר ולא הותקן. |
| [acf-fields-home.php](../../../site/wp-content/themes/ea-eyalamit/inc/chapters/acf-fields-home.php) | דף הבית כבר מוכיח דפוס **free-ACF fixed-slot** (`$img/$txt/$tab/$acc/$slots`) — repeater מדומה בשדות שטוחים `{base}_{i}_{sub}` בלי Pro. |

**קביעה:** נכון ל-2026-07-15, **ACF Pro אינו זמין ולא מאושר**. חובה להניח **ACF חינמי בלבד**. כל מודל שמסתמך על Flexible Content / Repeater של Pro נפסל כברירת-מחדל.

---

## 3. אפשרויות המודל — עלות/סיכון אמיתיים

### אופציה A — ACF Pro Flexible Content
מודל טבעי ל-`sections` הטרוגני: כל `part` = layout ב-Flexible Content; העורך מוסיף/מסדר/מוחק סקשנים חופשית.

| + | − |
|---|---|
| התאמה מושלמת למבנה הנתונים; העורך שולט גם בסדר ובכמות הסקשנים | **דורש רישיון Pro** (לא זמין — §2) → **פסול** |
| שדה יחיד לכל עמוד, פחות שטח שדות | סיכון ריגרסיה: העורך יכול לשבור מבנה/סדר שנקבע בעיצוב; דורש הגירת נתונים מ-defaults → Flexible |
| — | סוטה מדפוס ה-home הקיים (free fixed-slot) → שני דפוסים במקביל |

**מסקנה:** נחסם רישויית. לא בר-מימוש עכשיו.

### אופציה B — free-ACF, קבוצות-שדות ייעודיות לפי-סוג-עמוד (מראה מדויקת של רשימת הסקשנים הקבועה)
הרחבה ישירה של דפוס ה-home: לכל **סוג עמוד** קבוצת-שדות שמשקפת את **הרשימה הקבועה** של הסקשנים שלו. הסקלרים = שדות שטוחים; רשימות (`items[]`) = fixed-slots `{...}_{i}_{sub}`; המבנה, הסדר וסוגי ה-`part` **נעולים** (כמו ב-home: «עריכת טקסטים ותמונות בלבד — המבנה נעול»).

| + | − |
|---|---|
| **בלי רישיון** (free-ACF) | שטח שדות גדול יותר (סקלר-לכל-ארג) — מנוהל היטב עם רישום מונחה-נתונים (LOD400 §4) |
| **מוכח כבר ב-home** — אותו `$img/$txt/$slots`, אותו assemble; סיכון נמוך | העורך אינו יכול להוסיף/למחוק סקשנים (זו גם מעלה — נעילת עיצוב) |
| נפילה בטוחה מובנית: ריק → default, ACF כבוי → default; אף פעם לא מסך לבן | דורש שכבת-overlay חדשה למסלול-B (רכיב הנדסי אחד, ממומש פעם אחת) |
| ניתן **לייצר את הרישום מתוך מערך ה-defaults עצמו** (SSOT יחיד) → אין כפילות סכימה | תלוי בכך שסקשנים סופיים כבר יציבים (ולכן תלות ב-S4-01/S4-04) |

### אופציה C — היברید (B ל-flat-key, ומנגנון קל ל-sections)
זהה ל-B מבחינת רישוי ודפוס, אך מפרידה בין שני המסלולים: מסלול-A (home/method) מקבל קבוצת-שדות **flat-key** התואמת בדיוק את שמות ה-accessors; מסלול-B מקבל **overlay מונחה-אינדקס** + רישום מונחה-נתונים. למעשה זהו **מימוש-B הנכון** בהינתן שני המסלולים.

---

## 4. המלצה מחייבת: **אופציה B (בגרסת C — מודע-מסלול)**

**מאמצים free-ACF, קבוצות-שדות ייעודיות לפי-סוג-עמוד, מונחות-נתונים מתוך ה-defaults, עם שתי חטיבות מימוש לפי המסלול.** נימוקים:

1. **רישוי:** היחיד שבר-מימוש בלי ACF Pro (§2).
2. **הוכחת-דפוס:** דף הבית כבר רץ על בדיוק המנגנון הזה (`$slots`, `ea_chapters_assemble_rows`, `ea_chapters_repeater_specs`) — סיכון ריגרסיה מינימלי.
3. **נעילת-עיצוב:** התוכן מתקבל מ-CEO אייל כטקסט/מדיה; אין צורך שהעורך ישנה מבנה — רק טקסט ותמונות. זה **מקטין** סיכון, לא מגביל את הצורך.
4. **SSOT יחיד:** מכיוון שכל עמוד כבר מגדיר את מבנהו ב-`defaults/{type}-defaults.php`, הרישום **ייגזר מהמערך הזה** — אין כפילות סכימה בין defaults ל-ACF, ואין drift עתידי.

### 4.1 אסטרטגיית location-rule
לכל קבוצת-שדות **כלל-מיקום לפי page slug** (`page` param, operator `==`, value = slug), למעט home שנשאר על `page_template`+`front_page` הקיים. נימוק: מסלול-B ממופה סוג←slug דרך `ea_chapters_route_map()`; שני עמודים (method) עדיין ניתנים לכריכה ב-`page_template`, אך slug אחיד לכל הקבוצות = חד-משמעי, יציב, וקל לאימות. דפי מוצר/ספר (אותה תבנית `tpl-chapters-page`) **חייבים** slug כי הם חולקים template+type-family שונה.

### 4.2 מיפוי סקשנים משתנים ל-fixed-slots (per page)
- **סקלרים** (chap/title/body/lead/quote/attrib/cta_*/…): שדה שטוח יחיד לכל ארג.
- **רשימות** (`items[]` ב-steps/reveals/dd/testimonials/gallery/timeline/mag/bookcard/fbembeds): fixed-slots בגודל = ספירת-ברירת-המחדל של אותו סקשן **+ headroom** (ברירת מחדל +2, למעט testimonials +4), עם תת-שדות התואמים למפתחות האיבר. נרשמות ב-`ea_chapters_repeater_specs()` שיהפוך **מודע-סוג** (type-aware) כדי לפתור התנגשות-שמות בין עמודים (למשל `whom_items` שונה ב-home מ-method).
- **ארגים מבניים נעולים** (לא-שדות): `part, figr, reversed, id, alt(bool), center, dark, collapsible, active, cats, slug, cta_slug, yt_id, pending*`.

### 4.3 טיפול ב-image-id
כל שדה תמונה נרשם `return_format => 'id'` (כמו ב-home). בשכבת-ה-overlay של מסלול-B, ארגי-תמונה (`image/media/poster/cover/avatar/video`) יפוענחו דרך **`ea_chapters_resolve_img()`** (שכבר יודע id/array/url/theme-path) **במקום** `ea_chapters_asset_url()` הנוכחי — אחרת attachment-id יישבר. זו תוספת-תיקון קריטית שנכללת ב-LOD400.

### 4.4 טבלת גודל-עבודה לפי עמוד (הערכת שדות)
מבוסס על ספירת הסקשנים בקטלוג בפועל. «שדות סקלריים» = סך ארגים ניתנים-לעריכה; «Slot-repeaters» = מס' רשימות × ספירה.

| עמוד (slug) | מסלול | קבוצות | ~סקלרים | Slot-repeaters (name×count) | הערה |
|-------------|-------|--------|---------|------------------------------|------|
| home | A | קיימת | — | קיימות | ✅ כבר בוצע |
| method | A (flat-key) | 1 | ~24 | mag_items×6, whom_items×6, testi_items×12 | התבנית כבר קוראת accessors |
| treatment | B | 1 | ~55 | steps×6, reveals×7, dd×5, testimonials×16 | ~20 סקשנים |
| snoring-sleep-apnea | B | 1 | ~30 | gallery×3 | תלוי S4-01 (18 סקשנים סופיים) |
| sound-healing | B | 1 | ~40 | steps×6, reveals×6, testimonials×12 | |
| lessons | B | 1 | ~40 | dd×7, reveals×6, testimonials×12 | תוכן S4-04 |
| eyal-amit (about) | B | 1 | ~45 | timeline×6, reveals×6 | |
| mokesh-dahiman | B (mokesh tpl) | 1 | ~50 | timeline×9, gallery×21, fbembeds×6 | חי verbatim; עריכה בזהירות |
| didgeridoos | B | 1 | ~35 | steps×6 + product-cta | + meta-box מחיר |
| bags | B | 1 | ~30 | (לפי defaults) + product-cta | + meta-box מחיר |
| stands-storage | B | 1 | ~30 | + product-cta | + meta-box מחיר |
| stand-floor | B | 1 | ~30 | + product-cta | + meta-box מחיר |
| repair | B | 1 | ~30 | + product-cta | + meta-box מחיר |
| shop | B | 1 | ~4 | bookcard×7 (ריצה-דינמית) | ראו הערת shop* |
| books (muzza) | B | 1 | ~30 | bookcard×5 | |
| vekatavta | B | 1 | ~35 | reveals×7, gallery×5 | + שדה `price` |
| kushi-blantis | B | 1 | ~35 | (לפי defaults) | + שדה `price` |
| tsva-bekahol | B | 1 | ~35 | (לפי defaults) | + שדה `price` |
| faq | B | 1 | ~6 | — | faqblock=CPT (לא-שדה) |
| contact | B | 0–1 | ~5 (phero בלבד) | — | הטופס=CF7, אין `sections` args |

\* **shop-defaults.php** בונה את פריטי ה-bookcard **בזמן ריצה** מ-`ea_product_price` postmeta של כל עמוד מוצר; לכן עריכת ה-shop = עריכת המחירים דרך meta-box (§ LOD400) + עריכת ה-phero. אין צורך ב-slot-repeater ל-shop.

**סה"כ:** ~18 קבוצות-שדות free-ACF חדשות (1 method + ~16 מסלול-B) + הרחבת `ea_chapters_repeater_specs()` למודע-סוג + overlay יחיד למסלול-B + meta-box מחיר. שטח גדול אך **חזרתי ומונחה-נתונים** — ראו אלגוריתם הרישום ב-LOD400 §4 שמצמצם את זה לרכיב-רישום גנרי אחד.

---

## 5. מה נשאר ל-LOD400 (המימוש)
1. קבצי רישום (`inc/chapters/acf-fields-inner.php` + הרחבת/קובץ method) ואלגוריתם הרישום המונחה-נתונים.
2. חוזה שמות שדה/מפתח מדויק + whitelist ארגים-לעריכה לכל `part`.
3. accessors חדשים + overlay למסלול-B + עריכות התבניות (`tpl-chapters-page.php`, `tpl-chapters-mokesh.php`).
4. `ea_chapters_repeater_specs()` מודע-סוג (פותר התנגשות `whom_items`/`testi_items`).
5. meta-box מחיר (`ea_product_price`) + שורות `require` ב-functions.php/bootstrap.
6. טבלאות שדה per-page + AC מדידים + צעדי-אימות + תלות (S4-01, S4-04).


<!-- HANDOFF-FOOTER v1 -->

## הנדאוף לחבילה הבאה (חובה — הצוות המבצע / team_110)

- **חבילה נוכחית:** WP-S4-05 (LOD300)
- **הבאה בתור (`next_wp`):** WP-S4-05 (LOD400 build) — לאחר אישור מודל-השדות
- בסיום `L-GATE_BUILD PASS`: הפק הנדאוף קאנוני דרך `/AOS_handoff` (hub prompt-generate API — `type=onboard_agent`, `mode=handoff`, `team_id=110`, `wp_id` של הבאה בתור, `gate_state=gate_done`), כתוב את `artifact_markdown` verbatim ל-`_COMMUNICATION/team_110/HANDOFF_SELF_*_2026-07-XX_v1.md`, והצג את `activation_block` **inline בצ'אט** ל-team_00 (נמרוד) לניתוב ויצירת הסשן הבא.
- **אל תתחיל את החבילה הבאה אוטומטית** — עצור והמתן לניתוב team_00.
- פרוטוקול מלא + שרשרת הביצוע: `_COMMUNICATION/team_100/S004/S004-PACKAGE-SEQUENCE-INDEX-2026-07-15.md` §8.
