---
id: FIX-REPORT-CHAPTERS-FULLSITE-FIXROUND-2026-06-23
from_team: team_110 (Remediation implementer)
to_team: team_190, team_100, team_00
date: 2026-06-23
mandate: _COMMUNICATION/team_190/MANDATE-TEAM110-CHAPTERS-FULLSITE-FIXROUND-2026-06-23.md
repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home)
staging: http://eyalamit-co-il-2026.s887.upress.link
status: READY_FOR_FOCUSED_RECHECK
delivery: file-transport (ADR043 §4/§5)
---

# READY FOR FOCUSED RE-CHECK — team_190

team_110 fix round complete. Please run focused re-validation on **SEO head** (F110-01, post-deploy) and **blog archive** (F110-02, F110-03).

| Item | Path |
|------|------|
| **Fix report** | `_COMMUNICATION/team_110/FIX-REPORT-CHAPTERS-FULLSITE-FIXROUND-2026-06-23.md` |
| **Evidence root** | `_COMMUNICATION/team_110/evidence/chapters-fullsite-fixround-2026-06-23/` |
| **Code changed** | `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php` |
| **QA helpers added** | `scripts/qa/seo-head-probe.mjs`, `scripts/qa/blog-archive-permalink-check.mjs` |
| **Impacted criteria** | SEO meta description (F110-01); blog archive brand + permalinks (F110-02, F110-03) |

---

# Fix report — Chapters full-site fix round

## Summary

| Finding | Severity | Closure | Notes |
|---------|----------|---------|-------|
| **F110-01** | Medium | **CODE COMPLETE** — live SEO pass **pending deploy** | Meta descriptions added in theme; staging still pre-fix |
| **F110-02** | Medium | **CLOSED (live)** | Brand absent on `/blog/` + `/blog/page/2/`; team_100 mu-plugin already on staging |
| **F110-03** | Medium | **CLOSED (live)** | Flagged podcast slug + all archive permalinks return HTTP 200 |

Content accuracy regression: **PASS** (ledger-adjusted, 99.6% weighted). axe / h1+dir / qa_probe: **PASS** on affected routes.

---

## F110-01 — Missing description meta

### What changed

**File:** [`site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php`](../../site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php)

1. Added `ea_w2_09_trim_description()` helper (shared ~157-char trim).
2. In `ea_w2_09_route_description()`: when `ea_chapters_is_view()`, derive description from seeded `phero.sub` (verbatim hero copy — no new prose).
   - `/books/vekatavta/` ← `vekatavta-defaults.php`
   - `/eyal-amit/mokesh-dahiman/` ← `mokesh-defaults.php`
3. In `ea_w2_09_meta_description()`: replaced `/en/` skip with emission of existing EN hero subtitle from `tpl-chapters-en.php`:
   - `Didgeridoo-based breath work, sound healing and lessons — Pardes Hanna, Israel.`

Canonical, single `og:image`, and Yoast `@graph` are untouched.

### Verification

| Artifact | Result |
|----------|--------|
| Pre-deploy live probe | [`evidence/.../seo/seo_head_checks.json`](evidence/chapters-fullsite-fixround-2026-06-23/seo/seo_head_checks.json) — `metaDescriptionCount: 0` on vekatavta/mokesh/en (expected until deploy) |
| Post-deploy expectation | [`evidence/.../seo/seo_head_expected_post_deploy.json`](evidence/chapters-fullsite-fixround-2026-06-23/seo/seo_head_expected_post_deploy.json) |
| Re-run after deploy | `node scripts/qa/seo-head-probe.mjs --out _COMMUNICATION/team_110/evidence/.../seo` |

**team_00 action:** authorize FTP deploy of `wave2-w2-09.php` (or full `site/wp-content` sync) so team_190 can confirm live `metaDescriptionCount: 1` on all three routes.

---

## F110-02 — Retired brand on blog archive

### What changed

**No new code.** Existing fix from team_100 (2026-06-23):

- [`site/wp-content/mu-plugins/ea-w2-06b-blog-title-brand-once.php`](../../site/wp-content/mu-plugins/ea-w2-06b-blog-title-brand-once.php) — scrubs `סטודיו נשימה מעגלית` from blog **titles only**; slugs preserved.

### Verification

| Check | Result | Evidence |
|-------|--------|----------|
| curl grep on live HTML | **0 hits** `/blog/`, `/blog/page/2/` | [`seo/blog_brand_grep.json`](evidence/chapters-fullsite-fixround-2026-06-23/seo/blog_brand_grep.json) |
| qa_probe forbidden-term scan | **0 failures**, `forbiddenFound: []` | [`qa_probe/qa_probe_result.json`](evidence/chapters-fullsite-fixround-2026-06-23/qa_probe/qa_probe_result.json) + screenshots |

Historical post **bodies** may still contain the brand (TITLES-only scope per team_00); archive cards do not surface it.

---

## F110-03 — Broken blog permalink (podcast `…עמית-2/`)

### What changed

**No code change required.** team_50's single 404 was transient; live staging consistently returns **HTTP 200**.

### Verification

| Check | Result | Evidence |
|-------|--------|----------|
| curl -sI flagged slug `-2` | **200** | manual + [`seo/blog_archive_permalink_checks.json`](evidence/chapters-fullsite-fixround-2026-06-23/seo/blog_archive_permalink_checks.json) |
| curl -sI non-`-2` variant | **200** | same |
| All archive card permalinks (pages 1–2) GET | **24/24 → 200**, 0 failures | [`seo/blog_archive_permalink_checks.json`](evidence/chapters-fullsite-fixround-2026-06-23/seo/blog_archive_permalink_checks.json) |

**Note:** `seo/blog_link_checks.json` (broad HEAD crawl) has false positives (external fonts, xmlrpc 403, HEAD timeouts on long Hebrew URLs). Mandate closure uses focused GET probe above.

---

## QA regression suite (mandate §4)

| Gate | Command / tool | Exit | Evidence |
|------|----------------|------|----------|
| Content accuracy | `content-diff.mjs` | 0 | [`content/summary.json`](evidence/chapters-fullsite-fixround-2026-06-23/content/summary.json) — 99.6% weighted, ledger-adjusted PASS |
| axe a11y | `http-qa-axe.cjs` (5 routes) | 0 | [`axe/axe-http.json`](evidence/chapters-fullsite-fixround-2026-06-23/axe/axe-http.json) — 0 crit / 0 serious |
| h1 + dir | `h1-rtl-http-probe.cjs` (5 routes) | 0 | [`h1-rtl/h1-rtl-http-probe.json`](evidence/chapters-fullsite-fixround-2026-06-23/h1-rtl/h1-rtl-http-probe.json) — 5/5 PASS |
| Overflow + forbidden terms | `qa_probe.mjs` (`/blog/`, `/blog/page/2/`) | 0 | [`qa_probe/qa_probe_result.json`](evidence/chapters-fullsite-fixround-2026-06-23/qa_probe/qa_probe_result.json) — verdict PASS |

---

## Remaining risks / notes

1. **F110-01 live closure** blocked on deploy (constitutional: team_110 did not deploy).
2. **Duplicate podcast posts** (`…עמית/` vs `…עמית-2/`) — both 200; optional de-dup + 301 later with Eyal approval (non-blocking).
3. **12 legacy posts** may reference retired brand in body text on single-post pages (not archive); outside F110-02 scope.
4. **No merge / push** performed — awaiting team_00 explicit approval.

---

*team_110 — 2026-06-23 — Chapters full-site fix round. File-transport hand-back to team_190 for focused re-check.*
