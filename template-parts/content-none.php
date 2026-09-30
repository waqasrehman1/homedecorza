<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="decorza-no-results decorza-card" style="padding: 3rem 2rem; text-align: center; margin: 2rem 0;">
	<div style="width: 64px; height: 64px; border-radius: 50%; background: var(--color-accent); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--color-secondary);">
		<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
	</div>

	<h2 style="font-size: 1.75rem; margin-bottom: 0.75rem;"><?php esc_html_e( 'No Articles Found', 'decorza' ); ?></h2>

	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
		<p style="color: var(--color-text-muted); margin-bottom: 1.5rem;">
			<?php
			/* translators: 1: link to WP admin new post page */
			printf( wp_kses( __( 'Ready to publish your first home decor article? <a href="%1$s">Get started here</a>.', 'decorza' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) );
			?>
		</p>
	<?php elseif ( is_search() ) : ?>
		<p style="color: var(--color-text-muted); margin-bottom: 1.5rem;">
			<?php esc_html_e( 'Sorry, but nothing matched your search criteria. Please try again with different keywords.', 'decorza' ); ?>
		</p>
		<div style="max-width: 450px; margin: 0 auto;">
			<?php get_search_form(); ?>
		</div>
	<?php else : ?>
		<p style="color: var(--color-text-muted); margin-bottom: 1.5rem;">
			<?php esc_html_e( 'It seems we cannot find what you are looking for. Perhaps searching can help.', 'decorza' ); ?>
		</p>
		<div style="max-width: 450px; margin: 0 auto;">
			<?php get_search_form(); ?>
		</div>
	<?php endif; ?>
</section>
