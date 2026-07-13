---
id: WP-CANON-TEMPLATE-UNIFICATION-LOD200-2026-07-12
from_team: team_100
to_team: team_00
date: 2026-07-12
type: wp-scoping
wp: WP-CANON-TEMPLATE-UNIFICATION
lod_status: LOD200
authorized_by: "team_00 (נמרוד) — item 1 of 2026-07-12 directive: 'זה חייב להפוך לחבילת עבודה קאנונית מנוהלת לביצוע סטנדרטיזציה מלאה של כלל תבניות וממשקי האתר'"
---

# LOD200 — WP-CANON: סטנדרטיזציה מלאה של תבניות האתר (Wave2 → Chapters)

## 1. הבעיה (Why)

האתר מריץ שתי מערכות תבניות מקבילות שהתפתחו במקביל: **"Wave2"** (הישנה, `template-parts/blocks/`, `page-templates/tpl-service.php` וכו') ו-**"Chapters"** (החדשה, `template-parts/chapters/`, `inc/chapters/defaults/*.php`). Chapters מנצחת בניתוב (`template_include` עדיפות 103) בכמעט כל עמוד; Wave2 נשארה חיה בפועל רק ב-`/shop`, עמודי מוצר בודדים, ו-`/qr`.

זה לא רק "חוב טכני" תיאורטי — זו **הסיבה השורשית** לרוב הפערים שהתגלו בהשוואה מול מסמכי אייל (12/7/2026): מנגנון FAQ מרוכז-לפי-קטגוריה, Product schema + תבנית מוצר עם מחיר/CTA, ווידאו+גלריה+Schema מלאים לעמוד ההנצחה למוקש — **כולם כבר קיימים, בנויים ומאומתים**, פשוט קבורים בקוד Wave2 המת. מלבד זאת, יש סתירות התנהגות בין שתי המערכות (target=_blank לא עקבי, קישורי תפריט מתים, footer שונה) שגורמות לבאגים אמיתיים.

## 2. מטרה

תבנית אחת מחייבת (Chapters) לכל האתר, ללא יוצא מן הכלל, כולל `/shop` ו-`/qr`. אפס קוד כפול. QA מלא לאחר האיחוד. אימות שממשק העריכה של אייל (page-review.html / media-intake.html / content-intake.html) עדיין תקין ומצביע לשדות הנכונים.

## 3. היקף (מסודר בסדר ביצוע נכון — Port ואז Delete)

| # | משימה | פירוט | תלות |
|---|---|---|---|
| T1 | Port — מוקש | טריילר YouTube (`kf4NKSdYi9E`) + גלריית 19 תמונות + 4 הטמעות פייסבוק + VideoObject schema, מ-`inc/wave2-w2-14e.php` אל `mokesh-defaults.php`, בעזרת `parts/videoblk.php` + `parts/gallery.php` הקיימים. + בניית Person schema למוקש (חדש - לא קיים באף גרסה). | אין |
| T2 | Port — FAQ | חיבור יכולת הסינון-לפי-קטגוריה הקיימת (`faqblock.php` ה-`cat` arg) לכל 11 עמודי mini-FAQ, החלפת המערכים הכפולים הידניים. **החלטת LOD-spec:** קטגוריה יחידה (זול) מול many-to-many (יקר יותר, תואם מדויק לדרישת team_00 6.6/6.16 — "כל שאלה מקושרת לקטגוריה אחת או יותר"). | אין |
| T3 | Port — תבנית מוצר | מחיר + CTA לרכישה (GreenInvoice/WhatsApp) + גלריה, מ-`tpl-shop-item.php`+`wave2-w2-05.php` אל עמודי Chapters (`didgeridoos`, `bags`, `stands-storage`, `stand-floor`, `repair`). | אין |
| T4 | Schema חדש | FAQPage (על גבי T2), Book (על כל 3 עמודי הספרים) — לא קיימים כלל, לא רק "לא מנותבים". | T2 |
| T5 | איחוד `/shop` + `/qr` | ה-routes האחרונים שעדיין על Wave2 בפועל. | T1-T3 |
| T6 | מחיקת Wave2 | כל `tpl-service.php`, `template-treatment.php`, `template-method.php`, `tpl-faq.php`, `template-faq-catalog.php`, `tpl-shop-item.php`, `tpl-shop-archive.php`, `tpl-contact.php`, `tpl-home.php`, `template-home-dashboard.php`, ו-`inc/wave2-w2-*.php` שהופכים מיותרים — רק לאחר וידוא אחד-אחד שאין תלות חיה. | T1-T5 |
| T7 | QA מלא | קישורים שבורים, עקביות, target=_blank אחיד, וממשק אייל תקין אחרי האיחוד. | T6 |

## 4. החלטות פתוחות לשלב ה-Spec (LOD400)

1. **FAQ: קטגוריה יחידה מול many-to-many** — עלות/תועלת אמיתית, ר' T2.
2. **סדר מחיקה מדויק** — לוודא בקוד (לא רק בהנחה) שאין page עדיין מוקצה ל-template ש-Wave2-בלבד לפני מחיקה.
3. **`/shop` ו-`/qr`** — האם יש שם תוכן/פיצ'רים ספציפיים שלא קיימים היום ב-Chapters שצריך קודם לבנות (heavier lift מהשאר, כי הם היחידים שעדיין "חיים" ב-Wave2 היום).

## 5. Builder / Validator (מוצע)

- **Builder:** team_110 (Domain Architect) — תואם את התקדים ב-WP-W2-17 (תכנית remediation מקיפה דומה בהיקפה).
- **Validator:** team_90 (full-site audit, אותו תהליך CR-FINAL) + team_190 (constitutional). Cross-engine מ-team_110 (builder) per Iron Rule #1.

## 6. אימות סיום

`qa_probe.mjs` מלא (קישורים/הרשאות/responsive) + `content-diff.mjs` על כל עמוד שעבר port (לוודא 0% דריפט תוכן במהלך המעבר) + בדיקה ידנית של page-review.html/media-intake.html.

---

*נכתב על ידי team_100 · 2026-07-12 · מקור: `DETAILED-DIFF-EYAL-QA-SEO-VS-CURRENT-SITE-2026-07-12.md`*
