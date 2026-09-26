# Mandate — the content-type canon, as a PAIR of linked documents — 2026-09-26

**Dictated by team_00 (Nimrod) on 2026-09-26.** His words:

> «אנחנו מייצרים שני מסמכים המקושרים ביניהם ועובדים תמיד בצמד — אחד ארטיפקט המיועד לי ולאייל,
> ואחד md המיועד לסשנים ומכיל אינדקס ואת כל ההגדרות המדוייקות כולל מחלקות css וכו.»

**Do not start this until `TYPE-MAP-2026-09-26.md` has landed.** The pair is DERIVED from that map;
it is not a second research pass.

---

## The pair, and the rule that binds it

**Two documents, always edited together. Changing one without the other is a defect**, the same way
a token change without its canon entry is a defect in this project.

**Each carries a link to the other at the top, and a line stating the pairing rule**, so whoever
opens either one learns it immediately.

### Document A — the artifact. For Nimrod and Eyal.

Tracked source at `_COMMUNICATION/team_100/EYAL-WORKSPACE/ea-content-types.html`, published live
via `hub/dist/ea-content-types.html`. **The tracked copy is the one in the workspace folder** —
see "Where the pair lives" below, which supersedes any other path in this file.

- Hebrew, right-to-left, opened in a browser by a non-developer.
- **Per type: a designed, rendered example with sample content** — what the row actually looks like —
  **and the definition paragraph in the owner's own register**, at the precision of his CTA
  definition: «הטקסט תמיד בלוק בשליש המרכזי, מיושר לימין. ה-cta שלנו בנוי משלושה שלישים…»
- **No class names, no file paths, no code.** Same rule as Eyal's other documents: if a token means
  something only to a developer, it does not appear here.
- **Sample content must be real or obviously generic.** Either text that already exists on the site,
  or plainly neutral placeholder. **Never invented copy that could be mistaken for Eyal's voice.**
- It is a working tool, not a report. The owner's intent: Eyal opens it and asks for
  **«שורה מטיפוס A עם תוכן B בעמוד C במיקום X»**. The document must make the names of the types
  and what each one accepts obvious enough for him to say that sentence unaided.

### Document B — the definitions. For sessions.

`_COMMUNICATION/team_100/EYAL-WORKSPACE/CONTENT-TYPES-CANON.md`, English. It mirrors the
typography canon in role, but it lives in the workspace folder because it is part of the pack.

- **An index first** — every type, one line each, linking down to its entry.
- **Per type, everything a session needs to render one correctly without reading the theme:** the
  renderer with file:line · its CSS with file:line · **the exact CSS classes and modifier classes** ·
  **the exact inputs it accepts**, read from the renderer's own parameter handling · the layout rules
  · which pages use it · its declared variants · and **its known exceptions**.
- **Exceptions are recorded, not hidden.** Where one page deviates by a per-page rule, the entry
  names the page, the rule and the reason. A canon that pretends uniformity it does not have is
  worse than none.
- Where the map says "not measured", this says "not measured" too. **Do not close a gap with a
  guess to make the document look finished.**

---

## What must survive from the map into the pair

**The inputs.** Without them neither document does its job: Eyal cannot say what content a type takes,
and a session cannot render one. **These come from the code, never from a docblock.**

**The exceptions and the orphans.** They are the reason this exists. **Every one of them appears in
document B.** In document A they appear only where they change what a human sees.

---

## Constraints

- **Content law.** Definition text is ours to write. Site copy is not. Sample content is real or
  plainly generic — never invented copy in Eyal's voice.
- Typography and colour tokens are LOCKED. **The artifact must render its examples using the
  theme's own live stylesheets** wherever it can, rather than reimplementing them — a canon that
  drifts from the site it documents is the defect it exists to prevent. If it cannot, say so in
  document B.
- Never `git add -A`. Never open `local/`. Never touch `_aos/`. Do not run
  `scripts/s007_render_work_ssot.py`. Do not open `scripts/save_legacy_wp_app_password.py`.
- Publish with `python3 scripts/ftp_publish_eyal_client_hub.py`; verify the live URL returns 200 and
  is byte-identical to the tracked source.

## Where the pair lives — updated 2026-09-26

**team_00 opened a dedicated folder for this and for what follows it:**
`_COMMUNICATION/team_100/EYAL-WORKSPACE/`, with `README-INDEX.md` as its entry point.

**Both documents of the pair are written into that folder from the start**, not moved there later.
The artifact still publishes to `hub/dist/` for its live URL, but its tracked source lives here.

**Three rules from that folder's index bind this mandate too:** every document states the date and
the theme version it is true for · "not measured" is a legal value · and content law travels with
the pack — the environment drafts a request, Eyal approves the words.

## Success criteria — Team 90 measures these

- **Both documents exist, each links to the other, and each states the pairing rule.**
- **Every type in the map appears in both** — compared in both directions, never by count.
- **Document A contains zero class names, file paths or status codes** — grepped and reported.
- **Document B names, per type, its inputs and its CSS classes**, and a session can render the type
  from that entry alone. **Test it: pick one type and state exactly what you would write.**
- Every exception and every orphan in the map appears in document B.
- The live artifact returns 200 and matches its tracked source.
