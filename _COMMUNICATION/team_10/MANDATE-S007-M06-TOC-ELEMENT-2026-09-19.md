---
id: MANDATE_S007_M06_TOC_ELEMENT_2026-09-19
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00, team_50]
date: 2026-09-19
approved_sketch: _COMMUNICATION/team_100/S007/SKETCH-TOC-ELEMENT-2026-09-18.html
canon: _COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md
theme_at_dispatch: 1.5.66
status: DISPATCHED
---

# M-06 · Build the table-of-contents element

**team_00 approved the sketch.** Build it as a real Chapters part. Open the sketch file
itself — it is the spec, it runs, and its comments carry the reasoning.

He expects this to be **reused on other content-heavy pages**, so build a part, not a
fix to one page. First consumer is `/snoring-sleep-apnea/`, which currently carries a
hand-written `<nav class="toc">` inside its first prose body.

## The one rule that is not negotiable

**team_00, 2026-09-19: «אין מצב שרואים גם את הראשוני הפרוס וגם את הצדדים — הצדדי מופיע
רק אחרי גלילה ראשונה».**

The inline list and the floating rail are the **same navigation**. They are never on
screen at the same time. The rail is hidden until the inline list has left the viewport,
and hides again the moment it returns. The sketch implements this with an
`IntersectionObserver` on the inline element toggling `.is-on`; verified at 1440×900 —
hidden at top, visible after scrolling past, hidden again on return.

Use `visibility` + `opacity`, **not `display`**: the transition needs it, and — more
importantly — a `visibility:hidden` rail is out of the tab order. A rail hidden with
`opacity` alone leaves six focusable links that a keyboard user reaches and cannot see.
This site has already shipped that exact bug once, in the mobile drawer.

## The three states

1. **Inline** — beside the intro, in the same grid row. Small: list items on `--fs-xs`,
   the numbering and the eyebrow on `--fs-3xs`, weight `--fw-light`.
2. **Rail** — fixed in the margin, vertical ticks, label on hover/focus, current section
   marked. **It must never overlay content** — that was explicit. In the margin, not over
   the column.
3. **Mobile (≤860px)** — the rail is gone entirely; a pill opens a `<dialog>` sheet with a
   **real close button**. Native `<dialog>` + `showModal()`, so focus trap, Escape and
   focus-return are the browser's job. Closing on link-click as well, as in the sketch.

## Hard requirements

- **Only locked tokens.** Every size from the twelve rungs, every weight from the eight.
  **No new value.** Canon §1. If a role has no rung, ask — do not invent one.
- **Set `font-family` explicitly on every `<button>` you render.** A button does not
  inherit it. That exact omission has produced three separate defects on this site in two
  days: the carousel arrows, six entire pages, and the lightbox chrome I built myself.
- **Headings.** The element's own label is not a section heading — do not emit `h2`. One
  `h1` per page and no skipped levels is verified by the gate.
- The rail's links and the sheet need real accessible names (`aria-label` on each `nav`,
  `aria-haspopup="dialog"` on the pill) — the sketch has them.
- `prefers-reduced-motion` respected, as in the sketch.
- The part must degrade to nothing when a page passes it no items.

## Wiring it to the page

`/snoring-sleep-apnea/` has its TOC hand-written as a `<nav class="toc">` with an `<h2>`
inside the first prose body. **Move it to the new part** — the links and their text are
Eyal's, do not rewrite them, only relocate. That `h2` disappears with it.

## Limits

- Do not touch the type scale, the weight scale, or `--sec`.
- No `git add -A` / `git add .` (charter §5.4). Do not touch `_aos/`.
- The deploy script ships the **working tree** and refuses a dirty `site/`. Commit first.
- Bump `style.css` `Version:` on any theme change, or the browser serves the old file.

## Verification before you report

At 1440 and at 390: that the rail is hidden at scroll 0, appears after the inline list
leaves the viewport, and hides again on return — measured, not eyeballed. That the sheet
opens, closes by button, by backdrop and by Escape, and returns focus to the pill. That
every size and weight in the element computes to a rung. That the page still has exactly
one `h1` and no skipped level.

Report to team_100 (`eyalamit-co-il-2026-76`) with the theme version you ended on.
Validation is team_50's on a different engine — you build, you do not validate your own.
