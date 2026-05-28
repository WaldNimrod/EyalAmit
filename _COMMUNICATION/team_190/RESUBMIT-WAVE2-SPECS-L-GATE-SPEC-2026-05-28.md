---
id: RESUBMIT-WAVE2-SPECS-L-GATE-SPEC-2026-05-28
from_team: team_100
to_team: team_190 (constitutional validator)
re: VERDICT-WAVE2-SPECS-L-GATE-SPEC-2026-05-28.md (BLOCKED overall)
fix_commit: 7adb0e1
date: 2026-05-28
status: RE-SUBMITTED for re-validation
---

# Re-submission — Wave2 LOD400 specs (corrections applied)

All corrections from your L-GATE_SPEC verdict are applied (commit `7adb0e1`). W2-03/04 (PASS_WITH_FINDINGS) corrected in place. W2-05/07/08/09 (BLOCKED) corrected and re-submitted for re-validation.

## Correction map
| Finding | Resolution |
|---------|------------|
| W2-03 F01 (lod_status) | roadmap WP-W2-03 → `current_lean_gate: L-GATE_SPEC`, `lod_status: LOD400`, `spec_gate` recorded. |
| W2-03 F02 (GI fallback AC) | AC-03 now: fallback → `/contact?subject=book-<slug>` (never `#`), GA4 `book_purchase_click` still fires. |
| W2-04 F01 (A/B CTA) | Added canonical A/B CTA contract (variants A/B/C, form/WhatsApp targets `wa.me/972524822842`, GA4 `cta_click` + `variant_label`). |
| W2-04 F02 (testimonial dep) | Stated: placeholders OK for L-GATE_BUILD; for L-GATE_VALIDATE only if W2-07 still open. |
| W2-05 B01 (ellipsis path) | Fixed → `סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md`. |
| W2-05 B02 (CTA) | Added deterministic Purchase/contact CTA matrix (GI new-tab if URL else `/contact?subject=product-<slug>`, GA4 `product_cta_click`). |
| W2-05 F03 (price) | Price source = post meta `ea_product_price`; fallback "מחיר לפי התאמה". |
| W2-07 B01 (press) | `/press` canonical (dropped "or /about"); source = hard input `_COMMUNICATION/team_40/W2-07-PRESS-EXPORT-2026-05-28.json`; routing = seeded page + W2-02 pattern. |
| W2-07 B02 (QR content) | Hard input `_COMMUNICATION/team_40/W2-07-QR-CONTENT-EXPORT-2026-05-28.json` (per-slug body+images); seeded WP pages under `qr` on `tpl-qr.php`; image rehost policy. |
| W2-07 B03 (testimonials) | Source = `_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/catalog.json` (meta+entries). |
| W2-07 B04 (routing) | Per-item route/template plan table added (press/moksha/QR). |
| W2-07 F05 (FB dep) | FB fetch = external best-effort + fallback to curated media → grey avatar. |
| W2-08 B01 (EN content) | Hard dependency `_COMMUNICATION/team_30/W2-08-EN-CONTENT-2026-05-28.md`; builder must not author copy. |
| W2-08 B02 (URL) | Canonical `/en`; legacy `/en/landing` → 301 → `/en`. |
| W2-08 B03 (hreflang) | Contract: `/en` emits en + he(→`/`) + x-default; HE homepage reciprocal en alternate. |
| W2-08 F04 (sources) | Per-section HE source map added. |
| W2-09 B01 (media inventory) | Authoritative = `_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-2026-05-26.json` (in_use_count 7 = stale; regenerate post-W2-08 ∪ W2-06 blog media). Removed `ACCURATE-SITE-MAPPING`. |
| W2-09 B02 (script) | `scripts/final_pre_cutover_check.sh` = deliverable of W2-09 (checks defined). |
| W2-09 B03 (301 source) | Exact = `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` (135 decisions); QR-keep policy stated. |
| W2-09 B04 (sample) | AC-03 = first 20 of `decisions[]` (deterministic). |
| W2-09 F05 (Lighthouse env) | HTTP staging; expired-TLS = M7 carry-forward (IDEA-001). |

## Request
Re-validate **WP-W2-05, WP-W2-07, WP-W2-08, WP-W2-09** at L-GATE_SPEC. (W2-03/04 already PASS_WITH_FINDINGS — corrected in place, no re-validation needed per your verdict.) On all-PASS, the Wave2 orchestration handoff clears to activate.
Update verdict → `_COMMUNICATION/team_190/VERDICT-WAVE2-SPECS-L-GATE-SPEC-2026-05-28-v2.md`.

*team_100 — 2026-05-28*
