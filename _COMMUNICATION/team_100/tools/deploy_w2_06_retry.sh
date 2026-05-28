#!/bin/bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026"
BASE="http://eyalamit-co-il-2026.s887.upress.link"
ok=0
for i in $(seq 1 20); do
  if python3 - <<'PY'
import sys;from pathlib import Path
sys.path.insert(0,str(Path('.').resolve()/'scripts'))
import upress_ftp_env as fenv
try:
    ftp,root=fenv.connect_ftp(timeout=25); ftp.quit(); sys.exit(0)
except Exception: sys.exit(1)
PY
  then
    echo "[attempt $i] FTP up — deploying theme"
    if python3 scripts/ftp_deploy_site_wp_content.py 2>&1 | tail -3; then ok=1; break; fi
  else
    echo "[attempt $i] FTP still down; sleeping 90s"
    sleep 90
  fi
done
if [ "$ok" = "1" ]; then
  echo "=== DEPLOYED — verifying /blog/ (opcache retry) ==="
  for j in 1 2 3 4 5; do
    TS=$(date +%s)$RANDOM; A=$(curl -sk "$BASE/blog/?cb=$TS")
    shell=$(printf '%s' "$A" | grep -co "ea-wave2-shell"); vc=$(printf '%s' "$A" | grep -co "vc_row"); blog=$(printf '%s' "$A" | grep -co "ea-blog")
    echo "verify $j: /blog/ ea-wave2-shell=$shell ea-blog=$blog vc_row=$vc"
    [ "$shell" -ge 1 ] && [ "$vc" = "0" ] && { echo "ARCHIVE OK"; break; }
    sleep 8
  done
else
  echo "DEPLOY NOT COMPLETED — FTP unreachable after 20 attempts"
fi
