# Content audit — live site vs Eyal's requirements (WP-W2-14 scope)

**Date:** 2026-06-04 · **By:** team_100 · **Scope:** the WP-W2-14-touched pages (home, method, memorial, galleries, media) — live staging content vs Eyal's source content (`from-eyal/תוכן לאתר 25.5.26/` + `INDEX-CONTENT-2026-05-25.md`) and the site-tree/spec.
**Companion:** open text questions logged to the client hub — `hub/data/materials-needed.json` group **H** (H1–H9), page `materials-intake.html` ("השלמות מאייל").

## Method
Compared each touched page's live rendered content against (a) Eyal's content files in `from-eyal/`, (b) the team content index (`INDEX-CONTENT-2026-05-25.md`), and (c) the LOD400 specs. Findings are accuracy/completeness gaps, not build defects (build gates passed separately).

## Findings

### F1 — Memorial content source is mis-scoped ⛔ (→ H1)
`INDEX-CONTENT-2026-05-25.md` §3 row 16 classifies `מוקש דהימן/ומה היום.docx` as **"חומר רקע — לא עמוד אתר"** — intended to supplement Method §07 ("איך נולדה השיטה") or a section in About, **not** as the memorial page body. Per the 2026-06-04 directive the memorial page (`/mokesh-dahiman` + `/about/moksha`) now renders this docx as its copy. **Needs Eyal/team_00 confirmation** that this is the intended page content, or the page needs dedicated copy and "ומה היום" returns to background/Method.

### F2 — Memorial lacks a biographical opening 🟦 (→ H2)
The page opens with the present-day narrative ("ומה היום") with no "who was Mokesh" intro (life, 1950–2020, the 2000 relationship). The prior generic page *did* carry that factual intro (from an earlier submission). Decide whether to add a biographical lead.

### F3 — Light edits to Eyal's memorial text (transparency) 🟦 (→ H4, H5)
In porting the docx to web copy I: fixed punctuation/typos; wrote the brand as **"Jungle Vibes"** (source: "jungel vibes"); **omitted** the fragment *"קוטלי עומד ומתפורר.."* (ambiguous personal note); and organised the narrative under **three headings I chose** (ומה היום · השנים שאחרי · מי שזכרו ממשיך). All flagged for approval.

### F4 — Memorial dates unconfirmed 🟦 (→ H3)
Hero ring shows "1950 — 2020" (carried from the prior build). The docx implies death = 2020 ("2026, שש שנים לאחר פטירתו"); birth year is unverified. Confirm.

### F5 — Memorial IA duplication 🟧 (→ H6)
Two pages exist: `/eyal-amit/mokesh-dahiman` (id 15, site-tree canonical) and `/about/moksha` (id 181, legacy). All memorial URLs currently resolve to id 181; the primary nav links to `/mokesh-dahiman`. 14-E now renders the elevated memorial on **both**, but the canonical URL + redirect/dedup is an open IA decision.

### F6 — Galleries page = mockup sample content, not real 🟠 (→ H7)
`/galleries` renders gallery titles/descriptions taken from the team_35 **mockup samples**; there is no real Eyal gallery list or photos in `from-eyal/`. Needs the real gallery inventory (names + descriptions + images).

### F7 — Media/testimonials page = mockup sample content 🟠 (→ H8)
`/media` renders testimonials + press items from the **mockup samples**; press links are `#`. Needs the real testimonials list + real press links (or wiring to the central testimonials/press CMS). NB: the same question applies to the **home testimonials rotator** (14-C) — confirm its 5 quotes are real, approved testimonials.

### F8 — Method page content not yet reconciled to `method.md` 🟦 (team_10 action)
`/method` (14-D) was built to the team_35 **mockup** block sequence. Eyal's source is `from-eyal/.../השיטה/method.md` (+ the April `EYAL-CONTENT-PKG-2026-04-10-st-method`). **Action (team_10):** reconcile the live `/method` copy against `method.md` (and confirm whether "ומה היום" feeds §07, per F1) — not yet verified line-by-line in this audit.

### F9 — Standing placeholders (already tracked) ℹ️
Consistent with existing `materials-needed.json`: home "מה זה טיפול" media figure = labelled placeholder (studio photo — A2/B2); קורסים external URL = `#` (→ H9); sound toggle audio (A4); hero video (G1). No regressions; these remain the known Eyal-gaps.

## Recommendation
- **Before the memorial can be content-final:** answer **H1, H2, H4, H6** (source/intent, biographical lead, edits, canonical URL).
- **Before galleries/media can be content-final:** supply **H7, H8** (real content) — until then they ship as honest sample/catalog scaffolding.
- **team_10:** action F8 (reconcile `/method` vs `method.md`).
- All Eyal-facing questions are in the client hub group H, ready to publish (`scripts/ftp_publish_eyal_client_hub.py`) and route via the WhatsApp/Drive intake.
