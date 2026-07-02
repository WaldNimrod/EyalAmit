#!/usr/bin/env node
/**
 * team_90 — image audit for CR-FINAL re-run 2026-07-02
 * Run from repo root: node scripts/qa/run-image-audit-cr-final.cjs
 * (uses puppeteer-core from scripts/qa/node_modules)
 */
const fs = require('fs');
const path = require('path');
const { createRequire } = require('module');

const ROOT = path.join(__dirname, '../../../..');
const OUT = __dirname;
const requireFromQa = createRequire(path.join(ROOT, 'scripts/qa/package.json'));
const puppeteer = requireFromQa('puppeteer-core');
const BASE = process.env.EA_QA_BASE || 'http://eyalamit-co-il-2026.s887.upress.link';
const CHROME =
  process.env.EA_CHROME ||
  '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

const PAGE_MAP = [
  { path: '/', name: 'home' },
  { path: '/method/', name: 'method' },
  { path: '/treatment/', name: 'treatment' },
  { path: '/sound-healing/', name: 'sound-healing' },
  { path: '/lessons/', name: 'lessons' },
  { path: '/faq/', name: 'faq' },
  { path: '/books/', name: 'books' },
  { path: '/eyal-amit/', name: 'eyal-amit' },
  { path: '/books/vekatavta/', name: 'book-vekatavta' },
  { path: '/books/kushi-blantis/', name: 'book-kushi' },
  { path: '/books/tsva-bekahol/', name: 'book-tsva' },
  { path: '/didgeridoos/', name: 'didgeridoos' },
  { path: '/bags/', name: 'bags' },
  { path: '/stands-storage/', name: 'stands-storage' },
  { path: '/stand-floor/', name: 'stand-floor' },
  { path: '/repair/', name: 'repair' },
];

const FILE_TO_PATH = {
  'בית - פרקים.html': '/',
  'השיטה - פרקים.html': '/method/',
  'טיפול - פרקים.html': '/treatment/',
  'סאונד הילינג - פרקים.html': '/sound-healing/',
  'שיעורים - פרקים.html': '/lessons/',
  'אודות - פרקים.html': '/eyal-amit/',
  'Memorial - Mokesh (elevated).html': '/eyal-amit/mokesh-dahiman/',
  'Book - Kushi Blantis.html': '/books/kushi-blantis/',
};

function normBasename(src) {
  if (!src) return '';
  try {
    const p = src.startsWith('http') ? new URL(src).pathname : src;
    return path.basename(decodeURIComponent(p.split('?')[0])).toLowerCase();
  } catch {
    return path.basename(src).toLowerCase();
  }
}

function buildSlotExpectations(imageMap) {
  const byPath = {};
  for (const page of imageMap.pages || []) {
    const wpPath = FILE_TO_PATH[page.file];
    if (!wpPath) continue;
    if (!byPath[wpPath]) byPath[wpPath] = [];
    for (const slot of page.slots || []) {
      if (slot.type === 'video') {
        const currents = Array.isArray(slot.current) ? slot.current : [slot.current];
        for (const c of currents) {
          if (c) byPath[wpPath].push({ slotId: slot.id, expected: normBasename(c), type: 'video' });
        }
      } else if (slot.current) {
        byPath[wpPath].push({ slotId: slot.id, expected: normBasename(slot.current), type: 'img' });
      }
    }
  }
  return byPath;
}

async function auditPage(page, url, slotExpectations) {
  await page.goto(url, { waitUntil: 'networkidle2', timeout: 60000 });
  // Scroll to trigger lazy-loaded images
  await page.evaluate(async () => {
    await new Promise((resolve) => {
      let y = 0;
      const step = () => {
        y += 400;
        window.scrollTo(0, y);
        if (y < document.body.scrollHeight) setTimeout(step, 80);
        else {
          window.scrollTo(0, 0);
          setTimeout(resolve, 500);
        }
      };
      step();
    });
  });
  await page.evaluate(() =>
    Promise.all(
      [...document.images].map((img) => {
        if (img.complete) return Promise.resolve();
        return new Promise((r) => {
          img.addEventListener('load', r, { once: true });
          img.addEventListener('error', r, { once: true });
          setTimeout(r, 3000);
        });
      })
    )
  );
  const data = await page.evaluate(() => {
    const imgs = [...document.querySelectorAll('img')].map((img) => ({
      src: img.currentSrc || img.src || '',
      alt: img.alt || '',
      complete: img.complete,
      naturalWidth: img.naturalWidth,
      broken: img.naturalWidth === 0,
    }));
    const bgEls = [...document.querySelectorAll('[style*="background-image"], .ea-hero, .wp-block-cover')];
    const bgImages = bgEls
      .map((el) => getComputedStyle(el).backgroundImage)
      .filter((b) => b && b !== 'none')
      .map((b) => b.replace(/^url\(["']?/, '').replace(/["']?\)$/, ''));
    return { imgs, bgImages };
  });

  const liveBasenames = new Set(
    [...data.imgs.map((i) => normBasename(i.src)), ...data.bgImages.map(normBasename)].filter(Boolean)
  );

  const broken = data.imgs.filter((i) => i.broken);
  const slotResults = (slotExpectations || []).map((slot) => ({
    ...slot,
    foundOnPage: liveBasenames.has(slot.expected),
  }));
  const missingSlots = slotResults.filter((s) => !s.foundOnPage);

  return {
    url,
    imagesTotal: data.imgs.length,
    imagesBroken: broken.length,
    brokenUrls: broken.map((i) => i.src),
    brokenDetails: broken,
    bgImageCount: data.bgImages.length,
    slotsExpected: slotResults.length,
    slotsMissing: missingSlots.length,
    missingSlotDetails: missingSlots,
    slotResults,
    pass: broken.length === 0 && missingSlots.length === 0,
  };
}

async function main() {
  fs.mkdirSync(path.join(OUT, 'per-page'), { recursive: true });

  const imageMap = JSON.parse(
    fs.readFileSync(path.join(ROOT, '_communication/team_110/image-map.json'), 'utf8')
  );
  const slotByPath = buildSlotExpectations(imageMap);

  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: true,
    args: ['--no-sandbox', '--disable-setuid-sandbox'],
  });

  const results = [];
  try {
    const pg = await browser.newPage();
    await pg.setViewport({ width: 1440, height: 900 });
    for (const { path: pagePath, name } of PAGE_MAP) {
      const url = BASE.replace(/\/$/, '') + pagePath;
      const r = await auditPage(pg, url, slotByPath[pagePath]);
      results.push({ name, path: pagePath, ...r });
      fs.writeFileSync(path.join(OUT, 'per-page', `${name}.json`), JSON.stringify(r, null, 2));
      process.stderr.write(
        `${pagePath}: imgs=${r.imagesTotal} broken=${r.imagesBroken} slotsMissing=${r.slotsMissing}\n`
      );
    }
  } finally {
    await browser.close();
  }

  const totalBroken = results.reduce((s, r) => s + r.imagesBroken, 0);
  const totalMissingSlots = results.reduce((s, r) => s + r.slotsMissing, 0);

  const summary = {
    generatedAt: new Date().toISOString(),
    base: BASE,
    imageMapSource: '_communication/team_110/image-map.json',
    pagesAudited: results.length,
    totalImages: results.reduce((s, r) => s + r.imagesTotal, 0),
    totalBroken,
    totalMissingSlots,
    pagesPass: results.filter((r) => r.pass).length,
    pagesFail: results.filter((r) => !r.pass).length,
    verdict: totalBroken === 0 && totalMissingSlots === 0 ? 'PASS' : 'FAIL',
    results: results.map(({ name, path: p, imagesTotal, imagesBroken, slotsExpected, slotsMissing, pass }) => ({
      name, path: p, imagesTotal, imagesBroken, slotsExpected, slotsMissing, pass,
    })),
  };

  fs.writeFileSync(path.join(OUT, 'summary.json'), JSON.stringify(summary, null, 2));
  console.log(JSON.stringify(summary, null, 2));
  process.exit(summary.verdict === 'PASS' ? 0 : 1);
}

main().catch((e) => {
  console.error(e);
  process.exit(2);
});
