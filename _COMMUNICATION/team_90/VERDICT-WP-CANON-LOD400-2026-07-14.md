---
id: VERDICT-WP-CANON-LOD400-2026-07-14
from_team: team_90 (cross-engine validator — cursor-composer)
to_team: team_100
cc: team_00
mandate: _COMMUNICATION/team_100/MANDATE-TEAM90-LOD400-DELTA-VALIDATION-WP-CANON-2026-07-14.md
prior_verdict: _COMMUNICATION/team_90/VERDICT-WP-CANON-LOD400-2026-07-14.md (FAIL — F90-01..F90-07, full read)
target_artifact: _COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD400-2026-07-14.md
date: 2026-07-14
type: cross-engine-validation-verdict
validation_pass: delta re-validation (F90-01/02/03 focus + F90-04..07 quick pass)
wp: WP-CANON-TEMPLATE-UNIFICATION
lod_status: LOD400
gate: L-GATE_SPEC (pre-build)
builder_engine: claude-sonnet-5 (Claude Code) — team_100
validator_engine: cursor-composer (team_90) — Iron Rule #1 satisfied (builder ≠ validator)
method: targeted read of §0.4, T3 §3.5.5/§3.6, T3b §3.0.f + §3.1–3.3, T4 §2.2/§2.3, T5 §4.3, T7 §5.3; line-level compare vs site/wp-content/themes/ea-eyalamit/inc/wave2-w2-05.php, wave2-w2-03.php, wave2-stage-b.php
---

# VERDICT — team_90 · LOD400 **delta re-validation** · WP-CANON-TEMPLATE-UNIFICATION

**Overall verdict: `PASS_WITH_FINDINGS`**

The §0.4 remediation closes all three material findings (F90-01, F90-02, F90-03). The LOD400 is **build-ready on the contract gaps that blocked the first run**, subject to one optional doc/code-nit on `ea_wave2_wa_url` verbatim fidelity (see delta finding D90-01 below — does **not** reopen F90-01 for product pages).

**Exit:** F90-01/02/03 **closed**. No open blockers or major items from the first validation pass. team_110 may proceed once remaining §0.2 team_00 micro-decisions are resolved for T6 execution (unchanged from prior verdict — not re-litigated here).

---

## 1. Delta scope (mandate)

| Prior ID | Severity | Delta question | Result |
|----------|----------|----------------|--------|
| F90-01 | blocker | `chapters-commerce.php` + §3.6 gate before w2-05 delete | **CLOSED** (residual D90-01) |
| F90-02 | blocker | Book purchase GA4 enqueue re-home + §3.6 row | **CLOSED** |
| F90-03 | major | T3b top-level schema fields ↔ T4 `ea_chapters_field` contract | **CLOSED** |
| F90-04 | minor | `ea_faq_query_items` in T4 | **CLOSED** |
| F90-05 | minor | Soften QR “forever/structural” wording | **CLOSED** |
| F90-06 | minor | `gi_url_map` line range 234–241 | **CLOSED** |
| F90-07 | minor | T4/T7 “79” + `lessons` on regular port path | **CLOSED** |

---

## 2. F90-01 — commerce accessor re-home (blocker)

### 2.1 §3.6 deletion gate

**PASS.** Rows for `wave2-w2-05.php` and `wave2-w2-03.php` (LOD400 ~L2636–2638) now require:

> **קודם**: לוודא ש-`chapters-commerce.php` (§3.5.5) כבר קיים ופעיל. **אז** מחק

This matches the remediation requested in the first verdict.

### 2.2 Four functions in §3.5.5 vs live code

| Function | Live source | Verbatim? | Product-page impact |
|----------|-------------|-----------|---------------------|
| `ea_w2_05_gi_url_map()` | `wave2-w2-05.php:234-241` | **Yes** | — |
| `ea_w2_05_gi_url()` | `wave2-w2-05.php:250-253` | **Almost** — LOD400 adds `trim()` around cast; map values are `''` today → same output | None |
| `ea_w2_05_price()` | `wave2-w2-05.php:261-265` | **Yes** | — |
| `ea_wave2_wa_url()` | `wave2-stage-b.php:23-26` | **No** — see D90-01 | None for `product-cta.php` (always passes explicit `$msg`) |

**Live `ea_wave2_wa_url` (stage-b):**

```php
function ea_wave2_wa_url( $msg = '' ) {
    $msg = ( '' !== $msg ) ? $msg : 'היי אייל, הגעתי דרך האתר ואשמח לקבל פרטים';
    return 'https://wa.me/' . EA_WAVE2_WHATSAPP_E164 . '?text=' . rawurlencode( $msg );
}
```

**LOD400 §3.5.5 proposal:** hardcoded `972524822842`, no default message when `$msg` is empty.

For the **stated F90-01 consumer** (`product-cta.php` T3 §2.1 ~L1192–1193), both versions produce the same URL when called with `'היי אייל, מתעניין/ת במוצר מהאתר ואשמח לפרטים'`.

**F90-01 blocker status: CLOSED** — undefined-function crash on 5 product pages is prevented; accessors are explicitly re-homed before delete.

---

## 3. F90-02 — book purchase GA4 enqueue (blocker)

### 3.1 Gate equivalence

**Live** (`wave2-w2-03.php:166-178`): enqueues when `ea_w2_03_is_wave2_page()` → book child of `books` with slug in `{vekatavta, kushi-blantis, tsva-bekahol}`.

**Proposed** (`ea_chapters_book_purchase_assets`, LOD400 ~L2609-2624): `is_page( array( 'vekatavta', 'kushi-blantis', 'tsva-bekahol' ) )`.

On the live site these three book pages are children of `books` with those slugs; Chapters already wins `template_include@103` but w2-03 enqueue still fires today. The flat slug gate covers the same three URLs in practice.

**Non-functional deltas (acceptable):** handle `ea-book-purchase` vs `ea-w2-03-purchase`; hook priority 20 vs 28; same script path `assets/js/ea-book-purchase.js`.

### 3.2 §3.6 row

**PASS.** `wave2-w2-03.php` row corrected from “ניתוב בלבד” to acknowledge live `ea_w2_03_purchase_assets()` and gates delete on `chapters-commerce.php`.

**F90-02 blocker status: CLOSED.**

---

## 4. F90-03 — T3b ↔ T4 Book schema contract (major)

### 4.1 T3b top-level fields (locked names + values)

| Book | `price` | `buy_print_url` | `buy_ebook_url` | Matches `cta_*` in same section? |
|------|---------|-----------------|-----------------|----------------------------------|
| vekatavta | 79 | mendele/vekatavta | mendele/vekatavta | Yes (§3.1 ~L1615-1620) |
| kushi-blantis | 69 | mrng.to/MTUiO3vkIg | mendele/kushibelantis | Yes (§3.2 ~L1691-1696) |
| tsva-bekahol | 59 | mendele/tsvabacholvezorekleyam | same | Yes (§3.3 ~L1771-1776; C-5 flagged) |

`genre` / `meta_year` / `meta_pages` intentionally `null` (except `meta_pages => 252` on vekatavta from existing prose) — documented in §3.0.f.

### 4.2 T4 consumption

**PASS.** Contract table (~L2029-2038) and sample `ea_w2_seo_schema_book_node()` (~L2057-2083) read the **same** field names via `ea_chapters_field()`.

**Null handling:** `ea_chapters_field()` (`chapters-render.php:145-154`) returns `''` when key is absent or `null` (`isset` false). T4 guards with `if ( $genre )`, `if ( $year )`, `if ( is_numeric( $pages ) )` — omits empty/null fields; does not emit sham values. **Correct.**

**Residual doc nit (non-blocking):** comment at T4 sample ~L2056 still says “placeholder” though §2.3 contract is locked — cosmetic only.

**F90-03 major status: CLOSED.**

---

## 5. F90-04..F90-07 — quick pass

| ID | Check | Result |
|----|-------|--------|
| F90-04 | T4 calls `ea_faq_query_items` (~L1950-1951), not `ea_chapters_faq_items` | **CLOSED** |
| F90-05 | F-5 (~L48) + T5 §4.3 (~L2350-2352) qualify structural guarantee with DB/permalink dependency | **CLOSED** |
| F90-06 | T3 cites `234-241` (~L1151, L1400) | **CLOSED** |
| F90-07 | T4 uses **79** (~L1920); `lessons` on regular port (~L1928); T7 §5.3 (~L2746-2748) aligned | **CLOSED** — no remaining “~62” or “lessons ללא FAQ” in T4/T7 body |

---

## 6. New delta finding (optional — does not block)

### D90-01 — minor — `ea_wave2_wa_url` labeled “verbatim” but rewritten

| | |
|---|---|
| **Severity** | minor (optional before build) |
| **LOD400** | §3.5.5 claims `ea_wave2_wa_url` relocated “verbatim” from stage-b |
| **Live truth** | Default message injection + `EA_WAVE2_WHATSAPP_E164` constant |
| **Impact** | **None** on 5 product pages (explicit message). **Possible** on no-arg callers still live today (`ea_wave2_render_whatsapp_float`, `wave2-stage-b.php:374`) if chapters-commerce definition loads first and stage-b is trimmed |
| **Fix (team_100)** | Either copy stage-b function exactly (incl. default msg + constant), or drop “verbatim” label and add one line: “no-arg callers must pass message or accept empty `?text`” |

---

## 7. Remediation gate (updated)

| ID | Severity | First pass | Delta status | Blocks build? |
|----|----------|------------|--------------|---------------|
| F90-01 | blocker | open | **closed** | No |
| F90-02 | blocker | open | **closed** | No |
| F90-03 | major | open | **closed** | No |
| F90-04 | minor | open | **closed** | No |
| F90-05 | minor | open | **closed** | No |
| F90-06 | minor | open | **closed** | No |
| F90-07 | minor | open | **closed** | No |
| D90-01 | minor | — | new (optional) | No |

---

## 8. Cross-engine attestation

| | |
|---|---|
| **Builder** | team_100 / Claude Code (claude-sonnet-5) |
| **Validator** | team_90 / cursor-composer |
| **Iron Rule #1** | Satisfied — builder engine ≠ validator engine |
| **Scope** | Delta spec validation only; **zero** changes under `site/` |
| **Recommended next owner** | team_100 — optional D90-01 wording/verbatim fix; team_110 may start build on LOD400 contract |

---

*Filed by team_90 · LOD400 **delta re-validation** · WP-CANON-TEMPLATE-UNIFICATION · 2026-07-14*
