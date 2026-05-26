# PLUGINS-INSTALLED-2026-05-26
**Team:** team_20  
**Date:** 2026-05-26  
**Staging:** http://eyalamit-co-il-2026.s887.upress.link  

---

## Plugin Installation Summary

| Plugin | Slug | Version | Status |
|--------|------|---------|--------|
| Contact Form 7 | contact-form-7/wp-contact-form-7 | 6.1.6 | active |
| WP Mail SMTP | wp-mail-smtp/wp_mail_smtp | 4.8.0 | active |

Both plugins were installed successfully via `POST /wp-json/wp/v2/plugins` using Application Password auth (HTTP 201 on both).

### Full Plugin Roster (for reference)
| Plugin | Slug | Version | Status |
|--------|------|---------|--------|
| Contact Form 7 (טפסי צרו קשר 7) | contact-form-7/wp-contact-form-7 | 6.1.6 | active |
| ezCache | ezcache/ezcache | 2.5.1 | inactive |
| Fluent Forms | fluentform/fluentform | 6.2.4 | active |
| LTR RTL Admin content | ltrrtl-admin-content/ltr-admin | 0.6.6 | active |
| MailCheck.ai | validator-pizza/validator-pizza | 1.3.0 | active |
| UserCheck | usercheck/usercheck | 0.3.0 | inactive |
| WP Accessibility | wp-accessibility/wp-accessibility | 2.3.3 | active |
| WP Mail Logging | wp-mail-logging/wp-mail-logging | 1.16.0 | active |
| WP Mail SMTP | wp-mail-smtp/wp_mail_smtp | 4.8.0 | active |
| Yoast SEO | wordpress-seo/wp-seo | 27.6 | active |

---

## Human Gate — SMTP Credentials Required

Eyal must manually configure SMTP settings. No credentials are stored by agents.

**URL:** http://eyalamit-co-il-2026.s887.upress.link/wp-admin/admin.php?page=wp-mail-smtp

Steps:
1. Log in to WP Admin as `eyaladmin`
2. Navigate to: WP Mail SMTP > Settings
3. Set **Mailer** to "Other SMTP"
4. Enter credentials as provided by the MX-VERIFY task instructions

---

## AC Verdict

**PASS** — Both Contact Form 7 (v6.1.6) and WP Mail SMTP (v4.8.0) confirmed active on staging.
