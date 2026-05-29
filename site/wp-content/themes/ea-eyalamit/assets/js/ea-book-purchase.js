/**
 * ea-book-purchase.js — WP-W2-03 purchase-button GA4 tracking.
 *
 * AC-03: every purchase button fires a GA4 `book_purchase_click` event with
 * the book_slug when activated. Works for both the external Green Invoice link
 * (new tab) and the /contact?subject=book-<slug> fallback (same tab).
 *
 * gtag may be absent until Eyal supplies analytics credentials; the handler
 * no-ops gracefully in that case (event is still pushed to dataLayer when
 * present so it is captured once GA4 initializes).
 *
 * @package ea_eyalamit
 */
( function () {
	'use strict';

	function fire( slug ) {
		if ( ! slug ) {
			return;
		}
		var payload = { book_slug: slug };
		if ( typeof window.gtag === 'function' ) {
			window.gtag( 'event', 'book_purchase_click', payload );
		} else if ( window.dataLayer && typeof window.dataLayer.push === 'function' ) {
			window.dataLayer.push( Object.assign( { event: 'book_purchase_click' }, payload ) );
		}
	}

	document.addEventListener( 'click', function ( e ) {
		var el = e.target && e.target.closest ? e.target.closest( '[data-ea-book-purchase]' ) : null;
		if ( ! el ) {
			return;
		}
		fire( el.getAttribute( 'data-ea-book-slug' ) );
	}, false );
} )();
