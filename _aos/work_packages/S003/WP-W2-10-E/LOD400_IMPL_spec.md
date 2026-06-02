# LOD400 — WP-W2-10-E · Commerce templates FULL IMPLEMENTATION (post-elevation)

**WP:** WP-W2-10-E | **Milestone:** S003 | **Parent:** WP-W2-10 (Track-2) | **Priority:** HIGH | **Profile:** L0
**Builder:** team_10 (S3) · **Tokens:** team_80 (S4) · **QA:** team_50 → **Validate:** team_190 (Cursor)
**Authored:** 2026-06-02 (team_100) | **lod_status:** LOD400 (implementation-grade)
**Source of truth:** `_COMMUNICATION/team_35/WP-W2-10-E/elevation/` (`commerce-books-archive.html` + `commerce-book-detail.html` + elevation-notes + handoff; READY_FOR_S2, 0 new tokens/atoms, 0 GCR).
**Shared conventions:** inherit render-pattern / D-14 discipline / https-perf ACs / gate prompts from `WP-W2-10-A/LOD400_IMPL_spec.md`.

## 0. Objective
Implement the elevated **Commerce** composition across `/books` (archive) + 3 book details + `/shop` (5 items).
Live state: `tpl-books.php` (153L) + `tpl-book-detail.php` (151L) partially built; `tpl-shop-archive.php` / `tpl-shop-item.php` are stubs.
Composition-only on D-14 (`ea-tokens`, `ea-atoms`, `w2-05-shop.css`). Content from `inc/wave2-w2-05-content.php`.

## 1. Gate
READY_FOR_S2 → S2 Eyal sign-off (team_00 proxy) gates S3. **Purchase = EXTERNAL links only** (Morning / Mendele / Green-Invoice) — no embedded checkout.

## 2. Archive (`/books`, tpl-books) block order
1. topnav (current=ספרים) · 2. book-hero (kicker "הוצאה לאור · עצמאית מאז 2004") · 3. why-here prose (`section--prose --alt`) ·
4. **book-cards ×3 with REAL covers** + genre eyebrow + **price line + "לעמוד הספר" footer** (`book-card`) ·
5. **bundle** — stacked-cover visual (3 real covers fanned ±6°) on `--ea-chocolate`, strong price + strike, external Morning CTA ·
6. shop-grid ×5 (`shop-card`, 4:3 product gaps, price-by-quote) · 7. footer.

## 3. Detail (`/books/<slug>`, tpl-book-detail) block order
1. topnav · 2. **book-hero with REAL cover** 1fr/220px split + kicker + price-on-CTA · 3. meta strip (מחבר/עמודים/סיפורים/שנה) ·
4. summary (verbatim real) · 5. **excerpt OPEN by default** (`book-excerpt`) · 6. about · 7. gallery (1 real + gaps) ·
8. who · 9. mid-CTA (print `--primary` + e-book `--secondary` olive) · 10. FAQ ×4 (verbatim) · 11. closing CTA · 12. footer.

## 4. Real-asset wiring + clones
- Covers → theme media: `vekatavt-cover.jpg`, `kushi-blantis-cover.jpg`, `tsva-bechol-cover.jpg`.
- Detail mockup is **vekatavt**; **clone for kushi-blantis** (Morning link) and **tsva-bechol** (Mendele link) — swap copy from each route's content SSoT (`wave2-w2-05-content.php`).
- Shop: 5 products reuse `shop-card`; 4:3 product photos = graceful gaps until Eyal supplies; prices by-quote.

## 5. Acceptance (E-specific; else per A §7)
- AC-E2 `/books` + 3 details + `/shop` render the elevated composition (no stub fallback); match the 2 mockups.
- AC-E-ext: all purchase CTAs are external links (no checkout); correct per-book vendor (Morning/Mendele).
- AC-E-detail: real cover in hero; excerpt open; FAQ verbatim; single H1/page.
- (zero drift; axe 0/0 across archive + 1 detail + /shop; LH https a11y 100 / mobile perf ≥85 on /books + 1 detail; validate 0 FAIL; routes 200; RTL.)

## 6. Build sequence / gates
Per A §8/§9. Order: archive cards (real covers + price/footer) → bundle stacked-cover → wire 3 detail clones → shop 5-card grid.
S4 team_80 (bundle/meta/hero-split use existing tokens; `--ea-chocolate` bg is existing) → S5 team_50 (`/books/ <one-detail> /shop/`) → team_190 (Cursor). HALT for S2 first.

## 7. Risk
Vendor link correctness per book (asset-manifest table is SSoT); shop product photos absent (graceful gaps, non-blocking); confirm `tpl-shop-archive`/`tpl-shop-item` get the same render treatment as books (don't leave as stubs).
