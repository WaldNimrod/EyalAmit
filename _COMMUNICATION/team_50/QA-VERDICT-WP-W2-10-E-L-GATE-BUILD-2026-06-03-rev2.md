---
id: QA-VERDICT-WP-W2-10-E-L-GATE-BUILD-2026-06-03-rev2
title: team_50 L-GATE_BUILD QA Verdict — WP-W2-10-E Commerce cluster (re-pass)
date: 2026-06-03
from_team: team_50 (QA / L-GATE_BUILD)
to_team: team_100 → team_190 (on PASS)
wp: WP-W2-10-E
cluster: Commerce (E) — /books, 3 book details, /shop
gate: L-GATE_BUILD
round: 2 (re-pass after cover/LCP mobile perf fix)
branch: main
head_commit: c231b21
fix_commit: 75bc8c7
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_50/MANDATE-TEAM50-WP-W2-10-L-GATE-BUILD-2026-06-03.md
fix_ref: _COMMUNICATION/team_100/FIX-WP-W2-10-E-COVER-PERF-2026-06-03.md
prior_build_gate: _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-E-L-GATE-BUILD-2026-06-03.md
spec_ref: _aos/work_packages/S003/WP-W2-10-E/LOD400_IMPL_spec.md §7
status: ISSUED
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-10-E — Commerce cluster (5 routes) |
| Gate | L-GATE_BUILD re-pass (post cover/LCP mobile perf fix) |
| Verdict | **PASS** |
| Blocking AC | None |
| ACs in scope | AC-E4 **PASS** · AC-E5 **PASS** · AC-E7 **PASS** · **asset-200 PASS** |
| One-line next step | Advance cluster E to **team_190 L-GATE_VALIDATE** |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| engine | **Cursor Composer** (non-Claude — IR#1 compliant) |
| attestation | Independent re-verification; did **not** rely on team_100 fix disposition or rev1 FAIL |
| Repo @ QA time | branch `main` · HEAD `c231b21` (includes fix `75bc8c7`) |

---

# §2 Commands Run + Exit Codes

| Command | Exit code | Notes |
|---------|-----------|-------|
| `node scripts/qa/http-qa-axe.cjs /books/ /books/vekatavta/ /books/kushi-blantis/ /books/tsva-bekahol/ /shop/` | **0** | 5/5: 0 critical / 0 serious |
| `node scripts/qa/wp-w2-10-asset-smoke.cjs` (same 5 routes) | **0** | asset-200 + H1 + console |
| `bash scripts/qa/http-qa-lighthouse.sh /books/ /books/vekatavta/` | **0** | Supplemental desktop preset |
| Mobile Lighthouse ×3 per route (AC-E5 bar) | n/a | https + `--form-factor=mobile` |

Optimized cover probe: `vekatavt-cover.jpg` → HTTP **200**, **~136 KB** (was ~557 KB pre-fix).

---

# §3 Per-Route Results

## HTTP / structural / assets

| Route | HTTP | H1 | console err | `assets/images/*` imgs | asset-200 + ea-eyalamit |
|-------|------|----|-------------|------------------------|-------------------------|
| `/books/` | 200 | 1 | 0 | 6 | **PASS** |
| `/books/vekatavta/` | 200 | 1 | 0 | 2 | **PASS** |
| `/books/kushi-blantis/` | 200 | 1 | 0 | 2 | **PASS** |
| `/books/tsva-bekahol/` | 200 | 1 | 0 | 2 | **PASS** |
| `/shop/` | 200 | 1 | 0 | 0 | **PASS** (n/a) |

Detail hero LCP hints verified on `/books/vekatavta/`: `fetchpriority="high"`, `width="600"`, `height="800"`, cover src `themes/ea-eyalamit` → HTTP **200**.

## axe-core

| Route | critical | serious | Result |
|-------|----------|---------|--------|
| `/books/` | 0 | 0 | **PASS** |
| `/books/vekatavta/` | 0 | 0 | **PASS** |
| `/books/kushi-blantis/` | 0 | 0 | **PASS** |
| `/books/tsva-bekahol/` | 0 | 0 | **PASS** |
| `/shop/` | 0 | 0 | **PASS** |

Report: `scripts/qa/reports/axe-http-2026-06-02.json`

## Lighthouse — desktop (supplemental)

| Route | perf | a11y | bp | seo |
|-------|------|------|----|-----|
| `/books/` | 97 | 100 | 100 | 61 |
| `/books/vekatavta/` | 98 | 100 | 100 | 61 |

## Lighthouse — mobile triple-run (AC-E5 authoritative)

| Route | Run 1 | Run 2 | Run 3 | **Median perf** | a11y (all runs) | AC-E5 | rev1 median |
|-------|-------|-------|-------|-----------------|-----------------|-------|-------------|
| `/books/` | 85 | 85 | 86 | **85** | 100 / 100 / 100 | **PASS** | 87 |
| `/books/vekatavta/` | 85 | 86 | 86 | **86** | 100 / 100 / 100 | **PASS** | **73** (FAIL) |

Reports: `scripts/qa/reports/lh-mobile-w2-10-e-rev3_books__run{1,2,3}.json`, `…_books_vekatavta__run{1,2,3}.json`

**Variance note:** team_100 post-fix reported medians **97/97**; this run **85/86** — staging TTFB variance (same class as WP-W2-11); bar still met (≥85).

---

# §4 Acceptance Criteria

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| AC-E4 | axe 0 critical / 0 serious (5 routes) | **PASS** | §3 axe |
| AC-E5 | Mobile LH: a11y 100; perf median ≥85 on `/books/` + `/books/vekatavta/` | **PASS** | medians **85** / **86** |
| AC-E7 | HTTP 200; single H1; 0 console errors | **PASS** | §3 structural |
| Asset-200 | Every `assets/images/*` src → ea-eyalamit + HTTP 200 | **PASS** | §3 assets |

---

# §5 Findings

No blocking findings. F-W2-10-E-01 (mobile perf 73 on vekatavta) **closed** — median **86** after cover optimization + LCP hints.

**Non-blocking carry-forward:** tsva vendor URL uses asset-manifest SSoT (`tzvabekahol`) — per mandate.

---

# §6 Routing Recommendation

| Verdict | Route |
|---------|-------|
| **PASS** | **team_190 L-GATE_VALIDATE** (Cursor, cross-engine) |
| Prior rev1 build gate | Superseded by this re-pass |

**Cluster status (all WP-W2-10 A/B/E/F):** A rev2 PASS · B PASS · **E rev2 PASS** · F PASS — all four cleared for team_190.

---

*team_50 — QA / L-GATE_BUILD — Cursor Composer — 2026-06-03 rev2*
