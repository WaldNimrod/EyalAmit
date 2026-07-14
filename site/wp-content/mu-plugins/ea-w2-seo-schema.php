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
			// areaServed — D2 ratified (bounded GeoCircle, NOT areaServed:Israel): Hadera–Haifa–Sharon
			// catchment, 45km radius around the studio address. geoMidpoint geocoded from OpenStreetMap
			// Nominatim (עמל / Amal St., פרדס חנה-כרכור) — DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md D2.
			'areaServed'                => array(
				'@type'        => 'GeoCircle',
				'geoMidpoint'  => array(
					'@type'     => 'GeoCoordinates',
					'latitude'  => 32.4637761,
					'longitude' => 34.9760176,
				),
				'geoRadius'    => 45000,
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

		// --- Product node on a product page (a page carrying ea_product_price meta; W1-08) ---
		if ( is_page() ) {
			$pid = (int) get_queried_object_id();
			if ( $pid && metadata_exists( 'post', $pid, 'ea_product_price' ) ) {
				$price   = (string) get_post_meta( $pid, 'ea_product_price', true );
				$product = array(
					'@type' => 'Product',
					'@id'   => $site . '#/schema/product/' . $pid,
					'name'  => get_the_title( $pid ),
					'url'   => get_permalink( $pid ),
					'brand' => array( '@id' => $biz_id ),
				);
				if ( has_post_thumbnail( $pid ) ) {
					$product['image'] = get_the_post_thumbnail_url( $pid, 'full' );
				}
				// Offer only when the price is a real number — omit for "מחיר לפי התאמה" (no fake/zero price).
				if ( is_numeric( $price ) ) {
					$product['offers'] = array(
						'@type'         => 'Offer',
						'price'         => $price,
						'priceCurrency' => 'ILS',
						'availability'  => 'https://schema.org/InStock',
						'url'           => get_permalink( $pid ),
						'seller'        => array( '@id' => $biz_id ),
					);
				}
				$graph[] = $product;
			}
		}

		// --- FAQPage (WP-CANON T4) — visible questions only via ea_faq_query_items ---
		$ea_faq_pages = (array) apply_filters(
			'ea_seo_faq_page_categories',
			array(
				'faq'            => array(),
				'treatment'      => array( 'treatment' ),
				'sound-healing'  => array( 'sound-healing' ),
				'didgeridoos'    => array( 'didgeridoos' ),
				'bags'           => array( 'bags' ),
				'stands-storage' => array( 'stands-storage' ),
				'stand-floor'    => array( 'stand-floor' ),
				'repair'         => array( 'repair' ),
				'lessons'        => array( 'lessons' ),
				'method'         => array( 'method' ),
				'vekatavta'      => array( 'vekatavta' ),
				'kushi-blantis'  => array( 'kushi-blantis' ),
				'tsva-bekahol'   => array( 'tsva-bekahol' ),
			)
		);
		if ( is_page() && function_exists( 'ea_faq_query_items' ) ) {
			$ea_obj  = get_queried_object();
			$ea_slug = ( $ea_obj && isset( $ea_obj->post_name ) ) ? (string) $ea_obj->post_name : '';
			if ( isset( $ea_faq_pages[ $ea_slug ] ) ) {
				$ea_items = ea_faq_query_items( $ea_faq_pages[ $ea_slug ] );
				if ( ! empty( $ea_items ) ) {
					$graph[] = ea_w2_seo_schema_faqpage_node( $ea_items, $ea_slug );
				}
			}
		}

		// --- Book (WP-CANON T4) — contract: ea_chapters_field top-level schema fields from T3b ---
		$ea_book_slugs = array( 'vekatavta', 'kushi-blantis', 'tsva-bekahol' );
		if ( is_page() && function_exists( 'ea_chapters_field' ) ) {
			$ea_obj = get_queried_object();
			if ( $ea_obj instanceof WP_Post && in_array( $ea_obj->post_name, $ea_book_slugs, true ) ) {
				$graph[] = ea_w2_seo_schema_book_node( $ea_obj->post_name, (int) $ea_obj->ID );
			}
		}

		// --- Person + VideoObject: Mokesh Dahiman memorial page only (WP-CANON T1) ---
		// Routed through Yoast's single @graph (not a hand-rolled second <script>, per this
		// file's own "ONE schema engine" policy) — AND per the "no VideoObject on the muted
		// hero loop" prohibition (SEO-GEO-EXECUTION-PLAN-2026-06-20.md:74; enforced by
		// scripts/qa/seo_probe.mjs Check 9). The node below is anchored to the trailer as a
		// named, independently-identifiable work ('about' → the Person it documents,
		// 'publisher' → the business) — NOT described as "the hero decoration". Field values
		// deliberately avoid the literal substring "hero" in any key/id/url (see LOD400 T1 §3.4).
		if ( is_page() ) {
			$obj  = get_queried_object();
			$slug = ( $obj && isset( $obj->post_name ) ) ? (string) $obj->post_name : '';
			if ( 'mokesh-dahiman' === $slug ) {
				$mokesh_id  = $site . '#/schema/person/mokesh-dahiman';
				$mokesh_img = get_stylesheet_directory_uri() . '/assets/images/mokesh/mokesh-01.jpeg';

				$graph[] = array(
					'@type'         => 'Person',
					'@id'           => $mokesh_id,
					'name'          => 'מוקש דהימן',
					'alternateName' => 'Mukesh Dhiman',
					'description'   => "אמן-נגר ובונה דיג'רידו מרישיקש, הודו (1950–2020) — מורו של אייל עמית.",
					'url'           => home_url( '/eyal-amit/mokesh-dahiman/' ),
					'image'         => $mokesh_img,
					'birthDate'     => '1950',
					'deathDate'     => '2020-10-11',
					'knowsAbout'    => array( "בניית דיג'רידו בעבודת יד", 'נשימה מעגלית', 'מסורת הדיג׳רידו ברישיקש' ),
					'affiliation'   => array(
						'@type' => 'Organization',
						'name'  => 'Jungle Vibes',
					),
				);

				$graph[] = array(
					'@type'        => 'VideoObject',
					'@id'          => $site . '#/schema/video/mukesh-trailer',
					'name'         => 'MUKESH - The Art of Shanti Living | Official Trailer',
					'description'  => 'הטריילר הרשמי לסרט התיעודי על מוקש דהימן, מאסטר הדיג׳רידו מרישיקש, מאת אייל וגיא עמית.',
					'uploadDate'   => '2019-11-19T14:41:31-08:00',
					'thumbnailUrl' => 'https://i.ytimg.com/vi/kf4NKSdYi9E/maxresdefault.jpg',
					'embedUrl'     => 'https://www.youtube-nocookie.com/embed/kf4NKSdYi9E',
					'contentUrl'   => 'https://youtu.be/kf4NKSdYi9E',
					'about'        => array( '@id' => $mokesh_id ),
					'publisher'    => array( '@id' => $biz_id ),
				);
			}
		}

		return $graph;
	}
	add_filter( 'wpseo_schema_graph', 'ea_w2_seo_schema_graph', 20, 2 );

	/**
	 * Build a FAQPage schema node from ea_faq_query_items()-shaped rows.
	 *
	 * @param array  $items Rows with q/a keys.
	 * @param string $slug  Page slug for @id.
	 * @return array
	 */
	function ea_w2_seo_schema_faqpage_node( array $items, $slug ) {
		$site     = home_url( '/' );
		$entities = array();
		foreach ( $items as $it ) {
			if ( empty( $it['q'] ) || empty( $it['a'] ) ) {
				continue;
			}
			$entities[] = array(
				'@type'          => 'Question',
				'name'           => wp_strip_all_tags( (string) $it['q'] ),
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_kses_post( (string) $it['a'] ),
				),
			);
		}
		return array(
			'@type'      => 'FAQPage',
			'@id'        => $site . '#/schema/faqpage/' . $slug,
			'mainEntity' => $entities,
		);
	}

	/**
	 * Build a Book schema node from Chapters top-level schema fields (T3b contract).
	 *
	 * @param string $slug    Book page slug.
	 * @param int    $post_id Page ID.
	 * @return array
	 */
	function ea_w2_seo_schema_book_node( $slug, $post_id ) {
		$site = home_url( '/' );
		$node = array(
			'@type'      => 'Book',
			'@id'        => $site . '#/schema/book/' . $slug,
			'name'       => get_the_title( $post_id ),
			'url'        => get_permalink( $post_id ),
			'author'     => array( '@id' => $site . '#/schema/person/eyal-amit' ),
			'publisher'  => array(
				'@type' => 'Organization',
				'name'  => 'מוזה הוצאה לאור',
				'url'   => home_url( '/books/' ),
			),
			'inLanguage' => 'he',
		);
		$genre = ea_chapters_field( 'genre', $post_id );
		if ( $genre ) {
			$node['genre'] = $genre;
		}
		$year = ea_chapters_field( 'meta_year', $post_id );
		if ( $year ) {
			$node['datePublished'] = (string) $year;
		}
		$pages = ea_chapters_field( 'meta_pages', $post_id );
		if ( is_numeric( $pages ) ) {
			$node['numberOfPages'] = (int) $pages;
		}
		if ( function_exists( 'ea_chapters_img' ) ) {
			$cover = ea_chapters_img( 'cover', 'full' );
			if ( $cover ) {
				$node['image'] = $cover;
			}
		}
		$isbn = ea_chapters_field( 'isbn', $post_id );
		if ( $isbn ) {
			$node['isbn'] = $isbn;
		}

		$offers    = array();
		$price     = ea_chapters_field( 'price', $post_id );
		$print_url = ea_chapters_field( 'buy_print_url', $post_id );
		$ebook_url = ea_chapters_field( 'buy_ebook_url', $post_id );
		foreach ( array( $print_url, $ebook_url ) as $url ) {
			if ( $url && is_numeric( $price ) ) {
				$offers[] = array(
					'@type'         => 'Offer',
					'price'         => (string) $price,
					'priceCurrency' => 'ILS',
					'url'           => $url,
					'availability'  => 'https://schema.org/InStock',
				);
			}
		}
		if ( $offers ) {
			$node['offers'] = 1 === count( $offers ) ? $offers[0] : $offers;
		}

		return $node;
	}

endif;
