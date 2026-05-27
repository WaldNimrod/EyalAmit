# Lighthouse Mobile Audit (HTTPS direct, cert-bypass) — Stage B Smoke Page

**URL:** https://eyalamit-co-il-2026.s887.upress.link/wave2-test/  
**Form factor:** mobile  
**Chrome flags:** `--ignore-certificate-errors` (TLS deferred to M7 — environment workaround)  
**Sub-agent:** D2 (Haiku, re-run)  
**Date:** 2026-05-27  
**Compare against:** lighthouse-stage-b-2026-05-27.summary.md (HTTP entry, perf 81)

---

## Comparison: HTTP (redirect penalty) vs HTTPS (direct)

| Metric | HTTP (baseline) | HTTPS (direct) | Δ |
|--------|-----------------|----------------|---|
| **Performance Score** | 81/100 | **90/100** | +9 |
| **Accessibility Score** | 100/100 | **100/100** | — |
| **Redirects (ms)** | ~1093ms penalty | **0ms** | ✅ Eliminated |
| **FCP** | — | 2.9s (score: 54) | — |
| **LCP** | — | 2.9s (score: 81) | — |
| **Speed Index** | — | 3.0s (score: 94) | — |
| **Interactive (TTI)** | — | 2.9s (score: 96) | — |

---

## VC-7 Pass Criterion

**Requirement:** performance ≥85 AND accessibility ≥95

**Result:** **PASS ✅**

- Performance: 90/100 (exceeds ≥85 threshold by 5 points)
- Accessibility: 100/100 (exceeds ≥95 threshold)

---

## Key Findings

**Redirect Chain Impact:**  
The HTTP entry's 1093ms wasted in HTTP→HTTPS(cert-fail)→HTTP cascade is entirely eliminated when entering directly via HTTPS with cert-bypass. Performance improved from 81 → 90 (+11% relative gain).

**Core Web Vitals:**
- LCP (2.9s, score 81) is the main lever for further optimization post-M7 (server response time: 824ms primary opportunity).
- FCP (2.9s) reflects slow initial paint; aligns with TTFB constraint.
- Speed Index and TTI are solid (94 and 96 respectively).

**Accessibility:**  
Perfect score maintained (100/100) — no regression.

---

## Top Opportunity (post-M7 TLS fix)

1. **Reduce initial server response time:** 824ms potential savings
   - Requires backend optimization or CDN edge caching post-TLS cert renewal.

---

## Evidence Artifacts

- JSON report: `lighthouse-stage-b-https-2026-05-27.report.json` (366 KB)
- HTML report: `lighthouse-stage-b-https-2026-05-27.report.html` (461 KB)

---

## Tooling & Execution

- Lighthouse CLI v13.3.0 ✓
- Chromium headless + cert-bypass ✓
- Form factor: mobile ✓
- Categories: performance, accessibility ✓
