# LOD400 Spec — WP-W2-09
# Media Filter + Full 301 Application + Cutover Preparation

**WP ID:** WP-W2-09 | **Track:** A | **Milestone:** S002 | **Profile:** L0
**Owner/Builder:** team_20 (DevOps) | **L-GATE_BUILD:** team_50 (non-Claude) | **L-GATE_VALIDATE:** team_190 (Codex)
**Depends on:** WP-W2-01..W2-08 (ALL) + external (Eyal returns 301 JSON) | **Authored:** 2026-05-28 (team_100) | **lod_status:** LOD400 | **blocked:** true (until W2-01..08 complete)

## Objective
Final pre-cutover WP: filter media to in-use only, apply the full approved 301 map, run the cutover checklist. Measurable: all in-use media available (no 404), full 301 map active, end-to-end check 0 FAIL.

## Scope — IN (exact artifacts per team_190 L-GATE_SPEC)
- **Media inventory (authoritative, B01):** `_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-2026-05-26.json` is THE source (fields: `total_fetched`, `in_use_count`, `unattached_count`, `items`). Its `in_use_count` was **7** at 2026-05-26 — STALE: it predates W2-02 pages + W2-06 blog. W2-09 MUST **regenerate** this inventory after W2-01..08 are live (union with the 158 blog-localized media already in `wp-content/uploads/` from W2-06), then keep only in-use. (No `ACCURATE-SITE-MAPPING` artifact exists — that reference is removed.)
- **Migrate** any still-missing in-use media to new-site `wp-content/uploads/` (year/month). Blog media already localized in W2-06 — do not duplicate.
- **Apply full 301 map (B03):** source = `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` (`decision_id: D-EYAL-301-MIGRATION-2026-05-26`, `total_items: 135`, `decisions[]` len 135). Convert to `.htaccess` / Redirection plugin. NOTE: W2-06 already deployed the `/Blog/`→root catch-all + 26 page redirects; W2-09 consolidates to the full **135-rule** map. QR keep policy: the 49 `/qr/qrN/` URLs are NOT redirected (kept live).
- **Cutover checklist** — DNS, HTTPS/TLS (expired staging cert = known M7 carry-forward, IDEA-001), noindex removal, sitemap.xml, GA4 verify, Green Invoice integration test.

## Deliverable script (B02)
`scripts/final_pre_cutover_check.sh` does NOT yet exist — **W2-09 authors it** (team_20). It MUST assert: (a) every in-use media URL returns 200; (b) all 135 301 rules resolve to a live target; (c) all 49 QR URLs 200; (d) `validate_aos.sh` 0 FAIL; (e) Lighthouse homepage ≥ 90. Exit non-zero on any failure.

## Scope — OUT
Cutover execution itself (that's M7). Server-level HTTPS migration (coordinate with uPress).

## Acceptance Criteria
- AC-01: every in-use media item (regenerated inventory ∪ W2-06 blog media) returns 200 (no 404).
- AC-02: all **135** rules from `redirects-301-eyal-final-2026-05-27.json` active on staging; the 49 QR URLs remain live (not redirected).
- AC-03: deterministic sample = the **first 20 entries of `decisions[]`** (file order) — each legacy URL → its decided new URL (301 + correct Location).
- AC-04: 49 QR URLs unchanged + active (automated against `QR-URL-INVENTORY.csv`).
- AC-05: Lighthouse homepage ≥ 90 (perf/access/SEO/best-practices) on **HTTP staging** `http://eyalamit-co-il-2026.s887.upress.link` (expired-TLS is a known M7 carry-forward, IDEA-001 — do not block on HTTPS here).
- AC-06: `scripts/final_pre_cutover_check.sh` (authored in this WP) exits 0.

## Dependencies / blockers
Blocked until all Wave2 content WPs (W2-01..08) close. The approved 301 JSON is **already present** (`hub/data/decisions/redirects-301-eyal-final-2026-05-27.json`, 135 decisions) — no further Eyal input pending for redirects. TLS cert (IDEA-001) is an M7 concern, NOT a W2-09 blocker (Lighthouse runs on HTTP staging per AC-05).

## Gate sequence
L-GATE_ELIGIBILITY (after W2-08) → L-GATE_SPEC (this doc) → L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190).
