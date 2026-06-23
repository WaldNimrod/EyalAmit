---
id: GAP-ANALYSIS_CHAPTERS-FULLSITE-MANDATE-COVERAGE_2026-06-23
from_team: team_110 (Remediation + validation orchestration)
to_team: team_00, team_100, team_50, team_190
date: 2026-06-23
repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home)
staging: http://eyalamit-co-il-2026.s887.upress.link
references:
  - _COMMUNICATION/team_100/MANDATE-TEAM50-CHAPTERS-FULLSITE-VALIDATE-2026-06-22.md
  - _COMMUNICATION/team_100/MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22.md
  - _COMMUNICATION/team_100/CLOSEOUT_CHAPTERS-FULLSITE_POSTFIX_DEPLOY_E2E_2026-06-23.md
status: ISSUED
---

# Gap analysis — Chapters full-site mandate coverage (2026-06-23)

## Purpose

Map **what the original full-site mandate required** vs **what was implemented** in each validation wave, and what **still requires independent validator completion** before constitutional PASS and “ready for Eyal”.

---

## §1 Mandate acceptance criteria (source of truth)

From [`MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22.md`](../team_100/MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22.md) — all six axes:

| # | Criterion | Bar |
|---|-----------|-----|
| **1** | Content accuracy | 17 gated pages @ 100% sectionCov + sentenceCov vs Eyal source, minus ledger only; eyeball ≥3 pages |
| **2** | a11y | axe 0 critical / 0 serious **every route** (26 mandate + blog singles) |
| **3** | Layout (CDP) | qa_probe 0 overflow @ 7 breakpoints **every route** |
| **4** | Structure/SEO | 1 h1; correct dir; Yoast @graph; per-route meta; single og:image; canonical; one-hop 301s |
| **5** | Design fidelity | Browser screenshots + mockup comparison; no broken CSS/images/RTL; book covers + Mokesh media; `/en/` LTR |
| **6** | Function | CF7 + WhatsApp `generate_lead`; blog pagination; per-post meta/og |

---

## §2 Coverage matrix

| Criterion | team_50 (2026-06-22) | team_190 (2026-06-22) | team_100 post-deploy (2026-06-23) | Status |
|-----------|----------------------|----------------------|-----------------------------------|--------|
| **1 Content** — full `content-diff` 17 pages | ✅ Independent full run | ✅ Independent full run | ✅ Full re-run PASS 99.6% | **COVERED** — team_190 should **re-affirm** post-deploy (no body change in fix) |
| **1 Content** — eyeball ≥3 vs source | ✅ 4 pages | ✅ 3+ pages + screenshots | ❌ Not re-run | **GAP** — team_190 spot re-eyeball OR cite prior evidence if unchanged |
| **2 axe** — all mandate routes | ✅ 27 routes | ✅ 26 routes | ⚠️ **5 routes only** (F110-01 subset) | **PARTIAL** — post-deploy regression is sample; full-route axe **not** re-run |
| **3 qa_probe** — 7 breakpoints × all routes | ✅ 27×7 (189) | ✅ 26×7 (182) | ✅ 25×7 (182) PASS | **COVERED** post-deploy for config pages; blog singles not in config |
| **4 h1 + dir** — all mandate routes | ✅ 26/26 | ✅ 26/26 | ⚠️ **5 routes only** | **PARTIAL** post-deploy |
| **4 SEO head** — per-route meta | ⚠️ F110-01 finding | ⚠️ F-01 open | ✅ F110-01 routes fixed live | **team_190 must close F110-01 independently** |
| **4 SEO** — 301 one-hop | ✅ | ✅ | ❌ Not re-run post-deploy | **Re-affirm** (head-only deploy; low risk) |
| **4 SEO** — blog pagination + single-post meta | ✅ | ✅ | ❌ Not re-run | **Re-affirm** or spot-check |
| **5 Design** — mockup comparison | ✅ notes + screenshots | ✅ manual PASS | ❌ Not re-run | **GAP** — no post-deploy visual regression |
| **5 Media** — covers, Mokesh photos, broken images | ✅ eyeball | ✅ eyeball | ❌ Not re-run | **GAP** — validators should spot-check key pages |
| **6 Function** — CF7 / WhatsApp / blog | ✅ probes | ✅ probes | ❌ Not re-run | **GAP** — recommend team_190 function spot re-probe |
| **Lighthouse** | Partial | Representative | ✅ 7 routes recorded | **OK** for staging continuity |

---

## §3 What team_100 post-deploy actually validated

Scope was **regression guard after head-only deploy** (`wave2-w2-09.php`), not a repeat of the full constitutional mandate.

| Gate | Scope | Evidence |
|------|-------|----------|
| SEO head (F110-01) | 3 routes | `team_100/evidence/chapters-postdeploy-2026-06-23/seo/` |
| content-diff | **All 17 gated pages** | `…/content/summary.json` |
| axe | 5 routes | `…/axe/` |
| h1 + dir | 5 routes | `…/h1-rtl/` |
| qa_probe | 25 pages × 7 viewports | `…/qa_probe/` |
| Lighthouse | 7 representative routes | `…/lighthouse/` |

**Not in post-deploy scope:** design/mockup diff, media inventory, function probes, full-route axe/h1, 301 redirects, blog singles.

---

## §4 Findings closure state

| ID | Issue | team_110 fix | Live status (post-deploy) | Validator action |
|----|-------|--------------|----------------------------|------------------|
| **F110-01** | Missing `meta description` on 3 routes | `wave2-w2-09.php` deployed | team_100: `metaDescriptionCount: 1` all 3 | **team_190 independent probe → CLOSE** |
| **F110-02** | Retired brand on blog archive | mu-plugin (prior) | CLOSED | Re-affirm only |
| **F110-03** | Blog permalink 404 | transient; no code | CLOSED 24/24 | Re-affirm only |

---

## §5 Recommended validator split

### team_190 — constitutional post-deploy closure (required now)

1. Independent F110-01 live head probe (3 routes).
2. Update [`VERDICT_CHAPTERS-FULLSITE_2026-06-22.md`](../team_190/VERDICT_CHAPTERS-FULLSITE_2026-06-22.md) → addendum or superseding verdict **2026-06-23**.
3. **Delta re-affirmation:** cite team_100 post-deploy evidence where sufficient; independently re-run gaps in §6 where not.

### team_50 — optional delta (only if team_190 finds regression)

Not required if team_190 PASS on post-deploy addendum. Re-activate if design/media/function gaps fail.

---

## §6 Minimum additional probes for constitutional PASS (team_190)

| Priority | Probe | Routes / method | Why |
|----------|-------|-----------------|-----|
| **P0** | SEO head F110-01 | 3 routes — `seo-head-probe.mjs` | Blocking finding closure |
| **P1** | axe full mandate set | 26 routes — `http-qa-axe.cjs` | Post-deploy only sampled 5 |
| **P1** | h1 + dir full set | 26 routes — `h1-rtl-http-probe.cjs` | Post-deploy only sampled 5 |
| **P2** | Function | contact WhatsApp + CF7; blog page 2 ≠ page 1 | Mandate §6; not re-run post-deploy |
| **P2** | 301 one-hop | `/muzza/`, `/about/moksha/`, `/mokesh/` | Mandate §4 |
| **P2** | Design + media eyeball | `/books/`, `/books/vekatavta/`, `/eyal-amit/mokesh-dahiman/`, `/en/` + mockup compare | Mandate §5 |
| **P3** | Content eyeball | ≥3 pages live vs source `.md` | Mandate §1 — can cite 2026-06-22 if body unchanged |

---

## §7 Verdict path

| Condition | Overall status |
|-----------|----------------|
| F110-01 closed live + no new regressions on P1 probes | **PASS** (upgrade from PASS_WITH_FINDINGS) |
| F110-01 closed + P1 pass + P2 gaps documented as re-affirmed from 2026-06-22 | **PASS** with addendum |
| Any P1 failure post-deploy | **BLOCK** → team_110 fix round |

---

*team_110 — 2026-06-23 — mandate coverage gap analysis for validator routing.*
