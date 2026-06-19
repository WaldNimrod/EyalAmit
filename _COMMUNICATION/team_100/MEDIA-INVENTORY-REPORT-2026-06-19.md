# Media Inventory — EyalAmit.co.il-2026

**Date:** 2026-06-19 · **Author:** team_100 · **Source:** 6-agent audit workflow (wf_ecb59c31-65d) over the live theme `ea-eyalamit`.
**Scope:** every CONTENT + BACKGROUND image/video + per-page gallery. **Excludes** design-template chrome (logo, icons, decorative dividers, gradients) — 15 chrome items were filtered out.

**Totals:** 38 media items · 18 already have an asset · 11 placeholders · 9 need a new image · 11 galleries · 5 videos.

> Drives the client **media-intake** hub page (`hub/dist/media-intake.html`) + its `eyal-media-intake` JSON export. IDs here == IDs there == implementation keys.

## דף הבית — `/` (3)

| # | ID | סוג | סטטוס | גלריה | תיאור מה אמור להיות | מקור נוכחי |
|---|----|-----|-------|-------|----------------------|------------|
| 1 | `MED-HOME-01` | וידאו רקע (Hero) | ✅ יש נכס | — | וידאו רקע מושתק בלולאה לראש הדף: אייל מנגן בדיג׳רידו בסטודיו / תקריב נשימה ותנועת הכלי, … | /site/wp-content/themes/ea-eyalamit/assets/video/ea-home-… |
| 2 | `MED-HOME-02` | סרטון | 🔴 דרוש חדש | — | סרטון הסבר קצר (SECTION 03 'וידאו') שמציג מה זה טיפול בנשימה באמצעות דיג׳רידו — אייל מסב… | none / placeholder — slot documented but no embed rendered |
| 3 | `MED-HOME-03` | דיוקן | ✅ יש נכס | — | דיוקן אייל עמית לצד טקסט הביוגרפיה — תמונה אנכית (4:5) של אייל, רצוי בהקשר של נגינה/סטוד… | /site/wp-content/themes/ea-eyalamit/assets/images/eyal-po… |

## טיפול בדיג'רידו — `/treatment` (2)

| # | ID | סוג | סטטוס | גלריה | תיאור מה אמור להיות | מקור נוכחי |
|---|----|-----|-------|-------|----------------------|------------|
| 1 | `MED-TREAT-01` | רקע Hero | 🔴 דרוש חדש | — | תמונת או וידאו רקע לראש עמוד הטיפול בנשימה באמצעות דיג׳רידו — אייל בסטודיו בפרדס חנה במה… | none (CSS linear-gradient placeholder; block-hero video s… |
| 2 | `MED-TREAT-02` | דיוקן | 🔴 דרוש חדש | — | פורטרט אמיתי של אייל עמית מטפל בנשימה באמצעות דיג׳רידו בסטודיו — להחליף את גזיר העיתון ה… | site/wp-content/themes/ea-eyalamit/assets/images/eyal-por… |

## סאונד הילינג — `/sound-healing` (2)

| # | ID | סוג | סטטוס | גלריה | תיאור מה אמור להיות | מקור נוכחי |
|---|----|-----|-------|-------|----------------------|------------|
| 1 | `MED-SOUND-01` | רקע Hero | 🔴 דרוש חדש | — | תמונת או וידאו רקע לראש עמוד סאונד הילינג — חלל הסטודיו המוחשך באור נרות, ערסלים/מזרנים … | none (CSS linear-gradient placeholder; block-hero video s… |
| 2 | `MED-SOUND-02` | דיוקן | 🔴 דרוש חדש | — | פורטרט אמיתי של אייל עמית מנגן בדיג׳רידו במהלך מפגש סאונד הילינג בסטודיו — להחליף את גזי… | site/wp-content/themes/ea-eyalamit/assets/images/eyal-por… |

## שיעורי נגינה בדיג'רידו — `/lessons` (2)

| # | ID | סוג | סטטוס | גלריה | תיאור מה אמור להיות | מקור נוכחי |
|---|----|-----|-------|-------|----------------------|------------|
| 1 | `MED-LESSON-01` | רקע Hero | 🔴 דרוש חדש | — | תמונת או וידאו רקע לראש עמוד שיעורי נגינה — אייל מלמד תלמיד נגינה בדיג׳רידו אחד-על-אחד ב… | none (CSS linear-gradient placeholder; block-hero video s… |
| 2 | `MED-LESSON-02` | דיוקן | 🔴 דרוש חדש | — | פורטרט אמיתי של אייל עמית מלמד נגינה בדיג׳רידו בשיעור פרטי בסטודיו — להחליף את גזיר העית… | site/wp-content/themes/ea-eyalamit/assets/images/eyal-por… |

## אודות — אייל עמית — `/eyal-amit` (6)

| # | ID | סוג | סטטוס | גלריה | תיאור מה אמור להיות | מקור נוכחי |
|---|----|-----|-------|-------|----------------------|------------|
| 1 | `MED-ABOUT-01` | דיוקן | ✅ יש נכס | — | דיוקן ראשי של אייל עמית — תמונת פנים/חצי-גוף איכותית, אנכית, לכותרת עמוד האודות. | site/wp-content/themes/ea-eyalamit/assets/images/eyal-por… |
| 2 | `MED-ABOUT-02` | תמונת תוכן | ✅ יש נכס | — | כריכת הספר ״צבע בכחול וזרוק לים״ של אייל עמית. | site/wp-content/themes/ea-eyalamit/assets/images/tsva-bec… |
| 3 | `MED-ABOUT-03` | תמונת תוכן | ✅ יש נכס | — | כריכת הספר ״כושי בלאנטיס״ של אייל עמית. | site/wp-content/themes/ea-eyalamit/assets/images/kushi-bl… |
| 4 | `MED-ABOUT-04` | תמונת תוכן | ✅ יש נכס | — | כריכת הספר ״וכתבת״ של אייל עמית. | site/wp-content/themes/ea-eyalamit/assets/images/vekatavt… |
| 5 | `MED-ABOUT-05` | תמונת תוכן | ✅ יש נכס | — | צילום רחב של הסטודיו בפרדס חנה — המרחב, החצר הירוקה ושבילי העץ. | site/wp-content/themes/ea-eyalamit/assets/images/hero-wid… |
| 6 | `MED-ABOUT-06` | דיוקן | 🟡 placeholder | — | דיוקן/תמונת אווירה של אייל לבלוק ביוגרפיה — נופל לפלייסהולדר חול אם אין תמונה. | placeholder (sand fallback) |

## עמוד הנצחה — מוקש דהימן — `/eyal-amit/mokesh-dahiman` (4)

| # | ID | סוג | סטטוס | גלריה | תיאור מה אמור להיות | מקור נוכחי |
|---|----|-----|-------|-------|----------------------|------------|
| 1 | `MED-MOKESH-01` | וידאו רקע (Hero) | ✅ יש נכס | — | טריילר הסרט ״MUKESH – The Art of Shanti Living״ — וידאו פתיחה בראש דף ההנצחה, מתנגן מושת… | https://www.youtube.com/watch?v=kf4NKSdYi9E (trailer, embed) |
| 2 | `MED-MOKESH-02` | גלריה | ✅ יש נכס | 19 פריטים | גלריית 19 תצלומים של מוקש דהימן ובית המלאכה ברישיקש (Jungle Vibes) — בסדר המקורי המדויק … | wp-content/uploads/2021/10/ (18 photos) + 2025/08/ (#14);… |
| 3 | `MED-MOKESH-03` | סרטון | 🔴 דרוש חדש | — | הסרט המלא ״MUKESH – The Art of Shanti Living״ (כשעה, מאת אייל וגיא עמית) — לצפייה מלאה ב… | none |
| 4 | `MED-MOKESH-04` | סרטון | ✅ יש נכס | 4 פריטים | ארבעה עמודי פייסבוק מוטמעים בתחתית הדף — פוסטים לזכר מוקש דהימן (תמונות/וידאו/טקסט מקורי… | 4 FB posts via facebook.com/plugins/post.php (IsraelDidgC… |

## חנות / ספרים — `/shop` (13)

| # | ID | סוג | סטטוס | גלריה | תיאור מה אמור להיות | מקור נוכחי |
|---|----|-----|-------|-------|----------------------|------------|
| 1 | `MED-SHOP-01` | תמונת מוצר | 🟡 placeholder | 5 פריטים | 5 תמונות כרטיס-מוצר לחנות — תמונה ראשית אחת לכל קטגוריה: כלים, תיקים, סטנדים לאחסון, סטנ… | placeholder (span.ea-shop-card__media--placeholder, grey,… |
| 2 | `MED-SHOP-02` | גלריה | 🟡 placeholder | 6 פריטים | גלריית 6 תמונות של כלי דיגרידו בעבודת יד למכירה — צילומי הכלים מזוויות שונות, פרטי גימור… | placeholder (grey tiles; intro 'תמונות של הכלים יתווספו ב… |
| 3 | `MED-SHOP-03` | גלריה | 🟡 placeholder | 6 פריטים | גלריית 6 תמונות של תיקים לדיגרידו בשימוש יומיומי — בשטח, בדרך ובסטודיו, כולל איך הכלי יו… | placeholder (grey tiles) |
| 4 | `MED-SHOP-04` | גלריה | 🟡 placeholder | 6 פריטים | גלריית 6 תמונות של סטנדים מעץ בעבודת יד לאחסון דיגרידו — תלייה על הקיר ועמידה רצפתית, בש… | placeholder (grey tiles; intro 'תמונות של הסטנדים בשימוש … |
| 5 | `MED-SHOP-05` | גלריה | 🟡 placeholder | 6 פריטים | גלריית 6 תמונות של סטנד רצפתי לנגינה בדיגרידו בישיבה נמוכה — הסטנד עם כלי משוחל בתוכו, מ… | placeholder (grey tiles; intro 'תמונות של הסטנד בשימוש ית… |
| 6 | `MED-SHOP-06` | גלריה | 🟡 placeholder | 6 פריטים | גלריית 6 תמונות מבית המלאכה — כלי דיגרידו בתהליך תיקון וחידוש, סדקים ושברים לפני ואחרי, … | placeholder (grey tiles; intro 'תמונות של כלים בתהליך תיק… |
| 7 | `MED-SHOP-07` | תמונת מוצר | ✅ יש נכס | 3 פריטים | 3 כריכות ספרים של אייל עמית בכרטיסי המוצר: צבע בכחול וזרוק לים, כושי בלאנטיס, וכתבת. | theme: tsva-bechol-cover.jpg, kushi-blantis-cover.jpg, ve… |
| 8 | `MED-SHOP-08` | תמונת מוצר | ✅ יש נכס | 3 פריטים | ויזואל חבילת 3 הספרים — שלוש הכריכות בערימה משוכבת (אותן כריכות מהכרטיסים). | theme: tsva-bechol-cover.jpg, kushi-blantis-cover.jpg, ve… |
| 9 | `MED-SHOP-09` | תמונת מוצר | ✅ יש נכס | — | כריכת הספר צבע בכחול וזרוק לים בגודל גדול בהירו של עמוד הספר. | theme: assets/images/tsva-bechol-cover.jpg |
| 10 | `MED-SHOP-10` | תמונת מוצר | ✅ יש נכס | — | כריכת הספר כושי בלאנטיס בגודל גדול בהירו של עמוד הספר. | theme: assets/images/kushi-blantis-cover.jpg |
| 11 | `MED-SHOP-11` | תמונת מוצר | ✅ יש נכס | — | כריכת הספר וכתבת בגודל גדול בהירו של עמוד הספר. | theme: assets/images/vekatavt-cover.jpg |
| 12 | `MED-SHOP-12` | גלריה | 🟡 placeholder | 4 פריטים | גלריית 'מהעולם של הספר' — תמונת פתיחה אחת קיימת (אייל באיטליה) ועוד 3 תמונות חסרות (פנים… | theme: kushi-02-eyal-italy.jpg (lead, hardcoded for all 3… |
| 13 | `MED-SHOP-13` | רקע אזור | ✅ יש נכס | — | תמונת באנר רקע לראש מרכז הספרים (מוזה הוצאה לאור) — דיוקן שחור-לבן של אייל עמית כסופר ומ… | theme CSS url(../images/books-hero.jpg) |

## בלוג — `/blog` (3)

| # | ID | סוג | סטטוס | גלריה | תיאור מה אמור להיות | מקור נוכחי |
|---|----|-----|-------|-------|----------------------|------------|
| 1 | `MED-BLOG-01` | תמונת תוכן | 🟡 placeholder | — | תמונה ראשית 16:9 לכל כרטיס פוסט בבלוג — תמונה מייצגת לתוכן הפוסט; פוסט ללא תמונה מציג רק… | WP featured image (the_post_thumbnail medium_large); CSS … |
| 2 | `MED-BLOG-02` | תמונת תוכן | 🟡 placeholder | — | תמונה ראשית גדולה בראש כל פוסט — תמונת נושא לפוסט; פוסט ללא תמונה מציג רקע גרדיאנט מעוצב. | WP featured image (the_post_thumbnail large); CSS gradien… |
| 3 | `MED-BLOG-03` | תמונת תוכן | 🟡 placeholder | — | תמונות בתוך גוף הפוסט (אם קיימות) — תלויות בתוכן שהוזן בכל פוסט; מנוהלות דרך עורך וורדפרס. | WP post_content (uploads/CMS) — variable per post |

## צור קשר — `/contact` (1)

| # | ID | סוג | סטטוס | גלריה | תיאור מה אמור להיות | מקור נוכחי |
|---|----|-----|-------|-------|----------------------|------------|
| 1 | `MED-CONTACT-01` | רקע אזור | 🔴 דרוש חדש | — | עמוד צור קשר — אין בו כיום אף תמונת תוכן או רקע. סלוט אפשרי לתמונת אווירה (למשל הסטודיו … | none (form + WhatsApp text-pill CTA only; no img/video/ba… |

## שאלות נפוצות — `/faq` (1)

| # | ID | סוג | סטטוס | גלריה | תיאור מה אמור להיות | מקור נוכחי |
|---|----|-----|-------|-------|----------------------|------------|
| 1 | `MED-FAQ-01` | אחר | 🟡 placeholder | — | קטלוג שאלות — תמונות ממוזערות מושבתות במפורש (show_thumb=false). אין סלוט תמונה פעיל; או… | none (show_thumb=false; thumbnails disabled) |

## דף נחיתה (אנגלית) — `/en` (1)

| # | ID | סוג | סטטוס | גלריה | תיאור מה אמור להיות | מקור נוכחי |
|---|----|-----|-------|-------|----------------------|------------|
| 1 | `MED-EN-01` | תמונת תוכן | ✅ יש נכס | 3 פריטים | שלוש כריכות הספרים של אייל עמית (הוצאת מוזה): צבע בכחול וזרוק לים, כושי בלאנטיס, וכתבת —… | theme: tsva-bechol-cover.jpg, kushi-blantis-cover.jpg, ve… |
