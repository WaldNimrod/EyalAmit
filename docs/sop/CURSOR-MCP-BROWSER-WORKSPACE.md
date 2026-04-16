# Cursor — זמינות MCP דפדפן (`cursor-ide-browser`) לפי workspace

**גרסה:** 1.0 · **סטטוס:** ACTIVE — השלמה ל־[`AGENT-WORKSPACE-STANDARD.md`](./AGENT-WORKSPACE-STANDARD.md) §5

---

## 1. מה הבעיה

Cursor שומר תיאור MCP לפי **מזהה פרויקט** תחת `~/.cursor/projects/<slug>/mcps/`. ה־slug נגזר מנתיב ה־**workspace** שנפתח ב־**Open Folder**.

| Workspace שנפתח ב-Cursor | דוגמה slug (macOS) | מה רואים ב־`mcps/` |
|---------------------------|---------------------|---------------------|
| תיקיית האב `…/Eyal Amit` | `Users-…-Eyal-Amit` | בדרך כלל **`cursor-ide-browser`** (MCP דפדפן מובנה) |
| רק המאגר `…/Eyal Amit/EyalAmit.co.il-2026` | `Users-…-Eyal-Amit-eyalamit-co-il` | לעיתים רק **`cursor-browser-extension`** או ערכת כלים אחרת — **בלי** אותו שרת |

תוצאה: אותו מאגר Git, שני מצבי Cursor — באחד הסוכן רואה את כלי הדפדפן `cursor-ide-browser`, בשני לא.

**זה לא חוסר בהגדרות המאגר** — זה **פיצול פרויקט־Cursor** לפי תיקיית השורש הפתוחה.

---

## 2. תיקון מומלץ (מקומי למחשב זה)

אחרי ש־**שני** ה־workspaces נפתחו לפחות פעם אחת (כדי ש־Cursor ייצור את שתי התיקיות תחת `~/.cursor/projects/`):

```bash
cd /path/to/EyalAmit.co.il-2026
bash scripts/ensure_cursor_mcp_ide_browser_symlink.sh
```

הסקריפט יוצר **symlink** מ־`…/Eyal-Amit-eyalamit-co-il/mcps/cursor-ide-browser` אל העותק שב־`…/Eyal-Amit/mcps/cursor-ide-browser`.

**הפעלה מחדש של Cursor** (או Reload Window) מומלצת אחרי שינוי.

---

## 3. הרגל עבודה קנוני (ללא symlink)

לפי [`docs/WORKSPACE-POINTER.md`](../WORKSPACE-POINTER.md) — לפתוח תמיד **`EyalAmit.co.il-2026`** כשורש workspace כשעובדים על המאגר; אם נדרשים כלי הדפדפן בצורה עקבית, אפשר לפתוח את תיקיית האב **`Eyal Amit`** כדי לאחד את מזהה הפרויקט עם סביבה שכבר כוללת את `cursor-ide-browser`.

---

## 4. מה עדיין נדרש לבדיקות Hub

גם כש־MCP זמין, לבדוק אתר סטטי מ־`hub/dist/` צריך לרוב **שרת HTTP מקומי** (לא `file://`), למשל:

```bash
cd hub/dist && python3 -m http.server 8765 --bind 127.0.0.1
```

ואז בדפדפן/MCP: `http://127.0.0.1:8765/index.html`.

---

## 5. סנכרון מסמכים

שינוי מהותי כאן — לעדכן שורה בטבלת סביבה ב־[`PROJECT-ENTRY.md`](../PROJECT-ENTRY.md) אם נדרש; וקישור קצר ב־[`AGENT-WORKSPACE-STANDARD.md`](./AGENT-WORKSPACE-STANDARD.md) §5.
