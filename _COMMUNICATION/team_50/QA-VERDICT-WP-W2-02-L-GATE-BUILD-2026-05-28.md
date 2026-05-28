---
id: QA-VERDICT-WP-W2-02-L-GATE-BUILD-2026-05-28
title: team_50 L-GATE_BUILD QA Verdict — WP-W2-02 Core Content
date: 2026-05-28
from_team: team_50 (QA / L-GATE_BUILD)
to_team: team_100 (Chief System Architect)
wp: WP-W2-02
gate: L-GATE_BUILD
branch: feature/w2-06-blog
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_50/MANDATE-TEAM50-WAVE2-L-GATE-BUILD-2026-05-28.md
status: ISSUED
---

# §0 VERDICT BOX

| Field | Value |
|-------|-------|
| WP | WP-W2-02 — Core Content (6 pages) |
| Gate | L-GATE_BUILD |
| Verdict | **FAIL** |
| ACs passed | 9 of 10 |
| Blocking AC | AC-05 |
| One-line next step | Remediate CF7 asset dequeue on non-`/contact/` Wave2 pages; re-run L-GATE_BUILD after deploy |

---

# §1 Engine Declaration (IR#1)

| Field | Value |
|-------|-------|
| engine | **Cursor Composer** (non-Claude — IR#1 compliant) |
| mandate | `MANDATE-TEAM50-WAVE2-L-GATE-BUILD-2026-05-28.md` §0 |
| attestation | Builder ran on claude-sonnet-4-6; this validator is NOT Claude. |
| scope | WP-W2-02 ONLY — WP-W2-06 not tested (awaiting team_100 GO-SIGNAL) |

---

# §2 Acceptance Criteria Results (10/10)

Base: `http://eyalamit-co-il-2026.s887.upress.link`

| AC | Check | Method | Result | Evidence |
|----|-------|--------|--------|----------|
| AC-01 | 6 URLs → HTTP 200 | `curl` loop + Python urllib retries | **PASS** | All six paths returned 200 on successful fetches: `/`, `/method/`, `/treatment/`, `/about/`, `/faq/`, `/contact/`. Intermittent staging timeouts observed (see F-W2-02-03); eventual responses were 200. |
| AC-02 | H1 matches 25.5.26 source | view-source / browser snapshot | **PASS** | `/method/` → "שיטת cbDIDG של אייל עמית"; `/treatment/` → "טיפול בדיג׳רידו"; `/about/` → "אודות אייל עמית"; `/faq/` → "שאלות נפוצות (FAQ)"; `/contact/` → "צור קשר". `/` hero H1 contains both lines from `homepage1-3 v2.md` §01 H1 (full source title); presentation uses `<br>` instead of source dash separator (F-W2-02-02). |
| AC-03 | Wave2 templates active (`ea-wave2-shell`) | view-source `/method/` | **PASS** | `<body … ea-wave2-shell …>` present on `/method/`. |
| AC-04 | FAQ filter + 42 Qs / 5 categories | browser + CDP | **PASS** | Combobox `#ea-faq-cat` exposes 5 categories (+ "הכל"). Live DOM: 50 `.ea-faq-item` elements across 5 category sections. Selecting `treatment` filtered to 14 visible / 36 hidden items (filter functional). Mandate count "42" is doc drift vs deployed 50 (F-W2-02-04). |
| AC-05 | CF7 CSS only on `/contact/` | curl grep + browser CDP | **FAIL** | `ea_wave2_dequeue_unused_styles()` exists in tree (`wave2-stage-b.php:116–136`) but **not effective on staging**. CF7 CSS+JS present on non-contact pages, e.g. `/method/` and `/faq/`: `contact-form-7-css`, `contact-form-7-rtl-css`, `contact-form-7-js`. Also on `/`, `/treatment/`, `/about/`. Expected: CF7 assets **only** on `/contact/`. |
| AC-06 | `/about/moksha/` → 200 | curl | **PASS** | HTTP 200. |
| AC-07 | Legacy slug 301s → `/about/` | curl -I (no follow) | **PASS** | `/אייל-עמית-אודות/` → 301 `Location: …/about/`; `/eyal-amit/` → 301 `Location: …/about/`. |
| AC-08 | `validate_aos.sh` 0 FAIL | local on `feature/w2-06-blog` | **PASS** | 30 PASS / 18 SKIP / 0 FAIL — L-GATE_BUILD EXIT CRITERION: SATISFIED. |
| AC-09 | Mobile `<p>` text-align: start | grep `ea-atoms.css` | **PASS** | `@media (max-width: 639px)` block sets `text-align: start` on `.ea-wave2-service p`, `.ea-wave2-content p`, `.ea-service-section p`, `.ea-content-section p` (lines 1275–1308). |
| AC-10 | `style.css` Version 1.4.1 | grep theme | **PASS** | `Version: 1.4.1` in `site/wp-content/themes/ea-eyalamit/style.css`. |

---

# §3 Findings (classified)

## F-W2-02-01 — **P1 (BLOCKING)** — AC-05 CF7 assets not dequeued on non-contact Wave2 pages

**Description:** Contact Form 7 stylesheets and scripts load on Wave2 core pages other than `/contact/`, violating AC-05 and the stated intent of `ea_wave2_dequeue_unused_styles()`.

**Evidence (curl `/method/`):**
```
<link rel='stylesheet' id='contact-form-7-css' href='…/contact-form-7/includes/css/styles.css?ver=6.1.6' … />
<link rel='stylesheet' id='contact-form-7-rtl-css' href='…/contact-form-7/includes/css/styles-rtl.css?ver=6.1.6' … />
<script id="contact-form-7-js" src='…/contact-form-7/includes/js/index.js?ver=6.1.6'></script>
```

**Also confirmed on:** `/`, `/treatment/`, `/about/`, `/faq/` (curl). Browser CDP on `/` and `/method/` matched 2 CF7 stylesheet links each.

**Remediation (team_10):** Verify `ea_wave2_dequeue_unused_styles()` is deployed to staging; confirm it runs when `ea_wave2_is_active_view()` is true for W2-02 routed templates (`template-method`, `tpl-content`, etc.); ensure dequeue priority wins over CF7 re-enqueue; redeploy and re-verify with curl grep on all 6 URLs.

---

## F-W2-02-02 — **P3** — Homepage hero H1 separator differs from 25.5.26 source

**Description:** Source `homepage1-3 v2.md` §01 H1 uses dash separator: `…דיג'רידו - שיטת cbDIDG…`. Live hero uses `<br>` line break (no dash). Semantic content matches; formatting only.

**Not blocking** per content intent; note for visual parity if desired.

---

## F-W2-02-03 — **P3** — Staging intermittent response timeouts

**Description:** Repeated `curl`/urllib timeouts (exit 28 / errno 60) on staging during QA window; pages loaded successfully on retry.

**Not blocking** when pages eventually return 200; flag for infra/UPress if persistent.

---

## F-W2-02-04 — **P3** — FAQ question count vs mandate wording

**Description:** Mandate AC-04 cites "42 Qs"; deployed FAQ has **50** items (14 treatment / 8 lessons / 8 sound-healing / 6 method / 14 general). Source `FAQ FINAL.md` contains ~51 question headings. Filter and categories work; count mismatch is documentation/handoff drift, not functional failure.

---

# §4 Known Non-Blocking Items (not scored)

Per mandate §2 — Eyal-dependent; **not failed**:

| Item | Status observed |
|------|-----------------|
| CF7 form ID | Placeholder on `/contact/` — status message re wp-admin setup |
| GA4 / Clarity IDs | Not verified (Eyal-dependent) |
| Homepage video embed | Placeholder gradient hero (Eyal-dependent) |
| SMTP delivery | Not verified (IDEA-004) |

---

# §5 validate_aos.sh

```
RESULT: 30 PASS / 18 SKIP / 0 FAIL
L-GATE_BUILD EXIT CRITERION: SATISFIED
```

Run: `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh` on branch `feature/w2-06-blog`, 2026-05-28.

---

# §6 Routing Recommendation

| Verdict | Route |
|---------|-------|
| **FAIL** (AC-05) | team_100 → **team_10 remediation** on CF7 dequeue deploy/logic; re-issue L-GATE_BUILD after fix |
| WP-W2-06 | **Not started** — await `_COMMUNICATION/team_50/GO-SIGNAL-W2-06-QA-<timestamp>.md` |

Constitutional L-GATE_VALIDATE (team_190 / Codex) remains gated until WP-W2-02 L-GATE_BUILD passes with no P0/P1.

---

*team_50 — QA / L-GATE_BUILD — Cursor Composer — 2026-05-28*
