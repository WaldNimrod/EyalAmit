# for-eyal — חומרים לפגישות / הכנה מהירה

**אפיון ויזואלי:** בכל עמוד ציבורי באתר החדש תהיה **תמונת כותרת (Hero) ייעודית** לעמוד — המוקאפים למטה ממחישים זאת; ראו גם אפיון §6 (IA) ב־`SITE-SPECIFICATION-FINAL`.

תיקייה זו **אינה** מחליפה את חבילת ההגשה הרשמית ב־[`../to-eyal/`](../to-eyal/) (Word/PDF לאישור חתום).

כאן נשמרים **תזכירי פגישה** ומסמכים חד־פעמיים שמסכמים נעילות + מפה + שאלות פתוחות.

## ייצור תזכיר פגישה (Word)

```bash
python3 scripts/build_eyal_meeting_brief_docx.py
```

נוצרת תיקייה בתבנית `YYYY-MM-DD--meeting-brief/` עם קובץ  
`YYYY-MM-DD--meeting-brief-for-eyal--v1.docx`.

הסקריפט: [`../../../scripts/build_eyal_meeting_brief_docx.py`](../../../scripts/build_eyal_meeting_brief_docx.py).

## תרשים ויזואלי — כיווני דף הבית

- [`assets/home-directions-visual.html`](./assets/home-directions-visual.html) — פתחו בדפדפן (לפגישה עם אייל).  
- תמונות דוגמה: [`assets/home-preview/`](./assets/home-preview/) (הועתקו מ־`eyalamit.co.il-legacy/wp-content/uploads/`).

## עמוד נחיתה באנגלית (מוקאפ)

- [`assets/en-landing-page-preview.html`](./assets/en-landing-page-preview.html) — תוכן ראשוני, מבקר קצר.  
- מקור טקסט קנוני: [`../../team-100-preplanning/EN-LANDING-PAGE-CONTENT-DRAFT-2026-03-29.md`](../../team-100-preplanning/EN-LANDING-PAGE-CONTENT-DRAFT-2026-03-29.md)

## תנועה וקידום — הנחיות לאייל (SEO · AEO · GEO)

- מסמך מלא (Markdown): [`../../team-100-preplanning/EYAL-TRAFFIC-GROWTH-AEO-GEO-GUIDE-2026-03-29.md`](../../team-100-preplanning/EYAL-TRAFFIC-GROWTH-AEO-GEO-GUIDE-2026-03-29.md)  
- ייצוא Word: הריצו `python3 scripts/build_eyal_ceo_deliverables.py` — בחבילת `to-eyal/…final-spec-package-for-eyal/` יווצר קובץ `…eyal-traffic-aeo-geo-guide…docx`.

## מוקאפים נוספים (2026-03-31)

- [`assets/home-dashboard/index.html`](./assets/home-dashboard/index.html) — דף בית «דשבורד»: שלוש אופציות (צפיפות שונה + SEO).  
- [`assets/mockups/mockup-digital-course.html`](./assets/mockups/mockup-digital-course.html) — עמוד קורס דיגיטלי (תוכן זמני).  
- [`assets/mockups/mockup-lectures.html`](./assets/mockups/mockup-lectures.html) — עמוד הרצאות לארגונים (תוכן זמני).  
- [`assets/kmd-inventory-prototype.html`](./assets/kmd-inventory-prototype.html) — כלי KMD זמני (עריכה, העתקה, CSV).

אינדקס קבצים: [`assets/README.txt`](./assets/README.txt).
