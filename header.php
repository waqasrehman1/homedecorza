<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up until <main id="main-content">
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Reading Progress Bar (Single Posts) -->
<?php if ( is_single() ) : ?>
	<div class="decorza-reading-progress" aria-hidden="true"></div>
<?php endif; ?>

<!-- Accessibility Skip Link -->
<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'decorza' ); ?></a>

<!-- Optional Top Bar -->
<?php if ( get_theme_mod( 'decorza_enable_top_bar', true ) ) : ?>
	<div class="decorza-top-bar">
		<div class="decorza-container decorza-top-bar-inner">
			<div class="decorza-top-info">
				<span class="decorza-top-bar-text"><?php echo esc_html( get_theme_mod( 'decorza_top_bar_text', __( 'Transforming Spaces: Expert Interior Decor & Styling Tips', 'decorza' ) ) ); ?></span>
				<?php 
				$contact = get_theme_mod( 'decorza_top_bar_contact', 'hello@homedecorza.com' );
				if ( ! empty( $contact ) ) : ?>
					<span style="opacity: 0.7;">•</span>
					<span class="decorza-top-bar-contact"><?php echo esc_html( $contact ); ?></span>
				<?php endif; ?>
			</div>
			<div class="decorza-top-socials">
				<?php
				$social_fb = get_theme_mod( 'decorza_social_facebook', '#' );
				$social_ig = get_theme_mod( 'decorza_social_instagram', '#' );
				$social_pin = get_theme_mod( 'decorza_social_pinterest', '#' );
				?>
				<?php if ( ! empty( $social_pin ) ) : ?>
					<a href="<?php echo esc_url( $social_pin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Pinterest">
						<svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345-.09.375-.291 1.199-.334 1.373-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $social_ig ) ) : ?>
					<a href="<?php echo esc_url( $social_ig ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
						<svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $social_fb ) ) : ?>
					<a href="<?php echo esc_url( $social_fb ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
						<svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<!-- Sticky Site Header -->
<header id="masthead" class="decorza-site-header<?php echo get_theme_mod( 'decorza_enable_sticky_header', true ) ? ' enable-sticky' : ''; ?>">
	<div class="decorza-container">
		<div class="decorza-navbar">
			<!-- Logo Area -->
			<div class="decorza-logo-wrapper">
				<?php echo decorza_customize_partial_logo(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>

			<!-- Desktop Navigation Menu -->
			<nav id="site-navigation" class="decorza-nav-menu-wrapper" aria-label="<?php esc_attr_e( 'Main Menu', 'decorza' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary-menu',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'decorza-nav-menu',
					'container'      => false,
					'fallback_cb'    => function() {
						echo '<ul class="decorza-nav-menu">';
						echo '<li class="current-menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'decorza' ) . '</a></li>';
						$categories = get_categories( array( 'number' => 4 ) );
						foreach ( $categories as $cat ) {
							echo '<li><a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
						}
						echo '</ul>';
					},
				) );
				?>
			</nav>

			<!-- Header Actions (Search, Dark Mode, Mobile Hamburger) -->
			<div class="decorza-header-actions">
				<?php if ( get_theme_mod( 'decorza_enable_search_icon', true ) ) : ?>
					<button type="button" class="decorza-icon-btn decorza-search-toggle" aria-label="<?php esc_attr_e( 'Open Search Modal', 'decorza' ); ?>">
						<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
					</button>
				<?php endif; ?>

				<?php if ( get_theme_mod( 'decorza_enable_dark_mode_toggle', true ) ) : ?>
					<button type="button" class="decorza-icon-btn decorza-dark-mode-toggle" aria-label="<?php esc_attr_e( 'Toggle Dark Mode', 'decorza' ); ?>">
						<svg class="icon-moon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
						<svg class="icon-sun" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: none;"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
					</button>
				<?php endif; ?>

				<!-- Mobile Hamburger Toggle Button -->
				<button type="button" class="decorza-icon-btn decorza-mobile-toggle" aria-label="<?php esc_attr_e( 'Open Navigation Menu', 'decorza' ); ?>" aria-expanded="false" aria-controls="decorza-mobile-drawer">
					<svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
				</button>
			</div>
		</div>
	</div>
</header>

<!-- Mobile Navigation Drawer -->
<div id="decorza-mobile-drawer" class="decorza-mobile-drawer" aria-hidden="true">
	<div class="decorza-drawer-header">
		<div class="decorza-drawer-logo">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} elseif ( ! empty( $custom_logo_url ) ) {
				echo '<a href="' . esc_url( home_url( '/' ) ) . '"><img src="' . esc_url( $custom_logo_url ) . '" class="custom-logo" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" style="max-height: 40px; width: auto;" /></a>';
			} else {
				echo '<span style="font-family: var(--font-heading); font-size: 1.5rem; font-weight: 700; color: var(--color-primary);">' . esc_html( get_bloginfo( 'name' ) ) . '<span style="color: var(--color-secondary);">.</span></span>';
			}
			?>
		</div>
		<button type="button" class="decorza-drawer-close" aria-label="<?php esc_attr_e( 'Close menu', 'decorza' ); ?>">
			<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
		</button>
	</div>
	<nav class="decorza-mobile-nav" aria-label="<?php esc_attr_e( 'Mobile Menu', 'decorza' ); ?>">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'primary-menu',
			'menu_class'     => 'decorza-mobile-nav-menu',
			'container'      => false,
			'fallback_cb'    => function() {
				echo '<ul class="decorza-mobile-nav-menu">';
				echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'decorza' ) . '</a></li>';
				$categories = get_categories( array( 'number' => 6 ) );
				foreach ( $categories as $cat ) {
					echo '<li><a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
				}
				echo '</ul>';
			},
		) );
		?>
	</nav>
</div>
<div class="decorza-drawer-overlay" aria-hidden="true"></div>

<!-- Expandable Search Modal -->
<div class="decorza-search-modal" aria-hidden="true">
	<div class="decorza-search-box">
		<button type="button" class="decorza-search-close" aria-label="<?php esc_attr_e( 'Close Search', 'decorza' ); ?>">&times;</button>
		<h3 style="font-size: 1.4rem;"><?php esc_html_e( 'Search HomeDecorZa', 'decorza' ); ?></h3>
		<p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 0.5rem;"><?php esc_html_e( 'Find room guides, decor inspiration, furniture ideas, and styling advice...', 'decorza' ); ?></p>
		<form role="search" method="get" class="decorza-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" class="decorza-search-input" placeholder="<?php esc_attr_e( 'Type your search query...', 'decorza' ); ?>" value="<?php echo get_search_query(); ?>" name="s" required>
			<button type="submit" class="decorza-search-submit" aria-label="<?php esc_attr_e( 'Submit search', 'decorza' ); ?>">
				<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
			</button>
		</form>
	</div>
</div>

<main id="main-content" class="site-main">
