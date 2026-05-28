Engine: native Codex/GPT-5 (OpenAI Codex), not Claude.

# VERDICT — Wave2 LOD400 Specs L-GATE_SPEC

date: 2026-05-28
timezone: Asia/Jerusalem
validator: team_190 constitutional validator
repo: `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`
branch_observed: `feature/w2-06-blog`
commit_observed: `f497e3f`
mandate: `_COMMUNICATION/team_190/MANDATE-TEAM190-WAVE2-SPECS-L-GATE-SPEC-2026-05-28.md`
scope: WP-W2-03, WP-W2-04, WP-W2-05, WP-W2-07, WP-W2-08, WP-W2-09

## Executive Verdict

| WP | Spec | Verdict | Blocking reason / status |
|----|------|---------|--------------------------|
| WP-W2-03 | Books | PASS_WITH_FINDINGS | Implementable; source paths resolve. Correct roadmap LOD drift and make Green Invoice fallback AC explicit before dispatch. |
| WP-W2-04 | Sound Healing + Lessons | PASS_WITH_FINDINGS | Implementable; source paths resolve. Correct A/B CTA and testimonial dependency references before dispatch. |
| WP-W2-05 | Shop | BLOCKED | One 25.5.26 source path is written with ellipsis and is not literally resolvable; CTA/A-B purchase contract is underspecified. |
| WP-W2-07 | Press + Moksha + QR + FB testimonials | BLOCKED | Press, QR content, and FB testimonial source contracts are unresolved/ambiguous; `/press` routing is ambiguous. |
| WP-W2-08 | EN landing | BLOCKED | No final EN content artifact or exact URL choice; a fresh builder must author/guess content and hreflang targets. |
| WP-W2-09 | Cutover prep | BLOCKED | Mapping/script artifacts are unresolved or missing; media inventory count conflicts with spec; redirect rule count/source is ambiguous. |

Final routing: Wave2 orchestration handoff is **NOT CLEARED**. WP-W2-03 and WP-W2-04 may be corrected in place without re-validating as blockers. WP-W2-05, WP-W2-07, WP-W2-08, and WP-W2-09 require team_100 correction and re-submission to L-GATE_SPEC.

## Validation Evidence

| Check | Result | Evidence |
|-------|--------|----------|
| Mandate engine constraint | PASS | This verdict was authored by native Codex/GPT-5, not Claude. |
| Core AOS validation | PASS | `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` returned `RESULT: 30 PASS / 18 SKIP / 0 FAIL`. |
| W2-02 precedent | PASS | `_COMMUNICATION/team_190/VERDICT-WP-W2-02-L-GATE-VALIDATE-2026-05-28.md` records W2-02 PASS and documents the required `template_include` priority 100 + `ea_wave2_shell` pattern. |
| D-14 / template surface | PASS | `site/wp-content/themes/ea-eyalamit/inc/wave2-stage-b.php` already lists `tpl-books.php`, `tpl-book-detail.php`, `tpl-shop-archive.php`, `tpl-shop-item.php`, `tpl-en-landing.php`; templates exist under `site/wp-content/themes/ea-eyalamit/page-templates/`. |
| Source directory inventory | PASS_WITH_FINDINGS | 25.5.26 source folder exists with all listed 03/04 sources and most 05 sources; WP-W2-05 line 17 uses an ellipsis path that is not a literal file path. |
| Roadmap dependency state | PASS_WITH_FINDINGS | `_aos/roadmap.yaml` resolves all six `spec_ref`s. WP-W2-03 still has `lod_status: LOD200` while its spec says `LOD400`. WP-W2-09 correctly depends on W2-01..W2-08. |
| LOD helper script | INFO | `validate_lod.sh --all --min-lod 400` failed with a repository-root path bug (`_aos/_aos/work_packages`). Not used as dispositive evidence. |

## Per-Spec Verdicts

### WP-W2-03 — Books

Verdict: **PASS_WITH_FINDINGS**

| Criterion | Result | Notes |
|-----------|--------|-------|
| Implementability | PASS_WITH_FINDINGS | Page list, URLs, templates, block contract, router pattern, D-14 reuse, and ACs are sufficient for implementation. |
| Content-source path resolution | PASS | All four paths under `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/` exist: `מוזה הוצאה לאור - ספרים/MUZZA.md`, `וכתבת/vekatavta.md`, `כושי בלאנטיס/kushi_full.md`, `צבע בכחול וזרוק לים/eyal_tsva_FINAL.md`. |
| Cross-cutting correctness | PASS | Uses W2-02 `template_include` priority 100 pattern, `ea_wave2_shell`, D-14 tokens, branch-isolated `inc/wave2-w2-03.php`. |
| AC measurability | PASS | Six measurable ACs are present. |
| Scope/dependency integrity | PASS_WITH_FINDINGS | Depends on W2-02 COMPLETE; out-of-scope is clean. Roadmap still says `lod_status: LOD200` for WP-W2-03. |

Corrections:

| ID | Severity | Correction | evidence-by-path | route_recommendation |
|----|----------|------------|------------------|----------------------|
| T190-W2SPEC-03-F01 | P2 / NON-BLOCKING | Align `_aos/roadmap.yaml` WP-W2-03 `lod_status` from `LOD200` to `LOD400`, or explicitly mark that L-GATE_SPEC has not yet promoted it. | `_aos/roadmap.yaml`; `_aos/work_packages/S002/WP-W2-03/LOD400_spec.md:6` | team_100 roadmap correction before dispatch. |
| T190-W2SPEC-03-F02 | P3 / NON-BLOCKING | AC-03 requires Green Invoice new-tab + GA4, but dependencies allow placeholder `#`. Add a measurable fallback AC: if links are absent, button must route to approved contact/form URL, not `#`, and GA4 event must still fire. | `_aos/work_packages/S002/WP-W2-03/LOD400_spec.md:34`; `_aos/work_packages/S002/WP-W2-03/LOD400_spec.md:44` | team_100 spec clarification; no re-validation needed if changed exactly. |

### WP-W2-04 — Sound Healing + Lessons

Verdict: **PASS_WITH_FINDINGS**

| Criterion | Result | Notes |
|-----------|--------|-------|
| Implementability | PASS_WITH_FINDINGS | Two URLs, template, source paths, 10-block contract, router pattern, D-14 reuse, and six ACs are present. |
| Content-source path resolution | PASS | `סאונדהילינג/sound_healing_final.md` and `שיעורי נגינה/lesons.md` both exist under the 25.5.26 source directory. |
| Cross-cutting correctness | PASS | Reuses W2-02 `template_include`, `ea_wave2_shell`, body class, D-14 tokens. |
| AC measurability | PASS_WITH_FINDINGS | Six ACs are measurable, except CTA "per A/B variant" lacks exact source/reference. |
| Scope/dependency integrity | PASS | Depends on W2-02; W2-07 soft-dep for final testimonial images is explicit and non-blocking. |

Corrections:

| ID | Severity | Correction | evidence-by-path | route_recommendation |
|----|----------|------------|------------------|----------------------|
| T190-W2SPEC-04-F01 | P3 / NON-BLOCKING | Add the canonical A/B CTA reference or exact CTA behavior for each page: form target, WhatsApp target, tracking event, and which variant is expected at build time. | `_aos/work_packages/S002/WP-W2-04/LOD400_spec.md:18`; `_aos/work_packages/S002/WP-W2-04/LOD400_spec.md:28` | team_100 spec clarification before build. |
| T190-W2SPEC-04-F02 | P3 / NON-BLOCKING | State whether testimonial placeholder images are acceptable for L-GATE_BUILD only or also L-GATE_VALIDATE if W2-07 remains incomplete. | `_aos/work_packages/S002/WP-W2-04/LOD400_spec.md:6`; `_aos/work_packages/S002/WP-W2-04/LOD400_spec.md:27` | team_100 dependency note; no blocker. |

### WP-W2-05 — Shop

Verdict: **BLOCKED**

| Criterion | Result | Notes |
|-----------|--------|-------|
| Implementability | BLOCKED | Product list and templates are present, but CTA behavior and price/admin source are not precise enough for a fresh builder. |
| Content-source path resolution | BLOCKED | Four product sources resolve; line 17 uses `סטנד רצפתי.../stend for playing.md`, which is not a literal path. The actual path appears to be `סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md`. |
| Cross-cutting correctness | PASS | Uses W2-02 infra, `ea_wave2_shell`, D-14 templates, no WooCommerce/cart. |
| AC measurability | PASS_WITH_FINDINGS | Six ACs exist, but AC-04 references "Green Invoice / form (per A/B variant)" without exact routing or event name. |
| Scope/dependency integrity | PASS | Depends on W2-02; out-of-scope excludes WooCommerce/cart and non-25.5.26 products. |

Required corrections:

| ID | Severity | Correction | evidence-by-path | route_recommendation |
|----|----------|------------|------------------|----------------------|
| T190-W2SPEC-05-B01 | P1 / BLOCKING | Replace the ellipsis source with the exact resolvable path: `סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md`. | `_aos/work_packages/S002/WP-W2-05/LOD400_spec.md:17`; source exists under `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md` | team_100 correction + re-submit WP-W2-05 to L-GATE_SPEC. |
| T190-W2SPEC-05-B02 | P2 / BLOCKING | Make purchase/contact behavior deterministic per product: Green Invoice URL if known, fallback form URL if unknown, target/new-tab rule, and GA4 event name. "per A/B variant" is not enough for LOD400. | `_aos/work_packages/S002/WP-W2-05/LOD400_spec.md:22`; `_aos/work_packages/S002/WP-W2-05/LOD400_spec.md:31` | team_100 add CTA matrix; re-submit with B01. |
| T190-W2SPEC-05-F03 | P3 / NON-BLOCKING | Identify the exact admin/meta field for Eyal-entered prices, or state that prices are hardcoded fallback values until C3. | `_aos/work_packages/S002/WP-W2-05/LOD400_spec.md:25`; `_aos/work_packages/S002/WP-W2-05/LOD400_spec.md:30` | team_100 spec clarification. |

### WP-W2-07 — Press + Moksha + QR + FB Testimonials

Verdict: **BLOCKED**

| Criterion | Result | Notes |
|-----------|--------|-------|
| Implementability | BLOCKED | The spec combines four content domains but leaves multiple source/extraction decisions open. |
| Content-source path resolution | BLOCKED | `מוקש דהימן/ומה היום.docx` exists, and `QR-URL-INVENTORY.csv` exists. Press source is "legacy `/qr-press` or equiv", QR content source is not mapped to an export/file, and FB testimonials are "text from 25.5.26" although no exact 25.5.26 testimonial path is specified. |
| Cross-cutting correctness | PASS_WITH_FINDINGS | Reuses W2-02/D-14 and `ea_wave2_shell`, but says route via `template_include` / page templates "as appropriate" without defining which for `/press`, `/about/moksha`, and 49 QR pages. |
| AC measurability | PASS | Five measurable ACs exist. |
| Scope/dependency integrity | PASS_WITH_FINDINGS | Depends on W2-02; out-of-scope is clean. However, FB image-fetch from Facebook is an external acquisition dependency and should be declared as such. |

Required corrections:

| ID | Severity | Correction | evidence-by-path | route_recommendation |
|----|----------|------------|------------------|----------------------|
| T190-W2SPEC-07-B01 | P1 / BLOCKING | Replace "extract press articles from legacy (`/qr-press` or equiv)" with an exact source artifact/path and target routing decision. If `/press` is the URL, remove "(or section under `/about`)". | `_aos/work_packages/S002/WP-W2-07/LOD400_spec.md:14` | team_100 correction + re-submit WP-W2-07. |
| T190-W2SPEC-07-B02 | P1 / BLOCKING | Add an exact QR content source map for all 49 QR pages. `QR-URL-INVENTORY.csv` resolves the URL inventory, not the page body/images/structure required for 1:1 migration. | `_aos/work_packages/S002/WP-W2-07/LOD400_spec.md:16`; `docs/project/team-100-preplanning/QR-URL-INVENTORY.csv` | team_100 add QR content export/path and image source policy; re-submit. |
| T190-W2SPEC-07-B03 | P1 / BLOCKING | Add the canonical testimonial source artifact: exact file/path or explicit instruction to use `_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/` legacy testimonial catalog. "text from 25.5.26" is not resolvable. | `_aos/work_packages/S002/WP-W2-07/LOD400_spec.md:17`; 25.5.26 source inventory lacks a testimonial `.md` file | team_100 source correction + re-submit. |
| T190-W2SPEC-07-B04 | P2 / BLOCKING | Define route/template plan per item: `/press`, `/about/moksha`, and `/qr/qrN/`, including whether QR pages are seeded WP pages, custom rewrite/template router entries, or imported legacy pages. | `_aos/work_packages/S002/WP-W2-07/LOD400_spec.md:26` | team_100 implementation contract correction. |
| T190-W2SPEC-07-F05 | P3 / NON-BLOCKING | Declare FB profile-photo download as an external dependency with a fallback if Facebook fetch is blocked. | `_aos/work_packages/S002/WP-W2-07/LOD400_spec.md:23` | team_100 dependency note. |

### WP-W2-08 — English Landing Page

Verdict: **BLOCKED**

| Criterion | Result | Notes |
|-----------|--------|-------|
| Implementability | BLOCKED | The page requires authoring English content from "25.5.26 essence" but provides no final EN source, owner handoff artifact, or copy acceptance contract. |
| Content-source path resolution | BLOCKED | No exact 25.5.26 `.md` paths are listed for source pages/sections; no team_30 EN content artifact is referenced. |
| Cross-cutting correctness | PASS_WITH_FINDINGS | D-14 and `ea-wave2-shell` are listed. URL and hreflang targets are ambiguous. |
| AC measurability | PASS_WITH_FINDINGS | Five ACs exist, but "6 sections present with English content" does not verify approved EN copy. |
| Scope/dependency integrity | BLOCKED | Owner includes team_30 for EN content, but no dependency or deliverable path is declared. |

Required corrections:

| ID | Severity | Correction | evidence-by-path | route_recommendation |
|----|----------|------------|------------------|----------------------|
| T190-W2SPEC-08-B01 | P1 / BLOCKING | Provide a final EN content artifact/path or make team_30 delivery a hard dependency before build. The builder must not author marketing copy from "essence" during implementation. | `_aos/work_packages/S002/WP-W2-08/LOD400_spec.md:5`; `_aos/work_packages/S002/WP-W2-08/LOD400_spec.md:14` | team_100/team_30 correction + re-submit WP-W2-08. |
| T190-W2SPEC-08-B02 | P2 / BLOCKING | Choose one canonical URL: `/en` or `/en/landing`, and define any redirect between them. | `_aos/work_packages/S002/WP-W2-08/LOD400_spec.md:14`; `_aos/work_packages/S002/WP-W2-08/LOD400_spec.md:26` | team_100 route correction. |
| T190-W2SPEC-08-B03 | P2 / BLOCKING | Define exact hreflang contract: canonical Hebrew reciprocal target, expected `<link rel="alternate">` values, and whether `/` or `/home` is the HE counterpart. | `_aos/work_packages/S002/WP-W2-08/LOD400_spec.md:20`; `_aos/work_packages/S002/WP-W2-08/LOD400_spec.md:28` | team_100 SEO contract correction. |
| T190-W2SPEC-08-F04 | P3 / NON-BLOCKING | Add exact source paths for the Hebrew pages/sections summarized into the six EN sections. | `_aos/work_packages/S002/WP-W2-08/LOD400_spec.md:16` | team_100 content traceability correction. |

### WP-W2-09 — Media Filter + Full 301 + Cutover Prep

Verdict: **BLOCKED**

| Criterion | Result | Notes |
|-----------|--------|-------|
| Implementability | BLOCKED | The spec names required outputs but omits exact source paths/scripts for several build steps. |
| Content-source path resolution | BLOCKED | `ACCURATE-SITE-MAPPING` is referenced but no matching artifact was found. Existing media inventory path is `_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-2026-05-26.json`, but it contains `in_use_count: 11`, not the spec's expected `~60-120 of 319`. |
| Cross-cutting correctness | PASS_WITH_FINDINGS | Correctly depends on W2-01..W2-08 and defers cutover execution/M7. External 301 JSON exists, but the spec does not point to the exact canonical file. |
| AC measurability | PASS_WITH_FINDINGS | Six ACs exist. `final_pre_cutover_check.sh` is referenced but no such script was found. |
| Scope/dependency integrity | PASS_WITH_FINDINGS | Dependency list is structurally correct. External Eyal 301 JSON is already present in repo, so the blocker should be expressed as "use final approved JSON path" rather than "Eyal returns JSON" unless another approval is pending. |

Required corrections:

| ID | Severity | Correction | evidence-by-path | route_recommendation |
|----|----------|------------|------------------|----------------------|
| T190-W2SPEC-09-B01 | P1 / BLOCKING | Replace `ACCURATE-SITE-MAPPING` with an exact artifact path, or state that `_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-2026-05-26.json` is the authoritative source and reconcile the expected count. | `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md:12`; `_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-2026-05-26.json` | team_100/team_20 correction + re-submit WP-W2-09. |
| T190-W2SPEC-09-B02 | P1 / BLOCKING | Add or reference the required `final_pre_cutover_check.sh` script. No file with that name exists in the repo. | `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md:27`; repo `find` result empty | team_100/team_20 add script path or adjust AC. |
| T190-W2SPEC-09-B03 | P2 / BLOCKING | Identify the exact 301 source file: likely `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` (135 decisions). Reconcile AC-02 count (`~134 301 rules minus 49 QR keep`) with the actual final JSON and QR keep policy. | `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md:14`; `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json`; `docs/project/team-100-preplanning/QR-URL-INVENTORY.csv` | team_100/team_20 redirect contract correction. |
| T190-W2SPEC-09-B04 | P2 / BLOCKING | Define the exact sample set for AC-03: either a checked-in 20-URL sample file or deterministic sampling rule from the 301 JSON. | `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md:24` | team_100/team_20 AC correction. |
| T190-W2SPEC-09-F05 | P3 / NON-BLOCKING | Clarify Lighthouse target environment: HTTP vs HTTPS, TLS caveat, staging URL, and whether expired TLS is allowed as a known M7 carry-forward. | `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md:16`; `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md:26` | team_100/team_20 test environment note. |

## Source Path Resolution Matrix

| WP | Referenced source | Resolution |
|----|-------------------|------------|
| W2-03 | `מוזה הוצאה לאור - ספרים/MUZZA.md` | PASS |
| W2-03 | `וכתבת/vekatavta.md` | PASS |
| W2-03 | `כושי בלאנטיס/kushi_full.md` | PASS |
| W2-03 | `צבע בכחול וזרוק לים/eyal_tsva_FINAL.md` | PASS |
| W2-04 | `סאונדהילינג/sound_healing_final.md` | PASS |
| W2-04 | `שיעורי נגינה/lesons.md` | PASS |
| W2-05 | `כלים למכירה/buy didgeridoo.md` | PASS |
| W2-05 | `תיקים לדיג'רידו/bags for didg.md` | PASS |
| W2-05 | `סטנדים לדיג'רידו לאחסון/stend for hanging.md` | PASS |
| W2-05 | `סטנד רצפתי.../stend for playing.md` | BLOCKED — ellipsis path; exact folder exists as `סטנד רצפתי לנגינה בישיבה נמוכה/` |
| W2-05 | `תיקון כלי דיג'רידו/build didg.md` | PASS |
| W2-07 | `מוקש דהימן/ומה היום.docx` | PASS |
| W2-07 | press legacy `/qr-press` or equivalent | BLOCKED — no exact artifact/path |
| W2-07 | 49 QR body/images | BLOCKED — URL inventory exists, body/image source not specified |
| W2-07 | FB Top-5 text/images | BLOCKED — no exact 25.5.26 source path |
| W2-08 | EN summary from 25.5.26 essence | BLOCKED — no source paths or final EN artifact |
| W2-09 | `ACCURATE-SITE-MAPPING` relationships | BLOCKED — no matching artifact found |
| W2-09 | Eyal 301 JSON | PASS_WITH_FINDINGS — final JSON exists, spec does not point to exact file/count |

## Final Gate Routing

L-GATE_SPEC result is **BLOCKED OVERALL** because four of six specs contain blocking gaps. team_100 must correct and re-submit WP-W2-05, WP-W2-07, WP-W2-08, and WP-W2-09 before activating `_COMMUNICATION/team_100/HANDOFF_SELF_100_WP-W2-03_2026-05-28_v1.md` or dispatching Wave2 build work.

*team_190 — constitutional validator — 2026-05-28*
