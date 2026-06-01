---
id: QA-VERDICT-WP-W2-11-CONVERSION-L-GATE-BUILD-2026-06-02
title: team_50 L-GATE_BUILD QA Verdict — WP-W2-11 Conversion (S3 deploy)
date: 2026-06-02
from_team: team_50 (QA / L-GATE_BUILD)
to_team: team_100 (Chief System Architect)
wp: WP-W2-11
cluster: Conversion (C) — /contact, /faq
gate: L-GATE_BUILD
branch: feature/s003-base-implementation-prep
head_commit: 27cd3c6
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_100/MANDATE-TEAM10-WP-W2-11-S3-CONVERSION-2026-06-01.md §6 (S5)
spec_ref: _aos/work_packages/S003/WP-W2-11/LOD400_spec.md
token_compliance: _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-11-CONVERSION-2026-06-02.md
status: ISSUED
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-11 — Conversion cluster (`/contact`, `/faq`) |
| Gate | L-GATE_BUILD (S5 HTTP QA) |
| Verdict | **FAIL** |
| Blocking AC | **AC-04** — Lighthouse mobile perf median **83** on both routes (< **85** bar) |
| ACs in scope (this run) | AC-03 **PASS** · AC-04 **FAIL** · AC-07 **PASS** (HTTP 200) |
| One-line next step | Return to **team_10** — reduce mobile perf variance / TTFB (server-response-time ~760–790 ms); re-run S5 after deploy |

---

# §1 Engine Declaration (IR#1)

| Field | Value |
|-------|-------|
| engine | **Cursor Composer** (non-Claude — IR#1 compliant) |
| attestation | Independent re-verification over HTTP staging; did not rely on team_10 self-smoke alone |
| Repo @ QA time | branch `feature/s003-base-implementation-prep` · HEAD `27cd3c6` |

---

# §2 Commands Run + Exit Codes

Base: `http://eyalamit-co-il-2026.s887.upress.link` (HTTP-only; staging TLS cert expired — Lighthouse uses `--ignore-certificate-errors`).

| Command | Exit code | Notes |
|---------|-----------|-------|
| `node scripts/qa/http-qa-axe.cjs /contact/ /faq/` | **0** | 2/2 routes: 0 critical / 0 serious |
| `bash scripts/qa/http-qa-lighthouse.sh /contact/ /faq/` | **0** | Script exits 0 on completion (no pass/fail gate built in); desktop preset |
| Supplemental: mobile Lighthouse ×3 per route (AC-04 bar) | n/a | Required by mandate PASS bar (`mobile perf ≥85 triple-run median`); `http-qa-lighthouse.sh` is desktop-only |

Cache-bust on HTTP status probe: `?cb=$(date +%s)$RANDOM`.

---

# §3 Per-Route Results

## HTTP status (curl, cache-busted)

| Route | HTTP |
|-------|------|
| `/contact/` | **200** |
| `/faq/` | **200** |

## axe-core (`http-qa-axe.cjs`) — WCAG 2A/2AA

| Route | HTTP | critical | serious | moderate | minor | Result |
|-------|------|----------|---------|----------|-------|--------|
| `/contact/` | 200 | 0 | 0 | 0 | 0 | **PASS** |
| `/faq/` | 200 | 0 | 0 | 0 | 0 | **PASS** |

Report: `scripts/qa/reports/axe-http-2026-06-01.json`

## Lighthouse — desktop (`http-qa-lighthouse.sh`, staging-capped SEO/BP)

| Route | perf | a11y | best-practices | seo |
|-------|------|------|----------------|-----|
| `/contact/` | 96 | 100 | 81 | 58 |
| `/faq/` | 97 | 100 | 81 | 58 |

Reports: `scripts/qa/reports/lh_contact_.json`, `scripts/qa/reports/lh_faq_.json`  
Note: SEO/BP capped on staging (noindex + HTTP) — not scored against AC-04.

## Lighthouse — mobile triple-run (AC-04 authoritative perf bar)

| Route | Run 1 | Run 2 | Run 3 | **Median perf** | a11y (all runs) | AC-04 perf |
|-------|-------|-------|-------|-----------------|-----------------|------------|
| `/contact/` | 83 | 76 | 83 | **83** | 100 / 100 / 100 | **FAIL** (<85) |
| `/faq/` | 83 | 83 | 83 | **83** | 100 / 100 / 100 | **FAIL** (<85) |

Reports: `scripts/qa/reports/lh-mobile-contact-run{1,2,3}.json`, `scripts/qa/reports/lh-mobile-faq-run{1,2,3}.json`

Primary perf drag (run-1 sample): `server-response-time` root document **760–790 ms**; LCP **~3.5 s**; TBT 0 ms; CLS ≤0.018.

---

# §4 Acceptance Criteria (Conversion subset — this S5 pass)

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| AC-03 | axe 0 critical / 0 serious on both routes | **PASS** | §3 axe table; axe exit **0** |
| AC-04 | Lighthouse HTTP: a11y **100**; mobile perf **≥85** (triple-run median) | **FAIL** | a11y **100** all 6 mobile runs ✓; median perf **83** both routes ✗ |
| AC-07 | Deployed staging, per-route HTTP 200 | **PASS** | §3 HTTP status |

**Out of scope for this QA-only run (not re-verified here):** AC-01 composition mockup match, AC-02 token drift (team_80 PASS_WITH_FINDINGS 2026-06-02), AC-05 CF7/FAQ placeholders, AC-06 `validate_aos.sh` / `final_pre_cutover_check.sh` / `php -l`.

---

# §5 Findings

## F-W2-11-C-01 — **P1 / BLOCKING** — Mobile Lighthouse perf median 83 < 85

**Description:** Both conversion routes miss the harmonized S5 bar by 2 points on mobile perf median. `/contact/` shows run variance (76–83); `/faq/` is stable at 83/83/83.

**Likely driver:** Staging TTFB (`server-response-time` ~760–790 ms) — same class of variance seen historically (cf. T190-R2-BLOCKER-002 on Wave2 templates).

**Remediation:** team_10 — investigate Wave2 asset dequeue / server-side latency on conversion templates; redeploy; team_50 re-run S5.

---

# §6 Routing Recommendation

| Verdict | Route |
|---------|-------|
| **FAIL** (AC-04 blocking) | **Do not** advance to team_190 L-GATE_VALIDATE until mobile perf median ≥85 on both routes |
| AC-03 + AC-07 | Clean — carry forward on re-run |
| team_80 S4 | PASS_WITH_FINDINGS (non-blocking for this FAIL) |

---

*team_50 — QA / L-GATE_BUILD — Cursor Composer — 2026-06-02*
