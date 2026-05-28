# LOD400 Spec — WP-W2-09
# Media Filter + Full 301 Application + Cutover Preparation

**WP ID:** WP-W2-09 | **Track:** A | **Milestone:** S002 | **Profile:** L0
**Owner/Builder:** team_20 (DevOps) | **L-GATE_BUILD:** team_50 (non-Claude) | **L-GATE_VALIDATE:** team_190 (Codex)
**Depends on:** WP-W2-01..W2-08 (ALL) + external (Eyal returns 301 JSON) | **Authored:** 2026-05-28 (team_100) | **lod_status:** LOD400 | **blocked:** true (until W2-01..08 complete)

## Objective
Final pre-cutover WP: filter media to in-use only, apply the full approved 301 map, run the cutover checklist. Measurable: all in-use media available (no 404), full 301 map active, end-to-end check 0 FAIL.

## Scope — IN
- **MEDIA-IN-USE-INVENTORY.json** — derive from `ACCURATE-SITE-MAPPING` relationships (`page_attachments`, `post_attachments`); keep only `usage_count>0` (~60-120 of 319). NOTE: W2-06 already localized blog media to `wp-content/uploads/` — consolidate, don't duplicate.
- **Migrate filtered media** to new-site `wp-content/uploads/` (year/month structure).
- **Apply full 301 map** — ingest Eyal's JSON (from redirects-301.html) → `.htaccess` or Redirection plugin. NOTE: W2-06 already deployed a `/Blog/`→root catch-all + 26 page redirects; W2-09 consolidates to the full ~135-rule map (minus 49 QR keep).
- Verify Eyal's 78 auto + 8 manual recommendations all work.
- **Cutover checklist** — DNS, HTTPS (TLS — see IDEA-001), noindex removal, sitemap.xml, GA4 verify, Green Invoice integration test.

## Scope — OUT
Cutover execution itself (that's M7). Server-level HTTPS migration (coordinate with uPress).

## Acceptance Criteria
- AC-01: all in-use media available in new WP (no 404).
- AC-02: ~134 301 rules (minus 49 QR keep) active on staging.
- AC-03: sample 20 legacy URLs → each lands on correct new URL.
- AC-04: 49 QR URLs unchanged + active (automated).
- AC-05: Lighthouse homepage ≥ 90 (perf/access/SEO/best-practices).
- AC-06: `final_pre_cutover_check.sh` 0 FAIL.

## Dependencies / blockers
Blocked until all Wave2 content WPs (W2-01..08) close. External: Eyal returns 301 JSON. TLS cert (IDEA-001) must resolve before M7.

## Gate sequence
L-GATE_ELIGIBILITY (after W2-08) → L-GATE_SPEC (this doc) → L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190).
