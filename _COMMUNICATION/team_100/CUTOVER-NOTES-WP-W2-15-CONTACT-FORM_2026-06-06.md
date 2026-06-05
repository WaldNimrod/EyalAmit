# CUTOVER NOTE — Contact form recipient (verify at final review, post main-domain cutover)

**Owner:** team_100 · **Date:** 2026-06-06 · **Context:** WP-W2-15 item C1 (Contact Form 7) closed.

## What to verify after cutover to the production domain
The contact form (Contact Form 7, **form id 392**, created by
`mu-plugins/ea-w2-15-cf7-contact-form-once.php`) sends submissions to the WordPress
**`admin_email`** (`get_option('admin_email')`).

- [ ] **Confirm `admin_email` is Eyal's real inbox** on production (Settings → General).
      If not, either update `admin_email`, or set an explicit recipient in CF7 form 392
      (Contact → Contact Forms → "צור קשר — אייל עמית" → Mail → "To"),
      or hardcode it in the mu-plugin `$mail['recipient']`.
- [ ] **Send a live test submission** from `/contact/` and confirm it arrives.
- [ ] Confirm mail deliverability on the production host (SMTP / SPF/DKIM) so CF7 mail
      isn't dropped to spam — separate from the recipient address.
- [ ] (Optional) spam protection on the form (CF7 + Akismet / reCAPTCHA) before go-live.

Reference: `scripts/final_pre_cutover_check.sh`, team_20 cutover checklist.
