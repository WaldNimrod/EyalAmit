#!/usr/bin/env node
/**
 * team_190 Wave-1b final gate probes — independent live staging checks.
 */
import { writeFileSync, mkdirSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const __dir = dirname(fileURLToPath(import.meta.url));
const BASE = 'http://eyalamit-co-il-2026.s887.upress.link';
const OUT = __dir;

const ROUTES = [
  '/',
  '/blog/',
  '/blog/page/2/',
  '/eyal-amit/',
  '/shop/',
  '/didgeridoos/',
  '/bags/',
  '/stands-storage/',
  '/stand-floor/',
  '/repair/',
  '/books/',
  '/faq/',
  '/contact/',
];

const EXPECTED_NEEDLES = {
  '/': 'המרכז לטיפול בנשימה',
  '/blog/': 'הבלוג של אייל עמית',
  '/blog/page/2/': 'הבלוג של אייל עמית',
  '/eyal-amit/': 'אייל עמית',
  '/shop/': 'חנות הדיג׳רידו',
  '/didgeridoos/': 'דיג׳רידו למכירה',
  '/bags/': 'תיקים לדיג׳רידו',
  '/stands-storage/': 'סטנדים לאחסון דיג׳רידו',
  '/stand-floor/': 'סטנד רצפתי לדיג׳רידו',
  '/repair/': 'תיקון דיג׳רידו',
  '/books/': 'הספרים של אייל עמית',
  '/faq/': 'שאלות נפוצות',
  '/contact/': 'צרו קשר עם אייל עמית',
};

function extractMetaDescriptions(html) {
  const re = /<meta\s+[^>]*name\s*=\s*["']description["'][^>]*>/gi;
  const tags = html.match(re) || [];
  return tags.map((tag) => {
    const cm = tag.match(/content\s*=\s*["']([^"']*)["']/i);
    return cm ? cm[1] : '';
  });
}

function extractJsonLd(html) {
  const blocks = [];
  const re = /<script[^>]*type\s*=\s*["']application\/ld\+json["'][^>]*>([\s\S]*?)<\/script>/gi;
  let m;
  while ((m = re.exec(html)) !== null) {
    try {
      blocks.push(JSON.parse(m[1].trim()));
    } catch {
      blocks.push({ _parseError: true });
    }
  }
  return blocks;
}

function findBusinessNodes(obj, out = []) {
  if (!obj || typeof obj !== 'object') return out;
  if (Array.isArray(obj)) {
    for (const item of obj) findBusinessNodes(item, out);
    return out;
  }
  if (obj['@type'] === 'ProfessionalService' || obj['@type'] === 'LocalBusiness') {
    out.push(obj);
  }
  for (const v of Object.values(obj)) findBusinessNodes(v, out);
  return out;
}

async function fetchHtml(path) {
  const url = BASE + path;
  const res = await fetch(url, { redirect: 'follow' });
  const html = await res.text();
  return { url, finalUrl: res.url, status: res.status, html };
}

async function gateMeta() {
  const results = [];
  for (const route of ROUTES) {
    const { finalUrl, status, html } = await fetchHtml(route);
    const contents = extractMetaDescriptions(html);
    const needle = EXPECTED_NEEDLES[route];
    const contentAccurate = contents.some((c) => c.includes(needle));
    const pass = status === 200 && contents.length === 1 && contentAccurate;
    results.push({ route, finalUrl, status, count: contents.length, contents, expectedNeedle: needle, contentAccurate, pass });
  }

  const passCount = results.filter((r) => r.pass).length;
  const duplicateCount = results.filter((r) => r.count > 1).length;
  const zeroCount = results.filter((r) => r.count === 0).length;

  const out = {
    generatedAt: new Date().toISOString(),
    base: BASE,
    validator: 'team_190 final gate',
    decisiveRoutesTotal: ROUTES.length,
    passCount,
    failCount: ROUTES.length - passCount,
    duplicateCount,
    zeroCount,
    results,
  };
  writeFileSync(join(OUT, 'meta', 'meta-check.json'), JSON.stringify(out, null, 2));
  return out;
}

async function gateContact() {
  const { status, html } = await fetchHtml('/contact/');
  const visible = {
    centerName: /המרכז לטיפול בנשימה/.test(html),
    addressAmal8: /עמל\s*8/.test(html) && /פרדס חנה/.test(html),
    phoneText: /052[-\s]?482[-\s]?2842/.test(html),
    telHref: /tel:\+972524822842/.test(html),
    hours: /09:00/.test(html) && /19:00/.test(html) && /14:00/.test(html),
    waPrefill: /wa\.me\/972524822842/.test(html),
  };
  const jsonLdBlocks = extractJsonLd(html);
  const businessNodes = jsonLdBlocks.flatMap((b) => findBusinessNodes(b));
  const biz = businessNodes.find((n) => n['@type'] === 'ProfessionalService') || businessNodes[0];
  const jsonLdOk = biz && /482/.test(String(biz.telephone || '')) && biz.address;
  const pass = status === 200 && Object.values(visible).every(Boolean) && jsonLdOk;

  const out = {
    generatedAt: new Date().toISOString(),
    route: '/contact/',
    status,
    visible,
    jsonLdBlocks: jsonLdBlocks.length,
    businessNodes: businessNodes.map((n) => ({
      type: n['@type'],
      name: n.name,
      telephone: n.telephone,
      address: n.address,
      openingHoursSpecification: n.openingHoursSpecification,
    })),
    pass,
  };
  writeFileSync(join(OUT, 'contact', 'contact-nap.json'), JSON.stringify(out, null, 2));
  return out;
}

async function gateLcp() {
  const { status, html } = await fetchHtml('/eyal-amit/');
  const imgRe = /<img[^>]*>/gi;
  const imgs = html.match(imgRe) || [];
  const highPriorityImages = imgs
    .filter((tag) => /fetchpriority\s*=\s*["']high["']/i.test(tag))
    .map((tag) => {
      const get = (name) => {
        const m = tag.match(new RegExp(`${name}\\s*=\\s*["']([^"']*)["']`, 'i'));
        return m ? m[1] : null;
      };
      return {
        src: get('src'),
        alt: get('alt'),
        width: get('width'),
        height: get('height'),
        class: get('class'),
      };
    })
    .filter((img) => img.src && /portrait|eyal/i.test(img.src + (img.alt || '')));

  const pass =
    status === 200 &&
    highPriorityImages.length >= 1 &&
    highPriorityImages.every((img) => img.width && img.height);

  const out = {
    generatedAt: new Date().toISOString(),
    route: '/eyal-amit/',
    status,
    highPriorityImages,
    pass,
  };
  writeFileSync(join(OUT, 'lcp', 'lcp-check.json'), JSON.stringify(out, null, 2));
  return out;
}

async function gateRegression() {
  const phpPatterns = [/Fatal error/i, /Parse error/i, /PHP (Warning|Notice|Fatal)/i];
  const routeResults = [];
  let themeVer = null;

  for (const route of ROUTES) {
    const { status, html } = await fetchHtml(route);
    const phpErrors = phpPatterns.filter((p) => p.test(html)).map((p) => p.source);
    const verMatch = html.match(/ea-eyalamit[^"']*\?ver=([\d.]+)/);
    if (verMatch) themeVer = verMatch[1];
    routeResults.push({ route, status, phpErrors, pass: status === 200 && phpErrors.length === 0 });
  }

  const out = {
    generatedAt: new Date().toISOString(),
    base: BASE,
    themeVerLive: themeVer,
    routesChecked: routeResults.length,
    allHttp200: routeResults.every((r) => r.status === 200),
    phpErrorsFound: routeResults.filter((r) => r.phpErrors.length).length,
    routeResults,
    pass: routeResults.every((r) => r.pass),
  };
  writeFileSync(join(OUT, 'regression.json'), JSON.stringify(out, null, 2));
  return out;
}

async function gateRedirects() {
  const probes = [
    { path: '/shop/cart/', expectStatus: 301, expectLocation: '/shop/' },
    { path: '/shop/checkout/', expectStatus: 301, expectLocation: '/shop/' },
    { path: '/shop/my-account/', expectStatus: 301, expectLocation: '/shop/' },
    { path: '/Blog/test-slug/', expectStatus: 301, expectLocation: '/blog/test-slug/' },
    { path: '/%D7%9E%D7%95%D7%96%D7%94-%D7%94%D7%95%D7%A6%D7%90%D7%94-%D7%9C%D7%90%D7%95%D7%A8/', expectStatus: 301, expectLocation: '/books/' },
  ];

  const results = [];
  const curlLines = [];

  for (const probe of probes) {
    const url = BASE + probe.path;
    const res = await fetch(url, { redirect: 'manual' });
    const location = res.headers.get('location') || '';
    const locPath = location.replace(BASE, '').replace(/^https?:\/\/[^/]+/, '');
    const pass =
      res.status === probe.expectStatus &&
      (locPath === probe.expectLocation || locPath.endsWith(probe.expectLocation));
    results.push({ ...probe, url, status: res.status, location, locPath, pass });
    curlLines.push(`${url}\nHTTP/${res.status} location=${location}\n`);
  }

  const out = {
    generatedAt: new Date().toISOString(),
    passCount: results.filter((r) => r.pass).length,
    total: results.length,
    results,
    pass: results.every((r) => r.pass),
  };
  writeFileSync(join(OUT, 'redirects', 'redirect-check.json'), JSON.stringify(out, null, 2));
  writeFileSync(join(OUT, 'redirects', 'curl-I.txt'), curlLines.join('\n'));
  return out;
}

async function main() {
  mkdirSync(join(OUT, 'meta'), { recursive: true });
  const meta = await gateMeta();
  const contact = await gateContact();
  const lcp = await gateLcp();
  const regression = await gateRegression();
  const redirects = await gateRedirects();

  const summary = {
    generatedAt: new Date().toISOString(),
    gates: {
      meta: { pass: meta.passCount === meta.decisiveRoutesTotal && meta.duplicateCount === 0, passCount: meta.passCount, total: meta.decisiveRoutesTotal },
      contact: { pass: contact.pass },
      lcp: { pass: lcp.pass },
      regression: { pass: regression.pass, themeVerLive: regression.themeVerLive },
      redirects: { pass: redirects.pass, passCount: redirects.passCount, total: redirects.total },
    },
  };
  writeFileSync(join(OUT, 'gate-summary-partial.json'), JSON.stringify(summary, null, 2));
  console.log(JSON.stringify(summary, null, 2));
}

main().catch((e) => {
  console.error(e);
  process.exit(1);
});
