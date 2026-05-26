---
id: MANDATE-TEAM10-STAGE-B-IMPLEMENTATION-2026-05-27
title: מנדט team_10 — Stage B Implementation (WordPress code from atoms LOD400)
status: ACTIVE — execute now in a fresh team_10 session
date: 2026-05-27
from_team: team_00 (nimrod, Principal) via team_100
to_team: team_10 (Development / WordPress / Cursor)
parent_handoff: ./HANDOFF_SELF_10_WP-W2-01-STAGE-B-PREP_2026-05-26_v1.md
parent_mandate_prep: ./MANDATE-TEAM10-STAGE-B-PREP-PARALLEL-2026-05-26.md (B-PREP — CLOSED)
parent_decision: ../team_00/DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md (§7)
authorization_source: _COMMUNICATION/team_190/VERDICT_WP-W2-01_STAGE_A_L-GATE-SPEC_v2.0.0.md (PASS_WITH_FINDINGS — Stage B authorized)
profile: L0
wp: WP-W2-01 — Stage B (implementation)
combo: C (X3 Wave parallel + Y3 Atoms-first LOD400)
---

# מנדט team_10 — Stage B Implementation

## 0. הקשר ואישור התחלה

### Stage A סגור
team_190 הסמיך התחלת Stage B implementation בverdict v2.0.0 (PASS_WITH_FINDINGS, 2026-05-27, validator_engine: gpt-5.5 / Cursor — cross-engine נכון). 3 ה-blocking findings מ-v1 נסגרו ב-8 patches. ראיות באתר: Lighthouse mobile a11y 100, perf 89, BP 96, SEO 100; axe-core 0 violations.

### Stage B Prep סגור
B-PREP track הסתיים ב-`gate L-GATE_BUILD PASS_WITH_FINDINGS` (commit `93b40e3`). 7 משימות תשתית הושלמו. team_50 verdict 11/11 VCs PASS.

### מסלול Combo C
Y3 (Atoms-first LOD400) מסגיר את הסקופ שלכם כ-**הרכבה ויישום קוד מ-atoms מאושרים** — אסור design ad-hoc.

---

## 1. סקופ — מימוש 5 גושים ב-child theme `ea-eyalamit`

לפי WP-W2-01 LOD200 §B (Implementation) + D-14 LOD400 §9 (WordPress Integration).

### Block 1 — D-14 Tokens → CSS (1 יום)

**מטרה:** CSS variables קנוניים בפעולה ב-child theme.

**תוצרים:**
- `site/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css` — כל ה-tokens מ-D-14 §1 (Foundation).
- `site/wp-content/themes/ea-eyalamit/assets/css/ea-animations.css` — breathing primitives + entrance + micro-interactions + `prefers-reduced-motion` fallback מלא.
- שניהם enqueued דרך `functions.php` עם `wp_enqueue_style()`.

**מקור הערכים:** D-14 LOD400 + **טוקנים מעודכנים שב-POC לאחר 8 ה-patches** (ראו §3.1 — finding non-blocking של team_190 v2).

### Block 2 — 12 Blocks Gutenberg / PHP Partials (2-3 ימים)

**מטרה:** כל ה-atoms הוויזואליים זמינים כ-reusable blocks או partials.

**תוצרים:**
- 12 בלוקים, אחד-לאחד מה-POC (hub/dist/decisions/atoms-poc-2026-05-26.html — אומת cross-engine).
- כל אחד עם HTML+CSS+JS (אם נדרש) + accessibility attributes מ-D-14 §3 + ARIA + reduced-motion fallback.
- בחירה: Gutenberg blocks (`block.json` + `render.php`) או PHP partials (`get_template_part`). הצוות מחליט לפי מורכבות הבלוק.

### Block 3 — 11 Page Templates (2 ימים)

**מטרה:** Templates שאליהם WP יכוון את כל 16 העמודים של Wave2.

**תוצרים** (לפי D-14 §5):
- `tpl-home.php`, `tpl-service.php`, `tpl-book-detail.php`, `tpl-books.php`, `tpl-shop-item.php`, `tpl-shop-archive.php`, `tpl-blog-archive.php`, `tpl-blog-single.php`, `tpl-faq.php`, `tpl-content.php`, `tpl-en-landing.php`.
- כל template עם slot definitions, default content, required atoms.
- רישום ב-`functions.php` (Template Hierarchy) או דרך `Template Name:` PHPDoc.

### Block 4 — Contact Form 7 + Footer (0.5 יום)

**מטרה:** טופס + פוטר עובדים — אתחול אינטראקציה ראשונה.

**תוצרים:**
- **CF7 form ID** מוגדר לפי B1 (Minimal-Balanced: שם + טל/מייל + נושא אופציונלי + תוכן). 7 נושאים בדרופדאון (ללא "הופעה").
- שיבוץ shortcode CF7 ב-`tpl-content.php` או page template ייעודי `tpl-contact.php`.
- **3 וריאנטים של WhatsApp CTA** לפי B3 (A/B test): form-only, dual (form+WA), WA-only. רישום הקצאה random per-session ב-GA4 event (קוד JS כבר ב-WP-W2-01.B prep — `ea-ab-testing.js`).
- **Footer** עם 3 רשתות (FB+IG+YT — URLs מ-`hub/data/social-channels.json`). TikTok בהערה (URL pending).
- מספר וואטסאפ: 052-4822842.

### Block 5 — Analytics Wiring (0.25 יום)

**מטרה:** GA4 + Microsoft Clarity מקבלים events.

**תוצרים:**
- קוד GA4 + Clarity ב-`<head>` דרך `wp_head` action ב-`functions.php`.
- מקור IDs: `hub/data/analytics-config.json` (אייל ימלא ידנית את `ga4.measurement_id` + `clarity.project_id`).
- אם השדות עדיין PENDING_CREDENTIALS — להשאיר scaffold עם warning ב-error log שאומר "credentials missing — analytics inactive".

---

## 2. Scope OUT — לא חלק מהמנדט הזה

- ❌ תוכן עמודי 16 העמודים — זה WP-W2-02..W2-08.
- ❌ Hero video אמיתי — אייל מספק; placeholder אנימציה ב-POC ויישאר עד שמגיע.
- ❌ Custom Post Types לבלוג/ספרים/שופ — זה WP-W2-06 / W2-03 / W2-05.
- ❌ FAQ Custom Taxonomy — זה WP-W2-02.
- ❌ מיגרציית תוכן מהאתר הישן — זה WP-W2-09 prep.
- ❌ 301 redirects — אייל מאשר כקובץ ב-Drive; יישום ב-WP-W2-09.

---

## 3. דרישה מיוחדת — Token Backport (non-blocking finding מ-v2)

### הקשר
team_190 v2 verdict זיהה **finding לא-חוסם**:
> POC accessibility patches introduce updated token/motion values that are not fully backported into D-14. team_10 must implement from the patched POC + browser-evidence patch log for those values, or team_100/team_80 should issue an atom/spec patch before code hardening.

### 🟢 nimrod בחר מסלול A (2026-05-27) — Block 1 בהמתנה ל-team_80 patch

### 2 מסלולים — לבחור אחד לפני שמתחילים Block 1:

**מסלול A (מומלץ — חזק):** team_80 מנפיק patch ל-D-14 LOD400 שמגלם את 8 ה-POC patches.
- יתרון: D-14 נשאר SSOT יחיד.
- חיסרון: עיכוב של ~0.5 יום.
- **פעולה:** team_10 מבקש מ-team_100 לפתוח MSG ל-team_80 לפני שמתחילים. עד שmade — Block 1 בהמתנה.

**מסלול B (מהיר):** team_10 מיישם מ-POC + browser-evidence log כמקור.
- יתרון: התחלה מיידית.
- חיסרון: D-14 נשאר עם delta; דורש patch ב-Wave3 לפני שעובדים על WPs אחרים שצורכים את אותם tokens.
- **פעולה:** team_10 מתעד explicitly את כל ה-deltas שיישם מ-POC ב-`_COMMUNICATION/team_10/D-14-DELTA-IMPLEMENTED-FROM-POC-2026-XX-XX.md`.

**ברירת מחדל — אם nimrod לא מאשר**: **מסלול A** (cleaner audit trail).

**🟢 ביצוע בפועל:** נבחר **מסלול A** ב-2026-05-27. team_80 מנדט: `_COMMUNICATION/team_80/MANDATE-TEAM80-D-14-PATCH-FROM-POC-2026-05-27.md`. **טריגר ל-Block 1:** קיום `D-14-PATCH-NOTE-2026-05-27.md` עם status COMPLETE + commit ב-D-14 LOD400 v1.1.

---

## 4. מקורות אמת — חובה לקרוא ולהיצמד

| מקור | תפקיד |
|------|--------|
| `_COMMUNICATION/team_80/ATOM-INVENTORY-2026-05-26.md` (FINAL, L0) | רשימת 32 ה-atoms |
| `_COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md` (FINAL, L0) | spec מלא לכל atom + tokens + templates |
| `hub/dist/decisions/atoms-poc-2026-05-26.html` | מקור הרכבה + canonical token values אחרי patches |
| `_COMMUNICATION/team_50/POC-BROWSER-EVIDENCE-2026-05-27.md` | Lighthouse + axe-core + reduced-motion evidence |
| `_COMMUNICATION/team_190/VERDICT_WP-W2-01_STAGE_A_L-GATE-SPEC_v2.0.0.md` | authorization + non-blocking finding מקור |
| `_COMMUNICATION/team_00/DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md` | החלטות אייל ועקרונות מנחים |
| `hub/data/social-channels.json` | URLs רשתות (FB+IG+YT live; TT pending) |
| `hub/data/analytics-config.json` | GA4 + Clarity scaffolds (אייל ימלא IDs) |
| `_COMMUNICATION/team_20/PLUGINS-INSTALLED-2026-05-26.md` | CF7 6.1.6 + WP Mail SMTP 4.8.0 מותקנים |
| `_COMMUNICATION/team_30/CHILD-THEME-AUDIT-2026-05-26.md` | 23 קבצים ב-ea-eyalamit: 9 keep / 11 refresh / 1 delete |

---

## 5. Acceptance Criteria (≥12)

- [ ] AC-01: `ea-tokens.css` נטען בכל עמוד; CSS variables זמינים ב-`document.documentElement` (dev tools verify).
- [ ] AC-02: `ea-animations.css` כולל breathing primitives + `prefers-reduced-motion` fallback מלא (manual test on real browser).
- [ ] AC-03: 12 blocks/partials זמינים ב-Gutenberg picker או callable דרך `get_template_part()`.
- [ ] AC-04: כל בלוק ARIA-compliant — axe-core 0 critical/serious violations (CLI run on dev page that uses all 12).
- [ ] AC-05: 11 page templates רשומים ב-WP ("Template" dropdown ב-page editor); כל אחד עם documentation comment.
- [ ] AC-06: דף test שמשתמש ב-`tpl-home.php` מציג את 12 הבלוקים בסדר נכון (smoke test).
- [ ] AC-07: CF7 form שלוח מייל בדיקה ל-`info@eyalamit.co.il` (לאחר שאייל הזין SMTP password).
- [ ] AC-08: 3 variants של WhatsApp CTA קיימים; JS A/B test רץ ומדווח event ל-GA4 RealTime.
- [ ] AC-09: Footer מציג 3 קישורי רשת (FB+IG+YT) עם `target="_blank" rel="noopener noreferrer"`; קליק נרשם כ-outbound event ב-GA4.
- [ ] AC-10: GA4 + Clarity tracking ב-`<head>` של כל עמוד; הוספת event test pageview מאומתת ב-RealTime.
- [ ] AC-11: Lighthouse mobile על דף test ≥ 85 performance, ≥ 95 accessibility (אומת בריצה אמיתית).
- [ ] AC-12: validate_aos.sh: 0 FAIL.
- [ ] AC-13: כל הקבצים מ-`CHILD-THEME-AUDIT` שסומנו "refresh" עברו ריענון לפי D-14; הקובץ "delete" הוסר.
- [ ] AC-14: 1 file flagged סטטוס SUPERSEDED ב-roadmap.yaml (`books-wave1.css` אם עוד שם).

---

## 6. אורקסטרציה — סדר ביצוע

```
Block 1 (Tokens)           ─┐
                            ├─ tokens.css + animations.css עובדים
                            ┘
Block 2 (12 Blocks)        ──→ partials מקבילים, יום 2-3
Block 3 (11 Templates)     ──→ אחרי 6-8 blocks (לא צריך כולם)
Block 4 (Form + Footer)    ──→ אחרי Block 2 (CTA atom + Form atom available)
Block 5 (Analytics)        ──→ אחרון, 15 דקות wiring
```

**אומדן כולל:** 5-6 ימי עבודה (כי B-PREP כבר נסגר → חוסך ~2 ימים).

### תיאום
- **start trigger:** מסלול A (D-14 patch מ-team_80) או מסלול B (התחלה מיידית).
- **mid-checkpoint:** סוף Block 2 — דווח ל-team_100 (אם נדרש sub-decision על עיצוב).
- **end:** דוח השלמה + הזמנת QA ל-team_50 דרך MANDATE.

---

## 7. ולידציה לפני קליטה ל-Stage C (תוכן)

לפני שמסיימים Stage B ועוברים ל-WPs אחרים:

1. **L-GATE_BUILD QA** — team_50 בודק 14 ה-AC. ⚠ **חובה cross-engine** עכשיו (Iron Rule #1): builder=Claude/Cursor → validator engine **שונה**. אם team_10 ב-Cursor → team_50 ב-Claude/GPT. אם team_10 ב-Claude → team_50 ב-Cursor.
2. **L-GATE_V (cross-engine final)** — team_190 בודק עם מנוע שלישי אם שני הקודמים באותה משפחה.
3. **roadmap update** — team_100 (ספונק חדש) מעדכן `_aos/roadmap.yaml` `WP-W2-01` ל-`status: COMPLETE`.
4. **HUB build + publish** — אחרי שsucceeds: `python3 scripts/build_eyal_client_hub.py --mirror-docs` + `ftp_publish_eyal_client_hub.py`.

---

## 8. סיכון, התראות, וכשלים פוטנציאליים

| סיכון | חומרה | הקלה |
|--------|--------|------|
| token backport mismatch (D-14 → CSS) | בינוני | מסלול A מנטרל; מסלול B דורש `D-14-DELTA-IMPLEMENTED-FROM-POC` artifact |
| CF7 + WP Mail SMTP לא שולח מייל | נמוך | אייל לא הזין App Password עדיין → להציג warning UI, לא לחסום go-live |
| Lighthouse perf < 85 על mobile | בינוני | אופטימיזציה: image lazy-load, font-display swap, defer non-critical JS, אינלין critical CSS |
| תאימות RTL נשברת במובייל | בינוני | בדיקת manual + ChromeDevTools device emulation |
| Cross-engine QA לא זמין | גבוה | nimrod מספק engine alternate (cursor/codex/gpt) — אם לא — לעצור ולדווח ל-team_00 |
| Eyal משנה בקשה ל-Hero video לפני שהקוד מוכן | נמוך | Hero=placeholder עד מסירה; אין rework כי placeholder עצמו atomic |

---

## 9. תוצרים סופיים של Stage B — checklist

- [ ] `site/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css`
- [ ] `site/wp-content/themes/ea-eyalamit/assets/css/ea-animations.css`
- [ ] 12 blocks/partials ב-`blocks/` או `template-parts/`
- [ ] 11 page templates ב-`page-templates/`
- [ ] CF7 form configured + shortcode embedded
- [ ] Footer with 3 social links
- [ ] GA4 + Clarity wired in `functions.php`
- [ ] `_COMMUNICATION/team_10/STAGE-B-COMPLETION-REPORT-2026-XX-XX.md`
- [ ] (מסלול B in use) `_COMMUNICATION/team_10/D-14-DELTA-IMPLEMENTED-FROM-POC-2026-XX-XX.md`
- [ ] QA mandate routed to team_50 (cross-engine — opposite engine from team_10)

---

## 10. שיגור הסשן

**אופן הפעלה:**
1. nimrod פותח Cursor חדש על workspace `EyalAmit.co.il-2026/`.
2. מדביק את ה-Activation Prompt מ-§11 למטה.
3. team_10 (ב-Cursor) קורא את המנדט הזה כקובץ ראשון.
4. team_10 שואל את nimrod: "מסלול A או B?" לפני שמתחיל Block 1.
5. team_10 מבצע 5 גושים ברצף עם mid-checkpoint לאחר Block 2.

**צפי סיום:** 5-6 ימי עבודה מ-go.

---

## 11. Activation Prompt — לסשן team_10 חדש (Cursor)

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_10 only — Stage B Implementation

# Agent Onboarding — team_10 (Builder / Solo Mode B)

## Identity
- Team: team_10
- Engine: Cursor Composer (or any non-Claude engine if team_50 will be Claude)
- Role: Solo builder — implement WP-W2-01 Stage B (atoms → WP code)

## Mandate
Read in full: _COMMUNICATION/team_10/MANDATE-TEAM10-STAGE-B-IMPLEMENTATION-2026-05-27.md

## Source of truth (in order)
1. D-14 LOD400 spec: _COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md (FINAL)
2. ATOM-INVENTORY: _COMMUNICATION/team_80/ATOM-INVENTORY-2026-05-26.md (FINAL)
3. POC reference: hub/dist/decisions/atoms-poc-2026-05-26.html (canonical token values post-patches)
4. Browser evidence: _COMMUNICATION/team_50/POC-BROWSER-EVIDENCE-2026-05-27.md

## First action
1. Ask nimrod: "Token backport — מסלול A (wait for team_80 D-14 patch) או B (implement from POC + log deltas)?"
2. After answer, begin Block 1 (tokens) per §1 of mandate.

## Deliverables (5 blocks)
- Block 1: D-14 tokens → ea-tokens.css + ea-animations.css
- Block 2: 12 Gutenberg/PHP blocks
- Block 3: 11 page templates
- Block 4: CF7 form + Footer + WhatsApp 3-variant A/B
- Block 5: GA4 + Clarity wiring

## Acceptance criteria
14 AC in §5 of mandate. Lighthouse mobile ≥85 perf / ≥95 a11y on real browser run.

## Gate at end
L-GATE_BUILD QA by team_50 → if cross-engine match → team_190 (different third engine).

## Constraints
- NO ad-hoc CSS — atoms only.
- NO WooCommerce, NO premium plugins.
- prefers-reduced-motion fallback REQUIRED for every animation.
- RTL Hebrew on every block.

FIRST READ: _COMMUNICATION/team_10/MANDATE-TEAM10-STAGE-B-IMPLEMENTATION-2026-05-27.md
```

---

## 12. שינוי גרסה

| תאריך | פעולה |
|-------|--------|
| 2026-05-27 | מנדט נוצר על-ידי team_100 בעקבות team_190 v2 PASS_WITH_FINDINGS |
