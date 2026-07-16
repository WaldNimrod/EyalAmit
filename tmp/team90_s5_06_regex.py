#!/usr/bin/env python3
"""team_90 check 7: facade regex completeness against seed file."""
import re
from pathlib import Path

seed = Path("site/wp-content/mu-plugins/ea-w2-07-qr-content-data.php").read_text(encoding="utf-8")
pattern = re.compile(
    r'<iframe\b[^>]*\bsrc=(["\'])https?://(?:www\.)?youtube(?:-nocookie)?\.com/embed/([A-Za-z0-9_-]{6,})[^"\']*\1[^>]*>\s*</iframe>',
    re.I,
)
matches = pattern.findall(seed)
ids = [m[1] for m in matches]
link_line = None
for i, line in enumerate(seed.splitlines(), 1):
    if "ea-qr-embed--link" in line:
        link_line = i
        break

print(f"iframe matches: {len(matches)} (expected 60)")
print(f"unique video ids: {len(set(ids))}")
print(f"ea-qr-embed--link at line: {link_line}")
# ensure link line not matched
if link_line:
    link_ctx = seed.splitlines()[link_line - 1]
    print(f"link line matched by regex: {bool(pattern.search(link_ctx))}")
