---
mandate_id: MANDATE-TEAM20-B-PREP-2026-05-26
issued_by: team_10
issued_to: team_20
date: 2026-05-26
wp: WP-W2-01-STAGE-B-PREP
tasks: [B-PREP-1, B-PREP-2, B-PREP-5]
status: ISSUED
---

# Mandate — Team 20 | Stage B Prep Tasks

## Context
Wave2 Stage B parallel prep track. Team 100 is executing Stage A (LOD400 Design System spec) in parallel.
Your 3 tasks are infrastructure/backend tasks that can proceed independently of the LOD400 spec.

**Project root:** `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/`
**Credentials file:** `local/.env.upress` (gitignored — read it directly, never echo to logs)
**Staging base URL:** `http://eyalamit-co-il-2026.s887.upress.link`
**WP REST API:** Application Passwords enabled. Use `UPRESS_WP_APP_USER` + `UPRESS_WP_APP_PASS` from `.env.upress`.
**Table prefix:** `heu_` (not `wp_`)

---

## B-PREP-1 — Install CF7 + WP Mail SMTP Plugins

**Goal:** Install and activate both plugins on staging. Do NOT configure SMTP credentials — Eyal enters those manually (human gate).

**Steps:**
1. Read `local/.env.upress` to get `UPRESS_WP_APP_USER` and `UPRESS_WP_APP_PASS`.
2. Install Contact Form 7:
   ```
   POST http://eyalamit-co-il-2026.s887.upress.link/wp-json/wp/v2/plugins
   Auth: Basic base64(UPRESS_WP_APP_USER:UPRESS_WP_APP_PASS)
   Body: {"slug": "contact-form-7", "status": "active"}
   ```
3. Install WP Mail SMTP:
   ```
   POST http://eyalamit-co-il-2026.s887.upress.link/wp-json/wp/v2/plugins
   Body: {"slug": "wp-mail-smtp", "status": "active"}
   ```
4. Verify both appear active:
   ```
   GET /wp-json/wp/v2/plugins?per_page=100
   ```
5. Record installed version of each plugin.

**Deliverable:** `_COMMUNICATION/team_20/PLUGINS-INSTALLED-2026-05-26.md`

Format:
```markdown
# Plugins Installed — 2026-05-26

| Plugin | Slug | Version | Status |
|--------|------|---------|--------|
| Contact Form 7 | contact-form-7 | x.x.x | active |
| WP Mail SMTP | wp-mail-smtp | x.x.x | active |

## Human Gate — SMTP Configuration
- Plugin installed. SMTP credentials must be entered by Eyal in WP admin > WP Mail SMTP.
- Required: Google Workspace App Password for info@eyalamit.co.il
- WP Admin URL: http://eyalamit-co-il-2026.s887.upress.link/wp-admin/admin.php?page=wp-mail-smtp
- AC: BLOCKED_PENDING_HUMAN
```

---

## B-PREP-2 — Verify Google Workspace MX for info@eyalamit.co.il

**Goal:** Confirm MX records point to Google Workspace. Prepare instructions for Eyal to enter SMTP credentials.

**Steps:**
1. Run: `dig MX eyalamit.co.il +short`
2. Verify output contains Google MX servers (e.g. `aspmx.l.google.com`, `alt1.aspmx.l.google.com`, etc.)
3. Send a test email from WP using existing SMTP (if already configured) OR note current SMTP state.
4. Document SMTP App Password creation steps for Eyal:
   - Google Workspace Admin > Security > 2-Step Verification > App Passwords
   - App: Mail, Device: Other (WP Staging)
   - Copy 16-char password → enter in WP Mail SMTP plugin settings

**Deliverable:** `_COMMUNICATION/team_20/MX-VERIFY-2026-05-26.md`

Format:
```markdown
# Google Workspace MX Verification — 2026-05-26

## MX Records (dig output)
[paste dig output]

## Result
PASS / FAIL — [explanation]

## SMTP Status
[current state / what Eyal needs to do]

## Instructions for Eyal: Create Google App Password
1. ...
```

---

## B-PREP-5 — MEDIA-IN-USE Inventory

**Goal:** Enumerate all media attachments in WP that are actively used (attached to a post, or referenced in page content). Produce a JSON inventory for use in W2-09.

**Steps:**
1. `GET /wp-json/wp/v2/media?per_page=100&page=1` — paginate until no more results.
2. For each attachment item, extract: `id`, `source_url`, `slug`, `mime_type`, `media_details`, `post` (parent post ID — non-zero means attached).
3. For items with `post: 0` (unattached): also query post content to find any references. You can do a DB search via REST or note them as "potentially unused."
4. Filter to items with `post > 0` OR found in post content — these are "in use."
5. Build JSON array with each entry:
   ```json
   {
     "id": 123,
     "url": "http://.../.../file.jpg",
     "filename": "file.jpg",
     "mime_type": "image/jpeg",
     "used_by": [{"post_id": 45, "post_type": "page"}]
   }
   ```

**Expected count:** 60–120 items in use.

**Deliverable:** `_COMMUNICATION/team_20/MEDIA-IN-USE-INVENTORY-2026-05-26.json`

---

## Acceptance Criteria

- [ ] B-PREP-1: Both plugins appear in `/wp-json/wp/v2/plugins` with `status: active`
- [ ] B-PREP-1: `PLUGINS-INSTALLED-2026-05-26.md` written with versions documented
- [ ] B-PREP-2: `dig MX eyalamit.co.il` returns Google MX servers
- [ ] B-PREP-2: `MX-VERIFY-2026-05-26.md` written with PASS/FAIL verdict + Eyal instructions
- [ ] B-PREP-5: `MEDIA-IN-USE-INVENTORY-2026-05-26.json` written with ≥1 entry (expect 60–120)

## Iron Rules Reminder
- Write ONLY to `_COMMUNICATION/team_20/` and application source dirs
- Credentials from `local/.env.upress` only — never hardcode in deliverables
- Do NOT write to `_aos/`
- API-only mutations when AOS DB is online

## Report When Done
Write completion status to `_COMMUNICATION/team_20/B-PREP-COMPLETION-TEAM20-2026-05-26.md` with AC checklist results, then notify team_10.
