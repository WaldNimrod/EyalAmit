# Mandate — F-SEO-01 seo_probe sitemap HEAD resilience (DEFERRED)

| Field | Value |
|-------|--------|
| from | team_100 |
| to | team_110 |
| date | 2026-07-25 |
| status | **DEFERRED** — do not start until intake/cutover readiness pack is accepted as complete (team_00 sequencing: item 2 after item 3) |
| unblocks_after | `_COMMUNICATION/team_100/AEO-EYAL-INTAKE-AND-CUTOVER-READINESS-2026-07-25.md` marked ready (already authored); start only when team_00 says F-SEO-01 is next |

## Intent

`seo_probe.mjs` check 3 HEADs every sitemap URL and is slow/flaky (ConnectTimeout). Add timeout + limited retry; keep semantics (direct 200 required).

## Out of scope until unblocked

Do not implement in the AEO ratification / readiness session.
