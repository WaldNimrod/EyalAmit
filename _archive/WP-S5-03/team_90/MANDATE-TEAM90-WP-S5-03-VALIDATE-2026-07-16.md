---
id: MANDATE-TEAM90-WP-S5-03-VALIDATE-2026-07-16
from_team: team_00
authored_by: team_110 (under ADR045 execution_authority: full)
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
wp: WP-S5-03
milestone: S005
gate: L-GATE_VALIDATE
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-03-LOD400-2026-07-16.md
build_gate_verdict: _COMMUNICATION/team_90/VERDICT-WP-S5-03-BUILD-2026-07-16.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-03/
staging_base: http://eyalamit-co-il-2026.s887.upress.link
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S5-03-VALIDATE-2026-07-16.md
---

# MANDATE — team_90 L-GATE_VALIDATE: WP-S5-03

You already issued **`L-GATE_BUILD PASS`** — the ACs are settled. **Do not re-run the AC battery.**
This is the constitutional gate: *may WP-S5-03 be locked at LOD500 and archived?* You own it per team_00's
ruling 2026-07-16 (ADR045 R3.2 / Iron Rule #5 still name the dissolved team_190; GCR filed).

## Checks — judge, don't re-measure

1. **Scope honesty.** `git diff --stat`: the change set must be the SSoT JSON, the generator, the two
   regenerated artifacts, and evidence — nothing else. **No hand-edit of the mu-plugin** (you already proved
   regeneration is a zero-diff).
2. **SSoT-first integrity.** Every new rule traces to a decision in
   `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` (135 → 165, `total_items` updated), and both
   targets regenerate from it. The inert `.htaccess` mirror stayed in sync. `collides_canonical()` still guards.
3. **No real legacy content dropped (AC-3's core promise).** The 4 FOLD posts are live and reachable
   single-hop. Judge the DROP set honestly: is anything in it plausibly Eyal's content rather than
   feeds/tags/attachments/theme-demo? **This is the question that matters most** — a wrong DROP silently loses
   his writing after cutover.
4. **Findings dispositioned, not buried.** F-01 (the spec's count is wrong — 406, not 400, because the files
   lack a trailing newline) must be recorded against the SPEC. F-02 (residual 301→404 for the junk set) and
   F-03 (the live broken `/qr/qr2/` book link) must be routed, not swallowed.
5. **§6 out-of-scope honesty.** www/scheme + orphaned-destination are marked and deferred to WP-S5-05 §7 —
   **the spec does not require staging verification for them.** Confirm they are marked, not quietly dropped.
6. **Iron Rule #1** intact; team_110 self-validated at neither gate.
7. **LOD500 readiness + delivery criterion** (roadmap L2569 — «…ולהשאיר רק פליסהולדרים ברורים»). This WP adds
   no placeholder. Does it leave the legacy surface honest for cutover?

## Guardrails — DO NOT flag these as defects
- **Expired TLS / HTTP-only staging; site-wide `noindex`** — by design.
- 🔴 **Transient `curl 000` / `503`** — shared-host throttling; probe **serially**.
- **2-hop chains are legitimate** (`/Blog/x` → `/blog/x` → `/x`); use `curl -L`.
- **128 `/feed/` 404s** = attachment RSS junk; **`portfolio_page/*`** = purchased-theme demo content.
- **The DROP set still 301→404** — F-02, a mechanism change out of contract.
- **F-03** — out of this WP's scope; routed to team_100.
- **Stale `follow=404` rows in triage.csv** for the 4 FOLD posts — that snapshot predates the fix deploy; the
  live probes supersede it (you already confirmed this at L-GATE_BUILD).
- **`/qr/` prod 302 · Check-32 · §6 prod-only items** — out of scope.

## Required output
`_COMMUNICATION/team_90/VERDICT-WP-S5-03-VALIDATE-2026-07-16.md` — `## Verdict flag` · `## Iron Rule #1` ·
`## Per-item results` (checks 1-7) · `## LOD500 readiness` (explicit yes/no + may it be archived) ·
`## route_recommendation` (if PASS: `L-GATE_VALIDATE PASS — WP-S5-03 may be locked LOD500 and archived`).

**Do not** open WP-S5-05.
