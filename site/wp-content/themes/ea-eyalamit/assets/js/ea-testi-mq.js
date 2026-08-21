/**
 * ea-testi-mq.js — S006 wave 5.
 *
 * Manual left/right control for chapter testimonial strips (.testi-mq[data-testi-mq]).
 * No autoplay. Left button moves the strip left; right button moves it right.
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

		if ( leftBtn ) {
			leftBtn.addEventListener( 'click', function () {
				index += 1;
				apply();
			} );
		}
		if ( rightBtn ) {
			rightBtn.addEventListener( 'click', function () {
				index -= 1;
				apply();
			} );
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
