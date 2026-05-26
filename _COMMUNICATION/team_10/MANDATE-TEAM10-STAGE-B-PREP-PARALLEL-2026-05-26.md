---
id: MANDATE-TEAM10-STAGE-B-PREP-PARALLEL
title: מנדט team_10 — מסלול הכנה מקבילי ל-Stage B (תשתית WP)
status: ACTIVE — execute in parallel to team_100 Stage A
date: 2026-05-26
from_team: team_00 (nimrod, Principal)
to_team: team_10 (Development / WordPress)
parallel_to: _COMMUNICATION/team_100/MANDATE-TEAM100-STAGE-A-ATOMS-FIRST-2026-05-26.md
parent_handoff: ./HANDOFF_SELF_10_WP-W2-01-STAGE-B-PREP_2026-05-26_v1.md
parent_decision: ../team_00/DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md (§7)
lod: 200 (this mandate)
profile: L2
---

# מנדט team_10 — Stage B Prep (מסלול מקבילי)

## 0. למה מסלול מקבילי

team_100 מבצע כעת **Stage A** של WP-W2-01 (Atom Inventory + LOD400 Design System + POC) — 5 ימי עבודה.
**כל זמן הזה team_10 לא יכול ליישם CSS/blocks/templates** (תלוי ב-LOD400).

**אבל** יש בערך 7 משימות הכנה תשתיתיות שאינן תלויות ב-LOD400 ויכולות לרוץ במקביל. בסיום Stage A — team_10 כבר במצב מוכן לקפוץ ישר ליישום קוד.

**חיסכון נטו:** ~2 ימים על Wave2 כולו (W2-01 שלב B יורד מ-5-6 ל-3-4 ימים).

---

## 1. סקופ — 7 משימות הכנה (בסדר עדיפויות)

### Task B-PREP-1 — התקנת תוספי טופס + SMTP (0.5 יום)
**מטרה:** שני תוספים מותקנים על WP staging, מוכנים להגדרות.

**פעולות:**
1. WP admin → Plugins → Add New → Contact Form 7 (חינמי, ~1.5M installs) → Install + Activate.
2. WP admin → Plugins → Add New → WP Mail SMTP by WPForms (חינמי) → Install + Activate.
3. **לא** להגדיר עדיין את ה-SMTP credentials — אייל יזין סיסמה בעצמו.
4. לתעד גרסאות מותקנות ב-`_COMMUNICATION/team_10/PLUGINS-INSTALLED-2026-05-26.md`.

**AC:**
- [ ] CF7 מותקן + פעיל; ב-Settings יש פריט "Contact" בתפריט WP.
- [ ] WP Mail SMTP מותקן + פעיל; ב-Settings יש פריט "WP Mail SMTP".
- [ ] לא הוזנה סיסמת SMTP (`smtp_pass` ריק או `define('WPMS_ON', false)` בתחילה).

### Task B-PREP-2 — אימות Google Workspace MX → `info@eyalamit.co.il` (0.5 יום)
**מטרה:** לוודא שהדומיין `eyalamit.co.il` באמת מוגדר MX ל-Google ושהקופסה `info@` קיימת ומקבלת מיילים.

**פעולות:**
1. `dig MX eyalamit.co.il +short` — חייב להחזיר רשומות `aspmx.l.google.com` וכו'.
2. שליחת מייל בדיקה ידנית מחשבון אחר ל-`info@eyalamit.co.il`. לוודא שמגיע (לבקש אישור מאייל).
3. הכנה: ב-Google Admin של אייל ייווצר App Password ייעודי לאתר (לפלאגין SMTP). **אייל יזין אותו בעצמו ב-WP**.
4. תיעוד ב-`_COMMUNICATION/team_10/GOOGLE-WORKSPACE-VERIFICATION-2026-05-26.md`.

**AC:**
- [ ] dig מאמת MX → Google.
- [ ] מייל בדיקה התקבל ב-`info@eyalamit.co.il`.
- [ ] הוראות App Password מתועדות (לאייל).

### Task B-PREP-3 — הקמת GA4 + Microsoft Clarity (1 יום)
**מטרה:** שתי נכסי Analytics חיים, מוכנים להוספת tracking code ב-Stage B implementation.

**פעולות GA4:**
1. analytics.google.com → Create Property → Eyal Amit Production.
2. Data Stream → Web → `https://www.eyalamit.co.il` (גם staging ב-stream נפרד אם רוצים).
3. שמירת Measurement ID (`G-XXXXXXXXXX`) ב-`hub/data/analytics-config.json`.
4. Configure Enhanced Measurement → ✓ Page views, Scrolls, Outbound clicks, Form interactions.

**פעולות Clarity:**
1. clarity.microsoft.com → New Project → "Eyal Amit".
2. שמירת Project ID + tracking script ב-`hub/data/analytics-config.json`.
3. הגדרות → Privacy → Mask sensitive content (GDPR-friendly).

**תוצר:** `hub/data/analytics-config.json` חדש עם:
```json
{
  "ga4": {
    "measurement_id": "G-XXXXXXXXXX",
    "stream_id": "...",
    "domain": "eyalamit.co.il",
    "created": "2026-05-26"
  },
  "clarity": {
    "project_id": "...",
    "tracking_script_snippet": "..."
  },
  "ab_testing": {
    "variant_field": "eyal_cta_variant",
    "variants": ["form_only", "form_plus_wa", "wa_only"]
  }
}
```

**AC:**
- [ ] GA4 property חי, מקבל events ב-DebugView כשגולשים.
- [ ] Clarity מקליט session בדיקה.
- [ ] קונפיג נשמר ב-`hub/data/analytics-config.json`.

### Task B-PREP-4 — בדיקת בריאות סטייג'ינג + child theme (0.5 יום)
**מטרה:** לוודא שהסביבה מוכנה ליישום.

**פעולות:**
1. `curl -I https://eyalamit-co-il-2026.s887.upress.link/` → 200/302.
2. WP admin → Themes → ea-eyalamit פעיל? אם לא — להפעיל.
3. `wp theme list` → ea-eyalamit Status: Active.
4. בדיקת `wp-content/themes/ea-eyalamit/style.css` קיים; אם לא — להעלות סקלטון.
5. בדיקת `functions.php` ב-child theme — סינטקס תקין?
6. תיעוד ממצאים ב-`_COMMUNICATION/team_10/STAGING-HEALTH-CHECK-2026-05-26.md`.

**AC:**
- [ ] Staging חי.
- [ ] ea-eyalamit theme פעיל.
- [ ] PHP errors log נקי (24h).
- [ ] Backup DB סטייג'ינג נשמר (לפני שינויים).

### Task B-PREP-5 — MEDIA-IN-USE-INVENTORY (1 יום)
**מטרה:** הכנת הדו"ח שיהיה חוסם של WP-W2-09 (סינון מדיה). אם נכין אותו עכשיו — מקדמים את ה-cutover.

**פעולות:**
1. קריאת `eyalamit.co.il-legacy/docs/sitemap/ACCURATE-SITE-MAPPING-AFTER-ARCHIVE-2026-01-13_22-02-59.json`.
2. סינון `content.attachments[]` לפי `file_exists: true`.
3. הצלבה מול `relationships.page_attachments` + `relationships.post_attachments` — מי משתמש במה.
4. **כלל:** `usage_count > 0` בלבד (לפי F1 ב-DECISION RECORD).
5. תוצר: `_COMMUNICATION/team_40/MEDIA-IN-USE-INVENTORY-2026-05-26.json` (טכנית team_40 הוא בעלים, אבל team_10 יכול להפיק):

```json
{
  "meta": {
    "generated_at": "2026-05-26",
    "total_attachments_legacy": 319,
    "in_use": "<computed>",
    "to_migrate": "<computed>",
    "to_discard": "<computed>"
  },
  "in_use": [
    {"id": 1234, "filename": "...", "url": "...", "used_by": ["page_15177","post_4321"]},
    ...
  ],
  "discarded": [
    {"id": 5678, "filename": "...", "reason": "no_usage"},
    ...
  ]
}
```

**AC:**
- [ ] קובץ JSON תקין נוצר.
- [ ] `in_use` ≤ 319 ו-`in_use + discarded = 319`.
- [ ] לפחות 60-120 קבצים מסומנים `in_use` (אומדן).

### Task B-PREP-6 — FTP/SFTP credentials check (0.25 יום)
**פעולות:**
1. אימות שיש לצוות 10 גישת FTPS לסטייג'ינג uPress.
2. test upload + delete של file דמה.
3. תיעוד ב-`_COMMUNICATION/team_10/FTPS-ACCESS-CONFIRMED-2026-05-26.md` (לא לכלול סיסמאות!).

**AC:**
- [ ] FTPS עובד.
- [ ] write test הצליח.

### Task B-PREP-7 — סקירת מצב child theme `ea-eyalamit` (0.5 יום)
**מטרה:** לזהות מה כבר קיים שם מ-Wave1 ומה ידרוש refactor ב-Stage B.

**פעולות:**
1. `git log --oneline wp-content/themes/ea-eyalamit/` ב-eyalamit.co.il-legacy.
2. רשימת קבצי CSS/PHP/JS קיימים.
3. סימון:
   - **שמור** — קוד שעדיין רלוונטי (books-v2.css, books-reveal.js)
   - **לרענן** — קוד שדורש מיזוג עם D-14 tokens (אחרי Stage A)
   - **למחוק** — קוד ישן שלא יעבור (books-wave1.css)
4. תיעוד ב-`_COMMUNICATION/team_10/EA-EYALAMIT-CHILD-THEME-AUDIT-2026-05-26.md`.

**AC:**
- [ ] רשימה מלאה של כל הקבצים ב-theme.
- [ ] כל קובץ מסומן shamor/lerenan/limhok.

---

## 2. אורקסטרציה — סדר ביצוע ותלות בין משימות

### תלות פנימית

```
B-PREP-1 (plugins) ──┐
                     ├──→ ⏸ ממתין SMTP password מאייל
B-PREP-2 (MX verify)─┘

B-PREP-3 (GA4+Clarity) — עצמאי
B-PREP-4 (staging health) — עצמאי
B-PREP-5 (media inventory) — עצמאי, גדול
B-PREP-6 (FTPS) — עצמאי, קצר
B-PREP-7 (theme audit) — עצמאי
```

### סדר מומלץ (per צוות אחד working sequentially)

יום 1: B-PREP-6 (0.25) + B-PREP-1 (0.5) + B-PREP-4 (0.5) = 1.25 יום
יום 2: B-PREP-2 (0.5) + B-PREP-3 (1) = 1.5 ימים
יום 3: B-PREP-5 (1) = 1 יום
יום 4: B-PREP-7 (0.5) + sync + report = 1 יום

**סה"כ: 3-4 ימי עבודה** במקביל ל-Stage A של team_100 (~5 ימים).

### תיאום עם team_100

- **סוף יום 1:** עדכון מצב ב-`_COMMUNICATION/team_10/STAGE-B-PREP-PROGRESS-2026-05-26.md`.
- **סוף יום 3:** סקירת ביניים מול team_100 — האם A1 (Atom Inventory) מוכן? אם כן — אפשר להתחיל לחשוב על שיבוץ atoms.
- **סוף יום 4 / 5:** דוח השלמת B-PREP. ממתין ל-Stage A POC מאושר.

---

## 3. ולידציה לפני סגירת B-PREP

- [ ] כל 7 ה-AC ב-§1 סומנו `[x]`.
- [ ] 7 קבצי תיעוד נוצרו ב-`_COMMUNICATION/team_10/`.
- [ ] 0 שגיאות PHP ב-staging error log ב-72h האחרונות.
- [ ] GA4 RealTime מראה event (טסט ידני).
- [ ] Clarity מקליט session.
- [ ] MEDIA-IN-USE inventory עם count > 0 לפחות עבור 60 קבצים.

---

## 4. עקרונות חשובים מ-DECISION RECORD

- **Free + Minimal Tooling:** רק plugins חינמיים, רק מינימליים. אם אתה מרגיש שצריך plugin נוסף — שאל קודם.
- **אסור** WooCommerce, Elementor, Yoast Premium או premium plugins. אם נדרש — waiver מ-team_100.
- **A/B testing מהיום הראשון:** GA4 events + Clarity heatmaps פעילים מיד.

---

## 5. תוצרים סופיים של B-PREP — checklist

- [ ] `_COMMUNICATION/team_10/PLUGINS-INSTALLED-2026-05-26.md`
- [ ] `_COMMUNICATION/team_10/GOOGLE-WORKSPACE-VERIFICATION-2026-05-26.md`
- [ ] `hub/data/analytics-config.json` — GA4 + Clarity IDs
- [ ] `_COMMUNICATION/team_10/STAGING-HEALTH-CHECK-2026-05-26.md`
- [ ] `_COMMUNICATION/team_40/MEDIA-IN-USE-INVENTORY-2026-05-26.json` (~60-120 פריטים פעילים)
- [ ] `_COMMUNICATION/team_10/FTPS-ACCESS-CONFIRMED-2026-05-26.md`
- [ ] `_COMMUNICATION/team_10/EA-EYALAMIT-CHILD-THEME-AUDIT-2026-05-26.md`
- [ ] `_COMMUNICATION/team_10/STAGE-B-PREP-COMPLETION-REPORT-2026-XX-XX.md`

---

## 6. סיכון, התראות

| סיכון | חומרה | הקלה |
|--------|--------|------|
| Eyal לא מזין SMTP password בזמן | בינוני | טופס משלוח דרך `wp_mail()` default כ-fallback עד הזנה |
| Google Workspace MX לא נכון | נמוך | אימות `dig` קודם, לפני התקנת SMTP |
| Clarity דורש domain ownership verification | נמוך | תוכל לעבוד דרך הוספת JS snippet — לא דורש ownership |
| Staging פותח שגיאות PHP | בינוני | תיקון לפני המשך; אם לא — לסגנן ולחזור ל-team_100 |
| MEDIA-IN-USE inventory לא מוצא רוב הקבצים | בינוני | אם > 50% נמחקו — לאמת מול אייל לפני סינון |

---

## 7. סיום וחתימה

- **שעת התחלה:** 2026-05-26 (סשן מקבילי לזה של team_100)
- **שעת יעד סיום:** 2026-05-30 (3-4 ימי עבודה)
- **בעלי משימה:** team_10
- **שותפים:** team_20 (uPress access), team_40 (media inventory hand-off)
- **שער המשך:** המתנה ל-POC מאושר מ-team_100 לפני Stage B implementation.

**הפעולה הראשונה עכשיו:** B-PREP-6 (אימות FTPS) — קצר ופותר חוסם פוטנציאלי. אז B-PREP-1 (התקנת plugins) — מבסס תשתית. אז B-PREP-4 (staging health) — לפני שמתקדמים.
