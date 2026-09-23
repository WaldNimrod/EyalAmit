# S007 ALIGN CANON AUDIT — LIVE STAGING (2026-09-21)
**Scope:** LIVE layout measurement via headless Chrome CDP (not curl). No theme edits, no FTP.
**Staging base:** `http://eyalamit-co-il-2026.s887.upress.link` (HTTP; TLS invalid by design)
**Viewports:** 1440×900 (desktop), 390×844 (mobile)
**Chrome UA used:** `Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36`

---
## Baseline: /snoring-sleep-apnea/ (desktop 1440×900)
- html.clientWidth/scrollWidth: **1440 / 1440**
- main.classList: **chapters-main**
- first header kind: **header.phero**
- header inner width: **1200.0px**
- H1 width: **786.6px** · text-align: **start** · max-width: **786.622px**
- sections count: section.sec=18 · .cta-band=3 · .bleed=0 · ea-wave2-*=1

**Row #1 (first section with h2 + reading block):**
- wrap: width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
- h2: x-left **168.0**, width **1104.0px**, text-align **start**
- reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
- section padding-top/bottom: **88px / 88px** · bg: **rgba(0, 0, 0, 0)**
- h2-body start-edge delta (dir=rtl): **164.4px**

---
## Desktop 1440×900 — compact summary table
| page | family | wrap px | read px | h2-body offset px | sec pad-top px | match/deviate | notes |
|---|---:|---:|---:|---:|---:|---:|---|
| /snoring-sleep-apnea/ | F-CHAP-82CH | 1200.0 | 775.3 | 164.4 | 88.0 | MATCH | CTA full-bleed |
| / | F-CHAP-82CH | 1200.0 | 775.3 | 164.4 | 88.0 | MATCH | CTA full-bleed |
| /treatment/ | F-CHAP-82CH | 1200.0 | 775.3 | 164.4 | 88.0 | MATCH | CTA MISSING |
| /method/ | F-CHAP-OTHER | 1200.0 | 516.0 | 0.0 | 88.0 | DEVIATE | CTA full-bleed |
| /lessons/ | F-CHAP-OTHER | 1200.0 | 516.0 | 0.0 | 88.0 | DEVIATE | CTA full-bleed |
| /eyal-amit/ | F-CHAP-82CH | 1200.0 | 775.3 | 164.4 | 88.0 | MATCH | CTA MISSING |
| /contact/ | F-CHAP-OTHER | MISSING | MISSING | MISSING | MISSING | DEVIATE | CTA MISSING; ROWS(h2+reading) MISSING |
| /faq/ | F-CHAP-OTHER | MISSING | MISSING | MISSING | MISSING | DEVIATE | CTA MISSING; ROWS(h2+reading) MISSING |
| /shop/ | F-CHAP-OTHER | MISSING | MISSING | MISSING | MISSING | DEVIATE | CTA MISSING; ROWS(h2+reading) MISSING |
| /press/ | F-EDITORIAL-65CH | MISSING | MISSING | MISSING | MISSING | DEVIATE | CTA MISSING; ROWS(h2+reading) MISSING |
| /blog/ | F-BLOG-ARCHIVE | 1136.0 | 320.0 | -25.0 | 88.0 | DEVIATE | CTA MISSING |
| /%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-2/ | F-BLOG-SINGLE-960 | 896.0 | 380.0 | 0.0 | 88.0 | DEVIATE | CTA MISSING |
| /qr/qr1/ | F-QR | MISSING | MISSING | MISSING | MISSING | DEVIATE | CTA MISSING; ROWS(h2+reading) MISSING |
| /en/ | F-EN | 1200.0 | 775.3 | -164.4 | 88.0 | MATCH | CTA MISSING |
| /learning/ | F-CHAP-82CH | 1200.0 | 775.3 | 164.4 | 88.0 | MATCH | CTA full-bleed |
| /historical-articles/ | F-GP-DEFAULT | MISSING | MISSING | MISSING | MISSING | DEVIATE | CTA MISSING; ROWS(h2+reading) MISSING |

---
## Statistics (desktop)
### Pages per family
- **F-CHAP-82CH**: 5
- **F-CHAP-OTHER**: 5
- **F-BLOG-ARCHIVE**: 1
- **F-BLOG-SINGLE-960**: 1
- **F-EDITORIAL-65CH**: 1
- **F-EN**: 1
- **F-GP-DEFAULT**: 1
- **F-QR**: 1

### Family aggregates (desktop)
- Metrics use **Row #1** (first content row with h2+reading). Each aggregate includes its own n.
- **F-BLOG-ARCHIVE**
  - wrap.width: mean 1136.0 · min 1136.0 · max 1136.0 (n=1)
  - reading.width: mean 320.0 · min 320.0 · max 320.0 (n=1)
  - sec padding-top: mean 88.0 · min 88.0 · max 88.0 (n=1)
  - |h2-body offset|: mean 25.0 · min 25.0 · max 25.0 (n=1)
- **F-BLOG-SINGLE-960**
  - wrap.width: mean 896.0 · min 896.0 · max 896.0 (n=1)
  - reading.width: mean 380.0 · min 380.0 · max 380.0 (n=1)
  - sec padding-top: mean 88.0 · min 88.0 · max 88.0 (n=1)
  - |h2-body offset|: mean 0.0 · min 0.0 · max 0.0 (n=1)
- **F-CHAP-82CH**
  - wrap.width: mean 1200.0 · min 1200.0 · max 1200.0 (n=5)
  - reading.width: mean 775.3 · min 775.3 · max 775.3 (n=5)
  - sec padding-top: mean 88.0 · min 88.0 · max 88.0 (n=5)
  - |h2-body offset|: mean 164.4 · min 164.4 · max 164.4 (n=5)
- **F-CHAP-OTHER**
  - wrap.width: mean 1200.0 · min 1200.0 · max 1200.0 (n=2)
  - reading.width: mean 516.0 · min 516.0 · max 516.0 (n=2)
  - sec padding-top: mean 88.0 · min 88.0 · max 88.0 (n=2)
  - |h2-body offset|: mean 0.0 · min 0.0 · max 0.0 (n=2)
- **F-EDITORIAL-65CH**
  - wrap.width: MISSING
  - reading.width: MISSING
  - sec padding-top: MISSING
  - |h2-body offset|: MISSING
- **F-EN**
  - wrap.width: mean 1200.0 · min 1200.0 · max 1200.0 (n=1)
  - reading.width: mean 775.3 · min 775.3 · max 775.3 (n=1)
  - sec padding-top: mean 88.0 · min 88.0 · max 88.0 (n=1)
  - |h2-body offset|: mean 164.4 · min 164.4 · max 164.4 (n=1)
- **F-GP-DEFAULT**
  - wrap.width: MISSING
  - reading.width: MISSING
  - sec padding-top: MISSING
  - |h2-body offset|: MISSING
- **F-QR**
  - wrap.width: MISSING
  - reading.width: MISSING
  - sec padding-top: MISSING
  - |h2-body offset|: MISSING

### Canon match counts
- **MATCH snoring canon (wrap=1200, read≈775.3±4, centered, h2 start on wrap)**: **6 / 16**
  - pages: /snoring-sleep-apnea/, /, /treatment/, /eyal-amit/, /en/, /learning/

---
## Deviations vs canon (desktop)
- **/method/** (F-CHAP-OTHER):
  - reading.width 516.0px (baseline 775.3px ±4)
  - reading not centered within wrap (geometry test)
- **/lessons/** (F-CHAP-OTHER):
  - reading.width 516.0px (baseline 775.3px ±4)
  - reading not centered within wrap (geometry test)
- **/contact/** (F-CHAP-OTHER):
  - no content rows found matching: section with h2 AND reading block selector (.intro-body/.prose/.ea-post-content/article)
- **/faq/** (F-CHAP-OTHER):
  - no content rows found matching: section with h2 AND reading block selector (.intro-body/.prose/.ea-post-content/article)
- **/shop/** (F-CHAP-OTHER):
  - no content rows found matching: section with h2 AND reading block selector (.intro-body/.prose/.ea-post-content/article)
- **/press/** (F-EDITORIAL-65CH):
  - no content rows found matching: section with h2 AND reading block selector (.intro-body/.prose/.ea-post-content/article)
- **/blog/** (F-BLOG-ARCHIVE):
  - wrap.width 1136.0px (canon 1200.0px)
  - reading.width 320.0px (baseline 775.3px ±4)
  - reading not centered within wrap (geometry test)
  - h2 start not on wrap start-edge (gap 25.0px; tol 3px)
- **/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-2/** (F-BLOG-SINGLE-960):
  - wrap.width 896.0px (canon 1200.0px)
  - reading.width 380.0px (baseline 775.3px ±4)
  - reading not centered within wrap (geometry test)
- **/qr/qr1/** (F-QR):
  - no content rows found matching: section with h2 AND reading block selector (.intro-body/.prose/.ea-post-content/article)
- **/historical-articles/** (F-GP-DEFAULT):
  - no content rows found matching: section with h2 AND reading block selector (.intro-body/.prose/.ea-post-content/article)

---
## Per-page measurements (desktop 1440×900 + mobile 390×844)
### /snoring-sleep-apnea/ — snoring-sleep-apnea (BASELINE)
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **1200.0px**
  - H1 width: **786.6px** · text-align **start** · max-width **786.622px**
  - sections count: section.sec=18 · .cta-band=3 · .bleed=0 · ea-wave2-*=1
  - Row #1:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - Row #2:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgb(239, 234, 225)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - Row #3:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **756.0**, width **516.0px**, text-align **start**
    - reading (.intro-body): width **516.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **756.0**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - CTA band width vs wrap: **1440.0px** vs **266.7px**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **390.0px**
  - H1 width: **294.0px** · text-align **start** · max-width **574.839px**
  - sections count: section.sec=18 · .cta-band=3 · .bleed=0 · ea-wave2-*=1
  - Row #1:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #2:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgb(239, 234, 225)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #3:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - CTA band width vs wrap: **390.0px** vs **390.0px**

### / — home
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main**
  - first header kind: **header.hero**
  - header inner width: **1440.0px**
  - H1 width: **716.5px** · text-align **center** · max-width **none**
  - sections count: section.sec=9 · .cta-band=1 · .bleed=1 · ea-wave2-*=1
  - Row #1:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgb(239, 234, 225)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - Row #2:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - Row #3:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - CTA band width vs wrap: **1440.0px** vs **1200.0px**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main**
  - first header kind: **header.hero**
  - header inner width: **390.0px**
  - H1 width: **310.0px** · text-align **center** · max-width **none**
  - sections count: section.sec=9 · .cta-band=1 · .bleed=1 · ea-wave2-*=1
  - Row #1:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgb(239, 234, 225)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #2:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #3:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - CTA band width vs wrap: **390.0px** vs **390.0px**

### /treatment/ — treatment
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **1200.0px**
  - H1 width: **786.6px** · text-align **start** · max-width **786.622px**
  - sections count: section.sec=10 · .cta-band=0 · .bleed=1 · ea-wave2-*=1
  - Row #1:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - Row #2:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **756.0**, width **516.0px**, text-align **start**
    - reading (.intro-body): width **516.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **756.0**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #3:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - CTA band: **MISSING**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **390.0px**
  - H1 width: **294.0px** · text-align **start** · max-width **574.839px**
  - sections count: section.sec=10 · .cta-band=0 · .bleed=1 · ea-wave2-*=1
  - Row #1:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #2:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #3:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - CTA band: **MISSING**

### /method/ — method
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **1200.0px**
  - H1 width: **786.6px** · text-align **start** · max-width **786.622px**
  - sections count: section.sec=12 · .cta-band=1 · .bleed=0 · ea-wave2-*=1
  - Row #1:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **756.0**, width **516.0px**, text-align **start**
    - reading (.intro-body): width **516.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **756.0**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #2:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - Row #3:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - CTA band width vs wrap: **1440.0px** vs **1200.0px**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **390.0px**
  - H1 width: **294.0px** · text-align **start** · max-width **574.839px**
  - sections count: section.sec=12 · .cta-band=1 · .bleed=0 · ea-wave2-*=1
  - Row #1:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #2:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #3:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - CTA band width vs wrap: **390.0px** vs **390.0px**

### /lessons/ — lessons
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **1200.0px**
  - H1 width: **786.6px** · text-align **start** · max-width **786.622px**
  - sections count: section.sec=8 · .cta-band=1 · .bleed=0 · ea-wave2-*=1
  - Row #1:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **756.0**, width **516.0px**, text-align **start**
    - reading (.intro-body): width **516.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **756.0**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #2:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - Row #3:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **512.0**, width **760.0px**, text-align **start**
    - reading (.intro-body): width **760.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **512.0**
    - section padding-top/bottom **88px / 88px**, bg **rgb(239, 234, 225)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - CTA band width vs wrap: **1440.0px** vs **1200.0px**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **390.0px**
  - H1 width: **294.0px** · text-align **start** · max-width **574.839px**
  - sections count: section.sec=8 · .cta-band=1 · .bleed=0 · ea-wave2-*=1
  - Row #1:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #2:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #3:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgb(239, 234, 225)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - CTA band width vs wrap: **390.0px** vs **390.0px**

### /eyal-amit/ — eyal-amit
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **1200.0px**
  - H1 width: **786.6px** · text-align **start** · max-width **786.622px**
  - sections count: section.sec=15 · .cta-band=0 · .bleed=0 · ea-wave2-*=1
  - Row #1:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - Row #2:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - Row #3:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - CTA band: **MISSING**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **390.0px**
  - H1 width: **294.0px** · text-align **start** · max-width **574.839px**
  - sections count: section.sec=15 · .cta-band=0 · .bleed=0 · ea-wave2-*=1
  - Row #1:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #2:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #3:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - CTA band: **MISSING**

### /contact/ — contact
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **1200.0px**
  - H1 width: **786.6px** · text-align **start** · max-width **786.622px**
  - sections count: section.sec=3 · .cta-band=0 · .bleed=0 · ea-wave2-*=4
  - rows(h2+reading): **MISSING**
  - CTA band: **MISSING**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **390.0px**
  - H1 width: **294.0px** · text-align **start** · max-width **574.839px**
  - sections count: section.sec=3 · .cta-band=0 · .bleed=0 · ea-wave2-*=4
  - rows(h2+reading): **MISSING**
  - CTA band: **MISSING**

### /faq/ — faq
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **1200.0px**
  - H1 width: **786.6px** · text-align **start** · max-width **786.622px**
  - sections count: section.sec=0 · .cta-band=0 · .bleed=0 · ea-wave2-*=1
  - rows(h2+reading): **MISSING**
  - CTA band: **MISSING**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **390.0px**
  - H1 width: **294.0px** · text-align **start** · max-width **574.839px**
  - sections count: section.sec=0 · .cta-band=0 · .bleed=0 · ea-wave2-*=1
  - rows(h2+reading): **MISSING**
  - CTA band: **MISSING**

### /shop/ — shop
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **1200.0px**
  - H1 width: **786.6px** · text-align **start** · max-width **786.622px**
  - sections count: section.sec=1 · .cta-band=0 · .bleed=0 · ea-wave2-*=1
  - rows(h2+reading): **MISSING**
  - CTA band: **MISSING**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **390.0px**
  - H1 width: **294.0px** · text-align **start** · max-width **574.839px**
  - sections count: section.sec=1 · .cta-band=0 · .bleed=0 · ea-wave2-*=1
  - rows(h2+reading): **MISSING**
  - CTA band: **MISSING**

### /press/ — press
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **ea-wave2-editorial**
  - first header(.phero/.hero): **MISSING**
  - sections count: section.sec=0 · .cta-band=0 · .bleed=0 · ea-wave2-*=2
  - rows(h2+reading): **MISSING**
  - CTA band: **MISSING**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **ea-wave2-editorial**
  - first header(.phero/.hero): **MISSING**
  - sections count: section.sec=0 · .cta-band=0 · .bleed=0 · ea-wave2-*=2
  - rows(h2+reading): **MISSING**
  - CTA band: **MISSING**

### /blog/ — blog (archive)
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main, ea-wave2-blog-archive**
  - first header kind: **header.phero**
  - header inner width: **1136.0px**
  - H1 width: **786.6px** · text-align **start** · max-width **786.622px**
  - sections count: section.sec=1 · .cta-band=0 · .bleed=0 · ea-wave2-*=2
  - Row #1:
    - wrap width **1136.0px**, padding-inline **48px / 48px**, wrap.x-left **152.0**
    - h2 x-left **945.0**, width **270.0px**, text-align **start**
    - reading (ARTICLE): width **320.0px**, max-width **none**, margin L/R **0px / 0px**, x-left **920.0**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **-25.0px** (dir=rtl)
  - CTA band: **MISSING**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main, ea-wave2-blog-archive**
  - first header kind: **header.phero**
  - header inner width: **326.0px**
  - H1 width: **230.0px** · text-align **start** · max-width **574.839px**
  - sections count: section.sec=1 · .cta-band=0 · .bleed=0 · ea-wave2-*=2
  - Row #1:
    - wrap width **326.0px**, padding-inline **48px / 48px**, wrap.x-left **32.0**
    - h2 x-left **105.0**, width **180.0px**, text-align **start**
    - reading (ARTICLE): width **230.0px**, max-width **none**, margin L/R **0px / 0px**, x-left **80.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **-25.0px** (dir=rtl)
  - CTA band: **MISSING**

### /%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-2/ — blog (single picked from /blog/)
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main, ea-wave2-blog-single**
  - first header kind: **header.phero**
  - header inner width: **896.0px**
  - H1 width: **786.6px** · text-align **start** · max-width **786.622px**
  - sections count: section.sec=2 · .cta-band=0 · .bleed=0 · ea-wave2-*=2
  - Row #1:
    - wrap width **896.0px**, padding-inline **48px / 48px**, wrap.x-left **272.0**
    - h2 x-left **320.0**, width **800.0px**, text-align **center**
    - reading (ARTICLE): width **380.0px**, max-width **none**, margin L/R **0px / 0px**, x-left **740.0**
    - section padding-top/bottom **88px / 88px**, bg **rgb(239, 234, 225)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - CTA band: **MISSING**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main, ea-wave2-blog-single**
  - first header kind: **header.phero**
  - header inner width: **326.0px**
  - H1 width: **230.0px** · text-align **start** · max-width **574.839px**
  - sections count: section.sec=2 · .cta-band=0 · .bleed=0 · ea-wave2-*=2
  - Row #1:
    - wrap width **326.0px**, padding-inline **48px / 48px**, wrap.x-left **32.0**
    - h2 x-left **80.0**, width **230.0px**, text-align **center**
    - reading (ARTICLE): width **230.0px**, max-width **none**, margin L/R **0px / 0px**, x-left **80.0**
    - section padding-top/bottom **40px / 40px**, bg **rgb(239, 234, 225)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - CTA band: **MISSING**

### /qr/qr1/ — qr1
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **1200.0px**
  - H1 width: **786.6px** · text-align **start** · max-width **786.622px**
  - sections count: section.sec=1 · .cta-band=0 · .bleed=0 · ea-wave2-*=1
  - rows(h2+reading): **MISSING**
  - CTA band: **MISSING**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **390.0px**
  - H1 width: **294.0px** · text-align **start** · max-width **574.839px**
  - sections count: section.sec=1 · .cta-band=0 · .bleed=0 · ea-wave2-*=1
  - rows(h2+reading): **MISSING**
  - CTA band: **MISSING**

### /en/ — en
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **1200.0px**
  - H1 width: **786.6px** · text-align **left** · max-width **786.622px**
  - sections count: section.sec=34 · .cta-band=0 · .bleed=0 · ea-wave2-*=1
  - Row #1:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **left**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.359px / 164.375px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **-164.4px** (dir=ltr)
  - Row #2:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **left**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.359px / 164.375px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **-164.4px** (dir=ltr)
  - Row #3:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **left**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.359px / 164.375px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **-164.4px** (dir=ltr)
  - CTA band: **MISSING**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **390.0px**
  - H1 width: **294.0px** · text-align **left** · max-width **574.839px**
  - sections count: section.sec=34 · .cta-band=0 · .bleed=0 · ea-wave2-*=1
  - Row #1:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **left**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=ltr)
  - Row #2:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **left**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=ltr)
  - Row #3:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **left**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=ltr)
  - CTA band: **MISSING**

### /learning/ — learning
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **1200.0px**
  - H1 width: **786.6px** · text-align **start** · max-width **786.622px**
  - sections count: section.sec=7 · .cta-band=1 · .bleed=0 · ea-wave2-*=1
  - Row #1:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - Row #2:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - Row #3:
    - wrap width **1200.0px**, padding-inline **48px / 48px**, wrap.x-left **120.0**
    - h2 x-left **168.0**, width **1104.0px**, text-align **start**
    - reading (.intro-body): width **775.3px**, max-width **775.276px**, margin L/R **164.375px / 164.359px**, x-left **332.4**
    - section padding-top/bottom **88px / 88px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **164.4px** (dir=rtl)
  - CTA band width vs wrap: **1440.0px** vs **1200.0px**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **chapters-main**
  - first header kind: **header.phero**
  - header inner width: **390.0px**
  - H1 width: **294.0px** · text-align **start** · max-width **574.839px**
  - sections count: section.sec=7 · .cta-band=1 · .bleed=0 · ea-wave2-*=1
  - Row #1:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #2:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - Row #3:
    - wrap width **390.0px**, padding-inline **48px / 48px**, wrap.x-left **0.0**
    - h2 x-left **48.0**, width **294.0px**, text-align **start**
    - reading (.intro-body): width **294.0px**, max-width **775.276px**, margin L/R **0px / 0px**, x-left **48.0**
    - section padding-top/bottom **40px / 40px**, bg **rgba(0, 0, 0, 0)**
    - h2-body start-edge delta: **0.0px** (dir=rtl)
  - CTA band width vs wrap: **390.0px** vs **390.0px**

### /historical-articles/ — historical-articles
- **DESKTOP 1440×900**
  - html.clientWidth/scrollWidth: **1440 / 1440**
  - main.classList: **site-main**
  - first header(.phero/.hero): **MISSING**
  - sections count: section.sec=0 · .cta-band=0 · .bleed=0 · ea-wave2-*=0
  - rows(h2+reading): **MISSING**
  - CTA band: **MISSING**
- **MOBILE 390×844**
  - html.clientWidth/scrollWidth: **390 / 390**
  - main.classList: **site-main**
  - first header(.phero/.hero): **MISSING**
  - sections count: section.sec=0 · .cta-band=0 · .bleed=0 · ea-wave2-*=0
  - rows(h2+reading): **MISSING**
  - CTA band: **MISSING**


---
## Static CSS evidence (grep) + live family mapping
### `65ch` consumers (static)
- `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-blog.css` contains: `.ea-wave2-editorial .ea-section-intro__body { max-width: 65ch; }`
- `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-atoms.css` contains multiple `max-width: 65ch;` rules
- `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/w2-14e-catalog.css` contains `max-width: 65ch;`

**Live mapping:**
- `/press/` measured `main.classList = ea-wave2-editorial` → **F-EDITORIAL-65CH** is the live family most directly tied to the `65ch` rule above.

### `--ea-prose-width` (960px token) consumers
- Token definition: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css` sets `--ea-prose-width: 960px;`
- Static consumers include (non-exhaustive grep hits):
  - `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-blog.css`
  - `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/w2-05-shop.css`
  - `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/w2-04-service.css`
  - `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/w2-10-service.css`
  - `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/w2-07-heritage.css`
  - `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/w2-08-en-landing.css`
  - `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/w2-14e-catalog.css`

**Live mapping:**
- Blog single picked from /blog/: `/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-2/` measured `main.classList` includes `ea-wave2-blog-single` → **F-BLOG-SINGLE-960** is a live consumer candidate for `--ea-prose-width`.
- `/blog/` measured `main.classList` includes `ea-wave2-blog-archive` → **F-BLOG-ARCHIVE** is a live consumer candidate for `--ea-prose-width`.
- `/shop/` measured `main.classList = chapters-main` but had **ROWS(h2+reading) MISSING** in this probe; static CSS indicates shop styles (`w2-05-shop.css`) do consume `--ea-prose-width`.

---
## Mobile (390×844) overflow scan
- none detected in this sample
