---
id: SEO-GEO-ROUND2-COMPLETION
title: SEO/GEO Round-2 — build + deploy + verification record (team_100)
date: 2026-06-21
from_team: team_100 (Chief Architect — claude-code)
branch: seo-geo-r2 @ 32eefde (off main 5f9908c) — pushed to origin
staging: http://eyalamit-co-il-2026.s887.upress.link
plan: /Users/nimrod/.claude/plans/aos-handoff-gleaming-hare.md
status: DEPLOYED + self-verified (bulk) · 2 refinements committed PENDING redeploy (FTP outage) · pending dual-PASS + merge
---

# §0 Scope (Nimrod-approved)
All non-fully-blocked SEO/GEO items: **AC-18** in-content link canonicalization · **AC-19** per-post meta · **WP-04** og:image default · **WP-07** youtube-nocookie · **WP-06** brand-string removal. Deferred (by decision): WP-07 thumbnail facade, WP-05 WebP pass.

# §1 DEPLOYED + verified live (theme 1.4.17)
| Item | Live verification |
|------|-------------------|
| **AC-18** | `/faq/` has 0 `/Blog/` chains, 0 broken, 0 `/mokesh`; 38 links rewritten to direct-200. Found+fixed 3 broken: ריברסינג slug was wrong (404→correct root slug); de-linked `/cbDidg-therapy-training` (= Eyal-gated EYL-5 course, no page) + `/blog/pregnancy-didgeridoo` (no article) — text kept. |
| **AC-19** | blog single posts now emit exactly **1** `<meta name="description">` (was 0), derived from excerpt. |
| **WP-06** | brand «סטודיו נשימה מעגלית» = **0** on `/eyal-amit/`, `/treatment/`, `/method/`, `/sound-healing/`, footer, **and `/qr/qr32/`** (seeded → DB migration `ea-w2-06-brand-migration-once` ran successfully). Excluded (kept): verbatim testimonial quotes (`ea-testimonials-fb.json`), team_110's `wave2-w2-14e.php`. |
| **WP-07** | 60 QR YouTube embeds → `youtube-nocookie.com` (privacy/perf; lazy already present). CRLF preserved. |
| **content-diff** | 16/17 gatePass, **0 invented sections**, 17/17 ACCURATE — see §3 for the one section finding. |

# §2 COMMITTED but PENDING REDEPLOY (uPress FTP outage 2026-06-21 ~16:35→17:00)
The FTP endpoint went unreachable (connect timeout; HTTP fine) after the first successful deploy. Two refinements are committed + pushed but NOT yet on staging — **a single redeploy + re-verify is required when FTP recovers**:
1. **WP-04 og:image (`c9827e3`)** — the first deploy shipped a Yoast-filter version that **does not fire on Yoast v27.8**, so **og:image is still MISSING live**. Rewritten to emit `og:image`+dimensions+`twitter:image` via `wp_head` (Yoast emits none → no duplicate). **Not integrated until redeployed + verified.**
2. **WP-06 `/eyal-amit/` heading minimal edit (`32eefde`)** — see §3.

**Redeploy checklist (when FTP up):** `python3 scripts/ftp_deploy_site_wp_content.py` from the `seo-geo-r2` worktree → then verify: `curl …/ | grep og:image` (exactly 1, resolves 200) on `/`, `/eyal-amit/`, a blog post; re-run `node scripts/qa/content-diff.mjs` (expect /eyal-amit/ section ≥ prior).

# §3 Finding — `/eyal-amit/` content-diff (source reconciliation, NOT a code defect)
`/eyal-amit/` = **92.31% section** (12/13), 97.92% sentence, 0 invented, verdict ACCURATE. The 1 "missing" section is heading **07: "המרכז לטיפול בדיג'רידו – סטודיו נשימה מעגלית פרדס חנה"** — **Eyal's source heading itself contains the brand**, which D1 mandates removing. So removing it necessarily diverges from the stale source on this heading. Disposition options: **(a)** reconcile the source doc (drop the brand from that heading → restores 100%), or **(b)** accept as an intentional D1 deviation. I minimized the edit to keep the source-matching wording "המרכז לטיפול בדיג'רידו" (dropping only the brand), to maximize re-match after redeploy. **Action for team_00/Eyal:** confirm (a) or (b).

# §4 Other findings / flags
- **AC-09 caveat:** the brand persists in 6 verbatim testimonial quotes (`ea-testimonials-fb.json`) — these are customer words, NOT edited. AC-09's "--absent" must be re-scoped to the site's own voice (exclude quotes). Eyal may choose to edit/exclude those testimonials in the hub.
- **og:image upgrade (media-gated, EYL-3):** default = `eyal-portrait-hero.jpg`; swap to per-route 1200×630 cards via the `ea_w2_og_default_image_url` filter when media arrives.
- **Broken-link content gaps (Eyal-gated):** the cbDIDG therapist course page (EYL-5) + a didgeridoo-&-pregnancy article don't exist; FAQ now de-links them — re-add when content is created.

# §5 Git + gates
- Branch `seo-geo-r2 @ 32eefde` (7 commits off `main 5f9908c`), pushed to `origin`. Worktree: `../EyalAmit-seo` (separation protocol).
- **Remaining gates:** (1) redeploy on FTP recovery + verify og:image/eyal-amit; (2) **team_50 → team_190 dual-PASS** on the round; (3) merge `seo-geo-r2` → `main` on Nimrod "מאשר" (+ "פוש" for origin main). main stays validated-only.
- New mu-plugins added to deploy ALLOWLIST: `ea-w2-og-default.php`, `ea-w2-06-brand-migration-once.php`.
