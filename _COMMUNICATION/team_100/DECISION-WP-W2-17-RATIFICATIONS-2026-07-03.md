---
id: DECISION-WP-W2-17-RATIFICATIONS-2026-07-03
title: "WP-W2-17 ratification bundle: SEO/GEO decision gates D2/D3/D12/D13, AC-12 ownership, permanent brand retirement, content-diff tool-drift ratification"
date: 2026-07-03
decided_by: team_00 (Nimrod) — in-session, this date (items marked t00); team_100 within delegated authority (items marked t100)
prepared_by: team_100 (Chief Architect, claude-code)
status: DECIDED
related: _COMMUNICATION/team_80/SEO-GEO-RESEARCH-SYNTHESIS-2026-07-02.md; _COMMUNICATION/team_90/CONTENT-ACCURACY-REPORT-CR-FINAL-2026-07-02.md; WP-S004-P001-WP000-SEO-GEO-FINALIZATION-2026-06-20.md §8 (decision ledger); WP-W2-17-CRFINAL-SEO-REMEDIATION-PROGRAM-2026-07-03.md
---

# Decisions

## 1. D3 — AI-crawler robots.txt posture (t00) — **ALLOW ALL, EXPLICIT, LOGGED**
Production robots.txt carries explicit Allow stanzas for all 10 UAs — Googlebot, Bingbot, GPTBot, OAI-SearchBot, ChatGPT-User, ClaudeBot, Claude-SearchBot, Claude-User, PerplexityBot, Perplexity-User — plus `Sitemap: https://www.eyalamit.co.il/sitemap_index.xml`. Rationale: discovery-first objective (the site's only objective, umbrella `:22`); training inclusion helps an unknown brand become known to models; trivially reversible. File authored now at `docs/cutover/robots-production.txt`; **deployed only at cutover** (WP012 + AC-07 day-one curl matrix). UA tokens re-verified at build per WP-04 spec.

## 2. D13 — English site investment (t00) — **SINGLE-PAGE EN REFRESH** (deviates from team_80 advisory)
team_00 chose Option B over the advisory's out-of-scope recommendation: one refreshed `/en/` page (Mukesh lineage + cbDIDG intro). Constraints: EN copy is DRAFTED by the builder (WP-W2-17 T9) and **gated on Eyal's approval** before any publish; `/en/` stays technically correct meanwhile; no further EN investment without post-cutover demand data.

## 3. AC-12 — lead-receipt verification ownership (t00) — **ASSIGNED**
Accountable: **team_100**. Executing: team_10 + uPress ops (under the WP-W2-17 execution mandate). Human verifier: Eyal confirms inbox receipt — 2-minute ask via team_00 channel (queued in hub). Target: staging-provable half ≤ **2026-07-09**; production re-run stays WP012 checklist item 12. Registered in `hub/data/tasks.json` → `M5-T-LEAD-TRACKING`.

## 4. Brand retirement — **PERMANENT AND FINAL** (t00, verbatim ruling this session)
> «זה מאושר — ולא זמני — קבוע — הוחלט שמשנים את שם המותג ומחליפים בכל המקומות»

The retired brand string «סטודיו נשימה מעגלית» is replaced everywhere, permanently. Consequences:
- **P0-CRF-01 is not a site defect** — live `/eyal-amit/` §07 content is correct; the 25.5.26 source doc is stale on this point. The prior instruction to restore the source text (MANDATE-TEAM10-CRFINAL-FIXROUND-2026-07-03.md Task 1) is REVOKED/SUPERSEDED.
- `scripts/qa/content-diff.mjs` gains a **permanent source-side normalization** stripping the retired brand suffix (WP-W2-17 T1; jungle-vibes precedent), submitted to team_90 for ratification at the re-audit.
- Hub item **OPEN-BRAND-RETIRED** (`hub/data/eyal-needs.json`) is **CLOSED — decided by team_00**, no longer an Eyal ask; recorded in `hub/data/decisions.json`.
- The AC-09 scope-out for the 6 verbatim customer-testimonial quotes is unchanged (quotes keep the historical string).

## 5. D2 — geo layer for the business schema node (t100, per ledger authority) — **BOUNDED GEOCIRCLE**
`areaServed` = GeoCircle, `geoMidpoint` = the published studio address (עמל 8 ב', פרדס חנה-כרכור) geocoded at build (expected band lat 32.4–32.5 / lon 34.9–35.0), `geoRadius` 45 km — the Hadera–Haifa–Sharon catchment (LOD400 `:97`), NOT `areaServed: Israel` (AC-04). GBP parity check when WP009 claims GBP (AC-09). FYI (not a decision) to Eyal via the regular channel.

## 6. D12 — Hebrew keyword-volume method (t100) — **GSC-FIRST**
No paid tool, no Keyword Planner account creation. WP010 phase-1 ships the 3 strategy-justified spokes (= BLOG-01/02/03, pending Eyal content approval — not volume data); phase-2 sized from real GSC queries 4–8 weeks post-cutover.

## 7. content-diff.mjs tool drift (t100) — **RATIFIED AS LEGITIMATE**
The 46-line drift vs the frozen 06-05 copy (`evidence/preflight-2026-07-02/content-diff-drift.diff`) = slug-map updates matching already-ratified migrations (`/eyal-amit/`, `/books/`, mokesh memorial full-doc repoint), a genuine docx paragraph-extraction bugfix (prior code joined `<w:t>` runs across paragraphs, corrupting Hebrew), and the jungle-vibes spelling normalization. Not gate manipulation. team_90 asked team_100 to reconcile (report §6) — reconciled here; team_90 re-ratifies mechanically at the next run.

## 8. DEC-SEO-B1 — pillar URL (deferred, unchanged)
Remains OPEN — RECORD AT BUILD (WP003), per the umbrella ledger `:183`. team_80's lean (top-level `/sleep-apnea-snoring`) noted; decision belongs to WP003 build time, not this bundle.

# Context
Both mandated reports landed 2026-07-02 (team_90 CR-FINAL leg-1 FAIL; team_80 advisory synthesis). team_00 directed full orchestration 2026-07-03: canonical WP (WP-W2-17) covering all findings → external LOD400 validation → handoff to team_110 for implementation → full hub update. Options-per-gate analysis: team_80 report §3 (not duplicated here — Iron Rule: cite, don't copy).

# Rationale (delta only)
- Items 1, 5, 6 follow the team_80 recommendation verbatim; the full pros/cons tables live in the report.
- Item 2 is a team_00 override of the advisory — recorded as such.
- Item 4 converts what was previously an interim/pending disposition (OPEN-BRAND-RETIRED "approve or supply alternative text") into a final ruling; the Eyal round-trip on this item is cancelled.

# Operational notes
- Umbrella ledger (`WP-S004-P001-WP000-SEO-GEO-FINALIZATION-2026-06-20.md` §8) should be updated to CLOSED for D2/D3/D12/D13 at the next umbrella touch — not edited in this session to keep the change-set surgical; this artifact is the ruling of record.
- All build consequences are specified in `WP-W2-17-CRFINAL-SEO-REMEDIATION-PROGRAM-2026-07-03.md` (spec_ref of WP-W2-17).
