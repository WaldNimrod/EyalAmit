---
id: VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03
from: team_190 (L-GATE_VALIDATE)
to: team_100, team_50, team_10
type: QA_VERDICT
gate: L-GATE_VALIDATE
date: 2026-06-03
round: 1
engine: cursor-composer (cross-engine; IR#1 + IR#5)
verdict: FAIL
blocking_findings: 1
cluster: EN landing (F) — /en
wp: WP-W2-10-F (S003 Track-2)
branch: main
worktree_head: c231b21effb16877900bd02cb6867aa3d30053fa
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref: _aos/work_packages/S003/WP-W2-10-F/LOD400_IMPL_spec.md §7
elevation_ssot: _COMMUNICATION/team_35/WP-W2-10-F/elevation/
token_gate_ref: _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-F-2026-06-02.md
build_gate_ref: _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03.md
mandate_ref: _COMMUNICATION/team_190/MANDATE-TEAM190-WP-W2-10-L-GATE-VALIDATE-2026-06-03.md
---

# VERDICT — WP-W2-10-F EN landing cluster | L-GATE_VALIDATE

## §0 Verdict box

| Field | Value |
|-------|-------|
| WP | WP-W2-10-F — EN landing (`tpl-en-landing`, 1 route) |
| Gate | L-GATE_VALIDATE (team_190) |
| Predecessor | team_50 L-GATE_BUILD **PASS** (`QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03.md`) |
| Verdict | **FAIL** |
| Blocking (P0) | **1** — `tpl-en-landing.php` chrome not active on staging; AC-F2/F3 LTR mirror incomplete |
| Non-blocking | F-W2-10-F-01 (closing CTA `/contact?lang=en` vs mockup `#contact` — mandate carry-forward); injected blocks 2–7 + testimonials×4 otherwise meet content bar |
| Cluster close | **BLOCKED** — team_10: route `/en` to `tpl-en-landing` + deploy |

---

## §1 Gate chain

team_50 PASS reproduced for axe/LH/asset-200/H1/console on `/en/`. team_50 did **not** score AC-F2 full 8-block mockup parity or AC-F3 LTR mirror checklist (lang pill, `<main>` dir/lang). This validator exercised those items — **FAIL**.

---

## §2 Blocking finding (P0)

### T190-W2-10-F-P0-01 — Elevated EN shell (blocks 1 + 8) not deployed; AC-F3 mirror incomplete

| Requirement (mandate / LOD400 §4) | Staging `/en/` | Result |
|-----------------------------------|----------------|--------|
| `tpl-en-landing.php` active | `body` has `page-template-default` (GP default page) | **FAIL** |
| EN topnav + **language pill** → Hebrew `/` | No `a.ea-lang-pill`; GP Hebrew primary nav wraps page | **FAIL** |
| `dir="ltr" lang="en"` on **`<html>` + `<main>`** | `html`: ltr/en ✓ · `<main class="site-main">`: **no** `dir`/`lang` | **FAIL** (main) |
| EN footer-social (block 8) | GP site footer; no elevated `ea-footer` from tpl | **FAIL** |
| Blocks 2–7 elevated content | Injected via `ea_w2_08_render()` ✓ | **PASS** |
| Testimonials ×4 | `.ea-en-testimonial` count **4** | **PASS** |
| EN copy (hero kicker sample) | “The Center for Breath Therapy · Pardes Hanna, Israel” matches mockup/W2-08 | **PASS** |

**Root cause (repo):** `page-templates/tpl-en-landing.php` exists with correct EN chrome (`ea-lang-pill`, `<main lang="en" dir="ltr">`), but there is **no** `template_include` router for slug `en` (unlike A/B/E via W2-04/05/07). Staging page ID 25 uses default template; only `the_content` injection runs.

**Remediation:**

1. Add `template_include` (priority ≥100) mapping slug `en` → `tpl-en-landing.php` (mirror `ea_w2_04_template_include`), **or** set `_wp_page_template` → `page-templates/tpl-en-landing.php` on the `/en` page + redeploy.
2. Re-smoke: `ea-lang-pill` href → `/`, `<main>` has `dir=ltr lang=en`, body **not** `page-template-default`.
3. Re-gate: team_50 → team_190.

---

## §3 Acceptance criteria matrix

| AC | Verdict | Evidence |
|----|---------|----------|
| AC-F2 | **FAIL** | Blocks 2–7 present; blocks **1** (EN topnav) and **8** (EN footer) missing on staging vs `en-landing.html` |
| AC-F3 | **FAIL** | P0-01: no lang pill; `<main>` attrs missing; GP Hebrew nav on LTR page |
| AC-F-copy | **PASS** (content subset) | Injected EN strings match elevation mockup / `ea_w2_08_render()` |
| AC-A3 equiv. | **PASS** | team_80 PASS; `w2-08-en-landing.css` has **0** physical left/right declarations |
| AC-F4 | **PASS** | axe `/en/` crit=0 serious=0 |
| AC-F5 | **PASS** | Mobile ×3 median perf **89**, a11y **100** |
| AC-F7 | **PASS** | HTTP 200; H1=1; 0 console errors; 3 cover assets `ea-eyalamit` HTTP 200 |

**Note:** `w2-08-en-landing.css` cluster scope uses logical props; GP wrapper `.inside-article` padding is theme chrome outside the EN composition — not scored as cluster CSS violation once tpl shell is active.

---

## §4 What passed (for re-validate scope)

| Check | Result |
|-------|--------|
| axe 0/0 | **PASS** |
| asset-smoke | **PASS** |
| Mobile LH ≥85 / a11y 100 | **PASS** (median **89**) |
| Testimonials ×4 | **PASS** |
| `html dir=ltr lang=en` | **PASS** |
| hreflang en/he/x-default | **PASS** (curl) |

---

## §5 Validator reproduction

```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/scripts/qa"
node http-qa-axe.cjs /en/
node wp-w2-10-asset-smoke.cjs /en/
# Mobile LH ×3: reports/lh-mobile-t190-w2-10-f_en_run{1,2,3}.json
curl -s "http://eyalamit-co-il-2026.s887.upress.link/en/" | grep -E 'page-template|ea-lang-pill|main id'
```

Observed: `page-template-default` · no `ea-lang-pill` · `<main class="site-main" id="main">` without `dir`/`lang`.

---

## §6 Routing

| Verdict | Route |
|---------|-------|
| **FAIL** | **team_10** — wire `tpl-en-landing` on `/en` (router or page meta) + FTP deploy |
| Re-gate | team_50 L-GATE_BUILD → team_190 re-validate F only |
| WP-W2-10 roll-up | **BLOCKED** until F passes (A/B/E rev2/rev1 PASS in same batch) |

---

*Issued by team_190 · L-GATE_VALIDATE · WP-W2-10-F · 2026-06-03 · Cursor Composer cross-engine.*
