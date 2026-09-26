# DONE — HW-VEKATAVTA-ALT card added to Eyal's content-gaps form (2026-09-26)

## Task

Add one card to the S007 content-gaps form for six uncaptioned images on the «וכתבת» book
page, following the pattern of the two existing repair-page image-caption cards
(`HW-REPAIR-ALT`, `HW-REPAIR-DECOR`).

## Verified before writing anything

- Fetched `http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/`: **96 `<img>` tags,
  exactly 6 with empty/missing `alt`** — `veka-54.jpg`, `veka-69.jpg`, `veka-76.jpg`,
  `veka-90.jpg`, `veka-94.jpg`, `veka-99.jpg`. Matches the brief exactly.
- Fetched `/books/`, `/books/kushi-blantis/`, `/books/tsva-bekahol/`, `/galleries/` and parsed
  every `<img>` tag: **0 empty-alt images on all four** (7, 22, 44, 149 images respectively) —
  confirms the other book pages/galleries are clean and this is the only open page.
- `curl -sI` (no `-L`) on all five URLs above before writing any Python fetcher, and again on
  `/books/vekatavta/` itself: all return `200` directly, no redirects.

## What changed

New card `HW-VEKATAVTA-ALT`, inserted in **חלק א · המשך ביתי** (count updated 9 → 10),
immediately after `HW-REPAIR-DECOR` and before `HW-VIDEO`, in both:

- `_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html` (tracked source)
- `hub/dist/s007-content-gaps.html` (published copy, gitignored)

The card:
- Names the page («וכתבת») and links its live URL.
- States what's there today: 96 images on the page, 90 carry a caption, 6 do not — not
  declared decorative, just empty.
- States the "why" plainly: the site publishes a legal accessibility statement, and it can't
  claim full alt-text coverage while these six are open — not framed as pressure.
- Shows the six images as thumbnails with their file names (`veka-54` … `veka-99`), same
  `<figure class="shot">` mechanism as the repair cards, each with its own caption `<textarea>`.
- Radio choice with **nothing pre-selected**: an explicit "כתבתי למטה — כיתוב לתמונות שלמעלה"
  (hands something over, not just "we'll talk"), "אני מאשר שהן דקורטיביות", and «אחר» with a
  free-text field.
- One explicit line distinguishing it from the repair-page cards above it, so Eyal doesn't read
  it as the same question twice: "זו שאלה על עמוד «וכתבת» בלבד, נפרדת מהכרטיסים שלמעלה על עמוד
  התיקון — אינך מתבקש לענות עליהם פעמיים."
- **No captions were drafted or suggested anywhere in the card** — only placeholders
  ("כיתוב (רשות)") matching the existing repair-card pattern.

`CARD_IDS` JS array updated with `HW-VEKATAVTA-ALT` (inserted after `HW-REPAIR-DECOR`) so
draft autosave/restore covers the new card. **`FORM_SIG` left untouched** — Eyal's in-progress
draft is preserved.

No existing card was modified. Nothing under `site/` was touched.

## Verification (measurements, not descriptions)

- **File parity**: tracked source and `hub/dist/` copy `diff` to 0 lines, both before the edit
  and after (1076 lines each, byte-identical).
- **Diff is additions-only**: `git diff` — 28 insertions, 2 deletions. The two "deletions" are
  the section count line (`9` → `10`) and the `CARD_IDS` array line (same values plus the one
  new id inserted) — no existing `<div class="item">`, `<fieldset>`, or `<label class="opt">`
  block was altered.
- **Card count**: 41 `.item` cards before → **42 after**.
- **Publish**: `python3 scripts/ftp_publish_eyal_client_hub.py --dry-run` first (confirmed
  `s007-content-gaps.html` in the upload set), then a real run with `--no-prune` (this repo is
  the main checkout, not a worktree, but pruning the full remote tree was unnecessary risk for a
  one-card change) — `Done: Eyal client hub FTP publish (1308/1308 files)`, exit 0, no FTP
  errors.
- **Live form re-fetched after publish**: `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html`
  returns `200`, contains `HW-VEKATAVTA-ALT` (12 occurrences) and all six file names
  (`veka-54`…`veka-99`), and is **byte-identical** (`diff` = 0 lines, both 99,616 bytes) to the
  published `hub/dist/` copy.
- **No changes under `site/`**: `git status --porcelain site/` is empty — the concurrent
  session's theme work was left untouched.
- **Pre-existing unrelated dirt not touched**: `scripts/s007_render_work_ssot.py` (modified) and
  `scripts/save_legacy_wp_app_password.py` (untracked) were already present at session start,
  were not opened, not run, and were left out of the commit.

## Commit

`55e6263` — tracked source file only, explicit path
(`_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html`). `hub/dist/` is
gitignored, so the published copy is not committed; it is live via FTP as verified above. Not
pushed.

## Live form

http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html
