#!/usr/bin/env python3
"""
team_100 W2-06 blog import — REST API (Application Password) replacement for the
WP-Admin WXR importer. Idempotent: skips terms/posts that already exist by slug.

Reuses auth from scripts/wp_rest_client.py (UPRESS_WP_APP_USER/PASS via local/.env.upress).
No interactive login. Imports: categories (with hierarchy) -> tags -> 54 posts.
Author forced to eyaladmin (id 1). Run from repo root.
"""
from __future__ import annotations
import sys, time, html
import xml.etree.ElementTree as ET
from pathlib import Path

ROOT = Path(__file__).resolve().parents[3]   # repo root
sys.path.insert(0, str(ROOT / "scripts"))
import wp_rest_client as wp   # noqa: E402

NS = {'wp':'http://wordpress.org/export/1.2/',
      'content':'http://purl.org/rss/1.0/modules/content/',
      'dc':'http://purl.org/dc/elements/1.1/',
      'excerpt':'http://wordpress.org/export/1.2/excerpt/'}
WXR = ROOT / "site" / "exports" / "blog-legacy.wxr"
AUTHOR_ID = 1   # eyaladmin

def slugq(s):
    import urllib.parse; return urllib.parse.quote(s, safe='')

def rr(method, path, body=None, tries=6):
    """wp._request_raw with retry/backoff on transient network timeouts."""
    import urllib.error
    delay = 2
    for attempt in range(1, tries+1):
        try:
            return wp._request_raw(method, path, body)
        except (urllib.error.URLError, TimeoutError, OSError) as e:
            if attempt == tries:
                raise
            print(f"    .. retry {attempt}/{tries} after net error ({e}); sleeping {delay}s")
            time.sleep(delay); delay = min(delay*2, 20)

def find_term(kind, slug):
    st, data = rr("GET", f"/wp/v2/{kind}?slug={slugq(slug)}&per_page=1")
    if st == 200 and isinstance(data, list) and data:
        return data[0]["id"]
    return None

def ensure_term(kind, slug, name, parent_id=None):
    tid = find_term(kind, slug)
    if tid:
        print(f"  = {kind[:-1]} exists: {slug} (id {tid})"); return tid
    body = {"name": name, "slug": slug}
    if parent_id: body["parent"] = parent_id
    st, data = rr("POST", f"/wp/v2/{kind}", body)
    if st in (200,201):
        print(f"  + {kind[:-1]} created: {slug} (id {data['id']})"); return data["id"]
    # term_exists race -> fetch
    if isinstance(data, dict) and data.get("code")=="term_exists":
        existing = data.get("data",{}).get("term_id") or (data.get("additional_data") or [None])[0]
        if existing: print(f"  = {kind[:-1]} term_exists: {slug} (id {existing})"); return existing
        tid = find_term(kind, slug)
        if tid: return tid
    raise RuntimeError(f"failed {kind} {slug}: {st} {data}")

def post_exists(slug):
    st, data = rr("GET", f"/wp/v2/posts?slug={slugq(slug)}&status=any&per_page=1")
    if st==200 and isinstance(data,list) and data: return data[0]["id"]
    return None

def main():
    ch = ET.parse(WXR).getroot().find('channel')

    # ---- categories: build term_id -> (slug,name,parent_termid) ; create parents first
    cat_meta = {}
    for c in ch.findall('wp:category', NS):
        tid = c.findtext('wp:term_id','',NS)
        cat_meta[tid] = {
            "slug": c.findtext('wp:category_nicename','',NS),
            "name": c.findtext('wp:cat_name','',NS),
            "parent": c.findtext('wp:category_parent','',NS),  # parent term_id or '0'
        }
    print(f"Categories in WXR: {len(cat_meta)}")
    slug_to_id = {}   # category slug -> new WP id
    termid_to_newid = {}
    # two passes: parents (parent==0) first, then children
    for want_parent_zero in (True, False):
        for tid, m in cat_meta.items():
            is_top = (m["parent"] in ("0","",None))
            if is_top != want_parent_zero: continue
            parent_new = None
            if not is_top:
                parent_new = termid_to_newid.get(m["parent"])
            nid = ensure_term("categories", m["slug"], m["name"], parent_new)
            slug_to_id[m["slug"]] = nid
            termid_to_newid[tid] = nid

    # ---- tags: collect from items (domain post_tag)
    items = ch.findall('item')
    tag_name_by_slug = {}
    for i in items:
        for c in i.findall('category'):
            if c.get('domain')=='post_tag':
                tag_name_by_slug.setdefault(c.get('nicename'), (c.text or c.get('nicename')))
    print(f"Distinct tags: {len(tag_name_by_slug)}")
    tag_slug_to_id = {}
    for slug, name in tag_name_by_slug.items():
        tag_slug_to_id[slug] = ensure_term("tags", slug, name)

    # ---- posts
    created=skipped=failed=0
    for i in items:
        if i.findtext('wp:post_type','',NS)!='post': continue
        slug = i.findtext('wp:post_name','',NS)
        title = i.findtext('title') or slug
        if post_exists(slug):
            skipped+=1; print(f"  = post exists, skip: {slug}"); continue
        content = i.findtext('content:encoded','',NS) or ''
        date = (i.findtext('wp:post_date','',NS) or '').replace(' ','T')
        cat_ids=[]; tag_ids=[]
        for c in i.findall('category'):
            if c.get('domain')=='category' and c.get('nicename') in slug_to_id:
                cat_ids.append(slug_to_id[c.get('nicename')])
            elif c.get('domain')=='post_tag' and c.get('nicename') in tag_slug_to_id:
                tag_ids.append(tag_slug_to_id[c.get('nicename')])
        body={"title":title,"slug":slug,"content":content,"status":"publish",
              "author":AUTHOR_ID,"categories":cat_ids,"tags":tag_ids}
        if date: body["date"]=date
        st,data=rr("POST","/wp/v2/posts",body)
        if st in (200,201):
            created+=1; print(f"  + post {created}: {slug} (id {data['id']})")
        else:
            failed+=1; print(f"  ! FAIL {slug}: {st} {str(data)[:200]}")
        time.sleep(0.15)
    print(f"\nSUMMARY: created={created} skipped={skipped} failed={failed} "
          f"categories={len(slug_to_id)} tags={len(tag_slug_to_id)}")

if __name__=="__main__":
    main()
