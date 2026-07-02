# צ'קליסט פגישה — אייל · Chapters full-site · 2026-06-23

**לנמרוד בלבד** (מסמך פנימי — לא להגשה לאייל כ-.md).

**גרסה לעבודה (קישורים לחיצה):** [`MEETING-EYAL-CHAPTERS-2026-06-23-CHECKLIST.docx`](MEETING-EYAL-CHAPTERS-2026-06-23-CHECKLIST.docx) — העלה ל-Google Drive → פתח ב-Google Docs.

**Hub חי:** http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/  
**Staging:** http://eyalamit-co-il-2026.s887.upress.link/  
**גרסת Hub צפויה:** ≥1.9.0 · בנייה 2026-06-23

---

## לפני הפגישה (5 דק)

- [ ] Hub `index.html` — gate text: team_190 PASS + merge + M5 focus (לא «בעיצומה»)
- [ ] `meeting.html` — אג'נדה מעודכנת + קישור ל-content-proposals
- [ ] `tasks.html` — open count >4 (M5/M7 + EYL)
- [ ] staging — רענון `?nc=` על בית + מוקש + /en/ (F110-01 meta)
- [ ] מסך משותף: Hub + staging בטאבים

---

## 1. פתיחה (5 דק)

| נושא | מה לומר |
|------|---------|
| מה הושלם | Chapters על **כל האתר**; content-diff; team_50 + team_190 **PASS** |
| מיזוג | `chapters-home` → `main` @ 6d898a7 (23.6) |
| מה **לא** קרה | **eyalamit.co.il** עדיין legacy — cutover = **M7** |
| מסגרת | היום: סקירה + אישורים; אחרי: M5 → M6 → M7 |

---

## 2. סקירה חיה על staging (40 דק)

**סדר מומלץ** (מ-`meeting-brief.json`):

1. בית `/`
2. השיטה `/method/`
3. טיפול `/treatment/`
4. סאונד הילינג `/sound-healing/`
5. שיעורים `/lessons/`
6. אודות `/eyal-amit/`
7. מוקש `/eyal-amit/mokesh-dahiman/`
8. מוזה + 3 ספרים `/books/` …
9. חנות `/shop/` (5 מוצרים)
10. FAQ `/faq/`
11. בלוג `/blog/` + פוסט אחד
12. צור קשר `/contact/`

**במהלך המעבר:** הדגש verbatim, נגישות, wa.me, טפסים — לא «תיקונים טכניים».

---

## 3. אישורים ממך — לפי עדיפות (30 דק)

### עדיפות #1 — 15 הצעות תוכן SEO/GEO

- **דף Hub:** `content-proposals.html`
- **מנוף עסקי:** CP-01 פילר נחירות/דום נשימה
- **יעד:** אישור/דחייה/עריכה לכל הצעה; ייצוא JSON אם אפשר

### #2 — 48 עדויות

- **דף Hub:** `pending.html` + `materials-intake` (I1)
- **יעד:** אישור אופן הצגה + אצירה (אישור / תקציר / החרגה)

### #3 — מותג מושמט (WP-06)

- «סטודיו נשימה מעגלית» — השאר מושמט או ניסוח חלופי?
- קשור ל-BN-01 ב-content-proposals

### #4 — מדיה

- hero ל-4 עמודי שירות (A1)
- כריכות ספרים, מוצרי חנות, מוקש/גלריות
- **דפים:** `materials-intake.html`, `media-intake.html`

### #5 — משפטי + EN

- פרטיות / נגישות / תקנון — נוסח מאייל או אישור טיוטת צוות
- `/en/` — תקציר אנגלי לאישור

### #6 — Clarity (EYL-1)

- GA4 כבר פעיל; נדרש `project_id` לפני go-live

### #7 — וואטסאפ

- אישור +972 52-482-2842 (materials-intake WA)

---

## 4. סגירה (10 דק)

| שאלה | הערות |
|------|--------|
| M5 timeline | SEO pillar, מדיה, עדויות — מה חוסם? |
| M6 | design-QA responsive — אחרי מדיה |
| M7 יעד | תאריך רצוי ל-cutover ל-eyalamit.co.il |
| מה ממך השבוע | רשימה קצרה: proposals + 3 hero + Clarity |

---

## נקודות מפתח (אם נשאל)

- **למה לא עלינו ל-prod?** M7 מכוון; staging מאומת; חוסמים = תוכן/מדיה/אישורים
- **team_190?** PASS — VERDICT 23.6; F110-01 סגור
- **תוכן שונה?** לא — verbatim מהמקור; חריג יחיד מותג (מאושר נמרוד)

---

## קישורים מהירים

| דף | URL יחסי ב-Hub |
|----|----------------|
| כניסה | `index.html` |
| תדריך פגישה | `meeting.html` |
| הצעות תוכן | `content-proposals.html` |
| השלמות | `materials-intake.html` |
| משימות | `tasks.html` |
| מפת דרכים | `roadmap.html` |
