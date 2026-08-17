VERDICT: PASS

**מנדט:** team_90 · R1-05 · `/sound-healing/` · דסקטופ · SSOT `sound_healing_final.md` · live `curl -sk` + `qa_probe`

---

### חוזה קוד (Iron Rules 1–3)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| **Diff ממופה בלבד** | **CONFIRMED** | `git diff --name-only HEAD` בערכת הנושא: רק `sound-healing-defaults.php` + `chapters-render.php` |
| **התאמת מקור** | **CONFIRMED** | כל מחרוזות התוכן ב־defaults נגזרות מ־SECTION 01–10 ב־`sound_healing_final.md`; `/method/` במקום `/method-cbdidg` מתועד כתיקון routing (לא copy חדש); «מוקש דהימן» ללא `href` — כמו במקור |
| **Provenance** | **CONFIRMED** | כותרת קובץ `S006 R1-05 · מקור: …sound_healing_final.md` + הערת `/* S006 · מקור: … · SECTION NN */` לכל בלוק; `chapters-render.php` מסומן `R1-02…R1-05` + `sound-healing` ב־ACF-skip |

---

### HTML חי — `<main>` בלבד (דסקטופ)

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| **1** | H1 + CTA הירו | **CONFIRMED** | `<h1 class="phero__h">סאונד הילינג פרטי בדיג'רידו - מסע אישי בצליל ותדר ליחידים ולזוגות</h1>` — ללא `<em>`; CTA `<a href="/contact/">לתיאום שיחת היכרות</a>` |
| **2** | אין פסקה מומצאת SECTION 03 | **CONFIRMED** | «המפגשים מתקיימים בסטודיו של אייל עמית בפרדס חנה» — **לא** ב־`<main>` |
| **3** | אין bleed/steps/«מבנה המפגש»; «איך זה עובד?» פרוזה | **CONFIRMED** | אין `.bleed`/`.steps`/«מבנה המפגש»; h2 «איך זה עובד?» + 9 פסקאות; «אוהל הטיפי», «כשעתיים» נוכחים |
| **4** | אין rcard/reveals/«ועוד למי»; SECTION 07 | **CONFIRMED** | אין `.rcard`/`.reveals`/«ועוד למי זה מתאים»; **8** פסקאות תחת «למי זה מתאים?» incl. קישור `/lessons/` |
| **5** | קישורים SECTION 04 | **CONFIRMED** | אין `href` ל־`/eyal-amit/mokesh-dahiman/` ב־`<main>`; «מוקש דהימן» כטקסט; אין `/method-cbdidg`; `<a href="/method/">שיטת cbDIDG</a>` |
| **6** | FAQ accordion | **CONFIRMED** | **8** × `<details … ea-faq-item>` בתוך `.ea-faq-list`; אחריו `<a href="/faq/">דף השאלות הנפוצות המלא</a>` (לא נספר JSON-LD) |
| **7** | המלצות SECTION 09 | **CONFIRMED** | **8** שמות ייחודיים + **8** `facebook.com/share/p/…` incl. `1TNJeTs7Mo` (קרין); `<a href="/testimonials/">לכל ההמלצות על אייל עמית</a>` |
| **8** | CTA סיום | **CONFIRMED** | h2 «רוצים להגיע למפגש?»; `<a href="/contact/">יצירת קשר</a>`; אין WhatsApp/wa.me ב־`<main>` |

---

### qa_probe (desktop, תוספת)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| **Overflow + absent terms** | **CONFIRMED** | desktop 1440×900: `scrollWidth=1440`, `overflow=false`, `forbiddenFound=[]`, `verdict: PASS` |

---

**הערות מחוץ להיקף (לא FAIL):** meta Yoast/footer/nav מכילים «פרדס חנה» / mokesh — מחוץ ל־`<main>`; hero/split images (SH-01) ווידאו SECTION 05 (SH-02) — ממתינים לאייל per mandate.
