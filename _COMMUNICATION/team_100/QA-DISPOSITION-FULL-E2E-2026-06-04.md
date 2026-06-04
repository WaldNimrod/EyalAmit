# team_100 disposition — team_50 full-site E2E QA (2026-06-04)

**Source:** `_COMMUNICATION/team_50/QA-REPORT-FULL-E2E-SITE-2026-06-04.md` — Verdict **PASS_WITH_FINDINGS**, 0 P0, 6 P1.
**Outcome:** WP-W2-14 build layer is technically clean (0 P0). P1s dispositioned below.

## Code-defect P1s — actioned this session
| Finding | Disposition |
|---|---|
| **Blog singles 404** (`…-2/` archive slug) | **FALSE POSITIVE — no fix.** Transient staging timeout (recurring this session). Verified **all 54 published posts → HTTP 200** (REST enumerate + retry; 0 persistent non-200), incl. the `-2/` podcast slug and the suspect Mokesh-painting post. |
| **EN footer shows Hebrew** | **FIXED + DEPLOYED.** Root cause: `ea_eyalamit_render_footer_legal_nav()` (functions.php, `generate_before_footer`) renders the `ea_footer_legal` WP menu (Hebrew page titles) on every page incl. `/en`, below the English `.ea-footer`. Guarded with `is_page('en')`. Verified: `/en` legal-nav=0 / 0 Hebrew; `/` + `/treatment` legal-nav intact. |

## Content / out-of-scope P1s — routed, NOT fixed here
| Finding | Owner | Status |
|---|---|---|
| F1–F5 Memorial (source/intent, dates, edits, IA) | team_00/Eyal | Client-hub group **H1–H6** (published) — awaiting answer |
| F8 Method copy vs `method.md` | team_10 + Eyal | **H8**; team_10 to reconcile `/method` to `method.md` |
| F6/F7 Galleries/Media = mockup samples; press `#` | team_00/Eyal | **H6/H7** — awaiting real content |
| Drawer "קורסים" → `#` | Eyal | **H9** — pending external URL (documented placeholder) |
| Contact form: empty submit, no validation | Eyal/admin | **C1** — `form_id=0`; create CF7 form in wp-admin |

## Recommendation
- **WP-W2-14 build → route per-WP L-GATE_VALIDATE** (team_50 → team_190): the build is technically clean; ship B/C/D/E with the documented content-pending notes (memorial/galleries/media stay sample/scaffold until Eyal answers H1–H8).
- **Targeted retest:** only `/en` footer changed → already re-verified clean here; no full retest needed. Blog 404 needs no fix.
- team_50's full-E2E coverage + F1–F9 confirmation stands as the independent QA evidence for this round.

*team_100 — 2026-06-04.*
