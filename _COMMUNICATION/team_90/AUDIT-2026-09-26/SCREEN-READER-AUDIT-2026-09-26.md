# Screen-reader accessibility audit — Eyal Amit staging (2026-09-26)

**Site:** `http://eyalamit-co-il-2026.s887.upress.link` (plain HTTP by design)  
**Theme (staging):** ea-eyalamit **1.5.141** (per audit brief)  
**Auditor lane:** Team 90 — read-only machine audit  
**Evidence (scratchpad, not in repo):** `/private/tmp/claude-501/-Users-nimrod-Documents-AOS_V5-EyalAmit-co-il-2026/8a34018b-bb57-45a0-b464-69539609f78a/scratchpad/` (`audit_results.json`, `audit_post_cookie.json`, `audit_targeted.json`, runner scripts)

---

## What was actually run

| Layer | Tooling |
|--------|---------|
| Browser | `chrome-headless-shell` at `/Users/nimrod/.cache/puppeteer/chrome-headless-shell/mac_arm-149.0.7827.22/chrome-headless-shell-mac-arm64/chrome-headless-shell` (same discovery pattern as `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs`) |
| Accessibility data | Chrome DevTools Protocol **`Accessibility.getFullAXTree`** (accessibility tree, not raw DOM) |
| Keyboard | CDP **`Input.dispatchKeyEvent`** for **Tab** (and **Escape** on one mobile-nav probe) — not `element.focus()` |
| Viewports | **1440×900** (desktop) and **390×844** (mobile) |
| Population | WordPress REST: `pages` (101 published) + `posts` (52 published) = **153** objects; HTTP check (max 3 concurrent, 502 retry): **136** return **200**, **17** return **301** redirects (legacy paths such as `/muzza/*`, `/services/didgeridoo-lessons/` → `/lessons/`, etc.) |
| Real screen reader | **Not run.** No VoiceOver, NVDA, or JAWS session was driven on this machine in this audit. |

### Passes

1. **First-visit pass (cookie modal open):** Each navigation starts with no stored consent; `#ea-cookie-notice` is opened with `showModal()`. AX tree and Tab order were recorded **before** dismissing the dialog.
2. **Post-consent pass:** Cookie **“דחייה”** clicked, then AX tree, skip-link behaviour, and extended Tab sampling on the page content.
3. **Targeted probes:** Cookie-only Tab cycle; FAQ `<details>` / AX roles; `/en/` language; contact form empty submit; mobile home Tab after opening **“תפריט”**.

---

## What this audit is — and is not

This is a **machine audit of the accessibility tree, focus behaviour, and related DOM signals** in headless Chrome. It approximates what many screen readers consume, but it is **not** a substitute for testing with real assistive technology and a human operator.

**It does not establish** ISO 5568 / WCAG conformance level, “full compliance” for the published accessibility statement, or that blind users can complete real tasks without friction.

**It can establish** specific, reproducible defects (missing names, modal focus leaks, unlabeled fields in the DOM, images with empty `alt`, etc.) and areas that looked **acceptable in AX** after cookie dismissal on the sampled URLs.

---

## Pages audited (stratified) and why

Sampling follows `_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv` template families (chapters home, method, service/learning, commerce, book, contact, FAQ, blog, QR, catalogs, legal, English). Required brief items are **bold**.

| Page ID | URL path | Template / family rationale |
|---------|----------|-----------------------------|
| **home** | `/` | Chapters home (`tpl-chapters-home`); cookie modal; hero FAQ; embeds |
| **lessons** | `/lessons/` | Service / learning (canonical target of `/services/didgeridoo-lessons/` redirect) |
| **book-vekatavta** | `/books/vekatavta/` | Book detail; previously flagged image alts |
| **repair** | `/repair/` | Commerce / repair; known empty `alt` photographs |
| **contact** | `/contact/` | **Contact + CF7** (critical form) |
| **faq** | `/faq/` | **FAQ** accordion (`<details>` / DisclosureTriangle) |
| **blog** | `/blog/` | **Blog archive** |
| **blog-post** | `/פודקאסט-דיגרידו-ונשימה-אייל-עמית-2/` | **Single post** (podcast article) |
| **qr1** | `/qr/qr1/` | **Printed QR code** landing |
| **galleries** | `/galleries/` | **Galleries catalog** |
| **en** | `/en/` | **English** page (`lang=en`, `dir=ltr`) |
| **accessibility** | `/accessibility/` | **Legal — accessibility statement** |
| **privacy** | `/privacy/` | **Legal — privacy** |
| **terms** | `/terms/` | **Legal — terms** |
| method | `/method/` | Only page on `tpl-chapters-method` |
| didgeridoos | `/didgeridoos/` | Richest product/commerce chapter family |
| about | `/about/` | About hub |
| testimonials | `/testimonials/` | Media / testimonials catalog |
| learning-hub | `/learning/` | Learning hub |
| press | `/press/` | Press |
| qr-index | `/qr/` | QR index |

Each row above was audited at **both** viewports unless noted. The first-visit cookie pass covered **21 URLs × 2 viewports** plus an extra mobile home cookie probe (**43** runs in `audit_results.json`). Post-consent structure/keyboard sampling covered **16 URLs × 2 viewports** (`audit_post_cookie.json`).

**Not audited:** The remaining ~130 published URLs (including most QR variants and legacy redirect sources). Findings on unaudited URLs are **not determined**.

---

## Findings (ordered by severity for screen-reader users)

Severity key: **Blocker** — likely prevents or fundamentally breaks task completion; **Major** — serious confusion or loss of information; **Moderate** — friction or WCAG gap; **Minor** — polish.

### 1. Blocker — First visit: page content is absent from the accessibility tree behind the cookie modal

- **Pages:** All sampled URLs on **first load** (representative: **home**, desktop and mobile).
- **Element / mechanism:** Native `<dialog id="ea-cookie-notice">` with `showModal()`; AX tree while open contains essentially **only** the dialog (~23 nodes on home — roles `dialog`, buttons, privacy link, static text). **No `main`, no `navigation`, no headings, no page content.**
- **Screen-reader experience:** On a first visit (no prior consent cookie), the user hears only the cookie notice. The site they came for **does not exist** in the tree until they activate **אישור** or **דחייה**. This is expected modal behaviour to a point, but it **blocks any other page purpose** (including reading the accessibility statement from the footer) until dismissed.
- **Fix direction:** Keep modal semantics, but ensure the dialog is concise, focus is trapped **inside** it (see finding 2), and consider whether first paint should still expose skip link + document title in a way AT users expect; document in the accessibility statement that first interaction is cookie consent.

### 2. Blocker — Cookie modal: Tab focus escapes to the inert page (`<body>`) while the dialog stays open

- **Pages:** **home** (targeted probe); same pattern on first-visit Tab runs site-wide while cookie open.
- **Element:** Tab order cycles **אישור → דחייה → `document.body` → מדיניות הפרטיות → …** with `ea-cookie-notice` still `open`. Initial focus on load was the privacy link (`A.ea-cookie__link`), not the dialog title or primary action.
- **Screen-reader experience:** Focus intermittently lands on the full page behind the modal (body), which is supposed to be inert. Users can believe they left the dialog or can interact with the page, while the modal still blocks interaction — **disorienting and contrary to modal keyboard patterns**.
- **Fix direction:** Implement robust focus trap per WAI-ARIA modal dialog pattern: initial focus on title or primary button, Tab/Shift+Tab cycle only among dialog controls, no focus on `body` until close; return focus to a sensible element on dismiss.

### 3. Major — Contact form: no programmatic labels in the DOM (placeholders only)

- **Page:** `/contact/` (desktop and mobile).
- **Element:** Contact Form 7 fields `your-name`, `your-phone`, `your-email`, `your-subject`, `your-message` — **no** `id` + `<label for>`, **no** `aria-labelledby` in DOM inspection; placeholders hold Hebrew hints (“שם מלא”, “טלפון”, …).
- **Screen-reader experience:** Chromium’s AX tree **does** expose names such as “שם מלא” / “נושא” (likely from placeholder heuristics). In the Tab probe, several fields appeared with **empty spoken text** in the active-element snapshot. Users may hear unnamed fields or lose label/context when placeholders disappear after input. Required fields are **not** clearly distinguished in the DOM beyond CF7 defaults (**not determined** in AX for `aria-required`).
- **Fix direction:** Visible `<label>` associated with each control (or `aria-labelledby`); do not rely on `placeholder` alone; mark required fields programmatically; ensure error text is tied with `aria-describedby`.

### 4. Major — Contact form validation: errors in DOM but not exposed as alerts in the AX tree

- **Page:** `/contact/` after empty submit.
- **Element:** `.wpcf7-not-valid-tip` (“נא למלא שדה זה.”), `.wpcf7-response-output` with `aria-live="polite"` (“קיימת שגיאה בשדה אחד או יותר…”), `aria-invalid="true"` on three fields.
- **Screen-reader experience:** Visual and DOM error state exists. **`Accessibility.getFullAXTree` returned no `alert` nodes** after submit. Whether NVDA/VoiceOver announces the live region is **not determined** in this audit; in the tree used here, failures were **not** surfaced as alerts — risk that errors are easy to miss.
- **Fix direction:** Use `role="alert"` or `aria-live="assertive"` for the summary; associate each field error via `aria-describedby`; verify with a real screen reader.

### 5. Major — `/repair/`: seven content photographs use `alt=""`

- **Page:** `/repair/` (desktop and mobile).
- **Element:** Theme repair gallery images, including `EA-000239.jpeg`, `EA-000298.jpg`, `EA-000214.jpeg`, `EA-000238.jpeg`, `EA-000220.jpeg`, `EA-000268.jpeg`, `EA-000161.jpg` — all `alt=""` in HTML.
- **Screen-reader experience:** Images are treated as decorative; users get **no description** of repair work photos that are substantive content (figures also expose filename links in content — **not determined** if read as adjacent text).
- **Fix direction:** Provide meaningful `alt` per image (or visible captions referenced via `aria-labelledby`); only use empty `alt` if truly decorative.

### 6. Major — Mobile home: multiple unnamed iframes in the Tab order

- **Page:** **home**, viewport **390×844**, after cookie dismissed and menu opened once.
- **Element:** At least **five** consecutive **`IFRAME`** stops with **empty** accessible name in the Tab chain (YouTube / embed pattern — **exact embed count not mapped to src** in this pass).
- **Screen-reader experience:** Keyboard users tab through several “blank” embeds before reaching meaningful links — tedious and confusing; may announce as unlabeled frame or silence.
- **Fix direction:** `title` on each iframe, defer embeds from tab order where appropriate (`tabindex="-1"` on wrapper with accessible “play video” control), or use consent-gated loading.

### 7. Major — English page: document is English; primary navigation stays Hebrew without a coherent language strategy

- **Page:** `/en/`
- **Element:** `<html lang="en" dir="ltr">`; sampled **nav** text is Hebrew (“המרכז לטיפול בדיג׳רידו”, Hebrew menu items); multiple descendants carry `lang="he"`.
- **Screen-reader experience:** English screen reader voice on `en` page may **switch incorrectly** or mispronounce Hebrew menu items; Hebrew AT users on English content get the inverse problem in the nav.
- **Fix direction:** English nav labels on `/en/`, or `lang="he"` only on Hebrew segments with an English nav alternative; ensure `lang` on blocks matches spoken content.

### 8. Moderate — Latin trademark text in Hebrew pages (e.g. `cbDIDG`) without verified `lang` on the token

- **Pages:** **home** (H1 includes “cbDIDG”), **method** (content includes “cbDIDG” in HTML).
- **Element:** Latin letters inside Hebrew copy.
- **Screen-reader experience:** May be read with Hebrew phonetics unless `lang="en"` wraps the token.
- **Fix direction:** `<span lang="en">cbDIDG</span>` (or equivalent) inside Hebrew headings/body.

### 9. Moderate — Mobile navigation: menu toggle behaviour partially verified only

- **Pages:** All mobile samples.
- **Element:** Button named **“תפריט”** (`aria-expanded` toggles to `true` after click). Panel container selector used in automation **did not match** (`panelFound: false`), but many nav links exist in DOM.
- **Screen-reader experience:** Toggle name is present. Whether focus is trapped in the drawer, whether **Escape** returns focus to the button, and whether background content is inert — **not fully determined** (Escape left focus on a FAQ `<summary>` on home, not clearly on the menu button).
- **Fix direction:** Verify mobile nav against APG disclosure/dialog pattern; manual AT pass required.

### 10. Moderate — Cookie dialog: accessible name present; heading linkage incomplete in DOM

- **Pages:** Site-wide first visit.
- **Element:** `#ea-cookie-notice` — `aria-labelledby="ea-cookie-title"`; AX exposes dialog name **“שימוש בעוגיות”**. DOM `title` snippet for `#ea-cookie-title` was empty in one probe (labelling may still work via AX internal mapping — **not determined** in DOM alone).
- **Screen-reader experience:** Dialog is named; buttons **אישור** / **דחייה** have visible text (good). Privacy link is understandable.
- **Fix direction:** Ensure visible heading element matches `ea-cookie-title`; prefer focus on dialog title on open.

### 11. Minor — `/books/vekatavta/` image alt gap (previously known): **not reproduced on staging today**

- **Page:** `/books/vekatavta/`
- **Finding:** HTML sample (96 `<img>`) showed **no** missing/empty `alt` in automated crawl; post-consent AX **unnamed image count = 0** on this URL. Team 10 reported alt remediation on 2026-09-26 (`DONE-FORM-VEKATAVTA-ALT-2026-09-26.md`).
- **Screen-reader experience:** No defect confirmed in this audit pass.
- **Fix direction:** None from this audit; keep regression check in QA.

### 12. Positive (reduces severity elsewhere) — After cookie dismissal on sampled pages

- **Landmarks:** One **`main`**, one **H1**, named **`navigation`** regions (“תפריט ראשי”, “ניווט בפוטר”, often “פירורי לחם”) on post-consent AX for **home, lessons, contact, faq, blog, legal**, etc.
- **Skip link:** `a[href="#main"]` (“דלג לתוכן” / “Skip to content” on `/en/`) moves focus to **`#main`** after consent (**verified** on home desktop).
- **FAQ:** `/faq/` — `<summary>` items expose as **`DisclosureTriangle`** with meaningful Hebrew names in AX (e.g. “מה זה בעצם טיפול בדיג'רידו?”).
- **Focus visibility:** On `/contact/`, focused controls showed **2px outline + box-shadow** in computed styles during Tab (not a substitute for full keyboard audit on all widgets).
- **Galleries / QR / home (post-consent):** AX **unnamed `image` role count = 0** on spot-checked paths (`/`, `/galleries/`, `/qr/qr1/`, `/contact/`).

---

## Dynamic behaviour (summary)

| Behaviour | Finding |
|-----------|---------|
| Cookie modal | See blockers 1–2; modal is announced as `dialog` with name “שימוש בעוגיות”. |
| FAQ accordions | Named disclosures; expand/collapse state present in AX (`expanded: false` at rest). |
| Carousels / autoplay audio | **Not determined** on all pages; home mobile had embed iframes in tab order. No `audio[autoplay]` on home DOM probe. |
| CF7 submit | Errors visual + `aria-live="polite"`; **alert role absent in AX** (finding 4). |

---

## What still stands between this site and a defensible compliance claim

### Fixable in implementation (team 10 / theme) without a human AT session

1. Cookie modal **focus trap** and **no body focus** while open; rational **initial focus**.
2. **Repair** page image `alt` text (seven images).
3. **Contact form** real labels, required semantics, and **error announcement** wiring (`aria-describedby` / alert pattern).
4. **Iframe** titles and tab order on mobile home (and any similar embed-heavy templates).
5. **`lang` attributes** for English page navigation and Latin tokens (`cbDIDG`) in Hebrew pages.
6. Mobile nav **focus return** and drawer semantics (complete APG pattern).

### Requires a human assistive-technology session (cannot be signed off from this audit)

1. **End-to-end tasks** with **VoiceOver** (macOS/iOS) and at least one **Windows** screen reader (NVDA or JAWS): first visit with cookie, contact form completion, FAQ expand, mobile menu, English page reading order.
2. **Judgment** on whether alt text is **meaningful** (not just non-empty) across catalogs, galleries, and blog media.
3. **Full-site** pass or statistically significant sample beyond the **~21 URLs × 2 viewports** tested here (remaining URLs **not determined**).
4. Owner sign-off that the **accessibility statement** text matches tested reality and does not claim a conformance level this work does not support.

---

## Redirect note (population, not a defect)

Seventeen published URLs return **301** to canonical paths (e.g. `/services/didgeridoo-lessons/` → `/lessons/`). Screen-reader users following old links receive redirects; target pages were audited where listed above. TLS on staging was **not** evaluated (invalid cert by design).

---

*End of report. No site code was modified. Single deliverable: this file.*
