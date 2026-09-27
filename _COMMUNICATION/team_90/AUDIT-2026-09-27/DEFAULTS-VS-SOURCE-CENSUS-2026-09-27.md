> # ⚠ PROVENANCE WARNING — THIS FILE IS NOT A team_90 MEASUREMENT
>
> **Stamped by team_90 (control), session `90- הכנה לעלייה לאוויר אייל עמית` [418028], 2026-09-27T15:10+03:00.**
>
> This file appeared in `_COMMUNICATION/team_90/` at 14:53 local, signed
> "team_90 adjudication". **The team_90 session that owns this directory did not write it and did
> not make that adjudication.** Per team_10, it was written by a session displaying the same
> `team_90` name but belonging to a **different project (the TikTrack domain)**, which had
> incidental filesystem access here. Nimrod caught the mix-up; that session was asked to purge
> EyalAmit data and confirmed it did.
>
> **The header line below that says "team_90 adjudication" is therefore false and is retained only
> so this record is not rewritten after the fact.** Do not cite this file as a team_90 finding.
>
> ## What team_90 has actually verified, by its own measurement
>
> **✅ CONFIRMED — the /books/ (muzza) S03.5 claim.** Re-measured independently on 2026-09-27:
> commit `4bc5f5c` (2026-08-21, "S006 wave 7: apply Eyal 19.8 book notes") does remove exactly the
> three marker strings of that bio block from `muzza-defaults.php`; and Eyal's own note in
> `_COMMUNICATION/team_100/S006/tracker/r19-eyal-answers.json`, `pages[12]` (pageKey R1-16,
> «ספרים»), `pageNotes[3]`, instructs that only the intro text remain under the hero — it names
> the intro, not the bio. **The removal was deliberate and Eyal's. Re-adding it was the error, the
> revert `47f405b` was correct, and this is not a document-vs-document conflict for Nimrod.**
> The only real defect is the stale header comment in `muzza-defaults.php` claiming a full verbatim
> copy of the source.
>
> **⚠ UNVERIFIED — everything else in this file**, including the vekatavta S05 gallery claim and the
> tsva-bekahol S06 button-text claim. They may well be right. **They are claims until team_90
> measures them**, and no card closes on them.
>
> ---

# DEFAULTS vs CITED SOURCE — census (team_90, 2026-09-27) — READ-ONLY, measured at `e2d9042`

**team_90 adjudication of the raw census below (read this first):**

- **muzza S03.5 «על אייל עמית» — RECLASSIFIED: ABSENT-BY-DESIGN (undocumented). It is NOT a content gap.**
  - The removal was commit `4bc5f5c` (2026-08-21, «apply Eyal 19.8 book notes»). That commit carried out Eyal's own later instruction for the /books/ page (`_COMMUNICATION/team_100/S006/tracker/r19-eyal-answers.json`, pages[12] «ספרים», pageNotes): «מתחת להירו להשאיר רק את הטקסט הזה: …».
  - The 25.5 source (MUZZA.md) is SUPERSEDED on this point by Eyal's 19.8 note.
  - **The real defect** is only that `muzza-defaults.php` does not document the removal, and that its header still claims «the FULL approved source copy VERBATIM».
  - ⚠ **Re-adding S03.5 contradicts Eyal's newer instruction.** Two directions conflict here (Nimrod's stage-A authorisation, which rested on «content is missing», and Eyal's 19.8 «keep only this text»). They go to Nimrod side by side BEFORE anything is published.
- **vekatavta S05 «גלריה» — a REAL gap (PARTIAL).** Eyal's 19.8 answer VKT-01 on the gallery says «קח את כל התמונות מכאן» (add the images); it does not remove the section's three intro lines. They were lost in the same `4bc5f5c`.
- **tsva-bekahol S06 — a REAL gap (PARTIAL, minor).**
  - Eyal's own 19.8 note for this page (block 9) gives the digital button text as «לרכישת הספר הדיגיטלי», with the Mendele link. The live defaults say «לרכישה דרך מנדלי», with no documented reason.
  - The dropped «(קריאה אונליין / הורדה)» predates the 19.8 notes (`8f4a1ed`).
- **Net result: 2 real gaps (vekatavta S05, tsva-bekahol S06) + 1 undocumented removal (muzza S03.5, a comment fix only).**
- **The documentation defect is a CLASS**, the same one in 4 other places (kushi-blantis S08 «גוף ככתבו» is wrong; tsva S08; didgeridoos S09; treatment S11). Several defaults files do not record WHY they diverge from their cited source. A fix lane should add a one-line «source superseded by …» comment at each divergence. That makes the next census mechanical.

---

# Census: do the page-defaults files deliver what their cited sources say?

- **Repo:** /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026 · **HEAD `e2d9042`**. Every defaults file and every source was read from the commit with `git show e2d9042:<path>`, never from disk. The only exception is marked "off-commit" below.
- **Files:** 35 `inc/chapters/defaults/*-defaults.php`.
- **Files whose cited source resolves in the commit:** 19. None of the literal paths resolves: files cite `content 13.8.26/…`, and that folder lives only in the gitignored `EyalAmit_Site_GoogleDrive_Sync/`. I resolved each one by name to its tracked copy under `docs/project/eyal-ceo-submissions-and-responses/from-eyal/`: `תוכן לאתר 25.5.26/<folder, with _ changed back to '>/…` for most, and `2026-07-12--snoring-sleep-apnea-didgeridoo-CHECKED.md` for snoring. The tracked copies match the local Drive copies:
  - 15 of the 16 `.md` files are byte-identical.
  - `vekatavta.md` differs only in the spelling of היקיקומורי (5 lines).
  - The testimonials `.docx` (media) is byte-identical.
  - The mokesh `.docx` has a different filename but the same words; only whitespace differs.
  - `en` cites `2026-09-21--content-gaps--from-eyal/SOURCE-C-…json`, item C3.
- **Positive control (muzza SECTION 03.5 «על אייל עמית») flagged: YES.** At e2d9042:
  - Coverage is 0 of 47 words, the heading is absent, and the Wikipedia URL is absent (0 of 1).
  - The same check on the working-tree copy, which another session is editing, gives 47 of 47 words and finds the URL (1 of 1). So the instrument finds the text when it is there.
  - History: the section was present from `873a757` (2026-06-22). It was removed in `4bc5f5c` (2026-08-21, "S006 wave 7: apply Eyal 19.8 book notes"). The removal is probably a reading of Eyal's 19.8 note «מתחת להירו להשאיר רק את הטקסט הזה», found in `_COMMUNICATION/team_100/S006/tracker/r19-eyal-answers.json`, pages[12]. The defaults file has no comment documenting the removal.
- **Working-tree note:** `git diff --stat e2d9042 -- …/muzza-defaults.php` shows 1 file changed, 14 insertions (+). The working-tree copy differs from e2d9042.

## Method
1. **Splitting sources.** Each source was split on `SECTION n` markers. `en` was split on its `#` headings instead.
2. **Removing non-content from sources.**
   - DEV NOTES bullet blocks and `> DEV NOTE` blockquotes were removed.
   - The document-title lines "Part N – Sections …" and label-only lines (`H1:`, `CTA:`, `תוכן:`, …) were ignored.
3. **Preparing the defaults text.** PHP comments were stripped, so a quote that appears only in a comment does not count.
4. **Normalising both sides.** HTML tags, niqqud and all quote/geresh variants were removed. Everything else was reduced to letters and digits.
5. **Scoring.** Each source word counts as present when it sits inside a 4-word shingle that also occurs in the defaults. Each section got a word-coverage percentage and a heading hit.
6. **Links.** Links were checked separately, both raw and percent-decoded.
7. **Manual review and history.** Every section below 85% was reviewed by hand, along with its git history (`git log -S`). I also looked for decisions in `r19-eyal-answers.json` (Eyal's 19.8 notes) and `_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json`.
8. **Internal links.** A missing internal URL was not counted as a gap when the defaults use the canonical slug instead. Examples: `/muzeh/…` became `/books/…`, and `/didgeridoo-treatment` became `/treatment/` or `$ea_treatment`. These rewrites are documented in the file headers.

**Negative controls**
- **PRESENT:** muzza S04 «למה את הספרים של מוזה תמצאו כאן». 60 of 60 words found and the heading hits.
- **ABSENT-BY-DESIGN:** lectures S09 «מה אומרים אחרי ההרצאה?». 0 of 4 words, correctly missing. The file header says «SECTION 09 (המלצות) לא מוצג — אין עדויות הרצאה מאושרות».
- **ABSENT-BY-DESIGN:** snoring S17, third source line «מקור רפואי מוסמך נוסף…». 0 of 14 words. The file header says «שורת המקור השלישית לא רונדרת».

## Files with gaps (ABSENT/PARTIAL, not by design)

### muzza-defaults.php
- **Source:** `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/מוזה הוצאה לאור - ספרים/MUZZA.md`
- **SECTION 03.5 «על אייל עמית» — ABSENT.**
  - Source opens: «אייל עמית הוא סופר ומוציא לאור, מהנדס אלקטרוניקה לשעבר ואיש במה לשעבר, שיצר במשך שנים…»
  - Searched: the heading, both bio sentences, the link text «לקריאה נוספת על אייל עמית בויקיפדיה», and the he.wikipedia URL (encoded and decoded). All had 0 hits.
  - Removed in `4bc5f5c`; see the positive control above.

### vekatavta-defaults.php
- **Source:** `…/from-eyal/תוכן לאתר 25.5.26/וכתבת/vekatavta.md`
- **SECTION 05 «גלריה» — PARTIAL.** The gallery images are present. The section's only text, three lines, is absent.
  - Source opens: «גלריית תמונות מתוך הספר, מתוך רגעים מהדרך, ומהמפגש של הסיפורים עם העולם.»
  - 0 of 12 words found.
  - Removed in `4bc5f5c`, when the prose block was turned into a gallery part. Eyal's note VKT-01 is about images only.
  - The in-file comment still claims «SECTION 05 · שורות 203–205 טקסט בלבד».

### tsva-bekahol-defaults.php
- **Source:** `…/from-eyal/תוכן לאתר 25.5.26/צבע בכחול וזרוק לים/eyal_tsva_FINAL.md`
- **SECTION 06 «רכישת הספר» — PARTIAL (minor).** 75% coverage.
  - Source opens: «ניתן לרכוש את הספר בשתי גרסאות: ספר מודפס (עותק פיזי) לרכישה דרך פנייה ישירה…»
  - Missing: the sub-line «(קריאה אונליין / הורדה)», 0 of 3 words. It was dropped in `8f4a1ed`.
  - Changed: the digital CTA label «לרכישת הספר הדיגיטלי במנדלי» now reads «לרכישה דרך מנדלי». No reason is given for the change.
  - By design: the Mendele URL swap to `tzvabekahol`. This follows Eyal's answer TSV-07 and is documented in the file.

## Differs from the cited source but explained outside the file (not counted as gaps; the files do not document them)
- **kushi-blantis S08 «על אייל עמית»:** 26% against the source. The text was replaced by Eyal's 19.8 note (`r19-eyal-answers.json` pages[7]); the defaults carry 143 of 154 words of that note. The in-file comment wrongly says «גוף ככתבו». The note's own typo «הדיג׳רוקשבה» is copied verbatim.
- **tsva-bekahol S08 «על אייל עמית»:** 26% against the source. Replaced by Eyal's 19.8 note (pages[14]); 118 of 129 words of the note are present.
- **didgeridoos S09 «המלצות»:** 19% against the source. The testimonials carousel was removed in `e8992be` per Eyal's choice «להסיר את הסקשן» (S007-WORK-SSOT.json, item D1). Only the section's closing lines remain, as a prose block with no source tag.
- **treatment S11 «מי זה אייל עמית»:** 83% against the source. «סטודיו נשימה מעגלית» was dropped under the retired-brand rule BN-01 (`_COMMUNICATION/team_100/S004/WP-S4-07-LOD400-2026-07-15.md` §5.2).

## ABSENT-BY-DESIGN (documented in the file) and N/A
- **By design:**
  - faq S02: «ירד לפי הערת אייל 19.8 עמודה 5».
  - faq S03–S10 (8 sections): delegated to the CPT corpus (header: «FAQ-03 corpus: inc/data/ea-faq-seed.json + mu-plugins/ea-s006-faq-merge-once.php»). Side note, not verified in depth and out of scope: the corpus holds 79% of S03's words and 86–100% of S04–S10.
  - lectures S09: see the negative control.
  - snoring S17, third line, and S18: «SECTION 18 לא רונדר».
  - about S15: «SECTION 15 (הערות SEO למתכנת) לא מוצג».
  - en: the Hebrew note to Nimrod.
  - muzza S10: the purchase URL, per «Mandate S007 Task A».
  - media: the testimonial text is by design in `inc/data/ea-testimonials-fb.json`. That corpus holds all 48 items and 100% of the docx words.
- **N/A (not page content):**
  - Developer, QA and SEO sections: kushi/tsva/vekatavta S13, repair S09 and S10, stand-floor S10, the global dev notes at the end of lectures S12 and workshops S14.
  - Image-only instructions: tsva S05, S11 and S14; kushi S05, S11 and S14.
  - The home S03 video, whose source URL is the placeholder `watch?v=XXXXXXXXXXX`.
  - repair S06: the source marks the block «לא פעיל עד הוספת המלצות אמיתיות».
  - treatment S09: the source marks it «(הוסר)».
  - muzza S01: menu instructions only.
  - The document-title preambles.

## No cited source, or path not resolvable at e2d9042
- **Cited path not in the commit:**
  - about, lectures and workshops cite `הערות של אייל לאחר סבב שלב 1 - 19.8.26/…md`. That folder exists only in the gitignored Drive sync.
  - Off-commit check against the local Drive copies: all three are clean. Every content section is at 85% or more; the only omissions are documented or N/A.
- **Cited, but not a content document or not in the commit:**
  - shop cites `EA-CONTENT-TRACKER.xlsx`. Only CSV snapshots are tracked.
  - thank-you cites only the id `EI-A4`.
  - accessibility cites audit evidence, not copy.
- **No source cited:**
  - contact («No Eyal .md source»), courses-external (owner placeholder), galleries (old-site Envira gallery).
  - learning and therapist-training (derived from about-defaults, team-authored).
  - privacy, terms, qr, qr-hub.
- **Derived:** treatment-eyal has no text of its own. It `require`s treatment-defaults.php and drops only the bleed quote and the FAQ extras, so it inherits treatment's clean result.

## Tally
- **Files:** of the 19 files with a source that resolves in the commit, 16 are clean and 3 have gaps (muzza, vekatavta, tsva-bekahol).
- **Gap sections:** 3 in total. 1 is ABSENT (muzza 03.5) and 2 are PARTIAL (vekatavta S05, tsva S06).
- **ABSENT-BY-DESIGN:** 16 section-level items, documented in the files.
- **Explained outside the file:** 4 divergences.
- **No usable source at e2d9042:** 15 files, of which 3 are clean against the off-commit Drive copies.
- **Derived:** 1 file (treatment-eyal).
