# Archive Manifest: WP-W2-10-F

**archive_date:** 2026-06-03
**archived_by:** team_191 (Git, Archive & File Governance)
**mandate:** team_00 authorization (2026-06-03) per WP closure protocol; authority: ADR042 §step-1 + POST_GATE_ARCHIVE_PROCEDURE v1.1.0, Iron Rule #15
**wp_id:** WP-W2-10-F
**label:** UI Precision — EN landing (tpl-en-landing, LTR mirror)
**milestone:** S003
**status:** DONE
**lod_status:** LOD500_LOCKED
**profile:** L0
**branch:** feature/w2-10-track2 → merged + pushed to `main`
**created_at:** 2026-05-28
**completed_at:** 2026-06-03
**spec_ref:** `_aos/work_packages/S003/WP-W2-10-F/LOD400_IMPL_spec.md`
**parent:** WP-W2-10 (Track-2 elevation; umbrella stays open — siblings C/D superseded by WP-W2-11, G BLOCKED on Eyal hero video)

## Summary

Track-2 design-elevation of the **EN landing** — 1 route (`/en`) on the `tpl-en-landing` template,
an LTR mirror of the Hebrew site. 8-block elevated composition: EN topnav (with language pill →
Hebrew `/`), hero, about, method, services, books row (×3 covers), testimonials (×4), EN footer.
LTR via logical properties only (0 physical left/right in cluster CSS); EN copy verbatim (16/16 key
strings). Run S2 (team_00 sign-off) → S4 (team_80 token-compliance) → S5 L-GATE_BUILD (team_50,
non-Claude) → S5 L-GATE_VALIDATE (team_190, Cursor/Composer cross-engine). Round-1 validate
**FAILed** on a P0 (`/en` served GP default template, not the `tpl-en-landing` shell); the
template-route fix (`ea_w2_08_template_include()`, commit `9d0d313`) closed it and rev2 build +
validate both **PASS**. Cluster code merged + pushed to `main`.

## Clusters / gate

| Cluster | Routes | axe (crit/serious) | LH mobile perf (median ×3) | a11y | L-GATE_VALIDATE | On main |
|---------|--------|--------------------|----------------------------|------|-----------------|---------|
| EN landing (F) | /en | 0/0 | 89 (HTTPS) | 100 | **PASS** (rev2, team_190/Cursor) | ✓ |

## Gate history

| Gate | Owner | Outcome |
|------|-------|---------|
| S2 sign-off | team_00 | `SIGNOFF_S2_WP-W2-10-F_2026-06-02.md` |
| S4 token-compliance | team_80 | `TOKEN-COMPLIANCE-WP-W2-10-F-2026-06-02.md` — **PASS** (cluster CSS 0 physical left/right) |
| S5 L-GATE_BUILD | team_50 (non-Claude) | round-1 then **PASS** (rev2) — `QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03.md` + `...-rev2.md` |
| S5 L-GATE_VALIDATE | team_190 (Cursor/Composer, cross-engine) | round-1 **FAIL** (P0 `/en` default template) → rev2 **PASS** — `VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03.md` + `...-rev2.md` |
| P0 remediation | team_100 / team_10 | `FIX-WP-W2-10-F-TEMPLATE-ROUTE-2026-06-03.md` · commit `9d0d313` |

## Composition notes

LTR mirror via logical properties only; EN copy verbatim (16/16 key strings); language pill →
Hebrew `/` (label "עברית"); `<html>` + `<main>` `dir="ltr" lang="en"`; hreflang en/he/x-default;
3 book covers resolve `ea-eyalamit` HTTP 200; testimonials ×4. Carry-forward (non-blocking):
F-W2-10-F-01 — closing CTAs use `/contact?lang=en` (functional) vs mockup `#contact` anchor —
mandate carry-forward.

## Artifact inventory (archived 2026-07-08 — Phase B sweep, team_110)

Per-team files **relocated** from `_COMMUNICATION/team_*/` into this archive dir (superseding the
2026-06-03 "referenced in place" disposition).

### team_00
- team_00/SIGNOFF_S2_WP-W2-10-F_2026-06-02.md

### team_80 (token-compliance)
- team_80/TOKEN-COMPLIANCE-WP-W2-10-F-2026-06-02.md

### team_100 (remediation, F-exclusive)
- team_100/FIX-WP-W2-10-F-TEMPLATE-ROUTE-2026-06-03.md (commit `9d0d313`)

### team_50 (L-GATE_BUILD verdicts)
- team_50/QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03.md
- team_50/QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03-rev2.md (PASS)

### team_190 (L-GATE_VALIDATE verdicts + post-close reconfirm)
- team_190/VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03.md (round-1 FAIL — P0 /en default template)
- team_190/VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03-rev2.md (PASS)
- team_190/VERDICT-WP-W2-10-F-POSTCLOSE-RECONFIRM-2026-06-03.md (D1 WhatsApp-CTA re-confirm, PASS)

### Spec (unchanged — retained under `_aos/work_packages/`)
- _aos/work_packages/S003/WP-W2-10-F/LOD400_IMPL_spec.md

### Cross-references (physically archived under sibling WPs — not duplicated here)
- `DECISION_WP-W2-10-POST-CLOSURE_2026-06-03_v1.md` (shared A+F; D1=F CTA) → `_archive/WP-W2-10-A/team_00/DECISION_WP-W2-10-POST-CLOSURE_2026-06-03_v1.md`
- `MANDATE-S5-WP-W2-10-ABEF-2026-06-02.md` → `_archive/WP-W2-10-A/team_100/MANDATE-S5-WP-W2-10-ABEF-2026-06-02.md`
- `WP-W2-10-TRACK2-COMPLETION-2026-06-03.md` → `_archive/WP-W2-10-A/team_100/WP-W2-10-TRACK2-COMPLETION-2026-06-03.md`
- `ASSET-PACKAGE-CONFIRM-WP-W2-10-TRACK2-2026-06-02.md` → `_archive/WP-W2-10-A/team_100/ASSET-PACKAGE-CONFIRM-WP-W2-10-TRACK2-2026-06-02.md`
- `PROGRESS-REPORT-WP-W2-10-Track2-2026-06-02.md` → `_archive/WP-W2-10-A/team_100/PROGRESS-REPORT-WP-W2-10-Track2-2026-06-02.md`
- `MANDATE-TEAM190-WP-W2-10-L-GATE-VALIDATE-2026-06-03.md` → `_archive/WP-W2-10-A/team_190/MANDATE-TEAM190-WP-W2-10-L-GATE-VALIDATE-2026-06-03.md`
- `MANDATE-TEAM50-WP-W2-10-L-GATE-BUILD-2026-06-03.md` → `_archive/WP-W2-10-A/team_50/MANDATE-TEAM50-WP-W2-10-L-GATE-BUILD-2026-06-03.md`
- `PREFLIGHT-QA-WP-W2-10-BEF-2026-06-02.md` (shared B/E/F pre-flight) → `_archive/WP-W2-10-B/team_100/PREFLIGHT-QA-WP-W2-10-BEF-2026-06-02.md`

## Path redirects

| Former path (before archive) | Archived path |
|-------------------------------|---------------|
| _COMMUNICATION/team_00/SIGNOFF_S2_WP-W2-10-F_2026-06-02.md | _archive/WP-W2-10-F/team_00/SIGNOFF_S2_WP-W2-10-F_2026-06-02.md |
| _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-F-2026-06-02.md | _archive/WP-W2-10-F/team_80/TOKEN-COMPLIANCE-WP-W2-10-F-2026-06-02.md |
| _COMMUNICATION/team_100/FIX-WP-W2-10-F-TEMPLATE-ROUTE-2026-06-03.md | _archive/WP-W2-10-F/team_100/FIX-WP-W2-10-F-TEMPLATE-ROUTE-2026-06-03.md |
| _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03.md | _archive/WP-W2-10-F/team_50/QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03.md |
| _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03-rev2.md | _archive/WP-W2-10-F/team_50/QA-VERDICT-WP-W2-10-F-L-GATE-BUILD-2026-06-03-rev2.md |
| _COMMUNICATION/team_190/VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03.md | _archive/WP-W2-10-F/team_190/VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03.md |
| _COMMUNICATION/team_190/VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03-rev2.md | _archive/WP-W2-10-F/team_190/VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03-rev2.md |
| _COMMUNICATION/team_190/VERDICT-WP-W2-10-F-POSTCLOSE-RECONFIRM-2026-06-03.md | _archive/WP-W2-10-F/team_190/VERDICT-WP-W2-10-F-POSTCLOSE-RECONFIRM-2026-06-03.md |

---
## Post-closure addendum — 2026-06-03 (team_00 DECISION 1)
`/en` closing CTA (and the hero + services CTAs) retargeted to **WhatsApp** (`wa.me/` +
`EA_WAVE2_WHATSAPP_E164`) with `target="_blank" rel="noopener noreferrer"` + WhatsApp aria-label —
English visitors contact directly (closes carry-forward F-W2-10-F-01). No `/contact?lang=en` refs
remain; axe `/en` 0/0. Commit `d79c23e`. Cluster stays DONE/LOD500_LOCKED; **pending team_190
lightweight cross-engine re-confirm**. See `team_00/DECISION_WP-W2-10-POST-CLOSURE_2026-06-03_v1.md`
(now under `_archive/WP-W2-10-A/`).

*Generated by post-gate archive procedure (team_191) | 2026-06-03*
*Phase B relocation completed by team_110 | 2026-07-08 (Fleet Version-Hygiene Sweep)*
