---
id: D-EYAL-DESIGN-DIRECTION-FBW-DEEP
title: כיוון עיצובי מורחב — השראת Frequency Breathwork (LOD300 → לפיתוח D-14)
status: OPEN — דורש סיבוב עיצובי מצוות 80
date: 2026-05-26
approved_by: אייל עמית (CEO) — בפגישת 2026-05-26
target: team_80 (עיצוב/UX), team_100 (אדריכל)
supersedes: לא מבטל את D-EYAL-DESIGN-STYLE-13 — מעמיק את §7.1 ב-HANDOFF
references:
  - _COMMUNICATION/team_80/D-EYAL-DESIGN-STYLE-13-DECISION-PACKAGE-2026-04-07.md
  - _COMMUNICATION/team_80/HANDOFF-DESIGN-SYSTEM-TO-TEAM100-2026-04-10.md §7.1
  - docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/MEETING-DECISIONS-2026-05-26.md (Q12)
---

# כיוון עיצובי מורחב — השראה עמוקה מ-Frequency Breathwork

## 0. ההחלטה שלוקחת אייל בפגישת 2026-05-26

> "אנחנו רוצים לקבל השראה מהאתר [frequencybreathwork.com](https://frequencybreathwork.com/) ולא רק בכותרת — אייל מאוד מתחבר לאתר הזה בכל נושא העיצוב ואני רוצה לקחת את העיצוב שלנו לכיוון והשראה של האתר הזה."

זוהי **הרחבה רשמית** של D-EYAL-DESIGN-STYLE-13 (LOCKED 2026-04-07), לא ביטול שלו.

---

## 1. מה נשאר נעול (ללא שינוי) מ-D-EYAL-DESIGN-STYLE-13

| נושא | סטטוס | מקור |
|------|--------|------|
| **פלטת צבעים — 7 צבעי מותג + UI** | ✅ LOCKED — לא משתנה | `EYAL-SITE-COLOR-PALETTE.md` |
| **טיפוגרפיה — Heebo (משפחה יחידה)** | ✅ LOCKED — לא משתנה | D-13 §3 |
| **6 כללי עיצוב בלתי ניתנים לשינוי** | ✅ LOCKED — לא משתנה | HANDOFF §1 |
| **Hero בחירה — C (Video)** | 🟢 נסגר 2026-05-26 | פגישת אייל |
| **12 בלוקים בדף הבית** | ✅ LOCKED — לא משתנה | HANDOFF §6.1 |

**סיכום:** Earth & Warmth + Heebo + 6 כללי הברזל נשארים. ההרחבה היא ב**רובד החוויה והתנועה**, לא בפלטה ולא בטיפוגרפיה.

---

## 2. מה מתעמיק / נפתח מחדש לבחינה (D-14)

מה שב-HANDOFF §7.1 צוין כ-"מה לבחון" עובר עכשיו ל-"חובת מימוש":

### 2.1 Breathing motion — מעבר מ-Hero לכל האתר

ב-D-13 / HANDOFF §5.1 — קווים נושמים היו **רק ב-Hero**. ב-D-14:

- **קווים נושמים גם כ-section dividers** בין סקציות (אופקיים, opacity נמוכה, breathe animation ~6-8s).
- **מעגלים נושמים בפינות** של בלוקים מסוימים (CTA, accent boxes) — opacity 0.04-0.08.
- **דופק רך על אלמנטים סטטיים** — לוגו עם breathing opacity 0.95↔1.0 (~4s loop), כפתורים primary עם scale 1.0↔1.005.
- **כל הקצבים שונים** (5-10s, delay רנדומלי) — מדמה נשימה אורגנית, לא מטרונום.

### 2.2 Restraint — "פחות זה יותר", מעבר ל-Apple-level

מ-HANDOFF: *"restrained clarity over expression"*. ב-D-14:

- **הסרת כל אלמנט שאינו תורם תוכן או חוויה.** כל border / divider / רווח חייב להצדיק את עצמו.
- **טקסט קצר יותר.** כל H2 → לבחון אם אפשר להוריד 30% מהאורך בלי לאבד משמעות.
- **CTAs בודדים, לא מרובים.** כל section עם CTA אחד מקסימום, רצוי אף לא אחד בסקציות מידע.
- **אין אייקונים בכלל** (כבר ב-D-13 — מודגש כאן שוב).
- **רווחים אפילו גדולים יותר.** Section padding: 100px → לבחון 120-140px בדפים שמיועדים לקריאה איטית (method, treatment, books).

### 2.3 Layout non-linear (אופציונלי, לבחון)

ב-HANDOFF §7.1 — *"layout מעגלי (non-linear sections)"* היה ב"מה לבחון". ב-D-14:

- **לא לאמץ באופן גורף** — non-linear על אתר RTL בעברית עלול לפגוע ב-readability ובנגישות.
- **אבל לבחון בנקודות ספציפיות:**
  - **רקע Hero** — circular masking, drift animation עדין.
  - **section "מה זה טיפול"** — אופציה לסקציה דיאגונלית עם reveal asymmetric.
  - **CTA תחתון** — gradient רדיאלי במקום מלבני.
- **שמירה על קריאות + נגישות תמיד גוברת.**

### 2.4 Hero Video — מפרט עמוק (החלטת Q1 + Q12 משולבת)

כיוון שאייל בחר Video + ההשראה היא FBW:

**מפרט וידאו** (להפקה / בחירה):
- **תוכן:** קלוז-אפ דיג'רידו (עץ, פיתוחים, יד אייל) — לא נגינה מלאה.
- **תנועה:** איטית, מסתורית, מינימליסטית. אין cuts. ~15-25 שניות לופ.
- **קולור גרייד:** מותאם לפלטה — חם, Earth tones, contrast נמוך.
- **autoplay muted loop** — חובה (autoplay עם sound = blocker בדפדפנים).
- **כפתור pause חובה** (ת"י 5568 — נגישות).
- **fallback תמונת סטילים** למובייל (חיסכון 5MB+).
- **breathing lines overlay** מעל הוידאו — לא במקומו. שני אלמנטים בו זמנית.

**מפרט טכני:**
- ffmpeg H.264 + WebM VP9 (dual source).
- מקסימום 3MB ל-desktop, 800KB-תמונת fallback למובייל.
- LCP target < 2.5s על 4G (אופטימיזציה: preload="metadata", lazy decode).

### 2.5 שילוב סאונד בממשק — לבחון בזהירות

מ-HANDOFF §7.1 — *"שילוב סאונד בממשק"* היה ב"מה לבחון". מסקנה זמנית:

- **לא לאמץ עכשיו** — אתר עברי, ברוב המוחלט המבקרים יבואו במצב mute או בסביבת עבודה.
- **אבל ניתן לאפשר** — toggle בחלק העליון של Hero ("שמע את הצליל") שמפעיל סאונד דיג'רידו רך כשהמבקר בוחר.
- **לא לעולם default-on.**

### 2.6 Micro-interactions עמוקות

מ-HANDOFF §5.3 — קיים מפרט micro-interactions. הרחבה ב-D-14:

- **כניסה לכל section** — לא רק fadeUp; להוסיף breathing decompression (scale 0.995→1, opacity 0→1, slow ease).
- **Hover על כל לינק** — לא רק color shift; להוסיף underline שצומח מהמרכז החוצה (~300ms).
- **Scroll progress indicator** — קו דק (1px) ב-edge למעלה, Terracotta, opacity 0.4.
- **Cursor אלמנט (אופציונלי)** — נקודה רכה שעוקבת אחרי העכבר עם delay (~80ms), opacity 0.15. רק בדסקטופ.

---

## 3. השוואה ויזואלית — FBW vs Eyal (להחלטה בסיבוב D-14)

| ממד | FBW (frequencybreathwork.com) | Eyal Amit (D-13 הנוכחי) | Eyal Amit (D-14 מוצע) |
|-----|--------------------------------|------------------------|----------------------|
| **פלטה** | כהה — שחור/כחול לילה + accent ניאון | בהיר — Sand/Earth/Ink (חם) | כמו D-13 (חם, בהיר) |
| **טיפוגרפיה** | Serif מודרני + Sans-serif | Heebo בלבד | כמו D-13 (Heebo) |
| **Hero** | Video + breathing lines | היה portrait/studio/video | **C — Video + breathing lines** |
| **Motion philosophy** | "Breathing everywhere" | רק ב-Hero | **הרחבה לכל האתר** |
| **Section transitions** | Asymmetric, drift | Stack standard | **בחינה: שילוב drift עדין** |
| **Sound** | Optional toggle | אין | **לבחון: toggle ב-Hero** |
| **Density** | מאוד נמוכה (ריקנות) | בינונית | **הורדה ל-30% פחות תוכן ב-fold ראשון** |
| **Cursor** | Custom dot | Default | **לבחון: custom dot** |
| **CTAs** | אחד, גדול, רחוק | אחד בכל section | **הקטנה: לא בכל section** |
| **Color usage of accent** | חזק, פיסי (ניאון) | רך (Terracotta) | **כמו D-13 — לא משנים** |

**שורה תחתונה:** הרבה ממה ש-FBW עושים אנחנו **כבר עושים** ברמת הכללים, פשוט לא במלוא ההיקף. D-14 = **לקחת את הכללים שכבר נעולים ולמתוח אותם לקיצוניות שלהם.**

---

## 4. ניהול סיכונים

| סיכון | חומרה | הקלה |
|-------|--------|------|
| Hero Video — כבד, LCP גרוע במובייל | גבוה | Fallback סטילים למובייל + lazy + image preload |
| נגישות — אנימציות רבות → motion sickness | בינוני | `prefers-reduced-motion` media query — לבטל את כל ה-breathing |
| Performance — JS-heavy animations | בינוני | רק CSS animations + transform/opacity (GPU). אין JS scroll-tied. |
| תאימות RTL — FBW אנגלי LTR | בינוני | בדיקה קפדנית של כל drift / asymmetry לעברית RTL |
| הסחה מהמסר — "האתר יפה אבל לא מבינים מה זה" | גבוה | המסר הראשי לעולם לא מאחורי הוידאו — H1 קריא ב-overlay |

---

## 5. צעדים נדרשים (סדר ביצוע)

### 5.1 ⬛ סיבוב צוות 80 — חבילת D-14 (חוסם יישום)

צוות 80 לבנות חבילת החלטה חדשה:
- **D-EYAL-DESIGN-STYLE-14** — מבוסס על D-13 + העמקות במסמך זה.
- **3 דפי דמו חדשים** עם אנימציות נושמות מורחבות (לא רק Hero):
  - דף בית (כל 12 הבלוקים, עם דיברידרים נושמים)
  - דף method (קריאה איטית, padding 120px, breathing on H2)
  - דף treatment (להפגין את ה-CTA הבודד, restraint)
- **תיעוד `prefers-reduced-motion` fallback** — חובת מימוש.
- **מפרט וידאו Hero** — content + תקציר הפקה (אורך, סצנות).

### 5.2 ⬛ הפקת וידאו Hero (חוסם go-live)

- **בעלים:** אייל (תוכן) + צוות 40 (מדיה).
- **לבחון:** האם יש חומר וידאו קיים ניתן להשתמש? אם לא — נדרש סשן צילום.
- **תקציב:** TBD — וידאו מקצועי 15-25 שניות עולה ~₪3,000-8,000 לפי הפקה.

### 5.3 🟧 עדכון מוקאפ Hero C קיים

המוקאפ הנוכחי ב-`hub/dist/mockups/hero-video.html` מבוסס על D-13.
**צוות 80 לעדכן** כדי שיכלול:
- breathing lines overlay מעל הוידאו
- CTA pill עם breathing scale
- כפתור pause (נגישות)
- toggle סאונד אופציונלי

### 5.4 🟦 הפצה לצוות 10 (יישום WordPress)

לאחר D-14 LOCKED:
- עדכון `style.css` של ea-eyalamit child theme עם CSS variables מורחבים.
- יישום `prefers-reduced-motion` בכל אנימציה.
- יצירת blocks חדשים: `breathing-divider`, `hero-video-frame`, `floating-cta`.

---

## 6. שאלות חוסמות לאייל בפגישה (אם רלוונטי)

1. **תוכן וידאו** — האם יש לאייל וידאו קיים שיכול לשמש Hero, או נדרשת הפקה חדשה?
2. **תקציב הפקת וידאו** — אם נדרשת הפקה: ~₪3-8K. אישור?
3. **לוח זמנים** — האם דחיית go-live חודש לטובת הפקת וידאו ועדכון D-14 — מקובלת?
4. **סאונד toggle** — אישור עקרוני לכלול toggle סאונד ב-Hero (לא default-on)?
5. **Cursor dot** — אישור עקרוני לכלול cursor custom בדסקטופ בלבד?

---

## 7. שינוי גרסה

| תאריך | פעולה | בעלים |
|-------|--------|-------|
| 2026-04-07 | D-13 LOCKED (אופציה A + Heebo) | אייל + team_80 |
| 2026-04-10 | HANDOFF LOD400 → team_100 | team_80 |
| 2026-05-26 | החלטת אייל: Hero=C + FBW deeper | אייל בפגישה |
| 2026-05-26 | פתיחת מסמך זה — D-14 לפיתוח | team_100 |
