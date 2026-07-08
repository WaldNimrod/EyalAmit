---
id: QA-VERDICT-WP-W2-10-B-L-GATE-BUILD-2026-06-03
title: team_50 L-GATE_BUILD QA Verdict — WP-W2-10-B Editorial cluster
date: 2026-06-03
from_team: team_50 (QA / L-GATE_BUILD)
to_team: team_100 → team_190 (on PASS)
wp: WP-W2-10-B
cluster: Editorial (B) — /about, /press, /about/moksha
gate: L-GATE_BUILD
branch: main
head_commit: b52b062
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_50/MANDATE-TEAM50-WP-W2-10-L-GATE-BUILD-2026-06-03.md
fix_ref: _COMMUNICATION/team_100/FIX-WP-W2-10-PORTRAIT-URI-2026-06-03.md
spec_ref: _aos/work_packages/S003/WP-W2-10-B/LOD400_IMPL_spec.md §7
token_compliance: _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-B-2026-06-02.md
status: ISSUED
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-10-B — Editorial cluster (3 routes, tpl-content) |
| Gate | L-GATE_BUILD (S5 HTTP QA) |
| Verdict | **PASS** |
| Blocking AC | None |
| ACs in scope | AC-B4 **PASS** · AC-B5 **PASS** · AC-B7 **PASS** · **asset-200 PASS** |
| One-line next step | Advance cluster B to **team_190 L-GATE_VALIDATE** |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| engine | **Cursor Composer** (non-Claude — IR#1 compliant) |
| attestation | Independent re-verification; did **not** rely on team_100 pre-flight |
| Repo @ QA time | branch `main` · HEAD `b52b062` |

---

# §2 Commands Run + Exit Codes

| Command | Exit code | Notes |
|---------|-----------|-------|
| `node scripts/qa/http-qa-axe.cjs /about/ /press/ /about/moksha/` | **0** | 3/3: 0 critical / 0 serious |
| `node scripts/qa/wp-w2-10-asset-smoke.cjs` (same 3 routes) | **0** | asset-200 + H1 + console |
| `bash scripts/qa/http-qa-lighthouse.sh /about/ /press/` | **0** | Supplemental desktop preset |
| Mobile Lighthouse ×3 per route (AC-B5 bar) | n/a | https + `--form-factor=mobile` |

---

# §3 Per-Route Results

## HTTP / structural / assets

| Route | HTTP | H1 | console err | `assets/images/*` imgs | asset-200 + ea-eyalamit |
|-------|------|----|-------------|------------------------|-------------------------|
| `/about/` | 200 | 1 | 0 | 5 (portrait, studio, 3 covers) | **PASS** |
| `/press/` | 200 | 1 | 0 | 4 | **PASS** |
| `/about/moksha/` | 200 | 1 | 0 | 1 | **PASS** |

Sample `/about/` assets (all `themes/ea-eyalamit`, HTTP 200): `eyal-portrait-hero.jpg`, `hero-wide-studio.jpg`, `tsva-bechol-cover.jpg`, `kushi-blantis-cover.jpg`, `vekatavt-cover.jpg`.

## axe-core

| Route | critical | serious | Result |
|-------|----------|---------|--------|
| `/about/` | 0 | 0 | **PASS** |
| `/press/` | 0 | 0 | **PASS** |
| `/about/moksha/` | 0 | 0 | **PASS** |

Report: `scripts/qa/reports/axe-http-2026-06-02.json`

## Lighthouse — desktop (supplemental)

| Route | perf | a11y | bp | seo |
|-------|------|------|----|-----|
| `/about/` | 97 | 100 | 100 | 61 |
| `/press/` | 96 | 100 | 100 | 61 |

## Lighthouse — mobile triple-run (AC-B5 authoritative)

| Route | Run 1 | Run 2 | Run 3 | **Median perf** | a11y (all runs) | AC-B5 |
|-------|-------|-------|-------|-----------------|-----------------|-------|
| `/about/` | 86 | 87 | 85 | **86** | 100 / 100 / 100 | **PASS** |
| `/press/` | 85 | 85 | 86 | **85** | 100 / 100 / 100 | **PASS** |

Reports: `scripts/qa/reports/lh-mobile-w2-10-b-rev2_about__run{1,2,3}.json`, `…_press__run{1,2,3}.json`

---

# §4 Acceptance Criteria

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| AC-B4 | axe 0 critical / 0 serious (3 routes) | **PASS** | §3 axe |
| AC-B5 | Mobile LH: a11y 100; perf median ≥85 on `/about/` + `/press/` | **PASS** | medians **86** / **85** |
| AC-B7 | HTTP 200; single H1; 0 console errors | **PASS** | §3 structural |
| Asset-200 | Every `assets/images/*` src → ea-eyalamit + HTTP 200 | **PASS** | §3 assets |

---

# §5 Findings (non-blocking carry-forward)

**F-W2-10-B-01:** Editorial routes intentionally not in primary nav (no active-state) — per mandate carry-forward; not scored in this HTTP QA pass.

No blocking findings.

---

# §6 Routing Recommendation

| Verdict | Route |
|---------|-------|
| **PASS** | **team_190 L-GATE_VALIDATE** (Cursor, cross-engine) |

---

*team_50 — QA / L-GATE_BUILD — Cursor Composer — 2026-06-03*
