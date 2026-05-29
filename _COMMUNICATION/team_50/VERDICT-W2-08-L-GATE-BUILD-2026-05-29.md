---
verdict: PASS_WITH_FINDINGS
wp: WP-W2-08
date: 2026-05-29
head_verified: 5ac435b
validator_engine: cursor-composer
branch: feature/w2-08-en
tip_commit: 96adbf2
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_50/MANDATE-TEAM50-W2-08-L-GATE-BUILD-2026-05-29.md
spec_ref: _aos/work_packages/S002/WP-W2-08/LOD400_spec.md
status: ISSUED
criteria_total: 5
criteria_pass: 5
criteria_fail: 0
findings_blocker: 0
findings_major: 0
findings_minor: 1
---

Engine: **cursor-composer** (non-Claude) — Iron Rule #1 satisfied. Builder = team_10 (Claude).

# L-GATE_BUILD Verdict — WP-W2-08 English Landing (/en)

## Result

**PASS_WITH_FINDINGS** — all five acceptance criteria pass; no P0/P1 blockers.

| Field | Value |
|-------|-------|
| WP | WP-W2-08 — English Landing Page (`/en`) |
| Gate | L-GATE_BUILD |
| Verdict | **PASS_WITH_FINDINGS** |
| ACs passed | **5 of 5** |
| Blocking AC | none |
| One-line next step | Notify **team_100** + **team_00** → route **team_190 (Codex) L-GATE_VALIDATE** |

---

## Proof-of-HEAD

| Check | Result |
|-------|--------|
| Branch | `feature/w2-08-en` |
| Tip commit | `96adbf2` — docs: L-GATE_BUILD + L-GATE_VALIDATE mandates |
| **Build commit (verified)** | **`5ac435b`** — `WP-W2-08: English landing /en` |
| Ancestry | `5ac435b` is ancestor of HEAD ✓ |
| Base main | `37921fb` ✓ |
| `git diff --name-only 5ac435b..HEAD` | **2 files only** — zero theme/CSS delta ✓ |
| | `_COMMUNICATION/team_50/MANDATE-TEAM50-W2-08-L-GATE-BUILD-2026-05-29.md` |
| | `_COMMUNICATION/team_190/MANDATE-TEAM190-W2-08-L-GATE-VALIDATE-2026-05-29.md` |
| Tree `style.css` Version | **1.4.6** |
| Deployed `style.css` Version | **1.4.6** (cache-busted curl on staging) ✓ |

All HTTP checks used cache-bust: `?cb=$(date +%s)$RANDOM`.

---

## Engine Declaration (Iron Rule #1)

| Field | Value |
|-------|-------|
| Builder | claude-sonnet (team_10) |
| Validator | **cursor-composer** (non-Claude) ✓ |
| Attestation | This verdict is issued by Cursor Composer, not a Claude engine. |

---

## §3 Static Code Checks

| Check | Method | Result |
|-------|--------|--------|
| PHP syntax | `php -l inc/wave2-w2-08.php` | **PASS** — no syntax errors |
| D-14 CSS (no raw hex) | `grep -nE "#[0-9a-fA-F]{3,6}" w2-08-en-landing.css` | **PASS** — empty (no matches) |
| Version bump | `grep ^Version: style.css` | **PASS** — `1.4.6` |
| Router wired | `grep wave2-w2-08 functions.php` | **PASS** — L807 `require_once` |
| `tpl-en-landing` in active views | `grep tpl-en-landing wave2-stage-b.php` | **PASS** — L56 |
| LTR scoped CSS | `w2-08-en-landing.css` | **PASS** — `direction: ltr`; scoped to `body.ea-en-landing`; `@media (max-width: 768px)` present |
| Single H1 template | `tpl-en-landing.php` | **PASS** — no `the_title()`; hero carries H1 per W2-08 comment |
| `validate_aos.sh` | `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` | **PASS** — 30 PASS / 18 SKIP / **0 FAIL** |

---

## §3B Staging HTTP Checks

### AC-01 — `/en` → 200, `lang="en"`

```
/en/?cb=… → HTTP 200
lang="en": present (main + template)
dir="ltr": present
ea-wave2-shell + ea-en-landing body classes: present
```

### AC-02 — 6 sections verbatim from team_30; single H1

```
data-block sections (6): hero · about · method · services · books · testimonials
h1_count: 1 (hero only)
testimonials live: 8 (Shiri Elkabetz … Alex Flop — matches team_30 §6)
CTA pills "Schedule an introductory call": 3

Verbatim spot-check (team_30 artifact ↔ live HTML):
  H1 tagline ✓ | cbDIDG ✓ | Muzza Publishing ✓ | Paint It Blue… ✓
  Shiri Elkabetz quote ✓ | closing CTA text ✓
PHP render source matches approved copy in wave2-w2-08.php (no builder-authored marketing detected)
```

### AC-03 — hreflang B03 reciprocal

**On `/en/`:**

| Alternate | href |
|-----------|------|
| `hreflang="en"` | `…/en/` ✓ |
| `hreflang="he"` | `…/` (HE homepage) ✓ |
| `hreflang="x-default"` | `…/` ✓ |

**On HE homepage `/`:**

| Alternate | href |
|-----------|------|
| `hreflang="en"` | `…/en/` ✓ (reciprocal) |

### AC-04 — CTA → `/contact?lang=en`

```
Schedule-an-introductory-call CTA pills (3/3):
  → /contact?lang=en ✓
No hash (#) CTAs in main content ✓
Note: site header nav retains generic /contact/ link (site-wide chrome, not W2-08 primary CTA)
```

### AC-05 — validate_aos 0 FAIL + responsive LTR

```
validate_aos.sh → 30 PASS / 18 SKIP / 0 FAIL
w2-08-en-landing.css enqueued on /en (ver=1.4.6)
LTR direction + mobile @media breakpoint present in CSS
```

---

## AC Results

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| AC-01 | `/en` → 200, `lang="en"` | **PASS** | HTTP 200; `lang="en"` + `dir="ltr"` on main |
| AC-02 | 6 sections verbatim team_30; single H1 | **PASS** | 6 `data-block` sections; h1=1; 8 testimonials; verbatim spot-checks pass |
| AC-03 | hreflang B03 en↔he reciprocal + x-default | **PASS** | 3 alternates on `/en`; reciprocal `en→/en/` on HE `/` |
| AC-04 | CTA → `/contact?lang=en` | **PASS** | 3/3 primary CTA pills → `/contact?lang=en`; no `#` CTAs |
| AC-05 | `validate_aos.sh` 0 FAIL + responsive LTR | **PASS** | 0 FAIL; LTR CSS + mobile media query |

---

## Findings

### F-W2-08-01 — **P3 / Advisory** — Residual `ea-blog-archive-view` body class on page-id-25

**Evidence:** Live `/en/` body carries `ea-blog-archive-view` alongside `ea-en-landing` (page-id-25 matches a WP body_class filter from another feature).

**Impact:** Cosmetic only — W2-08 CSS scoped to `.ea-en-landing`; no visual regression observed.

**Not blocking** — mandate §4 note; candidate for follow-up housekeeping.

---

## §5 validate_aos.sh

```
RESULT: 30 PASS / 18 SKIP / 0 FAIL
L-GATE_BUILD EXIT CRITERION: SATISFIED
```

---

## Final Routing

WP-W2-08 **passes L-GATE_BUILD** (PASS_WITH_FINDINGS). No P0/P1 blockers.

→ **team_100** + **team_00**: route **team_190 (Codex) L-GATE_VALIDATE**.

*team_50 — L-GATE_BUILD validator — 2026-05-29*
