---
id: XVAL_BRIEF_S007_DESKTOP_CANON_2026-09-18
schema_version: aos_v1_team_messaging
type: CROSS-ENGINE VALIDATION BRIEF (team_100 → team_50 line)
from: team_100
to: team_50 (cross-engine, Grok — builder was Claude Opus 5, Iron Rule #1)
cc: [team_00]
date: 2026-09-18
theme_under_test: 1.5.56
status: DISPATCHED
---

# Cross-engine gate · the S007 desktop typography layer

team_00's gate before mobile work may begin: **"להריץ בדיקות וולידציות כלל בקרת איכות
ודיוק קאנון css בחוצה מנועים להיות בטוחים ששכבת הדסקטופ מדוייקת מלאה וללא חריגות."**

Your job is to **falsify** the claims below, not to confirm them. A clean result is only
worth something if you tried to break it. **A tool reporting "no issues" is a fact about
the tool** (charter §8א clause 5).

## The claims under test

**C1 — the scale exists as twelve rungs and nothing else.**
`assets/css/ea-tokens.css` defines `--fs-h1 --fs-display --fs-h2 --fs-h4 --fs-lead --fs-h3
--fs-nav --fs-body --fs-sm --fs-xs --fs-2xs --fs-3xs` plus six `--fw-*`. Claim: no live
stylesheet declares a `font-size` that is not one of those, apart from three deliberate
exemptions, each annotated in place with its reason — `.nav__caret` (`.6em`, a glyph sized
off its parent), `.testi-mq__btn` (carousel arrow), and a CF7 label at `font-size:0`
(hidden on purpose).

**C2 — five of the rungs are team_00's own approved numbers.**
From the combination he approved: body 17px is the anchor, nav ×1.08, h3 ×1.10, h2 ×1.45,
h1 ×2.60. Claim: the shipped rem values are those pixel values over a 16px root, exactly —
`--fs-body:1.0625rem`, `--fs-nav:1.1475rem`, `--fs-h3:1.16875rem`, `--fs-h2:1.540625rem`,
`--fs-h1:2.7625rem`. **One deliberate departure:** `--fw-h3` is 600, not the 500 in that
URL, because «H3 יותר כבד» came afterwards.

**C3 — nothing off-scale renders on any page family.**
The site is 157 published URLs (103 pages, 54 posts) which group into **16 distinct
CSS-plus-template families**. The full list is
`_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv`. Claim: at 1440×900,
every rendered text element on a representative of each family computes to one of the
twelve rungs (±0.6px). **Derive the 16 families yourself** — do not take my grouping.

**C4 — the rungs are `rem`, and text resize works.**
Claim: doubling the root font size doubles every rung exactly, and no page scrolls
horizontally at 200%.

**C5 — heading hierarchy is intact.**
Claim: one `h1` per page, no skipped levels, on every family.

## Where this is most likely to be wrong — attack here first

These are the traps that already produced confident wrong answers on this site today. Two
of them were mine.

- **Search the wrong PROPERTY and you get a clean zero.** `ea-tokens.css` reports zero
  `font-size` declarations and holds nine composite tokens inside the **`font:` shorthand**.
  Two independent passes recorded that file as empty. Check `font-size`, `font:` and
  `font-weight` separately.
- **A stylesheet list read off two pages is a claim about two pages.** `faq-toc.css` loads
  only on `/faq/`; `ea-blog.css` only on blog views; `books-v2.css` on book *detail* pages
  but not the hub; `home-front.css` only on `/`. My original nine-file list missed two live
  sheets entirely.
- **Specificity, not just presence.** A correct declaration can be inert. The base floor in
  `ea-tokens.css` was shipped at `0,0,1`, which lost to GeneratePress's `main.min.css`
  `h1{font-size:42px}` on source order — the token sat unused in the cascade behind it.
  Check computed values, never declarations alone.
- **Six pages render outside every Wave2 template whitelist** (`/services/`,
  `/shows-heritage/`, `/historical-articles/`, `/thank-you/`, `/courses-soon/`,
  `/learning/courses-external/`). They had no tokens at all until 1.5.55. Verify they do now.
- **`scrollHeight > clientHeight` is not clipping** unless an ancestor actually clips.

## Report

```
_COMMUNICATION/team_50/XVAL-S007-DESKTOP-CANON-2026-09-18.md
```

Per claim: **CONFIRMED** or **FALSIFIED**, with the command or the URL-and-selector the
verdict rests on. Split the run into short lines — one claim per line. **Do not raise a
timeout to make a long line fit; split it again.** Engine order is Grok first (D-18).

If you falsify something, say so plainly and do not soften it. The last two cross-engine
findings on this milestone were both correct and both contradicted me, and both were worth
more than agreement would have been.
