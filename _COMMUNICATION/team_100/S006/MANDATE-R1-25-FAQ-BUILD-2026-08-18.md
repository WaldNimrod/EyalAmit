# MANDATE — team_100 subagent · R1-25 `/faq/` · gates 1–4 (wave 3 paste)

**סקואופ נעול (team_00):** `סקואופ אושר: R1-17, R1-18, R1-19, R1-25, R1-28 בלבד` + הקפאת `R1-07, R1-08, R1-09, R1-27`
**העמוד הזה בלבד:** R1-25 `/faq/` · http://eyalamit-co-il-2026.s887.upress.link/faq/
**בנאי:** Cursor Grok · **לא מאמת.** Iron Rule #1.
**דין:** `_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md` §2 · §3א · §3ג · §8ד
**פקודות:** `_COMMUNICATION/team_100/S006/HANDOFF-TEMPLATE-GENERIC.md` v3.1.0
**דסקטופ בלבד.** TLS סטייג'ינג פג בכוונה — `curl -k` מותר כאן בלבד.

## חומר

SSOT: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/דף FAQ/FAQ FINAL.md`
אין `סקירה FAQ`. «אין הערה = מאושר» אינו חל. ה-md הוא הרצוי.
אל תכתבו מ-`from-eyal/`.

ערוץ כתיבה (פאזה ב׳ בלבד, Hero+Intro בלבד):
`site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/faq-defaults.php`

**מלכודת CPT:** האקורדיון (`faqblock`) נמשך מ-`ea_faq` דרך `block-faq-list.php`. **אסור** לגעת ב-`block-faq-list.php` וב-`inc/data/*.json`. בפאזה א׳ חובה להשוות שאלות/תשובות ה-md מול ה-HTML החי של האקורדיון (וגם מול `inc/data/ea-faq-seed.json` לקריאה בלבד). אם יש פער Q&A → סעיף `לא ברור` עם `ASK_NIMROD` (אין ערוץ כתיבה חוקי) — **אל תבנו CPT**. Hero/Intro ב-defaults כן ניתנים להדבקה אם נעילת §3א מתקיימת.

## פאזה א׳ — קליטה + סיווג בלבד (חובה עכשיו)

1. קראו את ה-md במלואו + defaults + HTML חי (`curl -sk`).
2. סיווגו Hero + Intro לפי §3א. מדיה בלי קובץ = `לא ברור` לאייל (`_picks`).
3. סיווגו את קורפוס ה-Q&A: התאמה מלאה / פער (אז `לא ברור` לנימרוד, לא בניית JSON).
4. כתבו:
   - `_COMMUNICATION/team_100/S006/RESEARCH-R1-25-FAQ-2026-08-18.md`
   - `_COMMUNICATION/team_100/S006/tracker/r1-25-items.json`
5. שורה ראשונה: `RECOMMEND: BUILD|FREEZE|ASK_NIMROD` + ספירות. אם יש פער CPT → חייב `ASK_NIMROD` (גם אם Hero ברור).

סכימת JSON = `r1-04-items.json`. קידומת: `FAQ-`.

## אסור

xlsx / `tracker_page_tab.py` / `tracker_update.py` · `chapters-render.php` · `tpl-chapters-page.php` · `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · defaults של אחים · FTP · git commit/push · wp-admin · WP-CLI migrate.

## פאזה ב׳ — בנייה

רק אחרי `GO BUILD R1-25` מהאורקסטרטור. Provenance. רק `faq-defaults.php`. אין תוכן = אין רכיב.
