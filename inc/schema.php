<?php
/**
 * DecorZa SEO & Schema Engine
 *
 * Emits Schema.org JSON-LD structured data and Open Graph / Twitter Card meta tags.
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output Schema.org JSON-LD in wp_head
 */
function decorza_output_schema_jsonld() {
	if ( ! get_theme_mod( 'decorza_enable_schema', true ) ) {
		return;
	}

	$schemas = array();

	// 1. Organization Schema
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$logo_url       = $custom_logo_id ? wp_get_attachment_image_url( $custom_logo_id, 'full' ) : '';

	$social_links = array_filter( array(
		get_theme_mod( 'decorza_social_facebook' ),
		get_theme_mod( 'decorza_social_instagram' ),
		get_theme_mod( 'decorza_social_pinterest' ),
		get_theme_mod( 'decorza_social_twitter' ),
		get_theme_mod( 'decorza_social_youtube' ),
	) );

	$org_schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Organization',
		'name'        => get_bloginfo( 'name' ),
		'url'         => home_url( '/' ),
		'description' => get_bloginfo( 'description' ),
	);

	if ( ! empty( $logo_url ) ) {
		$org_schema['logo'] = array(
			'@type' => 'ImageObject',
			'url'   => $logo_url,
		);
	}

	if ( ! empty( $social_links ) ) {
		$org_schema['sameAs'] = array_values( $social_links );
	}

	$schemas[] = $org_schema;

	// 2. WebSite Schema (Homepage / General)
	$website_schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'WebSite',
		'name'            => get_bloginfo( 'name' ),
		'url'             => home_url( '/' ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => home_url( '/?s={search_term_string}' ),
			'query-input' => 'required name=search_term_string',
		),
	);
	$schemas[] = $website_schema;

	// 3. Article / BlogPosting Schema (Single Posts)
	if ( is_single() ) {
		global $post;

		$author_id   = $post->post_author;
		$author_name = get_the_author_meta( 'display_name', $author_id );
		$author_url  = get_author_posts_url( $author_id );

		$excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( $post->post_content ), 28 );

		$article_schema = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'BlogPosting',
			'mainEntityOfPage' => array(
				'@type' => 'WebPage',
				'@id'   => get_permalink(),
			),
			'headline'         => wp_strip_all_tags( get_the_title() ),
			'description'      => $excerpt,
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'author'           => array(
				'@type' => 'Person',
				'name'  => $author_name,
				'url'   => $author_url,
			),
			'publisher'        => array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
				'logo'  => ! empty( $logo_url ) ? array( '@type' => 'ImageObject', 'url' => $logo_url ) : null,
			),
		);

		if ( has_post_thumbnail() ) {
			$thumb_url = get_the_post_thumbnail_url( $post->ID, 'full' );
			$article_schema['image'] = array(
				'@type' => 'ImageObject',
				'url'   => $thumb_url,
			);
		}

		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			$article_schema['articleSection'] = $categories[0]->name;
		}

		$schemas[] = $article_schema;
	}

	// 4. BreadcrumbList Schema
	if ( ! is_front_page() ) {
		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => __( 'Home', 'decorza' ),
			'item'     => home_url( '/' ),
		);

		$pos = 2;
		if ( is_category() ) {
			$category = get_queried_object();
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => $pos,
				'name'     => $category->name,
				'item'     => get_category_link( $category->term_id ),
			);
		} elseif ( is_single() ) {
			$cats = get_the_category();
			if ( ! empty( $cats ) ) {
				$cat = $cats[0];
				$breadcrumbs[] = array(
					'@type'    => 'ListItem',
					'position' => $pos,
					'name'     => $cat->name,
					'item'     => get_category_link( $cat->term_id ),
				);
				$pos++;
			}
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => $pos,
				'name'     => get_the_title(),
				'item'     => get_permalink(),
			);
		} elseif ( is_page() ) {
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => $pos,
				'name'     => get_the_title(),
				'item'     => get_permalink(),
			);
		}

		if ( count( $breadcrumbs ) > 1 ) {
			$schemas[] = array(
				'@context'        => 'https://schema.org',
				'@type'           => 'BreadcrumbList',
				'itemListElement' => $breadcrumbs,
			);
		}
	}

	// Output valid JSON-LD
	foreach ( $schemas as $schema ) {
		echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
	}
}
add_action( 'wp_head', 'decorza_output_schema_jsonld', 1 );

/**
 * Output Open Graph and Twitter Card Meta Tags
 */
function decorza_output_social_meta_tags() {
	if ( ! get_theme_mod( 'decorza_enable_opengraph', true ) ) {
		return;
	}

	$title       = get_bloginfo( 'name' );
	$description = get_theme_mod( 'decorza_default_meta_desc', get_bloginfo( 'description' ) );
	$url         = home_url( '/' );
	$type        = 'website';
	$image       = '';

	if ( is_single() || is_page() ) {
		global $post;
		$title       = get_the_title();
		$description = has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( $post->post_content ), 25 );
		$url         = get_permalink();
		$type        = is_single() ? 'article' : 'website';

		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( $post->ID, 'large' );
		}
	} elseif ( is_category() || is_tag() ) {
		$term = get_queried_object();
		if ( $term ) {
			$title       = $term->name . ' - ' . get_bloginfo( 'name' );
			$description = ! empty( $term->description ) ? wp_strip_all_tags( $term->description ) : $description;
			$url         = get_term_link( $term );
		}
	}

	// Fallback image from custom logo or hero image
	if ( empty( $image ) ) {
		$hero_img = get_theme_mod( 'decorza_hero_image', '' );
		if ( ! empty( $hero_img ) ) {
			$image = $hero_img;
		}
	}

	echo "\n<!-- DecorZa Open Graph & Twitter Cards -->\n";
	echo '<meta property="og:locale" content="' . esc_attr( get_locale() ) . '">' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";

	if ( ! empty( $image ) ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
	}

	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";

	if ( ! empty( $image ) ) {
		echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
	}
	echo "<!-- /DecorZa Open Graph -->\n\n";
}
add_action( 'wp_head', 'decorza_output_social_meta_tags', 2 );
