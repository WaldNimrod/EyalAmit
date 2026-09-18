<?php
/**
 * Plugin Name: EA — typography preview (STAGING ONLY, temporary)
 * Description: Lets team_00 tune the type scale live, on the real site, from the URL.
 *   Body size is the anchor; every other role derives from it, which is the model he
 *   asked for: «טקסט רץ — מבקש להתחיל מלנעול את הגודל שלו… ומהגודל הזה נגזור את כל האחרים».
 *
 *   SCAFFOLDING. It refuses to run anywhere but *.upress.link, it only ever emits CSS,
 *   and it is deleted the moment the scale is locked. Nothing here is the product.
 *
 *   Usage — append to any page URL:
 *     ?ty=17                      body 17px, everything derives from it
 *     &nav=1.08                   nav size as a multiple of body   (default 1.05)
 *     &navw=400                   nav weight                        (default 400)
 *     &navc=95                    nav colour opacity, 60-100        (default 92)
 *     &h1=2.4 &h2=1.75 &h3=1.12   heading sizes as multiples of body
 *     &h1w=300 &h2w=400 &h3w=400  heading weights
 *     &sub=1                      force one submenu open, to judge it against the main menu
 *     &subpad=6                   submenu item padding in px        (default 10, site ships 10/14)
 *     &serif=0                    hero H1 in Heebo like every other heading, instead of the
 *                                 reserved Frank Ruhl Libre accent — so the family deviation
 *                                 team_00 spotted can be judged rather than argued about
 *     &grid=1                     show the resolved numbers in a corner readout
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

function ea_type_preview_is_staging() {
	$host = isset( $_SERVER['HTTP_HOST'] ) ? (string) $_SERVER['HTTP_HOST'] : '';
	return (bool) preg_match( '/\.upress\.link$/i', $host );
}

function ea_type_preview_num( $key, $default, $min, $max ) {
	if ( ! isset( $_GET[ $key ] ) ) {
		return $default;
	}
	$v = (float) $_GET[ $key ];
	return ( $v >= $min && $v <= $max ) ? $v : $default;
}

add_action( 'wp_head', function () {
	if ( ! ea_type_preview_is_staging() || ! isset( $_GET['ty'] ) ) {
		return;
	}

	$b    = ea_type_preview_num( 'ty',   17,   11,   28 );   // the anchor
	$nav  = ea_type_preview_num( 'nav',  1.05, 0.7,  2.0 );
	$navw = (int) ea_type_preview_num( 'navw', 400, 100, 900 );
	$navc = ea_type_preview_num( 'navc', 92,   50,  100 );
	$h1   = ea_type_preview_num( 'h1',   2.4,  1.2,  4.5 );
	$h2   = ea_type_preview_num( 'h2',   1.75, 1.05, 3.5 );
	$h3   = ea_type_preview_num( 'h3',   1.12, 0.9,  2.0 );
	$h1w  = (int) ea_type_preview_num( 'h1w', 300, 100, 900 );
	$h2w  = (int) ea_type_preview_num( 'h2w', 400, 100, 900 );
	$h3w  = (int) ea_type_preview_num( 'h3w', 400, 100, 900 );
	$sub    = isset( $_GET['sub'] ) && '1' === $_GET['sub'];
	$subpad = ea_type_preview_num( 'subpad', 10, 0, 24 );
	$serif  = ! ( isset( $_GET['serif'] ) && '0' === $_GET['serif'] );
	$grid = isset( $_GET['grid'] ) && '1' === $_GET['grid'];

	$nav_px = round( $b * $nav, 2 );
	$h1_px  = round( $b * $h1, 2 );
	$h2_px  = round( $b * $h2, 2 );
	$h3_px  = round( $b * $h3, 2 );
	$alpha  = round( $navc / 100, 3 );

	$css = "
/* EA typography preview — body {$b}px is the anchor, all else derives */
.sec p,.sec li,.phero__s,.dd__b,.st3__t,p{font-size:{$b}px!important}
.h2,h2{font-size:{$h2_px}px!important;font-weight:{$h2w}!important}
.phero__h,h1{font-size:{$h1_px}px!important;font-weight:{$h1w}!important}
h3{font-size:{$h3_px}px!important;font-weight:{$h3w}!important}
.nav__l a,.nav__dd{font-size:{$nav_px}px!important;font-weight:{$navw}!important;color:rgba(255,255,255,{$alpha})!important}
/* submenu: same size as the main menu, one step lighter, tighter padding — per team_00 */
.nav__sub a{font-size:{$nav_px}px!important;font-weight:" . max( 100, $navw - 100 ) . "!important;color:rgba(255,255,255," . round( $alpha * 0.92, 3 ) . ")!important;padding:" . round( $subpad * 0.7, 1 ) . "px {$subpad}px!important}
";
	if ( ! $serif ) {
		/* the hero is the only heading on the site in a serif; let it be judged, not assumed */
		$css .= ".hero__h,.phero__h{font-family:var(--hf)!important}\n";
	}
	if ( $sub ) {
		$css .= "@media(min-width:1181px){.nav__l>li:nth-of-type(2) .nav__sub{opacity:1!important;visibility:visible!important;transform:none!important;pointer-events:auto!important}}\n";
	}
	echo "<style id=\"ea-type-preview\">" . $css . "</style>\n";

	if ( $grid ) {
		echo '<style>#ea-typro{position:fixed;inset-block-end:12px;inset-inline-start:12px;z-index:99999;background:rgba(20,14,9,.92);color:#fff;font:12px/1.7 monospace;padding:10px 14px;border-radius:8px;direction:ltr;text-align:left;pointer-events:none}</style>';
		echo '<div id="ea-typro">body ' . esc_html( $b ) . 'px &middot; nav ' . esc_html( $nav_px ) . 'px/' . esc_html( $navw )
			. ' &middot; h1 ' . esc_html( $h1_px ) . 'px/' . esc_html( $h1w )
			. ' &middot; h2 ' . esc_html( $h2_px ) . 'px/' . esc_html( $h2w )
			. ' &middot; h3 ' . esc_html( $h3_px ) . 'px/' . esc_html( $h3w ) . '</div>';
	}
}, 99 );
