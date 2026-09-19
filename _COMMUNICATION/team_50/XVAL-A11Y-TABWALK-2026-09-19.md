---
id: XVAL_A11Y_TABWALK_2026-09-19
schema_version: aos_v1_team_messaging
type: CROSS-ENGINE VALIDATION RESULT (team_50 line → team_100)
from: team_50 (cross-engine line, cursor-grok-4.6-high)
to: team_100
cc: [team_00, team_10]
date: 2026-09-19
theme_under_test: 1.5.66 (start and end — no drift)
prompt: tmp/qa/xval-2026-09-19/A3b-tabwalk.txt
verdict: FALSIFIED — the #peek CTA on the home page takes real Tab focus inside an opacity:0 reveal wrapper
---

> Builder engine was Claude Opus 5. Validator engine is Grok — Iron Rule #1 at engine level.
> This line is one third of an accessibility brief that timed out empty twice at 900s; the
> fix on this project is to split the measurement work, never to raise the timeout. Raw
> output follows verbatim.

I'll treat this as a falsification pass only: live CSS version first, then a real Tab walk on `/` and `/contact/` at 1440×900 — no simulated focus loop, no fixes.Homepage loaded (77,356 bytes, tokens `1.5.66`). Next I’ll find a real-key Tab walker — a simulated focus loop is out of bounds for this claim.Existing CDP harness is usable. I’ll inspect how prior Tab walks sent real keys, then run the same pattern on `/` and `/contact/` only.I’ll run a real-Tab walk at 1440×900, cap at 60 stops per page, and classify each stop after the browser’s own focus scroll — no simulated focus loop.One home stop flagged `ancestor-opacity:0` and the clip screenshot hit the 0-height trap. I’ll pull that ancestor chain and the live `?ver=` independently — the probe’s version parse came back empty.**Claim is false on `/`.** One real-Tab stop was reachable while an ancestor was still `opacity: 0` with `visibility: visible`. `/contact/` did not show that pattern in the stops that were walked.

Method: Chrome, 1440×900, real `Tab` (CDP key events), no `element.focus()` loop. After each Tab, 450 ms settle, then `getBoundingClientRect()` + computed `visibility` / `opacity` / `display`, plus whether the box intersected the viewport after Chrome’s own focus scroll. Pages asserted loaded (`/` DOM 78,365 bytes, `/contact/` 50,773; both had `.ea-skiplink` and `#main`, HTTP 200, 1440×900).

---

### `/` — 60 stops, **hit the cap** (stopped at stop 60: `a` «שיעורי דיג׳רידו»). Not the end of the document.

**Offending stop: 39**

| | |
|---|---|
| Element | `a.btn.btn--terra` «לתיאום שיחת היכרות» `href="/contact/"` |
| Path | `main#main > section#peek > div.wrap > p.r > a.btn` |
| Rect (after focus scroll) | `{ x: 168, y: 856.1, w: 201.4, h: 55.7 }` top 856.1 / bottom 911.8 / left 168 / right 369.4 |
| Own computed | `visibility: visible`, `opacity: 1`, `display: inline-flex` |
| In viewport after focus scroll | **yes** (intersects; not fully inside — bottom 911.8 > 900) |
| `scrollY` | 8379 |
| Ancestor | `p.r` — `display: block`, **`visibility: visible`**, **`opacity: 0`**, class `r` with **no** `in` |
| Closed menu | no |

This is the classic bug: `.r { opacity: 0 }` under `prefers-reduced-motion: no-preference` does not set `visibility: hidden`, so the CTA stays in the tab order while the wrapper paints nothing. The live IO uses `threshold: 0.1` and `rootMargin: 0px 0px -7% 0px`; at 1440×900 that cuts 63 px off the bottom of the root, so a focused control sitting at y=856 is in the layout viewport and still **outside** the observer root. Class `in` was never added.

**Paint could not be sampled.** Clip screenshot failed with `Cannot take screenshot with 0 height.` Rectangle above is the measurement; computed style is not a paint sample.

No other home stop in 1–60 was off-screen, zero-sized, `opacity: 0`, `visibility: hidden`, `display: none`, or behind a closed menu. Stop 36 (`a.btn.btn--terra.r.in`) was mid-fade at computed opacity **0.342711** — not counted as invisible.

---

### `/contact/` — **none in 55 focusable stops**

Walk returned to `BODY` on stop 56 (end of this page’s cycle). Stops 1–55: skip-link, RTL nav + submenus, EN, CTA, CF7 fields, then footer links. Every one had `visibility: visible`, `opacity: 1`, non-zero box, intersecting the viewport after focus scroll, not in a closed drawer/submenu.

---

### Theme `?ver=` on `ea-tokens.css`

- **Start** (curl of `/` before the walk): **1.5.66**
- **End** (curl of `/` and `/contact/` after the walk): **1.5.66** on both

An in-page stylesheet parse in the Tab script returned `null`. That is a fact about the probe regex, not about the site. The live HTML still had `ea-tokens.css?ver=1.5.66` at both ends.