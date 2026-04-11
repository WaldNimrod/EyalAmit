# מפרט ייצוא לוגו — לצוות עיצוב
**תאריך:** 2026-04-11 | **פרויקט:** EyalAmit.co.il-2026

---

## רקע

מקור הלוגו הנוכחי: `master logo cbdidg.psd` (קובץ Photoshop).  
השימוש הנוכחי: `ea-logo.jpg` בלבד (472×472px, JPEG, ~31KB) — **איכות לא מספיקה לאתר מלא**.  
כל רקעי האתר: **בהירים/חמים** (פלטת חול, נייר, לבן). **אין רקע כהה — אין צורך בגרסה הפוכה (לבנה) למסכים.**

---

## סט לוגו מלא — פרטי ייצוא

### קבצים נדרשים

| שם קובץ | פורמט | גודל | רקע | שימוש |
|---------|-------|------|-----|-------|
| `ea-logo.svg` | SVG | וקטור (scalable) | **שקוף** | קובץ מאסטר — כל שימוש מדויק ו-retina |
| `ea-logo-512.png` | PNG-24 | 512 × 512 px | **שקוף** | ייצוא יכולות גבוהות, Downloads, PWA splash |
| `ea-logo-256.png` | PNG-24 | 256 × 256 px | **שקוף** | שימוש כללי, Header @2x |
| `ea-logo-192.png` | PNG-24 | 192 × 192 px | **שקוף** | PWA manifest icon |
| `ea-logo-128.png` | PNG-24 | 128 × 128 px | **שקוף** | Header @1x, נדרש לשימוש בנייד |
| `ea-favicon.ico` | ICO | 16×16 + 32×32 (multi-size) | **שקוף** | לשונית דפדפן |
| `ea-favicon-32.png` | PNG-24 | 32 × 32 px | **שקוף** | Favicon מודרני (Chrome, Safari) |
| `ea-favicon-16.png` | PNG-24 | 16 × 16 px | **שקוף** | Favicon מינימלי |
| `ea-og-image.jpg` | JPEG | **1200 × 630 px** | **#D8C7B5 (חול)** | Open Graph / שיתוף לינקדאין, פייסבוק, וואטסאפ |
| `ea-logo-print.png` | PNG-24 | 1000 × 1000 px | **לבן #FFFFFF** | הדפסה, PDF, חתימת מייל |

**סה״כ:** 10 קבצים

---

## גרסאות צבע

| גרסה | שימוש | רקע |
|------|-------|-----|
| **Full color** (גרסה יחידה) | Header, Footer, Print, OG | שקוף / לבן / חול |
| ❌ גרסה לבנה | לא נדרש — אין רקע כהה באתר | — |
| ❌ Monochrome | לא נדרש לעת עתה | — |

---

## הנחיות ייצוא

### SVG
- ייצוא ישיר מ-Photoshop לא מומלץ — להמיר דרך Illustrator או Inkscape
- לוודא: אין `viewBox` שגוי, אין fonts embedded (להמיר לנתיבים/paths)
- שמירה: `Save As → SVG → SVG Tiny 1.2` או Illustrator SVG עם embed=no
- בדיקה: לפתוח ב-Chrome ולוודא רינדור נכון

### PNG (כל הגדלים)
- Export As → PNG-24
- רקע: **שקוף** (למעט `ea-logo-print.png` שרקעו לבן, ו-`ea-og-image.jpg` שרקעו חול)
- Color Space: sRGB
- לא לשמור עם "Photoshop metadata" — לשמור כ-web

### ICO
- לייצר מ-`ea-favicon-32.png` + `ea-favicon-16.png`
- כלי מומלץ: [favicon.io](https://favicon.io) או ImageMagick
- שמירה: `ea-favicon.ico`

### OG Image (1200×630)
- רקע: גוון חול `#D8C7B5`
- לוגו ממורכז — גודל מומלץ: 400×400px בתוך הקנבס
- שם האתר / "אייל עמית" — טיפוגרפיה Heebo Light 300, Ink #2E2B28
- **ללא אלמנטים עדינים מאוד** — נדרש להיראות ב-thumbnail 600×315px

---

## מיקום שמירה (במאגר)

```
site/wp-content/themes/ea-eyalamit/assets/images/
├── ea-logo.svg           ← חדש (מאסטר)
├── ea-logo.jpg           ← קיים (להשאיר לאחורה)
├── ea-logo-512.png       ← חדש
├── ea-logo-256.png       ← חדש
├── ea-logo-192.png       ← חדש
├── ea-logo-128.png       ← חדש
├── ea-favicon.ico        ← חדש
├── ea-favicon-32.png     ← חדש
├── ea-favicon-16.png     ← חדש
└── ea-og-image.jpg       ← חדש
```

קובץ ה-print:
```
docs/assets/
└── ea-logo-print.png     ← להדפסה / PDF
```

---

## אחרי קבלת הקבצים

1. להוסיף `ea-logo.svg` (ולחלופין `ea-logo-128.png`) ל-`header.php` במקום `ea-logo.jpg`
2. להוסיף ל-`<head>` ב-WordPress:
   ```html
   <link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/ea-eyalamit/assets/images/ea-favicon-32.png">
   <link rel="icon" type="image/png" sizes="16x16" href="/wp-content/themes/ea-eyalamit/assets/images/ea-favicon-16.png">
   <link rel="shortcut icon" href="/wp-content/themes/ea-eyalamit/assets/images/ea-favicon.ico">
   <meta property="og:image" content="https://www.eyalamit.co.il/wp-content/themes/ea-eyalamit/assets/images/ea-og-image.jpg">
   ```
3. לעדכן את `EYAL-ASSET-LOGO-PSD-2024` ב-`hub/data/content-index.json` מ-`blocked` ל-`ingested`

---

## הערה לצוות

הלוגו הנוכחי הוא **ריבועי** (קצב גובה-רוחב 1:1). גודל ה-Header מוגדר ל-`max-height: 40px; width: auto` — כלומר הלוגו יוצג בגודל **40×40px** בפועל בניווט. לוודא שהלוגו קריא וברור בגודל זה.

**בדיקת favicon במיוחד** — ב-16×16px הפרטים הקטנים נעלמים. אם הלוגו עשיר בפרטים, לשקול גרסת favicon פשוטה יותר (ראשי תיבות, אות בודדת, או עיגול צבע).
