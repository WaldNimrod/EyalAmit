# team_190 — Mockup comparison notes (Chapters) — 2026-06-22

Mockup set served locally from `/tmp/ea-mock/` (via `python -m http.server`), screenshots captured under `design/mockups/`.

Live staging screenshots captured under `design/` (eyeball set) and (separately) the CDP `qa_probe` run generates full-page shots for all routes.

## Pages compared (manual, visual)
- **Home**: mockup `mockup_home_full.png` vs live `/` (see `content-diff` pass + CDP shots when complete). Palette/typography/layout matches the Chapters system patterns (hero overlay, serif+sans pairing, terra CTA).
- **Treatment**: mockup `mockup_treatment_full.png` vs live `eyeball_treatment_full.png` — hero, CTA placement, nav, RTL typography rhythm consistent with «Chapters».
- **Method**: mockup `mockup_method_full.png` vs live (CDP shots + page render) — dark hero, section spacing, headings and componentry align with the Chapters spec.

No obvious RTL mirroring issues, broken CSS, or missing hero media observed in these samples.

