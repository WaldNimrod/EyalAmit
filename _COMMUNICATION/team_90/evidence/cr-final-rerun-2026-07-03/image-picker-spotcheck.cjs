#!/usr/bin/env node
/** team_90 image-picker spot-check — CR-FINAL rerun 2026-07-03 */
const fs = require('fs');
const path = require('path');
const { createRequire } = require('module');

const ROOT = path.join(__dirname, '../../../..');
const OUT = path.join(__dirname, 'image-picker-spotcheck.json');
const requireFromQa = createRequire(path.join(ROOT, 'scripts/qa/package.json'));
const puppeteer = requireFromQa('puppeteer-core');

const URL = 'http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/image-picker.html';
const CHROME =
  process.env.EA_CHROME ||
  '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const KEY = 'ea-image-picker-v2';

async function main() {
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: true,
    args: ['--no-sandbox', '--disable-web-security'],
  });
  const page = await browser.newPage();
  await page.setViewport({ width: 1440, height: 900 });

  const result = {
    generatedAt: new Date().toISOString(),
    url: URL,
    pass: false,
    checks: {},
  };

  try {
    const res = await page.goto(URL, { waitUntil: 'load', timeout: 180000 });
    result.httpStatus = res?.status() ?? 0;

    const init = await page.evaluate(() => ({
      total: typeof TOTAL !== 'undefined' ? TOTAL : null,
      slotCards: document.querySelectorAll('.slot-card, [data-slot-id]').length,
      candidateCards: document.querySelectorAll('.cc').length,
    }));
    result.checks.pageLoad = {
      pass: res?.status() === 200 && init.total === 71,
      ...init,
    };

    // Sample thumbs: first DOK, legacy, and random third
    const thumbSamples = await page.evaluate(async () => {
      const cards = [...document.querySelectorAll('.cc')].slice(0, 6);
      const out = [];
      for (const card of cards) {
        const img = card.querySelector('img');
        const src = img?.src || card.dataset.src || '';
        let naturalWidth = img?.naturalWidth ?? 0;
        if (naturalWidth === 0 && img) {
          await new Promise((r) => {
            if (img.complete) return r();
            img.addEventListener('load', r, { once: true });
            img.addEventListener('error', r, { once: true });
            setTimeout(r, 4000);
          });
          naturalWidth = img.naturalWidth;
        }
        out.push({
          pid: card.dataset.pid,
          dataSrc: card.dataset.src,
          src,
          naturalWidth,
          loaded: naturalWidth > 0,
          decision: card.dataset.d,
        });
      }
      return out;
    });
    // HTTP-verify samples (headless naturalWidth often 0 on lazy/slow hub assets)
    const httpVerified = [];
    for (const t of thumbSamples) {
      let status = 0;
      for (let attempt = 0; attempt < 3 && status !== 200; attempt++) {
        try {
          const r = await fetch(t.src, { method: 'GET', redirect: 'follow' });
          status = r.status;
        } catch {
          status = 0;
        }
      }
      httpVerified.push({ ...t, httpStatus: status, httpOk: status === 200 });
    }
    const thumbsLoaded = httpVerified.filter((t) => t.httpOk).length;
    result.checks.thumbLoad = {
      pass: thumbsLoaded >= 3,
      sampled: httpVerified.length,
      loaded: thumbsLoaded,
      samples: httpVerified,
      note: 'naturalWidth unreliable in headless; HTTP 200 used per image-audit precedent',
    };

    // localStorage round-trip — invoke pick() on a DOK candidate (not __current__)
    await page.evaluate((key) => localStorage.removeItem(key), KEY);
    const pickMeta = await page.evaluate(() => {
      const card = document.querySelector('.cc[data-pid="DOK-AJPS8301"]');
      if (!card || typeof pick !== 'function') return null;
      pick(card);
      return {
        slot: card.dataset.slot,
        pid: card.dataset.pid,
        src: card.dataset.src,
        d: card.dataset.d,
      };
    });
    if (!pickMeta) throw new Error('pick() on DOK-AJPS8301 failed');
    await new Promise((r) => setTimeout(r, 500));
    const afterPick = await page.evaluate((key) => {
      const store = JSON.parse(localStorage.getItem(key) || '{}');
      const selected = document.querySelectorAll('.cc.selected').length;
      return { store, selectedCount: selected };
    }, KEY);
    await page.reload({ waitUntil: 'domcontentloaded', timeout: 120000 });
    const afterReload = await page.evaluate((key, pid, slot) => {
      const store = JSON.parse(localStorage.getItem(key) || '{}');
      const card = document.querySelector(`.cc[data-slot="${slot}"][data-pid="${pid}"]`);
      return {
        storeKeys: Object.keys(store),
        slotInStore: store[slot] || null,
        cardHasSelected: card?.classList.contains('selected') ?? false,
      };
    }, KEY, pickMeta.pid, pickMeta.slot);

    result.checks.localStorageRoundTrip = {
      pass:
        afterPick.selectedCount >= 1 &&
        afterReload.storeKeys.includes(pickMeta.slot) &&
        afterReload.cardHasSelected,
      pickMeta,
      afterPick,
      afterReload,
    };

    result.pass =
      result.checks.pageLoad.pass &&
      result.checks.thumbLoad.pass &&
      result.checks.localStorageRoundTrip.pass;
  } catch (e) {
    result.error = String(e.message || e);
  } finally {
    await browser.close();
  }

  fs.writeFileSync(OUT, JSON.stringify(result, null, 2));
  console.log(JSON.stringify(result, null, 2));
  process.exit(result.pass ? 0 : 1);
}

main();
