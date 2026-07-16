---
id: DECISION-NAP-CANON-2026-07-16
from_team: team_110
to_team: team_100
cc: [team_00, team_30, team_90, team_190]
date: 2026-07-16
type: decision-record
status: RATIFIED — team_00, 2026-07-16
scope: site-wide (NAP — Name / Address / Phone)
ssot_file: site/wp-content/mu-plugins/ea-w2-seo-schema.php (self-declared "BUSINESS-NAP-AND-HOURS SSoT", L6 / L53)
authorized_by: "team_00 (נמרוד) 2026-07-16 — «אני לא יודע כמה פעמים כבר אישרתי את הכתובת והטלפון האלו. גם אייל אישר - שוב ושוב ושוב זה חוזר. די. זה המידע המדוייק. לא לשאול יותר שוב!!! לתקן בפוטר בהתאם ובכל מקום שצריך.»"
supersedes: "WP-S4-07 verdict's open item «decide D1 NAP footer line per BN-01 recommendation» — DECIDED, see §2"
---

# DECISION RECORD — NAP canon (RATIFIED · לא לשאול שוב)

## 0. ⛔ Read this first — the standing instruction

**The address and phone are APPROVED.** By team_00 repeatedly, and by Eyal repeatedly. They are **not** an
open question, **not** a decision gate, and **not** something to re-confirm.

> **דיר באלק אם שוב אתם שואלים אותו מה הטלפון.** — team_00, 2026-07-16

**No agent, WP, spec, verdict or gate may re-open this.** If a future artifact asks "what is the NAP?" or
defers a NAP decision — that artifact is **wrong**; point it here. This record is the answer.

## 1. Why it kept coming back (root cause — this is the actual bug)

The NAP **was never missing**. It has been sitting in a **self-declared SSoT** the whole time:
`site/wp-content/mu-plugins/ea-w2-seo-schema.php` — *"BUSINESS-NAP-AND-HOURS SSoT; ProfessionalService
inherits LocalBusiness props"* (L6), *"Business: cbDIDG breath-therapy center (**NAP SSoT**)"* (L53).

**But nothing else in the codebase reads from it.** Every surface hard-codes its own copy. Result — team_110
forensics, 2026-07-16, found **6 phone variants and 3 apostrophe variants** of the *same* approved data:

| Phone variant | Hyphen | Files | |
|---|---|---|---|
| `052-4822842` | U+002D | 5 | display majority |
| `+972524822842` | — | 2 | `tel:` href |
| `052‑4822842` | **U+2011** | 1 | `contact.php` — non-breaking hyphen |
| `052-482-2842` | U+002D | 1 | `ea-faq-seed.json` |
| `0524822842` | — | 1 | testimonials |
| **`052-482284`** | U+002D | 1 | 🔴 **WRONG — 9 digits, see §3** |

| Address variant | Char | File |
|---|---|---|
| `עמל 8 ב'` | U+0027 | `ea-w2-seo-schema.php` (SSoT), `contact.php`, `ea-faq-seed.json` |
| `עמל 8 ב׳` | **U+05F3** (Hebrew geresh) | `seo-head-fallbacks.php` |

So **WP-S4-07's AC-10 ("NAP byte-identical FAQ ↔ footer") could never pass** — there was no canonical byte
form to match against, and the footer had no NAP at all. Each WP that touched it "discovered" the ambiguity
and escalated it as a question, instead of the codebase having one source. **That is what this record ends.**

## 2. THE CANON — copy these exactly

Taken from the declared SSoT (`ea-w2-seo-schema.php`), which is authoritative. **Nothing here is a new
decision about Eyal's data — it is the already-approved data, plus one format ruling per surface.**

| Field | Canonical value | Where used |
|---|---|---|
| **Street address** | `עמל 8 ב'` — apostrophe is **U+0027** (straight `'`), **not** U+05F3 `׳` | all display + schema |
| **Locality** | `פרדס חנה-כרכור` — hyphen **U+002D** | all display + schema |
| **Full address (display)** | `רח' עמל 8 ב', פרדס חנה-כרכור` | footer, contact, FAQ |
| **Phone — schema/E.164** | `+972-52-482-2842` | `schema.org` `telephone` **only** |
| **Phone — `tel:` href** | `+972524822842` | every `<a href="tel:…">` |
| **Phone — human display** | `052-4822842` — hyphen **U+002D** | footer, contact, FAQ, QR, everywhere visible |

### Format rulings (team_110 engineering calls — NOT questions for team_00/Eyal)
1. **Display phone = `052-4822842` (U+002D).** It is the existing majority (5 files) and is byte-matchable.
2. **`contact.php`'s U+2011 (non-breaking hyphen) → normalize to U+002D.** The intent (prevent an ugly
   mid-number line-break) is legitimate but must be achieved with **CSS `white-space: nowrap`**, not a
   look-alike character — a homoglyph silently breaks byte-matching, copy-paste, and click-to-call parsers.
   This single character is a direct cause of AC-10's unsatisfiability.
3. **Address apostrophe = U+0027**, per the SSoT. (U+05F3 is arguably better Hebrew typography, but the SSoT
   is the SSoT; one form beats a nicer form. Normalize `seo-head-fallbacks.php`.)
4. **`052-482-2842` (FAQ seed) → `052-4822842`.** Aligns the FAQ to the canon so AC-10 can actually pass.
5. **Machine-readable stays split from display:** `tel:` href = `+972524822842`; schema = `+972-52-482-2842`.
   Display never carries the country code.

### §2.1 The footer — DECIDED, build it
WP-S4-07's AC-10 deferred *"decide D1 NAP footer line per BN-01"*. **team_00 has decided: build it.**
`block-footer-social.php` L64-65 currently renders only:
```php
<p class="ea-cfoot__loc">פרדס חנה · ישראל</p>
```
It must carry the **full canonical NAP** — address + phone (phone as a `tel:` link using the canonical href).
This is standard local-SEO NAP consistency and it is **approved**. Do not re-ask.

## 3. 🔴 Defect found while establishing this canon — `/qr/qr32/` has a WRONG phone

`site/wp-content/mu-plugins/ea-w2-07-qr-content-data.php` **L606**:
```html
<div><strong>לפרטים נוספים מוזמנים ליצור קשר</strong> <strong>052-482284</strong></div>
```
**9 digits — the final `2` is missing.** Canonical is `0524822842` (10).

**Verified live 2026-07-16:** `https://…/qr/qr32/` → **HTTP 200**, renders `052-482284`. Page title:
*"qr32 - נשימה מעגלית"*.

**Impact — this is not cosmetic.** `/qr/qr32/` is reached by **scanning a QR code printed in Eyal's book**.
A reader scans it, wants to contact Eyal, and gets an **unreachable number**. It is the only phone on the
page (`ליצור קשר` appears exactly 1× in the entire seed data). This has been live the whole time.

**Fix:** correct L606 to the canonical display form, then reseed. ⚠ The QR content is **seeded into DB
`post_content`** — no WP-CLI on staging → use the self-guarded `-once` drop-in pattern
(cf. `ea-w2-07b-qr-reseed-once.php`). **Do not hand-edit the DB.**

## 4. Scope — "ובכל מקום שצריך" (team_00)

Normalize every surface onto the canon. Known targets (verify exhaustively during build — this list is a
starting point, not a closed set):

| # | File | Action |
|---|---|---|
| 1 | `template-parts/blocks/block-footer-social.php` L64-65 | **ADD** full NAP (address + `tel:` phone) — §2.1 |
| 2 | `mu-plugins/ea-w2-07-qr-content-data.php` L606 | **FIX** `052-482284` → `052-4822842` + reseed — §3 |
| 3 | `inc/data/ea-faq-seed.json` | `052-482-2842` → `052-4822842`; FAQ-03 Q1 geo answer with canonical address |
| 4 | `template-parts/chapters/parts/contact.php` L88 | U+2011 → U+002D + CSS `nowrap` |
| 5 | `inc/seo-head-fallbacks.php` | address `ב׳` (U+05F3) → `ב'` (U+0027) |
| 6 | `mu-plugins/ea-w2-seo-schema.php` | **unchanged** — it is the SSoT and is already correct |
| 7 | `inc/chapters/defaults/{privacy,accessibility}-defaults.php`, `tpl-chapters-en.php`, `wave2-stage-b.php` | verify against canon |
| — | `inc/data/ea-testimonials-fb.json` | ⚠ **out of scope** — the other numbers there are *testimonial authors'*, not Eyal's. **Do not touch.** |

**Acceptance:** one canonical byte-form per surface class across the repo; AC-10's FAQ ↔ footer byte-match
passes; `/qr/qr32/` renders the correct number live; **zero** occurrences of `052-482284`, `052-482-2842`,
U+2011 phone, or U+05F3 address remain outside the testimonials file.

## 5. Durability — so this never returns

1. This record is the NAP answer. Any spec/verdict/gate that treats NAP as open is **wrong**; cite this.
2. **Structural recommendation for the LOD400 (team_100's call):** the reason this recurred is that the SSoT
   is *declarative but unreadable* — a PHP array literal inside the schema plugin that no other file can
   consume. Consider exposing a tiny accessor (e.g. `ea_nap( 'phone_display' | 'phone_href' | 'address' )`)
   and having the footer/contact/FAQ read **from it**, so a future divergence is impossible rather than
   merely forbidden. Without that, this decision is a document — with it, it is enforced by the code.
