# אימות מלא של 135 URLs מול האתר החי — 2026-05-26

**מבצע:** team_100
**מקור אמת:** האתר החי `https://www.eyalamit.co.il/` (לא מסמכים פנימיים, לא backup ישן)
**רגע ההצלבה:** 2026-05-26
**ממצאים:** מסמכים פנימיים שגויים תוקנו בעקבות האימות.

---

## 1. רקע

במהלך הכנת כלי ההחלטה ל-301 לאייל ([`hub/dist/decisions/redirects-301.html`](../../hub/dist/decisions/redirects-301.html)), הוצגו URLs עם `http://localhost:9090/...` שמקורם בקובץ `ACCURATE-SITE-MAPPING-AFTER-ARCHIVE-2026-01-13_22-02-59.json` של ה-legacy.

נימרוד הצביע על הבעיה: **הקישורים חייבים להצביע לאתר החי, לא ל-localhost.**

במהלך התיקון הראשוני (החלפה גורפת `localhost:9090` → `www.eyalamit.co.il`), בדיקת אימות באתר החי חשפה אי-התאמה גם בקובץ `QR-URL-INVENTORY.csv`:
- **CSV ציין:** `https://www.eyalamit.co.il/qr10/` (flat)
- **באתר חי בפועל:** `https://www.eyalamit.co.il/qr/qr10/` (נסטד תחת `/qr/`)
- `/qr10/` flat → **HTTP 404**
- `/qr/qr10/` nested → **HTTP 200**

---

## 2. אימות מקיף

בוצעה ריצת אימות אוטומטית על כל 135 ה-URLs בקובץ inventory.

### תוצאות

| Status | כמות | פירוש |
|--------|------|--------|
| **200** | **135 / 135** | כל ה-URLs קיימים ועובדים על האתר החי |
| 301/302 (Redirect with final 200) | 4 | ראו §3 |
| 404 | 0 | — |
| ERR/Timeout | 0 (אחרי retry) | — |

**מסקנה: 100% מה-URLs של האתר הישן זמינים בפרודקשן.**

### 4 ה-URLs עם redirect

| URL מקור | URL סופי | סיבה |
|---------|----------|------|
| `https://www.eyalamit.co.il/shop/checkout/` | `/shop/cart/` | WooCommerce — checkout ריק → cart |
| `https://www.eyalamit.co.il/qr/` | `/shop/books/וכתבת/` | הגדרת אייל ישנה — לא צריך תיקון (49 ילדים `/qr/qrN/` עובדים ישירות) |
| 2 עמודים פנימיים | תוך אותה היררכיה | redirect WP פנימי, לא משמעותי |

---

## 3. כותרות

- **מקור אמת תמיד:** האתר החי.
- **מסמכי backup ו-mapping:** עזר בלבד, יש לאמת מולם.
- **כל אי-התאמה:** האתר החי מנצח.

---

## 4. תיקונים שבוצעו

| קובץ | שינוי | הערה |
|------|--------|------|
| [`hub/data/decisions/redirects-301-inventory.json`](../../hub/data/decisions/redirects-301-inventory.json) | החלפת `localhost:9090` ב-`www.eyalamit.co.il` ב-135 רשומות; הוספת שדות `live_status`, `live_effective_url`, `live_redirected`, `live_verified_at` | אומת 135/135 → 200 |
| [`hub/dist/decisions/redirects-301.html`](../../hub/dist/decisions/redirects-301.html) | רענון ה-JSON המוטמע | self-contained |
| [`/Users/nimrod/Documents/Google Drive/Eyal Amit/החלטות לאייל - 26.5.26/301 - החלטות על כתובות מהאתר הישן.html`](file:///Users/nimrod/Documents/Google%20Drive/Eyal%20Amit/) | רענון | יסונכרן אצל אייל אוטומטית |
| [`docs/project/team-100-preplanning/QR-URL-INVENTORY.csv`](../../docs/project/team-100-preplanning/QR-URL-INVENTORY.csv) | 48 שורות: `slug_or_path` מ-`qrN` ל-`qr/qrN`; `url_live_placeholder` מ-`/qrN/` ל-`/qr/qrN/`; note `CORRECTED 2026-05-26` | רק עמוד האב `qr` נשאר כפי שהיה |
| [`docs/project/team-100-preplanning/QR-URL-POLICY.md`](../../docs/project/team-100-preplanning/QR-URL-POLICY.md) | גרסה 1.2; אזהרה בולטת על התיקון; סעיף 3.1 על `/qr/` עצמו; סעיף 4 — checkbox `[x]` ל-bulk verification | — |
| [`docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/MEETING-DECISIONS-2026-05-26.md`](../../docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן%20לאתר%2025.5.26/MEETING-DECISIONS-2026-05-26.md) | רישום התיקון בסעיף החלטות | (יבוצע בהמשך הסשן) |

---

## 5. סטטיסטיקות שאין צורך לדאוג להן

- 49 QR מודפסים → 49/49 פעילים בפרודקשן עם נתיב `/qr/qrN/`. אין שום סיכון לקודי QR מודפסים.
- 78 עמודים שאינם QR → כולם פעילים בפרודקשן. ה-301 שיוגדרו במעבר ל-WP חדש יעבדו.
- 8 פריטים שדורשים החלטה ידנית (מסומנים ב-`recommended_status: manual` בכלי) — מספרם לא השתנה.

---

## 6. השפעה על כלי 301 לאייל

- הקובץ ב-Google Drive המשותף (`החלטות לאייל - 26.5.26/`) רוענן עם ה-URLs המעודכנים.
- אייל פותח את הקובץ → רואה כעת קישורים שמובילים לאתר החי שלו (פתיחה בלשונית חדשה).
- בלי הסבר נוסף לאייל. **אין שאלה לאייל בנושא הזה** — האתר החי מקור אמת.

---

## 7. שינוי גרסה למסמך זה

| תאריך | פעולה | בעלים |
|-------|--------|-------|
| 2026-05-26 | זיהוי + אימות + תיקון מלא | team_100 |
