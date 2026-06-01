Engine: native Codex/GPT-5 (OpenAI Codex), not Claude and not team_50.
---
id: VERDICT-BUGFIX-QA-L-GATE-VALIDATE-2026-06-01
from: team_190 (L-GATE_VALIDATE — native Codex)
to: team_100, team_00
type: QA_VERDICT
gate: L-GATE_VALIDATE
date: 2026-06-01
engine: native Codex/GPT-5 (OpenAI Codex)
verdict: FAIL
blocking_findings: 1
branch: chore/bugfix-qa-http
mandated_head: 016de33
worktree_head: 78204c7
target_fix_commit: 90cf695
staging: http://eyalamit-co-il-2026.s887.upress.link
report_ref: _COMMUNICATION/team_100/BUGFIX-SWEEP-AND-HTTP-QA-2026-06-01.md
build_gate_ref: _COMMUNICATION/team_50/VERDICT-BUGFIX-QA-L-GATE-BUILD-2026-06-01.md
---

# VERDICT — Bug-fix sweep + HTTP QA | L-GATE_VALIDATE

## Verdict Box

| Field | Value |
|-------|-------|
| Deliverable | Known-bug fix sweep (4 fixes) + reusable HTTP QA tooling |
| Verdict | **FAIL** |
| Blocking | **T190-BUGFIX-F01** — triage completeness failure: W2-05 primary-nav legacy repair link is still live and omitted from the sweep report |
| P0/P1 | 1 P1 gate-contract blocker (functional severity is P3; blocking because mandate §2.5 explicitly requires no FIXABLE-NOW omission) |
| S3 approval | **NOT APPROVED** until the omitted item is either fixed or explicitly dispositioned in the sweep report with owner/severity |

## Proof-of-HEAD

| Check | Result |
|-------|--------|
| Branch | `chore/bugfix-qa-http` |
| Mandated HEAD | `016de33` — bug-fix sweep report |
| Worktree HEAD | `78204c7` — docs-only mandate commit after `016de33`; no code delta after the target report/tooling commits |
| Fix commit reviewed | `90cf695` — `fix(bugs): blog excerpt shortcodes, /en RTL footer+skiplink, body-class scope, author name` |
| Build gate entry | **PASS** in `_COMMUNICATION/team_50/VERDICT-BUGFIX-QA-L-GATE-BUILD-2026-06-01.md` |

## §2.1 Cross-engine Chain

| Required | Verdict | Evidence |
|----------|---------|----------|
| builder != team_50 != team_190 | **PASS** | Fix commit `90cf695` is co-authored by Claude; team_50 verdict declares `engine: cursor-composer-2.5-fast`; this verdict is native Codex/GPT-5. |

## §2.2 Four Live Fixes — Independent HTTP Reproduction

| Bug | Verdict | Evidence |
|-----|---------|----------|
| B1 `/blog/` raw `[vc_` = 0 | **PASS** | Playwright HTTP `page.evaluate` on `/blog/?cb=t190pw1`: `vcCount: 0`; page title `בלוג - eyal amit`. |
| B2 `/en` no `ea-blog-archive-view`; `/blog` retains | **PASS** | `/en/?cb=t190pw2`: `blogClassCount: 0`, body includes `ea-en-landing`; `/blog/?cb=t190pw1`: body includes `ea-blog-archive-view`, `blogClassCount: 1`. |
| B3 EN LTR override scoped | **PASS** | `/en` loads `w2-08-en-landing.css?ver=1.4.6`; fetched CSS contains `body.ea-en-landing .ea-footer__social` and `body.ea-en-landing .ea-skiplink`; no unscoped `.ea-footer__social` override; marker `LTR mirror fixes` count = 1. |
| B4 byline = `מאת: אייל עמית` | **PASS** | Sample single post `/פודקאסט-.../?cb=t190pw3`: `.ea-post-meta__author` = `מאת: אייל עמית`; visible `eyaladmin` count = 0. |

## §2.3 QA Tooling Reproduction

| Check | Verdict | Evidence |
|-------|---------|----------|
| `node scripts/qa/http-qa-axe.cjs` | **PASS** | 14/14 routes HTTP 200; 0 critical / 0 serious; report `scripts/qa/reports/axe-http-2026-06-01.json`. |
| Lighthouse `/`, `/treatment/`, `/blog/`, `/en/` | **PASS** | `bash scripts/qa/http-qa-lighthouse.sh / /treatment/ /blog/ /en/` returned: `/` 96/100/81/69; `/treatment/` 97/100/81/66; `/blog/` 96/97/81/58; `/en/` 94/100/81/58. SEO/BP are staging-capped by HTTP + noindex. |
| Tooling caveat | INFO | One local headless Chrome child crash report appeared during the run; both mandated scripts completed and returned usable PASS data. Direct `curl` later became DNS-flaky (`Could not resolve host`), so content probes used Playwright HTTP. |

## §2.4 Code Review of `90cf695`

| Surface | Verdict | Evidence |
|---------|---------|----------|
| `ea-blog-shortcode-cleanup.php` regex + guards | **PASS** | `php -l` clean. Regexes are bounded by `]` or non-greedy paired shortcode spans; no nested exponential pattern found. `the_content` remains guarded by `is_singular('post')`; excerpt hook guards `get_post_type() === 'post'`. Risk of removing literal shortcode-like prose is acceptable for legacy-post render cleanup and preserves paired inner text. |
| `ea-w2-10-author-displayname-once.php` | **PASS** | `php -l` clean. Option gate `ea_w2_10_author_displayname_v1`; marks done even if user absent, so it does not run every request. `wp_update_user` only sets `ID`, `display_name`, `nickname` on resolved `WP_User`. |
| `wave2-w2-06.php` body class | **PASS** | `php -l` clean. Condition is narrowed to `is_home() || is_page_template('page-templates/tpl-blog-archive.php')`; live `/blog` retains class and `/en` does not. |
| EN CSS scope | **PASS** | Override selectors are scoped to `body.ea-en-landing`; fetched live CSS confirms no unscoped footer-social override. |

## §2.5 Triage Completeness

| Required | Verdict | Evidence |
|----------|---------|----------|
| No FIXABLE-NOW item omitted; NEEDS-EYAL / NEEDS-DECISION classified correctly | **FAIL** | `_COMMUNICATION/team_100/BUGFIX-SWEEP-AND-HTTP-QA-2026-06-01.md` omits the W2-05 carry-forward `F-W2-05-01` primary-nav repair link. This item is documented in `_COMMUNICATION/team_100/INFO-HANDOFF-WAVE2-COMPLETE-2026-05-31.md` and `_COMMUNICATION/team_100/S002-MILESTONE-CLOSEOUT-2026-05-31.md`; live homepage still exposes `תיקון וחידוש כלים` → `/tools-and-accessories/repair/` instead of canonical `/repair/`. |

### Blocking Finding

| ID | Severity | Finding | Evidence | Required disposition |
|----|----------|---------|----------|----------------------|
| T190-BUGFIX-F01 | **P1 gate-contract blocker** | The bug-fix sweep claims a definitive known-bug triage, but drops known W2-05 advisory `F-W2-05-01`. Functional severity remains P3 because the legacy URL renders, but the omission violates mandate §2.5 and the sweep objective "fix every known code-fixable bug." | Playwright on homepage `/?cb=t190pw4`: link text `תיקון וחידוש כלים` href `http://eyalamit-co-il-2026.s887.upress.link/tools-and-accessories/repair/`. Playwright on that URL `?cb=t190pw5`: page is live but body lacks `ea-wave2-shell`, confirming users are sent to the legacy page, not the W2-05 canonical `/repair`. Prior docs: `_COMMUNICATION/team_100/INFO-HANDOFF-WAVE2-COMPLETE-2026-05-31.md`; `_COMMUNICATION/team_100/S002-MILESTONE-CLOSEOUT-2026-05-31.md`. | Either fix the nav/menu sync (and optional 301) or amend the sweep report to explicitly classify this as accepted P3 carry-forward with owner and rationale. Re-run this gate after disposition. |

## §2.6 TLS / HTTP-only Staging

| Required | Verdict | Evidence |
|----------|---------|----------|
| Staging is HTTP-only; no reliance on HTTPS | **PASS** | `docs/project/EYAL_ENV_VARS_REFERENCE.md` §2 states staging tests use `http://` because there is no valid public SSL cert for staging. QA scripts default to `http://eyalamit-co-il-2026.s887.upress.link`; axe and Lighthouse evidence above used HTTP. |

## Constitutional Package Lint

`python3 /Users/nimrod/.codex/skills/constitutional-package-linter/scripts/lint_constitutional_package.py` on the source mandate/report/build-verdict set returned **PASS**.

## Final Routing

**L-GATE_VALIDATE = FAIL.** Do not advance to S3 on this package as-is. The blocker is narrow: dispose of `F-W2-05-01` in the bug-fix sweep, then resubmit for a focused team_190 revalidation of §2.5 plus smoke re-checks for B1-B4/QA.

*team_190 — native Codex/GPT-5 — 2026-06-01*
