---
id: MANDATE-TEAM35-W2-10-TRACK2-ELEVATION-2026-06-02
from_team: team_100 (Chief System Architect)
to_team: team_35 (Design Studio — claude-design)
date: 2026-06-02
wp: WP-W2-10 (UI Precision umbrella) — Track-2 high-visual ELEVATION
clusters: A (Service) · B (Editorial) · E (Commerce) · F (EN landing)   [G (Hero video) BLOCKED]
stage: S1.5 — design elevation / precision pass (builds on the delivered S1 mockups). HALTS at S2 (Eyal sign-off).
status: ISSUED (execute on team_00 go)
decision_ref: _COMMUNICATION/team_00/DECISION_DESIGN-ELEVATION-SEQUENCING_2026-06-01_v1.md
process_ssot: _COMMUNICATION/team_100/UI-PRECISION-PHASE-PLAN-2026-05-28.md
predecessor: MANDATE-TEAM35-W2-10-CLUSTERS-A-G-2026-05-31 (S1 hi-fi mockups — delivered, READY_FOR_S2)
---

# MANDATE — team_35 · WP-W2-10 Track-2 · High-visual design ELEVATION (A/B/E/F)

## 0. Context & authorization
team_00 decided **Option C (hybrid)** (2026-06-01): the settled clusters shipped under WP-W2-11 (Conversion +
Blog + Home — now DONE on main). The **high-visual flagship clusters take the elevation path**: per the decision,
"A Service · B Editorial · E Commerce · F EN → **team_35 improvement + precision (with team_00/nimrod) → Eyal
approval → implement**." Track-1 is complete; **Track-2 is now the active front, and team_35 is the lead.**

You already delivered S1 hi-fi mockups for A–G (2026-05-31, composition-only, D-14 atoms assembled). This mandate
is the **elevation pass on top of those S1 mockups** — raising the four high-visual clusters from "correct
composition" to "sign-off-ready, precision-tuned flagship design," iterating with team_00/nimrod, for Eyal S2.

## 1. Scope (IN) — 4 clusters, sequence A → B → E → F
| # | Cluster | Routes / template | S1 source to elevate |
|---|---------|-------------------|----------------------|
| **A (first — biggest coverage win)** | Service | `/treatment`, `/method`, `/sound-healing`, `/lessons` (`tpl-service`, 7 unwired D-14 slots) | `_COMMUNICATION/team_35/WP-W2-10-A/` |
| **B** | Editorial | `/about`, `/press`, `/about/moksha` (`tpl-content`; bio/portrait placeholder) | `_COMMUNICATION/team_35/WP-W2-10-B/` |
| **E** | Commerce | `/books` + 3 details, `/shop` + 5 items | `_COMMUNICATION/team_35/WP-W2-10-E/` |
| **F** | EN landing | `/en` (`tpl-en-landing`, RTL→LTR mirror) | `_COMMUNICATION/team_35/WP-W2-10-F/` |

**OUT OF SCOPE:** G (Hero video) — BLOCKED on Eyal's video asset. Track-1 clusters (done). No template edits.

## 2. What "elevation" means (the deliverable per cluster)
Beyond the S1 composition, deliver a **precision-tuned hi-fi mockup** that is genuinely flagship-grade:
- **Visual hierarchy & rhythm:** deliberate spacing scale, type hierarchy, section pacing — not just atoms stacked.
- **Hero/section treatments:** per-cluster hero/intro treatment (within D-14), strong above-the-fold for each flagship.
- **Content shaping:** use the REAL content (fetch from staging `http://eyalamit-co-il-2026.s887.upress.link/<route>`,
  HTTP) and shape it for scannability/conversion (Service: "who it's for" + method + proof; Editorial: long-form
  reading; Commerce: product desirability + clear buy path; EN: credible LTR mirror).
- **Eyal-gap placeholders kept graceful** (portrait avatars, book/product covers, EN assets) — flagged, not faked.
- **Iterate with team_00/nimrod** within this mandate before declaring a cluster ready for Eyal.

## 3. HARD CONSTRAINTS (same D-14 discipline as S1)
- **Composition + precision only** — reuse D-14 atoms/tokens **verbatim** (`ea-tokens.css`, `ea-atoms.css`, cluster
  sheets `w2-04-service.css` / `w2-05-shop.css` / `ea-blog.css`). **No new token values; no new atoms.** If the
  elevation genuinely needs a new atom/token, **flag it for a team_80 GCR** (team_100 → team_00) — do NOT invent it.
- Self-contained RTL mockups (`dir="rtl" lang="he"`; F is LTR mirror via logical properties). Motion off in mockups
  (live motion is the build layer). AA contrast (`--ea-text-body`). Real content, not lorem.
- **STOP at S2 (Eyal sign-off).** No theme/template edits, no deploy, **no self-validation** (S5 is team_50 + team_190).
- Inter-team comms via canonical artifacts in `_COMMUNICATION/team_35/`.

## 4. Per-cluster deliverables (into `_COMMUNICATION/team_35/WP-W2-10-<X>/elevation/`)
- `mockup/*.html` — elevated hi-fi mockup(s) per route.
- `narrative/elevation-notes.md` — what changed vs S1 and why (cite D-14 atom IDs; list any GCR-flagged needs).
- `assets/asset-manifest.md` — Eyal-gap inventory + swap path.
- `HANDOFF_35_W2-10-<X>-ELEVATION_2026-06-0X_v1.md` — index; status `READY_FOR_S2`.

## 5. Flow & gates (per cluster, after this elevation)
S1 (done) → **S1.5 elevation (this mandate, team_35 + team_00)** → **S2 Eyal sign-off** → S3 team_10 refine/implement
→ S4 team_80 token-compliance → S5 team_50 L-GATE_BUILD → team_190 L-GATE_VALIDATE (run in Cursor per team_00).
team_35 HALTS at S2.

## 6. Acceptance (elevation-stage; full ACs validated downstream at S5)
- AC-E1 each cluster's elevated mockup is flagship-grade (clear hierarchy, hero treatment, shaped real content) and
  team_00-iterated.
- AC-E2 strict D-14 fidelity — zero new tokens/atoms (any need GCR-flagged).
- AC-E3 RTL correct (F = LTR mirror via logical props); AA contrast; single H1; graceful Eyal-gap placeholders.
- AC-E4 HANDOFF per cluster, `READY_FOR_S2`, halted (no template edits / no self-validate).

## 7. First action
Start with **Cluster A (Service)** — elevate `tpl-service`'s 4 routes from the WP-W2-10-A S1 mockup; iterate with
team_00; produce the elevation package + HANDOFF; then proceed B → E → F. Escalate any new-atom/token need to
team_100 as a GCR before using it.

*Issued by team_100. team_35 leads Track-2 elevation; team_00 co-designs; Eyal signs off at S2.*
