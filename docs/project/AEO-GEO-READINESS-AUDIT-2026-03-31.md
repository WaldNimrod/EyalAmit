# AEO / GEO Readiness Audit
**Project:** `eyalamit.co.il`  
**Date:** 2026-03-31  
**Purpose:** assess what the new site must improve in order to perform better in AI-driven discovery surfaces such as Google AI Overviews / AI Mode and ChatGPT Search.

## 1. Executive Summary
The market language has changed, but the operational conclusion is more concrete than dramatic:

1. **AEO / GEO are real traffic opportunities.**
2. **There is no separate "secret AI optimization layer" that replaces core SEO.**
3. **The site must become more crawlable, more answerable, more structured, more trustworthy, and easier for machines to quote correctly.**

### Main conclusion
The site should be rebuilt as a **clean, answer-friendly, entity-strong service site**, not as a patched legacy WordPress installation.

### Important nuance
According to Google, there are **no extra technical requirements** to appear in AI Overviews / AI Mode beyond normal Search eligibility. According to OpenAI, appearing in ChatGPT Search depends in part on **not blocking `OAI-SearchBot`**.  

Therefore, the work is not "AI hacks". The work is:
- clean crawl/index control
- strong textual answer blocks
- structured data that matches visible content
- clearer entity and service architecture
- better local/business trust signals
- explicit measurement of AI-origin traffic

## 2. What AEO / GEO Mean in Practice
### AEO
Answer Engine Optimization means shaping pages so answer engines can:
- identify the main question
- extract a direct answer
- understand authority and context
- safely cite or summarize the page

### GEO
Generative Engine Optimization means making content more usable for generative search surfaces such as:
- Google AI Overviews / AI Mode
- ChatGPT Search
- Bing / Copilot-like conversational layers

In practice, GEO depends on:
- crawl access
- indexability
- snippet eligibility
- clear textual content
- entity clarity
- structured data
- freshness
- trust

## 3. What the Official Sources Say
### 3.1 Google
Google's current guidance is explicit:
- standard SEO best practices still apply to AI features
- there are **no additional technical requirements**
- there is **no need to create new AI text files or special markup**
- important content should be available in text form
- structured data should match visible content
- Merchant Center / Business Profile information should be up to date
- preview controls such as `nosnippet`, `max-snippet`, `noindex` still control visibility in AI search experiences

### 3.2 OpenAI
OpenAI's current guidance is also explicit:
- `OAI-SearchBot` is the crawler used for ChatGPT Search discovery
- sites that block `OAI-SearchBot` will not be surfaced in ChatGPT search answers
- `OAI-SearchBot` is separate from `GPTBot`
- site owners can allow search discovery while disallowing model training
- referral traffic from ChatGPT search can be tracked via `utm_source=chatgpt.com`

## 4. Current-State Audit: Where the Site Stands Today
The observations below are based on the live site and current project materials.

### 4.1 What is already working
- The site has real expert content, not generic filler.
- The business has a strong human entity: Eyal Amit.
- There is niche topical authority around:
  - didgeridoo
  - circular breathing
  - sound healing
  - breathing / self-practice
  - instruction / workshops
- The site already has canonical tags and a working Yoast sitemap.
- The homepage and service pages are crawlable and indexable.

### 4.2 What is weak for AEO / GEO right now
#### A. Crawl policy is not explicit enough
- `robots.txt` returns `404`.
- `llms.txt` returns `404`.

Important note:
- `robots.txt` returning `404` does **not** automatically block crawling.
- However, it means there is currently **no explicit policy** for Googlebot, `OAI-SearchBot`, or `GPTBot`.

#### B. Schema is thinner than it should be
On the live homepage, current JSON-LD output appears to be only a single Yoast graph with:
- `Person` / `Organization`
- `WebSite`
- `WebPage`

Observed gaps:
- no dedicated `FAQPage`
- no dedicated `LocalBusiness` / `ProfessionalService`
- no dedicated service-level schema on money pages

On a core service page (`טיפול בדיג'רידו – ריפוי עצמי בעזרת דיג'רידו`), live structured data is still minimal and no FAQ schema was found.

#### C. Pages are not written in an "answer extraction" format
The site has expertise, but many pages are still written as long narrative marketing text.

Current weakness:
- no short, direct answer block near the top
- limited scannable Q/A formatting
- weak FAQ architecture
- not enough explicit "for whom / what it is / how it works / what happens next"

#### D. Content trust is uneven
For AI systems, especially around health-adjacent topics, phrasing matters.

Current risk:
- some benefit claims are broad
- some language can sound like medical promise rather than guided practice / supportive method
- this may reduce trust, or create compliance risk

#### E. Freshness and maintenance signals are mixed
The homepage still promotes workshop dates from:
- `17.12.2025`
- `18.12.2025`
- `19.12.2025`

As of `2026-03-31`, this is a weak freshness signal.

#### F. Too much crawl noise still exists in the ecosystem
Legacy content footprint includes:
- shop pages
- QR pages
- product remnants
- attachments
- theme leftovers
- old archive layers

This is harmful for AEO / GEO because machines need a **tight topic graph**, not a noisy domain.

#### G. Social-preview readiness is incomplete
The homepage currently exposes:
- `og:title`
- `og:description`
- but no `og:image`

This weakens sharing quality and reduces clarity in external surfaces.

#### H. AI traffic measurement is not yet treated as a first-class KPI
Current strategy documents focus on SEO and migration, but not yet enough on:
- ChatGPT-origin traffic
- citation visibility
- AI-assisted discovery paths
- answer-surface CTR / assisted conversions

## 5. Strategic Interpretation
### 5.1 The opportunity
This domain is actually a good candidate for AEO / GEO because it has:
- a clear expert entity
- a niche subject area
- strong service intent
- long-tail question potential
- a local / trust dimension

### 5.2 The risk
If the rebuild keeps the current pattern of:
- long unstructured copy
- unclear service boundaries
- crawl noise
- stale content
- thin schema

then the site may rank in classic SEO, but underperform in AI search experiences where systems prefer concise, structured, trustworthy, answerable content.

## 6. What Must Change in the New Site
## 6.1 P0: Mandatory for the rebuild
### 1. Add explicit crawl policy
Create a real `robots.txt` and define policy intentionally.

Recommended direction:
- allow `Googlebot`
- allow `OAI-SearchBot`
- decide intentionally whether to allow or block `GPTBot`
- publish sitemap location explicitly

### 2. Build pages around answer blocks
Each core service page should begin with a short section that directly answers:
- what is this service?
- who is it for?
- what happens in the process?
- what result should the user realistically expect?
- how do I begin?

This is one of the highest-impact AEO/GEO changes.

### 3. Turn service pages into machine-readable service assets
Each service page should contain:
- one clear H1
- short summary paragraph
- scannable sections
- FAQ section
- conversion CTA
- trust section

### 4. Strengthen structured data
Minimum schema stack for the new site:
- `Organization` or `Person`
- `LocalBusiness` or `ProfessionalService`
- `BreadcrumbList`
- `Article` for posts
- `FAQPage` where real FAQs exist
- `Event` only when a real upcoming event is active

Structured data must match visible content exactly.

### 5. Reduce crawl noise hard
Remove or de-index from the new main experience:
- cart / checkout / account
- QR archives
- legacy portfolio leftovers
- attachment pages
- thin legacy pages
- outdated campaign pages

### 6. Make important content textual and extractable
Do not rely on:
- image text
- gallery-heavy sections
- sliders
- video without supporting text

Every important claim must also exist in clean body text.

### 7. Fix freshness discipline
Homepage and service pages must never show expired dates.  
If events exist:
- show only the next real event
- remove automatically or archive on expiry

### 8. Add real measurement for AI discovery
Implement reporting for:
- `utm_source=chatgpt.com`
- Search Console web performance
- AI-assisted landing pages
- lead-source attribution by landing page

## 6.2 P1: Highly recommended
### 9. Build a question-led content model
Create a content backlog around real user questions, for example:
- מה זה נשימה מעגלית?
- איך לומדים לנגן בדיג'רידו?
- מה ההבדל בין סאונד הילינג לבין תהליך לימודי/טיפולי?
- למי זה מתאים?
- מה קורה במפגש ראשון?
- האם זה מתאים למתחילים?

### 10. Create entity clarity
The site should consistently connect:
- Eyal Amit
- Circular Breathing Studio
- Didgeridoo
- Circular breathing
- Sound healing
- Instruction
- Local presence in Pardes Hanna

This matters for both Search and generative systems.

### 11. Improve local-business completeness
Audit and align:
- business name
- address / area served
- phone
- opening / response expectations
- business profile data
- consistent footer / contact data

### 12. Improve preview assets
Every core page should have:
- unique title
- unique meta description
- unique OG image
- strong lead image

## 6.3 P2: Experimental / optional
### 13. `llms.txt`
This can be added as an experiment, but should **not** be treated as a priority over the fundamentals above.

Reason:
- Google explicitly says no new AI file or special markup is required for AI features.
- `llms.txt` is still optional and ecosystem-level, not a core ranking/discovery prerequisite.

### 14. Merchant / product feed work
Only relevant if books or products later become a real external commerce strategy.

## 7. Recommended Backlog
### Phase 1: Foundation
1. `robots.txt`
2. crawl / index policy
3. sitemap cleanup
4. canonical redirect map
5. removal of crawl noise

### Phase 2: Page architecture
1. homepage rewrite
2. service page template
3. FAQ architecture
4. author/entity/about structure
5. trust and contact architecture

### Phase 3: Structured data
1. Person / Organization / ProfessionalService
2. Article
3. Breadcrumb
4. FAQ
5. Event where applicable

### Phase 4: Content engine
1. question-led blog plan
2. evergreen answer pages
3. myth-busting pages
4. case stories / testimonials
5. media / podcast pages

### Phase 5: Measurement
1. Search Console baseline
2. GA4 AI-source dashboards
3. ChatGPT referral tracking
4. lead attribution

## 8. Decision Points for the Client Meeting
These are the decisions to close with Eyal:

### Decision 1
Do we want the new site to optimize primarily for:
- leads to treatment
- leads to lessons
- workshop registrations
- content authority

### Decision 2
Are books a core growth area or a supporting authority layer?

### Decision 3
Should product / instrument sales exist only as inquiry pages, or disappear entirely?

### Decision 4
Do we want to allow `GPTBot`, or allow only `OAI-SearchBot` and block model-training crawl?

### Decision 5
How conservative do we want to be with health-related claims and wording?

## 9. Final Recommendation
The correct interpretation of AEO / GEO for this project is:

1. do **not** chase gimmicks
2. do **not** build around experimental AI-file folklore
3. rebuild the site so machines can:
   - crawl it
   - understand it
   - trust it
   - extract answers from it
   - cite it clearly

For this domain, the highest ROI work is:
- answer-first page design
- clean information architecture
- service-focused structured data
- explicit crawler policy
- removal of legacy noise
- AI-source measurement

## 10. Source Notes
Primary external sources used for this audit:
- Google Search Central: [AI features and your website](https://developers.google.com/search/docs/appearance/ai-features)
- Google Search Central Blog: [Top ways to ensure your content performs well in Google's AI experiences on Search](https://developers.google.com/search/blog/2025/05/succeeding-in-ai-search)
- OpenAI Docs: [Overview of OpenAI crawlers](https://developers.openai.com/api/docs/bots)
- OpenAI: [Help ChatGPT discover your products](https://openai.com/chatgpt/search-product-discovery/)
- OpenAI Help Center: [Publishers and developers FAQ](https://help.openai.com/en/articles/12627856-publishers-and-developers-faq)

