---
gate: CR-FINAL_FULL-SITE-CONTENT-ACCURACY (re-run) + ADMIN-INTERFACE-VERIFICATION
wp: WP-W2-15-CR-FINAL
to: team_90
from: team_100
engine_builder: claude-code
date: 2026-07-02
priority: HIGH
status: OPEN
depends_on: CR1-4 merged to main (dual-PASS team_50+team_190); CR-FINAL leg 1 (team_90) PASS 2026-06-05; WP-W2-16 series (post-content completion) now IN_PROGRESS; page-review.html / image-picker.html / media-gallery pipeline built 2026-07-01/02
canonical_handoff: generated via /AOS_mail handoff (type=handoff&mode=handoff), team_id=team_90, project_id=eyalamit, wp_id=WP-W2-15-CR-FINAL, at 2026-07-02T20:06:46.782736Z — see Appendix A
---

# MANDATE — team_90 full-site re-audit: content + images + cross-browser/screen-size + admin-interface functional verification

## Why

- CR-FINAL leg 1 (team_90) **PASSED 2026-06-05**: 16/16 in-scope sourced pages ≥ gate (96.51% simple / 98.21% weighted accuracy), up from the 2026-06-04 baseline of 0/17 (33.64%). Report: `_COMMUNICATION/team_90/CONTENT-ACCURACY-REPORT-CR-FINAL-2026-06-05.md`. Prior mandate for reference: `_COMMUNICATION/team_90/MANDATE_WP-W2-15-CR-FINAL_FULL-AUDIT_v1.0.0.md`.
- Legs 2 (team_190 full-site L-GATE_VALIDATE) and 3 (team_50 E2E) were **PENDING** as of that report (§7). **HARD RULE remains: no "ready" message to Eyal until all three legs triple-PASS.** Confirm the CURRENT status of legs 2/3 as part of this mandate's context-gathering — do not assume either completed since 06-05.
- Since 2026-06-05, substantial additional work has landed on `main`: the WP-W2-16 series (hero video, testimonials carousel, FAQ TOC, nav/IA polish, Mokesh memorial content, verification & re-publish — ALL still `IN_PROGRESS` per `_aos/roadmap.yaml`), WP-W2-15-D (5 previously-unbuilt pages), and WP-W2-15-G (legacy/SEO completeness, also `IN_PROGRESS`). The site has changed meaningfully since the last team_90 pass — a fresh full re-audit is due, not a rubber-stamp of the 06-05 result.
- Per team_90's own governing Iron Rule — **"never repeat prior findings without fresh re-execution"** — this mandate requires a genuine new run, not a restatement of the 06-05 numbers.
- Scope is **expanding** beyond the original CONTENT-ACCURACY (text-only) methodology. Team 00 additionally requires: (a) missing/incorrect-**image** verification (not just text), (b) real **cross-browser + multi-screen-size** verification (HTTP-only checks are explicitly insufficient per this project's own Browser-QA Discipline, CLAUDE.md), and (c) functional verification that every Eyal-facing **admin/content-management interface** actually does what it claims — several of these (image-picker, page-review) were only built/restored in the last 48 hours and have not been through any formal gate.

## Scope

- **Surface 1 — live dev/staging site:** `http://eyalamit-co-il-2026.s887.upress.link` (branch `main`). **HTTP only** — staging TLS is invalid by design (CLAUDE.md Dev/Staging TLS discipline); a cert error on staging is expected and is NOT a defect to report.
- **Surface 2 — the Eyal client hub's admin interfaces:** `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/` (see Task 4 for the exact interface list).
- **Content source of truth:** `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/` (`INDEX-CONTENT-2026-05-25.md` + per-page source docs) — same SSoT as the 06-04/06-05 audits. Do not re-litigate content that source doesn't cover.
- **Image source of truth:** DOK-WEB media set (`docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/DOK-WEB/` — 582 images + catalogs) + legacy curated set (`_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/` — 315 images) + `hub/data/site-tree.json` (40-node IA; `pageMockupHref` / `productHref` fields) for expected page↔asset mapping.

## Tasks

### 1 — Full CONTENT-ACCURACY re-run (methodology unchanged from CR-FINAL)

Re-run:
```bash
node scripts/qa/content-diff.mjs \
  --base http://eyalamit-co-il-2026.s887.upress.link \
  --out _COMMUNICATION/team_90/evidence/content-accuracy-cr-final-2026-07-02
```
over the full PAGE_MAP. Report per-page section% / sentence% / accuracy%, overall simple + weighted average, and gate pass/fail (≥95% section · ≥90% sentence · 0 invented sections). **Diff explicitly against the 06-05 baseline** — any page that was PASS on 06-05 and is not now is a P0 finding (regression), not a routine miss.

### 2 — NEW: missing/incorrect-image audit (per page)

For every in-scope sourced page, verify:
- Every image the source material specifies or implies is actually present and rendering on the live page (not a broken `<img>`, not a placeholder/stock substitute standing in for real content).
- No page is silently missing an expected hero/gallery image.
- Cross-check against `hub/data/site-tree.json`'s `productHref` / `pageMockupHref` fields and, if present, the picker's `_COMMUNICATION/team_110/build/enrichment/slot-candidates.json` for which image was actually *selected* per page slot — confirm the live page matches that selection, not a stale/default one.

Use real browser checks (`img.complete && img.naturalWidth === 0` = broken) — **do not rely on HTTP 200 alone**; a 200 response can still be the wrong image or a truncated file. Report per-page: images-expected vs. images-present vs. images-broken, with URLs.

### 3 — NEW: cross-browser + screen-size verification (real browser, not curl)

Per CLAUDE.md's Browser-QA Discipline: *"Never use curl alone to validate layout."* Use `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` (or equivalent real-browser tooling) across the breakpoints already established in this project's own QA convention (`docs/qa/*/qa_probe_result.json` — 360/390/414/768/1440) for every in-scope page:
- Zero horizontal overflow (`scrollWidth` vs `clientWidth`).
- Non-empty, correct `<title>`.
- No forbidden/placeholder strings in the rendered DOM (including `alt`/`aria` text) — TBD, lorem, מוקאפ, etc.
- Screenshot evidence for at least mobile + desktop per page.

Additionally spot-check actual cross-browser rendering if a second engine is available (Chrome headless is this project's standard QA tool); if only one browser engine is available, state that limitation explicitly rather than silently skipping cross-browser coverage.

### 4 — NEW: functional verification of every Eyal-facing admin/content-management interface

For **each** of the following (served from the Eyal client hub, built from `hub/dist/`), verify it genuinely allows correct management of the **current** live page content — not just that it loads:

| Interface | What to verify |
|---|---|
| `content-intake.html` | Lists the real current site-tree pages; a submitted entry is exportable/usable. |
| `media-intake.html` | Fields match actual current media needs (`hub/data/media-inventory.json`). |
| `materials-intake.html` | Items match `hub/data/materials-needed.json` current state. |
| `image-picker.html` | Candidate images actually load (legacy + DOK-WEB); slots match `hub/data/site-tree.json`'s real page list; JSON export produces valid, usable output. (Restored + re-wired into the hub build 2026-07-01/02 — has not been through any formal gate yet.) |
| `page-review.html` | All ~40 site-tree nodes have a working section; notes/media-ID fields persist (localStorage) and export correctly; flagged questions/gaps in `hub/data/page-review.json` are current, not stale. (New, built 2026-07-01.) |
| `meeting-checklist.html`, `tasks.html`, `site-tree.html` | Each still accurately reflects current decisions/tasks/IA — not a stale copy from an earlier hub version. |

For each interface: does it save state correctly, does exported JSON validate/round-trip, does it reference real (not broken or stale) data. Report per-interface **PASS/FAIL** with the specific defect if FAIL.

### 5 — Gate-tool health check

Confirm `scripts/qa/content-diff.mjs` (which team_90 owns per §4 of the 06-05 report) still runs clean against the current codebase with no unratified changes since the last ratification (7 change groups, all RATIFY, per the 06-05 report §4). If the script needed modification to run against the current site, that modification is itself a finding to report (methodology drift), not something to silently fix and move past.

## Out of scope

- **CR5** (`/mokesh-dahiman` or its current slug, `/galleries`, `/media`) — confirmed BLOCKED on Eyal per WP-W2-15-F / WP-W2-15-CR5 (`_aos/roadmap.yaml`). Re-verify these are **still** blocked (not silently resolved) but do not count them in the pass/fail rollup, consistent with the 06-05 precedent (§6 of that report).
- Production domain (`eyalamit.co.il`) — this mandate is staging-only; production Lighthouse/SEO scores are explicitly out of scope per CLAUDE.md TLS discipline (re-measure only at cutover).
- Fixing any defect found — team_90 does not implement; route findings back to team_10 (build) via team_100.

## Deliverable

`CONTENT-ACCURACY-REPORT-CR-FINAL-2026-07-02.md` (or dated equivalent) in `_COMMUNICATION/team_90/`, following the §0 verdict-box format established in the 06-05 report, **plus** the two new sections (images; cross-browser/screen-size) and the admin-interface verification table. Refreshed evidence under `_COMMUNICATION/team_90/evidence/` — **commit it this time**: the 06-05 report itself flagged that team_90 left its evidence uncommitted previously (§6 of the completion program); do not repeat that gap.

State a clear **"team_90 leg: PASS / PASS WITH FINDINGS / FAIL"** line, and explicitly restate the current status of the other two CR-FINAL legs (team_190, team_50) so team_100 knows exactly what remains before any "ready" message to Eyal. Route to team_100.

---

# Appendix A — Canonical AOS Handoff Activation (verbatim)

*Generated via `/AOS_mail handoff` → `GET /api/prompts/generate?type=handoff&mode=handoff&team_id=team_90&project_id=eyalamit&wp_id=WP-W2-15-CR-FINAL` at `2026-07-02T20:06:46.782736Z`. Embedded verbatim per the canonical handoff mechanism (ADR043 §A.4c) — this is the real, live-generated identity/governance/environment activation block, not a paraphrase.*

*(Note: the API's live WP lookup returned "work package details unavailable" for `WP-W2-15-CR-FINAL` — this WP exists in the file-canonical `_aos/roadmap.yaml` snapshot but was never registered in the DB, per the roadmap's own 2026-05-31 note: "file roadmap.yaml remains live SSoT" for the Wave2 WP set. The file-based WP context is supplied above in `## Why`.)*

# Session Handoff — team_90 | Full-site content+image+cross-browser re-audit (CR-FINAL leg re-run) + functional verification of every Eyal-facing admin/content-management interface

## 1. SESSION ACCOMPLISHED
*(No accomplishments recorded — session handoff for context only.)*

## 2. IDENTITY SNAPSHOT
## Team Identity
- **Team ID:** team_90
- **Label:** Team 90
- **Engine:** cursor-composer-2
- **Group:** governance
- **Profession:** dev_validator
- **Domain scope:** universal

### Role Description
Default + Constitutional validator (the prior senior constitutional validator collapsed into team_90 per WP M9-P1-WP7 — the senior/constitutional tier is now a PARAMETER selected per gate, ADR053, not a separate team). Owns the GOVERNANCE facet of every L-gate: L-GATE_ELIGIBILITY, L-GATE_SPEC, L-GATE_BUILD, and L-GATE_VALIDATE (the governance half of the DUAL final gate — team_50 owns the functional half). Multi-project scope. ADVERSARIAL stance — never repeat prior findings without fresh re-execution; do NOT start from the implementation team's self-assessment. Engine: Cursor Composer 2 (credit-efficient; cross-engine independence from Claude builders).

## 3. CONTEXT SNAPSHOT
## Work Package — WP-W2-15-CR-FINAL
*(work package details unavailable via live API lookup — see file-canonical context in `## Why` above)*

## 4. MANDATORY READS
- `_aos/governance/team_90.md`
- `_aos/roadmap.yaml`
- `methodology/AOS_IDENTITY_ONBOARDING_v1.0.0.md` (first AOS session only)

## 5. BLOCKERS / OPEN ITEMS
*(None recorded by the API — see this mandate's own `## Why` for the real open items: CR-FINAL legs 2/3 status unconfirmed, CR5 Eyal-blocked.)*

## 6. ACTIVATION PROMPT
```
HANDOFF_DEPTH: full
ACTIVATION_SCOPE: team_90 only

# Handoff — team_90 / eyalamit

*Generated 2026-07-02T20:06:46.782736Z  ·  Depth: full*

## Activation TL;DR
- **Identity:** team_90 · engine: cursor-composer-2 · role: Team 90
- **Domain:** eyalamit · profile: L0
- **Assignment:** WP=WP-W2-15-CR-FINAL —  · gate=—
- **Task:** See _COMMUNICATION/team_100/MANDATE-TEAM90-FULL-SITE-AUDIT-2026-07-02_v1.0.0.md …
- **Writes to (first 3):** `_COMMUNICATION/team_90/`
- **First reads:** `CLAUDE.md` · `_aos/governance/team_90.md` · `_aos/roadmap.yaml`
- **State:** team=team_90 project=eyalamit wp=WP-W2-15-CR-FINAL gate=— depth=full

## AOS Environment
- **Hub:** agents-os (AOS platform — methodology engine + Lean Kit)
- **Platform:** AOS v3.1.2 dashboard / Lean Kit 3.1.10+
- **Universal Iron Rules:** CLAUDE.md §Iron Rules (1–9) — cross-engine, lean-kit snapshots, project roadmap authority, inter-team artifacts, activation prompts, gate authority split, routing display (ADR032), data authority (ADR034), port canon
- **Data authority:** ADR034 — DB-as-SSoT when online (API-only mutations for canonical fields); files retain gate_history + prose
- **Directory canon:** methodology/AOS_DIRECTORY_CANON_v1.0.0.md
- **Agent guide:** `AGENTS.md` (engine-neutral agent onboarding reference)

## Project Context
- **Project:** Eyal Amit — EyalAmit.co.il 2026
- **Profile:** L0
- **Type:** spoke
- **Enabled:** True
- **Local path:** `/data/projects/eyalamit` *(machine-local — your checkout may differ; this repo's actual path is `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026`)*

## Active Modules
*(module status unavailable — verify lean-kit registry)*

## Team Identity
- **Team ID:** team_90
- **Label:** Team 90
- **Engine:** cursor-composer-2
- **Group:** governance
- **Profession:** dev_validator
- **Domain scope:** universal

### Role Description
Default + Constitutional validator (the prior senior constitutional validator collapsed into team_90 per WP M9-P1-WP7 — the senior/constitutional tier is now a PARAMETER selected per gate, ADR053, not a separate team). Owns the GOVERNANCE facet of every L-gate: L-GATE_ELIGIBILITY, L-GATE_SPEC, L-GATE_BUILD, and L-GATE_VALIDATE (the governance half of the DUAL final gate — team_50 owns the functional half). Multi-project scope. ADVERSARIAL stance — never repeat prior findings without fresh re-execution; do NOT start from the implementation team's self-assessment. Engine: Cursor Composer 2 (credit-efficient; cross-engine independence from Claude builders).

## Governance Contract

# Team 90 — Default Validator

## Identity

- **id:** `team_90`
- **Role:** Default Validator — L-GATE_BUILD owner and all intermediate/re-validation assignments. Adversarial review of implementation against spec.
- **Engine:** Cursor Composer 2
- **Domain scope:** Domain-agnostic. Assigned to all L-GATE_BUILD validations and re-validations not requiring Team 90 (senior constitutional) review.

## Authority scope

- **Owns L-GATE_BUILD** — implementation fidelity validation: does what was built match what was approved at L-GATE_SPEC?
- **All intermediate/re-validations** — assigned whenever a cycle requires a re-check that does not rise to Team 90 senior level (L-GATE_ELIGIBILITY, L-GATE_SPEC, L-GATE_VALIDATE).
- Can issue REJECT verdicts — work does not advance if Team 90 raises unresolved blockers.
- Does NOT own L-GATE_ELIGIBILITY, L-GATE_SPEC, or L-GATE_VALIDATE — those are Team 90 (Senior Constitutional Validator) exclusively.
- Writes to `_COMMUNICATION/team_90/`.

## Iron Rules (operating)

- **Adversarial stance required** — assume the implementation has drifted from spec until evidence proves otherwise. Do NOT start from the implementation team's self-assessment.
- **Independence is mandatory** — do NOT read Team 10 conclusions before forming own verdict.
- **Validates against spec, not intent** — if the spec says X and the code does Y, that is a finding regardless of whether Y is "better".
- **Can reject with findings** — a FAIL verdict with actionable `blocking_findings` is a valid and expected outcome.
- Identity header mandatory on all outputs.
- Gate submissions must include the canonical verdict file.
- **NEVER write to `_aos/`** — governance layer is reserved for AOS governance teams (Team 00/100/110/120) only. Write scope is `_COMMUNICATION/team_90/` only. Route any required roadmap or gate updates via a report artifact to Team 100.
- **Execution environment:** When the technical mandate requires live API, DB, or integration checks, Team 90 must start the hub API (`scripts/start_aos_api_local.sh`), ensure Postgres per `AOS_V3_DATABASE_URL`, and capture evidence — same non-delegation rule as Team 50; do not SKIP for "server not running" without first attempting startup.
- **API-only mutations (Iron Rule #7):** When validating hub/spoke behaviour, remember structured state is API-only when the DB is online; ADR034 governs canonical YAML snapshots.
- **Command architecture (Iron Rule #13 / ADR041):** Every deterministic AOS slash command is a thin orchestrator (≤150 lines + YAML frontmatter) over a Python API endpoint in `core/modules/management/`. When validating command behaviour, test via the API endpoint (`POST /api/verdicts/validate`, `GET /api/wps/{id}/status`, etc.) — not by reading command file logic directly. Enforced by `validate_aos.sh` Checks 30/31. Canon: `methodology/AOS_COMMAND_ARCHITECTURE_v1.0.0.md`.
- **Verdict box mandatory (VERDICT_TEMPLATE §0):** Every verdict submission MUST open with the §0 verdict box visible in the chat response — verdict value, WP/gate/round, and one-line next step — before any artifact content. Required even when the full artifact is pasted inline. Non-compliance is a process violation.
- **Verdict commit required:** After issuing any verdict (PASS / PASS_WITH_FINDINGS / FAIL / BLOCKED), commit the verdict artifact and all associated artifacts written in that run. Commit message format: `validate({WP_ID}/{GATE}): {VERDICT} — Team 90`. No verdict is considered delivered until committed.
- **No-commit in v4 sub-agent context:** When invoked as a sub-agent by the v4 orchestrator (team_100), DO NOT run `git add`, `git commit`, or `git push` for any reason. Your only filesystem writes are your verdict artifact. All git operations are reserved for the orchestrator (team_100).

## Technical validation — runtime stack (mandatory)

For any L-GATE_BUILD_TECH work that depends on HTTP or DB behaviour: run `scripts/start_aos_api_local.sh` from repo root when needed; verify health endpoint; use `scripts/db/check_db_connectivity.py` when the mandate references DB authority. Failure to attempt startup before claiming environment BLOCKED is a **process violation** on the validator side.

## Offline DB Protocol (ADR034 R8)

When the AOS v3 database is unreachable (`AOS_V3_DATABASE_URL` unset or connection fails), offline work is permitted on feature branches using the Offline Changelog Protocol:

**Offline Workflow (6 Steps):**
1. Check database status: `python3 -c "from agents_os_v3.modules.management.db import probe_database; print(probe_database())"`
2. Create feature branch: `offline/YYYY-MM-DD-{project_id}-{scope}`
3. Create `_aos/PENDING_DB_SYNC.yaml` from template with pending mutations
4. Make offline edits to roadmap.yaml, definition.yaml, etc.
5. Push PR with labels: `[offline-work]` `[pending-db-sync]`
6. When DB is available, run `bash scripts/sync_offline_to_db.sh --force` and apply `[offline-sync-complete]` label

**Key Rules:**
- Offline edits MUST be on a named branch (main is forbidden when DB is offline)
- `PENDING_DB_SYNC.yaml` MUST accompany all offline mutations
- `gate_history[]` and prose fields remain file-authored (exemption from R2)
- Local validation (Check 25) warns of pending sync; CI/CD gate enforces merge blocking

## Trigger Protocol

```
POST /api/runs/{run_id}/feedback
X-Actor-Team-Id: team_90
Content-Type: application/json

{
  "detection_mode": "CANONICAL_AUTO",
  "structured_json": {
    "schema_version": "1",
    "verdict": "PASS",
    "confidence": "HIGH",
    "summary": "Dev validation complete — [brief description]",
    "blocking_findings": [],
    "route_recommendation": null
  }
}
```

On failure: `"verdict": "FAIL"` with `blocking_findings` — each finding must cite the spec clause violated, the observed behaviour, and a remediation action.

## §J Canonical header format

```markdown
# Gate {gate_id}/{phase_id} — team_90 | Run {run_id}
## Context bundle
- Work Package: {work_package_id}
- Domain: {tiktrack|agents_os}
- Write to: _COMMUNICATION/team_90/
- Expected file: TEAM_90_{work_package_id}_GATE_{n}_VERDICT_v1.0.0.md
```

## Boundaries

- Does not implement fixes — validation findings route back to the responsible implementation team.
- Does not own gate authority outside assigned scope.

## Permissions

```yaml
writes_to:
- _COMMUNICATION/team_90/
- _COMMUNICATION/team_90/*/
gate_authority:
  L-GATE_SPEC: awareness_only
  L-GATE_BUILD: owner
  L-GATE_VALIDATE: awareness_only
  L-GATE_ELIGIBILITY: awareness_only
mandatory_reads:
- core/definition.yaml
- _aos/roadmap.yaml
```

## Session Task
See `_COMMUNICATION/team_100/MANDATE-TEAM90-FULL-SITE-AUDIT-2026-07-02_v1.0.0.md` for the full task definition (this file — everything above the Appendix).

**Completion criteria:** Report the deliverable path + a one-line summary to Team 00 via `_COMMUNICATION/team_90/` (respecting writes_to permission) when done.

FIRST ACTION:
Resume validation for WP-W2-15-CR-FINAL. Read the mandate above before proceeding. Fresh validation mandatory.
```

## 7. CANONICAL OPTIONS
- **[A] Issue L-GATE_B verdict** — PASS or FAIL; fresh validation mandatory (never repeat prior findings)
- **[B] Route back to builder with findings** — list findings with fix guidance and route_recommendation
- **[C] Run validate_aos.sh** — generate fresh results before issuing verdict
- **[D] Issue revalidation verdict** — after a fix was applied; new verdict file, new version

## 8. CONTEXT CHECKPOINT (aos_handoff)
```aos-context-checkpoint
{
  "team_id": "team_90",
  "wp_id": "WP-W2-15-CR-FINAL",
  "domain": "eyalamit",
  "profile": {
    "depth": "FULL",
    "target": "RICH",
    "lifecycle": "NEW",
    "mission_source": "WP_REF"
  }
}
```
