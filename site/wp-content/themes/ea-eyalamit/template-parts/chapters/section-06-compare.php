<?php
/**
 * Chapters — 06 COMPARE (two photo cards: treatment vs sound-healing).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$lead  = ea_chapters_field( 'cmp_lead' );
$cards = array(
	array(
		'img'   => ea_chapters_img( 'cmp_a_image' ),
		'title' => ea_chapters_field( 'cmp_a_title' ),
		'text'  => ea_chapters_field( 'cmp_a_text' ),
		'cta'   => ea_chapters_field( 'cmp_a_cta' ),
		'url'   => ea_chapters_field( 'cmp_a_url' ),
		'rcls'  => 'r',
	),
	array(
		'img'   => ea_chapters_img( 'cmp_b_image' ),
		'title' => ea_chapters_field( 'cmp_b_title' ),
		'text'  => ea_chapters_field( 'cmp_b_text' ),
		'cta'   => ea_chapters_field( 'cmp_b_cta' ),
		'url'   => ea_chapters_field( 'cmp_b_url' ),
		'rcls'  => 'r r2',
	),
);
?>
<section class="sec" id="compare">
	<div class="wrap center">
		<span class="chap chap--c r"><?php echo esc_html( ea_chapters_field( 'cmp_chap' ) ); ?></span>
		<h2 class="h2 r"><?php echo esc_html( ea_chapters_field( 'cmp_title' ) ); ?></h2>
		<?php if ( $lead ) : ?>
			<p class="lead r" style="margin-top:14px"><?php echo esc_html( $lead ); ?></p>
		<?php endif; ?>
		<div class="cmp">
			<?php foreach ( $cards as $c ) : ?>
				<div class="cmpc <?php echo esc_attr( $c['rcls'] ); ?>">
					<span class="cmpc__m">
						<?php if ( $c['img'] ) : ?>
							<img src="<?php echo esc_url( $c['img'] ); ?>" alt="" loading="lazy">
						<?php endif; ?>
					</span>
					<span class="cmpc__sc" aria-hidden="true"></span>
					<div class="cmpc__b">
						<h3 class="cmpc__t"><?php echo esc_html( $c['title'] ); ?></h3>
						<p class="cmpc__p"><?php echo esc_html( $c['text'] ); ?></p>
						<?php if ( $c['cta'] ) : ?>
							<a class="btn btn--gw" href="<?php echo esc_url( $c['url'] ); ?>"><?php echo esc_html( $c['cta'] ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
