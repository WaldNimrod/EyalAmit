---
deviation_id: DEVIATION-B-PREP-6-FTP-BLOCK-2026-05-26
raised_by: team_10
routed_to: team_110
date: 2026-05-26
task: B-PREP-6
severity: MEDIUM
status: CLOSED — resolved 2026-05-26
---

# Deviation Report — B-PREP-6 FTPS Block

## Summary
FTP port 21 is unreachable from the execution machine during FTPS verification of the uPress staging account. This blocks B-PREP-6 and may block future FTP-dependent deployment tasks in Wave2 Stage B.

## Observed Behavior
- DNS resolution: `ftp.s887.upress.link → 185.201.148.144` ✅
- TCP port 21: **TIMEOUT** (connection refused/no response)
- Also tested: ports 990 (FTPS implicit), 2121 (alt FTP), 22 (SFTP) — all timeout
- Both `ftplib.FTP_TLS` and plain `ftplib.FTP` attempted — both failed at TCP connect stage

## Likely Causes
1. **Local network/ISP filters outbound FTP** — common on corporate or residential networks
2. **uPress IP whitelist on staging FTP** — uPress may restrict FTP access by IP for security
3. **uPress panel FTP toggle** — FTP may be disabled in the staging account panel

## Historical Context
Previous successful FTP operations on this project used `scripts/ftp_deploy_site_wp_content.py`. Those sessions may have run from a different network or IP.

## Resolution Options (for Team 110 to assess)

| Option | Action | Owner |
|--------|--------|-------|
| A | Check uPress panel for FTP IP whitelist → add current outbound IP | Eyal / Team 110 |
| B | Test FTP from a different network (mobile hotspot) to isolate ISP filtering | Team 60 |
| C | Enable SFTP on uPress panel if available (prefer SFTP over FTP) | Eyal |
| D | Use WP REST API for all file operations (already the primary method per project toolchain) | Team 20 |

## Impact
- B-PREP-6 AC: **BLOCKED**
- Wave2 Stage B: FTP-based theme file deployment may be affected if issue persists
- Mitigation: WP REST API + Application Passwords are already the primary toolchain; FTP is secondary

## Request to Team 110
Please assess and recommend resolution path. If Option D (REST API only) is approved as the going-forward standard, B-PREP-6 can be closed as "FTP deprecated — REST API is canonical."

---

*Raised by team_10 · 2026-05-26*
