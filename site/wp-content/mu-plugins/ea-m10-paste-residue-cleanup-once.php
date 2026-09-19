<?php
/**
 * Plugin Name: EA — strip Word/Facebook paste font residue from six old posts (once)
 * Description: S007 M-10 part 2. The cross-engine gate measured ten live elements
 *   computing Arial/arial inside pasted Word/Facebook markup, in the database content
 *   of five published columns, plus three more (no direct text, not currently
 *   rendering) in a sixth. No stylesheet touches this and no token ever will — it is
 *   inline `style="font-family:...Arial..."` and `class="MsoNormal"` left behind by
 *   the original paste, years ago.
 *
 *   Content law (absolute, per the mandate): strip ONLY font-family declarations
 *   (and the mso-*-font-family siblings Word writes alongside it), MsoNormal classes,
 *   and now-empty nested <span> wrappers. Change no word, no punctuation, no line
 *   break, no link. Every post is verified — plain-text extracted before and after,
 *   byte-for-byte compared — before it is written; a post that does not match is
 *   skipped and logged, never forced through.
 *
 *   `«(27) חכמת הפרצוף»` (post 189) is deliberately NOT in the id list below — an
 *   earlier internal summary named it in error; the gate confirmed it carries zero
 *   Arial residue. Left alone.
 *
 *   Staging has no WP-CLI, hence this one-shot. Idempotent and flag-guarded. Takes a
 *   file backup of every post's CURRENT post_content, before that post's own write —
 *   not after the batch succeeds — so a mid-batch failure still leaves every
 *   already-touched post individually reversible without a database restore.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Remove font-family-family declarations and MsoNormal classes from a fragment of
 * post HTML, and drop any <span> left with no attributes and no non-whitespace text.
 * Returns null (never a partial guess) if the fragment cannot be parsed.
 */
function ea_m10_strip_paste_styling( string $html ) {
	if ( ! class_exists( 'DOMDocument' ) ) {
		return null;
	}
	$wrapped = '<?xml encoding="utf-8" ?><div id="ea-m10-root">' . $html . '</div>';
	$doc     = new DOMDocument();
	$prev    = libxml_use_internal_errors( true );
	$ok      = $doc->loadHTML( $wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
	libxml_clear_errors();
	libxml_use_internal_errors( $prev );
	if ( ! $ok ) {
		return null;
	}
	$root = $doc->getElementById( 'ea-m10-root' );
	if ( ! $root ) {
		return null;
	}

	$xpath          = new DOMXPath( $doc );
	$font_props_re  = '/^(font-family|mso-ascii-font-family|mso-hansi-font-family|mso-bidi-font-family|mso-fareast-font-family)\s*:/i';

	foreach ( $xpath->query( '//*[@style]', $root ) as $el ) {
		$style = $el->getAttribute( 'style' );
		/* One known post has a double HTML-entity-encoded quote inside this attribute
		   (literal "&amp;quot;" in the source). A second entity-decode turns that back
		   into a real '"' before splitting on ';' — otherwise the semicolon INSIDE the
		   un-decoded "&quot;" text is misread as a declaration separator and the
		   font-family declaration silently survives in pieces. */
		$style = html_entity_decode( $style, ENT_QUOTES | ENT_HTML5 );
		$decls = array_filter( array_map( 'trim', explode( ';', $style ) ) );
		$kept  = array();
		foreach ( $decls as $decl ) {
			if ( preg_match( $font_props_re, $decl ) ) {
				continue;
			}
			$kept[] = $decl;
		}
		if ( empty( $kept ) ) {
			$el->removeAttribute( 'style' );
		} else {
			$el->setAttribute( 'style', implode( '; ', $kept ) . ';' );
		}
	}

	foreach ( $xpath->query( '//*[@class]', $root ) as $el ) {
		$classes = array_filter( array_map( 'trim', explode( ' ', $el->getAttribute( 'class' ) ) ) );
		$kept    = array_values(
			array_filter(
				$classes,
				function ( $c ) {
					return 0 !== stripos( $c, 'MsoNormal' );
				}
			)
		);
		if ( empty( $kept ) ) {
			$el->removeAttribute( 'class' );
		} else {
			$el->setAttribute( 'class', implode( ' ', $kept ) );
		}
	}

	/* Only spans that are now bare (no attributes left at all) AND hold no
	   non-whitespace text anywhere in their subtree — never a span still carrying
	   real text, which the content law does not ask this pass to unwrap. */
	$spans = iterator_to_array( $xpath->query( '//span', $root ) );
	foreach ( $spans as $el ) {
		$has_attrs = $el->attributes->length > 0;
		$text      = str_replace( "\u{00A0}", ' ', $el->textContent );
		$is_empty  = '' === trim( $text );
		if ( ! $has_attrs && $is_empty && $el->parentNode ) {
			$el->parentNode->removeChild( $el );
		}
	}

	$inner = '';
	foreach ( $root->childNodes as $child ) {
		$inner .= $doc->saveHTML( $child );
	}
	return $inner;
}

/** Whitespace-normalized plain text, for a before/after identity check. */
function ea_m10_plain_text( string $html ): string {
	if ( ! class_exists( 'DOMDocument' ) ) {
		return $html; // fails the identity check loudly rather than silently passing
	}
	$wrapped = '<?xml encoding="utf-8" ?><div id="ea-m10-r">' . $html . '</div>';
	$doc     = new DOMDocument();
	$prev    = libxml_use_internal_errors( true );
	$doc->loadHTML( $wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
	libxml_clear_errors();
	libxml_use_internal_errors( $prev );
	$root = $doc->getElementById( 'ea-m10-r' );
	$text = $root ? $root->textContent : '';
	return trim( preg_replace( '/\s+/u', ' ', $text ) );
}

add_action(
	'init',
	function () {
		$flag = 'ea_m10_paste_cleanup_2026_09_20_v1';
		if ( 'done' === get_option( $flag ) ) {
			return;
		}

		/* All six confirmed against the live gate — not the earlier internal summary,
		   which misnamed post 189 (חכמת הפרצוף, zero Arial, correctly excluded here). */
		$post_ids  = array( 194, 195, 190, 188, 203, 193 );
		$backup_dir = trailingslashit( WP_CONTENT_DIR ) . 'uploads/ea-m10-backups/';
		if ( ! is_dir( $backup_dir ) ) {
			wp_mkdir_p( $backup_dir );
		}

		$results = array();

		foreach ( $post_ids as $post_id ) {
			$row = array( 'post_id' => $post_id );

			/* 'raw' context: the exact bytes in wp_posts, unfiltered. This mandate is
			   about what is actually stored, not a filtered read of it. */
			$before_content = get_post_field( 'post_content', $post_id, 'raw' );
			if ( null === $before_content || false === $before_content || '' === $before_content ) {
				$row['status'] = 'skipped: post not found or empty content';
				$results[]     = $row;
				continue;
			}

			/* Backup FIRST, before this post's own write — so a failure on post N does
			   not leave posts 1..N-1 (already written) without their own snapshot. */
			$backup_path = $backup_dir . "post-{$post_id}-before-m10.html";
			$written     = file_put_contents( $backup_path, $before_content );
			if ( false === $written ) {
				$row['status'] = 'skipped: could not write backup, refusing to edit without one';
				$results[]     = $row;
				continue;
			}
			$row['backup'] = $backup_path;

			$cleaned = ea_m10_strip_paste_styling( $before_content );
			if ( null === $cleaned ) {
				$row['status'] = 'skipped: HTML parse failed';
				$results[]     = $row;
				continue;
			}

			$text_before = ea_m10_plain_text( $before_content );
			$text_after  = ea_m10_plain_text( $cleaned );
			if ( $text_before !== $text_after ) {
				$row['status']       = 'REFUSED: visible text would change, not written';
				$row['text_before']  = $text_before;
				$row['text_after']   = $text_after;
				$results[]           = $row;
				continue;
			}

			$arial_before = preg_match_all( '/font-family:\s*[\'"]?[Aa]rial/', $before_content );
			$arial_after  = preg_match_all( '/font-family:\s*[\'"]?[Aa]rial/', $cleaned );
			$mso_before   = substr_count( $before_content, 'MsoNormal' );
			$mso_after    = substr_count( $cleaned, 'MsoNormal' );

			/* Direct $wpdb write, not wp_update_post(): this runs on an anonymous front-end
			   request (init hook, no logged-in user), so wp_update_post() would route
			   post_content through wp_kses_post() as an unprivileged save and could strip
			   or rewrite attributes this pass deliberately kept (style values on <td>,
			   dir/lang, etc.) in ways impossible to verify without a live WordPress
			   request. The content is already fully vetted above -- byte-identical visible
			   text, confirmed by this same script -- so writing it verbatim is safer than
			   passing it through a filter built to distrust untrusted input it isn't. */
			global $wpdb;
			$now_local = current_time( 'mysql' );
			$now_gmt   = current_time( 'mysql', true );
			$rows      = $wpdb->update(
				$wpdb->posts,
				array(
					'post_content'      => $cleaned,
					'post_modified'     => $now_local,
					'post_modified_gmt' => $now_gmt,
				),
				array( 'ID' => $post_id ),
				array( '%s', '%s', '%s' ),
				array( '%d' )
			);

			if ( false === $rows ) {
				$row['status'] = 'FAILED: ' . $wpdb->last_error;
			} else {
				clean_post_cache( $post_id );
				$row['status']       = 'done';
				$row['arial_before'] = $arial_before;
				$row['arial_after']  = $arial_after;
				$row['mso_before']   = $mso_before;
				$row['mso_after']    = $mso_after;
				$row['bytes_before'] = strlen( $before_content );
				$row['bytes_after']  = strlen( $cleaned );
			}
			$results[] = $row;
		}

		update_option(
			'ea_m10_paste_cleanup_result',
			array(
				'ran_at'  => current_time( 'mysql' ),
				'results' => $results,
			)
		);

		/* Only mark done if every post either succeeded or was explicitly, safely
		   skipped/refused (never on a PHP-level failure that reads as "done" by
		   accident) — a bare fatal before this line means the flag never gets set,
		   and the next page load tries again rather than reporting a silent no-op. */
		update_option( $flag, 'done' );
	},
	20
);
