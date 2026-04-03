---
name: eyal-client-hub-publish
description: >
  Builds the Eyal client hub from hub/ (Client Hub Standard v1.1) and uploads hub/dist/ to uPress FTP (ea-eyal-hub).
  Use when the user asks to update or deploy the Eyal hub, push hub changes for Eyal, refresh staging hub, or after editing
  hub data (decisions.json, tasks.json, roadmap.json, updates.json, deliverables.json) or hub/src assets; also when Eyal does not see latest HTML at the hub URL.
---

# Eyal client hub — build + FTP publish

## מה הסקיל עושה

1. **בונה** את `hub/dist/` מ־`hub/data/` + `hub/src/` (`scripts/build_eyal_client_hub.py`).
2. **מעלה** את תוכן `hub/dist/` ל־FTP/FTPS לפי `local/.env.upress` (`scripts/ftp_publish_eyal_client_hub.py`). **לפני ההעלאה** הסקריפט (ברירת מחדל) **מוחק בשרת** קבצים תחת נתיב ה־Hub שאינם ב־`dist` — כדי להסיר שאריות מגרסאות ישנות; `--no-prune` משבית.

## לפני הרצה

- שורש המאגר: `EyalAmit.co.il-2026`.
- קובץ סודות: `local/.env.upress` (לא ב־Git) — שדות: [`docs/project/EYAL_ENV_VARS_REFERENCE.md`](../../docs/project/EYAL_ENV_VARS_REFERENCE.md) §2.
- תלות FTP: `pip install -r scripts/requirements-upress.txt`.

## פקודות (הרץ מהשורש)

```bash
python3 scripts/build_eyal_client_hub.py
# אופציונלי — העתקת docx/txt/pdf ל-dist/files/:
python3 scripts/build_eyal_client_hub.py --mirror-docs
# או: --mirror-docx (alias)

python3 scripts/ftp_publish_eyal_client_hub.py --dry-run
python3 scripts/ftp_publish_eyal_client_hub.py
```

אם חסר `hub/dist/`, סקריפט הפרסום יציין להריץ קודם את `build_eyal_client_hub.py`.

## איפה זה נוחת בשרת

**סטייג'ינג — גלישה:** אין תעודת SSL ציבורית תקינה על sandbox; השתמשו ב־**`http://`** לבדיקות (דפדפן / MCP / `curl` בלי `-k`). דוגמה: `http://<דומיין-סטייג'ינג>/ea-eyal-hub/index.html` — לפי `UPRESS_EYAL_HUB_PATH`. **פרודקשן:** רק **`https://`** עם תעודה תקינה.

עמודים: `roadmap.html`, `tasks.html` (משימות + החלטות + ייצוא JSON). `pending.html` מפנה ל־`tasks.html`.

## צפייה ואבטחה

לפי נוהל Hub v1.1: **אין** לחסום צפייה בתוכן ה־Hub עם Basic Auth על כל התיקייה. אימות ל־F-15 (אם יופעל) — נפרד וממוקד.

## הפניות

- `docs/CLIENT_HUB_STANDARD_v1.md` — נוהל נעול
- `docs/CLIENT_HUB_APPENDIX_EYAL.md` — נספח פרויקט
- `hub/EYAL-HUB-SSOT-WORKFLOW.md` — זרימת SSOT
- `hub/README.md` — ממשק לקוח יחיד (אין עותק תחת `docs/project/eyal-client-hub/`)
- `scripts/build_eyal_client_hub.py` · `scripts/ftp_publish_eyal_client_hub.py`
