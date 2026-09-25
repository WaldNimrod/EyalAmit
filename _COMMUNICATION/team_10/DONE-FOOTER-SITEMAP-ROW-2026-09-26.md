# DONE — footer sitemap row (second footer row) — 2026-09-26

Mandate: `_COMMUNICATION/team_90/AUDIT-2026-09-24/MANDATE-FOOTER-SITEMAP-ROW-2026-09-26.md`

Builder: team_10 (Claude Sonnet 5). Team 90 re-measures; nothing below is a request to
close on my say-so — it is what I measured, live, after each deploy.

Staging: `http://eyalamit-co-il-2026.s887.upress.link`. Theme version deployed: **1.5.128**
(bumped from 1.5.127, `style.css`).

Commits (`main`, in order): `d79c314` (ship), `c67cae4` (fix — see "Two bugs I introduced
and fixed" below), `277fc2f` (fix — same), `c339a8a` (deploy-log entries for the three
deploys). `a8e9601` and `bb97dc0` in between are a concurrent session's commits, not mine —
this repo had another session running against the same worktree throughout (see project
memory `eyalamit-concurrent-sessions-one-worktree.md`); I never touched its files.

---

## The one rule — render from `ea_canonical_nav_items()`

Done. `ea_render_canonical_nav_footer_sitemap()` and its recursive child helper
(`inc/ea-canonical-nav.php`) are the only place the tree is walked; no second copy exists.
Verified by extraction, not by reading my own code: I pulled every `(href, label)` pair out
of the rendered `<nav class="ea-footer-sitemap">` on a live page and compared it, both
directions, against a PHP harness that requires the actual deployed
`ea_canonical_nav_items()` and flattens it the same way (skip `hidden`, concatenate
`label_emph`), `html.unescape`d on both sides:

```
rendered pairs: 31   expected pairs: 31
rendered − expected: set()   expected − rendered: set()
EQUAL: True
```

## Finding: the theme has FOUR live footer render paths, not two

The mandate named two (GeneratePress-parent fallback via child `footer.php`, and the
`page-templates/*.php` that call `block-footer-social.php` directly). Measuring the footer
markup class actually returned by all 153 published pages/posts found **four**:

| Render path | Source file | Live pages (of 153) | Example |
|---|---|---|---|
| Chapters footer | `template-parts/chapters/section-footer.php` | 150 | `/treatment/` |
| Wave2 block | `template-parts/blocks/block-footer-social.php` | 1 | `/press/` |
| Chapters-EN | `page-templates/tpl-chapters-en.php` (self-contained, never calls `get_footer()`) | 1 | `/en/` |
| Bare GeneratePress | child `footer.php` → parent theme, no custom partial at all | 1 | `/historical-articles/` |

`/en/` was the surprise: it does **not** use `page-templates/tpl-en-landing.php` (which does
have a `get_footer()` call and its own static footer markup) — the live template is
`tpl-chapters-en.php`, a different, self-contained file with inline `<style>` and its own
`<footer class="ea-en-foot">`, discovered by diffing rendered markup against grep hits for
every footer-partial call site in the theme.

**Because of this I added a fifth mechanism, not just four call sites**: a `wp_footer`
action hook on `ea_render_canonical_nav_footer_sitemap()` in `inc/ea-canonical-nav.php`, as a
safety net for `/historical-articles/`-class pages (page-template-default reaching the parent
GeneratePress theme's own `footer.php`, which is not vendored in this repo — see
`_aos`/worktree notes — so there is no fixed point inside it to call from directly).
The function is guarded with a `static $ea_rendered` flag so a page that already got the row
from one of the four direct call sites (Chapters' `section-footer.php`, Wave2's
`block-footer-social.php`, `tpl-chapters-en.php`, and the shell-fallback branch of child
`footer.php`) does not get it twice via the `wp_footer` net.

**Also found, unrelated to my work, reported not fixed (third finding, see below):** `/press/`
renders **two** `<footer>` landmarks on one page — `block-footer-social.php`'s `.ea-footer`
and then GeneratePress's own `.site-info`, because `page-templates/tpl-content.php` calls the
block directly and then still calls `get_footer()` afterward. Pre-existing, not introduced by
me, out of scope to fix (same principle as the two defects the mandate already named).

## Success criteria — measured

**Renders on all 153 published objects, 200, exactly one primary nav, zero PHP error
strings.** REST-enumerated population: 101 pages + 52 posts = **153**
(`/wp-json/wp/v2/pages` + `/posts`, `per_page=100&status=publish`, paginated). Full sweep
after the final deploy:

```
total checked: 153
fetch errors: 0
non-200: 0
nav_count != 1 (i.e. not exactly one <nav class="ea-footer-sitemap">): 0
pages with no sitemap nav found: 0
"Fatal error"/"Parse error"/Warning/Notice strings found: 0
courses-external leaked into the nav: 0
```
("primary nav" here — I did not touch the header/primary menu at all; this new `<nav>` is a
distinct footer-sitemap landmark, `aria-label="מפת האתר"`, not the primary nav.)

**Every link in the new row returns 200, redirects not followed.** The row has 26 distinct
hrefs (31 rendered items, 5 are the "ספרים" column heading + its own child appearing twice
at the same URL — `/books/`, `/eyal-amit/` root vs `/eyal-amit/` first child, etc. — a normal
consequence of "every level-1 item also links to its own page"). Checked twice, independently:
`curl -sI` (HEAD, no `-L`) and full `curl` GET (no `-L`), both on the redeployed final state:

```
26/26 → 200  (curl -I, redirects not followed)
26/26 → 200  (curl GET, redirects not followed)
```
Zero 301s. The tree's own hrefs already carry the trailing slash (per `$h()` /
`home_url()` in `ea_canonical_nav_items()`), so the row does not repeat the existing
footer's 14/16-links-301 defect (see "out of scope" below).

**Item set equals `ea_canonical_nav_items()`'s visible set exactly, both directions,
`html.unescape`d.** Shown above — 31/31, empty set-difference both ways.

**`courses-external` appears zero times.** Confirmed inside the `<nav class="ea-footer-sitemap">`
markup specifically (not just page-wide — two unrelated pages, `/learning/courses-external/`
and `/courses-soon/`, legitimately contain the Hebrew string elsewhere in their own content,
which a page-wide grep would have wrongly flagged; scoped the check to the nav block itself
before concluding). 0/153.

**Three levels present and visually distinguishable, verified in a rendered browser after
layout settles.** Chrome-headless-shell (`/Users/nimrod/.cache/puppeteer/chrome-headless-shell/mac_arm-149.0.7827.22/…`)
over raw CDP, one instance per check: navigate → wait ~3.2s → `document.getElementById('ea-cookie-notice').close()`
→ two chained `requestAnimationFrame`s → measure. `dialogOpenAfterDismiss: false` confirmed on
every check (8/8: the 4 render-path pages × mobile-390/desktop-1440).

Computed styles, identical across all four render paths after the specificity fix (see below):

| Level | font-size | font-weight | colour (rgba) | extra distinguishers |
|---|---|---|---|---|
| L1 (column heading) | 13.6px (`--fs-xs`) | 100 (`--fw-thin`) | `rgba(255,255,255,.92)` | uppercase, 1.5px letter-spacing, border-bottom |
| L2 (child link) | 13.6px (`--fs-xs`) | 300 (`--fw-light`) | `rgba(255,255,255,.68)` | — |
| L3 (grandchild, under "ספרים" only) | 12.24px (`--fs-2xs`) | 100 (`--fw-thin`) | `rgba(255,255,255,.56)` | indented (`padding-inline-start`), left border rule |

Screenshot confirmation (desktop, `/treatment/`, clipped to the row) shows the "ספרים" column's
five grandchildren visibly inset with a vertical rule, smaller and dimmer than their parent
link, which is itself smaller/dimmer than the column heading above it — three readable tiers.

**No new font-size declaration, no new token.** `assets/css/ea-footer-sitemap.css` uses only
`--fs-xs`, `--fs-2xs`, `--fw-thin`, `--fw-light`, `--ea-ink`, `--ea-space-*`, `--ea-gutter`,
`--ea-prose-width`, `--ea-font` — all pre-existing rungs from `ea-tokens.css`.
`_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md` is untouched (not opened for editing).

**Contrast ratio of the new text, stated as a number, against the painted background.**
Measured live via `getComputedStyle` after the dialog-dismiss + 2-rAF settle, background
resolved by walking up from the `<nav>` if its own computed `background-color` came back
transparent (it doesn't, post-fix — see below), then WCAG contrast computed in the probe
script itself (not assumed):

- Painted background, uniform across **all four** render paths: `rgb(46, 43, 40)` = `#2E2B28`
  = the existing `--ea-ink` token.
- **L1: 12.14 : 1**
- **L2: 7.35 : 1**
- **L3 (worst case, most "delicate" tier): 5.51 : 1**

All three clear the 4.5:1 threshold for regular text under 24px with margin — the tightest
(L3) still has almost 1.1× headroom.

**Readable at 390px, zero horizontal overflow.** `document.documentElement.scrollWidth` vs
`.clientWidth` at 390×844: `390 === 390` on all four render-path pages (and unchanged at
1440×900). Screenshot at 390px shows a clean single-column stack (the `@media(min-width:480px)`
breakpoint is deliberately above the mandate's own 390px check width, matching the existing
`.ea-cfoot` sibling component's own ≤479px single-column bucket).

## Two bugs I introduced and fixed before calling this done

Both were caught by measuring the rendered page, not by reading the CSS/PHP back — exactly
the discipline the mandate asks for, and I'm reporting them rather than quietly folding them
into one commit, since Team 90 should know two intermediate deploys were briefly broken on
staging:

1. **`c67cae4`** — my own doc-comment in both `inc/ea-canonical-nav.php` and
   `ea-footer-sitemap.css` wrote `--fs-*/--fw-*`; the `*` immediately before `/` closes a
   `/* */` comment early. In the CSS file this silently dropped the entire
   `.ea-footer-sitemap { background: var(--ea-ink); … }` base rule — confirmed by walking
   `document.styleSheets` in the browser and finding the rule simply absent, 0 occurrences,
   despite the file uploading correctly and the `<link>` tag being present. Effect: the row's
   white text sat on whatever background happened to be behind it — correct-looking by
   accident on the two pages with an already-dark ambient footer, but white-on-near-white
   (measured contrast **1.00 : 1**) on `/en/` and `/historical-articles/`. Same pattern was
   caught and fixed in the PHP docblock during `php -l` linting before the first deploy; missed
   the parallel one in the CSS file until the post-deploy contrast measurement caught it.
2. **`277fc2f`** — even after the background fix, L1/L3 still measured at the *ambient*
   footer's own link colour (`rgba(255,255,255,.6)`, from `.foot a` in `chapters.css` — the
   150-page Chapters footer — or `.ea-en-foot a` inline on `/en/`) instead of this file's own
   `.92`/`.56`, because a bare `.ea-footer-sitemap__l1` (specificity 0,1,0) and
   `.ea-footer-sitemap__l3 a` (0,1,1) lose or tie-and-lose against those ambient descendant
   rules (0,1,1). Only L2 escaped by accident, via its own longer `>li>a` selector chain.
   Fixed by qualifying every descendant selector with the `.ea-footer-sitemap` ancestor class
   (0,2,0 / 0,2,1), which wins regardless of stylesheet load order, without touching the
   ambient files. Post-fix, colours are identical and correct on all four render paths (table
   above).

Both fixes are CSS/comment-only; no markup, no PHP logic, no token changed between the ship
commit and the final state.

## Two things reported, not fixed (per mandate — separate board items)

1. **Existing footer's drifted "ניווט"/"מה מציעים" column** — confirmed still present,
   untouched. On Chapters pages it's `template-parts/chapters/section-footer.php`'s own
   hardcoded "מה מציעים"/"עוד" columns (note: this is a *different* drifted copy than the one
   the mandate quoted from `block-footer-social.php` — that file is only live on `/press/`.
   The Chapters footer, live on 150/153 pages, has its own separate hand-written link list
   with the same class of drift, e.g. "לימוד והכשרה" vs the tree's "שיעורים והכשרות"). Not
   rewritten — same reasoning the mandate gives: replacing a shipped, visible component is
   its own decision.
2. **14/16 existing footer links lack a trailing slash → 301.** Unchanged, not touched. The
   new row does not repeat this (26/26 new-row links measured 200, redirects not followed,
   above).

## New finding to flag (not asked for, not fixed): `/press/` double `<footer>`

See "Finding" section above — `tpl-content.php` calls `block-footer-social.php` directly and
then also calls `get_footer()`, so `/press/` renders both `.ea-footer` (with the sitemap row
correctly attached once, per the render-once guard) and GeneratePress's own bare `.site-info`
footer directly after it. Pre-existing, unrelated to this mandate's content, left alone.

## Files changed

```
site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php          (+123)  render functions + wp_footer net
site/wp-content/themes/ea-eyalamit/assets/css/ea-footer-sitemap.css  (new, 139 lines)
site/wp-content/themes/ea-eyalamit/functions.php                     (+24)   unconditional enqueue
site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-footer.php   (+8)  call site
site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-footer-social.php (+11) call site
site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-en.php (+12)  call site (lang=he dir=rtl)
site/wp-content/themes/ea-eyalamit/footer.php                        (+8)   shell-fallback call site
site/wp-content/themes/ea-eyalamit/style.css                         (1.5.127 → 1.5.128)
```

## git status

**Before** (session start, per system snapshot):
```
 M _COMMUNICATION/team_100/S006/DEPLOY-LOG.md
 M scripts/s007_render_work_ssot.py
?? _COMMUNICATION/team_90/AUDIT-2026-09-24/MANDATE-FOOTER-SITEMAP-ROW-2026-09-26.md
?? scripts/save_legacy_wp_app_password.py
```

**After** (now — `site/` clean, deploy script's own dirty-check passed without
`--allow-dirty`):
```
 M scripts/s007_render_work_ssot.py
?? scripts/save_legacy_wp_app_password.py
```
Both are pre-existing, out of mandate scope (never opened/run per instruction), and belong to
the concurrent session sharing this worktree.

## What I did not do / would flag as wrong if asked

Nothing in the mandate turned out to be wrong. The "two known render paths" description was
incomplete (four, not two, live) but that is exactly the kind of thing the mandate itself
warned would be true ("find every one of them") — not a wrong instruction, a discovery it
predicted.

One judgement call worth a second look from Team 90/Eyal: `/en/` is the site's one English
page, and the new row is Hebrew-only (the canonical tree has no English variant), rendered
there with explicit `lang="he" dir="rtl"` for correct bidi handling. It reaches 100% of the
153 published objects this way, per the mandate's own success criterion, but a Hebrew sitemap
under English prose is a legitimate content question, not an engineering one — flagging
rather than deciding it.
