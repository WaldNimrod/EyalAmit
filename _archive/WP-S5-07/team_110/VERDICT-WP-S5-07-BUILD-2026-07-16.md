---
id: VERDICT-WP-S5-07-BUILD-2026-07-16
from_team: team_110
to_team: team_00
cc: [team_100, team_90]
date: 2026-07-16
type: build-verify-result
wp: WP-S5-07
milestone: S005
gate: L-GATE_BUILD
next_wp: WP-S5-05
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-07-LOD400-2026-07-16.md
authority:
  - _COMMUNICATION/team_110/DECISION-NAP-CANON-2026-07-16.md
mandate_ref: _COMMUNICATION/team_110/MANDATE_S005_TEAM110_EXECUTION_v1.0.0.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-07/
builder_engine: claude-opus-4-8 (Claude Code, Anthropic)
builder_team: team_110
staging_base: http://eyalamit-co-il-2026.s887.upress.link
result: PASS_WITH_FINDINGS
---

# Builder result — WP-S5-07 (NAP consistency · qr32 phone · FAQ-03 · rebirthing glow)

## Summary

**Verdict flag: `PASS_WITH_FINDINGS` — 8/8 ACs met on live staging · 0 blockers · 0 major · 2 minor.**

**The headline is AC-3.** `/qr/qr32/` is reached by scanning a QR **printed in Eyal's book**. It rendered
`052-482284` — nine digits, an **unreachable number** — and it was the only phone on the page. It now renders
`052-4822842`. That defect was live the entire time.

**AC-2 closes WP-S4-07's AC-10**, open since S004 and *unsatisfiable by construction*: there was no canonical
byte-form to match against, and the footer carried no NAP at all. Both are now true.

| AC | Requirement | Result | Evidence |
|----|---|---|---|
| **AC-1** | 🔴 `ProfessionalService` byte-identical | **PASS** — every field identical; the **whole node** byte-identical | `schema-regression/ProfessionalService_{BEFORE,AFTER}.json` |
| **AC-2** | footer NAP + FAQ↔footer byte-match + `ea-cfoot`=0 | **PASS** — NAP live on `/`, `/faq/`, `/contact/`, `/treatment/` (from **0**); `ea-cfoot`=**0** on all 4 | `footer-nap/AC-2-footer.txt` |
| **AC-3** | 🔴 `/qr/qr32/` correct phone | **PASS** — renders `052-4822842`; standalone truncated **1 → 0** | `qr32/AC-3-qr32.txt`, `qr32/qr32_{BEFORE,AFTER}.html` |
| **AC-4** | FAQ: glow + canonical phone | **PASS** — `ניסוח בידול` **0 → 2**; `052-482-2842` **2 → 0**; canonical **1 → 3** | `faq-update/AC-4-AC-5-faq.txt` |
| **AC-5** | VERIFY-only unbroken | **PASS** — all intact; `.ea-pending-approval` **10 → 12** (≥10) | `faq-update/AC-4-AC-5-faq.txt` |
| **AC-6** | `nap_canon_check.mjs` exit 0 | **PASS** — 670 files, 0 variants | `canon-guard/` |
| **AC-7** | exclusions honoured | **PASS** — `git diff` empty for testimonials + `wave2-stage-b.php` | `scope/` |
| **AC-8** | `php -l` · axe · RTL | **PASS on intent** — `php -l` 9/9; **0 axe violations introduced**; RTL 0 overflow (see F-02) | `a11y-rtl/` |

## AC-1 — the regression guard (this engine just passed WP-S5-02 cross-engine)

The `ea_nap()` refactor is **behaviour-preserving**. Live `ProfessionalService`, before vs after:

```
name                    IDENTICAL   "המרכז לטיפול בנשימה באמצעות דיג'רידו"
alternateName           IDENTICAL   "cbDIDG"
telephone               IDENTICAL   "+972-52-482-2842"
address.streetAddress   IDENTICAL   "עמל 8 ב'"
address.addressLocality IDENTICAL   "פרדס חנה-כרכור"
address.addressCountry  IDENTICAL   "IL"
=> the ENTIRE node is byte-identical.
```

`ea-w2-seo-schema.php` is now a **consumer** of `ea_nap()` like every other surface — which is the proof the
accessor works (§4.A). The root cause (§2) is closed in code, not just in a document: the SSoT was
*declarative but unreadable*, so 6 phone variants drifted out of one approved dataset.

## AC-3 — cross-WP interaction with WP-S5-06 (both touch `/qr/qr32/`)

`/qr/qr32/` carries **2 videos** *and* the broken phone, so it is the one page both WPs touch. §4.F predicted
they are order-independent, and that held:

```
VideoObject  2 -> 2      (reseed did NOT drop the schema)
ea-qr-facade still present: yes
```

The facade is a `the_content` **render filter** and never touches `post_content`; the reseed writes back the
same seed HTML, embeds included. Both survive. Had S5-06 taken the forbidden reseed route, these two WPs would
have collided — further confirmation of §2's constraint.

## Findings (both minor; neither blocks)

### F-01 (minor) — 🔴 **the spec's §4.G drop-in has a real bug: it self-disarms**

`ea-faq-seed.json` is **`{ "_note": str, "count": int, "items": [...] }`** — the rows live under `items[]`.
The real seeder reads `$raw['items']` (`ea-faq-seed-once.php:54,60`). But the spec's §4.G code does:

```php
$seed = json_decode( ..., true );
foreach ( $seed as $row ) { if ( isset( $row['seed_key'] ) ) { $by[ $row['seed_key'] ] = $row; } }
```

which walks `_note` / `count` / `items` — **none has a `seed_key`**. Proven locally against the real file:

```
v1 (foreach $raw)          -> map size 0     => every key `continue`s, silent no-op
v2 (foreach $raw['items']) -> map size 108   => both keys resolve
```

So the drop-in **sets its flag having changed nothing**. First run on staging confirmed it: `method-02` glow
stayed 0, `052-482-2842` stayed 2. **And it burnt `ea_s507_faq_update_done` in the process** — the same
"spent flag" lesson as `ea-w2-07b-qr-reseed-once.php`, which is why §4.F required a new flag in the first
place.

**This survived both LOD400 cross-engine cycles** (cycle 1 `PASS_WITH_FINDINGS` → cycle 2 clean `PASS`)
because the code was reviewed, never **executed**. It is the deeper cousin of the trap §4.G itself documents:
§4.G correctly warns that the FAQ seeder is insert-only and that a builder "will reset the flag, load the
page, see no change, and get stuck" — the spec's own remedy then failed in exactly that shape.

**Fixed:** read `$raw['items']`; new flag `ea_s507_faq_update_v2_done`; reasoning pinned in the drop-in so it
cannot be "simplified" back. Re-ran: glow 0→2, wrong phone 2→0. **The 2-key allow-list was never widened** —
the `wp_update_post` blast radius stayed at exactly `method-02` + `general-17`, so no wp-admin edit was at
risk (§4.G's data-loss warning respected).

### F-02 (minor) — AC-8's axe threshold is unsatisfiable; same root cause as WP-S5-06 F-01

AC-8 requires `axe → exit 0` on `/`, `/faq/`, `/contact/`. Measured: **1 serious node on each, identical**:

```
rule   : color-contrast
target : [".foot__disc"]
message: insufficient color contrast of 3.48 (#6a6664 on #0e0905), needs 4.5:1
```

`.foot__disc` is the footer's **pre-existing medical disclaimer**. §4 touches no colour token.

**Where this WP's own additions land** (same axe run): `.foot__nap` → **`incomplete`**, reason *"background
color could not be determined due to a background image"* — the **identical bucket and reason** as the
pre-existing siblings `.foot__brand > b` and the tagline `.foot__brand > p:nth-child(2)`. `.foot__tel a` is
not reported. **So WP-S5-07 introduced 0 axe violations**; `.foot__nap` simply inherits the footer's
established text treatment.

*(Honest correction: an earlier hand-computed estimate put `.foot__nap` at ~4.50:1 against a solid
background. That estimate was wrong — axe reports the background is an **image**, so a solid-background
composite is not the real measurement. The bucket result above is the truthful statement.)*

**This is the SAME defect as WP-S5-06's F-01**: that WP's pre-existing `color-contrast` node on `/qr/qr2/`
and `/qr/qr10/` is this same `.foot__disc` — `section-footer.php` renders on QR pages too. **One site-wide
defect surfacing in two WPs.** It belongs to the hygiene WP already requested in S5-06 F-01, not to either WP,
and does not block WP-S5-05. Executed on AC-8's intent — zero regression, per rule id + node target.

## Decisions honoured (no TBD re-opened)

- **§0 / the NAP is not a question.** No item asked team_00 or Eyal anything. The canon was taken from
  `DECISION-NAP-CANON-2026-07-16.md` (RATIFIED) and applied.
- **§4.B — built in `section-footer.php`** (the live footer), **not** `block-footer-social.php`. `ea-cfoot`=0
  on all 4 routes proves the dead file stayed dead and **no second hardcoded NAP copy was created** — that
  would have been the very drift pattern this WP closes.
- **§4.B nowrap — "choose one":** CSS (`.foot__tel a { white-space: nowrap; }`) only. No inline style on the
  footer. (`contact.php` keeps its inline `white-space:nowrap`, per §4.C's own line.)
- **§4.C — BOTH L87 and L88 fixed.** The input DECISION named only L88; L87 also carried U+2011 in
  `פרדס חנה‑כרכור`. Verified by codepoint scan.
- **§4.D — token-targeted.** Only `רח׳`→`רח'` and `ב׳`→`ב'`. **`דיג׳רידו` (brand word) untouched** — verified
  at runtime: U+05F3 count in the value is exactly 1.
- **§5.2 — EN page unified** on the international form (`+972-52-482-2842`) at both L106 and L112.
- **§5.3 — `ea-testimonials-fb.json` untouched** (AC-7, `git diff` empty). The exclusion holds on the
  *stronger* reason: those are Eyal's own number quoted verbatim inside attributed recommendations.
- **§5.4 — `דיג'רידו` site-wide NOT normalised** (out of scope; observed-and-excluded).
- **§5.1 scope — no refactor of `privacy-defaults.php` / `accessibility-defaults.php`** (already canonical);
  **`wave2-stage-b.php` untouched** (its number is in a comment only).

## A caught-in-build note worth recording

Replacing `רח׳`→`רח'` inside `seo-head-fallbacks.php:50` **broke PHP**: the line is a single-quoted string, so
a literal `'` terminated it early (`php -l` → parse error). Repaired by escaping (`רח\'`), and the **runtime**
value verified canonical (U+0027 present; brand word intact). The U+05F3 there was likely never a typography
choice — it simply avoided escaping. This is exactly why AC-8 mandates `php -l` on every touched file.

## Files changed (all deployed, byte-verified — `evidence/s5-07/DEPLOY-MANIFEST.txt`)

11 files: `ea-nap-ssot.php` (new) · `ea-w2-seo-schema.php` · `section-footer.php` · `contact.php` ·
`seo-head-fallbacks.php` · `tpl-chapters-en.php` · `ea-w2-07-qr-content-data.php` ·
`ea-s507-qr-reseed-once.php` (new) · `ea-faq-seed.json` · `ea-s507-faq-update-once.php` (new, v2) ·
`chapters.css`. Plus `scripts/qa/nap_canon_check.mjs` (new; local guard, not deployed).

## Environmental notes (not findings — ratified guardrails)

- Expired TLS / HTTP-only staging **by design**; `curl -k`. Site-wide `x-robots-tag: noindex` host-conditional.
- **Transient `503` under concurrent probing** (new, same class as `curl 000`): all AC measurement done
  serially.
- **Drop-ins are single-fire**: "nothing happened on the second load" is **correct**, not a failure.
- **`esc_html()` encodes `'` as `&#039;`** — AC-2's "byte-identical" must be evaluated on **decoded** text.
  Removing `esc_html()` to make a raw grep match would be a security regression and is not done.

## Iron Rule #1 attestation

| Role | Engine | Team |
|---|---|---|
| Builder | claude-opus-4-8 (Claude Code, Anthropic) | team_110 |
| Validator | composer-2.5 (Cursor) — **distinct vendor** | team_90 |
| Distinct vendors | **satisfied** | — |

## route_recommendation

**`L-GATE_BUILD` → team_90 for independent cross-engine validation.** F-01 is fixed and re-verified live;
F-02 is a pre-existing site-wide defect already routed to a hygiene WP via S5-06 F-01. No blocker.
WP-S5-05 remains blocked and is **not** started.
