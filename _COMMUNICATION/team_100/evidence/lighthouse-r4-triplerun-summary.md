# Lighthouse Triple-Run — R4 Perf Verification

**URL:** https://eyalamit-co-il-2026.s887.upress.link/wave2-test/
**Method:** 3 consecutive runs with cache-bust query
**Optimizations applied:**
- wp-block-library + wp-block-library-theme + classic-theme-styles + global-styles DEQUEUED on Wave2 templates
- wp-emoji detection script + inline styles REMOVED on Wave2 templates
- contact-form-7-css DEQUEUED on non-contact Wave2 templates
- <audio> element removed from block-topnav.php (404 reference eliminated)

**Sub-agent:** H (Haiku, R4 perf measurement)
**Date:** 2026-05-27

---

## Triple-Run Results

| Run | Perf Score | A11y Score | Server Response (ms) | FCP | LCP |
|-----|-----------|-----------|------|-----|-----|
| 1 | 87 | 100 | 683 | 3.2s | 3.2s |
| 2 | 87 | 100 | 626 | 3.2s | 3.2s |
| 3 | 87 | 100 | 634 | 3.2s | 3.2s |

**Average Performance Score:** 87
**Average A11y Score:** 100
**Average Server Response Time:** 648 ms (range: 626–683 ms, σ ≈ 32 ms)
**Redirects:** 0 (all runs)

---

## VC-7 R4 Assessment

**Criterion:** avg perf ≥85 AND min-run-perf ≥80 AND a11y always 100

✅ **PASS**
- Avg perf: **87** ≥ 85 ✓
- Min run perf: **87** ≥ 80 ✓
- A11y all runs: **100** ✓

**Variance:** Minimal (all runs scored 87/100). Server response time remains the primary latency driver (648 ms average), consistent with prior measurements (team_190 observed similar variance 83–90 range).

---

## R4 Optimization Verdict

The dequeue of CSS libraries (wp-block-library, global-styles) and removal of wp-emoji detection script successfully maintained/stabilized performance at 87 mobile. Audio 404 elimination removed unused asset load. CDN cache-bust prevents stale edge responses.

**Recommendation:** R4 optimizations APPROVED for VC-7 handoff. Perf score stable and above threshold. A11y perfect across runs.
