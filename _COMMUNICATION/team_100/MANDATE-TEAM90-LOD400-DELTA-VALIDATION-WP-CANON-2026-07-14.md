---
id: MANDATE-TEAM90-LOD400-DELTA-VALIDATION-WP-CANON-2026-07-14
from_team: team_100
to_team: team_90
date: 2026-07-14
type: cross-engine-validation-mandate
wp: WP-CANON-TEMPLATE-UNIFICATION
target_artifact: _COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD400-2026-07-14.md
prior_verdict: _COMMUNICATION/team_90/VERDICT-WP-CANON-LOD400-2026-07-14.md (FAIL — F90-01..F90-07)
builder_engine: claude-sonnet-5 (Claude Code)
required_validator_engine: non-Claude (cursor-composer) — Iron Rule #1
---

# MANDATE — team_90: delta-validation אחרי תיקון F90-01..F90-07

## הקשר

הריצה הקודמת (`VERDICT-WP-CANON-LOD400-2026-07-14.md`) חזרה `FAIL` עם 2 blockers (F90-01, F90-02), 1 major (F90-03), 4 minor (F90-04..F90-07). כל 7 הממצאים תוקנו בתוך `WP-CANON-TEMPLATE-UNIFICATION-LOD400-2026-07-14.md` עצמו — פירוט מלא ב-§0.4 של המסמך (יומן-תיקונים, טבלה עם "איפה תוקן" לכל ממצא).

**זו לא בקשה לקרוא מחדש את כל ~2,870 השורות.** כמו שה-verdict הקודם עצמו המליץ: התמקד ב-3 הממצאים המהותיים (F90-01/02/03), עם עבור-קצר על 4 המינוריים.

## מה לבדוק

1. **F90-01 (§3.5.5 ב-T6, קובץ חדש `chapters-commerce.php`):** האם ה-4 הפונקציות שם (`ea_w2_05_gi_url_map`, `ea_w2_05_gi_url`, `ea_w2_05_price`, `ea_wave2_wa_url`) תואמות verbatim למקור החי (`inc/wave2-w2-05.php:234-265`, `inc/wave2-stage-b.php`)? האם טבלת §3.6 המעודכנת (שורות `wave2-w2-05.php`) אכן מתנה מחיקה בקיום הקובץ החדש?
2. **F90-02 (אותו §3.5.5):** האם `ea_chapters_book_purchase_assets()` המוצעת (re-gated לפי 3 סלאגי-ספרים במקום ה-gate המקורי) שקולה מבחינת תוצאה בפועל ל-`ea_w2_03_purchase_assets()` המקורית (`inc/wave2-w2-03.php:166+`)? האם טבלת §3.6 (שורת `wave2-w2-03.php`) מעודכנת בהתאם?
3. **F90-03 (§3.0.f + §3.1/3.2/3.3 ב-T3b, §2.3 ב-T4):** האם השדות החדשים (`price`, `buy_print_url`, `buy_ebook_url`, `genre`, `meta_year`, `meta_pages`) עקביים בין T3b (איפה שהם נוספים, עם ערכים אמיתיים לכל ספר) ל-T4 (איפה שהם נקראים)? שים לב: `genre`/`meta_year`/`meta_pages` הושארו `null` בכוונה (לא אומתו ערכים מדויקים במחקר המקורי) — זה תקין, לא פער חדש, כל עוד T4 מטפל נכון ב-`null`/ריק (משמיט את השדה, לא כותב ערך-שווא).
4. **F90-04..F90-07 (עבור מהיר):** `ea_faq_query_items` מופיע נכון בT4 (לא `ea_chapters_faq_items`)? ניסוח ה"forever" ל-`/qr` רך יותר (T5 §4.3 + §0.1 F-5)? ציטוט `234-241` תוקן? T4/T7 אומרים "79" ולא "~62", ו-`lessons` מטופל כ"מצטרף לפורט הרגיל" לא כ"ללא FAQ"?

## פורמט התשובה

Verdict חדש: `PASS` / `PASS_WITH_FINDINGS` / `FAIL`. אם `FAIL` — רק על סמך F90-01/02/03 שלא נסגרו בפועל (לא על ממצאים חדשים מחוץ לסקופ הזה, אלא אם הם עצמם blocker/major אמיתי שנתגלה תוך כדי הבדיקה הממוקדת). כתוב verdict חדש ל-`_COMMUNICATION/team_90/VERDICT-WP-CANON-LOD400-2026-07-14.md` (מחליף/מעדכן את הקודם — ציין בבירור "delta re-validation" בכותרת).
