# פרומט משלים לצוות 110 — אחרי הבדיקה החוזרת — להעתקה מתחת לקו

---

You are the **builder** on EyalAmit.co.il-2026, continuing the pre-meeting fix round.

Your previous round was re-measured by Team 90 against a bar written before your work came back.
**It passed.** All fourteen built tasks stand, and the site-wide content-law sweep came back clean —
710 images, 539 non-empty alts, **zero** unsourced factual assertions. That was the highest-risk
check of the round.

**Two things you did are worth repeating.** You refused task 5 with a measurement behind you, and
you were right — Team 90 re-measured in a rendered browser and the breadcrumb component has existed
since 2026-09-21. **The task we sent you was based on our error, not your omission.** You also
reported the old Mukesh remote directory as still present instead of quietly leaving it out.
**Both are exactly the behaviour this process needs.**

This supplement covers **three gaps found during that re-measurement that were not on your list.**

- **Repo:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` — branch `main`
- **Live staging:** `http://eyalamit-co-il-2026.s887.upress.link` — plain HTTP on purpose. The
  staging certificate is invalid **by design**; never a defect, never a thing to fix.
- **Current live theme:** 1.5.116. **Read `Version:` in `style.css` before you bump it** — it is a
  shared counter and another session may have moved it.
- **Language:** Hebrew to Nimrod. Code comments and your report in English.

## The three rules that still override your judgement

**1 — Content law.** Remove invented text, restore Eyal's own words. **Write no new copy** — not a
sentence, not a caption, not a description. Where his words do not exist, use the neutral label the
task names and report it. **Task 3 below is the one that will tempt you. Read its guard rail twice.**

**2 — The canons are locked.** No typography token, no colour token. **The contrast section is still
on hold** pending Nimrod's approval of the map. Do not touch it.

**3 — Verify on the rendered page.** A lint is not a render, a diff is not a render, and a count of
elements in HTML is not a render. Read a box only **after** layout settles — a
`getBoundingClientRect` taken too early returns zeros, and zeros look exactly like a defect. **Do
not follow redirects** when checking a URL's health.

---

## Task 17 · `/thank-you/` draws the primary navigation twice — **the only build task here**

**מה** — The page emits the primary nav **twice, back to back**. Both copies carry `id="nav"`, which
is invalid HTML and makes a screen reader announce two identical main menus.

**איפה** — `http://eyalamit-co-il-2026.s887.upress.link/thank-you/`.
Measured: `<nav class="nav" id="nav"` appears **2** times; the second begins 4,422 bytes after the
first, with no wrapping element between them and nothing hiding either. `/contact/` returns **1**.

**למה** — **This is the page a visitor lands on after submitting the contact form.** If Eyal
submits the form during the meeting, this is what he sees. It is also the only exception in a sweep
of all 153 published URLs: 137 returned 200, and **136 of them carry exactly one nav.**

**איך** — Two code paths both emit this nav, and you need to find which pair fires on this page
before you change anything:

1. `inc/ea-open-round.php:87` — `ea_open_round_inject_chapters_nav()` runs on `wp_body_open` for
   every slug in `ea_open_round_chrome_slugs()`, and `thank-you` is in that list.
2. Every `page-templates/tpl-chapters-*.php` **also** calls
   `get_template_part( 'template-parts/chapters/section', 'nav' )` directly.

**A complication you must not skip past:** the live body class on this page is
`page-template-default`, i.e. it is **not** running a `tpl-chapters-*` template — so the simple
"hook plus template" explanation does not fit on its face. **Find the actual second emitter before
you patch.** Do not assume.

**The correction we expect is a render-once guard, not a removal.** Removing one call site fixes
one page and leaves the same trap for the next one. A static flag inside the nav partial that makes
a second render a no-op closes it regardless of which path fires twice.

**Do not** change the nav's markup, its items, or its order. **The nav tree is canonical** — it
lives in `inc/ea-canonical-nav.php` and feeds every renderer. This task is about how many times it
is printed, nothing else.

**Prove it** with the rendered page: the count of primary navs on `/thank-you/`, **and the same
count on at least four other pages** to show you did not break the nav everywhere. **A template
change has taken this whole site down once before in this project.**

---

## Task 18 · The meeting rows are on both surfaces but cannot be used at the meeting

**מה** — All nine rows you routed **are** on Eyal's form under «לפגישה, לא למילוי» with no input
fields, and on Nimrod's board. **Your report on this was accurate and the placement is right.**

What is missing is the second half of Nimrod's rule: a row must carry the context and links to
**decide**, not guess.

- **Seven of the eight carry no link at all** to the page they discuss. Only `Q-REPAIR-ALT` links
  `/repair/`.
- `Q-SHOWS` refers to `A2` and `E4` — **bare internal ids with no gloss.** A reader who is not
  inside this audit cannot know what they are.
- `Q-G07` cites "the 17 notes of 18.9 at 11:58" with **no source and no link.**
- On the board, **86 items are addressable sections with their own id. These eight are `<li>` rows
  inside one shared list** — not linkable and not anchorable.

**איפה** — the renderer `scripts/s007_render_work_ssot.py`, and the `questions[]` entries in
`_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json`.

**למה** — Nimrod reviews by opening things. A row he cannot open is a row he has to reconstruct
from memory in front of the client.

**איך** — For each of the eight: **add the live URL of the page it names**, and **expand every bare
internal id into the words it stands for.** On the board, give each one its own addressable section
like `Q-REPAIR-ALT` already has, so it can be linked and jumped to.

**⚠ The guard rail — this is the content-law trap in this supplement.** You are adding **links and
id expansions only.** You are **not** writing a better description of the issue, not rephrasing the
question, and not adding options that nobody decided. **If a row is unclear because the underlying
decision is unclear, leave it unclear and say so in your report.** An id expansion means replacing
`A2` with the title `A2` already carries in the work data — not inventing a summary of what `A2` is
about.

---

## Task 19 · `/shows-heritage/` share card reads «ניווט משני.»

**מה** — You removed the internal marker from the visible body, correctly. But the page's
`og:description` is now the literal string «ניווט משני.» — so sharing the URL previews the words
"secondary navigation".

**איפה** — `/shows-heritage/`, the meta layer: `inc/seo-head-fallbacks.php` and
`mu-plugins/ea-w2-seo-schema.php`. The page's `meta description` is a real sentence about heritage
and performances; **only the `og:description` carries the stray value.**

**למה** — **Eyal shares his pages in WhatsApp.** That is the reason the og:description task existed
at all. Your report said the marker was removed "from the body and from the share card" — the first
half is true, the second is technically accurate and practically misleading.

**איך** — **Fall back to that page's existing `meta description`, exactly as task 11 did for the
other six pages.** Same mechanism, same rule: **do not write a new sentence.** The page's meta
description already exists and is correct.

**Do not** change the page's published status, its `noindex`, or its sitemap entry. **Those are
Nimrod's calls and they are already recorded for the meeting.**

---

## Task 20 · Put the contrast map on Nimrod's board, with openable examples

**This task changed on 2026-09-24 by team_00's instruction. Read the change before you read the
task.** The contrast map was previously held, waiting for an approval that would turn it into a
build. **It is no longer a build task and you are not fixing any contrast.** team_00's ruling:

> «המיפוי צריך להופיע בלוח עם דוגמאות — בפגישה נבחן את המצבים בפועל בדפדפן ונקבל החלטה.»

So the map becomes a **meeting item, reviewed live in a browser, decided in the room.** Your job is
to make that review possible. **Change no colour, no token, no scrim, no CSS.**

**מה** — Render the contrast map onto Nimrod's board as meeting rows, each one openable.

**איפה** — Source of truth: `_COMMUNICATION/team_90/AUDIT-2026-09-24/CONTRAST-MAP-2026-09-24.md`.
Route it the way every other row is routed: entries in
`_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json`, rendered by
`scripts/s007_render_work_ssot.py` onto `content-gaps-2026-09-21/GALLERY.html`.

**למה** — Nimrod and Eyal will decide these at the meeting by **looking at the real pages**. A row
they cannot open is a row they have to argue about from memory. This is also the direct lesson of
task 18 above.

**איך — nine rows, each its own addressable section.**

**Do not put all nine inside one shared list.** That is exactly the defect task 18 exists to fix:
86 board items are addressable sections with their own id, and the eight meeting rows are `<li>`s
nobody can link to. **These nine must be sections, like `Q-REPAIR-ALT` is.**

Each row carries, and nothing more:

- **The element in plain Hebrew** — what a person sees on screen, not the CSS class alone.
- **One representative live URL, as a clickable link** — the case to open in the meeting.
- **The measured worst ratio and the threshold it is judged against.** Both numbers, always: the
  threshold is size-dependent and a bare ratio is not a verdict.
- **How many of the 153 published pages carry the element**, and how many were pixel-measured and
  failed. **Keep the measured/inferred distinction** — it is the difference between evidence and
  extrapolation.
- **The proposed direction only** — a background or scrim change; for row 3, a missing function
  argument. **No colour token and no type-scale value is in scope**, per the locked canons.
- **A line stating this is a decision, not an approved build.**

**The nine, worst first, with their representative URLs:**

1. `.ea-crumb__link` — the terracotta "בית" link inside the breadcrumb. 1.41:1 against 4.5:1.
   On 100 of 153 pages; 36 of the 58 measured fail. Open `/sound-healing/`.
2. `.chap` — the small eyebrow label above the H1. 1.04:1 against 4.5:1. On 116 of 153 pages; 29 of
   the 31 measured fail. Open `/contact/`. **This is the element team_00's original pushback was
   about — it belongs high on the board, not buried.**
3. `.ea-crumb` on `/press/` — dark text on a dark background. **One page, and a different kind of
   defect from the rest: a one-line code bug, not a design judgement.** Of four
   `ea_breadcrumbs_render()` call sites, only `inc/wave2-w2-07.php:940` omits `array( 'dark' => true )`;
   `section-hero.php:38`, `parts/phero.php:44` and `parts/mokesh-hero.php:30` all pass it.
   **Record it as a row. Do not fix it in this round** — it is on the board so the room sees that
   one of the nine is a typo and the other eight are choices.
4. `.bleed__a` — the attribution line under a pull-quote over a full-bleed photo. 1.06:1 against
   4.5:1. 6 pages; 5 of 5 measured fail. Open `/services/didgeridoo-treatment-breath/`.
5. `.ea-crumb__item` / `.ea-crumb__current` — the plain white breadcrumb text. **Ranges 2.38–12.63:1
   and 2.43–12:1 — it passes almost everywhere and dips only over hot spots in some photos.**
   Open `/eyal-amit/`. **Write the range, not the worst number alone.** team_00 already ruled this
   text fixed, and it is: a single worst-case figure here would reopen a settled decision and would
   be misleading.
6. `.phero__h` — the inner hero H1. 2.02:1 against **3:1** (large text). On 149 pages; only 3 of 60
   measured fail. Open `/lessons/`.
7. `.phero__s` — the inner hero subtitle. 3.10:1 against 4.5:1. On 99 pages; 4 of 59 measured fail.
   Open `/lessons/`.
8. `.hero__trust` — the trust line above the homepage video hero. 3.15:1 against 4.5:1. 1 page.
   Open the homepage.
9. `.cmpc__p` — body text in the homepage comparison card. 4.22:1 against 4.5:1. 1 page. Open the
   homepage. **It misses by 0.28 — say so, so the room can price it accordingly.**

**Plus three rows that are not failures and must still be visible:**

- **What passes** — Section 2 of the map. **Its whole purpose is to stop settled elements being
  re-opened in the room.** One row, listing them.
- **Borderline** — Section 3. Things within 1.2× of the threshold that pass today, e.g. `.dd__tag`
  at 4.63:1, 2.9% above the floor. **Flagged, not judged.**
- **Not measurable** — Section 4, and why: a template with no live instances, closed accordions,
  hover states, mobile widths. **Declared, not omitted.** A gap nobody can see is the one that
  surfaces in the room.

**On Eyal's form: nothing.** Not nine rows, not one summary line, nothing. **See task 21** — the
meeting section is being removed from the form entirely. Contrast is Nimrod's decision and lives
only on the board.

**Guard rails.** Do not re-measure and do not "improve" a number — the map's figures were produced
by a pixel-measurement pass that caught and fixed three of its own measurement bugs, and a
freehand re-derivation will not match. **Copy the numbers.** If a figure looks wrong to you, report
it; do not silently correct it. **And do not add an element to the list that is not in the map.**

**Prove it** by giving the board URL and the count of contrast sections rendered, plus two of the
representative links fetched live with their status codes.

---

## Task 21 · Take every meeting item off Eyal's form — **highest priority in this supplement**

**team_00 reviewed the live form on 2026-09-24 and ruled:**

> «כל סעיפי הפגישה — נכונים, אבל זה לא המקום שלהם. הטופס זה נטו מה שאייל צריך להשלים לבד בבית
> לפני הפגישה. כל סעיפי הפגישה צריכים להופיע בלוח שלי ולא בטופס של אייל.»

**The content is right. The placement is wrong.** Nothing here says a row is inaccurate — the test
is now one question, applied to every row: **can Eyal finish this alone, at home, before the
meeting?** If yes it stays on the form. If it needs the two of them in a room, it belongs on the
board and only on the board.

**מה** — Remove every discussion item from Eyal's form. Keep them all on Nimrod's board.

**איפה** — `_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json` routing, rendered by
`scripts/s007_render_work_ssot.py` to the form and the board. **This is a routing change, not a
content change.** Do not rewrite a single row's text.

**איך — two groups come off, and the second one is not obvious.**

**Group 1 — the whole «לפגישה, לא למילוי» section.** All eight rows: `Q-SHOWS`, `Q-FAQ-HOME`,
`Q-A11Y-STMT`, `Q-G04`, `Q-G06`, `Q-G07`, `Q-TALK-8`, `Q-MOKESH-OLD`. **Delete the section from the
form.** They are `waitingOn: nimrod` and already render on the board — **confirm each is there
before you remove it from the form**, and make it addressable per task 18. **Do not delete the
rows themselves. They move, they do not disappear.**

**Group 2 — six of the eight items in «חלק י · לשיחה».** This group is the reason to read the
options and not the heading. Measured on the live form:

- `M1` — «נדבר בשיחה» · «יש הערה על העץ»
- `M2` — «נדבר בשיחה» · «יש הערה על התבנית»
- `M3` — «נדבר בשיחה» · «יש הערה»
- `M5` — «נדבר בשיחה» · «יש הערה»
- `M6` — «נדבר בשיחה» · «יש הערה»
- `M7` — «נדבר בשיחה» · «יש הערה»

**Neither option on any of these six delivers anything.** They are discussion items wearing input
fields. **They come off the form and stay on the board.**

**`M8` and `M9` stay.** Their first option is a real deliverable — `M8` «אשלח סרטונים», `M9`
«אשלח קובץ» — which is precisely something Eyal does alone at home. **Keep them, and move them out
of a part titled «לשיחה», which no longer describes them.**

**What remains on the form afterwards — eleven items:**
`A3`, `A5`, `B2`, `B3`, `C1`, `C3`, `P037`, `Q-HERO-ASK`, `M8`, `M9`, `Q-REPAIR-ALT`.
**Every one of them has at least one option that hands something over.** Verify that property
yourself, per row, before you call this done — **that property is the acceptance test, not my list.**

**למה** — A form that mixes "send me the photos" with "let's discuss the menu tree" teaches its
reader that some rows need no action, and the rows that do need action get skimmed with them.
**The cost is the deliverable of the meeting**, which is exactly what the form exists to protect.

**Do not** change any row's wording, its options, its `waitingOn`, or its status. **Do not** mark
anything closed. **A moved row is not an answered row.**

---

## Task 22 · Two rows ask for something the control cannot express

**Separate from placement, and do not fold it into task 21.** These two stay on the form — they are
things Eyal does alone — but as built he cannot actually answer them.

**`Q-REPAIR-ALT`** asks for **a short sentence for each of five photographs**, and identifies them
as `EA-000239`, `EA-000298`, `EA-000214`, `EA-000238`, `EA-000220`. Measured: **the form contains
zero `<img>` tags — no thumbnail anywhere.** It links `/repair/`, but that page shows **nine**
images and nothing maps an internal id to a photo. The answer control is **«מאושר» / «יש הערה»** —
one binary, for five separate captions.

**איך** — show the five photographs, or name each one in words so it is identifiable on the page,
and give **a separate text field per image**. **Do not write a caption, not even a draft, and not
even a placeholder** — that is the whole point of the row. If a thumbnail cannot be embedded, a
direct link to each image file is acceptable.

**`P037`** carries the stamp «אייל ישלח אם יש» — a deliverable — but its options are
«מאושר» / «יש הערה», which express neither sending nor not having one. **Report what you find here
and propose the option set; do not invent a new question.**

**למה** — A row he cannot answer produces a blank, and a blank is indistinguishable from a row he
chose not to answer. **This is the row most likely to come back empty and be read as agreement.**

---

## What is deliberately NOT yours in this supplement

- **Fixing any contrast.** Task 20 puts the map on the board for a decision in the room. **The fix
  itself is not in this round and is not yours to start.**
- **The contact mail** — the destination is correct in code. What is missing is a receipt for the
  second message, and a receipt is not something you can build. **Do not re-send a test message and
  do not change the recipient.**
- **The accessibility statement** — still last, still waiting on the contrast decision and on
  Nimrod's approval of wording before paste.
- **The homepage FAQ block** — still waiting on how many and which.
- **The old Mukesh remote directory**, which you correctly reported is still served at its old URL
  although no page links to it. **Leave it. Report it again if you like, but do not delete files on
  the server in this round.**

## Two open doubts — report, do not resolve

**Do not fix these. Measure them and tell us what you find**, so they land on a surface:

1. **`mokesh-eyal.jpg` carries two different alts on two different pages** —
   «מוקש דהימן עם אייל עמית ברישיקש, הודו» on the memorial page, which matches the theme default,
   and «אייל עמית עם המאסטר מוקש דהימן ברישיקש, הודו» on `/eyal-amit/`, which matches nothing.
   Same facts, different wording. **Find where the second one is defined.** Do not rewrite either.
2. **`/services/` returns 404**, yet the slug `services` is still listed in
   `ea_nav_drawer_orphan_slugs()` and `ea_open_round_chrome_slugs()`. Harmless today. **Confirm
   whether that page exists at all**, and report. Do not remove the slug on your own.

## The standing instruction — it still outranks the task list

**Every gap that goes back to Nimrod or to Eyal must be recorded in BOTH surfaces: Eyal's form and
Nimrod's board.**

> **"No embarrassments" means no gap that has not been fixed, or recorded for the meeting, or placed
> in Eyal's form. When every item on the form and every item for the meeting has an answer, the
> site is ready to go live.**

**If you hit a gap that is not in this supplement — do not quietly fix it and do not skip it.
Report it.** A gap you fixed but nobody recorded looks exactly like a gap that never existed.

## Practical constraints

- **Never open or commit anything under `local/`** — it holds credentials.
- **`_aos/` is a read-only snapshot.** Never edit inside it.
- **Never `git add -A` or `git add .`** — stage explicit paths only. Other sessions share this
  checkout.
- **Deploy:** `python3 scripts/ftp_deploy_site_wp_content.py` ships the working tree and **refuses a
  dirty `site/`**. That refusal protects another session's uncommitted work — **never force past
  it.**
- **There is an untracked file `scripts/save_legacy_wp_app_password.py` in the working tree. Do not
  commit it and do not open it.**

## Report back

Append to `_COMMUNICATION/team_10/DONE-PRE-MEETING-FIXES-2026-09-24.md`, or write a second file
beside it.

Per task: **the live URL, the status code, and the measurement that proves it is closed** — not a
description of what you changed. For task 17, the nav count on `/thank-you/` **and on four other
pages**. For task 19, the `og:description` value fetched live.

**If a task turns out to be wrong, say so and do not implement it.** You were right to refuse once
already today, and that refusal is the reason we caught our own false finding. **A task you refuse
with a measurement behind you is a good outcome. A task you implement on a premise that was wrong
is not.**

**If you cannot finish everything, stop and report where you got to.** Team 90 re-measures this work
before the meeting, against a bar that is already written.
