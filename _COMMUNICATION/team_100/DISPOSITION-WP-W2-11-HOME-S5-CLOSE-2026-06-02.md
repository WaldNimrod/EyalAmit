---
id: DISPOSITION-WP-W2-11-HOME-S5-CLOSE-2026-06-02
from_team: team_100 (Chief System Architect)
to_team: team_00 (decision record) / team_50 / team_190 / team_10 / team_80
date: 2026-06-02
wp: WP-W2-11 (S003 Base Implementation — Hybrid Track-1)
cluster: Home refine — /
stage: S5 close
branch: feature/s003-base-implementation-prep
verdict: BUILD-COMPLETE — S5 pre-flight PASS (all ACs met); external L-GATE_VALIDATE batched
---

# DISPOSITION — WP-W2-11 Home refine · S5 close

## 1. What changed (S3 team_10 / S4 team_80)
Conservative refine of the POC-signed-off home (12 blocks). team_00 decisions: **keep `<br>` hero H1** (IDEA-005); **replace external `picsum.photos` hero image with CSS-only gradient**.
- **S3 (team_10, `1b761f7`)**: removed the external `picsum.photos` `<img>` from `block-hero.php`; interim hero now renders the D-14 gradient + breathing-line overlay only — **zero external hero requests**. `<br>` H1 kept. No CSS change needed (the img was inline-styled; no orphan rule). Blocks 2–12 verify-only, unchanged.
- **S4 (team_80, `942a87c`)**: zero new D-14 drift; ruled the pre-existing token-based inline `style=""` in six POC blocks acceptable (not introduced by this WP) — logged as a non-blocking DS-hygiene carry-forward (tokenize stagger-delays + move to CSS in a future WP).

## 2. S5 pre-flight (team_100, corrected QA)
| Route | axe (crit/serious) | LH mobile perf — median of 3 (https) | a11y | external hero req |
|-------|--------------------|--------------------------------------|------|-------------------|
| `/` | 0 / 0 | **98** (98/98/97) | 100 | **0** (picsum removed) |

All bars met outright; no staging-cap needed. Evidence on-disk under `scripts/qa/reports/` (gitignored, per convention).

## 3. AC roll-up (Home)
AC-01 POC composition intact (only the 2 approved hero deltas) — PASS · AC-02 zero drift — PASS · AC-03 axe 0 crit/serious — PASS · AC-04 a11y 100 / mobile perf 98 — PASS · AC-05 placeholders graceful + no external hero request — PASS · AC-06 validate_aos 0 FAIL + php -l — PASS · AC-07 `/` HTTP 200 — PASS.

**Home cluster: BUILD-COMPLETE, S5 pre-flight PASS.** Remaining: external L-GATE_VALIDATE (team_190/Codex) — batched.

## 4. Carry-forwards (tracked, non-blocking)
1. Hero **video** (G) — Eyal asset, blocked; structure ready for `<video>` swap.
2. DS-hygiene: tokenize POC stagger-delays + move pre-existing inline styles to `ea-atoms.css` (future WP).
3. WhatsApp number, testimonial avatars, book covers — graceful placeholders pending Eyal materials.
4. External L-GATE_VALIDATE (team_190/Codex) for Blog + Home — batched.

---

# WP-W2-11 ROLL-UP — all three Track-1 base clusters BUILD-COMPLETE

| Cluster | Routes | S3 | S4 | S5 pre-flight | Disposition |
|---------|--------|----|----|---------------|-------------|
| **Conversion** | /contact, /faq | ✓ | ✓ zero drift | axe 0/0; perf https 94/98; **MERGED to main** | …CONVERSION-S5-CLOSE… (AC-04 staging-capped) |
| **Blog (D)** | /blog, /blog/* | ✓ | ✓ zero drift | axe 0/0; perf https 98/97 | …BLOG-S5-CLOSE… |
| **Home** | / | ✓ | ✓ zero drift | axe 0/0; perf https 98 | this doc |

**State:** Conversion is merged + pushed to `main`. Blog + Home are build-complete on `feature/s003-base-implementation-prep`, S5 pre-flight PASS, awaiting (a) external constitutional L-GATE_VALIDATE (team_190/Codex, batched) and (b) team_00 go for the `main` merge. No `main` merge/push without explicit team_00 go.
