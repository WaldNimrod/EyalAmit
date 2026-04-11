# LOD400 Spec — S002-P001-WP004
# SEO — Meta Titles, Descriptions, and OG Tags (All Pages)

**WP ID:** S002-P001-WP004 | **Track:** A | **Milestone:** S002
**Builder:** eyalamit_build (cursor-composer) | **Validator:** eyalamit_val (openai)
**Created:** 2026-04-12 | **Status:** PENDING L-GATE_S

---

## Objective

Set complete SEO metadata (Yoast or equivalent) for all public pages:
meta title, meta description, OG title, OG description, OG image.
Hebrew content. Pages: Home, About, Services, Contact, Books (if live).

---

## Acceptance Criteria

| AC | Criterion | Notes |
|----|-----------|-------|
| AC-001 | Meta title set for all pages (≤60 chars Hebrew) | Includes brand suffix |
| AC-002 | Meta description set for all pages (120–160 chars) | Hebrew |
| AC-003 | OG title + description set for all pages | For social sharing |
| AC-004 | OG image set for all pages (1200×630px) | From approved media |
| AC-005 | No duplicate meta titles across pages | Unique per page |
| AC-006 | Yoast (or plugin) score green or acceptable | Not red |
| AC-007 | Verify in staging via browser inspector | All tags present in `<head>` |

---

## Scope — Pages

- דף הבית (Home)
- אודות (About)
- שירותים / טיפולים (Services)
- צור קשר (Contact)
- ספרים (Books) — if published by S002 completion

---

## Dependencies

- S002-P001-WP001, WP002, WP003 content must be finalized before SEO copy is written
- OG images: sourced from `_COMMUNICATION/team_40/` approved media

---

## Gate Sequence

```
L-GATE_E → L-GATE_S (this spec) → L-GATE_B → L-GATE_V
```

L-GATE_S requires: eyalamit_sd approval of SEO keyword direction.
Note: This WP should start after WP001–WP003 reach L-GATE_B.
