---
id: MANDATE_S006_M11_DUP_IMAGES_2026-09-18_v1.0.0
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → second build line)
from: team_100
to: team_10 (second line)
cc: [team_00]
date: 2026-09-18
law: S006-MILESTONE-CHARTER.md
disposition: INVESTIGATE — read-only. Report only. Fix nothing.
---

# M-11 · Find the same photograph shown twice as content

**team_00 (Nimrod) believes there are a few and wants them located.** He is right to
suspect it: on disk, 291 image files collapse to **250 unique by sha256** — 41 files
are byte-identical copies of another file. But files on disk are not the question.
**The question is what a visitor actually sees twice.**

## This mandate is READ-ONLY

Another line is working in this same worktree on M-10 right now, and this project has
twice lost work to two sessions sharing one tree. So:

- **Change no file under `site/`.** Do not edit `build_media_data.py` — M-10 owns it.
- Do not commit. Do not deploy.
- Write exactly one file: your report, named below.
- Put any scripts you write under `tmp/qa/m11-dupes/` (gitignored).

## What counts as a duplicate here

A **content photograph** shown in more than one place — the same page twice, or two
different pages — where the repetition looks unintended.

**In scope:** photographs of Eyal, of people, of instruments, of the studio, of
events, of books and products. The pictures that carry meaning.

**Out of scope — do not report these:**
- Design and decorative assets: logos, icons, SVGs, textures, background scrims,
  arcs, watermarks, mandalas. These are *supposed* to repeat.
- Obvious placeholders — the same stand-in image occupying several unbuilt slots is
  a known, deliberate state, not a defect.
- A photograph deliberately reused in a designed way, e.g. a portrait that appears
  both on a bio page and beside a contact form. Report it, but label it intentional
  and say why you think so.

The judgement between "accidental repetition" and "deliberate reuse" is the valuable
part of this report. Do not just dump a list of matching hashes.

## Two kinds of duplicate — you must look for both

1. **Byte-identical.** Same sha256, different filenames. Known example, already
   measured by team_100: `assets/images/chapters/eyal-teaching.jpg` is byte-identical
   to `assets/images/chapters/tsva/tsva-32.jpg`. Same photograph, two filenames.
2. **Visually the same but not byte-identical** — re-encoded, resized, re-cropped, or
   re-saved at a different quality. These share no hash and are the ones a hash-only
   pass will miss. **Pillow 12.2.0 and `imagehash` are both installed** — use a
   perceptual hash (dHash or pHash) with a small Hamming distance, and report the
   distance alongside each pair so I can judge your threshold rather than trust it.
   Crops and heavy re-crops may defeat perceptual hashing too; say so where you
   suspect it rather than claiming completeness.

## It must be what is RENDERED, not what is on disk

A duplicate pair in `assets/images/` matters only if both copies actually reach a
visitor. So resolve every candidate pair to the pages that render it.

- 256 image paths are referenced by the theme, **zero broken**; roughly 24–28 images
  on disk are referenced by nothing at all. Those are not duplicates on the site —
  they are unused files. Report them separately, in one line, not as findings.
- Fetch the live pages and confirm. Staging is
  `http://eyalamit-co-il-2026.s887.upress.link` (TLS invalid there by design).

⚠ **Staging returns incomplete responses under repeated probing.** One fetch during
this session returned 150 bytes and a `grep` that had matched a moment earlier
returned nothing. **Assert each page actually loaded** — check a length and a known
element — before drawing any conclusion from it. Probe serially with a pause; do not
hammer it in parallel.

⚠ Do not judge an image from `curl` alone where JS builds the markup, and do not judge
an image that has not decoded (`naturalWidth === 0` on a lazy image makes comparisons
`NaN`, and `NaN` comparisons pass silently).

## Report

Write `_COMMUNICATION/team_10/DONE-S006-M11-DUPLICATE-CONTENT-IMAGES-2026-09-18.md`.

For each finding: the photograph (a description a human can recognise, not just a
filename), every file path it exists at, every live page and section that renders it,
whether the match is byte-identical or perceptual (with the distance), and **your
judgement: accidental or intentional, and why.** Order by how likely a visitor is to
notice.

Then: what you checked and found clean, what you could not measure and why, and the
one-line count of unused-on-disk images.

Every claim about code cites `file:line` (charter §3א-2). A check that could not run
reports COULD NOT MEASURE — never a pass by absence (charter §8א, clause 4).
