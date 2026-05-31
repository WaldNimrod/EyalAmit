---
id: MANDATE-TEAM10-W2-02-CORE-CONTENT-2026-05-28
title: team_10 mandate — WP-W2-02 Core Content (6 pages — Home, השיטה, טיפול, אודות, FAQ, צור קשר)
status: ACTIVE — execute in a fresh team_10 session (Cursor recommended; same toolchain as Stage B)
date: 2026-05-28
from_team: team_00 (nimrod, Principal) via team_100
to_team: team_10 (Development / WordPress / Cursor)
parent_lod200: ../team_100/WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md (§WP-W2-02)
parent_unblock: ../team_190/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v4.0.0.md (PASS — Stage B closed 2026-05-28)
parent_closure: ../team_100/STAGE-B-IMPL-CLOSURE-REPORT-2026-05-28.md
team_00_disposition_reference: ../team_00/DISPOSITION_IR1_WAIVER_WP-W2-01-STAGE-B-IMPL_2026-05-27.md (narrow; does NOT auto-apply to this WP — fresh IR#1 chain starts here)
profile: L0
wp: WP-W2-02 — Core Content
combo: C (X3 Wave parallel + Y3 Atoms-first LOD400)
parallel_track: WP-W2-06 — Blog Migration (can run in a SEPARATE session in parallel)
---

# מנדט team_10 — WP-W2-02 Core Content

## 0. הקשר ואישור התחלה

**Stage B Impl נסגר L-GATE_VALIDATE PASS** ב-2026-05-28 (team_190 GPT-5.5, commit `9182870`). כל ה-Wave2 infrastructure (D-14 tokens, 12 blocks, 13 templates, CF7, footer, analytics scaffold) חי בסטייג'ינג ועובד.

**ה-WP הזה מקבל את התשתית ומחבר אליה תוכן.** לא בונים atoms חדשים. רק מרכיבים בלוקים קיימים עם תוכן אמיתי + יוצרים עמודי WP בפועל.

## 1. סקופ — 6 עמודי תוכן בליבת המוצר

| # | עמוד | slug | template | מקור תוכן | בלוקים |
|---|------|------|----------|------------|---------|
| 1 | דף הבית | `/` | `tpl-home.php` | `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/דף הבית/homepage1-3 v2.md` | 12 (כמו ב-/wave2-test/) |
| 2 | השיטה — cbDIDG | `/method` | `tpl-content.php` (or new `tpl-method.php` if blocks differ materially) | `…/השיטה/method.md` | 12 |
| 3 | טיפול בדיג'רידו | `/treatment` | `tpl-service.php` | `…/טיפול בדיג'רידו/treatment.md` | 10 |
| 4 | אודות אייל | `/about` | `tpl-content.php` | legacy site slug "אייל-עמית-אודות" (1:1 migration); add sub-link to `/about/moksha` | content-driven |
| 5 | FAQ | `/faq` | `tpl-faq.php` | `…/דף FAQ/FAQ FINAL.md` (4 categories, ~36 questions, tag system) | FAQ block + filter UI |
| 6 | צור קשר | `/contact` | `tpl-contact.php` (NEW — needs creation; embeds CF7 form id from Stage B) | טופס בלבד | CF7 shortcode + footer |

## 2. תוצרים נדרשים

### Code (theme additions)
- **Optionally new template**: `tpl-method.php` if the Home blocks don't cover method exactly (probably reuse `tpl-content.php`).
- **NEW template**: `tpl-contact.php` (referenced in Stage B `ea_wave2_dequeue_unused_styles()` conditional — keep CF7 CSS only on this template).
- **Hero block tuning**: real H1/sub from `homepage1-3 v2.md` (currently smoke page uses placeholders).
- **FAQ block**: filterable UI per `FAQ FINAL.md` (4 categories, tag system). May need new `block-faq-list.php` + JS.
- **About-sub-link**: `/about/moksha` page link injection.

### Content (WP DB)
- 6 WP pages published with correct slugs + Page Template attribute.
- Content imported from `25.5.26` markdown sources into `wp_posts` + `wp_postmeta`.
- FAQ taxonomies: `faq_category` (4 entries) + `faq_tag` (per FAQ FINAL.md).
- 301 redirect from legacy `אייל-עמית-אודות` → `/about` (use existing 301 tool).

### Deploy
- FTPS deploy via `scripts/ftp_deploy_site_wp_content.py` (canonical pattern from Stage B R4).
- All 6 pages live on staging: HTTP 200, render correctly, RTL OK, blocks rendered.

## 3. Acceptance Criteria

- [ ] AC-01: 6 page URLs return HTTP 200 on staging within <3s.
- [ ] AC-02: H1 on each page matches `25.5.26` source 1:1 (no rephrasing).
- [ ] AC-03: All 6 pages use Wave2 templates (no legacy GeneratePress default).
- [ ] AC-04: FAQ filter UI works — category select + tag select narrow the question list client-side.
- [ ] AC-05: `/contact` shows the CF7 form id from Stage B; CF7 CSS loads only on this page (verify dequeue exception in `ea_wave2_dequeue_unused_styles`).
- [ ] AC-06: About-moksha sub-link reachable from `/about`.
- [ ] AC-07: 301 redirect from legacy slug works (`curl -I /אייל-עמית-אודות/` → 301 → `/about`).
- [ ] AC-08: `validate_aos.sh` 0 FAIL.
- [ ] AC-09: F-R2-02 mobile `<p>` text-align cleanup applied if any real `<p>` regression observed (IDEA-002).
- [ ] AC-10: Theme `style.css` Version bumped (1.3.9 → 1.4.0 for the content release).

## 4. Cross-engine + QA chain (fresh start — disposition d761422 does NOT apply here)

This WP's IR#1 chain restarts cleanly:
- **Builder (team_10):** recommended `cursor-composer` (Cursor IDE — same toolchain as Stage B, fluent for WP template + DB work).
- **L-GATE_BUILD validator (team_50):** MUST be ≠ cursor-composer. Acceptable: claude-sonnet sub-agent (under team_100 orchestration) — the pattern that worked for Stage B R5. NO team_00 waiver needed: the original builder is just cursor.
- **L-GATE_VALIDATE (team_190):** native Codex/OpenAI/GPT-5 (same as Stage B R3-final).

Cross-engine rule is **clean** for this WP — no R3/R4 patches in the chain yet, so the "no claude" tightening from Stage B does not carry over.

## 5. Phase 1 vs Phase 2 (same split as Stage B)

- **Phase 1** (this WP): structure + content + render + a11y + perf. No mail/analytics gating.
- **Phase 2** (separate cycle): VC-15..VC-18 from Stage B carry-forward — gated on:
  - SMTP delivery confirmation (IDEA-004, partially closed by nimrod's uPress credentials update)
  - GA4 Measurement ID (IDEA-003, pending Eyal)
  - Clarity Project ID (IDEA-003, pending Eyal)

W2-02 must NOT block on Phase-2 inputs. Render the GA4/Clarity scaffolding using `analytics-config.json` placeholders — when Eyal fills, the placeholder substitution activates automatically (per `inc/analytics-config.json` pattern).

## 6. Parallelism with W2-06

W2-06 (blog migration) can run in a **separate team_10 session** in parallel. Two WPs share the theme repo but operate on different page sets and different template files:
- W2-02: tpl-home / tpl-content / tpl-service / tpl-faq / tpl-contact / tpl-about → 6 core pages.
- W2-06: tpl-blog-archive / tpl-blog-single → 54 posts + 6 categories + 126 tags.

Merge conflict risk: `functions.php` if both touch enqueue or filter hooks. Mitigation: each WP adds its own `inc/wave2-w2-02.php` or `inc/wave2-w2-06.php` and require_once from `functions.php` once at top. Coordinate via team_100 if both sessions need to touch `functions.php`.

## 7. Deliverables

| Artifact | Path |
|----------|------|
| Completion report | `_COMMUNICATION/team_10/W2-02-COMPLETION-REPORT-2026-05-28.md` |
| Code: new tpl-contact + tpl-method (if) | `site/wp-content/themes/ea-eyalamit/page-templates/` |
| Code: FAQ block + JS | `site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-faq-list.php` + `assets/js/ea-faq-filter.js` |
| FTPS deploy | via `scripts/ftp_deploy_site_wp_content.py` (or `/tmp/ftp_deploy_w2_02.py` for delta) |
| QA mandate to team_50 | filed automatically after completion (team_100 issues) |

## 8. Estimate

**7-10 days** (Eyal's earlier estimate). Sub-breakdown:
- Template tuning + new tpl-contact: 1d
- FAQ block + filter UI: 1.5d
- Content import to WP DB: 2d (largest variable — 6 pages with rich markdown)
- 301 + about-moksha: 0.5d
- Polish + intra-team QA: 1d
- Buffer: 1d

## 9. First action

`team_10` session opens, reads this mandate + WAVE2-WORK-PACKAGES-LOD200 §WP-W2-02 + D-14 LOD400 §5 (Templates) + Stage B closure report. Then drafts `W2-02-PLAN-2026-05-28.md` with day-by-day breakdown before any code change.

## 10. Activation Prompt

```
HANDOFF_DEPTH: full
ACTIVATION_SCOPE: team_10 only — WP-W2-02 Core Content (6 pages)

Identity: team_10 (Developer / WordPress / Cursor)
Engine: cursor-composer recommended (same toolchain as Stage B).

Mandate (FIRST READ):
  /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_COMMUNICATION/team_10/MANDATE-TEAM10-W2-02-CORE-CONTENT-2026-05-28.md

Context:
  - LOD200: _COMMUNICATION/team_100/WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-02
  - D-14 LOD400: _COMMUNICATION/team_100/EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md (and D-14 design)
  - Stage B closure: _COMMUNICATION/team_100/STAGE-B-IMPL-CLOSURE-REPORT-2026-05-28.md
  - Content sources: docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/

Working dir: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
Target staging URL: https://eyalamit-co-il-2026.s887.upress.link

First action: draft W2-02-PLAN-2026-05-28.md (day-by-day breakdown). Submit to team_100 for sign-off before code changes.

Iron Rules:
  - Single logical writer on roadmap.yaml (team_100 only — do not edit _aos/)
  - Cross-engine: your builder = cursor-composer; QA validator must differ
  - Inter-team comms via _COMMUNICATION/team_10/ artifacts
  - All site files under site/wp-content/themes/ea-eyalamit/

Deliverables per mandate §7. AC checklist per §3. Commit pattern:
  "feat(W2-02): {scope} — Team 10"  and push.

Notify team_00 + team_100 on completion via _COMMUNICATION/team_10/W2-02-COMPLETION-REPORT-2026-05-28.md.
```

## 11. Version

| Date | Action |
|------|--------|
| 2026-05-28 | Mandate authored by team_100 right after Stage B closure; ready for nimrod to dispatch (separate Cursor session). |
