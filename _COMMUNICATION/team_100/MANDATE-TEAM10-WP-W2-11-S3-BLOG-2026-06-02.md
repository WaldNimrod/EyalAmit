---
id: MANDATE-TEAM10-WP-W2-11-S3-BLOG-2026-06-02
from_team: team_100 (Chief System Architect)
to_team: team_10 (Builder)
date: 2026-06-02
wp: WP-W2-11 (S003 Base Implementation — Hybrid Track-1)
cluster: Blog (D) — /blog, /blog/<slug>
stage: S3 (Refine/implement — composition-only on the W2-06 build)
branch: feature/s003-base-implementation-prep
status: ISSUED
spec_ref: _aos/work_packages/S003/WP-W2-11/LOD400_spec.md
source_of_truth: _COMMUNICATION/team_35/WP-W2-10-D/
predecessor: Conversion cluster CLOSED (DISPOSITION-WP-W2-11-CONVERSION-S5-CLOSE-2026-06-02.md)
---

# MANDATE — team_10 · WP-W2-11 S3 · Blog cluster (`/blog`, `/blog/<slug>`)

## 0. Authorization & team_00 decisions (2026-06-02)
- Option C Track-1; Blog is a settled cluster (REAL templates, W2-06 build + validated `ea-blog.css`). Proceed now.
- **team_00 decisions this round:**
  - **Share + Related (Q5): APPROVED.** Add to single. **Share targets = WhatsApp + copy-link ONLY (no Facebook).** Related = 2-up `block-blog-card`, titles. These are net-new compositions → **team_80 registers the D-14 rules** (approved-GCR path, existing atoms/tokens). You build the markup reusing existing geometry (footer-social button geometry for share, `block-blog-card` for related); team_80 fills any CSS gaps at S4.
  - **Author byline (Q1): display "אייל עמית"** (display-only filter). **Defer** the Yoast nicename (eyaladmin→eyal-amit) + `/author/` 301 to the production-cutover SEO pass (carry-forward — do NOT do it here).
  - **Defaults applied (no further sign-off needed):** Q2 featured-image → **gradient placeholder** (reuse `.ea-book-hero` earth→chocolate→ink gradient language, with descriptive `aria-label`); Q3 categories → **keep the live filter as-is** (`hide_empty=true` already governs it); Q4 reading measure → **cap body at 66ch** (a `ch` constraint, NOT a new token — team_80 confirms at S4); Q6 → **IDEA-006 excerpt shortcode-strip** (cards show clean Hebrew, never raw `[vc_row …]`) — bonus AC-D4.

## 1. Scope (composition-only, on top of the W2-06 build)
| Route | Template | Source of truth |
|-------|----------|-----------------|
| `/blog` | `page-templates/tpl-blog-archive.php` + `template-parts/blocks/block-blog-card.php` | `_COMMUNICATION/team_35/WP-W2-10-D/mockup/blog-archive.html` + `narrative/composition-notes.md` Screen 1 |
| `/blog/<slug>` | `page-templates/tpl-blog-single.php` | mockup `blog-single.html` + composition-notes Screen 2 |

D-14 SSoT: `assets/css/ea-tokens.css`, `ea-atoms.css`, and the validated W2-06 sheet `ea-blog.css`. Reuse verbatim.

## 2. S3 deltas

### `/blog` archive (composition-notes Screen 1)
- Grid `.ea-blog-grid` 3-up → 2-up ≤900px → 1-up ≤560px (already in `ea-blog.css` — verify, don't duplicate).
- Category filter `.ea-blog-filter` + pagination `.ea-blog-pagination` already exist in the template — keep as-is.
- **`block-blog-card`**: 16:9 thumb with **gradient placeholder when no featured image** (reuse `.ea-book-hero` gradient language, `aria-label`); cat eyebrow / title / **clean excerpt** / date. **IDEA-006: strip Visual-Composer shortcodes from the excerpt** so cards never render `[vc_row …]` — use an excerpt shortcode-strip (e.g. `strip_shortcodes()` + `wp_strip_all_tags()` on the raw excerpt/content), clamped to 3 lines. Single tab stop per card (title `<a>`; thumb wrapper `tabindex="-1"`, `:focus-within` ring).

### `/blog/<slug>` single (composition-notes Screen 2)
- **Featured image**: when `has_post_thumbnail()` → render as today; **else render a gradient placeholder** `.ea-post-featured` (earth→chocolate→ink, `aria-label`) — graceful (AC-05), no broken UI.
- **Author byline → "אייל עמית"**: filter the displayed author name (display-only). Prefer a theme filter on `get_the_author()` output / `the_author` so it shows "אייל עמית" without touching the WP user nicename. Do NOT change the WP user, Yoast nicename, or add `/author/` 301 (deferred).
- **Reading typography (AC-D3)**: body `--ea-type-body-lg`, `line-height:1.9`, **measure capped at 66ch** inside the `--ea-prose-width` column; paragraph rhythm `--ea-space-3`; `h2/h3` per tokens; body colour `--ea-text-body`.
- **Tags** `.ea-post-tags` — keep.
- **NEW — Share row** (`.ea-post-share`): **WhatsApp + copy-link only** (no Facebook). Round bordered icon buttons reusing footer-social geometry; each with `aria-label`; copy-link via a small inline script (no console errors; graceful if clipboard API unavailable). WhatsApp uses the site WhatsApp share intent.
- **NEW — Related posts** (`.ea-related`): 2-up `block-blog-card` (titles), same-category or recent fallback; reuses existing card atom.
- **contact-cta** + **footer-social** — already appended; keep.

> For the two NEW sections, build clean semantic markup with the class names above and reuse existing atom geometry as far as possible. Any missing CSS rules are **team_80's** to author at S4 (team_00-approved D-14 registration, existing tokens only). Do NOT invent new tokens yourself.

## 3. HARD CONSTRAINTS
- Composition-only; reuse D-14/`ea-blog.css` atoms verbatim; no new token VALUES; no raw hex in new rules; no inline `style=""` (gradient placeholders use existing atom classes).
- RTL: logical properties only.
- `php -l` clean on every touched PHP. Behaviour-only JS (copy-link, any filter) passes `node --check`.
- **Surgical per-file commits** on `feature/s003-base-implementation-prep`; never `git add -A`; end commit bodies with `Co-Authored-By: Claude Opus 4.8 <noreply@anthropic.com>`. No push/merge.
- Deploy to staging via `python3 scripts/ftp_deploy_site_wp_content.py`.
- **No self-validation** (no axe/Lighthouse against ACs) — S5 is team_50 → team_190 (cross-engine). Self-smoke only: `/blog/` + a single post URL return HTTP 200; gradient placeholder renders; excerpts are clean (no `[vc_row]`); byline shows "אייל עמית"; share/related render; no PHP/console errors.

## 4. ALSO — QA-tooling fix (carry-forward #2 from Conversion close)
Patch **`scripts/qa/http-qa-lighthouse.sh`** so the **performance** measurement targets **https** (production-representative), eliminating the http→https 301 redirect artifact that falsely capped Conversion mobile perf at 83. Keep `--ignore-certificate-errors` (staging cert expired). axe (`http-qa-axe.cjs`) stays over http (AC-03 unaffected — redirect doesn't change DOM a11y). Make this a separate surgical commit. Document the change in a one-line comment referencing the Conversion disposition. This ensures Blog's S5 measures real perf.

## 5. Acceptance (Blog subset of WP-W2-11 ACs + child AC-D*)
- **AC-01 / AC-D2** archive + single match the team_35 D mockups (composition-only).
- **AC-02** zero D-14 token drift (team_80 S4; share/related rules use existing tokens).
- **AC-03** axe 0 critical / 0 serious on `/blog` + a single post.
- **AC-04 / AC-D4** Lighthouse (measured on https per §4): a11y 100, mobile perf ≥85 (triple-run median).
- **AC-05** gradient featured placeholder + clean empties degrade gracefully; no console errors.
- **AC-06** validate_aos 0 FAIL + final_pre_cutover_check exit 0 + php -l clean.
- **AC-07** deployed, `/blog` + single HTTP 200, cache-busted.
- **AC-D3** long-Hebrew reading typography (66ch / line-height 1.9, RTL).
- **Bonus AC-D4** IDEA-006 excerpt `[vc_row]` cleared.

## 6. Downstream gates (paste-ready)
### S4 → team_80
Token-compliance audit (zero drift) **+ author the approved D-14 rules** for `.ea-post-share` and `.ea-related` (and any gradient-placeholder/66ch gaps) using EXISTING tokens only — same pattern as the Conversion rules-only addition (team_00-approved). Confirm the 66ch measure is a `ch` constraint, not a new token. Write `TOKEN-COMPLIANCE-WP-W2-11-BLOG-2026-06-0X.md` to `_COMMUNICATION/team_80/`.

### S5 → team_50 (L-GATE_BUILD, non-Claude) — PASTE-READY
```
Run QA on the EyalAmit staging Blog routes after the WP-W2-11 Blog S3 deploy.
cd /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
  node scripts/qa/http-qa-axe.cjs /blog/ <one-single-post-path>
  bash scripts/qa/http-qa-lighthouse.sh /blog/ <one-single-post-path>
NOTE: http-qa-lighthouse.sh now measures perf on https (production-representative) per the
Conversion disposition — the http->https redirect artifact is gone. axe stays over http.
PASS bar: axe 0 critical AND 0 serious BOTH routes; LH a11y 100 (>=97 only if documented
moderate), mobile perf >=85 (triple-run median). Write
QA-VERDICT-WP-W2-11-BLOG-L-GATE-BUILD-2026-06-0X.md to _COMMUNICATION/team_50/. Report exit codes.
ONLY after this PASSES, route to team_190 L-GATE_VALIDATE (gate-order discipline).
```
### S5 → team_190 (L-GATE_VALIDATE, Codex / cross-engine) — PASTE-READY
```
Constitutional L-GATE_VALIDATE for WP-W2-11 Blog cluster — RUN ONLY AFTER team_50 build-gate PASSES.
Cross-engine (builder team_10 != you). Verify against _aos/work_packages/S003/WP-W2-11/LOD400_spec.md
AC-01..07 (Blog subset) + AC-D2/D3/D4 + the team_50 verdict (confirm the file exists). Evaluate AC-04 on
the MOBILE triple-run median (NOT desktop). Re-verify live (https, base eyalamit-co-il-2026.s887.upress.link,
/blog/ + a single post): composition matches the team_35 D mockups, zero D-14 drift, axe 0 crit/serious,
LH a11y 100 / mobile perf >=85, gradient featured placeholder + clean excerpts (no [vc_row]) + byline
"אייל עמית" + share(WhatsApp+copy-link)/related render with no console errors. Issue PASS/FAIL with 8-check
rationale to _COMMUNICATION/team_190/VERDICT-WP-W2-11-BLOG-L-GATE-VALIDATE-2026-06-0X.md.
```

*Issued by team_100. Iterate within this mandate; escalate blockers to team_100.*
