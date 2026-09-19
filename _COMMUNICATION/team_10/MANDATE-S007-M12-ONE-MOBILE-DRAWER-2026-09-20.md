---
id: MANDATE_S007_M12_ONE_MOBILE_DRAWER_2026-09-20
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00, team_50]
date: 2026-09-20
decisions: [D-29, D-30, D-31, D-32, D-33]
decision_record: _COMMUNICATION/team_00/DECISION-S007-MOBILE-NAV-MECHANISM-2026-09-19.md
design_source: _COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/
baseline: _COMMUNICATION/team_50/XVAL-MOBILE-BASELINE-2026-09-19.md
theme_at_dispatch: 1.5.83
status: DISPATCHED — M-11 closed clean on 2026-09-20, hold lifted
---

# M-12 · One mobile drawer, every page, on the browser's own modal

**Read `DECISION-S007-MOBILE-NAV-MECHANISM-2026-09-19.md` first.** Every choice below is
already made and recorded there with team_00's own words. This mandate is the build, not the
argument. If something here contradicts that record, the record wins and you tell me.

## What is being replaced

Three different mobile menus are live and which one a visitor meets depends only on which page
they opened. Nobody chose this — the Chapters system replaced the navigation after the June
design had been implemented, and that work was orphaned.

- **Chapters `.nav__burger`** — most of the site. Behaviourally the best of the three.
- **Wave2 `ea-mnav`** — `/about/` and `/press/` only. The **designed** one.
- **GeneratePress `.menu-toggle`** — `/services/`, `/shows-heritage/`, `/historical-articles/`,
  `/thank-you/`, `/courses-soon/`, `/learning/courses-external/`. A white panel with the brand
  in lowercase Latin. A visitor landing there sees a different site.

## The decisions, so you do not have to go looking

- **Look:** the June package's drawer. team_00: «עברתי על הסקיצה היא בסיס טוב».
- **Mechanism:** a native `<dialog>` opened with `showModal()`. Focus trap, Escape, background
  inertness and focus-return are then the browser's job. This site has shipped the wrong
  version of two of those.
- **Scope:** **«הכול כולל הכול בלי שום עמוד חריג»** — every page, the six parent-theme pages
  included. **This is the clause most likely to be quietly dropped**, because those six have
  been missed by every sweep on this milestone. Prove you covered them.
- **The page behind it locks completely.** He approved that explicitly: no partial drawer, no
  peeking edge, no scrolling behind it.
- **The WhatsApp float goes behind or away while it is open.** Already true via
  `visibility:hidden` under `.ea-mnav-open` and `body.nav-locked` — keep whatever flag your
  new drawer sets working with that rule, or update the rule.

## Fit, measured — this is what «חובה לוודא שנכנס במסך או לצמצם רווחים» means

Measured on the live drawer at **390×844**: 11 top-level items, **25 rows in total** because
the three sub-lists are open by default and nothing collapses. The list box is **597px**, the
content **660px**, `overflow-y:auto` already present, **18 of 25 rows fully visible**, **63px
below the fold**.

So: **trim roughly 3px of vertical padding per row** and the whole menu fits a 844-tall phone
with no scrolling at all. Two limits on that:

- **Keep `overflow-y:auto`.** A 375×667 phone is 177px shorter and no sane trim closes that.
  Never `overflow:hidden` on that list.
- **Do not take a row below a 44×44 hit area to win space.** Rows are 59px today. Trimming 3px
  keeps them clear. Trading an accessibility floor for space is not a win.

## Adaptation — the June package is a base, not a spec to copy

- **Every font size in those mockups is dead.** They predate the locked scale by three months;
  canon §7 lists the dead figures. Re-type onto the twelve rungs. Never copy a number across.
- **Set `font-family` explicitly on every `<button>`.** Four separate live defects this week.
- **Four elements postdate the package** and are not in it: the TOC in its three states, the
  image lightbox, the FAQ accordion, the testimonial cards.
- **The section rhythm moved** after team_00 asked for less air: `--sec` is
  `clamp(62px,6.2vw,88px)`.

## Hard requirements

- `visibility:hidden` or `display:none` for the closed drawer — never `transform` alone. The
  old one kept **22 of 28 stops on `/about/`** reachable by keyboard while closed.
- **Never `visibility:hidden` on an element that carries a control's accessible name.** Hide
  the container; the name must survive.
- `prefers-reduced-motion` respected.
- The drawer's own list scrolls; the page does not.

## Verification, and it must be measured

At **390×844 and 375×667**, on at least one page of each of the three systems being replaced —
so `/`, `/about/`, and `/services/` at minimum, plus `/en/` which today has no burger at all:

- A **real tab walk** with real key events. Closed: **zero** stops inside the drawer. Open:
  focus enters it, Escape closes it, focus returns to the opener.
- `elementFromPoint` at real coordinates for background reachability — **not `element.click()`,
  which bypasses hit-testing entirely and cannot answer this.**
- **Escape needs `windowsVirtualKeyCode: 27`** in the CDP call or the dialog stays open and you
  will report a defect that is not there. Run a bare-`<dialog>` control first; if that does not
  close, your method is disqualified.
- Every row's hit area ≥44×44. The full menu visible without scrolling at 844; degrading to an
  internal scroll at 667.
- The WhatsApp float not hit-testable while the drawer is open.
- Screenshots of the open drawer on each of the three page families.

## Limits

No `git add -A`. Do not touch `_aos/`. Bump `style.css` `Version:`. **Do not deploy** — the
standing instruction is one deploy at the end, and another session shares this worktree, so
commit as you finish each piece rather than leaving the tree dirty. Report to team_100
(`eyalamit-co-il-2026-76`). Validation is team_50's, on a different engine.
