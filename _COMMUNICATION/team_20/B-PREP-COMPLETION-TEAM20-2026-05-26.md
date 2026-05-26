# B-PREP-COMPLETION-TEAM20-2026-05-26
**Team:** team_20  
**Date:** 2026-05-26  
**Staging:** http://eyalamit-co-il-2026.s887.upress.link  
**Auth method:** Application Password (UPRESS_WP_APP_USER / UPRESS_WP_APP_PASS)

---

## AC Checklist

### B-PREP-1 — Install CF7 + WP Mail SMTP
- [x] Contact Form 7 installed and active (v6.1.6, HTTP 201)
- [x] WP Mail SMTP installed and active (v4.8.0, HTTP 201)
- [x] Both verified via GET /wp-json/wp/v2/plugins
- [x] Human-gate section written for SMTP credentials
- [x] Deliverable written: `PLUGINS-INSTALLED-2026-05-26.md`

### B-PREP-2 — Verify Google Workspace MX Records
- [x] `dig MX eyalamit.co.il +short` executed successfully
- [x] All 5 MX records confirm Google Workspace (aspmx.l.google.com + 4 alt servers)
- [x] PASS verdict confirmed
- [x] SMTP provider endpoint checked (404 as expected — WP Mail SMTP has no public REST API for config)
- [x] Step-by-step App Password + SMTP config instructions written for Eyal
- [x] Deliverable written: `MX-VERIFY-2026-05-26.md`

### B-PREP-5 — MEDIA-IN-USE Inventory
- [x] All media pages fetched (1 page, 11 items total — single page confirmed by count < 100)
- [x] 7 items classified `in_use` (post_id > 0, attached to pages 124, 125, 126)
- [x] 4 items classified `unattached_verify` (post_id == 0 or null — IDs: 121, 122, 158, 159)
- [x] Valid JSON output produced with correct top-level structure
- [x] Deliverable written: `MEDIA-IN-USE-INVENTORY-2026-05-26.json`

---

## Errors Encountered

| Task | Error | Resolution |
|------|-------|------------|
| B-PREP-2 | `/wp-json/wp-mail-smtp/v1/providers` returned 404 | Expected — WP Mail SMTP does not expose a provider config REST endpoint. Documented and skipped gracefully. |

No auth failures. Application Password worked for all plugin install and media listing operations.

---

## Human-Gate Items Still Pending

1. **SMTP configuration (B-PREP-1 + B-PREP-2):**  
   Eyal must log in to WP Admin and configure WP Mail SMTP manually.  
   URL: http://eyalamit-co-il-2026.s887.upress.link/wp-admin/admin.php?page=wp-mail-smtp  
   Instructions: see `MX-VERIFY-2026-05-26.md` for full App Password + settings guide.

2. **Unattached media review (B-PREP-5):**  
   4 media items (IDs 121, 122, 158, 159) have no parent post. Manual review recommended to determine if they should be deleted or re-attached. IDs 158 and 159 appear to be upload artifacts (duplicate filenames of attached items 163 and 164).

---

## Overall Verdict

**COMPLETE**

All 3 tasks executed successfully. Both plugins are live and active on staging. MX records confirm Google Workspace routing. Media inventory is complete (11 items, 7 in_use, 4 unattached_verify). Human-gate items documented with actionable instructions for Eyal.
