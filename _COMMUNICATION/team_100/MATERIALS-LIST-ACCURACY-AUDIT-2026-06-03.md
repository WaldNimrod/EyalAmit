# MATERIALS-LIST ACCURACY AUDIT — team_100 → team_00 — v1.0

**Date:** 2026-06-03 · **Audited list:** `hub/data/materials-needed.json` ("השלמות נדרשות מאייל", generated **2026-05-31**) → rendered `hub/dist/materials-intake.html`
**Method:** every item cross-checked against the **live staging site** + theme code at `main @ 545bfc0`.

## Headline
The list is **materially out of date.** It was generated **2026-05-31 — before** the Track-2 build (2026-06-02/03), which wired the team_35 real shared-assets (portrait, 3 book covers, studio/gallery) and changed the EN CTA to WhatsApp. **5 items are now resolved, 1 is obsolete, 4 need reclassification, 13 remain accurate.** Sending it to Eyal as-is would ask for things already done (notably the 3 book covers, the portrait, and 2 purchase links) and ask him to confirm a CTA that no longer exists.

## Per-item verdict (evidence-based)

| Code | List says | Live state (evidence) | Verdict |
|---|---|---|---|
| **WA** | confirm WhatsApp +972 52-482-2842 | Number now used site-wide incl. /en CTAs; matches code `EA_WAVE2_WHATSAPP_E164=972524822842` | **ACCURATE** (confirm — now more relevant) |
| A1 | hero media ×4 service pages | All 4 still `ea-hero__gradient-bg` (no image/video) | **ACCURATE** (needed) |
| A2 | studio/space photos (Pardes Hanna, tipi) | Only India/Sinai gallery imgs exist; no Pardes-Hanna studio/tipi | **ACCURATE** (needed) |
| A3 | testimonial face photos (optional) | Sand-circle placeholders kept | **ACCURATE** (optional) |
| A4 | didgeridoo ambient audio | Not provided; sound toggle silent | **ACCURATE** (needed) |
| **B1** | portrait — **"חוסם/blocking"** | **Real portrait wired** (`eyal-portrait-hero.jpg`, 566×1024, live on /about). But it's the **preview** crop (manifest: "Final swap → high-res studio portrait") | **RECLASSIFY** → not blocking; optional hi-res upgrade |
| B2 | About gallery: lead 16:7 + 3×4:3 — "חוסם" | Lead `hero-wide-studio.jpg` **wired**; secondary cells still placeholder | **PARTIAL** → reduce to "3 secondary images"; not blocking |
| **B3** | Mokesh photo — "חוסם/blocking" | No Mokesh asset in package; moksha bio still placeholder | **ACCURATE** (blocking, needed) |
| B4 | press logos (optional) | Press page text-only | **ACCURATE** (optional) |
| **C1** | create CF7 form — "חוסם/blocking" | `/contact` shows the **fallback note** ("…יוגדר לאחר יצירת טופס CF7"); **0 real CF7 fields** (form_id still 0). Code wiring ready; form not created | **ACCURATE** (blocking — Eyal/admin action) |
| **C2** | 5 empty FAQ categories | `/faq` has **0** "בהכנה"/empty markers; categories populated | **RESOLVED** → remove (spot-check the 5 shop categories) |
| C3 | direct contact details (optional) | Decision still open | **ACCURATE** (optional/decision) |
| D1 | featured images ×12 posts | Blog still gradient placeholders | **ACCURATE** (needed) |
| **D2** | author name eyaladmin→Eyal | Blog shows **"אייל עמית"** (0× eyaladmin); fixed by `ea-w2-10-author-displayname-once.php` | **RESOLVED** → remove |
| **E1** | 3 book covers — **"חוסם/blocking"** | **Real covers wired & live** on /books + all 3 details (HTTP 200) | **RESOLVED** → remove |
| E2 | per-book galleries (~5 each) | 1 gallery image wired; rest placeholder | **PARTIAL** → reduce to "~4 more per book" |
| E3 | shop product photos | Placeholders (graceful gaps) | **ACCURATE** (needed) |
| E4 | Green-Invoice shop purchase links | Shop CTAs → contact default | **ACCURATE** (needed/decision) |
| **E5** | buy links for kushi + tsva | **Both wired** (Mendele/Morning) — 4 external buy links on each detail | **RESOLVED** → remove |
| **F1** | confirm EN CTA = `/contact?lang=en` | **CTA changed to WhatsApp** (team_00 DECISION 2026-06-03); 0× `/contact?lang=en` on /en | **OBSOLETE** → rephrase to "confirm EN CTA = WhatsApp" |
| F2 | confirm EN testimonials w/o photos (optional) | Text-only by design | **ACCURATE** (optional) |
| **G1** | hero video + poster — "חוסם" | Home hero still gradient; blocked on asset | **ACCURATE** (blocking, needed) |

## Tally
- **RESOLVED — remove (5):** C2, D2, E1, E5 + (F1 obsolete).
- **RECLASSIFY / reduce scope (3):** B1 (blocking→optional hi-res), B2 (→3 secondary imgs), E2 (→remaining gallery imgs).
- **STILL ACCURATE (13):** WA, A1, A2, A3, A4, B3, B4, C1, C3, D1, E3, E4, F2, G1.

## Genuinely-blocking items still outstanding (the real short list for Eyal)
**B3** (Mokesh photo), **C1** (create the CF7 form in wp-admin), **G1** (home hero video + poster). Everything else still-needed is medium/optional polish (service hero media, studio photos, blog featured images, shop product photos + links, audio, press logos).

## Recommendation
Regenerate `hub/data/materials-needed.json` (and re-render `hub/dist/materials-intake.html`) to the corrected state before Eyal acts on it — otherwise he'll supply already-live covers/portrait/links and confirm a dead CTA. I can produce the corrected JSON on your go.
