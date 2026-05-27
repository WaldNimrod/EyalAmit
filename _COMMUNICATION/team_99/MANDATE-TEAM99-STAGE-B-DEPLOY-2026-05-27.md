---
id: MANDATE-TEAM99-STAGE-B-DEPLOY-2026-05-27
title: מנדט team_99 — FTPS deploy Stage B + WP smoke page + TLS renew
status: ACTIVE — execute on waldhomeserver SSH session
date: 2026-05-27
from_team: team_00 (nimrod, Principal) via team_100
to_team: team_99 (Home Server Team — Server-side ops)
parent_remediation: ../team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md
parent_verdict: ../team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md (FAIL Round 1)
operating_model: ISOLATED_BRANCH or DIRECT (deploy is non-code; direct ok)
profile: L0
wp: WP-W2-01-STAGE-B-IMPL (remediation cycle)
---

# מנדט team_99 — Stage B Deploy + Smoke Page + TLS

## 0. הקשר

team_50 verdict v1.0.0 על WP-W2-01-STAGE-B-IMPL = FAIL Round 1. שורש כשל: **קוד קיים ב-git אבל לא דחוף ל-staging**. team_50 בדיקות staging חוזרות 404 לכל הקבצים החדשים.

team_99 = הצוות היחיד עם SSH/Tailscale ל-waldhomeserver + WP-CLI/FTPS credentials של uPress. אתם המבצעים הקריטיים של 3 משימות מקבילות (R1+R3+R4 ב-Remediation Plan).

---

## 1. סקופ — 3 משימות

### Task A — FTPS Deploy (30 דק', BLOCKER)

**מטרה:** העברת Stage B theme tree ל-uPress staging.

**מקור:** `EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/` (commit `e165218`, מעודכן בRound 2 לפני R2 patch — ראו §3).
**יעד:** uPress FTPS path `/wp-content/themes/ea-eyalamit/`.

**צעדים:**

1. **Pull latest** ב-waldhomeserver:
   ```bash
   cd /path/to/eyalamit_repo  # path להתאמה בשרת
   git fetch origin && git pull --rebase origin main
   git log --oneline -3
   # ודא ש-605d46c או later מופיע
   ```

2. **קבל credentials FTPS** מ-`_COMMUNICATION/team_60/FTPS-VERIFY-2026-05-26.md` (working).

3. **רשימת קבצים להעלאה** (relative ל-`site/wp-content/themes/ea-eyalamit/`):
   - `assets/css/ea-tokens.css`
   - `assets/css/ea-animations.css`
   - `assets/css/ea-atoms.css`
   - `assets/js/ea-ab-testing.js` (⚠ ודא **AFTER** R2 patch — ראו §3)
   - `assets/js/ea-entrance.js`
   - `assets/js/ea-scroll.js`
   - `assets/js/ea-hero.js`
   - `inc/wave2-stage-b.php`
   - `inc/cf7-wave2-form.txt`
   - `inc/analytics-config.json`
   - `template-parts/blocks/block-*.php` (12 קבצים)
   - `page-templates/tpl-*.php` (13 קבצים חדשים — home, service, book-detail, books, shop-item, shop-archive, blog-archive, blog-single, faq, content, contact, en-landing, stage-b-test)
   - `functions.php` (overwrite — מכיל enqueues חדשים)

4. **DELETE מ-staging:** `assets/css/books-wave1.css`.

5. **אימות פוסט-deploy:**
   ```bash
   curl -sI http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css | head -1
   # expected: HTTP/1.1 200 OK
   curl -sI http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/assets/css/books-wave1.css | head -1
   # expected: HTTP/1.1 404 Not Found
   ```

**AC Task A:**
- [ ] כל 30+ הקבצים זמינים ב-FTPS path הנכון.
- [ ] `books-wave1.css` הוסר.
- [ ] curl ל-3 קבצי CSS Wave2 → 200 OK.

### Task B — WP Smoke Page (5 דק', BLOCKER)

**מטרה:** עמוד WP חי בסטייג'ינג שמשתמש ב-template `tpl-stage-b-test` כדי לרנדר את 12 הבלוקים.

**מומלץ: WP-CLI** (מהיר, לא דורש browser):

```bash
# SSH/Tailscale ל-waldhomeserver אם דרוש; או דרך uPress shell
ssh upress_user@upress_host  # אם זמין
# או דרך אינטגרציה אחרת לפי team_60 FTPS playbook

wp post create \
  --post_type=page \
  --post_status=publish \
  --post_title="Wave2 Stage B Smoke Test" \
  --post_name="wave2-test" \
  --meta_input='{"_wp_page_template":"page-templates/tpl-stage-b-test.php"}' \
  --path=/path/to/wp/install
```

אם אין SSH ל-uPress, **fallback:** WP admin browser:
1. `https://eyalamit-co-il-2026.s887.upress.link/wp-admin/`
2. Pages → Add New
3. Title: "Wave2 Stage B Smoke Test"
4. Slug: `wave2-test`
5. Page Attributes → Template: **Stage B Test (tpl-stage-b-test)**
6. Publish

**אימות:**
```bash
curl -sI http://eyalamit-co-il-2026.s887.upress.link/wave2-test/ | head -1
# expected: HTTP/1.1 200 OK
curl -s http://eyalamit-co-il-2026.s887.upress.link/wave2-test/ | grep -c "data-block="
# expected: 12 or higher (depending on how blocks are marked)
```

**AC Task B:**
- [ ] `/wave2-test/` → 200 OK.
- [ ] HTML response מכיל את כל 12 הבלוקים (grep `block-` או similar).
- [ ] `<link rel="stylesheet" href=".*ea-tokens.css">` מופיע ב-HTML.

### Task C — TLS Cert Renew (15-60 דק', MAJOR, parallel)

**מטרה:** תעודת HTTPS תקפה על `eyalamit-co-il-2026.s887.upress.link`.

**אופציות:**

1. **uPress panel** (preferred): login לפאנל uPress, navigate ל-SSL section, "Renew" או "Reissue".
2. **Let's Encrypt automation** (אם uPress תומך): `certbot renew` או דומה.
3. **Cloudflare** (אם דומיין מנותב דרכם): Flexible SSL automatic.

**אימות:**
```bash
curl -sI https://eyalamit-co-il-2026.s887.upress.link/ 2>&1 | head -3
# expected: HTTP/2 200 (no TLS warning)
openssl s_client -connect eyalamit-co-il-2026.s887.upress.link:443 -servername eyalamit-co-il-2026.s887.upress.link < /dev/null 2>/dev/null | openssl x509 -noout -dates
# expected: notAfter ≥ 30 days from now
```

**AC Task C:**
- [ ] `curl -sI https://...` → 200 ללא warning.
- [ ] תעודה תקפה ≥ 30 יום.

**הערה:** אם R4 לא מתבצע בזמן — team_50 רץ Phase 2 על HTTP, ו-TLS נרשם כ-finding לסגירה ב-cutover (M7).

---

## 2. תיאום — סדר ביצוע

```
T0:   Task A (deploy) + Task C (TLS, parallel)
T+30: Task B (smoke page) — אחרי Task A
T+45: SIGNAL ל-team_50 (mail or commit notice) — Ready for re-QA
```

⚠ **חשוב:** Task A חייבת לרוץ **אחרי** ש-team_10 משלים את R2 (A/B drift patch). team_100 מתאם — תקבלו ירוק להמשך כשcommit ה-patch נדחף. הצפי: ~15 דק' מעכשיו.

**אל תתחילו Task A** עד שיש commit message בלוג הgit שמתחיל ב-"WP-W2-01-STAGE-B-IMPL: A/B contract drift fix" או דומה.

---

## 3. תוצרי team_99 — checklist

- [ ] `_COMMUNICATION/team_99/STAGE-B-DEPLOY-REPORT-2026-05-27.md` — דוח Task A
- [ ] `_COMMUNICATION/team_99/SMOKE-PAGE-CREATED-2026-05-27.md` — דוח Task B
- [ ] `_COMMUNICATION/team_99/TLS-RENEW-2026-05-27.md` — דוח Task C (or N/A if deferred)
- [ ] **No code commits** — team_99 פועל ב-isolated branch / direct ops; קבצי תיעוד בלבד ב-`_COMMUNICATION/team_99/`.
- [ ] git push (תיעוד בלבד).

---

## 4. אישורי Iron Rule

- **Iron Rule #5** — final validation by team_190 cross-engine. team_99 ops עצמן לא דורשות cross-engine, אבל ה-deploy עצמו חייב להיות מאומת על-ידי team_50 לפני sign-off (R5 ב-remediation plan).
- **Iron Rule #6** — Inter-team communication דרך canonical artifact ב-`_COMMUNICATION/team_99/`.
- **OUT_OF_GATE_ISOLATED** — team_99 לא בתהליך הgate הקנוני; ה-deploy actions לא דורשות gate verdict (היעוד שלהן הוא Ops).

---

## 5. Activation prompt לסשן team_99 (SSH ל-waldhomeserver)

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_99 only — Server-side Ops (deploy + smoke + TLS)

Identity: team_99 (Home Server Team)
Engine: claude-code (CLI on waldhomeserver via SSH/Tailscale)
Operating Mode: SERVER_OPS

Mandate: _COMMUNICATION/team_99/MANDATE-TEAM99-STAGE-B-DEPLOY-2026-05-27.md

Three tasks (parallel A+C; B after A):
A. FTPS deploy site/wp-content/themes/ea-eyalamit/ → uPress staging
   Wait until commit "A/B drift fix" lands; then proceed.
B. WP-CLI create page /wave2-test/ with template tpl-stage-b-test.
C. TLS cert renew (uPress panel or LE).

Deliverables (no code commits; doc files only):
- _COMMUNICATION/team_99/STAGE-B-DEPLOY-REPORT-2026-05-27.md
- _COMMUNICATION/team_99/SMOKE-PAGE-CREATED-2026-05-27.md
- _COMMUNICATION/team_99/TLS-RENEW-2026-05-27.md

Authority: OUT_OF_GATE_ISOLATED. No gate verdict needed for these ops; team_50
re-QA (R5) is the gate that validates the deploy was successful.

FIRST READ: _COMMUNICATION/team_99/MANDATE-TEAM99-STAGE-B-DEPLOY-2026-05-27.md
```

---

## 6. שינוי גרסה

| תאריך | פעולה |
|-------|--------|
| 2026-05-27 | מנדט נוצר ע"י team_100 בעקבות team_50 Round 1 FAIL |
