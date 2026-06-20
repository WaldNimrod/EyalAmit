---
id: VERDICT_MOKESH_DUALPASS_2026-06-21
title: team_50 Independent Validation — Mukesh memorial page (dual-PASS)
date: 2026-06-21
local_date: 2026-06-21 Asia/Jerusalem
from_team: team_50 (cross-engine VALIDATOR)
to_team: team_110, team_190, team_00
route: /eyal-amit/mokesh-dahiman/
gate: L-GATE_BUILD (Mokesh content rebuild — dual-PASS)
correction_cycle: initial (team_110 build complete)
engine_builder: team_110 (BUILDER)
engine_validator: GPT in Cursor (team_50)   # IR#1 compliant
branch_observed: mokesh-content (off wave1b-seo-geo; uncommitted at validation time)
staging: http://eyalamit-co-il-2026.s887.upress.link
theme_ver_live: 1.4.16
mandate: _COMMUNICATION/team_50/MANDATE-FROM-110-MOKESH-DUALPASS-VALIDATE-2026-06-21.md
builder_handoff: _COMMUNICATION/team_110/MOKESH-BUILD-COMPLETE-DUALPASS-REQUEST-2026-06-21.md
evidence: _COMMUNICATION/team_50/evidence/mokesh-dualpass-2026-06-21/
status: ISSUED
delivery: file-based
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| Route | `/eyal-amit/mokesh-dahiman/` |
| Gate | team_50 independent validation (Mukesh memorial rebuild) |
| **Verdict** | **PASS** |
| Blocking findings | **None** |
| content-diff (mokesh) | sectionCov **100** · sentenceCov **100** (161/161) · inventedSections **0** · gatePass **true** |
| Axe a11y | **0 critical / 0 serious** |
| qa_probe overflow | **2/2** (mobile 375 + desktop 1440) · **0** horizontal overflow · title non-empty |
| Redirects | **3/3** mandated legacy slugs → **single 301 hop** → canonical **200** |
| Content/visual review | 11 doc sections · «Jungle Vibes» (0× `jungel`) · 19 photos ordered · trailer muted autoplay + unmute · full-film placeholder · 4 FB embeds · dignified mobile |
| Open flags (non-blocking) | Hebrew-slug 2-hop deferred · VideoObject no `uploadDate` · full-film placeholder · verbatim «בתחתית העמוד» vs hero trailer · FB iframe clip on small mobile |
| Handoff | **team_190 may proceed** to final gate; team_110 must not declare Eyal-ready until team_190 also PASS |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| Builder | **team_110** — `mokesh-content` branch, theme 1.4.16 deployed |
| Validator | **team_50 / GPT in Cursor** — all gates re-run independently 2026-06-21 |
| Cross-engine | Confirmed — validator did not trust builder evidence; every gate re-executed |
| Builder claim | content-diff 100/100/0, axe 0/0, qa_probe clean, redirects single-hop |
| Validator outcome | **All builder claims independently confirmed** |

---

# §2 Commands Run + Exit Codes

| Command | Exit | Evidence |
|---------|------|----------|
| `node scripts/qa/content-diff.mjs --base http://eyalamit-co-il-2026.s887.upress.link --out …/content-diff` | **0** | `content-diff/_mokesh-dahiman.json`, `content-diff/summary.json` |
| `node scripts/qa/http-qa-axe.cjs /eyal-amit/mokesh-dahiman/` | **0** | `axe.stdout.txt`, `axe-http.json` |
| `node _aos/lean-kit/…/qa_probe.mjs --base … --paths /eyal-amit/mokesh-dahiman/ --out …/qa_probe` | **0** | `qa_probe/qa_probe_result.json` |
| `curl -sI` first-hop redirect probes (3 paths) + canonical 200 | **0** | `redirect-check.json`, `redirects.txt` |
| Puppeteer trailer/unmute + mobile overflow spot-check | **0** | `trailer-mobile-check.json`, `mobile-375.png` |
| Live HTML parse (sections, photos, FB, spelling) | **0** | `content-visual.json`, `live-page.html` |
| Photo HTTP 200 probe (19 assets) | **0** | `photo-http-check.txt` |

---

# §3 Gate Results (mandate)

## Check 1 — content-diff

| Metric | Result |
|--------|--------|
| sectionCoveragePct | **100** |
| sentenceCoveragePct | **100** (161/161) |
| inventedSections | **0** |
| gatePass | **true** |
| verdict | **ACCURATE** |
| **Verdict** | **PASS** (exceeds bar: section≥95, sentence≥90, invented=0) |

## Check 2 — axe a11y

| Route | HTTP | Critical | Serious |
|-------|------|----------|---------|
| `/eyal-amit/mokesh-dahiman/` | 200 | **0** | **0** |
| **Verdict** | **PASS** |

## Check 3 — layout/overflow (CDP)

| Viewport | scrollWidth | clientWidth | overflow | title |
|----------|-------------|-------------|----------|-------|
| mobile (375) | 375 | 375 | false | מוקש דהימן — לזכרו - eyal amit |
| desktop (1440) | 1440 | 1440 | false | מוקש דהימן — לזכרו - eyal amit |
| **Verdict** | **PASS** (2/2, failures=0) |

## Check 4 — redirect single-hop

| Source | 1st hop | Location | Final |
|--------|---------|----------|-------|
| `/about/moksha/` | **301** | `/eyal-amit/mokesh-dahiman/` | **200** |
| `/mokesh/` | **301** | `/eyal-amit/mokesh-dahiman/` | **200** |
| `/mokesh-dahiman/` | **301** | `/eyal-amit/mokesh-dahiman/` | **200** |
| **Verdict** | **PASS** (3/3 single-hop) |

## Check 5 — content/visual review

| Criterion | Result |
|-----------|--------|
| 11 doc sections (9 prose + eulogy + «Om Mukesh Ji») | **PASS** — 10 prose/eulogy H2 headings + mantra block (`Om Mukesh Ji`); content-diff 161/161 sentences |
| «Jungle Vibes» spelling | **PASS** — 21× «Jungle Vibes» in alt text; **0×** `jungel` |
| Hero trailer `kf4NKSdYi9E` | **PASS** — iframe on `#ea-mokesh-trailer`, `autoplay=1&mute=1`, YT state=1 (playing), muted=true at load |
| Unmute control | **PASS** — click toggles `aria-pressed` true, label → «השתקת קול», YT `muted=false` |
| 19 photos in order | **PASS** — indices 01–19 present in DOM; all **HTTP 200** |
| Full-film placeholder | **PASS** — «יוטמע כאן בקרוב» + FB film page link (accepted open flag) |
| 4 Facebook embeds | **PASS** — 4× `facebook.com/plugins/post.php` iframes at page bottom |
| Dignified on mobile | **PASS** — 375px no overflow; hero gradient + typography readable; FB iframe fixed-width clip noted as accepted cosmetic flag |
| **Verdict** | **PASS** |

---

# §4 Open Flags (accepted — not failures)

Per builder handoff §Open flags; validator confirms these are **non-blocking**:

1. Legacy Hebrew slug remains **2-hop** (redirect-regen out of scope).
2. VideoObject JSON-LD omits `uploadDate` (valid but no video rich-results until Eyal supplies date).
3. Full-film block is a **placeholder** pending Eyal asset.
4. Verbatim «בתחתית העמוד» promo line kept though trailer is in hero (Eyal-review).
5. FB embeds may clip inside fixed-width iframe on small mobile (no document overflow).

---

# §5 Findings Summary

| ID | Severity | Finding |
|----|----------|---------|
| — | — | **No blocking findings** |

---

# §6 Handoff

| To | Action |
|----|--------|
| **team_190** | Run final cross-engine gate on `/eyal-amit/mokesh-dahiman/` per dual-PASS protocol |
| **team_110** | Do **not** declare Eyal-ready until team_190 PASS |
| **team_00 / Nimrod** | Merge `mokesh-content` remains gated on dual-PASS closure + explicit go |

---

**Signed:** team_50 (VALIDATOR) · 2026-06-21 · file-transport (hub DB offline)
