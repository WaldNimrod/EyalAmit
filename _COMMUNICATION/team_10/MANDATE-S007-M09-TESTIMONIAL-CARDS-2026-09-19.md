---
id: MANDATE_S007_M09_TESTIMONIAL_CARDS_2026-09-19
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00, team_50]
date: 2026-09-19
theme_at_dispatch: 1.5.71
status: DISPATCHED
---

# M-09 · The two testimonials on the snoring page, as cards beside the story

**team_00, 2026-09-18: «קרוסלה - אם יש רק 2 - עדיף כרטיסים».**
**team_00, 2026-09-19, answering where they go: «עדויות - ליד הסיפור».**

So: **not a carousel, and not lifted out of the narrative.** The two quotes stay with the
Yoni story on `/snoring-sleep-apnea/` and are presented **alongside** it as cards.

## Content law, and it is absolute here

The quotes are **Eyal's**, already in
`inc/chapters/defaults/snoring-sleep-apnea-defaults.php`. **Relocate them into the card
markup character for character.** Do not rewrite, do not shorten, do not add an attribution,
a heading, a rating, a date or a label that is not already in the file. If a card design has a
slot with nothing to put in it, the slot does not ship — **an empty card is forbidden on this
site.**

Removing the quotes from the prose body leaves that prose still reading correctly. Check that
it does; if pulling them breaks the sentence around them, stop and report rather than
smoothing it over with words of your own.

## Design

Two cards, side by side at desktop, stacked at mobile, sitting **next to** the Yoni section —
the same relationship the TOC has to the lead paragraph, which is already built and live as
`.ea-toc .lede` with the `pairs_with_toc` marker on the preceding prose. Reuse that pattern
rather than inventing a second pairing mechanism.

**Every size and weight from the locked scale** (canon §1) — twelve rungs, eight weights, no
new value. **Set `font-family` explicitly on any `<button>`** you render; that omission has
produced four separate defects here this week.

## Verification

At 1440 and 390: both quotes present and byte-identical to the source file, the surrounding
prose still coherent, every computed size and weight on a rung, one `h1` on the page and no
skipped heading level, and no horizontal overflow at 390.

## Limits

No `git add -A`. Do not touch `_aos/`. Bump `style.css` `Version:`. Report to team_100
(`eyalamit-co-il-2026-76`). Validation is team_50's, on a different engine.
