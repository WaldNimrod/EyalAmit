---
id: VERDICT-WP-S5-01-BUILD-2026-07-16
from_team: team_110
to_team: team_00
date: 2026-07-16
type: build-verify-result
wp: WP-S5-01
milestone: S005
gate: L-GATE_BUILD
next_wp: WP-S5-02
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-01-LOD400-2026-07-16.md
parent_index: _COMMUNICATION/team_100/S005/S005-PACKAGE-1-3-INDEX-2026-07-16.md
source_research: _COMMUNICATION/team_100/RESEARCH-WP-S5-01-GROUND-TRUTH-2026-07-16.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-01/
builder_engine: claude-opus-4-8 (Claude Code)
builder_team: team_110
staging_base: https://eyalamit-co-il-2026.s887.upress.link
result: PASS (5/5) — item 4 OPEN-until-cutover; item 5.2 DEFERRED
---

# VERDICT — WP-S5-01 build/verify (team_110, L-GATE_BUILD)

## Summary

**Verdict: `PASS` (5/5 items).**

WP-S5-01 is a **VERIFY** package (not a build). All 5 residual items were verified against staging with saved
evidence + a per-item PASS/FAIL result. **3/5 confirmed already-built-and-live** (no regression), **1/5 QR
direct-200 PASS on staging** (with a mandatory prod-only re-run caveat), **1/5 route-completeness verify-only
precheck PASS** (the fix is owned by WP-S5-02; no schema/meta built here).

| # | Item | Framing | Result | Evidence |
|---|------|---------|--------|----------|
| 1 | blog pagination `/blog/page/N/` | VERIFY (already fixed) | **PASS** | `evidence/s5-01/blog-pagination/` |
| 2 | FAQ section-TOC | VERIFY (already built) | **PASS** | `evidence/s5-01/faq-toc/` |
| 3 | shop-in-nav | VERIFY (already present) | **PASS** | `evidence/s5-01/shop-nav/` |
| 4 | QR direct-200 (49 rows) | VERIFY + prod caveat | **PASS (staging) — OPEN-until-cutover** | `evidence/s5-01/qr-direct-200/` |
| 5 | route-completeness schema/meta | VERIFY-ONLY (fix = WP-S5-02) | **PASS (5.1 precheck)** · 5.2 DEFERRED | `evidence/s5-01/route-completeness-precheck/` |

**No regressions found.** No "already-built" item flipped to FAIL, so there is **no route_recommendation back to
team_110**. Total evidence: 103 files across 5 subdirs.

---

## Item 1 — blog pagination · PASS

- `/blog/`, `/blog/page/2/`, `/blog/page/3/`, `/blog/page/5/` → all **HTTP 200** (no cookies).
- **Distinct post sets** per page (unique WP `post-NNN` article IDs): p1=228–239, p2=215–227, p3=204–221, p5=186–191.
  Distinctness matrix: **0 shared post-ids** across all 6 page-pairs.
- `page-numbers current` marker **matches the URL page number** on every page (1,2,3,5).
- **AC-1.4 — served by the LIVE template:** every page contains `<main id="chapters-main">` (=`tpl-chapters-blog-archive.php`)
  and **zero** `id="main"` (the dead `tpl-blog-archive.php` marker). The historical `$_GET['paged']`-only bug is
  fixed at `tpl-chapters-blog-archive.php:14-20` (reads `get_query_var('paged')` first). Asserted against the live
  template, not the dead one.

## Item 2 — FAQ section-TOC · PASS

- `/faq/` → **HTTP 200**; `<nav class="ea-faq-toc">` present.
- **13 chips** (`href="#faq-topic-<slug>"`) ↔ **13 target divs** (`id="faq-topic-<slug>"`) — **identical sets**,
  **0 broken anchors**, **0 orphan targets** (chips △ targets = ∅). Matches the research baseline of 13
  categories-with-questions (built at `block-faq-list.php:58-79` from categories that actually have questions).

## Item 3 — shop-in-nav · PASS

- `/` → **HTTP 200**; `<nav class="nav" id="nav">` block isolated (52 lines).
- All **6 hrefs present inside the nav block**: `/shop/` (hub) + `/repair/`, `/didgeridoos/`, `/bags/`,
  `/stands-storage/`, `/stand-floor/` (the hard-coded, template-fixed "כלים ואביזרים" dropdown,
  `section-nav.php:39-44`).

## Item 4 — QR direct-200 · PASS (staging) — **OPEN-until-cutover**

- 49 rows parsed from `docs/project/team-100-preplanning/QR-URL-INVENTORY.csv` (hub `/qr/` + `qr1`..`qr48`;
  Python `csv` parser used because 2 titles contain quoted commas).
- **All 49 DIRECT (no `-L`) = HTTP 200, zero `Location:` header** on staging; follow (`-L`) = **0 redirects**
  (no hidden staging redirect). Full table: `evidence/s5-01/qr-direct-200/results.tsv`.
- **Probing note:** high-concurrency probing produced transient curl-`000` (transport timeout on the slow shared
  staging host, never an HTTP redirect); re-probed at low concurrency then sequentially until every direct code
  was a clean 200. `000` = curl could not connect, `0` `Location` headers throughout.

> **⚠ MANDATORY PROD-ONLY CAVEAT (spec §4).** Staging PASS does **not** prove the documented prod-only 302 on
> `/qr/` is resolved. CSV row 1: *"VERIFIED 2026-05-26: parent /qr/ exists on prod but currently 302-redirects to
> /shop/books/וכתבת/"*. The redirect engine is prod-conditional; staging cannot substitute. **This item is
> `OPEN-until-cutover`** — `scripts/final_pre_cutover_check.sh` MUST re-run this exact 49-row check (no `-L`,
> assert 200 + no `Location`) **after** production cutover (WP-S5-05 §7 item 6). Do **not** mark it "closed" from
> staging evidence alone.

## Item 5 — route-completeness schema/meta · PASS (5.1 precheck, VERIFY-ONLY)

**No build performed here** — the schema/meta fix is owned by **WP-S5-02** (Option A). This item only verifies the
canonical gap list (5.1). **5.2 postcheck (confirm coverage after S5-02 builds) is DEFERRED** — WP-S5-02 has not
built yet.

Canonical gap list **confirmed exactly** — and no covered route class exhibits the gap:

| route | HTTP | meta-description | page-specific schema node | verdict |
|-------|------|------------------|---------------------------|---------|
| `/press/` | 200 | MISSING | none (base graph only) | **GAP** (meta+schema) |
| `/shows-heritage/` | 200 | MISSING | none (base graph only) | **GAP** (meta+schema) |
| `/qr/` (hub) | 200 | generic-auto* | none (no `qr` branch) | **GAP** (schema + no dedicated meta) |
| `/qr/qr1/` (repr. of 48) | 200 | MISSING | none (base graph only) | **GAP** (meta+schema) |
| `/repair/` (control) | 200 | PRESENT (`$map`) | FAQPage | COMPLETE |
| `/bags/` (control) | 200 | PRESENT (`$map`) | FAQPage | COMPLETE |
| `/books/vekatavta/` (control) | 200 | PRESENT (`phero.sub`) | Book, FAQPage | COMPLETE |
| `/eyal-amit/mokesh-dahiman/` (control) | 200 | PRESENT (`phero.sub`) | VideoObject | COMPLETE |

\* `/qr/` hub meta = "כל עמוד קשור לקוד QR מודפס באחד הספרים." — auto/generic, **not** a dedicated `$map` entry.

**Code cross-check (source of coverage):**
- `inc/seo-head-fallbacks.php` `$map` (L38-51): 12 keys (eyal-amit, shop, didgeridoos, bags, stands-storage,
  stand-floor, repair, books, muzza, blog, faq, contact) — **no** `press`/`shows-heritage`/`qr`.
- `mu-plugins/ea-w2-seo-schema.php`: gate arrays `$services` (L99), `$ea_faq_pages` (L150), `$ea_book_slugs`
  (L180), Person=`mokesh-dahiman` only (L199) — **none** of `press`/`qr`/`shows`.

**noindex clarification (spec §5.1):** `x-robots-tag: noindex, nofollow` appears on **all 8 probed routes** —
COMPLETE and GAP alike — so it is the site-wide staging plugin `ea-staging-noindex.php` (host-conditional on
`upress.link`), **not** a route-specific editorial noindex; it will **not** exist on production.

**Bonus (recorded, WP-S5-03/legacy scope):** `/shows/` (old slug) → **301** → `/shows-heritage/` on staging —
validates the spec's `/shows/`→`/shows-heritage/` slug correction.

---

## Environmental note (pre-existing, out of team_110 scope)

`bash validate_aos.sh .` = **47 PASS / 30 SKIP / 1 FAIL**. The single FAIL is **Check 32: uncommitted
`_aos/roadmap.yaml` drift** — the prior team_100 LOD400-authoring change (lod_status LOD200→LOD400 + spec_ref +
parent_index for WP-S5-01/02/03), already present in the session-start git status. It is a **team_00/team_100**
concern ("Run aos_sync_all.sh via team_00/team_100"), outside team_110's authority (team_110 never writes `_aos/`),
and unrelated to WP-S5-01 verification. Flagged, not touched.

## Iron Rule #1 attestation

| Role | Engine | Team |
|---|---|---|
| Builder / verifier (this evidence + verdict) | claude-opus-4-8 (Claude Code) | team_110 |
| Independent cross-engine validation of this execution | (non-Claude, e.g. composer-2.5) | team_90 — **separate step, at team_00's routing discretion** |

The LOD400 spec itself was already cross-engine validated to a clean PASS (VERDICT-S005-LOD400-COVERAGE-CYCLE3,
builder Claude/team_100, validator composer-2.5/team_90, 0 findings). Independent team_90 re-validation of *this
build/verify execution* is a team_00 routing decision, not performed in this 110-scoped session.

## route_recommendation

**PROCEED to WP-S5-02.** WP-S5-01 verification is clean (5/5 PASS, 0 regressions). Item 4 remains
`OPEN-until-cutover` (prod re-run mandatory, WP-S5-05). Item 5's fix is built by WP-S5-02 (this precheck confirmed
the exact route set). Canonical build handoff for WP-S5-02 generated per index §7.2; `activation_block` presented
inline to team_00 — **no build starts until team_00 routes team_110.**
