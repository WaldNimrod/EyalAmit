---
id: MANDATE_CONTENT-QA-2026-07-12_L-GATE_BUILD
from_team: team_100 (Chief System Architect — Claude Code, builder engine)
to_team: team_90 (Default / Senior Constitutional Validator — cursor-composer-2)
date: 2026-07-12
wp: none formal yet (pre-WP-CANON quick-fix batch; WP-CANON-TEMPLATE-UNIFICATION registered separately, LOD200, not yet built)
gate: L-GATE_BUILD — cross-engine validation per Iron Rule #1 (builder=Claude, validator must be a different engine)
workspace: /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026
verdict_path: _COMMUNICATION/team_90/VERDICT_CONTENT-QA-2026-07-12_L-GATE_BUILD.md
---

# MANDATE — team_90 · cross-engine validation, 2026-07-12 content + quick-fix batch

## Role boundary (read first)

**You are validating, not building.** Do not edit any file under `site/`, `_aos/`, `mu-plugins/`, or `scripts/`. Read-only investigation only. Your ONLY write action is creating the verdict file at the `verdict_path` above.

## Context

A prior team_100 (Claude Code) session reconciled two client-provided (Eyal) ChatGPT-assisted spec documents against the live WordPress theme, found the site runs two parallel template systems (legacy "Wave2" vs live "Chapters"), and — after the client (team_00/Nimrod) ruled on each item — implemented 14 small, scoped changes directly. A same-engine (Claude) Explore-agent self-review already ran once and found + the builder fixed 1 real bug (a `<details>` scroll-reveal visibility issue). You are the first genuinely cross-engine pass.

Full narrative + client rulings: `_COMMUNICATION/team_100/DETAILED-DIFF-EYAL-QA-SEO-VS-CURRENT-SITE-2026-07-12.md`. Prior same-engine review + fix: `_COMMUNICATION/team_100/MANDATE-TEAM10-CONTENT-QA-2026-07-12.md`.

**IMPORTANT — do not re-litigate scope.** Two items were explicitly and deliberately declined by team_00/team_100 after review (not overlooked): (a) H1/H2 wording tweaks the SEO doc suggested — team_100 judged the live copy already equal-or-better (dash style, `/method` H1 keeping the founder's name for E-E-A-T, `/treatment` H2 more keyword-specific); (b) literal `<br>`-per-source-line-break in vekatavta's "10 things" — the source is arbitrary text-editor hard-wrap, not intentional formatting; the live 11-paragraph structure is correct. Do not flag either as a gap unless you find the reasoning itself is wrong.

## What to verify

Run `git diff` from the workspace root first to see the real, current diff (do not trust this document's descriptions — read the actual code). Then confirm, file:line, for each:

1. **Homepage Trust Line** — `home-defaults.php` new `hero_trust` field, rendered in `section-hero.php` above the H1, inside `.hero__c`. **Also verify the escaping**: `section-hero.php`'s `hero_subtitle` line must use `ea_chapters_kses_e()`, NOT `esc_html()` — an `esc_html()` call there was found live-broken (rendered a literal `<br>` as text) and fixed; confirm the fix is actually in place and no other field in this file has the same class of bug (grep the file for `esc_html.*ea_chapters_field` and sanity-check each one against whether that field is expected to carry `<em>/<br>/<strong>`).
2. **Testimonial names clickable** — `section-05-testimonials.php`, `href` carried from `ea_fb_testimonials_all()`/`testi_items`, wrapped in `<a target="_blank" rel="noopener noreferrer">` when present.
3. **`/method` 8-card testimonial carousel** — `method-defaults.php` new `testi_items` (8 named people), wired into `tpl-chapters-method.php` via `parts/testimonials.php`. **Verify the 8 quotes are verbatim-identical** to what git history shows was removed from `split_body` — this was a manual human-adjacent extraction and deserves real scrutiny, not just "looks plausible."
4. **Book reading-excerpt accordions** — `prose.php` new `collapsible`/`toggle_label` args, applied on all 3 book pages' SECTION 03. Confirm the collapsible branch's inner div does NOT carry the `r`/`r2` scroll-reveal classes (a bug was found + fixed here: content nested in a closed `<details>` never intersects the viewport, so the reveal observer never fires and the text would stay invisible after opening — check this specific regression class carefully, including what happens on repeat open/close).
5. **Homepage hero video** — `section-hero.php` `<video>` has no `autoplay`, `preload="none"`; `ea-chapters.js` new block plays it on `window.load` gated by `!reduce`. **Confirm the actual hero video source file itself was not changed** — client was explicit this must stay untouched, only load timing changed.
6. **FAQ font-size** — `ea-atoms.css` `.ea-faq-item__answer p` is `1rem` (was `0.9rem`).
7. **"לימוד והכשרה" nav links** — `section-nav.php`, 3 of 4 sub-links point to real `/learning/...` pages; "קורסים" intentionally still `#` (pending external URL from client, not a bug).
8. **Footer disclaimer** — `section-footer.php` new `.foot__legal` block, verbatim canonical disclaimer text (compare against `template-parts/blocks/block-disclaimer.php`'s default string — must match exactly, this is legally-sensitive copy), plus `/accessibility/` and `/privacy/` links.
9. **`/repair` electronics-engineer sentence** — new sentence in `repair-defaults.php`, check it reads naturally in context and doesn't duplicate/contradict adjacent sentences.
10. **Meta-description mu-plugin** — `site/wp-content/mu-plugins/ea-content-eyal-seo-metadesc-2026-07-12-once.php`. Confirm: (a) valid PHP, (b) unconditionally overwrites `_yoast_wpseo_metadesc` for exactly 8 named routes via `update_post_meta` (not gated on emptiness, unlike its sibling `ea-w2-17-metadesc-backfill-once.php`), (c) the 8 description strings match what's quoted in `DETAILED-DIFF-EYAL-QA-SEO-VS-CURRENT-SITE-2026-07-12.md` §... verbatim — flag any transcription drift.
11. **`_aos/roadmap.yaml`** — new `WP-CANON-TEMPLATE-UNIFICATION` entry. Confirm the YAML is valid (`python3 -c "import yaml; yaml.safe_load(open('_aos/roadmap.yaml'))"`) and doesn't corrupt/duplicate any existing entry.
12. **`scripts/ftp_deploy_site_wp_content.py`** — confirm the new mu-plugin (#10) was correctly added to the deploy file list so it actually ships, and that no existing entry was accidentally altered.

## Also actively look for

- Anything NOT in this list that the diff touches but this mandate doesn't mention (scope-creep or an undocumented change).
- PHP syntax errors (`php -l` every changed `.php` file yourself, don't trust it was already done).
- Any place a change here could interact badly with the still-live Wave2 legacy system (e.g., does anything in this diff assume the Wave2→Chapters unification already happened?).

## Verdict

Write to `_COMMUNICATION/team_90/VERDICT_CONTENT-QA-2026-07-12_L-GATE_BUILD.md`: a table (item # | PASS / FAIL / FINDING | evidence), then an overall verdict line: `PASS`, `PASS_WITH_FINDINGS`, or `FAIL`. Be skeptical — this is exactly the role Iron Rule #1 exists for; do not rubber-stamp a same-engine self-review.
