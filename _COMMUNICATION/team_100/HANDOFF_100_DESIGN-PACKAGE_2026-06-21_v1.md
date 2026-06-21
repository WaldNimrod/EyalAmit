---
id: HANDOFF_100_DESIGN-PACKAGE
title: AOS HANDOFF — team_100 → next session · design-package mission · depth FULL
date: 2026-06-21
from_team: team_100 (Chief Architect — claude-code)
to_team: team_100 (next session)
mechanism: /AOS_handoff 100 full → /AOS_mail handoff → API offline (probed HTTP 000) → file-transport fallback (ADR043 §4/§5). THIS FILE is the handoff.
repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
profile: L0 spoke · domain eyalamit
---

# Mission (NEW primary — Nimrod 2026-06-21)
**Implement the design package: mockups → an updated design template.** A **DEEP + FULL redesign** of the site's visual layer **+ image integration**. This is the next program after SEO/GEO Round-2.

# §A — SEO/GEO Round-2: final state (DON'T break it; close the loose ends first)
Full record: `_COMMUNICATION/team_100/SEO-GEO-ROUND2-COMPLETION-2026-06-21.md` (on branch `seo-geo-r2` / origin).
Branch `seo-geo-r2 @ fe230da` (7 commits off `main 5f9908c`), pushed to origin.

**DEPLOYED + verified live (theme 1.4.17):** AC-18 FAQ links → direct-200 (0 chains/broken); AC-19 per-post meta; WP-06 brand «סטודיו נשימה מעגלית» removed (incl. seeded `/qr/qr32/` via the `ea-w2-06-brand-migration-once` DB migration); WP-07 60 QR embeds → youtube-nocookie. content-diff 16/17 gatePass, 0 invented.

**COMMITTED but NOT deployed (uPress FTP outage ~16:35–17:05; HTTP fine):**
1. **WP-04 og:image (`c9827e3`)** — first deploy shipped a Yoast-filter version that **doesn't fire on v27.8**, so **og:image is still MISSING live**. Rewrote to emit via `wp_head`. **Needs redeploy + verify.**
2. **`/eyal-amit/` heading minimal edit (`32eefde`)** — restores source-matching wording.

# §B — IMMEDIATE loose ends to close (do FIRST, before/with the redesign)
1. **Redeploy** `seo-geo-r2` when FTP recovers: from the worktree `../EyalAmit-seo`, `python3 scripts/ftp_deploy_site_wp_content.py`; then VERIFY: `og:image` present + resolves 200 on `/`, `/eyal-amit/`, a blog post (exactly 1, no duplicate); re-run `node scripts/qa/content-diff.mjs` (expect `/eyal-amit/` section to improve).
2. **Dual-PASS** the SEO/GEO round: team_50 (non-Claude) → team_190 final.
3. **Merge** `seo-geo-r2` → `main` on Nimrod's explicit **"מאשר"** (+ **"פוש"** for origin main). main stays validated-only.
4. **`/eyal-amit/` source reconciliation:** the source heading "07" still contains «סטודיו נשימה מעגלית» (D1 removed it from the page → content-diff section 92.31%). Decide: update the source doc heading (→ 100%) OR accept as intentional D1 deviation. Owner: team_00/Eyal.
5. **AC-09 caveat:** brand persists in 6 verbatim testimonial quotes (`ea-testimonials-fb.json`) — Eyal to edit/exclude in the hub; do NOT auto-edit customer quotes.

# §C — The DESIGN mission (assets + scope + first tasks)
**Source assets to intake:**
- **Mockups:** `hub/src/mockups/` (+ built `hub/dist/mockups/`).
- **Design system:** team_80 — `_COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md` + `HANDOFF-DESIGN-SYSTEM-TO-TEAM100-2026-04-10.md`.
- **UI/responsive precedent:** team_35 WP-W2-10 clusters A–G + mobile/Track2 (`_COMMUNICATION/team_35/`); `LOD200-DESIGN-QA-UI-RESPONSIVE-2026-06-16.md`; `VISUAL-FIDELITY-AUDIT-WP-W2-10-2026-06-03.md`; `UI-PRECISION-WORK-PACKAGES-LOD200-2026-05-28.md`.
- **Images:** `MEDIA-INVENTORY-REPORT-2026-06-19.md` + the live media-intake hub page; **EYL-3 (38 media items) is partly Eyal-gated** (service-page heroes + a real studio portrait still needed).

**Scope:** deep + full redesign — implement the mockups into the GeneratePress child theme `site/wp-content/themes/ea-eyalamit/` (templates `page-templates/`, blocks `template-parts/blocks/`, `inc/wave2-*`, CSS `assets/css/` + `style.css`), with full image integration. This is bigger than the prior polish passes — it's a template overhaul.

**First tasks:** (1) intake + read the mockups + design-system spec; (2) gap-analyze current theme vs mockups; (3) plan the redesign in phases (tokens/CSS → layout/blocks → per-page templates → image integration → responsive QA); (4) present the plan before building.

**HARD constraint — preserve the SEO/GEO machine layer:** the redesign touches templates/blocks/CSS that the SEO work depends on. DO NOT regress: Yoast `@graph` (mu-plugin `ea-w2-seo-schema.php`), per-route meta (`inc/wave2-w2-09.php`), og:image (`ea-w2-og-default.php`), 301s (`ea-w209-legacy-301-redirects.php`), analytics (`generate_lead`), the canonical FAQ links (`block-faq-list.php`), NAP/brand. Re-run the SEO QA gates after redesign.

# §D — Repo / branch / worktree / toolchain / governance
- **Branches:** `main @ 5f9908c` (validated trunk: Wave-1 + Wave-1b + mokesh page + Phase-2). `seo-geo-r2 @ fe230da` (Round-2, pending dual-PASS+merge). `mokesh-content` (team_110, merged to main). All on origin.
- **⚠ Worktree separation (HARD — collision happened 2026-06-21):** concurrent sessions MUST use separate git worktrees. team_100 SEO = `../EyalAmit-seo` (`seo-geo-r2`); team_110 = the main dir (`mokesh-content`). For the design mission, create a fresh worktree off `main` (after the SEO merge) e.g. `git worktree add ../EyalAmit-design <branch> main`. Never share one dirty tree. See memory `project_worktree_separation`.
- **Deploy:** `python3 scripts/ftp_deploy_site_wp_content.py` (uploads whole theme + the mu-plugin **ALLOWLIST** — add new mu-plugins there or they won't ship). Bump `style.css Version:` to cache-bust (currently 1.4.17). Credentials: `local/.env.upress` (symlink into a worktree if needed; do NOT read the secret). Staging: `http://eyalamit-co-il-2026.s887.upress.link` (HTTP, noindex by design).
- **QA:** `content-diff.mjs` (≥95 section/≥90 sentence/0 invented), `http-qa-axe.cjs` (0 crit/serious), `_aos/…/qa_probe.mjs` (overflow @360/390/414/768 — ESSENTIAL for a redesign), `http-qa-lighthouse.sh` (CWV). `EA_QA_BASE` overrides the host.
- **Governance:** dual-PASS before main merge (builder≠validator, team_190 final); commit/push/merge ONLY on Nimrod "מאשר/פוש"; verify against the LIVE runtime (the Yoast lesson + the og:image-filter lesson this round); **"מה שלא בשרת לא קרה"** — deploy+verify, not just commit (memory `feedback_server_is_system_of_record`); file-links to Nimrod = clickable `file://…%20…` only.

# §E — Activation prompt
> You are **team_100 (Chief Architect)**, Claude Code, on EyalAmit.co.il-2026. Read this handoff + `SEO-GEO-ROUND2-COMPLETION-2026-06-21.md`. **Work in your own git worktree** (separation rule). **FIRST** close the SEO/GEO Round-2 loose ends (§B): redeploy `seo-geo-r2` when uPress FTP is back + verify og:image live + re-run content-diff; drive the team_50→team_190 dual-PASS; merge `seo-geo-r2`→main on Nimrod's "מאשר". **THEN** take on the **design-package mission** (§C): intake `hub/src/mockups/` + the team_80 design system + the LOD200 design-QA, gap-analyze vs the current theme, and present a phased redesign + image-integration plan BEFORE building — preserving the SEO/GEO machine layer. Present every decision; when told "run", run to the next validation boundary then report. Un-deployed = not integrated.
