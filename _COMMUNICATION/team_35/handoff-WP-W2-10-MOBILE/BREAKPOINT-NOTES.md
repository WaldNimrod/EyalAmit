# BREAKPOINT NOTES — per-component responsive behaviour

team_35 → team_10 · WP-W2-10 mobile. Existing theme breakpoints (do not invent new ones — D-14): **`max-width:1023px`** (tablet), **`max-width:767px`** (mobile), **`max-width:639px`** (small). Design widths verified: **360 · 390 (primary) · 414 · 768**.

> Rule of thumb: layout grids step **desktop → 2-col @1023 → 1-col @639**; chrome swaps to the **drawer @1023**; section padding tightens @639. No element exceeds `100vw` at any width (logical props + `max-inline-size:100%` + `overflow-wrap`).

---

## Chrome

| Component | ≥1024 | ≤1023 | ≤767 | ≤639 |
|---|---|---|---|---|
| Top nav | canonical 10-link bar + 3 hover dropdowns | **drawer bar** (☰ · שמע · EN · brand); desktop links hidden | same | same |
| Drawer width | — | `min(86vw,360px)` | same | same |
| Footer | 4-block grid (brand · ניווט · מידע · עקבו) | 4-block | **2-col**, brand spans full | **1-col** |

## Page components

| Component | Pages | ≥1024 | ≤1023 | ≤639 / @390 |
|---|---|---|---|---|
| Hero (kicker+H1+sub+CTA pair) | all | full | H1 steps down (2.2rem) | H1 1.7rem; **CTA pair stacks full-width**; min-height eases |
| 4-step pillars | Method, A | 4-col | **2-col** | **1-col**, step number kept as kicker |
| "who it's for" 5-tile | A | row | wrap | **1-col** |
| **Service comparison (3-col)** | A | 3-col fused table | — | **3 full-width cards** (hairline frame; active = terracotta border). Alt: `data-compare="scroll"` swipe row |
| Bio block (portrait+prose) | A, B | side-by-side | — | **portrait first, prose below**; portrait 4/5 |
| Testimonials | A/Home, Media | grid ×3 | ×2 | **1-col stack**; Home = **auto-rotator** (1-up, dots, pause-on-hover, reduced-motion safe). Alt: `data-testi="carousel"` |
| FAQ accordion | A, C | full | full | tap targets ≥44px; native disclosure |
| Editorial hero + journey timeline (6 cells) | B | 2-col timeline | — | **vertical**, one cell under the next |
| Memorial section | B/Memorial | centered | centered | round sand avatar + quote; **subtitle nowrap ≥768, wraps below**; generous spacing |
| Studio + gallery grid | B, Galleries | 3-col | **2-col** | **1-col**; lead image 4/3 |
| Books archive cards | E | row | 2-col | **1-col**; cover ratio preserved, price/CTA stack in footer |
| Stacked-cover **bundle** band | E | row | stack | 3 covers overlap centered above price; CTA full-width |
| Book detail (cover-hero split) | E | split | — | **cover first, then title/excerpt**; long excerpt clamps with "read more"; **external-purchase CTAs full-width** |
| **Shop grid (4-up)** | E | 4-col | 2-col | **2-col** (default). Alt: `data-shop="1col"` |
| Press / media row | Media | 2-col | 2-col | **1-col** |
| EN landing (LTR) | F | full LTR | drawer (LTR) | full LTR mobile pass; logical props mirror automatically |

## Verified
- **No horizontal overflow** — `scrollWidth === innerWidth` at 360/390/414/768 across all 10 templates. (Closes the `/treatment` ~1px overflow note.)
- **Tap targets** — burger, sound, EN, ✕, drawer rows, accordion buttons, dots: all ≥44px.
- **Drawer** opens/closes and traps focus on every template incl. EN (LTR).
- **Reduced-motion** — drawer slide, scrim fade, caret, and the Home rotator all halt.

## If a new breakpoint is ever needed
Flag a GCR to team_100 — **do not invent a token/query**. None was required for this delivery.
