# W1 · הערת מדידה צוות 100 · 2026-08-31

**מקור אימות 90:** [W1-VERIFY-2026-08-31.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-a11y-close/_COMMUNICATION/team_90/evidence/a11y-close-w1-2026-08-31/W1-VERIFY-2026-08-31.md) — סימן FAIL על H1 של `/treatment/`.

**בדיקת textContent אמיתית (HTMLParser על `<h1>` חי):** המחרוזת זהה ל-baseline.jsonl:

- חי: `טיפול בדיג׳רידו` (רווח יחיד אחרי «טיפול»)
- baseline: אותה מחרוזת, אותם codepoints כולל geresh U+05F3

ה-FAIL נבע מקילוף `<em>` עם רווח (`טיפול ב` + `דיג׳רידו`). ה-HTML החי הוא `טיפול ב<em>דיג׳רידו</em>` — **לא** שינוי כותרת ב-W1.

**קריטריון כשל H1/CTA:** לא הופר. כרום W1 (דילוג אחד, טופס CF7 יחיד, `p.foot__col-title`, qa_probe 0) **עבר**.

EzCache REST `ezcache/v1` אינו רשום ב-wp-json בסטייג'ינג (תוסף לא ב-namespaces). אימות עם `?nocache=`.
