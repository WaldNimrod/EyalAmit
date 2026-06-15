#!/usr/bin/env node
/**
 * WP-W2-15-CR-FINAL — team_50 full E2E journey probe (leg 3/3).
 * Usage: node scripts/qa/cr-final-e2e.cjs [--out <dir>]
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
const SOURCE_ROOT = path.join(
  __dirname,
  '../../docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26'
);

const args = process.argv.slice(2);
let outDir = path.join(
  __dirname,
  '../../_COMMUNICATION/team_50/evidence/cr-final-e2e-2026-06-05'
);
for (let i = 0; i < args.length; i++) {
  if (args[i] === '--out') outDir = args[++i];
}

const VIEWPORTS = [
  { name: 'w360', w: 360, h: 800 },
  { name: 'w390', w: 390, h: 844 },
  { name: 'w414', w: 414, h: 896 },
  { name: 'w768', w: 768, h: 1024 },
  { name: 'desktop', w: 1440, h: 900 },
];

const JOURNEY_ROUTES = [
  '/',
  '/treatment/',
  '/method/',
  '/sound-healing/',
  '/lessons/',
  '/faq/',
  '/contact/',
  '/books/',
  '/books/vekatavta/',
  '/books/kushi-blantis/',
  '/books/tsva-bekahol/',
  '/didgeridoos/',
  '/bags/',
  '/stands-storage/',
  '/stand-floor/',
  '/repair/',
];

const NAV_EXPECTED = [
  { label: 'טיפול בדיג׳רידו', path: '/treatment' },
  { label: 'השיטה', path: '/method' },
  { label: 'שיעורי דיג׳רידו', path: '/lessons' },
  { label: 'סאונד הילינג', path: '/sound-healing' },
  { label: 'מוזה הוצאה לאור', path: '/books' },
  { label: 'בלוג דיג׳רידו', path: '/blog' },
  { label: 'צור קשר', path: '/contact' },
];

const VERBATIM_CHECKS = [
  {
    route: '/treatment/',
    source: "טיפול בדיג'רידו/treatment.md",
    phrases: [
      'משהו בנשימה שלך מבקש תשומת לב',
      'טיפול בדיג\'רידו',
      'לתיאום שיחת היכרות',
    ],
  },
  {
    route: '/repair/',
    source: "תיקון כלי דיג'רידו/build didg.md",
    phrases: ['מעל שני עשורים', 'כל תיקון מתחיל בבדיקה'],
  },
  {
    route: '/books/vekatavta/',
    source: 'וכתבת/vekatavta.md',
    phrases: [
      '46 סיפורים אמיתיים',
      'היקיקומורי',
      'בקוסטה ריקה הכרתי וטיילתי שבוע עם היקיקומורי',
    ],
    forbidden: ['היקוקומורי', 'היקוקמורי'],
  },
];

const PURCHASE_LINKS = [
  { route: '/books/tsva-bekahol/', url: 'https://www.mendele.co.il/product/tzvabekahol/' },
  { route: '/books/kushi-blantis/', url: 'https://mrng.to/MTUiO3vkIg' },
  { route: '/books/vekatavta/', url: 'https://www.mendele.co.il/product/vekatavta/' },
];

function fetchRedirectChain(url) {
  return new Promise((resolve) => {
    const chain = [];
    const follow = (u, depth) => {
      if (depth > 8) return resolve({ chain, error: 'too many redirects' });
      const httpUrl = u.replace(/^https:/, 'http:');
      const lib = httpUrl.startsWith('https') ? https : http;
      const req = lib.get(httpUrl, { timeout: 30000, rejectUnauthorized: false }, (res) => {
        res.resume();
        chain.push({ url: u, status: res.statusCode, location: res.headers.location || null });
        if ([301, 302, 307, 308].includes(res.statusCode) && res.headers.location) {
          const next = new URL(res.headers.location, u).href;
          follow(next, depth + 1);
        } else {
          resolve({ chain, final: chain[chain.length - 1] });
        }
      });
      req.on('error', (e) => resolve({ chain, error: String(e.message || e) }));
      req.on('timeout', () => {
        req.destroy();
        resolve({ chain, error: 'timeout' });
      });
    };
    follow(url, 0);
  });
}

function headStatus(url) {
  return new Promise((resolve) => {
    const lib = url.startsWith('https') ? https : http;
    const req = lib.request(url, { method: 'HEAD', timeout: 20000, rejectUnauthorized: false }, (res) => {
      res.resume();
      resolve(res.statusCode);
    });
    req.on('error', () => resolve(null));
    req.on('timeout', () => {
      req.destroy();
      resolve(null);
    });
    req.end();
  });
}

function add(checks, id, pass, detail) {
  checks.push({ id, pass, detail });
}

(async () => {
  fs.mkdirSync(outDir, { recursive: true });
  const checks = [];
  const report = {
    generated: new Date().toISOString(),
    base: BASE,
    branch: 'main @ 9c48714',
    gate: 'CR-FINAL_FULL_E2E',
    wp: 'WP-W2-15-CR-FINAL',
  };

  // --- HTTP redirect: /muzza -> /books ---
  const muzza = await fetchRedirectChain(BASE.replace(/\/$/, '') + '/muzza');
  const muzzaFinal = muzza.final || {};
  const muzzaOk =
    !muzza.error &&
    muzza.chain.some((s) => [301, 302].includes(s.status)) &&
    String(muzzaFinal.url || '').includes('/books');
  add(checks, 'redirect_muzza_to_books', muzzaOk, JSON.stringify(muzza));

  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors'],
  });

  const consoleErrors = [];
  const page = await browser.newPage();
  page.on('console', (msg) => {
    if (msg.type() === 'error') consoleErrors.push({ text: msg.text(), url: page.url() });
  });
  page.on('pageerror', (err) => consoleErrors.push({ text: String(err.message), url: page.url() }));

  // --- Desktop nav links ---
  await page.setViewport({ width: 1440, height: 900 });
  await page.goto(BASE + '/', { waitUntil: 'domcontentloaded', timeout: 90000 });
  const navLinks = await page.evaluate(() => {
    const links = Array.from(document.querySelectorAll('.ea-topnav__links a.ea-topnav__link'));
    return links.map((a) => ({
      text: (a.textContent || '').trim(),
      href: a.getAttribute('href') || '',
    }));
  });
  for (const exp of NAV_EXPECTED) {
    const found = navLinks.find((l) => l.text.includes(exp.label) || l.href.includes(exp.path));
    add(checks, `nav_${exp.path}`, !!found, found ? JSON.stringify(found) : `missing ${exp.label}`);
  }
  const muzzaNav = navLinks.find((l) => l.text.includes('מוזה הוצאה לאור'));
  add(
    checks,
    'nav_muzza_href_books',
    !!(muzzaNav && muzzaNav.href.includes('/books')),
    muzzaNav ? muzzaNav.href : 'not found'
  );

  const goto = async (route) => {
    const resp = await page.goto(BASE + route, { waitUntil: 'domcontentloaded', timeout: 90000 });
    return resp ? resp.status() : null;
  };

  // --- Journey: nav hrefs resolve (HTTP + title) ---
  for (const exp of NAV_EXPECTED) {
    const status = await goto(exp.path + (exp.path.endsWith('/') ? '' : '/'));
    const title = await page.title();
    add(
      checks,
      `journey_nav_${exp.path}`,
      status === 200 && title.length > 0,
      JSON.stringify({ status, url: page.url(), title: title.slice(0, 60) })
    );
  }

  // --- Home -> service -> FAQ -> contact (sequential goto simulates journey) ---
  const serviceJourney = ['/treatment/', '/faq/', '/contact/'];
  for (const route of serviceJourney) {
    const status = await goto(route);
    add(checks, `journey_service${route}`, status === 200, page.url());
  }

  // --- Books hub -> detail + back link href ---
  await goto('/books/');
  const bookSlugs = ['vekatavta', 'kushi-blantis', 'tsva-bekahol'];
  for (const slug of bookSlugs) {
    const status = await goto(`/books/${slug}/`);
    add(checks, `journey_book_${slug}`, status === 200 && page.url().includes(slug), page.url());
    const backHref = await page.evaluate(() => {
      const el = document.querySelector('.ea-book-detail-hero__back, .ea-book-hero__back');
      return el ? el.getAttribute('href') : null;
    });
    add(
      checks,
      `backlink_book_${slug}`,
      !!(backHref && backHref.includes('/books')),
      backHref || 'back link missing'
    );
  }

  // --- Contact CTAs on service pages (hero CTA href) ---
  const ctaPages = ['/treatment/', '/method/', '/sound-healing/', '/lessons/'];
  for (const route of ctaPages) {
    await goto(route);
    const ctaHref = await page.evaluate(() => {
      const main = document.querySelector('main') || document.body;
      const cta = main.querySelector('a[href*="/contact"]');
      return cta ? cta.getAttribute('href') : null;
    });
    add(
      checks,
      `cta_contact_${route}`,
      !!(ctaHref && ctaHref.includes('/contact')),
      ctaHref || 'no contact CTA in main'
    );
  }

  // --- Purchase links present + HEAD ---
  for (const pl of PURCHASE_LINKS) {
    await page.goto(BASE + pl.route, { waitUntil: 'domcontentloaded', timeout: 60000 });
    const hrefs = await page.evaluate(() =>
      Array.from(document.querySelectorAll('a[data-ea-book-purchase], .ea-cta-ab--purchase a, a[href*="mendele"], a[href*="mrng"]'))
        .map((a) => a.href)
    );
    const present = hrefs.some((h) => h === pl.url || h.startsWith(pl.url) || h.includes(new URL(pl.url).hostname));
    const status = await headStatus(pl.url);
    add(
      checks,
      `purchase_${pl.route}`,
      present && status && status < 400,
      JSON.stringify({ present, status, hrefs: hrefs.slice(0, 5) })
    );
  }

  // --- Verbatim + images + overflow per route/viewport ---
  const overflowFails = [];
  const imageFails = [];
  const verbatimResults = [];

  for (const vc of VERBATIM_CHECKS) {
    await page.goto(BASE + vc.route, { waitUntil: 'domcontentloaded', timeout: 60000 });
    const bodyText = await page.evaluate(() => document.body.innerText);
    const phraseHits = vc.phrases.map((p) => ({ phrase: p, found: bodyText.includes(p) }));
    const forbiddenHits = (vc.forbidden || []).map((p) => ({ phrase: p, found: bodyText.includes(p) }));
    const hikikomoriCount = (bodyText.match(/היקיקומורי/g) || []).length;
    verbatimResults.push({
      route: vc.route,
      source: vc.source,
      phraseHits,
      forbiddenHits,
      hikikomoriCount,
      pass:
        phraseHits.every((p) => p.found) && forbiddenHits.every((p) => !p.found),
    });
    add(
      checks,
      `verbatim_${vc.route}`,
      phraseHits.every((p) => p.found) && forbiddenHits.every((p) => !p.found),
      JSON.stringify({ phraseHits, forbiddenHits, hikikomoriCount })
    );
  }

  for (const route of JOURNEY_ROUTES) {
    for (const vp of VIEWPORTS) {
      await page.setViewport({
        width: vp.w,
        height: vp.h,
        isMobile: vp.w < 1024,
        hasTouch: vp.w < 1024,
      });
      await page.goto(BASE + route, { waitUntil: 'domcontentloaded', timeout: 90000 });
      await page.evaluate(async () => {
        const imgs = Array.from(document.images).filter((img) => img.src && !img.src.startsWith('data:'));
        for (const img of imgs) {
          try {
            img.scrollIntoView({ block: 'nearest' });
          } catch (_) {
            /* ignore */
          }
        }
        await Promise.all(
          imgs.map(
            (img) =>
              new Promise((resolve) => {
                if (img.complete && img.naturalWidth > 0) return resolve();
                img.addEventListener('load', resolve, { once: true });
                img.addEventListener('error', resolve, { once: true });
                setTimeout(resolve, 3000);
              })
          )
        );
      });
      const metrics = await page.evaluate(() => {
        const doc = document.documentElement;
        const brokenImgs = Array.from(document.images).filter(
          (img) =>
            img.naturalWidth === 0 &&
            img.src &&
            !img.src.startsWith('data:') &&
            getComputedStyle(img).display !== 'none' &&
            img.offsetParent !== null
        );
        return {
          overflow: doc.scrollWidth > doc.clientWidth + 1,
          scrollWidth: doc.scrollWidth,
          clientWidth: doc.clientWidth,
          brokenImages: brokenImgs.length,
          brokenSrcs: brokenImgs.map((img) => img.src).slice(0, 3),
          h1: document.querySelectorAll('h1').length,
          dir: document.documentElement.getAttribute('dir'),
        };
      });
      if (metrics.overflow) {
        overflowFails.push({ route, vp: vp.name, ...metrics });
      }
      if (metrics.brokenImages > 0) {
        imageFails.push({ route, vp: vp.name, broken: metrics.brokenImages });
      }
      if (vp.name === 'w390') {
        add(
          checks,
          `structure_${route.replace(/\//g, '_')}`,
          metrics.h1 === 1 && metrics.dir === 'rtl',
          JSON.stringify(metrics)
        );
      }
    }
  }

  // --- Mobile drawer (WP-W2-14) @390 ---
  await page.setViewport({ width: 390, height: 844, isMobile: true, hasTouch: true });
  await page.goto(BASE + '/', { waitUntil: 'domcontentloaded', timeout: 60000 });
  const burger = await page.$('.ea-mnav-burger');
  add(checks, 'mobile_drawer_burger_present', !!burger, burger ? 'found' : 'missing');
  if (burger) {
    await page.evaluate(() => document.querySelector('.ea-mnav-burger')?.click());
    await page.waitForFunction(() => document.documentElement.classList.contains('ea-mnav-open'), {
      timeout: 5000,
    });
    const drawerState = await page.evaluate(() => ({
      open: document.documentElement.classList.contains('ea-mnav-open'),
      drawerLinks: document.querySelectorAll('#ea-mnav-drawer a').length,
      ariaExpanded: document.querySelector('.ea-mnav-burger')?.getAttribute('aria-expanded'),
    }));
    add(checks, 'mobile_drawer_opens', drawerState.open && drawerState.drawerLinks > 5, JSON.stringify(drawerState));
    const drawerMuzza = await page.evaluate(() => {
      const a = Array.from(document.querySelectorAll('#ea-mnav-drawer a')).find((el) =>
        (el.textContent || '').includes('מוזה')
      );
      return a ? { href: a.href, text: a.textContent.trim() } : null;
    });
    add(
      checks,
      'mobile_drawer_muzza_books',
      !!(drawerMuzza && drawerMuzza.href.includes('/books')),
      JSON.stringify(drawerMuzza)
    );
    await page.keyboard.press('Escape');
    await page.waitForFunction(() => !document.documentElement.classList.contains('ea-mnav-open'), {
      timeout: 5000,
    });
    add(
      checks,
      'mobile_drawer_closes',
      !(await page.evaluate(() => document.documentElement.classList.contains('ea-mnav-open'))),
      'closed via Escape'
    );
  }

  // Filter benign console errors (favicon, third-party)
  const blockingConsole = consoleErrors.filter(
    (e) =>
      !/favicon/i.test(e.text) &&
      !/Failed to load resource.*404/i.test(e.text) &&
      !/net::ERR_/i.test(e.text)
  );
  add(
    checks,
    'console_errors',
    blockingConsole.length === 0,
    JSON.stringify({ total: consoleErrors.length, blocking: blockingConsole.slice(0, 10) })
  );
  add(checks, 'overflow_journey_routes', overflowFails.length === 0, JSON.stringify(overflowFails.slice(0, 10)));
  add(checks, 'broken_images', imageFails.length === 0, JSON.stringify(imageFails.slice(0, 10)));

  await browser.close();

  report.checks = checks;
  report.pass = checks.every((c) => c.pass);
  report.failCount = checks.filter((c) => !c.pass).length;
  report.verbatimResults = verbatimResults;
  report.overflowFails = overflowFails;
  report.imageFails = imageFails;
  report.consoleErrors = consoleErrors;

  const outPath = path.join(outDir, 'e2e_probe_result.json');
  fs.writeFileSync(outPath, JSON.stringify(report, null, 2));

  console.log(JSON.stringify({ pass: report.pass, failCount: report.failCount, out: outPath }, null, 2));
  for (const c of checks.filter((x) => !x.pass)) {
    console.log(`FAIL ${c.id}: ${c.detail}`);
  }
  process.exit(report.pass ? 0 : 1);
})().catch((e) => {
  console.error('FATAL:', e);
  process.exit(2);
});
