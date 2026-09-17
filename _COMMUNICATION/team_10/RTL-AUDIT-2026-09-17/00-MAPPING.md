# RTL Audit — Cross-Cutting Map

Synthesizes four independent facets into one route-by-route and dead-code view:
- `01-CSS-STATIC-AUDIT.md` — all 20 theme CSS files
- `02-PHP-TEMPLATES-AUDIT.md` — all template-parts + the testimonials data function
- `03-JS-INTERACTIVE-AUDIT.md` — all 14 theme JS files
- `04-LIVE-BROWSER-VERIFICATION.md` — direct empirical verification in the running browser

Each of the first three ran as an independent agent with no visibility into the others' work. Where two or three of them arrived at the same conclusion from different angles (grep vs. routing-trace vs. live DOM measurement), that is called out explicitly below as **cross-validated** — it's the strongest form of evidence in this audit, stronger than any single facet alone.

---

## 1. Route-by-route view (what a real visitor actually hits)

| Route(s) | Template chain | Known issues found here | Status |
|---|---|---|---|
| `/` (home) | `tpl-chapters-home.php` → `section-nav.php` + `section-hero.php` + `section-05-testimonials.php` | **Hero scroll-hint chevron points sideways, not down** (Facet 4, confirmed bug — every full hero on the site, so also affects any inner page using the same hero partial). Mobile nav drawer has no `[dir]` handling (Facet 1, confirmed live but cosmetic-only per Facet 4's verification). Testimonials carousel: **already fixed tonight.** | 1 new bug, 1 already-fixed |
| `/treatment/`, `/method/`, `/sound-healing/`, `/lessons/`, `/didgeridoos/` | `tpl-chapters-page.php` → `parts/testimonials.php` (carousel mode) | Testimonials carousel: **already fixed tonight**, verified live on all 5 by Facet 4's earlier round (this session, before this audit). Shares the sitewide hero/nav issues above wherever those pages use the same hero/nav partials. | Fixed / shared issues only |
| `/testimonials/` | `tpl-chapters-page.php` → `parts/testimonials.php` (**grid** mode, no carousel by design) | Grid variant shares the same `.tmq__q`/`.tmq__n`/`.tmq__nl` CSS classes as the fixed carousel — confirmed correct (border side, alignment, links) on all 46 cards, live-verified this session. | Clean |
| `/books/`, `/shop/`, `/qr/` (+ `/qr/qrN/` children) | `tpl-chapters-page.php` (types `muzza`/`shop`/`qr-hub`) → `parts/bookcard.php` | **HIGH — live, unmitigated `←` arrow** in the "to the book page" CTA hint, bidi-mirrors to point the wrong way on all three routes (Facet 2, Finding 2.1). Not yet fixed. | **1 new bug — highest priority in this audit** |
| `/contact/` | `parts/contact.php` | Phone number correctly `dir="ltr"` (Facet 2). Form fields use physical `text-align:right` from a shared stylesheet (Facet 1 + Facet 4) — not visibly broken today, no LTR contact form exists to break. | Low-priority latent risk only |
| `/faq/` | FAQ accordion (`<details>`/`<summary>`, `.dd__ic`) | Expand/collapse icon uses rotation, not mirroring — confirmed correct pattern (Facet 4). | Clean |
| `/mokesh-dahiman/` | `parts/mokesh-hero.php`, `parts/mokesh-portrait.php` | Latin caption correctly scoped `dir="ltr"` (Facet 2); one cosmetic `text-align:left`→`:start` nit inside that already-LTR scope. | Clean (cosmetic nit only) |
| `/vekatavta/`, `/kushi-blantis/`, `/tsva-bekahol/` | book-detail pages | `ea-book-purchase.js` clean (Facet 3). | Clean |
| Blog archive/single | `tpl-chapters-blog-*.php` | `ea-blog-share.js`'s off-screen clipboard textarea uses `style.left` — benign, symmetric-equivalent either direction (Facet 3). | Cosmetic nit only |
| `/en/` | `tpl-chapters-en.php` | **Architectural root cause, not a visible bug today.** See §2 — this page only works because of scattered inline `style="direction:ltr"` patches fighting an unscoped global rule. Currently has no form and only 6 links (Facet 4), so the fight is contained, but it's exactly the kind of thing that breaks the next time someone extends this page without knowing to add the same patch. | Works today, fragile |
| Every page, mobile viewport | `section-nav.php` mobile drawer | Confirmed live+working at rest (Facet 4); missing `[dir]`-aware slide animation (Facet 1). Separate, likely non-RTL bug found in the same drawer: submenu labels with `white-space:nowrap` clip at the screen edge instead of wrapping (Facet 4). | 1 cosmetic RTL gap + 1 unrelated layout bug |
| Every page | `#ea-scroll-progress` reading bar | Checked live per Facet 3's own request to Facet 1/4: fills correctly from the right (reading-start) edge as scroll progresses, thanks to `direction:rtl` on the bar element itself. | **Confirmed correct** |

---

## 2. The architectural root cause: why `/en/` is held together with patches

This is the single most important finding to come out of cross-referencing the facets, because no one facet saw the whole shape of it alone:

1. **Facet 1** found that `chapters.css:27` and `ea-atoms.css:59` both set a bare, unscoped `body{direction:rtl;text-align:right}` — a rule with no selector scoping it to Hebrew pages, so it applies to *every* page that loads these (very widely loaded) files, `/en/` included.
2. **Facet 1** separately found that `tpl-chapters-en.php` (the `/en/` template) carries repeated inline `style="direction:ltr;text-align:left"` patches on its `<main>` and on all 4 of its `<section>` elements, and that `style.css` has a dedicated `body.ea-lang-en` override rule to fight the same global rule at the body level.
3. **Facet 4**, working independently in the live browser, confirmed `/en/` renders correctly today (`dir="ltr"` on `<html>`, correct visual layout) — but also found it's a minimal 6-link, no-form landing page, meaning the patches have not yet been tested against anything more complex than plain text and links.

**Put together:** the site's CSS architecture assumes "RTL always," not "RTL by default, LTR by exception" the way the governing standard's own recommended architecture (`[dir="rtl"]` overrides layered on direction-neutral base rules, Standard §6.1) assumes. Today that gap is invisible because `/en/` is simple. It stops being invisible the day anyone adds a form, a card grid, or any component to `/en/` that wasn't hand-patched with its own inline `direction:ltr` override — it will silently inherit right-aligned, RTL-flowing styling, exactly the way the contact-form `text-align:right` rule would (Facet 1 + Facet 4's contact-form finding is the same root cause, just not yet triggered because no English form exists yet).

This is why it's called out as the top architectural recommendation rather than bundled into the CSS line-item list — fixing the ~53 individual property instances in Facet 1's report is mechanical; fixing *this* is the difference between "patches keep working by luck" and "the next English page just works."

---

## 3. Dead-code map — cross-validated across three independent facets

All three background agents, working from different file types with no knowledge of each other, independently reconstructed the same underlying fact: this theme runs two parallel systems (**Wave2**, older; **Chapters**, current and live-by-default), and a shared query-var mechanism (`ea_wave2_shell`) causes several Wave2 files to keep *loading* on every live page even though the markup they target no longer *renders* anywhere. Three agents converging on the identical mechanism from CSS, PHP routing, and JS enqueue analysis respectively is strong evidence this map is accurate, not a single agent's misreading.

**Confirmed DEAD (zero code path reaches a live visitor):**
| File | Type | Why |
|---|---|---|
| `template-parts/blocks/block-testimonials-carousel.php` | PHP | Only reachable via the frozen `tpl-home.php` rollback or a QA test page |
| `template-parts/blocks/block-testimonials-row.php` | PHP | Zero callers anywhere in the theme |
| `template-parts/chapters/parts/mag.php` | PHP | No defaults file places this part; no `get_template_part` call references it |
| `assets/js/ea-testimonials.js` | JS | Superseded predecessor of `ea-testi-mq.js`; its DOM target doesn't exist in the live render tree |
| `assets/js/books-reveal.js` | JS | Enqueue gate checks stale page slugs that no longer match live URLs |
| `assets/css/services.css`, `w2-04-service.css`, `w2-10-service.css`, `w2-14e-catalog.css` | CSS | No `wp_enqueue_style()` call exists anywhere for any of the four |

**Loaded on every live page, but functionally inert (ships bytes, executes, touches nothing real):**
| File | Type | Shared mechanism |
|---|---|---|
| `assets/js/ea-hero.js` | JS | `ea_wave2_shell` gate — queries `.ea-topnav__burger`/`.ea-hero__video`, which only exist in the dead `block-topnav.php`/`block-hero.php` |
| `assets/js/ea-mobile-nav.js` | JS | Same gate — queries `#ea-mnav-drawer` etc., same dead partial. **Notable: this file has the single best-executed `[dir]`-aware drawer logic in the whole theme, and it currently runs nowhere.** |
| `assets/css/testimonials-carousel.css` | CSS | Same gate — targets the dead `block-testimonials-carousel.php`/`-row.php` classes |
| `assets/css/ea-mobile-nav.css` | CSS | Same gate — targets the same dead nav markup. **Also notable: contains the reference `--ea-mnav-tx` custom-property pattern (Standard §6.2) that the live `chapters.css` drawer should be using instead of its current unhandled `translateX(100%)`.** |
| `assets/css/ea-mobile-variants.css` | CSS | Extends the above; nothing to target either |

**Likely dead (enqueue gate checks a superseded condition; not exhaustively proven):**
`home-front.css`, `w2-07-heritage.css` (CSS); `block-topnav.php`, `block-footer-social.php`, `block-contact-cta.php`, and their common ancestor `tpl-content.php` (PHP) — this last group's status hinges on one open question, see §4.

**The irony worth naming out loud:** the two files with the *most correct* RTL logic anywhere in this theme — `ea-mobile-nav.js`'s runtime `dir`-aware drawer math, and `ea-mobile-nav.css`'s `--ea-mnav-tx` custom property — are both dead weight today, while the *live* mobile drawer (`chapters.css`'s `.nav__l` + inline nav JS in `ea-chapters.js`) has none of that handling. If the live drawer is ever fixed, the fix already exists, unused, one file away.

---

## 4. One open question only a human can close

**Is `page-templates/tpl-content.php` live?** Facet 2 traced every code path into it and could not settle this from the repo alone — it depends on which page-template is actually assigned in the WordPress database, which static analysis can't see. This one fact determines the priority of two findings (the `↗`/`↙` unmitigated arrows in `block-topnav.php`/`block-contact-cta.php`) and whether three files become removal candidates.

**How to check (30 seconds):** visit `/about/` and `/press/` on the staging site, or look in wp-admin under Pages for a page still assigned the "tpl-content (Wave2)" template. If neither route resolves to real content, those two arrow findings drop to purely informational and the three files join the dead-code list in §3.

---

## 5. What every facet checked and found clean (confirmed-safe patterns, not just absence of a search)

Worth keeping on record so no one re-audits these:

- **SVG icon mirroring:** zero blanket mirroring transforms anywhere in the theme's PHP or CSS (Facet 2, supplementary CSS-wide grep). Every SVG in the theme (social logos, sound toggle, WhatsApp, avatar placeholder, link-out icon) is correctly never-mirrored per the standard's "universal convention" rule.
- **Phone numbers:** every `tel:` link in scope correctly wraps in `dir="ltr"` (Facet 2), applied consistently, not just once.
- **FAQ accordion expand icon:** rotation-based state change, direction-agnostic by construction (Facet 4, live-verified).
- **Nav dropdown caret (`▾`) and volume icon:** neither is in Unicode's bidi-mirroring set / neither carries a mirroring transform (Facet 2 + Facet 4, cross-checked two ways).
- **`#ea-scroll-progress` reading bar:** fills from the correct (right) edge in this RTL site (Facet 4, live-verified in response to a question Facet 3 raised).
- **`scrollLeft`, keyboard arrow-key navigation, swipe/touch gestures:** used nowhere in the theme's JS (Facet 3, confirmed by grep across all 14 files) — there is currently no live component in the highest-risk category for this class of bug.
- **`margin-left/right`, `padding-left/right`, `float:left/right`, the four `border-radius` corner longhands:** zero hits anywhere across all 20 CSS files (Facet 1).
