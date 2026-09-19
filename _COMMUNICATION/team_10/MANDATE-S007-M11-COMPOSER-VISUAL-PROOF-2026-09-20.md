---
id: MANDATE_S007_M11_COMPOSER_VISUAL_PROOF_2026-09-20
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00, team_50]
date: 2026-09-20
theme_under_test: 1.5.83 (deployed and live)
status: DISPATCHED
---

# M-11 · Screenshots, on Composer, of everything that shipped tonight

**team_00, 2026-09-20, before going to sleep: «חובה סבב שצוות 10 מריץ קומפוזר לקחת צילומים,
לאשר שמדוייק ולהחזיר אליכם לבקרה סופית מול ההוכחות מהדפדפן ולא רק מול הדוחות».**

Run this **on Composer**, not on your own engine. He named the tool; use it.

**The deliverable is images, and a verdict per image.** Not a report that says it looks right
— the screenshots themselves, so I can do the final check against what the browser actually
painted rather than against anyone's prose. That distinction is the whole point of this round
and it is there because reports on this milestone have twice described a state the browser
did not agree with.

## What shipped tonight, and therefore what must be shown

Live is **1.5.83**. Everything below is already deployed.

1. **The reading measure changed site-wide** — prose went from 65ch flush to one edge, to
   82ch centred. **This moves every line break on every page**, so this is the item with the
   widest blast radius and the least testing. Show a text-heavy page, a short page, a page
   with many headings, and a blog post.
2. **The contents list moved into the hero** on `/snoring-sleep-apnea/`, inline-end side,
   vertically centred, light on dark.
3. **The Yoni section was rebuilt** — full-width prose, the WhatsApp screenshot floated
   inside it with text wrapping, the two quote cards as a full-width band immediately under
   «מיד אחר כך הוא כתב:».
4. **The WhatsApp float is icon-only site-wide** and must be hidden behind an open drawer.
5. **Two font families were removed** (Rubik, Suez One) — confirm nothing lost its typeface.
6. **The paste-residue cleanup ran** on six posts — confirm the text reads correctly and
   nothing was swallowed with the markup.

## Widths and pages

**1440 and 390, both, for every shot.** At minimum: `/`, `/snoring-sleep-apnea/`,
`/treatment/`, `/about/`, `/press/`, `/faq/`, `/shop/`, `/contact/`, `/services/`, `/en/`,
one blog post, and **each of the six cleaned posts** (194, 195, 190, 188, 203, 193).

## What to look for, and say per shot

- Text that now breaks badly, orphans a single word, or collides with an image — the 82ch
  change is the likely source and nobody has looked at its consequences yet.
- Anything rendering in a typeface that is not Heebo, except the pull quote.
- The float, the cards, the hero list: are they where this mandate says they are.
- Any horizontal overflow at 390.

## What NOT to do

**Do not fix anything.** If you find a defect, capture it and report it. I want the whole
picture before anything moves again, because the next change is mobile and I do not want to
be chasing a regression into it.

**Do not deploy.** Live stays at 1.5.83 for this round.

## Reporting

Screenshots on disk with a path list, and a per-page verdict. Send me the paths — I will look
at the images myself. If you found nothing wrong, say so plainly, but say it about images you
actually opened.
