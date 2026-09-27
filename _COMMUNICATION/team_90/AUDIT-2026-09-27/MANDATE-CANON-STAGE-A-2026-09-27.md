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

**And a third case the split does not cover: a contradiction between two documents, or between a
document and this mandate.** That is neither a taste question nor a code lookup. **Take it to
Nimrod first, with both quotes**, and do not resolve it by picking the one you prefer. Several
documents here were written days apart and the site moves daily.

**Never guess at any of the three.** A guessed technical fact wastes a day; a guessed design
decision reaches the client; a silently resolved contradiction becomes the new wrong answer.

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
   and Eyal. 37 examples. **Each is local markup injected with `iframe.srcdoc` (line 544) and
   styled by the live theme stylesheets**, which the `STAGE` variable (line 134) prefixes. It is
   not fetching pages. Plain language, no class names. Published at the hub.

**Then the state of the ground:**

3. **`_COMMUNICATION/team_90/AUDIT-2026-09-27/EDITING-SURFACES-MAP-2026-09-27.md`** and
   **`EDIT-LEVELS-2026-09-27.md`** — what is editable in wp-admin today and what is not. **You
   need this, because it is the constraint stage ב will inherit.**
4. **`_COMMUNICATION/team_90/PROTOCOL-VERIFY-AND-FIX.md`** — the standing verification procedure.
   **It replaces closing conditions written in prose. Follow it.**
5. **`_COMMUNICATION/team_90/AUDIT-2026-09-24/SESSION-STATE-2026-09-24.md`** — the entry point:
   current state and open items. **It summarises six measurement traps; the full fifteen are in**
   `_COMMUNICATION/team_90/AUDIT-2026-09-24/MASTER-PRE-MEETING-AUDIT-2026-09-24.md`.
   **Its earlier ruling that the canon is a later stage was superseded on 2026-09-27 when Nimrod
   opened this session — the file now says so, and stages ב and ג remain later.**

### Four facts you would otherwise discover the hard way

- **The pair says it is true for theme 1.5.138. The live theme is 1.5.147.** Part of your job is
  re-verifying its geometry claims. **"Not measured" is a legal value in that file — keep it so.**
- **Core page content does not live in the database.** 155,673 Hebrew characters sit in 35 PHP
  files under `inc/chapters/defaults/`. `tpl-chapters-page.php`, `-method.php` and `-mokesh.php`
  never call `the_content()`. **Two Chapters templates do, and this matters:**
  `tpl-chapters-qr.php:47` and `tpl-chapters-blog-single.php:105`. **The 48 QR pages and the
  blog posts are ordinary database content and edit normally** — measured, 42 of 49 and 50 of 52.
- **ACF is installed and the overlay works** — but it is frozen for 21 page types by
  `ea_chapters_seeded_only_types()` in `inc/chapters/chapters-render.php`. Measured 2026-09-27:
  **zero stored ACF values on any frozen page**, and lifting the freeze for one type does restore
  editing. That function is filterable, so a type can be unfrozen for a test without editing code
  twice.
- **The artifact depends on the staging host in 21 places:** the `STAGE` variable that prefixes
  every stylesheet and image, plus **20 hardcoded URLs in the review lists** (lines 588–595,
  614–617). **At the domain cutover the examples lose their styling and those 20 links die.**
  If you touch that file, do not add a twenty-first hardcoded URL.

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

**At least one type, rendered on a real live page, with real content, through the mechanism the
site actually uses.** This is the acceptance test for the stage.

**Before you plan it, understand how content reaches an inner page.** This is the part a builder
gets wrong, so it is spelled out:

- An inner Chapters page renders **only the sections already listed in its own
  `inc/chapters/defaults/{type}-defaults.php`.** `ea_chapters_page_sections()` walks that array.
- **ACF can replace the value of a slot that already exists in that array. It cannot add a row.**
  The admin field names are `phero_{arg}` and `s{N}_{arg}` — built in
  `inc/chapters/acf-fields-inner.php` — **not the `$args` names the canon records.** The canon
  says `title`; the field is `s3_title`. **That gap is itself a canon finding: write it down.**
- An empty ACF value keeps the seeded default, which is why lifting the freeze changes nothing
  until a value is entered.
- **The freeze filter removes a type from the frozen list for every page of that type**, not for
  one page.

**Therefore there are exactly two honest routes, and you pick one with Nimrod:**

**Route A — change an existing slot through ACF.** Available today on the pages that are already
unfrozen: **`/learning/`, `/learning/therapist-training/`, `/learning/lectures/`,
`/learning/workshops/`, `/thank-you/`.** No code, no deploy, fully reversible. **This proves the
overlay works and that the canon entry describes the right field.** It does not prove a type can
be constructed from its entry.

**Route B — add a section to a defaults array.** This is the only way to put a type on a page that
does not already have it. **It is PHP in the theme, and that is the site's real mechanism, not a
shortcut** — do not avoid it out of a misreading of "use a real field". **But it is also a code
change on a live site, so: one page, one section, committed with explicit paths, deployed on a
clean tree, and captured before and after.**

**What "a hardcoded patch" means here, since the distinction matters:** pasting markup into a
template, adding a `page-id-` CSS rule, or special-casing one URL in a renderer. **Adding a
properly-shaped entry to a defaults array is not that.**

**Rules for the example:**

- **Real content only.** Content law: only what exists on the site, what came from Eyal, or what
  came from Nimrod. **No invented copy, not even as an example.** Eyal's delivered material is
  under `docs/project/eyal-ceo-submissions-and-responses/from-eyal/`. If you cannot find real
  text, **ask Nimrod — do not write a sentence for him.**

  **One boundary, because the two rules look like they collide.** Content law governs **anything
  that reaches the live site.** The artifact's 37 examples are a different thing: the pair mandate
  allows **plainly generic placeholder text** there, and several examples use it today
  («כותרת העמוד», «כיתוב לדוגמה»). **Leave those alone unless Nimrod rules otherwise — and never
  copy one onto a page.** An example that reads as real copy is the actual danger, not an example
  that reads as obviously fake.
- **Off limits without his explicit permission:** `/eyal-amit/mokesh-dahiman/` (the memorial —
  approved at the meeting, the most sensitive page on the site), the legal pages, the home page,
  **and the eight deviation pages he is meant to judge untouched — which includes `/repair/`.**
- **Type 37 is out of scope for the example.** It has zero live instances and needs a renderer
  that does not exist; building it is a multi-file job and therefore outside stage A.
- **Propose page, type, route and the exact real content to Nimrod before you build.** One short
  message.

**How you show it did not break anything else — and the gate alone is not enough:**

**The gate checks population counts, one nav, one footer, the reveal class, PHP error strings,
legal links and missing `alt`. It does not diff page bodies.** Exit 0 is compatible with a
rewritten page. So:

1. **Capture the rendered HTML of the page you are changing, and of three others sharing its
   type, before you touch anything.**
2. Make the change.
3. **Diff all four.** The one you meant to change shows exactly the intended difference; the other
   three are byte-identical.
4. **And run the gate either side**, for everything the diff cannot see.

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

**Make the output implementable.** The test of a canon entry is not that it is accurate but that
a session can build from it without having to go **read the theme to work out what the type even
is**. **If an entry cannot be implemented from its own text, it is not finished.**

**This is not a ban on editing theme files.** Route B in 4.3 edits `{type}-defaults.php` and that
is the site's real mechanism, not a defect. **The rule is about the canon being self-sufficient as
a description, not about which files you may touch.**

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
If your change is meant to move a number, re-baseline with the **full** invocation:

    python3 scripts/qa/ea_regression_gate.py --update-baseline --reason "..."

**`--reason` on its own does nothing and is silently ignored** — it only has meaning together with
`--update-baseline`, and the script refuses that pair without it.

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
  **Consequence you must not work around:** the canon artifact is published at
  `hub/dist/ea-content-types.html`. **You edit the workspace copy; team_90 copies it into
  `hub/dist/` and runs `scripts/ftp_publish_eyal_client_hub.py`.** Say in your report when a
  publish is due. **Do not publish it yourself and do not leave it unsaid** — otherwise the live
  catalog Nimrod and Eyal open stays on the old file.
  **One exception you may need:** type 37's schema lives in
  `_COMMUNICATION/team_100/S007/POST-TEMPLATE-SETTINGS.md`. **Read it; do not edit it.** If it
  needs changing, say so in the report.
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
