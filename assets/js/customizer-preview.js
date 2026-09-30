/**
 * DecorZa Theme Customizer Live Preview & Edit Shortcuts
 *
 * Real-time postMessage handling for instant DOM updates without page refresh.
 *
 * @package DecorZa
 * @version 1.1.0
 */

(function( $ ) {
	'use strict';

	// =========================================================================
	// 1. SITE IDENTITY & HEADER
	// =========================================================================

	// Site Title
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-site-title a' ).text( to );
		} );
	} );

	// Site Tagline / Description
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-site-description' ).text( to );
		} );
	} );

	// Header Top Bar Announcement Text
	wp.customize( 'decorza_top_bar_text', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-top-bar-text' ).text( to );
		} );
	} );

	// Header Top Bar Contact
	wp.customize( 'decorza_top_bar_contact', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-top-bar-contact' ).text( to );
		} );
	} );

	// Header Background Color
	wp.customize( 'decorza_header_bg_color', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-site-header' ).css( 'background-color', to );
		} );
	} );

	// Logo Dimensions: Desktop Width
	wp.customize( 'decorza_logo_width', function( value ) {
		value.bind( function( to ) {
			$( '.custom-logo-link img, .custom-logo, .decorza-logo-wrapper img' ).css( 'width', to + 'px' );
		} );
	} );

	// Logo Dimensions: Max Height
	wp.customize( 'decorza_logo_max_height', function( value ) {
		value.bind( function( to ) {
			$( '.custom-logo-link img, .custom-logo, .decorza-logo-wrapper img' ).css( 'max-height', to + 'px' );
		} );
	} );

	// =========================================================================
	// 2. BRAND COLORS (CSS CUSTOM PROPERTIES)
	// =========================================================================

	// Primary Color
	wp.customize( 'decorza_primary_color', function( value ) {
		value.bind( function( to ) {
			document.documentElement.style.setProperty( '--color-primary', to );
		} );
	} );

	// Secondary Color
	wp.customize( 'decorza_secondary_color', function( value ) {
		value.bind( function( to ) {
			document.documentElement.style.setProperty( '--color-secondary', to );
		} );
	} );

	// Accent Color
	wp.customize( 'decorza_accent_color', function( value ) {
		value.bind( function( to ) {
			document.documentElement.style.setProperty( '--color-accent', to );
		} );
	} );

	// =========================================================================
	// 3. HOMEPAGE HERO BANNER
	// =========================================================================

	// Hero Tagline
	wp.customize( 'decorza_hero_tagline', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-hero-tagline' ).text( to );
		} );
	} );

	// Hero Heading
	wp.customize( 'decorza_hero_heading', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-hero-title' ).text( to );
		} );
	} );

	// Hero Subheading
	wp.customize( 'decorza_hero_subheading', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-hero-subtitle' ).text( to );
		} );
	} );

	// Hero Button Text
	wp.customize( 'decorza_hero_btn_text', function( value ) {
		value.bind( function( to ) {
			var $btn = $( '.decorza-hero-cta a' );
			$btn.html( to + ' <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' );
		} );
	} );

	// Hero Button URL
	wp.customize( 'decorza_hero_btn_url', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-hero-cta a' ).attr( 'href', to );
		} );
	} );

	// =========================================================================
	// 4. FEATURED CATEGORIES SECTION
	// =========================================================================

	// Categories Section Title
	wp.customize( 'decorza_categories_title', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-categories-section .decorza-section-title' ).text( to );
		} );
	} );

	// =========================================================================
	// 5. LATEST ARTICLES SECTION
	// =========================================================================

	// Latest Articles Section Title
	wp.customize( 'decorza_latest_title', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-latest-section .decorza-section-title' ).text( to );
		} );
	} );

	// Latest Articles "View All" Button Text
	wp.customize( 'decorza_latest_btn_text', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-latest-btn-wrap a' ).html( to + ' &rarr;' );
		} );
	} );

	// Latest Articles "View All" Button URL
	wp.customize( 'decorza_latest_btn_url', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-latest-btn-wrap a' ).attr( 'href', to );
		} );
	} );

	// =========================================================================
	// 6. HOMEPAGE ABOUT SECTION
	// =========================================================================

	// About Heading
	wp.customize( 'decorza_about_heading', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-about-heading' ).text( to );
		} );
	} );

	// About Description (HTML paragraph)
	wp.customize( 'decorza_about_description', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-about-description' ).html( to );
		} );
	} );

	// Stat 1 Number & Label
	wp.customize( 'decorza_stat1_num', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-stat-item-1 .decorza-stat-number' ).text( to );
		} );
	} );
	wp.customize( 'decorza_stat1_text', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-stat-item-1 .decorza-stat-label' ).text( to );
		} );
	} );

	// Stat 2 Number & Label
	wp.customize( 'decorza_stat2_num', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-stat-item-2 .decorza-stat-number' ).text( to );
		} );
	} );
	wp.customize( 'decorza_stat2_text', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-stat-item-2 .decorza-stat-label' ).text( to );
		} );
	} );

	// Stat 3 Number & Label
	wp.customize( 'decorza_stat3_num', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-stat-item-3 .decorza-stat-number' ).text( to );
		} );
	} );
	wp.customize( 'decorza_stat3_text', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-stat-item-3 .decorza-stat-label' ).text( to );
		} );
	} );

	// About Button Text & URL
	wp.customize( 'decorza_about_btn_text', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-about-btn-wrap a' ).text( to );
		} );
	} );
	wp.customize( 'decorza_about_btn_url', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-about-btn-wrap a' ).attr( 'href', to );
		} );
	} );

	// =========================================================================
	// 7. POPULAR POSTS & AUTHORS SECTIONS
	// =========================================================================

	// Popular Posts Section Title
	wp.customize( 'decorza_popular_title', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-popular-section .decorza-section-title' ).text( to );
		} );
	} );

	// Authors Section Title
	wp.customize( 'decorza_authors_title', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-authors-section .decorza-section-title' ).text( to );
		} );
	} );

	// =========================================================================
	// 8. NEWSLETTER SECTION
	// =========================================================================

	// Newsletter Title
	wp.customize( 'decorza_newsletter_title', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-newsletter-title' ).text( to );
		} );
	} );

	// Newsletter Subtext
	wp.customize( 'decorza_newsletter_subtext', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-newsletter-subtext' ).text( to );
		} );
	} );

	// Newsletter Button Text
	wp.customize( 'decorza_newsletter_btn_text', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-newsletter-btn-wrap button, .decorza-newsletter-btn-wrap a, .decorza-newsletter-form button' ).text( to );
		} );
	} );

	// Newsletter Button URL (if custom link)
	wp.customize( 'decorza_newsletter_btn_url', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-newsletter-btn-wrap a' ).attr( 'href', to );
		} );
	} );

	// Newsletter Background Color
	wp.customize( 'decorza_newsletter_bg', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-newsletter-section' ).css( 'background-color', to );
		} );
	} );

	// =========================================================================
	// 9. FOOTER SETTINGS
	// =========================================================================

	// Footer Background Color
	wp.customize( 'decorza_footer_bg', function( value ) {
		value.bind( function( to ) {
			$( '.decorza-site-footer' ).css( 'background-color', to );
		} );
	} );

	// Copyright Text
	wp.customize( 'decorza_copyright_text', function( value ) {
		value.bind( function( to ) {
			var currentYear = new Date().getFullYear();
			var rendered    = to.replace( '{year}', currentYear );
			$( '.decorza-copyright' ).text( rendered );
		} );
	} );

})( jQuery );
