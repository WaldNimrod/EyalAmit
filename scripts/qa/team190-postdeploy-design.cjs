#!/usr/bin/env node
/** team_190 post-deploy — design eyeball screenshots + snippet verification */
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');

const BASE = 'http://eyalamit-co-il-2026.s887.upress.link';
const NC = `team190-${Date.now()}`;
const OUT = path.join(__dirname, '../../_COMMUNICATION/team_190/evidence/chapters-postdeploy-closure-2026-06-23/design');
const CHROME = process.env.EA_CHROME || '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

const eyeballPages = [
  {
    slug: 'treatment',
    path: '/treatment/',
    snippet: 'ובדיוק שם מתחילה העבודה.',
    source: "טיפול בדיג'רידו/treatment.md",
  },
  {
    slug: 'vekatavta',
    path: '/books/vekatavta/',
    snippet: 'ייחודי במיוחד לוכתבת הוא גם האלמנט של סריקת ה-QR:',
    source: 'וכתבת/vekatavta.md',
  },
  {
    slug: 'mokesh',
    path: '/eyal-amit/mokesh-dahiman/',
    snippet: 'יום אחד, בתחילת שנות השבעים',
    source: 'Mokesh memorial DOCX',
  },
];

const designPages = [
  { slug: 'home', path: '/' },
  { slug: 'method', path: '/method/' },
  { slug: 'treatment', path: '/treatment/' },
  { slug: 'vekatavta', path: '/books/vekatavta/' },
  { slug: 'mokesh', path: '/eyal-amit/mokesh-dahiman/' },
  { slug: 'books', path: '/books/' },
  { slug: 'kushi', path: '/books/kushi-blantis/' },
  { slug: 'tsva', path: '/books/tsva-bekahol/' },
  { slug: 'en', path: '/en/' },
];

(async () => {
  fs.mkdirSync(OUT, { recursive: true });

  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors'],
  });

  const eyeballResults = [];
  const designResults = [];

  for (const p of eyeballPages) {
    const page = await browser.newPage();
    await page.setViewport({ width: 1440, height: 900 });
    await page.goto(`${BASE}${p.path}?nc=${NC}`, { waitUntil: 'networkidle2', timeout: 90000 });
    const bodyText = await page.evaluate(() => document.body.innerText);
    const snippetFound = bodyText.includes(p.snippet);
    const shot = path.join(OUT, `eyeball_${p.slug}_full.png`);
    await page.screenshot({ path: shot, fullPage: true });
    eyeballResults.push({ path: p.path, source: p.source, snippet: p.snippet, snippetFound, screenshot: shot });
    await page.close();
  }

  for (const p of designPages) {
    const page = await browser.newPage();
    await page.setViewport({ width: 1440, height: 900 });
    await page.goto(`${BASE}${p.path}?nc=${NC}`, { waitUntil: 'networkidle2', timeout: 90000 });
    const meta = await page.evaluate(() => ({
      dir: document.documentElement.getAttribute('dir'),
      lang: document.documentElement.getAttribute('lang'),
      brokenImages: [...document.querySelectorAll('img')].filter((img) => !img.complete || img.naturalWidth === 0).length,
      loadedImages: [...document.querySelectorAll('img')].filter((img) => img.naturalWidth > 0).length,
      mokeshPhotos: document.querySelectorAll('.ea-memorial img, .ea-timeline img, article img').length,
    }));
    const shot = path.join(OUT, `design_${p.slug}_w1440.png`);
    await page.screenshot({ path: shot, fullPage: false });
    designResults.push({ path: p.path, ...meta, screenshot: shot });
    await page.close();
  }

  await browser.close();

  fs.writeFileSync(path.join(OUT, 'eyeball_probe_results.json'), JSON.stringify({ generatedAt: new Date().toISOString(), cacheBust: NC, eyeballResults }, null, 2));
  fs.writeFileSync(path.join(OUT, 'design_probe_results.json'), JSON.stringify({ generatedAt: new Date().toISOString(), cacheBust: NC, designResults }, null, 2));

  console.log('eyeball', eyeballResults.map((r) => `${r.path}:${r.snippetFound}`).join(' '));
  console.log('en dir', designResults.find((r) => r.path === '/en/')?.dir);
  console.log('books images', designResults.find((r) => r.path === '/books/')?.loadedImages);
})().catch((e) => {
  console.error(e);
  process.exit(1);
});
