# DRAFT — updated accessibility statement (הצהרת נגישות)

**Task:** B5, team_90 (control). **Prepared:** 2026-09-26 (this pass supersedes an earlier draft
prepared the same day against theme **1.5.130** — that draft is fully re-verified below, not trusted).
**Live statement checked:** http://eyalamit-co-il-2026.s887.upress.link/accessibility/

**Theme version confirmed live today: `1.5.138`** — read from the `?ver=` query strings on the
homepage HTML (`ver=1.5.138` on every theme asset; `ver=2.3.5` / `ver=3.6.1` are plugin/library
assets, not the theme). This is newer than the 1.5.130 the previous draft was written against, and
the task brief said several disclosed items have been fixed since then — every claim below was
re-measured against **this** version, live, today.

**Method:** a rendered Chromium session (chrome-headless-shell, driven headlessly) for every visual
claim — page loaded, settled, scrolled step-by-step to trigger reveal animations, the native
`#ea-cookie-notice` dialog dismissed, two animation frames awaited, **then** measured. Contrast was
computed by screenshotting the settled viewport and sampling actual painted pixels (not computed
CSS colors, which mean nothing over a photograph): glyph pixels were matched against the element's
own computed text color to find its true rendered color (excluding anti-aliased edge blends), then
background pixels were sampled from a padded zone with every glyph rect *dilated* by 2px to strip
the anti-aliasing halo — the 5th-percentile-worst background pixel is reported as "worst," the
median as "typical." Ratios below use the applicable WCAG threshold: 3:1 for large text (≥24px, or
≥18.66px bold), 4.5:1 otherwise. Focus indicators were measured with real `Tab` keypresses (not
scripted `.focus()`, which does not reliably trigger `:focus-visible`), including tabbing all the
way to a rebuilt CTA band's own button (57 real tab-stops on the home page). Landmark/duplicate-id
checks were both a live HTTP fetch and a rendered-DOM check. **One self-caught error:** a first
measurement pass wrote every page's screenshots to a filename keyed only by an in-page probe index
(`probe-0.png`, `probe-1.png`, …), so later pages silently overwrote earlier ones and several
contrast readings were compared against the wrong page's screenshot. This was caught before any
number below was used (visually confirmed a "probe-0.png" showed `/blog/` content when it was
supposed to be `/repair/`), the script was fixed to key filenames by page+probe, and the full sweep
was re-run. Every number in this document comes from that corrected, re-run pass.

**Pages measured today:** `/`, `/learning/`, `/learning/lectures/`, `/learning/therapist-training/`,
`/learning/workshops/`, `/sound-healing/`, `/treatment/`, `/faq/`, `/eyal-amit/`,
`/eyal-amit/mokesh-dahiman/`, `/method/`, `/snoring-sleep-apnea/`, `/repair/`, `/testimonials/`,
`/lessons/`, `/books/`, `/books/tsva-bekahol/`, `/books/kushi-blantis/`, `/books/vekatavta/`,
`/didgeridoos/`, `/bags/`, `/stand-floor/`, `/stands-storage/`, `/contact/`, `/galleries/`,
`/blog/`, `/thank-you/`, `/terms/` — 28 pages, not the full 157-URL population. Where a claim can
only be backed by these pages, the table says so; it is not claimed as a site-wide census.

---

## 1. Claim-by-claim verdict (re-measured today, theme 1.5.138)

| # | Claim in the current live statement | Verdict | Evidence |
|---|---|---|---|
| 1 | Heading structure correct — one H1 per page, no level skipped | **TRUE** | Fetched 9 pages incl. `/`, `/learning/`, `/repair/`, `/books/vekatavta/`, `/galleries/`, `/thank-you/`, `/terms/`, `/accessibility/`: exactly one `<h1>` on every one. Full heading-level sequence checked on `/` (24 headings) and `/learning/` (6 headings): every step goes 1→2 or 2→3, never skips a level. |
| 2a | All content images have alt text, except marked decorative ones | **FALSE as a blanket claim — and the gap is wider than the previous draft found** | `/repair/`: 9 images, **7 with `alt=""`** — unchanged from the earlier pass. **New this pass:** `/books/vekatavta/` (96 images) has **6 with `alt=""`** (`veka-54.jpg, veka-69.jpg, veka-76.jpg, veka-90.jpg, veka-94.jpg, veka-99.jpg`) — a real content gallery, same markup pattern as its captioned neighbours, not a decorative marker. This page was not in the earlier draft's checked list (only `/books/`, `/books/tsva-bekahol/`, `/books/kushi-blantis/` and `/galleries/` were checked — all still 0 empty). 8 further pages spot-checked today (`/didgeridoos/`, `/bags/`, `/stand-floor/`, `/stands-storage/`, `/lessons/`, `/snoring-sleep-apnea/`, `/eyal-amit/`, `/testimonials/`) show 0 empty alt. |
| 2b | "...except several images in the book galleries still pending identification" | **Was stale in the previous draft; today it is TRUE again, differently scoped** | The previous draft (correctly, for what it checked) removed this sentence because the 3 book pages + galleries it sampled were all fully described. Today's wider check found `/books/vekatavta/` **does** have real, undescribed images — so a "pending" disclosure belongs back in the statement, scoped to the repair gallery and this one book gallery specifically, not to "book galleries" in general (the other three are clean). |
| 3 | "Skip to content" link at the top of every page | **TRUE** | Real keyboard Tab from a fresh load: first stop is `a.ea-skiplink`, text "דלג לתוכן", target `#main`. Confirmed on `/`, `/learning/`, `/faq/`, `/contact/`. |
| 4a | Full keyboard navigation, incl. the narrow-screen menu; every control receives a focus mark | **TRUE** | Tabbed through 4 pages; every stop (skip link, nav home, nav dropdown triggers, nav links) received a visible focus mark. |
| 4b | "...see the caveat under Known Limitations about ring prominence on some controls" | **STILL FALSE — the disclosed limitation is stale, and this was re-checked against the rebuilt footer/nav/CTA bands specifically** | Real keyboard Tab, not scripted focus: every stop measured **`outline: 2px solid rgb(255,255,250)`** plus **`box-shadow: 0 0 0 4px rgb(47,32,19)`** — a two-tone ring, light outline + dark halo. Checked on the skip link, nav links/dropdowns on 4 pages, **and** — because the CTA bands were rebuilt since the last check — tabbed 57 real keystrokes into the home page to reach the rebuilt CTA band's own action button (`לתיאום שיחת היכרות`): **same two-tone ring, no degradation.** The limitation the statement names is false today. |
| 5 | Text can be enlarged up to 200% with no clipped content and no horizontal scroll | **TRUE** | 640px viewport (≈200% zoom at a 1280px design width) on 6 pages: `/`, `/contact/`, `/learning/`, `/faq/`, `/books/vekatavta/`, `/repair/`. `scrollWidth === clientWidth` on all six — no horizontal overflow. |
| 6 | Landmark structure — single main content area, named nav regions, no duplicate ids | **TRUE — re-verified against the rebuilt footer/nav/CTA bands** | `/`, `/learning/`, `/faq/`, `/contact/` (rendered DOM) and `/thank-you/` (static fetch, the page previously found with a duplicate `nav#nav`): every page has exactly one `<main>`, exactly one `<footer>`, every `<nav>` carries a non-empty `aria-label` (2–4 navs per page: main menu, breadcrumb, FAQ topic nav where present, footer nav), zero duplicate non-empty ids. The rebuilt CTA band (`.cta-band`) is a 3-column CSS grid (`grid-template-columns: 357.328px 357.328px 357.344px` — logo / text / action) and does not disturb any of this. |
| 7 | Color contrast adapted for text, including the text color in keyboard-focus state | **FALSE as a blanket claim; TRUE for the focus-state part; the general picture has changed completely since the last draft, not just improved** | Focus-state contrast: see row 4b, genuinely good everywhere checked. General text-over-photo contrast, measured live today (worst 5th-percentile pixel vs. the applicable WCAG threshold): **the two specific failures the previous draft/task brief tracked no longer fail** — the `/learning/` eyebrow label now measures **7.09:1 worst / 8.33:1 median** (needs 4.5) and the home comparison-card body text now measures **5.42:1 and 6.13:1 worst** on its two instances (needs 4.5, a real but modest margin, consistent with the improvement the task brief described). **But the same eyebrow label fails on other photographs**: `/sound-healing/` **3.80:1** and `/contact/` **3.96:1** (both need 4.5, both fail), and `/learning/therapist-training/` **4.42:1** (fails by a hair). It passes clearly on `/blog/` (6.21:1). All hero headings (`.phero__h`, needs only 3:1 as large text) and all lead paragraphs (`.phero__s`/`.hero__s`, needs 4.5:1) checked today pass, worst cases 3.88:1 and 4.67:1 respectively. **Net effect: the same CSS color fix helps a lot and is not uniformly sufficient — it depends on the specific photograph under the label, and at least two pages still fail outright.** |

**Not independently re-verified this session (kept as-is):**
- "No screen-reader testing has been performed" — a claim about a *process*; nothing in this session ran an actual screen-reader pass. Left unchanged.
- Third-party video embeds / captions not fully controlled — a generic hedge about content the site owner does not produce. Left unchanged.
- The historical September-2026 "zero errors, 162 missing alts" anecdote — a claim about a past event, not present state. Kept as narrative color explaining why manual testing is used, but its trailing sentence is corrected below (see §3) because it can no longer claim *every* book-gallery image got described.

---

## 2. Final Hebrew text — ready to paste

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
(`/repair/`) ובאחת מגלריות הספרים מספר תמונות עדיין ללא תיאור — ראו «מגבלות ידועות» למטה.

קישור «דלג לתוכן» בראש כל עמוד, המעביר את המיקוד לאזור התוכן הראשי — נבדק בפועל עם מקלדת.

ניווט מלא במקלדת, לרבות התפריט במסכים צרים. כל פקד מקבל סימון מיקוד ברור ובולט — נבדק בפועל עם
מקלדת על קישור הדילוג, על קישורי הניווט ועל כפתורי הקריאה לפעולה, וכולל טבעת כפולה (מסגרת בהירה
והילה כהה) המבטיחה בולטות גם מעל רקעים בהירים וגם מעל רקעים כהים.

הגדלת טקסט עד פי שניים ללא חיתוך תוכן וללא גלילה אופקית — נבדק במספר עמודים מייצגים באתר.

סימון אזורי תוכן — אזור תוכן ראשי יחיד, אזורי ניווט מסומנים בשם, ומזהים ייחודיים ללא כפילויות.

ניגודיות צבעים של מסגרת המיקוד במקלדת — נבדקה ונמצאה תואמת בפועל, לרבות בכפתורי הקריאה לפעולה.

מגבלות ידועות

אנו מעדיפים לפרט את המגבלות שאנו מכירים, ולא להסתפק בנוסח כללי:

לא בוצעה בדיקה בקורא מסך. האתר נבנה עם סימון מתאים לקוראי מסך ונבדק בכלים אוטומטיים וידניים, אך
טרם נבדק בפועל מול תוכנת קורא מסך.

מספר תמונות בגלריית התיקונים והכלים (`/repair/`) ובגלריית «וכתבת» (`/books/vekatavta/`) עדיין ללא
תיאור טקסטואלי. העדפנו להשאירן ללא תיאור על פני לנחש את תוכנן, ואנו פועלים להשלים אותו מהמקורות
הקיימים.

ניגודיות הצבעים של טקסט המוצג על גבי תמונה אינה אחידה בכל מקום. התג הקטן שמעל כותרות מסוימות
(«אייקברואו») עומד היטב בדרישה מעל חלק מהתמונות, אך עדיין נמדד מתחת לסף הנדרש מעל תמונות אחרות —
בהן עמודי «סאונד הילינג» ו«צור קשר». אנו מודעים לכך שהתיקון שהוחל אינו מספיק על כל תמונה, וממשיכים
לעבוד על פתרון שאינו תלוי בתמונת הרקע הספציפית.

תכני צד שלישי, ובהם הטמעות וידאו, אינם בשליטתנו המלאה.

כלי בדיקה אוטומטיים אינם מעידים על עמידה בתקן. למדנו זאת באתר הזה: בספטמבר 2026 סורק תקני דיווח
«אפס תקלות» על עמודים שבהם 162 תמונות תוכן היו אז חסרות תיאור לחלוטין. רוב אותן תמונות תוארו
מאז, ונותרו הפערים המפורטים למעלה. לכן כל הבדיקות שלעיל נעשו גם ידנית.

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
  statement — because live evidence does not support it: contrast still measurably fails on at least
  two named pages, and no screen-reader pass has ever been run. The existing disclaimer about no
  external independent audit is kept.
- **I did not claim the eyebrow-contrast issue is fixed everywhere**, even though the two specific
  instances the task brief pointed at (`/learning/` eyebrow, home comparison card) both now measure
  comfortably above 4.5:1. A broader re-sweep across 23 pages found the *same* CSS rule still failing
  on two other pages and marginal on a third. Claiming "fixed" would have been the exact
  over-claiming the task warned against; the statement instead names the pages where it still fails.
- **I did not claim the home comparison-card margin is large.** It passed today at 5.42:1 and 6.13:1
  (worst-pixel), which is a real, positive change from the previously-reported 4.22:1 — but it is not
  a wide margin, so the Hebrew text does not say the site's contrast is "handled," only that this
  specific element now clears the bar.
- **I did not repeat "לרבות כלל התמונות בגלריות הספרים" (including all book-gallery images) in the
  automated-tools paragraph**, because `/books/vekatavta/` still has 6 undescribed images — that
  specific over-claim, inherited from the live statement's own wording, is corrected to "most,"
  matching what is actually true today.
- **I did not add new dates, names, phone numbers, or procedures.** All contact details are copied
  verbatim from the live statement. The "last updated" date is left as an explicit placeholder — the
  live statement currently says 21 September, but the theme has shipped multiple releases since
  (1.5.130 → 1.5.138 just between this morning's draft and this one), so carrying that date forward
  unchanged would itself be a false claim, and picking a new one is not something a measurement can
  verify — that is Eyal/Nimrod's call at publish time.
- **I did not touch the screen-reader-testing disclosure or the third-party video hedge** — neither
  is something a page load can confirm or refute.
- **I did not run an exhaustive 157-page census.** 28 pages were measured today (listed in the method
  section). Every claim above is scoped to what was actually checked; where a broader pattern is
  plausible but unconfirmed (e.g. whether other book galleries besides vekatavta, or other photo
  heroes besides the three named, have the same issues), the Hebrew text names the specific pages
  found, not a general assertion.
- **I did not add a line about `/terms/`.** It is now linked from the site-wide footer (confirmed
  live, 200 OK) where it was not before — a genuine improvement — but the accessibility statement
  never made a claim about reaching legal documents, so there is nothing in the existing text to
  correct.

---

## 4. Open questions for the owner

1. **Compliance level.** The statement still cannot say "עומד בתקן ת״י 5568 ברמה AA" or similar —
   live measurement today found a real, outstanding contrast failure (the eyebrow label over two
   named photographs) and no screen-reader pass has ever been run. Eyal/Nimrod should decide whether
   to (a) publish as-is with the honest limitations list, (b) fix the two failing pages first, or
   (c) commission the screen-reader pass before making any compliance claim.
2. **"Last updated" date** — left as `[להשלמה בידי אייל/נמרוד בעת הפרסום]`. Needs a real date at
   publish time; not something this session can supply.
3. Whether to name the two still-failing pages explicitly in the public statement (as drafted above)
   or use vaguer language — naming them is more honest and matches the task's "disclose what is
   still true, without drama" instruction, but it is a judgment call the owner may want to weigh in
   on before publishing.
