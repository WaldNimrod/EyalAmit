# Mandate — a second footer row: the whole nav tree as a link list — 2026-09-26

**Dictated by team_00 (Nimrod) on 2026-09-26.** His words:

> «בפוטר — אני רוצה להוסיף שורה שניה. בה יופיע כל עץ התפריט פרוס כרשימת לינקים. קצת מיושן
> אבל לפחות להתחלה זה חשוב. מעוצב יפה עם שלוש הרמות ברור, כל תפריט בעמודה. לבן דק ועדין.»

- **Repo:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` — branch `main`
- **Live staging:** `http://eyalamit-co-il-2026.s887.upress.link` — plain HTTP on purpose; the
  certificate is invalid **by design** and is never a defect
- **Live theme:** read `Version:` in `site/wp-content/themes/ea-eyalamit/style.css` before bumping
- **Language:** code and your report in English

---

## The one rule that decides whether this task succeeds

**You must render from `ea_canonical_nav_items()` in `inc/ea-canonical-nav.php`. Do not write a
copy of the tree.**

This theme's single most repeated defect is parallel implementations of one component. The nav
tree has already existed in **six** places. **The footer is one of them**, and it has already
drifted: `block-footer-social.php` hardcodes its own «ניווט» column with labels that no longer
match the canonical tree — «טיפול בדיג׳רידו» vs «טיפול נשימה באמצעות דיג׳רידו», «לימוד והכשרה»
vs «שיעורים והכשרות», «ספרים – מוזה הוצאה לאור» vs «ספרים».

**A seventh copy will drift by next week. Read the function.**

## What to build

**A second row inside the existing footer, below the current one.** The current row stays exactly
as it is — brand, ניווט, מידע ותקנון, עקבו, copyright. **You are adding, not restructuring.**

**The new row is the full tree, three levels, one column per top-level item:**

- Level 1 — the top-level item, as the column heading. It is a link when it has an `href`.
- Level 2 — its children, listed under it.
- Level 3 — a child's own children, indented under their parent. **The tree really is three deep**
  («ספרים» sits under «כלים ואביזרים» and carries five children of its own), and
  `ea_canonical_nav_items()` is recursive. **Recurse; do not assume two levels.**

**Styling, in his words: «לבן דק ועדין» — white, thin, delicate.** Columns, clear level
distinction, comfortable at phone width. Old-fashioned in the good sense: a plain sitemap row.

## Constraints that override your judgement

**1 — Content law.** Every label and every URL comes from the tree. **You may not write new copy**,
not a heading, not a column title, not a description. If you think a label reads badly, report it.

**2 — Honour `'hidden' => true`.** `courses-external` («קורסים דיגיטליים») is hidden by Eyal's
instruction and **must not appear in the new row.** Both existing renderers skip it; yours must too.

**3 — Honour `'label_emph'`.** «מוקש דהימן -» carries its emphasis in a separate field, never as
HTML inside the label. Render it the way the existing renderers do.

**4 — The type and colour canons are LOCKED.** `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md`
is the only authority on sizing. **Do not add a `font-size` to a component rule and do not add a
new token.** Use the existing `--fs-*` rungs. Same for colour: no new colour token.

**5 — It must render on every page.** This theme has more than one footer path — the child
`footer.php` defers to the GeneratePress parent, and several page templates call
`get_template_part( 'template-parts/blocks/block', 'footer-social' )` directly. **Find every path
before you choose where to inject.** A footer that appears on the pages you happened to open is
not a footer. **Six pages in this site render outside every template whitelist and were missed
that way once already.**

**6 — Accessibility.** The new row is navigation: give it a `<nav>` landmark with its own
`aria-label` distinct from the existing one. **Measure the contrast of the new text against the
footer's actual painted background** and state the ratio. «דק ועדין» must not mean unreadable —
thin white text on a dark footer still has to clear its threshold (4.5:1 under 24px regular).

## Practical constraints

- **Never open or commit anything under `local/`.** **`_aos/` is a read-only snapshot.**
- **Never `git add -A` or `git add .`** — explicit paths only.
- **Deploy:** `python3 scripts/ftp_deploy_site_wp_content.py` ships the working tree and **refuses a
  dirty `site/`. Never force past that refusal** — stop and report.
- Leave the untracked `scripts/save_legacy_wp_app_password.py` alone. **Do not open it.**
- **⚠ Do NOT run `scripts/s007_render_work_ssot.py`.** It is stale and would overwrite Eyal's live
  form and Nimrod's board.
- **Bump the theme version** in `style.css` — it is a shared counter; read it first, then bump.

## Two things to REPORT and NOT fix

These are real and already measured. **They are separate board items and are out of your scope.**

1. **The existing footer's «ניווט» column is a hardcoded, drifted copy of the tree** (labels above).
   Do not rewrite it in this task — replacing it is its own decision, because it is a visible
   change to a shipped component.
2. **Fourteen of the existing footer's sixteen links are written without a trailing slash and
   therefore return 301**, e.g. `/treatment` → `/treatment/`. Measured 2026-09-26. Your new row
   must **not** repeat this — the tree's own hrefs already carry the slash, so simply using them
   avoids it. **Do not "fix" the old row while you are there.**

## Success criteria — Team 90 measures these, and they were written before you started

- **The new row renders on all 153 published objects** — every one 200, **exactly one primary nav
  per page**, zero PHP error strings. **A template change took this whole site down once already.**
- **Every link in the new row returns 200 with redirects NOT followed** — zero 301s.
- **The item set in the new row equals the visible item set of `ea_canonical_nav_items()` exactly**,
  compared in both directions, `html.unescape`d before comparing. **Never conclude from a count.**
- **`courses-external` appears zero times** in the new row.
- **Three levels are present and visually distinguishable**, verified in a rendered browser, not in
  markup — read the boxes only after layout settles.
- **No new font-size declaration and no new token**; the canon file is untouched.
- **The contrast ratio of the new text is stated as a number**, measured against the painted
  background.
- **Readable at 390px width with zero horizontal overflow.**

## Report

`_COMMUNICATION/team_10/DONE-FOOTER-SITEMAP-ROW-2026-09-26.md`. Per criterion: **the live URL, the
status code, and the measurement that proves it** — not a description of what you changed. Include
`git status` before and after, and the theme version you deployed.

**If any instruction here turns out to be wrong, say so and do not implement it.** Refusals with a
measurement behind them have saved this project repeatedly, including one that caught Team 90's
own error.
