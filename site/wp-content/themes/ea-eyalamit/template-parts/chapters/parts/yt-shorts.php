<?php
/**
 * Chapters part — one or two YouTube Shorts.
 *
 * $args: chap, title, body (HTML), id, items[] of yt_id + title (iframe name).
 * A single yt_id is accepted and treated as one item.
 * Host is youtube-nocookie.com, same as mokesh-video.php.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
if ( ! $items && ! empty( $a['yt_id'] ) ) {
	$items = array(
		array(
			'yt_id' => $a['yt_id'],
			'title' => $a['title'] ?? '',
		),
	);
}
$ready = array();
foreach ( $items as $item ) {
	if ( ! is_array( $item ) ) {
		continue;
	}
	$id = preg_replace( '/[^A-Za-z0-9_-]/', '', (string) ( $item['yt_id'] ?? '' ) );
	if ( '' === $id ) {
		continue;
	}
	$ready[] = array(
		'yt_id' => $id,
		'title' => (string) ( $item['title'] ?? '' ),
	);
}
if ( ! $ready ) {
	return;
}
?>
<section class="sec sec--alt"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap">
		<?php if ( ! empty( $a['chap'] ) || ! empty( $a['title'] ) || ! empty( $a['body'] ) ) : ?>
		<div style="max-width:760px">
			<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap r"><?php echo ea_esc_visible_text( $a['chap'] ); ?></span><?php endif; ?>
			<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r" style="margin-bottom:18px"><?php echo ea_esc_visible_text( $a['title'] ); ?></h2><?php endif; ?>
			<?php if ( ! empty( $a['body'] ) ) : ?><div class="intro-body r r2"><?php echo ea_chapters_prepare_body_html( $a['body'] ); ?></div><?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="ea-yt-shorts">
			<?php foreach ( $ready as $item ) : ?>
			<div class="ea-yt-shorts__f">
				<iframe
					src="<?php echo esc_url( 'https://www.youtube-nocookie.com/embed/' . rawurlencode( $item['yt_id'] ) ); ?>"
					title="<?php echo esc_attr( $item['title'] ); ?>"
					loading="lazy"
					referrerpolicy="strict-origin-when-cross-origin"
					allow="accelerometer; encrypted-media; gyroscope; picture-in-picture; web-share"
					allowfullscreen
					style="position:absolute;inset:0;width:100%;height:100%;border:0"></iframe>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
