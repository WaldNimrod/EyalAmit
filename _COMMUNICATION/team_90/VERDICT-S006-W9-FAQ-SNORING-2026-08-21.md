VERDICT: PASS

**מאמת:** team_90 · Composer (`composer-2.5`) · 2026-08-22  
**בנאי הגל:** Cursor Grok 4.6 · Iron Rule #1 (validator ≠ builder)  
**בסיס:** `curl` · http:// בלבד · דסקטופ · סטייג'ינג חי  
**מנדט:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-W9-FAQ-SNORING-2026-08-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-W9-FAQ-SNORING-2026-08-21.md)

**HTTP:** `http://eyalamit-co-il-2026.s887.upress.link/faq/` **200** · **170,114** bytes · `http://eyalamit-co-il-2026.s887.upress.link/snoring-sleep-apnea/` **200** · **90,612** bytes (לא ריק).

## בדיקות

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| **1** | `/faq/` **אינו** מכיל `👉 לפני שממשיכים` (בלוק 2 ירד) | **CONFIRMED** | `grep -c '👉 לפני שממשיכים'`: **0** |
| **2** | בסרגל הראשי «טיפול בדיג׳רידו» דרופ עם קישור ל-`/snoring-sleep-apnea/` | **CONFIRMED** | `<a class="nav__dd" href=".../treatment/">טיפול בדיג׳רידו<span class="nav__caret"...` · `<li><a href=".../snoring-sleep-apnea/">נחירות ודום נשימה בשינה</a></li>` |
| **3** | FAQ: href `/books/` (לא `/muse`) ליד ספרים · `בהחלט, כל הפרטים בדף` | **CONFIRMED** | `href="/books/"`: **2** · `/muse`: **0** · `<p>בהחלט, כל הפרטים בדף <a class="tlink" href="/books/">ספרים</a>.</p>` |
| **4** | שאלת הריון כוללת URL בלוג (מדויק) | **CONFIRMED** | `<a class="tlink" href="https://www.eyalamit.co.il/Blog/%d7%a0%d7%a9%d7%99%d7%9d-%d7%9e%d7%a0%d7%92%d7%a0%d7%95%d7%aa-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%90%d7%99%d7%a9%d7%94-%d7%9e%d7%a0%d7%92%d7%a0%d7%aa-%d7%91%d7%93%d7%99%d7%92/">קראו עוד</a>` |
| **5** | שאלות נחירות ב-FAQ כוללות קישור ל-`/snoring-sleep-apnea/` · אין באנר `ממתין לאישור` על CPAP | **CONFIRMED** | `snoring-sleep-apnea`: **8** ב-FAQ · `ממתין לאישור`: **0** · שאלת CPAP: `<h3...>האם דיג'רידו מחליף מכשיר CPAP?</h3>` + `<a class="tlink" href="/snoring-sleep-apnea/">עמוד נחירות ודום נשימה</a>` (ללא באנר) |
| **6** | `/snoring-sleep-apnea/`: H2 `תוכן עניינים` · `maccabi.jpg` · `yoni-whatsapp.jpg` · אין באנר מעל יוני | **CONFIRMED** | `<h2 class="h2 r">תוכן עניינים</h2>` · `chapters/snoring/maccabi.jpg` · `chapters/snoring/yoni-whatsapp.jpg` · `ממתין לאישור`: **0** · `<section class="sec" id="הסיפור-של-יוני">` ללא באנר |
| **7** | אין לשונית FAQ חדשה ל«סדנאות» / «הרצאות» (גל 10) | **CONFIRMED** | TOC: `faq-topic-treatment` … `vekatavta` · **אין** `faq-topic-workshops` / `faq-topic-lectures` · ניווט ראשי ל-`/learning/workshops/` ו-`/learning/lectures/` קיים (מותר) |
| **8** | `videoblk.php` · `block-faq-list.php` — לא נבדק כ-FAIL | **N/A** | לא מופיעים ב-HTML (0) · קבצים dirty מלפני הגל מוחרגים במנדט |

## היקף בנאי (לא נבדק כ-FAIL)

| פריט | הערה |
|------|------|
| `videoblk.php` · `block-faq-list.php` | מנדט: אסור — לא מופיעים ב-HTML (0) |
| קבצים dirty מלפני הגל | מוחרגים במנדט |

## סיכום

שמונה בדיקות החיות של גל 9 · FAQ + נחירות עברו על הסטייג'ינג: בלוק 2 הוסר, דרופ טיפול עם עמוד נחירות, קישורי ספרים/הריון/נחירות תקינים, עמוד נחירות עם TOC ותמונות מכבי/יוני ללא באנרי «ממתין לאישור», וללא לשוניות FAQ חדשות לסדנאות/הרצאות.
