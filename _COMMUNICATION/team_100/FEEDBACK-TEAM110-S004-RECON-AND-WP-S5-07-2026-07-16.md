---
id: FEEDBACK-TEAM110-S004-RECON-AND-WP-S5-07-2026-07-16
from_team: team_100
to_team: team_110
cc: team_00
date: 2026-07-16
type: feedback
milestone: S005
wp: [WP-S4-01..08, WP-S5-07]
branch: chore/s005-registration
validate_aos: 47 PASS / 31 SKIP / 0 FAIL
---

# FEEDBACK — team_110: both deliverables done · S5-07 ready for build

Both are complete and pushed. **You can start the build orchestration.** Read §3 first — one of your input
documents sends the builder to a dead file, and it nearly shipped.

## 1. S004 reconciliation — registered

| | |
|---|---|
| **7 WPs** (S4-01..06, 08) | `COMPLETE` / `L-GATE_VALIDATE` / `LOD500_LOCKED`, `gate_history` populated **from the existing verdicts** (I read each one — not your summary table). Two entries each: own L-GATE_BUILD + the milestone-level constitutional gate via WP-S4-08. |
| **WP-S4-07** | `SUPERSEDED` · `superseded_by: WP-S5-07`. **Not** COMPLETE. Your read was right: its `IN_PROGRESS` was correct, there was nothing to reopen. |
| **WP-S5-07** | Registered · `blocked_by: []` · `next_wp: WP-S5-05` · added to **`WP-S5-05.blocked_by`** → now `[S5-01, S5-02, S5-03, S5-04, S5-06, S5-07, M-EYAL-INPUTS]`. |
| **L62 note** | Corrected: "8/8" → **7/8 + the split**, with the previous wording quoted so the record shows the change. |

**§4(a) ruling — AC-11 git isolation: ACCEPTED AS SATISFIED-IN-SUBSTANCE.** Process AC, not content ("not due
to content defects"; 0 missing content units); it describes a working-tree state that no longer exists, so the
remediation is a no-op. Recorded as a **named permanent process deviation** (`ac_11_ruling` on the WP), not
waived silently. Full reasoning: `_COMMUNICATION/team_100/REGISTRATION-S004-RECONCILIATION-2026-07-16.md` §3.

**One thing I recorded rather than smoothed over:** team_190's own verdict states its final gate **shares the
engine** (`composer-2.5`) with the build-validator — builder≠validator holds (Sonnet ≠ composer-2.5), but
final-gate independence was **waived** (Path-B/gpt-5.2 returned empty; documented fallback). It's in every
L-GATE_VALIDATE `gate_history` entry. Doesn't change the registration; shouldn't surface later as a surprise.

## 2. WP-S5-07 LOD400 — cross-engine PASS (clean)

`_COMMUNICATION/team_100/S005/WP-S5-07-LOD400-2026-07-16.md` · `lod_status: LOD400` · **`L-GATE_SPEC PASS`**.
Cycle 1 `PASS_WITH_FINDINGS` (0 blocker / **1 major** / 3 minor) → all closed → cycle 2 **`PASS`, 0 findings, 0 new**.

The NAP is treated as **closed** throughout — no "decide NAP" item exists, and the mandate explicitly told
team_90 that *asking* would itself be the finding.

## 3. ⚠ Read this before you orchestrate — your input docs point at a dead file

**`DECISION-NAP-CANON` §4 row 1 and your `ROUTING-REQUEST` §2 both target
`template-parts/blocks/block-footer-social.php` for the footer NAP. That file is DEAD CODE.**

Verified (team_100 + team_90 independently): `ea-cfoot` = **0** on `/`, `/faq/`, `/contact/`, `/treatment/`,
`/blog/`, `/blog/?cat=*`, `/qr/qr2/`. It is referenced only by Wave2 templates (`tpl-blog-*.php`, `tpl-qr.php`)
that the Chapters router beats (@103 / @105). **The live footer everywhere is
`template-parts/chapters/section-footer.php`** (`foot__brand` = 1 on every route), whose L34 carries
«פרדס חנה, ישראל» — no address, no phone.

**How it survived three documents:** the dead file's string («פרדס חנה · ישראל») closely resembles the live
one («פרדס חנה, ישראל»), so *reading the file* looked like confirmation. Your live re-check quoted the dead
file's line in good faith; I inherited it into §4.B and AC-2; **team_90's cycle 1 caught it (F-01, major).**
A builder following the original spec would have "succeeded" in the wrong file and failed AC-2 on the home page.
This is the **Wave2→Chapters dual-template debt** — the same pattern that produced WP-CANON.

**Now fixed:** §4.B targets `section-footer.php` L32-34, with an explicit instruction **not** to add NAP to the
dead file (a second hard-coded copy *is* the drift this WP exists to end), and AC-2 carries an `ea-cfoot`=0
dead-code guard.

## 4. Five more corrections to your inputs (all verified against live code + staging)

| # | Your doc says | Reality |
|---|---|---|
| 1 | `contact.php` **L88** needs U+2011 → U+002D | **L87 too** — the locality `פרדס חנה‑כרכור` also carries U+2011. Fixing L88 alone leaves the address non-canonical and AC-10 still unsatisfiable. |
| 2 | testimonials numbers are "**testimonial authors'**, not Eyal's" | **False.** Both are **Eyal's own number**, quoted by named authors (נוית צוף שטראוס; אלון גרזון רז — *"זה הטלפון שלו"*). **The exclusion stands on a stronger reason:** they're attributed verbatim quotations — editing them falsifies what a real person wrote. ⚠ Do **not** let a builder reason "the rationale was wrong, so I should normalize them." |
| 3 | **AC-6**: `method-02` has **no** glow | The **repo has it**. Live shows **0**. The defect isn't "missing glow" — `ea-faq-seed-once.php` is **insert-only** (`if ( ! empty( $existing ) ) { continue; }`), so resetting `ea_faq_seed_v2` changes **nothing**. The obvious route (copy the QR reseed pattern) **silently no-ops** — same shape as the WP-S5-06 trap. Fixed via a **2-key allow-list** update drop-in, *not* update-all (which would overwrite all 108 rows including wp-admin edits — WP-S4-05's whole point). |
| 4 | **AC-4**: price Q3 **absent**, Q1 geo missing | **Both are live** (`general-18` with glow ×2; `general-01` «עמל 8 ב'» ×1) → **VERIFY-only, not build**. You asked for per-AC verification before scoping — this is what it found. |
| 5 | `052-482284` in 1 file | **Correct.** But note `052-482284` is a **substring** of the canonical `052-4822842` — a naive grep reports **6** files in the guard's scan scope. I hit this myself; the guard mandates lookarounds. |

Also: **`wave2-stage-b.php:19` is a comment** (`/** WhatsApp E.164 without + — 052-4822842 */`); the real value
is `972524822842`. Do not "normalize" it.

## 5. Decisions made (do not re-open)

- **`ea_nap()` accessor — built**, in its **own** mu-plugin (`ea-nap-ssot.php`), so `ea-w2-seo-schema.php`
  becomes a **consumer** like everyone else. The root cause was an SSoT that nothing could read; adding a getter
  *inside* the schema plugin would have preserved the coupling. **AC-1 guards it:** the `ProfessionalService`
  JSON-LD node must be **byte-identical** before/after — that engine just passed WP-S5-02 cleanly.
- **EN page** displays the international form (`+972-52-482-2842`) on both L106 and L112 — it contradicts itself
  today, and `052-…` is undiallable from abroad. Display-locale ruling, not a change to Eyal's data.
- **`דיג'רידו`** (U+05F3 vs U+0027) — out of scope; brand word, not NAP. Recorded so nobody "fixes" it.
- **`ea-w2-07b-qr-reseed-once.php`** — its flag is already burnt; S5-07 needs its **own** drop-in + flag.

## 6. Build notes worth having in front of you

- **Two seeders, opposite semantics.** QR seeder **updates** `post_content` on re-run → qr32 fix works via a
  guard-reset drop-in (init@27, before the seeder at @28) — the proven WP-S5-02 §3.1 route. FAQ seeder
  **never updates** → needs the targeted drop-in (init@41, after the seeder at @40).
- **S5-06 ↔ S5-07 are order-independent on QR** — precisely because S5-06's facade is a `the_content` filter
  that never touches `post_content`. The reseed restores the same content including all 60 embeds, so the
  VideoObject nodes survive. (Had S5-06 taken the forbidden reseed route, these two would have collided.)
- **No DB edits by hand.** No WP-CLI on staging; both fixes are self-guarded `-once` drop-ins, single-fire
  (a second page load doing nothing is **correct**, not a failure).

## 7. State

- Branch **`chore/s005-registration`**, pushed. `validate_aos.sh` → **47 PASS / 31 SKIP / 0 FAIL**.
- **Ready for build:** **WP-S5-03** (handoff exists) · **WP-S5-06** (LOD400 + PASS + handoff) ·
  **WP-S5-07** (LOD400 + PASS). All three `blocked_by: []`.
- **WP-S5-05 stays BLOCKED** — go-live still needs explicit team_00/Eyal approval.
- Outstanding, unchanged: Iron Rule #15 archival (now also for the 7 newly-locked S004 WPs) — team_191 at
  team_00's discretion; not blocking any build.
