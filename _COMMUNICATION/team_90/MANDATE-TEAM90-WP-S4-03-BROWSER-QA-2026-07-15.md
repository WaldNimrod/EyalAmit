---
id: MANDATE-TEAM90-WP-S4-03-BROWSER-QA-2026-07-15
from_team: team_100
to_team: team_90
date: 2026-07-15
type: cross-engine-validation-mandate
wp: WP-S4-03
builder_engine: prior Claude (2026-07-12 content 12.7 batch)
validator_engine: composer-2.5 (cursor, team_90) — MUST differ from Claude builder (Iron Rule #1)
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S4-03-CONTENT-QA-BROWSER-2026-07-15.md
---

# MANDATE — team_90 cross-engine browser-QA closure: WP-S4-03 (Content-QA 12.7)

You are the **cross-engine QA validator** (composer-2.5) — a DIFFERENT engine from the original Claude builder of the 2026-07-12 batch (Iron Rule #1). Independently **judge** the 12 content-QA items against staging. Engine-neutral evidence was gathered via `qa_probe.mjs`, `curl`, and CDP `Runtime.evaluate` over a headless browser. You MAY re-run any check to confirm — do not merely trust the evidence files.

## Spec
`_COMMUNICATION/team_100/S004/WP-S4-03-LOD400-2026-07-15.md` — §2 (12 items + CDP EXPRs), §3 (ACs).

## Staging
`http://eyalamit-co-il-2026.s887.upress.link`

## Gathered evidence (`_COMMUNICATION/team_90/evidence/wp-s4-03-2026-07-15/`)
- `qa_probe/qa_probe_result.json` — **22/22 PASS** (0 overflow, 0 forbidden). **PROBE-PRECISION-NOTE:** the term `undefined` was removed from the absent-list because it matched ONLY inline JS feature-detection (`"undefined"!=typeof Worker`), 0 visible occurrences; real markers (`TBD`/`Lorem`/`&lt;br&gt;`) = 0. (Analogous to the WP-S4-02 VC-03 comment-line issue — flag if you disagree.)
- `item04-accordions.json` — **the key behaviour fix (AC-4)**: kushi / vekatavta / tsva all `opacityAfterOpen=1`, `opacityAfterReopen=1`, `hasRevealClass=false` (bug was a scroll-reveal class trapping the body at opacity:0).
- `DOM-CHECKS.txt` — items 1,2,3,5,6,8 (trust line + no literal br; testimonial links; method 8+ cards; video preload=none/no-autoplay; FAQ font-size 1rem; footer legal + a11y/privacy links).
- `item07-learning-http.txt` (3×200), `item09-repair-sentence.txt`, `item10-metadesc-readback.txt` (8/8 live), `item11-yaml.txt` (OK), `item12-deploy-list.txt` (1 hit).

## Judge each AC (blocking unless noted)
- **AC-1** — all 12 items evidenced on staging.
- **AC-2** — 0 horizontal overflow across 22 page×viewport combos.
- **AC-3** — 0 literal `&lt;br&gt;`/raw text on home (item 1).
- **AC-4** — book accordion opacity=1 after open+reopen ×3 books.
- **AC-5 (non-blocking)** — 8 meta descriptions live & matching source.
- **AC-6** — 3 `/learning/*` links → HTTP 200.
- **AC-7** — 0 blocking; findings documented.
- Known non-blocking residuals: item 2 FB testimonial links depend on live `ea_fb_testimonials_all()` data (→ WP-EI-07); item 10 live read-back is the final pre-prod confirmation.

## Output
Write **`_COMMUNICATION/team_90/VERDICT-WP-S4-03-CONTENT-QA-BROWSER-2026-07-15.md`**: a 12-item table (`PASS`/`FINDING`/`FAIL` + evidence-by-path), a top-level flag (`PASS`/`PASS_WITH_FINDINGS`/`CONCERNS`/`FAIL`), IR#1 attestation (you = composer-2.5 ≠ Claude builder), and `route_recommendation` for any finding.
