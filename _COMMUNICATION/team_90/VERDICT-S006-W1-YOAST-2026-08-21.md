VERDICT: PASS

**Validator:** team_90 (`composer-2.5`) · **Builder:** Cursor Grok 4.6 · Iron Rule #1 (cross-engine).
**Mandate:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-W1-YOAST-2026-08-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-W1-YOAST-2026-08-21.md)
**Staging:** [http://eyalamit-co-il-2026.s887.upress.link/lessons/](http://eyalamit-co-il-2026.s887.upress.link/lessons/) · `curl -sk` · no `-fast`
**Date:** 2026-08-21

---

## Contract 1 — JSON-LD FAQPage on `/lessons/` · D6 href byte-for-byte

**HTTP:** `200 OK` · body **80170** bytes (non-empty — not FAIL).

**D6 canonical URL (Eyal 19.8):**

```
https://www.eyalamit.co.il/Blog/%d7%a0%d7%a9%d7%99%d7%9d-%d7%9e%d7%a0%d7%92%d7%a0%d7%95%d7%aa-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%90%d7%99%d7%a9%d7%94-%d7%9e%d7%a0%d7%92%d7%a0%d7%aa-%d7%91%d7%93%d7%99%d7%92/
```

**Yoast `@graph` FAQPage entity** (`האם אפשר בזמן הריון?`) — `acceptedAnswer.text` href (quoted from live HTML):

```html
<a class="tlink" href="https://www.eyalamit.co.il/Blog/%d7%a0%d7%a9%d7%99%d7%9d-%d7%9e%d7%a0%d7%92%d7%a0%d7%95%d7%aa-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%90%d7%99%d7%a9%d7%94-%d7%9e%d7%a0%d7%92%d7%a0%d7%aa-%d7%91%d7%93%d7%99%d7%92/">קראו עוד</a>
```

**Byte compare:** `href == D6` → **true** (Python `==` on extracted string; 1 occurrence in full page HTML).

**Forbidden:** `/blog/pregnancy-didgeridoo` — **not present** anywhere in `/lessons/` response (case-insensitive grep).

**Result:** CONFIRM.

---

## Contract 2 — Seed `lessons-06` in `ea-faq-seed.json`

**Source:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/data/ea-faq-seed.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/data/ea-faq-seed.json)

**`seed_key` `lessons-06` answer href (quoted):**

```html
<a class="tlink" href="https://www.eyalamit.co.il/Blog/%d7%a0%d7%a9%d7%99%d7%9d-%d7%9e%d7%a0%d7%92%d7%a0%d7%95%d7%aa-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%90%d7%99%d7%a9%d7%94-%d7%9e%d7%a0%d7%92%d7%a0%d7%aa-%d7%91%d7%93%d7%99%d7%92/">קראו עוד</a>
```

**Byte compare:** seed href `== D6` → **true**.

**Result:** CONFIRM.

---

## Contract 3 — Scope: `/lessons/` only (no `/faq/` validation)

Per mandate: validator **did not** open `/faq/` (tabs/TOC out of scope). All live checks above used **`/lessons/`** only.

**Result:** CONFIRM (procedure).

---

## Visible DOM (informational — not separate contract clause)

FAQ accordion on `/lessons/` line ~291 mirrors the same D6 href in visible markup (consistent with JSON-LD).

---

## Allowed-artifact note

Wave Yoast allow-list: `ea-faq-seed.json` · `ea-s006-pregnancy-href-once.php`. WAIT-WAVE / pre-wave `seo-head-fallbacks.php` dirtiness **not** in scope per mandate — no FAIL on those files.

---

## Summary

| Check | Result |
|-------|--------|
| FAQPage JSON-LD href byte-for-byte D6 | PASS |
| No `/blog/pregnancy-didgeridoo` on `/lessons/` | PASS |
| Seed `lessons-06` matches D6 | PASS |
| Validation scope `/lessons/` only | PASS |

**Overall:** PASS — wave 1 Yoast pregnancy href contract satisfied on staging.
