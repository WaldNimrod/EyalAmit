---
id: MANDATE-TEAM20-W2-09-CUTOVER-2026-05-30
from_team: team_100 (Chief System Architect)
to_team: team_20 (DevOps Builder)
wp: WP-W2-09 — Media filter + full 301 application + cutover prep
date: 2026-05-30
status: READY TO DISPATCH
spec_ref: _aos/work_packages/S002/WP-W2-09/LOD400_spec.md
decision_ref: _COMMUNICATION/team_00/DECISION_W2-09-301-REDIRECT-APPROACH_2026-05-30_v1.md
depends_on: WP-W2-01..W2-08 (ALL COMPLETE)
branch: feature/w2-09-cutover
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-09
---

# Dispatch Mandate — WP-W2-09 (Cutover Prep)

## 1. Scope (final pre-cutover WP — 4 parts)
1. **Regenerate the 301 layer CLEAN** from the 135-decision JSON (per the DECISION, approach B).
2. **Regenerate the in-use media inventory** (post W2-01..08) + ensure every in-use item 200.
3. **Author `scripts/final_pre_cutover_check.sh`** (asserts the whole cutover state).
4. **Cutover checklist** (noindex removal readiness, sitemap, GA4 verify — document; execution itself is M7/out of scope).

## 2. 301 application — approach B (clean regenerate from JSON SSoT)
**Source of truth = `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` ONLY** (135 decisions).
Do NOT carry forward any rule from the old hand-edited `_COMMUNICATION/team_100/tools/htaccess_301_block.txt`.

- **Write a generator** `scripts/gen_htaccess_301_from_decisions.py` that reads the JSON and emits a fresh
  marker-wrapped block to `_COMMUNICATION/team_100/tools/htaccess_301_block.txt`, applying:
  - `decided_status=301` (27) → `Redirect 301 <legacy-path> <target>`. Target = `decided_target_slug`
    → `/<slug>/` (home-rel), or `decided_custom_url`, or — if EMPTY — the **obvious new-site equivalent**
    per the DECISION §Q2 (צור קשר→/contact/, shows/press titles→/shows/, Muzza/books→/muzza/ or /books/<slug>/,
    lessons→/lessons/, repair→/repair/, sound-healing→/sound-healing/). **Never lazy `/`.**
  - `decided_status=410` (1: "פרק א") → `Redirect 410 <legacy-path>`.
  - `manual` (3): `/thankyou`→`Redirect 410`; `/sitemap`→`/sitemap.xml`; `/תקנון`→`/` (interim, flag for Eyal).
  - `keep` (54) + `is_qr_protected` (49, all `/qr/qrN/`) + empty(1) → **NO rule** (stay live 200).
  - Keep the W2-06 `RewriteRule ^Blog/(.+)$ /$1 [R=301,L,NC]` blog catch-all (still valid).
  - **DE-CONFLICT GUARD (mandatory):** skip + log any rule whose source path matches a LIVE Wave2 canonical
    (`/`, `/shop`, `/books*`, `/treatment`, `/lessons`, `/sound-healing`, `/method`, `/contact`, `/press`,
    `/en`, `/qr/*`, `/didgeridoos`, `/bags`, `/stands-storage`, `/stand-floor`, `/repair`, `/blog*`). In
    particular **DROP the legacy `/shop/ → /books/` rule** (it breaks the live W2-05 catalog).
  - De-dup identical sources; assert no rule's target is also a redirected source (no chains/loops).
- **Deploy via the existing SAFE deployer** `_COMMUNICATION/team_100/tools/deploy_htaccess_301.py` (backs up
  live .htaccess, marker-idempotent replace of the existing block, health-check + sample-redirect verify,
  **auto-rollback on failure**). Ensure it REPLACES the old block (same BEGIN/END markers) — not append.
- **Verify live (cache-bust):** the 27 legacy 301s return 301 + correct `Location`; the 49 `/qr/qrN/` stay
  200 (NOT redirected); all live Wave2 canonicals stay 200.

## 3. Media inventory regenerate (B01)
`_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-2026-05-26.json` (in_use_count=7) is STALE (predates W2-02/06).
**Regenerate** after W2-01..08 live: crawl the live new-site for referenced media (theme assets +
wp-content/uploads), UNION with the 158 blog-localized media from W2-06 already in `wp-content/uploads/`.
Keep in-use only; migrate any still-missing in-use media to `wp-content/uploads/` (year/month, relative —
do NOT duplicate W2-06 blog media). Write the regenerated inventory back to `_COMMUNICATION/team_20/`.
**AC-01:** every in-use item → 200 (no 404).

## 4. Deliverable script (B02) — `scripts/final_pre_cutover_check.sh` (NEW, authored here)
Must assert (exit non-zero on ANY failure): (a) every in-use media URL 200; (b) all 27 301 rules resolve to
a LIVE target (301 + Location → 200); (c) all 49 QR URLs 200 (against `docs/project/team-100-preplanning/QR-URL-INVENTORY.csv`);
(d) `validate_aos.sh` 0 FAIL; (e) Lighthouse homepage ≥ 90 (perf/access/SEO/best-practices) on HTTP staging.

## 5. Acceptance Criteria
- AC-01 in-use media (regenerated ∪ W2-06 blog) all 200. AC-02 full 135-map honored (27×301 + 410 active;
  49 QR live not-redirected; keeps live). AC-03 first 20 `decisions[]` each resolve per decision (301→correct
  Location / keep→200). AC-04 49 QR live vs CSV. AC-05 Lighthouse homepage ≥90 on HTTP staging (expired-TLS =
  M7 carry-forward, do NOT block). AC-06 `final_pre_cutover_check.sh` exits 0.

## 6. Cross-engine (IR#1) + commits
Builder team_20 (Claude sub-agent). L-GATE_BUILD team_50 NON-Claude. L-GATE_VALIDATE team_190 Codex.
Commit **surgically by file path — never `git add -A`**. Do NOT push. Report →
`_COMMUNICATION/team_100/W2-09-BUILD-REPORT-2026-05-30.md` (generator + full rule table incl. each empty→target
mapping + dropped/skipped conflicts; media regen counts; check-script output; Lighthouse scores; blockers).

## 7. Out of scope
Cutover execution (M7); server HTTPS/TLS migration (uPress). Rewriting page content.

## 8. Activation prompt (paste into a team_20 builder session on team_00 go)
```
You are team_20 (DevOps builder), AOS eyalamit spoke. Build WP-W2-09 (cutover prep).
Worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-09 (branch feature/w2-09-cutover).
Read FIRST: this mandate + spec (_aos/work_packages/S002/WP-W2-09/LOD400_spec.md) +
DECISION (_COMMUNICATION/team_00/DECISION_W2-09-301-REDIRECT-APPROACH_2026-05-30_v1.md).
APPROACH B: write scripts/gen_htaccess_301_from_decisions.py to REGENERATE
_COMMUNICATION/team_100/tools/htaccess_301_block.txt cleanly from
hub/data/decisions/redirects-301-eyal-final-2026-05-27.json (135 decisions) per the DECISION rules
(27 301 w/ obvious targets not lazy /, 1 410, manual per §Q2, keep+49 QR get NO rule, DE-CONFLICT
guard dropping /shop->/books + any live-Wave2-canonical collision, no loops). Deploy via the SAFE
deployer _COMMUNICATION/team_100/tools/deploy_htaccess_301.py (auto-rollback). Regenerate the in-use
media inventory (crawl live site ∪ W2-06 blog media), ensure all 200. Author
scripts/final_pre_cutover_check.sh (media 200, 27 301 resolve, 49 QR 200, validate 0 FAIL,
Lighthouse home ≥90) exit non-zero on failure. Verify all ACs live (cache-bust). Commit surgically
(NO git add -A). Report to _COMMUNICATION/team_100/. Do NOT push.
```

*team_100 — 2026-05-30 — READY TO DISPATCH.*
