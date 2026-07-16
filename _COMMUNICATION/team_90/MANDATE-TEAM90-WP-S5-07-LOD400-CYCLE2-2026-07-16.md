---
id: MANDATE-TEAM90-WP-S5-07-LOD400-CYCLE2-2026-07-16
from_team: team_100
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
cycle: 2 (delta — closes cycle-1 findings)
wp: WP-S5-07
gate: L-GATE_SPEC
target_artifacts:
  - _COMMUNICATION/team_100/S005/WP-S5-07-LOD400-2026-07-16.md
prior_cycle:
  mandate: _COMMUNICATION/team_90/MANDATE-TEAM90-WP-S5-07-LOD400-2026-07-16.md
  verdict: _COMMUNICATION/team_90/VERDICT-WP-S5-07-LOD400-2026-07-16.md
  result: PASS_WITH_FINDINGS — 0 blockers · 1 major (F-01) · 3 minor (F-02..F-04)
builder_engine: claude-opus-4-8 (Claude Code)
required_validator_engine: non-Claude (composer-2.5 / cursor vendor) — Iron Rule #1
---

# MANDATE — team_90: WP-S5-07 LOD400 — מחזור 2 (delta)

מחזור 1 החזיר **`PASS_WITH_FINDINGS`** — 0 blockers, **1 major (F-01)**, 3 minor. team_100 סגר את **כל** הארבעה.
**הרף למחזור זה: `PASS` נקי (0 ממצאים).** ולידציית **מפרט** — אל תבנה ואל תריץ את ה-drop-ins.

**⛔ תזכורת:** ה-NAP **מאושר וסגור**. אל תדרוש אימות מול אייל/team_00 ואל תסמן כממצא שהוא «לא הוכרע».

## 1. סגירת הממצאים

| ID | חומרה | הממצא שלך | התיקון שנטען | מה לאמת |
|----|-------|-----------|--------------|---------|
| **F-01** | **major** | §4.B/AC-2 כיוונו ל-`block-footer-social.php`, אך מסלולי ה-Chapters מרנדרים `section-footer.php` | §4.B **נכתב מחדש**: יעד = `template-parts/chapters/section-footer.php` L32-34 (`foot__brand`), עם אזהרה מפורשת שהקובץ הישן **מת** + הוראה **לא** להוסיף לו NAP (עותק שני = הדריפט עצמו). §1 + §8#7 + AC-2 עודכנו | (א) האם היעד החדש נכון ומדויק ל-L32-34? (ב) האם ה-snippet ישתלב נכון בתוך `foot__brand` ולא ישבור את `foot__soc` שאחריו? (ג) האם AC-2 בודק כעת את **המסלולים הנכונים** (`/`, `/faq/`, `/contact/`, `/treatment/`) והאם שומר `ea-cfoot`=0 תקף? (ד) האם ההוראה לא-לגעת-במת חד-משמעית? |
| **F-02** | minor | AC-8 — `qa_probe.mjs` ללא נתיב | נתיב מלא `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` + נימוק RTL/nowrap | האם הנתיב קיים ונכון? |
| **F-03** | minor | «entry #1/#10» דו-משמעי | §5.3 — 0-based מפורש + «הזיהוי המחייב הוא שם המחבר» | האם התיקון מסיר את הדו-משמעות? האם ההחרגה עצמה נותרה חד-משמעית? |
| **F-04** | minor | «נאיבי = 7» | **6** בתחום `site/wp-content`+`scripts` (ה-7 היה `docs/`); bounded=1 | ספור בעצמך בתוך אותו תחום: נאיבי=6? bounded=1? |

## 2. אנטי-נסיגה (המפרט השתנה משמעותית ב-§4.B — ודא שלא נשבר דבר)

השינויים: §1 (טבלת קבצים), **§4.B (נכתב מחדש)**, §4.H (מספר), §5.3 (ניסוח), §6 (AC-2, AC-8), §8 (#6, +#7), **§9 (חדש)**.

1. **שתי המלכודות עדיין שלמות?** (א) FAQ insert-only (§4.G) — האיסור להפוך את ה-seeder ל-update-all לא רוכך?
   (ב) תת-מחרוזת (§4.H) — ה-lookarounds ללא שינוי?
2. **AC-1** (זהות-בייט של `ProfessionalService`) — שומר-הנסיגה על מנוע ה-schema של WP-S5-02 — ללא שינוי?
3. **AC-3** (qr32 חי) ו-**AC-4/AC-5** (FAQ: 2 פתוחים / 2 סגורים-VERIFY) — ללא שינוי?
4. **AC-7** (החרגות: testimonials 0 שינויים · `דיג׳רידו` · `wave2-stage-b`) — ללא שינוי?
5. **§9** — האם מתאר את מחזור 1 **נאמנה** מול ה-verdict שלך (0/1/3, F-01..F-04, ומה שאימתת עצמאית)?
   דווח כל אי-דיוק — זהו תיעוד היסטורי.
6. **roadmap** — `WP-S5-07`: `lod_status: LOD400` · `spec_ref` → המסמך · `next_wp: WP-S5-05` · `blocked_by: []` ·
   `supersedes: WP-S4-07`; `WP-S5-07` ∈ `WP-S5-05.blocked_by`; `WP-S4-07.status: SUPERSEDED` + `superseded_by: WP-S5-07`;
   7 ה-WPs S4-01..06,08 = `COMPLETE`/`LOD500_LOCKED` עם `gate_history`; `yaml.safe_load` נקי.

## 3. Guardrails — ללא שינוי. חובה לשמר.

| תופעה | דיספוזיציה |
|-------|-----------|
| TLS פג / staging HTTP-only | **מתוכנן**. `curl -k`. **לא ממצא.** |
| `x-robots-tag: noindex` | host-conditional. **לא ממצא.** |
| `curl 000` באצווה | timeout תעבורה, **לא** redirect. סדרתי לפני FAIL. |
| `052-482284` ⊂ `052-4822842` | lookarounds. אל תדווח 6 קבצים. |
| drop-ins single-fire | «כלום בהרצה שנייה» = תקין. |
| `/qr/` prod 302 · Check-32 | מחוץ ל-scope. |

## פורמט התשובה

`PASS` / `PASS_WITH_FINDINGS` / `FAIL`. אם F-01..F-04 לא נסגר — אמור זאת מפורשות, אל תעגל ל-PASS.
ממצא **חדש** מתיקוני מחזור 2 — דווח בנפרד. הכול סגור + אין חדשים → **`PASS`** נקי.

פלט: `_COMMUNICATION/team_90/VERDICT-WP-S5-07-LOD400-CYCLE2-2026-07-16.md`
