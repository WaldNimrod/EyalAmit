---
id: XVAL_TYPOGRAPHY_2026-09-19
schema_version: aos_v1_team_messaging
type: CROSS-ENGINE VALIDATION RESULT (team_50 line → team_100)
from: team_50 (cross-engine line, cursor-grok-4.6-high)
to: team_100
cc: [team_00, team_10]
date: 2026-09-19
theme_under_test: 1.5.66 (live at start and at end of run — no drift)
prompt: tmp/qa/xval-2026-09-19/T-typography.txt
coverage: 157/157 URLs, 14,698 text elements, plus an explicit button/input/select/textarea pass
verdict: T1 T2 T4 T5 FALSIFIED · T3 CONFIRMED
status: ACTED ON at 1.5.68 — see _COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md section 4
---

> Builder engine was Claude Opus 5 (team_100). Validator engine is Grok — Iron Rule #1 held
> at engine level, not only at role level. The line was given the claims and the traps, never
> the conclusions, and was told to falsify rather than confirm. Raw output follows verbatim.

Independent verification only — I will try to falsify T1–T5, not confirm them. First I’ll lock the live theme version, read the typography canon, and pull the 157-URL set so the scan is not limited to the builder’s 28 pages.Start version is **1.5.66**. Next I’ll read the 157-URL sitemap, the original deviations, live CSS, and the existing scan harness so I can measure independently instead of reusing the builder’s 28-page set.I’ll write my own scanner rather than reuse the builder’s, then audit live CSS and computed values in parallel. First I’m locating Chrome, the prior scanner, and the child-theme sheets.Source already shows a possible T5 hole: a `24px` size in `chapters.css` that is not in the canon exemptions. I’ll inspect that, button `font-family` (buttons do not inherit), live cascade order, and then run an independent full-site scan.Local theme is already 1.5.67 while staging is still 1.5.66. I’ll audit the live cascade and CSS, then run an independent 157-URL scan instead of the builder’s 28-page recheck.T5 already has a live hit: `.ea-lb__x` is `font-size:24px` and is not in canon §6. Next I’ll scan all 157 URLs independently and check the cascade claim on `/services/`.T1 is already broken on `/services/`: two `button.menu-toggle` elements still compute `-apple-system`, because GeneratePress targets `button` directly. I’ll rerun the full 157-URL scan in the backgrounded Shell tool and add a mobile button check.Independent verification, 157/157 URLs, theme **1.5.66** at start and end. I did not reuse the builder’s 28-page recheck. No fixes.

---

## Verdicts

| Claim | Verdict |
|---|---|
| **T1** — zero `-apple-system` on the six pages; fix is `html body` | **FALSIFIED** |
| **T2** — remaining family deviations are exactly Rubik / Frank / Arial | **FALSIFIED** |
| **T3** — zero weight deviations | **CONFIRMED** |
| **T4** — two size deviations only | **FALSIFIED** |
| **T5** — no live child-theme off-scale `font-size` outside canon §6 | **FALSIFIED** |

Live `ea-tokens.css?ver=` was **1.5.66** on the first homepage fetch and **1.5.66** on the last. Every one of the 157 scanned pages also reported `tokenVer=1.5.66`. Local `style.css` is already 1.5.67; staging did not move during this run.

Pages: **157/157** from `_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv`, HTTP, 1440×900, length > 0 + zero-rect guard, plus an explicit `button/input/select/textarea` pass. 0 short responses. 14,698 text elements. No TOC on `/snoring-sleep-apnea/`.

---

## T1 — FALSIFIED

The **54 named chrome rows are gone** on those six pages. Skip-link, brand, menu `<a>`, footer `site-info`, WhatsApp float now compute `Heebo, -apple-system, Arial, sans-serif` (first family **Heebo**). Non-button family leftovers on those pages are Rubik only.

**Zero `-apple-system` is false.** Each of the six pages still has two `button.menu-toggle` (“תפריט”) computing `-apple-system`. At 1440 they are `display:none`. At **390×844 they are visible** (55×60). Source: GeneratePress `main.min.css`:

`body,button,input,select,textarea{font-family:-apple-system,...}`

`html body` (0,0,2) wins for **body** and inheriting `<a>`/`<div>`. It does not beat a same-element `button` rule. Child-theme `body button` sets **size only**, not family.

### The “why `html body`” reasoning

Partially true, oversold as complete.

- Load order on `/services/`: tokens **0**, GP **2**. GP is later. Confirmed.
- GP’s body selector is 0,0,1. Matched styles on `body`: both `body, button, input, select, textarea` and `html body`. Computed body family is Heebo.
- Injected a late `body{font-family:"PROBE-PLAIN-BODY"}`: body stayed Heebo. A plain `body` rule in tokens **would be inert**. That part holds.
- Injected a late `html body`: it overrode. Specificity 0,0,2 is doing the work they claim.

What they omitted: GP also targets `button`/`input`/`select`/`textarea` directly. `html body` cannot fix those. That is why T1’s “zero” fails, and why trap #4 (`<button>` does not inherit `font-family`) still has live instances after 1.5.65/1.5.66.

The six pages still **do not enqueue Heebo** (only Rubik). Computed first name is Heebo because `--ea-font` lists it first. On a machine without a local Heebo face, painted glyphs can still be the fallback. `document.fonts.check('16px Heebo')` was true here; this Mac is not a clean visitor.

---

## T2 — FALSIFIED

Frank **22** and Arial **10** match the claim. Rubik is **66 distinct nodes** vs their **26**: same footer-legal links, counted separately because I kept the fourth class (`menu-item-ID`). Collapse that the way they did and you get ~26. The category is real; the “26” is a selector-collapse artifact.

**There is a fourth family: `-apple-system`, 224 rows, not in T2.** It is site-wide, including pages that were clean on 2026-09-18. Their 28-page recheck could not see it: those nodes are buttons/inputs without direct text, or `display:none` at 1440.

| Kind | Rows | Where | Visible? |
|---|---|---|---|
| `button.nav__burger` | 150 | Chapters shell (home, QR, posts, shop, …) | Hidden at 1440; **visible at 390** (42×42) |
| `button.ea-qr-facade` | 42 | QR video play overlay | **Visible at desktop** (no `font-family` on the control; play mark is `::before`) |
| `button.menu-toggle` | 16 | Six GP pages + `/about/` + `/press/` | Hidden at 1440; **visible at 390** |
| `button.ea-mnav-*` | 10 | `/about/`, `/press/` Wave2 mobile nav | Hidden at 1440; family rule is inside `@media (max-width:1023px)` |
| Mailchimp `#mce-EMAIL` / `#mc-embedded-subscribe` | 2 | `/100-100-100-תודה/` | Form controls, GP `input`/`button` |
| Guest-form `input` | 2 | `/ביקורות-גולשים-אודות-עכשיו-מופע-הסיפ/` | Same |
| Hidden CF7 inputs | 2 | `/contact/` | `display:none` |

Suez One: **0** rendered with direct text (same gap the 2026-09-18 scan had). Not a fourth live family in this pass.

---

## T3 — CONFIRMED

**0** weight deviations on 157 pages. Every measured `font-weight` was in 100–800.

---

## T4 — FALSIFIED

Found the two they named:

- `/contact/` CF7 row `label` at `font-size:0` (canon §6 exemption). I also picked up a child `br` and wrap at 0; same rule.
- Facebook-paste `<strong>` at **16px** on the “תלמידים ומטופלים ממליצים” post (0.7px over `--fs-sm` 15.3).

**Third, not exempt:** `/snoring-sleep-apnea/` `dialog.ea-lb > button.ea-lb__x` computes **24px** (nearest `--fs-h2` 24.65, gap 0.65 > 0.6). Closed dialog, so a visibility-only scan misses it. The declaration is live in `chapters.css` at 1.5.66.

`button.testi-mq__btn` at 25.6px (`1.6rem`) appeared on 11 pages. That **is** in canon §6. I am not counting it against T4.

---

## T5 — FALSIFIED

Live child-theme sheets (fetched from staging, not the local 1.5.67 tree). Off-token `font-size` that is **not** in canon §6:

- `.ea-lb__x { font-size:24px }` in live `chapters.css?ver=1.5.66` — added with the 1.5.64 lightbox / 1.5.66 button-family fix. Not annotated as an exemption.

§6 items that **are** present and annotated: `.nav__caret` `.6em`, `.testi-mq__btn` `1.6rem`, CF7 `font-size:0`, `books-v2.css` `0.85em` arrows.

Also live, not tokenized, numerically near a rung (so they would not fail T4’s 0.6px test):

- `tpl-chapters-en.php` inline: `.ea-en-head__b { font-size:1.2rem }` (19.2px vs `--fs-lead` 19.55), `.ea-en-head__lang` / `.ea-en-foot` `.85rem` (= `--fs-xs`)
- `mokesh-portrait.php` inline `.78rem` (12.48 vs `--fs-2xs` 12.24)

Dead files (`services.css`, `w2-04-service.css`, `w2-10-service.css`, `w2-14e-catalog.css`) were **not** enqueued. `w2-05-shop.css` is live on `/didgeridoos/` and `/bags/`; no off-token `font-size` there. `theme-shell-fallback.css` was not loaded (parent GP sheet is readable).

---

## Deviations **not** in T2’s three categories

This is the list the 28-page recheck was blind to.

**1. `-apple-system` on `<button>` / `<input>` (GeneratePress + UA; child theme never sets family on these controls except inside a mobile media query or on `.zoom` / `.ea-lb__x`).**

- **Visible at phone width, site-wide:** `nav__burger` on the Chapters shell; `menu-toggle` on the six GP-default pages.
- **Visible at desktop:** `button.ea-qr-facade` on 42 QR URLs (play overlay). Example: `http://eyalamit-co-il-2026.s887.upress.link/qr/qr10/`
- **Embedded post forms:** Mailchimp on `http://eyalamit-co-il-2026.s887.upress.link/100-100-100-%d7%aa%d7%95%d7%93%d7%94/` (`#mce-EMAIL`, `#mc-embedded-subscribe`); guest form inputs on `http://eyalamit-co-il-2026.s887.upress.link/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/`

**2. Off-scale size not in §6:** `button.ea-lb__x` at 24px on `http://eyalamit-co-il-2026.s887.upress.link/snoring-sleep-apnea/`

Owner of (1): child theme omitted `font-family` on buttons; GP supplies `-apple-system`. 1.5.66 fixed only `.zoom` and `.ea-lb__x`. Owner of (2): child-theme `chapters.css`, not third-party.

---

## Method vs the builder

They re-scanned 28 previously dirty pages with a direct-text + visibility filter. That filter is why they recorded “54 → 0”. I derived CSS+template clusters from all 157 (GP-orphan, chapters, shop, books-v2, EN, home-front, FAQ-toc, blog singles, QR/heritage, press/heritage) and loaded every URL, not a sample. Previously-clean pages are where `nav__burger` and `ea-qr-facade` live.

Raw JSONL: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007-typography/independent-2026-09-19/`The independent verification is done. **157/157** URLs scanned, theme **1.5.66** start and end.

**T1, T2, T4, T5 are falsified. T3 (weights) holds.**

The builder’s “54 `-apple-system` rows gone” is true for skip-link / header / menu / footer / WhatsApp. It is not true that nothing on those pages still computes `-apple-system`: `button.menu-toggle` still does, and it is **visible at 390px**. `html body` beats GeneratePress on `body`; it does not beat GP’s own `button`/`input` rules.

The 28-page recheck missed a **fourth family** site-wide: `-apple-system` on buttons (`nav__burger`, QR play overlays, mobile menu). That is the list that was not in T2.