#!/usr/bin/env python3
"""
Sync DB_NAME, DB_USER, DB_PASSWORD in remote wp-config.php from local/.env.upress (FTP/FTPS).

Also ensures define( 'WP_ENVIRONMENT_TYPE', ... ) exists (insert or update) per
https://developer.wordpress.org/apis/wp-config-php/#wp-environment-type — value from
UPRESS_WP_ENVIRONMENT_TYPE (default: staging).

Before overwriting wp-config.php, uploads a backup as wp-config.php.bak (v2 §2.3).

Usage (from repo root):
  pip install -r scripts/requirements-upress.txt
  python3 scripts/ftp_sync_wp_config_db_password.py

Requires: UPRESS_DB_PASS and optionally UPRESS_DB_NAME, UPRESS_DB_USER in .env.upress (v2 §12).
"""
from __future__ import annotations

import io
import re

from upress_ftp_env import (
    connect_ftp,
    get_db_triple_for_wp_config,
    get_wp_environment_type_for_wp_config,
)


def replace_define_value(content: str, const_name: str, new_value: str) -> str:
    pat = re.compile(
        rf"(define\s*\(\s*['\"]{re.escape(const_name)}['\"]\s*,\s*)(['\"])(?:[^'\\]|\\.)*(\2\s*\)\s*;)",
        re.IGNORECASE,
    )
    m = pat.search(content)
    if not m:
        raise SystemExit(f"{const_name} define not found in wp-config.php")
    q = m.group(2)
    esc = new_value.replace("\\", "\\\\")
    esc = esc.replace("'", "\\'") if q == "'" else esc.replace('"', '\\"')
    new_line = m.group(1) + q + esc + m.group(3)
    return content[: m.start()] + new_line + content[m.end() :]


def ensure_wp_environment_type(content: str, env_type: str) -> str:
    """Insert or update WP_ENVIRONMENT_TYPE; no-op if already set to env_type."""
    define_re = re.compile(
        r"define\s*\(\s*['\"]WP_ENVIRONMENT_TYPE['\"]\s*,\s*['\"]([^'\"]*)['\"]\s*\)\s*;",
        re.IGNORECASE,
    )
    m = define_re.search(content)
    if m:
        current = m.group(1).strip().lower()
        if current == env_type:
            return content
        return replace_define_value(content, "WP_ENVIRONMENT_TYPE", env_type)

    anchor = re.compile(
        r"(define\s*\(\s*['\"]DB_HOST['\"]\s*,\s*['\"][^'\"]*['\"]\s*\)\s*;\s*\n)",
        re.IGNORECASE,
    )
    ma = anchor.search(content)
    if not ma:
        raise SystemExit(
            "wp-config.php has no WP_ENVIRONMENT_TYPE and no DB_HOST line to anchor after — "
            "add manually: https://developer.wordpress.org/apis/wp-config-php/#wp-environment-type"
        )
    snippet = (
        "\n"
        "/** WordPress environment type: "
        "https://developer.wordpress.org/apis/wp-config-php/#wp-environment-type */\n"
        f"define( 'WP_ENVIRONMENT_TYPE', '{env_type}' );\n"
    )
    return content[: ma.end()] + snippet + content[ma.end() :]


def main() -> None:
    db_name, db_user, db_pw = get_db_triple_for_wp_config()
    wp_env_type = get_wp_environment_type_for_wp_config()

    ftp, _remote_rr = connect_ftp(timeout=45)

    if "wp-config.php" not in ftp.nlst():
        ftp.quit()
        raise SystemExit(
            "wp-config.php not found in WordPress FTP root — check UPRESS_FTP_REMOTE_ROOT."
        )

    buf = io.BytesIO()
    ftp.retrbinary("RETR wp-config.php", buf.write)
    original = buf.getvalue().decode("utf-8", errors="replace")
    updated = original
    if db_name:
        updated = replace_define_value(updated, "DB_NAME", db_name)
    if db_user:
        updated = replace_define_value(updated, "DB_USER", db_user)
    updated = replace_define_value(updated, "DB_PASSWORD", db_pw)
    updated = ensure_wp_environment_type(updated, wp_env_type)
    if updated == original:
        print(
            "wp-config.php already matches .env.upress (DB_* and WP_ENVIRONMENT_TYPE); no upload."
        )
        ftp.quit()
        return

    # Backup current file on server before overwrite (v2 §2.3)
    bak = io.BytesIO(original.encode("utf-8"))
    ftp.storbinary("STOR wp-config.php.bak", bak)

    out = io.BytesIO(updated.encode("utf-8"))
    ftp.storbinary("STOR wp-config.php", out)
    ftp.quit()
    print(
        "OK: wp-config.php DB_* and WP_ENVIRONMENT_TYPE synced from local/.env.upress "
        "(backup: wp-config.php.bak)."
    )


if __name__ == "__main__":
    main()
