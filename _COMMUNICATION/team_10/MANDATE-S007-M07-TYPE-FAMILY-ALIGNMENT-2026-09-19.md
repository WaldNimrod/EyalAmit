---
id: MANDATE_S007_M07_TYPE_FAMILY_ALIGNMENT_2026-09-19
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00, team_50]
date: 2026-09-19
canon: _COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md
evidence: _COMMUNICATION/team_50/XVAL-TYPOGRAPHY-2026-09-19.md
theme_at_dispatch: 1.5.71
status: DISPATCHED
---

# M-07 · Align every font family to Heebo, through the tokens — with one exception

**team_00, 2026-09-19: «טיפוגרפיה - לתת לצוות 10 לישר הכול נכון דרך הcss ולוודא שתקין.
חריג - ציטוט לדעתי מראש הוגדר שונה או לפחות נטוי. לבדוק.»**

## The exception, checked before dispatch — he is right

`.bleed__q` was serif in the **original** Chapters design commit (`69347c2`), where the token
itself is written `--serif:'Frank Ruhl Libre',serif; /* reserved serif accent */`. It was a
deliberate choice on day one, not drift. **It stays serif.**

**It was never italic.** `font-weight:400` and no `font-style` in that commit or since. Do not
add italic — team_00 said "or at least italic" as a recollection to verify, and the record says
serif, upright. If he later wants italic that is a new instruction, not this one.

## What to collapse

Everything else off Heebo, **by changing the token consumption, not by adding declarations**
(canon §5). Current state, measured across 157 URLs at 1.5.66:

- **Rubik, 26 elements** — `style.css` rules under `body.ea-m4-polish`: `.page-content`,
  `h1.entry-title`, `.page-content h2/h3`, `.ea-instance-catalog__title`,
  `.ea-footer-legal-menu`. Renders on `/services/`, `/shows-heritage/`,
  `/historical-articles/`, `/thank-you/`, `/courses-soon/`, `/learning/courses-external/`,
  and the footer legal nav on `/about/` and `/press/`.
- **Frank Ruhl Libre, 21 of 22** — `.bookcard__t` (11), `.tl__y` (4), and the one on `/en/`:
  `a.ea-en-head__b`, the English page's brand link, which nobody ever decided and matches
  nothing else on that page. **`.bleed__q` (6) is the exception above — leave it.**
  `.st3::after`, `.shstep__dot span`, `.bookcard__cover .ph` are in the same token but did not
  render on any of the 157 URLs; collapse them with the rest rather than leaving a fourth
  state.
- **Suez One (`--display`)** — `.fstep__num`, `.fstep__t`, `.mag-spread__fig figcaption b`,
  `.mag-list__n`, `.mag-list__t`, `.btile__t`. **team_00 named only the quote as an
  exception**, so these collapse too. **But this is the whole magazine vocabulary**: if
  collapsing any one of them visibly breaks a component rather than merely changing its
  typeface, STOP on that selector and report it — do not force it and do not invent a
  compromise.

**Arial on 10 elements in five old posts is NOT yours.** It is Word/Facebook paste residue
stored in the database and no stylesheet touches it.

## Evidence team_00 gets back

For each component family you change — book card, timeline, magazine tiles, the flow steps,
the GeneratePress-shell pages, the footer legal nav, the `/en/` brand link — **one before and
one after screenshot at 1440**, in your report. He asked for alignment, not for a surprise.

## Verification

Re-run a full 157-URL family scan (`tmp/qa/s007-typography/scan_full_site_type.mjs` is the
tool, it takes a JSON array of path STRINGS). Expected result: the only remaining non-Heebo
family is `.bleed__q`, plus the ten Arial rows in post content. Anything else is a miss.

**Buttons do not inherit `font-family`.** The floor added at 1.5.68 covers
`html button/input/select/textarea`; if you touch a control, check it computes Heebo rather
than assuming.

## Limits

Canon §5: change a token, never add a `font-size` or a `font-family` to a component rule.
No `git add -A`. Do not touch `_aos/`. Bump `style.css` `Version:` or the browser serves the
old file. Report to team_100 (`eyalamit-co-il-2026-76`). Validation is team_50's, other engine.
