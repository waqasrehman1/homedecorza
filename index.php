<?php
/**
 * The main template file
 *
 * Used to display the blog index and fallback archive queries.
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$has_sidebar      = get_theme_mod( 'decorza_enable_sidebar', true );
$sidebar_pos      = get_theme_mod( 'decorza_sidebar_position', 'right' );
$blog_layout      = get_theme_mod( 'decorza_blog_layout', 'grid' );
$layout_class     = $has_sidebar ? 'decorza-layout-with-sidebar' . ( 'left' === $sidebar_pos ? ' sidebar-left' : '' ) : '';
$grid_class       = ( 'list' === $blog_layout ) ? 'decorza-grid' : ( $has_sidebar ? 'decorza-grid decorza-grid-2' : 'decorza-grid decorza-grid-3' );
?>

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
