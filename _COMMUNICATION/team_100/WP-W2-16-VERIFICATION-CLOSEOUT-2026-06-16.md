# WP-W2-16 — Verification & Closeout (16-F)

**Date:** 2026-06-16 · **By:** team_100 (Claude Code, builder) · **Branch:** `wp-w2-16` (off `main`)
**Staging:** http://eyalamit-co-il-2026.s887.upress.link · **Theme ver:** 1.4.13
**Status:** ALL 5 BUILD BATCHES COMPLETE + INTERNAL QA PASS → **awaiting external dual-PASS** (team_50 → team_190)

> HARD RULE: no "ready" to Eyal until each batch's cross-engine dual-PASS. The Eyal
> update message (drafted: MSG-TO-EYAL-UPDATE-2026-06-16.md) is team_00's to send.

## Batches delivered
| Batch | Scope | Decision | Verify |
|---|---|---|---|
| **16-A** | Home hero background video — muted full-length loop, reduced-motion→poster | D-EYAL-VIDEO-13 = ב | poster+video live; overflow0; axe0/0 |
| **16-C** | FAQ sticky topic-nav (TOC) — anchor jump + scroll-spy; retired `<select>` | (#3, no decision) | 10/10 topic anchors; overflow0; axe0/0 |
| **16-D** | `/eyal-amit` canonical (flip from `/about`) + 4 shop pages in nav | D-EYAL-ABOUT-URL-15 = ב (#7/#9) | redirects single-hop, **0 loops**; /eyal-amit content-diff ACCURATE |
| **16-B** | Testimonials carousel (moving RTL marquee atom) — Home 15, service = page-specific + FB Top-5 | D-EYAL-TESTIMONIALS-14 = א (#2) | carousel live; overflow0; axe0/0 |
| **16-E** | Mokesh memorial **verbatim** from `ומה היום.docx`; bio+dates = placeholders pending Eyal | D-EYAL-MOKESH-16 (#8) | content-diff **ACCURATE 100%**; overflow0; axe0/0 |

## Site-wide gates (all GREEN @ 1.4.13)
- **content-diff (authoritative):** **17/17 measurable pages gatePass** (was 16/17 — mokesh now passes). 0 pages failing.
- **axe (S5 a11y):** **0 critical / 0 serious** across all 14 routes.
- **overflow (qa_probe @360/390/414/768):** **0 overflow** on every page touched (home, /faq, /eyal-amit, /eyal-amit/mokesh-dahiman, service pages).
- **Redirects:** `/about/`→`/eyal-amit/`, `/about/moksha/`+`/mokesh-dahiman/`+`/mokesh/`→`/eyal-amit/mokesh-dahiman/` — all **single-hop, no loops**.
- **Blog pagination (Eyal #6):** `/blog/page/2/` → 200 with 12 **distinct** posts (0 shared permalinks). Verified working.
- **validate_aos:** 0 FAIL. **php -l / node --check:** clean on every touched file.

## ⚠ Gate change to flag for validators
`scripts/qa/content-diff.mjs` docx reader was **fixed** (16-E): it joined ALL `<w:t>` runs
with a space, splitting words across runs (`של`→`ש ל`, `להיום`→`להי ום`) so a byte-verbatim
docx render could never match. Now extracts per `<w:p>` (runs no-sep, paragraphs newline).
**Only the docx source (mokesh) is affected**; thresholds + section logic unchanged. team_190
should confirm this parser fix is sound (it makes the gate correctly reward verbatim docx).

## Pending Eyal (placeholders, by design — route for final edit)
- Mokesh: **bio intro + birth/death dates (1950–2020)** + photos — flagged on-page (`ea-14e-note`) and await Eyal.
- 16-E verbatim preserves Eyal's exact text incl. `jungel vibes` (lowercase) — suggest Eyal confirm/brand-fix in final edit.
- Testimonials: more curated testimonials from Eyal later (D-14 "more content later") will extend the carousel.

## Commits on `wp-w2-16` (off `main` @ 82236f8 WP-15 closure)
16-A `2726e9b` · 16-C `1fc919e` · 16-D `073c414` · 16-B `6954ef4` · 16-E `46b0afb` · 16-B-fix `c6eabe3`
+ version bumps + QA evidence. `git diff main..wp-w2-16` = the full WP-W2-16 delta.

## Next (NOT done by builder)
1. **team_50** (cross-engine, E2E) → **team_190** (final validation) per ADR034 / Iron Rule #1+#5.
2. On dual-PASS: merge `wp-w2-16` → `main` (team_00 go), lock roadmap WP-W2-16*.
3. team_00 sends the drafted Eyal update; route mokesh to Eyal for final content edit.

**Evidence:** `_COMMUNICATION/team_100/evidence/wp-w2-16-{ac,b,d,e}-2026-06-16/`
