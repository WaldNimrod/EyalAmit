---
id: VERDICT-WP-S5-01-VERIFY-2026-07-16
from_team: team_90
to_team: team_110
date: 2026-07-16
type: cross-engine-validation-result
wp: WP-S5-01
milestone: S005
gate: L-GATE_VALIDATE
mandate_ref: MANDATE-TEAM90-WP-S5-01-VERIFY-2026-07-16
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-01-LOD400-2026-07-16.md
builder_verdict_ref: _COMMUNICATION/team_110/VERDICT-WP-S5-01-BUILD-2026-07-16.md
evidence_root_builder: _COMMUNICATION/team_110/evidence/s5-01/
staging_base: https://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — WP-S5-01 VERIFY (team_90 cross-engine validation)

## Verdict flag

**PASS**

All 5 residual items (incl. 5.1 precheck + 5.2 postcheck) independently reproduced **PASS** on live staging + repo code. Builder claim (5/5, 0 regressions) confirmed. Item 4 correctly remains **OPEN-until-cutover** (staging-only; prod re-run = WP-S5-05).

---

## Iron Rule #1

| Role | Engine | Team |
|------|--------|------|
| Builder / self-verifier | claude-opus-4-8 (Claude Code) | team_110 |
| Independent validator | composer-2.5 (Cursor) | team_90 |
| Distinct vendors | **satisfied** | |

---

## Per-item results

| # | Item | Framing | Result | Evidence (team_90 independent) |
|---|------|---------|--------|--------------------------------|
| **1** | Blog pagination `/blog/page/N/` | VERIFY (already fixed) | **PASS** | Staging curl `-k` (no cookies): `/blog/`, `/blog/page/2/`, `/blog/page/3/`, `/blog/page/5/` → all **HTTP 200**, **0** `Location:` headers. Post-id sets distinct: p1=`228–239`, p2=`215–227`, p3=`204–221`, p5=`186–191`; **0 shared** post-ids across all 6 page-pairs. `page-numbers current` = URL page (1,2,3,5). Every page: `<main id="chapters-main">` present, **0** `id="main"`. Code: `site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-blog-archive.php` L15–19 reads `get_query_var('paged')` first. Corroborates `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/evidence/s5-01/blog-pagination/`. |
| **2** | FAQ section-TOC | VERIFY (already built) | **PASS** | `/faq/` → **HTTP 200**; `<nav class="ea-faq-toc">` present. **13** chip hrefs (`#faq-topic-*`) ↔ **13** target divs (`id="faq-topic-*"`); **0** broken anchors, **0** orphan targets. Code: `site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-faq-list.php` L58–79 builds TOC only from categories with questions. Corroborates `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/evidence/s5-01/faq-toc/`. |
| **3** | Shop-in-nav | VERIFY (already present) | **PASS** | `/` → **HTTP 200**; `<nav … id="nav">` block found. All **6** hrefs inside nav: `/shop/`, `/repair/`, `/didgeridoos/`, `/bags/`, `/stands-storage/`, `/stand-floor/`. Code: `site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-nav.php` L39–44 (builder cited `section-nav.php:39-44`; path is under `template-parts/chapters/`). Corroborates `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/evidence/s5-01/shop-nav/`. |
| **4** | QR direct-200 (49 rows) | VERIFY + prod caveat | **PASS (staging) — OPEN-until-cutover** | 49 rows parsed from `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/team-100-preplanning/QR-URL-INVENTORY.csv` via Python `csv` (quoted-comma titles preserved). Sequential/low-concurrency direct probe (no `-L`): **49/49 HTTP 200**, **0** `Location:` headers. First pass: 4 transient curl-`000` (`/qr/qr2/`, `/qr/qr16/`, `/qr/qr20/`, `/qr/qr40/`) — transport timeouts per guardrails; re-probed individually → all **200**, 0 locations. Prod-only 302 on `/qr/` **not** demanded here; builder caveat correctly stated. Corroborates `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/evidence/s5-01/qr-direct-200/results.tsv`. |
| **5.1** | Route-completeness precheck | VERIFY-ONLY (fix = WP-S5-02) | **PASS** | Saved builder HTML at precheck time (`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/evidence/s5-01/route-completeness-precheck/pages/`): GAP routes `/press/` (no meta, no CollectionPage), `/shows-heritage/` (no meta, no CollectionPage), `/qr/` (generic meta only, no Article), `/qr/qr1/` (no meta, no Article). Controls COMPLETE: `/repair/` + `/bags/` (meta + FAQPage), `/books/vekatavta/` (meta + Book), `/eyal-amit/mokesh-dahiman/` (meta + VideoObject). Builder code snapshot in `SUMMARY.txt`: `$map` 12 keys (no press/shows/qr); gate arrays in `ea-w2-seo-schema.php` had no press/qr/shows branches — confirmed against saved evidence + `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/evidence/s5-01/route-completeness-precheck/SUMMARY.txt`. *(Current HEAD now has WP-S5-02 keys — expected; see 5.2.)* |
| **5.2** | Route-completeness postcheck | VERIFY (WP-S5-02 deployed) | **PASS** | Live staging (2026-07-16): all 4 formerly-gapped routes now carry **non-empty meta** + **page-specific schema**: `/press/` → meta 105 chars + `CollectionPage`; `/shows-heritage/` → meta 97 chars + `CollectionPage`; `/qr/` → dedicated meta 104 chars + `Article`; `/qr/qr1/` → meta 156 chars + `Article`. Controls unchanged (FAQPage/Book/VideoObject). Code: `seo-head-fallbacks.php` L51–53 (`press`, `shows-heritage`, `qr`); `ea-w2-seo-schema.php` L235–291 (QR Article branch), L294–298 (`$ea_article_pages` CollectionPage). Gap closed — no bare gapped routes remain. |

---

## Environmental observations (not defects)

Per mandate guardrails — **not flagged as findings:**

| Observation | Disposition |
|-------------|-------------|
| Expired TLS on `*.upress.link` | Expected dev/staging; `curl -k` used |
| Site-wide `x-robots-tag: noindex` on all routes | `ea-staging-noindex.php` host-conditional; not route-specific |
| 4 transient curl-`000` on QR batch probe | Re-probed sequentially → 200; transport timeout, not redirect |
| QR item 4 prod 302 | Correctly **OPEN-until-cutover**; WP-S5-05 `final_pre_cutover_check.sh` |
| `/shows/` → **301** → `/shows-heritage/` | Bonus slug correction; recorded, not in AC |
| `validate_aos.sh` Check-32 roadmap drift | Pre-existing team_00/team_100 scope |

---

## Findings

**none** (blocker / major / minor)

No "already-built" item regressed. Builder prod caveat on item 4 is accurate and complete.

---

## route_recommendation

**None.** WP-S5-01 verification independently confirmed. Safe to treat L-GATE_VALIDATE for WP-S5-01 as satisfied pending team_00 gate routing.

- Item 4: remains **OPEN-until-cutover** (prod re-run mandatory at WP-S5-05).
- Item 5.2: gap closed on staging by WP-S5-02 deployment — aligns with separate `MANDATE-TEAM90-WP-S5-02-BUILD` validation scope.

---

## Evidence index (team_90 probe session)

| Probe | Method | Timestamp |
|-------|--------|-----------|
| Items 1–3 | Python + `curl -sk` staging | 2026-07-16 |
| Item 4 (49-row) | Python `csv` + sequential `curl -sk` | 2026-07-16 |
| Item 4 retry (4 URLs) | Sequential `curl -sk --max-time 90` | 2026-07-16 |
| Items 5.1 + 5.2 | Saved HTML parse + live staging curl | 2026-07-16 |
| Builder evidence corroboration | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/evidence/s5-01/` | 2026-07-16 |
