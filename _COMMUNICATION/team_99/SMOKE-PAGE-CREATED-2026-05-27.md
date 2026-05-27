---
id: SMOKE-PAGE-CREATED-2026-05-27
title: team_99 — Wave2 Stage B Smoke Page Created (Task B)
status: PASS
date: 2026-05-27
from_team: team_99
to_team: team_100 ; team_50 (for R5 re-QA)
parent_mandate: ./MANDATE-TEAM99-STAGE-B-DEPLOY-2026-05-27.md
wp: WP-W2-01-STAGE-B-IMPL (remediation R3)
operating_mode: SERVER_OPS / OUT_OF_GATE_ISOLATED
---

# Smoke Page Created — Task B

## Verdict: **PASS** — `/wave2-test/` live, all 12 blocks render, Wave2 CSS/JS enqueued.

## 1. Creation mechanism

- **Channel:** WordPress REST API (`POST /wp-json/wp/v2/pages`) — chosen over WP-CLI because uPress sandbox does not expose SSH/WP-CLI to agents; admin browser fallback was unnecessary.
- **Auth:** Basic with `UPRESS_WP_APP_USER=eyaladmin` + Application Password from `local/.env.upress` (`UPRESS_WP_APP_PASS`).
- **Endpoint:** `http://eyalamit-co-il-2026.s887.upress.link/wp-json/wp/v2/pages`.

### Pre-flight

```
GET /wp-json/wp/v2/pages?slug=wave2-test&context=edit&status=any
→ []   (no existing page — safe to create)
```

### Create request body

```json
{
  "title": "Wave2 Stage B Smoke Test",
  "slug": "wave2-test",
  "status": "publish",
  "template": "page-templates/tpl-stage-b-test.php",
  "content": ""
}
```

### Response

```
HTTP/1.1 201 Created
id:        178
slug:      wave2-test
status:    publish
template:  page-templates/tpl-stage-b-test.php
link:      http://eyalamit-co-il-2026.s887.upress.link/wave2-test/
```

> Note: the modern REST API exposes `template` as a top-level field (WP 5.0+). The mandate's WP-CLI form (`--meta_input='{"_wp_page_template":...}'`) is the legacy meta-key approach — both end up writing `_wp_page_template` postmeta. The REST path produced the same result without needing shell access to uPress.

## 2. Post-create verification (HTTP)

```
GET /wave2-test/  →  HTTP/1.1 200 OK  (Server: nginx, Content-Type: text/html; charset=UTF-8)
```

Response HTML inspection (84 KB body):

**Body class** confirms template binding:
```
page-template-page-templatestpl-stage-b-test-php
```

**12 `data-block=` markers** rendered (all 12 Stage B blocks, no duplicates):

```
data-block="books-row"
data-block="breath-divider-1"
data-block="contact-cta"
data-block="faq-mini"
data-block="footer-social"
data-block="hero"
data-block="intro"
data-block="method-pillars"
data-block="services-row"
data-block="testimonials-row"
data-block="topnav"
data-block="treatment-overview"
```

**Wave2 stylesheets enqueued** (visible in `<link rel="stylesheet">` tags):
- `ea-tokens.css?ver=1.3.6`
- `ea-animations.css`
- `ea-atoms.css`

**Wave2 scripts enqueued** (visible in `<script src="...">` tags):
- `ea-ab-testing.js`
- `ea-entrance.js`
- `ea-hero.js`
- `ea-scroll.js`

## 3. Acceptance criteria — mandate §1 Task B

- [x] `/wave2-test/` returns HTTP/1.1 200 OK.
- [x] HTML contains all 12 blocks (12 unique `data-block=` values, one per Stage B block).
- [x] `<link rel='stylesheet' ...ea-tokens.css...>` present in HTML.

## 4. Handoff

→ **team_50**: smoke page is live. Phase 2 re-QA can drive its Stage B render checks against `http://eyalamit-co-il-2026.s887.upress.link/wave2-test/` (page id 178).
→ **team_100**: R3 of remediation plan complete.
