# Mandate — close the four items still open on the build side

You are the **builder** for this mandate. A separate Claude line will **audit** your work on
Tuesday night; builder engine and validator engine are never the same here (Iron Rule #1).
Work directly with **Nimrod** (team_00) and close all four items with him.

- **Repository:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` — branch `main`
- **Live staging:** `http://eyalamit-co-il-2026.s887.upress.link` (plain HTTP on purpose; the
  staging certificate is invalid **by design** — never "fix" it, and never use `https://` here)
- **Theme version at dispatch:** 1.5.92
- **Deadline:** Tuesday evening, 2026-09-22. Claude audits Tuesday night.
- **Language:** speak and write to Nimrod in **Hebrew**. Reports and code comments in English.

---

## WHERE YOU SAVE THE FINAL HANDOFF — read this before anything else

Everything goes under one directory, already created:

    _COMMUNICATION/team_10/S007-GROK/

**The single file the audit reads first:**

    _COMMUNICATION/team_10/S007-GROK/HANDOFF-TO-TEAM100-2026-09-22.md

It must contain, per task: what you changed, the live evidence you measured yourself (URL,
status, what you observed), what Nimrod approved and in his own words, and anything you
deliberately did NOT do and why. **If a task is incomplete, say so in that file rather than
leaving it to be discovered.** An honest "not finished, here is how far it got" is a pass; a
silent gap is not.

**The four deliverables beside it:**

    _COMMUNICATION/team_10/S007-GROK/REPORT-ACCESSIBILITY-2026-09-22.html
    _COMMUNICATION/team_10/S007-GROK/REPORT-PRIVACY-2026-09-22.html
    _COMMUNICATION/team_10/S007-GROK/REPORT-TERMS-2026-09-22.html
    _COMMUNICATION/team_10/S007-GROK/DONE-SOUND-TOGGLE-2026-09-22.md

Commit and push everything you write. Do not leave work only on disk.

---

## TASK 1-3 — three legal research reports (tracker rows R2-003, R2-016, R2-022)

All three sit at **HOLD-W4**. The status is identical for each: **an initial draft was already
approved as a basis, nothing has been pasted to the site, and a full research report is owed
before any of it reaches the client, Eyal.**

The approved drafts are here — read them first, they are your starting point, not blank paper:

    _COMMUNICATION/team_100/S006/DRAFT-R2-003-ACCESSIBILITY-2026-08-25.md
    _COMMUNICATION/team_100/S006/DRAFT-R2-016-PRIVACY-2026-08-25.md
    _COMMUNICATION/team_100/S006/DRAFT-R2-022-TERMS-2026-08-25.md

The live pages the reports are about:

    http://eyalamit-co-il-2026.s887.upress.link/accessibility/
    http://eyalamit-co-il-2026.s887.upress.link/privacy/
    http://eyalamit-co-il-2026.s887.upress.link/terms/

**The sequence is fixed and was set by team_00:** research → Nimrod's feedback → implementation
→ Nimrod's approval → only then to Eyal. **You do not paste anything into the site.** Not a
sentence, not a heading. The reports are decision material for Nimrod.

**Report 1 — accessibility.** Israeli accessibility law as it applies to a small practitioner's
site: what is actually required, where this site stands against it, and what the gaps are.
Recommend an **existing tool or plugin**, explicitly not a from-scratch invention — that
instruction is in the tracker verbatim. Note that this site already publishes an accessibility
statement and that substantial accessibility work has shipped (skip link, focus-visible ring,
alt text, contrast, one mobile drawer, unified navigation), so measure against what is live,
not against a blank slate.

**Report 2 — privacy.** What a site like this must state, what it currently does and does not
meet, the realistic options, and the sensitive points specific to **this** site — it has a
contact form, an external course link, a shop, and embedded media.

**Report 3 — terms.** Compare against similar Israeli sites in the same field, then recommend,
with current references. The tracker calls this part of one three-report package with the other
two — write the three so they read as a set.

**All three are HTML files**, readable by a non-lawyer, in Hebrew, with sources cited and
linked. Each must state plainly what you are **not** sure about; a confident report that hides
its uncertainty is worse than a shorter honest one.

---

## TASK 4 — the sound button is in the wrong place (defect, not a preference)

**team_00's ruling, 2026-09-20, verbatim:**

> «לא תקין - צריך להופיע רק כשיש סרט ותמיד על הסרט או צמוד אליו.»

Canonical: the sound toggle must appear **only on pages that actually have a video**, and must
sit **on the video itself or immediately beside it** — never in the navigation bar.

**Measured live on 2026-09-20, and you should re-measure before you touch anything:** exactly
**one** page carries a `<video>` element — the home page. The toggle renders on **fourteen**
Chapters pages. So on thirteen of them it is a control that operates nothing at all.

Where it lives today:

    site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-nav.php   (the button, id="soundtg")
    site/wp-content/themes/ea-eyalamit/assets/js/ea-chapters.js                  (the behaviour)
    site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/phero.php   (the hero that holds the video)

**Requirements.** Keep the accessible name and the `aria-pressed` state — a screen-reader user
must still be told what the control does and whether sound is on. Keep it reachable by keyboard
with a visible focus ring. Its hit area must be at least 44 by 44 pixels. It must not cover the
video's own controls or any text.

---

## HARD CONSTRAINTS — these are not style preferences

**Content law.** Only what already exists, what came from Eyal in his material files, or what
came from Nimrod in session. **No invented copy, no filling gaps from general knowledge, no
"improving" a sentence.** This rule exists because invented text and invented biographical
years reached the client once already. A page that has no content stays empty and marked.

**Never open or commit anything under `local/`.** It holds credentials — `.env.upress`,
database dumps, WordPress config copies. They are gitignored. Do not read them, do not print
them, do not commit them.

**`_aos/` is a read-only snapshot.** Never edit anything inside it.

**Never `git add -A` or `git add .`** — charter §5.4. Stage explicit paths only. Another session
may have uncommitted work in the same checkout, and a blanket add sweeps it into your commit.

**Typography is locked.** `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md` is the only
authority. To change a size you change a **token** in `assets/css/ea-tokens.css` — never add a
`font-size` to a component rule, never add a breakpoint `font-size`. Rungs are `rem` on purpose;
a `px` rung breaks text resize, which this site's published accessibility statement promises.

**Deploying.** `python3 scripts/ftp_deploy_site_wp_content.py` ships the **working tree**, and
refuses a dirty `site/`. That refusal is a safety interlock protecting other sessions' work —
**never force past it.** Bump `Version:` in `style.css` before deploying, and **read the current
value first rather than assuming it** — it is a shared counter and another session may have
moved it.

**Verify on the rendered page, never on the diff.** Three separate failures in this project on
2026-09-20 came from trusting something other than a real render: a passing `php -l` on a file
that fataled every page; a link-count in the HTML on a menu that was `display:none`; and a
`getBoundingClientRect()` read before layout, which returns zeros that look exactly like a
defect. After any template change, fetch a handful of real URLs with their status codes — a
full GET, not HEAD, not cached — before doing anything else.

**Redirects.** When checking whether a URL is healthy, do **not** follow redirects. A 301 read
with a redirect-following client returns its destination's body and a bouncing link reports as
fine.

---

## WHAT THE AUDIT WILL CHECK ON TUESDAY NIGHT

1. The three reports exist at the paths above, are readable by a non-lawyer, cite real sources,
   and state their own uncertainty.
2. **Nothing was pasted into the live site** for the three legal pages. This is a pass/fail gate.
3. The sound toggle renders only where a video exists, sits on or beside it, keeps its
   accessible name, `aria-pressed`, keyboard reachability and a 44-pixel hit area — verified on
   the rendered page at both desktop and phone widths, not from the source.
4. No page regressed: every published URL still returns 200 and still renders exactly one
   navigation.
5. The handoff file says what was done, what was approved by Nimrod in his own words, and what
   was left undone.
