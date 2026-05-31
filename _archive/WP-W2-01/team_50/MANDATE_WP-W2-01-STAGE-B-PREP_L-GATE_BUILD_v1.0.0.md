---
id: MANDATE_WP-W2-01-STAGE-B-PREP_L-GATE_BUILD_v1.0.0
from: Team 10 (Gateway / Orchestrator)
to: Team 50 (QA & Functional Acceptance)
date: 2026-05-26
type: QA_MANDATE
gate: L-GATE_BUILD
wp: WP-W2-01-STAGE-B-PREP
project: eyalamit
status: ACTIVE
verdict: PENDING
engine_constraint: "builder=claude-code (team_10), validator=cursor-composer (team_50) — engines must differ per Iron Rule #1"
resubmission_round: 1
---

# L-GATE_BUILD Mandate — WP-W2-01-STAGE-B-PREP

**Wave2 Stage B — Infrastructure Prep (Parallel Track)**
**Track:** L (Lean) | **Profile:** L0 | **Risk:** LOW

---

## 1. Context

While team_100 executes Stage A (LOD400 Design System spec + POC), team_10 ran 7 parallel infrastructure prep tasks that do not depend on the LOD400 spec. All 7 tasks are now complete. This mandate requests QA validation of the deliverables produced by sub-teams 20, 30, and 60.

**Execution mode:** Mode A (Orchestrator) — team_10 issued mandates to sub-teams; sub-teams produced deliverables.

---

## 2. Prior Gate History

| Gate | Result | Date | Validator | Notes |
|------|--------|------|-----------|-------|
| WP authorized | APPROVED | 2026-05-26 | team_00 | Combo C + Stage B parallel track approved |
| L-GATE_BUILD | PENDING | 2026-05-26 | team_50 | This mandate |

---

## 3. Scope

This L-GATE_BUILD (QA) validates functional acceptance of 7 infrastructure prep tasks:

| ID | Task | Executed By |
|----|------|-------------|
| B-PREP-1 | CF7 + WP Mail SMTP plugins installed on staging | team_20 |
| B-PREP-2 | Google Workspace MX records verified for eyalamit.co.il | team_20 |
| B-PREP-3 | GA4 + Clarity analytics config scaffolded | team_30 |
| B-PREP-4 | Staging environment health check | team_60 |
| B-PREP-5 | MEDIA-IN-USE inventory JSON produced | team_20 |
| B-PREP-6 | FTPS access verified (uPress staging) | team_60 |
| B-PREP-7 | Child theme ea-eyalamit fully audited | team_30 |

**Out of scope:** CSS/blocks/template implementation (awaiting LOD400 from team_100). SMTP credentials, GA4 IDs, Clarity IDs (human-gate items Eyal completes separately).

---

## 4. Validation Criteria

| # | Criterion | What to Check |
|---|-----------|---------------|
| VC-1 | CF7 installed and active | `GET /wp-json/wp/v2/plugins` — find `contact-form-7` with `status: active`. Verify version documented in `PLUGINS-INSTALLED-2026-05-26.md`. |
| VC-2 | WP Mail SMTP installed and active | Same endpoint — find `wp-mail-smtp` with `status: active`. Version documented. |
| VC-3 | Google MX records correct | `dig MX eyalamit.co.il +short` — verify Google MX servers present. Matches `MX-VERIFY-2026-05-26.md` verdict. |
| VC-4 | Analytics config JSON valid | `hub/data/analytics-config.json` exists, is valid JSON, contains `ga4.measurement_id`, `clarity.project_id`, `status: PENDING_CREDENTIALS`. |
| VC-5 | Staging HTTP 200 | `curl -o /dev/null -s -w "%{http_code}" http://eyalamit-co-il-2026.s887.upress.link` returns 200. |
| VC-6 | Active theme is ea-eyalamit | `GET /wp-json/wp/v2/themes?status=active` — `stylesheet: ea-eyalamit` present. |
| VC-7 | functions.php syntax clean | `php -l site/wp-content/themes/ea-eyalamit/functions.php` — no errors. |
| VC-8 | Media inventory JSON valid | `_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-2026-05-26.json` is valid JSON with `items` array, ≥1 entry, each with `id`, `url`, `filename`, `mime_type`, `post_id`, `status`. |
| VC-9 | FTPS access confirmed | `_COMMUNICATION/team_60/FTPS-VERIFY-2026-05-26.md` shows Overall Verdict: PASS with connect/upload/delete all succeeding. |
| VC-10 | Child theme audit complete | `_COMMUNICATION/team_30/CHILD-THEME-AUDIT-2026-05-26.md` exists, covers all theme files, has keep/refresh/delete verdicts with rationale for each. Summary counts present. |
| VC-11 | Eyal instructions complete | `_COMMUNICATION/team_20/MX-VERIFY-2026-05-26.md` contains SMTP App Password instructions for Eyal. `_COMMUNICATION/team_30/ANALYTICS-CONFIG-PREP-2026-05-26.md` contains GA4 + Clarity setup steps. |

Total: 11 criteria

---

## 5. Files to Review

### Mandate Files (team_10 — orchestration)
- `_COMMUNICATION/team_10/MANDATE-TEAM20-B-PREP-2026-05-26.md`
- `_COMMUNICATION/team_10/MANDATE-TEAM30-B-PREP-2026-05-26.md`
- `_COMMUNICATION/team_10/MANDATE-TEAM60-B-PREP-2026-05-26.md`
- `_COMMUNICATION/team_10/B-PREP-PROGRESS-REPORT-2026-05-26.md`

### Team 20 Deliverables (B-PREP-1, 2, 5)
- `_COMMUNICATION/team_20/PLUGINS-INSTALLED-2026-05-26.md`
- `_COMMUNICATION/team_20/MX-VERIFY-2026-05-26.md`
- `_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-2026-05-26.json`
- `_COMMUNICATION/team_20/B-PREP-COMPLETION-TEAM20-2026-05-26.md`

### Team 30 Deliverables (B-PREP-3, 7)
- `_COMMUNICATION/team_30/ANALYTICS-CONFIG-PREP-2026-05-26.md`
- `_COMMUNICATION/team_30/CHILD-THEME-AUDIT-2026-05-26.md`
- `_COMMUNICATION/team_30/B-PREP-COMPLETION-TEAM30-2026-05-26.md`
- `hub/data/analytics-config.json`

### Team 60 Deliverables (B-PREP-4, 6)
- `_COMMUNICATION/team_60/STAGING-HEALTH-CHECK-2026-05-26.md`
- `_COMMUNICATION/team_60/FTPS-VERIFY-2026-05-26.md`
- `_COMMUNICATION/team_60/B-PREP-COMPLETION-TEAM60-2026-05-26.md`

### Live Environment (re-verify independently)
- Staging URL: `http://eyalamit-co-il-2026.s887.upress.link`
- WP REST API: `http://eyalamit-co-il-2026.s887.upress.link/wp-json/`
- WP admin: `http://eyalamit-co-il-2026.s887.upress.link/wp-admin`
- Child theme: `site/wp-content/themes/ea-eyalamit/`

---

## 6. Resolved Findings

*First submission — no prior findings.*

---

## 7. Output

Write verdict to: `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-PREP_L-GATE_BUILD_v1.0.0.md`

Use the unified verdict template (7 sections):
1. Verdict Summary (PASS / BLOCK / PASS_WITH_FINDINGS)
2. Parameters
3. Criteria Table (VC-1 through VC-11, each PASS/FAIL/SKIP with evidence)
4. Findings (any FAIL — cite file:line)
5. validate_aos.sh output
6. Disposition
7. Next Step

### Constraints
- **Cross-engine:** builder=claude-code (team_10), validator=cursor-composer (team_50) — engines must differ (Iron Rule #1)
- **Independence:** do NOT read team_10's progress report conclusions before forming your own verdict on each VC
- **Evidence:** every FAIL must cite file path and specific line or content
- **Human gates:** VC items requiring Eyal input (SMTP, GA4, Clarity IDs) — verify the *instructions* are complete and the *scaffold* is correct; do not mark FAIL solely because Eyal hasn't entered credentials yet

---

*Issued by team_10 · WP-W2-01-STAGE-B-PREP · L-GATE_BUILD · Round 1 · 2026-05-26*
