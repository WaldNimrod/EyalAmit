#!/usr/bin/env node
/**
 * WP-W2-12 REV2 — AC-01 computed-style equivalence proof (team_190).
 * Independent reproduction of team_100 disposition measurements.
 */
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');

const CHROME =
  process.env.EA_CHROME ||
  '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const BASE = process.env.EA_QA_BASE || 'http://eyalamit-co-il-2026.s887.upress.link';
const OUT = path.join(__dirname, 'reports', 'wp-w2-12-rev2-computed-proof.json');

const TOLERANCE_PX = 0.5;

function near(a, b, tol = TOLERANCE_PX) {
  return Math.abs(Number(a) - Number(b)) <= tol;
}

function parsePx(v) {
  if (v == null || v === '') return NaN;
  const m = String(v).match(/^([\d.]+)px$/);
  return m ? parseFloat(m[1]) : NaN;
}

function rgbMatch(actual, expected) {
  const norm = (s) => String(s).replace(/\s/g, '');
  return norm(actual) === norm(expected);
}

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors'],
  });
  const page = await browser.newPage();
  await page.emulateMediaFeatures([{ name: 'prefers-reduced-motion', value: 'no-preference' }]);
  const resp = await page.goto(BASE.replace(/\/$/, '') + '/', {
    waitUntil: 'networkidle2',
    timeout: 90000,
  });

  const data = await page.evaluate(() => {
    const cs = (sel) => {
      const el = document.querySelector(sel);
      if (!el) return { found: false };
      const s = getComputedStyle(el);
      return {
        found: true,
        marginTop: s.marginTop,
        textAlign: s.textAlign,
        fontSize: s.fontSize,
        fontWeight: s.fontWeight,
        color: s.color,
        marginBottom: s.marginBottom,
        animationName: s.animationName,
        animationDelay: s.animationDelay,
        opacity: s.opacity,
      };
    };
    const root = getComputedStyle(document.documentElement);
    return {
      reduceMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
      tokens: {
        '--ea-space-6': root.getPropertyValue('--ea-space-6').trim(),
        '--ea-space-4': root.getPropertyValue('--ea-space-4').trim(),
        '--ea-muted': root.getPropertyValue('--ea-muted').trim(),
        '--ea-stagger-step': root.getPropertyValue('--ea-stagger-step').trim(),
      },
      selectors: {
        blockCtaEnd: cs('.ea-block-cta-end'),
        comparisonNote: cs('.ea-service-comparison__note'),
        contactNoteCta: cs('.ea-contact-form__note--cta'),
        pillar2: cs('.ea-pillars-grid .ea-pillar:nth-of-type(2)'),
        comparisonCol2: cs('.ea-service-comparison__grid .ea-service-comparison__col:nth-of-type(2)'),
        testimonial3: cs('.ea-testimonials-grid .ea-testimonial-card:nth-of-type(3)'),
        serviceTile2: cs('.ea-services-grid .ea-service-tile:nth-of-type(2)'),
        contactForm: cs('.ea-contact-section__form.ea-entrance'),
      },
      counts: {
        pillars: document.querySelectorAll('.ea-pillars-grid .ea-pillar').length,
        testimonials: document.querySelectorAll('.ea-testimonials-grid .ea-testimonial-card').length,
        books: document.querySelectorAll('.ea-books-grid .ea-book-card').length,
        comparisonCols: document.querySelectorAll('.ea-service-comparison__grid .ea-service-comparison__col').length,
        serviceTiles: document.querySelectorAll('.ea-services-grid .ea-service-tile').length,
        contactFormSide: document.querySelector('.ea-contact-section__form') ? 1 : 0,
        contactCtaSide: document.querySelector('.ea-contact-section__cta-side') ? 1 : 0,
      },
      blockInlineStyles: [
        '.ea-pillars-grid',
        '.ea-service-comparison__grid',
        '.ea-testimonials-grid',
        '.ea-books-grid',
        '.ea-services-grid',
        '.ea-contact-section',
      ].map((root) => {
        const el = document.querySelector(root);
        if (!el) return { root, found: false, withStyle: 0 };
        const withStyle = el.querySelectorAll('[style]').length;
        return { root, found: true, withStyle };
      }),
    };
  });

  const checks = [];
  const add = (id, pass, detail) => checks.push({ id, pass, detail });

  add('http', resp && resp.status() === 200, `status=${resp ? resp.status() : 'null'}`);
  add('reduce_false', data.reduceMotion === false, `reduceMotion=${data.reduceMotion}`);

  const t = data.tokens;
  add('token_space6', t['--ea-space-6'] === '48px', t['--ea-space-6']);
  add('token_space4', t['--ea-space-4'] === '32px', t['--ea-space-4']);
  add('token_muted', t['--ea-muted'].toUpperCase() === '#6F635A', t['--ea-muted']);
  add('token_stagger', t['--ea-stagger-step'] === '0.05s', t['--ea-stagger-step']);

  const cta = data.selectors.blockCtaEnd;
  add(
    'cta_end',
    cta.found &&
      near(parsePx(cta.marginTop), 48) &&
      cta.textAlign === 'right',
    JSON.stringify(cta)
  );

  const note = data.selectors.comparisonNote;
  add(
    'comparison_note',
    note.found &&
      near(parsePx(note.fontSize), 12.48) &&
      note.fontWeight === '200' &&
      rgbMatch(note.color, 'rgb(111, 99, 90)') &&
      near(parsePx(note.marginBottom), 32),
    JSON.stringify(note)
  );

  const contact = data.selectors.contactNoteCta;
  add(
    'contact_note_cta',
    contact.found && near(parsePx(contact.marginTop), 32),
    JSON.stringify(contact)
  );

  const inert = (s, label) => {
    const ok =
      s.found &&
      (s.animationName === 'none' || s.animationName === '') &&
      (s.animationDelay === '0s' || s.animationDelay === '') &&
      s.opacity === '1';
    add(label, ok, JSON.stringify(s));
  };
  inert(data.selectors.pillar2, 'pillar2_inert');
  inert(data.selectors.comparisonCol2, 'comparison_col2_inert');
  inert(data.selectors.testimonial3, 'testimonial3_inert');
  inert(data.selectors.serviceTile2, 'service_tile2_inert');
  inert(data.selectors.contactForm, 'contact_form_inert');

  add(
    'layout_counts',
    data.counts.pillars === 4 &&
      data.counts.testimonials === 3 &&
      data.counts.books === 3 &&
      data.counts.comparisonCols === 2 &&
      data.counts.serviceTiles === 2 &&
      data.counts.contactFormSide === 1 &&
      data.counts.contactCtaSide === 1,
    JSON.stringify(data.counts)
  );

  const blockStyleOk = data.blockInlineStyles.every((b) => b.found && b.withStyle === 0);
  add('ac02_block_inline', blockStyleOk, JSON.stringify(data.blockInlineStyles));

  const report = {
    date: new Date().toISOString().slice(0, 10),
    base: BASE,
    route: '/',
    engine: 'cursor-composer-rev2',
    checks,
    raw: data,
    pass: checks.every((c) => c.pass),
  };

  fs.mkdirSync(path.dirname(OUT), { recursive: true });
  fs.writeFileSync(OUT, JSON.stringify(report, null, 2));

  const desktopShot = path.join(__dirname, 'reports', 'wp-w2-12-rev2-home-desktop.png');
  const mobileShot = path.join(__dirname, 'reports', 'wp-w2-12-rev2-home-mobile.png');
  await page.setViewport({ width: 1440, height: 900 });
  await page.screenshot({ path: desktopShot, fullPage: true });
  await page.setViewport({ width: 390, height: 844, isMobile: true });
  await page.screenshot({ path: mobileShot, fullPage: true });

  await browser.close();

  console.log(JSON.stringify({ pass: report.pass, checks, out: OUT, desktopShot, mobileShot }, null, 2));
  process.exit(report.pass ? 0 : 1);
})();
