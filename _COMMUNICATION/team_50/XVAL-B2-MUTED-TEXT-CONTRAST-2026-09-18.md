Independent check only. Nothing was changed. Full write-up: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/XVAL-B2-MUTED-CONTRAST-2026-09-18.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/XVAL-B2-MUTED-CONTRAST-2026-09-18.md).

All four pages loaded (50–87 KB HTML, `#main` present, viewport **1440×900**). Staging is already serving `chapters.css?ver=1.5.39` with `--muted:#786651`. Every row below is **4.5:1** (8.96–13.12 px, not large text). Foreground is computed colour after an 800 ms settle. Background is **painted pixels** of the element’s own box, not an ancestor `backgroundColor` walk.

## Fails

| Page | Selector | Sample | FG | Painted BG | How BG | Ratio |
|---|---|---|---|---|---|---:|
| `/treatment/` `/lessons/` | `.dd__item--active .dd__tag` | תהליך אישי / שלב 1 | `rgb(255,255,255)` | `rgb(181,102,61)` (`--terra`) | chip padding, one RGB | **4.2573 FAIL** |
| all four | `.foot__brand p` / `.foot__nap` / `.foot__tel` | tagline, address, 052-4822842 | `rgba(255,255,255,0.45)` | `rgb(12,8,4)` | painted footer | **4.4867 FAIL** |

The active chip is 8.96 px white on terracotta. The token change does not touch `--terra`. Footer 0.45 white over computed `#0E0905` is 4.4960 — still fail. Painted footer is darker than that token.

## Live `--muted` / `--ea-muted` that pass

| Page | Selector | Sample | FG | Painted BG | How BG | Ratio |
|---|---|---|---|---|---|---:|
| `/treatment/` | `.dd__tag` inactive ×2 | הקשבה פאסיבית, לימוד נגינה | white | `rgb(120,102,81)` `#786651` | chip padding, flat | **5.5003** |
| `/lessons/` | `.dd__tag` inactive ×4 | שלב 2–4, המשך התקדמות | white | same | same | **5.5003** |
| `/blog/` | `time.ea-blog-card__date` ×12 | every card date | `rgb(111,99,90)` `#6F635A` | `rgb(248,248,244)` | painted card | **5.4665** |
| `/blog/` | `a.ea-blog-filter__item` inactive ×6 | category chips | `#6F635A` | `rgb(252,252,248)` | painted ivory | **5.6589** |
| `/blog/` | `a.ea-blog-filter__item--active` | הכל | `rgb(164,78,43)` | `rgb(240,236,232)` | own fill | **4.8252** (thin) |
| `/blog/` | `span.ea-blog-card__cat` ×12 | כללי | `rgb(164,78,43)` | `rgb(248,248,244)` | painted card | **5.3264** |

## Other secondary text (not the muted token)

Testimonial `figcaption.tmq__n` on `/treatment/` and `/lessons/` is terracotta `rgb(154,79,43)` on the **white card**, not on the photo. Ratio **5.803**. The photo is a sibling above the name. Walking `backgroundColor` past that card, or sampling an 8 px ring that includes the portrait, is the gradient/photo trap — I did not use those numbers.

Footer `.foot__disc` / `.foot__base` at 0.62 alpha: **7.7585** on `/blog/` and `/shop/`.

## `/shop/`

No captions, no chips, no meta, no `.bookcard__meta`, no price-note. Footer only. `books-v2.css` is not loaded on any of these four pages.

Zero live nodes for `.cap`, `.feat__meta`, `.post__meta`, `.disc__t`, `.gfig__cap`, `.ea-section-label`. No author or reading-time on `/blog/`.

## Disagreements (not reconciled)

1. Team 10’s “not deployed, still `1.5.38` / `#8C775F`” is **false today**. Live is `1.5.39` / `#786651`.
2. Their inactive-chip **5.50** matches my **5.5003** — but that was an injected preview; it is now actually on the server.
3. Their `--muted` text **5.48 on ivory** is not a live instance on these four pages. I will not stamp that number here.
4. Blog dates are **5.4665** on the painted card, not 5.4902 from token `--ea-bg`.
5. Footer brand line is **4.4867** painted, not 4.4960.

Measured: chips, blog dates/filters/cats, testimonial names on the white card, footer brand/legal where screenshotted. Inferred: only `.foot__disc` on `/treatment/` and `/lessons/` (off-viewport; computed colour matches the `/shop/` screenshot). Could not measure: carousel caption `שירי אלקבץ` (off the overflow-hidden track). No scanner.
