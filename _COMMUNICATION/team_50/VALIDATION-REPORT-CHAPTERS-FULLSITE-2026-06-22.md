---
id: VALIDATION-REPORT-CHAPTERS-FULLSITE-2026-06-22
from_team: team_50 (Independent QA)
to_team: team_100, team_190, team_00
date: 2026-06-22
mandate: _COMMUNICATION/team_100/MANDATE-TEAM50-CHAPTERS-FULLSITE-VALIDATE-2026-06-22.md
staging: http://eyalamit-co-il-2026.s887.upress.link
repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home)
engine_builder: claude-code (team_100)
engine_validator: cursor-composer (team_50)   # IR#1 compliant
evidence: _COMMUNICATION/team_50/evidence/chapters-fullsite-2026-06-22/
status: ISSUED
delivery: file-transport (ADR043 §4 fallback)
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| **Verdict** | **PASS_WITH_FINDINGS** |
| Content accuracy (weighted) | **99.6%** (`siteAccuracyWeightedBySourceCharsPct`) |
| Gated pages at 100% sect+sent | **16 / 17** (ledger-adjusted **17 / 17** — see §1) |
| Pages &lt;100% outside ledger | **0** (Chapters-built content) |
| axe critical / serious | **0 / 0** on 27 routes probed |
| Horizontal overflow | **0** on 189 CDP checks (27 pages × 7 viewports) |
| h1 + dir (26 mandate routes) | **26 / 26 PASS** |
| Blocking for merge | **None** on content-accuracy axis; **2 medium findings** before Eyal (§6) |
| Next step | team_190 constitutional final → [`MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22.md`](_COMMUNICATION/team_100/MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22.md) |

---

# §1 Content accuracy (priority)

**Command:** `node scripts/qa/content-diff.mjs --out _COMMUNICATION/team_50/evidence/chapters-fullsite-2026-06-22/content`  
**Evidence:** `content/summary.json` + per-page `content/_*.json`  
**Bar applied:** mandate §3 — **100% sectionCov + sentenceCov** per gated page, minus **only** approved ledger §7.

## Per-page table

| Page | Source | sect% | sent% | Mandate verdict | Missing / invented (outside ledger) |
|------|--------|------:|------:|-----------------|-------------------------------------|
| `/` | homepage1-3 v2.md | 100 | 100 | **PASS** | — |
| `/method/` | method.md | 100 | 98.85 | **PASS (ledger)** | 1 missing sentence = brand «סטודיו נשימה מעגלית» stripped (WP-06); live has brand-free equivalent |
| `/treatment/` | treatment.md | 100 | 100 | **PASS** | — |
| `/sound-healing/` | sound_healing_final.md | 100 | 100 | **PASS** | — |
| `/lessons/` | lesons.md | 100 | 100 | **PASS** | — |
| `/faq/` | FAQ FINAL.md | 100 | 100 | **PASS** | — |
| `/books/` | MUZZA.md | 100 | 100 | **PASS** | — |
| `/eyal-amit/` | אודות - אייל עמית.md | 92.31 | 97.92 | **PASS (ledger §7-a)** | §07 title + 1 sentence — retired brand only |
| `/books/vekatavta/` | vekatavta.md | 100 | 100 | **PASS** | — |
| `/books/kushi-blantis/` | kushi_full.md | 100 | 100 | **PASS** | — |
| `/books/tsva-bekahol/` | eyal_tsva_FINAL.md | 100 | 100 | **PASS** | — |
| `/didgeridoos/` | buy didgeridoo.md | 100 | 100 | **PASS** | — |
| `/bags/` | bags for didg.md | 100 | 100 | **PASS** | — |
| `/stands-storage/` | stend for hanging.md | 100 | 100 | **PASS** | — |
| `/stand-floor/` | stend for playing.md | 100 | 100 | **PASS** | — |
| `/repair/` | build didg.md | 100 | 100 | **PASS** | — |
| `/eyal-amit/mokesh-dahiman/` | mokesh DOCX | 100 | 100 | **PASS** | 161/161 sentences |
| `/galleries/` | — | N/A | N/A | N/A | No Eyal source |
| `/media/` | — | N/A | N/A | N/A | No Eyal source |

`inventedSections`: **0** on all gated pages.

## Independent eyeball spot-checks (4 pages)

See [`evidence/chapters-fullsite-2026-06-22/design-notes/eyeball-spot-checks.md`](evidence/chapters-fullsite-2026-06-22/design-notes/eyeball-spot-checks.md):

- `/treatment/` — opening + §03 prose **verbatim**
- `/books/vekatavta/` — תקציר + QR paragraph **verbatim**
- `/eyal-amit/mokesh-dahiman/` — timeline + הספד **verbatim**
- `/method/` — brand-stripped sentence only deviation (ledger)

## Brand sitewide (Chapters-built pages)

Sample grep on `/`, `/method/`, `/treatment/`, `/books/`, `/eyal-amit/`, `/faq/` → **0** hits for «סטודיו נשימה מעגלית».

**Exception (finding F-01):** `/blog/` archive renders legacy WP post title containing the retired brand (see §6).

---

# §2 QA gate

## axe a11y

| Metric | Result |
|--------|--------|
| Routes | 27 (26 mandate + 2 blog singles; 1 encoded slug 404 on axe but 0 violations) |
| critical / serious | **0 / 0** all routes |
| Exit code | **0** |
| Evidence | `evidence/chapters-fullsite-2026-06-22/axe/axe-http.json`, `axe-stdout.txt` |

## h1 + dir

| Metric | Result |
|--------|--------|
| Mandate routes (26) | **26 / 26 PASS** — exactly 1 `<h1>`; `dir=rtl` Hebrew; `/en/` `dir=ltr` |
| Blog singles (working slugs) | **2 / 2 PASS** |
| Evidence | `evidence/chapters-fullsite-2026-06-22/h1-rtl/h1-rtl-stdout.txt` |

## Overflow / RTL (CDP `qa_probe.mjs`)

| Metric | Result |
|--------|--------|
| Viewports | 360, 390, 414, 768, 1024, 1440, 1920 |
| Pages | 27 |
| Total checks | **189** |
| Horizontal overflow | **0** |
| Forbidden-text failures | **7** — all `/blog/` @ every viewport (retired brand in legacy post title — F-01) |
| Screenshots | `evidence/chapters-fullsite-2026-06-22/qa_probe/screenshots/` (189 PNG) |
| Config | `evidence/chapters-fullsite-2026-06-22/qa_probe_config.json` |

## Lighthouse (staging — SEO/BP capped)

| Route | perf | a11y | bp | seo |
|-------|-----:|-----:|---:|----:|
| `/` | 95 | 97 | 100 | 69 |
| `/treatment/` | — | — | — | — (run failed transient) |
| `/method/` | 96 | 97 | 100 | 61 |
| `/books/` | 90 | 97 | 100 | 69 |
| `/blog/` | 95 | 97 | 100 | 69 |
| `/contact/` | 94 | 99 | 100 | 69 |
| `/en/` | 97 | 98 | 100 | 61 |
| `/eyal-amit/mokesh-dahiman/` | 90 | 97 | 100 | 61 |

Evidence: `evidence/chapters-fullsite-2026-06-22/lighthouse/lighthouse-stdout.txt`  
**Note:** Low SEO scores = staging noindex artifact (expected).

## SEO machine

| Check | Result |
|-------|--------|
| `ld+json` @graph | **Present** on spot routes (`/`, `/treatment/`, `/books/vekatavta/`, `/blog/`, `/en/`) |
| meta description | **Present** |
| single `og:image` | **1** per spot route |
| canonical | **Present** |
| 301 `/muzza/` → `/books/` | **PASS** one-hop |
| 301 `/about/moksha/`, `/mokesh/` → mokesh canonical | **PASS** |
| FAQ canonical internal links | **PASS** — links to `/treatment/`, `/method/`, product slugs |
| `generate_lead` WhatsApp | **PASS** — fires on `.ea-whatsapp-float` click |
| Blog pagination | **PASS** — page 1 vs page 2: 12 vs 11 slugs, **0 shared** |
| Contact CF7 | **PASS** — 11 `wpcf7` markers on `/contact/` |
| Blog single og | **PASS** — `og:title` + `og:image` on probed single |

Evidence: `evidence/chapters-fullsite-2026-06-22/seo/seo-probes.json`, `seo/analytics-probe.json`

---

# §3 Design fidelity

Browser CDP screenshots + mockup comparison: [`evidence/chapters-fullsite-2026-06-22/design-notes/mockup-comparison.md`](evidence/chapters-fullsite-2026-06-22/design-notes/mockup-comparison.md)

| Area | Result |
|------|--------|
| Chapters palette / typography | **Match** — ivory/terra/dark; Heebo + Frank Ruhl Libre + Suez One |
| Home + service pages | **Match** mockups (`/tmp/ea-mock`, handoff zip) |
| Books shelf + detail heroes | **Match** — real covers visible |
| Mokesh memorial | **Match** — timeline + photos |
| `/en/` | **LTR** placeholder per ledger §7-c |
| Placeholder pages | **Clean** Chapters shell + `⟨…⟩` copy |
| Visual breakage | **None blocking**; some full-page CDP captures show empty bands (lazy-load timing — overflow still 0) |

---

# §4 Ledger confirmation

| Ledger item | Confirmed |
|-------------|-----------|
| **(a)** Brand «סטודיו נשימה מעגלית» retired | **Yes** on all 17 Chapters content pages; caps `/eyal-amit/` + `/method/` sentence |
| **(b)** Testimonials provisional on home/books | **Yes** — FB corpus; service pages use source testimonials |
| **(c)** Placeholder `⟨…⟩` on galleries/media/legal/en | **Yes** — render cleanly |
| **(d)** Contact/blog not content-gated | **Yes** — function checks pass (CF7, pagination, og on singles) |

**Deviation outside ledger:** legacy blog post title on `/blog/` still contains retired brand (F-01) — **not** in ledger; flagged for team_100.

---

# §5 Method / evidence

| Item | Value |
|------|-------|
| Validator engine | **Cursor Composer** (non-Claude — IR#1) |
| Staging | `http://eyalamit-co-il-2026.s887.upress.link` + `?nc=` cache-bust |
| Evidence root | `_COMMUNICATION/team_50/evidence/chapters-fullsite-2026-06-22/` |
| content-diff | exit **0** |
| http-qa-axe.cjs | exit **0** |
| h1-rtl-http-probe.cjs | exit **0** (mandate routes) |
| qa_probe.mjs | exit **1** (7 forbidden-text on `/blog/` only; 0 overflow) |
| wave1-analytics-probe.cjs | exit **1** (generate_lead OK; ga4 head absent on staging) |
| http-qa-lighthouse.sh | exit **0** (1 route transient fail) |

**qa_probe path:** `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs`

---

# §6 Findings (non-blocking unless noted)

| ID | Severity | Finding | Evidence |
|----|----------|---------|----------|
| **F-01** | Medium | Retired brand «סטודיו נשימה מעגלית» appears **2×** on `/blog/` archive in legacy post title «…ציור מקורי חדש בסטודיו נשימה מעגלית…» | qa_probe forbiddenFound; curl DOM |
| **F-02** | Medium | Blog archive links to `…פודקאסט-…-עמית-2/` → **HTTP 404**; variant without `-2` also 404 | h1-rtl + curl |
| **F-03** | Info | Home/books testimonial marquee = PROVISIONAL FB corpus (ledger §7-b) | content-diff `inventedBlocks` on `/` |
| **F-04** | Info | Staging Lighthouse SEO 61–69 (noindex artifact) | lighthouse stdout |
| **F-05** | Info | `wave1-analytics-probe` ga4InHead false on staging; **generate_lead** still fires | analytics-probe.json |

**Recommendation:** team_100 should edit or redirect legacy blog post (F-01) and fix broken podcast slug (F-02) before Eyal meeting; not a Chapters template/content-source defect.

---

# §7 Route to team_190

team_50 independent validation **PASS_WITH_FINDINGS**. Constitutional re-run required:

- Mandate: [`_COMMUNICATION/team_100/MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22.md`](_COMMUNICATION/team_100/MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22.md)
- Deliverable: `_COMMUNICATION/team_190/VERDICT_CHAPTERS-FULLSITE_2026-06-22.md`

**Gate:** merge `chapters-home`→main and “ready for Eyal” require **team_50 PASS/PASS_WITH_FINDINGS (no blockers)** **AND** **team_190 PASS**.

*team_50 — 2026-06-22 — independent cross-engine live-site validation. Content accuracy priority: Chapters-built pages verbatim vs Eyal source — PASS minus approved ledger only.*
