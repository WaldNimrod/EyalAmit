# A/B Contract Drift Fix — 2026-05-27

**From:** team_100 (Architect sub-agent)
**To:** team_10 (Implementation)
**Subject:** ea-ab-testing.js patched to canonical mandate contract
**Decision ref:** DECISION RECORD §2.1 — mandate is SSOT (Option 2a)
**team_50 verdict:** commit e773e5a — A/B contract drift flagged

---

## Files Changed

1. `site/wp-content/themes/ea-eyalamit/assets/js/ea-ab-testing.js`

No PHP/template consumers found for old variant names in:
- `template-parts/`
- `page-templates/`
- `inc/`

(Confirmed via grep — `inc/wave2-stage-b.php:147` uses `data-ea-ab="whatsapp"` only, not variant names or old key.)

---

## Key Changes (diff summary)

### 1. sessionStorage key

```diff
- var KEY = 'ea_wa_ab_variant';
+ var KEY = 'eyal_cta_variant';
```

### 2. variants array

```diff
- var variants = ['A', 'B', 'C'];
+ var variants = ['form_only', 'dual', 'wa_only'];
```

### 3. WhatsApp float conditional

```diff
- if (stored === 'A') {
+ if (stored === 'form_only') {
      wa.style.display = 'none';
  }
```

### 4. Form wrap conditional

```diff
- if (stored === 'C') {
+ if (stored === 'wa_only') {
      formWrap.style.display = 'none';
  }
```

### 5. JSDoc header updated

Old:
```
* B3 WhatsApp CTA A/B — variants A (form-only), B (dual), C (WA-only).
```
New:
```
* B3 WhatsApp CTA A/B — variants form_only (form visible, WA hidden),
* dual (both WA and form visible), wa_only (WA visible, form hidden).
* Canonical key: eyal_cta_variant (MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0)
```

---

## Verification Results

```
Check 1: ea_wa_ab_variant → 0 results  PASS
Check 2: eyal_cta_variant → 2 results  PASS
  ea-ab-testing.js:5  (JSDoc comment)
  ea-ab-testing.js:9  (KEY constant)
Check 3: no single-char variant values ('A','B','C') in ea-ab-testing.js  PASS
```

---

## Behavior Mapping (unchanged logic, renamed variants)

| Old name | New name    | WA float  | Contact form |
|----------|-------------|-----------|--------------|
| A        | form_only   | hidden    | visible      |
| B        | dual        | visible   | visible      |
| C        | wa_only     | visible   | hidden       |

---

## Status

Changes are unstaged. team_100 parent session to review and commit.
