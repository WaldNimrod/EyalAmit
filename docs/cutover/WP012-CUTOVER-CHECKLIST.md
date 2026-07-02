# WP012 — Production Cutover Checklist (robots.txt + AI-bot crawlability)

**Created:** 2026-07-03 (WP-W2-17 T6c) | **Status:** create-if-missing per LOD400 spec-validation remediation #5 — team_100 ratifies at completion.
**Scope:** this file covers the robots.txt swap and the AI-bot crawlability re-check that must run at production go-live (WP012). It is a **subset extract** of the full 15-point gated cutover sequence in `_COMMUNICATION/team_100/SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md` §6.3 ("Gated production cutover — Track B") and §7 (full 15-point checklist) — this file does not replace those, it operationalizes the robots.txt-specific steps named there (§6.3 step 8, §7 item 10 / umbrella AC-07).
**Ratification basis:** `_COMMUNICATION/team_100/DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md` D3 (ALLOW ALL, EXPLICIT, LOGGED — 10 ratified UAs).

---

## 1. Pre-condition (must be true before this checklist runs)

- All of §6.3 PRE-CUTOVER (steps 1–5) and DEPLOY + CONFIG TO PRODUCTION (steps 6–7) are complete: production WP has theme + mu-plugins + seeded content deployed, parity with staging verified, noindex/staging guards removed, real `WP_HOME`/`WP_SITEURL` (www canonical) set, valid production TLS live.
- Until this checklist runs, production/staging must still serve the **block-all** posture. Do NOT run step 2 below early.

## 2. Step: replace live robots.txt with the ratified production file

This is §6.3 step 8 ("Publish the REAL production robots.txt (NOT hub/dist block-all)"), expanded to an explicit runbook step:

1. Confirm the source file: `docs/cutover/robots-production.txt` (10 ratified-UA Allow stanzas + catch-all `User-agent: * / Allow: /` + `Sitemap: https://www.eyalamit.co.il/sitemap_index.xml`).
2. **Re-verify UA tokens** against current vendor documentation before use (tokens drift — Googlebot/Bingbot/GPTBot/OAI-SearchBot/ChatGPT-User/ClaudeBot/Claude-SearchBot/Claude-User/PerplexityBot/Perplexity-User). Update `docs/cutover/robots-production.txt` first if any token has changed, then proceed.
3. Identify the live root `robots.txt` location on the production WP docroot (FTP-inspect; do not assume — this is the same provenance question raised as C-1 in WP-W2-17 T6(b), resolved for the production host at this step).
4. Upload/replace the production root `robots.txt` with the contents of `docs/cutover/robots-production.txt` **manually or via a one-off cutover deploy action** — this file must NOT be added to any repeatable deploy/publish script (`ftp_deploy_site_wp_content.py`, `ftp_publish_eyal_client_hub.py`, `build_eyal_client_hub.py`). It is a cutover-time-only, hand-executed swap.
5. Confirm the file that was actually deployed to `hub/dist/robots.txt` (block-all) is **unaffected** by this step — that artifact stays as the hub's own robots.txt, on the hub's separate deploy path (`ftp_publish_eyal_client_hub.py`), and is never confused with the production site's robots.txt.
6. Verify: `curl -s https://www.eyalamit.co.il/robots.txt` returns the new file content (10 Allow stanzas + catch-all Allow + Sitemap line) — NOT `User-agent: * / Disallow: /`.

## 3. Step: AI-bot crawlability curl matrix (production, post-swap)

Supersedes the 7-UA matrix in `SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md` §5 (lines ~116–123), which pre-dates the D3 ratification and lists only 7 UAs (`OAI-SearchBot`, `ChatGPT-User`, `PerplexityBot`, `Claude-SearchBot`, `Claude-User`, `GPTBot`, `Google-Extended`). **This checklist is the superseding version — it runs the full ratified 10-UA list** (adds `Googlebot`, `Bingbot`, `ClaudeBot`; drops the non-ratified `Google-Extended` token in favor of the 10 UAs named in DECISION D3 and WP-W2-17 T6(a)). Run this instead of the §5 matrix at cutover; do not run the stale 7-UA version.

```bash
BASE="https://www.eyalamit.co.il"

for UA in "Googlebot" "Bingbot" "GPTBot" "OAI-SearchBot" "ChatGPT-User" \
          "ClaudeBot" "Claude-SearchBot" "Claude-User" \
          "PerplexityBot" "Perplexity-User"; do
  for U in / /treatment/ /sleep-apnea-snoring/ ; do   # use the real pillar slug per WP-03 decision
    code=$(curl -s -A "$UA" -o /dev/null -w "%{http_code}" "$BASE$U")
    echo "$UA $U -> $code"   # expect 200, never 403/blocked
  done
done
```

**Pass condition:** every UA × route combination returns **HTTP 200** — never 403 or any block signal (CDN/WAF must not eat the AI UAs). This is the umbrella AC-07 day-one check, re-scoped to the ratified 10-UA list.

**Re-verify UA tokens at cutover time** — vendor UA strings can change; confirm each token against current vendor docs before relying on a 200 as a pass.

## 4. Sitemap cross-check (run alongside the robots.txt swap)

- Confirm the `Sitemap:` line in the deployed production `robots.txt` names exactly `https://www.eyalamit.co.il/sitemap_index.xml`.
- Confirm this is the **single agreed sitemap URL** across robots.txt + any legacy 301 target + GSC submission (per validation plan §8 item 2 / §7 item 8) — do not let multiple sitemap URLs disagree.

## 5. Post-condition / rollback note

- If any UA in the §3 matrix returns non-200 after the swap, do NOT leave the block-all robots.txt down — investigate CDN/WAF/hosting-level blocks first (this is typically a hosting config issue, not a robots.txt content issue), fix, and re-run the full matrix before closing this checklist item.
- This checklist item is one line item within the full §7 15-point cutover checklist (`SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md` §7, item 10 = "robots AI-bot 200 check"); it does not stand alone — the full cutover is not signed off until all 15 items in §7 pass, including `final_pre_cutover_check.sh` exit 0 and team_190 + Eyal/team_00 go-live approval.
