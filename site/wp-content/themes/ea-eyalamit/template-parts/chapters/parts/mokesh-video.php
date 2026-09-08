<?php
/**
 * Chapters part — Mokesh documentary embed. PAGE-SPECIFIC to /mokesh/, not reusable:
 * loaded only from mokesh-defaults.php. See M-04 action 1.
 *
 * $args: yt_id (YouTube id), title (iframe accessible name — WCAG 4.1.2).
 *
 * Deliberately a PLAIN <iframe>, not a YT.Player instance. mokesh-hero.php already
 * mounts the same video as a muted looping hero background through the YouTube
 * IFrame API (ea-mokesh.js), and a second API player on the same document fights
 * the first over the shared global API object. A plain iframe cannot collide.
 *
 * Host is youtube-nocookie.com: D-6 makes a consent banner mandatory, and a plain
 * youtube.com embed sets a cookie before consent is given. ea-mokesh.js:72 already
 * uses the same host, so the page stays consistent.
 *
 * Sizing is inline (aspect-ratio) rather than a new CSS rule — the box must not
 * collapse or shift while the iframe loads, and inline style is the established
 * pattern in these parts (videoblk.php, split.php, prose.php all do it).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$yt_id = $a['yt_id'] ?? '';
if ( '' === $yt_id ) {
	return; // אין תוכן = אין רכיב — a missing id renders nothing at all.
}
$src = 'https://www.youtube-nocookie.com/embed/' . rawurlencode( $yt_id );
?>
<section class="sec">
	<div class="wrap">
		<div class="r r2" style="max-width:760px;margin-inline:auto">
			<div class="figr" style="position:relative;aspect-ratio:16/9">
				<iframe
					src="<?php echo esc_url( $src ); ?>"
					title="<?php echo esc_attr( $a['title'] ?? '' ); ?>"
					loading="lazy"
					referrerpolicy="strict-origin-when-cross-origin"
					allow="accelerometer; encrypted-media; gyroscope; picture-in-picture; web-share"
					allowfullscreen
					style="position:absolute;inset:0;width:100%;height:100%;border:0"></iframe>
			</div>
		</div>
	</div>
</section>
