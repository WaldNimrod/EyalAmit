# Composition Notes — WP-W2-10-C (Conversion cluster)

**Team:** team_35 (Design Studio · claude-design) · **Stage:** S1 hi-fi mockup · **Date:** 2026-05-31
**Routes:** `/contact` (`tpl-contact.php`) · `/faq` (`tpl-faq.php`)
**Rule:** composition-only — every class below is reused **verbatim** from D-14 `ea-atoms.css` / `ea-tokens.css`. No new atoms, no new token values (AC-U1).

---

## A. `/contact` — contact-form archetype (`conversion-contact.html`)

Block order (top → bottom):

1. **atom-nav-topnav** (`.ea-topnav`) — fixed nav, `aria-current="page"` on צור קשר. Mirrors `block-topnav`.
2. **ea-contact-page-intro** — the verbatim intro from `tpl-contact.php` lines 15–20: `<h1>צור קשר</h1>` + sub `ניתן ליצור קשר לתיאום שיחת היכרות…`. Kept as the single `<h1>` (one per page).
3. **atom-interaction-contact-form** (`.ea-contact-section` → `.ea-contact-form`) — left column. This is the composition payload: the template calls `ea_wave2_render_contact_form()` which on staging emits **no form (CF7 `form_id=0`)**. The mockup composes the *intended* accessible form so Eyal signs off the layout, not the wiring.
   - Field order: שם מלא (required) → טלפון (required, `type=tel`) → דוא״ל (optional, `type=email`) → נושא הפנייה (`select`, options align to service slugs) → הודעה (required `textarea`) → submit `.ea-cta-pill.ea-cta-pill--primary`.
   - Rationale for order: identity → reachable channel → optional channel → routing → free text. Phone before email because the primary conversion is a callback / WhatsApp, not email.
4. **atom-interaction-whatsapp-cta** — right column, rendered as the **A/B variant pair** the spec requires (per WP-W2-01 `ea-ab-testing`): `data-ab-experiment="contact_whatsapp_cta"` with variant A (`דברו איתי בוואטסאפ`) and variant B (`לתיאום שיחת היכרות בוואטסאפ`, `hidden`). Trust signals (`.ea-trust`) sit below: 3 real reassurances drawn from FAQ copy (שיחת היכרות ללא התחייבות / ליווי אישי אחד על אחד / מענה תוך יום עסקים).
5. **atom-interaction-whatsapp-cta (float variant)** (`.ea-whatsapp-float`) — persistent fixed CTA, `inset-inline-start` (RTL-correct bottom-left).
6. **atom-data-display-footer-social** (`.ea-footer`) — mirrors `block-footer-social`.

### Form accessibility (AC-U3 target)
- Every control has an explicit `<label for>`; required fields carry `required` + `aria-required="true"`.
- Error spans are pre-wired (`aria-describedby` → `#cf-*-err`, `hidden` until invalid) with `aria-invalid` styling hook (`--ea-brick`).
- `novalidate` on the form + visible `*` marked `aria-hidden` (the requirement is conveyed in the `.ea-sr-only` form-intro and `aria-required`).
- The CF7-gap note is `role="note"` and explicitly flagged "not for client display".

---

## B. `/faq` — faq-accordion archetype (`conversion-faq.html`)

Block order:

1. **atom-nav-topnav** — `aria-current="page"` on שאלות נפוצות.
2. **ea-faq-page-intro** — verbatim `<h1>שאלות נפוצות (FAQ)</h1>` from `tpl-faq.php` line 15.
3. **faq-filter** (`.ea-faq-filter`) — `position:sticky` under the nav. A `<select id="faq-topic">` whose `<option value>` slugs are **verbatim** from the live control: `all, treatment, lessons, sound-healing, method, didgeridoos, bags, stands-storage, stand-floor, repair, general`. `aria-controls="faq-list"`; live region `#faq-count` announces result count (AC-C3 URL-state + filter).
4. **atom-content-faq-item** (`.ea-faq-item`) — grouped under `<h2>` category headings. **Heading hierarchy:** page `h1` → category `h2` → question `h3` (the trigger button is wrapped in `<h3>` so each Q is a navigable heading). Real Q&A loaded for the 5 categories that have published answers on staging; the 5 empty categories (bags / stands-storage / stand-floor / repair / general) are kept as `hidden` groups with a "תוכן בהכנה" note so the filter list stays at parity with the live `<select>`.

### Accordion accessibility (deviation from D-14, justified)
- D-14 `atom-content-faq-item` uses native `<details>/<summary>`. For this S1 the trigger is a **`<button aria-expanded>` + `role="region"` answer panel** so the expanded/collapsed state is explicit and axe-auditable. Visual styling (`.ea-faq-item__trigger`, `__question`, `__icon` rotate) maps 1:1 onto the D-14 summary styling — **no new token values introduced**. team_10 may revert to `<details>` at S3 if preferred; layout is identical.
- Filter writes `?topic=<slug>` via `history.replaceState` and reads it on load (AC-C3 "URL state").

---

## C. RTL / contrast / motion

- `dir="rtl" lang="he"` on `<html>`; all insets use logical props (`inset-inline-start`, `margin-inline`) per D-14.
- Body text uses `--ea-text-body:#5A3826` on `--ea-bg/--ea-bg-alt` (the AA-corrected token, per ea-tokens.css comment) — not raw `--ea-earth`.
- Motion shipped OFF in both mockups (breathe/fade animations omitted) for a clean a11y/perf audit; D-14 `ea-animations.css` is the SSoT for the live motion layer at build (S3+).

---

## D. D-14 atom IDs used (cite, never redefine)
`atom-nav-topnav` · `atom-interaction-contact-form` · `atom-interaction-whatsapp-cta` (inline pair + float) · `atom-feedback-cta-pill` · `atom-content-faq-item` · faq-filter select · `atom-data-display-footer-social` · layout helpers (`.ea-container`, `.ea-sr-only`, `.ea-skiplink`).
