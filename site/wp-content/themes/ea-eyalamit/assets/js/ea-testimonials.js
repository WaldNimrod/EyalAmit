/**
 * ea-testimonials.js — WP-W2-14-C Home review fix.
 *
 * Turns the server-rendered testimonials card list (block-testimonials-row.php,
 * rendered with the `rotator` context flag) into an auto-advancing 1-up rotator:
 *   - one quote visible at a time, transform-based slide on the track;
 *   - RTL-correct: slide sign is derived from the computed `direction`, so the
 *     same code works in RTL (default) and LTR;
 *   - dots (role=tablist) for direct navigation;
 *   - auto-advance every ~5s, paused on hover / focus / pointer-down;
 *   - prefers-reduced-motion → no autoplay, no transition; the first slide is
 *     shown statically (also enforced by CSS as a no-JS fallback).
 *
 * No new @keyframes / tokens — motion reuses the CSS transition built from
 * --ea-dur-* / --ea-ease-*. Progressive enhancement: with JS off, CSS shows the
 * first card and hides the rest, so the section never collapses.
 *
 * @package ea_eyalamit
 */
(function () {
	'use strict';

	function initRotator( root ) {
		var track = root.querySelector( '.ea-testimonials-track' );
		var dotsWrap = root.querySelector( '.ea-testimonials-dots' );
		if ( ! track || ! dotsWrap ) {
			return;
		}

		var cards = Array.prototype.slice.call(
			track.querySelectorAll( '.ea-testimonial-card' )
		);
		var len = cards.length;
		if ( len < 2 ) {
			// Nothing to rotate — leave the single card as-is.
			root.classList.add( 'is-rotator-ready' );
			return;
		}

		var motionOK = ! window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
		var index = 0;
		var timer = null;
		var paused = false;

		// RTL-correct sign: in RTL the track must move toward the inline-start
		// (positive translateX); in LTR toward negative translateX.
		function rtlSign() {
			return getComputedStyle( track ).direction === 'rtl' ? 1 : -1;
		}

		// Build the dots.
		var dots = [];
		cards.forEach( function ( card, n ) {
			var dot = document.createElement( 'button' );
			dot.className = 'ea-testimonials-dot';
			dot.type = 'button';
			dot.setAttribute( 'aria-label', 'המלצה ' + ( n + 1 ) );
			dot.addEventListener( 'click', function () {
				go( n, true );
			} );
			dotsWrap.appendChild( dot );
			dots.push( dot );
		} );

		function setDots() {
			dots.forEach( function ( dot, n ) {
				dot.setAttribute( 'aria-current', n === index ? 'true' : 'false' );
			} );
		}

		function apply() {
			var w = root.querySelector( '.ea-testimonials-viewport' );
			var vw = ( w || root ).clientWidth;
			track.style.transform = 'translateX(' + ( rtlSign() * index * vw ) + 'px)';
		}

		function go( n, isUser ) {
			index = ( ( n % len ) + len ) % len;
			apply();
			setDots();
			if ( isUser ) {
				restart();
			}
		}

		function next() {
			go( index + 1 );
		}

		function start() {
			if ( timer || ! motionOK ) {
				return;
			}
			timer = window.setInterval( function () {
				if ( ! paused ) {
					next();
				}
			}, 5000 );
		}

		function stop() {
			if ( timer ) {
				window.clearInterval( timer );
				timer = null;
			}
		}

		function restart() {
			stop();
			start();
		}

		// Pause on hover / focus / active pointer; resume on leave / blur.
		[ 'mouseenter', 'focusin', 'pointerdown' ].forEach( function ( evt ) {
			root.addEventListener( evt, function () {
				paused = true;
			}, { passive: true } );
		} );
		[ 'mouseleave', 'focusout' ].forEach( function ( evt ) {
			root.addEventListener( evt, function () {
				paused = false;
			} );
		} );

		window.addEventListener( 'resize', apply );

		root.classList.add( 'is-rotator-ready' );
		setDots();
		apply();
		start();
	}

	function init() {
		var roots = document.querySelectorAll( '[data-testi-rotator]' );
		Array.prototype.forEach.call( roots, initRotator );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
})();
