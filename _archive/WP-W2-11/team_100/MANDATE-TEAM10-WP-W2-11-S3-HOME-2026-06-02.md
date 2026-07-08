---
id: MANDATE-TEAM10-WP-W2-11-S3-HOME-2026-06-02
from_team: team_100 (Chief System Architect)
to_team: team_10 (Builder)
date: 2026-06-02
wp: WP-W2-11 (S003 Base Implementation — Hybrid Track-1)
cluster: Home refine — /
stage: S3 (Refine — composition-only on the POC-reviewed deployed home)
branch: feature/s003-base-implementation-prep
status: ISSUED
spec_ref: _aos/work_packages/S003/WP-W2-11/LOD400_spec.md
---

# MANDATE — team_10 · WP-W2-11 S3 · Home refine (`/`)

## 0. Authorization & team_00 decisions (2026-06-02)
Home is the **POC-reviewed, signed-off composition** (already deployed; currently axe-clean, a11y 100, perf ~95). Refine is **conservative and composition-only** — do NOT restructure or restyle the approved composition beyond the two approved deltas below.
- **Hero headline (IDEA-005): KEEP the current `<br>` line break** — no change to the H1.
- **Hero placeholder: REPLACE the external `picsum.photos` image with a CSS-only gradient.** Keep the existing D-14 gradient + breathing-line overlay; remove the third-party `<img>`/external request entirely.

## 1. Scope
`/` → `page-templates/tpl-home.php` → `ea_wave2_render_home_blocks()` (12 blocks). The ONLY substantive change is the hero placeholder (`template-parts/blocks/block-hero.php`). Everything else is verify-only.

## 2. S3 deltas
1. **`block-hero.php` — remove external image**: delete the `picsum.photos` `<img class="ea-hero__placeholder">` (and any related external URL). The interim hero must render with the **CSS gradient + breathing lines only** — zero external network requests from the hero. Verify white H1/subtitle/trust text keeps AA contrast over the gradient-only background (adjust the existing overlay opacity token if needed — existing tokens only). Keep the structure ready for the future `<video>` swap (Eyal G asset, blocked).
   - If the placeholder image rule lives in CSS (`.ea-hero__placeholder`), remove/neutralize the now-unused rule (team_80 confirms no orphan/drift at S4).
2. **Everything else (blocks 2–12): verify-only** — confirm D-14 token alignment, RTL logical properties, heading hierarchy (single H1), `main#main` landmark, mobile ≤375px. Do NOT change the approved composition. If you spot a genuine defect (broken markup, console error, a11y violation), fix it surgically and flag it in your report — otherwise leave as-is.

## 3. Eyal-gaps (graceful, unchanged — AC-05)
Hero video (G, blocked), testimonial avatars, book covers, WhatsApp number — all remain graceful placeholders. Do NOT fabricate assets.

## 4. HARD CONSTRAINTS
- Composition-only; reuse D-14 atoms/tokens verbatim; no new token VALUES; no raw hex in new rules; no inline `style=""`; RTL logical properties only.
- `php -l` clean on touched PHP. **Surgical per-file commits** on the branch (never `git add -A`; `Co-Authored-By: Claude Opus 4.8 <noreply@anthropic.com>` trailer). No push/merge.
- Deploy: `python3 scripts/ftp_deploy_site_wp_content.py`.
- **No self-validation** (no axe/Lighthouse against ACs — S5 is team_50 → team_190). Self-smoke only: `/` returns 200 over https; hero renders gradient-only (no picsum / no external hero request — verify in the HTML/network); no PHP/console errors; `<br>` H1 intact.

## 5. Acceptance (Home subset of WP-W2-11 ACs)
- **AC-01** Home matches the POC composition (only the two approved hero deltas changed).
- **AC-02** zero D-14 drift (team_80 S4).
- **AC-03** axe 0 critical / 0 serious on `/`.
- **AC-04** Lighthouse (https): a11y 100, mobile perf ≥85.
- **AC-05** placeholders degrade gracefully; no console errors; no external hero request.
- **AC-06** validate_aos 0 FAIL + php -l clean.
- **AC-07** deployed, `/` HTTP 200, cache-busted.

## 6. Downstream gates (paste-ready)
### S4 → team_80
Token-compliance: confirm zero drift; verify the removed-image CSS left no orphan rule / no new tokens. Write `TOKEN-COMPLIANCE-WP-W2-11-HOME-2026-06-0X.md` to `_COMMUNICATION/team_80/`.
### S5 → team_50 (L-GATE_BUILD, non-Claude) — PASTE-READY
```
QA the EyalAmit staging Home route after the WP-W2-11 Home S3 deploy.
cd /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
  node scripts/qa/http-qa-axe.cjs /
  bash scripts/qa/http-qa-lighthouse.sh /
http-qa-lighthouse.sh measures perf on https (production-representative). axe over http.
PASS: axe 0 critical AND 0 serious; LH a11y 100 (>=97 w/ documented moderate), mobile perf >=85
(triple-run median). Confirm NO external hero request (no picsum.photos). Write
QA-VERDICT-WP-W2-11-HOME-L-GATE-BUILD-2026-06-0X.md to _COMMUNICATION/team_50/. Report exit codes.
ONLY after PASS, route to team_190 (gate-order discipline).
```
### S5 → team_190 (L-GATE_VALIDATE, Codex / cross-engine) — PASTE-READY
```
Constitutional L-GATE_VALIDATE for WP-W2-11 Home — RUN ONLY AFTER team_50 PASSES. Cross-engine
(builder team_10 != you). Verify vs _aos/work_packages/S003/WP-W2-11/LOD400_spec.md AC-01..07 (Home)
+ team_50 verdict. Evaluate AC-04 on MOBILE triple-run median. Re-verify live (https, base
eyalamit-co-il-2026.s887.upress.link, /): POC composition intact, hero gradient-only (no external
request), <br> H1 kept, zero D-14 drift, axe 0 crit/serious, LH a11y 100 / mobile perf >=85,
placeholders graceful. PASS/FAIL with 8-check rationale to
_COMMUNICATION/team_190/VERDICT-WP-W2-11-HOME-L-GATE-VALIDATE-2026-06-0X.md.
```

*Issued by team_100. Conservative refine — when in doubt, leave the POC composition unchanged and flag to team_100.*
