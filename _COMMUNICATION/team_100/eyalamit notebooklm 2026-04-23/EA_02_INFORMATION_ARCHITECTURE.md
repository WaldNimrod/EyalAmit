<!--
package: EyalAmit.co.il NotebookLM Package
file: EA_02_INFORMATION_ARCHITECTURE.md
date: 2026-04-23
audience: designers, SEO partners, content collaborators, developers
-->

# EyalAmit.co.il — Information Architecture and Site Structure

## The Navigation Philosophy

The new site's navigation follows a strict hierarchy: **what Eyal does → how he does it → the specific services → everything else**. This is the reverse of how the old site was organized (which treated all content categories as roughly equal).

The approved navigation structure places **Treatment** and **The Method** as primary destinations — not buried under a "Services" submenu. This was a deliberate strategic decision: the most important thing a visitor needs to understand is that Eyal treats people via didgeridoo and that there is a specific named method (cbDIDG). Only after that framing do specific service options make sense.

---

## Approved Navigation Bar (Final)

The approved primary navigation (from Eyal's production brief, confirmed):

1. **בית** (Home)
2. **טיפול בדיג'רידו** (Didgeridoo Treatment)
3. **השיטה (cbDIDG)** (The Method)
4. **שיעורי דיג'רידו** (Didgeridoo Lessons)
5. **סאונד הילינג** (Sound Healing)
6. **לימוד והכשרה** (Training & Certification)
7. **דיג'רידו וכלים** (Didgeridoo & Instruments)
8. **ספרים** (Books)
9. **תוכן** (Content — Blog + Testimonials)
10. **אייל עמית** (About Eyal)
11. **לתיאום שיחה / צור קשר** (CTA button — schedule a call / contact)

**Note on navigation evolution:** The approved v2.3 SITEMAP had Treatment and Lessons as sub-items under "Services." Eyal's own production brief elevated Treatment and Lessons as top-level primary nav items. This tension was formally documented and the resolution moves toward Eyal's flat structure — validated by the AEO/SEO rationale that primary money pages should be as close to the root as possible.

---

## Full Site Tree

### 1. בית — Home

**Purpose:** The single most important conversion page. Sets the frame for everything else.

**Block sequence (approved by Eyal):**
1. Header (logo + nav + CTA button)
2. Hero — H1 + subtitle + reinforcement line + CTA
3. "מה זה טיפול בדיג'רידו" — explanatory block, first conversion of confusion into understanding
4. "טיפול בדיג'רידו מול סאונד הילינג" — distinction block (critical: many visitors confuse these)
5. וידאו — brief glimpse into the space and working style (not autoplay, never first element)
6. תחומי הפעילות — 4 cards: Treatment / Lessons / Sound Healing / The Method
7. שיטת cbDIDG — brief introduction to the branded method
8. למי זה מתאים — fit criteria / target audience
9. FAQ קצר — 3–5 quick Q&As (preview of the full FAQ page)
10. המלצות — 2–3 testimonials
11. אודות קצר — brief bio paragraph
12. CTA תחתון — closing call to action

**Design constraint:** No expired event dates visible. Events block must auto-archive when dates pass.

---

### 2. טיפול בדיג'רידו — Didgeridoo Treatment (Primary money page)

**Purpose:** The central service page. Most search traffic is expected here.

**Content structure:**
- Hero H1: "משהו בנשימה שלך מבקש תשומת לב"
- Hero subtitle: "דרך הדיג'רידו וליווי אישי תלמדו לעבוד עם הנשימה, להקשיב, לדייק ולהחזיר אותה למקום טבעי, רגוע ומאוזן"
- CTA: "לתיאום שיחת היכרות"
- Introductory clarification: what treatment is (not just passive sound healing — active breath work)
- Personal origin story (Eyal's asthma, the fire, the journey, meeting Mokesh in India)
- Clinical research: BMJ RCT, Maccabi HMO recognition for snoring/sleep apnea
- Detailed FAQ (10 approved Q&As — see EA_04 for full copy)
- Medical disclaimer (full Hebrew legal text)
- Closing CTA

**AEO requirement:** Every major H2 is followed by a 40–100 word answer paragraph in clear, scannable Hebrew. This is the "short answer block" structure that makes content AI-indexable and search-featured.

---

### 3. השיטה (cbDIDG) — The Method

**Purpose:** The intellectual/methodological anchor of the site. Gives the treatment page its authority by explaining the framework behind it.

**H1:** "שיטת cbDIDG – עבודה עם הנשימה באמצעות דיג'רידו"

**Content structure:**
- What the method is (definition + scope)
- How it developed (Eyal's personal research, the master-apprentice tradition with Mokesh)
- Four stages of the process: Acquaintance/Diagnosis → Practice/Learning → Consolidation/Integration → Depth/Internal State
- What makes cbDIDG unique
- Who it is suited for (with specific conditions: stress, snoring, sleep apnea, anxiety, emotional regulation difficulties, people who don't respond well to quiet/passive practices)
- What a session looks like (Pardes Hanna studio, garden setting, blend of didgeridoo practice + breath guidance)
- FAQ section
- CTA

**SEO note:** The brand name "cbDIDG" is unique enough to own in search. The Method page is the primary target for queries like "שיטת נשימה דיג'רידו" and "circular breathing therapy Israel."

---

### 4. שיעורי דיג'רידו — Didgeridoo Lessons

**Purpose:** Service page for the learning/instrument track — separate from the treatment track.

**Visitor profile:** People who want to play didgeridoo as a skill or personal practice, not necessarily seeking therapeutic treatment.

**Content structure:**
- H1 and answer block: what the lessons are, for whom
- Types of learning: individual lessons / group / beginner / ongoing
- What is learned: playing technique, circular breathing, repertoire
- Setting (studio, Pardes Hanna)
- Pricing / booking → external payment link
- FAQ
- CTA

---

### 5. סאונד הילינג — Sound Healing / Didgeridoo Meditation

**Purpose:** The "passive" track — group sessions where Eyal plays and the audience/participants receive the sound. Different from treatment (active) and lessons (skill-building).

**Content structure:**
- H1 and answer block: what sound healing is, what to expect
- Format: group / individual / private event
- Who benefits
- Next event dates (auto-archive when past)
- Booking → external link
- FAQ
- CTA

---

### 6. לימוד והכשרה — Training and Certification for Therapists

**Purpose:** Future-oriented page for practitioners who want to learn the method professionally.

**Current status:** "Coming soon" content — the page exists but the program is not yet launched.

**Content note:** This page must be clearly positioned as professional training — not personal healing. Target audience is therapists, breathwork practitioners, and bodywork professionals seeking to add the cbDIDG method to their practice.

---

### 7. דיג'רידו וכלים — Didgeridoo Instruments and Accessories

**Purpose:** Information + purchase redirect for handmade instruments and accessories.

**Commerce model:** No cart. The page displays product information and links to external payment (Green Invoice / Cheshbonit Yeroka). WooCommerce is explicitly forbidden.

**Content:** Handmade instrument types, materials, photos, pricing → external purchase link.

**Instrument repair and restoration:** Also under this section — service for restoring didgeridoos; booking via external form or WhatsApp.

---

### 8. ספרים — Books (with Muze Publishing)

**Purpose:** Sales and discovery page for Eyal's three published books. Also establishes Eyal as an author/publisher — a secondary but real facet of his creative identity.

**Publishing context:** Eyal founded Muze Publishing (מוזה הוצאה לאור) in 2004. The site positions direct purchase as "farm-direct" buying — supporting the creator directly rather than going through bookstore chains.

**Three books:**
1. **צבע בכחול וזרוק לים** — 38 short stories from South America travel; 10th edition; "freedom, confusion, and the road"
2. **כושי בלאנטיס** — fantasy novel about awakening and leaving the comfortable life; 6th edition
3. **וכתבת** — 46 true stories from Eyal's life; includes QR elements that expand the reading experience

**Bundle:** All three books 150 NIS (vs. 207 NIS individually).

**Purchase model:** External links only. No internal cart.

---

### 9. תוכן — Content Hub (Blog + Testimonials & Media)

**Purpose:** Two SEO assets presented under one navigation umbrella.

**Blog (בלוג דיג'רידו):**
- Primary SEO asset — category archive + individual posts
- Categories: נשימה ודיג'רידו (core) / טיפול וריפוי עצמי / סדנאות וחוויות / חדשות ועדכונים
- Each post: single H1, internal link to at least one service page, unique meta, descriptive image alt text
- 54 existing posts from the old site: audited and categorized as Keep / Merge / Hide

**Testimonials & Media (המלצות ומדיה):**
- Client testimonials (text + possibly audio/video)
- Podcast appearances
- Selected press coverage
- Not a full archive — curated selection

---

### 10. אייל עמית — About

**Purpose:** The human page — gives Eyal's story, credentials, and the personal dimension of the brand.

**What it is NOT:** a full CV or archive of everything Eyal has done. It is the story of how he got to this specific work and why he is the person to trust with your breath.

**Key sub-page: מוקש דהימן — לזכרו** (Mokesh Dahiman — In Memoriam)
- Mokesh was Eyal's primary teacher, who he met in India in 2000
- This is a dedicated memorial page — emotionally significant and also SEO-relevant (Mokesh Dahiman appears in Eyal's backstory and is a documented figure in the circular breathing/didgeridoo tradition)
- Legacy URL must be preserved with 301 redirect from the old site

---

### 11. English Landing Page

**Purpose:** Single English-language entry point for international visitors.

**H1 (locked):** "Didgeridoo healing center - Eyal Amit"

**Meta title:** "Didgeridoo healing center — Eyal Amit | Israel"

**Meta description:** "Circular breathing, didgeridoo lessons, sound healing and therapy with Eyal Amit. Based near Pardes Hanna–Karkur, Israel. Contact for lessons, treatments and workshops."

**Content:** Condensed version of the Hebrew service offering in English. Lists all service categories, location, contact details. Does NOT duplicate the full Hebrew site — it is a gateway page that introduces English speakers to the center and invites contact.

**Technical:** `lang="en"`, LTR direction, `hreflang` linking to Hebrew equivalent pages.

---

### System Pages (Not in Marketing Tree)

- **נגישות** (Accessibility statement) — Israeli law requirement
- **תקנון ותנאי שימוש** (Terms of use)
- **תודה** (Thank-you pages for form submissions)
- **HTML Sitemap** (optional — aids accessibility + crawling)
- **FAQ מלא** (Full FAQ page — standalone page in addition to FAQ blocks on service pages)
- **QR URL pages** — Preserved unchanged (no 301). All QR codes printed on physical materials must continue to work.

---

### Legacy / Not in Primary Navigation

- **Performances archive** — exists, maintained, not promoted
- **Historical press** — exists, maintained, not promoted
- **Shop redirect** — `/shop/` URLs redirect cleanly (no 404s for anyone who bookmarked the old store)

---

## Key IA Decisions

| Decision | Resolution |
|----------|------------|
| Services hub vs. flat nav | Eyal's brief wins: Treatment and Lessons are PRIMARY nav items, not nested under Services |
| "Content" as unified nav item | Yes — merges Blog and Testimonials under one top-level item |
| English page placement | Top-level page, not a sub-section; `lang="en"` |
| Books page | Merged with Muze Publishing — one section, not separate |
| Store / WooCommerce | Not on the new site. All commerce → external payment links |
| Legacy archive | Maintained but not in primary navigation tree |
| QR URLs | Preserved as-is, no redirects |
| Therapist training | Exists as "coming soon" — active page, not hidden |
