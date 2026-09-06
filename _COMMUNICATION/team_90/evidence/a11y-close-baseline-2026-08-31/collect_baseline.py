#!/usr/bin/env python3
import json
import sys
import time
import urllib.request
from dataclasses import dataclass, asdict
from html import unescape
from html.parser import HTMLParser
from typing import Optional


BASE = "http://eyalamit-co-il-2026.s887.upress.link"

PAGES = [
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


def _norm_text(s: str) -> str:
    return " ".join(unescape(s).split()).strip()


def _class_contains(attrs: dict, needle: str) -> bool:
    cls = attrs.get("class", "") or ""
    return needle in cls.split() or needle in cls


@dataclass
class PageBaseline:
    path: str
    http_status: int
    title: str
    h1: str
    skip_link_count: int
    main_id: str
    primary_cta_href: str
    unlabeled_img_count: int
    forms_count: int


class BaselineHTMLParser(HTMLParser):
    def __init__(self, *, count_forms: bool):
        super().__init__(convert_charrefs=True)
        self.count_forms = count_forms

        self._in_title = False
        self._in_h1 = False
        self._title_chunks: list[str] = []
        self._h1_chunks: list[str] = []

        self.title: str = ""
        self.h1: str = ""
        self.skip_link_count = 0
        self.main_id: str = ""
        self.primary_cta_href: str = ""
        self.unlabeled_img_count = 0
        self.forms_count = 0

    def handle_starttag(self, tag, attrs_list):
        tag = (tag or "").lower()
        attrs = {k.lower(): (v or "") for (k, v) in (attrs_list or []) if k}

        if tag == "title":
            self._in_title = True
            return

        if tag == "h1" and not self.h1:
            self._in_h1 = True
            return

        if tag == "a":
            if _class_contains(attrs, "ea-skiplink") or _class_contains(attrs, "ea-skip-link"):
                self.skip_link_count += 1

            if not self.primary_cta_href:
                if _class_contains(attrs, "ea-cta-pill--primary") or _class_contains(attrs, "hero__cta") or _class_contains(attrs, "hero__cta"):
                    href = attrs.get("href", "") or ""
                    self.primary_cta_href = href.strip()

            return

        if tag == "main" and not self.main_id:
            self.main_id = (attrs.get("id", "") or "").strip()
            return

        if tag == "img":
            if "alt" not in attrs:
                self.unlabeled_img_count += 1
            return

        if tag == "form" and self.count_forms:
            self.forms_count += 1
            return

    def handle_endtag(self, tag):
        tag = (tag or "").lower()
        if tag == "title" and self._in_title:
            self._in_title = False
            if not self.title:
                self.title = _norm_text("".join(self._title_chunks))
            return

        if tag == "h1" and self._in_h1:
            self._in_h1 = False
            if not self.h1:
                self.h1 = _norm_text("".join(self._h1_chunks))
            return

    def handle_data(self, data):
        if not data:
            return
        if self._in_title:
            self._title_chunks.append(data)
        if self._in_h1:
            self._h1_chunks.append(data)


def fetch(url: str) -> tuple[int, str]:
    req = urllib.request.Request(
        url,
        headers={
            "User-Agent": "team_90_baseline/2026-08-31 (+AOS validator)",
            "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        },
        method="GET",
    )
    with urllib.request.urlopen(req, timeout=20) as resp:
        status = getattr(resp, "status", 0) or 0
        raw = resp.read()
        # Prefer declared encoding if present.
        ctype = resp.headers.get("content-type", "")
        enc = "utf-8"
        if "charset=" in ctype:
            enc = ctype.split("charset=")[-1].split(";")[0].strip() or "utf-8"
        try:
            html = raw.decode(enc, errors="replace")
        except Exception:
            html = raw.decode("utf-8", errors="replace")
        return status, html


def main() -> int:
    out_dir = "/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-a11y-close/_COMMUNICATION/team_90/evidence/a11y-close-baseline-2026-08-31"
    jsonl_path = f"{out_dir}/baseline.jsonl"
    summary_path = f"{out_dir}/BASELINE-SUMMARY-2026-08-31.md"

    rows: list[PageBaseline] = []

    for path in PAGES:
        url = f"{BASE}{path}"
        try:
            status, html = fetch(url)
        except Exception as e:
            rows.append(
                PageBaseline(
                    path=path,
                    http_status=0,
                    title="",
                    h1="",
                    skip_link_count=0,
                    main_id="",
                    primary_cta_href="",
                    unlabeled_img_count=0,
                    forms_count=0,
                )
            )
            print(f"[WARN] fetch failed {path}: {e}", file=sys.stderr)
            continue

        parser = BaselineHTMLParser(count_forms=(path == "/contact/"))
        try:
            parser.feed(html)
            parser.close()
        except Exception as e:
            print(f"[WARN] parse failed {path}: {e}", file=sys.stderr)

        rows.append(
            PageBaseline(
                path=path,
                http_status=status,
                title=_norm_text(parser.title),
                h1=_norm_text(parser.h1),
                skip_link_count=int(parser.skip_link_count),
                main_id=(parser.main_id or "").strip(),
                primary_cta_href=(parser.primary_cta_href or "").strip(),
                unlabeled_img_count=int(parser.unlabeled_img_count),
                forms_count=int(parser.forms_count),
            )
        )

        # Be polite to the host.
        time.sleep(0.15)

    # Write JSONL
    with open(jsonl_path, "w", encoding="utf-8") as f:
        for r in rows:
            f.write(json.dumps(asdict(r), ensure_ascii=False) + "\n")

    # Write summary MD
    ts = time.strftime("%Y-%m-%dT%H:%M:%S%z")
    with open(summary_path, "w", encoding="utf-8") as f:
        f.write("# A11Y Close — Baseline Summary (2026-08-31)\n\n")
        f.write(f"- Base: `{BASE}`\n")
        f.write(f"- Generated: `{ts}`\n\n")
        f.write("| URL | H1 | Skip links | main#id |\n")
        f.write("|---|---|---:|---|\n")
        for r in rows:
            url = f"{BASE}{r.path}"
            h1 = r.h1.replace("|", "\\|")
            main_id = r.main_id.replace("|", "\\|")
            f.write(f"| `{url}` | {h1} | {r.skip_link_count} | `{main_id}` |\n")

        f.write("\n## Non-200 HTTP\n\n")
        non_200 = [r for r in rows if r.http_status != 200]
        if not non_200:
            f.write("- None\n")
        else:
            for r in non_200:
                f.write(f"- `{BASE}{r.path}` → **{r.http_status}**\n")

        f.write("\n## /contact/ forms count\n\n")
        contact = next((r for r in rows if r.path == "/contact/"), None)
        if contact is None:
            f.write("- /contact/ not fetched\n")
        else:
            f.write(f"- `{BASE}/contact/` → **{contact.forms_count}** `<form>` elements\n")

    print(jsonl_path)
    print(summary_path)
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
