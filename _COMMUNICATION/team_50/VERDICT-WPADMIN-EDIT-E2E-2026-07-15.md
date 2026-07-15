---
tester_engine: composer-2.5
wp: WP-S4-05
mandate: MANDATE-TEAM50-WPADMIN-EDIT-E2E-2026-07-15
date: 2026-07-15
from_team: team_50
to_team: team_100
staging_base: http://eyalamit-co-il-2026.s887.upress.link
verdict: BLOCKED
---

# VERDICT — WP-S4-05 live wp-admin editability E2E (team_50)

## Top-level flag: **BLOCKED**

Full wp-admin edit cycle (AC-EDIT / AC-FALLBACK / cleanup) **could not be executed** because `UPRESS_WP_ADMIN_PASS` in `local/.env.upress` does **not** authenticate against staging `wp-login.php`. Application Password (`UPRESS_WP_APP_USER` / `UPRESS_WP_APP_PASS`) **does** work for REST, but cannot drive the wp-admin ACF editor UI.

---

## Test target

| Item | Value |
|------|--------|
| **Page** | `/treatment/` (post ID **54**, template `page-templates/template-treatment.php`) |
| **Planned ACF field** | `s1_title` (section 1 intro title; key `f_treatment_s1_title`; group `group_chapters_treatment`) |
| **Planned test value** | `__E2E_EDIT_2026-07-15__` |
| **Seeded default (fallback)** | `משהו בנשימה שלך מבקש תשומת לב` |

Field contract source: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/acf-fields-inner.php` · defaults: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/treatment-defaults.php`.

---

## Results matrix

| Check | Result | Evidence / method |
|-------|--------|-----------------|
| **ACF-free active on staging** | **YES** (plugin layer) | `GET /wp/v2/plugins` with `UPRESS_WP_APP_USER`/`UPRESS_WP_APP_PASS` → **Advanced Custom Fields** (`advanced-custom-fields/acf`) status **active**. |
| **ACF field group renders in wp-admin** | **NOT TESTED** | Blocked at login — edit screen never reached. |
| **AC-EDIT** (set field → save → front shows override) | **NOT RUN** | Blocked at login. |
| **AC-FALLBACK** (clear field → save → front shows default) | **NOT RUN** (full cycle) | Baseline only: `GET /treatment/` → HTTP **200**, default snippet present, no white-screen (`body_len` ≈ 84 280). Does **not** satisfy mandate (no prior override to clear). |
| **Cleanup** | **N/A** | No `__E2E__` residue written (edit step never ran). |

---

## Blocker detail

### wp-login failure

- **Method:** `POST /wp-login.php` with env keys `UPRESS_WP_ADMIN_USER`, `UPRESS_WP_ADMIN_PASS` (also reproduced via headless CDP form submit).
- **User login:** `eyaladmin` (from env; not a secret).
- **Outcome:** Remains on `wp-login.php`; WordPress error (Hebrew): password incorrect for user `eyaladmin`.
- **REST contrast:** `python3 scripts/verify_upress_rest.py` → **OK** with `UPRESS_WP_APP_USER`/`UPRESS_WP_APP_PASS` (user id=1). App password ≠ wp-admin account password; app password is **not** accepted by `wp-login.php`.

### What a human must do before re-run

1. **team_20 / credential holder:** Reset or retrieve the current **wp-admin account password** for `eyaladmin` from the uPress panel (not the Application Password).
2. Update **`local/.env.upress`** → `UPRESS_WP_ADMIN_PASS` to match (do not commit; reference key only in artifacts).
3. Optional sanity: `POST /wp-login.php` should redirect into `/wp-admin/` (not back to login with `#login_error`).
4. Re-issue or re-run this mandate — team_50 will execute the Puppeteer/UI flow: open post **54** → confirm `group_chapters_treatment` fields → AC-EDIT → AC-FALLBACK → cleanup.

---

## How verified (what ran)

| Tool | Path |
|------|------|
| Python runner | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/evidence/wpadmin-edit-e2e-2026-07-15/wpadmin_edit_e2e_runner.py` |
| CDP login capture | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/evidence/wpadmin-edit-e2e-2026-07-15/wpadmin_login_cdp.mjs` |
| Machine-readable summary | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/evidence/wpadmin-edit-e2e-2026-07-15/results.json` |
| Login HTML snippet | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/evidence/wpadmin-edit-e2e-2026-07-15/login-response-snippet.html` |
| CDP login JSON | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/evidence/wpadmin-edit-e2e-2026-07-15/cdp-login-result.json` |

Credentials referenced **by env key only** — no secret values in this verdict.

---

## team_50 assessment

- **ACF on staging:** confirmed active at plugin level; **cannot** confirm editor field-group UI without wp-admin session.
- **Editability promise (Eyal can edit in wp-admin):** **unproven** in this run — blocked on stale/mismatched `UPRESS_WP_ADMIN_PASS`, not on front-end render regression.
- **Next owner:** **team_20** (credential sync) → **team_50** (re-test) → **team_100** (gate WP-S4-05 AC-EDIT closure).

---

*team_50 · composer-2.5 · cross-engine ≠ builder (sonnet) · 2026-07-15*
