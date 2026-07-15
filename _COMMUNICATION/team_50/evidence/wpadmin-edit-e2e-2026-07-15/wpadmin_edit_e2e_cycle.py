#!/usr/bin/env python3
"""WP-S4-05 team_50 — full wp-admin edit cycle via authenticated POST + front verify."""
from __future__ import annotations

import json
import re
import time
from datetime import datetime, timezone
from pathlib import Path

import requests
from dotenv import load_dotenv
import os

ROOT = Path(__file__).resolve().parents[4]
EVIDENCE = Path(__file__).resolve().parent
load_dotenv(ROOT / "local" / ".env.upress")

BASE = os.getenv("UPRESS_PUBLIC_BASE", "").rstrip("/")
REST = os.getenv("UPRESS_WP_REST_BASE", "").rstrip("/")
ADMIN_USER = os.getenv("UPRESS_WP_ADMIN_USER", "")
ADMIN_PASS = os.getenv("UPRESS_WP_ADMIN_PASS", "")
APP_USER = os.getenv("UPRESS_WP_APP_USER", "")
APP_PASS = os.getenv("UPRESS_WP_APP_PASS", "")

PAGE_ID = 54
PAGE_SLUG = "treatment"
FIELD_NAME = "s1_title"
FIELD_KEY = "f_treatment_s1_title"
GROUP_KEY = "group_chapters_treatment"
TEST_VALUE = "__E2E_EDIT_2026-07-15__"
DEFAULT_SNIPPET = "משהו בנשימה שלך מבקש תשומת לב"


def save(name: str, content: str | dict) -> str:
    p = EVIDENCE / name
    if isinstance(content, dict):
        p.write_text(json.dumps(content, ensure_ascii=False, indent=2), encoding="utf-8")
    else:
        p.write_text(content, encoding="utf-8")
    return str(p)


def session_login() -> requests.Session:
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
        timeout=60,
    )
    ok = "wp-admin" in r.url and "wp-login" not in r.url
    if not ok:
        errs = re.findall(r'id="login_error"[^>]*>(.*?)</div>', r.text, re.S)
        err = re.sub(r"<[^>]+>", "", errs[0]).strip() if errs else "unknown"
        raise RuntimeError(f"wp-login failed: {err}")
    return s


def grab_nonce(html: str, name: str) -> str | None:
    for pat in (
        rf'name="{name}"[^>]*value="([^"]+)"',
        rf'id="{name}"[^>]*value="([^"]+)"',
    ):
        m = re.search(pat, html)
        if m:
            return m.group(1)
    return None


def front_probe() -> dict:
    r = requests.get(f"{BASE}/{PAGE_SLUG}/?nc={int(time.time())}", timeout=60)
    body = r.text
    return {
        "status": r.status_code,
        "has_test_value": TEST_VALUE in body,
        "has_default_snippet": DEFAULT_SNIPPET in body,
        "body_len": len(body),
        "white_screen": len(body) < 500,
    }


def acf_plugin_probe() -> dict:
    auth = (APP_USER, APP_PASS)
    plugins = requests.get(f"{REST}/wp/v2/plugins", auth=auth, timeout=60).json()
    acf = [
        p
        for p in plugins
        if "acf" in p.get("plugin", "").lower()
        or "advanced custom fields" in p.get("name", "").lower()
    ]
    return {
        "acf_active": bool(acf and acf[0].get("status") == "active"),
        "plugin": {k: acf[0].get(k) for k in ("name", "plugin", "status")} if acf else None,
    }


def edit_screen_probe(s: requests.Session) -> dict:
    edit = s.get(f"{BASE}/wp-admin/post.php?post={PAGE_ID}&action=edit", timeout=90)
    html = edit.text
    save("edit-screen-full-v2.html", html[:800000])
    mb_url_m = re.search(r'_wpMetaBoxUrl = "([^"]+)"', html)
    mb_html = ""
    if mb_url_m:
        mb_url = mb_url_m.group(1).replace("\\/", "/")
        mb = s.get(mb_url, timeout=90)
        mb_html = mb.text
        save("meta-box-loader-v2.html", mb_html[:800000])
    combined = html + mb_html
    acf_field_count = combined.count('class="acf-field')
    has_s1 = 'data-name="s1_title"' in combined or f"data-key=\"{FIELD_KEY}\"" in combined
    has_group = GROUP_KEY in combined or "פרקים — treatment" in combined
    # acf JS config
    acf_data = re.search(r"acf\.data\s*=\s*(\{[\s\S]*?\});", combined)
    acf_config_has_key = FIELD_KEY in (acf_data.group(1) if acf_data else "")
    return {
        "edit_status": edit.status_code,
        "acf_field_div_count": acf_field_count,
        "has_s1_title_input": has_s1,
        "has_group_chapters_treatment": has_group,
        "acf_js_config_has_field_key": acf_config_has_key,
        "acf_fields_rendered": acf_field_count > 0 and has_s1,
        "nonces": {
            "_wpnonce": bool(grab_nonce(html, "_wpnonce")),
            "_acf_nonce": bool(grab_nonce(html, "_acf_nonce")),
        },
    }


def save_acf_field(s: requests.Session, html: str, value: str) -> dict:
    wpnonce = grab_nonce(html, "_wpnonce")
    acf_nonce = grab_nonce(html, "_acf_nonce")
    data = {
        "post_ID": str(PAGE_ID),
        "post_type": "page",
        "originalaction": "editpost",
        "action": "editpost",
        "post_status": "publish",
        "comment_status": "closed",
        "ping_status": "closed",
        "_wpnonce": wpnonce,
        "_acf_screen": "post",
        "_acf_post_id": str(PAGE_ID),
        "_acf_validation": "1",
        "_acf_nonce": acf_nonce,
        "_acf_changed": "1",
        "post_title": "טיפול בדיג'רידו",
        "content": "",
        f"acf[{FIELD_KEY}]": value,
    }
    r = s.post(f"{BASE}/wp-admin/post.php", data=data, timeout=90, allow_redirects=True)
    return {"status": r.status_code, "final_url": r.url}


def main() -> None:
    out: dict = {
        "generated_at": datetime.now(timezone.utc).isoformat(),
        "tester_engine": "composer-2.5",
        "wp": "WP-S4-05",
        "page": {"id": PAGE_ID, "slug": PAGE_SLUG},
        "field": {"name": FIELD_NAME, "key": FIELD_KEY, "group": GROUP_KEY, "test_value": TEST_VALUE},
        "default_snippet": DEFAULT_SNIPPET,
        "env_keys": ["UPRESS_WP_ADMIN_USER", "UPRESS_WP_ADMIN_PASS"],
        "user_login": ADMIN_USER,
    }

    out["acf_plugin"] = acf_plugin_probe()
    s = session_login()
    out["wp_login"] = {"login_ok": True, "user_login": ADMIN_USER}
    out["edit_screen"] = edit_screen_probe(s)

    edit_html = (EVIDENCE / "edit-screen-full-v2.html").read_text(encoding="utf-8")

    out["baseline_front"] = front_probe()
    out["ac_edit"] = {"save": save_acf_field(s, edit_html, TEST_VALUE)}
    time.sleep(2)
    out["ac_edit"]["front_after_set"] = front_probe()
    out["ac_fallback"] = {"save": save_acf_field(s, edit_html, "")}
    time.sleep(2)
    out["ac_fallback"]["front_after_clear"] = front_probe()

    acf_ui = out["edit_screen"]["acf_fields_rendered"]
    acf_active = out["acf_plugin"]["acf_active"]
    ac_edit_ok = out["ac_edit"]["front_after_set"]["has_test_value"]
    ac_fallback_ok = (
        not out["ac_fallback"]["front_after_clear"]["has_test_value"]
        and out["ac_fallback"]["front_after_clear"]["has_default_snippet"]
        and not out["ac_fallback"]["front_after_clear"]["white_screen"]
    )
    cleanup_ok = not out["ac_fallback"]["front_after_clear"]["has_test_value"]

    if acf_active and acf_ui and ac_edit_ok and ac_fallback_ok and cleanup_ok:
        flag = "PASS"
    elif acf_active and ac_edit_ok and ac_fallback_ok and cleanup_ok and not acf_ui:
        flag = "FAIL"  # save path works; editor UI missing — editability promise blocked for Eyal
    elif not ac_edit_ok:
        flag = "FAIL"
    else:
        flag = "FAIL"

    out["verdict"] = flag
    out["summary"] = {
        "acf_active": acf_active,
        "acf_ui_rendered": acf_ui,
        "ac_edit_ok": ac_edit_ok,
        "ac_fallback_ok": ac_fallback_ok,
        "cleanup_ok": cleanup_ok,
    }

    save("e2e-cycle-results.json", out)
    print(json.dumps(out["summary"], ensure_ascii=False, indent=2))
    print("verdict:", flag)


if __name__ == "__main__":
    main()
