/**
 * QR embed facade (WP-S5-06) — swap the poster for the real nocookie player on
 * click. Vanilla, no deps, footer-loaded, QR views only.
 */
(function () {
	'use strict';

	var ALLOW = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';

	function activate(btn) {
		var id = btn.getAttribute('data-ea-qr-video');
		if (!id || !/^[A-Za-z0-9_-]{6,}$/.test(id)) {
			return;
		}
		var box = btn.parentNode;
		if (!box) {
			return;
		}
		var f = document.createElement('iframe');
		// nocookie is non-negotiable (privacy) — see LOD400 §5.2.
		f.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) + '?autoplay=1';
		f.title = btn.getAttribute('aria-label') || 'YouTube video';
		f.setAttribute('loading', 'lazy');
		f.setAttribute('frameborder', '0');
		f.setAttribute('allow', ALLOW);
		f.setAttribute('allowfullscreen', '');
		// tabindex="-1" is REQUIRED: focus() on a freshly-inserted iframe is not
		// reliably honoured across browsers without it (the element is not yet a
		// focusable target). Set it BEFORE replaceChild.
		f.setAttribute('tabindex', '-1');
		box.replaceChild(f, btn);
		// Keyboard users must land in the player they just activated.
		f.focus({ preventScroll: true });
	}

	document.addEventListener('click', function (e) {
		var btn = e.target.closest ? e.target.closest('.ea-qr-facade') : null;
		if (btn) {
			e.preventDefault();
			activate(btn);
		}
	});

	// hqdefault exists for every public video, but never leave a broken poster.
	document.addEventListener(
		'error',
		function (e) {
			var t = e.target;
			if (t && t.classList && t.classList.contains('ea-qr-facade__thumb')) {
				t.style.display = 'none';
			}
		},
		true
	);
})();
