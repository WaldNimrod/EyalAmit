---
id: S007_TYPOGRAPHY_CANON
schema_version: aos_v1_team_messaging
type: CANON (team_100)
status: AUTHORITATIVE — supersedes every earlier typography figure in this repo
authority: team_00, 2026-09-18 — «תנעל את הסולם לפי הצירוף האחרון»
locked_at: theme 1.5.56
---

# Typography and CSS canon

**This file is the only authority on type sizing in this theme.** Every other document that
carries a font-size number is history. If a figure anywhere disagrees with this file, this
file wins and the other document is stale — §7 lists the specific numbers that are dead.

**Do not quote a number from here as *current* without re-deriving it either.** Read the
token block in `assets/css/ea-tokens.css`; this file explains it, the CSS *is* it.

---

## 1. The scale

**Body is the anchor. Every rung is a ratio of it.** That is team_00's model, not a
convention: «טקסט רץ — מבקש להתחיל מלנעול את הגודל שלו… ומהגודל הזה נגזור את כל האחרים».

Anchor: **17px body**, shipped as `1.0625rem` against a 16px root.

Five rungs are **team_00's own approved numbers**, read off the combination he approved in
the live preview (`?ty=17&nav=1.08&h1=2.6&h2=1.45&h3=1.1`):

```
--fs-body    1.0625rem     17.00px    x1.00   running text — THE ANCHOR
--fs-nav     1.1475rem     18.36px    x1.08   main menu and submenu
--fs-h3      1.16875rem    18.70px    x1.10   sub-heading inside a section
--fs-h2      1.540625rem   24.65px    x1.45   section titles
--fs-h1      2.7625rem     44.20px    x2.60   page hero titles
```

Seven more are **derived** to cover roles his combination does not name:

```
--fs-display 2.125rem      34.00px    x2.00   pull quotes, statement headings
--fs-h4      1.328125rem   21.25px    x1.25   card and sub-block titles
--fs-lead    1.221875rem   19.55px    x1.15   hero sub-headings and ledes
--fs-sm      0.95625rem    15.30px    x0.90   secondary text, buttons
--fs-xs      0.85rem       13.60px    x0.80   labels, footer links
--fs-2xs     0.765rem      12.24px    x0.72   tags, toggles, fine print
--fs-3xs     0.690625rem   11.05px    x0.65   eyebrows, column titles
```

**Authorised exception, Wave 1 A8, 2026-09-25, theme 1.5.127.** One new rung,
form controls only:

```
--fs-field   1rem          16.00px    x0.94   CF7 text, select, textarea
```

`--fs-xs` stays 0.85rem. It is still used for labels, footer links, and the
other roles that do not receive keyboard focus as a text field. iOS Safari
zooms the page when a focused field is under 16px. 16px is `1rem` on the 16px
root, so the rung is `1rem`, not a `px` declaration. It is applied only on
`.wpcf7-form-control.wpcf7-text`, `.wpcf7-select`, and `.wpcf7-textarea` in
`ea-atoms.css`. The canon comment that listed `--fs-xs` as «labels, form
controls, footer links» already separated those roles; this rung is that
separation, recorded here in the same change as the token.

Weights:

```
--fw-h1 300   --fw-h2 400   --fw-h3 600   --fw-nav 400   --fw-body 300   --fw-sub 300
```

Since 1.5.60 those six are **aliases** onto an eight-value weight scale, not literals:

```
--fw-thin 100  --fw-xlight 200  --fw-light 300  --fw-regular 400
--fw-medium 500  --fw-semibold 600  --fw-bold 700  --fw-xbold 800
```

Every `font-weight` in every live child-theme sheet points at one of those eight. The Wave2
`--ea-fw-*` family is aliased onto the same scale. **Change a weight token, never a
declaration** — the same rule as sizes.

**`--fw-h3` is 600, not the 500 in that URL.** «H3 יותר כבד» came after it. This is the one
deliberate departure from the approved combination and it is intentional.

## 2. Why `rem` and not `px`

The approved numbers are pixel numbers. **They are not shipped as pixel units**, because a
`px` font-size does not follow the reader's own font-size setting and this site publishes a
statement promising text can be doubled. Each rung is the approved pixel value over the 16px
root: identical rendering at default settings, and resize verified as an exact ×2.

**Never convert a rung back to `px` to "match the approved number". The rem value IS the
approved number.**

## 3. Where the tokens live, and why not in `chapters.css`

They live in **`assets/css/ea-tokens.css`**, which is enqueued on **every front-end view**
(`ea_eyalamit_enqueue_type_tokens_everywhere`, `functions.php`, priority 3).

`chapters.css` is gated on `ea_chapters_is_view()`. Defining the rungs there and consuming
them in an unconditional sheet collapses the whole `font:` shorthand — a shorthand with one
unresolvable `var()` fails **whole**, not per-property. This was moved deliberately; do not
move it back.

**Six published pages render outside every Wave2 template whitelist** — `/services/`,
`/shows-heritage/`, `/historical-articles/`, `/thank-you/`, `/courses-soon/`,
`/learning/courses-external/`. Before 1.5.55 they had no tokens at all. That is why the
enqueue is unconditional.

## 4. The three layers, in cascade order

**Layer 1 — the base floor**, in `ea-tokens.css`, at specificity **`0,0,2`** (`body h1`, not
`h1`). It exists so a page with no component CSS still lands on the scale.

**It must stay at 0,0,2.** GeneratePress's `main.min.css` ships `h1{font-size:42px}` and
`h2{font-size:35px}` at `0,0,1` and loads *after* this file. Shipped at `0,0,1` the floor
was completely inert — the token sat unused in the cascade behind the wrong number. `0,0,2`
beats the parent theme regardless of load order and still loses to every class-based rule
in this theme (`0,1,0` > `0,0,2`), so no component design is affected.

**The floor has a second rule, and it is not optional: form controls.**
`html button, html input, html select, html textarea { font-family: var(--ea-font) }`.
A `<button>` does **not** inherit `font-family` — the UA sheet gives it its own, and
GeneratePress then sets `body,button,input,select,textarea{font-family:-apple-system,…}`.
A same-element rule beats an inherited value at any specificity, so `html body` cannot
reach a control no matter how specific it is. This omission has produced **four** separate
live defects here in three days: the carousel arrows (1.5.61), six whole pages (1.5.65),
the lightbox chrome (1.5.66), and then 224 controls the first three fixes did not touch —
the chapters burger on nearly every page, the QR play overlay (**visible at desktop on 42
URLs**), the Wave2 drawer and the GeneratePress toggle (1.5.68). The floor sets **family
only**; size and weight on a control belong to its component.

**If you add a control that renders text, set its font-family explicitly.** Every scan that
filters for elements with direct text is blind to most of them, which is how 224 of them
survived a 157-URL, 13,412-element sweep.

**Layer 2 — the nine composite `font:` tokens**, also in `ea-tokens.css`. These carry size
*inside* the `font:` shorthand, which is why no search for `font-size` can see them and why
that file reported zero declarations while holding an entire second scale. 51 rules across
six stylesheets consume them. They are now written in rungs, so all 51 follow the scale
without touching 51 rules.

**Layer 3 — component rules**, class-based, in `chapters.css` / `ea-atoms.css` / the rest.
Includes the content scope — `.intro-body`, `.prose`, `.dd__body`, `.ea-faq-item__answer` —
which sizes the bare `h2/h3/h4/li/blockquote` that appear inside Eyal's own prose markup.
Wired at the **container**, so prose written later inherits the scale automatically.

## 5. How to change the scale

**Change the token. Never a declaration.** One edit in `ea-tokens.css` moves the whole site.

For mobile: **re-declare the same tokens inside a media query.** Do not add breakpoint
`font-size` rules to components — that is what tokens are for. Two `.ea-edhero__title`
breakpoint overrides in `ea-blog.css` are annotated as belonging to that phase; they are the
pattern to replace, not to copy.

**That media query now exists**, added 2026-09-20 at `@media(max-width:640px)` in
`ea-tokens.css`. It is the only one in that file and there should never be a second — a
second set of mobile rungs somewhere else is the beginning of a second scale, which is the
failure this canon was written to end.

**What it changes, and what it deliberately does not.** Only the large end moves, and it moves
toward the body anchor: h1 2.60→1.90, display 2.00→1.60, h2 1.45→1.32, h4 1.25→1.18,
lead 1.15→1.10, h3 1.10→1.06 (ratios over the 17px body). **`--fs-nav` and everything from
`--fs-body` down are unchanged.** Body text never shrinks on a phone — it is already the
anchor and already the smallest comfortable reading size — and `--fs-nav`, `--fs-sm`, `--fs-xs`
size labels and secondary text, where shrinking works against the 44px touch-target floor.
Form fields use `--fs-field` (16px) and are not part of that shrink.

**Measured at 390×844, before and after:** the home hero title went from 248px tall over five
wrapped lines to 145px over four; the blog post title from 347px over seven lines to 217px
over six. **At 200% text**, which the site's published accessibility statement promises, the
home H1 block went from 990px to 579px and the blog post's from 1485px to 796px.

**640px, not 860px, on purpose.** 768 and 720 are tablet widths where the desktop scale still
has room, and the TOC's 860px breakpoint is about layout. A rung set is not a layout
breakpoint; do not align them for tidiness.

## 6. The only declarations deliberately NOT on a rung

Each is annotated in place with its reason. **A sixth unexplained one is a defect.**

- `.nav__caret` — `.6em`, a glyph sized off its parent, not a type rung.
- `.testi-mq__btn` — a carousel arrow glyph, not text.
- CF7 row label — `font-size:0`, hidden on purpose (Eyal asked for the separate labels to go).
- `.ea-books-hub-card__cta a::after` and `::before` — `0.85em` arrow glyphs on
  pseudo-elements. **Listed but NOT verifiable as live:** the cross-engine re-check traced
  `.ea-books-hub-card__cta` to a template gated on slugs that all 301 before rendering, so
  no DOM node exists anywhere to confirm they compute off-rung. They are annotated in the
  CSS and left alone. **If that template ever gets a live route, treat them as unproven and
  re-measure rather than assuming this entry vouched for them.**

> **This list was three when first written and the cross-engine gate falsified that.**
> `.ea-topnav__caret` was a fourth, undocumented, at `0.7em` resolving to 8.568px — it is
> now on `--fs-3xs` rather than becoming a fifth exemption. The two `books-v2.css` arrow
> glyphs are genuine and were simply missed. Treat any new `em` or literal size as a defect
> until it appears in this list.

## 6a. Scope of "no live stylesheet carries a hardcoded size"

**Read it as "no live CHILD-THEME sheet."** That is what the claim was tested against and it
holds. It is **false** of the page as a whole: GeneratePress's `main.min.css`, `wpa-style.css`,
Fluent Forms and CF7 all ship live hardcoded sizes. The child-theme token wins the cascade
wherever it was checked — see §4 layer 1 for why that needed `0,0,2` to be true — but do not
repeat the claim in its unqualified form.

**That claim is about LIVE sheets only.** Four stylesheets in `assets/css/` have **no enqueue
call anywhere in the codebase** and are not wired: `services.css`, `w2-04-service.css`,
`w2-10-service.css`, `w2-14e-catalog.css` (its renderer was deleted in an earlier cleanup and
the CSS never followed). They are dead, not exempt. If any is ever re-enqueued it must be
wired first. `theme-shell-fallback.css` IS conditionally live — it loads when the parent
GeneratePress stylesheet is unreadable — and **is** wired.

## 7. Superseded — these numbers are DEAD, do not act on them

Earlier documents in this repo state these. They were true when written and are not now.

- **"the menu is 12.48px designed / 12.8px live"** — the menu is **18.36px**. team_00 raised
  it deliberately; it is not a correction to make.
- **"body is 18px"** — body is **17px**.
- **"242 / 263 / 261 hardcoded `font-size` declarations"** — all live declarations are on
  rungs. Those counts described the pre-lock state.
- **"76 live / 185 orphan"** — the orphan classification was wrong for two files:
  `ea-mobile-nav.css` styles the live footer on Wave2-shell pages, and `books-v2.css` loads
  on book *detail* pages. Both are wired.
- **"every H1 renders in Frank Ruhl Libre"** — true until 1.5.41, false since. Hero H1 is
  Heebo, on team_00's instruction. The serif remains on quote/display/book-title elements.
- **"the h3 dial moves nothing"** — true of the preview tool before the content scope was
  wired. Prose `h3` is a real rung now.
- **`mu-plugins/ea-type-preview-staging.php`** is scaffolding and overrides these tokens with
  `!important` when `?ty=` is in the URL. It is **not** the scale. Delete it on team_00's
  word — and note the FTP deploy **never prunes**, so deleting it locally does not remove it
  from staging.

## 8. Traps that produced confident wrong answers here

Full list: memory `eyalamit-qa-harnesses-that-fail-open`. The four that bite typography work:

1. **Searching the wrong property returns a clean zero.** Check `font-size`, `font:` and
   `font-weight` separately.
2. **A stylesheet list read off two pages is a claim about two pages.** The site is 157 URLs
   in **16 distinct CSS-plus-template families** — list at
   `_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv`. Sweep one of each.
3. **A declaration being present proves nothing.** Check computed values (see §4, layer 1).
4. **Spacing-sensitive greps lie.** `font-size:var(` found zero where `font-size: var(` had
   fourteen.


## 9. Known gaps, deliberately out of scope for the size lock

These were surfaced by the cross-engine gate and are **not** defects in the size scale.

- ~~207 live `font-weight` declarations off-token~~ — **CLOSED 2026-09-18 at 1.5.60**, on
  team_00's instruction «משקלים קודם - ואז מובייל». 214 declarations across eleven live
  sheets now point at an eight-value weight scale in `ea-tokens.css`; the six role weights
  he approved are aliases onto it rather than literals. **Zero visual change** — every
  declaration kept its own number. A second weight family (`--ea-fw-*`, declared in
  `style.css`, consumed seven times there) was pointed at the same scale and its duplicate
  definitions removed.
  **What is still open is the design question, not the plumbing:** the team_35 design used
  nothing above weight 400, and the rendered site does exceed that. Measured live — home
  page 73×300, 43×400, **32×500, 7×700**; `/press/` 184×300, 8×200, 1×100, 6×400, 6×500,
  1×700; `/books/kushi-blantis/` 101×300, 22×400, 13×500, 3×700. So the divergence is a
  short, concrete list of elements at 500 and 700, not a sitewide restyle — and it is
  team_00's call whether to bring them down.
- **`/2228-2/`** — one of the 54 posts skips `h1` → `h3` in its own authored content. Real
  and live, found only because a re-check happened to sample a different post than the two
  earlier passes did. A content item, not a template bug; nothing in the theme causes it.
  Worth remembering that two independent passes over 54 posts sampled 2 each and both
  missed it.


## 10. Font FAMILY — the third axis, and the one nobody had scanned

team_00 found this himself on the home page: «נשימה היא הבסיס להכל - חורג מהטיפוגרפיה».
That element is `.bleed__q`, and it is not a size problem — it renders in **Frank Ruhl Libre**
while the other 33 text selectors on that page render in **Heebo**. Every scan on this
milestone had checked size; two also checked weight; **none checked family.**

**Four families are live, not one.**

- **Heebo** — `--hf`, `--bf`, `--ea-font`. All three are the same string; the
  heading/body distinction those token names imply is fictional.
- **Frank Ruhl Libre** — `--serif`, on six `chapters.css` rules: `.tl__y`, `.bleed__q`,
  `.st3::after`, `.shstep__dot span`, `.bookcard__cover .ph`, `.bookcard__t`. Its comment
  used to say «hero + years only» and that stopped being true at 1.5.41, when the hero moved
  to Heebo on team_00's instruction. Comment corrected.
- **Suez One** — `--display`, a third family on six more: `.fstep__num`, `.fstep__t`,
  `.mag-spread__fig figcaption b`, `.mag-list__n`, `.mag-list__t`, `.btile__t`.
- **Rubik** — `--ea-font-sans`, six `style.css` rules, plus a literal in
  `theme-shell-fallback.css`. Earlier reports called Rubik "fetched and unused". It is used.

**Fixed at 1.5.61 because it was unambiguous:** the two carousel-arrow `<span>` elements
inside `.testi-mq__btn` set **no font-family at all** and fell through to `-apple-system` —
so those glyphs rendered in whatever font the visitor's OS supplied, differently per device.
That is not a design choice, it is an omission.

**NOT fixed, because it is a design decision and not ours:** whether Frank Ruhl Libre and
Suez One remain as accents. Both are deliberate-looking, both are applied consistently within
their components, and collapsing them to Heebo would change the look of the timeline, the
pull quotes, the book titles and the whole magazine/feature vocabulary. **team_00's call.**

Full per-page evidence: `_COMMUNICATION/team_10/S007-M05/` — a scan of **all 157 URLs**, not
a sample, on all three axes. Sampling was retired as a method at this point in the milestone
because three consecutive sampled passes each missed something the next one found.
