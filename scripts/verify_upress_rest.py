#!/usr/bin/env python3
"""
Smoke test: authenticated GET wp/v2/users/me (Application Password, v2 §7).

Usage (repo root, after local/.env.upress is filled):
  pip install -r scripts/requirements-upress.txt
  python3 scripts/verify_upress_rest.py

Requires: UPRESS_WP_REST_BASE, UPRESS_WP_APP_USER, UPRESS_WP_APP_PASS
"""
from __future__ import annotations

import base64
import json
import os
import ssl
import sys
import urllib.error
import urllib.request
from pathlib import Path

try:
    from dotenv import load_dotenv
except ImportError as e:
    raise SystemExit("pip install -r scripts/requirements-upress.txt") from e


def main() -> None:
    root = Path(__file__).resolve().parents[1]
    envp = root / "local" / ".env.upress"
    if not envp.is_file():
        raise SystemExit(f"Missing {envp}")
    load_dotenv(envp)

    base = (os.getenv("UPRESS_WP_REST_BASE") or "").strip().rstrip("/")
    user = (os.getenv("UPRESS_WP_APP_USER") or "").strip()
    pw = (os.getenv("UPRESS_WP_APP_PASS") or "").strip()
    if not base or not user or not pw:
        raise SystemExit(
            "Set UPRESS_WP_REST_BASE, UPRESS_WP_APP_USER, UPRESS_WP_APP_PASS in local/.env.upress"
        )

    url = f"{base}/wp/v2/users/me?context=edit"
    token = base64.b64encode(f"{user}:{pw}".encode()).decode()
    req = urllib.request.Request(
        url,
        headers={"Authorization": f"Basic {token}"},
        method="GET",
    )
    ctx = ssl.create_default_context()
    try:
        with urllib.request.urlopen(req, timeout=30, context=ctx) as resp:
            body = resp.read().decode("utf-8", errors="replace")
            data = json.loads(body)
    except urllib.error.HTTPError as e:
        print(f"HTTP {e.code}: {e.reason}", file=sys.stderr)
        if e.fp:
            print(e.fp.read().decode("utf-8", errors="replace")[:2000], file=sys.stderr)
        raise SystemExit(1) from e
    except urllib.error.URLError as e:
        raise SystemExit(f"Request failed: {e}") from e

    login = data.get("slug") or data.get("name")
    print(f"OK: REST auth works. user id={data.get('id')} slug/name={login!r}")


if __name__ == "__main__":
    main()
