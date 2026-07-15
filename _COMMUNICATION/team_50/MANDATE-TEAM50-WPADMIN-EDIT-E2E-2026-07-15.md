---
id: MANDATE-TEAM50-WPADMIN-EDIT-E2E-2026-07-15
from_team: team_100
to_team: team_50
date: 2026-07-15
type: e2e-editability-test
wp: WP-S4-05 (AC-EDIT / AC-FALLBACK live)
builder_engine: sonnet (anthropic)
tester_engine: composer-2.5 (cursor, team_50) — cross-engine ≠ builder
verdict_output: _COMMUNICATION/team_50/VERDICT-WPADMIN-EDIT-E2E-2026-07-15.md
---

# MANDATE — team_50 E2E: live wp-admin editability cycle (WP-S4-05 AC-EDIT/AC-FALLBACK)

You are team_50 (E2E QA, composer-2.5). Prove that content is **actually editable in wp-admin** on staging — the "Eyal can edit the site" promise — end to end. This is a real browser/HTTP test against a live WordPress; you MUST authenticate (the builder session cannot; you can).

## Environment
- Staging front: `http://eyalamit-co-il-2026.s887.upress.link` (TLS invalid by design — use http / ignore cert).
- Credentials: read from `local/.env.upress` (git-ignored). Keys: `UPRESS_WP_ADMIN` (wp-admin URL), `UPRESS_WP_ADMIN_USER`, `UPRESS_WP_ADMIN_PASS` (and `UPRESS_WP_APP_USER`/`UPRESS_WP_APP_PASS` app-password if you prefer REST). **Do not print secret values into the verdict** — reference them as env keys only.
- Tools available: `node` (v24) + cached `chrome-headless-shell` under `~/.cache/puppeteer` (same one `qa_probe.mjs` uses) for a Puppeteer/CDP script; `curl`; the theme code (`site/wp-content/themes/ea-eyalamit/inc/chapters/acf-fields-inner.php` gives the field name/key contract per page type).

## What to prove (write + run whatever script does it reliably — Puppeteer UI flow, or scripted login-cookie + ACF form POST)
1. **ACF-free is ACTIVE on staging** — log into wp-admin, open the edit screen of an in-scope page (e.g. `/treatment/`, `/repair/`, or `/didgeridoos/`), and confirm the **ACF field group renders** (the `group_chapters_{type}` fields appear). If ACF is NOT active / no fields appear → that is the single most important finding: report it (the editability promise can't be met until ACF-free is activated on staging).
2. **AC-EDIT** — set one ACF field (e.g. a section title or a prose body) to a **distinctive test value** (e.g. `__E2E_EDIT_2026-07-15__`), save, then load the live front-end of that page and confirm the test value **renders** (the override beats the seeded default).
3. **AC-FALLBACK** — clear that field, save, reload the front-end, confirm it **falls back to the seeded default** (no blank / no white-screen).
4. **Cleanup (mandatory)** — leave the field EMPTY (its original state) so no `__E2E__` test residue remains on staging.

## Required output
Write **`_COMMUNICATION/team_50/VERDICT-WPADMIN-EDIT-E2E-2026-07-15.md`**: frontmatter (`tester_engine: composer-2.5`, `wp: WP-S4-05`); a top-level flag (`PASS` = full green / `FAIL` / `BLOCKED`); the page + field you tested; ACF-active result; AC-EDIT result (test value seen on front-end? yes/no + how verified); AC-FALLBACK result; cleanup confirmation; and any blocker (login failed, ACF inactive, ACF UI un-scriptable) with what a human would need to do. Save any script + screenshots/HTML under `_COMMUNICATION/team_50/evidence/wpadmin-edit-e2e-2026-07-15/`.
