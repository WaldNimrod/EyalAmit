# Mandate — canon stage A: sharpen the canon, and prove it on one real page

**Ordered by team_00 (Nimrod), 2026-09-27.** For a parallel **team_10** session on Sonnet,
working directly with him.

> «אני רוצה לפתוח לנו סשן מקביל של צוות 10 על סונט שיבצע מולי את השלב הראשון — דיוק הקאנון
> עצמו כולל לפחות דוגמה חיה מדוייקת אחת בעמוד באתר עם תוכן אמיתי.»

**Read this file to the end before you touch anything.** It is the whole brief.

---

## 1 · Who is who, and who decides what

**You are team_10, a builder.** You are not the validator of your own work — that is Iron Rule #1
on this project and it is not a formality. **Team_90 (control) re-measures everything before any
card closes.** A report from you is a claim until team_90 has measured it.

**Nimrod (team_00) is the decision authority.** He is the one you are working with in stage A.
**Eyal is the client.** You never contact Eyal, and you never write in his voice.

**Language:** conversation with Nimrod in **Hebrew**. Code, commit messages, documents and reports
in **English**. The product UI and anything a visitor reads is Hebrew.

### Where your questions go — this matters, do not get it wrong

**To Nimrod — matters of substance, style and design:**
should a type exist at all · is this the right look · is this variant worth keeping or should it
be merged · what does this section mean editorially · naming in Hebrew · anything about the
client's business · anything where the honest answer is "that is a taste or a business call".

**To team_90 — anything technical:**
where a thing lives in the codebase · which file renders what · how something is implemented
today · whether a change is safe · what was already measured and what the number was · how to
deploy · what broke last time and why. **Ask before searching for an hour.** Much of what you
need has already been measured this week and the numbers are in `_COMMUNICATION/team_90/`.

**Never guess at either kind.** A guessed technical fact wastes a day; a guessed design decision
reaches the client.

---

## 2 · What stage A is, and what it is not

Nimrod set three stages, and this mandate is **only the first**:

- **א — he reviews the canon and sharpens it.** ← you are here
- **ב — a site reset round against the corrected canon.** Not now.
- **ג — significant deviations and areas that fall under no type are marked for visual review
  and decision, as part of stage א.**

**Stage A is not a rebuild.** You are not re-skinning the site, not refactoring the theme, and not
touching pages that are not part of the agreed example. **If you find yourself changing many
files, stop — you have left the mandate.**

### And one ruling that shapes everything

> «טיפוסי הקאנון גם הם צריכים להיות מובנים בניהול. וכך הם יישמרו.»

**The 37 types are not documentation. They are meant to become the editing vocabulary in
wp-admin.** A canon that is a document drifts, because nothing enforces it; a canon that is the
picker in the admin enforces itself, because a row of a type that does not exist cannot be added.

**So every decision in stage A should be judged by: does this make the type easier or harder to
offer as a choice in the admin later?** A type that cannot be described as a small set of named
inputs is a type that will not survive stage ב.

---

## 3 · What already exists — read these first, in this order

**The pair. These two are edited together; changing one without the other is a defect.**

1. **`_COMMUNICATION/team_100/EYAL-WORKSPACE/CONTENT-TYPES-CANON.md`** — 816 lines, the
   definitions file, written for sessions. Per type: renderer file and line range, CSS file and
   line range, exact classes, **exact inputs as the renderer's `$args`**, measured layout rules,
   which pages use it, variants, exceptions, and whether it is an orphan.
2. **`_COMMUNICATION/team_100/EYAL-WORKSPACE/ea-content-types.html`** — the artifact for Nimrod
   and Eyal. 37 rendered examples, each drawn by the **live theme CSS** in an iframe. Plain
   language, no class names. Published at the hub.

**Then the state of the ground:**

3. **`_COMMUNICATION/team_90/AUDIT-2026-09-27/EDITING-SURFACES-MAP-2026-09-27.md`** and
   **`EDIT-LEVELS-2026-09-27.md`** — what is editable in wp-admin today and what is not. **You
   need this, because it is the constraint stage ב will inherit.**
4. **`_COMMUNICATION/team_90/PROTOCOL-VERIFY-AND-FIX.md`** — the standing verification procedure.
   **It replaces closing conditions written in prose. Follow it.**
5. **`_COMMUNICATION/team_90/AUDIT-2026-09-24/SESSION-STATE-2026-09-24.md`** — the entry point:
   current state, open items, and the fifteen measurement traps.

### Four facts you would otherwise discover the hard way

- **The pair says it is true for theme 1.5.138. The live theme is 1.5.147.** Part of your job is
  re-verifying its geometry claims. **"Not measured" is a legal value in that file — keep it so.**
- **Page content does not live in the database.** ~156,000 Hebrew characters sit in 35 PHP files
  under `inc/chapters/defaults/`. The Chapters templates never call `the_content()`.
- **ACF is installed and the overlay works** — but it is frozen for 21 page types by
  `ea_chapters_seeded_only_types()` in `inc/chapters/chapters-render.php`. Measured 2026-09-27:
  **zero stored ACF values on any frozen page**, and lifting the freeze for one type does restore
  editing. That function is filterable, so a type can be unfrozen for a test without editing code
  twice.
- **The artifact pulls all 37 examples from the staging host** through a single `STAGE` variable,
  plus 20 hardcoded URLs. **It breaks silently at the domain cutover.** If you touch that file,
  do not add a twenty-second one.

---

## 4 · The deliverables

### 4.1 A sharpened canon

Working **with Nimrod**, go through the 37 types and produce a corrected pair. Expect to:

- **merge types that are the same thing wearing two names**, and say so with the measurement;
- **split a "type" that is really two**, where the inputs differ enough that one entry cannot
  describe both;
- **kill entries that are orphans** — the canon already flags some; confirm each by measurement
  before removing, because a grep finding a file is not the same as a page rendering it;
- **re-verify the geometry claims against 1.5.147**, and mark what you could not measure;
- **fill the gap the artifact has:** the definitions file carries Tier 2 (9 elements inside rows)
  and an orphans section that the artifact does not show at all.

**Every change lands in both documents in the same commit.**

### 4.2 The stage-ג lists, which are part of stage A

The canon already carries a stage-A review list — **8 deviations and 4 areas that fall under no
type.** Nimrod ruled these are decided **as part of stage A**, with a live link per row so he can
look. **Bring each one to him as a decision, not as a finding.** Two of the four "areas" currently
link to the general blog archive rather than a specific page; **that is not good enough to decide
from, and fixing those links is part of this.**

### 4.3 The one hard deliverable — a real example on a real page

**At least one type, rendered on a real live page, with real content, done the way the site is
actually meant to be built.**

This is the acceptance test for the whole stage: **if the canon is accurate, someone should be
able to build from it without opening the theme. Prove that by doing it.**

**Rules for the example:**

- **Real content only.** Content law on this project: only what exists on the site, what came from
  Eyal, or what came from Nimrod. **No invented copy, not even as an example.** Eyal's delivered
  material is under `docs/project/eyal-ceo-submissions-and-responses/from-eyal/`. If you cannot
  find real text for the example, **ask Nimrod — do not write a sentence for him.**
- **Not on a sensitive page.** Off limits without explicit permission: `/eyal-amit/mokesh-dahiman/`
  (the memorial — its content was approved at the meeting and is the most sensitive page on the
  site), the legal pages, and the home page.
- **Through the mechanism, not around it.** If the right way is an ACF field, use the field. If it
  needs the freeze lifted for one type, lift it through the filter and say so. **A hardcoded patch
  that happens to look right is a failure of this deliverable, not a shortcut.**
- **Propose the page and the type to Nimrod before you build it.** One short message: which page,
  which type, which real content, and why that pair proves the canon.
- **Zero visible change anywhere else.** The gate is how you show that.

---

## 5 · Working principles

**Avoid duplication — this theme's signature defect.** Found six times in two days: one component,
several parallel invocations, each drifting on its own. The nav had nine invocation paths; the
footer had five; the freeze list existed as two identical arrays in one file. **Before you add a
second way to do something, find the first way and use it.** If you must add a parallel path, say
why in the commit.

**Use WordPress properly.** Prefer the platform's own mechanism over a bespoke one: a real field
over a PHP constant, a template part over a copied block, `get_template_part` over an include.
**The reason is not purity — it is that an error in data is a recoverable paragraph and an error
in code is an outage**, and Eyal will be updating this site with agents.

**Make the output implementable.** The test of your canon entry is not that it is accurate but
that a session can build from it without opening the theme. **If an entry cannot be implemented
from its own text, it is not finished.**

**Reuse what exists.** `ea_chapters_is_blog_view()`, `ea_canonical_nav_items()`,
`ea_render_unified_footer()`, the `--fs-*` tokens, the existing text-shadow pattern, the hero
modifier mechanism. **Adding a near-duplicate of one of these is the most likely way to fail this
mandate.**

**Say "not measured" when you did not measure.** It is a legal value everywhere in this project.

---

## 6 · Verification — the standing procedure, not a new one

**Run the gate before you start. It must pass before you change anything.**

    python3 scripts/qa/ea_regression_gate.py

It enumerates the published population itself and checks every invariant every time: population
shape, one primary nav and one footer per page, the footer reveal class by count and exact URL
list, zero PHP errors, all three legal links on every page, images with no alt attribute.

**Exit 0 pass · 1 drift · 2 could not measure.** A drift is a regression until measured otherwise.
If your change is meant to move a number, re-baseline **with `--reason`** — the script refuses
without one, which is the point.

**And the four rules from the protocol, because they are what this exists to enforce:**

1. **A builder's report is a claim.** Team_90 closes cards, not you.
2. **Census, not sample.** Proof on five pages is proof about five pages.
3. **Compare in both directions** — the group that was *not* supposed to change must also be
   counted. A lane proved zero visible change byte-for-byte on five pages this week and still
   stripped an animation from 53 pages, because its population pass counted navs and footers and
   nothing else.
4. **Capture "before" first.** A before you did not capture does not exist.

---

## 7 · Hard constraints

- **Content law:** only what exists, what came from Eyal, or what came from Nimrod. **No invented
  copy, not even as an example.** 100 of the site's 135 search descriptions currently violate this
  and are an open item — do not add to them.
- **Typography and colour tokens are LOCKED** by `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md`.
  Change a token, never a declaration, and update the canon in the same commit.
- Never `git add -A` — explicit paths only. Never open `local/`. Never edit `_aos/` (read-only
  snapshot). Do not run `scripts/s007_render_work_ssot.py` (stale; would overwrite Eyal's form and
  the board). Do not open `scripts/save_legacy_wp_app_password.py`.
- **Do not touch `_COMMUNICATION/team_100/S007/` or `hub/dist/`** — Eyal's live form and the
  published hub. **His form signature `wave1-20260925` is frozen; changing it erases his saved
  draft, which exists nowhere else.**
- **Deploy with `python3 scripts/ftp_deploy_site_wp_content.py`.** It refuses a dirty `site/` —
  that refusal is a safety interlock. **`--allow-dirty` is forbidden.** Commit first, then deploy.
  A lane bypassed this and left 49 files live and uncommitted.
- Bump the theme version in `style.css` when theme files change — it is a shared counter, read it
  first. **Do not push;** team_90 pushes after validation.
- **Be gentle with staging:** at most 3 concurrent requests, retry on 502, and never record a 502
  as a defect without retrying. **The staging certificate is invalid by design and is never a
  finding.**
- **One working copy.** Two lanes in one file have already overwritten each other on this project.
  Team_90 is working in the same repo — **split by file, and say which files you are holding.**

---

## 8 · Traps specific to this work

- **`get_template_part` splits the partial name into two arguments.** Grepping the full filename
  finds nothing. This has cost a day already.
- **A grep finds a file; only a fetch finds a page.** Several theme files render on zero pages.
- **A file named DONE is not a site state.**
- **Sampling a rounded element inside its bounding box** drags in blurred edge pixels — same page,
  same text measured 4.17 rectangular and 9.00 with the radius inset. If you measure contrast,
  inset by the radius and filter to solid-colour pixels.
- **Scroll-reveal:** much of this theme sits at the wrong position and opacity 0 until scrolled
  into view. Settle the page before measuring.
- **The cookie dialog** is a native `<dialog>` opened with `showModal()`, which makes the rest of
  the page inert; dismissing it triggers a reload.
- **A predicate that asks a different question than the router asks will drift from it.** Call the
  router's own predicate.

---

## 9 · Reporting

**Report to `_COMMUNICATION/team_10/`**, dated, in English. For the stage:

- what changed in each of the 37 entries and why, with the measurement;
- the 8 deviations and 4 areas, each with Nimrod's decision as he gave it;
- **the example: which page, which type, which real content, what you changed, the before and
  after, and the gate output either side;**
- what you could not measure, named as such;
- anything you believe should change in the theme but did not do, as a proposal.

**If something in this mandate turns out to be wrong, say so in the report.** Several facts here
were measured this week and the site moves daily. **An instruction you followed that produced a
bad outcome is the mandate's fault, not yours — but only if you flag it.**
