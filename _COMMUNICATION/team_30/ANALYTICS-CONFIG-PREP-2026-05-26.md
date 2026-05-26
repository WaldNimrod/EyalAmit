# Analytics Configuration Prep — EyalAmit.co.il | 2026-05-26

**Prepared by:** team_30  
**Status:** PENDING_CREDENTIALS — awaiting Eyal to supply GA4 Measurement ID + Clarity Project ID  
**Config file:** `hub/data/analytics-config.json`  
**Theme implementation:** blocked pending Stage A LOD400 spec from team_100

---

## Section A — How to Create GA4 Property (for Eyal)

Follow these steps to create a Google Analytics 4 property for eyalamit.co.il:

1. Go to https://analytics.google.com and sign in with your Google account.
2. Click **Admin** (bottom-left gear icon) → **Create** → **Property**.
3. **Property name:** `Eyal Amit` (or `eyalamit.co.il`)
4. **Reporting time zone:** `Israel` (Asia/Jerusalem)  
   **Currency:** `Israeli Shekel (ILS)`
5. **Business objectives:** select `Get baseline reports` or `Examine user behavior` — the closest match to engagement/awareness goals.
6. **Platform:** choose **Web**.
7. **Website URL:** `https://www.eyalamit.co.il`  
   **Stream name:** `eyalamit.co.il main`
8. Click **Create stream**.
9. In the stream details panel, copy the **Measurement ID** — it looks like `G-XXXXXXXXXX`.
10. Also copy the **Stream ID** — this is the numeric ID shown just below the stream name.
11. Enter both values into `hub/data/analytics-config.json`:
    - `ga4.measurement_id` → the `G-XXXXXXXXXX` value
    - `ga4.stream_id` → the numeric stream ID

**Note:** Do NOT activate the built-in "Enhanced Measurement" events until the site is live, to avoid polluting data during staging.

---

## Section B — How to Create Clarity Project (for Eyal)

Follow these steps to create a Microsoft Clarity project for the site:

1. Go to https://clarity.microsoft.com and sign in with your Microsoft account (or create one — it's free).
2. Click **+ New project** (top-right button).
3. Fill in:
   - **Name:** `Eyal Amit Site`
   - **Website URL:** `https://www.eyalamit.co.il`
   - **Category:** `Personal` (closest match for a personal brand/practitioner site)
4. Click **Create**.
5. In the project dashboard, find the **Project ID** — it is the short alphanumeric code visible in:
   - The browser URL after creating the project (e.g., `clarity.microsoft.com/projects/view/XXXXXXXXXXXX/`)
   - The setup snippet shown on the Install page (the value after `/tag/`)
6. Enter the Project ID into `hub/data/analytics-config.json`:
   - `clarity.project_id` → the alphanumeric project ID

**Note:** Clarity is free and has no traffic caps. Session recordings and heatmaps activate automatically once the snippet is live.

---

## Section C — Theme Integration (awaiting LOD400 spec from team_100)

### Implementation plan (ready to execute once credentials + spec arrive)

**GA4 gtag.js snippet**
- Will be added to `functions.php` via the `wp_head` hook (or `wp_enqueue_scripts` with `wp_add_inline_script`).
- The Measurement ID from `analytics-config.json → ga4.measurement_id` will be substituted into the snippet template at `analytics-config.json → ga4.gtag_snippet_template`.
- Output only on the frontend (not in `is_admin()`).

**Microsoft Clarity snippet**
- Will be added to `functions.php` via the `wp_head` hook.
- The Project ID from `analytics-config.json → clarity.project_id` will be substituted into the snippet template at `analytics-config.json → clarity.clarity_snippet_template`.
- Output only on the frontend (not in `is_admin()`).

**Implementation is BLOCKED pending:**
1. Eyal supplying GA4 Measurement ID and Clarity Project ID (fill into `hub/data/analytics-config.json`).
2. Stage A LOD400 spec delivery from team_100 — this spec will determine whether analytics hooks are added to the current `functions.php` directly or via a dedicated `inc/analytics.php` include, and whether any consent/cookie banner integration is required.

**Once both are received, team_30 will:**
- Read credentials from `hub/data/analytics-config.json`
- Add both snippets to the child theme per the LOD400 spec pattern
- Validate on staging before marking the task DONE
