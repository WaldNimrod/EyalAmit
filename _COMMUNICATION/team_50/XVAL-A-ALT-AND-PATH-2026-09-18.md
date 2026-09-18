Independent live check of the 12 staging pages. Nothing was changed. I did not run an accessibility scanner.

## What I ran

1. Serial Chrome CDP probe (headless, HTTP, `--ignore-certificate-errors` for this invalid-by-design staging host), one page at a time with a 2.5s pause:
   `node /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/probe-img-alt.mjs`
   For each page: require `outerHTML.length ≥ 4000`, a non-empty `<title>`, and a known element (`h1` / `.phero` / `#primary` / `main` / `.site-header`); set every `<img loading=eager>`; scroll the full height in 400px steps; wait until `complete`; `await img.decode()`; skip any image with `naturalWidth === 0` from “decoded” counts. All 12 pages loaded on attempt 1. `undecodedCount = 0` on every page. The 150-byte truncated-response trap did not fire in this run.
2. Live file bytes (not WordPress PHP): HTTP GET of the three photographs below, then `sha256`.
3. Repo reads only: `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php`, `inc/chapters/defaults/*.php`, `template-parts/chapters/parts/phero.php`. I did **not** execute those PHP functions inside WordPress. Any hash-map membership taken from the repo map is weaker than the live DOM.

Raw JSON: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/img-alt-live.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/img-alt-live.json)

## 1. Twelve pages — live `<img>` counts

**Measured** in the decoded DOM. `empty ∩ aria-hidden` means `alt=""` and an ancestor with `aria-hidden="true"`. No image on these 12 pages lacked the `alt` attribute.

| Page | HTML bytes | `<img>` | non-empty `alt` | `alt=""` | no `alt` attr | empty inside `aria-hidden` | empty **not** in `aria-hidden` | undecoded |
|---|---:|---:|---:|---:|---:|---:|---:|---:|
| `/` | 78062 | 39 | 38 | 1 | 0 | 1 | 0 | 0 |
| `/contact/` | 50527 | 2 | 1 | 1 | 0 | 1 | 0 | 0 |
| `/treatment/` | 86493 | 3 | 3 | 0 | 0 | 0 | 0 | 0 |
| `/accessibility/` | 51882 | 1 | 1 | 0 | 0 | 0 | 0 | 0 |
| `/faq/` | 158762 | 1 | 1 | 0 | 0 | 0 | 0 | 0 |
| `/shop/` | 50388 | 5 | 5 | 0 | 0 | 0 | 0 | 0 |
| `/blog/` | 66467 | 1 | 1 | 0 | 0 | 0 | 0 | 0 |
| `/en/` | 46558 | 1 | 1 | 0 | 0 | 0 | 0 | 0 |
| `/qr/` | 69757 | 0 | 0 | 0 | 0 | 0 | 0 | 0 |
| `/books/vekatavta/` | 89791 | 97 | 91 | 6 | 0 | 0 | 6 | 0 |
| `/books/tsva-bekahol/` | 72836 | 44 | 44 | 0 | 0 | 0 | 0 | 0 |
| `/books/kushi-blantis/` | 69234 | 22 | 22 | 0 | 0 | 0 | 0 | 0 |
| **12-page total** | — | **216** | **208** | **8** | **0** | **2** | **6** | **0** |

The two decorative empties (measured `src` + ancestor):

- `/` — `studio-interior.jpg` inside `.start__bg[aria-hidden="true"]`
- `/contact/` — `eyal-portrait-garden.jpg` inside `.ea-contact-portrait[aria-hidden="true"]`

The six content empties are named in §3.

## 2. Hash-map alternative text, not an explicit defaults value

**Inferred from repo, then checked live.** `ea_chapters_content_img_alt()` returns `$explicit` when non-empty; otherwise it hashes the theme file and looks up `ea_chapters_content_img_alt_map()`. `phero.php` always calls that helper.

On the 12 pages, the only content image whose defaults entry has **no** `'alt'` / `'media_alt'` and that still has a non-empty live `alt` is the `/accessibility/` hero.

`accessibility-defaults.php` phero:

- `'media' => 'assets/images/chapters/studio-interior.jpg'`
- **no `media_alt` key** (confirmed by search: zero hits in that file)

**Measured on live `/accessibility/`:** one `<img class="phero__media">`, decoded, `naturalWidth=4000`, `alt="פנים הסטודיו בפרדס חנה"`.

**Measured on the live file bytes:**  
`http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/assets/images/chapters/studio-interior.jpg`  
HTTP 200, 1 213 042 bytes, sha256 `b230febb8efecec75de4d85cbffef18993d73f9adcd266662e5f6b018332da72`.

That hash is in the repo map with exactly that Hebrew string. ACF overlay cannot supply `media_alt` here: accessibility is not on the seed-only exclusion list, but the overlay only writes keys already present on the seeded `phero` array, and `media_alt` is not one of them.

**I could not falsify the claim that this hero’s alternative text comes from the hash map and currently resolves on the live site.** The live string is that map value. It is not the longer explicit `studio_alt` used for the same file on the home page.

Same photograph, three live treatments (measured):

| Surface | `alt` | Origin (inferred) |
|---|---|---|
| `/accessibility/` hero | `פנים הסטודיו בפרדס חנה` | hash map (no explicit in defaults) |
| `/` studio section | `פנים הסטודיו — קיר הפסיפס והדיג׳רידו, פרדס חנה` | explicit `studio_alt` in `home-defaults.php`; that template does **not** call the hash helper |
| `/` “how to start” band | `""` | hardcoded `alt=""` inside `aria-hidden="true"` |

Other hash-map candidates on these 12 pages **did not** resolve to a description:

- `/books/vekatavta/` items `veka-54`, `veka-69`, `veka-76`, `veka-90`, `veka-94`, `veka-99` have no `'alt'` key in defaults. Live DOM: `alt=""`, decoded, **not** `aria-hidden`. Repo map does not contain their sha256 (local file hash; weaker than WP, but consistent with the empty live `alt`). Path resolution on live WP is working — if it were still broken, the accessibility hero would also be empty.

The mandate’s worked example is **no longer a hash-map-only live case**. `tsva-32.jpg` now has an explicit `'alt'` in `tsva-bekahol-defaults.php`. Live `/books/tsva-bekahol/`: `tsva-32.jpg` has `alt="אייל עמית מלמד נגינה בדיג'רידו"`. Live bytes of `tsva-32.jpg` and `eyal-teaching.jpg` are identical (both sha256 `bfb5f39f…`, 81 721 bytes). Because explicit wins, that live string does **not** prove hash matching.

`/blog/` and `/en/` heroes have explicit `media_alt` in their templates, so they are not hash-map cases. `/qr/` has no `<img>` at all.

## 3. Book gallery pages — distinct strings vs image count

**Measured** on the whole page, then on `.gallery` / `.gfig` only.

| Page | `<img>` on page | distinct non-empty `alt` strings | `alt=""` | gallery `<img>` | distinct non-empty gallery strings |
|---|---:|---:|---:|---:|---:|
| `/books/vekatavta/` | 97 | **91** | 6 | 95 | 89 |
| `/books/tsva-bekahol/` | 44 | **44** | 0 | 43 | 43 |
| `/books/kushi-blantis/` | 22 | **22** | 0 | 21 | 21 |

These three pages are **not** the “many images, one shared string” defect. Every non-empty alternative text on each page is unique.

`/books/vekatavta/` is a **missing-description** defect, not a collapse: 6 of 97 images have `alt=""`, none of those six sit in `aria-hidden`. Files (measured `src`): `veka-54.jpg`, `veka-69.jpg`, `veka-76.jpg`, `veka-90.jpg`, `veka-94.jpg`, `veka-99.jpg`.

On `/` only, two `<img>` share one non-empty string: both are `breath-practice.jpg` with `תרגול נשימה עם דיג׳רידו` (whom-grid + compare). That is the same file used twice with the same authored string, not a gallery of different photos under one label.

## Disagreements with repo claims (not reconciled)

- Mandate [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/MANDATE-S006-M10-IMAGE-MAP-AND-ALT-2026-09-18.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/MANDATE-S006-M10-IMAGE-MAP-AND-ALT-2026-09-18.md) gave **14 pages: 229 `<img>`, 65 real alt, 164 `alt=""`**. My 12-page live totals are **216 / 208 / 8**. Different page set and post-change site. I am not treating that mandate table as a current live measurement.
- DONE [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/DONE-S006-M10-IMAGE-MAP-AND-ALT-2026-09-18.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/DONE-S006-M10-IMAGE-MAP-AND-ALT-2026-09-18.md) said home `#peek` alts were “described, not applied”. Live `/` has **27** peek/gallery images, **27** distinct non-empty alts. Current `home-defaults.php` contains those strings. I did not investigate who wrote them.
- That same DONE’s live book counts (**tsva 44/44 empty 0, kushi 22/22 empty 0, vekatavta 97 with 6 empty named `veka-54/69/76/90/94/99`**) match what I measured today. Not falsified.
- `tsva-32.jpg` rendering `alt=""` (mandate worked example) is **false on the live site now**.

## Could not measure

- PHP path resolution **inside** WordPress (no WP bootstrap). Live DOM + live file hash are the evidence that the map hit for `studio-interior.jpg`.
- `/privacy/` and `/terms/` — same missing-`media_alt` + `studio-interior.jpg` pattern in defaults; not in the 12-page list.
- Whether the 6 empty vekatavta photographs *should* have text. I only measured that they do not.
- Screen-reader output. Not run.
- Automated scanners. Not run, and would not be cited as a pass.
