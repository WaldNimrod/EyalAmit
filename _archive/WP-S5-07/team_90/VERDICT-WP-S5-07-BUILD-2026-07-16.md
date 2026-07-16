---
id: VERDICT-WP-S5-07-BUILD-2026-07-16
from_team: team_90
to_team: team_110
cc: [team_00, team_100]
date: 2026-07-16
type: cross-engine-validation-result
wp: WP-S5-07
milestone: S005
gate: L-GATE_BUILD
mandate_ref: MANDATE-TEAM90-WP-S5-07-BUILD-2026-07-16
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-07-LOD400-2026-07-16.md
authority:
  - _COMMUNICATION/team_110/DECISION-NAP-CANON-2026-07-16.md
builder_verdict_ref: _COMMUNICATION/team_110/VERDICT-WP-S5-07-BUILD-2026-07-16.md
evidence_root_builder: _COMMUNICATION/team_110/evidence/s5-07/
evidence_root_validator: /tmp/team90_s507_validate/ + scripts/qa/reports/axe-http-2026-07-16.json
staging_base: http://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — WP-S5-07 BUILD (team_90 cross-engine validation)

## Verdict flag

**`PASS_WITH_FINDINGS`**

All 8 ACs independently reproduced **PASS** on live staging (serial `curl -sk` probes, 2026-07-16) plus repo code inspection. **AC-1 regression guard holds** — `ProfessionalService` byte-identical after the `ea_nap()` refactor. **AC-3 headline defect closed** — `/qr/qr32/` renders reachable `052-4822842`; standalone truncated `052-482284` = 0. **0 blockers · 0 major · 2 minor** (F-01 spec bug confirmed fixed; F-02 pre-existing axe baseline — not a build regression). Iron Rule #1 satisfied.

---

## Iron Rule #1

| Role | Engine | Team |
|------|--------|------|
| Builder | claude-opus-4-8 (Claude Code, Anthropic) | team_110 |
| Independent validator | composer-2.5 (Cursor) | team_90 |
| Distinct vendors | **satisfied** | |

---

## Per-item results

| # | Check | Result | Evidence reproduced (URL + HTTP + code + observed value) |
|---|-------|--------|----------------------------------------------------------|
| **1 — AC-1** (FIRST — regression guard) | **PASS** | Live **`/`** HTTP **200** — parsed Yoast `@graph` `ProfessionalService`: `name` = `"המרכז לטיפול בנשימה באמצעות דיג'רידו"` **IDENTICAL**; `alternateName` = `"cbDIDG"` **IDENTICAL**; `telephone` = `"+972-52-482-2842"` **IDENTICAL**; `address.streetAddress` = `"עמל 8 ב'"` **IDENTICAL**; `address.addressLocality` = `"פרדס חנה-כרכור"` **IDENTICAL** (vs `_COMMUNICATION/team_110/evidence/s5-07/schema-regression/ProfessionalService_BEFORE.json`). **Code — consumer refactor only:** `site/wp-content/mu-plugins/ea-w2-seo-schema.php:57` `name` → `ea_nap('name')`; `:58` `alternateName` → `ea_nap('alternate_name')`; `:61` `telephone` → `ea_nap('phone_schema')`; `:65–66` `streetAddress` / `addressLocality` → `ea_nap('street')` / `ea_nap('locality')`. SSoT: `site/wp-content/mu-plugins/ea-nap-ssot.php:21–31`. |
| **2 — AC-2** | **PASS** | Footer NAP on all four routes (decoded text — `esc_html()` encodes `'` as `&#039;`; compared after decode): **`/`** HTTP **200** — `foot__nap` = `"רח' עמל 8 ב', פרדס חנה-כרכור"`; `tel:+972524822842` → `052-4822842` inside `foot__brand`; `ea-cfoot`=**0**. **`/faq/`** — same NAP + tel; `ea-cfoot`=**0**. **`/contact/`** — same; `ea-cfoot`=**0**. **`/treatment/`** — same; `ea-cfoot`=**0**. **FAQ↔footer byte-match:** canonical token `עמל 8 ב'` (U+0027) count on `/faq/` decoded = **2** (FAQ answer + footer); geresh form `עמל 8 ב׳` (U+05F3) = **0**. Code: `site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-footer.php:35–37` reads `ea_nap('address_display')`, `ea_nap('phone_href')`, `ea_nap('phone_display')`. |
| **3 — AC-3** | **PASS** | **`/qr/qr32/`** HTTP **200** — rendered `<strong>052-4822842</strong>`; canonical phone count = **2**; standalone truncated `(?<![\d-])052-482284(?![\d])` = **0**. **S5-06 cross-check:** JSON-LD `VideoObject` = **2**; `ea-qr-facade` present in HTML. **Other QR pages unchanged:** `git diff -w site/wp-content/mu-plugins/ea-w2-07-qr-content-data.php` shows **one semantic change** — `qr32` phone `052-482284` → `052-4822842` (`:606`); spot-check **`/qr/qr1/`**, **`/qr/qr2/`**, **`/qr/qr10/`**, **`/qr/qr48/`** — bad standalone = **0** each. |
| **4 — AC-4** | **PASS** | **`/faq/`** HTTP **200** — `ניסוח בידול` count = **2** (from 0); `052-482-2842` = **0** (from 2); canonical `052-4822842` = **3**. Seed source: `site/wp-content/themes/ea-eyalamit/inc/data/ea-faq-seed.json` (`method-02` glow, `general-17` phone). |
| **5 — AC-5** | **PASS** | **`/faq/`** — `כמה עולה טיפול` = **2** (≥1); `מדיניות מחיר` = **2** (≥2); `עמל 8 ב` = **2** (≥1); `.ea-pending-approval` = **12** (≥10; spec predicted 11 — `method-02` renders twice, +1 expected). VERIFY-only surfaces unbroken. |
| **6 — AC-6** | **PASS** | `node scripts/qa/nap_canon_check.mjs` → exit **0** — 670 files scanned, **0** non-canonical NAP variants in scope. |
| **7 — AC-7** (scope — STOP-level) | **PASS** | `git diff --stat` **empty** for `site/wp-content/themes/ea-eyalamit/inc/data/ea-testimonials-fb.json` and `site/wp-content/themes/ea-eyalamit/inc/wave2-stage-b.php`. **`seo-head-fallbacks.php:50`** — `contact` meta: `דיג׳רידו` (U+05F3) **unchanged**; only `רח'` / `ב'` normalized (`רח\\' עמל 8 ב\\'`). Footer tagline U+05F3 count on **`/`** = **1** (`"דיג׳רידו"` in `foot__brand > p`) — brand word untouched per §4.D / §5.4. |
| **8 — AC-8** | **PASS on intent** | **`php -l`** — all 9 touched PHP files: **no syntax errors** (`ea-nap-ssot.php`, `ea-w2-seo-schema.php`, `ea-s507-qr-reseed-once.php`, `ea-s507-faq-update-once.php`, `section-footer.php`, `contact.php`, `seo-head-fallbacks.php`, `tpl-chapters-en.php`, `ea-w2-07-qr-content-data.php`). **`qa_probe.mjs`** (`--base http://eyalamit-co-il-2026.s887.upress.link --paths /,/contact/`) → verdict **PASS**, **4/4** `overflow: false` (mobile 375 + desktop 1440). **axe:** see F-02 — literal `exit 1`, **0 violations introduced**; `.foot__nap` lands in `incomplete` bucket only. |

---

## F-01 / F-02 adjudication

### F-01 — Spec §4.G drop-in self-disarms on `{ _note, count, items[] }` shape

**Ruling: CONFIRM (minor — finding against the SPEC, not the builder; builder fix verified).**

Independent reproduction against live JSON:

```
foreach ( $raw as $row )     → map size 0   (walks _note / count / items — none has seed_key)
foreach ( $raw['items'] … )  → map size 108 (both allow-list keys resolve)
```

Drop-in code (`site/wp-content/mu-plugins/ea-s507-faq-update-once.php:43` allow-list `['method-02','general-17']` only; `:53–62` reads `$raw['items']`; `:36` flag `ea_s507_faq_update_v2_done`) — **allow-list NOT widened**. Live `/faq/` confirms the v2 run succeeded: glow **2**, wrong phone **0**. The v1 bug would have burnt `ea_s507_faq_update_done` with zero DB writes — same class as WP-S5-06 spent-flag lesson.

**Disposition:** team_100 to annotate LOD400 §4.G (or errata) — the drop-in must iterate `$raw['items']`, not top-level `$seed`. Not a build blocker; fix is deployed and verified.

### F-02 — AC-8 axe `exit 0` unsatisfiable; pre-existing `.foot__disc`

**Ruling: CONFIRM (minor — pre-existing site-wide baseline; zero regression).**

Independent axe run (`node scripts/qa/http-qa-axe.cjs / /faq/ /contact/` from `scripts/qa/`, 2026-07-16):

```
/           HTTP 200  crit=0 serious=1
/faq/       HTTP 200  crit=0 serious=1
/contact/   HTTP 200  crit=0 serious=1
axe exit = 1
```

Detailed target probe (same run, `/`):

```
[violations]  color-contrast → .foot__disc          (pre-existing medical disclaimer)
[incomplete]  color-contrast → .foot__brand > b      (pre-existing)
[incomplete]  color-contrast → .foot__brand > p:nth-child(2)  (pre-existing tagline)
[incomplete]  color-contrast → .foot__nap           (ADDED by WP-S5-07 — same bucket/reason)
```

Code: `.foot__disc` at `section-footer.php:48` — WP-S5-07 touches no colour token. **Same root cause as WP-S5-06 F-01** (footer renders on QR pages too). **0 new, 0 worsened** vs builder baseline.

**AC-8 on stated intent (zero regression, RTL nowrap phone): PASS.** Literal LOD400 `axe → exit 0` remains unsatisfiable on this staging baseline → hygiene WP (already routed from S5-06 F-01), not S5-07-blocking.

---

## Validator notes (non-blocking)

- **Staging transport:** HTTP-only + expired TLS by design; all probes used `curl -sk`. Site-wide `x-robots-tag: noindex` host-conditional — not flagged.
- **AC-2 measurement:** raw HTML grep for literal `'` in footer finds `&#039;` — decode before comparing address tokens (ratified guardrail).
- **Substring guardrail:** `(?<![\d-])052-482284(?![\d])` used throughout — naive grep over `site/wp-content` reports false positives where `052-482284 ⊂ 052-4822842`.
- **NAP canon:** not re-opened; all checks verify conformance to `_COMMUNICATION/team_110/DECISION-NAP-CANON-2026-07-16.md` only.

---

## route_recommendation

**`L-GATE_BUILD` PASS.**

All 8 ACs independently verified on live staging. F-01 is a spec/documentation defect (fixed and re-verified live). F-02 is a pre-existing site-wide axe baseline (`.foot__disc` contrast 3.48) — zero regression from WP-S5-07. No `route_recommendation` back to team_110. WP-S5-05 remains out of scope for this validation pass.
