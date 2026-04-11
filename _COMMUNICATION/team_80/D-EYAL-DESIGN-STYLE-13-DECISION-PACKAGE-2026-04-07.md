---
id: D-EYAL-DESIGN-STYLE-13
title: חבילת החלטה עיצובית — אייל עמית
status: LOCKED
date: 2026-04-07
approved_by: אייל עמית (לקוח)
target: team_100 (אדריכל פרויקט)
lod: LOD300
---

# חבילת החלטה עיצובית — D-EYAL-DESIGN-STYLE-13

## 1. סיכום

אייל אישר את כיוון עיצוב **A — Earth & Warmth** עם פונט **Heebo** כסגנון העיצובי לאתר החדש.

ההחלטה התקבלה לאחר:
- הצגת 4 אופציות טיפוגרפיה (Heebo, Noto Serif Hebrew, Assistant+Bellefair, IBM Plex Sans Hebrew)
- הצגת 3 כיווני עיצוב (Earth & Warmth, Light & Airy, Editorial & Bold)
- הלקוח נעל אופציה A + Heebo כראשית

**אופציה חליפית** (לא נבחרה): B — Light & Airy + IBM Plex Sans Hebrew.

---

## 2. סגנון עיצובי — Earth & Warmth

- רקע חם: `#FAF8F5`
- רקע חלופי (מתודה, FAQ): `#F3EEE8`
- Header כהה (Ink): sticky, 56px
- קווי הפרדה דקים: 1px בלבד
- הרבה whitespace בין סקשנים (80px padding)
- אין אייקונים — טקסט בלבד. קווי Terracotta דקים הם האלמנטים הגרפיים
- אין shadows (חוץ מ-backdrop-filter בנאב)
- פינות: 100px (pills) לכפתורים, 4px לתמונות. אין עגולות בינוניות
- בהשראת הלוגו — עדין, קטן, זורם. Apple-level minimalism

---

## 3. טיפוגרפיה — Heebo

משפחה אחת בלבד. Sans-serif גיאומטרי מ-Google Fonts.

| אלמנט | Weight | Size | הערות |
|--------|--------|------|-------|
| H1 | 200 | 2.8rem | line-height 1.12, letter-spacing -0.5px |
| H2 | 200 | 1.8rem | line-height 1.2, letter-spacing -0.3px |
| H3 | 400 | 0.92rem | |
| גוף | 300 | 15px (0.9rem) | line-height 1.85, color: Earth |
| ניווט | 300 | 0.72rem | color: #A8A19B |
| כפתורים | 300 | 0.78rem | border-radius 100px (pills) |
| Labels | 300 | 0.58rem | letter-spacing 3.5px, uppercase |
| ציטוטים | 200 | 1rem | italic |

---

## 4. פלטת צבעים (קנוני)

מקור: `docs/project/EYAL-SITE-COLOR-PALETTE.md`

| שם | HEX | CSS Variable | תפקיד |
|----|-----|-------------|--------|
| Sand | `#D8C7B5` | `--eyal-sand` | רקעים בהירים, שטחים רכים, גרדיאנטים |
| Terracotta | `#A44E2B` | `--eyal-terracotta` / `--accent` | הדגשה ראשית, CTA, קווי accent דקים |
| Earth | `#8A5A44` | `--eyal-earth` / `--text-muted` | טקסט משני, מטא-דאטה |
| Olive | `#6E6F4A` | `--eyal-olive` | הדגשה משנית, אזורי מצב |
| Ink | `#2E2B28` | `--eyal-ink` / `--text` | טקסט ראשי, כותרות, header |
| Chocolate | `#5C3A2E` | `--eyal-chocolate` | כותרות משנה, CTA תחתון |
| Brick | `#AB3A2B` | `--eyal-brick` / `--accent-strong` | CTA חזק, קריאה לפעולה |

Terracotta מופיע רק בנקודות מגע. כל השאר — Ink, Earth, Sand.

---

## 5. Layout ו-Grid

| פרמטר | ערך |
|--------|-----|
| רוחב תוכן | `max-width: 960px`, ממורכז |
| Section padding | 80px למעלה/למטה |
| רקע ראשי | `#FAF8F5` (warm off-white) |
| רקע חלופי | `#F3EEE8` (למתודה ו-FAQ) |
| הפרדה בין סקשנים | קו 1px דק או divider 40px |
| תחומי פעילות | grid 4 עמודות, gap: 1px, hover משנה רקע |
| FAQ | grid 2 עמודות, gap: 1px |
| גלריה | grid 3 עמודות, gap: 4px |
| בלוג | featured (50/50) + grid 3 עמודות cards |
| Breakpoint | 800px — מעבר לעמודה אחת |
| Header | sticky, רקע Ink `#2E2B28`, גובה 56px |
| CTA תחתון | רקע Chocolate `#5C3A2E`, כפתור Brick |
| ניווט | שטוח, 11 פריטים + CTA, ללא dropdowns |

---

## 6. מבנה דפים

### 6.1 דף הבית — 12 בלוקים

1. Header (sticky, Ink) + ניווט שטוח 11 פריטים + CTA
2. Hero — כותרת מרכזית (H1 weight 200), תת-כותרת, מיקום + שנה, CTA
3. מה זה טיפול בדיג׳רידו — פסקה מובילה
4. תחומי פעילות — grid 4 עמודות עם קווי 1px
5. וידאו — טקסט + תמונה/סרטון בצד
6. שיטת cbDIDG — רקע חלופי, מרכזי
7. למי מתאים — רשימה + תמונה בצד
8. FAQ — grid 2x2 + קישור לכל השאלות
9. המלצות — 3 ציטוטים מרכזיים
10. אודות אייל — תמונה + טקסט בצד
11. CTA תחתון — רקע Chocolate, 2 כפתורים (שיחה + וואטסאפ)
12. Footer — לוגו + קישורים + מיקום

### 6.2 דף תוכן (שירות/תחום)

Header → כותרת + תיאור → טקסט מוביל → גלריה (grid 3) → FAQ (grid 2, 6 שאלות) → המלצות (3 ציטוטים) → CTA

### 6.3 דף בלוג

Header → כותרת + תיאור → Featured post (תמונה 50% + טקסט 50%) → Grid 3 עמודות cards (thumb + קטגוריה + כותרת + תקציר + תאריך)

---

## 7. השראה

שני אתרים שהרשימו את אייל במיוחד:

1. **Frequency Breathwork** — https://frequencybreathwork.com/
   - Awwwards Honorable Mention
   - קווים חיים שנעים כמו נשימה, מינימליזם מושלם
   - גישה: "restrained clarity over expression, function over form"

2. **Dhun Wellness** — https://dhunwellness.com/
   - Awwwards Nominee
   - ממשק שקט ושלו, ניווט זורם, אנימציות איטיות

**הצעד הבא**: בחינה מעמיקה של שני האתרים — אילו אלמנטים ספציפיים לשלב באתר של אייל.

---

## 8. קבצים מצורפים

| קובץ | מיקום | תיאור |
|-------|--------|--------|
| מוקאפ אופציה A | `hub/dist/mockups/` | HTML מלא — 3 דפים עם תמונות |
| טיפוגרפיה specimens | `hub/dist/mockups/` | 4 אופציות טיפוגרפיה |
| פלטת צבעים | `docs/project/EYAL-SITE-COLOR-PALETTE.md` | מקור קנוני |
| לוגו | `eyal-ceo-submissions-and-responses/from-eyal/LOGO/` | נשלח 2026-04-07 |

---

## 9. צעדים הבאים

1. בחינה מעמיקה של Frequency Breathwork ו-Dhun Wellness — אילו אלמנטים לשלב
2. תרגום CSS variables ו-design tokens ל-GeneratePress child theme (ea-eyalamit)
3. יישום דף הבית בוורדפרס לפי מפרט הבלוקים
4. יישום דפי תוכן ובלוג לפי אותו סגנון
5. איסוף תוכן מהלקוח — שילוב עם content intake ב-Hub
