#!/usr/bin/env node
/** team_90 hub admin functional smoke — CR-FINAL 2026-07-02 */
const fs = require('fs');
const path = require('path');
const { createRequire } = require('module');

const ROOT = path.join(__dirname, '../../../..');
const OUT = __dirname;
const requireFromQa = createRequire(path.join(ROOT, 'scripts/qa/package.json'));
const puppeteer = requireFromQa('puppeteer-core');

const BASE = 'http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub';
const CHROME =
  process.env.EA_CHROME ||
  '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

const siteTree = JSON.parse(fs.readFileSync(path.join(ROOT, 'hub/data/site-tree.json'), 'utf8'));
const mediaInv = JSON.parse(fs.readFileSync(path.join(ROOT, 'hub/data/media-inventory.json'), 'utf8'));
const materials = JSON.parse(fs.readFileSync(path.join(ROOT, 'hub/data/materials-needed.json'), 'utf8'));
const pageReview = JSON.parse(fs.readFileSync(path.join(ROOT, 'hub/data/page-review.json'), 'utf8'));
const nodeCount = siteTree.nodes.length;

const INTERFACES = [
  {
    id: 'content-intake',
    file: 'content-intake.html',
    checks: async (page) => {
      const n = await page.evaluate(() => {
        const sel = document.querySelector('#page-select, select[name="page"], select');
        return sel ? sel.options.length : 0;
      });
      return { pageOptions: n, pass: n >= nodeCount - 2 };
    },
  },
  {
    id: 'media-intake',
    file: 'media-intake.html',
    checks: async (page) => {
      const n = await page.evaluate(() => document.querySelectorAll('[data-med-id], .med-card, .media-item, .med-item').length);
      const text = await page.evaluate(() => document.body.innerText);
      const medCount = (text.match(/MED-/g) || []).length;
      const expected = mediaInv.totals?.total_media || 38;
      return { cardsFound: n, medIdsInText: medCount, expectedItems: expected, pass: medCount >= expected || text.includes('38') };
    },
  },
  {
    id: 'materials-intake',
    file: 'materials-intake.html',
    checks: async (page) => {
      const text = await page.evaluate(() => document.body.innerText);
      const groups = (materials.groups || []).length;
      return { groupsExpected: groups, hasGroupA: text.includes('A1') || text.includes('קבוצה'), pass: groups > 0 && text.length > 500 };
    },
  },
  {
    id: 'image-picker',
    file: 'image-picker.html',
    checks: async (page) => {
      const data = await page.evaluate(() => ({
        total: typeof TOTAL !== 'undefined' ? TOTAL : null,
        slots: document.querySelectorAll('.slot-card, [data-slot-id]').length,
        bodyLen: document.body.innerText.length,
      }));
      return { ...data, expectedSlots: 71, pass: (data.total === 71 || data.slots >= 50) && data.bodyLen > 200 };
    },
  },
  {
    id: 'page-review',
    file: 'page-review.html',
    checks: async (page) => {
      const n = await page.evaluate(() => document.querySelectorAll('details.pr-sec').length);
      const qs = await page.evaluate(() => document.body.innerText.includes('שאלות') || document.body.innerText.includes('פערים'));
      return { sections: n, questionsInData: (pageReview.pages || pageReview.nodes || []).length || Object.keys(pageReview).length, hasQuestionsUI: qs, pass: n >= 35 };
    },
  },
  {
    id: 'meeting-checklist',
    file: 'meeting-checklist.html',
    checks: async (page) => {
      const text = await page.evaluate(() => document.body.innerText);
      return { pass: text.includes('החלטות') || text.includes('פגישה') || text.length > 300 };
    },
  },
  {
    id: 'tasks',
    file: 'tasks.html',
    checks: async (page) => {
      const n = await page.evaluate(() => document.querySelectorAll('.task-row').length);
      const hasExport = await page.evaluate(() => !!document.querySelector('button, [type="button"]'));
      return { taskBlocks: n, hasExport, pass: n >= 1 && hasExport };
    },
  },
  {
    id: 'site-tree',
    file: 'site-tree.html',
    checks: async (page) => {
      const n = await page.evaluate(() => document.querySelectorAll('.site-tree-node').length);
      return { nodesRendered: n, expected: nodeCount, pass: n >= nodeCount - 5 };
    },
  },
];

async function main() {
  fs.mkdirSync(OUT, { recursive: true });
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: true,
    args: ['--no-sandbox'],
  });
  const results = [];
  const pg = await browser.newPage();
  await pg.setViewport({ width: 1440, height: 900 });

  for (const iface of INTERFACES) {
    const url = `${BASE}/${iface.file}`;
    let status = 'FAIL';
    let detail = {};
    let error = null;
    try {
      const res = await pg.goto(url, { waitUntil: 'networkidle2', timeout: 45000 });
      const httpStatus = res?.status() || 0;
      const title = await pg.title();
      detail = await iface.checks(pg);
      status = httpStatus === 200 && detail.pass ? 'PASS' : 'FAIL';
      detail.httpStatus = httpStatus;
      detail.title = title;
      if (status === 'FAIL') {
        await pg.screenshot({ path: path.join(OUT, `${iface.id}-fail.png`), fullPage: true });
      }
    } catch (e) {
      error = String(e.message || e);
      await pg.screenshot({ path: path.join(OUT, `${iface.id}-error.png`), fullPage: true }).catch(() => {});
    }
    results.push({ interface: iface.id, url, verdict: status, error, ...detail });
    process.stderr.write(`${iface.id}: ${status}\n`);
  }

  await browser.close();
  const summary = {
    generatedAt: new Date().toISOString(),
    base: BASE,
    hubMetadataMatch: '2026-07-02T12:18:20Z',
    pass: results.filter((r) => r.verdict === 'PASS').length,
    fail: results.filter((r) => r.verdict === 'FAIL').length,
    verdict: results.every((r) => r.verdict === 'PASS') ? 'PASS' : 'FAIL',
    results,
  };
  fs.writeFileSync(path.join(OUT, 'hub-admin-summary.json'), JSON.stringify(summary, null, 2));
  console.log(JSON.stringify(summary, null, 2));
}

main().catch((e) => {
  console.error(e);
  process.exit(2);
});
