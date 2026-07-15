---
id: MANDATE-TEAM90-WP-S4-06-BUILD-2026-07-15
from_team: team_100
to_team: team_90
date: 2026-07-15
type: cross-engine-validation-mandate
wp: WP-S4-06
builder_engine: sonnet (anthropic, team_10)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S4-06-BUILD-2026-07-15.md
---

# MANDATE — team_90 cross-engine validation: WP-S4-06 (site-wide glow-placeholder audit)

You are the **cross-engine validator** (composer-2.5). **Independently reproduce** the ACs. The core purpose: every Eyal-missing item (esp. temporary Green-Invoice purchase CTAs) carries a visible «ממתין לאישור» glow, uniformly, with no false positives on complete pages.

## Sources of truth
- Spec: `_COMMUNICATION/team_100/S004/WP-S4-06-LOD400-2026-07-15.md` (§3 component, §4 data edits, §5 ACs, §6.2 manifest).
- Built: `template-parts/chapters/parts/pending-note.php` (NEW), `assets/css/chapters.css` (`.ea-pending-inline`), `template-parts/chapters/parts/product-cta.php` (`gi_temp`), `cta.php` (`temp_note`), 5 product defaults, 3 book defaults, legal defaults, `tpl-chapters-en.php`.
- Staging: `http://eyalamit-co-il-2026.s887.upress.link`. team_100 gathers per-route selector evidence via qa_probe/DOM.

## Checks — reproduce each (selector counts from RENDERED staging DOM)
- **AC — products (blocking):** each of `/didgeridoos/ /bags/ /stands-storage/ /stand-floor/ /repair/` shows `.ea-pending-inline` **≥1** (temp-GI CTA marked) AND `.gfig--pending` **≥2** (pending gallery slots). The temp-GI purchase CTA must NOT render as final/unmarked.
- **AC — legal:** `/privacy/ /accessibility/ /terms/` each show **≥1** glow marker and **0** visible `⟨`/`⟩`.
- **AC — no false positives (blocking):** complete service pages (e.g. `/method/`, `/sound-healing/`, `/lessons/`) show **0** glow markers.
- **AC — anchor preserved (blocking):** `/snoring-sleep-apnea/` retains its 2 gallery pending slots + the יוני pending note; the WP-S4-01 verbatim prose is **unchanged** (content-diff the anchor defaults file vs its WP-S4-01 state — glow-markup swap allowed only if inner text is byte-identical).
- **AC — component:** `pending-note.php` exists with the uniform structure; `.ea-pending-inline` CSS present; `product-cta.php` `gi_temp` + `cta.php` `temp_note` hooks present.
- **php -l** clean on all touched files.
- **No-regression:** `ea_chapters_page_sections()`/render still fine (WP-S4-05 overlay untouched); qa_probe no fatal.

## Required output
Write **`_COMMUNICATION/team_90/VERDICT-WP-S4-06-BUILD-2026-07-15.md`**: frontmatter; top-level flag; per-AC table with the actual selector counts per route + evidence; explicit confirmation the anchor verbatim prose is unchanged; `route_recommendation` for any FAIL. A product route with an UNMARKED temp-GI CTA, or any change to the anchor's verbatim prose, = FAIL.
