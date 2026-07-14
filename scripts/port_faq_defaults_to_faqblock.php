<?php
/**
 * Port inc/chapters/defaults/* FAQ sections to faqblock (WP-CANON T2).
 * One-time helper — run after manual review if re-porting.
 */
define( 'ABSPATH', true );

$theme = dirname( __DIR__ ) . '/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults';

$ports = array(
	'treatment-defaults.php'      => array( 'chap' => 'שאלות נפוצות', 'title' => 'שאלות נפוצות', 'cats' => array( 'treatment' ) ),
	'sound-healing-defaults.php'  => array( 'chap' => 'שאלות נפוצות', 'title' => 'שאלות נפוצות על סאונד הילינג בדיג׳רידו', 'cats' => array( 'sound-healing' ) ),
	'bags-defaults.php'             => array( 'chap' => 'שאלות נפוצות', 'title' => "שאלות נפוצות על תיק לדיג'רידו", 'cats' => array( 'bags' ) ),
	'didgeridoos-defaults.php'      => array( 'chap' => "שאלות נפוצות", 'title' => "שאלות נפוצות", 'cats' => array( 'didgeridoos' ) ),
	'repair-defaults.php'           => array( 'chap' => 'שאלות נפוצות', 'title' => 'שאלות נפוצות', 'cats' => array( 'repair' ), 'id' => 'faq' ),
	'stands-storage-defaults.php' => array( 'chap' => "שאלות נפוצות", 'title' => "שאלות נפוצות", 'cats' => array( 'stands-storage' ) ),
	'stand-floor-defaults.php'    => array( 'chap' => 'שאלות נפוצות', 'title' => 'שאלות נפוצות', 'cats' => array( 'stand-floor' ) ),
	'vekatavta-defaults.php'        => array( 'chap' => 'שאלות ותשובות', 'title' => 'שאלות ותשובות', 'cats' => array( 'vekatavta' ) ),
	'kushi-blantis-defaults.php'  => array( 'chap' => 'שאלות ותשובות', 'title' => 'שאלות ותשובות', 'cats' => array( 'kushi-blantis' ) ),
	'tsva-bekahol-defaults.php'   => array( 'chap' => 'שאלות ותשובות', 'title' => 'שאלות ותשובות', 'cats' => array( 'tsva-bekahol' ) ),
);

function build_faqblock( array $meta ): string {
	$id_line = ! empty( $meta['id'] ) ? "\n\t\t\t\t'id'   => '" . $meta['id'] . "'," : '';
	$cats    = "array( '" . implode( "', '", $meta['cats'] ) . "' )";
	return "\t\tarray(\n\t\t\t'part' => 'faqblock',\n\t\t\t'args' => array(\n\t\t\t\t'chap'  => '" . $meta['chap'] . "',\n\t\t\t\t'title' => '" . $meta['title'] . "'," . $id_line . "\n\t\t\t\t'cats'  => " . $cats . ",\n\t\t\t),\n\t\t),";
}

foreach ( $ports as $file => $meta ) {
	$path = $theme . '/' . $file;
	$src  = file_get_contents( $path );
	$repl = build_faqblock( $meta );
	if ( ! preg_match( "/\t\tarray\(\s*\n\t\t\t'part' => 'faq',.*?\n\t\t\),/s", $src ) ) {
		fwrite( STDERR, "SKIP (no faq part): $file\n" );
		continue;
	}
	$out = preg_replace( "/\t\tarray\(\s*\n\t\t\t'part' => 'faq',.*?\n\t\t\),/s", $repl, $src, 1 );
	file_put_contents( $path, $out );
	echo "ported: $file\n";
}

// lessons — prose FAQ block.
$lessons = $theme . '/lessons-defaults.php';
$src     = file_get_contents( $lessons );
$repl    = build_faqblock( array(
	'chap'  => 'שאלות ותשובות',
	'title' => 'שאלות נפוצות',
	'cats'  => array( 'lessons' ),
) );
if ( preg_match( "/\t\t\/\* FAQ.*?\n\t\tarray\(\s*\n\t\t\t'part' => 'prose',.*?\n\t\t\),/s", $src ) ) {
	$out = preg_replace(
		"/\t\t\/\* FAQ.*?\n\t\tarray\(\s*\n\t\t\t'part' => 'prose',.*?\n\t\t\),/s",
		"\t\t/* FAQ — שאלות נפוצות (SECTION 09) */\n" . $repl,
		$src,
		1
	);
	file_put_contents( $lessons, $out );
	echo "ported: lessons-defaults.php\n";
} else {
	fwrite( STDERR, "SKIP lessons prose FAQ\n" );
}
