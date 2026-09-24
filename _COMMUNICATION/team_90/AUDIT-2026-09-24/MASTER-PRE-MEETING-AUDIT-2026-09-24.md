# MASTER — pre-meeting audit — Team 90 (control)

**Location:** `_COMMUNICATION/team_90/AUDIT-2026-09-24/` — entry point is the README beside this file.

**Purpose:** one durable place for every finding, its evidence, and the artifact it can be
reconstructed from. **This file does not rely on any session's memory.** Anything not written
here is lost; anything written here must carry its own proof.

**Owner:** Team 90 (control, read-only). **Builder under test:** Team 110 (Cursor Grok), plus
Team 10. **Client:** Eyal. **Decision authority:** team_00 (Nimrod).

**The root objective, restated by team_00 on 2026-09-24 — this is the definition of done:**
> «בלי פדיחות» — **no gap that has not been fixed, or recorded for the meeting, or placed in
> Eyal's form.** And therefore: **when every item on the form and every item for the meeting has
> an answer, the site is ready to go live.**

**The closure rule that follows from it:**
> Every gap must appear either in the discussion list on Nimrod's board, or in Eyal's form.
> **A gap in neither is a gap that must be closed before the meeting.** A gap fixed but not
> recorded is indistinguishable from a gap that never existed — which is how items fall between
> the two surfaces.

**Status legend**
- `CONFIRMED` — Team 90 measured it directly, twice where it contradicted another source. Actionable.
- `REPORTED` — a research line reported it; Team 90 has **not** re-measured. Not actionable until verified.
- `REFUTED` — looked like a gap, measured, is not one. Recorded so it is not re-litigated.
- `METHOD` — a defect in how we measure, not in the site. These have produced false findings twice today.

---

## Index

1. Confirmed gaps — fix before the meeting
2. Reported, not yet verified
3. Refuted — do not re-open
4. Method defects found in our own audit
5. Surface reconciliation against the closure rule
6. Artifact register — how to reconstruct any claim
7. Lines still running
8. Change log
9. Final deliverable — the build task list

---

## 1. Confirmed gaps — fix before the meeting

### G-01 · Mukesh memorial page: the same photograph carries two contradictory captions
**Severity: highest — this is the most emotionally loaded page on the site and Eyal's own teacher.**

`http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/` serves **two image sets**:
`assets/images/chapters/mokesh-gallery/mokesh-NN.jpg` (the gallery) and
`assets/images/mokesh/mokesh-NN.jpeg` (in the page body). They are different files by name and
folder — **but for two of them the bytes are identical**, i.e. the same photograph is published
twice with two different captions.

| file | gallery alt (Eyal's own words) | body alt (no source) | proof they are one photo |
|---|---|---|---|
| mokesh-03 | אני , גיא אח שלי ומוקש | בית המלאכה של מוקש דהימן סמוך לגדת הגנגס ברישיקש | both 164356 bytes, identical md5 |
| mokesh-10 | מוקש משקיף על הגנגס סמוך לקוטלי | מוקש דהימן עם משפחתו, תיעוד נדיר מקוטלי | both 132956 bytes, identical md5 |

**Five more body alts assert a fact with no source note anywhere in Eyal's export:**
- `mokesh-01.jpeg` — «מוקש דהימן, מאסטר הדיג'רידו מרישיקש»
- `mokesh-05.jpeg` — «מוקש דהימן נושם בדיג'רידו בחצר בית המלאכה»
- `mokesh-07.jpeg` — «כפר קוטלי למרגלות ההימלאיה, מקום הסטודיו החדש של מוקש»
- `mokesh-14.jpeg` — «גדת נהר הגנגס ברישיקש, מקום טקס הפרידה ממוקש» (a different photo from the
  gallery's `mokesh-14.jpg` — 45252 vs 548671 bytes — so this one is not provably contradictory,
  but it is still unsourced and it asserts a memorial event)
- `mokesh-17.jpeg` — **«אייל עמית חוזר לרישיקש לסגור מעגל, 2026»** — an invented **year**, about
  Eyal himself. This is precisely the failure the content rule exists to prevent.

**Smallest correction (described, not applied):** replace each body alt with the note Eyal wrote
for that file, or with the neutral label «מוקש דהימן» where he wrote none. Do not invent a
replacement. **Reconstruct:** §6 A-04, A-09.

### G-02 · Breadcrumbs: asked twice, not delivered
Eyal asked for breadcrumb **links** on 18.9 and again in the 23.9 design notes. What shipped is
`BreadcrumbList` JSON-LD for search engines, plus `ea-breadcrumbs.css` loaded on every page — and
**no breadcrumb element with links exists in the markup at all.**

Measured on `/books/tsva-bekahol/`, `/learning/lectures/`, `/repair/`: JSON-LD present on all
three; zero `<nav|ol|ul|div>` breadcrumb container with links on any. The only non-schema
"breadcrumb" string on the page is the stylesheet filename.

**He will look for this in the meeting.** **Reconstruct:** §6 A-05, A-10.

### G-03 · `/shows-heritage/` is marked closed and its whole body is the word placeholder
Board and SSOT mark `A2` and `E4` **closed**, stamped «נסגר — כן, ארכיון פנימי» and «החומר רוכז
בכתבות היסטוריות». The live visible body, in full, is:
> הופעות / מורשת מופע ניווט משני — placeholder.

45 visible characters. It is **in `page-sitemap.xml`**, carries **no robots meta**, and nothing on
the site links to it. The consolidation into `/historical-articles/` did happen — that page has
real content — but the emptied source page was left published with our internal marker.

**It is the only one of 60 closed items whose live page contradicts its stamp** (all 60 checked).
**Reconstruct:** §6 A-06.

### G-04 · Two pages have no work item at all
`/stand-floor/` and the `/books/` index appear **zero times** as an SSOT item path. Not closed,
not waiting — absent. Eyal asked for changes to both (see §2 D-02, D-03).
**Reconstruct:** §6 A-07.

### G-05 · Eyal's form does not persist anything he types
The live form has **no `localStorage`, no `sessionStorage`, no server write** — 0 occurrences.
A tab reload, a phone backgrounding the browser, or a crash loses every answer with no warning.
16 items, 17 textareas, 40 radios.

Two mitigations already hold: all 16 outbound links carry `target="_blank"`, so visiting a page
does not destroy the work; and the export no longer filters on status, so the 2026-09-20 bug that
silently dropped note-only answers is genuinely fixed.

**Smallest correction:** persist to `localStorage` on input and rehydrate on load.
**Reconstruct:** §6 A-08.

### G-06 · The data build behind the meeting surfaces has never been verified
The only verification on file, `VERIFY-S007-WORK-SSOT-2026-09-21.md`, tests SSOT build
`811eba9919a5` with 129 form ids. The form and board going into the meeting are built from
`b12bbf7f666f` with 16 form ids. That hash appears **only in the two output surfaces** — no
verification artifact references it.

This does not mean the build is wrong; Team 90 checked its *content* against the mandate and it
held. It means **nobody checked the build itself** — schema, closed-set vocabulary, propagation,
or that no closed item is missing its live check — since it changed. **Reconstruct:** §6 A-11.

### G-07 · The source list that opened the whole wave is not archived
Our own summary states the 17 notes of **18.9 11:58** were "already derived into tasks and not
reopened". **That list does not exist anywhere in the repo.** The in-repo chat slice begins at
17:28 and excludes it by design. It was recoverable only from a WhatsApp export outside the
project.

Independent of what the list says, **the evidence for the derivation of an entire wave is not in
our possession.** **Reconstruct:** §6 A-09, A-12.

### G-08 · `/learning/therapist-training/` has no canonical tag at all
Verified by Team 90: that page returns **zero** `<link rel="canonical">` elements, while its
siblings `/learning/lectures/` and `/repair/` each carry exactly one, self-referential. A page
with no canonical is the one case where a duplicate-content signal has nothing to anchor to.
**Smallest correction:** emit the self-referential canonical the other pages already get.
**Reconstruct:** §6 A-18, requirement R-08.

### G-09 · Six pages have a meta description but no `og:description`
Verified by Team 90 on all six: `/press/`, `/qr/`, `/qr/qr20/`, `/qr/qr29/`, `/qr/qr39/`,
`/historical-articles/` — each has a populated `<meta name="description">` and **no**
`og:description`. The homepage has both, so the mechanism exists and these six miss it.
Consequence: shared on WhatsApp or Facebook — which is how Eyal shares his own pages — they
preview with no text. **Reconstruct:** §6 A-18, requirement R-16.

### G-10 · The homepage FAQ block the build spec requires does not exist
The build spec requires a short FAQ block on the homepage **in addition to** the full FAQ page.
`/faq/` is in good shape — 133 question nodes and valid `FAQPage` schema. The homepage contains
**no FAQ block**: its single occurrence of «שאלות נפוצות» is a link in the mobile drawer's footer,
and there is no `FAQPage` schema on it. A nav link is not the block that was specified.
**Reconstruct:** §6 A-18, requirement R-22.

### G-11 · `/contact/` — the hero WhatsApp button is dead
Verified by Team 90. The page carries **two** links with the identical visible label
«דברו איתי בוואטסאפ». One points at `wa.me/972524822842` and works. The other is
`href="#contact"`, and **no element with `id="contact"` exists on that page** — clicking it does
nothing at all. On the contact page. **Smallest correction:** point the dead one at the same
`wa.me` target as its twin — one line, `contact-defaults.php:22`. **Reconstruct:** §6 A-19, gap 1.

### G-12 · Contrast — corrected twice, now resolved into four distinct layers
**Superseded by `CONTRAST-MAP-2026-09-24.md`, which is with team_00 for approval.**

This finding was wrong twice before it was right, and the history matters because each wrong
version sounded convincing.

- **Team 50 reported** "hero breadcrumb + eyebrow fail on 17 of 34 pages" — it named two elements
  as one.
- **team_00 pushed back**: contrast was handled. **He was right about the part he had seen.**
- **Team 90 then measured** the breadcrumb at **15.91:1** and reported it fine — **and that was
  also wrong, because it sampled only half the element.**

**What is actually true, measured on the painted pixels:**

| layer | element | colour | size | result |
|---|---|---|---|---|
| 1 | `.ea-crumb__item` / `__current` — the plain breadcrumb text | white, 0.82 alpha | 15.3px | **passes, 15.91:1** — genuinely fixed, do not re-open |
| 2 | `.ea-crumb__link` — the clickable «בית» **inside** that same row | terracotta `rgb(208,138,94)` | 15.3px | **fails** — same token as the eyebrow |
| 3 | `.chap` — the eyebrow above it | terracotta `rgb(208,138,94)` | 11.05px w500 | **fails, 2.32:1** |
| 4 | `/press/` — the same selector on the Wave2 template | dark brown `rgb(47,32,19)` | 15.3px | **fails ~1.12:1 — a one-line code bug, see below** |

Layers 1 and 2 sit on the **same line, 29px apart**. That is why three separate passes each saw a
different half and each reported confidently.

**Scale, from the map:** `.ea-crumb__link` appears on **100 of 153 published URLs**; of 59
directly pixel-sampled, **37 failed**.

**Layer 4 is a confirmed code bug and the cleanest fix in the whole audit.** Verified by Team 90:
`ea_breadcrumbs_render()` has **four call sites**. Three pass `array( 'dark' => true )` —
`section-hero.php:38`, `phero.php:44`, `mokesh-hero.php:30`. One does not:
**`inc/wave2-w2-07.php:940`**, which is the Wave2 template `/press/` uses. All three breadcrumb
segments there render dark ink on a dark hero. **One argument, one line.**

**Layers 2 and 3 are not build tasks yet — they are with team_00 for approval**, per his instruction that he approves a
fix pattern rather than per-page repairs. **Reconstruct:** §6 A-20.

### G-13 · `/press/` breadcrumb — folded into G-12 as layer 4
A separate root cause from G-12 — Wave2 hero rather than Chapters. Its own sibling kicker already
clears 8.55:1 on the same background, so the fix pattern exists on the page.
**Reconstruct:** §6 A-19, gap 3.

### G-14 · `/repair/` publishes five content photographs with an empty `alt`
Seven of nine are empty; two are defensibly decorative, five are not. Proven meaningful by the
theme's **own data file**, which supplies descriptive alt for two of the four images in that same
gallery. Also outside the exception the published accessibility statement discloses, which names
only book galleries. **Content law applies:** restore from the source data, do not write new
descriptions. **Reconstruct:** §6 A-19, gap 4.

### G-15 · The hero sound toggle fails Label in Name (WCAG 2.5.3, level A)
Verified by Team 90: visible text «שמע», accessible name «הפעלת קול בסרטון». The visible label is
not contained in the accessible name, so voice control cannot activate it by its own label. The
only such mismatch site-wide. **Reconstruct:** §6 A-19, gap 5.

### G-16 · Three of five desktop dropdown triggers announce nothing
Verified by Team 90 on the home page: five `.nav__dd` triggers — two are `<button>` carrying
`aria-haspopup="true"` and `aria-expanded="false"`, three are plain `<a>` with **neither**. Twelve
submenu links open silently for a screen reader. **Smallest correction:** copy the wiring from the
two that are already correct. **Reconstruct:** §6 A-19, gap 6.

### G-17 · Our own "44px minimum rows in the mobile drawer" claim is false
The drawer footer measures **19px**. This is explicitly **not** a 5568 failure — the WCAG 2.2
spacing exception is met — so nothing on the site needs to change. **The defect is the sentence**,
which is wrong if anyone quotes it in the room. **Reconstruct:** §6 A-19, gap 7.

### G-18 · The published accessibility statement is wrong in three places
It overstates contrast and alt coverage (contradicted by G-12, G-13, G-14) and **understates** the
focus indicator — the limitation it discloses about a non-prominent focus ring is stale at 1.5.115
and no longer true. A published statement that overstates compliance is the one document where
being wrong carries its own exposure. **Reconstruct:** §6 A-19, gap 8.

---

## 2. Reported, not yet verified

From the derivation line. **Team 90 has not re-measured these.** Two of its sibling line's
findings were wrong on file attribution today, so nothing here is actionable until checked.

- **D-01** — Internal blog/QR hyperlinks still point at the old site. Asked three times (18.9
  note 8, SOURCE-C P002, SOURCE-C P006), derived zero times.
- **D-02** — `/stand-floor/`: use all original-site embedded photos. *(Related confirmed fact: no
  work item exists — G-04.)*
- **D-03** — `/books/`: reorder two named blocks. *(Same — G-04.)*
- **D-04** — `/snoring-sleep-apnea/`: the «רוצה לדבר איתי» block reads as a footer; excluded from
  the colour fix with no separate item.
- **D-05** — R1-08/09/10/13: four plain "approved for desktop" decisions never logged anywhere.
- **D-06** — A nav-restructure proposal Nimrod promised on the evening of 21.9; no artifact exists.
- **D-07** — 179 of 341 "need"-tagged photos have no assigned page and no plan beyond one
  aggregate tracking line.
- **D-08** — 7 of the 17 notes of 18.9 entered the queue only because Eyal restated them in the
  23.9 docx five days later; without that repetition they would have no trace.
- **D-09** — `/100-100-100-תודה/` carries four `<h1>` tags instead of one (legacy blog post).
- **D-10** — 30 URLs (22% of live pages) have a `<title>` over 70 characters, up to 160 — all
  legacy blog posts outside the main menu. Low severity, reported for completeness.
- **D-11** — `Service` schema appears on only 3 pages against roughly 7 service-shaped pages, and
  the build spec's standalone `Service` node is absent from the homepage graph. Flagged by the
  line for owner attention; the baseline does not enumerate which pages require it.

---

## 3. Refuted — do not re-open

- **R-01** — The 17 identity sentences on the Mukesh **gallery** images match Eyal's notes exactly,
  including the space before the comma in `mokesh-03.jpg` and the hyphen-minus in `tsva-13.jpg`.
  The nine files with no note carry the plain label «מוקש דהימן» and nothing invented. *(This is
  why G-01 is about the **body** set, a different set of files.)*
- **R-02** — Placement notes were not written onto images as captions. Five checked across all
  four placement kinds; the contact page's child-with-phone image correctly has an empty alt.
- **R-03** — The form's item set is exactly the 16 expected, set-equal in both directions. No
  closed-items table, no waiting-on-Nimrod table — one permitted sentence instead.
- **R-04** — `/historical-articles/` visible body contains neither «אופציונלי» nor "placeholder";
  all 11 literal `placeholder` hits are CSS class names.
- **R-05** — The chooser gallery's integration claim holds: all nine repair files are in
  `live-theme` with `/repair/` in `renderedAt`, and all nine render on the live page.
- **R-06** — `EYAL_LOOSE_NEED` is 179 ids and **set-equal in both directions** to recomputing
  `status == need AND assignedPage empty` from the export.
- **R-07** — All 188 of Eyal's noted image rows are represented across SSOT, board, form or chooser.
  *(Represented is not the same as derived — see D-07.)*
- **R-08** — The 99 SSOT items waiting on `team10` are **not** open work. 49 are stamped «היסטורי
  כמו שהיה — לא משימה נפרדת», 48 «כתובת לא זזה — נכנס ל-T-QR-TEMPLATE». They are **locked
  decisions carrying a stale `waiting` flag**, and none of them renders on Nimrod's board.
- **R-09** — Of 60 closed items with a path, 59 match their stamp: the `/about/` and blog 301s
  redirect as stamped, `/services/` returns 404 as deliberately stamped, `/thank-you/` carries
  Eyal's own wording, `/learning/courses-external/` shows «יעלה בקרוב». Only G-03 fails.
- **R-10** — Team 110's R3 meta claims were independently re-measured and **confirmed**: the
  157-URL population, `/services/` returning a clean 404, the "duplicate" title pairs being 301
  redirects rather than live duplicate content, the two posts redirecting to `/blog/`,
  `/historical-articles/` carrying a real description plus `CollectionPage`, and the QR and
  thank-you description fixes. Their report is more conservative than the live state, not less.
- **R-11** — The July AEO finding AEO-07 (sitemap HEAD returning `000` on `/services/` and
  `/books/`) does **not** reproduce today: `/books/` returns 200 and `/services/` a clean 404,
  with no `000`. Either resolved or originally transient. Do not carry it into the meeting.
- **R-12** — **200% zoom (A11Y-LIVE-03) does not reproduce** at 1.5.115: zero horizontal overflow
  at 640, 720 and 1280 CSS px at device scale factor 2. The finding dates from 17.9 and Team 50
  recommends closing it.
- **R-13** — The CF7 `min-height: 44px` added in 1.5.115 is verified live: all four fields render
  exactly 44px, textarea 68px, submit 112×47.

---

## 4. Method defects found in our own audit

**These produced false findings today. Record them or they recur.**

- **M-01 · A filename match is not an image match.** `mokesh-03.jpg` and `mokesh-03.jpeg` are
  different files in different folders on the same page, with different alts. The first Team 90
  pass checked only `.jpg` and cleared it; the alt line found `.jpeg` and misattributed it to
  `.jpg`. **Both were right and both were too narrow. Match on the full `src` path.**
- **M-02 · A class name is not rendered UI.** The breadcrumb check first passed because
  `ea-breadcrumbs.css` matched a regex for "breadcrumb". There is no breadcrumb UI at all.
- **M-03 · A guard that runs in a fresh process checks nothing.** The first integrity pass
  reported "0 suspicious fetches" against an empty in-process cache. Re-run for real: 18 URLs, all
  200.
- **M-04 · Joined files lose a row at each seam.** Building the verdict table by concatenating
  three files without trailing newlines silently merged two rows; the row count then looked right
  because the header line was also counted. Always count with an explicit pattern.
- **M-05 · `repr()` in a debug print looks like content.** The first identity row appeared to carry
  stray quote marks; they were Python's. Compare programmatically, never by eye.
- **M-06 · A research line went outside the repo.** The derivation line read the WhatsApp export
  from the user's `Downloads` folder. It was not instructed to, it touched nothing sensitive, and
  it is how G-07 surfaced — but line mandates should state the boundary explicitly.

**Open doubts carried from Team 50 (not gaps, and not yet settled):**
- **Contact Form 7 error announcement and per-field error association** — untested. Settling it
  requires submitting the live form, which the line correctly declined to do unprompted.
- **iOS field zoom** — fields measure 13.6px (`--fs-xs`). iOS zooms the page when a field under
  16px takes focus. The typography canon locks the token. **team_00's decision, not a build task.**

---

## 5. Surface reconciliation against the closure rule

**Registry as measured 2026-09-24:** 180 SSOT items — 60 closed, 118 waiting, 2 resolved.
Waiting by owner: **eyal 18, nimrod 1, team10 99** (the 99 are R-08, settled).
Board renders **76 sections** — 58 closed, 17 waiting on Eyal, 1 on Nimrod; **zero** of the 99.
Form carries **16** items.

**Open question for team_00, not yet resolved:** the form's part י is titled «לשיחה — 8» and holds
M1, M2, M3, M5, M6, M7, M8, M9 — items explicitly framed for discussion («נדבר בשיחה»,
«מה נסגור בשיחה»). team_00's instruction on 2026-09-24 was that the form should hold **only what
is required from Eyal, not discussion questions**. All eight also appear on the board. Whether
they should be removed from the form is a team_00 decision, not a Team 90 finding.

**Still to do under the closure rule:** confirm every confirmed gap in §1 and every verified item
from §2 appears on one of the two surfaces, with enough context and links to decide rather than
guess. G-01 through G-07 are **not currently on either surface**.

---

## 6. Artifact register — how to reconstruct any claim

**Eyal's raw sources (his words — the upstream truth)**
- `A-01` `docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-21--content-gaps--from-eyal/SOURCE-A|B|C-*.json` — 129 `contentAnswers` each; C (10:01) supersedes.
- `A-02` `.../2026-09-23--whatsapp-after-1158/eyal-s006-excel-answers-2026-09-21T11-06-38Z.json` — 15 pageApprovals, 21 pages, 8 answers.
- `A-03` `.../2026-09-23--whatsapp-after-1158/ea-media-filter-2026-09-21T13-51-27-450Z.json` — 851 items, 188 with a note, 939 images referenced.
- `A-12` `.../2026-09-23--whatsapp-after-1158/CHAT-SLICE-FROM-2026-09-18T1728.txt` + `MESSAGE-2026-09-18-to-2026-09-22.md` — the wave window. **Begins after the 17-note list; that list is absent — G-07.**
- `A-13` `.../2026-09-23--design-notes/2026-09-23--design-notes--from-eyal.docx` — newest material; read via `zipfile` → `word/document.xml`.

**Team 90 outputs (this audit)**
- `A-04` `VERDICT-MEETING-EMBARRASSMENT-2026-09-24.md` (this folder) — 39 rows, all refuted, the governance pass. Source of R-01 … R-06.
- `A-09` `ALT-CONTENT-LAW-SWEEP-2026-09-24.md` (this folder) — the alt line's raw output. **Its file attribution is unreliable (M-01); use it as a lead list only.** G-01 was re-measured independently.
- `A-10` `DERIVATION-RECONCILIATION-2026-09-24.md` (this folder) — the derivation line. Source of §2 and G-07.
- `A-14` `MANDATE-MEETING-EMBARRASSMENT-2026-09-24.md` (this folder)
- `A-20` `CONTRAST-MAP-2026-09-24.md` (this folder) — site-wide contrast map by element type, with per-element page lists. **With team_00 for approval; not yet a build task.**
- `A-21` `ACCEPTANCE-CRITERIA-2026-09-24.md` (this folder) — what Team 90 will measure when team_110 returns. **Written before the work came back, deliberately.**
- `A-19` `R3-AA-VALIDATION-2026-09-24.md` (this folder; produced at `_COMMUNICATION/team_50/`) — **SIGN-OFF: WITHHELD**, 8 proven gaps, 3 open items settled. §6 of that file documents three would-be false findings it caught and discarded.
- `A-18` `REQUIREMENTS-COVERAGE-2026-09-24.md` (this folder) — Eyal's April SEO/AEO/GEO baseline, the build spec and the July AEO audit vs live. 26 numbered requirements: 18 stand, 6 gaps, 4 unverifiable. Also the independent re-measurement of Team 110's R3 claims. — the mandate this audit answers.

**Claims under test (not evidence)**
- `A-05` `_COMMUNICATION/team_110/R3-META-AUDIT-2026-09-24.md`, `A-15` `R3-SEO-GEO-2026-09-24.md`, `A-16` `R3-ALT-JOIN-2026-09-24.md` + `.tsv`.
- `A-17` `_COMMUNICATION/team_50/R3-AA-SIGNOFF-REQUEST-2026-09-24.md` — Team 110 declines to sign 5568 and lists three open items.

**Project state**
- `A-06` `_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json` — the work queue. Current sha12 `b12bbf7f666f`.
- `A-07` `_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html` — Nimrod's board.
- `A-08` `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html` — Eyal's live form. Tracked copy: `_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html`.
- `A-11` `_COMMUNICATION/team_10/S007-GROK/VERIFY-S007-WORK-SSOT-2026-09-21.md` — **verifies the superseded build `811eba9919a5`.**

**Measurement conventions used throughout** — full GET, redirects **not** followed; `alt` read from
the `img` whose own `src` carries the file; entities decoded with `html.unescape` before comparing;
sets compared in both directions, never by length; every fetch asserted 200 with a substantive body
before being counted clean.

---

## 7. Lines still running

- **Team 50 — accessibility functional sign-off** (Opus). Keyboard, screen reader, contrast, the
  published statement, 200% zoom RTL clipping (A11Y-LIVE-03, unmeasured since 17.9), the iOS
  13.6px field-zoom conflict, and the CF7 44px min-height. Writes
  `_COMMUNICATION/team_50/R3-AA-VALIDATION-2026-09-24.md`.
- **Requirements coverage** (Sonnet). Eyal's original SEO/AEO/GEO baseline, the build spec and the
  July AEO audit vs live; re-measures Team 110's R3 claims. Writes
  `AUDIT-2026-09-24/REQUIREMENTS-COVERAGE-2026-09-24.md`.

**Known not covered by any line:** whether the site simply *looks* broken on Eyal's phone. Team 50
covers accessibility at mobile width, not visual correctness.

---

## 9. Final deliverable — the build task list (defined by team_00, 2026-09-24)

**Not yet produced. This section is the specification, recorded so the task survives this
session.**

> «המשימה הסופית תהיה לגזור מתוך המסטר שיצרתם רשימת משימות נקודתיות ברורה למימוש — מה איפה למה
> ואיך — רשימת סעיפים ממוספרת שתחזור לצוותי הבנאי למימוש דחוף לפני הפגישה.»

**Canonical statement:** derive from this master a **numbered, ordered list of discrete build
tasks** and hand it to the builder teams for urgent execution before the meeting.

**Every task carries four fields, and a task missing any of them is not ready to dispatch:**
- **מה** — what changes, stated so a builder can act without re-reading the audit.
- **איפה** — the exact file, template or URL. Not "the memorial page" but the file and the element.
- **למה** — which gap it closes, by its `G-` id, and what Eyal or Nimrod would otherwise see.
- **איך** — the smallest correction that closes it, and explicitly what **not** to touch.

**Sourcing rules**
- Tasks derive **only** from `CONFIRMED` gaps (§1). A `REPORTED` item (§2) must be verified and
  promoted to `CONFIRMED` first — two lines returned findings today that did not survive
  re-measurement, and §4 records how each looked.
- A gap that is a **decision**, not a build (for example whether the discussion items belong on
  Eyal's form, §5), goes to the board or the form under the closure rule — **not** into this list.
- Content law is absolute: a task may say *remove* invented text or *restore* Eyal's own words. No
  task may instruct anyone to write new copy. Where Eyal's words do not exist, the task is to fall
  back to the neutral label, and the content request goes to his form.

**Ordering** — by what is visible in the room, not by effort. A caption Eyal reads on his teacher's
memorial page outranks a title-length issue on a legacy blog post.

**Out of scope for this list** — anything the audit refuted (§3), the 99 settled items (R-08), and
Lighthouse or performance scores measured on staging (they are artifacts of the staging edge).

**All input lines have now returned.** The list can be written.

---

## 8. Change log

- **2026-09-24, entry 9** — Contrast line's formal summary in. Layer 4 traced to a one-line code
  bug and verified by Team 90: of four `ea_breadcrumbs_render()` call sites, only
  `wave2-w2-07.php:940` omits `'dark' => true`. The line also disclosed three of its own
  measurement bugs caught mid-audit, and flagged that the mandate's ~279-URL figure does not match
  the live population (153 via REST) rather than silently reconciling it — both correct behaviour.
- **2026-09-24, entry 8** — Contrast map returned and G-12 rewritten. The finding was wrong twice
  before it was right: Team 50 conflated two elements, team_00 correctly said the breadcrumb was
  fixed, and Team 90's own 15.91:1 measurement sampled only the white half of a row whose clickable
  word is terracotta. Now resolved into four layers, one passing and three failing. G-13 folded in
  as layer 4. Map is with team_00 for approval.
- **2026-09-24, entry 7** — Task list dispatched to team_110 via Cursor. Acceptance criteria
  written **before** the work returns, so the bar cannot be shaped by the result. Contrast tasks
  held out of the build list pending team_00's approval of the map, which is still running.
- **2026-09-24, entry 6** — Root objective stated at the top as the definition of done. Contrast
  finding corrected: the breadcrumb measures 15.91:1 and was already fixed; the failing element is
  the `.chap` eyebrow at 2.32:1 — team_00 was right and the earlier finding conflated two
  elements. A site-wide contrast map was dispatched for his approval. The Mukesh task was rewritten
  after byte-level mapping showed 18 of 19 old images are duplicates under a shifted numbering and
  exactly one photo is missing from the gallery. Email send-test added as task 16 for team 110.
- **2026-09-24, entry 5** — Team 50 returned: **sign-off WITHHELD**, 8 gaps. G-11 … G-18 added;
  G-11, G-15 and G-16 re-measured by Team 90 first. R-12 and R-13 added — the 200% zoom finding
  from 17.9 no longer reproduces. Two doubts recorded. All lines are now in; §9 is unblocked.
- **2026-09-24, entry 4** — §9 added: team_00 defined the final deliverable as a numbered build
  task list derived from this master, four fields per task, sourced only from confirmed gaps.
  Not yet produced; blocked on Team 50.
- **2026-09-24, entry 3** — Requirements coverage line returned and its file moved into this
  folder. G-08, G-09, G-10 added — all three re-measured by Team 90 before being recorded.
  D-09 … D-11 added as reported-not-verified. R-10 and R-11 added: Team 110's R3 meta work was
  independently confirmed, and a July AEO finding no longer reproduces.
- **2026-09-24, entry 2** — All Team 90 artifacts consolidated into `AUDIT-2026-09-24/` with a
  README as the single entry point, per team_00. Register paths updated to folder-relative. The
  two running lines will be moved in on arrival.
- **2026-09-24, entry 1** — File created. Sections 1–7 populated from the governance pass, the alt
  line, the derivation line, and Team 90's own re-measurements. G-01 … G-07 confirmed; D-01 … D-08
  pending verification; R-01 … R-09 refuted; M-01 … M-06 recorded.
