# LOD400 Spec — S002-P001-WP001
# About Page — Content Completion + Hebrew Copy

**WP ID:** S002-P001-WP001 | **Track:** A | **Milestone:** S002
**Builder:** eyalamit_build (cursor-composer) | **Validator:** eyalamit_val (openai)
**Created:** 2026-04-12 | **Status:** PENDING L-GATE_S

---

## Objective

Complete all content on the About page (אודות) in Hebrew. Content must be sourced from
Eyal Amit's Drive materials or WhatsApp intake. No placeholder text.

---

## Acceptance Criteria

| AC | Criterion | Notes |
|----|-----------|-------|
| AC-001 | About page has full Hebrew bio (200–400 words) | From Drive/WhatsApp |
| AC-002 | Personal photo placed correctly | Alt text in Hebrew |
| AC-003 | Section titles in Hebrew, consistent with site-tree | Per `hub/data/site-tree.json` |
| AC-004 | No Lorem Ipsum or placeholder text | Full pass required |
| AC-005 | Mobile viewport renders correctly | No overflow, readable |
| AC-006 | Page saved + published on uPress staging | Verifiable URL |

---

## Content Sources

- Drive: `from-eyal/CONTENT/` — bio and self-description files
- WhatsApp intake: via `scripts/intake_new_content.py` if new content arrives
- Site tree reference: `hub/data/site-tree.json`

---

## Out of Scope

- SEO meta tags (covered in S002-P001-WP004)
- Design/layout changes
- English content

---

## Gate Sequence

```
L-GATE_E (arch) → L-GATE_S (arch, this spec) → L-GATE_B (builder) → L-GATE_V (openai)
```

L-GATE_S requires: eyalamit_sd (Nimrod) approval of scope + content source confirmation.
