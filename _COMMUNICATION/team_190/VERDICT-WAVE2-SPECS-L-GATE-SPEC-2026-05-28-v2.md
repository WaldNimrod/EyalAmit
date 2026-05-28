Engine: native Codex/GPT-5 (OpenAI Codex), not Claude.

# VERDICT v2 — Wave2 LOD400 Specs L-GATE_SPEC Re-validation

date: 2026-05-28
timezone: Asia/Jerusalem
correction_cycle: R2 — re-validation against corrected specs at HEAD 1306e51 after stale pre-correction verdict
validator: team_190 constitutional validator
repo: `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`
branch_observed: `feature/w2-06-blog`
commit_observed: `1306e51`
resubmission: `_COMMUNICATION/team_190/RESUBMIT-WAVE2-SPECS-L-GATE-SPEC-2026-05-28.md`
staleness_evidence: `_COMMUNICATION/team_190/EVIDENCE-WAVE2-SPECS-STALE-VERDICT-2026-05-28.md`
prior_verdict: `_COMMUNICATION/team_190/VERDICT-WAVE2-SPECS-L-GATE-SPEC-2026-05-28.md`
scope_revalidated: WP-W2-05, WP-W2-07, WP-W2-08, WP-W2-09

## Fresh-tree Proof

| Required proof | Result |
|----------------|--------|
| `git log --oneline -1` | `1306e51 team_190: evidence second specs verdict is stale (predates corrections 7adb0e1 by 6min); request re-validation vs HEAD 3b6e394 -> v2` |
| `grep -n "Deliverable script (B02)" _aos/work_packages/S002/WP-W2-09/LOD400_spec.md` | `17:## Deliverable script (B02)` |
| `grep -n "סטנד רצפתי לנגינה בישיבה נמוכה" _aos/work_packages/S002/WP-W2-05/LOD400_spec.md` | `17:| Floor stand | /stand-floor | tpl-shop-item.php | סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md |` |

Conclusion: this v2 verdict was run against the corrected tree, not the stale pre-`7adb0e1` tree.

## Executive Verdict

| WP | Prior v1 state | v2 verdict | Reason |
|----|----------------|------------|--------|
| WP-W2-05 | BLOCKED | PASS | Exact source path, deterministic CTA matrix, price meta field, and measurable ACs now present. |
| WP-W2-07 | BLOCKED | PASS | Press/QR/testimonial sources are now exact HARD INPUT contracts; routing/template plan is defined. |
| WP-W2-08 | BLOCKED | PASS | EN copy is now a HARD INPUT contract; canonical URL and hreflang contract are deterministic. |
| WP-W2-09 | BLOCKED | PASS_WITH_FINDINGS | Blocking gaps resolved. One non-blocking cleanup remains: line 6 still says external Eyal returns 301 JSON, while line 32 correctly says no further Eyal input is pending. |

Overall L-GATE_SPEC v2 routing: **PASS_WITH_FINDINGS, no blocking gaps**. The Wave2 orchestration handoff may proceed once team_100 accepts the non-blocking W2-09 cleanup or carries it explicitly.

## B0x Finding Resolution Map

| Prior finding | v2 status | Current spec evidence |
|---------------|-----------|-----------------------|
| W2-05 B01 — ellipsis path | RESOLVED | `_aos/work_packages/S002/WP-W2-05/LOD400_spec.md:17` now states exact path `סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md`. |
| W2-05 B02 — CTA underspecified | RESOLVED | `_aos/work_packages/S002/WP-W2-05/LOD400_spec.md:27-28` defines `Purchase/contact CTA matrix`; AC line 37 requires GI new-tab if present, else `/contact?subject=product-<slug>`, never `#`, with GA4 `product_cta_click`. |
| W2-07 B01 — press source/routing unresolved | RESOLVED | `_aos/work_packages/S002/WP-W2-07/LOD400_spec.md:14` sets `/press` canonical, hard input `_COMMUNICATION/team_40/W2-07-PRESS-EXPORT-2026-05-28.json`, and seeded page + W2-02 routing. |
| W2-07 B02 — QR content source missing | RESOLVED | `_aos/work_packages/S002/WP-W2-07/LOD400_spec.md:16` sets hard input `_COMMUNICATION/team_40/W2-07-QR-CONTENT-EXPORT-2026-05-28.json`, inventory CSV for slugs, seeded WP pages, `tpl-qr.php`, and media rehost path. |
| W2-07 B03 — testimonial source missing | RESOLVED | `_aos/work_packages/S002/WP-W2-07/LOD400_spec.md:17` sets `_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/catalog.json`; local evidence confirms `catalog.json` exists with `meta` + 315 `entries`. |
| W2-07 B04 — route/template plan undefined | RESOLVED | `_aos/work_packages/S002/WP-W2-07/LOD400_spec.md:12-17` provides per-item route/template plans for Press, Moksha, QR pages, and FB testimonials. |
| W2-08 B01 — EN content source missing | RESOLVED | `_aos/work_packages/S002/WP-W2-08/LOD400_spec.md:14` and `:24-25` declare hard input `_COMMUNICATION/team_30/W2-08-EN-CONTENT-2026-05-28.md`; builder must not author/translate copy. |
| W2-08 B02 — URL ambiguous | RESOLVED | `_aos/work_packages/S002/WP-W2-08/LOD400_spec.md:14` chooses `/en` as the single canonical URL and says `/en/landing` 301s to `/en` if present. |
| W2-08 B03 — hreflang ambiguous | RESOLVED | `_aos/work_packages/S002/WP-W2-08/LOD400_spec.md:20` defines `en`, `he`, reciprocal HE homepage alternate, and `x-default`. |
| W2-09 B01 — media inventory source unresolved | RESOLVED | `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md:12` sets `_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-2026-05-26.json` as authoritative stale input to regenerate after W2-01..08; local evidence confirms `in_use_count=7`, `items_len=11`. |
| W2-09 B02 — missing script | RESOLVED | `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md:17-18` states `scripts/final_pre_cutover_check.sh` is authored by W2-09 and defines five required assertions; AC line 29 requires exit 0. |
| W2-09 B03 — 301 source/count ambiguous | RESOLVED | `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md:14` sets `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json`, `total_items: 135`, `decisions[]` len 135, and QR keep policy; local evidence confirms 135 decisions. |
| W2-09 B04 — sample set undefined | RESOLVED | `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md:26` defines the deterministic sample as the first 20 entries of `decisions[]` in file order. |

## Per-spec Re-validation

### WP-W2-05 — Shop

Verdict: **PASS**

| Criterion | Result | Evidence |
|-----------|--------|----------|
| Implementability | PASS | Pages/sources table, product block contract, cross-cutting route note, deterministic CTA matrix, price meta field, and ACs are sufficient for a fresh builder. |
| Content-source path resolution | PASS | All five 25.5.26 source paths are literal and resolvable; floor-stand path corrected at line 17. |
| Cross-cutting correctness | PASS | Lines 24-25 reuse W2-02 infra, `ea_wave2_shell`, `tpl-shop-item.php`, `tpl-shop-archive.php`, and no WooCommerce/cart. |
| AC measurability | PASS | Lines 33-39 define six measurable ACs, including CTA GA4 params and fallback behavior. |
| Scope/dependency integrity | PASS | Depends on W2-02; out-of-scope excludes WooCommerce/local cart and non-25.5.26 products. |

### WP-W2-07 — Press + Moksha + QR + FB Testimonials

Verdict: **PASS**

| Criterion | Result | Evidence |
|-----------|--------|----------|
| Implementability | PASS | Lines 11-17 provide URL, exact source/input artifact, and route/template plan per item. |
| Content-source path resolution | PASS | Moksha source exists; testimonial catalog exists. Press and QR exports are declared as HARD INPUT artifacts from team_40, which is a valid LOD400 input contract before build eligibility. |
| Cross-cutting correctness | PASS | Lines 31-32 require W2-02/D-14 reuse and `ea_wave2_shell`; QR has explicit `tpl-qr.php` and `ea_wave2_is_active_view` addition. |
| AC measurability | PASS | Lines 34-39 define five measurable ACs. |
| Scope/dependency integrity | PASS | Lines 25-29 declare hard input dependencies and FB fallback behavior; out-of-scope is migration-only content rewrite and QR SEO. |

### WP-W2-08 — English Landing

Verdict: **PASS**

| Criterion | Result | Evidence |
|-----------|--------|----------|
| Implementability | PASS | Lines 11-25 define canonical URL, template, hard EN copy dependency, section contract, HE source map, SEO, media, and CTA behavior. |
| Content-source path resolution | PASS | EN copy is intentionally a HARD INPUT artifact from team_30; line 17 maps each section to HE source routes/catalog for traceability. |
| Cross-cutting correctness | PASS | Line 14 uses `tpl-en-landing.php`; lines 20-22 define hreflang, CTA, media, D-14 tokens, and `ea-wave2-shell`. |
| AC measurability | PASS | Lines 27-32 define five measurable ACs, including verbatim match to approved EN artifact. |
| Scope/dependency integrity | PASS | Owner includes team_30; line 24-25 blocks eligibility until team_30 artifact exists; out-of-scope is clear. |

### WP-W2-09 — Cutover Prep

Verdict: **PASS_WITH_FINDINGS**

| Criterion | Result | Evidence |
|-----------|--------|----------|
| Implementability | PASS | Lines 11-18 define exact artifacts, regeneration rule, 301 source, cutover checklist, and deliverable script requirements. |
| Content-source path resolution | PASS | Media inventory, final 301 JSON, and QR inventory resolve; final 301 JSON has 135 decisions. |
| Cross-cutting correctness | PASS_WITH_FINDINGS | Dependency shape is correct, but line 6 still says `+ external (Eyal returns 301 JSON)` while line 32 correctly says the approved 301 JSON is already present and no further redirect input is pending. |
| AC measurability | PASS | Lines 23-29 define six measurable ACs including exact first-20 redirect sample and HTTP staging Lighthouse environment. |
| Scope/dependency integrity | PASS_WITH_FINDINGS | Blocked until W2-01..08 close is correct. Non-blocking cleanup: remove stale line-6 external note to avoid confusing orchestration. |

Non-blocking finding:

| ID | Severity | Finding | evidence-by-path | route_recommendation |
|----|----------|---------|------------------|----------------------|
| T190-W2SPEC-V2-09-F01 | P3 / NON-BLOCKING | Header dependency text says Eyal still returns 301 JSON, but the body correctly says no redirect input is pending. This does not block build because line 32 is specific and authoritative. | `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md:6`; `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md:32` | team_100 should remove `+ external (Eyal returns 301 JSON)` from line 6 or replace with `approved 301 JSON present`. |

## Verification

```bash
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .
# RESULT: 30 PASS / 18 SKIP / 0 FAIL
```

```text
JSON evidence:
MEDIA-IN-USE-INVENTORY-2026-05-26.json: total_fetched=11, in_use_count=7, unattached_count=4, items_len=11
redirects-301-eyal-final-2026-05-27.json: decision_id=D-EYAL-301-MIGRATION-2026-05-26, total_items=135, decisions_len=135
ea-legacy-curated-2026-04-11/catalog.json: keys=meta,entries; entries_len=315
```

## Final Routing

Re-validation of WP-W2-05, WP-W2-07, WP-W2-08, and WP-W2-09 is **PASS_WITH_FINDINGS overall, no blocking gaps**. The prior B0x blockers are resolved in the corrected specs. W2-07/W2-08 hard-input artifacts are accepted as valid LOD400 input contracts and should gate L-GATE_ELIGIBILITY/build dispatch, not L-GATE_SPEC precision.

*team_190 — constitutional validator — 2026-05-28*
