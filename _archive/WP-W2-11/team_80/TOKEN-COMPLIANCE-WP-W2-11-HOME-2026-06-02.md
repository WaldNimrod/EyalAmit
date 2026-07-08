---
id: TOKEN-COMPLIANCE-WP-W2-11-HOME-2026-06-02
from_team: team_80 (Design-System Owner / D-14 token authority)
to_team: team_100 (Chief System Architect)
date: 2026-06-02
wp: WP-W2-11 (S003 Base Implementation — Hybrid Track-1)
cluster: Home refine — /
stage: S4 (internal token-compliance gate — NOT external S5 QA)
branch: feature/s003-base-implementation-prep
spec_ref: _aos/work_packages/S003/WP-W2-11/LOD400_spec.md
mandate_ref: _COMMUNICATION/team_100/MANDATE-TEAM10-WP-W2-11-S3-HOME-2026-06-02.md
status: ISSUED
verdict: PASS_WITH_FINDINGS
---

# TOKEN-COMPLIANCE — WP-W2-11 S4 · Home refine (`/`)

Internal D-14 token-compliance gate for AC-02 (zero design-system drift). This is the
token-compliance audit only; axe/Lighthouse (AC-03/AC-04) are the external S5 gates
(team_50 → team_190) and are explicitly out of scope here.

## 1. Scope under audit
team_10's S3 Home refine made **exactly one substantive change**: it removed the external
`picsum.photos` placeholder `<img class="ea-hero__placeholder">` from
`template-parts/blocks/block-hero.php`. The interim hero now renders the D-14 gradient +
breathing-line overlay only (zero external network requests). The `<br>` H1 was kept
(team_00 decision). All other blocks (2–12) were verify-only — unchanged
POC-signed-off composition.

Verified scope (`git diff main..HEAD -- block-hero.php`):
- Removed: the `<img class="ea-hero__placeholder" src="https://picsum.photos/...">` line
  (note: that `<img>` carried its own inline `style="position:absolute;...z-index:1;"` —
  so this change **net-removes** one inline style rather than adding any).
- Changed: one HTML comment, updated to document the gradient-only / future-`<video>`-swap intent.
- No markup, class, or token additions.

## 2. Drift audit (AC-02) — results

| Check | Result |
|-------|--------|
| `git diff main..HEAD -- assets/css/ea-tokens.css` is EMPTY | PASS (empty) |
| Zero new token VALUES introduced | PASS |
| Zero raw hex in any new rule | PASS (no CSS rules added at all) |
| Zero NEW inline `style=""` introduced | PASS (the change net-**removes** one inline style) |
| No new atoms introduced | PASS |
| No orphaned CSS — `.ea-hero__placeholder` has no leftover rule | PASS |
| No CSS files changed (ea-atoms / ea-tokens / ea-home / hero) | PASS (none touched) |

Evidence:
- `grep -rn "ea-hero__placeholder" site/wp-content/themes/ea-eyalamit/` → **0 matches** anywhere
  (CSS and markup). The selector never had a dedicated CSS rule (the removed `<img>` was styled
  entirely via its own inline `style=""`), so removing the markup left **no orphan rule** and
  no dead selector. Clean removal.
- `git diff main..HEAD` on CSS shows no changes to `ea-atoms.css`, `ea-tokens.css`,
  `ea-home.css`, or any hero CSS. CSS surface is byte-identical to main.

**Drift result: ZERO new D-14 drift.** AC-02 satisfied for the Home refine.

## 3. Adjudication — pre-existing inline `style=""` in POC blocks

team_10 flagged inline `style=""` attributes across six POC blocks. I confirmed via
`git diff --stat main..HEAD` that **all six block files are byte-unchanged by this WP**
(empty diff), i.e. these inline styles are **pre-existing in the POC-signed-off composition
and were NOT introduced by WP-W2-11**.

Inventory (all confirmed pre-existing):

| Block | Inline style(s) | Kind |
|-------|-----------------|------|
| `block-testimonials-row.php` | `animation-delay:0.1s` / `0.2s` | stagger timing (literal seconds) |
| `block-services-row.php` | `animation-delay:0.1s` | stagger timing |
| `block-method-pillars.php` | `animation-delay:0.1s/0.2s/0.3s`; `margin-top: var(--ea-space-6); text-align: right;` | stagger + token spacing |
| `block-contact-cta.php` | `margin-top: var(--ea-space-4);`; `animation-delay:0.15s` | token spacing + stagger |
| `block-treatment-overview.php` | `font-family: var(--ea-font); font-size: 0.78rem; font-weight: 200; color: var(--ea-muted); margin: 0 0 var(--ea-space-4);`; `animation-delay:0.15s` | token typography/spacing + stagger |
| `block-books-row.php` | `animation-delay:0.1s/0.2s`; `margin-top: var(--ea-space-6); text-align: right;` | stagger + token spacing |

Two sub-categories:
1. **Token-based spacing/typography** — uses `var(--ea-space-*)`, `var(--ea-font)`,
   `var(--ea-muted)`. No raw hex (`grep -rnE 'style="[^"]*#[0-9a-fA-F]{3}'` → 0 matches),
   no new token values. These consume existing D-14 tokens correctly; the only deviation is
   that they live inline rather than in a CSS class. The lone literals (`font-size: 0.78rem`,
   `font-weight: 200`) are raw CSS values, not color/design-token drift, and are pre-existing.
2. **Staggered `animation-delay`** (`0.1s`…`0.3s`) — literal time values. The D-14 system
   defines no stagger-delay token, so these are not "raw values where a token exists"; they
   are per-instance sequencing hooks.

### Ruling (as D-14 owner): **(a) acceptable as-is for this conservative Home refine.**

Justification:
- The mandate's "no inline `style=""`" hard constraint (§4) governs **changes introduced by
  this WP**. This WP introduced **none** — it net-removed one. The flagged styles predate the
  WP and live in the POC-signed-off, already-deployed, axe-clean / a11y-100 composition.
- They are **token-based** (where colors/spacing are involved) with **zero raw hex** and
  **zero new token values**, so they do not constitute D-14 *drift* — the design-system
  contract (single source of truth for color/spacing tokens) is intact.
- The conservative-refine contract (§0, §2.2: "Do NOT change the approved composition")
  forbids me — and forbade team_10 — from touching these unchanged blocks. Refactoring inline
  styles into CSS classes here would be out-of-scope churn against signed-off markup and would
  risk regressing the deployed a11y/perf baseline for no compliance gain.

**Carry-forward note (non-blocking):** these pre-existing inline styles should eventually be
migrated to CSS utility classes / a stagger-delay convention as a dedicated DS-hygiene WP
(e.g. introduce `--ea-stagger-1..n` tokens or a `.ea-entrance--delay-N` class set, and move the
token-based spacing/typography inline rules into `ea-atoms.css`). This is a maintainability
cleanup, **not** drift, and must NOT be done inside a conservative composition-only refine.
Recommend team_100 log it to the DS backlog.

## 4. Verdict

**PASS_WITH_FINDINGS.**

- Zero NEW D-14 drift introduced by the Home S3 refine (AC-02 satisfied): tokens diff empty,
  no new token values, no raw hex, no new inline styles (one removed), no new atoms,
  no orphaned `.ea-hero__placeholder` rule.
- One documented **pre-existing, non-blocking carry-forward**: token-based inline `style=""`
  in six unchanged POC blocks — ruled acceptable as-is for this conservative refine, flagged
  for a future DS-hygiene WP.

No blocking drift. Home refine clears the internal token-compliance gate; proceed to S5
(team_50 → team_190).

*Issued by team_80 (D-14 token authority). Audit-only; no PHP/JS/CSS/`_aos/` edits made.*
