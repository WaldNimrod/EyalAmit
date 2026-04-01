# WordPress Agent Skills (מקור חיצוני)

סט מצומצם של סקילים מהמאגר הרשמי **[WordPress/agent-skills](https://github.com/WordPress/agent-skills)** — הועתק ל־`.cursor/skills/` כדי ש-Cursor יטען אותם אוטומטית (ראו [תיעוד Cursor — Skills](https://www.cursor.com/docs/context/skills)).

## מה מותקן כאן

| תיקייה | שימוש מומלץ בפרויקט Eyal Amit |
|--------|--------------------------------|
| **`eyalamit-staging-ftp`** | **מקומי לפרויקט:** סטייג'ינג uPress מ־Cursor — תוסף SFTP/FTP, `sftp.json` בטוח, סקריפט `wp-config` |
| `wp-plugin-development` | PHP, תוספים, ודפוסי WordPress כלליים |
| `wp-rest-api` | REST, אינטגרציות |
| `wp-performance` | ביצועים, אופטימיזציה |
| `wp-wpcli-and-ops` | WP-CLI, תפעול סביבה |
| `wp-phpstan` | ניתוח סטטי (אופציונלי) |
| `wp-project-triage` | מיפוי קוד/בעיות במערכת legacy |

**הערה:** המסלול שלכם כולל Elementor ומיגרציה — סקילים ממוקדי בלוקים בלבד לא הוכנסו כברירת מחדל; ניתן להוסיף ידנית מתוך המאגר (למשל `wp-block-development`) אם נדרש.

## עדכון

```bash
git clone --depth 1 https://github.com/WordPress/agent-skills.git /tmp/wp-agent-skills
# להעתיק מחדש תיקיות skills נבחרות ל־.cursor/skills/
```

כלי `npx skills add` משתנה בין גרסאות; אם יציב אצלכם — אפשר לתעד כאן פקודה מדויקת אחרי בדיקה מקומית.

## רישיון

עקבו אחרי הרישיון והקרדיט במאגר המקורי של WordPress.
