---
id: MANDATE-TEAM35-W2-10-CLUSTERS-A-G-2026-05-31
from_team: team_100 (Chief System Architect)
to_team: team_35 (Design Studio — claude-design)
date: 2026-05-31
track: CONTENT
milestone: S003
wp: WP-W2-10 (umbrella) + children A–G
authority: team_00 explicit activation 2026-05-31 (governance team_35 §invocation = on_demand_by_team_00)
phase_plan: _COMMUNICATION/team_100/UI-PRECISION-PHASE-PLAN-2026-05-28.md
spec: _aos/work_packages/S003/WP-W2-10/LOD400_spec.md (+ children WP-W2-10-{A..G}/LOD400_spec.md)
gate_role: PIPELINE_FEEDER (produces S1 mockups; does NOT operate gates)
status: ACTIVE
---

# Mandate — UI-Precision S1 (hi-fi mockups), all 7 clusters

## Authorization
team_00 has authorized activation of the **entire S003 UI-Precision cluster** (2026-05-31).
Per governance, team_35 is invoked on-demand by team_00 only; this mandate is that invocation,
issued via team_100, for **all 7 clusters A–G** at once (G conditionally — see §G).

## Objective (per umbrella spec)
Produce, for every non-home route, a **hi-fi visual composition (S1)** on **REAL migrated content**,
so Eyal can sign off (S2) the layout that today is "atoms-by-assumption". **Composition-only** —
assemble existing **D-14** atoms/tokens; invent NO new atoms, NO token/CSS values (AC-U1).

## The 5-stage flow (this mandate = S1 only)
S1 team_35 mockup → **S2 Eyal sign-off (EXTERNAL — STOP here)** → S3 team_10 refine → S4 team_80 token-compliance → S5 team_50 build-gate + team_190 validate.
This mandate covers **S1 only**. Each cluster's package halts at S2 (the missing visual gate). team_35 iterates within this mandate on Eyal feedback.

## Inputs (information package)
- **D-14 design system (SSoT for atoms/tokens — cite, never redefine):**
  `site/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css` + `ea-atoms.css` (+ `ea-animations.css`).
- **Deployed templates (the slot-maps to compose into):** `site/wp-content/themes/ea-eyalamit/page-templates/*.php` and `template-parts/blocks/*.php`.
- **REAL content (mockups MUST use real Hebrew copy, real titles/excerpts — NOT lorem):** staging base
  **`http://eyalamit-co-il-2026.s887.upress.link`** (HTTP, noindex staging). Fetch the live route per cluster.
  Fallback content: `hub/data/content-index.json`, `site/exports/m2-pages-seed.wxr`, `site/exports/blog-legacy.wxr`.
- Per-cluster child spec: `_aos/work_packages/S003/WP-W2-10-<X>/LOD400_spec.md`.

## Deliverable per cluster → `_COMMUNICATION/team_35/WP-W2-10-<X>/` (HANDOFF_PACKAGE, IR#6)
1. `HANDOFF_35_WP-W2-10-<X>_<DATE>_v1.md` — authoritative index (routes, decisions, D-14 atoms used, open questions/assumptions, asset requests).
2. `mockup/` — **hi-fi HTML mockup** per representative route, self-contained, linking/inlining D-14 tokens, on real content. This is the artifact Eyal signs off.
3. `narrative/` — screen-by-screen composition notes citing D-14 atom IDs + rationale for block order/spacing.
4. `assets/` — declared asset list (what real images/media exist vs. what Eyal must still provide).
5. Open questions / assumptions (in the HANDOFF index) — esp. asset gaps and content ambiguities.
(wireframe/prototype/state-diagram: fold into the narrative where the layout is non-trivial.)

## Clusters (sequence per phase-plan §7)
| WP | Cluster | Routes | Template(s) | Priority | Content |
|----|---------|--------|-------------|----------|---------|
| **A** | Service | /treatment, /method, /sound-healing, /lessons | `tpl-service.php` (slots: hero, intro, body-sections, faq-filter, testimonials, cta-pill) | HIGH (first) | W2-02/W2-04 |
| **B** | Editorial | /about, /press, /about/moksha | `tpl-content.php` | HIGH | W2-02/W2-07 |
| **C** | Conversion | /contact, /faq | `tpl-contact.php`, `tpl-faq.php` (already REAL) | MED | W2-02 |
| **D** | Blog | /blog (archive), /blog/<slug> (single) | `tpl-blog-archive.php`, `tpl-blog-single.php` | MED | W2-06 |
| **E** | Commerce | /books, book-detail, /shop, shop-item | `tpl-books.php`, `tpl-book-detail.php`, `tpl-shop-archive.php`, `tpl-shop-item.php` | HIGH (asset-gated) | W2-03/W2-05 |
| **F** | EN landing | /en | `tpl-en-landing.php` (RTL→LTR mirror) | HIGH (direction-flip risk) | W2-08 |
| **G** | Hero video | / hero block | `template-parts/blocks/block-hero.php` | 🔒 **BLOCKED** | Eyal video |

### §G — Hero video (BLOCKED, conditional)
G's S1 is **deferred**: it requires Eyal's hero video asset (not yet delivered). This mandate
**registers** G as activated-but-blocked; team_35 does NOT produce a G mockup until team_00 supplies
the video. Declare the CSS-gradient placeholder fallback in the (future) package.

## Constraints (binding)
- **Composition-only.** Cite D-14 atom IDs; introduce no new atoms or token values (AC-U1; if truly
  needed → team_80 GCR, not a unilateral change). team_80 verifies zero drift at S4.
- **Real content only** (no lorem) — front-loads a meaningful Eyal review (phase-plan §6 risk).
- **Targets to design toward:** Lighthouse mobile perf ≥85 + a11y 100 (AC-U2); axe 0 critical/0 serious (AC-U3).
- **STOP at S2.** Do not refine deployed templates (that is S3/team_10) and do not self-validate (S5/team_50+190, non-Claude — cross-engine IR#1).

## Per-cluster paste-ready sandbox prompt
A ready-to-run prompt for the claude-design sandbox is provided in each
`_COMMUNICATION/team_35/WP-W2-10-<X>/BRIEF.md` (one per cluster).

*team_100 → team_35 | activation 2026-05-31. S1 packages feed the Eyal sign-off gate (S2).*
