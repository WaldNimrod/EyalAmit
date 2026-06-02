---
id: VERDICT-WP-W2-10-B-L-GATE-VALIDATE-2026-06-03
from: team_190 (L-GATE_VALIDATE)
to: team_100, team_50, team_10
type: QA_VERDICT
gate: L-GATE_VALIDATE
date: 2026-06-03
round: 1
engine: cursor-composer (cross-engine; IR#1 + IR#5)
verdict: PASS
blocking_findings: 0
cluster: Editorial (B) — /about, /press, /about/moksha
wp: WP-W2-10-B (S003 Track-2)
branch: main
worktree_head: c231b21effb16877900bd02cb6867aa3d30053fa
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref: _aos/work_packages/S003/WP-W2-10-B/LOD400_IMPL_spec.md §7
elevation_ssot: _COMMUNICATION/team_35/WP-W2-10-B/elevation/
token_gate_ref: _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-B-2026-06-02.md
build_gate_ref: _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-B-L-GATE-BUILD-2026-06-03.md
fix_ref: _COMMUNICATION/team_100/FIX-WP-W2-10-PORTRAIT-URI-2026-06-03.md
mandate_ref: _COMMUNICATION/team_190/MANDATE-TEAM190-WP-W2-10-L-GATE-VALIDATE-2026-06-03.md
---

# VERDICT — WP-W2-10-B Editorial cluster | L-GATE_VALIDATE

## §0 Verdict box

| Field | Value |
|-------|-------|
| WP | WP-W2-10-B — Editorial (3 routes, `tpl-content`) |
| Gate | L-GATE_VALIDATE (team_190) |
| Predecessor | team_50 L-GATE_BUILD **PASS** (`QA-VERDICT-WP-W2-10-B-L-GATE-BUILD-2026-06-03.md`) |
| Verdict | **PASS** |
| Blocking (P0/P1) | **0** |
| Non-blocking | F-W2-10-B-01 (editorial routes not in primary nav — mandate carry-forward) |
| Cluster close | **APPROVED** |

---

## §1 Gate chain

team_50 PASS confirmed. Portrait URI systemic fix (`407965a`) verified on `/about/` assets (5× `ea-eyalamit` HTTP 200). Independent full A/C boundary exercised.

---

## §2 Acceptance criteria

| AC | Verdict | Evidence |
|----|---------|----------|
| AC-B2 | **PASS** | `tpl-content` + `main.ea-wave2-editorial`; full block spine vs `editorial-about.html`; no bare stub |
| AC-B3 (D-14) | **PASS** | team_80 PASS carried; `ea-tokens.css` unchanged |
| AC-B4 | **PASS** | axe 0/0 on `/about/`, `/press/`, `/about/moksha/` |
| AC-B5 | **PASS** | Mobile ×3: `/about/` median perf **86** a11y **100**; `/press/` median **85** a11y **100** |
| AC-B7 | **PASS** | HTTP 200; H1=1; 0 console errors; asset-smoke **PASS** (3 routes) |

---

## §3 Cluster-specific checks

| Check | Result | Evidence |
|-------|--------|----------|
| Memorial = dedicated **section** (not link) | **PASS** | `<section data-block="memorial">`; `memorialIsLink=false` |
| Memorial copy verbatim | **PASS** | H2 “מוקש דהימן”; pullquote matches `ea_wave2_editorial_memorial()` |
| Journey timeline ×6 | **PASS** | `.ea-pillars-grid .ea-pillar` count **6** on `/about/` |
| AA on `--ea-ink` | **PASS** | `.ea-edhero__lead` on `.ea-edhero` bg: contrast ratio **≈14.1** (≥4.5) |
| AA on `--ea-bg` | **PASS** | Prose on `--ea-bg` effective surface; axe **0 serious** on all routes (independent AA bar) |
| Real portrait + studio assets | **PASS** | asset-smoke: 5 imgs `/about/`, 4 `/press/`, 1 `/about/moksha/` — all `ea-eyalamit` HTTP 200 |
| `/about/moksha/` memorial | **PASS** | `data-block="memorial"` present (curl) |

### Block order (primary `/about/`)

`editorial-hero` → `metastrip` → `intro` → `breath-divider-1` → `content-section` → `method-pillars` (journey) → `breath-divider-1` → `memorial` → `studio` → `books-crosslink` → `contact-cta` (+ chrome `topnav`/`footer-social`).

`/press/`: `editorial-hero` → `metastrip` → `breath-divider-1` → `press` → `testimonials-row` → `books-crosslink` → `contact-cta`.

---

## §4 Validator reproduction

```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/scripts/qa"
node http-qa-axe.cjs /about/ /press/ /about/moksha/
node wp-w2-10-asset-smoke.cjs /about/ /press/ /about/moksha/
# Mobile LH: reports/lh-mobile-t190-w2-10-b_{about,press}_run{1,2,3}.json
```

| Command | Exit |
|---------|------|
| axe (3 routes) | **0** |
| asset-smoke | **0** |

---

## §5 Routing

| Verdict | Route |
|---------|-------|
| **PASS** | Cluster B **CLOSE** → team_100 |

---

*Issued by team_190 · L-GATE_VALIDATE · WP-W2-10-B · 2026-06-03 · Cursor Composer cross-engine.*
