---
id: MANDATE-TEAM80-WP-W2-12-S3-DS-HYGIENE-2026-06-02
from_team: team_100 (Chief System Architect)
to_team: team_80 (Design-System Owner)
date: 2026-06-02
wp: WP-W2-12 (S003 DS-Hygiene)
stage: S3 (DS owner implements)
branch: feature/s003-ds-hygiene
status: ISSUED (execute on team_00 go)
spec_ref: _aos/work_packages/S003/WP-W2-12/LOD400_spec.md
---

# MANDATE — team_80 · WP-W2-12 S3 · DS-Hygiene (tokenize stagger + de-inline POC blocks)

## 0. Authorization
team_00 approved opening this dedicated WP (2026-06-02) to clear the inline-style debt you flagged at WP-W2-11
Home S4. New stagger tokens are a gated D-14 change — **authorized under this WP**.

## 1. Scope — 6 POC blocks (composition unchanged)
`template-parts/blocks/`: `block-method-pillars.php`, `block-treatment-overview.php`, `block-testimonials-row.php`,
`block-books-row.php`, `block-services-row.php`, `block-contact-cta.php`. CSS: `assets/css/ea-tokens.css`,
`ea-atoms.css` (and `ea-animations.css` if delays belong in the animations layer).

## 2. Work
1. **Inventory** every inline `style=""` in the 6 blocks; capture each declaration + computed value (note them in your verdict).
2. **Tokenize** the entrance-animation stagger delays as D-14 tokens in `ea-tokens.css` — prefer a single
   `--ea-stagger-step` consumed via `calc(var(--ea-stagger-step) * n)`, or `--ea-stagger-1..N` if clearer. No magic numbers left inline.
3. **Relocate** the declarations into class / `nth-child` rules in `ea-atoms.css` (or animations layer), referencing the new
   stagger tokens + existing spacing tokens. **Remove the inline `style=""`** from the PHP.
4. RTL logical properties preserved; `prefers-reduced-motion` honored (existing pattern).
5. Deploy: `python3 scripts/ftp_deploy_site_wp_content.py`.

## 3. HARD CONSTRAINT — PIXEL-IDENTICAL
This is hygiene, not a redesign. The homepage `/` must render **pixel-identical** before/after (layout + animation
timing). Capture before/after evidence (screenshots or computed-style comparison) for `/` at desktop + mobile. If any
value can't be reproduced exactly with a token, keep the exact literal value in the CSS rule (documented) rather than
changing it.

## 4. Acceptance (per LOD400 spec)
AC-01 pixel-identical · AC-02 zero inline `style=""` left in the 6 blocks (`grep` clean) · AC-03 new stagger tokens in
ea-tokens.css, no raw magic numbers / no raw hex in new rules · AC-04 axe 0 crit/serious + LH a11y 100 / mobile perf ≥85
on `/` (unchanged) · AC-05 validate_aos 0 FAIL + php -l clean · AC-06 deployed, `/` 200.

## 5. Constraints
Surgical per-file commits on `feature/s003-ds-hygiene` (never `git add -A`; `Co-Authored-By: Claude Opus 4.8 <noreply@anthropic.com>`). No push/merge. No self-validation against ACs beyond your own pixel-diff check (S5 = team_50 → team_190/Cursor). Do not touch blocks outside the 6, or `_aos/`.

## 6. Downstream (paste-ready)
**S5 → team_50 (build-gate):** `node scripts/qa/http-qa-axe.cjs /` + `bash scripts/qa/http-qa-lighthouse.sh /` → axe 0/0, a11y 100, mobile perf ≥85. **S5 → team_190 (validate, run in CURSOR, cross-engine):** verify pixel-identical rendering + zero inline styles + token-correctness + axe/LH unchanged; PASS/FAIL → `_COMMUNICATION/team_190/VERDICT-WP-W2-12-L-GATE-VALIDATE-2026-06-0X.md`.

*Issued by team_100. Pixel-identical is the bar — when a value can't be tokenized exactly, keep the literal and document it.*
