# Mandate — rebuild Nimrod's board from scratch — 2026-09-25

**Dictated by team_00 after Eyal's form shipped and the meeting closed well. The site is close to
go-live.**

> «לגזור מחדש, לוודא שיש לנו רק כרטיסים רלוונטיים שלא נענו נסגרו או בוצעו. כל פער פגם באג סטיה
> או חוסר שלא מופיע בטופס של אייל חייב להופיע בלוח — מסווג מה ממתין לי ומה לכם, שני סקשנים
> נפרדים. כמו בטופס — כל כרטיס חייב כותרת ברורה לאיזה עמוד או עמודים מתייחס ומה נדרש בדיוק.»

- **Repo:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` — branch `main`
- **Live staging:** `http://eyalamit-co-il-2026.s887.upress.link` — plain HTTP on purpose, certificate
  invalid **by design**, never a defect
- **Board:** `_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html`, rendered from
  `S007-WORK-SSOT.json` by `scripts/s007_render_work_ssot.py`
- **Language:** Hebrew to Nimrod; code comments and report in English

**⚠ Five commits are sitting locally unpushed** — the push was blocked by the environment. **Do not
attempt to push and do not rewrite history.** Work on top of them and say so in your report.

---

## The governing rule

**Eyal's form and this board together must cover everything. A gap on neither surface is an open
gap.** The form now carries **21 cards**:

    BLOG-COL41 · GI-BUNDLE · GI-KUSHI · GI-TSVA · GI-VEKATAVTA
    HW-2012-PHOTO · HW-B2-GALLERY-DUP · HW-C1 · HW-C3 · HW-MUSIC · HW-QR-HERO · HW-REPAIR-ALT · HW-VIDEO
    LEGAL-ACCESS · LEGAL-PRIVACY · LEGAL-TERMS
    OLD-ARCHIVE · OLD-GALLERIES · OLD-PAPER-STORIES · OLD-PORTFOLIO · OLD-SHOWS

**Anything on that list does not go on the board as an open item.** Everything else that is still
open does.

## Structure — two sections, and nothing else at the top

**Section A — ממתין לנימרוד.** Decisions only he can make.
**Section B — ממתין לצוותים.** Work we owe, with no decision blocking it.

**No status table, no derived-state block, no counters at the top.** The board opens with the first
card of Section A. Same discipline the form just got.

**Every card carries:** a heading naming **the page or pages it concerns**, those pages' **live
URLs**, and **exactly what is required** — stated so it can be acted on without reading an audit.

---

## Section A — ממתין לנימרוד

**A1 · עמוד ההופעות — להשאיר, לבטל פרסום, או לפתוח מחדש.** `/shows-heritage/`. Live and indexed;
its whole visible body is the phrase «ניווט משני.». The internal marker was removed; the decision
was never made.

**A2 · בלוק השאלות בדף הבית — כמה מתוך 133, ואילו.** `/` and `/faq/`. Not built. No question was
written and none will be until he says.

**A3 · שני עמודים בלי פריט עבודה.** `/stand-floor/` and `/books/`. Registration, not a build.

**A4 · לבניית נתוני העבודה אין אימות נפרד.** Process, not a site change.

**A5 · שבע־עשרה ההערות מ־18.9 אינן בארכיון.** Documentation, not a build.

**A6 · עמוד מוקש — המילה הסופית.** `/eyal-amit/mokesh-dahiman/`. Prose drift from day one,
including the sentence «בשנת 2026, שש שנים לאחר פטירתו». Not deleted and not rewritten, deliberately.
**Note for the card: there is only one live Mukesh page**; `/about/moksha/` is a 301 to it, and a
separate legacy post about a painting exists. Team 90 measured this.

**A7 · אותה תמונה, שני כיתובים.** `/eyal-amit/mokesh-dahiman/` and `/eyal-amit/`. The file
`mokesh-eyal.jpg` carries «מוקש דהימן עם אייל עמית ברישיקש, הודו» on one and
«אייל עמית עם המאסטר מוקש דהימן ברישיקש, הודו» on the other. **The second has no source anywhere.**
Content law forbids us choosing. **Not on Eyal's form — so it must be here.**

**A8 · התנגשות הזום באייפון.** `/contact/` and every form page. Fields render at 13.6px; iPhone
zooms the page when a field under 16px takes focus. **The type canon locks the field size.** Moving
it is a canon decision.

**A9 · מגע: הקשה על הורה מנווטת במקום לפתוח תפריט.** Every page, mobile. The nav JS listens for
mouse and focus only; there is no first-tap handling. **Now that the menu has three levels, measure
and state whether the four book pages are reachable by touch** — and put that measurement on the
card.

**A10 · העמוד באנגלית בלי פירורי לחם.** `/en/`. Every other page has one; `/` correctly does not.
**Is `/en/` a root like `/`, or does it need a breadcrumb?**

**A11 · האתר הישן — רצף המחיקה.** Backup, then the store decision, then the two real content gaps,
then redirects verified, **then** deletion. **111 of 250 core URLs die; a 100-URL sample of 1,004
attachments returned zero survivors.** The five decision classes are on Eyal's form; **the sequence
is his.**

**A12 · חמישה קומיטים לא נדחפו.** The push was blocked by the environment. **All of today's work
exists only on this machine.** Not a site defect — a risk to the record.

**A13 · אלמנטי הקריאה לפעולה אינם אחידים.** Site-wide. His words: button on the left, logo behind
on the right, title centred, block aligned right. **Needs a map before anyone touches it — exactly
like contrast did.** Approving a map is the decision; the map itself is Section B.

---

## Section B — ממתין לצוותים

**B1 · מיפוי אלמנטי הקריאה לפעולה.** Produce the map A13 needs: every CTA variant, which pages,
what differs. **Measurement only — no redesign, no fix.**

**B2 · כתובית אחת על תמונה בהירה עדיין מתחת לסף.** team_10 reported this honestly after the scrim
shipped. **Team 90 has not re-measured it.** Identify the element and the page, measure against the
painted pixels, and report the number.

**B3 · טקסט כרטיס ההשוואה בדף הבית — 4.22 מול 4.5.** `/`. Misses by 0.28. Explicitly excluded from
the approved contrast round. **Small, and it should not be lost.**

**B4 · כתיבת ההפניות לאתר הישן.** The decisions are Eyal's and Nimrod's; **writing and verifying the
redirect rules is ours.** Blocked until A11 decides.

**B5 · הצהרת הנגישות — ניסוח מעודכן להגשה.** `/accessibility/`. The contrast decision is now made,
so it can be drafted. **It currently discloses a focus-indicator limitation that our own record says
was fixed at 1.5.115 — it is harder on itself than reality.** Draft, then Nimrod approves wording
before paste.

**B6 · עותק שלישי וקפוא של עץ הניווט.** `template-parts/blocks/block-topnav.php`. Renders on no page
found. **Latent: if anyone wires it back, the menu forks.** Fifth instance of this theme's recurring
pattern.

**B7 · ניווט שני ב־DOM בשלושה עמודים.** `/press/`, `/shows-heritage/`, `/historical-articles/`.
Measured `display:block` with a **0×0 painted box** — invisible today. **One CSS rule away from
becoming a visible second menu**, and on `/press/` a rule already fires that shows its container.

**B8 · בדיקת הדואר השנייה.** `/contact/`. The first arrived; Eyal confirmed the second in the
meeting. **Verify the stored recipient is `info@eyalamit.co.il` and record the confirmation** so the
item closes on evidence, not on memory.

---

## Items that must be REMOVED — answered or done today

**Verify each before removing, and report the mapping.**

- **`Q-TALK-8`** — answered. team_00 ruled all meeting items off Eyal's form; six moved to the board.
- **`Q-CONTRAST`** — answered. Both decisions approved and built; `.chap` measured live at **5.55**.
  **What remains are B2 and B3 only** — do not carry the whole row forward.
- **`Q-MAIL-2`** — answered. Eyal confirmed receipt in the meeting. **Becomes B8, a verification.**
- **`Q-EYAL-BATCH`, `Q-COLOR`** — already `resolved`.
- **The 99 `waitingOn: team10` rows** — locked decisions carrying a stale flag, not open work.
  **They are the blog and QR catalogue. They must not appear as open cards.** If the flag itself is
  wrong, say so in your report; do not silently rewrite it.
- **The 60 closed items** — done. They do not render as cards.

---

## Rules

**Content law applies to every card.** Restate what was measured or decided. **Do not characterise,
do not recommend, and do not write a finding that has no measurement behind it.**

**Nothing may be lost.** Every row you drop must be traceable — answered, closed, on Eyal's form, or
explicitly retired. **Report the mapping row by row.**

**Do not mark anything closed that was not closed.** Answered ≠ closed.

**Never `git add -A`.** Never open anything under `local/`. Do not touch `_aos/`. Leave the untracked
`scripts/save_legacy_wp_app_password.py` alone.

## Success criteria — Team 90 measures these

- **Two sections only**, A and B, and no status block at the top.
- **Every card names its page(s) and carries live URLs that return 200**, redirects not followed.
- **Every card states what is required**, actionable without reading an audit.
- **Zero cards for anything on Eyal's 21.** Cross-checked both directions.
- **Zero cards for the 99 locked rows and the 60 closed ones.**
- **Every item in Sections A and B above is present**, or its absence is explained.
- **The mapping of every removed row is reported.**

## Report

`_COMMUNICATION/team_10/DONE-BOARD-REBUILD-2026-09-25.md`, ending with **the board's file path** so
team_00 can open it.
