---
id: MANDATE-TEAM50-WAVE2-L-GATE-BUILD-2026-05-28
title: Wave2 L-GATE_BUILD QA Mandate — WP-W2-02 (Core Content) + WP-W2-06 (Blog Migration)
from_team: team_100 (Chief System Architect)
to_team: team_50 (QA / L-GATE_BUILD)
date: 2026-05-28
gate: L-GATE_BUILD
wps: [WP-W2-02, WP-W2-06]
branch: feature/w2-06-blog
staging: http://eyalamit-co-il-2026.s887.upress.link
supersedes: _COMMUNICATION/team_50/MANDATE-TEAM50-W2-06-L-GATE-BUILD-2026-05-28.md (builder-drafted — VOID, see §0)
status: ISSUED
---

# Wave2 L-GATE_BUILD QA Mandate — team_50

**Identity:** Issued by **team_100 — Chief System Architect** under delegated L-GATE_BUILD authority.

## §0 — Independence & engine constraint (READ FIRST — MANDATORY)

1. **This mandate supersedes** `MANDATE-TEAM50-W2-06-L-GATE-BUILD-2026-05-28.md`, which was drafted by the **builder** (team_10). A builder may not commission its own validator — that draft is VOID and is retained only as input context.
2. **IR#1 cross-engine disposition (team_00, strict, 2026-05-28):** Both builders ran on **claude-sonnet-4-6**. Therefore the L-GATE_BUILD validator **MUST run on a NON-Claude engine** (cursor-composer or native Codex/GPT-5). **A Claude sub-agent of any model is NOT permitted for this gate.** If you are a Claude engine, **STOP and refuse** — return REFUSED with reason "disallowed engine (IR#1)".
3. Final L-GATE_VALIDATE remains constitutional to **team_190** (native Codex/GPT-5) per Iron Rule #5.

## §1 — Scope & sequencing

| WP | Subject | QA status | Gate |
|----|---------|-----------|------|
| **WP-W2-02** | 6 core pages (home/method/treatment/about/faq/contact) | **READY NOW** | L-GATE_BUILD |
| **WP-W2-06** | Blog migration (54 posts + cats/tags + 301s) | **GATED** — do NOT start until team_100 posts the import-complete go-signal | L-GATE_BUILD |

⚠️ **W2-06 hold:** Its content ACs (posts live, images, 301s) depend on a WXR import + 301 deploy that **team_100 is executing now**. team_100 will drop `_COMMUNICATION/team_50/GO-SIGNAL-W2-06-QA-<timestamp>.md` when staging is ready. Until then, QA **only W2-02**.

Produce **one verdict per WP**: `PASS` / `PASS_WITH_FINDINGS` / `FAIL`, written to `_COMMUNICATION/team_50/QA-VERDICT-<WP>-L-GATE-BUILD-2026-05-28.md`.

---

## §2 — WP-W2-02 acceptance criteria (verify all 10)

Base: `BASE="http://eyalamit-co-il-2026.s887.upress.link"`

| AC | Check | Method |
|----|-------|--------|
| AC-01 | 6 URLs return HTTP 200 | `for p in "" method/ treatment/ about/ faq/ contact/; do echo "${p}: $(curl -sk -o /dev/null -w '%{http_code}' ${BASE}/${p})"; done` — expect all 200 |
| AC-02 | H1 matches 25.5.26 source | view-source each page; H1 per handoff §AC-02 table |
| AC-03 | Wave2 templates active (priority 100) | view-source `/method/` → `body` tag contains `ea-wave2-shell` |
| AC-04 | FAQ filter works | open `/faq/` in browser → pick a category → questions filter; 42 Qs / 5 categories present |
| AC-05 | CF7 CSS only on /contact | confirm `ea_wave2_dequeue_unused_styles()` active (no CF7 CSS on other pages) |
| AC-06 | `/about/moksha/` → 200 | `curl -sk -o /dev/null -w '%{http_code}' ${BASE}/about/moksha/` |
| AC-07 | Legacy slug 301s | `curl -skI "${BASE}/$(python3 -c "import urllib.parse;print(urllib.parse.quote('אייל-עמית-אודות'))")/"` and `${BASE}/eyal-amit/` → 301 → `/about/` |
| AC-08 | `validate_aos.sh` 0 FAIL | run locally on `feature/w2-06-blog`; expect 30 PASS / 18 SKIP / 0 FAIL |
| AC-09 | Mobile `<p>` text-align: start | inspect `ea-atoms.css` `@media (max-width:639px)` |
| AC-10 | style.css Version 1.4.1 | grep theme `style.css` |

**Known non-blocking open items (do NOT fail on these — Eyal-dependent, tracked in ideas.json):** CF7 form ID, GA4/Clarity IDs, homepage video embed, SMTP delivery confirmation. Tech note: `/about` was created via WP REST API (seeder stalled on `wp_insert_post`) — reason documented in the W2-02 handoff; acceptable.

---

## §3 — WP-W2-06 acceptance criteria (verify after go-signal)

| AC | Check |
|----|-------|
| AC-01 | 54 `/blog/<slug>/` → HTTP 200 (sample ≥10 across categories) |
| AC-02 | author / date / categories / tags preserved on posts |
| AC-03 | post images not 404 |
| AC-04 | blog archive: pagination + category filter functional |
| AC-05 | `curl -I /Blog/<slug>/` → 301 to `/blog/<slug>/` (sample ≥5) |
| AC-06 | `validate_aos.sh` → 0 FAIL |
| AC-07 | no shortcode artifacts (VC/Elementor) in rendered posts |
| AC-08 | style.css Version present (1.4.1 in tree — acceptable) |

---

## §4 — Deliverable & next gate

- Verdict file per WP → `_COMMUNICATION/team_50/`.
- On **PASS** (or PASS_WITH_FINDINGS with no P0/P1) → team_100 routes to **team_190 (Codex) L-GATE_VALIDATE**.
- On **FAIL** → team_100 routes remediation back to team_10.

*team_100 — Chief System Architect — 2026-05-28*
