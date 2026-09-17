# RTL Audit — Angle 02: PHP Templates

**Theme:** `ea-eyalamit`
**Scope:** `template-parts/` recursively (`blocks/` + `chapters/` incl. `chapters/parts/`), `inc/chapters/chapters-render.php`, `header.php`, `footer.php` — all paths relative to `site/wp-content/themes/ea-eyalamit/`.
**Date:** 2026-09-17
**Standard applied:** `_aos/lean-kit/modules/standards-conventions/rtl-bidi/RTL_BIDI_STANDARD_v1.0.0.md` (AOS Module 11), read in full before auditing — Section 1 (HTML foundation), Section 2/2.3 (logical vs. physical CSS, incl. the `[dir="rtl"]`-override exception for transforms), Section 4 (bidi text, `dir="ltr"` embedding), Section 5.5 (icon mirroring: mirror only direction-of-movement icons) applied throughout.
**Method:** whole-scope greps for every category (inline `style=`, `dir=`, `scaleX`/`transform`/mirror/flip, hardcoded directional Unicode across two passes covering ~20 candidate glyphs) so no instance was missed by manual reading alone; every file that matched was then read in full for context. Live/dead status was established by reading `inc/chapters/chapters-routing.php` and `inc/chapters/chapters-render.php` in full and tracing the actual `template_include` filter chain (not by guessing from filenames), then cross-checking every `get_template_part` call site in the theme (37 call sites, enumerated exhaustively) back to a real, currently-routable page template. Where a finding's mitigation could plausibly live in CSS (categories 2 and 3 explicitly allow "an equivalent CSS-based correction"), the relevant compiled CSS file was checked too, even though CSS files are outside this audit's file scope — skipping that check would have produced false positives.

**Headline result:** one confirmed **live, unmitigated** bidi-arrow bug affecting three real pages (`/books/`, `/shop/`, `/qr/`), a handful of lower-priority findings on templates whose live/dead status ranges from confirmed-dead to indeterminate, and — importantly — a **false alarm avoided**: the homepage/inner-page testimonial-carousel `›`/`‹` buttons that this brief's own framing pointed at turn out to already carry the exact `direction:ltr` mitigation described in the brief, applied tonight and already committed. No blanket SVG-mirroring transform was found anywhere in the audited PHP (or, on a supplementary check, anywhere in the theme's CSS). Two of the four testimonial/carousel-related block files in scope are dead code with no live rendering path.

---

## 0. Context: the already-fixed `href` bug, and whether it has siblings

`inc/chapters/chapters-render.php:690-721` (`ea_chapters_testimonials()`) already carries Nimrod's 2026-09-16 fix (see the inline comment at lines 707-713) restoring the `href` field that was being silently dropped between the FB-corpus JSON and the template. I read this fix in full and confirm it is correct and complete for that function.

I looked for other instances of the same failure class ("a field a template already knows how to render is quietly stripped one layer upstream") within this audit's scope and found none of that exact shape. I did find one **adjacent but distinct** gap worth a one-line flag since it's the same neighborhood: `ea_chapters_part_field_map()` (`inc/chapters/chapters-render.php:432`) registers the `'testimonials'` part's editable list sub-fields as `array( 'name' => 'txt', 'text' => 'ta' )` only — `href` is not in that map. Per the file's own docblock (lines 404-418), this map is the single source of truth consumed both by the ACF field registrar and by the path-B overlay (`ea_chapters_page_sections()`). Net effect: on any page using the generic sections loop (e.g. a future new page type with an editable testimonials block), an editor would be able to change a testimonial's name/text via wp-admin but **could never add or change its link** — `href` can only ever come from the seeded PHP defaults, never from ACF. This is a content-editability gap, not a rendering bug (today's live pages get their `href` from hardcoded defaults, which do render correctly), so it's outside this audit's RTL mandate and I have not verified it against `acf-fields-inner.php` (out of scope). Flagging only because it lives one function away from the bug this brief described.

---

## 1. Inline `style="..."` physical-direction CSS

Every `style=` attribute in scope (55 occurrences) was enumerated and reviewed. The great majority are `margin-top`/`margin-bottom`/symmetric `inset:Npx` shorthand — block-axis or symmetric properties that do not flip between LTR and RTL, so they are not RTL bugs regardless of the general logical-properties preference in Standard §2.1. Two genuine inline-axis (`left`/`text-align:left`) hits were found:

### Finding 1.1 — `left`/`top` physical positioning on a decorative element (DEAD)

**File:** `template-parts/chapters/parts/mag.php:15`
```php
<span class="arcs" aria-hidden="true" style="width:560px;height:560px;top:-180px;left:-180px;opacity:.1;filter:invert(1) sepia(.5) brightness(1.3)"></span>
```
Physical `left:-180px` positions a decorative glow/arc. Per Standard §2.2 this should be `inset-inline-start`, or if the visual truly must stay pinned to the physical left in both directions, a comment justifying the exception (§8.1 checklist item: "each instance has a comment justifying the exception") — neither is present.

**Reachability: DEAD.** `template-parts/chapters/parts/mag.php` is never invoked. I confirmed this two ways: (a) no `inc/chapters/defaults/*.php` file contains a section with `'part' => 'mag'` (grepped all 31 defaults files, zero matches — the only place "mag" appears is the unrelated `mag_items` ACF *repeater spec* for the `method` type in `ea_chapters_repeater_specs()`, which is vestigial bookkeeping for a part that is never actually placed in `method-defaults.php`'s `sections` array); (b) no `get_template_part` call anywhere in the theme references `parts/mag` directly. This file cannot render on any current page. **Priority: informational only** — do not spend fix time here unless the file is revived for a future page.

### Finding 1.2 — `text-align:left` inside a `dir="ltr"` wrapper (LIVE, cosmetic only)

**File:** `template-parts/chapters/parts/mokesh-portrait.php:53`
```php
<figcaption dir="ltr" style="margin-top:10px;font-family:var(--bf);font-size:.78rem;line-height:1.65;letter-spacing:.3px;color:var(--muted);text-align:left">
```
This is **not a bug** — the file's own docblock (lines 16-19) documents exactly why `dir="ltr"` is there (Latin caption lines that must not be bidi-reordered), which matches Standard §4.1 precisely. `text-align:left` inside an already-LTR-scoped element is self-consistent (left = start under `dir="ltr"`), so nothing renders wrong. The only nit is that `text-align:start` would be the logical-property-pure form and would need no updating if this figcaption were ever reused outside an LTR wrapper. **Priority: very low / optional polish.** Reachable live via `/mokesh-dahiman/` (`mokesh-dahiman` → `tpl-chapters-mokesh` in `ea_chapters_route_map()`).

**Positive callout:** `template-parts/chapters/parts/gallery.php:56` already does this correctly —
```php
<span class="ea-pending-approval__badge" style="position:absolute;inset-block-start:10px;inset-inline-start:10px;z-index:2">
```
— logical properties used inline, exactly per Standard §2.1. No action; noted as a good example.

---

## 2. Hardcoded directional Unicode characters (arrows/chevrons)

Two grep passes covered `← → ↑ ↓ » « › ‹ ▶ ◀ ▸ ◂ ⟨ ⟩ ➜ ➔ ⇐ ⇒ ⇦ ⇨ ≪ ≫` plus HTML-entity forms; every hit outside a code comment was traced to its rendering context and, where the standard allows a CSS-based fix, to the actual CSS rule.

### Finding 2.1 — `←` inside a live, unmitigated CTA hint (HIGH — confirmed live on 3 pages)

**File:** `template-parts/chapters/parts/bookcard.php:20` (default) and `:47` (render site)
```php
$cta_default = ! empty( $a['cta_label'] ) ? (string) $a['cta_label'] : 'לעמוד הספר ←';
...
<span class="bookcard__cta" aria-hidden="true"><?php echo esc_html( $cta ); ?></span>
```
Two data sources supply the same unmitigated pattern to the same template:
- `inc/chapters/defaults/shop-defaults.php:33` — `'cta_label' => 'לעמוד ←'`
- `inc/chapters/defaults/qr-hub-defaults.php:39` — `'cta_label' => 'לעמוד ה-QR ←'`
- `inc/chapters/defaults/muzza-defaults.php`'s `'books'` section (line 56 onward) sets no `cta_label` at all, so it falls through to bookcard.php's own hardcoded default above.

`←` (U+2190) is Bidi_Mirrored. Sitting undecorated inside Hebrew (RTL) text with no `dir="ltr"`/`direction:ltr`/`unicode-bidi:isolate` anywhere in the chain, the browser's bidi algorithm will display it as its mirror glyph — visually a **right**-pointing mark — immediately after "לעמוד הספר" ("to the book page"). I checked the compiled CSS rule for the class that wraps it (`assets/css/chapters.css:796`, `.bookcard__cta{margin-top:8px;font-family:var(--bf);font-size:.8rem;letter-spacing:.6px;color:var(--terra-dk);font-weight:500}`) — there is no `direction` or `unicode-bidi` property on it or on any ancestor `.bookcard`/`.bookcard__b` rule. **No mitigation exists anywhere in the chain.** This is the same failure family as tonight's carousel-arrow bug (a directional glyph rendering backwards inside an RTL run), just on a different, currently-unfixed component.

**Reachability: LIVE**, confirmed via `ea_chapters_template_include()` (`inc/chapters/chapters-routing.php:18-49`, hooked at `template_include` priority 103 — wins unconditionally): `books` → type `muzza` → `/books/`; `shop` → type `shop` → `/shop/`; `qr` → type `qr-hub` → `/qr/`. All three are in `ea_chapters_route_map()` (`inc/chapters/chapters-render.php:32-71`) and are force-routed regardless of what page-template meta is stored in the DB.

**Fix:** wrap the arrow portion in the template itself rather than relying on per-string discipline, e.g. render the label and glyph separately with the glyph in a `direction:ltr`/`dir="ltr"` span (matching tonight's carousel fix), or drop the raw arrow character from these three translatable strings entirely and use a small inline SVG chevron instead (immune to bidi mirroring by construction — see the "Patterns" section below for why the live testimonials cards already do this for their own link icon).

### Finding 2.2 — CHECKED AND ALREADY FIXED: testimonial-carousel `›`/`‹` buttons (no action needed)

**Files:** `template-parts/chapters/section-05-testimonials.php:81,89` and `template-parts/chapters/parts/testimonials.php:94,100` — both render:
```php
<button type="button" class="testi-mq__btn testi-mq__btn--right" aria-label="הזזה ימינה">
	<span aria-hidden="true">›</span>
</button>
...
<button type="button" class="testi-mq__btn testi-mq__btn--left" aria-label="הזזה שמאלה">
	<span aria-hidden="true">‹</span>
</button>
```
On first pass this looks identical to Finding 2.1: `›`/`‹` (U+203A/U+2039) are a canonical bidi-mirror pair, and the PHP alone shows no `dir`/`direction` attribute. **I checked the CSS before flagging it, and it is already mitigated.** `assets/css/chapters.css:687-703` sets `direction:ltr` on `.testi-mq__viewport`, `.testi-mq__track`, **and** `.testi-mq__btn`, with an inline comment that documents this exact bug and fix:
> "RTL fix (Nimrod, live in an Eyal meeting, 2026-09-16): ... U+2039/U+203A (‹ ›) are Unicode-mirrored punctuation, so inside an RTL run the browser silently swaps which glyph shape renders for which character — the button classed --right (›, "move right") visually showed a left-pointing chevron and vice versa. direction:ltr on the button stops the glyph from being mirrored..."

This is, word for word, the "mirrored nav arrows" bug the task brief referenced as tonight's incident — it lives in **this** component (the homepage/inner-page manual testimonial carousel, which is what `section-05-testimonials.php`'s own docblock literally calls "Manual carousel with left/right arrows"), not in the separately-named `block-testimonials-carousel.php` file (see §5 below — that file is dead and uses different CSS classes entirely, unaffected by this fix). The fix is already committed and live. **No action needed; listed here so this audit doesn't re-flag it and so the "already fixed" scope is documented precisely.** Reachable live on: `/`, `/treatment/`, `/method/`, `/sound-healing/`, `/lessons/`, `/didgeridoos/` (confirmed — none of these five inner-page defaults files set `'layout' => 'grid'`, so all render the carousel branch with these buttons; only `media-defaults.php`'s three `/testimonials/` sections set grid mode, which skips the buttons entirely).

### Finding 2.3 — `↗` external-link hint, unmitigated (reachability indeterminate, likely low-traffic)

**File:** `template-parts/blocks/block-topnav.php:365`
```php
<span class="ea-mnav-link__ext">חיצוני ↗</span>
```
`↗` (U+2197) mirrors with `↖` (U+2196). Unmitigated in this Hebrew run, it will display pointing up-**left** instead of up-right. Checked `assets/css/ea-mobile-nav.css:167` (`.ea-mnav-link__ext{font-size:0.7rem;color:rgba(255,255,255,0.45);font-weight:200}`) — no `direction`/`unicode-bidi` property. No mitigation exists.

**Reachability:** see §5 — `block-topnav.php` is dead for every caller I could resolve except `page-templates/tpl-content.php`, whose own live/dead status could not be settled from static code alone. **Priority: medium-low, contingent** — worth a 30-second live check (see recommendations) before investing fix time.

### Finding 2.4 — `↙` WhatsApp hint arrow, unmitigated (reachability indeterminate, likely dead)

**File:** `template-parts/blocks/block-contact-cta.php:95`
```php
<p class="ea-contact-form__note ea-contact-form__note--cta">
	אפשר גם לשלוח הודעה ישירה בוואטסאפ ↙
</p>
```
`↙` (U+2199) mirrors with `↘` (U+2198) — unmitigated, it will point down-right instead of down-left. Checked `assets/css/ea-atoms.css:1264-1266` (`.ea-contact-form__note--cta{margin-top:var(--ea-space-4);}`) — no direction property. No mitigation exists.

**Reachability:** same chain as `block-topnav.php` (see §5) — its only non-dead, non-test-only caller is `ea_wave2_render_editorial_blocks()`, itself only reachable via `tpl-content.php`. **Priority: low, contingent** on the same live-page check as 2.3.

### Finding 2.5 — `↗` hint on dead carousel/row blocks (informational only)

**Files:** `template-parts/blocks/block-testimonials-carousel.php:72` and `template-parts/blocks/block-testimonials-row.php:105`, identical pattern:
```php
<span class="ea-testimonial-card__hint" aria-hidden="true"> ↗</span>
```
Same unmitigated-mirroring issue as 2.3 (checked `assets/css/testimonials-carousel.css` — no `direction`/`unicode-bidi` rule for `.ea-testimonial-card__hint`). **Both files are confirmed dead** (see §5 inventory) — no live page currently renders this markup. **Priority: informational only.**

### Non-issues checked and cleared

- `▾` (block-topnav.php:214, section-nav.php:23/33/43/54/64) and `⌄` (block-topnav.php:345) — down-pointing carets. These are **not** in Unicode's bidi-mirroring set (a vertically-oriented, left-right-symmetric glyph has no mirror form), and "open/expand downward" isn't a reading-direction concept. No RTL exposure; not flagged as findings.
- `☰`, `×`, `♪` — symmetric glyphs, no bidi exposure.
- `is_rtl()` — not called anywhere in scope (no conditional RTL/LTR branching logic in these templates beyond the `dir=` attributes covered in §4).

---

## 3. SVG icon mirroring

No inline `style`/`transform` on any `<svg>` element was found anywhere in scope (the exhaustive `style=` enumeration in §1 covers every inline style in the audited files, inline-SVG-transform included — there were none). No `[dir="rtl"] svg { transform: scaleX(-1) }`-style rule was found either, on a supplementary check across **all** of the theme's CSS files (`grep -rn "svg.*scaleX\|scaleX.*svg\|\[dir=.rtl.\].*svg" assets/css/*.css` — zero hits in all 19 stylesheets). **No blanket SVG-mirroring transform exists anywhere in this theme.**

Every SVG encountered in scope is a static path with no conditional transform: the footer's social-network logos (`block-footer-social.php`, `section-footer.php` — Facebook/Instagram/YouTube/TikTok, correctly never mirrored per Standard §5.5's "brand logos" rule), the sound-toggle icon, the WhatsApp icon, the generic person/avatar placeholder icon in testimonial cards, and the external-link "box with an arrow" icon (`template-parts/chapters/parts/testimonials.php:67`, `section-05-testimonials.php:64`) — none are transformed, so none are at risk of the universal-icon-mirroring mistake the standard warns about. This category is clean.

Worth noting as a **positive pattern**: the live testimonial cards' external-link indicator is an actual `<svg class="tmq__link-ic">` with a fixed path, not a Unicode arrow character — which is structurally immune to the bidi-mirroring problem that affects Findings 2.1/2.3/2.4/2.5. See the Patterns section.

---

## 4. Explicit `dir="ltr"` / `dir="rtl"` attributes — full inventory

Every occurrence in scope, with context and an intentional/dormant call on each:

| # | File:Line | Snippet | Assessment |
|---|---|---|---|
| 1 | `template-parts/chapters/parts/contact.php:77` | `<a href="tel:..." dir="ltr" style="white-space:nowrap">` | **Intentional/correct.** Phone number — matches Standard §4.1's "known-LTR islands" rule (tickers/URLs/codes; a Western-digit phone number is the same category). Live on `/contact/`. |
| 2 | `template-parts/chapters/section-footer.php:37` | `<a href="tel:..." dir="ltr">` | **Intentional/correct.** Same phone-number pattern, in the sitewide Chapters footer. Live sitewide. |
| 3 | `template-parts/chapters/parts/mokesh-portrait.php:53` | `<figcaption dir="ltr" style="...">` | **Intentional/correct**, and explicitly self-documented in the file's own docblock (lines 16-19) as protecting Latin caption lines from bidi reordering. Live on `/mokesh-dahiman/`. |
| 4 | `template-parts/blocks/block-topnav.php:197` | `<nav class="ea-topnav" ...<?php echo 'ltr' === $ea_nav_dir ? ' dir="ltr"' : ''; ?>>` | **Dormant, not a bug.** Conditional on a query var (`ea_nav_dir`) that is read here and in block-footer-social.php but **never set to `'ltr'` anywhere in the codebase** (confirmed by grepping every `ea_nav_dir` occurrence theme-wide — only the two read sites exist). This is inert forward-compatibility scaffolding for a hypothetical future English-nav variant, not a live scoping mistake. |
| 5 | `template-parts/blocks/block-footer-social.php:58` | `<footer class="ea-footer" ...<?php echo 'ltr' === $ea_nav_dir ? ' dir="ltr"' : ''; ?>>` | **Dormant, not a bug.** Same unset query var as #4. |

No occurrence in scope scopes something to LTR/RTL that shouldn't be, and none is missing where the standard would require one inside this file set. `header.php`'s root-level direction declaration is handled differently — see the Patterns section below.

---

## 5. Live vs. dead — testimonial/carousel-related templates

This required tracing the actual WordPress routing, not just filenames, because the theme runs two parallel systems ("Wave2" and "Chapters" — see Patterns). The decisive mechanism is `ea_chapters_template_include()` (`inc/chapters/chapters-routing.php:18-49`), hooked to `template_include` at **priority 103**, which unconditionally overrides the front page and every slug listed in `ea_chapters_route_map()` — and `ea_chapters_blog_template_include()` at **priority 105** for the blog archive/single. Both run whenever `ea_chapters_enabled()` is true, which it is by default (`inc/chapters/chapters-render.php:91-94`: `defined('EA_CHAPTERS_FRONT') ? ... : true`) — and `EA_CHAPTERS_FRONT` is **not defined anywhere** in this codebase (grepped the full `site/` tree; the only hits are comments describing the rollback mechanism, never an actual `define()`). So Chapters is live, and every legacy ("Wave2") template that duplicates a Chapters-routed slug is dead **as a matter of code fact**, not inference from naming.

| Template file | Status | Basis |
|---|---|---|
| `template-parts/chapters/section-05-testimonials.php` | **LIVE** | Called directly by `page-templates/tpl-chapters-home.php:66`, which `ea_chapters_template_include()` force-serves for the front page. |
| `template-parts/chapters/parts/testimonials.php` | **LIVE** | Invoked by `ea_chapters_page_sections()`'s generic sections loop wherever a page type's defaults declare `'part' => 'testimonials'`. Confirmed present (grepped all defaults files) in `media-defaults.php` (→ `/testimonials/`, grid mode), `treatment-defaults.php` (→ `/treatment/`, carousel mode), `method-defaults.php` (→ `/method/`, carousel), `sound-healing-defaults.php` (→ `/sound-healing/`, carousel), `lessons-defaults.php` (→ `/lessons/`, carousel), `didgeridoos-defaults.php` (→ `/didgeridoos/`, carousel). All six slugs are in `ea_chapters_route_map()` and force-routed to `tpl-chapters-page.php`. |
| `template-parts/blocks/block-testimonials-carousel.php` | **DEAD** (rollback-only / test-only) | Reachable only via `ea_wave2_home_block_slugs()`'s dynamic-slug loop in `ea_wave2_render_home_blocks()` (`inc/wave2-stage-b.php:40-56, 345-360`), whose only two callers are `page-templates/tpl-home.php` and `page-templates/tpl-stage-b-test.php`. `tpl-home.php`'s own docblock states it in so many words: *"FROZEN EMERGENCY ROLLBACK ... kept when EA_CHAPTERS_FRONT=false ... Do not edit — Chapters tpl-chapters-home.php is the live template."* Since `EA_CHAPTERS_FRONT` is never defined false, this branch does not currently serve any visitor. `tpl-stage-b-test.php` is routed only for a page whose slug is literally `stage-b-test` (`ea_wave2_template_router()`, `functions.php:509-526`) — a QA harness page, not real content. |
| `template-parts/blocks/block-testimonials-row.php` | **DEAD** (fully orphaned) | Zero references anywhere in the theme. I enumerated every `get_template_part` call site in the codebase (37 total, across every `.php` file) and cross-checked every dynamic-slug array (`ea_wave2_home_block_slugs()` contains `'testimonials-carousel'`, never `'testimonials-row'`). No code path, live or rollback, reaches this file. It is superseded in-place by `block-testimonials-carousel.php` (the two files share an identical context contract, per both files' own docblocks — "Reads the same `ea_testimonials_ctx` query var ... so callers swap the block slug without reshaping data" — but nothing ever made that swap back to `-row`). |

**Bottom line for prioritization:** the two files sharing this audit's own filename pattern (`block-testimonials-carousel.php`, `block-testimonials-row.php`) are both dead; the two files that actually serve every real visitor's testimonials (`section-05-testimonials.php` on the homepage, `parts/testimonials.php` everywhere else) are named differently and are covered above in Findings 2.1 (n/a here — clean) and 2.2 (checked, already fixed).

### Related, lower-confidence dead-code trail (flagged per the brief's "apply the same check to anything else you flag")

Three more files carrying findings in this report (`block-topnav.php`, `block-footer-social.php`, `block-contact-cta.php`) are **not** testimonial/carousel files but share the exact same Wave2-vs-Chapters ambiguity, so I traced them too rather than assume:

- Both are called from `ea_wave2_render_home_blocks()` (same dead/test-only path as above), from `page-templates/tpl-qr.php` (**dead** — `qr` and pattern-routed `/qr/*` children are both force-routed to Chapters templates per `ea_chapters_route_map()` and `ea_chapters_pattern_routes()`), and from `page-templates/tpl-blog-single.php`/`tpl-blog-archive.php` (**dead** — `ea_chapters_blog_template_include()` force-routes `is_home()`/`is_singular('post')` to the Chapters blog templates at priority 105).
- Their one remaining caller, `page-templates/tpl-content.php`, is **not** overridden by the Chapters router (no slug in `ea_chapters_route_map()` resolves to `tpl-content`), so its live/dead status depends entirely on whatever page-template meta is actually stored in the WordPress database — which static code analysis cannot see. Its own docblock scopes it to three editorial routes: `/about`, `/press`, `/about/moksha`. None of these three paths appear anywhere in the current live navigation (`block-topnav.php`'s own `$ea_topnav_items`, and `section-nav.php`) — the current "about Eyal" link is `/eyal-amit/` (Chapters-routed) and the current Mokesh page is `/mokesh-dahiman/` (also Chapters-routed, via `tpl-chapters-mokesh.php`). This makes `tpl-content.php` **likely dead** but not provably so from the repo alone.
- `block-contact-cta.php`'s alternate caller path (`inc/wave2-w2-07.php:617`, inside `ea_wave2_render_editorial_blocks()`) confirms it is reachable only through this same `tpl-content.php` thread.

**Recommendation:** a 30-second manual check settles this — visit `/about/` and `/press/` on the live/staging site (or check Pages → look for a page still assigned "tpl-content (Wave2)" in wp-admin). If neither resolves to real content, Findings 2.3 and 2.4 drop to pure informational status alongside 2.5, and the three files become candidates for removal.

---

## Patterns

**1. Wave2/Chapters dual-template debt is the dominant risk multiplier in this file set, and it's traceable in code, not just by convention.** Nearly every RTL-relevant finding above that landed on a "Wave2" block (testimonials-carousel, testimonials-row, topnav, footer-social, contact-cta) turned out to be dead or near-dead once the actual `template_include` filter chain was read, while the corresponding "Chapters" replacement is what real visitors see. This matches the project's known dual-template debt (Wave2 vs. Chapters) and means: **any future RTL fix proposed for a `template-parts/blocks/*.php` file should first be checked against `ea_chapters_route_map()` / `ea_chapters_pattern_routes()` and the two `template_include` filters in `chapters-routing.php`** before assuming it needs attention. Not every block file is dead, though — `block-blog-card.php` and `block-faq-list.php` are shared and genuinely live under both systems (called directly from `tpl-chapters-blog-archive.php`/`tpl-chapters-blog-single.php` and from `chapters/parts/faqblock.php` respectively) — so this is a per-file check, not a blanket "everything in blocks/ is dead" assumption.

**2. Unicode arrow glyphs are a recurring, self-inflicted risk in this codebase; SVG paths are not.** Every finding in §2 (2.1, 2.3, 2.4, 2.5) is the identical mechanism: a literal directional Unicode character typed straight into a Hebrew string or PHP template with no bidi isolation. The one place in scope that renders an equivalent "external link" affordance via an actual `<svg>` path (`parts/testimonials.php:67`, `section-05-testimonials.php:64`) has zero mirroring exposure by construction — there is no character to mirror. Recommend treating "no bare directional Unicode in a translatable/Hebrew-adjacent string" as a lint-able rule going forward (mirrors the standard's own §8.2 grep-based CI suggestion, just for glyphs instead of CSS properties), and preferring a small inline SVG chevron over a typed `←`/`→`/`‹`/`›` character for any future CTA hint.

**3. Where this codebase does handle bidi correctly, it does so consistently and often with an explicit paper trail.** The phone-number `dir="ltr"` pattern (Finding-table #1/#2) is applied uniformly everywhere a `tel:` link appears in scope. The `mokesh-portrait.php` Latin-caption handling is self-documented in its own docblock. And Finding 2.2 shows the exact mechanism this audit was asked to watch for (`direction:ltr` stopping bidi-mirrored punctuation) was already correctly diagnosed and fixed tonight, with a comment good enough that I could independently re-derive the bug from the code alone before finding the comment confirming it. `header.php`'s dev-only fallback branch (only ever reached when no GeneratePress parent theme is present — GeneratePress is not vendored in this repo, so in real deployment `get_parent_theme_file_path('header.php')` resolves to GeneratePress's own header and this repo's fallback markup never executes) correctly uses `language_attributes()` rather than a hardcoded `<html>` tag, which is the WordPress-idiomatic way to satisfy Standard §1.1 (`is_rtl()` populates `dir="rtl"` automatically for a Hebrew-locale install) — noted for completeness even though this branch is not live.

---

## Prioritized recommendations

1. **HIGH — Fix `template-parts/chapters/parts/bookcard.php`'s CTA arrow (Finding 2.1).** Live on `/books/`, `/shop/`, `/qr/`. Wrap the `←` glyph in a `direction:ltr` scope (cheapest, matches tonight's precedent) or replace it with an inline SVG chevron in the template (more robust, removes the raw arrow character from three translatable strings at once: `bookcard.php:20`, `shop-defaults.php:33`, `qr-hub-defaults.php:39`).
2. **MEDIUM — Settle `tpl-content.php`'s live/dead status** (one visit to `/about/` and `/press/`, or one look at wp-admin Pages). This single check resolves the priority of Findings 2.3 and 2.4 and tells you whether `block-topnav.php`/`block-footer-social.php`/`block-contact-cta.php` are worth any further attention at all, RTL or otherwise.
3. **LOW, contingent on #2 — If `tpl-content.php` is live:** fix the `↗` in `block-topnav.php:365` and the `↙` in `block-contact-cta.php:95` the same way as #1. **If dead:** no action; these three files become removal candidates for a separate cleanup pass (not this audit's call to make).
4. **LOW / optional — `mokesh-portrait.php:53`:** `text-align:left` → `text-align:start` for logical-property purity. Cosmetic; current rendering is already correct.
5. **INFORMATIONAL — no action required:** Finding 2.2 (testimonial carousel arrows) is already fixed and live; Finding 1.1 (`mag.php`) and Finding 2.5 (`block-testimonials-carousel.php`/`block-testimonials-row.php`) are on dead code.
6. **Process note:** the ACF-editability gap in §0 (testimonials `href` not in `ea_chapters_part_field_map()`'s list-sub-field map) is outside this audit's mandate and unverified against `acf-fields-inner.php` — worth a look by whoever owns that file, not an RTL fix.

---

*Audit conducted by reading every file in scope in full, plus the standard document in full, plus `inc/chapters/chapters-routing.php`, `inc/chapters/chapters-render.php`, `functions.php`'s template-routing hooks, `inc/wave2-stage-b.php`, and the relevant `inc/chapters/defaults/*.php` files needed to resolve live/dead status. This is audit-only; no code was modified.*
