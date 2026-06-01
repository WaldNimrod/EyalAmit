# LOD400 Spec — WP-W2-11
# S003 Base Implementation (Hybrid Track-1) — settled clusters → deployed templates

**WP ID:** WP-W2-11 | **Milestone:** S003 | **Track:** A (implementation) | **Profile:** L0
**Owner:** team_100 (orchestration) | **Builder:** team_10 | **Tokens:** team_80 | **QA:** team_50 → **Validate:** team_190 (Codex)
**Authored:** 2026-06-01 (team_100) | **lod_status:** LOD400 | **status:** PLANNED
**Decision basis:** `_COMMUNICATION/team_00/DECISION_DESIGN-ELEVATION-SEQUENCING_2026-06-01_v1.md` (Option C — hybrid)
**Process SSoT:** `_COMMUNICATION/team_100/UI-PRECISION-PHASE-PLAN-2026-05-28.md`

## Objective
Implement the **settled / low-visual-risk clusters now** — the hybrid Track-1 "base" — to ship a working,
QA-clean spine, **without** a team_35 elevation pass (these are already POC-reviewed or use REAL templates).
The high-visual clusters (A/B/E/F) are **out of scope** here — they take the team_35 elevation path under
WP-W2-10 (Track-2).

## Scope — base clusters (IN)
| Cluster | Routes | Template(s) | Source of truth (composition) | Note |
|---------|--------|-------------|-------------------------------|------|
| **Home** | `/` | `tpl-home.php` + `template-parts/blocks/*` | POC-reviewed comp (deployed) | refine only; hero = interim net placeholder until Eyal video (G) |
| **Conversion (C)** | `/contact`, `/faq` | `tpl-contact.php`, `tpl-faq.php` (REAL) | `_COMMUNICATION/team_35/WP-W2-10-C/` mockups + composition-notes | CF7 `form_id` Eyal-dependent → graceful placeholder |
| **Blog (D)** | `/blog`, `/blog/<slug>` | `tpl-blog-archive.php`, `tpl-blog-single.php` | `_COMMUNICATION/team_35/WP-W2-10-D/` mockups + composition-notes | featured images Eyal-dependent → gradient placeholder |

## Out of scope (Track-2 — separate, via WP-W2-10 + team_35)
A Service · B Editorial · E Commerce · F EN landing → team_35 elevation → Eyal sign-off → implement.
G Hero video → BLOCKED (Eyal asset). These do NOT execute under WP-W2-11.

## Execution flow (per base cluster) — S3 → S4 → S5 (S1/S2 already satisfied)
| Stage | Owner | Output |
|-------|-------|--------|
| S3 Refine/implement | team_10 | apply the composition deltas from the S1 mockups + composition-notes to the **deployed** templates. **Composition-only** — D-14 atoms/tokens unchanged. Deploy to staging via `scripts/ftp_deploy_site_wp_content.py`. |
| S4 Token-compliance | team_80 | verify zero ad-hoc drift from D-14 (no raw hex / new atoms / ad-hoc CSS). |
| S5 QA → Validate | team_50 (L-GATE_BUILD, non-Claude) → team_190 (L-GATE_VALIDATE, Codex) | axe + Lighthouse **over HTTP** (staging is HTTP-only — EYAL_ENV_VARS_REFERENCE §44) via `scripts/qa/http-qa-axe.cjs` + `http-qa-lighthouse.sh`; visual screenshots; cross-engine. |

## Cross-engine (IR#1 + IR#5)
Builder **team_10** ≠ **team_50** (non-Claude build-gate) ≠ **team_190** (native Codex, final validate). Every
NON-Claude gate gets a paste-ready prompt (team_00 directive). Final validation owned by team_190 (immutable).

## Acceptance Criteria
- **AC-01** Each base route's composition matches its approved S1 mockup (Home: POC comp; C/D: the team_35 mockups), composition-only.
- **AC-02** Zero D-14 token drift across the refined templates (team_80 verified).
- **AC-03** axe-core: **0 critical / 0 serious** on every base route (`http-qa-axe.cjs`).
- **AC-04** Lighthouse (HTTP): a11y **100** (≥97 documented if a known moderate), perf **≥85**; SEO/BP staging-capped (→100 at cutover).
- **AC-05** Eyal-dependent gaps degrade gracefully: `/contact` CF7 `form_id=0` shows the placeholder (no fatal), blog posts without featured images show the gradient placeholder — no broken UI, no console errors.
- **AC-06** No regressions: `validate_aos.sh` 0 FAIL + `scripts/final_pre_cutover_check.sh` exit 0 + `php -l` clean on touched PHP.
- **AC-07** Deployed to staging + verified live over HTTP (cache-busted); per-route HTTP 200.

## Dependencies
- S1 mockups + composition-notes (DONE) — `_COMMUNICATION/team_35/WP-W2-10-{C,D}/`.
- Bug-fix + HTTP-QA baseline (DONE, on main) — `_COMMUNICATION/team_100/BUGFIX-SWEEP-AND-HTTP-QA-2026-06-01.md`; QA tooling `scripts/qa/`.
- Eyal content (CF7 form, blog featured images, WhatsApp #) — **parallel, non-blocking**; tracked on the hub `materials-intake` page; placeholders bridge (AC-05).

## Roadmap-mutation / SSoT
ADR034 offline-fallback (named branch, never main; file `roadmap.yaml` = live SSoT; API hangs — item #1 closed
per `DISPOSITION-MSG-HUB-20260530-001-CLOSE-2026-05-31`). Re-probe API before any API-only mutation.

## Gate sequence
L-GATE_SPEC (this doc) → S3 build → S4 tokens → S5 L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190) → CLOSE.

## Carry-forwards into S3 (from the bug-fix sweep, NEEDS-DECISION/P3)
- Homepage hero `<br>` vs dash (NEEDS-DECISION) · blog featured-image strategy + empty categories + share/related (team_80 GCR) · FAQ empty-category handling · Yoast author nicename (`eyaladmin→eyal-amit`) + `/author/` 301 · legacy `/tools-and-accessories/repair/` 301. Resolve during S3 of the relevant cluster.
