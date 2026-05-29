#!/usr/bin/env python3
"""Extract HE page content + comments (testimonials) from staging SQL for WP-W2-08."""
import re, sys

SQL = "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/local/eyalamit-staging-20260411.sql"
raw = open(SQL, encoding="utf-8", errors="replace").read()

def split_rows(table):
    """Yield raw row tuples (as strings) from all INSERT INTO `table` statements."""
    rows = []
    for stmt in re.finditer(r"INSERT INTO `%s`(?: \([^)]*\))? VALUES (.*?);\n" % re.escape(table), raw, re.S):
        body = stmt.group(1)
        # split top-level (...) tuples respecting quotes/escapes
        depth = 0; cur = ""; inq = False; esc = False
        for ch in body:
            if esc:
                cur += ch; esc = False; continue
            if ch == "\\":
                cur += ch; esc = True; continue
            if ch == "'":
                inq = not inq; cur += ch; continue
            if not inq:
                if ch == "(":
                    if depth == 0:
                        cur = ""
                    else:
                        cur += ch
                    depth += 1; continue
                if ch == ")":
                    depth -= 1
                    if depth == 0:
                        rows.append(cur); cur = ""
                    else:
                        cur += ch
                    continue
            cur += ch
    return rows

def parse_fields(rowstr):
    """Split a single tuple body into fields respecting quotes."""
    fields = []; cur = ""; inq = False; esc = False
    for ch in rowstr:
        if esc:
            cur += ch; esc = False; continue
        if ch == "\\":
            cur += ch; esc = True; continue
        if ch == "'":
            inq = not inq; cur += ch; continue
        if ch == "," and not inq:
            fields.append(cur); cur = ""; continue
        cur += ch
    fields.append(cur)
    return [f.strip() for f in fields]

def unq(s):
    s = s.strip()
    if s.startswith("'") and s.endswith("'"):
        s = s[1:-1]
    return s.replace("\\'", "'").replace('\\"', '"').replace("\\n", "\n").replace("\\r", "").replace("\\\\", "\\")

mode = sys.argv[1] if len(sys.argv) > 1 else "pages"

if mode == "pages":
    wanted = sys.argv[2:] if len(sys.argv) > 2 else None
    # wp_posts columns: ID, post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,
    # post_status, comment_status, ping_status, post_password, post_name, ...
    for r in split_rows("wp_posts"):
        f = parse_fields(r)
        if len(f) < 21:
            continue
        post_content = unq(f[4]); post_title = unq(f[5])
        post_status = unq(f[7]); post_name = unq(f[11]); post_type = unq(f[20])
        if post_type not in ("page", "post"):
            continue
        if post_status != "publish":
            continue
        if wanted and post_name not in wanted:
            continue
        print("=" * 70)
        print("SLUG:", post_name, "| TYPE:", post_type, "| TITLE:", post_title)
        print("-" * 70)
        # strip simple html/shortcodes for readability
        c = re.sub(r"<[^>]+>", " ", post_content)
        c = re.sub(r"\[[^\]]+\]", " ", c)
        c = re.sub(r"\s+", " ", c).strip()
        print(c[:3000])
        print()

elif mode == "slugs":
    for r in split_rows("wp_posts"):
        f = parse_fields(r)
        if len(f) < 21: continue
        if unq(f[7]) != "publish": continue
        if unq(f[20]) not in ("page","post"): continue
        print(unq(f[20]), "|", unq(f[11]), "|", unq(f[5]))

elif mode == "comments":
    # wp_comments cols: comment_ID, comment_post_ID, comment_author, comment_author_email,
    # comment_author_url, comment_author_IP, comment_date, comment_date_gmt, comment_content,
    # ... comment_approved (index ~ 9..)
    for r in split_rows("wp_comments"):
        f = parse_fields(r)
        if len(f) < 11: continue
        author = unq(f[2]); content = unq(f[8])
        approved = unq(f[10]) if len(f) > 10 else ""
        if approved not in ("1", "approve", "approved"):
            continue
        content = re.sub(r"\s+", " ", re.sub(r"<[^>]+>", " ", content)).strip()
        if len(content) < 15: continue
        print("AUTHOR:", author, "| APPROVED:", approved)
        print(content)
        print("-" * 50)
