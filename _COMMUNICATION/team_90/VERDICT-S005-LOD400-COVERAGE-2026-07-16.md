---
id: VERDICT-S005-LOD400-COVERAGE-2026-07-16
from_team: team_90
to_team: team_100
date: 2026-07-16
type: validation-result
mandate_ref: MANDATE-TEAM90-S005-LOD400-COVERAGE-2026-07-16
validator_engine: composer-2.5 (Cursor)
builder_engine: claude-opus-4-8 (Claude Code)
correction_cycle: 1
wp: S005-PACKAGE-1-3 (WP-S5-01, WP-S5-02, WP-S5-03)
---

# VERDICT — S005 LOD400 coverage (packages 1+2+3, team_90, cross-engine)

## Summary

**Verdict: `PASS_WITH_FINDINGS`**

Cross-engine validation (Iron Rule #1: builder = Claude Code / team_100; validator = composer-2.5 / team_90) of the four target LOD400 artifacts against live repo code, `_aos/roadmap.yaml`, and the three RESEARCH ground-truth documents.

| Check area | Result |
|---|---|
| Spot-check vs live code (10 claims) | **10/10 PASS** — no code/spec line-reference mismatches |
| Buildability (3 WPs) | **PASS** — files, build sequence, measurable ACs present; 2 minor ambiguities (non-blocking) |
| Coverage matrix + overlap S5-01↔S5-02 | **PASS** — all RESEARCH findings mapped; verify-only vs BUILD split clean |
| `next_wp` consistency (3 sources) | **PASS** — S5-01→S5-02, S5-02→S5-05, S5-03→S5-05 aligned |
| Option A (index+schema) | **PASS** in LOD400 docs — consistent §0/§2.1/§2.6; fallback not a loophole |
| Deterministic hygiene | **PASS** — dates, WP frontmatter, YAML parse; 2 roadmap `notes` drift items (minor) |

**Blockers: 0.** Four minor findings documented below; none prevent team_110 from starting WP-S5-01 / WP-S5-03 or block LOD400 handoff after optional note cleanup.

---

## 1) Spot-check — live code vs spec claims (10/10 PASS)

| # | Spec claim | Spec location | Live source | Result |
|---|------------|---------------|-------------|--------|
| 1 | Blog archive routed via `ea_chapters_blog_template_include()` @ priority **105** → `tpl-chapters-blog-archive.php` | WP-S5-01 §1 L42-44 | `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-routing.php` L84-104, `add_filter(..., 105)` L104 | **PASS** |
| 2 | Pagination fix uses `get_query_var('paged')` first in `tpl-chapters-blog-archive.php:14-20` | WP-S5-01 §1 L45-47 | `page-templates/tpl-chapters-blog-archive.php` L15-19 | **PASS** |
| 3 | FAQ TOC built in `block-faq-list.php:58-79`; targets `id="faq-topic-*"` @ L90 | WP-S5-01 §2 L64-65 | `template-parts/blocks/block-faq-list.php` L58-79, L90 | **PASS** |
| 4 | Shop routes in nav `section-nav.php:36-46` | WP-S5-01 §3 L84-85 | `template-parts/chapters/section-nav.php` L39-44 (`/shop/`, `/repair/`, `/didgeridoos/`, `/bags/`, `/stands-storage/`, `/stand-floor/`) | **PASS** |
| 5 | QR-URL-INVENTORY.csv = **49 data rows** (parent + qr1..qr48) | WP-S5-01 §4 L106-107 | `docs/project/team-100-preplanning/QR-URL-INVENTORY.csv` — 50 lines total, 1 header + 49 data rows | **PASS** |
| 6 | `$services` L99-103; Product Offer gated `is_numeric()` L135; no `qr`/`press`/`shows-heritage` branches | WP-S5-02 §2.0 L61-68 | `site/wp-content/mu-plugins/ea-w2-seo-schema.php` L99-103, L135, L235 `return $graph`; grep: no `press`/`shows-heritage`/`qr` | **PASS** (gap correctly described) |
| 7 | Mokesh `VideoObject` template L220-231 (`youtube-nocookie` embedUrl) | WP-S5-02 §2.2 L86-89 | `ea-w2-seo-schema.php` L220-231 | **PASS** |
| 8 | Meta `$map` L38-51; post excerpt fallback L57-62; no `press`/`shows-heritage` | WP-S5-02 §2.0 L65-66, §2.4 | `inc/seo-head-fallbacks.php` L38-51, L57-62; no `press`/`shows-heritage`/`qr` keys | **PASS** |
| 9 | QR seed flag `ea_w2_07_qr_seeded_v3` check L92, set L145; source 46/46 `youtube-nocookie`, 0 plain `youtube.com/embed` | WP-S5-02 §3 L141-145, L134-135 | `ea-w2-07-qr-seed-once.php` L92, L145; `ea-w2-07-qr-content-data.php` — 46× `youtube-nocookie`, 0× `youtube.com/embed` | **PASS** |
| 10 | Legacy redirects: func L11, 2×410 L25, `/Blog/` regex L31-33, hook L80; SSoT 135 decisions; gen writes htaccess L262 + PHP L340-341; 32×301 in live map | WP-S5-03 §2 L63-72 | `ea-w209-legacy-301-redirects.php` L11, L20-26, L31-33, L38-72 (32 map entries), L80; JSON `decisions: 135`; `gen_htaccess_301_from_decisions.py` L262 (`OUT.write_text`), L340-341 (`php_out.write_text`) | **PASS** |

Additional confirmation: `scripts/qa/seo_probe.config.json` has **no** entries for `/press/`, `/shows-heritage/`, or `/qr/*` — consistent with WP-S5-02 §5 (harness gap to be closed by build).

---

## 2) Buildability (LOD400 bar)

### WP-S5-01 — **PASS**

| Requirement | Status |
|---|---|
| Target files | N/A (verify-only) — explicit §0 |
| Build sequence | Per-item AC-1..5 with evidence paths |
| Measurable ACs | All 5 items have curl/qa criteria + `evidence/s5-01/*` |
| Item 5 overlap | §5 + §6: **verify-only**; no schema/meta build instructions |

### WP-S5-02 — **PASS** (1 minor ambiguity)

| Requirement | Status |
|---|---|
| Target files | §0 lists 4 touch points (`ea-w2-seo-schema.php`, `seo-head-fallbacks.php`, `seo_probe.config.json`, option reset) |
| §2.2 QR branch | Step-by-step: parent-slug detection, `Article` node, YouTube regex, `VideoObject` cloned from mokesh L220-231, omit `uploadDate` when unknown |
| §2.3 press/shows-heritage | `$ea_article_pages` map + `CollectionPage` node shape specified |
| §2.4 meta | Copy provided for `press` + `shows-heritage`; QR children via excerpt branch |
| §2.5-§2.6 AC | Rich Results sample + documented noindex fallback (future-only, not built now) |
| §3.1 reseed | Exact WP-CLI action; no mu-plugin edit |
| §5 harness | `expectedTypes` per route class |

A fresh builder can implement QR + press/shows branches **without guessing** the schema/meta shape. Hub `/qr/` meta alone allows two valid paths (see F-02).

### WP-S5-03 — **PASS**

| Requirement | Status |
|---|---|
| SSoT-first workflow | §3.4: edit JSON → run gen script → verify regeneration; no hand-edit |
| Pattern A + B | §3.2-§3.3 name root causes + mirror/slug mapping examples |
| Full triage | §3.1 method + `triage.csv` 400-row AC |
| §4 54 blog slugs | BUILD/DECIDE with AC + pointer to reconciliation doc |
| §6 out-of-scope | Prod-only items explicitly excluded from staging AC |

---

## 3) Coverage matrix + S5-01↔S5-02 overlap

### RESEARCH → index §3 mapping — **PASS (no orphans)**

| RESEARCH source | Findings | Index §3 row(s) | LOD400 owner |
|---|---|---|---|
| S5-01 Item 1 (blog pagination) | Already fixed | #1 | WP-S5-01 VERIFY |
| S5-01 Item 2 (FAQ TOC) | Built | #2 | WP-S5-01 VERIFY |
| S5-01 Item 3 (shop nav) | Present | #3 | WP-S5-01 VERIFY |
| S5-01 Item 4 (QR direct-200) | Staging pass + prod caveat | #4 | WP-S5-01 VERIFY |
| S5-01 Item 5 = S5-02 Item 2 (route schema/meta) | Gaps: press, shows-heritage, QR | #5, #7-#9 | **WP-S5-02 BUILD** / WP-S5-01 verify-only |
| S5-02 Item 1 (sitemap) | Reconciled | #6 | WP-S5-02 NO-OP |
| S5-02 Item 3 (QR CWV) | Lazy live; reseed needed | #10 | WP-S5-02 PARTIAL |
| S5-02 Item 4 (Offer/price) | Code correct, dormant | #11 | CONTENT-TASK |
| S5-03 Steps 1-3 (400 URL triage, 2 roots) | 9 gaps / 2 patterns | #12-#14, #16 | WP-S5-03 BUILD |
| S5-03 Step 4 (54 blog slugs) | Open TODO | #15 | WP-S5-03 BUILD/DECIDE |
| S5-03 www/scheme + orphan destination | Out of staging scope | #17 | WP-S5-05 |

Cross-notes in RESEARCH (S5-01↔S5-02 item 5/2) are explicitly resolved in index §3.1.

### Overlap S5-01 ↔ S5-02 — **PASS (no duplicate build, no ownership gap)**

| Document | route-completeness treatment |
|---|---|
| WP-S5-01 §5 | **VERIFY-ONLY** — §5.1 pre-check list; §5.2 post-S5-02 validation; §5.3 AC: "אין בנייה בפריט זה" |
| WP-S5-02 §2 | **BUILD (Option A)** — full schema/meta implementation §2.2-§2.4 |
| Index §3.1 | Ownership = WP-S5-02; S5-01 confirms list + post-build regression |

No contradictory build instructions for schema/meta in WP-S5-01.

---

## 4) `next_wp` consistency (3 sources) — **PASS**

| WP | Frontmatter | `_aos/roadmap.yaml` | Index §7.1 | Match |
|---|---|---|---|---|
| WP-S5-01 | `next_wp: WP-S5-02` (L8) | L2031 `next_wp: WP-S5-02` | L155 | **YES** |
| WP-S5-02 | `next_wp: WP-S5-05` (L8) | L2057 `next_wp: WP-S5-05` | L156 | **YES** |
| WP-S5-03 | `next_wp: WP-S5-05` (L8) | L2081 `next_wp: WP-S5-05` | L157 | **YES** |

Roadmap `lod_status: LOD400` + `spec_ref` + `parent_index` for all three WPs: confirmed at `_aos/roadmap.yaml` L2024-2030, L2050-2056, L2074-2080.

YAML parse: `python3 -c "import yaml; yaml.safe_load(open('_aos/roadmap.yaml'))"` — **exit 0**.

---

## 5) Option A decision (WP-S5-02) — **PASS**

| Location | Statement | Consistent? |
|---|---|---|
| Index §2.1 | index + schema/meta for all gapped routes; noindex = post-cutover fallback only | Yes |
| WP-S5-02 §0 | Option A: index + dedicated schema/meta — not noindex | Yes |
| WP-S5-02 §2.1 | Canonical route list uses `/shows-heritage/` (not stale `/shows/`) | Yes |
| WP-S5-02 §2.6 | Fallback documented as **future reversible** mu-plugin on `_yoast_wpseo_meta-robots-noindex`; "**אינו נבנה כעת**" | Yes — not an open gate |

The fallback is explicitly deferred and conditional on GSC thin-content (WP-S5-05 §7 item 9 reference). It does not undermine the LOD400 build path.

---

## 6) Deterministic hygiene — **PASS** (roadmap `notes` drift only)

| Rule | Result |
|---|---|
| (a) `date: 2026-07-16` on all 4 docs | **PASS** — verified in frontmatter of index + 3 WPs |
| (b) WP frontmatter complete (`id`, `wp`, `lod_status`, `next_wp`, `parent_index`, `assigned_validator`) | **PASS** — all three WP LOD400 files |
| (c) No real TBD/placeholder | **PASS** — intentional BUILD/DECIDE items (54 blog slugs, facade decision-gate §3.2) are scoped work, not empty placeholders |
| (d) `_aos/roadmap.yaml` parses | **PASS** |

---

## 7) Findings

### F-01 — **minor** — WP-S5-01 AC-3 href count label

- **Spec:** WP-S5-01 §3 title + §6 table say "**5 hrefs**"; §3 AC-3 body lists **6** URLs including `/shop/`.
- **Live code:** 6 `<a href>` entries in the shop dropdown (L39-44) — `/shop/` plus the five product routes.
- **Impact:** Cosmetic inconsistency only; live nav matches the enumerated list in AC-3 body.
- **route_recommendation:** Align §3 heading and §6 table to "6 hrefs (incl. `/shop/`)" or clarify "5 shop routes + hub `/shop/`".

### F-02 — **minor** — WP-S5-02 hub `/qr/` meta left to builder choice

- **Spec:** WP-S5-02 §2.4 item 2: hub `/qr/` — "כניסת `$map` ידנית **או** ייפול לתגית — **לפי בחירת הבונה**, מתועד."
- **Impact:** QR children branch is fully specified; hub meta has two valid implementations. Does not block build; junior must document which path was chosen in evidence.
- **route_recommendation:** Optional tighten: add one canonical `$map['qr'] => '...'` line (≤155 chars) to remove the fork.

### F-03 — **minor** — `_aos/roadmap.yaml` WP-S5-02 `notes` pre-Option-A wording

- **Roadmap:** L2064-2065: "route-completeness schema/meta for the 8+ route classes … (**OR explicit noindex** where …)"
- **LOD400:** WP-S5-02 + index §2.1 commit to **Option A (index+schema)**; noindex only as §2.6 future fallback.
- **Impact:** Roadmap `notes` field only — `spec_ref` points to correct LOD400. No builder should read stale notes over LOD400, but drift exists.
- **route_recommendation:** team_100 amend WP-S5-02 roadmap `notes` on next roadmap edit to reference Option A / remove "OR explicit noindex".

### F-04 — **minor** — `_aos/roadmap.yaml` WP-S5-01 `notes` stale route list

- **Roadmap:** L2043: spot-check mentions `/shows` among routes; LOD400 uses `/shows-heritage/` consistently (WP-S5-01 §5.1, WP-S5-02 §2.1).
- **Impact:** Notes-only drift; LOD400 + RESEARCH are aligned on `/shows-heritage/`.
- **route_recommendation:** Normalize roadmap `notes` to `/shows-heritage/` on next edit.

---

## 8) Iron Rule #1 attestation

| Role | Engine | Team |
|---|---|---|
| Builder (LOD400 author) | claude-opus-4-8 (Claude Code) | team_100 |
| Validator (this verdict) | composer-2.5 (Cursor vendor) | team_90 |

Cross-engine validation satisfied for this spec-review mandate.

---

## 9) route_recommendation

**PROCEED** to canonical handoff for **WP-S5-01** (and parallel WP-S5-03 per team_00 routing) per index §7.2.

Optional pre-handoff cleanup (non-blocking): resolve F-01–F-04 in a correction cycle if team_100 targets **0 findings** parity with S004 cycle3; otherwise document F-02 builder choice at build time.

**Next gate for team_100:** hub prompt-generate handoff → `_COMMUNICATION/team_110/HANDOFF_SELF_*_WP-S5-01_2026-07-16_v1.md` after team_00 confirms.
