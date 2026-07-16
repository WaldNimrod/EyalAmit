---
id: RESEARCH-WP-S5-02-GROUND-TRUTH-2026-07-16
from_team: team_100
date: 2026-07-16
type: research-preserved-for-handoff
wp: WP-S5-02
status: COMPLETE — ready to fold directly into WP-S5-02-LOD400 authoring
---

# Preserved ground-truth research — WP-S5-02 (SEO/GEO ratified-execution completion)

Produced by an Explore agent during this session (after one retry — first attempt hit a mid-response API
error), before the task was correctly redirected to a canonical handoff (per team_00 instruction, 2026-07-16).
Complete — use directly, no need to re-run. Cross-references `WP-W2-17-CRFINAL-SEO-REMEDIATION-PROGRAM-2026-07-03.md`
(T4/T5/T6/T7) and `SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md` §8 items 2, 7, 8, 9.

## Item 1 — Sitemap URL reconciliation: **RESOLVED, consistent — no action needed**

No physical `robots.txt` file / no mu-plugin generates custom robots.txt body — the staging block-all body is WP core's default virtual-robots output (`blog_public=0`); `ea-staging-noindex.php:38-46` only adds `noindex,nofollow` via the `wp_robots` filter, doesn't touch robots.txt.

Live: `/robots.txt` → 200, `User-agent: * / Disallow: /` (no Sitemap line — expected, block-all host). `/sitemap_index.xml` → 200 (Yoast). `/wp-sitemap.xml` → 301 → `/sitemap_index.xml` (single-hop, `X-Redirect-By: Yoast SEO`). Legacy `/מפת-אתר-site-map/` → `/sitemap_index.xml` (`ea-w209-legacy-301-redirects.php:48`). Pre-authored production `docs/cutover/robots-production.txt:60` → `Sitemap: https://www.eyalamit.co.il/sitemap_index.xml`.

**All four references agree on `/sitemap_index.xml`.** T6's design is already correctly reconciled — it just isn't live yet (by design, ships only at cutover).

## Item 2 — Route-completeness schema/meta: **REAL GAPS FOUND**

Schema engine: `site/wp-content/mu-plugins/ea-w2-seo-schema.php`, `ea_w2_seo_schema_graph()` (L22-236) on Yoast's `wpseo_schema_graph` filter — the single "one schema engine" policy file. Only per-route noindex mechanism in the codebase: `_yoast_wpseo_meta-robots-noindex` postmeta, set in exactly ONE place (`ea-m2-site-tree-lock-sync-once.php:237`), applied only to `/therapist-training/`.

| Route class | Schema (code) | Explicit noindex | Verdict |
|---|---|---|---|
| `/repair/ /bags/ /stand-floor/ /stands-storage/` | FAQPage only (L150-167); no Product node (price meta not set on any of 4 — correct per Item 4) | none | **Not a gap** |
| `/books/vekatavta/ /kushi-blantis/ /tsva-bekahol/` | Book node + Offer-when-numeric (L179-186, 276-334) | n/a | Fine |
| `/eyal-amit/mokesh-dahiman/` | Person + VideoObject (L196-233) | n/a | Fine |
| `/press/` | Nothing route-specific | none | **GENUINE GAP** |
| `/shows/` | **Route is stale** — `/shows/` 301s to `/shows-heritage/` (confirmed live; a WP-core old-slug redirect, not the legacy mu-plugin). Live `/shows-heritage/` gets only sitewide boilerplate | none | **GENUINE GAP** (+ correct the spec's route name from `/shows/` to `/shows-heritage/`) |
| **48 `/qr/qrN/` + `/qr/` hub** | `tpl-chapters-qr.php` renders raw `the_content()`; schema engine has **no branch for `qr` at all**. Spot-check qr2/qr10/qr30/qr48: only sitewide boilerplate, zero page-specific type — despite several embedding real YouTube videos (no `VideoObject`) | none | **GENUINE, LARGE-SCALE GAP — all 48+1** |

**Net gapped-route list:** `/press/`, `/shows-heritage/` (the live slug), all 48 `/qr/qrN/` + `/qr/` hub. Everything else in the enumerated set is fine. Note: `scripts/qa/seo_probe.config.json` (the standing T7 QA harness) currently has NO entries for any of these gapped routes either — the harness doesn't catch this.

## Item 3 — QR-iframe CWV: **Mostly already remediated; one deploy/reseed gap**

Template `tpl-chapters-qr.php` is chrome-only; real iframes live in seeded `post_content` from `ea-w2-07-qr-content-data.php`.

**Code-level:** all 46 `<iframe>` occurrences in the CURRENT source already carry `loading="lazy"` (46/46), src domain `youtube-nocookie.com` — introduced in commit `624a5a9` ("WP-06 brand-string removal + WP-07 youtube-nocookie"), original seed was `c7dc34a`. No click-to-load facade exists anywhere in theme JS; no transcripts (0 hits for "transcript|תמלול" in the content-data file).

**Live discrepancy found:** `/qr/qr2/`'s rendered iframe HAS `loading="lazy"` but its `src` is still plain `youtube.com/embed/ng9q5-xkNmE`, not `youtube-nocookie.com` as the current source specifies for that video ID. Root cause: `ea-w2-07-qr-seed-once.php` is gated by option flag `ea_w2_07_qr_seeded_v3` — content only refreshes on a manual flag reset. Live DB content predates the `624a5a9` nocookie switch and was never re-seeded.

**Ground truth:** the master plan's stated concern ("raw iframes, no facade/lazy-load") is **stale** — lazy-loading is already live. Genuinely open: (a) no facade pattern (native lazy-load meets the "at minimum lazy" bar, not the stronger facade option — decision needed on whether facade is still required), (b) no transcripts, (c) live/repo drift on the nocookie-domain cosmetic fix, fixable by resetting the `ea_w2_07_qr_seeded_v3` flag and re-running the seed.

## Item 4 — Offer/price schema rule: **Correctly implemented, currently dormant**

Both Offer-emission sites in `ea-w2-seo-schema.php` are `is_numeric()`-gated:
- Product/Offer (5 shop pages via `ea_product_price` postmeta): L119-147. Product node only builds if the postmeta KEY EXISTS (L122) at all; offers block only added `if (is_numeric($price))` (L135). No meta key at all → no Product node whatsoever, not just no Offer.
- Book/Offer: L314-328, same pattern (`if ($url && is_numeric($price))`, L319).

Metabox owning `ea_product_price`: `inc/chapters/product-meta.php` (WP-S4-05 §5), scoped to exactly the 5 shop slugs; empty submitted value → `delete_post_meta()` (not stored as `''`), so the field can never hold a fake/zero value.

**Live cross-check, all 5 product pages:** zero Product/Offer nodes on any of them — because no price has been entered into the metabox yet on staging. Page copy correctly shows "מחיר לפי התאמה" (quote-only) consistent with unset price. **This is the expected safe fallback, not a bug** — the rule is holding. No schema Offer will exist until a price is entered via the metabox (content/ops task, not a code gap).

## Summary of what's actionable for the LOD400 spec
1. Item 1 — no action needed; fully reconciled by design, ships at cutover.
2. Item 2 — real work: `/press/`, `/shows-heritage/` (correct the stale `/shows/` route name in any spec), and 48 `/qr/qrN/`+hub need a schema decision (e.g. Article/CreativeWork+VideoObject for QR, Article for press/shows-heritage) OR an explicit noindex decision.
3. Item 3 — lazy-loading done; decide if facade+transcripts still required; reset `ea_w2_07_qr_seeded_v3` + re-seed to pick up the already-fixed nocookie-domain change.
4. Item 4 — code correct; becomes a content-entry task (populate `ea_product_price` when prices are ready) once Eyal/team decides pricing, not a code fix.

## Cross-note vs WP-S5-01
Item 2 here is the SAME master-plan §8 item 7 finding as WP-S5-01's item 5 (route-completeness schema/meta) — do not duplicate. Recommend WP-S5-02 owns the actual fix (it's the SEO/GEO-completion package); WP-S5-01 stays "confirm-only" framing.
