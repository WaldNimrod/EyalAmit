---
id: DONE_S007_M12_PHASE_A_VERIFIED_CLEAN_2026-09-20
schema_version: aos_v1_team_messaging
type: DONE (team_10 -> team_100)
from: team_10
to: team_100 (eyalamit-co-il-2026-76)
cc: [team_00, team_50]
date: 2026-09-20
mandate: MANDATE-S007-M12-ONE-MOBILE-DRAWER-2026-09-20.md
theme_verified: 1.5.88 (live)
status: Phase A fully verified clean, all four required page families, both
  required widths. Starting Phase B.
---

# M-12 Phase A — clean on the deployed 1.5.88

Full re-run of the same real-CDP verification pass (bare-`<dialog>` Escape control
first, `windowsVirtualKeyCode:27`, real `dispatchKeyEvent`/`dispatchMouseEvent`, never
`.click()`/`.focus()`) against the actual deployed site. Every one of the four
required page families, both required widths (390×844, 375×667):

- **Closed-state real Tab walk: 0 of 12 stops inside the dialog**, on all 8
  page×width combinations. The two prior real defects (`/services/` not opening,
  `/en/` having no trigger at all) are both gone — real click opens the dialog on
  every page now, including both.
- **Burger hit area: 44×44 on all 8** — the Chapters burger's pre-existing 42×42 is
  fixed too.
- **Open state, every combination:** focus inside the dialog, `body{overflow:
  hidden}`, WhatsApp float `visibility:hidden` and not hit-testable at its own
  coordinates, real Escape closes it and restores focus to the opener.
- **Fit at 844 vs 667, measured directly on `/`:** at 390×844 the list's
  `scrollHeight` now equals its `clientHeight` exactly — **the full menu fits with
  zero scroll**, matching the mandate's target. At 375×667 it needs 158px of internal
  scroll, which is the mandate's own stated degradation for the shorter phone, not a
  defect — `overflow-y:auto` confirmed present and working.

Screenshots of the open drawer, all four families, saved under
`tmp/qa/m12-drawer-shots/`: `chapters-390-open.png`, `wave2-390-open.png`,
`orphan-390-open.png`, `en-ltr-390-open.png`.

Nothing outstanding from this mandate's own checklist. Starting Phase B now.

## Noted, not acted on (not this mandate's job)

Per your message: the placeholder-pages ruling
(`DECIDE-S007-PLACEHOLDER-PAGES-2026-09-20.md`) and the live confirmation that
`/learning/courses-external/` is the only placeholder reachable from a live menu
today, under a label that resolves to href="#" on the Chapters side (which is why
this drawer omits it) — R2-007. No indexing/publish-state action is this mandate's
to take, and none was taken.

## Phase B starting

Six orphan pages' bar chrome, per your go-ahead. Sound toggle will not propagate to
them — already true in the current code (`show_sound` is keyed off the same
no-burger-page list the standalone burger uses), carrying forward as the bar itself
is rebuilt.
