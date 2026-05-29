---
id: W2-07-BUILD-REPORT-2026-05-29
from_team: team_10 (Builder, Claude)
to_team: team_100 (Chief System Architect)
wp: WP-W2-07 — Heritage (Press + Moksha + 48 QR + FB Top-5 testimonials)
date: 2026-05-29
branch: feature/w2-07-heritage
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-07
staging: http://eyalamit-co-il-2026.s887.upress.link
status: BUILD COMPLETE — all 5 ACs PASS
---

# WP-W2-07 Build Report

## Summary
All four deliverables built, deployed to staging, and verified. All acceptance
criteria pass. No commits pushed; surgical commit performed on the feature branch
(see Commit section). Cross-engine: built by team_10 (Claude); L-GATE_BUILD owed
to team_50 (non-Claude), L-GATE_VALIDATE to team_190 (Codex).

## Acceptance criteria — result
| AC | Criterion | Result |
|----|-----------|--------|
| AC-01 | 48 QR URLs `/qr/qrN/` → 200 (loop vs inventory) | **PASS — 48/48 → 200** |
| AC-02 | /about/moksha content + image + link to /about | **PASS** (heading "ומה היום", rehosted image, back-link, migrated text) |
| AC-03 | /press ≥5 (all 26) external links new-tab | **PASS — 26/26 links, all `target=_blank rel=noopener noreferrer`** |
| AC-04 | FB Top-5 testimonials text + image + link | **PASS — 5 cards on /press, FB links new-tab; avatars = grey placeholder (spec F05 acceptable)** |
| AC-05 | external links new-tab + `validate_aos.sh` 0 FAIL | **PASS — validate_aos: 30 PASS / 18 SKIP / 0 FAIL** |

## Files touched
NEW:
- `site/wp-content/mu-plugins/ea-w2-07-qr-seed-once.php` — once-only seeder (parent `qr` + 48 children + `press`), guards mirror W2-05; seeds real post_content; KSES disabled during the controlled migration so YouTube `<iframe>` embeds survive insert; flag `ea_w2_07_qr_seeded_v3`.
- `site/wp-content/mu-plugins/ea-w2-07-qr-content-data.php` — generated seed data (48 pages; DO NOT hand-edit).
- `site/wp-content/themes/ea-eyalamit/page-templates/tpl-qr.php` — thin QR shell (copy of tpl-shop-item), `main.ea-wave2-qr`, the_content().
- `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-07.php` — router (press routing + shell flags + body class + sidebar + GP-title + W2-07 CSS enqueue), /press the_content render (26 links), FB Top-5 testimonial render.
- `site/wp-content/themes/ea-eyalamit/inc/data/w2-07-press.json` — press export copied into theme for runtime read.
- `site/wp-content/themes/ea-eyalamit/assets/css/w2-07-heritage.css` — D-14 tokens only (no raw hex).
- `scripts/build_w2_07_qr_data.py` — reproducible migration generator (shortcode/embed/img normalisation).
- `scripts/update_moksha_page.py` — REST update of page 181 from the docx.

MODIFIED:
- `site/wp-content/themes/ea-eyalamit/functions.php` — require_once wave2-w2-07.php.
- `site/wp-content/themes/ea-eyalamit/inc/wave2-stage-b.php` — added `page-templates/tpl-qr.php` to `ea_wave2_is_active_view`.
- `site/wp-content/themes/ea-eyalamit/style.css` — Version 1.4.4 → **1.4.5**.
- `scripts/ftp_deploy_site_wp_content.py` — added the two W2-07 mu-plugins to the upload list + existence checks.

## Content migration notes (1:1 text; layout/embed normalised only)
WPBakery shortcodes in the legacy bodies were normalised, not rewritten:
- `[vc_video link=…]` → responsive YouTube/Vimeo `<iframe>` (FB-video → external link). 58 YT + 1 vimeo + 1 fb across the set.
- `[caption]…[/caption]` → unwrapped (inner img/text kept).
- `[vc_row]/[vc_column]/[vc_column_text]/[vc_empty_space]` → stripped (layout-only).
- `[envira-gallery]` → removed (legacy gallery, no source).
- Legacy Flickr Flash `<object>/<embed>` slideshows (qr21, 6 images) → converted to rehosted `<img>` tags.
- Legacy internal links `http://localhost:9090/PATH` → site-relative `/PATH` (never left live). **0 localhost URLs remain** in any seeded body.

## Image resolution table (41 refs; 12 rehosted, 29 omitted refs = 28 distinct absent paths)
REHOSTED → `wp-content/uploads/ea-legacy/qr/` (all verified HTTP 200 on staging):
| QR | source | legacy ref | rehosted path |
|----|--------|-----------|---------------|
| qr14 | mongabay (download) | photos.mongabay.com/06/braz_defor_88-05-lrg.jpg | /…/qr/mongabay_braz_defor_88-05.jpg |
| qr21 | flickr (download, ex-Flash) | farm3…/4030994475_…_o.jpg | /…/qr/flickr_4030994475.jpg |
| qr21 | flickr (download, ex-Flash) | farm3…/4030995601_…_o.jpg | /…/qr/flickr_4030995601.jpg |
| qr21 | flickr (download, ex-Flash) | farm3…/4030994831_…_o.jpg | /…/qr/flickr_4030994831.jpg |
| qr21 | flickr (download, ex-Flash) | farm4…/4030995255_…_o.jpg | /…/qr/flickr_4030995255.jpg |
| qr21 | flickr (download, ex-Flash) | farm3…/4030995031_…_o.jpg | /…/qr/flickr_4030995031.jpg |
| qr21 | flickr (download, ex-Flash) | farm3…/4031748522_…_o.jpg | /…/qr/flickr_4031748522.jpg |
| qr28 | legacy uploads | 2016/12/eat2-450x297.jpg | /…/qr/eat2-450x297.jpg |
| qr28 | legacy uploads | 2016/12/eat1-450x297.jpg | /…/qr/eat1-450x297.jpg |
| qr32 | legacy uploads | 2024/08/378172116…-450x448.jpg | /…/qr/378172116…-450x448.jpg |
| qr33 | legacy uploads | 2016/12/color-1024x437.jpg | /…/qr/color-1024x437.jpg |
| qr42 | legacy uploads | 2016/12/IMG_7784-1024x943.jpg | /…/qr/IMG_7784-1024x943.jpg |

OMITTED (29 refs / 28 distinct paths) — `<img>` removed, surrounding text kept; NO live localhost URL.
qr1 2016/08/eyal.jpg · qr2 brazil1.jpg, בוליביה.jpg, בוליביה1-4.jpg, צבע-בכחול-וזרוק-לים-אייל-עמית.jpg, brazil-anat.jpg, brazil-anat2.jpg · qr4 הרצוג-23-גבעתיים.jpg · qr12 מכרה1-1/2/3/5.jpg · qr13 עורב.jpg · qr14 פדרו.jpg · qr17 וראנסי.jpg, יוגי-לודג-וראנסי.jpg · qr30 2017/05/uni.jpg · qr31 CR-7.jpg · qr32 יואב-קליימן.jpg, אדם-ניוזילנד.jpg, יורם-סיון-ויאיר-גפני.jpg, מוקש.jpg, מוקש1.jpg, אייל-עמית-דיגרידו-רישיקש-1.jpg · qr41 בר-מצווה.jpg · qr48 2016/08/eyal.jpg (= qr1's, shared).

> **CARRY-FORWARD → team_40 (image recovery):** the 28 distinct omitted images do not
> exist locally (absent from legacy uploads backup, unmapped by curated catalogs,
> legacy localhost:9090 WP permanently offline). If Eyal can supply originals, drop
> them into `wp-content/uploads/ea-legacy/qr/`, add a mapping in
> `scripts/build_w2_07_qr_data.py`, regenerate, bump the seed flag, redeploy.

## Per-deliverable status
- **48 QR pages** — seeded under parent `/qr/` on `tpl-qr.php`; real migrated post_content; slugs/nesting per QR-URL-INVENTORY.csv (`qr/qrN`). All 48 → 200. YouTube embeds + 12 rehosted images render; 0 localhost leak. Verified samples: qr2/qr12 video embed=1; qr21 flickr imgs=6; qr28=2, qr33/qr42/qr32=1, qr14 mongabay=1.
- **/press** — root page `press` (seeded), routed via W2-07 router → tpl-content shell; the_content injects all **26** articles (year · title · source) each external link `target=_blank rel=noopener noreferrer`. HTTP 200.
- **/about/moksha** — existing page **ID 181** updated via REST (`scripts/update_moksha_page.py`, slug-guarded). Content = docx text ("ומה היום") + rehosted image `wp-content/uploads/ea-legacy/moksha/mukesh-dhiman-7-1024x792.jpg` (HTTP 200) + back-link to `/about/`. Page NOT recreated.
- **FB Top-5 testimonials** — rendered via the Wave2 testimonial accordion block on the /press heritage surface; text = the real FB Top-5 (sound-healing) from `inc/wave2-w2-04-content.php` with FB share links (5 cards, all FB links new-tab). Images: rehosted-when-available infra in place; FB profile photos unavailable → grey placeholder (spec F05/F04 acceptable; no new image dependency).

## Deploy
- FTP theme + mu-plugins via `scripts/ftp_deploy_site_wp_content.py` (incl. 2 new W2-07 mu-plugins).
- 12 QR images + 1 moksha image FTP-uploaded to `wp-content/uploads/ea-legacy/{qr,moksha}/` via `scripts/ftp_upload_uploads_dir.py`.
- Seeder triggered by homepage hits (init hook); re-seed via flag bump (v1→v3) to re-apply KSES-safe content + Flash-image fix.
- Moksha via REST POST to `/wp/v2/pages/181`.
- All HTTP checks cache-busted (`?cb=$(date +%s)$RANDOM`).

## SSoT note (carry to gate)
Count corrected QR **49 → 48** stands (48 distinct qrN; 49th = parent `/qr/`).
team_190 owes a brief re-confirm at L-GATE_VALIDATE per the spec correction — not a defect.

## Blockers
None for the gates. One non-blocking carry-forward: the 28 omitted QR images (team_40 image recovery, source no longer exists locally).
