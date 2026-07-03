---
id: CONTENT-ACCURACY-REPORT-CR-FINAL-RERUN-2026-07-03
from_team: team_90 (Default Validator — cursor-composer-2)
to_team: team_100
date: 2026-07-03
wp: WP-W2-17
gate: CR-FINAL_FULL-SITE-CONTENT-ACCURACY (leg 1 re-run post-remediation)
mandate: _COMMUNICATION/team_100/MANDATE-TEAM90-CRFINAL-RERUN-2026-07-03_v1.0.0.md
cross_engine: builder=claude-code (team_110); validator=cursor (team_90) — IR#1 satisfied
---

# Gate CR-FINAL_FULL-SITE-CONTENT-ACCURACY (re-run) — team_90 | Run 2026-07-03

## Context bundle

- **Work Package:** WP-W2-17 (CR-FINAL leg-1 re-audit after remediation)
- **Domain:** EyalAmit.co.il-2026 (WordPress staging)
- **Write to:** `_COMMUNICATION/team_90/`
- **Mandate:** [`MANDATE-TEAM90-CRFINAL-RERUN-2026-07-03_v1.0.0.md`](../team_100/MANDATE-TEAM90-CRFINAL-RERUN-2026-07-03_v1.0.0.md)
- **Predecessor:** [`CONTENT-ACCURACY-REPORT-CR-FINAL-2026-07-02.md`](CONTENT-ACCURACY-REPORT-CR-FINAL-2026-07-02.md) (**FAIL** — P0 `/eyal-amit/` + image audit)
- **Staging:** http://eyalamit-co-il-2026.s887.upress.link (HTTP only)
- **Measured @:** 2026-07-03T11:20Z · repo `main` @ `8394448`
- **Evidence root:** `_COMMUNICATION/team_90/evidence/cr-final-rerun-2026-07-03/`

---

## §0 — Verdict box

| שדה | ערך |
|-----|-----|
| **Gate** | CR-FINAL_FULL-SITE-CONTENT-ACCURACY leg-1 re-run (post WP-W2-17) |
| **Verdict** | **PASS_WITH_FINDINGS** — all mandated gates pass on fresh evidence; non-blocking flaky-host / tooling findings only |
| **CR-FINAL team_90 leg** | **PASS_WITH_FINDINGS** |
| **Content-diff (T1)** | **PASS** — 17/17 gate-pass; `/eyal-amit/` **100%/100%**; brand normalization **RATIFIED** |
| **Image audit (T2)** | **PASS** — canonical `scripts/qa/image-audit.cjs` rerun2: 16/16, 0 broken, 0 missing slots |
| **SEO probe (T7)** | **PASS_WITH_FINDINGS** — script exit **1** (host batch-fetch timeouts); 15/16 routes PASS in-script; failing checks **independently verified PASS**; implementation **RATIFIED** vs Appendix B |
| **Image-picker spot-check** | **PASS** — thumbs HTTP-200 (6/6 sampled) + `localStorage` round-trip |
| **Legs 2/3** | **UNCHANGED** — team_190 + team_50 June triple-PASS stands |
| **Next step** | Route to **team_100** → advance L-GATE_VALIDATE leg-1; **no "ready" to Eyal** (triple-PASS chain) |

**מסקנה אחת:** רגרסיית P0-CRF-01 נסגרה דרך נרמול מותג קבוע (לא שחזור תוכן). שער תמונות ותוכן עוברים. `seo_probe.mjs` מיושם נכון אך זקוק לסבלנות retry על בדיקות 3/6 בסביבה רועשת — לא חוסם.

---

## §1 — טבלת עמודים (content-diff)

נוסחת **accuracy%** (F04): `pageAccuracy% = 0.4 × sectionCoverage% + 0.6 × sentenceCoverage%`

| page | section% | sentence% | accuracy% | gate | Δ vs 07-02 |
|------|----------|-----------|-----------|------|------------|
| `/` | 100 | 100 | 100.00 | PASS | = |
| `/method/` | 100 | 98.85 | 99.31 | PASS | = |
| `/treatment/` | 100 | 100 | 100.00 | PASS | = |
| `/sound-healing/` | 100 | 100 | 100.00 | PASS | = |
| `/lessons/` | 100 | 100 | 100.00 | PASS | = |
| `/faq/` | 100 | 100 | 100.00 | PASS | = |
| `/books/` | 100 | 100 | 100.00 | PASS | = |
| **`/eyal-amit/`** | **100** | **100** | **100.00** | **PASS** | **↑ P0 resolved** (was FAIL 92.31/97.92) |
| `/books/vekatavta/` | 100 | 100 | 100.00 | PASS | = |
| `/books/kushi-blantis/` | 100 | 100 | 100.00 | PASS | = |
| `/books/tsva-bekahol/` | 100 | 100 | 100.00 | PASS | = |
| `/didgeridoos/` | 100 | 100 | 100.00 | PASS | = |
| `/bags/` | 100 | 100 | 100.00 | PASS | = |
| `/stands-storage/` | 100 | 100 | 100.00 | PASS | = |
| `/stand-floor/` | 100 | 100 | 100.00 | PASS | = |
| `/repair/` | 100 | 100 | 100.00 | PASS | = |
| `/mokesh-dahiman` (CR5) | 100 | 100 | 100.00 | PASS* | = |
| `/galleries/`, `/media/` | N/A | N/A | N/A | — | — |

\* mokesh measured but excluded from CR1–4 rollup.

**Rollup:** `gateWouldPassCount` **17/17** · site accuracy **99.96%** simple / **99.92%** weighted (was 99.70% / 99.60% on 07-02).

Evidence: `evidence/cr-final-rerun-2026-07-03/content-diff/summary.json`

---

## §2 — Ratifications (T1 + T7 + decisions)

### T1 — Permanent brand normalization (**RATIFIED**)

Per [`DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md`](../team_100/DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md) §4 + §7:

- P0-CRF-01 is **not a site defect** — retired string «סטודיו נשימה מעגלית» stripped source-side in `scripts/qa/content-diff.mjs` (lines 134–144) is the **new frozen baseline**.
- 46-line tool drift vs 06-05 copy re-ratified as legitimate (slug map, docx extraction fix, jungle-vibes).

### T7 — `seo_probe.mjs` implementation (**RATIFIED** vs Appendix B)

| Check | Spec | Implementation | team_90 disposition |
|-------|------|----------------|---------------------|
| 2 robots.txt UAs | Appendix B "8 UAs" | **10 UAs** per ratified D3 | **RATIFIED** supersession |
| 7 JSON-LD `/method/` | Service on service slugs | **No Service** on `/method/` per C-2 | **RATIFIED** |
| 4 meta-description | exactly 1 per route | PASS all 16 routes (final run) | **CONFIRMED** — D-1 drift closed |
| 12 brand absence | retired string absent | `brandExemptRoutes`: `/`, `/method/`, `/treatment/`, `/sound-healing/`, `/lessons/` | **RATIFIED** — consistent with AC-09 6-quote file scope + live HTML |
| 1,5,8–11 | Appendix B | PASS all routes in final run | **CONFIRMED** |

### `mockup_unbuilt_slots` (**NON-BLOCKING**)

6 slots in `image-map.json:mockup_unbuilt_slots` documented per [`IMAGE-RECONCILIATION-WP-W2-17-2026-07-03.md`](../team_100/IMAGE-RECONCILIATION-WP-W2-17-2026-07-03.md) — design question for team_00, not content gap.

---

## §3 — Image audit (T2 confirmation)

**Tool:** `scripts/qa/image-audit.cjs` (canonical — **not** evidence copy from 07-02)

| Run | Verdict | broken | missing slots | notes |
|-----|---------|--------|---------------|-------|
| Run 1 | FAIL | 1 (`eyal-window.jpg` on `/books/kushi-blantis/`) | 0 | `httpStatus=0` in-script; **curl 6×200** — flaky false positive |
| **Run 2** | **PASS** | **0** | **0** | **Authoritative** — 16/16 pages, 20 slow-load recovered |

Evidence: `evidence/cr-final-rerun-2026-07-03/image-audit-rerun2/summary.json`

Prior 07-02 findings (19 broken DOM imgs, 9 missing slots) **resolved** via manifest reconciliation + video-aware + HTTP-verified audit per team_100.

---

## §4 — SEO probe (T7)

**Runs:** 5 attempts (2× exit 2 connect-timeout mid-run, 2× exit 1, 1× exit 1 **complete**)

**Authoritative run:** `evidence/cr-final-rerun-2026-07-03/seo-probe-final/seo_probe_report.json`

| Scope | Result |
|-------|--------|
| Host `2_robots_txt` (staging) | **PASS** |
| Host `3_sitemap_index` | Script **FAIL** — 23 `<loc>` entries `fetch failed` during batch HEAD crawl |
| Routes 16× checks 1,4,5,6,7,8,9,10,11,12 | **15/16 PASS** in-script; `/method/` check 6 `og_image` HEAD timeout |
| **Manual retry** | `seo-probe-manual-verify.json` — og:image + sitemap_index + `/lessons/` **HTTP 200** |

**Finding F-SEO-01 (non-blocking):** `seo_probe.mjs` check 3 (sitemap child `<loc>` HEAD sweep) and check 6 (`og:image` HEAD) lack retry tolerance under uPress staging flakiness. Observed behaviour matches team_110's reported inability to get clean exit-0 — **not check-logic failure**. Recommend retry wrapper (future WP); does not block leg-1.

---

## §5 — Image-picker spot-check (carried finding)

**URL:** `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/image-picker.html`

| Check | Result |
|-------|--------|
| Page load (`TOTAL=71`, 424 candidates) | **PASS** |
| Candidate thumb load (6 sampled: keep + DOK + legacy) | **PASS** — HTTP 200 all (`naturalWidth=0` in headless; HTTP verify per image-audit precedent) |
| `localStorage` round-trip (`ea-image-picker-v2`, `pick()` on DOK-AJPS8301) | **PASS** — store persists across reload, `.selected` restored |

Evidence: `evidence/cr-final-rerun-2026-07-03/image-picker-spotcheck.json`

---

## §6 — Legs 2/3 + startup

| Item | Status |
|------|--------|
| team_190 leg 2 (June PASS) | **UNCHANGED** — no new cross-cutting scope |
| team_50 leg 3 (June PASS) | **UNCHANGED** |
| `validate_aos.sh` | **44 PASS / 0 FAIL** |
| AOS API health | `db.status: online` |
| Staging pre-flight | 6/6 HTTP 200 |

---

## §7 — Non-blocking findings summary

| ID | Finding | Remediation |
|----|---------|-------------|
| F-IMG-01 | Image audit run1 false broken on flaky host | Resolved on rerun2; document retry discipline |
| F-SEO-01 | `seo_probe` exit 1 on batch fetch timeouts | Add retry to checks 3/6; manual verify PASS |
| F-DESIGN-01 | 6 `mockup_unbuilt_slots` | team_00 design decision; defer past cutover |

---

## Route recommendation

**→ team_100:** Accept CR-FINAL leg-1 **PASS_WITH_FINDINGS**; advance WP-W2-17 L-GATE_VALIDATE (leg 1 complete). Dispatch legs 2/3 only if team_100 chooses full chain re-close; June PASS stands.

**Do NOT** message Eyal "ready" — AC-011 triple-PASS + team_00 only.

---

**log_entry | TEAM_90 | CR-FINAL_LEG1_RERUN | 2026-07-03 | PASS_WITH_FINDINGS**
