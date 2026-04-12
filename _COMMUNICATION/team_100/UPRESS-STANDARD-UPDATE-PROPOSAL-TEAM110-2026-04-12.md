# הצעת עדכון: UPRESS_WORDPRESS_STANDARD_v2 → v2.1

**מאת:** Team 110 (eyalamit_build)  
**אל:** Team 100 (eyalamit_arch)  
**תאריך:** 2026-04-12  
**נושא:** עדכון עומק לנוהל uPress + WordPress לאחר session עבודה מאומץ — גילויים, תיקוני שגיאות, כלים חדשים  
**קובץ יעד לעדכון:** `docs/project/UPRESS_WORDPRESS_STANDARD_v2.md`  
**סוג:** Update Proposal (Team 110 → Team 100, per governance: eyalamit_arch מחזיק write authority על מסמכי פרויקט)

---

## רקע ומניע

במהלך session בניה של S002 (עמודי `/treatment` ו-`/method` באתר eyalamit) נתקלנו בסדרת בעיות סביבה שהאטו את העבודה ב-~8 שעות. כל הבעיות נפתרו לבסוף, אך חשפו פערים ממשיים בנוהל v2 — חלקם **שגיאות עובדתיות**, חלקם **מידע חסר**, וחלקם **כלים חדשים** שפותחו במהלך ה-session וצריכים להיכנס לנוהל.

הצעה זו מפרטת **6 שינויים נדרשים** עם הנמקה מלאה ו-diff מדויק לכל שינוי.

---

## שינוי 1 — §7.4: שגיאה עובדתית קריטית — Application Passwords ו-HTTPS

### הבעיה בנוהל הקיים (שורה 330–332)

```
- Application Passwords require **HTTPS**; they will not work over plain HTTP.
```

**זו שגיאה.** הנוהל הקיים גורם לצוותים לחשוב שאין דרך להפעיל Application Passwords בסביבת staging ללא SSL — וזה מוביל לאיבוד שעות עבודה. המציאות:

### הגורם האמיתי

WordPress בודק HTTPS לפני הפעלת Application Passwords **אלא אם** `WP_ENVIRONMENT_TYPE` מוגדר ל-`local` או `development` ב-`wp-config.php`. בסביבת staging ללא SSL, הוספת שורה אחת ל-wp-config מאפשרת את כל הפונקציונליות.

### אימות

```bash
# אחרי הוספת WP_ENVIRONMENT_TYPE=local לwp-config.php:
curl -s http://eyalamit-co-il-2026.s887.upress.link/wp-json/ | python3 -c "
import sys,json; d=json.load(sys.stdin)
print('application-passwords' in d.get('authentication',{}))
"
# Output: True
```

### הטקסט המוצע (החלפה ל-§7.4, bullet ראשון)

```markdown
- **Application Passwords ו-HTTP staging:** ברירת המחדל של WordPress דורשת HTTPS
  לשימוש ב-Application Passwords. **פתרון לסביבת staging ללא SSL:** הוסף שורה אחת
  ל-`wp-config.php` לפני `/* That's all, stop editing! */`:

  ```php
  define( 'WP_ENVIRONMENT_TYPE', 'local' ); // staging HTTP — enables Application Passwords without HTTPS
  ```

  ערכים תקינים: `local` | `development` | `staging` | `production`.
  ב-production עם HTTPS תקין — אין צורך בהגדרה זו.
  **שיטת הוספה:** הורד wp-config.php ב-FTP, הוסף השורה, העלה בחזרה.
  לאחר הוספה — אמת עם `curl .../wp-json/ | python3 -c "import sys,json; d=json.load(sys.stdin); print('application-passwords' in d.get('authentication',{}))"`.
```

---

## שינוי 2 — §7.2: שיטה קנונית חדשה ליצירת Application Password (ללא deployment)

### הבעיה בנוהל הקיים

הנוהל מציע שיטה אחת: פריסת קוד PHP ב-functions.php. זה מחייב deployment, גורם לזיהום בקוד, ודורש ניקוי ידני אחרי. בפועל, ישנה שיטה נקייה יותר שהוכחה עובדת: cookie session + REST API nonce.

### השיטה החדשה שהוכחה (Python)

```python
import requests, re

STAGING = "http://eyalamit-co-il-2026.s887.upress.link"  # or https://...
s = requests.Session()

# Step 1: Login (cookie auth)
s.cookies.set('wordpress_test_cookie', 'WP Cookie check')
r = s.post(STAGING + "/wp-login.php", data={
    'log': '{UPRESS_WP_ADMIN_USER}',
    'pwd': '{UPRESS_WP_ADMIN_PASS}',
    'wp-submit': 'Log In',
    'redirect_to': '/wp-admin/',
    'testcookie': '1',
}, allow_redirects=True, timeout=15)
assert 'wp-admin' in r.url, "Login failed"

# Step 2: Get REST API nonce
nonce = s.get(STAGING + "/wp-admin/admin-ajax.php",
              params={'action': 'rest-nonce'}, timeout=10).text.strip()

# Step 3: Create Application Password via REST API
r_app = s.post(
    STAGING + "/wp-json/wp/v2/users/1/application-passwords",
    json={"name": "agent-automation"},
    headers={"X-WP-Nonce": nonce, "Content-Type": "application/json"},
    timeout=15
)
assert r_app.status_code == 201
raw_pass = r_app.json()['password']  # WordPress-generated 24-char password
```

**יתרונות לעומת שיטת functions.php:**
- אין deployment נדרש
- אין זיהום קוד לניקוי
- WordPress מייצר את הסיסמה ומאחסן אותה בצורה נכונה
- עובד גם מחוץ ל-MCP browser — Python בלבד

### הוספה מוצעת ל-§7.2 (לפני "Checklist after retrieval")

```markdown
**Preferred programmatic method (no deployment required):**
Use cookie session + REST API nonce — cleaner and leaves no code footprint:

[קוד Python כמו לעיל]

**Note:** This requires `UPRESS_WP_ADMIN_USER` and `UPRESS_WP_ADMIN_PASS` to be set and correct
in `.env.upress`. If login fails, verify the `user_login` field (not email) via SQL (see §4.4).
The functions.php hook method (below) is a fallback for environments where wp-login.php is blocked.
```

---

## שינוי 3 — §13: הוספת 5 לקחים קריטיים חדשים

### לקח א׳: mu-plugins — אזור מוגבל, סכנת 500 מיידי

**מה קרה:** קובץ PHP זמני (`_tmp_reset_pass.php`) הועלה ל-`wp-content/mu-plugins/` דרך FTP. התוצאה: האתר כולו החזיר HTTP 500 — מיידית.

**הסיבה:** WordPress מריץ אוטומטית **כל קובץ PHP** ב-`mu-plugins/` בכל בקשה, לפני כל שאר הקוד. קובץ שקרא `require_once $wp_load` גרם ל-WordPress לנסות לאתחל את עצמו פעמיים — fatal error.

**כלל חדש לנוהל:**
```markdown
### mu-plugins — אזור מוגבל לקוד זמני (Critical)

**NEVER** שמור קבצי PHP זמניים (scripts, one-off utilities, debug tools) ב-`wp-content/mu-plugins/`.
כל קובץ PHP ב-mu-plugins מורץ אוטומטית בכל בקשת WordPress — גם בלי activation.
קובץ שגוי = HTTP 500 מיידי לאתר כולו.

- **קוד זמני:** אל תעלה לשרת כלל. השתמש ב-REST API או functions.php hook מגודר.
- **mu-plugins לגיטימיים:** רק plugins שצריכים לרוץ תמיד, לפני שאר ה-plugins.
  מקם ב-`site/wp-content/mu-plugins/` בrepository ופרוס דרך `ftp_deploy_site_wp_content.py`.
```

### לקח ב׳: גילוי קרדנשיאלס WP Admin בסביבת staging חדשה

**מה קרה:** קרדנשיאלס WP Admin שהיו ב-`.env.upress` היו של האתר הישן (production). uPress מתקין WordPress רענן בסביבת staging עם admin user שונה לחלוטין.

**שיטת גילוי (SQL דרך phpMyAdmin):**
```sql
SELECT ID, user_login, user_email, user_registered
FROM {prefix}_users ORDER BY ID;
```

**כלל חדש:**
```markdown
### WP Admin Credentials בסביבת Staging חדשה

uPress מתקין WordPress רענן בסביבת sandbox עם admin user שנוצר בהתקנה — 
שאינו בהכרח הemail או ה-user_login שנמצאים ב-`.env.upress` של production.

**פרוטוקול גילוי לסביבה חדשה:**
1. התחבר ל-phpMyAdmin (`UPRESS_PHPMYADMIN_URL` + `UPRESS_DB_USER/PASS`)
2. הרץ: `SELECT ID, user_login, user_email FROM {prefix}_users ORDER BY ID;`
3. עדכן `.env.upress` עם `user_login` הנכון (לא email) ב-`UPRESS_WP_ADMIN_USER`

**איפוס סיסמה דרך SQL (ללא WP-CLI):**
```sql
-- WP מקבל MD5 ומשדרג אוטומטית ל-phpass בכניסה הבאה
UPDATE {prefix}_users SET user_pass=MD5('NewPassword123!') WHERE user_login='{user_login}';
```
```

### לקח ג׳: אל תחשב phpass ידנית

**מה קרה:** נסינו לכתוב Python phpass hash generator כדי ליצור Application Password ולשמור ב-DB. ה-hash היה שגוי (iteration count שגוי: 256 במקום 8192, salt באורך שגוי). WP דחה אותו בשקט — 401 ללא הסבר.

**כלל חדש:**
```markdown
### אל תחשב phpass hash ידנית

WP משתמש ב-phpass עם `count_log2=13` (8192 iterations) ו-8-char base64-encoded salt.
ניסיון ל-implement phpass ב-Python/JavaScript ידנית — גבוה מאוד להיכשל בשקט.

**לאיפוס סיסמת WP admin:** השתמש ב-SQL MD5 (ראה לקח ב׳) — WP מקבל MD5 ומשדרג.  
**ליצירת Application Password:** השתמש ב-REST API (cookie session method, ראה §7.2).  
**לעולם אל** תשמור Application Password hash ידנית ב-DB — WP מנהל זאת דרך `WP_Application_Passwords::create_new_application_password()`.
```

### לקח ד׳: phpMyAdmin Python session — endpoint ורוטה נכונים

**מה קרה:** ניסיון ראשון לפנות ל-phpMyAdmin דרך Python נכשל עם "Token mismatch". הסיבה: שימוש בtoken מלפני ה-login (pre-login token) במקום בtoken שמוחזר ב-response אחרי ה-login.

**Pattern עובד:**
```python
import requests, re, json

BASE = "https://s-il-{NNN}-{code}.upress.io/{token}"
s = requests.Session()
s.verify = False  # phpMyAdmin on uPress may have HTTPS mismatch warning

# Step 1: Get pre-login token
r1 = s.get(BASE + "/index.php", timeout=15)
pre_token = re.search(r'name="token" value="([^"]+)"', r1.text).group(1)

# Step 2: Login
r2 = s.post(BASE + "/index.php", data={
    'pma_username': '{UPRESS_DB_USER}',
    'pma_password': '{UPRESS_DB_PASS}',
    'server': '1', 'lang': 'en', 'token': pre_token,
}, timeout=15, allow_redirects=True)

# CRITICAL: Extract POST-LOGIN token (different from pre-login token!)
post_token = re.findall(r'name="token" value="([^"]+)"', r2.text)[0]

# Step 3: Execute SQL
r3 = s.post(BASE + "/index.php?route=/import&db={UPRESS_DB_NAME}", data={
    'db': '{UPRESS_DB_NAME}', 'table': '', 'token': post_token,
    'sql_query': 'SELECT ID, user_login FROM {prefix}_users;',
    'ajax_request': '1', 'server': '1',
}, timeout=20)
result = json.loads(r3.text)
print(result['success'], result['message'])
```

**כלל:** `route=/import` עם `ajax_request=1` הוא endpoint SQL. תמיד השתמש בpost-login token.

### לקח ה׳: גילוי table prefix לפני כל פעולת DB

**מה קרה:** ניסינו ל-import SQL backup עם prefix `wp_` לסביבה שה-prefix שלה `heu_`. בזבוז זמן.

**כלל מחוזק (מעבר למה שכבר קיים ב-§4.2):**
```markdown
### Table Prefix — בדוק תמיד לפני DB operations

```bash
# דרך FTP: קרא wp-config.php וחפש:
grep "table_prefix" wp-config.php

# דרך phpMyAdmin:
SHOW TABLES LIKE '%users';
-- הPrefix הוא כל מה שלפני "users"
```

עדכן `UPRESS_DB_TABLE_PREFIX` ב-`.env.upress` מיד אחרי גילוי. 
לעולם אל תניח `wp_`.
```

---

## שינוי 4 — §12: עדכון Credentials Template

### פערים בtemplate הקיים

1. **`UPRESS_WP_ADMIN_USER`** — הערה קיימת `{admin_email}` מטעה. זה צריך להיות `user_login`, לא email.
2. **חסר `UPRESS_FTP_REMOTE_ROOT`** — קריטי כי path משתנה בין חשבונות (ראה §3).
3. **חסר `UPRESS_FTP_USE_TLS`** — נדרש להבדיל בין staging (ללא TLS לפעמים) ל-production.
4. **`UPRESS_DB_TABLE_PREFIX`** — צריך ערך דוגמה שמדגיש שאינו `wp_`.

### Template מעודכן מוצע (§12 כולו)

```env
# ── FTPS / FTP ──
UPRESS_SFTP_HOST=ftp.s{NNN}.upress.link
UPRESS_SFTP_PORT=21
UPRESS_SFTP_USER={user}@{domain}
UPRESS_SFTP_PASS={password}
UPRESS_FTP_REMOTE_ROOT=/           # Path from FTP root to WP root. '/' if already at WP root.
UPRESS_FTP_USE_TLS=true            # true for production; false for staging if TLS fails

# ── URLs (staging: http://, production: https://) ──
UPRESS_PUBLIC_BASE=https://{domain}
UPRESS_WP_ADMIN=https://{domain}/wp-admin
UPRESS_WP_REST_BASE=https://{domain}/wp-json
UPRESS_PAGE_SLUG=/{primary_page_slug}
UPRESS_UPLOAD_PATH=wp-content/uploads/{project}

# ── phpMyAdmin + DB ──
UPRESS_PHPMYADMIN_URL=https://s-il-{NNN}-{code}.upress.io/{token}/
UPRESS_DB_NAME={db_name}
UPRESS_DB_USER={db_user}
UPRESS_DB_PASS={db_pass}
UPRESS_DB_TABLE_PREFIX={abc}_      # NEVER assume 'wp_' — discover from wp-config.php or SHOW TABLES

# ── WordPress Admin (dashboard login) ──
# Use user_login (NOT email) — may differ: e.g., 'nimrodadmin' not 'admin@domain.com'
# Discover via SQL: SELECT user_login FROM {prefix}_users WHERE ID=1;
UPRESS_WP_ADMIN_USER={user_login}
UPRESS_WP_ADMIN_PASS={admin_password}

# ── REST API Application Password ──
# Format: "XXXX XXXX XXXX XXXX XXXX XXXX" (WordPress generates on creation)
# Create via: cookie-session + REST API (see §7.2 preferred method)
UPRESS_WP_APP_USER={user_login}    # Same as UPRESS_WP_ADMIN_USER
UPRESS_WP_APP_PASS={application_password_with_spaces}
```

---

## שינוי 5 — §11: הוספת `wp_rest_client.py` לmatrix הכלים

### Python REST client — קיים ועובד

במהלך ה-session פותח `scripts/wp_rest_client.py` — Python module שמכיל את כל פעולות REST הנדרשות, עם טעינת קרדנשיאלס אוטומטית מ-`.env.upress`.

**API ציבורי:**
```python
from scripts.wp_rest_client import verify_auth, ensure_page, set_page_template, list_pages, get_page_by_slug

verify_auth()                          # → bool
ensure_page(slug, title, status)       # → int (post_id)
set_page_template(post_id, template)   # → None
get_page_by_slug(slug)                 # → dict | None
list_pages()                           # → list[dict]
```

**CLI:**
```bash
python3 scripts/wp_rest_client.py --verify
python3 scripts/wp_rest_client.py --list-pages
python3 scripts/wp_rest_client.py --ensure-page treatment "טיפול בדיג׳רידו"
python3 scripts/wp_rest_client.py --set-template 54 page-templates/template-treatment.php
```

**הוספה מוצעת ל-§11 (Decision Matrix), שורה חדשה:**

| Task | Recommended Channel | Rationale |
|------|---------------------|-----------|
| Create / update WP page (slug, title, template, status) | `scripts/wp_rest_client.py` | Python module עם auth אוטומטי מ-.env.upress. ראה `scripts/wp_rest_client.py`. |

**הוספה ל-§6.2 (Requirements) או §7.3 — הפניה ל-`verify_upress_rest.py`:**
```
Verification script: python3 scripts/verify_upress_rest.py
Requires: UPRESS_WP_REST_BASE, UPRESS_WP_APP_USER, UPRESS_WP_APP_PASS in .env.upress
```

---

## שינוי 6 — הוספת §5 Note: WP_ENVIRONMENT_TYPE בסביבת Staging

בסעיף §5 (Environments — Staging vs Production), הוסף note:

```markdown
### WP_ENVIRONMENT_TYPE — הגדרה קריטית לסביבת Staging

WordPress משתמש ב-`WP_ENVIRONMENT_TYPE` כדי להתנהג אחרת בסביבות שונות.
בסביבת staging ללא SSL, הגדר ב-`wp-config.php` (לפני "stop editing"):

```php
define( 'WP_ENVIRONMENT_TYPE', 'local' ); // or 'development'
```

**אפקטים:**
- מפעיל Application Passwords ללא HTTPS (קריטי לסטייגינג)
- לא מפעיל WP_DEBUG אוטומטית (אין השפעה על תצוגה)
- **בפרודקשן עם HTTPS תקין — אין צורך בהגדרה זו**

**שיטת הוספה:** `scripts/ftp_sync_wp_config_db_password.py` תומך ב-`UPRESS_WP_ENVIRONMENT_TYPE` ב-`.env.upress` — מוסיף את ה-constant אוטומטית.
```

---

## סיכום — טבלת שינויים מוצעים

| # | סעיף | סוג שינוי | דחיפות |
|---|------|-----------|---------|
| 1 | §7.4 | **תיקון שגיאה עובדתית** — HTTPS אינו חובה עם WP_ENVIRONMENT_TYPE | 🔴 קריטי |
| 2 | §7.2 | **הוספה** — שיטה קנונית חדשה ליצירת Application Password | 🔴 קריטי |
| 3 | §13 | **הוספה** — 5 לקחים חדשים (mu-plugins, admin creds, phpass, phpMyAdmin, prefix) | 🔴 קריטי |
| 4 | §12 | **עדכון** — Template קרדנשיאלס + הסברים | 🟡 חשוב |
| 5 | §11 | **הוספה** — `wp_rest_client.py` ב-Decision Matrix | 🟡 חשוב |
| 6 | §5 | **הוספה** — Note על WP_ENVIRONMENT_TYPE | 🟡 חשוב |

---

## פרויקטים מושפעים

נוהל זה מוגדר כ-**cross-project** (`docs/project/UPRESS_WORDPRESS_STANDARD_v2.md`, שורה 5).  
הפרויקטים הידועים על אותו שרת uPress:
- `EyalAmit.co.il-2026` (s887) — נבדק ואומת
- `SmallFarmsAgents` / `nimrod.bio` — כנראה מושפע מלקחים 3א-ה, 4, 5
- פרויקטים עתידיים — חובה שיוכנסו לנוהל לפני פריסה

---

*מסמך זה הוכן על-ידי eyalamit_build (Team 110) בהתאם לנוהל AOS — Team 110 אינו מוסמך לעדכן `docs/project/` ישירות. מסמך זה מועבר ל-Team 100 לאישור ועדכון.*
