---
id: VERDICT-BUGFIX-QA-L-GATE-BUILD-2026-06-01
from: team_50 (L-GATE_BUILD Validator)
to: team_100, team_00 → team_190
type: QA_VERDICT
gate: L-GATE_BUILD
date: 2026-06-01
engine: cursor-composer-2.5-fast
verdict: PASS
criteria_total: 7
criteria_pass: 7
criteria_fail: 0
findings_blocker: 0
findings_major: 0
findings_minor: 1
branch: chore/bugfix-qa-http
fixes_commit: 90cf695
mandated_head: 016de33
worktree_head: 78204c7
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_50/MANDATE-TEAM50-BUGFIX-QA-L-GATE-BUILD-2026-06-01.md
report_ref: _COMMUNICATION/team_100/BUGFIX-SWEEP-AND-HTTP-QA-2026-06-01.md
cross_engine: IR#1 — builder=Claude; validator=cursor-composer-2.5-fast (non-Claude)
---

# VERDICT — Bug-fix sweep + HTTP QA | L-GATE_BUILD

**Engine (line 1): cursor-composer-2.5-fast (non-Claude)**

## Verdict Box

| Field | Value |
|-------|-------|
| Deliverable | 4 known-bug fixes + reusable HTTP QA tooling |
| Gate | L-GATE_BUILD |
| Verdict | **PASS** |
| Blocking (P0/P1) | None |
| Non-blocking | `/en/` Perf 94 (hero JPG; F2 WebP at S3); author archive slug still `/author/eyaladmin/` (display name fixed) |
| Next step | team_190 L-GATE_VALIDATE |

---

## Proof-of-HEAD

| Check | Result |
|-------|--------|
| Branch | `chore/bugfix-qa-http` |
| Fixes commit | `90cf695` — `fix(bugs): blog excerpt shortcodes, /en RTL footer+skiplink, body-class scope, author name` |
| Mandated HEAD | `016de33` (docs report) |
| Worktree HEAD | `78204c7` — docs-only delta (+2 mandate files); **zero fix-artifact changes** vs `016de33` |
| Base main | `d359850` (per mandate) |
| HTTP only | All probes used `http://` + cache-bust `?cb=$(date +%s)$RANDOM` |

---

## Cross-engine (IR#1)

| Role | Engine |
|------|--------|
| Builder | Claude |
| Validator (this verdict) | **cursor-composer-2.5-fast** ✓ |

---

## AC Checklist

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| AC-01 | B1: `/blog/` no raw `[vc_` (was 10) | **PASS** | `curl -s "$BASE/blog/?cb=…" \| grep -c '\[vc_'` → **0** |
| AC-02 | B2: `/en` no `ea-blog-archive-view`; `/blog/` retains | **PASS** | `/en` count → **0**; `/blog/` count → **1** |
| AC-03 | B3: LTR override served; footer/skip-link scoped | **PASS** | CSS `grep -c 'LTR mirror fixes'` → **1**; repo has `body.ea-en-landing .ea-footer__social` + `.ea-skiplink` LTR overrides in `w2-08-en-landing.css` |
| AC-04 | B4: post byline = "מאת: אייל עמית" | **PASS** | Sample post (פודקאסט…): HTTP 200; `.ea-post-meta__author` → `מאת: אייל עמית`; `eyaladmin` visible count → **0** |
| AC-05 | axe HTTP: 14/14 routes 200 + 0 critical/serious | **PASS** | `node scripts/qa/http-qa-axe.cjs` → 14 routes, all 200, crit=0 serious=0; report `scripts/qa/reports/axe-http-2026-06-01.json` |
| AC-06 | Lighthouse HTTP: a11y ≥97; perf as reported; SEO/BP staging-capped | **PASS** | `bash scripts/qa/http-qa-lighthouse.sh / /treatment/ /blog/ /en/` → see table below; all a11y **≥97** |
| AC-07 | No regression: php -l ×3 + validate_aos 0 FAIL + pre-cutover exit 0 | **PASS** | All three `php -l` clean; `validate_aos.sh` → 30 PASS / 0 FAIL; `final_pre_cutover_check.sh` → exit **0** (a–e green, ~342s) |

Summary: **7 PASS / 0 FAIL**

---

## Lighthouse (AC-06) — independent run

| Route | Perf | A11y | BP | SEO |
|-------|------|------|----|-----|
| `/` | 96 | 100 | 81 | 69 |
| `/treatment/` | 97 | 100 | 81 | 66 |
| `/blog/` | 97 | **97** | 81 | 58 |
| `/en/` | 94 | 100 | 81 | 58 |

SEO/BP staging-capped (noindex + HTTP → 100 at M7 cutover). `/en/` Perf 94 (builder reported 84; variance acceptable — F2 hero JPG carry-forward, not a gate failure).

`final_pre_cutover_check.sh` §(e) home: Perf=96, A11y=100 — gate PASS.

---

## Static validation (AC-07 detail)

```text
php -l ea-blog-shortcode-cleanup.php          → No syntax errors
php -l ea-w2-10-author-displayname-once.php   → No syntax errors
php -l inc/wave2-w2-06.php                    → No syntax errors
validate_aos.sh                               → 30 PASS / 18 SKIP / 0 FAIL
final_pre_cutover_check.sh                    → RESULT: PASS (exit 0)
  (a) media 74/74 200
  (b) 301=25 410=2 failures=0
  (c) QR 49/49 200
  (d) validate_aos 0 FAIL
  (e) Lighthouse gate PASS
```

---

## Findings (non-blocking)

| ID | Severity | Finding |
|----|----------|---------|
| F-01 | P3 | Yoast schema still references `/author/eyaladmin/` URL slug; visible byline correctly shows "אייל עמית" — slug cleanup optional post-cutover |

---

## Routing

team_50 **PASS** → team_190 L-GATE_VALIDATE (`MANDATE-TEAM190-BUGFIX-QA-L-GATE-VALIDATE-2026-06-01.md`).

---

*team_50 — cursor-composer-2.5-fast — 2026-06-01 — independent HTTP validation; no code changes.*
