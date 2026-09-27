# The verify-and-fix protocol

**Standing procedure. Ordered by team_00 on 2026-09-27:** «תוכנית מסודרת שתבטיח מעגל בדיקה
ותיקון בלי צורך שלי להגדיר את זה שוב ושוב.»

**A mandate does not restate closing conditions in prose. It links here and adds only what is
unique to it.** Prose closing conditions are what produced the defect below.

---

## Why this file exists

On 2026-09-27 a lane reduced nine invocation paths to one. It reported success, proved the
rendered markup byte-identical on five pages, and ran a full-population regression that came back
clean. **All of that was true, and the change had still stripped the sticky-reveal footer from 53
pages** — every blog post and the blog archive.

Nothing lied. The five pages it chose were all fine. Its population pass counted navs and footers
**and nothing else**, because that is what its mandate's hand-written closing conditions listed.
**One CSS class was never named, so it was never counted.**

That is the failure this protocol removes: **an invariant that lives in prose gets forgotten. An
invariant that lives in the gate cannot be.**

---

## The four rules

**1 · A builder's report is a claim.** A card closes when team_90 runs the gate, not when a report
says the work is done. This is Iron Rule #1 and it is not a formality — the report above was
honest, thorough, and wrong.

**2 · Census, not sample.** Proof on five pages is proof about five pages. **If a claim is about
the site, the measurement is over every live URL**, enumerated from the REST API at measurement
time — never from a stored list, which goes stale in silence.

**3 · Compare in both directions.** "After matches before" is only true when the group that was
**not** supposed to change was also counted. The 53 pages were never in either column.

**4 · Run the gate before the change, not only after.** A "before" you did not capture does not
exist, and without it a drift cannot be told from a pre-existing condition.

---

## The gate

    python3 scripts/qa/ea_regression_gate.py

It takes no page list and no invariant list. It enumerates the published population itself and
checks **every** invariant **every** time. Exit 0 passed · 1 drifted · 2 could not measure.

**Adding a check to that script is the only way to make an invariant permanent.** If a mandate
needs an invariant the gate does not yet hold, the mandate adds it to the gate — it does not
write it into its own closing conditions.

**What it holds today:** population shape (objects / 200s / redirects) · exactly one primary nav
per page · exactly one footer per page · the footer reveal class, by count and by exact URL list ·
zero PHP error strings · every page linking all three legal documents · images carrying no alt
attribute at all.

**The baseline** lives beside it in `ea_regression_gate_baseline.json`. Changing a baseline value
requires `--reason`, and the script refuses without one. **That is the whole point:** an intended
change is recorded with its justification, so it can never be mistaken for a regression that was
quietly accepted.

---

## The loop

1. **Run the gate. It must pass before you start.** If it already fails, stop and report — you are
   not the cause, and working on top of a failing gate hides who is.
2. Do the work.
3. Deploy. **Commit first: the deploy ships the working tree and refuses a dirty `site/`. That
   refusal is a safety interlock; `--allow-dirty` is forbidden.** A dirty deploy leaves the live
   site with no commit describing what is on it, and that has already happened once.
4. **Run the gate again.**
5. **A failure goes back to the lane with the measurement**, not to the reviewer's editor. The
   reviewer who fixes the builder's work becomes the builder, and then nobody is checking.
6. **Only then** does the card close.

---

## Before you call anything a finding

Read the fifteen measurement traps in
`_COMMUNICATION/team_90/AUDIT-2026-09-24/MASTER-PRE-MEETING-AUDIT-2026-09-24.md`. Every one of
them was paid for. The ones that recur most:

- **Sampling a rounded element inside its bounding box** drags in blurred edge pixels. Same page,
  same text: 4.17 with the rectangular clip, 9.00 with the radius inset.
- **Anti-aliased glyph edges** make any text measurable as failing. Filter to solid-colour pixels.
- **A file named DONE is not a site state.** Fetch the page.
- **grep finds a file; only a fetch finds a page.** And `get_template_part` splits the partial name
  into two arguments, so grepping the full filename misses every call site.
- **A predicate that asks a different question than the router asks will drift from it.** Call the
  router's own predicate. The 53-page regression was exactly this: a test against page-template
  meta, on posts, which never carry it.
- **A reveal animation must settle** before the element is read, or the measurement invents a
  defect.

---

## Standing constraints, for pasting into any mandate

- Never `git add -A`. Commit explicit paths.
- Never open `local/`. Never edit `_aos/` — it is a read-only snapshot.
- Do not run `scripts/s007_render_work_ssot.py`; it is stale and would overwrite Eyal's form and
  the board. Do not open `scripts/save_legacy_wp_app_password.py`.
- Typography and colour tokens are locked by `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md`.
  Change a token, never a declaration, and update the canon in the same commit.
- **Content law:** only what exists, what came from Eyal, or what came from Nimrod. No invented
  copy, not even as an example.
- **Eyal's form signature `wave1-20260925` is frozen.** Changing it erases his saved draft, which
  exists nowhere else. Adding a card is additive only.
- Be gentle with staging: at most 3 concurrent requests, retry on 502, and **never record a 502 as
  a defect without retrying.**
- The staging certificate is invalid **by design** and is never a finding.
- One working copy. Two lanes in one file have already overwritten each other. Split by file.
