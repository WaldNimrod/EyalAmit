#!/usr/bin/env node
/**
 * WP-W2-13 L-GATE_VALIDATE — AC-02 entrance play / reduce suppression (team_190).
 */
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');

const CHROME =
  process.env.EA_CHROME ||
  '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const BASE =
  process.env.EA_QA_BASE || 'https://eyalamit-co-il-2026.s887.upress.link';
const OUT = path.join(__dirname, 'reports', 'wp-w2-13-entrance-proof.json');

function delayOk(actual, expectedSec) {
  const n = parseFloat(String(actual).replace('s', ''));
  const e = parseFloat(expectedSec);
  return Math.abs(n - e) < 0.02;
}

function animNameOk(actual, expected) {
  const a = String(actual || '').toLowerCase();
  return a.includes(expected.toLowerCase());
}

async function measure(page, reduce) {
  await page.emulateMediaFeatures([
    { name: 'prefers-reduced-motion', value: reduce ? 'reduce' : 'no-preference' },
  ]);
  await page.goto(BASE.replace(/\/$/, '') + '/', {
    waitUntil: 'networkidle2',
    timeout: 90000,
  });
  return page.evaluate(() => {
    const cs = (sel) => {
      const el = document.querySelector(sel);
      if (!el) return { found: false, sel };
      const s = getComputedStyle(el);
      return {
        found: true,
        animationName: s.animationName,
        animationDelay: s.animationDelay,
        animation: s.animation,
        opacity: s.opacity,
      };
    };
    return {
      reduceMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
      pillar2: cs('.ea-pillars-grid .ea-pillar:nth-of-type(2)'),
      pillar3: cs('.ea-pillars-grid .ea-pillar:nth-of-type(3)'),
      pillar4: cs('.ea-pillars-grid .ea-pillar:nth-of-type(4)'),
      breathHeading: cs('.ea-content-section__heading.ea-entrance--breath'),
    };
  });
}

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors'],
  });
  const page = await browser.newPage();
  const resp = await page.goto(BASE.replace(/\/$/, '') + '/', {
    waitUntil: 'networkidle2',
    timeout: 90000,
  });

  const noPref = await measure(page, false);
  const reduce = await measure(page, true);

  const checks = [];
  const add = (id, pass, detail) => checks.push({ id, pass, detail });

  add('http', resp && resp.status() === 200, `status=${resp ? resp.status() : 'null'}`);

  add(
    'matchMedia_no_pref',
    noPref.reduceMotion === false,
    `reduceMotion=${noPref.reduceMotion}`
  );
  add(
    'matchMedia_reduce',
    reduce.reduceMotion === true,
    `reduceMotion=${reduce.reduceMotion}`
  );

  add(
    'pillar2_fadeUp',
    noPref.pillar2.found &&
      animNameOk(noPref.pillar2.animationName, 'ea-fadeUp') &&
      delayOk(noPref.pillar2.animationDelay, '0.1'),
    JSON.stringify(noPref.pillar2)
  );
  add(
    'pillar3_delay',
    noPref.pillar3.found && delayOk(noPref.pillar3.animationDelay, '0.2'),
    JSON.stringify(noPref.pillar3)
  );
  add(
    'pillar4_delay',
    noPref.pillar4.found && delayOk(noPref.pillar4.animationDelay, '0.3'),
    JSON.stringify(noPref.pillar4)
  );
  add(
    'breath_heading',
    noPref.breathHeading.found &&
      animNameOk(noPref.breathHeading.animationName, 'ea-breathReveal'),
    JSON.stringify(noPref.breathHeading)
  );

  const inert = (s) =>
    s.found &&
    (s.animationName === 'none' || s.animation === 'none' || s.animationName === '');
  add('reduce_pillar2', inert(reduce.pillar2), JSON.stringify(reduce.pillar2));
  add('reduce_pillar3', inert(reduce.pillar3), JSON.stringify(reduce.pillar3));
  add('reduce_breath', inert(reduce.breathHeading), JSON.stringify(reduce.breathHeading));

  const report = {
    date: new Date().toISOString().slice(0, 10),
    base: BASE,
    noPreference: noPref,
    reduce,
    checks,
    pass: checks.every((c) => c.pass),
  };

  fs.mkdirSync(path.dirname(OUT), { recursive: true });
  fs.writeFileSync(OUT, JSON.stringify(report, null, 2));
  await browser.close();

  console.log(JSON.stringify(report, null, 2));
  process.exit(report.pass ? 0 : 1);
})();
