# DONE — S007 form: new card for the two unnamed decorative repair photos — 2026-09-26

Builder: Team 10. Task: add one card to Eyal's content-gaps form for EA-000161 and EA-000268 (the
two of the seven blank-`alt` photos on `/repair/` that the existing five-image card does not name).
Owner ruling 2026-09-26: «להעביר לאייל לאישור».

Staging base: `http://eyalamit-co-il-2026.s887.upress.link` (plain HTTP; the certificate is invalid
by design and is not a finding). Commit `535b9ab` on `main`, not pushed.

## Measurement, verified live before writing

`GET /repair/` → `HTTP/1.1 200 OK`. Nine `chapters/repair/` `<img>` tags in the rendered HTML:

| file | `alt` |
|---|---|
| EA-000239.jpeg | empty |
| EA-000298.jpg | empty |
| EA-000214.jpeg | empty |
| EA-000238.jpeg | empty |
| EA-000220.jpeg | empty |
| EA-000237.jpeg | non-empty (captioned) |
| **EA-000268.jpeg** | **empty** |
| EA-000242.jpeg | non-empty (captioned) |
| **EA-000161.jpg** | **empty** |

Seven empty, two captioned — matches the Team 90 measurement. The existing card
`HW-REPAIR-ALT` («כיתוב לחמש תמונות בעמוד התיקון») names exactly the five empty ones other than
EA-000161 and EA-000268. Those two are the two the 2026-09-24 audit judged decorative. Confirmed
by grepping the tracked form for `EA-000214|220|238|239|298` before writing — no other card
mentions them.

## What was added

New card `HW-REPAIR-DECOR`, placed immediately after `HW-REPAIR-ALT` in `חלק א` (same section,
same `.item`/`.now`/`.need`/`.fieldnote`/`.shot`/`fieldset.opt` markup and classes as the existing
card — copied its figure/thumbnail/caption-textarea mechanism verbatim for EA-000161 and
EA-000268). Contents:

- Heading naming the page, with `/repair/` as a working link.
- States plainly: 2 of the 9 gallery photos carry no caption, judged decorative on 2026-09-24,
  unlike the other five where a caption was requested.
- Asks Eyal to confirm the judgement or supply a caption.
- Three radio options, none pre-selected: «אני מאשר שהן דקורטיביות — בלי כיתוב» ·
  «אני רוצה כיתוב — כתבתי למטה» (with per-image caption textareas under each thumbnail, so this
  option hands over the actual text) · «אחר — פירטתי למטה» (free-text textarea).
- One explicit line that this is a separate question from the five-image card, so Eyal isn't asked
  twice.
- Both images shown as thumbnails with file-name captions, identical mechanism to `HW-REPAIR-ALT`.

`חלק א` header count bumped `— 8` → `— 9` (now 9 items in that section). `HW-REPAIR-DECOR` was
added to the `CARD_IDS` JS array (right after `HW-REPAIR-ALT`) so draft autosave covers it.
`FORM_SIG` (`wave1-20260925`) was **not** touched — Eyal's in-progress draft on the other cards is
preserved.

## Diff proof — only additions, apart from the two required one-line edits

`git diff` on the tracked file before commit showed exactly:

1. `<span class="cnt">— 8</span>` → `<span class="cnt">— 9</span>` (the one count-line change).
2. `CARD_IDS = ['HW-C1','HW-C3','HW-QR-HERO','HW-REPAIR-ALT',...]` → same array with
   `'HW-REPAIR-DECOR'` inserted right after `'HW-REPAIR-ALT'` (the one JS-array-line change).
3. The full new `<div class="item" id="HW-REPAIR-DECOR" ...>...</div>` block — pure addition,
   nothing else removed or reordered.

`HW-REPAIR-ALT` and every other existing card are byte-for-byte unchanged (confirmed — the diff
above is the complete change list, `24 insertions(+), 2 deletions(-)`, one file).

## Publish + live verification

- Tracked source: `_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html`
- Published copy: `hub/dist/s007-content-gaps.html` (gitignored, not committed)
- Published with `python3 scripts/ftp_publish_eyal_client_hub.py` (full hub publish, sequential
  FTP, one connection — no concurrency to worry about). Result: `Done: Eyal client hub FTP publish
  (1306/1306 files).` No 502s, no failed files.
- All three copies are byte-identical: tracked source, `hub/dist/`, and the live download all hash
  to md5 `10963e6da437e08cf49408ce53c951d2`, all `74042` bytes.
- `GET http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html` → `HTTP/1.1
  200 OK`, contains `id="HW-REPAIR-DECOR"`, `EA-000161`, `EA-000268`.
- `GET /repair/` (no redirects followed, `curl -sI`) → `HTTP/1.1 200 OK`, confirmed both before and
  after the publish.

## Constraints observed

- Wrote only the two HTML files listed above; did not touch `site/`, `_aos/`, `local/`, or
  `scripts/save_legacy_wp_app_password.py`, and did not run `scripts/s007_render_work_ssot.py`.
- Committed the tracked file only, by explicit path (`git add
  _COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html`), not `git add -A`. Not
  pushed.
- The publish script runs one FTP connection sequentially (never more than 1 concurrent request);
  no 502s were encountered so the retry-on-502 path was not exercised.

Live form: http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html
