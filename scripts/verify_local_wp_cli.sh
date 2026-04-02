#!/usr/bin/env bash
# אימות שתמונת Docker המקומית כוללת WP-CLI (Q3 תשתית — צוות 50).
# מריץ build (שכבת wordpress) ואז בודק wp --info בתוך קונטיינר חד-פעמי — בלי DB.
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT/local"

echo "==> docker compose build wordpress"
docker compose build wordpress

echo "==> WP-CLI inside image (must print version)"
docker compose run --rm --no-deps wordpress /usr/bin/wp --info --allow-root

echo "OK: WP-CLI verified in local WordPress image."
echo "Tip: after pull, run: docker compose up -d --force-recreate wordpress"
echo "Q3 full check from local/: docker compose exec wordpress /usr/bin/wp --path=/var/www/html --allow-root cli info"
