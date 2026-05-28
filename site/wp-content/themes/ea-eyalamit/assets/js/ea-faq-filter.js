( function () {
	'use strict';

	function initFaqFilter() {
		var catSelect = document.getElementById( 'ea-faq-cat' );
		var items     = document.querySelectorAll( '.ea-faq-item' );

		if ( ! catSelect || ! items.length ) {
			return;
		}

		function filterItems() {
			var cat = catSelect.value;
			items.forEach( function ( item ) {
				var itemCat = item.getAttribute( 'data-category' ) || '';
				if ( cat === 'all' || itemCat === cat ) {
					item.removeAttribute( 'hidden' );
				} else {
					item.setAttribute( 'hidden', '' );
				}
			} );

			// Update category headings visibility.
			document.querySelectorAll( '.ea-faq-category' ).forEach( function ( section ) {
				var visible = section.querySelectorAll( '.ea-faq-item:not([hidden])' );
				if ( visible.length ) {
					section.removeAttribute( 'hidden' );
				} else {
					section.setAttribute( 'hidden', '' );
				}
			} );
		}

		catSelect.addEventListener( 'change', filterItems );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initFaqFilter );
	} else {
		initFaqFilter();
	}
} )();
