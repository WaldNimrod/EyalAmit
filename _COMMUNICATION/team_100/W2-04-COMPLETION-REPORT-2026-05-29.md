---
id: W2-04-COMPLETION-REPORT-2026-05-29
from_team: team_10 (Builder)
to_team: team_100 (Chief System Architect)
wp: WP-W2-04 — Sound Healing + Lessons (2 service pages)
date: 2026-05-29
status: BUILD COMPLETE — ready for L-GATE_BUILD (team_50, non-Claude)
spec_ref: _aos/work_packages/S002/WP-W2-04/LOD400_spec.md
mandate_ref: _COMMUNICATION/team_10/MANDATE-TEAM10-W2-04-SOUND-HEALING-LESSONS-2026-05-29.md
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-04 (branch feature/w2-04-services)
---

# WP-W2-04 Completion Report — Sound Healing + Lessons

## Live URLs + HTTP status (cache-busted)
- http://eyalamit-co-il-2026.s887.upress.link/sound-healing/ → **HTTP 200**
- http://eyalamit-co-il-2026.s887.upress.link/lessons/ → **HTTP 200**

Both render the full 10-block contract (verified via curl against the deployed pages).

## Files changed
| File | Action | Purpose |
|------|--------|---------|
| `inc/wave2-w2-04.php` | NEW | Router (top-level slug match @ priority 100, mirrors W2-02), body class `ea-wave2-shell` + `ea-service-<slug>`, no-sidebar, GP title hide, `ea_wave2_shell` query var, asset enqueue, and the `the_content` injection + block renderers (hero/prose/steps/faq/testimonials/cta). |
| `inc/wave2-w2-04-content.php` | NEW | Content provider: 10 ordered blocks per page, transcribed 1:1 from the 25.5.26 sources. |
| `functions.php` | EDIT (surgical) | Appended `require_once .../inc/wave2-w2-04.php`. |
| `template-parts/blocks/block-faq-list.php` | EDIT | Added optional `$ea_faq_only_category` arg → view-only single-category render (no chips/JS). Default `/faq` unchanged. Dataset NOT duplicated. |
| `assets/js/ea-ab-testing.js` | EDIT | Extended canonical `eyal_cta_variant` mechanism to toggle the in-page `[data-ea-ab]` CTA block + GA4 `cta_click { variant_label, page }`. No new variant key. |
| `assets/css/w2-04-service.css` | NEW | Hero/prose/steps/testimonials-accordion/view-only-FAQ/A-B-CTA styling. D-14 tokens only, no raw hex. |
| `style.css` | EDIT | Version 1.4.2 → 1.4.3 (single bump). |

## Architecture notes
- tpl-service.php is a thin shell that renders `the_content()` only, and FTP deploy cannot write `post_content`. Per mandate §2b, the 10-block HTML is injected via `add_filter('the_content', …, 9)` guarded by `is_main_query() && in_the_loop()`, keyed on the two top-level slugs. The two pages already exist in the DB (both returned 200 pre-build, empty content).
- Block→slot mapping (10 blocks each):
  - `/sound-healing`: hero · intro(prose) · what-it-is(prose) · what's-special(prose) · how-it-works(prose) · benefits(prose) · who-it's-for(prose) · FAQ(view-only) · testimonials(Top-5 accordion) · CTA(A/B). (= hero + 6 prose + faq + testimonials + cta)
  - `/lessons`: hero · intro(prose) · what-it-is(prose) · why/benefits(prose) · how-it-works(prose) · what-you-learn(steps accordion) · who-it's-for + why-Eyal(prose) · FAQ(view-only) · testimonials(Top-5 accordion) · CTA(A/B). (= hero + 5 prose + steps + faq + testimonials + cta)

## Per-AC status
- **AC-01 — both URLs 200:** PASS. /sound-healing 200, /lessons 200.
- **AC-02 — H1 + body 1:1 with source:** PASS. H1s match source verbatim; full body transcribed 1:1 under the §2c normalization rule (see flags).
- **AC-03 — FAQ shows ONLY page category, view-only:** PASS. /sound-healing renders 8 `sound-healing` items, /lessons renders 8 `lessons` items; 0 leakage from other categories; no filter select/chips present. `/faq` full filterable list unchanged (single shared dataset).
- **AC-04 — testimonials text + image + link:** PASS (with placeholder images). 5 testimonials per page (Top-5) in an accordion; each has text + grey avatar placeholder (W2-07 pending, declared carry-forward) + FB anchor link opening in a new tab.
- **AC-05 — every CTA active (form + WhatsApp per A/B variant), GA4 wired:** PASS. In-page `[data-ea-ab]` CTA block with both targets present: form → `/contact?subject=<slug>`, WhatsApp → `https://wa.me/972524822842`. ea-ab-testing.js (v1.4.3, enqueued on both pages) assigns the per-session canonical variant and toggles form/WA visibility (form_only→A, dual→B, wa_only→C) and fires GA4 `cta_click { variant_label, page }`.
- **AC-06 — validate_aos 0 FAIL; mobile responsive:** PASS. `validate_aos.sh .` → **30 PASS / 18 SKIP / 0 FAIL**, "L-GATE_BUILD EXIT CRITERION: SATISFIED". Mobile: responsive hero type via `clamp()`, CTA buttons stack at ≤600px, prose constrained to `--ea-prose-width`.

## AC-05 normalization decisions + FLAGS
Applied team_00 aos_decide B: normalized clear/obvious typos, preserved Eyal's voice & spoken-style slang. Decisions:
1. **Internal-link slugs normalized (technical, not voice) — FLAG:** The lessons source `.md` used non-canonical route slugs that do not exist on the live site:
   - `/method-cbdidg` → normalized to **`/method`** (sound-healing source).
   - `/didgeridoo-treatment` → normalized to **`/treatment`** (lessons source, 2 occurrences).
   - `/blog/pregnancy-didgeridoo` (lessons FAQ "האם אפשר בזמן הריון") — this link exists only in the source `.md`; the FAQ block dataset (block-faq-list.php) for that question has **no link** ("לא מומלץ."). Since AC-03 mandates the FAQ block dataset is the single source of truth and must not be duplicated, the rendered FAQ uses the existing dataset answer (no pregnancy-blog link). **FLAG for team_100:** decide whether the `/blog/pregnancy-didgeridoo` "קראו עוד" link should be added to the canonical FAQ dataset.
2. **Markdown decorations dropped (presentational, not content):** the source `👉` emoji prefixes on links and the "DEV NOTES" blocks were not rendered (they are authoring/layout instructions, not page copy). No wording changed.
3. **No genuine spelling/voice ambiguities** were encountered in the body prose that required guessing — Eyal's spoken-style phrasing (e.g. "ג'אגלינג של מערכת הנשימה", "וואו") preserved verbatim.

## Testimonial text / placeholder notes
- Testimonial **text** was sourced directly from the page `.md` files (SECTION 09 sound-healing carousel; SECTION 08 lessons). 5 used per page (Top-5), verbatim, with `\n` preserved as `<br>`.
- Testimonial **images = grey avatar placeholders** (`.ea-testimonial-card__avatar-placeholder`, sand-token circle), consistent with the W2-03 grey-placeholder pattern. This is the declared **W2-07 carry-forward**. For L-GATE_VALIDATE: placeholders are acceptable only if W2-07 is still open at validation time (per spec F02); if W2-07 is closed, final images are required.

## Deploy
`python3 scripts/ftp_deploy_site_wp_content.py` — completed OK (child theme + mu-plugins synced). Verified deployed `style.css` Version=1.4.3 and assets load on both pages.

## validate_aos result
`bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` → **30 PASS / 18 SKIP / 0 FAIL** — L-GATE_BUILD EXIT CRITERION: SATISFIED.

## Surgical commits (by file name, no git add -A)
- `ad53e47` — WP-W2-04: router + content provider + functions.php wiring.
- `00c488b` — WP-W2-04: FAQ/CTA reuse, w2-04-service.css, style.css 1.4.3.

`local/.env.upress` NOT committed. `_aos/` not touched. The pre-existing unrelated `_aos/.../DECISION-REQUEST-PRECONDITION1...` modification was left unstaged.

*team_10 (Builder) — 2026-05-29.*
