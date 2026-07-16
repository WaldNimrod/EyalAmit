#!/usr/bin/env python3
"""
WP-W2-09 (team_20) — Clean-regenerate the .htaccess 301 block from the 135-decision
JSON SSoT (approach B, DECISION_W2-09-301-REDIRECT-APPROACH_2026-05-30_v1).

Reads:  hub/data/decisions/redirects-301-eyal-final-2026-05-27.json (135 decisions)
Writes: _COMMUNICATION/team_100/tools/htaccess_301_block.txt (marker-wrapped block)

Rules (authoritative — see mandate + DECISION):
  * decided_status == "301" (27) -> `Redirect 301 <legacy-path> <target>`.
      target = decided_target_slug -> /<slug>/  (or nested if slug contains "/")
             | decided_custom_url (if a real new-site path)
             | EMPTY -> obvious new-site equivalent (EMPTY_TARGET_MAP, never lazy "/").
  * decided_status == "410" (1: "פרק א") -> `Redirect 410 <legacy-path>`.
  * manual (3): /thankyou -> 410 ; /מפת-אתר-site-map -> /sitemap_index.xml ;
                /shop/תקנון -> / (interim, FLAGGED for Eyal).
  * keep (54) + is_qr_protected (49 /qr/qrN/) + empty(1, old home "/") -> NO rule (stay live 200).
  * W2-06 blog catch-all RewriteRule ^Blog/(.+)$ /$1 [R=301,L,NC] is preserved.

De-conflict guard (mandatory): drop+log any rule whose SOURCE path matches a live
Wave2 canonical (incl. the legacy /shop/* -> /books/ rules). De-dup identical sources.
Assert no rule's target is also a redirected source (no chains/loops within the block).

Legacy paths in old_url are percent-encoded Hebrew — exact encoding is preserved verbatim.
"""
from __future__ import annotations

import json
import sys
from pathlib import Path
from urllib.parse import urlsplit

ROOT = Path(__file__).resolve().parents[1]
SRC = ROOT / "hub/data/decisions/redirects-301-eyal-final-2026-05-27.json"
OUT = ROOT / "_COMMUNICATION/team_100/tools/htaccess_301_block.txt"

BEGIN = "# BEGIN EA-W2-06 301"   # same markers the SAFE deployer replaces idempotently
END = "# END EA-W2-06 301"

# Live Wave2 canonical path PREFIXES/exacts that a generated SOURCE must never collide with.
# (Sources are full legacy Hebrew slugs except the /shop/* set — those collide and are dropped.)
CANONICAL_SOURCE_GUARD = (
    "/", "/shop", "/books", "/treatment", "/lessons", "/sound-healing",
    "/method", "/contact", "/press", "/en", "/qr", "/didgeridoos", "/bags",
    "/stands-storage", "/stand-floor", "/repair", "/blog", "/shows", "/muzza",
    "/about", "/terms",
)

# Empty-target 301s -> obvious new-site equivalent, keyed by the decision `slug`.
# Targets chosen to be the deepest stable live URL (verified 200/canonical on staging 2026-05-30).
EMPTY_TARGET_MAP = {
    # צור קשר
    "%d7%a6%d7%95%d7%a8-%d7%a7%d7%a9%d7%a8": "/contact/",
    # וכתבת אוטוביוגרפיה בסיפורים (book page)
    "%d7%95%d7%9b%d7%aa%d7%91%d7%aa-%d7%90%d7%95%d7%98%d7%95%d7%91%d7%99%d7%95%d7%92%d7%a8%d7%a4%d7%99%d7%94-%d7%91%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d": "/books/vekatavta/",
    # הופעות
    "%d7%94%d7%95%d7%a4%d7%a2%d7%95%d7%aa": "/shows/",
    # מוזה הוצאה לאור — DIRECT to /books/ (WP-W2-15-CR-FINAL F-CRF-02, 2026-06-05): /muzza is a
    # PERMANENT 301 to /books (functions.php ea_eyalamit_muzza_to_books_redirect, template_redirect
    # prio 0), so targeting /muzza here would create a 2-hop. Target /books directly. Do NOT revert.
    "%d7%9e%d7%95%d7%96%d7%94-%d7%94%d7%95%d7%a6%d7%90%d7%94-%d7%9c%d7%90%d7%95%d7%a8": "/books/",
    # כושי בלאנטיס אוטוביוגרפיה (book page) — DIRECT canonical (team_100 correction 2026-05-30, LIVE+verified)
    "%d7%9b%d7%95%d7%a9%d7%99-%d7%91%d7%9c%d7%90%d7%a0%d7%98%d7%99%d7%a1-%d7%90%d7%95%d7%98%d7%95%d7%91%d7%99%d7%95%d7%92%d7%a8%d7%a4%d7%99%d7%94-%d7%91%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d": "/books/kushi-blantis/",
    # שיעורי נגינה בדיגרידו
    "%d7%a9%d7%99%d7%a2%d7%95%d7%a8%d7%99-%d7%a0%d7%92%d7%99%d7%a0%d7%94-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95": "/lessons/",
    # סדנה עצמית לבניית דיגרידו
    "%d7%a1%d7%93%d7%a0%d7%90%d7%95%d7%aa-%d7%91%d7%a0%d7%99%d7%99%d7%94-%d7%a2%d7%a6%d7%9e%d7%99%d7%aa-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95": "/lessons/",
    # תיקון דיגרידו
    "%d7%aa%d7%99%d7%a7%d7%95%d7%9f-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95": "/repair/",
    # סאונד הילינג מדיטציית דיגרידו
    "%d7%a1%d7%90%d7%95%d7%a0%d7%93-%d7%94%d7%99%d7%9c%d7%99%d7%a0%d7%92-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%9e%d7%93%d7%99%d7%98%d7%a6%d7%99%d7%99%d7%aa-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93": "/sound-healing/",
    # אייל עמית אודות (about Eyal)
    "%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%95%d7%93%d7%95%d7%aa": "/about/",
}

# __CUSTOM__ targets whose decided_custom_url points at the OLD domain -> map to new-site page.
CUSTOM_NEWSITE_MAP = {
    # מוקש דהימן (master didgeridoo memorial) — DIRECT canonical. team_110 2026-06-21:
    # was "/about/moksha/" which itself 301s to the canonical (a 2-hop chain); point
    # straight at the approved canonical so the legacy deep-link is a single hop.
    "%d7%9e%d7%95%d7%a7%d7%a9-%d7%93%d7%94%d7%99%d7%9e%d7%9f-%d7%9e%d7%90%d7%a1%d7%98%d7%a8-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%93%d7%a3-%d7%9c%d7%94%d7%a0%d7%a6%d7%97%d7%aa-%d7%96%d7%9b": "/eyal-amit/mokesh-dahiman/",
}

# manual items -> explicit handling keyed by legacy path.
MANUAL_MAP = {
    "/thankyou/": ("410", None, "no Wave2 user registration (INGEST §2.1)"),
    # /מפת-אתר-site-map/ -> live Yoast sitemap (verified /sitemap_index.xml = 200; /sitemap.xml = 404)
    "/%d7%9e%d7%a4%d7%aa-%d7%90%d7%aa%d7%a8-site-map/": ("301", "/sitemap_index.xml", "Yoast sitemap index (sitemap.xml not present)"),
    # /shop/תקנון/ -> / interim (mandate). FLAG: live /terms/ page exists (better target, await Eyal).
    "/shop/%d7%aa%d7%a7%d7%a0%d7%95%d7%9f/": ("301", "/", "interim per mandate — FLAG Eyal: /terms/ live page exists"),
}

# Legacy WooCommerce sub-URLs (cart/checkout/account) — not in the decisions JSON, or dropped by the
# /shop canonical guard. They 404 on the new site; redirect to the live /shop/ archive (cutover finding #3).
EXTRA_301 = {
    "/shop/cart/": "/shop/",
    "/shop/checkout/": "/shop/",
    "/shop/my-account/": "/shop/",
}


def legacy_path(old_url: str) -> str:
    """Path component, percent-encoding preserved exactly as stored."""
    return urlsplit(old_url).path


def target_for_slug(slug: str) -> str:
    """decided_target_slug -> home-relative path. Supports nested 'books/vekatavta'."""
    s = slug.strip("/")
    return "/" + s + "/"


def collides_canonical(src_path: str) -> str | None:
    """Return the matched canonical guard token if src collides, else None."""
    sp = src_path.rstrip("/") or "/"
    for tok in CANONICAL_SOURCE_GUARD:
        if tok == "/":
            if sp == "/":
                return tok
            continue
        # collide if src equals the canonical or is exactly that canonical (no deeper legacy slug)
        if sp == tok:
            return tok
        # /shop/cart, /shop/checkout, /shop/my-account -> drop (shop catalog conflict)
        if tok == "/shop" and sp.startswith("/shop/") and "%" not in sp.split("/shop/")[1]:
            return tok
    return None


def main() -> int:
    data = json.loads(SRC.read_text(encoding="utf-8"))
    items = data["decisions"]

    rules: list[tuple[str, str, str | None, str]] = []  # (kind, source, target, note)
    dropped: list[tuple[str, str, str]] = []             # (source, reason, detail)
    flagged: list[str] = []

    seen_sources: set[str] = set()

    for it in items:
        status = it["decided_status"]
        src = legacy_path(it["old_url"])
        slug = it["slug"]
        tgt_slug = (it.get("decided_target_slug") or "").strip()
        custom = (it.get("decided_custom_url") or "").strip()

        if status == "" or it.get("is_qr_protected") or status == "keep":
            # empty(old home "/"), 49 QR, 54 keep -> NO rule.
            continue

        if status == "manual":
            if src not in MANUAL_MAP:
                dropped.append((src, "manual-unmapped", it["title"][:40]))
                continue
            mkind, mtgt, mnote = MANUAL_MAP[src]
            if mkind == "410":
                rules.append(("410", src, None, mnote))
            else:
                rules.append(("301", src, mtgt, mnote))
            flagged.append(f"manual {src} -> {mkind} {mtgt or ''} ({mnote})")
            continue

        if status == "410":
            rules.append(("410", src, None, "Gone (פרק א)"))
            continue

        if status == "301":
            # de-conflict guard first
            hit = collides_canonical(src)
            if hit is not None:
                dropped.append((src, f"canonical-collision:{hit}", f"target_slug={tgt_slug or custom or '(empty)'}"))
                continue

            # resolve target
            if tgt_slug == "__CUSTOM__":
                tgt = CUSTOM_NEWSITE_MAP.get(slug)
                if not tgt:
                    dropped.append((src, "custom-unmapped", custom[:60]))
                    continue
                note = "custom->newsite"
            elif tgt_slug:
                tgt = target_for_slug(tgt_slug)
                note = f"slug:{tgt_slug}"
            elif custom and custom.startswith("/"):
                tgt = custom
                note = "custom-path"
            else:
                tgt = EMPTY_TARGET_MAP.get(slug)
                if not tgt:
                    dropped.append((src, "empty-unmapped", it["title"][:40]))
                    continue
                note = "empty->equiv"
            rules.append(("301", src, tgt, note))
            continue

        dropped.append((src, f"unknown-status:{status}", ""))

    # legacy WooCommerce sub-URLs -> live /shop/ (explicit; bypass the /shop canonical guard — safe: not live pages)
    for _s, _t in EXTRA_301.items():
        rules.append(("301", _s, _t, "legacy woo -> /shop/"))

    # de-dup identical sources (keep first)
    deduped: list[tuple[str, str, str | None, str]] = []
    for r in rules:
        if r[1] in seen_sources:
            dropped.append((r[1], "duplicate-source", r[3]))
            continue
        seen_sources.add(r[1])
        deduped.append(r)
    rules = deduped

    # loop/chain assertion: no target is also a redirected source
    src_set = {r[1].rstrip("/") for r in rules}
    for kind, src, tgt, note in rules:
        if tgt and tgt.rstrip("/") in src_set:
            raise SystemExit(f"LOOP: target {tgt} is also a redirected source ({src})")

    # emit block.
    # NOTE: legacy sources are percent-encoded Hebrew. The uPress stack (nginx -> Apache)
    # may present %{REQUEST_URI} either still-encoded (/%d7..) OR already URL-decoded to
    # literal UTF-8 Hebrew. To be robust to both, each rule matches an ALTERNATION of the
    # encoded form and the decoded (UTF-8 literal) form against %{REQUEST_URI}. Matching
    # happens inside mod_rewrite, before the WP front controller. 410 via [G].
    from urllib.parse import unquote

    def _esc(s: str) -> str:
        # escape regex metacharacters that can appear in a path (only '.' is realistic here)
        out = []
        for ch in s:
            if ch in ".^$*+?()[]{}|\\":
                out.append("\\" + ch)
            else:
                out.append(ch)
        return "".join(out)

    lines: list[str] = []
    lines.append(f"{BEGIN}  (regenerated from 135-decision JSON SSoT; approach B; team_20 2026-05-30)")
    lines.append("<IfModule mod_rewrite.c>")
    lines.append("RewriteEngine On")
    lines.append("# W2-06 blog catch-all: legacy /Blog/<slug>/ -> /blog/<slug>/")
    lines.append("RewriteRule ^Blog/(.+)$ /blog/$1 [R=301,L,NC]")
    lines.append("# --- page-level 301/410 redirects (generated from decisions JSON SSoT) ---")
    lines.append("# Bare RewriteRule on the per-directory relative path (same mechanism as the")
    lines.append("# working ^Blog/ rule): the relative path keeps the percent-encoding verbatim.")

    def rel_pattern(src: str) -> str:
        # per-directory match: leading slash stripped, encoding preserved. anchor both ends.
        return "^" + _esc(src.lstrip("/")) + "$"

    n301 = n410 = 0
    for kind, src, tgt, note in rules:
        if kind == "301":
            n301 += 1
            lines.append(f"RewriteRule {rel_pattern(src)} {tgt} [R=301,L]")
        else:
            n410 += 1
            lines.append(f"RewriteRule {rel_pattern(src)} - [G,L]")
    lines.append("</IfModule>")
    lines.append(END)
    block = "\n".join(lines) + "\n"

    OUT.write_text(block, encoding="utf-8")

    # ------------------------------------------------------------------
    # Also emit a PHP mu-plugin redirect map. On the uPress stack (nginx +
    # AllowOverride None) Apache .htaccess RewriteRules are IGNORED; the live
    # redirect mechanism is the PHP `template_redirect` table (see existing
    # ea-m2-site-tree-lock-sync-once.php). We mirror the SAME 135-decision map
    # into a self-contained mu-plugin keyed on the rawurldecode()d path.
    # The .htaccess block above is retained as documentation / SSoT + a no-op
    # safety net should AllowOverride ever be enabled.
    # ------------------------------------------------------------------
    from urllib.parse import unquote

    php_301: list[tuple[str, str]] = []  # (decoded_legacy_path, target)
    php_410: list[str] = []
    for kind, src, tgt, note in rules:
        dec = unquote(src)
        if not dec.endswith("/"):
            dec += "/"
        if kind == "301":
            php_301.append((dec, tgt))
        else:
            php_410.append(dec)

    def php_q(s: str) -> str:
        return "'" + s.replace("\\", "\\\\").replace("'", "\\'") + "'"

    pl: list[str] = []
    pl.append("<?php")
    pl.append("/**")
    pl.append(" * Plugin Name: EA W2-09 — Legacy 301/410 map (generated)")
    pl.append(" * Description: GENERATED by scripts/gen_htaccess_301_from_decisions.py from")
    pl.append(" *   hub/data/decisions/redirects-301-eyal-final-2026-05-27.json (135 decisions, approach B).")
    pl.append(" *   DO NOT hand-edit. .htaccess is inert on this stack (nginx); PHP is the live mechanism.")
    pl.append(" * Version: 1.0.0")
    pl.append(" */")
    pl.append("defined( 'ABSPATH' ) || exit;")
    pl.append("")
    pl.append("function ea_w209_legacy_redirects() {")
    pl.append("\tif ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) { return; }")
    pl.append("\t$uri = isset( $_SERVER['REQUEST_URI'] ) ? rawurldecode( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';")
    pl.append("\tif ( $uri === '' ) { return; }")
    pl.append("\t$path = (string) wp_parse_url( $uri, PHP_URL_PATH );")
    pl.append("\tif ( $path === '' ) { return; }")
    pl.append("\t$norm = trailingslashit( $path );")
    pl.append("")
    pl.append("\t// 410 Gone")
    pl.append("\t$gone = array(")
    for d in php_410:
        pl.append(f"\t\t{php_q(d)},")
    pl.append("\t);")
    pl.append("\tif ( in_array( $norm, $gone, true ) ) {")
    pl.append("\t\tstatus_header( 410 ); header( 'X-EA-Redirect: w209-410' ); nocache_headers();")
    pl.append("\t\texit;")
    pl.append("\t}")
    pl.append("")
    pl.append("\t// 301 legacy -> new")
    pl.append("\t$map = array(")
    for d, t in php_301:
        pl.append(f"\t\t{php_q(d)} => {php_q(t)},")
    pl.append("\t);")
    pl.append("")
    pl.append("\t// W2-06 blog migration: legacy /Blog/<slug> (capital B) -> /blog/<slug> (regex prefix;")
    pl.append("\t// the exact-match $map cannot express a prefix). Lowercase /blog/ won't match -> no loop.")
    pl.append("\t//")
    pl.append("\t// AN EXACT DECISION BEATS THE CATCH-ALL (WP-S5-03, 2026-07-16). The regex used to run")
    pl.append("\t// BEFORE $map and exit(), so an exact /Blog/<slug> rule was unreachable — the catch-all")
    pl.append("\t// always won. That silently dropped real content: a post RENAMED between the old and new")
    pl.append("\t// site got 301'd to /blog/<old-slug>, which 404s, because a prefix rewrite cannot follow a")
    pl.append("\t// rename. The full 406-URL triage found 4 live posts of Eyal's dead-ending exactly this way")
    pl.append("\t// (e.g. /Blog/את-הספר-החדש-שלי-לא-תמצאו-בחנויות-הספרי -> the live post is ...ברשתות...).")
    pl.append("\t// $map is now defined first and the regex yields to it. Do NOT reorder these back.")
    pl.append("\tif ( ! isset( $map[ $norm ] ) && preg_match( '#^/Blog/(.+)$#', $path, $m ) ) {")
    pl.append("\t\theader( 'X-EA-Redirect: w209-blog' );")
    pl.append("\t\twp_redirect( home_url( '/blog/' . $m[1] ), 301 );")
    pl.append("\t\texit;")
    pl.append("\t}")
    pl.append("\tif ( isset( $map[ $norm ] ) ) {")
    pl.append("\t\theader( 'X-EA-Redirect: w209-301' );")
    pl.append("\t\twp_redirect( home_url( $map[ $norm ] ), 301 );")
    pl.append("\t\texit;")
    pl.append("\t}")
    pl.append("}")
    pl.append("// priority 0: run before the site-tree canonical table (priority 1).")
    pl.append("add_action( 'template_redirect', 'ea_w209_legacy_redirects', 0 );")
    pl.append("")
    php_out = ROOT / "site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php"
    php_out.write_text("\n".join(pl), encoding="utf-8")
    print(f"WROTE {php_out.relative_to(ROOT)}  (PHP mu-plugin: {len(php_301)} 301 + {len(php_410)} 410)", file=sys.stderr)

    # report to stderr
    print(f"WROTE {OUT.relative_to(ROOT)}", file=sys.stderr)
    print(f"  301 rules: {n301}", file=sys.stderr)
    print(f"  410 rules: {n410}", file=sys.stderr)
    print(f"  total emitted: {n301 + n410}", file=sys.stderr)
    print(f"  dropped/skipped: {len(dropped)}", file=sys.stderr)
    for s, reason, detail in dropped:
        print(f"    DROP {reason}: {s}  [{detail}]", file=sys.stderr)
    print(f"  flagged for Eyal: {len(flagged)}", file=sys.stderr)
    for f in flagged:
        print(f"    FLAG {f}", file=sys.stderr)
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
