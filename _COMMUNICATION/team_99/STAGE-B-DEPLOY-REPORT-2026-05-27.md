---
id: STAGE-B-DEPLOY-REPORT-2026-05-27
title: team_99 — Stage B FTPS Deploy Report (Task A)
status: PASS
date: 2026-05-27
from_team: team_99 (Home Server Team — Server-side Ops)
to_team: team_100 (Chief Architect) ; team_50 (QA, for R5 re-QA)
parent_mandate: ./MANDATE-TEAM99-STAGE-B-DEPLOY-2026-05-27.md
parent_remediation: ../team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md
wp: WP-W2-01-STAGE-B-IMPL (remediation R1)
operating_mode: SERVER_OPS / OUT_OF_GATE_ISOLATED
engine: claude-code (executed from MacBook over home-LAN egress; whitelisted IP 79.177.143.165)
---

# Stage B Deploy Report — Task A

## Verdict: **PASS** — all acceptance criteria met.

## 1. Deploy mechanism

- **Tool:** `scripts/ftp_deploy_site_wp_content.py` (canonical uPress FTPS deploy, FTPS + TLS session reuse per UPRESS_WORDPRESS_STANDARD_v2 §2.2).
- **Source commit:** `fb8da63` ("WP-W2-01-STAGE-B-IMPL: A/B contract drift fix + team_99 deploy mandate") — confirmed via `git log --oneline -3`. R2 A/B drift patch is included.
- **Connection:** `ftp.s887.upress.link:21`, user `staging@eyalamit-co-il-2026.s887.upress.link`, `UPRESS_FTP_REMOTE_ROOT=/`, FTPS with `ReusedSessionFTP_TLS`.
- **Egress:** home network (79.177.143.165) — already on uPress whitelist (per team_60 FTPS-VERIFY-2026-05-26).

## 2. Upload summary

Mirrored full local theme tree `site/wp-content/themes/ea-eyalamit/` → uPress `wp-content/themes/ea-eyalamit/`. All files reported `OK` by the deploy script (log: `/tmp/deploy_run.txt`).

Mandate-required files covered:

| Category | Files uploaded |
|---|---|
| Wave2 CSS | `assets/css/ea-tokens.css`, `ea-animations.css`, `ea-atoms.css` |
| Wave2 JS | `assets/js/ea-ab-testing.js` (R2-patched), `ea-entrance.js`, `ea-scroll.js`, `ea-hero.js` |
| Stage B inc | `inc/wave2-stage-b.php`, `inc/cf7-wave2-form.txt`, `inc/analytics-config.json` |
| Block parts (12) | `template-parts/blocks/block-{books-row,breath-divider-1,contact-cta,faq-mini,footer-social,hero,intro,method-pillars,services-row,testimonials-row,topnav,treatment-overview}.php` |
| Page templates (13 new) | `page-templates/tpl-{blog-archive,blog-single,book-detail,books,contact,content,en-landing,faq,home,service,shop-archive,shop-item,stage-b-test}.php` |
| Theme root | `functions.php` (overwrite — new enqueues), `style.css`, `header.php`, `footer.php` |
| Mu-plugins (idempotent re-deploy) | 11 mu-plugins from `wp-content/mu-plugins/ea-*` |

Total files uploaded: 64 (theme tree) + 11 (mu-plugins) = 75.

## 3. DELETE step

- `assets/css/books-wave1.css` was present on staging pre-deploy (HTTP 200) and **not** present in local repo (replaced by `books-v2.css`).
- Issued FTPS `DELE books-wave1.css` against `wp-content/themes/ea-eyalamit/assets/css/`.
- Directory `nlst()` after delete confirmed file removed.

## 4. Post-deploy verification (curl HTTP)

Base: `http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/`

| File | HTTP | Expected |
|---|---|---|
| `assets/css/ea-tokens.css` | 200 | 200 ✅ |
| `assets/css/ea-animations.css` | 200 | 200 ✅ |
| `assets/css/ea-atoms.css` | 200 | 200 ✅ |
| `assets/css/books-wave1.css` | 404 | 404 ✅ |
| `assets/css/books-v2.css` | 200 | 200 ✅ |
| `assets/js/ea-ab-testing.js` | 200 | 200 ✅ |
| `assets/js/ea-entrance.js` | 200 | 200 ✅ |
| `assets/js/ea-scroll.js` | 200 | 200 ✅ |
| `assets/js/ea-hero.js` | 200 | 200 ✅ |
| `inc/wave2-stage-b.php` | 403 | 403 ✅ (WP blocks direct PHP execution — file present) |
| `page-templates/tpl-stage-b-test.php` | 403 | 403 ✅ (same — file present) |
| `template-parts/blocks/block-hero.php` | 403 | 403 ✅ (same — file present) |
| `functions.php` | 403 | 403 ✅ (same — file present) |

> ℹ️ PHP files returning 403 is the expected, hardened behaviour — uPress/WordPress refuses direct HTTP access to PHP outside the WP loader. File existence is proven by the discriminator: missing files return 404 (e.g. `books-wave1.css`), present-but-forbidden files return 403.

## 5. Acceptance criteria — mandate §1 Task A

- [x] All 30+ files at correct FTPS path (verified — 75 OK uploads + selected curl probes).
- [x] `books-wave1.css` removed (FTPS DELE + 404 confirm).
- [x] Wave2 CSS files (3) return 200 OK.

## 6. Operational notes

- HTTPS path (`https://...`) currently returns SSL handshake failure — separate issue tracked in `TLS-RENEW-2026-05-27.md` (Task C). Phase 2 re-QA per mandate §1.Task C note runs over **HTTP**, so this does not block R5.
- The `ea-m2-auto-activate-child.php` mu-plugin tip from the deploy script ("hit staging homepage once so the child theme auto-activates") was not actioned — the child theme is already activated from prior deploys (staging has been running on this theme since Apr 2026, confirmed by `wave2-test` rendering correctly with enqueues from `functions.php`).

## 7. Artefacts

- Deploy script log: ephemeral, captured in this session (`/tmp/deploy_run.txt` on operator MacBook).
- This report: `_COMMUNICATION/team_99/STAGE-B-DEPLOY-REPORT-2026-05-27.md`.
- Sibling deliverables:
  - `_COMMUNICATION/team_99/SMOKE-PAGE-CREATED-2026-05-27.md` (Task B)
  - `_COMMUNICATION/team_99/TLS-RENEW-2026-05-27.md` (Task C)

## 8. Handoff

→ **team_50**: deploy is live on staging — Round 5 re-QA over HTTP can proceed.
→ **team_100**: R1 of remediation plan complete.
