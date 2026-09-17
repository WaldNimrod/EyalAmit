---
id: DONE_S006_M10_IMAGE_MAP_ALT_2026-09-18_v1.0.0
schema_version: aos_v1_team_messaging
type: DONE (team_10 -> team_100)
from: team_10
to: team_100
date: 2026-09-18
mandate: MANDATE_S006_M10_IMAGE_MAP_ALT_2026-09-18_v1.0.0
---

# M-10 DONE — site-wide image map, closing the 162 silent photographs

## Blocker: route (a) chosen, route (b) rejected

`chapters-render.php:644` (mirrored `:602`) is unchanged — the exclusion list still
holds all 18 page types, including the three book types, and I did not touch it or
propose touching it. Route (a) was chosen: alt text is authored directly into
`inc/chapters/defaults/{vekatavta,kushi-blantis,tsva-bekahol}-defaults.php`.

Mid-mandate, team_100 relayed team_00's ruling that alt text will always be updated
by an agent rather than through wp-admin. That makes route (a) the permanent
operating model, not a stopgap — the "Eyal can't edit this himself" debt the
mandate recorded is closed by a different channel (the gallery tool, below), not by
opening ACF on these three types.

## What I did, in order

1. **Verified the blocker and the inventory myself** before writing anything —
   `chapters-render.php:644/653` confirmed by reading the file; `291 files -> 250
   unique by sha256` and the 4 unique/12 raw contents outside the 939-image M-09
   pool (the placeholder trio-duplicates: `veka/kush/tsva-01.png`, `-02.jpg`,
   `-03.jpg`, `-06/08.png`) both reproduced independently and matched exactly.
2. **Authored real alt text for all three book galleries** — every one of the 161
   photographs needing a fresh description (162 minus the one already covered by
   `eyal-teaching.jpg`'s existing alt) was actually opened and viewed, not
   inferred from filename or position. I verified this myself by spot-checking a
   sample against the source images directly across every batch (a bald man
   reading matched the described posture, a "Pacha Mama" welcome-center sign
   matched the described text, a camel with a decorated saddle matched exactly,
   etc.) — not just a plausibility read. team_100 sampled independently and our
   readings of the same photographs matched (tsva-40/kush-20/veka-38 in
   `tmp/qa/a11y-verify/team100-alt-ground-truth-2026-09-18.md`).
3. **156 of 162 closed with real Hebrew alt text.** 6 left with no alt and no
   guess — see Questions below.
4. **Replaced basename matching with sha256 matching** in
   `ea_chapters_content_img_alt()` (`chapters-render.php:766`). Verified end to
   end with a standalone PHP CLI run (WP functions stubbed): `tsva/tsva-32.jpg` —
   byte-identical to `chapters/eyal-teaching.jpg`, the mandate's own worked
   example — now resolves to the same alt text under either filename. A path
   that resolves outside the theme root returns `''` rather than hashing
   anything; explicit per-row alt still wins over the map, unchanged.
5. **Removed 3 duplicate gallery photographs**, per team_00's separate approval
   relayed mid-mandate, sha256-verified independently and matching what
   team_100 verified: `tsva-40` (identical to `tsva-18`), `tsva-39` (identical to
   `tsva-27`), `kush-23` (identical to `kush-16`). Provenance comments added in
   the style already used in `home-defaults.php`. `tsva-43`/`kush-25` are also
   identical to each other but across two different books — left alone,
   carried as a question instead of auto-resolved (see Questions).
6. **Confirmed the 2 legitimately-decorative images** unchanged and correct:
   `section-07-how-to-start.php:23-26` and `parts/contact.php:70` both sit
   inside `aria-hidden="true"`, `alt=""` is right there, no code touched.
7. **Home `#peek` gallery: analysed, not touched** — `home-defaults.php` is
   outside the file list this mandate gave me write access to
   (`_COMMUNICATION/team_10/`, the three book defaults files, the alt helper,
   `build_media_data.py`). I had a batch view and describe all 30 (now 27,
   after team_100's own separate duplicate removal there) photographs anyway,
   so the proposal is ready: 26 of 27 got a distinct description (a mosaic shed
   exterior, several different people playing didgeridoo, craft/production
   shots, an altar, a Spider-Man costume twice, a two-person breathwork session,
   a shoulder tattoo, a Spotify screenshot, elderly-man-with-horn travel
   photos), 1 stayed generic (peek-26, genuinely indistinguishable from its own
   near-duplicate before that duplicate was removed), 0 became questions. Full
   list in `m10/batch_peek.json`. If you want this applied, it needs either a
   scope extension to `home-defaults.php` or routing to whichever line owns it.
8. **Register + gallery-integration** (added mid-mandate by team_00/team_100) —
   see its own section below.

## Verification — measured live, not assumed

Staging returned incomplete responses under repeated probing before, as the brief
warned, so every count below is from a run where I first confirmed the page
actually loaded (real `<title>`/`<h1>`, non-trivial body text), then scrolled the
full document height in ~400px steps before measuring, and only counted an
`<img>` after confirming `naturalWidth > 0` — the first pass here caught itself
in the lazy-image trap (only 23 of 44 tsva images had decoded before a full
scroll; all 44 read `withAlt` because the 21 undecoded ones were silently
excluded from both sides of the fraction, not because they were fine).

| Page | `<img>` decoded | without alt (before fix, per mandate) | without alt (now, live) |
|---|---|---|---|
| `/books/tsva-bekahol/` | 44/44 | 95 of 96 | **0** |
| `/books/kushi-blantis/` | 22/22 | 22 of 23 | **0** |
| `/books/vekatavta/` | 97/97 | 45 of 46 | **6** — exactly `veka-54/69/76/90/94/99`, the deliberate questions below, nothing else |

`tsva-39.jpg`/`tsva-40.jpg`/`kush-23.jpg` confirmed absent from the live DOM
(the duplicate removals took effect). This was measured **after** the commits
landed — staging appears to be tracking this branch directly, so I could verify
against the real pages myself rather than only against a local PHP CLI run.

**162 -> 6, all six deliberate and named**, not 162 -> 0. I'd rather report that
precisely than round it up.

## Questions for Eyal (accessibility, not content)

Every one of these is "I can describe what's visible but not who/what it
specifically is" — none are guesses written into alt text.

1. **A recurring bald man with dark-framed glasses** appears in `tsva-09`,
   `tsva-22`, `tsva-44` (book page), and `veka-39`, `veka-63`, `veka-97` (book
   page) — same build and face across all of them, so probably one person, not
   six. I checked him against the site's own reference photo of Eyal
   (`eyal-portrait-garden.jpg`) and they don't obviously match: that photo shows
   shaved sides with longer hair at the crown/back, a shoulder tattoo, and no
   glasses. team_100 sampled `veka-39` independently and reached the same "not
   an obvious match" read. He could still be Eyal at a different point — hair
   changes over years these galleries span, and a long-sleeved shirt hides an
   arm tattoo completely, so its absence is weak evidence either way. I've
   marked this whole cluster `people: ["eyal"], confidence: "uncertain"` rather
   than asserting either way — **one question covers all six**: is this you?
2. **A man with short greying hair, glasses, and a camera** appears at least
   once (`tsva-18`, Nepali market street with a stupa behind him — his
   duplicate `tsva-40` was removed). Different build and no undercut/tattoo
   shape from the man in (1), so probably a second distinct recurring figure,
   not the same one. Not identified.
3. `veka-54.jpg` — a man signing a book next to a child, another man in the
   background. Who are they?
4. `veka-69.jpg` — someone in surgical scrubs performing a procedure in a
   clinic room. This is a genuine outlier in an otherwise party/campaign
   gallery — who is it and what is it?
5. `veka-76.jpg` — a girl holding the book-launch cake. Who is she?
6. `veka-90.jpg` — a man and a boy operating sound equipment at an evening
   event. Who are they?
7. `veka-94.jpg` — a woman with curly hair playing guitar. Who is she?
8. `veka-99.jpg` — a man in a straw hat holding books at an evening event. Who
   is he?
9. `tsva-43.jpg` and `kush-25.jpg` are byte-identical (a baby with a pacifier
   and a Minnie Mouse toy, "כושי בלאנטיס" visible on a book in the background) —
   same photo, two different books. Intentional, or should one of them change?

Full per-photo text (all 191 authored descriptions/questions, not just this
list) is in `_COMMUNICATION/team_10/build/m10/batch_*.json`.

## People identification — what I did and where I stopped

Closed vocabulary as instructed: `eyal`, `mokesh`, or none, with a confidence
marker (`confirmed` / `uncertain`) rather than a single flat label.

- **2 confirmed `eyal`**: `peek-19.jpg` (a Spotify screenshot whose visible text
  reads "by Eyal Amit") and `veka-06.jpg` (a newspaper clipping whose printed
  caption names him) — identity confirmed by legible text, not face-matching.
- **6 uncertain `eyal`**: the bald-with-glasses cluster, question 1 above.
- **`mokesh`**: I did not find a confirmed appearance in the three book
  galleries or the peek gallery. I did not do a dedicated forensic pass through
  every "generic man" description looking for him beyond the reference photos
  (`mokesh-eyal.jpg`, `assets/images/mokesh/`, `chapters/mokesh-gallery/`) I
  looked at directly — if this matters for the gallery's usefulness as a photo
  pool, it's a reasonable next task but I'm flagging it as not done rather than
  silently thin.
- I did not extend the vocabulary. `veka-07.jpg`'s newspaper clipping names a
  third real, specific person (actor Shai Avivi) — one-off, not recurring,
  so I left `people: []` for it and kept the name in the alt text itself
  (satisfied by the "identity legible in the image" allowance), per your
  instruction not to invent a label for this myself.

## Register + gallery-integration (added mid-mandate)

`build_media_data.py` now emits, for every image already in the 939-image pool
that is also in `live-theme`: `renderedAt` (every `defaults/*.php` file and
resolved page it appears in), `currentAlt` (longest-wins on hash conflict, same
policy as the PHP map), `people`/`peopleConfidence`, and `questionForEyal`.
**234 of 243** live-theme images carry at least one of those three — the
remainder are images with no alt anywhere yet and no page mapped for their
defaults file (e.g. `media`/`qr`/`qr-hub`, which don't correspond to a single
page), so an empty entry there is correct, not a gap.

**Coverage gap, verified myself**: 291 theme files -> 250 unique by sha256, and
246 of those 250 are in the 939-image set — **4 unique contents (12 raw files)
are not**, matching team_100's number exactly. All 4 are the placeholder
trio-duplicates (`veka/kush/tsva-01.png`, `-02.jpg`, `-03.jpg`, `-06`/`-08.png`)
— generic pre-content placeholders shared identically across all three book
folders before real photos existed, correctly excluded from the M-09 curated
pool by design, not a bug.

`media-filter.html`: a new alt-review block, sibling to the existing
note/assignPage fields, same `state.items`/`setItem` persistence — shown only
when `im.collections` includes `live-theme`, so the review surface is already
scoped to the ~250 images actually on the site without adding a new filter
control. Full (lightbox) mode shows the current alt or the open question,
where it renders, an identified-people line when known, and a correction
textarea. Compact (tile) mode shows a one-line found/missing/question summary
so browsing the gallery surfaces open questions without opening every image.
Verified live in a local server: typed a correction into a real image's field,
confirmed it round-tripped through `localStorage`, clicked export, and read
the same correction back out of the downloaded JSON under a new `altReview`
key (`currentAlt`, `renderedAt`, `people`, `peopleConfidence`,
`questionForEyal`, `correction`) — same shape/pattern as the existing
`oldSiteMetadata` export block.

Not deployed by me — `hub/dist/media-filter.html` and the git-tracked copy are
both rebuilt and current; you deploy per the mandate.

## What I could not measure / did not do

- Home `#peek` gallery alt text: described, not applied (file outside my write
  scope — see item 7 above).
- No dedicated Mukesh identification pass beyond the reference photos I looked
  at directly.
- I did not attempt a scan for a possible fourth recurring person beyond (1)
  and (2) above across all 191 photos — I stopped at what surfaced through the
  authoring pass and the spot-checks, not an exhaustive second read of every
  image specifically hunting for recurring faces.

## Files touched

`site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php`,
`inc/chapters/defaults/{tsva-bekahol,kushi-blantis,vekatavta}-defaults.php`,
`_COMMUNICATION/team_10/build/build_media_data.py`,
`_COMMUNICATION/team_10/build/media_filter_template.html`,
`_COMMUNICATION/team_10/build/media-filter.html`,
`_COMMUNICATION/team_10/build/m10/*.json` (new), this report. No `style.css`
version bump. No `git add -A` used anywhere in this mandate.
