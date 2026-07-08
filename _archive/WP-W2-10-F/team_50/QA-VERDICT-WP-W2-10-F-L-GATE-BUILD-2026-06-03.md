---
id: QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03
title: team_50 L-GATE_BUILD QA Verdict — WP-W2-10-F EN landing cluster
date: 2026-06-03
from_team: team_50 (QA / L-GATE_BUILD)
to_team: team_100 → team_190 (on PASS)
wp: WP-W2-10-F
cluster: EN landing (F) — /en
gate: L-GATE_BUILD
branch: main
head_commit: b52b062
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_50/MANDATE-TEAM50-WP-W2-10-L-GATE-BUILD-2026-06-03.md
fix_ref: _COMMUNICATION/team_100/FIX-WP-W2-10-PORTRAIT-URI-2026-06-03.md
spec_ref: _aos/work_packages/S003/WP-W2-10-F/LOD400_IMPL_spec.md §7
token_compliance: _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-F-2026-06-02.md
status: ISSUED
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-10-F — EN landing (1 route, tpl-en-landing) |
| Gate | L-GATE_BUILD (S5 HTTP QA) |
| Verdict | **PASS** |
| Blocking AC | None |
| ACs in scope | AC-F4 **PASS** · AC-F5 **PASS** · AC-F7 **PASS** · **asset-200 PASS** |
| One-line next step | Advance cluster F to **team_190 L-GATE_VALIDATE** |

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
| `node scripts/qa/http-qa-axe.cjs /en/` | **0** | 0 critical / 0 serious |
| `node scripts/qa/wp-w2-10-asset-smoke.cjs /en/` | **0** | asset-200 + H1 + console |
| `bash scripts/qa/http-qa-lighthouse.sh /en/` | **0** | Supplemental desktop preset; single route (no sibling) |
| Mobile Lighthouse ×3 on `/en/` (AC-F5 bar) | n/a | https + `--form-factor=mobile` |

---

# §3 Per-Route Results

## HTTP / structural / assets

| Route | HTTP | H1 | console err | `assets/images/*` imgs | asset-200 + ea-eyalamit |
|-------|------|----|-------------|------------------------|-------------------------|
| `/en/` | 200 | 1 | 0 | 3 (3 book covers) | **PASS** |

Sample assets (all `themes/ea-eyalamit`, HTTP 200): `tsva-bechol-cover.jpg`, `kushi-blantis-cover.jpg`, `vekatavt-cover.jpg`.  
F cluster was already on `get_stylesheet_directory_uri()` pre-fix — unchanged and correct.

## axe-core

| Route | critical | serious | Result |
|-------|----------|---------|--------|
| `/en/` | 0 | 0 | **PASS** |

Report: `scripts/qa/reports/axe-http-2026-06-02.json`

## Lighthouse — desktop (supplemental)

| Route | perf | a11y | bp | seo |
|-------|------|------|----|-----|
| `/en/` | 94 | 100 | 100 | 61 |

## Lighthouse — mobile triple-run (AC-F5 authoritative)

| Route | Run 1 | Run 2 | Run 3 | **Median perf** | a11y (all runs) | AC-F5 |
|-------|-------|-------|-------|-----------------|-----------------|-------|
| `/en/` | 89 | 89 | 89 | **89** | 100 / 100 / 100 | **PASS** |

Report: `scripts/qa/reports/lh-mobile-w2-10-f-rev2_en__run{1,2,3}.json`

---

# §4 Acceptance Criteria

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| AC-F4 | axe 0 critical / 0 serious | **PASS** | §3 axe |
| AC-F5 | Mobile LH: a11y 100; perf median ≥85 on `/en/` | **PASS** | median **89** |
| AC-F7 | HTTP 200; single H1; 0 console errors | **PASS** | §3 structural |
| Asset-200 | Every `assets/images/*` src → ea-eyalamit + HTTP 200 | **PASS** | §3 assets |

---

# §5 Findings (non-blocking carry-forward)

**F-W2-10-F-01:** Closing CTA uses `/contact?lang=en` vs mockup `#contact` — per mandate carry-forward; not scored in this HTTP QA pass.

No blocking findings.

---

# §6 Routing Recommendation

| Verdict | Route |
|---------|-------|
| **PASS** | **team_190 L-GATE_VALIDATE** (Cursor, cross-engine) |

---

*team_50 — QA / L-GATE_BUILD — Cursor Composer — 2026-06-03*
