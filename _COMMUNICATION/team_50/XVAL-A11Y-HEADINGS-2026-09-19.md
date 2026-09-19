---
id: XVAL_A11Y_HEADINGS_2026-09-19
schema_version: aos_v1_team_messaging
type: CROSS-ENGINE VALIDATION RESULT (team_50 line → team_100)
from: team_50 (cross-engine line, cursor-grok-4.6-high)
to: team_100
cc: [team_00, team_10]
date: 2026-09-19
theme_under_test: 1.5.66 (start and end — no drift)
prompt: tmp/qa/xval-2026-09-19/A3a-headings.txt
verdict: headings and one h1 per page — CONFIRMED on 12 URLs, /about/ duplicate h1 is fixed
---

> Builder engine was Claude Opus 5. Validator engine is Grok — Iron Rule #1 at engine level.
> This line is one third of an accessibility brief that timed out empty twice at 900s; the
> fix on this project is to split the measurement work, never to raise the timeout. Raw
> output follows verbatim.

I'll falsify the heading claim on those 12 URLs only: DOM reads (not the accessibility tree), live `ea-tokens.css` `?ver=` at start and end, and a load assertion on every page before trusting its headings. Starting the AOS health probe and the first CSS version check now.Start version is `ea-tokens.css?ver=1.5.66`. Next I’ll read the live DOM on those 12 URLs via CDP (not the accessibility tree) and assert each page actually loaded.I'll probe the rendered DOM with CDP (`document.querySelectorAll` on heading tags), retry short/incomplete staging responses, and treat a missing `main` plus short HTML as a failed load—not a heading result.The first DOM pass did not break the claim. Next I’ll try to falsify it: extra `role="heading"` nodes, a second `/about/` h1, and a home-page h2 count vs the 10-vs-11 trap.The claim **did not break** on this 12-URL DOM campaign. That is a failed falsification on this set, not a statement about the rest of the site.

**Method:** live Chromium CDP, `document.querySelectorAll('h1,h2,h3,h4,h5,h6')` in document order. **DOM, not the accessibility tree.** No visibility filter. No `role="heading"` extras on the pages I re-checked (`/`, `/about/`, `/services/`, `/en/` — count 0). Home **h2 count in DOM = 10** (the 11-vs-10 trap).

**Load assertion (all 12):** `htmlLen` 46 714–158 890, `bodyLen` ≥ 14 441, `main` present, `ea-tokens.css` linked, non-empty `title`. Incomplete-response retries not needed; each page loaded on attempt 1.

| URL | html bytes | h1 | sequence | verdict |
|---|---:|---:|---|---|
| `/` | 78 213 | 1 | h1 h2 h2 h2 h3 h3 h2 h2 h2 h2 h2 h2 h2 | no counterexample |
| `/about/` | 71 887 | 1 | h1 h2 h2 h2 | no counterexample |
| `/press/` | 96 874 | 1 | h1 h2 h2 h2 h3 h3 h2 | no counterexample |
| `/contact/` | 50 647 | 1 | h1 h2 h2 h3 | no counterexample |
| `/faq/` | 158 890 | 1 | h1, then 16×(h2 then n×h3): 23,8,8,9,5,7,5,4,6,19,7,6,5,6,11,6 h3s | no counterexample |
| `/shop/` | 50 516 | 1 | h1 h2 h2 h2 h2 h2 | no counterexample |
| `/treatment/` | 86 607 | 1 | h1 h2×8 h3×21 h2 h2 h2 | no counterexample |
| `/blog/` | 66 593 | 1 | h1 + 12×h2 | no counterexample |
| `/snoring-sleep-apnea/` | 77 454 | 1 | h1 h2×5 h3 h3 h3 h2×10 | no counterexample |
| `/accessibility/` | 52 225 | 1 | h1 + 6×h2 | no counterexample |
| `/services/` | 54 004 | 1 | h1 only | no counterexample |
| `/en/` | 46 714 | 1 | h1 h2 h2 h2 h2 | no counterexample |

Zero pages with 0 or >1 `h1`. Zero downward skips (no h*n* then h*n+2*). No `h4+` anywhere in this set. `/2228-2/` was not opened.

**`/about/` duplicate-h1 claim:** one `h1` (“אודות אייל עמית”), `display:block` / `visibility:visible`, under `main` → `section.ea-content-section`. Raw HTML `<h1` open-tag count = 1. Leaf-text matches for that string: `<title>`, JSON-LD `<script>`, that one `<h1>`. No second heading node.

**`ea-tokens.css?ver=`:** start **1.5.66** · end **1.5.66** (unchanged).