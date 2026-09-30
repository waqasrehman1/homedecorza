<?php
/**
 * Template part for displaying posts in a 3-column card grid
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'decorza-card' ); ?>>
	<div class="decorza-card-media">
		<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'decorza-card', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
			<?php else : ?>
				<!-- Elegant decorative placeholder for home decor -->
				<div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light)); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.4);">
					<svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
				</div>
			<?php endif; ?>
		</a>
		<div class="decorza-card-badge-wrap">
			<?php decorza_category_badge(); ?>
		</div>
	</div>

	<div class="decorza-card-body">
		<div class="decorza-card-meta">
			<span class="decorza-card-date">
				<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
				<?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
			</span>
			<span class="decorza-meta-dot">•</span>
			<span class="decorza-card-read-time">
				<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
				<?php echo esc_html( decorza_reading_time() ); ?>
			</span>
		</div>

		<h3 class="decorza-card-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<div class="decorza-card-excerpt">
			<?php the_excerpt(); ?>
		</div>

		<div class="decorza-card-footer">
			<div class="decorza-card-author">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 32, '', get_the_author() ); ?>
				<span><?php echo esc_html( get_the_author() ); ?></span>
			</div>
			<a href="<?php the_permalink(); ?>" class="decorza-card-read-more" aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'decorza' ), get_the_title() ) ); ?>">
				<span style="font-weight: 600; color: var(--color-secondary); font-size: 0.85rem;"><?php esc_html_e( 'Read →', 'decorza' ); ?></span>
			</a>
		</div>
	</div>
</article>
