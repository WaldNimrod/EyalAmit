#!/usr/bin/env node
/** Focused blog archive permalink GET checks (F110-03 evidence). */
import fs from 'node:fs';

const base = 'http://eyalamit-co-il-2026.s887.upress.link';
const nc = `team110-${Date.now()}`;
const extra = [
  '/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-2/',
  '/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa/',
];

const hrefs = new Set(extra.map((s) => base.replace(/\/$/, '') + s));
for (const p of ['/blog/', '/blog/page/2/']) {
  const res = await fetch(`${base}${p}?nc=${nc}`, { signal: AbortSignal.timeout(60000) });
  const html = await res.text();
  const re = /<a[^>]*class="ea-blog-card__link"[^>]*href="([^"]+)"|<a[^>]*href="([^"]+)"[^>]*class="ea-blog-card__link"/g;
  let m;
  while ((m = re.exec(html))) {
    const href = (m[1] || m[2]).split('#')[0].split('?')[0];
    hrefs.add(href.startsWith('http') ? href : base.replace(/\/$/, '') + href);
  }
}

const results = [];
for (const href of hrefs) {
  const url = `${href}?nc=${nc}`;
  try {
    const res = await fetch(url, { signal: AbortSignal.timeout(60000) });
    results.push({ href, status: res.status, ok: res.status === 200 });
    console.log(res.status, href);
  } catch (e) {
    results.push({ href, status: null, ok: false, error: String(e.message || e) });
    console.log('ERR', href, e.message);
  }
}

const failures = results.filter((r) => !r.ok);
const out = {
  generatedAt: new Date().toISOString(),
  base,
  method: 'GET',
  archivePermalinkCount: results.length,
  failures,
  results,
  verdict: failures.length === 0 ? 'PASS' : 'FAIL',
};
const outPath =
  '_COMMUNICATION/team_110/evidence/chapters-fullsite-fixround-2026-06-23/seo/blog_archive_permalink_checks.json';
fs.writeFileSync(outPath, JSON.stringify(out, null, 2));
console.log(`Wrote ${outPath} — ${failures.length} failures`);
process.exit(failures.length === 0 ? 0 : 1);
