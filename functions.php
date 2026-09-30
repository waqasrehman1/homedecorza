<?php
/**
 * DecorZa Theme Functions & Definitions
 *
 * 100% Linux/Hostinger & Windows/XAMPP Cross-Platform Compatible.
 * Follows strict WordPress Coding Standards (WPCS).
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Set global content width
if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function decorza_setup() {
	// Make theme available for translation with forward-slash path
	load_theme_textdomain( 'decorza', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages
	add_theme_support( 'post-thumbnails' );

	// Custom Image Sizes for optimal performance
	add_image_size( 'decorza-card', 600, 375, true );
	add_image_size( 'decorza-card-horiz', 450, 350, true );
	add_image_size( 'decorza-hero', 1600, 650, true );
	add_image_size( 'decorza-single', 1100, 620, true );

	// Register Navigation Menus
	register_nav_menus( array(
		'primary-menu' => esc_html__( 'Primary Navigation Menu', 'decorza' ),
		'footer-menu'  => esc_html__( 'Footer Legal / Secondary Menu', 'decorza' ),
	) );

	// Switch default core markup to output valid HTML5
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Add support for core custom logo with flexible dimensions
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-width'  => true,
		'flex-height' => true,
		'unlink-homepage-logo' => false,
	) );

	// Add theme support for selective refresh for widgets
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles and full/wide alignments
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'decorza_setup' );

/**
 * Register widget area.
 */
function decorza_widgets_init() {
	// Main Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Main Sidebar', 'decorza' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your blog sidebar.', 'decorza' ),
		'before_widget' => '<div id="%1$s" class="decorza-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="decorza-widget-title">',
		'after_title'   => '</h3>',
	) );

	// 3 Dedicated Footer Columns for fully editable dynamic footer
	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar( array(
			/* translators: %d: footer column number */
			'name'          => sprintf( esc_html__( 'Footer Column %d', 'decorza' ), $i ),
			'id'            => 'footer-' . $i,
			'description'   => sprintf( esc_html__( 'Widgets added here appear in Footer Column %d. Add text, links, or menus from Appearance > Widgets.', 'decorza' ), $i ),
			'before_widget' => '<div id="%1$s" class="decorza-footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="decorza-footer-widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'decorza_widgets_init' );

/**
 * Preconnect to Google Fonts for PageSpeed optimization
 */
function decorza_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'decorza_resource_hints', 10, 2 );

/**
 * Enqueue scripts and styles with Linux file_exists guards & dynamic versioning.
 */
function decorza_scripts() {
	$theme_dir = wp_normalize_path( get_template_directory() );
	$theme_uri = get_template_directory_uri();

	// 1. Google Fonts: Playfair Display (Serif) & Inter (Sans-Serif)
	wp_enqueue_style(
		'decorza-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600;1,700&display=swap',
		array(),
		null
	);

	// 2. Primary Theme Stylesheet (style.css in theme root)
	$style_path = $theme_dir . '/style.css';
	$style_ver  = file_exists( $style_path ) ? filemtime( $style_path ) : '1.0.0';
	wp_enqueue_style( 'decorza-style', get_stylesheet_uri(), array(), $style_ver );

	// 3. Optional Modular CSS (assets/css/main.css) if present
	$main_css_path = $theme_dir . '/assets/css/main.css';
	if ( file_exists( $main_css_path ) ) {
		$main_css_ver = filemtime( $main_css_path );
		wp_enqueue_style( 'decorza-main-css', $theme_uri . '/assets/css/main.css', array( 'decorza-style' ), $main_css_ver );
	}

	// 4. Dynamic Customizer CSS overrides
	$custom_css = decorza_get_customizer_css();
	if ( ! empty( $custom_css ) ) {
		wp_add_inline_style( 'decorza-style', $custom_css );
	}

	// 5. Main Vanilla JavaScript (assets/js/main.js - No jQuery, loaded in footer)
	$main_js_path = $theme_dir . '/assets/js/main.js';
	if ( file_exists( $main_js_path ) ) {
		$main_js_ver = filemtime( $main_js_path );
		wp_enqueue_script(
			'decorza-main-js',
			$theme_uri . '/assets/js/main.js',
			array(),
			$main_js_ver,
			true
		);

		// Localize script for AJAX Contact Form handling
		wp_localize_script( 'decorza-main-js', 'decorza_ajax_obj', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'decorza_contact_action' ),
		) );
	} else {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( '[DecorZa] Assets error: ' . $main_js_path . ' not found on server.' );
		}
	}

	// 6. WordPress Threaded Comments JS
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'decorza_scripts' );

/**
 * Generate inline CSS from Customizer settings
 */
function decorza_get_customizer_css() {
	$primary_color   = get_theme_mod( 'decorza_primary_color', '#2C3E50' );
	$secondary_color = get_theme_mod( 'decorza_secondary_color', '#E67E22' );
	$accent_color    = get_theme_mod( 'decorza_accent_color', '#ECF0F1' );
	$header_bg       = get_theme_mod( 'decorza_header_bg_color', '#FFFFFF' );
	$footer_bg       = get_theme_mod( 'decorza_footer_bg', '#2C3E50' );

	$css = ":root {\n";
	if ( '#2C3E50' !== $primary_color ) {
		$css .= "  --color-primary: " . esc_attr( $primary_color ) . ";\n";
	}
	if ( '#E67E22' !== $secondary_color ) {
		$css .= "  --color-secondary: " . esc_attr( $secondary_color ) . ";\n";
	}
	if ( '#ECF0F1' !== $accent_color ) {
		$css .= "  --color-accent: " . esc_attr( $accent_color ) . ";\n";
	}
	$css .= "}\n";

	if ( '#FFFFFF' !== $header_bg ) {
		$css .= ".decorza-site-header { background-color: " . esc_attr( $header_bg ) . "; }\n";
	}
	if ( '#2C3E50' !== $footer_bg ) {
		$css .= ".decorza-site-footer { background-color: " . esc_attr( $footer_bg ) . "; }\n";
	}

	// Dynamic Logo Dimension Adjustments
	$logo_width       = get_theme_mod( 'decorza_logo_width', 180 );
	$logo_max_height  = get_theme_mod( 'decorza_logo_max_height', 55 );
	$logo_mobile_w    = get_theme_mod( 'decorza_logo_mobile_width', 140 );

	$css .= ".custom-logo-link, .decorza-logo-wrapper { display: inline-flex; align-items: center; }\n";
	$css .= ".custom-logo-link img, .custom-logo, .decorza-logo-wrapper img { width: " . absint( $logo_width ) . "px !important; max-width: 100% !important; max-height: " . absint( $logo_max_height ) . "px !important; height: auto !important; object-fit: contain; display: block; }\n";
	$css .= "@media (max-width: 768px) {\n";
	$css .= "  .custom-logo-link img, .custom-logo, .decorza-logo-wrapper img { width: " . absint( $logo_mobile_w ) . "px !important; max-height: 48px !important; }\n";
	$css .= "}\n";

	return $css;
}

/**
 * Filter the excerpt length.
 */
function decorza_custom_excerpt_length( $length ) {
	$custom_length = get_theme_mod( 'decorza_excerpt_length', 20 );
	return $custom_length ? $custom_length : 20;
}
add_filter( 'excerpt_length', 'decorza_custom_excerpt_length', 999 );

/**
 * Filter the excerpt "read more" string.
 */
function decorza_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'decorza_excerpt_more' );

/**
 * Insert Google Analytics / Custom Header Code
 */
function decorza_header_analytics_code() {
	$analytics = get_theme_mod( 'decorza_analytics_code', '' );
	if ( ! empty( $analytics ) ) {
		echo $analytics . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
add_action( 'wp_head', 'decorza_header_analytics_code', 99 );

/**
 * Handle Standard Contact Form POST Submission
 */
function decorza_handle_contact_form() {
	if ( ! isset( $_POST['decorza_contact_submit'] ) ) {
		return;
	}

	// Honeypot check
	if ( ! empty( $_POST['decorza_hp'] ) ) {
		wp_die( esc_html__( 'Spam detected.', 'decorza' ) );
	}

	// Nonce verification
	if ( ! isset( $_POST['decorza_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['decorza_contact_nonce'] ) ), 'decorza_contact_action' ) ) {
		wp_die( esc_html__( 'Security check failed. Please refresh the page and try again.', 'decorza' ) );
	}

	$name    = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
	$email   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
	$subject = isset( $_POST['contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_subject'] ) ) : __( 'Decor Inquiry', 'decorza' );
	$message = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

	if ( empty( $name ) || empty( $email ) || empty( $message ) || ! is_email( $email ) ) {
		$redirect = add_query_arg( 'contact_status', 'error', wp_get_referer() ? wp_get_referer() : home_url( '/' ) );
		wp_safe_redirect( $redirect );
		exit;
	}

	$recipient = get_theme_mod( 'decorza_contact_email', '' );
	if ( empty( $recipient ) ) {
		$recipient = get_option( 'admin_email' );
	}

	$mail_subject = '[' . get_bloginfo( 'name' ) . '] ' . $subject . ' - ' . $name;
	$mail_body    = "You have received a new inquiry from the DecorZa contact form:\n\n";
	$mail_body   .= "Name: " . $name . "\n";
	$mail_body   .= "Email: " . $email . "\n";
	$mail_body   .= "Topic: " . $subject . "\n\n";
	$mail_body   .= "Message:\n" . $message . "\n\n";
	$mail_body   .= "---\nSent from " . home_url();

	$headers = array(
		'From: ' . get_bloginfo( 'name' ) . ' <' . $recipient . '>',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( $recipient, $mail_subject, $mail_body, $headers );

	$status = $sent ? 'success' : 'failed';
	$redirect = add_query_arg( 'contact_status', $status, wp_get_referer() ? wp_get_referer() : home_url( '/' ) );
	wp_safe_redirect( $redirect );
	exit;
}
add_action( 'template_redirect', 'decorza_handle_contact_form' );

/**
 * Handle AJAX Contact Form Submission
 */
function decorza_ajax_contact() {
	check_ajax_referer( 'decorza_contact_action', 'nonce' );

	if ( ! empty( $_POST['decorza_hp'] ) ) {
		wp_send_json_error( array( 'message' => __( 'Spam detected.', 'decorza' ) ) );
	}

	$name    = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
	$email   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
	$subject = isset( $_POST['contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_subject'] ) ) : __( 'Decor Inquiry', 'decorza' );
	$message = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

	if ( empty( $name ) || empty( $email ) || empty( $message ) || ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in all required fields with a valid email.', 'decorza' ) ) );
	}

	$recipient = get_theme_mod( 'decorza_contact_email', '' );
	if ( empty( $recipient ) ) {
		$recipient = get_option( 'admin_email' );
	}

	$mail_subject = '[' . get_bloginfo( 'name' ) . '] ' . $subject . ' - ' . $name;
	$mail_body    = "You have received a new inquiry from the DecorZa contact form:\n\n";
	$mail_body   .= "Name: " . $name . "\n";
	$mail_body   .= "Email: " . $email . "\n";
	$mail_body   .= "Topic: " . $subject . "\n\n";
	$mail_body   .= "Message:\n" . $message . "\n\n";
	$mail_body   .= "---\nSent from " . home_url();

	$headers = array(
		'From: ' . get_bloginfo( 'name' ) . ' <' . $recipient . '>',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( $recipient, $mail_subject, $mail_body, $headers );

	if ( $sent ) {
		wp_send_json_success( array( 'message' => __( 'Thank you! Your message has been sent successfully. Our interior styling team will respond promptly.', 'decorza' ) ) );
	} else {
		wp_send_json_error( array( 'message' => __( 'There was an issue sending your message. Please try again or reach out directly via email.', 'decorza' ) ) );
	}
}
add_action( 'wp_ajax_decorza_contact', 'decorza_ajax_contact' );
add_action( 'wp_ajax_nopriv_decorza_contact', 'decorza_ajax_contact' );

// =============================================================================
// CATEGORY CUSTOM IMAGE UPLOAD (TERM META WITHOUT PLUGINS)
// =============================================================================

/**
 * Add image field to Category creation form (add-tag).
 */
function decorza_add_category_image_field() {
	?>
	<div class="form-field term-group">
		<label for="decorza_category_image"><?php esc_html_e( 'Category Featured Image', 'decorza' ); ?></label>
		<input type="hidden" id="decorza_category_image" name="decorza_category_image" value="">
		<div id="decorza-category-image-wrapper" style="margin-bottom: 10px;"></div>
		<p>
			<button type="button" class="button button-secondary" id="decorza_upload_image_btn"><?php esc_html_e( 'Upload / Select Image', 'decorza' ); ?></button>
			<button type="button" class="button button-secondary" id="decorza_remove_image_btn" style="display:none;"><?php esc_html_e( 'Remove Image', 'decorza' ); ?></button>
		</p>
		<p class="description"><?php esc_html_e( 'Upload a featured image for this category to appear on homepage category cards and category archive hero banners.', 'decorza' ); ?></p>
	</div>
	<?php
}
add_action( 'category_add_form_fields', 'decorza_add_category_image_field', 10, 2 );

/**
 * Add image field to Category edit form (term.php).
 */
function decorza_edit_category_image_field( $term ) {
	$image_id  = get_term_meta( $term->term_id, 'decorza_category_image', true );
	$image_url = '';
	if ( ! empty( $image_id ) ) {
		if ( is_numeric( $image_id ) ) {
			$image_url = wp_get_attachment_image_url( (int) $image_id, 'medium' );
		} elseif ( filter_var( $image_id, FILTER_VALIDATE_URL ) ) {
			$image_url = $image_id;
		}
	}
	?>
	<tr class="form-field term-group-wrap">
		<th scope="row">
			<label for="decorza_category_image"><?php esc_html_e( 'Category Featured Image', 'decorza' ); ?></label>
		</th>
		<td>
			<input type="hidden" id="decorza_category_image" name="decorza_category_image" value="<?php echo esc_attr( $image_id ); ?>">
			<div id="decorza-category-image-wrapper" style="margin-bottom: 12px;">
				<?php if ( $image_url ) : ?>
					<img src="<?php echo esc_url( $image_url ); ?>" style="max-width: 240px; height: auto; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.12); display: block;" />
				<?php endif; ?>
			</div>
			<p>
				<button type="button" class="button button-secondary" id="decorza_upload_image_btn"><?php esc_html_e( 'Upload / Select Image', 'decorza' ); ?></button>
				<button type="button" class="button button-secondary" id="decorza_remove_image_btn" style="<?php echo $image_url ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Remove Image', 'decorza' ); ?></button>
			</p>
			<p class="description"><?php esc_html_e( 'Upload a featured image for this category to appear on homepage category cards and category archive hero banners.', 'decorza' ); ?></p>
		</td>
	</tr>
	<?php
}
add_action( 'category_edit_form_fields', 'decorza_edit_category_image_field', 10, 2 );

/**
 * Save category image term meta on create/edit.
 */
function decorza_save_category_image( $term_id ) {
	if ( isset( $_POST['decorza_category_image'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$image_val = sanitize_text_field( wp_unslash( $_POST['decorza_category_image'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( ! empty( $image_val ) ) {
			update_term_meta( $term_id, 'decorza_category_image', $image_val );
		} else {
			delete_term_meta( $term_id, 'decorza_category_image' );
		}
	}
}
add_action( 'created_category', 'decorza_save_category_image', 10, 2 );
add_action( 'edited_category', 'decorza_save_category_image', 10, 2 );

/**
 * Enqueue WP Media library scripts on Category edit screens and add media handler JS.
 */
function decorza_category_image_admin_scripts( $hook_suffix ) {
	if ( 'edit-tags.php' === $hook_suffix || 'term.php' === $hook_suffix ) {
		$screen = get_current_screen();
		if ( $screen && 'category' === $screen->taxonomy ) {
			wp_enqueue_media();
			add_action( 'admin_footer', 'decorza_category_image_admin_footer_js' );
		}
	}
}
add_action( 'admin_enqueue_scripts', 'decorza_category_image_admin_scripts' );

/**
 * Print JavaScript for media uploader in admin footer.
 */
function decorza_category_image_admin_footer_js() {
	?>
	<script>
	jQuery(document).ready(function($) {
		var fileFrame;
		$('#decorza_upload_image_btn').on('click', function(e) {
			e.preventDefault();
			if (fileFrame) {
				fileFrame.open();
				return;
			}
			fileFrame = wp.media({
				title: '<?php echo esc_js( __( 'Select or Upload Category Image', 'decorza' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Use this image', 'decorza' ) ); ?>' },
				multiple: false
			});
			fileFrame.on('select', function() {
				var attachment = fileFrame.state().get('selection').first().toJSON();
				var imgUrl = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
				$('#decorza_category_image').val(attachment.id);
				$('#decorza-category-image-wrapper').html('<img src="' + imgUrl + '" style="max-width: 240px; height: auto; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.12); display: block;" />');
				$('#decorza_remove_image_btn').show();
			});
			fileFrame.open();
		});

		$('#decorza_remove_image_btn').on('click', function(e) {
			e.preventDefault();
			$('#decorza_category_image').val('');
			$('#decorza-category-image-wrapper').empty();
			$(this).hide();
		});

		// Reset fields after AJAX add-tag event in edit-tags.php
		$(document).ajaxComplete(function(event, xhr, settings) {
			if (settings.data && settings.data.indexOf('action=add-tag') !== -1) {
				var res = xhr.responseXML;
				if (res && $(res).find('term_id').length > 0) {
					$('#decorza_category_image').val('');
					$('#decorza-category-image-wrapper').empty();
					$('#decorza_remove_image_btn').hide();
				}
			}
		});
	});
	</script>
	<?php
}

/**
 * Helper function to retrieve category image URL.
 *
 * @param int    $term_id Category term ID.
 * @param string $size    Image size name. Default 'decorza-card'.
 * @return string Image URL if exists, or empty string.
 */
function decorza_get_category_image_url( $term_id, $size = 'decorza-card' ) {
	if ( ! $term_id ) {
		return '';
	}

	$image_id = get_term_meta( $term_id, 'decorza_category_image', true );
	if ( empty( $image_id ) ) {
		$image_id = get_term_meta( $term_id, 'category_image', true );
	}

	if ( ! empty( $image_id ) ) {
		if ( is_numeric( $image_id ) ) {
			$url = wp_get_attachment_image_url( (int) $image_id, $size );
			if ( $url ) {
				return $url;
			}
		} elseif ( filter_var( $image_id, FILTER_VALIDATE_URL ) ) {
			return $image_id;
		}
	}

	return '';
}

// =============================================================================
// LINUX / HOSTINGER FATAL ERROR PROTECTION: SAFE FILE LOADER
// =============================================================================

/**
 * Safely includes a theme file with file_exists check, normalized path separators,
 * and admin notice reporting. Completely eliminates 500 Fatal Errors / White Screen of Death.
 *
 * @param string $relative_path Relative path from theme root using forward slashes (e.g. 'inc/customizer.php').
 * @return bool True if file was successfully loaded, false otherwise.
 */
function decorza_safe_include( $relative_path ) {
	// Normalize base directory and path with forward slashes (Linux standard)
	$theme_dir = wp_normalize_path( get_template_directory() );
	$clean_rel = ltrim( str_replace( '\\', '/', $relative_path ), '/' );
	$file_path = $theme_dir . '/' . $clean_rel;

	if ( file_exists( $file_path ) ) {
		require_once $file_path;
		return true;
	}

	// 1. Log to PHP error_log if debugging is enabled
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( sprintf( '[DecorZa Theme Fatal Error Prevention] Required file missing on server: %s', $file_path ) );
	}

	// 2. Display admin warning notice instead of crashing with a Critical Error
	add_action( 'admin_notices', function() use ( $clean_rel, $file_path ) {
		if ( current_user_can( 'manage_options' ) ) {
			?>
			<div class="notice notice-error is-dismissible">
				<p>
					<strong><?php esc_html_e( 'DecorZa Theme Warning:', 'decorza' ); ?></strong>
					<?php
					/* translators: 1: relative file path, 2: full absolute path */
					printf(
						esc_html__( 'Failed to locate theme component "%1$s" at path: "%2$s". If deploying to Linux / Hostinger, check that folder names are strictly lowercase (e.g., "inc" not "Inc") and that the ZIP archive was extracted with proper directory hierarchy.', 'decorza' ),
						'<code>' . esc_html( $clean_rel ) . '</code>',
						'<code>' . esc_html( $file_path ) . '</code>'
					);
					?>
				</p>
			</div>
			<?php
		}
	} );

	return false;
}

// Safely require all core modular files
decorza_safe_include( 'inc/customizer.php' );
decorza_safe_include( 'inc/widgets.php' );
decorza_safe_include( 'inc/template-tags.php' );
decorza_safe_include( 'inc/schema.php' );
