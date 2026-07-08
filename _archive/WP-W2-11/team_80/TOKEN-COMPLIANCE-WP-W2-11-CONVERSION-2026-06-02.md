---
id: TOKEN-COMPLIANCE-WP-W2-11-CONVERSION-2026-06-02
from_team: team_80 (Design-System Owner / Token-Compliance Validator)
to_team: team_100 (Chief System Architect)
date: 2026-06-02
wp: WP-W2-11 (S003 Base Implementation — Hybrid Track-1)
cluster: Conversion (C) — /contact, /faq
stage: S4 (token-compliance gate — internal build-side, NOT external S5 QA)
branch: feature/s003-base-implementation-prep
builder_ref: team_10 S3 (commits 6172d0b tpl-contact, a925582 block-faq-list, 5a90419 ea-faq-filter.js)
spec_ref: _aos/work_packages/S003/WP-W2-11/LOD400_spec.md
mandate_ref: _COMMUNICATION/team_100/MANDATE-TEAM10-WP-W2-11-S3-CONVERSION-2026-06-01.md §6
verdict: PASS
gcr_needed: RESOLVED (team_00-approved rules-only addition authored 2026-06-02)
---

# S4 Token-Compliance Verdict — WP-W2-11 Conversion (`/contact`, `/faq`)

**VERDICT: PASS_WITH_FINDINGS** — zero D-14 token drift (AC-02 satisfied), but a
genuine, *pre-existing* design-system gap blocks full AC-01 composition fidelity.
A Governance Change Request (GCR) is recommended before S5, routed team_100 → team_00
per CLAUDE.md / Iron Rule #12 (ADR040). **No CSS was added in this S4 pass** (verify-and-rule role only).

Scope audited: the three S3-changed files only —
`page-templates/tpl-contact.php`, `template-parts/blocks/block-faq-list.php`,
`assets/js/ea-faq-filter.js`. CSS SSoT (`ea-tokens.css`, `ea-atoms.css`,
`ea-animations.css`) cross-referenced read-only.

---

## 1. Drift audit (AC-02) — per check

| # | Check | Result | Evidence |
|---|-------|--------|----------|
| D1 | Zero raw hex literals in new rules | **PASS** | Only grep hit was `&#9662;` (HTML numeric entity for ▾ down-triangle glyph in the FAQ accordion icon) — not a CSS color literal. |
| D2 | Zero inline `style="…"` | **PASS** | `grep 'style="'` over all three files → NONE. |
| D3 | Zero new CSS custom properties | **PASS** | `git diff main -- assets/css/` is **empty** (no CSS files touched). The `--` grep hits are `ea-cta-pill--primary` BEM modifier class names, not `--var:` declarations. |
| D4 | Zero new atoms | **PASS** | Every styling class composed in S3 resolves to an existing D-14 atom (table below). New BEM-ish hooks added (`data-ea-ab`, `data-ea-ab-wa`, `ea-cta-ab__wa`, `#faq-count`/`ea-faq-list__filter-count`) carry **no styling** — they are JS/behavior hooks (see §2 Dev-1) or unstyled structure (see §2 Dev-3), not new visual atoms. |
| D5 | Zero new animations | **PASS** | No `assets/css/` change; no `@keyframes`; no `.style.*` JS manipulation (`git diff` JS → NONE). Motion is inherited via `ea-entrance` from `ea-animations.css` (composition-only). |
| D6 | WhatsApp A/B = legit reuse, not ad-hoc | **PASS** | See §2 Deviation 1. |

### Atom-resolution table (every S3 styling class → live D-14 source)
| Class composed in S3 | Resolves to | Source file |
|----------------------|-------------|-------------|
| `ea-contact-section` / `__inner` / `__heading` / `__body` / `__cta-side` | existing | `ea-atoms.css` |
| `ea-contact-form` (+ `__field/__label/__input/__select/__textarea/__error/__note`) | existing | `ea-atoms.css` |
| `ea-cta-pill`, `ea-cta-pill--primary` | existing | `ea-atoms.css` |
| `ea-cta-ab` | existing | `w2-04-service.css`, `w2-05-shop.css` |
| `ea-entrance` | existing | `ea-atoms.css`, `ea-animations.css` |
| `ea-sr-only` | existing | `ea-atoms.css` |
| `ea-faq-item`, `__summary`, `__icon`, `__question`, `__answer` | existing (incl. `__summary` L919, `__icon` L943) | `ea-atoms.css` |
| `ea-faq-category` | existing | `w2-04-service.css`, `w2-05-shop.css` |

**Drift-audit conclusion: ZERO D-14 token drift.** AC-02 is satisfied.

---

## 2. Adjudication of team_10's three reported deviations

### Deviation 1 — WhatsApp CTA mapping → **ACCEPTED (legitimate reuse)**
The team_35 mockup names (`.ea-wa-variants` / `.ea-wa-cta` / `.ea-trust`) do not exist
in D-14. team_10 correctly **declined to invent atoms** and instead mapped onto the
canonical WP-W2-01/W2-04 `ea-ab-testing` mechanism.

Verified against `assets/js/ea-ab-testing.js`:
- L50 `document.querySelectorAll('[data-ea-ab]')` — reads the wrapper team_10 emitted.
- L55 `cta.querySelector('[data-ea-ab-wa]')` — reads the variant anchors team_10 emitted.
- L53 `data-ea-page` — team_10 set `data-ea-page="contact"`.

The wrapper `<div class="ea-cta-ab" data-ea-ab data-ab-experiment="contact_whatsapp_cta" data-ea-page="contact">`
and the two `data-ea-ab-wa` anchors are an exact fit for this JS contract. **Visual** styling
of the buttons comes entirely from `ea-cta-pill ea-cta-pill--primary` (both in `ea-atoms.css`).
`data-ea-ab` / `ea-cta-ab__wa` being "absent from CSS" is **correct and expected** — they are
behavior hooks, not styling classes. This is verbatim reuse of an existing mechanism, **not ad-hoc styling.** ✔

### Deviation 2 — FAQ empty categories → **ACCEPTED (no-op, forward-parity safe)**
Live `$faq_data` populates all listed categories, so the `empty($cat_items)` branch
(the `hidden` "תוכן בהכנה" group) renders nothing today. The guard is structurally present
for forward parity (mandate Q2 default: keep `hidden` groups for filter parity) and emits
no markup now. No drift, no AC-05 risk. ✔

### Deviation 3 (KEY) — unstyled composition → **GENUINE D-14 GAP → GCR recommended (option b)**
team_10 reports `.ea-contact-page-intro`, `.ea-page-title` (non-blog scope),
`.ea-faq-list__filter` (sticky), `.ea-faq-category__heading` are structurally present but
visually unstyled, and (per composition-only) did not add CSS. **I confirm this is real and
rule it a genuine gap, not an acceptable composition-only outcome.** Evidence:

- `.ea-contact-page-intro` (+ `__inner`/`__sub`): **no rule anywhere** in live CSS.
- `.ea-page-title`: styled **only** under `.ea-wave2-blog-archive` / `.ea-wave2-blog-single`
  scopes in `ea-blog.css` (L14, L184). The contact page renders under `<main class="ea-wave2-contact">`,
  so `.ea-page-title` there inherits **no** sizing/weight/color. (Pre-existing on `main`.)
- `.ea-faq-list__filter` sticky: **no `position:sticky`** for the FAQ filter anywhere in live CSS;
  `.ea-faq-list__filter-label` / `__select` / `__count` also unstyled.
- `.ea-faq-category__heading`: **no rule** in live CSS.

Crucially, the team_35 mockup (`conversion-faq.html`) *does* define all of these — but the rules
live **only in the mockup's inline `<style>` block**, expressed in `--ea-*` tokens
(`.ea-faq-filter{position:sticky;top:var(--ea-nav-height);z-index:var(--ea-z-sticky);…}`,
`.ea-page-title{font-weight:200;font-size:2.8rem;color:var(--ea-ink);…}`). They were **never
promoted into the D-14 SSoT** (`ea-atoms.css`). The mockup even uses different class names
(`.ea-faq-filter`, `.ea-faq-page-intro`) than the live template (`.ea-faq-list__filter`,
`.ea-contact-page-intro`), so even a name-for-name port is not 1:1.

This gap is **pre-existing** (the unstyled `.ea-contact-page-intro` + `.ea-page-title` exist on
`main`; team_10 did not introduce them) — so it is **not** an S3 build defect and **not** drift.
But composition-only **cannot** close it: AC-01 (composition matches the team_35 C mockup) will
**not** be fully met at S5 for the sticky filter, styled category headings, and styled page title,
because the visual rules the mockup specifies simply do not exist in D-14. This is a missing-atom
gap, not a token gap.

---

## 3. GCR recommendation (routes team_100 → team_00 per Iron Rule #12 / ADR040)

A GCR is **recommended before S5** so AC-01 can pass. team_80 (D-14 owner) cannot add these
atoms unilaterally; the change must be authored into the hub SSoT after team_00 approval.
**Good news: every value needed is already a defined D-14 token** (verified in `ea-tokens.css`:
`--ea-nav-height`, `--ea-z-sticky`, `--ea-prose-width`, `--ea-gutter`, `--ea-space-*`, `--ea-bg`,
`--ea-ink` all present). So the GCR adds **rules only — zero new token values**, keeping the
design system tight.

Atoms/rules to add to `ea-atoms.css` (token-only, no new custom properties):

1. **`.ea-faq-list__filter`** (sticky) — `position:sticky; top:var(--ea-nav-height); z-index:var(--ea-z-sticky); background:var(--ea-bg); padding:0 var(--ea-gutter) var(--ea-space-3);` plus `__inner` flex layout, `__label`, `__select`, `__count` rules (port from mockup `.ea-faq-filter*`, renamed to the live `ea-faq-list__filter*` namespace).
2. **`.ea-faq-category__heading`** — heading rule (weight/size/spacing) in `--ea-*` tokens (port from mockup).
3. **`.ea-page-title`** — promote a **scope-neutral** base rule (or add an `.ea-wave2-contact .ea-page-title` scope) so the contact `<h1>` is styled outside blog scope. Recommend a scope-neutral base atom to avoid per-page duplication.
4. **`.ea-contact-page-intro`** (+ `__inner`, `__sub`) — section/intro layout in `--ea-*` tokens (port from mockup `.ea-faq-page-intro` analog).

GCR template:
`/Users/nimrod/Documents/agents-os/lean-kit/modules/project-governance/config_templates/GOVERNANCE_CHANGE_REQUEST.md.template`.
File the GCR in `_COMMUNICATION/team_XX/` → route to team_100 → team_00 approval → hub edit
(`ea-atoms.css`) → `aos_sync_all.sh` propagation → re-run S3 deploy → S4 re-spot-check → S5.

---

## 4. Verdict & handback

- **AC-02 (zero D-14 drift): PASS.** No raw hex, no inline styles, no new custom properties,
  no new atoms, no new animations. WhatsApp A/B is verified legitimate reuse of the canonical
  `ea-ab-testing` mechanism.
- **AC-01 (composition match): BLOCKED on a pre-existing D-14 gap** for the sticky FAQ filter,
  styled category headings, styled (non-blog) page title, and contact-page intro. Closing it
  requires a GCR (rules-only, zero new tokens), not more composition.
- **Overall: PASS_WITH_FINDINGS.** team_10's S3 is clean and within mandate; the gap is not a
  builder defect. Recommend team_100 file/route the GCR to team_00 before S5 so team_50/team_190
  can pass AC-01. If team_00 instead rules the unstyled-but-accessible state acceptable for this
  base pass (defer styling to a later elevation), that is a valid call to make at the team_00 level
  — but S5 AC-01 fidelity should not be asserted PASS in the meantime.

*No `_aos/` or theme files were edited in this S4 pass. This is an internal build-side gate;
external axe/Lighthouse S5 QA remains team_50 → team_190.*

— team_80

---

## 5. GCR RESOLVED — rules-only D-14 addition (team_00-approved 2026-06-02)

**team_00 APPROVED** (2026-06-02) the rules-only addition recommended in §3, authorized to
team_80 as D-14 owner. The rules were authored into `assets/css/ea-atoms.css` (the live D-14
SSoT for this spoke) under the comment banner
`/* WP-W2-11 Conversion — D-14 rules-only addition, team_00-approved 2026-06-02 */`.

**Constraint honored: zero new token values.** Only existing custom properties from
`ea-tokens.css` were used. Verified:
- `git diff main -- assets/css/ea-tokens.css` → **EMPTY** (token SSoT unchanged).
- grep of the additions for raw hex `#[0-9A-Fa-f]{3,6}` → **NONE**.
- grep for new `--ea-*` property declarations → **NONE**.
- grep for new `@keyframes` → **NONE**.

### Rules added (selectors → tokens used)

1. **`.ea-contact-page-intro`** — `padding: calc(var(--ea-nav-height) + var(--ea-space-10)) var(--ea-gutter) var(--ea-space-5); background: var(--ea-bg);`
   - **`__inner`** — `max-width: var(--ea-prose-width); margin-inline: auto;`
   - **`__sub`** — `var(--ea-font)`, `var(--ea-text-body)`; literal `1.05rem`/`1.9`/`65ch` per existing house style (no token exists for these — same as `.ea-section-intro__body`).
2. **`.ea-wave2-contact .ea-page-title, .ea-wave2-faq .ea-page-title`** — `font: var(--ea-type-h1); color: var(--ea-text); margin: 0 0 var(--ea-space-2) 0;`. **Existing blog rules (`.ea-wave2-blog-archive`/`.ea-wave2-blog-single .ea-page-title` in `ea-blog.css`) left untouched.**
3. **`.ea-faq-list__filter`** (sticky) — `position: sticky; top: var(--ea-nav-height); z-index: var(--ea-z-sticky); background: var(--ea-bg); padding: 0 var(--ea-gutter) var(--ea-space-3);` + flex layout with `gap: var(--ea-space-2)`. Plus `__filter-label` (`var(--ea-font)`/`var(--ea-ink)`), `__filter-select` (`var(--ea-line)`/`var(--ea-radius-img)`/`var(--ea-bg)`/`var(--ea-ink)`/`var(--ea-terracotta)` focus), `__filter-count` (`var(--ea-muted)`, `margin-inline-start: auto`). Mobile: `top: var(--ea-nav-height-mob)`.
4. **`.ea-faq-category__heading`** — `var(--ea-font)`, `font-weight: 200`, `color: var(--ea-ink)`, `margin: 0 0 var(--ea-space-2) 0; padding-bottom: var(--ea-space-1);` (literal `1.4rem`/`1.2` per existing house style — matches `.ea-faq-group__heading` in the mockup; no font-size token at this step).

RTL handled with logical properties (`margin-inline`, `margin-inline-start`). No transitions
added, so no `prefers-reduced-motion` block required.

### Verdict flip

- **AC-01 (composition match): now CLOSEABLE.** The four selectors are now styled in D-14 to
  the team_35 mockup intent; S5 can assert AC-01 fidelity for the sticky filter, styled category
  headings, styled (non-blog) page title, and contact intro band.
- **AC-02 (zero D-14 token drift): PASS** — re-confirmed; the addition introduced zero new tokens
  and zero raw hex.
- **OVERALL VERDICT: PASS.**

team_80 authored `ea-atoms.css` only. **Not deployed** — team_10 will redeploy the updated CSS
to staging next. Not pushed/merged (stays on `feature/s003-base-implementation-prep`).

— team_80 (2026-06-02, GCR-resolved)
