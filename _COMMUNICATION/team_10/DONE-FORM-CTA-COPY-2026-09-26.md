# DONE — CTA-band copy cards added to the content-gaps form

2026-09-26 · team_10 (builder) · theme 1.5.138 (verified live, matches the team_90 measurement)

## Task

Per the owner's 2026-09-26 ruling («בלוקים בלי כותרת - להוסיף לאייל לנסח - כל אחד סעיף בטופס. לא
חובה גם כותרת וגם פסקה - חובה משהו. לא רק כפתור.»): add cards to
`FORM-EYAL-CONTENT-GAPS-2026-09-20.html` for every CTA band on the site that has no words at
all, only a button.

A prior attempt at this exact task was cut off by an environment restart before writing
anything. Verified from scratch: before this session, the form still had exactly 32 cards and
no `DONE-FORM-CTA-COPY-2026-09-26.md` existed.

## Verification against the live site (before writing)

Fetched all 9 pages team_90 named, from `http://eyalamit-co-il-2026.s887.upress.link`, and parsed
every `<section class="cta-band...">` block for each. Confirmed theme version 1.5.138 from the
live `style.css`. The team_90 counts and button labels matched exactly, band for band:

| Page | Bands with no heading/paragraph | Button label(s), in page order |
|---|---|---|
| `/bags/` | 1 | «לתיאום והתאמה של תיק לדיג'רידו» |
| `/books/` | 1 | «לרכישת חבילת 3 הספרים» |
| `/books/kushi-blantis/` | 2 (of 3 bands — the middle band already has a heading and is excluded) | 1st: «לרכישת הספר» · 3rd: «לרכישת הספר» |
| `/books/tsva-bekahol/` | 2 (of 3 — middle band already has a heading, excluded) | 1st: «לרכישת הספר» · 3rd: «לרכישת הספר המודפס» |
| `/books/vekatavta/` | 3 | «לרכישת הספר» × 3 |
| `/didgeridoos/` | 3 | «לתיאום הגעה והתנסות בכלים», «לבדיקת זמינות והתאמה», «לתיאום הגעה ובחירת כלי» |
| `/snoring-sleep-apnea/` | 3 | «רוצה לדבר איתי» × 3 |
| `/stand-floor/` | 1 | «ליצירת קשר» |
| `/stands-storage/` | 1 | «לתיאום והזמנה» |

**Total: 17 bare-button bands across 9 distinct pages.** All 9 are commercial pages, as stated.

**Note on the brief's "10 cards" language:** the brief's narrative and its verify-section both say
"10 cards," but its own per-page table lists exactly 9 distinct page URLs, and those 9 sum to the
stated 17 bands. I verified the live site against that same table and found 9 real pages, not 10 —
no tenth page or additional band exists. Built 9 cards (one per page, per the "ONE CARD PER PAGE"
instruction), which is the count that is actually consistent with 17 total band fields. Flagging
this rather than silently padding to a round number that doesn't match any real page.

## What was built

One card per page (9 cards total), following the existing `HW-REPAIR-ALT` /
`HW-REPAIR-DECOR` precedent (one field per item, plus a shared "אחר" catch-all):

- New section `חלק י · באנרים עם כפתור בלבד, בלי משפט אחד — לנסח` (count "— 9"), inserted after
  `חלק ט` and before the free-notes section `חלק ו`, matching the existing heading pattern.
- Each card has: an `<h3>` naming the page, its live staging URL as a working link, a factual
  "מה מוצג היום" line stating the band shows a button and nothing else (no sentence at all —
  making clear the text element is absent, not empty), each band's exact button label and its
  ordinal position on the page (1st/2nd/3rd, counted across *all* CTA bands on that page,
  including ones that already have a heading — so multi-band pages like the two book pages
  correctly skip "2nd" where that band is out of scope), a "מה מבוקש ממך" line explicitly stating
  neither a heading nor a paragraph is required — something is — and a bare button is not enough.
- One free-text `<textarea>` per band (`note-CTA-<PAGE>-B<n>`), never pre-filled with suggested
  wording — only a generic placeholder ("שורה או משפט קצר לבאנר הזה/הראשון/...").
- A shared radio-button `<fieldset>` per card, nothing pre-selected, with three options:
  "כתבתי למטה" (single-band cards) or "כתבתי למטה לכל באנר בנפרד" (multi-band cards) — the
  option that hands something over — "נדבר בשיחה — לא ממלא בנפרד", and "אחר — פירטתי למטה".
- A closing "אחר" `<textarea>` per card for general notes.
- No copy was drafted or suggested anywhere in the new cards — only the kind of line wanted was
  described, per the content law.

New card ids, registered in the JS `CARD_IDS` array (appended after `REDIRECT-MAP-APPROVAL`,
`FORM_SIG` left untouched at `wave1-20260925` so no in-progress draft is wiped):

```
CTA-BAGS, CTA-BOOKS, CTA-KUSHI, CTA-TSVA, CTA-VEKATAVTA,
CTA-DIDGERIDOOS, CTA-SNORING, CTA-STAND-FLOOR, CTA-STANDS-STORAGE
```

## Verification after writing

- **Card count:** 41 `.item` cards total (32 existing + 9 new). Confirmed by direct grep.
- **Band-field count, forward:** 9 cards × per-page band counts (1+1+2+2+3+3+3+1+1) = 17.
- **Band-field count, backward:** `grep -o 'name="note-CTA-[A-Z-]*-B[0-9]"'` returns exactly 17
  matches, one per band, matching the table above exactly (including `KUSHI`/`TSVA` skipping
  `B2`, since that band already has a heading and is out of scope).
- **HTML validity:** ran the new + full file through Python's `html.parser` tag-balance checker —
  zero mismatched or unclosed tags.
- **Byte-identity:** `_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html` and
  `hub/dist/s007-content-gaps.html` are byte-identical (same MD5:
  `326481420f9b799a1eae13b6afb4adb4`) after copying the source over the (gitignored) dist mirror.
- **Existing cards unchanged:** `git diff` on the tracked file shows exactly one deletion line
  (the old `CARD_IDS` closing line, which just gained a continuation) and 185 insertion lines —
  every other line in the diff is a pure addition. No existing `.item` card, radio name, or
  textarea name was touched.
- **Live form:** published via `python3 scripts/ftp_publish_eyal_client_hub.py` (exit code 0,
  ~315 legacy media files re-verified/re-uploaded as part of the standard prune-and-sync). The
  live form now returns **200** and its body is **byte-identical** (same MD5) to the local
  `hub/dist` file. All 9 new card ids (`CTA-BAGS` … `CTA-STANDS-STORAGE`) are present in the live
  HTML, total `.item` count is 41, and `FORM_SIG` is confirmed unchanged at `wave1-20260925`.
- **Every referenced page URL** returns **200** with redirects not followed (`curl -sI`, no
  `-L`), for all 9 pages: `/bags/`, `/books/`, `/books/kushi-blantis/`, `/books/tsva-bekahol/`,
  `/books/vekatavta/`, `/didgeridoos/`, `/snoring-sleep-apnea/`, `/stand-floor/`,
  `/stands-storage/`.

## Files changed

- `_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html` (tracked, committed)
- `hub/dist/s007-content-gaps.html` (gitignored publish mirror, kept byte-identical, published
  live)

Commit: `605d849` — "Add 9 cards for headless CTA-band copy to the content-gaps form"

## Live form

http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html
