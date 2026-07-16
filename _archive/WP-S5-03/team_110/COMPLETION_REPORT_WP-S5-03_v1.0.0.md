---
id: COMPLETION_REPORT_WP-S5-03_v1.0.0
from_team: team_110
to: [team_00, team_100]
cc: [team_90, team_120, team_60]
date: 2026-07-16
type: COMPLETION_REPORT
wp: WP-S5-03
milestone: S005
project: eyalamit
mandate_ref: _COMMUNICATION/team_110/MANDATE_S005_TEAM110_EXECUTION_v1.0.0.md
adr_ref: ADR045 R4
status: COMPLETE / LOD500_LOCKED
---

# COMPLETION REPORT — WP-S5-03 (Legacy/301 completeness)

**The `/Blog/` catch-all was silently dropping four real, live posts of Eyal's.** A prefix rewrite cannot
follow a **rename**, and the regex ran *before* the exact map and `exit()`ed — so an exact decision for a
renamed post was **unreachable**. Every such post was 301'd into a 404. Nobody would have seen it: the URL
returned a redirect, not an error.

| Legacy URL | Live post | Was | Now |
|---|---|---|---|
| `/Blog/הכל-אודות-ריברסינג-נשימה-מעגלית-ו-דיג/` | `/ריברסינג-נשימה-מעגלית-דיגרידו/` | 301→**404** | 301→**200** |
| `/Blog/נשים-מנגנות-בדיגרידו-אישה-מנגנת-בדיג-2/` | `/נשים-מנגנות-בדיגרידו-אישה-מנגנת-בדיג/` | 301→**404** | 301→**200** |
| `/Blog/סדנה-קבוצתית-מקיפה-וייחודית-לנשימה-מע/` | `/סדנת-דיגרידו-קבוצתית-מקיפה-וייחודית-ל/` | 301→**404** | 301→**200** |
| `/Blog/את-הספר-החדש-שלי-לא-תמצאו-בחנויות-הספרי/` | `/את-הספר-החדש-שלי-לא-תמצאו-ברשתות-הספרים/` | 301→**404** | 301→**200** |

Each confirmed by **title match** against the live post, not slug similarity.

## 1. Gate chain

| Gate | Result | Findings |
|---|---|---|
| L-GATE_SPEC (cycles 1-2 / 3) | PASS_WITH_FINDINGS → PASS | 0 |
| **L-GATE_BUILD** | **PASS** | 0 blocker / 0 major / 3 minor |
| **L-GATE_VALIDATE** | **PASS** | **0** |

Iron Rule #1: builder `claude-opus-4-8` ≠ validator `composer-2.5`; team_110 self-validated at neither gate.

## 2. Result

- **368/368** unique paths triaged (from **406** raw rows — see F-01), **fully serial** with spaced retries on
  the throttling host; redirect chains re-probed with **`curl -L`** (the site has a legitimate 2-hop chain —
  a one-hop probe under-reports, a mistake I made and corrected).
- All fixes through the **SSoT** (135 → **165** decisions) + regeneration. The mu-plugin was **never**
  hand-edited — team_90 proved regeneration is a **zero-diff**.
- Live rules: **301 32 → 47** · **410 2 → 13**.
- **§3.2 Pattern A** — 2nd prefix, **plus a 3rd prefix `/פרדס-חנה/` the spec never names** (found only because
  the triage covered all 406 rather than a 21-URL sample).
- **§3.3 Pattern B** — `/shop/books/*` → the **latin** `/books/` slugs (verified 200; the hebrew variants 404).
  The spec's example slugs were **right**; an earlier note of mine claiming otherwise is retracted in the
  evidence pack.
- **§5** — 11 orphan media pages now **410 Gone**, not 301-to-nowhere.
- **§6** — www/scheme + orphaned-destination **marked**, deferred to WP-S5-05 §7 (the spec does not require
  staging verification for them).
- **§7** — `deploy_htaccess_301.py` **not run**: it uploads `.htaccess`, which nginx **ignores** — it would
  look like a deploy while changing nothing.

## 3. ADR042 3-step closure audit

| Step | Done | Evidence |
|---|---|---|
| 1 — Gate chain, cross-engine | ✔ | both gates team_90, PASS |
| 2 — Archive (IR#15) | ✔ | `_archive/WP-S5-03/ARCHIVE_MANIFEST.md`; **10 == 10**, non-vacuous; M.1–M.4 |
| 3 — Registration | ✔ | COMPLETE / LOD500_LOCKED / L-GATE_VALIDATE + full `gate_history` — **FILE path** (T-1 ruling) |

## 4. Findings → team_100 (none blocking)

- **F-01 — the spec's §1 table is wrong: 406, not 400.** The 9 GSC exports have **no trailing newline**, so the
  line-counter behind that table (`tail -n +2 | wc -l`) **drops the last URL of every file** — 6 files, 6 real
  legacy URLs silently omitted from the triage denominator. **The mandate's 406 was right.** Ask: correct §1.
- **F-02 — residual 301→404 chains** for the ~74 DROP-class `/Blog/` URLs (feeds/tags/attachments). Harmless to
  users, wasteful for crawl budget. Fixing = tightening the regex, a **mechanism** change outside this WP's
  contract. Options in the evidence pack.
- **F-03 — a LIVE BROKEN LINK on `/qr/qr2/`.** Two anchors point at `/books/צבע-בכחול-וזרוק-לים/` → **404**;
  one is empty (also S5-06's axe `link-name` node), the other is a **visible «לדף הספר>>» link a reader
  clicks**. Correct target: `/books/tsva-bekahol/` (200). Bounded: **1 QR page, 2 anchors, 1 target**. It is a
  **current internal seed link**, not a legacy GSC URL — out of scope for S5-03/06/07. Fix = edit
  `ea-w2-07-qr-content-data.php` + reseed with a new `-once` flag. **Eyal's readers hit it today.**

## 5. Declared deviation — adjudicated by team_90

§3.4 forbids hand-editing the **artifact** and prescribes "add decisions + regenerate". The 4 FOLD decisions
were **unreachable** that way, so I made a **minimal generator change**: emit `$map` before the `/Blog/` regex
and have the regex yield to it. **team_90 ruled it a legitimate SSoT-first fix, not an out-of-contract
hand-edit**, verifying the artifact regenerates zero-diff and that un-decided slugs still ride the catch-all.

## 6. Status

**WP-S5-03 — COMPLETE / LOD500_LOCKED.** The last of `WP-S5-05.blocked_by`'s code WPs is cleared.
**WP-S5-05 NOT started** — blocked cutover gate; needs explicit team_00/Eyal go-live approval.
Still outstanding for the cutover: **WP-S5-04** (human checks) and **M-EYAL-INPUTS**.
