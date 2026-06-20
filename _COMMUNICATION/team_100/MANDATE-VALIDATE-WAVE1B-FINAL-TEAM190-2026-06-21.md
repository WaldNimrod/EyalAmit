---
id: MANDATE-VALIDATE-WAVE1B-FINAL-TEAM190
title: Final-gate mandate — Wave-1b SEO/GEO (team_190, after team_50 v2 PASS)
date: 2026-06-21
from_team: team_100 (Chief Architect / builder — claude-code)
to_team: team_190 (final validation — constitutional, cross-engine, IR#5)
wp: S004-P001-WP000 — Wave-1b additive SEO/GEO batch
gate: L-GATE_VALIDATE (final)
branch: wave1b-seo-geo (== mokesh-content @ 91e2765 + the uncommitted meta fix)
staging: http://eyalamit-co-il-2026.s887.upress.link
predecessor_v2: _COMMUNICATION/team_50/VERDICT_WP-S004-P001-WP000-WAVE1B_v2.md (PASS_WITH_FINDINGS)
selfqa: _COMMUNICATION/team_100/evidence/wave1b-selfqa-2026-06-21/SELFQA-SUMMARY.md
rev2_mandate: _COMMUNICATION/team_100/MANDATE-VALIDATE-WAVE1B-REV2-2026-06-21.md
delivery: file-based (hub DB offline — ADR043 §4/§5 fallback)
---

# §0 Why this mandate

team_50 v2 returned **PASS_WITH_FINDINGS** on Wave-1b: the blocker `B-W1B-META-01`
is resolved (`/blog/` + `/blog/page/2/` each emit exactly one meta description; no
route duplicates). Regression all green (meta 13/13, content-diff 17/17, axe 13/13,
overflow 52/52, redirects 5/5, contact NAP, LCP, no PHP notices). One non-blocking
finding: live theme version drift (see §2). This mandate requests the **final,
constitutional cross-engine validation** (IR#5) before merge.

# §1 Scope = Wave-1b ONLY

The Wave-1b WP comprises (most already committed on `wave1b-seo-geo`):
`/shop/cart|checkout|my-account → /shop/` 301; per-route meta on the 9 bare routes
**+ the `/blog/` archive (the fix)**; contact-page NAP/hours; LCP `fetchpriority`
on `/eyal-amit/`. Validate these gates against LIVE staging, independently (IR#1):

1. **Meta (re-confirm — surface is being actively changed by a concurrent session, see §2):**
   every route emits exactly ONE `<meta name="description">`, none emits two —
   `/`, `/blog/`, `/blog/page/2/`, `/eyal-amit/`, `/shop/`, `/didgeridoos/`, `/bags/`,
   `/stands-storage/`, `/stand-floor/`, `/repair/`, `/books/`, `/faq/`, `/contact/`.
2. content-diff — no regression.
3. axe — 0 serious/critical.
4. overflow @360/390/414/768 — 0.
5. redirects — `/shop/*`→301→`/shop/`; `/Blog/<slug>`→`/blog/<slug>`; `/מוזה-הוצאה-לאור/`→`/books/`.
6. contact NAP — visible name+address+`tel:+972524822842`+hours; ProfessionalService JSON-LD matches.
7. LCP — `/eyal-amit/` portrait `fetchpriority="high"` + width/height.
8. regression — no PHP notices/fatals.

# §2 IMPORTANT — concurrent-workstream context (read before validating)

The staging working tree is **shared** and a concurrent session (team_110 /
`mokesh-content`, building the **w2-14e catalog**) is actively editing it. As a
result:
- Live theme version is **1.4.16** (not 1.4.15 as the rev2 mandate stated) — the
  concurrent session bumped `style.css` 1.4.15→1.4.16 and redeployed *after*
  team_100's deploy. **The meta fix is server-side PHP in `inc/wave2-w2-09.php` and
  is unaffected by the version string** — verified live: `/blog/` still emits one
  meta description. team_50 recorded the version drift as non-blocking.
- Live staging ALSO carries the concurrent session's uncommitted catalog work
  (`inc/wave2-w2-14e.php`, `assets/css/w2-14e-catalog.css`, `inc/wave2-w2-02.php`).
  **This is NOT part of Wave-1b** and is validated separately by its own workstream.
  Validate ONLY the §1 Wave-1b gates; if you observe catalog/press changes, they are
  out of Wave-1b scope — do not fail Wave-1b on them, but you MAY note them.

Because the surface is changing under concurrent edits, **re-confirm the meta gate
at your validation time** rather than relying on team_50's earlier snapshot.

# §3 Known non-blockers (do NOT fail Wave-1b on these)

- **Single blog posts emit 0 meta description** — pre-existing; theme covers Pages +
  the `/blog/` archive only; carried to WP-04. Not a Wave-1b item.
- **Theme version drift 1.4.15→1.4.16** — concurrent-session cache-bust; PHP fix unaffected (§2).

# §4 Verdict + merge gate

- team_190 files the Wave-1b final verdict in `_COMMUNICATION/team_190/`
  (`VERDICT_WP-S004-P001-WP000-WAVE1B_FINAL_v1.md`), on a **non-Claude engine
  different from the builder** (e.g. Codex / GPT in Cursor — as the Wave-1 final used).
- On **dual-PASS** (team_50 v2 + team_190 final), team_100 will **scope-commit ONLY
  `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php`** onto `wave1b-seo-geo`
  (the meta fix is self-contained PHP; no version bump required for it to work) and
  merge `wave1b-seo-geo` → `main` — **only on Nimrod's explicit "מאשר"** (separate
  "פוש" for origin). The concurrent catalog work + the `style.css` 1.4.16 bump stay
  with the `mokesh-content` workstream's own commit — they are NOT swept into the
  Wave-1b merge. No "ready" to Eyal before dual-PASS (team_00 owns Eyal comms).

# §5 team_190 activation prompt (copy-paste; non-Claude engine, ≠ builder)

> You are **team_190**, the final-gate validator for EyalAmit.co.il-2026
> (`/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`) — constitutional,
> cross-engine, IR#5. Run on a **non-Claude engine** different from the builder
> (e.g. Codex / GPT in Cursor). team_50 v2 returned PASS_WITH_FINDINGS on Wave-1b
> (blocker `B-W1B-META-01` resolved). Read
> `_COMMUNICATION/team_100/MANDATE-VALIDATE-WAVE1B-FINAL-TEAM190-2026-06-21.md`
> (note §2 — the staging tree is shared with a concurrent team_110 `mokesh-content`
> catalog workstream; validate ONLY the Wave-1b §1 gates and re-confirm the meta
> gate live). Run gates 1–8 independently against LIVE staging
> `http://eyalamit-co-il-2026.s887.upress.link`; do NOT trust team_100 or team_50
> self-reports. Treat the §3 items (single-post meta, version drift) as known
> non-blockers. File `VERDICT_WP-S004-P001-WP000-WAVE1B_FINAL_v1.md` in
> `_COMMUNICATION/team_190/` with PASS/FAIL + evidence. On PASS, Wave-1b is
> dual-PASS and clears for merge on Nimrod's explicit approval.
