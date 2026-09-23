# S007 independent control — technical health — 2026-09-21

## Identity and verdict

- **Role:** independent technical control; engine differs from the Composer builder.
- **Scope:** live staging only; no FTP, deployment, commit, or site mutation.
- **Staging:** http://eyalamit-co-il-2026.s887.upress.link
- **Method:** browser-UA GET without redirect following for HTTP checks; rendered CDP for layout and console checks.
- **Overall verdict:** **PASS**

All requested live checks passed. There are no overflow failures, HTTP expectation mismatches, or first-party CSS/JS 404s in the requested sample.

## 1. Live theme version

**PASS**

- `GET http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/style.css?nc=1790018000` returned **200**.
- The stylesheet header reports `Version: 1.5.103`.
- Homepage HTML also loads `http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/style.css?ver=1.5.103`.

## 2. Rendered overflow probe

**PASS — 20/20 page/viewport combinations; 0 failures.**

Runner:

`node /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs`

Machine-readable result:

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/control-tech-health-2026-09-21/qa_probe_result.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/control-tech-health-2026-09-21/qa_probe_result.json)

Screenshots:

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/control-tech-health-2026-09-21/screenshots/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/control-tech-health-2026-09-21/screenshots/)

| URL | 375px `scrollWidth/clientWidth` | 1440px `scrollWidth/clientWidth` | Result |
|---|---:|---:|---|
| http://eyalamit-co-il-2026.s887.upress.link/ | 375 / 375 | 1440 / 1440 | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/en/ | 375 / 375 | 1440 / 1440 | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/learning/ | 375 / 375 | 1440 / 1440 | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/learning/courses-external/ | 375 / 375 | 1440 / 1440 | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/contact/ | 375 / 375 | 1440 / 1440 | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/press/ | 375 / 375 | 1440 / 1440 | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/ | 375 / 375 | 1440 / 1440 | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/faq/ | 375 / 375 | 1440 / 1440 | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/didgeridoos/ | 375 / 375 | 1440 / 1440 | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/thank-you/ | 375 / 375 | 1440 / 1440 | PASS |

### Overflow FAIL list

None.

## 3. CDP console and asset sample at 390px

**PASS**

Browser UA observed: `HeadlessChrome/149.0.7827.22`.

| URL | First-party CSS/JS 404s | Relevant console errors |
|---|---:|---:|
| http://eyalamit-co-il-2026.s887.upress.link/ | 0 | 0 |
| http://eyalamit-co-il-2026.s887.upress.link/en/ | 0 | 0 |

The homepage emitted one non-error browser warning, `Unrecognized feature: 'web-share'.`; it is not a first-party asset 404 or console error. Third-party YouTube/gtag noise was excluded as requested.

### First-party asset 404 list

None.

## 4. High-risk HTTP sample

All requests used a Chrome browser UA and **did not follow redirects**.

| Request | Expected | Observed | Result |
|---|---|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/services/ | 404 | **404**, no `Location` | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/about/ | 301 | **301** → `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/` | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/about/moksha/ | Must not redirect to the `/eyal-amit/` root | **301** → `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/` | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/%D7%90%D7%99%D7%99%D7%9C-%D7%A2%D7%9E%D7%99%D7%AA-%D7%90%D7%95%D7%93%D7%95%D7%AA/ | 301 → `/eyal-amit/` | **301** → `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/` | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/en/ | 200 | **200** | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/learning/ | 200 | **200** | PASS |
| http://eyalamit-co-il-2026.s887.upress.link/qr/qr1/ | 200; permalink intact | **200** | PASS |

### HTTP mismatch list

None.

## 5. Canonical homepage navigation

**PASS**

- Homepage HTML contains two real anchors to `http://eyalamit-co-il-2026.s887.upress.link/learning/courses-external/`: one in the desktop navigation and one in the mobile drawer.
- No anchor to `http://eyalamit-co-il-2026.s887.upress.link/services/` was found anywhere in homepage HTML; therefore there is no live `/services/` L1 item in the sampled canonical homepage navigation.

## Repository-health note outside the staging verdict

The mandatory repository validator was also run. It returned **47 PASS / 35 SKIP / 3 FAIL** for pre-existing AOS governance-cache issues: incomplete governance snapshots in checks 11 and 13, plus cache-count drift in check 65. These failures do not alter the requested live staging technical-health verdict and no `_aos/` file was edited.
