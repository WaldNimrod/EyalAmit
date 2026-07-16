---
id: VERDICT-WP-S5-03-VALIDATE-2026-07-16
from_team: team_90
to_team: team_00
cc: [team_100, team_110]
date: 2026-07-16
type: cross-engine-validation-result
wp: WP-S5-03
milestone: S005
gate: L-GATE_VALIDATE
mandate_ref: MANDATE-TEAM90-WP-S5-03-VALIDATE-2026-07-16
build_gate_verdict: _COMMUNICATION/team_90/VERDICT-WP-S5-03-BUILD-2026-07-16.md
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-03-LOD400-2026-07-16.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-03/
staging_base: http://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — WP-S5-03 L-GATE_VALIDATE (team_90 constitutional gate)

## Verdict flag

**PASS**

Constitutional gate satisfied. L-GATE_BUILD `PASS_WITH_FINDINGS` accepted without re-running the AC battery. Scope is honest; SSoT-first chain intact; no real Eyal writing silently dropped; findings F-01..F-03 dispositioned and routed; §6 prod-only items explicitly deferred; Iron Rule #1 intact. WP-S5-03 may be locked at LOD500 and archived.

---

## Iron Rule #1

| Role | Engine | Team |
|------|--------|------|
| Builder | claude-opus-4-8 (Claude Code, Anthropic) | team_110 |
| Constitutional validator | composer-2.5 (Cursor) | team_90 |
| Distinct vendors | **satisfied** | |

team_110 did **not** self-validate at L-GATE_BUILD or L-GATE_VALIDATE. Builder verdict: `_COMMUNICATION/team_110/VERDICT-WP-S5-03-BUILD-2026-07-16.md`. Independent BUILD verdict: `_COMMUNICATION/team_90/VERDICT-WP-S5-03-BUILD-2026-07-16.md`.

---

## Per-item results

| # | Check | Result | Judgment (evidence-by-path) |
|---|-------|--------|-----------------------------|
| **1** | **Scope honesty** | **PASS** | `git diff --stat` (2026-07-16): exactly five application deltas — `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` (+362), `scripts/gen_htaccess_301_from_decisions.py` (+24), `site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php` (+61, regenerated), `_COMMUNICATION/team_100/tools/htaccess_301_block.txt` (+30, inert mirror), `_COMMUNICATION/team_110/evidence/s5-03/OBSERVED-LIVE-BOOK-SLUGS.txt` (evidence append). Untracked paths are evidence + verdict artifacts only (`triage-400/`, `blog-54/`, `410/`, `patterns/`, `SUMMARY.txt`, `DEPLOY-MANIFEST.txt`). **No unrelated code.** Spot-check: `python3 scripts/gen_htaccess_301_from_decisions.py` → **zero diff** on mu-plugin (47×301 + 13×410). **No hand-edit** of the artifact. |
| **2** | **SSoT-first integrity** | **PASS** | SSoT `total_items`: **135 → 165** (`hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` L8/L17); 30 new entries tagged WP-S5-03 in `decided_note`. Patterns A (2nd + 3rd legacy prefixes), B (`/shop/books/*` → `/books/<latin-slug>`), §4 FOLD (4 `/Blog/<slug>` renames), §5 orphans (11×410) all trace to JSON decisions. Generator emits `$map` before `/Blog/` regex (`scripts/gen_htaccess_301_from_decisions.py` L324–343); artifact mirrors L91–110. `collides_canonical()` still guards (`scripts/gen_htaccess_301_from_decisions.py` L113, L169) — 4 `/shop/*` collisions dropped at emit. Inert `.htaccess` mirror regenerated in same run (`_COMMUNICATION/team_100/tools/htaccess_301_block.txt`). |
| **3** | **No real legacy content dropped** | **PASS** | **The question that matters:** among DROP-class `/Blog/` URLs, is anything plausibly Eyal's writing? **No.** Builder + BUILD-gate live probes accepted: **4 FOLD** renamed posts now single-hop 301→200 with title match (`_COMMUNICATION/team_110/evidence/s5-03/blog-54/AC-4-fold-verified.txt`, `SUMMARY.txt` L36–49). **27 KEEP** — including `הטור של אייל עמית` series — reach 200 via legitimate 2-hop catch-all (`AC-4-fold-verified.txt` L7–9; L-GATE_BUILD AC-4 regression rows). **74 DROP** decompose to feeds (33), `portfolio_page/*` theme-demo (12), tag archives (7), attachment/orphan ids (remainder) — not article permalinks (`SUMMARY.txt` L51–57; `blog-54/AC-4-blog-fold-or-drop.txt`). Note: `AC-4-blog-fold-or-drop.txt` L13 lists `/Blog/23-הטור…` under a DROP *category header* as an illustrative path shape; live classification is **KEEP** (chain=200). Ledger authoritative count: 105 `/Blog/` URLs = 4 FOLD + 27 KEEP + 74 DROP. Residual 301→404 on DROP set is F-02 (routed), not silent content loss. |
| **4** | **Findings dispositioned** | **PASS** | **F-01** — spec §1 table claims 400; authoritative raw count is **406** (9 GSC files lack trailing newline; `tail \| wc -l` drops last row per file). **Recorded against SPEC**, not builder. Route: team_100 correct §1 + AC-3 denominator language (unique paths from 406 raw → 368 triaged). **F-02** — DROP `/Blog/` junk still 301→404 via catch-all; mechanism change outside §3.4 contract. **Routed** to team_100 (optional regex tightening in generator); not swallowed. **F-03** — `/qr/qr2/` broken book link (Hebrew slug → 404; correct target `/books/tsva-bekahol/`). Out of WP-S5-03 scope. **Routed** to team_100 per `OBSERVED-LIVE-BOOK-SLUGS.txt` + builder verdict §F-03. Generator-order deviation (map before regex) adjudicated **legitimate** at L-GATE_BUILD — honours AC-3 "no real legacy content dropped" without artifact hand-edit. |
| **5** | **§6 out-of-scope honesty** | **PASS** (doc nit) | Spec §6: www/scheme canonicalization + orphaned-destination (redirect target itself 404) → WP-S5-05 §7; **no staging verification required**. `SUMMARY.txt` L59–61 and `DEPLOY-MANIFEST.txt` L16–18 mark both explicitly. Triage: **14** rows carry `https://www.eyalamit.co.il` source URLs; **95** `needs-content-check` (orphaned-destination chains). Literal verdict string `out-of-staging-scope` appears **0** times in `triage-400/triage.csv` — documentation gap only (same nit recorded at L-GATE_BUILD AC-6). Items are **marked and deferred**, not quietly dropped. |
| **6** | **Iron Rule #1** | **PASS** | Anthropic builder (team_110, Claude Code) ≠ Cursor validator (team_90, composer-2.5). team_110 issued builder verdict only; team_90 owns both L-GATE_BUILD and L-GATE_VALIDATE cross-engine results. |
| **7** | **LOD500 readiness + delivery criterion** | **PASS** | WP adds **no placeholders**. Deliverable is a complete, regenerated redirect surface: SSoT JSON (165 decisions) → generator → live mu-plugin + inert mirror, with full triage evidence (`368/368` classified). Legacy surface is **honest for cutover**: real renamed posts rescued (4 FOLD), working posts preserved (27 KEEP), junk classified (74 DROP), orphans gone (11×410), patterns A+B live. Residuals (F-02 crawl-budget waste, F-03 QR seed link, §6 prod-only review) are **explicitly routed** — not hidden debt. `deploy_htaccess_301.py` flagged do-not-run (AC-7). Aligns with roadmap delivery criterion: leave only clear, documented follow-ups (WP-S5-05 §7, team_100 spec/QR fixes). |

---

## LOD500 readiness

| Question | Answer |
|----------|--------|
| Ready for LOD500 lock? | **Yes** |
| May WP-S5-03 be archived? | **Yes** |
| Blockers | **None** |
| Non-blocking follow-ups (routed, not gate-blocking) | F-01 → team_100 (spec §1 count); F-02 → team_100 (optional regex); F-03 → team_100 (QR seed); §6 prod items → WP-S5-05 §7 (do **not** open WP-S5-05 until team_00 routes cutover) |

---

## route_recommendation

**`L-GATE_VALIDATE PASS — WP-S5-03 may be locked LOD500 and archived`**

Do **not** open WP-S5-05 until team_00 routes production cutover.
