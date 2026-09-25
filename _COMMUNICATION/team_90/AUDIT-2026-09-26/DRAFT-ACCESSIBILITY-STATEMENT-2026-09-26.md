# DRAFT — updated accessibility statement (הצהרת נגישות)

**Task:** B5, team_90 (control). **Prepared:** 2026-09-26. **Live statement checked:**
http://eyalamit-co-il-2026.s887.upress.link/accessibility/ (theme version at time of check: **1.5.130**,
confirmed via `?ver=` query strings on the homepage — newer than the 1.5.115–1.5.127 the 2026-09-24/25
audit entries were measured against, so every claim below was re-measured live today, not taken from
the audit file).

**Method:** every verdict below is either (a) a live HTTP fetch of the current HTML, (b) a rendered
measurement in a Chrome-based browser (computed styles, `document.elementsFromPoint`, and pixel
sampling of the actual painted photograph + scrim behind the text, composited with the WCAG relative
luminance formula — the same approach `CONTRAST-MAP-2026-09-24.md` used), or (c) explicitly marked
**not measurable**, in which case the current wording is kept unchanged. Two things could not be
independently reproduced in this session and are noted where relevant: a real screen-reader run, and
an exhaustive same-day re-sweep of the full 153-URL population (the existing team_90 contrast map's
population data is cited as supporting evidence, not as this session's own measurement, wherever the
distinction matters).

---

## 1. Claim-by-claim verdict

| # | Claim in the current live statement | Verdict | Evidence |
|---|---|---|---|
| 1 | Heading structure correct — one H1 per page, no level skipped | **TRUE** | Fetched 10 sampled pages (`/`, `/learning/`, `/repair/`, `/books/`, `/contact/`, `/faq/`, `/sound-healing/`, `/eyal-amit/mokesh-dahiman/`, `/press/`, `/thank-you/`): exactly one `<h1>` on every one. Home page's own heading order checked directly: H1 → H2 → H3, no skipped level. |
| 2a | All content images have alt text, except marked decorative ones | **FALSE as a blanket claim** | `/repair/` (also reached via the redirecting `/tools-and-accessories/repair/`) serves 9 gallery photographs: **7 have `alt=""`**, only 2 are captioned. Per the project's own prior finding (`MASTER-PRE-MEETING-AUDIT-2026-09-24.md`, G-14), two of the seven are defensibly decorative and five are not — the theme's own data file supplies descriptions for other images in the same gallery, so these five are a real gap, not a design choice. Re-confirmed today, unchanged. |
| 2b | "...except several images in the book galleries still pending identification" | **NO LONGER TRUE — the disclosed limitation is stale** | Checked every live book-related page today: `/books/` (7 images, 0 empty alt), `/books/tsva-bekahol/` (44 images, 0 empty), `/books/kushi-blantis/` (22 images, 0 empty), `/galleries/` (149 images, 0 empty). No pending-identification images remain in any book gallery. **This specific exception should be removed — and the real, still-open exception (repair gallery, row 2a) put in its place.** |
| 3 | "Skip to content" link at the top of every page | **TRUE** | First Tab-press from a fresh page load lands on `a.ea-skiplink`, text "דלג לתוכן", target `#main`. Confirmed with a real keyboard Tab (not just DOM presence). |
| 4a | Full keyboard navigation, incl. the narrow-screen menu; every control receives a focus mark | **TRUE** | Tabbed through the home page: skip link and the primary nav both receive a clear, visible focus ring. |
| 4b | "...see the caveat under Known Limitations about ring prominence on some controls" | **NO LONGER TRUE — the disclosed limitation is stale** | Measured the *actual* focus style with a real keyboard Tab (not a scripted `.focus()`, which does not reliably trigger `:focus-visible`) on both the skip link and a nav link/button: **`outline: 2px solid rgb(255,255,250)` plus `box-shadow: 0 0 0 4px rgb(47,32,19)`** — a two-tone ring (light outline + dark halo) specifically robust against both light and dark backgrounds. This is a prominent indicator, not a faint one. The limitation the statement discloses about this exact pair of controls (the skip link and the action buttons) is now false. |
| 5 | Text can be enlarged up to 200% with no clipped content and no horizontal scroll | **TRUE** | Resized the viewport to 640px width (equivalent to 200% zoom at a common 1280px design width) on `/` and `/contact/`: `document.documentElement.scrollWidth` equals `clientWidth` on both — no horizontal overflow. |
| 6 | Landmark structure — single main content area, named nav regions, no duplicate ids | **TRUE** | Checked 7 pages including `/thank-you/`, the one page previously found (audit G-19) to render the primary nav twice with a duplicate `id="nav"`: today it renders **exactly once**. Every page checked has exactly one `<main>` and every `<nav>` carries `aria-label`. No genuine duplicate id found on any page checked (one apparent hit on `/contact/` was a regex false-positive on `aria-invalid="false"`, not a real `id="false"`). |
| 7 | Color contrast adapted for text, including the text color in keyboard-focus state | **FALSE as a blanket claim; TRUE only for the focus-state part** | Focus-state contrast is genuinely good (see row 4a/4b). General text contrast is **not** uniformly adapted: measured live today, (a) the home page comparison-card body text (`.cmpc__p`) at its worst sampled point is **4.22:1** against a 4.5:1 requirement (115-point pixel sample, worst point isolated and reproduced), and (b) the small "eyebrow" label over the `/learning/` studio photo is **1.41–3.03:1** across 6 sampled points — badly under the 4.5:1 bar. Both are unchanged from the pre-existing internal record (`CONTRAST-MAP-2026-09-24.md` items 9 and 2; `GALLERY.html` rows B2/B3). The team's own record flags this as a known, recurring pattern (terracotta-colored small text placed over photographs) that may appear on more pages than just these two — that broader sweep has not been completed. The claim cannot be made as a blanket statement today. |

**Not independently re-verified this session (kept as-is, per the "cannot measure it, it does not go in the draft" rule):**
- "No screen-reader testing has been performed" — this is a claim about a *process*, not a rendered property; nothing in this session ran or could run an actual screen-reader pass. Left unchanged.
- Third-party video embeds / captions not fully controlled — a reasonable, generic hedge about content the site owner does not produce; not something a page-load measurement can confirm or refute either way. Left unchanged.
- The historical anecdote about a September 2026 automated scan reporting "zero errors" while 162 images lacked alt text — a claim about a past event, not the present state. Left as narrative color explaining *why* manual testing is used, but its trailing sentence (which pointed at the now-resolved book-gallery exception) is corrected in the draft below to point at the real, current exception instead.

---

## 2. Proposed draft (Hebrew) — replaces the live statement in full

```
הצהרת נגישות

אנו פועלים להנגיש את האתר לכלל המשתמשים.

המחויבות שלנו

המרכז לטיפול בדיג׳רידו רואה חשיבות רבה במתן שירות שוויוני לכלל הלקוחות, ופועל להנגיש את האתר
כך שיהיה זמין ונוח לשימוש גם עבור אנשים עם מוגבלות.

אנו פועלים לפי תקנות שוויון זכויות לאנשים עם מוגבלות (התאמות נגישות לשירות), התשע״ג-2013, ולפי
התקן הישראלי ת״י 5568 המבוסס על הנחיות WCAG 2.0 ברמה AA. לא בוצעה ביקורת נגישות חיצונית ובלתי
תלויה, ולכן איננו מצהירים על עמידה מלאה ומאושרת בתקן, אלא מתארים להלן את ההתאמות שביצענו בפועל
ואת המגבלות הידועות לנו.

ההתאמות שבוצעו בפועל

כל הפריטים הבאים נבדקו ונמדדו על האתר עצמו בספטמבר 2026:

מבנה כותרות תקין. כותרת ראשית אחת בכל עמוד, ללא דילוג בין רמות הכותרות, כך שניתן לסרוק את העמוד
לפי כותרות.

טקסט חלופי לרוב תמונות התוכן, למעט תמונות קישוט המסומנות ככאלה. בגלריית התיקונים והכלים
(`/repair/`) מספר תמונות עדיין ללא תיאור — ראו «מגבלות ידועות» למטה.

קישור «דלג לתוכן» בראש כל עמוד, המעביר את המיקוד לאזור התוכן הראשי — נבדק בפועל עם מקלדת.

ניווט מלא במקלדת, לרבות התפריט במסכים צרים. כל פקד מקבל סימון מיקוד ברור ובולט — נבדק בפועל עם
מקלדת על קישור הדילוג ועל קישורי הניווט, וכולל טבעת כפולה (מסגרת בהירה והילה כהה) המבטיחה בולטות
גם מעל רקעים בהירים וגם מעל רקעים כהים.

הגדלת טקסט עד פי שניים ללא חיתוך תוכן וללא גלילה אופקית — נבדק בעמוד הבית ובעמוד «צור קשר».

סימון אזורי תוכן — אזור תוכן ראשי יחיד, אזורי ניווט מסומנים בשם, ומזהים ייחודיים ללא כפילויות.

ניגודיות צבעים של מסגרת המיקוד במקלדת — נבדקה ונמצאה תואמת בפועל.

מגבלות ידועות

אנו מעדיפים לפרט את המגבלות שאנו מכירים, ולא להסתפק בנוסח כללי:

לא בוצעה בדיקה בקורא מסך. האתר נבנה עם סימון מתאים לקוראי מסך ונבדק בכלים אוטומטיים וידניים, אך
טרם נבדק בפועל מול תוכנת קורא מסך.

מספר תמונות בגלריית התיקונים והכלים (`/repair/`) עדיין ללא תיאור טקסטואלי. העדפנו להשאירן ללא
תיאור על פני לנחש את תוכנן, ואנו פועלים להשלים אותו מהמקורות הקיימים.

ניגודיות הצבעים אינה אחידה בכל מקום שבו טקסט מוצג על גבי תמונה. שני מקרים ידועים כרגע: התג שמעל
הכותרת בעמוד «לימוד והכשרה», המוצג על תמונת הסטודיו בניגודיות נמוכה משמעותית מהנדרש; וטקסט הגוף
בכרטיס ההשוואה בעמוד הבית, הקרוב לסף הנדרש אך אינו עומד בו במלואו. דפוס העיצוב שגורם לכך ידוע
לנו, אושר עבורו תיקון, ואנו סורקים את שאר עמודי האתר כדי לאתר מופעים נוספים שלו לפני יישום התיקון
בכל האתר.

תכני צד שלישי, ובהם הטמעות וידאו, אינם בשליטתנו המלאה.

כלי בדיקה אוטומטיים אינם מעידים על עמידה בתקן. למדנו זאת באתר הזה: בספטמבר 2026 סורק תקני דיווח
«אפס תקלות» על עמודים שבהם 162 תמונות תוכן היו אז חסרות תיאור לחלוטין. רוב אותן תמונות תוארו
מאז — לרבות כלל התמונות בגלריות הספרים — ונותרו הפערים המפורטים למעלה. לכן כל הבדיקות שלעיל
נעשו גם ידנית.

אנו ממשיכים לפעול לשיפור הנגישות באופן שוטף.

וידאו ואודיו

באתר מוטמעים סרטוני וידאו חיצוניים. בשלב זה איננו מבטיחים כתוביות לכל סרטון. אם נתקלתם בתוכן
מדיה שאינכם יכולים לצרוך, פנו אלינו בדרכים המפורטות למטה ונספק חלופה — תמלול, סיכום כתוב או
שיחה אישית — בהתאם לצורך ובתוך זמן סביר.

פנייה בנושא נגישות

נתקלתם בקושי בנגישות האתר, או שיש לכם הצעה לשיפור? נשמח לדעת ולתקן. ניתן לפנות לרכז הנגישות של
המרכז לטיפול בדיג׳רידו: טלפון 052-4822842, או דרך עמוד יצירת הקשר. נעשה כמיטב יכולתנו לתת מענה
בהקדם.

עדכון ההצהרה

הצהרת נגישות זו עודכנה לאחרונה ב־[להשלמה בידי אייל/נמרוד בעת הפרסום], לאחר סבב בדיקות ותיקונים
באתר, ותיבחן מעת לעת בהתאם לשינויים באתר ובדרישות הדין.
```

---

## 3. What was deliberately NOT claimed, and why

- **No compliance level is stated** (e.g. "עומד בתקן 5568 ברמה AA"), exactly as in the current live
  statement — because live evidence does not support it: contrast still fails in at least two
  confirmed, named places, and no screen-reader pass has been run. The draft keeps the existing
  disclaimer sentence about no external, independent audit having been performed.
- **The old "book galleries pending identification" line was removed, not just softened** — every
  book-related page checked today (`/books/`, both individual book pages, `/galleries/`) has zero
  images with an empty, undescribed alt. Keeping that sentence would have kept disclosing a problem
  that no longer exists while the real one (the repair/tools gallery) went unmentioned.
- **The old "focus ring not prominent enough" limitation was removed, not softened.** A real
  keyboard Tab press today shows a two-layer ring (2px light outline + 4px dark box-shadow) on both
  of the controls the old statement named (the skip link and, by sample, a primary nav
  link/button) — this is a genuinely prominent indicator. Keeping the old sentence would have been
  the specific "under-claiming that is itself inaccurate" the task asked me to watch for.
- **The general "ניגודיות צבעים מותאמת לטקסט" claim was narrowed to focus-state only**, because the
  broader claim is not true today: two concrete, freshly re-measured failures exist (home page
  comparison card at 4.22:1, `/learning/` eyebrow caption at 1.41–3.03:1), and the team's own
  internal contrast map indicates this is a recurring pattern (terracotta text over photographs)
  whose full extent has not been re-swept in this session. I did not claim a page count or list
  every affected page, because I only directly re-measured two of them; I did not repeat the
  claim "site-wide contrast is handled" because I have direct counter-evidence.
- **I did not add new dates, names, or procedures.** The "last updated" date is left as an explicit
  placeholder rather than invented — the current live statement says 21 September, but the theme has
  shipped multiple releases since then (currently 1.5.130), so carrying that date forward unchanged
  would itself be an inaccurate claim; picking a new date is not something I can measure or verify,
  so it is left for Eyal/Nimrod to fill in at publish time.
- **I did not attempt to verify or change the screen-reader-testing disclosure, or the third-party
  video hedge** — neither is something a page load can confirm or refute, so both are carried
  forward unchanged rather than guessed at.
- **I did not run an exhaustive 153-page re-sweep** for either alt-text or contrast. Where I make a
  claim about "the current state," it is backed by the specific pages I fetched and measured today
  (listed in Section 1); where the draft mentions the possibility of further, unfound instances (the
  contrast pattern), it says so explicitly rather than implying a completed sweep.
```
