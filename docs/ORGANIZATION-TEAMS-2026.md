# ארגון צוותים — מודל 2026 (מול SSOT ישן)

מסמך זה מגדיר את **מבנה הצוותים הפעיל** בפרויקט EyalAmit.co.il-2026. גוף [`docs/sop/SSOT.md`](sop/SSOT.md) עשוי עדיין לתאר מספור ישן (0–4, Gatekeeper) — **למודל יומיומי** עקבו אחרי טבלה זו ואחרי [`_communication/README.md`](../_communication/README.md).

## צוותים פעילים

| מספר | תיקיית תקשורת | תפקיד |
|------|----------------|--------|
| **100** | `_communication/team_100/` | אדריכלות מערכת, סינתזה, דרישות |
| **10** | `_communication/team_10/` | יישום WordPress |
| **20** | `_communication/team_20/` | DB, DevOps, **Git**, סביבות |
| **30** | `_communication/team_30/` | תיעוד ודוקומנטציה |
| **50** | `_communication/team_50/` | QA, בדיקות, ולידציה |
| **90** | `_communication/team_90/` | **בקרה** (Control/Audit), מחקר ומיפוי; איתור אקטיבי של כשלים, סתירות ובחירות לא אופטימליות; הצעת חלופות מנומקות; הטלת ספק במידע לא מוכח; שערי תכנון לפני מימוש |

## מיפוי לסעיפים היסטוריים ב-SSOT (הקשר בלבד)

| SSOT (ישן) | הערה | מודל 2026 |
|------------|------|-----------|
| Team 0 — Architect | | **צוות 100** |
| Team 1 — Development | | **צוות 10** |
| Team 2 — QA | | **צוות 50** |
| Team 3 — Gatekeeper / Docs & Git | **לא בשימוש** במודל 2026 | תיאום אנושי / צוות 100; Git תחת **צוות 20**; תיעוד תחת **צוות 30** |
| Team 4 — Database | | **צוות 20** (יחד עם DevOps/Git) |

## אונבורד ופרומט ראשון

לכל צוות קובץ קבוע: `_communication/team_XX/onboard_teamXX.md` — **זהו פרומט ההקמה וההגדרה** לסשן; יש לקרוא אותו **במלואו** לפני משימת ביצוע. **אינדקס כל הקבצים + סדר עבודה:** [`_communication/README.md`](../_communication/README.md#onboarding-prompts) (עוגן `onboarding-prompts`).
