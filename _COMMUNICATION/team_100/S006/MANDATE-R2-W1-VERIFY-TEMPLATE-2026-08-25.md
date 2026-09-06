# MANDATE — team_100 subagent · W1 verify-only (fill ROW / PATH / TARGET)

**מנהל:** team_100 · **בנאי:** Cursor Grok · **לא מאמת E2E. לא FTP. לא PHP.**
**מפה:** [MAP-S006-R2-W1-301-2026-08-25.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/MAP-S006-R2-W1-301-2026-08-25.md)

שורה ראשונה: `RECOMMEND: VERIFY_DONE|ASK_NIMROD`

## זהות (למלא)

```
שורה: {ROW}
נתיב: {PATH}
יעד נעול: {TARGET}
גל: W1
סוג: 301-אימות
מקור: שורת טרקר «אימות יעד 301 בלבד» + HEAD 24.8
מחוץ לסקואופ: 23 עמודי סבב 1 · טופס סבב 1 · כל PHP · videoblk.php · wp-admin
```

## מה לעשות

1. `curl -sI --max-time 8 http://eyalamit-co-il-2026.s887.upress.link{PATH}`
2. ודא קוד ראשון 301 ו-Location מסתיים ב-{TARGET} (קפיצה אחת; www/http מותר).
3. `curl -sI` ליעד — 200.
4. כתוב דוח קצר ל-`_COMMUNICATION/team_100/S006/VERIFY-{ROW}-W1-2026-08-25.md` עם הקודים וה-Location.
5. אם היעד זז או 301 שגוי — `ASK_NIMROD`. **אל תתקן PHP.**

R2-004: היעד `/learning/courses-external/` נשאר. לא ממציאים URL.

## אסור

PHP · FTP · git · defaults של סבב 1 · שינוי יעד.
