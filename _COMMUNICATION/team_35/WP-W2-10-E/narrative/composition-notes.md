# Composition Notes — WP-W2-10-E (Commerce cluster) S1

team_35 (Design Studio, claude-design) · 2026-05-31 · composition-only · cites D-14 atom IDs (no new atoms/tokens; AC-U1).

D-14 SSoT: `site/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css` + `ea-atoms.css`.

---

## 1. Two archetypes, one DNA

The cluster has exactly two layout archetypes. Both are built **entirely** from existing D-14 atoms — nothing new was invented.

| Archetype | Mockup | Drives routes |
|-----------|--------|---------------|
| **Card-archive** | `commerce-books-archive.html` | `/books` (tpl-books.php) + `/shop` (tpl-shop-archive.php) |
| **Detail** | `commerce-book-detail.html` | book-detail (tpl-book-detail.php) + shop-item (tpl-shop-item.php) |

---

## 2. Card-archive archetype (books + shop reuse)

Block order top→bottom, mirroring the deployed `tpl-books.php` slot-map:

1. **Hero** — `atom-structure-book-hero` (`.ea-book-hero` + `.ea-book-hero__overlay` + `.ea-book-hero__title/__subtitle`). Gradient background (`--ea-earth → --ea-chocolate → --ea-ink`) is the D-14 asset-free hero — no image needed, so this block is NOT asset-gated. Single H1.
2. **Intro / Why-here** — `.ea-section--prose` and `.ea-section--prose.ea-section--alt` alternating bg (`--ea-bg` / `--ea-bg-alt`) for vertical rhythm. Heading = `.ea-section__heading` (h2, weight 200, 2rem).
3. **Card grid** — `.ea-books-section` → `.ea-books-grid` (3-col → 2-col @1023 → 1-col @639). Each card = **`atom-content-book-card`** (`.ea-book-card` › `.ea-book-card__link` › `.ea-book-card__cover-placeholder` + `.ea-book-card__body` › `.ea-book-card__title` h3 + `.ea-book-card__teaser`). Whole card is one focusable link with `aria-label`; hover = `scale(1.02)` + soft shadow (already in atom).
4. **Bundle** — `.ea-bundle` (`__accent`, `__title`, `__price` with `<strong>`/`<del>`, `__desc`, `__note`). The hero's ghost CTA anchors to `#books-bundle`.

### How /shop reuses the books DNA
The shop archive is the **same `.ea-books-grid` + `.ea-book-card`** scaffold, with three composition deltas — all expressed with **existing tokens**, no new atom:
- Cover placeholder aspect ratio `4/3` (product) instead of `5/7` (book spine). This is a per-instance aspect-ratio on the same placeholder pattern (`.ea-book-card__cover-placeholder` value `--ea-bg-alt` + `--ea-line` border, identical to the book atom). I named the demo class `.ea-shop-card__cover-placeholder` for clarity but it is byte-for-byte the book placeholder with one ratio override — flag for team_10 to decide whether to fold into a modifier at S3.
- A price/availability micro-line `.ea-shop-card__price` (color `--ea-terracotta`, 0.78rem) — re-using the book-card teaser type scale; candidate for a shared `--price` element at S3.
- CTA target = `/contact` (no fixed online price), per the W2-05 B02 CTA matrix — see §4.

> **Composition decision:** keep books and shop on the *same* grid atom so Eyal signs off one card rhythm that serves both catalogues. The only honest difference is image proportion + a price line; everything else (gap `--ea-space-5`, breakpoints, hover) is identical.

---

## 3. Detail archetype (book-detail; shop-item reuse)

Block order mirrors the 14-block `tpl-book-detail.php` contract (trimmed to the signed-off essentials for S1; press/related folded out where empty):

1. **Hero** — `.ea-book-hero` with `.ea-book-hero__back` ("← מוזה הוצאה לאור"), H1 title, multi-line `.ea-book-hero__subtitle`, and the **purchase CTA** (`.ea-cta-pill--ghost-white` on the dark hero).
2. **Summary (תקציר)** — `.ea-section` + `.ea-book-prose` (verbatim copy, `--ea-text-body`, `<strong>` → `--ea-chocolate`).
3. **Excerpt (קטע מתוך)** — `atom .ea-book-excerpt` `<details>` accordion, default closed; body uses `.ea-book-prose--preserve` (`white-space:pre-line`) to keep the author's manual line breaks.
4. **About the book (על הספר)** — `.ea-section` prose.
5. **Gallery** — `atom .ea-book-gallery` grey placeholder grid (`__grid` with first item full-bleed 16/7, rest 4/3). **Asset-gated** — see manifest.
6. **Purchase (רכישה)** — `.ea-section` + prose + `.ea-book-purchase-cta` → `.ea-cta-pill--primary` (the load-bearing buy button).
7. **Who it's for (למי מתאים)** — `.ea-section--alt` prose.
8. **Intermediate CTA** — `.ea-section--cta` (centered) + `.ea-book-midcta__text` + repeat purchase pill.
9. **FAQ** — `atom .ea-faq-item` `<details>` list (book-specific Q&A, real content).
10. **Closing CTA** — `.ea-section--closing` centered prose + final purchase pill.

### How shop-item reuses book-detail DNA
shop-item (`/didgeridoos` etc.) maps onto the **same** vertical: hero → what-it-is (= summary) → features/who-it's-for (= prose sections) → FAQ (`.ea-faq-item`) → price block → purchase/contact CTA → gallery (`.ea-book-gallery`) → closing. Same atoms, different headings. The single structural difference: shop-item's CTA is **contact-based** (`.ea-cta-pill--secondary` olive, → `/contact`) because products are priced per-fit, whereas books carry a real external buy link.

---

## 4. Purchase-CTA / Green-Invoice integration (composition view)
- **Books** have confirmed external purchase links in the content SSoT: bundle → `https://mrng.to/MTUiO3vkIg` (Morning/Green-Invoice), וכתבת → `https://www.mendele.co.il/product/vekatavta/`. These are wired live in the mockups (`.ea-cta-pill--primary`, `target=_blank rel=noopener`).
- **Shop products** have **no** online price/checkout. Per the W2-05 B02 CTA matrix the CTA is `/contact` ("לתיאום…"), rendered as the existing pill. When/if Eyal supplies Green-Invoice product links, swap the `href` only — atom unchanged (AC-E4).

---

## 5. RTL / a11y composition guarantees
- `dir="rtl" lang="he"` on `<html>`; body `text-align:right` (D-14 base).
- Single H1 per page (in hero); section headings are H2, card titles H3 — clean outline.
- `.ea-skiplink` first focusable; `#main` target present.
- Every card = one link with `aria-label`; CTAs have visible `:focus-visible` outline (`--ea-terracotta`, offset). Contrast uses `--ea-text-body #5A3826` / `--ea-muted #6F635A` (the AA-corrected D-14 values), never the retired light greys.
- Accordions use native `<details>`/`<summary>` (keyboard + SR free).
- Placeholders are `aria-hidden` decorative or carry descriptive text; they do not pollute the reading order.
