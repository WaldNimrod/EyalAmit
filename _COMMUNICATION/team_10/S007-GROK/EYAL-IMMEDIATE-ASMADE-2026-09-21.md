# EYAL-IMMEDIATE — As-Made Report (Team 10)

| Field | Value |
|-------|-------|
| Pack | Eyal Immediate (S007-GROK) |
| Date | 2026-09-21 |
| Staging | http://eyalamit-co-il-2026.s887.upress.link |
| Theme live | **1.5.100** |
| FTP | **OK** (3 deploys; see DEPLOY-LOG) |
| Mandate | file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/MANDATE-EYAL-IMMEDIATE-2026-09-21.md |
| Git commit at deploy | `20361b1d6b1d` (DIRTY working tree — not committed) |

---

## Hebrew summary (לצוות 100 / אייל)

חבילת **Eyal Immediate** הוטמעה בסטייג'ינג ונפרסה ב-FTP. גרסת התמה **1.5.100**.

**בוצע:**
- **EI-B1** — וידאו YouTube 16:9 בדף הבית (במקום Lorem / placeholder).
- **EI-A4** — עמוד `/thank-you/` עם שתי שורות אייל; ניתוב CF7 אחרי שליחה (JS).
- **EI-D1** — הסרת בלוק עדויות + CTA מדף דידג'רידואים (עדויות בית נשארו).
- **EI-D3** — קישור FAQ `general-12` → `/learning/therapist-training/`.
- **EI-F3** — תיקון אסטמה → אסתמה ב-defaults חיים (לא בציטוט לקוח).
- **EI-L1–L3** — הסרת pending-note; תאריך מאושר 21 בספטמבר 2026.
- **EI-T18** — P016/P045 לפח + 301 ל־`/blog/`.
- **EI-T19** — P002/P006/P008/P048: תמונות מפרודקשן, קישורים, P048 → `/books/kushi-blantis/`.

**לא בחבילה (לפי מנדט):** ניווט, EN, גלריות, heroes מרובים, WhatsApp, C2 therapist-training copy.

**NEED-HUMAN:** אין. (הפניה מטופס ל־`/thank-you/` לא נבדקה end-to-end בשליחה אמיתית — רק GET + קוד JS.)

---

## Scope delivered (mandate IDs)

| ID | Item | Status |
|----|------|--------|
| EI-B1 | Home video embed | DONE |
| EI-A4 | Thank-you page + CF7 redirect hook | DONE |
| EI-D1 | Didgeridoos testimonials removed | DONE |
| EI-D3 | FAQ general-12 href | DONE |
| EI-F3 | אסתמה spelling in live defaults | DONE |
| EI-L1–L3 | Legal pages approved date, no pending-note | DONE |
| EI-T18 | Trash P016/P045 + 301 → /blog/ | DONE |
| EI-T19 | Blog exceptions P002/P006/P008/P048 | DONE |

---

## Smoke GET (no follow, UA Mozilla/5.0)

| Check | HTTP | Result |
|-------|------|--------|
| Home — no Lorem/placeholder; YouTube iframe; אסתמה | 200 | PASS |
| `/didgeridoos/` — no «לכל העדויות וההמלצות»; no testimonials section in body | 200 | PASS |
| `/thank-you/` — Eyal two lines | 200 | PASS |
| `/accessibility/` `/privacy/` `/terms/` — no «ממתין לאישור» | 200 | PASS |
| `/faq/` — `/learning/therapist-training/` present; old cbDidg path absent | 200 | PASS |
| P016 slug — 301 → `/blog/` | 301 | PASS |
| P045 slug — 301 → `/blog/` | 301 | PASS |
| `style.css` Version 1.5.100 | 200 | PASS |
| P008 — 6+ women photos under `/uploads/2025/02/`; no `ea-legacy/` body imgs | 200 | PASS |
| P048 — `/books/kushi-blantis/` in content | 200 | PASS |

Note: `/didgeridoos/` still enqueues global CSS handle `ea-testimonials-carousel-css` (theme asset); **no testimonial block or CTA text** in page content.

---

## FTP deploy log (this pack)

| Timestamp (Asia/Jerusalem) | Theme | Note |
|----------------------------|-------|------|
| 2026-09-21T14:01:50+03:00 | 1.5.100 | DIRTY: EI immediate pack team10 |
| 2026-09-21T14:04:45+03:00 | 1.5.100 | DIRTY: EI T19 v2 image fix |
| 2026-09-21T14:07:37+03:00 | 1.5.100 | DIRTY: EI-T19 P008 v3 body_images fix |

Source: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/DEPLOY-LOG.md

---

## Files changed (this pack only)

### Theme `ea-eyalamit` (modified)

| File | SHA-256 |
|------|---------|
| `site/wp-content/themes/ea-eyalamit/style.css` | `f3e86d19a177d1a0dcde53e87ea52a3c261a05e0a98ad5ed616ed671e63bf0a2` |
| `site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-home-03-video.php` | `d5313576b6ed631150fd0ef85d7a99196e143728a1a8807ad6dc6934e88a1db0` |
| `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/home-defaults.php` | `9eb166a3aaca57415ba76a5f07eaf91582ef9d6d47f04765df43af62d32ba26f` |
| `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` | `63fc58c80e7bb7debe810d9d02f49c0a8879d9b26ec78b7ff20fe8cef501c85d` |
| `site/wp-content/themes/ea-eyalamit/assets/js/ea-ab-testing.js` | `abe540fe318edc00771e40403f37d442e58c33f27c8179c4f7497c3d48761f97` |
| `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/didgeridoos-defaults.php` | `5953f3ecdfbc86bb82ddc25ef96ac084a64912773ad74a64e47027b4ab860195` |
| `site/wp-content/themes/ea-eyalamit/inc/data/ea-faq-seed.json` | `39ebd636b7eb2cd33a62fabcab5721cfa6411f47fbafc901cce067fd1a2b56dc` |
| `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/accessibility-defaults.php` | `8368ee060c42667031ac4ce238975051ab2ffa9154d928b9899c76a690a3bb05` |
| `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/privacy-defaults.php` | `5817733c690775664f9d2069a6716d584cc257cb8a86c38efa82160e9c0b7c6a` |
| `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/terms-defaults.php` | `0d7184d68dce94596ff43dd765047dc11f7e2a6d71c1fc9c1c02cf4e049140a7` |
| `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/method-defaults.php` | `1112e87baa3b7d3b356f784a7f271eca477271d429c8f828097d9cdede525d87` |
| `site/wp-content/themes/ea-eyalamit/inc/wave2-stage-b.php` | `de2c581026f6ec87bfb82d1d64eb79e1fa0c85b6ef3ae201759036524f4463c2` |

### Theme (new)

| File | SHA-256 |
|------|---------|
| `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/thank-you-defaults.php` | `4451582eb824f61c0c8c3b0f6c5690eb867a25cf0044784d7fa68aaf6f7402c6` |

### MU-plugins (new)

| File | SHA-256 | Option / behaviour |
|------|---------|-------------------|
| `site/wp-content/mu-plugins/ea-ei-d3-faq-general12-once.php` | `04b0ec0003b3918d068b045895a61d90e23a20cb4b9b1031ab4b4801cffbb095` | `ea_ei_d3_faq_general12_done` |
| `site/wp-content/mu-plugins/ea-ei-t18-trash-once.php` | `178b05b929b45c15e6ffe07e39d77bb87402d0450039e00afa8cb7efbb3b79b0` | `ea_ei_t18_trash_done` |
| `site/wp-content/mu-plugins/ea-ei-t18-legacy-301.php` | `6ddb887b69d5fbaafb994456d5fae66ad556e8c96983fcd764eb85ebaa6171d7` | persistent `template_redirect` |
| `site/wp-content/mu-plugins/ea-ei-t19-blog-exceptions-once.php` | `4e08a47af601e76fec43f22d5b4a1efa395944e7171a73210523573bb8302af0` | `ea_ei_t19_blog_v3_done` |

---

## Hard NO compliance

| Rule | Honoured |
|------|----------|
| No nav files (`ea-canonical-nav*`, `section-nav`, `block-topnav`) | YES |
| No `--fs-*` token changes | YES |
| No `_aos/` / `local/` commit | YES |
| No invented copy | YES |
| Out-of-scope items (EN, galleries, bulk heroes, nav IA, WA float) | NOT touched |
| `/en/` Draft banner | NOT removed |
| C2 therapist-training body | NOT changed |

---

## Exceptions / notes

| Topic | Detail |
|-------|--------|
| P008 images | v3 mu-plugin uses explicit `body_images` URLs from production (`/Blog/...` path). Live HTML shows `/uploads/2025/02/` sideloads (6 body + featured). |
| REST `content.rendered` for P008 | May lag or differ from front-end template output; smoke used live HTML GET. |
| CF7 redirect | `ea-ab-testing.js` listens `wpcf7mailsent` on `/contact` → `/thank-you/`. Not smoke-tested with real form submit. |
| Commits | Working tree dirty; user did not request git commit. |

---

## NEED-HUMAN

None for this pack.

---

*Team 10 implementation — builder smoke only; Team 50 functional validation per gate.*
