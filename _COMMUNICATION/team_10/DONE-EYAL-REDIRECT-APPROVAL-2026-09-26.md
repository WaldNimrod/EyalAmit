# DONE — Eyal-facing redirect + slug approval surface, 2026-09-26

Built the decision surface that lets Eyal (non-developer) review and approve the old-site→new-site
redirect plan and the new-site slug decisions, per the owner's brief (Hebrew, quoted in the mandate):
accessible, no codes, minimal, lets Eyal actually decide, lets the team derive the final map from
his answers.

## Deliverable 1 — the document

`_COMMUNICATION/team_90/AUDIT-2026-09-26/EYAL-REDIRECTS-APPROVAL-2026-09-26.html`
(same bytes published to `hub/dist/eyal-redirects-approval.html`)

Self-contained HTML, Hebrew, RTL, visual language matched to
`_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html` (same CSS variables, `.item`
card shape, `.now`/`.need` blocks, `.opt` radio rows, sticky bottom bar).

Structure:
- One short box on the one thing that can't be measured from the sites themselves (Google Search
  Console / an SEO report) — one sentence on why it matters, one plain question.
- One short "numbers" box: 1,255 old-site addresses total (251 content + 1,004 media); 50 of the
  251 are the numbered code pages printed in the physical books and already exist at the same
  address on the new site, so they're not shown as a decision.
- **Ten groups**, each with the four required parts (what it is · count + 2–3 real examples ·
  proposed outcome in plain human terms · radio answer with nothing pre-selected, one option that
  changes the outcome, plus free text): home page (1) · core Hebrew pages (26) · store + book
  pages (14) · blog posts (54) · portfolio pages (25) · blog categories + tags (53) · shows (4) ·
  galleries (6) · leftover archive pages from retired plugins (18) · media files (1,004).
- Two small new-site naming decisions, in the same shape, drawn from
  `SLUG-DECISIONS-2026-09-26.html`: the missing new name for the `/shop/` catalog page (already
  decided to change; only the name is open), and whether to keep new-site addresses in Latin
  letters (recommendation given, with the one-sentence reason). The third slug item in that
  source (how the 38 messy old-blog-slug addresses get derived) is stated as already decided and
  explicitly not asked again, so Eyal isn't asked twice.
- All answers save to `localStorage` in try/catch; one bottom button copies every answer as plain
  text (clipboard API first, `execCommand` fallback, visible textarea as last resort) for pasting
  into email/WhatsApp.

**Titles are real, not invented.** Core-page, store, and blog-post examples came from
`docs/project/team-100-preplanning/CONTENT-SSOT-INVENTORY.csv` (the same 135-item page/post
population behind `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json`). Portfolio
examples came from the prior audit's verified sample (`OLD-SITE-MIGRATION-AUDIT-2026-09-24.md`),
cross-checked live by the 2026-09-26 research. Shows: quoted the two pages literally titled
"מופע לדוגמה" (sample show) and the one page carrying only a date, "11-7" — that literal fact is
itself the example, not a stand-in for a real title.

**No-codes rule — grep proof (client-facing document only):**

```
301        -> 0
regex      -> 0
.php       -> 0
htaccess   -> 0
sitemap    -> 0
slug       -> 0
```

All zero. No developer-facing word appears anywhere in the running Hebrew text; every outcome is
phrased as what a visitor experiences ("מי שמגיע לכתובת הישנה יגיע ל…", "יראה הודעה שהעמוד לא
נמצא"). Radio-group `name` attributes and the localStorage key use plain English identifiers
(`home`, `core-pages`, `shop-name`, …) that never appear in the readable Hebrew content.

**Too thin to present with invented specifics — stated honestly instead of guessed:**
- Blog categories (6) and tags (47) — no real category/tag names were captured in any measurement
  pass; the document says so plainly rather than making names up, and asks for one class decision
  covering all 53.
- Leftover archive pages from retired plugins (18) — same: described by what generated them
  (retired portfolio/testimonials/slide/carousel-category systems, author archives), no titles.
- Shows (4) and galleries (6) — partially thin. Shows: 1 of 4 already migrated, 2 literally named
  "sample show," 1 unidentified (dated only) — stated as such. Galleries: only 3 of the 6 measured
  addresses were manually confirmed to carry an explicit book name plus one generic album; the
  other 2 were not confirmed, and the document says exactly that instead of assuming they're the
  same shape.

## Deliverable 2 — the form card

Added one short card, "אישור מפת ההפניות והכתובות, לקראת מחיקת האתר הישן," as a new final section
(חלק ט) in both:
- `_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html` (source)
- `hub/dist/s007-content-gaps.html` (published copy)

Confirmed byte-identical after the edit. The card states why it matters in two sentences, links to
the live document, and asks one question (has he gone through it), with an "אחר" free-text
fallback — matching the existing card shape exactly. Registered `REDIRECT-MAP-APPROVAL` in the
`CARD_IDS` JS array. **`FORM_SIG` (`wave1-20260925`) was left untouched**, so no in-progress draft
of Eyal's is wiped. No existing card was modified.

Published both files with `python3 scripts/ftp_publish_eyal_client_hub.py` (no `--dry-run` flag on
the real run) — completed clean, 1,307/1,307 files, exit code 0. No 502s encountered; no retries
needed.

## Verification performed

- Document renders RTL; every one of the 12 items (10 groups + 2 slug decisions) has all four
  parts and a `<fieldset>` with no `checked` attribute anywhere in the source (grep-confirmed: the
  only `checked` occurrences are JS `:checked`/`.checked` logic, none on an `<input>` tag).
- Exercised the interaction with a JS injection against the rendered page: selecting a radio and
  typing a note correctly appears in the generated copy-summary text; the copy button's
  `try/catch` fallback chain was exercised too (the sandboxed preview blocks both
  `navigator.clipboard` and `localStorage` under a `data:` URL — expected there, not a defect —
  and the code degraded gracefully to the visible textarea exactly as designed, matching the
  "cannot break the page" requirement).
- Live checks after publish:
  - `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/eyal-redirects-approval.html` → 200,
    byte-identical to the local `hub/dist` copy and to the tracked source under
    `_COMMUNICATION/team_90/AUDIT-2026-09-26/`.
  - `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html` → 200,
    byte-identical to `hub/dist/s007-content-gaps.html` and to the tracked source; contains the
    new card and its link to the document above.
  - Both form copies (`_COMMUNICATION/team_100/S007/…` and `hub/dist/…`) diffed identical.

## Answering the two questions asked directly

- **Ended up with 10 groups** for the old-site side (matching the brief's own list exactly: home,
  core Hebrew pages, store + books, blog posts, portfolio, blog categories + tags, shows,
  galleries, leftover retired-plugin archives, media), plus 2 small new-site naming decisions —
  12 decision items total, not 1,255 rows.
- **Thin spots, stated rather than guessed** (see above): no real names exist anywhere in the repo
  for the 6 blog categories, the 47 tags, or the 18 leftover archive pages; and 2 of the 6 gallery
  addresses and 1 of the 4 show addresses were not confirmed by name in any measurement pass. The
  document says this to Eyal in plain language instead of inventing a title to fill the gap.

## Live links

- Approval document: http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/eyal-redirects-approval.html
- Form (with the new pointer card): http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html
