VERDICT: PASS

מנדט team_90 · Composer · R1-02 E2E + עדשת אקסל — ראיות נאספו עכשיו מול `http://eyalamit-co-il-2026.s887.upress.link/treatment/` (curl `-sk`), HTML, `qa_probe`, ו־CSV/JSON.

| # | תוצאה | ציטוט / ראיה |
|---|--------|--------------|
| **א1** | | |
| 1 | CONFIRMED | H1: `טיפול בדיג׳רידו` · hero: `<a class="btn btn--gw" href="/contact/">לתיאום שיחת היכרות</a>` |
| 2 | CONFIRMED | SECTION 03 (`id="what"`): `עובדת הוותק` absent · `שעוסק בתחום מאז 1999 בשיטת` absent |
| 3 | CONFIRMED | `<li>מרגיש עייפות או חוסר יציבות אנרגטית</li>` · `<li>מתמודד עם מחלה ורוצה לתמוך…</li>` · `.rcard count: 0` |
| 4 | CONFIRMED | `ea-home-hero-720` absent · `<p class="ea-pending-approval__title">כאן ייכנס סרטון מפגש</p>` |
| 5 | CONFIRMED | «סטודיו נשימה מעגלית בפרדס חנה» בסקשן «מי זה אייל עמית» |
| 6 | CONFIRMED | 13 שמות ייחודיים ב־`tmq__nl` (26 כרטיסים בקרוסלה, 0 ריקים): שירי אלקבץ…דן ארליכמן |
| 7 | CONFIRMED | `<section class="bleed">` + `<p class="bleed__q r">הנשימה היא לכולם.</p>` — מתועד T-01, לא FAIL |
| 8 | CONFIRMED | 20 שאלות FAQ ייחודיות (≥20; 15+5 נחירות/CPAP) — מתועד T-01, לא FAIL |
| **א2** | | |
| 9 | CONFIRMED | אין סקשן/כרטיס ריק; פלייסהולדר וידאו = תג + «כאן ייכנס סרטון מפגש» |
| 10 | CONFIRMED | CTA תחתון: `<a class="btn btn--terra" href="/contact/">לתיאום שיחת היכרות</a>` |
| 11 | CONFIRMED | HTTP `200` · hero `href="/contact/"` (לא `#what`) · `qa_probe` desktop: `scrollWidth:1440 clientWidth:1440 overflow:false verdict:PASS` |
| **א3** | | |
| 12 | CONFIRMED | פנימיים בגוף: `/contact/` `/method/` `/eyal-amit/mokesh-dahiman/` `/treatment/` `/sound-healing/` `/lessons/` — כולם `200` |
| 13 | CONFIRMED | 13 קישורי Facebook ייחודיים — כולם `200` (HEAD `-skI -L`); URLs תואמים `treatment.md` SECTION 08 מילה-במילה |
| 14 | CONFIRMED | תפריט: `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` — כולם `200` |
| 15 | CONFIRMED | footer: `href="tel:+972524822842"` · `href="https://wa.me/972524822842?text=…"` |
| **ב1** | | |
| 16 | CONFIRMED | `latest.csv` R1-02: `#=R1-02` · `נתיב=/treatment/` |
| 17 | CONFIRMED | `סטטוס מכונה=הוגש לבדיקה` |
| 18 | CONFIRMED | `ממתין ל=אייל` (לא `team_100`) |
| 19 | CONFIRMED | `סטטוס אישור=—` · `הערות נימרוד=''` · `הערות אייל=''` · `תאריך אישור=''` |
| **ב2** | | |
| 20 | CONFIRMED | T-01: משפט אחד + `_picks`: «גרסה מוצעת» / «גרסה לפי המסמך»; בלי שמות קבצים/PHP/git |
| 21 | CONFIRMED | T-01 `אפשרויות לבחירה`: שני URL חיים + הסבר מפורש (רצועת bleed + 5 שאלות CPAP/נחירות) |
| 22 | CONFIRMED | T-02: «בסקשן «איך נראה מפגש» חסר סרטון… קישור או שם קובץ, או שאין סרטון» |
| 23 | CONFIRMED | T-01/T-02 בלבד `ממתין לאייל`; T-03..T-06 `בוצע`/`—` — לא דורסים H-01/H-06/H-07 (R1-01) |
| 24 | CONFIRMED | אין `to-eyal` חדש ל-R1-02; T-01 `קישור=http://…/treatment/` (סטייג'ינג, לא Markdown) |
| **ב3** | | |
| 25 | CONFIRMED | T-01/T-02 `סיווג=לא ברור`; T-03..T-06 `סיווג=ברור` + `סטטוס סעיף=בוצע` |

**עדשה א׳:** PASS  
**עדשה ב׳:** PASS  
**כללי:** PASS

**הערות לא-חוסמות:** קובץ `EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx` לא ב-workspace; אומת מול `_COMMUNICATION/team_100/S006/tracker/latest.csv` + `latest-items.csv` + `r1-02-items.json` (מסונכרנים). `qa_probe` הורץ מחדש ב-composer session — PASS desktop 1440.
