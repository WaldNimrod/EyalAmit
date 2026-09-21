<?php
/**
 * Plugin Name: EA EI-T19 — Blog exception posts media + hrefs (once)
 * Description: P002/P006/P008/P048 — featured images + href fixes from production; P008 women photos + dot cleanup.
 * Version: 1.0.0
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'EA_EI_T19_SOURCE' ) ) {
	define( 'EA_EI_T19_SOURCE', 'https://www.eyalamit.co.il' );
}

/**
 * Legacy path → new-site relative path (subset of ea-w209 map + EI fixes).
 *
 * @return array<string,string>
 */
function ea_ei_t19_path_map() {
	return array(
		'/דיגרידו-המרכז-לטיפול-בדיגרידו-סטודי/מוקש-דהימן-מאסטר-דיגרידו-דף-להנצחת-זכ/' => '/eyal-amit/mokesh-dahiman/',
		'/דיגרידו-המרכז-לטיפול-בדיגרידו-סטודי/הדיגרידו-ככלי-לריפוי-עצמי/'             => '/treatment/',
		'/דיגרידו-המרכז-לטיפול-בדיגרידו-סטודי/שיעורי-נגינה-בדיגרידו/'                 => '/lessons/',
		'/books/כושי-בלאנטיס/'                                                         => '/books/kushi-blantis/',
		'/books/כושי-בלנטיס/'                                                          => '/books/kushi-blantis/',
		'/shop/cart/'                                                                  => '/shop/',
		'/'                                                                            => '/',
	);
}

/**
 * @param string $url Absolute legacy URL.
 * @return string Relative path for the new site.
 */
function ea_ei_t19_map_href( $url ) {
	$path = (string) wp_parse_url( $url, PHP_URL_PATH );
	$path = rawurldecode( $path );
	$norm = trailingslashit( $path );
	$map  = ea_ei_t19_path_map();
	if ( isset( $map[ $norm ] ) ) {
		return $map[ $norm ];
	}
	if ( preg_match( '#^/Blog/(.+)$#i', $norm, $m ) ) {
		return trailingslashit( '/' . $m[1] );
	}
	return $norm;
}

/**
 * @param string $html Post HTML.
 * @return string
 */
function ea_ei_t19_rewrite_hrefs( $html ) {
	return (string) preg_replace_callback(
		'#https?://(?:www\.)?eyalamit\.co\.il([^"\'\s>]*)#iu',
		static function ( $m ) {
			return ea_ei_t19_map_href( 'https://www.eyalamit.co.il' . $m[1] );
		},
		$html
	);
}

/**
 * @param string $html Post HTML.
 * @return string
 */
function ea_ei_t19_strip_lone_dots( $html ) {
	$html = (string) preg_replace( '#<div[^>]*>\s*\.\s*</div>#iu', ' ', $html );
	$html = (string) preg_replace( '#<p[^>]*>\s*\.\s*</p>#iu', ' ', $html );
	return $html;
}

/**
 * @param string $url Remote image URL.
 * @param int    $post_id Parent post.
 * @return int Attachment ID or 0.
 */
function ea_ei_t19_sideload_image( $url, $post_id ) {
	if ( ! function_exists( 'media_sideload_image' ) ) {
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}

	$aid = media_sideload_image( $url, $post_id, null, 'id' );
	if ( is_wp_error( $aid ) ) {
		return 0;
	}
	return (int) $aid;
}

/**
 * @param string $prod_blog_path Path after /Blog/ (encoded or literal).
 * @return string HTML or empty.
 */
function ea_ei_t19_fetch_production_html( $prod_blog_path ) {
	$url  = trailingslashit( EA_EI_T19_SOURCE . '/Blog/' . ltrim( $prod_blog_path, '/' ) );
	$resp = wp_remote_get(
		$url,
		array(
			'timeout'    => 30,
			'user-agent' => 'EA-EI-T19/1.0; WordPress/' . get_bloginfo( 'version' ),
		)
	);
	if ( is_wp_error( $resp ) || 200 !== (int) wp_remote_retrieve_response_code( $resp ) ) {
		return '';
	}
	return (string) wp_remote_retrieve_body( $resp );
}

/**
 * @param string $html Production page HTML.
 * @return string[]
 */
function ea_ei_t19_content_image_urls( $html ) {
	$chunk = $html;
	if ( preg_match( '#class="[^"]*post_content_holder[^"]*"[^>]*>(.*)</div>\s*</div>#is', $html, $m ) ) {
		$chunk = $m[1];
	} elseif ( preg_match( '#class="[^"]*entry-content[^"]*"[^>]*>(.*)</div>#is', $html, $m ) ) {
		$chunk = $m[1];
	}
	preg_match_all(
		'#https://www\.eyalamit\.co\.il/wp-content/uploads/[^"\'\s>]+\.(?:jpe?g|png|webp)#iu',
		$chunk,
		$matches
	);
	$out = array();
	foreach ( $matches[0] as $url ) {
		if ( preg_match( '#/(fav|logo|Icon-|cropped-logo|master-logo)#i', $url ) ) {
			continue;
		}
		if ( preg_match( '#-\d+x\d+\.#', $url ) ) {
			continue;
		}
		if ( ! in_array( $url, $out, true ) ) {
			$out[] = $url;
		}
	}
	return $out;
}

/**
 * @return void
 */
function ea_ei_t19_maybe_run() {
	if ( 'done' === get_option( 'ea_ei_t19_blog_v3_done', '' ) ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( get_transient( 'ea_ei_t19_blog_lock' ) ) {
		return;
	}
	set_transient( 'ea_ei_t19_blog_lock', 1, 180 );

	try {
		$jobs = array(
			array(
				'slug'      => 'מורה-לדיגרידו-מודה-למוריו-תלמידיו-ומט',
				'prod_path' => '%d7%9e%d7%95%d7%a8%d7%94-%d7%9c%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%9e%d7%95%d7%93%d7%94-%d7%9c%d7%9e%d7%95%d7%a8%d7%99%d7%95-%d7%aa%d7%9c%d7%9e%d7%99%d7%93%d7%99%d7%95-%d7%95%d7%9e%d7%98',
				'featured'  => EA_EI_T19_SOURCE . '/wp-content/uploads/2024/08/449633618_10171106140875206_1091675749536197018_n-700x1243-1.jpg',
			),
			array(
				'slug'      => 'ריברסינג-נשימה-מעגלית-דיגרידו',
				'prod_path' => '%d7%a8%d7%99%d7%91%d7%a8%d7%a1%d7%99%d7%a0%d7%92-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%9e%d7%a2%d7%92%d7%9c%d7%99%d7%aa-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95',
				'featured'  => EA_EI_T19_SOURCE . '/wp-content/uploads/2025/04/%E2%80%8F%E2%80%8F%D7%9C%D7%9B%D7%92%D7%92%D7%99%D7%93%D7%94.jpg',
			),
			array(
				'slug'           => 'נשים-מנגנות-בדיגרידו-אישה-מנגנת-בדיג',
				'prod_path'      => '%d7%a0%d7%a9%d7%99%d7%9d-%d7%9e%d7%a0%d7%92%d7%a0%d7%95%d7%aa-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%90%d7%99%d7%a9%d7%94-%d7%9e%d7%a0%d7%92%d7%a0%d7%aa-%d7%91%d7%93%d7%99%d7%92',
				'featured'       => EA_EI_T19_SOURCE . '/wp-content/uploads/2025/02/275302194_10168178567520206_2098729360236844113_n.jpg',
				'body_images'      => array(
					EA_EI_T19_SOURCE . '/wp-content/uploads/2025/02/275304745_10168178568145206_8303380660628675257_n-500x950.jpg',
					EA_EI_T19_SOURCE . '/wp-content/uploads/2025/02/275306461_10168178568815206_8633556448398060825_n-500x950.jpg',
					EA_EI_T19_SOURCE . '/wp-content/uploads/2025/02/275305865_10168178571120206_4810100867964574940_n-500x950.jpg',
					EA_EI_T19_SOURCE . '/wp-content/uploads/2025/02/275377841_10168178567435206_8857887367660911677_n-500x950.jpg',
					EA_EI_T19_SOURCE . '/wp-content/uploads/2025/02/275307914_10168178567225206_9109260503880350505_n-500x950.jpg',
					EA_EI_T19_SOURCE . '/wp-content/uploads/2025/02/275306455_10168178567305206_3277191078486302628_n-500x950.jpg',
				),
				'replace_images' => true,
				'strip_dots'     => true,
			),
			array(
				'slug'      => '34-הטור-של-אייל-עמית-הלב',
				'prod_path' => '34-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%94%d7%9c%d7%91',
				'featured'  => EA_EI_T19_SOURCE . '/wp-content/uploads/2017/06/%D7%9B%D7%95%D7%A9%D7%99-%D7%91%D7%9C%D7%90%D7%A0%D7%98%D7%99%D7%A1-%D7%A2%D7%98%D7%99%D7%A4%D7%94-%D7%9E%D7%9C%D7%90%D7%94.jpg',
				'kushi'     => true,
			),
		);

		foreach ( $jobs as $job ) {
			$posts = get_posts(
				array(
					'post_type'      => 'post',
					'name'           => $job['slug'],
					'post_status'    => 'publish',
					'posts_per_page' => 1,
				)
			);
			if ( empty( $posts ) ) {
				continue;
			}
			$post    = $posts[0];
			$post_id = (int) $post->ID;
			$content = (string) $post->post_content;

			$content = ea_ei_t19_rewrite_hrefs( $content );

			if ( ! empty( $job['kushi'] ) ) {
				$content = (string) preg_replace(
					'#https?://(?:www\.)?eyalamit\.co\.il/books/[^"\']+#iu',
					'/books/kushi-blantis/',
					$content
				);
				$content = (string) preg_replace(
					'#href="/books/[^"]*כושי[^"]*"#iu',
					'href="/books/kushi-blantis/"',
					$content
				);
			}

			if ( ! empty( $job['strip_dots'] ) ) {
				$content = ea_ei_t19_strip_lone_dots( $content );
			}

			if ( ! empty( $job['replace_images'] ) ) {
				$src_urls = ! empty( $job['body_images'] ) && is_array( $job['body_images'] )
					? $job['body_images']
					: ea_ei_t19_content_image_urls( ea_ei_t19_fetch_production_html( $job['prod_path'] ) );
				if ( $src_urls ) {
					$new_urls = array();
					foreach ( $src_urls as $src ) {
						$aid = ea_ei_t19_sideload_image( $src, $post_id );
						if ( $aid > 0 ) {
							$new_urls[] = wp_get_attachment_url( $aid );
						}
					}
					if ( $new_urls ) {
						$idx = 0;
						$content = (string) preg_replace_callback(
							'#src="([^"]+)"#',
							static function ( $m ) use ( &$idx, $new_urls ) {
								if ( false !== strpos( $m[1], 'ea-legacy/' ) && isset( $new_urls[ $idx ] ) ) {
									$url = $new_urls[ $idx ];
									++$idx;
									return 'src="' . esc_url( $url ) . '"';
								}
								return $m[0];
							},
							$content
						);
					}
				}
			}

			if ( $content !== $post->post_content ) {
				wp_update_post(
					array(
						'ID'           => $post_id,
						'post_content' => $content,
					)
				);
			}

			if ( ! empty( $job['featured'] ) && get_post_thumbnail_id( $post_id ) < 1 ) {
				$thumb_id = ea_ei_t19_sideload_image( $job['featured'], $post_id );
				if ( $thumb_id > 0 ) {
					set_post_thumbnail( $post_id, $thumb_id );
				}
			}
		}

		update_option( 'ea_ei_t19_blog_v3_done', 'done', false );
	} finally {
		delete_transient( 'ea_ei_t19_blog_lock' );
	}
}
add_action( 'init', 'ea_ei_t19_maybe_run', 35 );
