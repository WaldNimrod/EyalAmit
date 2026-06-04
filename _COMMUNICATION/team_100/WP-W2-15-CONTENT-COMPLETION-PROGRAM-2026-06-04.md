# PROGRAM — Content completion to 100% (WP-W2-15 reconciliation, right-sized + validated)

**Date:** 2026-06-04 · **Author:** team_100 · **Trigger:** team_90 full content-accuracy audit = **33.64% overall (32% weighted), 0/17 pages pass**. Premature "ready" message to Eyal = process failure to correct.

## 0. Hard rule (the fix for the failure)
**No "ready"/sign-off to Eyal until the FINAL full-site content audit shows every sourced page ≥ the gate.** "Done" = measured, not asserted. Every page closes only on a CONTENT-ACCURACY **PASS** (section-cov ≥95% · sentence-cov ≥90% · 0 invented sections), re-measured by `content-diff.mjs`.

## 1. Session sizing (data-driven — measured source volume)
Source docs (`25.5.26/`): 16 sourced pages, ~138k chars / ~27.7k words. Per-doc size: **XL** method 14.2k · treatment 14.8k · faq 14.7k · books-tsva 11.8k · books-vekatavt 11.4k · books-kushi 10.9k · sound-healing 10.8k · lessons 10.5k; **L** didgeridoos 9.8k · about 9.2k · home 8.5k · stand-floor 6.9k; **M** muzza 4.9k (+ bags / stands-storage / repair ≈ M–L).

**Sizing rule → 1 page = 1 build sub-agent** (an XL ~14k-char / 14-section doc is the ceiling for one focused, accurate session that reads source + rewrites the page render verbatim + self-verifies). Only **M/S pages pair**. This keeps each session small enough for **accuracy + speed**, with a clean handover when the page passes content-diff.

**Orchestrator session = 1 batch (3–4 pages)** → dispatches the page sub-agents in parallel worktrees, integrates, deploys, pre-flights. Handover when the batch passes its gate.

## 2. The work-package sequence (batches, worst-first)
| WP | Pages (source) | curr. acc. | Build |
|---|---|---|---|
| **15-CR1** (worst) | `/muzza` (3.3%), `/method` (8.6%), `/eyal-amit` (12.3%), `/` home (18.6%) | ~10% | 4 ∥ sub-agents |
| **15-CR2** (services) | `/treatment`, `/sound-healing`, `/lessons`, `/faq` (~20–25%) | ~22% | 4 ∥ |
| **15-CR3** (commerce) | `/books/tsva` (63.6%), `/books/kushi`, `/books/vekatavt`, `/muzza`-bundle | ~50% | 3–4 ∥ |
| **15-CR4** (shop) | `/didgeridoos`, `/bags`, `/stands-storage`, `/stand-floor` (63.5%), `/repair` (4%) | ~40% | 5 ∥ (2 batched if needed) |
| **15-CR5** (Eyal-blocked) | `/mokesh` (source decision H1), `/galleries`, `/media` (real content) | — | await Eyal |
| **15-CR-FINAL** | FULL-site re-audit + external validation + sign-off | — | gates only |

Per batch: each page sub-agent rebuilds its render to carry the source **verbatim** (every SECTION, correct order, CTAs/links per source), reusing the existing (locked) structure/atoms — **no structural rework, no new tokens**.

## 3. Validation model (internal sub-agents + external + full end-to-end)
**A. INTERNAL (every page, before handover):**
1. **Build sub-agent** rewrites the page from source.
2. **Adversarial verify sub-agent** (separate) runs `content-diff.mjs` on the live/local render + checks: all source sections present & ordered, 0 invented blocks, CTAs/links match. Returns the measured % + miss-list. Page is "build-done" only at **PASS**.
**B. EXTERNAL (per batch):** team_100 pre-flight (content-diff all batch pages + 0-overflow + axe) → **team_50** (independent content-diff verdict) → **team_190** L-GATE_VALIDATE (cross-engine). Close batch on dual-PASS → merge → lock.
**C. FINAL (15-CR-FINAL, after all batches):** **team_90** re-runs the FULL content-accuracy audit (target: every sourced page ≥ gate, overall ≈100%) + **team_190** full-site cross-engine L-GATE_VALIDATE + **team_50** full E2E. **Only on this triple-PASS** does content reach "ready" → team_00 may sign off to Eyal.

## 4. Handover protocol (timing)
- **Sub-agent → orchestrator:** at page content-diff PASS (build-done) + committed in its worktree.
- **Batch → next batch:** at batch external dual-PASS (team_50+team_190) + merge/lock. Batches are serialized at integration; pages within a batch are parallel.
- **Program → team_00/Eyal:** ONLY at 15-CR-FINAL triple-PASS.
- Each handover carries: measured %, miss-list (if any), evidence JSON.

## 5. Acceptance (every page)
CONTENT-ACCURACY PASS (section ≥95% · sentence ≥90% · 0 invented) · structure/D-14 unchanged (ea-tokens.css untouched) · axe 0/0 · 0 overflow · 200 · single H1 · RTL · links/CTAs per source.

## 6. Standing rules
ADR034 named branch per batch; surgical commits (`Co-Authored-By: Claude Opus 4.8`); roadmap single-writer = team_100; `validate_aos .` 0 FAIL + `php -l` clean; **content VERBATIM from 25.5.26 — zero paraphrase/invention** (this is the whole point). Commit `content-diff.mjs` + team_90 evidence into the repo (team_90 left them uncommitted).

## 7. Priority / order
15-CR1 → 15-CR2 → 15-CR3 → 15-CR4 → (15-CR5 when Eyal delivers) → **15-CR-FINAL**. Blog #6 (15-A) already fixed. FAQ TOC (#3) + testimonials carousel (#2) fold into 15-CR2 (faq) / a feature pass after CR-FINAL or in parallel where unblocked.
