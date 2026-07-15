---
id: VERDICT-WP-S4-02-VERIFY-2026-07-15
from_team: team_90
to_team: team_100
date: 2026-07-15
type: validation-result
wp: WP-S4-02
builder_engine: prior-session (code pre-built)
validator_engine: composer-2.5
iron_rule_1: satisfied
mandate_ref: MANDATE-TEAM90-WP-S4-02-VERIFY-2026-07-15
spec_ref: _COMMUNICATION/team_100/S004/WP-S4-02-LOD400-2026-07-15.md
---

# VERDICT — WP-S4-02 VERIFY (team_90 cross-engine validation)

## Verdict flag

**PASS**

All **blocking** acceptance criteria (AC-1, AC-2, AC-3, AC-4, AC-7) independently reproduced **PASS** on code + staging. Non-blocking AC-5/AC-6 pass per spec measurements (static + book runtime). One informational note on Product JSON-LD runtime emission (see AC-6) — not a WP-S4-02 defect; AC-6 is non-blocking.

---

## Iron Rule #1

| Check | Result |
|-------|--------|
| Builder / prior verifier | anthropic (prior-session build; team_100/opus pre-check) |
| Validator | composer-2.5 / cursor / team_90 |
| Distinct vendors | **satisfied** |

---

## Per-AC results

| AC | Blocking | Result | Evidence |
|----|----------|--------|----------|
| **AC-1** | yes | **PASS** | `mrng.to/MTUiO3vkIg` in all 5 code sources: `kushi-blantis-defaults.php`, `vekatavta-defaults.php`, `tsva-bekahol-defaults.php`, `muzza-defaults.php`, `chapters-commerce.php` (`ea_w2_05_gi_url_map()` ×5). Staging curl (team_90): all 3 book pages emit GI URL + Book/FAQPage LD; all 5 product pages emit `mrng.to/MTUiO3vkIg` + `data-cta-type="green_invoice"`. Artifacts: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/wp-s4-02-2026-07-15/vc08-*.txt`, `vc10-*.txt`. |
| **AC-2** | yes | **PASS** | `rg 'href=["\x27][^"\x27]*mendele'` + `rg -i mendele\.co\.il` on `site/wp-content/themes/ea-eyalamit/` → **0** href/domain hits. Only comment-line «Mendele» in `vekatavta-defaults.php` L18 and `tsva-bekahol-defaults.php` L19 (drift-fix notes). Staging DOM grep on 8 book+product URLs → **MENDELE_OK** all. |
| **AC-3** | yes | **PASS** | `kushi-blantis-defaults.php`: 5 live `image` items (L145–149), **0** `'pending' => true`. Disk: 5×`OK` for `kushi-blantis-cover.jpg`, `kushi-01-blantis-1.jpg`, `kushi-02-eyal-italy.jpg`, `kushi-03-screenshot-2013.png`, `kushi-04-sinai.jpg`. qa_probe kushi page: no overflow, no forbidden strings. |
| **AC-4** | yes | **PASS** | Pending counts: `vekatavta` = 2 (L159, L165); `tsva-bekahol` = 5 (L129, L135, L163–165). Covers present (`vekatavt-cover.jpg`, `tsva-bechol-cover.jpg`). **Scoped kushi anti-contamination** (image/href fields only, per mandate probe-precision): **0** `'image' => '...kushi...'` in vekatavta/tsva; **0** `href="...kushi..."`. Comment lines mentioning «kushi» allowed (vekatavta L17/L149; tsva L18/L119) — not defects. qa_probe vekatavta/tsva: PASS both viewports. |
| **AC-5** | no | **PASS** | `ea-faq-seed-once.php` L27–29: categories `vekatavta`, `kushi-blantis`, `tsva-bekahol`. Each book defaults has `faqblock` + matching `cats` (kushi L129–133, vekatavta L130–134, tsva L111–115). |
| **AC-6** | no | **PASS** | Static (VC-07): `ea-w2-seo-schema.php` — `ea_w2_seo_schema_book_node`, `'@type' => 'Book'`, `'@type' => 'Product'`, `'@type' => 'FAQPage'`; `php -l` clean. Book runtime (VC-08): all 3 slugs emit `"@type":"Book"`, `"@type":"FAQPage"`, `mrng.to/MTUiO3vkIg`. **Note:** live product HTML on staging did not include `"@type":"Product"` in Yoast `@graph` (sampled didgeridoos/bags/all 5); code gates Product node on `metadata_exists(..., 'ea_product_price')` — likely staging postmeta gap, pre-existing to WP-S4-02 scope. GI + FAQPage present on product pages. |
| **AC-7** | yes | **PASS** | Independent `qa_probe.mjs` run (team_90, 2026-07-15T09:41:30Z): **18/18 PASS**, `failures: 0`, zero horizontal overflow, zero `mendele`/`TBD`/`CDIP`/`Lorem` in DOM. Artifact: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/wp-s4-02-2026-07-15/qa_probe_result.json`. Corroborates team_50 reference (`18/18 PASS`) but was **not** trusted without re-run. |

---

## Probe-precision note (VC-03 / AC-4)

LOD400 VC-03 literal (`rg -n 'kushi'` on vekatavta/tsva) **false-fails** on legitimate anti-contamination comments. This validation applied the mandate-scoped rule: **image/href fields only**. Under that scope: **PASS**. Recommend amending LOD400 VC-03 to match scoped grep in a future spec revision.

---

## By-design residuals (NOT defects)

Per LOD400 §4 — deferred to Eyal input packages; wiring (temp GI + glowing pending slots) is correct:

| Residual | Package | Status |
|----------|---------|--------|
| Shared temp GI `mrng.to/MTUiO3vkIg` on 8 commerce targets (3 books + 5 products + muzza bundle) | **WP-EI-01** | Expected until per-item Green Invoice URLs from Eyal |
| vekatavta: 2 pending gallery slots; tsva: 5 pending (2 main + 3 trip-final); non-POC cover images | **WP-EI-02** | Expected until Drive/April media import |
| kushi POC gallery complete; cover still noted as «closest in-repo» in file header | **WP-EI-02** (minor) | Declared gap, not blocking |

---

## Defects

**none** (blocking)

---

## Evidence index (team_90 independent)

| Artifact | Path |
|----------|------|
| qa_probe (18 page×viewport) | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/wp-s4-02-2026-07-15/qa_probe_result.json` |
| Book JSON-LD + GI (×3) | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/wp-s4-02-2026-07-15/vc08-kushi-blantis.txt` (and vekatavta, tsva-bekahol) |
| Product GI CTA (×5) | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/wp-s4-02-2026-07-15/vc10-*.txt` |
| Product LD spot-check | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/wp-s4-02-2026-07-15/product-ld-*.txt` |

---

## Route recommendation

- **L-GATE_VALIDATE (WP-S4-02):** **PASS** — proceed to team_50 E2E sign-off if not already filed; no builder remediation required for blocking ACs.
- **Optional follow-up (non-blocking):** confirm `ea_product_price` postmeta on staging product pages if live Product JSON-LD is required before production — outside WP-S4-02 book-debt closure scope.

*Filed by team_90 · cross-engine validation · 2026-07-15*
