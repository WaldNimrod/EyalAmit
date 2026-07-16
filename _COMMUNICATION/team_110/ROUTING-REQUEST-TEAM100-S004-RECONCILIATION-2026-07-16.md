---
id: ROUTING-REQUEST-TEAM100-S004-RECONCILIATION-2026-07-16
from_team: team_110
to_team: team_100
cc: team_00
date: 2026-07-16
type: routing-request
milestone: S004 (reconciliation) → S005 (carry-forward)
wp: [WP-S4-01..08, WP-S5-07 (new)]
blocks: WP-S5-05
authorized_by: "team_00 (נמרוד) 2026-07-16 — «S004 - אם זה פתוח - סגירת המיילסטון היא טעות קשה» + ruling: «כן — רישום 7 + WP-S5-07»"
trigger: _COMMUNICATION/team_100/REGISTRATION-S005-WP-S5-01-02-2026-07-16.md §5.2 (team_100's own escalation)
---

# ROUTING REQUEST — team_100: reconcile S004 (7 register · 1 genuinely open → WP-S5-07)

## 0. The finding, stated plainly

team_100's own escalation (§5.2 of the S005 registration) flagged that **all 8 S004 WPs sit at
`IN_PROGRESS`** while the milestone reads COMPLETE. team_00 reacted sharply — *"אם זה פתוח - סגירת
המיילסטון היא טעות קשה"*. team_110 audited it. **The reality is a split, and it matters:**

- **7 of 8 are genuinely done** — built, cross-engine validated (Iron Rule #1), constitutionally gated.
  Their `IN_PROGRESS` is **pure bookkeeping drift** — `gate_history: 0` on all eight; nobody ever wrote the
  verdicts back into the fields. **Identical to the drift you just fixed on WP-S5-01/02.**
- **WP-S4-07 is genuinely OPEN.** Its own team_90 verdict mandates fixes that were never performed. Its
  `IN_PROGRESS` is **correct**. **There is nothing to "reopen" — it was never closed.**

**So the milestone closure was not the error.** The error is the roadmap note at **L62** asserting
*"8/8 WPs (WP-S4-01..08)"* complete. That single claim is false; everything else about S004 holds.

**team_00 ruling (2026-07-16):** register the 7 · carry S4-07's residual forward as **WP-S5-07** ·
correct the note. Explicitly **rejected**: a new milestone, and reopening S004 — both are heavy ceremony
for one WP's residual, and reopening would invalidate a team_190 constitutional GO that was issued
**correctly**. This follows the **S003-closure precedent already used in this project** (*"5 carried forward
as live work under the new S005 milestone"*), not a new invention.

## 1. Register these 7 → `COMPLETE` / `LOD500_LOCKED`

Same operation as WP-S5-01/02: advance `status` + `current_lean_gate` + `lod_status`, and append
`gate_history` from the **existing** verdicts (builder, validator, engine, findings, artifact path).

| WP | team_90 verdict | Flag | Note for gate_history |
|----|-----------------|------|------------------------|
| **WP-S4-01** | `VERDICT-WP-S4-01-BUILD-2026-07-15.md` | PASS_WITH_FINDINGS | AC-11 git-isolation FAIL is **process, not content** — verdict states *"not due to content defects"*; AC-2 = **0 missing public content units**. **See §4(a) — needs your ruling.** |
| **WP-S4-02** | `VERDICT-WP-S4-02-VERIFY-2026-07-15.md` | **PASS** | — |
| **WP-S4-03** | `VERDICT-WP-S4-03-CONTENT-QA-BROWSER-2026-07-15.md` | **PASS** | — |
| **WP-S4-04** | `VERDICT-WP-S4-04-BUILD-2026-07-15.md` | **PASS** | — |
| **WP-S4-05** | `VERDICT-WP-S4-05-BUILD-2026-07-15.md` | **PASS** | AC-EDIT (live wp-admin cycle) deferred → **already tracked as WP-S5-04**. Not a gap. |
| **WP-S4-06** | `VERDICT-WP-S4-06-BUILD-2026-07-15.md` | PASS_WITH_FINDINGS | F-01 = 1 `.ea-pending-approval` on `/method/` — a **carryover from S4-07**, not introduced here. **Closes automatically when WP-S5-07 lands.** |
| **WP-S4-08** | `_COMMUNICATION/team_190/VERDICT-S004-FINAL-CONTROL-2026-07-15.md` | PASS_WITH_FINDINGS **+ GO** | The constitutional gate (Iron Rule #5). Advance to `L-GATE_VALIDATE`. |

**The constitutional gate's own words** (team_190, WP-S4-08) — the basis for treating these as done:

> *"S004 staging, glow inventory, editability **mechanism**, cross-engine WP-S4-01..07 closure, hub deploy,
> CEO delivery package, and lead-capture render are **ready for Eyal review**. Residuals are **documented
> deferrals** … — **not delivery blockers**."*

Independently verified there: **32/32** routes HTTP 200 · **48/48** QR 200 · `hasAngleBrackets: false` on all
20 probed routes (no raw `⟨⟩` leaking) · 5 products temp-GI marked · anchor verbatim · hub live (1049 files,
metadata match) · CF7 + `wa.me` + `tel:` + GA4 present.

**Its deferrals are already tracked** — wp-admin edit cycle + CF7 end-to-end submit → **WP-S5-04**; Eyal
sign-offs → **M-EYAL-INPUTS**. Nothing is lost by registering.

## 2. WP-S4-07 → `SUPERSEDED`; residual → **new `WP-S5-07`**

`VERDICT-WP-S4-07-BUILD-2026-07-15.md` **route_recommendation, verbatim**:

> *"**Before L-GATE_BUILD closeout:** fix **AC-10** (NAP FAQ-03 ↔ footer) and **AC-6** gap (rebirthing FAQ
> glow); complete **AC-4** FAQ-03 Q3 + Q1 geo answer in seed."*

**Never done.** Re-verified live by team_110, 2026-07-16:

| Item | Verdict | team_110 live re-check (2026-07-16) |
|---|---|---|
| **AC-10 = FAIL** | NAP «עמל 8 ב'» + `052-482-2842` must be byte-identical FAQ ↔ footer | **CONFIRMED still open.** `block-footer-social.php` L64-65 renders only `<p class="ea-cfoot__loc">פרדס חנה · ישראל</p>` — **no address, no phone**. Live staging home: `052-482-2842` → **0 occurrences**; «עמל 8» → 1 (via schema, not footer). |
| **AC-6 gap** | `method-02` rebirthing has **no** `.ea-pending-approval` despite `[EYAL-SIGN-OFF]` in spec §3.2 | An **unmarked placeholder** — directly against team_00's standing policy (*"leave only clear placeholders"*). Also the source of S4-06's F-01. |
| **AC-4** | FAQ-03 Q3 (price) not seeded; Q1 geo answer missing | team_110's coarse grep found «עמל 8» ×1 and price strings in `ea-faq-seed.json` — **too coarse to confirm the specific rows**. **Verify per-AC before scoping.** |

### Requested: register `WP-S5-07`
- **label:** *"S004 residual — NAP consistency + FAQ-03 geo/price + rebirthing glow (from WP-S4-07)"*
- `milestone_ref: S005` · `blocked_by: []` · `next_wp: WP-S5-05` · `assigned_builder: team_10/110`
  · `assigned_validator: team_90 (cross-engine)` · `supersedes: WP-S4-07`
- **Add `WP-S5-07` to `WP-S5-05.blocked_by`.** Rationale: NAP/local-SEO and an unmarked placeholder are
  squarely inside team_00's delivery goal — *"להגיש לאייל את האתר הכי מדוייק שאפשר … ולהשאיר רק פליסהולדרים
  ברורים"*. It should not ship to Eyal unfixed.
- **WP-S4-07** → `status: SUPERSEDED`, `superseded_by: WP-S5-07`, `closure_note` citing this artifact +
  the verdict's route_recommendation. Do **not** mark it COMPLETE — the work genuinely was not done.
- **LOD400:** author to the S5-01/02/03 bar, then team_90 cross-engine validate. Scope is small and the
  verdict already names files/lines — but it carries **one real decision, §4(b)**.

## 3. Correct the false roadmap note (L62)

Current: *"**S004 «Final-Review Readiness» milestone COMPLETE** — 8/8 WPs (WP-S4-01..08) built …"*

**"8/8" is false.** Suggested correction — keep the (accurate) rest, fix the count and state the split:

> *"S004 «Final-Review Readiness» — **7/8 WPs COMPLETE** (WP-S4-01..06, 08), cross-engine validated +
> team_190 constitutional PASS_WITH_FINDINGS + GO (WP-S4-08): site ready for Eyal review, 32/32 routes 200,
> glow inventory clean. **WP-S4-07 was NOT completed** — its verdict mandated AC-10 (NAP FAQ↔footer) / AC-6
> (rebirthing glow) / AC-4 (FAQ-03) fixes before closeout, which were never performed; superseded by
> **WP-S5-07** under S005 (team_00 ruling 2026-07-16). Registration of the 7 was bookkeeping-only —
> `gate_history` had never been written back."*

## 4. Two rulings team_110 did NOT make

**(a) WP-S4-01's AC-11 (git isolation) — literally FAIL, never remediated.** The verdict recommended
*"commit/isolate WP-S4-01 on a clean branch containing only the defaults file before L-GATE_BUILD closeout"* —
also never done. It is a **process** AC (dirty working tree at validation time); the artifact has since been
committed, and the verdict is explicit that content was PASS with **0 missing public content units**. **Rule:**
accept as satisfied-in-substance (recommended — it describes a git hygiene state that no longer exists), or
record as a permanent process deviation on the WP. Either way it is **not** a reason to withhold registration.

**(b) ~~The NAP footer line is a business decision~~ — ✅ RESOLVED 2026-07-16, do NOT re-open.**
> team_00 ruled: *«אני לא יודע כמה פעמים כבר אישרתי את הכתובת והטלפון האלו. גם אייל אישר… זה המידע המדוייק.
> לא לשאול יותר שוב!!! לתקן בפוטר בהתאם ובכל מקום שצריך.»* — the NAP is **approved**; the footer **gets built**.
> Canon + exact byte forms + full normalization scope: **`_COMMUNICATION/team_110/DECISION-NAP-CANON-2026-07-16.md`**.
> A self-declared NAP SSoT already existed (`ea-w2-seo-schema.php` L6/L53) — nothing read from it, which is why
> 6 phone variants and 3 apostrophe variants accumulated and AC-10 was unsatisfiable. **This item is CLOSED.**
> Also found while establishing it: **`/qr/qr32/` renders a 9-digit WRONG phone live** (§3 of the decision record).

~~**(b-original) The NAP footer line is a business decision, not a build detail.**~~ AC-10 requires the address + phone to
appear byte-identically in the footer and FAQ-03. Putting **«עמל 8 ב'» + `052-482-2842` into the site-wide
footer** is Eyal's call (public display of his business address/phone), not team_110's or team_100's. The
verdict defers to *"decide D1 NAP footer line per BN-01 recommendation"*. **This decision must be resolved
(team_00/Eyal) before or inside WP-S5-07's LOD400** — otherwise the WP cannot close, because AC-10 is
unsatisfiable without it. Flagging early so it does not become a late cutover blocker.

## 5. Not requested here

- WP-S5-03 (handoff ready) · WP-S5-06 (registered; LOD400 pending — your §5.1).
- Iron Rule #15 archival (your §5.3) — standing spoke-wide gap, team_191 at team_00's discretion.
- WP-S5-05 stays BLOCKED; `blocked_by` should now read
  `[WP-S5-01, WP-S5-02, WP-S5-03, WP-S5-04, WP-S5-06, WP-S5-07, M-EYAL-INPUTS]`.
