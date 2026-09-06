#!/usr/bin/env python3
import json
import os
import re
import sys
import urllib.request
from html import unescape


BASE = "http://eyalamit-co-il-2026.s887.upress.link"
NOCACHE = "nocache=20260831w1"

R1_PATHS = [
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
]

EXTRA_PATHS = [
    "/en/",
]


def normalize_ws(s: str) -> str:
    return " ".join(s.split()).strip()


def strip_tags(html_fragment: str) -> str:
    txt = re.sub(r"<[^>]+>", " ", html_fragment, flags=re.S)
    return normalize_ws(unescape(txt))


def extract_first_tag_text(html: str, tag: str) -> str:
    m = re.search(rf"<{tag}\b[^>]*>(.*?)</{tag}>", html, flags=re.I | re.S)
    return strip_tags(m.group(1)) if m else ""


def extract_skiplinks(html: str):
    # returns list of dicts {href, label}
    out = []
    for m in re.finditer(
        r'(<a\b[^>]*class=["\'][^"\']*\bea-skiplink\b[^"\']*["\'][^>]*>)(.*?)</a>',
        html,
        flags=re.I | re.S,
    ):
        open_tag, inner = m.group(1), m.group(2)
        href_m = re.search(r'href=["\']([^"\']+)["\']', open_tag, flags=re.I)
        href = href_m.group(1) if href_m else ""
        label = strip_tags(inner)
        out.append({"href": href, "label": label})
    return out


def has_main_id_main(html: str) -> bool:
    return bool(re.search(r'<main\b[^>]*\bid=["\']main["\']', html, flags=re.I))


def count_forms(html: str) -> int:
    return len(re.findall(r"<form\b", html, flags=re.I))


def has_id(html: str, element_id: str) -> bool:
    return bool(re.search(rf'\bid=["\']{re.escape(element_id)}["\']', html, flags=re.I))


def footer_title_counts(html: str):
    p_count = len(
        re.findall(
            r'<p\b[^>]*class=["\'][^"\']*\bfoot__col-title\b[^"\']*["\']',
            html,
            flags=re.I,
        )
    )
    h4_count = len(
        re.findall(
            r'<h4\b[^>]*class=["\'][^"\']*\bfoot__col-title\b[^"\']*["\']',
            html,
            flags=re.I,
        )
    )
    return {"p": p_count, "h4": h4_count}


def build_url(path: str) -> str:
    if not path.startswith("/"):
        path = "/" + path
    sep = "&" if "?" in path else "?"
    return f"{BASE}{path}{sep}{NOCACHE}"


def fetch_html(path: str, timeout_s: int = 30):
    url = build_url(path)
    req = urllib.request.Request(
        url,
        headers={
            "User-Agent": "team90-validator/1.0 (+a11y-close-w1)",
            "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Encoding": "identity",
            "Cache-Control": "no-cache",
            "Pragma": "no-cache",
        },
        method="GET",
    )
    try:
        with urllib.request.urlopen(req, timeout=timeout_s) as resp:
            status = resp.getcode()
            body_bytes = resp.read()
            try:
                body = body_bytes.decode("utf-8", errors="replace")
            except Exception:
                body = body_bytes.decode(errors="replace")
            return {"url": url, "http_status": status, "html": body}
    except Exception as e:
        return {"url": url, "http_status": 0, "error": str(e), "html": ""}


def load_baseline_map(baseline_jsonl_path: str):
    m = {}
    with open(baseline_jsonl_path, "r", encoding="utf-8") as f:
        for line in f:
            line = line.strip()
            if not line:
                continue
            obj = json.loads(line)
            m[obj["path"]] = obj
    return m


def main():
    if len(sys.argv) < 2:
        print("Usage: collect_w1.py /abs/path/to/baseline.jsonl", file=sys.stderr)
        return 2

    baseline_path = sys.argv[1]
    baseline = load_baseline_map(baseline_path)

    all_paths = R1_PATHS + EXTRA_PATHS
    results = []

    for path in all_paths:
        fetched = fetch_html(path)
        html = fetched.get("html", "")

        h1 = extract_first_tag_text(html, "h1")
        skiplinks = extract_skiplinks(html)
        skip_count = len(skiplinks)
        skip_all_href_main = all(sl.get("href") == "#main" for sl in skiplinks) if skiplinks else False
        main_ok = has_main_id_main(html)

        contact_forms = count_forms(html) if path == "/contact/" else None
        contact_has_ea_cf_name = has_id(html, "ea-cf-name") if path == "/contact/" else None
        contact_has_wpcf7 = ("wpcf7" in html.lower()) if path == "/contact/" else None

        foot_titles = footer_title_counts(html) if path == "/" else None

        baseline_h1 = baseline.get(path, {}).get("h1", "")
        h1_match = (h1 == baseline_h1) if path in R1_PATHS else None

        results.append(
            {
                "path": path,
                "url": fetched.get("url"),
                "http_status": fetched.get("http_status"),
                "h1": h1,
                "baseline_h1": baseline_h1,
                "h1_match_baseline": h1_match,
                "skip_count": skip_count,
                "skip_all_href_main": skip_all_href_main,
                "skiplinks": skiplinks,
                "main_id_main": main_ok,
                "contact_forms_count": contact_forms,
                "contact_has_ea_cf_name": contact_has_ea_cf_name,
                "contact_has_wpcf7": contact_has_wpcf7,
                "footer_titles": foot_titles,
                "error": fetched.get("error", ""),
            }
        )

    print(json.dumps({"base": BASE, "nocache": NOCACHE, "results": results}, ensure_ascii=False, indent=2))
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

