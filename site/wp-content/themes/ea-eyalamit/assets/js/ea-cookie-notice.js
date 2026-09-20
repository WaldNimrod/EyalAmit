/**
 * First-visit cookie/measurement notice. Acknowledgement only — does not
 * gate GA4, does not store consent categories (Wave B).
 */
(function () {
	'use strict';
	var KEY = 'ea_cookie_notice_ack';
	var dlg = document.getElementById('ea-cookie-notice');
	if (!dlg) {
		return;
	}
	function acknowledged() {
		try {
			return window.localStorage.getItem(KEY) === '1';
		} catch (e) {
			return false;
		}
	}
	function ack() {
		try {
			window.localStorage.setItem(KEY, '1');
		} catch (e) { /* private mode — notice may return next load */ }
		if (typeof dlg.close === 'function' && dlg.open) {
			dlg.close();
		} else {
			dlg.removeAttribute('open');
		}
	}
	if (acknowledged()) {
		return;
	}
	var btn = dlg.querySelector('[data-ea-cookie-ack]');
	if (btn) {
		btn.addEventListener('click', ack);
	}
	dlg.addEventListener('close', function () {
		try {
			window.localStorage.setItem(KEY, '1');
		} catch (e) {}
	});
	dlg.addEventListener('click', function (e) {
		if (e.target === dlg) {
			ack();
		}
	});
	if (typeof dlg.showModal === 'function') {
		dlg.showModal();
	} else {
		dlg.setAttribute('open', '');
	}
})();
