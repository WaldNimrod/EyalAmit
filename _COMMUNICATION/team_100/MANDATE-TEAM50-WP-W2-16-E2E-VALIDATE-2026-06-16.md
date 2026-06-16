# MANDATE — team_50: WP-W2-16 E2E build-gate validation

**From:** team_100 (Chief Architect, builder = **Claude Code**) · **To:** team_50 (E2E validator)
**Date:** 2026-06-16 · **WP:** WP-W2-16 (post-content completion) · **Branch:** `wp-w2-16` (off `main`)
**Staging:** http://eyalamit-co-il-2026.s887.upress.link · **Theme ver:** `1.4.13`
**Gate:** L-GATE_BUILD (E2E). **Cross-engine (Iron Rule #1):** you are NOT Claude — run in
Cursor/Codex/Composer. **Order:** your PASS is the precondition for team_190 (Iron Rule #5).

## ⚠ Precondition (already satisfied — confirm, don't skip)
The content-accuracy gate's docx parser was **fixed and landed to `main`** (commit `88160bd`):
it previously space-joined Word `<w:t>` runs (`של`→`ש ל`), so a byte-verbatim docx render
(mokesh) could never pass. **Run the gate from `main` or `wp-w2-16`** (both carry the fix) —
NOT an older checkout. Sanity: `node -e "import('./scripts/qa/content-diff.mjs').then(m=>m.readSource('מוקש דהימן/ומה היום.docx','docx',m.DEFAULT_CONTENT_ROOT).then(r=>console.log(r.text.includes('להיום')&&!r.text.includes('ש ל '))))"` must print `true`.

## What was built (5 batches — verify each end-to-end)
| Batch | Deliverable | Decision/Eyal |
|---|---|---|
| 16-A | Home hero **video** (muted full-length loop; reduced-motion→poster) | D-13=ב |
| 16-C | **FAQ topic TOC** (sticky, scroll-spy, jump-to-section; old `<select>` retired) | #3 |
| 16-D | **`/eyal-amit` canonical** (flipped from `/about`) + 4 shop pages in nav | D-15=ב, #7/#9 |
| 16-B | **Testimonials carousel** (moving RTL marquee; Home 15, service = page-specific + FB Top-5) | D-14=א, #2 |
| 16-E | **Mokesh memorial verbatim** from `ומה היום.docx`; bio+dates = placeholders pending Eyal | D-16, #8 |

## Required checks (commands + expected)
1. **content-diff (authoritative):** `node scripts/qa/content-diff.mjs --base <staging> --out <your-evidence-dir>` → **17/17 measurable pages gatePass** (esp. `/eyal-amit/` and `/eyal-amit/mokesh-dahiman/` = ACCURATE, sentenceCov 100). 0 PARTIAL/INVENTED among sourced pages.
2. **Overflow (qa_probe):** `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` @ **360/390/414/768** on `/`, `/faq/`, `/eyal-amit/`, `/eyal-amit/mokesh-dahiman/`, `/treatment/`, `/lessons/`, `/sound-healing/` → **0 horizontal overflow**.
3. **axe (S5 a11y):** `node scripts/qa/http-qa-axe.cjs --base <staging>` → **0 critical / 0 serious** across all routes.
4. **Redirects (single-hop, NO loops):** `curl -sSI -L --max-redirs 5`:
   - `/about/`→301→`/eyal-amit/`(200); `/about/moksha/`,`/mokesh-dahiman/`,`/mokesh/`→301→`/eyal-amit/mokesh-dahiman/`(200). Any 2-hop or loop = FAIL.
5. **Blog pagination (Eyal #6):** `/blog/page/2/`→200 with **distinct** posts vs page 1 (0 shared permalinks).
6. **Visual (mockup-vs-live screenshots — DON'T skip per WP-W2-10 lesson):** hero video plays muted/looping (poster under reduced-motion); FAQ TOC sticky + active chip; carousel scrolls + pauses on hover; **mokesh memorial reads with dignity** and carries Eyal's verbatim narrative (`ומה היום`, the Ganges-flood section, `תם עידן מוקש`, `jungel vibes`) + the placeholder note for bio/dates/photos.
7. **Asset 200s (WP-W2-10 lesson):** the hero video + poster resolve HTTP 200 (`assets/video/ea-home-hero-720-muted.mp4`, `…-poster.jpg`).

## Deliverable
`_COMMUNICATION/team_50/VERDICT_WP-W2-16_E2E_<engine>_v1.md` + evidence dir. PASS/FAIL per check,
with screenshots. On FAIL: file findings (file:line + repro) → team_100. Do NOT touch `_aos/`.

## ACTIVATION PROMPT
```
You are team_50 (E2E validator), running in Cursor/Codex (cross-engine vs the Claude builder).
Repo: EyalAmit.co.il-2026. Validate WP-W2-16 on branch wp-w2-16 (staging 1.4.13).
READ: _COMMUNICATION/team_100/MANDATE-TEAM50-WP-W2-16-E2E-VALIDATE-2026-06-16.md
      _COMMUNICATION/team_100/WP-W2-16-VERIFICATION-CLOSEOUT-2026-06-16.md
PRECONDITION: confirm the content-diff docx-parser fix is present (main 88160bd) before running the gate.
RUN: content-diff (17/17), qa_probe overflow @360/390/414/768 (0), axe (0/0), redirect single-hop probes,
     blog page-2 distinctness, mockup-vs-live screenshots of all 5 batches incl. the mokesh memorial.
EMIT: _COMMUNICATION/team_50/VERDICT_WP-W2-16_E2E_<engine>_v1.md (PASS/FAIL per check + evidence).
Your PASS gates team_190. Cross-engine: do NOT run as Claude.
```
