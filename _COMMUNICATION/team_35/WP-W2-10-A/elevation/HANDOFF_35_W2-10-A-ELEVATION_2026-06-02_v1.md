---
id: HANDOFF_35_W2-10-A-ELEVATION_2026-06-02_v1
from_team: team_35
to_team: team_10
cluster: A (Service)
template: tpl-service
primary_route: /treatment
fanout_routes: [/method, /sound-healing, /lessons]
status: READY_FOR_S2
date: 2026-06-02
new_tokens: 0
new_atoms: 0
gcr_flags: 0
---

# HANDOFF — Cluster A (Service) elevation → READY_FOR_S2

## Files
- `mockup/service-treatment.html` — elevated hi-fi mockup (primary `/treatment`)
- `narrative/elevation-notes.md` — change log vs S1 + atom mapping
- `assets/asset-manifest.md` — Eyal-gap inventory + swap paths

## Block order (top → bottom) and atom binding
1. `atom-nav-topnav` — sticky, Ink 72% + blur, current=טיפול
2. `atom-structure-hero-video` (gradient variant) — kicker, H1, subtitle, trust line, CTA pair, 3 breath-lines
3. `atom-structure-section-intro` — "משהו בנשימה שלך מבקש תשומת לב"
4. `breath-divider`
5. `atom-structure-content-section` — "מה זה טיפול בדיג׳רידו"
6. `content-section--alt` + `.ea-pillar`×4 — **cbDIDG 4-step method**
7. `content-section` + `.ea-pillar`×5 — "למי מתאים"
8. `atom-content-bio-block` — "איך נראה מפגש" + **real portrait**
9. `service-comparison` — טיפול / סאונד הילינג / שיעורים (current active)
10. `testimonials-section` ×3 (real quotes) + ghost CTA
11. `faq-mini` ×3 + link to /faq
12. `disclaimer` (legally required, verbatim)
13. `section--cta` (Ink) — "לתיאום שיחת היכרות"
14. `atom-data-display-footer-social`

## Implementation guardrails (S3 = team_10)
- Reuse D-14 sheets verbatim: `ea-tokens.css`, `ea-atoms.css`, `w2-04-service.css`. **No new token values, no new atoms.**
- Motion is OFF in this mockup by design — live motion is added at the build layer per `ea-animations.css` (stagger tokens).
- Single H1. AA contrast (`--ea-text-body` on `--ea-bg`). RTL (`dir="rtl" lang="he"`).
- Fan-out the 3 sibling routes from this shell (see elevation-notes §"Route fan-out").

## HALT
team_35 stops at S2. No template edits, no deploy, no self-validation. → Eyal sign-off → team_10 (S3).
