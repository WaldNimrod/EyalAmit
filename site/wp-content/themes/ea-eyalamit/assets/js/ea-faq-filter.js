( function () {
	'use strict';

	function initFaqFilter() {
		var catSelect = document.getElementById( 'ea-faq-cat' );
		var items     = document.querySelectorAll( '.ea-faq-item' );
		var countEl   = document.getElementById( 'faq-count' );

		if ( ! catSelect || ! items.length ) {
			return;
		}

		function filterItems() {
			var cat   = catSelect.value;
			var shown = 0;

			items.forEach( function ( item ) {
				var itemCat = item.getAttribute( 'data-category' ) || '';
				if ( cat === 'all' || itemCat === cat ) {
					item.removeAttribute( 'hidden' );
					shown += 1;
				} else {
					item.setAttribute( 'hidden', '' );
				}
			} );

			// Category headings: show a group only when it has visible items.
			document.querySelectorAll( '.ea-faq-category' ).forEach( function ( section ) {
				var visible = section.querySelectorAll( '.ea-faq-item:not([hidden])' );
				if ( visible.length ) {
					section.removeAttribute( 'hidden' );
				} else {
					section.setAttribute( 'hidden', '' );
				}
			} );

			// AC-C3 — live result count.
			if ( countEl ) {
				countEl.textContent = shown + ' שאלות מוצגות';
			}
		}

		// AC-C3 — write ?topic=<slug> URL state (history.replaceState).
		function setURL( slug ) {
			if ( ! window.history || ! window.history.replaceState ) {
				return;
			}
			var url = new URL( window.location.href );
			if ( slug === 'all' ) {
				url.searchParams.delete( 'topic' );
			} else {
				url.searchParams.set( 'topic', slug );
			}
			window.history.replaceState( null, '', url.toString() );
		}

		catSelect.addEventListener( 'change', function () {
			filterItems();
			setURL( catSelect.value );
		} );

		// AC-C3 — read ?topic=<slug> on load.
		var initial = 'all';
		try {
			initial = new URL( window.location.href ).searchParams.get( 'topic' ) || 'all';
		} catch ( e ) {
			initial = 'all';
		}
		var valid = Array.prototype.some.call( catSelect.options, function ( o ) {
			return o.value === initial;
		} );
		if ( valid ) {
			catSelect.value = initial;
		}

		filterItems();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initFaqFilter );
	} else {
		initFaqFilter();
	}
} )();
