# PROGRAM PLAN — WP-W2-15 · Content reconciliation + Eyal-feedback fixes

**Date:** 2026-06-04 · **Author:** team_100 · **Trigger:** Eyal review (WhatsApp 14:23, 9 points) + `CONTENT-INTEGRITY-AUDIT-2026-06-04.md` (most content pages run team_35 *mockup* placeholder copy, not Eyal's text).

## 0. Problem & principle
The site **structure is built and locked** (WP-W2-14 family DONE/LOD500). The **text content is wrong** on most pages — implemented from the team_35 mockups' representative copy instead of Eyal's `.md` files. WP-W2-15 = **content-fill + targeted fixes into the existing structure. No structural rework.**

**Content SSoT:** `docs/.../from-eyal/תוכן לאתר 25.5.26/` (latest, 2026-05-25) — map in `INDEX-CONTENT-2026-05-25.md`. Each page's body is rebuilt **verbatim** from its source file, section by section.

**NEW gate dimension:** **CONTENT-ACCURACY** — team_50 runs a verbatim live-vs-source diff per page (target ≥95% of Eyal's sections present, no invented copy).

## 0.1 Operational prerequisite (team_00 / Eyal)
Eyal's Drive folder is **"Shared with me"** → **not** synced to our Mac (only `My Drive/TikTrack` syncs). New uploads (the About page) won't arrive automatically. **Action:** Eyal/Nimrod "Add shortcut to My Drive" on the shared folder (then it syncs), or send new docs explicitly. Until then we work from the repo `from-eyal/` copy (refreshed 2026-06-04).

## 1. Children (registered in roadmap)
| WP | Scope | Eyal pts | Source | Blocked? |
|---|---|---|---|---|
| **15-A** | **Blog pagination fix** (archive ignores `paged`; only page-1 posts ever show) + any structural bugs found | #6 | — (code) | no — **P0, do first** |
| **15-B** | Content reconciliation — **service/content pages**: `/method`, `/treatment`, `/sound-healing`, `/lessons`, home invented blocks, **+ `/eyal-amit` (About)** | audit, #7 | `method.md`, `treatment.md`, `sound_healing_final.md`, `lesons.md`, `homepage1-3 v2.md`, **`אודות - אייל עמית.md`** | no |
| **15-C** | Content reconciliation — **commerce**: `/muzza` + book-detail ×3 | #4, #5 | `MUZZA.md`, `eyal_tsva_FINAL.md`, `kushi_full.md`, `vekatavta.md` | no |
| **15-D** | **Reconcile 5 EXISTING shop pages** (tools-for-sale, bags, stands-storage, floor-stand, repair). *(team_190 F01/F03: the pages EXIST and return 200 with partial/mockup content — this is verbatim **reconcile + IA/nav verify**, NOT build-from-scratch.)* | #9 | `buy didgeridoo.md`, `bags for didg.md`, `stend for hanging.md`, `stend for playing.md`, `build didg.md` | no |
| **15-E** | **FAQ overhaul** — show ALL questions per page (not 3) + full FAQ page section TOC/jump-nav + **testimonials carousel** (more items, L↔R moving) | #1, #2, #3 | `FAQ FINAL.md` + testimonials source (**F05: Eyal-pending — real testimonials list**) | partial (carousel item list) |
| **15-F** | **Eyal-blocked**: Mokesh source decision (#8/H1), galleries/media real content, real testimonials list | #8, #2 | H1 decision, real gallery/testimonial/media lists | **yes — await Eyal** · *(About #7 moved to 15-B — source arrived F02)* |

## 2. Orchestration (phased)
- **Phase 1 (now, unblocked):** 15-A (blog P0) → 15-B + 15-C + 15-D content rebuilds (parallel worktrees, each owns its page render/content files; serialize-integrate → deploy → team_100 pre-flight content-check). 15-A first (isolatable bug).
- **Phase 2:** 15-E features (FAQ show-all + TOC; testimonials carousel) — needs a small team_35 design pass for the carousel + Eyal's testimonials list.
- **Phase 3 (blocked):** 15-F when Eyal uploads About + decides Mokesh source + supplies gallery/testimonial content.

## 3. Gate chain (per child)
S3 (team_10, content-rebuild from source) → S4 (team_80, D-14 zero-drift; no new tokens) → deploy → **team_100 pre-flight incl. CONTENT-ACCURACY diff (verbatim vs source) + 0-overflow + axe** → S5 team_50 (incl. **content-diff verdict**) → team_190 L-GATE_VALIDATE. Close on dual-PASS → merge → lock.

## 4. Acceptance (every content child)
- Live page body = Eyal's source **verbatim** (all sections, correct order); content-diff ≥95%; no invented/mockup copy remains.
- Structure/D-14 unchanged (ea-tokens.css untouched); axe 0/0; 0 overflow; per-route 200; single H1; RTL.
- Links/CTAs per source; internal links resolve.

## 5. Hard rules
Same as WP-W2-14: ADR034 named branch; surgical per-file commits (`Co-Authored-By: Claude Opus 4.8`); roadmap single-writer = team_100; cross-engine validate (team_190 Cursor); `validate_aos .` 0 FAIL + `php -l` clean each step. **Content is verbatim from the 25.5.26 source — no paraphrasing/invention.**

## 6. Priority order
15-A (blog P0) → 15-B method (0%) → 15-C muzza+books (0%) → 15-B treatment/sound-healing/lessons (~25%) → 15-E FAQ (#1+#3) → 15-D 5 shop pages (#9) → 15-E testimonials carousel (#2) → 15-F about/mokesh/galleries (await Eyal).

---

## ADDENDUM 2026-06-04 (Eyal — 2 uploads, fold into the package)

Both arrived in `from-eyal/תוכן לאתר 25.5.26/` (synced today).

### (i) About page content — UNBLOCKS #7
`אודות - אייל עמית/אודות - אייל עמית.md` — a complete **13-section FINAL** doc (Hero · journey · meeting the didgeridoo · teachers · the stolen didg & new path · cbDIDG · the center/studio · breath/research/recognition · books/stage/media · next generation · today · CTA · disclaimer).
- **Action:** move About out of 15-F (blocked) into the **Phase-1 build set** — full elevated `/eyal-amit` page from this source, verbatim. Folded into **15-B**. (15-F retains only the still-blocked: Mokesh source/H1, galleries/media real content, real testimonials list.)

### (ii) "דפים שלא אונדקסו" (non-indexed legacy pages) — NEW child 15-G
A Google Search Console "not indexed" export — 9 category files (soft-404 · noindex · alternate-with-canonical · redirect · 404 · crawled-not-indexed · duplicate-no-canonical · server-error), **406 legacy `eyalamit.co.il` URLs** (~174 after stripping `/feed//tag//category//qr/`+attachments; real-content subset smaller).
- **Scope (15-G — SEO/migration, route team_40 + team_20):** triage the 406 → (a) real content to preserve/redirect, (b) junk (feeds/dupes/attachments) to let 404/canonicalize; verify **301 coverage** vs the WP-W2-09 redirect map; confirm **new-site pages are indexable** (no stray `noindex`). Cross-check with #9 (unbuilt pages) so no real legacy content is dropped.
- Largely an SEO completeness pass; not content-rewrite. Lower urgency than 15-A–E but in-package.

---

## team_190 L-GATE_SPEC findings — RESOLUTION (verdict PASS_WITH_FINDINGS, 2026-06-04)
- **F01/F03 (P1):** 15-D reworded — the 5 shop pages **exist** (200, partial content); scope is **reconcile + IA/nav verify**, not build-from-scratch. ✔ (table updated; triage #9 reworded)
- **F02 (P1):** About source is in the repo; About **moved to 15-B** (Phase-1 build), removed from 15-F blockers. ✔
- **F05 (P2):** testimonials real list = **Eyal-pending** (15-F); 15-E carousel ships structure + uses existing/approved quotes until Eyal supplies the full list. ✔
- **F04 (P2) — CONTENT-ACCURACY measurable procedure:** per page, the gate runs `scripts/qa/content-diff.mjs` (to be authored under 15-A): (1) parse the source `.md` → ordered list of **section titles** + **content sentences (≥40 Hebrew chars)**; (2) normalise (strip md-links/markup, collapse whitespace, unify geresh/quotes) both source and live-rendered text; (3) compute **section-coverage** = % of source section titles present in live, and **sentence-coverage** = % of source sentences present verbatim. **PASS = section-coverage ≥95% AND 0 invented sections AND sentence-coverage ≥90%.** Output a per-page JSON + a miss-list. team_50 re-runs independently at S5.
- **F06 (P2) — `/faq` TOC AC:** the full FAQ page shows a **topic TOC at the top** listing every section (sound-healing / treatment / method / books / …); clicking a topic scrolls to its section (anchor); TOC is keyboard-operable (links, visible focus) and visible/sticky on mobile; each section has a clear divider/heading. Verified by team_50 (interaction + a11y).

**Status:** plan updated per F01–F06; **cleared to start Phase 1** (15-A → 15-B/C/D). No FAIL.
