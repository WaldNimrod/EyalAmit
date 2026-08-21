VERDICT: PASS

**מאמת:** team_90 · Composer (`composer-2.5`) · 2026-08-22  
**בנאי הגל:** Cursor Grok 4.6 · Iron Rule #1 (validator ≠ builder)  
**בסיס:** `curl` · http:// בלבד · דסקטופ · סטייג'ינג חי  
**מנדט:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-W10-LECTURES-WORKSHOPS-2026-08-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-W10-LECTURES-WORKSHOPS-2026-08-21.md)

**HTTP:** `http://eyalamit-co-il-2026.s887.upress.link/learning/lectures/` **200** · **59,506** bytes · `http://eyalamit-co-il-2026.s887.upress.link/learning/workshops/` **200** · **72,223** bytes · `http://eyalamit-co-il-2026.s887.upress.link/faq/` **200** · **198,085** bytes (לא ריק).

## בדיקות

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| **1** | `/learning/lectures/` H1 `הרצאות על נשימה, דיג'רידו, סטרס ושינה` · CTA ל-`/contact/` · אין באנר `ממתין לאישור` · אין בלוק `מה אומרים אחרי ההרצאה` | **CONFIRMED** | `<h1 class="phero__h">הרצאות על נשימה, דיג'רידו, סטרס ושינה</h1>` · `<a class="btn btn--gw" href="/contact/">לתיאום הרצאה</a>` · `ממתין לאישור`: **0** · `מה אומרים אחרי ההרצאה`: **0** |
| **2** | בהרצאות: קישור ל-`/eyal-amit/mokesh-dahiman/` (לא `/mokesh-dahiman` חשוף) וקישור ל-`/learning/workshops/` | **CONFIRMED** | `<a class="tlink" href="/eyal-amit/mokesh-dahiman/">מוקש דהימן</a>` · `<a class="tlink" href="/learning/workshops/">סדנאות דיג'רידו ונשימה</a>` · אין `href` ל-`/mokesh-dahiman` ללא `eyal-amit` |
| **3** | `/learning/workshops/` H1 `סדנאות דיג'רידו ונשימה לקבוצות וארגונים` · `נשימה מעגלית בדיג'רידו` (לא קיצור) · `כרגע אין מועד` · אין באנר `ממתין לאישור` | **CONFIRMED** | `<h1 class="phero__h">סדנאות דיג'רידו ונשימה לקבוצות וארגונים</h1>` · `נשימה מעגלית בדיג'רידו`: **5** · `<p>כרגע אין מועד חדש לסדנה פתוחה.</p>` · `ממתין לאישור`: **0** |
| **4** | בסדנאות: קישור ל-`/eyal-amit/mokesh-dahiman/` ול-`/method/` | **CONFIRMED** | `href="/eyal-amit/mokesh-dahiman/"` · `href="/method/"` (מספר מופעים בגוף העמוד) |
| **5** | ב-`/faq/` TOC: לשונית `הרצאות` · לשונית `סדנאות דיג'רידו` · לשונית `טיפול בנחירות ודום נשימה` | **CONFIRMED** | `<a class="ea-faq-toc__link" href="#faq-topic-lectures" data-faq-toc-link="lectures">הרצאות</a>` · `<a class="ea-faq-toc__link" href="#faq-topic-workshops" data-faq-toc-link="workshops">סדנאות דיג&#039;רידו</a>` · `<a class="ea-faq-toc__link" href="#faq-topic-snoring-sleep-apnea" data-faq-toc-link="snoring-sleep-apnea">טיפול בנחירות ודום נשימה</a>` |
| **6** | `videoblk.php` · `block-faq-list.php` — לא נבדק כ-FAIL | **N/A** | לא מופיעים ב-HTML (**0** בכל שלושת העמודים) · קבצים dirty מלפני הגל מוחרגים במנדט |

## היקף בנאי (לא נבדק כ-FAIL)

| פריט | הערה |
|------|------|
| `videoblk.php` · `block-faq-list.php` | מנדט: אסור — לא מופיעים ב-HTML (0) |
| קבצים dirty מלפני הגל | מוחרגים במנדט |

## סיכום

שש בדיקות החיות של גל 10 · הרצאות וסדנאות עברו על הסטייג'ינג: H1 ותוכן תקינים, קישורי mokesh/method/workshops, CTA ליצירת קשר, ללא באנרי «ממתין לאישור» וללא בלוק «מה אומרים אחרי ההרצאה», ולשוניות FAQ חדשות להרצאות/סדנאות/נחירות ב-TOC.
