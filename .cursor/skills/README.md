# WordPress Agent Skills (מקור חיצוני + הרחבות פרויקט)

סט סקילים מהמאגר הרשמי **[WordPress/agent-skills](https://github.com/WordPress/agent-skills)** — מועתק ל־`.cursor/skills/` כדי ש-Cursor יטען אותם אוטומטית (ראו [תיעוד Cursor — Skills](https://www.cursor.com/docs/context/skills)).

**תקן סביבה מחייב לכל האגנטים:** [`docs/sop/AGENT-WORKSPACE-STANDARD.md`](../../docs/sop/AGENT-WORKSPACE-STANDARD.md) · כללי Cursor: [`.cursor/rules/eyalamit-agent-workspace-mandatory.mdc`](../rules/eyalamit-agent-workspace-mandatory.mdc)

## הרחבות עורך (לא Skills — להתקין ב-Cursor)

המאגר כולל [`.vscode/extensions.json`](../../.vscode/extensions.json): **Intelephense**, **EditorConfig**, **PHP Debug**, **GitLens**; לדיבוג PHP יש [`launch.json`](../../.vscode/launch.json) (Listen Xdebug). פירוט והשוואה לרשימת Cursor (~8 פריטים): [`docs/sop/AGENT-WORKSPACE-STANDARD.md` §3.3–3.5](../../docs/sop/AGENT-WORKSPACE-STANDARD.md).

## מה מותקן כאן

| תיקייה | שימוש מומלץ בפרויקט Eyal Amit |
|--------|--------------------------------|
| **`eyalamit-staging-ftp`** | **מקומי לפרויקט:** סטייג'ינג uPress מ־Cursor — תוסף SFTP/FTP, `sftp.json` בטוח, סקריפט `wp-config` |
| `wp-plugin-development` | PHP, תוספים, ודפוסי WordPress כלליים |
| `wp-block-development` | בלוקים מותאמים, Block API, עורך בלוקים |
| `wp-block-themes` | תבניות בלוק, `theme.json`, FSE (כשנוגעים בתחום) |
| `wp-rest-api` | REST, אינטגרציות |
| `wp-performance` | ביצועים, אופטימיזציה |
| `wp-wpcli-and-ops` | WP-CLI, תפעול סביבה |
| `wp-phpstan` | ניתוח סטטי (אופציונלי) |
| `wp-project-triage` | מיפוי קוד/בעיות במערכת legacy |

## עדכון מה-upstream

```bash
git clone --depth 1 https://github.com/WordPress/agent-skills.git /tmp/wp-agent-skills
# להעתיק מחדש תיקיות skills נבחרות ל־.cursor/skills/
```

כלי `npx skills add` משתנה בין גרסאות; אם יציב אצלכם — אפשר לתעד כאן פקודה מדויקת אחרי בדיקה מקומית.

## רישיון

עקבו אחרי הרישיון והקרדיט במאגר המקורי של WordPress.
