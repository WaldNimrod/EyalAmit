# MANDATE — Team 90 — meeting embarrassment audit — 2026-09-24

**Validator:** Claude Opus, a new read-only session. **Builder of the claims under test:** Cursor Grok (Team 110). The builder does not audit itself. An empty reply is FAIL. Do not edit the site, the board, the form, or this mandate. The only file you may write is the verdict.

First line of the verdict: `VERDICT: PASS` or `VERDICT: FAIL`  
Write the verdict to: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-MEETING-EMBARRASSMENT-2026-09-24.md`

You are Team 90 (control). You are not Team 50. You do not sign accessibility, you do not measure Lighthouse on staging, and you do not implement a fix. This pass is only: will Eyal or Nimrod be shown, in the meeting, something that contradicts what Eyal already wrote or what the live staging site actually shows?

Staging TLS errors are expected. `curl -k` against `http://eyalamit-co-il-2026.s887.upress.link` is allowed. A certificate warning is not a finding.

## The bar

A clean feeling is not a result. You have two duties, and skipping either one is FAIL.

**Find.** Treat every "done" sentence from Team 110 as unproven. Produce a candidate embarrassment for every probe below. A verdict with no candidate table is FAIL, even if you believe the site is clean.

**Refute.** Attack every candidate before it counts. A candidate survives only if the refutation fails. Then it is CONFIRMED. If the refutation succeeds, it is REFUTED and it is not an embarrassment.

- CONFIRMED requires both quotes: Eyal's source text, and the live text, plus the URL you fetched. A CONFIRMED row also states the refutation you attempted and why it failed.
- REFUTED requires the live quote that killed it. "Looks fine" is not a refutation.
- HTML entities that decode to the same characters (`&#039;` for `'`, `&#8211;` for an en dash) are the same text. That difference is REFUTED.
- The alt that counts is the `alt` on the `img` whose `src` contains that filename. A neighboring image does not count.
- Team 110's reports, the board, and this mandate are claims. The live response is the evidence.

`VERDICT: FAIL` if any row is CONFIRMED, or if any mandatory probe has no row.  
`VERDICT: PASS` only when every mandatory probe has a REFUTED row backed by a live quote.

## What an embarrassment is

One of these, and only these:

1. Eyal wrote who or what is in the picture, and the live `alt` for that file is different text.
2. A placement instruction he wrote is the live `alt`.
3. The form asks a question he already answered, or shows an item that is not waiting on him.
4. Something waiting on Eyal or on Nimrod is missing from his form or from Nimrod's board.
5. The chooser gallery says integrated, or "needed, no page", and the live theme does not agree.
6. A surface says done, and the live page does not show it.

Anything else is out of scope. Do not add it as a finding.

## Sources (his words)

- Image notes, status, assigned page, 2026-09-21 13:51Z: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--whatsapp-after-1158/ea-media-filter-2026-09-21T13-51-27-450Z.json`
- Excel answers, same day: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--whatsapp-after-1158/eyal-s006-excel-answers-2026-09-21T11-06-38Z.json`
- Form answers: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-21--content-gaps--from-eyal/`
- Work queue the board and the form are rendered from: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json`

The join note from earlier the same day is a claim that was later superseded. Do not treat it as the live state: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/R3-ALT-JOIN-2026-09-24.md`

## Surfaces (what the meeting will open)

- Nimrod's board: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html`
- Eyal's form: `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html`
- Chooser gallery: `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/media-filter.html`
- Unassigned cut, 179: `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/media-filter-unassigned-need.html`
- Staging origin: `http://eyalamit-co-il-2026.s887.upress.link`

## Mandatory probes

Each probe is one or more rows. Filename match is on the `img` `src`.

### P1 — identity sentences on the live page

For each row, fetch the page, find the `img` whose `src` contains the filename, decode the `alt`, and compare it to the note. A shorter or older sentence is CONFIRMED.

| File | Page | Note in the 21.9 export (verbatim) |
|---|---|---|
| `mokesh-13.jpg` | `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/` | זו ג'מה הספרדייה, תלמידה ותיקה של מוקש |
| `mokesh-14.jpg` | same | אניטה אשתו של מוקש |
| `mokesh-15.jpg` | same | הבנים של מוקש ואני |
| `mokesh-11.jpg` | same | תמונה של מוקש עם ענת אשתי והילדים מ 2018 |
| `mokesh-03.jpg` | same | אני , גיא אח שלי ומוקש |
| `mokesh-10.jpg` | same | מוקש משקיף על הגנגס סמוך לקוטלי |
| `mokesh-08.jpg` | same | זה השלד של הסטודיו החדש בקוטלי. ככה עמד 6 שנים עד שאני הגעתי |
| `mokesh-09.jpg` | same | הביקתה בקוטלי |
| `mokesh-04.jpg` | same | בחצר אצל מוקש |
| `peek-21.jpeg` | `http://eyalamit-co-il-2026.s887.upress.link/` | אני ומוקש |
| `peek-29.jpg` | same | זה הדיג' שנגנב. צילום אחרון שלו בבית המלאכה אצל מוקש 2003. אחרי האירוע כל מסלול חיי הוסת והתחלתי לעסוק בדיג'רידו |
| `tsva-13.jpg` | `http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/` | שנת 2003 - מוקש אוחז בספר הראשון שלי שראה אור ב 2001 |
| `stand-01.jpg` | `http://eyalamit-co-il-2026.s887.upress.link/stands-storage/` | סטנד רצפתי |
| `stand-02.jpg` | same | זה סטנד רצפתי |
| `stand-03.jpg` | same | סטנד רצפתי |
| `stand-04.jpg` | same | סטנד רצפתי |
| `stand-05.jpg` | same | סטנד לתלייה על הקיר |

`mokesh-03.jpg` keeps the space before the comma. `tsva-13.jpg` keeps the hyphen-minus, not an en dash. The home card that uses `stand-01.jpg` with the shop title is a different `img`. Judge the stands-page `img` only.

Gallery files still labeled only «מוקש דהימן» (`mokesh-01`, `02`, `05`, `06`, `07`, `12`, `16`, `17`, `18`) have no identity note. Inventing a sentence for them would be CONFIRMED. Leaving «מוקש דהימן» is REFUTED.

### P2 — placement notes are not captions

Pick five export notes that only say where to put the file (gallery at the bottom, put in the hero, add to the archive, article assignment). For each, show the live `alt` of that file and show that the note is not the `alt`. If the note is the `alt`, CONFIRMED. The child-with-phone image on the contact page has no note and must stay an empty `alt`. A filled alt there is CONFIRMED.

Contact page: `http://eyalamit-co-il-2026.s887.upress.link/contact/`

### P3 — the form shows only what is waiting on Eyal

Fetch the form. Confirm all of the following, each as its own row:

- There is no table whose header is the closed-items list.
- There is no table of items waiting on Nimrod. One sentence that says those items are not on this form is allowed.
- These 16 items are present, and no other item is present: `A3`, `A5`, `B2`, `B3`, `C1`, `C3`, `P037`, `Q-HERO-ASK`, `M1`, `M2`, `M3`, `M5`, `M6`, `M7`, `M8`, `M9`.
- `A3` says the historical archive is live and the placeholder line is gone, and that the remaining wait is the catalog he promised. It does not say the placeholder is still in the body.
- Historical page itself: `http://eyalamit-co-il-2026.s887.upress.link/historical-articles/` does not contain `אופציונלי`.
- Already decided, so they must not be open questions on the form: burger menu; press out of the menu; shows out of the menu; historical articles out of the menu; courses stay «יעלה בקרוב» until he sends links (`A5` waiting for links is still legitimate).

### P4 — the board shows every wait, his and Nimrod's

On the board file, confirm:

- `T-NAV-HOLD` is present and waiting on Nimrod.
- `T-GALLERY-ASSIGNED` and `T-BLOG-HERO-OLD` are present and waiting on Eyal. They are board items. Their absence from the form is REFUTED, because `M6` and `P037` already carry those waits on the form.
- The optimization section does not say the identity notes are still waiting for a decision. It says those sentences are on staging, and that placement notes were not written onto the images.
- `A5` is present.

### P5 — the chooser gallery matches the theme

Fetch `media-filter.html`. Confirm:

- All nine repair files are in the `live-theme` collection and `renderedAt` includes `/repair/`: `EA-000161.jpg`, `EA-000214.jpeg`, `EA-000220.jpeg`, `EA-000237.jpeg`, `EA-000238.jpeg`, `EA-000239.jpeg`, `EA-000242.jpeg`, `EA-000268.jpeg`, `EA-000298.jpg`. One of those image URLs returns HTTP 200.
- `mokesh-13.jpg` `currentAlt` in that file is the Gemma sentence.
- `EYAL_LOOSE_NEED` has 179 ids. That set is exactly: export `status` = `need` and `assignedPage` empty. Do not remove an id only because the photo was already on some page on 21.9.
- The unassigned page's title count is 179.

Live repair page, for one file, as the refutation sample: `http://eyalamit-co-il-2026.s887.upress.link/repair/`

## Verdict shape

```
VERDICT: PASS|FAIL

## Probe table
| Probe | Candidate (one line) | Refutation attempted | Result CONFIRMED or REFUTED | Live URL | Live quote | His quote |

## Confirmed only
One line each: what he will see, what he wrote, the URL, and the smallest correction. Do not apply it.

## Hunt gaps
Probes you could not fetch. Each one is FAIL.
```

No improvement ideas. No accessibility sign-off. No edits outside the verdict file.
