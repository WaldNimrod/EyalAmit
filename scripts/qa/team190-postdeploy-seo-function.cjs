#!/usr/bin/env node
/** team_190 post-deploy closure — B5 SEO + B7 function probes */
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');

const BASE = 'http://eyalamit-co-il-2026.s887.upress.link';
const NC = `team190-${Date.now()}`;
const EVIDENCE = path.join(__dirname, '../../_COMMUNICATION/team_190/evidence/chapters-postdeploy-closure-2026-06-23');
const CHROME = process.env.EA_CHROME || '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

async function chainFrom(route) {
  const hops = [];
  let url = `${BASE}${route}?nc=${NC}`;
  for (let i = 0; i < 5; i++) {
    const res = await fetch(url, { redirect: 'manual' });
    const loc = res.headers.get('location');
    hops.push({ url, status: res.status, location: loc });
    if (![301, 302, 307, 308].includes(res.status) || !loc) break;
    url = new URL(loc, url).href;
  }
  return hops;
}

async function redirectProbes() {
  const cases = [
    { from: '/muzza/', expectTo: '/books/' },
    { from: '/about/moksha/', expectTo: '/eyal-amit/mokesh-dahiman/' },
    { from: '/mokesh/', expectTo: '/eyal-amit/mokesh-dahiman/' },
  ];
  const results = [];
  for (const c of cases) {
    const hops = await chainFrom(c.from);
    const oneHop = hops.length === 2 && hops[0].status === 301;
    const finalPath = new URL(hops[hops.length - 1].url).pathname;
    const pass = oneHop && finalPath === c.expectTo;
    results.push({ ...c, hops, oneHop, pass });
  }
  return { generatedAt: new Date().toISOString(), base: BASE, cacheBust: NC, results };
}

async function getBlogPostLinks(browser, blogPath) {
  const page = await browser.newPage();
  await page.goto(`${BASE}${blogPath}?nc=${NC}`, { waitUntil: 'networkidle2', timeout: 90000 });
  const links = await page.evaluate(() => {
    const host = window.location.host;
    const sel = '.ea-blog-card h2 a[href], .ea-blog-card .ea-blog-card__title a[href], .ea-blog-card a.ea-blog-card__link[href]';
    return [...new Set(
      [...document.querySelectorAll(sel)]
        .map((a) => a.href)
        .filter((h) => {
          if (!h.includes(host)) return false;
          if (h.includes('/blog/page/') || /\/blog\/?$/.test(h)) return false;
          if (h.includes('/category/') || h.includes('/tag/') || h.includes('/author/')) return false;
          return true;
        })
    )];
  });
  await page.close();
  return links;
}

async function blogPagination(browser) {
  const page1 = await getBlogPostLinks(browser, '/blog/');
  const page2 = await getBlogPostLinks(browser, '/blog/page/2/');
  const shared = page1.filter((u) => page2.includes(u));
  return {
    generatedAt: new Date().toISOString(),
    base: BASE,
    cacheBust: NC,
    page1Count: page1.length,
    page2Count: page2.length,
    sharedCount: shared.length,
    shared,
    page1,
    page2,
    pass: shared.length === 0 && page1.length > 0 && page2.length > 0,
  };
}

function analyzeHead(html) {
  const metaDesc = (html.match(/<meta[^>]+name=["']description["'][^>]*>/gi) || []).length;
  const ogImage = (html.match(/<meta[^>]+property=["']og:image["'][^>]*>/gi) || []).length;
  const canonical = /<link[^>]+rel=["']canonical["'][^>]*>/i.test(html);
  const yoastGraph = /application\/ld\+json[^>]*>[\s\S]*?@graph/i.test(html);
  return { metaDescriptionCount: metaDesc, ogImageCount: ogImage, canonicalPresent: canonical, yoastGraphPresent: yoastGraph };
}

async function headSpotcheck() {
  const routes = [
    { name: 'home', path: '/' },
    { name: 'treatment', path: '/treatment/' },
    { name: 'blog_single', path: '/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa/' },
  ];
  const results = [];
  for (const r of routes) {
    const res = await fetch(`${BASE}${r.path}?nc=${NC}`);
    const html = await res.text();
    const head = analyzeHead(html);
    results.push({
      name: r.name,
      path: r.path,
      status: res.status,
      ...head,
      pass: res.status === 200 && head.canonicalPresent && head.yoastGraphPresent && head.ogImageCount === 1 && head.metaDescriptionCount >= 1,
    });
  }
  return { generatedAt: new Date().toISOString(), base: BASE, cacheBust: NC, results };
}

async function contactWhatsappProbe(browser) {
  const page = await browser.newPage();
  const gtagEvents = [];
  await page.exposeFunction('__captureGtag', (name, params) => gtagEvents.push({ name, params }));
  await page.evaluateOnNewDocument(() => {
    window.dataLayer = window.dataLayer || [];
    function installWrap() {
      const prev = window.gtag;
      window.gtag = function (cmd, name, params) {
        if (cmd === 'event' && typeof window.__captureGtag === 'function') {
          window.__captureGtag(name, params || {});
        }
        if (typeof prev === 'function') return prev.apply(this, arguments);
        window.dataLayer.push(arguments);
      };
    }
    installWrap();
    document.addEventListener('DOMContentLoaded', installWrap);
    window.addEventListener('load', installWrap);
  });
  let clickError = null;
  await page.goto(`${BASE}/contact/?nc=${NC}`, { waitUntil: 'networkidle2', timeout: 90000 });
  await page.evaluate(installWrap => {
    function installWrap() {
      const prev = window.gtag;
      window.gtag = function (cmd, name, params) {
        if (cmd === 'event' && typeof window.__captureGtag === 'function') {
          window.__captureGtag(name, params || {});
        }
        if (typeof prev === 'function') return prev.apply(this, arguments);
        window.dataLayer.push(arguments);
      };
    }
    installWrap();
  });
  const cf7 = await page.evaluate(() => ({
    hasWpcf7: !!document.querySelector('.wpcf7'),
    formCount: document.querySelectorAll('form').length,
    wpcf7FormCount: document.querySelectorAll('form.wpcf7-form').length,
  }));
  const whatsapp = await page.evaluate(() => {
    const float = document.querySelector('.ea-whatsapp-float[data-ea-ab]');
    const inline = document.querySelector('[data-ea-ab-wa]');
    const el = float || inline || document.querySelector('a[href*="wa.me"]');
    if (!el) return { exists: false };
    const style = window.getComputedStyle(el);
    return {
      exists: true,
      selector: float ? '.ea-whatsapp-float' : inline ? '[data-ea-ab-wa]' : 'a[href*="wa.me"]',
      display: style.display,
      href: el.getAttribute('href'),
      hasTextParam: (el.getAttribute('href') || '').includes('text='),
    };
  });
  if (whatsapp.exists) {
    try {
      const sel = whatsapp.selector === '.ea-whatsapp-float'
        ? '.ea-whatsapp-float[data-ea-ab]'
        : whatsapp.selector === '[data-ea-ab-wa]'
          ? '[data-ea-ab-wa]'
          : 'a[href*="wa.me"]';
      await page.evaluate((s) => {
        const el = document.querySelector(s);
        if (el) el.dispatchEvent(new MouseEvent('click', { bubbles: true, cancelable: true }));
      }, sel);
      await new Promise((r) => setTimeout(r, 500));
    } catch (e) {
      clickError = String(e.message || e);
    }
  }
  const hasGenerateLead = gtagEvents.some((e) => e.name === 'generate_lead');
  const out = {
    generatedAt: new Date().toISOString(),
    base: BASE,
    cacheBust: NC,
    finalUrl: page.url(),
    cf7,
    whatsapp,
    gtagEvents,
    hasGenerateLead,
    clickError,
    pass: cf7.hasWpcf7 && whatsapp.exists && whatsapp.hasTextParam && hasGenerateLead,
  };
  await page.close();
  return out;
}

(async () => {
  const seoDir = path.join(EVIDENCE, 'seo');
  const fnDir = path.join(EVIDENCE, 'function');
  fs.mkdirSync(seoDir, { recursive: true });
  fs.mkdirSync(fnDir, { recursive: true });

  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors'],
  });

  const [redirects, blog, head, contact] = await Promise.all([
    redirectProbes(),
    blogPagination(browser),
    headSpotcheck(),
    contactWhatsappProbe(browser),
  ]);

  await browser.close();

  fs.writeFileSync(path.join(seoDir, 'redirect_onehop_checks.json'), JSON.stringify(redirects, null, 2));
  fs.writeFileSync(path.join(seoDir, 'blog_pagination_posts.json'), JSON.stringify(blog, null, 2));
  fs.writeFileSync(path.join(seoDir, 'seo_head_spotcheck.json'), JSON.stringify(head, null, 2));
  fs.writeFileSync(path.join(fnDir, 'contact_whatsapp_probe.json'), JSON.stringify(contact, null, 2));

  console.log('redirects', redirects.results.every((r) => r.pass));
  console.log('blog', blog.pass, 'shared', blog.sharedCount, 'p1', blog.page1Count, 'p2', blog.page2Count);
  console.log('head', head.results.every((r) => r.pass));
  console.log('contact', contact.pass, 'generate_lead', contact.hasGenerateLead, 'events', contact.gtagEvents.length);
})().catch((e) => {
  console.error(e);
  process.exit(1);
});
