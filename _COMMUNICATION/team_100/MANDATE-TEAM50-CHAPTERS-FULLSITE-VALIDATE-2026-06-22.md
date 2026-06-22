---
id: MANDATE-TEAM50-CHAPTERS-FULLSITE-VALIDATE-2026-06-22
from_team: team_100 (Chief Architect — builder this cycle)
to_team: team_50 (Independent QA — EXTERNAL validator)
date: 2026-06-22
type: VALIDATION_MANDATE
scope: FULL-SITE — every page in the «Chapters» (פרקים) design
staging: http://eyalamit-co-il-2026.s887.upress.link
repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit-design  (branch chapters-home, pushed: b48b35a)
engine_builder: claude-code        # the build was done by Claude
engine_validator: NON-CLAUDE       # YOU must be a different engine (Cursor / Codex / etc.) — Iron Rule #1
mechanism: file-transport (hub mail API offline — ADR043 §4/§5)
authorized_by: team_00 (Nimrod)
status: ISSUED
---

# Mandate — Full-site independent validation of the Chapters site (team_50)

## 0. Why
The whole site has been rebuilt in the «Chapters» design and deployed to **staging** (theme 1.5.5, branch `chapters-home`). Before merge-to-main and before the Eyal meeting, it needs **independent, cross-engine validation**. **The build was done by Claude (builder); you MUST run on a different engine (Iron Rule #1: builder ≠ validator).** Re-run every check yourself against the **live staging site** — **do NOT trust the builder's numbers** in §6; reproduce them.

## 1. Identity & rules
- You are **team_50 — Independent QA**. **Measure & report; do NOT fix, edit, commit, merge or deploy.** Output **only** under `_COMMUNICATION/team_50/`.
- **Validate against the LIVE staging site** (the URL above) — not by reading git/code. Code reading is allowed only to explain a finding.
- **Browser-rendered checks are mandatory for anything visual** (layout, RTL, responsive, design fidelity). `curl` is blind to the rendered box model — per the canon `_aos/lean-kit/modules/validation-quality/docs/BROWSER_QA_HARNESS_CANON_v1.0.0.md`, use the CDP runner `qa_probe.mjs` (screenshots) + Lighthouse (full Chrome). Use `curl -k ?nc=<n>` only for HTML/meta/status/redirects.
- Dev/staging is HTTP and noindex **by design** — cert/noindex/edge artifacts are NOT defects. Bust edge cache with `?nc=<random>` when re-checking.

## 2. Scope — every route (26)
`/` · `/method/` · `/treatment/` · `/sound-healing/` · `/lessons/` · `/eyal-amit/` · `/faq/` · `/didgeridoos/` · `/bags/` · `/stands-storage/` · `/stand-floor/` · `/repair/` · `/books/` (Muzza hub) · `/books/vekatavta/` · `/books/kushi-blantis/` · `/books/tsva-bekahol/` · `/eyal-amit/mokesh-dahiman/` · `/contact/` · `/blog/` (+ at least 2 single posts) · `/galleries/` · `/media/` · `/privacy/` · `/accessibility/` · `/terms/` · `/en/`

## 3. ⭐ PRIORITY CHECK — CONTENT ACCURACY vs Eyal's source (the #1 emphasis)
**Every Hebrew word on every page must be VERBATIM from Eyal's approved source** — `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/` (map in `INDEX-CONTENT-2026-05-25.md`). This is the single most important axis: Eyal previously flagged invented text, so prove there is none.

Page ↔ source map (the SSoT; also encoded in `scripts/qa/content-diff.mjs` `PAGE_MAP`):

| Live page | Source file |
|---|---|
| `/` | `דף הבית/homepage1-3 v2.md` |
| `/method/` | `השיטה/method.md` |
| `/treatment/` | `טיפול בדיג'רידו/treatment.md` |
| `/sound-healing/` | `סאונדהילינג/sound_healing_final.md` |
| `/lessons/` | `שיעורי נגינה/lesons.md` |
| `/faq/` | `דף FAQ/FAQ FINAL.md` |
| `/books/` (hub) | `מוזה הוצאה לאור - ספרים/MUZZA.md` |
| `/eyal-amit/` | `אודות - אייל עמית/אודות - אייל עמית.md` |
| `/books/vekatavta/` · `/books/kushi-blantis/` · `/books/tsva-bekahol/` | `וכתבת/vekatavta.md` · `כושי בלאנטיס/kushi_full.md` · `צבע בכחול וזרוק לים/eyal_tsva_FINAL.md` |
| `/didgeridoos/` · `/bags/` · `/stands-storage/` · `/stand-floor/` · `/repair/` | `כלים למכירה/buy didgeridoo.md` · `תיקים לדיג'רידו/bags for didg.md` · `סטנדים לדיג'רידו לאחסון/stend for hanging.md` · `סטנד רצפתי…/stend for playing.md` · `תיקון כלי דיג'רידו/build didg.md` |
| `/eyal-amit/mokesh-dahiman/` | `מוקש דהימן/…1950-2020.docx` (DOCX) |
| `/galleries/` · `/media/` | **no source** → N/A |

**Method (reproduce, don't trust):** run the deterministic gate yourself —
```
cd <repo> && node scripts/qa/content-diff.mjs --out _COMMUNICATION/team_50/evidence/content-<date>
```
It parses each source, normalises (geresh/maqaf/dash/quote folding, entity decode, markdown strip), fetches the live page's `<main>`, and reports per-page **sectionCov / sentenceCov / missingSentences / inventedSections**. **Independently spot-read 3–4 pages by eye** (open the live page + the source `.md` side by side) to confirm the script isn't masking paraphrase. Required bar: **100% (sectionCov + sentenceCov) per page, minus ONLY the approved ledger in §7.** Any *invented* block (live prose with no source) or any *missing* source sentence outside the ledger = **FAIL**, itemised per page.

## 4. Full QA gate (re-run on live)
1. **axe a11y** — `node scripts/qa/http-qa-axe.cjs --base <staging> <routes…>` → **0 critical / 0 serious**, every route.
2. **Overflow / RTL (browser/CDP)** — `qa_probe.mjs` across **360 / 390 / 414 / 768 / 1024 / 1440 / 1920** → **0 horizontal overflow**, every route. (config example in `/tmp` or build your own from §2.)
3. **H1 / dir** — exactly **one `<h1>`** per page; `dir=rtl` on all Hebrew pages, `dir=ltr` on `/en/`.
4. **Lighthouse** — full Chrome (`CHROME_PATH=…Google Chrome.app…`), key routes; note staging SEO/BP are artifacts (re-measure on prod).
5. **SEO machine preserved** — Yoast `@graph` (`ld+json`), per-route meta description (`inc/wave2-w2-09.php`), single `og:image`, canonical tag, and **one-hop 301s**: `/muzza/`→`/books/`, `/about/moksha/` `/mokesh/`→`/eyal-amit/mokesh-dahiman/`. FAQ canonical internal links present (AC-18). `generate_lead` analytics on the contact WhatsApp CTA.

## 5. ⭐ DESIGN ACCURACY — in the BROWSER, against the mockups (not git)
Render each page in a real browser and judge **visual fidelity to the «Chapters» design**, at mobile + desktop:
- **Screenshots** — `qa_probe.mjs --shots` (or Lighthouse) for each route at ≥2 viewports; attach/reference them in your report.
- **Compare to the approved mockups** — `/tmp/ea-mock/*.html` and the handoff zip `eyal-amit/project/*.html` (Home, Method, Treatment, Sound-Healing, Lessons, About, Books, Book-Detail, Memorial-Mokesh, Blog, Contact, Shop, Galleries, Media, EN). Confirm the live page matches the intended layout, typography (Heebo / Frank Ruhl Libre / Suez One), palette (ivory/terra/dark), section rhythm, hero, and components (nav, phero, bookcards, testimonials marquee, FAQ accordion, gallery grid).
- **Check for visual breakage** — broken images, missing CSS (unstyled blocks), overlapping text, RTL mirroring errors, the EN page rendering LTR correctly, real book covers showing on `/books/` cards + detail heroes, the Mokesh memorial photos in order.
- **Responsive** — exercise the 7 breakpoints; confirm nav/burger, grids collapse cleanly, no clipped/overflowing content.

## 6. Builder's CLAIMED results — RE-VERIFY, DO NOT TRUST
(For your convenience; reproduce each independently.)
- content-diff: **16/17 gated pages = 100/100**; `/eyal-amit/` = 92.31 sect / 97.92 sent (ledger §7-a); `/galleries//media/` = N/A.
- axe: 0 critical / 0 serious on all routes checked.
- overflow: 182 checks (26 routes × 7 breakpoints) → 0 overflow.
- 1 `<h1>` per page; 301s one-hop; schema/meta/og/canonical present.

## 7. Approved deviation ledger (NOT defects — confirm scope, don't fail on these)
- **(a) Retired brand «סטודיו נשימה מעגלית»** — removed sitewide per WP-06 (Nimrod-approved). It is stripped from one historical sentence + the §07 title on `/eyal-amit/`, which caps that page at 92.31 sect / 97.92 sent. Confirm the *rest* of `/eyal-amit/` is 100% and that the brand appears **nowhere** live. Do NOT require the brand back.
- **(b) Testimonials** — service pages (`/treatment/`, `/lessons/`, `/sound-healing/`) now render the **source testimonials verbatim**; `/books/`-hub & home use the curated set. The 48-item FB corpus (`hub/data/testimonials-curation.json`) carries **PROVISIONAL** snippets pending Eyal's curation — flag, not fail.
- **(c) Placeholder pages** — `/galleries/`, `/media/`, `/privacy/`, `/accessibility/`, `/terms/`, `/en/` carry intentional `⟨…⟩` placeholder copy/imagery (no Eyal source yet; logged in the HUB). Verify they render cleanly in Chapters design + pass a11y/overflow; the *placeholder text itself* is expected (flag as "pending Eyal", not a defect). `/en/` must be LTR English.
- **(d) Contact / Blog** — no `.md` source (template strings / dynamic posts) → not content-gated; validate function (CF7 form present, WhatsApp A/B + `generate_lead`, blog pagination shows different posts on page 2, per-post meta/og preserved) + design.

## 8. Deliverable
`_COMMUNICATION/team_50/VALIDATION-REPORT-CHAPTERS-FULLSITE-2026-06-22.md`:
- **Verdict box** (top): PASS / PASS_WITH_FINDINGS / FAIL + headline content-accuracy % and count of pages <100% (excluding ledger).
- **§1 Content accuracy** — per-page table (sectionCov / sentenceCov / verdict / missing-or-invented list); your independent eyeball spot-checks.
- **§2 QA gate** — axe / overflow / h1-dir / lighthouse / SEO results per route.
- **§3 Design fidelity** — per-page browser screenshots + mockup-comparison notes; any visual breakage.
- **§4 Ledger confirmation** — that §7 items are in-scope and nothing beyond them deviates.
- **§5 Method/evidence** — commands, engine used, evidence dir.
- Then **route to team_190** for the constitutional final (see the team_190 mandate). **No "ready" to Eyal until team_50 AND team_190 both PASS.**

*team_100 — 2026-06-22 — independent, cross-engine, live-site + browser. Content accuracy vs Eyal's source is the priority.*
