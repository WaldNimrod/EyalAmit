---
id: MANDATE-TEAM10-W2-06-BLOG-MIGRATION-2026-05-28
title: team_10 mandate — WP-W2-06 Blog Migration (54 posts + 6 categories + 126 tags)
status: ACTIVE — execute in a fresh team_10 session (Cursor recommended; PARALLEL to W2-02)
date: 2026-05-28
from_team: team_00 (nimrod, Principal) via team_100
to_team: team_10 (Development / WordPress / Cursor) + team_40 (Media)
parent_lod200: ../team_100/WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md (§WP-W2-06)
parent_unblock: ../team_190/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v4.0.0.md (PASS — Stage B closed 2026-05-28)
parent_closure: ../team_100/STAGE-B-IMPL-CLOSURE-REPORT-2026-05-28.md
profile: L0
wp: WP-W2-06 — Blog Migration
parallel_track: WP-W2-02 — Core Content (separate session, no merge conflict expected)
---

# מנדט team_10 — WP-W2-06 Blog Migration

## 0. הקשר ואישור התחלה

Stage B Impl PASS 2026-05-28. ה-blog templates (`tpl-blog-archive.php` + `tpl-blog-single.php`) כבר נמצאים בתמה ועובדים על D-14 tokens. WP זה מבצע **מיגרציה — לא כתיבה.** 54 פוסטים מהאתר הישן מוזנים ל-WP החדש, עם שמירת מבנה IA + slugs ל-301.

## 1. סקופ

| Item | Count | Source |
|------|-------|--------|
| פוסטים | 54 | `https://www.eyalamit.co.il/Blog/*` (legacy WP export) |
| קטגוריות | 6 | per `ACCURATE-SITE-MAPPING-AFTER-ARCHIVE` |
| תגיות | 126 | per `ACCURATE-SITE-MAPPING-AFTER-ARCHIVE` |
| תמונות נלוות | usage_count > 0 | media inventory F1 |
| 301 redirects | 54 | `/Blog/<slug>/` → `/blog/<slug>/` (Hebrew WP capital-B sensitivity — verify) |

### Scope — OUT
- כתיבת תוכן חדש (לא בסקופ — מיגרציה בלבד).
- בלוג EN (WP-W2-08).
- Shortcodes ישנים מורכבים (Elementor / Visual Composer) — 5-10 פוסטים "מורכבים" יומרו ידנית, השאר plain text.

## 2. תוצרים נדרשים

### Code
- ייתכן תוסף קל ל-`tpl-blog-archive.php` (פגינציה + filter קטגוריה) — אם חסר מ-Stage B.
- ייתכן shortcode-stripping mu-plugin (`ea-blog-shortcode-cleanup.php`) להמרה אוטומטית של 80% מהפוסטים.

### Migration
- WXR export מהאתר הישן: `site/exports/blog-legacy.wxr` (ייבוא דרך WP admin → Tools → Import או DB-direct).
- 6 קטגוריות נוצרות לפי מיפוי קנוני.
- 126 תגיות.
- תמונות נלוות מועלות לספריית מדיה: `site/wp-content/uploads/blog-migrated/<year>/<month>/`.
- 301 redirects רשומים ב-301 tool (כבר כלולים באינוונטר 301 שאייל שלח 2026-05-27 — 135 פריטים).

## 3. Acceptance Criteria

- [ ] AC-01: 54 URLs פעילים תחת `/blog/<slug>/` — HTTP 200 כל אחד.
- [ ] AC-02: כל פוסט שומר על author, date, tags, categories מהמקור.
- [ ] AC-03: תמונות פעילות (לא 404).
- [ ] AC-04: ארכיון `/blog/` מציג פגינציה + פילטר קטגוריה.
- [ ] AC-05: 301 מ-`/Blog/*` → `/blog/*` עובד (curl -I → 301).
- [ ] AC-06: validate_aos.sh 0 FAIL.
- [ ] AC-07: 5-10 פוסטים "מורכבים" (עם shortcodes ישנים) מוסבים ידנית ומאומתים ויזואלית.
- [ ] AC-08: Style.css Version bumped (1.3.9 → 1.4.0 — coordinate with W2-02 if both bump at once).

## 4. Cross-engine + QA chain

Same posture as W2-02 — fresh IR#1 chain:
- **Builder:** cursor-composer (Cursor).
- **L-GATE_BUILD validator (team_50):** ≠ cursor (claude-sonnet sub-agent acceptable).
- **L-GATE_VALIDATE (team_190):** Codex/OpenAI native.

## 5. Risks + mitigations

| Risk | Severity | Mitigation |
|------|----------|------------|
| Legacy blog images missing / 404 | Medium | `usage_count` filter + placeholder for missing |
| Old shortcodes (Elementor etc.) leak into content | High | shortcode-strip mu-plugin + manual cleanup for the 5-10 "complex" |
| 54 redirects collide with 301 tool's existing entries | Low | Pre-check overlap with the 135-item 301 inventory before publish |
| Image upload bloats `wp-content/uploads/` past uPress quota | Low-Med | Verify uploads quota with Eyal before mass-import |

## 6. Parallelism with W2-02

Two parallel team_10 sessions. Coordination:
- W2-02 owns: home, method, treatment, about, faq, contact pages.
- W2-06 owns: blog archive + 54 posts.
- Shared files at risk:
  - `functions.php` — both might add a require_once. **Mitigation:** Stage B already requires `inc/wave2-stage-b.php`. W2-02 adds `inc/wave2-w2-02.php`, W2-06 adds `inc/wave2-w2-06.php`. Single require_once line per file; commit independently.
  - `style.css` Version — coordinate version bump (both can target 1.4.0; whoever lands second rebases).
- Pre-merge: each session pushes its own branch (W2-02 → `feature/w2-02-content`; W2-06 → `feature/w2-06-blog`) and merges to main only after team_50 PASS.

## 7. Deliverables

| Artifact | Path |
|----------|------|
| Completion report | `_COMMUNICATION/team_10/W2-06-COMPLETION-REPORT-2026-05-28.md` |
| WXR export | `site/exports/blog-legacy.wxr` |
| Shortcode cleanup mu-plugin (if needed) | `site/wp-content/mu-plugins/ea-blog-shortcode-cleanup.php` |
| 301 tool entries | shared `301-inventory.json` (already 135 items per Eyal 2026-05-27 — verify 54 blog entries present) |

## 8. Estimate

**5-7 days**:
- DB import + WXR: 2d
- Image migration + 404 cleanup: 1d
- Templates polish (archive pagination + filter): 1.5d
- Manual cleanup of 5-10 complex posts: 1d
- QA + 301 verification: 1.5d

## 9. First action

`team_10` session opens, reads this mandate + WAVE2-WORK-PACKAGES-LOD200 §WP-W2-06 + the legacy WXR (export from old WP first if not yet exported). Then drafts `W2-06-PLAN-2026-05-28.md` with day-by-day breakdown.

## 10. Activation Prompt

```
HANDOFF_DEPTH: full
ACTIVATION_SCOPE: team_10 only — WP-W2-06 Blog Migration

Identity: team_10 (Developer / WordPress / Cursor) + team_40 collab on media
Engine: cursor-composer recommended.

Mandate (FIRST READ):
  /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_COMMUNICATION/team_10/MANDATE-TEAM10-W2-06-BLOG-MIGRATION-2026-05-28.md

Context:
  - LOD200: _COMMUNICATION/team_100/WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-06
  - Stage B closure: _COMMUNICATION/team_100/STAGE-B-IMPL-CLOSURE-REPORT-2026-05-28.md
  - Site mapping: docs/project/ACCURATE-SITE-MAPPING-AFTER-ARCHIVE*.md
  - Existing 301 inventory: docs/project/301-decisions-*.json (135 items, 54 blog entries)
  - Legacy WP: https://www.eyalamit.co.il/Blog/* (export WXR first if not done)

Working dir: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
Target staging URL: https://eyalamit-co-il-2026.s887.upress.link

First action: draft W2-06-PLAN-2026-05-28.md (day-by-day) + export WXR from legacy. Submit plan to team_100 for sign-off.

Iron Rules same as W2-02 mandate. Branch: feature/w2-06-blog. Merge to main only after team_50 PASS.

Deliverables per mandate §7. AC checklist per §3.

Notify team_00 + team_100 on completion via _COMMUNICATION/team_10/W2-06-COMPLETION-REPORT-2026-05-28.md.
```

## 11. Version

| Date | Action |
|------|--------|
| 2026-05-28 | Mandate authored by team_100 right after Stage B closure. Parallel to W2-02 mandate. |
