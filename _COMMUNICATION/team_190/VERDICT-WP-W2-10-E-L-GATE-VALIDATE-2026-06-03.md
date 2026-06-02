---
id: VERDICT-WP-W2-10-E-L-GATE-VALIDATE-2026-06-03
from: team_190 (L-GATE_VALIDATE)
to: team_100, team_50, team_10
type: QA_VERDICT
gate: L-GATE_VALIDATE
date: 2026-06-03
round: 1
engine: cursor-composer (cross-engine; IR#1 + IR#5)
verdict: PASS
blocking_findings: 0
cluster: Commerce (E) — /books, 3 book details, /shop
wp: WP-W2-10-E (S003 Track-2)
branch: main
worktree_head: c231b21effb16877900bd02cb6867aa3d30053fa
fix_commit: 75bc8c7
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref: _aos/work_packages/S003/WP-W2-10-E/LOD400_IMPL_spec.md §7
elevation_ssot: _COMMUNICATION/team_35/WP-W2-10-E/elevation/
token_gate_ref: _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-E-2026-06-02.md
build_gate_ref: _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-E-L-GATE-BUILD-2026-06-03-rev2.md
fix_ref: _COMMUNICATION/team_100/FIX-WP-W2-10-E-COVER-PERF-2026-06-03.md
mandate_ref: _COMMUNICATION/team_190/MANDATE-TEAM190-WP-W2-10-L-GATE-VALIDATE-2026-06-03.md
---

# VERDICT — WP-W2-10-E Commerce cluster | L-GATE_VALIDATE

## §0 Verdict box

| Field | Value |
|-------|-------|
| WP | WP-W2-10-E — Commerce (5 routes) |
| Gate | L-GATE_VALIDATE (team_190) |
| Predecessor | team_50 L-GATE_BUILD **PASS** (`QA-VERDICT-WP-W2-10-E-L-GATE-BUILD-2026-06-03-rev2.md`) |
| Verdict | **PASS** |
| Blocking (P0/P1) | **0** |
| Non-blocking | F-W2-10-E-01 (tsva vendor URL SSoT `tzvabekahol` vs legacy spelling — mandate carry-forward) |
| Cluster close | **APPROVED** |

---

## §1 Gate chain

team_50 rev2 PASS confirmed (post cover/LCP fix `75bc8c7`). Portrait/URI systemic fix also applies to book covers (`get_stylesheet_directory_uri`). Independent full A/C boundary exercised.

---

## §2 Acceptance criteria

| AC | Verdict | Evidence |
|----|---------|----------|
| AC-E2 | **PASS** | Archive + 3 details + `/shop/` elevated composition; no stub fallback |
| AC-E3 (D-14) | **PASS** | team_80 PASS carried |
| AC-E4 | **PASS** | axe 0/0 on 5 routes |
| AC-E5 | **PASS** | Mobile ×3: `/books/` median perf **85** a11y **100**; `/books/vekatavta/` median **86** a11y **100** |
| AC-E7 | **PASS** | HTTP 200; H1=1; 0 console errors; asset-smoke **PASS** |

---

## §3 Cluster-specific checks

| Check | Result | Evidence |
|-------|--------|----------|
| Real covers render | **PASS** | asset-smoke: archive 6 covers + 2/detail; `naturalWidth > 0` on `/books/vekatavta/` |
| Excerpt **open** by default | **PASS** | `details.ea-book-excerpt[open]` on all 3 detail routes |
| FAQ ×4 verbatim (per clone) | **PASS** | `details.ea-faq-item` count **4** on vekatavta, kushi-blantis, tsva-bekahol |
| ALL purchase CTAs **external** | **PASS** | Hrefs → `mendele.co.il` / `mrng.to` (Morning); **0** internal `/checkout` |
| 3 detail clones distinct | **PASS** | H1s: “וכתבת” / “כושי בלאנטיס” / “צבע בכחול וזרוק לים” |
| Archive block spine | **PASS** | `/books/`: `hero`, `why-here`, `book-cards`, `bundle`, `shop-grid` (+ chrome) |

---

## §4 Validator reproduction

```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/scripts/qa"
node http-qa-axe.cjs /books/ /books/vekatavta/ /books/kushi-blantis/ /books/tsva-bekahol/ /shop/
node wp-w2-10-asset-smoke.cjs /books/ /books/vekatavta/ /books/kushi-blantis/ /books/tsva-bekahol/ /shop/
# Mobile LH: reports/lh-mobile-t190-w2-10-e_{books,books_vekatavta}_run{1,2,3}.json
```

| Command | Exit |
|---------|------|
| axe (5 routes) | **0** |
| asset-smoke | **0** |

---

## §5 Routing

| Verdict | Route |
|---------|-------|
| **PASS** | Cluster E **CLOSE** → team_100 |

---

*Issued by team_190 · L-GATE_VALIDATE · WP-W2-10-E · 2026-06-03 · Cursor Composer cross-engine.*
