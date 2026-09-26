# Review — EYAL-REDIRECTS-APPROVAL-2026-09-26.html

Reviewer: Team 90 (control), precise-check pass per the owner's ruling that the redirect
topic is not closed until the document is verified accurate and clear to Eyal.

Document reviewed: `_COMMUNICATION/team_90/AUDIT-2026-09-26/EYAL-REDIRECTS-APPROVAL-2026-09-26.html`
(same content live at `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/eyal-redirects-approval.html`)

Sources checked against: `RESEARCH-REDIRECTS-2026-09-26.md`, `OLD-SITE-MIGRATION-AUDIT-2026-09-24.md`,
and fresh live measurement of `https://www.eyalamit.co.il` (all 20 Yoast sub-sitemaps fetched and
counted directly, plus live title fetches of every named example page) done for this review today.

## VERDICT: **No — not ready to send to Eyal as-is.**

The headline numbers (1,255 / 251 / 1,004 / 50 / 201) are all independently re-confirmed accurate
against a fresh, live count of the old site's own sitemaps today. The document is genuinely clean of
developer jargon, and it functions correctly in a live browser (RTL, no overflow at 390px, nothing
pre-selected, answers survive reload, the copy button produces a usable plain-text summary). But one
group's own internal arithmetic does not add up to the number printed on it, two named examples are
inaccurate in ways that would mislead a first-time reader, and one group's factual claim about "already
existing" pages is wrong for one of its 50 members. None of this is catastrophic, all of it is fixable
in minutes, but none of it should go to Eyal unfixed.

---

## 1 — Are the numbers still true?

**Top-line figures: confirmed accurate.** I fetched all 20 of the old site's own Yoast sub-sitemaps
live today (not from any cached report) and counted every `<loc>` directly:

| Sitemap | Live count today |
|---|---|
| page-sitemap.xml | 81 |
| post-sitemap.xml (blog) | 54 |
| attachment-sitemap1+2.xml | 1000 + 4 = 1004 |
| portfolio_page-sitemap.xml | 25 |
| category-sitemap.xml | 6 |
| post_tag-sitemap.xml | 47 |
| shows-sitemap.xml | 4 |
| envira + envira_album | 5 + 1 = 6 |
| product-sitemap.xml (distinct from `/shop/` root, already counted in page-sitemap) | 7 |
| product_cat-sitemap.xml | 2 |
| shop_order-sitemap.xml | 1 |
| pagescategory/portfolio_category/testimonials_category/slides_category/carousels_category/author | 2+3+2+8+1+2 = 18 |
| events-sitemap.xml | **0** (empty — not a missed content type) |

Sum of content sitemaps = **251**, matching the document's "251 עמודי תוכן" exactly. 1000+4 = **1,004**
media files, matching exactly. 251+1,004 = **1,255**, matching the document's headline exactly. The qr
pages (qr1–qr48, 48 numbers, all present, no gaps) plus `/qr/` and `/qr/פרק-א/` = **50**, matching "qr1
עד qr48 ועוד שניים" exactly. 251−50 = **201**, matching the stated remainder exactly. **These five
headline figures are solid — no discrepancy found.**

The 20th sub-sitemap, `events-sitemap.xml`, is not mentioned anywhere in the research or the document —
I checked it precisely because it wasn't accounted for anywhere, and confirmed it is genuinely empty
(0 URLs), so its omission is not a gap.

### Discrepancies found (four, in the group-level numbers and their descriptions)

**a) Group 1 (home page's) description of the qr pages overstates what's true for one of them.**
The document says the 50 qr addresses "כבר קיימים בכתובת כמעט זהה גם באתר החדש, ואין שם שום דבר
להחליט" (already exist at an almost-identical address on the new site, nothing to decide there). Live
check: 49 of the 50 do exist at the identical path on the new site. The 50th, `/qr/פרק-א/`, returns
**410 Gone** on the new site — it does not exist at "an almost-identical address," it has been
deliberately declared permanently removed. Saying "nothing to decide" is defensible (it was already
decided), but "already exist" is not true for this one out of fifty.

**b) Group 3 (Store)'s own description does not add up to the "14 כתובות" printed on it, and undercounts
two different things inside it.** I fetched `product-sitemap.xml` live: it has 8 URLs (`/shop/` itself,
already counted once via `page-sitemap.xml`, plus 7 distinct product URLs):
`וכתבת`, `כושי-בלאנטיס`, `צבע-בכחול-וזרוק-לים` (3 real books) — then **three**, not two, bundle-shaped
product URLs (`שלושת-הספרים-...` a 3-book bundle, `שני-הספרים-...-צבע-בכחול...` a 2-book bundle, and a
*second, different* `שני-הספרים-...-כושי-בלאנטיס...` 2-book bundle) — plus one duplicate/test product
(`כושי-בלנטיס-העתק`, literally "-copy"). The document's "מה אנחנו מציעים" text says: *"שלוש מהן יובילו
ישירות לעמוד הספר הנכון. שתי הכתובות של מבצעי החבילה (שני ספרים במחיר מיוחד, ושלושה ספרים במחיר מיוחד)
יובילו לעמוד הספרים הכללי"* — three go to the right book page, **two** bundle addresses go to the
general books page. That accounts for 5 of the 7 product URLs. The actual count is **three** bundle-shaped
URLs, not two, and the duplicate/test product isn't mentioned at all. Separately, the same group's "מה
זה" line says "שני עמודי תשלום" (two payment pages) — live `page-sitemap.xml` shows **four** distinct
utility URLs under `/shop/` (`/shop/cart/`, `/shop/checkout/`, `/shop/my-account/`, `/shop/תקנון/`), and
one of those four is a terms page, not a payment page. And the group never mentions the two
`product_cat-sitemap.xml` URLs (`/product-category/sale/`, `/product-category/books/`) that are part of
its own "14" per the research doc's own table. The "14" total is arithmetically defensible once you
reconstruct it from the sources, but the group's own prose describes only about 8 of the 14 items by
name and miscounts two of the categories it does name (2 payment pages → really 4 utility pages; 2
bundles → really 3). This is the highest-stakes group in the whole document (it is the one the owner
himself called "the most serious finding, not a redirect to fix later") and it's the one whose own
numbers don't reconcile.

**c) The same group (Store) folds in an 15th address that isn't in its own "14."** Its last line says:
*"עמוד ארכיון כללי אחד של מערכת ההזמנות הישנה ייפול יחד עם שאר עמודי החנות"* (one general archive page
of the old order system will fall along with the rest of the store pages) — this is
`shop_order-sitemap.xml`'s one URL, which the research doc's own breakdown table lists as a **separate**
line item outside the Store group's 14 (`shop_order archive | 1 | N/A | drop / 410, not a redirect
target`). It is correctly counted once in the overall 251, but it is being narrated as part of "this
group" without the group's header number reflecting a 15th item.

**d) Portfolio (Group 5) and Shows (Group 7) each fold their own listing/archive root page into a count
that's otherwise described as individual content items.** Portfolio's 25 = 24 individual portfolio pages
+ 1 archive root (`/Blog/portfolio_page/`); Shows' 4 = 3 individual shows + 1 archive root
(`/Blog/shows/`). The document's "מה זה" text for both reads as if all of them are individual pieces
("עשרים וחמישה עמודים... תחת הכותרת תיק עבודות"; "ארבע כתובות נוספות מסוג 'מופע'"). This is a minor
precision issue, not a wrong total — flagged because it's the same shape of error as (a)–(c), and Group
8 (Galleries) shows this can be described correctly: it explicitly breaks its "6" into "5 גלריות ואלבום
תמונות אחד," which is exactly right and a good model for how 5 and 7 should read too.

**Everything else — Groups 2, 4, 6, 8, 9, 10, and the two naming decisions — reconciles exactly** against
live counts and the research documents. No further numeric issues found there.

---

## 2 — Is every example real?

All named example URLs resolve live (HTTP 200, verified today with real GETs, quoted `<title>` tags
below). Two are inaccurate in ways worth fixing before this goes to Eyal; the rest are exact matches.

**Confirmed exact matches** (title fetched live today matches the document's example text verbatim):
- Group 2: "צור קשר" → live title "צור קשר - המרכז לטיפול בדיג'רידו..." — exact.
- Group 2: "דיג'רידו – המרכז לטיפול בדיג'רידו – סטודיו נשימה מעגלית – אייל עמית" → live title "דיג'רידו
  - המרכז לטיפול בדיג'רידו - סטודיו נשימה מעגלית - אייל עמית" — exact.
- Group 3: "ספר \"כושי בלאנטיס\"" → live title "כושי בלאנטיס - ..." — exact.
- Group 4: "(18) הטור של אייל עמית: מסך הברזל" and "(41) הטור של אייל עמית: חארטה בארטה" → both exact,
  including the parenthetical numbering.
- Group 5: "Art Week 2014 Malmö", "SuperDollz Showroom", "Der Spiegel Cover Art" → all three exact,
  including the umlaut on "Malmö."

**Found wrong / misattributed / tidied:**

- **Group 2's "תקנון" example does not belong to Group 2's population.** The only page on the old site
  titled "תקנון" is `/shop/תקנון/` — and the research doc's own table places that URL inside the
  **Store** group's 14 (it's one of the five `page-sitemap.xml` URLs under `/shop/`), not inside the 26
  "core Hebrew pages" that Group 2 is illustrating. The title itself is accurate ("תקנון - המרכז
  לטיפול..."), but the example is drawn from the wrong group.

- **Group 4's third example is tidied/truncated, not the real title.** The document shows: *"זמן חלום
  (וידאו בלוג) – השקת הספר 'כושי בלאנטיס'"*. The live page's actual `<title>` is: *"זמן חלום (וידאו
  בלוג) - השקת הספר 'כושי בלאנטיס' גג מסעדת הטאלי 24 רופי | אוגוסט 2004"* — the document drops the venue
  and date ("roof of Hatali restaurant, Rothschild 24 | August 2004") that's actually part of the page's
  real title.

- **Group 7's characterization of two shows as "literally called 'מופע לדוגמה'" describes the URL slug,
  not what the page is actually titled.** I fetched all three live show pages. Their real `<title>`
  tags are **"20.6"**, **"27.6"**, and **"11.7"** — i.e. every one of the three is titled only by a date,
  with no name at all. The phrase "מופע לדוגמה" ("example show") exists only in two of the URL slugs
  (`מופע-לדוגמה-4`, `מופע-לדוגמה-2`), not in what a visitor or Eyal would actually see as the page's
  name. The document's phrasing — "שתיים מהן נקראות... 'מופע לדוגמה'... השלישית מסומנת רק בתאריך" (two
  are literally called "example show"... the third is marked only by a date) — implies the first two
  have a discernible name while only the third is a bare date. In reality **all three** are bare-date
  stubs with no real title; only the URL of two of them happens to say "example show." This understates,
  if anything, how content-empty this group is — worth restating so Eyal isn't left thinking two of the
  three have any actual name.

- **Minor, low-severity:** Group 3's "ספר \"וכתבת\"" drops the diacritic mark present in the real title
  ("וכתבתָּ" — pronounced Vekatavta, matching the new site's own slug `vekatavta`). Cosmetic; not
  worth blocking on its own, but is part of the same group that has the bigger issues above.

No example URL failed to resolve; nothing was found to be outright invented.

---

## 3 — Is it actually clear to a non-developer?

**Developer-token grep of the visible text (style/script blocks excluded): zero hits for every one of
the twelve tokens.** `301`, `302`, `regex`, `.php`, `htaccess`, `sitemap`, `slug`, `canonical`, `404`,
`410`, `HTTP`, `CSS`, `URL` — all zero. This is a genuinely clean pass; nothing here reads like it was
written for a developer.

**One sentence assumes technical knowledge a non-developer client is unlikely to have:** the opening box
asks Eyal: *"יש לך גישה לחשבון Google Search Console של האתר, או לדוח קידום אחר שמישהו הכין לך
פעם?"* ("do you have access to the site's Google Search Console account, or another SEO report someone
once prepared for you?"). "Google Search Console" is a webmaster tool most clients have never heard of
and are unlikely to have credentials for; the sentence doesn't explain what it is or why it would help,
just asks for it by name.

**Minor, lower priority:** Group 9's "מה זה" text says "תוספי וורדפרס ישנים שכבר אינם פעילים" (old
WordPress plugins that are no longer active) — "plugin" is a mildly technical term, though the sentence
immediately re-explains it in plain language right after ("שאריות טכניות... לא תוכן שכתבת" — technical
leftovers, not content you wrote), which softens it. Not blocking on its own.

**Consequences and real choices:** every group states what happens to a visitor who lands on the old
address (directly, or via the "לוותר"/"ייעלמו" options themselves), and every group offers at least one
option that changes the outcome rather than just acknowledging it — no group was found where every
option amounted to "let's talk" (the two naming-decision items each have a "לדבר" option, but each also
has at least one option that commits to an actual answer).

---

## 4 — Does it work?

Tested against the **live** URL
(`http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/eyal-redirects-approval.html`) using
`chrome-headless-shell` at `/Users/nimrod/.cache/puppeteer/chrome-headless-shell/mac_arm-149.0.7827.22/`,
reusing the discovery logic from `qa_probe.mjs` (read only, not modified) inside a purpose-built script
in the scratchpad for the interactive checks that tool doesn't cover.

- **Initial load:** `dir="rtl"`, `lang="he"`, correct title. 12 radio groups / 45 radio inputs total
  (10 content groups + 2 naming decisions) — **0 pre-selected**. 12 real free-text fields, all empty by
  default (the 13th textarea is the hidden, readonly copy-output box). All controls are reachable and
  settable via real clicks/typing.
- **Copy button — actually run, with a genuine trusted click (not a synthetic one):** produces this
  (first entry, full structure preserved for all 12):
  ```
  סיכום תשובות — אישור כתובות ישנות וכתובות חדשות, 26 בספטמבר 2026

  1) 1. עמוד הבית
     תשובה: מאשר — אפשר להמשיך בדיוק כמו שמתואר
     הערה: הערת בדיקה 0
  ...
  12) כתובות באנגלית או בעברית
     תשובה: מאשר — הכתובות נשארות באנגלית
     הערה: הערת בדיקה 11
  ```
  This is a legible, numbered, plain-text summary someone could paste into an email or WhatsApp message
  and act on directly — it passes. One technical note worth recording, not a defect today: this staging
  host is plain HTTP on a non-localhost domain (by design, per the brief), so `navigator.clipboard` is
  genuinely unavailable in Chrome (`isSecureContext: false`) — the button *always* falls through to the
  legacy `document.execCommand('copy')`. With a real trusted click that fallback works correctly (message
  shown: "הועתק ללוח — אפשר להדביק במייל או בוואטסאפ"). It only fails silently under a synthetic,
  script-dispatched click (which is not how Eyal will use it), and only continues to work as long as
  Chrome keeps `execCommand('copy')` around, which is deprecated but currently still functional.
- **Reload persistence:** after filling all 12 groups and reloading, all 12 answers and the sampled note
  text were restored correctly from `localStorage`.
- **390px viewport (RTL, no horizontal overflow):** `scrollWidth === clientWidth` (390 === 390), and a
  full-DOM scan for any element extending past the viewport edge returned **zero** offenders.

No functional defects found.

---

## What must change before this is sent to Eyal, in order of how badly it would mislead him

1. **Fix the Store group's (Group 3) internal counting and description** — the highest-stakes group in
   the document. State plainly that there are **three** bundle-shaped product addresses (not two, since
   there are two different "two-book" bundle variants plus the three-book bundle) and mention the
   duplicate/test product (`כושי-בלנטיס-העתק`) explicitly rather than leaving it unaccounted for. Correct
   "שני עמודי תשלום" to reflect the actual four utility addresses (cart, checkout, my-account, and a
   terms page — not all of which are "payment" pages). Either fold the two `product-category` URLs and
   the order-archive page into the visible count (making it 15) or explain why they're grouped separately.
2. **Fix the Shows group's (Group 7) example description.** State that all three show pages are titled
   only by a date on the live site today ("20.6", "27.6", "11.7") — the phrase "מופע לדוגמה" exists only
   in two of their web addresses, not in any page's actual displayed name. As written, it reads as if two
   of the three have a discernible name and only the third doesn't.
3. **Replace or move the "תקנון" example in Group 2 (core pages)** — it's a real page with an accurate
   title, but it belongs to the Store group's population, not the core-pages group it's currently
   illustrating.
4. **Correct the qr-pages claim in Group 1** so it doesn't say all 50 "already exist at an almost
   identical address" — one of the fifty (`/qr/פרק-א/`) is declared permanently gone (410), not existing.
5. **Restore the dropped venue/date in Group 4's third example** ("...גג מסעדת הטאלי 24 רופי | אוגוסט
   2004") or pick a shorter example that doesn't need truncating.
6. **Rewrite or drop the Google Search Console ask** in the opening box — either explain in one plain
   sentence what it is and how to check for it, or ask a lower-friction question Eyal can actually answer
   (e.g., "do you know if anyone ever set up Google tracking for the site?").
7. **Optional polish, not blocking:** describe Portfolio's 25 and Shows' 4 the way Galleries' 6 is already
   described (call out that one of each is the listing/archive page itself, not an individual item), and
   restore the diacritic in "וכתבתָּ" to match the new site's own spelling.
