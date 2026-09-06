#!/usr/bin/env python3
"""Round-2 intake map 23.8.2026: HTTP + Drive pack + proposed bucket. No PHP."""
from __future__ import annotations

import csv
import subprocess
import urllib.parse
from concurrent.futures import ThreadPoolExecutor, as_completed
from pathlib import Path

REPO = Path(__file__).resolve().parent.parent
TRACKER = REPO / "_COMMUNICATION/team_100/S006/tracker/latest.csv"
DRIVE = REPO / "EyalAmit_Site_GoogleDrive_Sync/content 13.8.26"
OUT = REPO / "_COMMUNICATION/team_100/S006/tracker/R2-INTAKE-MAP-2026-08-23.csv"
BASE = "http://eyalamit-co-il-2026.s887.upress.link"

# Round-1 submitted canonical paths (trailing slash except menu-only).
R1_SUBMITTED = {
    "/",
    "/treatment/",
    "/method/",
    "/lessons/",
    "/sound-healing/",
    "/learning/lectures/",
    "/learning/workshops/",
    "/shop/",
    "/repair/",
    "/didgeridoos/",
    "/bags/",
    "/stands-storage/",
    "/stand-floor/",
    "/books/",
    "/books/kushi-blantis/",
    "/books/tsva-bekahol/",
    "/books/vekatavta/",
    "/eyal-amit/",
    "/eyal-amit/mokesh-dahiman/",
    "/contact/",
    "/faq/",
    "/testimonials/",
    "/snoring-sleep-apnea/",
}
R1_FROZEN = {
    "/learning/",
    "/learning/therapist-training/",
    "/blog/",
    "/en/",
    "/galleries/",
}

# Path prefix → Drive folder name under content 13.8.26 (exact folder names).
PACK_BY_PREFIX: list[tuple[str, str]] = [
    ("/about/moksha/", "מוקש - דף הנחצחה לזרכו ופועלו"),
    ("/about/", "אודות - אייל עמית"),
    ("/eyal-amit/mokesh-dahiman/", "מוקש - דף הנחצחה לזרכו ופועלו"),
    ("/eyal-amit/", "אודות - אייל עמית"),
]


def drive_folders() -> set[str]:
    if not DRIVE.is_dir():
        return set()
    return {p.name for p in DRIVE.iterdir() if p.is_dir()}


def pack_for(path: str, kind: str, folders: set[str]) -> str:
    if kind in ("פוסט", "QR", "legacy/301"):
        return "אין"
    for prefix, folder in PACK_BY_PREFIX:
        if path.startswith(prefix) and folder in folders:
            return folder
    return "אין"


def path_of(url: str) -> str:
    u = (url or "").replace(BASE, "")
    if not u:
        return "/"
    if "?" in u:
        u = u.split("?", 1)[0]
    if not u.startswith("/"):
        u = "/" + u
    if not u.endswith("/") and "." not in u.rsplit("/", 1)[-1]:
        u += "/"
    return u


def http_probe(path: str) -> tuple[str, str, str]:
    if not path.startswith("/"):
        return "n/a", "n/a", ""
    url = BASE + path
    first_cmd = [
        "curl", "-sS", "-o", "/dev/null", "-I",
        "-w", "%{http_code}",
        "--max-time", "20",
        url,
    ]
    follow_cmd = [
        "curl", "-sS", "-o", "/dev/null", "-L", "--max-redirs", "5",
        "-w", "%{http_code} %{url_effective}",
        "--max-time", "25",
        url,
    ]
    try:
        first = subprocess.check_output(first_cmd, text=True, stderr=subprocess.DEVNULL).strip()
    except subprocess.CalledProcessError:
        first = "err"
    try:
        followed = subprocess.check_output(follow_cmd, text=True, stderr=subprocess.DEVNULL).strip()
        parts = followed.split(" ", 1)
        final = parts[0]
        final_url = parts[1] if len(parts) > 1 else url
    except subprocess.CalledProcessError:
        final, final_url = "err", url
    return first, final, final_url


def overlap_he(path: str, kind: str, final_path: str) -> str:
    bits = []
    if path in {"/about/", "/about/moksha/"}:
        bits.append("כפילות אפשרית מול אייל עמית / מוקש דהימן בסבב 1")
    if path.startswith("/tools-and-accessories/"):
        bits.append("כפילות אפשרית מול חנות / כלים / תיקון בסבב 1")
    if path == "/learning/courses-external/":
        bits.append("פריט תפריט קורסים בסבב 1 מוקפא ומפנה ל-#")
    if kind == "legacy/301":
        if final_path in R1_SUBMITTED:
            bits.append("יעד 301 הוא עמוד שהוגש בסבב 1")
        elif final_path in R1_FROZEN:
            bits.append("יעד 301 הוא עמוד מוקפא בסבב 1")
        elif final_path.startswith("/learning/courses-external"):
            bits.append("יעד 301 הוא עמוד סבב 2 בלי חבילה")
    if path == "/blog/" or kind == "פוסט":
        bits.append("ארכיון הבלוג מוקפא בסבב 1; הפוסטים עצמם סבב 2")
    return " · ".join(bits)


def bucket(
    *,
    kind: str,
    path: str,
    pack: str,
    first: str,
    final: str,
    final_path: str,
) -> tuple[str, str]:
    """Return (דלי, נימוק). Proposed only — not written to tracker."""
    if kind == "legacy/301":
        if first.startswith("301") and final.startswith("200") and final_path in R1_SUBMITTED:
            return (
                "ברור",
                "הטרקר מגדיר פעולה אחת: אימות יעד 301 בלי עריכת תוכן. "
                "החי מפנה לעמוד שהוגש בסבב 1.",
            )
        if first.startswith("301") and final.startswith("200"):
            return (
                "נימרוד",
                "ה-301 חי, אך היעד אינו עמוד שהוגש בסבב 1 — צריך הכרעה אם זה מספיק.",
            )
        return "נימרוד", f"ה-301 לא נקי (ראשון={first} סופי={final} יעד={final_path})"
    if path in {"/about/", "/about/moksha/"}:
        return "נימרוד", "חבילת דרייב משותפת עם עמודי סבב 1 — כפילות נתיבים, לא בייטים להדבקה."
    if path.startswith("/tools-and-accessories/"):
        return "נימרוד", "אין חבילת סבב 2; חפיפה אפשרית לחנות/תיקון שכבר הוגשו."
    if kind == "פוסט":
        return "הקפאה", "אין חבילה ואין סקירה. החי נשאר ארכיון עד הכרעה. לא 54 שאלות לאייל."
    if kind == "QR":
        return "הקפאה", "אין חבילה ואין סקירה. דפי QR חיים; לא ממציאים עותק Hub."
    if pack == "אין":
        return "הקפאה", "אין תיקייה ב-content 13.8.26 ואין קובץ סקירה. בלי מקור לא מדביקים."
    return "נימרוד", "יש תיקייה בדרייב אך אין ציטוט תא/סקשן — נעילת ברור לא מתקיימת."


def main() -> int:
    folders = drive_folders()
    rows = list(csv.DictReader(TRACKER.open(encoding="utf-8-sig")))
    r2 = [r for r in rows if (r.get("__sheet__") or "") == "סבב-2"]
    print(f"Round-2 rows: {len(r2)}; Drive folders: {len(folders)}", flush=True)

    jobs = {}
    with ThreadPoolExecutor(max_workers=8) as pool:
        for r in r2:
            path = (r.get("נתיב") or "").strip()
            jobs[pool.submit(http_probe, path)] = r

        probes: dict[str, tuple[str, str, str]] = {}
        done = 0
        for fut in as_completed(jobs):
            r = jobs[fut]
            path = (r.get("נתיב") or "").strip()
            probes[path] = fut.result()
            done += 1
            if done % 20 == 0 or done == len(r2):
                print(f"HTTP {done}/{len(r2)}", flush=True)

    out_rows = []
    for r in r2:
        path = (r.get("נתיב") or "").strip()
        kind = (r.get("סוג") or "").strip()
        title = (r.get("כותרת") or "").strip()
        pack = pack_for(path, kind, folders)
        first, final, final_url = probes[path]
        final_path = path_of(final_url)
        decoded = urllib.parse.unquote(path)
        bkt, why = bucket(
            kind=kind,
            path=path,
            pack=pack,
            first=first,
            final=final,
            final_path=final_path,
        )
        ov = overlap_he(path, kind, final_path)
        out_rows.append({
            "מזהה": r.get("#") or "",
            "שם_עמוד": title,
            "נתיב": path,
            "נתיב_decoded": decoded,
            "סוג": kind,
            "HTTP_ראשון": first,
            "HTTP_סופי": final,
            "נתיב_סופי": final_path,
            "URL_סופי": final_url,
            "חבילה_דרייב": pack,
            "חפיפה_סבב1": ov,
            "דלי_מוצע": bkt,
            "נימוק": why,
        })

    fields = list(out_rows[0].keys())
    with OUT.open("w", encoding="utf-8", newline="") as f:
        w = csv.DictWriter(f, fieldnames=fields)
        w.writeheader()
        w.writerows(out_rows)

    from collections import Counter
    c = Counter(x["דלי_מוצע"] for x in out_rows)
    kinds = Counter(x["סוג"] for x in out_rows)
    print(f"Wrote {len(out_rows)} → {OUT}")
    print("kinds", dict(kinds))
    print("buckets", dict(c))
    bad = [x for x in out_rows if x["HTTP_ראשון"] in ("err", "000", "") or x["HTTP_סופי"] in ("err", "000", "")]
    print(f"http_errors={len(bad)}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
