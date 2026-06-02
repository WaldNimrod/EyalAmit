---
id: QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03-rev2
title: team_50 L-GATE_BUILD QA Verdict (re-pass) — WP-W2-10-F EN landing cluster
date: 2026-06-03
from_team: team_50 (QA / L-GATE_BUILD)
to_team: team_190 (on PASS)
wp: WP-W2-10-F
cluster: EN landing (F) — /en
gate: L-GATE_BUILD
round: 2 (post team_10 template_include fix)
branch: main
head_commit: 9d0d313
staging: http://eyalamit-co-il-2026.s887.upress.link
fix_ref: _COMMUNICATION/team_100/FIX-WP-W2-10-F-TEMPLATE-ROUTE-2026-06-03.md
prior_build: _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03.md
prior_validate_fail: _COMMUNICATION/team_190/VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03.md
spec_ref: _aos/work_packages/S003/WP-W2-10-F/LOD400_IMPL_spec.md §7
status: ISSUED
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-10-F — EN landing (1 route, tpl-en-landing via `template_include`) |
| Gate | L-GATE_BUILD (S5 HTTP QA) — **re-pass** after team_190 P0 |
| Verdict | **PASS** |
| Blocking AC | None |
| P0 template routing | **PASS** (see §4) |
| ACs in scope | AC-F4 **PASS** · AC-F5 **PASS** · AC-F7 **PASS** · **asset-200 PASS** |
| One-line next step | Advance cluster F to **team_190 L-GATE_VALIDATE** (re-validate) |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| engine | **Cursor Composer** (non-Claude — IR#1 compliant) |
| attestation | Independent re-verification on staging post-fix; did **not** rely on team_100 pre-flight |
| Repo @ QA time | branch `main` · HEAD `9d0d313` |

---

# §2 Commands Run + Exit Codes

| Command | Exit code | Notes |
|---------|-----------|-------|
| `node scripts/qa/http-qa-axe.cjs /en/` | **0** | 0 critical / 0 serious |
| `node scripts/qa/wp-w2-10-asset-smoke.cjs /en/` | **0** | asset-200 + H1 + console |
| `bash scripts/qa/http-qa-lighthouse.sh /en/` | **0** | Supplemental desktop preset (https) |
| Mobile Lighthouse ×3 on `/en/` (AC-F5 bar) | **0** | `--form-factor=mobile`; median perf **89** |

---

# §3 Per-Route Results

## HTTP / structural / assets

| Route | HTTP | H1 | console err | `assets/images/*` imgs | asset-200 + ea-eyalamit |
|-------|------|----|-------------|------------------------|-------------------------|
| `/en/` | 200 | 1 | 0 | 3 (book covers) | **PASS** |

Sample assets (all `themes/ea-eyalamit`, HTTP 200): `tsva-bechol-cover.jpg`, `kushi-blantis-cover.jpg`, `vekatavt-cover.jpg`.

## axe-core

| Route | critical | serious | Result |
|-------|----------|---------|--------|
| `/en/` | 0 | 0 | **PASS** |

Report: `scripts/qa/reports/axe-http-2026-06-02.json`

## Lighthouse — desktop (supplemental)

| Route | perf | a11y | bp | seo |
|-------|------|------|----|-----|
| `/en/` | 93 | 100 | 100 | 61 |

## Lighthouse — mobile triple-run (AC-F5 authoritative)

| Route | Run 1 | Run 2 | Run 3 | **Median perf** | a11y (all runs) | AC-F5 |
|-------|-------|-------|-------|-----------------|-----------------|-------|
| `/en/` | 89 | 89 | 89 | **89** | 100 / 100 / 100 | **PASS** |

Reports: `scripts/qa/reports/lh-mobile-w2-10-f-rev2-en_run{1,2,3}.json`

---

# §4 P0 Template Check (team_190 T190-W2-10-F-P0-01 remediation)

Staging HTML smoke (`GET /en/`, 2026-06-03):

| Check | Expected | Observed | Result |
|-------|----------|----------|--------|
| Elevated `<main>` LTR attrs | `<main … dir="ltr" lang="en">` on tpl shell | `<main id="main" class="ea-wave2-en" lang="en" dir="ltr">` | **PASS** |
| GP default main wrapper | **No** `<main class="site-main">` | 0 occurrences of `<main class="site-main"` | **PASS** |
| EN topnav (block 1) | `data-block="topnav"` + LTR nav | Present; `aria-label="Primary navigation" dir="ltr"` | **PASS** |
| Language pill → Hebrew `/` | `a.ea-lang-pill` → site root | `href="http://eyalamit-co-il-2026.s887.upress.link/"` (staging `home_url('/')`) | **PASS** |
| EN footer (block 8) | tpl `ea-footer` chrome | `<footer class="ea-footer" … dir="ltr">` after `</main>` | **PASS** |
| `<html>` LTR | `lang="en" dir="ltr"` | `<html lang="en" dir="ltr">` | **PASS** |

**Note:** `body` still carries WP class `page-template-default` while `template_include` serves `tpl-en-landing.php` chrome — acceptable per team_100 fix disposition; functional shell criteria above are met.

---

# §5 Acceptance Criteria

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| P0-template | tpl-en-landing chrome active (not GP `site-main` only) | **PASS** | §4 |
| AC-F4 | axe 0 critical / 0 serious | **PASS** | §3 axe |
| AC-F5 | Mobile LH: a11y 100; perf median ≥85 on `/en/` | **PASS** | median **89** |
| AC-F7 | HTTP 200; single H1; 0 console errors | **PASS** | §3 structural |
| Asset-200 | Every `assets/images/*` src → ea-eyalamit + HTTP 200 | **PASS** | §3 assets |

---

# §6 Findings (non-blocking carry-forward)

**F-W2-10-F-01:** Closing CTA uses `/contact?lang=en` vs mockup `#contact` — mandate carry-forward; not scored in this HTTP QA pass.

No blocking findings.

---

# §7 Routing Recommendation

| Verdict | Route |
|---------|-------|
| **PASS** | **team_190 L-GATE_VALIDATE** (Cursor, cross-engine — re-validate AC-F2/F3 + P0 closure) |

---

*team_50 — QA / L-GATE_BUILD re-pass — Cursor Composer — 2026-06-03*
