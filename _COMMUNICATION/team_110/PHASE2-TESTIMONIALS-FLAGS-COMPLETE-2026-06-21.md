# Phase 2 COMPLETE — testimonials (item 2) + flags (item 3)

**By:** team_110 · **Date:** 2026-06-21 · **Branch:** `mokesh-content` (deployed to staging; theme 1.4.16). **Uncommitted — awaiting Nimrod's go.**

## Item 2 — D-TESTIMONIALS (48 FB testimonials integrated)
- Source parsed: **48** testimonials (17 טיפול · 9 סאונד הילינג · 22 שיעורים), each name + FB link + full text → `theme/inc/data/ea-testimonials-fb.json`; accessors in `inc/ea-testimonials-fb.php`.
- **Service pages** (`inc/wave2-w2-04.php`): each page's CATEGORY of FB testimonials (provisional snippets) appended after the service-specific (source) ones, deduped by name — order preserved so content-diff stays green. treatment+method ← טיפול, sound-healing ← סאונד הילינג, lessons ← שיעורים.
- **/media** (`inc/wave2-w2-14e.php`): all 48 grouped by 3 categories; name links to the original FB post.
- **Home**: unchanged — already shows 15 curated source-verbatim testimonials (broad set).
- **Hub review**: full 48 + provisional snippets recorded as Eyal-review options → `hub/data/testimonials-curation.json` (decision: approve|edit|exclude per item; snippets are PROVISIONAL pending Eyal).

## Item 3 — flags
- **3a legacy 2-hop → single-hop**: regenerated `w209` from the decisions generator (changed only the mokesh target `/about/moksha/` → `/eyal-amit/mokesh-dahiman/`; verified diff is that one line). Legacy Hebrew slug now 1×301 → canonical 200.
- **3b VideoObject uploadDate**: added `2019-11-19` (verified from YouTube) — schema now video-rich-result eligible.
- **3c full film**: genuinely blocked on Eyal (no public link) — clean placeholder + link to the FB movie page retained. Needs Eyal's link.
- **3d CTA "gaps"**: investigated — the 2 shop pages render a RICHER book-purchase widget (price, mendele link) that supersedes the source's plain-text purchase lines; both pass the gate (≥90%). Accepted as intentional design (forcing the plain text would downgrade the UX).
- **FB mobile clip**: accepted — a proper fix needs the FB JS SDK, which the SEO/GEO plan flags against (Core-Web-Vitals); no document overflow (qa_probe green).

## Builder-side validation (ALL GREEN — re-verify independently)
| Gate | Result |
|---|---|
| content-diff (all) | **17/17 PASS**, 0 under-90; service routes + home + mokesh all 100/100/0 (testimonials additive, no regression) |
| axe (/media, /lessons, mokesh) | 0 critical / 0 serious |
| qa_probe (/media, /lessons, mokesh) | no overflow, mobile+desktop |
| redirects | legacy Hebrew slug **1 hop** → canonical 200; `/about/moksha/`,`/mokesh/`,`/mokesh-dahiman/` still 1 hop |
| /media | 48 testimonial cards, 3 category groups |
| VideoObject | uploadDate 2019-11-19 present |

Evidence: `_COMMUNICATION/team_110/evidence/phase2-2026-06-21/`.

## Pending Nimrod/team_00
1. Commit phase-2 (no commit without explicit ask).
2. Dual-PASS (team_50 + team_190) on the phase-2-changed routes (service pages, /media, legacy redirect) before Eyal-ready.
3. Eyal review of the provisional testimonial snippets (`hub/data/testimonials-curation.json`) + provide the full-film link.
