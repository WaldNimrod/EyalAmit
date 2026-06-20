#!/usr/bin/env node
/** Wave-1 redirect probes — uses live mu-plugin map keys */
import { readFileSync, writeFileSync } from 'node:fs';

const BASE = 'http://eyalamit-co-il-2026.s887.upress.link';
const php = readFileSync('site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php', 'utf8');
const map = {};
for (const m of php.matchAll(/'([^']+)'\s*=>\s*'([^']+)'/g)) map[m[1]] = m[2];

const spotKeys = [
  '/צור-קשר/',
  '/דיגרידו-המרכז-לטיפול-בדיגרידו-סטודי/שיעורי-נגינה-בדיגרידו/',
  '/דיגרידו-המרכז-לטיפול-בדיגרידו-סטודי/תיקון-דיגרידו/',
  '/דיגרידו-המרכז-לטיפול-בדיגרידו-סטודי/סאונד-הילינג-דיגרידו-מדיטציית-דיגריד/',
  '/הופעות/',
  '/אייל-עמית-אודות/',
  '/מוזה-הוצאה-לאור/וכתבת-אוטוביוגרפיה-בסיפורים/',
  '/מוזה-הוצאה-לאור/',
];

async function chainFrom(path) {
  const hops = [];
  let url = BASE + encodeURI(path).replace(/%2F/g, '/');
  // path already Hebrew — use as-is on BASE
  url = BASE + path;
  for (let i = 0; i < 5; i++) {
    const res = await fetch(url, { redirect: 'manual' });
    const loc = res.headers.get('location');
    hops.push({ url, status: res.status, location: loc });
    if (![301, 302, 307, 308].includes(res.status) || !loc) break;
    url = new URL(loc, url).href;
  }
  return hops;
}

async function probePath(path, expectStatus, expectTarget, opts = {}) {
  const hops = await chainFrom(path);
  const first = hops[0];
  const final = hops[hops.length - 1];
  let pass = first.status === expectStatus;
  if (opts.noRedirect) {
    pass = hops.length === 1 && first.status === 200;
  } else if (expectTarget) {
    pass = pass && (first.location || '').includes(expectTarget);
  }
  if (path === '/מוזה-הוצאה-לאור/') {
    pass = pass && hops.length === 2 && final.status === 200 && !hops.some((h) => (h.location || '').includes('/muzza'));
  }
  return { hops, hopCount: hops.length - 1, pass, finalStatus: final.status };
}

const results = [];
results.push({ from: '/Blog/test-slug/', expected: '/blog/test-slug/', ...(await probePath('/Blog/test-slug/', 301, '/blog/test-slug/')) });
for (const key of spotKeys) {
  const expected = map[key];
  results.push({ from: key, expected, ...(await probePath(key, 301, expected)) });
}
results.push({ from: '/shop/', note: 'no redirect — live page', ...(await probePath('/shop/', 200, null, { noRedirect: true })) });

const out = {
  generatedAt: new Date().toISOString(),
  base: BASE,
  results,
  passCount: results.filter((r) => r.pass).length,
  failCount: results.filter((r) => !r.pass).length,
};
writeFileSync('_COMMUNICATION/team_50/evidence/wp-s004-wave1-2026-06-20/redirect-probes.json', JSON.stringify(out, null, 2));
for (const r of results) {
  console.log(`${r.pass ? 'PASS' : 'FAIL'} ${r.from} -> hops=${r.hopCount} final=${r.finalStatus}`);
}
process.exit(out.failCount ? 1 : 0);
