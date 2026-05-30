#!/usr/bin/env bash
# WP-W2-09 (team_20) — final pre-cutover end-to-end assertion.
# Exits non-zero on ANY failure. Cache-busts every request.
#
# Asserts:
#   (a) every in-use media URL -> 200 (regenerated inventory)
#   (b) all generated 301 rules resolve to a LIVE target (301 + Location -> 200)
#       and all 410 rules -> 410
#   (c) all 49 QR URLs -> 200 (vs docs/project/team-100-preplanning/QR-URL-INVENTORY.csv)
#   (d) validate_aos.sh -> 0 FAIL
#   (e) Lighthouse homepage >= 90 (perf/access/SEO/best-practices) on HTTP staging
#
# Usage:  bash scripts/final_pre_cutover_check.sh [--skip-lighthouse]
set -uo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BASE="http://eyalamit-co-il-2026.s887.upress.link"
INV="${ROOT}/_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-REGEN-2026-05-30.json"
BLOCK="${ROOT}/_COMMUNICATION/team_100/tools/htaccess_301_block.txt"
QR_CSV="${ROOT}/docs/project/team-100-preplanning/QR-URL-INVENTORY.csv"
SKIP_LH=0
[ "${1:-}" = "--skip-lighthouse" ] && SKIP_LH=1

FAILS=0
note() { printf '%s\n' "$*"; }
fail() { printf 'FAIL: %s\n' "$*"; FAILS=$((FAILS+1)); }

cb() { echo "$1?cb=$RANDOM$RANDOM"; }
code() { curl -s --max-time 25 -o /dev/null -w "%{http_code}" "$(cb "$1")"; }
loc()  { curl -s --max-time 25 -o /dev/null -w "%{redirect_url}" "$(cb "$1")"; }

# ---------- (a) media ----------
note "== (a) in-use media 200 =="
if [ ! -f "$INV" ]; then
  fail "media inventory not found: $INV"
else
  python3 - "$INV" "$BASE" <<'PY'
import json,sys,urllib.request,random,time
inv=json.load(open(sys.argv[1])); base=sys.argv[2]
def code(url):
    for a in range(3):
        try: return urllib.request.urlopen(urllib.request.Request(url,headers={"User-Agent":"chk"}),timeout=25).status
        except urllib.error.HTTPError as e: return e.code
        except Exception: time.sleep(1+a)
    return 0
bad=0; tot=0
for it in inv.get("items",[]):
    u=it["url"]; tot+=1
    url=u+("&cb=%d"%random.randint(1,99999) if "?" in u else "?cb=%d"%random.randint(1,99999))
    c=code(url)
    if c!=200:
        print(f"  media NON-200 {c}: {u}"); bad+=1
print(f"  media items={tot} non200={bad}")
sys.exit(1 if bad else 0)
PY
  [ $? -ne 0 ] && fail "one or more in-use media != 200"
fi

# ---------- (b) 301/410 redirects ----------
note "== (b) 301/410 redirects resolve =="
if [ ! -f "$BLOCK" ]; then
  fail "htaccess block not found: $BLOCK"
else
  python3 - "$BLOCK" "$BASE" <<'PY'
import sys,re,urllib.request,random
from urllib.parse import urlsplit,unquote
block=open(sys.argv[1],encoding="utf-8").read().splitlines(); base=sys.argv[2]
r301=[]; r410=[]
# parse literal page-level rules; skip pattern rules (e.g. blog catch-all ^Blog/(.+)$)
def literal(p):
    return not any(ch in p for ch in "()*+?")
for l in block:
    m=re.match(r"RewriteRule \^(.+?)\$ (\S+) \[R=301", l)
    if m and literal(m.group(1)): r301.append(("/"+m.group(1), m.group(2))); continue
    m=re.match(r"RewriteRule \^(.+?)\$ - \[G", l)
    if m and literal(m.group(1)): r410.append("/"+m.group(1)); continue
    m=re.match(r"Redirect 301 (\S+) (\S+)", l)
    if m: r301.append((m.group(1), m.group(2))); continue
    m=re.match(r"Redirect 410 (\S+)", l)
    if m: r410.append(m.group(1)); continue
import time
def req(path,follow=False):
    class NR(urllib.request.HTTPRedirectHandler):
        def redirect_request(self,*a,**k): return None
    op=urllib.request.build_opener() if follow else urllib.request.build_opener(NR)
    for a in range(3):
        url=base+path+("?cb=%d"%random.randint(1,99999))
        try:
            r=op.open(urllib.request.Request(url,headers={"User-Agent":"chk"}),timeout=25); return r.status, r.headers.get("Location")
        except urllib.error.HTTPError as e: return e.code, e.headers.get("Location")
        except Exception: time.sleep(1+a)
    return 0, None
bad=0
for src,tgt in r301:
    c,L=req(src); lp=urlsplit(L).path if L else None
    fc,_=req(tgt,follow=True)
    if not (c==301 and lp and unquote(lp).rstrip("/")==unquote(tgt).rstrip("/") and fc==200):
        print(f"  301 FAIL src={unquote(src)[:30]} code={c} loc={lp} tgt={tgt} final={fc}"); bad+=1
for src in r410:
    c,_=req(src)
    if c!=410:
        print(f"  410 FAIL src={unquote(src)[:30]} code={c}"); bad+=1
print(f"  301={len(r301)} 410={len(r410)} failures={bad}")
sys.exit(1 if bad else 0)
PY
  [ $? -ne 0 ] && fail "one or more 301/410 rules did not resolve"
fi

# ---------- (c) 49 QR ----------
note "== (c) 49 QR URLs 200 =="
if [ ! -f "$QR_CSV" ]; then
  fail "QR CSV not found: $QR_CSV"
else
  python3 - "$QR_CSV" "$BASE" <<'PY'
import sys,csv,urllib.request,random,time
rows=list(csv.DictReader(open(sys.argv[1],encoding="utf-8-sig"))); base=sys.argv[2]
def code(path):
    for a in range(3):
        url=base+path+("?cb=%d"%random.randint(1,99999))
        try: return urllib.request.urlopen(urllib.request.Request(url,headers={"User-Agent":"chk"}),timeout=25).status
        except urllib.error.HTTPError as e: return e.code
        except Exception: time.sleep(1+a)
    return 0
bad=0; tot=0
for r in rows:
    sp=(r.get("slug_or_path") or "").strip().strip("/")
    if not sp: continue
    path="/"+sp+"/"; tot+=1
    c=code(path)
    if c!=200:
        print(f"  QR NON-200 {c}: {path}"); bad+=1
print(f"  QR checked={tot} non200={bad}")
sys.exit(1 if bad else 0)
PY
  [ $? -ne 0 ] && fail "one or more QR URLs != 200"
fi

# ---------- (d) validate_aos ----------
note "== (d) validate_aos.sh 0 FAIL =="
VAL="${ROOT}/_aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh"
if [ -f "$VAL" ]; then
  OUT="$(bash "$VAL" "$ROOT" 2>&1)"
  echo "$OUT" | tail -3
  if echo "$OUT" | grep -Eiq '([1-9][0-9]* +FAIL|FAIL:[1-9])'; then
    fail "validate_aos reported FAIL"
  fi
else
  fail "validate_aos.sh not found at $VAL"
fi

# ---------- (e) Lighthouse ----------
note "== (e) Lighthouse home >= 90 =="
if [ "$SKIP_LH" = "1" ]; then
  note "  (skipped via --skip-lighthouse)"
elif ! command -v lighthouse >/dev/null 2>&1; then
  fail "lighthouse CLI not installed (run with --skip-lighthouse to bypass, or install)"
else
  TMP="$(mktemp -d)"
  lighthouse "${BASE}/" --quiet --chrome-flags="--headless --no-sandbox" \
    --only-categories=performance,accessibility,seo,best-practices \
    --output=json --output-path="${TMP}/lh.json" >/dev/null 2>&1
  if [ -f "${TMP}/lh.json" ]; then
    python3 - "${TMP}/lh.json" <<'PY'
import json,sys
d=json.load(open(sys.argv[1])); c=d["categories"]
bad=0
for k in ("performance","accessibility","seo","best-practices"):
    s=round((c[k]["score"] or 0)*100)
    print(f"  {k}={s}")
    if s<90: bad+=1
sys.exit(1 if bad else 0)
PY
    [ $? -ne 0 ] && fail "Lighthouse category < 90"
  else
    fail "Lighthouse run produced no report"
  fi
  rm -rf "$TMP"
fi

echo
if [ "$FAILS" -eq 0 ]; then
  echo "RESULT: PASS — all pre-cutover checks green"
  exit 0
else
  echo "RESULT: FAIL — ${FAILS} check group(s) failed"
  exit 1
fi
