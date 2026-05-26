---
mandate_id: MANDATE-TEAM30-B-PREP-2026-05-26
issued_by: team_10
issued_to: team_30
date: 2026-05-26
wp: WP-W2-01-STAGE-B-PREP
tasks: [B-PREP-3, B-PREP-7]
status: ISSUED
---

# Mandate — Team 30 | Stage B Prep Tasks

## Context
Wave2 Stage B parallel prep track. Team 100 is executing Stage A (LOD400 Design System spec) in parallel.
Your 2 tasks cover analytics infrastructure setup and child theme audit — both can proceed now without LOD400 spec.

**Project root:** `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/`
**Child theme:** `site/wp-content/themes/ea-eyalamit/`
**Hub data dir:** `hub/data/`
**Staging URL:** `http://eyalamit-co-il-2026.s887.upress.link`

---

## B-PREP-3 — GA4 + Microsoft Clarity Analytics Config

**Goal:** Create the analytics config JSON structure and preparation document. Eyal will supply the actual Measurement ID and Project ID after creating the accounts — your job is to build the skeleton and write the integration instructions.

**Steps:**

1. Create `hub/data/analytics-config.json`:
```json
{
  "ga4": {
    "measurement_id": "__PENDING_EYAL__",
    "stream_id": "__PENDING_EYAL__",
    "ab_variant": "",
    "gtag_snippet": "<!-- GA4: insert gtag.js snippet here after Eyal provides measurement_id -->"
  },
  "clarity": {
    "project_id": "__PENDING_EYAL__",
    "ab_variant": "",
    "clarity_snippet": "<!-- Clarity: insert clarity tracking snippet here after Eyal provides project_id -->"
  },
  "status": "PENDING_CREDENTIALS",
  "prepared": "2026-05-26",
  "prepared_by": "team_30"
}
```

2. Write `_COMMUNICATION/team_30/ANALYTICS-CONFIG-PREP-2026-05-26.md` with:
   - How Eyal creates a GA4 property (Google Analytics > Admin > Create Property)
   - Where to find the Measurement ID (G-XXXXXXXXXX)
   - How Eyal creates a Clarity project (clarity.microsoft.com > New Project)
   - Where to find the Project ID
   - Where these IDs get entered (hub/data/analytics-config.json fields)
   - The GA4 gtag.js snippet template to add to the WP theme's `<head>` (via functions.php `wp_enqueue_scripts`)
   - The Clarity snippet template for functions.php
   - Note: implementation of snippets in theme awaits Stage A LOD400 spec completion

**Deliverables:**
- `hub/data/analytics-config.json`
- `_COMMUNICATION/team_30/ANALYTICS-CONFIG-PREP-2026-05-26.md`

---

## B-PREP-7 — Child Theme Audit

**Goal:** Read all files in the `ea-eyalamit` child theme and produce a categorized audit. Each file gets a verdict: `keep` / `refresh` / `delete` with a one-line rationale.

**Theme location:** `site/wp-content/themes/ea-eyalamit/`

**Known files to audit:**
- `functions.php` (768 lines)
- `style.css`
- `header.php`
- `footer.php`
- `page-templates/template-home-dashboard.php`
- `page-templates/template-galleries-catalog.php`
- `page-templates/template-faq-catalog.php`
- `page-templates/template-books-hub.php`
- `page-templates/template-book-detail.php`
- `page-templates/template-treatment.php`
- `page-templates/template-method.php`
- `assets/css/home-front.css`
- `assets/css/services.css`
- `assets/css/books-wave1.css`
- `assets/css/books-v2.css`
- `assets/css/theme-shell-fallback.css`
- `assets/js/books-reveal.js`
- Any other files found (list all)

**Categorization rules:**
- `keep` — unchanged for Wave2; solid, Wave1-tested, no refresh needed
- `refresh` — needs update/rewrite per Wave2 LOD400 spec (mark as "awaiting spec")
- `delete` — dead code, superseded, or no longer needed

**Deliverable:** `_COMMUNICATION/team_30/CHILD-THEME-AUDIT-2026-05-26.md`

Format:
```markdown
# Child Theme Audit — ea-eyalamit | 2026-05-26

## Summary
- keep: N files
- refresh: N files (awaiting LOD400 spec)
- delete: N files

## File Verdicts

| File | Verdict | Rationale |
|------|---------|-----------|
| functions.php | refresh | Core theme setup — needs W2 design token hooks |
| style.css | refresh | CSS custom properties will be replaced by LOD400 tokens |
| ... | ... | ... |

## Refresh Queue (awaiting LOD400 spec from team_100)
[list files marked refresh with brief note on what LOD400 will determine]

## Delete Queue
[list files to delete with rationale]
```

---

## Acceptance Criteria

- [ ] B-PREP-3: `hub/data/analytics-config.json` exists with correct structure and `status: PENDING_CREDENTIALS`
- [ ] B-PREP-3: `ANALYTICS-CONFIG-PREP-2026-05-26.md` written with complete Eyal instructions
- [ ] B-PREP-7: `CHILD-THEME-AUDIT-2026-05-26.md` written with verdict for every file in the theme
- [ ] B-PREP-7: Audit summary counts (keep/refresh/delete) present

## Iron Rules Reminder
- Write ONLY to `_COMMUNICATION/team_30/`, `hub/data/`, and application source dirs
- Do NOT write to `_aos/`
- No inline scripts or ES modules per team_30 Iron Rules
- API-only mutations when AOS DB is online

## Report When Done
Write completion status to `_COMMUNICATION/team_30/B-PREP-COMPLETION-TEAM30-2026-05-26.md` with AC checklist results, then notify team_10.
