<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="decorza-section">
	<div class="decorza-container">
		<div style="text-align: center; max-width: 650px; margin: 0 auto 4rem;">
			<span style="font-family: var(--font-heading); font-size: clamp(5rem, 12vw, 8rem); font-weight: 800; color: var(--color-secondary); line-height: 1; display: block; margin-bottom: 1rem;">
				404
			</span>
			<h1 style="font-size: clamp(1.8rem, 3.5vw, 2.5rem); margin-bottom: 1rem;">
				<?php esc_html_e( 'Oops! This Room Seems To Be Empty', 'decorza' ); ?>
			</h1>
			<p style="color: var(--color-text-muted); font-size: 1.1rem; line-height: 1.6; margin-bottom: 2rem;">
				<?php esc_html_e( 'The page or decor guide you are seeking may have been rearranged, renamed, or moved. Let us help you find what you need.', 'decorza' ); ?>
			</p>

			<!-- Search Form -->
			<div style="margin-bottom: 2rem;">
				<?php get_search_form(); ?>
			</div>

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="decorza-btn decorza-btn-primary">
				&larr; <?php esc_html_e( 'Return to Homepage', 'decorza' ); ?>
			</a>
		</div>

		<!-- Recommended Popular Articles -->
		<div style="margin-top: 4rem; padding-top: 3rem; border-top: 1px solid var(--color-border);">
			<div class="decorza-section-header">
				<h2 class="decorza-section-title"><?php esc_html_e( 'Popular Decor Inspirations', 'decorza' ); ?></h2>
				<p class="decorza-section-subtitle"><?php esc_html_e( 'While you are here, dive into some of our community favorite design guides.', 'decorza' ); ?></p>
			</div>

			<?php
			$recent_query = new WP_Query( array(
				'posts_per_page'      => 3,
				'ignore_sticky_posts' => 1,
			) );

			if ( $recent_query->have_posts() ) :
				?>
				<div class="decorza-grid decorza-grid-3">
					<?php
					while ( $recent_query->have_posts() ) :
						$recent_query->the_post();
						get_template_part( 'template-parts/content', 'card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
get_footer();
