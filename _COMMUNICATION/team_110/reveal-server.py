#!/usr/bin/env python3
"""Tiny localhost companion server — reveals files in macOS Finder.

Usage (run once, keep open alongside the main gallery server):
  python3 _COMMUNICATION/team_110/reveal-server.py

The gallery's "פתח ב-Finder" button calls http://127.0.0.1:7772/?path=<encoded>.
If this server isn't running, the button falls back to copying the path to clipboard.
"""
from http.server import BaseHTTPRequestHandler, HTTPServer
from urllib.parse import urlparse, parse_qs, unquote
import subprocess, os

PORT = 7772


class RevealHandler(BaseHTTPRequestHandler):
    def do_GET(self):
        q = parse_qs(urlparse(self.path).query)
        path = unquote(q.get('path', [''])[0])
        ok = bool(path) and os.path.exists(path)
        if ok:
            subprocess.run(['open', '-R', path], check=False)
        self.send_response(200 if ok else 400)
        self.send_header('Access-Control-Allow-Origin', '*')
        self.send_header('Content-Type', 'text/plain; charset=utf-8')
        self.end_headers()
        msg = 'ok' if ok else f'not found: {path}'
        self.wfile.write(msg.encode())

    def log_message(self, fmt, *args):
        status = args[1] if len(args) > 1 else '?'
        print(f'[reveal] {status}  {args[0] if args else ""}')


if __name__ == '__main__':
    print(f'Reveal server listening on http://127.0.0.1:{PORT}/')
    print('Press Ctrl+C to stop.')
    HTTPServer(('127.0.0.1', PORT), RevealHandler).serve_forever()
