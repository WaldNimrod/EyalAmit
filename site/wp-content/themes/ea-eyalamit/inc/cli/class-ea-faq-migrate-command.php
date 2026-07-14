<?php
/**
 * WP-CLI: migrate inc/data/ea-faq-seed.json → ea_faq posts + ea_faq_cat terms.
 * WP-CANON T2 — idempotent via _ea_faq_seed_key postmeta.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'ea-faq migrate', 'Ea_Faq_Migrate_Command' );
}

/**
 * FAQ seed migration command.
 */
class Ea_Faq_Migrate_Command {

	/**
	 * Hebrew labels for ea_faq_cat terms (display order = array key order).
	 *
	 * @return array<string,string>
	 */
	private function category_labels() {
		return array(
			'treatment'      => "טיפול בדיג'רידו",
			'lessons'        => "שיעורי נגינה בדיג'רידו",
			'sound-healing'  => "סאונד הילינג בדיג'רידו",
			'method'         => 'השיטה — cbDIDG',
			'didgeridoos'    => "רכישת דיג'רידו",
			'bags'           => "תיקים לדיג'רידו",
			'stands-storage' => "סטנדים לאחסון דיג'רידו",
			'stand-floor'    => 'סטנד רצפתי לנגינה',
			'repair'         => "תיקון וחידוש דיג'רידו",
			'general'        => 'שאלות כלליות',
			'vekatavta'      => 'וכתבת',
			'kushi-blantis'  => 'כושי בלאנטיס',
			'tsva-bekahol'   => 'צבע בכחול',
		);
	}

	/**
	 * Migrates inc/data/ea-faq-seed.json into ea_faq posts + ea_faq_cat terms.
	 *
	 * ## OPTIONS
	 *
	 * [--dry-run]
	 * : Print planned inserts, write nothing.
	 *
	 * ## EXAMPLES
	 *
	 *     wp ea-faq migrate --dry-run
	 *     wp ea-faq migrate
	 *
	 * @param array $args       Positional args.
	 * @param array $assoc_args Associative args.
	 */
	public function __invoke( $args, $assoc_args ) {
		$dry  = isset( $assoc_args['dry-run'] );
		$path = get_stylesheet_directory() . '/inc/data/ea-faq-seed.json';
		$raw  = json_decode( (string) file_get_contents( $path ), true );
		if ( empty( $raw['items'] ) ) {
			WP_CLI::error( 'ea-faq-seed.json missing or empty.' );
		}

		$labels = $this->category_labels();

		// Collect slugs present in seed (preserve canonical display order from labels map).
		$seed_slugs = array();
		foreach ( $raw['items'] as $item ) {
			foreach ( (array) $item['categories'] as $slug ) {
				$seed_slugs[ $slug ] = true;
			}
		}
		$ordered_slugs = array();
		foreach ( array_keys( $labels ) as $slug ) {
			if ( isset( $seed_slugs[ $slug ] ) ) {
				$ordered_slugs[] = $slug;
			}
		}
		foreach ( array_keys( $seed_slugs ) as $slug ) {
			if ( ! in_array( $slug, $ordered_slugs, true ) ) {
				$ordered_slugs[] = $slug;
			}
		}

		// 1) Terms — explicit order drives ea_faq_get_categories() display order.
		foreach ( $ordered_slugs as $slug ) {
			$name  = $labels[ $slug ] ?? $slug;
			$exist = term_exists( $slug, 'ea_faq_cat' );
			if ( $exist ) {
				if ( ! $dry ) {
					wp_update_term( (int) ( is_array( $exist ) ? $exist['term_id'] : $exist ), 'ea_faq_cat', array( 'name' => $name ) );
				}
				WP_CLI::log( ( $dry ? '[dry-run] term exists: ' : 'updated term: ' ) . $slug );
				continue;
			}
			WP_CLI::log( ( $dry ? '[dry-run] would create term: ' : 'creating term: ' ) . $slug );
			if ( ! $dry ) {
				wp_insert_term( $name, 'ea_faq_cat', array( 'slug' => $slug ) );
			}
		}

		// 2) Posts — idempotent via _ea_faq_seed_key postmeta.
		foreach ( $raw['items'] as $item ) {
			$existing = get_posts(
				array(
					'post_type'   => 'ea_faq',
					'post_status' => 'any',
					'meta_key'    => '_ea_faq_seed_key',
					'meta_value'  => $item['seed_key'],
					'numberposts' => 1,
					'fields'      => 'ids',
				)
			);
			if ( ! empty( $existing ) ) {
				WP_CLI::log( 'skip (exists): ' . $item['seed_key'] );
				continue;
			}
			WP_CLI::log( ( $dry ? '[dry-run] would create post: ' : 'creating post: ' ) . $item['seed_key'] );
			if ( $dry ) {
				continue;
			}
			$post_id = wp_insert_post(
				array(
					'post_type'    => 'ea_faq',
					'post_status'  => 'publish',
					'post_title'   => $item['q'],
					'post_content' => $item['a'],
				),
				true
			);
			if ( is_wp_error( $post_id ) ) {
				WP_CLI::warning( $item['seed_key'] . ': ' . $post_id->get_error_message() );
				continue;
			}
			update_post_meta( $post_id, '_ea_faq_seed_key', $item['seed_key'] );
			wp_set_object_terms( $post_id, $item['categories'], 'ea_faq_cat', false );
		}
		WP_CLI::success( $dry ? 'Dry run complete.' : 'Migration complete.' );
	}
}
