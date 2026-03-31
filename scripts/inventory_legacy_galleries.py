#!/usr/bin/env python3
"""
Inventory Envira galleries from:
  (A) WordPress WXR export file (Tools → Export) — no DB required
  (B) MySQL — optional PyMySQL

WXR: counts attachments listed as children of each gallery post_id in the export
     (best-effort; Envira may also store images only in postmeta — then use MySQL).

Examples:
  python3 scripts/inventory_legacy_galleries.py
  python3 scripts/inventory_legacy_galleries.py --wxr-export ~/Downloads/eyalamit.WordPress.xml --csv-out galleries.csv
  python3 scripts/inventory_legacy_galleries.py --host 127.0.0.1 --user wp --password x --database wordpress --csv-out out.csv
"""

from __future__ import annotations

import argparse
import csv
import re
import sys
import xml.etree.ElementTree as ET
from typing import Any

SHORTCODE_ENVIRA = re.compile(
    r"\[envira[-_]gallery[^\]]*id=[\"']?(\d+)[\"']?", re.IGNORECASE
)


def _local_tag(tag: str) -> str:
    if "}" in tag:
        return tag.rsplit("}", 1)[-1]
    return tag


def _item_wp_fields(item: ET.Element) -> dict[str, str]:
    out: dict[str, str] = {}
    title_el = item.find("title")
    if title_el is not None and title_el.text:
        out["rss_title"] = title_el.text.strip()
    for child in item:
        lt = _local_tag(child.tag)
        if lt in (
            "post_id",
            "post_type",
            "post_name",
            "status",
            "post_parent",
        ):
            out[lt] = (child.text or "").strip()
    return out


def _item_content_encoded(item: ET.Element) -> str:
    for child in item:
        if _local_tag(child.tag) == "encoded":
            return child.text or ""
    return ""


def parse_wxr(path: str) -> tuple[list[dict[str, Any]], dict[str, int], dict[str, list[str]]]:
    tree = ET.parse(path)
    root = tree.getroot()
    attachments_by_parent: dict[str, int] = {}
    galleries: list[dict[str, Any]] = []
    usage: dict[str, list[str]] = {}

    for item in root.findall(".//item"):
        fields = _item_wp_fields(item)
        pt = fields.get("post_type", "")
        pid = fields.get("post_id", "")
        body = _item_content_encoded(item)
        title = fields.get("rss_title") or ""

        if pt == "attachment" and pid:
            parent = fields.get("post_parent", "")
            if parent.isdigit():
                attachments_by_parent[parent] = attachments_by_parent.get(parent, 0) + 1

        if pt and body:
            label = f"{title} ({pt})" if title else f"({pt})"
            for m in SHORTCODE_ENVIRA.finditer(body):
                gid = m.group(1)
                usage.setdefault(gid, []).append(label)

        if pt == "envira" or (pt.startswith("envira_")):
            galleries.append(
                {
                    "gallery_id": pid,
                    "title": title,
                    "slug": fields.get("post_name", ""),
                    "status": fields.get("status", ""),
                }
            )

    return galleries, attachments_by_parent, usage


def run_wxr(wxr_path: str, csv_out: str) -> int:
    try:
        galleries, att_by_parent, usage = parse_wxr(wxr_path)
    except ET.ParseError as e:
        print(f"שגיאת XML: {e}", file=sys.stderr)
        return 1

    rows = []
    for g in galleries:
        gid = g["gallery_id"]
        att_n = att_by_parent.get(gid, 0)
        use_list = usage.get(gid, [])
        rows.append(
            {
                "gallery_id": gid,
                "title": g.get("title", ""),
                "slug": g.get("slug", ""),
                "status": g.get("status", ""),
                "image_count_attachments_in_export": str(att_n) if att_n else "0",
                "image_count_note": "אם 0 — ייתכן שתמונות רק ב־postmeta; בדקו ב־MySQL או בממשק Envira",
                "usage_pages": "; ".join(use_list[:12]) + ("; …" if len(use_list) > 12 else ""),
                "seo_note": "",
                "under_150_cap": "",
            }
        )

    # orphan shortcodes (gallery id in content but not in gallery list)
    known = {r["gallery_id"] for r in rows}
    for gid, refs in usage.items():
        if gid not in known:
            rows.append(
                {
                    "gallery_id": gid,
                    "title": "[מזהה מקוד קצר — לא נמצא פוסט envira ביצוא]",
                    "slug": "",
                    "status": "",
                    "image_count_attachments_in_export": "",
                    "image_count_note": "לוודא ב־DB",
                    "usage_pages": "; ".join(refs[:8]),
                    "seo_note": "קצרקוד בלי גלריה בקובץ היצוא",
                    "under_150_cap": "",
                }
            )

    rows.sort(key=lambda x: (x["title"] or x["gallery_id"]).lower())

    fieldnames = [
        "gallery_id",
        "title",
        "slug",
        "status",
        "image_count_attachments_in_export",
        "image_count_note",
        "usage_pages",
        "seo_note",
        "under_150_cap",
    ]

    if csv_out:
        with open(csv_out, "w", newline="", encoding="utf-8-sig") as f:
            w = csv.DictWriter(f, fieldnames=fieldnames)
            w.writeheader()
            w.writerows(rows)
        print(f"נכתב {csv_out} — {len(rows)} שורות (מ־WXR).")
    else:
        for row in rows:
            print(row)

    print(
        f"סה״כ גלריות מזוהות (post_type envira*): {len(galleries)}; "
        f"מזהים עם קצרקוד בשימוש: {len(usage)}"
    )
    return 0


def print_instructions() -> None:
    print(
        """
--- א. יצוא WordPress (ללא DB) ---
בממשק: כלים → ייצוא → הכל → הורדת XML.
הריצו:
  python3 scripts/inventory_legacy_galleries.py --wxr-export /path/to/export.xml --csv-out galleries-inventory.csv

--- ב. MySQL (מדויק יותר למטא Envira) ---

SELECT DISTINCT post_type FROM wp_posts WHERE post_type LIKE '%envira%' LIMIT 20;

SELECT ID, post_title, post_name, post_status, post_date
FROM wp_posts
WHERE post_type = 'envira' AND post_status IN ('publish', 'draft', 'private')
ORDER BY post_title;

SELECT post_id, meta_key, LENGTH(meta_value) AS meta_len
FROM wp_postmeta
WHERE meta_key LIKE '%envira%' OR meta_key LIKE '%eg_%'
LIMIT 50;

העתיקו לטבלה ב-GALLERY-INVENTORY-REPORT או:
  python3 scripts/inventory_legacy_galleries.py --host ... --csv-out out.csv
""".strip()
    )


def try_mysql_inventory(args: argparse.Namespace) -> int:
    try:
        import pymysql  # type: ignore
    except ImportError:
        print("PyMySQL לא מותקן. התקינו: pip install pymysql", file=sys.stderr)
        print_instructions()
        return 1

    prefix = args.prefix
    posts = f"{prefix}posts"
    postmeta = f"{prefix}postmeta"

    conn = pymysql.connect(
        host=args.host,
        user=args.user,
        password=args.password,
        database=args.database,
        charset="utf8mb4",
        cursorclass=pymysql.cursors.DictCursor,
    )
    try:
        with conn.cursor() as cur:
            cur.execute(
                f"""
                SELECT ID, post_title, post_name, post_status
                FROM `{posts}`
                WHERE post_type = %s AND post_status IN ('publish', 'draft', 'private')
                ORDER BY post_title
                """,
                (args.post_type,),
            )
            rows: list[dict[str, Any]] = list(cur.fetchall())

        out_rows = []
        for r in rows:
            pid = r["ID"]
            img_guess = ""
            with conn.cursor() as cur:
                cur.execute(
                    f"""
                    SELECT meta_value FROM `{postmeta}`
                    WHERE post_id = %s AND meta_key IN ('_eg_gallery_data', '_eg_in_gallery')
                    LIMIT 5
                    """,
                    (pid,),
                )
                metas = cur.fetchall()
            for m in metas:
                val = m.get("meta_value") or ""
                if isinstance(val, bytes):
                    val = val.decode("utf-8", errors="replace")
                img_guess = str(val.count('"id"') + val.count("i:"))
                if img_guess != "0":
                    break
            out_rows.append(
                {
                    "gallery_id": pid,
                    "title": r.get("post_title") or "",
                    "slug": r.get("post_name") or "",
                    "status": r.get("post_status") or "",
                    "image_count_guess": img_guess or "—",
                    "usage_pages": "",
                    "seo_note": "",
                    "under_150_cap": "",
                }
            )

        if args.csv_out:
            with open(args.csv_out, "w", newline="", encoding="utf-8-sig") as f:
                w = csv.DictWriter(
                    f,
                    fieldnames=[
                        "gallery_id",
                        "title",
                        "slug",
                        "status",
                        "image_count_guess",
                        "usage_pages",
                        "seo_note",
                        "under_150_cap",
                    ],
                )
                w.writeheader()
                w.writerows(out_rows)
            print(f"נכתב {args.csv_out} ({len(out_rows)} שורות).")
        else:
            for row in out_rows:
                print(row)
    finally:
        conn.close()
    return 0


def main() -> int:
    p = argparse.ArgumentParser(description="Envira gallery inventory helper")
    p.add_argument("--wxr-export", default="", help="נתיב לקובץ יצוא WordPress (.xml)")
    p.add_argument("--host", default="", help="MySQL host")
    p.add_argument("--user", default="", help="MySQL user")
    p.add_argument("--password", default="", help="MySQL password")
    p.add_argument("--database", default="", help="שם מסד")
    p.add_argument("--prefix", default="wp_", help="קידומת טבלאות")
    p.add_argument("--post-type", dest="post_type", default="envira", help="post_type של Envira")
    p.add_argument("--csv-out", default="", help="נתיב לייצוא CSV")
    args = p.parse_args()

    if args.wxr_export:
        return run_wxr(args.wxr_export, args.csv_out or "")

    if not args.host or not args.user or not args.database:
        print_instructions()
        return 0

    return try_mysql_inventory(args)


if __name__ == "__main__":
    raise SystemExit(main())
