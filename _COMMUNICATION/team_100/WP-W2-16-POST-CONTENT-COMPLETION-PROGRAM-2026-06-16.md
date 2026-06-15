# PROGRAM — WP-W2-16 Post-content completion (media · features · IA · verification)

**Date:** 2026-06-16 · **Author:** team_100 · **Trigger:** Eyal info round 2026-06-16 (homepage
video + 9 feedback points + re-confirmed Drive docs). Intake:
`_COMMUNICATION/team_100/INFO-ROUND-EYAL-2026-06-16.md`.

## 0. Premise (implications of the new info)
- **Drive docs = the `25.5.26` set we already built CR1–CR4 from** (unchanged in git). So Eyal's
  content complaints **#4 muzza, #5 books, #7 about, #9 shop** are **already resolved** (live-verified
  2026-06-16) — his view is pre-CR / cached. Implication: a **verification + cache-bust + re-check**
  round, NOT a rebuild.
- **#1 FAQ count** — service pages now render the **full** category (15 on /treatment); resolved by CR2.
- **Genuinely open build work:** **#2 testimonials carousel**, **#3 FAQ topic-nav (TOC)**.
- **#8 mokesh** — still shows non-source content (was WP-W2-15-CR5, Eyal-blocked).
- **#6 blog pagination** — fixed in 15-A; re-verify against Eyal's report.
- **Video (materials G1) is now UNBLOCKED** — Eyal delivered it. Compressed working files in
  `local/video-work/` (720p/6.1 MB muted hero + poster). Needs a treatment decision + integration.

## 1. Work package
**WP-W2-16 — Post-content completion**, parent of six ordered, canonical batches (CR-style; each
batch = 1 build+QA cycle, internal→external validation, same discipline as WP-W2-15).

| Batch | Scope | Eyal pts | Depends on | Ready? |
|---|---|---|---|---|
| **16-A** Homepage hero video | integrate compressed video as hero (autoplay/muted/loop) + poster; replace gradient; dequeue heavy bg elsewhere | G1 | **D-EYAL-VIDEO-13** | after decision |
| **16-B** Testimonials carousel | new moving (RTL↔LTR) carousel atom; wire across service/home pages; populate >3 | #2 | **D-EYAL-TESTIMONIALS-14** | after decision/content |
| **16-C** FAQ topic navigation | sticky topic menu on /faq → jump-to-section; clearer section separation | #3 | — | **YES** |
| **16-D** Navigation & IA polish | expose shop pages (didgeridoos/bags/stands-storage/stand-floor) in nav; resolve /eyal-amit URL | #7, #9 | **D-EYAL-ABOUT-URL-15** | after decision |
| **16-E** Mokesh memorial content | rebuild /about/moksha from Eyal's source (ex WP-W2-15-CR5) | #8 | **D-EYAL-MOKESH-16** (Eyal) | BLOCKED |
| **16-F** Verification & re-publish | bust staging cache; re-verify blog pagination (#6); confirm #1/#4/#5/#7/#9 closed; route team_50/team_190; Eyal re-check note | #1,4,5,6,7,9 | 16-A..D merged | partial-now |

## 2. Execution order
1. **Now (no decision needed):** 16-C (FAQ TOC) + the cache-bust/verify half of 16-F.
2. **On Principal/Eyal decisions:** 16-A (video) ← D-13 · 16-D (nav/URL) ← D-15 · 16-B (carousel) ← D-14.
3. **On Eyal content:** 16-E (mokesh) ← D-16.
4. **Close:** 16-F full external validation per batch (team_50 + team_190), then merge/lock.

## 3. Standing rules (inherit WP-W2-15)
ADR034 named branch per batch; verbatim content (no invention); locked atoms / ea-tokens.css untouched
unless a batch explicitly adds an atom (carousel) — then new atom + tokens reuse only; `php -l` clean;
content-diff PASS where content changes; 0-overflow @360/390/414/768 + axe 0/0 per batch; roadmap
single-writer = team_100; **no "ready" to Eyal until each batch's dual-PASS**.

## 4. Open decisions (canonical aos_decide — added to hub/data/decisions.json)
- **D-EYAL-VIDEO-13** — hero video treatment (muted loop / sound / trim).
- **D-EYAL-TESTIMONIALS-14** — carousel source & count (FB dataset / Eyal-curated / keep-3).
- **D-EYAL-ABOUT-URL-15** — "אייל עמית" canonical URL (/about vs /eyal-amit).
- **D-EYAL-MOKESH-16** — mokesh page source & content (docx-as-page + bio / docx-background-only).
Batches 16-A/B/D/E do not start until their decision resolves.

## 5. Next Eyal round (materials hub)
Update `materials-intake` with the still-needed-from-Eyal items: **more testimonials** (16-B),
**mokesh bio + source decision** (16-E), **video treatment confirmation** (16-A), and a **re-check
confirmation** for the 5 already-closed items. Drives the next info round.
