---
id: VERDICT-WP-S4-05-BUILD-2026-07-15
from_team: team_90
to_team: team_100
date: 2026-07-15
type: validation-result
wp: WP-S4-05
builder_engine: sonnet (anthropic, team_110)
validator_engine: composer-2.5
iron_rule_1: satisfied
mandate_ref: MANDATE-TEAM90-WP-S4-05-BUILD-2026-07-15
spec_ref: _COMMUNICATION/team_100/S004/WP-S4-05-LOD400-2026-07-15.md
---

# VERDICT — WP-S4-05 BUILD (team_90 cross-engine validation)

## Verdict flag

**PASS**

Independent reproduction of all in-scope acceptance criteria (mechanism + no-regression) **PASS**. Live wp-admin edit cycle (**AC-EDIT**) explicitly deferred to WP-S4-08 per mandate; not evaluated here.

---

## Iron Rule #1

| Check | Result |
|-------|--------|
| Builder | sonnet / anthropic / team_110 |
| Validator | composer-2.5 / cursor / team_90 |
| Distinct vendors | **satisfied** |

---

## AC-NOACF / regression (CRITICAL)

**Result: PASS**

When `get_field` is **undefined** (ACF absent), `ea_chapters_page_sections()` and `ea_chapters_phero_overlay()` produce output **identical to the pre-S4-05 template render pipeline** (committed `tpl-chapters-page.php` baseline: scalar `image`/`media`/`poster`/`video` + phero `media` resolved via `ea_chapters_asset_url()`; list `items[]` left as seeded paths).

Independent PHP harness: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/validate_wp_s4_05_noacf.php` — **9 path-B types tested, 0 failures**:

| Type | sections ≡ legacy | phero ≡ legacy | #sections |
|------|-------------------|----------------|-----------|
| treatment | ✓ | ✓ | 17 |
| didgeridoos | ✓ | ✓ | 14 |
| vekatavta | ✓ | ✓ | 13 |
| mokesh | ✓ | ✓ | 22 |
| sound-healing | ✓ | ✓ | 12 |
| lessons | ✓ | ✓ | 11 |
| about | ✓ | ✓ | 16 |
| faq | ✓ | ✓ | 2 |
| contact | ✓ | ✓ | 1 |

**Interpretation note:** Overlay output is **not** byte-identical to raw `$d['sections']` in defaults files when scalar image fields exist — by design (LOD400 §4.2 / §4.3 moved `ea_chapters_asset_url` resolution from the template into the overlay via `ea_chapters_resolve_img()`). The regression baseline is the **previous front render**, not unprocessed defaults arrays. No fatal / undefined-function path: all ACF reads go through guarded accessors (`chapters-render.php` L199–204, L218–223, L282–284, L475–480, L503–505).

Staging corroboration: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/wp-s4-05-2026-07-15/qa_probe_result.json` — 40/40 probes PASS, `forbiddenFound: []` (no fatal/parse/critical-error strings), all `http_rendered: true`.

---

## Per-AC results

| AC | Result | Evidence |
|----|--------|----------|
| **AC-NOACF** | **PASS** | See § AC-NOACF above. Overlay code paths: `ea_chapters_field_or()` L474–481; `ea_chapters_section_list_fetch()` L502–505 returns `[]` when ACF absent → list branch skipped (`ea_chapters_page_sections()` L623–630). Harness exit 0 on type loop (failures array empty). |
| **Guards** | **PASS** | Enumerated every `get_field()` / `have_rows()` in mandate file set. **`chapters-render.php`:** L200 inside `function_exists('get_field')`; L218–219 inside `function_exists('have_rows')`; L294 inside `ea_chapters_assemble_rows()` early-return L282–284; L318 ternary; L476 inside guard; L510 inside `ea_chapters_section_list_fetch()` guard L503. **`acf-fields-inner.php`:** `acf_add_local_field_group` only after L177 / L292 guards. **`product-meta.php`**, **templates**, **`chapters-bootstrap.php`:** zero ACF calls. **Unguarded calls: 0.** |
| **AC-FALLBACK** | **PASS** | `ea_chapters_field_or()` returns explicit `$default` when ACF missing or value empty (L475–481). `ea_chapters_merge_list_rows()` returns `$defaults` unchanged when `$rows` empty (L535–537); partial slot: empty sub keeps default sibling (L547–549). Harness: treatment with stub `get_field()` → `''` matches legacy sections. Unit test: `MERGE_PARTIAL_PASS` + `MERGE_EMPTY_PASS` (validator shell, 2026-07-15). |
| **AC-LOCK** | **PASS** | Structural args (`part, figr, reversed, id, center, dark, collapsible, active, cats, slug, cta_slug, yt_id, pending, pending_label`) **absent** from `ea_chapters_part_field_map()` (`chapters-render.php` L394–415 — grep for structural keys = 0). Overlay only iterates whitelisted scalars/lists present in defaults args (`ea_chapters_page_sections()` L610–621). Editable `alt` **text** for images (e.g. split `'alt'=>'txt'`) is intentional per LOD400 §3.2 — distinct from structural `alt(bool)`. Defaults still carry `figr`/`pending`/`cta_slug` etc. (e.g. `treatment-defaults.php` L48–49) and pass through untouched. Registrar skips args not in section defaults (`acf-fields-inner.php` L254–256). |
| **Naming contract (§2)** | **PASS** | `ea_chapters_inner_field()` L130–144: `name` = bare contract name (`s{N}_{arg}`, `s{N}_i{K}_{sub}`, `phero_{arg}`); `key` = `f_{type}_{name}`. Groups: `group_chapters_{type}` L195; method `group_chapters_method` L373. Location: `page == <slug>` L199, L377. Images: `return_format => 'id'` L134. List registry key `{type}_s{N}` via `ea_chapters_section_specs()` L454. Method flat keys (`mag_items`, `whom_items`, `testi_items`) L324–359. Excluded types per team_00: `ea_chapters_inner_excluded_types()` L49–50 (`en`, `qr-hub`, `qr`, `galleries`, `media`, `method`). |
| **AC-IMG** | **PASS** | Scalar img/file kinds resolved in overlay: `ea_chapters_page_sections()` L616–617, `ea_chapters_phero_overlay()` L580–581 via `ea_chapters_resolve_img()`. List img subs resolved in merge: `ea_chapters_merge_list_rows()` L551. `ea_chapters_resolve_img()` handles id/array/url/theme-path (L362–375). Registration uses attachment-id fields only (not raw URL fields). |
| **Type-aware conflict (§4)** | **PASS** | `ea_chapters_repeater_specs($type)` accepts `$type` param (L252–270). Home base specs preserved when `$type === 'home'` (L269). Method overrides: `mag_items`×6 `{title,text}`, `whom_items`×6 `{image,title,more}`, `testi_items`×12 `{name,text}` (L262–266). Harness: home `whom_items.subs = [image,text]`, method `whom_items.subs = [image,title,more]`; home `testi_items` 4-subs vs method 2-subs — **match spec**. Path-B section specs merged from `ea_chapters_section_specs($type)` L270. Method slots sized from `ea_chapters_repeater_specs('method')` (`acf-fields-inner.php` L404). |
| **Product meta (§5)** | **PASS** | `product-meta.php`: meta key `ea_product_price` (L54, L84–86); nonce `ea_product_price_nonce` / `wp_verify_nonce` (L53, L69); capability `current_user_can('edit_page', $post_id)` (L75); autosave guard (L72–74); slug scope 5 products (L31); empty → `delete_post_meta` (L83–84); digit/dot sanitize (L82). Consumer `ea_w2_05_price()` reads same key (`chapters-commerce.php` L44–46). No ACF dependency. |
| **php -l** | **PASS** | Clean on all 6 files (validator shell, 2026-07-15): `acf-fields-inner.php`, `product-meta.php`, `chapters-render.php`, `tpl-chapters-page.php`, `tpl-chapters-mokesh.php`, `chapters-bootstrap.php`. |
| **Home regression** | **PASS** | `git diff HEAD -- acf-fields-home.php` = empty (file unchanged). `group_chapters_home` still registered (`acf-fields-home.php` L182). `ea_chapters_register_home_fields()` + `acf_add_local_field_group` guard intact (L25–27). Bootstrap load order preserved: home registrar L20 before inner L21 (`chapters-bootstrap.php`). Staging home probes PASS in qa evidence (mobile + desktop). |
| **AC-EDIT** | **DEFERRED** | Per mandate: credentialed wp-admin cycle is WP-S4-08 §C delivery-blocking. This verdict validates registration + overlay + guards only. |
| **AC-LIST (live)** | **MECHANISM PASS** | `ea_chapters_section_list_fetch()` preserves slot index (L507–514); merge preserves locked keys + partial slots (unit test). Full headroom/live slot add not wp-admin tested here. |
| **Layout / no white-screen (staging)** | **PASS** (evidence) | `qa_probe_result.json`: `verdict: PASS`, `failures: 0`, 20 routes × 2 viewports, includes treatment/didgeridoos/vekatavta/method/mokesh/home. |

---

## route_recommendation

**None** — all in-scope AC **PASS**. Proceed to WP-S4-06 per S004 index; schedule **AC-EDIT** live wp-admin verification at **WP-S4-08** with team_00.

---

## Non-blocking notes

1. **Book `price` top-level field** (vekatavta/kushi-blantis/tsva-bekahol): LOD400 §5.3 marks template/accessor alignment as S4-02 sub-task; not registered in `acf-fields-inner.php` in this build. Out of explicit mandate AC table; track under books debt if still open.
2. **Harness artifact** lives at `tmp/validate_wp_s4_05_noacf.php` (validator-generated); optional copy to evidence folder for audit trail.
3. Working tree contains broader uncommitted S004 changes outside this WP file list; verdict scoped to mandate sources only.

---

## Validator methodology

Independent reproduction: read LOD400 §2–§8 + LOD300 field model; full read of 6 built files; `php -l`; grep guard enumeration; PHP harness with ACF stubbed absent + empty-field fallback; `ea_chapters_merge_list_rows` unit test; read staging `qa_probe_result.json` (did not rely on team_110 narrative). Builder engine ≠ validator engine (Iron Rule #1).
