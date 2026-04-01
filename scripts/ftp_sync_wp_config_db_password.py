#!/usr/bin/env python3
"""
Sync DB_NAME, DB_USER, DB_PASSWORD in remote wp-config.php from local/staging.credentials.md (FTP).

Parses MySQL triple from the הערות line: `DB: … user: … password: …` (avoids mistaking **Password:** for DB).
Usage (from repo root): python3 scripts/ftp_sync_wp_config_db_password.py

Requires: FTP access from this machine to uPress (port 21 open).
"""
from __future__ import annotations

import io
import re
from pathlib import Path


def parse_credentials(md: str) -> dict:
    out = {}
    for label, key in (
        ("**Host:**", "ftp_host"),
        ("**Port:**", "ftp_port"),
        ("**Username:**", "ftp_user"),
        ("**Password:**", "ftp_password"),
    ):
        m = re.search(re.escape(label) + r"\s*([^\n]+)", md)
        if m:
            out[key] = m.group(1).strip()

    # MySQL: single line "DB: x user: y password: z" (under הערות) — NOT generic password: (breaks on **Password:**)
    m = re.search(
        r"DB:\s*(\S+)\s+user:\s*(\S+)\s+password:\s*(\S+)",
        md,
        re.IGNORECASE,
    )
    if m:
        out["db_name"] = m.group(1)
        out["db_user"] = m.group(2)
        out["db_password"] = m.group(3)
    else:
        m = re.search(r"\*\*סיסמת MySQL / הערות:\*\*\s*([^\n]+)", md)
        if m:
            out["db_password"] = m.group(1).strip()
    if "db_password" not in out:
        raise SystemExit(
            "Could not find DB credentials. Add a line like: DB: name user: user password: pass (under מסד נתונים)."
        )

    return out


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


def main() -> None:
    root = Path(__file__).resolve().parents[1]
    cred_path = root / "local" / "staging.credentials.md"
    if not cred_path.is_file():
        raise SystemExit(f"Missing {cred_path}")

    text = cred_path.read_text(encoding="utf-8")
    c = parse_credentials(text)

    import ftplib

    host = c["ftp_host"]
    port = int(c.get("ftp_port") or "21")
    user = c["ftp_user"]
    pw = c["ftp_password"]
    db_pw = c["db_password"]
    db_name = c.get("db_name")
    db_user = c.get("db_user")

    ftp = ftplib.FTP()
    ftp.connect(host, port, timeout=45)
    ftp.login(user, pw)
    ftp.cwd("/")
    if "wp-config.php" not in ftp.nlst():
        raise SystemExit("wp-config.php not found in FTP root (check remote path).")

    buf = io.BytesIO()
    ftp.retrbinary("RETR wp-config.php", buf.write)
    original = buf.getvalue().decode("utf-8", errors="replace")
    updated = original
    if db_name:
        updated = replace_define_value(updated, "DB_NAME", db_name)
    if db_user:
        updated = replace_define_value(updated, "DB_USER", db_user)
    updated = replace_define_value(updated, "DB_PASSWORD", db_pw)
    if updated == original:
        print("wp-config.php DB_* already match credentials (no upload).")
        ftp.quit()
        return

    out = io.BytesIO(updated.encode("utf-8"))
    ftp.storbinary("STOR wp-config.php", out)
    ftp.quit()
    print("OK: wp-config.php DB_NAME / DB_USER / DB_PASSWORD synced from staging.credentials.md.")


if __name__ == "__main__":
    main()
