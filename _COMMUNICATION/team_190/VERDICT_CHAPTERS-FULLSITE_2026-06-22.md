---
id: VERDICT_CHAPTERS-FULLSITE_2026-06-22
from_team: team_190 (FINAL VALIDATION OWNER — Iron Rule #5)
to_team: team_100, team_00
date: 2026-06-22
scope: FULL-SITE — «Chapters» design, all mandate routes
staging: http://eyalamit-co-il-2026.s887.upress.link
repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home)
engine_builder: claude-code
engine_team50_validator: cursor-composer
engine_team190_validator: GPT-5.2
evidence_root: _COMMUNICATION/team_190/evidence/chapters-fullsite-2026-06-22/
status: ISSUED
---

# team_190 — Constitutional verdict — Chapters FULL-SITE — 2026-06-22

## §0 VERDICT BOX

| Field | Value |
|-------|-------|
| **Verdict** | **PASS_WITH_FINDINGS** |
| **Engine (validator)** | **GPT-5.2** (non-Claude; different from team_50) |
| **Content accuracy (weighted)** | **99.6%** (`siteAccuracyWeightedBySourceCharsPct`) |
| **Content-gated pages @100% (ledger-adjusted)** | **17 / 17 PASS** (only ledger deviations on `/method/` + `/eyal-amit/`) |
| **axe critical / serious** | **0 / 0** (26 routes) |
| **Horizontal overflow (CDP, 7 breakpoints)** | **0** (182 checks = 26 routes × 7 widths) |
| **1 `<h1>` + correct `dir`** | **26 / 26 PASS** (`/en/` = `dir=ltr`, others `rtl`) |
| **One-hop 301s (mandate set)** | **PASS** (`/muzza/`, `/about/moksha/`, `/mokesh/`) |
| **Contact + Blog function** | **PASS** (CF7 present; WhatsApp `generate_lead`; blog page 2 differs; single-post OG/meta present) |

**Important**: This verdict is based on an independent re-run against the **LIVE staging runtime** with **browser-rendered** evidence. No fixes/commits/merges/deploys performed by team_190.

## §1 Evidence index (team_190)

Primary artifacts (all under `evidence_root`):
- `scope.json` (frozen routes + ledger scope)
- `content/summary.json` (content-diff full summary + per-page JSONs)
- `axe/axe-http-2026-06-22.json`
- `h1-rtl/h1-rtl-http-probe.json`
- `qa_probe/qa_probe_result.json` + `qa_probe/screenshots/*.png`
- `lighthouse/lh_*.json` (representative routes)
- `seo/redirect_onehop_checks.json`
- `seo/blog_pagination_posts_v3.json`
- `seo/seo_head_checks_v3.json`
- `function/contact_whatsapp_probe.json`
- `design/eyeball-spot-checks.md` + `design/eyeball_*.png`
- `design/mockups/mockup_*.png` + `design/mockup-comparison-notes.md`

## §2 Criteria results (per mandate)

### 2.1 Content accuracy (PRIORITY) — PASS (ledger-adjusted)
- **Deterministic run**: `content/summary.json`
  - 17 measured pages; 2 N/A pages (`/galleries/`, `/media/`)
  - **All measured pages = 100%/100%** except:
    - `/method/`: 1 missing sentence due to retired brand removal (ledger item a)
    - `/eyal-amit/`: 1 missing section title + 1 missing sentence due to retired brand removal (ledger item a)
- **Manual eyeball (≥3 pages)**: `design/eyeball-spot-checks.md` (+ screenshots in `design/`)

### 2.2 a11y (axe) — PASS
- **Bar**: 0 critical / 0 serious on every route
- **Evidence**: `axe/axe-http-2026-06-22.json`

### 2.3 Layout overflow @ 7 breakpoints (browser/CDP) — PASS
- **Bar**: 0 horizontal overflow at widths 360/390/414/768/1024/1440/1920 on every route
- **Evidence**: `qa_probe/qa_probe_result.json` (`failures: 0`) + `qa_probe/screenshots/*.png`

### 2.4 Structure/SEO — PASS_WITH_FINDINGS
- **1 `<h1>`/page + correct `dir`**: PASS (`h1-rtl/h1-rtl-http-probe.json`)
- **Yoast `@graph` + canonical + single `og:image`**: PASS on representative routes
  - Evidence: `seo/seo_head_checks_v3.json`
- **One-hop 301s (mandate)**: PASS
  - Evidence: `seo/redirect_onehop_checks.json`
- **Finding (F-01)**: some routes are missing a description meta (`name=description` and any `*description*` meta)
  - Evidence: `seo/seo_head_checks_v3.json` shows `metaDescriptionCount: 0` and `ogDescriptionCount: 0` for:
    - `/books/vekatavta/`
    - `/eyal-amit/mokesh-dahiman/`
    - (also `/en/` has `og:description` but no `name=description`)

### 2.5 Design fidelity (browser) — PASS (manual)
- **Approach**: manual visual comparison on key pages, supported by full-page live screenshots (CDP) and the mockup set.
- **Evidence**:
  - Mockups (served locally): `design/mockups/mockup_home_full.png`, `design/mockups/mockup_method_full.png`, `design/mockups/mockup_treatment_full.png`
  - Live staging samples: `design/eyeball_treatment_full.png`, `design/eyeball_vekatavta_full.png`, `design/eyeball_mokesh_full.png`
  - Full-route screenshots: `qa_probe/screenshots/*.png`
  - Notes: `design/mockup-comparison-notes.md`

### 2.6 Function — PASS
- **Contact**: CF7 present; WhatsApp CTA exists with `text=`; `generate_lead` fired on click
  - Evidence: `function/contact_whatsapp_probe.json`
- **Blog pagination**: `/blog/page/2/` posts differ from page 1 (no shared permalinks)
  - Evidence: `seo/blog_pagination_posts_v3.json`
- **Per-post meta/og**: representative single post shows canonical + `og:image` + meta description
  - Evidence: `seo/seo_head_checks_v3.json` (`blog_single_sample`)

## §3 Findings

| ID | Severity | Finding | Evidence |
|----|----------|---------|----------|
| **F-01** | Medium | Missing description meta on some routes (notably `/books/vekatavta/` and `/eyal-amit/mokesh-dahiman/`; `/en/` lacks `name=description`) | `seo/seo_head_checks_v3.json` |

## §4 Routing / gate note

This is the constitutional team_190 re-run. Route this verdict to **team_100** and **team_00**. Merge `chapters-home` → `main` and “ready for Eyal” remain gated on **team_50 + team_190** results per mandate.

