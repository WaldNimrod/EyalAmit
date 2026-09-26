# DONE — visual round (CTA bands, /method/ sand test, contrast) — 2026-09-26

Builder: Team 10. Mandate: `_COMMUNICATION/team_90/AUDIT-2026-09-26/MANDATE-CTA-BANDS-2026-09-26.md`, plus the coordinator correction in the session prompt (verify where each rule lives; do not trust a filename).

Staging base: `http://eyalamit-co-il-2026.s887.upress.link` (plain HTTP; the TLS certificate is invalid by design). Theme deployed: **1.5.134**. Commit `98351d4` on `main`, not pushed. `ea-tokens.css` byte-unchanged, sha256 `0c4f825befdd09e744d2a8c541f31cb009e7e095e8bf2d78413653fb6ed150b4`.

Every contrast number below is from painted pixels (full viewport PNG, cropped at `getBoundingClientRect`, glyphs masked, `elementFromPoint` confirmed the target was the topmost painted element). Cookie dialog dismissed before sampling. Samples taken after the reveal class `in` (ancestor opacity ≥ 0.99).

## git

Commit `98351d4` — “Apply the row CTA to the seven centred bands, and test a sand band on /method/ only.” `site/` was clean at deploy time, so `python3 scripts/ftp_deploy_site_wp_content.py` ran without `--allow-dirty` and exited 0.

After that commit, `git status --porcelain` shows only files this session did not write:

- `M _COMMUNICATION/team_100/S006/DEPLOY-LOG.md` (the deploy script appends this)
- `M scripts/s007_render_work_ssot.py` (pre-existing; not run)
- `?? _COMMUNICATION/team_10/DONE-B7-SECOND-NAV-2026-09-26.md` (the parallel builder)
- `?? scripts/save_legacy_wp_app_password.py` (pre-existing; not opened)

Not pushed.

## Where the rules actually live

Grep, not the mandate’s filename. `.cta-band`, `.cta-band--row`, `.cta-band--stack`, `.cta-band--choc`, `.btn--sand`, `.btn--terra` are all in `site/wp-content/themes/ea-eyalamit/assets/css/chapters.css`. The variant is chosen in PHP: `inc/chapters/defaults/*-defaults.php` pass `stack` into `template-parts/chapters/parts/cta.php`, and an empty `stack` is what emits `cta-band--row` plus the side logo. The seven deviations were `'stack' => true` in those defaults. Removing `stack` is the existing row variant. No third variant was added.

## Task 1 — the seven bands

All seven now render `cta-band--row` with the side logo at a layout box of **440×440**. On `/method/` the mark is visible in the rendered viewport, on the right of the sand band. HTTP 200 on every URL (the 136-URL regression below).

| URL | status | class | background | button | logo box |
|---|---|---|---|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/method/ | 200 | `cta-band cta-band--row cta-band--sand` | rgb(216, 199, 181) | `btn btn--terra` | 440×440 |
| http://eyalamit-co-il-2026.s887.upress.link/repair/ | 200 | `cta-band cta-band--row cta-band--choc` | rgb(92, 58, 46) | `btn btn--sand` | 440×440 |
| http://eyalamit-co-il-2026.s887.upress.link/sound-healing/ | 200 | `cta-band cta-band--row cta-band--choc` | rgb(92, 58, 46) | `btn btn--sand` | 440×440 |
| http://eyalamit-co-il-2026.s887.upress.link/learning/ | 200 | `cta-band cta-band--row cta-band--choc` | rgb(92, 58, 46) | `btn btn--sand` | 440×440 |
| http://eyalamit-co-il-2026.s887.upress.link/learning/lectures/ | 200 | `cta-band cta-band--row cta-band--choc` | rgb(92, 58, 46) | `btn btn--sand` | 440×440 |
| http://eyalamit-co-il-2026.s887.upress.link/learning/workshops/ | 200 | `cta-band cta-band--row cta-band--choc` | rgb(92, 58, 46) | `btn btn--sand` | 440×440 |
| http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/ | 200 | `cta-band cta-band--row cta-band--choc` | rgb(92, 58, 46) | `btn btn--sand` | 440×440 |

rgb(92, 58, 46) is `--ea-chocolate` `#5C3A2E`. The six stay on that fill with `btn--sand`. Heading colour on those six is rgb(255, 255, 255); paragraph is rgba(255, 255, 255, 0.82), which is the row rule the other bands already use.

Control, not one of the seven: http://eyalamit-co-il-2026.s887.upress.link/lessons/ is still `cta-band cta-band--row` (no `--choc`, no `--sand`), button `btn--terra`, logo 440×440. The row CSS itself was not edited, and the only defaults edited are these seven files. The other 22 were not re-rendered one by one.

## Task 2 — /method/ only

http://eyalamit-co-il-2026.s887.upress.link/method/ — status 200.

Band fill painted rgb(216, 199, 181) = `--ea-sand` `#D8C7B5`. Heading and paragraph painted rgb(46, 43, 40) = `--ea-ink` `#2E2B28`. No new token, no handwritten hex.

| element | size / weight | threshold | painted min | p05 | median | worst background |
|---|---|---|---|---|---|---|
| `.cta-band__h` | 24.65px / 500 | 3:1 | **8.55** | 8.55 | 8.55 | rgb(216, 199, 181) |
| `.cta-band__p` | 17px / 300 | 4.5:1 | **8.55** | 8.55 | 8.55 | rgb(216, 199, 181) |
| `a.btn.btn--terra` text | 15.3px / 500 | 4.5:1 | median **4.63** | — | 4.63 | fill rgb(176, 95, 56) |
| button edge (solid fill vs adjacent sand) | — | 3:1 UI boundary | **2.81** | — | — | sand rgb(216, 199, 181) |

Button text: white on the solid fill rgb(176, 95, 56), which is the existing `--terra-btn` `#B05F38`. The glyph-interior median is 4.63:1, which passes 4.5:1. The line-box minimum of 1.58:1 is sand pixels inside the text’s bounding box (233 of 2,176 pixels in that crop are sand), not the glyph interior.

Button edge: a solid fill pixel rgb(176, 95, 56) against the adjacent sand pixel rgb(216, 199, 181) is **2.81:1**. That is under the 3:1 non-text boundary threshold. `btn--terra` is the darkest filled `.btn` variant in `chapters.css`. `btn--sand` is 1:1 against this ground. `btn--gw` and `btn--gd` are lighter. No existing chapters button has a darker fill, so none was invented. The edge miss is reported for the owner; the six other pages were not switched.

## Task 3a — /learning/ eyebrow

The instruction that the approved scrim had been dropped on this page is wrong, and it was not re-implemented.

`.phero__sc` is in the markup (`template-parts/chapters/parts/phero.php` emits it whenever the hero has media) and its computed background is the shared gradient already used by `.phero--media .phero__sc`, `.phero--compact .phero__sc`, `.bleed__sc`, `.hero__scrim`, and `.ea-hero__overlay`:

`linear-gradient(180deg, rgba(11,7,3,.22) 0%, rgba(11,7,3,.42) 50%, rgba(11,7,3,.72) 100%)`

The failure was the eyebrow colour `#9A572D`, which was set on 2026-09-24 for flat near-white heroes. On the `/learning/` photograph, glyph-masked painted pixels of that colour were **1.15:1** minimum (p05 1.32, median 1.74, n=950, worst background rgb(113, 91, 73)). The mandate’s 1.38:1 sits in that same distribution. The same pixels with `--ea-on-dark` (the colour `.phero__h` already uses on this scrim) were **6.37:1** minimum before deploy.

After deploy, http://eyalamit-co-il-2026.s887.upress.link/learning/ status 200, `.phero .chap` computed colour rgb(255, 255, 255), topmost true:

| min | p05 | median | max | n | worst background |
|---|---|---|---|---|---|
| **7.65** | 8.84 | 11.71 | 18.68 | 950 | rgb(101, 79, 63) |

Passes 4.5:1. The rule is `.phero--media .chap{color:var(--ea-on-dark)}`, after the `#9A572D` rule, so non-photo `.phero` keeps `#9A572D`. No new gradient.

## Task 3b — sweep

136 published URLs (page-sitemap 83 + post-sitemap 53). 74 pages draw at least one text element over a photo. 221 text-over-photo samples.

Scrim classification on those 221, before this round’s colour change:

- **86** already carried the approved gradient above.
- **135** recorded scrim `none`. **130** of those are `.gfig__cap` on http://eyalamit-co-il-2026.s887.upress.link/galleries/ with min=1.0 and p05=1.0, and the viewport crop was ivory `#fffffa` — the images had not painted. Those 130 are **unmeasured**, not failures, and are not in the count below.
- Of the 41 real failures, **38** already had the approved gradient. The other 3 are the two home `.cmpc__p` and one `.btn--gw`, which sit on the compare-card overlay (`.cmpc__sc`, a flat `rgba(18,12,8,.6)`), not on the shared gradient.

So the scrim is not missing on the photo heroes. It is present and it is the approved one. It is thinnest at the top of the hero (alpha 0.22), which is where `.chap` sits, so a bright photograph still fails white text there. Darkening that gradient would be a new treatment. It was not done.

**41** real contrast failures before this round, on **33** pages. After this round, remeasured:

- 2 `.cmpc__p` now pass (task 3c).
- 3 `.chap` now pass: `/learning/` 7.65, and two posts at 19.17 and 19.20.
- **18 `.chap` still fail** the worst painted pixel (remeasured on 1.5.134).
- **18 other elements still fail.** Their rules were not changed, so these are the pre-deploy painted numbers.

**36 places still fail.** Listed below.

### 18 eyebrows still under 4.5:1 (post-deploy, `.phero .chap`, white, 11.05px / 500)

The median is high on most of these (9–19:1). The minimum is a near-white patch under part of the glyph, worst background around rgb(224–232). p05 is within 0.1 of the minimum, so it is not a single fringe pixel.

| min | p05 | median | URL |
|---|---|---|---|
| 3.33 | 4.50 | 6.58 | http://eyalamit-co-il-2026.s887.upress.link/sound-healing/ |
| 1.25 | 1.28 | 9.03 | http://eyalamit-co-il-2026.s887.upress.link/en/ |
| 1.28 | 1.32 | 13.89 | http://eyalamit-co-il-2026.s887.upress.link/terms/ |
| 1.31 | 1.40 | 13.94 | http://eyalamit-co-il-2026.s887.upress.link/privacy/ |
| 1.28 | 1.32 | 13.19 | http://eyalamit-co-il-2026.s887.upress.link/accessibility/ |
| 1.25 | 1.31 | 10.89 | http://eyalamit-co-il-2026.s887.upress.link/blog/ |
| 1.32 | 1.32 | 13.46 | http://eyalamit-co-il-2026.s887.upress.link/34-הטור-של-אייל-עמית-הלב/ |
| 1.27 | 1.28 | 10.52 | http://eyalamit-co-il-2026.s887.upress.link/36-הטור-של-אייל-עמית-שיטת-השקשוקה/ |
| 1.29 | 1.31 | 12.74 | http://eyalamit-co-il-2026.s887.upress.link/51-הטור-של-אייל-עמית-אקסטרים-זה-נעים/ |
| 1.36 | 1.37 | 19.23 | http://eyalamit-co-il-2026.s887.upress.link/45-הטור-של-אייל-עמית-פרופורציות/ |
| 1.32 | 1.35 | 15.40 | http://eyalamit-co-il-2026.s887.upress.link/43-הטור-של-אייל-עמית-אדון-סליחות/ |
| 1.27 | 1.28 | 9.64 | http://eyalamit-co-il-2026.s887.upress.link/42-הטור-של-אייל-עמית-אחד-בספטמבר/ |
| 1.34 | 1.35 | 17.40 | http://eyalamit-co-il-2026.s887.upress.link/32-הטור-של-אייל-עמית-אם-אין-אני-לי-מי-לי/ |
| 1.33 | 1.34 | 15.81 | http://eyalamit-co-il-2026.s887.upress.link/29-הטור-של-אייל-עמית-רייב-שבוע-הספר/ |
| 1.33 | 1.34 | 17.02 | http://eyalamit-co-il-2026.s887.upress.link/27-הטור-של-אייל-עמית-חכמת-הפרצוף/ |
| 1.35 | 1.37 | 19.10 | http://eyalamit-co-il-2026.s887.upress.link/18-הטור-של-אייל-עמית-מסך-הברזל/ |
| 1.35 | 1.38 | 19.25 | http://eyalamit-co-il-2026.s887.upress.link/40-הטור-של-אייל-עמית-פרסומת-אחת-וחזרנו/ |
| 1.32 | 1.33 | 16.52 | http://eyalamit-co-il-2026.s887.upress.link/49-הטור-של-אייל-עמית-קומיק-רליף/ |

Two eyebrows that failed before this round now pass, same colour change: http://eyalamit-co-il-2026.s887.upress.link/הטור-של-אייל-עמית-24-ילד-אסור-ילד-מותר/ min 19.17, and http://eyalamit-co-il-2026.s887.upress.link/23-הטור-של-אייל-עמית-לציית-או-לחשוב/ min 19.20.

### 18 other text-over-photo failures, rules unchanged

Approved gradient present on all of these except the ghost button. Pre-deploy painted minimums. Not restyled.

| min | need | selector | URL |
|---|---|---|---|
| 2.63 | 3 | `.hero__h` (44.2px / 300) | http://eyalamit-co-il-2026.s887.upress.link/ |
| 2.79 | 4.5 | `.hero__s` (19.55px) | http://eyalamit-co-il-2026.s887.upress.link/ |
| 2.85 | 4.5 | `.btn.btn--gw` “למידע נוסף על סאונד הילינג” | http://eyalamit-co-il-2026.s887.upress.link/ |
| 3.58 | 4.5 | `.phero__s` | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/ |
| 3.88 | 4.5 | `.phero__s` | http://eyalamit-co-il-2026.s887.upress.link/books/ |
| 2.95 | 3 | `.phero__h` | http://eyalamit-co-il-2026.s887.upress.link/lessons/ |
| 2.94 | 3 | `.phero__h` | http://eyalamit-co-il-2026.s887.upress.link/sound-healing/ |
| 3.69 | 4.5 | `.phero__s` | http://eyalamit-co-il-2026.s887.upress.link/sound-healing/ |
| 4.19 | 4.5 | `.phero__s` | http://eyalamit-co-il-2026.s887.upress.link/learning/workshops/ |
| 1.45 | 3 | `<em>` inside `.phero__h` (`--terra-lt`), text “מטפלים ומנחים” | http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/ |
| 3.90 | 4.5 | `.phero__s` | http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/ |
| 3.88 | 4.5 | `.phero__s` | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ |
| 2.58 | 3 | `.bleed__q` | http://eyalamit-co-il-2026.s887.upress.link/bags/ |
| 1.90 | 4.5 | `.bleed__a` | http://eyalamit-co-il-2026.s887.upress.link/bags/ |
| 3.55 | 4.5 | `.phero__s` | http://eyalamit-co-il-2026.s887.upress.link/repair/ |
| 3.89 | 4.5 | `.phero__s` | http://eyalamit-co-il-2026.s887.upress.link/treatment/ |
| 4.02 | 4.5 | `.phero__s` | http://eyalamit-co-il-2026.s887.upress.link/method/ |
| 3.60 | 4.5 | `.phero__s` | http://eyalamit-co-il-2026.s887.upress.link/faq/ |

## Task 3c — both home `.cmpc__p`

http://eyalamit-co-il-2026.s887.upress.link/ — status 200. Colour changed from `rgba(255,255,255,.85)` to `var(--ea-on-dark)`. Both sampled after the reveal, topmost true, colour rgb(255, 255, 255), 15.3px / 300, threshold 4.5:1. Pre-deploy minimum was 4.22 on both, worst background rgb(113, 109, 107).

| instance | min | p05 | median | max | n |
|---|---|---|---|---|---|
| first `.cmpc__p` | **5.12** | 5.30 | 14.59 | 20.03 | 130650 |
| second `.cmpc__p` | **5.12** | 6.19 | 12.74 | 19.91 | 133728 |

Both pass. `.cmpc__sc` was left as it was.

## Regression

136 live URLs, concurrency 2, retried on 502. **136/136 HTTP 200.** Exactly one `<nav class="nav">` on each. Zero of `Fatal error`, `Parse error`, `Uncaught`, `critical error`, `Warning: `, `Notice: `. The string `1.5.134` is in every response body.

`page-templates/`, `inc/wave2-*.php`, `functions.php`, the footer files, `ea-tokens.css`, and `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md` were not edited.

## For the owner

http://eyalamit-co-il-2026.s887.upress.link/method/
