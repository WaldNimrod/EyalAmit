---
id: COMPLETION_REPORT_WP-S5-07_v1.0.0
from_team: team_110
to: [team_00, team_100]
cc: [team_90, team_120, team_60]
date: 2026-07-16
type: COMPLETION_REPORT
wp: WP-S5-07
milestone: S005
project: eyalamit
mandate_ref: _COMMUNICATION/team_110/MANDATE_S005_TEAM110_EXECUTION_v1.0.0.md
adr_ref: ADR045 R4 (execution_authority: full)
status: COMPLETE / LOD500_LOCKED
---

# COMPLETION REPORT — WP-S5-07 (S004 residual: NAP · qr32 phone · FAQ-03 · rebirthing glow)

**`/qr/qr32/` is reached by scanning a QR code printed in Eyal's book.** It rendered `052-482284` — nine digits,
an **unreachable number** — and it was the only phone on the page. A reader who scanned it, wanted to call, and
dialled, got nothing. **It now renders `052-4822842`.** That defect was live the whole time.

This WP also **closes WP-S4-07's AC-10** («NAP byte-identical FAQ ↔ footer»), which had been open since S004 and
was **unsatisfiable by construction**: there was no canonical byte-form to match against, and the footer carried
no NAP at all. Both are now true.

## 1. Gate chain

| Gate | Result | Findings | Artifact |
|---|---|---|---|
| L-GATE_SPEC (cycle 1) | PASS_WITH_FINDINGS | 0 / 1 major / 3 minor | `_archive/WP-S5-07/team_90/VERDICT-WP-S5-07-LOD400-2026-07-16.md` |
| L-GATE_SPEC (cycle 2) | PASS | 0 | `_archive/WP-S5-07/team_90/VERDICT-WP-S5-07-LOD400-CYCLE2-2026-07-16.md` |
| **L-GATE_BUILD** | **PASS** | 0 blocker / 0 major / **2 minor** | `_archive/WP-S5-07/team_90/VERDICT-WP-S5-07-BUILD-2026-07-16.md` |
| **L-GATE_VALIDATE** | **PASS** | **0** | `_archive/WP-S5-07/team_90/VERDICT-WP-S5-07-VALIDATE-2026-07-16.md` |

**Iron Rule #1:** builder `claude-opus-4-8` (Anthropic) ≠ validator `composer-2.5` (Cursor); team_110 did not
self-validate at either gate. Both gates went to team_90 per the mandate's §4 (mandate-literal reading).

## 2. Measured result (independently reproduced by team_90 on live staging)

| AC | Before | After |
|---|---|---|
| **AC-3** `/qr/qr32/` | `052-482284` (unreachable, ×1) | **`052-4822842`**; truncated **1 → 0** |
| **AC-2** footer NAP on `/`, `/faq/`, `/contact/`, `/treatment/` | **0** phone occurrences | NAP + `tel:` link on **all 4**; `ea-cfoot` = **0** |
| **AC-1** `ProfessionalService` | — | **byte-identical** after the `ea_nap()` refactor |
| **AC-4** `/faq/` glow | `ניסוח בידול` = 0 | **2**; `052-482-2842` **2 → 0** |
| **AC-5** VERIFY-only | 10 pending-approval | 12 (≥10) — all intact |
| **AC-6** canon guard | 6 phone variants | `nap_canon_check.mjs` **exit 0**, 670 files |
| **AC-7** exclusions | — | `git diff` **empty** for testimonials + `wave2-stage-b.php` |
| **AC-8** hygiene | — | `php -l` 9/9; **0** axe violations introduced; RTL 0 overflow |

**Cross-WP:** `/qr/qr32/` carries 2 videos *and* the broken phone — the one page both WPs touch. After the
reseed, `VideoObject` **2 → 2** with the S5-06 facade still live. §4.F predicted order-independence; it held.

## 3. The root cause is closed in code, not in a document

The NAP was **never missing**. It sat in a self-declared SSoT (`ea-w2-seo-schema.php`) that **nothing could
consume**, so every surface hard-coded its own copy → **6 phone variants, 3 apostrophe variants** of one
approved dataset. That is why AC-10 was impossible and why every WP that touched it "discovered" the ambiguity
and escalated it as a question.

Now: `ea_nap()` is the one source · `ea-w2-seo-schema.php` is a **consumer like every other surface** (the proof
the accessor works) · `nap_canon_check.mjs` enforces what `ea_nap()` cannot reach (JSON/HTML seeds can't call
PHP). team_90 at L-GATE_VALIDATE: a future divergence is now **impossible-by-construction**, not merely
forbidden.

## 4. ADR042 3-step closure audit

| Step | Done | Evidence |
|---|---|---|
| 1 — Gate chain, cross-engine | ✔ | L-GATE_BUILD PASS + L-GATE_VALIDATE PASS, both team_90 |
| 2 — Archive (Iron Rule #15) | ✔ | `_archive/WP-S5-07/ARCHIVE_MANIFEST.md`; **`verified_count == intended_count == 16`**, non-vacuous; M.1–M.4 applied |
| 3 — Registration | ✔ | `status: COMPLETE`, `lod_status: LOD500_LOCKED`, `current_lean_gate: L-GATE_VALIDATE`, full `gate_history` — **FILE path** (T-1 ruling; the API serves an S002 payload with zero `WP-S5-*` rows, server build 2026-07-12) |

## 5. Findings disposition

| ID | Severity | Status | Owner |
|---|---|---|---|
| **F-01** — the spec's §4.G drop-in code self-disarms | minor | **FIXED + re-verified live**; spec still needs correcting | **team_100** |
| **F-02** — AC-8's axe threshold unsatisfiable (`.foot__disc`) | minor | **OPEN** — same defect as S5-06 F-01 | **team_100** (hygiene WP) |

### F-01 — the spec's own remedy failed in exactly the shape the spec warned about
`ea-faq-seed.json` is `{_note, count, items[]}`; the rows live under `items[]` (cf. `ea-faq-seed-once.php:54,60`).
§4.G's code does `foreach ( $seed as $row )` over the **top level** → the map comes out **empty** (proven: v1 map
size **0** vs v2 **108**) → every key `continue`s → **it sets its flag having changed nothing**, burning
`ea_s507_faq_update_done` exactly as `ea-w2-07b`'s flag was burnt. Confirmed live: first run left the glow at 0.

**It survived both LOD400 cross-engine cycles because the code was reviewed, never executed.** And it is the
deeper cousin of the very trap §4.G documents — *"a builder will reset the flag, load the page, see no change,
and get stuck."*

Fixed: read `$raw['items']`, new flag `ea_s507_faq_update_v2_done`, reasoning pinned in-file. **The 2-key
allow-list was never widened** — the `wp_update_post` blast radius stayed at exactly `method-02` + `general-17`,
so §4.G's data-loss warning (108 rows / wp-admin edits, the whole point of WP-S4-05) was respected.
**team_100 action:** correct §4.G in the spec so it is not copied forward into another WP.

### F-02 — one site-wide defect, surfacing in two WPs
The single serious axe node on `/`, `/faq/`, `/contact/` is `[".foot__disc"]` — the footer's **pre-existing**
medical disclaimer, contrast **3.48**. This WP's own `.foot__nap` lands in axe's **`incomplete`** bucket
("background could not be determined due to a background image") — the *same bucket and reason* as its
pre-existing siblings. **0 violations introduced.** This is the **same `.foot__disc`** behind WP-S5-06's F-01
(`section-footer.php` renders on QR pages too). **Fold into the hygiene WP already requested under S5-06 F-01.**
Not S5-06 debt, not S5-07 debt, does not block WP-S5-05.

## 6. Caught in build (worth recording)

Replacing `רח׳`→`רח'` in `seo-head-fallbacks.php:50` **broke PHP** — the line is a single-quoted string, so a
literal `'` closed it early (`php -l` → parse error). Repaired by escaping; the **runtime** value verified
canonical. The U+05F3 there was probably never a typography choice — it just avoided escaping. This is precisely
why AC-8 mandates `php -l` on every touched file.

## 7. Deferred / out of scope (each ruled, none silently dropped)

- **`דיג'רידו` vs `דיג׳רידו` site-wide** — ratified §5.4: brand word, not NAP. Observed-and-excluded; candidate
  for a separate hygiene WP.
- **`privacy-defaults.php:81` / `accessibility-defaults.php:58` not refactored to `ea_nap()`** — ratified §5.1:
  already canonical; refactor = risk without a live defect. `nap_canon_check.mjs` guards them.
- **`wave2-stage-b.php:19`** — the number is in a **comment**; the value is `972524822842`. Nothing to fix.
- **`ea-testimonials-fb.json`** — §5.3 excluded. *The input DECISION's stated reason is factually wrong* (those
  are **Eyal's own** number quoted by named recommenders, not the authors' numbers) — but the exclusion is right
  on stronger ground: normalising a number inside a verbatim quotation changes what a real person wrote.
- **`.foot__disc` contrast** — F-02, hygiene WP.

## 8. Delivery-criterion check (roadmap L2569)

> «להגיש לאייל את האתר הכי מדוייק שאפשר … ולהשאיר רק פליסהולדרים ברורים»

This WP **removes** a defect that actively misled readers of Eyal's book, and **adds one clearly-marked
placeholder** — `method-02`'s glow («ניסוח בידול מ-rebirthing — ממתין לאישור אייל»), a *disclosed*
[EYAL-SIGN-OFF] marker. That is compliance with the criterion, not a gap: the only permitted gap is a content gap
**clearly marked** for Eyal. It will appear in the delivery message's placeholder enumeration.

## 9. Status

**WP-S5-07 — COMPLETE / LOD500_LOCKED.** Another `WP-S5-05.blocked_by` entry cleared.
**WP-S5-05 was NOT started.** Next: WP-S5-03.
