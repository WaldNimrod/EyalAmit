---
id: MANDATE-TEAM90-WP-S4-05-BUILD-2026-07-15
from_team: team_100
to_team: team_90
date: 2026-07-15
type: cross-engine-validation-mandate
wp: WP-S4-05
builder_engine: sonnet (anthropic, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S4-05-BUILD-2026-07-15.md
---

# MANDATE — team_90 cross-engine validation: WP-S4-05 (wp-admin editability, free-ACF)

You are the **cross-engine validator** (composer-2.5). This is the highest-risk WP — it refactors the core Chapters render layer. **Independently reproduce** the ACs from the specs + built code. The overriding property to verify is **zero regression + graceful degradation**.

## Sources of truth
- Specs: `_COMMUNICATION/team_100/S004/WP-S4-05-LOD400-2026-07-15.md` (§2 naming, §3 field map, §4 conflict resolution, §5 product meta, §8 ACs) + `WP-S4-05-LOD300-FIELD-MODEL-2026-07-15.md`.
- Built/modified: `inc/chapters/acf-fields-inner.php` (NEW), `inc/chapters/product-meta.php` (NEW), `inc/chapters/chapters-render.php`, `page-templates/tpl-chapters-page.php`, `page-templates/tpl-chapters-mokesh.php`, `inc/chapters/chapters-bootstrap.php`.
- Confirmed scope (team_00): master §2.1 set editable; EXCLUDE /en, qr-hub, galleries/media.

## Checks — reproduce each, cite evidence
- **AC-NOACF (CRITICAL)** — with ACF absent (`function_exists('get_field')` false) OR all fields empty, `ea_chapters_page_sections($type)` returns the **identical** sections array as the raw `$d['sections']` default. No `undefined function` / fatal / white-screen path. Verify by reading the overlay code AND, if feasible, a PHP harness: require a defaults file, call the overlay with ACF stubbed absent, assert equality with the default. **This is the property that guarantees no regression.**
- **Guards** — every `get_field()`/ACF call is wrapped in `function_exists()` (grep + enumerate). List any unguarded call (would be a FAIL).
- **AC-FALLBACK** — a cleared/empty field resolves to the seeded default (the overlay treats empty ACF as "use default"), never blank.
- **AC-LOCK** — structural args (`part, figr, reversed, id, alt(bool), center, dark, collapsible, active, cats, slug, cta_slug, yt_id, pending, pending_label`) are NOT registered as ACF fields (pass through untouched via `ea_chapters_part_field_map()` whitelist).
- **Naming contract (§2)** — field/key names follow `s{N}_{arg}` / `f_{type}_s{N}_{arg}`, list slots `s{N}_i{K}_{sub}`, group key `group_chapters_{type}`, location `page == <slug>`; images `return_format=id` resolved via `ea_chapters_resolve_img`.
- **AC-IMG** — image fields (attachment-id) resolve to URL via `ea_chapters_resolve_img` (not raw id).
- **Type-aware conflict (§4)** — `ea_chapters_repeater_specs($type)` gains `$type` param; home vs method list-shape conflicts (`whom_items`/`testi_items`/`mag_items`) resolved.
- **Product meta (§5)** — `product-meta.php` writes `ea_product_price` postmeta with nonce + `edit_page` cap; empty → deletes meta.
- **php -l** — clean on all 6 files.
- **Home regression** — `acf-fields-home.php` unchanged; home group still registers.

## Note on the LIVE edit cycle (AC-EDIT)
The actual wp-admin "edit a field → override appears on front / clear → falls back" cycle requires authenticated wp-admin access (credentialed login) and is executed at **WP-S4-08 §C** (delivery-blocking, with team_00). For THIS verdict, validate the **mechanism** (registration + overlay logic + guards + no-regression) — do not attempt credentialed login.

## Required output
Write **`_COMMUNICATION/team_90/VERDICT-WP-S4-05-BUILD-2026-07-15.md`**: frontmatter (`validator_engine: composer-2.5`, `wp: WP-S4-05`, `iron_rule_1: satisfied`); top-level flag; per-AC table with PASS/FAIL + evidence; explicitly state the AC-NOACF/regression result; `route_recommendation` for any FAIL. Any unguarded ACF call or a non-identity overlay when no override = FAIL (regression risk).
