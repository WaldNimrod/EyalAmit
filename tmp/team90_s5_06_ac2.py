#!/usr/bin/env python3
"""team_90 independent AC-2 schema regression check."""
import json
import re
import subprocess
import sys
from pathlib import Path

BASE = "http://eyalamit-co-il-2026.s887.upress.link"
ROUTES = ["qr1", "qr2", "qr10", "qr48"]
EVIDENCE = Path("_COMMUNICATION/team_110/evidence/s5-06/schema-regression")

def count_types(html: str) -> tuple[int, int, str]:
    m = re.search(r'<meta\s+name=["\']description["\']\s+content=["\']([^"\']*)["\']', html, re.I)
    desc = m.group(1) if m else ""
    vo = art = 0
    for block in re.findall(
        r'<script[^>]*type=["\']application/ld\+json["\'][^>]*>(.*?)</script>',
        html,
        re.S | re.I,
    ):
        try:
            data = json.loads(block.strip())
        except json.JSONDecodeError:
            continue
        nodes = data if isinstance(data, list) else data.get("@graph", [data])
        if not isinstance(nodes, list):
            nodes = [nodes]
        for n in nodes:
            t = n.get("@type", "")
            types = t if isinstance(t, list) else [t]
            if "VideoObject" in types:
                vo += 1
            if "Article" in types:
                art += 1
    return vo, art, desc

def main() -> int:
    expected_vo = {"qr1": 0, "qr2": 1, "qr10": 3, "qr48": 0}
    ok = True
    for route in ROUTES:
        url = f"{BASE}/qr/{route}/"
        proc = subprocess.run(
            ["curl", "-sk", "-o", f"/tmp/t90_{route}.html", "-w", "%{http_code}", url],
            capture_output=True,
            text=True,
            timeout=45,
        )
        code = proc.stdout.strip()
        html = Path(f"/tmp/t90_{route}.html").read_text(encoding="utf-8", errors="replace")
        vo, art, desc = count_types(html)
        before_html = (EVIDENCE / f"{route}_BEFORE.html").read_text(encoding="utf-8", errors="replace")
        _, _, before_desc = count_types(before_html)
        desc_match = desc == before_desc and bool(desc.strip())
        vo_ok = vo == expected_vo[route]
        art_ok = art >= 1
        route_ok = code == "200" and vo_ok and art_ok and desc_match
        ok = ok and route_ok
        print(
            f"{route}: HTTP={code} VideoObject={vo}(exp {expected_vo[route]}) "
            f"Article={art} desc_match={desc_match} -> {'PASS' if route_ok else 'FAIL'}"
        )
    return 0 if ok else 1

if __name__ == "__main__":
    sys.exit(main())
