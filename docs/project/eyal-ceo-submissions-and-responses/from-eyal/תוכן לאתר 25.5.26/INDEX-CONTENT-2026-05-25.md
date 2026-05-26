# אינדקס — תוכן לאתר 25.5.26 (קליטה מאייל)

**תאריך קליטה:** 2026-05-25 (קבצים נוספו ב־25/05; אינדוקס בוצע ב־26/05/2026)
**מקור:** הגשת תוכן ישירה מאייל עמית (אחרי הפסקת הפעילות באפריל)
**מטרת המסמך:** מצביע יחיד לתוכן + מיפוי slug + פערים פתוחים. **לא** מחליף את נוהל החבילה הקנוני (`EYAL-CONTENT-PKG-yyyy-mm-dd-<slug>`) — ראו §5.

---

## 1. נתיב מקור (קנוני)

```
/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/
  docs/project/eyal-ceo-submissions-and-responses/from-eyal/
    תוכן לאתר 25.5.26/
```

המיקום תקין מבחינת קנון הפרויקט: כל הגשות מאייל יושבות תחת `from-eyal/`. תיקייה זו אינה עדיין חבילה קנונית עם `PACKAGE-MANIFEST.json` — היא **חומר גלם להפצה לחבילות** (ראו §5).

קישורים רלוונטיים:
- נוהל חבילות: [`PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md`](../PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md)
- קליטה היסטורית (6 חבילות אפריל): [`CONTENT/`](../CONTENT/)
- אינדקס היסטורי: [`CONTENT/INDEX-CONTENT.txt`](../CONTENT/INDEX-CONTENT.txt)
- מפת אתר v2.3 (APPROVED): [`SITEMAP-NEW-SITE-v2-DRAFT.md`](../../../team-100-preplanning/SITEMAP-NEW-SITE-v2-DRAFT.md)
- אפיון CANONICAL: [`SITE-SPECIFICATION-FINAL-2026-03-30.md`](../../../team-100-preplanning/SITE-SPECIFICATION-FINAL-2026-03-30.md)
- Handoff עיצוב 80→100: [`HANDOFF-DESIGN-SYSTEM-TO-TEAM100-2026-04-10.md`](../../../../_COMMUNICATION/team_80/HANDOFF-DESIGN-SYSTEM-TO-TEAM100-2026-04-10.md)

---

## 2. סיכום ביצועי

- **16 פריטי תוכן** (15 קבצי `.md` + 1 קובץ `.docx`).
- כל הקבצים בפורמט אחיד: בלוקים `SECTION 01–NN` עם `DEV NOTES` + תוכן עברי + CTA.
- **כל ה־CTA מצביעים ל־`/contact`** (אחיד).
- **אין מדיה מצורפת** בתיקייה — לא תמונות, לא וידאו, לא PDF נלווה (ראו §6 – פערים).
- **אין קובצי מטא נפרדים** (title/description/slug) — חייב מיפוי ידני (ראו §3).
- **`וכתבת` + `כושי בלאנטיס` + `צבע בכחול וזרוק לים` + `מוזה`** כבר נקלטו כחבילות `EYAL-CONTENT-PKG-2026-04-07-*` באפריל; הגרסה הזו ב־25/05 עשויה להיות **גרסה חדשה** — ראו §4 (לבדוק delta).

---

## 3. מיפוי תוכן ↔ עץ אתר ↔ תבנית

| # | תיקייה (מקור) | קובץ | pageId (מפת אתר v2.3) | slug מוצע | תבנית | סטטוס בסבב |
|---|---------------|------|----------------------|-----------|--------|------------|
| 1 | `דף הבית` | `homepage1-3 v2.md` | `st-home` | `/` | `tpl-home` | **חדש** — דף בית 12 בלוקים (§4.1) |
| 2 | `דף FAQ` | `FAQ FINAL.md` | `st-faq` | `/faq` | `tpl-faq` | **חדש** — FAQ אחוד 4 קטגוריות |
| 3 | `השיטה` | `method.md` | `st-method` | `/method` | `tpl-content` | **תואם / חדש** — קיימת חבילה PKG-2026-04-10 (לבדוק delta) |
| 4 | `טיפול בדיג'רידו` | `treatment.md` | `st-svc-treatment` | `/treatment` | `tpl-service` | **תואם / חדש** — קיימת PKG-2026-04-09 (לבדוק delta) |
| 5 | `סאונדהילינג` | `sound_healing_final.md` | `st-svc-sound-healing` | `/sound-healing` | `tpl-service` | **חדש** — לא קיים בקליטות אפריל |
| 6 | `שיעורי נגינה` | `lesons.md` | `st-svc-lessons` | `/lessons` | `tpl-service` | **חדש** — לא קיים בקליטות אפריל |
| 7 | `מוזה הוצאה לאור - ספרים` | `MUZZA.md` | `st-books` | `/books` | `tpl-books` | **תואם / חדש** — קיימת PKG-2026-04-07-muzeh (delta) |
| 8 | `וכתבת` | `vekatavta.md` | `st-book-vekatavt` | `/books/vekatavta` | `tpl-book-detail` | **תואם / חדש** — קיימת PKG-2026-04-07 (delta) |
| 9 | `כושי בלאנטיס` | `kushi_full.md` | `st-book-kushi` | `/books/kushi-blantis` | `tpl-book-detail` | **תואם / חדש** — קיימת PKG-2026-04-06 (POC; delta) |
| 10 | `צבע בכחול וזרוק לים` | `eyal_tsva_FINAL.md` | `st-book-tsva` | `/books/tsva-bekahol` | `tpl-book-detail` | **תואם / חדש** — קיימת PKG-2026-04-07 (delta) |
| 11 | `כלים למכירה` | `buy didgeridoo.md` | `st-shop-didg` | `/didgeridoos` | `tpl-shop` | **חדש** — מותג משני, לבדוק קיום ב־site-tree |
| 12 | `תיקים לדיג'רידו` | `bags for didg.md` | `st-shop-bags` | `/bags` | `tpl-shop` | **חדש** — מותג משני (Q: ב־site-tree?) |
| 13 | `סטנדים לדיג'רידו לאחסון` | `stend for hanging.md` | `st-shop-stands-hang` | `/stands-storage` | `tpl-shop` | **חדש** — מותג משני (Q: ב־site-tree?) |
| 14 | `סטנד רצפתי לנגינה בישיבה נמוכה` | `stend for playing.md` | `st-shop-stand-play` | `/stand-floor` | `tpl-shop` | **חדש** — מותג משני (Q: ב־site-tree?) |
| 15 | `תיקון כלי דיג'רידו` | `build didg.md` | `st-svc-repair` | `/repair` | `tpl-service` | **חדש** — שירות משני (Q: ב־site-tree?) |
| 16 | `מוקש דהימן` | `ומה היום.docx` | — | — | **חומר רקע** | **לא עמוד אתר** — תוכן ספציפי על מוקש 2026; משלים את `method.md` §07 ("איך נולדה השיטה") **או** קטע ל`st-about` |

**הערה:** ה־slug המוצע מבוסס על המפנים הפנימיים שבתוך הקבצים (`/contact`, `/treatment`, `/sound-healing`, `/lessons`, `/method`, `/books/...`). חייב להצליב מול `SITEMAP-NEW-SITE-v2-DRAFT.md` ומדיניות QR.

---

## 4. סטטוס מבני של כל קובץ

### 4.1 דף הבית — `homepage1-3 v2.md`
- 12 בלוקים מלאים: Hero → מה זה → וידאו → ההבדל סאונד/טיפול → למי מתאים → איך מתחילים → במפגש → סטודיו → גלריה נוספת → 15 עדויות פייסבוק → CTA סופי.
- **תואם** ל־`D-EYAL-HOME-01` (12 בלוקים מאושר ב־Handoff עיצוב §6.1).
- **לא מתאים** ל־Hero A/B/C — דורש בחירה (פתוח לפגישה).
- **תלוי במדיה:** תמונת Hero, וידאו, תמונות סטודיו — ראו §6.

### 4.2 FAQ — `FAQ FINAL.md`
- 4 קטגוריות: טיפול / שיעורים / סאונד הילינג / שיטה — סה"כ ~36 שאלות.
- בנוי לדף אחוד `/faq` עם 4 אקורדיונים, אבל גם משוכפל בתוך עמודי השירות (treatment/lessons/sound healing/method).
- **החלטה נדרשת:** האם להציג FAQ במקור אחד עם anchor או לשכפל בכל עמוד שירות (כפי שעשוי בתוכן)?

### 4.3 השיטה — `method.md`
- 12 בלוקים מלאים: Hero → מהי → לא כל עבודה זהה → איך בנויה → עקרונות → מה מייחד → לידת השיטה (חיבור למוקש) → אודות אייל → למי → במפגש → FAQ → חוויות.
- §07 ("איך נולדה השיטה והחיבור למוקש") — נראה שזה היעד של `מוקש דהימן/ומה היום.docx` כתוכן רקע.

### 4.4 טיפול בדיג'רידו — `treatment.md`
- ~10 בלוקים: Hero → פתיחה רגשית → מה זה → למי → איך עובד → איך נראה מפגש → השוואה לסאונד/שיעורים → 13 עדויות פייסבוק → SECTION 09 הוסר → FAQ.

### 4.5 סאונד הילינג — `sound_healing_final.md`
- 10 בלוקים: Hero → פתיחה → מה זה → מה מיוחד → איך זה עובד → מה מאפשר → למי → FAQ → המלצות → CTA.

### 4.6 שיעורי נגינה — `lesons.md`
- 10 בלוקים: Hero → מה זה → למה → איך נראים → מה לומדים בשלבים 1–4 + המשך → למי → למה אצל אייל → 9 המלצות → FAQ → CTA.

### 4.7 מוזה — `MUZZA.md`
- 12 בלוקים: Header → Hero → Intro → אודות אייל → למה כאן → ספר 1 → ספר 2 → ספר 3 → חבילת 3 ספרים → CTA bundle → משלוח → סגירה.
- **bundle** מופיע — כלומר הצעת `st-book-bundle` שהיתה PENDING באפריל **חוזרת** כאן כתוכן בעמוד מוזה. **דורש החלטת IA** (האם דף נפרד או חלק מ־`st-books`).

### 4.8 ספרים (וכתבת / כושי / צבע) — מבנה זהה, 14 בלוקים
- כל ספר: Hero → תקציר → קטע מתוך → על הספר → גלריה → רכישה → למי מתאים → אייל בהקשר → CTA ביניים → FAQ → כתבות עיתונות → CTA סופי → DEV NOTES → עוד רגעים.

### 4.9 כלים/תיקים/סטנדים/תיקון — 4 דפי מוצר/שירות משני
- מבנה דומה: Hero → מה / למה → איך / מאפיינים → למי → FAQ → המלצות → CTA.
- **כל אחד עם CTA ל־`/contact`** — לא איקומרס (תואם החלטה: ללא עגלת קנייה פנימית).

### 4.10 מוקש דהימן — `ומה היום.docx`
- טקסט רציף קצר (~1,500 תווים) על מצב משפחת מוקש ב־2026. **לא עמוד אתר** — חומר רקע / הקשר לקנון "החיבור למוקש".
- **המלצה:** לשבץ בתוך `method.md` §07 או ב־`about` של אייל.

---

## 5. צעד הבא קנוני — לפני יישום ב־WordPress

לפי [`PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md`](../PACKAGE-ROLES-PROCEDURE-VS-CONTENT.md), כל עמוד מאייל צריך **חבילה קנונית** משלו עם:

```
from-eyal/CONTENT/EYAL-CONTENT-PKG-2026-05-25-<slug>/
  ├── PACKAGE-MANIFEST.json    (מזהה, pageId, תבנית, סטטוס, תלות, hash)
  ├── content.md               (הקובץ המקורי בשם תקני)
  ├── media/                   (תמונות, וידאו אם יש)
  └── notes.md                 (פערים, החלטות, תלות)
```

ולאחר מכן רישום ב־`hub/data/deliverables.json`. **לא קלטנו עדיין** את 16 הפריטים ככאלה — צריך לבצע סבב פיצול לחבילות.

**הצעת מזהים קנוניים** (לאישור צוות 100):

```
EYAL-CONTENT-PKG-2026-05-25-st-home
EYAL-CONTENT-PKG-2026-05-25-st-faq
EYAL-CONTENT-PKG-2026-05-25-st-method            (delta vs PKG-2026-04-10)
EYAL-CONTENT-PKG-2026-05-25-st-svc-treatment      (delta vs PKG-2026-04-09)
EYAL-CONTENT-PKG-2026-05-25-st-svc-sound-healing
EYAL-CONTENT-PKG-2026-05-25-st-svc-lessons
EYAL-CONTENT-PKG-2026-05-25-st-books              (delta vs PKG-2026-04-07-muzeh)
EYAL-CONTENT-PKG-2026-05-25-st-book-vekatavt      (delta vs PKG-2026-04-07)
EYAL-CONTENT-PKG-2026-05-25-st-book-kushi         (delta vs PKG-2026-04-06)
EYAL-CONTENT-PKG-2026-05-25-st-book-tsva          (delta vs PKG-2026-04-07)
EYAL-CONTENT-PKG-2026-05-25-st-shop-didg
EYAL-CONTENT-PKG-2026-05-25-st-shop-bags
EYAL-CONTENT-PKG-2026-05-25-st-shop-stands-hang
EYAL-CONTENT-PKG-2026-05-25-st-shop-stand-play
EYAL-CONTENT-PKG-2026-05-25-st-svc-repair
EYAL-CONTENT-PKG-2026-05-25-asset-moksha-2026     (חומר רקע, לא עמוד)
```

---

## 6. פערים, חוסרים ושאלות פתוחות

ראו [`QUESTIONS-AND-GAPS-2026-05-26.md`](./QUESTIONS-AND-GAPS-2026-05-26.md) (מסמך נפרד באותה תיקייה).

---

## 7. שינוי גרסה

| תאריך | פעולה | בוצע ע"י |
|-------|--------|----------|
| 2026-05-25 | קליטת 16 פריטים מאייל לתיקייה זו | אייל / נימרוד |
| 2026-05-26 | יצירת אינדקס + מיפוי slug + רשימת פערים | סוכן (תחת team_100, בהוראת team_00) |
