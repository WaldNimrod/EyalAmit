# Mandate — one unified footer, from one source — 2026-09-26

**Dictated by team_00 (Nimrod) on 2026-09-26, after seeing the footer live.** His words:

> «השורה השניה זה כפילות וזה לא טוב. צריך לחשוב שוב על עיצוב הפוטר כך שיכנס רק פעם אחת אחיד
> בעיצוב יפה. עיצוב לפי מה שיש למעלה ״מה מציעים״ אבל תוכן - לפי התפריט המלא כולל ספרים כעמודה
> משלה. הערות משפטיות הכי בסוף, ממורכז ורק הוא בגוון הבהיר, כל השאר בשחור, להעמיד יפה פרטי קשר
> בבלוק וכל התפריט בבלוק.»

**This supersedes `MANDATE-FOOTER-SITEMAP-ROW-2026-09-26.md`.** That mandate produced a correct
sitemap row — measured and verified — but it sits *below* the older link columns and duplicates
nine of their ten links. **The duplication is the defect. One footer, once.**

- **Repo:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` — branch `main`
- **Live staging:** `http://eyalamit-co-il-2026.s887.upress.link` — plain HTTP on purpose; the
  certificate is invalid **by design** and is never a defect
- **Live theme:** read `Version:` in `site/wp-content/themes/ea-eyalamit/style.css` before bumping
- **Language:** code and your report in English

---

## What the footer must become

**One block. Rendered once per page. No second row anywhere.**

**1 · The menu, as columns.** Visual design follows the existing «מה מציעים» / «עוד» columns —
that is the look he approved. **Content follows the full canonical tree**, not the current
hardcoded shortlist.

**2 · «ספרים» gets a column of its own.** In `ea_canonical_nav_items()` it is a child of
«כלים ואביזרים» with five children beneath it. **Promote it to a top-level column in the FOOTER
RENDERER ONLY. Do not change the tree** — the tree drives the main menu and the mobile drawer, and
team_00 did not ask for those to change. **If you find yourself editing the array, you have
misread this.**

**3 · Contact details in their own block, well placed.** The existing brand block — the centre
name, the location line, the address, the phone and the social icons — stays, arranged cleanly.

**4 · The legal strip is LAST, CENTRED, and is the ONLY part in the light tone.** Everything else
in the footer is on the dark/black ground. The legal strip carries the medical disclaimer, the
copyright line, and the accessibility and privacy links that are already there.

## The rule that decides whether this succeeds

**Render from `ea_canonical_nav_items()`. Do not write a copy of the tree.**

This theme has had **six** parallel copies of its navigation and every one of them drifted. The
current footer columns are one of them: measured 2026-09-26, they differ from the tree in five
places — «טיפול בדיג׳רידו» vs «טיפול נשימה באמצעות דיג׳רידו», «שיעורי דיג׳רידו» vs
«שיעורי דיג׳רידו פרטיים», «השיטה cbDIDG» vs «השיטה», «לימוד והכשרה» pointing at a different URL
than the tree's «שיעורים והכשרות», and «ספרים – מוזה הוצאה לאור» as one row where the tree has two.

**Those five differences disappear when the footer reads the tree. That is the point.**

## Constraints that override your judgement

**1 — Content law.** Every label and every URL comes from the tree, or is text already live in the
footer (the disclaimer, the copyright, the centre name, the address, the phone). **You may not
write new copy** — not a column heading, not a tagline, not a link label. **The column headings are
the tree's own top-level labels.** If a column needs a heading the tree does not supply, stop and
report it.

**2 — Honour `'hidden' => true`.** «קורסים דיגיטליים» stays out, as in every other renderer.
**And honour `'label_emph'`** — «מוקש דהימן -» carries its emphasis in a separate field.

**3 — Tokens are LOCKED.** `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md` is the only authority
on sizing. **No new `font-size` in a component rule, no new token.** Use the existing `--fs-*`
rungs and the existing colour tokens.

**4 — Remove the row you shipped this morning, completely.** It is wired from four render paths
plus a `wp_footer` safety net. **Unwire all of them.** A leftover call means the duplication
survives, which is the whole defect.

**5 — Four footer render paths exist**, and the previous round found them the hard way:
Chapters' `section-footer.php` (about 150 pages), Wave2's `block-footer-social.php` (`/press/`),
`tpl-chapters-en.php` (`/en/`), and the bare GeneratePress parent footer reached by
`/historical-articles/`. **The unified footer must reach all of them, once each.**

## Three open items this round closes, and you should close them deliberately

- **`/press/` currently paints SEVEN `<footer>` elements** where every other page paints one —
  `tpl-content.php` calls both the Wave2 footer and `get_footer()`. **One footer per page.**
- **Fourteen of the sixteen links in the Wave2 footer lack a trailing slash and return 301.**
  Reading from the tree fixes this by construction — **the tree's own hrefs carry the slash.**
  Verify it rather than assuming it.
- The drifted labels above.

## A layout judgement you must make, and report

The tree has six top-level items; **promoting «ספרים» makes seven columns**, and two of them
(«השיטה», «בלוג דיג׳רידו») have no children at all, so they are single-link columns. **Seven
columns, two of them one line long, may look wrong.** Decide how to lay it out so it reads well at
desktop and at phone width — **and state in your report what you chose and why.** You may group or
wrap columns; you may not invent a heading to pad a column, and you may not drop an item.

## Practical constraints

- **Never open or commit anything under `local/`.** **`_aos/` is a read-only snapshot.**
- **Never `git add -A` or `git add .`** — explicit paths only.
- **Deploy:** `python3 scripts/ftp_deploy_site_wp_content.py` ships the working tree and **refuses a
  dirty `site/`. Never force past that refusal** — stop and report.
- Leave `scripts/save_legacy_wp_app_password.py` alone. **Do not open it.**
- **⚠ Do NOT run `scripts/s007_render_work_ssot.py`.**
- **Bump the theme version** in `style.css` — read it first, it is a shared counter.

## Success criteria — Team 90 measures these, and they were written before you started

- **Exactly one footer element per page, on all 136 live pages**, including `/press/`. Every page
  200, **exactly one primary nav**, zero PHP error strings.
- **Exactly one rendering of the menu in the footer.** Zero duplicated links between one footer
  region and another.
- **The item set in the footer menu equals the visible item set of `ea_canonical_nav_items()`
  exactly**, compared in both directions, `html.unescape`d first. **Never conclude from a count.**
- **«ספרים» renders as its own column**, with its five children under it.
- **`courses-external` appears zero times.**
- **Every footer link returns 200 with redirects NOT followed** — zero 301s, including on `/press/`.
- **The legal strip is last, centred, and the only light-toned region** — verified in a rendered
  browser, not in markup.
- **Contrast stated as a number** for every text level in the footer, measured against the painted
  background, against the correct threshold for its size and weight.
- **Zero horizontal overflow at 390px** on all four render paths.
- **`ea-tokens.css` and the canon are untouched** — Team 90 diffs them.

## Report

`_COMMUNICATION/team_10/DONE-FOOTER-UNIFY-2026-09-26.md`. Per criterion: **the live URL, the status
code, and the measurement that proves it** — not a description of what you changed. Include both
`git status` readings, the theme version deployed, and your layout decision with its reasoning.

**If any instruction here turns out to be wrong, say so and do not implement it.** Refusals with a
measurement behind them have repeatedly saved this project, including one that caught Team 90's own
error twice today.
