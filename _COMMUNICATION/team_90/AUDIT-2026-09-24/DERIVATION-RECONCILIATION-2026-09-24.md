# Forward derivation reconciliation — Eyal's wave, 2026-09-18 11:58 → 2026-09-23

**Direction:** from his words to the task, not the reverse. **Scope:** the six raw sources named in the mandate, checked against `_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json` (178 items) and `content-gaps-2026-09-21/GALLERY.html`. This file only reports. No SSOT edit, no code change, no commit was made while producing it.

---

## 0. The loudest finding first — the 17-note list is not in this repo

The claim under test (`docs/project/.../2026-09-23--whatsapp-after-1158/MESSAGE-2026-09-18-to-2026-09-22.md`, line 3) reads:

> "18/09/2026 11:58 — רשימת 17 ההערות. כבר נגזרה למשימות. לא נפתחת מחדש."
> ("18/09 11:58 — the list of 17 notes. Already derived into tasks. Not reopened.")

**The list itself does not exist anywhere in this repository.** `CHAT-SLICE-FROM-2026-09-18T1728.txt` says so explicitly: the window it captures starts at 17:28 on the 18th, and it names the 11:58 note only to say it is *not* included ("לפני החיתוך, לא בחלון הזה: 18/09/2026 11:58 רשימת 17 ההערות (כבר נקלטה)"). Nothing else in `docs/project/eyal-ceo-submissions-and-responses/` or `_COMMUNICATION/team_100/S007/` contains it. A repo-wide grep for "1158", "11:58", "17 הערות" and "seventeen" turns up only documents that *refer* to the note, never its content.

I located the actual list outside the repo, in the raw WhatsApp export the summary was built from: `/Users/nimrod/Downloads/WhatsApp Chat - אייל עמית/_chat.txt`, lines 1870–1887 (message timestamped `[18/09/2026, 11:58:21]`). It is reproduced in full in §4 below because the claim that it was "already derived and not reopened" is the thing being audited, and it turns out to be **false for roughly half the list**.

---

## 1. Headline counts

| Source | Discrete statements found | FAITHFUL | NARROWED | REINTERPRETED | NOT-DERIVED |
|---|---|---|---|---|---|
| 1 — 17 notes of 18.9 11:58 | 17 | 6 (#1,6,7,10,15,16) | 7 (#3,4,5,9,11,12,17 — see note below) | 1 (#2) | 1 (#8) |
| 2 — Content-gaps SOURCE-C (129 `contentAnswers`) | 129 | 129 at raw-capture level* | 7 named blog posts carry a *second*, distinct ask blanket-overridden by one "historical-as-is" ruling (P002, P003, P006, P008, P009, P010, P024) | 0 | 0 at raw-capture level |
| 3 — Excel answers (15 pageApprovals + 8 answers = 23) | 23 | 15 | 3 (R1-17/18 sub-point 3 deferred; R1-28 dark-block instance not separately tracked) | 0 | 5 (R1-08, R1-09, R1-10, R1-13 plain approvals never logged in SSOT; R1-15 /stand-floor/; R1-16 /books/ block order) |
| 4 — Media-filter notes (188 of 851 items) | 188 (32 distinct texts) | ~37 identification/caption notes mostly applied (Mokesh gallery, home, books, stands captions) | ~151 generic "add to bottom gallery" placement notes rolled into one tracking item (T-GALLERY-ASSIGNED), only 9 of them (the repair page) actually built | 0 | 179 of the 341 "need" images have no page and no build plan beyond the one tracking line |
| 5 — WhatsApp slice 18.9 17:28–22.9 13:50 | 9 (excluding social chat) | 7 | 0 | 0 | 1 (Nimrod's own promised nav-restructure proposal "by evening" of 21.9 — no artifact of it exists anywhere) + 1 duplicate of source 2/4 (three form re-saves, see §5) |
| 6 — Design notes docx, 23.9 | ~20 (17 general notes + 7 QR swaps counted as one bundle + 1 stray question) | 15 (incl. all 7 QR swaps, verbatim, closed) | 3 (nav order recorded-not-applied; blog-category "think about it" left open; cookie button default) | 1 (breadcrumbs, same defect as #2 above — one finding, two sources) | 0 new (everything in the docx that isn't derived is the same gap already counted in source 1) |

`*` — see §2. Every one of SOURCE-C's 129 answers is copied **verbatim** into an SSOT item's `eyal.choice`/`eyal.note` for a matching `id`. That is real capture, not a rubber stamp — but capture of his words is not the same as his request being carried out, and §3 documents seven cases where it wasn't.

**Total explicit NOT-DERIVED rows below: 9 (some already folded into the counts above; see the table for the exact list).**
**Total explicit REINTERPRETED rows: 1 defect, cited from two independent sources.**

---

## 2. Source 1 in full — the 17 notes, one by one

Transcribed verbatim from `/Users/nimrod/Downloads/WhatsApp Chat - אייל עמית/_chat.txt` lines 1870–1887. For each: derivation status **as of the 18.9 note itself** (not as of whatever eventually got fixed).

| # | His text (verbatim, translated in brackets for orientation only) | Status | Evidence |
|---|---|---|---|
| 1 | "סרגל עליון מופיע פעמיים 'אייל עמית'... אולי ליד הלוגו צריך להיות כתוב: המרכז לטיפול בדיג'רידו." | **FAITHFUL** | `WAVE-A-EYAL-NOTES-2026-09-20.md` row #1: wordmark "המרכז לטיפול בדיג׳רידו" added by logo; commit `8f5c9c6` ("Ship Wave A of Eyal's notes"), theme 1.5.96, 20.9 — two days after the note. |
| 2 | "להוסיף לאתר קישורי 'פירורי לחם'." | **REINTERPRETED** (see §3, item R1) | `S007-WORK-SSOT.json` `optimizationRound.rows[2]` ("קידום"): closed as "הסימון כבר היה חי... פירורים" — schema.org breadcrumb *markup* (invisible SEO data), not the visible navigation links he asked for. |
| 3 | "יש באתר בלוקים בצבע שחור שנראים כמו פוטר... צריך לשנות את הצבע." | **NARROWED**, and **not from this note** | `WAVE-A-EYAL-NOTES-2026-09-20.md` "מה לא נכנס" list names "בלוקים שחורים" explicitly as excluded from Wave A. It only entered the SSOT (M4/T-COLOR) after he retyped the identical sentence in the 23.9 docx — 5 days later. Even then, books and snoring pages were explicitly excluded (§3, item R2). |
| 4 | "הכותרות הראשיות בהירו לא מסודרות טוב... cbDIDG לא נראה יפה בכלל." | **NARROWED / not from this note** | Same Wave-A exclusion list ("שבירת כותרות"). Only entered SSOT as M7, sourced solely from the 23.9 docx, status still `waiting/eyal` — unresolved as of 23.9. |
| 5 | "צריך להוסיף קרוסלת סירטונים!" | **NARROWED / not from this note** | Not mentioned at all in Wave A (neither done nor excluded — silently absent). Only entered SSOT as M8, sourced solely from the 23.9 docx, `waiting/eyal` for the video files. |
| 6 | "בפוטר צריך שיהיה רשום 'ספרים – מוזה הוצאה לאור'... 'בלוג דיג'רידו'... 'כלים ואביזרים'. 'לימוד והכשרה'." | **FAITHFUL** | `WAVE-A-EYAL-NOTES-2026-09-20.md` row #6, live 20.9; confirmed in current code `site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-footer.php` lines 27–33 — all four labels present verbatim. |
| 7 | "לוודא שיש הודעת איסוף נתונים... הודעה תיקנית על פי חוק!" | **FAITHFUL**, but in two steps | Wave A row #7 shipped an informational dialog only (`<dialog>`, no accept/reject) on 20.9. Full copy with "אישור"/"דחייה" buttons and "אישור" as default only shipped after he supplied exact wording in the 23.9 docx (`T-COOKIE-COPY`, theme 1.5.114). |
| 8 | "צריך לבקש מקלוד לעבור על כל התוכן של הבלוג ועל כל התוכן של דפי ה-QR ולתקן את כל הקישורים הפנימיים... צריך שיהיו מקושרים לאתר החדש." | **NOT-DERIVED** (see §3, item N1) | Two search strategies below, plus two independent repeats of the same request that were *also* dropped (P002, P006 in SOURCE-C). |
| 9 | "מוסיקת רקע להירו... עם לחצן ברור של אפשרות להשתיק." | **NARROWED / not from this note** | Absent from Wave A. Only entered SSOT as M9, sourced solely from the 23.9 docx, `waiting/eyal` for the file. |
| 10 | "בדף צור קשר יש שני לחצני וואצאפ, צריך למחוק אחד." | **FAITHFUL** | Wave A row #10, live 20.9: variant B removed from DOM, `wa.me` count = 1. |
| 11 | "בלוג, האם אפשר לבקש מקלוד להעתיק את כל תמונות הנושא מהאתר המקורי?" | **NARROWED / not from this note** | Absent from Wave A. Entered SSOT as `T-BLOG-HERO-OLD` sourced solely from the 23.9 docx: 51 of 52 posts copied; one post has no original-site image either and was never invented. |
| 12 | "בלוג... מילות מפתח... כולן נוגעות לכתיבה... צריך להוסיף לחצן נוסף עבור 'דיג'רידו' ו-'נשימה'." | **NARROWED / not from this note** | Absent from Wave A. Entered SSOT as `T-BLOG-CHIPS` sourced solely from the 23.9 docx: two chips shipped; his docx follow-up ("לחשוב אם צריך להוסיף קטגוריות נוספות") explicitly left open, not actioned. |
| 13 | "דף שאלות ותשובות – איך מגיעים אליו מהסרגל הראשי?" | **FAITHFUL** (as a tracked open question) | Wave A doc: "FAQ ועדויות נשארו במגירה" (deliberately parked, not silently dropped). Still open in M1 as of 23.9 ("שאל אם שאלות נפוצות ועדויות נכנסים לסרגל"). FAQ/testimonials confirmed absent from `ea-canonical-nav.php` today — genuinely still undecided, not lost. |
| 14 | "דף עדויות והמלצות – כנ"ל." | **FAITHFUL** (same tracked question as #13) | Same evidence as #13. |
| 15 | "תיקון וחידוש כלים בסרגל צריך להיות: תיקון וחידוש כלי דיג'רידו." | **FAITHFUL** | Wave A row #15, live: `ea-canonical-nav.php` line 76 reads exactly "תיקון וחידוש כלי דיג׳רידו" today. Not tracked under its own SSOT item id, but the WAVE-A doc plus current code are direct, dated evidence. |
| 16 | "בדף שיעורי דיג'רידו הטקסט של ההירו גלש למעלה ומופיע מאחורי הסרגל הראשי." | **FAITHFUL** | Wave A row #16, with before/after CDP measurements (`h1Top=0/overlap true` → `h1Top=88/overlap false`) and screenshots. |
| 17 | "אולי כדאי להגדיל טיפה את הסרגל הראשי... וברגע שמתחילים לגלול למטה אפשר להקטין את הסרגל עם טרנזישן יפה." | **NARROWED / not from this note** | Wave A "מה לא נכנס" explicitly excludes "הגדלת הסרגל בגלילה." The nav *did* get enlarged twice by 21.9 (per his own WhatsApp: "ההגדלה קרתה פעמיים"), but Nimrod's reply says that happened from unrelated requests, not this one, and "לא מכניס לו עדין את הסבב החדש." The shrink-to-56px-on-scroll behavior that exists today predates this ask. The specific "enlarge, then shrink with a nice transition" request was never actioned; it resurfaces unresolved inside M1 on 23.9 ("להצר עוד בגלילה"). |

**Bottom line on the claim being audited:** of 17 notes, 6 (#1, 6, 7, 10, 15, 16) really were acted on within two days, matching the claim. But 7 (#3, 4, 5, 9, 11, 12, 17) were explicitly *excluded* from that first pass and only entered the SSOT because Eyal happened to retype the same sentences almost verbatim in his 23.9 design-notes docx — if he hadn't, they would have no trace in the system at all. One (#8) was never derived in either pass, despite being restated three separate times (see §3). One (#2) was closed against a different feature than the one he asked for. The claim "already derived into tasks and not reopened" is **accurate for a minority of the list and actively misleading for the rest** — several notes were, in effect, silently dropped for five days and only survived because he happened to repeat himself.

---

## 3. NOT-DERIVED table — the deliverable that matters

| # | Source · locator | His verbatim text | Search strategy 1 | Search strategy 2 |
|---|---|---|---|---|
| N1 | Source 1, note #8 (18.9 11:58) **and** Source 2, `SOURCE-C` ids **P002**, **P006** (21.9) | 18.9: *"צריך לבקש מקלוד לעבור על כל התוכן של הבלוג ועל כל התוכן של דפי ה QR ולתקן את כל הקישורים הפנימיים. כרגע הם מקושרים לאתר הנוכחי. צריך שיהיו מקושרים לאתר החדש שאנו בונים עכשיו."* — repeated per-post in P002/P006: *"יש בטקסט היפרלינקים שמפנים לדפים באתר הישן. צריך לוודא שההיפרלינקים מעודכנים ומפנים לאתר החדש."* | Grepped the flattened SSOT (`items[]`) and the 23.9 docx text for "קישורים פנימיים", "internal link", "לתקן קישורים", "old site link" — zero hits. | Grepped the whole repo for a link-fix mandate, an "old-site → new-site" URL-rewrite task, or any `_COMMUNICATION` file discussing blog/QR hyperlink remediation — zero hits. Confirmed P002 and P006 are both closed under the blanket `nimrod.decision = "historical-as-is"` stamp ("נשאר כבאתר הישן, לא מחליפים תמונות"), which addresses images only and never mentions the hyperlink defect at all. |
| N2 | Source 3, `eyal-s006-excel-answers`, pageApprovals **R1-15** `/stand-floor/` | *"שים לב שבאתר המקורי יש תמונות שמשולבות בדף... שמראות את הסטנד הזה. בבקשה תשתמש בכל התמונות האלה ושלב אותן בדף החדש."* | Grepped SSOT flat file for "stand-floor" (path) — zero hits (only `/stands-storage/` exists, via M6, a different page). | Grepped for "בכל התמונות האלה" / "שילוב תמונות מהאתר המקורי" tied to this specific page — zero hits; the closest item (M6) is scoped to `/stands-storage/`, not `/stand-floor/`. |
| N3 | Source 3, `eyal-s006-excel-answers`, pageApprovals **R1-16** `/books/` | *"את הבלוק של 'למה את הספרים של מוזה תמצאו כאן' תעביר מעל לבלוק של 'שלושה ספרים, שלושה עולמות'."* | Grepped SSOT flat file for both block titles verbatim — zero hits. | Grepped for any item with `path` = `/books/` (not `/books/kushi-blantis/` etc.) — zero hits; no item exists for the `/books/` index page at all. |
| N4 | Source 3, `eyal-s006-excel-answers`, pageApprovals **R1-28** `/snoring-sleep-apnea/` | *"גם כאן צריך לשנות את העיצוב של הבלוק שבו מופיע הלחצן: 'רוצה לדבר איתי'. זה נראה כמו פוטר... שים לב שהבלוק הזה מופיע כמה פעמים בדף וצריך לתקן את כולם."* | Grepped SSOT flat file for the literal button text "רוצה לדבר איתי" — zero hits. | Grepped for `path` = `/snoring-sleep-apnea/` combined with any color/block fix — the only hit is `T-ALIGN-SWEEP` (an unrelated alignment fix) and `M4`/`T-COLOR`, both of which *explicitly* list snoring as one of the pages left unrecolored ("בית ודום נשימה לא נצבעו"). No separate item exists to resolve his specific complaint. |
| N5 | Source 3, `eyal-s006-excel-answers`, pageApprovals **R1-08, R1-09, R1-10, R1-13** | Plain `"choice": "אושר למסך מחשב"`, `"approvalStatus": "אושר ע״י אייל"` for `/learning/lectures/`, `/learning/workshops/`, `/shop/`, `/bags/` — no free-text note, but a decision nonetheless. | Grepped SSOT for `trackerRow` values `R1-08`, `R1-09`, `R1-10`, `R1-13` — zero hits. | Grepped FORM/GALLERY HTML and the tracker CSV for any record of these four desktop-approvals — zero hits. These four "yes, approved" decisions have no home anywhere in the tracked system; they are not wrong, they are simply unrecorded. |
| N6 | Source 5, WhatsApp, 21/09/2026 13:47:22 (Nimrod, not Eyal, but a decision inside the audited window) | *"אני מכין לנו הצעה לשיפור - יהיה לקראת הערב."* (a nav-restructure proposal, promised "by evening") | Grepped the repo for any file named around "NAV-PROPOS*" / "MENU-PROPOS*" — zero hits. | Grepped for the phrasing "הצעה לשיפור" / "הצעת תפריט" anywhere in `_COMMUNICATION` — zero hits outside the WhatsApp quote itself. As of the 23.9 docx, Eyal is still the one proposing a nav order (M1), suggesting the promised proposal was never produced or sent. |
| N7 | Source 4, media-filter, 179 of 341 "need" images | Aggregate: every "need"-tagged photo with no `assignedPage`, no note beyond a generic placement instruction, and no built gallery. | `T-GALLERY-ASSIGNED` in the SSOT itself states the count: "179 שסומנו נחוץ בלי עמוד נשארו בלי עמוד" — an explicit, self-reported gap, not one I had to infer. | Cross-checked against live pages: only `/repair/` (9 images) is built; `/lessons/` (46 marked), `/eyal-amit/` about (9), the three book pages (9/9/3), `/bags/`, `/shop/` tools, `/treatment/`, `/sound-healing/` all remain without their assigned gallery per the same item. |

---

## 4. NARROWED and REINTERPRETED table

| Item | His text | SSOT item(s) | What differs |
|---|---|---|---|
| **R1 — REINTERPRETED** | Note #2 (18.9): *"להוסיף לאתר קישורי 'פירורי לחם'."* Repeated in the 23.9 docx: *"להוסיף לאתר קישורי 'פירורי לחם'"* (identical sentence, twice). | `S007-WORK-SSOT.json` → `optimizationRound.rows[2]` (topic "קידום"), `specifiedHe`/`doneHe` | He asked for **breadcrumb navigation links** — a visible, clickable UI trail a visitor can use to move up the page hierarchy (that is what "קישורים," links, means). What was closed as satisfying it is **schema.org breadcrumb structured data** — invisible JSON-LD markup for search engines that a visitor never sees or clicks. These are two different features that share an English name. Asked twice, resolved as neither time. |
| **R2 — NARROWED** | Note #3 (18.9) and its 23.9 restatement, **plus** R1-11, R1-17, R1-18, R1-28 in the excel file (21.9), all making the same complaint about different pages, with R1-17/18 explicitly saying *"את ההערה הזו צריך להחיל על כל דפי האתר שבהם מופיע בלוק בעיצוב כזה"* (apply this to every page with such a block). | `M4`, `T-COLOR` | He asked for a site-wide fix. What shipped (theme 1.5.114) recolored the band on `/method/`, `/repair/`, `/sound-healing/`, and `/learning/` only. Books (`kushi-blantis`, `tsva-bekahol`, and by extension `vekatavta`) and `/snoring-sleep-apnea/` were explicitly left dark, "כי אין שם כותרת ופסקה, ולא הומצא משפט" — a real constraint, but one that leaves his named pages (R1-17, R1-18, R1-28) with the exact defect he flagged, unresolved and with no separate tracking item of their own (see N4 above for snoring specifically). |
| **R3 — NARROWED** | R1-17 / R1-18 sub-point 3: *"את הבלוק של 'גלריה' צריך להעביר ממש לסוף הדף... גם על שני הספרים האחרים."* | `T-BOOK-FOLD` | Sub-point 2 (four lines + "המשך קריאה") shipped, live, on all three books. Sub-point 3 (move the gallery to the very end) is explicitly deferred: `T-BOOK-FOLD.summaryHe` says "הגלריה בסוף העמוד נשארת לגל ב" — correctly tracked, but only two of his three asks for this page were carried through in this round. |
| **R4 — NARROWED (systemic, 7 items)** | SOURCE-C notes on **P002**, **P003**, **P006**, **P008**, **P009**, **P010**, **P024** — each carries a *second* numbered point beyond the standard "take the hero image from the original post," e.g. P002/P006 ask for internal-link fixes (= note #8 again); P003 asks for image-in-text wrapping "exactly like you did here [link]"; P008 asks to add named women's photos and remove stray blank placeholder lines; P009 asks for a full paragraph-by-paragraph text replacement; P010 asks for a recommender photo per testimonial plus a separator line between entries; P024 asks to replace a dead-end "read more at the old blog" hyperlink with real content. | All seven items | Every one of these carries the single blanket stamp `stampHe: "היסטורי כמו שהיה — לא משימה נפרדת"` and `nimrod.decision: "historical-as-is"`, whose note only speaks to images ("לא מחליפים תמונות"). None of the second, more specific asks on these seven posts is mentioned, actioned, or separately dismissed — they were absorbed into a policy that wasn't written with them in mind. |
| **R5 — NARROWED** | Design-notes docx: *"בלוג... צריך לבקש מקלוד שיעבור על התכנים בבלוג ויחשוב אם צריך להוסיף קטגוריות נוספות."* | `T-BLOG-CHIPS` | Two chips ("דיג'רידו," "נשימה") shipped as asked. The follow-up request to review all blog content for further categories is logged only as an observation ("«כללי» עדיין 50 פוסטים — זו תצפית לפגישה, לא לחצן חדש") — noted, not acted on. |
| **R6 — NARROWED** | Design-notes docx nav-order request (10 items, right-to-left, one line, tighter separation, narrower on scroll). | `M1`, `T-NAV-HOLD` | `M1.summaryHe` itself says it plainly: "הסדר שכתבת נרשם ולא יושם" (the order you wrote was recorded, not applied). His exact wording is preserved verbatim in `eyal.note`, but zero of the four sub-asks (order, one-line font, logo separation, scroll-narrowing) is live as of 23.9 — all deferred to "the conversation." |

---

## 5. Source-by-source detail

### Source 1 — 17 notes of 18.9
Covered in full in §2. **The list itself is not in the repository**; recovered from `/Users/nimrod/Downloads/WhatsApp Chat - אייל עמית/_chat.txt` lines 1861–1887 (message block starts at line 1870).

### Source 2 — Content-gaps SOURCE-A/B/C
`SOURCE-A` (08:07), `SOURCE-B` (08:32) and `SOURCE-C` (10:01) are **byte-identical** in every one of the 129 `contentAnswers` — confirmed by direct field-by-field diff (`id`, `choice`, `note` match on all 129 rows, zero diffs found). This matches what the WhatsApp summary itself says ("אין כאן 129 שורות חדשות"). **Nothing in A or B is absent from C** — there is no drop between these three saves; they are the same file resent three times.

All 129 of `SOURCE-C`'s entries have a matching SSOT item by `id`, and all 129 are copied **verbatim** into that item's `eyal.choice`/`eyal.note` fields (confirmed programmatically — zero mismatches). That is real, faithful raw capture. The seven items in §4/R4 show where faithful capture of the *words* did not translate into faithful capture of *every ask inside those words*.

### Source 3 — Excel answers (11.06)
23 distinct statements: 15 `pageApprovals` (11 carry free-text notes; 4 are plain "אושר למסך מחשב" approvals with no note) + 8 point-level `answers` (identical to `pages[].items`, confirmed by direct comparison — not double-counted). 15 of 23 are faithfully represented in the SSOT (M3, M4, M5, M6, T-CONTACT-23, T-BOOK-FOLD, D3, etc., all citing this exact file as a source). 5 are NOT-DERIVED (N2–N6 above) and 3 are NARROWED (R2, R3 above, plus R1-28's specific instance folded into N4).

### Source 4 — Media-filter export (13:51)
851 items, 188 with a non-empty `note` (confirmed count). Those 188 reduce to only **32 distinct note texts** — 151 of the 188 are one of three generic placement instructions ("גלריה כללית בתחתית העמוד" ×127, "להוסיף לגלריה הכללית בתחתית הדף" ×19, "בגלריה הכללית בתחתית העמוד" ×5), 7 say "לשים בהירו," 3 say "סטנד רצפתי," and the remaining ~27 are one-off identification captions (mostly for the Mokesh memorial gallery: naming Jama, Anita, Mukesh's sons, Anat and the kids, the stolen didgeridoo, the old workshop, etc.).

The identification captions are largely **applied** — the SSOT's `optimizationRound.rows[0]` ("טקסט לתמונות") explicitly lists the Mokesh-gallery captions as live on the staging site, matching this export almost word for word. The generic placement notes are where the gap is: `T-GALLERY-ASSIGNED` is the single item carrying all of them, and by its own account only the repair page's nine photos are actually built; lessons (46), about (9), the three books (9/9/3), bags, shop tools, treatment and sound-healing galleries are named as still not built. A prior check ("all 188 ids appear somewhere") was checking the wrong thing — the ids appear because they're echoed in a summary line, not because each photo's placement instruction was executed.

### Source 5 — WhatsApp slice (18.9 17:28 → 22.9 13:50)
Social/non-task content excluded per the mandate (the Ronen Mandel referral). Nine discretely-tracked items: the three form re-saves (11:08/11:33/13:02, = source 2, no new content), Nimrod's 13:47–13:48 remarks (nav overcrowded + a promised proposal [N6, not derived] + "images are what I need most now" — this last is corroborated everywhere in the SSOT), the three gallery exports (15:30/15:57/16:51, last-wins, = source 4), the nav-bar screenshot discussion (folds into note #17), and the 22.9 blog-images clarification (= `T-BLOG-HERO-OLD`, already counted). No independent drop beyond N6.

### Source 6 — Design notes docx (23.9)
Extracted via `zipfile` + regex tag-stripping of `word/document.xml` (3,515 characters of body text). Contains: the breadcrumbs / black-blocks / hero-font / video-carousel / cookie-notice / blog-image / blog-keyword / FAQ-nav / testimonials-nav / logo-separation restatements already covered in §2 as the "note only survived because he repeated it" pattern, plus a **new** question ("היכן מופיע התקנון של האתר?" — answered inline in M1: already in the footer, FAITHFUL), the full ten-item nav order request (R6 above), and **seven QR content-swap requests** (QR6, QR8, 18QR/QR18, QR23, QR27, QR28, QR31) with specific YouTube URLs and one image URL. All seven are captured **verbatim and correctly** in `T-QR-SWAP`, closed, live on staging, video IDs matching exactly (`Lak0__1Hqwc`, `RH7Zv8Iqw4s`, `ZrRFtY9z3wY`+`GYQxjlUO15U`, `zoKn9_3xUIc`+`gdavWTyCcy4`, `sIA_-7lBmGY`, `Ht1Ub6Xl93g`, `-Jcqxr9Djjc`+`CR-7.jpg`) — the one part of this whole wave with a clean, fully faithful bill of health.

---

## 6. What I could not read / limits of this pass

- The 17-note list required leaving the repository entirely (Downloads folder, raw WhatsApp export) to find. Inside the repo, it is unrecoverable — worth fixing at the source-intake level, not just noting here.
- `docs/project/.../2026-09-23--whatsapp-after-1158/nav-bar-2026-09-21-15-38.jpg`, `old-site-eyal-baby.jpg`, and the Mokesh `mokesh-meeting.html` pack were referenced but not independently re-verified pixel-by-pixel against the SSOT's visual claims (e.g. burger button coordinates) — those numbers are taken on trust from `WAVE-A-EYAL-NOTES-2026-09-20.md`'s own CDP measurements, which I did not re-run live against staging.
- I did not re-render `FORM-EYAL-CONTENT-GAPS-2026-09-20.html` or `GALLERY.html` from the current SSOT to confirm byte-parity (that check exists already in `CONTROL-DERIVATION-2026-09-21.md` and was not repeated here, since that document's job was declared out of scope — it checks the renderer, not the source-to-SSOT direction this task covers).
- Source 4's 188 notes were checked by category and by the SSOT's own aggregate accounting (`T-GALLERY-ASSIGNED`'s stated 179-without-a-page figure), not by opening each of the 188 individual image thumbnails to confirm placement — with 851 images in the export, that would require the media-filter tool itself, not a repo read.
- I did not have git blame access confirmed for `ea-canonical-nav.php` line 76 beyond the log search performed; the WAVE-A document is treated as sufficient dated evidence for note #15 rather than a full history walk.

---

**Files this reconciliation is built from (all read in full or via `zipfile`/`json` scripts in scratchpad, not modified):**
- `/Users/nimrod/Downloads/WhatsApp Chat - אייל עמית/_chat.txt` (external, lines 1861–1936)
- `docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--whatsapp-after-1158/{CHAT-SLICE-FROM-2026-09-18T1728.txt, MESSAGE-2026-09-18-to-2026-09-22.md, eyal-s006-excel-answers-2026-09-21T11-06-38Z.json, ea-media-filter-2026-09-21T13-51-27-450Z.json}`
- `docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-21--content-gaps--from-eyal/{SOURCE-A,SOURCE-B,SOURCE-C}-*.json`
- `docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--design-notes/2026-09-23--design-notes--from-eyal.docx`
- `_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json`, `content-gaps-2026-09-21/GALLERY.html`
- `_COMMUNICATION/team_10/S007-GROK/WAVE-A-EYAL-NOTES-2026-09-20.md`
- `site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php`, `template-parts/chapters/section-footer.php`
- `git log` on this repo (commit `8f5c9c6` and surrounding history)
