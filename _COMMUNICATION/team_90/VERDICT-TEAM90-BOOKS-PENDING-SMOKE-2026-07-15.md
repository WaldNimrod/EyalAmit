---
id: VERDICT-TEAM90-BOOKS-PENDING-SMOKE-2026-07-15
from_team: team_90
to_team: team_100
date: 2026-07-15
type: validation-verdict
engine: composer-2.5
builder_engine: cursor-grok-4.5
overall: PASS
---

# Smoke VALIDATE — books galleries + pending-approval (2026-07-15)

Staging: `http://eyalamit-co-il-2026.s887.upress.link`

| URL | Verdict |
|-----|---------|
| `/books/kushi-blantis/` | **PASS** — POC images `kushi-01` + `kushi-03` live; `mrng.to`; 0 mendele; FAQ details present |
| `/books/vekatavta/` | **PASS** — cover only (0 kushi cross); pending approval present; `mrng.to`; 0 mendele |
| `/books/tsva-bekahol/` | **PASS** — same as vekatavta for cross-clean + pending |
| `/snoring-sleep-apnea/` | **PASS** — pending slots + נחירות/דום/BMJ |

**Overall: PASS (4/4)**
