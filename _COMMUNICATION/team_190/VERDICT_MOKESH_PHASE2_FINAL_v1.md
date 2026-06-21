---
id: VERDICT_MOKESH_PHASE2_FINAL_v1
title: team_190 FINAL validation verdict — Mokesh Phase-2 (testimonials + flags)
date: 2026-06-21
from_team: team_190 (FINAL VALIDATION OWNER — Iron Rule #5, constitutional, cross-engine)
to_team: team_00, team_100, team_110, team_50
scope: Phase-2 delta only (testimonials + legacy redirect + VideoObject uploadDate)
staging: http://eyalamit-co-il-2026.s887.upress.link
theme: 1.4.16
branch: mokesh-content (on origin/mokesh-content per mandate; staging reflects deployed Phase-2)
engine_builder: team_110 (Opus / Cursor agent)
engine_validator: team_190 (Cursor Composer)
mandate: _COMMUNICATION/team_190/MANDATE-FROM-110-MOKESH-PHASE2-FINAL-2026-06-21.md
builder_input: _COMMUNICATION/team_110/PHASE2-TESTIMONIALS-FLAGS-COMPLETE-2026-06-21.md
evidence: _COMMUNICATION/team_190/evidence/mokesh-phase2-final-2026-06-21/
status: ISSUED
delivery: file-based (ADR043 §4/§5 — hub DB offline)
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| Subject | Phase-2 — 48 FB testimonials, legacy single-hop redirect, VideoObject `uploadDate` |
| Gate | FINAL validation (team_190 constitutional cross-engine) |
| team_190 technical gates | **PASS** — all Phase-2 acceptance criteria independently re-run |
| Verdict | **PASS** |
| Dual-PASS chain | **INCOMPLETE** — team_50 Phase-2 verdict file `VERDICT_MOKESH_PHASE2_v1.md` **not on disk** at validation time |
| Merge to `main` | **Blocked** — requires dual-PASS + Nimrod explicit **«מאשר»** (per mandate) |

---

# §1 Engine declaration (IR#1 / IR#5)

| Field | Value |
|-------|-------|
| Builder | **team_110** (BUILDER — Opus; must not self-certify) |
| E2E / dual-pass peer | **team_50** — mandate requires non-Claude engine; **`VERDICT_MOKESH_PHASE2_v1.md` not present** |
| Constitutional validator | **team_190 (Cursor Composer)** — this document |
| Attestation | All gates below were **re-run independently** on live staging; builder numbers were not trusted |

Phase-1 (memorial page) already final-PASSed on `main`. This verdict covers **only** the Phase-2 delta listed in the mandate.

---

# §2 Acceptance criteria — results

| # | Criterion | Threshold | team_190 result | Evidence |
|---|-----------|-----------|-----------------|----------|
| 1 | **content-diff** (full site) | 17/17 PASS · 0 under-90 · service + home + mokesh 100/100/0 | **PASS** — `gateWouldPassCount` 17 · `pagesUnder90Pct` 0 · mokesh 100/100/0 (161/161) · `/` `/method/` `/treatment/` `/sound-healing/` `/lessons/` all 100/100/0 | `content-diff/summary.json`, per-route JSON |
| 2 | **axe** a11y (changed routes) | 0 critical / 0 serious | **PASS** — 5 routes · crit=0 serious=0 · HTTP 200 | `axe.stdout.txt`, `axe-http.json` |
| 3 | **qa_probe** (CDP) | no horizontal overflow mobile+desktop | **PASS** — 12/12 (6 routes × mobile 375 + desktop 1440) · 0 overflow | `qa_probe.stdout.txt`, `qa_probe/qa_probe_result.json` |
| 4 | **Redirects** | legacy Hebrew slug + `/about/moksha/` + `/mokesh/` + `/mokesh-dahiman/` → single 301 → canonical 200 | **PASS** — all four paths: `REDIRECT_COUNT=1` → `…/eyal-amit/mokesh-dahiman/` HTTP 200; legacy path shows `X-EA-Redirect: w209-301` | `redirects.txt` |
| 5 | **/media** testimonials | 48 cards · 3 category groups · names → FB | **PASS** — 48× `ea-tcard` · 48 FB name links · H3 groups: טיפול / סאונד הילינג / שיעורים | `media-page.html`, `media-fidelity-summary.json` |
| 6 | **VideoObject** `uploadDate` | `2019-11-19` on mokesh page | **PASS** — `uploadDate":"2019-11-19T14:41:31-08:00"` in JSON-LD | `mokesh-page.html`, `videoobject-summary.json` |

**Overall team_190 technical verdict: PASS**

---

# §3 Phase-2 surface spot-check (detail)

| Check | Observed |
|-------|----------|
| Service carousels additive | content-diff green on `/treatment/` `/method/` `/sound-healing/` `/lessons/` — testimonials appended without source regression (100/100/0 each) |
| /media grouping | 3× `ea-media-cat` H3 headings under «עדויות משתתפים» |
| FB deep links | Every `ea-tcard__n` anchor targets `facebook.com` (48/48) |
| Legacy slug (was 2-hop) | `/דיגרידו-המרכז-לטיפול-בדיגרידו-סטודי/מוקש-דהימן-מאסטר-דיגרידו-דף-להנצחת-זכ/` → **1×301** direct to canonical (no `/about/moksha/` intermediate) |
| Mokesh memorial regression | mokesh row unchanged at 100/100/0 · 161/161 sentences |

---

# §4 Accepted non-blocking flags (recorded, not gate failures)

Per `_COMMUNICATION/team_110/PHASE2-TESTIMONIALS-FLAGS-COMPLETE-2026-06-21.md`:

| Flag | Status |
|------|--------|
| Provisional testimonial snippets (Eyal curation via `hub/data/testimonials-curation.json`) | **Accepted** |
| Full-film embed link pending Eyal | **Accepted** |
| Shop CTA richer widget vs plain source lines | **Accepted** — intentional UX; pages still ≥90% |
| FB iframe minor mobile clip | **Accepted** — no document overflow (qa_probe green) |

---

# §5 Dual-PASS chain status

| Link | Artifact | Status |
|------|----------|--------|
| team_110 Phase-2 complete | `PHASE2-TESTIMONIALS-FLAGS-COMPLETE-2026-06-21.md` | Received |
| team_50 Phase-2 verdict | `_COMMUNICATION/team_50/VERDICT_MOKESH_PHASE2_v1.md` | **NOT PRESENT** at validation time |
| team_50 Phase-1 dual-pass | `VERDICT_MOKESH_DUALPASS_2026-06-21.md` | Present (Phase-1 scope only) |
| team_190 Phase-2 final | this document | **PASS** |

Per mandate: **do not merge Phase-2 to `main` until team_50 AND team_190 both PASS and Nimrod issues explicit «מאשר».** team_190 has passed; merge remains blocked pending team_50 Phase-2 verdict artifact and Nimrod sign-off.

---

# §6 Evidence index

| Artifact | Path |
|----------|------|
| Content-diff summary + per-route JSON | `evidence/mokesh-phase2-final-2026-06-21/content-diff/` |
| Axe stdout + JSON | `…/axe.stdout.txt`, `…/axe-http.json` |
| qa_probe CDP | `…/qa_probe.stdout.txt`, `…/qa_probe/qa_probe_result.json` |
| Redirect traces | `…/redirects.txt` |
| /media HTML + counts | `…/media-page.html`, `…/media-fidelity-summary.json` |
| Mokesh HTML + VideoObject | `…/mokesh-page.html`, `…/videoobject-summary.json` |

---

# §7 Commands re-run (team_190 session 2026-06-21)

```bash
node scripts/qa/content-diff.mjs --out _COMMUNICATION/team_190/evidence/mokesh-phase2-final-2026-06-21/content-diff
node scripts/qa/http-qa-axe.cjs /media/ /lessons/ /treatment/ /sound-healing/ /method/
node /Users/nimrod/Documents/agents-os/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs \
  --base http://eyalamit-co-il-2026.s887.upress.link \
  --paths /media/,/lessons/,/treatment/,/sound-healing/,/method/,/eyal-amit/mokesh-dahiman/ \
  --out _COMMUNICATION/team_190/evidence/mokesh-phase2-final-2026-06-21/qa_probe
```

Redirect + HTML probes: `curl -sI` / `curl -sL` against staging (see `redirects.txt`, `media-page.html`, `mokesh-page.html`).

---

**Signed:** team_190 · Cursor Composer · 2026-06-21 · constitutional final sign-off **PASS** (Phase-2 technical); **merge to `main` pending team_50 `VERDICT_MOKESH_PHASE2_v1.md` + Nimrod «מאשר»**
