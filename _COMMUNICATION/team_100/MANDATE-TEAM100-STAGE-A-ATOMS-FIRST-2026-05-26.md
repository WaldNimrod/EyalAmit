---
id: MANDATE-TEAM100-STAGE-A-ATOMS-FIRST
title: מנדט team_100 — שלב A של WP-W2-01 (Atoms-First LOD400) — ביצוע רציף + ולידציה קנונית
status: ACTIVE — execute now
date: 2026-05-26
from_team: team_00 (nimrod, Principal)
to_team: team_100 (Architect)
parent_handoff: ./HANDOFF_SELF_100_WP-W2-01-STAGE-A_2026-05-26_v1.md
parent_decision: ../team_00/DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md (§7)
lod: 200 (this mandate); produces LOD400 deliverable
profile: L2
---

# מנדט team_100 — Stage A (Atoms-First LOD400)

## 0. הקשר

ב-DECISION RECORD מ-2026-05-26 (§7) אישר Principal את **Combo C** לביצוע Wave2:
**X3 (Wave parallel) + Y3 (Atoms-first LOD400)**.

Stage A של WP-W2-01 הוא **חוסם** של כל 8 ה-WPs האחרים. הוא דורש סגירה מוצקה וקנונית לפני שצוות 10 יכול להתחיל ביישום קוד בשאר ה-Wave2.

מסמך זה מהווה את ההוראה המבצעית של team_00 → team_100. הזהות, הסמכויות והגוורננס שלכם מוגדרים ב-[HANDOFF הקנוני](./HANDOFF_SELF_100_WP-W2-01-STAGE-A_2026-05-26_v1.md).

---

## 1. שלוש משימות שעליכם לבצע ברצף, בסשן זה

### A1 — Atom Inventory Scan (1.5 ימים)

**מטרה:** הפקת רשימה ממוצה של כל ה-atoms הוויזואליים והפונקציונליים שיופיעו בפרויקט.

**מקורות סריקה חובה:**
1. 16 קבצי תוכן ב-`docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/`
2. 54 פוסטי בלוג + 6 קטגוריות + 126 תגיות (מ-`ACCURATE-SITE-MAPPING-AFTER-ARCHIVE-2026-01-13_22-02-59.json`)
3. 49 עמודי QR — לאמת באמצעות `QR-URL-INVENTORY.csv` המתוקן
4. עמודי השופ + תיקון
5. עמוד EN landing (תמצית)
6. הסקיצה הקיימת [`hub/dist/decisions/hero-c-fbw-sketch.html`](../../hub/dist/decisions/hero-c-fbw-sketch.html) — מה כבר הוגדר

**תוצר:** `_COMMUNICATION/team_80/ATOM-INVENTORY-2026-05-26.md` (בשיתוף team_80 — צוות עיצוב הוא הבעלים העיצובי, team_100 הוא הבעלים הארכיטקטוני).

**מבנה נדרש (לכל atom):**
- ID קנוני: `atom-<category>-<name>` (למשל `atom-hero-video`, `atom-cta-pill`)
- שם בעברית + שם באנגלית
- קטגוריה: structure / content / interaction / feedback / nav / data-display
- usage count: בכמה עמודים מופיע
- source files: באילו 25.5.26 mds
- variants: וריאנטים שונים (אם יש)
- accessibility flags: דרישות a11y מיוחדות
- D-14 alignment: האם דורש breathing? motion?
- responsive: rules כלליים

**אומדן:** ~25-30 atoms ייחודיים. אם מצאתם <20 או >40 — חזרו ובצעו ביקורת (תת- או על-פיצול).

### A2 — LOD400 Design System Spec (2.5 ימים)

**מטרה:** מסמך אחד מלא שיהווה SSOT לכל יישום ב-WPs הבאים.

**תוצר:** `_COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md`

**מבנה חובה (10-12 פרקים):**

1. **Foundation** — פלטה, טיפוגרפיה, spacing, layout grid, breakpoints, z-index scale. CSS variables `:root` מוכנים להעתקה.
2. **Motion System** — breathing keyframes (3-5 variants), entrance animations, micro-interactions, `prefers-reduced-motion` fallback מלא לכל primitive.
3. **Atoms** — לכל atom מ-A1: HTML structure (semantic) + CSS class names + ARIA attributes + states (default/hover/focus/active/disabled) + responsive rules + reduced-motion fallback.
4. **Composition Rules** — איך atoms מתחברים ל-blocks. דוגמאות אסורות (anti-patterns).
5. **Templates** — `tpl-home`, `tpl-service`, `tpl-book-detail`, `tpl-books`, `tpl-shop-item`, `tpl-shop-archive`, `tpl-blog-archive`, `tpl-blog-single`, `tpl-faq`, `tpl-content`, `tpl-en-landing`. לכל template: slot definitions, default content, required atoms.
6. **Interaction Patterns** — Hero video toggle, FAQ filter, breadcrumb, scroll progress, sound toggle, gallery lightbox (אם יש).
7. **Accessibility Spec** — WCAG 2.2 AA + ת"י 5568 conformance per atom. Color contrast tables. Keyboard navigation flows. Screen reader scripts.
8. **Data Schemas** — JSON shapes לכל data-driven atom (FAQ items, testimonials, products, blog posts, social URLs).
9. **WordPress Integration** — Custom Post Types, Taxonomies, Theme Mods, Block patterns (Gutenberg), shortcodes (only if necessary).
10. **Performance Budget** — LCP target per page type, JS budget, CSS budget, image guidelines.
11. **Testing Strategy** — Unit (visual regression), Integration (WP staging), A11y (axe-core), Performance (Lighthouse CI).
12. **Changelog & Versioning** — איך atoms יתעדכנו ב-Wave3+ בלי לשבור Wave2.

**עיקרון מנחה:** כל פריט במסמך זה חייב להיות **קוד מוכן ליישום** או **spec ברור עד רמת property**. אסור "TBD" ב-LOD400.

### A3 — POC: דמו עמוד מ-atoms (1 יום)

**מטרה:** קובץ HTML יחיד, self-contained, שמדגים שה-LOD400 עובד בפועל.

**תוצר:** `hub/dist/decisions/atoms-poc-2026-05-26.html`

**דרישות:**
- בחירת עמוד אחד (מומלץ: דף הבית — הכי מורכב, אם הוא עובד הכל יעבוד).
- מורכב 100% מ-atoms שב-A2 (אסור CSS ad-hoc).
- כל ה-12 בלוקים של דף הבית.
- Reduced-motion fallback מאומת (manual test).
- Lighthouse audit ≥ 85 mobile, ≥ 95 accessibility.
- אופציה: שני שינויים מ-WP-W2-02 (מקבלים אישור POC מנימרוד לפני שלב B).

**שער אישור (חובה):** nimrod סוקר את ה-POC, מאשר או מבקש שינויים. רק אז עוברים ל-Stage B (יישום ב-WordPress).

---

## 2. אורקסטרציה — איך מבצעים את 3 המשימות ברצף

### עיקרון מנחה: רציפות + נקודות בקרה

- **A1 → A2 → A3** הן רצף קשיח. אסור להתחיל A2 לפני שיש Atom Inventory מאושר.
- **בכל מעבר** — אתם רושמים תוצאות ב-`_COMMUNICATION/team_100/`, מאמתים מול הלוח הקנוני, ועוברים הלאה.
- **לא דורש אישור Principal בין A1↔A2↔A3** — רק שער ב-POC (A3 → שלב B).
- **כשמסתבכים** — לעצור ולשאול את team_00. לא לפתור לבד "כי זה מהיר יותר".

### חלוקת אחריות פנימית (team_100 ↔ team_80)

| שלב | team_100 (Architect) | team_80 (Design) |
|------|----------------------|-------------------|
| A1 Atom Inventory | מבנה + רשימה + Naming | סקירת ויזואלית + variants |
| A2 LOD400 Spec | Architecture, data schemas, WP integration, performance | Visual specs, motion, accessibility |
| A3 POC | אינטגרציה + Lighthouse + a11y test | רינדור ויזואלי + states demo |

**שיתוף פעולה:** ב-Cursor session אחד או בשני sessions נפרדים (team_100 + team_80) שמתואמים דרך `_COMMUNICATION/`.

### זמן יעד

**5 ימי עבודה מצטברים** (לפי LOD200 הורחב). אפשרי לסיים ב-4 ימים אם team_80 פנוי במקביל ל-A1.

---

## 3. ולידציה קנונית — לפני מסירה ל-Stage B

### חובה לאמת לפני סגירת Stage A

1. **`bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .`** — תוצאה: 0 FAIL.
2. **קריאה אנושית של A2 LOD400** — האם כל atom שב-A1 מופיע במלואו ב-A2? (חובה 100% coverage).
3. **POC עובר Lighthouse** — mobile ≥ 85 perf, ≥ 95 a11y.
4. **POC עובר axe-core** — 0 violations חמורים, 0 בינוניים. הערות נמוכות מותרות עם waiver.
5. **POC עובר reduced-motion manual test** — דפדפן עם `prefers-reduced-motion: reduce` → כל ה-animations נעצרים.
6. **WP-W2-01 LOD200 §AC-01..AC-07** — כל קריטריון מסומן `[x]`.
7. **שער nimrod ב-POC** — אישור מפורש בכתב לפני Stage B.

### אם validation נכשל

- לא להמשיך ל-Stage B.
- לתעד את הכשל ב-`_COMMUNICATION/team_100/STAGE-A-VALIDATION-ISSUES-{date}.md`.
- לתקן ולחזור על הוולידציה.
- שער ולידציה סופי בידי team_190 (לפי Iron Rule #5).

---

## 4. מקורות אמת — חובה לקרוא ולהיצמד

### Content SSOT (לפי DECISION RECORD §2.1)
1. **`תוכן לאתר 25.5.26/`** — SSOT לכל מה שמופיע שם
2. **`https://www.eyalamit.co.il/`** — השלמה 1:1 למה שלא בקבצים החדשים

### Technical SSOT (לפי DECISION RECORD §2.2)
1. **האתר החי = מקור אמת טכני** — URLs, slugs, redirects
2. **`QR-URL-INVENTORY.csv`** — מתוקן 2026-05-26 (nested pattern)

### Design SSOT
1. **`D-EYAL-DESIGN-STYLE-13`** (D-13) — נעול 2026-04-07
2. **`D-EYAL-DESIGN-DIRECTION-FBW-DEEP-2026-05-26.md`** (D-14) — מעמיק את D-13
3. **`EYAL-SITE-COLOR-PALETTE.md`** — 7 צבעי מותג

### Project SSOT
1. **`MEETING-DECISIONS-2026-05-26.md`** — 33 החלטות (12 + 21)
2. **`WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md`** — 9 WPs
3. **`hub/data/social-channels.json`** — URLs רשתות (3/4 התקבלו)

---

## 5. תוצרים סופיים של Stage A — checklist

- [ ] `_COMMUNICATION/team_80/ATOM-INVENTORY-2026-05-26.md`
- [ ] `_COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md`
- [ ] `hub/dist/decisions/atoms-poc-2026-05-26.html`
- [ ] `_COMMUNICATION/team_100/STAGE-A-COMPLETION-REPORT-2026-XX-XX.md` — דוח השלמה + validation results + שער POC
- [ ] עדכון `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md` — סימון A1/A2/A3 כ-DONE

---

## 6. סיכון, התראות, וכשלים פוטנציאליים

| סיכון | חומרה | הקלה |
|--------|--------|------|
| A1 ימצא <20 atoms או >40 — סימן לקטגוריזציה לא נכונה | בינוני | חזרה לבדיקת מקורות, פיצול/איחוד נכון |
| A2 חוצה 30 עמודים — דורש קריאה ארוכה מדי | בינוני | אינדקס מובנה + TOC + lookups בולטים |
| POC לא עובר Lighthouse | בינוני | חזרה לA2 — לסדר performance budget |
| nimrod מבקש שינויים מהותיים ב-POC | נמוך-בינוני | תקציב יום אחד לסבב שיפורים |
| team_80 לא פנוי במקביל | בינוני | team_100 לבצע A1 לבד, להעלות סקיצות ויזואליות פשוטות |
| מקור תוכן 25.5.26 דורש פרשנות | נמוך | חזרה ל-MEETING-DECISIONS — אם לא ברור, שאלה ל-team_00 |

---

## 7. סיום וחתימה

- **שעת התחלה:** 2026-05-26 (בסשן זה)
- **שעת יעד סיום:** 2026-05-31 (5 ימי עבודה)
- **בעלי משימה:** team_100 (architect) + team_80 (design)
- **בעל אישור POC:** team_00 (nimrod)
- **שער ולידציה סופי:** team_190 (אם דרוש)

**הפעולה הראשונה עכשיו:** התחל A1 — Atom Inventory Scan. סרוק 16 קבצי 25.5.26 + עמודי השופ + 49 QR + הסקיצה הקיימת. הפק את `ATOM-INVENTORY-2026-05-26.md` עם 25-30 atoms ייחודיים.
