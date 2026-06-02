# LOD400 — WP-W2-10-A · Service template FULL IMPLEMENTATION (post-elevation)

**WP:** WP-W2-10-A | **Milestone:** S003 | **Parent:** WP-W2-10 (Track-2) | **Priority:** HIGH | **Profile:** L0
**Builder:** team_10 (S3) | **Tokens:** team_80 (S4) | **QA:** team_50 (S5 build) → **Validate:** team_190 (Cursor, cross-engine)
**Authored:** 2026-06-02 (team_100) | **lod_status:** LOD400 (implementation-grade)
**Supersedes** the S3 section of `_aos/work_packages/S003/WP-W2-10-A/LOD400_spec.md` (2026-05-29, pre-elevation).
**Source of truth (composition):** `_COMMUNICATION/team_35/WP-W2-10-A/elevation/` —
`mockup/service-treatment.html` + `narrative/elevation-notes.md` + `assets/asset-manifest.md` + HANDOFF (READY_FOR_S2, 0 new tokens/atoms, 0 GCR).
**Real assets:** `_COMMUNICATION/team_35/handoff-WP-W2-10-Track2/shared-assets/` (portrait, covers, gallery, logo, hero-wide).

## 0. Objective
Turn `tpl-service.php` — currently an **empty stub** (`<!-- SLOT … -->` comments + bare `the_content()`) — into the
team_35-elevated flagship composition, wired across all **4 service routes** (`/treatment`, `/method`,
`/sound-healing`, `/lessons`), composition-only on D-14. This is the lead Track-2 template; it sets the pattern B/E/F follow.

## 1. Gate position (READ FIRST)
Package is **READY_FOR_S2 (Eyal sign-off)**. Per the Track-2 decision, **S2 Eyal approval is the gate before S3 build.**
This LOD400 specifies the S3 implementation; team_10 executes it **after** S2 sign-off is recorded.

## 2. Implementation architecture (mirror the Home pattern)
Replace the stub body with a **route-aware render function**, mirroring `ea_wave2_render_home_blocks()` in
`inc/wave2-stage-b.php` (L177). Add `ea_wave2_render_service_blocks( $route_ctx )` in a service provider
(`inc/wave2-w2-03.php` / `wave2-w2-04.php` already hold the service content — extend, don't duplicate):
- Resolve `$route_ctx` from the current page slug (treatment | method | sound-healing | lessons).
- `tpl-service.php` body becomes: `get_header()` → `block-topnav` → `<main id="main" class="ea-wave2-service">` →
  `ea_wave2_render_service_blocks( ea_wave2_service_ctx() )` → `</main>` → `block-footer-social` → `get_footer()`.
- Each block is a `get_template_part('template-parts/blocks/block', <slug>)`; content comes from the route context +
  the W2-03/W2-04 datasets (`inc/wave2-w2-03-content.php`, `wave2-w2-04-content.php`) — **no content rewrite**.
- **Single H1** (hero title) per route; all section titles H2; pillars H3.

## 3. Block sequence (14) — mapping to existing partials + content source
Order is verbatim from the elevated mockup (HANDOFF §"Block order"). Reuse existing partials; where a block needs
service-specific content, parametrize the partial (do NOT fork a new atom).

| # | Block | Existing partial / atom | Action |
|---|-------|------------------------|--------|
| 1 | Hero (gradient variant) — kicker + H1 + subtitle + trust line + **CTA pair** (`--primary` + `--ghost-white`) + 3 breath-lines | `block-hero.php` (`atom-structure-hero-video`) | parametrize for service ctx (kicker/title/sub/trust/CTAs per route); gradient bg (G video blocked) |
| 2 | Section-intro ("משהו בנשימה שלך…") | `block-intro.php` (`atom-structure-section-intro`) | route copy |
| 3 | breath-divider | `block-breath-divider-1.php` | reuse |
| 4 | Content-section ("מה זה טיפול בדיג׳רידו") | `atom-structure-content-section` (in `block-intro`/inline) | route copy |
| 5 | **cbDIDG 4-step method** — `content-section--alt` + `.ea-pillar`×4 (אבחון→תרגול→שליטה→הטמעה) in a 4-col `--steps` grid | `block-method-pillars.php` (`.ea-pillar`) | extend to a 4-step variant via existing grid+`--ea-space` tokens (NO new atom — see §4) |
| 6 | **"למי מתאים"** — `.ea-pillar`×5 tile grid | `block-method-pillars.php` / `.ea-pillar` grid | 5-tile variant, route copy |
| 7 | Bio-block ("איך נראה מפגש") + **real portrait** | `atom-content-bio-block` (new partial if absent — compose from existing atoms) | wire `eyal-portrait-hero.jpg` (see §5) |
| 8 | Service-comparison (טיפול / סאונד הילינג / שיעורים; current active) | `block-treatment-overview.php` (`service-comparison`) | mark current route active |
| 9 | Testimonials ×3 (real quotes) + ghost CTA | `block-testimonials-row.php` | avatar = sand-circle placeholder (Eyal gap) |
| 10 | FAQ-mini ×3 + link `/faq` | `block-faq-mini.php` | route copy |
| 11 | Disclaimer (legally required, **verbatim**) | inline (`disclaimer` atom) | verbatim from staging |
| 12 | CTA band (Ink) — "לתיאום שיחת היכרות" | `block-contact-cta.php` (`section--cta`) | reuse |
| 13 | footer-social | `block-footer-social.php` | chrome |

If `atom-content-bio-block` has no partial yet, **compose it from existing atoms** (image + prose + container
classes) — it is NOT a new atom; do not add tokens. If truly impossible without a new atom/token → **GCR to team_100**.

## 4. The two "new emphasis" compositions — composition-only proof
- **cbDIDG 4-step grid (`--steps`)** and **"who it's for" 5-tile grid** reuse `.ea-pillar` + existing grid/`--ea-space`
  token values (team_35 confirmed: 0 new tokens/atoms, 0 GCR). team_10 implements them as grid-column-count
  variations using **existing** tokens; team_80 verifies zero drift at S4.

## 5. Real-asset wiring (closes Eyal-gaps)
- Move `shared-assets/eyal-portrait-hero.jpg` → theme media (`site/wp-content/themes/ea-eyalamit/assets/images/`)
  and reference via theme URL in the bio-block (block #7). Target: portrait crop per asset-manifest.
- **Eyal-gap placeholders kept graceful:** testimonial avatars = neutral sand circle (`.ea-testimonial-card__avatar-placeholder`,
  design-acceptable); hero media = gradient (G video blocked). No shadows/gradients beyond the existing hero gradient.
- (Book covers + gallery in shared-assets are for clusters E/B — out of scope here; leave in the package.)

## 6. Route fan-out (1 shell → 4 routes)
Same elevated shell; swap section copy per route from staging + W2-03/W2-04 datasets:
- `/treatment` (primary) + `/method` → cbDIDG 4-step most relevant.
- `/lessons` → musical-progression framing of the steps.
- `/sound-healing` → passive-session framing.
Each route: single H1, correct service-comparison active state, route-appropriate FAQ/CTA.

## 7. Acceptance Criteria
- **AC-A1** S2 Eyal sign-off recorded before S3.
- **AC-A2** All 4 routes render the full 14-block elevated composition — **no bare `the_content()` fallback**; matches `service-treatment.html` (composition-only).
- **AC-A3** Zero D-14 drift (team_80): no new tokens/atoms, no raw hex, no inline styles (entrance stagger via `ea-animations.css` per the WP-W2-13 pattern).
- **AC-A4** axe 0 critical / 0 serious on all 4 routes.
- **AC-A5** Lighthouse (https, production-representative per WP-W2-11 disposition): a11y 100; mobile perf ≥85 (triple-run median) on the primary `/treatment` (+ spot-check 1 sibling).
- **AC-A6** Graceful Eyal-gaps (sand-circle avatars; gradient hero) — no broken UI / console errors; real portrait live.
- **AC-A7** `validate_aos` 0 FAIL; `php -l` clean; per-route HTTP 200; single H1/route; RTL logical props.

## 8. Build sequence (team_10, S3)
1. Add `assets/images/eyal-portrait-hero.jpg` to the theme; confirm media path.
2. Author `ea_wave2_render_service_blocks()` + `ea_wave2_service_ctx()` (route resolver) in the W2-03/04 provider; rewrite `tpl-service.php` body to call it (chrome + main wrapper).
3. Wire blocks 1–13 in order, parametrized per route; implement the cbDIDG 4-step + 5-tile pillar grids (existing tokens).
4. Wire the real portrait into the bio-block; keep avatar/hero placeholders graceful.
5. `php -l` clean; deploy via `scripts/ftp_deploy_site_wp_content.py`; self-smoke all 4 routes HTTP 200 + visual parity vs mockup (NO axe/LH self-validation — S5 owns it).
6. Surgical per-file commits on a named branch (never main).

## 9. Gate sequence + downstream (paste-ready)
L-GATE_SPEC (this) → **S2 Eyal sign-off** → S3 (team_10, §8) → S4 team_80 token-compliance → S5 team_50 L-GATE_BUILD
(axe http + LH **https**) → team_190 L-GATE_VALIDATE (**run in Cursor**, cross-engine) → close.
- **S4 → team_80:** verify zero D-14 drift across tpl-service + new render fn + grids (greps: raw hex, inline `style=`, new `--ea-*`/atoms); confirm cbDIDG/5-tile grids use existing tokens. Verdict → `_COMMUNICATION/team_80/`.
- **S5 → team_50:** `node scripts/qa/http-qa-axe.cjs /treatment/ /method/ /sound-healing/ /lessons/` + `bash scripts/qa/http-qa-lighthouse.sh /treatment/ /method/` (perf on https). PASS: axe 0/0 all routes; LH a11y 100 / mobile perf ≥85 median. Verdict → `_COMMUNICATION/team_50/`.
- **S5 → team_190 (Cursor):** verify all 4 routes vs the elevated mockup, zero drift, axe/LH bars, single H1, RTL, graceful gaps; mobile-axis perf; PASS/FAIL → `_COMMUNICATION/team_190/`.

## 10. Risks / carry-forwards
- Route fan-out content gaps (a sibling route missing copy on staging) → use the W2-03/04 dataset; flag any true content gap to team_00 (non-blocking; placeholder bridge).
- `atom-content-bio-block` may need a new partial file (composition of existing atoms — allowed; a new *atom/token* is not — GCR if needed).
- Production-cutover: SEO/BP→100 + hero video (G) swap remain post-WP carry-forwards.

## 11. Note on B/E/F
The elevation package also delivered B (Editorial/`tpl-content`), E (Commerce/books+shop), F (EN landing). Each gets
its own implementation-grade LOD400 following this template's pattern. Sequence after A per team_00.
