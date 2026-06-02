---
id: DECISION_WP-W2-10-POST-CLOSURE_2026-06-03
type: decision record (AOS_decide)
wp: WP-W2-10 (post-closure remediations)
decided_by: team_00 (Principal)
recorded_by: team_100
date: 2026-06-03
---

# DECISION — WP-W2-10 post-closure (3 items)

## D1 — F (/en) closing CTA → **WhatsApp**
**Decision:** CTA target = WhatsApp (`https://wa.me/` + `EA_WAVE2_WHATSAPP_E164`), not `/contact?lang=en` or `#contact`.
**Rationale:** English visitors contact directly via WhatsApp — no Hebrew-form barrier, no dead in-page anchor. Closes carry-forward F-W2-10-F-01.
**Implementation:** `ea_w2_08_cta_url()` returns the wa.me URL; all 3 `/en` CTAs gain `target="_blank" rel="noopener noreferrer"` + WhatsApp aria-label. Commit `d79c23e`.

## D2 — A (Service) composition CSS → **relocate to cluster sheet** (optimal long-term, governance-clean)
**Decision:** Move A's composition rules out of the shared `ea-atoms.css` into a dedicated `assets/css/w2-10-service.css` loaded only on the 4 service routes — matching the B/E/F cluster-sheet convention. Do it **properly** (re-verified + cross-engine re-confirm), not as a silent edit of locked work.
**Rationale:** long-term architectural consistency without keeping cluster-specific rules in the shared atoms sheet; "no severe governance deviation" satisfied by S4 re-check + team_190 re-confirm.
**Implementation:** new sheet enqueued via `ea_wave2_service_composition_assets()` (dep `ea-wave2-atoms`, on `is_page(ea_wave2_service_slugs())`); block removed from `ea-atoms.css`. Pure move — zero new tokens/hex/keyframes (S4 re-check PASS); computed-style parity proven on `/treatment` (kicker=`--ea-sand`, `--steps`=4col, disclaimer muted); axe 0/0 all routes. Commit `d79c23e`.

## D3 — Remote merged-branch cleanup → **delete (3A)**
**Decision:** delete the 4 fully-merged remote branches (`origin/chore/bugfix-qa-http`, `origin/chore/s002-closeout`, `origin/feature/s003-track2-A-lod400`, `origin/fix/f-w2-05-01-nav-repair` — all 0 ahead of main), leaving only `main` + `legacy/full-git-history`.

## Governance note
D1/D2 modify clusters that are LOD500_LOCKED (F, A). Per "no severe deviation": changes are (a) re-verified build-side (S4 + pre-flight + computed parity), (b) routed for a **lightweight team_190 cross-engine re-confirm** (A composition unchanged after move; F CTA), (c) recorded here + as addenda on the A/F ARCHIVE_MANIFESTs. Clusters remain DONE; re-confirm affirms the post-closure state.
