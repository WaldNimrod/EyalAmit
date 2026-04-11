/**
 * books-reveal.js — Scroll-reveal for books section.
 * Design System D-EYAL-DESIGN-STYLE-13: elements enter with a gentle upward
 * drift (translateY 30px → 0, opacity 0 → 1, 0.8s ease).
 * IntersectionObserver threshold: 0.15 (per spec).
 *
 * Once visible, the element is unobserved — animation runs once only.
 * Falls back gracefully when IntersectionObserver is unavailable (shows all).
 *
 * @package ea_eyalamit
 */
( function () {
	'use strict';

	var els = document.querySelectorAll( '.reveal' );
	if ( ! els.length ) {
		return;
	}

	// Graceful fallback — show all immediately if no IntersectionObserver.
	if ( ! ( 'IntersectionObserver' in window ) ) {
		els.forEach( function ( el ) {
			el.classList.add( 'visible' );
		} );
		return;
	}

	var observer = new IntersectionObserver(
		function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'visible' );
					observer.unobserve( entry.target );
				}
			} );
		},
		{ threshold: 0.15 }
	);

	els.forEach( function ( el ) {
		observer.observe( el );
	} );
} )();
