# DONE — six dedicated placeholder cards added to Eyal's content-gaps form (2026-09-26)

## Task

Owner ruling 2026-09-26 (`«כל אחד כזה צריך לקבל כרטיס יעודי בטופס של אייל»`): each of the six
public placeholders Team 90 measured across the 153 published objects gets its own dedicated
card in the S007 content-gaps form — not a shared one.

## What changed

New section **חלק ח · תגי מקום פתוחים לציבור — שישה עמודים חיים** (count: 6), inserted
immediately before the free-notes section (**חלק ו**), in both:

- `_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html` (tracked source)
- `hub/dist/s007-content-gaps.html` (published copy, gitignored)

Six new cards, one per placeholder, quoting Team 90's exact measured strings:

| Card id | Page | Quoted string |
|---|---|---|
| `PH-TREATMENT-VIDEO` | `/treatment/` | badge title «כאן ייכנס סרטון מפגש» |
| `PH-LESSONS-VIDEO` | `/lessons/` | badge title «כאן ייכנס וידאו» |
| `PH-SOUND-HEALING-VIDEO` | `/sound-healing/` | badge title «כאן ייכנס וידאו» |
| `PH-TESTIMONIALS-MEDIA` | `/testimonials/` | badge title «אוסף המדיה בהשלמה» + badge note (media in-progress, sample images) |
| `PH-THERAPIST-TRAINING` | `/learning/therapist-training/` | badge title «מבנה המסלול, תנאי קבלה, מועדי פתיחה ועלות» |
| `PH-COURSES-EXTERNAL` | `/learning/courses-external/` | page body «יעלה בקרוב»; card states plainly the page's menu-hidden status was already decided by Eyal on 2026-09-24 and is not being re-asked — only content is |

Each card: names the exact page, links its live URL, states what's needed, gives 3–4 radio
options including at least one that hands something over (file/link upload options, not just
"let's talk"), and an «אחר» option with a free-text field. The five video/media cards each carry
one line distinguishing the ask from the existing `HW-VIDEO` card ("קרוסלת סרטונים בדף הבית
ובדפים חשובים") — that card is a home-page carousel; these are fixed per-page slots. The
`HW-VIDEO` card itself was not touched.

Also updated the form's `CARD_IDS` JavaScript array (used by the draft-autosave/restore logic)
to register the six new ids, so answers to the new cards persist in the browser like all
existing cards. `FORM_SIG` was deliberately left unchanged so Eyal's existing in-progress draft
for the other 24 cards is not reset.

## Verification (measurements, not descriptions)

- **File parity**: `diff` between the tracked source and `hub/dist/` copy — identical, both
  before and after the edit.
- **Diff is additions-only**: `git diff` on the tracked file shows 103 insertions, 1 deletion —
  the single deletion is the old closing line of the `CARD_IDS` array, replaced by the same
  values plus the six new ids appended. No existing `<div class="item">`, `<fieldset>`, or
  `<label class="opt">` block was altered. Balanced-tag check: 95 `<div>` / 95 `</div>`, 29
  `<fieldset>` / 29 `</fieldset>`, 30 `.item` divs (24 original + 6 new).
- **Live placeholder strings verified against the live pages before writing copy** (not just
  trusted from the brief) — `curl` fetch of each of the 6 URLs confirmed the exact quoted
  Hebrew strings are present, and confirmed the «ממתין לאישור» internal badge is visible on the
  five badge pages and absent on `/learning/courses-external/` (matches the brief).
- **Redirect check, `curl -sI` (no `-L`), verified before writing any Python fetcher**: all six
  page URLs return `200` directly, no redirects:
  - `/treatment/` → 200
  - `/lessons/` → 200
  - `/sound-healing/` → 200
  - `/testimonials/` → 200
  - `/learning/therapist-training/` → 200
  - `/learning/courses-external/` → 200
- **Publish**: `python3 scripts/ftp_publish_eyal_client_hub.py` — dry-run first (confirmed
  `s007-content-gaps.html` in the upload set, no errors), then real run — `Done: Eyal client hub
  FTP publish (1306/1306 files)`, exit 0, no FTP errors in the log.
- **Live form re-fetched after publish**: `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html`
  returns `200`, contains all six new card ids (`grep -c` = 1 each) and the new section heading,
  and is **byte-identical** (`diff` = 0 lines) to the tracked source file.
- **No changes under `site/`**: `git status --porcelain site/` is empty — the concurrent builder's
  work there was left untouched. `git status` also shows two pre-existing unrelated modified
  files (`_COMMUNICATION/team_100/S006/DEPLOY-LOG.md`, `scripts/s007_render_work_ssot.py`) that
  were already dirty at session start and were not touched or committed by this task.

## Commit

`5ef8cda` — tracked source file only (`hub/dist/` is gitignored, so the published copy is not
committed; it is live via FTP as verified above). Not pushed.

## Live form

http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html
