#!/usr/bin/env node
/**
 * WP-W2-10 asset + structural smoke — per-route:
 * - HTTP 200
 * - single h1
 * - 0 console errors
 * - every img[src*="assets/images/"] resolves HTTP 200 and uses ea-eyalamit theme (not generatepress)
 */
const http = require('http');
const https = require('https');
const puppeteer = require('puppeteer-core');

const CHROME =
  process.env.EA_CHROME ||
  '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

const base = process.env.EA_QA_BASE || 'http://eyalamit-co-il-2026.s887.upress.link';
const routes = process.argv.slice(2);
if (routes.length === 0) {
  console.error('Usage: node wp-w2-10-asset-smoke.cjs /route/ ...');
  process.exit(2);
}

function fetchStatus(url) {
  return new Promise((resolve) => {
    const lib = url.startsWith('https') ? https : http;
    const req = lib.get(url, { timeout: 30000 }, (res) => {
      res.resume();
      resolve({ url, status: res.statusCode });
    });
    req.on('error', (e) => resolve({ url, status: null, error: String(e.message || e) }));
    req.on('timeout', () => {
      req.destroy();
      resolve({ url, status: null, error: 'timeout' });
    });
  });
}

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors'],
  });

  const clusterResults = [];
  let blocking = 0;

  for (const route of routes) {
    const pageUrl = base.replace(/\/$/, '') + route;
    const row = {
      route,
      pageUrl,
      http: null,
      h1Count: null,
      consoleErrors: [],
      assetImages: [],
      assetPass: true,
      pass: true,
      failures: [],
    };

    const page = await browser.newPage();
    const consoleErrors = [];
    page.on('console', (m) => {
      if (m.type() === 'error') consoleErrors.push(m.text());
    });

    try {
      const resp = await page.goto(pageUrl, { waitUntil: 'networkidle2', timeout: 90000 });
      row.http = resp ? resp.status() : null;
      row.h1Count = await page.evaluate(() => document.querySelectorAll('h1').length);
      row.consoleErrors = consoleErrors;

      const srcs = await page.evaluate(() =>
        [...document.querySelectorAll('img[src*="assets/images/"]')].map((img) => img.getAttribute('src'))
      );

      for (const src of srcs) {
        const absolute = new URL(src, pageUrl).href;
        const check = {
          src,
          absolute,
          http: null,
          themeOk: null,
          pass: true,
          note: null,
        };

        if (absolute.includes('/themes/generatepress/')) {
          check.themeOk = false;
          check.pass = false;
          check.note = 'parent theme path (generatepress)';
        } else if (absolute.includes('/themes/ea-eyalamit/')) {
          check.themeOk = true;
        } else {
          check.themeOk = false;
          check.pass = false;
          check.note = 'missing ea-eyalamit theme path';
        }

        const fetched = await fetchStatus(absolute.replace(/^https:/, 'http:'));
        check.http = fetched.status;
        if (fetched.status !== 200) {
          check.pass = false;
          check.note = (check.note ? check.note + '; ' : '') + `HTTP ${fetched.status ?? 'ERR'}`;
        }

        row.assetImages.push(check);
        if (!check.pass) row.assetPass = false;
      }
    } catch (e) {
      row.pass = false;
      row.failures.push(String(e.message || e));
    } finally {
      await page.close();
    }

    if (row.http !== 200) {
      row.pass = false;
      row.failures.push(`page HTTP ${row.http}`);
    }
    if (row.h1Count !== 1) {
      row.pass = false;
      row.failures.push(`h1 count ${row.h1Count} (expected 1)`);
    }
    if (row.consoleErrors.length > 0) {
      row.pass = false;
      row.failures.push(`${row.consoleErrors.length} console error(s)`);
    }
    if (!row.assetPass) {
      row.pass = false;
      row.failures.push('asset image check failed');
    }

    if (!row.pass) blocking++;

    const flag = row.pass ? 'PASS' : 'FAIL';
    console.log(
      `${flag} ${route.padEnd(22)} http=${row.http} h1=${row.h1Count} assets=${row.assetImages.length} assetPass=${row.assetPass} consoleErr=${row.consoleErrors.length}` +
        (row.failures.length ? `  (${row.failures.join('; ')})` : '')
    );
    for (const a of row.assetImages.filter((x) => !x.pass)) {
      console.log(`  ASSET FAIL ${a.src} -> ${a.http} themeOk=${a.themeOk} ${a.note || ''}`);
    }

    clusterResults.push(row);
  }

  await browser.close();

  console.log('\n============================================================');
  console.log(`Routes: ${clusterResults.length} · pass: ${clusterResults.length - blocking} · blocking: ${blocking}`);
  console.log(`RESULT: ${blocking === 0 ? 'PASS' : 'FAIL'}`);
  process.exit(blocking === 0 ? 0 : 1);
})();
