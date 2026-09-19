---
id: XVAL_A11Y_CONTRAST_2026-09-19
schema_version: aos_v1_team_messaging
type: CROSS-ENGINE VALIDATION RESULT (team_50 line → team_100)
from: team_50 (cross-engine line, cursor-grok-4.6-high)
to: team_100
cc: [team_00, team_10]
date: 2026-09-19
theme_under_test: 1.5.66 (start and end — no drift)
prompt: tmp/qa/xval-2026-09-19/A1-contrast.txt
verdict: both claims CONFIRMED — the active chip fix holds; the footer line still fails
status: FOOTER REMAINS OPEN — owner is whoever owns the 0.45 opacity, not this line
---

> Builder engine was Claude Opus 5. Validator engine is Grok — Iron Rule #1 at engine level.
> Painted-pixel sampling with rgba flattening, per the traps this project has already been
> caught by. One correction to our own record: the 4.4867 figure filed on 2026-09-18 does not
> reproduce; the live pair measures 4.4960 against a painted #0E0905. Still a fail either way.
> Raw output follows verbatim.

I'll verify only A1 and A2: live contrast on the filter chips and footer line, plus the `ea-tokens.css` version at start and end. Starting with session identity, health, and the live CSS `?ver=` before any measurements.Start `?ver=` is **1.5.66**. Next I’ll load the validator activation, inspect how contrast is sampled, then measure the live chips and footer against painted pixels.Previous XVAL used painted-pixel sampling via Puppeteer. I’ll reuse that method independently and search the repo for any document that claims the footer line passes.Python Playwright and PIL are available. I’ll measure painted pixels (not ancestor `backgroundColor`) and scan the repo for any claim that the footer line passes.Writing a Playwright probe that samples painted pixels, flattens `rgba()`, and asserts each page actually loaded before any ratio.First pass had bad samples: the active treatment chip stayed off-screen, and capsule-edge pixels mixed with the page. Re-measuring with window scroll and center samples after hiding the ink.Independent verifier, engine this session, no site changes. Attempted to break both claims. Live `ea-tokens.css?ver=` was **1.5.66** at the start of the run and **1.5.66** at the end.

Pages were asserted loaded (HTML byte length + known elements, 1440×900, DPR 1) before any ratio. Staging TLS ignored by design. No axe/Lighthouse; a scanner “clean” result would not have counted.

---

## A1 — active filter chip fail is closed

**CONFIRMED** (could not falsify). Live painted fill of `.dd__item--active .dd__tag` is `--terra-btn` `#B05F38` / `rgb(176, 95, 56)`, white on that fill is **4.6255:1**, which clears 4.5:1. Brand `--terra` is still `#B5663D` (the old 4.2573 pair). Inactive chips and the FAQ active chip match the cited numbers.

| Instance | Load | FG | Painted BG | Size / weight | Need | Ratio | vs 4.5 |
|---|---|---|---|---|---|---:|---|
| `/treatment/` active «תהליך אישי» | 86 619 B, `#main`=1, `.dd__tag`=3, active=1 | `rgb(255,255,255)` | `rgb(176, 95, 56)` `#B05F38` | **11.05px / 300** (not large) | 4.5:1 | **4.6255** | PASS |
| `/lessons/` active «שלב 1» | 72 334 B, `.dd__tag`=5, active=1 | same | same | **11.05px / 300** | 4.5:1 | **4.6255** | PASS |
| `/treatment/` inactive ×2 | same load | white | `rgb(120, 102, 81)` `#786651` `--muted` | 11.05px / 300 | 4.5:1 | **5.5003** | PASS |
| `/lessons/` inactive ×4 | same load | white | same `#786651` | 11.05px / 300 | 4.5:1 | **5.5003** | PASS |
| `/faq/` `.ea-faq-toc__link.is-active` «טיפול בדיג'רידו» | 158 898 B, 16 chips, 1 `.is-active` | white | `rgb(164, 78, 43)` `#A44E2B` `--ea-terracotta` | **13.6px / 300** | 4.5:1 | **5.6709** | PASS |

**Token check (live `:root`, not source):** `--terra` = `#B5663D` (untouched). `--terra-btn` = `#B05F38`. Active `.dd__tag` computed `background-color` is `rgb(176, 95, 56)` with `background-image: none`, `opacity: 1`, `mix-blend-mode: normal`, `background-clip: border-box`. That is the existing button token, not a new colour, and not `--terra`.

White on leftover `--terra` `#B5663D` / `rgb(181, 102, 61)` is still **4.2573:1**. That pair is not what the active chip paints now.

**Method:** Chrome, viewport 1440×900, DPR 1, 800 ms settle after `scrollIntoView`. Foreground = computed `color`. Background = painted pixels of the chip’s **side padding** (3×4 viewport clip) plus Playwright **element screenshot** padding/center. Both agreed, `nuniq=1`, `stdev=0`, and matched computed own fill. Center of the element screenshot had extra colours from glyphs; padding did not. Hiding the ink and sampling the box centre was discarded: it returned a different RGB than the chip (treatment `rgb(183,109,73)` / lessons mixed `rgb(128,70,41)`). That is a fact about that method, not about the chip.

Chip type is 11.05px / 300, not the old 8.96px. Still nowhere near the large-text carve-out (≥24px, or ≥18.66px at 700).

---

## A2 — footer muted line still below threshold; no document claims a pass

**CONFIRMED** on both directions (could not falsify). It still fails 4.5:1. Nothing in this repo states that this line passes.

| Page | Load | Selector / text | FG (flattened) | Painted BG | Size / weight | Need | Ratio |
|---|---|---|---|---|---|---|---:|
| `/treatment/` | 86 619 B, `.foot__brand p`=3 | tagline / `.foot__nap` / `.foot__tel` | `rgba(255,255,255,0.45)` → `rgb(122.45, 119.70, 117.50)` | `rgb(14, 9, 5)` `#0E0905` | **13.6px / 300** | 4.5:1 | **4.4960 FAIL** |
| `/lessons/` | 72 334 B | same three | same | same | 13.6px / 300 | 4.5:1 | **4.4960 FAIL** |
| `/blog/` | 66 537 B | same three | same | same | 13.6px / 300 | 4.5:1 | **4.4960 FAIL** |
| `/shop/` | 50 526 B | same three | same | same | 13.6px / 300 | 4.5:1 | **4.4960 FAIL** |

Unflattened `rgba(255,255,255,0.45)` against black would print a nonsense ~19:1. Flattened against the painted footer it is **4.4960**. 13.6px / 300 is not large text, so 3:1 does not apply. 4.4960 < 4.5, so it fails. Rounding 4.496 to two decimals as “4.50” is not a WCAG pass.

**Number vs 2026-09-18:** I did **not** reproduce 4.4867 on `rgb(12, 8, 4)`. On all four pages the painted footer behind the hidden ink, and the padding just above the text, was a flat `rgb(14, 9, 5)` (`nuniq=1`), which is computed `--dark`. That is the 4.4960 pair already on file as the token-arithmetic miss. The line is still a fail; the 4.4867 painted figure is not the live number today.

**Does some report claim it passes?** No. Searched `_COMMUNICATION/` and the rest of the repo. Every mention of this pair calls it a fail or an open near-miss:

- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/XVAL-B2-MUTED-CONTRAST-2026-09-18.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/XVAL-B2-MUTED-CONTRAST-2026-09-18.md) — **4.4867 FAIL**
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/HANDOFF-CURRENT-S006.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/HANDOFF-CURRENT-S006.md) — still **open**, “4.4867:1”
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/A11Y-P2-OPEN-PACKAGE.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/A11Y-P2-OPEN-PACKAGE.md) — **4.4960:1** “genuine near-miss”
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/03-DONE-CONTRAST-TOKENS.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/03-DONE-CONTRAST-TOKENS.md) — “4.496 (rounds to 4.50)” then **§6: not fixed**
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-M04/A11Y-RECHECK-2026-09-18.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-M04/A11Y-RECHECK-2026-09-18.md) — **4.496**, “literal WCAG number it is under”

“Footer legal text passes” in B2 is `.foot__disc` / `.foot__base` at 0.62 opacity, not this 0.45 brand/NAP/phone line.

**Method:** same Chrome/viewport. Computed `color` flattened onto painted pixels. Two paints agreed: (1) `color:transparent; text-shadow:none` then 6×6 at the text-box centre; (2) 6×4 in footer padding above the glyphs. Own `background-color` of the `<p>` is `transparent` — an ancestor walk would have been the wrong tool; the paint is the footer `--dark` fill.

---

## Theme version

| When | `ea-tokens.css?ver=` |
|---|---|
| Start (home HTML 85 259 B) | **1.5.66** |
| During (all five measured pages) | **1.5.66** |
| End (home 77 356 B, `/treatment/` 85 846 B, `/faq/` 162 661 B) | **1.5.66** |

Nothing was fixed. Next owner of A2 remains whoever owns the footer 0.45 opacity, not this line.Both measurement runs finished. The live numbers they produced are the ones in the A1/A2 report: active chips at **4.6255:1** on `--terra-btn`, footer brand line still **4.4960:1** against painted `rgb(14, 9, 5)`, theme **1.5.66** throughout.