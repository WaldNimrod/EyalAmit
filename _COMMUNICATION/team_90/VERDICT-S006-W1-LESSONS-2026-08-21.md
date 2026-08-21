VERDICT: PASS

**מאמת:** team_90 · Composer (`composer-2.5`) · 2026-08-21  
**בנאי:** Cursor Grok 4.6 · Iron Rule #1 (validator ≠ builder)  
**בסיס:** http://eyalamit-co-il-2026.s887.upress.link/lessons/ · `curl -sk` · דסקטופ  
**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-W1-LESSONS-2026-08-21.md`  
**מקורות:** `שיעורי דיג_רידו.xlsx` E7/E8/E9/E12 · `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/שיעורי נגינה/lesons.md`

**HTTP:** `200 OK` · body **69 711** bytes (לא ריק).

## בדיקות

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| **1** | הירו: אין «שיעורי נגינה» מעל H1; טקסט מאוחד (כולל `/method/`) בתוך `.phero`; אין prose כפול מיד אחרי ההירo | **CONFIRMED** | ב-`<main>` לפני `<h1>`: אין `שיעורי נגינה` · `chap` ריק · `<p class="phero__s">` עם `<a class="tlink" href="/method/">cbDIDG</a>` · אחרי `</header>` ישר «מה זה ללמוד…» — לא שכפול פסקאות ההירו |
| **2** | «איך נראים השיעורים בפועל»: שלד 16:9 / ממתין לאישור; אין וידאו מומצא | **CONFIRMED** | `#lessons-look` · `.videoblk` + `ea-pending-approval` («ממתין לאישור» / «כאן ייכנס וידאו») · `videoblk__v`: 0 · `<video>` / `<source>`: 0 · CSS `aspect-ratio:16/9` על `.videoblk` |
| **3** | לפני CTA האחרון: «אודות אייל עמית» + «מאז 1999» + `/eyal-amit/` | **CONFIRMED** | H2 «אודות אייל עמית» לפני `.cta-band` · `מאז 1999` · `<a class="tlink" href="/eyal-amit/">לקריאה נוספת על אייל עמית</a>` |
| **4** | קישור הריון הנראה: D6 בייט-בבייט; לא 404 | **CONFIRMED** | FAQ «האם אפשר בזמן הריון?» · `href` == D6 (Python `==`) · `pregnancy-didgeridoo`: 0 · `curl` ל-D6 → **200** |
| **5** | 9 המלצות (JS קרוסלה מחוץ להיקף; LSN-01 תמונות לא הוחלפו) | **CONFIRMED** | 9 שמות ייחודיים: שירי אלקבץ · נוית צוף שטראוס · רותי שליט · ענת קרמנר ויינשטיין · גלית מילר · אלכס פלופ · אלון גרזון רז · קרין טננצאפ · אלכס פסטרנק · שכפול DOM ב-marquee — לא נספר כ-FAIL |

## אסור (גבול בנאי)

| פריט | תוצאה | ראיה |
|------|--------|------|
| `videoblk.php` (רק `videoblk-placeholder.php`) | **CONFIRMED** | `lessons-defaults.php` → `'part' => 'videoblk-placeholder'` · חי: אין `videoblk__play` / `videoblk__v` |
| עמוד FAQ (`/faq/`) | **CONFIRMED** | אין `href="/faq/"` ב-`<main>` · FAQ inline מ-SECTION 09 ב-`lesons.md` — בתוך `/lessons/` כצפוי |

## היקף מחוץ ל-FAIL (ממתין לאייל / גל אחר)

| פריט | הערה |
|------|------|
| LSN-01 | תמונות הירו (`eyal-teaching.jpg`) וספליט (`eyal-studio-play.jpg`) — לא הוחלפו; לא נדרש PASS בגל זה |
| LSN-02 | וידאo אמיתי — שלד «ממתין לאישור» נשאר |
| קרוסלת JS | marquee / `testi-mq` — מחוץ להיקף גל 1 |

## סיכום

חמש הבדיקות החיות של גל 1 · שיעורים עברו על הסטייג'ינג. HTML לא ריק. Yoast JSON-LD ל-D6 — אומת בנפרד ב-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-W1-YOAST-2026-08-21.md`.
