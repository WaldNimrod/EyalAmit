#!/usr/bin/env node
/**
 * team_190 WP-W2-16 final validate — HTTP-only probes (no site mutation).
 *
 * Probes:
 * - Redirect chains (single-hop, no loops) for legacy URLs
 * - /eyal-amit canonical tag points to /eyal-amit/
 * - Internal nav/link presence for /eyal-amit on home
 * - Blog pagination /blog/page/2/ returns 200 and has distinct post permalinks
 * - Staging theme version fingerprint (best-effort string presence)
 *
 * Usage:
 *   node _COMMUNICATION/team_190/evidence/wp-w2-16-final-validate-2026-06-16/http/http_probes.cjs
 *   EA_QA_BASE=http://... node .../http_probes.cjs
 */
const fs = require('fs');
const path = require('path');
const http = require('http');
const https = require('https');

const BASE = process.env.EA_QA_BASE || 'http://eyalamit-co-il-2026.s887.upress.link';

function fetchUrl(url) {
  return new Promise((resolve, reject) => {
    const lib = url.startsWith('https:') ? https : http;
    const req = lib.get(
      url.replace(/^https:/, 'http:'),
      {
        timeout: 30000,
        rejectUnauthorized: false,
        headers: { 'User-Agent': 'team190-http-probes/1.0' },
      },
      (res) => {
        let body = '';
        res.on('data', (d) => (body += d));
        res.on('end', () =>
          resolve({
            url,
            status: res.statusCode || null,
            headers: res.headers || {},
            body,
          })
        );
      }
    );
    req.on('error', (e) => reject(e));
    req.on('timeout', () => {
      req.destroy();
      reject(new Error('timeout'));
    });
  });
}

async function redirectChain(startUrl, maxHops = 8) {
  const chain = [];
  let url = startUrl;
  for (let i = 0; i < maxHops; i++) {
    // eslint-disable-next-line no-await-in-loop
    const r = await fetchUrl(url);
    const loc = r.headers.location
      ? new URL(r.headers.location, url).href
      : null;
    chain.push({
      url,
      status: r.status,
      location: loc,
    });
    if ([301, 302, 307, 308].includes(r.status) && loc) {
      url = loc;
      continue;
    }
    break;
  }
  const final = chain[chain.length - 1] || null;
  const loop = chain
    .map((x) => x.url)
    .some((u, idx, arr) => arr.indexOf(u) !== idx);
  return { chain, final, loop };
}

function extractCanonicalHref(html) {
  const tag = html.match(/<link[^>]+rel=(["'])canonical\1[^>]*>/i);
  if (!tag) return null;
  const href = tag[0].match(/href=(["'])([^"']+)\1/i);
  return href ? href[2] : null;
}

function hasHrefSubstring(html, needle) {
  return String(html).toLowerCase().includes(String(needle).toLowerCase());
}

function extractAllHrefs(html) {
  const re = /<a[^>]+href=(["'])([^"']+)\1/gi;
  const out = [];
  let m;
  while ((m = re.exec(String(html)))) out.push(m[2]);
  return out;
}

function extractBlogPostPermalinks(html) {
  const out = [];

  // Primary (current theme): <article class="ea-blog-card ..."> ... <a class="ea-blog-card__link" href="...">
  const doc = String(html);
  const reArticle =
    /<article\b[^>]*class=(["'])[^"']*ea-blog-card[^"']*\1[^>]*>([\s\S]*?)<\/article>/gi;
  let m;
  while ((m = reArticle.exec(doc))) {
    const block = m[2];
    const a1 = block.match(
      /<a\b[^>]*class=(["'])[^"']*ea-blog-card__link[^"']*\1[^>]*href=(["'])([^"']+)\2/i
    );
    const a2 = block.match(
      /<a\b[^>]*href=(["'])([^"']+)\1[^>]*class=(["'])[^"']*ea-blog-card__link[^"']*\3/i
    );
    const href = a1 ? a1[3] : a2 ? a2[2] : null;
    if (href) out.push(href);
  }

  // Fallback: WP block theme: <a class="wp-block-post-title__link" href="...">
  if (out.length === 0) {
    const reWp =
      /<a[^>]+class=(["'])[^"']*wp-block-post-title__link[^"']*\1[^>]+href=(["'])([^"']+)\2/gi;
    while ((m = reWp.exec(String(html)))) out.push(m[3]);
  }

  return out;
}

(async () => {
  const outDir = __dirname;
  const outPath = path.join(outDir, 'redirects-canonical-blog.json');

  const checks = {
    generatedAt: new Date().toISOString(),
    base: BASE,
    redirects: {},
    canonical: {},
    internalLinks: {},
    blogPage2: {},
    stagingVersion: {},
  };

  // --- Redirect probes (single-hop, no loops)
  const about = await redirectChain(BASE.replace(/\/$/, '') + '/about/');
  checks.redirects.about = about;

  const aboutMoksha = await redirectChain(
    BASE.replace(/\/$/, '') + '/about/moksha/'
  );
  checks.redirects.about_moksha = aboutMoksha;

  const mokeshOld1 = await redirectChain(
    BASE.replace(/\/$/, '') + '/mokesh-dahiman/'
  );
  checks.redirects.mokesh_dahiman = mokeshOld1;

  const mokeshOld2 = await redirectChain(BASE.replace(/\/$/, '') + '/mokesh/');
  checks.redirects.mokesh = mokeshOld2;

  // --- Canonical on /eyal-amit/
  const eyal = await fetchUrl(BASE.replace(/\/$/, '') + '/eyal-amit/');
  checks.canonical.eyal_amit = {
    status: eyal.status,
    canonicalHref: extractCanonicalHref(eyal.body),
  };

  // --- Home has /eyal-amit in links (nav/internal anchor)
  const home = await fetchUrl(BASE.replace(/\/$/, '') + '/');
  const homeHrefs = extractAllHrefs(home.body);
  const homeEyal = homeHrefs
    .map((h) => {
      try { return new URL(h, BASE).href; } catch (_) { return null; }
    })
    .filter(Boolean)
    .filter((h) => new URL(h).pathname.startsWith('/eyal-amit'));
  checks.internalLinks.home = {
    hrefCount: homeHrefs.length,
    eyalAmitHrefCount: homeEyal.length,
    hasEyalAmit: homeEyal.length > 0,
    sample: homeEyal.slice(0, 8),
  };

  // --- Blog pagination page 2
  const blog2 = await fetchUrl(BASE.replace(/\/$/, '') + '/blog/page/2/');
  const blockTitleLinks = extractBlogPostPermalinks(blog2.body);
  const allBlogHrefs = extractAllHrefs(blog2.body)
    .map((h) => {
      try { return new URL(h, BASE).href; } catch (_) { return null; }
    })
    .filter(Boolean);
  const blogPostish = allBlogHrefs.filter((h) => {
    try {
      const u = new URL(h);
      if (!u.pathname.startsWith('/blog/')) return false;
      if (u.pathname.startsWith('/blog/page/')) return false;
      if (u.pathname === '/blog/' || u.pathname === '/blog') return false;
      return true;
    } catch (_) {
      return false;
    }
  });
  const links = blockTitleLinks.length ? blockTitleLinks : blogPostish;
  const uniq = Array.from(new Set(links.map((h) => new URL(h, BASE).href)));
  checks.blogPage2 = {
    status: blog2.status,
    postLinksFound: links.length,
    distinctPostLinks: uniq.length,
    distinct: uniq.length === links.length,
    usedSelector: blockTitleLinks.length > 0 ? 'ea-blog-card__link|wp-block-post-title__link' : 'fallback:/blog/* hrefs',
    sample: uniq.slice(0, 12),
  };

  // --- Best-effort: staging theme version fingerprint (1.4.13)
  const verNeedle = '1.4.13';
  checks.stagingVersion = {
    needle: verNeedle,
    homeContains: home.body.includes(verNeedle),
    eyalAmitContains: eyal.body.includes(verNeedle),
  };

  fs.mkdirSync(outDir, { recursive: true });
  fs.writeFileSync(outPath, JSON.stringify(checks, null, 2));

  console.log(
    JSON.stringify(
      {
        out: outPath,
        aboutFinal: about.final,
        aboutMokshaFinal: aboutMoksha.final,
        canonical: checks.canonical.eyal_amit,
        blogPage2: checks.blogPage2,
        homeLinks: checks.internalLinks.home,
      },
      null,
      2
    )
  );
  process.exit(0);
})().catch((e) => {
  console.error('FATAL:', e);
  process.exit(2);
});

