---
id: HANDOFF_35_W2-10-B-ELEVATION_2026-06-02_v1
from_team: team_35
to_team: team_10
cluster: B (Editorial)
template: tpl-content
primary_route: /about
fanout_routes: [/press, /about/moksha]
status: READY_FOR_S2
date: 2026-06-02
new_tokens: 0
new_atoms: 0
gcr_flags: 0
---

# HANDOFF — Cluster B (Editorial) elevation → READY_FOR_S2

## Files
- `mockup/editorial-about.html` — elevated hi-fi mockup (`/about`)
- `narrative/elevation-notes.md` — change log + atom mapping
- `assets/asset-manifest.md` — Eyal-gap inventory

## Block order + atom binding
1. `atom-nav-topnav` (current=אודות)
2. **Editorial hero** (Ink) — kicker, H1 "אייל עמית", lead, real portrait split
3. Meta strip — פועל מאז 1999 / cbDIDG / פרדס חנה / שלושה
4. `section-intro` — "משהו בנשימה התחיל את הכל"
5. `breath-divider`
6. `content-section` — "המרכז לטיפול בדיג׳רידו" (lead + body)
7. `content-section--alt` + `.ea-pillar`×6 — **journey timeline**
8. `breath-divider`
9. `content-section` — **Mokesh memorial** (memorial disc 1950–2020 + pullquote)
10. `content-section--alt` — Studio + `book-gallery` (real studio photo)
11. `services-section` — book-cover row + 2 `service-tile` (moksha, books)
12. `contact-section` (Ink) — "רוצים להכיר?"
13. `atom-data-display-footer-social`

## Guardrails (S3)
- Reuse `ea-tokens.css`, `ea-atoms.css`, `ea-blog.css` verbatim. No new tokens/atoms.
- Memorial block is dedicated (not a link) per content decision; treat copy as sensitive.
- Single H1; AA contrast on Ink + bg surfaces; RTL.

## HALT
team_35 stops at S2 → Eyal sign-off → team_10 (S3).
