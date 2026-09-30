<?php
/**
 * DecorZa Theme Customizer API Integration
 *
 * Fully integrated panels, sections, settings, postMessage live previews,
 * and Selective Refresh edit shortcuts (blue pencil icons).
 *
 * 100% Linux/Hostinger compatible, strictly normalized forward slashes.
 *
 * @package DecorZa
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register DecorZa Customizer options.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function decorza_customize_register( $wp_customize ) {

	// Set Core settings to postMessage for live updates
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// -------------------------------------------------------------------------
	// MASTER PANEL: DecorZa Theme Settings
	// -------------------------------------------------------------------------
	$wp_customize->add_panel( 'decorza_theme_panel', array(
		'title'       => __( 'DecorZa Theme Settings', 'decorza' ),
		'description' => __( 'Customize typography, colors, layouts, header, footer, SEO, and homepage sections.', 'decorza' ),
		'priority'    => 20,
	) );

	// =========================================================================
	// 1. GENERAL SETTINGS
	// =========================================================================
	$wp_customize->add_section( 'decorza_general_section', array(
		'title'       => __( 'General Settings', 'decorza' ),
		'panel'       => 'decorza_theme_panel',
		'priority'    => 10,
	) );

	// Primary Color
	$wp_customize->add_setting( 'decorza_primary_color', array(
		'default'           => '#2C3E50',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'decorza_primary_color', array(
		'label'    => __( 'Primary Brand Color', 'decorza' ),
		'section'  => 'decorza_general_section',
		'settings' => 'decorza_primary_color',
	) ) );

	// Secondary Color
	$wp_customize->add_setting( 'decorza_secondary_color', array(
		'default'           => '#E67E22',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'decorza_secondary_color', array(
		'label'    => __( 'Secondary / Accent Copper Color', 'decorza' ),
		'section'  => 'decorza_general_section',
		'settings' => 'decorza_secondary_color',
	) ) );

	// Accent Background Color
	$wp_customize->add_setting( 'decorza_accent_color', array(
		'default'           => '#ECF0F1',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'decorza_accent_color', array(
		'label'    => __( 'Light Accent Background Color', 'decorza' ),
		'section'  => 'decorza_general_section',
		'settings' => 'decorza_accent_color',
	) ) );

	// Heading Font
	$wp_customize->add_setting( 'decorza_heading_font', array(
		'default'           => 'Playfair Display',
		'sanitize_callback' => 'decorza_sanitize_select',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_heading_font', array(
		'label'    => __( 'Headings Font Family', 'decorza' ),
		'section'  => 'decorza_general_section',
		'type'     => 'select',
		'choices'  => array(
			'Playfair Display'   => 'Playfair Display (Serif - Recommended)',
			'Merriweather'       => 'Merriweather (Classic Serif)',
			'Lora'               => 'Lora (Editorial Serif)',
			'Cormorant Garamond' => 'Cormorant Garamond (Luxury Serif)',
			'System Serif'       => 'System Serif (Georgia, Times)',
		),
	) );

	// Body Font
	$wp_customize->add_setting( 'decorza_body_font', array(
		'default'           => 'Inter',
		'sanitize_callback' => 'decorza_sanitize_select',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_body_font', array(
		'label'    => __( 'Body Font Family', 'decorza' ),
		'section'  => 'decorza_general_section',
		'type'     => 'select',
		'choices'  => array(
			'Inter'      => 'Inter (Clean Sans-Serif - Recommended)',
			'Roboto'     => 'Roboto (Modern Sans-Serif)',
			'Open Sans'  => 'Open Sans (Neutral Sans-Serif)',
			'System Sans'=> 'System Sans-Serif (Native Fast)',
		),
	) );

	// Preloader Toggle
	$wp_customize->add_setting( 'decorza_enable_preloader', array(
		'default'           => false,
		'sanitize_callback' => 'decorza_sanitize_checkbox',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_enable_preloader', array(
		'label'    => __( 'Enable Page Preloader', 'decorza' ),
		'section'  => 'decorza_general_section',
		'type'     => 'checkbox',
	) );

	// =========================================================================
	// 2. HEADER SETTINGS
	// =========================================================================
	$wp_customize->add_section( 'decorza_header_section', array(
		'title'       => __( 'Header Settings', 'decorza' ),
		'panel'       => 'decorza_theme_panel',
		'priority'    => 20,
	) );

	// Header Layout
	$wp_customize->add_setting( 'decorza_header_layout', array(
		'default'           => 'left',
		'sanitize_callback' => 'decorza_sanitize_select',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_header_layout', array(
		'label'    => __( 'Header Logo Alignment', 'decorza' ),
		'section'  => 'decorza_header_section',
		'type'     => 'radio',
		'choices'  => array(
			'left'   => __( 'Logo Left / Navigation Right', 'decorza' ),
			'center' => __( 'Logo Centered', 'decorza' ),
		),
	) );

	// Custom Logo Image Upload (Header Section convenience)
	$wp_customize->add_setting( 'decorza_custom_logo', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'decorza_custom_logo', array(
		'label'       => __( 'Custom Website Logo Image', 'decorza' ),
		'description' => __( 'Upload your logo image. If set, this overrides the text logo.', 'decorza' ),
		'section'     => 'decorza_header_section',
		'settings'    => 'decorza_custom_logo',
	) ) );

	// Logo Width Adjustment (Desktop)
	$wp_customize->add_setting( 'decorza_logo_width', array(
		'default'           => 180,
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_logo_width', array(
		'label'       => __( 'Logo Width - Desktop (in pixels)', 'decorza' ),
		'description' => __( 'Adjust the display width of your logo (e.g., 80px to 400px).', 'decorza' ),
		'section'     => 'decorza_header_section',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 50,
			'max'  => 400,
			'step' => 2,
		),
	) );

	// Logo Max Height Adjustment
	$wp_customize->add_setting( 'decorza_logo_max_height', array(
		'default'           => 55,
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_logo_max_height', array(
		'label'       => __( 'Logo Max Height (in pixels)', 'decorza' ),
		'description' => __( 'Control maximum height to keep header proportions sleek.', 'decorza' ),
		'section'     => 'decorza_header_section',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 25,
			'max'  => 120,
			'step' => 2,
		),
	) );

	// Logo Mobile Width Adjustment
	$wp_customize->add_setting( 'decorza_logo_mobile_width', array(
		'default'           => 140,
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_logo_mobile_width', array(
		'label'       => __( 'Logo Width - Mobile (in pixels)', 'decorza' ),
		'description' => __( 'Adjust the logo width on mobile devices and tablets.', 'decorza' ),
		'section'     => 'decorza_header_section',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 40,
			'max'  => 250,
			'step' => 2,
		),
	) );

	// Enable Top Bar
	$wp_customize->add_setting( 'decorza_enable_top_bar', array(
		'default'           => true,
		'sanitize_callback' => 'decorza_sanitize_checkbox',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_enable_top_bar', array(
		'label'    => __( 'Enable Header Top Bar', 'decorza' ),
		'section'  => 'decorza_header_section',
		'type'     => 'checkbox',
	) );

	// Top Bar Text
	$wp_customize->add_setting( 'decorza_top_bar_text', array(
		'default'           => __( 'Transforming Spaces: Expert Interior Decor & Styling Tips', 'decorza' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_top_bar_text', array(
		'label'    => __( 'Top Bar Announcement Text', 'decorza' ),
		'section'  => 'decorza_header_section',
		'type'     => 'text',
	) );

	// Top Bar Contact / Email
	$wp_customize->add_setting( 'decorza_top_bar_contact', array(
		'default'           => 'hello@homedecorza.com',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_top_bar_contact', array(
		'label'    => __( 'Top Bar Email / Contact Note', 'decorza' ),
		'section'  => 'decorza_header_section',
		'type'     => 'text',
	) );

	// Enable Sticky Header
	$wp_customize->add_setting( 'decorza_enable_sticky_header', array(
		'default'           => true,
		'sanitize_callback' => 'decorza_sanitize_checkbox',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_enable_sticky_header', array(
		'label'    => __( 'Enable Sticky Header on Scroll', 'decorza' ),
		'section'  => 'decorza_header_section',
		'type'     => 'checkbox',
	) );

	// Enable Search Icon
	$wp_customize->add_setting( 'decorza_enable_search_icon', array(
		'default'           => true,
		'sanitize_callback' => 'decorza_sanitize_checkbox',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_enable_search_icon', array(
		'label'    => __( 'Enable Header Search Icon', 'decorza' ),
		'section'  => 'decorza_header_section',
		'type'     => 'checkbox',
	) );

	// Enable Dark Mode Toggle
	$wp_customize->add_setting( 'decorza_enable_dark_mode_toggle', array(
		'default'           => true,
		'sanitize_callback' => 'decorza_sanitize_checkbox',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_enable_dark_mode_toggle', array(
		'label'    => __( 'Enable Dark/Light Mode Switcher', 'decorza' ),
		'section'  => 'decorza_header_section',
		'type'     => 'checkbox',
	) );

	// Header Background Color
	$wp_customize->add_setting( 'decorza_header_bg_color', array(
		'default'           => '#FFFFFF',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'decorza_header_bg_color', array(
		'label'    => __( 'Header Background Color', 'decorza' ),
		'section'  => 'decorza_header_section',
		'settings' => 'decorza_header_bg_color',
	) ) );

	// =========================================================================
	// 3. HOMEPAGE HERO BANNER
	// =========================================================================
	$wp_customize->add_section( 'decorza_hero_section', array(
		'title'       => __( 'Homepage Hero Banner', 'decorza' ),
		'panel'       => 'decorza_theme_panel',
		'priority'    => 30,
	) );

	// Enable Hero
	$wp_customize->add_setting( 'decorza_enable_hero', array(
		'default'           => true,
		'sanitize_callback' => 'decorza_sanitize_checkbox',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_enable_hero', array(
		'label'    => __( 'Display Hero Banner', 'decorza' ),
		'section'  => 'decorza_hero_section',
		'type'     => 'checkbox',
	) );

	// Hero Background Image
	$wp_customize->add_setting( 'decorza_hero_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'decorza_hero_image', array(
		'label'    => __( 'Hero Background Image', 'decorza' ),
		'section'  => 'decorza_hero_section',
		'settings' => 'decorza_hero_image',
	) ) );

	// Hero Tagline
	$wp_customize->add_setting( 'decorza_hero_tagline', array(
		'default'           => __( 'HOME DECOR INSPIRATION & GUIDES', 'decorza' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_hero_tagline', array(
		'label'    => __( 'Hero Top Tagline', 'decorza' ),
		'section'  => 'decorza_hero_section',
		'type'     => 'text',
	) );

	// Hero Heading
	$wp_customize->add_setting( 'decorza_hero_heading', array(
		'default'           => __( 'Transform Your Space with Elegant Decor Ideas', 'decorza' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_hero_heading', array(
		'label'    => __( 'Hero Heading Text', 'decorza' ),
		'section'  => 'decorza_hero_section',
		'type'     => 'text',
	) );

	// Hero Subheading
	$wp_customize->add_setting( 'decorza_hero_subheading', array(
		'default'           => __( 'Explore modern aesthetics, cozy Scandinavian layouts, architectural lighting, and DIY tips crafted to bring timeless elegance into every room.', 'decorza' ),
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_hero_subheading', array(
		'label'    => __( 'Hero Subheading Text', 'decorza' ),
		'section'  => 'decorza_hero_section',
		'type'     => 'textarea',
	) );

	// Hero CTA Text
	$wp_customize->add_setting( 'decorza_hero_btn_text', array(
		'default'           => __( 'Explore Articles', 'decorza' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_hero_btn_text', array(
		'label'    => __( 'Hero Button Label', 'decorza' ),
		'section'  => 'decorza_hero_section',
		'type'     => 'text',
	) );

	// Hero CTA Link
	$wp_customize->add_setting( 'decorza_hero_btn_url', array(
		'default'           => '#decorza-articles',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_hero_btn_url', array(
		'label'    => __( 'Hero Button Link URL', 'decorza' ),
		'section'  => 'decorza_hero_section',
		'type'     => 'url',
	) );

	// =========================================================================
	// 4. HOMEPAGE ABOUT SECTION
	// =========================================================================
	$wp_customize->add_section( 'decorza_about_section', array(
		'title'       => __( 'Homepage About Section', 'decorza' ),
		'panel'       => 'decorza_theme_panel',
		'priority'    => 40,
	) );

	// Enable About
	$wp_customize->add_setting( 'decorza_enable_about', array(
		'default'           => true,
		'sanitize_callback' => 'decorza_sanitize_checkbox',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_enable_about', array(
		'label'    => __( 'Display About Section', 'decorza' ),
		'section'  => 'decorza_about_section',
		'type'     => 'checkbox',
	) );

	// About Image
	$wp_customize->add_setting( 'decorza_about_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'decorza_about_image', array(
		'label'    => __( 'About Section Image', 'decorza' ),
		'section'  => 'decorza_about_section',
	) ) );

	// About Heading
	$wp_customize->add_setting( 'decorza_about_heading', array(
		'default'           => __( 'About HomeDecorZa', 'decorza' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_about_heading', array(
		'label'    => __( 'About Section Title', 'decorza' ),
		'section'  => 'decorza_about_section',
		'type'     => 'text',
	) );

	// About Description
	$wp_customize->add_setting( 'decorza_about_description', array(
		'default'           => __( 'HomeDecorZa is a dedicated digital sanctuary for interior architecture, home staging, and thoughtful design. We empower homeowners and interior enthusiasts to build living spaces that reflect grace, warmth, and authentic personality.', 'decorza' ),
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_about_description', array(
		'label'    => __( 'About Section Content', 'decorza' ),
		'section'  => 'decorza_about_section',
		'type'     => 'textarea',
	) );

	// Highlights
	$wp_customize->add_setting( 'decorza_stat1_num', array( 'default' => '500+', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_stat1_num', array( 'label' => __( 'Highlight 1 Number', 'decorza' ), 'section' => 'decorza_about_section', 'type' => 'text' ) );
	$wp_customize->add_setting( 'decorza_stat1_text', array( 'default' => __( 'Curated Articles', 'decorza' ), 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_stat1_text', array( 'label' => __( 'Highlight 1 Label', 'decorza' ), 'section' => 'decorza_about_section', 'type' => 'text' ) );

	$wp_customize->add_setting( 'decorza_stat2_num', array( 'default' => '100%', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_stat2_num', array( 'label' => __( 'Highlight 2 Number', 'decorza' ), 'section' => 'decorza_about_section', 'type' => 'text' ) );
	$wp_customize->add_setting( 'decorza_stat2_text', array( 'default' => __( 'Expert Writers', 'decorza' ), 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_stat2_text', array( 'label' => __( 'Highlight 2 Label', 'decorza' ), 'section' => 'decorza_about_section', 'type' => 'text' ) );

	$wp_customize->add_setting( 'decorza_stat3_num', array( 'default' => '50K+', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_stat3_num', array( 'label' => __( 'Highlight 3 Number', 'decorza' ), 'section' => 'decorza_about_section', 'type' => 'text' ) );
	$wp_customize->add_setting( 'decorza_stat3_text', array( 'default' => __( 'Trusted Tips Shared', 'decorza' ), 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_stat3_text', array( 'label' => __( 'Highlight 3 Label', 'decorza' ), 'section' => 'decorza_about_section', 'type' => 'text' ) );

	// About Button
	$wp_customize->add_setting( 'decorza_about_btn_text', array( 'default' => __( 'Learn More About Us', 'decorza' ), 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_about_btn_text', array( 'label' => __( 'About Button Label', 'decorza' ), 'section' => 'decorza_about_section', 'type' => 'text' ) );
	$wp_customize->add_setting( 'decorza_about_btn_url', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_about_btn_url', array( 'label' => __( 'About Button URL', 'decorza' ), 'section' => 'decorza_about_section', 'type' => 'url' ) );

	// =========================================================================
	// 5. HOMEPAGE LAYOUT & SECTION TOGGLES
	// =========================================================================
	$wp_customize->add_section( 'decorza_layout_section', array(
		'title'       => __( 'Homepage Layout & Sections', 'decorza' ),
		'panel'       => 'decorza_theme_panel',
		'priority'    => 50,
	) );

	// Toggles
	$wp_customize->add_setting( 'decorza_enable_categories_sec', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_categories_sec', array( 'label' => __( 'Show Featured Categories Section', 'decorza' ), 'section' => 'decorza_layout_section', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'decorza_enable_latest_posts_sec', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_latest_posts_sec', array( 'label' => __( 'Show Latest Articles Section', 'decorza' ), 'section' => 'decorza_layout_section', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'decorza_enable_popular_sec', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_popular_sec', array( 'label' => __( 'Show Most Popular Posts Section', 'decorza' ), 'section' => 'decorza_layout_section', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'decorza_enable_authors_sec', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_authors_sec', array( 'label' => __( 'Show Authors/Team Section', 'decorza' ), 'section' => 'decorza_layout_section', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'decorza_enable_newsletter_sec', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_newsletter_sec', array( 'label' => __( 'Show Newsletter Signup Section', 'decorza' ), 'section' => 'decorza_layout_section', 'type' => 'checkbox' ) );

	// Post Counts
	$wp_customize->add_setting( 'decorza_latest_posts_count', array( 'default' => 6, 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_latest_posts_count', array(
		'label'    => __( 'Number of Latest Posts on Homepage', 'decorza' ),
		'section'  => 'decorza_layout_section',
		'type'     => 'select',
		'choices'  => array( 3 => '3 Posts', 6 => '6 Posts', 9 => '9 Posts', 12 => '12 Posts' ),
	) );

	// Section Titles
	$wp_customize->add_setting( 'decorza_categories_title', array( 'default' => __( 'Explore Categories', 'decorza' ), 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_categories_title', array( 'label' => __( 'Featured Categories Title', 'decorza' ), 'section' => 'decorza_layout_section', 'type' => 'text' ) );

	$wp_customize->add_setting( 'decorza_latest_title', array( 'default' => __( 'Latest Articles', 'decorza' ), 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_latest_title', array( 'label' => __( 'Latest Articles Title', 'decorza' ), 'section' => 'decorza_layout_section', 'type' => 'text' ) );

	// Latest Articles Button (Text & URL)
	$wp_customize->add_setting( 'decorza_latest_btn_text', array( 'default' => __( 'View All Articles', 'decorza' ), 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_latest_btn_text', array( 'label' => __( 'Latest Articles Button Label', 'decorza' ), 'section' => 'decorza_layout_section', 'type' => 'text' ) );

	$wp_customize->add_setting( 'decorza_latest_btn_url', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_latest_btn_url', array(
		'label'       => __( 'Latest Articles Button Link URL', 'decorza' ),
		'description' => __( 'Leave empty to automatically link to your main Blog/Posts page.', 'decorza' ),
		'section'     => 'decorza_layout_section',
		'type'        => 'url',
	) );

	$wp_customize->add_setting( 'decorza_popular_title', array( 'default' => __( 'Most Popular', 'decorza' ), 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_popular_title', array( 'label' => __( 'Most Popular Posts Title', 'decorza' ), 'section' => 'decorza_layout_section', 'type' => 'text' ) );

	$wp_customize->add_setting( 'decorza_authors_title', array( 'default' => __( 'Meet Our Writers', 'decorza' ), 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_authors_title', array( 'label' => __( 'Authors Section Title', 'decorza' ), 'section' => 'decorza_layout_section', 'type' => 'text' ) );

	// =========================================================================
	// 6. NEWSLETTER SECTION
	// =========================================================================
	$wp_customize->add_section( 'decorza_newsletter_section', array(
		'title'       => __( 'Newsletter Section', 'decorza' ),
		'panel'       => 'decorza_theme_panel',
		'priority'    => 60,
	) );

	$wp_customize->add_setting( 'decorza_newsletter_title', array( 'default' => __( 'Stay Inspired', 'decorza' ), 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_newsletter_title', array( 'label' => __( 'Newsletter Title', 'decorza' ), 'section' => 'decorza_newsletter_section', 'type' => 'text' ) );

	$wp_customize->add_setting( 'decorza_newsletter_subtext', array(
		'default'           => __( 'Subscribe to get the latest decor trends, styling formulas, and DIY projects delivered straight to your inbox.', 'decorza' ),
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_newsletter_subtext', array( 'label' => __( 'Newsletter Subtext', 'decorza' ), 'section' => 'decorza_newsletter_section', 'type' => 'textarea' ) );

	// Newsletter Button Text & URL
	$wp_customize->add_setting( 'decorza_newsletter_btn_text', array( 'default' => __( 'Subscribe Free', 'decorza' ), 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_newsletter_btn_text', array( 'label' => __( 'Newsletter Button Label', 'decorza' ), 'section' => 'decorza_newsletter_section', 'type' => 'text' ) );

	$wp_customize->add_setting( 'decorza_newsletter_btn_url', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( 'decorza_newsletter_btn_url', array(
		'label'       => __( 'Newsletter Button Custom Link (Optional)', 'decorza' ),
		'description' => __( 'Leave empty if using standard email form submit button.', 'decorza' ),
		'section'     => 'decorza_newsletter_section',
		'type'        => 'url',
	) );

	$wp_customize->add_setting( 'decorza_newsletter_shortcode', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_newsletter_shortcode', array( 'label' => __( 'Newsletter Plugin Shortcode (Optional)', 'decorza' ), 'description' => __( 'Paste shortcode from Mailchimp, FluentCRM, or MailerLite if preferred.', 'decorza' ), 'section' => 'decorza_newsletter_section', 'type' => 'text' ) );

	$wp_customize->add_setting( 'decorza_newsletter_bg', array( 'default' => '#ECF0F1', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'decorza_newsletter_bg', array(
		'label'    => __( 'Newsletter Background Color', 'decorza' ),
		'section'  => 'decorza_newsletter_section',
		'settings' => 'decorza_newsletter_bg',
	) ) );

	// =========================================================================
	// 7. BLOG & ARCHIVE SETTINGS
	// =========================================================================
	$wp_customize->add_section( 'decorza_blog_section', array(
		'title'       => __( 'Blog & Archive Settings', 'decorza' ),
		'panel'       => 'decorza_theme_panel',
		'priority'    => 70,
	) );

	$wp_customize->add_setting( 'decorza_blog_layout', array( 'default' => 'grid', 'sanitize_callback' => 'decorza_sanitize_select', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_blog_layout', array(
		'label'    => __( 'Archive Posts Layout', 'decorza' ),
		'section'  => 'decorza_blog_section',
		'type'     => 'radio',
		'choices'  => array( 'grid' => __( 'Grid (3 columns)', 'decorza' ), 'list' => __( 'Horizontal List', 'decorza' ) ),
	) );

	$wp_customize->add_setting( 'decorza_enable_sidebar', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_sidebar', array( 'label' => __( 'Enable Sidebar on Blog/Archive', 'decorza' ), 'section' => 'decorza_blog_section', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'decorza_sidebar_position', array( 'default' => 'right', 'sanitize_callback' => 'decorza_sanitize_select', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_sidebar_position', array(
		'label'    => __( 'Sidebar Position', 'decorza' ),
		'section'  => 'decorza_blog_section',
		'type'     => 'radio',
		'choices'  => array( 'right' => __( 'Right Sidebar', 'decorza' ), 'left' => __( 'Left Sidebar', 'decorza' ) ),
	) );

	$wp_customize->add_setting( 'decorza_enable_breadcrumbs', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_breadcrumbs', array( 'label' => __( 'Display Breadcrumbs Navigation', 'decorza' ), 'section' => 'decorza_blog_section', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'decorza_excerpt_length', array( 'default' => 20, 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_excerpt_length', array( 'label' => __( 'Excerpt Word Count', 'decorza' ), 'section' => 'decorza_blog_section', 'type' => 'number' ) );

	// =========================================================================
	// 8. SINGLE POST SETTINGS
	// =========================================================================
	$wp_customize->add_section( 'decorza_single_section', array(
		'title'       => __( 'Single Post Settings', 'decorza' ),
		'panel'       => 'decorza_theme_panel',
		'priority'    => 80,
	) );

	$wp_customize->add_setting( 'decorza_enable_author_box', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_author_box', array( 'label' => __( 'Enable Author Bio Box', 'decorza' ), 'section' => 'decorza_single_section', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'decorza_enable_related_posts', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_related_posts', array( 'label' => __( 'Enable Related Posts Section', 'decorza' ), 'section' => 'decorza_single_section', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'decorza_enable_social_share', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_social_share', array( 'label' => __( 'Enable Floating Social Share Buttons', 'decorza' ), 'section' => 'decorza_single_section', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'decorza_enable_reading_time', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_reading_time', array( 'label' => __( 'Enable Reading Time Estimate', 'decorza' ), 'section' => 'decorza_single_section', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'decorza_enable_toc', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_toc', array( 'label' => __( 'Enable Auto Table of Contents', 'decorza' ), 'section' => 'decorza_single_section', 'type' => 'checkbox' ) );

	// =========================================================================
	// 9. FOOTER SETTINGS
	// =========================================================================
	$wp_customize->add_section( 'decorza_footer_section', array(
		'title'       => __( 'Footer Settings', 'decorza' ),
		'panel'       => 'decorza_theme_panel',
		'priority'    => 90,
	) );

	$wp_customize->add_setting( 'decorza_footer_bg', array( 'default' => '#2C3E50', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'decorza_footer_bg', array(
		'label'    => __( 'Footer Background Color', 'decorza' ),
		'section'  => 'decorza_footer_section',
		'settings' => 'decorza_footer_bg',
	) ) );

	$wp_customize->add_setting( 'decorza_footer_columns', array( 'default' => 4, 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_footer_columns', array(
		'label'    => __( 'Footer Widget Columns', 'decorza' ),
		'section'  => 'decorza_footer_section',
		'type'     => 'select',
		'choices'  => array( 2 => '2 Columns', 3 => '3 Columns', 4 => '4 Columns' ),
	) );

	$wp_customize->add_setting( 'decorza_copyright_text', array(
		'default'           => __( '© {year} HomeDecorZa. All Rights Reserved.', 'decorza' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'decorza_copyright_text', array(
		'label'       => __( 'Copyright Text', 'decorza' ),
		'description' => __( 'Use {year} to dynamically output the current year.', 'decorza' ),
		'section'     => 'decorza_footer_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'decorza_enable_back_to_top', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_back_to_top', array( 'label' => __( 'Enable Back to Top Button', 'decorza' ), 'section' => 'decorza_footer_section', 'type' => 'checkbox' ) );

	// Social Links
	$social_platforms = array(
		'facebook'  => __( 'Facebook URL', 'decorza' ),
		'instagram' => __( 'Instagram URL', 'decorza' ),
		'pinterest' => __( 'Pinterest URL', 'decorza' ),
		'twitter'   => __( 'Twitter / X URL', 'decorza' ),
		'youtube'   => __( 'YouTube URL', 'decorza' ),
	);

	foreach ( $social_platforms as $key => $label ) {
		$wp_customize->add_setting( 'decorza_social_' . $key, array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
		$wp_customize->add_control( 'decorza_social_' . $key, array(
			'label'    => $label,
			'section'  => 'decorza_footer_section',
			'type'     => 'url',
		) );
	}

	// =========================================================================
	// 10. CONTACT PAGE SETTINGS
	// =========================================================================
	$wp_customize->add_section( 'decorza_contact_section', array(
		'title'       => __( 'Contact Page Settings', 'decorza' ),
		'panel'       => 'decorza_theme_panel',
		'priority'    => 95,
	) );

	$wp_customize->add_setting( 'decorza_contact_email', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_email',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_contact_email', array(
		'label'       => __( 'Recipient Contact Email', 'decorza' ),
		'description' => __( 'Leave blank to use the WordPress administration email.', 'decorza' ),
		'section'     => 'decorza_contact_section',
		'type'        => 'email',
	) );

	$wp_customize->add_setting( 'decorza_contact_phone', array(
		'default'           => '+1 (555) 234-5678',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_contact_phone', array(
		'label'    => __( 'Studio Telephone / Phone', 'decorza' ),
		'section'  => 'decorza_contact_section',
		'type'     => 'text',
	) );

	$wp_customize->add_setting( 'decorza_contact_address', array(
		'default'           => '450 Design Avenue, Studio 200, New York, NY 10018',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_contact_address', array(
		'label'    => __( 'Studio Address / Location', 'decorza' ),
		'section'  => 'decorza_contact_section',
		'type'     => 'text',
	) );

	$wp_customize->add_setting( 'decorza_contact_hours', array(
		'default'           => 'Mon - Fri: 9:00 AM - 6:00 PM EST',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_contact_hours', array(
		'label'    => __( 'Office Hours', 'decorza' ),
		'section'  => 'decorza_contact_section',
		'type'     => 'text',
	) );

	$wp_customize->add_setting( 'decorza_contact_shortcode', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_contact_shortcode', array(
		'label'       => __( 'Contact Form Plugin Shortcode (Optional)', 'decorza' ),
		'description' => __( 'If you prefer using WPForms or Contact Form 7, paste your shortcode here.', 'decorza' ),
		'section'     => 'decorza_contact_section',
		'type'        => 'text',
	) );

	// =========================================================================
	// 11. SEO SETTINGS
	// =========================================================================
	$wp_customize->add_section( 'decorza_seo_section', array(
		'title'       => __( 'SEO & Meta Settings', 'decorza' ),
		'panel'       => 'decorza_theme_panel',
		'priority'    => 100,
	) );

	$wp_customize->add_setting( 'decorza_enable_schema', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_schema', array( 'label' => __( 'Enable Schema.org JSON-LD Markup', 'decorza' ), 'section' => 'decorza_seo_section', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'decorza_enable_opengraph', array( 'default' => true, 'sanitize_callback' => 'decorza_sanitize_checkbox', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_enable_opengraph', array( 'label' => __( 'Enable Open Graph & Twitter Cards', 'decorza' ), 'section' => 'decorza_seo_section', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'decorza_default_meta_desc', array(
		'default'           => __( 'HomeDecorZa is your premier home decor & interior design destination for stylish layouts, decor guides, and modern inspiration.', 'decorza' ),
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'decorza_default_meta_desc', array( 'label' => __( 'Default Meta Description', 'decorza' ), 'section' => 'decorza_seo_section', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'decorza_analytics_code', array( 'default' => '', 'sanitize_callback' => 'decorza_sanitize_raw_html', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'decorza_analytics_code', array(
		'label'       => __( 'Google Analytics / Header Script', 'decorza' ),
		'description' => __( 'Inserted securely into <head> (e.g. Google Analytics tag).', 'decorza' ),
		'section'     => 'decorza_seo_section',
		'type'        => 'textarea',
	) );

	// -------------------------------------------------------------------------
	// 12. SELECTIVE REFRESH & EDIT SHORTCUTS (BLUE PENCIL ICONS)
	// -------------------------------------------------------------------------
	if ( isset( $wp_customize->selective_refresh ) ) {

		// Site Title
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.decorza-site-title a',
			'render_callback' => 'decorza_customize_partial_blogname',
		) );

		// Site Tagline
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.decorza-site-description',
			'render_callback' => 'decorza_customize_partial_blogdescription',
		) );

		// Custom Logo
		$wp_customize->selective_refresh->add_partial( 'decorza_logo_partial', array(
			'selector'        => '.decorza-logo-wrapper',
			'settings'        => array( 'custom_logo', 'decorza_custom_logo', 'decorza_logo_width' ),
			'render_callback' => 'decorza_customize_partial_logo',
		) );

		// Header Top Bar Announcement Text
		$wp_customize->selective_refresh->add_partial( 'decorza_top_bar_text_partial', array(
			'selector'        => '.decorza-top-bar-text',
			'settings'        => array( 'decorza_top_bar_text' ),
			'render_callback' => 'decorza_customize_partial_top_bar_text',
		) );

		// Header Top Bar Email/Contact
		$wp_customize->selective_refresh->add_partial( 'decorza_top_bar_contact_partial', array(
			'selector'        => '.decorza-top-bar-contact',
			'settings'        => array( 'decorza_top_bar_contact' ),
			'render_callback' => 'decorza_customize_partial_top_bar_contact',
		) );

		// Hero Banner: Tagline
		$wp_customize->selective_refresh->add_partial( 'decorza_hero_tagline_partial', array(
			'selector'        => '.decorza-hero-tagline',
			'settings'        => array( 'decorza_hero_tagline' ),
			'render_callback' => 'decorza_customize_partial_hero_tagline',
		) );

		// Hero Banner: Heading
		$wp_customize->selective_refresh->add_partial( 'decorza_hero_heading_partial', array(
			'selector'        => '.decorza-hero-title',
			'settings'        => array( 'decorza_hero_heading' ),
			'render_callback' => 'decorza_customize_partial_hero_heading',
		) );

		// Hero Banner: Subheading
		$wp_customize->selective_refresh->add_partial( 'decorza_hero_subheading_partial', array(
			'selector'        => '.decorza-hero-subtitle',
			'settings'        => array( 'decorza_hero_subheading' ),
			'render_callback' => 'decorza_customize_partial_hero_subheading',
		) );

		// Hero Banner: Dual Button (Text + URL)
		$wp_customize->selective_refresh->add_partial( 'decorza_hero_btn_partial', array(
			'selector'        => '.decorza-hero-cta',
			'settings'        => array( 'decorza_hero_btn_text', 'decorza_hero_btn_url' ),
			'render_callback' => 'decorza_customize_partial_hero_btn',
		) );

		// Featured Categories Section: Title
		$wp_customize->selective_refresh->add_partial( 'decorza_categories_title_partial', array(
			'selector'        => '.decorza-categories-section .decorza-section-title',
			'settings'        => array( 'decorza_categories_title' ),
			'render_callback' => 'decorza_customize_partial_categories_title',
		) );

		// Latest Articles Section: Title
		$wp_customize->selective_refresh->add_partial( 'decorza_latest_title_partial', array(
			'selector'        => '.decorza-latest-section .decorza-section-title',
			'settings'        => array( 'decorza_latest_title' ),
			'render_callback' => 'decorza_customize_partial_latest_title',
		) );

		// Latest Articles Section: "View All" Button (Text + URL)
		$wp_customize->selective_refresh->add_partial( 'decorza_latest_btn_partial', array(
			'selector'        => '.decorza-latest-btn-wrap',
			'settings'        => array( 'decorza_latest_btn_text', 'decorza_latest_btn_url' ),
			'render_callback' => 'decorza_customize_partial_latest_btn',
		) );

		// About Section: Image
		$wp_customize->selective_refresh->add_partial( 'decorza_about_image_partial', array(
			'selector'        => '.decorza-about-image',
			'settings'        => array( 'decorza_about_image' ),
			'render_callback' => 'decorza_customize_partial_about_image',
		) );

		// About Section: Heading
		$wp_customize->selective_refresh->add_partial( 'decorza_about_heading_partial', array(
			'selector'        => '.decorza-about-heading',
			'settings'        => array( 'decorza_about_heading' ),
			'render_callback' => 'decorza_customize_partial_about_heading',
		) );

		// About Section: Description
		$wp_customize->selective_refresh->add_partial( 'decorza_about_description_partial', array(
			'selector'        => '.decorza-about-description',
			'settings'        => array( 'decorza_about_description' ),
			'render_callback' => 'decorza_customize_partial_about_description',
		) );

		// About Section: Highlight 1 (Number + Label)
		$wp_customize->selective_refresh->add_partial( 'decorza_stat1_partial', array(
			'selector'        => '.decorza-stat-item-1',
			'settings'        => array( 'decorza_stat1_num', 'decorza_stat1_text' ),
			'render_callback' => 'decorza_customize_partial_stat1',
		) );

		// About Section: Highlight 2 (Number + Label)
		$wp_customize->selective_refresh->add_partial( 'decorza_stat2_partial', array(
			'selector'        => '.decorza-stat-item-2',
			'settings'        => array( 'decorza_stat2_num', 'decorza_stat2_text' ),
			'render_callback' => 'decorza_customize_partial_stat2',
		) );

		// About Section: Highlight 3 (Number + Label)
		$wp_customize->selective_refresh->add_partial( 'decorza_stat3_partial', array(
			'selector'        => '.decorza-stat-item-3',
			'settings'        => array( 'decorza_stat3_num', 'decorza_stat3_text' ),
			'render_callback' => 'decorza_customize_partial_stat3',
		) );

		// About Section: Button (Text + URL)
		$wp_customize->selective_refresh->add_partial( 'decorza_about_btn_partial', array(
			'selector'        => '.decorza-about-btn-wrap',
			'settings'        => array( 'decorza_about_btn_text', 'decorza_about_btn_url' ),
			'render_callback' => 'decorza_customize_partial_about_btn',
		) );

		// Popular Posts Section: Title
		$wp_customize->selective_refresh->add_partial( 'decorza_popular_title_partial', array(
			'selector'        => '.decorza-popular-section .decorza-section-title',
			'settings'        => array( 'decorza_popular_title' ),
			'render_callback' => 'decorza_customize_partial_popular_title',
		) );

		// Authors Section: Title
		$wp_customize->selective_refresh->add_partial( 'decorza_authors_title_partial', array(
			'selector'        => '.decorza-authors-section .decorza-section-title',
			'settings'        => array( 'decorza_authors_title' ),
			'render_callback' => 'decorza_customize_partial_authors_title',
		) );

		// Newsletter Section: Title
		$wp_customize->selective_refresh->add_partial( 'decorza_newsletter_title_partial', array(
			'selector'        => '.decorza-newsletter-title',
			'settings'        => array( 'decorza_newsletter_title' ),
			'render_callback' => 'decorza_customize_partial_newsletter_title',
		) );

		// Newsletter Section: Subtext
		$wp_customize->selective_refresh->add_partial( 'decorza_newsletter_subtext_partial', array(
			'selector'        => '.decorza-newsletter-subtext',
			'settings'        => array( 'decorza_newsletter_subtext' ),
			'render_callback' => 'decorza_customize_partial_newsletter_subtext',
		) );

		// Newsletter Section: Button
		$wp_customize->selective_refresh->add_partial( 'decorza_newsletter_btn_partial', array(
			'selector'        => '.decorza-newsletter-btn-wrap',
			'settings'        => array( 'decorza_newsletter_btn_text', 'decorza_newsletter_btn_url' ),
			'render_callback' => 'decorza_customize_partial_newsletter_btn',
		) );

		// Footer: Copyright Text
		$wp_customize->selective_refresh->add_partial( 'decorza_copyright_partial', array(
			'selector'        => '.decorza-copyright',
			'settings'        => array( 'decorza_copyright_text' ),
			'render_callback' => 'decorza_customize_partial_copyright',
		) );
	}
}
add_action( 'customize_register', 'decorza_customize_register' );

// -----------------------------------------------------------------------------
// SELECTIVE REFRESH CALLBACK FUNCTIONS
// -----------------------------------------------------------------------------

/**
 * Render callback for site title partial.
 */
function decorza_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render callback for site description partial.
 */
function decorza_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Render callback for custom logo partial.
 */
function decorza_customize_partial_logo() {
	$custom_logo_url = get_theme_mod( 'decorza_custom_logo', '' );
	if ( has_custom_logo() ) {
		return get_custom_logo();
	} elseif ( ! empty( $custom_logo_url ) ) {
		return '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" rel="home"><img src="' . esc_url( $custom_logo_url ) . '" class="custom-logo" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" /></a>';
	} else {
		return '<div class="decorza-site-branding"><h1 class="decorza-site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '<span class="accent-dot">.</span></a></h1></div>';
	}
}

/**
 * Render callback for Top Bar announcement text.
 */
function decorza_customize_partial_top_bar_text() {
	return esc_html( get_theme_mod( 'decorza_top_bar_text', __( 'Transforming Spaces: Expert Interior Decor & Styling Tips', 'decorza' ) ) );
}

/**
 * Render callback for Top Bar contact.
 */
function decorza_customize_partial_top_bar_contact() {
	return esc_html( get_theme_mod( 'decorza_top_bar_contact', 'hello@homedecorza.com' ) );
}

/**
 * Render callback for Hero tagline.
 */
function decorza_customize_partial_hero_tagline() {
	return esc_html( get_theme_mod( 'decorza_hero_tagline', __( 'HOME DECOR INSPIRATION & GUIDES', 'decorza' ) ) );
}

/**
 * Render callback for Hero heading.
 */
function decorza_customize_partial_hero_heading() {
	return esc_html( get_theme_mod( 'decorza_hero_heading', __( 'Transform Your Space with Elegant Decor Ideas', 'decorza' ) ) );
}

/**
 * Render callback for Hero subheading.
 */
function decorza_customize_partial_hero_subheading() {
	return esc_html( get_theme_mod( 'decorza_hero_subheading', __( 'Explore modern aesthetics, cozy Scandinavian layouts, architectural lighting, and DIY tips crafted to bring timeless elegance into every room.', 'decorza' ) ) );
}

/**
 * Render callback for Hero button.
 */
function decorza_customize_partial_hero_btn() {
	$btn_text = get_theme_mod( 'decorza_hero_btn_text', __( 'Explore Articles', 'decorza' ) );
	$btn_url  = get_theme_mod( 'decorza_hero_btn_url', '#decorza-articles' );
	if ( empty( $btn_text ) ) {
		return '';
	}
	return '<a href="' . esc_url( $btn_url ) . '" class="decorza-btn decorza-btn-primary">'
		. esc_html( $btn_text )
		. ' <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
		. '</a>';
}

/**
 * Render callback for Categories section title.
 */
function decorza_customize_partial_categories_title() {
	return esc_html( get_theme_mod( 'decorza_categories_title', __( 'Explore Categories', 'decorza' ) ) );
}

/**
 * Render callback for Latest Articles section title.
 */
function decorza_customize_partial_latest_title() {
	return esc_html( get_theme_mod( 'decorza_latest_title', __( 'Latest Articles', 'decorza' ) ) );
}

/**
 * Render callback for Latest Articles "View All" button.
 */
function decorza_customize_partial_latest_btn() {
	$btn_text     = get_theme_mod( 'decorza_latest_btn_text', __( 'View All Articles', 'decorza' ) );
	$blog_page_id = get_option( 'page_for_posts' );
	$default_url  = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/blog/' );
	$btn_url      = get_theme_mod( 'decorza_latest_btn_url', '' );
	if ( empty( $btn_url ) ) {
		$btn_url = $default_url;
	}
	if ( empty( $btn_text ) ) {
		return '';
	}
	return '<a href="' . esc_url( $btn_url ) . '" class="decorza-btn decorza-btn-outline">'
		. esc_html( $btn_text ) . ' &rarr;'
		. '</a>';
}

/**
 * Render callback for About section image.
 */
function decorza_customize_partial_about_image() {
	$about_img = get_theme_mod( 'decorza_about_image', '' );
	if ( ! empty( $about_img ) ) {
		return '<img src="' . esc_url( $about_img ) . '" alt="' . esc_attr( get_theme_mod( 'decorza_about_heading', 'About HomeDecorZa' ) ) . '" loading="lazy">';
	}
	return '<div style="width: 100%; height: 440px; background: linear-gradient(135deg, #34495E, #1A252F); display: flex; flex-direction: column; align-items: center; justify-content: center; color: #FFF; padding: 2rem; text-align: center;">'
		. '<svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom: 1rem; color: var(--color-secondary);"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>'
		. '<span style="font-family: var(--font-heading); font-size: 1.5rem; font-weight: 700;">HomeDecorZa</span>'
		. '<span style="font-size: 0.9rem; color: #BDC3C7; margin-top: 0.5rem;">' . esc_html__( 'Artisan Interior Styling & Living', 'decorza' ) . '</span>'
		. '</div>';
}

/**
 * Render callback for About heading.
 */
function decorza_customize_partial_about_heading() {
	return esc_html( get_theme_mod( 'decorza_about_heading', __( 'About HomeDecorZa', 'decorza' ) ) );
}

/**
 * Render callback for About description.
 */
function decorza_customize_partial_about_description() {
	return wp_kses_post( wpautop( get_theme_mod( 'decorza_about_description', __( 'HomeDecorZa is a dedicated digital sanctuary for interior architecture, home staging, and thoughtful design. We empower homeowners and interior enthusiasts to build living spaces that reflect grace, warmth, and authentic personality.', 'decorza' ) ) ) );
}

/**
 * Render callback for About stat 1.
 */
function decorza_customize_partial_stat1() {
	return '<span class="decorza-stat-number">' . esc_html( get_theme_mod( 'decorza_stat1_num', '500+' ) ) . '</span>'
		. '<span class="decorza-stat-label">' . esc_html( get_theme_mod( 'decorza_stat1_text', __( 'Curated Articles', 'decorza' ) ) ) . '</span>';
}

/**
 * Render callback for About stat 2.
 */
function decorza_customize_partial_stat2() {
	return '<span class="decorza-stat-number">' . esc_html( get_theme_mod( 'decorza_stat2_num', '100%' ) ) . '</span>'
		. '<span class="decorza-stat-label">' . esc_html( get_theme_mod( 'decorza_stat2_text', __( 'Expert Writers', 'decorza' ) ) ) . '</span>';
}

/**
 * Render callback for About stat 3.
 */
function decorza_customize_partial_stat3() {
	return '<span class="decorza-stat-number">' . esc_html( get_theme_mod( 'decorza_stat3_num', '50K+' ) ) . '</span>'
		. '<span class="decorza-stat-label">' . esc_html( get_theme_mod( 'decorza_stat3_text', __( 'Trusted Tips Shared', 'decorza' ) ) ) . '</span>';
}

/**
 * Render callback for About button.
 */
function decorza_customize_partial_about_btn() {
	$btn_text = get_theme_mod( 'decorza_about_btn_text', __( 'Learn More About Us', 'decorza' ) );
	$btn_url  = get_theme_mod( 'decorza_about_btn_url', '#' );
	if ( empty( $btn_text ) ) {
		return '';
	}
	return '<a href="' . esc_url( $btn_url ) . '" class="decorza-btn decorza-btn-primary">'
		. esc_html( $btn_text )
		. '</a>';
}

/**
 * Render callback for Popular Posts title.
 */
function decorza_customize_partial_popular_title() {
	return esc_html( get_theme_mod( 'decorza_popular_title', __( 'Most Popular', 'decorza' ) ) );
}

/**
 * Render callback for Authors section title.
 */
function decorza_customize_partial_authors_title() {
	return esc_html( get_theme_mod( 'decorza_authors_title', __( 'Meet Our Writers', 'decorza' ) ) );
}

/**
 * Render callback for Newsletter title.
 */
function decorza_customize_partial_newsletter_title() {
	return esc_html( get_theme_mod( 'decorza_newsletter_title', __( 'Stay Inspired', 'decorza' ) ) );
}

/**
 * Render callback for Newsletter subtext.
 */
function decorza_customize_partial_newsletter_subtext() {
	return esc_html( get_theme_mod( 'decorza_newsletter_subtext', __( 'Subscribe to get the latest decor trends, styling formulas, and DIY projects delivered straight to your inbox.', 'decorza' ) ) );
}

/**
 * Render callback for Newsletter button.
 */
function decorza_customize_partial_newsletter_btn() {
	$btn_text = get_theme_mod( 'decorza_newsletter_btn_text', __( 'Subscribe Free', 'decorza' ) );
	$btn_url  = get_theme_mod( 'decorza_newsletter_btn_url', '' );
	if ( ! empty( $btn_url ) ) {
		return '<a href="' . esc_url( $btn_url ) . '" class="decorza-btn decorza-btn-primary">' . esc_html( $btn_text ) . '</a>';
	}
	return '<button type="submit" class="decorza-btn decorza-btn-primary">' . esc_html( $btn_text ) . '</button>';
}

/**
 * Render callback for Footer copyright text.
 */
function decorza_customize_partial_copyright() {
	$copyright_template = get_theme_mod( 'decorza_copyright_text', __( '© {year} HomeDecorZa. All Rights Reserved.', 'decorza' ) );
	return esc_html( str_replace( '{year}', date( 'Y' ), $copyright_template ) );
}

// -----------------------------------------------------------------------------
// LIVE PREVIEW ASSETS ENQUEUE (POSTMESSAGE SCRIPT)
// -----------------------------------------------------------------------------

/**
 * Binds JS handlers to instantly make Theme Customizer preview changes.
 */
function decorza_customize_preview_js() {
	$theme_dir = wp_normalize_path( get_template_directory() );
	$theme_uri = get_template_directory_uri();
	$js_file   = $theme_dir . '/assets/js/customizer-preview.js';
	$version   = file_exists( $js_file ) ? filemtime( $js_file ) : '1.1.0';

	wp_enqueue_script(
		'decorza-customizer-preview',
		$theme_uri . '/assets/js/customizer-preview.js',
		array( 'customize-preview', 'jquery' ),
		$version,
		true
	);
}
add_action( 'customize_preview_init', 'decorza_customize_preview_js' );

// -----------------------------------------------------------------------------
// Sanitization Callbacks
// -----------------------------------------------------------------------------

/**
 * Sanitize checkbox inputs.
 */
function decorza_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && true == $checked ) ? true : false;
}

/**
 * Sanitize select and radio choices.
 */
function decorza_sanitize_select( $input, $setting ) {
	$input   = sanitize_key( $input );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Sanitize raw HTML for analytics script without escaping valid script tags.
 */
function decorza_sanitize_raw_html( $input ) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		return $input;
	}
	return wp_kses_post( $input );
}
