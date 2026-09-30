<?php
/**
 * The sidebar containing the main widget area
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<aside id="secondary" class="decorza-sidebar" aria-label="<?php esc_attr_e( 'Primary Sidebar', 'decorza' ); ?>">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php else : ?>
		<!-- Default Home Decor Widgets Fallback -->
		<div class="decorza-widget">
			<h3 class="decorza-widget-title"><?php esc_html_e( 'About DecorZa', 'decorza' ); ?></h3>
			<p style="color: var(--color-text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1rem;">
				<?php esc_html_e( 'HomeDecorZa delivers daily interior inspirations, architecture journals, styling rules, and DIY furniture projects to empower your modern sanctuary.', 'decorza' ); ?>
			</p>
		</div>

		<div class="decorza-widget">
			<h3 class="decorza-widget-title"><?php esc_html_e( 'Popular Decor Topics', 'decorza' ); ?></h3>
			<ul class="decorza-widget-category-list">
				<?php
				$cats = get_categories( array( 'number' => 5, 'orderby' => 'count', 'order' => 'DESC' ) );
				if ( ! empty( $cats ) ) :
					foreach ( $cats as $cat ) :
						echo '<li>';
						echo '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a>';
						echo '<span class="decorza-category-badge-count">' . esc_html( $cat->count ) . '</span>';
						echo '</li>';
					endforeach;
				endif;
				?>
			</ul>
		</div>

		<div class="decorza-widget">
			<h3 class="decorza-widget-title"><?php esc_html_e( 'Join 50K+ Readers', 'decorza' ); ?></h3>
			<p style="font-size: 0.9rem; color: var(--color-text-muted); margin-bottom: 1rem;">
				<?php esc_html_e( 'Get curated decor styling advice straight to your inbox every Sunday morning.', 'decorza' ); ?>
			</p>
			<form onsubmit="event.preventDefault(); alert('Thank you for subscribing to DecorZa!');" style="display: flex; flex-direction: column; gap: 0.75rem;">
				<input type="email" placeholder="<?php esc_attr_e( 'Your email...', 'decorza' ); ?>" required style="padding: 0.75rem 1rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); background: var(--color-bg); color: var(--color-text); width: 100%;">
				<button type="submit" class="decorza-btn decorza-btn-primary" style="width: 100%; border-radius: var(--radius-sm); padding: 0.75rem;"><?php esc_html_e( 'Subscribe Free', 'decorza' ); ?></button>
			</form>
		</div>
	<?php endif; ?>
</aside>
