# M2 — אימות משוב צוות 10 + הוראות המשך (G2)

**תאריך:** 2026-04-01  
**מקור משוב:** [`../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md)  
**מאמת:** צוות **100** / **20** (מסמך זה)

**מנדטים + GO 10:** [`../team_100/M2-GATE-20A-AMENDMENT-AND-GO-TEAM10-2026-04-02.md`](../team_100/M2-GATE-20A-AMENDMENT-AND-GO-TEAM10-2026-04-02.md) · אינדקס [`../team_100/M2-G2-MANDATE-SEQUENCE-INDEX-2026-04-02.md`](../team_100/M2-G2-MANDATE-SEQUENCE-INDEX-2026-04-02.md) · **20:** [`M2-MANDATE-G2-PREREQ-TEAM20-2026-04-02.md`](./M2-MANDATE-G2-PREREQ-TEAM20-2026-04-02.md) · **10:** [`../team_10/M2-MANDATE-G2-TEAM10-2026-04-02.md`](../team_10/M2-MANDATE-G2-TEAM10-2026-04-02.md)

---

## 1. אימות במאגר (עבר)

| פריט | מסקנה |
|------|--------|
| **Child `ea-eyalamit`** | [`site/wp-content/themes/ea-eyalamit/functions.php`](../../site/wp-content/themes/ea-eyalamit/functions.php) — מסנן `body_class` מוסיף `ea-lang-en` ל־`is_page( 'en' \| 'english' )`; קידומת `ea_`; עקבי עם WP-THEME §5 (EN LTR). |
| **CSS** | [`style.css`](../../site/wp-content/themes/ea-eyalamit/style.css) גרסה **1.0.1**, כללי LTR ל־`body.ea-lang-en`. |
| **WXR** | [`site/exports/m2-pages-seed.wxr`](../../site/exports/m2-pages-seed.wxr) — עמודים תואמים רשימת הסקריפט; **P22** `shop`; **P23** ילד של **P11** (`wp:post_parent` 510); **`courses-soon`** ל־F11-b. |
| **סקריפט** | [`scripts/m2_emit_pages_wxr.py`](../../scripts/m2_emit_pages_wxr.py) רץ מהשורש ומייצר מחדש את ה־WXR (`python3 scripts/m2_emit_pages_wxr.py`). |
| **תיעוד `site/`** | [`site/README.md`](../../site/README.md) מתעד WXR + סקריפט. |
| **סיכום 10** | מבנה טבלאות §7, תפריטים T1–T6, F5–F16, Yoast + Fluent, קאש שרת, QR DEFERRED — **עקבי** עם M2-WORKPLAN §6. |

**הערת ייבוא WXR:** ב־WXR מופיע `<dc:creator>admin</dc:creator>` — בייבוא ב־wp-admin ודאו שמשתמש **`admin`** (או מיפוי מחבר) קיים, או עדכנו את הסקריפט לשם משתמש קיים ו־**הריצו מחדש** את `m2_emit_pages_wxr.py` לפני ייבוא.

---

## 2. ממצאי בדיקת רשת (סטייג'ינג — לפי דוח 10)

אלה **לא** פערי מאגר אלא **מצב שרת** שדורש השלמה ב־wp-admin / FTP / uPress:

| נושא | מצב | בעלות |
|------|-----|--------|
| **תמה פעילה** | **עודכן 2026-04-03:** פלט HTML מציג **GP + child `ea-eyalamit`** אחרי פריסת FTP + בקשה לדף הבית — לאמת ב־50 | **צוות 50** — לאשר ב־דוח תשתית; אם חוזר TT5 — **צוות 10** לבדוק mu-plugin / הפעלת תמה. |
| **`noindex` סטייג'ינג** | לא ב־`<head>` עד העלאת [`ea-staging-noindex.php`](../../site/wp-content/mu-plugins/ea-staging-noindex.php) | **צוות 10** (FTP) + אימות `view-source`. |
| **SSL** | אימות מחמיר נכשל — **תעודה שפגה** (דיווח 10) | **צוות 20** — פאנל uPress / תמיכה: **חידוש או יישור תעודה** לדומיין הסטייג'ינג; עדכון runbook §6 לאחר תיקון. |

---

## 3. הוראות לצוות 20 (תשתית)

1. **SSL:** לפתוח/לממש חידוש תעודה ל־`eyalamit-co-il-2026.s887.upress.link` (או הנחיה מ־uPress אם יש כפתור "חדש תעודה").  
2. **אימות:** `curl -I https://eyalamit-co-il-2026.s887.upress.link/` ללא `-k` — לצפות ל־200 ללא שגיאת אישור.  
3. **תיעוד:** לעדכן [`M2-RUNBOOK-ENV-2026-03-31.md`](./M2-RUNBOOK-ENV-2026-03-31.md) §6 בהערת "תוקף תעודה — תוקן ב־<תאריך>" כשהושלם.  
4. **לא** לשנות את לוגיקת ה־mu-plugin ל־noindex — היא נכונה; הבעיה הייתה העדר פריסה / תמה, לא הקוד.

---

## 4. הוראות לצוות 10 (השלמת G2 על הסטייג'ינג)

עקבו אחרי [`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) §10 ובמילים:

1. גיבוי (אם לא מאז השינוי האחרון).  
2. התקנת **GeneratePress**.  
3. **FTP:** `ea-eyalamit/` (גרסת מאגר עדכנית) + `ea-staging-noindex.php`.  
4. **הפעלת child** EA Eyal Amit.  
5. **Permalink** `/%postname%/` — לתעד בסיכום §7.  
6. **ייבוא** `m2-pages-seed.wxr` → **הגדרות → קריאה:** דף בית סטטי «בית», פוסטים «בלוג».  
7. **Yoast** + **Fluent Forms** + טופס בצור קשר; **P15** noindex ב־Yoast.  
8. **תפריטים** T1–T6 לפי הסיכום §5.  
9. **`view-source`** — אימות `noindex` בסטייג'ינג.  
10. **מילוי עמודת מזהה WP** בטבלת §4 בסיכום + **חתימת צ'קליסט** ב־[`M2-HANDOFF-FROM-20-2026-03-31.md`](../team_10/M2-HANDOFF-FROM-20-2026-03-31.md) §4.  
11. אחרי SSL תקין — לחזור על בדיקת `curl` / דפדפן (ללא התעלמות מאזהרות).

---

## 5. שיפור אופציונלי (לא חוסם M2)

- **`lang` על מסמך EN:** כרגע יש LTR ב־`body`; שקלו בהמשך מסנן `language_attributes` או תבנית עמוד ל־`lang="en"` על `<html>` ל־SEO/נגישות — **G3+**.  
- **Lighthouse:** למדוד אחרי GeneratePress + child פעילים על דף ריק/כמעט ריק (§6.3 M2).

---

**קישורים:** [`STAGING-CHANNEL-STATUS-2026-03-31.md`](./STAGING-CHANNEL-STATUS-2026-03-31.md) · [`M2-HANDOFF-FROM-20-2026-03-31.md`](../team_10/M2-HANDOFF-FROM-20-2026-03-31.md)
