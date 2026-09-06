VERDICT: PASS

**Validator:** team_90 (Composer) · **Builder:** Cursor Grok 4.6 · Iron Rule #1 (cross-engine; no code changes).
**Mandate:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-SEO-FAQ-E2E-B-2026-08-18.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-SEO-FAQ-E2E-B-2026-08-18.md)
**Prior contract (PASS):** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-SEO-FAQ-CONTRACT-A-2026-08-18.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-SEO-FAQ-CONTRACT-A-2026-08-18.md)
**Staging base:** [http://eyalamit-co-il-2026.s887.upress.link](http://eyalamit-co-il-2026.s887.upress.link) · `curl -sk` · no `-fast`
**Date:** 2026-08-18

---

## Executive summary

All seven mandatory regression checks on live staging **CONFIRM**. Testimonials SEO chrome is clean with 44 quote cards in `<main>`; FAQ hero/H1/hrefs intact; three book child pages free of `mrng.to` and invented prices; snoring page retains Yoni story and pending Maccabi/Yoni cards; parent `/books/` retains allowed bundle `mrng.to`; desktop `qa_probe` reports `overflow: false` on all six paths; sampled nav URLs return HTTP 200.

---

## 1 — `/testimonials/`

**HTTP:** `200 OK` · body `65 030` bytes (non-empty).

**Live meta (quoted):**

```html
<meta property="og:description" content="סרטונים, הקלטות, וכתבות על העבודה עם הנשימה והדיג׳רידו." />
<meta name="description" content="סרטונים, הקלטות, וכתבות על העבודה עם הנשימה והדיג׳רידו." />
```

**Forbidden strings in `<head>`:** `PLACEHOLDER` · `צוות 80` · `לא לאישור פרסום` — **none found**.

**H1 inside `<main id="chapters-main">` (quoted):**

```html
<h1 class="phero__h">מדיה <em>ווידאו</em></h1>
```

**Testimonial cards in `<main>`:** `44` × `<figure class="tmq tmq--full">` (threshold ≥ 40).

**Pending media (not a fail):** `ea-pending-approval` block «אוסף המדיה בהשלמה» present (M-03/M-04).

**Result:** CONFIRM.

---

## 2 — `/faq/`

**HTTP:** `200 OK` · body non-empty.

**H1 (quoted):**

```html
<h1 class="phero__h">שאלות נפוצות</h1>
```

**`<em>` in FAQ H1:** absent (CONFIRM).

**Hero present (quoted):**

```html
<header class="phero phero--media">
  <img class="phero__media" src="http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/assets/images/chapters/studio-mosaic.jpg" alt="הסטודיו בפרדס חנה — שאלות נפוצות">
```

**Three mandated hrefs retained (quoted):**

```
href="/blog/pregnancy-didgeridoo"
href="/muse"
href="/cbDidg-therapy-training"
```

**Remap check:** `/books/` and `/learning/therapist-training/` **not** substituted for the three Eyal-source hrefs in FAQ body. HTTP 404 on those three URLs is explicitly not a fail per mandate.

**Result:** CONFIRM.

---

## 3 — Book child pages

### `/books/kushi-blantis/`

**HTTP:** `200 OK` · `71 057` bytes.

**H1 (quoted):** `<h1 class="phero__h">כושי בלאנטיס</h1>`

**`mrng.to`:** absent · **invented prices 69/59/79:** absent.

**Result:** CONFIRM.

### `/books/tsva-bekahol/`

**HTTP:** `200 OK` · `66 543` bytes.

**H1 (quoted):** `<h1 class="phero__h">צבע בכחול וזרוק לים</h1>`

**`mrng.to`:** absent · **invented prices 69/59/79:** absent.

**Live Mendele button (TSV-07):** absent. Purchase block shows contact-only path:

```html
<a class="tlink" href="/contact/">לרכישת עותק מודפס – צרו קשר</a>
```

**Result:** CONFIRM.

### `/books/vekatavta/`

**HTTP:** `200 OK` · `72 301` bytes.

**H1 (quoted):** `<h1 class="phero__h">וכתבת</h1>`

**`mrng.to`:** absent · **invented prices 69/59/79:** absent.

**Hiccup spellings retained:** `היקוקומורי` · `היקוקמורי`.

**Result:** CONFIRM.

---

## 4 — `/snoring-sleep-apnea/`

**HTTP:** `200 OK` · body non-empty.

**Yoni story present:** section `id="הסיפור-של-יוני"` with heading:

```html
<h2 class="h2 r" style="margin-bottom:18px">הסיפור של יוני</h2>
```

Body includes verbatim case narrative (e.g. «יוני, שם בדוי, הוא איש הייטק ואבא לחמישה ילדים.»).

**Pending cards retained (not a fail):**

- `ea-pending-approval` — «סיפור המקרה «יוני» + תמונת יוני.jpg»
- `ea-pending-approval` — «יוני.jpg — ממתין לאישור / מדיה חסרה»
- `ea-pending-approval` — «מכבי.jpg — ממתין לאישור / מדיה חסרה»

**Maccabi section present:** `id="מכבי-דיגרידו"` with link to official Maccabi page.

**Result:** CONFIRM.

---

## 5 — Parent `/books/` (`mrng.to` allowed)

**HTTP:** `200 OK`.

**Bundle link present (allowed per mandate):**

```
mrng.to/MTUiO3vkIg
```

**Result:** CONFIRM — child pages clean; parent bundle link permitted.

---

## 6 — Desktop `qa_probe` (overflow)

**Command:**

```bash
node /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs \
  --base http://eyalamit-co-il-2026.s887.upress.link \
  --paths /testimonials/,/faq/,/books/kushi-blantis/,/books/tsva-bekahol/,/books/vekatavta/,/snoring-sleep-apnea/
```

**Verdict:** `PASS` · `failures: 0` · `ts: 2026-08-18T14:32:23.345Z`

| viewport | path | overflow | pass |
|----------|------|----------|------|
| desktop | `/testimonials/` | false | true |
| desktop | `/faq/` | false | true |
| desktop | `/books/kushi-blantis/` | false | true |
| desktop | `/books/tsva-bekahol/` | false | true |
| desktop | `/books/vekatavta/` | false | true |
| desktop | `/snoring-sleep-apnea/` | false | true |

**Result:** CONFIRM.

---

## 7 — Sample nav URLs (200 or 301)

| path | HTTP |
|------|------|
| `/` | 200 |
| `/method/` | 200 |
| `/lessons/` | 200 |
| `/shop/` | 200 |
| `/contact/` | 200 |
| `/eyal-amit/` | 200 |
| `/books/` | 200 |
| `/faq/` | 200 |

**Result:** CONFIRM.

---

## Final disposition

| check | status |
|-------|--------|
| `/testimonials/` SEO + H1 + cards | PASS |
| `/faq/` H1 + hero + hrefs | PASS |
| `/books/kushi-blantis/` | PASS |
| `/books/tsva-bekahol/` | PASS |
| `/books/vekatavta/` | PASS |
| `/snoring-sleep-apnea/` | PASS |
| parent `/books/` mrng allowed | PASS |
| desktop `qa_probe` overflow | PASS |
| nav sample URLs | PASS |

**Overall:** **PASS** — S006 E2E ב׳ regression remainder + testimonials confirmed on live staging.
