#!/usr/bin/env node
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');

const CHROME =
  process.env.EA_CHROME ||
  '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

const base = 'http://eyalamit-co-il-2026.s887.upress.link';
const routes = process.argv.slice(2);
const DEFAULT_ROUTES = [
  '/', '/treatment/', '/method/', '/sound-healing/', '/lessons/', '/learning/',
  '/therapist-training/', '/courses-external/', '/lectures/', '/workshops/',
  '/tools-and-accessories/', '/instruments/', '/repair/', '/muzza/', '/muzeh/',
  '/books/', '/books/kushi-blantis/', '/books/tsva-bekahol/', '/books/vekatavta/',
  '/blog/', '/about/', '/eyal-amit/', '/contact/', '/faq/', '/galleries/', '/media/',
  '/privacy/', '/accessibility/', '/terms/', '/mokesh-dahiman/', '/about/moksha/',
  '/shop/', '/didgeridoos/', '/bags/', '/stands-storage/', '/stand-floor/', '/press/', '/en/',
];
const probeRoutes = routes.length ? routes : DEFAULT_ROUTES;

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors'],
  });
  const results = [];
  for (const route of probeRoutes) {
    const page = await browser.newPage();
    const row = { route, http: null, h1: null, dir: null, lang: null, finalUrl: null, pass: false };
    try {
      const resp = await page.goto(base + route, { waitUntil: 'networkidle2', timeout: 90000 });
      row.http = resp ? resp.status() : null;
      row.finalUrl = page.url();
      const meta = await page.evaluate(() => ({
        h1: document.querySelectorAll('h1').length,
        dir: document.documentElement.getAttribute('dir'),
        lang: document.documentElement.getAttribute('lang'),
      }));
      Object.assign(row, meta);
      const rtlOk = route === '/en/' ? meta.dir === 'ltr' : meta.dir === 'rtl';
      row.pass = row.http === 200 && meta.h1 === 1 && rtlOk;
    } catch (e) {
      row.error = String(e.message || e);
    } finally {
      await page.close();
    }
    results.push(row);
    console.log(
      `${row.pass ? 'PASS' : 'FAIL'} ${route.padEnd(22)} http=${row.http} h1=${row.h1} dir=${row.dir}`
    );
  }
  await browser.close();
  const out = {
    generatedAt: new Date().toISOString(),
    base,
    results,
    passCount: results.filter((r) => r.pass).length,
    failCount: results.filter((r) => !r.pass).length,
  };
  const outArg = process.env.EA_H1_OUT;
  const outPath = outArg
    ? path.resolve(outArg)
    : path.join(__dirname, 'reports', `h1-rtl-http-${new Date().toISOString().slice(0, 10)}.json`);
  fs.mkdirSync(path.dirname(outPath), { recursive: true });
  fs.writeFileSync(outPath, JSON.stringify(out, null, 2));
  console.log(`SUMMARY ${out.passCount}/${results.length} pass → ${outPath}`);
  process.exit(out.failCount ? 1 : 0);
})().catch((e) => {
  console.error('FATAL:', e);
  process.exit(2);
});
