---
id: QA-REQUEST-WP-CANON-TEMPLATE-UNIFICATION-E2E-TEAM50-2026-07-14
from_team: team_110
to_team: team_50
cc: team_00, team_100, team_90
date: 2026-07-14
type: qa-request
wp: WP-CANON-TEMPLATE-UNIFICATION
staging: http://eyalamit-co-il-2026.s887.upress.link
builder_engine: cursor-grok-4.5
qa_engine_required: composer-2.5
---

# QA REQUEST — צוות 50 · E2E דפדפן · WP-CANON-TEMPLATE-UNIFICATION

## הקשר

team_110 (Grok) מימש T1–T6 ופרס לסטייג'ינג. team_90 (Composer) כבר חתם L-GATE_BUILD/VALIDATE.  
**עכשיו נדרש דוח QA של צוות 50** — בדיקת E2E בדפדפן של **כלל הממשקים** שנגעו ב-WP: דיוק מידע + עיצוב/לייאאוט (לא רק HTTP 200).

**איסור:** לא לתקן קוד. רק לתעד ממצאים + severity + evidence (צילום/snapshot/qa_probe).

## סביבה

- Base: `http://eyalamit-co-il-2026.s887.upress.link` (TLS סטייג'ינג — להעדיף http)
- פריסה: FTP `scripts/ftp_deploy_site_wp_content.py` הושלם לפני הבדיקה
- MCP דפדפן: navigate → lock → snapshot → unlock
- גם: `qa_probe.mjs` על הנתיבים למטה

## מטריצת בדיקה (חובה)

| # | URL | מה לבדוק |
|---|-----|----------|
| 1 | `/shop/` | רשת 5 כרטיסים, קישורים למוצרים, מחיר/"מחיר לפי התאמה", Chapters chrome |
| 2 | `/qr/` | רשת קישורי QR, מיון מספרי |
| 3 | `/qr/qr1/` … sample iframe + img (`qr2` + עמוד עם img) | תוכן גוף, iframe רספונסיבי, אין overflow ב-375px |
| 4 | כל `/qr/qrN/` | לפחות מדגם 8 + אימות סטטוס 200 לכולם (או matrix מלא) |
| 5 | `/eyal-amit/mokesh-dahiman/` | hero וידאו/unmute UI, גלריה 19, FB embeds, אין overflow |
| 6 | `/faq/` | אקורדיון שאלות לא ריק, קטגוריות |
| 7 | `/treatment/`, `/method/`, `/lessons/` | FAQ מסונן + עיצוב |
| 8 | `/didgeridoos/`, `/bags/`, `/repair/` | product-cta: מחיר + כפתורי רכישה/וואטסאפ |
| 9 | `/books/vekatavta/`, `/kushi-blantis/`, `/tsva-bekahol/` | מחיר ב-hero, שני כפתורי רכישה, גלריה; tsva מסומן C-5 |
| 10 | `/press/` | עדיין חי (Wave2 residual) — smoke בלבד |

## קריטריוני כשל

- P0: עמוד לבן / PHP fatal / 404 על URL שחייב 200 / overflow אופקי במובייל על מוקש/QR/מוצר
- P1: תוכן חסר מול מה שצפוי (FAQ ריק, גלריה חסרה, CTA חסר)
- P2: פער עיצובי קוסמטי / יישור

## פלט חובה

`_COMMUNICATION/team_50/QA-REPORT-WP-CANON-TEMPLATE-UNIFICATION-E2E-2026-07-14.md`

כולל: PASS/FAIL כולל, טבלת ממצאים, evidence paths, המלצה ל-team_10/110.
