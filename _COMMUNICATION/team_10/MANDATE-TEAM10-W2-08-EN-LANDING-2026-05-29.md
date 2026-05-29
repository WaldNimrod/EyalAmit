---
id: MANDATE-TEAM10-W2-08-EN-LANDING-2026-05-29
from_team: team_100 (Chief System Architect)
to_team: team_10 (Builder)
wp: WP-W2-08 — English Landing Page (/en)
date: 2026-05-29
status: READY TO DISPATCH
spec_ref: _aos/work_packages/S002/WP-W2-08/LOD400_spec.md
depends_on: WP-W2-02 (COMPLETE)
branch: feature/w2-08-en
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-08
---

# Dispatch Mandate — WP-W2-08 (English Landing /en)

## 1. Scope (1 page, EXTEND existing infra — do NOT rebuild)
One English landing page at **`/en`** summarizing the whole site. The WP page + `tpl-en-landing.php`
already exist (live 200 on staging; template registered in `ea_wave2_is_active_view`,
`inc/wave2-stage-b.php:56`). This WP fills the CONTENT + hreflang + CTA. Smaller than W2-05/07.

## 2. Content — VERBATIM from the approved artifact (AC-02: NO builder-authored copy)
Source (FINAL, approved by team_30): `_COMMUNICATION/team_30/W2-08-EN-CONTENT-2026-05-28.md`.
**6 sections, verbatim** (do NOT translate/rewrite/author marketing copy):
1. Hero (H1 tagline + subhead + trust line + CTA) · 2. About Eyal · 3. The Method (cbDIDG) ·
4. Services Overview · 5. Books — Muzza Publishing · 6. Testimonials (8 named, EN) + closing CTA.

## 3. Build (mirror W2-04/05 the_content injection)
- **`inc/wave2-w2-08.php`** (NEW) — router/provider (mirror W2-04): `the_content` filter @ pri 9
  (guards `is_main_query() && in_the_loop()`) keyed on the **`en`** page (slug `en`), injecting the 6
  sections as block markup. Set `ea_wave2_shell`, body `ea-wave2-shell`, no-sidebar, hide GP default
  title (the hero block carries the single H1). `require_once` in `functions.php`. Enqueue any W2-08 CSS.
  FTP cannot write post_content → inject via the_content (consistent with W2-04/05/07-press).
- **`page-templates/tpl-en-landing.php`** — already a thin shell (`lang="en" dir="ltr"`, renders
  `the_title()+the_content()`). Adjust so the injected hero H1 is the page H1 (suppress/avoid a duplicate
  `the_title()` H1 — mirror how W2-04 hides GP title and the hero provides H1). Keep `lang=en dir=ltr`.
- **hreflang (B03)** — EXTEND the existing logic in `functions.php` (around lines 54-60/211, keyed on
  `page_on_front`): on `/en` emit `<link rel=alternate hreflang=en href=…/en/>` + `hreflang=he href=…/>`
  + `x-default href=…/>`; on the **HE homepage** (`page_on_front=16`, `/`) emit the reciprocal
  `hreflang=en href=…/en/>` (+ keep he + x-default). Reciprocal + x-default→`/`. Verify head output.
- **CTA** → `/contact?lang=en` (already in the approved copy; ensure links resolve, never `#`).
- **Media:** hero + section images from new-site uploads (relative paths, authentic — no stock).
- D-14 tokens only (no raw hex); LTR styles; `style.css` Version 1.4.5 → **1.4.6**.
- If the `/en` WP page needs a real post (it already exists live), do NOT recreate; if a `/en/landing`
  legacy URL exists, 301 → `/en` (per spec). Confirm `/en` page slug = `en`.

## 4. Deploy → verify (worktree; cache-bust ?cb=$(date +%s)$RANDOM)
- FTP theme. Staging `http://eyalamit-co-il-2026.s887.upress.link`.
- AC-01 `/en` → 200. AC-02 all 6 sections present, verbatim vs the artifact. AC-03 hreflang per B03
  (curl `/en` head + HE `/` head; confirm reciprocal en↔he + x-default). AC-04 CTA → `/contact?lang=en`.
  AC-05 `validate_aos.sh` 0 FAIL + mobile responsive (LTR).

## 5. Cross-engine (IR#1) + commits
Builder team_10 (Claude). L-GATE_BUILD team_50 NON-Claude. L-GATE_VALIDATE team_190 native Codex.
Commit **surgically by file path — never `git add -A`**. Do NOT push. Report →
`_COMMUNICATION/team_100/W2-08-BUILD-REPORT-2026-05-29.md` (files, /en HTTP, 6-section verbatim check,
hreflang head evidence both directions, CTA, validate result, blockers).

## 6. Out of scope
Full HE-site translation; separate EN service pages; EN blog. Only the single `/en` summary page.

## 7. Activation prompt (paste into builder session on team_00 go)
```
You are team_10 (builder), AOS eyalamit spoke. Build WP-W2-08 (English landing /en).
Worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-08 (branch feature/w2-08-en).
Read in full FIRST: this mandate (_COMMUNICATION/team_10/MANDATE-TEAM10-W2-08-EN-LANDING-2026-05-29.md)
+ spec (_aos/work_packages/S002/WP-W2-08/LOD400_spec.md) + the FINAL approved EN copy
(_COMMUNICATION/team_30/W2-08-EN-CONTENT-2026-05-28.md). EXTEND existing infra: /en page +
tpl-en-landing.php already exist (live 200). Build inc/wave2-w2-08.php (the_content injection keyed on
slug `en`, mirror inc/wave2-w2-04.php), inject the 6 EN sections VERBATIM (no authored/translated copy,
AC-02), single hero H1. Extend hreflang in functions.php per B03 (/en: en+he(->/)+x-default; HE
homepage page_on_front=16: reciprocal en->/en). CTA -> /contact?lang=en. lang=en dir=ltr, D-14 tokens,
style.css 1.4.6. Deploy via FTP, cache-bust. Verify /en 200 + 6 sections verbatim + hreflang both
directions + CTA + validate_aos 0 FAIL. Commit surgically (NO git add -A). Report to _COMMUNICATION/team_100/.
```

*team_100 — 2026-05-29 — READY TO DISPATCH.*
