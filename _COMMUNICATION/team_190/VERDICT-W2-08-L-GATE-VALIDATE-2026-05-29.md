Engine: native Codex/GPT-5 (OpenAI Codex), not Claude builder and not team_50 QA engine.

# §0 VERDICT BOX

date: 2026-05-29
timezone: Asia/Jerusalem
correction_cycle: R1 — initial L-GATE_VALIDATE (post team_50 PASS_WITH_FINDINGS)

| Field | Value |
|-------|-------|
| WP | WP-W2-08 — English Landing Page (`/en`) |
| Gate | L-GATE_VALIDATE |
| Date | 2026-05-29 Asia/Jerusalem |
| Verdict | **PASS** |
| Blocking findings | None |
| Non-blocking carry-forwards | F-W2-08-01 residual `ea-blog-archive-view` body class on page-id-25 (cosmetic; mandate §4) |
| One-line next step | **team_100** executes WP Closure Protocol (roadmap COMPLETE / LOD500_LOCKED via offline-fallback — re-probe API + confirm DB before API-only switch per W2-07 finding; team_191 archive; merge `feature/w2-08-en` → main on team_00 go), then re-handoff to **WP-W2-09**. |

# §1 Validator Engine Declaration

| Field | Value |
|-------|-------|
| Identity | team_190 (constitutional Final Validator, IR#5) |
| Engine | **native Codex / OpenAI / GPT-5** — not `claude-*` (team_10 builder), not team_50 QA engine |
| Worktree | `/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-08` |
| Branch | `feature/w2-08-en` |
| Comms HEAD | `96adbf2` |
| Build commit (validated) | **`5ac435b`** — `WP-W2-08: English landing /en` |
| Mandate | `_COMMUNICATION/team_190/MANDATE-TEAM190-W2-08-L-GATE-VALIDATE-2026-05-29.md` |
| L-GATE_BUILD trigger | `_COMMUNICATION/team_50/VERDICT-W2-08-L-GATE-BUILD-2026-05-29.md` — PASS_WITH_FINDINGS, 5/5 ACs |
| Content SSOT | `_COMMUNICATION/team_30/W2-08-EN-CONTENT-2026-05-28.md` |
| Staging | `http://eyalamit-co-il-2026.s887.upress.link` (all HTTP checks cache-busted: `?cb=$(date +%s)$RANDOM`) |

# §2 Fresh-tree Proof

| Required proof | Result |
|----------------|--------|
| `git rev-parse HEAD` | `96adbf2157a96a9a796ff842817c3af9054c7c5a` (`96adbf2`) — comms-doc tip ✓ |
| Build artifacts frozen at | **`5ac435b`** — `WP-W2-08: English landing /en` |
| `git merge-base 5ac435b HEAD` | `5ac435b` — build commit is ancestor of HEAD ✓ |
| Base main | `37921fb` ✓ |
| `git diff --name-only 5ac435b..HEAD` | **Only 2 files** — zero theme/CSS/template delta ✓ |
| | `_COMMUNICATION/team_190/MANDATE-TEAM190-W2-08-L-GATE-VALIDATE-2026-05-29.md` |
| | `_COMMUNICATION/team_50/MANDATE-TEAM50-W2-08-L-GATE-BUILD-2026-05-29.md` |
| Tree `style.css` Version | **1.4.6** |
| Deployed `style.css` Version | **1.4.6** (cache-busted curl on staging) ✓ |
| W2-08 CSS raw hex (D-14) | **PASS** — `grep '#[0-9a-fA-F]{3,6}' w2-08-en-landing.css` → no matches |

Conclusion: validation run against **build state `5ac435b`**; HEAD `96adbf2` adds comms only — no stale-build risk.

# §3 Eight-Check Validation

| Check | Scope | Result | Evidence / Notes |
|-------|-------|--------|------------------|
| C-1 | Cross-engine chain | **PASS** | Builder = team_10 (`claude-*`); L-GATE_BUILD = team_50 (`cursor-composer`, non-Claude) PASS_WITH_FINDINGS 5/5; this L-GATE_VALIDATE = **Codex/GPT-5** (IR#1). |
| C-2 | Code surface + static hygiene | **PASS** | `php -l inc/wave2-w2-08.php` clean. `require_once` wired in `functions.php` L807. `tpl-en-landing.php` in active views (`wave2-stage-b.php` L56). `style.css` Version **1.4.6**. W2-08 CSS: no raw hex; `direction: ltr`; `@media (max-width: 768px)` present. |
| C-3 | AC-01 — `/en` live HTTP + lang | **PASS** | Cache-busted curl: `/en/` → **HTTP 200**; `<html lang="en" dir="ltr">`; body classes `ea-wave2-shell` + `ea-en-landing`. |
| C-4 | AC-02 — 6 sections verbatim + single H1 | **PASS** | 6 `data-block` sections: hero · about · method · services · books · testimonials. `h1` count = **1** (hero tagline only). 8/8 named testimonials present (Shiri Elkabetz … Alex Flop). Verbatim spot-checks pass vs team_30 SSOT (H1 tagline, cbDIDG, Muzza Publishing, three book titles, method principles, service headings, closing CTA). |
| C-5 | AC-03 — hreflang B03 reciprocal (both directions) | **PASS** | **On `/en/`:** `hreflang="en"` → `/en/`; `hreflang="he"` → `/`; `hreflang="x-default"` → `/`. **On HE `/`:** reciprocal `hreflang="en"` → `/en/` ✓. Both heads verified independently via cache-busted curl. |
| C-6 | AC-04 — CTA → `/contact?lang=en` | **PASS** | 3/3 primary `ea-cta-pill--primary` CTAs → `/contact?lang=en`. No hash (`#`) CTAs in main content. Site header retains generic `/contact/` (site-wide chrome; non-blocking per team_50). |
| C-7 | AC-05 — validate_aos + responsive LTR | **PASS** | `validate_aos.sh` → **30 PASS / 18 SKIP / 0 FAIL**. `w2-08-en-landing.css?ver=1.4.6` enqueued on `/en`; HTTP 200. LTR direction + mobile breakpoint confirmed in CSS. |
| C-8 | Artifact integrity + prior gate state | **PASS** | Mandate + build verdict + content SSOT paths resolve. team_50 reported 0 P0/P1 blockers; team_100 pre-gate live check aligned (200, 6 blocks, single H1, hreflang reciprocal, validate 30/0). |

# §4 LOD400 Precision Gate (AC-01..AC-05)

| AC | Description | Verdict | Independent evidence |
|----|-------------|---------|----------------------|
| AC-01 | `/en` → 200, `lang="en"` | **PASS** | HTTP 200; `lang="en"` + `dir="ltr"` on `<html>`; wave2 shell classes present. |
| AC-02 | 6 sections verbatim team_30; single H1; 8 testimonials | **PASS** | 6 `data-block` sections; h1=1; 8 named testimonials; 12/12 verbatim phrase spot-checks pass vs `_COMMUNICATION/team_30/W2-08-EN-CONTENT-2026-05-28.md`. |
| AC-03 | hreflang B03 en↔he reciprocal + x-default | **PASS** | 3 alternates on `/en/`; reciprocal `hreflang=en→/en/` on HE `/` confirmed independently. |
| AC-04 | CTA → `/contact?lang=en` (never `#`) | **PASS** | 3/3 primary CTA pills → `/contact?lang=en`; no `#` CTAs in page content. |
| AC-05 | `validate_aos.sh` 0 FAIL + responsive LTR + D-14 tokens | **PASS** | 0 FAIL; LTR CSS + mobile media query; no raw hex in w2-08 CSS. |

# §5 Prior Findings Disposition (team_50 → team_190)

| ID | Severity | Status | Notes |
|----|----------|--------|-------|
| F-W2-08-01 | P3 | **ACCEPTED (non-blocking)** | Residual `ea-blog-archive-view` body class on page-id-25 — cosmetic only; W2-08 CSS scoped to `.ea-en-landing`. Mandate §4 explicitly non-blocking. |

# §6 Independent Findings (this run)

| ID | Severity | Finding | evidence-by-path | route_recommendation |
|----|----------|---------|------------------|----------------------|
| — | — | **No blocking findings.** | — | Proceed to WP Closure Protocol. |

# §7 Evidence Summary

```bash
git -C "/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-08" rev-parse HEAD
# 96adbf2157a96a9a796ff842817c3af9054c7c5a

git -C "/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-08" rev-parse 5ac435b
# 5ac435bc9587ccfbae65ded0b1ae585fc594ae6a

git -C "/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-08" diff --name-only 5ac435b..HEAD
# _COMMUNICATION/team_190/MANDATE-TEAM190-W2-08-L-GATE-VALIDATE-2026-05-29.md
# _COMMUNICATION/team_50/MANDATE-TEAM50-W2-08-L-GATE-BUILD-2026-05-29.md

bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .
# RESULT: 30 PASS / 18 SKIP / 0 FAIL
```

```text
AC-01 cache-busted curl, team_190 2026-05-29:
/en/?cb=… → HTTP 200
<html lang="en" dir="ltr">
body: ea-wave2-shell, ea-en-landing
h1_count: 1
data-block: hero, about, method, services, books, testimonials (6)
```

```text
AC-02 verbatim spot-check (team_190 vs team_30 SSOT):
H1 tagline ✓ | cbDIDG ✓ | Muzza Publishing ✓
Paint It Blue and Throw It to the Sea ✓ | Kushi Blantis ✓ | And You Shall Write ✓
Active work. ✓ | Process, not a moment. ✓
Didgeridoo Therapy. ✓ | Sound Healing. ✓ | Didgeridoo Lessons. ✓
If you've read this far ✓
testimonials 8/8: Shiri Elkabetz … Alex Flop ✓
```

```text
AC-03 hreflang — BOTH directions (cache-busted curl):

/en/ head:
  hreflang="en" → …/en/
  hreflang="he" → …/
  hreflang="x-default" → …/

HE / head:
  hreflang="en" → …/en/  (reciprocal ✓)
  hreflang="he" → …/
  hreflang="x-default" → …/
```

```text
AC-04 CTA probe (team_190):
ea-cta-pill--primary count: 3
contact?lang=en count: 3/3
hash CTAs in main content: none
```

```text
AC-05 static + live:
validate_aos.sh → 30 PASS / 18 SKIP / 0 FAIL
w2-08-en-landing.css?ver=1.4.6 enqueued on /en → HTTP 200
grep raw hex in w2-08-en-landing.css → no matches
direction: ltr + @media (max-width: 768px) present
deployed style.css Version: 1.4.6
```

# §8 Final Routing

**L-GATE_VALIDATE: PASS.** All eight constitutional checks pass; LOD400 precision gate AC-01..AC-05 independently verified live at build commit **`5ac435b`**. No P0/P1/P2 blockers. F-W2-08-01 accepted as non-blocking per mandate §4.

→ **team_100**: execute WP Closure Protocol for WP-W2-08 (roadmap COMPLETE / LOD500_LOCKED via offline-fallback — re-probe API + confirm DB contains the WP before any API-only switch, per W2-07 finding; team_191 archive; merge `feature/w2-08-en` → main on team_00 go).

→ **team_00**: merge authorized after team_100 closure.

→ **Next WP**: **WP-W2-09** (final pre-cutover; depends W2-01..08).

*team_190 — constitutional validator — 2026-05-29*
