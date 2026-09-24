# R3 — AA validation, functional facet (Team 50)

**From:** team_50 (functional-facet validator, Claude Opus — cross-engine vs. team_110 / Cursor Grok)
**To:** team_00, cc team_110, team_90
**Date:** 2026-09-24
**Target:** `http://eyalamit-co-il-2026.s887.upress.link` — theme **1.5.115** confirmed live
(`ea-tokens.css?ver=1.5.115` read off the rendered DOM, not off the repo)
**Scope:** the four areas team_110 declined to sign in `_COMMUNICATION/team_50/R3-AA-SIGNOFF-REQUEST-2026-09-24.md`
— keyboard, screen-reader semantics, contrast, and the published accessibility statement — plus the
three open items handed over.

---

## 1. Verdict

**SIGN-OFF: WITHHELD**

8 gaps are proven by live measurement. Two of them (G1, G2) are visible to anyone who opens the site
in the meeting without knowing anything about accessibility.

Nothing here is a reason to panic: the keyboard layer, the landmark/heading layer and the mobile
drawer are genuinely in good shape and I have the measurements to say so (§4). The failures are
concentrated in two places — one dead button, and one colour decision repeated across a page family.

---

## 2. Gaps that must be fixed before the meeting

Ordered by how fast Eyal or Nimrod would hit them in the room.

### G1 — The contact page's main WhatsApp button does nothing

* **URL:** `http://eyalamit-co-il-2026.s887.upress.link/contact/`
* **What breaks:** the hero's primary CTA, labelled **"דברו איתי בוואטסאפ"**, is
  `<a class="btn btn--gw" href="#contact">`. There is no element with `id="contact"` anywhere on that
  page. Clicking it neither opens WhatsApp nor scrolls anywhere.
* **Measurement:** rendered box `[x1075 y304 w197 h56]`, `document.elementFromPoint` at its centre
  returns the anchor itself (so it is hit-testable and a visitor *will* click it); a scan of every
  in-page anchor on the page found exactly one broken target — this one. Source confirms it:
  `inc/chapters/defaults/contact-defaults.php` line 22, `'cta_url' => '#contact'`. The only
  `id="contact"` in the theme lives in `inc/wave2-w2-08.php` (an English Wave2 template that this
  page does not use).
* **Extra sting:** the same page already carries a *working* link with the *identical* label
  "דברו איתי בוואטסאפ" pointing at `https://wa.me/972524822842?text=…`. Two controls, same
  accessible name, different behaviour — one of them dead.
* **Smallest correction (described, not applied):** in `contact-defaults.php`, replace the
  `'cta_url'` value with the same `wa.me` URL the working pill already uses. One line. No CSS, no
  template change.

### G2 — Hero breadcrumb and eyebrow fail contrast on 17 of the 34 pages measured

* **URLs:** every Chapters page whose hero photo has a light region. Worst cases:
  `/sound-healing/`, `/galleries/`, `/faq/`, `/learning/workshops/`, `/books/`, `/repair/`,
  `/accessibility/`, `/terms/`, `/privacy/`, `/learning/`, `/learning/lectures/`, `/contact/`,
  `/en/`, `/eyal-amit/mokesh-dahiman/`, `/books/vekatavta/`, `/books/kushi-blantis/`,
  `/books/tsva-bekahol/`.
* **What breaks:** `.ea-crumb__link` (terracotta `rgb(208,138,94)`, 15.3px, weight 300) and `.chap`
  (same terracotta, 11.05px, weight 500) are painted directly onto the hero photograph with no scrim
  behind that line. Over pale foliage, pale wood or a sunlit wall they fall far under 4.5:1.
* **Measurement method** (this matters — the naive version of this test produces garbage on this
  site): each text run's own glyphs were set to `color: transparent`, the viewport was then captured
  through CDP and the *pure backdrop* pixels under the run were read back through a canvas, and the
  CSS colour was composited against the worst backdrop colour occupying ≥5% of the run's box. The
  threshold was derived per element from its own rendered size and weight, not applied globally.
* **Worst measured ratios (required 4.5:1):**

  | Page | Element | Text | Ratio |
  |---|---|---|---|
  | `/sound-healing/` | `.chap` | סאונד הילינג | **1.03** |
  | `/sound-healing/` | `.ea-crumb__link` | בית | **1.18** |
  | `/galleries/` | `.chap` | גלריות | **1.61** |
  | `/faq/` | `.ea-crumb__link` | בית | **1.64** |
  | `/learning/workshops/` | `.ea-crumb__link` | בית | **1.70** |
  | `/books/` | `.ea-crumb__link` | בית | **2.27** |
  | `/en/` | `.chap` | cbDIDG Method - Eyal Amit | **2.37** |
  | `/repair/` | `.ea-crumb__link` | כלים ואביזרים | **2.44** |
  | `/accessibility/` | `.chap` | משפטי | **2.60** |
  | `/contact/` | `.chap` | צור קשר | **3.04** |

  33 failing runs in total across the 34 pages; a full list is in §7. Confirmed by eye as well as by
  number — a 5× crop of `/sound-healing/` shows the terracotta eyebrow essentially dissolving into
  the foliage.
* **Two neighbours of the same root cause, same fix:**
  * `/lessons/` — `.phero__h` (white, 44.2px, large-text threshold **3:1**) measures **2.66** over a
    near-white patch of the hero photo.
  * `/sound-healing/` — `.phero__s` (white 0.86, 19.55px) measures **4.12** against 4.5.
* **Smallest correction:** the `.phero` hero already carries a dark gradient scrim lower down, which
  is exactly why the 44.2px H1 clears 10–19:1 on most pages. Extend that same existing scrim upward
  to cover the eyebrow + breadcrumb row (or put the crumb row on a short dark gradient band of its
  own). No token change, no colour change, no typography change — the terracotta and the 15.3px rung
  both stay. **Do not** fix this by darkening the terracotta: that is a token, and the type/colour
  canon owns it.
* **Not affected:** all 3 QR pages sampled pass (no photo hero). `/treatment/` and `/eyal-amit/`
  pass (dark hero photos).

### G3 — The breadcrumb on `/press/` is dark brown on dark brown, 1.12:1

* **URL:** `http://eyalamit-co-il-2026.s887.upress.link/press/`
* **What breaks:** `.ea-crumb__link` / `.ea-crumb__current` render `rgb(47,32,19)` on a solid
  `rgb(46,43,40)` hero. Not "low contrast" — invisible. The words "בית / עיתונות" are on the page and
  cannot be read.
* **Measurement:** **1.12:1** required 4.5:1, agreed by three independent methods: computed-style
  ancestor walk, glyph-masked pixel sampling (the backdrop pixel occupies 80–100% of the text box, so
  there is no ambiguity here at all), and a plain screenshot.
* **Why it is separate from G2:** `/press/` is the Wave2/GeneratePress family, not Chapters. It is the
  only page in the 34 where the crumb inherits a *dark* text colour, and it happens to sit on a dark
  hero. The G2 scrim fix will not touch it.
* **Smallest correction:** give the `.ea-crumb` inside the Wave2 editorial hero (`.ea-edhero`) the
  same on-dark colours the rest of that hero already uses successfully — its sibling
  `.ea-edhero__kicker` renders `rgb(216,199,181)` on the same background at **8.55:1**. Scope the
  override to the Wave2 hero so no Chapters page is touched.

### G4 — `/repair/` publishes content photographs with an empty `alt`, outside the exception the statement discloses

* **URL:** `http://eyalamit-co-il-2026.s887.upress.link/repair/`
* **Team 90's figure, independently verified:** 9 `<img>` elements render on the page; **7 carry
  `alt=""`**; **0** of them sit inside `aria-hidden="true"`.
* **Decorative or meaningful — settled from the page's own content and its own source:** the four-up
  gallery at the bottom holds four photographs of the same kind, and the theme's own data file
  `inc/chapters/defaults/repair-defaults.php` gives **two of them full descriptive Hebrew alt text**
  ("תיקון וחידוש דיג'רידו ישנים…", "סדנת בנייה עצמית…") and the other two `'alt' => ''`. The team
  itself classifies this class of image as content. An incomplete pass, not a decorative decision.
  The same applies to the floated photo in the opening prose and the two `split` photos that
  illustrate "מתי דיג'רידו צריך תיקון?" and "איך נראה תהליך התיקון?".
* **Verdict per image:**
  * **Meaningful, empty alt = GAP (5 images):** `EA-000298.jpg` (prose float), `EA-000214.jpeg` and
    `EA-000238.jpeg` (the two `split` illustrations), `EA-000268.jpeg` and `EA-000161.jpg` (the two
    undescribed gallery items).
  * **Defensible as decorative (2 images):** `EA-000239.jpeg` (the `phero` hero backdrop, whose
    meaning the H1 already carries) and `EA-000220.jpeg` (the full-width `photo-band`).
* **Why it is a statement problem, not only an alt problem:** `/accessibility/` states the alt-text
  exception as *"מספר תמונות **בגלריות הספרים** ממתינות לזיהוי"*. `/repair/` is not a book gallery,
  so these five sit outside the published exception. Either fix the alt or widen the disclosure — the
  two must agree.
* **Smallest correction:** add Hebrew `alt` strings for the five in `repair-defaults.php` (the file
  already carries `'literal_alt' => true` on each, so the values pass through verbatim). If team_00
  prefers to leave the hero and the photo band decorative, that is fine and needs no change —
  `alt=""` is the correct marking for those two.

### G5 — The hero sound toggle fails "Label in Name" (WCAG 2.5.3, level **A**)

* **URL:** `http://eyalamit-co-il-2026.s887.upress.link/` (home hero)
* **What breaks:** `button.hero__sound` renders the visible word **"שמע"** as a real text node
  (12.24px, `rgba(255,255,255,0.92)`), while its accessible name is
  `aria-label="הפעלת קול בסרטון"` — which does not contain the visible label. A voice-control user
  saying "שמע" cannot activate it.
* **Measurement:** a Label-in-Name sweep over every visible `a[href]`, `button` and `[role=button]`
  carrying an `aria-label`, across `/`, `/contact/`, `/treatment/`, `/press/`, `/en/`, `/repair/`,
  after stripping `aria-hidden` descendants: **exactly one mismatch on the whole sample**, this one.
* **Smallest correction:** make the accessible name start with the visible word —
  `aria-label="שמע — הפעלת קול בסרטון"`. One attribute. The `aria-pressed` behaviour is already
  correct and must not be touched.

### G6 — Three of the five desktop dropdown triggers announce nothing to a screen reader

* **URL:** every page (the main menu).
* **What breaks:** the five `.nav__dd` triggers are inconsistent.
  * `<button class="nav__dd">` — "לימוד והכשרה", "אייל עמית" — carry `aria-haspopup="true"` and a
    live `aria-expanded` that I watched flip **false → true** under real keyboard focus. Correct.
  * `<a class="nav__dd">` — "טיפול בדיג׳רידו", "כלים ואביזרים", "ספרים" — carry
    `aria-expanded = null` and `aria-haspopup = null`, yet their `.nav__sub` panel *does* open
    (`visibility: visible`, `opacity: 1`, measured live under real Tab focus) and its links *are*
    reachable. A screen-reader user is given no indication that a submenu exists or that it just
    opened. **12 submenu links** sit behind the three silent triggers.
* **Measurement:** `.nav__dd` attribute snapshot on `/` plus a real CDP Tab walk with a settle delay
  — focus sequence stop 3 → 4 → 5 enters the submenu, and at stop 9 the `<button>` variant reads
  `aria-expanded="true"` while all three `<a>` variants read `null`.
* **Smallest correction:** add `aria-haspopup="true"` and an `aria-expanded` that the existing
  focus/hover handler already knows how to flip, to the three `<a class="nav__dd">` triggers — i.e.
  give them the attribute wiring the two `<button>` triggers already have. Keyboard behaviour is
  already correct and must not be re-engineered.

### G7 — The sign-off request's "44px minimum rows in the mobile drawer" claim is not true of the drawer footer

* **URL:** home page at 390×844, drawer open.
* **What breaks:** the claim, not the standard. The drawer's main rows measure **50px** and its
  sublinks **46px** — both above 44, as claimed. But the drawer's own footer link row measures
  **19px tall**: "שאלות נפוצות" 66×19, "גלריות" 31×19, "המלצות" 37×19, "מדיניות פרטיות" 72×19,
  "הצהרת נגישות" 70×19, "תקנון" 25×19.
* **Honest framing, so nobody over-reacts:** this is **not** a ת״י 5568 failure. 5568 follows
  WCAG 2.0, which has no minimum-target-size criterion at AA; and even under WCAG 2.2 SC 2.5.8 these
  links pass, because the spacing exception is met (nearest centre-to-centre distance measured 27px
  vertically and 73px horizontally, both over the 24px circle). The gap is that a sentence team_110
  asked me to validate is measurably false as written, and if it is quoted in the meeting it will be
  wrong.
* **Smallest correction:** either restate the claim as "the drawer's navigation rows are ≥44px; the
  secondary footer links are 19px and rely on the WCAG 2.2 spacing exception", or give
  `.ea-nd__foot a` a `min-height: 24px` with padding. The first is free.

### G8 — The published accessibility statement understates the site in one place and overstates it in two

* **URL:** `http://eyalamit-co-il-2026.s887.upress.link/accessibility/`
* **Overstates (already covered above, listed here so the statement is auditable as one item):**
  1. *"ניגודיות צבעים מותאמת לטקסט"* — contradicted by G2 and G3.
  2. *"כל תמונה נושאת תיאור, למעט תמונות קישוט … ולמעט מספר תמונות **בגלריות הספרים**"* —
     contradicted by G4, which is not a book gallery.
* **Understates (fix it, because being *worse* than your own statement is the only dangerous
  direction, and being *better* than it is still a thing to correct before someone reads it aloud):**
  * *"סימון המיקוד במקלדת בולט פחות מדי בחלק מהפקדים … ובהם קישור הדילוג וכפתורי הפעולה"* — this
    limitation is **stale at 1.5.115**. Every one of the 145 focus stops I recorded carries a dual
    ring: a 2px solid outline at 3px offset **plus** a 4px `rgb(47,32,19)` box-shadow. On the skip
    link specifically — the control the statement names — the ring renders white on the dark header
    and is, on a 6× crop, the most prominent thing on the screen; its own label contrast measures
    5.69:1. The CF7 submit button, the other control the statement names, renders
    `2px solid rgb(164,78,43)` + the same dark 4px shadow, which clears 3:1 against the light page.
* **Smallest correction:** three sentence edits on one page. No code.

---

## 3. Doubts — what I could not settle, and what would settle it

* **D1 — Contact Form 7 error announcement and per-field error association.** The form carries a
  `role="status" aria-live="polite"` region and a `.wpcf7-response-output` with `aria-hidden="true"`,
  and every field has `aria-invalid="false"` at rest. Whether an invalid submission actually moves
  focus, sets `aria-invalid="true"`, wires `aria-describedby` to the `.wpcf7-not-valid-tip`, and
  announces the summary — **I did not test, because testing it means submitting the form**, which I
  am not permitted to do. *What would settle it:* team_00 submits the live form once with an
  invalid email and a screen reader (or one deliberate dummy submission that team_110 then reads the
  DOM of). This is the single largest untested surface in the whole sign-off.
* **D2 — Actual screen-reader behaviour.** Everything in §4 under "semantics" is measured from the
  rendered accessibility properties, not from NVDA/VoiceOver output. The statement itself discloses
  this ("לא בוצעה בדיקה בקורא מסך") and that disclosure is accurate. *What would settle it:* one
  VoiceOver pass over `/`, `/contact/` and the mobile drawer.
* **D3 — iOS field zoom.** I can report the fact and not the consequence. **Fact:** every CF7 field
  renders at **13.6px** (`--fs-xs`, `0.85rem`) — measured live on `/contact/` for
  `your-name`, `your-phone`, `your-email`, `your-subject`, `your-message`. iOS Safari auto-zooms the
  page when a field below 16px takes focus; that is a documented Safari behaviour, not something I
  reproduced on a device here — no iOS Safari was available to me. **Trade-off, stated neutrally:**
  holding the token gives a consistent type scale and keeps the form visually identical to the rest
  of the site; the cost is that iPhone users get an unrequested zoom on focus and must pinch back
  out, on the page whose whole job is to capture a lead. Moving the token to `1rem` on form controls
  removes the zoom and breaks the locked scale. **This is team_00's call, not mine and not
  team_110's** — I am not recommending a token change. *What would settle the measurement:* one
  iPhone, `/contact/`, tap the name field.
* **D4 — Contrast of text over the home hero video.** `.hero__h` measures 10.94:1 and `.hero__s`
  7.57:1 — but against **one frame**. A video backdrop's worst frame is not knowable from a single
  capture. *What would settle it:* sample 5–10 frames across the loop. I flag it rather than
  claim the home hero is proven.
* **D5 — Video captions.** Third-party embeds; the statement discloses that captions are not
  guaranteed and offers an alternative channel. Not measured, correctly disclosed.
* **D6 — The remaining 49 URLs.** I measured 34 non-QR pages plus 3 QR pages. The site publishes 83
  page URLs in `page-sitemap.xml` (note: `sitemap_index.xml` today lists only `post-sitemap.xml` and
  `page-sitemap.xml` — the three custom-post-type sitemaps recorded in earlier sessions are no longer
  in the index). The 45 QR pages I did not individually open share one template with the three I did,
  all three of which passed contrast with zero failures.

---

## 4. What stands — proven, with the measurement

**Keyboard**

* **Tab reachability and order.** Real CDP `Input.dispatchKeyEvent` Tab walks (with a settle delay
  between presses — see §6): **61 stops** on `/faq/`, **40 stops** in the mobile drawer, **24** on
  `/contact/`, **20** on `/`. Order follows visual order in RTL throughout; no reversal, no jump.
* **Desktop submenus are keyboard-reachable.** With focus on a `.nav__dd` trigger the `.nav__sub`
  panel computes `visibility: visible; opacity: 1` and the next Tab enters it — verified for all five
  dropdowns and all 18 submenu links. (The semantics of three of the five triggers are still G6.)
* **No keyboard trap outside a modal.** Zero focus stops landed inside a closed `<details>` across
  the whole `/faq/` walk (133 closed accordions on that page) — Chrome correctly skips them.
* **Mobile drawer, 390×844, opened with a real coordinate mouse event (not `element.click()`):**
  burger 44×44, `aria-label="תפריט"`, `aria-controls="ea-nav-drawer"`, `aria-expanded` false→true;
  focus moves to the close button; **41 controls all reachable**; `body { overflow: hidden }` scroll
  lock active; `document.elementFromPoint` at four coordinates behind the drawer returns only drawer
  elements and the scrim — nothing reaches the page behind; `scrollWidth == clientWidth == 390`.
* **Escape closes the drawer and restores focus.** Dispatched with `windowsVirtualKeyCode: 27`, and
  **the control passed first**: a bare reference `<dialog>` built on the same page with none of the
  site's code closed on the same event (`keyCode: 27`, `isTrusted: true`). Result: drawer
  `display: none`, `aria-expanded="false"`, scroll lock released, **focus returned to the burger**.
* **Cookie banner.** A real `<dialog>` in modal state (`:modal === true`, backdrop
  `rgba(20,14,9,0.45)`), `aria-labelledby="ea-cookie-title"`. Focus is trapped in a clean 3-element
  cycle (policy link → אישור → דחייה) — correct for a modal, and Escape closes it (same vk-27
  dispatch, same passing control). Buttons 71×45 and 72×45 at both 1440 and 390; at 390 the dialog is
  359px wide in a 390px viewport with zero horizontal overflow; all three controls hit-testable.
  Activation proven by a real coordinate click on "דחייה", which recorded the choice and reloaded.
* **Focus indicator on 100% of stops.** Dual ring — `2px solid` outline at `3px` offset plus a
  `rgb(47,32,19) 0 0 0 4px` box-shadow — so the light ring carries on dark surfaces and the dark ring
  carries on light ones. See G8 for the statement text this now contradicts in the good direction.
* **Skip link.** Present on all 12 page families, `href="#main"`, target exists and carries
  `tabindex="-1"`. When focused it renders at `[1346, 12, 82, 37]` (`position: fixed`, no clip), text
  white on `rgb(164,78,43)` = **5.69:1**.
* **Sound toggle.** `aria-pressed` flips **false → true**, the `<video>` goes `muted: true → false`,
  target 72×44, `aria-label` present. (Its *name* is G5; its *state* is correct.)

**Screen-reader semantics**

* **Accessible names.** Across 12 pages, every visible focusable control resolves a non-empty
  accessible name. Focusable counts per page: 62 `/`, 44 `/eyal-amit/`, 95 `/press/`, 90
  `/treatment/`, 45 `/repair/`, 40 `/contact/`, 33 `/accessibility/`, 21 `/en/`, 32 `/qr/qr1/`, 42
  `/stands-storage/`, 230 `/faq/`, 47 `/books/vekatavta/`. (Two apparent exceptions were my own
  harness's fault — see §6.)
* **Headings.** Exactly **one `<h1>` per page** and **zero level skips** on all 12 — e.g. `/` runs
  h1 → h2 → h3 → h2 → h3 → h2 … with no gap. This is the statement's claim and it holds.
* **Landmarks.** Exactly **one `<main>`** per page on all 12. Every `<nav>` carries an accessible
  name ("תפריט ראשי", "פירורי לחם", "ניווט נושאי שאלות נפוצות", "מידע ותקנון", …).
* **Unique IDs.** **Zero duplicate `id` attributes** on any of the 10 pages tested. The statement's
  "מזהים ייחודיים ללא כפילויות" claim holds.
* **`aria-expanded` that actually changes.** Burger false→true→false; `<button class="nav__dd">`
  false→true on focus; `.hero__sound` `aria-pressed` false→true. All read live, not from source.
* **Language of parts.** `/en/` declares `lang="en"` and contains **zero** Hebrew text runs without a
  governing `lang` declaration — the Hebrew nav on that page is correctly marked.
* **Alt attributes.** No `<img>` anywhere in the 12-page sample is missing the `alt` attribute
  entirely. `/books/vekatavta/` — the page that carried 95 empty alts in the September incident — now
  renders 98 images with **6** empty, which matches the statement's disclosed residue.

**Zoom and resize — the two open items from 17.9 and 1.5.115**

* **A11Y-LIVE-03 (nav clipped left in RTL at 200%) does NOT reproduce at 1.5.115.** Measured at
  `deviceScaleFactor: 2` across three CSS viewports — 640×512, 720×450 and 1280×1024 — on `/`,
  `/treatment/` and `/contact/`: **horizontal overflow 0 at every combination**. At 640 and 720 the
  desktop nav correctly collapses (`.nav__l` → `display: none`, burger → `display: flex`); at 1280
  the desktop nav renders at `[131, 25, 1026, 36]`, comfortably inside the viewport. The only element
  escaping the viewport is `span.arcs`, a decorative empty-text arc inside a header with
  `overflow-x: clip` — no content and no function is lost. **Recommend closing A11Y-LIVE-03 as not
  reproducible**, without unlocking the nav bar.
* **Text-only 200% resize.** Root forced 16px → 32px: body paragraphs go **19.55px → 39.1px** (an
  exact ×2, which is what the `rem` rungs are for) with **zero horizontal overflow** on `/`,
  `/treatment/`, `/contact/`, `/accessibility/` and `/repair/`, and zero genuinely clipped text. The
  nine elements that tripped an overflow check on `/treatment/` are all inside **closed** accordions,
  whose ancestor `overflow` was inspected before drawing any conclusion.
* **CF7 `min-height: 44px` from 1.5.115 — verified live.** `your-name`, `your-phone`, `your-email`
  and `your-subject` all compute `min-height: 44px` and render at exactly **44px** tall × 560 wide.
  The textarea computes `min-height: 0px` but renders **68px**, and the submit button renders
  **112×47** — both above 44 anyway, so nothing further is needed. Every field is wrapped in a
  `<label>`, so all five resolve a proper accessible name; `autocomplete` is set correctly on name,
  tel and email.

**Contrast that passes**

* All white hero H1/subtitle runs on `/`, `/contact/`, `/repair/`, `/accessibility/`, `/treatment/`,
  `/eyal-amit/`, `/en/`, `/press/` — 4.11:1 to 19.44:1 against their own size-derived thresholds,
  measured with glyphs masked (the two exceptions are listed under G2).
* `/press/` editorial hero: title 14.07:1, lead 14.07:1, kicker 8.55:1.
* All three QR pages sampled: zero contrast failures.
* Skip link 5.69:1; QR back-link `rgb(154,79,43)` on `rgb(255,255,250)` = 5.94:1.

**Not a defect, though it looks like one in a screenshot**

* The "ממתין לאישור" placeholder blocks visible on `/treatment/`, `/lessons/`, `/sound-healing/`,
  `/galleries/` and `/testimonials/` (one each, e.g. 1072×589 at `[184, 4828]` on `/treatment/`) are
  a **deliberate, canonical theme component** —
  `template-parts/chapters/parts/pending-note.php` and `videoblk-placeholder.php` — referenced across
  the S006/S007 record. They are the mechanism for showing Eyal what is still awaiting his content.
  I checked before calling them internal build leakage. Flagging them here only so nobody is
  surprised by them mid-meeting.

---

## 5. What I deliberately did not test, and why

* **Lighthouse on staging** — excluded by the sign-off request, and rightly: edge `noindex` headers
  and different caching make staging scores artefacts. Not run, no scores reported.
* **Submitting the Contact Form 7 form** — submitting a form on the owner's live site is a
  side-effecting action I am not authorised to take. This is why D1 is a doubt and not a finding.
* **Any real assistive technology** — no NVDA/JAWS/VoiceOver was available to me. Every semantic
  claim above is a property measurement, and per the team_00 ruling of 18.9.26 an automated result
  may be reported as "N found", never as evidence of conformance. Nothing in §4 is offered as a
  conformance certificate.
* **The production domain and its TLS** — the staging certificate is invalid by design and is not a
  finding; nothing here was measured on `eyalamit.co.il`, so SEO/performance artefacts of staging are
  out of scope entirely.
* **45 of the 48 QR pages** — one template, three sampled, all clean. See D6.
* **`/services/`** — returns **404** and is not in `page-sitemap.xml`; it is not a published URL, so
  there was nothing to test. `/about/` is a **301 → `/eyal-amit/`**, which I followed and tested at
  its real address. Both probed without following redirects first, so neither was mistaken for
  healthy.
* **I did not edit the theme, the board, the form, the mandate, `_aos/`, or anything else.** The only
  file this session writes is this report. Nothing was deployed and nothing was committed.

---

## 6. Harness discipline — three false findings I caught before reporting them

Recorded because a wrong finding costs this project as much as a missed one, and because two of these
would have gone into a mandate as defects.

1. **"Submenu links are unreachable by keyboard."** A Tab walk with no delay between key presses
   showed focus jumping straight past all 18 submenu links. It was a style-recalc race, not a defect:
   with a 350–400ms settle between presses, every submenu link is reached in order. **A key dispatched
   faster than the page can restyle measures the previous frame.**
2. **"10 links on `/treatment/` and 48 on `/faq/` have no accessible name."** They are inside closed
   `<details>`; `innerText` returns `''` for content Chrome does not render, so my name resolver saw
   nothing. The decisive control was the real Tab walk — **zero** focus stops landed in a closed
   accordion. Not a defect, and the `alt`/name layer is clean.
3. **"20 contrast failures on `/contact/`, including the whole footer."** Two separate artefacts
   compounded: the footer sits behind the scrolling content (its `getBoundingClientRect` is real but
   the pixels there belong to whatever covers it), and an unmasked pixel sample counts a coloured
   glyph as a background. Fixed by (a) requiring `document.elementFromPoint` to return the element or
   a descendant before sampling it, and (b) masking the run's own glyphs to `transparent` before the
   capture. The failure count on `/contact/` fell from 20 to 1 — and that 1 is real.

Also settled, per the standing note on this: `Input.dispatchKeyEvent` **must** carry
`windowsVirtualKeyCode: 27` for Escape, and a reference `<dialog>` control must pass before any
"Escape does not close it" verdict is written down. Here the control passed, so both Escape results
in §4 count.

---

## 7. Appendix — full contrast failure list (34 pages, glyph-masked pixel method)

| Page | Element | Text | Measured | Required |
|---|---|---|---|---|
| `/sound-healing/` | `.chap` | סאונד הילינג | 1.03 | 4.5 |
| `/press/` | `.ea-crumb__link` | בית | 1.12 | 4.5 |
| `/press/` | `.ea-crumb__current` | עיתונות | 1.12 | 4.5 |
| `/sound-healing/` | `.ea-crumb__link` | בית | 1.18 | 4.5 |
| `/galleries/` | `.chap` | גלריות | 1.61 | 4.5 |
| `/faq/` | `.ea-crumb__link` | בית | 1.64 | 4.5 |
| `/learning/workshops/` | `.ea-crumb__link` | בית | 1.70 | 4.5 |
| `/books/` | `.ea-crumb__link` | בית | 2.27 | 4.5 |
| `/en/` | `.chap` | cbDIDG Method - Eyal Amit | 2.37 | 4.5 |
| `/learning/lectures/` | `.ea-crumb__link` | בית | 2.41 | 4.5 |
| `/repair/` | `.ea-crumb__link` | כלים ואביזרים | 2.44 | 4.5 |
| `/accessibility/` | `.chap` | משפטי | 2.60 | 4.5 |
| `/terms/` | `.chap` | משפטי | 2.60 | 4.5 |
| `/privacy/` | `.chap` | משפטי | 2.60 | 4.5 |
| `/lessons/` | `.phero__h` | שיעורי נגינה בדיג'רידו | 2.66 | **3.0** |
| `/accessibility/` | `.ea-crumb__link` | בית | 2.84 | 4.5 |
| `/terms/` | `.ea-crumb__link` | בית | 2.84 | 4.5 |
| `/privacy/` | `.ea-crumb__link` | בית | 2.84 | 4.5 |
| `/learning/` | `.ea-crumb__link` | בית | 2.80 | 4.5 |
| `/learning/` | `.chap` | לימוד והכשרה | 2.83 | 4.5 |
| `/sound-healing/` | `.ea-crumb__current` | סאונד הילינג | 2.92 | 4.5 |
| `/repair/` | `.ea-crumb__link` | בית | 2.98 | 4.5 |
| `/eyal-amit/mokesh-dahiman/` | `.ea-crumb__link` | בית | 3.02 | 4.5 |
| `/contact/` | `.chap` | צור קשר | 3.04 | 4.5 |
| `/books/` | `.ea-crumb__current` | ספרים | 3.26 | 4.5 |
| `/books/tsva-bekahol/` | `.ea-crumb__link` | ספרים | 3.49 | 4.5 |
| `/books/kushi-blantis/` | `.ea-crumb__link` | בית | 3.83 | 4.5 |
| `/books/kushi-blantis/` | `.ea-crumb__link` | ספרים | 3.83 | 4.5 |
| `/books/tsva-bekahol/` | `.ea-crumb__link` | בית | 4.04 | 4.5 |
| `/books/vekatavta/` | `.ea-crumb__link` | בית | 4.08 | 4.5 |
| `/books/vekatavta/` | `.ea-crumb__link` | ספרים | 4.10 | 4.5 |
| `/sound-healing/` | `.phero__s` | מסע אישי ופרטי בצלילים | 4.12 | 4.5 |
| `/galleries/` | `.ea-crumb__link` | בית | 4.49 | 4.5 |

146 text runs sampled across 34 pages; 33 failed; 113 passed.
