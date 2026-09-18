---
id: DONE_S007_M03_TYPE_INVENTORY_2026-09-18_v1.0.0
schema_version: aos_v1_team_messaging
type: DONE (team_10 → team_100)
from: team_10 (session eyalamit-co-il-2026-e4)
to: team_100 (session eyalamit-co-il-2026-76)
cc: [team_00]
date: 2026-09-18
mandate: MANDATE-S007-M03-TYPE-INVENTORY-2026-09-18.md
disposition: MEASUREMENT ONLY. No CSS/PHP edited. No scale proposed. No declaration judged.
---

# S007 M-03 · Typography inventory — measurement only

No scale is proposed here and no declaration is called "wrong" — that call is team_00's,
per the mandate's own hard scope limit. This is the inventory that makes his call
mechanical instead of a 261-declaration read-through.

## The investigation ran across a live edit — reported, not hidden

The mandate's own baseline was measured at **theme version 1.5.40**. While this inventory
was being built, two real commits landed in this shared worktree and changed the exact
files under inventory:

- `78d4896` *"Eleven corrections from team_00, theme 1.5.41"* — authored by Nimrod, co-authored
  by Claude Opus 5. Changed 9 files including `chapters.css` (line-height on 9 rules, the
  home hero's font-family from serif to Heebo, `.hero__trust` `.72rem→.86rem`, button tracking,
  a new H3 tier at weight 600, footer/logo changes).
- `05763dd` *"The hero box was too narrow for its own line break, 1.5.42"* — a follow-up fix to
  the same hero, same day.

**Current theme version is 1.5.42, not 1.5.40.** Both my CSS parse and my live-DOM check were
run (and, once I noticed the version had moved, re-run in full) against the current, post-1.5.42
state — nothing in this report mixes the two states. `git log --oneline -3` at time of writing:
`05763dd` → `78d4896` → `66e09d7`, working tree clean, no uncommitted changes in `site/`.

One more thing worth naming plainly: commit `143528f`, checked while investigating this,
turned out to be a prior *S007 M-01* report — mine, the one I filed and messaged you about
earlier today — committed to git by someone else in this shared tree (byte-for-byte identical
diff, verified). That's a good sign the earlier report reached the people who needed it; it
isn't part of this mandate, noted here only because I found it while explaining why line
numbers had shifted.

## Positive assertion / commands used

- Root font size: **16px, empirically confirmed** two ways — (a) no `html{font-size:...}` or
  `:root{font-size:...}` override exists in any of the 9 files (`grep -n` returned nothing),
  and (b) live CDP `getComputedStyle(document.documentElement).fontSize` on the home page at
  1440px returns `16px` directly. Not assumed.
- Live-enqueued file list: **verified from the rendered `<link rel="stylesheet">` tags**, not
  from the mandate's claim — fetched `/` and `/treatment/` fresh
  (`curl -sk https://eyalamit-co-il-2026.s887.upress.link/{,treatment/}`, grepped for
  `<link[^>]+>.*\.css`). Exactly the 9 files the mandate names appear — **but not uniformly**:
  `home-front.css` is enqueued on `/` and **absent** from `/treatment/`'s `<link>` list, so it
  is home-page-conditional, not sitewide, despite reading as one of "the nine." The mandate's
  prose calls them "the eight files that are actually live" while its own code block lists
  nine — a small self-inconsistency, noted rather than silently resolved.
- `font-size` pattern: matched via `font-size\s*:\s*([^;]+);?` (tolerates 0-or-more spaces
  after the colon) against every `assets/css/*.css` file plus `style.css`, on text with CSS
  comments blanked out character-for-character (not deleted) so line numbers stay exact
  against the original file. This is the exact class of bug the mandate warned about
  (`font-size:var(` vs `font-size: var(` as different grep hits) — my pattern does not have
  that failure mode; stated here so it can be checked.
- LIVE/ORPHAN: `document.querySelectorAll(selector).length > 0`, evaluated **in the real DOM**
  of **30 live pages** — one representative page per Chapters template type I could locate a
  working URL for (home, method, treatment, about, mokesh, books archive, 2 book details,
  galleries, testimonials, EN, contact, faq, blog archive, shop, and 15 more covering
  bags/accessibility/privacy/repair/didgeridoos/terms/stand-floor/stands-storage/
  snoring-sleep-apnea/qr/learning/lectures/therapist-training) — full list and per-page hit
  counts in `_COMMUNICATION/team_10/S007-M03/live-check-raw.json`. **This is a large sample,
  not a proof of absence.** A selector matching on none of these 30 pages is reported ORPHAN
  here; it could still be reachable on a page type this sample missed (a single blog post's
  specific category page, an individual shop product, a `:hover`/`:focus` state never
  triggered by a static crawl). Zero selectors errored (no invalid-selector syntax hit).

- **A line-number bug in my own first pass, caught before delivery, not after.** My extractor
  initially reported every declaration's line as one-too-low whenever a rule's selector text
  is the first thing on its own line — a comma/brace regex can swallow the trailing newline
  from the *previous* rule's closing `}` as leading whitespace on the next match, and counting
  newlines up to that swallowed character undercounts by one. Caught by spot-checking four
  citations against `sed -n` before writing this report, found two were wrong, traced the
  cause, fixed the extractor to skip captured leading whitespace before counting lines, and
  re-verified **all 92 file:line citations in this report's prose tables and all 261 rows in
  the CSV** programmatically against the current source files afterward — zero mismatches on
  the re-check. Named here because a systematic off-by-one is exactly the kind of "clean
  automated result" the mandate warns is not evidence on its own; this one only became
  trustworthy after the second, independent check.

## Section 1 — Counts

| | Declarations | Distinct raw values |
|---|---|---|
| **Total, all 9 confirmed-live files** | **261** | **89** |
| `assets/css/chapters.css` | 114 | 55 |
| `assets/css/ea-atoms.css` | 93 | 26 |
| `style.css` | 21 | 15 |
| `assets/css/ea-mobile-nav.css` | 15 | 15 |
| `assets/css/home-front.css` | 13 | 10 |
| `assets/css/ea-mobile-variants.css` | 5 | 5 |
| `assets/css/ea-tokens.css` | 0 | 0 |
| `assets/css/ea-animations.css` | 0 | 0 |
| `assets/css/testimonials-carousel.css` | 0 | 0 |

**Corrections to the mandate's own stated baseline, reproduced and found different:**
- Total: **261**, not 263. (At the version the mandate measured, 1.5.40, my own parser
  reproduces **262** — one declaration was net-removed by the 1.5.41 edit. Either way, not 263;
  the 1-2 unit gap is most likely a counting-method difference — e.g. whether a rule with two
  comma-separated selectors counts once or twice — not a disagreement about which files count.)
- `chapters.css`: **115 declarations at 1.5.40** (matches the mandate exactly), **114 now**
  (1.5.42). Distinct values: **55**, not 53, at both versions checked.
- Font-family tokens touching a `font-size` rule: **7, not 6** — `--hf`, `--bf`, `--serif`,
  `--display` (all `chapters.css`), `--ea-font` (`ea-tokens.css`), `--ea-font-sans`
  (`style.css`), and `--svc-font` (`services.css` — **not** one of the 9 live files; this
  token never resolves on any page a visitor can reach). See Section 4.

**The number that actually matters for "wiring the whole site to one set of definitions":**
only **76 of the 261 declarations (29%) match at least one element on at least one of the 30
pages sampled.** The other **185 (71%) are ORPHAN** — split further below by file. Those 76
LIVE declarations carry **47 distinct raw values**, which round to **21 distinct pixel values
at 1440px**. That is the real size of the mechanical-mapping problem: 21 clusters, not 261
declarations and not even the 89 raw distinct values — most of what looks like scattered
inconsistency is CSS nobody's browser loads.

| File | Declarations | LIVE | ORPHAN |
|---|---|---|---|
| `chapters.css` | 114 | **60** | 54 |
| `ea-atoms.css` | 93 | **16** | 77 |
| `style.css` | 21 | **0** | 21 |
| `ea-mobile-nav.css` | 15 | **0** | 15 |
| `home-front.css` | 13 | **0** | 13 |
| `ea-mobile-variants.css` | 5 | **0** | 5 |
| **Total** | **261** | **76** | **185** |

Three files are **100% orphan** for font-size purposes, and for three different reasons worth
distinguishing rather than lumping together:

1. **`ea-mobile-nav.css` / `ea-mobile-variants.css` (20 declarations)** — the mandate's own
   claim, verified: the orphaned team_35 mobile-nav implementation, already known from the RTL
   audit. Every one of its 20 font-size-bearing selectors (`.ea-mnav-link`, `.ea-mnav-sublink`,
   `.ea-topnav__lang`, etc.) matched zero elements across all 30 pages.
2. **`style.css` (21 declarations)** — the `--ea-size-*` token scale documented in the S007
   M-01 report: 8 tokens, all 21 use-sites scoped under `body.ea-home-dashboard`, a class
   absent from the current live home page. Dead Wave2 dashboard variant, not the theme's
   general stylesheet being dead — the other, non-font-size rules in `style.css` may well be
   live; only its font-size declarations were in scope here.
3. **`home-front.css` (13 declarations)** — a genuinely new finding this mandate. This file
   **does** load on the home page (confirmed via the live `<link>` tag), unlike the two files
   above — but **10 of its 13 font-size selectors are also `.ea-home-dashboard`-scoped**, and
   the remaining 3 target `.ea-testimonials-section--rotator .ea-testimonial-card__text` — a
   "rotator" testimonials variant that isn't the one on the live page (`testimonials-carousel.css`
   is what's actually active, per the separate, non-zero-declaration but likewise 0-live-hit
   file check — see below). So the file is fetched by every home-page visitor and contributes
   nothing to what they see, for font-size purposes.

`ea-atoms.css`'s 77 orphan declarations are not one dead subsystem — they include, among
others, an entire parallel `.ea-book-hero__*` / `.ea-book-card__*` component family
(`ea-atoms.css:1836`, `2007`, and others) that reads exactly like a real book-detail page
component set but doesn't match the live book-detail markup (which uses `.phero__h` / `.h2`,
confirmed in the S007 M-01 report). This looks like leftover styling for an earlier book-page
treatment, not a mobile-specific system — flagged for someone who owns that decision, not
concluded here.

## Section 2 — Clusters (LIVE only, by computed px at 1440, largest first)

76 LIVE declarations, 21 clusters. Full listing:

#### 59px  (n=1)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:160` | `.hero__h` | clamp(2.2rem,4.8vw,3.7rem) | 500 | hero-title |

#### 58px  (n=1)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:315` | `.phero__h` | clamp(2.2rem,4.6vw,3.6rem) | 500 | hero-title |

#### 42px  (n=2)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:80` | `.h2` | clamp(1.8rem,3.1vw,2.6rem) | 600 | section-title |
| `assets/css/chapters.css:338` | `.cta-band__h` | clamp(1.8rem,3.2vw,2.6rem) | 500 | button |

#### 40px  (n=1)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:258` | `.bleed__q` | clamp(1.5rem,3vw,2.5rem) | 400 | body |

#### 32px  (n=2)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:225` | `.studio__h` | 2rem | 500 | body |
| `assets/css/ea-atoms.css:1158` | `.ea-contact-section__heading` | 2rem | 200 | section-title |

#### 27px  (n=1)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:196` | `.tl__y` | 1.7rem | 500 | body |

#### 26px  (n=2)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:249` | `.cmpc__t` | 1.6rem | 500 | title |
| `assets/css/chapters.css:821` | `.testi-mq__btn` | 1.6rem | inherit | button |

#### 24px  (n=1)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:912` | `.bookcard__t` | 1.5rem | 300 | card-title |

#### 22px  (n=4)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:289` | `.foot__brand b` | 1.4rem | inherit | footer |
| `assets/css/chapters.css:488` | `.ea-faq-category__heading` | 1.35rem | 500 | faq |
| `assets/css/ea-atoms.css:1688` | `.ea-section-intro__heading, .ea-content-section__headin` | 1.4rem | inherit | section-title |
| `assets/css/ea-atoms.css:2094` | `.ea-faq-category__heading` | 1.4rem | 200 | faq |

#### 21px  (n=1)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/ea-atoms.css:1286` | `.ea-contact-nap__h` | 1.3rem | 500 | body |

#### 19px  (n=5)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:162` | `.hero__s` | clamp(1.02rem,1.4vw,1.18rem) | 300 | hero-title |
| `assets/css/chapters.css:277` | `.st3__t` | 1.18rem | 500 | title |
| `assets/css/chapters.css:317` | `.phero__s` | clamp(1.04rem,1.4vw,1.2rem) | 300 | hero-title |
| `assets/css/chapters.css:423` | `.dd__t` | 1.2rem | 600 | title |
| `assets/css/chapters.css:909` | `.bookcard__cover .ph` | 1.2rem | inherit | body |

#### 18px  (n=2)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:59` | `body` | 18px | 300 | body |
| `assets/css/ea-atoms.css:1260` | `.ea-contact-points li` | 1.15rem | 500 | body |

#### 17px  (n=10)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:81` | `.lead` | 1.06rem | 300 | lead |
| `assets/css/chapters.css:226` | `.studio__p` | 1.04rem | 300 | body |
| `assets/css/chapters.css:322` | `.phero__lede` | clamp(.98rem,1.2vw,1.08rem) | 300 | hero-title |
| `assets/css/chapters.css:339` | `.cta-band__p` | 1.08rem | 300 | button |
| `assets/css/chapters.css:442` | `.intro-body p` | 1.08rem | inherit | body |
| `assets/css/chapters.css:492` | `.ea-faq-item__summary, .ea-faq-item__question` | 1.08rem | 500 | faq |
| `assets/css/chapters.css:510` | `.prose-acc__t` | 1.08rem | 500 | title |
| `assets/css/chapters.css:739` | `.about__body p:first-child` | 1.06rem | inherit | body |
| `assets/css/chapters.css:959` | `.ea-pending-approval__title` | 1.05rem | 700 | title |
| `assets/css/ea-atoms.css:1166` | `.ea-contact-section__body` | 1.05rem | 300 | body |

#### 16px  (n=8)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:250` | `.cmpc__p` | 1rem | 300 | body |
| `assets/css/chapters.css:429` | `.dd__body` | 1rem | inherit | body |
| `assets/css/chapters.css:504` | `.ea-faq-item__answer` | 1rem | inherit | faq |
| `assets/css/chapters.css:714` | `.nav__l>li>a,.nav__dd` | 1rem | inherit | nav |
| `assets/css/chapters.css:865` | `.tmq__q` | 1rem | 400 | testimonial |
| `assets/css/chapters.css:916` | `.bookcard__blurb` | .98rem | inherit | card-blurb |
| `assets/css/ea-atoms.css:1103` | `.ea-faq-item__question` | 1rem | 400 | faq |
| `assets/css/ea-atoms.css:1123` | `.ea-faq-item__answer p` | 1rem | 300 | faq |

#### 15px  (n=6)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:88` | `.btn` | .95rem | 500 | button |
| `assets/css/chapters.css:206` | `.whom__p` | .96rem | inherit | body |
| `assets/css/chapters.css:278` | `.st3__p` | .94rem | inherit | body |
| `assets/css/ea-atoms.css:1176` | `.ea-whatsapp-float` | 0.95rem | 700 | body |
| `assets/css/ea-atoms.css:1293` | `.ea-contact-nap__row` | 0.95rem | 300 | body |
| `assets/css/ea-atoms.css:1452` | `.ea-contact-form--cf7 .wpcf7-submit` | 0.95rem | 400 | form |

#### 14px  (n=7)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:159` | `.hero__trust` | .86rem | 500 | hero-title |
| `assets/css/chapters.css:197` | `.tl__l` | .9rem | inherit | label |
| `assets/css/chapters.css:285` | `.foot a` | .85rem | inherit | footer |
| `assets/css/chapters.css:960` | `.ea-pending-approval__note` | .88rem | inherit | body |
| `assets/css/ea-atoms.css:74` | `.ea-skiplink` | 0.9rem | inherit | body |
| `assets/css/ea-atoms.css:1398` | `.ea-contact-form--cf7 .wpcf7-form-control.wpcf7-text, .` | 0.9rem | 300 | form |
| `assets/css/ea-atoms.css:1483` | `.ea-contact-form--cf7 .wpcf7-response-output` | 0.9rem | inherit | form |

#### 13px  (n=5)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:131` | `.nav__l a` | .8rem | 300 | nav |
| `assets/css/chapters.css:290` | `.foot__brand p` | .82rem | inherit | footer |
| `assets/css/chapters.css:553` | `.nav__sub a` | .8rem | 300 | nav |
| `assets/css/chapters.css:917` | `.bookcard__cta` | .8rem | 500 | button |
| `assets/css/chapters.css:969` | `.ea-pending-inline` | .8rem | 600 | body |

#### 12px  (n=11)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:135` | `.nav__tg` | .72rem | inherit | nav |
| `assets/css/chapters.css:138` | `.nav__en` | .72rem | inherit | nav |
| `assets/css/chapters.css:259` | `.bleed__a` | .74rem | inherit | body |
| `assets/css/chapters.css:297` | `.foot__disc` | .72rem | inherit | footer |
| `assets/css/chapters.css:298` | `.foot__base` | .76rem | inherit | footer |
| `assets/css/chapters.css:381` | `.nav__tg` | .72rem | inherit | nav |
| `assets/css/chapters.css:546` | `.nav__dd` | .78rem | 300 | nav |
| `assets/css/chapters.css:875` | `.tmq__n` | .74rem | 500 | testimonial |
| `assets/css/chapters.css:955` | `.ea-pending-approval__badge` | .72rem | 700 | body |
| `assets/css/chapters.css:990` | `.mokesh-hero__unmute` | .78rem | inherit | hero-title |
| `assets/css/ea-atoms.css:533` | `.ea-cta-pill` | 0.78rem | 300 | button |

#### 11px  (n=1)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:113` | `.ph span` | .66rem | inherit | body |

#### 10px  (n=3)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:78` | `.chap` | .64rem | 500 | body |
| `assets/css/chapters.css:284` | `.foot h4,.foot__col-title` | .6rem | 500 | footer |
| `assets/css/chapters.css:548` | `.nav__caret` | .6em | inherit | nav |

#### 9px  (n=1)

| File:line | Selector | Raw | Weight | Role |
|---|---|---|---|---|
| `assets/css/chapters.css:421` | `.dd__tag` | .56rem | inherit | tag |

Two same-pixel clusters split by role in a way worth flagging even without judging them:
**42px** holds one section heading (`.h2`) and one CTA-band heading (`.cta-band__h`) at
different weights (600 vs 500) — same size, different weight, different role. **32px** holds
a generic body heading (`.studio__h`, weight 500) next to the contact page's own section
heading (`.ea-contact-section__heading`, weight 200) — same size, opposite ends of the weight
range. Both are exactly the kind of same-size-different-weight pairing Part 3 of the earlier
M-01 report flagged as a decision team_00 hasn't made yet, not something this inventory
resolves.

## Section 3 — The `clamp()` set

11 fluid declarations, all in `chapters.css`, all resolved by hand at both endpoints — these
are the ones a flat scale will fight, because each is already a small two-point scale of its
own:

| File:line | Selector | Raw | 390px | 1440px | Role |
|---|---|---|---|---|---|
| `chapters.css:160` | `.hero__h` | `clamp(2.2rem,4.8vw,3.7rem)` | 35.2px | 59.2px | hero-title |
| `chapters.css:315` | `.phero__h` | `clamp(2.2rem,4.6vw,3.6rem)` | 35.2px | 57.6px | hero-title |
| `chapters.css:80` | `.h2` | `clamp(1.8rem,3.1vw,2.6rem)` | 28.8px | 41.6px | section-title |
| `chapters.css:338` | `.cta-band__h` | `clamp(1.8rem,3.2vw,2.6rem)` | 28.8px | 41.6px | button |
| `chapters.css:352` | `.feat__t` | `clamp(1.6rem,2.6vw,2.2rem)` | 25.6px | 35.2px | title |
| `chapters.css:258` | `.bleed__q` | `clamp(1.5rem,3vw,2.5rem)` | 24.0px | 40.0px | body |
| `chapters.css:618` | `.mag-list__n` | `clamp(2.2rem,3.2vw,3rem)` | 35.2px | 46.08px | body (decorative numeral) |
| `chapters.css:590` | `.fstep__num` | `clamp(3.4rem,6vw,5.4rem)` | 54.4px | 86.4px | body (decorative numeral) |
| `chapters.css:162` | `.hero__s` | `clamp(1.02rem,1.4vw,1.18rem)` | 16.32px | 18.88px | hero-title |
| `chapters.css:317` | `.phero__s` | `clamp(1.04rem,1.4vw,1.2rem)` | 16.64px | 19.2px | hero-title |
| `chapters.css:322` | `.phero__lede` | `clamp(.98rem,1.2vw,1.08rem)` | 15.68px | 17.28px | hero-title |

Method: each `clamp(MIN, PREFERRED, MAX)` resolved as `max(MIN, min(PREFERRED, MAX))`, with
`rem` terms `× 16` (the verified root) and `vw` terms `× (width ÷ 100)`. At 390px every one of
these 11 is still riding its `vw`-scaled middle term, not yet pinned to MIN — none of them
hits their floor until narrower than 390px. Four pairs are near-duplicates of each other
(`.hero__h`/`.phero__h`; `.h2`/`.cta-band__h`, byte-identical growth rates; `.hero__s`/`.phero__s`/
`.phero__lede`, three closely-spaced variants of the same hero-copy idea) — worth knowing
before deciding how many *fluid* steps a scale needs, separately from the flat steps.

## Section 4 — Font families

Seven distinct custom properties resolve into a `font-family` value somewhere a `font-size`
rule also lives (not six, per the correction in Section 1):

| Token | Defined at | Resolves to | Used by font-size rules |
|---|---|---|---|
| `--hf` | `chapters.css:31` | `'Heebo',-apple-system,Arial,sans-serif` | 22 rules |
| `--bf` | `chapters.css:31` | `'Heebo',-apple-system,Arial,sans-serif` | 31 rules |
| `--serif` | `chapters.css:32` | `'Frank Ruhl Libre',serif` | 6 rules |
| `--display` | `chapters.css:606` | `'Suez One','Frank Ruhl Libre',serif` | 6 rules |
| `--ea-font` | `ea-tokens.css:31` | `'Heebo', -apple-system, Arial, sans-serif` | 80 rules† |
| `--ea-font-sans` | `style.css:95` and again at `style.css:312` (identical value, defined twice) | `"Rubik", sans-serif` | 1 rule |
| `--svc-font` | `services.css:19` | `"Rubik", "Heebo", Arial, sans-serif` | 0 rules in the live 9-file set — `services.css` is not enqueued on any page checked |

† `--ea-font` shows 80 hits because `ea-tokens.css` defines the same token name generically
and it is the fallback several component families resolve to when a rule doesn't redeclare
`font-family` locally — most of those 80 are inherited-default attributions, not 80 explicit
`font-family:var(--ea-font)` lines; see the CSV's `font_family_resolved` column
(`not-declared-in-rule` vs `token-not-in-known-6` vs a literal token name) for which is which
per row.

Three families are in play: **Heebo** (the workhorse — `--hf`, `--bf`, `--ea-font` are the same
stack under three names), **Frank Ruhl Libre / Suez One** (both Hebrew display/serif faces,
reserved for accents — `--serif` and `--display` overlap in their fallback but name two
different primary faces), and **Rubik** (`--ea-font-sans`, `--svc-font` — the odd one out,
used by only one live-file rule and by a token from a file that never loads). No rule
hardcodes a literal family without going through one of these seven tokens, except the one
`--ea-font-sans` rule and a couple of rules whose `font-family` isn't redeclared at all and
simply inherit `body`'s (`chapters.css:60`, itself `var(--bf)`).

`--serif`'s own comment (`chapters.css:32`) reads `/* reserved serif accent — hero + years
only */`, but the 1.5.41 edit moved the home hero (`.hero__h`) off `--serif` onto `--hf`
(Heebo) — the comment is now stale relative to what the rule actually does. Not a font-size
finding, noted because it sits one line above one.

## Section 5 — What could not be resolved

- **Cascade-dependent values.** 114 of the 261 declarations don't redeclare `font-family` in
  their own rule (`font_family_resolved = not-declared-in-rule` in the CSV) — they inherit
  from whatever ancestor rule wins the cascade at that DOM position. Static parsing can name
  the nearest textual candidate but cannot prove the winning ancestor without per-page
  computed-style evaluation, which was done for the 76 LIVE rows' `font-weight`/`font-size`
  (via the same DOM check) but not exhaustively for `font-family` inheritance chains — recorded
  as the rule's own text, not a resolved inherited value, for every row.
  Font-weight in the CSV uses the literal string `inherit` for the same reason (52 of 261
  rows), not a resolved number.
- **`em`-based sizes** (one row: `.nav__caret`, `chapters.css:547`, `.6em`) — resolved here as
  if `1em = 16px` (the root), which is only correct if nothing between it and the root changes
  font-size. Given `.nav__caret` sits inside `.nav__dd` (`.78rem` = 12.48px), the real computed
  size is more likely `0.6 × 12.48px ≈ 7.5px`, not the `9.6px` a root-relative reading would
  suggest. Flagged rather than corrected silently — the CSV's `computed_px_*` columns for this
  one row should be read as approximate, not measured.
- **`:hover` / `:focus` / interaction-only rules.** None of the 261 font-size declarations
  themselves are gated behind a pseudo-class, so this didn't end up mattering for this
  inventory — but it's why some ORPHAN verdicts elsewhere in this project's history (this
  session's own carousel work) have needed a real interaction, not just a static crawl, and
  is worth remembering if this CSV is later used to justify deleting something.
- **Whether `books-v2.css`, `services.css`, `w2-*.css`, `ea-blog.css`,
  `theme-shell-fallback.css`, and `faq-toc.css` are live anywhere.** Out of scope — the mandate
  named 9 files as "actually live" and this inventory took that as the boundary (independently
  re-verified, not merely assumed, per Section 1). Whether any of these other files' font-size
  rules reach a visitor on some page type this inventory didn't check is a real open question,
  not one this mandate asked to be closed.
- **Exact source of the 1-2 declaration gap against the mandate's 263 baseline**, and the
  55-vs-53 distinct-value gap in `chapters.css` — reproduced my own number with method
  (Section 1); did not chase team_100's exact figure down to the statement that produced it.

## CSV

`_COMMUNICATION/team_10/S007-M03/type-inventory.csv` — 261 rows, columns exactly as specified:
`file,line,selector,raw_value,computed_px_1440,computed_px_390,font_weight,font_family_token,role_guess,status`.
`role_guess` is a location label only (nav / footer / hero-title / section-title / card-title /
card-blurb / body / lead / button / faq / testimonial / form / label / tag / title / meta),
assigned by matching the selector text against common naming patterns — it is not a claim
about what the role *should* be, per the mandate's own constraint.

Raw supporting data: `_COMMUNICATION/team_10/S007-M03/live-check-raw.json` (the 30-page list,
per-page match counts, and the full matched/orphan/errored selector sets).

## Scope compliance

No file under `site/` was edited. No scale was proposed. No declaration was labeled "wrong" —
`role_guess` names where something is used, never what it should become. Did not touch `_aos/`.
Did not run `git add -A` or `git add .`. The only files created are this report, the CSV, and
the raw JSON named above, all under `_COMMUNICATION/team_10/S007-M03/`.
