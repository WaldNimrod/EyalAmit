---
id: TASK_S007_RESPONSIVE_MOBILE_2026-09-18_v1.0.0
type: TASK DEFINITION (team_00 → team_100)
recorded_by: team_100
date: 2026-09-18
status: RECORDED — mapping starts now in parallel; FIXING waits for accessibility to close
---

> ⚠ **HISTORICAL — not the current state.** Typography and CSS sizing are governed by
> `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md`, locked at theme 1.5.56. Numbers in
> this file were true when it was written. **Do not act on a font-size figure from here**
> without checking the canon first — §7 there lists the specific figures that are dead.
> Kept because the measurements and the method are still useful; the conclusions are not.

# Responsiveness and mobile design accuracy — task as team_00 defined it

## Source — team_00's own words, 2026-09-18

> «בקרה ותיקון כל נושא הרספונסיביות באתר ודיוק העיצובים למובייל. כולל היכן צריך להקטין,
> לשנות ריווח וכו — לא רק לרמת תקינות הקוד אלה גם לרמה של נראות קריאות וממשק משתמש סופר
> נוח ויפה ויזואלית.»

> «אתם לא מתעסקים בזה כרגע — אתם רושמים את המשימה כפי שהגדרתי אותה, שולחים קודם כל סוכן
> מחקר ואז מפעילים את צוות 10 לבצע מיפוי מלא, תעוד הנקודות הבעייתיות, השאלות וכו והכנת דוח
> מפורט. אחרי שנסגור סופית את המהלך שלנו בנושא נגישות נתפנה לטפל בזה.»

> «צוות 10 מנהל את התהליך — שולח ליינים זולים של קומפוזר לבדוק, לצלם, להביא רעיות וכו — כל
> פעם ליין קצר עם משימה ספציפית. כל צילומי המסך הרלוונטיים יש לשמור בתקייה זמנית בצורה
> מסודרת ועם קישור מהדוח הסופי. הדוח הסופי חייב לאפשר לנו לנהל דיון ולקבל החלטות ולבנות
> תוכנית תיקון ודיוק אופטימאלית ומדידה.»

## Canonical statement (English, authoritative for teams)

**Objective.** Audit and then correct the site's responsive behaviour and the accuracy of
its mobile design. The bar is explicitly **not** "the code is valid". The bar is that the
site looks right, reads well, and is genuinely pleasant to use on a phone — including
where things must be made smaller, where spacing must change, and anywhere the visual
result is merely tolerable rather than good.

**Phasing.**
- **Now, in parallel with the accessibility work:** research, then a full mapping, the
  documentation of every problem point, the open questions, and a detailed report.
- **After the accessibility milestone closes:** the fixing itself. No corrective change to
  the site is made under this task before then.

**Ownership.** team_10 **manages** this process. It dispatches **short, cheap Composer
lines**, one specific task each — inspect, screenshot, bring evidence back. team_100
frames, validates, and takes it to team_00.

**Screenshots.** Every relevant screenshot is kept in a temporary directory, organised,
and linked from the final report. A finding without an image the owner can look at is
not a finding he can decide on.

**What the final report must make possible.** A real discussion, actual decisions, and an
optimal, **measurable** correction plan. Not a list of impressions.

## Why this is not the accessibility work again

The accessibility milestone measured conformance: ratios, roles, focus order, alt text.
This task measures **quality**: whether a thing is the right size, whether it breathes,
whether a phone user can read it comfortably and enjoy doing so. The two overlap at the
edges — tap targets, text size, reflow — and the report should say where an item is
already covered by the accessibility work rather than re-opening it.

## Constraints carried over

- Rounds 1 and 2 were desktop-only by team_00's decision (charter §8ב); mobile was
  deferred to round 3. **This task is that round-3 mobile work.**
- Content law still applies: no rewriting Eyal's copy to make a layout fit. If text does
  not fit, that is a layout finding or a question for him, never a silent edit.
- The site is right-to-left. Mobile RTL has its own failure modes, and a prior RTL audit
  (`_COMMUNICATION/team_10/RTL-AUDIT-2026-09-17/`) already found several — read it first
  rather than rediscovering them.
- Never `git add -A`. Every claim about code cites `file:line`.
- **Engine cost order (team_00, 2026-09-18):** Grok first; composer-2.5 for black work;
  GPT only when an extra edge is genuinely needed.

## Status

- [x] Task recorded as defined
- [ ] Research pass
- [ ] team_10 activated to map, document and report
- [ ] Report to team_00 for discussion and decisions
- [ ] Correction plan built and approved
- [ ] Fixes executed — **blocked until the accessibility milestone closes**
