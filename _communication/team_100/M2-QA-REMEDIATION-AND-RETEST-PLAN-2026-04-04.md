# M2 — תוכנית תיקון ושיפור אחרי QA צוות 50 + קריטריונים לבדיקה חוזרת

**תאריך:** 2026-04-04  
**מוציא:** צוות **100**  
**נמענים:** צוות **10** (ביצוע סטייג'ינג / wp-admin — **מנדט הועבר אליהם**), צוות **50** (בדיקה חוזרת), צוות **20** (runbook §14 עודכן ליישור QA תשתית)

**סטטוס חלק צוות 100 (מאגר + תיעוד מסגרת):** **הושלם** (2026-04-04). סגירת מעקב כוללת דורשת PASS מ־50 על Q3 + ביטול BLOCKED ב־G2 אחרי ביצוע 10.

**מקור משוב:**  
[`../team_50/M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](../team_50/M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md) (**FAIL** — Q3 WP-CLI),  
[`../team_50/M2-G2-QA-REPORT-TEAM50-2026-04-02.md`](../team_50/M2-G2-QA-REPORT-TEAM50-2026-04-02.md) (**BLOCKED** — G4 ומטה).

---

## 1. סיכום ממצאים (מקובץ)

| תחום | ממצא | בעלות עיקרית |
|------|------|----------------|
| תשתית מקומית | `wp` לא נמצא בקונטיינר הרץ למרות Dockerfile; סביבה מקומית עלולה להיות לפני סיום התקנת WP | **100 / מאגר** — כפיית rebuild + אימות בבנייה |
| תיעוד QA | בבקשת תשתית צוין §11.1; הסעיף הרלוונטי ב־runbook הוא **§14** | **100** — יישור הפניה בבקשת הבקרה |
| סטייג'ינג G2 | Child + noindex — כן; ייבוא WXR, קריאה, תפריטים, `/contact/`, `/en/`, Yoast P15 — לא / לא ניתן לאמת | **10** — השלמת צעדי wp-admin המתועדים |

---

## 2. תיקונים במאגר — **בוצעו** (צוות 100)

| # | רכיב | מה נעשה |
|---|------|---------|
| 1 | [`local/Dockerfile.wordpress`](../../local/Dockerfile.wordpress) | אחרי התקנת WP-CLI: `&& /usr/local/bin/wp --info` — כשל בבנייה אם ה־phar לא תקין |
| 2 | [`local/docker-compose.yml`](../../local/docker-compose.yml) | תג תמונה `eyalamit-local-wp:xdebug-wpcli-v2` + הערה שלא לעבוד מתמונה ישנה בלי CLI |
| 3 | [`local/README.md`](../../local/README.md) | `build --no-cache`, אימות `/usr/local/bin/wp --info`, הסבר אחרי `git pull` |
| 4 | [`scripts/ftp_deploy_site_wp_content.py`](../../scripts/ftp_deploy_site_wp_content.py) | `--upload-wxr` → `wp-content/uploads/ea-m2-seed/m2-pages-seed.wxr` |
| 5 | [`../team_50/M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md`](../team_50/M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md) | Q5 מפנה ל־runbook **§14** (תיקון טעות §11.1) |
| 6 | [`../../docs/PROJECT-ENTRY.md`](../../docs/PROJECT-ENTRY.md) · [`../../AGENTS.md`](../../AGENTS.md) | קישורים למסמך זה ול־[`M2-G2-STAGING-P0-COMPLETION-2026-04-04.md`](../team_10/M2-G2-STAGING-P0-COMPLETION-2026-04-04.md) |
| 7 | Runbook §14 | [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) — עודכן יישור מול דוח QA (rebuild, תג תמונה) |

---

## 3. הוראות לצוות 10 — השלמת סטייג'ינג (P0) — **בעלות 10 בלבד**

מסמך צעד־אחר־צעד: [`../team_10/M2-G2-STAGING-P0-COMPLETION-2026-04-04.md`](../team_10/M2-G2-STAGING-P0-COMPLETION-2026-04-04.md). צוות 100 אינו מבצע שלבי wp-admin אלה; המנדט הועבר לצוות 10.

בקצרה: ייבוא WXR → הגדרות קריאה (בית סטטי + בלוג) → תפריטים T1–T6 → Fluent ב־`/contact/` → עמוד EN + מחלקת `ea-lang-en` → Yoast noindex ל־`therapist-training`.

---

## 4. קריטריונים לבדיקה חוזרת — צוות 50

### 4.1 תשתית (חידוש Q3 ואופציונלי Q2)

- **עדכון 2026-04-06:** ראו מנדט [`M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md`](./M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md) — `/usr/bin/wp`, `verify_local_wp_cli.sh`, `--force-recreate`.
- מתוך `local/`, אחרי `git pull` ו־`docker compose build --no-cache wordpress` + `docker compose up -d --force-recreate wordpress`:
  - `docker compose exec wordpress /usr/bin/wp --path=/var/www/html --allow-root cli info` — **חייב** לצאת 0 ולהדפיס גרסת WP-CLI.
  - אופציונלי: `bash scripts/verify_local_wp_cli.sh` משורש המאגר.
- Q2: אם `WORDPRESS_PORT` ב־`.env` שונה מ־9090 — לתעד בדוח את ה־URL בפועל (לא כשגיאה).

### 4.2 G2 מוצרי (פתיחת BLOCKED)

לאחר ביצוע §3:

- `curl -k -sI` ל־`/`, `/contact/`, `/en/`, `/home/`, `/blog/`, `/services/` — **200** (או הפניה מתועדת ל־200), לא 404 לעמודי הליבה של M2.
- דף הבית — לא רשימת פוסטים ברירת מחדל עם «Hello world!» בלבד; תואם הגדרת בית סטטי.
- תפריט ראשי — מבנה M2 (לא רק «Sample Page»).
- Yoast: `therapist-training` — noindex ברמת העמוד (P15), כשהעמוד קיים.
- Fluent: טופס זמין ב־`/contact/`; שליחת בדיקה + לוג דוא״ל לפי נוהל הקיים. **מטמון קצה:** אם `GET /contact/` או `GET /` מחזירים HTML ישן אבל אותו נתיב עם `?cb=…` נכון — **ניקוי מטמון uPress** (runbook P4 + EzCache אם מותקן); לא סימן ל־Fluent כבוי — לאמת עם `wp-json` (מרחב `fluentform/v1`).

---

## 5. סטטוס מסירה

- **צוות 100 (מאגר):** הושלם — ראו §2.  
- **צוות 10:** לבצע §3; אחר כך **צוות 50** מריץ מחדש §4.1 + §4.2 ומעדכן דוחות.  
- **סגירת מעקב ארכיטקטורה:** כאשר **תשתית = PASS** ו־**G2 ≠ BLOCKED** (או חריגה מתועדת מ־100).

**עדכון 2026-04-08:** תשתית **PASS** (דוח Q3) + G2 **PASS WITH NOTES** (משוב קנוני 50) — **GO לקליטת תוכן** לפי [`M2-CONTENT-INTAKE-INFRASTRUCTURE-GO-TEAM100-2026-04-08.md`](./M2-CONTENT-INTAKE-INFRASTRUCTURE-GO-TEAM100-2026-04-08.md); סגירת F2 לפני פרודקשן.

**חתימת צוות 100:** תוכנית + יישום חלק המאגר — **2026-04-04**
