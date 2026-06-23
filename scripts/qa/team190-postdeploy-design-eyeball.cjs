#!/usr/bin/env node
/** team_190 post-deploy — B6 design + media eyeball probes */
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');

const BASE = 'http://eyalamit-co-il-2026.s887.upress.link';
const NC = `team190-design-${Date.now()}`;
const OUT = path.join(__dirname, '../../_COMMUNICATION/team_190/evidence/chapters-postdeploy-closure-2026-06-23/design');
const CHROME = process.env.EA_CHROME || '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

const PAGES = [
  { name: 'home', path: '/', checks: ['hero', 'chapters-nav'] },
  { name: 'method', path: '/method/', checks: ['hero'] },
  { name: 'treatment', path: '/treatment/', checks: ['hero', 'verbatim-spot'] },
  { name: 'books', path: '/books/', checks: ['book-covers'] },
  { name: 'bookVekatavta', path: '/books/vekatavta/', checks: ['book-cover', 'verbatim-spot'] },
  { name: 'mokesh', path: '/eyal-amit/mokesh-dahiman/', checks: ['memorial-photos'] },
  { name: 'en', path: '/en/', checks: ['ltr'] },
];

(async () => {
  fs.mkdirSync(OUT, { recursive: true });
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors'],
  });
  const results = [];
  for (const pg of PAGES) {
    const page = await browser.newPage();
    await page.setViewport({ width: 1440, height: 900 });
    const row = { page: pg.name, path: pg.path, http: null, dir: null, lang: null, checks: {}, pass: true };
    try {
      const resp = await page.goto(`${BASE}${pg.path}?nc=${NC}`, { waitUntil: 'networkidle2', timeout: 90000 });
      row.http = resp ? resp.status() : null;
      const meta = await page.evaluate(() => ({
        dir: document.documentElement.getAttribute('dir'),
        lang: document.documentElement.getAttribute('lang'),
        h1: document.querySelectorAll('h1').length,
        brokenImages: [...document.querySelectorAll('img')].filter((img) => img.naturalWidth === 0 && img.src).length,
        bookCoverImgs: [...document.querySelectorAll('img')].filter((img) =>
          /vekatavta|kushi|tsva|book|cover|מוזה/i.test(img.alt + img.src)
        ).length,
        mokeshImgs: [...document.querySelectorAll('img')].filter((img) =>
          /mokesh|מוקש|dahiman/i.test(img.alt + img.src + (img.closest('figure')?.className || ''))
        ).length,
        hasMain: !!document.querySelector('main'),
        treatmentSpot: document.body.innerText.includes('ובדיוק שם מתחילה העבודה'),
        vekatavtaSpot: document.body.innerText.includes('ייחודי במיוחד לוכתבת הוא גם האלמנט של סריקת ה-QR'),
        mokeshSpot: document.body.innerText.includes('יום אחד, בתחילת שנות השבעים'),
      }));
      Object.assign(row, { dir: meta.dir, lang: meta.lang, h1: meta.h1 });
      row.checks.brokenImages = meta.brokenImages;
      row.checks.bookCovers = meta.bookCoverImgs;
      row.checks.mokeshPhotos = meta.mokeshImgs;
      row.checks.ltr = pg.path === '/en/' ? meta.dir === 'ltr' : meta.dir === 'rtl';
      if (pg.path === '/treatment/') row.checks.verbatimSpot = meta.treatmentSpot;
      if (pg.path === '/books/vekatavta/') row.checks.verbatimSpot = meta.vekatavtaSpot;
      if (pg.path === '/eyal-amit/mokesh-dahiman/') row.checks.verbatimSpot = meta.mokeshSpot;
      if (meta.brokenImages > 0) row.pass = false;
      if (pg.path === '/books/' && meta.bookCoverImgs < 1) row.pass = false;
      if (pg.path === '/eyal-amit/mokesh-dahiman/' && meta.mokeshImgs < 1) row.pass = false;
      if (pg.path === '/en/' && meta.dir !== 'ltr') row.pass = false;
      const shot = path.join(OUT, `eyeball_${pg.name}_w1440.png`);
      await page.screenshot({ path: shot, fullPage: true });
      row.screenshot = shot.replace(/.*team_190\//, '_COMMUNICATION/team_190/');
    } catch (e) {
      row.error = String(e.message || e);
      row.pass = false;
    } finally {
      await page.close();
    }
    results.push(row);
    console.log(`${row.pass ? 'PASS' : 'FAIL'} ${pg.path} dir=${row.dir} broken=${row.checks.brokenImages}`);
  }
  await browser.close();
  const summary = {
    generatedAt: new Date().toISOString(),
    base: BASE,
    cacheBust: NC,
    engine: 'GPT-5.2 (team_190 post-deploy)',
    results,
    passCount: results.filter((r) => r.pass).length,
    failCount: results.filter((r) => !r.pass).length,
    verdict: results.every((r) => r.pass) ? 'PASS' : 'FAIL',
  };
  fs.writeFileSync(path.join(OUT, 'design-media-probe.json'), JSON.stringify(summary, null, 2));
  console.log('verdict', summary.verdict, `${summary.passCount}/${results.length}`);
})().catch((e) => {
  console.error(e);
  process.exit(1);
});
