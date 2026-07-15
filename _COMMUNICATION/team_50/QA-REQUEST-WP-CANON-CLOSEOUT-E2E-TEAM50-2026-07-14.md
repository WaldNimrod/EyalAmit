---
id: QA-REQUEST-WP-CANON-CLOSEOUT-E2E-TEAM50-2026-07-14
from_team: team_100
to_team: team_50
cc: team_00, team_110, team_90
date: 2026-07-14
type: qa-request
wp: WP-CANON-TEMPLATE-UNIFICATION
staging: http://eyalamit-co-il-2026.s887.upress.link
builder_engine: cursor-grok-4.5
qa_engine_required: composer-2.5
prior_css_fix: _COMMUNICATION/team_110/FIX-COMPLETE-WP-CANON-CSS-ENQUEUE-2026-07-14.md
prior_delta: _COMMUNICATION/team_90/VERDICT-WP-CANON-L-GATE_VALIDATE-CSS-ENQUEUE-DELTA-2026-07-14.md
---

# QA REQUEST — צוות 50 · E2E דפדפן מלא · WP-CANON close-out

## הקשר

חבילת WP-CANON על סטייג'ינג כולל תיקון CSS (`w2-05-shop.css` על 5 עמודי מוצר). team_90 delta VALIDATE כבר PASS.  
**נדרש דוח QA של צוות 50** — E2E מלא בדפדפן לכל התיקונים והממשקים שנגעו בחבילה (לא רק HTTP).

**איסור:** לא לתקן קוד. רק ממצאים + severity + evidence.

## סביבה

- Base: `http://eyalamit-co-il-2026.s887.upress.link` (TLS סטייג'ינג — להעדיף http)
- MCP דפדפן: navigate → lock → snapshot → unlock; צילומי מסך ל-CTA/מחיר
- גם: `qa_probe.mjs` ו/או CDP `getComputedStyle` לעמודי מוצר

## מטריצת בדיקה (חובה)

| # | URL | מה לבדוק |
|---|-----|----------|
| 1 | `/` | בית — chrome Chapters, אין שבירה גסה |
| 2 | `/shop/` | 5 כרטיסים, קישורים, Chapters |
| 3 | `/didgeridoos/`, `/bags/`, `/stands-storage/`, `/stand-floor/`, `/repair/` | **CSS:** `w2-05-shop.css` ב-<link>; **ויזואלי:** מחיר מעוצב + קבוצת CTA + כפתור וואטסאפ ירוק (לא טקסט גולמי) |
| 4 | `/books/vekatavta/`, `/kushi-blantis/`, `/tsva-bekahol/` | מחיר/CTA ספר; גלריה קיימת; tsva — C-5 מתועד כ-ACCEPT |
| 5 | `/faq/` | אקורדיון לא ריק |
| 6 | `/treatment/` או `/method/` | FAQ מסונן smoke |
| 7 | `/eyal-amit/mokesh-dahiman/` | hero + גלריה smoke, אין overflow ב-375 |
| 8 | `/qr/` + `/qr/qr1/` + מדגם | רשת + תוכן; **48/48 HTTP 200** לכל `/qr/qrN/` |
| 9 | `/press/` | smoke חי (Wave2 residual) |
| 10 | `/contact/` | טופס חי (CF7/Fluent), הודעות שגיאה לשדות חובה |

## ACCEPT מפורש (לא FAIL)

- C-5 PENDING על קישור מנדלי ל«צבע בכחול»
- מפת GI ריקה (נפילה לצור-קשר/וואטסאפ)
- תמונת גלריה משותפת `kushi-04-sinai.jpg` בשלושת הספרים
- `/press` עדיין Wave2

## כשל

- **P0:** עמוד לבן / fatal / 404 על URL חייב / overflow אופקי חמור / מחיר+CTA לא מעוצבים (רגרסיית CSS) / QR < 48/48
- **P1:** תוכן חסר מהותי (FAQ ריק, CTA חסר ב-DOM)
- **P2:** קוסמטי

## פלט חובה

`_COMMUNICATION/team_50/QA-REPORT-WP-CANON-CLOSEOUT-E2E-TEAM50-2026-07-14.md`

`overall: PASS` | `PASS_WITH_FINDINGS` | `FAIL`  
Iron Rule #1: validator = composer-2.5 ≠ builder Grok.
