# Canon map validation — lane 1: rulings vs map — VERDICT

**Validator:** Cursor Grok 4.6 (engine ≠ builder Claude / team_10). **Date:** 2026-09-28.
**Mandate:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/canon-validation/LANE-1-RULINGS-VS-MAP.md`
**Read-only** except this file. Hebrew quotes in «» from team_00 (CANON-STAGE-A-STATE.md §3) are the authority.

**Inputs compared**

| # | File |
|---|---|
| (1) | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/CANON-STAGE-A-STATE.md` §3 D1–D62 |
| (2) | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/EYAL-WORKSPACE/CONTENT-TYPES-CANON.md` |
| (3) | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/canon-map/tools/canon_types.py` |
| (4) | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/canon-map/ea-canon-map.html` |
| (5) | `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/canon-map/grids.html` |

**Method.** Every D-row whose Hebrew quote approves or rules a visual/type fact was traced into (2)(3)(4). Every «מאושר» example in (4), every rule in (3), and every APPROVED block in (2) was traced back to a D-row. Later D-rows override earlier ones (D29→D32, D21→D24, D22→D28, D46 K-4.2→D50, D54). Statuses in (3) and (4) were checked against D62 and against check E.

**What agrees (not findings).** Map and `canon_types.py` both have 18 current rows; statuses match D62 (13 מאושר / 4 מאושר בחלקו / 1 פתוח). Text columns 2–5 (D32), gutter 10px (D28), hero 92/66/44svh and button 5–6 (D17/D24/D27), CTA text 1–4 (D23), K-4.2 stacked block (D50), 16 locked K-n.m in `grids.html`, five tones + per-tone text (D34/D35), TOC ≥1,400 words (D55), eyebrow never repeats heading (D61), `open.html` has 0 pictured proposals. Justify, fill/fit as a shared variant, and the thin card frame are written in Grid rules / SITE_RULES.

---

## Findings

### L1-1 · D · fix

- **Where:** (2) index + Tier 1 §§1–37 (`CONTENT-TYPES-CANON.md` lines 63–175 and 228–764) vs (3) `GROUPS` (18 ids) vs (4) 18 `details.cm-row` vs (2) Grid-rules audit table lines 142–174.
- **Ruling:** D49 «מאשר 2–5 לכולם, ממשיכים.» · «בואו ננעל את השלב הזה, נעדכן את המפה חזרה יפה למצב המקורי, לפי הסוגים העדכניים»; D40 35 types → 14 + P-1/P-2 + shared state; D51 added S-2; D62 «יש לסמן נכון במפה, לוודא שכל הטיפוסים מתועדים מדויק.»
- **What is wrong:** (3) and (4) document the merged 18. (2) still inventories 37 row types as the working index (type N = T-N), keeps separate live entries for types that the map retired into variants (5 fold, 7 float, 9–37 except the two retired heroes), and its own pairing rule (lines 16–17, 1004–1007) calls a change to one without the other a defect. The audit table then grades old IDs (T-04 «✓ approved», T-06 «✓ approved») while the map marks the merged T-04 and T-06 «מאושר בחלקו». A builder cannot tell which inventory is current.
- **Severity:** fix

### L1-2 · C · fix

- **Where:** (2) type 37, line 758: `bg ∈ ivory | ivory-2 | dark | cta` · «No fifth background without a new SSOT decision.»
- **Ruling:** D34 «מאשר את חמשת הגוונים»; D41 A-1 «רקע — מראש לתקן את כולם לגוון הקאנוני הקרוב ביותר»; D35 five text sets (ivory, sand, olive, terracotta, dark). Ivory-2 is not one of the five; D33 forbade leftover tones that fail.
- **What is wrong:** Type 37 still treats ivory-2 as an approved background and denies a fifth tone after D34 locked five (including sand / olive / terracotta, none of which appear in that `bg` list). Stale relative to D34/D41.
- **Severity:** fix

### L1-3 · C · fix

- **Where:** (2) «Stage-A review list» lines 938–962 (Table A: hero heights, CTA shapes, prose fold/dark, split crop/zoom, float sizes, FAQ cards, gallery portraits, video placeholders — each still «Needs: Decision»).
- **Ruling:** D17 «מאשר את הגבהים ואת הכפתור»; D19/D23 CTA; D34/D35 tones; D36 split; D52/D61 contact; D55 TOC; D58 «השאר אישרתי»; D62 «כל הפתוחים מאושרים.»
- **What is wrong:** The review list still presents those items as unmade decisions. They have been ruled. The list is superseded and will send a later session back into closed questions.
- **Severity:** fix

### L1-4 · A · fix

- **Where:** (2) Buttons, lines 820–823 (only D25 padding) vs (3) S-2 lines 101–104 vs (4) S-2 row (five tone examples).
- **Ruling:** D51 «O-8, O-9, O-10, O-12, O-13, O-15, O-16, O-18, כל הכפתורים — כל אלו סבבה, מאושר.» (filled/outline = the tone’s link colour); D25 «פחות ריווח סביב הטקסט בכל הכפתורים.»
- **What is wrong:** D51’s button system is in (3) and (4). (2)’s only APPROVED block for buttons records D25 (`9px 18px` / 44px tall) and the hero/CTA 5–6 cell, not the five-tone filled/outline rule that D51 moved into the map as S-2. Pairing is broken on the approved button spec.
- **Severity:** fix

### L1-5 · A · fix

- **Where:** (3) T-26 rules lines 77–81; (4) T-26 row; (2) type 26 lines 605–615 (no APPROVED block, no per-page video rule).
- **Ruling:** D8 «כל עמוד מקבל סרט משלו.»
- **What is wrong:** The Hebrew rule does not land in (2), (3) or (4) as a type rule. T-26 is marked מאושר with columns 2–5 (D49/O-18) only. Treatment deferred (O2) does not cancel the site-wide ruling; it is simply unrecorded.
- **Severity:** fix

### L1-6 · A · fix

- **Where:** (3) T-08 rules lines 84–87: only «טקסט בטורים 1–4, כפתור בטורים 5–6» and phone-left. (4) T-08 `.cm-rules` is the same pair. (2) type 8 APPROVED lines 387–397 does have both facts.
- **Ruling:** D23 «הלוגו — להצמיד לקצה המסך.» · D11 «no button without a heading and sub-heading» (state file: closed rule; type 8 APPROVED restates «Full form only: heading + text + button»).
- **What is wrong:** Check A requires the ruling in (2), (3) and (4). Logo pinned to the screen edge and the closed full-form rule are in (2) and (for the logo) in the T-08 example *label* in (4); they are missing from the typed rules in (3) and from the map’s T-08 כללים list. Weakened in the map spec the next session will copy.
- **Severity:** fix

### L1-7 · B · fix

- **Where:** (4) S-1, line 2536, example labelled «מאושר — כמו כל פסקה: כותרת בטורים 1–6, הטקסט בטורים 2–5, הסרטון ברוחב מלא» (class `cm-variant cm-v-a` + `cm-spec cm-appr`). Same string is T-26’s approved example.
- **Ruling:** D41 A-5 «מאשר לעשות אחיד, עם צבע בולט»; D49/D51 O-18 is the video *paragraph* (T-26), not the pending state.
- **What is wrong:** S-1’s only «מאושר» example is labelled with T-26’s ruling. S-1’s own approved fact is the pink-stripe / dashed `#D6006F` look (definition in (3) line 106; CSS in (4) lines 185–190). Check B: a «מאושר» label must trace to the ruling that actually applies to that row. This one does not.
- **Severity:** fix

### L1-8 · D · fix

- **Where:** (3) T-26 olds include `("T-27", "סרטון שעוד לא הגיע")` (line 77); S-1 olds include `("T-27", "סרטון שעוד לא הגיע")` (line 105). (4) T-26 «היום באתר — T-27»; S-1 «היום באתר — T-27».
- **Ruling:** D40/D41 A-5 one pending look; D4 map placeholders. D62 asks for types documented accurately.
- **What is wrong:** T-27 has two homes. (3) and (4) disagree with a one-id-one-row map. The pending video is both a T-26 variant and the S-1 state.
- **Severity:** fix

### L1-9 · E · fix

- **Where:** (4) S-2 `c-use` / «שימושים באתר — כרגע לא בשימוש» (around line 2528); (3) S-2 `olds=[]` so the census prints unused. Definition: «כל כפתור באתר».
- **Ruling:** D51 «כל הכפתורים — … מאושר»; D3 «כרגע לא בשימוש» is for types with no live instance (the T-37 dummy), not for the site-wide button.
- **What is wrong:** A type marked מאושר whose definition is every button on the site cannot honestly say it is unused. Check E: the status badge is מאושר, but the uses line is the unused mark, which is false.
- **Severity:** fix

### L1-10 · E · fix

- **Where:** (3) T-29 rules line 29: only «בטורים 2–5, כמו טקסט רץ (מאושר)». (4) T-29 כללים: the same one line; examples are only «היום באתר». `open.html` «החלטות בלי תמונה» lists accordion, float, photo-band/collage/studio — not year lists.
- **Ruling:** D62 «partly 4 with the reason in their rules — … year lists (not drawn beyond the columns)».
- **What is wrong:** Check E: מאושר בחלקו must name what is missing. T-29 does not. D62’s reason is only in the state file, not in the map row or in `open.html`.
- **Severity:** fix

### L1-11 · D · fix

- **Where:** (2) Grid rules §8 line 139 «below 761px»; (3) SITE_RULES «טלפון» line 117 «מתחת ל-761 פיקסלים»; (2) type 1 APPROVED line 255, type 4 line 305, type 6 line 362, type 8 line 397 — all «Below 760px».
- **Ruling:** D31 «במסך צר — הירו + CTA — כפתור תמיד מיושר לשמאל»; D36 «one column below 760px» (builder’s English); D46 phone two-column image grids.
- **What is wrong:** Check D: a number disagreement — 760 vs 761 — between the written canon’s type APPROVED blocks and the Grid rules / map SITE_RULES. Same breakpoint stated two ways is still two numbers in the three documents.
- **Severity:** fix

### L1-12 · A · note · uncertain

- **Where:** (4) T-23, P-1, P-2, T-21, T-29 — no `cm-variant cm-v-a` / «מאושר — …» example (only «היום באתר»). T-10 correctly has none (פתוח).
- **Ruling:** D49 approved columns 2–5 for accordion, year lists, TOC and inline video; D55 «מאשר את כלל תוכן העניינים»; D40 A-9 / D49 templates as a second layer; D62 «יש לסמן נכון במפה».
- **What is wrong:** Types the map marks מאושר (T-23, P-1, P-2) have no blue example of the approved placement. Partly-approved T-21/T-29 also never show the approved 2–5 columns as «מאושר». Uncertain whether D55/D49 required a drawn example or only the rule — still a gap against «the map shows every approved example blue» (D53).
- **Severity:** note

### L1-13 · A · note

- **Where:** (3) S-2 rules «ריווח מצומצם סביב הטקסט» (line 104); (4) S-2 כללים same words. Exact `9px 18px` lives in (2) Buttons APPROVED (line 821) and in (4) CSS `--cm-btn-pad-block:9px;--cm-btn-pad-inline:18px` (line 57).
- **Ruling:** D25 «פחות ריווח סביב הטקסט בכל הכפתורים. זה בכל מקרה.»
- **What is wrong:** The ruling’s numbers are not in the map’s typed rules, only in CSS and in (2). Weakened in (3)/(4) spec text; implemented in the overlay.
- **Severity:** note

### L1-14 · A · note · uncertain

- **Where:** (4) P-2 «היום באתר — T-37 «פוסט בלוג — תבנית חדשה»»; (3) P-2 variant «חדש»; no «כרגע לא בשימוש» on that variant (P-2 uses-count is 52 via T-34).
- **Ruling:** D3 dummy content, clearly marked; «כרגע לא בשימוש» instead of a proof link.
- **What is wrong:** After D49 merged T-37 into P-2, D3’s unused mark is gone. Uncertain whether the merge was meant to retire that mark.
- **Severity:** note

### L1-15 · C · note

- **Where:** (4) CSS comments lines 191–193 still «Proposal (T-05 fold…)»; line 204 «Proposal (grid discipline)». The fold example itself is labelled «מאושר» (T-04).
- **Ruling:** D58 «השאר אישרתי.» (O-1 fold); D44 grid discipline approved in his words.
- **What is wrong:** Comments in the published map still call approved work a proposal. Stale wording next to a blue badge.
- **Severity:** note

### L1-16 · A · note · uncertain

- **Where:** (3) T-01, T-18, T-26, T-31 have no variant «גודל התמונה (משותף) מילוי · התאמה». SITE_RULES line 115 and (2) Grid §4 / Canon terms say every type that carries an image has that variant. T-06, T-09, T-11 do list it.
- **Ruling:** D36 «fill או fit — שוב זה פרמטר בטיפוס. לכולם, לא טיפוס נפרד.»; D48 «כל טיפוס שיש לו תמונה — יש וריאנט לדרך חישוב גודל התמונות.»
- **What is wrong:** Hero media, contact portrait, video poster, testimonial avatar do not expose fill/fit. Uncertain: full-bleed cover (hero, photo band) may be outside the cell variant. Still a gap against «לכולם».
- **Severity:** note

---

## Check summary

| Check | Result |
|---|---|
| A · every ruling in map + canon + types | Fail — D8, D11/D23 in T-08 rules, D51 in (2) Buttons, D62 reason on T-29 |
| B · nothing unapproved labelled «מאושר» | Fail — S-1 example wears T-26’s label |
| C · latest ruling wins | Fail — type 37 ivory-2; Stage-A review list; (2) still pre-merge |
| D · (2)(3)(4) agree | Fail — 37 vs 18 types; 760 vs 761; T-27 double-home; T-04/T-06 status |
| E · statuses honest | Fail — T-29 unnamed gap; S-2 «unused» |

Supersessions that **do** follow the latest (not findings): D29 text 2–6 → D32 2–5; D21 one-cell button → D24 columns 5–6; D22 4px gutter → D28 10px; D19 CTA 2–4 → D23 1–4; D46 K-4.2 as 2+1+1+2 → D50 stacked block; D54 terra button 4.63 / `#B05F38` in `palette-check.html` (not the old 4.26 / `#B5663D` fail claim).

(n) counts blockers and fixes; notes are listed and not counted.

VERDICT: FINDINGS (11)
