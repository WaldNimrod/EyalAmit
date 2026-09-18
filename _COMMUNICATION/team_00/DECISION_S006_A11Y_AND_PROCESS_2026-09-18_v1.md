---
id: DECISION_S006_A11Y_AND_PROCESS_2026-09-18_v1.0.0
schema_version: aos_v1_team_messaging
type: DECISION (team_00)
authority: team_00 (נימרוד)
recorded_by: team_100
date: 2026-09-18
status: LOCKED — binding on all S006/S007 sessions
decisions: [D-9, D-10, D-11, D-12, D-13, D-14, D-15, D-16, D-17, D-18, D-19, D-20, D-21, D-22, D-23, D-24]
continues: DECISION_S006_CONTACT_SUBJECT_2026-09-12_v1.md (D-8)
---

# החלטות team_00 · נגישות ותהליך · 18.9.2026

**למה הקובץ הזה קיים.** ההחלטות של הלילה נרשמו תחילה כאותיות בתוך דוח ביקורת —
`D-A` עד `D-J` — וזו הייתה **שיטת מספור רביעית** בפרויקט שכבר החזיק שלוש. היא מתנגשת
ברצף `D-1`…`D-8` הקיים, ושום דבר לא איגד ביניהן. **החלטה שנמצאת רק אם יודעים מראש
באיזה מארבעה מקומות לחפש אינה החלטה שמורה.** לכן כולן מומרות כאן לרצף אחד.

הפניה מהיר: [DECISION-INDEX.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_00/DECISION-INDEX.md)

---

## D-9 — אין ווידג'ט נגישות

**מקורו:** «בלי הוויגיט.»

**Canonical:** No accessibility overlay or toolbar widget is installed, on staging or in
production, as a conformance measure. Conformance comes from fixing the delivered page.
The existing wp-accessibility plugin stays as it is — it is near-inert; its own skip-link
feature is off and the working skip link is entirely our code. No second plugin.
**Consequence: the published statement may not cite a widget as an adjustment.**

---

## D-10 — ההצהרה מתעדכנת

**מקורו:** «מאשר עדכון ההצהרה.»

**Canonical:** The accessibility statement is rewritten to describe only adjustments
actually made, in the form «פועלים לפי» and never «עומדים», and it discloses that no
independent external audit was performed.

---

## D-11 — רכז נגישות בשם

**מקורו:** «שם — להוסיף עם הסבר ברור לאייל בטופס העדכני והאחרון שלו.»

**Canonical:** A named accessibility coordinator is added to the statement. The request goes
to Eyal in his current review form, with a clear explanation of what the name is for and why
the regulation asks for a person rather than only a phone number. He approves; he does not
compose. **Still open on Eyal.**

---

## D-12 — מדיניות כתוביות

**מקורו:** «כתוביות — סבבה תוסיפו.»

**Canonical:** A media policy sentence is added: we do not promise captions on every video,
and we offer a written alternative on request within a reasonable time.

---

## D-13 — באנר הטיוטה המשפטית נשאר

**מקורו:** «הטיוטה המשפטית — מופיע כטיוטה עד אישור של אייל לנוסח הסופי.»

**Canonical:** The WP-EI-05 draft banner stays on `/accessibility/`, `/privacy/` and
`/terms/` until Eyal approves the final wording. The rewritten statement therefore ships
**with** the banner on it. **This is an expected state, not a defect — a later audit must
not re-raise it.** **Still open on Eyal.**

---

## D-14 — סריקה אוטומטית נקייה אינה ראיה

**מקורו:** «הכלי האוטומטי — מקבל את ההמלצה ויש לתעד כך גם במסמכים שלנו שלא יחזור.»

**Canonical:** An automated accessibility scan may be reported only as "N violations found",
never as evidence of conformance. Any conformance claim requires human review of the specific
criterion on the specific page. **Proof:** axe-core returned 0 violations on the three book
gallery pages both before and after 162 content photographs were fixed — the tool's answer did
not change when the defect was closed, because it could never see it.
**Implemented as charter §8א clause 5.**

---

## D-15 — הבאנר בדף הבית נשאר, ומאומת

**מקורו:** «באנר דף הבית — כרגע זה מה שמוצג וצריך להיות תקין.» · «להשאיר ולוודא שהוא אמיתי.»

**Canonical:** The home page's video placeholder banner stays. Verified truthful — a video
genuinely is pending, and it carries `role="status"`. No edit. *The Lorem Ipsum body text
beside it is a content matter, out of accessibility scope, recorded for the content track.*

---

## D-16 — היקף: שכבה שנייה נכנסת, שלישית נרשמת

**מקורו:** «לקחת גם את השניה — את השלישית יש לרשום לנו ברור כחבילת עבודה פתוחה לביצוע
כולל קישורים למידע להגדרות ולמה שכבר בוצע.»

**Canonical:** P0 and P1 are executed in this milestone. P2 is written up as an explicit open
work package, each item carrying three links: to the source finding, to the standard's
definition, and to what has already been done nearby. Items that are **not** WCAG 2.0 AA
failures are grouped separately and labelled as recommendations.

---

## D-17 — רשימת הנושאים בטופס מתוקנת

**מקורו:** «רשימת הנושאים — מוזמנים לתקן.»

**Canonical:** The D-8 subject dropdown gains a blank prompt option. D-8 itself is unchanged:
the field stays, the dropdown stays, the option list stays. Not a WCAG failure — a
correctness defect, since every untouched submission mailed Eyal a wrong subject line.

---

## D-18 — סדר עדיפות מנועים הוא החלטת עלות

**מקורו:** «עדיפות 1 גרוק — יש הגדרות מסודרות. כשצריך רק עבודה שחורה — קומפוזר החדש, זה סהכ
גרסה חדשה. GPT יקר לנו בהרבה, זה בנק קטן שיש לנו ומשתמשים בו רק כשצריך חוד נוסף.»

**Canonical:** Engine order for cross-engine work: **Grok first**; `composer-2.5` for pure
black work; **GPT only when a genuine extra edge is needed** — it is a small, finite budget.
Iron Rule #1 is satisfied by all three, so the choice among them is purely economic.
`scripts/run_cross_engine_validator.sh` now defaults to Grok.

---

## D-19 — כפילויות תמונה מוסרות

**מקורו:** «בגלריה בדף הבית לדעתי באמת יש כפילות — זה מה שגם הוליד את כל המשימה.
מה שכן כפול מאשר להסיר.»

**Canonical:** Duplicate content photographs are removed where the same photograph appears
twice within one view. Removed: three from the home gallery (30 tiles → 27), two pairs on
`/books/tsva-bekahol/`, one pair on `/books/kushi-blantis/`. **Not removed and deliberately
so:** each book's own cover inside its own gallery (consistent across all three, therefore
intentional); a decorative background that legitimately repeats a content image; and the one
photograph appearing across two different book pages, which a visitor never sees twice in one
view and which is a question for Eyal.

---

## D-20 — טקסט חלופי מתוחזק על ידי סוכן, בתכנון

**מקורו:** «אני מאשר שזה יהיה דרך סוכן לעדכן את זה תמיד — אבל!!!! בגלריה ששלחנו לאייל…
יש להוסיף שם את כל השדות הרלוונטיים באותו מבנה שכבר קיים.»

**Canonical:** Alt text is maintained by an agent, not through wp-admin. This is the chosen
operating model, not a stopgap — the ACF unblocking work is **not scheduled and not wanted**.
Eyal's correction channel is the media picker: each image carries its current alt, the page
that renders it, and an editable correction field, in the same structure as the existing notes
fields. Where Eyal or Mukesh appears it is recorded as **structured, filterable data**, not
buried in a sentence.

---

## D-21 — S007 מתחיל בטיפוגרפיה בלבד

**מקורו:** «אנחנו מטפלים כרגע רק בנושא טיפוגרפיה — לא בתבניות של אלמנטים. זה יבוצע בנפרד.»

**Canonical:** The first S007 mandate covers type size, weight, line-height, letter-spacing
and line length only. Element templates, layout, spacing, imagery, grids and nav behaviour are
a separate later mandate, parked in `BACKLOG-S007-M02-ELEMENT-TEMPLATES.md`.

---

## D-22 — אישור טיפוגרפיה: סולם תחילה, אחר כך חריגים

**מקורו:** «סולם תחילה, אחר כך חריגים.»

**Canonical:** team_00 approves one scale against representative pages; afterwards we walk the
pages where it sits badly and correct pointwise. Two review rounds.

---

## D-23 — בדיקת נגישות חוזרת: ממוקדת עכשיו, מלאה לפני השקה

**מקורו:** «ממוקדת עכשיו, מלאה לפני השקה.»

**Canonical:** After each typography change, re-test only what typography can actually break —
contrast, the large-text threshold boundary, line length, reflow, tap targets, and every claim
in the published statement. One full re-audit before production.

---

## D-24 — החלה: עמודי דגל תחילה

**מקורו:** «קודם עמודי הדגל, אחר כך השאר.»

**Canonical:** The approved scale lands on three flagship pages first; team_00 lives with it;
then it widens to the rest.

---

## פתוחות מול אייל, לא מול נימרוד

**D-11** — אישורו לשמו כרכז. · **D-13** — אישורו לנוסח הסופי, שמסיר את באנר הטיוטה.
בנוסף: שש תמונות שממתינות לזיהוי, ותמונה אחת שמופיעה בשני ספרים.
