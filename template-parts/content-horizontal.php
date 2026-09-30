<?php
/**
 * Template part for displaying posts in a horizontal card layout
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'decorza-card-horizontal' ); ?>>
	<div class="decorza-card-media">
		<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'decorza-card-horiz', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
			<?php else : ?>
				<div style="width: 100%; height: 100%; min-height: 200px; background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light)); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.4);">
					<svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
				</div>
			<?php endif; ?>
		</a>
		<div class="decorza-card-badge-wrap">
			<?php decorza_category_badge(); ?>
		</div>
	</div>

	<div class="decorza-card-body">
		<div class="decorza-card-meta">
			<span class="decorza-card-date"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
			<span class="decorza-meta-dot">•</span>
			<span class="decorza-card-read-time"><?php echo esc_html( decorza_reading_time() ); ?></span>
		</div>

		<h3 class="decorza-card-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<div class="decorza-card-excerpt">
			<?php the_excerpt(); ?>
		</div>

		<div class="decorza-card-footer">
			<div class="decorza-card-author">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 28, '', get_the_author() ); ?>
				<span><?php echo esc_html( get_the_author() ); ?></span>
			</div>
			<a href="<?php the_permalink(); ?>" style="color: var(--color-secondary); font-weight: 600; font-size: 0.9rem;">
				<?php esc_html_e( 'Read Article →', 'decorza' ); ?>
			</a>
		</div>
	</div>
</article>
