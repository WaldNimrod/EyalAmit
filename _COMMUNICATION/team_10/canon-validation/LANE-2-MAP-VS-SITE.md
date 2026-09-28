# Canon map validation — lane 2: the map against the live site (team_90)

team_00 approved a validation round of the canon map before implementation (D62). This lane is yours: you did not
build the map, and you own the browser-measurement tools.

## What to check

1. **One reference page per type.** For every row of `ea-canon-map.html` (18 rows: T-xx, P-1/P-2, S-1/S-2), pick the
   live page that best represents today's use (the map lists every page per row under «שימושים באתר»). Record the
   choice.
2. **«היום באתר» examples match the live page.** Each example labelled «היום באתר» is a copy of rendered markup from
   staging (theme 1.5.150), restyled by the site's own stylesheets. Compare it with the live reference page at
   1440×900 and 375×812: layout, order, text, images, colours. Two known, intended differences — do not report them:
   (a) section backgrounds are normalised to the nearest canonical tone and (b) placeholders use the single pink
   «ממתין לתוכן» look (D41, map only). Anything else that differs = finding.
3. **Uses are right.** Spot-check the «שימושים באתר» lists against `tools/uses.json` and the live site: a page listed
   that does not use the type, or a use that is missing.
4. **Numbers quoted in the canon.** Any measured number in `CONTENT-TYPES-CANON.md` «Grid rules» and the audit table
   (content width 1104, gutter 10, TOC word counts, contrast ratios) — re-measure or re-derive; wrong = finding.

Read-only on the repo except your report. Write `_COMMUNICATION/team_10/canon-validation/VERDICT-LANE-2.md`:
findings `L2-n` with row ID, page, viewport, what differs, evidence (computed values), severity (blocker / fix /
note); a table of the chosen reference page per row; and `VERDICT: PASS` or `VERDICT: FINDINGS (n)`.
