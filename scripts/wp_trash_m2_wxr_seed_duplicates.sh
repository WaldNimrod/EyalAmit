#!/usr/bin/env bash
# Remove duplicate pages created by importing site/exports/m2-pages-seed.wxr on top of an
# existing M2 database. Those posts use fixed IDs 500–524 (see scripts/m2_emit_pages_wxr.py).
#
# Preconditions:
#   - page_on_front must NOT be one of 500–524.
#   - Run from repo root, with Docker stack in local/ (see local/README.md).
#
# Usage:
#   bash scripts/wp_trash_m2_wxr_seed_duplicates.sh

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
COMPOSE="$ROOT/local/docker-compose.yml"
WP=(docker compose -f "$COMPOSE" exec -T wordpress /usr/bin/wp --path=/var/www/html --allow-root)

if ! "${WP[@]}" core is-installed 2>/dev/null; then
  echo "WordPress not installed in local Docker. Start: cd local && docker compose up -d" >&2
  exit 1
fi

front="$("${WP[@]}" option get page_on_front 2>/dev/null || true)"
if [[ -n "$front" && "$front" != "0" ]]; then
  if [[ "$front" -ge 500 && "$front" -le 524 ]]; then
    echo "Refusing: page_on_front is $front (inside WXR seed range). Reassign front page first." >&2
    exit 1
  fi
fi

ids=(500 501 502 503 504 505 506 507 508 509 510 511 512 513 514 515 516 517 518 519 520 521 522 523 524)
echo "Trashing WXR seed duplicate pages: ${ids[*]}"
for id in "${ids[@]}"; do
  if "${WP[@]}" post get "$id" --field=ID &>/dev/null; then
    "${WP[@]}" post delete "$id" || true
    echo "  trashed $id"
  else
    echo "  skip $id (not found)"
  fi
done

echo "Done. To delete permanently: wp post list --post_status=trash --field=ID | xargs wp post delete --force"
