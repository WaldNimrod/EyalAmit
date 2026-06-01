---
id: BUGFIX-SWEEP-AND-HTTP-QA-2026-06-01
title: Known-bug sweep + HTTP QA (existing staging environment)
from_team: team_100 (Chief System Architect)
to_team: team_00 (Principal)
date: 2026-06-01
scope: pre-Eyal-completions productive work — fix all fixable-now bugs + implement/run QA over HTTP
branch: chore/bugfix-qa-http (never main)
---

# Bug-fix sweep + HTTP QA

## §0 Context
Work advanceable **without** Eyal's pending completions: fix every known code-fixable bug across all
stages, and stand up + run QA in the **existing HTTP-only staging environment** (per team_00 direction).

## §1 Staging TLS — RESOLVED (no action)
uPress staging is **HTTP-only by design** — `docs/project/EYAL_ENV_VARS_REFERENCE.md:44`: *"סטייג'ינג uPress:
לבדיקות השתמשו ב־http:// על אותו hostname (אין תעודת SSL ציבורית תקינה כמו בפרודקשן)"*. Production gets
auto-renewed SSL at cutover (M7). **No cert to renew.** QA runs over HTTP; the prior blocker (HTTPS-forced
Lighthouse/axe runners) is removed by pointing the runners at `http://`.

## §2 Definitive known-bug triage
A full sweep of all gate verdicts, completion reports, carry-forward logs, the 6 S1 HANDOFFs, roadmap
notes and `ideas.json` produced **31 items**: 10 FIXABLE-NOW (incl. duplicates), 9 NEEDS-EYAL, 6
NEEDS-DECISION, plus already-fixed/carry-forward. The NEEDS-EYAL items are exactly the
`materials-intake` page; NEEDS-DECISION are logged for team_00.

## §3 Bugs FIXED this session (deployed to staging + verified live over HTTP)
| Bug | Fix | File | Verified |
|-----|-----|------|----------|
| **F-W2-06-03 / IDEA-006** — blog archive cards leak raw `[vc_row…]` shortcodes | Extended the cleanup mu-plugin to also filter `get_the_excerpt` (the archive excerpt pipeline doesn't strip unregistered shortcodes) | `site/wp-content/mu-plugins/ea-blog-shortcode-cleanup.php` | `/blog/` raw `[vc_` count **10 → 0** |
| **F-W2-08-01** — stray `ea-blog-archive-view` body class on `/en` (+ every Wave2 page) | Root cause: `ea_wave2_is_active_view()` takes **no arg** → true for all Wave2 templates. Scoped the class to `is_home() \|\| tpl-blog-archive` | `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-06.php` | `/en` class **gone**; `/blog/` **retains** it |
| **F-W2-10-F (M4/M5/M6)** — `/en` footer social + skip-link use physical RTL props that don't flip under `dir=ltr` | Added LTR overrides scoped to `body.ea-en-landing` (footer `row`/`flex-start`; skip-link `left:0`) | `site/wp-content/themes/ea-eyalamit/assets/css/w2-08-en-landing.css` | override CSS served on `/en` |
| **WP-W2-10-D Q1** — blog byline shows login `eyaladmin` not `אייל עמית` | Idempotent `-once` mu-plugin sets the user's `display_name`/`nickname` | `site/wp-content/mu-plugins/ea-w2-10-author-displayname-once.php` (new) | post byline now **"מאת: אייל עמית"** |
| **F-W2-05-01** — primary-nav item linked the LEGACY page `/tools-and-accessories/repair/` (id 65) instead of canonical `/repair/` (id 293) ⟵ *added in round-2 after team_190 flagged the triage-completeness gap* | `-once` mu-plugin repoints any `nav_menu_item` from the legacy page → canonical page (resolved dynamically) | `site/wp-content/mu-plugins/ea-w2-10-nav-repair-canonical-once.php` (new) | menu item now → `/repair/`; legacy link **0 occurrences** sitewide |

**Deliberately NOT changed (flagged, not bugs):**
- **F-W2-02-02 / IDEA-005** — homepage hero H1 uses `<br>` vs source dash. The homepage is the one
  POC-reviewed composition; changing it unilaterally would contradict sign-off → **NEEDS-DECISION** (team_00/Eyal).
- **IDEA-002** (mobile `<p>` text-align) — the only `text-align:left` left is in the EN CSS (correct for LTR); the RTL override is already gone → effectively resolved.
- **IDEA-007** (2 orphaned 404 refs in stored post content) — not user-visible; optional DB cleanup, left as-is.

## §4 QA implemented + run (HTTP, existing environment)
New reusable HTTP QA tooling under `scripts/qa/` (self-contained; `node_modules` gitignored):
- `http-qa-axe.cjs` — axe-core WCAG 2A/2AA across all routes over HTTP (puppeteer-core + local Chrome). This is the reusable **S5 a11y gate**.
- `http-qa-lighthouse.sh` — Lighthouse perf/a11y/BP/SEO over HTTP for representative routes.

**axe results — 14/14 routes PASS (HTTP 200, 0 critical / 0 serious):**
`/ · /treatment · /method · /sound-healing · /lessons · /about · /press · /about/moksha · /contact · /faq · /books · /shop · /blog · /en` → report `scripts/qa/reports/axe-http-*.json`. **AC-U3 met sitewide.**

**Lighthouse (HTTP):**
| Route | Perf | A11y | BP | SEO |
|-------|------|------|----|-----|
| / | 95 | 100 | 81 | 69 |
| /treatment/ | 96 | 100 | 81 | 66 |
| /blog/ | 96 | 97 | 81 | 58 |
| /en/ | 84 | 100 | 81 | 58 |

- A11y 100 on 3/4 (blog 97 — minor, no critical/serious axe issue). Perf ≥95 except **/en 84** — the 708 KB hero JPG (F2 → WebP/srcset at S3). SEO/BP **staging-capped** (noindex + HTTP → 100 at M7 cutover), consistent with W2-09's accepted Lighthouse disposition.

## §5 Also fixed (deploy completeness)
`scripts/ftp_deploy_site_wp_content.py` did not include `ea-blog-shortcode-cleanup.php` in its canonical
mu-plugin list (so prod/staging deploys could miss it). Added it + the new author-display once-plugin.

## §6 Carry-forward (still needs Eyal / decision)
NEEDS-EYAL items are tracked in the live `materials-intake` hub page. NEEDS-DECISION (for team_00):
homepage hero `<br>`, `--3col` comparison modifier, `/shop` legacy cart 404s, interim `/תקנון` & build-workshops
redirect targets, `/method` testimonials scope, blog share/related atoms (team_80 GCR).

**New P3 carry-forwards surfaced during the external gates (round 2):**
- **Duplicate legacy `repair` page** — page id 65 `/tools-and-accessories/repair/` still resolves 200 alongside
  canonical id 293 `/repair/`. The nav no longer links it (fixed above), but it remains crawlable. Recommend a
  301 `/tools-and-accessories/repair/ → /repair/` in the W2-09 redirect layer (regen from the 135-JSON) or trash
  page 65, at M7/S3. (team_50 + team_190 round-1 didn't flag this; surfaced while fixing F-W2-05-01.)
- **Yoast author schema slug** (team_50 P3) — Yoast still emits `/author/eyaladmin/` (the `user_nicename`).
  Display byline is fixed; the slug is cosmetic/SEO-minor and unindexed on staging. Fix at S3: set
  `user_nicename = eyal-amit` + add a `/author/eyaladmin/ → /author/eyal-amit/` 301.

## §7 Process note — triage-completeness miss (round 1 → round 2)
team_190 L-GATE_VALIDATE **FAILed round 1** correctly: F-W2-05-01 (nav repair link) was mis-triaged as
NEEDS-DECISION and omitted from this report's fix scope, while the canonical `/repair/` was already live —
making it a clear FIXABLE-NOW. Remediated in round 2 (nav repointed + report completed). Lesson: a "live
legacy link with a canonical target already shipped" is a bug, not a decision.

*team_100 | bug-fix sweep + HTTP QA complete 2026-06-01. Branch chore/bugfix-qa-http; merge PENDING team_00.*
