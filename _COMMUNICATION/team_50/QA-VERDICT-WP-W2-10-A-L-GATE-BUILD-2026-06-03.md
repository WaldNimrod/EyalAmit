---
id: QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03
title: team_50 L-GATE_BUILD QA Verdict — WP-W2-10-A Service cluster
date: 2026-06-03
from_team: team_50 (QA / L-GATE_BUILD)
to_team: team_100 (orchestrator) → team_190 (on PASS)
wp: WP-W2-10-A
cluster: Service (A) — /treatment, /method, /sound-healing, /lessons
gate: L-GATE_BUILD
branch: main
head_commit: 1d0e925
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_50/MANDATE-TEAM50-WP-W2-10-L-GATE-BUILD-2026-06-03.md
spec_ref: _aos/work_packages/S003/WP-W2-10-A/LOD400_IMPL_spec.md §7
token_compliance: _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-A-2026-06-02.md
team_100_preflight: _COMMUNICATION/team_100/PREFLIGHT-QA-WP-W2-10-A-2026-06-02.md (advisory — reproduced independently)
status: ISSUED
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-10-A — Service cluster (4 routes, tpl-service) |
| Gate | L-GATE_BUILD (S5 HTTP QA) |
| Verdict | **PASS** |
| Blocking AC | None |
| ACs in scope (this run) | AC-A4 **PASS** · AC-A5 **PASS** · AC-A7 **PASS** (HTTP 200 / single H1 / 0 console errors) |
| One-line next step | Advance cluster A to **team_190 L-GATE_VALIDATE** (Cursor, cross-engine) |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| engine | **Cursor Composer** (non-Claude — IR#1 compliant) |
| attestation | Independent re-verification over HTTP staging; did **not** rely on team_100 pre-flight |
| Repo @ QA time | branch `main` · HEAD `1d0e925` |

---

# §2 Commands Run + Exit Codes

Base: `http://eyalamit-co-il-2026.s887.upress.link` (HTTP-only; staging TLS cert expired — Lighthouse uses `--ignore-certificate-errors` on https).

| Command | Exit code | Notes |
|---------|-----------|-------|
| `node scripts/qa/http-qa-axe.cjs /treatment/ /method/ /sound-healing/ /lessons/` | **0** | 4/4 routes: 0 critical / 0 serious |
| `bash scripts/qa/http-qa-lighthouse.sh /treatment/ /method/` | **0** | Supplemental desktop preset |
| Mobile Lighthouse ×3 per route (AC-A5 authoritative perf bar) | n/a | https + `--form-factor=mobile`; perf/a11y only |

Cache-bust on HTTP status probe: `?cb=$(date +%s)$RANDOM`.

---

# §3 Per-Route Results

## HTTP status (curl, cache-busted)

| Route | HTTP |
|-------|------|
| `/treatment/` | **200** |
| `/method/` | **200** |
| `/sound-healing/` | **200** |
| `/lessons/` | **200** |

## Structural smoke (Puppeteer — single H1, console errors)

| Route | HTTP | H1 count | console errors |
|-------|------|----------|----------------|
| `/treatment/` | 200 | **1** | **0** |
| `/method/` | 200 | **1** | **0** |
| `/sound-healing/` | 200 | **1** | **0** |
| `/lessons/` | 200 | **1** | **0** |

## axe-core (`http-qa-axe.cjs`) — WCAG 2A/2AA

| Route | HTTP | critical | serious | moderate | minor | Result |
|-------|------|----------|---------|----------|-------|--------|
| `/treatment/` | 200 | 0 | 0 | 0 | 0 | **PASS** |
| `/method/` | 200 | 0 | 0 | 0 | 0 | **PASS** |
| `/sound-healing/` | 200 | 0 | 0 | 0 | 0 | **PASS** |
| `/lessons/` | 200 | 0 | 0 | 0 | 0 | **PASS** |

Report: `scripts/qa/reports/axe-http-2026-06-02.json`

## Lighthouse — desktop (`http-qa-lighthouse.sh`, staging-capped SEO/BP)

| Route | perf | a11y | best-practices | seo |
|-------|------|------|----------------|-----|
| `/treatment/` | 97 | 100 | 96 | 69 |
| `/method/` | 98 | 100 | 96 | 61 |

Reports: `scripts/qa/reports/lh_treatment_.json`, `scripts/qa/reports/lh_method_.json`  
Note: SEO/BP capped on staging (noindex + HTTP) — not scored against AC-A5.

## Lighthouse — mobile triple-run (AC-A5 authoritative perf bar)

| Route | Run 1 | Run 2 | Run 3 | **Median perf** | a11y (all runs) | AC-A5 perf |
|-------|-------|-------|-------|-----------------|-----------------|------------|
| `/treatment/` | 87 | 90 | 87 | **87** | 100 / 100 / 100 | **PASS** (≥85) |
| `/method/` | 87 | 87 | 87 | **87** | 100 / 100 / 100 | **PASS** (≥85) |

Reports: `scripts/qa/reports/lh-mobile-w2-10-a_treatment__run{1,2,3}.json`, `scripts/qa/reports/lh-mobile-w2-10-a_method__run{1,2,3}.json`

**Variance note:** team_100 pre-flight reported mobile median **97** on `/treatment/` + `/method/` (2026-06-02); this run median **87** — same staging TTFB variance class as WP-W2-11 Home/Blog (team_190 W04/W06). Bar still met (≥85).

---

# §4 Acceptance Criteria (Service subset — this S5 pass)

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| AC-A4 | axe 0 critical / 0 serious on all 4 routes | **PASS** | §3 axe table; axe exit **0** |
| AC-A5 | Lighthouse https: a11y **100**; mobile perf **≥85** (triple-run median) on `/treatment/` + sibling `/method/` | **PASS** | a11y **100** all 6 mobile runs ✓; median perf **87** both routes ✓ |
| AC-A7 | Per-route HTTP 200; single H1/route; no console errors | **PASS** | §3 HTTP + structural smoke |

**Out of scope for this QA-only run (not re-verified here):** AC-A1 S2 sign-off, AC-A2 composition mockup match vs elevation SSoT, AC-A3 token drift (team_80 PASS 2026-06-02), AC-A6 graceful gaps / real portrait wiring, AC-A7 `validate_aos` / `php -l`.

---

# §5 Findings

No blocking findings. No PASS_WITH_FINDINGS carry items for cluster A.

**Non-blocking observation (F-W2-10-A-01):** Mobile perf median **87** sits 2 points above the ≥85 bar with modest run variance on `/treatment/` (87/90/87). Monitor at production cutover re-measure; no team_10 action required for gate clearance.

---

# §6 Routing Recommendation

| Verdict | Route |
|---------|-------|
| **PASS** | Advance cluster A to **team_190 L-GATE_VALIDATE** (Cursor, cross-engine per IR#1/#5) |
| team_80 S4 | PASS (2026-06-02) — carried forward |
| team_100 pre-flight | Advisory PASS reproduced independently |

---

*team_50 — QA / L-GATE_BUILD — Cursor Composer — 2026-06-03*
