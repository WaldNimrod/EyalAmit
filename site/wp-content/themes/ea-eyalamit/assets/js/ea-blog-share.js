/**
 * WP-W2-11 S3 (Blog D) — copy-link share button.
 * Copies the post URL to the clipboard. Degrades gracefully when the
 * Clipboard API is unavailable (falls back to a hidden textarea + execCommand);
 * never throws, never logs console errors.
 */
( function () {
	'use strict';

	function flashLabel( btn ) {
		var original = btn.getAttribute( 'aria-label' );
		btn.setAttribute( 'aria-label', 'הקישור הועתק' );
		btn.classList.add( 'is-copied' );
		window.setTimeout( function () {
			btn.setAttribute( 'aria-label', original );
			btn.classList.remove( 'is-copied' );
		}, 1800 );
	}

	function legacyCopy( text ) {
		var ta = document.createElement( 'textarea' );
		ta.value = text;
		ta.setAttribute( 'readonly', '' );
		ta.style.position = 'absolute';
		ta.style.left = '-9999px';
		document.body.appendChild( ta );
		ta.select();
		var ok = false;
		try {
			ok = document.execCommand( 'copy' );
		} catch ( e ) {
			ok = false;
		}
		document.body.removeChild( ta );
		return ok;
	}

	function copyLink( btn ) {
		var text = btn.getAttribute( 'data-ea-copy-link' );
		if ( ! text ) {
			return;
		}
		if ( navigator.clipboard && navigator.clipboard.writeText ) {
			navigator.clipboard.writeText( text ).then(
				function () {
					flashLabel( btn );
				},
				function () {
					if ( legacyCopy( text ) ) {
						flashLabel( btn );
					}
				}
			);
		} else if ( legacyCopy( text ) ) {
			flashLabel( btn );
		}
	}

	function init() {
		var buttons = document.querySelectorAll( '[data-ea-copy-link]' );
		if ( ! buttons.length ) {
			return;
		}
		buttons.forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				copyLink( btn );
			} );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
