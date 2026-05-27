const fs = require('fs');
const puppeteer = require('puppeteer-core');
const axeSource = fs.readFileSync(require.resolve('axe-core/axe.min.js'), 'utf8');

const out = '_COMMUNICATION/team_190/evidence/axe-validate.json';
const url = 'https://eyalamit-co-il-2026.s887.upress.link/wave2-test/';

function parseRgb(value) {
  const match = String(value || '').match(/rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([0-9.]+))?\)/);
  if (!match) return null;
  return { r: +match[1], g: +match[2], b: +match[3], a: match[4] === undefined ? 1 : +match[4] };
}

function luminance(color) {
  const channel = (value) => {
    value = value / 255;
    return value <= 0.03928 ? value / 12.92 : Math.pow((value + 0.055) / 1.055, 2.4);
  };
  return 0.2126 * channel(color.r) + 0.7152 * channel(color.g) + 0.0722 * channel(color.b);
}

function contrastRatio(foreground, background) {
  const lighter = Math.max(luminance(foreground), luminance(background));
  const darker = Math.min(luminance(foreground), luminance(background));
  return (lighter + 0.05) / (darker + 0.05);
}

(async () => {
  const browser = await puppeteer.launch({
    executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors', '--allow-running-insecure-content'],
  });
  const page = await browser.newPage();
  await page.setViewport({ width: 390, height: 844, deviceScaleFactor: 3, isMobile: true });
  await page.goto(url, { waitUntil: 'networkidle2', timeout: 90000 });
  await page.addScriptTag({ content: axeSource });

  const axe = await page.evaluate(async () => {
    return window.axe.run(document, { runOnly: { type: 'tag', values: ['wcag2aa'] } });
  });

  const pageChecks = await page.evaluate(() => {
    const cssLoaded = (id) => {
      const element = document.querySelector(`link#${id}`);
      return !!element && /\/wp-content\/themes\/ea-eyalamit\/assets\/css\//.test(element.href || '');
    };
    const label = document.querySelector('.ea-sound-toggle__label');
    const backgroundFor = (element) => {
      let node = element;
      while (node && node.nodeType === 1) {
        const background = getComputedStyle(node).backgroundColor;
        if (background && background !== 'transparent' && !/^rgba\(0, 0, 0, 0\)$/.test(background)) {
          return background;
        }
        node = node.parentElement;
      }
      return getComputedStyle(document.body).backgroundColor;
    };

    return {
      title: document.title,
      finalUrl: location.href,
      htmlLang: document.documentElement.lang,
      htmlDir: document.documentElement.dir,
      bodyDirection: getComputedStyle(document.body).direction,
      dataBlocks: Array.from(document.querySelectorAll('[data-block]')).map((element) => element.getAttribute('data-block')),
      css: {
        tokens: cssLoaded('ea-wave2-tokens-css'),
        animations: cssLoaded('ea-wave2-animations-css'),
        atoms: cssLoaded('ea-wave2-atoms-css'),
      },
      footerExists: !!document.querySelector('[data-block="footer-social"] .ea-footer'),
      whatsappExists: !!document.querySelector('.ea-whatsapp-float[href^="https://wa.me/972524822842"]'),
      hebrewProbe: document.body.innerText.includes('אייל עמית') && document.body.innerText.includes('דיג׳רידו'),
      soundLabel: label ? {
        text: label.textContent.trim(),
        color: getComputedStyle(label).color,
        backgroundColor: backgroundFor(label),
        fontSize: getComputedStyle(label).fontSize,
        fontWeight: getComputedStyle(label).fontWeight,
      } : null,
    };
  });

  if (pageChecks.soundLabel) {
    const foreground = parseRgb(pageChecks.soundLabel.color);
    const background = parseRgb(pageChecks.soundLabel.backgroundColor);
    pageChecks.soundLabel.contrastRatio = foreground && background ? Number(contrastRatio(foreground, background).toFixed(2)) : null;
    pageChecks.soundLabel.wcagAA = pageChecks.soundLabel.contrastRatio !== null && pageChecks.soundLabel.contrastRatio >= 4.5;
  }

  const result = {
    generatedAt: new Date().toISOString(),
    method: 'puppeteer-core + injected axe-core, Chrome cert bypass',
    url,
    pageChecks,
    axeSummary: {
      violations: axe.violations.length,
      critical: axe.violations.filter((violation) => violation.impact === 'critical').length,
      serious: axe.violations.filter((violation) => violation.impact === 'serious').length,
      moderate: axe.violations.filter((violation) => violation.impact === 'moderate').length,
      minor: axe.violations.filter((violation) => violation.impact === 'minor').length,
    },
    axe,
  };

  fs.writeFileSync(out, JSON.stringify(result, null, 2));
  await browser.close();

  if (result.axeSummary.critical > 0 || result.axeSummary.serious > 0 || !pageChecks.soundLabel || !pageChecks.soundLabel.wcagAA) {
    process.exit(2);
  }
})().catch((error) => {
  fs.writeFileSync(out, JSON.stringify({ error: String(error && error.stack || error) }, null, 2));
  process.exit(1);
});
