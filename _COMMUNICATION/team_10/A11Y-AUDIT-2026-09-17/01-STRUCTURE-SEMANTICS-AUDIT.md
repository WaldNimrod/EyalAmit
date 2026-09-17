# A11Y-STRUCT — Semantic Structure and Markup Audit

Line: team_10 (A11Y-STRUCT) · Date: 2026-09-17 · Repo: `EyalAmit.co.il-2026` ·
Branch `s006/tracker-integrity` · Commit `8f6296d` (2026-09-17 22:35:58 +0300)
Standard: **IS 5568 level AA = WCAG 2.0 level AA** (binding). Any 2.1/2.2-only criterion
cited below is explicitly labelled "beyond the binding standard — recommendation only."
**This is not legal advice.**

Consolidation, claim verification and fixes: team_100. This line does not fix anything and
did not edit any file under `site/`.

---

## 1. Scope and what I actually ran

**Mandate:** semantic structure and markup — headings, landmarks, alt text, link/button
semantics, language, tables/lists, page titles, parsing — on the theme source under
`site/wp-content/themes/ea-eyalamit/` plus mu-plugins that inject page markup.

**Static code read** (full file reads unless noted), all under
`site/wp-content/themes/ea-eyalamit/` except where stated:
`header.php`, `footer.php`, `functions.php` (relevant hooks), `inc/chapters/chapters-render.php`
(full, 784 lines), `inc/wave2-stage-b.php` (relevant sections), `inc/seo-head-fallbacks.php`
(full); every `page-templates/tpl-chapters-*.php` (page, home, method, en, qr, mokesh,
blog-archive, blog-single); `template-parts/chapters/section-nav.php`,
`section-footer.php`, and every `section-0X-*.php`; every
`template-parts/chapters/parts/*.php` (phero, gallery, bookcard, contact, mag, steps,
reveals, dd, faq-inline, faqblock, product-cta, cta, pending-note and others);
`template-parts/blocks/block-faq-list.php`, `block-blog-card.php`; every
`inc/chapters/defaults/*.php` relevant to the page set below plus the three book pages
(vekatavta, kushi-blantis, tsva-bekahol); all 42 files in `site/wp-content/mu-plugins/`
listed and grepped for direct markup injection (`the_content`/`wp_footer`/`wp_body_open`
hooks that `echo` HTML tags) — none found beyond what is already covered above.

**Live measurement** — staging is the system of record per the shared brief
(`http://eyalamit-co-il-2026.s887.upress.link`, HTTP 200, TLS invalid by design). Fetched
with `curl -s` in this session on 2026-09-17, all returned HTTP 200:
`/`, `/contact/`, `/treatment/`, `/accessibility/`, `/faq/`, `/shop/`, `/blog/` + one post
(`/פודקאסט-דיגרידו-ו-נשימה-אייל-עמית-2/`), `/en/`, `/qr/` + `/qr/qr1/`,
`/books/vekatavta/` — the 12 URLs named in the brief's page set — plus `/books/kushi-blantis/`
and `/books/tsva-bekahol/` fetched additionally to corroborate a pattern found in the third
(`vekatavta`) once it looked systemic. 14 fetches, 13 distinct pages, all saved to this
session's scratchpad and analyzed with small Python scripts: heading-tree extraction with
level-skip/multi-H1/empty-heading checks, landmark element counts, `<img>`/`alt` inventory,
site-wide duplicate-`id` check, and a tag-balance heuristic (Python's stdlib `html.parser`,
tracking an open-tag stack) — **not** a certified validator (no W3C Nu / html5lib available in
this environment), so the "parsing" result below is a heuristic measurement, labelled as such.
`curl` output is markup only; nothing below claims anything about JS-built DOM, layout, or
contrast from it.

**What this did not cover:** contrast, focus visibility, keyboard traps, screen-reader
behavior, mobile — other lines' mandates. JS-dependent runtime behavior (menu toggle,
testimonial carousel, sound-toggle button, RTL bidi rendering) is out of a static-markup
mandate and is called out explicitly below rather than guessed at.

---

## 2. Findings

| ID | Severity | WCAG 2.0 SC | Measured/Inferred | Evidence | User impact |
|---|---|---|---|---|---|
| **A11Y-STRUCT-01** | **High** | 1.1.1 Non-text Content (A) | Measured (live + source) | `template-parts/chapters/parts/gallery.php:54` renders `alt="<?php echo esc_attr( ea_chapters_content_img_alt( $src, $it['alt'] ?? '' ) ); ?>"`. The fallback helper `ea_chapters_content_img_alt()` (`inc/chapters/chapters-render.php:753-783`) returns `''` for any filename not in its hardcoded map (line 782), and the map (lines 760-781) has no entries for any `veka-*.jpg`/book-gallery filename. The three book galleries supply zero `alt` and zero `cap` keys per item: `inc/chapters/defaults/vekatavta-defaults.php:88-189` (95 items), `inc/chapters/defaults/kushi-blantis-defaults.php:86-115` (22 items), `inc/chapters/defaults/tsva-bekahol-defaults.php:78-129` (45 items). Live-fetched 2026-09-17: `/books/vekatavta/` = 95 of 96 `<img>` with `alt=""`; `/books/kushi-blantis/` = 22 of 23; `/books/tsva-bekahol/` = 45 of 46 (the one non-empty image on each page is the book cover, which does carry an explicit alt). No `figcaption`/`cap` and no `aria-hidden` on any of these — they are not marked decorative either. | A blind/low-vision screen-reader user gets **no content at all** from three whole "Gallery" sections (162 photos combined) that sighted users see as part of the book's narrative — the section is silently empty for them, not merely under-labelled. |
| **A11Y-STRUCT-02** | Medium | 1.3.1 Info and Relationships (A) | Measured (live + source) | `template-parts/chapters/parts/bookcard.php:57` renders each card's visible title as `<span class="bookcard__t">`, never a heading, while `.bookcard__t` is styled as the card's title (per the visual design intent stated in the file's own docblock, lines 3-11: "cover + (meta) + title + blurb + CTA"). This part backs three hub pages in the audited set: `inc/chapters/defaults/shop-defaults.php:37-73` (5 cards), `inc/chapters/defaults/qr-hub-defaults.php:37` (QR hub), `inc/chapters/defaults/muzza-defaults.php:56` (books hub). Live-fetched: `/shop/` and `/qr/` each contain **exactly one heading on the whole page** (the page H1); the five/several visually-titled cards contribute nothing to the heading tree. This is the F2 failure pattern (conveying structure via presentation/styling instead of markup) applied to a title, not a section. | A screen-reader user who navigates by heading (the single most common AT navigation method for scanning a page) finds one H1 and then nothing — the entire content of the shop/QR hub is invisible to heading-based navigation and must be found by linear reading or by-link navigation instead. |
| **A11Y-STRUCT-03** | Medium-Low | 1.3.1 / 2.4.6 Headings and Labels (A/AA), consistency | Measured (live + source) | The same accordion component, `template-parts/blocks/block-faq-list.php`, wraps each question in a heading in one code path but not the other. Full/unfiltered mode (used by the standalone `/faq/` hub): `block-faq-list.php:100-101` — `<summary class="ea-faq-item__summary"><h3 class="ea-faq-item__question">…</h3>`. Category-filtered/"view-only" mode (used when a page embeds a subset, e.g. `/treatment/`'s "שאלות נפוצות" section via `inc/chapters/defaults/treatment-defaults.php:206-211`, `'cats' => array('treatment')`): `block-faq-list.php:45-46` — `<summary class="ea-faq-item__question">` with **no** heading inside. Live-confirmed: `/faq/` = 150 headings, H2 per category + H3 per question throughout; `/treatment/` = one H2 ("שאלות נפוצות") and then zero H3s for its own listed questions. Same component, two accessible-name/heading behaviors for the identical visual pattern. | On `/faq/`, a screen-reader user can jump question-to-question by heading. On `/treatment/` (and any other page that embeds a filtered FAQ subset the same way), the same-looking accordion cannot be heading-navigated — only reachable by tabbing through each disclosure in sequence. |
| **A11Y-STRUCT-04** | Low-Medium | 2.4.4 Link Purpose in Context (A) | Measured (source, sitewide) | `template-parts/chapters/section-nav.php:36-37`: `<?php /* קורסים: ממתין ל-URL קורס חיצוני... placeholder עד שיסופק, ר' block-topnav.php */ ?><li><a href="#">קורסים</a></li>` — a real item in the primary menu (rendered on every page that includes `section-nav.php`, i.e. every audited page except `/en/`) whose accessible name ("קורסים" / Courses) promises a destination the link does not provide; activating it is a no-op. Acknowledged in the code comment as an intentional placeholder awaiting a real URL, not an oversight. | Every keyboard and screen-reader user who tries the "Courses" menu item (a real, visually normal-looking nav entry, present sitewide) gets no feedback and no destination — indistinguishable from a broken link. |
| **A11Y-STRUCT-05** | Low | 1.1.1 / 4.1.2 (A) | Measured (source + live) | `template-parts/chapters/section-07-how-to-start.php:17-21` defines three decorative step icons (phone/compass/calendar SVGs) with no `aria-hidden` anywhere in the string; `:36` renders them via `<span class="st3__ic"><?php echo $icons[...]; ?></span>` — the wrapping `<span>` also carries no `aria-hidden`. This is the one inconsistency found against an otherwise-consistent sitewide convention: every other decorative icon in the live render path (nav caret, burger, sound-toggle, footer social glyphs, FAQ chevron, testimonial avatar/external-link glyphs) is wrapped in `aria-hidden="true"` on itself or its parent — confirmed by reading each in context, see §3. | Screen-reader users get an extra, unlabelled graphic announced for each of the "how to start" steps (3 per page, on `/`, `/treatment/`, `/method/`, etc.) — minor noise, no lost content since the step's title/text is separately and correctly exposed. |
| **A11Y-STRUCT-06** | Low | 1.3.1 (A) | Measured (source + live) | `template-parts/chapters/section-07-how-to-start.php:33-39`: three sequential, individually-titled steps ("Step 1/2/3" visually, via the icon+CSS-counter design) are each a plain `<div class="st3">` inside `<div class="steps3 r">` — no `<ol>/<li>`. By contrast, `section-nav.php` explicitly re-asserts `role="list"` on every `<ul>` it emits (lines 21, 24, 34, 44, 55, 65) specifically to preserve list semantics against the known WebKit/VoiceOver bug where `list-style:none` strips the implicit list role — showing the team is aware of list semantics elsewhere, which makes this instance read as an oversight rather than a deliberate choice. | A screen-reader user is not told "list of 3 items" / "item 2 of 3" for the how-to-start steps the way they would be for a real list — the sequence and count are conveyed only visually. |
| **A11Y-STRUCT-07** | Low | 3.1.2 Language of Parts (AA) | Measured (source + live) | `page-templates/tpl-chapters-en.php:17` sets `<html lang="en" dir="ltr">` for the whole page. Two Hebrew-language runs are embedded in that English-tagged document with no element-level `lang="he"` switch: `:48` — the draft banner, `<span>Draft — English summary is a team draft awaiting Eyal's approval before launch (WP-EI-06) · טיוטה צוותית באנגלית הממתינה לאישור אייל</span>`; `:112` — the footer link, `<a href="/">לאתר העברי / Hebrew site</a>`. Confirmed live in `/en/`'s fetched HTML, byte-for-byte matching. | A screen reader set to an English voice will attempt to pronounce the Hebrew text as English (or vice-versa for a Hebrew voice, on the rare visitor who has one active while reading this English page) — the embedded phrase becomes unintelligible noise instead of correctly-voiced Hebrew. |
| **A11Y-STRUCT-08** | Not a 2.0 AA failure — recommendation (touches SC 3.2.5 On Request, **Level AAA**, beyond the binding IS 5568 AA standard) | — | Measured (source, sitewide grep) | `target="_blank"` is used consistently with `rel="noopener noreferrer"` (good security practice, unrelated to a11y) but **inconsistently** carries a warning that the link opens a new window/tab. Carries a warning: `template-parts/chapters/parts/contact.php:86-87` (aria-label "…(נפתח בחלון חדש)"), `phero.php:35` and `cta.php:26,30` (aria-label "…(נפתח בלשונית חדשה)", only when `cta_slug` is set). Carries **no** warning: `template-parts/chapters/parts/product-cta.php:54,68`; `page-templates/tpl-chapters-en.php:104`; the testimonial name-links, `template-parts/chapters/parts/testimonials.php:67` and `section-05-testimonials.php:64` (no `aria-label` at all — the link's only accessible name is the person's name; the adjacent "external link" SVG glyph is `aria-hidden="true"`, so the new-window cue is visual-only); the external book-purchase links in `inc/chapters/defaults/vekatavta-defaults.php:198`, `kushi-blantis-defaults.php:125`, `tsva-bekahol-defaults.php:139`; and the two research-citation links in `inc/chapters/defaults/snoring-sleep-apnea-defaults.php:71,83,316`. | Since 3.2.5 is AAA and not the binding standard, this is a recommendation, not a compliance gap. Practically: some new-tab links warn the user first and some silently open a second tab/window, which is inconsistent and can disorient a screen-reader or low-vision user who doesn't notice the new tab (e.g. thinks the Back button will return them, when it won't). |
| **A11Y-STRUCT-09** | Low — recommendation | 2.4.2 Page Titled (A), borderline | Measured (live); source of the value **not found** in theme code (see §4) | Live `<title>` for `/shop/`: **"עמוד קטלוג ראשי - eyal amit"** ("Main catalog page - eyal amit"). This reads as an internal/admin label rather than a title written for a site visitor, unlike every other fetched page's title (e.g. `/contact/` → "צור קשר - eyal amit", `/treatment/` → "טיפול בדיג'רידו בפרדס חנה \| אייל עמית – שיטת cbDIDG"). It does still loosely describe the page's topic (a catalog page), so this is not a clear 2.4.2 failure — titles need only identify topic/purpose, which this technically does. | A visitor with several tabs open (or a screen-reader user reading the tab/window title list) sees a generic internal label instead of "Tools & Accessories" or similar — harder to distinguish this tab from others at a glance. |
| **A11Y-STRUCT-10** | Not a clear 2.0 AA failure — recommendation (loosely touches 2.4.5 Multiple Ways, AA, but that SC concerns locating a page within a *set* of pages, and `/en/` is deliberately one self-contained page, not a set) | — | Measured (source + live) | `page-templates/tpl-chapters-en.php:41-44` gives `/en/` its own minimal `<header>` (brand link + "עברית →" language switch) with **no `<nav>` element at all** — confirmed live (`page_en.html`: `<nav>` count = 0, vs. 1-3 on every Hebrew page). The only ways off the page are: the header's Hebrew-home link, one in-body "visit the Hebrew site" link (`:70`), the WhatsApp CTA (`:104`), and the footer's duplicate Hebrew-site link (`:112`). This is very likely deliberate (the docblock at `:5-8` calls it a self-contained English landing page, "PLACEHOLDER copy," not a subsite), but it is a real structural difference from every other page in the set. | An English-reading visitor has no menu to browse the (Hebrew) site from `/en/` — only a single link back to the Hebrew home page and a WhatsApp CTA. Not a violation as scoped, but worth the team's explicit sign-off that this is intended, not missed. |

---

## 3. Checked and found correct (with evidence)

- **Heading tree, all 13 fetched pages: exactly one `<h1>`, zero skipped levels, zero empty
  headings.** Measured live, 2026-09-17: `/`, `/contact/`, `/treatment/`, `/accessibility/`,
  `/faq/` (150 headings, H1→H2×24→H3×126, no skips), `/shop/`, `/blog/`, one blog post,
  `/en/`, `/qr/`, `/qr/qr1/`, `/books/vekatavta/`, `/books/kushi-blantis/`,
  `/books/tsva-bekahol/`. Root cause confirmed in source: `template-parts/chapters/parts/phero.php:31`
  unconditionally renders the page's single `<h1>` and is called exactly once per page by
  every `page-templates/tpl-chapters-*.php` template; every section-level "part" hardcodes
  `<h2>` for its own title and `<h3>` for sub-items (confirmed by reading every file in
  `template-parts/chapters/parts/*.php` and `section-*.php` — full tag inventory taken).
  No file constructs a heading tag from a dynamic `$level` variable anywhere in the theme
  (checked with a repo-wide pattern search) — the brief's concern about "parts that take a
  heading level as an argument" does not materialize as a live mechanism; each part's level
  is a fixed literal.
- **Skip link resolves correctly, sitewide, live.** `inc/wave2-stage-b.php:415-425`
  (`ea_wave2_body_open_extras()`, hooked to `wp_body_open` priority 5) prints
  `<a class="ea-skiplink" href="#main">` (Hebrew label) or "Skip to content" (English, when
  `is_page('en')`, line 419-421) whenever `ea_wave2_is_active_view()` is true. That gate
  (`:61-80`) is true for Chapters pages because `inc/chapters/chapters-routing.php` sets the
  `ea_wave2_shell` query var (lines 61, 91, 98) on every Chapters-routed request — verified by
  reading the actual gate function in full, not just its first branch (its first branch, a
  template-name whitelist at `:62-76`, lists only pre-Chapters legacy templates and would
  wrongly suggest the skip link is dead on every Chapters page; the second branch, `:79`, is
  what actually fires). Every `page-templates/tpl-chapters-*.php` template gives `<main>` the
  matching `id="main"` (confirmed by grep across all 8 template files). Live-confirmed: all 13
  fetched pages carry exactly one working skip link with `href="#main"` matching an existing
  `id="main"`. **This directly confirms the brief's §"Verified environment facts" claim that
  the A11Y-NOW skip-link fix is merged and live — I looked for a reason to disagree with that
  premise (the dead `header.php` skip link at `header.php:24`, which target `#main` but is
  never reached because Chapters templates never call `get_header()`, made me suspect the
  fix was dead code) and did not find one once I traced the actual live path.** I flag the
  dead `header.php`/`footer.php` code itself in §6 as a trap for other lines, not as a defect.
- **No layout tables anywhere in the theme.** Repo-wide search for `<table` across
  `template-parts/`, `inc/`, `page-templates/` returned zero hits. The visual "comparison"
  sections (home's "טיפול או סאונד הילינג", `template-parts/chapters/section-06-compare.php`)
  are two-card grids with a real `<h2>` section title and a real `<h3>` per card
  (`:35` and `:49`) — not a table, and correctly headed.
  Where semantic HTML has a native equivalent, the theme uses it: `dd.php` uses real
  `<details>/<summary>` for its drill-down accordion (`:20-21`, native disclosure semantics,
  keyboard-operable without added script) and `<ul role="list">` is used correctly for the
  primary/sub navigation menus.
- **No duplicate `id` attributes on any of the 13 fetched pages.** Measured with a
  site-wide-per-page regex scan; zero collisions found, including on `/faq/` (150 accordion
  items) and `/books/vekatavta/` (95 gallery images) — the highest-repetition pages in the set.
- **No unclosed/mismatched tags on any of the 13 fetched pages**, per a tag-balance heuristic
  (Python `html.parser`, void-element aware) — every page ended with an empty open-tag stack
  and zero mismatch events. Labelled as a heuristic, not a certified-validator result (see §4).
- **No nested interactive elements (`<a>` inside `<a>`, `<button>` inside `<a>`) in any
  rendered page body.** An initial pass found ~28 apparent hits on `/faq/` and `/treatment/`;
  inspecting the actual matched text showed every one was inside a `<script type=
  "application/ld+json">` FAQPage schema block, where `<\/a>` is JSON-escaped text, not
  markup — a false positive from not excluding `<script>` content, exactly the "confident
  wrong answer" trap the brief warns about. Re-run with `<script>`/`<style>` bodies stripped
  first: zero genuine hits.
- **Icon-only interactive controls consistently have accessible names,** and their decorative
  glyphs are consistently `aria-hidden` — checked by reading every `<button>`/icon-bearing
  `<a>` in the live render path: the nav burger (`section-nav.php:78`,
  `aria-label="תפריט" aria-expanded="false" aria-controls="nav"`), the sound toggle
  (`:74`, `aria-pressed="false" aria-label="…"`), the two dropdown triggers (`:33`, `:64`,
  real `<button>` with `aria-haspopup="true" aria-expanded="false"`), the footer social icons
  (`section-footer.php:40-43`, each with a distinct `aria-label`), the WhatsApp floating CTA
  (`inc/wave2-stage-b.php:396-401`, `aria-label` includes "(נפתח בחלון חדש)"), and the
  testimonial avatar glyph (`section-05-testimonials.php:60` /
  `template-parts/chapters/parts/testimonials.php:58`, `aria-hidden="true"` on the wrapping
  `<span>` — this one was a near-miss in my own first grep pass, which looked for
  `aria-hidden` on the `<svg>` tag itself and missed it because the attribute is one level up
  on the parent; re-checked in full multi-line context per the brief's warning about
  single-line/single-tag search).
- **Duplicate landmarks are correctly distinguished by accessible name.** `/blog/` has three
  `<nav>` elements (main menu `aria-label="תפריט ראשי"`; category filter,
  `class="ea-blog-filter" aria-label="סינון לפי קטגוריה"`; pagination,
  `class="ea-blog-pagination" aria-label="ניווט עמודים"`), and `/faq/` has two (main menu; FAQ
  topic TOC, `aria-label="ניווט נושאי שאלות נפוצות"`) — each with a distinct label, all
  confirmed live. Every fetched page has exactly one `<header>` that resolves to the
  `banner` landmark, one `<main>`, one `<footer>`; the second `<header>` element that shows up
  in the raw tag count on every page is `phero.php:23`'s `<header class="phero…">`, which sits
  nested inside `<main>` on every template — per the HTML-AAM mapping, a `<header>` that is a
  descendant of `main` does **not** resolve to a second `banner` landmark, so this is not a
  duplicate-landmark defect (verified by tracing the actual DOM nesting in
  `page-templates/tpl-chapters-en.php:46-108`, not assumed from the raw element count).
- **`html`/`dir`/`lang` are correct and consistent with content direction on every template**:
  Hebrew templates use `language_attributes()` (resolves to `lang="he-IL" dir="rtl"` — the
  9 Hebrew pages fetched all show this) rather than a hardcoded value; the EN template
  hardcodes `lang="en" dir="ltr"` (`tpl-chapters-en.php:17`) since it is intentionally not
  driven by site language. The EN page's own alt text is correctly localized in English
  (`/en/`'s one `<img>` → `alt="Eyal Amit playing the didgeridoo"`, from `:56`), not left in
  Hebrew.
- **The accessibility statement's own structural self-claims hold up under this audit** —
  cross-checked out of general diligence, though the statement's legal sufficiency is other
  lines' mandate, not mine: `inc/chapters/defaults/accessibility-defaults.php:36` claims
  "מבנה כותרות היררכי ותקין... לתמונות" (proper hierarchical heading structure) and `:38`
  claims a "דלג לתוכן" skip link "בראש כל עמוד" (at the top of every page) — both are
  consistent with what I measured above (clean heading trees sitewide; working skip link
  sitewide). This does **not** speak to the alt-text half of the same claim (`:36`), which
  A11Y-STRUCT-01 contradicts for three pages, or to any claim outside this line's mandate.

---

## 4. COULD NOT MEASURE

- **The exact generator of the `<title>` tag content and of any Yoast-driven title template.**
  `site/wp-content/plugins/` in this repo checkout contains only `wordpress-importer` — Yoast
  SEO is not present in this repository (it must be installed directly on the server/staging,
  outside version control). I measured the live `<title>` output via `curl` for all 13 pages
  (reported above and in §2/STRUCT-09) but cannot cite a theme file:line for the title
  template itself; `inc/seo-head-fallbacks.php` only controls the meta description, favicon,
  and blog author byline, not `<title>`.
- **The wp-accessibility plugin's configured skip-link target/behavior.** The brief states
  this plugin is active on the live site; like Yoast, its code is not present under
  `site/wp-content/plugins/` in this checkout, and its configuration (if any differs from the
  theme's own skip link covered above) lives in the WordPress database (options table), which
  I have no access path to from static files. I did not find any second, plugin-injected skip
  link in the live-fetched HTML of any of the 13 pages — only the one theme-provided
  `.ea-skiplink` per page — so if wp-accessibility also injects one, it was not present in what
  I fetched.
- **Anything JS-built or JS-dependent**, per the brief's own warning: the mobile nav
  burger's actual `aria-expanded` toggle behavior, the dropdown buttons' (`nav__dd`) open/close
  state, the sound-toggle button's (`#soundtg`) real effect, the testimonial carousel's runtime
  markup, and the `rcard`/reveal-on-hover interaction pattern referenced by dead code (see §6) —
  all require a live DOM/browser session to verify and are outside a static-markup pass.
  Handed to the live/keyboard/screen-reader line.
- **Whether `template-parts/chapters/parts/mag.php`, `steps.php`, and `reveals.php` are
  reachable from any current admin/editor path** (e.g. a manually-authored ACF section on a
  page not covered by the seeded defaults I read). I found zero call sites for these three
  parts across the entire live render path (`ea_chapters_page_sections()`'s generic mechanism,
  checked against every file in `inc/chapters/defaults/*.php`, plus a repo-wide literal-string
  search for `parts/mag`, `parts/steps`, `parts/reveals`) — high confidence they are dead, but
  I cannot prove a negative against ad-hoc wp-admin content I have no access to.
- **A certified HTML parse-error count** (the brief's item 8, "unclosed tags"). No W3C
  Nu Validator or `html5lib` was available in this environment; I substituted a stdlib
  tag-balance heuristic (reported in §3) which catches unclosed/mismatched tags but not every
  class of parse error a certified validator would flag (e.g. attribute-level errors, invalid
  nesting the browser tolerates silently, duplicate attributes). Treat the "0 issues" result
  as a lower bound, not a full validator pass.
- **Icon-font-based icons.** I found none in the live render path (search for common
  icon-font class prefixes across the theme returned nothing) — every icon I found is inline
  SVG. I did not audit `assets/` binary/font files directly, so I cannot rule out an icon font
  loaded but unused, only confirm none is referenced from the markup I read.

---

## 5. Recommended fixes, ordered by user impact

1. **Give the three book galleries real alt text** (A11Y-STRUCT-01) — highest impact, fully
   silent content for blind users on three whole pages. Fix in the data, not the template:
   add an `'alt'` (or, where genuinely decorative/repetitive, mark the section
   `aria-hidden`-equivalent — but these look like real content photos, so real alt text is the
   right fix) to each item in `inc/chapters/defaults/vekatavta-defaults.php:88-189`,
   `kushi-blantis-defaults.php:86-115`, `tsva-bekahol-defaults.php:78-129`. The render path
   (`template-parts/chapters/parts/gallery.php:54`) already picks up an explicit `'alt'` the
   moment one is supplied — no template change needed, only content.
2. **Give card-grid items real headings** (A11Y-STRUCT-02) — restores heading-navigation to
   three whole hub pages. Change `template-parts/chapters/parts/bookcard.php:57` from
   `<span class="bookcard__t">` to a heading element (`<h3>`, matching the level used
   elsewhere for sub-items); restyle via CSS class, not tag choice, to keep the visual
   design identical.
3. **Make the embedded FAQ heading behavior match the hub's** (A11Y-STRUCT-03) — align
   `template-parts/blocks/block-faq-list.php:45-46` (filtered/"view-only" branch) with
   `:100-101` (full branch) by wrapping the question in the same `<h3>` in both branches.
4. **Fix or remove the dead "קורסים" nav link** (A11Y-STRUCT-04) —
   `template-parts/chapters/section-nav.php:37`: either point it at a real URL now that one
   may exist, or remove the item until it does, sitewide impact for a one-line change.
5. **Hide the three decorative step icons from assistive tech** (A11Y-STRUCT-05/06) —
   `template-parts/chapters/section-07-how-to-start.php:36`: add `aria-hidden="true"` to
   `<span class="st3__ic">` (matching the convention used everywhere else in the theme); while
   in that file, consider `<ol>/<li>` for the `steps3`/`st3` structure (STRUCT-06) to expose
   "3 steps" as a real list.
6. **Wrap the two Hebrew runs on `/en/` in `lang="he"`** (A11Y-STRUCT-07) —
   `page-templates/tpl-chapters-en.php:48` and `:112`, e.g.
   `<span lang="he" dir="rtl">…</span>` around just the Hebrew portion of each string.
7. **Decide and standardize the new-window warning** (A11Y-STRUCT-08, recommendation/AAA) —
   pick one convention (the existing "(נפתח בחלון חדש)" `aria-label` suffix is already proven
   in `contact.php`/`phero.php`/`cta.php`) and apply it to `product-cta.php:54,68`,
   `tpl-chapters-en.php:104`, `testimonials.php:67`/`section-05-testimonials.php:64`, and the
   external links in the three book-defaults files and `snoring-sleep-apnea-defaults.php`.
8. **Give `/shop/` a real page title** (A11Y-STRUCT-09) — this is CMS content (the page's
   title field), not a template file; team_100 will need to change it in wp-admin (or in
   whichever seeder originally set it) rather than in a PHP file. I could not locate the
   literal string in theme code to cite a file:line for the source (see §4).
9. **Confirm `/en/`'s lack of a nav landmark is intentional** (A11Y-STRUCT-10) — no code
   change recommended unless team_100/Nimrod decide the English page should expose more of
   the site; if so, `page-templates/tpl-chapters-en.php:41-44` is where a `<nav>` would go.

---

## 6. Anything I believe the other lines will get wrong

- **`header.php` and `footer.php` (theme root) do not render on any page in the audited set,
  and probably not on any live page at all.** Every `page-templates/tpl-chapters-*.php`
  template prints its own complete `<!DOCTYPE html><html>…<head>…<body>` and never calls
  `get_header()`/`get_footer()` (confirmed by reading all 8 of them). `header.php` only runs
  if GeneratePress's own `header.php` is missing (`header.php:10-14`,
  `get_parent_theme_file_path('header.php')` — and GeneratePress **is** the declared parent
  theme, `style.css:5`), and even then it is Chapters templates that skip it entirely, not
  GeneratePress's own. A line that greps `header.php`'s skip link, `role="banner"`, or nav
  markup and reports on it is reporting on dead code. The live header/nav/footer for the
  audited page set is `template-parts/chapters/section-nav.php` +
  `section-footer.php` (or `tpl-chapters-en.php`'s own inline header/footer for `/en/`).
- **Two separate skip-link mechanisms exist in the codebase; only one is live.**
  `header.php:24`'s `.ea-skip-link` is dead (see above). `inc/wave2-stage-b.php:422`'s
  `.ea-skiplink` is the live one, but it is gated by `ea_wave2_is_active_view()`
  (`wave2-stage-b.php:61-80`), whose *first* branch (a hardcoded template-name whitelist) lists
  only pre-Chapters legacy templates and would make a reader think the skip link never fires
  on a Chapters page. It fires because of the *second* branch (`:79`,
  `get_query_var('ea_wave2_shell')`), set by `inc/chapters/chapters-routing.php`. Read the
  whole gate function, not just its first `if`, before concluding anything about the skip link
  — I nearly reported this as broken before tracing that second branch and re-verifying live.
- **`template-parts/chapters/parts/mag.php`, `steps.php`, and `reveals.php` are very likely
  dead code** (see §4) — despite `inc/chapters/acf-fields-inner.php:380` explicitly commenting
  "whom_items feeds the 'reveals' part (tpl-chapters-method.php)," the actual live
  `method-defaults.php` sections array (checked in full) does not use `'reveals'` anywhere;
  `/method/`'s "who is this for" content renders through `section-02-for-whom.php`'s own
  hardcoded markup instead. A line that audits `reveals.php`'s `tabindex="0"` focusable-`<div>`
  pattern (a real, if minor, 4.1.2 concern *if it were live*) would be auditing something no
  visitor can currently reach.
- **`/en/` does not use the Hebrew mega-menu or footer at all.** It is a separate, self-contained
  template (`tpl-chapters-en.php`) with its own two-link header and a three-line footer. A line
  that tests the primary nav's dropdown/keyboard behavior on `/en/` and reports it "missing"
  would be right that it's missing, but for the wrong reason if it assumes `/en/` reuses
  `section-nav.php` and something broke — it never included it to begin with.
- **The footer social icons (Facebook/Instagram/YouTube/TikTok, `section-footer.php:40-43`)
  all point at `/contact/`, not real social profiles.** Each icon does have a correct,
  specific `aria-label` naming the network, so this is not a structure/markup defect under
  this mandate (sighted and screen-reader users are equally misled about the destination) —
  but a line auditing link purpose might flag it as an accessibility bug when it is really a
  content/business accuracy bug that happens to sit on an icon-only link. I chose not to count
  it as an A11Y-STRUCT finding for that reason; flagging here so it isn't double-counted or
  mis-attributed.
- **`ea-contact-portrait` (`template-parts/chapters/parts/contact.php:69-70`) and the
  `start_bg` studio photo (`section-07-how-to-start.php:21-23`) are correctly implemented as
  decorative** (`alt=""` plus an `aria-hidden="true"` ancestor, exactly per the brief's own
  criterion) — I mention this because both *looked* like potential missing-alt findings from
  the live HTML dump alone (an `<img alt="">` with no other context), and only reading the
  surrounding markup showed the ancestor `aria-hidden`. A line working from live HTML/DOM
  snapshots without reading the template source could easily mis-flag either as a STRUCT-01
  style defect; they are not — verified via the source, not inferred from the HTML alone.
