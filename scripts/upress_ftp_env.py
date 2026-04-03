"""
Shared uPress FTP helpers — local/.env.upress + FTPS with TLS session reuse (v2 §2.2).

Governance: docs/project/UPRESS_WORDPRESS_STANDARD_v2.md
Requires: pip install -r scripts/requirements-upress.txt
"""
from __future__ import annotations

import ftplib
import os
from pathlib import Path, PurePosixPath

try:
    from dotenv import load_dotenv
except ImportError as e:
    raise SystemExit(
        "Missing python-dotenv. Run: pip install -r scripts/requirements-upress.txt"
    ) from e


class ReusedSessionFTP_TLS(ftplib.FTP_TLS):
    """uPress-compatible FTPS: TLS session reuse on data channels (standard v2 §2.2)."""

    def ntransfercmd(self, cmd, rest=None):
        conn, size = ftplib.FTP.ntransfercmd(self, cmd, rest)
        if self._prot_p:
            conn = self.context.wrap_socket(
                conn,
                server_hostname=self.host,
                session=self.sock.session,
            )
        return conn, size


def repo_root() -> Path:
    return Path(__file__).resolve().parents[1]


def env_file_path() -> Path:
    return repo_root() / "local" / ".env.upress"


def load_upress_dotenv() -> None:
    p = env_file_path()
    if not p.is_file():
        raise SystemExit(
            f"Missing {p} — create from §2 in docs/project/EYAL_ENV_VARS_REFERENCE.md → local/.env.upress. "
            "See docs/project/UPRESS_WORDPRESS_STANDARD_v2.md §12."
        )
    load_dotenv(p)


def _truthy(name: str, default: bool = True) -> bool:
    v = os.getenv(name)
    if v is None:
        return default
    return v.strip().lower() in ("1", "true", "yes", "on")


def ftp_ensure_cwd(ftp: ftplib.FTP, path: str) -> None:
    path = path.strip().replace("\\", "/")
    if path in ("", "/"):
        return
    parts = [p for p in path.split("/") if p and p != "."]
    for p in parts:
        try:
            ftp.cwd(p)
        except Exception:
            try:
                ftp.mkd(p)
            except Exception:
                pass
            ftp.cwd(p)


def ftp_cwd_to_wordpress_root(ftp: ftplib.FTP, remote_root: str) -> None:
    """From account login, cd to / then into remote_root if set (Eyal: public_html, etc.)."""
    ftp.cwd("/")
    rr = (remote_root or "").strip().replace("\\", "/")
    if rr and rr not in ("/", ""):
        ftp_ensure_cwd(ftp, rr.strip("/"))


def connect_ftp(*, timeout: int = 120) -> tuple[ftplib.FTP, str]:
    """
    Load .env.upress, connect with TLS or plain FTP per UPRESS_FTP_USE_TLS.
    Returns (ftp, remote_root) with CWD already at WordPress root.
    """
    load_upress_dotenv()
    host = os.getenv("UPRESS_SFTP_HOST", "").strip()
    user = os.getenv("UPRESS_SFTP_USER", "").strip()
    pw = os.getenv("UPRESS_SFTP_PASS", "")
    port = int(os.getenv("UPRESS_SFTP_PORT", "21").strip() or "21")
    if not host or not user:
        raise SystemExit(
            "UPRESS_SFTP_HOST and UPRESS_SFTP_USER must be set in local/.env.upress"
        )
    use_tls = _truthy("UPRESS_FTP_USE_TLS", default=True)
    remote_root = (os.getenv("UPRESS_FTP_REMOTE_ROOT") or "").strip().replace("\\", "/")

    if use_tls:
        ftp = ReusedSessionFTP_TLS()
        ftp.connect(host, port, timeout=timeout)
        ftp.login(user, pw)
        ftp.prot_p()
    else:
        ftp = ftplib.FTP()
        ftp.connect(host, port, timeout=timeout)
        ftp.login(user, pw)

    ftp_cwd_to_wordpress_root(ftp, remote_root)
    norm_root = remote_root if remote_root else "/"
    return ftp, norm_root


def eyal_hub_relative_path() -> str:
    load_upress_dotenv()
    return (os.getenv("UPRESS_EYAL_HUB_PATH") or "ea-eyal-hub").strip().strip("/")


def ftp_upload_file(ftp: ftplib.FTP, local: Path, remote_name: str) -> None:
    with open(local, "rb") as f:
        ftp.storbinary(f"STOR {remote_name}", f)


def ftp_cd_hub_subpath(ftp: ftplib.FTP, remote_root: str, hub_rel: str, rel_dir: str) -> None:
    """cd to WordPress root + hub_rel + rel_dir (rel_dir is posix, '' or 'a/b')."""
    ftp.cwd("/")
    ftp_cwd_to_wordpress_root(ftp, remote_root)
    ftp_ensure_cwd(ftp, hub_rel)
    rd = (rel_dir or "").strip().replace("\\", "/").strip("/")
    if rd:
        ftp_ensure_cwd(ftp, rd)


def ftp_list_hub_remote_files(ftp: ftplib.FTP, remote_root: str, hub_rel: str) -> set[str]:
    """
    All file paths under hub_rel, as posix relative paths (e.g. index.html, assets/hub.css).
    Directories are traversed; only regular files are collected.
    """
    found: set[str] = set()

    def walk(rel_dir: str) -> None:
        ftp_cd_hub_subpath(ftp, remote_root, hub_rel, rel_dir)
        try:
            raw_names = ftp.nlst()
        except ftplib.error_perm:
            return
        for raw in raw_names:
            name = PurePosixPath(raw).name
            if not name or name in (".", ".."):
                continue
            child_rel = f"{rel_dir}/{name}" if rel_dir else name
            ftp_cd_hub_subpath(ftp, remote_root, hub_rel, rel_dir)
            try:
                ftp.cwd(name)
                walk(child_rel)
                ftp_cd_hub_subpath(ftp, remote_root, hub_rel, rel_dir)
            except ftplib.error_perm:
                found.add(child_rel)

    walk("")
    return found


def ftp_delete_hub_file(ftp: ftplib.FTP, remote_root: str, hub_rel: str, rel_posix: str) -> None:
    """DELE a file under hub (rel_posix relative to hub root)."""
    rel_posix = rel_posix.replace("\\", "/").strip("/")
    if not rel_posix or ".." in PurePosixPath(rel_posix).parts:
        raise ValueError(f"invalid hub-relative path: {rel_posix!r}")
    parent = str(PurePosixPath(rel_posix).parent)
    name = PurePosixPath(rel_posix).name
    if parent == ".":
        parent = ""
    ftp_cd_hub_subpath(ftp, remote_root, hub_rel, parent)
    ftp.delete(name)


def get_db_triple_for_wp_config() -> tuple[str | None, str | None, str]:
    """DB_NAME, DB_USER, DB_PASSWORD from .env for wp-config sync."""
    load_upress_dotenv()
    pw = (os.getenv("UPRESS_DB_PASS") or "").strip()
    if not pw:
        raise SystemExit(
            "UPRESS_DB_PASS must be set in local/.env.upress for wp-config sync "
            "(see UPRESS_WORDPRESS_STANDARD_v2.md §12)."
        )
    name = (os.getenv("UPRESS_DB_NAME") or "").strip() or None
    user = (os.getenv("UPRESS_DB_USER") or "").strip() or None
    return name, user, pw


def get_wp_environment_type_for_wp_config() -> str:
    """
    Value for define( 'WP_ENVIRONMENT_TYPE', ... ) per WordPress docs.
    Allowed: local, development, staging, production.
    Default staging (uPress sandbox / non-production mirrors).
    """
    load_upress_dotenv()
    allowed = frozenset({"local", "development", "staging", "production"})
    raw = (os.getenv("UPRESS_WP_ENVIRONMENT_TYPE") or "staging").strip().lower()
    if raw not in allowed:
        raise SystemExit(
            "UPRESS_WP_ENVIRONMENT_TYPE must be one of: "
            + ", ".join(sorted(allowed))
            + " — see https://developer.wordpress.org/apis/wp-config-php/#wp-environment-type"
        )
    return raw
