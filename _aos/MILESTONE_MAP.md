# MILESTONE_MAP.md — EyalAmit AOS Milestone Descriptions

## Pre-AOS History (completed before canonization)

| Phase | Period | Outcome |
|-------|--------|---------|
| M2 — Infrastructure | 2026-03-29 – 2026-04-04 | uPress staging, Docker local, FTP, WP seed, DB |
| M3 — Content & QA | 2026-04-04 – 2026-04-10 | Books POC, services content, Hub system v1, QA gates |
| M4 — Hub v2 + Books | 2026-04-10 – 2026-04-11 | Books v2, content-index, purchase-links, workflow button, push |

## AOS Stages

### S001 — AOS Canonization (ACTIVE)

**Goal:** Wrap the existing project in AOS governance structure.
Adds `_aos/`, `CLAUDE.md`, `.cursorrules`, `_COMMUNICATION/`, and registers in hub.
No changes to project code, scripts, or Hub system.

**WPs:**
- S001-P001-WP001: `_aos/` Foundation
- S001-P001-WP002: Root context files (CLAUDE.md + .cursorrules)
- S001-P001-WP003: Governance contracts + activation files
- S001-P001-WP004: `_COMMUNICATION/` canonical structure
- S001-P001-WP005: AOS hub registration

**Exit criterion:** `validate_aos.sh` exits 0 + teams 110+190 sign-off.

### S002 — Content Completion (PLANNED)

**Goal:** Complete remaining content pages (About, Method, Services, Home).
Pending: purchase URLs from morning.to, gallery media for books, SEO final review.

### S003 — Launch (PLANNED)

**Goal:** Go-live on production domain.
Pending: logo export (design team), WP template finalization, DNS cutover.
