<?php
/**
 * The template for displaying search results pages
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$has_sidebar  = get_theme_mod( 'decorza_enable_sidebar', true );
$sidebar_pos  = get_theme_mod( 'decorza_sidebar_position', 'right' );
$layout_class = $has_sidebar ? 'decorza-layout-with-sidebar' . ( 'left' === $sidebar_pos ? ' sidebar-left' : '' ) : '';
$grid_class   = $has_sidebar ? 'decorza-grid decorza-grid-2' : 'decorza-grid decorza-grid-3';
?>

<header class="decorza-category-hero" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); color: #FFFFFF; padding: 3.5rem 1.5rem 3rem; text-align: center;">
	<div class="decorza-container" style="max-width: 800px;">
		<span class="decorza-badge" style="background: var(--color-secondary); color: #FFF; margin-bottom: 0.75rem;"><?php esc_html_e( 'SEARCH RESULTS', 'decorza' ); ?></span>
		<h1 style="color: #FFFFFF; font-size: clamp(2rem, 3.5vw, 3rem); margin-bottom: 0.5rem;">
			<?php
			/* translators: %s: search query */
			printf( esc_html__( 'Results for: "%s"', 'decorza' ), esc_html( get_search_query() ) );
			?>
		</h1>
		<div style="font-size: 0.95rem; color: #ECF0F1;">
			<?php
			global $wp_query;
			$total_results = $wp_query->found_posts;
			/* translators: %d: number of results found */
			printf( esc_html( _n( 'Found %d article matching your search', 'Found %d articles matching your search', $total_results, 'decorza' ) ), absint( $total_results ) );
			?>
		</div>
	</div>
</header>

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
							get_template_part( 'template-parts/content', 'card' );
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
