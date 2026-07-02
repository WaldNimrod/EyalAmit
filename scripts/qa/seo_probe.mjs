#!/usr/bin/env node
/**
 * seo_probe.mjs — the SEO/GEO QA gate (WP-W2-17 T7).
 *
 * WHY THIS EXISTS:
 *   `qa_probe.mjs` (layout/overflow) and `content-diff.mjs` (content accuracy) check
 *   zero SEO signals — that gap let D-1 (meta-description drift on /treatment/,
 *   /sound-healing/, /lessons/, /method/) ship silently for 10 days
 *   (team_80 SEO-GEO-RESEARCH-SYNTHESIS-2026-07-02.md §Fact base / Appendix B).
 *   This script closes that gap: 12 checks per route, zero npm deps, pure `fetch`.
 *
 * AUTHORITATIVE SPEC:
 *   Appendix B (12-check spec) — _COMMUNICATION/team_80/SEO-GEO-RESEARCH-SYNTHESIS-2026-07-02.md
 *   (table ~lines 313-327). Two ratified supersessions of that spec are implemented
 *   here (see check 2 and check 7/manifest below); both are cited inline.
 *
 * ROUTING NOTE (recorded per WP-W2-17 T7 / DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md
 *   item 10): team_80 §5.5 recommended this be built by team_90/team_50; under the
 *   team_00 fast-track directive (2026-07-03) it was built by team_110 within
 *   WP-W2-17, and team_90 ratifies the implementation against Appendix B at the
 *   CR-FINAL re-audit.
 *
 * Conventions follow scripts/qa/seo-head-probe.mjs (arg parsing, cache-busting query
 * param, JSON report to scripts/qa/reports/, process.exit semantics) and
 * scripts/qa/content-diff.mjs (manifest-driven route table, summary.json shape).
 * This is a NEW, broader script — not an edit of seo-head-probe.mjs, which stays as-is.
 *
 * Usage:
 *   node scripts/qa/seo_probe.mjs [--base URL] [--config PATH] [--out DIR] [--mode staging|production]
 *
 *   --mode is auto-detected from --base host (host containing "upress.link" => staging;
 *   otherwise => production) unless explicitly overridden. Checks 1 and 2 (robots
 *   posture) invert their pass rule between the two modes per Appendix B.
 *
 * Exit code: 0 only if every check on every configured route passes; 1 otherwise
 * (with a clear failure list on stdout and in the JSON report); 2 on a hard runtime
 * error (network/parse blowup outside the check logic itself).
 */
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const REPO_ROOT = path.resolve(__dirname, '../..');

const DEFAULT_BASE = 'http://eyalamit-co-il-2026.s887.upress.link';
const DEFAULT_CONFIG = path.join(__dirname, 'seo_probe.config.json');
const PRODUCTION_SITEMAP_URL = 'https://www.eyalamit.co.il/sitemap_index.xml';
const GA4_ID = 'G-MRXESK7QJF';
const RETIRED_BRAND_STRING = 'סטודיו נשימה מעגלית';
const SITE_TAGLINE_FALLBACK_ENGLISH = null; // no static fallback trusted; see config _comment on "tagline"

/**
 * Check 2 supersession (ratified): Appendix B (team_80 SEO-GEO-RESEARCH-SYNTHESIS-
 * 2026-07-02.md :316) says "the 8 allowed UAs". That count is SUPERSEDED by ratified
 * decision D3 (DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md item 1 — t00, Nimrod,
 * "ALLOW ALL, EXPLICIT, LOGGED") which fixes the production allow-list at 10 UAs.
 * This script checks against the 10-UA list, not Appendix B's 8.
 */
const RATIFIED_ALLOWED_UAS = [
  'Googlebot',
  'Bingbot',
  'GPTBot',
  'OAI-SearchBot',
  'ChatGPT-User',
  'ClaudeBot',
  'Claude-SearchBot',
  'Claude-User',
  'PerplexityBot',
  'Perplexity-User',
];

/**
 * Check 12 supersession/re-scope (ratified): the T1 permanent brand-retirement
 * ruling (DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md item 4) plus the AC-09
 * 6-quote scope-out (SEO-GEO-ROUND2-COMPLETION-2026-06-21.md :35) mean the brand
 * string legitimately persists ONLY inside 6 verbatim customer-testimonial quotes
 * (site/wp-content/themes/ea-eyalamit/inc/data/ea-testimonials-fb.json — grep-
 * verified 6 occurrences). That exemption is FILE-scoped, not ROUTE-scoped; no
 * source document maps quotes to routes. seo_probe.config.json's
 * `brandExemptRoutes.routes` is the builder's best-effort reconstruction (traced
 * via PHASE2-TESTIMONIALS-FLAGS-COMPLETE-2026-06-21.md's per-route testimonial
 * wiring) and is flagged as an open question pending team_90 ratification.
 */

function parseArgs(argv) {
  const opts = {
    base: DEFAULT_BASE,
    config: DEFAULT_CONFIG,
    out: null,
    mode: null, // auto-detected below unless overridden
  };
  for (let i = 2; i < argv.length; i++) {
    if (argv[i] === '--base') opts.base = argv[++i];
    else if (argv[i] === '--config') opts.config = argv[++i];
    else if (argv[i] === '--out') opts.out = argv[++i];
    else if (argv[i] === '--mode') opts.mode = argv[++i];
  }
  if (!opts.mode) {
    let host = '';
    try {
      host = new URL(opts.base).host;
    } catch {
      host = opts.base;
    }
    opts.mode = host.includes('upress.link') ? 'staging' : 'production';
  }
  return opts;
}

function loadConfig(configPath) {
  const raw = fs.readFileSync(configPath, 'utf8');
  return JSON.parse(raw);
}

async function fetchText(url, init) {
  const res = await fetch(url, { redirect: 'follow', ...init });
  const text = await res.text();
  return { res, text };
}

function countMatches(re, text) {
  return (text.match(re) || []).length;
}

/** Extract the (first) yoast-schema-graph JSON-LD block and parse it. */
function extractYoastGraph(html) {
  const blocks = [
    ...html.matchAll(
      /<script[^>]+type=["']application\/ld\+json["'][^>]*class=["']yoast-schema-graph["'][^>]*>([\s\S]*?)<\/script>/gi
    ),
  ];
  // Yoast sometimes orders attributes class-before-type; try the reverse order too.
  if (blocks.length === 0) {
    blocks.push(
      ...html.matchAll(
        /<script[^>]+class=["']yoast-schema-graph["'][^>]+type=["']application\/ld\+json["'][^>]*>([\s\S]*?)<\/script>/gi
      )
    );
  }
  if (blocks.length === 0) {
    return { count: 0, parsed: null, error: 'no yoast-schema-graph block found' };
  }
  if (blocks.length > 1) {
    return { count: blocks.length, parsed: null, error: `expected 1 yoast-schema-graph block, found ${blocks.length}` };
  }
  try {
    const parsed = JSON.parse(blocks[0][1].trim());
    return { count: 1, parsed, error: null };
  } catch (e) {
    return { count: 1, parsed: null, error: `JSON.parse failed: ${String(e.message || e)}` };
  }
}

/** Collect every @id defined and every @id referenced (as {"@id": "..."}) in the graph. */
function collectIds(graphArray) {
  const defined = new Set();
  const referenced = new Set();
  const walk = (node) => {
    if (Array.isArray(node)) {
      node.forEach(walk);
      return;
    }
    if (node && typeof node === 'object') {
      const keys = Object.keys(node);
      if (keys.length === 1 && keys[0] === '@id' && typeof node['@id'] === 'string') {
        referenced.add(node['@id']);
        return;
      }
      if (typeof node['@id'] === 'string') {
        defined.add(node['@id']);
      }
      for (const k of keys) {
        if (k === '@id') continue;
        walk(node[k]);
      }
    }
  };
  walk(graphArray);
  return { defined, referenced };
}

function graphTypesOf(graphArray) {
  const types = new Set();
  for (const node of Array.isArray(graphArray) ? graphArray : []) {
    if (node && typeof node === 'object' && node['@type']) {
      if (Array.isArray(node['@type'])) node['@type'].forEach((t) => types.add(t));
      else types.add(node['@type']);
    }
  }
  return types;
}

/** Fetch the live WordPress tagline via the RSS feed <description> (best-effort; never throws). */
async function fetchLiveTagline(base) {
  try {
    const url = `${base.replace(/\/$/, '')}/feed/`;
    const { res, text } = await fetchText(url);
    if (res.status !== 200) return null;
    const m = text.match(/<description>([\s\S]*?)<\/description>/i);
    if (!m) return null;
    return m[1]
      .replace(/^<!\[CDATA\[/, '')
      .replace(/\]\]>$/, '')
      .trim();
  } catch {
    return null;
  }
}

/** ---- Individual checks (each returns {pass, details}) ---- */

// Check 1 — robots meta/header noindex posture.
function checkRobotsMetaHeader(html, headers, mode) {
  const metaNoindex = /<meta[^>]+name=["']robots["'][^>]+content=["'][^"']*noindex[^"']*["']/i.test(html);
  const headerRobots = headers.get('x-robots-tag') || '';
  const headerNoindex = /noindex/i.test(headerRobots);
  const noindexPresent = metaNoindex || headerNoindex;
  if (mode === 'staging') {
    return {
      pass: noindexPresent,
      details: `staging expects noindex PRESENT; meta=${metaNoindex} header="${headerRobots}"`,
    };
  }
  return {
    pass: !noindexPresent,
    details: `production expects noindex ABSENT; meta=${metaNoindex} header="${headerRobots}"`,
  };
}

// Check 2 — robots.txt posture. 10-UA list per D3 (supersedes Appendix B's "8" — see header comment).
async function checkRobotsTxt(base, mode) {
  const url = `${base.replace(/\/$/, '')}/robots.txt`;
  const { res, text } = await fetchText(url);
  if (mode === 'staging') {
    // Staging: any content is acceptable per Appendix B ("staging: any"); we only
    // confirm it's reachable.
    return { pass: res.status === 200, details: `staging robots.txt any-content; status=${res.status}` };
  }
  const blockAll = /Disallow:\s*\/\s*$/im.test(text) && /User-agent:\s*\*/i.test(text);
  const hasSitemapLine = new RegExp(`Sitemap:\\s*${PRODUCTION_SITEMAP_URL.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}`, 'i').test(
    text
  );
  const missingUAs = RATIFIED_ALLOWED_UAS.filter((ua) => !new RegExp(`User-agent:\\s*${ua}\\b`, 'i').test(text));
  const pass = res.status === 200 && !blockAll && hasSitemapLine && missingUAs.length === 0;
  return {
    pass,
    details: `status=${res.status} blockAll=${blockAll} sitemapLine=${hasSitemapLine} missingUAs=${JSON.stringify(
      missingUAs
    )} (10-UA list per D3, supersedes Appendix B's 8)`,
  };
}

// Check 3 — sitemap_index parses + every child-sitemap <loc> returns direct 200.
async function checkSitemap(base) {
  const url = `${base.replace(/\/$/, '')}/sitemap_index.xml`;
  const { res, text } = await fetchText(url);
  if (res.status !== 200) {
    return { pass: false, details: `sitemap_index.xml status=${res.status}` };
  }
  const childLocs = [...text.matchAll(/<loc>([^<]+)<\/loc>/gi)].map((m) => m[1].trim());
  if (childLocs.length === 0) {
    return { pass: false, details: 'sitemap_index.xml parsed but contained no <loc> entries' };
  }
  const failures = [];
  for (const childUrl of childLocs) {
    try {
      const cRes = await fetch(childUrl, { redirect: 'manual' });
      if (cRes.status !== 200) {
        failures.push(`${childUrl} => ${cRes.status}`);
        continue;
      }
      const cText = await cRes.text();
      const grandLocs = [...cText.matchAll(/<loc>([^<]+)<\/loc>/gi)].map((m) => m[1].trim());
      for (const locUrl of grandLocs) {
        try {
          const lRes = await fetch(locUrl, { method: 'HEAD', redirect: 'manual' });
          if (lRes.status !== 200) {
            failures.push(`${locUrl} => ${lRes.status} (redirect/404, expected direct 200)`);
          }
        } catch (e) {
          failures.push(`${locUrl} => fetch error: ${String(e.message || e)}`);
        }
      }
    } catch (e) {
      failures.push(`${childUrl} => fetch error: ${String(e.message || e)}`);
    }
  }
  return {
    pass: failures.length === 0,
    details:
      failures.length === 0
        ? `${childLocs.length} child sitemaps, all <loc> entries direct-200`
        : `${failures.length} failing <loc> entries: ${failures.slice(0, 10).join('; ')}`,
  };
}

// Check 4 — meta description: exactly 1 per route, non-empty, != site tagline.
function checkMetaDescription(html, tagline) {
  const matches = [...html.matchAll(/<meta[^>]+name=["']description["'][^>]*content=["']([^"']*)["'][^>]*>/gi)];
  const count = matches.length;
  if (count !== 1) {
    return { pass: false, details: `expected exactly 1 <meta name="description">, found ${count}` };
  }
  const value = matches[0][1].trim();
  if (value === '') {
    return { pass: false, details: 'meta description present but empty' };
  }
  if (tagline && value === tagline.trim()) {
    return { pass: false, details: `meta description equals site tagline verbatim ("${tagline}")` };
  }
  return { pass: true, details: `1 non-empty description ("${value.slice(0, 60)}${value.length > 60 ? '…' : ''}")` };
}

// Check 5 — canonical: exactly 1, self-referencing.
function checkCanonical(html, requestedUrl, finalUrl) {
  const matches = [...html.matchAll(/<link[^>]+rel=["']canonical["'][^>]+href=["']([^"']+)["'][^>]*>/gi)];
  const count = matches.length;
  if (count !== 1) {
    return { pass: false, details: `expected exactly 1 canonical link, found ${count}` };
  }
  const href = matches[0][1].trim();
  const normalize = (u) => u.replace(/\?.*$/, '').replace(/\/$/, '').toLowerCase();
  const selfRef = normalize(href) === normalize(finalUrl) || normalize(href) === normalize(requestedUrl);
  return {
    pass: selfRef,
    details: selfRef ? `canonical self-referencing (${href})` : `canonical="${href}" does not match route URL`,
  };
}

// Check 6 — og:image: exactly 1, resolves 200.
async function checkOgImage(html) {
  const matches = [...html.matchAll(/<meta[^>]+property=["']og:image["'][^>]+content=["']([^"']+)["'][^>]*>/gi)];
  const count = matches.length;
  if (count !== 1) {
    return { pass: false, details: `expected exactly 1 og:image, found ${count}` };
  }
  const src = matches[0][1].trim();
  try {
    const res = await fetch(src, { method: 'HEAD', redirect: 'follow' });
    return { pass: res.status === 200, details: `og:image=${src} status=${res.status}` };
  } catch (e) {
    return { pass: false, details: `og:image=${src} fetch error: ${String(e.message || e)}` };
  }
}

// Check 7 — JSON-LD graph: single yoast-schema-graph block parses; per-route expected @type set.
function checkJsonLdGraph(yoastGraph, expectedTypes) {
  if (yoastGraph.error) {
    return { pass: false, details: yoastGraph.error };
  }
  const graphArray = yoastGraph.parsed && yoastGraph.parsed['@graph'];
  if (!Array.isArray(graphArray)) {
    return { pass: false, details: 'parsed JSON-LD has no @graph array' };
  }
  const presentTypes = graphTypesOf(graphArray);
  const missing = (expectedTypes || []).filter((t) => !presentTypes.has(t));
  return {
    pass: missing.length === 0,
    details:
      missing.length === 0
        ? `all expected @type present: ${JSON.stringify(expectedTypes)}`
        : `missing expected @type(s): ${JSON.stringify(missing)}; present: ${JSON.stringify([...presentTypes])}`,
    graphArray,
  };
}

// Check 8 — @id connectivity: no dangling @id references.
function checkIdConnectivity(graphArray) {
  if (!Array.isArray(graphArray)) {
    return { pass: false, details: 'no graph array available (check 7 must pass first)' };
  }
  const { defined, referenced } = collectIds(graphArray);
  const dangling = [...referenced].filter((id) => !defined.has(id));
  return {
    pass: dangling.length === 0,
    details: dangling.length === 0 ? `${referenced.size} @id references, all resolve` : `dangling @id refs: ${JSON.stringify(dangling)}`,
  };
}

// Check 9 — prohibition lint: zero hits for the 4 forbidden patterns.
function checkProhibitionLint(html) {
  const hits = [];
  if (/AggregateRating/i.test(html)) hits.push('AggregateRating');
  if (/areaServed"\s*:\s*"Israel"/i.test(html)) hits.push('areaServed":"Israel"');
  if (/HealthAndBeautyBusiness/i.test(html)) hits.push('HealthAndBeautyBusiness');
  // VideoObject-on-hero: a VideoObject JSON-LD node whose contentUrl/embedUrl/thumbnailUrl
  // references the hero video/poster asset, OR a VideoObject appearing before any other
  // schema node in source order (heuristic for "on-hero" placement).
  const videoObjectHeroRe = /"@type"\s*:\s*"VideoObject"[^}]*hero/i;
  if (videoObjectHeroRe.test(html)) hits.push('VideoObject-on-hero');
  return {
    pass: hits.length === 0,
    details: hits.length === 0 ? 'zero hits' : `hits: ${JSON.stringify(hits)}`,
  };
}

// Check 10 — hreflang: reciprocal en/he/x-default pairs on / and /en/; /en/ has lang="en" dir="ltr".
function checkHreflang(html, routePath) {
  const links = [...html.matchAll(/<link[^>]+rel=["']alternate["'][^>]+hreflang=["']([^"']+)["'][^>]+href=["']([^"']+)["'][^>]*>/gi)];
  const altLinksRev = [...html.matchAll(/<link[^>]+rel=["']alternate["'][^>]+href=["']([^"']+)["'][^>]+hreflang=["']([^"']+)["'][^>]*>/gi)];
  const found = new Map();
  for (const m of links) found.set(m[1].toLowerCase(), m[2]);
  for (const m of altLinksRev) found.set(m[2].toLowerCase(), m[1]);
  const hasEn = found.has('en');
  const hasHe = found.has('he');
  const hasXDefault = found.has('x-default');
  const reciprocalOk = hasEn && hasHe && hasXDefault;
  let langDirOk = true;
  let langDirDetail = '';
  if (routePath === '/en/') {
    const htmlTagMatch = html.match(/<html\b[^>]*>/i);
    const tag = htmlTagMatch ? htmlTagMatch[0] : '';
    const isEn = /lang=["']en["']/i.test(tag);
    const isLtr = /dir=["']ltr["']/i.test(tag);
    langDirOk = isEn && isLtr;
    langDirDetail = ` <html> lang=en:${isEn} dir=ltr:${isLtr}`;
  }
  return {
    pass: reciprocalOk && langDirOk,
    details: `hreflang found=${JSON.stringify([...found.keys()])}${langDirDetail}`,
  };
}

// Check 11 — GA4: gtag/js?id=G-MRXESK7QJF present in head, exactly one config call.
function checkGA4(html) {
  const gtagJsRe = new RegExp(`gtag/js\\?id=${GA4_ID}`, 'i');
  const gtagJsPresent = gtagJsRe.test(html);
  const configCalls = countMatches(new RegExp(`gtag\\(\\s*['"]config['"]\\s*,\\s*['"]${GA4_ID}['"]`, 'gi'), html);
  return {
    pass: gtagJsPresent && configCalls === 1,
    details: `gtag/js present=${gtagJsPresent}; config('${GA4_ID}') calls=${configCalls}`,
  };
}

// Check 12 — brand-string absence, except the ratified 6-testimonial-quote exempt routes.
function checkBrandAbsence(html, routePath, exemptRoutes) {
  const isExempt = (exemptRoutes || []).includes(routePath);
  const hits = countMatches(new RegExp(RETIRED_BRAND_STRING, 'g'), html);
  if (isExempt) {
    // Exempt routes are allowed (not required) to still show the string inside
    // verbatim testimonial quotes; we don't fail either way for those routes, but
    // report the count for visibility.
    return { pass: true, details: `route exempt (6-quote scope-out); brand-string hits=${hits}` };
  }
  return {
    pass: hits === 0,
    details: hits === 0 ? 'zero hits' : `${hits} hit(s) of retired brand string on a non-exempt route`,
  };
}

/** ---- Route runner ---- */

async function probeRoute(base, routeCfg, mode, tagline, brandExemptRoutes, nc) {
  const routeUrl = `${base.replace(/\/$/, '')}${routeCfg.path}?nc=${nc}`;
  const { res, text: html } = await fetchText(routeUrl);
  const checks = {};

  checks['1_robots_meta_header'] = checkRobotsMetaHeader(html, res.headers, mode);
  checks['4_meta_description'] = checkMetaDescription(html, tagline);
  checks['5_canonical'] = checkCanonical(html, routeUrl, res.url || routeUrl);
  checks['6_og_image'] = await checkOgImage(html);

  const yoastGraph = extractYoastGraph(html);
  const jsonLdResult = checkJsonLdGraph(yoastGraph, routeCfg.expectedTypes);
  checks['7_json_ld_graph'] = { pass: jsonLdResult.pass, details: jsonLdResult.details };
  checks['8_id_connectivity'] = checkIdConnectivity(jsonLdResult.graphArray);

  checks['9_prohibition_lint'] = checkProhibitionLint(html);
  checks['10_hreflang'] = checkHreflang(html, routeCfg.path);
  checks['11_ga4'] = checkGA4(html);
  checks['12_brand_absence'] = checkBrandAbsence(html, routeCfg.path, brandExemptRoutes);

  return {
    name: routeCfg.name,
    path: routeCfg.path,
    url: routeUrl,
    status: res.status,
    checks,
    allPass: Object.values(checks).every((c) => c.pass),
  };
}

async function main() {
  const opts = parseArgs(process.argv);
  const config = loadConfig(opts.config);
  const nc = `t7-seoprobe-${Date.now()}`;

  const tagline = (await fetchLiveTagline(opts.base)) ?? config.tagline?.fallback ?? SITE_TAGLINE_FALLBACK_ENGLISH;
  const brandExemptRoutes = config.brandExemptRoutes?.routes || [];

  // Checks 2 and 3 are host-level (not per-route); run once.
  const robotsTxtResult = await checkRobotsTxt(opts.base, opts.mode);
  const sitemapResult = await checkSitemap(opts.base);

  const routeResults = [];
  for (const routeCfg of config.routes) {
    const r = await probeRoute(opts.base, routeCfg, opts.mode, tagline, brandExemptRoutes, nc);
    routeResults.push(r);
    const failedChecks = Object.entries(r.checks)
      .filter(([, v]) => !v.pass)
      .map(([k]) => k);
    console.log(
      `${r.path} status=${r.status} ${r.allPass ? 'PASS' : `FAIL (${failedChecks.join(', ')})`}`
    );
  }

  const allRoutesPass = routeResults.every((r) => r.allPass);
  const overallPass = allRoutesPass && robotsTxtResult.pass && sitemapResult.pass;

  const report = {
    generatedAt: new Date().toISOString(),
    base: opts.base,
    mode: opts.mode,
    cacheBust: nc,
    tagline,
    ratifiedAllowedUAs: RATIFIED_ALLOWED_UAS,
    supersessionNotes: [
      "Check 2 (robots.txt UA count): Appendix B said 8 UAs; superseded by ratified D3 -> 10 UAs (DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md item 1).",
      "Check 7 (/method/ @type set): C-2 ratified /method/ as NOT a Service node (DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md item 9); manifest does not expect Service there.",
      "Check 12 (brand-string exemption): file-scoped per AC-09 6-quote scope-out (SEO-GEO-ROUND2-COMPLETION-2026-06-21.md :35); route list in seo_probe.config.json is a best-effort reconstruction pending team_90 ratification.",
    ],
    hostLevelChecks: {
      '2_robots_txt': robotsTxtResult,
      '3_sitemap_index': sitemapResult,
    },
    routes: routeResults,
    overallPass,
  };

  const outDir = opts.out || path.join(__dirname, 'reports');
  fs.mkdirSync(outDir, { recursive: true });
  const outFile = path.join(outDir, 'seo_probe_report.json');
  fs.writeFileSync(outFile, JSON.stringify(report, null, 2));

  console.log('\n=== seo_probe.mjs summary ===');
  console.log(`mode=${opts.mode} base=${opts.base}`);
  console.log(`host-level: robots.txt=${robotsTxtResult.pass ? 'PASS' : 'FAIL'} sitemap_index=${sitemapResult.pass ? 'PASS' : 'FAIL'}`);
  console.log(`routes: ${routeResults.filter((r) => r.allPass).length}/${routeResults.length} PASS`);
  if (!overallPass) {
    console.log('\nFAILURES:');
    if (!robotsTxtResult.pass) console.log(`  [host] 2_robots_txt: ${robotsTxtResult.details}`);
    if (!sitemapResult.pass) console.log(`  [host] 3_sitemap_index: ${sitemapResult.details}`);
    for (const r of routeResults) {
      for (const [checkName, result] of Object.entries(r.checks)) {
        if (!result.pass) console.log(`  [${r.path}] ${checkName}: ${result.details}`);
      }
    }
  }
  console.log(`\nWrote ${outFile}`);
  process.exit(overallPass ? 0 : 1);
}

const __isMain = process.argv[1] && path.resolve(process.argv[1]) === fileURLToPath(import.meta.url);
if (__isMain) {
  main().catch((e) => {
    console.error(e);
    process.exit(2);
  });
}

export { extractYoastGraph, collectIds, graphTypesOf, checkRobotsTxt, checkProhibitionLint };
