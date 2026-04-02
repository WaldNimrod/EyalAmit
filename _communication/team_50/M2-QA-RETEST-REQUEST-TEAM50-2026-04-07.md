# בקשת בדיקה חוזרת (ריטסט) — צוות **50** (אחרי purge פאנל uPress)

**תאריך:** 2026-04-07  
**מוציא:** צוות **100** (אימות חזית אוטומטי + אריזת בקשה)  
**נמען:** צוות **50** (QA)

**סטייג'ינג:** `https://eyalamit-co-il-2026.s887.upress.link/`

---

## 1. מה בוצע בצד תפעול (לפי דיווח מחזיק)

- **ניקוי מטמון** בממשק uPress (פיתוח → ניהול כלי אחסון → בצע ניקוי מטמון), ולפי הצורך **EzCache** / Varnish לפי התיעוד ב־[`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) P4 ו־[`M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md`](../team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) §0.

---

## 2. אימות מצב (צוות 100, `curl` ללא query)

| בדיקה | תוצאה (צילום מצב) |
|--------|---------------------|
| **`GET /`** | `body` כולל **`page-id-16`** (עמוד בית סטטי) — **לא** `home blog` / `Hello world!`. |
| **`GET /contact/`** | מרקאפ Fluent: **`ff-el-form`**, **`fluentform_`**, **`ff_`** — **לא** shortcode גולמי `[fluentform …]`. |
| **כותרות `GET /`** | `cache-control: no-cache, must-revalidate, max-age=0, no-store, private` · `x-robots-tag: noindex, nofollow`. |

**מסקנה טכנית:** החסמים שדווחו ב־[`M2-G2-QA-RETEST-TEAM50-2026-04-02.md`](./M2-G2-QA-RETEST-TEAM50-2026-04-02.md) (BUG-06 / BUG-07 — מטמון stale) **נראים מתוקנים** בבדיקת חזית זו. נדרש **ריטסט רשמי** של צוות 50 ועדכון דוח G2 (ו־F2/SMTP אם רלוונטי).

**לאחר הריטסט:** משוב QA קנוני (TLS בסטייג'ינג, סטטוס Q3/G2, F2) — [`M2-QA-CANONICAL-FEEDBACK-TEAM50-STAGING-TLS-G2-2026-04-02.md`](./M2-QA-CANONICAL-FEEDBACK-TEAM50-STAGING-TLS-G2-2026-04-02.md).

---

## 3. מנדט וצ'קליסט מלא

להמשיך לפי:

- [`../team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md`](../team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md)

דוחות קודמים:

- תשתית (PASS לפי דיווח): [`M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](./M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md)  
- G2 ריטסט קודם (FAIL): [`M2-G2-QA-RETEST-TEAM50-2026-04-02.md`](./M2-G2-QA-RETEST-TEAM50-2026-04-02.md)

**מאגר (הקשר):** MU כולל `ea-staging-noindex` **v1.0.2**, `ea-m2-ensure-fluent-active` **v1.0.1**, `ea-m2-seed-shell-once` **v1.0.4** — ראו [`../../site/README.md`](../../site/README.md).

---

## 4. טקסט העברה (העתקה לצוות 50)

> **ריטסט G2 ממוקד (אחרי purge uPress):**  
> בוצע ניקוי מטמון בממשק; צוות 100 אימת ב־`curl` **בלי** query:  
> • `/` → `page-id-16` (בית סטטי).  
> • `/contact/` → טופס Fluent מרונדר (`ff-el-form` / `fluentform_`).  
> **בקשה:** להריץ מחדש את מטריצת G2 לפי המנדט [`_communication/team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md`](../../_communication/team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md), לעדכן דוח (או דוח ריטסט חדש בתאריך ביצוע) תחת `team_50/`, ולסגור או להשאיר פתוח **F2** (שליחת טופס / SMTP) לפי תוצאה.  
> מסמך בקשה קנוני: [`_communication/team_50/M2-QA-RETEST-REQUEST-TEAM50-2026-04-07.md`](./M2-QA-RETEST-REQUEST-TEAM50-2026-04-07.md).

---

**חתימת מוציא (100):** 2026-04-07
