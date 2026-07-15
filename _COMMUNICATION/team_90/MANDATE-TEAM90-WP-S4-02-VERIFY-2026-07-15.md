---
id: MANDATE-TEAM90-WP-S4-02-VERIFY-2026-07-15
from_team: team_100
to_team: team_90
date: 2026-07-15
type: cross-engine-validation-mandate
wp: WP-S4-02
builder_engine: prior-session (code pre-built); verifier team_100/opus (anthropic)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic verifier ≠ cursor validator (distinct vendors)
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S4-02-VERIFY-2026-07-15.md
---

# MANDATE — team_90 cross-engine verification: WP-S4-02 (books technical-debt closure)

WP-S4-02 is a **verification** package — the book/product code was built in a prior session. **Independently reproduce** the blocking acceptance criteria. Do NOT trust any prior report.

## IMPORTANT probe-precision note (spec bug)
The spec's literal VC-03 (`rg -n 'kushi'` must = 0 on vekatavta/tsva) **false-fails** on legitimate code-comment lines that document the anti-contamination intent. Scope the kushi cross-contamination check to **image/href fields only** — i.e. `'image' => '...kushi...'` or `href="...kushi..."`. Comment lines mentioning "kushi" are allowed.

## Sources of truth
- Spec (ACs): `_COMMUNICATION/team_100/S004/WP-S4-02-LOD400-2026-07-15.md`
- Files: `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/{kushi-blantis,vekatavta,tsva-bekahol,muzza}-defaults.php`, `inc/chapters/chapters-commerce.php`, the 5 product defaults, `template-parts/chapters/parts/gallery.php`, `mu-plugins/ea-faq-seed-once.php`, `mu-plugins/ea-w2-seo-schema.php`
- Staging: `http://eyalamit-co-il-2026.s887.upress.link` (books + products deployed)
- Existing QA evidence: `_COMMUNICATION/team_50/evidence/wp-s4-02-2026-07-15/qa_probe_result.json`

## Checks — reproduce independently
- **AC-1 (blocking)** — temp Green-Invoice link `mrng.to/MTUiO3vkIg` present on the 3 books + the 5-product commerce GI map (`ea_w2_05_gi_url_map()`), and renders on staging book+product pages.
- **AC-2 (blocking)** — **0** Mendele purchase `href` anywhere (code-comment mentions allowed); 0 in rendered DOM.
- **AC-3 (blocking)** — kushi gallery = live images, **0** pending slots in `kushi-blantis-defaults.php`.
- **AC-4 (blocking)** — vekatavta + tsva-bekahol: cover + pending slots (vekatavta=2, tsva=5) + **0** kushi images in `'image'` fields (scoped per note above).
- **AC-5/6 (non-blocking)** — FAQ categories seeded (`ea-faq-seed-once.php`) + `faqblock` wired on book pages; Book + Product + FAQPage JSON-LD nodes in `ea-w2-seo-schema.php`.
- **AC-7 (blocking)** — 0 horizontal overflow on books+products (reference the team_50 `qa_probe_result.json`: 18/18 PASS).
- **By-design residuals (NOT defects):** real per-item GI URLs → WP-EI-01; real gallery photos → WP-EI-02.

## Required output
Write your verdict to **`_COMMUNICATION/team_90/VERDICT-WP-S4-02-VERIFY-2026-07-15.md`** with: frontmatter (`validator_engine: composer-2.5`, `wp: WP-S4-02`, `iron_rule_1: satisfied`); a single top-level **verdict flag** (`PASS` / `PASS_WITH_FINDINGS` / `CONCERNS` / `FAIL`); a per-AC table with PASS/FAIL + evidence; and note by-design residuals separately from defects.
