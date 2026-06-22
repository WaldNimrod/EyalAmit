---
id: DECISION_CHAPTERS_INNER_ACF_2026-06-22_v1
title: "Inner-page editability (ACF) architecture + content/validation sequencing — Chapters"
date: 2026-06-22
decided_by: team_00 (Nimrod) via /AOS_decide
prepared_by: team_100 (Chief Architect, claude-code)
status: DECIDED
branch: chapters-home
related: DECISION_CHAPTERS_EDITABILITY_2026-06-22_v1, CHAPTERS-CONTENT-DECISIONS-EYAL.md
---

# Decision

1. **ACF mechanism for inner/content pages = Option B** — free-ACF **named WYSIWYG fields** per page
   (main texts + images per section; structure stays code-defined; no add/reorder of sections).
   No ACF Pro. Consistent with DECISION_CHAPTERS_EDITABILITY (free ACF, "edit content not templates").
2. **Sequencing = Option C** — **validate first (external cross-engine), then build B.**
   The content is already accurate + version-controlled, so we do NOT build the ACF layer on a
   structure the validation might change.
3. **GLOBAL standard** — this approach (free-ACF named fields, render-locked design, validate-then-ACF)
   is hereby the **standard for ALL pages on the site**, not just package 1. Future page types follow it.

# Content state (context)

- All 5 package-1 inner pages + home render the **full approved content, verbatim** from the SSoT
  (`docs/.../תוכן לאתר 25.5.26/*.md`). Rule (team_00): site content is authoritative; the mockup gives
  design + media only. **0 missing/altered content.**
- content-diff residual is fully accounted for and contains **no unapproved deviation**:
  - **Punctuation/typo** (Hebrew maqaf `ל־`, hero-section parsing) — content present; allowed typo/spelling exception.
  - **Brand «סטודיו נשימה מעגלית»** — removed per WP-06; **approved deviation** (team_00).
  - **Testimonials** — pages show the FB-corpus marquee, not the source's full verbatim testimonials →
    **escalated to Eyal** (hub `eyal-pending`: OPEN-CHAPTERS-TESTIMONIALS + `docs/CHAPTERS-CONTENT-DECISIONS-EYAL.md`).
    Decided at the Eyal meeting (≈2026-06-23 evening).

# Next steps
1. Document gap in the **client hub** (eyal-pending) + Eyal follow-up package — DONE.
2. **External cross-engine validation** of the design + content (Iron Rule #1, builder≠validator).
3. After validation + Eyal's testimonials call → build **B** (free-ACF named fields) across all pages.
4. Then dual-PASS → merge `chapters-home` → main → prod deploy (on Nimrod מאשר/פוש).
