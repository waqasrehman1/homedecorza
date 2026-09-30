<?php
/**
 * DecorZa Custom Template Tags & Helpers
 *
 * Includes: Breadcrumbs, Reading Time, Table of Contents, Social Share,
 * Author Box, Related Posts, and Pagination.
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =============================================================================
// 1. BREADCRUMBS
// =============================================================================
if ( ! function_exists( 'decorza_breadcrumbs' ) ) :
function decorza_breadcrumbs() {
	if ( ! get_theme_mod( 'decorza_enable_breadcrumbs', true ) ) {
		return;
	}

	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="decorza-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumbs', 'decorza' ) . '">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'decorza' ) . '</a>';
	echo '<span class="decorza-breadcrumbs-separator">/</span>';

	if ( is_category() ) {
		single_cat_title();
	} elseif ( is_tag() ) {
		single_tag_title( __( 'Tag: ', 'decorza' ) );
	} elseif ( is_author() ) {
		echo '<span>' . esc_html( get_the_author() ) . '</span>';
	} elseif ( is_year() ) {
		echo '<span>' . esc_html( get_the_date( 'Y' ) ) . '</span>';
	} elseif ( is_month() ) {
		echo '<a href="' . esc_url( get_year_link( get_the_date( 'Y' ) ) ) . '">' . esc_html( get_the_date( 'Y' ) ) . '</a>';
		echo '<span class="decorza-breadcrumbs-separator">/</span>';
		echo '<span>' . esc_html( get_the_date( 'F' ) ) . '</span>';
	} elseif ( is_search() ) {
		/* translators: %s: search query */
		printf( '<span>' . esc_html__( 'Search: "%s"', 'decorza' ) . '</span>', esc_html( get_search_query() ) );
	} elseif ( is_404() ) {
		echo '<span>' . esc_html__( 'Page Not Found', 'decorza' ) . '</span>';
	} elseif ( is_single() ) {
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			$category = $categories[0];
			echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
			echo '<span class="decorza-breadcrumbs-separator">/</span>';
		}
		echo '<span class="decorza-breadcrumbs-current">' . wp_trim_words( get_the_title(), 5 ) . '</span>';
	} elseif ( is_page() ) {
		the_title( '<span>', '</span>' );
	}

	echo '</nav>';
}
endif;

// =============================================================================
// 2. ESTIMATED READING TIME
// =============================================================================
if ( ! function_exists( 'decorza_reading_time' ) ) :
function decorza_reading_time() {
	if ( ! get_theme_mod( 'decorza_enable_reading_time', true ) ) {
		return '';
	}

	$post_content = get_post_field( 'post_content', get_the_ID() );
	$word_count   = str_word_count( wp_strip_all_tags( $post_content ) );
	$reading_time = ceil( $word_count / 200 ); // Average 200 words per minute

	if ( $reading_time < 1 ) {
		$reading_time = 1;
	}

	/* translators: %s: number of minutes */
	return sprintf( _n( '%s min read', '%s mins read', $reading_time, 'decorza' ), number_format_i18n( $reading_time ) );
}
endif;

// =============================================================================
// 3. TABLE OF CONTENTS
// =============================================================================
if ( ! function_exists( 'decorza_table_of_contents' ) ) :
function decorza_table_of_contents( $content ) {
	if ( ! is_single() || ! get_theme_mod( 'decorza_enable_toc', true ) ) {
		return $content;
	}

	// Match H2 and H3 tags
	preg_match_all( '/<h([2-3])(.*?)>(.*?)<\/h[2-3]>/i', $content, $matches, PREG_SET_ORDER );

	if ( count( $matches ) < 2 ) {
		return $content;
	}

	$toc_html = '<div class="decorza-toc-box" id="decorza-toc">';
	$toc_html .= '<div class="decorza-toc-header">';
	$toc_html .= '<h4 class="decorza-toc-title"><svg width="18" height="18" fill="var(--color-secondary)" viewBox="0 0 24 24"><path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/></svg> ' . esc_html__( 'Table of Contents', 'decorza' ) . '</h4>';
	$toc_html .= '<span class="decorza-toc-toggle" style="cursor: pointer;">' . esc_html__( '[Hide]', 'decorza' ) . '</span>';
	$toc_html .= '</div>';
	$toc_html .= '<ol class="decorza-toc-list">';

	$modified_content = $content;

	foreach ( $matches as $index => $match ) {
		$level     = $match[1];
		$attrs     = $match[2];
		$title_raw = $match[3];
		$title     = wp_strip_all_tags( $title_raw );
		$slug      = sanitize_title( $title );

		if ( empty( $slug ) ) {
			$slug = 'heading-' . ( $index + 1 );
		}

		$toc_html .= '<li class="decorza-toc-item toc-level-' . esc_attr( $level ) . '">';
		$toc_html .= '<a href="#' . esc_attr( $slug ) . '">' . esc_html( $title ) . '</a>';
		$toc_html .= '</li>';

		// Replace original heading with one containing the ID
		$new_heading = '<h' . $level . $attrs . ' id="' . esc_attr( $slug ) . '">' . $title_raw . '</h' . $level . '>';
		$modified_content = substr_replace( $modified_content, $new_heading, strpos( $modified_content, $match[0] ), strlen( $match[0] ) );
	}

	$toc_html .= '</ol>';
	$toc_html .= '</div>';

	// Inset TOC before the first H2 tag
	$first_h2_pos = strpos( $modified_content, '<h2' );
	if ( false !== $first_h2_pos ) {
		return substr_replace( $modified_content, $toc_html . '<h2', $first_h2_pos, 3 );
	}

	return $toc_html . $modified_content;
}
add_filter( 'the_content', 'decorza_table_of_contents', 20 );
endif;

// =============================================================================
// 4. FLOATING SOCIAL SHARE BUTTONS
// =============================================================================
if ( ! function_exists( 'decorza_social_share' ) ) :
function decorza_social_share() {
	if ( ! is_single() || ! get_theme_mod( 'decorza_enable_social_share', true ) ) {
		return;
	}

	$permalink = urlencode( get_permalink() );
	$title     = urlencode( get_the_title() );
	$image     = has_post_thumbnail() ? urlencode( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ) : '';

	?>
	<!-- Floating Social Share (Desktop) -->
	<aside class="decorza-social-share-floating" aria-label="<?php esc_attr_e( 'Share this article', 'decorza' ); ?>">
		<!-- Pinterest (Crucial for Home Decor) -->
		<a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_attr( $permalink ); ?>&media=<?php echo esc_attr( $image ); ?>&description=<?php echo esc_attr( $title ); ?>" target="_blank" rel="noopener noreferrer" class="decorza-share-btn decorza-share-pinterest" aria-label="<?php esc_attr_e( 'Pin on Pinterest', 'decorza' ); ?>" title="<?php esc_attr_e( 'Pin on Pinterest', 'decorza' ); ?>">
			<svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345-.09.375-.291 1.199-.334 1.373-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>
		</a>

		<!-- Facebook -->
		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr( $permalink ); ?>" target="_blank" rel="noopener noreferrer" class="decorza-share-btn decorza-share-facebook" aria-label="<?php esc_attr_e( 'Share on Facebook', 'decorza' ); ?>" title="<?php esc_attr_e( 'Share on Facebook', 'decorza' ); ?>">
			<svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>
		</a>

		<!-- Twitter / X -->
		<a href="https://twitter.com/intent/tweet?url=<?php echo esc_attr( $permalink ); ?>&text=<?php echo esc_attr( $title ); ?>" target="_blank" rel="noopener noreferrer" class="decorza-share-btn decorza-share-twitter" aria-label="<?php esc_attr_e( 'Post on X', 'decorza' ); ?>" title="<?php esc_attr_e( 'Post on X', 'decorza' ); ?>">
			<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
		</a>

		<!-- WhatsApp -->
		<a href="https://api.whatsapp.com/send?text=<?php echo esc_attr( $title . '%20' . $permalink ); ?>" target="_blank" rel="noopener noreferrer" class="decorza-share-btn decorza-share-whatsapp" aria-label="<?php esc_attr_e( 'Share via WhatsApp', 'decorza' ); ?>" title="<?php esc_attr_e( 'Share via WhatsApp', 'decorza' ); ?>">
			<svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
		</a>

		<!-- Copy Link -->
		<button type="button" class="decorza-share-btn decorza-share-copy" aria-label="<?php esc_attr_e( 'Copy link', 'decorza' ); ?>" title="<?php esc_attr_e( 'Copy link', 'decorza' ); ?>">
			<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
		</button>
	</aside>

	<!-- Mobile Share Bar -->
	<aside class="decorza-social-share-mobile" aria-label="<?php esc_attr_e( 'Share this article', 'decorza' ); ?>">
		<a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_attr( $permalink ); ?>&media=<?php echo esc_attr( $image ); ?>&description=<?php echo esc_attr( $title ); ?>" target="_blank" rel="noopener noreferrer" class="decorza-share-btn decorza-share-pinterest" aria-label="Pinterest">
			<svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345-.09.375-.291 1.199-.334 1.373-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>
		</a>
		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr( $permalink ); ?>" target="_blank" rel="noopener noreferrer" class="decorza-share-btn decorza-share-facebook" aria-label="Facebook">
			<svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>
		</a>
		<a href="https://twitter.com/intent/tweet?url=<?php echo esc_attr( $permalink ); ?>&text=<?php echo esc_attr( $title ); ?>" target="_blank" rel="noopener noreferrer" class="decorza-share-btn decorza-share-twitter" aria-label="Twitter">
			<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
		</a>
		<a href="https://api.whatsapp.com/send?text=<?php echo esc_attr( $title . '%20' . $permalink ); ?>" target="_blank" rel="noopener noreferrer" class="decorza-share-btn decorza-share-whatsapp" aria-label="WhatsApp">
			<svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
		</a>
		<button type="button" class="decorza-share-btn decorza-share-copy" aria-label="Copy Link">
			<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
		</button>
	</aside>
	<?php
}
endif;

// =============================================================================
// 5. AUTHOR BIO BOX
// =============================================================================
if ( ! function_exists( 'decorza_author_box' ) ) :
function decorza_author_box() {
	if ( ! get_theme_mod( 'decorza_enable_author_box', true ) ) {
		return;
	}

	$author_id          = get_the_author_meta( 'ID' );
	$author_name        = get_the_author();
	$author_bio         = get_the_author_meta( 'description' );
	$author_posts_url   = get_author_posts_url( $author_id );
	$fallback_avatar    = get_theme_mod( 'decorza_author_default_avatar', '' );

	if ( empty( $author_bio ) ) {
		$author_bio = __( 'Interior design enthusiast and contributing editor at HomeDecorZa. Passionate about architecture, sustainable textiles, and contemporary room transformations.', 'decorza' );
	}

	?>
	<section class="decorza-single-author-box" aria-label="<?php esc_attr_e( 'About the Author', 'decorza' ); ?>">
		<div class="decorza-author-box-avatar">
			<?php
			if ( ! empty( $fallback_avatar ) ) {
				echo '<img src="' . esc_url( $fallback_avatar ) . '" alt="' . esc_attr( $author_name ) . '" width="90" height="90">';
			} else {
				echo get_avatar( $author_id, 90, '', $author_name );
			}
			?>
		</div>
		<div class="decorza-author-box-content">
			<span class="decorza-author-box-role"><?php esc_html_e( 'Written By', 'decorza' ); ?></span>
			<h3 class="decorza-author-box-name"><a href="<?php echo esc_url( $author_posts_url ); ?>"><?php echo esc_html( $author_name ); ?></a></h3>
			<p class="decorza-author-box-bio"><?php echo esc_html( $author_bio ); ?></p>
			<div class="decorza-author-box-links">
				<a href="<?php echo esc_url( $author_posts_url ); ?>" style="font-weight: 600; color: var(--color-secondary);">
					<?php /* translators: %s: Author name */ printf( esc_html__( 'View all articles by %s →', 'decorza' ), esc_html( $author_name ) ); ?>
				</a>
			</div>
		</div>
	</section>
	<?php
}
endif;

// =============================================================================
// 6. RELATED POSTS
// =============================================================================
if ( ! function_exists( 'decorza_related_posts' ) ) :
function decorza_related_posts() {
	if ( ! get_theme_mod( 'decorza_enable_related_posts', true ) ) {
		return;
	}

	$categories = get_the_category();
	if ( empty( $categories ) ) {
		return;
	}

	$cat_ids = wp_list_pluck( $categories, 'term_id' );

	$related_query = new WP_Query( array(
		'category__in'   => $cat_ids,
		'post__not_in'   => array( get_the_ID() ),
		'posts_per_page' => 3,
		'ignore_sticky_posts' => 1,
	) );

	// Fallback to recent posts if no other posts in this category
	if ( ! $related_query->have_posts() ) {
		$related_query = new WP_Query( array(
			'post__not_in'        => array( get_the_ID() ),
			'posts_per_page'      => 3,
			'ignore_sticky_posts' => 1,
		) );
	}

	if ( $related_query->have_posts() ) :
		?>
		<section class="decorza-related-posts-section" aria-label="<?php esc_attr_e( 'Related Articles', 'decorza' ); ?>">
			<div class="decorza-section-header" style="text-align: left; margin-bottom: 2rem;">
				<h3 class="decorza-section-title"><?php esc_html_e( 'You Might Also Love', 'decorza' ); ?></h3>
			</div>
			<div class="decorza-grid decorza-grid-3">
				<?php
				while ( $related_query->have_posts() ) :
					$related_query->the_post();
					get_template_part( 'template-parts/content', 'card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</section>
		<?php
	endif;
}
endif;

// =============================================================================
// 7. NUMBERED PAGINATION
// =============================================================================
if ( ! function_exists( 'decorza_pagination' ) ) :
function decorza_pagination( $query = null ) {
	if ( null === $query ) {
		global $wp_query;
		$query = $wp_query;
	}

	$total_pages = $query->max_num_pages;

	if ( $total_pages > 1 ) {
		$current_page = max( 1, get_query_var( 'paged' ) );
		echo '<nav class="decorza-pagination" aria-label="' . esc_attr__( 'Page navigation', 'decorza' ) . '">';
		echo paginate_links( array( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'base'      => get_pagenum_link( 1 ) . '%_%',
			'format'    => 'page/%#%/',
			'current'   => $current_page,
			'total'     => $total_pages,
			'prev_text' => '&larr; ' . __( 'Prev', 'decorza' ),
			'next_text' => __( 'Next', 'decorza' ) . ' &rarr;',
			'type'      => 'plain',
		) );
		echo '</nav>';
	}
}
endif;

// =============================================================================
// 8. CATEGORY BADGE HELPER
// =============================================================================
if ( ! function_exists( 'decorza_category_badge' ) ) :
function decorza_category_badge() {
	$categories = get_the_category();
	if ( ! empty( $categories ) ) {
		$category = $categories[0];
		echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="decorza-badge">' . esc_html( $category->name ) . '</a>';
	}
}
endif;
