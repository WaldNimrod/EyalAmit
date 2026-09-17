# WS-3B — DONE: heading structure (bookcard titles + filtered FAQ questions)

Builder: team_10 (this line) · Date: 2026-09-18
Mandate: WS-3B — pages that are invisible to heading navigation (bookcard grid + the
category-filtered FAQ branch). P1. Sources: A11Y-STRUCT-02, A11Y-STRUCT-03.
Report per `_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/00-BRIEF-SHARED-FIX.md`.

Per the shared brief: I am BUILDING this fix, not verifying it. The PASS call belongs to a
different line (Iron Rule #1). I own, and only edited,
`template-parts/chapters/parts/bookcard.php` and `template-parts/blocks/block-faq-list.php`.
No CSS file was touched — §4 below is a request, not an action taken.

## 0. Which side is live (verified before editing)

Fetched all five affected staging pages fresh (`http://eyalamit-co-il-2026.s887.upress.link`,
`curl -k`, real UA) and confirmed every one loaded fully before counting anything:

| Page | HTTP | Bytes |
|---|---|---|
| `/shop/` | 200 | 52,121 |
| `/qr/` | 200 | 72,392 |
| `/faq/` | 200 | 198,061 |
| `/treatment/` | 200 | 100,765 |
| `/books/` (muzza hub) | 200 | 55,966 |

None of these hit the "150-byte truncated response" trap the brief warns about. `bookcard`'s
markup (`.bookcard`, `.bookcard__t`) and the FAQ markup (`.ea-faq-item__question`,
`.ea-faq-item__summary`) appear verbatim in the delivered HTML on all five, matching
`chapters.css` selectors — confirmed live via `inc/chapters/chapters-enqueue.php:19-40`: Chapters'
own `ea_chapters_enqueue_assets()` runs at `wp_enqueue_scripts` priority **100**, deliberately
later than Wave2's `ea_wave2_enqueue_assets()` at priority **28** (`inc/wave2-stage-b.php:145`) —
the file's own comment says why: "so chapters.css wins the cascade over any base sheet still on
the page." I independently re-derived this from the enqueue call order rather than taking the
comment on faith (§4 depends on it being true). All markup in scope here renders through the
Chapters path; Wave2's `ea-atoms.css` equivalents (`.ea-faq-item__question` etc., see §4) are a
real but losing sheet on these pages, not dead code — I did not touch them.

## 1. Root cause, measured

**A11Y-STRUCT-02 (bookcard).** `template-parts/chapters/parts/bookcard.php:57` (pre-fix) rendered
every card title as `<span class="bookcard__t">`. Live heading count:

- `/shop/`: **1** heading total (the H1). 5 cards, 0 headings among them.
- `/qr/`: **1** heading total (the H1). 48 cards, 0 headings among them.
- `/books/`: **4** headings (1 H1 + 3 H2 from unrelated prose sections). 3 cards, 0 headings.

**A11Y-STRUCT-03 (filtered FAQ).** `template-parts/blocks/block-faq-list.php` has two branches.
The unfiltered branch (`:96-127`, used only by `/faq/`) already wraps each question in
`<h3 class="ea-faq-item__question">` inside `<summary class="ea-faq-item__summary">`
(`:100-101` before my edit; now `:115-116`, see git diff — unchanged content, just shifted by my
new comment block). The filtered/view-only branch (`:39-53` before my edit, used only by
`/treatment/` via `treatment-defaults.php:206-211`'s `faqblock` section) put the question text
directly inside `<summary class="ea-faq-item__question">` with no heading element at all. Live:

- `/faq/`: **150** headings (1 H1, 16 H2, 133 H3) — already correct.
- `/treatment/`: **12** headings (1 H1 + 11 H2, including its own "שאלות נפוצות" H2). **22**
  FAQ questions rendered under it with zero heading markup (counted directly from the live
  `<summary class="ea-faq-item__question">` tags in the fetched HTML — this number is not from
  the content bank file, which has a different, unrelated count of 15; the live count comes from
  the `ea_faq` CPT query, confirmed by reading the 22 rendered question strings).

`grep -rln "bookcard\|ea-faq-item\|faq-list" assets/js/` returned **zero** matches in both
directions — neither component has any JS dependency on its current tag names, so this is a
markup-only change with no behavioural risk beyond CSS (§4).

## 2. Fix chosen — derive the heading level, don't hardcode it (per brief item 1)

**bookcard.php.** The part already renders its own `<h2 class="h2 r">` above the grid when the
caller passes `$a['title']` (`:45`, unchanged). So the part already knows, from its own `$args`,
whether it just put an H2 immediately above its cards. New logic
(`template-parts/chapters/parts/bookcard.php:22-40`):

```
$ea_card_level = ! empty( $a['title'] ) ? 3 : 2;
if ( isset( $a['card_heading_level'] ) && is_numeric( $a['card_heading_level'] ) ) {
    $ea_card_level = max( 2, min( 6, (int) $a['card_heading_level'] ) );
}
$ea_card_tag = 'h' . $ea_card_level;
```

I checked all 3 real callers (`shop-defaults.php:31-72`, `qr-hub-defaults.php:37-43`,
`muzza-defaults.php:56-83`) — **none** currently pass `title` into the bookcard section, so on
every live page today cards render as **H2**, directly under the page's H1, which is what the
live H1-only pages need (H3 would have skipped a level — see §6). A future caller that does pass
`title` gets H3 automatically, matching the brief's own worked example. `card_heading_level` is a
new optional escape hatch for a caller nested somewhere this heuristic can't see; not used by any
current caller.

**block-faq-list.php.** Same idea, using an arg this file already parses. The view-only branch
renders its own `<h2 class="h2 r">` (`:57`, unchanged) when `$ea_view_title` is set. New logic
(`template-parts/blocks/block-faq-list.php:28-41`):

```
$ea_view_only_q_tag = ( '' !== $ea_view_title ) ? 'h3' : 'h2';
```

Checked all `faqblock` callers in `inc/chapters/defaults/` (`grep -rn "'part' => 'faqblock'"`):
only two exist. `faq-defaults.php:38-39` passes `array()` (empty args → the unfiltered branch,
`/faq/` — untouched by this fix, see §5 proof). `treatment-defaults.php:206-211` is the **only**
live caller of the filtered branch, and it always sets `'title' => 'שאלות נפוצות'`, so H3 is
correct today. `treatment-eyal-defaults.php`'s own `faqblock` usage is dead code — confirmed via
`inc/chapters/chapters-render.php:163`'s comment ("treatment-eyal-defaults.php נשאר בדיסק ולא
נטען" — stays on disk, not loaded) and `:179-184`'s gate, which only swaps in `treatment-eyal` when
a `?compare=eyal` flag most sessions never set.

## 3. Changes made (file:line)

**`site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/bookcard.php`**
- `:22-40` (new) — heading-level derivation, documented in a comment citing this report.
- `:77` — `<span class="bookcard__t"><?php echo esc_html( $ttl ); ?></span>` became
  `<?php printf( '<%1$s class="bookcard__t">%2$s</%1$s>', $ea_card_tag, esc_html( $ttl ) ); ?>`.
  `$ttl` is still the only text on the line, still passed through `esc_html()` exactly as before
  — no word changed, only the wrapping tag.

**`site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-faq-list.php`**
- `:28-41` (new) — heading-level derivation, documented in a comment citing this report.
- `:61` — `<summary class="ea-faq-item__question"><?php echo esc_html( $item['q'] ); ?></summary>`
  became `<summary class="ea-faq-item__question"><?php printf( '<%1$s
  class="ea-faq-item__question-h">%2$s</%1$s>', $ea_view_only_q_tag, esc_html( $item['q'] ) );
  ?></summary>`. `$item['q']` still the only text, still `esc_html()`'d exactly as before. The
  unfiltered branch (`:96-127`) was **not touched** — see the byte-identical proof in §5.

I deliberately did **not** reuse the class `ea-faq-item__question` on the new inner heading (the
unfiltered branch's h3 does reuse it, on `:116`). Reusing it here would have put
`display:flex;padding:22px 0` (chapters.css, see §4) on the new element *in addition to* the
identical properties already on its parent `<summary>`, which still carries
`class="ea-faq-item__question"` unchanged — doubling the padding inside the row. Giving the new
heading its own class (`ea-faq-item__question-h`) keeps `<summary>`'s box 100% untouched and lets
the heading be a zero-footprint wrapper instead (§4).

## 4. CSS needed — NOT applied, for team_100

I don't own any CSS file (chapters.css is being actively edited by another line right now — its
line numbers shifted under me mid-session, from a `--muted` contrast-token change unrelated to
this fix; cited line numbers below are current as of this measurement). Both of these are
additions only — nothing existing needs to change.

**1. `.bookcard__t` gains two properties** (existing rule, currently
`chapters.css:877`: `.bookcard__t{font-family:var(--serif);font-size:1.5rem;line-height:1.2;color:var(--ink)}`):

```css
.bookcard__t{font-weight:300;text-wrap:wrap}
```

Why: `chapters.css:63` has a sitewide `h1,h2,h3{font-family:var(--hf);margin:0;text-wrap:balance;font-weight:500}`
reset. `.bookcard__t` (a class selector) already beats it on `font-family`, so that stays
correct either way — but `.bookcard__t` never set `font-weight` or `text-wrap`, and neither
`.bookcard`, `.bookcards`, `.bookcard__b`, nor `.sec` do either, so the title's font-weight today
is plain inherited `body{font-weight:300}` (chapters.css:49). The moment the title becomes an
`<h2>`/`<h3>`, the sitewide reset's `font-weight:500` and `text-wrap:balance` apply uncontested
and the title visibly thickens. `margin` needs no addition — the sitewide reset already zeroes it
to the same value a `<span>` has today.

**2. New rule for the filtered-FAQ heading:**

```css
.ea-faq-item__question-h{font:inherit;margin:0;text-wrap:wrap}
```

Why: `<summary class="ea-faq-item__question">` itself is untouched and keeps its existing
`chapters.css:480-481` rule (`display:flex;...;font-family:var(--hf);font-weight:500;font-size:1.08rem;...;margin:0`,
shared with `.ea-faq-item__summary` in the unfiltered branch). But the new *inner* heading has no
class of its own in that rule, so without an override it inherits nothing from its parent for the
properties the `h1,h2,h3` reset (`:63`) already claims (`font-family`, `margin`, `text-wrap`,
`font-weight`) — and **font-size isn't touched by that reset at all**, so the browser's UA default
for a bare `<h3>`/`<h2>` (`~1.17em`) wins. Measured live in a real browser (§5): without this rule
the question text renders at **29px**; with it, **17.28px** — matching the summary's own
`1.08rem`. `font: inherit` is the one declaration that fixes font-family + font-size + font-weight
+ line-height together in one shot (matches parent exactly); `margin:0` is redundant given `:63`
but kept for defensiveness; `text-wrap:wrap` cancels the same `balance` leak as fix 1.

Both rules are additions with a class or ID more specific than the sitewide `h1,h2,h3` type
selector, so they win regardless of where in the cascade they're added — no `!important`, no
reordering needed.

## 5. Verification method — two independent methods, both used

**Method A — actual PHP execution, not by-hand reasoning.** Staging serves the old files, so I
could not deploy and fetch. Instead I wrote a small harness
(`/private/tmp/.../scratchpad/render/harness_bookcard.php` and `harness_faq.php`, this session's
scratchpad) that stubs the handful of WP functions each template calls (`esc_html`, `esc_attr`,
`esc_url`, `wp_kses_post`, `sanitize_title`, `ea_chapters_resolve_img`, `ea_faq_get_categories`,
`ea_faq_query_items`) and actually `include`s the real template file under real PHP 8.5 — this
executes my actual edited file, it does not simulate it. Fed it:
- The real `shop-defaults.php` bookcard args (no title) → emitted `<h2 class="bookcard__t">`.
- A synthetic with-title case → emitted `<h3 class="bookcard__t">` right after its own
  `<h2 class="h2 r">`.
- The real `treatment-defaults.php` faqblock args (title set, `cats:['treatment']`) → emitted
  `<h3 class="ea-faq-item__question-h">` per question, correctly filtered.
- A synthetic no-title filtered case → emitted `<h2>` (fallback), proving the escape hatch works.
- **Regression check**: rendered the *unfiltered* branch (`args=array()`, the real `/faq/` shape)
  through both `git show HEAD:.../block-faq-list.php` (pre-edit) and the edited file, and
  `diff`'d the two outputs — **byte-for-byte identical**. This is stronger than a heading-count
  match: it proves I did not change a single character of the branch `/faq/` actually uses.
- Diffed old-vs-new bookcard output for the real no-title case: the **only** line-level diff is
  `<span class="bookcard__t">...</span>` → `<h2 class="bookcard__t">...</h2>`; every other byte
  (including the Hebrew title text itself) is identical.

**Method B — live in a real browser, against the actual staging cascade.** Since I can't deploy,
I opened the real staging pages in the browser and used JS to reproduce my exact diff client-side
(same tag swap, same new classes) plus injected the exact two CSS rules from §4 as a `<style>`
tag, then measured the live, real-cascade result — this exercises the actual `chapters.css` that
ships today, not my assumptions about it:
- `/shop/`: before 1 heading → after 6 (1 H1 + 5 H2), all 5 real card titles present with correct
  text. Screenshot before/after of the same scroll position: pixel-identical.
- `getComputedStyle()` on a converted title, with my CSS rule toggled off vs on:
  `fontWeight` 500→300, `textWrap` balance→wrap (on) — confirms §4 fix 1 is both necessary and
  sufficient, measured on the real live stylesheet, not inferred.
- `/qr/`: before 1 → after 49 (1 H1 + 48 H2), all 48 real items.
- `/books/` (muzza hub): before 4 (1 H1 + 3 H2) → after 7 (1 H1 + 6 H2), the 3 book titles
  inserted as H2 siblings between the existing "למה את הספרים..." and "חבילת 3 הספרים..." H2s —
  correct document position, no skip.
- `/treatment/`: before 12 (1 H1 + 11 H2) → after 34 (1 H1 + 11 H2 + 22 H3), all 22 real questions
  converted, sequence confirmed as `...H2(עדויות והמלצות) → H2(שאלות נפוצות) → H3×22 →
  H2(מי זה אייל עמית)...` — H1→H2→H3, no skip. Screenshot before/after of the same scroll
  position: pixel-identical.
- `getComputedStyle()` on a converted question, CSS toggled off vs on: `fontSize` **29px→17.28px**
  (17.28px matches the parent `<summary>`'s own computed font-size exactly), confirming §4 fix 2
  is necessary (without it the question text visibly grows) and sufficient (with it, exact parent
  match).

I'm stating explicitly per the brief: I rendered the changed markup in a real browser (Method B),
not only reasoned about the emitted HTML — Method A is the byte-exact executed-output check,
Method B is the live-cascade/visual check. Both agree with each other and with my by-hand cascade
analysis in §4.

## 6. Before / after measurement

| Page | Before | After | Tree | Skip? |
|---|---|---|---|---|
| `/shop/` | 1 (1×H1) | 6 (1×H1, 5×H2) | H1 → H2×5 (siblings) | No |
| `/qr/` | 1 (1×H1) | 49 (1×H1, 48×H2) | H1 → H2×48 (siblings) | No |
| `/books/` | 4 (1×H1, 3×H2) | 7 (1×H1, 6×H2) | H1 → H2("למה...") → H2×3(cards) → H2("חבילת...") → H2("שלושה...") | No |
| `/treatment/` | 12 (1×H1, 11×H2) | 34 (1×H1, 11×H2, 22×H3) | ...→ H2("שאלות נפוצות") → H3×22 → H2("מי זה אייל עמית") →... | No |
| `/faq/` | 150 (1×H1, 16×H2, 133×H3) | **150 — unchanged** (byte-identical render, §5 Method A) | unchanged | N/A |

All five satisfy the brief's acceptance test: `/shop/` and `/qr/` now have more than 1 heading
with a sane, non-skipping tree; `/treatment/` has exactly one H3 per embedded FAQ question with
H1→H2→H3 and no skip; `/faq/` is proven unchanged, not merely unaffected by inspection.

## 7. What I could not measure / where I believe this is incomplete

- **The live site is not fixed.** Everything in §5/§6 is either a local PHP-interpreter execution
  or a client-side DOM/CSS injection against the *current* staging HTML — nothing was saved to
  the server. `/shop/`, `/qr/`, `/books/`, `/treatment/` still serve the pre-fix markup (1, 1, 4,
  12 headings respectively) until team_100 deploys both files **and** applies §4's CSS. Deploying
  the PHP without the CSS would visibly regress card/question typography (§4's measured deltas)
  even though the heading fix itself would be correct — please apply both together.
- **`card_heading_level` and the FAQ's implicit title-driven level are untested beyond the one
  synthetic fixture each in §5.** I'm confident in the logic (it's a two-line ternary/clamp), but
  I have no real caller exercising `card_heading_level` today, so it's unverified against a real
  page — flagging this as new, currently-dead surface area rather than presenting it as more
  proven than it is.
- **Screen-reader/AT behaviour** (VoiceOver/NVDA/JAWS heading-navigation shortcuts specifically)
  was not tested directly — only DOM tag names and computed styles, per the tooling available to
  this line. `<h2>`/`<h3>` are native semantic elements with no ARIA overrides added or removed,
  so I have no reason to expect AT-specific discrepancy, but did not verify it directly.
- **The books hub (`/books/`) is reported for completeness** (the brief's explicit "check every
  page that uses it" for bookcard) but wasn't named in the brief's own acceptance-test list —
  included in case it's useful, not claiming it as a required target.
- I looked for but did not find any other live callers of either component beyond the ones listed
  in §2 (`grep -rn "'part' => 'bookcard'"` / `"'part' => 'faqblock'"` across
  `inc/chapters/defaults/`) — if a page outside that directory also invokes these parts directly
  via `get_template_part`, I did not find it.

## 8. Deploy status

Not deployed. Edits exist only in the local working tree at
`/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` (`git status`: both files modified, nothing
staged, nothing committed — no `git add`/`git commit` was run, per the shared brief). Staging
continues to serve the pre-fix `bookcard.php` / `block-faq-list.php` until team_100 deploys; FTP
is IP-allowlisted regardless, not something this line can or should do. `style.css` Version left
at **1.5.37**, not bumped (team_100's call, coordinated across the wave).
