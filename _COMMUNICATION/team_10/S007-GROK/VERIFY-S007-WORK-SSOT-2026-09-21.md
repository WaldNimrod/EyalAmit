# VERIFY — S007 WORK SSOT (Team 10) — 2026-09-21

GeneratedAt (UTC): 2026-09-21T15:27:43Z

Onboard: **Completed** (read file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_communication/team_10/onboard_team10.md in full)

Artifacts:
- SSOT JSON: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json
- GALLERY: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html
- FORM (tracked): file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html
- FORM (live hub): http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html
- SOURCE-C: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-21--content-gaps--from-eyal/SOURCE-C-2026-09-21T1001Z--from-eyal.json

ssotSha12 (sha256-12 of SSOT JSON): **811eba9919a5**

## Checks

| id | what | PASS/FAIL | evidence |
|---|---|---|---|
| CHK-SSOT-01 | SSOT JSON has schema + isWorkSsot | PASS | schema=s007-work-ssot-v1 · isWorkSsot=True · file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json |
| CHK-SSOT-02 | SSOT vocab is closed set | PASS | no violations |
| CHK-SSOT-03 | No closed item missing live.check | PASS | none |
| CHK-SOURCE-C-01 | SOURCE-C sha12 matches mandate (19d11db562f7) | PASS | sha12=19d11db562f7 · file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-21--content-gaps--from-eyal/SOURCE-C-2026-09-21T1001Z--from-eyal.json |
| CHK-ID-01 | EI-A4-E2E remains open | PASS | EI-A4-E2E status=open |
| CHK-ID-02 | T-NAV-HOLD is waiting on nimrod | PASS | status=waiting waitingOn=nimrod |
| CHK-ATTACK-01 | ATTACK remnants present + open/waiting (DA-P1-01 closed) | PASS | DA-WA-01:open/nimrod; DA-NAV-01:open/nimrod; DA-NAV-02:open/nimrod; DA-NAV-03:open/nimrod; DA-LOGO-01:open/nimrod; DA-P2-A2:open/nimrod; DA-P2-A3:open/nimrod; DA-P2-A4:open/nimrod; DA-P2-05:open/nimrod; DA-P2-06:open/nimrod; DA-P1-01:closed |
| CHK-HTML-01 | FORM html ssotSha12 matches sha256-12(JSON) | PASS | FORM ssotSha12=811eba9919a5 · expected=811eba9919a5 · file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html |
| CHK-HTML-02 | GALLERY html ssotSha12 matches sha256-12(JSON) | PASS | GALLERY ssotSha12=811eba9919a5 · expected=811eba9919a5 · file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html |
| CHK-HTML-03 | No SITE_STATUS object/map in FORM+GALLERY | PASS | FORM has SITE_STATUS=False · GALLERY has SITE_STATUS=False |
| CHK-FORM-01 | FORM has 129 data-id; matches SSOT surface eyal_form|both | PASS | data-id count=129 unique=129 · ssot eyal_form|both=129 |
| CHK-LIVE-01 | Live hub form reachable and matches ssotSha12 + 129 ids | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html → HTTP 200 · ssotSha12=811eba9919a5 · data-id unique=129 |
| LIVE-A4 | Live GET re-measurement (no redirects, browser UA) for A4 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/thank-you/ → HTTP 200 |
| LIVE-B1 | Live GET re-measurement (no redirects, browser UA) for B1 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/ → HTTP 200 |
| LIVE-C2 | Live GET re-measurement (no redirects, browser UA) for C2 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/ → HTTP 200 |
| LIVE-D1 | Live GET re-measurement (no redirects, browser UA) for D1 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/didgeridoos/ → HTTP 200 |
| LIVE-D2 | Live GET re-measurement (no redirects, browser UA) for D2 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/ → HTTP 200 |
| LIVE-D3 | Live GET re-measurement (no redirects, browser UA) for D3 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/faq/ → HTTP 200 |
| LIVE-E6 | Live GET re-measurement (no redirects, browser UA) for E6 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/thank-you/ → HTTP 200 |
| LIVE-F3 | Live GET re-measurement (no redirects, browser UA) for F3 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/ → HTTP 200 |
| LIVE-L1 | Live GET re-measurement (no redirects, browser UA) for L1 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/accessibility/ → HTTP 200 |
| LIVE-L2 | Live GET re-measurement (no redirects, browser UA) for L2 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/privacy/ → HTTP 200 |
| LIVE-L3 | Live GET re-measurement (no redirects, browser UA) for L3 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/terms/ → HTTP 200 |
| LIVE-P016 | Live GET re-measurement (no redirects, browser UA) for P016 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%9e%d7%94%d7%a0%d7%99%d7%99%d7%a8-%d7%a2%d7%9d-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa/ → HTTP 301 · Location=http://eyalamit-co-il-2026.s887.upress.link/blog/ |
| LIVE-P045 | Live GET re-measurement (no redirects, browser UA) for P045 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/41-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%97%d7%90%d7%a8%d7%98%d7%94-%d7%91%d7%90%d7%a8%d7%98%d7%94/ → HTTP 301 · Location=http://eyalamit-co-il-2026.s887.upress.link/blog/ |
| LIVE-DA-P1-01 | Live GET re-measurement (no redirects, browser UA) for DA-P1-01 | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/ → HTTP 200 |
| LIVE-WA-SOUND | Live GET re-measurement (no redirects, browser UA) for WA-SOUND | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/ → HTTP 200 |
| LIVE-WA-A | Live GET re-measurement (no redirects, browser UA) for WA-A | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/ → HTTP 200 |
| LIVE-WA-B | Live GET re-measurement (no redirects, browser UA) for WA-B | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/ → HTTP 200 |
| LIVE-M13-ONE-NAV | Live GET re-measurement (no redirects, browser UA) for M13-ONE-NAV | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/ → HTTP 200 |
| LIVE-TYPO-CANON | Live GET re-measurement (no redirects, browser UA) for TYPO-CANON | PASS | GET http://eyalamit-co-il-2026.s887.upress.link/ → HTTP 200 |

## ssotSha12 cross-surface verdict

ssotSha12 match JSON↔GALLERY↔FORM(tracked)↔FORM(live): **YES**

## One-line verdict

**PASS** — 31 PASS / 0 FAIL

