<?php
/**
 * The template for displaying all single posts
 *
 * Implements a distraction-free, 750px reading-optimized experience with
 * breadcrumbs, typography, floating share, TOC, author bio, related posts, and comments.
 *
 * @package DecorZa
 * @version 1.3.0
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
						<!-- Breadcrumbs Navigation -->
						<?php decorza_breadcrumbs(); ?>

						<header class="decorza-single-header">
							<div class="decorza-single-badge-wrap" style="margin-bottom: 0.75rem;">
								<?php decorza_category_badge(); ?>
							</div>

							<h1 class="decorza-single-title"><?php the_title(); ?></h1>

							<div class="decorza-single-meta">
								<div class="decorza-single-meta-item decorza-single-meta-author">
									<?php echo get_avatar( get_the_author_meta( 'ID' ), 36, '', get_the_author() ); ?>
									<span>
										<?php esc_html_e( 'By', 'decorza' ); ?>
										<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" style="color: var(--color-primary); font-weight: 600;">
											<?php echo esc_html( get_the_author() ); ?>
										</a>
									</span>
								</div>

								<div class="decorza-single-meta-item">
									<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
									<span><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
								</div>

								<?php $reading_time = decorza_reading_time(); ?>
								<?php if ( ! empty( $reading_time ) ) : ?>
									<div class="decorza-single-meta-item">
										<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
										<span><?php echo esc_html( $reading_time ); ?></span>
									</div>
								<?php endif; ?>

								<div class="decorza-single-meta-item">
									<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
									<span><?php comments_number( __( '0 comments', 'decorza' ), __( '1 comment', 'decorza' ), __( '% comments', 'decorza' ) ); ?></span>
								</div>
							</div>
						</header>

						<!-- Featured Image with Caption -->
						<?php if ( has_post_thumbnail() ) : ?>
							<figure class="decorza-single-featured-image">
								<?php the_post_thumbnail( 'decorza-single', array( 'loading' => 'eager', 'alt' => get_the_title() ) ); ?>
								<?php if ( get_the_post_thumbnail_caption() ) : ?>
									<figcaption class="decorza-image-caption"><?php echo esc_html( get_the_post_thumbnail_caption() ); ?></figcaption>
								<?php endif; ?>
							</figure>
						<?php endif; ?>

						<!-- Floating / Mobile Social Share -->
						<?php decorza_social_share(); ?>

						<!-- Article Body Content -->
						<div class="decorza-article-content entry-content">
							<?php
							the_content(
								sprintf(
									wp_kses(
										/* translators: %s: Name of current post. Only visible to screen readers */
										__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'decorza' ),
										array(
											'span' => array(
												'class' => array(),
											),
										)
									),
									wp_strip_all_tags( get_the_title() )
								)
							);

							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'decorza' ),
								'after'  => '</div>',
							) );
							?>
						</div>

						<!-- Tags Section -->
						<?php
						$tags = get_the_tags();
						if ( ! empty( $tags ) ) :
							?>
							<div class="decorza-post-tags">
								<span style="font-weight: 600; font-size: 0.85rem; color: var(--color-text-muted); margin-right: 0.5rem;"><?php esc_html_e( 'TAGS:', 'decorza' ); ?></span>
								<?php
								foreach ( $tags as $tag ) {
									echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="decorza-tag-pill">#' . esc_html( $tag->name ) . '</a>';
								}
								?>
							</div>
						<?php endif; ?>

						<!-- Post Navigation (Prev / Next with Thumbnails & Fallbacks) -->
						<?php
						$prev_post = get_previous_post();
						$next_post = get_next_post();

						if ( ! empty( $prev_post ) || ! empty( $next_post ) ) :
							?>
							<nav class="decorza-post-navigation" aria-label="<?php esc_attr_e( 'Posts Navigation', 'decorza' ); ?>">
								<?php
								if ( ! empty( $prev_post ) ) :
									$prev_thumb = has_post_thumbnail( $prev_post->ID ) ? get_the_post_thumbnail_url( $prev_post->ID, 'thumbnail' ) : '';
									?>
									<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="decorza-nav-link decorza-nav-prev" rel="prev">
										<div class="decorza-nav-thumb<?php echo empty( $prev_thumb ) ? ' decorza-nav-thumb-fallback' : ''; ?>" aria-hidden="true">
											<?php if ( ! empty( $prev_thumb ) ) : ?>
												<img src="<?php echo esc_url( $prev_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $prev_post->ID ) ); ?>" loading="lazy" />
											<?php else : ?>
												<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
											<?php endif; ?>
										</div>
										<div class="decorza-nav-body">
											<span class="decorza-nav-direction">&larr; <?php esc_html_e( 'Previous Article', 'decorza' ); ?></span>
											<h4 class="decorza-nav-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></h4>
										</div>
									</a>
								<?php else : ?>
									<div class="decorza-nav-empty"></div>
								<?php endif; ?>

								<?php
								if ( ! empty( $next_post ) ) :
									$next_thumb = has_post_thumbnail( $next_post->ID ) ? get_the_post_thumbnail_url( $next_post->ID, 'thumbnail' ) : '';
									?>
									<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="decorza-nav-link decorza-nav-next" rel="next">
										<div class="decorza-nav-body">
											<span class="decorza-nav-direction"><?php esc_html_e( 'Next Article', 'decorza' ); ?> &rarr;</span>
											<h4 class="decorza-nav-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></h4>
										</div>
										<div class="decorza-nav-thumb<?php echo empty( $next_thumb ) ? ' decorza-nav-thumb-fallback' : ''; ?>" aria-hidden="true">
											<?php if ( ! empty( $next_thumb ) ) : ?>
												<img src="<?php echo esc_url( $next_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $next_post->ID ) ); ?>" loading="lazy" />
											<?php else : ?>
												<svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
											<?php endif; ?>
										</div>
									</a>
								<?php else : ?>
									<div class="decorza-nav-empty"></div>
								<?php endif; ?>
							</nav>
						<?php endif; ?>

						<!-- Author Profile Card -->
						<?php decorza_author_box(); ?>

						<!-- Related Posts (3 in same category with fallback) -->
						<?php decorza_related_posts(); ?>

						<!-- Comments Template -->
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
