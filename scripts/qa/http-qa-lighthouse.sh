#!/usr/bin/env bash
# Lighthouse perf/a11y over HTTP for representative eyalamit staging routes.
# uPress staging is HTTP-only by design (EYAL_ENV_VARS_REFERENCE §44).
# Usage: bash scripts/qa/http-qa-lighthouse.sh [route ...]
set -uo pipefail
BASE="${EA_QA_BASE:-http://eyalamit-co-il-2026.s887.upress.link}"
CHROME="${EA_CHROME:-/Applications/Google Chrome.app/Contents/MacOS/Google Chrome}"
ROUTES=("$@"); [ ${#ROUTES[@]} -eq 0 ] && ROUTES=("/" "/treatment/" "/blog/" "/en/")
OUT="$(cd "$(dirname "$0")" && pwd)/reports"; mkdir -p "$OUT"
printf "%-18s %5s %5s %5s %5s\n" "route" "perf" "a11y" "bp" "seo"
for r in "${ROUTES[@]}"; do
  # Measure perf over HTTPS (production-representative) to drop the http->https 301 redirect
  # artifact that falsely capped Conversion mobile perf (DISPOSITION-WP-W2-11-CONVERSION-S5-CLOSE-2026-06-02.md).
  # --ignore-certificate-errors stays (staging cert expired); axe stays over http (http-qa-axe.cjs).
  https_base="https://${BASE#*://}"
  url="${https_base%/}${r}"
  f="$OUT/lh$(echo "$r" | tr '/' '_').json"
  CHROME_PATH="$CHROME" npx --yes lighthouse "$url" --quiet --preset=desktop \
    --only-categories=performance,accessibility,best-practices,seo \
    --chrome-flags="--headless --no-sandbox --ignore-certificate-errors" \
    --output=json --output-path="$f" >/dev/null 2>&1
  if [ -f "$f" ]; then
    python3 -c "
import json
d=json.load(open('$f'))['categories']
g=lambda k: round((d[k]['score'] or 0)*100) if k in d and d[k]['score'] is not None else '-'
print('%-18s %5s %5s %5s %5s' % ('$r', g('performance'), g('accessibility'), g('best-practices'), g('seo')))
"
  else
    printf "%-18s  (lighthouse failed)\n" "$r"
  fi
done
echo "(SEO/BP are staging-capped: noindex + HTTP -> 100 at production cutover)"
