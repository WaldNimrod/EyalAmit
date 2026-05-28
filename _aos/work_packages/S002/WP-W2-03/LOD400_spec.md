# LOD400 Spec — WP-W2-03
# Muzza Publishing Catalog + 3 Book Detail Pages

**WP ID:** WP-W2-03 | **Track:** A | **Milestone:** S002 | **Profile:** L0
**Owner/Builder:** team_10 | **L-GATE_BUILD:** team_50 (non-Claude) | **L-GATE_VALIDATE:** team_190 (Codex)
**Depends on:** WP-W2-02 (COMPLETE — template system + D-14 blocks) | **Authored:** 2026-05-28 (team_100) | **lod_status:** LOD400
**Content SSoT (25.5.26):** `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/`

---

## Objective
Catalog page `/books` + 3 book-detail pages live on staging with full Hebrew content from 25.5.26 sources, shared `tpl-book-detail` template, and external Green Invoice purchase links. Measurable: 4 URLs return 200, each book page renders all required blocks, purchase buttons open Green Invoice in a new tab with GA4 tracking.

## Pages & content sources
| Page | URL | Template | Content source (.md) | Blocks |
|------|-----|----------|----------------------|--------|
| Catalog | `/books` | `tpl-books.php` (in is_active_view list) | `מוזה הוצאה לאור - ספרים/MUZZA.md` | 12: header, hero, intro, about-Eyal, why-here, 3 book cards, bundle block (inline, not a page), 3 worlds, purchase CTA, shipping, closing |
| וכתבת | `/books/vekatavta` | `tpl-book-detail.php` | `וכתבת/vekatavta.md` | 14 |
| כושי בלאנטיס | `/books/kushi-blantis` | `tpl-book-detail.php` | `כושי בלאנטיס/kushi_full.md` | 14 |
| צבע בכחול וזרוק לים | `/books/tsva-bekahol` | `tpl-book-detail.php` | `צבע בכחול וזרוק לים/eyal_tsva_FINAL.md` | 14 |

## tpl-book-detail block contract (each book page)
Per LOD200 §WP-W2-03 / AC-02, each book page MUST render: summary (תקציר) · excerpt (קטע מתוך) · about-the-book (על הספר) · gallery · purchase (Green Invoice button) · who-it's-for (למי מתאים) · filtered FAQ · press mentions (if any) · closing CTA. Copy verbatim from the page's source .md (no rewriting; flag typos, don't fix without approval).

## Cross-cutting (reuse W2-01/W2-02 infra — do NOT rebuild)
- Route via `template_include` priority 100 + `set_query_var('ea_wave2_shell', true)` (same pattern as W2-02 `ea_w2_02_template_include`); add a `ea_w2_03_*` router in a new `inc/wave2-w2-03.php` (require in `functions.php`, append only).
- Body class `ea-wave2-shell`; D-14 tokens only (no raw hex); consume Stage-B asset dequeue.
- `style.css` Version bump — coordinate slot (next after 1.4.1).
- Book covers: migrate from legacy media (`usage_count>0`); grey placeholder if missing — request file from Eyal.

## Acceptance Criteria
- AC-01: 4 URLs (`/books`, `/books/vekatavta`, `/books/kushi-blantis`, `/books/tsva-bekahol`) return HTTP 200.
- AC-02: each book page renders all required blocks (block contract above).
- AC-03: purchase button opens Green Invoice in new tab + fires GA4 event.
- AC-04: `/books` shows 3 book cards + bundle block; each card links to its `/books/<slug>`.
- AC-05: H1 + body copy match 25.5.26 source 1:1.
- AC-06: `validate_aos.sh` 0 FAIL; mobile responsive (cards 3-up desktop / stacked mobile).

## Out of scope
Additional books; local cart/WooCommerce; Muzza-as-blog-category (that's W2-06); press extraction (W2-07).

## Dependencies & external inputs
- Blocker: WP-W2-02 (COMPLETE ✓).
- External (non-blocking with fallback): 3 Green Invoice links from Eyal (placeholder `#` + "רכישה — צור קשר" until provided); book cover images (grey placeholder until provided).

## Gate sequence
L-GATE_ELIGIBILITY → L-GATE_SPEC (this doc) → L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190).
