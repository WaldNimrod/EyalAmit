---
id: UI-PRECISION-WORK-PACKAGES-LOD200-2026-05-28
title: UI-Precision Phase — Canonical Work Packages (LOD200)
status: PLANNED — gated on content-migration completion (W2-02 + W2-06 + content WPs)
date: 2026-05-28
from_team: team_100 (Chief Architect)
to_team: team_00 (Principal — approval) ; team_35 (Design Studio — executor when activated) ; team_10 (refinement) ; team_80 (token compliance)
parent_plan: ./UI-PRECISION-PHASE-PLAN-2026-05-28.md
parent_audits:
  - ./evidence/DESIGN-TEMPLATE-AUDIT-A-deployed-2026-05-28.md
  - ./evidence/DESIGN-TEMPLATE-AUDIT-B-design-deliverables-2026-05-28.md
  - ./evidence/CONTENT-SCOPE-GAP-ANALYSIS-2026-05-28.md
milestone_ref: S003 (UI Precision — new milestone)
track: CONTENT (team_35 mockups) + A (team_10 refinement)
activation_rule: "team_35 activates ONLY by explicit team_00 instruction (governance team_35 §invocation), AFTER first migration stage delivers pages with final content."
profile: L0
---

# UI-Precision Phase — Work Packages (LOD200)

## §0 Phase framing

The Wave2 design SYSTEM (team_80 D-14) is complete; only the **homepage** has a reviewed visual composition. The UI-Precision phase produces per-cluster hi-fi mockups (team_35) → Eyal visual sign-off → team_10 refinement → team_80 token-compliance → team_50/190 QA. Runs **after** content migration so mockups reflect final content.

**New milestone: S003 — UI Precision.** Umbrella `WP-W2-10` with 7 cluster children (`WP-W2-10-A`..`WP-W2-10-G`).

**Activation gating:** team_35 is on-demand (team_00 instruction only). No WP here starts until its content dependency is content-complete on staging.

## §1 Standard structure for every UI-Precision WP

Each cluster WP follows the same 5-stage internal flow (from UI-PRECISION-PHASE-PLAN §3):

| Stage | Owner | Output |
|-------|-------|--------|
| S1 Mockup | team_35 | hi-fi HTML mockup(s) for the cluster on real content |
| S2 Sign-off | team_00 + Eyal | APPROVE / REVISE (the missing visual gate) |
| S3 Refine | team_10 | apply composition deltas to deployed templates (composition-only; atoms/tokens stay D-14) |
| S4 Token-compliance | team_80 | verify no ad-hoc drift from D-14 |
| S5 QA + Validate | team_50 (L-GATE_BUILD) → team_190 (L-GATE_VALIDATE) | cross-engine: Puppeteer axe + Lighthouse triple-run + visual screenshots |

**Cross-engine note:** S5 reuses the Stage-B-locked methodology. Builder (team_10/team_35) ≠ team_50 validator; team_190 = non-cursor/non-claude.

## §2 Work Packages

### WP-W2-10 — UI Precision (umbrella)
- **Goal:** Every non-home route has an Eyal-approved visual composition implemented + validated.
- **Children:** WP-W2-10-A..G.
- **Depends on:** content migration (W2-02, W2-06) content-complete on staging; per-cluster content WPs for commerce/press.
- **Closure:** all children COMPLETE/LOD500_LOCKED.
- **Acceptance:** AC-U0: all 7 clusters signed off by Eyal + validated; AC-U1: zero D-14 token drift across refined templates; AC-U2: every route Lighthouse mobile perf ≥85 + a11y 100 (triple-run); AC-U3: every route axe 0 critical/serious.

---

### WP-W2-10-A — Service cluster UI precision (HIGH)
- **Routes:** `/treatment`, `/method`, `/sound-healing`, `/lessons` (template `tpl-service.php` — currently a STUB with 7 unwired slots).
- **Content source:** W2-02 (treatment, method) + W2-04 (sound-healing, lessons).
- **Scope IN:** hi-fi mockup for the service-page archetype (hero + intro + pillars/steps + testimonials + CTA + related); 4 route instantiations; team_10 wires the 7 D-14 slots.
- **Scope OUT:** new atoms; content rewrite.
- **Depends on:** W2-02 + W2-04 content-complete.
- **AC:** AC-A1 mockup approved by Eyal; AC-A2 all 4 routes render the full slot set (no bare the_content()); AC-A3 token-compliance PASS; AC-A4 QA+validate PASS.
- **Est:** mockup 2d + refine 2d + QA 1d.

### WP-W2-10-B — Editorial cluster UI precision (HIGH)
- **Routes:** `/about`, `/press` (וכתבת), `/about/moksha` (Moksh) (template `tpl-content.php` — STUB).
- **Content source:** W2-02 (about) + W2-07 (press, moksha).
- **Scope IN:** long-form editorial archetype (portrait/bio block + rich body + pullquotes + media gallery + related); 3 route instantiations.
- **Depends on:** W2-02 + W2-07 content-complete.
- **AC:** AC-B1 mockup approved; AC-B2 bio/portrait block real (not placeholder avatar); AC-B3 token-compliance; AC-B4 QA+validate.
- **Est:** mockup 2d + refine 1.5d + QA 1d.

### WP-W2-10-C — Conversion cluster UI precision (MED)
- **Routes:** `/contact` (tpl-contact — REAL but CF7 form_id=0), `/faq` (tpl-faq — REAL, filter UI).
- **Content source:** W2-02.
- **Scope IN:** contact composition (form + WhatsApp A/B variants + trust signals); FAQ composition (category/tag filter polish). Resolve CF7 form_id wiring as part of refinement.
- **Depends on:** W2-02 content-complete + CF7 form configured (Phase-2-adjacent).
- **AC:** AC-C1 mockups approved; AC-C2 CF7 form renders (form_id≠0); AC-C3 FAQ filter UX validated; AC-C4 QA+validate.
- **Est:** mockup 1.5d + refine 1d + QA 0.5d.

### WP-W2-10-D — Blog cluster UI precision (MED)
- **Routes:** `/blog` archive + `/blog/<slug>` single (tpl-blog-archive / tpl-blog-single).
- **Content source:** W2-06 (provides first render to refine from).
- **Scope IN:** archive (pagination + category filter + card grid) + single (article typography + author/date + related posts + share). Refine on top of W2-06's first build.
- **Depends on:** W2-06 COMPLETE.
- **AC:** AC-D1 mockups approved; AC-D2 archive + single match; AC-D3 reading typography validated for long Hebrew posts; AC-D4 QA+validate.
- **Est:** mockup 1.5d + refine 1.5d + QA 1d.

### WP-W2-10-E — Commerce cluster UI precision (HIGH, asset-gated)
- **Routes:** `/books` + 3 book details + `/shop` + 5 product items (tpl-books, tpl-book-detail, tpl-shop-archive, tpl-shop-item).
- **Content source:** W2-03 (books) + W2-05 (shop).
- **Scope IN:** product/book card archetype (cover/image + title + price + Green Invoice CTA); detail archetype (gallery + description + buy CTA + related).
- **Scope OUT (gated):** real cover/product images + Green Invoice links — pending Eyal (mock with placeholders; swap on delivery).
- **Depends on:** W2-03 + W2-05 content-complete; Eyal media + Green Invoice links for final.
- **AC:** AC-E1 mockups approved; AC-E2 catalogue + detail render; AC-E3 placeholder→real asset swap path verified; AC-E4 Green Invoice CTA wired (when links arrive); AC-E5 QA+validate.
- **Est:** mockup 2.5d + refine 2d + QA 1d (+ asset-swap follow-up).

### WP-W2-10-F — EN landing UI precision (HIGH, direction-flip risk)
- **Route:** `/en` (tpl-en-landing — STUB; LTR mirror of the RTL system).
- **Content source:** W2-08.
- **Scope IN:** LTR composition; validate logical-property mirroring (margin-inline, etc.) flips correctly; EN typography.
- **Depends on:** W2-08 content-complete.
- **AC:** AC-F1 mockup approved; AC-F2 LTR layout correct (no RTL bleed); AC-F3 a11y + RTL/LTR mirror QA PASS; AC-F4 QA+validate.
- **Est:** mockup 2d + refine 1.5d + QA 1d.

### WP-W2-10-G — Hero video finalization (BLOCKED on Eyal)
- **Scope:** Replace the CSS-gradient hero placeholder (block-hero.php) with the real Hero=C video treatment per D-14 atom-structure-hero-video.
- **Depends on:** 🔒 Eyal-provided hero video asset.
- **Scope IN:** video element + poster + reduced-motion fallback + overlay text composition + mobile behavior; mockup of the final hero with real video frame.
- **AC:** AC-G1 video plays + poster fallback; AC-G2 reduced-motion serves poster (no autoplay); AC-G3 overlay text legible over video (contrast); AC-G4 mobile data-friendly (preload strategy); AC-G5 QA+validate.
- **Est:** mockup 1d + refine 1d + QA 0.5d (once video arrives).

## §3 Roadmap registration

All 8 WPs (umbrella + A-G) registered in `_aos/roadmap.yaml` under milestone S003 with:
- `status: PLANNED`
- `blocked_by:` their content-migration dependency
- `activation_rule:` team_35 on-demand by team_00 after content-complete

This ensures each WP surfaces at the right stage (post-migration) and is not started prematurely.

## §4 Dependency map (visual)

```
Content migration (S002):
  W2-02 (core content) ──┬──► W2-10-A (service)  [+W2-04]
                         ├──► W2-10-B (editorial) [+W2-07]
                         └──► W2-10-C (conversion)
  W2-06 (blog) ─────────────► W2-10-D (blog)
  W2-03 + W2-05 (books/shop) ► W2-10-E (commerce) [+Eyal assets]
  W2-08 (EN) ───────────────► W2-10-F (EN landing)
  Eyal video 🔒 ────────────► W2-10-G (hero)
                                   │
                                   ▼
                              WP-W2-10 (umbrella) CLOSE → cutover-ready (W2-09)
```

## §5 Sequencing recommendation (per phase plan §7)

1. W2-10-A Service (biggest coverage win)
2. W2-10-B Editorial
3. W2-10-C Conversion (fast — templates already REAL)
4. W2-10-D Blog (after W2-06)
5. W2-10-E Commerce (start mockups; finalize on assets)
6. W2-10-F EN landing (isolate direction-flip risk)
7. W2-10-G Hero (when video arrives)

## §6 team_35 activation note

Per `_aos/governance/team_35.md`: team_35 (Design Studio) is **invoked ONLY by explicit team_00 instruction**, operates in the claude-design sandbox (HTML-first, no git/shell/API from inside), and hands off via `HANDOFF_PACKAGE_*` to `_COMMUNICATION/team_35/[WP-ID]/`. team_100 then folds the mockups into each cluster WP and routes to team_10 for refinement. When team_00 authorizes, team_100 issues a `track: CONTENT` mandate per cluster.

## §7 Version

| Date | Action |
|------|--------|
| 2026-05-28 | LOD200 work packages authored by team_100. Awaiting team_00 approval + activation timing. Content scope verified complete (CONTENT-SCOPE-GAP-ANALYSIS — 16/16 areas, 0 gaps). |
