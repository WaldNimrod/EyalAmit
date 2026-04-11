חבילה לאייל — פורמט קנוני להגשת תוכן + תבניות (2026-04-06)
================================================================

תוכן התיקייה
------------
• CANONICAL-CONTENT-SUBMISSION-FROM-EYAL.md — המפרט המלא (עץ נעול, שדות, JSON/Markdown, אינסטנסים).
• page-templates.json — צילום מצב מתוך hub/data (שדות לפי tpl-*).
• site-tree.json — צילום מצב מתוך hub/data (עץ IA נעול).
• SITE-TREE-DIRECT-LINK.txt — קישור ישיר לעץ על השרת (אחרי פריסה).

קישור ישיר לקובץ site-tree.json על שרת הסטייג'ינג (uPress)
----------------------------------------------------------
לאחר הרצה מוצלחת של:
  python3 scripts/build_eyal_client_hub.py
  python3 scripts/ftp_publish_eyal_client_hub.py
הקובץ זמין ב-HTTP בנתיב הקבוע:

  http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/data/site-tree.json

(הבסיס מגיע מ-UPRESS_PUBLIC_BASE ו-UPRESS_EYAL_HUB_PATH ב-local/.env.upress — בפרודקשן יוחלף הדומיין, הנתיב היחסי נשאר.)

הערה: פריסה מסביבת העבודה הנוכחית נכשלה ב-timeout ל-FTP; יש להריץ ftp_publish מהמחשב עם גישה לשרת.

מקור במאגר
-----------
המפרט המתעדכן תמיד נשאר גם ב:
  docs/project/eyal-ceo-submissions-and-responses/from-eyal/CANONICAL-CONTENT-SUBMISSION-FROM-EYAL.md
עותק כאן מיועד למסירה לאייל (Drive / מייל) בלי לצלול לעץ הקבצים של המאגר.
