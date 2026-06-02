# LOD400 — WP-W2-10-B · Editorial template FULL IMPLEMENTATION (post-elevation)

**WP:** WP-W2-10-B | **Milestone:** S003 | **Parent:** WP-W2-10 (Track-2) | **Priority:** HIGH | **Profile:** L0
**Builder:** team_10 (S3) · **Tokens:** team_80 (S4) · **QA:** team_50 → **Validate:** team_190 (Cursor)
**Authored:** 2026-06-02 (team_100) | **lod_status:** LOD400 (implementation-grade)
**Source of truth:** `_COMMUNICATION/team_35/WP-W2-10-B/elevation/` (`mockup/editorial-about.html` + elevation-notes + handoff; READY_FOR_S2, 0 new tokens/atoms, 0 GCR).
**Shared conventions:** inherit the render-pattern, D-14 discipline, https-perf ACs, and downstream gate prompts from `WP-W2-10-A/LOD400_IMPL_spec.md` (§2, §7, §9). This spec lists only what is B-specific.

## 0. Objective
Implement the team_35-elevated **Editorial** composition on `tpl-content.php` (currently thin — renders `the_content()`),
across `/about` (primary) + `/press`, `/about/moksha`. Composition-only on D-14 (`ea-tokens`, `ea-atoms`, `ea-blog.css`).

## 1. Gate
READY_FOR_S2 → **S2 Eyal sign-off (team_00 proxy this round) gates S3.** Memorial copy is sensitive — treat verbatim.

## 2. Architecture
Mirror the A render-function approach: a route-aware `ea_wave2_render_editorial_blocks( $ctx )` (extend an editorial/content
provider; `inc/` content from W2-07 era) called from `tpl-content.php` body inside `<main id="main" class="ea-wave2-editorial">`.
Single H1 (editorial hero). Reading measures capped 65–72ch.

## 3. Block sequence (13) — mapping
| # | Block | Partial / atom | Notes |
|---|-------|----------------|-------|
| 1 | topnav (current=אודות) | `block-topnav` | chrome |
| 2 | **Editorial hero (Ink)** — kicker + H1 "אייל עמית" + lead + **real portrait** 1fr/300px split | recompose `section-intro` on `--ea-ink` + bio-block grid logic + `cta-pill` | wire `eyal-portrait-hero.jpg` |
| 3 | Meta strip (פועל מאז 1999 / cbDIDG / פרדס חנה / שלושה) | caption+body type tokens | composition-only |
| 4 | section-intro ("משהו בנשימה התחיל את הכל") | `block-intro` | route copy |
| 5 | breath-divider | `block-breath-divider-1` | reuse |
| 6 | content-section ("המרכז…") — first para `.lead` 1.15rem | content-section atom | route copy |
| 7 | **Journey timeline** — `content-section--alt` + `.ea-pillar`×6 (label=year) | `.ea-pillar` grid | dated 6-cell, existing tokens |
| 8 | breath-divider | reuse | |
| 9 | **Mokesh memorial** — dedicated section: circular memorial disc (1950–2020) + pullquote | composed: `border-inline-start`+terracotta pullquote; disc from line+type tokens | sensitive copy, verbatim |
| 10 | Studio + `book-gallery` (real studio photo + graceful gaps) | `book-gallery` pattern | `hero-wide-studio.jpg` / gallery |
| 11 | services-section — real **book-cover row** (3 covers) + 2 `service-tile` (moksha, books) | `services-grid`, `service-tile` | covers from shared-assets; links → /about/moksha, /books |
| 12 | contact-section (Ink) — "רוצים להכיר?" | `block-contact-cta` | reuse |
| 13 | footer-social | `block-footer-social` | chrome |

## 4. Real-asset wiring
`eyal-portrait-hero.jpg` (hero split) + `hero-wide-studio.jpg` (studio) + 3 covers (`vekatavt`/`kushi-blantis`/`tsva-bechol`)
→ theme media (`assets/images/`). Remaining gallery cells = graceful gaps.

## 5. Route fan-out
`/press` = same shell, body → press clippings + testimonials grid (reuse `service-tile`/gallery). `/about/moksha` = same
shell, lead with the memorial disc + long-form Mokesh biography.

## 6. Acceptance (B-specific deltas; else per A §7)
- AC-B2 all 3 routes render the full editorial composition (no bare `the_content()`); matches `editorial-about.html`.
- AC-B-memorial: memorial block present as a dedicated section (not a link), copy verbatim.
- AC-B6 AA contrast holds on BOTH `--ea-bg` and `--ea-ink` surfaces; single H1; RTL.
- (AC-A3/A4/A5/A7 equivalents: zero drift, axe 0/0, LH https a11y 100 / mobile perf ≥85 on /about + 1 sibling, validate 0 FAIL, routes 200.)

## 7. Build sequence / gates
Per A §8/§9, with editorial blocks + the 3 editorial routes. S4 team_80 (zero drift; memorial disc/timeline/meta-strip use existing tokens) → S5 team_50 (`/about/ /press/ /about/moksha/`) → team_190 (Cursor). HALT for S2 first.

## 8. Risk
Memorial content sensitivity (handle copy exactly); `/press` clippings availability on staging (flag gap → team_00, placeholder bridge).
