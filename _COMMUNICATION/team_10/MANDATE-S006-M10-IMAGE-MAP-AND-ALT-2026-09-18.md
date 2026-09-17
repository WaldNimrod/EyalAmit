---
id: MANDATE_S006_M10_IMAGE_MAP_ALT_2026-09-18_v1.0.0
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00]
date: 2026-09-18
law: S006-MILESTONE-CHARTER.md
plan: owner-approved accessibility work plan, WS-3
disposition: BUILD — team_10 builds, team_100 validates, a different line verifies
---

# M-10 · Site-wide image map, and closing the 162 silent photographs

**Scope is accessibility only.** Do not touch page copy. Do not rewrite a word Eyal
wrote. Alt text is an attribute required by WCAG 2.0 SC 1.1.1; it is never rendered
to a sighted reader and it is not page content.

Read first: `_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/00-BRIEF-SHARED-FIX.md` —
the five verifier-contract clauses apply to you, including the new fifth one:
**a clean automated scan is not a PASS.**

---

## The problem, measured

Three book gallery pages render 162 content photographs with `alt=""`. To a screen
reader those three gallery sections are empty. Measured twice, independently:

- `/books/vekatavta/` — 95 of 96 images
- `/books/kushi-blantis/` — 22 of 23
- `/books/tsva-bekahol/` — 45 of 46

(The one image per page that does carry alt is the book cover.)

**axe-core reports zero violations on all three pages.** `alt=""` is the valid way to
mark an image decorative, so the rule passes by design. Do not use a scanner to judge
your own work here — it cannot see this defect.

---

## The blocker you must solve first — this is why the job is not "just write alt text"

`site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php:644`
(mirrored at `:602`) short-circuits the ACF/DB merge for 18 page types, including all
three book types, with `continue;` at `:653`. The comment explains why: it exists to
stop ACF slots from a previous section order overwriting seeded content.

**Consequence: there is no wp-admin path today that can set alt on those 162 images.**
The render always uses the raw PHP array. So this cannot be handed to content editing.

Two routes. Choose one, justify it, and say what you rejected:

- **(a) Author in the defaults files.** Add `alt` keys to the three
  `inc/chapters/defaults/{vekatavta,kushi-blantis,tsva-bekahol}-defaults.php`. Simple,
  no engineering risk, but the text stays developer-owned.
- **(b) Remove the three book types from the exclusion list** and register real ACF
  fields. Gives Eyal an editing path forever. **Higher risk: you are touching a guard
  that exists to prevent slot-order corruption.** If you go this way it needs its own
  regression check proving no other page's content shifted.

⚠ **Do not take route (b) silently.** If you believe it is right, say so in your report
and stop — team_100 takes that decision, not the line.

The gallery item schema already supports this: `parts/gallery.php:5` documents
`items[ { image, alt, cap, pending, pending_label } ]`, and `galleries-defaults.php:40-45`
already uses real `alt` values. The three book files pass only `array('image' => ...)`.

---

## Measured inventory — these are given, do not re-derive

- **291 image files** under `assets/images/`, which collapse to **250 unique by sha256**.
  41 files are byte-identical duplicates of another file already on disk.
- **A worked example of why this matters:** `chapters/eyal-teaching.jpg` carries a good
  alt, and it is byte-identical to `chapters/tsva/tsva-32.jpg`, which renders `alt=""`.
  Same photograph, two filenames, one description. This is the argument for matching
  on content hash rather than on filename.
- The current helper `ea_chapters_content_img_alt()` (`chapters-render.php:753-783`)
  holds **20 hardcoded entries for one flat folder** and returns `''` on a miss. It is
  structurally incapable of covering 270 of the 291 files.
- Live across 14 pages: **229 `<img>`, 65 with real alt, 164 with `alt=""`, none missing
  the attribute.** 162 of the 164 are the three book pages. Exactly **2** of the 164 are
  legitimately decorative — they sit inside `aria-hidden="true"`:
  `section-07-how-to-start.php:23-26` and `parts/contact.php:70`.
- 256 referenced image paths, **zero broken**. Roughly 24–28 images on disk are
  referenced by nothing.

**If you measure a different number, stop and report it. Do not correct toward mine.**

---

## Reusable prior work — do not rebuild it

`_COMMUNICATION/team_10/build/media-filter.html` and `build_media_data.py` already hold
**939 canonical images** with sha256 ids, pool membership, every path per hash, and a
legacy-WP metadata join. **The hash join to the live theme is verified, not assumed:**
246 of the 250 unique live-theme contents are present in that 939-image set.

But **only 41 of the 939 carry usable legacy alt text**. That work gives you identity
and provenance. It does not give you copy.

---

## The work

1. **Register.** Extend `build_media_data.py` to emit a site-image register keyed by
   sha256: every on-disk image, all its paths, where it is actually rendered (page and
   template part), its current alt, and whether it is content or decorative. Reuse the
   existing hashing and pool logic.
2. **Resolve the blocker** per the section above.
3. **Author the alt text.** ~162 Hebrew descriptions.
   **The one constraint: do not invent what a photograph shows.** Where the subject is
   not self-evident from the image — which book, whose hands, which instrument, which
   event — collect it into a list of questions for Eyal rather than guessing. That list
   comes back to team_100 and goes to him as an **accessibility** question.
   Describe what is visible. Do not narrate, interpret, or market.
4. **Replace basename matching with hash matching** in the alt helper, so a photograph
   carries its description under every filename it appears under.
5. **Sweep the remainder.** Confirm the two genuinely decorative images stay `alt=""`
   with `aria-hidden`. The home `#peek` gallery has 30 images sharing one identical alt
   string («הצצה לחוויה בסטודיו») — vary it where the photographs actually differ,
   and say so where they do not.

---

## Constraints

- **Do not deploy.** team_100 deploys. FTP is IP-allowlisted.
- Do not bump `style.css` Version — team_100 bumps once per wave.
- Never `git add -A` / `git add .` (charter §5.4).
- Every claim about code cites `file:line` (charter §3א-2).
- Write only inside `_COMMUNICATION/team_10/`, the three defaults files, the alt helper,
  and `build_media_data.py`.

## Verification you must run, and report

Per-page counts of `<img>` with non-empty alt on a page set that **includes the three
book pages**. Target: 162 → 0 content images without alt.
**Assert every image decoded (`naturalWidth > 0`) before judging it** — lazy images
report 0 and `NaN` comparisons pass silently. That trap has produced a false clean here.
Staging returns incomplete responses under repeated probing: assert the page actually
loaded before you judge it.

## Report

`_COMMUNICATION/team_10/DONE-S006-M10-IMAGE-MAP-AND-ALT-2026-09-18.md` — what you did,
the route you chose for the blocker and what you rejected, before/after counts, the list
of questions for Eyal, and anything you could not measure.
