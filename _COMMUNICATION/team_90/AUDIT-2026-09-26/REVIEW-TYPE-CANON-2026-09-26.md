# Review — the content-type canon pair, rendered — 2026-09-26

**Verdict: YES.** Once the page finishes building (JavaScript, ~3 seconds on this run), the client
can open the catalogue, find a named type in the index or by scrolling, and say the owner's target
sentence — «שורה מטיפוס A עם תוכן B בעמוד C במיקום X». Every one of the 37 types the canon defines
has a human-readable name shown twice (index entry, and a badge+heading on the example itself),
clearly separated from the placeholder sample content inside the example. This is a materially
different result from Team 90's earlier **static** read, which could not see any of this because
the whole catalogue — index entries and all 37 example cards — is built by a single inline script
after load; a curl or no-JS view sees only the header and instructions.

Live URL checked: `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/ea-content-types.html`
(chrome, rendered, JS executed, polled until the DOM node count stopped changing at 512 nodes).
Tracked source: `_COMMUNICATION/team_100/EYAL-WORKSPACE/ea-content-types.html` — confirmed
byte-identical to the live file (both 60,532 bytes).

---

## 1 — Can he name a type?

**Yes, unambiguously.** Every one of the 37 `<article class="tcard">` elements carries, outside
and above the rendered example, a two-part label that is never sample content:

- `.tcard__badge` — "טיפוס 1", "טיפוס 2", … "טיפוס 37" (the ordinal).
- `.tcard__name` (an `<h3>`) — a plain-language type name, e.g. "הירו עמוד — עם תמונה",
  "פס קריאה לפעולה", "כרטיסי ספרים / מוצרים", "פוסט בלוג — תבנית חדשה".

The *example* itself (an `<iframe>` rendered with the theme's own live stylesheets) shows separate,
clearly-generic placeholder text — "כותרת העמוד" (the page title), "שם הספר" (the book's name),
"שם לדוגמה" (example name), "ציטוט לדוגמה" (example quote) — or, where the mandate allows it, real
site copy (the home CTA's actual button label "לתיאום שיחת היכרות" appears in the CTA example).
Nowhere does a placeholder string stand in for the type's name — the two are visually and
structurally distinct (label above the frame; sample content inside it).

The quick-jump index at the top ("קפיצה מהירה") lists all 37 types by number and name, grouped
into seven categories (openers, reading text, images/media, cards/lists, CTA, FAQ, and the
dedicated areas — blog/QR/contact/press), plus the two review lists. All 39 anchor links
(37 types + 2 review sections) resolve to a real element in the DOM — none dangle.

**This directly contradicts the static-read finding** that headings were sample content and the
index had only two entries — that was an artifact of reading the page before its script runs, not
a defect in the finished, rendered document. The mandate's own warning ("a static read cannot
answer any of this") is confirmed correct in the opposite direction: the static read undersold this
build.

## 2 — Is every type there? (compared in both directions)

**Both directions match exactly, 1:1, with no gaps and no extras.**

- The census (`TYPE-MAP-2026-09-26.md`) lists 36 row types with a renderer and a live page.
  `CONTENT-TYPES-CANON.md` adds one more (**#37, "Blog — New post," approved but not yet built**),
  for 37 total, and states this explicitly.
- The rendered artifact contains exactly 37 `<article>` elements, `id="t1"` through `id="t37"`,
  **no duplicate ids, no gaps** (verified programmatically against the full id list).
- Every rendered type's name was checked against the map/canon's numbered list and corresponds
  correctly — no mislabeling or swapped numbers (e.g. #13/#14 "whom cards"/"compare pair" are not
  swapped with each other; #16 "portrait collage" appears as "טקסט ותצרף תמונות" — text + image
  collage — matching that type's description; #37's "not built yet" status is stated in its own
  definition text, not presented as live).
- Nothing from the map is missing from the artifact, and nothing in the artifact has no source in
  the map/canon.

## 3 — The two review lists

**"מה עוד לא אחיד באתר" (significant deviations): 8 entries.** This matches exactly the "8 of 36
types are not uniform" figure from the map and the Stage-A "Significant deviations" table in the
canon (page hero, CTA band, prose row, split, floated figure, FAQ, gallery, video block). Each
entry states what a viewer would notice, in plain language, and is tagged with what is wanted from
the owner — "נדרשת ממך החלטה" (a decision is needed) on 7 of the 8, "נדרש ממך מבט" (a look is
needed) on the video-block entry. Each entry carries **two** links, "פתיחת דוגמה ראשונה ↗" /
"פתיחת דוגמה שנייה ↗" (16 links total), pointing at two live pages that show the deviation.
Fetched a sample of 9 of the 16 target URLs (`/repair/`, `/contact/`, `/method/`, `/books/`,
`/lessons/`, `/books/vekatavta/`, `/snoring-sleep-apnea/`, `/galleries/`, `/`) — **all returned
200.**

**"אזורים בלי טיפוס" (no-type areas): 4 entries.** Matches the Stage-A "Areas that fall under no
type" table exactly (QR page bodies, QR hero rule — approved not built, blog no-featured-image hero
— approved not built, blog new-post type — approved not built at all). Each entry states what a
viewer would notice and is tagged "נדרשת ממך הכרעה" (a ruling is needed) or "נדרש ממך מבט" (a look
is needed). Each carries one link, "פתיחת העמוד ↗" (4 links total). Fetched `/qr/qr1/` and
`/blog/` — **both 200.**

**One real weakness here, minor but worth recording:** two of the four no-type entries — "blog
no-featured-image hero" and "blog new-post type" — both link to the generic `/blog/` archive
rather than to a specific resource. For the new-post type this is unavoidable (zero live or draft
instances exist to link to). For the no-featured-image-hero entry, the map itself only got as far
as "(see `/blog/` for the current link)" rather than the specific post's slug, and the artifact
carried that gap forward rather than resolving it. The link still works (200), but it makes the
owner search `/blog/` for the one post in question instead of opening it directly.

## 4 — The client rule (no developer vocabulary)

**Clean. Zero occurrences of every forbidden term, checked in the rendered, visible text — not the
source.** Grepped `document.body.innerText` (12,490 chars of visible prose) and, separately, the
`innerText` of all 37 rendered `<iframe>` examples combined (3,045 chars — these are what a viewer
actually sees when the example paints, since the srcdoc markup itself is never displayed as text):

| Term | Count (main text) | Count (37 iframes combined) |
|---|---|---|
| `cta-band` | 0 | 0 |
| `.php` | 0 | 0 |
| `.css` | 0 | 0 |
| `301` | 0 | 0 |
| `404` | 0 | 0 |
| `410` | 0 | 0 |
| `class` | 0 | 0 |
| `grid` | 0 | 0 |
| `template-parts` | 0 | 0 |
| `--fs-` | 0 | 0 |
| `px` | 0 | 0 |
| `CSS` | 0 | 0 |

No instance of `px` (or any other term) appears anywhere in the rendered text, including inside
definition paragraphs, so there is no borderline case to adjudicate this round.

## 5 — Does it work as a page?

- **RTL:** `<html dir="rtl" lang="he">`. Confirmed on the live DOM.
- **Horizontal overflow at 390px:** none. `document.documentElement.scrollWidth` ===
  `clientWidth` === 390 after resize + settle.
- **Index links jump to targets:** all 39 anchors (37 types + 2 review sections) resolve to a real
  element; none dangle.
- **Console:** zero errors during load and script execution.
- **Load state observed:** the server-rendered HTML (pre-script) contains only the header, the
  "how to use this page" paragraph, and **empty** index/article containers (`<div class="grid"
  id="idx-openers"></div>`, etc.) — verified by fetching the raw HTML and inspecting everything
  before the first `<script>` tag. All 37 example cards and all 39 index entries are injected by
  one inline script (~40KB). It finished in this run in well under load-timeout (DOM node count
  stable at 512 within ~2.4 seconds of polling). **There is no `<noscript>` fallback and no visible
  loading state.** If the script is slow, blocked, or throws partway through, the visitor sees the
  header and instructions and then nothing — no catalogue, no error message, no spinner. This did
  not happen in this test, but it is the page's single point of failure and worth the owner's
  awareness given the mandate's explicit interest in "nothing is broken if JavaScript is slow."

## 6 — The pairing

**Confirmed, in the rendered page, both directions.**

- **Header** (rendered, not just source): "אייל עמית ונימרוד ולד · 26 בספטמבר 2026 · נכון לגרסת
  תמה 1.5.138 …" followed by a paragraph naming the paired definitions file ("קובץ תאום") with a
  working relative link (`CONTENT-TYPES-CANON.md`) and stating explicitly that the two files are
  always updated together and that changing one without the other is a defect.
- **Footer** restates: "תאריך ומספר גרסה: 26 בספטמבר 2026, גרסת תמה 1.5.138" and repeats the
  pairing rule in full ("שינוי בטיפוס כאן בלי עדכון מקביל בקובץ התאום הוא פגם…").
  It also states the examples render through the site's real stylesheet, not a reimplementation —
  matching the mandate's requirement.
- `CONTENT-TYPES-CANON.md` (read directly) opens with "**Paired document:** ea-content-types.html
  … Pairing rule: these two documents are edited together…" and states "Date: 2026-09-26. True for
  theme version 1.5.138" — matching the artifact exactly.
- The published copy at `hub/dist/`/`ea-eyal-hub/` correctly does **not** serve
  `CONTENT-TYPES-CANON.md` (confirmed 404) — the artifact's own text explains this is deliberate
  ("בעותק המתפרסם לרשת קובץ ההגדרות אינו מתפרסם, כי הוא מיועד לעבודה טכנית ולא לדפדפן"), so the
  404 is not a finding.

---

## What must change, worst first

1. **No fallback for a slow or failed script.** The entire catalogue (all 37 examples, all 39
   index entries) is injected by one inline script with no `<noscript>` content and no loading
   indicator. It rendered correctly and quickly in this test, but the page has no graceful
   degradation path if that script is ever slow, blocked by a content policy, or throws partway —
   the visitor would see the header and nothing else, with no sign anything is wrong. Not a defect
   observed today; a fragility worth a decision (accept the risk, or add a minimal loading/failure
   state).
2. **Two of the four "no-type" review entries link to the generic `/blog/` archive instead of a
   specific resource.** Both technically satisfy "a live URL he can open" (200, and one — the
   new-post type — genuinely has no specific resource to link to since nothing has been built).
   The other (blog no-featured-image hero) could point directly at the one affected post instead
   of asking the owner to find it inside `/blog/`. Low severity — the map itself only had "(see
   `/blog/` for the current link)" to work with, so this is inherited, not introduced.
3. No other defect found against the six checks in this mandate. Both documents exist, link to
   each other, state the pairing rule, the date and the theme version; all 37 types appear in both
   the map/canon and the rendered artifact with no gaps in either direction; both review lists are
   complete, linked, and labeled with what they need from the owner; the client-facing text is
   free of every forbidden term checked; the page is RTL, has no horizontal overflow at 390px, and
   its internal navigation works.
