---
id: VERDICT-WP-S5-07-VALIDATE-2026-07-16
from_team: team_90
to_team: team_00
cc: [team_100, team_110]
date: 2026-07-16
type: cross-engine-validation-result
wp: WP-S5-07
milestone: S005
gate: L-GATE_VALIDATE
mandate_ref: MANDATE-TEAM90-WP-S5-07-VALIDATE-2026-07-16
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-07-LOD400-2026-07-16.md
authority:
  - _COMMUNICATION/team_110/DECISION-NAP-CANON-2026-07-16.md
builder_verdict_ref: _COMMUNICATION/team_110/VERDICT-WP-S5-07-BUILD-2026-07-16.md
build_gate_verdict: _COMMUNICATION/team_90/VERDICT-WP-S5-07-BUILD-2026-07-16.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-07/
staging_base: http://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — WP-S5-07 L-GATE_VALIDATE (team_90 constitutional validation)

## Verdict flag

**`PASS`**

WP-S5-07 is constitutionally closeable: scope-honest (exactly LOD400 §1 — 11 deployed + 1 local harness), the WP-S4-07 NAP root cause is closed in code (not merely in a document), ratified decisions honoured, findings dispositioned honestly, Iron Rule #1 intact at both gates, no undisclosed placeholders introduced, and evidence is complete and archivable. L-GATE_BUILD was independently confirmed (`VERDICT-WP-S5-07-BUILD-2026-07-16.md`); this gate judges closeability only — the AC battery was **not** re-run.

---

## Iron Rule #1

| Role | Engine | Team |
|------|--------|------|
| Builder | claude-opus-4-8 (Claude Code, Anthropic) | team_110 |
| L-GATE_BUILD validator | composer-2.5 (Cursor) | team_90 |
| L-GATE_VALIDATE validator | composer-2.5 (Cursor) | team_90 |
| Distinct vendors (builder ≠ validator) | **satisfied** | |

team_110 did not self-validate at either gate. team_90 owns L-GATE_VALIDATE per team_00 ruling 2026-07-16; ADR045 R3.2 / Iron Rule #5 still name the dissolved team_190 (GCR filed) — **rule on the WP, not on the drift.**

---

## Per-item results

| # | Check | Result | What was inspected |
|---|-------|--------|-------------------|
| **1 — Scope honesty (STOP-level)** | **PASS** | Application changes = **exactly LOD400 §1 (11 deployed + 1 local harness).** Tracked edits (8): `ea-w2-seo-schema.php`, `ea-w2-07-qr-content-data.php`, `section-footer.php`, `contact.php`, `seo-head-fallbacks.php`, `tpl-chapters-en.php`, `ea-faq-seed.json`, `chapters.css`. Untracked new (4): `ea-nap-ssot.php`, `ea-s507-qr-reseed-once.php`, `ea-s507-faq-update-once.php`, `scripts/qa/nap_canon_check.mjs`. **`git diff -w ea-w2-07-qr-content-data.php`** → **1 semantic line** (`:606` `052-482284` → `052-4822842`); the large raw diff is whitespace/line-ending only. **`git diff --stat`** empty for **`ea-testimonials-fb.json`** and **`wave2-stage-b.php`**. **`git diff block-footer-social.php`** → 0 lines (untouched). `_COMMUNICATION/*` artifacts are delivery/validator residue — **not** application creep. `DEPLOY-MANIFEST.txt` lists 11 deployed files; harness not deployed. §4.A–H all executed; no §4 shortfall found. |
| **2 — Root cause closed in CODE (§2 / §5.1)** | **PASS** | **`ea_nap()`** exists as the single PHP source (`site/wp-content/mu-plugins/ea-nap-ssot.php:21–37`). **`ea-w2-seo-schema.php`** is now a **consumer** (`:57–58`, `:61`, `:65–67` → `ea_nap()` keys) — the former “declarative but unreadable” SSoT pattern is ended. All in-scope PHP display surfaces grep to `ea_nap()`: `section-footer.php:35–37`, `contact.php:87–88`, `tpl-chapters-en.php:106,112`. JSON/HTML seeds that cannot call PHP remain literals (`ea-faq-seed.json`, `ea-w2-07-qr-content-data.php`) and are **enforced by construction** via `scripts/qa/nap_canon_check.mjs` (bounded lookarounds; independent run → exit **0**, 670 files, 0 variants). Future drift in `site/wp-content` + `scripts` without updating `ea_nap()` **fails CI** — not merely “forbidden in prose.” Out-of-scope surfaces (`privacy-defaults`, `accessibility-defaults`, testimonials) are explicitly bounded per §5.1/§5.3 — not a reopening of WP-S4-07's residual within this WP's contract. |
| **3 — Dead-code trap stayed shut** | **PASS** | Live footer NAP built in **`section-footer.php`** (`foot__brand` + `foot__nap` / `foot__tel`) reading `ea_nap()` — no hardcoded copy. **`block-footer-social.php`** unchanged; still carries only `ea-cfoot__loc` “פרדס חנה · ישראל” with **no** full NAP and **no** phone — the exact drift pattern §4.B forbids was **not** added “for safety.” L-GATE_BUILD evidence (`footer-nap/AC-2-footer.txt`) recorded `ea-cfoot`=**0** on `/`, `/faq/`, `/contact/`, `/treatment/`; not re-measured here per mandate. |
| **4 — Ratified decisions honoured** | **PASS** | **§4.C both L87+L88:** `contact.php:87–88` → `ea_nap('address_display')`, `ea_nap('phone_href')`, `ea_nap('phone_display')` + inline `nowrap`. **§4.D token-targeted:** `seo-head-fallbacks.php:50` — `רח\' עמל 8 ב\'` (U+0027); `דיג׳רידו` (U+05F3) **intact** in the string. **§5.2 EN international form:** `tpl-chapters-en.php:106,112` → `ea_nap('phone_schema')`. **§5.3 testimonials untouched:** `git diff` empty on `ea-testimonials-fb.json`. **§5.4 brand word out of scope:** footer tagline `דיג׳רידו` (U+05F3) in `section-footer.php:34` unchanged. **§4.G allow-list exactly 2 keys:** `ea-s507-faq-update-once.php:43` → `['method-02', 'general-17']` only; reads `$raw['items']` (`:53–62`). **§4.B nowrap “choose one”:** CSS only — `chapters.css:797` `.foot__tel a { white-space: nowrap; }`; no inline nowrap on footer anchor. |
| **5 — Findings dispositioned honestly** | **PASS** | **F-01 (spec defect — CONFIRM, not buried):** LOD400 §4.G sample code iterated top-level `$seed` instead of `$raw['items']` — would self-disarm and burn the flag with zero DB writes (same class as the insert-only trap §4.G documents). Builder fixed in deployed `ea-s507-faq-update-once.php` (v2 flag `ea_s507_faq_update_v2_done`; `$raw['items']` iteration). L-GATE_BUILD independently reproduced the bug shape and verified live fix. **Disposition:** defect **against the spec**, not the builder; team_100 should annotate LOD400 §4.G (or errata). **Does not block constitutional close** — fix is deployed and live-verified. **F-02 (AC-8 axe — CONFIRM, not buried):** literal `axe → exit 0` remains unsatisfiable on staging baseline (pre-existing `.foot__disc` contrast 3.48 on `/`, `/faq/`, `/contact/`). **“PASS on intent” is honest:** WP-S5-07 introduced **0** new/worsened violations; `.foot__nap` lands in `incomplete` only (background image), same bucket as pre-existing footer siblings. Bar was **not** silently lowered after the fact — same routing as WP-S5-06 F-01 to hygiene WP. |
| **6 — Iron Rule #1 chain** | **PASS** | Builder `claude-opus-4-8` (Anthropic) ≠ validator `composer-2.5` (Cursor) at L-GATE_BUILD (`VERDICT-WP-S5-07-BUILD-2026-07-16.md`) and this L-GATE_VALIDATE pass. team_110 never self-validated. |
| **7 — team_00 delivery criterion (roadmap L2569)** | **PASS** | «להגיש לאייל את האתר הכי מדוייק שאפשר … ולהשאיר רק פליסהולדרים ברורים». This WP **adds** disclosed `[EYAL-SIGN-OFF]` markers (`method-02` rebirthing glow — `.ea-pending-approval`, intentionally pending Eyal sign-off per S4-06 routing), **not** hidden placeholders. It closes live defects: footer NAP (was absent), `/qr/qr32/` unreachable phone (9 digits), FAQ wrong phone + missing glow in DB. No undisclosed “coming soon” shells, empty content blocks, or silent TBD copy introduced on the four live routes or QR headline page. Pre-existing site-wide items (`.foot__disc` contrast, `דיג'רידו` orthography inconsistency) are ruled out-of-scope or routed elsewhere — not disguised as complete. |
| **8 — LOD500 readiness (file path)** | **PASS** | `_aos/roadmap.yaml` WP-S5-07 currently `PLANNED` / `lod_status: LOD400` / `current_lean_gate: L-GATE_SPEC` — pending this verdict and a **file** mutation. **File-SSoT is correct:** roadmap notes record team_00 **T-1 ruling (2026-07-16)**: ADR034 R9/R10/R12 — spoke **file** is write-SSoT; API `/api/l0/eyalamit/roadmap` serves stale projection (zero `WP-S5-*` rows; server build 2026-07-12 predates fix). WP-S5-07 row carries `roadmap_mutation: ADR034 R8 file-SSoT`. This is the **ruled** file path per WP-S5-01 / WP-S5-06 precedent — **not** a silent 4th R8 invocation. After this PASS, team_100 may set `status: COMPLETE`, `lod_status: LOD500_LOCKED`, `current_lean_gate: L-GATE_VALIDATE`, append `gate_history` for L-GATE_BUILD + L-GATE_VALIDATE — **via file only**. |

---

## LOD500 readiness

| Question | Answer |
|----------|--------|
| Ready for `LOD500_LOCKED`? | **Yes** |
| May WP-S5-07 be archived? | **Yes** — evidence pack under `_COMMUNICATION/team_110/evidence/s5-07/` is complete; `nap_canon_check.mjs` survives under `scripts/qa/` |
| Safe to feed WP-S5-05 cutover gate? | **Yes, as a resolved blocker** — this WP closes the S004 NAP residual that blocked cutover (`WP-S5-05.blocked_by` included WP-S5-07). **Do not open WP-S5-05** without explicit team_00 / Eyal go-live approval per mandate. |

---

## route_recommendation

**`L-GATE_VALIDATE PASS — WP-S5-07 may be locked LOD500 and archived`**

No route back to team_110 for remediation. team_100: file-path roadmap update + LOD400 §4.G errata for F-01 (spec sample code). F-02 remains routed to site-wide hygiene WP (S5-06 F-01 lineage). WP-S5-05 cutover remains gated separately.

---

*Filed by team_90 · composer-2.5 · cross-engine L-GATE_VALIDATE · WP-S5-07 · 2026-07-16*
