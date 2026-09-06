# חבילת A11Y-CLOSE · עץ מבודד עד שער סבב 1 · 2026-08-31

**צוות:** 100 מנהל · 10 בונה · 90/50 מאמת (מנוע ≠ בנאי)  
**ענף:** `feat/s006-a11y-close`  
**שורש עבודה:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-a11y-close` (clone עצמאי, לא git worktree)  
**אינו** חתימת ת״י 5568 AA · **אין** נגיעה ב-`accessibility-defaults.php` / באנר WP-EI-05 / נוסח ליגל

## למה clone ולא worktree

`move_agent_to_root` מנסה `git checkout main` ביעד. Git worktree נכשל כש-`main` כבר תפוס ב-checkout המקורי. לכן העץ המבודד הוא **clone** מ-`origin/feat/s006-a11y-close`.

## גלים

1. **W0** — baseline דפדפן על 23 עמודי סבב 1 `הוגש לבדיקה` + דגימת 5. בלי שינוי תוכן.
2. **W1** — כרום רוחבי (דילוג אחד, טופס CF7, פוטר, פוקוס, ניגודיות `.foot__disc`). FTP + ניקוי Varnish.
3. **W2** — alt/כותרות לעמודי סבב 1 שהוגשו. בלי שכתוב פסקאות.
4. **W3** — QR / בלוג / EN / ארכיון R2. בלי ליגל, בלי מובייל.
5. **שער** — מיזוג ל-`main` רק אחרי אישור סבב 1 + בקרת אחרי מול baseline.

כלל כשל: שינוי H1 / טקסט גוף / URL CTA = FAIL.

## סטייג'ינג

`http://eyalamit-co-il-2026.s887.upress.link` · FTP אחרי כל גל · ניקוי Varnish/EzCache · לא Enable Accessibility.
