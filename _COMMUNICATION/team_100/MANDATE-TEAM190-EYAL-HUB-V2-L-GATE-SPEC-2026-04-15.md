# מנדט צוות 190 — L-GATE_SPEC לאפיון Eyal Client Hub V2 (LOD400)

**תאריך:** 2026-04-15  
**מוציא:** צוות 100  
**נמען:** צוות 190 (eyalamit_val — ולידטור חוקתי)  
**סביבת עבודה:** OpenAI (ChatGPT / API) — **לא** Cursor (מנוע הבנייה)

---

## 1. מטרה

לבצע **L-GATE_SPEC** — בדיקה חוקתית ועוינת־כוונה של האפיון [`EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md`](./EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md) מול קריטריוני [`_aos/governance/team_190.md`](../../_aos/governance/team_190.md) (סעיף Validation criteria → L-GATE_SPEC), ובהתאם ל־[`_aos/context/ACTIVATION_VALIDATOR.md`](../../_aos/context/ACTIVATION_VALIDATOR.md) כאשר מותאם לשער **SPEC** (לא L-GATE_V שמותנה ב־LOD500).

**הפרדת תפקידים:** זהו **לא** תחליף לצוות 90 (בקרה מול מימוש ודוחות QA); כאן נבדקת **שלמות וברירות האפיון לפני / במקביל למימוש**, ללא דרישת אתר חי או LOD500.

---

## 2. תנאי־קדם (מכני / ארגוני)

1. **במאגר AOS ל־WP רשום:** לפי `team_190.md` (V318+), ריצת `validate_lod.sh` מ־lean-kit היא תנאי ל־L-GATE_SPEC על ארטיפקטים תחת מסלול `_aos/work_packages/`.  
2. **מסמך Hub V2 (מיקום נוכחי):** LOD400 זה יושב תחת `_COMMUNICATION/team_100/` — **מחוץ** למסלול ה־WP הזה. המקבילה התפעולית לתנאי־קדם: טבלת **§12 ביקורת צוות 100 — מוכנות לולידציה** בקובץ ה־LOD400 מסומנת כהושלמה; אין סתירה ידועה בין סעיפים, טבלאות AC והפניות § שצוות 100 לא תיעד כפתורה.

צוות 190 רשאי להניח שהממצאים המכניים ברמת המסמך (סעיפים, מספור AC, הפניות צולעות) טופלו על ידי צוות 100 **אלא אם** הסקירה מגלות סתירה.

---

## 3. קריאה חובה לפני התחלה

1. [`_COMMUNICATION/team_190/__ONBOARDING_TEAM_190.md`](../team_190/__ONBOARDING_TEAM_190.md)
2. [`_aos/context/ACTIVATION_VALIDATOR.md`](../../_aos/context/ACTIVATION_VALIDATOR.md) — עקרונות עצמאות מנוע ואיסור מימוש
3. [`_aos/governance/team_190.md`](../../_aos/governance/team_190.md) — L-GATE_SPEC
4. [`EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md`](./EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md) — במלואו, בעיקר §0–§9, §10 MVP/P1
5. [`docs/CLIENT_HUB_STANDARD_v1.md`](../../docs/CLIENT_HUB_STANDARD_v1.md) — התאמה ל־F-* רלוונטיים
6. [`docs/CLIENT_HUB_APPENDIX_EYAL.md`](../../docs/CLIENT_HUB_APPENDIX_EYAL.md) — נספח Eyal

**אין** להסתמך על מסירת צוות 10 או דוח צוות 50 כראיה לשער זה — אלה שייכים ל־L-GATE_VALIDATE / צוות 90 במסלול המימוש.

---

## 4. תוצר (Done)

קובץ: `_COMMUNICATION/team_190/EYAL-HUB-V2/L-GATE_SPEC_result.md`

חובה:

- **כותרת זהות** (Mandatory Identity Header) כמפורט ב־`team_190.md` — לפחות: מזהה צוות 190, מנוע (openai), תאריך, נושא (EYAL-HUB-V2 / L-GATE_SPEC).
- **הכרעה:** `PASS` | `PASS WITH FINDINGS` | `BLOCKED` — לפי המוסכמה ב־`team_190.md` (בשערי SPEC מותרות ממצאים עם PASS; `BLOCKED` = עצירת מסלול מימוש עד תיקון ממוסמך על ידי צוות 100).
- בדיקות ליבה (מיפוי ל־L-GATE_SPEC ב־`team_190.md`):
  - מדידות וברור של AC ב־§9; אין סתירה בין §2–§8 לבין §9.
  - היקף גבולות (שכבות קאנון / Hub / dist), שפה גלויה ללקוח, אוטומציה §7 — מספיקים למימושן בלי הבהרות קריטיות חסרות.
  - עקביות מול Standard + נספח Eyal.
- רשימת **ממצאים** (אם יש): לכל אחד — חומרה, ניסוח תיקון מוצע, האם חוסם מימוש.

---

## 5. גבולות

- לא לכתוב קוד מימוש; לא להחליף החלטת מוצר של צוות 00/100.
- לא לעדכן ישירות `_aos/roadmap.yaml` — לאחר מסירה, צוות 100 קורא את התוצר ומעדכן תיעוד/שערים לפי נוהל המאגר.
- **Iron Rule:** מנוע ולידציה (openai) ≠ מנוע שכתב את האפיון (למשל cursor-composer) — יש לציין זאת בתוצר.

---

## 6. פרומט אקטיבציה (זהות + קונטקסט מלא)

**מסמך מרכזי (העתקה לסשן OpenAI חדש):**  
[`EYAL-HUB-V2-ACTIVATION-PROMPTS-ALL-TEAMS-2026-04-15.md`](./EYAL-HUB-V2-ACTIVATION-PROMPTS-ALL-TEAMS-2026-04-15.md) — **סעיף «צוות 190 — L-GATE_SPEC (OpenAI)»**.

---

**חתימת צוות 100:** מנדט פעיל עם פרסום LOD400 §12 ומסמך זה.
