# Completion Round — gaps & remainders register (team_100 roadmap, 2026-06-20)

**Purpose:** the single internal SSoT for everything still open to take EyalAmit.co.il-2026 to launch — the "סבב הסיום
להשלמה". Every gap/remainder surfaced across this session, mapped to the client-hub milestones (M5 build/SEO completion ·
M6 design-QA/responsive · M7 production cutover), with status, blocker, owner, and source artifact. Engineering complement
to the client-facing `hub/data/roadmap.json` (M1-M4 ✅, M5 in-progress, M6/M7 not-started).

**Status legend:** 🔴 blocked-on-Eyal · 🟠 blocked-internal/dependency · 🟡 ready-to-build (no blocker) · 🔵 needs-decision · ✅ closed this session.

---

## §1 — Eyal-dependent (launch-blocking; awaiting Eyal) → M5/M7
| ID | Gap / remainder | Status | Owner | Source |
|----|----|----|----|----|
| EYL-1 | **Microsoft Clarity `project_id`** (GA4 received; Clarity missing → analytics gate stays dark) — PDF guide prepared | 🔴 | Eyal (via team_00) | INTAKE §2.C; Clarity guide PDF |
| EYL-2 | **Mokesh FULL-film link** (only the *trailer* `kf4NKSdYi9E` is public; the ~60-min film by Eyal & Guy Amit isn't on a public URL) — needed for the lower-page embed | 🔴 | Eyal | MOKESH-MEDIA-CAPTURE; 301/handoff |
| EYL-3 | **Media intake — 38 items** (9 🔴 needs-new incl. service-page hero backgrounds + a real Eyal studio portrait to replace the press-clipping scan; 11 🟡 gallery/product placeholders incl. 6 empty shop galleries) | 🔴 | Eyal (intake page live; filling over the weekend) | MEDIA-INVENTORY-REPORT; media-intake.html |
| EYL-4 | **Testimonials curation** — 48 received; select + snippet for the carousel + per-service routing; Eyal to confirm in hub | 🔴/🔵 | Eyal + team_100 | INTAKE §2.B |
| EYL-5 | **Courses ("קורסים") external URL** — `#` placeholder in top-nav | 🔴/🔵 | Eyal/team_00 | LOD200-EYAL-DEPENDENT |
| EYL-6 | **`/shop/תקנון/` 301 target** — interim `→ /` per mandate; a live `/terms/` page exists (better target) | 🔵 | Eyal confirm | gen script MANUAL_MAP; 301 doc |
| — | ✅ **Closed this session:** mokesh full doc + bio + dates (1950–2020), mokesh photos (same 19, same order) + 4 FB embeds, studio NAP (עמל 8 ב' פרדס חנה) + hours (Sun–Thu 9–19 / Fri 9–14 / Sat closed), GA4 `G-MRXESK7QJF`, WhatsApp, brand spelling decision (Jungle Vibes), the mokesh video UX (hero trailer + full film lower) | ✅ | — | INTAKE; NAP SSoT |

## §2 — Content build / implementation (post-intake handoff T1–T8) → M5 · 🟡 ready
| ID | Gap / remainder | Status | Source |
|----|----|----|----|
| BLD-1 | **Mokesh rebuild (16-E v2)** — full memorial verbatim (`Jungle Vibes`), HERO trailer (autoplay/muted/unmute), 19 photos in order, full film lower (gated EYL-2), 4 FB embeds; re-point content-diff gate to the full doc | 🟡 (full film gated) | handoff T1; MOKESH-MEDIA-CAPTURE |
| BLD-2 | **Testimonials integration** — build the curated 48 into carousel + service pages (gated EYL-4 selection) | 🟡/🔴 | handoff T2 |
| BLD-3 | **Analytics wiring** — reconcile in-theme `analytics-config.json` to `G-MRXESK7QJF` + **split `ea_wave2_print_analytics_head()`** so GA4 fires without Clarity (== SEO WP-01/T16) | 🟡 | handoff T3; LOD400 D11 |
| BLD-4 | **Contact page + LocalBusiness NAP/hours** — address is MISSING on /contact today; add NAP + hours + `LocalBusiness` JSON-LD (drop-in ready) | 🟡 | handoff T8; BUSINESS-NAP SSoT |
| BLD-5 | **Hub refresh** — mark received items, reflect reality | 🟡 | handoff T4 |
| BLD-6 | **verbatim↔spelling gate handling** — normalize spelling in the content-diff gate vs the verbatim source | 🔵 | handoff §E.3 |

## §3 — SEO/GEO execution (the major round) → M5, ongoing into M7
Full plan: **`SEO-GEO-EXECUTION-PLAN-2026-06-20.md`** — 13 canonical WPs (P1 quick-wins → P2 foundational → P3 ongoing + WP-12 gated cutover). Headline gap: the site **leaks ~⅓ of leads + measures 0 conversions** (WP-01).
**Pre-build blockers the completeness critic flagged (MUST resolve before/while building):**
| ID | Blocker | Source |
|----|----|----|
| SEO-B1 | **Sleep-apnea pillar URL not buildable as a `/treatment` child** — `wave2-w2-04.php` matches top-level pages only (`post_parent==0`); make it top-level OR extend the injector | exec-plan critic |
| SEO-B2 | ✅ **CLOSED (2026-06-21).** Sitemap reconciled at **`/sitemap_index.xml`** — live-verified: `/sitemap_index.xml` → 200 (Yoast), `/wp-sitemap.xml` → 301 → it, legacy `/מפת-אתר-site-map/` 301 already targets it. robots + GSC + 301 all name `/sitemap_index.xml`. The "404 / contradiction" critic claim was **stale** (no 404). | team_100 live verify; DEC-SEO-B2 |
| SEO-B3 | **48 `/qr/qr*/` pages embed raw YouTube iframes** — real video footprint. ✅ **Ownership pinned to WP-07** (facade/lazy/transcript + CWV) in the umbrella WP (2026-06-21). | exec-plan critic; WP000 §3 |
| SEO-B4 | **CF7 is wired but server-gated** — `form_id=0` because CF7 isn't active on the server; needs CF7 activation + SMTP/deliverability + spam protection + a real end-to-end lead-receipt test | exec-plan critic |
| SEO-B5 | **Route enumeration gaps** — `/shows/ /repair/ /bags/ /stand-floor/ /stands-storage/ /books/* /eyal-amit/mokesh-dahiman/ /press/ + 48 /qr/` get no schema/meta/title/OG → thin pages at cutover; enumerate or noindex. (Canonical memorial = `/eyal-amit/mokesh-dahiman/`; `/about/moksha/` is a 301 source → it, not a schema target.) | exec-plan critic; WP000 AC-11 |
| SEO-D | **Open decisions (carry as gates):** D1 official business name (drop "סטודיו נשימה מעגלית"), D3 allow GPTBot, D5 ProfessionalService+Person, D7 therapy-lead conversion, D12 verify real keyword volumes, D13 EN out-of-scope | exec-plan §12 |

## §4 — 301 / redirect-map cutover gaps → M7 (Track B)
| ID | Gap / remainder | Status | Source |
|----|----|----|----|
| 301-1 | ✅ **FIXED (W1-06):** `/Blog/<slug> → /blog/<slug>` now LIVE — taught the generator to emit a PHP `preg_match('#^/Blog/(.+)$#')→/blog/$1` block; verified on staging (301). `verify-301-blog.sh` now passes. | ✅ | W1-06 `48676f4` |
| 301-2 | **Dead verification harness** — `final_pre_cutover_check.sh` skips pattern rules; `verify-301-blog.sh` probes `/Blog/` expecting a 301 inert on nginx. Fix when 301-1 closes. | 🟠 | 301 doc §6 |
| 301-3 | **Stale exports quarantined** ✅ + **deploy-script fixed** ✅ + **`/מוזה-…/→/books/` drift fixed at source** ✅ — done this session; SSoT (mu-plugin) now faithful + idempotent | ✅ | 301-MAP-RECONCILIATION |

## §5 — Final design-QA + UI + full-responsive → M6 · 🟠 (depends on content-complete)
LOD200 written (`LOD200-DESIGN-QA-UI-RESPONSIVE`). QA-led find→fix→re-verify against the team_35 mockups (automated gates pass but don't catch visual-fidelity); full responsive sweep. Polish only — no new features. Blocked on M5 content-complete + the media (EYL-3).

## §6 — Production cutover → M7 · 🟠 Track B (gated)
LOD200 written (`LOD200-PRODUCTION-CUTOVER`). The public domain `eyalamit.co.il` still serves the LEGACY site (host: mezoohost). Cutover = 301 SSoT freeze + redirect/404 audit (incl. 301-1/301-2) + lift staging noindex + sitemap resubmit + GSC baseline + DNS switch. Gated on launch-blockers (analytics EYL-1, NAP done, mokesh final, media EYL-3).

## §7 — Governance / DB → spans M5–M7 · 🟠 BLOCKED
DB reconciliation is **blocked on the team_110 actor key** (hub-API writes 401 `INVALID_ACTOR_KEY`; `WP-W2-*` IDs are DB-schema-invalid). On key arrival: register these completion items as canonical WPs (S004 + the 13 SEO/GEO WPs), migrate the 50-WP file roadmap to canonical IDs, lock WP-W2-16. Request pending: `REQUEST-TEAM110-HUB-API-KEY-AND-DB-MIGRATION-2026-06-16.md`.

---

## Milestone mapping (client roadmap M5–M7)
- **M5 (build/SEO completion):** §2 BLD-1…6 · §3 SEO P1+P2 WPs + blockers · EYL-1/3/4 integration as they arrive.
- **M6 (design-QA + responsive):** §5 — after M5 content + media complete.
- **M7 (production cutover):** §3 WP-12 · §4 301-1/301-2 · §6 — gated on launch-blockers.
- **Cross-cutting:** §1 Eyal-dependent (drives M5/M7 timing) · §7 governance/DB (team_110).

**Critical path to launch:** team_110 key → register WPs · Eyal: Clarity + media (EYL-1/3) · build M5 (incl. WP-01 lead-leak fix + JSON-LD) → M6 design-QA → close 301-1 + harness → M7 cutover.


---

## Status snapshot — 2026-06-20 EOD (Wave-1 shipped · what remains)

### ✅ DONE + LIVE
- **Wave-1 SEO/GEO core — merged to `main` (817e05b) + live on staging + dual-PASS (team_50+team_190):** lead-leak fix (WhatsApp+form for all, GA4 `G-MRXESK7QJF` fires independently, `generate_lead`, wa.me pre-fill), entity schema via Yoast `wpseo_schema_graph` (Person/ProfessionalService/Service/Product, single graph), `/Blog/→/blog/` 301.
- **wave1b — FAILED Round-2 v1 → FIXED → PENDING rev2** (see the **2026-06-21 update** at the end): team_50 v1 = FAIL (`/blog/` emitted 0 meta); team_100 fixed the blog-archive meta branch (theme 1.4.15) + redeployed; awaiting team_50 v2 → team_190. Batch: `/shop/cart|checkout|my-account → /shop/` 301; per-route meta (now incl. the `/blog/` archive); contact NAP; LCP fetchpriority.
- **Earlier this session:** 301-map reconciliation (+/muzza fix, quarantine), media inventory (38) + hub intake page, 15 content proposals + hub page, SEO/GEO canonical WP `S004-P001-WP000` + validation/deploy plan + Wave-1 scope; Yoast-reality correction.

### 🟡 NON-Eyal-gated
**Completed in the wave1b pass (deployed to staging):** `/shop/cart|checkout|my-account → /shop/` 301 · per-route meta descriptions (9 bare routes) · **contact-page visible NAP/hours (BLD-4 — Eyal's flagged gap)** · LCP `fetchpriority` on /eyal-amit (W1-05a) · `/Blog/` 301 (W1-06 = 301-1).
**Deferred — still non-blocked but low-priority / cutover-time / risk (not worth doing now):**
- Full **WebP `<picture>`** image pass — marginal CWV gain + layout-regression risk; do as a dedicated QA'd perf pass (cwebp/Pillow ready).
- ✅ **`final_pre_cutover_check.sh` QR assertion — FIXED (2026-06-21).** Live verification corrected the critic's premise: the CSV's 49 rows (parent `/qr/` + 48 `/qr/qrN/`) are ALL correctly 200 on staging (it was **not** a 49→48 count error); `/qr/פרק-א/` → 410 is covered by section (b). Real fix applied: section (c) now asserts **DIRECT 200** (no redirect-follow) so the documented prod 302 on parent `/qr/` can't be masked. bash + embedded-python syntax-checked.
- **Hub `materials-needed.json` refresh** — superseded by the live media-intake + content-proposals pages; low-urgency.
- **Round-2 validation + merge** of wave1b — the next external-validation boundary.

### 🔴 BLOCKED on Eyal — cannot advance without his input (THE open list)
1. **Microsoft Clarity `project_id`** (EYL-1) — PDF guide sent; Clarity tag stays dormant (GA4 already live).
2. **Mokesh FULL-film link** (EYL-2) — only the trailer is public; needed for the lower-page embed in the mokesh rebuild.
3. **Media — 38 items** (EYL-3) — 9 *needs-new* (service-page hero backgrounds; a real studio portrait to replace the press-clipping scan) + 11 placeholders (6 empty shop galleries, blog/product images). Eyal fills via `media-intake.html`.
4. **Testimonials curation** (EYL-4) — 48 received; Eyal selects/edits via the hub.
5. **Content proposals — 15** (CP/AF/BN/FAQ/BLOG) — Eyal approves via `content-proposals.html`. **Unblocks the #1 content lever** (the sleep-apnea/snoring pillar + answer-first + business-name reframe + FAQ + blog spokes). W1-03 (pillar URL mechanism) is buildable but pointless until the content is approved → effectively content-gated.
6. **Product prices** — Eyal sets numeric `ea_product_price` in WP admin → the Product/Offer schema (already built) activates.
7. **Courses ("קורסים") URL** (EYL-5); **`/shop/תקנון/` target** confirm (`/terms/` exists) (EYL-6).
8. **GBP claim + Wikidata item** (D6/off-site) — need Eyal's Google/Wikidata account access; the on-site NAP + sameAs are already wired.
9. **Mokesh page rebuild (16-E v2)** — bio/dates/photos resolved (same 19 + 4 FB embeds); still needs EYL-2 (full film) + content approval before the verbatim rebuild.

> Net: the SEO/GEO **machine layer** (schema, analytics, redirects, meta, conversion) is essentially shipped; the **content + media + off-site** layers are the remaining value, and those are mostly gated on Eyal (hub approvals + media + accounts). The single highest-leverage unblock is Eyal approving the **content proposals** (sleep-apnea pillar).

---

## Status update — 2026-06-21 (Wave-1b rev2 + spec reconciliation)

**Trigger:** team_50 v1 cross-engine verdict on Wave-1b came back **FAIL** (not "pending" as the prior handoff stated) — single blocker `B-W1B-META-01`: `/blog/` emitted 0 `<meta name="description">`. 7/8 gates had passed.

### ✅ Done + verified this session
- **`B-W1B-META-01` fixed.** Root cause: `ea_w2_09_route_description()` early-returned unless `is_page()`, so the `/blog/` posts archive (`is_home()`) was skipped + the tagline fallback is empty. Added an `is_home() && ! is_front_page()` branch (single source of truth = `$map['blog']`). Self-QA GREEN: `/blog/` 0→1, `/blog/page/2/`=1, all 12 mandate routes=1 (no dup), single post=0 (no dup introduced). Theme 1.4.14→**1.4.15**, redeployed to staging. `php -l` clean.
- **`F-W1B-META-02` (`/muzza/`) dispositioned** — `/books/` canonical accepted; dead map entry documented. Closed, not a re-validation item.
- **Spec docs reconciled to live reality** (3 files): WP umbrella + exec-plan + validation-plan — Yoast = live schema engine (D4; WP-02 EXTENDS via `wpseo_schema_graph`, not hand-rolled); Moksha canonical = `/eyal-amit/mokesh-dahiman/` (D10 re-scoped content-only); **DEC-SEO-B2 CLOSED** at `/sitemap_index.xml`. New ACs: **AC-12b** (contact wa.me/tel always exposed), **AC-17** (Track-A rollback triggers), **AC-18** (in-content link canonicalization — no 301 sources), **AC-19** (per-post meta). Full brand-string enumeration (6 files/12 occ incl. 2 SEED files needing re-seed). WP-07 owns the 48 QR raw-iframes.
- **Harness fix** — `final_pre_cutover_check.sh` QR check now asserts DIRECT 200 (see §4 deferred list above).
- **Two critic claims disproved by live verification:** sitemap "404" (SEO-B2) and QR "49→48" — both were stale; docs corrected to truth, not propagated.
- **Governance:** `validate_aos.sh` = 43 PASS / 0 FAIL.

### ✅ Wave-1b DUAL-PASS achieved (2026-06-21) — merge pending Nimrod "מאשר"
- **team_50 v2** = PASS_WITH_FINDINGS (`VERDICT_…WAVE1B_v2.md`) · **team_190 final** = PASS_WITH_FINDINGS, no blockers (`_COMMUNICATION/team_190/VERDICT_WP-S004-P001-WP000-WAVE1B_FINAL_v1.md`, evidence `…/wp-s004-wave1b-final-2026-06-21/`). All 8 gates green; meta 13/13 re-confirmed live; `B-W1B-META-01` resolved.
- team_190 sole content-diff fail = `/eyal-amit/mokesh-dahiman/` — **out of Wave-1b scope** (concurrent team_110 mokesh workstream). Non-blockers: single-post meta (WP-04), version drift 1.4.16.
- **Merge plan (on "מאשר"):** scope-commit ONLY `inc/wave2-w2-09.php` (concurrent catalog work + `style.css` 1.4.16 stay with `mokesh-content`); merge `wave1b-seo-geo` → `main` via an isolated worktree so the shared dirty tree is untouched; merge-commit style (like the Wave-1 merge). Origin push separate, on "פוש".
- **New non-blocker logged:** single blog posts emit 0 meta (AC-19 → WP-04 head pack). Not a Wave-1b failure.
- **Git posture:** fix is live on staging (validation surface) but **uncommitted** per commit-gating; working tree also holds the prior session's verdict/script/docx untracked files — to be committed in their own commit(s) at merge time, kept out of the code-fix commit. **Branch note:** HEAD is currently on `mokesh-content`, which points to the SAME commit (`91e2765`) as `wave1b-seo-geo` — at commit time the meta fix must land on `wave1b-seo-geo` (checkout there, or fast-forward it) so the `wave1b-seo-geo` → `main` merge includes it.
