---
id: VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03-rev2
from: team_190 (L-GATE_VALIDATE)
to: team_100, team_50, team_10
type: QA_VERDICT
gate: L-GATE_VALIDATE
date: 2026-06-03
round: 2
engine: cursor-composer (cross-engine; IR#1 + IR#5)
verdict: PASS
blocking_findings: 0
cluster: EN landing (F) — /en
wp: WP-W2-10-F (S003 Track-2)
branch: main
worktree_head: 9d0d313e0869d912fdb4c2d389d361b38ab961d4
fix_commit: 9d0d313
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref: _aos/work_packages/S003/WP-W2-10-F/LOD400_IMPL_spec.md §7
elevation_ssot: _COMMUNICATION/team_35/WP-W2-10-F/elevation/
token_gate_ref: _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-F-2026-06-02.md
build_gate_ref: _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03-rev2.md
prior_validate: _COMMUNICATION/team_190/VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03.md (round-1 FAIL)
fix_ref: _COMMUNICATION/team_100/FIX-WP-W2-10-F-TEMPLATE-ROUTE-2026-06-03.md
mandate_ref: _COMMUNICATION/team_190/MANDATE-TEAM190-WP-W2-10-L-GATE-VALIDATE-2026-06-03.md
---

# VERDICT — WP-W2-10-F EN landing cluster | L-GATE_VALIDATE (rev2)

## §0 Verdict box

| Field | Value |
|-------|-------|
| WP | WP-W2-10-F — EN landing (`tpl-en-landing`, 1 route) |
| Gate | L-GATE_VALIDATE re-validate (post P0 template_include fix) |
| Predecessor | team_50 L-GATE_BUILD **PASS** (`QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03-rev2.md`) |
| Prior round-1 | **FAIL** (P0 tpl shell not active) — **closed** in this run |
| Verdict | **PASS** |
| Blocking (P0/P1) | **0** |
| Non-blocking | F-W2-10-F-01 (closing CTAs `/contact?lang=en` vs mockup `#contact` — mandate carry-forward) |
| Cluster close | **APPROVED** — cluster F may close; return to team_100 |

---

## §1 Gate chain

| Step | Artifact | Status |
|------|----------|--------|
| P0 fix | `FIX-WP-W2-10-F-TEMPLATE-ROUTE-2026-06-03.md` · `ea_w2_08_template_include()` | Applied |
| S5 re-pass | `QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03-rev2.md` | **PASS** (confirmed) |
| S5 validate | this document | **PASS** |

---

## §2 P0 closure (round-1 → rev2)

| Check | Round-1 | Rev2 |
|-------|---------|------|
| `tpl-en-landing.php` shell active | GP `page-template-default` only; blocks 1+8 missing | `<main id="main" class="ea-wave2-en" lang="en" dir="ltr">` ✓ |
| GP default `<main class="site-main">` | Present | **0** DOM occurrences (GP CSS ref only) |
| EN topnav (block 1) | Missing | `data-block="topnav"` + `ea-topnav` `dir="ltr"` ✓ |
| Language pill → Hebrew `/` | Missing | `a.ea-lang-pill` → `home_url('/')` · label **עברית** ✓ |
| EN footer (block 8) | GP site footer | `<footer class="ea-footer" … dir="ltr">` after `</main>` ✓ |
| `<html>` LTR | ✓ | `<html lang="en" dir="ltr">` ✓ |

**Note:** `body` retains WP class `page-template-default` while `template_include` serves `tpl-en-landing.php` — acceptable per team_100 fix disposition; functional shell criteria met.

---

## §3 Composition parity (AC-F2 vs `en-landing.html`)

| # | Block | Mockup | Staging `/en/` | Result |
|---|-------|--------|----------------|--------|
| 1 | EN topnav | `ea-topnav` + lang pill | `data-block="topnav"` | **PASS** |
| 2 | Hero | `ea-en-hero` + kicker + H1 | `data-block="hero"` | **PASS** |
| 3 | About | `ea-en-section` | `data-block="about"` | **PASS** |
| 4 | Method | `#method` | `data-block="method"` | **PASS** |
| 5 | Services | `#services` + CTA | `data-block="services"` | **PASS** |
| 6 | Books row | `ea-en-books-row` ×3 covers | 3 imgs `ea-eyalamit` | **PASS** |
| 7 | Testimonials | `.ea-en-testimonial` ×4 | **4** figures | **PASS** |
| — | Closing CTA | `ea-en-closing` `#contact` | present in testimonials section | **PASS** |
| 8 | EN footer | `ea-footer` | inline tpl footer | **PASS** |

Block spine order verified: topnav → hero → about → method → services → books → testimonials → closing → footer (matches elevation mockup).

---

## §4 Acceptance criteria matrix

| AC | Verdict | Evidence |
|----|---------|----------|
| AC-F2 | **PASS** | §3 — all 8 blocks present, ordered, no stub/`the_content()` fallback |
| AC-F3 | **PASS** | `dir="ltr" lang="en"` on `<html>` + `<main>`; lang pill → `/`; logical props only (0 physical left/right in `w2-08-en-landing.css`) |
| AC-F-copy | **PASS** | 16/16 key EN strings match mockup / W2-08 source (hero kicker, H1, section headings, testimonial names, closing copy) |
| AC-A3 equiv. | **PASS** | team_80 PASS carried; cluster CSS grep 0 physical left/right |
| AC-F4 | **PASS** | axe `/en/` crit=0 serious=0 |
| AC-F5 | **PASS** | Mobile LH ×3 (HTTPS): median perf **89**, a11y **100** / **100** / **100** (≥85 bar) |
| AC-F7 | **PASS** | HTTP 200; H1=1; 0 console errors; 3 cover assets `ea-eyalamit` HTTP 200 |

---

## §5 What passed (independent reproduction)

| Check | Result |
|-------|--------|
| axe 0/0 | **PASS** |
| asset-smoke | **PASS** (3 imgs, `assetPass=true`, consoleErr=0) |
| Mobile LH ≥85 / a11y 100 | **PASS** (median **89**) |
| Testimonials ×4 | **PASS** |
| `html` + `main` dir=ltr lang=en | **PASS** |
| hreflang en/he/x-default | **PASS** |
| Single H1 | **PASS** |

---

## §6 Findings (non-blocking)

**F-W2-10-F-01:** All three “Schedule an introductory call” CTAs use `/contact?lang=en` (functional) vs mockup `#contact` anchor — mandate carry-forward; not scored blocking.

---

## §7 Validator reproduction (2026-06-03)

```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/scripts/qa"
node http-qa-axe.cjs /en/
node wp-w2-10-asset-smoke.cjs /en/
# Mobile LH ×3 (HTTPS, --ignore-certificate-errors):
# reports/lh-mobile-t190-w2-10-f_en_run{1,2,3}.json
curl -s "http://eyalamit-co-il-2026.s887.upress.link/en/" | grep -E 'ea-lang-pill|<main id|ea-footer|data-block'
```

| Command | Exit |
|---------|------|
| axe `/en/` | **0** |
| asset-smoke `/en/` | **0** |
| Mobile LH ×3 median perf | **89** |

---

## §8 Routing

| Verdict | Route |
|---------|-------|
| **PASS** | Cluster F **CLOSE** → **team_100** for WP-W2-10 roll-up closure |

**WP-W2-10 cluster roll-up:** A (rev2 PASS) · B (PASS) · E (PASS) · F (rev2 PASS) — **all four clusters cleared**. team_100 may proceed per ADR042 (team_191 ARCHIVE_MANIFEST → roadmap DONE/LOD500_LOCKED on team_00 go).

---

*Issued by team_190 · L-GATE_VALIDATE rev2 · WP-W2-10-F · 2026-06-03 · Cursor Composer cross-engine.*
