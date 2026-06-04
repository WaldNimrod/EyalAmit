const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME = process.env.EA_CHROME || '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const base = 'http://eyalamit-co-il-2026.s887.upress.link';
const outDir = __dirname;

(async () => {
  const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();
  await page.setViewport({ width: 390, height: 844 });
  await page.goto(base + '/', { waitUntil: 'networkidle2' });

  const links = await page.evaluate((b) => {
    const sel = 'header a, nav a, .ea-cfoot a, footer a, .ea-mnav a, .ea-dnav a, .ea-chrome a';
    return [...document.querySelectorAll(sel)].map((a) => ({
      text: (a.textContent || '').trim().replace(/\s+/g, ' ').slice(0, 60),
      href: a.href,
      target: a.target || '',
      rel: a.rel || '',
      external: a.href.startsWith('http') && !a.href.startsWith(b),
    }));
  }, base);

  const uniq = {};
  for (const l of links) {
    if (!uniq[l.href]) uniq[l.href] = l;
  }

  const linkResults = [];
  for (const l of Object.values(uniq)) {
    let status = 'skip';
    if (l.external) status = 'external';
    else {
      try {
        const r = await page.goto(l.href, { waitUntil: 'domcontentloaded', timeout: 30000 });
        status = String(r.status());
      } catch (e) {
        status = 'ERR:' + String(e.message).slice(0, 60);
      }
    }
    linkResults.push({ ...l, status });
  }

  await page.setViewport({ width: 390, height: 844 });
  await page.goto(base + '/', { waitUntil: 'networkidle2' });
  const drawer = {};

  const toggleSel = 'button.ea-mnav-toggle, [data-ea-mnav-toggle], button[aria-controls*="mobile"], button[aria-label*="תפריט"], button[aria-label*="Menu"]';
  const toggle = await page.$(toggleSel);
  if (!toggle) {
    drawer.error = 'toggle not found: ' + toggleSel;
  } else {
    const toggleBox = await toggle.boundingBox();
    drawer.toggleSize = toggleBox ? { w: toggleBox.width, h: toggleBox.height } : null;

    await toggle.click();
    await new Promise((r) => setTimeout(r, 500));

    drawer.open = await page.evaluate(() => {
      const panel = document.querySelector('#ea-mobile-nav, .ea-mnav-panel, [data-ea-mnav-panel]');
      return {
        panelExists: !!panel,
        ariaHidden: panel?.getAttribute('aria-hidden'),
        bodyClass: document.body.className,
        bodyOverflow: getComputedStyle(document.body).overflow,
        expandedAccordions: [...document.querySelectorAll('[aria-expanded]')].map((e) => ({
          expanded: e.getAttribute('aria-expanded'),
          label: (e.textContent || '').trim().slice(0, 40),
        })),
        ariaCurrent: [...document.querySelectorAll('[aria-current]')].map((e) => ({
          href: e.href || '',
          text: (e.textContent || '').trim().slice(0, 30),
        })),
        focusTag: document.activeElement?.tagName,
        focusAria: document.activeElement?.getAttribute('aria-label'),
      };
    });

    await page.screenshot({ path: path.join(outDir, 'drawer-open-390.png'), fullPage: false });

    const closeSel = 'button[aria-label*="סגור"], button[aria-label*="Close"], .ea-mnav-close, button.ea-mnav-close';
    const closeBtn = await page.$(closeSel);
    if (closeBtn) {
      await closeBtn.click();
      await new Promise((r) => setTimeout(r, 400));
    }
    drawer.afterClose = await page.evaluate(() => {
      const panel = document.querySelector('#ea-mobile-nav, .ea-mnav-panel, [data-ea-mnav-panel]');
      return { ariaHidden: panel?.getAttribute('aria-hidden'), bodyOverflow: getComputedStyle(document.body).overflow };
    });

    await toggle.click();
    await new Promise((r) => setTimeout(r, 400));
    await page.keyboard.press('Escape');
    await new Promise((r) => setTimeout(r, 400));
    drawer.afterEsc = await page.evaluate(() => {
      const panel = document.querySelector('#ea-mobile-nav, .ea-mnav-panel, [data-ea-mnav-panel]');
      return panel?.getAttribute('aria-hidden');
    });

    // accordion test
    await toggle.click();
    await new Promise((r) => setTimeout(r, 400));
    const accBtn = await page.$('[aria-expanded="false"]');
    if (accBtn) {
      await accBtn.click();
      await new Promise((r) => setTimeout(r, 300));
      drawer.accordionAfterClick = await page.evaluate(() => {
        const open = document.querySelector('[aria-expanded="true"]');
        return open ? { label: (open.textContent || '').trim().slice(0, 40), expanded: open.getAttribute('aria-expanded') } : null;
      });
    }
  }

  await page.setViewport({ width: 1280, height: 900 });
  const mem1 = await (async () => {
    await page.goto(base + '/mokesh-dahiman/', { waitUntil: 'networkidle2' });
    return page.evaluate(() => ({
      url: location.href,
      h1: document.querySelector('h1')?.textContent?.trim(),
      bodyLen: document.body.innerText.length,
      canonical: document.querySelector('link[rel=canonical]')?.href,
      headings: [...document.querySelectorAll('h2,h3')].map((h) => h.textContent.trim()).slice(0, 8),
      dates: (document.body.innerText.match(/1950|2020|2026/g) || []),
    }));
  })();

  const mem2 = await (async () => {
    await page.goto(base + '/about/moksha/', { waitUntil: 'networkidle2' });
    return page.evaluate(() => ({
      url: location.href,
      h1: document.querySelector('h1')?.textContent?.trim(),
      bodyLen: document.body.innerText.length,
      canonical: document.querySelector('link[rel=canonical]')?.href,
      headings: [...document.querySelectorAll('h2,h3')].map((h) => h.textContent.trim()).slice(0, 8),
      dates: (document.body.innerText.match(/1950|2020|2026/g) || []),
    }));
  })();

  await page.goto(base + '/courses-external/', { waitUntil: 'networkidle2' });
  const coursesLink = await page.evaluate(() => {
    const ext = [...document.querySelectorAll('a[href^="http"]')].find((a) => !a.href.includes('eyalamit'));
    const hash = [...document.querySelectorAll('a[href="#"]')];
    return { external: ext ? { href: ext.href, target: ext.target, rel: ext.rel, text: ext.textContent.trim() } : null, hashLinks: hash.length };
  });

  await page.goto(base + '/contact/', { waitUntil: 'networkidle2' });
  const submit = await page.$('form button[type=submit], form input[type=submit], .wpcf7-submit');
  if (submit) {
    await submit.click();
    await new Promise((r) => setTimeout(r, 1500));
  }
  const formAfter = await page.evaluate(() => ({
    invalid: [...document.querySelectorAll(':invalid')].length,
    errors: [...document.querySelectorAll('.wpcf7-not-valid-tip, .error, [role=alert]')]
      .map((e) => e.textContent.trim())
      .filter(Boolean)
      .slice(0, 8),
    formId: document.querySelector('input[name="_wpcf7"]')?.value || document.querySelector('form')?.id,
  }));

  await page.setViewport({ width: 390, height: 844 });
  await page.goto(base + '/en/', { waitUntil: 'networkidle2' });
  const enMeta = await page.evaluate(() => ({
    dir: document.documentElement.dir,
    lang: document.documentElement.lang,
    pill: [...document.querySelectorAll('a')].find((a) => (a.textContent || '').includes('עברית'))?.href,
    menuSample: [...document.querySelectorAll('nav a, header a')].slice(0, 5).map((a) => a.textContent.trim()),
  }));

  await page.goto(base + '/method/', { waitUntil: 'networkidle2' });
  const methodContent = await page.evaluate(() => ({
    h1: document.querySelector('h1')?.textContent?.trim(),
    phrases: ['cbDIDG', 'לא כל עבודה עם', 'איך נולדה השיטה', 'ומה היום'].map((p) => ({
      p,
      found: document.body.innerText.includes(p),
    })),
    sectionCount: document.querySelectorAll('section, .ea-section').length,
  }));

  await page.goto(base + '/media/', { waitUntil: 'networkidle2' });
  const mediaContent = await page.evaluate(() => ({
    pressLinksHash: [...document.querySelectorAll('a[href="#"]')].length,
    pressLinksHttp: [...document.querySelectorAll('a[href^="http"]')].filter((a) => !a.href.includes('eyalamit')).length,
    itemCount: document.querySelectorAll('.ea-tgrid article, .ea-tgrid .ea-card, .ea-media-item').length,
  }));

  await page.goto(base + '/galleries/', { waitUntil: 'networkidle2' });
  const galleriesContent = await page.evaluate(() => ({
    itemCount: document.querySelectorAll('.ea-gallery-card, article, .ea-card').length,
    sampleTitles: [...document.querySelectorAll('h2,h3,.ea-card-title')].map((e) => e.textContent.trim()).slice(0, 5),
  }));

  fs.writeFileSync(path.join(outDir, 'link-coverage.json'), JSON.stringify({ total: linkResults.length, links: linkResults }, null, 2));
  fs.writeFileSync(
    path.join(outDir, 'interaction-tests.json'),
    JSON.stringify({ drawer, mem1, mem2, coursesLink, formAfter, enMeta, methodContent, mediaContent, galleriesContent }, null, 2)
  );

  console.log(JSON.stringify({ links: linkResults.length, drawer: drawer.error || 'ok', memSame: mem1.bodyLen === mem2.bodyLen, method: methodContent, formAfter }, null, 2));
  await browser.close();
})();
