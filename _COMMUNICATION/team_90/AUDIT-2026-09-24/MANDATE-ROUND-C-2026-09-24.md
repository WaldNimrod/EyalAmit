# Mandate — round C — navigation depth, the card element, breadcrumb placement — 2026-09-24

**All three items were dictated and approved by team_00 in a live client meeting.** Team 90 (control)
re-measures every line against the success criteria below, which were written before you started.

- **Repo:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` — branch `main`
- **Live staging:** `http://eyalamit-co-il-2026.s887.upress.link` — plain HTTP on purpose. The
  staging certificate is invalid **by design**; never a defect.
- **Live theme when this was written:** 1.5.123. **Read `Version:` before you bump it** — it is a
  shared counter that has moved a dozen times today.
- **Language:** Hebrew to Nimrod. Code comments and your report in English.

**Before you start and again right before you deploy:** run `git status` and `git log --oneline -3`
and record both. Several sessions worked in this checkout today and one silently reverted another's
edits. **Re-read every file you edit afterwards to confirm your change survived.**

---

## Task 1 · «ספרים» becomes a child of «אייל עמית» — and the menu grows a third level

**מה** — «ספרים» leaves level 1 and becomes a child of «אייל עמית», positioned **after «גלריה» and
before «צור קשר»**. It keeps its own four children, **which therefore become level-3 items.**

**The resulting «אייל עמית» submenu, in order:**

1. אודות אייל
2. מוקש דהימן (the label as it now stands after the previous round)
3. המלצות → `/testimonials/`
4. שאלות ותשובות → `/faq/`
5. גלריה → `/galleries/`
6. **ספרים** → `/books/` — with level-3 children: מבצעים, צבע בכחול וזרוק לים, כושי בלאנטיס, וכתבת
7. צור קשר → `/contact/`

**Level 1 therefore drops from seven buttons to six.**

**איפה** — the tree in `inc/ea-canonical-nav.php`, and the renderer
`template-parts/chapters/section-nav.php`.

**למה this is a build and not a reorder — measured, so you are not surprised:** the renderer
currently reads `$ea_item['children']` and emits them as **one flat `<ul class="nav__sub">` of
`<li><a>`**. There is **no recursion and no grandchild support.** A third level has to be built.

**איך**

- **Make the child loop handle its own children**, so depth is data-driven rather than a third
  hand-written level. **Do not hand-code a special case for ספרים** — this theme's recurring defect
  is parallel implementations of one component, and four instances of it were found today.
- **Keyboard and screen reader are not optional.** A level-2 item that opens a level-3 list must
  announce itself the way level-1 does — `aria-haspopup` and an `aria-expanded` that actually
  changes — and must be reachable and dismissible by keyboard alone. `assets/js/ea-chapters.js`
  selects `.nav__dd[aria-haspopup="true"]`, not by tag; extend the same mechanism rather than
  writing a second one.
- **The mobile drawer reads the same source and needs the third level too.** A drawer that shows
  only two levels while the desktop menu shows three is a worse outcome than not shipping this.
- **Respect the existing `hidden` flag** (`S007 M-14`) at every depth — «קורסים דיגיטליים» is in
  the tree and must stay unrendered.

**Touch — measured today, and it collides with this task.** The previous round made every level-1
parent a link, and `assets/js/ea-chapters.js` listens only for mouse and focus events: **it has no
first-tap handling at all.** On a phone, tapping a parent navigates straight to its target instead
of opening the submenu.

**With two levels that was a nuisance. With three it may mean a touch user can never reach level 3
at all** — and the four book pages would then be unreachable from the menu on a phone.

**Measure this explicitly on a real touch-emulated viewport and report what you find.** If level 3
is unreachable by touch, **say so plainly and do not paper over it** — a menu that works on a laptop
and hides four pages on a phone is worse than the flat menu it replaced. **Do not redesign the touch
behaviour on your own initiative; report it, because it is team_00's call.**

**Report honestly how a three-level menu behaves overall.** It is the hardest menu shape to operate.
**If it turns out badly, say so; team_00 decides whether to keep it, not you.**

---

## Task 2 · The «חדש באתר» card element

**מה** — a row of cards, placed **immediately after the hero**, on two pages.

**On the books page** — one card per book, plus a card for מבצעים.
**On the home page** — four cards: טיפול בנשימה, דום נשימה, שיעורים, תיקון כלים.

**איפה** — the books page `/books/` and the home page `/`.

**A finding you must not trip over:** two theme files are named `block-books-row.php` and
`block-services-row.php`. **Neither renders cards** — both are prose sections with hard-coded copy
about the studio, **and neither is used by any template.** They are dead code. **Do not extend them
and do not assume they are a starting point.** Team 90 searched the whole repository for a prior
sketch of this element in seven phrasings and found nothing. **You are building it new.**

**איך — and this is the content-law rule of this round.**

**The card text is not yours to write.** Each card takes the **existing `meta description` of the
page it points to, verbatim.** All four home-page targets already have one, and Team 90 verified
each is present:

    /treatment/            /snoring-sleep-apnea/            /lessons/            /repair/

For the books, take each book's existing title and its existing description from the theme's own
book data. **The מבצעים card points at the anchor that already exists on the books page.**

**Where a source sentence does not exist, the card ships without that line and you report it.**
**Do not compose a card headline, a teaser, a call to action label, or a "new on the site" strapline.**
An invented sentence has already reached this client once on this project.

**Trim, do not rewrite.** If a description is too long for a card, shorten it **by truncating at a
clause boundary**, never by rephrasing. Report every card whose text you trimmed.

**Layout:** cards must work at phone width, and the element must not push the hero off screen.
**No colour token and no font-size token may change** — both canons are locked.

---

## Task 3 · Breadcrumbs in the classic position

**מה** — team_00: the breadcrumb currently renders **inside the hero**, and that is nice but **does
not discharge the requirement** to place it in the classic position — **right-aligned, immediately
after the hero, consistently on every page.**

**איפה** — `inc/ea-breadcrumbs.php`, its four call sites, and
`assets/css/ea-breadcrumbs.css`. Team 90 measured the current DOM: the breadcrumb sits **inside the
`<header>`**, i.e. within the hero.

**A measured gap you must close as part of this — the requirement says "every page", and today it
is not.** Team 90 swept twenty page families. **Three carry no breadcrumb at all:**

    /shows-heritage/        /historical-articles/        /qr/qr20/   (the whole printed-code family)

`/` has none either, which is correct — the home page is the root.

**איך**

- Render the breadcrumb in the classic position: **right-aligned, directly below the hero, before
  the main content, the same on every page.**
- **Extend it to the three families that have none.** The printed-code pages are their own template
  family — check it explicitly rather than assuming the shared header covers it.
- **Exactly one breadcrumb may be exposed to assistive technology per page, and exactly one
  `BreadcrumbList` may exist in the structured data.** If you keep the in-hero one as decoration,
  it must be hidden from the accessibility tree and must not emit a second `BreadcrumbList`.
  **State plainly in your report which choice you made** — moved it, or kept both with one exposed —
  so team_00 can confirm the visual result.
- **«בית» stays the first link.** team_00 removed «בית» from the menu specifically because the
  breadcrumb always carries it. **Breaking that would silently remove the only path home.**

**Do not change the breadcrumb's contrast or colour.** One known bug is deliberately unfixed and is
recorded for a meeting decision: of four `ea_breadcrumbs_render()` call sites, only
`inc/wave2-w2-07.php:940` omits `array( 'dark' => true )`. **Leave it. Do not fix it in this round**
— but if your change moves that call site, **say so**, because it affects that open item.

---

## Deploy and push — authorised

1. `git status` first.
2. Bump `Version:` in `style.css` — **read the current value first.**
3. `python3 scripts/ftp_deploy_site_wp_content.py`. **It refuses a dirty `site/` — never force past
   that refusal.** If it refuses, stop and report.
4. Commit **explicit paths only. Never `git add -A` or `git add .`.** Then push.

**Never open or commit anything under `local/`.** Do not touch `_aos/`. Leave the untracked
`scripts/save_legacy_wp_app_password.py` alone and **do not open it**.

---

## Success criteria — Team 90 measures these

**Navigation**
- **Six** level-1 buttons. «ספרים» is not among them.
- «אייל עמית» has **seven** children in the stated order, and «ספרים» among them carries **four**
  level-3 children.
- **Every menu link returns 200**, redirects not followed. **A menu link that 301s is a failure.**
- **Every opener at every depth carries `aria-haspopup` and an `aria-expanded` that actually
  toggles**, measured on the rendered page.
- **The mobile drawer shows all three levels.**
- «קורסים דיגיטליים» still does not render, and `/learning/courses-external/` still returns 200.
- **Exactly one Chapters primary nav per page**, across all published URLs. A template change has
  taken this whole site down once already in this project.

**Cards**
- The element renders immediately after the hero on both pages, at desktop and phone width.
- **Every card's text appears verbatim in that page's existing `meta description`** or in the
  theme's own book data. Team 90 cross-checks automatically. **One sentence without a source fails
  the task.**
- Every card links to a URL returning 200.

**Breadcrumbs**
- Present and painted, right-aligned below the hero, on **every** published page except the home
  page — **including the three families that have none today.**
- **«בית» is the first link on every one of them.**
- **Exactly one `BreadcrumbList` per page**, and exactly one breadcrumb in the accessibility tree.

**Everywhere**
- **`assets/css/ea-tokens.css` byte-identical.**
- The four footer social links still point at the real profiles, not at `/contact/`.

## Report

`_COMMUNICATION/team_10/DONE-ROUND-C-2026-09-24.md`. Per task: the live URL, the status code, and
the measurement that proves it — not a description of what you changed. Include the rendered
level-1 list, the full «אייל עמית» submenu with its level-3 items, the card-text source mapping
per card, the breadcrumb placement decision, both `git status` readings, the theme version
deployed and the commit pushed.

**If any part of this turns out to be wrong, say so and do not implement it.** Refusals with a
measurement behind them have already saved this project twice today.
