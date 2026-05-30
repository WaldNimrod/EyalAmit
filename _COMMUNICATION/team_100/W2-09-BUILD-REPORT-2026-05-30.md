---
id: W2-09-BUILD-REPORT-2026-05-30
wp: WP-W2-09 — Media filter + full 301 application + cutover prep
from_team: team_20 (DevOps Builder, Claude)
to_team: team_100 (Chief Architect) / team_00 (Principal)
date: 2026-05-30
status: PARTIAL — BLOCKED on 301 deploy mechanism (team_00 decision required)
branch: feature/w2-09-cutover
---

# WP-W2-09 Build Report

## 0. Executive summary / BLOCKER (read first)

**The mandate's core mechanism — server-level `.htaccess` 301s — DOES NOT FUNCTION on the
uPress stack.** Empirically (3 safe-deployer deploys + live probes), every per-page legacy
redirect placed in `.htaccess` (`Redirect 301`, bare `RewriteRule`, and `RewriteCond
%{REQUEST_URI}` forms, encoded + decoded) returned **404**. The stack is **nginx front +
Apache with `AllowOverride None`**: `.htaccess` rewrite/redirect directives are silently
ignored. The redirects that *do* work on this site are **PHP `template_redirect` hooks**
(`ea_m2_st_canonical_path_redirects()` in `ea-m2-site-tree-lock-sync-once.php`) and WP
canonical redirects — proven: `/muzeh/`→`/muzza/`, `/hashita/`→`/method/`, etc. all 301.

**Resolution built (not yet deployed):** the generator now ALSO emits a working PHP mu-plugin
`site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php` carrying the identical
25×301 + 2×410 map (keyed on `rawurldecode()`d path), registered before the site-tree
table (`template_redirect` priority 0). **It was NOT deployed**: pushing a self-executing
mu-plugin to the highest-blast-radius WP without the safe deployer's backup/health-check/
auto-rollback was blocked by the environment guardrail (mu-plugins are a flagged hazard).
**Per mandate ("if it rolls back, diagnose + report — do NOT force"), I stopped and am
escalating.** team_00 decision required: approve deploying the PHP redirect mu-plugin
(deviation from the `.htaccess` mechanism the mandate assumed).

The `.htaccess` block was still regenerated cleanly and deployed via the SAFE deployer
(PASS, no rollback); it is **inert** on this stack (harmless, retained as SSoT + safety net
if AllowOverride is ever enabled). Site health verified 200 throughout — no harm done.

## 1. Part 1 — 301 layer regenerate (approach B)

- **Generator:** `scripts/gen_htaccess_301_from_decisions.py` — reads the 135-decision JSON
  SSoT, applies all DECISION rules, emits BOTH:
  - `_COMMUNICATION/team_100/tools/htaccess_301_block.txt` (marker-wrapped; inert on stack)
  - `site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php` (the WORKING mechanism)
- **Counts:** decided_status: 27×`301`, 1×`410`, 3×`manual`, 1×empty, 103×keep/qr.
  After de-conflict + manual reassignment → **25 × Redirect-301** + **2 × Redirect-410**
  emitted. Blog catch-all `RewriteRule ^Blog/(.+)$ /$1 [R=301,L,NC]` preserved (WP canonical
  also covers it).
- **Loop/dup guard:** de-dup on source; assertion that no target is a redirected source — PASS.

### 1a. Dropped / skipped (de-conflict guard) — 4

| source | reason | original target |
|---|---|---|
| `/shop/` | canonical-collision `/shop` | books → **DROPPED** (would break live W2-05 catalog) |
| `/shop/cart/` | canonical-collision `/shop` | books → DROPPED |
| `/shop/checkout/` | canonical-collision `/shop` | books → DROPPED |
| `/shop/my-account/` | canonical-collision `/shop` | books → DROPPED |

Verified live: `/shop/` → **200** (catalog intact). `/shop/cart|checkout|my-account/` →
404 (no Wave2 equivalent; acceptable — they were Woo endpoints, catalog is read-only).

### 1b. Full 301 rule table (25) — incl. empty→target resolution

| # | legacy (decoded) | target | resolution |
|---|---|---|---|
| 1 | /צור-קשר/ | /contact/ | empty→equiv |
| 2 | /כתבות-בתקשורת-…-של-א/ | /shows/ | slug:shows |
| 3 | /תגובות-גולשים-…-של/ | /shows/ | slug:shows |
| 4 | /מוזה-הוצאה-לאור/וכתבת-אוטוביוגרפיה…/ | /books/vekatavta/ | empty→equiv (book) |
| 5 | /הופעות/ | /shows/ | empty→equiv |
| 6 | /מוזה-הוצאה-לאור/ | /muzza/ | empty→equiv |
| 7 | /בלוג-דיגרידו-…-א/ | /blog/ | slug:blog |
| 8 | /מוזה-הוצאה-לאור/כושי-בלאנטיס…/ | /muzeh/kushi-blantis/ | empty→equiv (book) |
| 9 | /והודית/ | /shows/ | slug:shows |
| 10 | /מפת-אתר-site-map/ | /sitemap_index.xml | manual (Yoast index; .xml 404) |
| 11 | /מוזה-הוצאה-לאור/דף-מבצעים-…/ | /books/ | slug:books |
| 12 | /shop/תקנון/ | / | manual interim — FLAG (/terms/ exists) |
| 13 | /דיגרידו-…-סטודי/שיעורי-נגינה…/ | /lessons/ | empty→equiv |
| 14 | /דיגרידו-…-סטודי/סדנאות-בנייה…/ | /lessons/ | empty→equiv |
| 15 | /דיגרידו-…-סטודי/טיפולי-סאונד-הילינג…/ | /sound-healing/ | slug:sound-healing |
| 16 | /דיגרידו-…-סטודי/תיקון-דיגרידו/ | /repair/ | empty→equiv |
| 17 | /דיגרידו-…-סטודי/תיקים-לדיגרידו/ | /bags/ | slug:bags |
| 18 | /דיגרידו-…-סטודי/דיגרידו-למכירה…/ | /didgeridoos/ | slug:didgeridoos |
| 19 | /דיגרידו-…-סטודי/סאונד-הילינג-…מדיטציית…/ | /sound-healing/ | empty→equiv |
| 20 | /דיגרידו-…-סטודי/הדיגרידו-ככלי-לריפוי…/ | /treatment/ | slug:treatment |
| 21 | /דיגרידו-…-סטודי/מוקש-דהימן…/ | /eyal-amit/mokesh-dahiman/ | __CUSTOM__→newsite (custom_url was legacy domain) |
| 22 | /דיגרידו-…-סטודי/סטנד-רצפתי…/ | /stand-floor/ | slug:stand-floor |
| 23 | /דיגרידו-…-סטודי/סטנדים-לאחסון…/ | /stands-storage/ | slug:stands-storage |
| 24 | /וכתבת-אייל-עמית/ | /books/vekatavta/ | slug:books/vekatavta |
| 25 | /אייל-עמית-אודות/ | /about/ | empty→equiv (about Eyal) |

### 1c. 410 rules (2)

| legacy | note |
|---|---|
| /qr/פרק-א/ | decided 410 ("פרק א"). NB: under /qr/ but NOT one of the 49 /qr/qrN/ — distinct legacy slug. |
| /thankyou/ | manual→410 (no Wave2 user registration, INGEST §2.1) |

### 1d. NO-rule (stay live 200)

- 49 × `/qr/qrN/` (qr1..qr49) — verified live (see Part-2 QR check).
- 54 × keep; 1 × empty (old home `/` — would be self-loop + canonical, correctly no rule).

### 1e. Flagged for Eyal (non-blocking)

- `/shop/תקנון/` → `/` interim per mandate; `/terms/` live page exists (better target).
- `/מפת-אתר-site-map/` → `/sitemap_index.xml` (mandate said `/sitemap.xml`, which 404s).
- `/thankyou/` → 410 (confirm no future registration need).

### 1f. .htaccess deploy result

SAFE deployer (`deploy_htaccess_301.py`) ran 3× (iterating the mechanism): each time
**RESULT: PASS — site healthy, NO auto-rollback** (home/about 200, blog redirect via WP
canonical). Final live `.htaccess` = clean regenerated block (inert). Backups saved under
`_COMMUNICATION/team_100/tools/htaccess.backup-*`.

### 1g. 301/410 LIVE verify (current — PHP plugin NOT deployed)

- 25 × 301 legacy sources → **404** (`.htaccess` inert; PHP plugin pending deploy). **0/25 live.**
- 2 × 410 → 404 (same reason). **0/2 live.**
- 4 dropped `/shop/*`: `/shop/` **200** ✅ (catalog protected — primary de-conflict goal MET).
- **Targets all valid:** every one of the 25 targets independently resolves to 200 (verified).
  → Once the PHP plugin is deployed, the map is correct and will resolve. The blocker is
  deploy authorization, not map correctness.

## 2. Part 2 — media inventory regenerate

- **Generator:** `scripts/gen_media_in_use_inventory.py` — crawls live home + all published
  pages/posts (REST link list), extracts referenced `/wp-content/{uploads,themes}/` media,
  unions with W2-06 repo `uploads/`, dedups, HEAD-checks each.
- **Output:** `_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-REGEN-2026-05-30.json`.
- **Result:** **in_use_count = 74** (54 uploads + 23 theme assets; was 11 referenced-from-HTML
  ∪ 51 repo uploads from W2-06, deduped to 74 on the new-site host), crawled **158** live
  pages/posts. **all_200 = TRUE → AC-01 PASS.** Supersedes stale 2026-05-26 (in_use_count=7).
- **Migration:** no in-use media was missing (every referenced new-site media already 200);
  W2-06 blog media already localized in `wp-content/uploads/` — no duplication.
- **External references flagged (3, content-quality, NOT in-use media / NOT AC-01):**
  `http://blog.muzza.co.il/...2.jpg`, `.../31.jpg`, `https://www.eyalamit.co.il/...צוותא-אייל-עמית.jpg`
  — absolute URLs to legacy/external hosts embedded in content; recommend relinking
  post-cutover (logged in inventory `external_references`).

## 3. Part 3 — final_pre_cutover_check.sh

`scripts/final_pre_cutover_check.sh` (NEW) asserts, exit non-zero on any fail:
(a) in-use media 200 · (b) 301 resolve + 410 active · (c) 49 QR 200 vs CSV ·
(d) validate_aos 0 FAIL · (e) Lighthouse home ≥90 (HTTP; `--skip-lighthouse` when CLI absent).
Parses literal page-level RewriteRule/Redirect lines (skips the blog catch-all pattern);
all HTTP groups retry transient timeouts (staging host is intermittently slow tonight).

**Current run (`--skip-lighthouse`, PHP plugin NOT yet deployed):**
- (a) media: **PASS** — 74 in-use items all 200.
- (b) 301/410: **FAIL (expected)** — `.htaccess` inert; 25×301 + 2×410 return 404 until the
  PHP mu-plugin is deployed. Targets independently verified 200, so the map is correct.
- (c) 49 QR: **PASS** — all 200 (vs CSV; transient host timeouts retried).
- (d) validate_aos: **PASS** — 0 FAIL.
- (e) Lighthouse: **SKIPPED** (CLI absent).
- **Script exit: non-zero** (group b), correctly gating cutover until the redirect plugin ships.

## 4. Part 4 — cutover checklist

`_COMMUNICATION/team_20/W2-09-CUTOVER-CHECKLIST-2026-05-30.md`: noindex auto-disables on
production host (`upress.link`-gated); sitemap at `/sitemap_index.xml` (200); GA4 = open
human gate; the 301-mechanism deviation documented.

## 5. validate_aos

`bash _aos/.../validate_aos.sh .` → **30 PASS / 18 SKIP / 0 FAIL**. L-GATE_BUILD criterion satisfied.

## 6. Lighthouse (AC-05)

Lighthouse CLI **not installed** in this environment; no fresh full-category homepage run
possible. Prior HTTP run (2026-05-27, `/wave2-test/`): **performance=81**, accessibility=100
(SEO/best-practices not captured). **AC-05 UNVERIFIED this session + perf historically <90 on
HTTP** — carry-forward risk. Recommend a fresh `lighthouse` homepage run before M7.

## 7. Files touched

- `scripts/gen_htaccess_301_from_decisions.py` (NEW)
- `scripts/gen_media_in_use_inventory.py` (NEW)
- `scripts/final_pre_cutover_check.sh` (NEW)
- `site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php` (NEW, generated — NOT deployed)
- `scripts/ftp_deploy_site_wp_content.py` (registered the new mu-plugin)
- `_COMMUNICATION/team_100/tools/htaccess_301_block.txt` (regenerated; deployed; inert)
- `_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-REGEN-2026-05-30.json` (NEW)
- `_COMMUNICATION/team_20/W2-09-CUTOVER-CHECKLIST-2026-05-30.md` (NEW)
- `_COMMUNICATION/team_100/W2-09-BUILD-REPORT-2026-05-30.md` (this)

## 8. Blockers for the gates

1. **301 mechanism (HARD):** `.htaccess` inert on uPress. Working PHP mu-plugin built but
   **not deployed** (guardrail-blocked; mandate says don't force). **team_00 must approve**
   deploying `ea-w209-legacy-301-redirects.php` via `ftp_deploy_site_wp_content.py`.
   Until then AC-02/AC-03 (27 301 + 410 live) and check-(b) cannot pass.
2. **Lighthouse (SOFT/AC-05):** CLI absent; perf historically <90 on HTTP home — needs a
   fresh run pre-M7.

---

## 9. Lighthouse — AC-05 (homepage, HTTP staging) — appended 2026-05-31 by team_20 (DevOps)

Tool: Lighthouse 13.3.0 (local), headless Chrome. URL: `http://eyalamit-co-il-2026.s887.upress.link/` (cache-busted per run).

### Scores: baseline vs final (desktop preset)

| Category | Baseline | Final | ≥90? | Status |
|---|---|---|---|---|
| Performance | 96 | 96 | YES | PASS (desktop, stable across 3 runs) |
| Accessibility | 100 | 100 | YES | PASS |
| SEO | 61 | 69 | NO | FLOORED by intentional staging noindex — **M7 carry-forward** (would be 100 once noindex lifts) |
| Best-practices | 74 | 78 | NO | FLOORED by HTTP-only staging — **M7/HTTPS carry-forward** (would be 100 over HTTPS) |

Mobile preset (informational; AC targets desktop): Performance 79, Accessibility 100, SEO 69, Best-practices 78. Mobile perf is gated by FCP/LCP 3.6 s on the throttled (4x CPU + slow-4G) profile over HTTP/1.1 with no HTTP/2, CDN, or edge caching (`modern-http-insight` and `render-blocking-insight` both score 0). TBT 0 ms and CLS 0 are perfect — the deficit is transport/first-paint, not theme JS/layout. This lifts at the M7 HTTPS/HTTP-2/CDN cutover.

### Changes made (theme-level, content-neutral)

1. **NEW `inc/wave2-w2-09.php`** (+ registered in `functions.php`): emits `<meta name="description">` on the HE homepage (derived verbatim from existing hero title + subtitle — no new copy) with a tagline-based site-wide fallback; and emits favicon `<link rel="icon|shortcut icon|apple-touch-icon">` pointing at the shipped `assets/images/ea-logo.jpg`. Skips the EN page; defers to a real WP Site Icon if configured.
   - Fixes SEO `meta-description` (0 → pass) and best-practices `errors-in-console` (the `/favicon.ico` 404, 0 → pass).
2. **`template-parts/blocks/block-topnav.php`** + **`assets/js/ea-hero.js`**: prefixed the sound-toggle `aria-label` with the visible word "שמע" (both the initial PHP markup and the two JS state strings) so the accessible name contains the visible text.
   - Clears the sound-toggle `label-content-name-mismatch` axe flag (accessibility already 100; this is hygiene).

### Floored categories — exact blocking audits + why (HONEST)

- **SEO 69 (cap):** sole weighted failure is `is-crawlable` (weight 4.04 of ~14), caused by `<meta name="robots" content="noindex, nofollow">` + `X-Robots-Tag: noindex` from `mu-plugins/ea-staging-noindex.php` — the **intentional** staging noindex. Per mandate this MUST NOT be removed (removing it games the score). With it lifted at M7, computed SEO = **100**. NOT theme-fixable; M7 carry-forward.
- **Best-practices 78 (cap):** sole weighted failures are `is-on-https` and `redirects-http` — HTTP-only staging. HTTPS lands at M7 cutover. With HTTPS, computed best-practices = **100**. NOT theme-fixable; M7/HTTPS carry-forward.
- The `redirects` performance audit (and the http→https→http hop) is a staging-host artifact (cache-bust param + host redirect behavior), not theme-controllable.

### Files changed + deployed

- `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php` (NEW)
- `site/wp-content/themes/ea-eyalamit/functions.php` (registered the include)
- `site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-topnav.php`
- `site/wp-content/themes/ea-eyalamit/assets/js/ea-hero.js`

Deployed via `scripts/ftp_deploy_site_wp_content.py` on 2026-05-31; live head verified (meta description + favicon present, favicon URL returns 200, sound-toggle aria-label updated). Re-ran Lighthouse post-deploy to confirm scores above.

**AC-05 verdict:** Performance + Accessibility ≥90 (PASS). SEO + Best-practices are at their theme-level ceiling and FLOORED purely by the staging noindex and HTTP-only transport respectively — both verified to compute to 100 once the M7 HTTPS/production cutover lifts those staging conditions. No scores faked; staging noindex retained.
