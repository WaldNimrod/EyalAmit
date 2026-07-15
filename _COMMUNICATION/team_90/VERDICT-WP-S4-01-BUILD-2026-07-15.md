---
id: VERDICT-WP-S4-01-BUILD-2026-07-15
from_team: team_90
to_team: team_100
date: 2026-07-15
type: validation-result
wp: WP-S4-01
builder_engine: sonnet (anthropic, team_10)
validator_engine: composer-2.5
iron_rule_1: satisfied
mandate_ref: MANDATE-TEAM90-WP-S4-01-BUILD-2026-07-15
built_file: site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/snoring-sleep-apnea-defaults.php
source_md: docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-07-12--snoring-sleep-apnea-didgeridoo-CHECKED.md
spec_ref: _COMMUNICATION/team_100/S004/WP-S4-01-LOD400-2026-07-15.md
---

# VERDICT — WP-S4-01 BUILD (team_90 cross-engine validation)

## Verdict flag

**PASS_WITH_FINDINGS**

Content, structure, links, FAQ, disclaimer, pending slots, PHP syntax, and staging layout QA all independently reproduced **PASS**. One process AC (AC-11 git isolation) **FAIL** due to a dirty working tree and an untracked deliverable file — not due to content defects in the built defaults file.

---

## Iron Rule #1

| Check | Result |
|-------|--------|
| Builder | sonnet / anthropic / team_10 |
| Validator | composer-2.5 / cursor / team_90 |
| Distinct vendors | **satisfied** |

---

## Per-AC results

| AC | Result | Evidence |
|----|--------|----------|
| **AC-1** | **PASS** | Built file maps S01–S17 per LOD400 §3: `phero` (S01) + `sections[]` markers S01b, S02, S03–S17 incl. S05b/S10b/S14b (`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/snoring-sleep-apnea-defaults.php` L24–286). S18 dev notes only in header docblock L11–15, not in `sections`. |
| **AC-2** | **PASS** | Independent content-diff script: **201** MD public content units (S01–S17) extracted; **0** missing in built corpus after HTML/normalization. Key literals present: `250`, `2006`, `2014`, `1999`, `23:00`, `7:00`. See §AC-2 detail below. |
| **AC-3** | **PASS** | Two `gallery` items with `'pending' => true` (S05b L96–99, S10b L165–168). No `<img>` in defaults file (grep = 0). Rendered glow slots via `gallery.php` L35–41. |
| **AC-4** | **PASS** | S10 body opens with `.ea-pending-approval` block L155; yoni narrative MD 384–437 present verbatim after note (e.g. MD 384 «יוני, שם בדוי…» → built L155; MD 435–437 Before/After → built trailing `<p><strong>…</strong></p>` pair). |
| **AC-5** | **PASS** | Single H1 source: `phero['title']` L27 = MD L11 «נחירות ודום נשימה בשינה: גישה טיפולית באמצעות דיג'רידו»; `phero.php` renders sole `<h1>` (`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/phero.php` L22). No second H1 in defaults bodies. |
| **AC-6** | **PASS** | `'part' => 'dd'` S13 L196–229: **6** `items`, first `'active' => true` L206; titles match MD 525/532/541/548/557/566; bodies match MD answer paragraphs. |
| **AC-7** | **PASS** | Internal routes with trailing `/`: `/contact/` (phero L30, cta L250), `/treatment/` (L133), `/method/` (L144), `/eyal-amit/` (L144, L261). External BMJ + Maccabi URLs verbatim with `target="_blank" rel="noopener noreferrer"` (L72, L83, L284 ×2). |
| **AC-8** | **PASS** | TOC S02 L50: **11** `href="#…"` anchors; all targets match `args['id']` on sections (L60, L71, L110, L121, L132, L143, L154, L179, L190, L201, L238). Extra `id=מכבי-דיגרידו` L82 not in TOC — per spec D-5. |
| **AC-9** | **PASS** (evidence referenced) | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/wp-s4-01-2026-07-15/qa_probe_result.json`: `verdict: PASS`, `failures: 0`, mobile + desktop no horizontal overflow on `/snoring-sleep-apnea/`. |
| **AC-10** | **PASS** | S16 L265–274: `id=חשוב-לדעת`, `alt=>true`, four disclaimer `<p>` blocks verbatim to MD 647–653 / spec §5. |
| **AC-11** | **FAIL** | `git diff --name-only HEAD` lists **20** other modified tracked paths; deliverable `snoring-sleep-apnea-defaults.php` is **untracked** (`??`) and absent from diff. Literal AC not met. |
| **AC-12** | **PASS** | `php -l` → «No syntax errors detected»; all `דיג'רידו` apostrophes in PHP single-quoted strings use `\'`; file parses cleanly. |

---

## AC-2 — content discrepancies (explicit list)

**none**

All public sentences from MD sections S01–S17 are present in the built file after normalization (strip HTML, collapse whitespace, preserve ASCII apostrophe in «דיג'רידו»). Verified independently via Python extractor over `CHECKED.md` vs all single-quoted string values in the PHP defaults file.

**Allowed non-MD scaffolding (not counted as AC-2 violations per LOD400 §3–§4):**

- S02 chap/title («תוכן העניינים» / «מה יש בעמוד הזה») — structural per spec row 2
- WP-EI-03 pending notes (S10 prose header, S05b `lead`, gallery `pending_label` strings)
- HTML wrappers (`<nav>`, `<p>`, `<h3>`, `<blockquote>`, `class="tlink"`, etc.)

**Numbers / punctuation spot-check:** `250`, `2006`, `2014`, `1999`, `23:00`, `7:00` — all found in built text (script + manual grep).

---

## AC-11 — git isolation detail

Command run (repo root):

```bash
git diff --name-only HEAD
```

**Observed:** 20 modified tracked files (hub data, theme CSS/commerce/render, other defaults, gallery.php, communication docs, etc.). **Not observed:** `snoring-sleep-apnea-defaults.php` (new file, untracked).

**Interpretation:** The **built artifact** matches WP-S4-01 single-file scope. The **repository working tree** does not satisfy the literal AC-11 gate as written. Recommend team_10 commit/isolate WP-S4-01 on a clean branch containing only the defaults file before L-GATE_BUILD closeout.

---

## route_recommendation

| Failed AC | Route |
|-----------|-------|
| AC-11 | Return to **team_10** for git hygiene: stage/commit **only** `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/snoring-sleep-apnea-defaults.php` on a dedicated branch (or revert unrelated working-tree edits before WP closeout). **Do not** return for content rework — AC-2 through AC-10 and AC-12 are clean. |

After AC-11 remediation: re-run team_90 spot-check on `git diff --name-only` only; no full content re-validation required unless the defaults file changes.

---

## Validator notes

- Cross-engine validation performed independently from mandate sources; builder completion report not used as evidence.
- AC-9 layout validated from existing staging evidence (`qa_probe_result.json` 2026-07-15T09:08:35Z); team_100 may re-run `qa_probe.mjs` after FTP redeploy if defaults file changes.
- Rendered page will show **3** `.ea-pending-approval` nodes (S10 prose note + 2 gallery slots) — consistent with AC-3 (2 image slots) + AC-4 (yoni publish note); not a content defect.

---

## Summary for team_100 / team_00

WP-S4-01 **verbatim anchor content build is substantively complete and correct**. Proceed to FTP deploy + hub sync only after resolving AC-11 git isolation, or accept environmental FAIL with explicit waiver from team_00.
