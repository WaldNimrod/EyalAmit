#!/usr/bin/env python3
"""Check relative href/src targets in hub/dist HTML exist on disk.

Usage:
    python3 scripts/hub_check_dist_links.py [path_to_dist]
Default dist path: hub/dist

Skips: mailto:, javascript:, data:, and absolute http(s) URLs.
Exit 1 if any missing file; 0 if OK.
"""

from __future__ import annotations

import re
import sys
from pathlib import Path
from urllib.parse import unquote

ATTR_RE = re.compile(
    r'(?:href|src)\s*=\s*["\']([^"\']+)["\']',
    re.IGNORECASE,
)


def collect_refs(html: str) -> set[str]:
    return {m.group(1).strip() for m in ATTR_RE.finditer(html)}


def resolve(dist_root: Path, html_path: Path, ref: str) -> Path | None:
    ref = ref.split("#", 1)[0].split("?", 1)[0].strip()
    if not ref or ref.startswith(
        ("http://", "https://", "mailto:", "javascript:", "data:", "tel:", "sms:")
    ):
        return None
    ref = unquote(ref)
    # Relative to current HTML file's directory
    target = (html_path.parent / ref).resolve()
    try:
        target.relative_to(dist_root.resolve())
    except ValueError:
        return None  # outside dist — skip (e.g. odd edge case)
    return target


def main() -> int:
    root = Path(__file__).resolve().parent.parent
    dist = root / "hub" / "dist"
    if len(sys.argv) > 1:
        dist = Path(sys.argv[1]).resolve()
    if not dist.is_dir():
        print(f"[hub_check_dist_links] FAIL: not a directory: {dist}", file=sys.stderr)
        return 1

    missing: list[tuple[str, str]] = []
    for html_path in sorted(dist.rglob("*.html")):
        text = html_path.read_text(encoding="utf-8", errors="replace")
        for ref in collect_refs(text):
            target = resolve(dist, html_path, ref)
            if target is None:
                continue
            if not target.exists():
                rel = html_path.relative_to(dist)
                missing.append((str(rel), ref))

    if missing:
        print("[hub_check_dist_links] FAIL — missing targets:", file=sys.stderr)
        for page, ref in missing:
            print(f"  {page} -> {ref}", file=sys.stderr)
        return 1
    print(f"[hub_check_dist_links] OK — scanned {dist}")
    return 0


if __name__ == "__main__":
    sys.exit(main())
