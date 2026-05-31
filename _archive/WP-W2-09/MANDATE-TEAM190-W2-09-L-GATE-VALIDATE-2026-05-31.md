---
id: MANDATE-TEAM190-W2-09-L-GATE-VALIDATE-2026-05-31
from_team: team_100 (Chief System Architect)
to_team: team_190 (Final Validator — constitutional, IR#5)
wp: WP-W2-09 — Media filter + full 301 application + cutover prep (FINAL Wave2 WP)
date: 2026-05-31
gate: L-GATE_VALIDATE
build_commit: 4cad377
branch: feature/w2-09-cutover
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-09
staging: http://eyalamit-co-il-2026.s887.upress.link
status: ISSUED
---

# L-GATE_VALIDATE Mandate — WP-W2-09 (Cutover Prep)

## §0 — Engine (IR#1)
team_190 MUST run on **native Codex / OpenAI / GPT-5** (≠ Claude builder team_20, ≠ team_50). Confirm engine line 1.

## §0.1 — Worktree
`/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-09` (branch `feature/w2-09-cutover`). Shared tree on main — do NOT validate there.

## §1 — Prior gate state
- **L-GATE_BUILD:** _(team_50, non-Claude — run ONLY after team_50 PASS/PWF, no P0/P1.)_
  Verdict: `_COMMUNICATION/team_50/VERDICT-W2-09-L-GATE-BUILD-2026-05-31.md`.
- **team_100 pre-gate live checks (2026-05-31):** PHP redirect plugin deployed + verified — legacy 301s fire
  (`/צור-קשר/→/contact/`, `/הופעות/→/shows/`, kushi→`/books/kushi-blantis/`, moksha→`/about/moksha/`),
  `/thankyou/`→410; live canonicals + 49 QR all stay 200; `final_pre_cutover_check.sh` exits 0; validate 0 FAIL.

## §2 — ⚠ Mechanism change (team_00 ratified) — validate the PHP plugin, NOT .htaccess
The spec/DECISION originally said `.htaccess`. **.htaccess is empirically INERT on the uPress stack**
(nginx + Apache `AllowOverride None`; verified ×3 — every per-page rule 404s). team_00 ratified (2026-05-31)
the switch to **approach A**: a generated guarded PHP mu-plugin `ea-w209-legacy-301-redirects.php`
(`template_redirect` priority 0), produced by `scripts/gen_htaccess_301_from_decisions.py` from the 135-JSON SSoT.
DECISION amended (`_COMMUNICATION/team_00/DECISION_W2-09-301-REDIRECT-APPROACH_2026-05-30_v1.md`). Validate that plugin.

## §3 — Proof-of-HEAD
- `rev-parse HEAD` → **`4cad377`**; base main @ `1652fa6`. CACHE-BUST every HTTP check.

## §4 — Scope (LOD400 AC-01..06, independent live re-verify)
- **AC-01:** in-use media (regenerated `MEDIA-IN-USE-INVENTORY-REGEN-2026-05-30.json`, 74 items ∪ W2-06 blog) all 200.
- **AC-02:** 135-map honored — **25×301 + 2×410** active via the PHP plugin; **49 `/qr/qrN/` + keeps stay live 200**
  (NOT redirected). The legacy `/shop*` rules are intentionally DROPPED (live `/shop` catalog protected — verify 200).
- **AC-03:** first 20 `decisions[]` (file order) each resolve per decision (301 → correct `Location` → live 200; keep → 200).
- **AC-04:** 49 QR live vs `docs/project/team-100-preplanning/QR-URL-INVENTORY.csv`.
- **AC-05:** Lighthouse homepage — **Perf 96 + Accessibility 100 (≥90 PASS)**; **SEO 69 + Best-Practices 78 are
  staging-capped** ONLY by the intentional staging noindex (`ea-staging-noindex.php`) + HTTP-only → both compute
  to **100** once noindex removed + HTTPS live at cutover. **team_00 ACCEPTED this disposition (2026-05-31):**
  "staging is HTTP dev env; SSL lands at the main address (cutover)." HTTPS is spec OUT-of-scope / M7 IDEA-001.
  Do NOT require SEO/BP ≥90 on HTTP staging; do NOT remove the staging noindex.
- **AC-06:** `bash scripts/final_pre_cutover_check.sh` exits 0 (groups a-e PASS; e gates perf+a11y, records SEO/BP staging-cap).

## §5 — Scope-additions to confirm safe
PHP redirect plugin (guarded, priority 0, no loops, sources don't collide with live canonicals); 2 generator
scripts + `final_pre_cutover_check.sh`; `inc/wave2-w2-09.php` (homepage meta-description + favicon); topnav aria fix.
team_100 corrected 2 redirect targets to direct canonicals (generator==plugin==check, byte-for-byte).

## §6 — Known non-blocking (do NOT block)
- SEO/BP Lighthouse staging-cap (noindex+HTTP) → M7/HTTPS carry-forward (team_00 accepted).
- Eyal-flag (non-blocking): `/תקנון`→`/` interim; build-workshops→`/lessons` proxy — post-cutover confirmation.
- The 28 omitted W2-07 QR images (separate team_40 recovery, already logged in W2-07).

## §7 — Deliverable
Verdict → `_COMMUNICATION/team_190/VERDICT-W2-09-L-GATE-VALIDATE-2026-05-31.md` (PASS / BLOCKED) with Verdict Box
+ Fresh-tree Proof (HEAD `4cad377`) + 8-check table + AC-01..06 live re-verify + mechanism-switch + AC-05-disposition assessment.
- On **PASS** → team_100 WP Closure Protocol (roadmap COMPLETE/LOD500_LOCKED via offline-fallback — re-probe API +
  confirm DB contains the WP first; team_191 archive; merge → main on team_00 go). **W2-09 is the FINAL Wave2
  content/cutover-prep WP — closing it completes the S002 Wave2 build (W2-01..09 all COMPLETE).**
- On **BLOCKED** → team_100 routes remediation to team_20.

*team_100 — 2026-05-31*
