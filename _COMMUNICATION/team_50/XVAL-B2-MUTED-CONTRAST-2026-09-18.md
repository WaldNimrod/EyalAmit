# XVAL-B2 — muted / secondary text contrast (independent)

Independent live check of `/treatment/` `/lessons/` `/blog/` `/shop/` only. Nothing was changed. No accessibility scanner.

Site: [http://eyalamit-co-il-2026.s887.upress.link](http://eyalamit-co-il-2026.s887.upress.link) (Chrome followed the host’s HTTPS redirect; staging TLS ignored by design).  
Repo: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` · child theme `ea-eyalamit`.

Raw evidence: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/b2-raw.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/b2-raw.json) · crops under [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/b2-shots/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/b2-shots/).

## Load / viewport (asserted before any ratio)

Pages probed **serially** with a pause. HTTP 200 on each. Rendered `documentElement.outerHTML` length and known elements:

| Page | HTML bytes | Title | Known element counts | Viewport |
|---|---:|---|---|---|
| `/treatment/` | 86,604 | טיפול בדיג'רידו… | `.dd__tag`=3, `#main`=1, `.phero`=1 | **1440×900**, DPR 1 |
| `/lessons/` | 72,288 | שיעורי דיג'רידו פרטיים… | `.dd__tag`=5, `#main`=1, `.phero`=1 | **1440×900** |
| `/blog/` | 66,543 | בלוג - eyal amit | `.ea-blog-card`/filter/`#main`=14 | **1440×900** |
| `/shop/` | 50,497 | עמוד קטלוג ראשי - eyal amit | `.bookcard`/`.phero`/`#main`=7 | **1440×900** |

None were the 150-byte truncated response. `chapters.css?ver=1.5.39`. Live `:root --muted` = `#786651`. `--ea-muted` = `#6F635A`. `books-v2.css` is **not** on any of these four pages.

## Method (measured unless marked inferred)

Chrome via puppeteer-core, **800 ms settle** after scroll-into-view, no CSS injection, no scanner. Foreground = `getComputedStyle.color` after settle. Background for the declared ratio = **painted pixels** of the element’s own box (side-padding 3×3 for opaque chips; inside-corners / card fill for transparent text). Full-viewport screenshot then crop — CDP clipped shots were returning “0 height” here even with clipH=41.

A walker that takes the first opaque ancestor `backgroundColor` is recorded only as a diagnostic. It is **not** the declared background.

Threshold: **4.5:1** for every instance below (8.96–13.12 px, weight 200–500). None meet the 24 px / 18.66 px-bold carve-out.

---

## Instances

### A. Tag chips — `.dd__tag` (the live `--muted` consumer on these pages)

Own `background-color` is opaque; own `background-image` is `none`. Padding pixels were a **single RGB** (nuniq=1). This is a solid fill, not a gradient. `.sec--dark` on `/lessons/` *does* have a gradient **behind** the chip; the text sits on the chip fill, so that ancestor gradient is not the effective background.

| Page | Selector | Text | FG | Painted BG | How BG | Ratio | vs 4.5:1 |
|---|---|---|---|---|---|---:|---|
| `/treatment/` | `section#compare … details.dd__item--active … span.dd__tag` | תהליך אישי | `rgb(255,255,255)` | `rgb(181,102,61)` (`--terra`) | painted side-padding, flat | **4.2573** | **FAIL** |
| `/treatment/` | `section#compare … details.dd__item:nth-of-type(2) … span.dd__tag` | הקשבה פאסיבית | `rgb(255,255,255)` | `rgb(120,102,81)` (`--muted` `#786651`) | painted side-padding, flat | **5.5003** | PASS |
| `/treatment/` | `section#compare … details.dd__item:nth-of-type(3) … span.dd__tag` | לימוד נגינה | same | same `#786651` | same | **5.5003** | PASS |
| `/lessons/` | `section.sec--dark … details.dd__item--active … span.dd__tag` | שלב 1 | `rgb(255,255,255)` | `rgb(181,102,61)` | painted side-padding, flat | **4.2573** | **FAIL** |
| `/lessons/` | same component, inactive items ×4 | שלב 2 / שלב 3 / שלב 4 / המשך התקדמות | `rgb(255,255,255)` | `rgb(120,102,81)` | painted side-padding, flat | **5.5003** | PASS |

Font: **8.96 px / weight 300**. Calculated-from-computed-own-fill equals the painted number (both 4.2573 / 5.5003).

### B. Testimonial name figcaptions — `figcaption.tmq__n` (not `--muted`)

These are the only `<figcaption>` nodes on `/treatment/` and `/lessons/`. Colour is `rgb(154,79,43)` (terracotta, **not** `--muted` `#786651`). The name sits on the **white card** under the portrait, not on the photograph. Sampling the 8 px *outside* ring **does** ingest the photo — that walk is the trap; I did not use it for the ratio.

| Page | n | Text samples | FG | Painted BG | How BG | Ratio | vs 4.5:1 |
|---|---:|---|---|---|---|---:|---|
| `/treatment/` | 11 measured | נוית צוף שטראוס, ענת קרמנר ויינשטיין, חיה עזריה, אלון גרזון רז, ירון סאנצ'ו גושן, אלכס פלופ, קרין טננצאפ, מירל רובין בהן, אסתי קרמנר, דן ארליכמן, אלכס פסטרנק | `rgb(154,79,43)` | `rgb(252,252,252)` | painted inside of the name row (white card) | **5.803** | PASS |
| `/lessons/` | 8 measured | נוית צוף שטראוס, רותי שליט, ענת קרמנר ויינשטיין, גלית מילר, אלכס פלופ, קרין טננצאפ, אלכס פסטרנק, אלון גרזון רז | same | same | same | **5.803** | PASS |

**Could not measure:** carousel track item `שירי אלקבץ` on both pages (`elementFromPoint` center off-viewport — overflow-hidden track). Same class / same computed colour as the measured siblings.

A terracotta decorative rule lives *in the same figcaption box* as the name. It is not behind the glyphs. Sibling slides that I could sample cleanly are all 5.803.

**No** `figcaption.gfig__cap` photo-on-image captions, **no** `.cap` nodes, on any of the four pages.

### C. Blog meta + category chips — `/blog/` only

No author, no reading-time node exists in this archive DOM. Meta is the date only.

| Selector | n | Text | FG | Painted BG | How BG | Ratio | vs 4.5:1 |
|---|---:|---|---|---|---|---:|---|
| `time.ea-blog-card__date` | **12** (every card: 12.01.2026, 12.08.2025, 04.08.2025, 31.07.2025, 05.05.2025, 14.04.2025, 10.02.2025, 09.02.2025, 11.09.2024, and three × 05.08.2024) | dates as listed | `rgb(111,99,90)` (`--ea-muted` `#6F635A`) | `rgb(248,248,244)` | painted ring around the date on the card | **5.4665** | PASS |
| `span.ea-blog-card__cat` | **12** (every card: `כללי`) | כללי | `rgb(164,78,43)` | `rgb(248,248,244)` | painted ring on the card | **5.3264** | PASS |
| `a.ea-blog-filter__item--active` | 1 | הכל | `rgb(164,78,43)` | `rgb(240,236,232)` (`--ea-bg-alt` fill) | painted own fill | **4.8252** | PASS (thin) |
| `a.ea-blog-filter__item` (inactive) | 6 | הוצאה לאור - ספרים; כללי; כתבה על תופעת יחיד מופע הסיפורים; סיפורים מהספר 'וכתבת'; ספרים בהוצאת מוזה; תופעת יחיד - מופע הסיפורים של אייל עמית | `rgb(111,99,90)` | `rgb(252,252,248)` | painted inside-corners on page ivory | **5.6589** | PASS |

Date font: **9.28 px / weight 200**. Filter: **12.48 px / 300**. Category: **9.28 px / 200**.

Using the token `--ea-bg` `#FAF8F5` instead of the painted card would print **5.4902** for the dates. That is **not** my number. The painted card is slightly darker than the token.

### D. Footer disclaimers / fine-print (all four pages, same CSS)

`.foot` computed background is solid `--dark` `#0E0905` = `rgb(14,9,5)`, `background-image: none`. Painted padding of the footer copy is **`rgb(12,8,4)`** — darker than the computed token. I declare the painted number.

| Selector | Text (same on all 4 pages) | FG | Painted BG | How BG | Ratio | vs 4.5:1 |
|---|---|---|---|---|---:|---|
| `.foot__brand p` (tagline) | המרכז לטיפול בנשימה באמצעות דיג׳רידו · פרדס חנה… | `rgba(255,255,255,0.45)` | `rgb(12,8,4)` | painted | **4.4867** | **FAIL** |
| `.foot__brand p.foot__nap` | רח' עמל 8 ב', פרדס חנה-כרכור | same 0.45 | same | painted | **4.4867** | **FAIL** |
| `.foot__brand p.foot__tel` | 052-4822842 | same 0.45 | same | painted | **4.4867** | **FAIL** |
| `.foot__disc` | המידע באתר זה אינו מהווה ייעוץ רפואי… | `rgba(255,255,255,0.62)` | `rgb(12,8,4)` | painted (measured on `/blog/` + `/shop/`) | **7.7585** | PASS |
| `.foot__base` | © 2026 אייל עמית · כל הזכויות שמורות · … | `rgba(255,255,255,0.62)` | `rgb(12,8,4)` | painted | **7.7585** | PASS |
| `.foot__base a` | הצהרת נגישות | `rgba(255,255,255,0.55)` | `rgb(12,8,4)` | painted | **6.2606** | PASS |
| `.foot__base a` | מדיניות פרטיות | same 0.55 | same | painted | **6.2606** | PASS |

If you composite 0.45 white over the **computed** `#0E0905` you get **4.4960** — still FAIL. That is the number team_10 quoted. Painted footer is not that token.

`.foot__disc` on `/treatment/` and `/lessons/`: `elementFromPoint` center was off-viewport after scroll (long paragraph). Computed colour matches the `/shop/` instance I did screenshot. I am **not** copying `/shop/`’s ratio onto those two pages as a measurement.

---

## `/shop/` in-page muted/secondary

Discovery found **zero** captions, **zero** chips, **zero** blog-style meta, **zero** `.bookcard__meta`, **zero** `.ea-product-price__note`, **zero** `.cap` / `.gfig__cap` / `.disc__t` on `/shop/`. The only secondary/muted-looking text on that page is the footer block in table D. That is measured (DOM query), not inferred from the PHP defaults file.

`books-v2.css` is not loaded here, so the `--eyal-muted` → `--ea-muted` edit cannot affect these four pages.

---

## Dead selectors the token-fix write-up named as “the” muted text

On all four pages, `querySelectorAll` count **0**: `.cap`, `.feat__meta`, `.post__meta`, `.disc__t`, `.ea-section-label`, `.ea-book-gallery-placeholder__*`, `.gfig__cap`. Agree with team_10 that those *rules* are dead here. The live `--muted` use on this scope is the **inactive `.dd__tag` fill**, not caption text.

---

## Disagreements with repo claims

I am not reconciling toward the repo.

1. **Deploy status.** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/03-DONE-CONTRAST-TOKENS.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/03-DONE-CONTRAST-TOKENS.md) §9 says staging still serves `chapters.css?ver=1.5.38` with `--muted:#8C775F`. **Live today is `1.5.39` and `--muted:#786651`.** Inactive chips read `rgb(120,102,81)`, not `rgb(140,119,95)`.
2. **Inactive `.dd__tag` 5.50:1.** Their post-fix number. Mine is **5.5003**. Match, now actually on the server (they produced theirs by injecting CSS).
3. **Active `.dd__tag` 4.26:1 FAIL.** Their flag. Mine is **4.2573 FAIL**. Still live. Token change does not touch `--terra`.
4. **`--muted` text 5.48:1 on ivory.** I found **no `--muted` text colour** on these four pages. That pair is not a live instance in this scope. I will not rubber-stamp 5.48 from a page that is not in the brief (`/eyal-amit/mokesh-dahiman/`).
5. **Blog dates 5.49:1** if you use token `--ea-bg`. Painted card is `rgb(248,248,244)` → **5.4665**. Token arithmetic overstates it.
6. **`.foot__brand p` 4.4960.** Calculated over computed `--dark`: yes. Painted: **4.4867** on `rgb(12,8,4)`. Both FAIL. I will not adopt 4.496 as the painted-pixel number.

---

## Could not measure / did not claim

- Carousel figcaption `שירי אלקבץ` on `/treatment/` and `/lessons/` — off the overflow-hidden track.
- `.foot__disc` on `/treatment/` and `/lessons/` — center not in the 1440×900 viewport after scroll. Same computed style as the `/shop/` PASS instance; that is **inferred**, not measured.
- Photo captions that sit *on* a photograph (`.gfig__cap` gradient-over-image): **absent** from these four pages. Nothing to call INDETERMINATE because nothing rendered.
- Author / reading-time: **absent** from `/blog/` archive cards.
- I did not run axe/Lighthouse. A scanner reporting zero violations would not be evidence here.

Measured: chip fills, blog dates/filters/cats, testimonial names on the white card, footer brand/legal on `/blog/`+`/shop/` (and brand/legal on the other two pages except `.foot__disc`).  
Inferred: only the two `.foot__disc` rows on `/treatment/` and `/lessons/` (computed match to a measured sibling page).
