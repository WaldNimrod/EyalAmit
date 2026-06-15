#!/usr/bin/env node
/**
 * CONTENT-ACCURACY gate (WP-W2-15 F04) — deterministic live vs Eyal source diff.
 * team_90 baseline 2026-06-04. No site mutations.
 *
 * Usage:
 *   node scripts/qa/content-diff.mjs [--base URL] [--out DIR] [--content-root PATH]
 */
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const REPO_ROOT = path.resolve(__dirname, '../..');

const DEFAULT_BASE = 'http://eyalamit-co-il-2026.s887.upress.link';
export const DEFAULT_CONTENT_ROOT = path.join(
  REPO_ROOT,
  'docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26'
);

const MIN_HEBREW_CHARS = 40;
const SECTION_WEIGHT = 0.4;
const SENTENCE_WEIGHT = 0.6;

/** @type {Array<{path:string, source:string|null, label?:string, na?:boolean, sourceType?:'md'|'docx'}>} */
export const PAGE_MAP = [
  { path: '/', source: 'דף הבית/homepage1-3 v2.md', label: '/' },
  { path: '/method/', source: 'השיטה/method.md' },
  { path: '/treatment/', source: "טיפול בדיג'רידו/treatment.md" },
  { path: '/sound-healing/', source: 'סאונדהילינג/sound_healing_final.md' },
  { path: '/lessons/', source: 'שיעורי נגינה/lesons.md' },
  { path: '/faq/', source: 'דף FAQ/FAQ FINAL.md' },
  { path: '/muzza/', source: 'מוזה הוצאה לאור - ספרים/MUZZA.md', label: '/muzza' },
  { path: '/eyal-amit/', source: 'אודות - אייל עמית/אודות - אייל עמית.md', label: '/eyal-amit' },
  { path: '/books/vekatavta/', source: 'וכתבת/vekatavta.md' },
  { path: '/books/kushi-blantis/', source: 'כושי בלאנטיס/kushi_full.md' },
  { path: '/books/tsva-bekahol/', source: 'צבע בכחול וזרוק לים/eyal_tsva_FINAL.md' },
  { path: '/didgeridoos/', source: 'כלים למכירה/buy didgeridoo.md' },
  { path: '/bags/', source: "תיקים לדיג'רידו/bags for didg.md" },
  { path: '/stands-storage/', source: "סטנדים לדיג'רידו לאחסון/stend for hanging.md" },
  { path: '/stand-floor/', source: 'סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md' },
  { path: '/repair/', source: "תיקון כלי דיג'רידו/build didg.md" },
  {
    path: '/eyal-amit/mokesh-dahiman/',
    source: 'מוקש דהימן/ומה היום.docx',
    label: '/mokesh-dahiman',
    sourceType: 'docx',
  },
  { path: '/galleries/', source: null, na: true },
  { path: '/media/', source: null, na: true },
];

const SKIP_HEADERS = new Set([
  'dev notes',
  'cta',
  'הערות',
  'layout',
  'ux',
  'behavior',
  'קישורים',
]);

function parseArgs(argv) {
  const opts = {
    base: DEFAULT_BASE,
    contentRoot: DEFAULT_CONTENT_ROOT,
    out: path.join(
      REPO_ROOT,
      '_COMMUNICATION/team_90/evidence/content-accuracy-2026-06-04'
    ),
  };
  for (let i = 2; i < argv.length; i++) {
    if (argv[i] === '--base') opts.base = argv[++i];
    else if (argv[i] === '--content-root') opts.contentRoot = argv[++i];
    else if (argv[i] === '--out') opts.out = argv[++i];
  }
  return opts;
}

function hebrewCharCount(s) {
  return (s.match(/[\u0590-\u05FF]/g) || []).length;
}

export function normalize(text) {
  let t = text;
  t = t.replace(/<script[\s\S]*?<\/script>/gi, ' ');
  t = t.replace(/<style[\s\S]*?<\/style>/gi, ' ');
  t = t.replace(/<[^>]+>/g, ' ');
  // Decode HTML entities BEFORE the markdown-# strip. WordPress esc_html() emits
  // an apostrophe as &#039; and a quote as &#034;/&quot;; the later `#{1,6}` rule
  // would eat the `#` out of &#039; (-> &039;) so the char never matched and any
  // sentence containing ' or " failed the live gate. (team_100 fix 2026-06-05.)
  t = t.replace(/&#x([0-9a-fA-F]+);/g, (_, h) => String.fromCodePoint(parseInt(h, 16)));
  t = t.replace(/&#(\d+);/g, (_, d) => String.fromCodePoint(parseInt(d, 10)));
  t = t.replace(/&quot;/gi, '"').replace(/&apos;/gi, "'").replace(/&amp;/gi, '&');
  t = t.replace(/\[([^\]]+)\]\([^)]+\)/g, '$1');
  t = t.replace(/!\[([^\]]*)\]\([^)]+\)/g, '$1');
  t = t.replace(/\[([^\]]+)\]/g, '$1');
  t = t.replace(/#{1,6}\s*/g, '');
  t = t.replace(/\*\*([^*]+)\*\*/g, '$1');
  t = t.replace(/\*([^*]+)\*/g, '$1');
  t = t.replace(/~~([^~]+)~~/g, '$1');
  t = t.replace(/`([^`]+)`/g, '$1');
  t = t.replace(/&nbsp;/g, ' ');
  t = t.replace(/&[a-z]+;/gi, ' ');
  t = t.replace(/[\u2018\u2019\u05F3\uFF07\u2032]/g, "'");
  t = t.replace(/דיג׳רידו/g, "דיג'רידו");
  t = t.replace(/\[תמונ[^\]]*\]/g, ' ');
  t = t.replace(/\[וידאו[^\]]*\]/g, ' ');
  t = t.replace(/[\u201C\u201D\u05F4\u00AB\u00BB]/g, '"');
  // Unify hyphen/dash variants to an ASCII hyphen. WordPress wptexturize() rewrites
  // a source " - " to an en-dash " \u2013 " (and "--" to "\u2014") on output, so a verbatim
  // source hyphen otherwise fails to substring-match the rendered text. This is a
  // display transform, not a content difference. (team_100 fix 2026-06-05.)
  t = t.replace(/[\u2010-\u2015\u2212\uFE58\uFE63\uFF0D]/g, '-');
  // wptexturize() also rewrites "..." to a single ellipsis glyph "\u2026"; unify both.
  t = t.replace(/\u2026/g, '...');
  // A Hebrew maqaf (\u05be) is a tight word connector. When the word after it is a link
  // (e.g. source "\u05d1\u05be\u05d1\u05dc\u05d5\u05d2" rendered as \u05d1\u05be<a>\u05d1\u05dc\u05d5\u05d2</a>), stripping the <a> tag inserts a
  // space, yielding "\u05d1\u05be \u05d1\u05dc\u05d5\u05d2". Drop a space directly after a maqaf so the verbatim
  // connected form matches. (team_100 fix 2026-06-05.)
  t = t.replace(/\u05be\s+/g, '\u05be');
  t = t.replace(/[\u200E\u200F\u202A-\u202E]/g, '');
  t = t.replace(/\s+/g, ' ');
  // Drop a space before sentence punctuation \u2014 never content; it is a tag-strip
  // artifact of inline markup ending right before the mark, e.g. <a>\u2026\u05D1\u05D3\u05D9\u05D2'\u05E8\u05D9\u05D3\u05D5</a>.
  // becomes "\u05D1\u05D3\u05D9\u05D2'\u05E8\u05D9\u05D3\u05D5 ." (team_100 fix 2026-06-05).
  t = t.replace(/ +([.,;:!?])/g, '$1');
  return t.trim();
}

function normalizeSectionTitle(title) {
  return normalize(title)
    .replace(/^section\s*\d+\s*[-–—]\s*/i, '')
    .replace(/^סקשן\s*\d+\s*[-–—]\s*/i, '')
    // "FAQ Category:" is a dev annotation prefixing the real category title in
    // the FAQ source; strip it so the rendered category heading title-matches.
    .replace(/^faq\s+category\s*:\s*/i, '')
    // "(חלק 2)" / "(part 2)" mark a category split across two source blocks for
    // length; the published heading is the base name (the blocks render as one
    // category). Strip the part annotation so the section title-matches.
    .replace(/\s*\(\s*(?:חלק|part)\s+[^)]*\)\s*$/i, '')
    .trim();
}

/**
 * True when a SECTION's title marks it as pure authoring scaffolding (a global
 * DEV-NOTES block or a QA checklist) rather than published content. Such sections
 * are excluded from coverage entirely — they carry no reader-facing copy and the
 * source author never intended them to render. (team_100 fix 2026-06-05.)
 */
function isDevSectionTitle(title) {
  const h = normalizeSectionTitle(title).toLowerCase();
  // Also exclude sections the author explicitly marked incomplete — "(להשלמה)"
  // ("to be completed"): their body is a note to gather material later (e.g.
  // testimonials still to collect), not published content.
  return (
    /^dev\s+notes\b/.test(h) ||
    /^qa\b/.test(h) ||
    /checklist/.test(h) ||
    /להשלמה/.test(title)
  );
}

function splitContentSentences(raw) {
  // PRIMARY: per source line, split on sentence punctuation, keep parts that reach
  // the Hebrew threshold. This matches data-provider renders that emit each sentence
  // as its own <p>/array entry, and normalizing each line first avoids fusing a
  // punctuation-less line (an H1, a link label) with the next. (team_100 2026-06-05.)
  const out = [];
  for (const line of String(raw).split(/\n+/)) {
    const norm = normalize(line);
    if (!norm) continue;
    const parts = norm.split(/(?<=[.!?׃])\s+/).map((p) => p.trim()).filter(Boolean);
    for (const p of parts.length ? parts : [norm]) {
      if (hebrewCharCount(p) >= MIN_HEBREW_CHARS) out.push(p);
    }
  }
  // FALLBACK: a section whose lines are all short poetic hard-breaks (e.g. the
  // treatment intro) yields nothing above. Instead of fusing the whole blob into one
  // synthetic sentence, keep each blank-line-separated PARAGRAPH as a unit — that is
  // exactly the contiguous run such content renders into as one <p>. The '' blank
  // sentinels the parser preserves make \n{2,} paragraph boundaries available here.
  if (out.length === 0) {
    for (const para of String(raw).split(/\n{2,}/)) {
      const norm = normalize(para);
      if (hebrewCharCount(norm) >= MIN_HEBREW_CHARS) out.push(norm);
    }
  }
  return [...new Set(out)];
}

function isSkippableHeader(line) {
  const m = line.match(/^##\s+(.+?):?\s*$/);
  if (!m) return false;
  const h = m[1].trim().toLowerCase();
  return SKIP_HEADERS.has(h) || h.startsWith('dev notes') || h === 'cta';
}

const SECTION_HEAD_RE =
  /^(#{1,3}\s*)?SECTION\s*(\d+)\s*[-–—]\s*(.+)$/im;

function isSectionHeaderLine(line) {
  return SECTION_HEAD_RE.test(line.trim());
}

function parseSectionHeader(line) {
  const m = line.trim().match(SECTION_HEAD_RE);
  if (!m) return null;
  return { num: m[2], title: m[3].trim() };
}

function isDevOrCtaHeader(line) {
  // Strip surrounding markdown emphasis first: several sources write the dev-note
  // header in bold (**DEV NOTES:**, **DEV NOTES (גלובליים):**, **CTA:**) rather
  // than as a `### DEV NOTES` ATX heading. Both forms are authoring scaffolding,
  // not content, and must be skipped identically. (team_100 fix 2026-06-05.)
  const t = line.trim().replace(/\*\*/g, '').replace(/__/g, '').trim();
  if (/^#{1,3}\s+DEV\s+NOTES/i.test(t)) return true;
  if (/^#{1,3}\s+CTA\s*:?\s*$/i.test(t)) return true;
  if (/^DEV\s+NOTES\b/i.test(t)) return true;
  if (/^CTA\s*:?\s*$/i.test(t)) return true;
  return isSkippableHeader(line);
}

export function parseMarkdownSource(md) {
  const sections = [];
  const lines = md.split('\n');
  let current = null;
  let inDevOrCta = false;
  const contentLines = [];

  function flush() {
    if (!current) return;
    // Drop whole dev-scaffolding sections (global DEV NOTES / QA Checklist).
    if (isDevSectionTitle(current.title)) {
      contentLines.length = 0;
      return;
    }
    const blob = contentLines.join('\n');
    sections.push({
      num: current.num,
      title: current.title,
      titleNorm: normalizeSectionTitle(current.title),
      sentences: splitContentSentences(blob),
    });
    contentLines.length = 0;
  }

  for (const line of lines) {
    const sec = parseSectionHeader(line);
    if (sec) {
      flush();
      current = sec;
      inDevOrCta = false;
      continue;
    }
    if (!current) continue;

    if (isDevOrCtaHeader(line)) {
      inDevOrCta = true;
      continue;
    }
    if (/^#{1,3}\s+/.test(line.trim())) {
      const hdr = line.trim();
      if (isDevOrCtaHeader(hdr)) {
        inDevOrCta = true;
        continue;
      }
      inDevOrCta = false;
      const val = hdr.replace(/^#{1,3}\s+([^:]+):\s*/, '$1').trim();
      const afterColon = hdr.includes(':')
        ? hdr.split(':').slice(1).join(':').trim()
        : '';
      const body = afterColon || (val !== hdr.replace(/^#{1,3}\s+/, '') ? '' : '');
      if (body && hebrewCharCount(body) >= 8) contentLines.push(body);
      else if (
        /^(H1|H2|H3|תוכן|שאלה|תשובה|תת כותרת|Trust line)/i.test(
          hdr.replace(/^#{1,3}\s+/, '').split(':')[0]
        )
      ) {
        const inline = hdr.split(':').slice(1).join(':').trim();
        if (inline) contentLines.push(inline);
      }
      continue;
    }
    if (inDevOrCta) continue;
    if (/^#{1,3}\s/.test(line)) continue;
    const t = line.trim();
    // Preserve paragraph breaks (blank line / ---) as a sentinel so sentence
    // splitting can use them as boundaries. Consecutive non-blank source lines
    // (hard-break poetic lines, list items) stay in one paragraph — which mirrors
    // how they render into a single <p>/<ul> block the gate flattens to one run.
    if (!t || t === '---') {
      if (contentLines.length && contentLines[contentLines.length - 1] !== '') {
        contentLines.push('');
      }
      continue;
    }
    // Blockquote lines are authoring scaffolding in this corpus — DEV-NOTE image/
    // asset instructions and their continuation specs (> DEV NOTE:, > https://…,
    // > כולל:, > - תמונת כריכה …). Real published prose/quotes never use `>` here
    // (testimonials are ### name + text), so skip the whole blockquote. (team_100 fix.)
    if (/^>/.test(t)) continue;
    if (/^[-*]\s/.test(t)) {
      contentLines.push(t.replace(/^[-*]\s+/, ''));
    } else if (!/^layout:|^UX:|^behavior:|^קישורים:|^הערות/.test(t)) {
      contentLines.push(t);
    }
  }
  flush();
  return sections;
}

export async function readSource(relPath, sourceType, contentRoot) {
  const full = path.join(contentRoot, relPath);
  if (!fs.existsSync(full)) {
    return { error: `SOURCE_MISSING: ${full}`, text: null };
  }
  if (sourceType === 'docx' || relPath.endsWith('.docx')) {
    try {
      const { execFileSync } = await import('node:child_process');
      const xml = execFileSync('unzip', ['-p', full, 'word/document.xml'], {
        encoding: 'utf8',
        maxBuffer: 10 * 1024 * 1024,
      });
      // WP-W2-16-E fix: extract per <w:p> paragraph and join the <w:t> runs WITHIN a
      // paragraph with NO separator — Word can split one word across runs (e.g.
      // "להיום" → <w:t>להי</w:t><w:t>ום</w:t>). Paragraphs join with a newline so the
      // sentence splitter (which splits on \n+) keeps them apart. The prior code
      // joined ALL runs with ' ', producing spurious mid-word spaces ("ש ל", "להי ום")
      // and fusing repeated headings ("ומה היום ומה היום ...") — both broke matching
      // of byte-verbatim renders. Only the docx source (mokesh) is affected.
      const runText = (frag) =>
        [...frag.matchAll(/<w:t[^>]*>([^<]*)<\/w:t>/g)].map((m) => m[1]).join('');
      const paras = [...xml.matchAll(/<w:p(?:\s[^>]*)?>([\s\S]*?)<\/w:p>/g)].map((p) => runText(p[1]));
      return { error: null, text: paras.length ? paras.join('\n') : runText(xml), format: 'docx' };
    } catch (e) {
      return { error: `DOCX_PARSE_FAIL: ${e.message}`, text: null };
    }
  }
  return { error: null, text: fs.readFileSync(full, 'utf8'), format: 'md' };
}

export function parseDocxSections(text) {
  // Docx has no SECTION markers — treat whole doc as one pseudo-section + paragraph sentences
  const sentences = splitContentSentences(text);
  return [
    {
      num: '1',
      title: 'ומה היום (מסמך מלא)',
      titleNorm: normalizeSectionTitle('ומה היום'),
      sentences,
    },
  ];
}

export function htmlToText(html) {
  return normalize(html);
}

async function fetchLiveText(base, pagePath) {
  const url = new URL(pagePath, base).href;
  const res = await fetch(url, {
    redirect: 'follow',
    headers: { 'User-Agent': 'ea-content-diff/1.0 (team_90)' },
  });
  const html = await res.text();
  const mainMatch =
    html.match(/<main[^>]*>([\s\S]*?)<\/main>/i) ||
    html.match(/<article[^>]*>([\s\S]*?)<\/article>/i);
  const body = mainMatch ? mainMatch[1] : html;
  return {
    url: res.url,
    status: res.status,
    text: htmlToText(body),
    htmlMain: body,
    rawLen: html.length,
  };
}

function sectionFound(titleNorm, liveNorm) {
  if (!titleNorm || titleNorm.length < 4) return false;
  return liveNorm.includes(titleNorm);
}

function sentenceFound(sentence, liveNorm) {
  const s = normalize(sentence);
  if (!s) return false;
  return liveNorm.includes(s);
}

function extractLiveHeadings(htmlSnippet) {
  const headings = [];
  const re = /<h[23][^>]*>([\s\S]*?)<\/h[23]>/gi;
  let m;
  while ((m = re.exec(htmlSnippet))) {
    const t = normalize(m[1]);
    if (t && hebrewCharCount(t) >= 3) headings.push(t);
  }
  return headings;
}

function extractLiveInventedSentences(liveNorm, sourceSentences) {
  const sourceSet = new Set(sourceSentences.map((s) => normalize(s)));
  const candidates = splitContentSentences(liveNorm);
  return candidates.filter((c) => {
    const n = normalize(c);
    if (sourceSet.has(n)) return false;
    for (const s of sourceSet) {
      if (s.length > 20 && (n.includes(s) || s.includes(n))) return false;
    }
    return true;
  });
}

function verdictFromAccuracy(acc) {
  if (acc >= 90) return 'ACCURATE';
  if (acc >= 40) return 'PARTIAL';
  return 'INVENTED';
}

function gatePass(sectionCov, sentenceCov, inventedSectionCount) {
  return sectionCov >= 95 && sentenceCov >= 90 && inventedSectionCount === 0;
}

export function analyzePage({ sections, live, htmlMain }) {
  const liveNorm = live.text;
  const allSourceSentences = sections.flatMap((s) => s.sentences);
  const missingSections = [];
  let sectionsFound = 0;
  for (const sec of sections) {
    // Calibrated section coverage (team_100 2026-06-05, Principal-approved): judge
    // a section by whether its CONTENT is present, not only by whether its title —
    // which may be pure structural scaffolding ("Hero"/"Intro"/"Header"/"CTA"/
    // "וידאו") never meant to render as visible text — literally appears. A section
    // is covered if its title matches, OR it carries no measurable content sentences
    // (pure structural label, nothing to verify), OR all its content sentences are
    // present in the render. This removes the brittle English-label penalty without
    // resorting to invisible sr-only label text.
    let ok = sectionFound(sec.titleNorm, liveNorm);
    if (!ok) {
      ok = sec.sentences.length === 0 || sec.sentences.every((s) => sentenceFound(s, liveNorm));
    }
    if (ok) sectionsFound++;
    else missingSections.push({ num: sec.num, title: sec.title });
  }
  const sectionTotal = sections.length || 1;
  const sectionCov = (sectionsFound / sectionTotal) * 100;

  let sentencesFound = 0;
  const missingSentences = [];
  for (const sec of sections) {
    for (const sent of sec.sentences) {
      if (sentenceFound(sent, liveNorm)) sentencesFound++;
      else missingSentences.push({ section: sec.title, sentence: sent.slice(0, 120) });
    }
  }
  const sentenceTotal = allSourceSentences.length || 1;
  const sentenceCov = (sentencesFound / sentenceTotal) * 100;

  const accuracy =
    SECTION_WEIGHT * sectionCov + SENTENCE_WEIGHT * sentenceCov;

  const liveHeadings = extractLiveHeadings(htmlMain || '');
  const inventedSections = liveHeadings.filter(
    (h) =>
      !sections.some(
        (s) =>
          sectionFound(normalizeSectionTitle(h), liveNorm) ||
          h.includes(s.titleNorm) ||
          s.titleNorm.includes(h)
      )
  );

  const inventedBlocks = extractLiveInventedSentences(liveNorm, allSourceSentences).slice(
    0,
    30
  );

  return {
    sectionCoveragePct: round2(sectionCov),
    sentenceCoveragePct: round2(sentenceCov),
    pageAccuracyPct: round2(accuracy),
    sectionsTotal: sectionTotal,
    sectionsFound,
    sentencesTotal: sentenceTotal,
    sentencesFound,
    missingSections,
    missingSentences: missingSentences.slice(0, 50),
    inventedSections: inventedSections.slice(0, 20),
    inventedBlocks,
    gatePass: gatePass(sectionCov, sentenceCov, inventedSections.length),
    verdict: verdictFromAccuracy(accuracy),
  };
}

function round2(n) {
  return Math.round(n * 100) / 100;
}

function charWeight(sections) {
  return sections.reduce(
    (sum, s) => sum + s.sentences.join(' ').length + (s.title?.length || 0),
    0
  );
}

async function main() {
  const opts = parseArgs(process.argv);
  fs.mkdirSync(opts.out, { recursive: true });

  const results = [];
  const meta = {
    generatedAt: new Date().toISOString(),
    base: opts.base,
    contentRoot: opts.contentRoot,
    formula: {
      pageAccuracyPct: `${SECTION_WEIGHT * 100}% * sectionCoverage + ${SENTENCE_WEIGHT * 100}% * sentenceCoverage`,
      sectionCoveragePct:
        'sectionsFound / sectionsTotal * 100 (calibrated: section covered if title matches OR has no content sentences OR all its sentences present)',
      sentenceCoveragePct: 'sentencesFound / sentencesTotal * 100 (verbatim substring after normalize)',
      verdict: { ACCURATE: '>=90', PARTIAL: '40-89', INVENTED: '<40', NA: 'no source' },
      gatePass: 'section>=95 AND sentence>=90 AND inventedSections=0',
      minHebrewChars: MIN_HEBREW_CHARS,
      weights: { section: SECTION_WEIGHT, sentence: SENTENCE_WEIGHT },
    },
    script: 'scripts/qa/content-diff.mjs',
  };

  for (const page of PAGE_MAP) {
    const pageKey = page.label || page.path;
    if (page.na) {
      results.push({
        page: pageKey,
        path: page.path,
        source: null,
        verdict: 'N/A',
        note: 'No Eyal source — team_35 mockup samples',
      });
      continue;
    }

    const src = await readSource(page.source, page.sourceType, opts.contentRoot);
    if (src.error || !src.text) {
      const live = await fetchLiveText(opts.base, page.path);
      results.push({
        page: pageKey,
        path: page.path,
        source: page.source,
        sourceError: src.error,
        liveUrl: live.url,
        liveStatus: live.status,
        verdict: 'N/A',
        note: 'Source file missing or unreadable — metrics not computed',
      });
      continue;
    }

    const sections =
      src.format === 'docx'
        ? parseDocxSections(src.text)
        : parseMarkdownSource(src.text);

    const live = await fetchLiveText(opts.base, page.path);
    const analysis = analyzePage({ sections, live, htmlMain: live.htmlMain });
    const weight = charWeight(sections);

    results.push({
      page: pageKey,
      path: page.path,
      source: page.source,
      liveUrl: live.url,
      liveStatus: live.status,
      ...analysis,
      sourceCharWeight: weight,
    });

    fs.writeFileSync(
      path.join(opts.out, `${pageKey.replace(/\//g, '_') || 'home'}.json`),
      JSON.stringify(results[results.length - 1], null, 2),
      'utf8'
    );
  }

  const measurable = results.filter((r) => r.pageAccuracyPct != null);
  const simpleAvg =
    measurable.reduce((s, r) => s + r.pageAccuracyPct, 0) / (measurable.length || 1);
  const totalWeight = measurable.reduce((s, r) => s + (r.sourceCharWeight || 1), 0);
  const weightedAvg =
    measurable.reduce(
      (s, r) => s + r.pageAccuracyPct * (r.sourceCharWeight || 1),
      0
    ) / (totalWeight || 1);
  const under90 = measurable.filter((r) => r.pageAccuracyPct < 90).length;

  const summary = {
    ...meta,
    pagesTotal: PAGE_MAP.length,
    pagesMeasured: measurable.length,
    pagesNA: results.filter((r) => r.verdict === 'N/A').length,
    siteAccuracySimpleAvgPct: round2(simpleAvg),
    siteAccuracyWeightedBySourceCharsPct: round2(weightedAvg),
    pagesUnder90Pct: under90,
    gateWouldPassCount: measurable.filter((r) => r.gatePass).length,
    results,
  };

  fs.writeFileSync(
    path.join(opts.out, 'summary.json'),
    JSON.stringify(summary, null, 2),
    'utf8'
  );

  console.log(JSON.stringify(summary, null, 2));
}

const __isMain =
  process.argv[1] &&
  path.resolve(process.argv[1]) === fileURLToPath(import.meta.url);
if (__isMain) {
  main().catch((err) => {
    console.error(err);
    process.exit(1);
  });
}
