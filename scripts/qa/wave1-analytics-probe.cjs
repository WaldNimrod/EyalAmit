#!/usr/bin/env node
/** Wave-1 analytics runtime probe — generate_lead on WhatsApp click */
const puppeteer = require('puppeteer-core');
const CHROME = process.env.EA_CHROME || '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const BASE = 'http://eyalamit-co-il-2026.s887.upress.link';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors'],
  });
  const page = await browser.newPage();
  const events = [];
  await page.exposeFunction('__captureGtag', (name, params) => events.push({ name, params }));
  await page.goto(BASE + '/', { waitUntil: 'networkidle2', timeout: 90000 });
  await page.evaluate(() => {
    window.dataLayer = window.dataLayer || [];
    window.gtag = function (cmd, name, params) {
      if (cmd === 'event') window.__captureGtag(name, params || {});
      window.dataLayer.push(arguments);
    };
  });
  const waVisible = await page.evaluate(() => {
    const wa = document.querySelector('.ea-whatsapp-float');
    if (!wa) return { exists: false };
    const style = window.getComputedStyle(wa);
    return { exists: true, display: style.display, href: wa.href, hasText: wa.href.includes('?text=') };
  });
  await page.click('.ea-whatsapp-float');
  await new Promise((r) => setTimeout(r, 500));
  const hasGenerateLead = events.some((e) => e.name === 'generate_lead' && e.params?.method === 'whatsapp');
  const hasFormListener = await page.evaluate(() => {
    const src = document.querySelector('script[src*="ea-ab-testing"]')?.src || '';
    return fetch(src).then((r) => r.text()).then((t) => t.includes("track('generate_lead'") && t.includes('wpcf7mailsent') && t.includes("display = 'dual'"));
  });
  const ga4InHead = await page.evaluate(() => !!document.querySelector('script[src*="G-MRXESK7QJF"]'));
  const clarityInHead = await page.evaluate(() => !!document.querySelector('script[src*="clarity.ms"]'));
  const result = { waVisible, events, hasGenerateLead, hasFormListener, ga4InHead, clarityInHead, pass: waVisible.exists && waVisible.display !== 'none' && hasGenerateLead && hasFormListener && ga4InHead && !clarityInHead };
  console.log(JSON.stringify(result, null, 2));
  await browser.close();
  process.exit(result.pass ? 0 : 1);
})();
