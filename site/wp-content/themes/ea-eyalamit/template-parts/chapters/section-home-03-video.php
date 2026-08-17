<?php
/**
 * Home-only SECTION 03 — video skeleton + visible placeholder.
 *
 * S006 · מקור מבנה: סקירה דף הבית.xlsx · גיליון1!B9 («פרק 3 - וידאו»).
 * S006 · שיטת פלייסהולדר: הוראת team_00 17.8.26 — טקסט גיבריש + קופסה 16:9.
 * התוכן האמיתי חסום (H-06). אין URL. אין תמונת stock.
 *
 * Home-only file — does not edit shared parts/*.php.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$chap = (string) ea_chapters_field( 'video_chap' );
$title = (string) ea_chapters_field( 'video_title' );
$body  = (string) ea_chapters_field( 'video_placeholder_body' );
$box   = (string) ea_chapters_field( 'video_placeholder_box' );
?>
<section class="sec sec--alt" id="video">
	<div class="wrap">
		<?php if ( $chap ) : ?><span class="chap r"><?php echo esc_html( $chap ); ?></span><?php endif; ?>
		<?php if ( $title ) : ?><h2 class="h2 r" style="margin-bottom:18px"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
		<?php if ( $body ) : ?><div class="intro-body r r2"><?php echo wp_kses_post( $body ); ?></div><?php endif; ?>
		<div class="videoblk r r2" style="margin-top:48px" role="img" aria-label="<?php echo esc_attr( $box ); ?>">
			<div class="ea-pending-approval" role="status" style="position:absolute;inset:16px;margin:0">
				<span class="ea-pending-approval__badge">ממתין לאישור</span>
				<p class="ea-pending-approval__title"><?php echo esc_html( $box ); ?></p>
			</div>
		</div>
	</div>
</section>
