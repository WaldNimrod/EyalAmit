---
id: MANDATE_S005_TEAM110_EXECUTION_v1.0.0
from: team_100
to: team_110
cc: [team_00, team_90, team_120, team_60, team_70]
date: "2026-07-16"
type: EXECUTION_MANDATE
wp: [WP-S5-03, WP-S5-06, WP-S5-07]
milestone: S005
project: eyalamit
branch: main
execution_authority: full          # ← ADR045 R1 trigger — activates autonomous execution mode
status: ACTIVE
spec_ref:
  - _COMMUNICATION/team_100/S005/WP-S5-03-LOD400-2026-07-16.md
  - _COMMUNICATION/team_100/S005/WP-S5-06-LOD400-2026-07-16.md
  - _COMMUNICATION/team_100/S005/WP-S5-07-LOD400-2026-07-16.md
authorized_by: "team_00 (נמרוד) 2026-07-16 — «/AOS_handoff 110 full ליצירת הסשן שיממש את כלל תהליך הפיתוח שאופיין»"
---

# Execution Mandate — S005 build → deploy → validate → archive → deliver to Eyal

> **`execution_authority: full`** — team_110 is the primary executor for all three WPs. No mid-execution
> approvals needed. team_100 receives the COMPLETION_REPORT. Reference:
> `_aos/governance/directives/ADR045_TEAM_110_AUTONOMOUS_EXECUTION_v1.0.0.md`.

## §0 The success criterion — team_00, verbatim. Meet it precisely.

> **«להגיש לאייל את האתר הכי מדוייק שאפשר … ולהשאיר רק פליסהולדרים ברורים»**
> *(`_aos/roadmap.yaml` L2547 — the standing definition of done for this delivery.)*

**The only permitted gap from a perfect, approved site is a content gap carrying a CLEAR placeholder for Eyal.**
An **unmarked** placeholder is a failure of the criterion — that is precisely what WP-S5-07 AC-4 closes.

## §1 Scope — three WPs, one session, three separate gate chains

| WP | What | `blocked_by` |
|----|------|--------------|
| **WP-S5-03** | Legacy/301 completeness — triage 406 legacy URLs, verify redirect-map coverage | `[]` |
| **WP-S5-06** | QR embed facade — click-to-load (deliver the lazy-load commitment) | `[]` |
| **WP-S5-07** | S004 residual — NAP consistency · `/qr/qr32/` wrong phone · FAQ-03 · rebirthing glow | `[]` |

**All three are LOD400 with a clean team_90 cross-engine `PASS` on their spec, and a build handoff.**
**Keep them separate: three mandates · three verdicts · three gates · three evidence trees.** They were
deliberately not merged so no verdict is contaminated. **Do NOT start WP-S5-05** — it is the blocked cutover
gate and needs explicit team_00 go-live approval.

## §2 Read before beginning

Per WP: the **LOD400** (`spec_ref` above) **and** its handoff —
`_COMMUNICATION/team_110/HANDOFF_SELF_110_{WP}_2026-07-16_v1.md`.

> **The hub `prompt-generate` skeleton in each handoff is content-empty and team_120 has confirmed it is not to
> be trusted until the endpoint fix deploys («אל תסמכו על הנדאופים שלו»). THE SPOKE SUPPLEMENT IS THE MISSION.**

Also binding: `_COMMUNICATION/team_110/DECISION-NAP-CANON-2026-07-16.md` (**RATIFIED** — the NAP is **not** an
open question; do not ask team_00, do not ask Eyal, do not add a "decide NAP" item).

## §3 Acceptance criteria (summary — full detail in each `spec_ref`)

- **WP-S5-03** — per its LOD400: 406 legacy URLs triaged (preserve/301 vs junk); 301 coverage verified against
  `ea-w209-legacy-301-redirects.php` as the **sole** live redirect source; no real legacy content dropped.
- **WP-S5-06** — AC-1 player payload **0 req / 0 bytes** on `/qr/qr2/`+`/qr/qr10/` (from ~1.06 MB) · AC-1b thumbs
  ≤20 KB × videoCount · **AC-2 regression guard: VideoObject counts unchanged (qr2=1, qr10=3, qr1=0, qr48=0)** ·
  AC-3 click loads the nocookie player · AC-4 no LCP regression + axe 0 + RTL · AC-5 `php -l` + QR-only scoping.
- **WP-S5-07** — **AC-1 `ProfessionalService` JSON-LD byte-identical** before/after the `ea_nap()` refactor ·
  AC-2 live footer carries the NAP on `/`,`/faq/`,`/contact/`,`/treatment/` + FAQ↔footer byte-match +
  `ea-cfoot`=0 dead-code guard · **AC-3 `/qr/qr32/` renders `052-4822842`, zero standalone `052-482284`** ·
  AC-4 `method-02` glow live + `052-4822842` with zero `052-482-2842` · AC-5 VERIFY-only items unbroken ·
  AC-6 `nap_canon_check.mjs` exit 0 · AC-7 exclusions honoured · AC-8 `php -l` + axe exit 0 + `qa_probe` PASS.

## §4 Execution sequence

Per WP, independently:

1. **Implement** all ACs per `spec_ref`.
2. **Deploy to staging** — **FTP; there is no WP-CLI on staging.** WP-S5-07's `/qr/qr32/` fix additionally
   requires a **reseed via a self-guarded `-once` drop-in with a NEW flag** (`ea-w2-07b`'s flag is already
   burnt). **Never hand-edit the DB.**
3. **Test** — `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` (RTL/overflow, mobile+desktop) ·
   `scripts/qa/http-qa-axe.cjs` (exit 0 = 0 critical + 0 serious) · `scripts/qa/qr_facade_probe.mjs` (S5-06) ·
   `scripts/qa/nap_canon_check.mjs` (S5-07).
4. **L-GATE_BUILD → team_90** (ADR045 R2.1 — you may mandate them directly).
   Mirror `MANDATE-TEAM90-WP-S5-0{1,2}-*` **including their Guardrails section** — it demonstrably prevented
   false-positive FAILs. Runner: `bash scripts/run_cross_engine_validation.sh team_90 . <mandate>`
   (`--dry-run` first). **Correction loop until a clean PASS** (the S005 precedent: cycle 1 findings → fix →
   cycle 2 clean).
5. **L-GATE_VALIDATE → team_90.**
   > ⚠ **SUPERSEDES ADR045 R2.1/R3.2, which still says team_190.** **team_00 ruled 2026-07-16: «team_90 הוא
   > הוולידטור» — team_90 owns L-GATE_VALIDATE.** team_190 has no governance file (the registry holds 14 teams).
   > GCR filed to amend the contracts: `_COMMUNICATION/team_100/GCR_team_100_L-GATE_VALIDATE_OWNER_TEAM_90_2026-07-16_v1.0.0.md`.
   > **Iron Rule #1 still binds:** you must not validate your own build — team_90 (`composer-2.5`) ≠ your engine.
6. **Archive — immediately on L-GATE_VALIDATE PASS. Do not skip; it is your duty, not team_00's.**
   > ⚠ **SUPERSEDES ADR045 R2.1 + the mandate template, which still say team_191 / hand-write the manifest.**
   > **team_191 is DISSOLVED** (ADR042 Addendum v1.1.0, co-signed team_00+team_100). Run **`/AOS_archive <WP-ID>`**
   > (API-mediated `archive.py execute_archive()`) per `POST_GATE_ARCHIVE_PROCEDURE.md` **v1.3.0**. Do NOT proceed
   > until `ARCHIVE_MANIFEST.md` is written **and** `verified_count == intended_count` (physical-presence check).
   > **team_120** = procedure custodian; **team_60** commits the archive.
7. **Register closure** — `_aos/roadmap.yaml` WP entry → `status: COMPLETE`, `lod_status: LOD500_LOCKED`,
   `current_lean_gate`, + `gate_history` (**ADR045 R2.3 grants you this write in execution mode**).
   > 🔴 **Use the FILE path, NOT the API.** ADR045 R2.2 offers `POST /api/work-packages/{id}` — **do not use it
   > here.** **ADR034 R9/R10/R12 + team_00's T-1 ruling (2026-07-16): the FILE is the write-SSoT for this spoke.**
   > `health` reports `db: online`, so Iron Rule #7 *looks* like it demands the API — but the endpoint serves an
   > **S002 world with zero `WP-S5-*` rows** (`l0_roadmap_source: database`, 24 WPs). **An API mutation would
   > write the wrong object.** This is a live trap; the endpoint fix is written but not yet deployed.
8. **COMPLETION_REPORT** (ADR045 R4) → `_COMMUNICATION/team_110/{WP_ID}/COMPLETION_REPORT_{WP_ID}_v1.0.0.md`,
   to **team_00 + team_100**: gate chain, verdict paths, ADR042 3-step audit, findings disposition, deferrals.

## §5 After all three close — the final message to Eyal

**This is part of the mandate, not a follow-up.** Compose the delivery message to Eyal (**team_70**, the
Librarian, owns writing/composition — route to them; **team_00 sends it**). It must:
1. State what changed since the last package.
2. **Enumerate EVERY remaining placeholder** — that is the success criterion (§0): the only permitted gap is a
   content gap **clearly marked** for Eyal. A placeholder that exists but is not disclosed fails §0.
3. Name what is still needed **from Eyal** (M-EYAL-INPUTS + WP-S5-04 human checks).
4. **Not** promise go-live: WP-S5-05 is blocked and needs explicit team_00/Eyal approval.

## §6 🔴 Four traps that will silently defeat you (each already cost a real cycle)

1. **`block-footer-social.php` is DEAD.** Both NAP input docs point at it; `ea-cfoot` = **0** on every live route.
   The live footer is **`template-parts/chapters/section-footer.php`**. Caught by team_90 only at cycle 1 (major).
2. **The facade MUST be a `the_content` render filter.** The reseed route removes the embed URL from
   `post_content`, so `ea-w2-seo-schema.php:266`'s regex returns 0 → **every VideoObject vanishes from 42 QR
   pages**, silently, destroying the WP-S5-02 build. AC-2 is the guard.
3. **The FAQ seeder is INSERT-ONLY** (`if ( ! empty( $existing ) ) { continue; }`) — resetting `ea_faq_seed_v2`
   does **nothing**. Use the 2-key allow-list drop-in. *(The QR seeder is the opposite: it **does** update on
   re-run.)* **Two seeders, opposite semantics.**
4. **`052-482284` is a SUBSTRING of `052-4822842`** — naive grep reports 6 files; there is exactly **1**.

## §7 Two items team_120 assigned you (ruling §4)

1. **Confirm the mail channel:** `aos_actor team_110` → inbox → expect **200/422**. **Report via the bus — that
   is itself the proof.** If **401** → report to team_00. *(team_100 must not do this for you: sending as
   team_110 from a team_100 key returns 403 `TEAM_ID_MISMATCH` and is escalated as impersonation.)*
2. **Update §4 of `ROUTING-REQUEST-TEAM100-S005-REGISTRATION-2026-07-16.md`** (your directory) to:
   > *"superseded by T-1 ruling 2026-07-16 — file-SSoT enforced (R9/R10/R12); no backfill; fix = endpoint
   > authority guard + server checkout freshness; see MSG-TEAM120-FINAL-RULING-ALIGNMENT-2026-07-16"*

## §8 Completion criteria

- [ ] All ACs verified per WP, on live staging, with evidence under `_COMMUNICATION/team_110/evidence/s5-0{3,6,7}/`
- [ ] team_90 **L-GATE_BUILD**: clean PASS (0 blockers) — per WP
- [ ] team_90 **L-GATE_VALIDATE**: clean PASS (0 blockers) — per WP
- [ ] `/AOS_archive` run per WP; `ARCHIVE_MANIFEST.md` present; `verified_count == intended_count`
- [ ] `_aos/roadmap.yaml`: each WP `COMPLETE` / `LOD500_LOCKED` + `gate_history` (**file path, not API**)
- [ ] `validate_aos.sh` → **0 FAIL** (incl. Check 32 — commit the `_aos/` tree)
- [ ] COMPLETION_REPORT per WP → team_00 + team_100
- [ ] Merged to `main` + pushed
- [ ] **Final message to Eyal drafted (team_70) with every remaining placeholder enumerated — §0/§5**

## §9 Boundaries

- **Do NOT start WP-S5-05** (blocked cutover gate — explicit team_00/Eyal go-live approval required).
- **Do NOT validate your own build** (Iron Rule #1 — ADR045 R3.1).
- **team_00 override is absolute** at all times (ADR045 R3.3). **team_100 resumes closure** if this session ends
  without LOD500_LOCKED (R3.4).
- **Bus caveat:** `capture` is idempotent on `(session_id, gate, kind)` — **`wp_id` is not in the key**
  (`messages.py:302`), so multiple handoff captures from one session collapse into one row while still
  reporting `"captured": true`. **Verify the bus** (`inbox?…&limit=100`, returns oldest-first) or use
  `POST /messaging/v2/send` with `kind=handoff` per WP.
- **Worktree isolation:** `main` moved three times during team_100's session and another session committed onto
  its branch. Work in an isolated worktree; re-check `origin/main` before finalizing.

---

*MANDATE | S005 TEAM_110 EXECUTION | ADR045 `execution_authority: full` | team_100 | 2026-07-16*
