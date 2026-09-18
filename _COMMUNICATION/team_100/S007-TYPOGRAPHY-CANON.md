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
--fs-xs      0.85rem       13.60px    x0.80   labels, form controls, footer links
--fs-2xs     0.765rem      12.24px    x0.72   tags, toggles, fine print
--fs-3xs     0.690625rem   11.05px    x0.65   eyebrows, column titles
```

Weights:

```
--fw-h1 300   --fw-h2 400   --fw-h3 600   --fw-nav 400   --fw-body 300   --fw-sub 300
```

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

For mobile (phase 3): **re-declare the same tokens inside a media query.** Do not add
breakpoint `font-size` rules to components — that is what tokens are for. Two
`.ea-edhero__title` breakpoint overrides in `ea-blog.css` are annotated as belonging to that
phase; they are the pattern to replace, not to copy.

## 6. The only declarations deliberately NOT on a rung

Each is annotated in place with its reason. **A fourth unexplained one is a defect.**

- `.nav__caret` — `.6em`, a glyph sized off its parent, not a type rung.
- `.testi-mq__btn` — a carousel arrow glyph, not text.
- CF7 row label — `font-size:0`, hidden on purpose (Eyal asked for the separate labels to go).

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
