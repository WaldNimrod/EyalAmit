# Mandate — one footer, one invocation path — 2026-09-27

**Dictated by team_00.** Seeing the footer changed on every page again, he asked why it is a
duplication rather than one fixed element belonging to the template, and then:
«אם כבר משנים פוטר בכל העמודים - בואו נעשה את זה נכון.»

**⚠ DO NOT START until the `cbDIDG` language-marking lane has finished and its work is committed.**
That lane is editing ~50 theme files right now, including `inc/ea-canonical-nav.php`, which holds
the footer function. Two lanes in that file will overwrite each other — it has already happened
once on this project.

---

## What is actually true today, measured 2026-09-27

**The footer's content is already single-source.** One function, `ea_render_unified_footer()` in
`inc/ea-canonical-nav.php`. There is no second copy of the markup. **That part is not the problem.**

**What is duplicated is the invocation.** Five paths render it:

    inc/ea-canonical-nav.php:660     add_action( 'wp_footer', 'ea_render_unified_footer' )
    footer.php:63                    explicit call
    template-parts/blocks/block-footer-social.php:18   explicit call
    page-templates/tpl-chapters-en.php:120             explicit call
    template-parts/chapters/section-footer.php:24      explicit call, with a reveal argument

**A render-once guard inside the function is what stops the page printing it five times.** The guard
exists to contain the duplication, not because the duplication is needed.

**And the duplication turns out to be unnecessary.** Of the 21 page templates, 9 never call
`get_footer()`. **Seven of those nine call `wp_footer()` directly, so the hook fires anyway.** The
remaining two are not page renderers at all: `tpl-books.php` is a redirect stub that issues a 301
and exits, and `tpl-catalog-14e.php` is used by no published page.

**So `wp_footer` already reaches every page that renders one.** The four explicit calls are
belt-and-braces from the build, and the guard is there to survive them.

## The target state

**One invocation: the `wp_footer` hook. Nothing else.**

1. **Remove the four explicit calls.** Keep the hook.
2. **Remove the render-once guard** once there is a single path — a guard that can never fire is a
   trap for the next reader, who will assume duplication is expected here.
3. **Preserve the one real difference**: `section-footer.php` passes a reveal argument. **Find out
   what it does, and if it matters, carry it through the hook rather than losing it.** If it does
   not change what a visitor sees, say so with the measurement and drop it.
4. **Leave `tpl-books.php` and `tpl-catalog-14e.php` alone** — a redirect stub needs no footer, and
   an unused template is a separate question. **Report them; do not delete them in this task.**

## Why this is worth doing now rather than later

**This is the theme's signature defect, found six times in two days:** one component, several
parallel invocations, each drifting on its own. The navigation had six copies. A whole nav block is
called from three files and renders nowhere. The footer's own link column had drifted from the
tree. **Reducing five paths to one removes the mechanism, not just today's symptom.**

## Constraints

- **Do not change what the footer renders.** This is about how it is invoked. **Zero visible change
  is the success condition**, not a nice-to-have.
- Typography and colour tokens are LOCKED; `assets/css/ea-tokens.css` and the typography canon must
  come out byte-unchanged.
- Content law: no visible text changes.
- Never `git add -A`. Never open `local/`. Never touch `_aos/`. Do not run
  `scripts/s007_render_work_ssot.py`. Do not open `scripts/save_legacy_wp_app_password.py`.
- Deploy with `python3 scripts/ftp_deploy_site_wp_content.py`; it refuses a dirty `site/` — a safety
  interlock, never force past it. Do not push.
- **Be gentle: at most 3 concurrent requests, retry on 502, never record a 502 as a defect.**

## Success criteria — Team 90 measures these

- **Exactly one `<footer>` element on every one of the 136 live pages.** Not 135, not 137. The
  count that matters is per page, measured across the whole published population enumerated from
  the REST API.
- **Exactly one invocation path remains in the code** — grep and show it.
- **The rendered footer is byte-identical to today's on at least five pages spanning every template
  family**, including `/press/`, `/historical-articles/`, `/en/` and a printed-code page. **Diff the
  rendered footer markup before and after and show it is unchanged.**
- **The reveal behaviour on the Chapters pages is unchanged** — verify in a rendered browser, since
  it is an animation, and state what you measured.
- Full regression: every live URL 200, exactly one primary nav, zero PHP error strings.
- Zero horizontal overflow at 390px on four pages.

## Report

`_COMMUNICATION/team_10/DONE-FOOTER-ONE-PATH-2026-09-27.md`: the paths before and after, the
rendered-footer diff on five pages, what the reveal argument did and how it was preserved or why it
was dropped, and the status of the two non-rendering templates.

**If removing a call breaks a page, say which and stop.** A footer that vanishes from one template
family is worse than five call sites.
