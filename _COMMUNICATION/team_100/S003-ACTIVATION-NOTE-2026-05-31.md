---
id: S003-ACTIVATION-NOTE-2026-05-31
title: S003 UI-Precision — Activation + S1 (team_35 mockups) Delivery Note
status: S1 DELIVERED (A–F) — awaiting S2 Eyal sign-off; G BLOCKED
date: 2026-05-31
from_team: team_100 (Chief System Architect)
to_team: team_00 (Principal) → Eyal (visual sign-off)
milestone: S003
wp: WP-W2-10 + children A–G
mandate: _COMMUNICATION/team_35/MANDATE-TEAM35-W2-10-CLUSTERS-A-G-2026-05-31.md
---

# S003 UI-Precision — Activation & S1 Delivery

## What happened
On team_00 authorization (2026-05-31), the **entire S003 UI-Precision cluster was activated** and
team_35 (Design Studio, claude-design) produced **S1 hi-fi mockups for all 6 unblocked clusters
(A–F)** — grounded in **real staging content**, composition-only (D-14 atoms cited, none invented).
The packages now await the **S2 Eyal visual sign-off gate** — the review that never happened for
non-home routes (the core value of this phase). **G (Hero video) is BLOCKED** on Eyal's video asset.

## S1 deliverables (HANDOFF_PACKAGE per cluster → `_COMMUNICATION/team_35/WP-W2-10-<X>/`)
| Cluster | Mockup(s) | Real content | Status |
|---------|-----------|--------------|--------|
| **A Service** | `mockup/service-treatment.html` (+ method/sound/lessons reuse same DNA) | /treatment,/method,/sound-healing,/lessons all 200 | READY_FOR_S2 |
| **B Editorial** | `mockup/editorial-about.html` (flagship; press/moksha reuse DNA) | /about,/press,/about/moksha 200 | READY_FOR_S2 |
| **C Conversion** | `mockup/conversion-contact.html`, `mockup/conversion-faq.html` | /contact,/faq 200 | READY_FOR_S2 (CF7 form_id gap) |
| **D Blog** | `mockup/blog-archive.html`, `mockup/blog-single.html` | /blog + real post 200 | READY_FOR_S2 |
| **E Commerce** | `mockup/commerce-books-archive.html`, `mockup/commerce-book-detail.html` | /books,/shop + details 200 | READY_FOR_S2 (asset-gated) |
| **F EN landing** | `mockup/en-landing.html` (LTR) | /en content-complete | READY_FOR_S2 |
| **G Hero video** | — | — | **BLOCKED** (Eyal video) |

Each package also has `HANDOFF_*.md` (index + paste-ready claude-design sandbox prompt), `narrative/composition-notes.md` (D-14 atom citations), and `assets/asset-manifest.md`.

## S2 — consolidated Eyal sign-off questions (per cluster)
- **A Service:** hero "trust" line OK? 3-col comparison via composition vs. team_80 `--3col` modifier? compose treatment mini-FAQ or link to /faq? /method has no testimonials/FAQ — omit slots?
- **B Editorial:** real Eyal **portrait + studio/Moksha photos** (AC-B2 blocker); pullquote as token-composition OK? /press logos text-only (recommended) vs. sourced marks?
- **C Conversion:** **CF7 form_id** — Eyal must create the form in wp-admin (staging form_id=0); confirm field set; empty FAQ categories — show "בהכנה" or hide?
- **D Blog:** author byline `eyaladmin` vs **אייל עמית**? featured-image strategy? keep 6 empty filter chips? approve Share + Related-posts (→ team_80 GCR)? run IDEA-006 excerpt shortcode-strip?
- **E Commerce:** checkout model — online Green-Invoice links vs. contact-to-buy? supply **book cover art + product photos**; confirm purchase destinations; real prices vs "by quote"?
- **F EN landing:** confirm books stay prose summary (no buy grid on /en); `/contact?lang=en` CTA target; text-only translated testimonials OK?
- **ALL:** real **WhatsApp number** (placeholders used across clusters).

## Carry-forwards / findings
1. **Staging TLS cert EXPIRED** (`eyalamit-co-il-2026.s887.upress.link`) — HTTPS-forced fetchers (WebFetch/Lighthouse/axe runners) fail; only plain HTTP works. **The S5 team_50/190 automated gates will hit this** — fix the cert or run gates over plain HTTP. (Also relevant to M7 cutover, which provisions real TLS at the bare domain.)
2. **F EN footer/skip-link RTL bleed** — the shared footer atom + skip-link use *physical* `flex-direction:row-reverse`/`right:0` that do NOT flip under `dir="ltr"`; S3/team_10 must add LTR logical-property overrides (flagged M4/M5/M6, not silently patched).
3. **Asset gaps** (Eyal-provided): book covers, product photos, Eyal portrait + studio/Moksha photos, hero video (G).

## Roadmap state (this activation)
- `WP-W2-10` + `A–F`: `PLANNED` → **`IN_PROGRESS`** (S1 done; awaiting S2). `G`: remains **`BLOCKED`**.
- Offline-fallback (branch `feature/w2-10-activation`, never main; live API re-probe hangs → file SSoT). Merge PENDING team_00.

## Next actions
1. **Eyal reviews the 9 mockups** (open the `mockup/*.html` files in a browser) → APPROVE / REVISE per cluster (S2).
2. On APPROVE: team_100 issues per-cluster S3 mandates to **team_10** (refine deployed templates, composition-only) → **team_80** S4 token-compliance → **team_50 + team_190** S5 dual-gate (non-Claude, cross-engine).
3. Provide the missing assets + WhatsApp number + CF7 form + (for G) hero video.

*team_100 → team_00/Eyal | S1 complete 2026-05-31. The visual sign-off gate is now open.*
