# DONE — CTA band as three equal thirds — 2026-09-26

Builder report. Team 90 re-measures. Not pushed.

Staging: `http://eyalamit-co-il-2026.s887.upress.link` (plain HTTP). Theme **1.5.138**. Commit `325801b` (`Lay every CTA band out as three equal columns…`). Two later commits on `main` (`f592b5a`, `cd78f38`) do not touch the theme files; `git diff 325801b HEAD` on `cta.php`, `chapters.css`, `style.css`, `ea-tokens.css`, and `contact.php` is empty. Deploy:

- `2026-09-26T19:13:15+03:00 · 325801b1fc28 · main · theme 1.5.138 · 725 files`

in [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/DEPLOY-LOG.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/DEPLOY-LOG.md).

`style.css` Version was **1.5.137** before the bump. Live `chapters.css?ver=1.5.138` on every page below, including all 136 sitemap URLs.

Viewport 1440×900 unless noted, deviceScaleFactor 1. Chrome: `/Users/nimrod/.cache/puppeteer/chrome-headless-shell/mac_arm-149.0.7827.22/chrome-headless-shell-mac-arm64/chrome-headless-shell`, found with the same `find … chrome-headless-shell | sort -V | tail -1` logic as [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs). That file was not modified. Cookie choice `ea_cookie_cmp=reject` was set before navigation; if `<dialog id="ea-cookie-notice">` was still open it was closed. Each band was scrolled to center. Geometry was read only after every `.r` inside it carried `.in` and its computed transform was `none`, then two animation frames. Text boxes are the union of `Range.getClientRects()` on text nodes. Signed gap is `logo.left − ink.right` (positive = ink ends before the logo starts). A 502 was not recorded; none occurred (0 retries).

Live markup on 1.5.137, before this change, on `/method/`: the logo `span` was a sibling **before** `div.cta-band__in`. After 1.5.138 the logo is the first child of `.cta-band__in` on all 29 bands (`logoInside` true, `logoFirst` true).

## What shipped

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/cta.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/cta.php) — the logo span moved inside `.cta-band__in`, still `aria-hidden="true"`.

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/chapters.css](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/chapters.css) — `.cta-band--row .cta-band__in` is `display:grid` with `direction:ltr` and `grid-template-columns:repeat(3,minmax(0,1fr))`, `column-gap:24px`. Column 3 (right) is the logo, column 2 the text (`direction:rtl; text-align:right`), column 1 (left) the button (`justify-content:center`). The old padding `:has` rules and `body.page-id-73` are deleted. The logo rule is scoped to `.cta-band--row .cta-band__logo.cta-band__logo--side`, so the absolute `.cta-band__logo--side` rule that `/contact/` uses is unchanged. Logo computed on every band: `position:relative`, `opacity:0.26`, `filter:invert(1) sepia(0.5) brightness(1.3)`, `aria-hidden=true`, `tabIndex=-1`.

## Desktop — 29 bands, 19 pages, 1440×900

Inner track on every band: left **160**, right **1280**, width **1120**. Three tracks of **357.3** plus two **24px** gaps.

| Track | x |
|---|---|
| Left third (button) | 160 – 517.3 |
| Middle third (text) | 541.3 – 898.7 |
| Right third (logo) | 922.7 – 1280 |

Every logo box is **922.7–1280 × 357.3** wide (the right track only). Every text box and every button column is **357.3** wide on its own track. `documentElement.scrollWidth − clientWidth` is **0** on all 19. `nav#nav` is 1 and `footer` is 1 on all 19.

### Signed text/logo gap

`+24` means the ink's right edge is the middle track's right edge (898.7) and the logo starts at 922.7. `inkRightDelta` (`txt.right − ink.right`) is **0** on every band that has text. `textHitsLogo` is false on all 29. Button-only bands have no ink; the gap column is the button-to-logo clearance (`logo.left − btn.right`), and `btnHitsLogo` is false on all 29. `btnCenterDelta` (button-union center minus left-third center) is **0** on all 29. Left-third center is **338.65**.

| URL | Band | HTTP | Ink gap | Button gap | Ink right Δ | Button center Δ |
|---|---|---|---|---|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/ | 0 | 200 | **+24** | +483.4 | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/lessons/ | 0 | 200 | **+24** | +486.4 | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/testimonials/ | 0 | 200 | **+24** | +511.2 | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/method/ | 0 | 200 | **+24** | +483.4 | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/repair/ | 0 | 200 | **+24** | +489.6 | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/sound-healing/ | 0 | 200 | **+24** | +514.8 | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/learning/ | 0 | 200 | **+24** | +483.4 | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/learning/lectures/ | 0 | 200 | **+24** | +482.6 | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/learning/workshops/ | 0 | 200 | **+24** | +488.2 | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/ | 0 | 200 | **+24** | +498.7 | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/ | 1 | 200 | **+24** | +476.4 | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/ | 1 | 200 | **+24** | +476.4 | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/ | 0, 2 | 200 | no text | +504.2 | — | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/ | 0 | 200 | no text | +504.2 | — | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/ | 2 | 200 | no text | +478.2 | — | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/didgeridoos/ | 0 | 200 | no text | +459.0 | — | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/didgeridoos/ | 1 | 200 | no text | +475.4 | — | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/didgeridoos/ | 2 | 200 | no text | +471.9 | — | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/bags/ | 0 | 200 | no text | +445.7 | — | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/stands-storage/ | 0 | 200 | no text | +501.8 | — | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/stand-floor/ | 0 | 200 | no text | +511.2 | — | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/books/ | 0 | 200 | no text | +469.7 | — | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | 0, 1, 2 | 200 | no text | +504.2 | — | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/snoring-sleep-apnea/ | 0, 1, 2 | 200 | no text | +499.6 | — | 0 |

12 bands have text, all at ink gap **+24**. 17 bands are button-only (empty middle third still 357.3 wide). 12+17=29.

### Text in the middle third, right edge flush — three pages

| URL | Middle third | Ink union | Ink inside third | Right Δ |
|---|---|---|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/ | 541.3–898.7 | 553.4–898.7 (w 345.2) | yes | **0** |
| http://eyalamit-co-il-2026.s887.upress.link/testimonials/ | 541.3–898.7 | 655.2–898.7 (w 243.4) | yes | **0** |
| http://eyalamit-co-il-2026.s887.upress.link/method/ | 541.3–898.7 | 562.1–898.7 (w 336.6) | yes | **0** |

### Button in the left third, centred — three pages

Left third is 160–517.3, center **338.65**.

| URL | Button box | Center | Δ vs 338.65 |
|---|---|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/ | 238.0–439.3 (w 201.4) | 338.65 | **0** |
| http://eyalamit-co-il-2026.s887.upress.link/testimonials/ | 265.8–411.5 (w 145.7) | 338.65 | **0** |
| http://eyalamit-co-il-2026.s887.upress.link/bags/ | 200.4–477.0 (w 276.6) | 338.7 | **0** |

`/bags/` has no text. Its empty `.cta-band__txt` is still the middle track (541.3–898.7, height 0). The logo is the right track.

## Mobile — stacked below 880px

880px is the breakpoint already used beside this block (`.cta-rings`) and for the other multi-column chapter layouts. Below it the grid is one column, in this order:

1. Logo, `width:min(140px,36vw)`, centred (at 390: x **125–265**, 140×140, center **195** = viewport center).
2. Text, full content width, still right-aligned (`ink.right` equals the text box right).
3. Button, centred in that full width.

A 140px mark keeps a readable line (350px at 390) and leaves the button in normal flow under the text. The logo stays `aria-hidden`. Side padding of the band is 20px at this breakpoint. Measured at **390×844**. `scrollWidth − clientWidth` is **0** on all five. Ink and button sit inside 0–390. `textHitsLogo` is false. The stacked logo and the full-width text share x, so `logo.left − ink.right` is **−245**; they are separated vertically by the **22px** row-gap (`text.top − logo.bottom`).

| URL | Logo top | Text top | Button box | Ink right | Overflow |
|---|---|---|---|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/ | 262.9 | 424.9 | 94.3–295.7 | 370 | **0** |
| http://eyalamit-co-il-2026.s887.upress.link/lessons/ | 275.4 | 437.4 | 97.4–292.6 | 370 | **0** |
| http://eyalamit-co-il-2026.s887.upress.link/testimonials/ | 269.0 | 431.0 | 122.2–267.8 | 370 | **0** |
| http://eyalamit-co-il-2026.s887.upress.link/bags/ | 302.0 | (no ink) | 56.7–333.3 | — | **0** |
| http://eyalamit-co-il-2026.s887.upress.link/method/ | 189.4 | 351.4 | 94.3–295.7 | 370 | **0** |

`/bags/` button center at 390 is (56.7+333.3)/2 = **195**. Home button center is (94.3+295.7)/2 = **195**.

## Per-page rules

```
rg -n "page-id-73|cta-band__txt:has|body\.page-id" site/wp-content/themes/ea-eyalamit
```

No matches. `body.page-id` does not occur in `chapters.css`.

## Regression

`page-sitemap.xml` + `post-sitemap.xml` = **136** unique locs. Concurrency 3. Redirects not followed. No 502.

| Check | Result |
|---|---|
| HTTP 200 | **136 / 136** |
| `nav#nav` | **1** on 136 / 136 |
| `<footer` | **1** on 136 / 136 |
| `Fatal error`, `Parse error`, `Uncaught `, `Warning: `, `Notice: `, `Deprecated: `, `There has been a critical error` | **0** |
| `chapters.css?ver=` | **1.5.138** on 136 / 136 |
| Pages whose HTML contains `cta-band--row` | **19**, same set as the table above (band counts 1 or 3, total 29) |

`/contact/` is not in that 19. Its markup does not contain `cta-band--row`.

## Locked files

sha256, before and after, identical:

| File | sha256 |
|---|---|
| [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css) | `0c4f825befdd09e744d2a8c541f31cb009e7e095e8bf2d78413653fb6ed150b4` |
| [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md) | `259cf4e0b197aaa8faa10721d0f389758c77b3a8dd6ca21ae5d69677b116952d` |
| [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/contact.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/contact.php) | `ffa8a34c6d41fa2844572b50e3da5f7eecb7945769860e395a6cc4e29ae9abed` |

## /contact/ — same boxes

Both passes at 1440×900, coordinates relative to `[data-block="contact-cta"]` after scroll-into-view, `.in`, and transform `none`. Section height **485.9** both times. Logo stays absolute, 440×440, `right:-40px`, `top:242.922px`, opacity **0.16**, filter `invert(1) sepia(0.5) brightness(1.3)`, transform `matrix(1, 0, 0, 1, 0, -220)`.

| Box | Before 1.5.137 | After 1.5.138 |
|---|---|---|
| Section | 0,0 1440×485.9 | 0,0 1440×485.9 |
| Logo | 1040, 22.9, 440×440 | 1040, 22.9, 440×440 |
| Heading box | 240, 88, 960×29.6 | 240, 88, 960×29.6 |
| Heading ink | 970–1200, y 89, w 230 | 970–1200, y 89, w 230 |
| Paragraph box | 240, 141.6, 960×32.3 | 240, 141.6, 960×32.3 |
| Paragraph ink | 654.1–1200, y 147.6, w 545.9 | 654.1–1200, y 147.6, w 545.9 |
| WhatsApp control | 999.5, 213.7, 200.9×49.2 | 999.5, 213.8, 200.9×49.2 |
| Control ink | 1049.4–1150.6, w 101.2 | 1049.4–1150.6, w 101.2 |
| Points list | 240, 286.8, 960×111 | 240, 286.8, 960×111 |

The control's computed scale was `1.00463` before and `1.00467` after (same capture method, different frame). The box above is the layout box.

Next measurement: Team 90.
