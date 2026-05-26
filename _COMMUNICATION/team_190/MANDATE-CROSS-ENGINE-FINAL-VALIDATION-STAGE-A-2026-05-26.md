---
id: MANDATE-CROSS-ENGINE-FINAL-VALIDATION-STAGE-A
title: מנדט team_190 — Cross-Engine Final Validation על Stage A (Atoms-First LOD400)
status: ARMED — awaiting A3 completion trigger
date: 2026-05-26
from_team: team_00 (nimrod, Principal) via team_100
to_team: team_190 (Final Validation Authority)
trigger_condition: "A3 (POC) marked COMPLETE by team_100 — see _COMMUNICATION/team_100/STAGE-A-COMPLETION-REPORT-2026-XX-XX.md"
parent_handoff: ../team_100/HANDOFF_SELF_100_WP-W2-01-STAGE-A_2026-05-26_v1.md
parent_decision: ../team_00/DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md (§7)
constitutional_authority: Iron Rule #5 (CLAUDE.md) — "Final validation owned by team_190 (constitutional, cross-engine, immutable)"
profile: L2
---

> **🟡 SUPERSEDED 2026-05-27**
> This pre-emptive mandate was authored in parallel by team_100 while the team_80/team_100 parallel session was still active and unaware. The canonical mandate that was actually executed by team_190 is:
> [`MANDATE-TEAM190-STAGE-A-VALIDATION-2026-05-26.md`](../team_100/MANDATE-TEAM190-STAGE-A-VALIDATION-2026-05-26.md) (created by the parallel session, dispatched, executed → verdict v1.0.0 FAIL → 8 patches → v2.0.0 PASS_WITH_FINDINGS).
> Kept here as duplicate-effort record for audit trail; **do not execute**.


# מנדט team_190 — Cross-Engine Final Validation עבור Stage A

## 0. הקשר ופרוטוקול

פרוטוקול QA דו-שלבי לפרויקט eyalamit (אישור nimrod 2026-05-26):

| שלב | מנוע | תפקיד | סטטוס |
|------|------|--------|--------|
| **In-Process QA** | Haiku subagent (team_50 surrogate) | Sanity checks מהירים תוך כדי בנייה. **Iron Rule #1 לא חל** — זה לא ה-final validation. | תקין כ-in-process |
| **Final Validation** | Cross-engine — **לא Claude** | קונסטיטוציוני לפי Iron Rule #5. מבוצע ע"י team_190. | **המנדט הזה.** |

In-process QA על A1+A2 כבר בוצע (Haiku) ויצא PASS_WITH_FINDINGS. אלה **לא מוחלפים** — הם נשארים כ-record של ה-sanity checks המהירים. ה-final validation נמצא **מעליהם**.

---

## 1. כניעת מנדט

המנדט הזה **ARMED** — לא מופעל עד שמתקיים תנאי הפעלה.

### תנאי הפעלה (trigger)
- team_100 כותב `STAGE-A-COMPLETION-REPORT-2026-XX-XX.md` עם:
  - A1 (ATOM-INVENTORY) — סטטוס FINAL (לא DRAFT)
  - A2 (D-14-DESIGN-SYSTEM-LOD400) — סטטוס FINAL
  - A3 (POC HTML) — קובץ קיים ב-`hub/dist/decisions/atoms-poc-*.html`
  - sign-off פנימי של team_100

### פעולה ראשונה אחרי trigger
team_190 פותח סשן חדש ב-**Cursor Composer** (או Codex/GPT — ראו §3) וקורא את ה-Activation Prompt בפרק §6 למטה.

---

## 2. אחריות validation

### היקף (in scope)
1. **ATOM-INVENTORY-2026-05-26.md** — כל 32 ה-atoms.
   - בדיקת שלמות (32 atoms מכסים 9 WPs?).
   - בדיקת naming convention (`atom-<category>-<name>` kebab-case).
   - בדיקת source traceability (כל atom מצביע למקור אמיתי ב-`תוכן לאתר 25.5.26`?).
   - בדיקת אי-כפילות + Hebrew labels אמיתיים.
2. **D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md** — מסמך LOD400 המלא.
   - 12 פרקים נדרשים (Foundation → Changelog).
   - לכל atom מ-A1 — האם יש spec מלא ב-A2?
   - CSS variables מוכנים להעתקה? אין "TBD"?
   - Accessibility spec — WCAG 2.2 AA + ת"י 5568?
   - prefers-reduced-motion fallback לכל אנימציה?
3. **POC HTML** — `hub/dist/decisions/atoms-poc-*.html`.
   - האם מורכב 100% מ-atoms שב-A2 (אסור CSS ad-hoc)?
   - Lighthouse mobile ≥ 85 performance, ≥ 95 accessibility (אומת בריצה אמיתית, לא הצהרה).
   - axe-core 0 violations חמורים.
   - reduced-motion manual test passes (browser DevTools).
   - תאימות RTL — נבדק על דפדפן אמיתי.

### מחוץ להיקף (out of scope)
- WordPress implementation (זה Stage B).
- Hero video (אייל מספק).
- Final aesthetics judgment (זה nimrod).

---

## 3. דרישת Cross-Engine — חמורה

**team_190 לא רשאי להשתמש ב:**
- ❌ Claude (Opus/Sonnet/Haiku) — אותה משפחה כמו ה-builder.

**team_190 חייב להשתמש באחד מ:**
- ✅ **Cursor Composer** (preferred — סביבה זמינה לproject)
- ✅ Codex (GPT-5 / o4)
- ✅ Claude in Chrome / Browser-isolated GPT
- ✅ Gemini (אם הופעל)

**אישור מנוע** חובה ב-§5.1 של דוח ה-validation: שורת `validator_engine:` בpath מפורש.

**אם הסביבה היחידה הזמינה היא Claude:** עצור. דווח ל-team_00. אסור לוותר על cross-engine.

---

## 4. תוצרים נדרשים

### תוצר 1: דוח Validation מלא
`_COMMUNICATION/team_190/STAGE-A-CROSS-ENGINE-VALIDATION-REPORT-2026-XX-XX.md`

מבנה:
- §0 verdict box: PASS / PASS_WITH_FINDINGS / FAIL (כפי שבדוחות team_50 לפי VERDICT_TEMPLATE).
- §1 hostname + engine declaration (חובה — לא Claude).
- §2 כל ה-criteria checked (≥15 קריטריונים — לפי §2 לעיל).
- §3 findings (blocker / major / minor).
- §4 validate_aos.sh result — 0 FAIL.
- §5 evidence (screenshots Lighthouse, axe report, manual test logs).

### תוצר 2: Decision Record
אם **PASS** — sign-off final ל-Stage A.
אם **PASS_WITH_FINDINGS** — רשימת findings + recommended actions לteam_80/100.
אם **FAIL** — Stage A חוזר לרובד בנייה, אין go ל-Stage B implementation.

### תוצר 3: עדכון gate ב-roadmap.yaml
team_100 מעדכן (per ADR034 R9):
- WP-W2-01 → `current_lean_gate: L-GATE_V` (אחרי PASS) עם gate_history entry שכולל את הדוח של team_190.

---

## 5. תהליך הפעלה אופרטיבי

### שלב 1 — שער הפעלה
team_100 מסיים A3, כותב STAGE-A-COMPLETION-REPORT. שולח MSG ל-team_190 (או nimrod מפעיל ידנית).

### שלב 2 — פתיחת סשן Cursor
nimrod פותח Cursor חדש ב-workspace `EyalAmit.co.il-2026/` (לא Claude Code, לא Claude Desktop, לא Claude.ai).

### שלב 3 — הדבקת Activation Prompt
ראו §6 למטה.

### שלב 4 — ביצוע
team_190 (ב-Cursor) קורא את 3 התוצרים, מבצע bracket checks, מריץ Lighthouse + axe-core על ה-POC, כותב דוח.

### שלב 5 — מסירה
team_190 מסר את הדוח ל-team_100 + team_00. team_100 מעדכן את ה-roadmap.

---

## 6. Activation Prompt — להעתקה לסשן Cursor אחרי A3

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_190 only — Cross-Engine Final Validation

# Agent Onboarding — team_190 (Constitutional Validator)

## Identity
- Team: team_190 (Final Validation Authority)
- Engine: CURSOR COMPOSER (cross-engine vs Claude builder — Iron Rule #1)
- Role: Constitutional cross-engine validation of Stage A (Atoms-first LOD400)

## Mandate
Read in full: _COMMUNICATION/team_190/MANDATE-CROSS-ENGINE-FINAL-VALIDATION-STAGE-A-2026-05-26.md

## Input artifacts (all should be FINAL state when you start)
1. _COMMUNICATION/team_80/ATOM-INVENTORY-2026-05-26.md
2. _COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md
3. hub/dist/decisions/atoms-poc-*.html (Stage A.3 deliverable)
4. _COMMUNICATION/team_50/QA-A1-INVENTORY-2026-05-26.md (in-process Haiku QA — reference only)
5. _COMMUNICATION/team_50/QA-A2-LOD400-2026-05-26.md (in-process Haiku QA — reference only)
6. _COMMUNICATION/team_100/STAGE-A-COMPLETION-REPORT-*.md (completion declaration)

## Required checks (≥15)
- atom completeness, naming, traceability, uniqueness, Hebrew labels
- LOD400 12-chapter structure, atom-spec coverage 100%, no TBD, copy-paste-ready CSS
- WCAG 2.2 AA conformance per atom
- prefers-reduced-motion fallback per animation
- POC composition (100% atom-based, no ad-hoc CSS)
- Lighthouse mobile ≥85 perf / ≥95 a11y (RUN it, don't trust declarations)
- axe-core: 0 critical/serious violations on POC
- RTL behavior on real browser
- validate_aos.sh: 0 FAIL

## Output
_COMMUNICATION/team_190/STAGE-A-CROSS-ENGINE-VALIDATION-REPORT-{DATE}.md
- §0 verdict box (PASS / PASS_WITH_FINDINGS / FAIL)
- §1 validator_engine declaration (must NOT be Claude)
- §2-§5 evidence per MANDATE §4

## Authority
- Iron Rule #5 (constitutional cross-engine validator)
- Verdict is BINDING — team_100 must reflect in roadmap.yaml gate progression

## First action
Read the MANDATE artifact in full. Confirm engine is non-Claude. Begin atom-by-atom check of A1 against the source files in 'תוכן לאתר 25.5.26/'.

FIRST READ: _COMMUNICATION/team_190/MANDATE-CROSS-ENGINE-FINAL-VALIDATION-STAGE-A-2026-05-26.md
```

---

## 7. אחריות שיבוץ + תיאום

| תפקיד | בעלים | טריגר |
|--------|--------|--------|
| **שיגור המנדט** | team_00 (nimrod) ידנית, ברגע ש-team_100 הצהיר A3 COMPLETE | A3 mtime + completion report exist |
| **פתיחת סשן Cursor** | team_00 (nimrod) | אחרי שיגור |
| **ביצוע validation** | team_190 (ב-Cursor) | תוך 4-8 שעות עבודה |
| **מסירת דוח** | team_190 → team_100 + team_00 | סוף ה-validation |
| **עדכון roadmap** | team_100 בסשן חדש | אחרי קבלת דוח team_190 |

---

## 8. שינוי גרסה

| תאריך | פעולה |
|-------|--------|
| 2026-05-26 | מנדט נוצר במצב ARMED. ממתין ל-A3 COMPLETE. |
