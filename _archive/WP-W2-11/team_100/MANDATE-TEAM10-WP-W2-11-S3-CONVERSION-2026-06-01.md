---
id: MANDATE-TEAM10-WP-W2-11-S3-CONVERSION-2026-06-01
from_team: team_100 (Chief System Architect — Claude Code)
to_team: team_10 (Builder — cursor-composer)
date: 2026-06-01
wp: WP-W2-11 (S003 Base Implementation — Hybrid Track-1)
cluster: Conversion (C) — /contact, /faq
stage: S3 (Refine/implement — composition-only)
branch: feature/s003-base-implementation-prep
status: ISSUED
decision_ref: _COMMUNICATION/team_00/DECISION_DESIGN-ELEVATION-SEQUENCING_2026-06-01_v1.md
spec_ref: _aos/work_packages/S003/WP-W2-11/LOD400_spec.md
source_of_truth: _COMMUNICATION/team_35/WP-W2-10-C/
---

# MANDATE — team_10 · WP-W2-11 S3 · Conversion cluster (`/contact`, `/faq`)

## 0. Authorization
- **team_00 decision** (2026-06-01): Option C (hybrid). Conversion is a **Track-1 settled cluster** —
  implement now, **no team_35 elevation pass**. (`DECISION_DESIGN-ELEVATION-SEQUENCING_2026-06-01_v1.md`)
- **team_00 confirmations this session:** (1) Conversion is the **first** base cluster. (2) **Proceed now** —
  the 4 open Eyal questions are bridged by graceful placeholders (AC-05), **not** an S2 hold. Defaults below.
- WP-W2-11 LOD400 spec is the contract: `_aos/work_packages/S003/WP-W2-11/LOD400_spec.md`.

## 1. Scope (composition-only)
| Route | Template | Source of truth |
|-------|----------|-----------------|
| `/contact` | `site/wp-content/themes/ea-eyalamit/page-templates/tpl-contact.php` (+ contact-form provider / blocks) | `_COMMUNICATION/team_35/WP-W2-10-C/mockup/conversion-contact.html` + `narrative/composition-notes.md` §A |
| `/faq` | `site/wp-content/themes/ea-eyalamit/page-templates/tpl-faq.php` (+ `block-faq-list`) | `_COMMUNICATION/team_35/WP-W2-10-C/mockup/conversion-faq.html` + `narrative/composition-notes.md` §B |

**Composition-only**: assemble the deltas using **D-14 atoms/tokens verbatim** —
**no new atoms, no new token values, no raw hex, no ad-hoc CSS, no inline `style=""`** (AC-02 / AC-U1).

## 2. Inputs
- team_35 C package (mockups, composition-notes §A–D, asset-manifest).
- Deployed REAL templates (`tpl-contact.php`, `tpl-faq.php`) — both render, staging HTTP 200.
- D-14 SSoT: `assets/css/ea-tokens.css`, `ea-atoms.css`, `ea-animations.css`.
- Deploy: `scripts/ftp_deploy_site_wp_content.py`. QA tooling: `scripts/qa/`.
- Staging base (HTTP-only; TLS cert expired): `http://eyalamit-co-il-2026.s887.upress.link`.

## 3. S3 deltas to apply

### `/contact` — contact-form archetype (composition-notes §A)
- **Two-column `ea-contact-section`**: form column + (WhatsApp A/B + `.ea-trust`) column; collapse to one
  column `<768px`.
- **Form field order** (the design-toward layout for sign-off): שם מלא (required) → טלפון (required, `type=tel`)
  → דוא״ל (optional, `type=email`) → נושא הפנייה (`select`, options aligned to service slugs) → הודעה
  (required `textarea`) → submit `.ea-cta-pill.ea-cta-pill--primary`. Phone-first (primary conversion is
  callback/WhatsApp; email optional).
- **WhatsApp A/B pair** per WP-W2-01 `ea-ab-testing`: `data-ab-experiment="contact_whatsapp_cta"`, variant A
  (`דברו איתי בוואטסאפ`) visible + variant B (`לתיאום שיחת היכרות בוואטסאפ`) `hidden`.
- **`.ea-whatsapp-float`** persistent fixed CTA, RTL-correct `inset-inline-start` (bottom-left).
- **`.ea-trust`**: 3 real reassurances (שיחת היכרות ללא התחייבות / ליווי אישי אחד על אחד / מענה תוך יום עסקים).
- **Form a11y (AC-03 target):** explicit `<label for>` on every control; required fields `required` +
  `aria-required="true"`; pre-wired error spans (`aria-describedby` → `#cf-*-err`, `hidden` until invalid) with
  `aria-invalid` hook; `novalidate`; single `<h1>`; `.ea-skiplink` / `.ea-sr-only` present.
- **CF7 gap (AC-05):** template calls `ea_wave2_render_contact_form()`; staging is `form_id=0` → the existing
  placeholder must keep rendering (no fatal, no console error). Wire the real form later via
  `add_filter('ea_wave2_cf7_form_id', fn()=><ID>)` once Eyal creates it — **do not invent an id**.

### `/faq` — faq-accordion archetype (composition-notes §B)
- **Sticky `.ea-faq-filter`** under the nav: `<select id="faq-topic">` with the **11 verbatim live slugs**
  `all, treatment, lessons, sound-healing, method, didgeridoos, bags, stands-storage, stand-floor, repair, general`;
  `aria-controls="faq-list"`; `?topic=<slug>` URL state via `history.replaceState` + read-on-load;
  `aria-live` `#faq-count` announces result count (AC-C3).
- **Heading hierarchy:** page `h1` → category `h2` → question `h3` (trigger wrapped in `<h3>`).
- **Accordion:** `<button aria-expanded>` + `role="region"` answer panel (axe-explicit state). You **may revert
  to native `<details>/<summary>`** if preferred — layout/styling map 1:1, no token change either way.
- **Empty categories (resolved default):** the 5 with no published answers (bags / stands-storage / stand-floor
  / repair / general) stay as `hidden` "תוכן בהכנה" groups for filter parity. **Keep visible — do not remove.**

### Motion
Mockups shipped motion-off for a clean audit. Live breathe/fade is the **S3 build layer from
`ea-animations.css`** (the SSoT) — wire it respecting `prefers-reduced-motion`.

### Resolved defaults for the open Eyal questions (per team_00 — all non-blocking, AC-05)
| # | Question | Resolved default for S3 |
|---|----------|-------------------------|
| Q1 | CF7 field set | Build the mockup field set (name/phone/email/topic/message); `form_id=0` placeholder stays until Eyal creates the form. |
| Q2 | FAQ empties | Keep visible as `hidden` "תוכן בהכנה" groups (parity). |
| Q3 | Contact-details block | **Not added** — form + WhatsApp only (unless Eyal later requests). |
| Q4 | WhatsApp A/B copy + number | Placeholder `wa.me/0000000000` + mockup-drafted A/B copy; real number folds in later. |

## 4. Constraints (team_00 standing directives)
- Composition-only; zero D-14 drift (AC-02). Reuse atoms verbatim.
- Deploy to staging via `scripts/ftp_deploy_site_wp_content.py` (cache-busted).
- `php -l` clean on every touched PHP file.
- **Surgical, per-file commits — never `git add -A`.** Work on `feature/s003-base-implementation-prep`.
  No `main` merge / push without team_00 go.
- **No self-validation.** S5 is team_50 (build-gate) → team_190 (validate). STOP and hand back after
  deploy + your own functional self-smoke (HTTP 200 on both routes, placeholders render, no console errors).

## 5. Acceptance (Conversion subset of WP-W2-11 ACs)
- **AC-01** `/contact` + `/faq` composition match the team_35 C mockups (composition-only).
- **AC-02** Zero D-14 token drift (team_80 S4 verifies).
- **AC-03** axe-core 0 critical / 0 serious on both routes.
- **AC-04** Lighthouse (HTTP): a11y 100 (≥97 only if a documented moderate), mobile perf ≥85.
- **AC-05** CF7 `form_id=0` placeholder + FAQ empty-category "תוכן בהכנה" degrade gracefully — no broken UI / console errors.
- **AC-06** `validate_aos.sh .` 0 FAIL + `scripts/final_pre_cutover_check.sh` exit 0 + `php -l` clean.
- **AC-07** Deployed to staging, per-route HTTP 200, cache-busted.

---

## 6. Downstream gate handoffs (the full cluster chain, paste-ready)

### S4 → team_80 — token-compliance (after S3 deploy, before S5)
Audit the refined `/contact` + `/faq` CSS/HTML for D-14 drift. PASS = zero drift → S5 proceeds.
```
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026"
# raw hex (should be sourced from ea-tokens.css custom props, not literals in new rules):
grep -rnE "#[A-Fa-f0-9]{3,6}" site/wp-content/themes/ea-eyalamit/page-templates/tpl-contact.php site/wp-content/themes/ea-eyalamit/page-templates/tpl-faq.php site/wp-content/themes/ea-eyalamit/template-parts/blocks/
# inline styles:
grep -rn 'style="' site/wp-content/themes/ea-eyalamit/page-templates/tpl-contact.php site/wp-content/themes/ea-eyalamit/page-templates/tpl-faq.php site/wp-content/themes/ea-eyalamit/template-parts/blocks/
# new custom properties / animations introduced this WP (diff against main):
git diff main -- site/wp-content/themes/ea-eyalamit/assets/css/
```
Write `TOKEN-COMPLIANCE-WP-W2-11-CONVERSION-2026-06-0X.md` to `_COMMUNICATION/team_80/` with PASS/findings.

### S5 → team_50 — L-GATE_BUILD (non-Claude) — PASTE-READY
```
Run HTTP-only QA on the EyalAmit staging Conversion routes after the WP-W2-11 S3 deploy.
cd to the repo root (/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026), then:
  node scripts/qa/http-qa-axe.cjs /contact/ /faq/
  bash scripts/qa/http-qa-lighthouse.sh /contact/ /faq/
Base = http://eyalamit-co-il-2026.s887.upress.link (HTTP-only; staging TLS cert is expired).
PASS bar: axe 0 critical AND 0 serious on BOTH routes; Lighthouse a11y 100 (>=97 only if a documented
moderate), mobile perf >=85 (triple-run median). Record per-route HTTP status + scores and write
QA-VERDICT-WP-W2-11-CONVERSION-L-GATE-BUILD-2026-06-0X.md to _COMMUNICATION/team_50/. Report exit codes.
Do not edit templates — QA only.
```

### S5 → team_190 — L-GATE_VALIDATE (Codex / cross-engine) — PASTE-READY
```
Constitutional L-GATE_VALIDATE for WP-W2-11 Conversion cluster (cross-engine: builder was team_10/cursor-composer
-- you are the independent OpenAI/Codex validator, IR#1+IR#5). Verify against
_aos/work_packages/S003/WP-W2-11/LOD400_spec.md AC-01..AC-07 (Conversion subset) and the team_50 build-gate
verdict. Re-verify LIVE over HTTP (base http://eyalamit-co-il-2026.s887.upress.link, routes /contact/ + /faq/):
composition matches the team_35 C mockups (composition-only), zero D-14 drift, axe 0 crit/serious,
LH a11y 100 / perf >=85, graceful CF7 (form_id=0) + FAQ empty-category placeholders (no console errors),
validate_aos .  -> 0 FAIL. Issue PASS/FAIL with the 8-check rationale to
_COMMUNICATION/team_190/VERDICT-WP-W2-11-CONVERSION-L-GATE-VALIDATE-2026-06-0X.md.
```

---

## 7. Gate sequence for this cluster
L-GATE_SPEC (done — LOD400) → **S3 (team_10, this mandate)** → S4 (team_80) → S5 L-GATE_BUILD (team_50)
→ L-GATE_VALIDATE (team_190) → cluster CLOSE → next cluster (Blog — pending STUB reconciliation, see
`DEVIATION-WP-W2-11-BLOG-TEMPLATE-STATE-2026-06-01.md`).

*Issued by team_100. Begin S3 on team_00 go. Iterate within this mandate; escalate blockers to team_100.*
