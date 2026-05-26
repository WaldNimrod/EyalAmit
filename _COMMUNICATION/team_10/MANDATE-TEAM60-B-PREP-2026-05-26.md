---
mandate_id: MANDATE-TEAM60-B-PREP-2026-05-26
issued_by: team_10
issued_to: team_60
date: 2026-05-26
wp: WP-W2-01-STAGE-B-PREP
tasks: [B-PREP-4, B-PREP-6]
status: ISSUED
---

# Mandate — Team 60 | Stage B Prep Tasks

## Context
Wave2 Stage B parallel prep track. Team 100 is executing Stage A (LOD400 Design System spec) in parallel.
Your 2 tasks are DevOps/infrastructure checks — staging health and FTP access verification.

**Project root:** `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/`
**Credentials file:** `local/.env.upress` (gitignored — read it directly, never echo credentials to logs or deliverables)
**Staging URL:** `http://eyalamit-co-il-2026.s887.upress.link`
**FTP reference script:** `scripts/ftp_deploy_site_wp_content.py`
**WP REST API:** Application Passwords enabled. Use `UPRESS_WP_APP_USER` + `UPRESS_WP_APP_PASS`.

---

## B-PREP-4 — Staging Health Check

**Goal:** Confirm the staging environment is healthy and ready for Wave2 work.

**Steps:**

1. **HTTP status check:**
   ```
   curl -o /dev/null -s -w "%{http_code}" http://eyalamit-co-il-2026.s887.upress.link
   ```
   Expected: `200` or `302`. Any 5xx = FAIL.

2. **Active theme check:**
   ```
   GET http://eyalamit-co-il-2026.s887.upress.link/wp-json/wp/v2/themes?status=active
   Auth: Basic base64(UPRESS_WP_APP_USER:UPRESS_WP_APP_PASS)
   ```
   Expected: response includes theme with `stylesheet: "ea-eyalamit"`.

3. **PHP syntax check on functions.php** (run locally):
   ```
   php -l "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/functions.php"
   ```
   Expected: `No syntax errors detected`.

4. **DB backup status:**
   DB backup is a manual action via uPress panel — document as:
   "Last known backup: 2026-03-31 (per M2-RUNBOOK-ENV). Manual backup recommended before Wave2 build begins."
   Do NOT attempt automated DB backup — note as human action required.

5. **WP version check** (optional, via REST):
   ```
   GET /wp-json/ — check `gmt_offset`, `timezone_string`, `wp_version` in body
   ```

**Deliverable:** `_COMMUNICATION/team_60/STAGING-HEALTH-CHECK-2026-05-26.md`

Format:
```markdown
# Staging Health Check — 2026-05-26

## HTTP Status
- URL: http://eyalamit-co-il-2026.s887.upress.link
- Response: [200 / 302 / other]
- Result: PASS / FAIL

## Active Theme
- Expected: ea-eyalamit
- Found: [theme name]
- Result: PASS / FAIL

## PHP Syntax — functions.php
- Result: PASS / FAIL
- Output: [php -l output]

## DB Backup Status
- Last known backup: 2026-03-31
- Action required: Manual backup via uPress panel before Wave2 build

## WP Version
- Version: [from /wp-json/]

## Overall: PASS / FAIL / PARTIAL
```

---

## B-PREP-6 — FTPS/SFTP Access Verification

**Goal:** Confirm FTP access to uPress staging is working. Test list, upload, delete.

**Steps:**

1. Read from `local/.env.upress`:
   - `UPRESS_FTP_HOST` (should be `ftp.s887.upress.link`)
   - `UPRESS_FTP_USER`
   - `UPRESS_FTP_PASS`
   - `UPRESS_FTP_PORT` (default 21)

2. Connect via FTPS (FTP + TLS explicit):
   ```python
   from ftplib import FTP_TLS
   ftp = FTP_TLS()
   ftp.connect(host, port)
   ftp.login(user, passwd)
   ftp.prot_p()  # switch to secure data connection
   ```
   Reference: `scripts/ftp_deploy_site_wp_content.py` for exact connection pattern.

3. List remote root `/` — capture directory listing.

4. Upload probe file:
   - Create a 1-byte temp file locally
   - Upload as `/_b_prep_probe_2026-05-26.txt`
   - Verify it appears in listing

5. Delete probe file:
   - `ftp.delete('/_b_prep_probe_2026-05-26.txt')`
   - Verify it no longer appears

6. Close connection.

**Deliverable:** `_COMMUNICATION/team_60/FTPS-VERIFY-2026-05-26.md`

Format:
```markdown
# FTPS Access Verification — 2026-05-26

## Connection
- Host: [from .env, masked]
- Port: 21
- TLS: Explicit (FTPS)
- Result: CONNECTED / FAILED

## Directory Listing (root /)
[first 10 entries or "empty"]

## Upload Probe
- File: /_b_prep_probe_2026-05-26.txt
- Result: SUCCESS / FAILED

## Delete Probe
- Result: SUCCESS / FAILED

## Overall: PASS / FAIL
```

**Security note:** Never include actual FTP password in the deliverable document. Use `[REDACTED]` for any credential fields shown.

---

## Acceptance Criteria

- [ ] B-PREP-4: HTTP status 200 or 302 from staging URL
- [ ] B-PREP-4: REST API confirms `ea-eyalamit` is active theme
- [ ] B-PREP-4: PHP syntax check passes on functions.php
- [ ] B-PREP-4: `STAGING-HEALTH-CHECK-2026-05-26.md` written with overall verdict
- [ ] B-PREP-6: FTP connection established, list/upload/delete probe all succeed
- [ ] B-PREP-6: `FTPS-VERIFY-2026-05-26.md` written with PASS overall verdict

## Iron Rules Reminder
- Write ONLY to `_COMMUNICATION/team_60/`
- Credentials from `local/.env.upress` only — NEVER include real passwords in deliverable docs
- Do NOT write to `_aos/`
- No production deployments without gate PASS

## Report When Done
Write completion status to `_COMMUNICATION/team_60/B-PREP-COMPLETION-TEAM60-2026-05-26.md` with AC checklist results, then notify team_10.
