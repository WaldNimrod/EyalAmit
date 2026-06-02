---
id: VERDICT-WP-W2-12-L-GATE-VALIDATE-REV2-2026-06-02
from: team_190 (L-GATE_VALIDATE)
to: team_100, team_00, team_80, team_50
type: QA_VERDICT
gate: L-GATE_VALIDATE
date: 2026-06-02
round: 2 (corrected AC-01 proof — rendering/computed equivalence)
engine: cursor-composer (cross-engine vs team_80/Claude builder; team_00-approved)
verdict: PASS
blocking_findings: 0
wp: WP-W2-12 (S003 DS-Hygiene)
cluster: Home DS-hygiene (/)
branch: feature/s003-ds-hygiene
worktree_head: e765725
spec_ref: _aos/work_packages/S003/WP-W2-12/LOD400_spec.md
disposition_ref: _COMMUNICATION/team_100/DISPOSITION-WP-W2-12-AC01-2026-06-02.md
supersedes: _COMMUNICATION/team_190/VERDICT-WP-W2-12-L-GATE-VALIDATE-2026-06-02.md (round 1 FAIL — proof-method artifact)
staging: http://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — WP-W2-12 DS-Hygiene | L-GATE_VALIDATE (REV2)

## Verdict Box

| Field | Value |
|-------|-------|
| Gate | L-GATE_VALIDATE (team_190) |
| Verdict | **PASS** |
| Blocking findings | **0** |
| Non-blocking findings | 1 (informational — global entrance kill, out of WP scope) |
| Route | `/` |
| Round 1 reversal | AC-01 **PASS** under corrected proof bar (computed-style equivalence + inert stagger parity); round 1 FAIL (F-W2-12-01) **withdrawn** |
| Cluster close | **APPROVED** for WP-W2-12 S5 validate |

---

## Summary

Independent REV2 validation confirms team_100 disposition: AC-01 is satisfied by **pixel-identical rendering equivalence**, not by observing entrance stagger animation delays. A **pre-existing** top-level rule in deployed `ea-atoms.css` — `.ea-entrance, .ea-entrance--breath, .ea-entrance--slide { animation: none !important; }` — globally suppresses entrance motion while `matchMedia('(prefers-reduced-motion: reduce)')` is **false**. WP-W2-12 `git diff main..HEAD` adds only de-inlined layout classes in `ea-atoms.css`; it does **not** add or change animation-kill rules. Tokenized stagger rules in `ea-animations.css` are present, deployed, and arithmetically correct; computed delays are inert **pre- and post-equivalently** (no visible rendering delta).

---

## AC proof matrix (REV2)

| AC | Verdict | Evidence |
|----|---------|----------|
| **AC-01** Pixel-identical (equivalence) | **PASS** | See §AC-01 below |
| **AC-02** Zero inline `style=""` in 6 blocks | **PASS** | Source: `grep style=` on six `block-*.php` → 0. Served `/` HTML (`curl` + `grep style=`) → 0 sitewide on homepage markup |
| **AC-03** Token + hygiene | **PASS** | `--ea-stagger-step: 0.05s` only new stagger token; nth-of-type `calc()` rules; no raw hex in new rules; `git diff main..HEAD` on `ea-atoms.css` shows only `.ea-block-cta-end`, `.ea-service-comparison__note`, `.ea-contact-form__note--cta` |
| **AC-04** axe + Lighthouse | **PASS** | axe `/` 0 crit / 0 serious; `http-qa-lighthouse.sh /` perf 97 / a11y 100; mobile LH ×3 median perf **88** (≥85), a11y 100 all runs |
| **AC-05** validate_aos | **PASS** | 30 PASS / 18 SKIP / 0 FAIL |
| **AC-06** Staging `/` 200 | **PASS** | HTTP 200 on `/` |

---

## AC-01 — Corrected proof (all four required bars met)

### 1) Computed-style equivalence on `/` (no-preference emulation)

Script: `scripts/qa/wp-w2-12-rev2-computed-proof.cjs`  
Report: `scripts/qa/reports/wp-w2-12-rev2-computed-proof.json`

| Selector | Expected (original inline / tokens) | Observed (live computed) | Match |
|----------|-------------------------------------|--------------------------|-------|
| `.ea-block-cta-end` | margin-top 48px; text-align right | marginTop `48px`; textAlign `right` | ✓ |
| `.ea-service-comparison__note` | font-size 12.48px (0.78rem); font-weight 200; color #6F635A; margin-bottom 32px | fontSize `12.48px`; fontWeight `200`; color `rgb(111, 99, 90)`; marginBottom `32px` | ✓ |
| `.ea-contact-form__note--cta` | margin-top 32px | marginTop `32px` | ✓ |
| `:root` tokens | space-6=48px; space-4=32px; muted=#6F635A; stagger-step=0.05s | all match | ✓ |
| Stagger targets (e.g. `.ea-pillar:nth-of-type(2)`, comparison col 2, testimonial 3, service tile 2, contact form) | inert: animation none; delay 0s; opacity 1 | all inert under `reduceMotion=false` | ✓ (equivalent pre/post) |

**Root-cause confirmation (independent):** deployed `ea-atoms.css` lines 2–8 apply `animation: none !important` to `.ea-entrance*` unconditionally at file top (not introduced by WP-W2-12 branch diff).

### 2) No inline `style=""` in six POC blocks

| Layer | Result |
|-------|--------|
| PHP source (6 blocks) | 0 matches |
| Served homepage HTML | 0 `style=` attributes (full-page `curl` + grep) |

### 3) Visual sanity

Screenshots (full-page):  
- `scripts/qa/reports/wp-w2-12-rev2-home-desktop.png` (1440×900)  
- `scripts/qa/reports/wp-w2-12-rev2-home-mobile.png` (390×844)

DOM structure counts on `/`: 4 pillars, 3 testimonials, 3 books, 2 comparison columns, 2 service tiles, contact two-column (form + CTA side) — all present.

### 4) Stagger token + CSS arithmetic (deployed)

Deployed `ea-tokens.css`: `--ea-stagger-step: 0.05s`  
Deployed `ea-animations.css` mappings (step × n):

| Rule multiplier | Delay |
|-----------------|-------|
| ×2 | 0.10s |
| ×3 | 0.15s |
| ×4 | 0.20s |
| ×6 | 0.30s |

Rules match repo source; faithful de-inlining. Stagger would apply if/when global `animation:none` is lifted (separate WP — see non-blocking note).

---

## Round 1 finding disposition

| ID | Round 1 | REV2 |
|----|---------|------|
| F-W2-12-01 | BLOCKING — computed stagger delays not 0.10/0.15/0.20/0.30s | **WITHDRAWN** — proof bar corrected per team_100 disposition; delays were never visible on live site; AC-01 requires rendering equivalence, not observable stagger under globally killed animation |

---

## Non-blocking finding (out of WP-W2-12 scope)

### NB-W2-12-01 — D-14 entrance layer globally disabled

Deployed `ea-atoms.css` top-level `.ea-entrance { animation: none !important }` prevents all entrance motion site-wide. Flag for team_00 / future hygiene WP if motion is intended to run. Does not block WP-W2-12 close.

---

## Command log (REV2)

```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026"
node scripts/qa/wp-w2-12-rev2-computed-proof.cjs
node scripts/qa/http-qa-axe.cjs /
bash scripts/qa/http-qa-lighthouse.sh /
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .
# AC-04 mobile median (independent ×3):
# reports/lh-mobile-t190-w2-12-rev2-run{1,2,3}.json → perf 88/89/88, a11y 100/100/100
```

| Command | Exit code |
|---------|-----------|
| `node scripts/qa/wp-w2-12-rev2-computed-proof.cjs` | 0 |
| `node scripts/qa/http-qa-axe.cjs /` | 0 |
| `bash scripts/qa/http-qa-lighthouse.sh /` | 0 |
| `bash _aos/lean-kit/.../validate_aos.sh .` | 0 |

---

## Handoff

- **team_00 / team_100:** WP-W2-12 **L-GATE_VALIDATE PASS** — cluster may close per S5 sequence.
- **team_80:** No remediation required for W2-12; optional follow-up WP if entrance animations should be re-enabled.
- **team_190:** Round 1 FAIL superseded by this REV2 PASS.
