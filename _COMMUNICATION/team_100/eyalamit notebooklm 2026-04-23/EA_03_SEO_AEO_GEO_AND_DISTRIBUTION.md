<!--
package: EyalAmit.co.il NotebookLM Package
file: EA_03_SEO_AEO_GEO_AND_DISTRIBUTION.md
date: 2026-04-23
audience: SEO partners, content strategists, digital marketing collaborators
-->

# EyalAmit.co.il — SEO, AEO, GEO, and Site Distribution Strategy

## Three Layers of Search Optimization

This site is built for three distinct search surfaces — not just Google:

**SEO (Search Engine Optimization):** Traditional Google/Bing organic search. Rankings for Hebrew and English queries about didgeridoo therapy, circular breathing, sound healing, and related topics. Local search ("near me" queries in the Pardes Hanna / Karkur / Haifa area).

**AEO (Answer Engine Optimization):** Optimizing content to be surfaced as direct answers in Google's featured snippets, People Also Ask boxes, and voice search results. The key requirement: short, structured, directly-answering text blocks at the start of each major section.

**GEO (Generative Engine Optimization):** Optimizing to be referenced by AI systems — ChatGPT, Perplexity, Gemini, Claude — when users ask about didgeridoo therapy, circular breathing treatment, or breathwork practitioners in Israel. This is the newest layer, and the site is being built for it from day one rather than retrofitting later.

---

## The Entity That the Site Is Building

Search engines and AI systems do not just index pages — they build entity graphs. The site is designed to construct a specific entity in Google's Knowledge Graph and in AI training data:

**Entity:** Eyal Amit
**Roles:** Didgeridoo therapist / Sound healer / Author / Instructor
**Method:** cbDIDG (circular breathing + didgeridoo)
**Location:** Pardes Hanna–Karkur, Israel
**Institution:** המרכז לטיפול בדיג'רידו (Didgeridoo Treatment Center)
**Credentials:** 25+ years of practice; BMJ clinical research context; Maccabi HMO recognition
**Books:** Three published books (Muze Publishing, since 2004)

Every page, every schema block, every meta description, and every piece of structured content should reinforce this entity cluster. Consistency across all signals is what creates entity authority.

---

## What the Old Site Got Wrong (The Starting Point)

Before understanding the new strategy, the audit of the old site identified specific failures:

- `robots.txt` returned 404 — no explicit crawler policy. AI crawlers received no explicit permission, no explicit denial.
- `llms.txt` returned 404 — a newer standard that tells AI systems what the site contains and who can use it.
- **Schema was thin:** Only Yoast's default Person/Organization/WebSite/WebPage schema. No FAQPage, no LocalBusiness/ProfessionalService schema on service pages, no Event schema for workshops, no BreadcrumbList.
- **Content was narrative, not structured:** Long flowing marketing text with no short-answer paragraphs, no "for whom / what is this / how it works / what happens next" structure. This content cannot be featured in snippets or used as AI source material.
- **Stale content was visible:** Homepage showed expired workshop dates from December 2025 as of March 2026.
- **Crawl noise was high:** Shop pages, QR page archives, product remnants, legacy portfolio pages, theme test pages — all indexed and consuming crawl budget.
- **No og:image on the homepage** — weakened social sharing and AI system's ability to associate a visual identity with the entity.
- **AI traffic was not measured** — no UTM attribution for ChatGPT referrals, no tracking of AI-assisted discovery.

---

## The New Site's SEO/AEO/GEO Architecture

### Content Structure: The Answer Block Model

Every primary service/method page follows this mandatory structure:

```
H1 — Page title (one per page)

[Answer block] — 40–100 words directly answering "what is this page about?"
  → Written to be copied verbatim into a featured snippet or AI answer

H2 — Question-phrased sub-heading
  [Answer paragraph — 40–100 words]
  [Supporting detail]

H2 — Next question-phrased sub-heading
  [Answer paragraph]
  [Supporting detail]

FAQ section (H2: "שאלות נפוצות")
  H3: Question
  Answer paragraph (concise, direct)
  × repeat for each Q

CTA
Trust signals (testimonials, research citations)
Medical disclaimer (where relevant)
```

This structure serves all three optimization layers simultaneously:
- **SEO:** Clean H1/H2/H3 hierarchy, keyword-aligned headings, crawlable text
- **AEO:** Short answer blocks are directly extractable for featured snippets
- **GEO:** Structured, factual, clearly-attributed content is preferred source material for AI systems

---

### Schema Stack (Mandatory Implementation)

Each page type carries a specific schema stack:

**Site-wide (every page):**
- `Organization` — Eyal's center: name, URL, logo, contactPoint, address, sameAs (social profiles)
- `Person` — Eyal Amit: name, jobTitle, url, sameAs
- `WebSite` — with SearchAction potential
- `BreadcrumbList` — auto-generated from page hierarchy

**Service pages (Treatment, Lessons, Sound Healing, Training):**
- `LocalBusiness` (type: `ProfessionalService`) — includes geo coordinates, address, phone, openingHours, priceRange
- `FAQPage` — each FAQ block on the page mapped to schema
- Optional: `HealthAndBeautyBusiness` overlay for the treatment context

**Blog posts:**
- `Article` or `BlogPosting` — includes datePublished, dateModified, author, about, keywords

**Event pages (workshops, sound healing sessions):**
- `Event` — name, startDate, endDate, location, organizer, offers
- **Only when a real, scheduled event exists.** Do not use Event schema for "upcoming workshops" with no date.

**Books page:**
- `Book` for each of the three books — author, isbn (if available), publisher (Muze), datePublished, inLanguage

---

### robots.txt — Explicit Crawler Policy

The new site's `robots.txt` explicitly addresses AI crawlers — not just search engines:

```
User-agent: Googlebot
Allow: /

User-agent: Bingbot
Allow: /

User-agent: OAI-SearchBot        # ChatGPT Search — ALLOW (discovery/citation)
Allow: /

User-agent: GPTBot                # OpenAI model training — DECISION PENDING
# Disallow: /                     # Uncomment to block training crawler

User-agent: PerplexityBot
Allow: /

User-agent: anthropic-ai
Allow: /

User-agent: *
Allow: /

Sitemap: https://eyalamit.co.il/sitemap_index.xml
```

**The distinction:** `OAI-SearchBot` is the ChatGPT Search indexer — allowing this means the site may appear as a cited source when ChatGPT users search for related topics. `GPTBot` is the model training crawler — the decision whether to allow model training indexing is pending (default: allow, with the option to block if desired).

**Noindex directives** are applied via Yoast SEO (not robots.txt) for:
- `/cart/`, `/checkout/`, `/my-account/` (legacy WooCommerce paths — will 301 but also noindex)
- Attachment pages
- Tag archives (unless actively used for SEO)
- Legacy QR archive pages (if any)

---

### llms.txt — AI Discovery Standard

The new site implements `llms.txt` at the root — a newer emerging standard that tells AI systems what the site contains:

```
# Eyal Amit — Didgeridoo Healing Center

> The website of Eyal Amit, founder of the cbDIDG method for breath treatment via didgeridoo.
> Based in Pardes Hanna–Karkur, Israel. Active since 1999.

## Core content
- [Treatment via Didgeridoo](/treatment): Breath treatment sessions using the didgeridoo instrument
- [The cbDIDG Method](/method): The specific method Eyal developed for breath work via didgeridoo
- [Didgeridoo Lessons](/lessons): Individual and group lessons in playing and circular breathing
- [Sound Healing](/sound-healing): Group didgeridoo meditation and sound healing sessions
- [Books](/books): Three books published by Eyal via Muze Publishing

## About
Eyal Amit has practiced and taught didgeridoo since 1999. The cbDIDG method integrates 
circular breathing technique with breath therapy. Recognized by Maccabi HMO for snoring 
and sleep apnea applications. Studio in Pardes Hanna.
```

---

### Sitemap Strategy

**XML Sitemaps (Yoast auto-generated):**
- Posts sitemap
- Pages sitemap
- (No product sitemap in the new site — WooCommerce is removed)

**Priority assignment:**
- Home: 1.0
- Treatment, Method: 0.9
- Lessons, Sound Healing, Training: 0.8
- Books, About, Contact: 0.7
- Blog posts: 0.6
- Legal / system pages: 0.3

**Excluded from sitemap:** QR pages, thank-you pages, legacy archive pages, attachment pages.

---

### Internal Linking Architecture

Internal links serve two purposes: user navigation and PageRank distribution. The architecture:

- **Home** → links to Treatment, Method, Lessons, Sound Healing (all four primary money pages)
- **Treatment** → links to Method (the "why" behind the treatment), FAQ (standalone), Contact
- **Method** → links to Treatment, Lessons (related), Sound Healing (related)
- **Blog posts** → every post must include ≥1 internal link to a relevant service page
- **Books** → links to About (author context)
- **About** → links to Treatment, Method

No orphan pages. Every page is reachable from at least two other pages within the primary tree.

---

## Traffic Channels and Distribution Strategy

### Channel 1: Organic Search (Hebrew)

**Primary queries (target Hebrew searches):**
- טיפול בדיג'רידו
- דיג'רידו לנחירות
- נשימה מעגלית טיפול
- דיג'רידו ודום נשימה
- שיעורי דיג'רידו [+ area: מרכז / השרון / פרדס חנה]
- סאונד הילינג דיג'רידו
- שיטת cbDIDG
- אייל עמית דיג'רידו

**Priority pages for ranking:** Treatment page, Method page, Lessons page, Home.

**Blog as long-tail coverage:** The blog is the main vehicle for capturing long-tail Hebrew queries — people researching breathwork, snoring treatment alternatives, sound healing, circular breathing technique. Each post targets a specific question or topic cluster.

---

### Channel 2: Local Search

**Target queries:**
- "דיג'רידו פרדס חנה"
- "מרכז סאונד הילינג [קרקור / השרון / חיפה]"
- "טיפול נשימה קרוב אלי"

**Required implementation:**
- Google Business Profile — name consistent with site ("המרכז לטיפול בדיג'רידו - אייל עמית"), address (Pardes Hanna–Karkur), phone, hours, categories, photos
- NAP consistency: Name, Address, Phone identical across site, Google Business Profile, any directories
- LocalBusiness schema with geo coordinates on all service pages
- Hebrew AND English contact page with city name

---

### Channel 3: AI / Answer Engines (AEO + GEO)

**Target queries (AI-asked):**
- "What is didgeridoo therapy?"
- "Can didgeridoo help with sleep apnea?"
- "What is circular breathing therapy in Israel?"
- "Who teaches didgeridoo in Israel?"
- "What is cbDIDG?"
- "מה זה טיפול בדיג'רידו?"
- "האם דיג'רידו עוזר לנחירות?"

**What makes content AI-citable:**
- Short, factual, directly-answering paragraphs
- Clear attribution (who is the author, where is this center)
- Clinical research referenced with source (BMJ RCT)
- Consistent entity (Eyal Amit + cbDIDG + Pardes Hanna)
- Freshness signals (dates updated, no expired content visible)

**Measurement:** Track `utm_source=chatgpt.com` in Google Analytics to quantify AI referral traffic. Monitor Google Search Console for AI Overview appearances. Manual checks: ask ChatGPT and Perplexity for questions in the target domain and note whether the site is cited.

---

### Channel 4: Social and Community

**Facebook:** Primary social channel for this audience. Events, breathwork communities, wellness groups.

**Newsletter:** Existing email list — blog posts sent to subscribers; workshop announcements; content updates.

**Partnerships:** 
- Wellness centers and breathwork communities
- Sleep clinics and ENT practitioners who may refer patients exploring complementary options
- Other sound healers and meditation teachers who may cross-refer

---

### Channel 5: Lectures and Workshops

Every public lecture or workshop is an opportunity for direct URL sharing, QR code scans, and WhatsApp forwards. The QR URL preservation policy exists specifically to support this channel: any QR code Eyal has printed on flyers, cards, or books continues to work.

---

## The Blog as SEO Infrastructure

The blog is not a journal or a news section. It is a **structured SEO asset** with the following rules:

| Rule | Detail |
|------|--------|
| Minimum internal link | Every post links to ≥1 service page |
| H1 structure | One H1 per post — keyword-aligned |
| Meta | Unique meta description for every post |
| Images | Descriptive alt text on every lead image |
| Date management | `datePublished` and `dateModified` maintained accurately |

**Wave 1 (around launch):** Audit all 54 existing posts → Keep / Merge / Hide. Update top 10–15 posts (meta titles, internal links, images). No URL deletion without 301 redirect.

**Wave 2 (60 days post-launch):** 2–4 new posts per month. Topic clusters: breathing techniques, snoring and sleep research, didgeridoo as an instrument, workshop summaries, Q&A expansions.

---

## SEO Metrics and Success Definition

**Primary KPIs:**
- Organic clicks per month for the top 5 Hebrew queries (GSC)
- Ranking positions for target queries (top 3 is the goal for "טיפול בדיג'רידו")
- Local pack appearance for "near me" + studio queries
- AI referral traffic (chatgpt.com, perplexity.ai in GA4)

**Secondary KPIs:**
- Blog clicks from organic search
- Form submissions attributed to organic/AI traffic
- GSC impressions for English queries (international audience)

**Measurement setup required:**
- Google Search Console connected, domain property verified
- GA4 with UTM parameter tracking for chatgpt.com referrals
- Goal tracking for contact form submissions

---

## Open Questions (Pending Resolution)

| Question | Status |
|----------|--------|
| GPTBot (OpenAI training crawler) — allow or block? | Decision pending; currently defaulting to allow |
| hreflang implementation between Hebrew and English pages | Planned for English page launch |
| Google Business Profile categories — primary: "Sound healing service" or "Complementary medicine"? | To be confirmed |
| Blog post language — Hebrew only, or some posts in English? | Hebrew-first; English posts optional for international SEO |
