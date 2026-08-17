<?php
/**
 * Chapters part — text + 16:9 placeholder box (no video file yet).
 *
 * Treatment-only use in S006 R1-02. Does not edit videoblk.php.
 * S006 · שיטת פלייסהולדר: הוראת team_00 17.8.26.
 *
 * $args: chap, title, body(HTML), box, id
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a   = isset( $args ) && is_array( $args ) ? $args : array();
$box = isset( $a['box'] ) && '' !== $a['box'] ? (string) $a['box'] : '';
?>
<section class="sec sec--alt"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap">
		<div style="max-width:760px">
			<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
			<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r" style="margin-bottom:18px"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
			<?php if ( ! empty( $a['body'] ) ) : ?><div class="intro-body r r2"><?php echo wp_kses_post( $a['body'] ); ?></div><?php endif; ?>
		</div>
		<?php if ( '' !== $box ) : ?>
		<div class="videoblk r r2" style="margin-top:48px" role="img" aria-label="<?php echo esc_attr( $box ); ?>">
			<div class="ea-pending-approval" role="status" style="position:absolute;inset:16px;margin:0">
				<span class="ea-pending-approval__badge">ממתין לאישור</span>
				<p class="ea-pending-approval__title"><?php echo esc_html( $box ); ?></p>
			</div>
		</div>
		<?php endif; ?>
	</div>
</section>
