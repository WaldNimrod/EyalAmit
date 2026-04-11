# Build Package: S002 Session 1
# Team 110 (eyalamit_build) — חבילת פיתוח לפני פגישה עם אייל
# Date: 2026-04-12 | Authored by: eyalamit_arch (Team 100)

---

## הקשר — למה הסשן הזה מוגדר כך

מחר בבוקר (2026-04-13) יש פגישה עם אייל עמית.

**מה חסר ואי-אפשר לבנות ללא אייל:**
- דף אודות (About) — אין תוכן בכלל
- דף בית Hero — נוסח H1 זקוק לאישור סופי של אייל
- IA ניווט — החלטות על רמה ראשית לעומת sub-menu פתוחות

**מה קיים עם תוכן מלא מאייל — ניתן לבנות עכשיו:**

| עמוד | pageId | תוכן קיים | מקור |
|------|--------|-----------|------|
| טיפול בדיג'רידו | `st-svc-treatment` | מלא — 14 בלוקים, FAQ, המלצות, CTA, דיסקליימר | `EYAL-CONTENT-PKG-2026-04-09-st-svc-treatment` |
| השיטה (cbDIDG) | `st-method` | מלא — H1, INTRO, כל הסקציות | `final_st-method_2026-04-10_SINGLE.md` |

**הגיון:** עדיף להגיע לפגישה עם שני עמודים ראשיים חיים בסטייג'ינג מאשר עם אפס. אייל יראה את התוצר בפועל ויוכל לאשר/לתקן.

---

## משימה 1 — דף טיפול (st-svc-treatment)

### WP: S002-P001-WP003 (Services page)

**תבנית PHP ליצור:**
`site/wp-content/themes/ea-eyalamit/page-templates/template-treatment.php`

**מקור תוכן מלא:**
`docs/project/eyal-ceo-submissions-and-responses/from-eyal/CONTENT/EYAL-CONTENT-PKG-2026-04-09-st-svc-treatment/`

קבצים:
- `2026-04-09--st-svc-treatment--content--from-eyal.md` — כל הטקסטים
- `2026-04-09--st-svc-treatment--developer-brief--from-eyal.md` — הוראות UX + סדר בלוקים
- `2026-04-09--st-svc-treatment--faq--from-eyal.md` — שאלות נפוצות
- `2026-04-09--st-svc-treatment--testimonials--from-eyal.csv` — המלצות

**סדר בלוקים (מהדרגנות של developer-brief):**
1. Hero (H1 + subheadline + CTA)
2. Intro
3. What is Didgeridoo Therapy
4. Who is it for
5. How the Process Works
6. Self Healing
7. Differentiation
8. Personal Story
9. Research
10. Testimonials (carousel — 4 desktop, 1-2 mobile)
11. FAQ (accordion)
12. CTA
13. Disclaimer
14. Footer

**UX notes מה-brief:**
- RTL מלא
- כל 2–3 בלוקים: תמונה או שבירה ויזואלית
- צילום ריאליסטי בלבד (לא AI)
- קרוסלת המלצות: ACF repeater מועדף

**Hero copy (מוכן לשימוש ישיר):**
```
H1: משהו בנשימה שלך מבקש תשומת לב
Subheadline: דרך הדיג'רידו וליווי אישי תלמדו לעבוד עם הנשימה, להקשיב, לדייק ולהחזיר אותה למקום טבעי, רגוע ומאוזן
CTA: לתיאום שיחת היכרות
```

---

## משימה 2 — דף השיטה (st-method)

### WP: WP חדש — S002-P001-WP005 (יאותחל ע"י Team 100 לאחר confirmation)

**תבנית PHP ליצור:**
`site/wp-content/themes/ea-eyalamit/page-templates/template-method.php`

**מקור תוכן מלא:**
`docs/project/eyal-ceo-submissions-and-responses/from-eyal/CONTENT/EYAL-CONTENT-PKG-2026-04-10-st-method/final_st-method_2026-04-10_SINGLE.md`

**Hero copy:**
```
H1: שיטת cbDIDG – עבודה עם הנשימה באמצעות דיג'רידו
```

**מבנה הדף (מהקובץ):**
1. H1 + INTRO
2. "איך בנויה השיטה" (H2)
3. תיאור מנגנון ה-cbDIDG
4. רקע אייל + מוקש דהימן (מסורת)
5. CTA לשיחת היכרות

**Slug:** `/method`

---

## Acceptance Criteria — שתי המשימות

לפני L-GATE_B על כל עמוד:

- [ ] תבנית PHP קיימת ומוגדרת נכון
- [ ] כל הטקסטים מהחבילה מוטמעים (אין placeholder)
- [ ] RTL תקין בכל הבלוקים
- [ ] Mobile responsive — אין overflow
- [ ] דף פורסם ב-WP admin (status: published)
- [ ] FTP deploy לסטייג'ינג: `http://eyalamit-co-il-2026.s887.upress.link`
- [ ] validate_aos.sh — 12 PASS / 0 FAIL
- [ ] LOD500_asbuilt.md כתוב

---

## פקודות Deploy

```bash
# Hub build + deploy (רק אם שינית hub/data/*.json)
python3 scripts/build_eyal_client_hub.py --skip-team40-legacy-media
python3 scripts/ftp_publish_eyal_client_hub.py

# AOS validation
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .
```

---

## מה לא לגעת בו הסשן הזה

- `hub/data/site-tree.json` — שינויי IA ממתינים להחלטת אייל מחר
- `_aos/roadmap.yaml` — כותב יחיד: eyalamit_arch
- דף הבית (Home) — Hero טקסט ממתין לאישור אייל
- דף אודות (About) — אין תוכן

---

## מה לדווח לאחר הסשן

כתוב artifact ב-`_COMMUNICATION/team_110/` עם:
1. סטטוס כל עמוד (built / FTP deployed / URL בסטייג'ינג)
2. תוצאת validate_aos.sh
3. לינקים לעמודים בסטייג'ינג לבדיקת Nimrod לפני הפגישה

*Build package authored by eyalamit_arch (Team 100) | 2026-04-12*
