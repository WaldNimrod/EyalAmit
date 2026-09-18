---
id: CSS_ARCHITECTURE_AUDIT_2026-09-18_v1.0.0
schema_version: aos_v1_team_messaging
type: REPORT (team_10 → team_100, on Nimrod's direct instruction — not an S007/S006 mandate)
from: team_10 (session eyalamit-co-il-2026-e4)
to: team_100
cc: [team_00]
date: 2026-09-18
disposition: FINDINGS AND RECOMMENDATIONS ONLY. Read-only research, four parallel agents. No CSS/PHP edited, nothing committed, nothing deployed.
---

> ⚠ **HISTORICAL — not the current state.** Typography and CSS sizing are governed by
> `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md`, locked at theme 1.5.56. Numbers in
> this file were true when it was written. **Do not act on a font-size figure from here**
> without checking the canon first — §7 there lists the specific figures that are dead.
> Kept because the measurements and the method are still useful; the conclusions are not.

# CSS architecture audit — conclusions and recommendations

Nimrod asked directly (not via an S007/S006 mandate) for this after seeing the M-03/M-04
work: his read was that `home-front.css` "exceeds the whole idea of a unified design
template," and asked for the whole CSS structure to be checked for correctness and
WordPress best practice, via several parallel research agents, with conclusions delivered
to team_100. Explicitly marked secondary to any team_100 mandate — nothing here was allowed
to block S007 work, and it didn't.

Four agents ran in parallel: enqueue architecture, selector/naming quality, design-token
consolidation, and performance/WordPress conventions. Their findings overlap in places
(expected and useful — several facts got independently confirmed twice), and this report
reconciles them into one picture rather than stapling four documents together.

## Executive summary

1. **`home-front.css` should be deleted outright, not trimmed.** All 660 lines are dead —
   confirmed two independent ways (static trace to a class/block system nothing in the
   current codebase emits, and a live fetch of `/` showing zero of its 6 marker classes
   present) for two different structural reasons, not one. Nimrod's instinct was correct
   and the evidence fully supports it.
2. **Two more files are near-certainly dead for the identical reason, not yet deleted:**
   `w2-08-en-landing.css` (a template-priority race it silently lost to Chapters — the `/en`
   page is fully rendered by a competing template that never touches this file's markup)
   and, newly found this pass, `testimonials-carousel.css` (loaded on every single page,
   its only consumer is a Wave2 block partial that the live home page never reaches). Four
   more files were already confirmed to have **zero enqueue call anywhere in the codebase**
   (`services.css`, `w2-04-service.css`, `w2-10-service.css`, `w2-14e-catalog.css` — the last
   one's own renderer was deliberately deleted in a prior cleanup and nobody removed its
   CSS alongside it).
3. **CORRECTED after team_100 review — the `/books/` item is not a bug, and must not be
   "fixed."** `ea_eyalamit_is_books_hub_view()` still checking the pre-consolidation slugs
   `muzza`/`muzeh` looked at first like a missed rename that leaves `books-v2.css` unloaded
   on `/books/`. It is the opposite: that function gates five things at once
   (`functions.php`: a `template_include` override, the `books-v2.css` enqueue, body
   classes, the GeneratePress sidebar-layout slug, and a show-title filter), and `/books/`
   today renders through the current, approved Chapters template (confirmed live: body
   class `ea-chapters`, `chapters-main` present). The gate reading false is not why the page
   is broken — **it is why the page works.** Making the slug check match `books` would swap
   the live Chapters page back to the old Wave2 books-hub template across all five of those
   limbs at once. This was flagged and corrected before it could be actioned; see Part 2.
4. **The root cause behind #1-#3 is the same, three times over**: a URL got re-pointed to a
   new template/renderer during the Wave2→Chapters migration, and a sibling
   `is_page()`/`is_page_template()` check keyed to the old identity was never updated to
   match. This is a process gap (no migration checklist step for "grep for every
   is_-check referencing the old page/template"), not three unrelated mistakes.
5. **The CSS delivery pipeline is disconnected from WordPress's own dependency resolver.**
   8 of the 9 home-page stylesheets declare dependencies that never terminate at the parent
   GeneratePress stylesheet; correct load order today is held together entirely by
   hand-chosen `wp_enqueue_scripts` priority numbers (4→20→23→26→28→29→30→100→101). It
   works, but nothing enforces it, and it's undocumented outside code comments.
   `style.css` is also being sent to every visitor **twice** — once via GeneratePress's own
   automatic child-theme handle, once via this theme's own redundant explicit re-enqueue of
   the identical file.
6. **The font-size consolidation this project just finished (S007 M-01/M-03) is the
   exception, not the rule.** Every other design-property category is at a similar or worse
   state than font-size was before that work: spacing is 0-1.4% tokenized in the two
   biggest CSS files, box-shadow has never been tokenized at all (0%, theme-wide, no partial
   attempt), and — most concretely risky — **there are four parallel, partially-overlapping
   brand-color systems**, two of which hold genuinely different numeric values for the same
   two most important brand colors (ink and terracotta) depending which template family
   renders a given page.
7. **Real, non-token duplication exists at the component level**: at least four independent
   accordion/disclosure implementations, two book-card components with entirely different
   hover physics, and a hand-duplicated color palette (`--eyal-*` mirroring `--ea-*`) that
   has already caused one shipped accessibility regression when only one copy got a
   contrast fix.
8. **Net assessment: this codebase is in better shape than a typical multi-year WordPress
   theme on raw hygiene metrics** (`!important` and ID-selector counts are both genuinely
   low, versioning is consistently applied even if crudely, i18n/text-domain conventions are
   followed correctly, style.css's theme header is well-formed). The problems found are real
   and concrete, not a vague "needs a rewrite" — they're a specific, fixable backlog, most of
   it inherited from the still-incomplete Wave2→Chapters migration rather than from sloppy
   authorship.

## Part 1 — Confirmed dead code and its cost

| File | Status | Evidence | Byte cost (raw/gzip) |
|---|---|---|---|
| `home-front.css` | **Dead, all 660 lines.** Delete file + its enqueue (`inc/wave2-stage-b.php:140-143`). | Every rule traces to either `.ea-home-dashboard` (a class emitted by no current code path) or to Wave2 block partials (`template-parts/blocks/block-*.php`) that only `tpl-home.php` invokes — and `tpl-home.php` is never the file WordPress actually includes for the front page (Chapters' `tpl-chapters-home.php` wins via a separate, later-priority `template_include` filter). Live fetch of `/` confirms zero matches for all 6 marker classes. | 17,531 / 3,900 |
| `ea-mobile-nav.css` | **Dead** (established prior to this audit; reconfirmed here, still shipping on every page). | 0 DOM matches across 30 sampled pages, an earlier session's own finding. | 11,338 / 3,507 |
| `ea-mobile-variants.css` | **Dead** (same). | Same. | 3,213 / 1,232 |
| `testimonials-carousel.css` | **Likely dead — new finding, not yet independently re-verified beyond the home page.** Loaded on every page via the same sitewide bridge as the two files above; its only consumer, `template-parts/blocks/block-testimonials-carousel.php`, is a Wave2 block partial in the same unreachable family as `home-front.css`'s. Live home fetch shows none of its `.ea-testi-carousel__*` classes. | 2,325 / 1,057 |
| `services.css` | **Dead — zero enqueue call anywhere in the codebase.** Its own scoping classes (`.ea-treatment-page`/`.ea-method-page`) are never emitted by any current template. | 13,781 / 2,324 |
| `w2-04-service.css` | **Dead — zero enqueue call anywhere.** | 5,248 / 1,436 |
| `w2-10-service.css` | **Dead — zero enqueue call anywhere.** | 4,733 / 1,875 |
| `w2-14e-catalog.css` | **Dead — its own renderer was deliberately deleted in a prior cleanup** (`page-templates/tpl-catalog-14e.php` is now a 301-redirect stub; a code comment names the renderer's removal explicitly), and the CSS was never removed alongside it. | 15,509 / 3,498 |

**Confirmed-safe removal today (already known dead before this audit, zero new risk):**
`ea-mobile-nav.css` + `ea-mobile-variants.css` — **14.2 KB raw / 4.6 KB gzip**, 2 fewer
requests on every single page load.

**If `home-front.css` and the 4 zero-reference files are added** (pending only a final
"nothing else references this" pass before deleting, which is normal practice, not a new
finding this report needs to add): a further **56.8 KB raw / 12.6 KB gzip**, none of it
reachable from the front end today.

**Total identified dead weight, all 7 files: 71.4 KB raw / 17.3 KB gzip — roughly a third of
the entire 204.6 KB raw (50.9 KB gzip) currently shipped on every home-page load**, before
`testimonials-carousel.css` (pending final confirmation) is even counted.

## Part 2 — One real live bug, and one corrected false alarm

**`/books/` — CORRECTED, do not action the original wording of this finding.** The first
draft of this report read `ea_eyalamit_is_books_hub_view()` still checking the
pre-consolidation slugs `['muzza','muzeh']` as a missed-rename bug that leaves
`books-v2.css` unloaded on the current `/books/` page, and recommended adding the current
slug to fix it. **That recommendation was wrong and has been withdrawn** — team_100 caught
it before anyone acted on it. The function gates five things at once, all in
`functions.php`: a `template_include` override, the `books-v2.css` enqueue, body classes,
the GeneratePress sidebar-layout slug, and a show-title filter. `/books/` today renders
through the current, approved **Chapters** template — confirmed live, body class
`ea-chapters`, `chapters-main` present, verified independently by both team_10 and team_100.
The gate never matching `books` is *why* the old Wave2 books-hub path stays switched off,
not a mistake that leaves something unloaded. Making the slug check match `books` would
swap the live page back to the Wave2 template, layout, body classes and title-handling all
at once — a five-limbed regression, not a stylesheet fix. **This item is a correct instance
of the same root-cause pattern as the three dead-file findings (a Wave2→Chapters migration
left an old identity check behind) — but the repair for it is the opposite of the other
three: leave this gate exactly as it is. Do not add `books` to it.** No further action item
survives from this finding; it's recorded here only so the pattern (and the correction) is
on the record.

1. **`/en/` silently renders through the wrong system.** Two competing `template_include`
   filters target this URL; Chapters' own (`priority 103`) wins over the Wave2 w2-08 one
   (`priority 101`), so the page actually shown is `tpl-chapters-en.php` — which never calls
   `the_content()`, meaning `w2-08-en-landing.css`'s entire target markup
   (`.ea-en-hero`/`.ea-en-section`) is never printed. The stylesheet still loads on every
   `/en/` visit for nothing. This needs a decision (which system is canonical for `/en/`),
   not just a delete — flagging for team_00/whoever owns that page, not resolving it here.
2. **`home-front.css`'s "works" is an accident, not a maintained contract**, worth naming
   even though the fix (delete) is simple: its home-only condition checks a stored template
   meta value that was set once, years ago, by a run-once seeder script, and has silently
   stopped meaning anything since Chapters took over front-page rendering by a completely
   separate mechanism. It currently "works" purely because nobody has touched the front
   page's Template dropdown since — not because anything still enforces the relationship.

## Part 3 — Enqueue architecture

- **Dependency graph is disconnected from the parent theme for 8 of 9 home-page files.**
  Only the theme's own `style.css` enqueue correctly depends on GeneratePress's `generate-style`
  handle. The entire Wave2/Chapters chain (`ea-tokens.css` → everything downstream, including
  `chapters.css` itself) declares dependencies that terminate within that chain, never at the
  parent stylesheet — correct load-after-parent order is achieved only by hand-tuned
  `wp_enqueue_scripts` priority numbers. This works today; it's not self-enforcing, and nothing
  would error if a future priority choice collided with it.
- **`style.css` is sent to every visitor twice** — once via GeneratePress's own automatic
  child-theme handle (`generate-child-css`, correctly `filemtime()`-versioned), once via this
  theme's own redundant explicit re-enqueue of the identical file
  (`functions.php:120-125`). Not a deliberate print/screen split — same media, same bytes,
  parsed and applied twice. GeneratePress's own documented guidance for child themes is not
  to manually re-enqueue `style.css` at all; recommend removing this theme's explicit call
  and keeping only the parent's automatic one.
- **`ea-blog.css` is registered under two independent handles** (`ea-blog` and `ea-editorial`)
  in two different files with two independently-maintained conditions. Not currently a live
  double-load (the conditions happen to be mutually exclusive today), but every future change
  to "when does this file apply" has to be made twice to stay consistent.
- **Versioning is 100% theme-Version-based, zero `filemtime()`, and this is a felt cost
  today, not a theoretical one**: because one shared version string cache-busts all ~19 CSS
  files (and several JS files) at once, *any* single-file change forces a version bump that
  invalidates every visitor's cache for every unrelated file too — which is almost certainly
  why this session's own git log shows 20 consecutive manual version bumps, one per commit.
  GeneratePress's own auto-added handle for this theme's `style.css` already uses
  `filemtime()` right next to this theme's hand-versioned duplicate of the same file — the
  more robust mechanism is already present in the request log, just not used for this
  theme's own enqueues.
- **Two duplicate Google Fonts requests for Heebo** (`inc/wave2-stage-b.php:94-99`, weights
  100-600, unconditional on every Wave2 view; `inc/chapters/chapters-enqueue.php:27-32`,
  weights 200-800, unconditional on every Chapters view) — both fire on every page, two
  separate render-blocking font stylesheet requests for overlapping weights of the same
  family.
- **Positive finding, worth keeping in mind before assuming this project doesn't think about
  performance**: `ea_wave2_dequeue_unused_styles()` (`inc/wave2-stage-b.php:161-181`) already
  actively dequeues WordPress core block-library CSS/JS and Gutenberg global-styles on Wave2
  views. The awareness exists; it just hasn't been turned on the theme's own dead files yet.

## Part 4 — Design tokens: font-size was the exception, not the rule

The same "raw declarations vs. real distinct values vs. token adoption" methodology from the
font-size work (S007 M-03), applied to every other major design-property category:

| Category | Token adoption | Verdict |
|---|---|---|
| Color | 72.0% | Partially tokenized, worth finishing — see the 4-systems problem below; this is a consistency/correctness issue more than a volume one. |
| Spacing (margin/padding/gap) | 43.5% overall, but **0–1.4%** in `chapters.css` and `books-v2.css` specifically — the two biggest files | **Essentially untokenized where it matters most.** A working, well-adopted scale already exists (`--ea-space-*`, ~87% adopted in `ea-atoms.css`) — this is "port a proven scale to the files that never got it," structurally identical to how the font-size fix was scoped. Of the hardcoded spacing values, only 34% even happen to land on the existing scale's numbers — the rest is genuinely arbitrary, not just missing a `var()`. |
| Border-radius | 33.7% | Partially tokenized — smallest, most mechanical fix: really just 2 concepts (a 4px image radius, a 100px pill radius), already half-adopted, plus a third "pill" spelling (`999px`, 3 uses) that should collapse into the existing token. |
| Transition duration/easing | 34.8% pure token use (57.3% if partial "mixed" declarations count) | Partially tokenized — the cleanest replay of the font-size diagnosis: a working, documented system exists (`--ea-ease-enter`, `--ea-stagger-step`), and `chapters.css` independently reinvented both the easing curve (byte-identical curve, renamed `--e`, zero cross-references to the original) and the stagger concept (hardcoded step of 0.18s instead of using `--ea-stagger-step:0.05s`). |
| Box-shadow | **0%** | Never tokenized at all, anywhere, even partially — the starkest number of the five, though the smallest in absolute footprint (~41 hardcoded declarations theme-wide). |

**The color-system problem specifically** (the one item here with real, current visual-risk,
not just maintainability cost): four parallel definitions of the brand palette exist
simultaneously —
1. `ea-tokens.css` (`--ea-terracotta`, `--ea-ink`, etc.) — the intended, sitewide system.
2. A `functions.php`-injected global duplicate (`--eyal-terracotta`, `--eyal-ink`, etc.) with
   identical values but different names, consumed by `books-v2.css`, `services.css`,
   `theme-shell-fallback.css`.
3. `chapters.css`'s own, largely self-contained token set (`--terra`, `--ink`, etc.) — and
   **three of these genuinely differ in value** from the "same" color in system #1 (the
   third pair independently confirmed by team_100 during review): `--ink` (#2f2013) vs.
   `--ea-ink` (#2E2B28); `--terra` (#B5663D, lighter/more orange) vs. `--ea-terracotta`
   (#A44E2B, darker/more brick); and `--body` (#67482d) vs. `--ea-text-body` (#5A3826) — the
   last pair carries its own comment noting `--ea-text-body` was deliberately darkened for
   AA compliance, a fix the `chapters.css` copy never received. Team_100 measured the live
   body text using `chapters.css`'s own (undarkened) value at **8.62:1** — well clear of
   4.5:1, so nothing is failing today — and noted the darker `--ea-terracotta` is the safer
   of that pair. **No active contrast failure currently sits behind this drift; the finding
   is the mechanism, not a current visible bug**: a fix applied to one copy of a duplicated
   token silently does not reach the other, which is exactly what happened once already
   with `--eyal-muted` vs. `--ea-muted` (below) before it was caught.
4. A dead, unrelated `--svc-*` set inside the fully-orphaned `services.css`.

Also concrete: **185 distinct hardcoded color literals exist outside any token**, two of the
most-repeated of which (`#faf8f5`, `#f3eee8`, in `books-v2.css`) are pixel-identical to
tokens that already exist and load on every page (`--ea-bg`, `--ea-bg-alt`) — not missing
tokens, just missed `var()` calls. `#fff`/`#ffffff` alone appears as a raw literal 101 times
(69 of them in `chapters.css`), despite a token (`--ea-on-dark`) whose own changelog comment
says it was added specifically "to retire raw #fff" — the fix was made in one system and
never propagated to the other.

## Part 5 — Component and selector quality

- **`!important`: 75 real uses across ~9,900 lines** — genuinely low for a theme this size,
  and roughly a third of them are defensible (a11y reduced-motion guards, a documented,
  deliberate migration enforcing "no gradients on buttons" against legacy styles, the
  standard `[hidden]{display:none!important}` idiom). The rest, concentrated in
  `services.css` (a dead file, so moot) and the dead `home-front.css`'s home-dashboard
  component, read as a habitual crutch rather than a narrow escape hatch — most tellingly,
  one selector there is *already* 3 classes deep **and still** needs `!important`, which is
  the clearest possible sign of an unresolved cascade fight (traced to GeneratePress's own
  late-loaded `a:hover`/`a:focus` rule at competitive specificity — this exact collision is
  independently guarded against twice, in two different files, with two different
  techniques).
- **ID selectors: only 7 unique IDs theme-wide** — not a real problem by volume. One (`#session`)
  is worth a small fix: it scopes a one-off visual variant of an otherwise-reusable card
  component, which means nobody can reuse that same look elsewhere without either duplicating
  the ID or reaching for `!important` — a modifier class would have cost nothing extra and
  stayed reusable.
- **Real component duplication, not just token sprawl:**
  - **At least 4 independently-built accordion/disclosure widgets** implementing the
    identical visual technique under different names (`.faq__i`, `.prose-acc`,
    `.ea-faq-item` — itself defined independently in 3 separate files — and the native
    `.dd`/`<details>` variant), plus a testimonial-accordion block defined **byte-for-byte
    identically** in two different files (`w2-04-service.css` and `w2-05-shop.css`) that
    should simply live once.
  - **2 independently-built "book card" components with genuinely different hover physics**
    (`.bookcard` lifts + warm shadow; `.ea-book-card` scales + neutral shadow) — code comments
    reference a *third*, now-deliberately-abandoned hover treatment from even earlier in the
    project's history, meaning this one concept has had at least 3 different treatments,
    2 of which are still simultaneously live depending which template renders the card.
  - **The duplicated color-token system (Part 4) already caused a real, shipped bug**: a
    documented contrast fix landed on `--ea-muted` on 2026-05-27, but its `--eyal-muted`
    mirror's hardcoded fallback value was never updated, silently serving the old,
    non-AA-compliant color at 68 call sites until caught later.
- **Naming convention: mechanically consistent (BEM everywhere), vocabulary-fragmented across
  4+ eras/systems.** `chapters.css` is honest about being a deliberately separate design
  system (a dated, reviewed comment says so) — the newer, better-behaved part of this
  finding. The other fragmentation (terse per-component abbreviations like `cmpc`/`tl`/`st3`,
  inconsistent file-suffix leakage into class names like `.ea-14e-heading`, twinned
  content-type class families in `services.css` that mirror each other 17 ways instead of
  using one component + a modifier) looks like organic drift across authors/eras rather than
  a documented decision. Net effect: a new contributor cannot currently guess which of
  several existing "card" or "accordion" families to reuse for a new instance without
  grepping the whole codebase first — which defeats the point of having a convention.
- **Selector fragility is concentrated almost entirely in one place**: the dead
  `home-front.css`'s home-dashboard component repeats a 3-4-level ancestor chain
  (`body.ea-home-dashboard .ea-home-front ...`) across **97 separate rules** in two files,
  frequently terminating on a bare tag (`h3`, `summary`) rather than a class — meaning any
  future markup change there would silently break styling with no error. Since this file is
  being deleted (Part 1), this specific instance resolves itself; it's named here only
  because the *pattern* (deep chains terminating on bare tags instead of classes) is worth
  avoiding in whatever replaces it.

## Prioritized recommendations

Ranked by (impact × how contained/low-risk the fix is), not just severity:

**P0 — already fully proven safe, zero new investigation needed:**
1. Delete `ea-mobile-nav.css` + `ea-mobile-variants.css` and their enqueue calls. 14.2 KB
   raw / 4.6 KB gzip, 2 fewer requests, sitewide, on evidence already independently confirmed
   before this audit.

**P1 — this audit's own findings, high confidence, contained blast radius:**
2. Delete `home-front.css` and its enqueue (`inc/wave2-stage-b.php:140-143`) — all 660 lines
   confirmed dead by two independent structural reasons plus a live-DOM check.
3. ~~Fix the `/books/` hub-detection bug~~ — **withdrawn, do not do this.** See Part 2:
   `ea_eyalamit_is_books_hub_view()` reading false for `books` is correct and load-bearing;
   changing it would regress the live Chapters page back to the old Wave2 template.
4. Delete the 4 confirmed-zero-reference files: `services.css`, `w2-04-service.css`,
   `w2-10-service.css`, `w2-14e-catalog.css`.
5. Re-verify `testimonials-carousel.css` beyond the single-page sample this audit used, then
   delete if confirmed (same disposition as #2).
6. Remove the `style.css` double-enqueue (drop this theme's own explicit `ea-eyalamit-style`
   call, keep GeneratePress's automatic one) — saves one full duplicate request on every page.
7. Merge the two duplicate Heebo Google Fonts requests into one.

**P2 — needs an owner's decision, not just a delete:**
8. Decide the canonical system for `/en/` (Chapters' `tpl-chapters-en.php`, currently
   winning, vs. the w2-08 content-injection path it silently defeats) and clean up whichever
   loses.
9. Consolidate `ea-blog.css`'s two enqueue handles into one.
10. Reconcile the 4 parallel color-token systems into one, resolving the `--ink`/`--terra`
    vs. `--ea-ink`/`--ea-terracotta` numeric drift specifically — this is the one design-token
    finding with live visual-consistency stakes, not just maintainability.

**P3 — structural/process, worth scheduling deliberately rather than doing opportunistically:**
11. Port the existing, working `--ea-space-*` scale into `chapters.css` and `books-v2.css`
    (currently 0–1.4% adopted there) — same shape of fix as the font-size consolidation,
    and the single biggest remaining design-token win by volume.
12. Add explicit `$deps` (rather than relying on hook-priority ordering alone) for
    `ea-faq-toc`, `ea-blog`, and `ea-w2-05-shop` relative to `ea-chapters`/`ea-wave2-atoms`.
13. Switch to `filemtime()`-based per-file versioning instead of one shared theme-Version
    string, removing the need for today's frequent whole-site manual version bumps.
14. Unify the accordion implementations behind one class family, and pick one book-card
    hover treatment.
15. **Process fix, applies beyond CSS — and note the correction above before applying it.**
    Whenever a page/slug is migrated to a new template (Wave2 → Chapters, or the earlier
    muzza/muzeh → books consolidation), an old `is_page()`/`is_page_template()`/hardcoded-slug
    check keyed to the previous identity is exactly the kind of thing worth grep-auditing
    after the fact — three of this audit's findings share that diagnostic shape. But finding
    such a check does **not** mean it should be updated to match the new identity: for
    `w2-08-en-landing.css` and `home-front.css`, the stale check is genuinely a bug (dead
    code keeps loading because nothing gates it off any more). For `books-v2.css`, the
    stale check is doing its job correctly (it's the thing keeping a superseded Wave2
    template switched off). **On this codebase specifically, per the project's own
    documented Wave2/Chapters dual-template debt: a feature that looks absent is usually
    dead Wave2 code, and a check that looks stale is often what's keeping that dead path
    switched off.** The right process step is: confirm, per case, which side of that a given
    stale check is on (does the *new* identity currently render through Chapters already? —
    if yes, leave the old check alone) — not to mechanically "fix" every one the same way.

**P4 — lowest priority, real but marginal:**
16. Once P1's deletions land, consider merging the small always-loaded foundation files
    (`ea-tokens.css` + `ea-animations.css`, ~11.6 KB raw / 4.4 KB combined) to shave one more
    request.
17. Tokenize box-shadow (currently 0%, ~41 call sites theme-wide) and finish border-radius
    adoption (currently 33.7%, effectively 2 concepts already half-done).

## Scope and limits of this audit

- Four general-purpose research agents ran in parallel, each independently reading code and
  (where relevant) fetching the live staging site to verify claims rather than trust static
  code alone — several findings above were only caught because an agent checked the live
  DOM/HTML rather than stopping at "the enqueue call exists" (the `/books/` bug and the `/en/`
  template race would both have been invisible to a code-only read).
- Live-DOM verification was sampled, not exhaustive: the unused-selector percentages in
  Part 4 (52%/78% of `chapters.css`/`ea-atoms.css` matching nothing) come from **one page**
  (home) — `chapters.css` in particular is a shared component library used across many
  other Chapters templates that weren't sampled, so its true theme-wide unused rate is very
  likely lower than the home-page-only number; `ea-atoms.css`'s number is more concerning
  precisely because it's supposed to be a foundation layer for every Wave2-active view, and
  scored worse (2.4%) on the single busiest page in the site.
- One version-drift caveat consistent with this project's other reports today: the enqueue
  agent noted the live site was serving theme version 1.5.54 while this local checkout's
  `style.css` header read 1.5.52 at time of writing — a small, expected same-day drift given
  how much shipped today, noted rather than chased further.
- No file under `site/` was edited by this audit. Nothing was committed or deployed. This is
  entirely findings-and-recommendations; every fix above is a proposal for whoever owns that
  decision, not an action already taken.
