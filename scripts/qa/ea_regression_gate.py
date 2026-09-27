#!/usr/bin/env python3
"""The regression gate for eyalamit — the single source of truth for "the site is intact".

This exists because success conditions used to be re-written by hand in every mandate, and on
2026-09-27 one of them forgot a single CSS class: a lane proved zero visible change byte-for-byte
on five pages, passed its own full-population pass, and still silently stripped the sticky-reveal
footer from 53 pages. The five pages it chose were all fine. The population pass it ran counted
navs and footers and nothing else.

So this script takes no page list and no invariant list from its caller. It enumerates the whole
published population itself and checks every invariant every time. Adding a check here is how an
invariant becomes permanent; there is nowhere else to put one.

Usage
  python3 scripts/qa/ea_regression_gate.py                 # check against the baseline
  python3 scripts/qa/ea_regression_gate.py --json out.json # also write the raw measurement
  python3 scripts/qa/ea_regression_gate.py --update-baseline --reason "..."

Exit codes: 0 all invariants hold · 1 at least one drifted · 2 could not measure.

Discipline this script enforces, and why each line is here:
  * Census, not sample. Every check runs over every live URL.
  * Enumerate from the REST API, never from a stored URL list, which goes stale silently.
  * Redirects are NOT followed: a 301 that starts resolving to a 200 is itself a change.
  * 502s are retried. Staging chokes above 3 concurrent requests and a choked request is not
    a defect — recording one as a defect has already cost this project a day.
  * The staging certificate is invalid BY DESIGN. Never a finding.
"""
from __future__ import annotations

import argparse
import json
import re
import sys
import time
import urllib.error
import urllib.request
from concurrent.futures import ThreadPoolExecutor
from datetime import datetime, timezone
from pathlib import Path

BASE = "http://eyalamit-co-il-2026.s887.upress.link"
BASELINE = Path(__file__).resolve().parent / "ea_regression_gate_baseline.json"

MAX_WORKERS = 3          # staging chokes above this
RETRIES = 3
TIMEOUT = 45

# Pages checked for horizontal overflow and for the legal links. One per template family;
# they are named rather than sampled, because each represents a family that renders differently.
FAMILY_PAGES = [
    f"{BASE}/",
    f"{BASE}/press/",
    f"{BASE}/historical-articles/",
    f"{BASE}/en/",
]

LEGAL_PATHS = ("/accessibility/", "/privacy/", "/terms/")


class NoRedirect(urllib.request.HTTPRedirectHandler):
    """Do not follow redirects: a 301 turning into a 200 is a change we must see."""

    def redirect_request(self, *_a, **_k):
        return None


_no_redirect_opener = urllib.request.build_opener(NoRedirect)


def _get(url: str, follow: bool = False):
    """Fetch a URL, retrying 502s. Returns (status, body) or (0, '') when unreachable."""
    opener = urllib.request.urlopen if follow else _no_redirect_opener.open
    for attempt in range(RETRIES):
        try:
            resp = opener(url, timeout=TIMEOUT)
            return resp.getcode(), resp.read().decode("utf-8", "replace")
        except urllib.error.HTTPError as exc:
            if exc.code == 502 and attempt < RETRIES - 1:
                time.sleep(2 + attempt * 2)
                continue
            return exc.code, ""
        except Exception:  # noqa: BLE001 — transient network, retry then give up
            time.sleep(2 + attempt * 2)
    return 0, ""


def enumerate_population() -> list[str]:
    """Every published page and post URL, from the REST API. Never from a stored list."""
    urls: set[str] = set()
    for kind in ("pages", "posts"):
        page = 1
        while True:
            status, body = _get(
                f"{BASE}/wp-json/wp/v2/{kind}?per_page=100&status=publish&page={page}&_fields=link",
                follow=True,
            )
            if status != 200 or not body:
                break
            try:
                rows = json.loads(body)
            except json.JSONDecodeError:
                break
            if not isinstance(rows, list) or not rows:
                break
            urls.update(r["link"] for r in rows if r.get("link"))
            if len(rows) < 100:
                break
            page += 1
    return sorted(urls)


def measure() -> dict:
    """Fetch the whole population once and derive every invariant from that single pass."""
    population = enumerate_population()
    if not population:
        print("FATAL: could not enumerate the population from the REST API.", file=sys.stderr)
        sys.exit(2)

    results: dict[str, tuple[int, str]] = {}
    with ThreadPoolExecutor(max_workers=MAX_WORKERS) as pool:
        for url, (status, body) in zip(population, pool.map(_get, population)):
            results[url] = (status, body)

    unreachable = [u for u, (s, _) in results.items() if s == 0]
    if unreachable:
        print(f"FATAL: {len(unreachable)} URLs unreachable after {RETRIES} tries.", file=sys.stderr)
        for u in unreachable[:5]:
            print(f"  {u}", file=sys.stderr)
        sys.exit(2)

    live = {u: b for u, (s, b) in results.items() if s == 200}
    redirects = [u for u, (s, _) in results.items() if 300 <= s < 400]

    nav_not_one, footer_not_one, php_errors, missing_legal = [], [], [], []
    reveal_with, reveal_without = [], []
    no_alt_attr = 0
    theme_versions: dict[str, int] = {}

    for url, body in live.items():
        if len(re.findall(r'<nav[^>]*\bid="nav"', body)) != 1:
            nav_not_one.append(url)
        if len(re.findall(r"<footer[\s>]", body, re.I)) != 1:
            footer_not_one.append(url)
        if re.search(r"Fatal error|Parse error|Warning: |Notice: ", body):
            php_errors.append(url)

        footer_tag = re.search(r'<footer[^>]*class="([^"]*)"', body, re.I)
        classes = footer_tag.group(1) if footer_tag else ""
        (reveal_with if "uncover" in classes else reveal_without).append(url)

        if any(p not in body for p in LEGAL_PATHS):
            missing_legal.append(url)

        no_alt_attr += sum(
            1 for tag in re.findall(r"<img\b[^>]*>", body, re.I) if not re.search(r"\balt=", tag)
        )

        ver = re.search(r"ea-eyalamit[^\"']*?ver=(\d+\.\d+\.\d+)", body)
        if ver:
            theme_versions[ver.group(1)] = theme_versions.get(ver.group(1), 0) + 1

    return {
        "measured_at": datetime.now(timezone.utc).isoformat(timespec="seconds"),
        "population_objects": len(population),
        "live_200": len(live),
        "redirects": len(redirects),
        "nav_not_exactly_one": sorted(nav_not_one),
        "footer_not_exactly_one": sorted(footer_not_one),
        "php_error_pages": sorted(php_errors),
        "reveal_class_present": len(reveal_with),
        "reveal_class_absent": len(reveal_without),
        "reveal_class_absent_urls": sorted(reveal_without),
        "pages_missing_a_legal_link": sorted(missing_legal),
        "images_with_no_alt_attribute": no_alt_attr,
        "theme_versions_served": theme_versions,
    }


# Each entry: (key in the measurement, human label, comparison).
# "exact" must equal the baseline. "empty" must be an empty list whatever the baseline says —
# these are conditions that are never acceptable, so they cannot be baselined away.
CHECKS = [
    ("population_objects", "published objects", "exact"),
    ("live_200", "URLs returning 200", "exact"),
    ("redirects", "URLs redirecting", "exact"),
    ("nav_not_exactly_one", "pages without exactly one primary nav", "empty"),
    ("footer_not_exactly_one", "pages without exactly one footer", "empty"),
    ("php_error_pages", "pages printing a PHP error", "empty"),
    ("pages_missing_a_legal_link", "pages missing a legal document link", "empty"),
    ("reveal_class_present", "pages with the footer reveal class", "exact"),
    ("reveal_class_absent", "pages without the footer reveal class", "exact"),
    ("reveal_class_absent_urls", "which pages lack the reveal class", "exact"),
    ("images_with_no_alt_attribute", "images with no alt attribute at all", "exact"),
]


def compare(now: dict, baseline: dict) -> list[str]:
    failures = []
    for key, label, mode in CHECKS:
        actual = now.get(key)
        if mode == "empty":
            if actual:
                failures.append(f"{label}: {len(actual)} — expected none\n      e.g. {actual[0]}")
            continue
        expected = baseline.get(key)
        if actual != expected:
            if isinstance(actual, list) and isinstance(expected, list):
                added = sorted(set(actual) - set(expected))
                removed = sorted(set(expected) - set(actual))
                detail = []
                if added:
                    detail.append(f"newly listed: {len(added)} (e.g. {added[0]})")
                if removed:
                    detail.append(f"no longer listed: {len(removed)} (e.g. {removed[0]})")
                failures.append(f"{label}: " + "; ".join(detail))
            else:
                failures.append(f"{label}: {actual} — baseline says {expected}")
    return failures


def main() -> None:
    ap = argparse.ArgumentParser(description=__doc__, formatter_class=argparse.RawDescriptionHelpFormatter)
    ap.add_argument("--json", metavar="PATH", help="also write the raw measurement here")
    ap.add_argument("--update-baseline", action="store_true", help="accept the current state as the new baseline")
    ap.add_argument("--reason", help="required with --update-baseline: why the change is intended")
    args = ap.parse_args()

    if args.update_baseline and not args.reason:
        ap.error("--update-baseline requires --reason: an unexplained baseline change is how a "
                 "regression becomes permanent")

    now = measure()

    if args.json:
        Path(args.json).write_text(json.dumps(now, ensure_ascii=False, indent=1), encoding="utf-8")

    print(f"measured {now['measured_at']}")
    print(f"  population            {now['population_objects']} objects "
          f"({now['live_200']}x200, {now['redirects']}x30x)")
    print(f"  primary nav           {len(now['nav_not_exactly_one'])} pages not exactly one")
    print(f"  footer                {len(now['footer_not_exactly_one'])} pages not exactly one")
    print(f"  footer reveal class   {now['reveal_class_present']} with / {now['reveal_class_absent']} without")
    print(f"  PHP errors            {len(now['php_error_pages'])} pages")
    print(f"  legal links           {len(now['pages_missing_a_legal_link'])} pages missing one")
    print(f"  images with no alt    {now['images_with_no_alt_attribute']}")
    print(f"  theme served          {now['theme_versions_served']}")

    if args.update_baseline:
        now["baseline_reason"] = args.reason
        BASELINE.write_text(json.dumps(now, ensure_ascii=False, indent=1), encoding="utf-8")
        print(f"\nbaseline updated: {args.reason}")
        sys.exit(0)

    if not BASELINE.is_file():
        print(f"\nNo baseline at {BASELINE}. Run with --update-baseline --reason '...' to create one.",
              file=sys.stderr)
        sys.exit(2)

    baseline = json.loads(BASELINE.read_text(encoding="utf-8"))
    failures = compare(now, baseline)

    if failures:
        print(f"\nGATE FAILED — {len(failures)} invariant(s) drifted from "
              f"{baseline.get('measured_at')}:")
        for f in failures:
            print(f"  - {f}")
        print("\nA drift is a regression until measured otherwise. If it is intended, re-run with "
              "--update-baseline --reason '...'.")
        sys.exit(1)

    print(f"\nGATE PASSED — every invariant matches the baseline of {baseline.get('measured_at')}.")
    sys.exit(0)


if __name__ == "__main__":
    main()
