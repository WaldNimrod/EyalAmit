---
id: DISPOSITION-WP-W2-11-BLOG-S5-CLOSE-2026-06-02
from_team: team_100 (Chief System Architect)
to_team: team_00 (decision record) / team_50 / team_190 / team_10 / team_80
date: 2026-06-02
wp: WP-W2-11 (S003 Base Implementation — Hybrid Track-1)
cluster: Blog (D) — /blog, /blog/<slug>
stage: S5 close
branch: feature/s003-base-implementation-prep
verdict: BUILD-COMPLETE — S5 pre-flight PASS (all ACs met, no staging-cap); external L-GATE_VALIDATE batched
---

# DISPOSITION — WP-W2-11 Blog · S5 close

## 1. What was built (S3 team_10 / S4 team_80)
- **Archive (`/blog`)**: gradient placeholder thumb when no featured image; **IDEA-006 excerpt shortcode-strip** (raw `[vc_row …]` count 10 → **0**); single tab-stop per card.
- **Single (`/blog/<slug>`)**: gradient featured placeholder fallback; **byline → "אייל עמית"** (display-only filter; Yoast nicename + /author/ 301 deferred to cutover SEO); **AC-D3** long-Hebrew typography (66ch measure, line-height 1.9); **Share** (WhatsApp + copy-link, no Facebook) + **Related** (2-up, titles-only); tags/contact-cta/footer retained.
- **S4 (team_80)**: zero D-14 drift; authored the team_00-approved rules-only additions in `ea-blog.css` (gradient placeholders via `.ea-book-hero` gradient verbatim; `.ea-post-content max-width:66ch` — a `ch` constraint, NOT a new token; `.ea-post-share`; `.ea-related` 2-up + titles-only scoping) — existing tokens only, `ea-tokens.css` unchanged.
- **QA-tooling fix (carry-forward #2 from Conversion)**: `scripts/qa/http-qa-lighthouse.sh` now measures **perf over https** (production-representative); axe stays over http.

## 2. Two real defects caught & fixed during S3 (fix-don't-flag)
1. **`ea-blog.css` was never enqueuing** on blog views — the style's declared dependency handle was `ea-tokens`, but the registered handle is `ea-wave2-tokens`; WordPress silently drops a style with an unregistered dependency. **The entire blog D-14 layer was loading as raw HTML.** Fixed (`bc9733a`). *Implication: the prior W2-06 build was effectively serving unstyled; flagged for team_00 awareness — our S5 evaluates the now-correctly-styled page.*
2. **`aria-posinset="NaN"` ×2** (2 critical axe violations on one single post) — root cause was **static markup**: two pasted **Facebook embed wrappers** in a legacy post's `post_content` (imported via `blog-legacy.wxr`), carrying `aria-posinset="NaN"` + dangling `aria-describedby/labelledby` refs. NOT the Related cards (adjacent in source — initial misattribution). Fixed via a single-post-scoped `the_content` filter that neutralizes the invalid ARIA at render time (no DB mutation; generalizes to future pasted embeds) (`fce7b11`).

## 3. S5 pre-flight (team_100, corrected QA tooling)
| Route | axe (crit/serious) | LH mobile perf — median of 3 (https) | a11y |
|-------|--------------------|--------------------------------------|------|
| `/blog/` | 0 / 0 | **98** (98/98/97) | 100 |
| single (podcast post) | 0 / 0 | **97** (98/97/96) | 100 |

All bars met **outright** — unlike Conversion, **no staging-cap needed** (the https QA-tool fix removed the redirect artifact; perf is genuinely ≥85). Evidence on-disk under `scripts/qa/reports/` (gitignored, per convention).

## 4. AC roll-up (Blog cluster)
| AC | State | Basis |
|----|-------|-------|
| AC-01 / AC-D2 composition vs D mockups | PASS | archive + single match; D-14 rules live |
| AC-02 zero D-14 drift | PASS | team_80 (existing tokens only) |
| AC-03 axe 0 crit/serious | PASS | both routes (after FB-embed fix) |
| AC-04 / AC-D4 LH a11y/perf | **PASS** | a11y 100; mobile perf 98 / 97 (https) — no cap |
| AC-05 graceful gaps | PASS | gradient placeholders; clean excerpts; no console errors |
| AC-06 repo gates | PASS | validate_aos 0 FAIL; php -l clean |
| AC-07 live HTTP 200 | PASS | both routes |
| AC-D3 long-Hebrew typography | PASS | 66ch / line-height 1.9, RTL |
| Bonus AC-D4 IDEA-006 | PASS | `[vc_row]` 10 → 0 |

**Blog cluster: BUILD-COMPLETE, S5 pre-flight PASS.** Remaining: external **L-GATE_VALIDATE** (team_190, cross-engine/Codex) — batched (paste-ready prompt in the Blog mandate §6), same external step Conversion received. team_50 build-gate is reproduced by this pre-flight (clean); a formal team_50 verdict file can be backfilled with the external run.

## 5. Carry-forwards (tracked, non-blocking)
1. **Yoast author nicename** (eyaladmin→eyal-amit) + `/author/` 301 — deferred to production-cutover SEO pass (per team_00).
2. **Permanent post_content cleanup** of the pasted Facebook embeds (or oEmbed re-embed) — optional long-term; the render-time filter covers it for now.
3. **W2-06 enqueue bug** — now fixed; note that any prior W2-06 visual sign-off predated correctly-loaded blog CSS.
4. **External L-GATE_VALIDATE** for Blog (and Conversion) — route to Codex per mandate; gate-order + mobile-axis discipline re-affirmed in the Blog mandate.

## 6. Next
WP-W2-11 remains **IN_PROGRESS**; final cluster = **Home refine**. No `main` merge/push without explicit team_00 go.
