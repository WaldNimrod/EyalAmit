---
id: MANDATE-TEAM10-CONTENT-QA-2026-07-12
from_team: team_100 (Chief System Architect — Claude Code, Sonnet 5)
to_team: team_10 (Builder / Composer engine)
date: 2026-07-12
wp: none yet — pre-WP quick-fix batch, ahead of the forthcoming WP-CANON registration
priority: MEDIUM — no gate is currently blocked; this is a cross-engine QA pass per Iron Rule #1 (builder engine ≠ validator engine) before marking the batch COMPLETE
depends_on: none — all fixable/verifiable now
---

# MANDATE — team_10 · cross-engine QA on today's content + quick-fix batch

## Why

Following the 2026-07-12 Eyal WhatsApp intake (anchor page + QA/SEO docs) and the resulting detailed diff against live code, team_00 approved a plan (`/Users/nimrod/.claude/plans/1-humble-raven.md`) and gave item-by-item rulings on 19 design/code findings plus 5 content items. team_100 (this session, Claude Code) implemented the quick, low-risk items directly. Per Iron Rule #1, these need independent cross-engine validation before being marked COMPLETE — team_100 cannot self-validate its own build.

All changes are content/wiring-level (no new schema, no deletions, no routing changes) — low blast radius, but real production theme code on a live client site.

## Scope — verify each of the following

### Content (Eyal's wording — verify exact match, not paraphrase)
1. **Meta descriptions** — `site/wp-content/mu-plugins/ea-content-eyal-seo-metadesc-2026-07-12-once.php` (new file). Force-sets `_yoast_wpseo_metadesc` for 8 routes (home, treatment, method, sound-healing, lessons, faq, repair, didgeridoos) to the exact text in Eyal's SEO doc. Verify: (a) the WordPress `get_page_by_path()` lookups resolve to the correct live post IDs for each slug, (b) after the `init` hook fires once, each route's live meta description actually reads back the new value (not shadowed by a still-cached/CDN'd page), (c) the option-flag guard (`ea_eyal_seo_metadesc_20260712_v1`) prevents re-running on every request.
2. **`/repair` "electronics engineer" sentence** — `inc/chapters/defaults/repair-defaults.php`, one new sentence inserted into the opening prose body, matching the phrasing already used on `/didgeridoos`, `/eyal-amit`, `/books`, `/kushi-blantis`. Verify it renders correctly and reads naturally in context.

### Quick fixes (design/code — verify behavior + no regressions)
3. **Homepage Trust Line** — `inc/chapters/defaults/home-defaults.php` (new `hero_trust` field) + `template-parts/chapters/section-hero.php` (renders it above the H1) + `assets/css/chapters.css` (`.hero__trust`, uses `--terra-lt` for dark-bg contrast). Verify it's visible, legible, and doesn't crowd the H1 on mobile.
4. **Testimonial names clickable** — `template-parts/chapters/section-05-testimonials.php` now carries `href` through from `ea_fb_testimonials_all()` and wraps the name in `<a target="_blank" rel="noopener noreferrer">` when present; CSS `.tmq__nl` in `chapters.css`. Verify links actually resolve to the correct original Facebook posts, and that testimonials without an `href` still render the plain (non-link) caption cleanly.
5. **`/method` 8-card testimonial carousel** — `inc/chapters/defaults/method-defaults.php` (new `testi_chap`/`testi_title`/`testi_items` fields, 8 people, text extracted verbatim from the removed `split_body` blocks) + `page-templates/tpl-chapters-method.php` (wires `parts/testimonials.php` between the "whom" and "cta" sections). **Verify the extracted quotes are byte-identical to what was removed from `split_body`** — this was a manual extraction, re-check against git blame/history for the exact original text.
6. **Book reading-excerpt accordions** — `template-parts/chapters/parts/prose.php` gained an optional `collapsible`/`toggle_label` arg (closed `<details>` instead of a plain div); applied to the "SECTION 03" excerpt on all 3 book pages (`kushi-blantis-defaults.php`, `vekatavta-defaults.php`, `tsva-bekahol-defaults.php`). CSS `.prose-acc*` in `chapters.css`, mirrors the existing `.faq__i` accordion pattern. Verify: closed by default, opens on click, no layout shift, and — important — confirm this doesn't hide the excerpt from crawlers in a way that hurts the "reading excerpt as content marketing" SEO intent (a native `<details>` is normally fine for Google, but worth a sanity check).
7. **Homepage hero video: deferred/reduced-motion-safe autoplay** — `template-parts/chapters/section-hero.php` (removed `autoplay`, `preload="metadata"` → `preload="none"`) + `assets/js/ea-chapters.js` (new block: `.load()` + `.play()` on `window.load`, gated on `!prefers-reduced-motion`). **This is the one item team_00 was explicit about: the video file/content itself is locked, do not touch which video plays — only the loading/autoplay mechanics changed.** Verify: (a) video still autoplays for normal users, just slightly deferred, (b) reduced-motion users correctly get the static poster with no video fetch at all, (c) no-JS fallback (poster only) is an acceptable degrade, (d) measure whether this actually improves LCP/CWV on a throttled connection — don't just trust the theory.
8. **FAQ font-size** — `assets/css/ea-atoms.css`, `.ea-faq-item__answer p` raised `0.9rem` → `1rem` (14.4px → 16px) on the main `/faq` page. Verify no overflow/wrapping regression at common breakpoints.
9. **"לימוד והכשרה" nav sub-links** — `template-parts/chapters/section-nav.php`: 3 of 4 dead `href="#"` links now point to `/learning/therapist-training/`, `/learning/lectures/`, `/learning/workshops/` (existing WP pages, currently placeholder content per `ea-m2-site-tree-lock-sync-once.php` / `ea-m3-team80-placeholder-content-once.php`). `קורסים` intentionally left as `#` — it's genuinely waiting on an external course-platform URL from Eyal, not a fixable bug. Verify the three targets actually resolve (200, not 404) on live/staging.
10. **Footer medical disclaimer + accessibility/privacy links** — `template-parts/chapters/section-footer.php` (new `.foot__legal` block, disclaimer text copied verbatim from `template-parts/blocks/block-disclaimer.php`'s canonical default) + `chapters.css` (`.foot__legal`, `.foot__disc`, `.foot__base a`). Verify `/accessibility/` and `/privacy/` routes resolve, and the disclaimer text is legible against the dark footer background at the reduced opacity used.

## What team_10 should NOT do

- Do not touch anything under `page-templates/tpl-service.php`, `template-treatment.php`, `template-method.php`, `tpl-faq.php`, `tpl-shop-item.php`, or any other Wave2-legacy file — that's in scope for the separate WP-CANON work package (not yet registered), not this QA pass.
- Do not attempt the many-to-many FAQ category upgrade or the Mokesh video/gallery port — also WP-CANON scope.
- Do not "fix" the H1/H2 wording items team_100 reviewed and declined (dash style, `/method` H1 name-suffix, `/treatment` H2) — those were deliberately left as-is; see `_COMMUNICATION/team_100/DETAILED-DIFF-EYAL-QA-SEO-VS-CURRENT-SITE-2026-07-12.md` §3.A if you want the reasoning.

## On PASS

Reply with a verification artifact (or inline response) confirming each of the 10 items above; team_100 will then mark the batch COMPLETE per team_00's directive. On any FAIL, point to the specific file/line and team_100 will fix in a follow-up round — do not silently patch it yourself without flagging back first, since some of these (esp. #5, the extracted testimonial quotes) need a second pair of eyes on textual accuracy, not just code correctness.

---

*Filed by: team_100 (Claude Code, Sonnet 5) · 2026-07-12*
