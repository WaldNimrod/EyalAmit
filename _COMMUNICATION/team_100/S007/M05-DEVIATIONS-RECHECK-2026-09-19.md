---
id: M05_DEVIATIONS_RECHECK_2026-09-19
schema_version: aos_v1_team_messaging
type: VERIFICATION (team_100 → team_00)
from: team_100
to: team_00
cc: [team_10, team_50]
date: 2026-09-19
source_report: _COMMUNICATION/team_10/S007-M05/FULL-SITE-TYPE-SCAN-2026-09-18.md
theme_at_scan: 1.5.66 live (1.5.67 committed locally by team_10 during this window)
status: MEASURED — one category closed, three still open and none of them by accident
---

# Did the M-05 deviations get fixed? 114 → 60, and the 54 that went are the ones that were ours

team_00 asked for team_10's deviation report to be examined and for confirmation that
everything in it was fixed. **Everything in it was not fixed, and most of it should not have
been.** The precise position, measured today, is below.

## Method

Re-ran **team_10's own scanner** (`tmp/qa/s007-typography/scan_full_site_type.mjs`) — same
tool, same rung table, same ±0.6px tolerance, same `length > 0` plus zero-rect guard — against
the **28 URLs that carried any of the 114 findings**. 28/28 returned ok, 2,903 elements
scanned, zero page failures. Raw: `tmp/qa/s007-typography/m05-recheck.jsonl`.

Using their scanner rather than a fresh one is deliberate: a new tool that finds fewer
deviations proves nothing about the site and everything about the tool.

## The result

| | 2026-09-18 (1.5.60/64) | today (1.5.66) |
|---|---|---|
| total deviations | 114 | **60** |
| `-apple-system` (no font set at all) | 54 | **0** |
| Rubik | 26 | 26 |
| Frank Ruhl Libre | 22 | 22 |
| Arial / arial (post content) | 10 | 10 |
| size | 2 | 2 |
| weight | 0 | 0 |

**The entire delta is the 54 `-apple-system` rows.** Nothing else moved in either direction —
no regression, and no quiet fix either.

## What closed, and why it closed

The 54 were the report's own worst finding: six published pages — `/services/`,
`/shows-heritage/`, `/historical-articles/`, `/thank-you/`, `/courses-soon/`,
`/learning/courses-external/` — rendering skip link, header, brand link, every menu item,
footer `site-info` and the WhatsApp float in the browser's OS default font, because **no CSS
set a font-family there at all**. Closed at 1.5.65 by one rule in `ea-tokens.css`:

`html body { font-family: var(--ea-font); font-size: var(--fs-body); font-weight: var(--fw-body) }`

`html body` and not `body`, for the same reason `body h1` needed 0,0,2: GeneratePress sets
`body{font-family}` at 0,0,1 and loads after this file. That collision has now produced an
inert, correct-looking declaration in this theme three separate times.

## What is still open — three categories, none of them a pending fix

**1. Rubik, 26 elements — a decision team_00 has not been given yet.**
`/courses-soon/` 6, `/learning/courses-external/` 6, `/historical-articles/` 3, `/services/` 3,
`/shows-heritage/` 3, `/thank-you/` 3, plus the footer legal menu on `/about/` and `/press/`.
Source: `style.css` rules scoped to `body.ea-m4-polish` — the rules earlier reports called
"fetched and unused", which M-05 proved live. Collapsing them to Heebo is a one-line change;
whether the six orphan pages should look like the rest of the site is not a typography
question, it is his.

**2. Frank Ruhl Libre, 22 elements — the same decision, plus one genuine new item.**
`.bookcard__t` 11, `.bleed__q` 6 (the element he spotted himself), `.tl__y` 4 — all
deliberate accents, applied consistently inside their own components. **The exception is
`/en/`: `a.ea-en-head__b`, the English page's brand link, one element, which nobody ever
decided and which matches nothing else on that page.** That one reads as an omission, not a
choice.

**3. Arial, 10 elements in 5 old posts — not a CSS problem at all.**
Word- and Facebook-paste residue stored in the database, inside `p.MsoNormal` and nested
`span>span>span` chains. No token touches it; it is a content-cleanup item, and it will
survive every stylesheet change ever made to this theme.

The 2 size readings are unchanged and both already accounted for: the CF7 row label at
`font-size:0` is the canon's own documented exemption, and one `<strong>` at 16px sits inside
the same Facebook-paste content as category 3.

## The limit of this check, stated rather than hidden

**This re-check covered the 28 pages that already had a finding. It is structurally blind to a
new deviation introduced since 2026-09-18 on a page that was clean before** — and four theme
versions shipped in that window. That blind spot is exactly why the typography line of
today's cross-engine wave is told to derive its own page set from the 157-URL list and not to
stop at these 28.

Until that line reports, the honest claim is: **the defect M-05 found is closed and verified;
the remainder is two decisions and a content cleanup; and nobody has yet checked the pages
that were clean.**
