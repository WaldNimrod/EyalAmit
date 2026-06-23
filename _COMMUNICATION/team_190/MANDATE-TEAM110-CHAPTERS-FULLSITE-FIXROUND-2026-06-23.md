# MANDATE — team_190 → team_110 · Chapters FULL-SITE fix round (post dual validation findings)

**Issued:** 2026-06-23 · file-transport (ADR043 §4/§5).  
**From:** team_190 (FINAL VALIDATION OWNER — Iron Rule #5) · **To:** team_110 (Remediation / Fix implementer).  
**Repo/worktree:** `/Users/nimrod/Documents/Eyal Amit/EyalAmit-design` · branch `chapters-home`  
**Staging:** `http://eyalamit-co-il-2026.s887.upress.link`

## 0) Purpose
Run a **full fix round** for **all known findings** from:
- team_50 report: `_COMMUNICATION/team_50/VALIDATION-REPORT-CHAPTERS-FULLSITE-2026-06-22.md`
- team_190 verdict: `_COMMUNICATION/team_190/VERDICT_CHAPTERS-FULLSITE_2026-06-22.md`

After your fixes + evidence, you will submit back to team_190 for a **focused re-validation** (not a full re-run unless needed). team_190 will then prepare a short **summary report to team_100**.

## 1) Constraints (constitutional)
- **Do change/fix code/content as required** (this is remediation).
- **Do NOT merge to `main`**.
- **Do NOT deploy**.
- **Push / merge only on team_00 explicit “מאשר/פוש”.**
- **Content accuracy remains the top constraint:** do not introduce new prose on content-gated pages. Head/meta changes are allowed; body copy must remain source-verbatim minus the approved ledger.

## 2) Approved ledger (do not “fix” these)
See `_COMMUNICATION/team_100/MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22.md` ledger §7:
- retired brand removed from specific sentence/title on `/method/` + `/eyal-amit/`
- FB-corpus testimonial snippets provisional
- placeholder `⟨…⟩` pages (galleries/media/legal/en) pending Eyal
- contact/blog are not content-gated (validate function + SEO)

## 3) Findings to resolve (ALL)

### F110-01 (from team_190) — Missing description meta on specific routes (MEDIUM)
Evidence: team_190 `evidence/chapters-fullsite-2026-06-22/seo/seo_head_checks_v3.json`
- `/books/vekatavta/` → missing `meta name="description"` and missing any description meta
- `/eyal-amit/mokesh-dahiman/` → missing `meta name="description"` and missing any description meta
- `/en/` → missing `meta name="description"` (has `og:description` only)

**Fix requirement:** ensure each of the above routes has at minimum:
- **canonical** (already present) — do not break
- exactly **one** `og:image` (already present) — do not break
- **Yoast @graph** (already present) — do not break
- **meta description present** (`<meta name="description" ...>`) and (preferred) `og:description`

### F110-02 (from team_50) — Retired brand string appears on `/blog/` archive (MEDIUM)
Evidence: team_50 report §6 finding F-01.
The retired brand term `סטודיו נשימה מעגלית` must **not appear** on the site. Fix the offending legacy post title/excerpt rendering (or exclude it from the archive, or adjust title) so that `/blog/` (and `/blog/page/2/`) are clean.

### F110-03 (from team_50) — Broken blog link / 404 (MEDIUM)
Evidence: team_50 report §6 finding F-02.
`/blog/` archive must not link to routes that return 404. Specifically the reported podcast slug `…עמית-2/` must be **200** or a **301** to the correct post (one-hop preferred).

## 4) Validation you must re-run (and attach evidence)
After implementing fixes, re-run and store outputs under `_COMMUNICATION/team_110/evidence/chapters-fullsite-fixround-2026-06-23/`:

### 4.1 Content accuracy regression guard (required)
Run:
`node scripts/qa/content-diff.mjs --out _COMMUNICATION/team_110/evidence/chapters-fullsite-fixround-2026-06-23/content`

**Bar:** content-gated pages remain **ledger-adjusted PASS** (no new missing/invented outside ledger).

### 4.2 Browser QA (required on affected routes)
- **axe** (0 critical/serious) at minimum on: `/blog/`, `/blog/page/2/`, `/books/vekatavta/`, `/eyal-amit/mokesh-dahiman/`, `/en/`
  - `node scripts/qa/http-qa-axe.cjs --base http://eyalamit-co-il-2026.s887.upress.link <routes…>`
- **h1 + dir** at minimum on the same routes (and keep 1 `<h1>`/page):
  - `node scripts/qa/h1-rtl-http-probe.cjs <routes…>`
- **qa_probe (CDP)** overflow + forbidden-term scan on:
  - `/blog/`, `/blog/page/2/` (and optionally all 26 mandate routes if you touched shared templates)
  - Use the canonical runner:
    - `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base <staging> --paths <...> --absent "סטודיו נשימה מעגלית,TBD,LOREM,CDIP" --shots`

### 4.3 SEO head + redirect/link checks (required)
Provide evidence that:
- The 3 routes in **F110-01** now have `meta name="description"` (and ideally `og:description`)
- `/blog/` has no retired brand string in rendered HTML
- The previously broken blog permalink(s) are no longer 404 (200 or 301)

You may use `curl` (with `?nc=` cache bust) and/or a small node probe; but the deliverable must include a machine-checkable artifact (JSON or captured HTML snippets) under the evidence folder.

## 5) Deliverables (write-only)
1. `_COMMUNICATION/team_110/FIX-REPORT-CHAPTERS-FULLSITE-FIXROUND-2026-06-23.md` containing:
   - what changed (per finding)
   - what was verified (with links to evidence files/paths)
   - any remaining risk/notes
2. Evidence folder: `_COMMUNICATION/team_110/evidence/chapters-fullsite-fixround-2026-06-23/` (subfolders as needed)

## 6) Hand-back to team_190 (focus re-check request)
When deliverables are written, add a short “ready for focused re-check” note at the top of your fix report, pointing team_190 to:
- the exact files changed
- the exact evidence artifacts
- which criteria were impacted (SEO head/blog archive)

