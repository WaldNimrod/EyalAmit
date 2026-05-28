---
id: QA-VERDICT-WP-W2-06-L-GATE-BUILD-2026-05-28
title: team_50 L-GATE_BUILD QA Verdict — WP-W2-06 Blog Migration (re-run)
date: 2026-05-28
from_team: team_50 (QA / L-GATE_BUILD)
to_team: team_100 (Chief System Architect)
wp: WP-W2-06
gate: L-GATE_BUILD
branch: feature/w2-06-blog
head_commit: 20c354f
fix_commit: 78edf9d (AC-04 template_include routing — verified ancestor of HEAD)
staging: http://eyalamit-co-il-2026.s887.upress.link
go_signal: _COMMUNICATION/team_50/GO-SIGNAL-W2-06-QA-2026-05-28.md
reqa_signal: _COMMUNICATION/team_50/REQA-SIGNAL-W2-06-2026-05-28.md
mandate: _COMMUNICATION/team_50/MANDATE-TEAM50-WAVE2-L-GATE-BUILD-2026-05-28.md
prior_verdict: FAIL (AC-04) — superseded by this re-run
status: ISSUED
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-06 — Blog Migration |
| Gate | L-GATE_BUILD |
| Verdict | **PASS_WITH_FINDINGS** |
| ACs passed | 8 of 8 (2 with non-blocking P3 notes) |
| Blocking AC | none |
| One-line next step | Route to **team_190 L-GATE_VALIDATE**; optional backlog: strip VC shortcodes from archive excerpts (P3) |

**AC authority:** Per GO-SIGNAL, posts live at root `/<slug>/` (not `/blog/<slug>/`); legacy `/Blog/<slug>/` → 301 → `/<slug>/`.

**Re-QA trigger:** AC-04 remediated in commit `78edf9d` (`ea_w2_06_template_include` routes `is_home()` → `tpl-blog-archive.php`, `is_singular('post')` → `tpl-blog-single.php`). Deployed to staging; independently re-verified 2026-05-28.

---

# §1 Engine Declaration (IR#1)

| Field | Value |
|-------|-------|
| engine | **Cursor Codex** (non-Claude — IR#1 compliant) |
| builder | claude-sonnet-4-6 (IR#1 — cross-engine disposition) |
| go_signal | `GO-SIGNAL-W2-06-QA-2026-05-28.md` |
| reqa_signal | `REQA-SIGNAL-W2-06-2026-05-28.md` |
| attestation | Independent re-verification with cache-bust on every HTTP request; did not rely on team_100 pre-checks alone |

**Repo gate:** `git log --oneline -1` → `20c354f`; `78edf9d` confirmed ancestor of HEAD.

---

# §2 Acceptance Criteria Results (8/8)

Base: `http://eyalamit-co-il-2026.s887.upress.link` — all requests appended `?cb=$(date +%s)$RANDOM`.

| AC | Check (GO-SIGNAL-corrected) | Method | Result | Evidence |
|----|----------------------------|--------|--------|----------|
| AC-01 | 54 posts → HTTP 200 at **root `/<slug>/`** (sample ≥10) | HEAD all 54 WXR slugs + 11-category sample | **PASS** | Status distribution: `{200: 54}`. Category sample 11/11 → 200. |
| AC-02 | author / date / categories / tags preserved; Wave2 single template | REST API + rendered HTML (3 samples incl. `18-הטור-…-מסך-הברזל`) | **PASS** | REST: 54 published; author `eyaladmin` (id 1); 54/54 categorized; 47 tags / 27 posts tagged. Rendered: `ea-wave2-shell`, `ea-blog-single-view`, `ea-post-meta` present; `ea-post-tags` on tagged posts. |
| AC-03 | post images load from **new site** (`/wp-content/uploads/…`); 6 dead-source refs excluded | Rendered-page `<img>` scan (121 unique URLs) + REST orphan check | **PASS** | Rendered: 121/121 → HTTP 200; 3 dead-source refs visible (excluded). REST content holds 2 orphaned 404 upload paths not rendered — see F-W2-06-05 (P3). |
| AC-04 | `/blog/` renders Wave2 archive — `ea-wave2-shell`, card grid, category filter, pagination | curl markup + filter functional test | **PASS** | `/blog/`: `ea-wave2-shell=1`, `ea-blog-grid=1`, `ea-blog-card=108`, `ea-blog-filter=8`, `ea-blog-pagination=1`. Page 2: pagination + cards present. Filter: `?cat=11` → 1 card (count=1 cat); `?cat=13` → 4 cards; active tab class set. Not default GP archive. |
| AC-05 | `curl -I /Blog/<slug>/` → **301 → `/<slug>/`** (sample ≥5) | curl HEAD, no follow | **PASS** | 8/8 samples: HTTP 301 → root slug URL. |
| AC-06 | `validate_aos.sh` → 0 FAIL | local on `feature/w2-06-blog` @ HEAD `20c354f` | **PASS** | 30 PASS / 18 SKIP / 0 FAIL |
| AC-07 | no shortcode artifacts (VC/Elementor) in **rendered single posts** | grep patterns across all 54 single-post pages | **PASS_WITH_FINDINGS** | 0/54 singles contain `[vc_`, `[elementor`, `wpb_wrapper`, or `[vc_row`. Archive excerpts on `/blog/` still show raw `[vc_row` ×10 — P3 (F-W2-06-03), non-blocking per REQA-SIGNAL. |
| AC-08 | `style.css` Version present (1.4.1 acceptable) | grep theme tree + curl staging | **PASS** | `Version: 1.4.1` (tree + live theme CSS) |

---

# §2.1 Key Evidence Snippets

## AC-01 (all 54)
```
Status distribution: {200: 54}
All 54 root URLs returned 200
```

## AC-04 (archive — post-fix)
```bash
curl -sk "$BASE/blog/?cb=…" | grep -c 'ea-wave2-shell'   # → 1
curl -sk "$BASE/blog/?cb=…" | grep -c 'ea-blog-grid'      # → 1
curl -sk "$BASE/blog/?cb=…" | grep -c 'ea-blog-filter'   # → 8
curl -sk "$BASE/blog/?cb=…" | grep -c 'ea-blog-pagination' # → 1
curl -sk "$BASE/blog/?cat=11&cb=…" | grep -c 'ea-blog-card ' # → 1 (category count=1)
```
Body classes on `/blog/` include `ea-wave2-shell ea-blog-archive-view`.

## AC-02 (single — post-fix)
Sample `18-הטור-של-אייל-עמית-מסך-הברזל`:
```
ea-wave2-shell: True
ea-blog-single-view: True
ea-post-meta: True (author, date, category links)
```

## AC-05 (sample)
```
18-הטור-של-אייל-עמית-מסך-הברזל 301 → /18-…-מסך-הברזל/
23-הטור-של-אייל-עמית-לציית-או-לחשוב 301 → /23-…-לציית-או-לחשוב/
… (6 more PASS)
```

---

# §3 Findings (classified)

## F-W2-06-01 — **RESOLVED** (was P1) — AC-04 Wave2 blog archive routing

**Prior state:** `/blog/` used default GeneratePress archive; Wave2 template ignored because `page_for_posts` triggers `is_home()`.

**Fix verified:** `ea_w2_06_template_include` (commit `78edf9d`) routes posts page and singles to Wave2 templates; `ea-wave2-shell` + full D-14 archive markup live on staging.

---

## F-W2-06-02 — **RESOLVED** (was P2) — Wave2 single-post template routing

**Prior state:** Singles used `post-template-default` without Wave2 blocks.

**Fix verified:** Singles now render `ea-wave2-shell`, `ea-blog-single-view`, `ea-post-meta` via `tpl-blog-single.php` routing.

---

## F-W2-06-03 — **P3** — Raw VC shortcode text in `/blog/` archive excerpts

**Description:** Wave2 archive card excerpts still contain literal `[vc_row …]` strings (×10 on page 1). Single-post bodies are clean (mu-plugin `ea-blog-shortcode-cleanup.php` on `the_content`). Excerpt pipeline does not strip VC shortcodes.

**Impact:** Cosmetic in archive listing only; non-blocking per REQA-SIGNAL and AC-07 scope (singles clean).

**Remediation (optional backlog):** Extend `ea-blog-shortcode-cleanup` to `get_the_excerpt` / `the_excerpt`, or sanitize in `block-blog-card.php`.

---

## F-W2-06-04 — **CLOSED** — Tag display via Wave2 template

**Prior state:** Tags not rendered via `ea-post-tags` when default theme was active.

**Current:** 27 tagged posts render `ea-post-tags` block when tags exist. Data preserved; presentation meets spec.

---

## F-W2-06-05 — **P3** — Orphan broken upload refs in REST content (not rendered)

**Description:** REST `content.rendered` for 2 posts references `/wp-content/uploads/2025/…` paths that return HTTP 404. These `<img>` refs do **not** appear in live rendered single-post HTML (121/121 visible images → 200).

**Impact:** No user-visible broken images on staging; DB cleanup optional.

---

# §4 Known Non-Blocking Items (GO-SIGNAL)

Per GO-SIGNAL §2 — **not scored against AC-03**:

| Dead-source media (pre-migration) | Count |
|-----------------------------------|-------|
| `blog.muzza.co.il` (DNS dead) | 2 |
| `www.namaste.co.il` (404) | 1 |
| `gallery.mailchimp.com` (403) | 2 |
| Legacy `צוותא-אייל-עמית.jpg` (404) | 1 |

---

# §5 validate_aos.sh

```
RESULT: 30 PASS / 18 SKIP / 0 FAIL
L-GATE_BUILD EXIT CRITERION: SATISFIED
```

---

# §6 Routing Recommendation

| Verdict | Route |
|---------|-------|
| **PASS_WITH_FINDINGS** (no P0/P1) | team_100 → **team_190 L-GATE_VALIDATE** (native Codex/GPT-5) |
| P3 backlog | Optional: excerpt VC strip (F-W2-06-03); REST orphan img cleanup (F-W2-06-05) |
| WP-W2-02 | Already **PASS_WITH_FINDINGS** (v2) — unaffected |

---

*team_50 — QA / L-GATE_BUILD — Cursor Codex — 2026-05-28 (re-run post AC-04 fix)*
