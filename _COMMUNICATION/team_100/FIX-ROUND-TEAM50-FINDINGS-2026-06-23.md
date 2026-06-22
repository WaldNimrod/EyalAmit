---
id: FIX-ROUND-TEAM50-FINDINGS-2026-06-23
from_team: team_100 (builder)
to_team: team_190, team_00, team_50
date: 2026-06-23
re: _COMMUNICATION/team_50/VALIDATION-REPORT-CHAPTERS-FULLSITE-2026-06-22.md (PASS_WITH_FINDINGS)
staging: http://eyalamit-co-il-2026.s887.upress.link  (branch chapters-home @ a82ddcb)
status: FINDINGS ADDRESSED — ready for team_190 constitutional final
---

# Fix round — team_50 findings F-01 / F-02

## F-01 (Medium) — retired brand in blog post TITLES → FIXED
- **Found:** «סטודיו נשימה מעגלית» in 2 legacy blog post titles visible on `/blog/` (ids 228, 227). The original WP-06 migration deliberately skipped blog posts.
- **Decision (team_00):** TITLES-only scope (historical article bodies left intact).
- **Fix:** new flag-guarded mu-plugin `ea-w2-06b-blog-title-brand-once.php` (allowlisted in the FTP deploy). Replaces the brand in blog post **titles only** with «המרכז לטיפול בדיג'רידו»; `post_name` untouched → **slugs/permalinks preserved**.
- **Verified live:**
  - `/blog/` archive: **0** hits for «סטודיו נשימה מעגלית» (was 2).
  - id 228 → «מוקש דהימן - מאסטר דיג'רידו - ציור מקורי חדש **במרכז לטיפול בדיג'רידו** (שמן על קנבס)».
  - id 227 → «שליחות חיי - כתבה אודות **המרכז לטיפול בדיג'רידו** פרדס חנה - אייל עמית».
  - Both permalinks still **HTTP 200** (URLs unchanged).
- **Note:** the 12 blog posts that reference the brand in *body* text are left as historical record per the TITLES-only decision (can be revisited with Eyal).

## F-02 (Medium) — podcast link 404 → TRANSIENT, resolved
- Re-verified the flagged URL (`…פודקאסט-…-עמית-2/`) and the non-`-2` variant multiple times with cache-bust: **consistently HTTP 200**. team_50's single 404 was a transient uPress edge-cache miss mid-crawl.
- Minor hygiene (non-blocking): a `-2` duplicate-slug podcast post exists; optional cleanup later (de-dup + 301), not required for the meeting.

## F-03/F-04/F-05 — Info (no action): testimonials provisional (ledger §7-b), staging Lighthouse SEO artifact, GA4-head absent on staging (generate_lead still fires).

## Next
Current staging (a82ddcb) is the state to validate. Proceed to **team_190 constitutional final** per `MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22.md` (re-run on live, browser-rendered, content-accuracy priority). Merge `chapters-home`→main and "ready for Eyal" gated on **team_190 PASS**.

*team_100 — 2026-06-23 — fix round closed; brand removed from blog titles, URLs intact.*
