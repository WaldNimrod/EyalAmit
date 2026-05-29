---
id: MANDATE-TEAM190-W2-07-L-GATE-VALIDATE-2026-05-29
from_team: team_100 (Chief System Architect)
to_team: team_190 (Final Validator — constitutional, IR#5)
wp: WP-W2-07 — Press + Moksha + 48 QR pages + FB Top-5 testimonials
date: 2026-05-29
gate: L-GATE_VALIDATE
build_commit: c7dc34a
branch: feature/w2-07-heritage
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-07
staging: http://eyalamit-co-il-2026.s887.upress.link
status: ISSUED
---

# L-GATE_VALIDATE Mandate — WP-W2-07 (Heritage)

## §0 — Engine constraint (IR#1)
team_190 MUST run on **native Codex / OpenAI / GPT-5** (≠ Claude builder team_10, ≠ team_50 QA).
Confirm engine in line 1 of your verdict.

## §0.1 — Worktree
`/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-07` (branch `feature/w2-07-heritage`). Shared tree on main — do NOT validate there.

## §1 — Prior gate state
- **L-GATE_BUILD:** _(team_50, non-Claude — run ONLY after team_50 PASS / PASS_WITH_FINDINGS, no P0/P1.)_
  Verdict: `_COMMUNICATION/team_50/VERDICT-W2-07-L-GATE-BUILD-2026-05-29.md`.
- **L-GATE_SPEC:** PASS (team_190 Codex v2, 2026-05-28; commit 1306e51); spec later corrected 49→48 (see §3.1).
- **team_100 pre-gate live check (2026-05-29):** qr1/qr21/qr48 + /press + /about/moksha all 200; 0 localhost:9090
  leak on qr1/qr21; /press 36 new-tab links; validate_aos 30 PASS / 0 FAIL.

## §2 — Proof-of-HEAD (require before validating)
- `git -C "/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-07" rev-parse HEAD` → **`c7dc34a`**; base main @ `8270d98`.
- Deployed `style.css` Version = **1.4.5**. **CACHE-BUST every HTTP check** (`?cb=$(date +%s)$RANDOM`).

## §3 — Scope (LOD400 AC-01..05, independent live re-verify)
- **AC-01:** all **48** `/qr/qrN/` → 200 (loop vs `docs/project/team-100-preplanning/QR-URL-INVENTORY.csv`);
  body_html migrated 1:1; **zero live `localhost:9090` URLs** in any QR page HTML.
- **AC-02:** `/about/moksha` (existing page 181, REST-updated — not recreated) renders content + image + link to `/about`.
- **AC-03:** `/press` shows ≥5 (all 26) legacy articles, each external link `target=_blank rel=noopener`.
- **AC-04:** FB Top-5 testimonials render text + image (rehosted or grey placeholder) + FB link (new tab).
- **AC-05:** external links new-tab; `validate_aos.sh` → 0 FAIL; D-14 tokens only (no raw hex in w2-07-heritage.css).

## §3.1 — SSoT re-confirm (REQUIRED, brief)
QR page count was corrected **49 → 48** (legacy dump + inventory CSV both = 48 distinct qrN; 49th was the
parent `/qr/`). **Re-confirm the count = 48** (number only) in your verdict — it is NOT a defect.

## §3.2 — Scope-additions to confirm safe
- `mu-plugins/ea-w2-07-qr-seed-once.php` + `ea-w2-07-qr-content-data.php` (NEW) + deploy-list entry —
  guarded once-only seeder (ABSPATH, init, option flag v3, transient lock, no wp-load re-require, idempotent);
  KSES filters removed only-if-active then **restored in `finally`** (balanced 1:1) to preserve YouTube iframes.
- `/press` via the_content injection (router); `tpl-qr` added to `ea_wave2_is_active_view` (`wave2-stage-b.php`).
- moksha via REST page 181.

## §4 — Known non-blocking (do NOT block)
- **28 omitted QR images** — legacy source (localhost:9090) permanently offline, absent from both curated
  catalogs and the legacy uploads backup. `<img>` gracefully removed, surrounding text intact, no broken URLs
  live. Carry-forward = team_40 image recovery. Full table: `scripts/_w2_07_image_resolution.json` + build report.
- Testimonial avatars = grey placeholder (spec F05; FB photo acquisition best-effort).

## §5 — Deliverable
Verdict → `_COMMUNICATION/team_190/VERDICT-W2-07-L-GATE-VALIDATE-2026-05-29.md` (PASS / BLOCKED), with
Verdict Box + Fresh-tree Proof (HEAD `c7dc34a`) + 8-check table + AC-01..05 live re-verify + QR-count=48 re-confirm.
- On **PASS** → team_100 WP Closure Protocol (roadmap COMPLETE/LOD500_LOCKED via offline-fallback — re-probe
  API first, PRECONDITION#1 disposition-A interim; team_191 archive; merge → main on team_00 go), then re-handoff.
- On **BLOCKED** → team_100 routes remediation to team_10.

*team_100 — 2026-05-29*
