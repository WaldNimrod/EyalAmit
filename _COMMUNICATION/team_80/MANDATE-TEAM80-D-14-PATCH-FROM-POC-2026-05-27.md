---
id: MANDATE-TEAM80-D-14-PATCH-FROM-POC-2026-05-27
title: מנדט team_80 — Backport 8 POC patches ל-D-14 LOD400 spec (מסלול A)
status: ACTIVE — execute now
date: 2026-05-27
from_team: team_00 (nimrod, Principal) via team_100
to_team: team_80 (Design / Cursor session)
trigger: nimrod selected "מסלול A" 2026-05-27 (track-A token backport before team_10 starts Block 1)
parent_decision: ../team_00/DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md (§7)
authorization_source: _COMMUNICATION/team_190/VERDICT_WP-W2-01_STAGE_A_L-GATE-SPEC_v2.0.0.md (PASS_WITH_FINDINGS — non-blocking finding)
unblocks: _COMMUNICATION/team_10/MANDATE-TEAM10-STAGE-B-IMPLEMENTATION-2026-05-27.md (Block 1)
profile: L0
wp: WP-W2-01 — Stage A.4 (token backport)
combo: C (X3 Wave parallel + Y3 Atoms-first LOD400)
estimated_effort: 0.5 day (4-6 hours)
---

# מנדט team_80 — D-14 Token Backport from POC

## 0. הקשר ו-finding שמטופל

team_190 v2 verdict (PASS_WITH_FINDINGS, 2026-05-27) אישר את Stage A עם finding לא-חוסם:

> "the POC accessibility patches introduce updated token/motion values that are not fully backported into D-14. team_10 must implement from the patched POC + browser-evidence patch log for those values, **or team_100/team_80 should issue an atom/spec patch before code hardening**."

nimrod בחר **מסלול A**: team_80 מנפיק patch ל-D-14 spec לפני שteam_10 מתחיל Block 1.

**יתרון:** D-14 נשאר SSOT יחיד; אין delta בין spec לקוד.
**עלות זמן:** 0.5 יום (חוסם של Block 1 ב-Stage B implementation).

---

## 1. סקופ — 8 patches ל-backport

מקור: `_COMMUNICATION/team_50/POC-BROWSER-EVIDENCE-2026-05-27.md` §P-patches table.

| Patch | קטגוריה | שינוי בפועל ב-POC | מה לעדכן ב-D-14 LOD400 |
|--------|----------|---------------------|--------------------------|
| **P1** | ARIA | מחיקת `<div class="ea-hero__controls" aria-label="…">` placeholder + ה-CSS rule שלו | §3 Atom `atom-interaction-hero-controls` — להסיר אם קיים, או לציין שאינו atom פעיל ב-Wave2 |
| **P2** | ARIA | הוספת `role="img"` ל-`<span class="ea-bio-block__portrait-placeholder" aria-label="…">` | §3 Atom `atom-content-bio-portrait` — להוסיף `role="img"` ל-ARIA attributes |
| **P3** | Contrast — body text | **חדש: `--ea-text-body: #5A3826`** (כהה מ-`--ea-earth`). 4 selectors הוחלפו: `.ea-section-intro__body`, `.ea-bio-block__text`, `.ea-contact-section__body`, `.ea-contact-form__note` | §1 Foundation — הוספת token חדש `--ea-text-body: #5A3826`. §3 atoms הרלוונטיים — להחליף `--ea-earth` ב-`--ea-text-body` |
| **P4** | Contrast — WhatsApp button | bg `#25D366` → **`#0F7A3F`** (hover `#1ebe5d` → **`#0C6A37`**); font-weight `400` → **`700`**; font-size `0.78rem` → **`0.95rem`** | §1 Foundation או §3 atom `atom-interaction-whatsapp-cta` — עדכון 4 properties |
| **P5** | Contrast — footer copy | `rgba(255,255,255,0.3)` → **`rgba(255,255,255,0.78)`**; `0.7rem` → **`0.78rem`** | §3 atom `atom-nav-footer` או דומה — עדכון 2 properties |
| **P6** | Motion | הסרת `opacity` ramp מ-`ea-fadeUp`, `ea-breathReveal`, `ea-slideIn-rtl` keyframes (transform-only) | §2 Motion System — עדכון 3 keyframes (קריטי לcontrast: 12 מ-17 violations נפתרו בזה) |
| **P7** | Contrast — muted color | `--ea-muted: #A8A19B` → **`#6F635A`** | §1 Foundation — עדכון token (5 שימושים) |
| **P8** | Contrast — footer location | `color: var(--ea-muted)` → **`rgba(255,255,255,0.85)`**; weight `200` → **`400`**; size `0.58rem` → **`0.72rem`** | §3 atom `atom-data-display-footer-location` (אם קיים) — עדכון 3 properties |

---

## 2. תוצרים — שני קבצים

### תוצר 1: עדכון inline ל-D-14 LOD400 spec

קובץ: `_COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md`

**עדכונים נדרשים:**
1. **§1 Foundation:**
   - הוספת `--ea-text-body: #5A3826` ל-token table + CSS variables block.
   - עדכון `--ea-muted` מ-`#A8A19B` ל-`#6F635A`.
2. **§2 Motion System:**
   - עדכון 3 keyframes (`ea-fadeUp`, `ea-breathReveal`, `ea-slideIn-rtl`) — להסיר את ה-opacity ramp, להשאיר transform-only.
   - הערה ב-D-14 §2: "Contrast rule — animated text MUST NOT cross opacity threshold during reveal. transform-only motion."
3. **§3 Atoms** (אטומים רלוונטיים):
   - `atom-content-bio-portrait`: הוסף `role="img"` ל-ARIA spec.
   - `atom-interaction-whatsapp-cta`: עדכון bg/hover/font props.
   - `atom-nav-footer`: עדכון copy opacity + size.
   - אטומי body text (`atom-content-section-intro`, `atom-content-bio-block`, `atom-content-contact-section`, etc.): החלפת color reference מ-`--ea-earth` ל-`--ea-text-body`.
   - `atom-interaction-hero-controls`: סימון "DEPRECATED — empty placeholder removed" או הסרה לחלוטין.
4. **§12 Changelog:**
   - הוספת entry: `2026-05-27 — D-14 v1.1 — token backport from POC patches P1–P8 (cross-engine validation finding closure)`.
   - גרסה: מ-`v1.0` ל-`v1.1`.

### תוצר 2: Patch Note artifact

קובץ חדש: `_COMMUNICATION/team_80/D-14-PATCH-NOTE-2026-05-27.md`

**מבנה:**
- Frontmatter: `id`, `parent_spec: D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md`, `version: 1.1`, `cause: team_190 v2 finding`.
- §1 רשימת 8 patches (טבלה כמו ב-§1 לעיל) + שורת הצדקה לכל אחד.
- §2 רשימת קבצים שעודכנו (diff summary — לא diff מלא).
- §3 Acceptance — אישור עצמי של team_80 שכל 8 ה-patches integrated.

---

## 3. דרישה — Hebrew label / RTL

D-14 LOD400 כתוב בעיקר באנגלית טכנית. כל label עברי שמשורש ב-atom אסור שיישבר. בעת backport — לא לגעת בשמות עבריים, רק ב-tokens/CSS/ARIA.

---

## 4. Acceptance Criteria

- [ ] AC-01: `--ea-text-body: #5A3826` קיים ב-D-14 §1 + ב-`:root` CSS variables block.
- [ ] AC-02: `--ea-muted` עודכן ל-`#6F635A` ב-D-14 §1 (5 הופעות בקובץ).
- [ ] AC-03: 3 keyframes ב-§2 ללא `opacity` (רק transform).
- [ ] AC-04: `atom-content-bio-portrait` עם `role="img"` ב-ARIA attributes.
- [ ] AC-05: `atom-interaction-whatsapp-cta` עם 4 properties מעודכנות (bg, hover, weight, size).
- [ ] AC-06: 4 atoms של body text מצביעים על `--ea-text-body` (לא על `--ea-earth`).
- [ ] AC-07: §12 Changelog entry 2026-05-27 קיים; version bump מ-v1.0 ל-v1.1.
- [ ] AC-08: D-14-PATCH-NOTE-2026-05-27.md נוצר ומסכם את כל 8 ה-patches.
- [ ] AC-09: ATOM-INVENTORY (קובץ נפרד) — אם יש שינוי במספר ה-atoms בעקבות P1 (hero-controls deprecated) — עדכון בהתאם + Changelog.
- [ ] AC-10: validate_aos.sh: 0 FAIL.

---

## 5. אורקסטרציה

**אופן ביצוע:** סשן team_80 חדש (Cursor או Claude, **לא חוצה מנוע** — זה patch design ולא validation).

**זמן יעד:** 4-6 שעות עבודה רצופה.

**אין צורך** ב-QA cross-engine נפרד על ה-patch הזה — הוא ייכלל ב-Stage B implementation cross-engine QA הכולל.

**טריגר ל-team_10:** ברגע ש-D-14-PATCH-NOTE עם status COMPLETE → team_10 מתחיל Block 1.

---

## 6. מקורות אמת לעבודה

| מקור | תפקיד |
|------|--------|
| `hub/dist/decisions/atoms-poc-2026-05-26.html` | **canonical values** — אם יש ספק, ה-POC מנצח |
| `_COMMUNICATION/team_50/POC-BROWSER-EVIDENCE-2026-05-27.md` §P-patches | פירוט מלא של 8 ה-patches |
| `_COMMUNICATION/team_190/VERDICT_WP-W2-01_STAGE_A_L-GATE-SPEC_v2.0.0.md` | finding context |
| `_COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md` | קובץ-יעד לעדכון inline |
| `_COMMUNICATION/team_80/ATOM-INVENTORY-2026-05-26.md` | סנכרון אם P1 משפיע על מניין |

---

## 7. סיכון, התראות

| סיכון | חומרה | הקלה |
|--------|--------|------|
| Atom שלא מצוין ב-§1 לעיל ומשתמש ב-`--ea-earth` לבדיוק contrast (נשכח) | בינוני | סריקת `grep "--ea-earth"` על כל הקובץ; לכל הופעה — לבדוק אם זה body text |
| `--ea-muted` שינוי מ-#A8A19B ל-#6F635A — משבר אזורים שלא מצוינים | בינוני | סריקת `grep "--ea-muted"` — לוודא שכל 5 השימושים עוברים contrast check |
| Atom inventory לא מסונכרן עם spec | נמוך | סריקה הדדית — כל atom ב-A1 מופיע ב-A2 ולהפך |

---

## 8. תוצרים סופיים — checklist

- [ ] `_COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md` — עודכן inline; version v1.1; Changelog entry
- [ ] `_COMMUNICATION/team_80/D-14-PATCH-NOTE-2026-05-27.md` — נוצר
- [ ] (אם רלוונטי) `_COMMUNICATION/team_80/ATOM-INVENTORY-2026-05-26.md` — סונכרן עם spec (P1 hero-controls סטטוס)
- [ ] git commit + push: `D-14 v1.1 — token backport from POC P1-P8 (team_190 v2 finding closure)`
- [ ] הודעה ל-team_10: "Track A complete — Block 1 unblocked"
- [ ] עדכון task list

---

## 9. Activation Prompt — לסשן team_80 חדש

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_80 only — D-14 v1.1 Token Backport from POC

# Agent Onboarding — team_80 (Design / Atoms SSOT Owner)

## Identity
- Team: team_80
- Engine: Cursor or Claude (no cross-engine constraint — this is design patch, not validation)
- Role: Backport 8 POC patches into D-14 LOD400 spec to close team_190 v2 finding

## Mandate
Read in full: _COMMUNICATION/team_80/MANDATE-TEAM80-D-14-PATCH-FROM-POC-2026-05-27.md

## Sources
1. POC canonical values: hub/dist/decisions/atoms-poc-2026-05-26.html
2. Patch details: _COMMUNICATION/team_50/POC-BROWSER-EVIDENCE-2026-05-27.md (§P-patches table)
3. Spec to update: _COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md

## Deliverables
1. D-14 spec updated inline (§1, §2, §3, §12) — version bump v1.0 → v1.1
2. New artifact: _COMMUNICATION/team_80/D-14-PATCH-NOTE-2026-05-27.md
3. (if needed) ATOM-INVENTORY sync for P1 (hero-controls deprecation)

## Acceptance criteria
10 AC in §4 of mandate. validate_aos.sh 0 FAIL.

## Effort
4-6 hours single session.

## Downstream
On completion: team_10 unblocked to start Stage B Block 1.

FIRST READ: _COMMUNICATION/team_80/MANDATE-TEAM80-D-14-PATCH-FROM-POC-2026-05-27.md
```

---

## 10. שינוי גרסה

| תאריך | פעולה |
|-------|--------|
| 2026-05-27 | מנדט נוצר על-ידי team_100 בעקבות בחירת nimrod של מסלול A |
