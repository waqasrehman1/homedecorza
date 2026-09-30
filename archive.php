<?php
/**
 * The template for displaying archive pages (Categories, Tags, Authors, Dates)
 *
 * Full-width Hero Banner section with dynamic Category Title (H1),
 * description, post count, and category image.
 *
 * @package DecorZa
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$queried_obj = get_queried_object();
$term_id     = ( $queried_obj && isset( $queried_obj->term_id ) ) ? $queried_obj->term_id : 0;
$cat_img_url = $term_id ? decorza_get_category_image_url( $term_id, 'decorza-hero' ) : '';
$post_count  = ( $queried_obj && isset( $queried_obj->count ) ) ? $queried_obj->count : 0;
$has_sidebar = get_theme_mod( 'decorza_enable_sidebar', true );
$sidebar_pos = get_theme_mod( 'decorza_sidebar_position', 'right' );
$blog_layout = get_theme_mod( 'decorza_blog_layout', 'grid' );
$layout_class= $has_sidebar ? 'decorza-layout-with-sidebar' . ( 'left' === $sidebar_pos ? ' sidebar-left' : '' ) : '';
$grid_class  = ( 'list' === $blog_layout ) ? 'decorza-grid' : ( $has_sidebar ? 'decorza-grid decorza-grid-2' : 'decorza-grid decorza-grid-3' );

// Archive type badge label
$archive_type_label = __( 'Archive', 'decorza' );
if ( is_category() ) {
	$archive_type_label = __( 'Category', 'decorza' );
} elseif ( is_tag() ) {
	$archive_type_label = __( 'Topic Tag', 'decorza' );
} elseif ( is_author() ) {
	$archive_type_label = __( 'Author Archive', 'decorza' );
}
?>

<!-- Category / Archive Full-Width Hero Banner Section -->
<section class="decorza-archive-hero<?php echo ! empty( $cat_img_url ) ? ' has-featured-image' : ''; ?>">
	<div class="decorza-container">
		<div class="decorza-archive-hero-grid<?php echo empty( $cat_img_url ) ? ' no-image' : ''; ?>">
			<!-- Left Column: Title, Badge, Description, Count -->
			<div class="decorza-archive-hero-text">
				<div class="decorza-archive-hero-badges">
					<span class="decorza-badge"><?php echo esc_html( $archive_type_label ); ?></span>
					<?php if ( $post_count > 0 ) : ?>
						<span class="decorza-archive-count-pill">
							<svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
							<?php printf( esc_html( _n( '%s Curated Article', '%s Curated Articles', $post_count, 'decorza' ) ), esc_html( number_format_i18n( $post_count ) ) ); ?>
						</span>
					<?php endif; ?>
				</div>

				<h1 class="decorza-archive-hero-title">
					<?php
					if ( is_category() ) {
						single_cat_title();
					} elseif ( is_tag() ) {
						single_tag_title();
					} elseif ( is_author() ) {
						the_author();
					} else {
						the_archive_title();
					}
					?>
				</h1>

				<?php
				$archive_desc = get_the_archive_description();
				if ( ! empty( $archive_desc ) ) :
					?>
					<div class="decorza-archive-hero-desc">
						<?php echo wp_kses_post( $archive_desc ); ?>
					</div>
				<?php else : ?>
					<p class="decorza-archive-hero-desc">
						<?php esc_html_e( 'Explore our curated interior inspiration, styling advice, and timeless home design formulas.', 'decorza' ); ?>
					</p>
				<?php endif; ?>
			</div>

			<!-- Right Column: Featured Category Image (if set) -->
			<?php if ( ! empty( $cat_img_url ) ) : ?>
				<div class="decorza-archive-hero-media">
					<div class="decorza-archive-hero-img-wrap">
						<img src="<?php echo esc_url( $cat_img_url ); ?>" alt="<?php echo esc_attr( single_term_title( '', false ) ); ?>" />
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Main Archive Content Section -->
<div class="decorza-section">
	<div class="decorza-container">
		<?php decorza_breadcrumbs(); ?>

		<div class="<?php echo esc_attr( $layout_class ); ?>">
			<div class="decorza-content-area">
				<?php if ( have_posts() ) : ?>
					<div class="<?php echo esc_attr( $grid_class ); ?>">
						<?php
						while ( have_posts() ) :
							the_post();
							if ( 'list' === $blog_layout ) {
								get_template_part( 'template-parts/content', 'horizontal' );
							} else {
								get_template_part( 'template-parts/content', 'card' );
							}
						endwhile;
						?>
					</div>

					<!-- Numbered Pagination -->
					<?php decorza_pagination(); ?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>

			<?php if ( $has_sidebar ) : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
get_footer();
