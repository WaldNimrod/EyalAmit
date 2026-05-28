#!/usr/bin/env python3
"""
team_100 — deploy corrected W2-06 301 block into the live web-root .htaccess.
Safe: downloads + backs up current .htaccess, inserts a marker-wrapped block
(idempotent), uploads, verifies site health + a sample redirect, and AUTO-ROLLS
BACK to the backup if verification fails. Run from repo root after media job.
"""
import sys, io, time, datetime, urllib.request
from pathlib import Path
ROOT=Path(__file__).resolve().parents[3]; sys.path.insert(0,str(ROOT/"scripts"))
import upress_ftp_env as fenv
import wp_rest_client as wp

BASE="http://eyalamit-co-il-2026.s887.upress.link"
BLOCK=Path(ROOT/"_COMMUNICATION/team_100/tools/htaccess_301_block.txt").read_text(encoding="utf-8")
BEGIN="# BEGIN EA-W2-06 301"; END="# END EA-W2-06 301"

def http_code(url):
    try:
        req=urllib.request.Request(url, headers={"User-Agent":"ea-deploy-check"})
        return urllib.request.urlopen(req, timeout=30).status
    except urllib.error.HTTPError as e: return e.code
    except Exception as e: return f"ERR:{e}"

def redirect_of(path):
    import http.client
    from urllib.parse import urlsplit
    p=urlsplit(BASE); c=http.client.HTTPConnection(p.netloc, timeout=30)
    c.request("GET", path, headers={"User-Agent":"ea-deploy-check"})
    r=c.getresponse(); return r.status, r.getheader("Location")

def main():
    ftp,root=fenv.connect_ftp(timeout=120)
    try:
        # download current .htaccess
        buf=io.BytesIO()
        try:
            ftp.retrbinary("RETR .htaccess", buf.write); cur=buf.getvalue().decode("utf-8","replace")
        except Exception:
            cur=""  # none exists yet
        ts=datetime.datetime.now().strftime("%Y%m%d-%H%M%S")
        bak=ROOT/f"_COMMUNICATION/team_100/tools/htaccess.backup-{ts}"
        bak.write_text(cur, encoding="utf-8"); print(f"backup saved: {bak.name} ({len(cur)} bytes)")

        # build new content (idempotent)
        if BEGIN in cur and END in cur:
            pre=cur.split(BEGIN)[0]; post=cur.split(END,1)[1]
            newc=pre+BLOCK.strip()+"\n"+post.lstrip("\n")
            print("replaced existing EA-W2-06 block")
        elif "# BEGIN WordPress" in cur:
            newc=cur.replace("# BEGIN WordPress", BLOCK.strip()+"\n\n# BEGIN WordPress",1)
            print("inserted block before # BEGIN WordPress")
        else:
            newc=BLOCK.strip()+"\n\n"+cur
            print("prepended block (no WP marker found)")

        # upload
        ftp.cwd("/"); fenv.ftp_cwd_to_wordpress_root(ftp, root)
        ftp.storbinary("STOR .htaccess", io.BytesIO(newc.encode("utf-8")))
        print(f"uploaded .htaccess ({len(newc)} bytes)")
    finally:
        try: ftp.quit()
        except Exception: pass

    time.sleep(2)
    # verify
    home=http_code(BASE+"/"); about=http_code(BASE+"/about/")
    # sample legacy /Blog/<slug>/ should 301 -> /<slug>/
    st,posts=wp._request_raw("GET","/wp/v2/posts?per_page=1&status=publish")
    slug=posts[0]["slug"]
    rc,loc=redirect_of(f"/Blog/{slug}/")
    print(f"\nVERIFY: home={home} about={about}  /Blog/{slug[:20]}.. -> {rc} Location={loc}")
    ok = (home==200 and about==200 and rc in (301,302) and loc and ("/"+slug) in loc and "/blog/" not in loc.lower().replace("/blog/legacy",""))
    # ok redirect target should be root /<slug>/ not /blog/<slug>/
    ok = (home==200 and about==200 and rc==301 and loc and loc.rstrip("/").endswith(slug.rstrip("/")))
    if ok:
        print("RESULT: PASS — site healthy + legacy /Blog/ redirects to root")
    else:
        print("RESULT: FAIL — rolling back .htaccess")
        ftp,root=fenv.connect_ftp(timeout=120)
        try:
            ftp.cwd("/"); fenv.ftp_cwd_to_wordpress_root(ftp, root)
            ftp.storbinary("STOR .htaccess", io.BytesIO(cur.encode("utf-8")))
            print("ROLLED BACK to backup")
        finally:
            try: ftp.quit()
            except Exception: pass
        sys.exit(1)

if __name__=="__main__":
    main()
