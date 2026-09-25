# Mandate — builder round from Eyal's live meeting answers — 2026-09-24

You are the **builder** on EyalAmit.co.il-2026. These five tasks come from answers Eyal gave in a
live meeting today. **Team 90 (control) re-measures every line of this before you are done, against
the success criteria written below — which were written before you started and will not be changed
to fit your result.**

- **Repo:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` — branch `main`
- **Live staging:** `http://eyalamit-co-il-2026.s887.upress.link` — plain HTTP on purpose. The
  staging certificate is invalid **by design**; a certificate warning is never a defect.
- **Live theme:** 1.5.118. The working tree is currently ahead of it and **uncommitted**.
- **Language:** Hebrew to Nimrod. Code comments and your report in English.

## Four rules that override your judgement

**1 — Content law. This is the rule this round will be judged on.** You may **move** text that
already exists and you may **restore** Eyal's own words. You may **not write new copy** — not a
sentence, not a caption, not a heading, not a summary. Tasks 2 and 4 are both transfers from the
old site, and both will tempt you to tidy a sentence or fill a thin section. **Where the source has
nothing, the target stays empty and you report it.** An invented sentence has already reached this
client once.

**2 — The canons are locked.** Do not change a typography token or a colour token. The typography
canon is `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md` and it is the only authority on sizing.
**Task 3 is a layout task, not a type task.**

**3 — Verify on the rendered page.** A lint is not a render, a diff is not a render, and counting
elements in HTML is not a render — markup can sit inside a `display:none` container and count as
fine. Fetch the real URL with its status code, **do not follow redirects**, and read any box only
**after layout has settled**: a `getBoundingClientRect` taken too early returns zeros, and zeros
look exactly like a defect.

**4 — Report a gap, never fill it silently.** Every gap that goes back to Nimrod or Eyal must be
recorded on **both** surfaces — Eyal's form and Nimrod's board. This is the project's definition of
done: *"No embarrassments" means no gap that has not been fixed, or recorded for the meeting, or
placed in Eyal's form.* **A gap you fixed but nobody recorded looks exactly like a gap that never
existed.**

## Practical constraints

- **Never open or commit anything under `local/`** — it holds credentials.
- **`_aos/` is a read-only snapshot.** Never edit inside it.
- **Never `git add -A` or `git add .`** — stage explicit paths only. Other sessions share this
  checkout.
- **Deploy:** `python3 scripts/ftp_deploy_site_wp_content.py` ships the working tree and **refuses a
  dirty `site/`**. **Never force past that refusal.** If it refuses, stop and report — do not pass
  an override flag. Bump `Version:` in `site/wp-content/themes/ea-eyalamit/style.css` before
  deploying and **read the current value first**; it is a shared counter.
- There is an untracked `scripts/save_legacy_wp_app_password.py`. **Leave it. Do not open it.**

---

## Task 1 · Take the courses page out of the menu

**מה** — Eyal decided: the page stays live and comes out of the navigation.
His answer, verbatim: «להשאיר מחוץ לתפריט» · «אין עדיין קורס באוויר. כשיהיה מוכן אשלח קישור.»

**איפה** — the canonical nav tree, `site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php`.
The page `/learning/courses-external/` itself does not change.

**למה** — our record says the page is currently **in** the menu under לימוד והכשרה carrying
«יעלה בקרוב». **His answer changes that state**, so this is a real edit, not a confirmation.

**איך** — remove the menu item only. **Do not delete the page, do not change its content, and do
not remove the «יעלה בקרוב» line.** The nav tree is canonical and feeds every renderer — change the
one item, nothing else.

**Success criteria — measured without asking anyone:**
- The courses page appears in **no** navigation on any page of the site.
- Its direct URL still returns **200**.
- On every other page, the count of primary-nav items drops by **exactly one**. A drop of more than
  one is a failure.
- The nav renders exactly once per page, site-wide, on all published URLs.

---

## Task 2 · Historical articles — complete the content from the old site

**מה** — bring into the page **all** the content of the old site's shows page, **and in addition**
the visitor comments and extra material from the old site's page about reactions to the storytelling
show. **All on one page.**

Eyal's answer, verbatim: «לוודא שהעמוד תקין ומכיל את כל התוכן של עמוד ״מופעים״ או ״הופעות״ משהו
דומה באתר הישן» · «יש להוסיף לעמוד הזה המתעד למעשה את המופע ההיסטורי גם את כל התגובות והמידע
הנוסף על המופע המופיע באתר הישן בעמוד ״תגובות-גולשים-אודות-״מופע-הסיפורים-של״» · «הכול בעמוד אחד
מעוצב ויפה.»

He also fixed the page's status: **keep it, public URL, slug your choice, no menu link, reachable by
him through the admin.** Our record says it is already live and already out of the menu — **verify
that rather than assuming it, and report what you found.**

**איפה** — `/historical-articles/`.

**למה** — in his words the page «מתעד למעשה את המופע ההיסטורי», and this material is missing from
it. He asked to keep it as his own open working page.

**איך** — **transfer only.** Content law applies in full: do not rewrite, do not summarise into a
new sentence, do not shorten. **What is not in the old site is not written — it is reported.**
He also noted «בהמלצות חסר תוכן» — if the recommendations section has no source content, **leave it
empty and report it. Do not fill it.**

**Success criteria:**
- **Every paragraph on the page exists verbatim in one of the two source pages.** Team 90 will
  cross-check this automatically. **One sentence without a source fails the task.**
- **Zero new sentences**, including connecting text, headings you invented, or a caption.
- You deliver a **mapping of both source pages**: what was transferred, what was not, and why.
- The page returns **200**, carries a canonical tag pointing at itself, and **appears in no menu**.

---

## Task 3 · Historical articles — a readability pass

**מה** — Eyal, verbatim: «כן חשוב לבצע לעמוד סבב דיוק ממשק - כרגע ממש לא נראה טוב ולא קריא.»

**איפה** — the same page.

**למה** — he asked to keep this page as his own open working material. **If he opens it and cannot
read it, it comes straight back.**

**איך** — **this is layout, not type.** Permitted: spacing, measure, hierarchy, order, block
rhythm, alignment. **Forbidden: any font-size token and any colour token.** If you believe a size
is genuinely wrong, **report it — do not change it.**

**Success criteria:**
- Body **line length between 45 and 75 characters** at every width tested.
- **Zero horizontal overflow** at mobile width.
- Heading hierarchy is continuous with **no skipped level**.
- **`assets/css/ea-tokens.css` is byte-identical** to its current state. Team 90 diffs it and
  requires exact equality.
- Measured on the **rendered** page after layout settles, not from the stylesheet.

---

## Task 4 · The main gallery — images from the old site

**מה** — populate the galleries page from **the gallery at the bottom of the old site's home page.**

Eyal's answer, verbatim: «בדף הבית - בסוף העמוד של האתר הישן יש גלריה - אלו התמונות לעמוד הגלריות
כרגע, בהמשך אני יוסיף ועדכן וישפר. לשלב זה לקחת משם.»

**איפה** — `/galleries/`. It currently shows sample images only.

**למה** — this is his own choice, from a source he named explicitly. He was clear it is an interim
set he will improve later.

**איך** — **transfer only.** A caption per image **only if one exists** in the source or in Eyal's
own notes (`docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--whatsapp-after-1158/ea-media-filter-2026-09-21T13-51-27-450Z.json`).
**No source means the neutral label and a report. Never compose a caption.**

**Success criteria:**
- The galleries page contains **zero sample/demo images**.
- **Every image on it exists in the old site's home-page gallery** — cross-checked by **byte
  fingerprint, not by filename.** Filenames collide on this project and have produced a wrong answer
  before.
- **Every caption is either sourced or the neutral label. Zero invented captions.**
- The page returns **200** and every image URL on it returns **200**.

---

## Task 5 · Update the form — what is answered and what is open

**מה** — record Eyal's meeting answers and mark each row **answered** or **open**.

**איפה** — `_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json` and the renderer
`scripts/s007_render_work_ssot.py`, then both surfaces.

**Source of the answers:** the export Nimrod supplied, recorded verbatim in
`_COMMUNICATION/team_90/AUDIT-2026-09-24/MEETING-ANSWERS-EYAL-2026-09-24.md`. Its signature is
`371f7341103d`, which matches the current build — **the answers were given against this version.**

**למה** — Nimrod's instruction in the meeting: **what is open, Eyal handles alone at home and it
does not need Nimrod.** The form has to show Eyal exactly what is left on him.

**איך** — **record the answers as given. Do not summarise and do not rephrase.** An answered row is
marked answered and carries the answer. An open row stays open.

**Three rows must NOT be marked answered:**
- **`P037`** — Eyal's answer repeats an instruction already measured as impossible: the old post has
  no hero image either. **Mark it «ממתין להכרעה בפגישה».**
- **`B2`** — Eyal wrote he did not understand the question and that it duplicates `B3`. **Mark it
  «ממתין להכרעה בפגישה».**
- **`C1` and `C3`** — the choice says approved but the note says «טרם נבדק - נשאר פתוח לאייל
  לביצוע בבית». **The note wins. Both stay OPEN.** `C3`'s note is word-for-word identical to `C1`'s
  and refers to the learning page — treat it as a copy-paste and do not read approval into it.

**Success criteria:**
- **All eleven rows carry an explicit mark.** A row with no mark fails.
- **Every recorded answer is byte-identical to the export.** Team 90 cross-checks automatically.
- **Zero rows marked closed.** Nothing here closes — rows are answered, not closed.
- `P037`, `B2` marked waiting on the meeting; `C1`, `C3` still open.
- The signature updates **on both surfaces together**, and the form and board agree.

---

## What is deliberately NOT yours in this round

- **The hero image for the 2012 post** and **the first galleries question** — both blocked pending
  Nimrod's decision in the room. **Do not build either, and do not decide them.**
- **The learning page and the English page** — Eyal's own homework. Do not touch.
- **Contrast** — on the board for a meeting decision. **No colour work at all.**
- **The accessibility statement**, **the homepage FAQ block**, **the second contact-mail receipt**,
  and **deleting the old Mukesh directory on the server.** All deferred and already recorded.
- **Two fixes are already written and waiting on a deploy that the dirty-tree guard refused** — the
  `/shop/` and `/contact/` share-text leak, and the dead `about` slug. **They are in the working
  tree. Do not re-implement them and do not revert them.**

## Report back

Write `_COMMUNICATION/team_10/DONE-MEETING-ANSWERS-2026-09-24.md`.

Per task: **the live URL, the status code, and the measurement that proves it** — not a description
of what you changed. For task 2 and task 4, the source-to-target mapping. For task 1, the nav count
on at least five pages.

**If a task turns out to be wrong, say so and do not implement it.** Refusals with a measurement
behind them have already saved this project once today. **A task you implement on a premise that was
wrong is worse than a task you refuse.**

**If you cannot finish everything, stop and report where you got to.** An honest partial list is
worth more than a complete-looking one.
