---
id: ACTIVATION-PROMPTS-CHAPTERS-EXTERNAL-VALIDATION-2026-06-22
from_team: team_100
date: 2026-06-22
purpose: Copy-paste prompts to spin up the EXTERNAL (non-Claude) validation sessions
authorized_by: team_00 (Nimrod)
---

# Activation prompts — external cross-engine validation (Chapters full-site)

**How to use:** the build was done by **Claude**, so per **Iron Rule #1 (builder ≠ validator)** the validation must run on a **different engine**. Open a **non-Claude** coding agent (Cursor / Codex / Copilot-in-IDE / etc.) in the repo and paste **Prompt A** to run team_50. After team_50 PASSes, open another non-Claude session (a different engine than team_50 if available) and paste **Prompt B** for the team_190 constitutional final. The hub mail API is offline, so this is **file-transport**: the sessions read their mandate files and write their reports into `_COMMUNICATION/…`; no auto-notification — you (team_00) shuttle the go-aheads.

Repo: `/Users/nimrod/Documents/Eyal Amit/EyalAmit-design` · branch `chapters-home` · staging `http://eyalamit-co-il-2026.s887.upress.link`

---

## Prompt A — team_50 (Independent QA · NON-Claude)

```
You are team_50 — Independent QA on the EyalAmit.co.il-2026 project, working in the
git worktree /Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home).

IRON RULE #1 — builder ≠ validator: the site was BUILT by Claude. You must run on a
DIFFERENT engine (you are NOT Claude). Do not trust the builder's numbers — reproduce
every check yourself.

1. Read your full mandate and follow it exactly:
   _COMMUNICATION/team_100/MANDATE-TEAM50-CHAPTERS-FULLSITE-VALIDATE-2026-06-22.md
2. Validate against the LIVE staging site (http://eyalamit-co-il-2026.s887.upress.link),
   NOT by reading git. Bust edge cache with ?nc=<random> when re-checking.
3. TOP PRIORITY = CONTENT ACCURACY: every Hebrew word on every page must be VERBATIM from
   Eyal's source in docs/.../תוכן לאתר 25.5.26/ (map in the mandate §3). Re-run
   `node scripts/qa/content-diff.mjs --out _COMMUNICATION/team_50/evidence/content-2026-06-22`
   AND eyeball ≥3 pages (live vs source .md) to confirm no paraphrase/invention. Bar: 100%
   per page minus the approved ledger (mandate §7).
4. DESIGN ACCURACY must be checked IN A BROWSER (not curl/git): use the CDP runner
   `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --config <cfg> --shots`
   for overflow + screenshots @ 360/390/414/768/1024/1440/1920, and compare each page to its
   «Chapters» mockup (/tmp/ea-mock/*.html + the handoff zip eyal-amit/project/*.html). Flag any
   broken layout/CSS/RTL/images. Also run axe (scripts/qa/http-qa-axe.cjs) = 0 critical/serious,
   and Lighthouse (full Chrome) on key routes.
5. Honor the approved deviation ledger (mandate §7) — do NOT fail on those.
6. Write your verdict + evidence to
   _COMMUNICATION/team_50/VALIDATION-REPORT-CHAPTERS-FULLSITE-2026-06-22.md
   (verdict box: PASS / PASS_WITH_FINDINGS / FAIL; per-page content table; QA results;
   design screenshots + mockup-comparison notes). Report only — do NOT edit/fix/commit/deploy.
   Then notify team_00 that the report is ready for the team_190 final.
```

---

## Prompt B — team_190 (Constitutional final · NON-Claude, after team_50 PASS)

```
You are team_190 — the FINAL VALIDATION OWNER (Iron Rule #5: constitutional, cross-engine,
immutable) on EyalAmit.co.il-2026, in /Users/nimrod/Documents/Eyal Amit/EyalAmit-design
(branch chapters-home).

The site was BUILT by Claude and independently QA'd by team_50. You must run on a DIFFERENT
engine (NOT Claude; ideally different from team_50 too). Re-run; trust no prior numbers.

1. Read your mandate and the team_50 report:
   _COMMUNICATION/team_100/MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22.md
   _COMMUNICATION/team_50/VALIDATION-REPORT-CHAPTERS-FULLSITE-2026-06-22.md
2. Validate against the LIVE staging site with BROWSER-rendered checks (qa_probe CDP +
   screenshots; Lighthouse full Chrome). Confirm the acceptance criteria in your mandate:
   content accuracy (priority) = 100% vs Eyal's source minus the approved ledger; axe 0
   crit/serious; 0 overflow @ 7 breakpoints; 1 h1/page + correct dir; SEO graph/meta/og/
   canonical + one-hop 301s; design fidelity to the «Chapters» mockups; Contact + Blog
   function.
3. Independently re-run content-diff AND eyeball ≥3 pages against source. Honor the approved
   ledger (mandate). Do NOT edit/fix/commit/deploy.
4. Write the constitutional verdict to
   _COMMUNICATION/team_190/VERDICT_CHAPTERS-FULLSITE_2026-06-22.md
   (PASS / PASS_WITH_FINDINGS / BLOCK + per-criterion evidence + engine used). Route it back
   to team_100 / team_00. Merge to main and "ready for Eyal" are gated on team_50 PASS AND
   team_190 PASS.
```

---

## Sequencing & notes for team_00
1. Run **Prompt A** (team_50) first → it writes its report.
2. On team_50 PASS, run **Prompt B** (team_190) → constitutional verdict.
3. **Both PASS** → builder (team_100/Claude) may, on your "מאשר/פוש", merge `chapters-home`→main and you can show Eyal "ready". Any FAIL → findings come back to team_100 as the **fix round** before the meeting.
4. Engine choice: any non-Claude coding agent with shell + browser access (Cursor, Codex CLI, etc.). Node 18+ and a full `Google Chrome.app` are required for the browser checks (already present on this machine). The QA scripts need `puppeteer-core` + `axe-core` in `scripts/qa/` (`npm install` there if absent).
