# LOD200 — Production Cutover (Go-Live)

**WP (proposed):** `S004-P001-WP003` (milestone S004 *Launch Readiness*) · **Author:** team_100
**Date:** 2026-06-16 · **lod_status:** LOD200 · **Track:** B (Complex/Managed — see §11) · **Profile:** L0 · **Priority:** HIGH

## 1. Problem statement (LOD100 confirmed)
The rebuilt site lives only on **uPress staging** (`eyalamit-co-il-2026.s887.upress.link`, HTTP, `noindex` by mu-plugin).
The public domain **`eyalamit.co.il`** still serves the legacy site (host: mezoohost per `EYAL_LEGACY_FTP_*`). Launch =
a controlled cutover of the validated build to production, with indexing on, real SSL, analytics, and — critically —
**legacy-URL preservation** (301s) so the existing SEO equity and inbound links are not lost. This is the highest-risk
WP of the program (downtime, SEO loss, data loss) and must be runbook-driven with a tested rollback.

## 2. Solution concept
A planned, reversible cutover: freeze + backup → deploy theme + mu-plugins + content to production → configure
production (SSL, indexing, analytics, redirects) → switch the domain to the new site → post-cutover verification +
SEO/perf re-measure on the real domain → rollback if any gate fails.

## 3. Major components & purpose
- **Pre-cutover** — full backup (DB + files) of current production; final staging sign-off; maintenance/freeze window.
- **Production deploy** — theme (`ea-eyalamit`) + mu-plugins + seeded content (pages/posts/menus/forms) to the production WordPress; verify parity with staging.
- **Production config** — `wp-config` (remove `noindex`/staging guards, real `WP_HOME`/`WP_SITEURL`), valid TLS (production cert), CF7 recipient, GA4 + Clarity IDs (Eyal).
- **Legacy 301 map** — every legacy URL → its new canonical (the `_aos`/redirect mu-plugins + `legacy-unmapped.json` already inventory these); zero broken inbound links; single-hop.
- **Go-live** — DNS/domain switch (or in-place activation) to serve the new site at `eyalamit.co.il`.
- **Post-cutover verification** — all routes 200; redirects single-hop; SSL valid; indexing live (robots/sitemap/GSC); **SEO + Core Web Vitals re-measured on production** (staging numbers were artifacts); full smoke + content-diff on prod.
- **Rollback** — documented, tested restore-to-legacy path within the window.

## 4. Primary flow (happy path)
Backup → freeze → deploy + config to prod → wire redirects + analytics → switch domain → verify (200s, redirects, SSL, index, perf) → monitor → sign-off. On any gate fail within the window → rollback to legacy.

## 5. Actors / systems
team_100 (architect/runbook owner) · team_60 (home-server/infra) · builder · team_50 + team_190 (validate) · **Eyal/team_00** (go-live approval, domain + hosting credentials, analytics IDs) · uPress + mezoohost (hosting) · Google Search Console.

## 6. Open decisions (explicit) — several are blocking
- **D-CUT-1 — Target hosting:** does production move to **uPress** (promote staging) or stay on **mezoohost/eyalamit.co.il**? Determines the deploy + DNS path. *(team_00 / Eyal — infra)*
- **D-CUT-2 — Cutover strategy:** in-place upgrade of the live WP vs fresh install + DNS switch (blue/green). *(team_00 / team_60)*
- **D-CUT-3 — Window + comms:** maintenance window timing; whether Eyal wants a soft-launch first.
- **D-CUT-4 — Legacy redirect completeness:** sign-off on the full legacy→canonical 301 map (SEO-critical). *(team_100 + team_190)*
- **D-CUT-5 — Credentials:** production host + domain + analytics access (Eyal-dependent).

## 7. Dependencies & constraints
Gated by: design-QA round (`S004-P001-WP002`) + SEO round (`S004-P001-WP001`) substantially complete; Eyal's go-live
approval + production credentials; the legacy 301 map signed off. Constraint: reversible within the window; no data loss.

## 8. Initial success criteria (directional)
`eyalamit.co.il` serves the validated new site; all routes 200; **every legacy URL 301s single-hop to its canonical**;
valid production TLS; indexing enabled (sitemap submitted, robots correct); analytics live; SEO/CWV re-measured and green
on production; rollback path tested; team_190 final sign-off; Eyal go-live approval recorded.

## 9. Out of scope
The optimization + design work themselves (their own WPs); content authoring; ongoing post-launch maintenance/monitoring (a future ops WP).

## 10. Risk classification
**HIGH / Critical** — production cutover risks downtime, permanent SEO loss (broken redirects), and data loss. Demands a
backup, a tested rollback, a complete redirect map, and a tight verification gate. Several blocking external dependencies.

## 11. Track declaration
**Track B (Complex/Managed).** The risk + multi-system coordination (hosting, DNS, redirects, data, analytics) warrant a
**LOD300** behaviour spec + a step-by-step **cutover runbook with rollback** before LOD400 execution authorization.
