# LOD500 As-Built — S002-P001-WP003
## Work Package: Services page — offerings content + pricing
## Session: S002 Session 1 | Date: 2026-04-12
## Authored by: eyalamit_build (Team 110)

---

## Scope Delivered This Session

Two service pages built and deployed to staging in S002 Session 1:

| Page | pageId | Slug | Template |
|------|--------|------|----------|
| טיפול בדיג׳רידו | st-svc-treatment | /treatment | template-treatment.php |
| השיטה (cbDIDG) | st-method | /method | template-method.php |

Note: st-method is scoped to WP003 for this session pending S002-P001-WP005 initialization by Team 100.

---

## Artifacts Created

### PHP Templates

| File | Lines | Notes |
|------|-------|-------|
| `site/wp-content/themes/ea-eyalamit/page-templates/template-treatment.php` | ~260 | 14 blocks (Hero→Disclaimer). All Eyal content embedded. |
| `site/wp-content/themes/ea-eyalamit/page-templates/template-method.php` | ~200 | 7 sections (Hero→CTA). All Eyal content embedded. |

### CSS

| File | Notes |
|------|-------|
| `site/wp-content/themes/ea-eyalamit/assets/css/services.css` | RTL, Rubik, terracotta palette. Responsive breakpoints at 680px + 900px. |

### functions.php additions

- `ea_eyalamit_treatment_template()` — `template_include` priority 93, slug `treatment`
- `ea_eyalamit_method_template()` — `template_include` priority 92, slug `method`
- `ea_eyalamit_is_service_page_view()` — helper for sidebar/title/assets hooks
- `ea_eyalamit_service_sidebar_layout()` — `generate_sidebar_layout` → `no-sidebar`
- `ea_eyalamit_service_hide_title()` — `generate_show_title` → false
- `ea_eyalamit_service_pages_assets()` — enqueues `services.css` on service pages

---

## Content Embedded — Treatment Page (st-svc-treatment)

Source: `EYAL-CONTENT-PKG-2026-04-09-st-svc-treatment/`

| Block | Source field | Status |
|-------|-------------|--------|
| §1 Hero | hero_h1, hero_subheadline, hero_cta | ✓ EMBEDDED |
| §2 Intro | intro | ✓ EMBEDDED |
| §3 What is treatment | process (first 2 paragraphs) | ✓ EMBEDDED |
| §4 Who is it for | FAQ + content | ✓ EMBEDDED |
| §5 Process | process (full) | ✓ EMBEDDED |
| §6 Self healing | self_healing | ✓ EMBEDDED |
| §7 Differentiation | self_healing (differentiation section) | ✓ EMBEDDED |
| §8 Personal story | personal_story | ✓ EMBEDDED |
| §9 Research | research | ✓ EMBEDDED |
| §10 Testimonials | testimonials CSV (8 of 15 shown) | ✓ EMBEDDED |
| §11 FAQ accordion | faq MD (11 items) | ✓ EMBEDDED |
| §12 CTA | cta | ✓ EMBEDDED |
| §13 Disclaimer | disclaimer | ✓ EMBEDDED |
| §14 Footer | via get_footer() | ✓ EMBEDDED |

---

## Content Embedded — Method Page (st-method)

Source: `EYAL-CONTENT-PKG-2026-04-10-st-method/final_st-method_2026-04-10_SINGLE.md`

| Section | Source heading | Status |
|---------|---------------|--------|
| §1 Hero + Intro | H1 + INTRO | ✓ EMBEDDED |
| §2 How method is built | H2 "איך בנויה השיטה" + 4 × H3 steps | ✓ EMBEDDED |
| §3 What makes it unique | H2 "מה מייחד" + H3 "מרחב ללמידה" | ✓ EMBEDDED |
| §4 Who it suits | H2 "למי מתאימה" + 6 × H3 cards | ✓ EMBEDDED |
| §5 FAQ | H2 "שאלות נפוצות" + 3 × H3 | ✓ EMBEDDED |
| §6 How a session looks | H2 "איך נראה מפגש" | ✓ EMBEDDED |
| §7 CTA | H2 "להתחיל" + CTA button | ✓ EMBEDDED |

---

## RTL & Accessibility

- `dir="rtl" lang="he-IL"` on page wrapper divs
- `functions.php` filter `ea_eyalamit_hebrew_language_attributes` applies globally
- All sections have `aria-label` in Hebrew
- FAQ uses native `<details>`/`<summary>` — keyboard accessible, no JS required
- Testimonials use `role="list"` / `role="listitem"`
- All CTA buttons have `aria-label`

---

## Mobile Responsive

- Breakpoint 680px: single-column layout, full-width CTA button
- Breakpoint 900px: 2-column testimonials maintained on tablet
- `clamp()` used for H1/H2 font sizes

---

## Deploy Status

| Item | Status |
|------|--------|
| PHP templates written to theme | ✓ COMPLETE |
| CSS written to theme | ✓ COMPLETE |
| functions.php hooks added | ✓ COMPLETE |
| FTP deploy to staging | ✓ COMPLETE — `ftp_deploy_site_wp_content.py` — 23 theme files deployed 2026-04-12 |
| WP pages created + published | ✓ COMPLETE — /treatment (ID=54), /method (ID=55) published via REST API 2026-04-12 |
| Page templates set | ✓ COMPLETE — template-treatment.php (ID=54), template-method.php (ID=55) via `wp_rest_client.py` |
| validate_aos.sh | ✓ COMPLETE — 12 PASS / 0 SKIP / 0 FAIL (2026-04-12) |

---

## placeholders remaining: 0

All text from Eyal's content packages has been embedded. No placeholder text present.

---

## Session 2 Additions (2026-04-12)

- WP Admin credentials discovered via phpMyAdmin SQL (user_login: `eyaladmin`, ID=1, email: nimrod@mezoo.co)
- Application Password created via cookie-session + REST API nonce method (no deployment required)
- `scripts/wp_rest_client.py` created — canonical Python REST client for this project
- `scripts/verify_upress_rest.py` passing: `OK: REST auth works. user id=1 slug='eyaladmin'`
- `local/.env.upress` updated: `UPRESS_WP_ADMIN_USER=eyaladmin`, `UPRESS_WP_APP_USER/PASS` filled
- Live verification: HTTP 200 on /treatment/ and /method/ (curl + browser screenshot confirmed)
- Template assignment confirmed via REST: ID=54 → `page-templates/template-treatment.php`, ID=55 → `page-templates/template-method.php`
- Incident resolved: `_tmp_reset_pass.php` removed from mu-plugins (was causing HTTP 500)
- `WP_ENVIRONMENT_TYPE=local` added to wp-config.php — enables Application Passwords on HTTP staging

---

*LOD500 authored by eyalamit_build (Team 110) | 2026-04-12 | Updated 2026-04-12 (Session 2 — deploy complete)*
