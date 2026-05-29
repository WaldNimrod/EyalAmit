---
id: MANDATE-TEAM190-W2-08-L-GATE-VALIDATE-2026-05-29
from_team: team_100 (Chief System Architect)
to_team: team_190 (Final Validator — constitutional, IR#5)
wp: WP-W2-08 — English Landing Page (/en)
date: 2026-05-29
gate: L-GATE_VALIDATE
build_commit: 5ac435b
branch: feature/w2-08-en
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-08
staging: http://eyalamit-co-il-2026.s887.upress.link
status: ISSUED
---

# L-GATE_VALIDATE Mandate — WP-W2-08 (/en)

## §0 — Engine (IR#1)
team_190 MUST run on **native Codex / OpenAI / GPT-5** (≠ Claude builder, ≠ team_50). Confirm engine line 1.

## §0.1 — Worktree
`/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-08` (branch `feature/w2-08-en`). Shared tree on main — do NOT validate there.

## §1 — Prior gate state
- **L-GATE_BUILD:** _(team_50, non-Claude — run ONLY after team_50 PASS/PWF, no P0/P1.)_
  Verdict: `_COMMUNICATION/team_50/VERDICT-W2-08-L-GATE-BUILD-2026-05-29.md`.
- **team_100 pre-gate live check:** `/en` 200 (`lang=en dir=ltr`); 6 data-blocks + single H1; hreflang
  reciprocal on BOTH `/en` and HE `/`; CTA → `/contact?lang=en`; validate 30 PASS / 0 FAIL.

## §2 — Proof-of-HEAD
- `rev-parse HEAD` → **`5ac435b`**; base main @ `37921fb`. Deployed `style.css` = **1.4.6**. CACHE-BUST all HTTP.

## §3 — Scope (LOD400 AC-01..05, independent live re-verify)
- **AC-01:** `/en` → 200, `lang="en"`.
- **AC-02:** 6 sections (hero · about · method · services · books · testimonials) present + **verbatim** vs
  `_COMMUNICATION/team_30/W2-08-EN-CONTENT-2026-05-28.md` (NO builder-authored/translated copy); single H1
  (hero tagline); 8 named testimonials present.
- **AC-03 (key):** hreflang B03 — `/en` emits en + he(→`/`) + x-default(→`/`); **HE homepage `/` emits the
  reciprocal `hreflang=en`→`/en/`**. Verify BOTH heads independently (curl).
- **AC-04:** CTA → `/contact?lang=en` (never `#`).
- **AC-05:** `validate_aos.sh` 0 FAIL; mobile responsive (LTR); D-14 tokens only (no raw hex in w2-08 CSS).

## §4 — Known non-blocking (do NOT block)
- page-id-25 carries a stray `ea-blog-archive-view` body class from another WP's body_class filter matching
  the page id — cosmetic only (W2-08 CSS scoped to `.ea-en-landing`); candidate for a later cross-WP
  body_class-scoping follow-up. Not a W2-08 AC.
- Hero uses the authentic theme portrait asset (new-site uploads lacked a portrait/studio shot) — no stock.

## §5 — Deliverable
Verdict → `_COMMUNICATION/team_190/VERDICT-W2-08-L-GATE-VALIDATE-2026-05-29.md` (PASS / BLOCKED) with
Verdict Box + Fresh-tree Proof (HEAD `5ac435b`) + 8-check table + AC-01..05 live + hreflang both-directions evidence.
- On **PASS** → team_100 WP Closure Protocol (roadmap COMPLETE/LOD500_LOCKED via offline-fallback — re-probe
  API + confirm DB actually contains the WP before any API-only switch, per the W2-07 finding; team_191
  archive; merge → main on team_00 go), then re-handoff to **WP-W2-09** (final pre-cutover; depends W2-01..08).
- On **BLOCKED** → team_100 routes remediation to team_10.

*team_100 — 2026-05-29*
