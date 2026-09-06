VERDICT: PASS

**Validator:** team_90 (Composer) · **Builder:** Cursor Grok 4.6 · Iron Rule #1 (cross-engine).
**Mandate:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-SEO-FAQ-CONTRACT-A-2026-08-18.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-SEO-FAQ-CONTRACT-A-2026-08-18.md)
**Staging base:** [http://eyalamit-co-il-2026.s887.upress.link](http://eyalamit-co-il-2026.s887.upress.link) · `curl -sk` · no `-fast`
**Date:** 2026-08-18

---

## Contract 1 — `/testimonials/` SEO chrome + H1 (M-03)

**HTTP:** `200 OK` on `curl -sk -D - http://eyalamit-co-il-2026.s887.upress.link/testimonials/`

**Live meta tags (quoted):**

```html
<meta property="og:description" content="סרטונים, הקלטות, וכתבות על העבודה עם הנשימה והדיג׳רידו." />
<meta name="description" content="סרטונים, הקלטות, וכתבות על העבודה עם הנשימה והדיג׳רידו." />
```

**Forbidden strings in `<head>`:** `PLACEHOLDER` · `צוות 80` · `לא לאישור פרסום` — **none found**.

**H1 inside `<main>` (quoted):**

```html
<h1 class="phero__h">מדיה <em>ווידאו</em></h1>
```

**Result:** CONFIRM — expected subtitle copy; M-03 `<em>` preserved.

---

## Contract 2 — `/faq/` Eyal-source hrefs unchanged

**HTTP:** `200 OK` on `curl -sk http://eyalamit-co-il-2026.s887.upress.link/faq/`

**Three mandated hrefs inside `<main>` (quoted):**

```
href="/blog/pregnancy-didgeridoo"
href="/muse"
href="/cbDidg-therapy-training"
```

**Silent remap check inside `<main>`:** `/books/` — **not present** · `/learning/therapist-training/` — **not present** (nav footer elsewhere on page is out of scope; contract targets FAQ body hrefs).

**FAQ H1 inside `<main>` (quoted):**

```html
<h1 class="phero__h">שאלות נפוצות</h1>
```

**`<em>` in FAQ H1:** absent (CONFIRM).

**Result:** CONFIRM — Eyal-source bytes retained; 404 status of the three URLs is explicitly not a fail per mandate.

---

## Contract 3 — Tracker rows

**Source:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/latest-items.csv](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/latest-items.csv)

**FAQ-05..07 (quoted status column):**

| ID | סטטוס מכונה | ממתין ל |
|----|-------------|---------|
| FAQ-05 | ממתין לאייל | אייל |
| FAQ-06 | ממתין לאייל | אייל |
| FAQ-07 | ממתין לאייל | אייל |

**FAQ-01..04:** all present (FAQ-01 `ממתין לאייל`; FAQ-02 `בוצע`; FAQ-03 `בוצע`; FAQ-04 `ממתין לאייל`) — not deleted.

**Parent row R1-25** in [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/latest.csv](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/latest.csv) (quoted):

```
סבב-1-ליבה,R1-25,הוגש לבדיקה,—,אייל,/faq/,שאלות נפוצות (FAQ),...
```

**Result:** CONFIRM — `ממתין ל` = `אייל` for R1-25; FAQ-05/06/07 registered `ממתין לאייל`.

---

## Contract 4 — Unmapped hooks untouched

**`git diff --stat` (quoted):**

```
 .../S006/tracker/EA-CONTENT-ITEMS-2026-08-18.csv   |   3 +
 .../S006/tracker/EA-CONTENT-TRACKER-2026-08-18.csv |   4 +-
 .../team_100/S006/tracker/latest-items.csv         |   3 +
 _COMMUNICATION/team_100/S006/tracker/latest.csv    |   4 +-
 .../team_100/S006/tracker/r1-25-items.json         |  51 ++++++++
 scripts/ftp_deploy_site_wp_content.py              |   2 +
 scripts/tracker_page_tab.py                        |  90 +++++++++++--
 scripts/tracker_render.py                          |  67 ++++++----
 .../themes/ea-eyalamit/inc/seo-head-fallbacks.php  |  39 +++++-
 tmp/qa/cdp/qa_probe_result.json                    | 139 +++++++++++++++++----
 10 files changed, 333 insertions(+), 69 deletions(-)
```

**Untracked mapped file (present on disk, not in diff index):**

`site/wp-content/mu-plugins/ea-s006-strip-team80-seo-once.php`

**Unmapped-hook scan (`git diff --name-only` vs forbidden list):** `media-defaults.php` · `block-faq-list.php` · `ea-faq-seed.json` · `muzza-defaults.php` · `videoblk.php` · frozen defaults (`learning/lectures/workshops/galleries/therapist-training`) — **none touched**.

**Mapped files in scope:** `seo-head-fallbacks.php` (modified) · `ea-s006-strip-team80-seo-once.php` (new) · `ftp_deploy_site_wp_content.py` · `tracker_page_tab.py` · `tracker_render.py` · `r1-25-items.json` — all accounted for.

**Result:** CONFIRM — no unmapped-hook violation.

---

## Summary

| # | Contract | Result |
|---|----------|--------|
| 1 | Testimonials meta clean + H1 M-03 | **CONFIRM** |
| 2 | FAQ three Eyal hrefs in `<main>`, H1 no `<em>` | **CONFIRM** |
| 3 | Tracker FAQ-05/06/07 + R1-25 waiting-on אייל | **CONFIRM** |
| 4 | No unmapped PHP/JSON/default edits | **CONFIRM** |

**Overall:** PASS — all four contract clauses confirmed on live staging and in-repo evidence.
