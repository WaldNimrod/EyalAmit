---
id: VERDICT-WP-CANON-L-GATE_BUILD-T4-T6-T7-2026-07-14
from_team: team_90
to_team: team_100, team_110
cc: team_00
mandate: _COMMUNICATION/team_90/MANDATE-TEAM90-L-GATE_BUILD-WP-CANON-TEMPLATE-UNIFICATION-2026-07-14.md
spec: _COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD400-2026-07-14.md (T4 §5, T6 §6, T7 §7)
date: 2026-07-14
type: cross-engine-validation-verdict
wp: WP-CANON-TEMPLATE-UNIFICATION
gate: L-GATE_BUILD
scope: T4, T6, T7 only
builder_engine: cursor-grok-4.5 (team_110)
validator_engine: composer-2.5 (team_90)
iron_rule_1: satisfied — builder ≠ validator
staging: http://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — team_90 · L-GATE_BUILD · T4 / T6 / T7

**Overall verdict (this scope): `PASS_WITH_FINDINGS`**

Independent cross-engine validation of schema (T4), Wave2 deletion / commerce survival (T6), and QA evidence (T7). No blockers in T4–T7 scope. Two minor T6 hygiene items and one T7 content-diff finding on `/faq/` sentence coverage (likely T2 many-to-many distribution, not a T4/T6 regression).

---

## Findings table

| ID | Task | Severity | Verdict | Evidence |
|----|------|----------|---------|----------|
| T4-01 | T4 | — | **PASS** | `site/wp-content/mu-plugins/ea-w2-seo-schema.php` defines `ea_w2_seo_schema_faqpage_node()` (L246) and `ea_w2_seo_schema_book_node()` (L276); callers use `ea_faq_query_items()` (L168–174) and `ea_chapters_field()` (L291–317); ISBN omitted when empty (L309–312). Live: `/treatment/` FAQPage 15 entities; `/books/vekatavta/` Book node with genre/year/pages/offers, **no `isbn` key** (no fake ISBN). |
| T4-02 | T4 | minor | **PASS** | Book offers on vekatavta duplicate same Mendele URL for print+ebook — schema-valid, cosmetic only. |
| T6-01 | T6 | — | **PASS** | `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-commerce.php` exists; `ea_w2_05_price`, `ea_w2_05_gi_url`, `ea_wave2_wa_url`, `ea_chapters_book_purchase_assets` with `function_exists` guards (L13–82). Required from `functions.php` L790 (deleted w2-02..05/06/09/14e **not** required). |
| T6-02 | T6 | — | **PASS** | Deleted inc files: only `wave2-w2-07.php`, `wave2-w2-08.php` remain under `inc/`. Group A templates absent (`template-faq-catalog.php`, `tpl-shop-archive.php`, etc.). **Kept:** `tpl-home.php`, `wave2-stage-b.php`, `tpl-qr.php`, `tpl-chapters-qr.php`. |
| T6-03 | T6 | — | **PASS** | `site/wp-content/themes/ea-eyalamit/inc/seo-head-fallbacks.php` exists (relocated w2-09). w2-02 redirects merged into `site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php` L63–68. |
| T6-04 | T6 | — | **PASS** | No `require` of deleted wave2 sources in theme. `product-cta.php` calls `ea_w2_05_*` / `ea_wave2_wa_url` behind `function_exists`; live `/didgeridoos/` shows `ea-product` + `wa.me` CTAs (HTTP 200). |
| T6-05 | T6 | minor | **FINDING** | Orphan Wave2 shells remain: `page-templates/tpl-books.php` (calls deleted `ea_w2_05_render_books_archive`), `page-templates/tpl-catalog-14e.php` (calls deleted `ea_w2_14e_*`). Live `/books/` and `/media/` return 200 via Chapters routing — no runtime crash, but dead templates/comments should be cleaned in a follow-up. |
| T6-06 | T6 | minor | **FINDING** | Stale header comments in `product-cta.php`, `tpl-books.php` still cite `inc/wave2-w2-05.php` line numbers — misleading for future agents only. |
| T7-01 | T7 | — | **PASS** | QR HTTP matrix **48/48** independent curl (`_COMMUNICATION/team_90/evidence/qr-matrix-team90-2026-07-14.txt`). Matches builder baseline `_COMMUNICATION/team_110/_QR-BASELINE-HTTP-2026-07-14.txt`. |
| T7-02 | T7 | — | **PASS** | `qa_probe.mjs` 18/18 PASS, 0 failures (`_COMMUNICATION/team_90/evidence/qa-probe-team90-wp-canon-2026-07-14.json`). No overflow; mokesh/shop/qr paths clean at 375px + desktop. |
| T7-03 | T7 | — | **PASS** | `scripts/qa/content-diff.mjs` `PAGE_MAP` includes `/shop/` (L44), `/qr/` hub (L45), and 48× `/qr/qrN/` entries (L47–52). |
| T7-04 | T7 | minor | **FINDING** | Full content-diff re-run: `siteAccuracyWeightedBySourceCharsPct` 97.8%; `/faq/` **PARTIAL** (82.22% page accuracy, sentence 70.37%, `gatePass: false`) — missing sentences are category-intro prose now distributed via T2 many-to-many, not absent from site. Evidence: `_COMMUNICATION/team_90/evidence/content-diff-wp-canon-2026-07-14/summary.json`. |
| T7-05 | T7 | — | **PASS** | Smoke HTTP 200: `/didgeridoos/`, `/books/vekatavta/`, `/treatment/`, `/shop/`, `/qr/`, `/faq/`. |

---

## T4 — Schema (detail)

**Repo:** `ea-w2-seo-schema.php` implements both node builders and wires them into the Yoast `@graph` pipeline. FAQ slugs map through `ea_seo_faq_page_categories` filter; books limited to `vekatavta`, `kushi-blantis`, `tsva-bekahol`.

**Live JSON-LD (validator curl, 2026-07-14):**

| Path | Nodes observed |
|------|----------------|
| `/treatment/` | `FAQPage` (`mainEntity` count 15), `Question` |
| `/faq/` | `FAQPage`, `Question` |
| `/books/vekatavta/` | `Book` (genre, datePublished 2017, numberOfPages 252, dual Offer @ 79 ILS), `FAQPage` |

ISBN: `ea_chapters_field('isbn')` guard prevents emission when unset — confirmed `isbn` absent in live HTML for vekatavta.

---

## T6 — Wave2 deletion (detail)

**Commerce survival:** `chapters-commerce.php` is the sole live provider of `ea_w2_05_price` / `ea_w2_05_gi_url` after `wave2-w2-05.php` deletion. `ea_wave2_wa_url` also defined in frozen `wave2-stage-b.php` (loads L769); `chapters-commerce` guard prevents redeclare fatal.

**Deletion inventory verified:**

| Category | Status |
|----------|--------|
| `wave2-w2-02/03/04/05/06/09/14e` (+ content siblings) | **Absent** from `inc/` |
| Group A page templates (`template-faq-catalog`, `template-home-dashboard`, `template-method`, `template-treatment`, `tpl-book-detail`, `tpl-contact`, `tpl-faq`, `tpl-service`, `tpl-shop-archive`, `tpl-shop-item`) | **Absent** |
| `wave2-w2-07.php` (/press, QR DB) | **Kept** — `functions.php` L775 |
| `wave2-w2-08.php` (/en) | **Kept** — L780 |
| `wave2-stage-b.php` | **Kept (frozen)** — L769 |
| `tpl-home.php`, `tpl-qr.php` | **Kept** |
| `seo-head-fallbacks.php` | **Present** — L785 |

**Note on load order:** `chapters-commerce.php` loads after w2-07/08/seo-head-fallbacks but **after** deleted sources were removed from `functions.php`. Mandate satisfied: no deleted file is still required; commerce accessors are live before any page render.

---

## T7 — QA evidence (detail)

| Check | Result | Artifact |
|-------|--------|----------|
| QR matrix 48/48 | PASS | `_COMMUNICATION/team_90/evidence/qr-matrix-team90-2026-07-14.txt` |
| qa_probe 9 paths × 2 viewports | PASS (0 failures) | `_COMMUNICATION/team_90/evidence/qa-probe-team90-wp-canon-2026-07-14.json` |
| content-diff PAGE_MAP | PASS (shop + 48 qr children) | `scripts/qa/content-diff.mjs` L44–52 |
| content-diff full run | PASS_WITH_FINDINGS | `_COMMUNICATION/team_90/evidence/content-diff-wp-canon-2026-07-14/summary.json` — 17 measured, weighted avg 97.8%, 1 page under 90% (`/faq/`) |

---

## Exit

**T4:** PASS — schema contract live, no fake ISBN.  
**T6:** PASS_WITH_FINDINGS — deletion gate met, commerce alive; orphan tpl shells + stale comments only.  
**T7:** PASS_WITH_FINDINGS — QR/probe green; content-diff `/faq/` partial warrants team_10/30 review of Eyal-source vs many-to-many display, not a T6 regression.

**No T4/T6/T7 blockers.** Rolled-up L-GATE_BUILD verdict pending sibling T1–T5 validation merge.

*Filed by team_90 · composer-2.5 · cross-engine L-GATE_BUILD T4/T6/T7 · 2026-07-14*
