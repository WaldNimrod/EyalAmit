---
id: MANDATE-TEAM90-WP-S5-07-LOD400-2026-07-16
from_team: team_100
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
wp: WP-S5-07
gate: L-GATE_SPEC
target_artifacts:
  - _COMMUNICATION/team_100/S005/WP-S5-07-LOD400-2026-07-16.md
input_docs:
  - _COMMUNICATION/team_110/DECISION-NAP-CANON-2026-07-16.md
  - _COMMUNICATION/team_110/ROUTING-REQUEST-TEAM100-S004-RECONCILIATION-2026-07-16.md
  - _COMMUNICATION/team_90/VERDICT-WP-S4-07-BUILD-2026-07-15.md
builder_engine: claude-opus-4-8 (Claude Code)
required_validator_engine: non-Claude (composer-2.5 / cursor vendor) — Iron Rule #1
---

# MANDATE — team_90: ולידציה חוצת-מנוע ל-LOD400 של WP-S5-07 (NAP / S004 residual)

זהו **מפרט בנייה, לא קוד**. אל תבנה, אל תערוך קוד אתר, ואל תריץ את ה-drop-ins.
בדוק את המפרט **מול הקוד החי ומול הסטייג'ינג** — לא רק מול עצמו.

## ⛔ קודם כול — מה שאסור לבדוק

**ה-NAP מאושר וסגור** (team_00 + אייל, שוב ושוב). **אל תשאל «מה הטלפון?», אל תציע לאמת מול אייל, ואל תסמן
כממצא ששום החלטה על ה-NAP לא נלקחה.** אם המפרט היה מתייחס ל-NAP כשאלה פתוחה — **זה** היה הממצא.
רקע: `DECISION-NAP-CANON-2026-07-16.md` §0.

## קריטריון הקבלה
*"כל מפתח ג'וניור או agent טרי יוכל לממש בלי פערים, ניחושים או הנחות."*

## מה לבדוק בפועל

### 1. 🔴 שתי ה«מלכודות» שהמפרט טוען שהוא מונע — אמת את המנגנון, לא את הניסוח

**(א) ה-seeder של ה-FAQ הוא insert-only (§4.G).** המפרט טוען שאיפוס `ea_faq_seed_v2` **לא** יעדכן שורות
קיימות, ולכן `method-02` / `general-17` לא יגיעו ל-DB בדרך הזו — ושבונה שיחקה את דפוס ה-QR ייתקע.
- אמת ב-`mu-plugins/ea-faq-seed-once.php`: האם באמת `if ( ! empty( $existing ) ) { continue; }` + `wp_insert_post` בלבד?
- אמת את **ההפך** ב-`mu-plugins/ea-w2-07-qr-seed-once.php`: האם הוא באמת **מעדכן** `post_content` בהרצה חוזרת?
- האם ה-drop-in הממוקד (allow-list של 2 מפתחות, `init@41`) הוא הפתרון הנכון? האם ה-priority נכון מול ה-seeder ב-40?
- המפרט **אוסר** להפוך את ה-seeder ל-update-all + v3 (ידרוס 108 שורות ועריכות wp-admin). מנומק?

**(ב) תת-מחרוזת (§4.H).** המפרט טוען ש-`052-482284` הוא תת-מחרוזת של הקאנוני `052-4822842`, ולכן חיפוש נאיבי
מדווח **7** קבצים כשיש **1**. **אמת בעצמך** (הרץ גם נאיבי וגם עם lookarounds) וקבע: כמה קבצים באמת נושאים את
הטלפון השגוי כמספר עצמאי?

### 2. דיוק מול קוד חי + סטייג'ינג — spot-check (דווח כל אי-התאמה)
- **SSoT:** `ea-w2-seo-schema.php` L6/L53 (הצהרת SSoT); L61 `telephone`; L65 `streetAddress`; L66 `addressLocality`.
- **פוטר:** `block-footer-social.php` L64-65 — האם באמת רק `<p class="ea-cfoot__loc">פרדס חנה · ישראל</p>`, בלי טלפון/כתובת?
- **קודפוינטים (הקריטי):** `contact.php` **L87** — האם `פרדס חנה‑כרכור` נושא **U+2011**? (המפרט §8 טוען שמסמך
  הקלט פספס את זה ומנה רק את L88.) ו-`contact.php` L88 — U+2011 בטלפון? ו-`seo-head-fallbacks.php` L50 — האם
  שלושה U+05F3 (`דיג׳רידו`, `רח׳`, `ב׳`)?
- **qr32:** `ea-w2-07-qr-content-data.php` **L606** = `052-482284` (9 ספרות)? ו-`curl -k /qr/qr32/` → 200 + מרנדר אותו?
- **EN:** `tpl-chapters-en.php` L106 מול L112 — האם באמת שתי צורות תצוגה שונות?
- **`wave2-stage-b.php` L19** — האם המספר שם באמת **בהערה בלבד** והערך הוא `972524822842`? (המפרט §5.1 אומר «אל תיגע».)
- **חי:** `/faq/` — `ניסוח בידול` = 0? `052-482-2842` = 2? `כמה עולה טיפול / שיעור` = 1? `מדיניות מחיר` = 2?
  `עמל 8 ב` = 1? ו-`/` — `052-4822842` = 0?

### 3. ⚠ ששת התיקונים שהמפרט טוען למסמכי הקלט (§8) — אמת כל אחד
זה החלק החשוב ביותר אחרי §1. המפרט **סותר** את מסמכי הקלט בשישה מקומות:
1. `contact.php` L87 **וגם** L88 (ה-DECISION מנה רק L88).
2. `ea-testimonials-fb.json` — ה-DECISION אומר «המספרים שייכים לממליצים, לא לאייל». המפרט טוען שזה **שגוי**:
   שניהם **הטלפון של אייל**, מצוטט ע"י ממליצים בשמם (entry #1 נוית צוף שטראוס; entry #10 אלון גרזון רז
   «זה הטלפון שלו»). **אמת בקובץ.** האם ההחרגה עדיין נכונה (המפרט אומר כן, מנימוק חזק יותר — ציטוט מיוחס)?
3. AC-6 — ה-ROUTING-REQUEST אומר «`method-02` אין glow». המפרט טוען שב-**repo** ה-glow **קיים** ושהפער הוא
   **חי בלבד**. אמת בשני המקומות.
4. AC-4 — ה-verdict של S4-07 אומר «price Q3 absent; Q1 geo missing». המפרט טוען ש**שניהם חיים** ולכן
   VERIFY-בלבד. אמת חי.
5. F-01 של S4-06 — מסגור סותר (ROUTING-REQUEST: «placeholder לא-מסומן» מול verdict S4-06: «glow לגיטימי»).
6. `052-482284` בקובץ אחד — נכון?

**אם המפרט צודק — אשר.** אם הוא טועה ולו באחד — זה ממצא, כי הבונה יסמוך על §8.

### 4. שלמות פנימית (buildability)
- §4.A `ea_nap()` — האם הקוד שלם? האם ה-refactor של ה-SSoT (L57/61/65/66) **משמר-התנהגות**?
  האם AC-1 (זהות-בייט של `ProfessionalService`) באמת שומר על מנוע ה-schema של WP-S5-02?
- §4.B פוטר — האם המפרט מכריע בין inline-style ל-CSS («החלט אחד, אל תעשה שניהם»)?
- §4.F drop-in ה-QR — האם `init@27` נכון (לפני ה-seeder ב-28)? האם הדגל **חדש** (`ea-w2-07b` כבר נשרף)?
- §4.G drop-in ה-FAQ — האם קורא את ה-`post_content` **מה-JSON** ולא מקליד HTML מחדש?
- §4.D — האם ההוראה «רק `רח׳`+`ב׳`, לא `דיג׳רידו`» חד-משמעית? האם היא מונעת replace עיוור של U+05F3?
- TBD/placeholder אמיתי? (§5 מצהיר «אין TBD».)

### 5. החלטות §5 — הוכרעו ומנומקות?
- **§5.1 `ea_nap()` — כן/לא לכל משטח.** האם גבול ה«לא» מנומק (JSON לא קורא PHP; privacy/accessibility כבר
  קאנוניים; `wave2-stage-b` הערה בלבד)?
- **§5.2 EN = צורה בינלאומית** — האם זו הכרעה לגיטימית או **סתירה לקאנון** («display never carries the country
  code»)? המפרט טוען שהקאנון מונה משטחים **עבריים** בלבד ושהעמוד ממילא סותר את עצמו היום. שקול והכרע.
- **§5.3 החרגת testimonials** — האם המפרט מזהיר מספיק שהבונה לא יסיק «הנימוק שגוי ⇒ ההחרגה שגויה»?
- **§5.4 `דיג'רידו` מחוץ ל-scope** — מנומק?

### 6. AC מדידים (§6)
לכל AC-1..AC-8: סף מספרי + כלי + נתיב ראיה, או פרוזה? האם AC-5 (VERIFY-בלבד) באמת מגן על מה שכבר סגור?
האם `scripts/qa/http-qa-axe.cjs` ו-`qa_probe.mjs` קיימים כפי שה-AC-8 טוען?

### 7. Roadmap + hygiene
`_aos/roadmap.yaml` — `WP-S5-07`: `lod_status` · `spec_ref` → מסמך זה · `next_wp: WP-S5-05` · `blocked_by: []` ·
`supersedes: WP-S4-07`; `WP-S5-07` ∈ `WP-S5-05.blocked_by`; `WP-S4-07.status: SUPERSEDED` + `superseded_by`.
`python3 -c "import yaml; yaml.safe_load(open('_aos/roadmap.yaml'))"`. frontmatter מלא; `date: 2026-07-16`.

## Guardrails — חובה לשמר (מנעו false-FAIL ב-S5-01/02/06)

| תופעה | דיספוזיציה |
|-------|-----------|
| TLS פג / staging HTTP-only | **מתוכנן**. `curl -k`. **לא ממצא.** |
| `x-robots-tag: noindex` | host-conditional. **לא ממצא.** |
| `curl 000` באצווה | timeout תעבורה, **לא** redirect. סדרתי לפני FAIL. |
| `052-482284` ⊂ `052-4822842` | השתמש ב-lookarounds. אל תדווח 7 קבצים. |
| drop-ins single-fire | «לא קרה כלום בהרצה שנייה» = תקין. |
| `/qr/` prod 302 · Check-32 | מחוץ ל-scope. |

## פורמט התשובה
`PASS` / `PASS_WITH_FINDINGS` / `FAIL` + ממצאים ברמת חומרה (blocker/major/minor), כל אחד עם ציטוט/מיקום
במסמך **ובמקור-האמת**. אל תסתפק ב"נראה טוב".
פלט: `_COMMUNICATION/team_90/VERDICT-WP-S5-07-LOD400-2026-07-16.md`
