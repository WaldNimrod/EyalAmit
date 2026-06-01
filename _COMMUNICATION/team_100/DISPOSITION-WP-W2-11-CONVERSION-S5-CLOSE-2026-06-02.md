---
id: DISPOSITION-WP-W2-11-CONVERSION-S5-CLOSE-2026-06-02
from_team: team_100 (Chief System Architect)
to_team: team_00 (decision record) / team_50 / team_190 / team_10 / team_80
date: 2026-06-02
wp: WP-W2-11 (S003 Base Implementation — Hybrid Track-1)
cluster: Conversion (C) — /contact, /faq
stage: S5 close (L-GATE_BUILD + L-GATE_VALIDATE adjudication)
branch: feature/s003-base-implementation-prep
decision_authority: team_00 (2026-06-02)
verdict: CLUSTER CLOSED — AC-04 accepted as staging-capped (conditional)
---

# DISPOSITION — WP-W2-11 Conversion · S5 close & gate adjudication

team_100 adjudication of the two external S5 verdicts, with the team_00 decision recorded.

## 1. The two external verdicts (as received)
- **team_50 (L-GATE_BUILD)** → `_COMMUNICATION/team_50/QA-VERDICT-WP-W2-11-CONVERSION-L-GATE-BUILD-2026-06-02.md`:
  **FAIL**. axe 0 crit/serious (AC-03 PASS), a11y 100, HTTP 200 (AC-07 PASS), but **AC-04 mobile perf median 83 < 85** on both routes. Cited drag: server-response-time ~760–790ms, LCP ~3.5s.
- **team_190 (L-GATE_VALIDATE)** → `_COMMUNICATION/team_190/VERDICT-WP-W2-11-CONVERSION-L-GATE-VALIDATE-2026-06-02.md`:
  **PASS** (8/8). But it evaluated AC-04 on **desktop** perf (96–97), ran **before** a passing build-gate, and self-noted W01 (could not locate the team_50 verdict) + W02 (run by Cursor Composer, not the mandated Codex).

## 2. team_100 root-cause analysis (decisive)
The mobile-perf failure is a **staging test-methodology artifact, not a defect**:
- The QA harness (`scripts/qa/http-qa-lighthouse.sh`, `BASE` hardcoded `http://…`) measures the **http://** URL.
  WordPress on this staging host **301-redirects http→https**. Lighthouse follows it (cert errors ignored),
  paying a **630ms redirect penalty** the redirects audit attributes verbatim:
  `http://…/contact/ → https://…/contact/ (wasted 630ms)`.
- That redirect **does not exist in production** (https-native, valid cert — you request https directly).
- Direct HTTP check: `/contact/` (trailing slash) returns **200 with zero redirects**; the only redirect is the http→https upgrade Lighthouse incurs from the http start URL.

**team_100 diagnostic re-measure (production-representative, https mobile, same staging TTFB):**
| Route | mobile perf (https) | LCP | redirects |
|-------|--------------------|-----|-----------|
| `/contact/` | **94** | 2.4s | none |
| `/faq/` | **98** | 1.9s | none |
Evidence in-repo: `scripts/qa/reports/lh-mobile-https-{contact,faq}-team100-diag-2026-06-02.json`.

Both clear the ≥85 bar comfortably once the http→https redirect (a production non-issue) is removed.
The residual ~790ms TTFB is uPress staging-tier latency, also expected to improve at production cutover.

## 3. Adjudication of the verdicts
- **team_50 FAIL** — *correct as run*, but the failing metric is a staging artifact (http→https redirect), not template/composition. No team_10 perf remediation is warranted: the code already performs at 94/98 mobile on https.
- **team_190 PASS** — *conclusion accepted, basis flawed*: it ran out of sequence, measured the wrong axis (desktop, not mobile triple-run median), and the build-gate verdict did exist (team_50 00:41 < team_190 00:43 — a sequencing/path miss, W01). Recorded, not relied upon for AC-04.

## 4. team_00 DECISION (2026-06-02)
**Accept AC-04 as staging-capped (conditional)** — same treatment as SEO/BP per the LOD400 spec ("SEO/BP staging-capped → 100 at cutover"). The https evidence (94/98) is recorded as proof the bar is met production-representatively; the **formal mobile-perf gate is deferred to a production-cutover re-measure**.

## 5. AC roll-up (Conversion cluster)
| AC | State | Basis |
|----|-------|-------|
| AC-01 composition vs C mockups | PASS | team_190; GCR CSS live (sticky filter, intro/title) |
| AC-02 zero D-14 drift | PASS | team_80 TOKEN-COMPLIANCE PASS (ee46703) |
| AC-03 axe 0 crit/serious | PASS | team_50 + team_190 |
| AC-04 LH a11y/perf | **CONDITIONAL** | a11y 100 PASS; mobile perf **staging-capped** (https 94/98 ≥85; formal re-measure at cutover) |
| AC-05 graceful gaps | PASS | CF7 placeholder + FAQ guard, 0 console errors |
| AC-06 repo gates | PASS | validate_aos 0 FAIL; final_pre_cutover_check exit 0; php -l clean |
| AC-07 live HTTP 200 | PASS | both routes |

**Conversion cluster: CLOSED** (AC-04 conditional/staging-capped per team_00).

## 6. Carry-forwards (tracked, non-blocking)
1. **CUTOVER-PERF-REMEASURE** — at production cutover, re-run mobile Lighthouse triple-run over **https** on `/contact` + `/faq`; confirm median ≥85 (expected ~94/98). Bundle with the SEO/BP →100 cutover re-measure.
2. **QA-TOOLING-FIX** — `scripts/qa/http-qa-lighthouse.sh` should measure **perf on https** (production-representative) while keeping axe/a11y over http, to avoid the http→https redirect artifact penalizing every future cluster. Recommend before Blog (D) S5. (axe over http is unaffected — AC-03 stands.)
3. **GATE-ORDER DISCIPLINE** — L-GATE_VALIDATE (team_190) must not run until L-GATE_BUILD (team_50) PASSES; team_190 must evaluate AC-04 on the **mobile triple-run median** axis and confirm the build verdict file is present. Re-affirm in the Blog mandate.
4. **ENGINE NOTE (W02)** — this validate ran on Cursor Composer, not the mandated Codex. Cross-engine independence (IR#1: builder team_10 ≠ validator) was preserved either way, but route the Blog L-GATE_VALIDATE to Codex per mandate, or update the mandate to the actual validator engine.

## 7. Next
- WP-W2-11 remains **IN_PROGRESS**; sequence per plan: **Blog (D) → Home refine**.
- No `main` merge / push without explicit team_00 go (ADR034 offline-fallback).
