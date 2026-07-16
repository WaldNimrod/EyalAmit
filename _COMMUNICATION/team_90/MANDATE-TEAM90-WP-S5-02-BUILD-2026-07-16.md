---
id: MANDATE-TEAM90-WP-S5-02-BUILD-2026-07-16
from_team: team_00
authored_by: team_110 (under team_00 direction)
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
wp: WP-S5-02
milestone: S005
gate: L-GATE_VALIDATE
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-02-LOD400-2026-07-16.md
target_execution: _COMMUNICATION/team_110/VERDICT-WP-S5-02-BUILD-2026-07-16.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-02/
staging_base: https://eyalamit-co-il-2026.s887.upress.link
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S5-02-BUILD-2026-07-16.md
---

# MANDATE — team_90 cross-engine validation: WP-S5-02 (route-completeness schema/meta build)

You are the **cross-engine validator** (`composer-2.5`, non-Claude). WP-S5-02 is the **one real code gap** of the
S005 §1-3 package: dedicated schema + meta-description for the route classes that had none (48 QR children + `/qr/`
hub, `/press/`, `/shows-heritage/`). The builder (team_110, `claude-opus-4-8`) self-verified it PASS on staging.
Iron Rule #1 requires an independent non-Claude engine to **reproduce the build's ACs** before it can close the
WP-S5-05 cutover gate. **Independently reproduce each AC from the modified code + live staging + evidence — do not
merely re-read the self-verdict.**

## Sources of truth
- **Spec:** `_COMMUNICATION/team_100/S005/WP-S5-02-LOD400-2026-07-16.md` (Option A: index+schema for all gapped routes;
  §2.2 QR branch, §2.3 press/shows-heritage, §2.4 meta `$map`, §2.6 noindex-as-documented-fallback, §3.1 reseed, §4 Offer rule).
- **Self-verdict:** `_COMMUNICATION/team_110/VERDICT-WP-S5-02-BUILD-2026-07-16.md`.
- **Evidence:** `_COMMUNICATION/team_110/evidence/s5-02/` (24 files: `route-schema/*.jsonld` + `*.html`, `qr-reseed/`,
  `sitemap/`, `offer-rule/`, `seo-probe/`, `META-AFTER.txt`, `STRUCTURAL-VALIDATION.txt`, `DEPLOY-MANIFEST.txt`).
- **Modified/new code** (deployed to staging):
  - `site/wp-content/mu-plugins/ea-w2-seo-schema.php` — **QR branch L235-291** (Article L248-260; VideoObject per
    *unique* embedded YouTube id, loop L262-291, `youtube-nocookie` embedUrl L283); **press/shows-heritage
    CollectionPage branch L294-322** (`isPartOf`→Yoast's **real** WebSite `@id` resolved by scanning `$graph` L305-322);
    Product/Offer `is_numeric()` gate **L135**; Mokesh VideoObject L221-231 (the structure the QR branch mirrors).
  - `site/wp-content/themes/ea-eyalamit/inc/seo-head-fallbacks.php` — `$map` entries `press`/`shows-heritage`/`qr`
    **L51-53**; **early QR meta branch L67-84 placed BEFORE the Chapters `is_view` block (L86)** — hub `/qr/` returns
    `$map['qr']` (L80-81), child `/qr/qrN/` returns trimmed `post_content` (L77-78).
  - `site/wp-content/mu-plugins/ea-w2-07b-qr-reseed-once.php` (**NEW**, 33 lines) — self-guarded (`ea_w2_07b_qr_reseed_done`)
    one-time drop-in clearing `ea_w2_07_qr_seeded_v3` at init@27 so the W2-07 seeder re-runs at init@28.
  - `scripts/qa/seo_probe.config.json` — +3 routes (local QA only, not deployed).

## Acceptance criterion (the bar the builder claims to meet)
*Every gapped route class now returns a page-specific schema node + a non-empty, route-appropriate meta-description
on live staging; QR embeds are privacy+CWV compliant (nocookie + lazy); the Offer-price rule stays closed; and no
previously-covered route regressed.*

## Checks — reproduce each, cite concrete evidence (URL + code location + observed JSON/HTML)
1. **AC-2.1 — page-specific node + non-empty meta on every route class.** On staging (`curl -k`), fetch and parse
   JSON-LD + `<meta name="description">` for: `/qr/qr1/` (Article, no video), `/qr/qr2/` (Article + 1 VideoObject),
   `/qr/qr10/` (Article + 3 *unique* VideoObjects), `/qr/qr48/` (Article only, 0 embeds), `/qr/` hub (Article +
   **dedicated** `$map['qr']` copy, not the generic phero.sub), `/press/` (CollectionPage), `/shows-heritage/`
   (CollectionPage). Each must have a page-specific node **and** a non-empty meta. Compare against `route-schema/`.
2. **AC-2.2 — `/shows/`→301→`/shows-heritage/`** live (slug correction). Confirm 301 (not 200, not 404).
3. **AC-2.3 — QR video conditionality.** QR-with-embed → VideoObject(s) each with a `youtube-nocookie.com/embed/`
   `embedUrl`; QR-without-embed → **Article only** (no empty/placeholder VideoObject). Multiple embeds → one node per
   **unique** id (qr10 = 3 unique). Confirm the regex + dedup at L262-291.
4. **§3.1 — QR reseed (CWV).** On staging, the QR iframes now have `src="…youtube-nocookie.com/embed/…"` **and**
   `loading="lazy"` (before reseed they were plain `youtube.com/embed/…`). Check `qr-reseed/*_AFTER.html` and a live
   sample (qr2/qr10/qr30); qr48 has 0 iframes (text-only). Confirm the drop-in is self-guarded (single fire).
5. **§4 — Offer/price rule holds.** 5 product pages (repair/bags/stand-floor/stands-storage/didgeridoos) → **0 Offer
   and 0 Product** nodes, "מחיר לפי התאמה" present; the `is_numeric($price)` gate at **L135** correctly omits Offer
   when no numeric price. (This is a verify — no fake/zero-price Offer should ever emit.)
6. **early-QR-meta ordering (spec-vs-live reconciliation, team_00-approved).** Confirm the QR meta branch at
   `seo-head-fallbacks.php:67-84` runs **before** the Chapters `is_view` block (L86), so the `/qr/` hub returns the
   dedicated copy — not the generic `qr-hub-defaults.php` `phero.sub`. `$map['qr']` alone (post-`is_view`) would be
   dead code. See `route-schema/META-AFTER.txt` (hub meta AFTER = dedicated copy).
7. **§5 — harness.** `scripts/qa/seo_probe.config.json` is valid JSON and carries the +3 routes (press,
   shows-heritage, qr-qr2). `python3 -c "import json,sys; json.load(open('scripts/qa/seo_probe.config.json'))"`.
8. **`php -l`** clean on `ea-w2-seo-schema.php` and `seo-head-fallbacks.php` (and the new reseed drop-in).
9. **No regression** on previously-covered routes: `/repair/`, `/bags/`, `/books/vekatavta/`, `/eyal-amit/mokesh-dahiman/`
   still carry their prior nodes + meta (QR/press/shows changes must not have perturbed them).

## Guardrails — DO NOT flag these as defects (environment / ratified; documented in the self-verdict + spec)
- **VideoObject `uploadDate` omitted** — **ratified in spec §2.2**. The node is structurally valid but intentionally
  not eligible for the video-*date* rich-result (obtaining 46 real uploadDates = a future content task, not a code
  gap). Do **not** report it as missing.
- **`isPartOf` → Yoast's real WebSite `@id`** (`…/#website`, resolved by scanning `$graph`) instead of the spec's
  literal `#/schema/website` — this is a correct **builder refinement** (the literal would dangle). Not a deviation defect.
- **Expired TLS + site-wide noindex** on staging — dev-host artifacts (`ea-staging-noindex.php` keys on `upress.link`);
  `curl -k` is the correct bypass; noindex is absent on prod. The Rich-Results/schema.org *external-tool* run is
  impeded by the staging cert+noindex — structural validation against Google's required-property set is sufficient here;
  the authoritative external run is a prod/cutover step.
- **§3.2 facade + transcripts** — a **deferred** decision-gate (native lazy-load already meets the CWV bar). Out of
  scope for this build validation; do not FAIL on its absence.
- **`/qr/` prod 302 (QR direct-200)** — an `OPEN-until-cutover` WP-S5-01 item, not part of this build.
- **Transient curl-`000`** on the slow shared staging host — transport timeout, not a redirect; re-probe low-concurrency.
- **Pre-existing `validate_aos.sh` Check-32** roadmap drift — team_00/team_100 scope, unrelated.

## Required output
Write **`_COMMUNICATION/team_90/VERDICT-WP-S5-02-BUILD-2026-07-16.md`**: frontmatter (`validator_engine: composer-2.5`,
`wp: WP-S5-02`, `iron_rule_1: satisfied`, `builder_engine: claude-opus-4-8`); a top-level flag (`PASS` /
`PASS_WITH_FINDINGS` / `FAIL`); a per-check table (1–9) with PASS/FAIL + the concrete evidence you reproduced (URL +
code location + observed JSON/HTML); findings (if any) at severity blocker/major/minor, each with a concrete citation
showing the mismatch against code/spec/evidence. A missing page-specific node or empty meta on any gapped route, an
emitted Offer with no numeric price, or a non-nocookie QR embed = FAIL with a `route_recommendation` back to team_110.
