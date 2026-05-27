---
id: NEXT-SESSION-DIRECTIVE-team_100-2026-05-27
title: כיוון לסשן team_100 הבא — R5 cross-engine final QA + סדר WPs Wave2
status: ACTIVE — for next team_100 session
date: 2026-05-27
from: team_100 (current session, handed-off)
to: team_100 (next session — fresh)
parent_handoff: ./HANDOFF_SELF_100_WP-W2-01-STAGE-B-IMPL_2026-05-27_v1.md
parent_status_snapshot: ../team_00/PROJECT-STATUS-SNAPSHOT-2026-05-27.md
profile: L0
---

# כיוון לסשן team_100 הבא

## 0. למה הסשן הקודם הסתיים

הסשן הקודם של team_100 (start: 2026-05-26 בוקר; end: 2026-05-27 ערב) ביצע:
- 21 commits ב-Wave2
- כל הסגירה המוקדמת מול אייל (12 + 21 שאלות + TikTok + 301)
- ניהול 4 צוותים מקבילים (team_80, team_10, team_50, team_99)
- 2 cross-engine validations
- Stage A מלא + Stage B Prep מלא + Stage B Impl Round 1 (FAIL) + Round 2 (5 מתוך 5 שלבים הושלמו)

**הקונטקסט מלא.** מעבר לסשן חדש מאפשר טעינה נקייה של ה-Iron Rules + roadmap + קבצים רלוונטיים, ביצועים טובים יותר ופחות סיכון לטעויות.

---

## 1. מצב נוכחי בקצרה

### ✅ הושלם
- **Stage A** (WP-W2-01) — Atom Inventory + D-14 LOD400 v1.1 + POC — team_190 v2 PASS_WITH_FINDINGS.
- **Stage B Prep** — 7 משימות תשתית + verdict 11/11 VCs PASS.
- **Stage B Impl Round 1** — קוד נמסר (commit `e165218`) → FAIL (deploy gap + cross-engine violation).
- **Remediation R1-R4** — team_99 deploy + smoke page DONE (commit `0f71779`); A/B drift fix DONE (commit `fb8da63`); TLS deferred ל-M7 (uPress wildcard limitation).
- **Eyal closures (2026-05-27)** — TikTok URL ingested; 301 decisions JSON ingested (135 items, 131 decided, 4 follow-ups).

### 🟡 חוסם יחיד
- **R5 — Cross-engine final QA Round 2** על WP-W2-01-STAGE-B-IMPL.
  - 14 VCs: 10 fresh + 4 carry-forward.
  - Engine: **NOT cursor-composer** (builder היה cursor-composer; Iron Rule #1).
  - אפשרויות: claude-code (לא Cursor → satisfies cross-engine), Codex/GPT-5, Gemini.
  - URLs יעד: `http://eyalamit-co-il-2026.s887.upress.link/wave2-test/` ו-CSS assets.

### ⚪ לא חוסם
- **4 follow-ups 301** (3 manual + 1 empty) — nimrod decision, לא דחוף עד W2-09.
- **3 Eyal human gates** (SMTP / GA4 / Clarity) — Phase 2 בלבד, לא חוסם Phase 1 או WPs הבאים.

---

## 2. הצעד הבא הקריטי (Single Critical Path)

### Step A — Spawn R5 Cross-Engine Validator (FIRST PRIORITY)

לפי הוראת nimrod 2026-05-27: "בסיום יש לבצע בדיקות וולידציה קאנוניים חיצוניים".

**שתי דרכים, לפי availability:**

#### דרך A.1 (preferred) — External engine session
nimrod פותח:
- **Cursor חדש עם Codex/GPT-5 ב-agent mode** (כמו team_190 Stage A v2)
- או **Gemini Code Assist** (אם הופעל)
- או סשן GPT-5 ב-web עם access לrepo
מדביק את ה-activation prompt מ-[REMEDIATION-PLAN §6.3](./REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md).

#### דרך A.2 (acceptable fallback) — Fresh Claude Code session
טכנית מספק את Iron Rule #1 (claude-code ≠ cursor-composer = builder).
לא אופטימלי כי כל ה-Stage A+B builds היו Claude/Cursor — האידיאל הוא engine שלישי לחלוטין.
**אבל מקובל** אם נימרוד ברירה זמינה כיום היא רק Claude.

team_100 הבא **מחליט עם nimrod** איזו דרך, לאחר בדיקת engines זמינים.

### Step B — Process Verdict (Round 2)

לאחר R5 → קבלת `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md`.

- **אם PASS / PASS_WITH_FINDINGS:**
  - עדכן `_aos/roadmap.yaml` — `WP-W2-01-STAGE-B-IMPL` → COMPLETE.
  - עדכן umbrella `WP-W2-01` → COMPLETE (אם אין findings חוסמים).
  - שחרר **W2-02** ו-**W2-06** למסלולים מקבילים.
- **אם FAIL:**
  - new Remediation cycle Round 3 (אומדן נמוך — רוב הראיות עכשיו נוטות לPASS אחרי R1-R4).

### Step C — Launch Wave2 Round 2 (parallel sessions)

לאחר W2-01 COMPLETE:

**מסלולים מקבילים (2 sessions בו זמנית):**
1. **Session W2-02** (team_10 + team_30) — ליבת תוכן 6 עמודים — 7-10 ימים.
2. **Session W2-06** (team_10 + team_40) — מיגרציית בלוג 54 פוסטים — 5-7 ימים.

team_100 הבא יפיק 2 מנדטים נפרדים + 2 activation prompts.

---

## 3. סדר מומלץ של פעולות לסשן הבא (60-90 דקות)

| # | פעולה | סוג | זמן |
|---|--------|-----|------|
| 1 | קריאת HANDOFF + DIRECTIVE זה + STATUS-SNAPSHOT | onboarding | 5 דק' |
| 2 | התקשרות אחרונה עם git fetch + validate_aos | sanity check | 2 דק' |
| 3 | בחירת engine ל-R5 עם nimrod (A.1 vs A.2) | decision | 5 דק' |
| 4 | Spawn / dispatch R5 cross-engine QA session | מסור | 10 דק' (ההתחלה) |
| 5 | **המתנה ל-Round 2 verdict** | מנוחה אקטיבית | ~3 שעות (paralleliz with #6) |
| 6 | במקביל: יישור 4 follow-ups 301 עם nimrod | acquaintance | 15 דק' |
| 7 | במקביל: Optional drafting W2-02 mandate (preparation) | preparation | 30 דק' |
| 8 | לאחר R2 verdict → גייט advance ב-roadmap | mutation | 10 דק' |
| 9 | Launch W2-02 + W2-06 (2 mandates + prompts) | מסור | 30 דק' |

**יעד סשן הבא:** Round 2 PASS + Wave2 שלב הבא launched.

---

## 4. ארטיפקטים שהסשן הבא חייב לקרוא

| # | קובץ | סוג | חובה? |
|---|-------|-----|--------|
| 1 | `HANDOFF_SELF_100_WP-W2-01-STAGE-B-IMPL_2026-05-27_v1.md` | AOS canonical handoff | ✓ ראשון |
| 2 | זה (NEXT-SESSION-DIRECTIVE) | פרויקטלי | ✓ שני |
| 3 | `../team_00/PROJECT-STATUS-SNAPSHOT-2026-05-27.md` | תמונת מצב | ✓ |
| 4 | `REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md` | תוכנית התיקון (R1-R5) | ✓ §R5+§6.3 |
| 5 | `../team_99/STAGE-B-DEPLOY-TEAM99-COMPLETION-NOTICE-TO-TEAM100-2026-05-27.md` | מה team_99 גמר | ✓ |
| 6 | `../team_00/EYAL-301-DECISIONS-INGEST-2026-05-27.md` | TikTok+301 closures | ✓ §2-3 |
| 7 | `../team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md` | Round 1 FAIL reference | אופציה |
| 8 | `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md` | 9 WPs LOD200 ל-W2-02 preparation | אופציה |

---

## 5. הנחיות תפעוליות לסשן הבא

### עבודה דרך sub-agents (לפי הוראת nimrod)
- **Sonnet sub-agents** ל-code execution (כמו A/B drift fix שעשינו).
- **Haiku sub-agents** ל-in-process QA mid-task.
- **External (non-Claude) engines** רק ל-final cross-engine validation (R5, future Round-3 gates).

### Commits & push policy
- commit אחרי כל שלב משמעותי (לפי `team_50` Iron Rule #11 — verdict commit required).
- push לאחר groups לוגיים — לא לכל commit נפרד.
- אם uncommitted state נמשך >30 דק' — לבדוק שאין לכשהו דחוף לבצע.

### Cross-engine constraint tracker
**זכור:**
- W2-01 Stage B Impl Round 2 → builder cursor-composer → validator MUST ≠ cursor.
- W2-02 build → choose engine; document; validator ≠ that engine.
- כל gate בעתיד → ensure builder/validator engine pair מתועד.

### בטיחות tokens
- אם הסשן עובר 50% מ-context window → בקש handoff נוסף.
- כל פעולת deploy / mutation גדולה → commit + push לפני שממשיכים.

---

## 6. שאלות פתוחות שראויות לתשובה מ-nimrod מוקדם בסשן הבא

1. **R5 engine choice** — Codex/GPT-5 / Gemini / fresh Claude Code?
2. **4 follow-ups 301** — לאשר את ההמלצות (410/sitemap.xml/contact/home)? לא חוסם, אבל סגירה קלה.
3. **Wave2 צוואר בקבוק parallelism** — האם להכין כבר את W2-02+W2-06 mandates במקביל ל-R5, או רק אחרי R5 PASS?

---

## 7. שינוי גרסה

| תאריך | פעולה |
|-------|--------|
| 2026-05-27 | מסמך נכתב לפני handoff. הסשן הקודם מסיים. |
