# Elevation Notes — WP-W2-10-E · Commerce (`tpl-books` + `tpl-book-detail` + `tpl-shop-archive`)

**Routes:** `/books` (archive) + 3 book details + `/shop` (5 items, DNA reuse).
**S1 source:** `commerce-books-archive.html`, `commerce-book-detail.html`.

## Archive — changes vs S1 (zero new tokens/atoms)
| # | Section | Change | Atoms |
|---|---|---|---|
| 1 | Hero | Added kicker ("הוצאה לאור · עצמאית מאז 2004"). | `book-hero` |
| 2 | Why-here | Kept (direct-sale rationale, real copy). | `section--prose --alt` |
| 3 | **Book cards** | **Real cover art swapped into all 3 cards** (S1 had `[כריכה — נדרש]` placeholders). Added genre eyebrow + **price line + "לעמוד הספר" footer** (desirability + buy path, AC-E1 Commerce). | `book-card` |
| 4 | **Bundle** | Elevated to **stacked-cover visual** (3 real covers fanned ±6°) on Chocolate bg; price strong + strike. External Morning CTA. | `bundle` atom recomposed on `--ea-chocolate` |
| 5 | Shop DNA | Same card grid, 4:3 product placeholders (graceful gaps), price-by-quote lines. | `shop-card` |

## Detail — changes vs S1 (`commerce-book-detail.html`, route /books/vekatavta)
| # | Section | Change | Atoms |
|---|---|---|---|
| 1 | Hero | **Real cover floated into hero** in a 1fr/220px split (S1 was gradient-only) + kicker + price on CTA. | `book-hero` recomposed |
| 2 | Meta strip | NEW (מחבר/עמודים/סיפורים/שנה). | type tokens |
| 3 | Summary | Kept verbatim real content. | `section` + `book-prose` |
| 4 | Excerpt | **Open by default** (S1 was collapsed) so the taste shows above the fold-flow. | `book-excerpt` |
| 5 | About / Who / FAQ / closing | Kept; FAQ verbatim. | `faq-item`, `book-prose` |
| 6 | Purchase CTAs | Real Mendele links; printed + electronic (olive secondary). | `cta-pill --primary/--secondary` |
| 7 | Gallery | One real photo + graceful gaps. | `book-gallery` |

## GCR flags
**None.** Stacked-cover bundle, meta strips, hero cover-split are atom recompositions.

## Per-route fan-out (S3)
- Detail mockup is **vekatavt**; clone for **kushi-blantis** (cover `kushi-blantis-cover.jpg`, Morning link) and
  **tsva-bechol** (cover `tsva-bechol-cover.jpg`, Mendele link). Swap copy from each route's content SSoT.
- Shop items: 5 products reuse the same card; fill 4:3 product photos when Eyal supplies them.
- Purchase = external links only (Morning / Mendele / Green-Invoice). No embedded checkout.
