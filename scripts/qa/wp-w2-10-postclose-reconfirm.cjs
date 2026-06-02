#!/usr/bin/env node
/**
 * WP-W2-10 post-closure re-confirm probes (team_190) — A computed/spine/CSS + F CTA/LTR.
 */
const fs = require('fs');
const path = require('path');
const http = require('http');
const https = require('https');
const puppeteer = require('puppeteer-core');

const CHROME =
  process.env.EA_CHROME ||
  '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const BASE = process.env.EA_QA_BASE || 'http://eyalamit-co-il-2026.s887.upress.link';
const REPORTS = path.join(__dirname, 'reports');

const SERVICE_ROUTES = ['/treatment/', '/method/', '/sound-healing/', '/lessons/'];
const EXPECTED_SPINE = [
  'hero',
  'intro',
  'breath-divider-1',
  'content-section',
  'method-pillars',
  'method-pillars',
  'bio',
  'service-comparison',
  'testimonials-row',
  'faq-mini',
  'disclaimer',
  'contact-cta',
];

function fetchStatus(url) {
  const httpUrl = url.replace(/^https:/, 'http:');
  return new Promise((resolve) => {
    const lib = httpUrl.startsWith('https') ? https : http;
    const req = lib.get(httpUrl, { timeout: 30000, rejectUnauthorized: false }, (res) => {
      res.resume();
      resolve(res.statusCode);
    });
    req.on('error', () => resolve(null));
    req.on('timeout', () => {
      req.destroy();
      resolve(null);
    });
  });
}

function normColor(c) {
  return String(c).replace(/\s/g, '').toLowerCase();
}

async function probeClusterA(page) {
  const routeResults = [];

  for (const route of SERVICE_ROUTES) {
    const url = BASE.replace(/\/$/, '') + route;
    await page.setViewport({ width: 1440, height: 900 });
    await page.goto(url, { waitUntil: 'networkidle2', timeout: 90000 });

    const row = await page.evaluate(
      (expectedSpine) => {
        const blocks = [...document.querySelectorAll('[data-block]')].map((el) =>
          el.getAttribute('data-block')
        );
        const hasEntryStub = !!document.querySelector('.entry-content');
        const cssLink = [...document.querySelectorAll('link[rel="stylesheet"]')]
          .map((l) => l.getAttribute('href') || '')
          .find((h) => h.includes('w2-10-service.css'));

        const cs = (sel) => {
          const el = document.querySelector(sel);
          if (!el) return { found: false };
          const s = getComputedStyle(el);
          return {
            found: true,
            color: s.color,
            gridTemplateColumns: s.gridTemplateColumns,
            backgroundColor: s.backgroundColor,
          };
        };

        const root = getComputedStyle(document.documentElement);
        const token = (name) => root.getPropertyValue(name).trim();

        const compositionBlocks = blocks.filter(
          (b) => b !== 'topnav' && b !== 'footer-social'
        );

        return {
          blocks,
          compositionBlocks,
          hasEntryStub,
          cssHref: cssLink || null,
          h1Count: document.querySelectorAll('h1').length,
          computed: {
            kicker: cs('.ea-hero__kicker'),
            steps: cs('.ea-pillars-grid--steps'),
            disclaimer: cs('.ea-disclaimer__text'),
            inkCta: cs('.ea-section--cta--ink'),
          },
          tokens: {
            sand: token('--ea-sand'),
            muted: token('--ea-muted'),
            ink: token('--ea-ink'),
          },
          spineMatch:
            compositionBlocks.length === expectedSpine.length &&
            expectedSpine.every((b, i) => compositionBlocks[i] === b),
          stepsColCount: (() => {
            const el = document.querySelector('.ea-pillars-grid--steps');
            if (!el) return 0;
            const cols = getComputedStyle(el).gridTemplateColumns;
            if (cols.includes('repeat(4')) return 4;
            return cols.split(/\s+/).filter(Boolean).length;
          })(),
        };
      },
      EXPECTED_SPINE
    );

    let cssHttp = null;
    if (row.cssHref) {
      cssHttp = await fetchStatus(new URL(row.cssHref, url).href);
    }

    const sandComputed = await page.evaluate(() => {
      const root = getComputedStyle(document.documentElement);
      const sand = root.getPropertyValue('--ea-sand').trim();
      if (!sand) return null;
      const probe = document.createElement('div');
      probe.style.color = sand;
      document.body.appendChild(probe);
      const c = getComputedStyle(probe).color;
      document.body.removeChild(probe);
      return c;
    });

    const checks = {
      cssInDom: !!row.cssHref,
      cssHttp200: cssHttp === 200,
      spineOk: row.spineMatch && !row.hasEntryStub,
      h1Single: row.h1Count === 1,
      kickerSand:
        row.computed.kicker.found &&
        normColor(row.computed.kicker.color) === normColor(sandComputed),
      steps4col: row.stepsColCount === 4,
      disclaimerMuted:
        row.computed.disclaimer.found &&
        normColor(row.computed.disclaimer.color) ===
          normColor(
            await page.evaluate(() => {
              const root = getComputedStyle(document.documentElement);
              const muted = root.getPropertyValue('--ea-muted').trim();
              const probe = document.createElement('div');
              probe.style.color = muted;
              document.body.appendChild(probe);
              const c = getComputedStyle(probe).color;
              document.body.removeChild(probe);
              return c;
            })
          ),
      inkCtaBg:
        row.computed.inkCta.found &&
        normColor(row.computed.inkCta.backgroundColor) ===
          normColor(
            await page.evaluate(() => {
              const root = getComputedStyle(document.documentElement);
              const ink = root.getPropertyValue('--ea-ink').trim();
              const probe = document.createElement('div');
              probe.style.backgroundColor = ink;
              document.body.appendChild(probe);
              const c = getComputedStyle(probe).backgroundColor;
              document.body.removeChild(probe);
              return c;
            })
          ),
    };

    routeResults.push({
      route,
      url,
      cssHref: row.cssHref,
      cssHttp,
      blocks: row.blocks,
      checks,
      pass: Object.values(checks).every(Boolean),
      computedSample: route === '/treatment/' ? row.computed : undefined,
    });
  }

  const report = {
    date: new Date().toISOString().slice(0, 10),
    base: BASE,
    cluster: 'A',
    change: 'D2 CSS relocation to w2-10-service.css',
    routes: routeResults,
    pass: routeResults.every((r) => r.pass),
  };

  fs.mkdirSync(REPORTS, { recursive: true });
  const out = path.join(REPORTS, 'wp-w2-10-a-postclose-computed-proof.json');
  fs.writeFileSync(out, JSON.stringify(report, null, 2));
  console.log('A report:', out, 'pass=', report.pass);
  return report;
}

async function probeClusterF(page) {
  const url = BASE.replace(/\/$/, '') + '/en/';
  await page.setViewport({ width: 1440, height: 900 });
  const resp = await page.goto(url, { waitUntil: 'networkidle2', timeout: 90000 });
  const serverHtml = await resp.text();

  const serverScheduleCount = (serverHtml.match(/Schedule an introductory call<\/a>/g) || [])
    .length;
  const serverWaMeTargetCount = (
    serverHtml.match(/wa\.me\/972524822842" target="_blank"/g) || []
  ).length;

  const data = await page.evaluate(() => {
    const ctas = [...document.querySelectorAll('a.ea-cta-pill')]
      .filter((a) => a.textContent.trim() === 'Schedule an introductory call')
      .map((a) => ({
        href: a.getAttribute('href'),
        target: a.getAttribute('target') || a.target || null,
        rel: a.getAttribute('rel'),
        ariaLabel: a.getAttribute('aria-label'),
        text: a.textContent.trim(),
        hasTargetBlank:
          a.getAttribute('target') === '_blank' ||
          a.target === '_blank' ||
          a.outerHTML.includes('target="_blank"'),
      }));

    const html = document.documentElement;
    const main = document.querySelector('main#main, main.ea-wave2-en, main[id="main"]');
    const bodyHtml = document.body.innerHTML;

    return {
      ctas,
      htmlDir: html.getAttribute('dir'),
      htmlLang: html.getAttribute('lang'),
      mainDir: main ? main.getAttribute('dir') : null,
      mainLang: main ? main.getAttribute('lang') : null,
      hasTopnav: !!document.querySelector('[data-block="topnav"]'),
      hasFooter: !!document.querySelector('footer.ea-footer'),
      contactLangEnCount: (bodyHtml.match(/contact\?lang=en/g) || []).length,
      h1Count: document.querySelectorAll('h1').length,
    };
  });

  const expectedHref = 'https://wa.me/972524822842';
  const serverTargetBlank = serverWaMeTargetCount === 3;
  const serverWaMe = serverScheduleCount === 3 && serverWaMeTargetCount >= 3;

  const ctaChecks = {
    count3: data.ctas.length === 3,
    allWaMe: data.ctas.every((c) => c.href === expectedHref) && serverWaMe,
    allTargetBlank:
      serverTargetBlank ||
      data.ctas.every((c) => c.hasTargetBlank),
    allNoopener: data.ctas.every((c) => (c.rel || '').includes('noopener')),
    allAriaWhatsApp: data.ctas.every((c) =>
      (c.ariaLabel || '').toLowerCase().includes('whatsapp')
    ),
  };

  const domTargetBlank = data.ctas.every((c) => c.hasTargetBlank);

  const ltrChecks = {
    htmlLtr: data.htmlDir === 'ltr' && data.htmlLang === 'en',
    mainLtr: data.mainDir === 'ltr' && data.mainLang === 'en',
    topnav: data.hasTopnav,
    footer: data.hasFooter,
    noContactLangEn: data.contactLangEnCount === 0,
    h1Single: data.h1Count === 1,
  };

  const report = {
    date: new Date().toISOString().slice(0, 10),
    base: BASE,
    cluster: 'F',
    change: 'D1 WhatsApp CTA',
    url,
    serverScheduleCount,
    serverWaMeTargetCount,
    serverTargetBlank,
    domTargetBlank,
    ctas: data.ctas,
    ctaChecks,
    ltrChecks,
    pass:
      Object.values(ctaChecks).every(Boolean) && Object.values(ltrChecks).every(Boolean),
  };

  const out = path.join(REPORTS, 'wp-w2-10-f-postclose-cta-proof.json');
  fs.writeFileSync(out, JSON.stringify(report, null, 2));
  console.log('F report:', out, 'pass=', report.pass);
  return report;
}

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors'],
  });
  const page = await browser.newPage();
  await page.emulateMediaFeatures([{ name: 'prefers-reduced-motion', value: 'no-preference' }]);

  const aReport = await probeClusterA(page);
  const fReport = await probeClusterF(page);
  await browser.close();

  const exitCode = aReport.pass && fReport.pass ? 0 : 1;
  console.log(JSON.stringify({ aPass: aReport.pass, fPass: fReport.pass }, null, 2));
  process.exit(exitCode);
})();
