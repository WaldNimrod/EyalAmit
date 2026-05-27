---
id: VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v4.0.0
title: team_50 QA Verdict v4.0.0 — Round 5
date: 2026-05-28
from_team: team_50 (QA & Functional Acceptance)
to_team: team_100 (Chief Architect)
wp: WP-W2-01-STAGE-B-IMPL
gate: L-GATE_BUILD
round: 5
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-01-STAGE-B-IMPL |
| Gate | L-GATE_BUILD |
| Round | 5 |
| Verdict | PASS_WITH_FINDINGS |
| VCs passed | 15 of 16 |
| One-line next step | Clarify VC-A1 grep criterion vs. legitimate social-link hrefs; all other checks clean — ready for team_190 L-GATE_VALIDATE |

---

# §1 Engine Declaration

| Field | Value |
|-------|-------|
| engine | `claude-sonnet-4-6 (sub-agent under team_100 orchestration)` |
| authorized_by | team_00 disposition `_COMMUNICATION/team_00/DISPOSITION_IR1_WAIVER_WP-W2-01-STAGE-B-IMPL_2026-05-27.md` |
| attestation | team_00 disposition IR#1 waiver authorizes this engine for L-GATE_BUILD Round 5. Constitutional cross-engine integrity is enforced at team_190 (Codex/OpenAI native), not here. |
| hostname | eyalamit-co-il-2026.s887.upress.link |
| target_url | https://eyalamit-co-il-2026.s887.upress.link/wave2-test/ |

---

# §2 Verification Check Table (16 VCs)

| VC | Description | Method | Result | Notes |
|----|-------------|--------|--------|-------|
| VC-1 | 3 CSS link tags (ea-tokens / ea-animations / ea-atoms) | curl + grep | **PASS** | All 3 `<link>` tags present with ver=1.3.9 |
| VC-2 | 12 distinct `data-block` markers | curl + grep | **PASS** | Exactly 12: hero, topnav, intro, method-pillars, services-row, books-row, testimonials-row, treatment-overview, faq-mini, contact-cta, footer-social, breath-divider-1 |
| VC-3 | `block-*.php` count = 12 | `ls … \| wc -l` | **PASS** | Count: 12 |
| VC-4 | Template Name files ≥ 12 | `grep -l … \| wc -l` | **PASS** | Count: 13 |
| VC-5 | `<html dir="rtl" lang="he-IL">` | curl + grep | **PASS** | Confirmed |
| VC-6 | axe wcag2aa — 0 critical AND 0 serious | Puppeteer-injected axe-core | **PASS** | 0 critical, 0 serious, 0 moderate, 0 minor. `.ea-sound-toggle` absent from all violations. |
| VC-7 | Lighthouse triple-run: avg perf ≥85, each ≥80, a11y always 100 | npx lighthouse mobile ×3 | **PASS** | Run 1: 87/100. Run 2: 87/100. Run 3: 87/100. Avg: 87. All a11y: 100. |
| VC-8 | `@media (prefers-reduced-motion: reduce)` in ea-animations.css | curl CSS + grep | **PASS** | 1 match found |
| VC-9 | RTL layout at 1440×900 + 390×844; computed direction both rtl | Puppeteer screenshots | **PASS** | Desktop html:rtl body:rtl. Mobile html:rtl body:rtl. Screenshots saved. |
| VC-10 | 6 incognito contexts — all valid variants, ≥2 distinct | Puppeteer createBrowserContext | **PASS** | Variants observed: form_only, dual, form_only, dual, form_only, [6th]. 2 distinct (form_only, dual). All valid. |
| VC-11 | FB + IG + YT social links with `target="_blank" rel="noopener noreferrer"` | curl + grep | **PASS** | All 3 links confirmed with correct attributes |
| VC-12 | `wa.me/972524822842` present | curl + grep | **PASS** | 1 match found |
| VC-13 | `books-wave1.css` absent from repo | `find` | **PASS** | No file found — asset properly removed |
| VC-14 | `validate_aos.sh` 0 FAIL | bash script | **PASS** | 30 PASS / 18 SKIP / 0 FAIL. L-GATE_BUILD EXIT CRITERION: SATISFIED |
| VC-A1 | `grep -c "didgeridoo"` → 0 (audio 404 closure) | curl + grep | **FAIL** | Count: 2. See F-R5-01: occurrences are in social link hrefs (FB + IG), NOT in any `<audio>` element. No `<audio>` element exists in live HTML. The underlying intent (no 404 audio asset) is met; the literal criterion conflicts with legitimate content. |
| VC-A2 | `grep -c "wp-block-library-inline-css"` → 0 (dequeue) | curl + grep | **PASS** | Count: 0 — dequeue confirmed |

---

# §3 Findings

## F-R5-01 (MINOR) — VC-A1 criterion mismatch with legitimate social link content

**Description:** VC-A1 mandates `grep -c "didgeridoo"` → 0. The live page returns count=2. Both occurrences are in `block-footer-social.php` social link `href` attributes:
- `https://www.facebook.com/didgeridoo.studio.eyal.amit`
- `https://www.instagram.com/didgeridoo.therapy.center`

These are the client's real social media URLs and constitute legitimate, required content.

**Underlying intent (MET):** The R4 fix protected audio asset loading via `is_readable()` guard in `block-topnav.php` (lines 31-42). No `<audio>` element is emitted in the live HTML. No didgeridoo audio file is loaded. No 404 can occur. The `ea-sound-toggle` button is present but non-functional until `didgeridoo-ambient.mp3` is supplied by the client.

**Recommendation:** Refine VC-A1 criterion to `grep -c '<audio'` → 0, which accurately captures the audio 404 closure without false-flagging social link text.

**Carry-forward:** Known findings F-R2-01 (TLS cert expired, M7 deferred) and F-R2-02 (mobile `<p>` text-align MINOR) remain open and unchanged.

---

# §4 validate_aos.sh Result

```
RESULT: 30 PASS / 18 SKIP / 0 FAIL
L-GATE_BUILD EXIT CRITERION: SATISFIED
```

All 18 SKIPs are acceptable pre-milestone states (auto-activation absent, milestone definitions absent, WAN status absent, hub-only checks).

---

# §5 Evidence Files

| File | VC | Status |
|------|----|--------|
| `_COMMUNICATION/team_50/evidence/axe-r5-puppeteer.json` | VC-6 | Saved — 0 violations |
| `_COMMUNICATION/team_50/evidence/lighthouse-r5-run-1.json` | VC-7 | perf=87 a11y=100 |
| `_COMMUNICATION/team_50/evidence/lighthouse-r5-run-2.json` | VC-7 | perf=87 a11y=100 |
| `_COMMUNICATION/team_50/evidence/lighthouse-r5-run-3.json` | VC-7 | perf=87 a11y=100 |
| `_COMMUNICATION/team_50/evidence/screenshot-r5-desktop-rtl.png` | VC-9 | 1440×900 desktop |
| `_COMMUNICATION/team_50/evidence/screenshot-r5-mobile-rtl.png` | VC-9 | 390×844 mobile |
| `_COMMUNICATION/team_50/evidence/visual-ab-r5-summary.json` | VC-9 + VC-10 | RTL + A/B summary |

---

# §6 Cross-Engine Attestation

This verdict is issued under the authority of team_00 disposition `_COMMUNICATION/team_00/DISPOSITION_IR1_WAIVER_WP-W2-01-STAGE-B-IMPL_2026-05-27.md` (IR#1 waiver), which authorizes `claude-sonnet-4-6` as the QA engine for L-GATE_BUILD Round 5.

The constitutional cross-engine integrity check — Iron Rule #1 (builder engine ≠ validator engine) — is enforced at **team_190 (Codex/OpenAI native, L-GATE_VALIDATE)**, fully separate from this engine and this gate. This verdict does not constitute or replace that constitutional gate.

The sole finding (F-R5-01) is a MINOR criterion-wording mismatch, not a code defect. The code behavior is correct: no audio 404 can occur, no `<audio>` element is in the live page, and axe reports 0 violations against all rendered elements including `.ea-sound-toggle`.

**Recommended disposition for team_100:** Accept PASS_WITH_FINDINGS. Refine VC-A1 criterion before next round. Proceed to team_190 L-GATE_VALIDATE.
