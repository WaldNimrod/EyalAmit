---
id: HANDOFF_CURRENT_S006_2026-09-18_v3.0.0
schema_version: aos_v1_team_messaging
type: STATE (team_100)
status: ACTIVE — open-work SSOT
law: S006-MILESTONE-CHARTER.md
decisions: _COMMUNICATION/team_00/DECISION-INDEX.md
date: 2026-09-18
disposition: >
  SSOT for what is OPEN at session level. The tracker xlsx remains SSOT for row/item status.
  Every other S006 md file is method, archive or mandate — they point here and must not keep
  a second open-list. Rewritten in full on 2026-09-18 after the accessibility milestone
  closed and S007 opened; everything below the ARCHIVE line is prior-wave history.
---

# S006 / S007 · state at 2026-09-18, written for compaction

**Typography and CSS sizing are NOT governed by this file.** They are governed by
`_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md`, locked at theme 1.5.56. Any font-size
figure in this file or any other is historical unless the canon agrees with it.

**Read first:** the charter (`S006-MILESTONE-CHARTER.md`), this file, and the decision index
(`_COMMUNICATION/team_00/DECISION-INDEX.md`). Conflict precedence: charter › method template
› this file › session memory. **Derive every number fresh — quote nothing from here as current
state without re-measuring.**

## Where the code is

Branch `s006/tracker-integrity`. `main`, `origin/main` and `origin/s006/tracker-integrity`
all aligned. Live staging ran theme **1.5.54** when this line was written, after eighteen
deploys in one day (1.5.40 → 1.5.54). **That number is stale the moment you read it** — 1.5.40
survived less than an hour here, and 1.5.48 not much longer. Re-derive it; do not cite it.
`http://eyalamit-co-il-2026.s887.upress.link` (HTTP; invalid TLS there by design).

## Accessibility — four items open, two resolved 2026-09-18 pending M-04 re-verification

P0 and P1's code-level fixes are deployed and verified cross-engine on Grok. **The published
statement is NOT yet accurate** — see item 5. Theme moved 1.5.39 (the `XVAL-*` measurement
wave cited below) → **1.5.40** during the same day this was cross-checked — re-verify
anything version-sensitive fresh; do not trust any version number written here either.

**Landed:** focus colour on skip link / nav / logo / CTAs · mobile menu reachable by keyboard
and the closed drawer out of the tab order · 162 book-gallery photographs described (6 left
as deliberate questions for Eyal) · hash-based alt matching · the child-theme path bug that
had made that whole map dead · card and FAQ headings · muted colour tokens · the treatment/
lessons active-tag contrast fail (**confirmed passing live on 1.5.40, 4.6255:1** — the
`XVAL-B2` file measures the pre-fix 1.5.39 state, 4.2573:1 FAIL; no fresh cross-engine
artifact for 1.5.40 exists yet, so cite this line, not `XVAL-B2`, if asked how this closed).

**Not independently re-verified by the `XVAL-*` evidence** (may well be true — just not
re-measured; do not cite `XVAL-*` for these): submenu `aria-expanded` · Hebrew CF7 validation
· the D-8 blank prompt · duplicate photographs removed.

**Still open, all measured:**
1. **Focus-indicator prominence** — ring contrast: skip 1.06:1, `.btn--terra` 1.65:1, brand
   2.54:1, EN toggle 2.90–3.00:1 (borderline). Not a WCAG 2.0 AA failure (the 3:1 floor is
   2.1 SC 1.4.11, which IS 5568 does not bind) but the statement now names it as a limitation.
2. **Footer brand/address/phone at 4.4867:1** — three hundredths short of 4.5.
3. **Mobile only (390px)** — header Tab order contradicts visual RTL order; focus lands
   off-screen on one home `#peek` link and six FAQ chips.
4. **200% text resize** — **the real failure here is FIXED** (1.5.47). `.hero` was
   `height:100vh` with `overflow:hidden`; at a 32px root the hero needed 911px against a
   900px box and the hero CTA fell outside. Now `min-height:max(620px,100vh)`; re-measured on
   `/`, the hero grows 900→922px, nothing clipped, no horizontal scroll, every rung scaling
   exactly ×2. **Verified on the home page only** — the other eleven pages are M-04's job.
   Two cautions carried forward from getting this wrong first:
   - The earlier measurement used CSS `zoom:2`, which scales layout and is **page zoom**, a
     different question from text resize. Its overlap numbers (skip link over brand, FAQ
     heading over nav, burger 151.6px out) describe that test, not SC 1.4.4.
   - `scrollHeight > clientHeight` is **not** clipping unless an ancestor actually clips. It
     flagged nine `.h2` and the `h1` here; all nine were a tight line-height on an
     `overflow:visible` box. Only the hero was real, because only the hero had a clipping
     ancestor.
5. **The published statement's two false claims are both resolved** — differently, and the
   difference matters. The limitations section named the treatment/lessons tag chip as a
   current failure; that was false, so **the sentence was removed** (verified gone live).
   The 200% claim was false, so **the site was changed until the claim became true** (item 4)
   — the wording was not touched. Fixing the sentence would have been the wrong repair there.
   Statement now on its third and fourth corrections; treat every remaining sentence as a
   claim to falsify. M-04 re-measures all of them against 1.5.48.
6. **Eyal owes two answers** — his name as coordinator (D-11), and the final legal wording
   that retires the WP-EI-05 draft banner (D-13). Plus six unidentified photographs.

Evidence: `_COMMUNICATION/team_50/XVAL-CONSOLIDATED-2026-09-18.md` and the `XVAL-*` files it
indexes; `_COMMUNICATION/team_50/XVAL-STATE-ACCURACY-2026-09-18.md` (this cross-check, and
why items 1/5/Landed changed); `_COMMUNICATION/team_100/S006/A11Y-CONSOLIDATED-REGISTER-2026-09-17.md`;
`_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/`.

## S007 typography — SCALE LOCKED 2026-09-18, mapping run, phase 2 dispatched

**The plan:** `/Users/nimrod/.claude/plans/100-humming-forest.md`, Part Two — four phases,
typography → accessibility re-check → mobile → rows, in that order because type changes
invalidate the other two's measurements.

**LOCKED.** team_00: «תנעל את הסולם לפי הצירוף האחרון ותריץ את המיפוי». The scale is real
tokens in `assets/css/ea-tokens.css`, and the site renders from them.

**Twelve rungs, body as the anchor.** Five are his, read off the combination he approved
(`?ty=17&nav=1.08&h1=2.6&h2=1.45&h3=1.1`): body 1.00 · nav 1.08 · h3 1.10 · h2 1.45 · h1 2.60.
Seven derived for roles his combination does not name: display, h4, lead, sm, xs, 2xs, 3xs.
**One deliberate departure:** h3 weight is 600, not the 500 in that URL — «H3 יותר כבד» came
after it, and locking 500 would have undone an instruction already given.

**Expressed in `rem`, not `px`.** The approved numbers are pixel numbers, but a px font-size
does not follow the reader's own font-size setting and this site promises text can be
doubled. Each rung is the approved pixel value over the 16px root, so nothing renders
differently and resize works again. Shipping px was my error, caught the same day.

**Mapping run: 73 of 76 live declarations wired**, plus 8 more in two stylesheets the
inventory never saw. Three are deliberately NOT wired and annotated in place — `.nav__caret`
(`.6em`, a glyph sized off its parent), `.testi-mq__btn` (a carousel arrow), and a CF7 label
at `font-size:0` (hidden on purpose). A rung for any of those would be wrong, not missing.

**Two findings that change how this codebase should be searched:**
- **A tenth live stylesheet.** `faq-toc.css` loads only on `/faq/`, `ea-blog.css` only on blog
  views. The nine-file list — mine, and team_10's verification of it — was derived from `/`
  and `/treatment/`, which load neither. Both passes agreed and both were incomplete. A
  stylesheet list read off two pages is a claim about two pages.
- **A second, invisible type system.** `ea-tokens.css` defines nine `--ea-type-*` composites
  that carry size inside the `font:` **shorthand**. It reports **zero** `font-size`
  declarations, which is why it read as empty; 51 rules across six sheets consume it, and it
  loads on every page. That is how a 9.28px date survived on every blog card while the sweep
  reported the blog clean. Now expressed in rungs, so all 51 uses follow the scale.
- The rungs live in `ea-tokens.css`, **not** `chapters.css`: the latter is gated on
  `ea_chapters_is_view()`. Defining rungs in the conditional sheet and consuming them in the
  unconditional one collapses the whole `font:` shorthand — it fails whole, not per-property.

**Verification method that actually worked:** sweep the rendered DOM of each page for text
elements whose computed size is not one of the twelve rungs. Nine page types returned zero.
That sweep — not the file inventory — is what found both gaps above.

**The preview tool is still installed** and still overrides the tokens with `!important` when
`?ty=` is present, so the numbers can still be tuned by eye. Delete it on team_00's word —
and note the FTP deploy **never prunes**, so deleting the file locally does not remove it
from staging.

**Phase 2 ran and closed** — `_COMMUNICATION/team_10/S007-M04/`. 193 contrast failures
reported across 1,845 elements on 12 pages. **That number is not 193 defects.** 118 were the
FAQ disclosure chevron and 6 the section eyebrow, both on `--terra` at ~4.43:1 — closed by
repointing to `--terra-btn`, the token team_00 had already approved for the topic chip (no
new colour, brand `--terra` untouched). Verified live at 4.61:1. The rest split between
genuine near-misses at the footer (~4.50, open item 2) and backdrop-measurement errors.

**The nav was a real failure and I initially denied it.** I told team_10 their 4.18–4.40
readings were wrong and the nav measured ~11:1. They came back with the CSS: `.phero--media`
lays a photograph under a scrim that is only `.5` at the top. I looked at the rendered pixels
— a workshop photo with pale mosaic and a lit doorway sits directly behind the menu. There IS
a nav scrim (`chapters.css`), which is what my walker found, but it runs `.82` at the top edge
and `.34` by 52%, and `.nav` is 72px tall with its text vertically centred — so the text sits
at the `.34`, not the `.82`. Right gradient, wrong sample height. Arithmetic across photo
tones: old state 10.71 / 5.27 / **2.71**:1; new state 16.48 / 13.20 / 9.79:1. Fixed in 1.5.54
by holding the scrim at `.74` through 62% and lifting the links from 82% to 95% white — the
latter being the contrast increase team_00 asked for and I had not shipped.

**Also closed in phase 2:** the home hero clipped its own CTA at 200% text (`height:100vh` +
`overflow:hidden`, 911px of content in a 900px box) — now `min-height:max(620px,100vh)`,
re-measured at 900→922px with nothing cut. Heading structure clean on all 12 pages.

**Closed since:** content HTML inside prose bodies (bare `h2/h3/h4/li/blockquote` were never
selected by any child-theme rule — three `h3` rendered at 29px, *larger* than the 24.65px
section title above them); three inline `style="font-size"` attributes in the content itself,
the only place a stylesheet cannot reach; and all nine wrapping hero titles, each now breaking
on a chosen boundary in the sentence with the cap tightened to 32ch so the sentence decides
where a title breaks rather than the cap.

**Still open in typography:** the remaining SHOW-FIRST decisions, and six card-title classes
that still outrank the h3 tier on weight — whether the tier should override those designs is
team_00's call, not ours.

## S007 later phases — defined, not started

- **Mobile** — `TASK-S007-RESPONSIVE-MOBILE-2026-09-18.md` + its research file. Central fact:
  the approved team_35 mobile design was built as `ea-mobile-nav.css` / `.js` /
  `ea-mobile-variants.css`, then orphaned when Chapters replaced the nav. All three still load
  on every page and match **zero** elements.
- **Rows and media** — `FOUND-ROW-RHYTHM-GAP-2026-09-18.md`. 11 of 29 pages have zero
  alternating rows, 21 have at most one; the loop has no alternation logic at all and only 4
  of 33 defaults files request a variant. Six of twenty-four body parts are dead code and
  several are the vocabulary the flat pages lack. **Definition only — no corrective work.**
- **Element templates** — `BACKLOG-S007-M02-ELEMENT-TEMPLATES.md`, parked by D-21.

## Standing rules that bit us this session

- **A clean automated scan is not a PASS** — charter §8א clause 5, D-14. axe returned 0
  violations on the three book pages both before and after 162 photographs were fixed.
- **Split verification lines; do not raise the timeout.** Three lines timed out and returned
  nothing tonight; re-splitting worked immediately.
- **Engine cost order** — Grok first, `composer-2.5` for black work, GPT only for a real edge.
- **The deploy script ships the working tree, not a git ref.** It now refuses a dirty `site/`
  and records the deployed commit in `DEPLOY-LOG.md`.
- **Spacing-sensitive greps lie.** `font-size:var(` found zero where `font-size: var(` had
  fourteen.
- **A search for the wrong PROPERTY is the same failure one level up.** `ea-tokens.css`
  reports zero `font-size` declarations and carries an entire nine-rung type system inside
  the `font:` shorthand. Two independent passes recorded it as empty.
- **A file list read off two pages is a claim about two pages.** Two live stylesheets load
  only on `/faq/` and on blog views, and were missed by both my inventory and its
  verification. The authority is what renders, not what is enqueued in the files you checked.
- **`scrollHeight > clientHeight` is not clipping** unless an ancestor actually clips. It
  produced nine false positives in one sweep here; a tight line-height causes it routinely.
- **Do not resolve a backdrop from the DOM for contrast.** `backgroundColor` is transparent
  for gradients, background images and video, so a DOM walk sails past the real backdrop and
  lands on the body. Twelve findings, mostly false, in one pass. Sample rendered pixels.
- **`px` freezes a site against the reader's font-size setting; `rem` does not.** An approved
  pixel number is not an instruction to ship a pixel unit.
- **Before calling a same-day document wrong, check git.** A cross-engine line correctly
  measured Heebo and wrongly called the serif-H1 claim "backwards" — the claim was true when
  written and superseded three minutes before that line started.

## Two sessions are working alongside this one

`eyalamit-co-il-2026-ce` and `eyalamit-co-il-2026-e4`, both team_10 on Sonnet, sharing this
worktree. Both idle as of writing. They manage lines; they do not validate their own builds.

---

# ═══════════ ARCHIVE — everything below is prior-wave history ═══════════

Kept so the wave log is not lost. **Every "open" or "next" item below this line is VOID
against the state above.**

---
id: HANDOFF_CURRENT_S006_2026-09-08_v2.0.0
schema_version: aos_v1_team_messaging
type: HANDOFF_TO_NEXT (team_100 → fresh team_100 session) · depth: state-only
from: team_100 (reset 30.8 — state SSOT after prompt/CURRENT collision)
to: team_100 (fresh session)
cc: [team_00, team_90, team_10, team_50]
date: 2026-09-08
law: S006-MILESTONE-CHARTER.md
disposition: >-
  SSOT for what is OPEN at session level. Tracker xlsx is SSOT for row/item
  status. Other S006 md files are method, archive, or mandates — they must
  point here and must not keep a second open-list. Verified 2026-08-30 against
  tracker + theme code + staging HTTP/DOM. Re-verified 2026-09-06 against
  git (all branches), the live theme and Eyal's 31.8 export. Do not start a
  work plan from archive sections below the line.
status: ACTIVE — open-work SSOT (not a per-page build cycle)
---

# HANDOFF → team_100 · S006 · **מצב בלבד** (חי)

**מה פתוח מנוהל בקובץ הזה.**  
סטטוס שורה/סעיף = `EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx` (וגם `tracker/latest.csv` / `latest-items.csv`).  
אמנה = דין. תבנית GENERIC = פקודות ליין. אונבורד 17.8 / רשימות «ממתין לאייל» למטה = **ארכיון**. אל תציעו סקואופ עמוד מתוכם.

אימות חי 2026-09-06: סטייג'ינג `http://eyalamit-co-il-2026.s887.upress.link` · תמה **חיה** `1.5.20` · `main` **1.5.15** · ענף `s006/tracker-integrity` **1.5.17** · ענף `origin/feat/s006-a11y-close` **1.5.20** (לא ממוזג, בהוראת D-1).

> ⚠ **העץ עומד על ענף `s006/tracker-integrity`, לא על `main`.** הענף **לא נדחף** — הדחיפה נחסמה וממתינה לאישור נימרוד.

---

## פתוח עכשיו

### 1. עבודת סוכן שעדיין לא נסגרה

| פריט | איפה | מה נשאר | נבדק חי/קוד |
|---|---|---|---|
| **W4 משפטי — מחקר, בלי הדבקה** | R2-003 `/accessibility/` · R2-016 `/privacy/` · R2-022 `/terms/` · שלושת `LEG-01` = `בעבודה` | דוח HTML: [RESEARCH-S006-W4-LEGAL-2026-08-30.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/RESEARCH-S006-W4-LEGAL-2026-08-30.html) (עודכן אחרי CDP 30.8). ממתין למשוב נימרוד. **אין** `GO-W4-PASTE`. באנר WP-EI-05 חי | CDP: שני דילוגים → `#main` עובד בלחיצה; דילוג ראשון ב־1.5.16 נשאר `top:-40px` בפוקוס מיידי (transition). טופס צור קשר: CF7 בלי label + טופס מקומי עם label — כפילות |
| **A11Y-NOW — קומטה 6.9, עדיין לא בחי** | `fabd106` על `s006/tracker-integrity`. תמה 1.5.17 | **FTP חסום עד GO נימרוד** (מנדט NOW). אחרי FTP: אימות 50 Tab+Enter — [REQUEST-S006-A11Y-NOW-SPOTCHECK-TEAM50](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/REQUEST-S006-A11Y-NOW-SPOTCHECK-TEAM50-2026-08-26.md) | הייתה **לא מקומטת מ-26.8 עד 6.9** בעץ משותף. team_110 תפס במדידה |
| **🔴 מיזוג `feat/s006-a11y-close` — חוסם פריסה** | [RULING-110-BLOCKER](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/RULING-TEAM100-110-BLOCKER-AND-FOUR-2026-09-06.md) | **שער 4 מושהה.** אין FTP מהענף הזה עד מיזוג. `git merge` ו-`git push` **נחסמו ע״י מסנן ההרשאות** — שניהם ממתינים לנימרוד | הפריסה היא `rglob("*")` = דריסה מלאה. הענף חסר `position:fixed;z-index:100000`, ארבעה `:focus-visible`, `.foot__disc` ב-`.62`. פריסה = רגרסיה 1.5.20 ← 1.5.17 |
| **T-1 — 126 מעברי סטטוס בסבב-2** | [DECIDE_S006_TRACKER_DRIFT](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_00/DECIDE_S006_TRACKER_DRIFT_2026-09-06_v1.md) | **חוסם.** הבסיס תקוע על 23.8, אין verify נקי. ממתין להכרעת נימרוד | 126/126 עם ראיית ביצוע — הסטטוס אמיתי, רק הפנקסנות דילגה על «בעבודה» |

### 2. מה נסגר ב-7–8.9 — חמישה עמודים חיים

| עמוד | מה נעשה | אימות חי |
|---|---|---|
| R1-10 `/shop/` | בלוק 2 נמחק, שלוש הפסקאות להירו (M-01+M-03) | 3 `<p>` בתוך `header.phero`, `intro-body` נעלם |
| R1-23 `/contact/` | שדה «נושא הפנייה» נמחק (M-02) | `ea-cf-topic` נעדר |
| R1-22 מוקש | נגן `youtube-nocookie` + כיתוב 3 שורות + ציר זמן מתחת לגלריה (M-04) | דלתא 0, כותרת מדויקת |
| R1-25 `/faq/` | היסט מחושב, `12rem` כ-fallback (M-05) | 285px מול 273.5 נדרש |
| R1-28 נחירות | `gallery--doc` בהצטרפות מפורשת (M-06) | 820px = ×2.29, דלתא יחס **0** |

**גל הקרוסלה בוטל** — `9fcbec5` מ-21.8 («replace auto marquees with manual arrows») הקדים את המשוב של אייל ב-10 ימים. 3 מ-5 עמודים כבר הציגו את המספר המדויק. נותרו שתי שאלות בטופס: `H-16` (בית 15/16) · `DG-06` (כלים — אין קטגוריית כלים ב-docx).

**שער לפני העברת טופס לאייל — `scripts/s006_control_triangle.py`.** חמש בדיקות, כולן נבדקו שלילית. הטופס לא עובר בלי ריצה ירוקה.
**Version חי: 1.5.24.**

### 2ב. מה נסגר ב-6.9

| מה | קומיט | הערה |
|---|---|---|
| קליטת 21 הפסיקות של אייל (8 אושרו · 13 חזרו לתיקונים) | — (ה-xlsx הוא SSOT, gitignored) | דרך `tracker_ingest_approvals.py` בלבד. כתיבה ישירה נפסלה ע״י ה-guard, ובצדק |
| בקרת `--allow-ingest` + אטימת מסלולי המחיקה של יומן הביקורת | `83ace46` | self-test 14/14, הרמטי. שתי בדיקות חדשות למסלול הקליטה |
| הצלת A11Y-NOW מ-26.8 | `fabd106` | 25 קבצים |
| יומן הביקורת של סבב 2 | `6b615f3` | 392 קבצים שהיו רק בעץ העבודה |
| הזדהות מול שני ליינֵי הבנייה | ארטיפקטים ב-`team_10/` ו-`team_110/` | שניהם אישררו, נתנו משוב, ועומדים **ללא מנדט** |

**כללים שנקבעו 6.9 ואינם בתבנית:** פורס = team_100 בלבד (הבנאי מסיים בקוד+ראיות) · `Version` = הבנאי מודיע, team_100 מעלה · אישור אייל חל על הבייטים, לא על המימוש — רכיב משותף מחזיר רק עמודים שמחרוזת מאושרת שלהם זזה, מוכח בדיף-בייטים · ציטוט docx = `scripts/docx_paragraph_index.py`, פורמט «פסקה `<idx>`» · **מנדט בנייה פעיל אחד בכל רגע** (חלוקה לפי זמן, לא לפי קבצים) · «עד 50 מילים» **נמחק** — מספר בלי מקור · גל D ירד מרשימת הבנייה, אסקלציה לאייל.

**שני ליינים חיים וממתינים:** team_110 (Opus, בנייה כבדה/רב-עמודית) · team_10 (Sonnet, קובץ יחיד קיים).
הגבול: קובץ אחד, קיים, של עמוד אחד → team_10. כל השאר → team_110.

AOS: גרסת האב תגיע מההאב. **לא לגעת ב-`_aos/`**. `validate_aos` 11/13/65 נשארים.

### 2. ממתין לאייל — טפסים חיים (לא לגעת בניסוח)

טופס סבב 1: http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s006-review.html  
טופס סבב 2: http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s006-r2-review.html  
עץ: http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s006-r2-tree.html  

סעיפי טרקר `ממתין לאייל` (אומת 30.8 מ-`latest-items.csv`):

| סעיף | עמוד | חי |
|---|---|---|
| FAQ-07 | `/faq/` | href `/cbDidg-therapy-training` → **HTTP 404**. `/learning/therapist-training/` עצמו 200 (עמוד מוקפא) |
| SHOP-01 | R2-024 חנות/תיקון | שאלה: שני עולמות או איחוד — **לא ליישם** עד תשובה |
| ARC-01 ×7 | אודות · כתבות היסטוריות · קורסים חיצוניים · עיתונות · שירותים · הופעות · תודה | כולם HTTP 200 כארכיון/placeholder |

אין לפתוח מחדש עמוד `הוגש לבדיקה` בגלל השאלות האלה.

### 3. הוקפא — לא בנייה עכשיו

מדיה/וידאו בלי קובץ מאייל (H-06, T-02, LSN-02, SH-02, SHP/DG/BAG/… וכו') — סטטוס סעיף `הוקפא`. הרשימה המלאה בטרקר, לא כאן.

**H-06 חי:** בית `#video` — כותרת «וידאו» · Lorem · קופסה «כאן ייכנס וידאו 16:9» · זה **פלייסהולדר יחיד** בבית (`ממתין לאישור` ×1). לא למלא URL.

עמודי סבב 1 `הוקפא` (אין חבילה / ארכיון): R1-06 · R1-07 · R1-20 · R1-24 · R1-27 · R1-29.

### 4. סבב 3 / אחרי S006 — לא בסשן

מובייל · ביקורת ת״י 5568 AA · S007 meta · חיתוך לפרודקשן · `WP-S5-04/05`.

---

## לא פתוח — נבדק 30.8 (CURRENT הישן שיקר כאן)

| טענה ישנה בקובץ זה / בפרומט 17.8 | מצב חי |
|---|---|
| דף הבית מועמד לבנייה / H-01 ו-H-07 ממתינים | R1-01 `הוגש לבדיקה`. ציר זמן: אין 2004/2017 ב-DOM (רק 1999 בשורת trust). H-07: **30** `<img>` ב-`#peek`, בלי פלייסהולדר |
| פער מספור 02→04 חוסם הגשה | **לא נצפה.** תוויות `*_chap` ב-`home-defaults.php` ריקות; ב-DOM אין «פרק 02/03/04». סדר כותרות h2 תואם את 12 הפרקים של אייל |
| R1-08 / R1-09 הוקפאו | `הוגש לבדיקה`. `/learning/lectures/` 200, H1 «הרצאות על נשימה, דיג'רידו, סטרס ושינה» |
| C-07 / C-08 «לא יושמו» (§ב.6 הישן) | C-07 יושב (timeline ריק). C-08/M-01a `בוצע` בטרקר |
| C-04 חסר CTA `/media` | חי: «לכל ההמלצות» → `/testimonials/` |
| C-05 כרטיסים מומצאים | חי: פרק המפגש הוא פסקאות, בלי ארבע הכותרות שהומצאו |
| `?compare=eyal` עדיין טוען טווין | `ea_chapters_treatment_compare_eyal()` מחזיר `false` |
| סבב 2 «טרם נבנה» / OPTIONS 18.8 | גלים 1–3 + 5 הוגשו; גל 6 טופס חי (HTTP 200, title «אישור עמודים — סבב 2»); גל 4 = שורה 1 למעלה |
| A11Y-NOW פתוח לצוות 10 | [DONE-S006-A11Y-NOW-TEAM10-2026-08-26.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/DONE-S006-A11Y-NOW-TEAM10-2026-08-26.md) |

חתימת אייל בעמודת האנוש: **אפס שורות** — זה שער לקוח בטפסים, לא שער בנייה.

טפסים: **לא לגעת** ב-`s006-review.html` (סבב 1) מעבר לקריאה.

קליטת W4: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/INTAKE-NIMROD-W4-2026-08-26.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/INTAKE-NIMROD-W4-2026-08-26.md)  
חוק תוכן / שני ליינים: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/HANDOFF-TEMPLATE-GENERIC.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/HANDOFF-TEMPLATE-GENERIC.md) (פקודות בלבד).

---

# ארכיון — לא לגזור ממנו «פתוח»

נכתב 17–26.8. נשמר כדי לא לאבד יומן גלים. **כל סעיף «ממתין» / «הבא בתור» מתחת לקו הזה מבוטל מול «פתוח עכשיו» למעלה.**

### ב.0 מקור החומר

1. **בייטים מקוריים (team_00 17.8.26):** `EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/` + `סקירה דף הבית.xlsx` לידה.
2. **תשובות סבב 1 (19.8.26):** `EyalAmit_Site_GoogleDrive_Sync/הערות של אייל לאחר סבב שלב 1 - 19.8.26/`
3. **מפה:** `_COMMUNICATION/team_100/S006/MAP-S006-EYAL-R1-NOTES-2026-08-19.md`

לא כותבים מ-`docs/project/eyal-ceo-submissions-and-responses/from-eyal/`. 23 עמודי סבב 1 שהוגשו — לא לפתוח.


### ב.0 מקור החומר

1. **בייטים מקוריים (team_00 17.8.26):** `EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/` + `סקירה דף הבית.xlsx` לידה.
2. **תשובות סבב 1 (19.8.26):** `EyalAmit_Site_GoogleDrive_Sync/הערות של אייל לאחר סבב שלב 1 - 19.8.26/` — אקסלי טופס + md מחליף לאודות + md הרצאות/סדנאות + שני JPG + docx ממליצים.
3. **מפה:** `_COMMUNICATION/team_100/S006/MAP-S006-EYAL-R1-NOTES-2026-08-19.md`

לא כותבים מ-`docs/project/eyal-ceo-submissions-and-responses/from-eyal/`. מחזור עמוד סבב 2: אמנה §8ד + תבנית סוכן R2 + GO רציף. 23 עמודי סבב 1 — לא לפתוח.

## ב.1 מה הושלם *(ארכיון 21.8 — אל תגזרו «נשאר» מכאן)*

| שורה | עמוד | מצב |
|---|---|---|
| R1-01 | `/` דף הבית | **הוגש לבדיקה** · H-01 ציר זמן **הוסר** 21.8.26 (D5 «למחוק מהדף») · Composer א׳+ב׳ tails **PASS** · נשארו H-06 וידאו · H-07 מדיה |
| R1-02 | `/treatment/` | **הוגש לבדיקה** · T-01 **בוצע** 21.8.26 — `/treatment/` נשאר; `?compare=eyal` אינו טוען טווין · Composer א׳+ב׳ tails **PASS** · נשאר T-02 סרטון |
| R1-03 | `/method/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳ חוזה + ב׳ E2E/אקסל **PASS** · MTH-01 תמונות |
| R1-04 | `/lessons/` | **הוגש לבדיקה** · LSN-09 **בוצע** 21.8.26 — href מאמר הריון מ-D6 (אתר ישן, HTTP 200) · Composer א׳+ב׳ tails **PASS** · נשארו LSN-01 תמונות · LSN-02 וידאו |
| R1-05 | `/sound-healing/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳ חוזה + ב׳ E2E/אקסל **PASS** · SH-01 תמונות · SH-02 וידאו |
| R1-26 | `/testimonials/` (היה `/media/`) | **44** המלצות · slug שונה + 301 · **og:description נוקה** (צוות 80) 18.8.26 · H1/M-03 לא נפתח · **VERDICT PASS חוצה-מנועים** + חוזה א׳/E2E ב׳/בקרה CORE PASS |
| R1-10 | `/shop/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳ חוזה + ב׳ E2E/אקסל **PASS** · SHP-01/02 תמונות |
| R1-11 | `/repair/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳+ב׳ **PASS** · REP-01/02 |
| R1-12 | `/didgeridoos/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳+ב׳ **PASS** · DG-02/03 |
| R1-13 | `/bags/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳+ב׳ **PASS** · BAG-03/04/05 |
| R1-14 | `/stands-storage/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳+ב׳ **PASS** · STN-01/02 |
| R1-15 | `/stand-floor/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳+ב׳ **PASS** · FLR-01/02 |
| R1-16 | `/books/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳ חוזה + ב׳ E2E/אקסל **PASS** · BK-04/05/06 מדיה · **לא נפתח מחדש** בגל remainder |
| R1-17 | `/books/kushi-blantis/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳+ב׳ **PASS** · KSH-01…05 |
| R1-18 | `/books/tsva-bekahol/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳+ב׳ **PASS** · TSV-01/02/03/07 |
| R1-19 | `/books/vekatavta/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳+ב׳ **PASS** · VKT-01/02 |
| R1-21 | `/eyal-amit/` | **הוגש לבדיקה** · `ממתין ל=אייל` · שתי גרסאות באותו עמוד · Composer א׳+ב׳ **PASS** · ABT-08 בחירת גרסה · ABT-02 תמונות · ABT-05 ויקיפדיה |
| R1-22 | `/eyal-amit/mokesh-dahiman/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳+ב׳ **PASS** · MK-02…07 מדיה/ציר/bleed (נימרוד השאיר בינתיים) |
| R1-23 | `/contact/` | **הוגש לבדיקה** כקיים · Composer ב׳ E2E **PASS** · אפס PHP · `ממתין ל=נימרוד` (אין סעיף לאייל) |
| R1-25 | `/faq/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳+ב׳ **PASS** · FAQ-01 הירו · FAQ-04 טבלת מיזוג · **FAQ-05/06/07 קישורי 404** (href נשארו כבמסמך) · חריג CPT/JSON (נימרוד 18.8.26) |
| R1-28 | `/snoring-sleep-apnea/` | **הוגש לבדיקה** · `ממתין ל=אייל` · Composer א׳+ב׳ **PASS** · SNR-01…04 · WP-EI-03 נשאר ON_HOLD |
| R1-06 | `/learning/` | **הוקפא** · אין חבילת אייל |
| R1-07 | `/learning/therapist-training/` | **הוקפא** · אין חבילת אייל ב-`content 13.8.26/` |
| R1-08 | `/learning/lectures/` | **הוקפא** · אין חבילת אייל |
| R1-09 | `/learning/workshops/` | **הוקפא** · אין חבילת אייל |
| R1-20 | `/blog/` | **הוקפא** · ארכיון; 54 פוסטים = סבב 2 |
| R1-24 | `/en/` | **הוקפא** · אין מקור EN · WP-EI-06 ON_HOLD |
| R1-27 | `/galleries/` | **הוקפא** · zip מדיה אינו מקור עמוד |
| R1-29 | קורסים (תפריט `#`) | **הוקפא** WAIT-WAVE · אין תיקיית קורסים ב-`content 13.8.26` · לא הומצא יעד · R2-007 נשאר סבב 2 |

## ב.2 דף הבית — מוכן להצגה לאייל (דסקטופ)

הסדר החי: hero → 02 → **03** → 04 → 05 → 06 → 07 → photo-band → 08 → 09 → 10 → 11 → 12.
פלייסהולדרים 03 ו-09 חיים. H-07 **ניתן להצגה** (הקופסה בנויה).
artifact: `_COMMUNICATION/team_90/VERDICT-R1-01-HOME-PLACEHOLDERS-2026-08-17.md`

חוב שלא חוסם: שמות שדה `closing_*` בפרק 9 · `photo-band` בין 07 ל-08 (אין הערה = לא לגעת).

### תנאי סגירה סופית

אייל כותב `אושר ע״י אייל` בעמודת האנוש — אחרי שהוא רואה את הסטייג'ינג וממלא H-01 / H-06 / H-07.

### שיטת הפלייסהולדר (הוראת team_00)

סקשן שהמבנה של אייל מחייב אך התוכן שלו טרם התקבל — **בונים אותו עם פלייסהולדר גלוי**:
טקסט גיבריש + **קופסה במקום התמונה שכתוב בה מה נדרש**. כך המבנה ניתן לסקירה, ואייל רואה
בדיוק איזה חומר חסר לו.

⚠ **זה אינו סותר «אין תוכן = אין רכיב».** הכלל ההוא חל על **רשומה** שאין לה תוכן (שם בלי
המלצה). כאן מדובר ב**סקשן שהמבנה מחייב** — הפלייסהולדר הוא בדיוק הדרך להראות שהוא נדרש.

### תנאי סגירה לדף הבית

פרקים 01–12 קיימים ובסדר · פלייסהולדרים ל-03 ו-09 · מספור רצוף · verdict חוצה-מנועים PASS ·
`qa_probe` דסקטופ נקי · אפס רכיבים ריקים · הטאב מלא · ואז **הגשה לאייל**.
העמוד ייסגר סופית רק כשאייל יכתוב `אושר ע״י אייל` בעמודת האנוש.

## ב.2א גל רמה-ראשונה — נעול ונסגר ברמת שערים

סקואופ 18.8.26: `R1-06, R1-10, R1-16, R1-20, R1-21, R1-22, R1-23, R1-24 בלבד`.
חמשת הבנויים עברו א׳+ב׳. שלוש הקפאות מנומקות. **מפקד ניווט PASS** (`VERDICT-S006-WAVE1-NAV-MUSTER-2026-08-18.md`). **אין לפתוח מחדש** R1-01…R1-05 / R1-26.

חי גל:
- http://eyalamit-co-il-2026.s887.upress.link/shop/
- http://eyalamit-co-il-2026.s887.upress.link/books/
- http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/
- http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/
- http://eyalamit-co-il-2026.s887.upress.link/contact/

## ב.2ב גל כלים — נעול ונסגר ברמת שערים

סקואופ: `R1-11, R1-12, R1-13, R1-14, R1-15`. **מפקד כלים PASS** (`VERDICT-S006-WAVE2-TOOLS-MUSTER-2026-08-18.md`). האב `/shop/` לא נפתח מחדש.

חי גל:
- http://eyalamit-co-il-2026.s887.upress.link/repair/
- http://eyalamit-co-il-2026.s887.upress.link/didgeridoos/
- http://eyalamit-co-il-2026.s887.upress.link/bags/
- http://eyalamit-co-il-2026.s887.upress.link/stands-storage/
- http://eyalamit-co-il-2026.s887.upress.link/stand-floor/

## ב.2ג גל remainder — נעול ונסגר ברמת שערים (סשן 9)

סקואופ team_00: `R1-17, R1-18, R1-19, R1-25, R1-28` + הקפאת `R1-07, R1-08, R1-09, R1-27`.
חמשת ההדבקות עברו א׳ חוזה + ב׳ E2E/אקסל. **מפקד remainder PASS** (`VERDICT-S006-WAVE3-REMAINDER-MUSTER-2026-08-18.md`). **אין לפתוח מחדש** `/books/` הורה · `muzza-defaults.php` · `block-faq-list.php`. WP-EI-03 נשאר ON_HOLD.

חריג FAQ (נימרוד 18.8.26, כתוב): האתר שומר את כל השאלות הקיימות, בלי כפילויות, עם הירו; במחלוקת — נוסח אייל מ-`FAQ FINAL.md`. טבלת מיזוג: `_COMMUNICATION/team_100/S006/RESEARCH-R1-25-FAQ-MERGE-TABLE-2026-08-18.md`.

חי גל:
- http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/
- http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/
- http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/
- http://eyalamit-co-il-2026.s887.upress.link/faq/
- http://eyalamit-co-il-2026.s887.upress.link/snoring-sleep-apnea/

## ב.2ד גל תיקון SEO + סבב בקרה — נעול ונסגר ברמת שערים (סשן 10)

סקואופ: ניקוי כרום צוות 80 במטא שיתוף + רישום FAQ-05/06/07 בלי המרת URL. חוזה א׳ PASS · E2E ב׳ PASS · שלוש עדשות בקרה PASS.  
artifact: `_COMMUNICATION/team_100/S006/FINDINGS-S006-CONTROL-ROUND-2026-08-18.md`

**הבא (תור מוצע, לא סקואופ):** תשובות אייל על הסעיפים ב־ב.3 — טופס Hub: `s006-review.html`.

## ב.2ה גל WAIT-WAVE — נעול ונסגר ברמת שערים (סשן 11)

סקואופ: `WAIT-WAVE-2026-08-18 בלבד` (יישום תוכנית האורקסטרציה אחרי מעבר ל-Agent). ב (מועמדי מדיה) מחוץ לגל. ד התמזג ל-א (אותו glob FTP).

| זרם | מצב | מאמת `composer-2.5` ≠ בנאי Grok |
|---|---|---|
| W1 היגיינה + glob | R1-29 הוקפא · Hub `מוקפאים (8)` כולל קורסים · 40 mu-plugins הועלו אחרי PASS | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-WAIT-WAVE-W1-2026-08-18.md` |
| W2 מפת 129 | CSV מלא, HTTP+חבילה בלי תא ריק, 12/12 מדגם HEAD, אפס PHP | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-WAIT-WAVE-W2-2026-08-18.md` |
| W3 דסקטופ ייעודי | בסיס 21/21 overflow false · 0 `console.error` · Lighthouse ארטיפקט · 0 תיקוני CSS/JS · OPT-R3 למשותף/מובייל/GA | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-WAIT-WAVE-W3-2026-08-18.md` |

מפה: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/R2-INTAKE-MAP-2026-08-18.csv`  
OPT-R3: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/OPT-R3-REGISTER.md`  
Hub: http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s006-review.html

**מה לא נסגר בכוונה:** אישור אייל, בנייה לסבב 2, מובייל, CSS משותף, S007, חיתוך לפרודקשן, מועמדי מדיה. C-07/C-08 קיבלו תשובת אייל במפה — **לא יושמו**.

## ב.2ו מיפוי הערות אייל 19.8.26 — נעול כמפה, לא כביצוע (סשן 12)

חבילה בתיקיית דרייב (25 קבצים). מיפוי בלבד. אין PHP / Hub / טרקר / FTP בסשן הזה.

מפה: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/MAP-S006-EYAL-R1-NOTES-2026-08-19.md`  
פרומט מימוש: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/ONBOARD-PROMPT-R1-NOTES-IMPLEMENT-2026-08-21.md`

**הבא (תור מוצע, לא סקואופ):** יישום **זנבות** מחבילת 19.8 — לא בנייה מחדש של סבב 1, לא דריסת 62 `בוצע`.  
תוכנית מתוקנת: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/WAVE-PLAN-S006-R1-ANSWERS-2026-08-21.md`  
גל זנב א מוצע: H-01 מחיקת ציר · T-01 הורדת compare · LSN-09. «להשאיר» = אפס PHP.

## ב.3 ממתין לאייל — שאלות כתובות כבחירה מרשימה

**סטטוס 21.8.26:** רוב השורות למטה **נענו בחבילת 19.8** (מפה §2). הריקים שעדיין אצלו: **FAQ-04** · **SNR-04**. R1-15 אקסל ריק. אל תפתחו מחדש כ«ממתין לאייל» בלי לקרוא את המפה. הרשימה למטה היא הארכיון של מה שנשלח — לא מצב חי.

**גל remainder (חדש 18.8.26):**
**`/books/kushi-blantis/` (R1-17) — 5:** KSH-01 הירו · KSH-02 גלריה · KSH-03 עיתונות · KSH-04 עוד רגעים · KSH-05 `/about/` 404
**`/books/tsva-bekahol/` (R1-18) — 4:** TSV-01 הירו · TSV-02 גלריות · TSV-03 עיתונות · TSV-07 מנדלי 404
**`/books/vekatavta/` (R1-19) — 2:** VKT-01 הירו · VKT-02 גלריה
**`/faq/` (R1-25) — 5:** FAQ-01 הירו · FAQ-04 אישור טבלת מיזוג · FAQ-05 מאמר הריון 404 · FAQ-06 `/muse` 404 · FAQ-07 הכשרה 404
**`/snoring-sleep-apnea/` (R1-28) — 4:** SNR-01 מכבי.jpg · SNR-02 יוני.jpg · SNR-03 אישור יוני · SNR-04 מקור שלישי

**גל כלים (לא לפתוח מחדש):**
**`/repair/` (R1-11) — 2:** REP-01 תמונות · REP-02 המלצות
**`/didgeridoos/` (R1-12) — 2:** DG-02 תמונות · DG-03 אביזרים
**`/bags/` (R1-13) — 3:** BAG-03 הירו/split · BAG-04 גלריה · BAG-05 bleed
**`/stands-storage/` (R1-14) — 2:** STN-01 הירו · STN-02 לאורך העמוד
**`/stand-floor/` (R1-15) — 2:** FLR-01 הירו/02 · FLR-02 03/04/06

**גל רמה-ראשונה (לא לפתוח מחדש):**
**`/shop/` (R1-10) — 2:** SHP-01 תמונות הירו/סדנה · SHP-02 תמונות אביזרים
**`/books/` (R1-16) — 3:** BK-04 הירו · BK-05 עטיפות · BK-06 תמונת חבילה
**`/eyal-amit/` (R1-21) — 3:** ABT-08 בחירת גרסה (א׳/ב׳/שתיהן) · ABT-02 תמונות · ABT-05 ויקיפדיה
**מוקש (R1-22) — 6:** MK-02 תמונות · MK-03 וידאו · MK-04 גלריה · MK-05 הטמעות · MK-06 ציר · MK-07 bleed

**עמודים קודמים (לא לפתוח מחדש):**

**דף הבית (R1-01) — 3:** H-01 ציר זמן · H-06 קישורי וידאו · H-07 מדיה לפרק 9 (הפלייסהולדר בנוי — **ניתן להצגה**)
**`/treatment/` (R1-02) — 2:** T-01 בחירת גרסה (מוצע מול מסמך) · T-02 סרטון מפגש
**`/method/` (R1-03) — 1:** MTH-01 תמונות הירו / «מהי השיטה»
**`/lessons/` (R1-04) — 3:** LSN-01 תמונות הירו/ספליט · LSN-02 וידאו «איך נראים השיעורים» · LSN-09 קישור מאמר הריון (404)
**`/sound-healing/` (R1-05) — 2:** SH-01 תמונות הירו/ספליט · SH-02 וידאו «איך זה עובד»
**`/testimonials` (R1-26) — 4:** M-01a דן ארליכמן · M-03 כותרת העמוד · M-04 מדיה · M-05 כפילויות

**הוסרו מרשימת אייל** (החלטת team_00 17.8.26): סדר הפרקים ופער המספור — שניהם שלנו, לא שלו.

## ב.4 ממתין לנימרוד

שורת סקואופ ל**זנבות** 19.8 (לא סבב 1 מחדש). 62 בוצע נשארים. תוכנית מתוקנת: WAVE-PLAN-S006-R1-ANSWERS-2026-08-21.md

לפני/בתוך הגלים (מפה §3+§4):

1. כרום משותף: הסרת chap קטן + חצי קרוסלה (נוגע ל-`chapters.css` / קרוסלה) — כן/לא בסבב 1.  
2. «פיסקה מנצחת» עד 50 מילים מ-docx — ציטוט רציף בלבד, או עריכה.  
3. בלבול FLR מזהים ב-R1-14 מול R1-15 ריק.  
4. FAQ-06/07 כותרות בלי URL; FAQ-04 + SNR-04 ריקים.  
5. הפשרת R1-08 הרצאות + R1-09 סדנאות (יש md FINAL).  
6. IA: פיצול `/shop/` לרשת שירותים; ניווט ספרים; FAQ מלשוניות סדנאות/הרצאות/נחירות.

הקפאות שעדיין בלי חבילה: R1-06 · R1-07 · R1-20 · R1-24 · R1-27 · R1-29. R1-23 הוגש כקיים.

## ב.5 נסגר ברמת נימרוד בסשן הזה

סשן 12 (21.8.26): מיפוי 25 קבצי «הערות … 19.8.26». אפס יישום. מפה + פרומט אונבורד לסשן מימוש.

הקפאת R1-07/08/09/27 בלי PHP (אין חבילת אייל ב-`content 13.8.26/` ב-18.8 — **08/09 קיבלו md ב-19.8, עדיין מוקפאים עד סקואופ**). הכרעת FAQ CPT 18.8.26: כל השאלות הקיימות, בלי כפילויות, עם הירו; במחלוקת — נוסח אייל האחרון.

סשן 11 (WAIT-WAVE): הקפאת R1-29 · CODE-BLOCKED C-02/C-03 יושב, C-01 חלקי · glob FTP + 40 mu-plugins חיים · מפת סבב 2 129/129 · בסיס דסקטופ 21/21 בלי תיקוני CSS ייעודיים · שלושה verdicts PASS.

סשן 10: ניקוי `og:description` צוות 80 ב-`/testimonials/` (H1 לא נגע). FAQ-05/06/07 נרשמו לאייל; שלושת ה-href נשארו כבמסמך. סבב בקרה משולש PASS.

סשן קודם: M-01b דרור מצליח · M-01c קרן אברשי · M-01d שיילי פיינברג — שלושה כרטיסים ריקים שהיו כפילות שם.

## ב.6 חוב פתוח — לא חוסם *(ארכיון; C-07/C-08 למטה מבוטלים — ראו «לא פתוח» למעלה)*

- ~~**C-07** לא יושם~~ → **יושב** 21.8 + אומת DOM 30.8.
- ~~**C-08** לא יושם~~ → M-01a `בוצע` בטרקר.
- `ftp_deploy_site_wp_content.py` עבר ל-`glob('*.php')` + `MU_PLUGIN_DENYLIST` ריק; 40/40 הועלו לסטייג'ינג אחרי W1 PASS. להוסיף שם ל-denylist רק עם סיבה כתובה.
- דריפט גברנס `validate_aos` checks 11/13/65 — קיים גם על עץ נקי, לא נגענו במכוון
- סטיות מנוע זמניות → `_COMMUNICATION/team_120/`
- JSON של טאבי סעיפים (`r1-*-items.json`) הוא תמונת מחקר; SSoT סטטוס = xlsx / `latest-items.csv`
