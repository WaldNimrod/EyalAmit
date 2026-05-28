#!/usr/bin/env bash
# ============================================================
# blog-import.sh — WP-W2-06 Blog Migration Import Script
# Team 10 | 2026-05-28
#
# Imports 54 legacy blog posts from blog-legacy.wxr into the
# new WordPress site via WP-CLI.
#
# Usage (run from repo root or with --path):
#   bash scripts/blog-import.sh [--wp-path /path/to/wp]
#
# Prerequisites:
#   - wp-cli installed and on PATH
#   - WordPress installed at WP_PATH
#   - blog-legacy.wxr in site/exports/
#   - wordpress-importer plugin active (wp plugin install wordpress-importer --activate)
# ============================================================

set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
WXR_FILE="${REPO_ROOT}/site/exports/blog-legacy.wxr"

# Allow overriding WP path via argument
WP_PATH="${WP_PATH:-}"
if [[ $# -ge 1 && "$1" == "--wp-path" && $# -ge 2 ]]; then
  WP_PATH="$2"
fi

WP_CMD="wp"
if [[ -n "${WP_PATH}" ]]; then
  WP_CMD="wp --path=${WP_PATH}"
fi

echo "======================================================"
echo " WP-W2-06 Blog Migration — wp import"
echo " WXR:     ${WXR_FILE}"
echo " WP path: ${WP_PATH:-'(default)'}"
echo "======================================================"

# ── 0. Preflight checks ───────────────────────────────────
echo ""
echo "[0] Preflight checks..."

if [[ ! -f "${WXR_FILE}" ]]; then
  echo "ERROR: WXR file not found: ${WXR_FILE}" >&2
  exit 1
fi

if ! command -v wp &>/dev/null; then
  echo "ERROR: wp-cli not found on PATH" >&2
  exit 1
fi

# Ensure wordpress-importer is active
echo "    Checking wordpress-importer plugin..."
if ! ${WP_CMD} plugin is-active wordpress-importer 2>/dev/null; then
  echo "    Installing and activating wordpress-importer..."
  ${WP_CMD} plugin install wordpress-importer --activate
else
  echo "    wordpress-importer is active."
fi

# ── 1. Import WXR ─────────────────────────────────────────
echo ""
echo "[1] Importing ${WXR_FILE}..."
${WP_CMD} import "${WXR_FILE}" \
  --authors=mapping \
  --skip=image_resize \
  --user=1

echo ""
echo "[1] Import complete."

# ── 2. Author mapping fallback (create-if-missing) ────────
# If --authors=mapping fails interactively, use create instead:
# ${WP_CMD} import "${WXR_FILE}" --authors=create --skip=image_resize

# ── 3. Post-import verification ───────────────────────────
echo ""
echo "[2] Post-import counts..."

echo ""
echo "--- Categories ---"
${WP_CMD} term list category \
  --fields=term_id,name,slug,count \
  --format=table

echo ""
echo "--- Tags ---"
${WP_CMD} term list post_tag \
  --fields=term_id,name,slug,count \
  --format=table

echo ""
echo "[3] Published blog posts (expect 54)..."
${WP_CMD} post list \
  --post_type=post \
  --post_status=publish \
  --fields=ID,post_name,post_title \
  --format=csv \
  --orderby=ID \
  --order=ASC

echo ""
POST_COUNT=$(${WP_CMD} post list \
  --post_type=post \
  --post_status=publish \
  --format=count 2>/dev/null || echo "?")

echo "======================================================"
echo " RESULT: ${POST_COUNT} published posts found (expected 54)"
if [[ "${POST_COUNT}" == "54" ]]; then
  echo " STATUS: PASS"
else
  echo " STATUS: WARN — count mismatch; check for duplicates or failures"
fi
echo "======================================================"
echo ""
echo "Next steps:"
echo "  - Review posts with shortcodes (20 posts) — see W2-06-IMPORT-PREP report"
echo "  - Update post permalinks: wp rewrite flush --hard"
echo "  - Verify category assignments match legacy categories"
echo "  - Remove or convert legacy shortcodes before going live"
