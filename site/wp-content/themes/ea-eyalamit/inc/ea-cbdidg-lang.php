<?php
/**
 * Mark visible Latin token cbDIDG with lang="en" for screen readers (Hebrew UI).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Allow lang on span in post context so wp_kses_post keeps our markers.
 *
 * @param array<string,array<string,bool>> $tags
 * @param string                           $context
 * @return array<string,array<string,bool>>
 */
function ea_cbdidg_wp_kses_allow_lang_span( $tags, $context ) {
	if ( 'post' === $context && isset( $tags['span'] ) && is_array( $tags['span'] ) ) {
		$tags['span']['lang'] = true;
	}
	return $tags;
}
add_filter( 'wp_kses_allowed_html', 'ea_cbdidg_wp_kses_allow_lang_span', 10, 2 );

/**
 * Default visible marker (no nowrap — avoids line-break side effects in body copy).
 */
function ea_cbdidg_lang_markup() {
	return '<span lang="en">cbDIDG</span>';
}

/**
 * Mark unwrapped cbDIDG in an HTML fragment (text nodes only by naive replace; protect existing spans).
 *
 * @param string $html
 * @return string
 */
function ea_mark_cbdidg_visible_html( $html ) {
	$html = (string) $html;
	if ( false === strpos( $html, 'cbDIDG' ) ) {
		return $html;
	}

	$protected = array();
	$i         = 0;
	$html      = preg_replace_callback(
		'/<span[^>]*\blang=["\']en["\'][^>]*>cbDIDG<\/span>/i',
		static function ( $m ) use ( &$protected, &$i ) {
			$key               = "\xEA CBDIDG PROT " . ( $i++ ) . "\xEA";
			$protected[ $key ] = $m[0];
			return $key;
		},
		$html
	);

	$html = str_replace( 'cbDIDG', ea_cbdidg_lang_markup(), $html );

	foreach ( $protected as $key => $original ) {
		$html = str_replace( $key, $original, $html );
	}

	return $html;
}

/**
 * Plain visible text: escape, then inject lang spans (for esc_html() call sites).
 *
 * @param string $text
 * @return string Safe HTML for echo.
 */
function ea_esc_visible_text( $text ) {
	$text = (string) $text;
	if ( false === strpos( $text, 'cbDIDG' ) ) {
		return esc_html( $text );
	}
	$marked = ea_mark_cbdidg_visible_html( esc_html( $text ) );
	return wp_kses(
		$marked,
		array(
			'span' => array(
				'lang'  => true,
				'class' => true,
			),
		)
	);
}

/**
 * Chapter body HTML: retired-brand rewrite + cbDIDG lang + post kses.
 *
 * @param string $html
 * @return string
 */
function ea_chapters_prepare_body_html( $html ) {
	$html = function_exists( 'ea_replace_retired_brand' ) ? ea_replace_retired_brand( (string) $html ) : (string) $html;
	$html = ea_mark_cbdidg_visible_html( $html );
	return wp_kses_post( $html );
}

/**
 * Blog + classic editor content (not titles).
 *
 * @param string $content
 * @return string
 */
function ea_cbdidg_mark_the_content( $content ) {
	if ( ! is_string( $content ) || '' === $content || false === strpos( $content, 'cbDIDG' ) ) {
		return $content;
	}
	return ea_mark_cbdidg_visible_html( $content );
}
add_filter( 'the_content', 'ea_cbdidg_mark_the_content', 13 );
