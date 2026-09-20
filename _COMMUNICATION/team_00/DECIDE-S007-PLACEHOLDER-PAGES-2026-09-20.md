---
id: DECIDE_S007_PLACEHOLDER_PAGES_2026-09-20
schema_version: aos_v1_team_messaging
type: DECISION REQUEST (team_100 → team_00)
from: team_100
to: team_00
cc: [team_10]
date: 2026-09-20
severity: HIGHEST of anything found tonight
found_during: M-12, while looking at a screenshot of a header
---

# חמישה עמודים מפורסמים מגישים טקסט ממלא מקום

**זה הממצא הכי חמור של הלילה, והוא לא באג בקוד.** צף כשהסתכלתי בצילום מסך של כותרת
בעמוד שירותים, וראיתי מה כתוב מתחתיה.

## מה שמוגש היום למבקר

**בעמוד שירותים:** «עמוד הורה לשירותים — placeholder».

**בעמוד הופעות ומורשת:** «מופע ניווט משני — placeholder».

**בכתבות היסטוריות:** «אופציונלי — placeholder».

**בעמוד תודה:** «דף תודה אחרי טפסים — אם בשימוש» — הערה פנימית ולא תוכן.

**ובקורסים החיצוניים, במילים שלנו עצמנו:** «PLACEHOLDER — G3 — v1 — 2026-04-01 — לא לאישור
פרסום סופי».

**העמוד האחרון אומר על עצמו שהוא לא מאושר לפרסום, והוא מפורסם.**

## ולמה זה גרוע יותר ממה שזה נשמע

**אין באף אחד מהם תג שמונע מגוגל לאנדקס.** **וכולם נמצאים במפת האתר שאנחנו מגישים למנועי
החיפוש באופן פעיל.**

**בשרת הבדיקות יש חסימה ברמת השרת** ולכן אף אחד לא רואה את זה היום. **בדומיין האמיתי החסימה
הזו לא קיימת** — **וחמישה עמודי ממלא מקום ייכנסו לאינדקס.**

## ולמה זה עולה דווקא עכשיו

**המגירה החדשה נותנת לששת העמודים האלה תפריט עובד בפעם הראשונה.** **כלומר אנחנו בדיוק עכשיו
מגדילים את התנועה אליהם.** לא נכון להשלים את זה בלי להכריע מה יש בהם.

## מה אני לא עושה

**לא כותב להם תוכן.** חוק התוכן כאן מוחלט — **רק מה שקיים, מה שהגיע מאייל בקבצים, ומה שאמרת
אתה.** עמוד שירותים צריך טקסט שירותים, ואין לי אותו ואסור לי להמציא אותו.

## שלוש דרכים, וההכרעה שלך

**להוריד מפרסום** עד שיש תוכן. הכי בטוח, ושובר קישורים אם מישהו מקשר אליהם.

**להשאיר מפורסמים ולחסום אינדוקס** — להוציא ממפת האתר ולהוסיף תג חסימה. **מונע את הנזק
בחיפוש, ולא מונע ממבקר שהגיע מהתפריט לקרוא «placeholder».**

**לקבל תוכן מאייל** לחמישה עמודים. הנכון ביותר, והאיטי ביותר.

**ההמלצה שלי היא השנייה עכשיו והשלישית אחריה** — חסימה מיידית כי היא לוקחת דקות ומסירה את
הסיכון הגדול, ובקשת תוכן מאייל באותה רשימה שאתה מביא ממנו ממילא מחר.

**ואם ההכרעה היא הורדה מפרסום — תגיד לי לפני שאנחנו מסיימים את המגירה**, כי אין טעם לתת
תפריט עובד לעמודים שעומדים לרדת.

---

## ✅ הכרעת team_00 — 20 בספטמבר 2026

**מקור — לשונו של נימרוד:**

> «עמודים שלא מאושרים לפרסום - נכון להחזיק באתר סטייגינג שלנו - זה לאייל להשלים תוכן.
> מה שכן - מציע לעדכן את הטראקר שלנו בהתאם, ואת הטופס לאייל - להכין טופס נוסף עם התאריך
> של היום - ולציין לאייל בדיוק איפה נדרש השלמת תוכן.
> שימו לב האתר עוד לא פורסם ולא עולה לאוויר- העליה לאוויר היא כשנעבור לכתובת הראשית בדומיין.»

**Canonical ruling (English — binding for all teams):**

1. **The five placeholder pages STAY on staging, published, unchanged.** Holding
   not-yet-approved pages on our own staging site is correct and expected. Do not unpublish
   them, do not add a robots block, do not remove them from the sitemap.
2. **The content is Eyal's to complete.** No team writes copy for these pages. The standing
   content law is unchanged.
3. **The premise of the escalation was wrong on urgency, not on fact.** The site is NOT
   published and NOT live. Going live happens only when we move to the primary domain. Until
   that cutover, nothing on staging can be indexed from the real domain, so there is no
   live search-exposure risk to mitigate today.
4. **Before the domain cutover, this file must be re-read.** Everything in the sections
   above becomes live risk at the moment the primary domain is pointed here. The cutover
   checklist owns it from then on.
5. **Actions ordered by team_00 and completed 2026-09-20:** the tracker was updated to match
   reality, and a new dated form for Eyal was produced naming every place content is missing.

**Status:** CLOSED. Superseded for the cutover by the re-read duty in item 4.
