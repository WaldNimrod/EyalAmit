# Mandate — one invocation path per shared component — 2026-09-27

**Ordered by team_00, 2026-09-27:** «כפילויות קוד - מבקש לתקן, עי ליינים. אנחנו לא מגישים כזה
מוצר. לייצר לזה כרטיס ולהכניס לתור.»

This is the same defect the footer mandate closed on 2026-09-27, applied to everything else that
carries it. The footer is the worked example: read
`_COMMUNICATION/team_90/AUDIT-2026-09-26/MANDATE-FOOTER-ONE-PATH-2026-09-27.md` and the theme's
`inc/ea-canonical-nav.php` hook comment before you start. **Follow that pattern exactly.**

---

## What is true today, measured 2026-09-27 by team_90

**Content is already single-source everywhere.** Every renderer reads `ea_canonical_nav_items()`.
There is no second copy of any item list. **What is duplicated is invocation.**

    primary nav   template-parts/chapters/section-nav.php
                  8 explicit get_template_part call sites
                  + inc/ea-open-round.php:89  add_action( 'wp_body_open', ... )
                  = 9 paths, held together by ea_chapters_nav_mark_once()

    chapters footer   template-parts/chapters/section-footer.php    7 call sites
    social block      template-parts/blocks/block-footer-social.php 5 call sites

**Measured output today is correct** — exactly one primary nav and one footer on every one of the
136 live pages. This is a latent defect, not a live one. **Zero visible change is the success
condition, not a nice-to-have.**

## Four dead things found in the same sweep

1. **`header.php` (child) returns early** into the GeneratePress parent header. Everything below
   that `return` — the whole `ea-shell` wrapper: logo, a complete primary nav, the EN link —
   **renders on zero of the 153 published URLs.** Measured: the string `ea-shell-nav` appears on
   0 pages.
2. **`template-parts/blocks/block-topnav.php`** has 4 call sites and emits `nav.ea-topnav`, which
   appears on **0 pages**.
3. **`page-templates/tpl-catalog-14e.php`** is used by no published page.
4. **`page-templates/tpl-chapters-en.php:72`** loops `ea_canonical_nav_items()` in its own inline
   renderer — a second renderer of the same data, for one page.

## What to do

1. **Primary nav → one path.** Decide which single path reaches every page that needs a nav,
   exactly as the footer mandate did: **prove it by measurement before removing anything**, then
   remove the others and remove `ea_chapters_nav_mark_once()`. A guard that can never fire is a
   trap for the next reader.
2. **Chapters footer and social block → one path each**, same method.
3. **Dead code:** report each of the four with the measurement. **Do not delete anything in this
   task.** Deletion is a separate decision and this theme has taken three outages from deletions
   that carried a neighbour away with them.
4. **`tpl-chapters-en.php`'s inline loop:** report whether it can read the shared renderer without
   changing a pixel on `/en/`. **Propose, do not implement.**

## Constraints

- **Capture the rendered markup BEFORE you change anything.** That capture is the whole proof.
- **Do not change what any component renders.** No visible text changes. Content law applies.
- Typography and colour tokens are LOCKED; `assets/css/ea-tokens.css` must come out byte-unchanged.
- Never `git add -A`. Never open `local/`. Never touch `_aos/`. Do not run
  `scripts/s007_render_work_ssot.py`. Do not open `scripts/save_legacy_wp_app_password.py`.
- Do not touch `_COMMUNICATION/team_100/S007/` or `hub/dist/`.
- **Never deploy with `--allow-dirty`.** The script refuses a dirty `site/` on purpose: the deploy
  ships the working tree, so a dirty deploy leaves the live site with no commit describing it.
  **Commit first, then deploy.** A previous lane bypassed this and left 49 files live and
  uncommitted.
- **Stay inside the task.** A previous lane asked to wrap one token introduced a site-wide escaping
  helper across 49 files. If this seems to need a structural change beyond removing call sites and
  guards, **stop and report instead of building it.**
- Bump the theme version in `style.css` — read it first, it is a shared counter. Do not push.
- **Be gentle: at most 3 concurrent requests, retry on 502, never record a 502 as a defect.**

## Success criteria — team_90 re-measures all of these independently

- **Exactly one primary nav and exactly one `<footer>` on every one of the 136 live pages.**
  Enumerate the population yourself from the WP REST API (153 objects; 136 return 200, 17 are 301).
  Not a sample.
- **One invocation path per component left in the code** — grep and show each.
- **Rendered markup byte-identical before and after** on at least five pages spanning every template
  family, including `/`, `/press/`, `/historical-articles/`, `/en/` and a printed-code page.
- Every live URL 200, zero PHP error strings, zero horizontal overflow at 390px on four pages.

## Report

`_COMMUNICATION/team_10/DONE-INVOCATION-DEDUP-2026-09-27.md`: paths before and after per component,
the byte-level diff on five pages, and the status of the four dead items.

**If removing a call breaks a page, say which and stop.** A nav that vanishes from one template
family is far worse than nine call sites.
