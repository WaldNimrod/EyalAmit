/**
 * ea-testi-mq.js — S006 wave 5. Idle hint animation added 2026-09-16 (Nimrod,
 * live in an Eyal meeting, same RTL fix session — see chapters.css).
 *
 * Manual left/right control for chapter testimonial strips (.testi-mq[data-testi-mq]).
 * Left button moves the strip left; right button moves it right.
 *
 * Before any user interaction, a gentle idle animation steps one card at a time
 * to the end and back (ping-pong), reusing the exact same apply()/step()/maxIndex()
 * math the buttons use — no separate positioning logic to get wrong. It pauses on
 * hover/focus/pointer and while scrolled out of view, and stops for good the moment
 * the user actually clicks a button (manual control wins from then on). Off when
 * prefers-reduced-motion is set, matching every other motion in this theme.
 *
 * @package ea_eyalamit
 */
(function () {
	'use strict';

	function init( root ) {
		var viewport = root.querySelector( '.testi-mq__viewport' );
		var track = root.querySelector( '.testi-mq__track' );
		var leftBtn = root.querySelector( '.testi-mq__btn--left' );
		var rightBtn = root.querySelector( '.testi-mq__btn--right' );
		if ( ! viewport || ! track ) {
			return;
		}

		var cards = track.querySelectorAll( '.tmq' );
		if ( cards.length < 2 ) {
			if ( leftBtn ) {
				leftBtn.hidden = true;
			}
			if ( rightBtn ) {
				rightBtn.hidden = true;
			}
			return;
		}

		var index = 0;

		function step() {
			var card = cards[0];
			var gap = parseFloat( window.getComputedStyle( track ).gap ) || 24;
			return card.getBoundingClientRect().width + gap;
		}

		function maxIndex() {
			var s = step();
			if ( s <= 0 ) {
				return 0;
			}
			var extra = track.scrollWidth - viewport.clientWidth;
			return extra <= 0 ? 0 : Math.ceil( extra / s );
		}

		function apply() {
			var max = maxIndex();
			if ( index < 0 ) {
				index = 0;
			}
			if ( index > max ) {
				index = max;
			}
			track.style.transform = 'translateX(' + ( -index * step() ) + 'px)';
			if ( leftBtn ) {
				leftBtn.disabled = index >= max;
			}
			if ( rightBtn ) {
				rightBtn.disabled = index <= 0;
			}
		}

		var motionOK = ! window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
		var idleTimer = null;
		var idleDirection = 1; // 1 = toward max (forward), -1 = back toward 0
		var idlePaused = false;
		var idleStopped = false;

		function idleStep() {
			if ( idleStopped || idlePaused ) {
				return;
			}
			var max = maxIndex();
			if ( max <= 0 ) {
				return; // everything already fits — nothing to ping-pong.
			}
			index += idleDirection;
			if ( index >= max ) {
				index = max;
				idleDirection = -1;
			} else if ( index <= 0 ) {
				index = 0;
				idleDirection = 1;
			}
			apply();
		}

		function startIdle() {
			if ( idleTimer || idleStopped || ! motionOK ) {
				return;
			}
			idleTimer = window.setInterval( idleStep, 2600 );
		}

		function stopIdleTimer() {
			if ( idleTimer ) {
				window.clearInterval( idleTimer );
				idleTimer = null;
			}
		}

		function stopIdleForGood() {
			idleStopped = true;
			stopIdleTimer();
		}

		if ( leftBtn ) {
			leftBtn.addEventListener( 'click', function () {
				stopIdleForGood();
				index += 1;
				apply();
			} );
		}
		if ( rightBtn ) {
			rightBtn.addEventListener( 'click', function () {
				stopIdleForGood();
				index -= 1;
				apply();
			} );
		}

		// Pause (not stop) on hover / focus / active pointer, same as the
		// auto-advancing home rotator — resumes once the visitor moves on,
		// unless a click already stopped it for good.
		[ 'mouseenter', 'focusin', 'pointerdown' ].forEach( function ( evt ) {
			root.addEventListener( evt, function () {
				idlePaused = true;
			}, { passive: true } );
		} );
		[ 'mouseleave', 'focusout' ].forEach( function ( evt ) {
			root.addEventListener( evt, function () {
				idlePaused = false;
			} );
		} );

		if ( motionOK && 'IntersectionObserver' in window ) {
			var io = new IntersectionObserver( function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						startIdle();
					} else {
						stopIdleTimer();
					}
				} );
			}, { threshold: 0.4 } );
			io.observe( root );
		} else if ( motionOK ) {
			startIdle();
		}

		window.addEventListener( 'resize', apply );
		apply();
	}

	function boot() {
		var roots = document.querySelectorAll( '[data-testi-mq]' );
		Array.prototype.forEach.call( roots, init );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', boot );
	} else {
		boot();
	}
})();
