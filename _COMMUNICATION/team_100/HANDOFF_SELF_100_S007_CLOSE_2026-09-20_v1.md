# Session Handoff — team_100 | S007 closed out: one navigation site-wide, 137 phantom URLs retired, Eyal's 23-item form ready, merged to main at 1.5.92

**Checkpoint requested by team_00, 2026-09-20.** Next phase per his instruction: **ingest Eyal's
next round of requests.** Read §6 before starting it.

---

## 1. SESSION ACCOMPLISHED

- **One navigation on every published URL** (M-13). 144 URLs were serving a second, drifted,
  WordPress-editable menu. Three renderers — Chapters `section-nav.php`, GeneratePress's header
  via a `wp_nav_menu_items` filter, and `/en/` — now read one canonical function,
  `inc/ea-canonical-nav.php`. Built by team_10; accepted against five criteria; independently
  re-measured by team_100 across 157 REST-enumerated URLs.
- **137 custom-post-type single URLs retired.** `ea_faq`, `ea_gallery`, `ea_testimonial` are now
  `public => false`. **Their content was NOT deleted** — see §4, this is the most important
  trap in the file.
- **Five placeholder pages** re-recorded as `הוקפא` instead of the false `הוגש לבדיקה`.
  **Four seed placeholders** trashed. **Three redirecting URLs** removed from the sitemap.
- **Dated form for Eyal**: 23 items, six parts, at
  `_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html`.
- **Two rulings stamped** with team_00's verbatim words plus canonical English:
  `DECIDE-S007-PLACEHOLDER-PAGES-2026-09-20.md` and `DECIDE-S007-TWO-NAVIGATIONS-2026-09-20.md`.
- **Merged to main** as `92bae58`, pushed. Staging live at theme **1.5.92**.

## 2. STATE OF THE SITE

- **Live staging:** `http://eyalamit-co-il-2026.s887.upress.link` — theme **1.5.92**.
- **The site has never been published.** Going live is the move to the primary domain, and
  that is the moment several deferred risks become real. See §5.
- **Published URL population is 279 across five sitemaps**, and **103 pages via REST** — of
  which 16 are outside `page-sitemap.xml` (13 legitimate 301s, plus `/about/`, `/blog/` and
  `/learning/therapist-training/` which are live 200s).
- Working tree clean apart from `tmp/qa/cdp/qa_probe_result.json` and an untracked
  `scripts/save_legacy_wp_app_password.py`, neither of which is this session's.

## 3. WHAT IS STILL OPEN, AND WHOSE IT IS

**Ours — three rows, all the same shape:** `R2-003` accessibility, `R2-016` privacy,
`R2-022` terms. Each holds at **HOLD-W4**: draft approved, nothing pasted to the site, and a
full HTML research report owed before any of it reaches Eyal. **This is the only outstanding
build work in the tracker.**

**Eyal — 23 pages**, and the 23-item form is the vehicle. **team_00 — 125 pages** awaiting his
review, which is the normal steady state, not a backlog.

**Waived, not done:** the **cross-engine validation gate did not run** on M-13. team_10 built it
and also verified it; team_100's re-measurement is a second pair of eyes in the same engine, not
Iron Rule #1. team_00 explicitly waived the Grok round on 2026-09-20. **Do not let a later reader
mistake the merge for acceptance.**

## 4. THE TRAP THAT WOULD HAVE COST THE MOST

**`/faq/` is RENDERED FROM the `ea_faq` posts.** All 133 questions and answers appear verbatim on
`/faq/`, which looks exactly like a duplication worth deleting — and deleting the posts would
have emptied the page being duplicated. What was duplicated was the **URLs**, not the content.
The fix was `public => false`, never `wp_trash_post`.

**If a future instruction says to delete `ea_faq` items, re-read this paragraph first.**

## 5. CARRIED TO THE DOMAIN CUTOVER — RE-READ BEFORE GOING LIVE

- Five placeholder pages stay published on staging by team_00's ruling. They carry **no robots
  meta** and sit in the sitemap. Harmless while unpublished; live search exposure the moment the
  primary domain points here. `DECIDE-S007-PLACEHOLDER-PAGES-2026-09-20.md` item 4 owns this.
- `/about/` is listed in `ea_w217_redirect_source_paths()` as a redirect shell **and it is not
  one** — it serves 200. That is why every sitemap-based sweep was blind to it. Left deliberately
  alone: whether `/about/` should exist at all is Eyal's open `R2-001`, now part ו of the form.
- The WordPress record for `/eyal-amit/` still stores «אודות — placeholder» from April and has
  never been modified, while the theme renders the real page. **Same theme-renders /
  WordPress-stores split that made the accessibility statement publish a wrong `dateModified`.**
  Not broken today. Same mine.

## 6. NEXT PHASE — INGESTING EYAL'S ROUND

1. **Content law is unchanged and absolute.** Only what exists, what came from Eyal in files, or
   what came from team_00 in session. No guessing, no self-authored copy, no gap-filling. An
   empty card is never rendered.
2. **The tracker is SSOT** and has a real two-permission lock. Agent columns only, via
   `scripts/tracker_update.py`; human columns only via `scripts/tracker_ingest_approvals.py`
   from a named export file. `scripts/tracker_guard.py` must PASS after every change.
3. **The 23-item form already asks Eyal 23 things.** Fold his new round into the same tracker
   rows rather than opening a parallel list — that is how the drift of August happened.
4. **Every page you name to team_00 gets its live URL in the same breath.** He reviews by
   opening things on his phone.

## 7. MEASUREMENT LESSONS FROM THIS SESSION — ALL THREE COST REAL TIME

- **A lint is not a render.** `php -l` passed on a `section-nav.php` that fataled every Chapters
  page on 1.5.90 — a helper removed with its block, two call sites left behind. Third occurrence
  in this milestone of a deletion taking a neighbouring assignment; first one that was fatal.
- **A diff is not a render, and an HTML count is not a render.** `/about/` and `/press/` shipped
  with all 28 canonical nav links present in the markup and `display:none` on the header. I
  reported "28 links, identical to the main menu" from a grep. Every one was invisible.
- **A box read before layout reports zeros, and zeros look exactly like a defect.** Three times a
  `getBoundingClientRect()` on a freshly navigated page invented a failure that was not there.
  Settle first — two `requestAnimationFrame`s, or a screenshot — then measure.
- **`urlopen` follows redirects silently.** A 301 reads as its destination's body, which makes a
  redirect look like a duplicate page. Check status codes unfollowed.
- **`page-sitemap.xml` is not the site.** It was 87 of 279 published URLs. Start from
  `sitemap_index.xml`, or better, enumerate from REST.

All five are recorded in the memory notes `eyalamit-qa-harnesses-that-fail-open` (traps 19, 20,
21) and `eyalamit-never-delete-code-with-a-regex`.

## 8. KEY PATHS

- Canonical nav source: `site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php`
- CPT registration (now non-public): `functions.php`, `ea_eyalamit_register_m3_instance_cpts()`
- Sitemap exclusions: `site/wp-content/mu-plugins/ea-w2-17-sitemap-exclusions.php`
- Type canon: `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md` — change a token, never a
  declaration
- Deploy: `python3 scripts/ftp_deploy_site_wp_content.py` — ships the WORKING TREE and refuses a
  dirty `site/`. **Another session may be mid-edit in the same worktree; that guard is the
  interlock, never force past it.**
