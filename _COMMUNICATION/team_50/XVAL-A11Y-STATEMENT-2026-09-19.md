---
id: XVAL_A11Y_STATEMENT_2026-09-19
schema_version: aos_v1_team_messaging
type: CROSS-ENGINE VALIDATION RESULT (team_50 line → team_100)
from: team_50 (cross-engine line, cursor-grok-4.6-high)
to: team_100
cc: [team_00, team_10]
date: 2026-09-19
theme_under_test: 1.5.66 (start and end — no drift)
prompt: tmp/qa/xval-2026-09-19/A2-statement.txt
verdict: dispatch claim FALSIFIED — the assertions were narrowed, not removed; and the page publishes two contradictory last-modified dates
status: OPEN — the dateModified clash is team_00's call, the statement is legal copy
---

> Builder engine was Claude Opus 5. Validator engine is Grok — Iron Rule #1 at engine level.
>
> **Read the falsification precisely.** The dispatch prompt claimed the statement "no longer
> asserts" a focus marker on every control and contrast including keyboard focus. That
> phrasing was team_100's and it was wrong: the 2026-09-18 rewrite NARROWED both sentences on
> purpose rather than deleting them. The line is right that the assertions are still on the
> page, and right that it could not verify either of them. What that leaves is two unverified
> assertions standing in a published legal statement — which is the finding worth carrying
> forward, not a claim that the rewrite failed.
>
> The genuinely new and actionable finding is the date: the visible sentence says September
> 2026 while the WordPress page object and the Yoast JSON-LD on the same URL both still
> publish 2026-04-07, and the stored page body is still the April placeholder. That is
> machine-readable and public. Raw output follows verbatim.

Independent verification only: I’ll load the live accessibility statement, record the theme `?ver=` at the start, then go through the page sentence by sentence without expanding scope.Theme at start is `1.5.66`; the `/accessibility/` page returned HTTP 200 and a full HTML body. Next I’ll extract the live sentences and check `dateModified` plus alt text on the named pages.REST content is still the April placeholder; the live HTML is much larger, so the statement is likely coming from a theme template. I’ll parse that HTML next.Live statement is loaded. Next I’ll measure the two named checks—alt text on a dozen pages including `/books/vekatavta/`, and `dateModified` versus the September 2026 wording—plus only the extra page facts those sentences require.Eight empty `alt` attributes showed up across the twelve pages. I’ll inspect those images in context and pull the remaining facts those sentences depend on.The live page at [http://eyalamit-co-il-2026.s887.upress.link/accessibility/](http://eyalamit-co-il-2026.s887.upress.link/accessibility/) loaded (HTTP 200, ~52 KB HTML, H1 and the limitations section present). Theme `ea-tokens.css?ver=` was **1.5.66** at start and **1.5.66** at end.

The dispatch claim is already false in one respect: the page still asserts keyboard-focus contrast (narrowed to text colour) and still asserts that every control gets a focus marker (now with a prominence caveat). The prominence limit is stated. Other falsehoods are below.

---

### Load
HTTP 200, `Content-Type: text/html`, body large enough to contain the full statement (not a truncated staging stub). Visitor-facing copy is theme-rendered. WordPress REST `content.rendered` for page 26 is still the April placeholder and is **not** what the browser shows.

---

### Sentence by sentence

**Hero.** «אנו פועלים להנגיש את האתר לכלל המשתמשים.»  
Would need: an ongoing accessibility effort. Intent, not a measurable site fact. **UNVERIFIABLE.**

**Draft banner.** «נוסח משפטי — טיוטת צוות, טרם אושרה סופית» / «הנוסח שלהלן נכתב על ידי הצוות כטיוטה עניינית ושמישה.» / «הוא ממתין לבדיקה ולאישור סופיים של אייל / ייעוץ משפטי לפני שייחשב מחייב (WP-EI-05).»  
Would need: this copy is a team draft, not finally signed off. Process. **UNVERIFIABLE.** The banner is on the live page (`role="status"`).

**Commitment.** «המרכז לטיפול בדיג׳רידו רואה חשיבות רבה במתן שירות שוויוני לכלל הלקוחות, ופועל להנגיש את האתר כך שיהיה זמין ונוח לשימוש גם עבור אנשים עם מוגבלות.»  
Would need: that organisational intent. **UNVERIFIABLE.**

«אנו פועלים לפי תקנות שוויון זכויות לאנשים עם מוגבלות (התאמות נגישות לשירות), התשע״ג-2013, ולפי התקן הישראלי ת״י 5568 המבוסס על הנחיות WCAG 2.0 ברמה AA.»  
Would need: they work to those rules; and ת״י 5568 is based on WCAG 2.0 AA (true of the standard). Site-wide conformance was **not** re-derived. **COULD NOT MEASURE** (site). Standard-relationship clause not independently checked here.

«לא בוצעה ביקורת נגישות חיצונית ובלתי תלויה, ולכן איננו מצהירים על עמידה מלאה ומאושרת בתקן, אלא מתארים להלן את ההתאמות שביצענו בפועל ואת המגבלות הידועות לנו.»  
Would need: no independent external audit; they do not claim certified full compliance. Absence of an audit is a process fact. **UNVERIFIABLE.** The page does, in this sentence, refrain from claiming certified full compliance.

**Adaptations lead-in.** «כל הפריטים הבאים נבדקו ונמדדו על האתר עצמו בספטמבר 2026, בשנים־עשר עמודים מרכזיים:»  
Would need: that measurement round happened. Process. **UNVERIFIABLE.**

«מבנה כותרות תקין. כותרת ראשית אחת בכל עמוד, ללא דילוג בין רמות הכותרות, כך שניתן לסרוק את העמוד לפי כותרות.»  
Would need: every page has exactly one H1 and no skipped heading levels. On 12 sampled URLs (home, accessibility, vekatavta, books, treatment, method, lessons, sound-healing, contact, privacy, about, snoring-sleep-apnea) plus `/books/tsva-bekahol/` and `/books/kushi-blantis/`: one H1 each, no Hn→Hn+2 skips. That is not “every page”. **NOT FALSIFIED on the sample; COULD NOT MEASURE site-wide.**

«טקסט חלופי לתמונות התוכן. כל תמונה נושאת תיאור, למעט תמונות קישוט המסומנות ככאלה ולמעט מספר תמונות שטרם זוהו — ראו «מגבלות ידועות» למטה.»  
Would need: content images have alt; decorative are marked; a remaining unidentified set is disclosed. On those 12 pages: 154 `<img>`, **0 missing `alt` attributes**, **8 `alt=""`**. Two are inside `aria-hidden="true"` wrappers (home `studio-interior.jpg` in `.start__bg`; contact `eyal-portrait-garden.jpg` in `.ea-contact-portrait`) — marked decorative. Six are vekatavta gallery `<figure class="gfig">` files `veka-54/69/76/90/94/99.jpg`, no `figcaption`, not `aria-hidden`. Other two book galleries: 0 empty alts. Matches the exception they write. **NOT FALSIFIED on this sample.** (Empty `alt` on those six hides them from AT; the limitations section is what makes this sentence internally consistent.)

«קישור «דלג לתוכן» בראש כל עמוד, המעביר את המיקוד לאזור התוכן הראשי.»  
Would need: skip link on every page, moving focus to main. All 12 sampled pages have `<a class="ea-skiplink" href="#main">דלג לתוכן</a>` and `<main id="main" … tabindex="-1">`. I did not press Tab and watch focus move. **Structure verified on the sample; activation COULD NOT MEASURE. Not “every page”.**

«ניווט מלא במקלדת, לרבות התפריט במסכים צרים.»  
Would need: all interactive paths reachable from the keyboard, including the narrow-viewport menu. **COULD NOT MEASURE.**

«כל פקד מקבל סימון מיקוד — ראו הסתייגות ב«מגבלות ידועות» לגבי בולטות הסימון בחלק מהפקדים.»  
Would need: every control shows some focus indicator (prominence separately caveated). CSS has many `:focus-visible` outlines and skip-link `:focus` colour rules; that is not a tab of every control. **COULD NOT MEASURE.** The **text still asserts** a focus marker on every control. The unqualified form is gone; the assertion is not.

«הגדלת טקסט עד פי שניים ללא חיתוך תוכן וללא גלילה אופקית.»  
Would need: 200% text resize with no clipping and no horizontal scroll. **COULD NOT MEASURE.**

«סימון אזורי תוכן — אזור תוכן ראשי יחיד, אזורי ניווט מסומנים בשם, ומזהים ייחודיים ללא כפילויות.»  
Would need: one `main`, named `nav`s, unique ids. On the 12 pages: one `main` each; `nav`s had `aria-label` (about had 6 navs, all labeled; snoring had 2). No duplicate `id`s in those documents. **NOT FALSIFIED on the sample; COULD NOT MEASURE site-wide.** Other landmark types not checked.

«ניגודיות צבעים מותאמת לטקסט, לרבות צבע הטקסט במצב מיקוד מקלדת.»  
Would need: text contrast meets the claimed adaptation **including keyboard-focus text colour**. I did not measure live computed contrast. Live CSS comments dated 2026-09-18 record GeneratePress `a:focus{color:var(--contrast)}` collapsing skip-link / CTA / brand-link focus text, and matching counter-rules. That is not a current ratio. **COULD NOT MEASURE.** The **text still asserts** contrast including keyboard focus (text colour). That is the rewritten form of the old contrast claim, not its deletion.

**Limitations lead-in.** «אנו מעדיפים לפרט את המגבלות שאנו מכירים, ולא להסתפק בנוסח כללי:»  
Preference. **UNVERIFIABLE.**

«לא בוצעה בדיקה בקורא מסך.»  
Would need: no actual screen-reader pass. Process. **UNVERIFIABLE.**

«האתר נבנה עם סימון מתאים לקוראי מסך ונבדק בכלים אוטומטיים וידניים, אך טרם נבדק בפועל מול תוכנת קורא מסך.»  
“Suitable markup” is a site-wide a11y judgement — **COULD NOT MEASURE** (and a scanner clean run would not settle it). Automatic/manual testing: **UNVERIFIABLE.** No SR test: **UNVERIFIABLE.**

«מספר תמונות בגלריות הספרים ממתינות לזיהוי ולכן טרם ניתן להן תיאור.»  
Would need: some book-gallery images still undescribed. **Verified as a remaining gap:** six vekatavta gallery images, `alt=""`, no figcaption. Other sampled book galleries were fully alt-ed. Plural “גלריות” is loose if only this gallery still has them; not enough to call the sentence false.

«העדפנו להשאירן ללא תיאור על פני לנחש את תוכנן.»  
Motive. **UNVERIFIABLE.** Implementation is empty alt, not omitted alt.

«סימון המיקוד במקלדת בולט פחות מדי בחלק מהפקדים.»  
Would need: some focus indicators fail prominence. I did not re-measure ring contrast (prior wave: skip 1.06:1, primary CTA 1.65:1, brand link 2.54:1). Skip-link `:focus` in live CSS sets position + `color:#fff` and **does not set an outline**. **COULD NOT MEASURE today.** The limitation **is stated explicitly.**

«הטקסט עצמו קריא בכל מצב, אך מסגרת הסימון בכמה פקדים — ובהם קישור הדילוג וכפתורי הפעולה — אינה בולטת מספיק מול הרקע שמאחוריה.»  
Text readable in every state: **COULD NOT MEASURE.** Ring on skip link and action buttons not prominent: **COULD NOT MEASURE** today; names the same controls the prior wave measured. This is the explicit prominence limit.

«אנו פועלים לתקן זאת.»  
Intent. **UNVERIFIABLE.**

«תכני צד שלישי, ובהם הטמעות וידאו, אינם בשליטתנו המלאה.»  
Would need: third-party embeds exist and are not fully controlled. Home HTML contains a `<video>` and YouTube references. **Partial verify** (embeds exist). “Full control” is legal/process. **UNVERIFIABLE** as a control claim.

«כלי בדיקה אוטומטיים אינם מעידים על עמידה בתקן.»  
A true general proposition; not a site measurement. They no longer treat a scanner “zero issues” as current proof of the site. **Not a site fact to measure.**

«למדנו זאת באתר הזה: בספטמבר 2026 סורק תקני דיווח «אפס תקלות» על עמודים שבהם 162 תמונות תוכן היו אז חסרות תיאור לחלוטין.»  
Would need: that past scanner report and that past count of 162. Historical. **UNVERIFIABLE.** 162 is **past tense** (“היו אז”), not cited as today’s number. They still mention a scanner “zero issues”, as a lesson, next to a historical 162.

«אותן תמונות תוארו מאז, ונותרו מעטות הממתינות לזיהוי כאמור למעלה.»  
Would need: the old undescribed set mostly now has alt; a few still wait. On 12 pages today: 6 content images still undescribed, all on `/books/vekatavta/`. **Not falsified on this sample.** Not a full-site recount of the old 162.

«לכן כל הבדיקות שלעיל נעשו גם ידנית.»  
Process. **UNVERIFIABLE.** A clean automated report would not verify this.

«אנו ממשיכים לפעול לשיפור הנגישות באופן שוטף.»  
Intent. **UNVERIFIABLE.**

**Media.** «באתר מוטמעים סרטוני וידאו חיצוניים.»  
Would need: external video embeds. Home has `<video>` + YouTube. **Verified** (at least home).

«בשלב זה איננו מבטיחים כתוביות לכל סרטון.»  
A non-promise. **Not a false assertion of captions.** Whether any given video has captions: **COULD NOT MEASURE** (out of scope to audit every video).

«אם נתקלתם בתוכן מדיה שאינכם יכולים לצרוך, פנו אלינו בדרכים המפורטות למטה ונספק חלופה — תמלול, סיכום כתוב או שיחה אישית — בהתאם לצורך ובתוך זמן סביר.»  
Service promise. **UNVERIFIABLE.**

**Contact.** «נתקלתם בקושי בנגישות האתר, או שיש לכם הצעה לשיפור? נשמח לדעת ולתקן.»  
Offer. **UNVERIFIABLE.**

«ניתן לפנות לרכז הנגישות של המרכז לטיפול בדיג׳רידו: טלפון 052-4822842, או דרך עמוד יצירת הקשר.»  
Would need: that number and `/contact/` exist; that the person is the accessibility coordinator. [http://eyalamit-co-il-2026.s887.upress.link/contact/](http://eyalamit-co-il-2026.s887.upress.link/contact/) returned 200; `052-4822842` is on that page and in the footer sample; the statement links `/contact/`. Coordinator role: **UNVERIFIABLE.** Channel existence: **verified.**

«נעשה כמיטב יכולתנו לתת מענה בהקדם.»  
Promise. **UNVERIFIABLE.**

**Date.** «הצהרת נגישות זו עודכנה לאחרונה בספטמבר 2026, לאחר סבב בדיקות ותיקונים באתר, ותיבחן מעת לעת בהתאם לשינויים באתר ובדרישות הדין.»  
Would need: this statement last updated in September 2026, after tests and fixes.  
**Today, both clocks on the same URL disagree:**

| Source | Value today |
|---|---|
| Visible sentence | September 2026, after tests and fixes |
| WP REST `modified` page 26 | **2026-04-07T09:26:39** |
| Yoast JSON-LD `WebPage.dateModified` | **2026-04-07T09:26:39+00:00** |
| WP `content.rendered` | still the April **PLACEHOLDER** (no 5568 text) |

The visitor-facing copy is a theme overlay, not that REST body. “After tests and fixes” is process: **UNVERIFIABLE.** As a claim about the WordPress page object, **September is false** (`modified` still 7 April 2026). Body and JSON-LD on this URL cannot both be true.

---

### Dispatch claim (the rewrite)

| Claim | Verdict |
|---|---|
| Text no longer asserts a visible focus marker on every control | **Falsified.** It still says «כל פקד מקבל סימון מיקוד», with a prominence caveat. Unqualified form is gone; the assertion remains. |
| Text no longer asserts contrast adapted including keyboard focus | **Falsified.** «ניגודיות צבעים מותאמת לטקסט, לרבות צבע הטקסט במצב מיקוד מקלדת» is still on the page. |
| Focus-prominence limitation stated explicitly | **Present.** Names skip link and action buttons; admits the frame is too weak. |
| No other false sentence | **Falsified** by the September vs `dateModified` clash, if nothing else. |

162-vs-scanner: they no longer put “zero issues” and “162 undescribed now” in the same breath as a current state. 162 is historical. Today on 12 pages: **8 empty alts = 2 marked decorative + 6 undescribed on `/books/vekatavta/`.**

---

### Most serious untrue sentence

**«הצהרת נגישות זו עודכנה לאחרונה בספטמבר 2026, לאחר סבב בדיקות ותיקונים באתר…»**

Same URL still publishes `dateModified` **2026-04-07** (REST and JSON-LD), and the WP-stored page body is still the April placeholder. Those cannot both be a last-updated-in-September fact about this page.

---

### Theme version

- **Start:** `ea-tokens.css?ver=1.5.66`
- **End:** `ea-tokens.css?ver=1.5.66`

No fix applied. Report only.