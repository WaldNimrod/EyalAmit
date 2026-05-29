---
id: VERDICT-W2-05-L-GATE-BUILD-2026-05-29
verdict: PASS_WITH_FINDINGS
wp: WP-W2-05
gate: L-GATE_BUILD
date: 2026-05-29
branch: feature/w2-05-shop
head_verified: 112b341 (build commit; worktree HEAD c3e4fdd = docs-only delta after build)
validator_engine: composer-2.5-fast (non-Claude — IR#1 satisfied)
staging: http://eyalamit-co-il-2026.s887.upress.link
from_team: team_50 (L-GATE_BUILD QA)
to_team: team_100 / team_00 / team_190
spec_ref: _aos/work_packages/S002/WP-W2-05/LOD400_spec.md
build_report: _COMMUNICATION/team_100/W2-05-BUILD-REPORT-2026-05-29.md
---

# L-GATE_BUILD Verdict — WP-W2-05 (Shop)

**Engine (line 1):** `composer-2.5-fast` — non-Claude validator per IR#1.

## Result

**PASS_WITH_FINDINGS** — all six acceptance criteria (AC-01..06) satisfied on staging and in repo static review. One non-blocking advisory: primary nav still exposes legacy `/tools-and-accessories/repair/` alongside canonical `/repair` (C3 menu follow-up, not an AC failure).

Ready for **team_190 L-GATE_VALIDATE** (Codex).

---

## Proof-of-HEAD

| Check | Result |
|-------|--------|
| Branch | `feature/w2-05-shop` |
| Build commit | `112b341` — WP-W2-05 Shop build (mirror W2-04) |
| Worktree HEAD | `c3e4fdd` — adds team_50/team_190 mandate docs only; **no build-file delta** vs `112b341` |
| Theme version (deploy marker) | `style.css` → **1.4.4** |
| HTTP cache-bust | All staging requests used `?cb=<timestamp><random>` |

---

## AC Results

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| **AC-01** | 6 URLs → HTTP 200 | **PASS** | Staging GET (cache-busted): `/didgeridoos` 200 · `/bags` 200 · `/stands-storage` 200 · `/stand-floor` 200 · `/repair` 200 · `/shop` 200. Initial hop may be 301 (trailing slash); final response 200. |
| **AC-02** | Full 10-block contract per product page | **PASS** | All 5 product pages render 10 content blocks. Live `data-block` markers (excluding topnav/footer-social): **didgeridoos** hero + 4×prose + faq + testimonials-row + price + cta + gallery; **bags** same pattern; **stands-storage** hero + 3×prose + faq + testimonials-row + price + cta + gallery + **steps** (closing “הזמנה ותהליך” — valid closing block type per W2-04 mirror); **stand-floor** hero + 4×prose + faq + testimonials-row + price + cta + gallery; **repair** hero + prose + steps + prose + faq + testimonials-row + price + cta + gallery + prose. Single H1 in hero; FAQ view-only filtered per product category. Testimonials/gallery placeholders spec-sanctioned. |
| **AC-03** | Price on catalog card + product page, or fallback | **PASS** | `ea_product_price` read via `ea_w2_05_price()` / catalog resolver (`wave2-w2-05.php:245-248`, `:674-678`, `:620`). All meta empty → literal **"מחיר לפי התאמה"** on each product page (1×) and all 5 `/shop` cards (5×). **No hardcoded numeric prices** in W2-05 templates/CSS (grep theme w2-05* + `wave2-w2-05*.php`; unrelated book-template prices in `tpl-books.php` pre-exist and are out of WP-W2-05 scope). |
| **AC-04** | CTA matrix B02 + GA4 `product_cta_click` | **PASS** | GI map all empty (`wave2-w2-05.php:218-225`) → every product CTA: `href="/contact?subject=product-<slug>"` same-tab, `data-cta-type="contact"`, **never `#`** (verified all 5 slugs on staging). `[data-ea-product-cta]` + `[data-ea-product-cta-link]` wired in `ea-ab-testing.js:75-98` firing `product_cta_click { product_slug, cta_type }`; reuses canonical **`eyal_cta_variant`** (line 9) — no new A/B key. Script enqueued on W2-05 views (`wave2-w2-05.php:170-177`); present in live HTML. WhatsApp path: `https://wa.me/972524822842`. |
| **AC-05** | `/shop` responsive grid 4-up desktop / 2-up mobile; cards linked | **PASS** | Live `/shop`: `ea-shop-grid` present; **5** linked `ea-shop-card` anchors → `/didgeridoos`, `/bags`, `/stands-storage`, `/stand-floor`, `/repair`; **5** `ea-shop-card__price` cells with fallback text. CSS: `grid-template-columns: repeat(4, 1fr)` default; `@media (max-width: 900px)` and `600px` → `repeat(2, 1fr)` (`w2-05-shop.css:257-336`). |
| **AC-06** | `validate_aos.sh` → 0 FAIL | **PASS** | `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` → **30 PASS / 18 SKIP / 0 FAIL** — “L-GATE_BUILD EXIT CRITERION: SATISFIED”. PHP `-l` clean on all W2-05 PHP files. `w2-05-shop.css`: no raw hex (D-14 tokens only). |

---

## Scope-Additions Review (beyond team_10 MODIFY list)

### 1. NEW `ea-w2-05-shop-pages-seed-once.php` + deploy list entry — **SAFE & JUSTIFIED**

| Criterion | Result |
|-----------|--------|
| `defined('ABSPATH') \|\| exit` | ✅ line 13 |
| `init` hook | ✅ line 116, priority 27 |
| Option gate `ea_w2_05_shop_pages_v2` | ✅ lines 58-59, 109 |
| Transient lock | ✅ lines 67-70, 112 |
| No `wp-load` re-require | ✅ confirmed (no require of wp-load) |
| Idempotent get-or-create / re-parent to root | ✅ `ea_w2_05_seed_get_or_create_page()` lines 25-51 |
| `_wp_old_slug` cleanup only when owner slug differs | ✅ lines 99-105 |
| Pattern match | ✅ mirrors `ea-m2-ia-slug-fixups-once.php` (ABSPATH, init, option, transient, try/finally) |
| Deploy wiring | ✅ `scripts/ftp_deploy_site_wp_content.py` lines 18, 67, 109 |

**Rationale:** AC-01 was unreachable without top-level WP pages; FTP cannot create pages. Seeder is the established spoke pattern — not manual DB pokes.

### 2. `ea-m2-site-tree-lock-sync-once.php` — removed `/shop/` → `/tools-and-accessories/` 301 — **SAFE & JUSTIFIED**

Redirect table (`ea_m2_st_canonical_path_redirects`, lines 400-423) no longer maps `/shop/` away from the catalog. Comment documents WP-W2-05 SSOT (`st-shop-archive`, `tpl-shop-archive`). Consistent with function purpose (“legacy → canonical per site-tree.json”). Staging `/shop` now returns **200** with catalog grid (was blocked pre-fix per build report).

### 3. Nav menu repair link — **C3 follow-up (non-blocking)**

Primary menu is still built by `ea_m2_site_tree_lock_sync_run()` with repair nested under tools hub (`ea-m2-site-tree-lock-sync-once.php:164`, menu line 298). W2-05 seeder re-parented the **page** to root `/repair` (200). Staging `/shop` HTML exposes **both**:

- `…/repair` (canonical — catalog card + in-content links)
- `…/tools-and-accessories/repair/` (legacy nav item — also 200)

**Not in WP-W2-05 mandate MODIFY list.** Does not fail any AC (product URLs, CTAs, catalog links all correct). **Recommendation:** C3/Eyal admin menu sync — repoint primary nav repair item to top-level `/repair` when site-tree/nav WP is next touched; optional legacy 301 from nested path → `/repair` for bookmark hygiene.

---

## Static Code Checks (mandate §3A)

| Check | Result |
|-------|--------|
| PHP syntax (5 W2-05 files) | PASS — no errors |
| Raw hex in `w2-05-shop.css` | PASS — none found |
| `functions.php` require `wave2-w2-05.php` | PASS — line 792 |
| `style.css` Version | PASS — 1.4.4 |
| `tpl-shop-item` / `tpl-shop-archive` in `ea_wave2_is_active_view` list | PASS — `wave2-stage-b.php:51-52` |
| `hub/data/site-tree.json` nodes | PASS — `st-svc-repair` → `tpl-shop-item`; +4 product nodes + `st-shop-archive` |

---

## Findings (non-blocking)

### F-W2-05-01 (ADVISORY) — Primary nav repair URL stale

- **AC affected:** none
- **Evidence:** Staging `/shop` nav contains `href="…/tools-and-accessories/repair/"` while canonical product route is `/repair` (200, full shop template).
- **File:** `site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php:298` (menu build uses nested repair page ID from line 164 before W2-05 re-parent).
- **Recommendation:** C3 follow-up — update M2 menu sync or manual nav edit; not a builder rework for L-GATE_BUILD.

### F-W2-05-02 (INFO) — Builder scope additions documented

team_10 added seeder + redirect fix + deploy-script line outside original MODIFY list. Both code additions reviewed above; **accepted as necessary infrastructure** for AC-01 and catalog routing. No objection.

### F-W2-05-03 (INFO) — stand-floor closing synthesized

Per build report: stand-floor source lacked §10 closing; builder synthesized closing from §07/§09 wording. Content QA deferred to team_190 / Eyal review; block contract structurally satisfied.

---

## Recommendation

| Gate | Action |
|------|--------|
| L-GATE_BUILD | **CLOSE — PASS_WITH_FINDINGS** |
| Next | Dispatch **team_190** (Codex) for L-GATE_VALIDATE on `112b341` / deployed staging |
| C3 (parallel, non-blocking) | Nav repair URL cleanup + optional legacy nested-path 301 |

---

*team_50 — 2026-05-29 — L-GATE_BUILD QA complete (non-Claude engine).*
