---
gate: N/A — advisory research, not part of the gate process (team_80 charter)
wp: none registered (S004-P001-WP000 SEO/GEO program exists but is FILE-CANONICAL ONLY — see Why)
to: team_80
from: team_100
engine_builder: claude-code
date: 2026-07-02
priority: HIGH
status: OPEN
depends_on: S004-P001-WP000 SEO/GEO Finalization program (LOD400, file-canonical, 2026-06-20); content-proposals.json (15 proposals, all pending Eyal); AEO-GEO-READINESS-AUDIT-2026-03-31 (original diagnosis); DELTA-EYAL-DEV-BRIEF-GEO-AEO-SEO-VS-SSOT-2026-04-10
engine_method: PENDING team_00 approval per ADR046 §2.6 — team_100 recommendation given below; team_00 must confirm or override before team_80 begins execution
canonical_handoff: generated via /AOS_mail handoff (type=handoff&mode=handoff), team_id=team_80, project_id=eyalamit, at 2026-07-02T20:06:47.162519Z — see Appendix A
---

# MANDATE — team_80 deep SEO/GEO/organic-traffic research: synthesize, resolve open gates, verify current state, recommend

## Why

A substantial SEO/GEO/AEO body of work already exists for this project but has never reached execution closure. This mandate is explicitly **not** "start SEO research from zero" — it is: audit what exists, verify it against the CURRENT dev site, resolve what's still genuinely open, and produce one clear, decision-ready report. The trail, oldest to newest:

1. **Original diagnosis** — `docs/project/AEO-GEO-READINESS-AUDIT-2026-03-31.md`: pre-rebuild audit of the live legacy site against Google/OpenAI's actual public guidance on AI Overviews / ChatGPT Search. Findings: `robots.txt` and `llms.txt` both 404 on legacy; schema thin (only Yoast Person/Organization/WebSite/WebPage — no FAQPage/LocalBusiness); pages are narrative marketing copy, not answer-extraction format; stale event dates; no `og:image`.
2. **Client's own brief** — `docs/project/eyal-ceo-submissions-and-responses/from-eyal/eyal_amit_dev_brief_GEO_AEO_SEO.md` + companion `EYAL-SITEMAP-SEO-AEO-GEO--REQUIREMENTS-BASELINE-2026-04-02.md`. Positions the core offering as "טיפול בנשימה באמצעות דיג'רידו" (brand cbDIDG), explicitly rejecting "נשימה מעגלית" as the lead term; specifies homepage block structure, nav, mandatory FAQ, and a Schema stack (Person/LocalBusiness/FAQPage/Article).
3. **Gap analysis** — `_COMMUNICATION/team_100/DELTA-EYAL-DEV-BRIEF-GEO-AEO-SEO-VS-SSOT-2026-04-10.md`: reconciles Eyal's brief against the sitemap SSOT; several of its recommendations are now closed decisions (see §"Locked decisions" below).
4. **The full execution program** — `_COMMUNICATION/team_100/WP-S004-P001-WP000-SEO-GEO-FINALIZATION-2026-06-20.md` (13 sub-WPs, `S004-P001-WP001`..`WP013`, `lod_status: LOD400`, `current_lean_gate: L-GATE_SPEC`) + companions:
   - `_COMMUNICATION/team_100/LOD400-SEO-GEO-OPTIMIZATION-2026-06-19.md` (strategy, T1–T21 / D1–D12)
   - `_COMMUNICATION/team_100/SEO-GEO-EXECUTION-PLAN-2026-06-20.md` (13-WP verbatim specs)
   - `_COMMUNICATION/team_100/SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md` (per-WP gate matrix, staging-vs-production measurement rules)
   - `_COMMUNICATION/team_100/SEO-GEO-WAVE-1-SCOPE-2026-06-20.md` (buildable-now-without-Eyal subset)

   **This program is FILE-CANONICAL ONLY** — its header states plainly "CANONICAL STATUS — FILE-CANONICAL ONLY (DB registration BLOCKED)", blocked on a team_110 hub-API actor-key issue. `_aos/roadmap.yaml`'s `active_milestone` is still `S003`; the S004 slot is free/unused. This is real, detailed, LOD400-level work — read it as authoritative context, not as "not yet started."

5. **15 concrete content proposals** — `hub/data/content-proposals.json`. **All still open**, zero approved (`hub/data/eyal-needs.json` P1 confirms; `hub/data/tasks.json` task `M5-T-CONTENT-PROPOSALS` = `not_started`). **CP-01** (the snoring/sleep-apnea content pillar) is explicitly flagged as the #1 business lever for organic traffic and is blocked purely on Eyal's sign-off on wording/claims.

6. **A live self-correction already happened mid-program**: the execution plan's own appendix flags that an earlier assumption ("0% schema") was wrong — the site actually runs **Yoast SEO v27.8** with a live JSON-LD `@graph`, canonical tags, and `/sitemap_index.xml` — so the strategy was revised to *extend* Yoast's graph via the `wpseo_schema_graph` filter rather than hand-roll a second schema stack. **Verify this is still accurate against the CURRENT build** (Task 4) — the site has changed since 06-20.

## Scope

- All documents listed in `## Why` — read in full, do not summarize from titles alone.
- `hub/data/content-proposals.json`, `hub/data/decisions.json`, `hub/data/tasks.json` (the M5 → M6 → M7 punch-list sequencing), `hub/data/eyal-needs.json`, `hub/data/materials-needed.json`.
- Current live dev/staging site: `http://eyalamit-co-il-2026.s887.upress.link` — **HTTP only**, staging TLS is invalid by design (CLAUDE.md); staging is intentionally `noindex`'d (`ea-staging-noindex.php` mu-plugin) and Lighthouse/SEO scores there are explicitly flagged in the validation-deployment plan as staging-capped artifacts — do not treat a low staging SEO score as a production defect.
- `docs/qa/*/qa_probe_result.json` — existing QA runs; note their SEO-relevant blind spots (Task 4).

## Tasks

### 1 — Synthesize current state (one dense table)

For each of: the S004 program's 13 sub-WPs, the 15 content proposals, and the 5 SEO/GEO-relevant **locked decisions** (`D-EYAL-SITE-07` flat 11-item menu, `D-EYAL-CONTENT-MODEL-09` blog/media as separate slugs, `D-EYAL-MENU-BRAND-10` nav shows "השיטה" not cbDIDG, `D-EYAL-ENTITY-CATALOG-12` FAQ/galleries/testimonials as catalog pages, `D-EYAL-ABOUT-URL-15` canonical `/eyal-amit`) — state status: **done / in-progress / blocked-on-Eyal / open-decision-needed**, each with its exact source citation.

### 2 — Resolve the 4 open decision gates from the S004 program

The program's own decision tracker (D1–D13) lists these as still **OPEN**:
- **D2** — geo radius for local-business schema
- **D3** — GPTBot allow/block policy in `robots.txt`
- **D12** — keyword-volume verification method/tool
- **D13** — English-site SEO investment level

For each: research the actual tradeoffs, present **2–3 concrete options with pros/cons**, and give **one clear recommendation**. This is exactly the "options + recommendations" Team 00 asked the report to contain.

### 3 — Address the AC-12 ownership gap

The validation-deployment plan flags **AC-12 ("end-to-end lead receipt tracking")** as the highest business-risk acceptance criterion, with **no assigned owner or date**. Research what's needed to close it — cross-reference `hub/data/tasks.json` `M5-T-ANALYTICS` (Clarity setup) and the `WP-01` conversion-tracking item in `businessLeversHe` (`hub/data/eyal-needs.json`) — and recommend an owner + a concrete next step.

### 4 — Verify current dev-site SEO signals still hold

The site has changed since 06-20 (WP-W2-16 series, nav/IA cleanup, new pages built this week). Spot-check the **current** live staging build:
- Is the Yoast JSON-LD `@graph` still present and correctly typed per page (Person / LocalBusiness / FAQPage / Article as applicable)?
- Is `robots.txt` present, and does the staging `noindex` mu-plugin still correctly block indexing (expected/correct on staging — not a defect)?
- Is `/sitemap_index.xml` still live?

Note explicitly: the existing `docs/qa/*` probes check **none** of this (only page-title string + horizontal-overflow) — this is a genuine coverage gap in this project's QA harness. Flag it, and state whether **closing** that gap belongs to team_80 (research/advisory) or should be handed to team_90/team_50 (technical execution) — consistent with team_80's own charter, which is advisory and does not execute build/validation work itself.

### 5 — Deliver the summary + recommendations report

One report answering exactly what Team 00 asked for: summarize **all open topics** (the 4 decision gates, AC-12, the 15 pending content proposals bucketed by theme, any drift found in Task 4), present **options + a clear recommendation** for each open item, and a prioritized next-actions list distinguishing what can move now from what is hard-blocked on Eyal.

## Engine method (ADR046 §2.6 — binding, requires team_00 approval)

Per team_80's governance contract (Rule 1): team_100 recommends the working method per case; team_00 must approve or override **before** execution begins.

**team_100 recommendation:** `manual_hybrid`. This mandate is primarily synthesis-and-audit of existing written material (Tasks 1–3, 5) plus direct live-site verification (Task 4) — better suited to direct document reading + browser checks than an MCP-wrapped external search, and direct paid-API access is discouraged by default for team_80 per the contract's Rule 2 (credit pools reserved for production work).

**Team 00: please confirm or override this method before team_80 begins.**

## Out of scope

- Re-litigating the 5 already-**locked** decisions (`D-EYAL-SITE-07`, `D-EYAL-CONTENT-MODEL-09`, `D-EYAL-MENU-BRAND-10`, `D-EYAL-ENTITY-CATALOG-12`, `D-EYAL-ABOUT-URL-15`) — reference them, do not reopen them.
- Implementing any fix, schema code, or content — team_80 is advisory only (governance contract: "not part of the gate process"); findings route to team_100, not to direct implementation.
- Anything requiring Eyal's own decision to resolve (the 15 content proposals themselves, D10 Mokesh memorial content, the testimonials list) — report status accurately; do not attempt to resolve on Eyal's behalf.

## Deliverable

One report, `SEO-GEO-RESEARCH-SYNTHESIS-2026-07-02.md` (or dated equivalent), in `_COMMUNICATION/team_80/`, with **sources/citations for every claim** (team_80 Iron Rule 1: "Research artifacts must include sources and evidence") and **actionable, not academic**, recommendations (Iron Rule 2). Route to **team_100** for architecture-level action — per team_80's charter, do not route directly to Eyal; team_00/team_100 own that channel.

---

# Appendix A — Canonical AOS Handoff Activation (verbatim)

*Generated via `/AOS_mail handoff` → `GET /api/prompts/generate?type=handoff&mode=handoff&team_id=team_80&project_id=eyalamit` at `2026-07-02T20:06:47.162519Z`. Embedded verbatim per the canonical handoff mechanism (ADR043 §A.4c) — this is the real, live-generated identity/governance/environment activation block, not a paraphrase.*

*(No `wp_id` was supplied for this call — the substantive SEO/GEO program (S004) is not DB/roadmap-registered, so there is nothing for a live WP lookup to resolve. File-based context is supplied above in `## Why`.)*

# Session Handoff — team_80 | Deep SEO/GEO/organic-traffic research — synthesize the S004 program + content-proposals + prior audits, resolve open decision gates, verify current dev-site state, deliver options+recommendations

## 1. SESSION ACCOMPLISHED
*(No accomplishments recorded — session handoff for context only.)*

## 2. IDENTITY SNAPSHOT
## Team Identity
- **Team ID:** team_80
- **Label:** Team 80
- **Engine:** variable
- **Group:** research
- **Profession:** researcher
- **Domain scope:** universal

### Role Description
External research team operating in online environments across variable AI engines (Claude Chat, etc.). Performs deep analysis, competitive research, technology evaluation, feasibility studies, and prompt quality assessment. Advisory — delivers research artifacts to architecture teams via Team 00 routing. Not part of the gate process.

## 3. CONTEXT SNAPSHOT
*No active WP (S004 SEO/GEO program is file-canonical only — not DB-registered). Effective gate state: no_wp.*

## 4. MANDATORY READS
- `_aos/governance/team_80.md`
- `_aos/roadmap.yaml`
- `methodology/AOS_IDENTITY_ONBOARDING_v1.0.0.md` (first AOS session only)

## 5. BLOCKERS / OPEN ITEMS
*(None recorded by the API — see this mandate's `## Why` / Tasks 2–3 for the real open items: D2/D3/D12/D13 decision gates, AC-12 ownership gap.)*

## 6. ACTIVATION PROMPT
```
HANDOFF_DEPTH: full
ACTIVATION_SCOPE: team_80 only

# Handoff — team_80 / eyalamit

*Generated 2026-07-02T20:06:47.162519Z  ·  Depth: full*

## Activation TL;DR
- **Identity:** team_80 · engine: variable · role: Team 80
- **Domain:** eyalamit · profile: L0
- **Assignment:** WP=— · gate=—
- **Task:** See _COMMUNICATION/team_100/MANDATE-TEAM80-SEO-GEO-RESEARCH-2026-07-02_v1.0.0.md…
- **Writes to (first 3):** `_COMMUNICATION/team_80/`
- **First reads:** `CLAUDE.md` · `_aos/governance/team_80.md` · `_aos/roadmap.yaml`
- **State:** team=team_80 project=eyalamit wp=— gate=— depth=full

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
- **Team ID:** team_80
- **Label:** Team 80
- **Engine:** variable
- **Group:** research
- **Profession:** researcher
- **Domain scope:** universal

### Role Description
External research team operating in online environments across variable AI engines (Claude Chat, etc.). Performs deep analysis, competitive research, technology evaluation, feasibility studies, and prompt quality assessment. Advisory — delivers research artifacts to architecture teams via Team 00 routing. Not part of the gate process.

## Governance Contract

# Team 80 — Research | Governance Contract

## Identity
- **ID:** team_80
- **Role:** Research
- **Engine:** variable
- **Group:** research
- **Profession:** researcher
- **Gate Authority:** None — advisory, not in gate process

## Iron Rules (Operating)
1. Research artifacts must include sources and evidence
2. Findings must be actionable — not academic
3. Activation requires explicit Team 00 instruction
4. Deliver findings to architecture team, not implementation
5. Universal team numbering (Iron Rule #9)
6. Identity header mandatory on all output artifacts
7. NEVER write to `_aos/` — governance layer is reserved for AOS governance teams (Team 00/100/110/120) only. Write scope is `_COMMUNICATION/team_80/` only. Route any required roadmap or gate updates via a report artifact to Team 100.
8. **API-only mutations (Iron Rule #7):** API-only mutations: when AOS DB is running, all structured data mutations (WP status, gate, lod_status, team engine/environment, project metadata) MUST go through the API. Direct edits to roadmap.yaml, definition.yaml, projects.yaml for structured fields are FORBIDDEN per Iron Rule #7.

## Engine Method + Pre-Approval Rules (binding, per ADR046 §2.6)

Authority: team_00 directive 2026-04-25 (`_COMMUNICATION/team_80/DIRECTIVE_TEAM_80_MCP_DEFAULT_2026-04-25_v1.0.0.md`); promoted into governance contract 2026-04-27 alongside ADR046 / ADR047.

### Rule 1 — Method recommended per case + team_00 approves

The orchestrator (team_100) analyzes each team_80 research kickoff and **recommends** the working method for that specific case: `mcp` (when MCP server available + observable + appropriate) · `manual_hybrid` (when MCP unavailable/insufficient depth) · `mixed` (some queries via MCP, some manual) · `api-with-reason` (only when the first two are inadequate; see Rule 2). The recommendation MUST include reasoning so team_00 can override informed. team_00 approves OR modifies before execution begins. No method is universally default — routing is per-case.

### Rule 2 — API access discouraged + cost reasoning

Direct API access (Anthropic API, OpenAI API, Gemini API) is **discouraged by default** for team_80. Reason (binding): limited credit pools across providers must be reserved for production work.

## Permissions

```yaml
writes_to:
- _COMMUNICATION/team_80/
- _COMMUNICATION/team_80/*/
gate_authority: none
mandatory_reads:
- core/definition.yaml
- _aos/roadmap.yaml
```

## Session Task
See `_COMMUNICATION/team_100/MANDATE-TEAM80-SEO-GEO-RESEARCH-2026-07-02_v1.0.0.md` for the full task definition (this file — everything above the Appendix).

**Completion criteria:** Report the deliverable path + a one-line summary to Team 00 via `_COMMUNICATION/team_80/` (respecting writes_to permission) when done.

FIRST ACTION:
Confirm the recommended engine method (`manual_hybrid`) with team_00, then begin Task 1 (current-state synthesis table).
```

## 7. CONTEXT CHECKPOINT (aos_handoff)
```aos-context-checkpoint
{
  "team_id": "team_80",
  "wp_id": null,
  "domain": "eyalamit",
  "profile": {
    "depth": "FULL",
    "target": "RICH",
    "lifecycle": "NEW",
    "mission_source": "SESSION_TASK"
  }
}
```
