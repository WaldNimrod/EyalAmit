---
verdict: PASS
wp: WP-W2-04
date: 2026-05-29
gate: L-GATE_BUILD
validator_engine: cursor-composer
branch: feature/w2-04-services
head_at_qa: 30b90fd
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_50/MANDATE-TEAM50-W2-04-L-GATE-BUILD-2026-05-29.md
spec_ref: _aos/work_packages/S002/WP-W2-04/LOD400_spec.md
builder_report: _COMMUNICATION/team_100/W2-04-COMPLETION-REPORT-2026-05-29.md
status: ISSUED
---

# PREVERDICT — WP-W2-04 L-GATE_BUILD

## Engine declaration (IR#1)

| Field | Value |
|-------|-------|
| Builder | team_10 / **Claude** |
| Validator | **cursor-composer** (non-Claude) ✓ |
| Cross-engine | **SATISFIED** |

---

## Overall verdict

**PASS** — 6/6 AC pass on live staging (independently verified; builder report used only as index, not as evidence).

---

## AC results

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| **AC-01** | `/sound-healing`, `/lessons` → HTTP 200 | **PASS** | Cache-busted curl: `code=200 redirect=` both paths |
| **AC-02** | H1 + body 1:1 with 25.5.26 sources (normalization rule) | **PASS** | Spot-check below |
| **AC-03** | FAQ view-only, single category, zero leakage; `/faq` regression | **PASS** | Per-page FAQ counts below; `/faq` filter intact |
| **AC-04** | Testimonials Top-5 accordion: text + placeholder image + FB link | **PASS** | 5 accordions/page; 5 FB links/page |
| **AC-05** | A/B CTA: `[data-ea-ab]`, form + WA targets, sessionStorage variant, GA4 | **PASS** | Markup + JS source + enqueue verified |
| **AC-06** | `validate_aos.sh` 0 FAIL; mobile ≤600px; no raw hex | **PASS** | 30 PASS / 0 FAIL; CSS rules present; 0 hex in W2-04 CSS/PHP |

---

## AC-01 — HTTP

```bash
BASE="http://eyalamit-co-il-2026.s887.upress.link"; CB=$(date +%s)$RANDOM
for p in /sound-healing /lessons; do
  curl -s -o /dev/null -w "code=%{http_code} redirect=%{redirect_url} path=$p\n" -L "$BASE$p/?cb=$CB"
done
```

**Output (team_50, 2026-05-29):**
```
code=200 redirect= path=/sound-healing
code=200 redirect= path=/lessons
```

Deployed theme: `style.css` **Version 1.4.3**; `w2-04-service.css?ver=1.4.3` enqueued on both pages.

---

## AC-02 — Content spot-check (normalization rule)

Sources: `סאונדהילינג/sound_healing_final.md`, `שיעורי נגינה/lesons.md`.

| Page | Check | Result |
|------|-------|--------|
| `/sound-healing/` | H1 | **PASS** — `סאונד הילינג פרטי בדיג'רידו - מסע אישי בצליל ותדר ליחידים ולזוגות` |
| `/sound-healing/` | Intro ¶1 | **PASS** — opens `סאונד הילינג בדיג'רידו הוא מפגש פרטי…` |
| `/sound-healing/` | Intro ¶2 | **PASS** — `בניגוד לרוב מפגשי הסאונד הילינג המתקיימים בקבוצות…` |
| `/sound-healing/` | Intro ¶4 (closing) | **PASS** — `מפגש סאונד הילינג אינטימי, עמוק ועוצמתי…` |
| `/lessons/` | H1 | **PASS** — `שיעורי נגינה בדיג'רידו לפי שיטת cbDIDG של אייל עמית` |
| `/lessons/` | Body ¶ | **PASS** — `ללמוד לנגן בדיג'רידו…` / `ג'אגלינג של מערכת הנשימה` (slang preserved) |
| `/lessons/` | Hero sub | **PASS** — `השיעורים מתקיימים במתכונת פרטית, בליווי אישי של אייל עמית` |

**Flags (non-blocking, per mandate):** internal slugs normalized (`/method`, `/treatment`); pregnancy FAQ blog link absent in canonical dataset (builder flag accepted).

---

## AC-03 — FAQ category isolation

Cache-busted HTML parse of `data-block="faq-list"` sections:

| Page | Expected category | `<details>` count | Categories in block | Filter select/chips |
|------|-------------------|-------------------|---------------------|---------------------|
| `/sound-healing/` | `sound-healing` | **8** | `sound-healing` only (wrapper + 8 items) | **None** — `ea-faq-list--view-only`, no `id="ea-faq-cat"` |
| `/lessons/` | `lessons` | **8** | `lessons` only | **None** — view-only |
| `/faq/` (regression) | all categories | **50** items | `#ea-faq-cat` select with 5 category options | **PASS** — full filterable list unchanged |

Zero items from `treatment`, `method`, or `general` on service pages.

---

## AC-04 — Testimonials

| Page | Accordions | Avatar placeholders | FB links (in testimonials block) |
|------|------------|---------------------|----------------------------------|
| `/sound-healing/` | 5 | 5 | 5 (e.g. `facebook.com/share/p/1DrzXzvXjA/`) |
| `/lessons/` | 5 | 5 | 5 (e.g. `facebook.com/share/p/1E7ndvYyrp/`) |

Each accordion: name in summary, quote text in body, FB anchor with `target="_blank"`. Placeholder images = declared W2-07 carry-forward (**acceptable**).

---

## AC-05 — CTA A/B

**Markup snippet (both pages — `/sound-healing/` shown):**
```html
<div class="ea-cta-ab" data-ea-ab data-ea-page="sound-healing">
  <a class="ea-cta-pill ea-cta-pill--primary ea-cta-ab__form"
     href="…/contact?subject=sound-healing" data-ea-ab-form>לתיאום שיחת היכרות</a>
  <a class="ea-cta-pill ea-cta-pill--whatsapp ea-cta-ab__wa"
     href="https://wa.me/972524822842" target="_blank" rel="noopener noreferrer"
     data-ea-ab-wa>שליחת הודעה ב‑WhatsApp</a>
</div>
```

| Check | Result |
|-------|--------|
| `[data-ea-ab]` block present | ✓ both pages |
| Form → `/contact?subject=<slug>` | ✓ `sound-healing` / `lessons` |
| WhatsApp → `https://wa.me/972524822842` | ✓ |
| `ea-ab-testing.js` enqueued | ✓ `?ver=1.4.3` |
| Canonical key `eyal_cta_variant` | ✓ `sessionStorage` in JS |
| Variants `form_only` / `dual` / `wa_only` → A/B/C | ✓ toggles form/WA visibility |
| GA4 `cta_click` with `variant_label` + `page` | ✓ wired in `ea-ab-testing.js` |

Note: three variants are **runtime-assigned** (W2-01 canonical pattern) — both CTA targets exist in markup; JS hides one or both per variant. Not three separate markup blocks.

---

## AC-06 — validate_aos + mobile + tokens

**validate_aos.sh tail:**
```
RESULT: 30 PASS / 18 SKIP / 0 FAIL
L-GATE_BUILD EXIT CRITERION: SATISFIED
```

| Check | Result |
|-------|--------|
| Raw hex in `w2-04-service.css` | **0 matches** |
| Raw hex in `wave2-w2-04.php` / content PHP | **0 matches** |
| Hero clamp | `font-size: clamp(1.8rem, 4.5vw, 3rem)` in `w2-04-service.css` |
| CTA stack ≤600px | `@media (max-width: 600px) { .ea-cta-ab { flex-direction: column; } }` |
| Body class | `ea-wave2-shell` on both pages |

---

## Carry-forwards (informational — not scored FAIL)

1. Testimonial images = grey placeholders (W2-07).
2. `/blog/pregnancy-didgeridoo` link in source `.md` not in canonical FAQ dataset — pending team_00.
3. Internal route slugs normalized to live paths (`/method`, `/treatment`).

---

## Recommendation

| Verdict | Route |
|---------|-------|
| **PASS** (6/6 AC) | Advance to **L-GATE_VALIDATE (team_190, Codex)** |

---

*team_50 — L-GATE_BUILD — cursor-composer (non-Claude) — 2026-05-29*
