---
id: INFO-HANDOFF-TO-W2-05-SESSION-2026-05-29
from_team: team_100 (Chief System Architect — W2-04 session)
to_team: team_100 (next session — W2-05)
wp: WP-W2-05 — Shop (5 product pages + /shop catalog)
date: 2026-05-29
status: READY TO DISPATCH
---

# Handoff → WP-W2-05 session

WP-W2-04 is **CLOSED** (COMPLETE / LOD500_LOCKED; team_190 L-GATE_VALIDATE PASS) and **merged + pushed to origin/main** (`df8c8d2`). team_191 archive COMPLETE (`637b070`, `03fd06b`). This handoff seeds the next WP in the Wave2 loop.

## Git state
- **main** @ `03fd06b` (team_191 archive complete) — pushed to origin.
- **Working tree:** `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026` on main.
- **Worktree W2-04** at `/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-04` (branch `feature/w2-04-services`) — still exists; can be removed after confirming archive is complete (team_191 already archived all artifacts).
- **Create new worktree for W2-05** at session start:
  ```
  git -C ".../EyalAmit.co.il-2026" worktree add "../EyalAmit-w2-05" -b feature/w2-05-shop
  cp ".../EyalAmit.co.il-2026/local/.env.upress" ".../EyalAmit-w2-05/local/.env.upress"
  ```

## What to build (spec: `_aos/work_packages/S002/WP-W2-05/LOD400_spec.md`, lod_status LOD400)
- **6 pages:** `/didgeridoos`, `/bags`, `/stands-storage`, `/stand-floor`, `/repair` (each on `tpl-shop-item.php`) + `/shop` (catalog on `tpl-shop-archive.php`).
- Sources in `docs/.../תוכן לאתר 25.5.26/`: `כלים למכירה/buy didgeridoo.md`, `תיקים לדיג'רידו/bags for didg.md`, `סטנדים לדיג'רידו לאחסון/stend for hanging.md`, `סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md`, `תיקון כלי דיג'רידו/build didg.md`.
- Block contract (10/page): hero · what-it-is · features · who-it's-for · FAQ(filtered) · testimonials(placeholder) · **price** · **purchase CTA** · gallery · closing.
- **Price:** `ea_product_price` post meta (Eyal enters via WP admin); fallback "מחיר לפי התאמה" if empty. No hardcoded prices.
- **Purchase/Contact CTA matrix (B02):** Green Invoice URL → new-tab; no GI URL → `/contact?subject=product-<slug>` same-tab. Always fire GA4 `product_cta_click {product_slug, cta_type}`. A/B (`eyal_cta_variant`) selects form vs WhatsApp for the contact path (same canonical key as W2-04).
- **Catalog `/shop`:** responsive grid (4-up desktop, 2-up mobile); each card links to its product page + shows price/fallback.
- Reuse W2-02 infra: `inc/wave2-w2-05.php` router, `ea_wave2_shell`, `ea-wave2-shell` body class, D-14 tokens (no raw hex), `style.css` → **1.4.4**.
- **the_content filter** injection pattern (same as W2-04) — FTP cannot write post_content.
- No WooCommerce. No new A/B key (reuse `eyal_cta_variant`).
- AC-05 rule: normalize clear typos, preserve Eyal's voice/slang (carry-forward from aos_decide B).

## Acceptance criteria (gate against)
AC-01 6 URLs 200 · AC-02 full block contract each product page · AC-03 price shown (or fallback) · AC-04 CTA matrix correct + GA4 · AC-05 /shop responsive grid · AC-06 validate_aos 0 FAIL.

## Dependencies / carry-forwards
- depends_on WP-W2-02 (COMPLETE — tpl-service.php + infra exists). W2-04 COMPLETE.
- Soft-dep WP-W2-07 (testimonial images, non-blocking — same carry-forward as W2-04).
- No W2-05 team_10 mandate authored yet — author one (mirror MANDATE-TEAM10-W2-04) before dispatch.
- **Green Invoice URLs for each product:** NOT YET PROVIDED by Eyal. Use `/contact?subject=product-<slug>` fallback for all at build time; CTA type = 'contact'. When Eyal provides the GI URLs, they can be wired in post-closure or in a W2-07-era pass.

## ⛔ PRECONDITION #1 — still open (carry-forward from W2-04)
DB-as-SSoT infra gap: `GET /api/l0/eyalamit/roadmap` → 404 (API cannot reach Mac local_path). Decision-request routed to AOS hub team_100 (MSG-HUB-20260529-001). Offline-fallback authorized by team_00 for all WP closures until hub decision returns. Continue offline-fallback for W2-05 closure. Check inbox for hub response at session start.

## ⚠ AOS_decide PENDING — F-W2-04-FAQ-PREGNANCY-LINK (non-blocking for W2-05)
team_00 response pending. Recommendation: **C** (TODO comment in block-faq-list.php + verify W2-06 import). Whatever is decided: implement in a targeted micro-commit on main before W2-05 ship (1-line change to block-faq-list.php + redeploy). NOT a W2-05 gate dependency.

## The loop (same as W2-04)
build (team_10 Claude sub-agent) → deploy via `scripts/ftp_deploy_site_wp_content.py` (cache-bust `?cb=$(date +%s)$RANDOM`) → **L-GATE_BUILD team_50 (NON-Claude)** → **L-GATE_VALIDATE team_190 (native Codex)** → canonical checks → closure (offline-fallback) → team_191 archive → merge + push on team_00 go → re-handoff to **WP-W2-08** (or whichever is next in the active queue — check roadmap `status: PLANNED` + `blocked: false`).

## Standing team_00 directives (DO NOT drop)
1. Fix what you find — remediate findings, don't just flag.
2. Always present team_00 a paste-ready dispatch prompt for team_50 + team_190 gate sessions.
3. Commit surgically by file — never `git add -A`. IR#1 cross-engine chain immutable.
4. Push only on team_00 explicit request.

*team_100 (W2-04 session) — 2026-05-29*
