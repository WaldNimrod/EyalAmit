---
id: MANDATE_S007_M10_DEAD_FONTS_AND_PASTE_2026-09-20
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00, team_50]
date: 2026-09-20
evidence: _COMMUNICATION/team_50/XVAL-S007-M06-M09-GATE-2026-09-19.md
theme_at_dispatch: 1.5.77
status: DISPATCHED
---

# M-10 · Stop downloading two fonts nobody uses, and clear the paste residue

**team_00, 2026-09-20: «הסיבוב הבא זה לשלוח את צוות 10 לבצע את זה עכשיו.»**
Both items come from the cross-engine gate, both are measured, neither needs a design decision.

## Part 1 — two font families load on every page with zero consumers

The gate measured, across all 157 URLs: **zero elements compute Rubik and zero compute Suez
One.** The files are still requested anyway.

- **Rubik** — `id='ea-eyalamit-fonts-rubik-css'`, enqueued from `functions.php`, on **157 of
  157** pages.
- **Suez One** — bundled into the `ea-chapters-fonts` Google Fonts request from
  `inc/chapters/chapters-enqueue.php` (`family=Heebo+…+Frank+Ruhl+Libre+Suez+One`), on **149 of
  157** pages.

**Remove both requests.** This is dead weight on every page load on a site whose visitors are
largely on phones.

### The one thing you must not break

**Frank Ruhl Libre stays.** It is in the same bundled request as Suez One, and it is the font
of `.bleed__q` — the pull quote, team_00's single named exception to the Heebo collapse. Take
`Suez+One` out of that URL and leave `Frank+Ruhl+Libre` in it. **If the quote stops rendering
in Frank Ruhl Libre, you have broken the one thing he asked to keep.**

### The Rubik dependency, which is why this is not a one-line delete

`theme-shell-fallback.css` still contains a literal `font-family: "Rubik"`, and the Rubik
enqueue is a dependency of it. The gate confirmed that sheet is **not enqueued** while
GeneratePress is present — dead on staging today, but it would fire if the parent theme ever
went missing. So do not leave a sheet asking for a font that is no longer fetched: **point that
rule at the site font as part of this change**, then remove the enqueue. Trace the dependency
chain before deleting anything — a `wp_enqueue_style` with a `$deps` array that names a handle
you removed will silently drop the dependent sheet.

## Part 2 — Word and Facebook paste residue in five old posts

Ten elements compute `Arial`/`arial` inside pasted markup in the database. **No stylesheet
touches this and no token ever will.**

The five posts, **corrected against the gate** — our own earlier list was wrong:

- «(40) הטור של אייל עמית: פרסומת אחת וחזרנו»
- «(41) הטור של אייל עמית: חארטה בארטה»
- «(29) הטור של אייל עמית: רייב שבוע הספר»
- «(24) הטור של אייל עמית: ילד אסור ילד מותר»
- the 2012 studio post, «דיג'רידו פרדס חנה — סטודיו לבנייה ונגינה…»

**«(27) חכמת הפרצוף» has zero Arial and is NOT one of them** — it appears in
`_COMMUNICATION/team_10/S007-M05/deviations.csv`'s prose summary in error. Do not touch it.

Also present but not rendering: post «(36) שיטת השקשוקה» carries 3 inline Arial tags with no
direct text. Clean it too while you are in there — it is the same residue and it will surface
the moment that markup gains text.

### Content law, and it is absolute

**Strip the font styling. Do not touch a single character of text.** These are Eyal's published
columns. Remove `font-family` declarations, `class="MsoNormal"` and the empty nested `<span>`
wrappers Word leaves behind — and change **no word, no punctuation, no line break, no link**.
If removing a wrapper would change how a paragraph reads or where it breaks, stop and report
rather than deciding.

Single-glyph elements count: one of these is a lone `|` and another a lone `.`. A sweep that
filters for text longer than one character will miss them, which is how they survived nine
earlier sweeps.

### How to reach the database

Staging has **no WP-CLI**. Use the established one-shot mu-plugin pattern —
`site/wp-content/mu-plugins/*-once.php`, flag-guarded with an option, idempotent, reporting its
result into an option rather than dying silently. `ea-a11y-statement-modified-once.php` is a
current, small example. **Take a record of each post's `post_content` before you write**, in an
option or a file, so this is reversible without a database restore.

## Verification

Re-run the family scan across the 157 URLs: **zero Arial, zero Rubik, zero Suez One, and
`.bleed__q` still Frank Ruhl Libre.** Confirm from the live HTML that the Rubik request and the
`Suez+One` fragment are gone, and that the Frank Ruhl Libre request is still there. Confirm the
posts' visible text is unchanged — diff the rendered text of each post before and after, not
just the markup.

## Limits

No `git add -A`. Do not touch `_aos/`. Bump `style.css` `Version:`. The deploy script ships the
working tree and refuses a dirty `site/` — and another session shares this worktree, so do not
leave it dirty. Report to team_100 (`eyalamit-co-il-2026-76`) with the theme version you end on.
Validation is team_50's, on a different engine.
