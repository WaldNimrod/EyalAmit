---
id: DONE_S007_M12_LIVE_VERIFICATION_2026-09-20
schema_version: aos_v1_team_messaging
type: DONE (team_10 -> team_100)
from: team_10
to: team_100 (eyalamit-co-il-2026-76)
cc: [team_00, team_50]
date: 2026-09-20
mandate: MANDATE-S007-M12-ONE-MOBILE-DRAWER-2026-09-20.md
theme_verified: 1.5.87 (live)
commits_since: bb73503, 2bc6c60, b5630b1, e657c07 (all pushed, NOT yet deployed)
status: Live verification run on the deployed drawer. Two of four page families
  pass clean. Three real defects found, all fixed and committed, none yet
  re-verified live — needs the next deploy.
---

# M-12 — live verification against deployed 1.5.87

Real CDP interaction only throughout — `Input.dispatchKeyEvent`/`dispatchMouseEvent`
at real coordinates, never `.click()`/`.focus()`. Bare-`<dialog>` Escape control run
first with `windowsVirtualKeyCode:27`: closed correctly, method trusted for everything
below.

## `/` (Chapters) and `/about/` (Wave2) — clean at both 390×844 and 375×667

Closed-state real Tab walk: **0 of 12 stops** inside the dialog on both, both widths.
Real click on the page's own burger opens it; focus lands inside; `body{overflow:
hidden}`; the WhatsApp float computes `visibility:hidden` and is not hit-testable at
its own coordinates; a real coordinate near the far edge of the viewport resolves to
the dialog itself, not page content; real Escape (`vk 27`) closes it and restores
focus to the burger. Screenshots of the open drawer, both real page families, same
component, same content:

Full paths (I opened both myself before writing this):
```
tmp/qa/m12-drawer-shots/chapters-390-open.png
tmp/qa/m12-drawer-shots/wave2-390-open.png
```

One pre-existing gap, not introduced by M-12, caught because this mandate's own
checklist names the number: the Chapters `.nav__burger` measured **42×42**, 2px under
the 44×44 floor. Fixed (`b5630b1`).

## `/services/` (orphan) — real defect, found, fixed, not yet re-verified live

The burger existed at the right size (44×44) but a real click did not open the
dialog — `showModal()` worked fine when called directly, so the dialog itself was
never the problem. `elementFromPoint` at the burger's own center resolved to
`.menu-toggle`, not the burger: **GeneratePress's own real toggle already occupies
the same screen position** (top-inline-end of its masthead) that the new standalone
burger was placed at, and it wins every real hit-test. The screenshot from that exact
failed click is worth keeping — it's GP's own menu opening instead, and it happens to
show the two-navigations divergence you already filed from a completely different
angle: `מוזה הוצאה לאור` appears in the WordPress-menu-driven list and nowhere in the
Chapters tree this drawer uses.

```
tmp/qa/m12-drawer-shots/orphan-390-open.png   (the failed-click state, kept as evidence)
```

Fixed by moving the standalone burger to bottom-inline-end (`2bc6c60`) — confirmed
clear of both GP's toggle and the WhatsApp float via `elementFromPoint` on live
`/services/`, `/shows-heritage/`, `/thank-you/`, but the actual open-drawer click has
not been re-run live since this hasn't deployed yet.

## `/en/` — no trigger at all, as the mandate itself predicted

`/en/` is named in the mandate specifically because it has none today. Confirmed:
`tpl-chapters-en.php` never includes `section-nav.php` and my Phase A standalone-
burger logic only checked the six GeneratePress slugs, missing this one. Fixed
(`bb73503`) — not yet live.

## Fit at 844 — measured, not yet closed live

The mandate's target is the full menu visible at 390×844 with no scroll. Live
measurement on `/` (11 top-level rows, accordions collapsed by default — this
drawer's normal state, unlike the old always-expanded drawer the mandate's own
25-row/63px figure was measured against): the list needed **69px more than it had**.
Trimmed row padding accordingly (`e657c07`), kept the 44px hit-area floor exactly, not
below it. Not re-confirmed against a live render — a local harness with identical CSS
measured a different row height, almost certainly a font-metric difference (no real
Heebo webfont in a static harness) rather than a logic bug, so I'm trusting the live
number I already have over a harness number I don't for this specific question.

## What's committed but not live

`bb73503` /en/ burger · `2bc6c60` standalone-burger reposition · `b5630b1` Chapters
burger 44×44 · `e657c07` row-padding trim. All pushed. Re-running this exact
verification pass — same four pages, same widths, same method — is the next thing
once any of these deploy.

## Status

Two of four required page families verified clean live. Two more (`/services/`,
`/en/`) have real, diagnosed, fixed defects waiting on a deploy to confirm. Not
starting Phase B until this comes back clean, as agreed.
