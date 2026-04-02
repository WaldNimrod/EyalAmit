#!/usr/bin/env bash
# M2 G2 — אימות ארטיפקטי מאגר לפני/אחרי פריסה לסטייג'ינג.
# יציאה 0 = הכל קיים ותחביר PHP תקין.
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

ok=0
fail() { echo "FAIL: $*" >&2; ok=1; }

[[ -f site/wp-content/themes/ea-eyalamit/style.css ]] || fail "missing child style.css"
[[ -f site/wp-content/themes/ea-eyalamit/functions.php ]] || fail "missing child functions.php"
grep -q 'Template: generatepress' site/wp-content/themes/ea-eyalamit/style.css || fail "child must declare Template: generatepress"
[[ -f site/wp-content/mu-plugins/ea-staging-noindex.php ]] || fail "missing mu-plugin ea-staging-noindex.php"
[[ -f site/wp-content/mu-plugins/ea-m2-auto-activate-child.php ]] || fail "missing mu-plugin ea-m2-auto-activate-child.php"
[[ -f site/wp-content/mu-plugins/ea-m2-ensure-fluent-active.php ]] || fail "missing mu-plugin ea-m2-ensure-fluent-active.php"
[[ -f site/wp-content/mu-plugins/ea-m2-seed-shell-once.php ]] || fail "missing mu-plugin ea-m2-seed-shell-once.php"
[[ -f site/exports/m2-pages-seed.wxr ]] || fail "missing m2-pages-seed.wxr"

if command -v php >/dev/null 2>&1; then
  php -l site/wp-content/themes/ea-eyalamit/functions.php >/dev/null || fail "PHP lint functions.php"
  php -l site/wp-content/mu-plugins/ea-staging-noindex.php >/dev/null || fail "PHP lint ea-staging-noindex.php"
  php -l site/wp-content/mu-plugins/ea-m2-auto-activate-child.php >/dev/null || fail "PHP lint ea-m2-auto-activate-child.php"
  php -l site/wp-content/mu-plugins/ea-m2-ensure-fluent-active.php >/dev/null || fail "PHP lint ea-m2-ensure-fluent-active.php"
  php -l site/wp-content/mu-plugins/ea-m2-seed-shell-once.php >/dev/null || fail "PHP lint ea-m2-seed-shell-once.php"
else
  echo "WARN: php CLI not found — skip php -l" >&2
fi

if [[ "$ok" -ne 0 ]]; then
  exit 1
fi
echo "OK: M2 G2 repo artifacts verified under site/"
