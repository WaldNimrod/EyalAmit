---
id: VERDICT_MOKESH_PHASE2_v1
title: team_50 Independent Validation — Mokesh Phase-2 (testimonials + flag fixes)
date: 2026-06-21
local_date: 2026-06-21 Asia/Jerusalem
from_team: team_50 (cross-engine VALIDATOR)
to_team: team_110, team_190, team_00
scope: Phase-2 only (testimonials + flags); Phase-1 already merged to main
gate: L-GATE_BUILD (Mokesh Phase-2 — dual-PASS leg 1)
correction_cycle: initial (team_110 Phase-2 build complete)
engine_builder: team_110 (BUILDER, Opus)
engine_validator: Composer in Cursor (team_50)   # IR#1 compliant (non-Claude)
branch_observed: mokesh-content @ origin/mokesh-content (uncommitted at validation time)
staging: http://eyalamit-co-il-2026.s887.upress.link
theme_ver_live: 1.4.16
mandate: _COMMUNICATION/team_50/MANDATE-FROM-110-MOKESH-PHASE2-VALIDATE-2026-06-21.md
builder_handoff: _COMMUNICATION/team_110/PHASE2-TESTIMONIALS-FLAGS-COMPLETE-2026-06-21.md
evidence: _COMMUNICATION/team_50/evidence/mokesh-phase2-2026-06-21/
status: ISSUED
delivery: file-based
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| Scope | Phase-2 — service carousels, `/media`, legacy redirect, VideoObject `uploadDate` |
| Gate | team_50 independent validation (Mokesh Phase-2) |
| **Verdict** | **PASS** |
| Blocking findings | **None** |
| content-diff | **17/17 PASS** · 0 under-90 · service routes + home + mokesh **100/100/0** |
| Axe a11y | **0 critical / 0 serious** (`/media/`, `/lessons/`, `/treatment/`, `/sound-healing/`) |
| qa_probe overflow | **6/6** (3 routes × mobile 375 + desktop 1440) · **0** horizontal overflow |
| Legacy Hebrew slug | **1×301** → `/eyal-amit/mokesh-dahiman/` → **200** (single hop — was 2-hop) |
| /media | **48** `ea-tcard` testimonials · **3** category groups · **48** name→FB links |
| VideoObject | `uploadDate` **2019-11-19** present (`2019-11-19T14:41:31-08:00`) |
| Handoff | **team_190 may proceed** to Phase-2 final gate |

---

# §1 Engine Declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| Builder | **team_110** — `mokesh-content` branch, theme 1.4.16 deployed |
| Validator | **team_50 / Composer in Cursor** — all gates re-run independently 2026-06-21 |
| Cross-engine | Confirmed — validator did not trust builder evidence; every gate re-executed |
| Builder claim | content-diff 17/17, axe 0/0, qa_probe clean, Hebrew slug single-hop, 48 cards, uploadDate |
| Validator outcome | **All builder claims independently confirmed** |

---

# §2 Commands Run + Exit Codes

| Command | Exit | Evidence |
|---------|------|----------|
| `node scripts/qa/content-diff.mjs --base http://eyalamit-co-il-2026.s887.upress.link --out …/content-diff` | **0** | `content-diff/summary.json`, per-page JSON |
| `node scripts/qa/http-qa-axe.cjs /media/ /lessons/ /treatment/ /sound-healing/` | **0** | `axe.stdout.txt`, `axe-http.json` |
| `node _aos/lean-kit/…/qa_probe.mjs --base … --paths /media/,/lessons/,/eyal-amit/mokesh-dahiman/ --out …/qa_probe` | **0** | `qa_probe/qa_probe_result.json` |
| `curl -sI` legacy Hebrew slug + mokesh redirects + canonical 200 | **0** | `redirect-check.json` |
| Live HTML parse (`/media` cards + VideoObject) | **0** | `media-check.json`, `videoobject-check.json` |

---

# §3 Gate Results (mandate)

## Check 1 — content-diff (17/17, no regression)

| Route | sectionCov | sentenceCov | invented | gatePass |
|-------|------------|-------------|----------|----------|
| `/` | **100** | **100** | 0 | true |
| `/method/` | **100** | **100** | 0 | true |
| `/treatment/` | **100** | **100** | 0 | true |
| `/sound-healing/` | **100** | **100** | 0 | true |
| `/lessons/` | **100** | **100** | 0 | true |
| `/eyal-amit/mokesh-dahiman/` | **100** | **100** (161/161) | 0 | true |
| *(+ 11 other measured routes)* | all ≥95 / ≥90 | — | 0 | true |
| **Site aggregate** | gateWouldPassCount **17** · pagesUnder90 **0** |
| **Verdict** | **PASS** — testimonials additive; no content-diff regression |

## Check 2 — axe a11y

| Route | HTTP | Critical | Serious |
|-------|------|----------|---------|
| `/media/` | 200 | **0** | **0** |
| `/lessons/` | 200 | **0** | **0** |
| `/treatment/` | 200 | **0** | **0** |
| `/sound-healing/` | 200 | **0** | **0** |
| **Verdict** | **PASS** |

## Check 3 — layout/overflow (qa_probe)

| Viewport | `/media/` | `/lessons/` | `/eyal-amit/mokesh-dahiman/` |
|----------|-----------|-------------|------------------------------|
| mobile (375) | overflow=false | overflow=false | overflow=false |
| desktop (1440) | overflow=false | overflow=false | overflow=false |
| **Verdict** | **PASS** (6/6, failures=0) |

## Check 4 — legacy redirect single-hop (flag 3a)

| Source | 1st hop | Location | Final |
|--------|---------|----------|-------|
| `/דיגרידו-המרכז-לטיפול-בדיגרידו-סטודי/מוקש-דהימן-מאסטר-דיגרידו-דף-להנצחת-זכ/` | **301** | `/eyal-amit/mokesh-dahiman/` | **200** |
| `/about/moksha/` | **301** | `/eyal-amit/mokesh-dahiman/` | **200** |
| `/mokesh/` | **301** | `/eyal-amit/mokesh-dahiman/` | **200** |
| `/mokesh-dahiman/` | **301** | `/eyal-amit/mokesh-dahiman/` | **200** |
| **Verdict** | **PASS** — Hebrew slug now **single-hop** (Phase-1 open flag **resolved**) |

## Check 5 — /media testimonials (item 2)

| Criterion | Result |
|-----------|--------|
| Total testimonial cards (`ea-tcard`) | **48** |
| Category groups (`ea-media-cat` H3) | **3** — טיפול בדיג'רידו · סאונד הילינג · שיעורי נגינה בדיג'רידו |
| Name links to FB post | **48/48** |
| **Verdict** | **PASS** |

## Check 6 — VideoObject uploadDate (flag 3b)

| Criterion | Result |
|-----------|--------|
| `@type: VideoObject` present | **yes** |
| `uploadDate` | **2019-11-19T14:41:31-08:00** |
| **Verdict** | **PASS** (Phase-1 open flag **resolved**) |

---

# §4 Accepted Non-Blocking Flags (per builder §item3)

Validator confirms these remain **non-blocking** per mandate:

1. Testimonial **snippets are PROVISIONAL** — auto-generated; Eyal curation pending via `hub/data/testimonials-curation.json`.
2. **Full-film placeholder** — blocked on Eyal link; FB film page link retained.
3. **Shop-page CTA "gaps"** — intentional richer purchase widget (both shop pages ≥90% content-diff).
4. **FB iframe minor mobile clip** — no document overflow (qa_probe green).

---

# §5 Findings Summary

| ID | Severity | Finding |
|----|----------|---------|
| — | — | **No blocking findings** |

---

# §6 Phase-1 Open Flags — Resolution Status

| Phase-1 flag | Phase-2 status |
|--------------|----------------|
| Hebrew slug 2-hop | **RESOLVED** — now 1×301 → canonical |
| VideoObject no `uploadDate` | **RESOLVED** — `2019-11-19` present |
| Full-film placeholder | **Still open** (Eyal asset) — accepted |
| «בתחתית העמוד» vs hero trailer | **Still open** (Eyal-review) — accepted |
| FB iframe clip on small mobile | **Still open** (cosmetic) — accepted |

---

# §7 Handoff

| To | Action |
|----|--------|
| **team_190** | Run Phase-2 final cross-engine gate per `MANDATE-FROM-110-MOKESH-PHASE2-FINAL-2026-06-21.md` |
| **team_110** | Do **not** declare Eyal-ready or merge to `main` until team_190 PASS + Nimrod explicit go |
| **team_00 / Nimrod** | Phase-2 commit remains gated on dual-PASS closure |

---

**Signed:** team_50 (VALIDATOR) · 2026-06-21 · file-transport (hub DB offline)
