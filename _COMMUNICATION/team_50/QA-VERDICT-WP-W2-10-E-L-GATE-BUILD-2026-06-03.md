---
id: QA-VERDICT-WP-W2-10-E-L-GATE-BUILD-2026-06-03
title: team_50 L-GATE_BUILD QA Verdict — WP-W2-10-E Commerce cluster
date: 2026-06-03
from_team: team_50 (QA / L-GATE_BUILD)
to_team: team_100 (orchestrator) — return for remediation
wp: WP-W2-10-E
cluster: Commerce (E) — /books, 3 book details, /shop
gate: L-GATE_BUILD
branch: main
head_commit: b52b062
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_50/MANDATE-TEAM50-WP-W2-10-L-GATE-BUILD-2026-06-03.md
fix_ref: _COMMUNICATION/team_100/FIX-WP-W2-10-PORTRAIT-URI-2026-06-03.md
spec_ref: _aos/work_packages/S003/WP-W2-10-E/LOD400_IMPL_spec.md §7
token_compliance: _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-E-2026-06-02.md
status: ISSUED
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-10-E — Commerce cluster (5 routes) |
| Gate | L-GATE_BUILD (S5 HTTP QA) |
| Verdict | **FAIL** |
| Blocking AC | **AC-E5** — mobile perf median **73** on `/books/vekatavta/` (< **85** bar) |
| ACs in scope | AC-E4 **PASS** · AC-E5 **FAIL** · AC-E7 **PASS** · asset-200 **PASS** |
| One-line next step | Return to **team_10** — reduce mobile perf drag on book detail template; re-deploy; team_50 re-run |

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
| `node scripts/qa/http-qa-axe.cjs /books/ /books/vekatavta/ /books/kushi-blantis/ /books/tsva-bekahol/ /shop/` | **0** | 5/5: 0 critical / 0 serious |
| `node scripts/qa/wp-w2-10-asset-smoke.cjs` (same 5 routes) | **0** | asset-200 + H1 + console |
| `bash scripts/qa/http-qa-lighthouse.sh /books/ /books/vekatavta/` | **0** | Supplemental desktop preset |
| Mobile Lighthouse ×3 per route (AC-E5 bar) | n/a | https + `--form-factor=mobile` |
| Confirm triple-run `/books/vekatavta/` | n/a | Reproduced FAIL (median **73**) |

---

# §3 Per-Route Results

## HTTP / structural / assets

| Route | HTTP | H1 | console err | `assets/images/*` imgs | asset-200 + ea-eyalamit |
|-------|------|----|-------------|------------------------|-------------------------|
| `/books/` | 200 | 1 | 0 | 6 (3 covers ×2) | **PASS** |
| `/books/vekatavta/ | 200 | 1 | 0 | 2 (cover + gallery) | **PASS** |
| `/books/kushi-blantis/` | 200 | 1 | 0 | 2 | **PASS** |
| `/books/tsva-bekahol/` | 200 | 1 | 0 | 2 | **PASS** |
| `/shop/` | 200 | 1 | 0 | 0 | **PASS** (n/a) |

All resolved cover/gallery srcs use `themes/ea-eyalamit` and return HTTP **200**.

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
| `/books/` | 93 | 100 | 100 | 61 |
| `/books/vekatavta/` | 98 | 100 | 100 | 61 |

## Lighthouse — mobile triple-run (AC-E5 authoritative)

| Route | Run 1 | Run 2 | Run 3 | **Median perf** | a11y (all runs) | AC-E5 |
|-------|-------|-------|-------|-----------------|-----------------|-------|
| `/books/` | 90 | 87 | 85 | **87** | 100 / 100 / 100 | **PASS** |
| `/books/vekatavta/` | 73 | 76 | 73 | **73** | 100 / 100 / 100 | **FAIL** |

Confirm run (independent triple): perf **73 / 73 / 67** → median **73**.

Reports: `scripts/qa/reports/lh-mobile-w2-10-e-rev2_books__run{1,2,3}.json`, `…_books_vekatavta__run{1,2,3}.json`, confirm: `…e-rev2-vekatavta-confirm-run{1,2,3}.json`

**Note:** Desktop preset on `/books/vekatavta/` scored perf **98** — axis mismatch confirms mobile is the authoritative AC-E5 bar (same pattern as WP-W2-11 Conversion disposition).

---

# §4 Acceptance Criteria

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| AC-E4 | axe 0 critical / 0 serious (5 routes) | **PASS** | §3 axe |
| AC-E5 | Mobile LH: a11y 100; perf median ≥85 on `/books/` + `/books/vekatavta/` | **FAIL** | `/books/` median **87** ✓; `/books/vekatavta/` median **73** ✗ |
| AC-E7 | HTTP 200; single H1; 0 console errors | **PASS** | §3 structural |
| Asset-200 | Every `assets/images/*` src → ea-eyalamit + HTTP 200 | **PASS** | §3 assets |

---

# §5 Findings

## F-W2-10-E-01 — **P1 / BLOCKING** — Mobile Lighthouse perf median 73 on `/books/vekatavta/`

**Description:** Primary sibling detail route misses the S5 mobile perf bar by 12 points (median **73**, stable across two independent triple-runs). Archive `/books/` clears at median **87**.

**Likely driver:** Detail template payload (cover hero split + gallery image `kushi-02-eyal-italy.jpg` on vekatavta) — investigate image sizing/deferral and Wave2 asset dequeue on `tpl-book-detail` pattern.

**Remediation:** team_10 — optimize detail-route mobile perf; redeploy; team_50 re-run S5.

## F-W2-10-E-02 — **non-blocking carry-forward**

tsva vendor URL uses asset-manifest SSoT (`tzvabekahol`) — per mandate; not blocking this FAIL.

---

# §6 Routing Recommendation

| Verdict | Route |
|---------|-------|
| **FAIL** (AC-E5 blocking) | **Do not** advance cluster E to team_190 until `/books/vekatavta/` mobile perf median ≥85 |
| AC-E4 + AC-E7 + asset-200 | Clean — carry forward on re-run |
| team_80 S4 | PASS (2026-06-02) — non-blocking |

---

*team_50 — QA / L-GATE_BUILD — Cursor Composer — 2026-06-03*
