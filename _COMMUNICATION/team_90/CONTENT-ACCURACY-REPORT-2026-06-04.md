# Gate CONTENT-ACCURACY — team_90 | Run 2026-06-04

## Context bundle

- **Work Package:** WP-W2-15 (baseline מדידה לפני reconciliation)
- **Domain:** EyalAmit.co.il-2026 (WordPress staging)
- **Write to:** `_COMMUNICATION/team_90/`
- **Mandate:** `_COMMUNICATION/team_100/WP-W2-15-CONTENT-RECONCILIATION-PROGRAM-PLAN-2026-06-04.md` (F04 CONTENT-ACCURACY); השוואה ל־`CONTENT-INTEGRITY-AUDIT-2026-06-04.md`
- **Staging:** http://eyalamit-co-il-2026.s887.upress.link
- **SSoT:** `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/` · `INDEX-CONTENT-2026-05-25.md`

---

## §0 — Verdict box

| שדה | ערך |
|-----|-----|
| **Verdict** | **FAIL** — אף עמוד עם מקור לא עומד ב־CONTENT-ACCURACY gate (0/17 PASS) |
| **דיוק כללי (ממוצע עמודים)** | **33.64%** |
| **דיוק כללי (משוקלל לפי אורך מקור)** | **32.00%** |
| **עמודים &lt;90%** | **17 / 17** (100% מהעמודים הנמדדים) |
| **עמודים N/A** | 2 (`/galleries/`, `/media/`) |
| **Gate F04 (≥95% sections + ≥90% sentences + 0 invented sections)** | **0 PASS** |
| **Next step** | team_10 — WP-W2-15 content-fill לפי miss-lists ב־evidence; team_50 — re-run `content-diff.mjs` אחרי deploy |

**מסקנה אחת:** רוב גוף האתר עדיין mockup / paraphrase, לא תוכן 25.5.26 verbatim. המבנה (WP-W2-14) תקין; **תוכן — P0**.

---

## §1 — טבלת עמודים

נוסחת **accuracy%** (מיושרת ל־F04):  
`pageAccuracy% = 0.4 × sectionCoverage% + 0.6 × sentenceCoverage%`

| page | source | section-cov% | sentence-cov% | accuracy% | verdict | #מקטעים חסרים |
|------|--------|-------------:|--------------:|----------:|---------|---------------:|
| `/` | `דף הבית/homepage1-3 v2.md` | 25.00 | 14.29 | 18.57 | INVENTED | 9 |
| `/method/` | `השיטה/method.md` | 21.43 | 0.00 | 8.57 | INVENTED | 11 |
| `/muzza/` | `מוזה…/MUZZA.md` | 8.33 | 0.00 | 3.33 | INVENTED | 11 |
| `/repair/` | `תיקון…/build didg.md` | 10.00 | 0.00 | 4.00 | INVENTED | 9 |
| `/sound-healing/` | `סאונדהילינג/sound_healing_final.md` | 40.00 | 3.17 | 17.90 | INVENTED | 6 |
| `/eyal-amit` → `/about/` | `אודות…/אודות - אייל עמית.md` | 30.77 | 0.00 | 12.31 | INVENTED | 9 |
| `/faq/` | `דף FAQ/FAQ FINAL.md` | 0.00 | 37.10 | 22.26 | INVENTED | 10 |
| `/treatment/` | `טיפול…/treatment.md` | 46.15 | 6.52 | 22.37 | INVENTED | 7 |
| `/lessons/` | `שיעורי נגינה/lesons.md` | 40.00 | 10.96 | 22.58 | INVENTED | 6 |
| `/mokesh-dahiman` → `/about/moksha/` | `מוקש דהימן/ומה היום.docx` | 100.00 | 9.09 | 45.45 | PARTIAL | 0 |
| `/didgeridoos/` | `כלים למכירה/buy didgeridoo.md` | 40.00 | 48.65 | 45.19 | PARTIAL | 6 |
| `/books/kushi-blantis/` | `כושי בלאנטיס/kushi_full.md` | 28.57 | 68.18 | 52.34 | PARTIAL | 10 |
| `/stand-floor/` | `סטנד רצפתי…/stend for playing.md` | 40.00 | 62.96 | 53.78 | PARTIAL | 6 |
| `/bags/` | `תיקים…/bags for didg.md` | 40.00 | 68.00 | 56.80 | PARTIAL | 6 |
| `/books/vekatavta/` | `וכתבת/vekatavta.md` | 28.57 | 79.75 | 59.28 | PARTIAL | 10 |
| `/stands-storage/` | `סטנדים…/stend for hanging.md` | 60.00 | 65.85 | 63.51 | PARTIAL | 4 |
| `/books/tsva-bekahol/` | `צבע בכחול…/eyal_tsva_FINAL.md` | 28.57 | 87.04 | 63.65 | PARTIAL | 10 |
| `/galleries/` | — | — | — | — | **N/A** | — |
| `/media/` | — | — | — | — | **N/A** | — |

**ספי verdict (מדידה team_90):** ACCURATE ≥90 · PARTIAL 40–89 · INVENTED &lt;40 · N/A ללא מקור.

**ספי gate F04 (WP-W2-15):** PASS = section ≥95% **ו** sentence ≥90% **ו** 0 invented sections (כותרות H2/H3 חיות שלא במקור).

---

## §2 — Worst offenders + קלט ל־WP-W2-15

### עמודים קריטיים (accuracy &lt;25%)

1. **`/muzza/` (3.33%)** — כמעט כל מקטעי `MUZZA.md` חסרים; 0 משפטי מקור verbatim. מאשר דגימת team_100 (0%).
2. **`/repair/` (4.00%)** — גוף mockup; 0% משפטים.
3. **`/method/` (8.57%)** — 11/14 מקטעים חסרים (כולל «מהי cbDIDG», «עקרונות השיטה», «איך נולדה השיטה», FAQ, חוויות). 0% משפטים — טקסט חי שונה לחלוטין מ־`method.md`. מאשר team_100 (0%).
4. **`/eyal-amit` / `/about/` (12.31%)** — מקור 13 SECTION הגיע; live עדיין mockup בגוף (0% משפטים).
5. **`/` (18.57%)** — 9/12 מקטעים חסרים; רק ~14% משפטי מקור. **תיקון מספר team_100:** דגימת 12 משפטים נתנה ~66%; מדידה מלאה (כל המשפטים ≥40 תווים) נותנת **18.57%** — אותו כיוון (חלק מטקסט אייל, הרבה mockup) אך מספר שונה בגלל מתודולוגיה.
6. **`/sound-healing/` (17.90%)**, **`/treatment/` (22.37%)**, **`/lessons/` (22.58%)** — תואם ~25% בדגימת team_100 (טווח 18–23% במדידה מלאה).
7. **`/faq/` (22.26%)** — 37% משפטים אך **0% כותרות SECTION** (כותרות מקור כוללות «FAQ Category: …» שלא מופיעות כך ב-live). **תיקון team_100:** ~41% בדגימה → **22.26%** במדידה מלאה + section=0.

### מקטעים חסרים — `/method/` (קלט ישיר ל־15-B)

- Hero – שיטת cbDIDG של אייל עמית  
- מהי שיטת cbDIDG  
- לא כל עבודה עם דיג'רידו היא אותו דבר  
- עקרונות השיטה  
- מה מייחד את שיטת cbDIDG  
- איך נולדה השיטה (הדרך והחיבור למוקש)  
- אודות אייל עמית  
- איך נראה מפגש בפועל  
- שאלות נפוצות על השיטה  
- מה אנשים חווים בתהליך  
- מבט קדימה  

(פירוט מלא + משפטים חסרים: `evidence/content-accuracy-2026-06-04/_method_.json`)

### מקטעים חסרים — `/` (דף בית)

- HERO (כותרת מקור מלאה)  
- מה זה טיפול בנשימה…  
- וידאו  
- ההבדל בין סאונד הילינג לטיפול  
- למי זה מתאים  
- איך מתחילים  
- במפגש טיפולי  
- הסטודיו  
- גלריה נוספת  
- 15 עדויות פייסבוק  
- CTA סופי  

### בלוקים מומצאים (דוגמה)

- **`/method/`:** כל גוף העמוד החי («שיטה ייחודית · מאז 1999», «איך בנויה השיטה» mockup) — ראה `inventedBlocks` ב־JSON.  
- **`/muzza/`:** מבנה חנות/ספרים mockup, לא 12 בלוקי `MUZZA.md`.  
- **`/mokesh-dahiman`:** live ב־`/about/moksha/`; מקור docx קיים — **9% משפטים verbatim** (רוב הפסקאות paraphrase/עריכה); כותרת «ומה היום» קיימת (section 100%).

---

## §3 — עמודים ללא מקור Eyal

| page | הערה |
|------|------|
| `/galleries/` | תוכן דוגמה team_35 — **N/A** |
| `/media/` | תוכן דוגמה team_35 — **N/A** |

---

## §4 — שיטה + רפרודוקציה

### סקריפט

| פריט | נתיב |
|------|------|
| Canon | `scripts/qa/content-diff.mjs` |
| עותק evidence | `_COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04/content-diff.mjs` |
| פלט JSON | `_COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04/summary.json` (+ per-page `*.json`) |

```bash
cd EyalAmit.co.il-2026
node scripts/qa/content-diff.mjs \
  --base http://eyalamit-co-il-2026.s887.upress.link \
  --out _COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04
```

### פרסור מקור

- זיהוי מקטעים: שורות `SECTION NN – title` (עם או בלי `#` / `##`).
- הוצאה ממקטע: כל שורות תוכן עברי; **מוחרגים:** בלוקי `DEV NOTES`, `CTA`, שורות `- layout:` / `UX:` / `behavior:`.
- משפטי מקור: פיצול לפסקאות/סיום משפט; נשמרים רק מקטעים עם **≥40 תווים עבריים** (`[\u0590-\u05FF]`).

### משיכת live

- `fetch` עם redirect; חילוץ `<main>` (או `<article>`).
- הסרת `<script>`, `<style>`, תגיות HTML → טקסט.

### נרמול (שני הצדדים)

- קישורי Markdown → טקסט עוגן בלבד  
- הסרת markup (`**`, `#`, וכו')  
- יישור גרש/מרכאות (`׳` `'` `"` וכו')  
- `דיג׳רידו` → `דיג'רידו`  
- whitespace מרוכז לרווח יחיד  

### מדדים

| מדד | נוסחה |
|-----|--------|
| section-coverage% | `מקטעי מקור שנמצאו (כותרת מנורמלת כ-substring) / סה"כ מקטעים × 100` |
| sentence-coverage% | `משפטי מקור שנמצאו verbatim (אחרי נרמול) / סה"כ משפטים × 100` |
| page-accuracy% | `0.4 × section + 0.6 × sentence` |
| משוקלל אתר | ממוצע accuracy לפי סכום אורך תוכן מקור per page |

### invented detection

- **invented sections:** כותרות H2/H3 ב-live שלא תואמות לאף כותרת מקור.  
- **invented blocks:** משפטים ≥40 תווים ב-live שאינם substring של משפט מקור.

### יישור ל־team_100 sample audit

| עמוד | team_100 (דגימה) | team_90 (מלא) | הערה |
|------|------------------|---------------|------|
| `/method/` | 0% | **8.57%** | אותו verdict INVENTED; sentence עדיין 0% |
| `/muzza/` | 0% | **3.33%** | INVENTED |
| `/treatment/` | ~25% | **22.37%** | INVENTED במדד מלא |
| `/sound-healing/` | ~25% | **17.90%** | INVENTED |
| `/lessons/` | ~25% | **22.58%** | INVENTED |
| `/faq/` | ~41% | **22.26%** | דגימה העריכה גבוהה; section=0 מוריד accuracy |
| `/` | ~66% | **18.57%** | דגימת 12 משפטים vs ~70+ במקור — **לא סתירה בכיוון** |

---

## §5 — תלות והגבלות

- **לא בוצעו** תיקוני תוכן, deploy, או merge — מדידה בלבד.  
- **מנדט** `MANDATE-TEAM90-FULL-CONTENT-ACCURACY-AUDIT-2026-06-04.md` לא נמצא במאגר; בוצע לפי הנחיות סשן + F04 ב־`WP-W2-15-CONTENT-RECONCILIATION-PROGRAM-PLAN-2026-06-04.md`.  
- **`/mokesh-dahiman`:** נמדד ב־URL הסופי `/about/moksha/` (301 מ־`/mokesh-dahiman/`).  
- **ספרים:** נמדדו ב־`/books/…` (canonical); `/muzza/…` מפנה לשם.

---

**log_entry | TEAM_90 | CONTENT_ACCURACY_BASELINE | 2026-06-04 | FAIL 33.64% site avg | evidence/content-accuracy-2026-06-04/**
