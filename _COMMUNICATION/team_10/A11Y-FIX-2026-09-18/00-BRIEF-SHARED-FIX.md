# Shared brief — S006 accessibility FIX wave (P0)

Issuer: team_100 · Builders: team_10 lines · Date: 2026-09-18
Plan: the owner-approved work plan, WS-2. Law: `S006-MILESTONE-CHARTER.md`.

You are BUILDING a fix that a different line found and that team_100 independently
re-measured. You are not auditing. Verification of your fix goes to yet another
line (Iron Rule #1) — do not mark your own work PASS.

## The five verifier-contract clauses (charter §8א) apply to you too

1. Source match — every new user-visible string must exist in the cited source.
2. Unmapped hunk — a code change not mapped to a mandate item → FAIL.
3. Provenance — a changed string without a source comment → FAIL.
4. Empty output = FAIL, never PASS.
5. **A clean automated scan is not a PASS** (team_00, 18.9.26). Report
   "N violations found", never "clean, therefore conformant". Assert the specific
   criterion on the specific page, positively.

## Standing constraints

- **Scope is accessibility only.** Do not touch page copy, do not rewrite Eyal's
  text, do not "improve" wording or layout you were not asked about.
- Any deploy-affecting CSS/JS change requires a `Version:` bump in
  `site/wp-content/themes/ea-eyalamit/style.css` (charter §8). Current: **1.5.37**.
  Bump it once for the wave — coordinate through team_100, do not each bump it.
- **Do not deploy.** team_100 deploys. FTP is IP-allowlisted anyway.
- Never `git add -A` or `git add .` (charter §5.4).
- Every claim about code cites `file:line` (charter §3א-2).

## The theme has two parallel template systems — this matters for every fix

Wave2 (`.ea-topnav*`, `header.php`, `ea-mobile-nav.js`) is largely **dead** on the
live site. Chapters (`.nav`, `section-nav.php`, `ea-chapters.js`) is what visitors
get. Three independent audits have now confirmed that the better-written code
often sits on the dead side. **Before fixing anything, prove which side is live**
by fetching the staging page and finding your selector in the delivered HTML.
Staging: `http://eyalamit-co-il-2026.s887.upress.link` (TLS invalid by design).

## Measurement traps that have produced false passes here

- A `0x0` viewport returns real-looking wrong numbers — assert it is non-zero.
- Lazy images report `naturalWidth = 0`; `NaN` comparisons silently pass.
- `curl` never sees JS-built markup or the rendered cascade.
- A plugin's `?ver=` is not the theme's — match the path, not just the number.
- If your harness's Tab does not move focus off BODY, it is not delivering real
  key events: report COULD NOT MEASURE, never a pass.

## Report

Write `NN-DONE-<your-id>.md` in this directory: what you changed and why, with
`file:line`; the before/after measurement; what you could not measure; and any
place you believe the fix is incomplete.
