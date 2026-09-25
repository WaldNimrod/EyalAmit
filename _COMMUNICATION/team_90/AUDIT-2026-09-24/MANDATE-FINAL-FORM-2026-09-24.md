# Mandate — the closing task — rebuild Eyal's form, and the books page offers — 2026-09-24

**Dictated by team_00 at the end of the live client meeting. This is the closing deliverable of the day.**

- **Repo:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` — branch `main`
- **Live staging:** `http://eyalamit-co-il-2026.s887.upress.link` — plain HTTP on purpose; certificate invalid **by design**, never a defect
- **Live theme:** 1.5.124. **Read `Version:` before bumping** — a shared counter that moved a dozen times today
- **Language:** Hebrew to Nimrod. Code comments and report in English

**Run `git status` and `git log --oneline -3` before you start and again before you deploy, and record both.** Several sessions worked in this checkout today and one silently reverted another's edits.

---

## Task 0 · The duplicated menu entries — do this first, it is visible

**team_00 raised this twice and the second message pins it exactly. Read the whole task before
touching anything — Team 90's first reading of it was wrong, and the corrected reading is below.**

**The redundancy team_00 is pointing at is the auto-generated «— עמוד ראשי» row, and it lives in
the mobile drawer.** team_00, verbatim: «יש פשוט כפתור כפול מיותר בהמבורגר — כבר יש לנו ברמה 2
כפתור לכל עמוד».

**Measured in the live drawer — every section carries one:**

    אייל עמית — עמוד ראשי            /eyal-amit/     …and «אודות אייל» already points there
    ספרים — עמוד ראשי                /books/
    טיפולים בדיג׳רידו — עמוד ראשי    /treatment/     …and «טיפול נשימה…» already points there
    שיעורים והכשרות — עמוד ראשי      /lessons/       …and «שיעורי דיג׳רידו פרטיים» already does
    כלים ואביזרים — עמוד ראשי        /shop/          …and «כלים בעבודת יד…» already does

**So four of the five sections list the same page three times:** the section header, the
«עמוד ראשי» row, and the properly-named child. **The desktop menu has no «עמוד ראשי» row at all** —
that is the difference between the two menus team_00 suspected, and it is real.

**איך** — **remove the generated «— עמוד ראשי» row. Every page keeps its own properly-named button
at level 2, which is exactly team_00's point.**

**Do NOT remove the named children.** «אודות אייל», «טיפול נשימה באמצעות דיג׳רידו»,
«שיעורי דיג׳רידו פרטיים» and «כלים בעבודת יד ואביזרים» **stay.** They are the named buttons for
those pages, and **in the drawer the section header is an accordion toggle, not a link** — so
removing both the «עמוד ראשי» row and the named child would leave those four pages unreachable from
the drawer entirely. **Verify that for yourself before you touch anything.**

**Make it a rule in the renderer, not five hand-removed rows** — this theme's recurring defect is
hand-tuned special cases, and five instances were found today.

**Do not change the desktop parents' own links** — the uniform-parent rule stays.

**One more measured defect in the same drawer — fix it while you are there.** Its six footer links
are missing their trailing slash and **all six return 301**, not 200:

    /faq  ·  /galleries  ·  /testimonials  ·  /privacy  ·  /accessibility  ·  /terms

**A menu link that redirects is a failure by this project's own criterion.** Point them at the
canonical slashed paths, and confirm each returns 200 with redirects not followed.

---

## Task A · The offers on the books page, with purchase buttons

**Context, measured — read it so you do not repeat an error Team 90 already made today.**

There is a **binding decision from 2026-07-14**, `DECISION-TEAM00-ANCHOR-FIRST-GI-BOOKS-2026-07-14.md`:
**one canon only — a Green Invoice / Morning button on the book page. No Mendele, no other store, no
alternative checkout.** The same decision assigns Eyal one duty: **«URL מדויק לכל ספר/מוצר»** — an
exact URL per book.

**Current live state, measured:** `/books/` carries **exactly one** Morning link,
`https://mrng.to/MTUiO3vkIg` — the sample created in July. **There is no per-book link, and no
purchase button on the offers section.**

**מה** — add the **מבצעים** offers to the general books page with **Green Invoice purchase
buttons**, one per offer.

**איך** — **placeholder buttons until the real links arrive.** A button must be visibly and
unmistakably a placeholder — **it must not look purchasable and must not lead anywhere that takes
money.** Do not reuse the July sample URL as if it were the real link for an offer: **that is one
specific book's link and using it for an offer would send a buyer to the wrong product.**

**Content law:** the offer titles and prices **already exist** on the books page — Team 90 measured
the bundle section and its text. **Reuse them. Do not write a new offer, a new price, or a new
description.** If an offer has no existing text, it does not ship and you report it.

**Do not touch** the three book pages' own purchase arrangements in this task.

---

## Task B · Rebuild Eyal's form — the closing deliverable

**team_00's instruction, verbatim in substance:** produce an up-to-date version of Eyal's form
containing **all the content still genuinely needed from him, and the questions that are genuinely
still open to him** — nothing else.

### B1 — Every card states which page it is about

**Each card carries a clear heading naming the page it refers to.** Today a reader has to infer it.
**The page name goes in the heading, and the live URL goes in the card**, so he can open it.

### B2 — What belongs on the form

**The test is unchanged and it is a property, not a list:** a row belongs on the form **only if at
least one of its answer options hands something over.** A row whose only options are "we will
discuss" or "I have a comment" delivers nothing and does not belong.

**Everything decided in today's meeting is already answered and must not reappear as a question.**
The answers are recorded verbatim in
`_COMMUNICATION/team_90/AUDIT-2026-09-24/MEETING-ANSWERS-EYAL-2026-09-24.md` and the decisions in
`DECISIONS-LIVE-MEETING-2026-09-24.md`. **Read both before you decide what stays.**

**New rows team_00 named explicitly:**

- **A Green Invoice link per book** — three books, plus each offer. **This is the oldest
  outstanding item on the list; it has been his since 2026-07-14.**
- **Blog column 41, «חארטה בארטה»** — measured missing from the new site, with no equivalent. Team 90
  enumerated which columns exist and this one is genuinely absent. **Ask him for it.**

### B3 — The old-site pages that need his eye

**The old site is going to be backed up and deleted.** Team 90's migration audit
(`OLD-SITE-MIGRATION-AUDIT-2026-09-24.md`) found pages that will die. **Each one that needs a human
decision gets its own card**, and each card states two things plainly:

1. **What the page's status is right now** — lives on the old site, has no equivalent on the new one,
   and will stop working when the old site is deleted.
2. **What is being asked of him** — keep it and we rebuild, or let it go.

**The cards to create:**

- **Twenty-five portfolio pages.** Titles like «Art Week 2014 Malmö», «SuperDollz Showroom»,
  «Der Spiegel Cover Art». **Team 90's read is that these are leftover WordPress theme demo content,
  unrelated to his business — but «looks like demo» is not a measurement.** Give him **two or three
  live links to glance at**, and one question: are these yours, or theme leftovers we may drop?
- **Two pages named «מופע לדוגמה»**, plus one dated show listing. Same treatment.
- **Four book galleries and one album.** **State clearly that a photo gallery is not the same thing
  as a book page** — if he wants the galleries themselves, they do not exist on the new site.
- **«סיפורים מהנייר עם אייל עמית»** — an event-series announcement with no equivalent. Keep or drop.
- **Eighty-five archive pages** (tags, categories, author pages). **One card for the whole class, not
  eighty-five cards.** These are listing pages WordPress generates, not his writing.

**Do not pre-decide any of these for him, and do not write a recommendation into the card as
though it were a finding.** State the status, state the question.

### B4 — The notes table at the end

**A table at the end of the form for free-form notes, unlimited rows.** Each row has four fields:

    עמוד  ·  נושא  ·  פרטים  ·  קובץ מצורף או קישור

**It must let him add rows without a limit**, and it must save with everything else. **The existing
form already persists to local storage under a key carrying the work-data signature — the table must
persist the same way**, or he will lose the notes exactly as he lost work once before.

**If attaching a real file is not possible in a static page, accept a link and say so in the field's
own label** — do not present an upload control that silently does nothing.

### B5 — What must not happen

- **No invented question.** Every card restates something he already wrote, approved, or was
  measured live. **Where there is nothing to restate, there is no card.**
- **No meeting items.** The form is only what he completes alone at home. Discussion rows live on
  Nimrod's board.
- **Nothing marked closed.** Rows are answered, not closed.
- **Do not lose a row on the way.** Every row you remove must still exist on the board. **Cross-check
  each one and report the mapping.**

---

## Deploy and push — authorised

`git status` · bump `Version:` after reading it · `python3 scripts/ftp_deploy_site_wp_content.py`
(**it refuses a dirty `site/` — never force past that refusal**) · commit **explicit paths only,
never `git add -A`** · push.

**Never open or commit anything under `local/`.** Do not touch `_aos/`. Leave the untracked
`scripts/save_legacy_wp_app_password.py` alone and **do not open it**.

---

## Success criteria — Team 90 measures these

- **Every card on the form names its page in the heading and carries that page's live URL**, and
  every one of those URLs returns 200 with redirects not followed.
- **Every card has at least one option that hands something over.** A card failing that property
  fails the task **even if it is on the list above** — the property governs, not the list.
- **A Green Invoice card exists per book and per offer.**
- **Column 41 has a card.**
- **The old-site cards exist**, each stating current status and the ask, with the portfolio class
  carrying two or three live links to glance at, and the eighty-five archive pages as **one** card.
- **The notes table accepts unlimited rows, with all four fields, and survives a reload.**
- **Zero rows marked closed. Zero rows lost** — every removed row still on the board, mapping
  reported.
- **The offers section on `/books/` shows purchase buttons that are unmistakably placeholders** and
  lead nowhere that takes money, and **the July sample URL is not reused as an offer's link.**
- **`assets/css/ea-tokens.css` byte-identical.** Both canons locked.

## Report

`_COMMUNICATION/team_10/DONE-FINAL-FORM-2026-09-24.md`, and **end it with the live URL of the
form** — team_00 asked for that link explicitly.

Include: the full card list with each card's page and URL, the row-by-row mapping of anything
removed, the notes-table persistence measurement, both `git status` readings, the theme version
deployed and the commit pushed.

**If any part of this turns out to be wrong, say so and do not implement it.**
