---
id: TOKEN-COMPLIANCE-WP-W2-11-BLOG-2026-06-02
from_team: team_80 (Design-System Owner / Token-Compliance Validator)
to_team: team_100 (Chief System Architect)
date: 2026-06-02
wp: WP-W2-11 (S003 Base Implementation — Hybrid Track-1)
cluster: Blog (D) — /blog, /blog/<slug>
stage: S4 (token-compliance gate — internal build-side, NOT external S5 QA)
branch: feature/s003-base-implementation-prep
builder_ref: team_10 S3 (tpl-blog-single.php, block-blog-card.php, wave2-w2-06.php, ea-blog-share.js)
spec_ref: _aos/work_packages/S003/WP-W2-11/LOD400_spec.md
mandate_ref: _COMMUNICATION/team_100/MANDATE-TEAM10-WP-W2-11-S3-BLOG-2026-06-02.md §6
precedent_ref: _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-11-CONVERSION-2026-06-02.md §5
verdict: PASS
gcr_needed: RESOLVED (team_00-approved rules-only addition authored 2026-06-02)
---

# S4 Token-Compliance Verdict — WP-W2-11 Blog (`/blog`, `/blog/<slug>`)

**VERDICT: PASS** — zero D-14 token drift (AC-02 satisfied), and the team_00-approved
rules-only D-14 additions for the new Blog selectors are authored using existing tokens
only. AC-01 composition fidelity for the new Share/Related/placeholder/measure selectors
is now CLOSEABLE. This is the internal build-side gate; external axe/Lighthouse remains S5
(team_50 → team_190). No `_aos/`, PHP, or JS was edited in this pass — `ea-blog.css` only.

CSS SSoT note: the live D-14 sheets for this spoke are under
`site/wp-content/themes/ea-eyalamit/assets/css/` (`ea-tokens.css`, `ea-atoms.css`,
`ea-blog.css`); the mandate's `assets/css/...` paths are repo-relative shorthand for these.

---

## 1. Drift audit (AC-02) — per check

Scope audited: the four S3-changed files —
`page-templates/tpl-blog-single.php`, `template-parts/blocks/block-blog-card.php`,
`inc/wave2-w2-06.php`, `assets/js/ea-blog-share.js`. CSS SSoT cross-referenced read-only.

| # | Check | Result | Evidence |
|---|-------|--------|----------|
| D1 | `git diff main..HEAD -- ea-tokens.css` EMPTY | **PASS** | Token SSoT untouched by S3 AND by this S4 addition. |
| D2 | Zero new token VALUES | **PASS** | No `--ea-*` declarations added anywhere (PHP/JS/CSS). |
| D3 | Zero raw hex in new rules | **PASS** | `grep -E '#[0-9A-Fa-f]{3,6}'` over the new CSS block (and over the S3 PHP/JS `+` lines) → NONE. |
| D4 | Zero inline `style="…"` (PHP) | **PASS** | `grep 'style="'` over added PHP `+` lines → NONE. Gradient placeholders use atom classes (`.ea-blog-card__thumb-placeholder`, `.ea-post-featured__placeholder`), not inline styles. |
| D5 | Zero new `@keyframes` | **PASS** | None in the addition. Motion limited to a `transition` on the share button, gated by `prefers-reduced-motion`. |
| D6 | No new atoms beyond the approved ones | **PASS** | All new selectors are exactly the team_00-approved set (see §2). No others introduced. |

### Note on the JS `.style.*` lines (not a drift finding)
`ea-blog-share.js` sets `ta.style.position`/`ta.style.left = '-9999px'` on an
**off-screen, never-rendered `<textarea>`** used purely as the legacy `execCommand('copy')`
clipboard fallback. This is a behavior-only utility element (matches the existing
`-9999px` off-screen house pattern), removed immediately after copy — not a styled visual
atom and not an inline style on rendered UI. No D-14 implication.

**Drift-audit conclusion: ZERO D-14 token drift.** AC-02 satisfied.

---

## 2. Approved rules authored (selectors → tokens)

Authored into `ea-blog.css` (preferred home for blog rules) under banner
`/* WP-W2-11 Blog — D-14 rules-only addition, team_00-approved 2026-06-02 */`.
Nothing was added to `ea-atoms.css` — every new selector is blog-scoped, so the blog
sheet is the correct home (no genuinely global rule among them).

| Selector | Properties → tokens |
|----------|---------------------|
| `.ea-blog-card__thumb-placeholder` | `width/height:100%`; `background: linear-gradient(135deg, var(--ea-earth) 0%, var(--ea-chocolate) 55%, var(--ea-ink) 100%)` — the `.ea-book-hero` gradient language **verbatim** (ea-atoms.css L1413). Sits inside the existing 16:9 `.ea-blog-card__thumb`. |
| `.ea-post-featured__placeholder` | `aspect-ratio:16/9`; same earth→chocolate→ink gradient (no new value). |
| `.ea-post-content` | `max-width: 66ch` — measure cap (see §3). |
| `.ea-post-share` | flex row; `gap: var(--ea-space-2)`; `margin-block-start: var(--ea-space-6)`; `padding-block-start: var(--ea-space-3)`; `border-block-start: 1px solid var(--ea-line)`. |
| `.ea-post-share__label` | `font: var(--ea-type-body-sm)`; `color: var(--ea-muted)`. |
| `.ea-post-share__link` | round bordered icon button: `width/height: var(--ea-space-5)`; `font: var(--ea-type-body-sm)`; `color: var(--ea-text)`; `background: var(--ea-bg)`; `border: 1px solid var(--ea-line)`; `border-radius: var(--ea-radius-pill)`; `transition: …0.2s` (footer-social/cta-pill button geometry language, existing tokens). |
| `.ea-post-share__link:hover, .is-copied` | `color: var(--ea-accent)`; `border-color: var(--ea-accent)`; `background: var(--ea-bg-alt)`. (`.is-copied` is the JS copy-confirmation class.) |
| `.ea-post-share__link:focus-visible` | `outline: 2px solid var(--ea-terracotta)`; `outline-offset: 3px` — house focus-ring style (matches `.ea-cta-pill` / `.ea-sound-toggle`). |
| `.ea-related` | `max-width: var(--ea-prose-width)`; `margin:0 auto`; `padding: 0 var(--ea-space-4) var(--ea-space-8)`; `direction: rtl`. |
| `.ea-related__heading` | `font: var(--ea-type-h2)`; `color: var(--ea-text)`; `margin-block-end: var(--ea-space-5)`. |
| `.ea-related__grid` | `display:grid`; `grid-template-columns: repeat(2,1fr)`; `gap: var(--ea-space-5)`; collapses to 1-up `@media (max-width:560px)` (matches the established `.ea-blog-grid` breakpoint). |
| `.ea-related .ea-blog-card__excerpt, __date, __cat` | `display: none` — **titles-only scoping** (see §4). |

House-style literals used (each already established in `ea-blog.css` / `ea-atoms.css`,
no token exists for them — same documented practice as the Conversion addition):
- `1px solid var(--ea-line)` borders — verbatim pattern from `.ea-blog-card`, `.ea-post-meta`, `.ea-post-tags`.
- `transition: …0.2s` durations — verbatim from `.ea-blog-filter__item`, `.ea-post-tags a`.
- `2px solid` / `3px` focus-ring outline + offset — verbatim from `.ea-cta-pill:focus-visible` / `.ea-sound-toggle:focus-visible`.
- gradient stop percentages `0% / 55% / 100%` — copied verbatim from `.ea-book-hero`.

RTL: logical properties only (`margin-block-*`, `padding-block-*`, `border-block-start`).
Motion: the only transition (`.ea-post-share__link`) is disabled under
`@media (prefers-reduced-motion: reduce)`. Placeholders and grids are static (no motion).

---

## 3. 66ch measure — explicit confirmation (NOT a new token)

`max-width: 66ch` on `.ea-post-content` is a **`ch` relative-length constraint** (sized to
the rendered font's "0" advance), **not** a design-system token and **not** a new
`--ea-*` value. Per mandate Q4 / AC-D3 it caps the long-Hebrew reading measure inside the
column already bounded by `--ea-prose-width` (on `.ea-wave2-blog-single`). Confirmed:
`git diff main..HEAD -- ea-tokens.css` is EMPTY; no `--ea-*` declaration was added.
This matches the team_00 instruction ("a `ch` constraint, NOT a new token — team_80
confirms at S4").

---

## 4. Related titles-only handling (CSS-only, markup unchanged)

team_10 reused the FULL `block-blog-card` for the Related grid, but mockup Screen 2 shows
**titles only**. Per mandate, this is handled **in CSS within the `.ea-related` scope** —
markup is NOT changed:

```
.ea-related .ea-blog-card__excerpt,
.ea-related .ea-blog-card__date,
.ea-related .ea-blog-card__cat { display: none; }
```

Result: inside Related, each card renders the title link only (single tab stop preserved —
the title `<a>` remains the lone focusable element; the thumb wrapper keeps `tabindex="-1"`).
The card atom is untouched everywhere else (archive cards keep excerpt/date/cat).

---

## 5. Verification summary

- `git diff main..HEAD -- ea-tokens.css` → **EMPTY** (token SSoT unchanged). ✔
- Raw hex `#[0-9A-Fa-f]{3,6}` in the new CSS block → **NONE**. ✔
- New `--ea-*` property declarations → **NONE**. ✔
- New `@keyframes` → **NONE**. ✔
- Inline `style="…"` in S3 PHP → **NONE**. ✔
- New atoms beyond the team_00-approved set → **NONE**. ✔

---

## 6. Verdict & handback

- **AC-02 (zero D-14 token drift): PASS.**
- **AC-01 (composition match) for the new Blog selectors: now CLOSEABLE** — gradient
  placeholders, 66ch measure, Share row (WhatsApp + copy-link), and the 2-up titles-only
  Related grid are styled in D-14 to the team_35 D-mockup intent using existing tokens only.
- **OVERALL VERDICT: PASS.**

team_80 authored `ea-blog.css` only. **Not deployed** — team_10 will redeploy the updated
CSS to staging next. Not pushed/merged (stays on `feature/s003-base-implementation-prep`).
External S5 axe/Lighthouse remains team_50 → team_190.

— team_80 (2026-06-02)
