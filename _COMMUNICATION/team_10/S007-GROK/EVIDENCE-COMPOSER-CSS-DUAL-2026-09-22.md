# S007 — Dual width systems validation (Composer 2.5)

**Validator:** Composer 2.5 (read-only; no theme edits, no FTP)  
**Date:** 2026-09-22  
**Theme child validated:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/site/wp-content/themes/ea-eyalamit/`  
**Question:** After align-sweep (remove `ea-wave2-blog-*` from Chapters `<main>`, retarget `.ea-post-content` to 82ch), are **two width systems** still **live** on published Chapters URLs or only **dormant** in CSS?

---

## Executive verdict (1 page)

| Layer | Two systems still live on default Chapters blog + inner URLs? |
|-------|----------------------------------------------------------------|
| **PHP / `<main>` class** | **No** — published Chapters blog archive/single use `chapters-main` only. Legacy `ea-wave2-blog-archive` / `ea-wave2-blog-single` remain only in unused Wave2 page templates. |
| **Primary reading measure** | **Canon wins** — `.ea-post-content` is **82ch** (not 66ch). Chapters `.prose` / `.intro-body` are **82ch**; shell `.wrap` is **1200px**. |
| **Residual Wave2 measure on same page** | **Yes, narrow** — blog single still renders `.ea-related` capped at **`var(--ea-prose-width)` (960px)** while post body is 82ch inside `.wrap` (1200). That is a **live dual measure on one URL family**, not dormant CSS. |
| **Stylesheet repo** | **Yes, dual definitions persist** — `--ea-prose-width: 960px` in `ea-tokens.css` plus ~50 `max-width: var(--ea-prose-width)` / `65ch` rules across Wave2 sheets; Chapters canon uses 1200 / 82ch. Most Wave2 rules are **dormant** on Chapters inners because selectors require Wave2 markup (`.ea-wave2-editorial`, shop/service templates, etc.). |
| **Co-enqueue risk** | **Medium (latent)** — Chapters blog views load **`chapters.css` + `ea-blog.css` + `ea-atoms.css`** (via `ea_wave2_shell`). Unused rules in `ea-blog.css` (editorial block) do not apply without `.ea-wave2-editorial`. Accidental reintroduction of `ea-wave2-blog-*` on `<main>` would **not** re-cage main today (those classes only set `direction: rtl` after sweep) but would signal regression. |

**Bottom line:** For **`ea_chapters_enabled()` default (true)** and blog routed at priority **105**, the **old main-class Wave2 blog cage is not live**. The **canon width system governs** blog post body and Chapters long-form. **Two systems coexist in the codebase** and **one live hybrid** remains on **blog single** (82ch body + 960px related block). **66ch is not an active CSS value** (comment-only in `ea-blog.css`).

---

## 1. PHP / HTML: `ea-wave2-blog-*` on `<main>`

Full-repo grep for `ea-wave2-blog-single` | `ea-wave2-blog-archive`:

| File | `<main>` class | Routed when Chapters on? |
|------|----------------|---------------------------|
| `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-blog-archive.php` | `chapters-main` | **Yes** (`is_home`, priority 105) |
| `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-blog-single.php` | `chapters-main` | **Yes** (`is_singular('post')`, priority 105) |
| `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/site/wp-content/themes/ea-eyalamit/page-templates/tpl-blog-archive.php` | `ea-wave2-blog-archive` | **No** (not selected by Chapters router; page-template name only) |
| `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/site/wp-content/themes/ea-eyalamit/page-templates/tpl-blog-single.php` | `ea-wave2-blog-single` | **No** (stale comment references `functions.php` hook; **no** `template_include` hook found; `inc/wave2-w2-06.php` removed) |

All other Chapters templates use `chapters-main` on `<main>` (home, page, method, QR, en, mokesh, etc.).

---

## 2. Runtime template winner: priority 105 vs legacy `tpl-blog-single.php`

Source: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-routing.php`

| Filter | Priority | Effect on blog |
|--------|----------|----------------|
| `ea_wave2_template_router` | 90 | Does not map blog (only `stage-b-test` slug map) |
| Various catalog routers in `functions.php` | 94–97 | Pages only |
| `ea_chapters_template_include` | 103 | Pages only (`is_page`) |
| **`ea_chapters_blog_template_include`** | **105** | **`tpl-chapters-blog-archive.php` / `tpl-chapters-blog-single.php`** when `ea_chapters_enabled()` |

Comment in routing file cites “WP-W2-06 @ 100”; **w2-06 file is absent**. Nothing at priority 100–104 overrides blog to `tpl-blog-single.php`.

Rollback path: `EA_CHAPTERS_FRONT` false or filter `ea_chapters_front_enabled` → Chapters blog filter returns `$tpl` unchanged; child theme has **no** `single.php` — parent theme default applies (not verified here).

---

## 3. Full grep: `max-width` targets (60 lines in `assets/css/`)

Command: `rg -n 'max-width:\s*(var\(--ea-prose-width\)|65ch|66ch|82ch|820px)' assets/css/`  
**66ch:** zero active declarations (one historical comment in `ea-blog.css` L264).

### Canon (Chapters family — live on Chapters-routed URLs)

| Rule | File | Live consumer (URL family) |
|------|------|----------------------------|
| `.wrap { max-width:1200px }` | `chapters.css` | All Chapters shell pages + blog archive/single |
| `.prose`, `.intro-body { max-width:82ch }` | `chapters.css` | Chapters inner long-form (`tpl-chapters-page`, method, FAQ prose, etc.) |
| `.ea-post-content { max-width:82ch }` | `ea-blog.css` | **Blog single** (`tpl-chapters-blog-single.php`) |

### Chapters-specific non-82ch widths (canon-adjacent, not Wave2 960)

| Rule | File | Live consumer |
|------|------|----------------|
| `.faq`, `.ea-faq-list*`, `.gallery--doc { max-width:820px }` | `chapters.css` | Chapters FAQ / doc gallery pages |
| `@media (max-width:820px)` | `chapters.css` | Breakpoint only (`.bio` grid) |

### Wave2 leftover (`--ea-prose-width` / 65ch) — selective live consumers

| Rule (selector) | File | Live consumer? | Risk |
|-----------------|------|----------------|------|
| `--ea-prose-width: 960px` | `ea-tokens.css` | Global token whenever Wave2 stack loads | **Later:** any new rule using token |
| `.ea-related` | `ea-blog.css` | **Yes** — blog single related section | **Now:** 960px band vs 82ch body |
| `.ea-wave2-editorial …` (65ch, 960px inners) | `ea-blog.css` | **No** on Chapters blog — needs `tpl-content.php` / `.ea-wave2-editorial` | Dormant unless editorial template |
| `.ea-wave2-blog-archive` / `.ea-wave2-blog-single` | `ea-blog.css` | Legacy templates only; **no max-width** after sweep | Low unless class returns to `<main>` |
| `.ea-section-intro__body { 65ch }` | `ea-atoms.css` | Legacy home / Wave2 blocks using atoms | Not on Chapters-markup pages |
| `.ea-books-section__intro { 65ch }` | `ea-atoms.css` | Legacy block routes | Dormant on Chapters |
| `.ea-contact-page-intro__* { 960/65ch }` | `ea-atoms.css` | `/contact` Wave2 template | Chapters FAQ uses different markup |
| `.ea-wave2-14e .ea-14e-prose p { 65ch }` | `w2-14e-catalog.css` | Catalog slugs not overridden by Chapters map | Parallel system on 14e URLs |
| Multiple `var(--ea-prose-width)` | `w2-04-service.css`, `w2-05-shop.css`, `w2-08-en-landing.css`, `w2-10-service.css`, `w2-07-heritage.css` | Respective Wave2 page templates | Not Chapters-routed |
| 22× `var(--ea-prose-width)` + 3× `65ch` | `ea-atoms.css` | Wave2 shell views using atom class names | Latent on Chapters if markup reuses atoms |

---

## 4. `.ea-post-content` measure

```266:268:file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/site/wp-content/themes/ea-eyalamit/assets/css/ea-blog.css
.ea-post-content {
	max-width: 82ch;
	margin-inline: auto;
```

**Regression check:** **82ch (good)**. No competing `max-width` on `.ea-post-content` in `chapters.css`.

---

## 5. `font-size` on component rules (`ea-blog.css` / `chapters.css`)

**Policy:** typography via `--fs-*` / `--fw-*` in `ea-tokens.css` (canon).

| File | Raw `px` font-size on components | `font-size` via `var(--fs-*)` |
|------|----------------------------------|-------------------------------|
| `ea-blog.css` | **None** | Yes (e.g. `.ea-edhero__title`, editorial cluster) |
| `chapters.css` | **None** | Yes (extensive) |
| **Documented exceptions** | `chapters.css` L936: `1.6rem` carousel arrow (comment: glyph not a rung); L675: `.6em` caret | Intentional per-file comments |

No off-token pixel rungs found in these two sheets.

---

## 6. Co-enqueue: can dormant Wave2 CSS hit Chapters?

| Asset | Enqueue | Chapters blog views |
|-------|---------|---------------------|
| `ea-wave2-tokens`, `ea-wave2-atoms`, mobile nav, etc. | `wave2-stage-b.php` @ **28** when `ea_wave2_is_active_view()` — includes `get_query_var('ea_wave2_shell')` set **true** for Chapters blog | **Loaded** |
| `ea-blog.css` | `chapters-enqueue.php` `ea_chapters_blog_assets` @ **29** | **Loaded** |
| `chapters.css` | `chapters-enqueue.php` @ **100** | **Loaded last** among these |

Chapters blog archive/single markup uses **Chapters** classes (`chapters-main`, `.wrap`, `.ea-blog-grid`) — not `.ea-wave2-editorial` or `.ea-wave2-blog-*` width cages. **Exception:** `.ea-related` in shared `ea-blog.css` **does** apply (960px).

Inner Chapters pages (non-blog) typically **do not** enqueue `ea-blog.css` unless blog view — editorial block in `ea-blog.css` stays unloaded on e.g. `/method`.

---

## 7. Leftover rule → consumer → risk (summary table)

| Leftover rule | Live consumer on published Chapters URLs (default)? | Risk now | Risk later |
|---------------|-----------------------------------------------------|----------|------------|
| `ea-wave2-blog-*` on `<main>` | **No** | Low | **High** if re-added to Chapters templates (semantic drift) |
| `max-width` on `.ea-wave2-blog-*` | **Removed** — only `direction: rtl` | Low | Medium if someone restores 960px on class |
| `.ea-post-content` 82ch | **Yes** (blog single) | None | Low if duplicated in another sheet |
| `.ea-related` 960px | **Yes** (blog single footer) | **Medium** — visual inconsistency | Medium until aligned to `.wrap` / 82ch |
| `--ea-prose-width` + Wave2 sheets | Shop/service/14e/legacy home atoms | Low on Chapters inners | **High** if Chapters markup adopts atom wrappers |
| `.ea-wave2-editorial` block in `ea-blog.css` | **No** on Chapters blog | None | Low |
| `65ch` in atoms / 14e / editorial | Non-Chapters templates | None on Chapters | Medium cross-template copy-paste |
| Chapters `.faq` 820px | FAQ Chapters page | Accepted local measure | Document in canon if intentional |

---

## 8. Recommendations (do not implement)

### Delete / isolate (when Team 10 mandate allows)

1. **Split `ea-blog.css`:** move WP-W2-10 editorial cluster (`.ea-wave2-editorial` and below ~L354) to `w2-10-editorial.css` enqueued only on `tpl-content.php` routes — stops shipping ~200 lines on every blog view.
2. **Retarget `.ea-related`** on Chapters blog single: drop `max-width: var(--ea-prose-width)` or scope under legacy template only; let `.wrap` (1200) govern grid width.
3. **Archive or delete** `tpl-blog-archive.php` / `tpl-blog-single.php` after rollback window closes, or gate behind `! ea_chapters_enabled()` documentation-only copies.
4. **Remove stale** `tpl-blog-single.php` comment claiming `template_include` in `functions.php`.

### Keep

- `chapters.css` canon: `.wrap` 1200, `.prose` / `.intro-body` 82ch, `--sec`, `.phero`.
- `.ea-post-content { max-width: 82ch }` in `ea-blog.css` (shared with legacy tpl if ever used).
- `--ea-prose-width` **until** all Wave2 route families migrate or tokens are namespaced per era.

### Prevent dual `<main>` class (CI / lint)

1. **`scripts/lint_chapters_main_class.sh`:** `rg` Chapters `page-templates/tpl-chapters-*.php` — fail if `<main` matches `ea-wave2-blog-(single|archive)`.
2. **Ban list in CI:** `ea-wave2-blog-single|ea-wave2-blog-archive` inside `tpl-chapters-*.php`.
3. **Assert routing:** grep test that `ea_chapters_blog_template_include` remains priority **≥ 105** and references only `tpl-chapters-blog-*.php`.
4. **Width drift grep (warn):** fail on new `max-width: 66ch` or `max-width: var(--ea-prose-width)` under selectors matching `chapters-main` / `.ea-post-content` without allowlist file.
5. **Optional browser QA:** blog single — computed `max-width` on `.ea-post-content` = 82ch; on `.ea-related` flag if still 960px.

---

## Evidence commands (repro)

```bash
cd "/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/site/wp-content/themes/ea-eyalamit"
rg -n 'ea-wave2-blog-(single|archive)' .
rg -n 'max-width:\s*(var\(--ea-prose-width\)|65ch|66ch|82ch|820px)' assets/css/
rg -n '<main' page-templates/tpl-chapters-*.php page-templates/tpl-blog-*.php
```

---

*End of evidence pack.*
