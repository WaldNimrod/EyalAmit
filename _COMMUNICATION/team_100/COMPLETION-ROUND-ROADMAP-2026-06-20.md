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
| SEO-B2 | **Sitemap URL contradiction** — plan/robots say `wp-sitemap.xml` but the live 301 maps `/מפת-אתר/ → /sitemap_index.xml` (Yoast convention); theme-native (D4) emits neither by default — pick ONE + make robots/GSC/301 agree | exec-plan critic; 301 doc; gen MANUAL_MAP |
| SEO-B3 | **48 `/qr/qr*/` pages embed raw YouTube iframes** — real video footprint not covered by WP-07; assign facade/lazy/transcript | exec-plan critic |
| SEO-B4 | **CF7 is wired but server-gated** — `form_id=0` because CF7 isn't active on the server; needs CF7 activation + SMTP/deliverability + spam protection + a real end-to-end lead-receipt test | exec-plan critic |
| SEO-B5 | **Route enumeration gaps** — `/shows/ /repair/ /bags/ /stand-floor/ /stands-storage/ /books/* /about/moksha/ /press/ + 48 /qr/` get no schema/meta/title/OG → thin pages at cutover; enumerate or noindex | exec-plan critic |
| SEO-D | **Open decisions (carry as gates):** D1 official business name (drop "סטודיו נשימה מעגלית"), D3 allow GPTBot, D5 ProfessionalService+Person, D7 therapy-lead conversion, D12 verify real keyword volumes, D13 EN out-of-scope | exec-plan §12 |

## §4 — 301 / redirect-map cutover gaps → M7 (Track B)
| ID | Gap / remainder | Status | Source |
|----|----|----|----|
| 301-1 | **`/Blog/ → /blog/` migration is NOT live** (catch-all + 54 per-slug). **Generator-level gap:** the PHP emit uses exact-match `isset()` and can't express a regex prefix; the 54 decisions are `keep`. Must teach `gen_htaccess_301_from_decisions.py` to emit a PHP `preg_match('#^/Blog/(.+)#i')→301` (or per-slug). Re-running as-is won't help. | 🟠 | 301 doc §6; quarantine README |
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
