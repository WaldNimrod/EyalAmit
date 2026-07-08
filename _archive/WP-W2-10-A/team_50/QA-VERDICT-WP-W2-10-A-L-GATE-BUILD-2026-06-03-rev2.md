---
id: QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03-rev2
title: team_50 L-GATE_BUILD QA Verdict — WP-W2-10-A Service cluster (re-pass)
date: 2026-06-03
from_team: team_50 (QA / L-GATE_BUILD)
to_team: team_100 → team_190 (on PASS)
wp: WP-W2-10-A
cluster: Service (A) — /treatment, /method, /sound-healing, /lessons
gate: L-GATE_BUILD
round: 2 (re-pass after team_190 P0 asset-404 FAIL)
branch: main
head_commit: b52b062
fix_commit: 407965a
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_50/MANDATE-TEAM50-WP-W2-10-L-GATE-BUILD-2026-06-03.md
fix_ref: _COMMUNICATION/team_100/FIX-WP-W2-10-PORTRAIT-URI-2026-06-03.md
prior_build_gate: _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03.md
prior_validate_fail: _COMMUNICATION/team_190/VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03.md
spec_ref: _aos/work_packages/S003/WP-W2-10-A/LOD400_IMPL_spec.md §7
status: ISSUED
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-10-A — Service cluster (4 routes, tpl-service) |
| Gate | L-GATE_BUILD re-pass (post P0 asset-URI fix) |
| Verdict | **PASS** |
| Blocking AC | None |
| ACs in scope | AC-A4 **PASS** · AC-A5 **PASS** · AC-A7 **PASS** · **asset-200 PASS** |
| One-line next step | Advance cluster A to **team_190 L-GATE_VALIDATE re-validate** |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| engine | **Cursor Composer** (non-Claude — IR#1 compliant) |
| attestation | Independent re-verification; did **not** rely on team_100 pre-flight or rev1 build gate |
| Repo @ QA time | branch `main` · HEAD `b52b062` (includes fix `407965a`) |

---

# §2 Commands Run + Exit Codes

| Command | Exit code | Notes |
|---------|-----------|-------|
| `node scripts/qa/http-qa-axe.cjs /treatment/ /method/ /sound-healing/ /lessons/` | **0** | 4/4: 0 critical / 0 serious |
| `node scripts/qa/wp-w2-10-asset-smoke.cjs` (same 4 routes) | **0** | asset-200 + H1 + console |
| `bash scripts/qa/http-qa-lighthouse.sh /treatment/ /method/` | **0** | Supplemental desktop preset |
| Mobile Lighthouse ×3 per route (AC-A5 bar) | n/a | https + `--form-factor=mobile` |

Direct asset probe (P0 regression guard):

| URL | HTTP |
|-----|------|
| `…/themes/ea-eyalamit/assets/images/eyal-portrait-hero.jpg` | **200** |
| `…/themes/generatepress/assets/images/eyal-portrait-hero.jpg` | **404** (confirms prior root cause) |

---

# §3 Per-Route Results

## HTTP / structural / assets

| Route | HTTP | H1 | console err | `assets/images/*` imgs | asset-200 + ea-eyalamit |
|-------|------|----|-------------|------------------------|-------------------------|
| `/treatment/` | 200 | 1 | 0 | 1 (`eyal-portrait-hero.jpg`) | **PASS** |
| `/method/` | 200 | 1 | 0 | 1 | **PASS** |
| `/sound-healing/` | 200 | 1 | 0 | 1 | **PASS** |
| `/lessons/` | 200 | 1 | 0 | 1 | **PASS** |

Rendered portrait src (sample `/treatment/`):  
`http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/assets/images/eyal-portrait-hero.jpg` → **200**

## axe-core

| Route | critical | serious | Result |
|-------|----------|---------|--------|
| `/treatment/` | 0 | 0 | **PASS** |
| `/method/` | 0 | 0 | **PASS** |
| `/sound-healing/` | 0 | 0 | **PASS** |
| `/lessons/` | 0 | 0 | **PASS** |

Report: `scripts/qa/reports/axe-http-2026-06-02.json`

## Lighthouse — desktop (supplemental)

| Route | perf | a11y | bp | seo |
|-------|------|------|----|-----|
| `/treatment/` | 98 | 100 | 100 | 69 |
| `/method/` | 98 | 100 | 100 | 61 |

## Lighthouse — mobile triple-run (AC-A5 authoritative)

| Route | Run 1 | Run 2 | Run 3 | **Median perf** | a11y (all runs) | AC-A5 |
|-------|-------|-------|-------|-----------------|-----------------|-------|
| `/treatment/` | 87 | 87 | 87 | **87** | 100 / 100 / 100 | **PASS** |
| `/method/` | 95 | 87 | 87 | **87** | 100 / 100 / 100 | **PASS** |

Reports: `scripts/qa/reports/lh-mobile-w2-10-a-rev2_treatment__run{1,2,3}.json`, `…_method__run{1,2,3}.json`

---

# §4 Acceptance Criteria

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| AC-A4 | axe 0 critical / 0 serious (4 routes) | **PASS** | §3 axe |
| AC-A5 | Mobile LH: a11y 100; perf median ≥85 on `/treatment/` + `/method/` | **PASS** | medians **87** / **87** |
| AC-A7 | HTTP 200; single H1; 0 console errors | **PASS** | §3 structural |
| Asset-200 (closed QA-gap) | Every `assets/images/*` src → ea-eyalamit + HTTP 200 | **PASS** | §3 assets; P0 defect remediated |

---

# §5 Findings

No blocking findings. P0 portrait-404 from team_190 round-1 is **closed** — child-theme URI resolves and renders.

---

# §6 Routing Recommendation

| Verdict | Route |
|---------|-------|
| **PASS** | **team_190 L-GATE_VALIDATE re-validate** (Cursor, cross-engine) |
| Prior rev1 build gate | Superseded by this re-pass |

---

*team_50 — QA / L-GATE_BUILD — Cursor Composer — 2026-06-03 rev2*
