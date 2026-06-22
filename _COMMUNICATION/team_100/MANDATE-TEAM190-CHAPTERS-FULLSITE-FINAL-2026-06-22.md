---
id: MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22
from_team: team_100 (Chief Architect — builder this cycle)
to_team: team_190 (FINAL VALIDATION OWNER — Iron Rule #5: constitutional, cross-engine, immutable)
date: 2026-06-22
type: FINAL_VALIDATION_MANDATE
scope: FULL-SITE — «Chapters» design, all routes
staging: http://eyalamit-co-il-2026.s887.upress.link
repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit-design  (branch chapters-home, b48b35a)
engine_builder: claude-code
engine_validator: NON-CLAUDE (and different from the team_50 engine where possible)
mechanism: file-transport (ADR043 §4/§5)
authorized_by: team_00 (Nimrod)
status: ISSUED  (runs AFTER team_50 PASS)
---

# Mandate — Constitutional final validation, Chapters full-site (team_190)

## Subject
Independent, final, constitutional sign-off (Iron Rule #5) of the full site rebuilt in the «Chapters» design, after team_50's independent pass. **Builder = Claude → you MUST run a different engine; re-run, do not trust builder or team_50 numbers.** Validate against the **live staging site** with **browser-rendered** checks for design — not by reading git.

- **Build/QA detail + builder evidence:** this mandate's sibling `MANDATE-TEAM50-CHAPTERS-FULLSITE-VALIDATE-2026-06-22.md` (full scope, source map, commands, ledger).
- **team_50 report:** `_COMMUNICATION/team_50/VALIDATION-REPORT-CHAPTERS-FULLSITE-2026-06-22.md`.

## Acceptance criteria (all must hold)
1. **Content accuracy (priority)** — every gated page (17, per the §3 source map) at **100% sectionCov + sentenceCov** vs Eyal's `תוכן לאתר 25.5.26` source, **minus only the approved ledger**. Zero invented prose, zero missing source sentences outside the ledger. Independently re-run `scripts/qa/content-diff.mjs` **and** eyeball ≥3 pages against source.
2. **a11y** — axe 0 critical / 0 serious, every route.
3. **Layout (browser/CDP)** — `qa_probe.mjs` 0 horizontal overflow @ 360/390/414/768/1024/1440/1920, every route.
4. **Structure/SEO** — exactly one `<h1>`/page; `dir` correct (rtl; `/en/` ltr); Yoast `@graph`, per-route meta, single `og:image`, canonical present; one-hop 301s (`/muzza/`→`/books/`, `/about/moksha/` `/mokesh/`→`/eyal-amit/mokesh-dahiman/`).
5. **Design fidelity (browser)** — each page rendered + screenshot-compared to its «Chapters» mockup (`/tmp/ea-mock`, handoff zip); no broken images/CSS/RTL; real book covers + Mokesh photos present; `/en/` LTR.
6. **Function** — Contact CF7 form + WhatsApp A/B (`generate_lead`); Blog pagination (page 2 ≠ page 1) + per-post meta/og preserved.

## Approved, non-blocking ledger (see team_50 mandate §7)
(a) WP-06 retired brand «סטודיו נשימה מעגלית» stripped (caps `/eyal-amit/` ≈92/98); (b) FB-corpus testimonial snippets provisional pending Eyal; (c) `⟨…⟩` placeholder copy/imagery on galleries/media/privacy/accessibility/terms/en (pending Eyal); (d) contact/blog not content-gated. These are expected — confirm scope, don't fail on them.

## Deliverable
`_COMMUNICATION/team_190/VERDICT_CHAPTERS-FULLSITE_2026-06-22.md` — **PASS / PASS_WITH_FINDINGS / BLOCK** + evidence, engine used, per-criterion result. Constitutional final.
**Gate to merge `chapters-home`→main and to tell Eyal "ready": team_50 PASS AND team_190 PASS.** Route the verdict back to team_100 / team_00.

*team_100 — 2026-06-22 — constitutional cross-engine final. Live site + browser. Content accuracy first.*
