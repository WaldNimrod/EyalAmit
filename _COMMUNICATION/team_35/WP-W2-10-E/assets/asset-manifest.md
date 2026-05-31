# Asset Manifest — WP-W2-10-E (Commerce cluster) S1

team_35 · 2026-05-31. Declares REAL assets in hand vs. assets **Eyal must provide**. Drives the placeholder→real-asset swap path (AC-E3).

## Real content / assets ALREADY available (used verbatim in mockups)
| Asset | Source | Status |
|-------|--------|--------|
| Book titles, teasers, summaries, excerpts, FAQ, who-for, closing | `inc/wave2-w2-03-content.php` (verbatim, AC-05) + staging `/books/`, `/books/vekatavta` | ✅ in mockup |
| Bundle price (150 ש"ח / was 207) + copy | `tpl-books.php` block 09 | ✅ in mockup |
| 5 product titles, subtitles, feature/who copy, price notes | `inc/wave2-w2-05-content.php` + staging `/shop/` | ✅ in mockup |
| Book purchase link (וכתבת) | `https://www.mendele.co.il/product/vekatavta/` | ✅ wired |
| Bundle purchase link | `https://mrng.to/MTUiO3vkIg` (Morning/Green-Invoice) | ✅ wired |
| Brand colour / type / spacing tokens | D-14 `ea-tokens.css` (inlined verbatim) | ✅ |
| Hero background | D-14 gradient (`--ea-earth→--ea-chocolate→--ea-ink`) — asset-free | ✅ no image needed |

## Assets Eyal MUST still provide (placeholders in mockup)
| # | Asset needed | Where used | Placeholder shown |
|---|--------------|-----------|-------------------|
| A1 | **Cover art — צבע בכחול וזרוק לים** | books-archive card (5/7) | `[כריכת צבע בכחול וזרוק לים — נדרש מאייל]` |
| A2 | **Cover art — כושי בלאנטיס** | books-archive card | `[כריכת כושי בלאנטיס — נדרש מאייל]` |
| A3 | **Cover art — וכתבת** | books-archive card + detail gallery | `[כריכת וכתבת — נדרש מאייל]` |
| A4 | **Book gallery images** (cover + interior, ~5 per book) | book-detail gallery (16/7 lead + 4/3 grid) | grey `.ea-book-gallery__item` tiles |
| A5 | **Product photos — דיג'רידו** | shop card + shop-item gallery (4/3) | `[תמונת דיג'רידו — נדרש מאייל]` |
| A6 | **Product photos — תיקים** | shop card / item | `[תמונת תיק — נדרש מאייל]` |
| A7 | **Product photos — סטנדים לאחסון** | shop card / item | `[תמונת סטנד אחסון — נדרש מאייל]` |
| A8 | **Product photos — סטנד רצפתי** | shop card / item | `[תמונת סטנד רצפתי — נדרש מאייל]` |
| A9 | **Product photos — תיקון/חידוש** | shop card / item | `[תמונת תיקון — נדרש מאייל]` |
| A10 | **Green-Invoice / checkout links for SHOP products** | shop CTAs (currently → /contact fallback) | n/a — link, not image |
| A11 | Purchase links for the other two books (כושי בלאנטיס → "מנדלי"; צבע בכחול) | book-detail purchase CTAs | partial — וכתבת confirmed; verify other two |

## Swap path (verified pattern for AC-E3)
1. Cover/product placeholder = a fixed-ratio box (`5/7` books, `4/3` products, `16/7` gallery lead). Replace the placeholder `<div>` with an `<img src loading="lazy" width height alt>` of the **same** aspect ratio → zero layout shift (CLS-safe; supports perf ≥85).
2. CTA links: swap the `href` only; the `.ea-cta-pill` atom is unchanged.
3. No token/atom edits required for any swap — swap is content-layer only, executed at S3/team_10.
