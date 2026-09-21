# VERIFY — S007 QPACK (Independent LIVE validation) — 2026-09-21

## סיכום קצר לנימרוד

החבילה נראית **תקינה בלייב**: כל סעיפים 1–5 עומדים בציפיות (כולל `/services/` כ-404 ללא הפניה, הפניות `/about/` ל-`/eyal-amit/`, עמוד קורסים חי, `/en/` עם נוסח C3 ללא «הערה לנמרוד», וגרסת תמה `1.5.101`). גם ה-Hub עלה 200 ומזכיר את הסיגנלים (סעיף 6 — אופציונלי).

## Scope / Identity

- **Repo**: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026`
- **SSOT**: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json` (מקור EN: C3 `eyal.note`, ללא הטריילר «הערה לנמרוד…»)
- **Staging base**: `http://eyalamit-co-il-2026.s887.upress.link`
- **Method**:
  - Python `urllib` GET **ללא מעקב redirect** (handler שמחזיר `None`) + UA דפדפן Chrome/128.
  - CDP optional: `qa_probe.mjs` רץ על `/en/` ו-`/learning/courses-external/` ב-`375px` ו-`1440px` (ברירת־מחדל של הכלי; לא `390px`) עם forbidden-strings כפי שמוגדר בסעיף 4/3.

## Results table (PASS only if 1–5 pass)

| Check ID | Expected | Observed (LIVE evidence) | PASS/FAIL |
|---|---|---|---|
| 1a | `GET /services/` unpublished; **no 301/410**, expect 404/200-404-template; must NOT show `עמוד הורה לשירותים`; must NOT `Location: /` | `GET http://eyalamit-co-il-2026.s887.upress.link/services/` → **404**, **no `Location` header**; body **does not contain** `עמוד הורה לשירותים` | PASS |
| 1b | Regression: `/services/didgeridoo-lessons/` still **301 → /lessons/** | `GET http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-lessons/` → **301** `Location: http://eyalamit-co-il-2026.s887.upress.link/lessons/` | PASS |
| 1c | Regression: `/services/didgeridoo-treatment-breath/` still **301** (not 404) | `GET http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-treatment-breath/` → **301** `Location: http://eyalamit-co-il-2026.s887.upress.link/treatment/` | PASS |
| 1d | Regression: `/services/handmade-instruments/` still **301** (not 404) | `GET http://eyalamit-co-il-2026.s887.upress.link/services/handmade-instruments/` → **301** `Location: http://eyalamit-co-il-2026.s887.upress.link/didgeridoos/` | PASS |
| 2a | `/about/` **301 → /eyal-amit/** | `GET http://eyalamit-co-il-2026.s887.upress.link/about/` → **301** `Location: http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/` | PASS |
| 2b | Hebrew slug `/אייל-עמית-אודות/` (encoded) **301 → /eyal-amit/** in one hop (not → `/about/`) | `GET http://eyalamit-co-il-2026.s887.upress.link/%D7%90%D7%99%D7%99%D7%9C-%D7%A2%D7%9E%D7%99%D7%AA-%D7%90%D7%95%D7%93%D7%95%D7%AA/` → **301** `Location: http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/` | PASS |
| 2c | `/about/moksha/` still **301 → /eyal-amit/mokesh-dahiman/** | `GET http://eyalamit-co-il-2026.s887.upress.link/about/moksha/` → **301** `Location: http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/` | PASS |
| 2d | `/eyal-amit/` 200 contains `הקשר שלי עם מוקש התחיל בשנת 2000` and also `2003`; nav has `אודות אייל` → `/eyal-amit/` not `/about/` | `GET http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/` → **200**; body contains **both** `הקשר שלי עם מוקש התחיל בשנת 2000` and `2003`; anchors with label `אודות אייל` link to `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/` | PASS |
| 3a | `/learning/courses-external/` 200; visible `יעלה בקרוב` and `קורסים`; must NOT contain `PLACEHOLDER — G3` | `GET http://eyalamit-co-il-2026.s887.upress.link/learning/courses-external/` → **200**; body contains `יעלה בקרוב` + `קורסים`; **does not contain** `PLACEHOLDER — G3` | PASS |
| 3b | Canonical nav on home and `/eyal-amit/` includes a real `href` to `/learning/courses-external/` with label `קורסים` (not `href=\"#\"`) | Home: anchors with label `קורסים` → `http://eyalamit-co-il-2026.s887.upress.link/learning/courses-external/` (twice). `/eyal-amit/`: same. | PASS |
| 3c | L1 count remains **10** (courses is child of לימוד והכשרה, not new L1) | Parsed `ul.nav__l` on home: **10** top-level `<li>` items. (Two L1 items are rendered as buttons/dropdowns; still counted in the 10.) | PASS |
| 4a | `/en/` 200; H1 or title `Didgeridoo Healing Center` | `GET http://eyalamit-co-il-2026.s887.upress.link/en/` → **200**; **H1** = `Didgeridoo Healing Center` (HTML `<title>` observed: `English - eyal amit`) | PASS |
| 4b | `/en/` contains Eyal phrases: `English-speaking visitors are welcome`, `cbDIDG`, Mukesh + `2000`, WhatsApp `wa.me/972524822842` | `/en/` body contains all required strings; WhatsApp link substring present: `wa.me/972524822842` | PASS |
| 4c | `/en/` must NOT contain WP draft banner `WP-EI-06` / `Draft — English summary is a team draft` and must NOT contain Hebrew `הערה לנמרוד` | `/en/` body contains **none** of: `WP-EI-06`, `Draft — English summary is a team draft`, `הערה לנמרוד` | PASS |
| 4d | Photo placeholders present `Photo — to be chosen` (~5 slots; aria/visible may double-count) | `/en/` contains `Photo — to be chosen` (counted **10** occurrences in raw HTML; consistent with ~5 slots duplicated) | PASS |
| 5 | Theme style.css contains `Version: 1.5.101` | `GET http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/style.css` → **200**; header line: `Version: 1.5.101` | PASS |
| 6 (optional) | Hub form mentions unpublished services / published EN | `GET http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html` → **200**; page contains signals referencing `services` / `/services/` and EN (`/en/` / English / אנגלית) | PASS (optional) |

## Optional CDP probe (qa_probe.mjs)

- Ran: `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /en/,/learning/courses-external/ --absent \"WP-EI-06,Draft — English summary is a team draft,הערה לנמרוד,PLACEHOLDER — G3\"`
- Verdict: **PASS** (0 failures)
- Viewports: **mobile 375×812** and **desktop 1440×900** (tool default; user asked 390 & 1440 — 390 not used without a config file)

## Typography guardrail check (new files only)

Searched for new inline `font-size: <n>px` in these builder-pack files:

- `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/photo-slot.php`
- `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/en-defaults.php`
- `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/courses-external-defaults.php`
- `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/mu-plugins/ea-s007-qpack-once.php`

Result: **no matches found** (no new component `font-size` in px in those files).

## FAIL list (only if any)

None.

