<?php
/**
 * The template for displaying the footer
 *
 * Contains closing of #main-content and all content after.
 * Features 3 fully dynamic widget columns, copyright bar, and secondary navigation.
 *
 * @package DecorZa
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

</main><!-- #main-content -->

<footer id="colophon" class="decorza-site-footer">
	<!-- Footer Widgets Area (3 Dynamic Columns) -->
	<div class="decorza-footer-widgets-area">
		<div class="decorza-container">
			<div class="decorza-footer-grid decorza-footer-grid-3">
				<!-- Footer Column 1 -->
				<div class="decorza-footer-col">
					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<?php dynamic_sidebar( 'footer-1' ); ?>
					<?php else : ?>
						<div class="decorza-footer-widget">
							<h3 class="decorza-footer-widget-title"><?php esc_html_e( 'About DecorZa', 'decorza' ); ?></h3>
							<p><?php esc_html_e( 'DecorZa is your digital compass for interior beauty, timeless furniture aesthetics, and thoughtful room arrangements. Inspiring home transformations daily.', 'decorza' ); ?></p>
							<div class="decorza-footer-socials">
								<?php
								$social_pin = get_theme_mod( 'decorza_social_pinterest', '#' );
								$social_ig  = get_theme_mod( 'decorza_social_instagram', '#' );
								$social_fb  = get_theme_mod( 'decorza_social_facebook', '#' );
								?>
								<?php if ( ! empty( $social_pin ) ) : ?>
									<a href="<?php echo esc_url( $social_pin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Pinterest">
										<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345-.09.375-.291 1.199-.334 1.373-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>
									</a>
								<?php endif; ?>
								<?php if ( ! empty( $social_ig ) ) : ?>
									<a href="<?php echo esc_url( $social_ig ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
										<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
									</a>
								<?php endif; ?>
								<?php if ( ! empty( $social_fb ) ) : ?>
									<a href="<?php echo esc_url( $social_fb ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
										<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>
									</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<!-- Footer Column 2 -->
				<div class="decorza-footer-col">
					<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<?php dynamic_sidebar( 'footer-2' ); ?>
					<?php else : ?>
						<div class="decorza-footer-widget">
							<h3 class="decorza-footer-widget-title"><?php esc_html_e( 'Quick Links', 'decorza' ); ?></h3>
							<ul>
								<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home Page', 'decorza' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#decorza-articles' ) ); ?>"><?php esc_html_e( 'Latest Articles', 'decorza' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About Our Mission', 'decorza' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/#popular' ) ); ?>"><?php esc_html_e( 'Popular Ideas', 'decorza' ); ?></a></li>
							</ul>
						</div>
					<?php endif; ?>
				</div>

				<!-- Footer Column 3 -->
				<div class="decorza-footer-col">
					<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<?php dynamic_sidebar( 'footer-3' ); ?>
					<?php else : ?>
						<div class="decorza-footer-widget">
							<h3 class="decorza-footer-widget-title"><?php esc_html_e( 'Newsletter', 'decorza' ); ?></h3>
							<p><?php esc_html_e( 'Subscribe to our curated weekend edit of decor ideas.', 'decorza' ); ?></p>
							<form onsubmit="event.preventDefault(); alert('Subscribed to HomeDecorZa!');" style="display: flex; flex-direction: column; gap: 0.6rem; margin-top: 1rem;">
								<input type="email" placeholder="<?php esc_attr_e( 'Enter your email...', 'decorza' ); ?>" required style="padding: 0.65rem 1rem; border-radius: var(--radius-sm); border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.06); color: #fff;">
								<button type="submit" class="decorza-btn decorza-btn-primary" style="padding: 0.65rem; border-radius: var(--radius-sm);"><?php esc_html_e( 'Subscribe', 'decorza' ); ?></button>
							</form>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<!-- Bottom Bar -->
	<div class="decorza-footer-bottom">
		<div class="decorza-container decorza-footer-bottom-inner">
			<div class="decorza-copyright">
				<?php echo decorza_customize_partial_copyright(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>

			<!-- Footer Menu -->
			<nav class="decorza-footer-menu" aria-label="<?php esc_attr_e( 'Footer Menu', 'decorza' ); ?>">
				<?php
				if ( has_nav_menu( 'footer-menu' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'footer-menu',
						'depth'          => 1,
						'container'      => false,
						'menu_class'     => 'decorza-footer-menu',
					) );
				} else {
					echo '<ul class="decorza-footer-menu">';
					echo '<li><a href="' . esc_url( home_url( '/privacy-policy/' ) ) . '">' . esc_html__( 'Privacy Policy', 'decorza' ) . '</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/terms/' ) ) . '">' . esc_html__( 'Terms of Service', 'decorza' ) . '</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">' . esc_html__( 'Contact', 'decorza' ) . '</a></li>';
					echo '</ul>';
				}
				?>
			</nav>
		</div>
	</div>
</footer>

<!-- Back to Top Button -->
<?php if ( get_theme_mod( 'decorza_enable_back_to_top', true ) ) : ?>
	<button type="button" class="decorza-back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'decorza' ); ?>" title="<?php esc_attr_e( 'Back to top', 'decorza' ); ?>">
		<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 15l-6-6-6 6"/></svg>
	</button>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
