---
gate: L-GATE_QA_CONTENT-ACCURACY
wp: WP-W2-15
to: team_50
from: team_100
engine_builder: claude-code
engine_validator: cursor   # Iron Rule #1 — validator engine MUST differ from builder
date: 2026-06-05
priority: HIGH
status: OPEN
related_wp: WP-W2-15-CR1 / CR2 / CR3 / CR4
---

# MANDATE — team_50 independent CONTENT-ACCURACY QA (WP-W2-15 CR1–CR4)

## 0. Why this mandate
team_100 (Claude Code) **built** the content reconciliation for CR1–CR4 and self-measured
**16/17 sourced pages PASS** on the live staging gate. Per **Iron Rule #1 (builder engine ≠
validator engine)** and the WP-W2-15 program §3B, this must be **independently re-verified by
team_50 in Cursor** before the batch can close. **Do not take team_100's numbers on trust —
re-run the gate yourself.**

> HARD RULE (program §0): no "ready"/sign-off to team_00/Eyal until the FINAL full-site triple-PASS
> (team_90 re-audit + team_190 full-site + team_50 E2E). This mandate is the team_50 leg.

## 1. Scope — what to QA
Staging base: `http://eyalamit-co-il-2026.s887.upress.link`
The 16 sourced CR1–CR4 pages below. Source SSoT root:
`docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/`

## 2. Acceptance criteria (per page)
- **CONTENT-ACCURACY PASS** by `node scripts/qa/content-diff.mjs`: section ≥95% · sentence ≥90% · 0 invented sections.
- Content **VERBATIM** from the 25.5.26 source (zero paraphrase/invention) — spot-check 2–3 pages by eye against source.
- No layout regression: 0 horizontal overflow @360/390/414/768, axe 0 critical/0 serious, HTTP 200, single H1, RTL intact.
- Structure/atoms unchanged: `ea-tokens.css` untouched, no new tokens.

## 3. team_100 self-measured LIVE result (to reproduce, not to trust)
Run: `node scripts/qa/content-diff.mjs` (default base = staging). Evidence committed at
`_COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04/` (summary.json + per-page).

| Page | section | sentence | invented | gate |
|---|---|---|---|---|
| / | 100% | 100% | 0 | **PASS** |
| /method/ | 100% | 100% | 0 | **PASS** |
| /treatment/ | 100% | 100% | 0 | **PASS** |
| /sound-healing/ | 100% | 92.73% | 0 | **PASS** |
| /lessons/ | 100% | 100% | 0 | **PASS** |
| /faq/ | 100% | 98.15% | 0 | **PASS** |
| /muzza | 100% | 100% | 0 | **PASS** |
| /eyal-amit (/about/) | 100% | 100% | 0 | **PASS** |
| /books/vekatavta/ | 100% | 98.28% | 0 | **PASS** |
| /books/kushi-blantis/ | 100% | 95.24% | 0 | **PASS** |
| /books/tsva-bekahol/ | 100% | 96.67% | 0 | **PASS** |
| /didgeridoos/ | 100% | 100% | 0 | **PASS** |
| /bags/ | 100% | 100% | 0 | **PASS** |
| /stands-storage/ | 100% | 92.86% | 0 | **PASS** |
| /stand-floor/ | 100% | 100% | 0 | **PASS** |
| /repair/ | 100% | 100% | 0 | **PASS** |
| /mokesh-dahiman | 100% | 9.09% | 0 | FAIL — **WP-W2-15-CR5, BLOCKED on Eyal (out of scope)** |

**OVERALL: 95.87% simple · 97.55% weighted · 16/17 gatePass** (baseline was 33.64% / 0-of-17).

## 4. GATE-TOOL CHANGES — REQUIRE RATIFICATION (team_90 owns the tool; team_190 final authority)
team_100 (the builder) modified `scripts/qa/content-diff.mjs` to measure **published content vs WP
display transforms**, NOT to lower the bar. Because the builder changed the measuring tool, these
need **independent ratification** (team_90 as gate owner + team_190). Each change + rationale:
1. **HTML-entity decode before the `#`-strip** — `esc_html` emits `'`→`&#039;`; the markdown-`#`
   rule ate the `#` (`&039;`), so every apostrophe/quote sentence falsely missed. (+ `&quot;`→`"`.)
2. **Section-coverage calibration (Principal-approved 2026-06-05)** — a section is covered if its
   title matches OR it has no content sentences OR all its sentences are present. Removes the brittle
   English-structural-label penalty (Hero/Intro/CTA) without invisible sr-only label text.
3. **Sentence-fusion fix** — split per source line/paragraph before normalize collapses newlines, so
   a punctuation-less heading/label no longer fuses with the next sentence into a unit no render can
   contain. Short poetic hard-break sections fall back to per-paragraph units.
4. **Strip `~~strikethrough~~`**, recognise **bold `**DEV NOTES:**` / `**CTA:**`**, exclude whole
   **DEV NOTES / QA Checklist / "(להשלמה)"-incomplete** sections and **`> DEV NOTE:`** blockquote
   image instructions, strip **`FAQ Category:`** and **`(חלק N)`** dev annotations from titles —
   all authoring scaffolding, never published content.
5. **Unify display-only glyphs** WordPress `wptexturize` produces: hyphen/dash variants→`-`,
   `…`→`...`, drop a space after a Hebrew maqaf `־` left by tag-stripping `ב־<a>בלוג</a>`.

A WP-free local proxy `scripts/qa/content-selfcheck.mjs` (extracts the text a PHP render emits) was
added for worktree sub-agents; the **live `content-diff.mjs` run is authoritative**.

## 5. KNOWN FLAGS for team_50 / Principal
- **/muzza → /books (302):** `/muzza` and `/books` are two pre-existing pages both titled
  "מוזה הוצאה לאור". The verbatim MUZZA.md content renders at `/books`
  (tpl-books.php → `ea_w2_05_render_books_archive()`); `/muzza`'s books-hub template renders DB
  `the_content()` which FTP cannot write. Interim **temporary 302 /muzza→/books** so the gate (and
  visitors) see the real content. **Principal decision needed:** canonical Muzza URL + permanent 301/nav.
- **Source ambiguities flagged by build agents (need Eyal):** muzza book-link slugs `/muzeh/…` vs
  live `/books/…`; vekatavta "hikikomori" spelling variant; non-canonical internal slugs
  (`/didgeridoo-treatment`, `/instruments`) normalized to live routes; `/repair` testimonials section
  "(להשלמה)" awaiting real testimonials; `/didgeridoos` & `/stands-storage` FAQ "/contact" literal vs humanized anchor.
- **CR5 (/mokesh, /galleries, /media):** BLOCKED on Eyal — excluded from this mandate.

## 6. Deliverable
Write `VERDICT_WP-W2-15_L-GATE_QA_CONTENT-ACCURACY_v1.md` in `_COMMUNICATION/team_50/`:
per-page reproduced numbers, verbatim spot-check notes, overflow/axe results, a ratification
opinion on the §4 gate changes, and PASS / PASS_WITH_FINDINGS / BLOCK. Route back to team_100.
(Hub API is currently unreachable from the Mac session — deliver file-based per ADR043 §4 fallback,
or via API once `100.125.98.56:8090` is reachable from your engine.)
