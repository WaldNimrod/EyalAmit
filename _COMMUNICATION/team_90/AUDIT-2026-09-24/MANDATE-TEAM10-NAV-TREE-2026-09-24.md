# Mandate — implement the approved navigation tree — 2026-09-24

**Approved by team_00 (Nimrod) in a live client meeting.** The tree was dictated in five cumulative
amendments; the version below is the final accumulated one. **Nothing here is open to interpretation
— if something seems missing, it was decided and recorded, so ask rather than infer.**

- **Repo:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` — branch `main`
- **Live staging:** `http://eyalamit-co-il-2026.s887.upress.link` — plain HTTP on purpose. The
  staging certificate is invalid **by design**; never a defect.
- **Approval record, with every target measured live:**
  `_COMMUNICATION/team_90/AUDIT-2026-09-24/NAV-TREE-FOR-APPROVAL-2026-09-24.html`
- **Decision record:** `_COMMUNICATION/team_90/AUDIT-2026-09-24/DECISION-NAV-TREE-2026-09-24.md`
- **Language:** Hebrew to Nimrod. Code comments and your report in English.

## ⚠ Read this before you touch anything

**Another builder session has been running in this same checkout today, and it silently reverted a
different agent's edits mid-flight.** That agent had to detect the loss and re-apply its work.

Therefore, **before you start and again immediately before you deploy**:
1. Run `git status` and `git log --oneline -3`. **Record both in your report.**
2. **Re-read every file you edited** and confirm your change is still there.
3. If your edit has vanished, **re-apply it and say so** — do not assume it landed.

**Two files in the working tree carry another team's completed, uncommitted work** —
`template-parts/chapters/section-footer.php` and `template-parts/blocks/block-footer-social.php`
(the social-media links). **Do not revert them, do not "clean" them, and do not exclude them from
your deploy.** They are meant to ship.

## The approved tree — seven top-level buttons, right to left

**1 · אייל עמית** → `/eyal-amit/`
  1. אודות אייל
  2. מוקש דהימן — לזכרו
  3. צור קשר → `/contact/`

**2 · טיפולים בדיג׳רידו** — a new parent button
  1. טיפול נשימה באמצעות דיג׳רידו → `/treatment/`
  2. סאונד הילינג → `/sound-healing/`
  3. טיפול בנחירות ודום נשימה בשינה → `/snoring-sleep-apnea/`

**3 · שיעורים והכשרות**
  1. שיעורי דיג׳רידו פרטיים → `/lessons/`
  2. הכשרות למטפלים → `/learning/therapist-training/`
  3. קורסים דיגיטליים → `/learning/courses-external/` — **hidden until the content is ready**
  4. הרצאות → `/learning/lectures/`
  5. סדנאות דיג׳רידו → `/learning/workshops/`

**4 · השיטה** → `/method/`

**5 · כלים ואביזרים** → `/shop/` — **children unchanged**, all six: כלים בעבודת יד ואביזרים,
תיקון וחידוש כלי דיג׳רידו, כלי דיג׳רידו למכירה, תיקים לדיג׳רידו, סטנדים לאחסון דיג׳רידו,
סטנד רצפתי לנגינה.

**6 · ספרים** → `/books/` — **children unchanged**, all four: מבצעים, צבע בכחול וזרוק לים,
כושי בלאנטיס, וכתבת.

**7 · בלוג דיג׳רידו** → `/blog/`

**All fourteen targets were fetched live by Team 90 today and every one returned 200.**

## What changes, stated so you cannot misread it

- **אייל עמית moves from last to first.**
- **צור קשר drops from level 1 to level 2**, becoming the third and last child of אייל עמית.
- **«שיעורי דיג׳רידו» and «לימוד והכשרה», two separate level-1 buttons today, merge** into one
  button «שיעורים והכשרות» with five children.
- **«סאונד הילינג» stops being a level-1 button** and becomes a child of the new
  «טיפולים בדיג׳רידו».
- **«טיפול בדיג׳רידו», level 1 today, becomes a child** of that same new button, relabelled
  «טיפול נשימה באמצעות דיג׳רידו».
- **«השיטה» stays at level 1**, positioned after the two service buttons.
- **The «בית» item is removed from the menu.** Decided: the logo click covers it, **and the
  breadcrumb element always shows «בית».** Team 90 verified this in a rendered browser on three
  pages — `nav.ea-crumb` is visible, carries links, paints at 22.17px, and «בית» is its first link
  on all three. **Do not remove or alter the breadcrumb.**
- **Level-1 count drops from eleven to seven.**

## Labels that change — copy them exactly

    שיעורי דיג׳רידו            →  שיעורי דיג׳רידו פרטיים
    סדנאות                     →  סדנאות דיג׳רידו
    קורסים                     →  קורסים דיגיטליים
    נחירות ודום נשימה בשינה    →  טיפול בנחירות ודום נשימה בשינה
    טיפול בדיג׳רידו            →  טיפול נשימה באמצעות דיג׳רידו
    לימוד והכשרה + שיעורי דיג׳רידו  →  שיעורים והכשרות

**Do NOT change «סאונד הילינג».** The owner dictated the spelling «סאונדהילינג» as one word;
Team 90 recorded that a change to the spelling of a service name is a brand decision, not a fix,
and **it was not approved. Keep the current two-word spelling.**

## The courses item

**«קורסים דיגיטליים» is the existing page** `/learning/courses-external/`. Its content is not ready.
Eyal's own answer today was «להשאיר מחוץ לתפריט», and Nimrod's ruling is that it is **hidden in the
menu until the content is ready.**

**So it must not be visible in the rendered menu.** Keep its place in the tree structure so it can
be restored in one step later, but **it does not render.** In practice «שיעורים והכשרות» shows
**four** children.

## Where

`site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php` — this is the **single source** every
renderer reads: the Chapters nav, the Wave2 header, GeneratePress's header and the mobile drawer.
**Change the tree there and nowhere else.** Do not hand-edit a second copy into any template — this
theme's recurring defect is exactly that, two parallel implementations of one component.

## Rules that override your judgement

**1 — Canons are locked.** No colour token, no font-size token. This is a structural change only.

**2 — Do not invent a page.** Every item above maps to a page that exists and returns 200. **If a
target does not resolve, stop and report — do not create a page and do not point the item
somewhere plausible.**

**3 — Verify on the rendered page.** A tree in PHP is not a menu on screen. After deploying, fetch
real URLs and read the rendered nav, and **check the mobile drawer too** — it reads the same source
and is where a broken tree shows up first.

## Deploy and push — authorised by team_00

**You are authorised to deploy and to push.** Sequence:

1. `git status` first. **Confirm the two social-media files are present and intact.**
2. Bump `Version:` in `site/wp-content/themes/ea-eyalamit/style.css` — **read the current value
   first**, it is a shared counter that has moved several times today.
3. `python3 scripts/ftp_deploy_site_wp_content.py`. **It refuses a dirty `site/` — never force past
   that refusal.** If it refuses, stop and report; do not pass an override flag.
4. Commit **explicit paths only. Never `git add -A` or `git add .`.**
5. Push.

**Never open or commit anything under `local/`.** Do not touch `_aos/`. There is an untracked
`scripts/save_legacy_wp_app_password.py` — **leave it and do not open it.**

## Success criteria — Team 90 measures these, and they were written before you started

- **Seven level-1 items, in the exact order above**, on the rendered page.
- **«בית» is not among them.**
- **The breadcrumb still renders** with «בית» as its first link on `/books/tsva-bekahol/`,
  `/learning/lectures/` and `/repair/`, with a painted height above zero.
- **«קורסים דיגיטליים» does not appear in the rendered menu**, and
  `/learning/courses-external/` still returns 200 at its direct URL.
- **Every remaining menu link resolves to 200**, redirects not followed. **A menu link that 301s is
  a failure** — point it at the live destination.
- **Exactly one primary nav per page**, across every published URL. A template change has taken this
  whole site down once already in this project.
- **The mobile drawer shows the same seven items in the same order.**
- **`assets/css/ea-tokens.css` is byte-identical** to its current state.
- **The four social links in the footer still point at the real profiles**, not at `/contact/` —
  i.e. you did not revert another team's work.

## Report

Write `_COMMUNICATION/team_10/DONE-NAV-TREE-2026-09-24.md`: the rendered level-1 list in order, the
status code of every menu target, the nav count on at least five pages, the theme version you
deployed, the commit hash you pushed, and your two `git status` readings — before and after.

**If any part of this turns out to be wrong, say so and do not implement it.** A refusal with a
measurement behind it has already saved this project twice today.
