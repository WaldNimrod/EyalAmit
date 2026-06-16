---
id: VERDICT_WP-W2-16_E2E_Composer_v1
title: team_50 E2E Verdict — WP-W2-16 (L-GATE_BUILD)
date: 2026-06-16
from_team: team_50 (E2E validator)
to_team: team_100, team_190
wp: WP-W2-16
gate: L-GATE_BUILD (E2E)
engine_builder: claude-code (team_100)
engine_validator: cursor-composer (team_50)   # IR#1 compliant
branch: wp-w2-16 @ de21a5d
staging: http://eyalamit-co-il-2026.s887.upress.link
theme_ver: 1.4.13
mandate: _COMMUNICATION/team_100/MANDATE-TEAM50-WP-W2-16-E2E-VALIDATE-2026-06-16.md
closeout_ref: _COMMUNICATION/team_100/WP-W2-16-VERIFICATION-CLOSEOUT-2026-06-16.md
evidence: _COMMUNICATION/team_50/evidence/wp-w2-16-e2e-2026-06-16/
status: ISSUED
delivery: file-based
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-16 — post-content completion (5 batches 16-A…16-E) |
| Gate | L-GATE_BUILD (team_50 E2E) |
| **Verdict** | **PASS** |
| Precondition | docx-parser sanity `true`; per-`<w:p>` run join live on branch (`3b94fce` aligns canonical fix) |
| Content-diff | **17/17** measurable pages `gatePass` · 0 PARTIAL/INVENTED among sourced pages |
| Overflow | **28/28** probes @360/390/414/768 · **0** horizontal overflow |
| Axe (S5) | **14/14** routes · **0 critical / 0 serious** |
| Redirects | **4/4** single-hop 301→200 · **0** loops |
| Blog pagination | `/blog/page/2/` **200** · **12** distinct posts vs page 1 · **0** shared permalinks |
| Visual (5 batches) | **5/5 PASS** (screenshots in evidence) |
| Asset 200s | hero video + poster **200** |
| Blocking findings | **None** |
| One-line next step | **team_190** may proceed with final validation (Iron Rule #5) |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| Builder | **Claude Code** (team_100) — batches 16-A…16-E on `wp-w2-16` |
| Validator | **Cursor Composer** (team_50) — independent live staging probe 2026-06-16 |
| Cross-engine | Confirmed — this verdict is NOT from Claude |
| Gate order | team_50 PASS → preconditions team_190 final validation |

---

# §2 Precondition — docx parser fix

| Check | Result |
|-------|--------|
| Branch | `wp-w2-16` @ `de21a5d` |
| Sanity command | `node -e "…readSource('מוקש דהימן/ומה היום.docx'…)"` → **`true`** |
| Parser commit on branch | `3b94fce` — aligns per-`<w:p>` run-join to canonical main toolchain fix (`88160bd` lineage) |
| **Precondition** | **PASS** |

---

# §3 Commands Run + Exit Codes

| Command | Exit | Evidence |
|---------|------|----------|
| `node scripts/qa/content-diff.mjs --base <staging> --out …/content-diff` | **0** | `content-diff/summary.json` — **17/17 gatePass** |
| `node …/qa_probe.mjs --config qa_probe_config.json --out …/qa_probe --shots` | **0** | `qa_probe_result.json` — **28/28** no overflow |
| `node scripts/qa/http-qa-axe.cjs --base <staging>` | **0** | `axe-http-2026-06-16.json` — **0 crit / 0 serious** |
| Redirect probes (node fetch, manual redirect) | **pass** | `redirect-probes.json` |
| Blog pagination distinctness | **pass** | `blog-pagination.json` |
| Asset HEAD probes | **pass** | `asset-200s.json` |
| Visual batch puppeteer (5 batches) | **0** | `visual/visual_batch_results.json` + PNGs |

---

# §4 Gate Results (mandate checks 1–7)

## Check 1 — content-diff (authoritative)

| Metric | Result |
|--------|--------|
| Measurable pages | **17/17** `gatePass` |
| Site accuracy (weighted) | **99.72%** |
| PARTIAL / INVENTED (sourced) | **0** |
| `/eyal-amit/` | ACCURATE · section 100% · sentence 100% |
| `/eyal-amit/mokesh-dahiman/` | ACCURATE · section 100% · sentence 100% · source `ומה היום.docx` |
| **Verdict** | **PASS** |

## Check 2 — overflow (qa_probe)

| Pages | Viewports | Failures |
|-------|-----------|----------|
| `/`, `/faq/`, `/eyal-amit/`, `/eyal-amit/mokesh-dahiman/`, `/treatment/`, `/lessons/`, `/sound-healing/` | 360, 390, 414, 768 | **0** |
| **Verdict** | **PASS** (28/28) |

## Check 3 — axe (S5 a11y)

| Routes | Critical | Serious |
|--------|----------|---------|
| 14 default staging routes | **0** | **0** |
| **Verdict** | **PASS** |

## Check 4 — redirects (single-hop, no loops)

| From | Chain | Final |
|------|-------|-------|
| `/about/` | 301 (1 hop) | `/eyal-amit/` **200** |
| `/about/moksha/` | 301 (1 hop) | `/eyal-amit/mokesh-dahiman/` **200** |
| `/mokesh-dahiman/` | 301 (1 hop) | `/eyal-amit/mokesh-dahiman/` **200** |
| `/mokesh/` | 301 (1 hop) | `/eyal-amit/mokesh-dahiman/` **200** |
| **Verdict** | **PASS** |

## Check 5 — blog pagination (Eyal #6)

| Check | Result |
|-------|--------|
| `/blog/page/2/` HTTP | **200** |
| Page 1 post slugs | **12** |
| Page 2 post slugs | **12** |
| Shared permalinks | **0** |
| **Verdict** | **PASS** |

## Check 6 — visual (mockup-vs-live, 5 batches)

| Batch | What verified | Result | Screenshot |
|-------|---------------|--------|------------|
| **16-A** | `<video>` muted+loop playing (`currentTime>0`); poster URL live | **PASS** | `visual/16-A-hero-video-home-w768.png` |
| **16-C** | `.ea-faq-toc` sticky; 10 chips / 10 anchors; `#ea-faq-cat` retired; scroll-spy active chip | **PASS** | `visual/16-C-faq-toc-top.png`, `…-scrollspy.png` |
| **16-B** | `.ea-testi-carousel__track` CSS `ea-testi-scroll` animates; 15 home cards; pauses on hover | **PASS** | `visual/16-B-carousel-home.png`, `…-treatment.png` |
| **16-D** | `/eyal-amit/` canonical page; ≥4 shop routes in nav (6 observed) | **PASS** | `visual/16-D-eyal-amit-canonical.png` |
| **16-E** | Mokesh memorial: `ומה היום`, Ganges section, `תם עידן מוקש`, `jungel vibes`; `.ea-14e-note` placeholder | **PASS** | `visual/16-E-mokesh-memorial-full.png` |
| **Verdict** | **PASS** |

## Check 7 — asset 200s

| Asset | HTTP |
|-------|------|
| `…/ea-eyalamit/assets/video/ea-home-hero-720-muted.mp4` | **200** |
| `…/ea-eyalamit/assets/video/ea-home-hero-poster.jpg` | **200** |
| **Verdict** | **PASS** |

---

# §5 Batch Acceptance Summary

| Batch | Decision | team_50 E2E |
|-------|----------|-------------|
| 16-A Hero video | D-13=ב | **PASS** |
| 16-C FAQ TOC | #3 | **PASS** |
| 16-D `/eyal-amit` canonical + shop nav | D-15=ב, #7/#9 | **PASS** |
| 16-B Testimonials carousel | D-14=א, #2 | **PASS** |
| 16-E Mokesh memorial verbatim | D-16, #8 | **PASS** |

---

# §6 Notes for team_190

1. **docx parser:** Gate change is intentional — per-`<w:p>` extraction (not space-joined runs). Mokesh is the only affected source; team_190 should confirm parser soundness per closeout §"Gate change to flag".
2. **Poster filename:** Live asset is `ea-home-hero-poster.jpg` (mandate shorthand `…-poster.jpg` — same asset, theme-relative path under `ea-eyalamit`).
3. **Placeholders by design:** Mokesh bio/dates/photos flagged via `.ea-14e-note` — pending Eyal final edit; not a gate failure.
4. **`jungel vibes`:** Preserved verbatim (lowercase) per Eyal source — brand-fix deferred to Eyal.

---

# §7 Evidence Index

| Artifact | Path |
|----------|------|
| Content-diff summary | `evidence/wp-w2-16-e2e-2026-06-16/content-diff/summary.json` |
| Mokesh page diff | `evidence/wp-w2-16-e2e-2026-06-16/content-diff/_mokesh-dahiman.json` |
| Eyal-amit page diff | `evidence/wp-w2-16-e2e-2026-06-16/content-diff/_eyal-amit.json` |
| Overflow config + results | `…/qa_probe_config.json`, `…/qa_probe_result.json`, `…/qa_probe/screenshots/` |
| Axe report | `…/axe-http-2026-06-16.json` |
| Redirect probes | `…/redirect-probes.json` |
| Blog pagination | `…/blog-pagination.json` |
| Asset 200s | `…/asset-200s.json` |
| Visual batches | `…/visual/visual_batch_results.json` + `16-{A…E}-*.png` |

---

# §8 Sign-off

**team_50 E2E verdict: PASS.** All seven mandated checks green on live staging @ theme **1.4.13**. No blocking findings filed to team_100. **team_190** cleared to run final validation.

*Issued 2026-06-16 · Cursor Composer (team_50) · cross-engine per ADR034 / Iron Rule #1*
