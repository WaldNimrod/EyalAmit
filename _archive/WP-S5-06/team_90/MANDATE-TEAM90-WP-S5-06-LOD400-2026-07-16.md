---
id: MANDATE-TEAM90-WP-S5-06-LOD400-2026-07-16
from_team: team_100
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
wp: WP-S5-06
gate: L-GATE_SPEC
target_artifacts:
  - _COMMUNICATION/team_100/S005/WP-S5-06-LOD400-2026-07-16.md
input_docs:
  - _COMMUNICATION/team_110/ADDENDUM-TEAM100-WP-S5-06-FACADE-MANDATORY-2026-07-16.md
  - _COMMUNICATION/team_110/evidence/s5-02-facade-cwv/RESULTS-2026-07-16.txt
builder_engine: claude-opus-4-8 (Claude Code)
required_validator_engine: non-Claude (composer-2.5 / cursor vendor) — Iron Rule #1
---

# MANDATE — team_90: ולידציה חוצת-מנוע ל-LOD400 של WP-S5-06 (QR embed facade)

## מה לבדוק

`WP-S5-06-LOD400-2026-07-16.md` הוא **מפרט בנייה, לא קוד**. אין לבצע ואין לצפות לשום שינוי בקוד האתר בשלב זה.
בדוק את המפרט **מול הקוד החי בריפו** (`site/wp-content/`, `scripts/`, `_aos/roadmap.yaml`), לא רק מול עצמו.

## קריטריון הקבלה (הרף ש-team_100 קבע לעצמו)

*"כל מפתח ג'וניור או agent טרי יוכל לממש בלי פערים, ניחושים או הנחות."*

## מה לבדוק בפועל

### 1. 🔴 האילוץ הקריטי — האם המפרט באמת מונע את ההרס? (הבדיקה החשובה ביותר)
המפרט טוען (§2) שבניית ה-facade דרך **שינוי seed + reseed** תמחק בשקט כל צומת `VideoObject` מ-42 עמודי QR.
- אמת את **מנגנון** הטענה מול הקוד: `site/wp-content/mu-plugins/ea-w2-seo-schema.php` **L266** — האם ה-regex
  באמת רץ על `$qr_obj->post_content` (שדה DB גולמי) ולא על פלט מרונדר?
- אמת שה-iframes אכן מגיעים מה-seed: `site/wp-content/mu-plugins/ea-w2-07-qr-content-data.php`.
- **האם מסלול ה-`the_content` filter שהמפרט מחייב (§4.A) באמת משאיר את `post_content` ללא שינוי?**
- האם §2 מנוסח **נורמטיבית** (חובה/אסור), או שהוא רק "המלצה" שבונה יכול לעקוף?
- האם **AC-2** (§6) באמת תופס את הכשל הזה אם בונה יבחר reseed בכל זאת?

### 2. דיוק מול קוד חי — spot-check (דווח כל אי-התאמה, ולו קטנה)
בחר **8-10** טענות קונקרטיות ואמת ישירות מול המקור. מומלץ:
- **מסלול רינדור (§3.1):** `inc/chapters/chapters-routing.php:53` (`template_include` @103) ·
  `inc/chapters/chapters-render.php:75` (pattern route `'qr'`) · `page-templates/tpl-chapters-qr.php:38`
  (`the_content()`). **האם `tpl-chapters-qr.php` הוא באמת מה שמרנדר `/qr/qrN/`, ולא `tpl-qr.php` (Wave2)?**
- **טבלת 5 הפילטרים (§3.2):** אמת **כל אחת** מ-5 השורות (priority + קובץ + שורה + ה-gate) — האם באמת **אף אחד**
  מהם לא נוגע ב-QR? אם אחד כן נוגע, priority 20 עלול להיות שגוי.
- **קופסת ה-CLS (§3.3):** `assets/css/chapters.css` L777-790 — `aspect-ratio: 16/9` + `iframe{position:absolute;inset:0}`.
- **ספירות (§1):** האם ה-seed באמת מכיל **60** iframes (ולא 46 כפי שהאדנדום טוען), ו-**42** עמודים עם ≥1 וידאו
  (6×0 + 27×1 + 12×2 + 3×3)? ספור בעצמך. אמת `qr1=0, qr2=1, qr10=3, qr48=0`.
- **מבנה ה-VideoObject:** `ea-w2-seo-schema.php` L274-289 — האם ה-label ב-§4.A (`title` + אינדקס רק כש->1)
  באמת משקף את L275-278?
- **נקודת ה-require (§4.B):** `inc/chapters/chapters-bootstrap.php` L16-22.
- **תקדים ה-enqueue (§4.A):** `inc/chapters/chapters-commerce.php:83,102` — האם באמת קיים תקדים לקובץ-פיצ'ר
  שרושם את ה-enqueue של עצמו (המפרט מסתמך על זה)?
- **גרסת התמה (§4.E):** `style.css` L7 — האם באמת `1.5.6`?

### 3. שלמות פנימית (buildability) — הרף האמיתי
- האם ה-PHP/CSS/JS ב-§4 **שלמים ומדויקים דיים** למימוש ללא ניחוש? סמן כל מקום שבו agent טרי ייאלץ להחליט לבד.
- **regex §4.A:** האם הוא באמת תופס את מרקאפ ה-seed (§3.3) **אחרי `wpautop`**? האם הוא תופס **רק** iframes של
  YouTube ומשאיר אחרים? בדוק את הגבולות (מרכאות בודדות/כפולות, `www.` אופציונלי, query-string).
- **JS §4.D:** האם delegation + `closest()` + `error`-capture נכונים? האם `f.focus()` באמת מטפל בניהול-פוקוס?
- האם יש **TBD/placeholder** אמיתי? (המפרט מצהיר §5 «אין TBD» — אמת.)

### 4. ההחלטות שהוכרעו (§5) — האם הן באמת הוכרעו ומנומקות?
- **§5.1 כרזה:** ההחלטה `hqdefault` + **איסור** `maxresdefault`. team_100 מדד: `maxresdefault` → **404 ב-3/4**
  מהמזהים. **אמת עצמאית** (למשל `curl -s -o /dev/null -w '%{http_code}'` על 4 המזהים `ng9q5-xkNmE`,
  `bdJQOIeQBig`, `kQjtK32mGJQ`, `BlqT-V_CTcg`). אמת גם את גדלי `hqdefault` (~9-14 KB) ואת טענת ה-**0 `Set-Cookie`**.
- **§5.3 `ea-w2-07b-qr-reseed-once.php` נשאר** — האם ההנמקה עומדת, או שהאדנדום דרש מחיקה?
- האם §5 **מכריע** בכל מקום, או משאיר משהו פתוח בניגוד להוראת team_00?

### 5. ⚠ הסתירה שה-team_100 טוען שמצא (§8) — אמת אותה
המפרט טוען שה-AC-1 של האדנדום («YouTube payload → ~0 KB / 0 requests») **בלתי-אפשרי כפי שנוסח**, כי
`qr_cwv_probe.mjs` L45 סופר `ytimg.com` בתוך `ytBytes` — ולכן כרזת `i.ytimg.com` (שהאדנדום עצמו ממליץ עליה)
מבטיחה `ytBytes > 0`.
- **קרא את L45 של ה-probe ואמת את הסתירה.**
- האם הפיצול ל-AC-1 (נגן = 0 מוחלט) + AC-1b (כרזה מתוקצבת ≤20 KB × videoCount) הוא פתרון **נכון ומדיד**,
  או שהוא מרכך את הדרישה המקורית?
- אמת את שאר §8 (60≠46; «~10-30 KB» מול 9,195-13,953 B הנמדדים).

### 6. AC מדידים (§6)
לכל אחד מ-AC-1, AC-1b, AC-2, AC-3, AC-4, AC-5: האם הוא **מדיד** (סף מספרי + כלי + נתיב ראיה), או פרוזה?
- האם ה-harness (§4.F) שהמפרט מחייב באמת **מסוגל** למדוד את מה ש-AC-1/1b/3/4 דורשים אחרי השינויים המפורטים?
- האם AC-4 (LCP «+20%») מנומק כסף-רחב-בכוונה בגלל רעש ה-LCP, או שהוא חור?
- **§4.F — קידום ה-probe ל-`scripts/qa/`:** ההנמקה היא Iron Rule #15 (ארכוב `_COMMUNICATION/` ישבור AC שתלוי
  בנתיב evidence). האם ההנמקה נכונה? האם `scripts/qa/` באמת בית ה-harness הקנוני?

### 7. עקביות roadmap + hygiene דטרמיניסטי
- `_aos/roadmap.yaml` — שורת `WP-S5-06`: `lod_status: LOD400` · `spec_ref` מצביע למסמך הזה · `next_wp: WP-S5-05` ·
  `blocked_by: []` · והאם `WP-S5-06` נמצא ב-`WP-S5-05.blocked_by`?
- `next_wp` זהה בין frontmatter המסמך ל-roadmap.
- frontmatter מלא; `date: 2026-07-16`; `_aos/roadmap.yaml` parses (`python3 -c "import yaml; yaml.safe_load(open('_aos/roadmap.yaml'))"`).
- **transcripts:** אמת שהמפרט באמת **לא** מכניס אותם לשום AC (הוראת team_00 — §5.5).

## Guardrails — מנעו false-FAIL בשתי החבילות הקודמות. חובה לשמר.

| תופעה | דיספוזיציה |
|-------|-----------|
| תעודת TLS פגה ב-`*.upress.link` | **מתוכנן** בסטייג'ינג. `curl -k`. **לא ממצא.** |
| `x-robots-tag: noindex` באתר כולו | host-conditional (`ea-staging-noindex.php`). **לא ממצא.** |
| `curl` מחזיר `000` באצווה | timeout תעבורה על ה-host המשותף של uPress — **לא** redirect. בדוק סדרתית לפני FAIL. |
| `/qr/` prod 302 | מחוץ ל-scope (WP-S5-05). **לא ממצא.** |
| `validate_aos.sh` Check-32 drift | scope של team_00/team_100. **לא ממצא.** |

**זו ולידציית מפרט.** אל תריץ בנייה, אל תערוך קוד אתר, ואל תדרוש ראיות-ריצה שקיימות רק אחרי הבנייה.

## פורמט התשובה

Verdict סטנדרטי: `PASS` / `PASS_WITH_FINDINGS` / `FAIL`, עם ממצאים ברמת חומרה (**blocker** / **major** / **minor**),
כל אחד עם ציטוט/מיקום קונקרטי **במסמך** + **במקור-האמת** (קוד / roadmap / probe) שמראה את אי-ההתאמה.
אל תסתפק ב"נראה טוב" — אם טענה במפרט לא נבדקה מול הקוד, אמור זאת.

פלט: `_COMMUNICATION/team_90/VERDICT-WP-S5-06-LOD400-2026-07-16.md`
