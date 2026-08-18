VERDICT: PASS

**מאמת:** team_90 · Composer (Cursor) · 2026-08-18  
**בנאי הגל:** Cursor Grok 4.6 · Iron Rule #1 (validator ≠ builder)  
**בסיס:** http://eyalamit-co-il-2026.s887.upress.link/ · דסקטופ  
**מנדט:** `_COMMUNICATION/team_90/MANDATE-S006-WAVE1-NAV-MUSTER-2026-08-18.md`

## 1. קישורי ניווט רמה ראשונה (`#nav`)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| `#nav` קיים בדף הבית | CONFIRMED | `id="nav"` · `ul.nav__l` + `nav__en` |
| `/` | CONFIRMED | HTTP 200 |
| `/treatment/` | CONFIRMED | HTTP 200 |
| `/method/` | CONFIRMED | HTTP 200 |
| `/lessons/` | CONFIRMED | HTTP 200 |
| `/sound-healing/` | CONFIRMED | HTTP 200 |
| `/books/` | CONFIRMED | HTTP 200 |
| `/blog/` | CONFIRMED | HTTP 200 |
| `/contact/` | CONFIRMED | HTTP 200 |
| `/en/` | CONFIRMED | HTTP 200 |
| כפתורי דרופדאון ללא href | CONFIRMED | «לימוד והכשרה» · «כלים ואביזרים» · «אייל עמית» נוכחים |
| `קורסים` → `#` | הערה | R1-29 — לא FAIL |

## 2. ילדי דרופדאון בגל (לא 404)

| נתיב | תוצאה | ראיה |
|------|--------|------|
| `/shop/` | CONFIRMED | HTTP 200 |
| `/eyal-amit/` | CONFIRMED | HTTP 200 |
| `/eyal-amit/mokesh-dahiman/` | CONFIRMED | HTTP 200 · תחת «אייל עמית» |

## 3. H1 חי (`<main>`) + HTTP 200

| נתיב | תוצאה | HTTP | H1 (מצוטט) |
|------|--------|------|------------|
| `/` | CONFIRMED | 200 | `המרכז לטיפול בנשימה באמצעות דיג'רידו – שיטת cbDIDG של אייל עמית` — רגרסיה בלבד; לא 404 |
| `/treatment/` | CONFIRMED | 200 | `טיפול בדיג׳רידו` — רגרסיה בלבד |
| `/method/` | CONFIRMED | 200 | `שיטת cbDIDG של אייל עמית` — רגרסיה בלבד |
| `/lessons/` | CONFIRMED | 200 | `שיעורי נגינה בדיג'רידו לפי שיטת cbDIDG של אייל עמית` — רגרסיה בלבד |
| `/sound-healing/` | CONFIRMED | 200 | `סאונד הילינג פרטי בדיג'רידו - מסע אישי בצליל ותדר ליחידים ולזוגות` — רגרסיה בלבד |
| `/shop/` | CONFIRMED | 200 | `כלי דיג'רידו למכירה - כלים בעבודת יד` · ללא `<em>` |
| `/books/` | CONFIRMED | 200 | `מוזה הוצאה לאור` · ללא `<em>` |
| `/eyal-amit/` | CONFIRMED | 200 | `אייל עמית` · ללא `<em>` · תוויות גרסה א׳/ב׳ נוכחות |
| `/eyal-amit/mokesh-dahiman/` | CONFIRMED | 200 | `מי היה מוקש דהימן?` · ללא `<em>` |
| `/contact/` | CONFIRMED | 200 | `צור קשר` |
| `/learning/` | CONFIRMED | 200 | `ללמוד, להעמיק, להנחות` — הקפאה; HTTP 200 מספיק |
| `/blog/` | CONFIRMED | 200 | `בלוג` — הקפאה; HTTP 200 מספיק |
| `/en/` | CONFIRMED | 200 | `Eyal Amit` — הקפאה; HTTP 200 מספיק |

## 4. `qa_probe` דסקטופ (סט בנוי/מוקפא)

| נתיב | תוצאה | overflow | forbiddenFound |
|------|--------|----------|----------------|
| `/shop/` | CONFIRMED | false | [] |
| `/books/` | CONFIRMED | false | [] |
| `/eyal-amit/` | CONFIRMED | false | [] |
| `/eyal-amit/mokesh-dahiman/` | CONFIRMED | false | [] |
| `/contact/` | CONFIRMED | false | [] |
| `/learning/` | CONFIRMED | false | [] |
| `/blog/` | CONFIRMED | false | [] |
| `/en/` | CONFIRMED | false | [] |

**רגרסיה אופציונלית (ליבה):** `/` · `/treatment/` · `/method/` · `/lessons/` · `/sound-healing/` — דסקטופ `overflow: false` · `forbiddenFound: []` לכולם.

## 5. טרקר (`latest.csv`)

| שורה | סטטוס מכונה | ממתין ל | תוצאה |
|------|-------------|---------|--------|
| R1-10 · R1-16 · R1-21 · R1-22 | `הוגש לבדיקה` | `אייל` | CONFIRMED |
| R1-23 | `הוגש לבדיקה` | `נימרוד` | CONFIRMED |
| R1-06 · R1-20 · R1-24 | `הוקפא` | `נימרוד` | CONFIRMED |

## סיכום

מפקד ניווט גל רמה-ראשונה עבר: כל קישורי `#nav` והילדים הנעולים בגל מחזירים 200; H1 חי על עמודי הגל; `qa_probe` דסקטופ נקי; טרקר תואם. לא נפתחו מחדש סעיפי אייל על R1-01…R1-05 / R1-26.
