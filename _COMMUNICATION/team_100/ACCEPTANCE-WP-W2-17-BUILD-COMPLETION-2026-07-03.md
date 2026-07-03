---
id: ACCEPTANCE-WP-W2-17-BUILD-COMPLETION-2026-07-03
from_team: team_100 (Chief Architect — claude-code)
to_team: team_00 (info) + team_110 (disposition) + team_90 (context for re-audit)
date: 2026-07-03
type: build-acceptance + disposition
wp: WP-W2-17
gate: L-GATE_BUILD → PASS (team_110 completion accepted); advancing to L-GATE_VALIDATE
refs:
  - _COMMUNICATION/team_110/WP-W2-17/COMPLETION_REPORT_WP-W2-17_v1.0.0.md
  - _COMMUNICATION/team_90/VALIDATE-REQUEST-WP-W2-17-2026-07-03.md
---

# ACCEPTANCE — WP-W2-17 build completion (team_110) + team_100 disposition of routed items

team_110 delivered the COMPLETION_REPORT for WP-W2-17 (executed on claude-code; 15 commits `b95c24f`..`6fcf840`; validate_aos 45/0). team_100 performed **independent live verification** (not a rubber-stamp) before accepting. Result: **L-GATE_BUILD ACCEPTED**, with one material correction to team_110's image classification (§2).

## 1. Independently verified live-correct (spot-check, retry-tolerant)

| Task | Claim | team_100 live check | Result |
|---|---|---|---|
| T3 (D-1) | exactly 1 meta-description per route | `curl … \| grep -o 'name="description"' \| wc -l` on `/`, `/method/`, `/treatment/`, `/eyal-amit/` | **1 / 1 / 1 / 1** ✓ (incl. `/method/`, previously 0) |
| T5 (D2) | GeoCircle live with ratified coords | home JSON-LD grep | **GeoCircle present, lat 32.4637761** (in band) ✓ |
| T4 (D-2) | test pages unpublished | `curl -o /dev/null -w %{http_code}` | `/sample-page/` **404**, `/wave2-test/` **404** ✓ |
| T6 (D3) | staging robots stays block-all | `curl /robots.txt` | `User-agent: * / Disallow: /` ✓ |

team_110 also found and fixed **5 real live-only defects** beyond spec scope (tel: lead had zero `generate_lead` tracking; og:image duplicate on `/books/kushi-blantis/`; hreflang check over-scoped; sitemap muzza/muzeh transposition; missing `--set-status` in `wp_rest_client.py`). These are genuine quality catches — accepted.

## 2. CORRECTION — team_110's image "content gaps" are a stale-manifest artifact (0 content gaps, 0 Eyal asks)

team_110's §2b routed **2 "genuine content gaps needing Eyal sourcing"** (`ea-home-hero-poster.jpg`, `kushi-04-sinai.jpg`, `kushi-02-eyal-italy.jpg`) + **3 "mapping-gap covers"** to team_100. **team_100 verification finds all of these files exist in-repo AND are live-200 on staging** — there is **no content gap and no Eyal ask**.

| File | team_110 said | team_100 verified (live) |
|---|---|---|
| `ea-home-hero-poster.jpg` | (d) content gap, "404 everywhere", needs sourcing | **200** at `assets/video/ea-home-hero-poster.jpg` (the exact path `home-defaults.php:26` uses) |
| `kushi-04-sinai.jpg` | (d) content gap, needs sourcing | **200** at `assets/images/kushi-04-sinai.jpg` |
| `kushi-02-eyal-italy.jpg` | (d) content gap, needs sourcing | **200** at `assets/images/kushi-02-eyal-italy.jpg` |
| `tsva-bechol-cover.jpg` | (c) mapping gap (uploads only) | **200** at `assets/images/…` AND `uploads/2026/04/…` |
| `kushi-blantis-cover.jpg` | (c) mapping gap | **200** at both paths |
| `vekatavt-cover.jpg` | (c) mapping gap | **200** at both paths |

**Root cause:** `_COMMUNICATION/team_110/image-map.json` carries **stale aspirational slot paths** — `assets/ea-home-hero-poster.jpg`, `assets/covers/*`, `assets/gallery/*` — that were never the real file locations. The real files live at `assets/video/` and `assets/images/`. The `image-audit.cjs` HEAD-checks the manifest's stale paths (all 404), producing false "missing slot / content gap" findings. Confirmed: the 3 stale paths return **404**, the 6 real paths return **200**.

**Disposition:**
- **Zero Eyal content asks arise from the image audit.** (No hub change — I did not add phantom image requests.)
- The only real work is a **manifest reconciliation** of `image-map.json` (a team_110 artifact) — align slot paths to the real `assets/video/` + `assets/images/` locations, and for any slot whose built page genuinely does not render the image (e.g. `/eyal-amit/` book-cover slots — `about-defaults.php` has no cover refs, so the manifest is ahead of the built page), remove the entry or record it as an intended future build. **Low priority; blocks nothing; no Eyal input; no site-code change.** Routed to team_110 as a follow-up (not gating this WP's re-audit).
- For the CR-FINAL re-audit, the image-audit "missing slot" findings are a **documented, evidence-backed known-artifact** (like the brand deviation) — non-blocking; team_90 should note them, not fail on them (see the re-audit mandate).

This is the second over-classified "content gap" this WP stream has surfaced (the first was the P0 brand string). team_100 oversight caught both; taking the builder report at face value would have generated phantom Eyal asks.

## 3. Minor items noted (non-blocking)

- **/method/ pre-fix baseline discrepancy** (team_110 §3): team_110 notes `/method/` has its own `phero_sub`, so the theme's route logic *should* have produced 1 tag pre-fix, contradicting the report's "0 tags" baseline for that route. Doesn't affect the fix (Yoast owns it now, live = 1). Flagged to team_90 to reconcile the exact pre-fix baseline if desired.
- **EN draft** (`_COMMUNICATION/team_110/EN-REFRESH-DRAFT-WP-W2-17-2026-07-03.md`) delivered with **4 open questions for team_100/Eyal** — team_100 to review those before the draft goes to Eyal via the hub. Follow-up; non-blocking; hub ask already reads "draft in preparation."
- **AC-12 step 5** (SMTP/honeypot posture) correctly scoped out by team_110 to team_100/uPress-ops, target ≤2026-07-09 — unchanged, already registered.

## 4. Gate action
- L-GATE_BUILD: **PASS** (accepted with the §2 correction).
- Advancing WP-W2-17 `current_lean_gate` → **L-GATE_VALIDATE**; canonical CR-FINAL leg-1 re-audit dispatched to team_90 (`MANDATE-TEAM90-CRFINAL-RERUN-2026-07-03_v1.0.0.md`), superseding team_110's direct validate-request.
- No "ready" to Eyal — triple-PASS chain only.
