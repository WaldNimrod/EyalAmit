#!/usr/bin/env python3
"""GET (no follow) every closed S007 SSOT item; downgrade if live disagrees.

Optional: write checks back onto live.check. Does not invent new closed rows.
"""
from __future__ import annotations

import json
import ssl
import sys
import urllib.error
import urllib.request
from datetime import datetime, timezone
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent))
import s007_work_ssot as S  # noqa: E402

UA = (
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) "
    "AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36"
)
TODAY = "2026-09-21"

# Per-id body/status assertions. Missing keys → HTTP 200 on live.url is enough.
ASSERT = {
    "A4": {"status": 200, "must": ["תודה שפנית אליי", "הפרטים התקבלו ואחזור אליך בהקדם"]},
    "B1": {
        "status": 200,
        "must": ["youtube.com/embed/wDQoJauqsRM"],
        "must_not": ["Lorem ipsum"],
    },
    "C2": {"status": 200},
    "D1": {"status": 200, "must_not": ["ea-testimonials-didg", "כל העדויות"]},
    "D2": {"status": 200},
    "D3": {
        "status": 200,
        "must": ["/learning/therapist-training/"],
        "must_not": ["cbDidg-therapy-training"],
    },
    "E6": {"status": 200, "must": ["תודה שפנית אליי"]},
    "F3": {"status": 200, "must": ["אסתמה"], "must_not": ["אסטמה"]},
    "L1": {"status": 200, "must_not": ["ea-pending-note", "טיוטה לאישור"]},
    "L2": {"status": 200, "must_not": ["ea-pending-note", "טיוטה לאישור"]},
    "L3": {"status": 200, "must_not": ["ea-pending-note", "טיוטה לאישור"]},
    "P016": {"status": 301, "loc_has": "/blog/"},
    "P045": {"status": 301, "loc_has": "/blog/"},
    "DA-P1-01": {"status": 200, "must_not": ["Lorem ipsum"]},
    "WA-SOUND": {"status": 200},
    "WA-A": {"status": 200},
    "WA-B": {"status": 200},
    "M13-ONE-NAV": {"status": 200},
    "TYPO-CANON": {"status": 200},
}


class _NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):  # noqa: ARG002
        return None


def fetch(url: str) -> tuple[int, str, bytes]:
    ctx = ssl._create_unverified_context()
    opener = urllib.request.build_opener(
        urllib.request.HTTPSHandler(context=ctx),
        urllib.request.HTTPHandler(),
        _NoRedirect(),
    )
    req = urllib.request.Request(url, method="GET", headers={"User-Agent": UA, "Accept": "text/html"})
    try:
        with opener.open(req, timeout=25) as resp:
            return resp.status, resp.headers.get("Location") or "", resp.read()
    except urllib.error.HTTPError as e:
        loc = e.headers.get("Location") if e.headers else ""
        body = e.read() if e.fp else b""
        return e.code, loc or "", body


def check_item(it: dict) -> tuple[bool, str]:
    url = (it.get("live") or {}).get("url") or S.live_url(it.get("path") or "/")
    spec = ASSERT.get(it["id"], {"status": 200})
    try:
        code, loc, raw = fetch(url)
    except Exception as e:
        return False, f"GET error {e}"
    want = spec.get("status", 200)
    if code != want:
        return False, f"HTTP {code} want {want} loc={loc[:80]}"
    if spec.get("loc_has"):
        if spec["loc_has"] not in (loc or ""):
            return False, f"Location {loc!r} missing {spec['loc_has']}"
    text = ""
    try:
        text = raw.decode("utf-8", "replace")
    except Exception:
        text = ""
    for needle in spec.get("must") or []:
        if needle not in text:
            return False, f"missing {needle!r} in {url}"
    for needle in spec.get("must_not") or []:
        if needle in text:
            return False, f"found forbidden {needle!r} in {url}"
    loc_bit = f" loc={loc}" if loc else ""
    return True, f"GET {code}{loc_bit} bytes={len(raw)}"


def main() -> int:
    data = json.loads(S.SSOT_PATH.read_text(encoding="utf-8"))
    closed = [it for it in data["items"] if it["status"] == "closed"]
    failed: list[str] = []
    for it in closed:
        ok, msg = check_item(it)
        stamp = f"{TODAY} {msg}"
        it.setdefault("live", {})
        it["live"]["url"] = it["live"].get("url") or S.live_url(it.get("path") or "/")
        it["live"]["date"] = TODAY
        if ok:
            it["live"]["check"] = stamp
            print(f"PASS {it['id']:16} {msg}")
        else:
            it["status"] = "waiting"
            it["waitingOn"] = "nimrod"
            it["live"]["check"] = f"DOWNGRADED {stamp}"
            it["stampHe"] = "ירד מ-closed — האתר לא מאשר"
            failed.append(f"{it['id']}: {msg}")
            print(f"FAIL {it['id']:16} {msg}")
    data["liveValidatedAt"] = datetime.now(timezone.utc).strftime("%Y-%m-%dT%H:%M:%SZ")
    errors = S.validate(data)
    if errors:
        print("schema after validate:", file=sys.stderr)
        print("\n".join(errors[:30]), file=sys.stderr)
        return 2
    S.SSOT_PATH.write_text(json.dumps(data, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")
    print(f"wrote {S.SSOT_PATH} sha12={S.sha12_path(S.SSOT_PATH)}")
    if failed:
        print(f"{len(failed)} closed rows downgraded")
        return 1
    print(f"all {len(closed)} closed rows confirmed on GET")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
