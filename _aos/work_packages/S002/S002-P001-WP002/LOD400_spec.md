# LOD400 Spec — S002-P001-WP002
# Home Page — Hero Copy + Section Content Completion

**WP ID:** S002-P001-WP002 | **Track:** A | **Milestone:** S002
**Builder:** eyalamit_build (cursor-composer) | **Validator:** eyalamit_val (openai)
**Created:** 2026-04-12 | **Status:** PENDING L-GATE_S

---

## Objective

Complete all text content on the Home page (דף הבית) — hero headline, subheadline,
and all section body copy. Content in Hebrew, sourced from Eyal's materials.

---

## Acceptance Criteria

| AC | Criterion | Notes |
|----|-----------|-------|
| AC-001 | Hero headline set (Hebrew, ≤8 words) | Eyal-approved |
| AC-002 | Hero subheadline / tagline set (Hebrew) | From Drive materials |
| AC-003 | All homepage sections have body copy (no placeholders) | Full review |
| AC-004 | CTA buttons have final Hebrew labels | Consistent with nav |
| AC-005 | Mobile viewport renders correctly | No overflow |
| AC-006 | Page saved + published on uPress staging | Verifiable URL |

---

## Content Sources

- Drive: `from-eyal/CONTENT/` — taglines, descriptions
- Existing staging content to review for gaps
- WhatsApp intake if new content needed

---

## Out of Scope

- SEO meta tags (S002-P001-WP004)
- Visual design changes
- Navigation changes

---

## Gate Sequence

```
L-GATE_E → L-GATE_S (this spec) → L-GATE_B → L-GATE_V
```

L-GATE_S requires: eyalamit_sd approval of hero copy direction.
