---
id: HANDOFF_35_W2-10-F-ELEVATION_2026-06-02_v1
from_team: team_35
to_team: team_10
cluster: F (EN landing)
template: tpl-en-landing
route: /en
direction: LTR mirror of RTL system
status: READY_FOR_S2
date: 2026-06-02
new_tokens: 0
new_atoms: 0
gcr_flags: 0
---

# HANDOFF — Cluster F (EN landing) elevation → READY_FOR_S2

## Files
- `mockup/en-landing.html` — elevated LTR landing
- `narrative/elevation-notes.md`, `assets/asset-manifest.md`

## Block order
1. topnav (LTR, lang pill → /) · 2. **hero (kicker + gradient + breath-lines)**
3. About · 4. Method (principles list) · 5. Services (3 paths)
6. **Books (real cover row + prose)** · 7. Testimonials ×4 + closing CTA · 8. footer

## LTR mirror checklist (verify at S3)
- [ ] `dir="ltr" lang="en"` on html + main
- [ ] logical props only (`inset-inline-start`, `padding-inline-start`, `justify-content:flex-start`)
- [ ] language pill links to Hebrew `/`
- [ ] EN copy VERBATIM from team_30 W2-08 source

## Guardrails (S3)
- Reuse `ea-tokens.css`, `ea-atoms.css`, `w2-08-en-landing.css` verbatim. No new tokens/atoms.
- Single H1; AA contrast; reduced-motion respected.

## HALT — team_35 stops at S2 → Eyal sign-off → team_10 (S3).
