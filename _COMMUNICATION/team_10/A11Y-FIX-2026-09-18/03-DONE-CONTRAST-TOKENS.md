# WS-3B — DONE: contrast cluster, the "muted" colour system

Builder: team_10 (this line) · Date: 2026-09-18
Mandate: WS-3B — `--eyal-muted` undefined (falls back to a pre-AA-fix colour) and
chapters.css's own `--muted` fails against both of its standard backgrounds. P1.
Report per `_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/00-BRIEF-SHARED-FIX.md`.

Per the shared brief: I am BUILDING this fix, not verifying it. Everything below is my
own measurement to convince myself the fix is real before handing it off — the PASS call
belongs to a different line (Iron Rule #1). Files touched: only the three I own —
`assets/css/ea-tokens.css` (read, **not edited** — see §3.3), `assets/css/chapters.css`,
`assets/css/books-v2.css`. Nothing else. Not committed, not deployed.

## 1. Token map — every "muted" / "ink" token, file:line, live-or-dead

Verified "live" by fetching staging (`http://eyalamit-co-il-2026.s887.upress.link`,
TLS-invalid by design) — home page + 15 inner pages spanning every distinct page
template reachable from the home nav (`/`, `/books/`, all 3 book detail pages
`/books/{kushi-blantis,tsva-bekahol,vekatavta}/`, `/method/`, `/treatment/`,
`/eyal-amit/`, `/eyal-amit/mokesh-dahiman/`, `/blog/`, `/faq/`, `/didgeridoos/`,
`/sound-healing/`, `/learning/workshops/`, `/lessons/`, `/shop/` — all HTTP 200,
52–198KB, none truncated) — grepped the delivered HTML for each class, then
cross-checked the ones that mattered with a real `document.querySelectorAll` in the
Browser pane (DOM-level, not just markup-level) and a PHP-source grep for every
template file in the theme.

| Token | Value | Defined at | Owning system | Live? |
|---|---|---|---|---|
| `--ea-muted` | `#6F635A` | `ea-tokens.css:28` | D-14 / Wave2 (loaded on every "Wave2 active view" template — home, service, content, contact, faq, book-detail, shop, qr, blog, en-landing: `inc/wave2-stage-b.php:61-79`) | **LIVE.** Already AA-fixed 2026-05-27 (file's own comment). Confirmed consumed by `ea-blog.css:30-32` (`.ea-blog-filter__item{…color:var(--ea-muted);}`, real class in `page-templates/tpl-chapters-blog-archive.php:66`, live on `/blog/`) and by `ea-atoms.css`/other w2-*.css files (not exhaustively re-audited — out of my file ownership; spot-checked one real consumer as proof of life). |
| `--ea-ink` (alias `--ea-text`) | `#2E2B28` | `ea-tokens.css:12,19` | D-14 / Wave2 | Token itself live (same gate as above). Not flagged as failing by this mandate; sanity-checked anyway — see §2. |
| `--ea-text-muted` | `var(--ea-text-body)` = `#5A3826` | `ea-tokens.css:20-21` | D-14 / Wave2 | Live (alias, already the AA-fixed body-text colour). Consumed by `w2-07-heritage.css:60,97`, `w2-05-shop.css:211` — not re-audited (not owned by this line; not named by this mandate). |
| `--muted` (local, **not** `--ea-*`) | `#8C775F` → **fixed to `#786651`** | `chapters.css:18` (now `:29` after the fix) | Chapters, self-contained (own `:root`, does not reference `ea-tokens.css` names) | **Mixed.** See §1a below — this is the mandate's actual target, and it's more nuanced than "live" or "dead." |
| `--ink` (local, **not** `--ea-*`) | `#2f2013` | `chapters.css:18` | Chapters | Token live (loaded on every Chapters view + every Wave2-active-view page, since `chapters.css` is enqueued whenever `ea_chapters_is_view()`/`ea_chapters_is_blog_view()` is true — `inc/chapters/chapters-enqueue.php:19-58` — and the home page satisfies both gates at once). Consuming selectors (`.h2`, `.tcard__q`, `.feat__t`, `.dd__t`, etc.) are a mix of live and dead per-selector, same as `--muted` — see §2 for why this mandate doesn't need to touch it either way. |
| `--ea-home-muted` | `#6f6f6f` | `style.css:92` | A **third**, separate "Wave2 dashboard" fragment, scoped under `body.ea-home-dashboard` | **DEAD.** `ea-home-dashboard` never appears as a body class on any of the 16 pages fetched (home included — the home page's real body class list is `rtl home wp-singular … ea-wave2-shell ea-m4-polish ea-chapters`, no `ea-home-dashboard`). Its entire consumer tree (`.ea-home-front`, `.ea-home-banner`, `.ea-home-hero-overlay`, `.ea-home-hero-meta` — `style.css:150,169`, `home-front.css:254-409`) also returns zero DOM matches. **Not owned by this line** (`style.css`, `home-front.css` are outside my file list) — flagging per item 1's own instruction ("a token that only feeds dead CSS is not worth changing; say so") rather than touching it. |
| `--eyal-muted` | *(undefined anywhere)*, hardcoded fallback `#a8a19b` → **fixed to `var(--ea-muted, #6F635A)`** | 4× in `books-v2.css` (now `:480,:864,:904,:912`) | Orphaned — see §1b | **DEAD**, all 4 sites, confirmed multiple ways — see §1b. |

That's the audit's "three unrelated muted colours" (`--ea-muted`, chapters' `--muted`,
`--ea-home-muted`) plus the orphaned `--eyal-muted` reference, and "two unrelated ink
values" (`--ea-ink`, chapters' `--ink`) — all accounted for, file:line, above.

### 1a. `--muted` (chapters.css) — not simply "live" or "dead": the class is dead, the
token is live via a sibling that doesn't use the class

The three named consumers in the mandate text — captions, blog meta, a disclaimer —
map to `.cap` (`chapters.css:322`), `.feat__meta`/`.post__meta` (`:342,:355`), and
`.disc__t` (`:500`). **All four are dead**: `class="cap"`, `feat__meta`, `post__meta`,
`disc__t` — zero matches, PHP source (whole theme) and all 16 live pages. `.feat`/`.post`
turn out to be a blog-card design ported from `flow/chapters.css` (file header,
`chapters.css:2`) that the real blog build superseded with
`template-parts/blocks/block-blog-card.php` + `ea-blog.css`'s own classes
(`tpl-chapters-blog-archive.php:78`, confirmed live under §1's `.ea-blog-filter__item`
check) — never wired up. `.tcard`/`.btile`/`.disc__t` are the same story: zero PHP call
sites theme-wide, zero live DOM matches.

**But the token itself is not dead**, via two paths the class-name search misses:

1. **`template-parts/chapters/parts/mokesh-portrait.php:53`** sets `color:var(--muted)`
   as an **inline style** on a `<figcaption>`, not through `.cap` — its own comment
   explains why: *"Styling is inline rather than a new CSS rule — no generic figcaption
   rule exists in the theme, and inline style is the established pattern in these
   parts."* This is genuinely live: fetched `/eyal-amit/mokesh-dahiman/`, HTTP 200,
   99847 bytes, and confirmed both the inline style string and (in a real Chrome tab,
   not curl) `getComputedStyle` on the actual DOM node — see §5.
2. **`chapters.css:410`**, `.dd__item:not(.dd__item--active) .dd__tag{background:var(--muted)}`
   — `--muted` as a **background fill**, not text colour. `.dd__tag`/`.dd__item` (the
   drill-down comparison accordion) are confirmed live on `/treatment/` and `/lessons/`
   (`template-parts/chapters/parts/dd.php`; also found live by DOM query — 3 real
   `.dd__tag` elements on `/treatment/`, 2 of them inactive/muted-background — §5).

So: I fixed the token. It is not "a token that only feeds dead CSS" — the caption
use-case the mandate describes is real, just implemented through a different call site
than the one the original audit's selector search found (an inline `style=""` rather
than the `.cap` class it names). The `.cap`/`.feat__meta`/`.post__meta`/`.disc__t`
**rules** are dead weight regardless of this fix (nothing renders them); I did not touch
them beyond what the shared token change does automatically, per "do not patch each
site of use."

### 1b. `--eyal-muted` (books-v2.css) — genuinely dead, fixed anyway, here's why

All four consumers — `.ea-section-label` (`:454`, used for `.eyebrow`-style section
labels) and `.ea-book-gallery-placeholder__label/__text/__note` (`:839-914`, a "dummy
gallery" the file's own comment says is temporary, "until approved photos from
team_40," meant to be dropped into `.ea-book-body` as a Custom HTML block) — return
**zero** matches: in the raw HTML of the books hub and all 3 book detail pages (the
only 3 books that exist), and independently in a real-DOM
`document.querySelectorAll('.ea-section-label')` /
`.ea-book-gallery-placeholder` query on `/books/kushi-blantis/` (§5) — both `0`. I
looked for a third explanation (content-editor-inserted Custom HTML, invisible to a
PHP-template grep) and ruled it out the same way: still zero on the actual rendered
DOM, not just the template source.

Per item 1's instruction, a token feeding only dead CSS isn't worth changing — but I
fixed this one anyway, for reasons specific to this case, not as a default:

- It's a **one-line, zero-behavioural-risk** correction (a colour reference, not
  logic), so "worth changing" has a much lower bar than for a live component.
- `.ea-section-label` is a **general-purpose utility class** (its own comment: "§15.
  SECTION LABEL UTILITY"), not page-specific — unlike the true prototype leftovers in
  chapters.css, it's plausible an editor reactivates it in future book content, at
  which point an unfixed fallback would silently resurrect the rejected `#a8a19b`.
- The evidence for *why* it's broken (not just *that* it's broken) is unusually clean:
  the sibling declarations in the same file — `var(--eyal-brick, #ab3a2b)` at
  `books-v2.css:823` and `var(--eyal-olive, #6e6f4a)` at `:830` (both in the purchase
  button rules immediately above §27b), and `var(--eyal-line, rgba(216,199,181,0.35))`
  at `:873`, *inside the same §27b gallery-placeholder block* as the fix itself — all
  carry the same stale `"eyal-"` prefix, but their **hardcoded fallbacks still match
  the current real `--ea-brick`/`--ea-olive`/`--ea-line` values exactly** — only
  `--eyal-muted`'s
  fallback is wrong, because `--ea-muted`'s value (unlike brick/olive/line) changed
  after whatever rename took this file from `eyal-` to `ea-` prefixes. That is: this
  is the same bug class as `--eyal-brick`/`--eyal-olive`/`--eyal-line`, just the only
  one of the four where the staleness is visible in the rendered colour instead of
  being accidentally harmless. I did **not** touch brick/olive/line — they're not
  "muted," they're brand-adjacent button colours, out of this mandate's scope, and
  (today) not broken in effect. Flagging them here for the record, not fixing them.

I'm reporting the dead status plainly rather than letting the fix imply an active bug:
**this is technical-debt cleanup with zero live user impact today**, not a correction
to something currently rendering the wrong colour for a visitor.

## 2. Intended semantic for muted text

`--muted` / `--ea-muted` mean the same thing in both systems: de-emphasised
*but-still-legible* secondary text — captions, meta lines, tag chips, disclaimers,
section eyebrows. Never a page's primary reading text (that's `--body`/`--ea-text-body`,
already fixed 2026-05-27 and not part of this mandate) and never decorative-only. Every
consumer of both tokens is small type — 8.96px to 13.12px across all of `.dd__tag`
(`.56rem`), `.ea-section-label`/`.ea-book-gallery-placeholder__label`
(`.58rem`), `.post__meta` (`.74rem`), `.cap`/`.feat__meta`/mokesh's inline caption
(`.76rem`/`.78rem`), `.ea-book-gallery-placeholder__text` (`.72rem`), `.disc__t`
(`.82rem`) — none bold, none within reach of the large-text carve-out (≥24px, or
≥18.66px bold). So the floor is **4.5:1, everywhere, no exceptions**, for this whole
cluster — matching the mandate's framing of the `.btile__tag` 9px case exactly, and
generalising it: nothing in the muted/ink cluster is large text, so nothing in it
gets the 3:1 allowance.

## 3. The fix

### 3.1 `chapters.css:18→29` — `--muted:#8C775F` → `--muted:#786651`

Converted `#8C775F` to HSL — `(32.00°, 19.15%, 46.08%)` — and reduced **lightness
only** (46.08% → 39.44%), holding hue and saturation fixed, so this is a contrast
nudge along the colour's own character, not a redesign: it's the same brown, darker.
Solved for the minimum darkening that clears 4.5:1 against the darker of its two real
backgrounds (`--ivory-2`) with a small safety margin (targeted 4.60:1 there, not the
bare 4.50, so two-decimal rounding on either the file or a future measurement can't
flip it back to FAIL). Full comment with the numbers is inline at `chapters.css:19-28`.

I'm aware `chapters.css:3` says *"Final palette locked (team_00, 2026-06-22)"* — this
mandate (P1, from team_100) is the explicit instruction to touch this one value
regardless; I did not treat "locked" as licence to touch anything beyond what item 3
of the mandate names (`--muted` only — `--ink`, `--body`, `--terra*`, `--sand`,
`--dark*` are all byte-for-byte unchanged).

### 3.2 `books-v2.css` — `var( --eyal-muted, #a8a19b )` → `var( --ea-muted, #6F635A )`, 4×

Lines `480`, `864`, `904`, `912` (were `462`, `839`, `879`, `887` before the comments
I added shifted later lines down). Chose "remove the broken token / repoint to the
correct existing one" over "define `--eyal-muted` properly," because a real, correct,
already-AA-fixed token (`--ea-muted`) already exists and is already loaded on every
page `books-v2.css` itself loads (both gated by the same `tpl-book-detail.php` /
`ea_wave2_is_active_view()` check — confirmed live, §5) — adding a second definition
for the same concept would recreate exactly the fragmentation ("three unrelated muted
colours") this mandate exists to undo. Kept the `var(x, fallback)` two-argument form,
matching this file's own established style (every other token reference in it does
the same), with the fallback corrected to the *current* real value instead of the
stale pre-fix one.

### 3.3 `ea-tokens.css` — read, not edited

`--ea-muted` (`:28`) and `--ea-ink`/`--ea-text` (`:12,19`) are already correct — already
the AA-fixed values, confirmed by measurement (§4) — so there was nothing to change
here. Zero-line diff on this file is the correct outcome, not an oversight.

## 4. Verification — computed, not eyeballed

Wrote a standalone WCAG relative-luminance calculator (relative luminance → contrast
ratio, plus sRGB alpha-compositing for translucent colours and analytic linear-gradient
sampling for gradient backgrounds — no screenshots/pixel-guessing for the flat-colour
cases, since exact source colours were available):
`/private/tmp/claude-501/-Users-nimrod-Documents-AOS-V5-EyalAmit-co-il-2026/5ae45105-ea60-41c0-a0a1-15918f2e481d/scratchpad/qa/contrast/wcag.mjs`
(+ `hsl_solve.mjs`, `final.mjs` — same directory).

**Formula self-check against team_100's own independently-measured number:** computing
`.foot__brand p` (`rgba(255,255,255,.45)` composited over `.foot`'s solid
`--dark` `#0E0905`) gives **4.496** before rounding — the mandate cites this exact
component at **4.4960:1**. Match, to 4 decimal places. I trust the rest of the script's
output on the strength of that reproduction, and confirmed it a second way live
(§5, identical 4.496 from real `getComputedStyle`, not just the script).

| # | Pair | Before | After | Threshold | Where it renders |
|---|---|---|---|---|---|
| 1 | `--muted` text on `--ivory` (`#fffffa`) | 4.26:1 FAIL | **5.48:1 PASS** | 4.5 (normal) | mokesh figcaption, `/eyal-amit/mokesh-dahiman/` — LIVE |
| 2 | `--muted` text on `--ivory-2` (`#efeae1`) | 3.56:1 FAIL | **4.59:1 PASS** | 4.5 (normal) | `.cap`/`.disc__t`/etc. — dead today, both standard backgrounds regardless (§1a) |
| 3 | white `#fff` on `--muted` background (`.dd__tag` inactive) | 4.27:1 FAIL | **5.50:1 PASS** | 4.5 (normal, 8.96px) | `/treatment/`, `/lessons/` — LIVE (found during my own sweep, not named in the mandate) |
| 4 | `--eyal-muted`→`#a8a19b` fallback on white `#fff` | 2.55:1 FAIL | **5.82:1 PASS** (now `--ea-muted`) | 4.5 (normal) | `.ea-section-label` — dead today (§1b) |
| 5 | same, on `--ea-bg` (`#FAF8F5`) | 2.41:1 FAIL | **5.49:1 PASS** | 4.5 | same |
| 6 | same, on `--ea-bg-alt`/`#f3eee8` | 2.21:1 FAIL | **5.05:1 PASS** | 4.5 | `.ea-book-gallery-placeholder__item` bg — dead today (§1b) |

Rows 1–3 match the mandate's own cited pre-fix numbers exactly (4.26 / 3.56; the
white-on-background 4.27 is my own addition, not previously named). Rows 4–6 use the
theme's own real background tokens (`--ea-bg`, `--ea-bg-alt`, and plain white, the card
background `.ea-book-gallery-placeholder__item` actually hardcodes at `books-v2.css`)
rather than a single assumed backdrop, since the fix has to hold on all of them.

## 5. Live-page proof (not just the file) — real Chrome, viewport asserted, settle-checked

Used the Browser pane (real Chrome rendering, not curl) against the unmodified staging
server, live-injecting the exact CSS this fix adds, then reading `getComputedStyle` on
the real DOM nodes — never assumed from source.

- **Viewport non-zero, asserted before trusting anything**: `316×805` on
  `/eyal-amit/mokesh-dahiman/` and `/treatment/`, `379×965` on
  `/books/kushi-blantis/` — all confirmed via `window.innerWidth/innerHeight`, all
  non-zero.
- **`/eyal-amit/mokesh-dahiman/`**: found the real `<figcaption dir="ltr" …
  color:var(--muted)…>` node. Ancestor-walked from the element itself outward (not
  skipping to `parentElement` first — the trap noted in this project's own prior
  report), found no gradient/image in the chain, landed on a solid
  `rgb(255,255,250)` at `<body>` (the section itself is plain `class="sec"`, no
  `--alt`/`--dark` modifier — confirmed from the live class list, not assumed from the
  template). Baseline computed colour: `rgb(140,119,95)` = `#8C775F` exactly — confirms
  staging is still serving the old file. Injected `:root{--muted:#786651 !important}`,
  forced a reflow, read again immediately **and** after a 500ms settle wait (this
  project's own prior report found a genuine mid-transition read once; this element's
  `transition-property` computes to `all`, so I checked): both reads identical,
  `rgb(120,102,81)` = `#786651` exactly. Live-computed ratio from these exact RGB
  triples: **5.48:1**, matching the script.
- **`/treatment/`**: found 3 real `.dd__tag` nodes. One (`itemIsActive:true`) reads
  `background: rgb(181,102,61)` (`--terra`) — untouched by this fix, as expected. Two
  (`itemIsActive:false`) read `background: rgb(140,119,95)` (`--muted`, pre-fix),
  `color: rgb(255,255,255)`, `font-size: 8.96px` — confirms the mandate's own "9px, not
  large text" framing exactly, on the real element. After injecting the same
  `:root` override: both inactive tags now read `background: rgb(120,102,81)`,
  live-computed ratio **5.50:1**.
- **`/books/kushi-blantis/`**: confirmed `getComputedStyle(document.documentElement).getPropertyValue('--ea-muted')`
  = `#6F635A` (the correct token really is present on a book-detail page) and
  `--eyal-muted` = `''` (genuinely undefined, matching team_100's finding). Confirmed
  `books-v2.css`, `ea-tokens.css`, `chapters.css` and `ea-atoms.css` are all present in
  `document.styleSheets` simultaneously on this one page (both gates are satisfied at
  once, as the enqueue source implied). Queried the live DOM directly —
  `document.querySelectorAll('.ea-section-label')` and `('.ea-book-gallery-placeholder')`
  both return **0** — a second, independent confirmation of §1b's dead-code finding
  (DOM query, not just HTML-source grep). Built a temporary off-screen probe element
  with `class="ea-section-label"` (appended, measured, removed — no persistent DOM
  change) to exercise the *exact* fixed rule end-to-end: before my injected override it
  computed `rgb(168,161,155)` = `#a8a19b` (matches the currently-deployed broken
  behaviour exactly); after injecting `.ea-section-label{color:var(--ea-muted,
  #6F635A)!important}` it computed `rgb(111,99,90)` = `#6F635A` exactly — proof the fix
  functions correctly once deployed, even though nothing on the live site currently
  instantiates this class.
- **`/books/kushi-blantis/` again, `.foot__brand p`**: cross-checked the formula
  self-check from §4 live: `color` computes to `rgba(255,255,255,0.45)`, `.foot`'s
  background computes to solid `rgb(14,9,5)` with `background-image:none` (confirmed
  not a gradient — this footer, unlike the nav, uses flat `--dark`, not `--dark-grad`).
  Composited live: effective `rgb(122.45,119.70,117.50)`, ratio **4.496** (rounds to
  4.50) — identical to the offline script and to the mandate's own cited figure.

No `0x0` viewport anywhere, no read taken without a settle check where a transition was
possible, no gradient assumed-flat.

## 6. P2 near-misses — re-measured, not fixed (token change doesn't reach them)

- **`.foot__brand p`** (`chapters.css:278`, unchanged) — hardcoded
  `rgba(255,255,255,.45)` on solid `--dark`. Does not reference `--muted` or `--ink` at
  all, so this fix cannot change it and doesn't. Confirmed still **4.496:1 → rounds to
  4.50 → still FAIL** (both by script and live, §4/§5). Left alone, correctly — still a
  P2, needs its own fix (raising the alpha or the colour) if/when scheduled.
- **`.btile--clay` tile text and `.btile__tag`** (`chapters.css:625-650`) — both use
  **hardcoded hex**, not `--muted`/`--ink`/any token (`.btile--clay{background:
  linear-gradient(155deg,#B5663D,#9A4F2B)}`, `.btile--clay .btile__tag{color:#F0DCC8}`),
  so again the token fix was never going to reach these. Also: **the entire `.btile`
  family is dead** — zero PHP call sites theme-wide, zero DOM matches across all 16
  live pages checked (§1, same sweep). Re-measured anyway, per the mandate's explicit
  ask, analytically (exact CSS gradient stop colours, sampled at 101 points along the
  gradient axis — this is a precise evaluation of the same interpolation the browser
  would paint, not a screenshot pixel-guess, and it reproduces the mandate's own cited
  figures exactly): white `.btile__t` text across the clay gradient, **4.26:1 (min) to
  5.95:1 (max)**; `#F0DCC8` `.btile__tag` (clay variant, 9px, not large text) across
  the same gradient, **3.20:1 (min) to 4.47:1 (max)** — both match the mandate's cited
  numbers exactly. Not fixed: not a token issue, and not live.
- **Default (non-clay/non-txt) `.btile__tag`**, colour `var(--terra-lt)`, sits over a
  live `<img>` photo (via the `.btile__ov` dark-gradient overlay) in the cases where a
  tile actually has a photo — reported **INDETERMINATE**, per the brief's own
  instruction, rather than guessed: a photo backdrop isn't a fixed colour, and (per
  §1) this whole component doesn't render anywhere today regardless.
- Confirms the mandate's own framing: none of these three were ever "supposed to be
  covered" by the muted/ink token fix (none reference either token), so there is
  nothing to report as "closed for free" — they're correctly independent P2 items.

## 7. Found during the sweep, not fixed — flagging for team_100

**`.dd__tag` active state — white text on `var(--terra)` — also fails, and I can't
fix it under this mandate.** While confirming `.dd__tag`'s inactive/`--muted` state
live on `/treatment/` (§5), the one active tag on that page (`background:
rgb(181,102,61)` = `--terra`, `color:#fff`, `8.96px`) computed to **4.26:1 — also a
FAIL** against the same 4.5:1 floor, same reasoning as §2 (small, not-large text).
This is the *same failure shape* as the fix in this mandate (white text on an
under-contrast fill, at chip-scale text) but on `--terra`, which is a protected brand
colour under item 4 of my mandate ("do not change the brand palette… If you cannot
reach 4.5:1 without touching a brand colour, stop and report it as a decision for
team_100"). I did not touch `--terra` anywhere. Flagging this as a decision item:
either the brand terracotta needs a documented exception for this specific
white-on-fill small-text use, or `.dd__tag`'s active state needs its own
(non-token-palette) fix — e.g. a darker overlay behind the text — which is outside
what "the muted colour system" mandate authorizes me to touch.

## 8. What I could not measure / where I believe this is incomplete

- **`--ea-muted`'s and `--ea-ink`'s other consumers** (`ea-atoms.css` ×9,
  `w2-14e-catalog.css`, `w2-10-service.css`, `faq-toc.css`, `ea-blog.css` ×8,
  `w2-05-shop.css`, `w2-08-en-landing.css`, `w2-07-heritage.css`) were not individually
  re-audited for live/dead status — those files aren't mine, weren't named by this
  mandate, and both tokens were already AA-compliant before I started (§4), so there
  was nothing for me to fix there regardless of their liveness. I spot-checked exactly
  one (`ea-blog.css`'s `.ea-blog-filter__item`) as evidence the token has genuine live
  reach beyond my own two files, not as a complete audit.
- **`--ea-home-muted` (`style.css:92`) is very likely also failing AA** (`#6f6f6f` is
  close in character to the pre-fix `--ea-muted` `#A8A19B`) but I did not compute its
  ratio — it's confirmed dead (§1), so there's no live user-facing question to answer,
  and `style.css`/`home-front.css` aren't files this line may edit. Flagging only.
  `--eyal-brick`/`--eyal-olive`/`--eyal-line` (`books-v2.css`, same stale-prefix bug
  class as `--eyal-muted`) are noted in §1b but deliberately not fixed — not "muted,"
  not broken in current effect (their fallbacks are still correct), out of scope.
- **Real assistive-technology behaviour** (VoiceOver/NVDA/JAWS) was not tested — colour
  contrast is a rendering property with no semantic/AT dimension, and nothing about
  markup, roles, or attributes changed in this fix, only `color`/custom-property
  values — but I did not verify AT rendering directly.
- Everything else above (§4-§6) was measured directly and positively, computed to two
  decimals with a real formula that reproduces two independently-sourced reference
  numbers exactly (team_100's `.foot__brand p` 4.4960:1, and the mandate's own
  `.btile--clay`/`.btile__tag` gradient figures) — not inferred, not eyeballed.

## 9. Deploy status

Not deployed. Both edits exist only in the local working tree at
`/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026`; staging continues to serve the
old `chapters.css` (`?ver=1.5.38`, still resolving `--muted` to `#8C775F` live, confirmed
§5) and old `books-v2.css` until team_100 deploys — FTP is IP-allowlisted regardless,
not something this line can or should do. Every "after" number in §4/§5 was produced by
live-injecting the same CSS into the loaded staging page in a real browser tab, not by
editing staging itself. `style.css` Version not touched (currently `1.5.38` live, per
the fetched `<link>` tag — team_100's own number to manage; not bumped by me, per the
shared brief). Never used `git add -A`/`git add .`; nothing staged or committed.

Diff: 2 files changed, 41 insertions(+), 5 deletions(-) (`ea-tokens.css`: 0 changes —
already correct, confirmed by measurement, not an oversight).
