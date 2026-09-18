/**
 * EA — image lightbox.
 *
 * Built 2026-09-18 for team_00's ruling on /snoring-sleep-apnea/: «התמונה - לשים בצד
 * עם lightbox - לצד הטקסט». That page carries two document screenshots — the Maccabi
 * page and a WhatsApp thread — which he had previously required be shown large enough
 * to READ. Beside the text they are ~420px wide, which is not readable; the lightbox is
 * what makes both of his instructions true at once.
 *
 * Deliberately a native <dialog>. showModal() gives focus trapping, Escape-to-close,
 * inert background and focus return to the trigger without a line of code for any of
 * them — all four are things a hand-rolled modal on this site would get wrong, and this
 * site publishes an accessibility statement.
 *
 * No library, no dependency. Opt-in: a part renders a <button class="zoom"> carrying
 * data-zoom-src and data-zoom-alt.
 *
 * @package ea_eyalamit
 */
( function () {
	'use strict';

	var triggers = document.querySelectorAll( '[data-zoom-src]' );
	if ( ! triggers.length || typeof HTMLDialogElement === 'undefined' ) {
		return; // nothing to do, or a browser without <dialog>: the image stays a plain image
	}

	var dlg = document.createElement( 'dialog' );
	dlg.className = 'ea-lb';
	dlg.innerHTML =
		'<button type="button" class="ea-lb__x" aria-label="סגירה">&times;</button>' +
		'<img class="ea-lb__img" alt="">';
	document.body.appendChild( dlg );

	var img = dlg.querySelector( '.ea-lb__img' );

	dlg.querySelector( '.ea-lb__x' ).addEventListener( 'click', function () {
		dlg.close();
	} );

	/* Click outside the image closes. The dialog element itself fills the viewport, so a
	   click that lands on it rather than on a child is a backdrop click. */
	dlg.addEventListener( 'click', function ( e ) {
		if ( e.target === dlg ) {
			dlg.close();
		}
	} );

	Array.prototype.forEach.call( triggers, function ( btn ) {
		btn.addEventListener( 'click', function () {
			img.src = btn.getAttribute( 'data-zoom-src' );
			img.alt = btn.getAttribute( 'data-zoom-alt' ) || '';
			dlg.showModal();
		} );
	} );
}() );
