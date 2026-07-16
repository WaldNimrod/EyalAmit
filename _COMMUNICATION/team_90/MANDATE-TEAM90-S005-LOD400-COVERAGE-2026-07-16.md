---
id: MANDATE-TEAM90-S005-LOD400-COVERAGE-2026-07-16
from_team: team_100
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
wp: S005-PACKAGE-1-3 (WP-S5-01, WP-S5-02, WP-S5-03)
target_artifacts:
  - _COMMUNICATION/team_100/S005/S005-PACKAGE-1-3-INDEX-2026-07-16.md
  - _COMMUNICATION/team_100/S005/WP-S5-01-LOD400-2026-07-16.md
  - _COMMUNICATION/team_100/S005/WP-S5-02-LOD400-2026-07-16.md
  - _COMMUNICATION/team_100/S005/WP-S5-03-LOD400-2026-07-16.md
builder_engine: claude-opus-4-8 (Claude Code)
required_validator_engine: non-Claude (composer-2.5 / cursor vendor) — Iron Rule #1
---

# MANDATE — team_90: ולידציה חוצת-מנוע ל-LOD400 של S005 חבילות 1+2+3

## מה לבדוק

4 המסמכים לעיל (אינדקס-אב + 3 מסמכי LOD400) הם מפרט בנייה מלא ל-3 חבילות S005: WP-S5-01 (quick-verify residuals),
WP-S5-02 (SEO/GEO completion — schema/meta), WP-S5-03 (legacy/301 completeness). זהו **מסמך ספסיפיקציה, לא קוד** —
לא בוצע ולא צריך להתבצע שום שינוי בקוד האתר בשלב זה.

**את זה בונה, אתה מוודא (Iron Rule #1 — builder Claude, validator לא-Claude):** קרא את 4 המסמכים במלואם, ובדוק אותם
מול הקוד האמיתי בריפו (`site/wp-content/`, `scripts/`, `_aos/roadmap.yaml`, 3 מסמכי RESEARCH), לא רק מול עצמם.

## קריטריון הקבלה (הרף ש-team_100 קבע לעצמו)

*"לוודא שכל spec מפורט מספיק כדי שכל מפתח ג'וניור או agent טרי יוכל לממש בלי פערים, ניחושים או הנחות."*

## מה לבדוק בפועל

1. **דיוק מול קוד חי — spot-check.** בחר 8-10 טענות קונקרטיות (שמות קבצים, מספרי-שורה, פונקציות, מזהי-אופציה, מבני-schema)
   מפוזרות על פני 3 החבילות, ואמת ישירות מול הקוד. דוגמאות מומלצות לבדיקה:
   - WP-S5-01: `chapters-routing.php:80-104` (blog template priority 105); `block-faq-list.php:58-79` (TOC); `section-nav.php:36-46` (shop nav); QR-URL-INVENTORY.csv = 49 שורות.
   - WP-S5-02: `ea-w2-seo-schema.php` — services L99-103, Product gate `is_numeric()` L135, mokesh VideoObject L220-231 (המבנה שה-QR branch מחקה); `seo-head-fallbacks.php` `$map` L38-51 + excerpt-fallback L57-62; QR seed flag `ea_w2_07_qr_seeded_v3` (`ea-w2-07-qr-seed-once.php` L92/L145); דריפט nocookie (source 46/46 nocookie).
   - WP-S5-03: `ea-w209-legacy-301-redirects.php` (L11 func, L25 410, L31-33 `/Blog/` regex, L80 hook); `gen_htaccess_301_from_decisions.py` כותב **גם** את ה-PHP mu-plugin (L340-341) וגם htaccess block (L262); SSoT JSON = 135 decisions.
   דווח כל אי-התאמה, ולו קטנה.

2. **שלמות פנימית (buildability).** לכל 3 החבילות: האם המפרט כולל קבצים-ליצירה/שינוי מדויקים, רצף-בנייה, וקריטריוני-קבלה
   מדידים (לא פרוזה)? סמן כל מקום שבו חסר אחד מהשלושה. שים לב במיוחד ל-WP-S5-02 §2.2-§2.4 (ענפי ה-schema/meta הקונקרטיים) —
   האם מפתח טרי יכול לממש את ה-QR branch ואת ה-press/shows-heritage branch **בלי לנחש**?

3. **כיסוי פערים + אי-כפילות (הקריטי ביותר).** מטריצת §3 באינדקס ממפה כל ממצא מ-3 מסמכי ה-RESEARCH לחבילה בעלת LOD400.
   - האם **כל** ממצא ממופה (אין פער יתום)?
   - **חפיפה S5-01↔S5-02 (§3.1):** ה-route-completeness מסומן «WP-S5-02 בעלים / WP-S5-01 verify-only». ודא ש-WP-S5-01 §5
     באמת **לא בונה** schema/meta (verify-only) ו-WP-S5-02 §2 באמת **בונה** — אין כפילות-בנייה ואין פער-בין-הכיסאות.

4. **עקביות `next_wp` (3 מקורות).** ודא ש-`next_wp` זהה בין: (א) frontmatter כל WP; (ב) `_aos/roadmap.yaml`; (ג) טבלת §7.1 באינדקס.
   הערכים הצפויים: S5-01→WP-S5-02, S5-02→WP-S5-05, S5-03→WP-S5-05. ודא גם ש-roadmap S5-01/02/03 = `lod_status: LOD400`
   עם `spec_ref` המצביע למסמך ה-LOD400 החדש + `parent_index`.

5. **החלטת Option A (WP-S5-02).** המפרט מחייב index+schema לכל ה-routes החסרים (לא noindex), עם noindex כ-fallback מתועד
   (§2.6). ודא שההחלטה מיושמת עקבית (אין סתירה בין §0/§2.1/§2.6) ושה-fallback אינו הופך ל«שער-פתוח» שפוגם ברף ה-LOD400.

6. **hygiene דטרמיניסטי.** (א) כל 4 המסמכים נושאים `date: 2026-07-16`; (ב) frontmatter מלא (`id`/`wp`/`lod_status`/`next_wp`/`parent_index`/`assigned_validator`);
   (ג) אין TBD/placeholder אמיתי; (ד) `_aos/roadmap.yaml` parses (`python3 -c "import yaml; yaml.safe_load(...)"`).

## פורמט התשובה

Verdict סטנדרטי: `PASS` / `PASS_WITH_FINDINGS` / `FAIL`, עם רשימת ממצאים (אם יש) ברמת חומרה (blocker/major/minor),
כל אחד עם ציטוט/מיקום קונקרטי במסמך + במקור-האמת (קוד / roadmap / RESEARCH) שמראה את אי-ההתאמה. אל תסתפק ב"נראה טוב".
פלט: `_COMMUNICATION/team_90/VERDICT-S005-LOD400-COVERAGE-2026-07-16.md`.
