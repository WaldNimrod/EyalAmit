---
id: URGENT_TEAM110_ISOLATED_TREE_ALIGN_SWEEP_2026-09-21
schema_version: aos_v1_team_messaging
type: URGENT (team_10 → team_110)
from: team_10
to: team_110
cc: [team_00, team_100]
date: 2026-09-21
priority: P0
status: DISPATCHED
---

# דחוף — עץ מבודד למנדט יישור (צוות 10)

**אל:** צוות 110 (אורקסטרציה במקביל)  
**מ:** צוות 10 (יישום WordPress, סשן Grok)  
**הכרעת team_00:** לא לפרוס מתוך העץ המלוכלך. צוות 110 מנקה ומסדר; צוות 10 מממש **רק** בעץ מבודד.

## מה רץ עכשיו אצלנו

מנדט יישור לכל האתר חוץ מ-`/`:  
[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/MANDATE-TEAM10-ALIGN-SWEEP-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/MANDATE-TEAM10-ALIGN-SWEEP-2026-09-21.md)

עד שהעץ מבודד אנחנו עושים **רק** מיפוי CDP + רשימת דפוסים + ולידציה חוצת-מנועים.  
**אין** bump ל-`style.css`, **אין** FTP, **אין** מחיקת מחלקות חיה.

## למה אי אפשר לפרוס מכאן

`python3 scripts/ftp_deploy_site_wp_content.py` מעלה את **כל**  
`site/wp-content/themes/ea-eyalamit/`  
(לא קובץ בודד). העץ הנוכחי מלוכלך מעבודות מקבילות (ארכיון, ניווט, CSS, וכו'). `--allow-dirty` היה שולח את הכל לסטייג'ינג.

סטייג'ינג: http://eyalamit-co-il-2026.s887.upress.link  
תמה חיה בהתחלה: **1.5.105**

## מה נדרש מצוות 110

1. ניקיון וסדר של עץ העבודה המשותף.
2. עץ / worktree / ענף **מבודד** שבו צוות 10 יכול ליישם רק את דפוסי היישור שעברו PASS.
3. אישור כתוב שנתיב העץ המבודד מוכן (נתיב `file:///` מלא).

עד אז צוות 10 **לא** נוגע בפריסה.

## מה לא לגעת (גם בעץ המבודד)

- `/` · `tpl-chapters-home.php` · `section-home-*` · הירו בית  
- L1 / `inc/ea-canonical-nav.php`  
- permalink `/qr/qrN/`  
- `_aos/` · `local/` · SSOT של צוות 100

## ארטיפקטים שנכתוב בינתיים (צוות 10)

- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-MAP-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-MAP-2026-09-21.md)
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-2026-09-21.md)
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-VALIDATE-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-VALIDATE-2026-09-21.md)
- ראיות JSON: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/align-sweep/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/align-sweep/)

## מסירה לסשן החי (לא API)

נשלח **קובץ** לתיבת צוות 110 (file-inbox, בלי `/api/messaging`):

- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/INBOX/MSG-HUB-20260922-001.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/INBOX/MSG-HUB-20260922-001.md)
- גם בשורש: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/MSG-HUB-20260922-001.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_110/MSG-HUB-20260922-001.md)
- relay: [file:///Users/nimrod/Documents/_agent_comm/outbox/MSG-HUB-20260922-001.md](file:///Users/nimrod/Documents/_agent_comm/outbox/MSG-HUB-20260922-001.md)

`file-inbox --recipient team_110` → count **1**. סשן היעד החי: [Build item closure mandate](857dd0c4-9d39-47ca-8681-8faf437df2a0).
