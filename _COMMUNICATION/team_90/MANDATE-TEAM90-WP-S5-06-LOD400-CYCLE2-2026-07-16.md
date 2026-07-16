---
id: MANDATE-TEAM90-WP-S5-06-LOD400-CYCLE2-2026-07-16
from_team: team_100
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
cycle: 2 (delta — closes cycle-1 findings)
wp: WP-S5-06
gate: L-GATE_SPEC
target_artifacts:
  - _COMMUNICATION/team_100/S005/WP-S5-06-LOD400-2026-07-16.md
prior_cycle:
  mandate: _COMMUNICATION/team_90/MANDATE-TEAM90-WP-S5-06-LOD400-2026-07-16.md
  verdict: _COMMUNICATION/team_90/VERDICT-WP-S5-06-LOD400-2026-07-16.md
  result: PASS_WITH_FINDINGS — 0 blockers · 0 major · 4 minor (F-01..F-04)
builder_engine: claude-opus-4-8 (Claude Code)
required_validator_engine: non-Claude (composer-2.5 / cursor vendor) — Iron Rule #1
---

# MANDATE — team_90: WP-S5-06 LOD400 — מחזור 2 (delta)

מחזור 1 החזיר **`PASS_WITH_FINDINGS`** — 0 blockers, 0 major, **4 minor** (F-01..F-04). team_100 סגר את
**כל** הארבעה. **הרף למחזור זה: `PASS` נקי (0 ממצאים).** זו ולידציית **מפרט** — אין קוד לבנות ואין להריץ probe.

## 1. סגירת הממצאים — בדוק כל אחד מול המסמך המעודכן

| ID | הממצא שלך (מחזור 1) | התיקון שנטען | מה לאמת |
|----|---------------------|--------------|---------|
| **F-01** | `aria-label` נושא «נגן וידאו:» שאין ב-`VideoObject.name`; «mirrors L275-278» מטעה | §4.A — ההערה הופרדה: **כלל האינדקס** משקף את L275-278; הקידומת **מכוונת** (WCAG 2.4.6/4.1.2 — `<button>` חייב שם-פעולה) + «אין ליישר ע"י הסרת הקידומת» | האם ההערה מסירה את ההטעיה? האם היא מונעת מבונה "לתקן" את הקידומת בטעות? |
| **F-02** | נתיבי ראיה ללא קידומת `_COMMUNICATION/team_110/` | §6 — שורת **Evidence root** מפורשת + נתיב מלא בכל תא | האם ה-root נכון מול המוסכמה הקיימת (`evidence/s5-01/`, `evidence/s5-02/`)? האם נותר תא ללא נתיב מלא? |
| **F-03** | AC-4 דורש axe 0 ללא כלי מוגדר | **§4.G חדש** + AC-4 עודכן — `node scripts/qa/http-qa-axe.cjs /qr/qr2/ /qr/qr10/`, `exit 0` = 0 critical + 0 serious, לפני ואחרי | **אמת מול הקוד:** האם `scripts/qa/http-qa-axe.cjs` קיים, והאם ה-docblock שלו באמת מגדיר `exit 0` = 0 critical + 0 serious ("the reusable S5 a11y gate")? האם AC-4 עכשיו מדיד לגמרי? |
| **F-04** | `f.focus()` על iframe דינמי ללא `tabindex` | §4.D — `f.setAttribute('tabindex','-1')` **לפני** `replaceChild`, עם הנמקה | האם המיקום (לפני `replaceChild`) נכון? האם נותר פער פוקוס? |

## 2. אנטי-נסיגה (המפרט השתנה — ודא שלא נשבר דבר)

השינויים במחזור 2 נגעו ב-§4.A (הערה), §4.D (שורה אחת), **§4.G (סעיף חדש)**, §6 (טבלת AC), **§9 (חדש — היסטוריית ולידציה)**.

1. **§2 האילוץ הקריטי — עדיין נורמטיבי ושלם?** («render filter חובה / reseed אסור», מגובה ב-`ea-w2-seo-schema.php` L266).
   זו הנקודה היחידה שאסור שתיחלש. אמת שהיא לא רוככה.
2. **AC-2 עדיין שומר-הנסיגה?** qr2=1, qr10=3, qr1=0, qr48=0 — ללא שינוי.
3. **AC-1 / AC-1b** — הפיצול player/thumb נשמר כפי שאישרת במחזור 1 (AC-1 = 0 מוחלט; AC-1b = ≤20,480 B × count).
4. **§4.D** — האם ה-JS עדיין תקין תחבירית אחרי הוספת השורה (סדר: `setAttribute` → `replaceChild` → `focus`)?
5. **§9** — האם הוא מתאר את מחזור 1 **נאמנה** מול ה-verdict שלך (0/0/4, F-01..F-04, מה שאימתת עצמאית)?
   דווח כל אי-דיוק — זהו תיעוד היסטורי שייקרא אחרי שהסשן ייסגר.
6. **roadmap** — `WP-S5-06`: `lod_status: LOD400`, `spec_ref` → המסמך, `next_wp: WP-S5-05`, `blocked_by: []`,
   ו-`WP-S5-06` ∈ `WP-S5-05.blocked_by`. `python3 -c "import yaml; yaml.safe_load(open('_aos/roadmap.yaml'))"`.

## 3. Guardrails — ללא שינוי ממחזור 1. חובה לשמר.

| תופעה | דיספוזיציה |
|-------|-----------|
| תעודת TLS פגה / סטייג'ינג HTTP-only | **מתוכנן**. `curl -k` / `--ignore-certificate-errors`. **לא ממצא** (רלוונטי במיוחד ל-§4.G). |
| `x-robots-tag: noindex` באתר כולו | host-conditional. **לא ממצא.** |
| `curl` מחזיר `000` באצווה | timeout תעבורה, **לא** redirect. בדוק סדרתית לפני FAIL. |
| `/qr/` prod 302 · Check-32 drift | מחוץ ל-scope. **לא ממצא.** |

## פורמט התשובה

`PASS` / `PASS_WITH_FINDINGS` / `FAIL`. אם ממצא כלשהו מ-F-01..F-04 **לא** נסגר — אמור זאת מפורשות ואל תעגל
כלפי מעלה ל-PASS. ממצא **חדש** שנוצר ע"י תיקוני מחזור 2 — דווח בנפרד ובבירור.
אם הכול נסגר ואין ממצאים חדשים → **`PASS`** נקי.

פלט: `_COMMUNICATION/team_90/VERDICT-WP-S5-06-LOD400-CYCLE2-2026-07-16.md`
