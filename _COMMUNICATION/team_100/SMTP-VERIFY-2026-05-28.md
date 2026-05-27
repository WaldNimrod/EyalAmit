---
id: SMTP-VERIFY-2026-05-28
title: SMTP / WP Mail SMTP verification — in-session probe (partial)
status: PARTIAL — plugin verified present; delivery confirmation deferred to nimrod/Eyal
date: 2026-05-28
from_team: team_100 (Chief Architect)
to_team: team_00 (Principal)
idea_ref: IDEA-004 in _aos/ideas.json
trigger: nimrod in-session 2026-05-28 — `עודכנו פרטי smtp באתר ביופרס - אנא בדיקתכם`
---

# SMTP Verification — Partial In-Session Probe

## §0 Box

| Field | Value |
|-------|-------|
| WP Mail SMTP plugin present on staging | ✅ confirmed (HTTP probe) |
| WP Mail SMTP plugin config (credentials set) | ⚠ unverified — requires WP-Admin or DB access |
| Test email programmatic delivery | ⏸ deferred — Fluent Forms nonce loads via JS (would need headed browser); CF7 endpoint requires auth |
| End-to-end delivery to info@eyalamit.co.il | ⏸ tomorrow — Eyal confirms via inbox/spam check |

## §1 In-session probes

| Probe | Method | Result |
|-------|--------|--------|
| WP Mail SMTP plugin files exist | `curl /wp-content/plugins/wp-mail-smtp/readme.txt` | HTTP 200 ✅ |
| WP Mail SMTP main PHP file (protected from direct read) | `curl /wp-content/plugins/wp-mail-smtp/wp_mail_smtp.php` | HTTP 403 (expected — WP protection) ✅ |
| CF7 REST endpoint (Wave2 form path) | `curl /wp-json/contact-form-7/v1/contact-forms` | HTTP 403 (auth-protected, expected) |
| Fluent Forms on legacy `/contact/` page | curl + grep | Form present (`form_id=1`, Fluent Forms 6.2.4) ✅ |
| Fluent Forms nonce extraction | regex against HTML | Empty — nonce loads via JS post-render |
| `/wave2-test/` (Wave2 smoke page) | grep for any form | No form (this is the design-system smoke page, not a contact-template page) |
| analytics-config.json (GA4 + Clarity) | curl | Both still `__PENDING_EYAL__` — unrelated to SMTP |

## §2 What I can NOT confirm from here

- Whether WP Mail SMTP plugin **is activated** (vs. just installed) — requires WP-Admin or wp-cli.
- Whether the SMTP **credentials** (host, user, app password, from address) are valid and saved — same gating.
- Whether outbound mail **actually leaves the server** and reaches the inbox — requires either:
  - A WP Mail SMTP "Send a Test Email" click in WP-Admin (canonical), or
  - A real form submission that triggers `wp_mail()`, or
  - SSH/wp-cli access (`wp mail test`).

## §3 Recommended verification path

### Path A (preferred, today) — nimrod 60-second test
1. nimrod logs into `https://eyalamit-co-il-2026.s887.upress.link/wp-admin/`.
2. Navigates to **WP Mail SMTP → Email Test**.
3. Enters `info@eyalamit.co.il` as the test recipient.
4. Clicks **Send Email**.
5. Confirms in WP-Admin the result banner ("HTML test email was sent successfully" or specific error).
6. Tomorrow Eyal checks the inbox; if the email arrived → IDEA-004 closed-fulfilled; if didn't → re-open with the WP-Admin error to debug.

### Path B (programmatic, low effort) — Fluent Forms via headed browser
- Dispatch a Sonnet sub-agent with Puppeteer:
  - Load `/contact/`, wait for JS to populate the nonce, fill 3 fields (name, email, message with "team_100 SMTP smoke 2026-05-28"), click submit.
  - Confirm AJAX response is success.
  - Tomorrow Eyal checks.
- Cost: ~3 min of agent time. Lower confidence than Path A (different code path from Path A's WP Mail SMTP test endpoint).

### Path C (deferred) — Phase 2 QA cycle
- When GA4 + Clarity arrive from Eyal, spawn the Phase 2 QA WP (per IDEA-003). VC-15 will programmatically submit the **Wave2 CF7 form** (after a Wave2 contact page is published using tpl-contact.php) and verify delivery.

## §4 Recommendation

Go with **Path A** today (nimrod, 60 seconds). It's the canonical WP Mail SMTP self-test. If Path A succeeds → IDEA-004 closed today, and the broader Phase 2 still waits on GA4+Clarity from Eyal. Path B is only if Path A is somehow blocked.

## §5 Linked artifacts

- IDEA-004 in `_aos/ideas.json` (this verification's tracking entry)
- IDEA-003 in `_aos/ideas.json` (broader Phase 2 cycle — depends on this resolving)
- Stage B mandate v1.0.0 §1 Phase 2 (canonical VC-15 spec)
