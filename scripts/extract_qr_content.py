#!/usr/bin/env python3
"""
WP-W2-07 QR content export — 1:1 migration of 49 legacy QR pages.

Reads:
  - wp_posts mysqldump
  - QR-URL-INVENTORY.csv (SSoT for wp_id -> qrN mapping; do NOT change slugs)

Writes:
  - W2-07-QR-CONTENT-EXPORT-2026-05-28.json  (49 objects)

Method: character-by-character tokenizer over `INSERT INTO `wp_posts` VALUES (...),(...);`
rows, respecting single-quoted strings with MySQL escaping (\\', \\\\, \\", etc.).
"""

import csv
import json
import re
import sys

SQL = "/Users/nimrod/Documents/Eyal Amit/eyalamit.co.il-legacy/wp_posts_backup_20260113_010740.sql"
CSV = "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/docs/project/team-100-preplanning/QR-URL-INVENTORY.csv"
OUT = "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_COMMUNICATION/team_40/W2-07-QR-CONTENT-EXPORT-2026-05-28.json"

# wp_posts column indices
COL_ID = 0
COL_CONTENT = 4
COL_TITLE = 5
COL_NAME = 11  # slug

# MySQL escape map for backslash sequences inside single-quoted strings
ESCAPE_MAP = {
    "0": "\0",
    "'": "'",
    '"': '"',
    "b": "\b",
    "n": "\n",
    "r": "\r",
    "t": "\t",
    "Z": "\x1a",
    "\\": "\\",
    "%": "\\%",   # MySQL keeps the backslash for \% and \_ unless used in LIKE
    "_": "\\_",
}


def unescape_sql_value(raw):
    """Unescape a single-quoted MySQL string body (without surrounding quotes)."""
    out = []
    i = 0
    n = len(raw)
    while i < n:
        c = raw[i]
        if c == "\\" and i + 1 < n:
            nxt = raw[i + 1]
            out.append(ESCAPE_MAP.get(nxt, nxt))
            i += 2
        elif c == "'" and i + 1 < n and raw[i + 1] == "'":
            # doubled single-quote -> single quote
            out.append("'")
            i += 2
        else:
            out.append(c)
            i += 1
    return "".join(out)


def tokenize_values(s, start):
    """
    Parse the tuple list following 'VALUES' beginning at index `start`
    (which should point at the first '(' ). Returns list-of-rows; each row
    is a list of field values. String fields are returned unescaped; non-string
    (numbers / NULL) returned as raw text. Stops at the terminating ';'.
    Returns (rows, end_index).
    """
    rows = []
    i = start
    n = len(s)
    while i < n:
        # skip whitespace and commas between tuples
        while i < n and s[i] in " \t\r\n,":
            i += 1
        if i >= n:
            break
        if s[i] == ";":
            break
        if s[i] != "(":
            # not a tuple start; stop
            break
        # parse one tuple
        i += 1  # consume '('
        fields = []
        cur = []
        cur_is_string = False
        in_string = False
        while i < n:
            c = s[i]
            if in_string:
                if c == "\\":
                    # take this char and the next verbatim (handled in unescape)
                    cur.append(c)
                    if i + 1 < n:
                        cur.append(s[i + 1])
                        i += 2
                    else:
                        i += 1
                    continue
                elif c == "'":
                    # could be end of string, or doubled-quote escape
                    if i + 1 < n and s[i + 1] == "'":
                        cur.append("''")
                        i += 2
                        continue
                    else:
                        in_string = False
                        i += 1
                        continue
                else:
                    cur.append(c)
                    i += 1
                    continue
            else:
                if c == "'":
                    in_string = True
                    cur_is_string = True
                    i += 1
                    continue
                elif c == ",":
                    val = "".join(cur)
                    fields.append(unescape_sql_value(val) if cur_is_string else val.strip())
                    cur = []
                    cur_is_string = False
                    i += 1
                    continue
                elif c == ")":
                    val = "".join(cur)
                    fields.append(unescape_sql_value(val) if cur_is_string else val.strip())
                    cur = []
                    cur_is_string = False
                    i += 1
                    rows.append(fields)
                    break
                else:
                    cur.append(c)
                    i += 1
                    continue
    return rows, i


def parse_dump(path):
    """Yield rows (list of field values) for every wp_posts tuple in the dump."""
    with open(path, "r", encoding="utf-8", errors="replace") as f:
        data = f.read()
    all_rows = []
    marker = "INSERT INTO `wp_posts` VALUES "
    pos = 0
    while True:
        idx = data.find(marker, pos)
        if idx == -1:
            break
        start = idx + len(marker)
        rows, end = tokenize_values(data, start)
        all_rows.extend(rows)
        pos = end
    return all_rows


IMG_RE = re.compile(
    r'(?:src|href)\s*=\s*["\']([^"\']+\.(?:png|jpe?g|gif|webp|svg|bmp|tiff?))(?:\?[^"\']*)?["\']',
    re.IGNORECASE,
)


def extract_image_urls(html):
    urls = []
    seen = set()
    for m in IMG_RE.finditer(html or ""):
        u = m.group(1)
        if u not in seen:
            seen.add(u)
            urls.append(u)
    return urls


def qr_n_from_slug(slug_or_path):
    # slug_or_path like 'qr/qr10' or 'qr'
    m = re.search(r'qr(\d+)$', slug_or_path)
    return int(m.group(1)) if m else None


def main():
    # 1. Load inventory: map wp_id -> qr_n (only the 49 qrN rows, skip parent 'qr')
    inv = {}  # qr_n -> {wp_id, title (inventory), slug}
    with open(CSV, newline="", encoding="utf-8-sig") as f:
        reader = csv.DictReader(f)
        for row in reader:
            qn = qr_n_from_slug(row["slug_or_path"].strip())
            if qn is None:
                continue  # parent 'qr'
            inv[qn] = {
                "wp_id": int(row["wp_id"]),
                "inv_title": row["title"].strip(),
                "slug": row["slug_or_path"].strip(),
            }

    # SSoT QR-URL-INVENTORY.csv holds qr1..qr48 (48 rows) + parent 'qr'. There is
    # NO qr49 (verified: absent from inventory AND legacy dump). The export is
    # inventory-driven — one record per real qrN — so it maps 1:1 to the SSoT.
    print(f"inventory_qrN_rows={len(inv)} (qr1..qr48)")

    # 2. Parse dump -> id -> (content, title)
    rows = parse_dump(SQL)
    by_id = {}
    for fields in rows:
        if len(fields) <= COL_TITLE:
            continue
        try:
            pid = int(fields[COL_ID])
        except (ValueError, IndexError):
            continue
        by_id[pid] = {
            "content": fields[COL_CONTENT],
            "title": fields[COL_TITLE],
        }

    # 3. Build one record per real qrN (inventory-driven, 1:1 with SSoT)
    missing = []
    records = []
    for qn in sorted(inv):
        info = inv[qn]
        wp_id = info["wp_id"]
        post = by_id.get(wp_id)
        if post is None:
            missing.append(f"qr{qn} (wp_id={wp_id}): not found in dump")
            records.append({
                "qr_n": qn,
                "slug": f"qr/qr{qn}",
                "title": info["inv_title"],
                "body_html": "",
                "image_urls": [],
            })
            continue
        body = post["content"] or ""
        title = post["title"] or info["inv_title"]
        if not body.strip():
            missing.append(f"qr{qn} (wp_id={wp_id}): empty body_html in legacy")
        records.append({
            "qr_n": qn,
            "slug": f"qr/qr{qn}",
            "title": title,
            "body_html": body,
            "image_urls": extract_image_urls(body),
        })

    # 4. Validate & write
    assert len(records) == len(inv), f"Expected {len(inv)} records, got {len(records)}"
    with open(OUT, "w", encoding="utf-8") as f:
        json.dump(records, f, ensure_ascii=False, indent=2)

    # self-check: reparse
    with open(OUT, "r", encoding="utf-8") as f:
        reparsed = json.load(f)
    assert len(reparsed) == len(inv), "Reparse failed count check"

    # report
    print(f"WROTE {OUT}")
    print(f"records={len(records)}")
    print(f"with_body={sum(1 for r in records if r['body_html'].strip())}")
    print(f"with_images={sum(1 for r in records if r['image_urls'])}")
    print(f"total_image_urls={sum(len(r['image_urls']) for r in records)}")
    print("MISSING_OR_GAPS:")
    for m in missing:
        print("  -", m)


if __name__ == "__main__":
    main()
