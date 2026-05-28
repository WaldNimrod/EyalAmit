#!/usr/bin/env bash
# verify-301-blog.sh — W2-06 Blog 301 Redirect Verification
# Tests 3 sample /Blog/ URLs against the uPress staging environment.
# Usage: bash scripts/verify-301-blog.sh [STAGING_URL]
# Default staging URL: https://eyalamit-co-il-2026.s887.upress.link

set -euo pipefail

STAGING="${1:-https://eyalamit-co-il-2026.s887.upress.link}"
PASS_COUNT=0
FAIL_COUNT=0

# Sample URLs — one from each range (first, middle, last legacy post slugs)
declare -a TEST_PATHS=(
  "/Blog/18-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9e%d7%a1%d7%9a-%d7%94%d7%91%d7%a8%d7%96%d7%9c/"
  "/Blog/%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-15-11-14-%d7%91%d7%aa/"
  "/Blog/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-2/"
)

echo "======================================================"
echo "W2-06 Blog 301 Redirect Verification"
echo "Staging: ${STAGING}"
echo "======================================================"
echo ""

for path in "${TEST_PATHS[@]}"; do
  url="${STAGING}${path}"
  echo "Testing: ${url}"

  # Fetch headers only, follow no redirects, timeout 10s
  response=$(curl --silent --head --max-time 10 --write-out "\n%{http_code}" \
    --header "User-Agent: W2-06-verify/1.0" \
    "${url}" 2>&1) || {
    echo "  ERROR: curl failed (network error or timeout)"
    echo "  FAIL"
    FAIL_COUNT=$((FAIL_COUNT + 1))
    echo ""
    continue
  }

  http_code=$(echo "${response}" | tail -n1)
  location=$(echo "${response}" | grep -i "^location:" | head -n1 | tr -d '\r')

  if [[ "${http_code}" == "301" ]]; then
    echo "  HTTP: ${http_code}"
    echo "  Location: ${location}"
    # Verify Location contains /blog/ (lowercase)
    if echo "${location}" | grep -qi "/blog/"; then
      echo "  PASS — 301 redirect to /blog/ confirmed"
      PASS_COUNT=$((PASS_COUNT + 1))
    else
      echo "  FAIL — 301 received but Location does not contain /blog/"
      FAIL_COUNT=$((FAIL_COUNT + 1))
    fi
  else
    echo "  HTTP: ${http_code} (expected 301)"
    echo "  FAIL — unexpected status code"
    FAIL_COUNT=$((FAIL_COUNT + 1))
  fi
  echo ""
done

echo "======================================================"
echo "Results: ${PASS_COUNT} PASS / ${FAIL_COUNT} FAIL"
echo "======================================================"

if [[ "${FAIL_COUNT}" -gt 0 ]]; then
  exit 1
fi
