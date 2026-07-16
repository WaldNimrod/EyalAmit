---
id: MANDATE-TEAM90-WP-S5-03-BUILD-2026-07-16
from_team: team_00
authored_by: team_110 (under ADR045 execution_authority: full)
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
wp: WP-S5-03
milestone: S005
gate: L-GATE_BUILD
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-03-LOD400-2026-07-16.md
target_execution: _COMMUNICATION/team_110/VERDICT-WP-S5-03-BUILD-2026-07-16.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-03/
staging_base: http://eyalamit-co-il-2026.s887.upress.link
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S5-03-BUILD-2026-07-16.md
---

# MANDATE — team_90 cross-engine validation: WP-S5-03 (legacy/301 completeness, L-GATE_BUILD)

You are the cross-engine validator (`composer-2.5`, non-Claude). WP-S5-03 completes the 301 coverage of the
legacy URL set before cutover. **Independently reproduce each AC from the SSoT + generator + live staging +
the evidence — do not merely re-read the builder's report.**

## Sources of truth
| What | Path |
|---|---|
| Spec (cycle-3 clean PASS) | `_COMMUNICATION/team_100/S005/WP-S5-03-LOD400-2026-07-16.md` |
| Builder result + findings | `_COMMUNICATION/team_110/VERDICT-WP-S5-03-BUILD-2026-07-16.md` |
| Evidence (incl. `SUMMARY.txt`) | `_COMMUNICATION/team_110/evidence/s5-03/` |
| SSoT | `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` |
| Generator | `scripts/gen_htaccess_301_from_decisions.py` |
| Live artifact | `site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php` |

## Checks — reproduce each, cite concrete evidence

1. **AC-3 triage.** `evidence/s5-03/triage-400/triage.csv` must classify **every** URL, one row per unique
   normalised path. Confirm the count yourself from the 9 GSC files. **Read F-01 first** — the builder claims
   the real row count is **406** (not the spec's 400) because the files have **no trailing newline**, so a
   line-counter drops each file's last URL. **Verify this independently**; if true, the spec's §1 table is wrong.
2. **AC-3 Patterns.** Confirm Pattern A (2nd prefix), the **3rd prefix `/פרדס-חנה/`** (not named in the spec —
   verify it is real and correctly mirrored), and Pattern B (`/shop/books/*`) exist as **decisions in the SSoT
   JSON** and appear in the **regenerated** artifact. Confirm the mu-plugin was **NOT hand-edited** (it must be
   reproducible: re-run `python3 scripts/gen_htaccess_301_from_decisions.py` and diff — it should be stable).
3. **AC-3 live.** Sample the gap set: each must be **301 single-hop → 200**. Note `/shop/books/*` targets are
   the **LATIN** slugs (`/books/tsva-bekahol/` etc., verified 200); the hebrew-slug variants **404**.
4. **AC-4 fold-or-drop.** 🔴 **The core finding.** Verify the builder's claim that the `/Blog/` catch-all was
   **dropping real content**: the regex ran before `$map` and `exit()`ed, so an exact `/Blog/<slug>` decision
   was unreachable, and a **renamed** post got 301'd into a 404. Verify the **4 FOLD posts** are real and live
   (check the TITLE, not just slug similarity), that each is now **301 single-hop → 200**, and that
   **un-decided `/Blog/` slugs still ride the catch-all** (2 hops → 200, no regression). Then judge the DROP
   set's per-slug rationale (feeds/tags/attachments/`portfolio_page` theme-demo).
5. **AC-5.** Orphans return **410** live with `X-EA-Redirect: w209-410`.
6. **AC-6.** www/scheme + orphaned-destination marked `out-of-staging-scope` → WP-S5-05 §7. **The spec does
   NOT require staging verification for these — do not FAIL on their absence.**
7. **AC-7.** `deploy_htaccess_301.py` marked **do-not-run** (it uploads `.htaccess`, which nginx **ignores** —
   it would look like a deploy while changing nothing). SSoT documented as the single live source.

## 🔴 Adjudicate the declared deviation

The builder changed the **GENERATOR** (not the artifact): `$map` is now emitted **before** the `/Blog/` regex,
and the regex yields to it. §3.4 forbids hand-editing the **artifact** and prescribes "add decisions +
regenerate" — but the 4 FOLD decisions were **unreachable** through that path alone, and AC-3 requires that no
real legacy content be dropped. **Rule on whether this is a legitimate SSoT-first fix or an out-of-contract
mechanism change.** Verify the artifact itself was never hand-edited.

## Guardrails — DO NOT flag these as defects
- **Expired TLS / HTTP-only staging; site-wide `noindex`** — by design, host-conditional. `curl -k`.
- 🔴 **Transient `curl 000` / `503`** — the shared uPress host throttles. Measured: batches return 503, the
  same routes return 200 **serially**. **This WP's evidence is a 368-URL triage + a 122-row `-L` re-follow,
  both fully serial with spaced retries.** If you re-probe in parallel you WILL get false failures. **Probe
  serially.**
- **Single-hop vs `-L`.** The site has a legitimate **2-hop** chain (`/Blog/x` → `/blog/x` → `/x`). A one-hop
  probe under-reports it as a failure — the builder's first pass made exactly this mistake and corrected it.
  Use `curl -L` for chain-end status.
- **The 128 `/feed/` 404s** under the covered prefix are **junk** (attachment RSS), matching the spec's own
  severity call. Not lost content.
- **`portfolio_page/*`** — purchased-theme **demo content** (Stockholm fashion, Der Spiegel cover art). Not
  Eyal's. Correctly dropped.
- **The DROP set still 301→404** — F-02, a mechanism change out of contract. Not blocking.
- **`/qr/qr2/`'s broken book link** — F-03, out of this WP's scope (a current internal seed link, not a legacy
  GSC URL). Routed to team_100.
- **`/qr/` prod 302 · Check-32 · prod-only §6 items** — out of scope.

## Required output
`_COMMUNICATION/team_90/VERDICT-WP-S5-03-BUILD-2026-07-16.md` — frontmatter mirroring the S5-06/07 verdicts ·
`## Verdict flag` · `## Iron Rule #1` · `## Per-item results` (per check, citing URL + code `file:line` + the
value **you** observed) · `## F-01/F-02/F-03 + deviation adjudication` · `## route_recommendation`.

**Do not** open WP-S5-05.
