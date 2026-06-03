# VISUAL-FIDELITY AUDIT — WP-W2-10 (mockup vs live) — team_100 → team_00 — v1.0

**Date:** 2026-06-03 · **Method:** headless screenshots of each team_35 mockup vs the live staging page, 1280/1000px desktop, full-page, side-by-side.
**Simplest way to view:** open `scripts/qa/reports/visual-audit/index.html` in a browser (5 side-by-side composites). Raw pairs: `scripts/qa/reports/visual-audit/CMP-*.png`.

## Honest headline
The earlier gates (axe / Lighthouse / block-presence / zero-drift) passed, but **none compared visual fidelity to the mockup**. They verified the page *has* the right blocks — not that it *looks* like the mockup. So a real, systemic visual defect shipped undetected. **team_00 was right: it does not look like the mockups.**

## 🔴 P0 — systemic, every page: doubled navigation
Every wave2 page renders the **GeneratePress legacy header** — white bar, legacy IA menu (בלוג / מוזה הוצאה לאור / כלים ואביזרים / EN…), social icons, **~182px tall, `display:block`, visible** (confirmed in DOM on `/`, `/treatment`, `/about`, `/books`, `/en`) — **above** the wave2 `ea-topnav`. The mockups have **only** the slim dark `ea-topnav`. Result: two different navigations stacked.
- **Cause:** wave2 templates call `get_header()` (emits GP masthead); nothing hides `.site-header`; `ea-topnav` is added on top.
- **Scope:** ALL wave2 pages, incl. the POC-approved home.
- **Worst on `/en`:** the GP header is Hebrew/RTL sitting above an English LTR page.
- **Design intent (team_00):** **one navigation only** → the GP header must be suppressed so `ea-topnav` is the sole nav (matches mockup).
- **Sub-decision:** `ea-topnav` currently lists בית/השיטה/טיפול/סאונד הילינג/שיעורים/ספרים/צור קשר — it is **missing** בלוג / EN / shop-categories that exist in the GP menu. Hiding GP header requires confirming/extending `ea-topnav`'s links so nothing becomes unreachable.

## Per-page findings (composition vs chrome)
| Page | Composition/body vs mockup | Real assets | Page-specific gap (beyond P0) |
|---|---|---|---|
| A `/treatment` | ✅ matches (hero, 4-step grid, tiles, bio, comparison, testimonials, FAQ, CTA band) | portrait wires | + a misplaced dark nav/footer panel beside the hero (part of the broken chrome) |
| B `/about` | ✅ body matches | **real portrait renders** ✓ | hero composition differs — mockup integrates portrait+name in one dark hero; live splits into a separate photo card + hero band |
| E `/books` | ✅ matches well | **real covers render** (better than mockup placeholders) ✓ | none beyond P0 |
| E `/books/vekatavta` | ✅ order matches | real cover ✓ | live page is **much taller** — far more body text than the mockup (long excerpt/body); verify not over-rendering |
| F `/en` | ✅ body matches (LTR, EN copy) | covers ✓ | P0 especially jarring (Hebrew RTL GP header over English page) |

**Note on fonts:** mockups load **Heebo**; live service/editorial pages use **Rubik** (books use Heebo). Minor but contributes to "feels different." Confirm desired body font.

## What is actually GOOD
Composition, block order, grids, cards, CTAs, RTL/LTR, and **real assets (covers + portrait) all render** — in places better than the mockups (which used placeholders). The build is sound; the failure is **chrome + a few per-page composition details**, not the body.

## Recommended remediation (priority order)
1. **P0 — one navigation:** suppress GP `.site-header` on wave2 pages (CSS `.ea-wave2-shell .site-header{display:none}` and/or stop emitting the GP masthead), leaving `ea-topnav` as the sole nav. First confirm/extend `ea-topnav` link set (blog/EN/shop) so nothing is orphaned. Re-deploy → re-validate (incl. **visual** check this time).
2. **B hero** — align the `/about` hero composition to the mockup (portrait+name in one dark hero).
3. **E detail length** — investigate the extra body text on book details vs mockup.
4. **Fonts** — decide Heebo vs Rubik for body.
5. **Process fix:** add a visual-fidelity step to the QA gate (mockup-vs-live screenshot diff) so this class of defect can't pass again. (Note: project now ships a browser-QA runner `_aos/lean-kit/.../qa/qa_probe.mjs` per the updated CLAUDE.md — fold a screenshot/box-model check into S5.)

## Governance note
All A/B/E/F are LOD500_LOCKED. These fixes reopen them — handle as post-closure remediation (build → S4 if CSS → deploy → pre-flight incl. visual → team_190 re-confirm), like the D1/D2 cycle. The P0 is significant enough to justify it.
