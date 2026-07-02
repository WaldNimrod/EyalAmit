---
id: MANDATE-TEAM10-CRFINAL-FIXROUND-2026-07-03
from_team: team_100 (Chief System Architect — Claude Code)
to_team: team_10 (Builder)
date: 2026-07-03
wp: WP-W2-15-CR-FINAL (leg 1 fix round)
gate: CR-FINAL_FULL-SITE-CONTENT-ACCURACY (leg 1) — FAIL, this mandate is the remediation
status: SUPERSEDED — see WP-W2-17 (2026-07-03)
priority: HIGH — blocks CR-FINAL "ready" status and the M5→M6→M7 cutover chain
source_report: _COMMUNICATION/team_90/CONTENT-ACCURACY-REPORT-CR-FINAL-2026-07-02.md
depends_on: none — both findings are independently fixable now
superseded_by: _COMMUNICATION/team_100/WP-W2-17-CRFINAL-SEO-REMEDIATION-PROGRAM-2026-07-03.md
---

> ## ⛔ SUPERSEDED — DO NOT EXECUTE (team_100, 2026-07-03)
>
> This mandate is replaced by **WP-W2-17** (`WP-W2-17-CRFINAL-SEO-REMEDIATION-PROGRAM-2026-07-03.md`, executed by team_110 under `MANDATE-TEAM110-WP-W2-17-EXECUTION-2026-07-03_v1.0.0.md`).
>
> - **Task 1 below is WRONG — do not restore the §07 heading/sentence.** The "missing" text is the retired brand string «סטודיו נשימה מעגלית», whose removal team_00 ratified as **permanent** on 2026-07-03 (`DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md` §4). The live page is correct; the source doc is stale. Resolution = permanent gate normalization (WP-W2-17 T1).
> - Task 2 (image verify-first) is absorbed as WP-W2-17 T2.

# MANDATE — team_10 · CR-FINAL leg-1 fix round (P0 content regression + image audit)

## Why

team_90 re-ran CR-FINAL leg 1 on 2026-07-02 (mandate: `MANDATE-TEAM90-FULL-SITE-AUDIT-2026-07-02_v1.0.0.md`) and returned **FAIL** — report at `_COMMUNICATION/team_90/CONTENT-ACCURACY-REPORT-CR-FINAL-2026-07-02.md` (commit `58ff809`). Overall accuracy actually *improved* since the June baseline (99.70% vs 96.51%), but two findings block the gate:

1. A P0 content regression on `/eyal-amit/` (was PASS in June, now FAILs).
2. A site-wide image audit FAIL (new check this cycle — 19 broken images + 9 missing image-map slots).

Legs 2 (team_190) and 3 (team_50) are unaffected — their June PASS still stands. Once this mandate closes, route back through team_100 for a team_90 leg-1 re-run; only then can CR-FINAL be reported "ready" again.

**Tool note:** team_90 flagged `scripts/qa/content-diff.mjs` as 46 lines drifted from the frozen 06-05 copy (`_COMMUNICATION/team_90/evidence/preflight-2026-07-02/content-diff-drift.diff`). team_100 reviewed the actual diff: it's a slug-map update (`/eyal-amit/`, `/books/`, mokesh memorial path — all already-ratified migrations elsewhere), a genuine docx paragraph-extraction bugfix (the prior code joined `<w:t>` runs across paragraph boundaries with a space, corrupting Hebrew text where Word splits a word mid-run — e.g. "להיום" → "להי ום"), and a "jungle/jungel vibes" spelling normalization. **team_100 ratifies this drift as legitimate — not gate manipulation.** No action needed from team_10 on this; noted so you don't waste time suspecting the tool.

---

## Task 1 — P0-CRF-01: restore the `/eyal-amit/` §07 section

**Finding:** section% dropped to 92.31% (was 100%) because the live page's "SECTION 07" heading and lede sentence don't match the approved source. Content source of truth confirms the expected title is **"המרכז לטיפול בדיג'רידו – סטודיו נשימה מעגלית פרדס חנה"** (with the studio-name suffix); the live/coded version renders just **"המרכז לטיפול בדיג׳רידו"** (suffix missing) and the lede sentence is the shorter two-paragraph variant instead of the full one.

**Located:** `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/about-defaults.php:153-154` — the `SECTION 07` block's `title` and `body` keys. (Confirmed present in-repo with a full 4-paragraph body already — the gap is specifically the missing studio-name suffix in the title, not a wholesale missing section. Check whether a live ACF/DB override on this "chapters" page is shadowing this default — the chapters system is editable per `DECISION_CHAPTERS_EDITABILITY_2026-06-22_v1.md` — fix wherever the live render actually sources from.)

**Evidence for exact expected wording:** `_COMMUNICATION/team_90/evidence/content-accuracy-cr-final-2026-07-02/_eyal-amit.json:17,22-23` (source title + sentence verbatim).

**Fix:** update the title to include the studio-name suffix and confirm the rendered lede sentence matches the source's full sentence (not the truncated variant). Re-run `content-diff.mjs` against `/eyal-amit/` locally before declaring done — target: section% back to 100, gate PASS.

## Task 2 — Image audit: verify then fix

**Finding:** `_COMMUNICATION/team_90/evidence/image-audit-cr-final-2026-07-02/summary.json` — 19 DOM-broken `<img>` (naturalWidth===0) + 9 missing image-map slots across 16 pages, only 8/16 pages clean. Full per-page breakdown + broken URLs in `evidence/image-audit-cr-final-2026-07-02/per-page/*.json`.

**team_90's own caveat (do not skip this step):** sampled "broken" URLs return HTTP 200, and failures correlate with lazy-loaded/carousel off-screen images — this may be a probe methodology artifact (the check ran after scroll+wait but may not have triggered every carousel's lazy-load), not real breakage. **team_100 spot-checked one page**: on `/eyal-amit/`, the two "broken" images (`garden.jpg`, `studio-didgs.jpg`) exist locally in the theme repo at full size (502KB / 203KB — real photos, not placeholders) at `site/wp-content/themes/ea-eyalamit/assets/images/chapters/`. This suggests a deploy-sync or lazy-load-timing issue rather than missing assets, at least for this page — **verify the same for the other 15 pages' broken lists before assuming content loss.**

**Sequence:**
1. Visually load each of the 16 pages in a real browser (not curl) and confirm which of the 19 "broken" images are actually broken on-screen vs. a lazy-load/probe-timing false-positive.
2. For genuinely broken images: confirm the asset exists in the repo and is deployed to staging (FTP sync gap is a known past failure mode in this project — check `scripts/ftp_deploy_site_wp_content.py` ran clean for the theme's `assets/images/` tree).
3. For the 9 missing image-map slots (`_communication/team_110/image-map.json` is the SSoT — `/eyal-amit/` alone is missing `gallery-4`, `book-1`, `book-2`, `book-3` per `evidence/image-audit-cr-final-2026-07-02/per-page/eyal-amit.json:28-53`): determine per-slot whether the page genuinely should render that image (content gap — fix) or the image-map's expectation is stale/wrong for that page (mapping gap — flag back to team_100, do not force an image onto a page that doesn't need it).
4. Home (`/`) has the worst broken-count (8/22) — start there.

**Fix scope:** only genuine breakage/deploy gaps. Do not force-fix a probe false-positive by disabling lazy-load or similar — report it back as "verified false-positive" instead if that's what you find, so team_90's next run and the QA harness (separate, not-yet-issued mandate) can account for it.

---

## Constraints (standing project directives)

- Composition/content-only fix — no new atoms, no ad-hoc CSS, no scope creep into unrelated pages.
- Deploy to staging via the project's standard FTP deploy script, cache-busted.
- `php -l` clean on every touched PHP file. `validate_aos.sh .` 0 FAIL before handoff.
- Surgical, per-file commits — never `git add -A`.
- **No self-validation.** Hand back to team_100 when done; team_100 routes to team_90 for the CR-FINAL leg-1 re-run. Do not report "ready" to Eyal — that determination belongs to the full triple-PASS chain (team_90 + team_190 + team_50 + team_00), unchanged since June.

## Acceptance

- `/eyal-amit/` scores section% = 100 / accuracy ≥ gate threshold on a fresh `content-diff.mjs` run.
- Image audit re-run shows 0 genuine broken images (probe false-positives may remain and should be documented, not silently passed) and every image-map slot either renders or has a team_100-acknowledged mapping correction.
- `validate_aos.sh .` 0 FAIL.
- Report back to `_COMMUNICATION/team_100/` with what was fixed vs. what was found to be a probe false-positive vs. what needs a team_100 mapping decision.
