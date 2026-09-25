# Mandate — the CTA bands: one variant, and one page as a colour test — 2026-09-26

**Approved by team_00 on 2026-09-26**, after seeing `/method/` live and after Team 90 measured the
whole population.

- **Repo:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026` — branch `main`
- **Live staging:** `http://eyalamit-co-il-2026.s887.upress.link` — plain HTTP on purpose; the
  certificate is invalid **by design** and is never a defect
- **Live theme:** read `Version:` in `site/wp-content/themes/ea-eyalamit/style.css` before bumping
- **Language:** code and report in English

**⚠ Another builder is working on the footer right now**, in
`template-parts/chapters/section-footer.php`, `template-parts/blocks/block-footer-social.php`,
`inc/ea-canonical-nav.php`, `functions.php`, `footer.php` and `assets/css/ea-footer-sitemap.css`.
**Do not touch any of those.** If a deploy is refused because `site/` is dirty with their work,
**stop and report — never force past the refusal.**

---

## What was measured, so you do not re-derive it

**19 pages carry a CTA band; 29 bands in total. There are exactly two variants:**

- **22 bands use `cta-band--row`** — button to the side, **the logo mark behind on the side**
  (`cta-band__logo cta-band__logo--side`, rendered by `parts/cta.php` and `parts/contact.php`),
  block aligned. **This is the variant team_00 approved.**
- **7 bands use `cta-band--stack cta-band--choc`** — centred, **no logo**, flat brown background.
  These are the deviation, on exactly these seven pages:

      /method/   /repair/   /sound-healing/
      /learning/   /learning/lectures/   /learning/workshops/   /learning/therapist-training/

**15 bands sit directly above the footer.** All 15 are dark: 5 of them `--choc`, the rest the
default dark wash.

## Task 1 — make the seven match the twenty-two

**Apply the existing `--row` variant to the seven.** They must end up with the same structure the
other 22 already have, including the side logo mark.

**This is not a redesign. You are not inventing a layout — you are applying one that is already
live on 22 blocks.** If the seven cannot take that variant for a structural reason, **stop and
report the reason with the measurement behind it. Do not improvise a third variant.**

## Task 2 — ONE page as a colour test. Do not roll out.

**team_00's words:** «אחרי חום צריך בהיר … צריך לזה פיטרון פשוט ואלגנטי בלי להפוך את כל העמודים.
זה פשוט לא נראה טוב. אולי לשנות את כולם לחום בהיר יחסית. נבדוק באחד ונאשר.»

**Team 90 measured the palette before this was written, and the measurement matters:**

    band background          vs the footer #2E2B28      text that works on it
    --ea-chocolate #5C3A2E          1.41:1              white 10.00:1
    --ea-earth     #8A5A44          2.43:1              white  5.79:1
    --ea-sand      #D8C7B5          8.55:1              ink    8.55:1

**A "relatively lighter brown" does not solve the problem.** `--ea-earth` separates from the footer
at only **2.43:1** — the two blocks would still read as one dark mass, which is the complaint.
**Only a genuinely light ground separates:** `--ea-sand` reaches **8.55:1** against the footer, and
carries `--ea-ink` text at **8.55:1**.

**So: on `/method/` and nowhere else**, render the band on `--ea-sand` with `--ea-ink` text.

- **Use the existing tokens.** `--ea-sand` and `--ea-ink` are already in `ea-tokens.css`.
  **Do not add a colour token and do not hand-write a hex.**
- **The button must be restyled for a light ground.** It currently uses `btn--sand`, which is a
  light button — **on a sand background it will disappear.** Use an existing dark button variant
  from this theme. **Measure the button's own text and its edge against the new background** and
  report both numbers. If no existing variant works, **report that — do not invent one.**
- **Every text element in the band gets a measured contrast number**, against the correct threshold
  for its size and weight (3:1 at ≥24px regular or ≥18.66px bold, otherwise 4.5:1).
- **Change nothing on the other six pages.** team_00 reviews one page and then decides.

## Constraints that override your judgement

- **Content law.** You may not write, shorten or rephrase any text in these bands.
- **Typography and colour tokens are LOCKED.** No new token, no new `font-size` in a component
  rule, no raw hex. `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md` is the authority.
- **Verify on the rendered page**, never in markup. Wait for load, settle and two animation frames.
  Dismiss the native `<dialog id="ea-cookie-notice">`, which makes the page inert.
  **Before sampling any colour, confirm with `elementFromPoint` that your target is the topmost
  painted element** — a scroll-reveal wrapper produced a false contrast failure here earlier today.
- **Never `git add -A`.** Never open `local/` or `scripts/save_legacy_wp_app_password.py`. Never run
  `scripts/s007_render_work_ssot.py`. Do not touch `_aos/`.
- **Bump the theme version** — read it first, it is a shared counter that moved several times today.

## Success criteria — Team 90 measures these

- **All seven pages render the `--row` variant**, each with the side logo mark painted at a
  non-zero box — verified in a rendered browser, not by counting classes.
- **The other 22 bands are unchanged** — Team 90 diffs the rendered item set and the classes.
- **Full regression:** every published URL 200, **exactly one primary nav per page**, zero PHP
  error strings. A template change took this whole site down once already.
- **`/method/` renders the band on `--ea-sand`**, all its text passes its threshold, and the button
  is legible with both numbers reported.
- **The six other `--choc` pages are untouched** — still brown, pending team_00's approval.
- **`ea-tokens.css` and the canon are untouched.**

## Report

`_COMMUNICATION/team_10/DONE-CTA-BANDS-2026-09-26.md`. Per item: the live URL, the status code, and
the measurement that proves it. Include both `git status` readings and the theme version deployed.
**End with the `/method/` URL so team_00 can look at it.**

**If any instruction here turns out to be wrong, say so with a measurement and do not implement
it.** Refusals backed by measurement have saved this project repeatedly, including two of Team 90's
own errors today.
