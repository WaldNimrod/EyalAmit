---
id: MANDATE-TEAM90-WP-S5-07-BUILD-2026-07-16
from_team: team_00
authored_by: team_110 (under ADR045 execution_authority: full)
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
wp: WP-S5-07
milestone: S005
gate: L-GATE_BUILD
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-07-LOD400-2026-07-16.md
target_execution: _COMMUNICATION/team_110/VERDICT-WP-S5-07-BUILD-2026-07-16.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-07/
staging_base: http://eyalamit-co-il-2026.s887.upress.link
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S5-07-BUILD-2026-07-16.md
---

# MANDATE — team_90 cross-engine validation: WP-S5-07 (L-GATE_BUILD)

You are the **cross-engine validator** (`composer-2.5`, non-Claude). WP-S5-07 carries the S004 residual that
WP-S4-07's verdict explicitly routed and which was **never executed**. Its sharpest item: `/qr/qr32/` — reached
by scanning a QR **printed in Eyal's book** — rendered `052-482284`, a **nine-digit unreachable number**, and it
was the only phone on the page. The builder (team_110, `claude-opus-4-8`) reports 8/8 ACs met on staging.

**Independently reproduce each AC from the modified code + live staging + the evidence — do not merely re-read
the builder's report.**

## Sources of truth

| What | Path |
|---|---|
| Spec (ratified, cycle-2 clean PASS, rev-3) | `_COMMUNICATION/team_100/S005/WP-S5-07-LOD400-2026-07-16.md` |
| NAP canon (**RATIFIED — not re-openable**) | `_COMMUNICATION/team_110/DECISION-NAP-CANON-2026-07-16.md` |
| Builder's result + findings | `_COMMUNICATION/team_110/VERDICT-WP-S5-07-BUILD-2026-07-16.md` |
| Evidence root | `_COMMUNICATION/team_110/evidence/s5-07/` |

## ⛔ The NAP is decided. Do not re-open it.

team_00, 2026-07-16: «זה המידע המדוייק. לא לשאול יותר שוב!!!» and «דיר באלק אם שוב אתם שואלים אותו מה הטלפון.»
**No finding may ask what the NAP is, or defer a NAP decision.** If you believe a value is wrong, cite the
DECISION record — do not escalate a question. Verify **conformance to the canon**, nothing else.

## Acceptance criterion

LOD400 §6 AC-1..AC-8 all PASS on live staging with evidence.
**AC-1 FAIL ⇒ STOP** (the WP-S5-02 schema engine is broken). **AC-7 FAIL ⇒ STOP** (scope breach).

## Checks — reproduce each, cite concrete evidence (URL + code location + observed value)

1. **AC-1 — the regression guard. Do this FIRST.** Parse the live `ProfessionalService` JSON-LD and compare to
   `schema-regression/ProfessionalService_BEFORE.json`. `telephone`, `address.streetAddress`,
   `address.addressLocality`, `name`, `alternateName` must be **byte-identical**. Confirm from the code that
   `ea-w2-seo-schema.php` L57/58/61/65/66 now read `ea_nap()` and that only **values** changed — no structural
   edit. `ea-w2-seo-schema.php` is the engine WP-S5-02 just passed cross-engine on.
2. **AC-2 — the footer NAP (this is WP-S4-07's AC-10, finally satisfiable).** On `/`, `/faq/`, `/contact/`,
   `/treatment/`: the footer must carry `רח' עמל 8 ב', פרדס חנה-כרכור` **and**
   `<a href="tel:+972524822842" …>052-4822842</a>` inside `foot__brand`, from **0** phone occurrences before.
   **FAQ↔footer byte-match** on `עמל 8 ב'` (U+0027). **Dead-code guard: `ea-cfoot` = 0 on all 4** — proving
   `block-footer-social.php` stayed dead and no second hardcoded NAP copy was created.
   > ⚠ **Measurement note:** `esc_html()` renders `'` as `&#039;`, so a raw grep for the literal will find 0 in
   > the footer while `/faq/` shows the literal. **Compare DECODED text.** Do not report this as a mismatch, and
   > do not ask for `esc_html()` to be removed — that would be a security regression.
3. **AC-3 — `/qr/qr32/`.** `curl -k` → HTTP 200, contains `052-4822842`, and **0** standalone `052-482284`.
   **Use lookarounds** (see the substring guardrail). Confirm the other 47 QR pages' `post_content` is unchanged.
   **Also cross-check WP-S5-06:** `VideoObject` on `/qr/qr32/` must still be **2** and the facade still present —
   the reseed must not have dropped the schema.
4. **AC-4** — `/faq/` contains `ניסוח בידול` ≥1 (from **0**) and `052-4822842` with **0** × `052-482-2842`
   (from **2**).
5. **AC-5** — VERIFY-only unbroken: `כמה עולה טיפול` ≥1 · `מדיניות מחיר` ≥2 · `עמל 8 ב` ≥1 ·
   `.ea-pending-approval` **≥10**. *(Observed 12, not the spec's predicted 11: `method-02`'s answer renders
   twice on `/faq/`, so it contributes +2. The AC's threshold is ≥10.)*
6. **AC-6** — `node scripts/qa/nap_canon_check.mjs` → **exit 0**.
7. **AC-7 — scope. STOP-level.** `git diff --stat` must be **empty** for
   `inc/data/ea-testimonials-fb.json` and `inc/wave2-stage-b.php`. The `דיג׳רידו` U+05F3 count in the footer
   `__tag` must be unchanged. Confirm `seo-head-fallbacks.php:50` changed **only** `רח׳`/`ב׳` and **not**
   `דיג׳רידו`.
8. **AC-8** — `php -l` clean on all 9 touched PHP files; `qa_probe.mjs` PASS mobile+desktop on `/` and
   `/contact/` with 0 horizontal overflow (the nowrap phone in RTL is a genuine overflow risk — that is why this
   AC exists). axe: **read F-02 below before judging.**

## 🔴 Adjudicate the two builder-raised findings

- **F-01 — the spec's own §4.G drop-in code is buggy and self-disarms.** `ea-faq-seed.json` is
  `{_note, count, items[]}`; the rows live under `items[]` (cf. `ea-faq-seed-once.php:54,60`). The spec's
  `foreach ( $seed as $row )` walks the top level, builds an **empty** map, `continue`s every key, and sets its
  flag having changed nothing — burning `ea_s507_faq_update_done`. Verify this yourself against the real JSON
  (v1 map size **0** vs v2 **108**). The builder fixed it (`$raw['items']`, new flag
  `ea_s507_faq_update_v2_done`) and re-ran successfully. **Confirm the allow-list was NOT widened** — it must
  still be exactly `['method-02','general-17']`, or §4.G's data-loss warning (108 rows / wp-admin edits) is live.
  **This is a finding against the SPEC, which passed two clean cycles because the code was reviewed, never run.**
- **F-02 — AC-8's axe threshold is unsatisfiable; pre-existing and site-wide.** The single serious node on all
  three routes is `[".foot__disc"]` — the footer's pre-existing medical disclaimer, contrast **3.48**. The
  builder's added `.foot__nap` lands in axe's **`incomplete`** bucket ("background could not be determined due to
  a background image") — the **same bucket and reason** as the pre-existing `.foot__brand > b` and tagline `<p>`.
  So 0 violations were introduced. **This is the SAME `.foot__disc` behind WP-S5-06's F-01** (that footer renders
  on QR pages too) — one site-wide defect, already routed to a hygiene WP. **Verify and rule.**

## Guardrails — DO NOT flag these as defects

- 🔴 **Substring:** `052-482284` ⊂ `052-4822842`. A naive grep over `site/wp-content`+`scripts` reports **6**
  files when there is exactly **1**. **Use lookarounds** (`(?<![\d-])052-482284(?![\d])`) — otherwise you will
  send the builder to "fix" perfectly correct files. team_100 fell for this on its first scan.
- **Expired TLS / HTTP-only staging** — by design. `curl -k`. **Not a finding.**
- **Site-wide `x-robots-tag: noindex`** — host-conditional. **Not a finding.**
- **Transient `curl 000` — and `503`.** Measured this session: routes returning `503` in a batch all returned
  `200` re-probed **serially**. Throttling, not a redirect. **Probe sequentially before marking FAIL.**
- **The drop-ins are single-fire.** After the first run they are no-ops. "Nothing happened on the second load"
  is **correct**, not a failure.
- **`esc_html()` entity-encoding** (`&#039;`) — correct WP practice; compare decoded text (see check 2).
- **`ea-testimonials-fb.json` excluded** — §5.3. Note the input DECISION's stated reason is factually wrong
  (they are **Eyal's own** number quoted by named recommenders, not the authors' numbers), but **the exclusion is
  RIGHT** on the stronger ground: normalising a number inside a verbatim quotation changes what a real person
  wrote. **Do not conclude "the reason is wrong, so the exclusion is wrong."**
- **`דיג'רידו` / `דיג׳רידו` inconsistency site-wide** — ratified §5.4 as observed-and-excluded (brand word, not
  NAP). **Not a finding.**
- **`privacy-defaults.php:81`, `accessibility-defaults.php:58` not refactored to `ea_nap()`** — ratified §5.1
  (already canonical; refactor = risk without a live defect). **Not a finding.**
- **`wave2-stage-b.php:19`** — the number there is in a **comment**; the value is `972524822842`. Nothing to fix.
- **`.ea-pending-approval` count 12 (not 11)** — `method-02` renders twice; AC-5's threshold is ≥10.
- **Pre-existing `validate_aos.sh` Check-32** — team_00/team_100 scope.

## Required output

Write `_COMMUNICATION/team_90/VERDICT-WP-S5-07-BUILD-2026-07-16.md`:
- Frontmatter mirroring the S5-01/02/06 verdicts.
- `## Verdict flag` — `PASS` / `PASS_WITH_FINDINGS` / `FAIL`.
- `## Iron Rule #1` — role/engine/team table incl. "Distinct vendors | satisfied".
- `## Per-item results` — one row per check, citing URL + HTTP + `file:line` + the value **you** observed.
- `## F-01 / F-02 adjudication` — your independent ruling on each.
- `## route_recommendation` — if PASS, say `L-GATE_BUILD PASS`.

**Do not** open WP-S5-05. **Do not** re-open the NAP.
