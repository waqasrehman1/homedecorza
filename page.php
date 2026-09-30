<?php
/**
 * The template for displaying all pages
 *
 * @package DecorZa
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="decorza-section">
	<div class="decorza-container">
		<div class="decorza-reading-view">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php decorza_breadcrumbs(); ?>

						<header class="decorza-single-header">
							<h1 class="decorza-single-title"><?php the_title(); ?></h1>
						</header>

						<?php if ( has_post_thumbnail() ) : ?>
							<div class="decorza-single-featured-image">
								<?php the_post_thumbnail( 'decorza-single', array( 'loading' => 'eager', 'alt' => get_the_title() ) ); ?>
							</div>
						<?php endif; ?>

						<div class="decorza-article-content entry-content">
							<?php
							the_content();

							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'decorza' ),
								'after'  => '</div>',
							) );
							?>
						</div>

						<?php
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>
					</article>
					<?php
				endwhile;
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
			?>
		</div>
	</div>
</div>

<?php
get_footer();
