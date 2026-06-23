---
id: ACTIVATION-PROMPT-TEAM190-CHAPTERS-POSTDEPLOY-FINAL-CLOSURE_2026-06-23
from_team: team_110 (via team_100 routing)
to_team: team_190
date: 2026-06-23
purpose: Activate team_190 session for post-deploy constitutional closure + full mandate gap completion
mechanism: file-transport (ADR043 §4/§5)
repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home)
staging: http://eyalamit-co-il-2026.s887.upress.link
---

# Activation prompt — team_190 — Post-deploy constitutional closure (2026-06-23)

Copy-paste into a **non-Claude** coding agent session (Iron Rule #5 — different engine from builder and ideally from team_50):

```
You are team_190 — FINAL VALIDATION OWNER (Iron Rule #5: constitutional, cross-engine)
on EyalAmit.co.il-2026, working in:
/Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home).

CONTEXT
- team_50 + team_190 ran full-site validation 2026-06-22 → PASS_WITH_FINDINGS (F110-01 missing meta description).
- team_110 fixed F110-01 in wave2-w2-09.php; team_100 deployed to live staging 2026-06-23 and ran a regression suite.
- Your job NOW: independent post-deploy constitutional closure — close F110-01 on LIVE staging AND complete any full-mandate checks that the post-deploy regression did NOT cover.

READ FIRST (source of truth)
1. _COMMUNICATION/team_110/MANDATE-TEAM190-CHAPTERS-POSTDEPLOY-CONSTITUTIONAL-CLOSURE_2026-06-23.md  ← YOUR MANDATE
2. _COMMUNICATION/team_110/GAP-ANALYSIS_CHAPTERS-FULLSITE-MANDATE-COVERAGE_2026-06-23.md
3. _COMMUNICATION/team_100/CLOSEOUT_CHAPTERS-FULLSITE_POSTFIX_DEPLOY_E2E_2026-06-23.md
4. _COMMUNICATION/team_100/evidence/chapters-postdeploy-2026-06-23/  (team_100 regression evidence)
5. _COMMUNICATION/team_190/VERDICT_CHAPTERS-FULLSITE_2026-06-22.md  (prior baseline)
6. Parent mandate: _COMMUNICATION/team_100/MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22.md

HARD RULES
- Validate against LIVE STAGING only: http://eyalamit-co-il-2026.s887.upress.link — use ?nc=<random> cache bust.
- Browser-rendered checks mandatory for design, layout, media (qa_probe CDP + screenshots; eyeball vs mockups).
- Do NOT trust team_100 or team_110 numbers — re-run independently.
- Do NOT edit, commit, merge, or deploy.
- Honor approved ledger (scope.json) — do not fail on placeholder pages, retired brand ledger, provisional testimonials.

PHASE A — BLOCKING: F110-01 live closure
node scripts/qa/seo-head-probe.mjs \
  --out _COMMUNICATION/team_190/evidence/chapters-postdeploy-closure-2026-06-23/seo \
  /books/vekatavta/ /eyal-amit/mokesh-dahiman/ /en/
PASS: metaDescriptionCount == 1 on all three routes.

PHASE B — Full mandate gaps (post-deploy regression was PARTIAL)
The team_100 post-deploy suite covered: full content-diff (17 pages), qa_probe (25×7), axe+h1 on ONLY 5 routes, lighthouse on 7 routes.
It did NOT re-run: full-route axe (26), full-route h1, design/mockup comparison, media eyeball (book covers, Mokesh photos), function probes (CF7, WhatsApp generate_lead, blog pagination), 301 redirects.

You MUST complete per mandate Phase B:
- B1: content-diff + eyeball ≥3 pages vs Eyal source
- B2: axe on ALL 26 mandate routes (0 crit / 0 serious)
- B3: h1+dir on ALL 26 routes
- B4: qa_probe overflow — re-affirm team_100 evidence OR re-run
- B5: SEO 301s + blog pagination + single-post meta
- B6: DESIGN + MEDIA in browser — mockup compare; book covers; Mokesh photos; /en/ LTR; no broken CSS/images
- B7: FUNCTION — contact CF7, WhatsApp generate_lead, blog page 2 ≠ page 1

Write evidence to:
_COMMUNICATION/team_190/evidence/chapters-postdeploy-closure-2026-06-23/

DELIVERABLE
_COMMUNICATION/team_190/VERDICT_CHAPTERS-FULLSITE_POSTDEPLOY_2026-06-23.md
- Verdict: PASS / PASS_WITH_FINDINGS / BLOCK
- F110-01: CLOSED (live) or not
- Per parent mandate criterion §1–§6: PASS/FAIL + evidence paths
- If PASS: SEO axis upgrades PASS_WITH_FINDINGS → PASS; route to team_00 for merge gate

Then notify team_00 that the constitutional post-deploy verdict is ready.
```

---

## Quick reference — what post-deploy already proved (re-affirm vs re-run)

| Already run by team_100 | team_190 action |
|-------------------------|-----------------|
| content-diff 17 pages PASS | Re-run independently (B1) |
| qa_probe 182 checks PASS | Re-affirm or re-run (B4) |
| axe 5 routes | **Must expand to 26 routes (B2)** |
| h1 5 routes | **Must expand to 26 routes (B3)** |
| F110-01 SEO 3 routes | **Independent re-probe (A)** |
| Design / media / function | **Not run — mandatory (B6, B7)** |

---

*team_110 — 2026-06-23 — team_190 activation for post-deploy constitutional closure.*
