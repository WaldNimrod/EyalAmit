---
id: MANDATE-TEAM10-W2-03-BOOKS-2026-05-28
from_team: team_100 (Chief System Architect)
to_team: team_10 (Builder)
wp: WP-W2-03 — Muzza Publishing + 3 Book Pages
date: 2026-05-28
status: READY TO DISPATCH (awaiting team_00 go)
spec_ref: _aos/work_packages/S002/WP-W2-03/LOD400_spec.md
depends_on: WP-W2-02 (COMPLETE)
---

# Dispatch Mandate — WP-W2-03 (Books)

## 1. Scope
Build `/books` catalog + 3 book-detail pages (`/books/vekatavta`, `/books/kushi-blantis`, `/books/tsva-bekahol`) on a shared `tpl-book-detail` template, per the LOD400 spec. Content verbatim from the 25.5.26 sources (MUZZA.md, vekatavta.md, kushi_full.md, eyal_tsva_FINAL.md).

## 2. Build on existing infra (do NOT rebuild)
- Reuse W2-02's routing pattern: add `inc/wave2-w2-03.php` with a `template_include` (priority 100) router that maps book slugs → `tpl-book-detail.php` and `/books` → `tpl-books.php`, and calls `set_query_var('ea_wave2_shell', true)` so Stage-B asset hygiene applies. Append `require_once` in `functions.php`.
- D-14 tokens only; body class `ea-wave2-shell`; bump `style.css` Version (next slot after 1.4.1 — coordinate if another WP is mid-flight).

## 3. Acceptance criteria
Per LOD400 spec AC-01..AC-06. Green Invoice links + book covers are external/Eyal-dependent → use placeholders (`#` / grey) until provided; do not block on them.

## 4. Cross-engine chain (IR#1 — team_00 strict disposition 2026-05-28)
- Builder: team_10 (claude-sonnet acceptable).
- L-GATE_BUILD QA: team_50 — **MUST be non-Claude** (cursor-composer / codex).
- L-GATE_VALIDATE: team_190 — native Codex/GPT-5.
- Note: if builder runs on claude-sonnet, validator (team_50) must differ.

## 5. Branch
New feature branch `feature/w2-03-books` (W2-02/W2-06 currently share `feature/w2-06-blog`; keep W2-03 isolated to avoid the single-tree coupling we hit on W2-02/06). If working in the shared tree, enforce file-domain separation (book templates/router only) and surgical commits (never `git add -A`).

## 6. Deliverables
4 live staging URLs, `tpl-book-detail.php`, `inc/wave2-w2-03.php`, book cards on `/books`, completion report to `_COMMUNICATION/team_100/`.

## 7. Activation prompt (paste into a builder session on your go)
```
You are team_10 (builder) for the AOS eyalamit spoke. Build WP-W2-03 (Books).
Repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
Read the LOD400 spec: _aos/work_packages/S002/WP-W2-03/LOD400_spec.md and this mandate.
Build /books + 3 book-detail pages per the block contract, content verbatim from the
25.5.26 sources. Reuse W2-02's template_include routing pattern (new inc/wave2-w2-03.php,
set ea_wave2_shell query var). Deploy via scripts/ftp_deploy_site_wp_content.py. Verify all
4 URLs 200 + blocks render. Commit surgically (no git add -A). Report to _COMMUNICATION/team_100/.
```

*team_100 — 2026-05-28 — READY TO DISPATCH on team_00 go.*
