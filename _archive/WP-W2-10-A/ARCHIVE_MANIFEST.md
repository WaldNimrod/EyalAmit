# Archive Manifest: WP-W2-10-A

**archive_date:** 2026-06-03
**archived_by:** team_191 (Git, Archive & File Governance)
**mandate:** team_00 authorization (2026-06-03) per WP closure protocol; authority: ADR042 §step-1 + POST_GATE_ARCHIVE_PROCEDURE v1.1.0, Iron Rule #15
**wp_id:** WP-W2-10-A
**label:** UI Precision — Service cluster (tpl-service)
**milestone:** S003
**status:** DONE
**lod_status:** LOD500_LOCKED
**profile:** L0
**branch:** feature/w2-10-track2 → merged + pushed to `main`
**created_at:** 2026-05-28
**completed_at:** 2026-06-03
**spec_ref:** `_aos/work_packages/S003/WP-W2-10-A/LOD400_IMPL_spec.md` (also `LOD400_spec.md`)
**parent:** WP-W2-10 (Track-2 elevation; umbrella stays open — siblings C/D superseded by WP-W2-11, G BLOCKED on Eyal hero video)

## Summary

Track-2 design-elevation of the **Service cluster** — 4 routes (`/treatment`, `/method`,
`/sound-healing`, `/lessons`) on the `tpl-service` template. Full 14-block elevated service
composition: cbDIDG 4-step + 5-tile pillar grids, real portrait in the bio-block, service
comparison with active-state tag, mini-FAQ, verbatim disclaimer, contact CTA. Run S2 (team_00
sign-off) → S4 (team_80 token-compliance) → team_100 pre-flight → S5 L-GATE_BUILD (team_50,
non-Claude) → S5 L-GATE_VALIDATE (team_190, Cursor/Composer cross-engine). Round-1 validate
**FAILed** on a P0 (bio portrait 404 — child-theme asset URL resolved via parent theme); the
systemic portrait-URI fix (`get_template_directory_uri()` → `get_stylesheet_directory_uri()`,
commit `407965a`) closed it and rev2 build + validate both **PASS**. Cluster code merged + pushed
to `main`.

## Clusters / gate

| Cluster | Routes | axe (crit/serious) | LH mobile perf (median ×3) | a11y | L-GATE_VALIDATE | On main |
|---------|--------|--------------------|----------------------------|------|-----------------|---------|
| Service (A) | /treatment, /method, /sound-healing, /lessons | 0/0 (4 routes) | 87 (/treatment, /method) | 100 | **PASS** (rev2, team_190/Cursor) | ✓ |

## Gate history

| Gate | Owner | Outcome |
|------|-------|---------|
| S2 sign-off | team_00 | `SIGNOFF_S2_WP-W2-10-A_2026-06-02.md` |
| S4 token-compliance | team_80 | `TOKEN-COMPLIANCE-WP-W2-10-A-2026-06-02.md` — **PASS** (`ea-tokens.css` unchanged) |
| Pre-flight QA | team_100 | `PREFLIGHT-QA-WP-W2-10-A-2026-06-02.md` |
| S5 L-GATE_BUILD | team_50 (non-Claude) | round-1 then **PASS** (rev2) — `QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03.md` + `...-rev2.md` |
| S5 L-GATE_VALIDATE | team_190 (Cursor/Composer, cross-engine) | round-1 **FAIL** (P0 portrait 404) → rev2 **PASS** — `VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03.md` + `...-rev2.md` |
| P0 remediation | team_100 / team_10 | `FIX-WP-W2-10-PORTRAIT-URI-2026-06-03.md` · commit `407965a` |

## Composition notes

14-block elevated service template; cbDIDG 4-step + 5-tile pillar grids; real portrait rendered in
bio-block (`ea-eyalamit/assets/images/eyal-portrait-hero.jpg`, 566×1024); service comparison with
active-state + "הדף הזה" tag; verbatim disclaimer. Non-blocking carry-forwards: F-W2-10-A-01 (mobile
perf median 87 — bar met); F-W2-10-A-02 (composition CSS in `ea-atoms.css` — team_80 noted).

## Artifact inventory (archived 2026-07-08 — Phase B sweep, team_110)

Per-team files **relocated** from `_COMMUNICATION/team_*/` into this archive dir (superseding the
2026-06-03 "referenced in place" disposition — completed per Fleet Version-Hygiene Sweep Phase B).

### team_00
- team_00/SIGNOFF_S2_WP-W2-10-A_2026-06-02.md
- team_00/DECISION_WP-W2-10-POST-CLOSURE_2026-06-03_v1.md (shared A+F — D1=F CTA, D2=A CSS relocate, D3=branch cleanup; primary copy here)

### team_80 (token-compliance)
- team_80/TOKEN-COMPLIANCE-WP-W2-10-A-2026-06-02.md

### team_100 (pre-flight + remediation + cross-cluster Track-2 reports)
- team_100/PREFLIGHT-QA-WP-W2-10-A-2026-06-02.md
- team_100/FIX-WP-W2-10-PORTRAIT-URI-2026-06-03.md (commit `407965a`; shared A/B/E systemic fix — originating WP; primary copy here)
- team_100/MANDATE-S5-WP-W2-10-ABEF-2026-06-02.md (shared A/B/E/F S5-routing mandate; G excluded/BLOCKED; primary copy here)
- team_100/WP-W2-10-TRACK2-COMPLETION-2026-06-03.md (shared A/B/E/F closure report; primary copy here)
- team_100/ASSET-PACKAGE-CONFIRM-WP-W2-10-TRACK2-2026-06-02.md (shared A/B/E/F; primary copy here)
- team_100/PROGRESS-REPORT-WP-W2-10-Track2-2026-06-02.md (shared A/B/E/F; primary copy here)

### team_50 (L-GATE_BUILD verdicts + shared mandate)
- team_50/QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03.md
- team_50/QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03-rev2.md (PASS)
- team_50/MANDATE-TEAM50-WP-W2-10-L-GATE-BUILD-2026-06-03.md (shared A/B/E/F L-GATE_BUILD mandate; G excluded/BLOCKED; primary copy here)

### team_190 (L-GATE_VALIDATE verdicts + post-close reconfirm + shared mandate)
- team_190/VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03.md (round-1 FAIL — P0 portrait 404)
- team_190/VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03-rev2.md (PASS)
- team_190/VERDICT-WP-W2-10-A-POSTCLOSE-RECONFIRM-2026-06-03.md (D2 composition-CSS-move re-confirm, PASS)
- team_190/MANDATE-TEAM190-WP-W2-10-L-GATE-VALIDATE-2026-06-03.md (shared A/B/E/F L-GATE_VALIDATE mandate; G excluded/BLOCKED; primary copy here)

### Spec (unchanged — retained under `_aos/work_packages/`)
- _aos/work_packages/S003/WP-W2-10-A/LOD400_IMPL_spec.md
- _aos/work_packages/S003/WP-W2-10-A/LOD400_spec.md

### NOT moved (ESCALATE — see Phase B sweep report)
- `_COMMUNICATION/team_100/VISUAL-FIDELITY-AUDIT-WP-W2-10-2026-06-03.md` — cited by 3 documents outside this
  archive batch, incl. a 2026-06-21 team_100 session handoff (`HANDOFF_100_DESIGN-PACKAGE_2026-06-21_v1.md`)
  that reads as still-live institutional reference for ongoing design work. Left in place; team_120 to rule.

## Path redirects

| Former path (before archive) | Archived path |
|-------------------------------|---------------|
| _COMMUNICATION/team_00/SIGNOFF_S2_WP-W2-10-A_2026-06-02.md | _archive/WP-W2-10-A/team_00/SIGNOFF_S2_WP-W2-10-A_2026-06-02.md |
| _COMMUNICATION/team_00/DECISION_WP-W2-10-POST-CLOSURE_2026-06-03_v1.md | _archive/WP-W2-10-A/team_00/DECISION_WP-W2-10-POST-CLOSURE_2026-06-03_v1.md |
| _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-A-2026-06-02.md | _archive/WP-W2-10-A/team_80/TOKEN-COMPLIANCE-WP-W2-10-A-2026-06-02.md |
| _COMMUNICATION/team_100/PREFLIGHT-QA-WP-W2-10-A-2026-06-02.md | _archive/WP-W2-10-A/team_100/PREFLIGHT-QA-WP-W2-10-A-2026-06-02.md |
| _COMMUNICATION/team_100/FIX-WP-W2-10-PORTRAIT-URI-2026-06-03.md | _archive/WP-W2-10-A/team_100/FIX-WP-W2-10-PORTRAIT-URI-2026-06-03.md |
| _COMMUNICATION/team_100/MANDATE-S5-WP-W2-10-ABEF-2026-06-02.md | _archive/WP-W2-10-A/team_100/MANDATE-S5-WP-W2-10-ABEF-2026-06-02.md |
| _COMMUNICATION/team_100/WP-W2-10-TRACK2-COMPLETION-2026-06-03.md | _archive/WP-W2-10-A/team_100/WP-W2-10-TRACK2-COMPLETION-2026-06-03.md |
| _COMMUNICATION/team_100/ASSET-PACKAGE-CONFIRM-WP-W2-10-TRACK2-2026-06-02.md | _archive/WP-W2-10-A/team_100/ASSET-PACKAGE-CONFIRM-WP-W2-10-TRACK2-2026-06-02.md |
| _COMMUNICATION/team_100/PROGRESS-REPORT-WP-W2-10-Track2-2026-06-02.md | _archive/WP-W2-10-A/team_100/PROGRESS-REPORT-WP-W2-10-Track2-2026-06-02.md |
| _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03.md | _archive/WP-W2-10-A/team_50/QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03.md |
| _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03-rev2.md | _archive/WP-W2-10-A/team_50/QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03-rev2.md |
| _COMMUNICATION/team_50/MANDATE-TEAM50-WP-W2-10-L-GATE-BUILD-2026-06-03.md | _archive/WP-W2-10-A/team_50/MANDATE-TEAM50-WP-W2-10-L-GATE-BUILD-2026-06-03.md |
| _COMMUNICATION/team_190/VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03.md | _archive/WP-W2-10-A/team_190/VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03.md |
| _COMMUNICATION/team_190/VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03-rev2.md | _archive/WP-W2-10-A/team_190/VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03-rev2.md |
| _COMMUNICATION/team_190/VERDICT-WP-W2-10-A-POSTCLOSE-RECONFIRM-2026-06-03.md | _archive/WP-W2-10-A/team_190/VERDICT-WP-W2-10-A-POSTCLOSE-RECONFIRM-2026-06-03.md |
| _COMMUNICATION/team_190/MANDATE-TEAM190-WP-W2-10-L-GATE-VALIDATE-2026-06-03.md | _archive/WP-W2-10-A/team_190/MANDATE-TEAM190-WP-W2-10-L-GATE-VALIDATE-2026-06-03.md |

---
## Post-closure addendum — 2026-06-03 (team_00 DECISION 2)
Service composition CSS relocated from the shared `ea-atoms.css` into a dedicated
`assets/css/w2-10-service.css` (enqueued only on the 4 service routes; B/E/F cluster-sheet
convention). Pure move — zero new tokens/hex/keyframes (S4 re-check PASS); computed-style
parity proven on `/treatment`; axe 0/0 all 4 routes. Commit `d79c23e`. Cluster stays DONE/LOD500_LOCKED;
**pending team_190 lightweight cross-engine re-confirm** (composition unchanged after the move).
See `team_00/DECISION_WP-W2-10-POST-CLOSURE_2026-06-03_v1.md` (this dir, above).

*Generated by post-gate archive procedure (team_191) | 2026-06-03*
*Phase B relocation completed by team_110 | 2026-07-08 (Fleet Version-Hygiene Sweep)*
