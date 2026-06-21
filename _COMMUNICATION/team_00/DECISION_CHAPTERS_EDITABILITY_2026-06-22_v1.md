---
id: DECISION_CHAPTERS_EDITABILITY_2026-06-22_v1
title: "Editability architecture for the 'Chapters' (פרקים) WordPress redesign"
date: 2026-06-22
decided_by: team_00 (Nimrod) via /AOS_decide
prepared_by: team_100 (Chief Architect, claude-code)
status: DECIDED
branch: chapters-home
related: CHAPTERS-HOME-IMPLEMENTATION-PLAN, HANDOFF_100_DESIGN-PACKAGE
---

# Decision

**Editability mechanism for the Chapters design system = ACF Pro** (Option A), with
**code-registered local field groups** bound to page templates and a **theme-native
duplicate-page action** (no extra plugin).

# Context / constraint balanced

Owner requirement (refined): Eyal must be able to edit **content only — mainly images and
texts — and duplicate/add pages built on existing templates**. He does **not** need to
create or modify templates. The decision balanced **final-product quality vs development
convenience vs time** against that bounded editability need. Current theme: GeneratePress
child, classic PHP template-parts, content hardcoded; NO ACF/meta-boxes/custom-blocks;
deploy ships theme + mu-plugin allowlist via FTP (not regular plugins).

# Options considered

| Option | Verdict |
|---|---|
| **A — ACF Pro, code-registered field groups** | **CHOSEN** |
| B — Native theme-built meta boxes / settings screen (no plugin) | rejected — highest dev time; repeater UIs hand-built |
| C — Native Gutenberg blocks | rejected — heaviest build; layout-integrity risk; paradigm shift from classic-PHP theme |

# Rationale

- Exact fit for "edit text/images + duplicate/add pages on existing templates" with the
  **lowest dev time** and **highest editor quality**.
- Repeaters (timeline, for-whom, session cards, testimonials, steps) are **built-in** — no
  custom admin UI to build/maintain.
- Field definitions live in **version-controlled theme PHP** (`acf_add_local_field_group`)
  → deploy via the normal FTP pipeline, reproducible, no manual field setup in wp-admin.
- The **design stays locked in render PHP** (token classes), so editors cannot break layout.
- Accessor layer (`ea_chapters_field()/ea_chapters_rows()`) returns seeded defaults when a
  field is empty **or ACF is inactive** → the page never white-screens.

# Costs / operational notes

- **ACF Pro license** (~$49/yr) + **one-time plugin install per environment** (staging, then
  prod). ACF is a regular plugin — **NOT** added to the mu-plugin FTP allowlist; installed via
  Plugins → Add New → Upload, then activated + licensed.
- Duplicate/add-pages: theme-native `page_row_actions` "שכפל" → `admin_post` clone copying
  `_wp_page_template` + all ACF meta (capability + nonce checked). No duplicate-page plugin.

# Sub-parameters (defaults applied; owner did not override)

- Duplicate tool: **theme-native hook** (no extra plugin).
- ACF Pro acquisition/install: to be done on staging → prod during Phase 3 cutover.
