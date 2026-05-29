---
id: MANDATE-TEAM190-W2-05-L-GATE-VALIDATE-2026-05-29
from_team: team_100 (Chief System Architect)
to_team: team_190 (Final Validator — constitutional, IR#5)
wp: WP-W2-05 — Shop (5 product/service pages + unified /shop catalog)
date: 2026-05-29
gate: L-GATE_VALIDATE
build_commit: 112b341
branch: feature/w2-05-shop
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-05
staging: http://eyalamit-co-il-2026.s887.upress.link
status: ISSUED
---

# L-GATE_VALIDATE Mandate — WP-W2-05 (Shop)

## §0 — Engine constraint (IR#1)
team_190 MUST run on **native Codex / OpenAI / GPT-5** (≠ Claude builder team_10, ≠ team_50 QA).
Confirm engine in line 1 of your verdict.

## §0.1 — Worktree (isolation)
W2-05 is in a **dedicated worktree**: `/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-05`
(branch `feature/w2-05-shop`). The shared `EyalAmit.co.il-2026` tree is on `main` — do NOT validate there.

## §1 — Prior gate state
- **L-GATE_BUILD:** _(team_50, non-Claude — verdict pending at issue; run ONLY after team_50 = PASS / PASS_WITH_FINDINGS, no P0/P1)._
  - Verdict path: `_COMMUNICATION/team_50/QA-VERDICT-WP-W2-05-L-GATE-BUILD-2026-05-29.md`
- **L-GATE_SPEC:** LOD400 spec authored 2026-05-28 (team_100), lod_status LOD400.
- **team_100 pre-gate live check (2026-05-29):** 6/6 URLs 200 (cache-busted); /didgeridoos shows
  10 data-block sections; price fallback "מחיר לפי התאמה" present; CTA `/contact?subject=product-didgeridoos`
  + `data-ea-product-cta`; /shop grid with 5 linked cards. validate_aos.sh 30 PASS / 0 FAIL.

## §2 — Proof-of-HEAD (require before validating — W2-02/W2-06 both produced stale verdicts first)
- `git -C "/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-05" rev-parse HEAD` → **`112b341`** (tip).
- base = main @ `9802d90`; working tree clean.
- Deployed theme `style.css` Version = **1.4.4**.
- **CACHE-BUST every HTTP check:** append `?cb=$(date +%s)$RANDOM`.

## §3 — Scope
Validate against LOD400 spec `_aos/work_packages/S002/WP-W2-05/LOD400_spec.md` (AC-01..AC-06). Apply
your 8-check validation + LOD400 precision gate. Independently re-verify live (cache-busted):
- **AC-01:** 6 URLs → 200: `/didgeridoos`, `/bags`, `/stands-storage`, `/stand-floor`, `/repair`, `/shop`.
- **AC-02:** each product page renders the 10-block contract (hero · what-it-is · features · who-it's-for ·
  FAQ[view-only filtered] · testimonials[placeholder] · price · purchase/contact CTA · gallery · closing).
- **AC-03:** price (`ea_product_price` post meta) on catalog card + product page; empty → literal
  "מחיר לפי התאמה". No hardcoded prices in templates.
- **AC-04:** CTA matrix B02 — no GI URL → `/contact?subject=product-<slug>` (same tab), never `#`;
  GA4 `product_cta_click {product_slug, cta_type}` fired; green_invoice branch present but dormant
  (Eyal-pending) is the CORRECT state; A/B reuses canonical `eyal_cta_variant` (no new key).
- **AC-05:** `/shop` responsive grid (4-up desktop / 2-up mobile); each of 5 cards links to its product.
- **AC-06:** `validate_aos.sh` → 0 FAIL; mobile responsive; body class `ea-wave2-shell`; D-14 tokens
  only (no raw hex in w2-05-shop.css).

## §3.1 — Scope-additions to confirm safe (builder went beyond mandate MODIFY list)
- **`mu-plugins/ea-w2-05-shop-pages-seed-once.php`** (NEW, + deploy-list entry): once-only page seeder
  (FTP cannot create WP pages). Confirm guarded/idempotent (ABSPATH, init hook, option flag, transient
  lock, no wp-load re-require), mirrors `ea-m2/m3/m4-*-once.php`.
- **`ea-m2-site-tree-lock-sync-once.php`**: stale `/shop → /tools-and-accessories/` 301 removed.
- Legacy nav-menu item to `/tools-and-accessories/repair/` (page re-parented to `/repair`) — note as
  C3/menu follow-up, non-blocking.

## §4 — Known non-blocking (do NOT block)
Individual Green Invoice product URLs are Eyal-dependent (contact-fallback is spec-sanctioned).
Testimonial + gallery images are W2-07 carry-forward (grey placeholders, spec F02-style). Pre-existing
`shop` page (id 28) title is a C3 content decision.

## §5 — Deliverable
Verdict → `_COMMUNICATION/team_190/VERDICT-W2-05-L-GATE-VALIDATE-2026-05-29.md` (PASS / BLOCKED),
with Verdict Box + Fresh-tree Proof (HEAD `112b341`) + 8-check table + 6/6 AC live re-verify.
- On **PASS** → team_100 executes WP Closure Protocol (roadmap COMPLETE / LOD500_LOCKED via
  offline-fallback per PRECONDITION #1 — named-branch roadmap.yaml edit, gate_history logged;
  team_191 archive; merge `feature/w2-05-shop` → main on team_00 go), then re-hands-off to the next
  PLANNED+unblocked WP.
- On **BLOCKED** → team_100 routes remediation to team_10.

*team_100 — 2026-05-29*
