---
id: MANDATE-TEAM90-L-GATE_BUILD-WP-CANON-TEMPLATE-UNIFICATION-2026-07-14
from_team: team_110
to_team: team_90
cc: team_00, team_100
date: 2026-07-14
type: mandate
wp: WP-CANON-TEMPLATE-UNIFICATION
gate: L-GATE_BUILD
builder_engine: cursor-composer (team_110) — Iron Rule #1: validator must use a DIFFERENT engine
---

# MANDATE — team_90 · L-GATE_BUILD · WP-CANON-TEMPLATE-UNIFICATION

## Authority

team_110 holds ADR045 `execution_authority: full` for this WP (team_00 handoff 2026-07-14). You are mandated to independently validate the **implementation** (not the LOD400 spec — already PASS_WITH_FINDINGS).

## Spec SSOT

`_COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD400-2026-07-14.md`

## What was built (T1–T7)

| Task | Summary |
|------|---------|
| T1 | Mokesh media: `mokesh-hero`, `fbembeds`, `tpl-chapters-mokesh`, Person+VideoObject |
| T2 | FAQ many-to-many: `ea_faq_cat` + `ea_faq_query_items` + seed JSON + seed-once mu-plugin |
| T3 | `product-cta.php` on 5 product pages; dual `ea-ab-testing` enqueue fixed |
| T3b | Book dual CTAs + price + galleries + top-level schema fields; C-5 PENDING on tsva URL |
| T4 | FAQPage + Book nodes in `ea-w2-seo-schema.php` |
| T5 | `/shop` + `/qr` + pattern-route `/qr/qrN/`; hub link grid; QR CSS in chapters.css |
| T6 | `chapters-commerce.php`; freeze tpl-home + stage-b; deleted Wave2 Group A/B/C partial; **kept** w2-07 (/press), w2-08 |
| T7 | content-diff PAGE_MAP extended; staging FTP deploy; QR HTTP matrix |

## Required validation (independent)

1. Reproduce smoke: `/shop/`, `/qr/`, all `/qr/qrN/` → 200; Chapters markers present.
2. `qa_probe.mjs` on key paths (mokesh, shop, qr2, treatment, books, products).
3. Confirm `chapters-commerce.php` loaded; product CTAs + book purchase script alive after Wave2 deletes.
4. FAQ: after `ea-faq-seed-once` option `ea_faq_seed_v1=done`, `/faq/` and mini-FAQ pages non-empty.
5. Schema: FAQPage/Book/Person(mokesh)/VideoObject present where expected; no VideoObject on muted-hero prohibition violation.
6. File grep: wave2-w2-05/03 deleted; w2-07 kept; no undefined commerce functions.

## Verdict target

Write `_COMMUNICATION/team_90/VERDICT-WP-CANON-L-GATE_BUILD-2026-07-14.md` with PASS / PASS_WITH_FINDINGS / FAIL + evidence paths.

**Do not self-validate on Cursor Composer if that was the builder engine for the slice you review** — use Claude Code / GPT / other engine per Iron Rule #1.
