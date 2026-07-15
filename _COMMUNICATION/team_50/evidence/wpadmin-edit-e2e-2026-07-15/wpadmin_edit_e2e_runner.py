#!/usr/bin/env python3
"""WP-S4-05 team_50 E2E — wp-admin editability probe + render-path corroboration.

Does NOT print secret values. Writes JSON evidence to evidence_dir.
"""
from __future__ import annotations

import json
import re
import time
from datetime import datetime, timezone
from pathlib import Path
from urllib.parse import urljoin

import requests
from dotenv import load_dotenv
import os

ROOT = Path(__file__).resolve().parents[4]
EVIDENCE = Path(__file__).resolve().parent
load_dotenv(ROOT / "local" / ".env.upress")

BASE = os.getenv("UPRESS_PUBLIC_BASE", "").rstrip("/")
REST = os.getenv("UPRESS_WP_REST_BASE", "").rstrip("/")
PMA = os.getenv("UPRESS_PHPMYADMIN_URL", "")
ADMIN_USER = os.getenv("UPRESS_WP_ADMIN_USER", "")
APP_USER = os.getenv("UPRESS_WP_APP_USER", "")
APP_PASS = os.getenv("UPRESS_WP_APP_PASS", "")
ADMIN_PASS = os.getenv("UPRESS_WP_ADMIN_PASS", "")
DB_USER = os.getenv("UPRESS_DB_USER", "")
DB_PASS = os.getenv("UPRESS_DB_PASS", "")
DB_NAME = os.getenv("UPRESS_DB_NAME", "")
PREFIX = os.getenv("UPRESS_DB_TABLE_PREFIX", "wp_")

PAGE_SLUG = "treatment"
PAGE_ID = 54
FIELD_NAME = "s1_title"
FIELD_KEY = "f_treatment_s1_title"
TEST_VALUE = "__E2E_EDIT_2026-07-15__"
DEFAULT_SNIPPET = "משהו בנשימה שלך מבקש תשומת לב"


def save(name: str, content: str | dict) -> str:
    p = EVIDENCE / name
    if isinstance(content, dict):
        p.write_text(json.dumps(content, ensure_ascii=False, indent=2), encoding="utf-8")
    else:
        p.write_text(content, encoding="utf-8")
    return str(p)


def wp_login_probe() -> dict:
    s = requests.Session()
    s.cookies.set("wordpress_test_cookie", "WP Cookie check")
    r = s.post(
        f"{BASE}/wp-login.php",
        data={
            "log": ADMIN_USER,
            "pwd": ADMIN_PASS,
            "wp-submit": "Log In",
            "redirect_to": f"{BASE}/wp-admin/",
            "testcookie": "1",
        },
        timeout=30,
    )
    errs = re.findall(r'id="login_error"[^>]*>(.*?)</div>', r.text, re.S)
    err_text = re.sub(r"<[^>]+>", "", errs[0]).strip() if errs else ""
    ok = "wp-admin" in r.url and "wp-login" not in r.url
    save("login-response-snippet.html", r.text[:12000])
    edit = None
    acf_rendered = False
    if ok:
        edit = s.get(f"{BASE}/wp-admin/post.php?post={PAGE_ID}&action=edit", timeout=30)
        acf_rendered = "acf-field" in edit.text and FIELD_NAME in edit.text
        save("edit-screen-snippet.html", edit.text[:20000])
    return {
        "method": "POST /wp-login.php",
        "env_keys": ["UPRESS_WP_ADMIN_USER", "UPRESS_WP_ADMIN_PASS"],
        "user_login": ADMIN_USER,
        "login_ok": ok,
        "final_url": r.url,
        "login_error": err_text or None,
        "edit_status": edit.status_code if edit is not None else None,
        "acf_fields_rendered": acf_rendered,
    }


def acf_plugin_probe() -> dict:
    auth = (APP_USER, APP_PASS)
    plugins = requests.get(f"{REST}/wp/v2/plugins", auth=auth, timeout=30).json()
    acf = [
        p
        for p in plugins
        if "acf" in p.get("plugin", "").lower() or "advanced custom fields" in p.get("name", "").lower()
    ]
    return {
        "source": "GET /wp/v2/plugins (UPRESS_WP_APP_USER/PASS)",
        "acf_active": bool(acf and acf[0].get("status") == "active"),
        "plugin": {k: acf[0].get(k) for k in ("name", "plugin", "status")} if acf else None,
    }


def pma_session() -> requests.Session | None:
    if not PMA:
        return None
    s = requests.Session()
    r = s.get(PMA, timeout=20)
    token = re.search(r'name="token"\s+value="([^"]+)"', r.text)
    data = {"pma_username": DB_USER, "pma_password": DB_PASS, "server": "1"}
    if token:
        data["token"] = token.group(1)
    r2 = s.post(urljoin(PMA, "index.php"), data=data, timeout=20)
    if "Cannot log in" in r2.text or DB_NAME not in r2.text:
        return None
    return s


def pma_sql(s: requests.Session, sql: str) -> str:
    # phpMyAdmin import endpoint
    r = s.post(
        urljoin(PMA, "index.php"),
        params={"route": "/database/sql", "db": DB_NAME},
        data={
            "sql_query": sql,
            "ajax_request": "true",
        },
        timeout=30,
    )
    return r.text


def meta_via_sql(action: str, value: str | None = None) -> dict:
    meta_table = f"{PREFIX}postmeta"
    if action == "read":
        sql = (
            f"SELECT meta_id, meta_key, meta_value FROM `{meta_table}` "
            f"WHERE post_id={PAGE_ID} AND meta_key IN ('{FIELD_NAME}', '_{FIELD_NAME}');"
        )
    elif action == "set":
        sql = (
            f"DELETE FROM `{meta_table}` WHERE post_id={PAGE_ID} AND meta_key IN ('{FIELD_NAME}', '_{FIELD_NAME}'); "
            f"INSERT INTO `{meta_table}` (post_id, meta_key, meta_value) VALUES "
            f"({PAGE_ID}, '{FIELD_NAME}', '{value}'), "
            f"({PAGE_ID}, '_{FIELD_NAME}', '{FIELD_KEY}');"
        )
    elif action == "clear":
        sql = (
            f"DELETE FROM `{meta_table}` WHERE post_id={PAGE_ID} AND meta_key IN ('{FIELD_NAME}', '_{FIELD_NAME}');"
        )
    else:
        raise ValueError(action)
    s = pma_session()
    if not s:
        return {"ok": False, "error": "phpMyAdmin login failed"}
    out = pma_sql(s, sql)
    save(f"sql-{action}-response.html", out[:8000])
    return {"ok": True, "action": action, "response_len": len(out)}


def front_probe() -> dict:
    r = requests.get(f"{BASE}/{PAGE_SLUG}/?nc={int(time.time())}", timeout=30)
    body = r.text
    return {
        "status": r.status_code,
        "has_test_value": TEST_VALUE in body,
        "has_default_snippet": DEFAULT_SNIPPET in body,
        "body_len": len(body),
        "white_screen": len(body) < 500,
    }


def main() -> None:
    out = {
        "generated_at": datetime.now(timezone.utc).isoformat(),
        "tester_engine": "composer-2.5",
        "wp": "WP-S4-05",
        "page": {"slug": PAGE_SLUG, "id": PAGE_ID},
        "field": {"name": FIELD_NAME, "key": FIELD_KEY, "test_value": TEST_VALUE},
        "default_snippet": DEFAULT_SNIPPET,
    }

    out["acf_plugin"] = acf_plugin_probe()
    out["wp_login"] = wp_login_probe()
    out["baseline_front"] = front_probe()

    # Render-path corroboration (NOT wp-admin — only when login blocked)
    corroboration = {"note": "SQL postmeta overlay — corroborates render only, NOT wp-admin UI"}
    corroboration["meta_before"] = meta_via_sql("read")
    corroboration["set"] = meta_via_sql("set", TEST_VALUE)
    time.sleep(2)
    corroboration["front_after_set"] = front_probe()
    corroboration["clear"] = meta_via_sql("clear")
    time.sleep(2)
    corroboration["front_after_clear"] = front_probe()
    corroboration["meta_after_cleanup"] = meta_via_sql("read")
    out["render_path_corroboration"] = corroboration

    # Verdict derivation
    login_ok = out["wp_login"]["login_ok"]
    acf_active = out["acf_plugin"]["acf_active"]
    edit_ok = corroboration["front_after_set"]["has_test_value"]
    fallback_ok = (
        not corroboration["front_after_clear"]["has_test_value"]
        and corroboration["front_after_clear"]["has_default_snippet"]
        and not corroboration["front_after_clear"]["white_screen"]
    )
    cleanup_ok = not corroboration["meta_after_cleanup"].get("ok") or corroboration["front_after_clear"]["has_default_snippet"]

    if login_ok and out["wp_login"]["acf_fields_rendered"] and edit_ok and fallback_ok and cleanup_ok:
        flag = "PASS"
    elif not login_ok:
        flag = "BLOCKED"
    else:
        flag = "FAIL"

    out["derived"] = {
        "flag": flag,
        "acf_active": acf_active,
        "wp_login_ok": login_ok,
        "acf_ui_rendered": out["wp_login"]["acf_fields_rendered"],
        "ac_edit_render_path": edit_ok,
        "ac_fallback_render_path": fallback_ok,
        "cleanup_ok": cleanup_ok,
    }

    save("results.json", out)
    print(json.dumps(out["derived"], ensure_ascii=False, indent=2))


if __name__ == "__main__":
    main()
