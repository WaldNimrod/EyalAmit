---
id: VERDICT-WP-W2-13-L-GATE-VALIDATE-2026-06-02
from: team_190 (L-GATE_VALIDATE)
to: team_100, team_00, team_80, team_50
type: QA_VERDICT
gate: L-GATE_VALIDATE
date: 2026-06-02
round: 1
engine: cursor-composer (cross-engine vs team_80/Claude builder; team_00-approved)
verdict: PASS
blocking_findings: 0
wp: WP-W2-13 (S003 — re-enable D-14 entrance animations)
cluster: Site-wide D-14 motion fix (verified on `/`)
branch: feature/s003-entrance-fix
worktree_head: e9ca9c3
fix_commit: e2fce1d
spec_ref: _aos/work_packages/S003/WP-W2-13/LOD400_spec.md
decision_ref: _COMMUNICATION/team_00/DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1.md
findings_ref: _COMMUNICATION/team_100/FINDINGS-WP-W2-13-ENTRANCE-ANIM-2026-06-02.md
staging: https://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — WP-W2-13 entrance-animation fix | L-GATE_VALIDATE

## Verdict Box

| Field | Value |
|-------|-------|
| Gate | L-GATE_VALIDATE (team_190) |
| Verdict | **PASS** |
| Blocking findings | **0** |
| Non-blocking findings | 0 |
| Route | `/` (HTTPS) |
| Cluster close | **APPROVED** for WP-W2-13 S5 validate |

---

## Summary

Independent validation confirms the **one-line** fix (`e2fce1d`: re-insert `@media (prefers-reduced-motion: reduce) {` at the top of `ea-atoms.css`) restores intended D-14 behavior. Entrances **play** under `no-preference` with WP-W2-12 stagger observable (0.1s / 0.2s / 0.3s on pillars 2–4; `ea-breathReveal` on section breath heading). Entrances are **fully suppressed** under `reduce`. D-14 drift check: only `ea-atoms.css` +1 line; `ea-tokens.css` unchanged; braces 291/291 balanced. axe, Lighthouse, `validate_aos`, and mobile perf median meet the S5 bar.

---

## AC proof matrix

| AC | Verdict | Evidence |
|----|---------|----------|
| **AC-01** Root-cause documented | **PASS** | team_100 FINDINGS + team_00 DECISION (accidental orphaned reduce block, commit `e165218`); repo fix `e2fce1d` scoped override to `@media (prefers-reduced-motion: reduce)` only |
| **AC-02** Entrances play (no-pref) + suppressed (reduce) | **PASS** | See §AC-02 runtime proof |
| **AC-03** No D-14 drift; a11y/perf gates | **PASS** | `git diff main..HEAD` → 1 line in `ea-atoms.css` only (theme CSS); `ea-tokens.css` diff empty; brace balance 291/291; axe 0/0; LH a11y 100; mobile median perf **88** |
| **AC-04** team_00 sign-off | **PASS** | `DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1.md` — Option A approved |
| **AC-05** validate_aos + `/` 200 | **PASS** | 30 PASS / 0 FAIL; HTTPS `/` HTTP 200 (puppeteer + axe) |

---

## AC-02 — Runtime proof (HTTPS `/`, puppeteer `emulateMediaFeatures`)

Script: `scripts/qa/wp-w2-13-entrance-proof.cjs`  
Report: `scripts/qa/reports/wp-w2-13-entrance-proof.json`

### `prefers-reduced-motion: no-preference`

| Target | Expected | Observed |
|--------|----------|----------|
| `matchMedia('(prefers-reduced-motion: reduce)')` | false | **false** ✓ |
| `.ea-pillars-grid .ea-pillar:nth-of-type(2)` | `ea-fadeUp`, delay **0.1s** | animationName `ea-fadeUp`, animationDelay `0.1s` ✓ |
| pillar nth(3) | delay **0.2s** | `0.2s` ✓ |
| pillar nth(4) | delay **0.3s** | `0.3s` ✓ |
| `.ea-content-section__heading.ea-entrance--breath` | `ea-breathReveal` | animationName `ea-breathReveal` ✓ |

WP-W2-12 stagger is **observable** (contrast with pre-W2-13 global kill).

### `prefers-reduced-motion: reduce`

| Target | Expected | Observed |
|--------|----------|----------|
| `matchMedia('(prefers-reduced-motion: reduce)')` | true | **true** ✓ |
| pillar2, pillar3, breath heading | `animation: none` / name none | animation `none`, animationName `none`, delay `0s` ✓ |

### Deployed CSS sanity

Staging `ea-atoms.css` lines 1–2: comment + `@media (prefers-reduced-motion: reduce) {` (curl -k; matches repo).

---

## AC-03 — D-14 drift (validate-only, no theme edits)

| Check | Result |
|-------|--------|
| Files changed vs `main` (theme) | `ea-atoms.css` only (+1 line `@media` opener) |
| `ea-tokens.css` | unchanged vs `main` |
| New tokens | none |
| Brace balance `ea-atoms.css` | `{` 291 / `}` 291 |

---

## Command log

```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026"
node scripts/qa/wp-w2-13-entrance-proof.cjs
node scripts/qa/http-qa-axe.cjs /
bash scripts/qa/http-qa-lighthouse.sh /
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .
# Mobile LH ×3 (https, ignore cert):
# reports/lh-mobile-t190-w2-13-run{1,2,3}.json → perf 88/87/89, a11y 100/100/100 → median perf 88
```

| Command | Exit code |
|---------|-----------|
| `node scripts/qa/wp-w2-13-entrance-proof.cjs` | 0 |
| `node scripts/qa/http-qa-axe.cjs /` | 0 |
| `bash scripts/qa/http-qa-lighthouse.sh /` | 0 (perf 99 / a11y 100 / bp 100) |
| `bash _aos/lean-kit/.../validate_aos.sh .` | 0 |

---

## Cross-engine (IR#1 / IR#5)

Builder/DS: team_80 (Claude), commit `e2fce1d`. This gate: Cursor/Composer, independent puppeteer trace + QA reruns — aligns with team_00 mandate.

---

## Handoff

- **team_00 / team_100:** WP-W2-13 **L-GATE_VALIDATE PASS** — merge to `main` per team_00 go.
- **team_80:** No remediation required.
- **team_190:** Gate closed PASS.
