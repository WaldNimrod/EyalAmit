#!/usr/bin/env bash
# יוצר symlink ל־MCP cursor-ide-browser בתיקיית הפרויקט של Cursor עבור workspace «EyalAmit.co.il-2026» בלבד,
# כך שאותו שרת MCP יופיע כשפותחים את המאגר כ־Open Folder ולא רק את תיקיית האב «Eyal Amit».
#
# דרישה: Cursor כבר יצר לפחות פעם אחת את שני ה־project folders תחת ~/.cursor/projects/
# (פתיחת שני ה־workspaces לפחות פעם אחת).
#
# שימוש: bash scripts/ensure_cursor_mcp_ide_browser_symlink.sh
# או: chmod +x scripts/ensure_cursor_mcp_ide_browser_symlink.sh && ./scripts/ensure_cursor_mcp_ide_browser_symlink.sh

set -euo pipefail

CURSOR_PROJECTS="${HOME}/.cursor/projects"
# שם תיקיית הפרויקט של Cursor כשה־workspace הוא תיקיית האב (Eyal Amit)
PARENT_SLUG="Users-nimrod-Documents-Eyal-Amit"
# שם תיקיית הפרויקט כשה־workspace הוא רק המאגר EyalAmit.co.il-2026
NESTED_SLUG="Users-nimrod-Documents-Eyal-Amit-eyalamit-co-il"

SOURCE="${CURSOR_PROJECTS}/${PARENT_SLUG}/mcps/cursor-ide-browser"
TARGET_DIR="${CURSOR_PROJECTS}/${NESTED_SLUG}/mcps"
TARGET="${TARGET_DIR}/cursor-ide-browser"

if [[ ! -d "$SOURCE" ]]; then
  echo "[ensure_cursor_mcp_ide_browser] ERROR: מקור לא נמצא: $SOURCE" >&2
  echo "  פתחו ב-Cursor את תיקיית האב «Eyal Amit» לפחות פעם אחת כדי ש-Cursor ייצור את תיקיית הפרויקט." >&2
  exit 1
fi

mkdir -p "$TARGET_DIR"

if [[ -e "$TARGET" ]] || [[ -L "$TARGET" ]]; then
  if [[ -L "$TARGET" ]] && [[ "$(readlink "$TARGET")" == "$SOURCE" ]]; then
    echo "[ensure_cursor_mcp_ide_browser] OK — symlink כבר מצביע נכון: $TARGET"
    exit 0
  fi
  echo "[ensure_cursor_mcp_ide_browser] ERROR: קיים כבר: $TARGET (לא מחליפים אוטומטית)" >&2
  exit 1
fi

ln -s "$SOURCE" "$TARGET"
echo "[ensure_cursor_mcp_ide_browser] OK — נוצר: $TARGET -> $SOURCE"
