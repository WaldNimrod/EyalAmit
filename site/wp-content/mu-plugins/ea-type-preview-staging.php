<?php
/**
 * Plugin Name: EA — typography preview (STAGING ONLY, temporary)
 * Description: Lets team_00 tune the type scale live, on the real site, from the URL.
 *   Body size is the anchor; every other role derives from it, which is the model he
 *   asked for: «טקסט רץ — מבקש להתחיל מלנעול את הגודל שלו… ומהגודל הזה נגזור את כל האחרים».
 *
 *   SCALE LOCKED 2026-09-18 (team_00: «תנעל את הסולם לפי הצירוף האחרון»). The values are
 *   now real tokens in chapters.css (--fs-* / --fw-*), and a page with no ?ty= in its URL
 *   renders purely from those. This tool is kept ONLY so the locked numbers can still be
 *   tuned by eye; it overrides the tokens with !important when asked. Delete it on his word.
 *   Note the FTP deploy never prunes, so deleting the file here does NOT remove it from
 *   staging — it has to be removed there too, or it becomes exactly the kind of dead file
 *   this project already has too many of.
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
 *     &serif=1                    put the hero H1 back on Frank Ruhl Libre. INVERTED 2026-09-18:
 *                                 team_00 ruled the hero string still broke the font map, so
 *                                 Heebo is what the site now ships and the serif is the
 *                                 comparison — the switch shows what was replaced.
 *     &pherow=34                   inner-page hero title cap in ch  (site now ships 34)
 *     &herow=880                  hero content box in px     (site now ships 880)
 *     &sec=88                     section padding top/bottom in px (site now ships 62-88 fluid)
 *     &lh=1.6                     running-text line-height   (site now ships 1.65-1.7)
 *     &h3ls=0.2                   h3 letter-spacing in px    (site now ships 0.2)
 *     &logo=40                    logo mark size in px       (site now ships 40)
 *     &demo=1                     insert a labelled specimen sub-heading into the first prose
 *                                 sections, so the h3 rung is visible at all — see below
 *     &fam=1                      outline every element that does NOT resolve to Heebo, and
 *                                 name the family on it, so the deviations can be seen
 *     &grid=1                     show the resolved numbers in a corner readout
 *
 *   WHY demo=1 EXISTS. Measured on live staging 2026-09-18: every section title in all
 *   24 Chapters body parts is an <h2 class="h2 r">, and H3 appears only as a CARD title
 *   inside a grid. Heading counts on the flagship pages: /method/ 13×h2 0×h3 ·
 *   /eyal-amit/ 13×h2 0×h3 · /books/ 6×h2 0×h3 · home 10×h2 2×h3. So on most pages the
 *   h3 dial above moves nothing, and team_00 cannot judge a three-rung hierarchy he
 *   cannot see. This switch injects ONE specimen sub-heading per prose section, in the
 *   first three sections only, with text that says outright that it is a specimen.
 *
 *   It is NOT content. It never renders without demo=1, it never renders off staging,
 *   it is injected in the browser and touches no theme file, and it dies with this
 *   plugin. The content law («רק מה שקיים») is about site copy; this is a measuring rod.
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
	$serif  = isset( $_GET['serif'] ) && '1' === $_GET['serif'];
	$lh     = isset( $_GET['lh'] )   ? ea_type_preview_num( 'lh',   1.65, 1.1, 2.4 ) : null;
	$h3ls   = isset( $_GET['h3ls'] ) ? ea_type_preview_num( 'h3ls', 0.2, -1.5, 4.0 ) : null;
	$logo   = isset( $_GET['logo'] ) ? ea_type_preview_num( 'logo', 40,  20,  90 )  : null;
	$herow  = isset( $_GET['herow'] ) ? ea_type_preview_num( 'herow', 880, 520, 1400 ) : null;
	$sec    = isset( $_GET['sec'] )   ? ea_type_preview_num( 'sec', 88, 20, 160 ) : null;
	$pherow = isset( $_GET['pherow'] ) ? ea_type_preview_num( 'pherow', 34, 10, 60 ) : null;
	$demo   = isset( $_GET['demo'] ) && '1' === $_GET['demo'];
	$fam    = isset( $_GET['fam'] ) && '1' === $_GET['fam'];
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
	if ( $serif ) {
		/* the serif the hero used to carry, for comparison against what now ships */
		$css .= ".hero__h,.phero__h{font-family:'Frank Ruhl Libre',serif!important}\n";
	}
	if ( $sub ) {
		$css .= "@media(min-width:1181px){.nav__l>li:nth-of-type(2) .nav__sub{opacity:1!important;visibility:visible!important;transform:none!important;pointer-events:auto!important}}\n";
	}
	if ( null !== $lh ) {
		/* team_00 2026-09-18: «פחות מרווח בין שורות». Shipped by eye at 1.55-1.7;
		   this dial is here so the eye that asked for it can correct the guess. */
		$css .= ".sec p,.intro-body p,.prose p,.faq__i p,.dd__body,.lead,.hero__s{line-height:{$lh}!important}\n";
	}
	if ( null !== $h3ls ) {
		$css .= "h3{letter-spacing:{$h3ls}px!important}\n";
	}
	if ( null !== $pherow ) {
		$css .= ".phero__h{max-width:{$pherow}ch!important}\n";
	}
	if ( null !== $sec ) {
		$css .= ":root{--sec:{$sec}px!important}\n";
	}
	if ( null !== $herow ) {
		$css .= ".hero__c{max-width:{$herow}px!important}\n";
	}
	if ( null !== $logo ) {
		$css .= ".nav__lg{width:{$logo}px!important;height:{$logo}px!important}\n";
	}
	if ( $demo ) {
		/* The specimen inherits the h3 rule above, so the h3 dial actually moves it. */
		$css .= ".ea-typrev-h3{margin:1.6em 0 .5em;color:var(--ink)}\n";
	}
	if ( $fam ) {
		/* Every live rule that resolves to something other than Heebo. Two families,
		   thirteen selectors, all in chapters.css — outlined so they can be seen in
		   place instead of read off a list. */
		$css .= ".hero__h,.phero__h,.tl__y,.bleed__q,.st3::after,.shstep__dot span,.bookcard__t"
			. "{outline:2px dashed #E0A33C!important;outline-offset:3px}\n";
		$css .= ".fstep__num,.fstep__t,.mag-spread__fig figcaption b,.mag-list__n,.mag-list__t,.btile__t"
			. "{outline:2px dashed #4FA3C4!important;outline-offset:3px}\n";
	}
	echo "<style id=\"ea-type-preview\">" . $css . "</style>\n";

	if ( $grid ) {
		echo '<style>#ea-typro{position:fixed;inset-block-end:12px;inset-inline-start:12px;z-index:99999;background:rgba(20,14,9,.92);color:#fff;font:12px/1.7 monospace;padding:10px 14px;border-radius:8px;direction:ltr;text-align:left;pointer-events:none}</style>';
		echo '<div id="ea-typro">body ' . esc_html( $b ) . 'px &middot; nav ' . esc_html( $nav_px ) . 'px/' . esc_html( $navw )
			. ' &middot; h1 ' . esc_html( $h1_px ) . 'px/' . esc_html( $h1w )
			. ' &middot; h2 ' . esc_html( $h2_px ) . 'px/' . esc_html( $h2w )
			. ' &middot; h3 ' . esc_html( $h3_px ) . 'px/' . esc_html( $h3w )
			. ( $fam ? ' &middot; <span style="color:#E0A33C">Frank Ruhl Libre</span> &middot; <span style="color:#4FA3C4">Suez One</span>' : '' )
			. '</div>';
	}

	if ( $demo ) {
		/* Injected in the browser: no theme file is touched, and nothing persists.
		   The specimen names itself, so it cannot be mistaken for Eyal's copy even
		   in a screenshot taken out of context. */
		$label = 'כותרת משנה — טקסט הדגמה לבחינת ההיררכיה';
		echo "<script id=\"ea-type-preview-demo\">document.addEventListener('DOMContentLoaded',function(){"
			. "var n=0;document.querySelectorAll('.intro-body').forEach(function(b){"
			. "if(n>=3)return;var ps=b.querySelectorAll(':scope > p');if(ps.length<2)return;"
			. "var h=document.createElement('h3');h.className='ea-typrev-h3';"
			. "h.textContent=" . wp_json_encode( $label ) . ";"
			. "ps[0].insertAdjacentElement('afterend',h);n++;});});</script>\n";
	}
}, 99 );
