VERDICT: PASS

**מנדט:** team_90 · R1-28 · `/snoring-sleep-apnea/` · דסקטופ · SSOT `snoring-sleep-apnea-didgeridoo-CHECKED.md` · live `curl -sk` + `qa_probe`
**מאמת:** composer-2.5 · **בנאי:** Cursor Grok 4.6 · Iron Rule #1

---

### חוזה קוד (Iron Rules 1–3)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| **Diff ממופה בלבד** | **CONFIRMED** | `git diff --name-only HEAD` בערכת הנושא: `snoring-sleep-apnea-defaults.php` + `chapters-render.php` + אחי גל 3 (`faq-defaults.php`, `kushi-blantis-defaults.php`, `tsva-bekahol-defaults.php`, `vekatavta-defaults.php`). אין `videoblk.php` · `block-faq-list.php` · `tpl-chapters-page.php` · `muzza-defaults.php` |
| **התאמת מקור** | **CONFIRMED** | מחרוזות תוכן ב־`snoring-sleep-apnea-defaults.php` נגזרות מ־SECTION 01–17 ב־`content 13.8.26/נחירות ודום נשימה/snoring-sleep-apnea-didgeridoo-CHECKED.md`; SNR-01/02/03 כרטיסי המתנה + באנר יוני לפי מנדט; SNR-04 שורה 671 («להשלמה לפני פרסום») לא רונדרת; SECTION 18 לא רונדר |
| **Provenance** | **CONFIRMED** | כותרת קובץ `S006 R1-28 SNR-05 · מקור: …snoring-sleep-apnea-didgeridoo-CHECKED.md` + 75 הערות `/* S006 · מקור: … */`; `chapters-render.php` מסומן wave3 + `snoring-sleep-apnea` ב־ACF-skip |

---

### HTML חי — `<main>` בלבד (דסקטופ)

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| **1** | H1 + אין כרום מומצא | **CONFIRMED** | `<h1>נחירות ודום נשימה בשינה: גישה טיפולית באמצעות דיג'רידו</h1>`; אין H2 «מה יש בעמוד הזה»; אין «להשלמה לפני פרסום»; `chap` count = 0 |
| **2** | יוני + כרטיסי המתנה SNR-01/02/03 | **CONFIRMED** | H2 «הסיפור של יוני» + גוף סיפור (יוני, CPAP, 250 הפסקות, בדיקת שינה); באנר `ea-pending-approval` מעל הסיפור; כרטיס `מכבי.jpg — ממתין לאישור / מדיה חסרה`; כרטיס `יוני.jpg — ממתין לאישור / מדיה חסרה` |
| **3** | CTA `רוצה לדבר איתי` → `/contact/` | **CONFIRMED** | הירו + `cta-band`: `<a href="/contact/">רוצה לדבר איתי</a>`; H2 «אז איך יודעים אם זה יכול להתאים גם לכם?» בפרוזה בלבד — אין H2 כפול על CTA |
| **4** | SECTION 18 לא ציבורי | **CONFIRMED** | אין «הערות מתכנת» / SECTION 18 ב־`<main>` |
| **5** | WP-EI-03 לא נפתח — לא ממציאים jpg | **CONFIRMED** | 0 `<img>` ב־`<main>`; כרטיסי pending בלי קבצי jpg חיים |

---

### qa_probe (desktop)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| **Overflow + absent terms** | **CONFIRMED** | desktop 1440×900: `scrollWidth=1440`, `overflow=false`, `forbiddenFound=[]` (absent: «מה יש בעמוד הזה», «להשלמה לפני פרסום», «SECTION 18»), `verdict: PASS` · `tmp/qa/cdp/qa_probe_result.json` |

---

**הערות מחוץ להיקף (לא FAIL):** SNR-01/02/03 ממתינים לאייל per tracker · meta Yoast/title מחוץ ל־`<main>` · BMJ link 403 לבוט curl (URL מהמקור) · mobile viewport ב־qa_probe עבר — מנדט דורש דסקטופ בלבד.
