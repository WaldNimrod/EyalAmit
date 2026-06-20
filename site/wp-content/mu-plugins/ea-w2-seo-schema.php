<?php
/**
 * Plugin Name: EA W2 — SEO entity schema (extends Yoast @graph)
 * Description: Adds the entity-grounding nodes Yoast's default graph lacks — Person
 *   (Eyal Amit + sameAs), the business as ProfessionalService (NAP from the
 *   BUSINESS-NAP-AND-HOURS SSoT; ProfessionalService inherits LocalBusiness props),
 *   and a Service node per service route. Hooks Yoast's wpseo_schema_graph so there is
 *   ONE schema engine (no hand-rolled second @graph). S004-P001-WP002 (Wave-1 W1-02).
 * Version: 1.0.0
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'ea_w2_seo_schema_graph' ) ) :

	/**
	 * Append entity nodes to Yoast's @graph.
	 *
	 * @param array $graph   Yoast schema graph pieces.
	 * @param mixed $context Yoast meta-tags context (unused).
	 * @return array
	 */
	function ea_w2_seo_schema_graph( $graph, $context = null ) {
		if ( ! is_array( $graph ) ) {
			return $graph;
		}

		$site      = home_url( '/' );
		$img       = get_stylesheet_directory_uri() . '/assets/images/eyal-portrait-hero.jpg';
		$person_id = $site . '#/schema/person/eyal-amit';
		$biz_id    = $site . '#/schema/business/cbdidg';

		// sameAs — verified-live channels (hub/data/social-channels.json) + he.wikipedia article.
		$same_as = array(
			'https://he.wikipedia.org/wiki/%D7%90%D7%99%D7%99%D7%9C_%D7%A2%D7%9E%D7%99%D7%AA',
			'https://www.facebook.com/didgeridoo.studio.eyal.amit',
			'https://www.instagram.com/didgeridoo.therapy.center',
			'https://www.youtube.com/@%D7%90%D7%99%D7%99%D7%9C%D7%A2%D7%9E%D7%99%D7%AA',
		);

		// --- Person: Eyal Amit (author/practitioner entity) ---
		$graph[] = array(
			'@type'      => 'Person',
			'@id'        => $person_id,
			'name'       => 'אייל עמית',
			'url'        => home_url( '/eyal-amit/' ),
			'image'      => $img,
			'jobTitle'   => 'מאסטר דיג\'רידו ומטפל בנשימה',
			'worksFor'   => array( '@id' => $biz_id ),
			'knowsAbout' => array( 'טיפול בנשימה באמצעות דיג\'רידו', 'סאונד הילינג', 'נשימה מעגלית', 'דום נשימה בשינה ונחירות', 'נגינה בדיג\'רידו' ),
			'sameAs'     => $same_as,
		);

		// --- Business: cbDIDG breath-therapy center (NAP SSoT; ProfessionalService inherits LocalBusiness) ---
		$graph[] = array(
			'@type'                     => 'ProfessionalService',
			'@id'                       => $biz_id,
			'name'                      => 'המרכז לטיפול בנשימה באמצעות דיג\'רידו',
			'alternateName'             => 'cbDIDG',
			'url'                       => $site,
			'image'                     => $img,
			'telephone'                 => '+972-52-482-2842',
			'founder'                   => array( '@id' => $person_id ),
			'address'                   => array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => 'עמל 8 ב\'',
				'addressLocality' => 'פרדס חנה-כרכור',
				'addressCountry'  => 'IL',
			),
			'openingHoursSpecification' => array(
				array(
					'@type'     => 'OpeningHoursSpecification',
					'dayOfWeek' => array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday' ),
					'opens'     => '09:00',
					'closes'    => '19:00',
				),
				array(
					'@type'     => 'OpeningHoursSpecification',
					'dayOfWeek' => 'Friday',
					'opens'     => '09:00',
					'closes'    => '14:00',
				),
			),
			'sameAs'                    => $same_as,
		);

		// --- Service node on the matching service route ---
		$services = array(
			'treatment'     => 'טיפול בנשימה באמצעות דיג\'רידו',
			'sound-healing' => 'סאונד הילינג',
			'lessons'       => 'שיעורי נגינה בדיג\'רידו',
		);
		if ( is_page() ) {
			$obj  = get_queried_object();
			$slug = ( $obj && isset( $obj->post_name ) ) ? (string) $obj->post_name : '';
			if ( isset( $services[ $slug ] ) ) {
				$graph[] = array(
					'@type'       => 'Service',
					'@id'         => $site . '#/schema/service/' . $slug,
					'name'        => $services[ $slug ],
					'serviceType' => $services[ $slug ],
					'provider'    => array( '@id' => $biz_id ),
					'url'         => home_url( '/' . $slug . '/' ),
				);
			}
		}

		return $graph;
	}
	add_filter( 'wpseo_schema_graph', 'ea_w2_seo_schema_graph', 20, 2 );

endif;
