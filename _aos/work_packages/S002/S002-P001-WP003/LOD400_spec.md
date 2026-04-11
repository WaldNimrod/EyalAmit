# LOD400 Spec — S002-P001-WP003
# Services Page — Offerings Content + Pricing

**WP ID:** S002-P001-WP003 | **Track:** A | **Milestone:** S002
**Builder:** eyalamit_build (cursor-composer) | **Validator:** eyalamit_val (openai)
**Created:** 2026-04-12 | **Status:** PENDING L-GATE_S

---

## Objective

Complete the Services page (שירותים / טיפולים) with all offerings, descriptions,
and pricing in Hebrew. Content from Eyal's approved materials only.

---

## Acceptance Criteria

| AC | Criterion | Notes |
|----|-----------|-------|
| AC-001 | All service offerings listed with Hebrew titles | Per Eyal's catalog |
| AC-002 | Each offering has description (50–150 words Hebrew) | No placeholders |
| AC-003 | Pricing populated where Eyal has approved | Exact figures from intake |
| AC-004 | Booking/contact CTA per service | Link target confirmed |
| AC-005 | Mobile viewport renders correctly | Cards/grid responsive |
| AC-006 | Page saved + published on uPress staging | Verifiable URL |

---

## Content Sources

- Drive: `from-eyal/CONTENT/` — services list and pricing
- WhatsApp intake for pricing if not in Drive

---

## Out of Scope

- SEO (S002-P001-WP004)
- Payment integration
- Booking system integration

---

## Gate Sequence

```
L-GATE_E → L-GATE_S (this spec) → L-GATE_B → L-GATE_V
```

L-GATE_S requires: eyalamit_sd confirmation of services list + pricing.
