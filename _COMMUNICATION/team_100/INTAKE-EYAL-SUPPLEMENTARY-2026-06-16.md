# INTAKE + ANALYSIS — Eyal supplementary materials (2026-06-16)

**Author:** team_100 · **Date:** 2026-06-16 · **Source:** Eyal (via team_00) · **Status:** ingested + analyzed

## 1. What was received (4 items)
| # | Item | Location in repo / value |
|---|---|---|
| A | **Mokesh full memorial doc** — "מוקש דהימן – מאסטר דיג'רידו – דף להנצחת זכרו ופועלו 1950-2020" | `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/מוקש דהימן – …1950-2020.docx` (+ copy under `מוקש דהימן/`). Drive: `docs.google.com/document/d/14YpaQMmS_zfJ-oFqp5iBhw08V0ChuR8h` |
| B | **Full FB testimonials doc** — "ממליצים מהפייסבוק" | `docs/.../from-eyal/תוכן לאתר 25.5.26/ממליצים מהפייסבוק.docx`. Drive: `docs.google.com/document/d/1ki6eWeZlf5hlmryLuoA8CiyO4s02wLip` |
| C | **GA4 measurement ID** | `G-MRXESK7QJF` → wired into `hub/data/analytics-config.json` |
| D | **WhatsApp number** | `+972524822842` |

## 2. Analysis

### 2.A Mokesh memorial — FULL page (72 paragraphs) ⭐ major
This is the **complete memorial page**, not the fragment we built from. It opens with **"מי היה מוקש דהימן?"** (the
exact I3 bio placeholder), confirms **1950–2020** + death **11.10.2020**, and runs a full biography in clearly-titled
sections: *מי היה · היכרותו עם הדיג'רידו (סיפור הביטלס/רישיקש) · בית המלאכה ברישיקש · Dream-Time · קוטלי (הסטודיו החדש) ·
הגשמת החלום · תפנית חדה (קורונה 2020) · פרידה · ומה היום · דברי הספד*. Family named (אשתו אניטה, 4 בנים, בת ונכדה).
- **Supersedes** `ומה היום.docx` (which is just one section — §"ומה היום" — of this doc; our 16-E verbatim text matches it).
- **References a 60-minute documentary** ("MUKESH - The Art of Shanti Living") with a **promo clip to embed at the page bottom** (doc ¶41) + a dedicated FB page (¶42).
- **Photo signals:** Eyal + his brother filmed/photographed Mokesh extensively with permission (¶39); a portrait "hangs on our wall" (¶34). Plus legacy-media mirror has Mokesh photos (`_COMMUNICATION/team_40/legacy-media-index-50…/mirror/2021/10/…rishikesh…`, `2024/08/mukesh-dhiman-…`).
- **⇒ Action:** the mokesh page should be **rebuilt** from this full doc (a much richer page than the current short one). The bio + dates placeholders (I3/I4) are now resolved verbatim.

### 2.B FB testimonials — 48 testimonials in 3 categories ⭐ major
Organized exactly to our service pages: **טיפול בדיג'רידו · סאונד הילינג · שיעורי נגינה בדיג'רידו**, **48 testimonials**
total (each = name + FB link + full quote). Includes everyone already in the carousel (חיה עזריה, שירי אלקבץ, נוית צוף
שטראוס, ירון, לירן, שרון, רתם…) **plus dozens more** (רותי שליט, ענת קרמנר, אלכס פסטרנק, אלון גרזון רז, גלית מילר…).
- **⇒ Action:** resolves I1 (more testimonials). Carousel can expand; per-category testimonials can feed the matching
  service page. Quotes are long → curate snippets per testimonial.

### 2.C GA4 — wired (Clarity still pending)
`G-MRXESK7QJF` recorded in `hub/data/analytics-config.json`. **Caveat:** `ea_wave2_print_analytics_head()` gates on
**both** GA4 *and* Clarity being present — to fire GA4 before Clarity arrives, split that pending-check (M5 SEO/analytics WP).

### 2.D WhatsApp — confirmed (already accurate)
`+972524822842` == the theme constant `EA_WAVE2_WHATSAPP_E164 = '972524822842'`. No change needed; confirmed correct.

## 3. Summary — received / accurate / unblocked / still-open / unclear

**✅ Now UNBLOCKED (was Eyal-dependent):**
- Mokesh **bio intro** (I3) + **dates 1950–2020** (I4) — fully provided.
- **More testimonials** (I1) — 48 delivered, categorized.
- **GA4 analytics** — ID received + recorded.

**✔ Verified accurate (matches what we built):**
- WhatsApp number; the "ומה היום" mokesh text (our 16-E verbatim == this doc's §ומה היום); the existing carousel names are a subset of the 48.

**🟡 STILL OPEN / pending from Eyal:**
- **Clarity** project_id (only GA4 was sent). Eyal struggles with the setup → a step-by-step **PDF guide** was prepared for him: `docs/.../to-eyal/2026-06-19--clarity-setup-guide/Clarity-Setup-Guide-Eyal-HE-2026-06-19.pdf` (team_00 to send).
- ~~**Mokesh page photos**~~ **RESOLVED 2026-06-16:** use the SAME 19 photos as the original page, SAME order; + add the 4 FB post embeds at the bottom → captured in `MOKESH-MEDIA-CAPTURE-2026-06-16.md`.
- **The documentary video** — link PROVIDED 2026-06-16: `https://youtu.be/kf4NKSdYi9E` = *"MUKESH - The Art of Shanti Living | Official Trailer"* (channel Kuthli Studio), verified via oEmbed. NOTE: it is the **trailer/promo** (matches the doc's ¶41 "embed the promo clip"), not the full ~60-min film — open whether a full-film link also exists.
- ~~**Studio address + hours**~~ **RESOLVED 2026-06-16:** name + עמל 8 ב' פרדס חנה + Sun–Thu 09–19 / Fri 09–14 / by appointment, **Sat closed** → SSoT `BUSINESS-NAP-AND-HOURS-2026-06-16.md` (contact page address was MISSING — now a build task T8). *(Saturday/Shabbat: confirmed closed 2026-06-19.)*

**❓ UNCLEAR / decisions for team_00:**
1. **Mokesh rebuild scope** — rebuild the page from the full memorial doc (much richer; a new 16-E-v2 build), verbatim? *(recommend yes)*
2. **Brand spelling** — Eyal's own doc uses **both** `jungle vibes` (¶64) and `jungel vibes` (¶75). Recommend standardizing to **`Jungle Vibes`** (the correct English) across the site. *(confirm)*
3. **Testimonials curation** — feature-set + snippet length for the carousel, and whether to route per-category testimonials onto the matching service pages.
4. **Documentary video** — embed the promo at the mokesh page bottom (need the file/link)?

## 4. Roadmap impact
Feeds the **M5/M7 Eyal-dependent completions WP** (`S004-P001-WP004`): I1/I3/I4 close; a **mokesh page rebuild** (richer
memorial + video + photos) becomes a concrete build item; analytics wiring folds into the SEO/analytics WP. Net: the
launch-blocking Eyal set is now mostly satisfied — remaining: Clarity ID, address/hours, photo + video selection.
