---
id: VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0
from: Team 50 (QA & Functional Acceptance)
to: Team 00
type: QA_VERDICT
work_package: WP-W2-01-STAGE-B-IMPL
gate: L-GATE_BUILD
date: 2026-05-27
round: 2
engine: composer (Cursor IDE agent runtime)
validator_engine: composer
enforcement: regular
verdict: FAIL
criteria_total: 14
criteria_pass: 13
criteria_fail: 1
findings_blocker: 2
findings_major: 1
findings_minor: 2
resubmission_round: 2
phase: 1
implementation_commit: e165218
remediation_commits:
  - 0f71779
  - fb8da63
  - c6b3161
parent_mandate: ./_COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.1.0.md
in_process_preverdict: ../team_100/PREVERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_2026-05-27.md
---

# QA Verdict v2.0.0 — WP-W2-01-STAGE-B-IMPL Phase 1 Round 2 | Team 50

## §0 Verdict Box

| Field | Value |
|-------|-------|
| **WP** | WP-W2-01-STAGE-B-IMPL |
| **Gate** | L-GATE_BUILD |
| **Round** | 2 (post-remediation) |
| **Verdict** | **FAIL** |
| **PASS count** | 13 of 14 |
| **FAIL count** | 1 (VC-6) |
| **SKIP count** | 0 |
| **Constitutional status** | **Non-canonical** — cross-engine Iron Rule #1 not satisfied (see §6) |

Staging deploy and smoke page remediation are **verified live**. One accessibility VC fails on independent measurement. Constitutional L-GATE_BUILD closure still requires a **non-Cursor, non-Claude** validator session per mandate v2.1.0 §1.

---

## §1 Hostname & Validator Engine

| Parameter | Value |
|-----------|-------|
| **Staging host** | `eyalamit-co-il-2026.s887.upress.link` |
| **Canonical test URL** | `https://eyalamit-co-il-2026.s887.upress.link/wave2-test/` |
| **HTTP entry (env baseline)** | `http://eyalamit-co-il-2026.s887.upress.link/wave2-test/` → 200 |
| **validator_engine** | **composer** (Cursor IDE agent runtime) |
| **Builder engine** | cursor-composer (team_10) |
| **Mandate** | `_COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.1.0.md` |
| **Measurement date** | 2026-05-27 |

**Engine note:** Mandate v2.1.0 §1 requires validator ∈ {Codex, Gemini, GPT-5 web, …} and **forbids** `cursor-*` and `claude-*`. This session ran in **Cursor Composer** — same forbidden family as Round 1. Technical measurements below are fresh and cited; **constitutional cross-engine attestation is FAIL** regardless of VC outcomes.

---

## §2 VC Table (14 VCs)

| VC | Description | Result | In-process | Team 50 disposition | Evidence |
|----|-------------|--------|------------|----------------------|----------|
| VC-1 | 3 Wave2 CSS enqueued on `/wave2-test/` | **PASS** | PASS | **Concur** | `curl` HTML: `ea-tokens.css`, `ea-animations.css`, `ea-atoms.css` (ver=1.3.6) |
| VC-2 | 12 blocks rendered (`data-block`) | **PASS** | PASS | **Concur** | 12 distinct markers: hero, intro, method-pillars, treatment-overview, services-row, books-row, testimonials-row, faq-mini, contact-cta, breath-divider-1, topnav, footer-social |
| VC-3 | 12 block partials in repo | **PASS** | PASS | **Concur** (carry-forward) | `ls …/block-*.php \| wc -l` → **12** |
| VC-4 | ≥12 page templates with Template Name | **PASS** | PASS | **Concur** (carry-forward) | `grep -l "Template Name:" tpl-*.php \| wc -l` → **13** |
| VC-5 | RTL `dir` + `lang` on `<html>` | **PASS** | PASS | **Concur** | `<html dir="rtl" lang="he-IL">`; Puppeteer computed `direction: rtl` desktop+mobile — `visual-qa-r2.json` |
| VC-6 | axe wcag2aa — 0 critical **and** 0 serious | **FAIL** | PASS | **Dispute** | See §3 F-R2-VC6; `axe-r2-puppeteer.json` |
| VC-7 | Lighthouse mobile perf ≥85, a11y ≥95 (HTTPS+cert-bypass) | **PASS** | PASS (90/100) | **Concur** (variance) | perf **87**, a11y **100** — `lighthouse-r2.report.json` |
| VC-8 | `prefers-reduced-motion` in ea-animations.css | **PASS** | PASS | **Concur** | `@media (prefers-reduced-motion: reduce)` at line 61 |
| VC-9 | Visual RTL layout (desktop + mobile) | **PASS** | PASS | **Concur** | Screenshots (local, gitignored): `evidence/screenshot-wave2-test-{desktop,mobile}-rtl.png`; RTL computed styles — `visual-qa-r2.json` |
| VC-10 | `sessionStorage.eyal_cta_variant` valid; ≥2 distinct / 6 trials | **PASS** | PASS | **Concur** (distribution differs) | 6/6 valid; **wa_only×4, dual×2** (in-process: form_only×4, dual×2) — `visual-qa-r2.json` |
| VC-11 | Footer FB+IG+YT `target="_blank" rel="noopener noreferrer"` | **PASS** | PASS | **Concur** | `data-block="footer-social"` — facebook.com, instagram.com, youtube.com links with required attrs |
| VC-12 | WhatsApp `wa.me/972524822842` | **PASS** | PASS | **Concur** | `href="https://wa.me/972524822842"` on page |
| VC-13 | `books-wave1.css` absent | **PASS** | PASS | **Concur** (carry-forward) | `find … -name books-wave1.css` → empty |
| VC-14 | `validate_aos.sh` 0 FAIL | **PASS** | PASS | **Concur** (carry-forward) | **30 PASS / 18 SKIP / 0 FAIL** |

**Summary:** 13 PASS / 1 FAIL / 0 SKIP

---

## §3 Findings

### F-R2-VC6 — BLOCKER (code defect — disputed in-process)

- **Finding:** On the live smoke page (HTTP 200, 12 `data-block` markers), axe wcag2aa reports **1 serious** violation: `color-contrast` on `.ea-sound-toggle__label` (contrast 3.73:1, required 4.5:1; fg `#d2d1d1` on bg `#696664`).
- **In-process claim:** 0 violations (team_100 axe summary).
- **Dispute evidence:** Mandate-prescribed `@axe-core/cli` save file `axe-r2.json` records URL `chrome-error://chromewebdata/` — **invalid test surface** despite CLI stdout “0 violations”. Independent Puppeteer injection on loaded HTTPS page (cert-bypass): `axe-r2-puppeteer.json`.
- **Required fix:** team_10 — raise contrast on `.ea-sound-toggle__label` (or adjust topnav background) to meet WCAG 2 AA 4.5:1 for normal text.

### F-R2-CE — BLOCKER (process — Iron Rule #1)

- **Finding:** Validator engine **composer** (Cursor) — same forbidden family as builder (cursor-composer). Mandate v2.1.0 §1 requires Codex / Gemini / GPT-5 web (not cursor-*, not claude-*).
- **Disposition:** Constitutional L-GATE_BUILD verdict **not valid** from this session. Re-run on approved external engine; declare engine in §1.

### F-R2-01 — MAJOR (environment — concur in-process)

- **Finding:** Staging TLS certificate expired (deferred M7). HTTP entry incurs redirect penalty; HTTPS-direct with `--ignore-certificate-errors` is required for perf measurement.
- **Team 50 VC-7:** perf **87**, a11y **100** under mandated HTTPS+cert-bypass methodology (in-process perf 90 — within normal Lighthouse variance). **Concur** PASS under §3 methodology.
- **Disposition:** Non-blocking for code; renew TLS at M7.

### F-R2-02 — MINOR (observation — concur in-process)

- **Finding:** Sampled `<p>` on mobile viewport resolves `text-align: left` while body/html remain RTL (`visual-qa-r2.json`). Desktop sample `<p>` is `right`.
- **Disposition:** Non-blocking; theme cleanup during W2-02.

### F-R2-AXE-CLI — MINOR (tooling)

- **Finding:** `@axe-core/cli` without reliable cert-bypass produced misleading `axe-r2.json` (chrome error page). Re-QA scripts should assert final URL + `data-block` count before trusting axe output.

---

## §4 validate_aos.sh

```
RESULT: 30 PASS / 18 SKIP / 0 FAIL
L-GATE_BUILD EXIT CRITERION (repo): SATISFIED
```

Command: `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` (exit 0, 2026-05-27)

---

## §5 Evidence Files

| Artifact | Path | Notes |
|----------|------|-------|
| axe CLI (mandate command) | `_COMMUNICATION/team_50/evidence/axe-r2.json` | **Invalid surface** (`chrome-error://`) — do not cite for PASS |
| axe Puppeteer (authoritative) | `_COMMUNICATION/team_50/evidence/axe-r2-puppeteer.json` | 1 serious `color-contrast`; URL + 12 blocks confirmed |
| Lighthouse JSON | `_COMMUNICATION/team_50/evidence/lighthouse-r2.report.json` | perf 87, a11y 100 |
| Lighthouse HTML | `_COMMUNICATION/team_50/evidence/lighthouse-r2.report.html` | mobile, HTTPS+cert-bypass |
| Visual QA JSON | `_COMMUNICATION/team_50/evidence/visual-qa-r2.json` | VC-9 computed styles + VC-10 trials |
| Screenshots | `_COMMUNICATION/team_50/evidence/screenshot-wave2-test-{desktop,mobile}-rtl.png` | gitignored per `.gitignore`; present locally |
| In-process reference | `_COMMUNICATION/team_100/evidence/` | Pre-verdict advisory only |

---

## §6 Cross-Engine Compliance Attestation

| Check | Result |
|-------|--------|
| Builder ≠ Validator engine family | **FAIL** — both cursor-* |
| Validator ∉ {cursor-*, claude-*} | **FAIL** — composer (Cursor) |
| Fresh measurements executed | **YES** — 2026-05-27 |
| Constitutional L-GATE_BUILD closable from this artifact | **NO** |

**Attestation:** This verdict documents **fresh Round-2 measurements** and **disputes** team_100 in-process VC-6 PASS. **Do not advance** `WP-W2-01-STAGE-B-IMPL` L-GATE_BUILD on this commit alone. Required path:

1. team_10 — fix VC-6 color contrast on `.ea-sound-toggle__label`.
2. team_50 — re-run Phase 1 on **Codex or Gemini** (declare engine in §1).
3. team_00 — acknowledge; team_190 L-GATE_VALIDATE remains blocked until team_50 constitutional PASS.

Phase 2 (VC-15..VC-18): **not executed** — Eyal human gates still pending.

---

*Team 50 · WP-W2-01-STAGE-B-IMPL · L-GATE_BUILD · Round 2 · 2026-05-27*
