---
id: UI-PRECISION-PHASE-PLAN-2026-05-28
title: UI-Precision Phase Plan — post content-migration design precision
status: DRAFT — for team_00 review + authorization
date: 2026-05-28
from_team: team_100 (Chief Architect)
to_team: team_00 (Principal)
depends_on: [WP-W2-02 content migration, WP-W2-06 blog migration]
design_system_owner: team_80 (D-14 LOD400 — design SYSTEM)
visual_mockup_owner: team_35 (Design Studio — wireframes + hi-fi mockups, on-demand)
audit_basis:
  - ./evidence/DESIGN-TEMPLATE-AUDIT-A-deployed-2026-05-28.md
  - ./evidence/DESIGN-TEMPLATE-AUDIT-B-design-deliverables-2026-05-28.md
profile: L0
---

# UI-Precision Phase Plan

## §0 Executive Summary

Wave2 has a **complete design SYSTEM** (team_80 D-14: locked tokens, 32 atoms, motion, a11y) but **only one reviewed visual COMPOSITION** — the homepage POC. Every other page route is being implemented as "atoms-by-assumption": team_10 assembles atoms into a layout that **Eyal has never seen as a design**. The UI-Precision phase closes that gap: engage **team_35 (Design Studio)** to produce per-page hi-fi mockups → Eyal visual sign-off → team_10 refinement → QA. It runs **after** content migration (W2-02 + W2-06) so mockups reflect real content, not lorem.

## §1 Why this phase exists (the gap)

| What exists | What's missing |
|-------------|----------------|
| D-14 design system — 3,934-line LOD400 spec, exact CSS values, BEM HTML, ARIA, motion. **Locked, no TBD.** | No Figma / image comps anywhere. Design is spec-as-code + 1 POC HTML. |
| Homepage POC (atoms-poc-2026-05-26.html) — reviewed, cross-engine validated, Eyal-adjacent sign-off via D-13 style direction. | No reviewed visual composition for ANY non-home page. |
| 32 atoms fully specced + working on the homepage. | How those atoms *assemble* into treatment / method / books / shop / blog / about / FAQ / EN pages = team_10's assumption, unvalidated visually. |
| Deployed theme: 5 real templates + 12 blocks (home-centric). | 8 stub templates (service, content, book-detail, blog ×2, shop ×2, en-landing) — slot-maps only, no layout. |

**Root cause:** The process went LOD200 → D-14 LOD400 atoms → implementation, **skipping the team_35 hi-fi-mockup step (LOD300) for non-home pages.** team_35 is invoked on-demand and was only engaged for early style direction, not per-page composition.

## §2 Coverage Matrix — design precision by route

Legend: ✅ done · 🟡 partial · ❌ missing · 🔒 blocked on external

| Route / Template | team_80 system (atoms/tokens) | Visual composition (mockup) | Deployed template | Content source | UI-precision priority |
|------------------|:---:|:---:|:---:|---|:---:|
| Home `/` (tpl-home) | ✅ | ✅ POC reviewed | REAL | W2-02 | **LOW** (refine) |
| Contact `/contact` (tpl-contact) | ✅ | ❌ | REAL (CF7 form_id=0 gap) | W2-02 | **MED** |
| FAQ `/faq` (tpl-faq) | ✅ | ❌ | REAL | W2-02 | **MED** |
| Books `/books` (tpl-books) | ✅ | ❌ | REAL (cover art placeholder) | W2-03 | **MED-HIGH** (needs Eyal cover assets) |
| Treatment/Method/Sound/Lessons (tpl-service) | ✅ | ❌ | **STUB** | W2-02/W2-04 | **HIGH** (4 key routes, 7 slots unwired) |
| About/Press/Moksha (tpl-content) | ✅ | ❌ | **STUB** | W2-02/W2-07 | **HIGH** |
| Book detail (tpl-book-detail) | ✅ | ❌ | **STUB** | W2-03 | **HIGH** |
| Shop archive/item (tpl-shop-*) | ✅ | ❌ | **STUB** | W2-05 | **HIGH** |
| Blog archive/single (tpl-blog-*) | ✅ | ❌ | **STUB** → W2-06 builds | W2-06 | **MED** (W2-06 produces first render) |
| EN landing (tpl-en-landing) | 🟡 | ❌ | **STUB** | W2-08 | **HIGH** (RTL→LTR flip unvalidated) |
| Hero video treatment | ✅ atom spec | 🔒 awaiting Eyal video | placeholder (CSS gradient) | Eyal | **🔒 BLOCKED** |
| 49 QR landing pages | 🟡 | ❌ | none | W2-07 | **MED** (template-driven, lower visual risk) |

**Designed-to-completion (visual):** Home only (1 of 11 page types).
**Assumption-based (visual):** 10 of 11 page types.

## §3 The UI-Precision Phase — structure

### Sequencing
```
[NOW] W2-02 content migration ──┐
      W2-06 blog migration ─────┼──► content lands in templates (real text/images)
                                │
                                ▼
      [UI-PRECISION PHASE] ─────────────────────────────────────────
      Step 1: team_35 hi-fi mockups (per template cluster, on real content)
      Step 2: Eyal visual sign-off gate (the missing review)
      Step 3: team_10 refinement (apply mockup deltas to deployed templates)
      Step 4: team_80 token-compliance check (no ad-hoc drift from D-14)
      Step 5: team_50 + team_190 QA/validate per cluster
```

**Why after content migration:** Mockups on lorem ipsum mislead. Eyal must judge real Hebrew copy, real book titles, real blog excerpts in the composition. W2-02 + W2-06 put that content in place first.

### Step 1 — team_35 mockup production (LOD300)
- team_100 issues a `track: CONTENT` mandate to team_35 (on-demand, per governance §Canonical Workflow).
- Mockups grouped by **template cluster** (not per-page — clusters share layout DNA):
  1. **Service cluster** (treatment / method / sound-healing / lessons — tpl-service) — HIGH priority, 4 routes one template.
  2. **Editorial cluster** (about / press / moksha — tpl-content) — HIGH.
  3. **Commerce cluster** (books / book-detail / shop-archive / shop-item) — HIGH, needs Eyal cover/product assets.
  4. **Blog cluster** (archive / single) — MED, W2-06 gives first render to refine from.
  5. **Conversion cluster** (contact / FAQ) — MED, templates already REAL.
  6. **EN landing** — HIGH (LTR mirror of RTL system — untested direction flip).
- Deliverable: hi-fi mockups (HTML-first in claude-design sandbox) + per-cluster design notes referencing D-14 atoms (no new atoms — composition only).

### Step 2 — Eyal visual sign-off gate (the missing gate)
- Each cluster's mockup → Eyal review → APPROVE / REVISE.
- This is the gate that never happened for non-home pages. It's the core value of the phase.
- team_00 routes Eyal's feedback; team_35 iterates within the same mandate.

### Step 3 — team_10 refinement
- For each approved cluster, team_10 applies the composition to the deployed template (wire the stub slots, adjust block order/spacing per mockup).
- Constraint: composition deltas only — atoms + tokens stay D-14-locked.

### Step 4 — team_80 token-compliance
- team_80 verifies the refined templates use only D-14 tokens/atoms — no ad-hoc CSS drift introduced during refinement.

### Step 5 — QA + validate
- team_50 L-GATE_BUILD (cross-engine; Puppeteer axe + Lighthouse triple-run + visual screenshots — the methodology locked in Stage B).
- team_190 L-GATE_VALIDATE (constitutional, Codex/GPT).

## §4 Scope boundaries

**IN scope:**
- Per-page visual compositions for all non-home routes.
- The Eyal visual sign-off gate.
- Composition refinement of deployed templates.
- Hero video treatment finalization (once Eyal provides video — IDEA-related, currently 🔒).

**OUT of scope:**
- New atoms or token changes (that's a D-14 amendment — team_80 GCR if truly needed).
- Content writing (W2-02..W2-08 own that).
- Net-new pages beyond the Wave2 roadmap.

## §5 Dependencies + triggers

| Dependency | Status | Blocks |
|------------|--------|--------|
| W2-02 content migration | IN_PROGRESS | Service/Editorial/Conversion cluster mockups |
| W2-06 blog migration | IN_PROGRESS | Blog cluster mockups |
| W2-03 books / W2-05 shop content | not started | Commerce cluster (can mock with placeholder commerce content if Eyal wants early) |
| Eyal cover/product image assets | pending | Commerce cluster final |
| Eyal hero video | pending (🔒 IDEA-linked) | Hero finalization |
| team_35 activation | requires team_00 explicit instruction (governance: on_demand_by_team_00) | entire phase |

**Phase trigger:** team_00 authorizes after W2-02 + W2-06 reach a content-complete state (even pre-QA — mockups can start on content-complete-but-unpolished templates).

## §6 Risks + mitigations

| Risk | Severity | Mitigation |
|------|----------|------------|
| Eyal rejects a composition late → rework cascade | HIGH | Front-load Eyal sign-off per cluster (Step 2) BEFORE team_10 refinement, not after |
| team_35 mockups drift from D-14 atoms (invent new visuals) | MED | Mandate explicitly: composition-only, cite D-14 atom IDs; team_80 Step-4 compliance check |
| Commerce cluster blocked on Eyal assets | MED | Mock with placeholder assets first; swap when Eyal delivers; don't block the whole cluster |
| EN landing RTL→LTR flip breaks layout | MED-HIGH | Dedicated EN mockup + a11y/RTL-mirror QA; treat as its own sub-cluster |
| Phase competes with content teams for the theme repo | MED | Sequence after W2-02/W2-06 merge; UI-precision works on merged main, separate feature branches per cluster |

## §7 Recommended cluster sequencing (when phase activates)

1. **Service cluster** (HIGH, 4 routes, content from W2-02) — biggest coverage win.
2. **Editorial cluster** (HIGH, about is a flagship page).
3. **Conversion cluster** (MED, templates already REAL — fast win, unblocks contact form too).
4. **Blog cluster** (MED, after W2-06 lands).
5. **Commerce cluster** (HIGH but asset-gated — start mockups, finalize on Eyal assets).
6. **EN landing** (HIGH, isolate the direction-flip risk).
7. **Hero video** (🔒 — finalize when Eyal video arrives).

## §8 Naming correction (governance accuracy)

- **team_35 = Design Studio** (סטודיו עיצוב) — wireframes + hi-fi mockups, claude-design sandbox, on-demand. **This is the team for the UI-precision phase** (nimrod's reference was correct).
- **team_80 = Design System owner** — D-14 LOD400 (tokens/atoms/motion). Owns the system, not per-page compositions.
- Both are needed: team_35 composes, team_80 guards system fidelity.

## §9 Next actions (for team_00 decision)

1. **Approve this phase plan** (or adjust cluster priorities).
2. **Decide phase trigger timing** — start mockups now on in-progress content, or wait for W2-02/W2-06 QA-complete?
3. **Authorize team_35 activation** (governance requires explicit team_00 instruction) — team_100 will then draft the `track: CONTENT` mandate per cluster.
4. **Confirm Eyal availability** for the per-cluster visual sign-off gate (the critical-path human step).

## §10 Version

| Date | Action |
|------|--------|
| 2026-05-28 | Plan drafted by team_100 from 2 design audits (deployed theme + design deliverables). Awaiting team_00 authorization. |
