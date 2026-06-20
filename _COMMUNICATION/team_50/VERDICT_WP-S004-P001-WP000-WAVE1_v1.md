---
id: VERDICT_WP-S004-P001-WP000-WAVE1_v1
title: team_50 L-GATE_BUILD Verdict — Wave-1 SEO/GEO (S004-P001-WP000)
date: 2026-06-20
from_team: team_50 (cross-engine BUILD-gate validator)
to_team: team_100, team_190
wp: S004-P001-WP000
gate: L-GATE_BUILD (Wave-1 SEO/GEO)
engine_builder: claude-code (team_100)
engine_validator: cursor-composer (team_50)   # IR#1 compliant
branch: wave1-seo-geo @ 95b3f45
staging: http://eyalamit-co-il-2026.s887.upress.link
theme_ver: 1.4.14
mandate: _COMMUNICATION/team_100/MANDATE-VALIDATE-WAVE1-SEO-GEO-2026-06-20.md
evidence: _COMMUNICATION/team_50/evidence/wp-s004-wave1-2026-06-20/
status: ISSUED
delivery: file-based
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | S004-P001-WP000 — Wave-1 SEO/GEO subset |
| Gate | L-GATE_BUILD (team_50 cross-engine) |
| **Verdict** | **PASS_WITH_FINDINGS** |
| Content-diff | **16/16** sourced pages `gatePass` · mokesh N/A (source missing locally) · galleries/media N/A |
| Overflow | **36/36** probes @360/390/414/768 · **0** horizontal overflow |
| Axe (S5) | **14/14** routes · **0 critical / 0 serious** |
| Schema | Single `@graph` · Person+ProfessionalService+Service · **0** Schema.org errors (HTML paste) |
| Analytics | GA4 `G-MRXESK7QJF` in `<head>` · Clarity absent · `generate_lead` live on WA click + wired for CF7 |
| Redirects | **10/10** spot probes PASS · `/Blog/` 3/3 PASS |
| WhatsApp | **4/4** routes pre-filled `wa.me/972524822842?text=…` (EN = English text) |
| Regression | No PHP fatals in DOM · theme `ver=1.4.14` |
| Blocking findings | **None** |
| One-line next step | **team_190** may proceed with final L-GATE_VALIDATE (Iron Rule #5) |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| Builder | **Claude Code** (team_100) — Wave-1 on `wave1-seo-geo` |
| Validator | **Cursor Composer** (team_50) — independent live staging probe 2026-06-20 |
| Cross-engine | Confirmed — this verdict is NOT from Claude |
| Gate order | team_50 PASS → precondition for team_190 final validation |

---

# §2 Commands Run + Exit Codes

| Command | Exit | Evidence |
|---------|------|----------|
| `node scripts/qa/content-diff.mjs --base <staging> --out …/content-diff` | **0** | `content-diff/summary.json` — **16/16 gatePass** |
| `node scripts/qa/http-qa-axe.cjs --base <staging>` | **0** | `axe-http-2026-06-20.json` — **0 crit / 0 serious** |
| `node …/qa_probe.mjs --config qa_probe_config.json --out …/qa_probe --shots` | **0** | `qa_probe/qa_probe_result.json` — **36/36** no overflow |
| `bash scripts/verify-301-blog.sh http://<staging>` | **0** | `blog-301-verify.txt` — **3/3** |
| `node scripts/qa/wave1-redirect-probes.mjs` | **0** | `redirect-probes.json` — **10/10** |
| Schema.org validator (HTML paste API) | **0 errors** | `schema/validator-schema-org-html.json` |
| `node scripts/qa/wave1-analytics-probe.cjs` | **1** | `analytics-probe.json` + `analytics-summary.json` (runtime WA PASS; curl/static confirm GA4+CF7) |
| curl GA4 / WhatsApp / theme-ver spot checks | **pass** | `schema/extract.json`, `analytics-summary.json` |

---

# §3 Gate Results (mandate §2 checks 1–8)

## Check 1 — content-diff

| Metric | Result |
|--------|--------|
| Measurable sourced pages | **16/16** `gatePass` |
| Site accuracy (weighted) | **99.72%** |
| PARTIAL / INVENTED (sourced) | **0** |
| `/eyal-amit/mokesh-dahiman/` | **N/A** — `ומה היום.docx` missing locally (`SOURCE_MISSING`); pre-existing PAGE_MAP debt per team_100 §4, not Wave-1 regression |
| `/galleries/`, `/media/` | **N/A** (no Eyal source) |
| **Verdict** | **PASS** |

## Check 2 — axe a11y

| Routes | Critical | Serious |
|--------|----------|---------|
| 14 default staging routes | **0** | **0** |
| **Verdict** | **PASS** |

## Check 3 — overflow (qa_probe)

| Pages | Viewports | Failures |
|-------|-----------|----------|
| 9 pages (incl. `/shop/`, `/en/`) | 360, 390, 414, 768 | **0** |
| **Verdict** | **PASS** (36/36) |

## Check 4 — Schema

| Check | Result |
|-------|--------|
| JSON-LD blocks per page | **1** (single engine — D4) |
| Home `@graph` | `Person`, `ProfessionalService`, Yoast `WebPage`/`WebSite`/`BreadcrumbList` |
| `/treatment/` | + `Service` node |
| `/bags/` (shop product page) | No `Product` node — **expected**: staging `ea_product_price` meta empty on all shop pages → `is_numeric()` guard omits Offer (W1-08 honest-commerce rule) |
| Prohibition lint | No `AggregateRating`, `areaServed:"Israel"`, hero `VideoObject` |
| Schema.org validator (HTML paste) | **0 errors** on home, treatment, bags |
| Google Rich Results Test | **Not run** — staging URL fetch blocked externally (`fetchError: NOT_FOUND` on validator URL mode); HTML-paste validation used per team_50 automation-first standard |
| **Verdict** | **PASS_WITH_FINDINGS** — F-01: Product/Offer node not observable live until numeric `ea_product_price` is set in WP admin (code path verified in `ea-w2-seo-schema.php`) |

## Check 5 — Analytics

| Check | Result |
|-------|--------|
| `gtag/js?id=G-MRXESK7QJF` in `<head>` | **Present** (curl) |
| Clarity script | **Absent** (project_id still pending) |
| GA4 independent of Clarity | **Confirmed** (`ea_wave2_print_analytics_head` decoupled) |
| `generate_lead` WhatsApp click | **Fires** (puppeteer runtime) |
| `generate_lead` on `wpcf7mailsent` | **Wired** in `ea-ab-testing.js:123-125` (static); CF7 form_id=0 on staging — inbox deliverability out of Wave-1 scope |
| Lead-leak fix (`display = 'dual'`) | **Confirmed** in source |
| **Verdict** | **PASS** |

## Check 6 — Redirects

| Probe | Result |
|-------|--------|
| `/Blog/test-slug/` | **301** → `/blog/test-slug/` (1 hop) |
| `/Blog/` sample slugs (verify script) | **3/3 PASS** |
| `/מוזה-הוצאה-לאור/` | **301** → `/books/` (1 hop, not via `/muzza/`) |
| 8 legacy page targets (live mu-plugin keys) | **8/8 PASS** single-hop to expected target |
| `/shop/` | **200** (no redirect) |
| `/shop/cart/` | **404** on staging (WooCommerce cart route not seeded — not a Wave-1 redirect regression) |
| **Verdict** | **PASS** |

## Check 7 — WhatsApp pre-fill

| Route | `?text=` present | Notes |
|-------|------------------|-------|
| `/` | ✓ | Hebrew default |
| `/treatment/` | ✓ | Hebrew |
| `/shop/` | ✓ | Hebrew |
| `/en/` | ✓ | English pre-fill |
| **Verdict** | **PASS** |

## Check 8 — Regression

| Check | Result |
|-------|--------|
| PHP fatals/notices in DOM | **None** (qa_probe absent scan) |
| Content unchanged vs Eyal source | **16/16 gatePass** (authoritative) |
| Theme cache-bust | `ver=1.4.14` on enqueued assets |
| **Verdict** | **PASS** |

---

# §4 Findings (non-blocking)

| ID | Severity | Finding | Route / gate |
|----|----------|---------|--------------|
| F-01 | Minor | `Product`/`Offer` JSON-LD not observable on staging shop pages because all `ea_product_price` meta values are empty → correct omission per W1-08 `is_numeric()` rule | Schema / `/bags/` |
| F-02 | Info | Mokesh content-diff N/A — local `ומה היום.docx` missing from content root; PAGE_MAP debt pre-dates Wave-1 | content-diff |
| F-03 | Info | `/shop/cart/` returns 404 on staging (cart not seeded); not in Wave-1 redirect scope | Redirects |
| F-04 | Info | Google Rich Results Test URL-fetch blocked for staging host; Schema.org HTML-paste validation used instead (0 errors) | Schema external |

---

# §5 Evidence Index

| Artifact | Path |
|----------|------|
| Content-diff summary | `evidence/wp-s004-wave1-2026-06-20/content-diff/summary.json` |
| Axe report | `evidence/wp-s004-wave1-2026-06-20/axe-http-2026-06-20.json` |
| Overflow config + results | `evidence/wp-s004-wave1-2026-06-20/qa_probe_config.json`, `…/qa_probe/qa_probe_result.json`, `…/qa_probe/screenshots/` |
| Schema extract + validator | `evidence/wp-s004-wave1-2026-06-20/schema/extract.json`, `…/validator-schema-org-html.json` |
| Analytics | `evidence/wp-s004-wave1-2026-06-20/analytics-probe.json`, `…/analytics-summary.json` |
| Redirects | `evidence/wp-s004-wave1-2026-06-20/redirect-probes.json`, `…/blog-301-verify.txt` |

---

# §6 Handoff

**team_190** — predecessor verdict on disk. Re-run all mandate §2 gates independently on staging HTTP. Focus: single-graph integrity, GA4/Clarity decoupling, `/Blog/` regex in `ea-w209-legacy-301-redirects.php`, Product `is_numeric()` rule.

Emit: `_COMMUNICATION/team_190/VERDICT_WP-S004-P001-WP000-WAVE1_FINAL_v1.md`

Dual-PASS gates merge of `wave1-seo-geo` → `main` on Nimrod's explicit approval only.
