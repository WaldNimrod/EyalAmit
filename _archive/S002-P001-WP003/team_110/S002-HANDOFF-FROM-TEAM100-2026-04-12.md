# Handoff: Team 100 → Team 110 (eyalamit_build)
# S002 — Content Completion Milestone
# Date: 2026-04-12 | From: eyalamit_arch (Claude Code) | To: eyalamit_build (Cursor Composer)

---

## מה קרה עד כה — תמונה מלאה

### S001 — AOS Canonization (COMPLETE)

הפרויקט EyalAmit.co.il-2026 עבר מיגרציה מלאה לקאנון AOS ב-2026-04-11.
כל 5 ה-WPs של S001 הגיעו ל-L-GATE_V PASS.

| WP | תיאור | סטטוס |
|----|-------|-------|
| S001-P001-WP001 | `_aos/` Foundation | COMPLETE |
| S001-P001-WP002 | CLAUDE.md + .cursorrules | COMPLETE |
| S001-P001-WP003 | Governance contracts + context files | COMPLETE |
| S001-P001-WP004 | `_COMMUNICATION/` canonical structure | COMPLETE |
| S001-P001-WP005 | AOS hub registration | COMPLETE |

**validate_aos.sh:** 12/12 PASS (אומת ע"י eyalamit_val / OpenAI)
**Hub (AOS):** הפרויקט רשום ב-agents-os/projects/eyalamit.yaml
**Team 110 (AOS Hub Domain Architect):** sign-off APPROVED 2026-04-12

---

### שינויים אחרונים (2026-04-12) — מה בוצע הסשן הזה

1. **`_communication/` → `_COMMUNICATION/`** — שינוי שם לקאנון AOS (commit `9159ff5`)
   - git mv דו-שלבי (macOS case-insensitive FS)
   - כל הפניות עודכנו: `.gitignore`, `scripts/`, `hub/data/`, `_aos/`, `CLAUDE.md`

2. **S002 WPs אותחלו** (commit `b76750b`)
   - 4 WPs נוספו ל-`_aos/roadmap.yaml`
   - LOD400 spec נוצר לכל WP
   - LOD300 milestone overview נוצר

---

## מצב הפרויקט — S002

### Active Milestone: S002

**סקופ:** השלמת תוכן עברי לדפים הציבוריים העיקריים + SEO.
**אין שינויים בתשתית, בעיצוב, או בקוד.**

### Work Packages — S002

| WP ID | תיאור | Gate נוכחי | תלות |
|-------|-------|------------|------|
| S002-P001-WP001 | About page — תוכן + ביוגרפיה עברית | L-GATE_E | אין |
| S002-P001-WP002 | Home page — hero copy + תוכן מקטעים | L-GATE_E | אין |
| S002-P001-WP003 | Services page — שירותים + מחירים | L-GATE_E | אין |
| S002-P001-WP004 | SEO — meta/OG לכל הדפים | L-GATE_E | אחרי WP001–WP003 L-GATE_B |

**כל ה-LOD400 specs נמצאים ב:**
`_aos/work_packages/S002/S002-P001-WP00[1-4]/LOD400_spec.md`

---

## מה צריך לקרות לפני שמתחיל לבנות

**L-GATE_S חסר לכל 4 ה-WPs.**

Team 110 (eyalamit_build) **לא יכול להתחיל build** עד ש-eyalamit_arch יאשר L-GATE_S לכל WP.
L-GATE_S דורש: אישור eyalamit_sd (נימרוד) על סקופ התוכן + מקורות.

**סדר הפעולות הנדרש:**
1. eyalamit_sd מאשר את LOD400 specs (WP001–WP003 במקביל, WP004 אחרון)
2. eyalamit_arch מעדכן roadmap.yaml → `current_lean_gate: L-GATE_S` + `gate_history` L-GATE_E PASS + L-GATE_S PASS
3. eyalamit_build מתחיל build

---

## מבנה הפרויקט — מה שחשוב לך

```
EyalAmit.co.il-2026/
├── _aos/
│   ├── roadmap.yaml              ← SSoT מצב WPs (קרא בכל סשן)
│   ├── context/
│   │   ├── PROJECT_CONTEXT.md    ← סקירת פרויקט
│   │   └── ACTIVATION_BUILDER.md ← הוראות הפעלה שלך
│   ├── governance/
│   │   └── team_110.md           ← חוזה הסמכות שלך
│   └── work_packages/S002/
│       ├── LOD300_content_completion_milestone.md
│       ├── S002-P001-WP001/LOD400_spec.md
│       ├── S002-P001-WP002/LOD400_spec.md
│       ├── S002-P001-WP003/LOD400_spec.md
│       └── S002-P001-WP004/LOD400_spec.md
├── _COMMUNICATION/
│   ├── team_110/                 ← כאן אתה כותב artifacts
│   └── team_10/                  ← legacy builder comms (קרא, אל תכתוב)
├── site/wp-content/themes/ea-eyalamit/  ← WordPress child theme
├── scripts/
│   ├── build_eyal_client_hub.py
│   ├── ftp_publish_eyal_client_hub.py
│   └── scan_eyal_content_index.py
├── hub/data/                     ← JSON data (build אחרי כל שינוי)
├── docs/PROJECT-ENTRY.md         ← כניסה לפרויקט לצוות חדש
├── CLAUDE.md                     ← context ראשי (גם רלוונטי לך)
└── .cursorrules                  ← קרא בכל סשן
```

---

## Stack הטכני

| שכבה | ערך |
|------|-----|
| CMS | WordPress 6.9.4 |
| Theme | GeneratePress + child theme `ea-eyalamit` |
| Hosting | uPress (Israeli WP hosting) |
| Staging | `http://eyalamit-co-il-2026.s887.upress.link` |
| Content plugins | Yoast SEO, ACF |
| Hub build | `python3 scripts/build_eyal_client_hub.py` |
| Hub deploy | `python3 scripts/ftp_publish_eyal_client_hub.py` |
| AOS validation | `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` |

**גישה ל-Staging:** דרך FTP / uPress admin panel (credentials ב-`.env` / local config)

---

## כללי ברזל — חובה לזכור

1. **לעולם לא לאמת את העבודה שלך** — L-GATE_V שייך אך ורק ל-eyalamit_val (OpenAI). קונסטיטוציונלי.
2. **לממש בדיוק לפי LOD400** — אין תוספות ללא אישור L-GATE_S מחדש
3. **validate_aos.sh לפני L-GATE_B** — exit 0, כל 12 בדיקות חייבות לעבור
4. **Hub deploy חובה** אחרי כל שינוי ב-`hub/data/*.json`
5. **כל פלט לאייל** — Word (.docx) או PDF. לא Markdown.
6. **roadmap.yaml** — כותב יחיד הוא eyalamit_arch. אל תכתוב לקובץ זה.
7. **תקשורת עם אייל** — דרך Team 00 (נימרוד) בלבד. לא ישירות.

---

## כיצד להצהיר L-GATE_B

לאחר השלמת implementation של WP:

1. הרץ: `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .`
2. וודא exit 0 (12 PASS)
3. כתוב `LOD500_asbuilt.md` ב-`_aos/work_packages/S002/S002-P001-WP00[X]/`
4. כתוב artifact ב-`_COMMUNICATION/team_110/` עם בקשת L-GATE_V לצוות 190

**תבנית LOD500:**
```markdown
# LOD500 — [WP-ID] As-Built Record
**WP ID:** [id] | **Builder:** eyalamit_build | **Date:** [date]

## AC Trace
| AC | Status | Notes |
|----|--------|-------|
| AC-001 | ✓ DONE | ... |
...

## validate_aos.sh
[timestamp] — 12 PASS / 0 SKIP / 0 FAIL

## L-GATE_B Declaration
PASS — [date]
Builder: eyalamit_build (cursor-composer)
Submitted to eyalamit_val (openai) for L-GATE_V.
```

---

## מקורות תוכן — S002

- **Drive:** `docs/project/eyal-ceo-submissions-and-responses/from-eyal/CONTENT/`
- **Legacy media:** `_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/`
- **WhatsApp intake:** `python3 scripts/intake_new_content.py`
- **Content index:** `hub/data/content-index.json`

---

## Team 00 — נקודת קשר

**עבור כל שאלה, אישור, או עדכון סקופ:**
Team 00 = נימרוד (human system designer). פנה אליו ב-Cursor Composer chat.

נימרוד הוא הסמכות הסופית. אל תתקדם ב-build ללא אישורו לסקופ (L-GATE_S דרשה זאת).

---

*Handoff authored by eyalamit_arch (Team 100 / Claude Code) | 2026-04-12*
*Session: S001 COMPLETE → S002 INITIALIZED*
