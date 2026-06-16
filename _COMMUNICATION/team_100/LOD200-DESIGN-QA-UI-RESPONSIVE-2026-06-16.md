# LOD200 — Final Design-QA + UI + Full-Responsive Round

**WP (proposed):** `S004-P001-WP002` (milestone S004 *Launch Readiness*) · **Author:** team_100
**Date:** 2026-06-16 · **lod_status:** LOD200 · **Track:** A (Standard) · **Profile:** L0 · **Priority:** HIGH

## 1. Problem statement (LOD100 confirmed)
The site was built page-by-page across many work packages (UI-precision W2-10, mobile W2-14, content W2-15/16).
No single **holistic** pass has audited design fidelity, UI consistency, and full responsiveness across **all** pages
at once. The hard lesson is on record (memory `wp-staging-toolchain`): **structural/a11y/perf gates (axe, Lighthouse,
overflow) do NOT catch visual-fidelity failures** — a page can pass every automated gate and still look nothing like the
mockup (e.g. the WP-W2-10 doubled-nav / footer-as-left-column defects that shipped through all gates). Eyal explicitly
asked for a final design check before launch.

## 2. Solution concept
A final, cross-cutting design-QA + UI-polish + responsive-lock round over the whole site: mockup-vs-live comparison,
token/spacing/type consistency, a full responsive matrix, cross-browser parity, and interaction/motion polish — then
remediate every gap. QA-led (find → fix → re-verify), not a redesign.

## 3. Major components & purpose
- **Design-fidelity sweep** — screenshot mockup-vs-live (puppeteer/Chrome, side-by-side composites) for every route; the model Reads the PNGs and flags drift.
- **UI consistency audit** — tokens (ea-tokens), spacing scale, typography hierarchy, atom usage, button/CTA/link states, empty/loading states — uniform across pages.
- **Responsive matrix** — verify **360 / 390 / 414 / 768 / 1024 / 1440 / 1920** on every page: 0 horizontal overflow, sane reflow, tap targets ≥44px, sticky elements, the FAQ-TOC + carousel + hero-video + drawer behaviours.
- **Cross-browser** — Chrome + Safari (WebKit) + Firefox parity (RTL, object-fit video, backdrop-filter, mask edge-fades, sticky).
- **Interaction & motion** — hover/focus-visible, dropdowns, carousel pause, scroll-spy, `prefers-reduced-motion` honored everywhere, entrance animations.
- **Remediation** — fix found defects (tokens/locked-atoms respected; new atoms only where justified).

## 4. Primary flow (happy path)
Enumerate routes × viewports → capture live + place mockups → diff (visual + measured) → log defects (file:line + repro) → remediate per page → re-capture → Eyal visual review → sign-off.

## 5. Actors / systems
team_100 (architect/QA-lead) · team_35 (mobile/UI builder) · builder · team_50 + team_190 (validate) · **Eyal** (final visual approval) · headless Chrome + system browsers (harness).

## 6. Open decisions (explicit)
- **D-DQA-1 — Design source-of-truth:** team_35 mockups vs the approved `hub/data/site-tree.json` IA where they disagree (the mockups under-specified the nav; the site-tree is the locked IA). *(team_00)*
- **D-DQA-2 — Responsive matrix:** confirm the breakpoint set (proposed 360→1920, 7 widths) and whether landscape/tablet-specific is in-scope.
- **D-DQA-3 — Cross-browser depth:** Chrome+Safari+Firefox latest only, or include older Safari/Samsung Internet?
- **D-DQA-4 — Gate vs cutover:** does this round gate the production cutover, or run in parallel?

## 7. Dependencies & constraints
Depends on content-complete (WP-W2-16 done) and the mockup set (team_35). Constraint: polish/fix only — no new features, no content changes; ea-tokens.css + locked atoms untouched (new atoms only where a real gap requires one).

## 8. Initial success criteria (directional)
Every page visually matches its design intent at every viewport in the matrix; **0 horizontal overflow 360→1920**;
consistent tokens/spacing/typography sitewide; interactions + motion polished and reduced-motion-safe; cross-browser
parity on the agreed set; **Eyal visual sign-off** recorded.

## 9. Out of scope
New features; content/copy changes; full redesign; net-new pages; performance optimization (covered by the geo/SEO WP).

## 10. Risk classification
**Medium** — visual fidelity is partly subjective and spans every page; cross-browser RTL + modern-CSS (object-fit, backdrop-filter, mask) can surface engine-specific defects; remediation scope is discovery-driven (unknown until the sweep runs).

## 11. Track declaration
**Track A (Standard).** Deliverables are concrete (audit + fixes); LOD400 will carry the route×viewport matrix, the
defect log format, and per-page acceptance criteria (incl. the mockup-vs-live screenshot evidence requirement).
