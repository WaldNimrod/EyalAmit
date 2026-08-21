VERDICT: PASS

**מאמת:** team_90 · Composer (`composer-2.5`) · 2026-08-21  
**בנאי הגל:** Cursor Grok 4.6 · Iron Rule #1 (validator ≠ builder)  
**בסיס:** http://eyalamit-co-il-2026.s887.upress.link/testimonials/?ea=w5-validate-20260821 · http://eyalamit-co-il-2026.s887.upress.link/sound-healing/?ea=w5-validate-20260821 · http://eyalamit-co-il-2026.s887.upress.link/method/?ea=w5-validate-20260821 · `curl` · דסקטופ  
**מנדט:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-W5-TESTIMONIALS-2026-08-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-W5-TESTIMONIALS-2026-08-21.md)  
**מקור:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/הערות%20של%20אייל%20לאחר%20סבב%20שלב%201%20-%2019.8.26/המלצות.xlsx](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/הערות%20של%20אייל%20לאחר%20סבב%20שלב%201%20-%2019.8.26/המלצות.xlsx)

**HTTP:** `/testimonials/` **200 OK** · body **71,817** bytes · `/sound-healing/` **200 OK** · **73,660** bytes · `/method/` **200 OK** · **74,618** bytes (לא ריק — לא FAIL).

## בדיקות

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| **1** | ב-`/testimonials/` ה-H1 הוא `עדויות והמלצות` (לא `מדיה ווידאו`) | **CONFIRMED** | `<h1 class="phero__h">עדויות והמלצות</h1>` (שורה 164) · `מדיה ווידאו`: 0 |
| **2** | ב-`/testimonials/` מופיע **דן ארליכמן** עם טקסט `משתף אתכם בכתבה` וקישור פייסבוק `1DKp5Coss8` | **CONFIRMED** | `<blockquote>…משתף אתכם בכתבה…</blockquote>` + `<a … href="https://www.facebook.com/share/p/1DKp5Coss8/">דן ארליכמן</a>` (שורה 171) |
| **3** | ב-`/sound-healing/` ו-`/method/` לקרוסלת העדויות כפתור שמאלה וימינה; אין `testi-scroll` / `animation: … infinite` על ה-track | **CONFIRMED** | `testi-mq__btn--right` `aria-label="הזזה ימינה"` + `testi-mq__btn--left` `aria-label="הזזה שמאלה"` (sound 260/266 · method 248/254) · `testi-scroll` ב-HTML: 0 · `ea-testi-carousel__track` ב-HTML: 0 · track חי: `testi-mq__track` ללא animation inline · `ea-testi-mq.js` נטען |
| **4** | אין תמונות פרופיל מומצאות (`via.placeholder` / `ui-avatars` / hotlink חדש); כפילויות שם בריכוז נשארות | **CONFIRMED** | `via.placeholder` / `ui-avatars`: 0 בכל שלושת העמודים · `<img>` ב-testimonials: נכסי תמה מקומיים (`chapters/*.jpg`) · כפילויות שם: רותי שליט×2, קרין טננצאפ×2, אלכס פלופ×2 — מותר במנדט |
| **5** | קישור «לכל ההמלצות» בעמודי שיטה/סאונד → `/testimonials/` (לא `/media/`) | **CONFIRMED** | sound: `<a class="tlink" href="/testimonials/">לכל ההמלצות על אייל עמית</a>` (274) · method: `<a class="btn btn--gd" href="/testimonials/">לכל ההמלצות</a>` (262) · `href="/media/"`: 0 |
| **6** | לא נדרש בגל 5: שכתוב ציטוטים ל-50 מילים; סרטונים/כתבות (M-04) | **N/A — לא FAIL** | לא נכלל בהיקף מנדט גל 5 |

## היקף בנאי (לא נבדק כ-FAIL)

| פריט | הערה |
|------|------|
| `videoblk.php` · `block-faq-list.php` | מנדט: אסור — לא מופיעים ב-HTML (0 בכל שלושת העמודים) |
| קבצים dirty מלפני הגל | מוחרגים במנדט |
| `testimonials-carousel.css` מכיל `@keyframes ea-testi-scroll` ל-`.ea-testi-carousel__track` | לא בשימוש בעמודים החיים — הקרוסלה החיה היא `testi-mq` עם כפתורים |

## סיכום

חמש הבדיקות החיות של גל 5 · המלצות + קרוסלה עברו על הסטייג'ינג. H1 «עדויות והמלצות»; דן ארליכמן עם כתבה וקישור FB; קרוסלה ידנית עם כפתורי שמאלה/ימינה ללא גלילה אוטומטית על ה-track; ללא placeholder לפרופיל; קישור «לכל ההמלצות» מוביל ל-`/testimonials/`.
