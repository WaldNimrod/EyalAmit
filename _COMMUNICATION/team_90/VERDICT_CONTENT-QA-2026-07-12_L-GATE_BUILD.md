---
id: VERDICT_CONTENT-QA-2026-07-12_L-GATE_BUILD
from_team: team_90 (cross-engine validator — cursor-composer-2)
to_team: team_100
mandate: _COMMUNICATION/team_90/MANDATE_CONTENT-QA-2026-07-12_L-GATE_BUILD.md
date: 2026-07-14
gate: L-GATE_BUILD
builder_engine: Claude Code (team_100)
validator_engine: cursor-composer-2 (team_90)
method: read-only git diff + file:line static verification; php -l on all changed PHP; yaml.safe_load on roadmap; programmatic byte-compare of /method testimonial extraction vs git HEAD
---

# VERDICT — team_90 · cross-engine validation, 2026-07-12 content + quick-fix batch

**Overall verdict: `PASS_WITH_FINDINGS`**

Cross-engine pass complete. All 12 mandated code checks pass at the static/repo layer. Two evidence-chain gaps and one component-asymmetry finding prevent a clean `PASS` rubber-stamp; no blocking code defect was found that would warrant `FAIL`.

---

## Mandated item table

| # | Item | Result | Evidence |
|---|------|--------|----------|
| 1 | Homepage Trust Line + `hero_subtitle` escaping | **PASS** | `home-defaults.php:21` adds `hero_trust`. `section-hero.php:28-31` renders trust inside `.hero__c` above H1 via `esc_html()` (plain text — correct). `hero_subtitle` at `section-hero.php:31` uses `ea_chapters_kses_e()`, not `esc_html()` — fix confirmed. Grep of `section-hero.php` shows no `esc_html( ea_chapters_field` pattern; only `hero_cta_label` uses `esc_html()` (plain label — correct). Supporting CSS: `chapters.css` `.hero__trust` added in diff. |
| 2 | Testimonial names clickable (homepage) | **PASS** | `section-05-testimonials.php:27-28,32-33` carries `href` from `ea_fb_testimonials_all()` / `testi_items`. `section-05-testimonials.php:45-46` wraps name in `<a class="tmq__nl" … target="_blank" rel="noopener noreferrer">` when `href` non-empty; plain `figcaption` fallback at `:48`. CSS `.tmq__nl` in `chapters.css` diff. **Note:** live FB URL resolution not exercised in this static pass (see Additional findings). |
| 3 | `/method` 8-card carousel + verbatim quotes | **PASS** | `method-defaults.php:171-181` adds `testi_chap`/`testi_title`/`testi_items` (8 entries). `tpl-chapters-method.php:81-85` wires `parts/testimonials.php`. Programmatic compare of all 8 `name`+`text` pairs against git `HEAD` `split_body` blocks: **8/8 byte-identical** (quotes merged from paired `"…"` segments in old inline HTML match new carousel strings exactly). |
| 4 | Book reading-excerpt accordions + scroll-reveal fix | **PASS** | `prose.php:19-24,31-35` — when `collapsible`, `$body_cls = 'intro-body'` (no `r`/`r2`). Inner div at `:34` uses only `intro-body`. Applied on all 3 book SECTION 03 configs: `kushi-blantis-defaults.php:44-47`, `vekatavta-defaults.php:44-47`, `tsva-bekahol-defaults.php:56-59`. CSS `.prose-acc*` in `chapters.css` diff. Repeat open/close safe: content never gets opacity-0 reveal classes. |
| 5 | Homepage hero video (timing only, file untouched) | **PASS** | `section-hero.php:21` — `<video>` has no `autoplay`, `preload="none"`. `ea-chapters.js:72-78` — deferred `.load()` + `.play()` on `window.load`, gated `!reduce`. `home-defaults.php:26` `hero_video` unchanged: `assets/video/ea-home-hero-720-muted.mp4`; `git diff` shows **zero** changes under `assets/video/`. |
| 6 | FAQ font-size | **PASS** | `ea-atoms.css:1109` — `.ea-faq-item__answer p` is `font-size: 1rem` (was `0.9rem` in diff). Targets main `/faq` atom stylesheet as mandated. |
| 7 | "לימוד והכשרה" nav links | **PASS** | `section-nav.php:29,32-33` — therapist-training, lectures, workshops → `/learning/therapist-training/`, `/learning/lectures/`, `/learning/workshops/`. `section-nav.php:31` — `קורסים` remains `href="#"` with intentional pending-URL comment. Slugs corroborated in `ea-m3-team80-placeholder-content-once.php` / `ea-m2-site-tree-lock-sync-once.php`. Live HTTP 200 not probed here. |
| 8 | Footer disclaimer + a11y/privacy links | **PASS** | `section-footer.php:43-45` — `.foot__legal` block. Disclaimer string at `:44` is **character-identical** to `block-disclaimer.php:25` default. Links at `:45` → `/accessibility/`, `/privacy/` via `home_url()`. CSS `.foot__legal`/`.foot__disc`/`.foot__base a` in `chapters.css` diff. |
| 9 | `/repair` electronics-engineer sentence | **PASS** | `repair-defaults.php:34` — new paragraph inserted after Mokesh sentence, before materials paragraph. Reads naturally; does not duplicate adjacent sentences (adds analysis angle vs prior biography). Consistent with pattern on `didgeridoos-defaults.php` / `about-defaults.php` (separate pages). |
| 10 | Meta-description mu-plugin | **PASS_WITH_FINDINGS** | **(a)** `php -l` clean. **(b)** `ea-content-eyal-seo-metadesc-2026-07-12-once.php:36-40` — `ea_eyal_seo_metadesc_20260712_set()` calls `update_post_meta()` unconditionally (no emptiness gate); contrast `ea-w2-17-metadesc-backfill-once.php:39-47` `get_post_meta` guard. Exactly 8 routes + front page (`:63-101`). Option guard `:47-48`, lock `:56-59`. **(c) FINDING:** `DETAILED-DIFF-EYAL-QA-SEO-VS-CURRENT-SITE-2026-07-12.md` §3.A row 1 does **not** quote the 8 description strings verbatim (only notes they differ from live). Verbatim transcription drift check against the mandate-cited artifact is **not executable from repo**; strings exist only in the mu-plugin + builder comments. Recommend team_10 attach SEO-doc excerpt or staging read-back before production deploy. |
| 11 | `_aos/roadmap.yaml` WP-CANON entry | **PASS** | `python3 -c "import yaml; yaml.safe_load(open('_aos/roadmap.yaml'))"` → OK. Single `- id: WP-CANON-TEMPLATE-UNIFICATION` at `roadmap.yaml:1528`; appended after `WP-W2-17` gate_history without corrupting prior entries. `parent_wp:` empty (valid YAML null). |
| 12 | FTP deploy file list | **PASS** | `scripts/ftp_deploy_site_wp_content.py:144-146` — new mu-plugin appended after existing `ea-w2-17-metadesc-backfill-once.php` entry; no other lines in that file altered (`git diff` shows +3 lines only). File is untracked in git but path matches deploy tuple. |

---

## Additional findings (mandate §Also actively look for)

| Area | Result | Detail |
|------|--------|--------|
| Scope creep / undocumented diff touch | **FINDING (low)** | All diff files map to mandate items. Minor asymmetry: homepage uses `section-05-testimonials.php` (href-aware) while `/method` uses `parts/testimonials.php` (`:23-26,37-39` — no `href` / `<a>` wiring). Method `testi_items` carry no `href` today, so no functional regression on `/method`; future href addition would need both templates aligned. |
| PHP syntax | **PASS** | `php -l` on all 12 changed `.php` files + untracked mu-plugin — 0 errors. |
| Wave2 interaction | **PASS** | No diff assumes Wave2→Chapters unification already happened. Changes are Chapters-layer only; meta plugin writes Yoast DB (compatible with existing Wave2 Yoast-first guard). Nav links target Chapters-routed `/learning/*` pages seeded by existing mu-plugins. |
| Runtime / staging | **FINDING (info)** | Not in static mandate scope but flagged for deploy QA: (1) mu-plugin `get_page_by_path()` resolution + post-deploy meta read-back, (2) FB testimonial `href` targets on homepage carousel, (3) `/learning/*` HTTP 200 on staging. |
| Declined scope re-litigation | **N/A** | H1/H2 wording and vekatavta `<br>` structure not flagged per mandate instruction. |

---

## Cross-engine attestation

- **Builder:** team_100 / Claude Code  
- **Validator:** team_90 / cursor-composer-2 (different engine — Iron Rule #1 satisfied)  
- **Diff basis:** `git diff` at workspace root, 17 tracked modified paths + 1 untracked mu-plugin  
- **Blocking issues:** none  
- **Recommended before marking batch COMPLETE:** resolve item 10(c) evidence gap (SEO-doc excerpt or staging meta read-back); optional: align `parts/testimonials.php` with `section-05-testimonials.php` href pattern for consistency.

---

*Filed by team_90 · cross-engine L-GATE_BUILD validation · 2026-07-14*
