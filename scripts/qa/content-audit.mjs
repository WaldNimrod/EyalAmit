#!/usr/bin/env node
/**
 * CONTENT AUDIT (team_110, 2026-06-21) — extends content-diff.mjs to compare
 * EVERY one of Eyal's latest from-eyal docs against the live pages, mapping per
 * (page × source): missing sections, missing/changed sentences, invented blocks.
 *
 * Reuses content-diff's parsing + analysis (same normalization, same metrics).
 * - Primary pack (תוכן לאתר 25.5.26) → the 17 PAGE_MAP routes.
 * - Supplementary CONTENT docs (earlier April page-prose) → their pages, to catch
 *   content Eyal wrote that the (May-based) live site dropped.
 * - Testimonials doc → integration-gap check.
 * Spec docs (dev-brief / seo-content / site_updates) are titles/meta/instructions,
 * NOT page prose — reviewed qualitatively in the report, not text-scored here.
 *
 * Usage: node scripts/qa/content-audit.mjs [--base URL] [--out DIR]
 */
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import {
  PAGE_MAP,
  DEFAULT_CONTENT_ROOT,
  readSource,
  parseMarkdownSource,
  parseDocxSections,
  analyzePage,
  htmlToText,
} from './content-diff.mjs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const REPO_ROOT = path.resolve(__dirname, '../..');
const FROM_EYAL = path.resolve(DEFAULT_CONTENT_ROOT, '..');
const DEFAULT_BASE = 'http://eyalamit-co-il-2026.s887.upress.link';

// Supplementary CONTENT sources (page-prose) keyed to live pages, root = from-eyal.
const SUPPLEMENTARY = [
  {
    page: '/sound-healing/',
    label: '/sound-healing (April canonical)',
    source: 'CONTENT 12.4.26/sound_healing_canonical.docx',
    sourceType: 'docx',
    kind: 'content',
  },
  {
    page: '/method/',
    label: '/method (April ST-method)',
    source: 'CONTENT EYAL 10.4.26/final_st-method_2026-04-10_SINGLE.md',
    kind: 'content',
  },
  {
    page: '/treatment/',
    label: '/treatment (April ST-method)',
    source: 'CONTENT EYAL 10.4.26/final_st-method_2026-04-10_SINGLE.md',
    kind: 'content',
  },
  {
    page: '/media/',
    label: '/media (FB testimonials)',
    source: 'תוכן לאתר 25.5.26/ממליצים מהפייסבוק.docx',
    sourceType: 'docx',
    kind: 'content',
  },
];

function parseArgs(argv) {
  const o = { base: DEFAULT_BASE, out: path.join(REPO_ROOT, '_COMMUNICATION/team_110/evidence/content-audit-2026-06-21') };
  for (let i = 2; i < argv.length; i++) {
    if (argv[i] === '--base') o.base = argv[++i];
    else if (argv[i] === '--out') o.out = argv[++i];
  }
  return o;
}

async function fetchLive(base, p) {
  const url = new URL(p, base).href;
  const res = await fetch(url, { redirect: 'follow', headers: { 'User-Agent': 'ea-content-audit/1.0 (team_110)' } });
  const html = await res.text();
  const m = html.match(/<main[^>]*>([\s\S]*?)<\/main>/i) || html.match(/<article[^>]*>([\s\S]*?)<\/article>/i);
  const body = m ? m[1] : html;
  return { url: res.url, status: res.status, text: htmlToText(body), htmlMain: body };
}

async function analyzeOne(base, page, sourceRel, contentRoot, sourceType, liveCache, flat = false) {
  const src = await readSource(sourceRel, sourceType, contentRoot);
  if (src.error || !src.text) return { error: src.error || 'no text' };
  if (!liveCache[page]) liveCache[page] = await fetchLive(base, page);
  const live = liveCache[page];
  // `flat`: ignore document structure and extract sentences from the whole text
  // (parseDocxSections runs the same splitContentSentences on any text). Needed for
  // supplementary docs whose structure differs from the 25.5.26 "SECTION N" convention,
  // where parseMarkdownSource would extract nothing. sentenceCov stays meaningful.
  const sections =
    flat || src.format === 'docx' ? parseDocxSections(src.text) : parseMarkdownSource(src.text);
  const a = analyzePage({ sections, live, htmlMain: live.htmlMain });
  return {
    liveStatus: live.status,
    sectionCov: a.sectionCoveragePct,
    sentenceCov: a.sentenceCoveragePct,
    accuracy: a.pageAccuracyPct,
    sectionsTotal: a.sectionsTotal,
    sentencesTotal: a.sentencesTotal,
    missingSections: a.missingSections,
    missingSentences: a.missingSentences,
    inventedSections: a.inventedSections,
    inventedBlocksCount: a.inventedBlocks.length,
    verdict: a.verdict,
  };
}

async function main() {
  const opts = parseArgs(process.argv);
  fs.mkdirSync(opts.out, { recursive: true });
  const liveCache = {};
  const primary = [];
  const supplementary = [];

  for (const pg of PAGE_MAP) {
    if (pg.na) {
      primary.push({ page: pg.label || pg.path, source: null, verdict: 'N/A', note: 'no Eyal source' });
      continue;
    }
    const r = await analyzeOne(opts.base, pg.path, pg.source, DEFAULT_CONTENT_ROOT, pg.sourceType, liveCache);
    primary.push({ page: pg.label || pg.path, source: pg.source, ...r });
  }

  for (const s of SUPPLEMENTARY) {
    // Flat sentence extraction (structure-agnostic) so sentenceCov is valid for all
    // supplementary doc shapes; we report sentenceCov + missing/found, not sectionCov.
    const r = await analyzeOne(opts.base, s.page, s.source, FROM_EYAL, s.sourceType, liveCache, true);
    supplementary.push({ label: s.label, page: s.page, source: s.source, kind: s.kind, ...r });
  }

  const out = { generatedAt: new Date().toISOString(), base: opts.base, primary, supplementary };
  fs.writeFileSync(path.join(opts.out, 'audit.json'), JSON.stringify(out, null, 2), 'utf8');
  console.log(JSON.stringify(out, null, 2));
}

main().catch((e) => { console.error(e); process.exit(1); });
