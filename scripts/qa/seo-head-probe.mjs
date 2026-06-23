#!/usr/bin/env node
/**
 * SEO head probe — meta description, og:description, canonical, og:image, Yoast @graph.
 * team_110 F110-01 evidence (2026-06-23).
 *
 * Usage:
 *   node scripts/qa/seo-head-probe.mjs [--base URL] [--out DIR] [/path/ ...]
 */
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const DEFAULT_BASE = 'http://eyalamit-co-il-2026.s887.upress.link';
const DEFAULT_ROUTES = [
  { name: 'book_vekatavta', path: '/books/vekatavta/' },
  { name: 'mokesh', path: '/eyal-amit/mokesh-dahiman/' },
  { name: 'en', path: '/en/' },
  { name: 'blog', path: '/blog/' },
];

function parseArgs(argv) {
  const opts = { base: DEFAULT_BASE, out: null, routes: [] };
  for (let i = 2; i < argv.length; i++) {
    if (argv[i] === '--base') opts.base = argv[++i];
    else if (argv[i] === '--out') opts.out = argv[++i];
    else opts.routes.push({ name: argv[i].replace(/\//g, '_'), path: argv[i] });
  }
  if (!opts.routes.length) opts.routes = DEFAULT_ROUTES;
  return opts;
}

function analyzeHtml(html) {
  const metaDesc = (html.match(/<meta[^>]+name=["']description["'][^>]*>/gi) || []).length;
  const ogDesc = (html.match(/<meta[^>]+property=["']og:description["'][^>]*>/gi) || []).length;
  const ogImage = (html.match(/<meta[^>]+property=["']og:image["'][^>]*>/gi) || []).length;
  const canonical = /<link[^>]+rel=["']canonical["'][^>]*>/i.test(html);
  const yoastGraph = /application\/ld\+json[^>]*>[\s\S]*?@graph/i.test(html);
  const canonMatch = html.match(/<link[^>]+rel=["']canonical["'][^>]+href=["']([^"']+)["']/i);
  return {
    metaDescriptionCount: metaDesc,
    ogDescriptionCount: ogDesc,
    ogImageCount: ogImage,
    canonicalPresent: canonical,
    canonical: canonMatch ? canonMatch[1] : null,
    yoastGraphPresent: yoastGraph,
  };
}

async function fetchRoute(base, routePath, nc) {
  const url = `${base.replace(/\/$/, '')}${routePath}?nc=${nc}`;
  const res = await fetch(url, { redirect: 'follow' });
  const html = await res.text();
  return {
    status: res.status,
    finalUrl: res.url,
    ...analyzeHtml(html),
  };
}

async function probeBlogLinks(base, nc) {
  const blogPages = ['/blog/', '/blog/page/2/'];
  const hrefs = new Set();
  for (const p of blogPages) {
    const url = `${base.replace(/\/$/, '')}${p}?nc=${nc}`;
    const res = await fetch(url);
    const html = await res.text();
    const re = /href=["']([^"']+)["']/gi;
    let m;
    while ((m = re.exec(html)) !== null) {
      const href = m[1];
      if (href.startsWith('http') && href.includes(new URL(base).host)) {
        try {
          const u = new URL(href);
          if (u.pathname !== '/blog/' && !u.pathname.startsWith('/blog/page/')) {
            hrefs.add(u.pathname + (u.search || ''));
          }
        } catch {
          /* skip */
        }
      } else if (href.startsWith('/') && !href.startsWith('/blog')) {
        hrefs.add(href.split('#')[0]);
      }
    }
  }
  const podcastSlugs = [
    '/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-2/',
    '/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa/',
  ];
  for (const s of podcastSlugs) hrefs.add(s);

  const checks = [];
  for (const pathname of hrefs) {
    if (!pathname || pathname === '/' || pathname.startsWith('/wp-') || pathname.startsWith('/contact')) continue;
    if (pathname.match(/\.(css|js|jpg|png|gif|svg|woff)/i)) continue;
    const url = `${base.replace(/\/$/, '')}${pathname}?nc=${nc}`;
    try {
      const res = await fetch(url, { method: 'HEAD', redirect: 'manual' });
      let status = res.status;
      let location = res.headers.get('location');
      if (status >= 300 && status < 400 && location) {
        const hop = await fetch(location.startsWith('http') ? location : `${base}${location}`, { method: 'HEAD' });
        status = hop.status;
      }
      checks.push({ pathname, status, ok: status === 200 || (status >= 300 && status < 400) });
    } catch (e) {
      checks.push({ pathname, status: null, ok: false, error: String(e.message || e) });
    }
  }
  const postLinks = checks.filter((c) => c.pathname.length > 10 && !c.pathname.startsWith('/books') && !c.pathname.startsWith('/treatment'));
  const failures = postLinks.filter((c) => !c.ok || c.status === 404);
  return { generatedAt: new Date().toISOString(), base, checkedCount: checks.length, failures, checks: postLinks };
}

async function main() {
  const opts = parseArgs(process.argv);
  const nc = `team110-${Date.now()}`;
  const results = [];
  for (const r of opts.routes) {
    const row = await fetchRoute(opts.base, r.path, nc);
    results.push({ name: r.name, path: r.path, ...row });
    console.log(
      `${r.path} status=${row.status} metaDesc=${row.metaDescriptionCount} ogDesc=${row.ogDescriptionCount} canonical=${row.canonicalPresent}`
    );
  }
  const seoOut = {
    generatedAt: new Date().toISOString(),
    base: opts.base,
    cacheBust: nc,
    note: 'F110-01 routes may show metaDescriptionCount=0 until wave2-w2-09.php is deployed to staging.',
    results,
  };
  const blogLinks = await probeBlogLinks(opts.base, nc);
  const outDir = opts.out || path.join(__dirname, 'reports');
  fs.mkdirSync(outDir, { recursive: true });
  fs.writeFileSync(path.join(outDir, 'seo_head_checks.json'), JSON.stringify(seoOut, null, 2));
  fs.writeFileSync(path.join(outDir, 'blog_link_checks.json'), JSON.stringify(blogLinks, null, 2));
  console.log(`Wrote ${outDir}/seo_head_checks.json`);
  console.log(`Wrote ${outDir}/blog_link_checks.json (${blogLinks.failures.length} failures)`);
  process.exit(blogLinks.failures.length === 0 ? 0 : 1);
}

main().catch((e) => {
  console.error(e);
  process.exit(2);
});
