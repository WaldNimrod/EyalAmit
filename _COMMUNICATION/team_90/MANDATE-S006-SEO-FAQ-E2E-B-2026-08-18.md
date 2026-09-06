# MANDATE — team_90 · Composer · S006 E2E ב׳ (רגרסיה remainder + testimonials)

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ בלבד. TLS פג בכוונה — `curl -sk` מותר כאן בלבד. פלט ריק = FAIL. `-fast` אסור.
**אל תשנה** PHP / JSON / אקסל / טרקר. רק פסק הדין.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`

חוזה א׳ כבר **PASS**: `_COMMUNICATION/team_90/VERDICT-S006-SEO-FAQ-CONTRACT-A-2026-08-18.md`

בסיס: `http://eyalamit-co-il-2026.s887.upress.link`

## רגרסיה חובה (כולן CONFIRMED ל-PASS)

| עמוד | בדיקה | לא FAIL אם |
|---|---|---|
| `/testimonials/` | og/meta description בלי PLACEHOLDER/צוות 80. H1 נשאר `מדיה <em>ווידאו</em>`. כרטיסי המלצות ב-`<main>` (ספירה ≥ 40; יעד 44). | M-03/M-04 מדיה ממתינה |
| `/faq/` | H1 `שאלות נפוצות` בלי em. הירו קיים. שלושת href: `/blog/pregnancy-didgeridoo` `/muse` `/cbDidg-therapy-training` נשארים. | FAQ-01 הירו מדיה; FAQ-04/05/06/07 ממתינים; 404 על שלושת ה-href אינו כשל |
| `/books/kushi-blantis/` | אין `mrng.to`. אין מחיר 69/59/79. H1 `כושי בלאנטיס`. | KSH-01…05 מדיה |
| `/books/tsva-bekahol/` | אין `mrng.to`. אין כפתור מנדלי חי (TSV-07). אין 69/59/79. | TSV-01/02/03/07 |
| `/books/vekatavta/` | אין `mrng.to`. נשמרים `היקוקומורי`/`היקוקמורי`. אין 69/59/79. | VKT-01/02 |
| `/snoring-sleep-apnea/` | סיפור יוני קיים. כרטיסי ממתין מכבי/יוני קיימים (לא נמחקו). | SNR-01…04 |
| `/books/` הורה | `mrng.to` **מותר** (חבילת 3). | BK-04/05/06 |

`qa_probe` דסקטופ על: `/testimonials/` `/faq/` `/books/kushi-blantis/` `/books/tsva-bekahol/` `/books/vekatavta/` `/snoring-sleep-apnea/` — overflow false.

קישורי תפריט דגימה (`/` `/method/` `/lessons/` `/shop/` `/contact/` `/eyal-amit/` `/books/` `/faq/`) — 200 או 301.

כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-SEO-FAQ-E2E-B-2026-08-18.md`
