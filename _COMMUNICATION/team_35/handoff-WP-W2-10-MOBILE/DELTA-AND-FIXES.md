# DELTA & FIXES — vs the desktop elevation (S1.5) + this session's review

team_35 · WP-W2-10 mobile · 2026-06-03. What changed since `README-HANDOFF-INDEX.md` (desktop elevation) and what review comments were resolved. **All changes are additive — no desktop markup was edited; nothing in the signed-off desktop layout regressed.**

---

## A. Delta vs the desktop elevation (S1.5)

| # | Area | Before (S1.5 desktop) | Now (mobile tier) | How |
|---|---|---|---|---|
| D1 | Mobile nav | burger present, **no drawer** | full side-sheet drawer (menu + accordions + utilities + footer links), focus-trap, RTL/LTR | new `ea-mobile-nav.{css,js}` |
| D2 | Nav consistency | each template hard-coded a **different** link subset | **one canonical 10-link nav + 3 dropdowns** built from the locked IA on every template | `ea-mobile-nav.js` rebuilds `.ea-topnav__links` |
| D3 | Footer | per-page stub (`brand + tagline`) | **canonical footer** (brand+location · ניווט · מידע ותקנון · עקבו · copyright), uniform everywhere; 4→2→1 col | `ea-mobile-nav.js` rebuilds `.ea-footer__inner` + `.ea-cfoot` CSS |
| D4 | §4 open questions | unspecified | **decided + implemented** (3-col→3 cards, shop→2col, testimonials→stack, timeline→vertical) with toggleable alternates | `ea-mobile-variants.css` |
| D5 | Responsive lock | ~1px overflow on `/treatment`; mobile spacing unconfirmed | **0 horizontal overflow** at 360/390/414/768; spacing/type confirmed per `BREAKPOINT-NOTES.md` | logical props + scoped rules |
| D6 | Coverage | A/B/E/F + Home elevated | **+ Method, Galleries, Media** brought into the same mobile chrome → all 10 designed templates uniform | 3 `<head>` includes added |
| D7 | Review harness | none | `Mobile UI.html` — 390px frame, template picker, live decision toggles | new |

## B. Review fixes — this session (Nimrod)

| Anchor | Comment (paraphrased) | Resolution |
|---|---|---|
| `Home …:18` | "Main menu isn't uniform across templates — must be uniform and exact, and so must the footer with all the info." | **D2 + D3.** Nav and footer now generated from one locked model; verified identical on all 10 templates (10 items · 3 dropdowns · 7 sub-links · footer 4 cols / 19 links). |
| `Home …:88` | "If there's no image on the left, why is the text so narrow? The home page is missing images." | "What is treatment" section restructured into a **two-column media row** (text + figure); lead width released. Figure is a labelled graceful placeholder (no suitable real studio photo yet). |
| `Home …:119` | "Too sparse — add an image?" | About block restructured into a **portrait media row** using `eyal-portrait-hero.jpg`. |
| `Home …:112` | "Add a sideways-scroll animation that swaps testimonials." | Testimonials rebuilt as an **auto-advancing 1-up rotator** (5 named real quotes, dots, pause on hover/focus, RTL-correct transform, respects reduced-motion). |
| `Memorial …-p` | "nowrap in desktop" | Subtitle is **`white-space:nowrap` ≥768px** and wraps below; replaced the brittle inline `width:600px` with a token-clean class (no mobile overflow). |

## C. Notes / fixes for what's already implemented in the live system

For team_10 when reconciling against the staging build (`eyalamit-co-il-2026`):

1. **Replace, don't append, the nav source.** The live bar still emits a hand-written link list per template. Wire the bar (and drawer) to the **single approved menu** (WP menu location keyed to `site-tree.json`); delete the per-template lists. The mockup proves the exact set and order.
2. **Footer is now a shared template part.** Render `.ea-cfoot` (brand+location · ניווט · מידע ותקנון · עקבו · copyright) from one partial included by every template — not re-authored per page.
3. **Drawer JS, server-rendered menu.** In the mockups JS rebuilds nav/footer because the files are static. In WP: render nav + footer markup **server-side** from the locked IA, and ship **only the drawer-behaviour JS** (open/close/accordion/focus-trap/scrim + the `dir`-aware slide sign). Do not ship the client-side menu-builder.
4. **Burger lives at inline-start, brand at inline-end** — confirm the live bar matches (order: ☰ · שמע · EN · … brand).
5. **`/treatment` overflow** — the offending >100vw element is gone in these mockups; when porting, keep logical props + `max-inline-size:100%` on media and the comparison block.
6. **Sound toggle** ships visual-only (`aria-pressed`) until the didgeridoo audio asset is supplied — keep it keyboard-operable now, wire audio later.
7. **Drawer breakpoint is `≤1023px`** (drawer through tablet) so the full 10-item nav only renders where it fits. If product prefers the old `≤767`, it's a one-line change — flag before build.

## D. Token confirmation
**Zero new tokens, zero new atoms, zero new keyframes, no GCR.** Every mobile rule composes existing `--ea-*`. If a future need arises (e.g. a new breakpoint), it goes to team_100 as a GCR — not invented here.
