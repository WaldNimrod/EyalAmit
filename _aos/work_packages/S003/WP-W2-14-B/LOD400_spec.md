# LOD400 — WP-W2-14-B · Existing elevated clusters — mobile pass (A/B/E/F)

**WP:** WP-W2-14-B | **Milestone:** S003 | **Parent:** WP-W2-14 | **Priority:** HIGH | **Profile:** L0
**Builder:** team_10 | **Tokens:** team_80 | **QA:** team_50 → team_190 (Cursor, incl. VISUAL+mobile)
**Authored:** 2026-06-03 (team_100) | **lod_status:** LOD400
**SSoT:** `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/` — `BREAKPOINT-NOTES.md` + `ea-mobile-variants.css` + the elevated mockups (Service-Treatment, Editorial-About, Commerce-Books-Archive, Commerce-Book-Detail, EN-Landing).

## 0. Objective
Apply the **§4 per-component mobile decisions** to the already-built elevated templates A/B/E/F. They inherit the chrome/drawer from **WP-W2-14-A** (3 enqueues) — this WP adds only the per-component responsive CSS (from `ea-mobile-variants.css`) + any markup hooks needed.

## 1. Scope + §4 decisions (defaults; alternates behind `html[data-…]` for review)
- **A — Service/Treatment:** 3-col service-comparison → **3 full-width stacked cards** (active = terracotta border + `--ea-bg-alt`); 5-tile grid → 1-col; cbDIDG 4-step → 2→1 col; bio portrait+prose stack.
- **B — Editorial/About:** journey timeline → **vertical** (≤639); studio gallery grid → 1-2 col; memorial disc spacing.
- **E — Commerce:** books archive cards → **1-col**; stacked-cover bundle mobile layout; **shop grid 4-up → 2-col** (`data-shop` alternate 1col); book-detail cover-hero → stack + **full-width purchase CTAs**; excerpt long-text handling.
- **F — EN landing:** full **LTR** mobile pass (inherits LTR drawer from 14-A); testimonials → 1-col stack; logical-prop mirror verified.
- CSS sheet ownership: the shared `ea-mobile-variants.css` is owned by 14-A; per-cluster page CSS (`w2-10-service.css`, `ea-blog.css`, `w2-05-shop.css`, `w2-08-en-landing.css`) carries cluster-specific ≤639/≤767 rules.

## 2. Acceptance Criteria
- Each route matches its elevated mockup **on mobile (390px)** + desktop (no desktop regression). Visual screenshot vs mockup = gate.
- §4 defaults implemented; alternates toggle via `data-*` (for review).
- axe 0 crit/0 serious (mobile+desktop) all routes; LH mobile perf median ≥85, a11y 100; **0 horizontal overflow** at 360/390/414/768; single H1; RTL/F-LTR correct.
- D-14 zero-drift (team_80 S4); `ea-tokens.css` unchanged.

## 3. Gate chain
S3 → S4 → deploy → team_100 pre-flight (incl. mobile screenshots) → S5 team_50 → team_190 (Cursor, visual+mobile).

## 4. Orchestration
**Blocked by WP-W2-14-A.** Parallel with C/D/E (isolated worktree; owns only the cluster page-CSS sheets + minimal markup hooks — does NOT touch block-topnav/footer/ea-mobile-nav.* which are 14-A's).

## 5. Spec-validation remediations (2026-06-03)
- **P3 — explicit route ↔ CSS-sheet ownership table** (the only files 14-B may edit):
  | Cluster | Routes | CSS sheet (owned by 14-B) |
  |---|---|---|
  | A Service | /treatment /method* /sound-healing /lessons | `assets/css/w2-10-service.css` |
  | B Editorial | /about /press /about/moksha | `assets/css/ea-blog.css` (editorial section) |
  | E Commerce | /books +details /shop | `assets/css/w2-05-shop.css` |
  | F EN | /en | `assets/css/w2-08-en-landing.css` (LTR; mostly inherits 14-A drawer) |
  (*`/method` desktop+mobile elevation is WP-W2-14-D; 14-B only ensures the service-template mobile variants also apply to it.)
- **P3 — Harmonized QA AC (uniform across 14-B/C/D/E):** `validate_aos .` 0 FAIL · `php -l` clean · per-route HTTP 200 · axe 0 crit/0 serious (mobile+desktop) · LH **mobile triple-run median ≥85** + a11y 100 (https) · 0 horizontal overflow @360/390/414/768 · single H1 · RTL logical props (F=LTR) · D-14 zero new tokens/atoms (team_80 S4) · **visual mockup-vs-live screenshot (desktop+390px) = gate**.
