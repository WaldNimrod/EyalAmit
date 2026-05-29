---
id: MANDATE-TEAM10-W2-07-HERITAGE-2026-05-29
from_team: team_100 (Chief System Architect)
to_team: team_10 (Builder)
wp: WP-W2-07 — Press + Moksha + 48 QR pages + FB Top-5 testimonials
date: 2026-05-29
status: READY TO DISPATCH
spec_ref: _aos/work_packages/S002/WP-W2-07/LOD400_spec.md
depends_on: WP-W2-02 (COMPLETE)
branch: feature/w2-07-heritage
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-07
---

# Dispatch Mandate — WP-W2-07 (Heritage)

## 1. Scope (4 deliverables)
1. **48 QR pages** `/qr/qr1/`..`/qr/qr48/` — 1:1 migration of legacy body_html + rehosted images.
2. **/press** — ≥5 (use all 26) legacy press articles, each date+title+external link (new tab).
3. **/about/moksha** — page EXISTS (W2-02 ID 181); fill final content + image + link to /about.
4. **FB Top-5 testimonials** — text+image(rehosted)+link, rendered via existing Wave2 testimonial block.

## 2. Inputs (all present + verified)
- QR content: `_COMMUNICATION/team_40/W2-07-QR-CONTENT-EXPORT-2026-05-28.json` — **list of 48** `{qr_n, slug, title, body_html, image_urls[]}`.
- QR URL inventory (slugs/nesting — DO NOT change, QR-URL-POLICY): `docs/project/team-100-preplanning/QR-URL-INVENTORY.csv`.
- Press: `_COMMUNICATION/team_40/W2-07-PRESS-EXPORT-2026-05-28.json` — **list of 26** `{date,title,url,source}`.
- Moksha text: `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/מוקש דהימן/ומה היום.docx` (extract text).
- Testimonial images + mapping: `_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/catalog.json` (315 entries; key `legacy_relative` → `media/<public_id>` files) + `media/` dir.
- Testimonial TEXT: reuse the real FB Top-5 already in `inc/wave2-w2-04-content.php` (sound-healing/lessons testimonials with FB share links) and/or the W2-08 EN artifact; legacy `post_type=testimonials` is sparse — do not block on it.
- **Legacy SQL dump (authority, OUTSIDE repo):** `/Users/nimrod/Documents/Eyal Amit/eyalamit.co.il-legacy/wp_posts_backup_20260113_010740.sql`; legacy uploads at `/Users/nimrod/Documents/Eyal Amit/eyalamit.co.il-legacy/wp-content/uploads/`.
- Reproducibility scripts already in `scripts/`: `extract_qr_content.py`, `extract_press.py`, `extract_he_for_w208.py`.

## 3. IMAGE REHOST — resolve FIRST, report if blocked (do not fail silently)
The 41 QR `image_urls`: **34 are `http://localhost:9090/wp-content/uploads/<rel>`** (legacy WP, likely offline), 6 external (flickr/mongabay). Rehost ALL referenced images to `wp-content/uploads/ea-legacy/qr/` (relative paths in body_html), per W2-06 media policy. Resolution order per image:
1. Map `localhost:9090/wp-content/uploads/<rel>` → `<rel>` lookup in `catalog.json` `legacy_relative` → copy the curated `media/<public_id>.<ext>` file.
2. Else copy from the legacy uploads dir `…/eyalamit.co.il-legacy/wp-content/uploads/<rel>`.
3. External (flickr/mongabay): download; if fetch blocked, keep the external URL as-is (acceptable — out-of-domain heritage refs).
4. If an image is unresolvable: leave a clean reference/omit gracefully + **flag in the completion report** (do NOT leave broken `localhost:9090` URLs live).
Rewrite each `body_html` image src to the rehosted relative path before seeding.

## 4. Build architecture (reuse W2-02/04/05 patterns)
- **QR pages — seed with REAL post_content** (unlike W2-05's the_content injection): the 48 bodies are large + unique, so the one-time seeder mu-plugin **`ea-w2-07-qr-seed-once.php`** (mirror `ea-w2-05-shop-pages-seed-once.php` guards: ABSPATH, init hook, option flag e.g. `ea_w2_07_qr_seeded_v1`, transient lock, no wp-load re-require, idempotent get-or-create) does `wp_insert_post` for each `qrN` under parent `qr` with `post_content = rewritten body_html`, assigning template `tpl-qr.php`. Slugs/nesting EXACTLY per the inventory CSV. Add the seeder to `scripts/ftp_deploy_site_wp_content.py` upload list.
- **`page-templates/tpl-qr.php`** (NEW) — thin shell (mirror tpl-shop-item.php): header → topnav → `<main class="ea-wave2-qr">` loop `the_content()` → footer → footer. Add `tpl-qr` to the `ea_wave2_is_active_view` list in `inc/wave2-stage-b.php` (~line 51-52, where tpl-shop-* are listed).
- **Router `inc/wave2-w2-07.php`** (NEW) — mirror W2-02/W2-05: route `press` → a content template + set `ea_wave2_shell`, body class `ea-wave2-shell`, no-sidebar, hide GP title, enqueue any W2-07 CSS. QR pages get the shell via their assigned template + the is_active_view list.
- **/press** — seed page slug `press` (in the same or a sibling once-only seeder) + render the 26-link list. Either (a) the_content injection keyed on slug `press` (mirror W2-05 provider, structured render: date · title · external link `target=_blank rel=noopener`) or (b) post_content via seeder. Prefer (a) for clean structured markup. ≥5 (use all 26).
- **/about/moksha** — update existing page ID 181 post_content via REST (`scripts/wp_rest_client.py`, Application Password in `local/.env.upress`) with the extracted docx text + image + link to `/about`. Do NOT recreate the page.
- **FB Top-5 testimonials** — render via the existing Wave2 testimonial block; images rehosted under `wp-content/uploads/` (relative); text from the W2-04 provider's Top-5 + FB share links; FB profile photos best-effort, else curated media, else grey avatar (spec F05/F04).
- D-14 tokens only (no raw hex); bump `style.css` Version 1.4.4 → **1.4.5**.

## 5. Deploy → verify (in the worktree)
- FTP theme/mu-plugins via `scripts/ftp_deploy_site_wp_content.py`; QR images via FTP to `wp-content/uploads/ea-legacy/qr/`; Moksha via REST. Cache-bust HTTP checks (`?cb=$(date +%s)$RANDOM`).
- AC-01: all **48** `/qr/qrN/` → 200 (automated loop against the inventory CSV). AC-02: /about/moksha content+image+link. AC-03: /press ≥5 articles, external links new-tab. AC-04: FB Top-5 text+image(rehosted)+link. AC-05: external links new-tab + `validate_aos.sh` **0 FAIL**.
- Staging host: `http://eyalamit-co-il-2026.s887.upress.link`.

## 6. SSoT note (carry to gate)
Spec was corrected **QR 49→48** (verified: 48 distinct qrN in dump + inventory; 49th was parent `/qr/`). team_190 owes a brief **re-confirm of the count** at L-GATE_VALIDATE — flag it; do not treat 48 as a defect.

## 7. Cross-engine (IR#1) + commits
Builder team_10 (Claude). L-GATE_BUILD team_50 NON-Claude. L-GATE_VALIDATE team_190 native Codex.
Commit **surgically by file path — never `git add -A`**. Do NOT push. Completion report → `_COMMUNICATION/team_100/W2-07-BUILD-REPORT-2026-05-29.md` (files, 48 QR HTTP codes, image-rehost resolution table, unresolved-image flags, testimonials source, validate result, blockers).

## 8. Out of scope
Rewriting QR/Moksha/press content (migration only); SEO/index page for QR (F2); W2-08 EN landing (separate WP).

## 9. Activation prompt (paste into builder session on team_00 go)
```
You are team_10 (builder), AOS eyalamit spoke. Build WP-W2-07 (Heritage).
Worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-07 (branch feature/w2-07-heritage).
Read in full FIRST: this mandate (_COMMUNICATION/team_10/MANDATE-TEAM10-W2-07-HERITAGE-2026-05-29.md)
+ spec (_aos/work_packages/S002/WP-W2-07/LOD400_spec.md). Mirror W2-02/04/05 patterns
(inc/wave2-w2-05.php, page-templates/tpl-shop-item.php, mu-plugins/ea-w2-05-shop-pages-seed-once.php,
inc/wave2-w2-02.php, inc/wave2-stage-b.php). Deliver: 48 QR pages (seeded w/ real post_content from
W2-07-QR-CONTENT-EXPORT json, images rehosted to wp-content/uploads/ea-legacy/qr/ — resolve via
catalog.json legacy_relative mapping then legacy uploads dir; flag unresolved), tpl-qr.php + router
wave2-w2-07.php; /press (26 links, ≥5, new-tab); /about/moksha (update page ID 181 via REST from the
docx); FB Top-5 testimonials (text from wave2-w2-04-content.php + rehosted images). STEP 0: resolve
QR image sourcing and report before full build. D-14 tokens only; style.css 1.4.5. Deploy (FTP +
REST + image upload), cache-bust. Verify 48 QR 200 + /press + /about/moksha + testimonials +
validate_aos 0 FAIL. Commit surgically (NO git add -A). Report to _COMMUNICATION/team_100/.
```

*team_100 — 2026-05-29 — READY TO DISPATCH.*
