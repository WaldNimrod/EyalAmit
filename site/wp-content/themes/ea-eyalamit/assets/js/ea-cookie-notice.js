/**
 * Wave B — measurement choice (accept / reject). Ignores legacy ea_cookie_notice_ack.
 * Writes localStorage + first-party cookie so PHP can gate wp_head on the next load.
 */
(function () {
	'use strict';
	var KEY = 'ea_cookie_cmp';
	var COOKIE = 'ea_cookie_cmp';
	var MAX_AGE = 31536000;

	function readChoice() {
		try {
			var ls = window.localStorage.getItem(KEY);
			if (ls === 'accept' || ls === 'reject') {
				return ls;
			}
		} catch (e) { /* private mode */ }
		var m = document.cookie.match(new RegExp('(?:^|; )' + COOKIE + '=([^;]*)'));
		if (m && (m[1] === 'accept' || m[1] === 'reject')) {
			return m[1];
		}
		return '';
	}

	function writeChoice(val) {
		try {
			window.localStorage.setItem(KEY, val);
		} catch (e) { /* private mode */ }
		document.cookie = COOKIE + '=' + val + ';path=/;max-age=' + MAX_AGE + ';SameSite=Lax';
	}

	function closeDialog(dlg) {
		if (typeof dlg.close === 'function' && dlg.open) {
			dlg.close();
		} else {
			dlg.removeAttribute('open');
		}
	}

	function boot() {
		var dlg = document.getElementById('ea-cookie-notice');
		if (!dlg) {
			return;
		}
		var existing = readChoice();
		if (existing === 'accept' || existing === 'reject') {
			writeChoice(existing);
			return;
		}
		function choose(val) {
			writeChoice(val);
			closeDialog(dlg);
			window.location.reload();
		}
		dlg.querySelectorAll('[data-ea-cookie-choice]').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var val = btn.getAttribute('data-ea-cookie-choice');
				if (val === 'accept' || val === 'reject') {
					choose(val);
				}
			});
		});
		if (typeof dlg.showModal === 'function') {
			dlg.showModal();
		} else {
			dlg.setAttribute('open', '');
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
