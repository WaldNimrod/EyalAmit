#!/usr/bin/env python3
"""
סריקה יזומה לקליטת תוכן חדש מאייל.

מריץ סריקה, מעדכן content-index.json, בונה את ה-Hub, ומציג סיכום.
הפעל כאשר אייל מודיע שהעביר חומרים חדשים לתיקיית Drive המשותפת.

Usage (repo root):
  python3 scripts/intake_new_content.py
  python3 scripts/intake_new_content.py --no-build   # רק סריקה, ללא בנייה
  python3 scripts/intake_new_content.py --no-deploy  # בנייה ללא FTP deploy

לאחר הריצה: שלח לאייל וואטסאפ עם רשימת החומרים שנקלטו.
טלפון אייל: 972-524822842
"""
from __future__ import annotations

import argparse
import json
import subprocess
import sys
from datetime import datetime, timezone
from pathlib import Path

REPO_ROOT = Path(__file__).resolve().parent.parent
INDEX_PATH = REPO_ROOT / "hub/data/content-index.json"
SCAN_SCRIPT = REPO_ROOT / "scripts/scan_eyal_content_index.py"
BUILD_SCRIPT = REPO_ROOT / "scripts/build_eyal_client_hub.py"
DEPLOY_SCRIPT = REPO_ROOT / "scripts/ftp_publish_eyal_client_hub.py"

EYAL_PHONE = "972-524822842"


def load_index() -> dict:
    with open(INDEX_PATH, encoding="utf-8") as f:
        return json.load(f)


def run(cmd: list[str], label: str) -> int:
    print(f"\n{'='*50}")
    print(f"[RUN] {label}")
    print(f"{'='*50}")
    result = subprocess.run(cmd, cwd=REPO_ROOT)
    return result.returncode


def main() -> None:
    ap = argparse.ArgumentParser(description="סריקה יזומה לקליטת תוכן חדש מאייל")
    ap.add_argument("--no-build", action="store_true", help="רק סריקה, ללא בנייה")
    ap.add_argument("--no-deploy", action="store_true", help="בנייה ללא FTP deploy")
    args = ap.parse_args()

    print(f"\n{'='*50}")
    print(f"  סריקת תוכן חדש מאייל — {datetime.now(timezone.utc).strftime('%Y-%m-%d %H:%M UTC')}")
    print(f"{'='*50}\n")

    # Load index before scan (to detect what changed)
    old_index = load_index() if INDEX_PATH.exists() else {}
    old_items = {item["id"]: item.get("status") for item in old_index.get("items", [])}

    # Run scanner
    rc = run([sys.executable, str(SCAN_SCRIPT)], "סורק תוכן")
    if rc != 0:
        print(f"[ERROR] הסריקה נכשלה (exit {rc})", file=sys.stderr)
        sys.exit(rc)

    # Load updated index
    new_index = load_index()
    new_items = {item["id"]: item for item in new_index.get("items", [])}

    # Find what changed
    truly_new = [item for iid, item in new_items.items() if iid not in old_items]
    status_changed = [
        item for iid, item in new_items.items()
        if iid in old_items and old_items[iid] != item.get("status")
    ]

    # Build
    if not args.no_build:
        rc = run([sys.executable, str(BUILD_SCRIPT)], "בנייה")
        if rc != 0:
            print(f"[ERROR] הבנייה נכשלה (exit {rc})", file=sys.stderr)
            sys.exit(rc)

    # Deploy
    if not args.no_build and not args.no_deploy:
        rc = run([sys.executable, str(DEPLOY_SCRIPT)], "פרסום ל-staging")
        if rc != 0:
            print(f"[WARN] הפרסום נכשל (exit {rc}) — ניתן להריץ ידנית", file=sys.stderr)

    # Summary
    print(f"\n{'='*50}")
    print("  סיכום קליטה")
    print(f"{'='*50}")

    if not truly_new and not status_changed:
        print("לא נמצאו חומרים חדשים או עדכונים.")
    else:
        if truly_new:
            print(f"\nחומרים חדשים ({len(truly_new)}):")
            for item in truly_new:
                print(f"  + {item.get('titleHe', item.get('id'))}")
        if status_changed:
            print(f"\nעדכוני סטטוס ({len(status_changed)}):")
            for item in status_changed:
                old = old_items.get(item["id"], "?")
                new = item.get("status", "?")
                print(f"  ~ {item.get('titleHe', item.get('id'))}  [{old} → {new}]")

    # WhatsApp template
    if truly_new or status_changed:
        print(f"\n{'='*50}")
        print(f"  תבנית וואטסאפ לאייל  ({EYAL_PHONE})")
        print(f"{'='*50}")
        lines = ["היי אייל,"]
        lines.append("קלטנו את החומרים הבאים:")
        lines.append("")
        for item in truly_new:
            lines.append(f"✓ {item.get('titleHe', item.get('id'))}")
        for item in status_changed:
            lines.append(f"✓ {item.get('titleHe', item.get('id'))}")
        lines.append("")
        lines.append("תודה!")
        print("\n".join(lines))
    else:
        print(f"\nלא נדרשת הודעה לאייל.")


if __name__ == "__main__":
    main()
