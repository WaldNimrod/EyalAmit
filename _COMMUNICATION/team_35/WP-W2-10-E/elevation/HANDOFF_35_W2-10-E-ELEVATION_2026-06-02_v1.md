---
id: HANDOFF_35_W2-10-E-ELEVATION_2026-06-02_v1
from_team: team_35
to_team: team_10
cluster: E (Commerce)
templates: [tpl-books, tpl-book-detail, tpl-shop-archive]
routes: [/books, /books/*, /shop]
status: READY_FOR_S2
date: 2026-06-02
new_tokens: 0
new_atoms: 0
gcr_flags: 0
---

# HANDOFF — Cluster E (Commerce) elevation → READY_FOR_S2

## Files
- `mockup/commerce-books-archive.html` — /books archive + /shop DNA demo
- `mockup/commerce-book-detail.html` — /books/vekatavta detail (clone for kushi, tsva)
- `narrative/elevation-notes.md`, `assets/asset-manifest.md`

## Archive block order
1. topnav (current=ספרים) · 2. book-hero (kicker) · 3. why-here prose
4. **book-cards ×3 with real covers + genre + price + footer**
5. **bundle (stacked real covers, Chocolate bg, Morning CTA)**
6. shop-grid ×5 (4:3 product gaps, quote prices)
7. footer

## Detail block order
1. topnav · 2. **book-hero with real cover split + kicker + price CTA**
3. meta strip · 4. summary · 5. **excerpt (open)** · 6. about
7. gallery (1 real + gaps) · 8. who · 9. mid-CTA (print + e-book)
10. FAQ ×4 · 11. closing CTA · 12. footer

## Guardrails (S3)
- Reuse `ea-tokens.css`, `ea-atoms.css`, `w2-05-shop.css` verbatim. No new tokens/atoms.
- External purchase links only (table in asset-manifest). No embedded checkout.
- Clone detail for all 3 books; reuse shop card for 5 products.
- Single H1 per page; AA contrast; RTL.

## HALT — team_35 stops at S2 → Eyal sign-off → team_10 (S3).
