---
id: WAVE2-WP-LOD200-2026-05-26
title: חבילות עבודה Wave2 — LOD200 מלא
status: APPROVED for execution
date: 2026-05-26
profile: L2
authored_by: team_100
approved_by: nimrod (team_00) + eyal (CEO)
parent_decision: _COMMUNICATION/team_00/DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md
goals_anchor: F3 — implementation order accepted, LOD200 mandate
total_estimate: 36-50 ימי עבודה (תלוי בקיבולת)
---

# Wave2 Work Packages — LOD200

## 0. מבוא ותקני LOD200

לפי דרישת אייל בפגישת 2026-05-26 (F3): **חבילות עבודה קנוניות במפת הדרכים כולל LOD200 מלא**.

**LOD200** במסגרת פרויקט זה כולל לכל WP:
- **ID + שם** קנוני
- **מטרה** — תוצאה מדידה
- **סקופ — IN** (מה כלול)
- **סקופ — OUT** (מה לא כלול)
- **תלויות** (קודמים)
- **תוצרים** (deliverables)
- **AC — Acceptance Criteria** (≥3 קריטריוני קבלה מדידים)
- **בעלים** (צוות אחראי)
- **שותפים** (תלות צוותית)
- **אומדן** (ימי עבודה)
- **סיכון + הקלה**
- **מפת קישורים** (קבצי מקור)

עיקרון: WPs ניתנים לעבודה מקבילית היכן שאין תלות הדדית. סדר תלויות מצוין מפורשות.

---

## WP-W2-01 — תשתית עיצוב D-14 + טופס + פוטר + Analytics

> **🟢 הרחבת סקופ 2026-05-26** (לפי Combo C — Atoms-first LOD400):
> WP זה מתרחב לכלול **גם LOD400 design system spec מלא** עבור כל ה-atoms / blocks / patterns / templates שיוצרכו בכל 9 ה-WPs. מסמך זה הופך לחוסם של כל WP אחר. ראו `5.0 שלב Atoms-First LOD400` למטה.

### מטרה
הנחת בסיס טכני־עיצובי שעליו ייבנו כל 8 ה-WPs האחרים: **LOD400 design system spec מלא** + design tokens D-14, מערכת אנימציות נושמות, טופס צור קשר עובד, פוטר עם רשתות חברתיות, ומנגנון A/B testing למדידה.

### Scope — IN

**A. שלב Atoms-First LOD400 (חוסם — לפי Combo C):**
1. **Atom Inventory Scan** — סריקת 16 עמודים + 54 פוסטי בלוג → רשימה ממוצה של ~25-30 atoms ייחודיים: Hero variants, intro blocks, content sections, gallery, faq-filtered, testimonials (text+image+link), cta-pill, breath-divider, video-frame, sound-toggle, social-footer, blog-card, blog-archive, product-card, price-display, green-invoice-cta, whatsapp-cta, contact-form-cf7, breadcrumb, ועוד. (1-2 ימים)
2. **LOD400 Design System Spec** — מסמך 25-30 עמודים: tokens (colors/typography/spacing), כל atom (HTML structure + CSS + states + a11y + responsive + reduced-motion), composition rules. תוצר: `_COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-XX-XX.md`. (2-3 ימים)
3. **POC validation** — דמו עמוד 1 שמורכב מ-atoms (מומלץ: דף הבית או טיפול). אישור nimrod. (0.5-1 יום)

**B. שלב יישום (אחרי A מאושר):**

1. **D-14 design tokens** ב-`assets/css/ea-tokens.css`: CSS variables לכל הפלטה, טיפוגרפיה Heebo, animations system, breathing primitives (keyframes משותפים), `prefers-reduced-motion` fallback מלא.
2. **תבניות אקורדיון / עדויות / FAQ filter** כ-Gutenberg blocks או PHP partials ב-child theme.
3. **טופס צור קשר**: התקנת Contact Form 7 + WP Mail SMTP חינמי. הגדרת שדות לפי B1+B2. חיבור MX לגוגל ל-`info@eyalamit.co.il`. **אייל יזין סיסמת SMTP בעצמו**.
4. **CTA וואטסאפ — 3 וריאנטים** (B3): variant_A (טופס בלבד), variant_B (כפול), variant_C (וואטסאפ בלבד). הקצאה אקראית per-session + GA4 event.
5. **פוטר**: לוגו + אייקוני רשת (FB, IG, YT — **URLs התקבלו 2026-05-26, מקור: [`hub/data/social-channels.json`](../../hub/data/social-channels.json)**; TT — אייקון לא מוצג עד לקבלת URL), מיקום הסטודיו, זכויות שמורות, link to /faq.
6. **Analytics**: GA4 + Microsoft Clarity (חינמי, מספק heatmaps). הטמעה דרך `wp_head` hook.
7. **כפתורי אקסס** (פתיחת/השתקת מוזיקה) כקומפוננטות משותפות.

### Scope — OUT
- תוכן עמודים (זה ב-WP-W2-02+).
- Hero סופי עם וידאו (יכנס כשאייל מספק; placeholder כעת).
- תרגום EN (זה ב-WP-W2-08).
- בלוג (זה ב-WP-W2-06).

### תלויות
- אין (זה ה-WP הראשון).
- מותנה בקבלת URLs מאייל (FB/IG/YT/TT) — אם מתעכב, פוטר משוחרר עם placeholder `#`.

### תוצרים
- `child-theme/assets/css/ea-tokens.css`
- `child-theme/assets/css/ea-animations.css` (breathing keyframes + reduced-motion)
- `child-theme/assets/js/ea-ab-testing.js`
- `child-theme/partials/footer-social.php`
- `child-theme/partials/contact-form.php` (CF7 shortcode wrapper)
- `child-theme/inc/analytics.php` (GA4 + Clarity tracking)
- מדריך הזנת סיסמת SMTP לאייל (`docs/onboarding/SMTP-EYAL-INSTRUCTIONS.md` — docx export)

### Acceptance Criteria
- [ ] AC-01: CSS variables נטענים ב-3 דפי test, אומתו בכלי dev tools.
- [ ] AC-02: `prefers-reduced-motion: reduce` מבטל את כל ה-breathing animations (אימות מערכת + browser test).
- [ ] AC-03: שליחת טופס דמה מגיעה ל-`info@eyalamit.co.il` (אחרי שאייל הזין סיסמה).
- [ ] AC-04: GA4 event מתועד עם variant_label (A/B/C) ב-Real-Time report בעת קליק על CTA.
- [ ] AC-05: Clarity מקליט session, heatmap נטען.
- [ ] AC-06: פוטר נראה תקין במובייל ודסקטופ, 4 אייקוני רשת קליקביליים.
- [ ] AC-07: validate_aos.sh עובר 0 FAIL ב-WP.

### בעלים + שותפים
- **בעלים:** team_10 (יישום WP)
- **שותפים:** team_80 (D-14 tokens, צריך אישור final), team_20 (התקנת plugins), team_50 (QA), team_90 (validation)

### אומדן
**8-11 ימי עבודה** (הורחב לפי Combo C):
- שלב A (Atoms-first LOD400): Atom inventory (1.5) + LOD400 spec (2.5) + POC (1) = **5 ימים**
- שלב B (יישום): D-14 tokens (1) + טופס (1.5) + Analytics (1) + פוטר (0.5) + QA (1-2) = **5-6 ימים**

**הערה:** למרות שזה ארוך יותר מ-W2-01 המקורי, ה-LOD400 כאן חוסך 1-3 ימים בכל WP אחר → חיסכון נטו של ~10-20 ימים על כל ה-Wave2.

### סיכון + הקלה

| סיכון | חומרה | הקלה |
|--------|--------|------|
| אייל לא יזין סיסמת SMTP בזמן | בינוני | טופס משלוח דרך WP-default (`wp_mail()`) עד שאייל יזין |
| TikTok URL לא מסופק | נמוך | 3/4 התקבלו ואומתו (FB/IG/YT live 200). TT לא יוצג עד שיגיע. |
| GA4 דורש זיהוי בעלות דומיין | נמוך | אייל מאשר ownership או נימרוד מטפל |
| D-14 לא נסגר מהר מספיק בצוות 80 | בינוני | התחלת WP-W2-02 עם D-13 + פאטץ' מאוחר |

### מפת קישורים
- D-13 base: [D-EYAL-DESIGN-STYLE-13](_COMMUNICATION/team_80/D-EYAL-DESIGN-STYLE-13-DECISION-PACKAGE-2026-04-07.md)
- D-14 spec: [D-EYAL-DESIGN-DIRECTION-FBW-DEEP](_COMMUNICATION/team_100/D-EYAL-DESIGN-DIRECTION-FBW-DEEP-2026-05-26.md)
- Child theme: `site/wp-content/themes/ea-eyalamit/`
- Color palette: `docs/project/EYAL-SITE-COLOR-PALETTE.md`

---

## WP-W2-02 — ליבת תוכן: בית + שיטה + טיפול + אודות + FAQ + צור קשר

### מטרה
6 עמודי ליבת המוצר חיים בסטייג'ינג עם תוכן מ-25.5.26, מעוצבים ב-D-14, נגישים, וקריאים לאייל לבחינה.

### Scope — IN
- **דף הבית** — 12 בלוקים לפי [`homepage1-3 v2.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/דף%20הבית/homepage1-3%20v2.md). Hero=C עם placeholder אנימציה עד שאייל מספק וידאו.
- **השיטה — cbDIDG** — 12 בלוקים לפי [`method.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/השיטה/method.md).
- **טיפול בדיג'רידו** — 10 בלוקים לפי [`treatment.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/טיפול%20בדיג'רידו/treatment.md).
- **אודות אייל** (`/about`) — מיגרציה 1:1 מהאתר הישן (slug "אייל-עמית-אודות"). הוספת sub-link ל-`/about/moksha`.
- **FAQ** (`/faq`) — אחוד מ-[`FAQ FINAL.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/דף%20FAQ/FAQ%20FINAL.md): 4 קטגוריות, ~36 שאלות, מערכת תגיות + קטגוריות.
- **צור קשר** (`/contact`) — שיבוץ הטופס מ-WP-W2-01.

### Scope — OUT
- ספרים (WP-W2-03), שיעורים/סאונד (WP-W2-04), שופ (WP-W2-05), בלוג (WP-W2-06), כתבות (WP-W2-07), EN (WP-W2-08).
- Hero וידאו אמיתי — placeholder ב-CSS עד שאייל מספק.
- עדויות FB מיושמות בפועל — דורש WP-W2-07 (חילוץ + image-fetch).

### תלויות
- ⬛ **חוסם:** WP-W2-01 חייב להיות PASS (tokens, טופס, פוטר, analytics).

### תוצרים
- 6 עמודי WP פעילים בסטייג'ינג.
- ייבוא תוכן 25.5.26 ל-WP DB (`wp_posts` + `wp_postmeta`).
- FAQ taxonomy: קטגוריות (`faq_category`) + תגיות (`faq_tag`).
- FAQ filter UI ב-`/faq` + view-only embed snippet לעמודי שירות.
- 301 redirect מ-slug ישן של `אייל-עמית-אודות` ל-`/about` (לפי tool 301).

### Acceptance Criteria
- [ ] AC-01: 6 עמודי URL בסטייג'ינג מחזירים 200, נטענים תוך < 3s.
- [ ] AC-02: H1 בכל עמוד תואם 1:1 לטקסט ב-25.5.26.
- [ ] AC-03: FAQ filter עובד — קליק בקטגוריה מסנן 8-10 שאלות; URL state מתעדכן (`?cat=treatment`).
- [ ] AC-04: עמוד `/about` כולל קישור ל-`/about/moksha` (אפילו אם המוקש עצמו ב-WP-W2-07).
- [ ] AC-05: Lighthouse mobile ≥ 85 (performance), ≥ 95 (accessibility) על דף הבית.
- [ ] AC-06: Hero placeholder אנימציה רץ; כפתור CTA מקשר ל-`/contact`.
- [ ] AC-07: כל הקישורים הפנימיים פעילים (אימות `link-checker`).

### בעלים + שותפים
- **בעלים:** team_10 + team_30 (תוכן)
- **שותפים:** team_80 (D-14 שיבוץ blocks), team_50 (QA), team_40 (מדיה — תמונות הסטודיו)

### אומדן
**7-10 ימי עבודה** — דף בית (3-4) + שיטה (1.5) + טיפול (1.5) + אודות (1) + FAQ עם filter (2-3) + צור קשר אינטגרציה (0.5).

### סיכון + הקלה

| סיכון | חומרה | הקלה |
|--------|--------|------|
| FAQ taxonomy מעורר תקלות (תגיות+קטגוריות בו זמנית) | בינוני | POC נפרד ב-WP-W2-01.5 (15 דק' אובחנה לפני יישום) |
| תוכן 25.5.26 דורש editing קל (typo, format) | נמוך | flag הערה, לא לעדכן בלי אישור |
| תמונת Hero חסרה — placeholder לא משכנע | בינוני | breathing lines + gradient ink בלבד, ללא תמונה |

### מפת קישורים
- Decision: [E1 SSOT cascade](_COMMUNICATION/team_00/DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md#21-content-ssot-cascade)
- אודות אייל מקור: `https://www.eyalamit.co.il/אייל-עמית-אודות/` (אומת live 200)

---

## WP-W2-03 — מוזה הוצאה לאור + 3 עמודי ספרים

### מטרה
עמוד הקטלוג `/books` + 3 עמודי ספר (וכתבת, כושי בלאנטיס, צבע בכחול וזרוק לים) פעילים בסטייג'ינג עם כל המידע + כפתור Green Invoice חיצוני.

### Scope — IN
- **`/books`** — קטלוג לפי [`MUZZA.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/מוזה%20הוצאה%20לאור%20-%20ספרים/MUZZA.md). 12 בלוקים: header, hero, intro, על אייל, למה כאן, 3 כרטיסי ספר, חבילת bundle (כבלוק, לא דף נפרד), 3 עולמות, CTA רכישה, משלוח, סגירה.
- **`/books/vekatavta`** — לפי [`vekatavta.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/וכתבת/vekatavta.md). 14 בלוקים.
- **`/books/kushi-blantis`** — לפי [`kushi_full.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/כושי%20בלאנטיס/kushi_full.md). 14 בלוקים.
- **`/books/tsva-bekahol`** — לפי [`eyal_tsva_FINAL.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/צבע%20בכחול%20וזרוק%20לים/eyal_tsva_FINAL.md). 14 בלוקים.
- **תבנית `tpl-book-detail`** משותפת לכל ספר.
- כפתור Green Invoice לרכישה — קישור חיצוני per-book.

### Scope — OUT
- ספרים נוספים (אין כאלה ב-25.5.26).
- E-commerce/cart מקומי (אין — Green Invoice חיצוני).
- מוזה כקטגוריה בבלוג (זה WP-W2-06).

### תלויות
- ⬛ **חוסם:** WP-W2-02 (template system, D-14 blocks).

### תוצרים
- 4 עמודי WP פעילים (1 קטלוג + 3 ספרים).
- תבנית `tpl-book-detail.php`.
- 3 קישורי Green Invoice — לקבל מאייל בעת מימוש.
- כריכות הספרים — מיגרציה ממדיה ישנה (לבדוק `usage_count > 0`).

### Acceptance Criteria
- [ ] AC-01: 4 URLs פעילים, מחזירים 200.
- [ ] AC-02: כל ספר מציג: תקציר, קטע מתוך, על הספר, גלריה, רכישה (כפתור Green Invoice), למי מתאים, FAQ מסונן, כתבות (אם יש), CTA.
- [ ] AC-03: כפתור "רכישה" פותח Green Invoice בלשונית חדשה, עוקב GA4.
- [ ] AC-04: `/books` מציג כרטיסי 3 ספרים + bundle בלוק; כל כרטיס מקשר ל-`/books/<slug>`.
- [ ] AC-05: H1 וטקסט תואמים 1:1 ל-25.5.26.

### בעלים + שותפים
- **בעלים:** team_10
- **שותפים:** team_30 (תוכן), team_40 (גלריות), team_80 (תבנית visual), team_50 (QA)

### אומדן
**4-6 ימי עבודה** — תבנית (1) + 3 ספרים (1 כל אחד, 3) + קטלוג (1) + QA (1).

### סיכון + הקלה

| סיכון | חומרה | הקלה |
|--------|--------|------|
| קישורי Green Invoice לא מוכנים | נמוך | אייל אישר שיש קישור לדוגמה ב-C1; אפשר שלושה במקביל |
| כריכת ספר לא קיימת במדיה הישנה | בינוני | לבקש מאייל קובץ חדש; placeholder אפור |

### מפת קישורים
- Decision: [Q2 books model](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/MEETING-DECISIONS-2026-05-26.md)
- 4 קבצי תוכן ב-`תוכן לאתר 25.5.26/`

---

## WP-W2-04 — סאונד הילינג + שיעורי נגינה

### מטרה
2 עמודי שירות פעילים בסטייג'ינג עם תוכן 25.5.26.

### Scope — IN
- **`/sound-healing`** — 10 בלוקים לפי [`sound_healing_final.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/סאונדהילינג/sound_healing_final.md).
- **`/lessons`** — 10 בלוקים לפי [`lesons.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/שיעורי%20נגינה/lesons.md).
- שיבוץ FAQ view-only filtered לכל עמוד (כל אחד = קטגוריה משלו).
- שיבוץ עדויות "Top 5" + "אקורדיון לכל השאר".

### Scope — OUT
- עמוד "טיפול" — זה ב-WP-W2-02.
- עמוד "שיטה" — זה ב-WP-W2-02.

### תלויות
- ⬛ **חוסם:** WP-W2-02 (template `tpl-service`).
- 🟡 **לא חוסם, אבל מועיל:** WP-W2-07 (עדויות לפי תבנית סופית).

### תוצרים
- 2 עמודי WP פעילים.
- תבנית `tpl-service` מקובעת.

### Acceptance Criteria
- [ ] AC-01: 2 URLs פעילים, 200.
- [ ] AC-02: H1 וגוף תואמים 1:1 ל-25.5.26.
- [ ] AC-03: FAQ filter על עמוד שירות = רק שאלות הקטגוריה הזו.
- [ ] AC-04: עדויות מוצגות עם טקסט + תמונה + לינק (אפילו אם image=placeholder עד WP-W2-07).
- [ ] AC-05: כל CTA פעיל (טופס + וואטסאפ לפי וריאנט A/B).

### בעלים + שותפים
- team_10 + team_30 (תוכן). team_50 (QA).

### אומדן
**3-4 ימי עבודה** — כל עמוד ~1.5 ימים + QA.

---

## WP-W2-05 — שופ: 4 מוצרים + תיקון + עמוד `/shop` אחוד

### מטרה
5 עמודי מוצר/שירות + דף קטלוג שופ אחוד פעילים בסטייג'ינג, עם מחירים וכפתור Green Invoice.

### Scope — IN
- **`/didgeridoos`** — לפי [`buy didgeridoo.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/כלים%20למכירה/buy%20didgeridoo.md). 10 בלוקים.
- **`/bags`** — לפי [`bags for didg.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/תיקים%20לדיג'רידו/bags%20for%20didg.md). 10 בלוקים.
- **`/stands-storage`** — לפי [`stend for hanging.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/סטנדים%20לדיג'רידו%20לאחסון/stend%20for%20hanging.md). 10 בלוקים.
- **`/stand-floor`** — לפי [`stend for playing.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/סטנד%20רצפתי%20לנגינה%20בישיבה%20נמוכה/stend%20for%20playing.md). 10 בלוקים.
- **`/repair`** — לפי [`build didg.md`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/תיקון%20כלי%20דיג'רידו/build%20didg.md). 10 בלוקים.
- **`/shop`** — דף קטלוג אחוד עם 5 כרטיסי מוצר.
- תבנית `tpl-shop-item` משותפת.
- כפתור Green Invoice לרכישה / יצירת קשר.
- מחירים — מקור: אייל יזין דרך WP admin (C3).

### Scope — OUT
- WooCommerce / עגלה מקומית.
- מוצרים נוספים שאינם ב-25.5.26.

### תלויות
- ⬛ **חוסם:** WP-W2-02 (template + design tokens).
- 🟡 קבלת מחירים מאייל — אם לא, מציגים "מחיר לפי התאמה" עד שיוזן.

### תוצרים
- 5 עמודי מוצר + עמוד קטלוג `/shop`.
- תבנית `tpl-shop-item.php`.
- עדכון `site-tree.json` עם 6 נכסים חדשים.

### Acceptance Criteria
- [ ] AC-01: 6 URLs פעילים.
- [ ] AC-02: כל עמוד מוצר מציג: hero, מה זה, איך עובד/מאפיינים, למי מתאים, FAQ, המלצות (placeholder עד WP-W2-07), CTA רכישה/קשר.
- [ ] AC-03: מחיר מוצג בכרטיס הקטלוג + בעמוד המוצר.
- [ ] AC-04: כפתור רכישה → Green Invoice / טופס (לפי וריאנט A/B).
- [ ] AC-05: דף `/shop` רספונסיבי (4 cols desktop, 2 mobile).

### בעלים + שותפים
- team_10 + team_30. team_40 (תמונות מוצר אמיתיות, לא קטלוגיות).

### אומדן
**4-5 ימי עבודה** — תבנית (0.5) + 5 עמודים (3) + קטלוג (0.5) + QA (1).

---

## WP-W2-06 — מיגרציית בלוג: 54 פוסטים + 6 קטגוריות + 126 תגיות

### מטרה
כל תוכן הבלוג מהאתר הישן מיובא ל-WP החדש עם שמירה על מבנה IA + slugs ל-301.

### Scope — IN
- **54 פוסטים** מ-`https://www.eyalamit.co.il/Blog/*` — ייבוא דרך WP export/import או DB direct.
- **6 קטגוריות**: לפי `ACCURATE-SITE-MAPPING-AFTER-ARCHIVE`.
- **126 תגיות** — מועברות.
- **תמונות נלוות** — לפי `usage_count > 0` (F1).
- **תבנית** `tpl-blog-archive` + `tpl-blog-single`.
- **301 redirect** מ-URL ישן (`/Blog/<slug>/`) ל-URL חדש (`/blog/<slug>/`). הערה: WP בעברית מעמיק `/Blog/` עם capital B; לוודא רישיות.

### Scope — OUT
- כתיבת תוכן חדש — לא בסקופ. מיגרציה בלבד.
- בלוג EN.

### תלויות
- ⬛ **חוסם:** WP-W2-01 (design tokens — תבניות עיצוב לבלוג).
- 🟡 לא חוסם WP-W2-02 (יכול לרוץ במקביל).

### תוצרים
- 54 פוסטים פעילים תחת `/blog/`.
- 6 קטגוריות + 126 תגיות.
- ארכיון בלוג ב-`/blog`.
- 54 רשומות 301 ב-redirect tool של אייל (כבר כלולות באינוונטרי שלנו).

### Acceptance Criteria
- [ ] AC-01: 54 URLs פעילים.
- [ ] AC-02: כל פוסט שומר על author, date, tags, categories מהמקור.
- [ ] AC-03: תמונות פעילות (לא 404).
- [ ] AC-04: archive ב-`/blog/` מציג פגינציה + פילטר קטגוריה.
- [ ] AC-05: 301 מ-`/Blog/*` → `/blog/*` עובד.

### בעלים + שותפים
- team_10 + team_40 (מדיה).

### אומדן
**5-7 ימי עבודה** — ייבוא DB (2) + תמונות (1) + תבניות (1.5) + QA + 301 (1.5).

### סיכון + הקלה

| סיכון | חומרה | הקלה |
|--------|--------|------|
| תמונות בלוג חסרות / שבורות באתר הישן | בינוני | usage_count מסנן; placeholder לחסר |
| Shortcodes ישנים בפוסטים (Elementor וכו') | גבוה | סינון + המרה ידנית של 5-10 עמודי "מורכב"; השאר plain text |

---

## WP-W2-07 — כתבות עיתונות + עמוד מוקש + 49 QR + עדויות FB live

### מטרה
מסירת תוכן ה"מורשת" שעוטף את הליבה: כתבות עיתונות, עמוד מוקש דהימן, ו-49 עמודי QR.

### Scope — IN
- **`/press`** או חלק מ-`/about` — חילוץ כל כתבות העיתונות מהאתר הישן (מ-`/qr-press` או דומה). מצגת רשימה עם תאריך + כותרת + לינק.
- **`/about/moksha`** — עמוד מוקש דהימן (E2) — תוכן מ-[`ומה היום.docx`](docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/מוקש%20דהימן/ומה%20היום.docx) + תמונות (מאתר ישן אם יש).
- **49 עמודי QR** (`/qr/qr1/` עד `/qr/qr49/`) — מיגרציה 1:1 (E1). תוכן + תמונות + מבנה.
- **עדויות FB Top 5** ב-Hero/sections — חילוץ טקסט מ-25.5.26 + image-fetch מ-FB (תמונת פרופיל הממליצים).
- אישור פרסום מ-30+ ממליצים — איסוף ע"י נימרוד מול הרשימה.

### Scope — OUT
- שכתוב תוכן QR / מוקש / כתבות — מיגרציה בלבד.
- פעולות SEO על עמודי QR (לפי F2 — לא צריך עמוד index).

### תלויות
- ⬛ **חוסם:** WP-W2-02 (design + about layout).

### תוצרים
- עמוד `/press` (או section תחת `/about`).
- עמוד `/about/moksha`.
- 49 עמודי QR פעילים תחת `/qr/qrN/`.
- 30+ עדויות FB עם תמונות.

### Acceptance Criteria
- [ ] AC-01: 49 QR URLs פעילים תחת `/qr/qrN/` (אומת).
- [ ] AC-02: עמוד מוקש מציג תוכן + תמונה + לינק לאודות.
- [ ] AC-03: עמוד כתבות עיתונות מציג ≥5 כתבות מהאתר הישן.
- [ ] AC-04: עדויות FB Top 5 מוצגות עם טקסט + תמונה + לינק.
- [ ] AC-05: כל URL פותח חיצוני (FB share) בלשונית חדשה.

### בעלים + שותפים
- team_10 + team_30 (תוכן) + team_40 (חילוץ תמונות + סינון).

### אומדן
**3-4 ימי עבודה** — מוקש (0.5) + כתבות (1) + 49 QR (1) + עדויות FB (1) + QA (0.5).

### סיכון + הקלה

| סיכון | חומרה | הקלה |
|--------|--------|------|
| אישור פרסום מ-30+ ממליצים — חלקם לא נגישים | בינוני | סבב 1 = רק 5 העדויות העיקריות (כבר אישרו פייסבוק = ציבורי). 25 השאר — בנפרד |
| תמונות FB מסומנות hot-link (פייסבוק חוסם) | בינוני | download + מחסן ב-`uploads/` שלנו |

---

## WP-W2-08 — עמוד EN — תמצית האתר באנגלית

### מטרה
עמוד נחיתה אחד באנגלית — תמצית כל האתר בעמוד אחד, מעוצב, עם מדיה. סבב שיפורים יבוצע לאחר.

### Scope — IN
- **`/en`** או `/en/landing` — עמוד יחיד עם:
  - Hero בולט (תמונה + tagline אנגלית).
  - 4-6 sections: About Eyal, Method (cbDIDG), Services Overview, Books, Testimonials (translated), CTA.
  - כתיבת תוכן EN על בסיס תמצית ב-25.5.26 (לא תרגום מילולי).
  - מדיה רלוונטית (פורטרט, סטודיו).
  - לינק לעמוד EN באתר הישן ב-301 אם רלוונטי.

### Scope — OUT
- תרגום מלא של אתר עברי.
- עמודי שירות EN נפרדים.
- בלוג EN.

### תלויות
- ⬛ **חוסם:** WP-W2-02 (להבנת התוכן הסופי שיתורגם תמציתית).

### תוצרים
- עמוד `/en/landing` או `/en` יחיד.
- תרגום של 5-10 עדויות FB.
- meta נכון: `lang="en"`, `hreflang="en"` + reciprocal מהעברית.

### Acceptance Criteria
- [ ] AC-01: URL פעיל.
- [ ] AC-02: עמוד מציג את 6 ה-sections עם תוכן באנגלית.
- [ ] AC-03: hreflang מקושר נכון (EN ↔ HE).
- [ ] AC-04: CTA → `/contact` עם פרמטר `?lang=en` (נושא פניה Auto-set).

### בעלים + שותפים
- team_30 (תוכן EN). team_10 (יישום).

### אומדן
**2-3 ימי עבודה** — כתיבה (1) + יישום (1) + QA (0.5).

---

## WP-W2-09 — סינון מדיה + יישום 301 + cutover preparation

### מטרה
WP אחרון לפני cutover — סינון מדיה, יישום מפת 301 שאישר אייל, צ'קליסט cutover.

### Scope — IN
- **MEDIA-IN-USE-INVENTORY.json** — דו"ח אוטומטי מ-`ACCURATE-SITE-MAPPING` של relationships (`page_attachments`, `post_attachments`). רק `usage_count > 0`.
- **העברת מדיה מסוננת** ל-`wp-content/uploads/` של החדש (לפי תיקיות שנה/חודש WP).
- **יישום 301** — קליטת JSON מאייל (מ-redirects-301.html), המרה ל-`.htaccess` או ל-Redirection plugin (חינמי).
- **בדיקה לכל 78 ההמלצות האוטומטיות + 8 הידניים** של אייל — שכולן עובדות.
- **צ'קליסט cutover** — DNS, HTTPS, noindex removal, sitemap.xml, GA4 verify, חשבונית ירוקה integration test.

### Scope — OUT
- ביצוע cutover עצמו (זה M7).
- HTTPS migration — אם דורש הגדרות שרת — תיאום עם uPress.

### תלויות
- ⬛ **חוסם:** כל WP-W2-01 עד W2-08.
- ⬛ **חוסם חיצוני:** אייל מחזיר JSON מ-redirects-301.html.

### תוצרים
- `MEDIA-IN-USE-INVENTORY.json` — דו"ח 319 attachments → רק אלה עם usage > 0 (אומדן: 60-120 קבצים פעילים מתוך 319).
- העברת קבצים פיזית.
- 135 כללי 301 פעילים על staging.
- צ'קליסט cutover (md + docx export לאייל).
- בדיקת end-to-end על staging.

### Acceptance Criteria
- [ ] AC-01: כל קבצי המדיה הפעילים זמינים ב-WP החדש (לא 404).
- [ ] AC-02: 134 כללי 301 (מינוס 49 QR keep) פעילים על staging.
- [ ] AC-03: דגימת 20 URLs ישנים → כל אחד מוביל ל-URL החדש הנכון.
- [ ] AC-04: 49 QR URLs פעילים ללא שינוי (אומת אוטומטית).
- [ ] AC-05: Lighthouse audit על דף הבית ≥ 90 (perf/access/SEO/best-practices).
- [ ] AC-06: סקריפט QA `final_pre_cutover_check.sh` עובר 0 FAIL.

### בעלים + שותפים
- team_20 (כלל .htaccess, מדיה), team_40 (מדיה), team_50 (QA סופי), team_90 (validation).

### אומדן
**3-4 ימי עבודה** — סינון מדיה (1) + העברה (0.5) + 301 (1) + צ'קליסט (0.5) + QA (1).

---

## תרשים תלויות

```
WP-W2-01 (תשתית)
    ↓
WP-W2-02 (ליבת תוכן) ────┬──→ WP-W2-03 (ספרים)
                          ├──→ WP-W2-04 (סאונד+שיעורים)
                          ├──→ WP-W2-05 (שופ)
                          ├──→ WP-W2-07 (כתבות+מוקש+QR)
                          └──→ WP-W2-08 (EN)

WP-W2-01 ─→ WP-W2-06 (בלוג, מקביל)

כולם ─→ WP-W2-09 (סינון+301+cutover)
```

## גאנט מקבילות

```
שבוע 1: [W2-01]
שבוע 2: [W2-02 חצי] [W2-06 חצי במקביל]
שבוע 3: [W2-02 סוף] [W2-06 סוף]
שבוע 4: [W2-03] [W2-04 במקביל]
שבוע 5: [W2-05] [W2-07 במקביל] [W2-08 ברקע]
שבוע 6: [W2-09] + QA סופי
שבוע 7: באפר + cutover M7
```

**סך זמן יישום:** 6-7 שבועות (4-5 שבועות אם 2 צוותי 10 פועלים במקביל).

---

## עדכון Roadmap

| שדה | ערך |
|------|-----|
| גרסה חדשה | v12.9 |
| Wave1 | DONE — ספרים POC, books-v2.css, treatment FINAL |
| Wave2 | ACTIVE — 9 WPs לפי מסמך זה |
| M4 | IN_PROGRESS — אינטגרציות (Green Invoice, טפסים) |
| M5 | NOT_STARTED — איכות סופית |
| M7 | NOT_STARTED — מסירה |

---

## אימותים נדרשים לפני התחלה

- [ ] אישור nimrod על מסמך זה (חתימה digital או reply).
- [ ] אישור team_80 על D-14 ready ל-tokens phase.
- [x] קבלת URLs רשתות חברתיות מאייל (פוטר) — **2026-05-26: FB+IG+YT התקבלו ואומתו live; TT ממתין.**
- [ ] קבלת מספר וואטסאפ + נוסח default מאייל ✓ (כבר התקבל: 052-4822842).
- [ ] אישור אייל על 3 קישורי Green Invoice (לכל ספר).

---

## חתימות

| תפקיד | חתימה | תאריך |
|--------|--------|--------|
| Architect (team_100) | ✓ נכתב | 2026-05-26 |
| Principal (team_00 / nimrod) | ⬜ ממתין | — |
| CEO (Eyal) | ⬜ לידוע — לא חוסם execution לפי F3 | — |
| QA Lead (team_50) | ⬜ ימתין לסיום W2-01 לפני קליטת mandate | — |

---

## Audit trail

- 2026-05-26 — מסמך נוצר כתגובה לדרישת F3 ("LOD200 מלא") של אייל בפגישה.
- 2026-05-26 — Decision Record reference: `_COMMUNICATION/team_00/DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md`.
