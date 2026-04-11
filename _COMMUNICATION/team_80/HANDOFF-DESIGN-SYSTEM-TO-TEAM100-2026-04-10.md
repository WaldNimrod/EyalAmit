---
id: HANDOFF-DESIGN-SYSTEM-2026-04-10
title: Handoff עיצובי מלא — team_80 → team_100
status: ACTIVE
date: 2026-04-10
from: team_80 (עיצוב ו-UX)
to: team_100 (אדריכל פרויקט)
related: D-EYAL-DESIGN-STYLE-13
lod: LOD400
---

# Handoff עיצובי מלא — אתר אייל עמית

## מטרת המסמך

מסמך זה מעביר את כלל ההחלטות העיצוביות, התובנות, הדוגמאות והכללים שנוצרו בתהליך עיצוב האתר החדש של אייל עמית. המסמך מיועד ל-team_100 (אדריכל פרויקט) ליישום ב:
1. **Client Hub** — עדכון המוקאפים והדפים הקיימים לסגנון החדש
2. **WordPress/GeneratePress** — יישום בתבנית ea-eyalamit

**סטטוס:** הלקוח אישר את הסגנון. ההחלטה נעולה (D-EYAL-DESIGN-STYLE-13, 2026-04-07).

---

## 1. סגנון נבחר: Earth & Warmth

### פילוסופיה
מינימליזם ברמה גבוהה בהשראת הלוגו של אייל — קווים דקים, עדינים, זורמים. כל אלמנט מכוון ומדויק. האתר צריך להרגיש כמו להיכנס למרחב הטיפול — שקט, חם, מקצועי.

ציטוט מנחה (מ-Frequency Breathwork): **"restrained clarity over expression, function over form"**

### 6 כללי עיצוב בלתי ניתנים לשינוי

1. **הרבה אוויר** — whitespace הוא חלק מהעיצוב, לא חלל ריק. Section padding: 80-100px. לא למלא.
2. **אין אייקונים** — הטקסט עושה את העבודה הכבדה. קווי Terracotta דקים (1px, 20-32px רוחב) הם האלמנטים הגרפיים היחידים.
3. **אין shadows** — חוץ מ-backdrop-filter blur(16px) בנאב בלבד. אין box-shadow על cards, אין drop-shadow על תמונות.
4. **אין borders כבדים** — רק קווי הפרדה 1px בצבע `rgba(216,199,181,0.35)`. Grid gap: 1px.
5. **פינות: pills או חדות** — כפתורים: border-radius 100px (pills). תמונות: border-radius 4px. אין עגולות בינוניות (8px, 12px, 16px).
6. **Terracotta רק בנקודות מגע** — CTA, קווי accent, hover states, links. כל השאר: Ink, Earth, Sand. Terracotta לעולם לא ברקע או בשטחים גדולים.

---

## 2. טיפוגרפיה — Heebo

משפחה אחת בלבד. Sans-serif גיאומטרי מ-Google Fonts.
**אין לערבב עם פונטים אחרים.**

### Import
```css
@import url('https://fonts.googleapis.com/css2?family=Heebo:wght@100;200;300;400;500;600&display=swap');
```

### מדרג מלא

| אלמנט | Weight | Size | Line-height | Letter-spacing | Color |
|--------|--------|------|-------------|----------------|-------|
| H1 (Hero) | 100 | 3.4rem | 1.12 | -0.5px | Ink #2E2B28 |
| H1 (פנימי) | 200 | 2.8rem | 1.12 | -0.5px | Ink |
| H2 | 200 | 2rem | 1.2 | -0.3px | Ink |
| H3 | 400 | 0.92rem | 1.4 | 0 | Ink |
| גוף | 300 | 15px (0.9rem) | 1.85-1.9 | 0 | Earth #8A5A44 |
| ניווט | 300 | 0.72rem | 1.4 | 0.3px | #A8A19B |
| כפתור (primary) | 300 | 0.78rem | 1 | 0.2px | white / Terracotta |
| כפתור (ghost) | 300 | 0.78rem | 1 | 0.2px | Earth |
| Label/section-label | 200 | 0.58rem | 1.4 | 3.5px uppercase | #A8A19B |
| ציטוט | 200 | 1.05rem | 1.5 | 0 | Ink, italic |
| ציטוט שם | 300 | 0.68rem | 1.4 | 0.8px | #A8A19B |
| קישור | 400 | 0.82rem | — | 0 | Terracotta + underline 1px |
| Footer | 300 | 0.68rem | 1.4 | 0 | #A8A19B |

### כלל מנחה
ככל שהאלמנט גדול יותר — המשקל קל יותר. H1 ב-100-200, גוף ב-300, כותרת משנה ב-400. אין bold (600+) אלא במקרים חריגים.

---

## 3. פלטת צבעים

מקור קנוני: `docs/project/EYAL-SITE-COLOR-PALETTE.md`

### 7 צבעי מותג

| שם | HEX | CSS Variable | RGB (לשקיפויות) | תפקיד |
|----|-----|-------------|-----------------|--------|
| Sand | #D8C7B5 | --sand | 216,199,181 | רקעים בהירים, שטחים רכים, גרדיאנטים, dividers |
| Terracotta | #A44E2B | --terra / --accent | 164,78,43 | הדגשה ראשית, CTA, קווי accent, hover, links |
| Earth | #8A5A44 | --earth | 138,90,68 | טקסט גוף, מטא-דאטה, תיאורים |
| Olive | #6E6F4A | --olive | 110,111,74 | הדגשה משנית, אזורי מצב שאינם שגיאה (לא בשימוש פעיל באופציה A) |
| Ink | #2E2B28 | --ink | 46,43,40 | טקסט ראשי, כותרות, header background |
| Chocolate | #5C3A2E | --choc | 92,58,46 | CTA תחתון background, כותרות משנה |
| Brick | #AB3A2B | --brick | 171,58,43 | CTA button fill חזק, קריאה לפעולה בולטת |

### צבעי UI

| שם | HEX | תפקיד |
|----|-----|--------|
| Background | #FAF8F5 | רקע ראשי (warm off-white) |
| Background Alt | #F3EEE8 | רקע חלופי (שיטה, FAQ, ציטוטים) |
| Line | rgba(216,199,181,0.35) | קווי הפרדה, grid gaps |
| Muted | #A8A19B | labels, ניווט, placeholder, meta |

### כלל מנחה
הפלטה שקטה. 90% מהממשק הוא Ink + Earth + Sand + Background. Terracotta מופיע רק בנקודות אינטראקציה. Brick רק ב-CTA הראשי.

---

## 4. Layout ו-Grid

| פרמטר | ערך | הערה |
|--------|-----|------|
| רוחב תוכן | max-width: 960px | ממורכז עם padding: 0 32px |
| Section padding | 80-100px top/bottom | שומר על אוויר |
| רקע ראשי | #FAF8F5 | |
| רקע חלופי | #F3EEE8 | למתודה, FAQ, ציטוטים |
| הפרדה בין סקשנים | divider (40px width, 1px, Sand) או gap: 1px | |
| תחומי פעילות | grid 4 columns, gap: 1px, hover→bg-alt | |
| FAQ | grid 2 columns, gap: 1px | |
| גלריה | grid 3 columns, gap: 4px | |
| בלוג | featured (50/50 split) + grid 3 cards | |
| Breakpoint | 800px → single column | |
| Header | position: fixed, bg: rgba(46,43,40,0.97), blur(16px), height: 64px | |
| ניווט | שטוח, 11 פריטים (כמו wireframe מאושר), ללא dropdowns | |
| CTA תחתון | bg: Chocolate, button: Brick pill | |
| Footer | border-top 1px, לוגו + links + מיקום | |

---

## 5. אנימציות ותנועה

### 5.1 קווים נושמים (Hero) — מ-Frequency Breathwork

4 קווים אופקיים דקים + 2 מעגלים, ממוקמים ברקע ה-Hero:
```css
@keyframes breathe {
  0%,100% { transform: scaleX(1); opacity: 0.35; }
  50% { transform: scaleX(1.15); opacity: 0.55; }
}
```
- קווים: height 1px, background Terracotta, opacity 0.3-0.55
- מעגלים: border 1px, opacity 0.06-0.08, scaleY animation
- כל אלמנט בקצב שונה (5-10s cycle) ו-delay שונה
- **מוסתרים במובייל** (display:none under 800px)

### 5.2 Scroll Reveal

כל section מתגלה בגלילה:
```css
.reveal { opacity:0; transform:translateY(30px); transition: opacity 0.8s, transform 0.8s; }
.reveal.visible { opacity:1; transform:translateY(0); }
```
IntersectionObserver עם threshold: 0.15

### 5.3 Micro-interactions

| אלמנט | Hover effect |
|--------|-------------|
| קווי accent בתחומי פעילות | width: 20px→32px, opacity: 0.45→0.8 |
| כותרות תחומי פעילות | color→Terracotta |
| תמונות (video, fit, about) | transform: scale(1.03), transition 0.6s |
| Concern pills | fill animation RTL (scaleX 0→1 מימין), color→white |
| FAQ items | background→bg-alt, h4 color→Terracotta |
| Fit list items | padding-right +8px, color→Ink |
| כפתור CTA nav | bg→Terracotta, border-color→Terracotta |

### 5.4 Hero entrance

כל אלמנט ב-Hero נכנס עם fadeUp staggered:
- Label: delay 0.2s
- H1: delay 0.5s
- Sub: delay 0.8s
- CTA: delay 1.1s
- Place: delay 1.4s

### 5.5 עיקרון מנחה
**ריסון.** כל אנימציה צריכה להיות עדינה עד כמעט בלתי מורגשת. Timing: ease-in-out, 0.3-0.8s. אם אנימציה "נראית" — היא חזקה מדי. הרעיון מ-Frequency Breathwork: "הוספנו רק מה שמוסיף משמעות, לא מה שמוסיף רעש."

---

## 6. מבנה דפים

### 6.1 דף הבית — 12 בלוקים (מאושר D-EYAL-HOME-01)

1. **Header** — sticky, Ink bg, ניווט שטוח 7+CTA
2. **Hero** — full-height, כותרת weight 100, breathing lines, CTA pill
3. **מה זה** — label + H2 + lead paragraph
4. **Concern nav** — "מה מביא אותך?" + 6 pills (מ-Dhun Wellness)
5. **תחומי פעילות** — grid 4, accent lines, hover
6. **וידאו** — split: text + video box עם play button
7. **שיטת cbDIDG** — bg-alt, centered, link
8. **למי מתאים** — split: list + portrait
9. **FAQ** — grid 2x2
10. **המלצות** — bg-alt, 3 quotes centered
11. **אודות** — split: portrait + text
12. **CTA תחתון** — Chocolate bg, breathing circle, 2 buttons

### 6.2 דף תוכן (שירות/תחום)

Header → page-header (label + H1 + desc) → טקסט מוביל → גלריה grid 3 → FAQ grid 2 (6 שאלות) → המלצות 3 → CTA

### 6.3 דף בלוג

Header → page-header → Featured post (50/50 split) → Grid 3 cards (thumb + cat + title + excerpt + date)

### 6.4 Hero — 3 גרסאות (ממתין לבחירה סופית)

| גרסה | URL staging | תיאור |
|-------|------------|--------|
| A — Portrait | /ea-eyal-hub/mockups/hero-portrait.html | תמונת אייל full-bleed + overlay כהה + טקסט לבן |
| B — Studio | /ea-eyal-hub/mockups/hero-studio.html | Split: טקסט 60% + תמונת סטודיו 40% |
| C — Video | /ea-eyal-hub/mockups/hero-video.html | תמונת דיג'רידו ברקע + play button + overlay |

**URL base:** http://eyalamit-co-il-2026.s887.upress.link

---

## 7. השראה — אלמנטים לשילוב

### 7.1 Frequency Breathwork (frequencybreathwork.com)
- **מה לקחנו:** קווים נושמים ב-Hero, פילוסופיית ריסון
- **מה לבחון:** layout מעגלי (non-linear sections), שילוב סאונד בממשק
- **Awwwards Honorable Mention, CSS Design Awards SOTD**

### 7.2 Dhun Wellness (dhunwellness.com)
- **מה לקחנו:** concern-based navigation ("מה מביא אותך?"), fill animation על pills
- **מה לבחון:** אנימציות scroll איטיות יותר, treatment booking flow
- **Awwwards Nominee**

### 7.3 Integrapija (integrapija.si/en)
- **מה לקחת:** ניסוח מקצועי-רפואי, דיג'רידו כחלק מתמהיל טיפולי (לא אקזוטי)
- **לא לקחת:** העיצוב עצמו (רגיל)

### 7.4 DidgeTherapy (didgetherapy.com)
- **מה לקחת:** תוכן שמחבר לעולם הרפואי, 25+ שנות ניסיון (כמו אייל), הצגת עבודה בבתי חולים
- **לא לקחת:** העיצוב (ישן)

### צעד הבא
בחינה מעמיקה של Frequency Breathwork ו-Dhun Wellness — הגדרת אילו אלמנטים ספציפיים לשלב, ומה דורש פיתוח custom vs מה ניתן עם GeneratePress blocks.

---

## 8. קבצים ודוגמאות

### דוגמאות חיות (staging)

| קובץ | URL | תיאור |
|-------|-----|--------|
| דף בית מלא | /ea-eyal-hub/mockups/homepage-final-prototype.html | 12 בלוקים, אנימציות, concern nav |
| Hero A — portrait | /ea-eyal-hub/mockups/hero-portrait.html | Full-bleed portrait |
| Hero B — studio | /ea-eyal-hub/mockups/hero-studio.html | Split layout |
| Hero C — video | /ea-eyal-hub/mockups/hero-video.html | Video hero |

**Base URL:** http://eyalamit-co-il-2026.s887.upress.link

### קבצי פרויקט

| קובץ | נתיב | תיאור |
|-------|------|--------|
| פלטת צבעים | docs/project/EYAL-SITE-COLOR-PALETTE.md | קנוני — 7 צבעים + CSS variables |
| החלטה נעולה | _communication/team_80/D-EYAL-DESIGN-STYLE-13-DECISION-PACKAGE-2026-04-07.md | החלטת עיצוב מאושרת |
| Wireframe מאושר | hub/dist/mockups/wireframes/home-visual-sketch-final-rtl.html | מבנה 12 בלוקים מקורי |
| לוגו | eyal-ceo-submissions-and-responses/from-eyal/LOGO/ | לוגו חדש (WhatsApp 2026-04-07) |
| CSS child theme | eyalamit.co.il-legacy/.../ea-eyalamit/style.css | התבנית הקיימת (לעדכון) |

---

## 9. צעדי יישום מומלצים

1. **תרגום Design Tokens** — CSS variables ל-GeneratePress child theme: פלטה, פונט, spacing, breakpoints
2. **עדכון Hub** — יישום הסגנון החדש על דפי ה-Hub הקיימים (dashboard, decisions, roadmap)
3. **יישום דף הבית** — 12 בלוקים לפי המפרט, כולל Hero (אחרי בחירה סופית A/B/C), אנימציות, concern nav
4. **יישום דפי תוכן** — תבנית אחידה: גלריה, FAQ, המלצות, CTA
5. **יישום בלוג** — Featured + grid cards
6. **בחינת השראה** — אלמנטים נוספים מ-Frequency Breathwork ו-Dhun Wellness
7. **איסוף תוכן** — שילוב עם content intake ב-Hub

---

## 10. CSS Variables — Copy/Paste Ready

```css
:root {
  /* Brand palette */
  --sand: #D8C7B5;
  --terra: #A44E2B;
  --earth: #8A5A44;
  --olive: #6E6F4A;
  --ink: #2E2B28;
  --choc: #5C3A2E;
  --brick: #AB3A2B;

  /* Semantic */
  --accent: var(--terra);
  --accent-strong: var(--brick);
  --text: var(--ink);
  --text-muted: var(--earth);

  /* UI */
  --bg: #FAF8F5;
  --bg-alt: #F3EEE8;
  --line: rgba(216,199,181,0.35);
  --muted: #A8A19B;

  /* Typography */
  --font: 'Heebo', sans-serif;
  --h1-weight: 100;
  --h2-weight: 200;
  --h3-weight: 400;
  --body-weight: 300;
  --body-size: 15px;
  --body-line-height: 1.85;

  /* Layout */
  --content-width: 960px;
  --section-padding: 100px;
  --nav-height: 64px;
  --border-radius-pill: 100px;
  --border-radius-img: 4px;
}
```

---

## 11. ביקורת עיצובית — Wave1 vs. V2 (פרק הספרים)

**תאריך ביקורת:** 2026-04-10 | **בוצע על ידי:** team_100

### תוצאת הביקורת

`books-wave1.css` (הקוד הקיים) מפר **17 הפרות** של 6 כללי העיצוב הנעולים. הקוד לא ניתן לתיקון חלקי. נכתב מחדש כ-`books-v2.css`.

### טבלת הפרות מרכזיות

| אלמנט | Wave1 (שגוי) | V2 (נכון) | כלל |
|--------|-------------|----------|-----|
| פונט hub title | Frank Ruhl Libre 700 | Heebo 200 | 1 |
| פונט H1 ספר | Amatic SC 700 | Heebo 200 | 1 |
| פונט H2/H3 | Rubik 600 | Heebo 200/400 | 1 |
| box-shadow כרטיסים | 2 שכבות | אין | 3 |
| box-shadow כריכה | 2 שכבות | אין | 3 |
| box-shadow כפתורים | כן | אין | 3 |
| border-radius כרטיס | 14px | 0 (flush grid) | 5 |
| border-radius כריכה | 12px | 4px | 5 |
| border-radius כפתורים | 9px | 100px (pill) | 5 |
| רקע כרטיס | linear-gradient | `#FAF8F5` | 2/3 |
| hover כרטיס | translateY(-3px)+shadow | bg→bg-alt | 3 |
| border-bottom title | 2px solid | קו accent ::after 1px×24px | 4 |
| border lead text | 4px solid | 1px solid | 4 |
| border blockquote | 4px solid | 1px solid | 4 |
| gap גריד | 1.35rem | 1px | 4 |
| gradient כפתורים | linear-gradient | flat Terracotta | 2/3 |

### מדד תאימות עיצובית

**תאימות 100% = אפס הפרות:**
- 0 fonts שאינם Heebo על עמודי ספרים
- 0 box-shadow על כל אלמנט
- 0 border-radius מחוץ ל-0/4px/100px
- 0 gradient backgrounds
- 0 transform על hover
- 0 border בעובי >1px
- 0 שימוש Terracotta כרקע שטחי

### קבצים שנוצרו/שונו

| קובץ | פעולה |
|------|-------|
| `assets/css/books-v2.css` | חדש — CSS V2 מלא (30 sections) |
| `assets/js/books-reveal.js` | חדש — scroll-reveal IntersectionObserver |
| `functions.php` | עודכן — slugs, fonts, CSS handle |
| `page-templates/template-books-hub.php` | עודכן — bundle section + reveal |
| `page-templates/template-book-detail.php` | עודכן — reveal classes |

### חבילת יישום

`_communication/team_10/BOOKS-V2-IMPL-PACKAGE-2026-04-10/` — 7 מסמכים לצוותים 10/30/40
