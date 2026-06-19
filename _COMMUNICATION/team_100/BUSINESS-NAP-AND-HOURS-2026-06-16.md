# Business NAP + Hours — canonical SSoT (2026-06-16)

**Source:** Eyal via team_00, 2026-06-16. **Consumers:** Contact page · `LocalBusiness` JSON-LD · Google Business
Profile · the SEO/GEO plan (local-SEO pillar). This is the single source of truth for the business entity.

## Raw (verbatim from Eyal)
- **שעות פתיחה:** כל יום מ‑9:00‑19:00 · שישי 9:00‑14:00 · **ביקור בתיאום מראש בלבד**.
- **כתובת העסק** (חסרה היום בעמוד «צור קשר» — להוסיף): **המרכז לטיפול בנשימה באמצעות דיג'רידו, רח' עמל 8 ב' פרדס חנה**.

## Structured NAP
| Field | Value |
|---|---|
| **Name (business)** | המרכז לטיפול בנשימה באמצעות דיג'רידו *(The Center for Breath Therapy via Didgeridoo)* |
| **Street** | עמל 8 ב' (Amal St. 8B) |
| **City** | פרדס חנה (Pardes Hanna-Karkur) |
| **Country** | IL |
| **Phone / WhatsApp** | +972 52-482-2842 (== theme `EA_WAVE2_WHATSAPP_E164 = 972524822842`) |
| **Hours** | Sun–Thu 09:00–19:00 · Fri 09:00–14:00 · **Sat (Shabbat) CLOSED** · **by appointment only** |

## Ready LocalBusiness JSON-LD (drop-in; confirm @type + the two flags below)
```json
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "המרכז לטיפול בנשימה באמצעות דיג'רידו",
  "telephone": "+972-52-482-2842",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "עמל 8 ב'",
    "addressLocality": "פרדס חנה-כרכור",
    "addressCountry": "IL"
  },
  "openingHoursSpecification": [
    { "@type": "OpeningHoursSpecification", "dayOfWeek": ["Sunday","Monday","Tuesday","Wednesday","Thursday"], "opens": "09:00", "closes": "19:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Friday", "opens": "09:00", "closes": "14:00" }
  ],
  "url": "https://www.eyalamit.co.il/"
}
```

## Open / confirm (do NOT invent — surfaced)
1. ~~**Saturday (Shabbat)**~~ **RESOLVED 2026-06-19 (Nimrod): closed on Saturday.** Hours are Sun–Thu 09:00–19:00, Fri 09:00–14:00, **Sat closed** (omit Saturday from `openingHoursSpecification` = closed; the JSON-LD above is correct as-is).
2. **`@type` subtype:** the SEO/GEO local-SEO research (running) will recommend the best subtype (e.g. `HealthAndBeautyBusiness` vs a generic `LocalBusiness`/`Physician`-adjacent). Default to `LocalBusiness` until then.
3. **"By appointment only":** not a schema field — surface in the contact-page copy and the GBP attributes; consider `OpeningHoursSpecification` notes / a visible note.
4. **No postal code / geo lat-long** supplied — add for GBP + `geo` schema when available.

## Build tasks this unblocks
- **Contact page:** add the business name + address (currently MISSING — Eyal flagged it) + the hours block.
- **LocalBusiness JSON-LD:** add site-wide (or on contact + home) per the SEO/GEO plan.
- **Footer / topnav:** consider surfacing address + hours (NAP consistency aids local SEO).
