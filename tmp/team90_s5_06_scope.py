#!/usr/bin/env python3
"""team_90 AC-5 scope + version checks."""
import re
import subprocess
from pathlib import Path

BASE = "http://eyalamit-co-il-2026.s887.upress.link"
ROUTES = {
    "/": 0,
    "/method/": 0,
    "/faq/": 0,
    "/repair/": 0,
    "/blog/": 0,
    "/contact/": 0,
    "/qr/qr2/": 1,  # expect facade present
}

def fetch(path: str) -> tuple[str, str]:
    proc = subprocess.run(
        ["curl", "-sk", "-w", "%{http_code}", "-o", "/tmp/t90_scope.html", f"{BASE}{path}"],
        capture_output=True,
        text=True,
        timeout=45,
    )
    return Path("/tmp/t90_scope.html").read_text(encoding="utf-8", errors="replace"), proc.stdout.strip()

style_ver = re.search(
    r"Version:\s*([\d.]+)",
    Path("site/wp-content/themes/ea-eyalamit/style.css").read_text(),
)
print(f"style.css Version: {style_ver.group(1) if style_ver else 'MISSING'}")

for path, expect_facade in ROUTES.items():
    html, code = fetch(path)
    facade = len(re.findall(r"ea-qr-facade", html))
    js = "ea-qr-facade.js" in html
    css = re.search(r"chapters\.css\?ver=([\d.]+)", html)
    js_ver = re.search(r"ea-qr-facade\.js\?ver=([\d.]+)", html)
    ok = (facade > 0) == (expect_facade > 0) and (js == (expect_facade > 0))
    print(
        f"{path} HTTP={code} facade={facade} js_loaded={js} "
        f"chapters.css?ver={css.group(1) if css else 'n/a'} "
        f"ea-qr-facade.js?ver={js_ver.group(1) if js_ver else 'n/a'} -> {'PASS' if ok else 'FAIL'}"
    )
