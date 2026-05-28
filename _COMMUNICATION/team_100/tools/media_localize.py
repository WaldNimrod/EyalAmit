#!/usr/bin/env python3
"""
team_100 W2-06 media localization.

Requirement (team_00, 2026-05-28): ALL media used in posts/pages must be moved
into the NEW site's folders and referenced with RELATIVE links — no hotlinks to
the legacy site or third-party CDNs.

Operates on LIVE content via REST (context=edit). For every remote media URL in
post/page content:
  1. download it (with UA + retry)
  2. upload it into the new site via FTP under wp-content/uploads
       - eyalamit.co.il /wp-content/uploads/... -> mirrored path (relative)
       - anything else -> /wp-content/uploads/ea-legacy/<host>/<hash>-<name><ext>
  3. rewrite the content URL to a root-relative path (/wp-content/uploads/...)
  4. PUT the updated content back

Idempotent: already-relative URLs are skipped. Dead/blocked URLs are left as-is
and reported. Run from repo root AFTER the post import completes.
"""
from __future__ import annotations
import sys, re, time, hashlib, mimetypes, tempfile
from pathlib import Path, PurePosixPath
from urllib.parse import urlparse, urljoin
import urllib.request, urllib.error

ROOT = Path(__file__).resolve().parents[3]
sys.path.insert(0, str(ROOT / "scripts"))
import wp_rest_client as wp           # REST auth (App Password)
import upress_ftp_env as fenv         # FTP helpers

STAGING_HOST = "eyalamit-co-il-2026.s887.upress.link"
LEGACY_HOSTS = ("eyalamit.co.il", "www.eyalamit.co.il")
UA = {"User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 "
                    "(KHTML, like Gecko) Chrome/124 Safari/537.36"}
EXT_OK = {".jpg",".jpeg",".png",".gif",".webp",".svg",".bmp",".tif",".tiff",
          ".pdf",".doc",".docx",".mp3",".mp4",".m4a",".ico"}

# ---- REST retry wrapper -------------------------------------------------------
def rr(method, path, body=None, tries=6):
    delay=2
    for a in range(1,tries+1):
        try: return wp._request_raw(method, path, body)
        except (urllib.error.URLError, TimeoutError, OSError) as e:
            if a==tries: raise
            print(f"    .. REST retry {a}/{tries} ({e}); sleep {delay}s"); time.sleep(delay); delay=min(delay*2,20)

# ---- collect live content ----------------------------------------------------
def fetch_all(kind):
    out=[]; page=1
    while True:
        st,data=rr("GET", f"/wp/v2/{kind}?per_page=50&page={page}&status=any&context=edit")
        if st!=200 or not isinstance(data,list) or not data: break
        out.extend(data)
        if len(data)<50: break
        page+=1
    return out

# ---- URL extraction ----------------------------------------------------------
URL_RE = re.compile(r'(?:src|href)\s*=\s*["\']([^"\']+)["\']', re.I)
SRCSET_RE = re.compile(r'srcset\s*=\s*["\']([^"\']+)["\']', re.I)

def candidate_urls(content):
    urls=set()
    for m in URL_RE.findall(content): urls.add(m.strip())
    for ss in SRCSET_RE.findall(content):
        for part in ss.split(","):
            u=part.strip().split(" ")[0].strip()
            if u: urls.add(u)
    return urls

def is_remote_media(u):
    if u.startswith("data:") or u.startswith("#"): return False
    p=urlparse(u if "//" in u else "https:"+u if u.startswith("//") else u)
    host=p.netloc.lower()
    if not host:  # already relative
        return False
    if host==STAGING_HOST:  # staging absolute -> we still relativize (handled later) but only if media ext
        pass
    ext=PurePosixPath(p.path).suffix.lower().split("?")[0]
    return ext in EXT_OK or "fbcdn" in host or "flickr" in host or "googleusercontent" in host

def normalize_abs(u):
    if u.startswith("//"): return "https:"+u
    if u.startswith("http"): return u
    return u

def new_relative_path(u):
    p=urlparse(normalize_abs(u)); host=p.netloc.lower(); path=p.path
    ext=PurePosixPath(path).suffix.lower() or ""
    if any(host==h or host.endswith("."+h) or host==h.replace("www.","") for h in LEGACY_HOSTS) or host.endswith("eyalamit.co.il"):
        if path.startswith("/wp-content/uploads/"):
            return path  # mirror
        base=PurePosixPath(path).name or "file"
        return f"/wp-content/uploads/ea-legacy/eyalamit/{base}"
    if host==STAGING_HOST:
        return path  # already on new site, just relativize
    # external CDN
    h=hashlib.sha1(normalize_abs(u).encode()).hexdigest()[:10]
    base=PurePosixPath(path).name or "img"
    base=re.sub(r"[^A-Za-z0-9._-]","_",base)
    if not PurePosixPath(base).suffix: base=base+(ext or "")
    safehost=re.sub(r"[^A-Za-z0-9.-]","_",host)
    return f"/wp-content/uploads/ea-legacy/{safehost}/{h}-{base}"

def encode_url(u):
    from urllib.parse import urlsplit, urlunsplit, quote
    p=urlsplit(normalize_abs(u))
    return urlunsplit((p.scheme, p.netloc, quote(p.path), quote(p.query, safe="=&?%"), ""))

def download(u, dest):
    req=urllib.request.Request(encode_url(u), headers=UA)
    for a in range(1,4):
        try:
            with urllib.request.urlopen(req, timeout=30) as r:
                data=r.read()
            if len(data)<8: raise ValueError("empty")
            dest.write_bytes(data); return len(data)
        except Exception as e:
            if a==3: raise
            time.sleep(2)

def main():
    items=[("posts",p) for p in fetch_all("posts")] + [("pages",p) for p in fetch_all("pages")]
    print(f"Scanning {len(items)} items (posts+pages)")
    # gather unique remote urls
    urlmap={}   # original-url-string -> new relative path
    for kind,it in items:
        c=it.get("content",{}).get("raw","") or ""
        for u in candidate_urls(c):
            if u.startswith("/"):  # already relative
                continue
            if is_remote_media(u):
                urlmap.setdefault(u, new_relative_path(u))
    print(f"Unique remote media URLs: {len(urlmap)}")

    # download + upload
    tmp=Path(tempfile.mkdtemp(prefix="ea-media-"))
    ftp,root=fenv.connect_ftp(timeout=120)
    migrated={}; failed={}
    try:
        for i,(u,rel) in enumerate(sorted(urlmap.items()),1):
            local=tmp/(hashlib.sha1(u.encode()).hexdigest())
            try:
                n=download(u, local)
            except Exception as e:
                failed[u]=f"download: {e}"; print(f"  [{i}/{len(urlmap)}] DL-FAIL {u[:80]} ({e})"); continue
            # upload mirroring rel path under WP root
            remote=rel.lstrip("/")
            d=str(PurePosixPath(remote).parent); name=PurePosixPath(remote).name
            try:
                ftp.cwd("/"); fenv.ftp_cwd_to_wordpress_root(ftp, root); fenv.ftp_ensure_cwd(ftp, d)
                fenv.ftp_upload_file(ftp, local, name)
                migrated[u]=rel; print(f"  [{i}/{len(urlmap)}] OK {n}B -> {rel}")
            except Exception as e:
                failed[u]=f"upload: {e}"; print(f"  [{i}/{len(urlmap)}] UP-FAIL {u[:80]} ({e})")
            time.sleep(0.05)
    finally:
        try: ftp.quit()
        except Exception: pass

    # rewrite content
    updated=0
    for kind,it in items:
        c=it.get("content",{}).get("raw","") or ""
        newc=c; changed=False
        for u,rel in migrated.items():
            if u in newc:
                newc=newc.replace(u, rel); changed=True
            # also handle protocol-relative form
            if u.startswith("https://") and ("//"+u[8:]) in newc:
                newc=newc.replace("//"+u[8:], rel); changed=True
        if changed:
            st,_=rr("POST", f"/wp/v2/{kind}/{it['id']}", {"content":newc})
            updated+= (1 if st in (200,201) else 0)
            print(f"  rewrote {kind} {it['id']} ({it.get('slug')})")
    print(f"\nSUMMARY: migrated={len(migrated)} failed={len(failed)} content_updated={updated}")
    if failed:
        print("FAILED URLS:")
        for u,why in failed.items(): print(f"  - {u}  [{why}]")

if __name__=="__main__":
    main()
