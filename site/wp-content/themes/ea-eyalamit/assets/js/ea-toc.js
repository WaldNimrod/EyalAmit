/**
 * EA — Chapters table of contents.
 *
 * Three states of the same navigation (inline / rail / mobile sheet), ported
 * from _COMMUNICATION/team_100/S007/SKETCH-TOC-ELEMENT-2026-09-18.html.
 *
 * - IntersectionObserver on .toc-inline toggles .rail.is-on so the two are
 *   never on screen together (visibility + opacity, not display).
 * - A second observer marks the current section on the rail (.on).
 * - Native <dialog> sheet: showModal, close button, backdrop click, link click.
 *   Dialog handling follows assets/js/ea-lightbox.js (feature-detect, degrade).
 *
 * No-ops when the part is not on the page.
 *
 * @package ea_eyalamit
 */
( function () {
	'use strict';

	var roots = document.querySelectorAll( '.ea-toc' );
	if ( ! roots.length ) {
		return;
	}

	Array.prototype.forEach.call( roots, function ( root ) {
		var inline = root.querySelector( '.toc-inline' );
		var rail = root.querySelector( '.rail' );
		var fab = root.querySelector( '.toc-fab' );
		var sheet = root.querySelector( '.sheet' );

		if ( fab && sheet && typeof HTMLDialogElement !== 'undefined' ) {
			fab.addEventListener( 'click', function () {
				sheet.showModal();
			} );
			var closeBtn = sheet.querySelector( '.sheet__x' );
			if ( closeBtn ) {
				closeBtn.addEventListener( 'click', function () {
					sheet.close();
				} );
			}
			sheet.addEventListener( 'click', function ( e ) {
				if ( e.target === sheet ) {
					sheet.close();
				}
			} );
			Array.prototype.forEach.call( sheet.querySelectorAll( 'a' ), function ( a ) {
				a.addEventListener( 'click', function () {
					sheet.close();
				} );
			} );
		}

		if ( ! inline || ! rail || typeof IntersectionObserver === 'undefined' ) {
			return;
		}

		/* The rail appears only once the inline list has scrolled away — never both
		   at once. visibility (not display) so the transition runs, and so it is
		   out of the tab order while hidden rather than being a set of focusable
		   links nobody can see. */
		new IntersectionObserver( function ( es ) {
			if ( ! es.length ) {
				return;
			}
			rail.classList.toggle( 'is-on', ! es[ 0 ].isIntersecting );
		}, { threshold: 0 } ).observe( inline );

		/* The rail marks where you are. Observe this instance's targets only, so a
		   reusable part does not highlight against unrelated section[id]s. */
		var links = [].slice.call( rail.querySelectorAll( 'a' ) );
		if ( ! links.length ) {
			return;
		}
		var obs = new IntersectionObserver( function ( es ) {
			es.forEach( function ( e ) {
				if ( ! e.isIntersecting ) {
					return;
				}
				links.forEach( function ( l ) {
					l.classList.toggle( 'on', l.getAttribute( 'href' ) === '#' + e.target.id );
				} );
			} );
		}, { rootMargin: '-45% 0px -45% 0px' } );
		links.forEach( function ( l ) {
			var href = l.getAttribute( 'href' ) || '';
			var id = href.charAt( 0 ) === '#' ? href.slice( 1 ) : '';
			var target = id ? document.getElementById( id ) : null;
			if ( target ) {
				obs.observe( target );
			}
		} );
	} );
}() );
