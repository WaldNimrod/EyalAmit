<?php
/**
 * Plugin Name: EA S006 — wave 10 lectures/workshops FAQ + Yoast (once)
 * Description: Inserts lectures/workshops/snoring FAQ seed keys into ea_faq CPT
 *   and sets Yoast title+metadesc on /learning/lectures/ and /learning/workshops/
 *   from the 19.8 md. Does not touch block-faq-list.php. Reads answers FROM JSON.
 *
 *   Reset: delete_option('ea_s006_w10_faq_seo_v1_done').
 * Version: 1.0.0
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	static function () {
		if ( 'done' === get_option( 'ea_s006_w10_faq_seo_v1_done', '' ) ) {
			return;
		}
		if ( wp_installing() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
			return;
		}
		if ( ! post_type_exists( 'ea_faq' ) ) {
			return;
		}

		$labels = array(
			'lectures'            => 'הרצאות',
			'workshops'           => "סדנאות דיג'רידו",
			'snoring-sleep-apnea' => 'טיפול בנחירות ודום נשימה',
		);
		foreach ( $labels as $slug => $name ) {
			$exist = term_exists( $slug, 'ea_faq_cat' );
			if ( $exist ) {
				wp_update_term( (int) ( is_array( $exist ) ? $exist['term_id'] : $exist ), 'ea_faq_cat', array( 'name' => $name ) );
			} else {
				wp_insert_term( $name, 'ea_faq_cat', array( 'slug' => $slug ) );
			}
		}

		$keys = array();
		for ( $i = 1; $i <= 6; $i++ ) {
			$keys[] = 'lectures-0' . $i;
		}
		for ( $i = 1; $i <= 11; $i++ ) {
			$keys[] = 'workshops-' . str_pad( (string) $i, 2, '0', STR_PAD_LEFT );
		}
		for ( $i = 1; $i <= 6; $i++ ) {
			$keys[] = 'snoring-faq-0' . $i;
		}

		$file = get_stylesheet_directory() . '/inc/data/ea-faq-seed.json';
		if ( ! is_readable( $file ) ) {
			return;
		}
		$raw = json_decode( (string) file_get_contents( $file ), true );
		if ( empty( $raw['items'] ) || ! is_array( $raw['items'] ) ) {
			return;
		}
		$by = array();
		foreach ( $raw['items'] as $row ) {
			if ( isset( $row['seed_key'] ) ) {
				$by[ $row['seed_key'] ] = $row;
			}
		}

		foreach ( $keys as $k ) {
			if ( empty( $by[ $k ]['q'] ) || empty( $by[ $k ]['a'] ) ) {
				continue;
			}
			$ids = get_posts(
				array(
					'post_type'   => 'ea_faq',
					'post_status' => 'any',
					'numberposts' => 1,
					'fields'      => 'ids',
					'meta_key'    => '_ea_faq_seed_key',
					'meta_value'  => $k,
				)
			);
			if ( empty( $ids ) ) {
				$post_id = wp_insert_post(
					array(
						'post_type'    => 'ea_faq',
						'post_status'  => 'publish',
						'post_title'   => $by[ $k ]['q'],
						'post_content' => $by[ $k ]['a'],
					),
					true
				);
				if ( is_wp_error( $post_id ) ) {
					continue;
				}
				update_post_meta( $post_id, '_ea_faq_seed_key', $k );
			} else {
				$post_id = (int) $ids[0];
				wp_update_post(
					array(
						'ID'           => $post_id,
						'post_title'   => $by[ $k ]['q'],
						'post_content' => $by[ $k ]['a'],
						'post_status'  => 'publish',
					)
				);
			}
			wp_set_object_terms( $post_id, (array) $by[ $k ]['categories'], 'ea_faq_cat', false );
		}

		$seo = array(
			'learning/lectures'  => array(
				'title' => "הרצאות על נשימה, סטרס ודיג'רידו | אייל עמית",
				'desc'  => 'הרצאות של אייל עמית המשלבות סיפור אישי, נשימה, דיג\'רידו, מחקר והדגמות חיות. לחברות, ארגונים, כנסים, קהילות וקבוצות פרטיות.',
			),
			'learning/workshops' => array(
				'title' => "סדנאות דיג'רידו ונשימה לקבוצות וארגונים | אייל עמית",
				'desc'  => "סדנת נשימה אקטיבית באמצעות דיג'רידו לקבוצות, חברות וארגונים. לומדים על הנשימה, סטרס, הפקת צליל ועקרונות הנשימה המעגלית בדיג'רידו, ללא צורך בניסיון קודם.",
			),
		);
		foreach ( $seo as $path => $meta ) {
			$page = get_page_by_path( $path, OBJECT, 'page' );
			if ( ! $page ) {
				continue;
			}
			update_post_meta( (int) $page->ID, '_yoast_wpseo_title', $meta['title'] );
			update_post_meta( (int) $page->ID, '_yoast_wpseo_metadesc', wp_strip_all_tags( $meta['desc'] ) );
		}

		update_option( 'ea_s006_w10_faq_seo_v1_done', 'done' );
	},
	45
);
