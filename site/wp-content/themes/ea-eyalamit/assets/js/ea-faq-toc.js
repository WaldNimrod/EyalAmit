/**
 * WP-W2-16-C — FAQ topic navigation (TOC).
 *
 * Progressive enhancement over a plain anchor-link nav: the markup already works
 * without JS (each chip is an <a href="#faq-topic-slug"> that the browser jumps
 * to). This script adds:
 *   1. smooth scroll on click (respecting prefers-reduced-motion),
 *   2. scroll-spy — the chip of the section nearest the top gets .is-active +
 *      aria-current,
 *   3. legacy deep-link support — ?topic=<slug> scrolls to that section on load
 *      (the old filter URL state stays meaningful).
 */
( function () {
	'use strict';

	function initFaqToc() {
		var toc = document.querySelector( '[data-faq-toc]' );
		var sections = document.querySelectorAll( '.ea-faq-category[id]' );
		if ( ! toc || ! sections.length ) {
			return;
		}

		var links = toc.querySelectorAll( '[data-faq-toc-link]' );
		if ( ! links.length ) {
			return;
		}

		var prefersReduce = window.matchMedia
			&& window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
		var linkBySlug = {};
		Array.prototype.forEach.call( links, function ( a ) {
			linkBySlug[ a.getAttribute( 'data-faq-toc-link' ) ] = a;
		} );

		function setActive( slug ) {
			Array.prototype.forEach.call( links, function ( a ) {
				var on = a.getAttribute( 'data-faq-toc-link' ) === slug;
				a.classList.toggle( 'is-active', on );
				if ( on ) {
					a.setAttribute( 'aria-current', 'true' );
				} else {
					a.removeAttribute( 'aria-current' );
				}
			} );
		}

		function slugOf( section ) {
			return section.getAttribute( 'data-category' )
				|| section.id.replace( /^faq-topic-/, '' );
		}

		function scrollToSection( slug, smooth ) {
			var target = document.getElementById( 'faq-topic-' + slug );
			if ( ! target ) {
				return false;
			}
			target.scrollIntoView( {
				behavior: ( smooth && ! prefersReduce ) ? 'smooth' : 'auto',
				block: 'start'
			} );
			setActive( slug );
			return true;
		}

		// Scroll-spy: highlight the most-visible section's chip.
		if ( 'IntersectionObserver' in window ) {
			var ratios = {};
			var observer = new IntersectionObserver( function ( entries ) {
				entries.forEach( function ( entry ) {
					ratios[ slugOf( entry.target ) ] = entry.isIntersecting
						? entry.intersectionRatio
						: 0;
				} );
				var best = null;
				var bestRatio = 0;
				Object.keys( ratios ).forEach( function ( slug ) {
					if ( ratios[ slug ] > bestRatio ) {
						bestRatio = ratios[ slug ];
						best = slug;
					}
				} );
				if ( best ) {
					setActive( best );
				}
			}, { rootMargin: '-25% 0px -55% 0px', threshold: [ 0, 0.25, 0.5, 1 ] } );

			Array.prototype.forEach.call( sections, function ( s ) {
				observer.observe( s );
			} );
		}

		// Click — smooth scroll + write ?topic= state (history.replaceState).
		Array.prototype.forEach.call( links, function ( a ) {
			a.addEventListener( 'click', function ( e ) {
				var slug = a.getAttribute( 'data-faq-toc-link' );
				if ( scrollToSection( slug, true ) ) {
					e.preventDefault();
					if ( window.history && window.history.replaceState ) {
						try {
							var url = new URL( window.location.href );
							url.searchParams.set( 'topic', slug );
							window.history.replaceState( null, '', url.toString() );
						} catch ( err ) {/* no-op */}
					}
				}
			} );
		} );

		// Legacy deep-link: ?topic=<slug> scrolls to that section on load.
		var initial = '';
		try {
			initial = new URL( window.location.href ).searchParams.get( 'topic' ) || '';
		} catch ( err ) {
			initial = '';
		}
		if ( initial && linkBySlug[ initial ] ) {
			window.requestAnimationFrame( function () {
				scrollToSection( initial, false );
			} );
		} else {
			setActive( slugOf( sections[ 0 ] ) );
		}
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initFaqToc );
	} else {
		initFaqToc();
	}
} )();
