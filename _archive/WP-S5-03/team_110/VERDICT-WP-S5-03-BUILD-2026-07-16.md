---
id: VERDICT-WP-S5-03-BUILD-2026-07-16
from_team: team_110
to_team: team_00
cc: [team_100, team_90]
date: 2026-07-16
type: build-verify-result
wp: WP-S5-03
milestone: S005
gate: L-GATE_BUILD
next_wp: WP-S5-05
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-03-LOD400-2026-07-16.md
mandate_ref: _COMMUNICATION/team_110/MANDATE_S005_TEAM110_EXECUTION_v1.0.0.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-03/
builder_engine: claude-opus-4-8 (Claude Code, Anthropic)
builder_team: team_110
staging_base: http://eyalamit-co-il-2026.s887.upress.link
result: PASS_WITH_FINDINGS
---

# Builder result — WP-S5-03 (Legacy/301 completeness)

## Summary

**`PASS_WITH_FINDINGS` — AC-3..AC-7 met · 0 blockers · 0 major · 3 minor (all builder-raised).**

**The headline: the `/Blog/` catch-all was silently dropping 4 real, live posts of Eyal's.** A prefix
rewrite cannot follow a **rename**, and the regex ran *before* the exact map and `exit()`ed — so an exact
decision for a renamed post was **unreachable**. Every such post was 301'd into a 404. All 4 are now
reachable, single-hop.

| AC | Requirement | Result |
|----|---|---|
| **AC-3** | 400/400 triaged; Patterns A+B via SSoT+regeneration; gap sample = 301 single-hop → 200 | **PASS** — **368/368** unique paths (from **406** raw rows, see F-01); A+B+extended applied via SSoT; all sampled gaps 301→200 |
| **AC-4** | 54 blog slugs fold-or-drop with per-slug rationale | **PASS** — 105 `/Blog/` URLs (the authoritative count): **4 FOLD** (real posts, exact decisions) · 27 KEEP (catch-all already correct) · 74 DROP (feeds/tags/attachments/theme-demo), each with a reason |
| **AC-5** | orphans → 410 live | **PASS** — 11 orphan media pages now `410` + `X-EA-Redirect: w209-410` |
| **AC-6** | out-of-scope marked → WP-S5-05 §7 | **PASS** — www/scheme + orphaned-destination marked, not verified here (by design) |
| **AC-7** | hazards flagged; SSoT is the only source | **PASS** — `deploy_htaccess_301.py` marked **do-not-run**; mu-plugin never hand-edited |

Live rule counts: **301 32 → 47** · **410 2 → 13** (SSoT decisions **135 → 165**).

## The chain was honoured (spec §3.4) — no hand-edits

`hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` → `gen_htaccess_301_from_decisions.py` →
**both** targets regenerated (live mu-plugin + inert `.htaccess` mirror). `collides_canonical()` correctly
blocked 4 `/shop` collisions. `deploy_htaccess_301.py` was **not run** (nginx ignores `.htaccess` — it would
look like a deploy while changing nothing).

## Findings (all minor, all builder-raised)

### F-01 — the spec's own counting method drops 6 real URLs
Spec §1 says **400**; the mandate says **406**. **The mandate is right.** The 9 GSC files have **no trailing
newline**, so `tail -n +2 | wc -l` — the method behind the spec's table — **drops the last URL of every
file**. Six files, six URLs silently omitted from the triage denominator. Triaged **406 raw → 368 unique**.
**Ask:** correct §1's table.

### F-02 — the `/Blog/` catch-all still dead-ends the junk set (mechanism change, out of contract)
74 DROP-class `/Blog/` URLs still 301 → 404. Harmless to users; wasteful for crawl budget. Fixing means
tightening the regex to exclude `/feed/`, `/tag/`, `/page/` and numeric attachment ids — a **generator**
change beyond this WP's "add decisions + regenerate" contract. Options in
`evidence/s5-03/blog-54/AC-4-blog-fold-or-drop.txt`. **Not blocking; does not affect users.**

### F-03 — a live broken link on `/qr/qr2/` (found in passing; NOT this WP's scope)
`/qr/qr2/` carries **two** anchors to `/books/צבע-בכחול-וזרוק-לים/` → **404**; one is empty (also the axe
`link-name` violation from S5-06's baseline), the other is a **visible «לדף הספר>>» link a reader clicks**.
The correct target is `/books/tsva-bekahol/` (200). Bounded: **1 QR page, 2 anchors, 1 target**. It is a
**current internal link in the QR seed**, not a legacy GSC URL — so it is not S5-03 scope, not S5-06 (facade),
not S5-07 (NAP). Fix = edit the seed + reseed with a new `-once` flag. **Routed to team_100.** Eyal's readers
hit it today. Detail: `evidence/s5-03/OBSERVED-LIVE-BOOK-SLUGS.txt`.

## One deviation from the letter of the spec — declared

§3.4 forbids hand-editing the **artifact**; it prescribes "add decisions + regenerate". The 4 FOLD decisions
were **unreachable** through that path alone, because the emitted regex preceded `$map` and `exit()`ed. I
therefore made a **minimal change to the GENERATOR** (not the artifact): emit `$map` first, and have the
regex yield to it (`! isset( $map[$norm] ) && preg_match(...)`). Rationale pinned in-file. This is the only
way to express an exact decision for a `/Blog/` path, and AC-3 requires that no real legacy content be
dropped. **The artifact itself was never hand-edited.** Verified: 4 FOLD posts 301→200 single-hop;
un-decided slugs still ride the catch-all (2 hops → 200) — no regression.

## Environmental notes

Expired TLS / HTTP-only staging by design (`curl -k`); site-wide `noindex` host-conditional; transient
`curl 000`/**503** = shared-host throttling, re-probed serially throughout (the 368-URL triage and the
122-row `-L` re-follow were both fully serial, with a spaced retry on every 000/503).

## Iron Rule #1 attestation

| Role | Engine | Team |
|---|---|---|
| Builder | claude-opus-4-8 (Claude Code, Anthropic) | team_110 |
| Validator | composer-2.5 (Cursor) — **distinct vendor** | team_90 |
| Distinct vendors | **satisfied** | — |

## route_recommendation

**`L-GATE_BUILD` → team_90.** No blocker. WP-S5-05 not started.
