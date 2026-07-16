---
id: MANDATE-TEAM90-WP-S5-07-VALIDATE-2026-07-16
from_team: team_00
authored_by: team_110 (under ADR045 execution_authority: full)
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
wp: WP-S5-07
milestone: S005
gate: L-GATE_VALIDATE
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-07-LOD400-2026-07-16.md
target_execution: _COMMUNICATION/team_110/VERDICT-WP-S5-07-BUILD-2026-07-16.md
build_gate_verdict: _COMMUNICATION/team_90/VERDICT-WP-S5-07-BUILD-2026-07-16.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-07/
staging_base: http://eyalamit-co-il-2026.s887.upress.link
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S5-07-VALIDATE-2026-07-16.md
---

# MANDATE — team_90 L-GATE_VALIDATE: WP-S5-07

You already issued **`L-GATE_BUILD PASS`** (`VERDICT-WP-S5-07-BUILD-2026-07-16.md`) — the ACs are reproduced and
settled. **Do not re-run the AC battery.**

**L-GATE_VALIDATE is the constitutional gate:** *may this WP be locked at LOD500 and archived?* You own it per
team_00's ruling of 2026-07-16 («team_90 הוא הוולידטור»); ADR045 R3.2 / Iron Rule #5 still name the **dissolved**
team_190 (GCR filed). **Rule on the WP, not on the drift.**

## The question

**Is WP-S5-07 constitutionally closeable — scope-honest, evidence-complete, governance-clean, and safe to feed
the WP-S5-05 cutover gate?**

## Checks — judge, don't re-measure

1. **Scope honesty — STOP-level.** `git diff --stat` on the branch must show **exactly** the §1 file set (11
   deployed + 1 local harness) and nothing else. **`ea-testimonials-fb.json` and `wave2-stage-b.php` must be
   untouched.** Flag any file outside §1; equally flag anything in §4 not done.
2. **The root cause is closed in CODE, not just in a document (§2 / §5.1).** `ea_nap()` exists as the one
   source; `ea-w2-seo-schema.php` — the former "declarative but unreadable" SSoT — is now a **consumer** like
   every other surface; `nap_canon_check.mjs` enforces what `ea_nap()` cannot reach (JSON/HTML seeds can't call
   PHP). Judge whether a future divergence is now **impossible-by-construction** rather than merely forbidden.
   If it is not, this WP has not actually closed WP-S4-07's residual — it has only moved it.
3. **The dead-code trap stayed shut.** `ea-cfoot` = 0 on all 4 routes: `block-footer-social.php` remains dead and
   **no second hardcoded NAP copy** was added to it "for safety". That would have been the exact drift pattern
   §2 exists to end.
4. **Ratified decisions honoured, not quietly re-litigated:** §4.C both L87+L88 · §4.D token-targeted (brand word
   `דיג׳רידו` intact) · §5.2 EN international form · §5.3 testimonials untouched · §5.4 brand word out of scope ·
   §4.G allow-list **still exactly 2 keys**.
5. **Findings dispositioned honestly, not buried.** F-01 is a defect **against the spec** — it must be recorded
   as such (the spec's §4.G code self-disarms; it survived two clean cycles because it was reviewed, never
   executed). F-02 must not be used to silently lower AC-8's bar. Judge whether "PASS on intent" is honest here.
6. **Iron Rule #1 chain intact** at both gates; team_110 never self-validated.
7. **team_00's delivery criterion** (`_aos/roadmap.yaml` L2569): «להגיש לאייל את האתר הכי מדוייק שאפשר … ולהשאיר
   רק פליסהולדרים ברורים». Does this WP leave any **undisclosed** placeholder? Note it deliberately **adds** a
   marked one (`method-02`'s glow — a *disclosed* [EYAL-SIGN-OFF] marker, which is compliant, not a gap).
8. **LOD500 readiness.** `status: COMPLETE` + `lod_status: LOD500_LOCKED` + `current_lean_gate: L-GATE_VALIDATE`
   about to be written to `_aos/roadmap.yaml` **via the FILE path** (ADR034 R9/R10/R12 + T-1 ruling — the l0
   endpoint serves an S002 payload with zero `WP-S5-*` rows; server build 2026-07-12 predates the fix). Confirm
   this is a **ruled** R8/R9 invocation, not a silent fallback.

## Guardrails — DO NOT flag these as defects

- 🔴 **Substring:** `052-482284` ⊂ `052-4822842` — use lookarounds; naive grep reports 6 files, there is 1.
- **Expired TLS / HTTP-only staging; site-wide `noindex`** — by design, host-conditional.
- **Transient `curl 000` / `503`** — throttling; re-probe serially.
- **Drop-ins are single-fire** — a second load is a no-op **by design**.
- **`esc_html()` renders `'` as `&#039;`** — compare decoded text; removing it would be a security regression.
- **`.foot__disc` contrast 3.48** — pre-existing, site-wide, already routed to a hygiene WP via S5-06 F-01.
- **`.ea-pending-approval` = 12 not 11** — `method-02` renders twice; AC-5's threshold is ≥10.
- **`ea-testimonials-fb.json` reason-vs-conclusion** — the DECISION's stated reason is wrong, the exclusion is
  right. Do not invert it.
- **`דיג'רידו` site-wide inconsistency; `privacy/accessibility-defaults` not refactored; `wave2-stage-b.php`
  comment** — all ratified §5.1/§5.4 as out of scope.

## Required output

Write `_COMMUNICATION/team_90/VERDICT-WP-S5-07-VALIDATE-2026-07-16.md`:
- Frontmatter mirroring the S5-01/02/06 verdicts.
- `## Verdict flag` · `## Iron Rule #1` · `## Per-item results` (checks 1-8, citing what you inspected)
- `## LOD500 readiness` — explicit yes/no + may it be archived
- `## route_recommendation` — if PASS: `L-GATE_VALIDATE PASS — WP-S5-07 may be locked LOD500 and archived`

**Do not** open WP-S5-05. **Do not** re-open the NAP.
