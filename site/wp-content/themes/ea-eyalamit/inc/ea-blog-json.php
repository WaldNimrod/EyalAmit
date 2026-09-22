<?php
/**
 * Blog post JSON renderer (ea-post-v1). Settings and row contract:
 * _COMMUNICATION/team_100/S007/POST-TEMPLATE-SETTINGS.md (repo copy under EyalAmit.co.il-2026).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sanitized slug from the staging dummy preview query arg.
 *
 * @return string
 */
function ea_blog_json_dummy_query_slug() {
	if ( empty( $_GET['ea_blog_dummy'] ) ) {
		return '';
	}
	$slug = sanitize_title( wp_unslash( (string) $_GET['ea_blog_dummy'] ) );
	return $slug ? $slug : '';
}

/**
 * Whether the current request is the staging-only dummy preview route.
 *
 * @return bool
 */
function ea_blog_json_is_dummy_preview() {
	return '' !== ea_blog_json_dummy_query_slug();
}

/**
 * Validated staging dummy preview (query arg + dummy JSON).
 *
 * @return bool
 */
function ea_blog_json_dummy_preview_active() {
	static $active = null;
	if ( null !== $active ) {
		return $active;
	}
	$slug = ea_blog_json_dummy_query_slug();
	if ( ! $slug ) {
		$active = false;
		return false;
	}
	$data = ea_blog_json_load( $slug );
	$active = ( is_array( $data ) && ! empty( $data['dummy'] ) );
	return $active;
}

/**
 * Absolute path to inc/data/blog/{slug}.json.
 *
 * @param string $slug Post slug.
 * @return string
 */
function ea_blog_json_file_path( $slug ) {
	$slug = sanitize_title( $slug );
	if ( ! $slug || ! preg_match( '/^[a-z0-9-]+$/', $slug ) ) {
		return '';
	}
	return get_stylesheet_directory() . '/inc/data/blog/' . $slug . '.json';
}

/**
 * Load and validate post JSON.
 *
 * @param string $slug Post slug.
 * @return array<string,mixed>|null
 */
function ea_blog_json_load( $slug ) {
	$path = ea_blog_json_file_path( $slug );
	if ( ! $path || ! is_readable( $path ) ) {
		return null;
	}
	$raw = file_get_contents( $path );
	if ( false === $raw ) {
		return null;
	}
	$data = json_decode( $raw, true );
	if ( ! is_array( $data ) || empty( $data['schema'] ) || 'ea-post-v1' !== $data['schema'] ) {
		return null;
	}
	if ( empty( $data['slug'] ) || sanitize_title( (string) $data['slug'] ) !== sanitize_title( $slug ) ) {
		return null;
	}
	return $data;
}

/**
 * Theme-relative image path under assets/images/.
 *
 * @param string $file Path from JSON media entry.
 * @return string
 */
function ea_blog_json_image_theme_path( $file ) {
	$file = ltrim( (string) $file, '/' );
	if ( '' === $file ) {
		return '';
	}
	if ( 0 === strpos( $file, 'assets/images/' ) ) {
		return $file;
	}
	return 'assets/images/' . $file;
}

/**
 * Resolve a media id to a public URL.
 *
 * @param string               $id   img-01…img-08.
 * @param array<string,mixed>  $data Full post JSON.
 * @return array{url:string,alt:string,cap:string,pending:bool,image:string}
 */
function ea_blog_json_media_item( $id, array $data ) {
	$out = array(
		'url'     => '',
		'alt'     => '',
		'cap'     => '',
		'pending' => false,
		'image'   => '',
	);
	$media = isset( $data['media'] ) && is_array( $data['media'] ) ? $data['media'] : array();
	foreach ( $media as $item ) {
		if ( ! is_array( $item ) || empty( $item['id'] ) || (string) $item['id'] !== (string) $id ) {
			continue;
		}
		$out['alt']     = isset( $item['alt'] ) ? (string) $item['alt'] : '';
		$out['cap']     = isset( $item['cap'] ) ? (string) $item['cap'] : '';
		$out['pending'] = ! empty( $item['pending'] );
		$theme_path     = ea_blog_json_image_theme_path( $item['file'] ?? '' );
		$out['image']   = $theme_path;
		if ( $theme_path && function_exists( 'ea_chapters_resolve_img' ) ) {
			$out['url'] = ea_chapters_resolve_img( $theme_path );
		} elseif ( $theme_path && function_exists( 'ea_chapters_asset_url' ) ) {
			$out['url'] = ea_chapters_asset_url( $theme_path );
		}
		break;
	}
	return $out;
}

/**
 * Map row background token to part args flags.
 *
 * @param string              $bg   ivory|ivory-2|dark|cta.
 * @param array<string,mixed> $args Args being built.
 * @return array<string,mixed>
 */
function ea_blog_json_apply_bg( $bg, array $args ) {
	switch ( (string) $bg ) {
		case 'ivory-2':
			$args['alt'] = true;
			break;
		case 'dark':
			$args['dark'] = true;
			break;
		default:
			break;
	}
	return $args;
}

/**
 * Build template-part args for one JSON row.
 *
 * @param array<string,mixed> $row  Row object.
 * @param array<string,mixed> $data Full post JSON.
 * @return array{part:string,args:array<string,mixed>}|null
 */
function ea_blog_json_row_part( array $row, array $data ) {
	$part = isset( $row['part'] ) ? (string) $row['part'] : '';
	if ( '' === $part ) {
		return null;
	}
	$bg   = isset( $row['bg'] ) ? (string) $row['bg'] : 'ivory';
	$args = array();
	if ( ! empty( $row['id'] ) ) {
		$args['id'] = (string) $row['id'];
	}

	switch ( $part ) {
		case 'prose':
			$args = ea_blog_json_apply_bg( $bg, $args );
			if ( ! empty( $row['title'] ) ) {
				$args['title'] = (string) $row['title'];
			}
			if ( ! empty( $row['body'] ) ) {
				$args['body'] = (string) $row['body'];
			}
			if ( ! empty( $row['center'] ) ) {
				$args['center'] = true;
			}
			if ( ! empty( $row['float'] ) ) {
				$mi = ea_blog_json_media_item( (string) $row['float'], $data );
				if ( $mi['url'] ) {
					$args['float_image'] = $mi['url'];
					$args['float_alt']   = $mi['alt'];
				}
			}
			return array( 'part' => 'prose', 'args' => $args );

		case 'quote':
			$args = ea_blog_json_apply_bg( $bg, $args );
			$quote = isset( $row['body'] ) ? (string) $row['body'] : '';
			$args['body'] = '<blockquote><p>' . esc_html( $quote ) . '</p></blockquote>';
			return array( 'part' => 'prose', 'args' => $args );

		case 'split':
			$images = isset( $row['images'] ) && is_array( $row['images'] ) ? $row['images'] : array();
			$img_id = $images[0] ?? '';
			$mi     = $img_id ? ea_blog_json_media_item( (string) $img_id, $data ) : array();
			if ( ! empty( $row['title'] ) ) {
				$args['title'] = (string) $row['title'];
			}
			if ( ! empty( $row['body'] ) ) {
				$args['body'] = (string) $row['body'];
			}
			if ( ! empty( $mi['url'] ) ) {
				$args['image'] = $mi['url'];
				$args['alt']   = $mi['alt'];
			}
			if ( ! empty( $row['zoom'] ) ) {
				$args['zoom'] = true;
			}
			return array( 'part' => 'split', 'args' => $args );

		case 'gallery':
			$args['alt'] = ( 'ivory' === $bg ) ? false : true;
			if ( ! empty( $row['title'] ) ) {
				$args['title'] = (string) $row['title'];
			}
			$items   = array();
			$img_ids = isset( $row['images'] ) && is_array( $row['images'] ) ? $row['images'] : array();
			foreach ( $img_ids as $img_id ) {
				$mi = ea_blog_json_media_item( (string) $img_id, $data );
				$items[] = array(
					'image'   => $mi['image'] ? $mi['image'] : ( $mi['url'] ?? '' ),
					'alt'     => $mi['alt'],
					'cap'     => $mi['cap'],
					'pending' => $mi['pending'] && ! $mi['url'],
				);
			}
			$args['items'] = $items;
			return array( 'part' => 'gallery', 'args' => $args );

		case 'photo-slot':
			$args['label'] = ! empty( $row['title'] ) ? (string) $row['title'] : ( ! empty( $row['body'] ) ? (string) $row['body'] : 'Photo — to be chosen' );
			return array( 'part' => 'photo-slot', 'args' => $args );

		case 'cta':
			if ( ! empty( $row['title'] ) ) {
				$args['title'] = (string) $row['title'];
			}
			if ( ! empty( $row['body'] ) ) {
				$args['body'] = (string) $row['body'];
			}
			if ( ! empty( $row['cta_label'] ) ) {
				$args['cta_label'] = (string) $row['cta_label'];
			}
			if ( ! empty( $row['cta_url'] ) ) {
				$args['cta_url'] = (string) $row['cta_url'];
			}
			return array( 'part' => 'cta', 'args' => $args );

		case 'video':
			if ( ! empty( $row['title'] ) ) {
				$args['title'] = (string) $row['title'];
			}
			if ( ! empty( $row['body'] ) ) {
				$args['body'] = (string) $row['body'];
			}
			$video_meta = isset( $data['video'] ) && is_array( $data['video'] ) ? $data['video'] : array();
			$file       = isset( $video_meta['file'] ) ? (string) $video_meta['file'] : '';
			$poster     = isset( $video_meta['poster'] ) ? (string) $video_meta['poster'] : '';
			if ( $file && function_exists( 'ea_chapters_resolve_img' ) ) {
				$args['video'] = ea_chapters_resolve_img( $file );
			} elseif ( $file && function_exists( 'ea_chapters_asset_url' ) ) {
				$args['video'] = ea_chapters_asset_url( $file );
			}
			if ( $poster && function_exists( 'ea_chapters_resolve_img' ) ) {
				$args['poster'] = ea_chapters_resolve_img( $poster );
			} elseif ( $poster && function_exists( 'ea_chapters_asset_url' ) ) {
				$args['poster'] = ea_chapters_asset_url( $poster );
			}
			if ( ! empty( $video_meta['cap'] ) ) {
				$args['cap'] = (string) $video_meta['cap'];
			}
			if ( empty( $args['video'] ) && ! empty( $video_meta['youtube'] ) ) {
				$yt_id = preg_replace( '/[^A-Za-z0-9_-]/', '', (string) $video_meta['youtube'] );
				if ( $yt_id ) {
					$args['body'] = ( $args['body'] ?? '' ) . '<div class="videoblk r r2" style="margin-top:48px"><iframe src="https://www.youtube-nocookie.com/embed/' . esc_attr( $yt_id ) . '" title="' . esc_attr( $args['title'] ?? __( 'וידאו', 'ea-eyalamit' ) ) . '" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy" style="position:absolute;inset:0;width:100%;height:100%;border:0"></iframe></div>';
				}
			}
			return array( 'part' => 'videoblk', 'args' => $args );

		default:
			return null;
	}
}

/**
 * Resolve image paths inside gallery row args (after row_part).
 *
 * @param array<string,mixed> $args Template args.
 * @return array<string,mixed>
 */
function ea_blog_json_resolve_gallery_args( array $args ) {
	if ( empty( $args['items'] ) || ! is_array( $args['items'] ) ) {
		return $args;
	}
	foreach ( $args['items'] as $i => $it ) {
		if ( ! is_array( $it ) || empty( $it['image'] ) ) {
			continue;
		}
		if ( function_exists( 'ea_chapters_resolve_img' ) ) {
			$args['items'][ $i ]['image'] = ea_chapters_resolve_img( $it['image'] );
		} elseif ( function_exists( 'ea_chapters_asset_url' ) ) {
			$args['items'][ $i ]['image'] = ea_chapters_asset_url( $it['image'] );
		}
	}
	return $args;
}

/**
 * Render all rows for a loaded JSON document.
 *
 * @param array<string,mixed> $data Post JSON.
 */
function ea_blog_json_render_rows( array $data ) {
	$rows = isset( $data['rows'] ) && is_array( $data['rows'] ) ? $data['rows'] : array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$mapped = ea_blog_json_row_part( $row, $data );
		if ( ! $mapped ) {
			continue;
		}
		if ( 'gallery' === $mapped['part'] ) {
			$mapped['args'] = ea_blog_json_resolve_gallery_args( $mapped['args'] );
		}
		get_template_part( 'template-parts/chapters/parts/' . $mapped['part'], null, $mapped['args'] );
	}
}

/**
 * Phero args from JSON hero block.
 *
 * @param array<string,mixed> $data Post JSON.
 * @return array<string,mixed>
 */
function ea_blog_json_phero_args( array $data ) {
	$hero = isset( $data['hero'] ) && is_array( $data['hero'] ) ? $data['hero'] : array();
	$sub  = '';
	if ( ! empty( $data['author'] ) || ! empty( $data['date'] ) ) {
		$sub = sprintf(
			/* translators: 1: author, 2: date */
			esc_html__( 'מאת %1$s · %2$s', 'ea-eyalamit' ),
			isset( $data['author'] ) ? (string) $data['author'] : '',
			isset( $data['date'] ) ? (string) $data['date'] : ''
		);
	}
	$media     = '';
	$media_alt = isset( $hero['imageAlt'] ) ? (string) $hero['imageAlt'] : '';
	$img_file  = isset( $hero['image'] ) ? trim( (string) $hero['image'] ) : '';
	if ( '' !== $img_file ) {
		$path = ea_blog_json_image_theme_path( $img_file );
		if ( $path && function_exists( 'ea_chapters_resolve_img' ) ) {
			$media = ea_chapters_resolve_img( $path );
		} elseif ( $path && function_exists( 'ea_chapters_asset_url' ) ) {
			$media = ea_chapters_asset_url( $path );
		}
	}
	return array(
		'chap'      => isset( $hero['chap'] ) ? (string) $hero['chap'] : ( isset( $data['category'] ) ? (string) $data['category'] : '' ),
		'title'     => isset( $data['title'] ) ? esc_html( (string) $data['title'] ) : '',
		'sub'       => $sub,
		'media'     => $media,
		'media_alt' => $media_alt ? esc_attr( $media_alt ) : ( isset( $data['title'] ) ? esc_attr( (string) $data['title'] ) : '' ),
	);
}

/**
 * Slug whose JSON should drive the current blog single view.
 *
 * @return string
 */
function ea_blog_json_active_slug() {
	if ( ea_blog_json_is_dummy_preview() ) {
		return ea_blog_json_dummy_query_slug();
	}
	if ( is_singular( 'post' ) ) {
		return (string) get_post_field( 'post_name', get_queried_object_id() );
	}
	return '';
}

/**
 * Whether rows should replace the_content for this request.
 *
 * @return bool
 */
function ea_blog_json_use_rows() {
	$slug = ea_blog_json_active_slug();
	if ( ! $slug ) {
		return false;
	}
	$data = ea_blog_json_load( $slug );
	if ( ! $data ) {
		return false;
	}
	if ( ! empty( $data['dummy'] ) ) {
		return ea_blog_json_is_dummy_preview();
	}
	return true;
}

/**
 * Loaded JSON for the active slug when rows mode is on.
 *
 * @return array<string,mixed>|null
 */
function ea_blog_json_active_data() {
	if ( ! ea_blog_json_use_rows() ) {
		return null;
	}
	return ea_blog_json_load( ea_blog_json_active_slug() );
}

/**
 * Staging dummy preview: force blog single chrome and noindex.
 *
 * @param string $tpl Current template.
 * @return string
 */
function ea_blog_json_dummy_template_include( $tpl ) {
	if ( ! function_exists( 'ea_chapters_enabled' ) || ! ea_chapters_enabled() ) {
		return $tpl;
	}
	$slug = ea_blog_json_dummy_query_slug();
	if ( ! $slug ) {
		return $tpl;
	}
	$data = ea_blog_json_load( $slug );
	if ( ! $data || empty( $data['dummy'] ) ) {
		return $tpl;
	}
	$found = locate_template( 'page-templates/tpl-chapters-blog-single.php' );
	if ( $found ) {
		set_query_var( 'ea_wave2_shell', true );
		return $found;
	}
	return $tpl;
}
add_filter( 'template_include', 'ea_blog_json_dummy_template_include', 110 );

/**
 * Noindex for dummy preview URLs.
 */
function ea_blog_json_dummy_robots() {
	if ( ! ea_blog_json_is_dummy_preview() ) {
		return;
	}
	$slug = ea_blog_json_dummy_query_slug();
	$data = $slug ? ea_blog_json_load( $slug ) : null;
	if ( ! $data || empty( $data['dummy'] ) ) {
		return;
	}
	if ( ! headers_sent() ) {
		header( 'X-Robots-Tag: noindex, nofollow', true );
	}
	add_filter(
		'wp_robots',
		static function ( $robots ) {
			$robots['noindex']   = true;
			$robots['nofollow']  = true;
			return $robots;
		},
		100
	);
}
add_action( 'template_redirect', 'ea_blog_json_dummy_robots', 1 );
