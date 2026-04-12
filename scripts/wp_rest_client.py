#!/usr/bin/env python3
"""
WP REST API client for eyalamit staging/production.

Uses Application Password auth (UPRESS_WP_APP_USER / UPRESS_WP_APP_PASS).
All functions load credentials from local/.env.upress automatically.

Usage:
    python3 scripts/wp_rest_client.py --verify
    python3 scripts/wp_rest_client.py --ensure-page treatment "טיפול בדיג׳רידו"
    python3 scripts/wp_rest_client.py --ensure-page method "השיטה"
    python3 scripts/wp_rest_client.py --set-template <post_id> page-templates/template-treatment.php

Requires: pip install -r scripts/requirements-upress.txt
"""
from __future__ import annotations

import argparse
import base64
import json
import os
import sys
import urllib.error
import urllib.parse
import urllib.request
from pathlib import Path


# ── Credential loading ────────────────────────────────────────────────────────

def _load_env() -> None:
    try:
        from dotenv import load_dotenv
    except ImportError:
        raise SystemExit("pip install -r scripts/requirements-upress.txt")
    root = Path(__file__).resolve().parents[1]
    envp = root / "local" / ".env.upress"
    if not envp.is_file():
        raise SystemExit(f"Missing {envp}")
    load_dotenv(envp)


def _get_auth_header() -> str:
    _load_env()
    user = (os.getenv("UPRESS_WP_APP_USER") or "").strip()
    pw   = (os.getenv("UPRESS_WP_APP_PASS") or "").strip()
    if not user or not pw:
        raise SystemExit("UPRESS_WP_APP_USER and UPRESS_WP_APP_PASS must be set in local/.env.upress")
    # WP normalises Application Passwords by stripping spaces before checking
    token = base64.b64encode(f"{user}:{pw}".encode()).decode()
    return f"Basic {token}"


def _base_url() -> str:
    _load_env()
    base = (os.getenv("UPRESS_WP_REST_BASE") or "").strip().rstrip("/")
    if not base:
        raise SystemExit("UPRESS_WP_REST_BASE must be set in local/.env.upress")
    return base


# ── Low-level HTTP helpers ────────────────────────────────────────────────────

def _request(method: str, path: str, body: dict | None = None) -> dict:
    """Make an authenticated JSON request to the WP REST API."""
    url = _base_url() + path
    data = json.dumps(body).encode() if body else None
    headers = {
        "Authorization": _get_auth_header(),
        "Content-Type": "application/json",
        "Accept": "application/json",
    }
    req = urllib.request.Request(url, data=data, headers=headers, method=method)
    try:
        with urllib.request.urlopen(req, timeout=30) as resp:
            return json.loads(resp.read().decode("utf-8", errors="replace"))
    except urllib.error.HTTPError as e:
        body_text = e.fp.read().decode("utf-8", errors="replace") if e.fp else ""
        raise RuntimeError(f"HTTP {e.code} {e.reason} → {url}\n{body_text[:600]}") from e
    except urllib.error.URLError as e:
        raise RuntimeError(f"Request failed: {e} → {url}") from e


def _request_raw(method: str, path: str, body: dict | None = None) -> tuple[int, dict]:
    """Like _request but returns (status_code, data) without raising on 4xx."""
    url = _base_url() + path
    data = json.dumps(body).encode() if body else None
    headers = {
        "Authorization": _get_auth_header(),
        "Content-Type": "application/json",
        "Accept": "application/json",
    }
    req = urllib.request.Request(url, data=data, headers=headers, method=method)
    try:
        with urllib.request.urlopen(req, timeout=30) as resp:
            return resp.status, json.loads(resp.read().decode("utf-8", errors="replace"))
    except urllib.error.HTTPError as e:
        body_text = e.fp.read().decode("utf-8", errors="replace") if e.fp else ""
        try:
            return e.code, json.loads(body_text)
        except Exception:
            return e.code, {"error": body_text}


# ── Public API ────────────────────────────────────────────────────────────────

def verify_auth() -> bool:
    """Return True if Application Password auth works."""
    try:
        data = _request("GET", "/wp/v2/users/me?context=edit")
        print(f"✅ REST auth OK — user id={data.get('id')} slug={data.get('slug')!r}")
        return True
    except RuntimeError as e:
        print(f"❌ REST auth failed: {e}", file=sys.stderr)
        return False


def get_page_by_slug(slug: str) -> dict | None:
    """Return the page dict for the given slug, or None if not found."""
    slug = slug.strip("/")
    status, data = _request_raw("GET", f"/wp/v2/pages?slug={urllib.parse.quote(slug)}&status=any&per_page=1")
    if status == 200 and isinstance(data, list) and data:
        return data[0]
    return None


def ensure_page(slug: str, title: str, status: str = "publish") -> int:
    """
    Create a page with the given slug and title if it doesn't exist.
    If it already exists, update its status to published.
    Returns the post ID.
    """
    slug = slug.strip("/")
    existing = get_page_by_slug(slug)
    if existing:
        post_id = existing["id"]
        if existing.get("status") != status:
            _request("POST", f"/wp/v2/pages/{post_id}", {"status": status})
            print(f"✅ Published existing page /{slug} (ID {post_id})")
        else:
            print(f"ℹ️  Page /{slug} already exists and is published (ID {post_id})")
        return post_id

    data = _request("POST", "/wp/v2/pages", {
        "slug": slug,
        "title": title,
        "status": status,
        "content": "",
    })
    post_id = data["id"]
    print(f"✅ Created page /{slug} — '{title}' (ID {post_id})")
    return post_id


def set_page_template(post_id: int, template_filename: str) -> None:
    """
    Set the page template for a post via the REST API.
    template_filename: e.g. 'page-templates/template-treatment.php'
    """
    _request("POST", f"/wp/v2/pages/{post_id}", {"template": template_filename})
    print(f"✅ Set template '{template_filename}' on page ID {post_id}")


def get_page_template(post_id: int) -> str:
    """Return the current page template filename for a post."""
    data = _request("GET", f"/wp/v2/pages/{post_id}?context=edit")
    return data.get("template", "")


def list_pages(per_page: int = 20) -> list[dict]:
    """Return a list of all pages (basic info)."""
    data = _request("GET", f"/wp/v2/pages?per_page={per_page}&status=any&context=edit")
    return [{"id": p["id"], "slug": p["slug"], "title": p["title"]["rendered"],
             "status": p["status"], "template": p.get("template", "")} for p in data]


# ── CLI ───────────────────────────────────────────────────────────────────────

def main() -> None:
    parser = argparse.ArgumentParser(description="WP REST API client for eyalamit")
    parser.add_argument("--verify", action="store_true", help="Verify auth and exit")
    parser.add_argument("--ensure-page", nargs=2, metavar=("SLUG", "TITLE"),
                        help="Create or publish page with slug and title")
    parser.add_argument("--set-template", nargs=2, metavar=("POST_ID", "TEMPLATE"),
                        help="Set page template (e.g. page-templates/template-treatment.php)")
    parser.add_argument("--get-template", metavar="POST_ID", type=int,
                        help="Print current template of a page")
    parser.add_argument("--list-pages", action="store_true", help="List all pages")
    args = parser.parse_args()

    if args.verify:
        sys.exit(0 if verify_auth() else 1)

    if args.ensure_page:
        slug, title = args.ensure_page
        post_id = ensure_page(slug, title)
        print(f"Post ID: {post_id}")

    if args.set_template:
        post_id = int(args.set_template[0])
        template = args.set_template[1]
        set_page_template(post_id, template)

    if args.get_template:
        tpl = get_page_template(args.get_template)
        print(f"Template: {tpl!r}")

    if args.list_pages:
        pages = list_pages()
        for p in pages:
            print(f"  [{p['status']:9s}] ID={p['id']:4d}  /{p['slug']:30s}  tpl={p['template']!r:40s}  {p['title']}")


if __name__ == "__main__":
    main()
