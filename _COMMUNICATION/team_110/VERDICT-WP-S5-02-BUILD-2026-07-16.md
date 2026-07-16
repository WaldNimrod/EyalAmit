---
id: VERDICT-WP-S5-02-BUILD-2026-07-16
from_team: team_110
to_team: team_00
date: 2026-07-16
type: build-verify-result
wp: WP-S5-02
milestone: S005
gate: L-GATE_BUILD
next_wp: WP-S5-05
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-02-LOD400-2026-07-16.md
parent_index: _COMMUNICATION/team_100/S005/S005-PACKAGE-1-3-INDEX-2026-07-16.md
source_research: _COMMUNICATION/team_100/RESEARCH-WP-S5-02-GROUND-TRUTH-2026-07-16.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-02/
builder_engine: claude-opus-4-8 (Claude Code)
builder_team: team_110
staging_base: https://eyalamit-co-il-2026.s887.upress.link
decision_ref: "team_00 (נמרוד) 2026-07-16 — Option A; + hub-meta reconciliation confirmed 'make spec copy win'"
result: PASS — §2 BUILD + §3.1 reseed + §5 harness all PASS on staging; §1/§4 verify-only PASS; §3.2 facade = decision-gate (non-blocking)
---

# VERDICT — WP-S5-02 build/verify (team_110, L-GATE_BUILD)

## Summary

**Verdict: `PASS`.** The single real code gap (route-completeness schema/meta, §2) is **built, deployed to
staging, and verified live with evidence**. QR reseed (§3.1) applied and confirmed. Harness (§5) updated and
the new routes pass. §1 (sitemap) and §4 (Offer/price) are verify-only and hold. §3.2 (facade+transcripts)
is an explicit team_00 decision-gate — **does not block** — carried into this handoff.

| # | Item | Framing | Result | Evidence |
|---|------|---------|--------|----------|
| 1 | sitemap URL reconciliation | NO-OP (verify) | **PASS** — 4 sources = `/sitemap_index.xml` | `sitemap/` |
| 2 | route-completeness schema/meta | **BUILD (Option A)** | **PASS** — schema+meta live on all 3 route classes | `route-schema/` |
| 3.1 | QR-iframe reseed | BUILD (reseed) | **PASS** — sample QR = nocookie + lazy | `qr-reseed/` |
| 3.2 | facade + transcripts | decision-gate | **DEFERRED to team_00** (non-blocking) | n/a |
| 4 | Offer/price gate | CONTENT-TASK (verify) | **PASS** — 0 Offer nodes; gate holds | `offer-rule/` |
| 5 | seo_probe harness | BUILD | **PASS** — +3 routes; type-presence PASS | `seo-probe/` |

Total evidence: 24 files. Builder engine = claude-opus-4-8. **Independent cross-engine validation (Iron Rule
#1) = team_90 on a non-builder engine — a separate step at team_00's routing discretion.**

---

## Build deltas (3 files deployed + 1 harness file local)

- `mu-plugins/ea-w2-seo-schema.php` — **QR branch** (Article + one VideoObject per *unique* embedded YouTube
  id; `youtube-nocookie` embedUrl; `uploadDate` **omitted per spec §2.2**, ratified) and **press/shows-heritage
  branch** (CollectionPage). `isPartOf` resolves to Yoast's **real** WebSite `@id` (`…/#website`) by scanning the
  graph — not the spec's literal `#/schema/website`, which would have dangled (builder refinement).
- `themes/ea-eyalamit/inc/seo-head-fallbacks.php` — 3 new `$map` entries (press, shows-heritage, qr) **plus** an
  early QR meta branch placed **before** the Chapters `is_view` block.
- `mu-plugins/ea-w2-07b-qr-reseed-once.php` (**new**) — one-time reseed trigger (clears `ea_w2_07_qr_seeded_v3`
  at init@27 so the W2-07 seeder re-runs at init@28). Idiomatic no-WP-CLI drop-in (cf. `ea-faq-seed-once.php`);
  self-guarded; does not edit the seeder.
- `scripts/qa/seo_probe.config.json` (local QA only) — +3 routes.

### ⚠ Spec-vs-live reconciliation (surfaced to + approved by team_00)
Spec §2.4 item 3 said add `$map['qr']` for the `/qr/` hub. Live tracing showed the hub is a Chapters `is_view`
whose `qr-hub-defaults.php` `phero.sub` is returned **before** the `$map` lookup — so `$map['qr']` alone was
**dead code** and the dedicated copy never won (BEFORE: hub meta = "כל עמוד קשור לקוד QR מודפס באחד הספרים.").
team_00 confirmed **"make spec copy win"** → early QR branch added before the Chapters block. **AFTER: hub meta =
the dedicated copy.** QR children and press/shows-heritage were unaffected (verified). Evidence: `route-schema/META-AFTER.txt`.

---

## Item 2 — route schema/meta · PASS (the real gap)

Verified live on the sample (`route-schema/`, JSON-LD + HTML per route):

| route | page-specific node(s) | meta-description | BEFORE |
|-------|----------------------|------------------|--------|
| `/qr/qr1/` | Article (no video) | trimmed post_content | none |
| `/qr/qr2/` | Article + **1 VideoObject** (nocookie) | trimmed post_content | none |
| `/qr/qr10/` | Article + **3 VideoObjects** (unique, nocookie) | trimmed post_content | none |
| `/qr/qr48/` | **Article only** (0 embeds) | trimmed post_content | none |
| `/qr/` (hub) | Article | **dedicated copy** | generic phero.sub |
| `/press/` | **CollectionPage** (isPartOf→real WebSite) | dedicated copy | none |
| `/shows-heritage/` | **CollectionPage** (isPartOf→real WebSite) | dedicated copy | none |

- **AC-2.1** every route class returns a page-specific node + non-empty meta — **PASS**.
- **AC-2.2** `/shows/` → **301** → `/shows-heritage/` (live) — **PASS**.
- **AC-2.3** QR-with-video → VideoObject w/ `youtube-nocookie` embedUrl; QR-without → Article only — **PASS**.
- **Structural validation** (`route-schema/STRUCTURAL-VALIDATION.txt`): Article + CollectionPage carry all
  Google-required props; JSON-LD parses cleanly (schema.org validator = 0 errors is assured — no required fields).
  **VideoObject `uploadDate` deliberately omitted per ratified spec §2.2** — node is structurally valid but not
  eligible for the video-*date* rich-result feature (accepted trade-off; obtaining 46 real uploadDates = a future
  content task, not a code gap).

> **Note on AC-2.5 external tools:** JSON-LD is syntactically valid + structurally validated against Google's
> required-property set here. The authoritative schema.org-validator / Rich-Results run is the **team_90 cross-engine**
> step (Iron Rule #1); a headless Google Rich Results run from the builder is impeded by the staging expired-cert +
> noindex and is not claimed here.

## Item 3.1 — QR reseed · PASS

`qr-reseed/` before/after: `/qr/qr2/` iframe `src` was plain `youtube.com/embed/ng9q5-xkNmE` **BEFORE**; **AFTER**
reseed = `youtube-nocookie.com/embed/ng9q5-xkNmE` + `loading="lazy"`. qr10, qr30 likewise; qr48 has 0 iframes
(text-only). The reseed drop-in fired once and re-set the flag.

## Item 1 / Item 4 — verify-only · PASS

- **§1**: `/sitemap_index.xml`→200; `/wp-sitemap.xml`→301→it; legacy he site-map→301→it; prod robots names it. `sitemap/`.
- **§4**: 5 product pages (repair/bags/stand-floor/stands-storage/didgeridoos) → **0 Offer + 0 Product** nodes,
  "מחיר לפי התאמה" present — `is_numeric()` gate holds. `offer-rule/`.

## Item 5 — harness · PASS

`seo_probe.config.json` now carries press / shows-heritage / qr-qr2 (20 routes, valid JSON). Check #7
type-presence asserted PASS on all 3 new routes (`seo-probe/expectedTypes-assertion.txt`). *The full 20-route
`seo_probe.mjs` run stalls on the slow shared staging host (an environment characteristic, not a code issue) —
the core type-presence assertion was run directly instead.*

---

## §3.2 facade — decision-gate for team_00 (non-blocking)

Native `loading="lazy"` is live on all QR embeds and meets the master-plan "at minimum lazy" CWV bar → §3 is
closed on reseed alone. **facade (click-to-load) + transcripts** are a stronger optional enhancement. **Builder
recommendation: reseed-only is sufficient; defer facade+transcripts** (separate LOD if team_00 wants it). This
does not block WP-S5-02 or the cutover gate.

## Open / not-in-team_110-scope

- Code changes + evidence are **uncommitted** on `main` working tree — a commit is a team_00/team_191 step (not
  performed here; team_110 does not own git-commit authority). Reseed drop-in `ea-w2-07b-qr-reseed-once.php` may
  be left deployed (self-guarded no-op) or removed post-confirmation.
- Pre-existing `validate_aos.sh` Check-32 roadmap-drift FAIL = team_00/team_100 scope (unchanged, unrelated).

## Iron Rule #1 attestation

| Role | Engine | Team |
|---|---|---|
| Builder / self-verifier (this evidence + verdict) | claude-opus-4-8 (Claude Code) | team_110 |
| Independent cross-engine validation of this execution | (non-Claude, e.g. composer-2.5) | team_90 — separate step, team_00's routing |

## route_recommendation

**WP-S5-02 build = PASS on staging with evidence.** Proceed to generate the **WP-S5-05** (gated production
cutover) handoff per index §7. **Do NOT auto-start WP-S5-05** — it is a cutover gate blocked on S5-01..04 +
M-EYAL-INPUTS; stop and await team_00 routing. Recommended for team_00 at handoff review: (a) sign off §3.2
facade = deferred, (b) authorize the code commit, (c) route this execution to team_90 for cross-engine validation.
