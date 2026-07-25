#!/usr/bin/env node
/**
 * AEO-focused JSON-LD + DOM signal matrix (fast). Complements seo_probe.mjs
 * which HEADs every sitemap URL and can take many minutes on staging.
 */
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const BASE = process.argv[2] || 'http://eyalamit-co-il-2026.s887.upress.link';
const OUT =
  process.argv[3] ||
  path.resolve(__dirname, '../../_COMMUNICATION/team_100/evidence/aeo-deep-audit-2026-07-25/jsonld_matrix.json');

const ROUTES = [
  '/',
  '/treatment/',
  '/sound-healing/',
  '/lessons/',
  '/method/',
  '/faq/',
  '/eyal-amit/',
  '/snoring-sleep-apnea/',
  '/books/vekatavta/',
  '/didgeridoos/',
];

function extractYoastGraph(html) {
  let m = html.match(
    /<script[^>]+type=["']application\/ld\+json["'][^>]*class=["']yoast-schema-graph["'][^>]*>([\s\S]*?)<\/script>/i
  );
  if (!m) {
    m = html.match(
      /<script[^>]+class=["']yoast-schema-graph["'][^>]+type=["']application\/ld\+json["'][^>]*>([\s\S]*?)<\/script>/i
    );
  }
  if (!m) return { error: 'no yoast graph', types: [], nodes: [] };
  try {
    const parsed = JSON.parse(m[1].trim());
    const graph = Array.isArray(parsed['@graph']) ? parsed['@graph'] : [];
    const types = new Set();
    for (const n of graph) {
      const t = n['@type'];
      if (Array.isArray(t)) t.forEach((x) => types.add(x));
      else if (t) types.add(t);
    }
    return { error: null, types: [...types].sort(), nodes: graph, raw: parsed };
  } catch (e) {
    return { error: String(e.message || e), types: [], nodes: [] };
  }
}

function findBiz(graph) {
  return graph.find((n) => n['@type'] === 'ProfessionalService') || null;
}

function domSignals(html) {
  const faqDetails = (html.match(/<details[^>]*class=["'][^"']*ea-faq/gi) || []).length;
  const faqBlock = /ea-faq|faqblock|block-faq/i.test(html);
  const h1 = [...html.matchAll(/<h1[^>]*>([\s\S]*?)<\/h1>/gi)].map((m) =>
    m[1].replace(/<[^>]+>/g, '').trim()
  );
  const h2 = [...html.matchAll(/<h2[^>]*>([\s\S]*?)<\/h2>/gi)]
    .map((m) => m[1].replace(/<[^>]+>/g, '').trim())
    .slice(0, 12);
  const metaDesc = [...html.matchAll(/<meta[^>]+name=["']description["'][^>]+content=["']([^"']*)["']/gi)].map(
    (m) => m[1]
  );
  const ogImage = [...html.matchAll(/<meta[^>]+property=["']og:image["'][^>]+content=["']([^"']+)["']/gi)].map(
    (m) => m[1]
  );
  const noindex = /noindex/i.test(html.match(/<meta[^>]+name=["']robots["'][^>]*>/i)?.[0] || '');
  // First substantial paragraph after body open (rough)
  const firstP = (html.match(/<main[\s\S]{0,8000}?<p[^>]*>([\s\S]*?)<\/p>/i) || [])[1] || '';
  const answerLead = firstP.replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim().slice(0, 280);
  const pending = (html.match(/ea-pending-approval/g) || []).length;
  const phoneHits = [...html.matchAll(/0\d{1,2}[-\s]?\d{3}[-\s]?\d{4}/g)].map((m) => m[0]);
  const napFooter =
    html.match(/ea-nap|footer[\s\S]{0,2000}?פרדס חנה|עמל/i)?.[0]?.slice(0, 200) || null;
  return {
    h1,
    h2Sample: h2,
    faqDetailsCount: faqDetails,
    faqBlockSignal: faqBlock,
    metaDescCount: metaDesc.length,
    metaDesc,
    ogImageCount: ogImage.length,
    ogImage,
    noindex,
    answerLead,
    pendingMarkers: pending,
    phoneHits: [...new Set(phoneHits)].slice(0, 8),
    napFooterSnippet: napFooter,
  };
}

async function probe(pathName) {
  const url = `${BASE.replace(/\/$/, '')}${pathName}?nc=aeo-${Date.now()}`;
  const res = await fetch(url, { redirect: 'follow' });
  const html = await res.text();
  const graph = extractYoastGraph(html);
  const biz = findBiz(graph.nodes);
  const areaServed = biz?.areaServed || null;
  const faqNode = graph.nodes.find((n) => n['@type'] === 'FAQPage');
  const faqQCount = faqNode?.mainEntity?.length || 0;
  const dom = domSignals(html);
  const faqPageExpected = dom.faqBlockSignal || dom.faqDetailsCount > 0;
  const faqPagePresent = graph.types.includes('FAQPage');
  return {
    path: pathName,
    status: res.status,
    types: graph.types,
    graphError: graph.error,
    areaServed,
    geoCircle: areaServed?.['@type'] === 'GeoCircle',
    faqQCount,
    faqPagePresent,
    faqVisibleLikely: faqPageExpected,
    faqSchemaMatchesVisible:
      faqPageExpected === faqPagePresent || (!faqPageExpected && !faqPagePresent),
    prohibitions: {
      aggregateRating: /AggregateRating/i.test(html),
      areaServedIsrael: /"areaServed"\s*:\s*"Israel"/i.test(html),
      healthAndBeauty: /HealthAndBeautyBusiness/i.test(html),
    },
    dom,
  };
}

const results = [];
for (const r of ROUTES) {
  process.stderr.write(`probe ${r}\n`);
  try {
    results.push(await probe(r));
  } catch (e) {
    results.push({ path: r, error: String(e.message || e) });
  }
}

// Host-level quick checks
const robots = await (await fetch(`${BASE}/robots.txt`)).text();
const sitemapIdx = await (await fetch(`${BASE}/sitemap_index.xml`)).text();
const childLocs = [...sitemapIdx.matchAll(/<loc>([^<]+)<\/loc>/gi)].map((m) => m[1]);

const report = {
  generatedAt: new Date().toISOString(),
  base: BASE,
  host: {
    robotsTxt: robots.trim(),
    sitemapChildCount: childLocs.length,
    sitemapChildren: childLocs,
  },
  routes: results,
};

fs.mkdirSync(path.dirname(OUT), { recursive: true });
fs.writeFileSync(OUT, JSON.stringify(report, null, 2));
console.log(`Wrote ${OUT}`);
const gaps = results.filter(
  (r) =>
    r.error ||
    (r.faqVisibleLikely && !r.faqPagePresent) ||
    (r.path === '/snoring-sleep-apnea/' && !r.faqPagePresent) ||
    (r.path === '/' && !r.geoCircle)
);
console.log(`gap_candidates=${gaps.length}`);
for (const g of gaps) {
  console.log(`  ${g.path}: faqVis=${g.faqVisibleLikely} faqSchema=${g.faqPagePresent} geo=${g.geoCircle} types=${JSON.stringify(g.types)}`);
}
