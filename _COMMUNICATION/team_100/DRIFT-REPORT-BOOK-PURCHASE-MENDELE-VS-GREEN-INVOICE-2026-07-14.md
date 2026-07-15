---
id: DRIFT-REPORT-BOOK-PURCHASE-MENDELE-VS-GREEN-INVOICE-2026-07-14
from_team: team_100
to_team: team_00, team_110
date: 2026-07-14
type: drift-report
wp: WP-CANON-TEMPLATE-UNIFICATION (residual) + commerce canon
severity: team_00 chat 2026-07-14 — «רכישת ספרים — לא מבין איך חזר הדריפט… חשבונית ירוקה… כפתור מותמע לתשלום»
---

# DRIFT — רכישת ספרים: Mendele חזר במקום חשבונית ירוקה

## Canon (נעול)

| מקור | כלל |
|------|-----|
| `docs/project/team-100-preplanning/GREEN-INVOICE-LINK-MAP.md` v1.1 | עמוד ספר סטטי + **כפתור אחד** → URL חשבונית ירוקה (`mrng.to/…`). אין עגלה ב-WP. |
| `D-EYAL-GREEN-UX-06` | ללא סליקה מוטמעת ב-WP; כפתור חיצוני ל-Morning. |
| POC + live | ספר **כושי בלאנטיס** — `https://mrng.to/MTUiO3vkIg` (אושר מאייל 2026-04-06) |

## מה קרה (שורש הדריפט)

1. **Canon נכון על כושי בלבד** — `kushi-blantis-defaults.php` משתמש ב-`mrng.to/MTUiO3vkIg` לכפתור הרכישה הראשי (מודפס).
2. **ב־WP-CANON T3b (יולי 2026)** עמודי **וכתבת** ו**צבע בכחול** נבנו מתוכן מקור ישן שכלל קישורי **Mendele** כ-verbatim «URL חיצוני לרכישה» — בלי ליישר מול GREEN-INVOICE-LINK-MAP / דפוס כושי.
3. **C-5** תועד כ«איזה סלאג מנדלי נכון» — זה עצמו דריפט: השאלה הנכונה היא **URL חשבונית ירוקה לכל ספר**, לא מנדלי.
4. **סעיף 8 ב-PDF לאייל (14.7)** ניסח בקשה ל-5 מוצרי חנות כאילו אין דוגמה — בעוד שדוגמת `mrng.to/MTUiO3vkIg` כבר קיימת ואושרה; team_00 הורה: **להשתמש בדוגמה בכל העמודים עכשיו**, ולעדכן לקישור מדויק כשיתקבל.

## מצב לפני תיקון (2026-07-14)

| עמוד | כפתור ראשי | סטטוס |
|------|------------|--------|
| `/books/kushi-blantis/` | `mrng.to/MTUiO3vkIg` | תקין (canon) |
| `/books/vekatavta/` | `mendele.co.il/product/vekatavta/` | **דריפט** |
| `/books/tsva-bekahol/` | Mendele + contact להדפסה | **דריפט** |
| 5 עמודי מוצר | `ea_w2_05_gi_url_map()` ריק → contact/WhatsApp | חסר GI (ממתין ל-URL מדויק; בינתיים דוגמה) |

## תיקון (team_00 2026-07-14)

- וכתבת + צבע בכחול: כפתור ראשי = **דוגמת** `https://mrng.to/MTUiO3vkIg` (placeholder עד URL ייעודי לספר).
- 5 מוצרים: אותו placeholder ב-`ea_w2_05_gi_url_map()`.
- הסרת Mendele/contact כנתיב רכישה ראשי מספרי הספרים.
- PDF/Hub: סעיף 8 = «שלח URL מדויק לכל ספר/מוצר; בינתיים דוגמה חיה».

## מה לא נפתח מחדש

- לא מחזירים מנדלי כסליקה.
- לא «חנות אחרת» / הפניה חיצונית שאינה חשבונית ירוקה.
