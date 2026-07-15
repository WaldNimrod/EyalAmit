---
id: MANDATE-TEAM90-WP-S4-04-BUILD-2026-07-15
from_team: team_100
to_team: team_90
date: 2026-07-15
type: cross-engine-validation-mandate
wp: WP-S4-04
builder_engine: sonnet (anthropic, team_10)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator (distinct vendors)
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S4-04-BUILD-2026-07-15.md
---

# MANDATE — team_90 cross-engine validation: WP-S4-04 (learning + legal + /en team content)

You are the **cross-engine validator** (composer-2.5, team_90). A Sonnet builder (team_10) built WP-S4-04. **Independently reproduce** the acceptance criteria from the sources — do NOT trust the builder's report.

## Sources of truth
- **Spec (ACs + verbatim bodies):** `_COMMUNICATION/team_100/S004/WP-S4-04-LOD400-2026-07-15.md` — §A (learning), §B (legal), §C (/en), §E (ACs).
- **Built/modified files:**
  - `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` (route map +4)
  - NEW `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/{learning,therapist-training,lectures,workshops}-defaults.php`
  - `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/{privacy,accessibility,terms}-defaults.php`
  - `site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-en.php`

## Checks — reproduce each independently, cite evidence
- **AC-A0** — `ea_chapters_route_map()` gains exactly the 4 entries `learning / therapist-training / lectures / workshops`, all → `tpl-chapters-page`, with **no slug collision** (none pre-existed).
- **AC-A2** — each of the 4 learning pages resolves to exactly one H1 source (phero).
- **AC-A4** — hub `learning-defaults.php`: **zero** `.ea-pending-approval` glow blocks + **3** internal button links to the children.
- **AC-A5** — each child (`therapist-training`, `lectures`, `workshops`): exactly **one** glow block + **≥3** prose sections.
- **AC-B1** — legal defaults (`privacy`, `accessibility`, `terms`): **zero** `⟨` or `⟩` characters remain.
- **AC-B2** — each legal page has exactly **one** glow banner.
- **AC-B3** — `accessibility-defaults.php` contains all of: `תקנות שוויון זכויות`, `5568`, `WCAG 2.0`, and a phone number.
- **AC-B4** — no Latin-in-Hebrew slips in the new legal/learning prose.
- **AC-B5** — each legal file's `phero` is unchanged from its prior committed state (`git diff` the phero block only).
- **AC-C** — `tpl-chapters-en.php`: `.ea-en-pending` CSS present, a DRAFT banner present, both `⟨…⟩` English placeholders replaced with English draft copy, page is LTR.
- **AC-X1** — `php -l` clean on ALL touched/created files.
- **AC-X3** — the draft text (legal Hebrew, /en English, learning bodies) matches the spec's given verbatim copy.
- **AC-X2 / layout / HTTP-200** — validated separately by team_100 via `qa_probe.mjs` on staging (4 learning + 3 legal + /en routes); reference `_COMMUNICATION/team_90/evidence/wp-s4-04-2026-07-15/` if present, else note "deferred to team_100 staging QA".

## Required output
Write your verdict to **`_COMMUNICATION/team_90/VERDICT-WP-S4-04-BUILD-2026-07-15.md`** with: frontmatter (`validator_engine: composer-2.5`, `wp: WP-S4-04`, `iron_rule_1: satisfied`); a single top-level **verdict flag** (`PASS` / `PASS_WITH_FINDINGS` / `CONCERNS` / `FAIL`); a per-AC table with PASS/FAIL + evidence; and `route_recommendation` for any FAIL. Note any FAIL that is environmental (e.g. pre-existing dirty tree) vs a real content/build defect.
