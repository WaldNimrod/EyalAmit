---
id: MANDATE-TEAM90-WP-S5-01-VERIFY-2026-07-16
from_team: team_00
authored_by: team_110 (under team_00 direction)
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
wp: WP-S5-01
milestone: S005
gate: L-GATE_VALIDATE
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator
target_execution: _COMMUNICATION/team_110/VERDICT-WP-S5-01-BUILD-2026-07-16.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-01/
staging_base: https://eyalamit-co-il-2026.s887.upress.link
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S5-01-VERIFY-2026-07-16.md
---

# MANDATE — team_90 cross-engine validation: WP-S5-01 (quick-verify residuals)

You are the **cross-engine validator** (`composer-2.5`, non-Claude). WP-S5-01 is a **VERIFY package** — the
builder (team_110, `claude-opus-4-8`) self-verified it PASS (5/5) but Iron Rule #1 requires an independent
non-Claude engine to reproduce the result before it can close the WP-S5-05 cutover gate. **This is validation of
an already-completed execution, not new work.** No site code was built in WP-S5-01 (the one code fix, route
schema/meta, is owned by WP-S5-02 — validated under the separate `MANDATE-TEAM90-WP-S5-02-BUILD` mandate).

## What you are validating
The 5-item verify verdict at **`_COMMUNICATION/team_110/VERDICT-WP-S5-01-BUILD-2026-07-16.md`**, against:
- **Live staging:** `https://eyalamit-co-il-2026.s887.upress.link` (expired TLS + noindex — see Guardrails; use `curl -k`).
- **Saved evidence:** `_COMMUNICATION/team_110/evidence/s5-01/` (103 files; 6 subdirs: `blog-pagination/`, `faq-toc/`,
  `shop-nav/`, `qr-direct-200/`, `route-completeness-precheck/`).
- **Live code** in `site/wp-content/` (the claim locations below — confirm each against the real file).
- **Spec:** `_COMMUNICATION/team_100/S005/WP-S5-01-LOD400-2026-07-16.md`. **Research:** `_COMMUNICATION/team_100/RESEARCH-WP-S5-01-GROUND-TRUTH-2026-07-16.md`.

## Acceptance criterion (the bar the builder claims to meet)
*Each of the 5 residual items is independently confirmed against live staging + code, with the framing
(`VERIFY` / `VERIFY+prod-caveat`) honored — no "already-built" item has silently regressed.*

## Checks — reproduce each, cite concrete evidence (don't settle for "looks fine")

1. **Item 1 — blog pagination (VERIFY, claimed already-fixed).** `/blog/`, `/blog/page/2/`, `/blog/page/3/`,
   `/blog/page/5/` → all **HTTP 200** (no cookies); **distinct post-id sets** per page (verdict claims 0 shared
   post-ids across all 6 page-pairs); `page-numbers current` marker matches the URL page number; page served by the
   LIVE template — `<main id="chapters-main">` present, **zero** `id="main"` (dead `tpl-blog-archive.php`). Confirm
   the fix at **`tpl-chapters-blog-archive.php:14-20`** reads `get_query_var('paged')` first (not `$_GET['paged']`).

2. **Item 2 — FAQ section-TOC (VERIFY, claimed already-built).** `/faq/` → 200; `<nav class="ea-faq-toc">` present;
   chips (`href="#faq-topic-<slug>"`) set == target divs (`id="faq-topic-<slug>"`) set — **0 broken anchors, 0 orphan
   targets**. Verdict claims 13 chips ↔ 13 targets. Confirm the builder at **`block-faq-list.php:58-79`** (TOC built
   only from categories that actually have questions).

3. **Item 3 — shop-in-nav (VERIFY, claimed already-present).** `/` → 200; inside the `<nav ... id="nav">` block, all
   **6 hrefs** present: `/shop/` + `/repair/`, `/didgeridoos/`, `/bags/`, `/stands-storage/`, `/stand-floor/`
   (hard-coded dropdown, **`section-nav.php:39-44`**).

4. **Item 4 — QR direct-200, 49 rows (VERIFY + PROD-ONLY CAVEAT).** Parse the 49 rows from
   `docs/project/team-100-preplanning/QR-URL-INVENTORY.csv` (use a real CSV parser — 2 titles contain quoted
   commas). On staging, **direct** (no `-L`) each → **HTTP 200 with no `Location:` header**. **Do NOT demand prod
   behavior** — the documented prod 302 on `/qr/` is prod-conditional; this item is correctly `OPEN-until-cutover`
   (re-run belongs to `scripts/final_pre_cutover_check.sh` at WP-S5-05). Transient curl-`000` on this slow shared
   host = transport timeout, **not** a redirect — re-probe low-concurrency (see Guardrails). Validate that the
   builder's staging result + the prod caveat are both correctly stated.

5. **Item 5 — route-completeness (VERIFY-ONLY; fix owned by WP-S5-02).**
   - **5.1 precheck:** confirm the canonical gap list — `/press/`, `/shows-heritage/`, `/qr/` hub, `/qr/qr1/`
     (repr. of 48) are the gapped routes (missing dedicated meta + page-specific schema node), while controls
     `/repair/`, `/bags/`, `/books/vekatavta/`, `/eyal-amit/mokesh-dahiman/` are COMPLETE. Cross-check the code:
     `inc/seo-head-fallbacks.php` `$map` (**L38-51**, 12 keys, none of press/shows-heritage/qr) and the gate arrays
     in `mu-plugins/ea-w2-seo-schema.php` (`$services` L99, `$ea_faq_pages` L150, `$ea_book_slugs` L180, Person
     mokesh-only L199 — none of press/qr/shows).
   - **5.2 postcheck (was DEFERRED — now closeable, WP-S5-02 is built + deployed):** confirm the 4 gapped routes
     **now** carry a page-specific schema node + non-empty meta on live staging (i.e. the WP-S5-02 build actually
     closed the gap S5-01 identified). This links the two WPs — flag any gapped route still bare.

## Guardrails — DO NOT flag these as defects (environment / ratified; already documented in the self-verdict)
- **Expired TLS on staging** — invalid by design on the uPress dev host; `curl -k` is the correct dev-only bypass.
- **Site-wide `x-robots-tag: noindex`** on all routes — host-conditional staging plugin `ea-staging-noindex.php`
  (keys on `upress.link`), **not** route-specific editorial noindex; it will not exist on production.
- **Transient curl-`000`** under concurrent probing — a transport timeout on the slow shared staging host, never an
  HTTP redirect (0 `Location:` headers). Re-probe sequentially / low-concurrency.
- **QR item 4 is `OPEN-until-cutover`** — staging PASS is the correct, complete result for this gate; prod re-run is a WP-S5-05 step.
- **Pre-existing `validate_aos.sh` Check-32** (uncommitted `_aos/roadmap.yaml` drift) — team_00/team_100 scope, unrelated to this WP.

## Required output
Write **`_COMMUNICATION/team_90/VERDICT-WP-S5-01-VERIFY-2026-07-16.md`**: frontmatter (`validator_engine:
composer-2.5`, `wp: WP-S5-01`, `iron_rule_1: satisfied`, `builder_engine: claude-opus-4-8`); a top-level flag
(`PASS` / `PASS_WITH_FINDINGS` / `FAIL`); a per-item table (items 1–5, incl. 5.1 + 5.2) with PASS/FAIL + the concrete
evidence you reproduced (URL + code location + observed value); findings (if any) at severity blocker/major/minor,
each with a concrete citation showing the mismatch. If any "already-built" item has regressed, that is a FAIL with a
`route_recommendation` back to team_110.
