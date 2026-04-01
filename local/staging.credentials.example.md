# פרטי סטייג'ינג — תבנית (ללא סודות)

**אל** לשמור קובץ ממולא ב-Git.

1. העתק קובץ זה ל־**`staging.credentials.md`** (אותה תיקייה).
2. מלא ערכים. הקובץ `staging.credentials.md` מופיע ב־`.gitignore`.

---

## FTP / SFTP

- **פרוטוקל:** (SFTP / FTP)
- **Host:**
- **Port:**
- **Username:**
- **Password:** _(רק בקובץ המקומי `staging.credentials.md`)_
- **נתיב מרוחק (remote path):** _(למשל שורש אתר / public_html — כפי שמופיע ב-uPress)_

## WordPress

- **URL אתר:**
- **URL wp-admin:**
- **שם משתמש מנהל** (או משתמש פיתוח): _(שם בלבד; סיסמה בקובץ המקומי או ב-vault)_
- **סיסמה / App Password:** _(רק בקובץ המקומי — לא כאן)_

## מסד נתונים (אופציונלי)

- **URL phpMyAdmin:** _(כתובת מלאה מהפאנל uPress — לעיתים לא תחת דומיין האתר)_
- **גישה:** phpMyAdmin / פאנל
- **שם בסיס נתונים (MySQL):**
- **משתמש MySQL:**
- **סיסמת MySQL / הערות:** _(רק בקובץ `staging.credentials.md` המקומי — לא בדוגמה)_

## הערות

- עדכוני **קבצים** (תבניות, תוספים, ליבה אם מותר): FTP/SFTP.  
- עדכוני **DB**: בדרך כלל דרך WP / phpMyAdmin / ייבוא SQL מבוקר — לא "פרוטוקול FTP ל-DB".
