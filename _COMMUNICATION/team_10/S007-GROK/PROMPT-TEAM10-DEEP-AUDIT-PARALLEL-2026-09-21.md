# פרומט — סשן צוות 10 מקביל · בקרת מערכת 1.5.99

הדביקו את **כל** הבלוק מתחת לשורה הראשונה של הצ'אט החדש (Cursor, צוות 10).  
תוכנית: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/PLAN-S007-DEEP-AUDIT-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/PLAN-S007-DEEP-AUDIT-2026-09-21.md)

---

אתה **צוות 10**. קרא במלואו את  
`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_communication/team_10/onboard_team10.md`  
לפני כל פעולה. אחרי האונבורד אמור: «אונבורד צוות 10 הושלם.» ואז בצע את המשימה הזו — בלי לחכות למשימה נוספת.

## זהות במשימה הזו

אתה **תוקף/מודד** את הסטייג'ינג החי. אתה **לא** מיישם, **לא** עורך `site/`, **לא** FTP, **לא** commit לקוד תמה, **לא** צוות 50 (אין חתימת QA רשמית), **לא** צוות 100 (אין החלטות מוצר).

סטייג'ינג: http://eyalamit-co-il-2026.s887.upress.link (HTTP בלבד; TLS לא תקין בכוונה — לא באג).  
תמה חייבת להיות **1.5.99**. אם `style.css?ver=` אחר — STOP וכתוב BLOCKER.

שפה מול נימרוד בארטיפקט: עברית בסיכום. טבלאות ממצאים: אנגלית כמו גל א.  
נתיבים: תמיד URL מלא או `file:///` מוחלט.

## מטרה

בקרה מעמיקה אחרי גל א+ב: ויזואלי, **נגישות מעמיקה**, **מובייל מעמיק**, שגיאות דפדפן, כשלים אחרים. למסור ארטיפקט אחד למנהל המבצע שיאשרר במנוע אחר.

תוכנית מחייבת (קרא במלואה):  
`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/PLAN-S007-DEEP-AUDIT-2026-09-21.md`

מפת 157:  
`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv`

רף נגישות מחייב: ת״י 5568 = WCAG 2.0 AA. 2.1/2.2 רק כבדיקת עזר, מסומן «לא בחובה».  
הצהרה חיה: «פועלים לפי» — אל תטען עמידה מאושרת.  
סריקת axe/Lighthouse נקייה **אינה** PASS.

## אסור

- לתקן קוד, bump Version, FTP, `git add -A`, `local/`, `_aos/`
- להמציא נוסח או לפתוח קבוצה ג
- לסמוך על curl ל־layout/overflow/RTL
- לסמן PASS על מה שלא מדדת
- לסגור דיאלוג CMP בלי למדוד מקלדת + 390
- להתעלם ממשפחות GP (`/about/` `/press/`), EN, QR, בלוג

## חובה לבצע — ארבע שכבות

**A. מפקד 157** — GET בלי follow לכל שורת ה־TSV. סטטוס, 301, ver=1.5.99 על 200, href ל־www.eyalamit.co.il (סווג). רשימת 4xx/5xx.

**B. ויזואלי** — 390×844, 768×1024, 1440×900 על נציגי כל המשפחות בתוכנית (בית, lessons/treatment/method, repair/shop, training/courses-external, ספר, contact/faq/privacy/accessibility, about/press, en, blog+פוסט, qr×2, mokesh). overflow, H1 מול סרגל, פירורים, CMP, טינט מול פוטר, וואטסאפ, מגירה.

**C. נגישות מעמיקה** — מקלדת מלאה ב־`/` `/lessons/` `/contact/` `/faq/` `/shop/` `/en/` `/qr/qr1/` `/privacy/`. skip link חי (לא המת ב־header.php אם אינו ב־DOM), פוקוס נראה, trap, aria מגירה, CMP (מיקוד, Esc, שני כפתורים), טופס contact, H1 יחיד, lang, alt, יעדים 44px, zoom 200%. Lighthouse a11y + axe כעזר בלבד. VoiceOver על `/` ו־`/contact/` או NEED-HUMAN. רגרסיות: WAF-02 overflow; סרגל 88→56; CMP; P2 פתוח ב־`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/A11Y-P2-OPEN-PACKAGE.md` — למדוד מחדש חי, לא להעתיק 17.9.

**D. מובייל מעמיק** — 390, 414, 768. overflow אחרי סגירת CMP; nav 88/56; `/lessons/` gap≥16; מגירה; פירורים wrap; nowrap cbDIDG; CMP לא יוצא מהמסך; וואטסאפ מול CTA; `/contact/` בלי צף; אין `user-scalable=no`; QR קריא.

כלים: `/usr/bin/curl` + UA דפדפן; Chrome.app ל־CDP (headless-shell עלול SEGV); `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` ל־overflow. ראיות תחת `tmp/qa/deep-audit-2026-09-21/` (לא Git).

## פלט יחיד

כתוב רק:  
`_COMMUNICATION/team_10/S007-GROK/DEEP-AUDIT-ATTACK-2026-09-21.md`

מבנה: זהות · MISS P0/P1/P2 (קריטריון+עמוד+viewport+ראיה+חובה 2.0 AA כן/לא) · PASS שנמדד · NEED-HUMAN · סיכום 157 · קונסולה/רשת · מה לא נבדק.

כשסיימת: הודעה קצרה בעברית לנימרוד עם נתיב הארטיפקט ומספר MISS לפי חומרה. בלי להציע תיקון בסשן הזה.
