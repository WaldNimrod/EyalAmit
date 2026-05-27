---
id: PROJECT-STATUS-SNAPSHOT-2026-05-27
title: תמונת מצב פרויקט EyalAmit — מה בוצע, מה פתוח, מה הסדר הנכון להמשך
status: SNAPSHOT
date: 2026-05-27
author: team_100
audience: team_00 (nimrod)
trigger: nimrod request "לבחון את מפת הדרכים ולהציג תמונת מצב עדכנית"
profile: L0
---

# תמונת מצב — EyalAmit.co.il 2026 · 2026-05-27

## 0. שורה תחתונה

הפרויקט בלב **M4 Wave2** — בניית האתר על-בסיס Atoms-first LOD400. מתוך 9 ה-WPs של Wave2:

- **WP-W2-01 (תשתית)** → Stage A סגור עם cross-engine PASS. Stage B Prep סגור. Stage B Impl בFAIL_REMEDIATION — team_99 פועל כעת על deploy (תיקון מבני, לא קוד).
- **WP-W2-02..W2-09** → כולם PENDING, חוסמים על W2-01.

**מסלול ביקורת אחרון 1.5 ימים:** 6 commits, 7 ה-deliverables עיצוביים+טכניים, 2 verdicts cross-engine, 1 FAIL ו-remediation מסודר.

ההמתנה הנוכחית: **team_99 ב-waldhomeserver מבצע 3 משימות שרת** (FTPS deploy + WP-CLI smoke page + TLS). אחריו → cross-engine final QA (R5).

---

## 1. אבני דרך — Milestones M1..M7

| # | אבן דרך | סטטוס | סגירה |
|---|---------|--------|--------|
| **M1** | בסיס ביצוע פנימי | 🟢 COMPLETED | 2026-03-30 |
| **M2** | הקמת אתר רזה (G2 staging) | 🟢 COMPLETED | 2026-04-06 |
| **M3** | מיגרציית תוכן ומדיה (טכני) | 🟢 COMPLETED | 2026-04-07 |
| **M4** | **אינטגרציות + Wave1 + Wave2** | 🟡 IN_PROGRESS | בפעולה |
| **M5** | איכות לפני מסירה | ⚪ NOT_STARTED | — |
| **M6** | פרימיום (waiver-only) | ⚪ NOT_STARTED | — |
| **M7** | מסירה לאייל + cutover | ⚪ NOT_STARTED | — |

---

## 2. M4 — מצב פנימי

### Wave1 (אפריל-מאי 2026) — 🟢 DONE
- book-detail v2.css + 3 ספרים FINAL (kushi, tsva, vekatavta)
- עמוד `st-books` (מוזה) FINAL
- עמוד `st-svc-treatment` FINAL
- 6 חבילות `EYAL-CONTENT-PKG-2026-04-*` הוחלפו ע"י תוכן 25.5.26 (SUPERSEDED)

### Wave2 (פעיל מ-2026-05-26)

**מבנה:** 9 WPs (W2-01..W2-09). אומדן 36-50 ימי עבודה לפי מסלול Combo C (Wave parallel + Atoms-first LOD400).

| WP | סטטוס | הסבר |
|----|--------|------|
| **W2-01 תשתית** | 🟡 IN_PROGRESS_PENDING_QA | Stage A + Stage B Prep סגרו; Stage B Impl בRemediation Round 2 (team_99 deploy בעבודה) |
| W2-02 ליבת תוכן (6 עמודים) | ⏸ PENDING (חוסם W2-01) | בית/שיטה/טיפול/אודות/FAQ/קשר |
| W2-03 מוזה+3 ספרים | ⏸ PENDING (חוסם W2-02) | קטלוג + 3 עמודי ספר |
| W2-04 סאונד+שיעורים | ⏸ PENDING (חוסם W2-02) | 2 שירותים |
| W2-05 שופ | ⏸ PENDING (חוסם W2-02) | 4 מוצרים + תיקון + /shop catalog |
| W2-06 בלוג | ⏸ PENDING (חוסם W2-01) | 54 פוסטים + 6 קטגוריות + 126 תגיות — **מקביל ל-W2-02** |
| W2-07 כתבות+מוקש+QR | ⏸ PENDING (חוסם W2-02) | חילוץ + 49 QR מיגרציה |
| W2-08 EN landing | ⏸ PENDING (חוסם W2-02) | עמוד יחיד באנגלית |
| W2-09 cutover prep | ⏸ PENDING (חוסם W2-01..W2-08) | סינון מדיה + 301 + checklist |

---

## 3. WP-W2-01 (פירוט קריטי — תשתית)

### Stage A — Atoms-first LOD400 → 🟢 COMPLETE
- **A1 ATOM-INVENTORY** (32 atoms) — FINAL, L0, v1.1.0 (post-backport)
- **A2 D-14-DESIGN-SYSTEM-LOD400** (12 פרקים) — FINAL, L0, v1.1.0 (post-backport)
- **A3 atoms-poc-2026-05-26.html** — Lighthouse a11y **100**, perf **89**, axe-core **0 violations**
- **D-14 v1.1 token backport** (P1-P8) — DONE (team_80 ב-Track A)
- **Cross-engine validation** — team_190 verdict v2.0.0 PASS_WITH_FINDINGS (validator: gpt-5.5/Cursor)

### Stage B Prep — 🟢 COMPLETE_WITH_FINDINGS
- 7 משימות תשתית: plugins, MX, analytics scaffold, staging health, media inventory, FTPS, theme audit
- team_50 verdict 11/11 VCs PASS · cross-engine PASS (cursor-composer vs claude-code builder)
- Manual DB backup: RESOLVED (nimrod)

### Stage B Impl — 🔴 FAIL_REMEDIATION (Round 2 פעיל)

**מה נמסר** (commit `e165218`, team_10 בcursor-composer):
- 3 CSS files: ea-tokens.css + ea-animations.css + ea-atoms.css
- 4 JS files: ab-testing (post-patch), entrance, scroll, hero
- 12 block partials
- 13 page templates (כולל tpl-stage-b-test)
- inc/wave2-stage-b.php (enqueues + wp_head)
- CF7 form schema + analytics scaffold
- books-wave1.css DELETED

**מה נכשל ב-Round 1 QA** (commit `e773e5a`, FAIL):
- 4/14 VCs PASS · 10/14 FAIL (כל ה-staging runtime checks → 404)
- **Root cause:** קוד ב-git, **לא** דחוף לסטייג'ינג
- **Process violation:** team_50 רץ ב-Cursor (אותו engine כמו team_10 — cross-engine violation)
- **MAJOR:** A/B contract drift (תוקן Round 2)
- **MAJOR:** Staging TLS expired (non-blocking — לסגירה ב-cutover)

**Remediation Round 2** ([REMEDIATION-PLAN](EyalAmit.co.il-2026/_COMMUNICATION/team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md)):
| שלב | אחראי | סטטוס |
|------|--------|--------|
| R1 FTPS deploy | team_99 | 🟡 בעבודה (waldhomeserver) |
| R2 A/B patch | Sonnet sub-agent + Haiku QA | 🟢 DONE (commit `fb8da63`) |
| R3 WP smoke page `/wave2-test/` | team_99 | 🟡 בעבודה |
| R4 TLS renew | team_99 | 🟡 בעבודה (parallel) |
| R5 Cross-engine re-QA | **חוסם — non-Claude** | ⏸ ARMED (אחרי R1+R3) |

---

## 4. תלויות חוצות-Wave2

```
W2-01 ──┬─→ W2-02 (ליבה)──┬─→ W2-03 ספרים
        │                  ├─→ W2-04 סאונד+שיעורים
        │                  ├─→ W2-05 שופ
        │                  ├─→ W2-07 כתבות+מוקש+QR
        │                  └─→ W2-08 EN
        │
        └─→ W2-06 בלוג (מקביל ל-W2-02)
                                
כל ה-WPs ─→ W2-09 cutover prep
```

**מסקנה:** W2-01 חוסם מוחלט. כל עיכוב שם דוחה את כל Wave2.

---

## 5. תלויות נוכחיות — מה בדיוק מחכים לו?

### חוסמים אקטיביים
1. **team_99 על waldhomeserver** — 3 משימות (FTPS + smoke + TLS) — ETA ~45 דק'.
2. **team_50/team_190 cross-engine re-QA** — **non-Claude** engine נדרש (Cursor / Codex / Gemini). חוסם אחרי team_99.
3. **אייל — 3 human gates** — SMTP App Password + GA4 Measurement ID + Clarity Project ID. **לא חוסם** Phase 1; חוסם Phase 2 בלבד.

### לא חוסמים (אבל פתוחים)
- **TikTok URL** מאייל — לפוטר; לא חוסם go-live.
- **Hero Video** מאייל — placeholder יישאר; לא חוסם.
- **מוזה Bundle CTAs (Green Invoice)** — 3 קישורים לספרים; ל-W2-03.
- **כתבות עיתונות** מהאתר הישן — ל-W2-07.

---

## 6. שעון "עד go-live"

לפי האומדנים המקוריים של WAVE2-WORK-PACKAGES-LOD200:
- **Wave2 הוקצב 4-6 שבועות.**
- **עברו ~1.5 ימים** (סבב סגירת אייל + Stage A + Stage B prep + Stage B Impl + Round 1 FAIL + Round 2).
- **נותר** ~5-7 ימים עבודה ל-W2-01 (כשמסיים Round 2 ההצלחה) + 30-40 ימי עבודה ל-W2-02..W2-09.

**צוואר בקבוק קריטי:** Cross-engine validation. בלי סשן non-Claude בכל gate → לא נקבל verdict לעבור.

**Cutover (M7):** דורש HTTPS מלא + 301 + הסרת noindex + 4 ה-VCs של Phase 2 (CF7/GA4/Clarity/A-B distribution) — כולם תלויים באייל.

---

## 7. סדר נכון להמשך — לפי תלות

### 🔴 חוסמים מיידיים (לפעולה היום)

**Step 1 — team_99 מסיים (R1+R3, R4 parallel)**
- ETA: 45 דק' מעכשיו
- אם team_99 מסר report → המשך אוטומטי ל-Step 2

**Step 2 — Cross-engine final QA Round 2 (R5)**
- Engine: **NOT Claude, NOT Cursor (כי team_10 = Cursor)**. אפשרויות: Codex / Gemini.
- 14 VCs (10 fresh + 4 carry-forward)
- ETA: 2-3 שעות
- Output: `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md`

**Step 3 — team_100 advance gate**
- אם PASS / PASS_WITH_FINDINGS → roadmap.yaml: `WP-W2-01-STAGE-B-IMPL` → COMPLETE
- W2-01 umbrella → COMPLETE (אם אין findings חוסמים)
- שחרור W2-02 + W2-06 (מסלולים מקבילים)

### 🟡 שלב Wave2 הבא (אחרי W2-01 COMPLETE)

**מסלולים מקבילים** (2 סשנים אפשר במקביל):
- **W2-02 ליבת תוכן** (team_10 + team_30) — 7-10 ימים
- **W2-06 בלוג** (team_10 + team_40) — 5-7 ימים

ב-2 הסשנים חובה לוודא cross-engine QA בסוף (לפי הפרוטוקול שלמדנו ב-W2-01).

### 🟢 שלב גל ספרים-שיעורים-שופ (אחרי W2-02 COMPLETE)

**שלושה במקביל** (3 סשנים):
- **W2-03 מוזה + 3 ספרים** — 4-6 ימים (team_10)
- **W2-04 סאונד + שיעורים** — 3-4 ימים (team_10+30)
- **W2-05 שופ** — 4-5 ימים (team_10+30)

### 🟣 שלב סוף Wave2

- **W2-07 כתבות + מוקש + QR** — 3-4 ימים (אחרי W2-02)
- **W2-08 EN landing** — 2-3 ימים (אחרי W2-02)
- **W2-09 cutover prep** — 3-4 ימים (חוסם על כולם)

### ⚙ M5..M7 — אחרי Wave2

- **M5 איכות** — SEO + נגישות + 301 final pass + HTTPS prep (~1 שבוע)
- **M6 פרימיום** — רק waiver, סביר NOOP
- **M7 cutover + מסירה** — DNS + 301 + Eyal handoff (~1-2 ימים)

---

## 8. סיכונים פתוחים

| סיכון | חומרה | הקלה |
|--------|--------|------|
| **Cross-engine engine availability** | גבוה | לוודא שיש סשן Cursor + Codex/Gemini זמין בכל gate |
| **Eyal לא ממלא human gates בזמן** | בינוני | Phase 2 ידחה; לא חוסם Phase 1 PASS ולא חוסם המשך WPs |
| **Hero Video לא מגיע** | נמוך | Placeholder אנימציה ב-CSS פעיל; cutover לא חוסם |
| **A/B distribution לא מספיק נתונים** | נמוך | אחרי go-live; לא חוסם cutover |
| **uPress TLS לא מתחדש** | בינוני | אם R4 נכשל — fallback ל-HTTP על staging; HTTPS חובה רק ב-cutover |
| **תוכן 25.5.26 דורש פרשנות** | נמוך | DECISION RECORD §2.1 — לפנות ל-team_00; אסור לכתוב מחדש |
| **D-14 v2 דרוש (Wave3)** | נמוך-בינוני | atoms שיוסיפו ב-WPs מאוחרים → patch ל-D-14 (לפי §12 Changelog) |

---

## 9. מטריקה — מה שעובד

| מדד | ערך נוכחי |
|------|------------|
| Commits בWave2 | 14 |
| validate_aos.sh | 30 PASS / 18 SKIP / 0 FAIL ✓ |
| Atoms ב-D-14 | 32 (post v1.1) |
| Templates ב-child theme | 13 חדשים |
| Block partials | 12 |
| Cross-engine validations | 2 (team_190 Stage A v2 + team_50 Stage B-PREP) |
| Cross-engine violations open | 1 (team_50 Round 1 Stage B Impl — sgemented; Round 2 inflight) |
| Human gates pending Eyal | 3 (SMTP + GA4 + Clarity) |
| Open URLs from Eyal | 1 (TikTok) |

---

## 10. המלצה לnimrod עכשיו

**צעדים פעילים שתוכל לבצע ברגע זה (parallel):**

1. **לוודא ש-team_99 מתקדם** — SSH ל-waldhomeserver אם נדרש debug.
2. **להתחיל לארגן engine לcross-engine Round 2:**
   - אם Codex / GPT-5 זמין → הכי טוב (כבר היה ב-team_190 Stage A)
   - Cursor Composer יכול לעבוד גם (cross-engine vs team_10 שהיה cursor-composer — סוגי cursor שונים בעיקרון)
   - Gemini אם הופעל
3. **לתאם עם אייל** את 3 ה-human gates — אפשר לעשות במקביל ל-Round 2; אחרת ייתקע ב-Phase 2.

**צעדים שעדיף לדחות** עד שRound 2 מסתיים:
- W2-02 mandate writing (מוכן יחסית, אבל נטל יחזיק עד שיש PASS ב-W2-01)
- W2-06 בלוג mandate
- Mandates ל-team_80 לעדכונים ל-D-14 v2 (אם יידרשו)

---

## 11. אינדקס קבצים שצריך לעיון

| נושא | קובץ |
|------|------|
| מפת דרכים מלאה | [ROADMAP-2026.md](../../docs/project/ROADMAP-2026.md) |
| 9 WPs LOD200 | [WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md](../team_100/WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md) |
| Combo C החלטה | [DECISION_EYAL_MEETING_CLOSURE §7](../team_00/DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md) |
| Stage A completion | [STAGE-A-COMPLETION-REPORT](../team_100/STAGE-A-COMPLETION-REPORT-2026-05-26.md) |
| Stage B verdict FAIL | [VERDICT v1.0.0](../team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md) |
| Remediation plan | [REMEDIATION-PLAN](../team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md) |
| team_99 mandate | [MANDATE-TEAM99-STAGE-B-DEPLOY](../team_99/MANDATE-TEAM99-STAGE-B-DEPLOY-2026-05-27.md) |
| A/B patch report | [A-B-DRIFT-FIX](../team_10/A-B-DRIFT-FIX-2026-05-27.md) |
| Haiku in-process QA | [QA-A-B-PATCH-HAIKU](../team_50/QA-A-B-PATCH-HAIKU-2026-05-27.md) |
