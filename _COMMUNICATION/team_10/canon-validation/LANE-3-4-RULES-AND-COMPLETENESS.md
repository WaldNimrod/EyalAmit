# Canon map validation — lanes 3 and 4: the rules, completeness, rebuild

Written as a re-runnable checker, from the **written canon**, not from the map's build code. The checker lives in
`_COMMUNICATION/team_10/canon-validation/check_map.py` and writes `VERDICT-LANE-3-4.md` next to this file.

## Lane 3 — every approved example against the rules (in a real browser, 1440×900 and 375×812)

Source of the rules: `CONTENT-TYPES-CANON.md` «Grid rules» and «Canon terms and site-wide rules». For every example
labelled «מאושר» in `ea-canon-map.html`:
- **Grid**: six columns on the content box (1104px at 1440), gutter 10px. Every direct layout child's left and right
  edges fall on a column line (±1.5px) — except full-bleed media, which may reach the screen edge.
- **Compositions**: any grid of 1–10 known items uses one of the locked compositions K-1.1…K-5.4 (by column spans
  and row spans); a list over 10 items uses one per-row count of 1, 2, 3 or 6.
- **Text**: running text (paragraphs, list items outside cards) sits in columns 2–5; eyebrow and heading in 1–6.
  Running text is justified.
- **Contrast**: every text node ≥ 4.5:1 (≥ 3:1 at 24px+ or 18.66px bold) against its effective background.
- **Phone**: no horizontal overflow at 375px; every type in one column (image grids may use two).

## Lane 4 — completeness and reproducibility

- Each of the 35 old type IDs T-01…T-37 (minus the retired T-02, T-03) appears in exactly one current type in
  `tools/canon_types.py`.
- Each current type has: a definition, at least one example, at least one use (or states «כרגע לא בשימוש»), fields,
  rules; the number of pages it lists equals the union of its old types' uses in `tools/uses.json`.
- A rebuild from a clean scratch directory (`tools/fetch.py`, then `tools/build.py … map-source.html`, then
  `tools/rebuild_views.sh`) reproduces the committed HTML byte-for-byte, except the capture date/version stamps.
- Every file path mentioned in the canon, the state file, the README and the tools resolves to an existing file.

Findings `L3-n` / `L4-n`, each with the example or file, the rule, the measured value, severity; then
`VERDICT: PASS` or `VERDICT: FINDINGS (n)`.
