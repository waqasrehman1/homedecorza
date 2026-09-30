<?php
/**
 * Template Name: Contact Page
 *
 * A specialized 2-column contact template for home decor inquiries,
 * editorial pitches, design consultations, and partnerships.
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Fetch contact settings from Customizer
$recipient_email = get_theme_mod( 'decorza_contact_email', '' );
if ( empty( $recipient_email ) ) {
	$recipient_email = get_option( 'admin_email' );
}
$contact_phone   = get_theme_mod( 'decorza_contact_phone', '+1 (555) 234-5678' );
$contact_address = get_theme_mod( 'decorza_contact_address', '450 Design Avenue, Studio 200, New York, NY 10018' );
$contact_hours   = get_theme_mod( 'decorza_contact_hours', 'Mon - Fri: 9:00 AM - 6:00 PM EST' );
$shortcode       = get_theme_mod( 'decorza_contact_shortcode', '' );
$status          = isset( $_GET['contact_status'] ) ? sanitize_text_field( wp_unslash( $_GET['contact_status'] ) ) : '';
?>

<!-- Contact Hero Banner -->
<header class="decorza-category-hero" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); color: #FFFFFF; padding: 4rem 1.5rem 3.5rem; text-align: center;">
	<div class="decorza-container" style="max-width: 800px;">
		<span class="decorza-badge" style="background: var(--color-secondary); color: #FFF; margin-bottom: 1rem;"><?php esc_html_e( 'CONNECT WITH US', 'decorza' ); ?></span>
		<h1 style="color: #FFFFFF; font-size: clamp(2.2rem, 4vw, 3.25rem); margin-bottom: 1rem;">
			<?php the_title(); ?>
		</h1>
		<p style="font-size: 1.1rem; line-height: 1.6; color: #ECF0F1; max-width: 650px; margin: 0 auto;">
			<?php esc_html_e( 'Have questions about interior styling, editorial collaborations, or design features? We would love to hear from you.', 'decorza' ); ?>
		</p>
	</div>
</header>

<div class="decorza-section">
	<div class="decorza-container">
		<?php decorza_breadcrumbs(); ?>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php if ( get_the_content() ) : ?>
					<div class="decorza-reading-view" style="margin-bottom: 3rem;">
						<div class="decorza-article-content">
							<?php the_content(); ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endwhile; ?>
		<?php endif; ?>

		<!-- 2-Column Contact Grid -->
		<div class="decorza-contact-grid">
			<!-- Left Column: Studio & Contact Info -->
			<div class="decorza-contact-info-col">
				<div class="decorza-contact-card">
					<span class="decorza-badge" style="margin-bottom: 1rem;"><?php esc_html_e( 'STUDIO INFORMATION', 'decorza' ); ?></span>
					<h2 style="font-size: 1.85rem; margin-bottom: 1rem;"><?php esc_html_e( 'Let\'s Discuss Your Next Space', 'decorza' ); ?></h2>
					<p style="color: var(--color-text-muted); line-height: 1.65; margin-bottom: 2rem;">
						<?php esc_html_e( 'Whether you are planning a room renovation, seeking decor product reviews, or pitching an interior feature article, our editorial and design team is here to assist.', 'decorza' ); ?>
					</p>

					<div class="decorza-contact-meta-list">
						<!-- Email -->
						<div class="decorza-contact-meta-item">
							<div class="decorza-contact-icon">
								<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
							</div>
							<div>
								<span class="decorza-contact-label"><?php esc_html_e( 'Direct Email', 'decorza' ); ?></span>
								<a href="mailto:<?php echo esc_attr( $recipient_email ); ?>" class="decorza-contact-value"><?php echo esc_html( $recipient_email ); ?></a>
							</div>
						</div>

						<!-- Phone -->
						<?php if ( ! empty( $contact_phone ) ) : ?>
							<div class="decorza-contact-meta-item">
								<div class="decorza-contact-icon">
									<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
								</div>
								<div>
									<span class="decorza-contact-label"><?php esc_html_e( 'Telephone', 'decorza' ); ?></span>
									<span class="decorza-contact-value"><?php echo esc_html( $contact_phone ); ?></span>
								</div>
							</div>
						<?php endif; ?>

						<!-- Address -->
						<?php if ( ! empty( $contact_address ) ) : ?>
							<div class="decorza-contact-meta-item">
								<div class="decorza-contact-icon">
									<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
								</div>
								<div>
									<span class="decorza-contact-label"><?php esc_html_e( 'Studio Location', 'decorza' ); ?></span>
									<span class="decorza-contact-value"><?php echo esc_html( $contact_address ); ?></span>
								</div>
							</div>
						<?php endif; ?>

						<!-- Hours -->
						<?php if ( ! empty( $contact_hours ) ) : ?>
							<div class="decorza-contact-meta-item">
								<div class="decorza-contact-icon">
									<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
								</div>
								<div>
									<span class="decorza-contact-label"><?php esc_html_e( 'Office Hours', 'decorza' ); ?></span>
									<span class="decorza-contact-value"><?php echo esc_html( $contact_hours ); ?></span>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<!-- Follow Us Socials -->
					<div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--color-border);">
						<span style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: var(--color-text-muted); display: block; margin-bottom: 0.75rem;"><?php esc_html_e( 'Follow Our Moodboards', 'decorza' ); ?></span>
						<div class="decorza-footer-socials" style="margin-top: 0;">
							<?php
							$social_pin = get_theme_mod( 'decorza_social_pinterest', '#' );
							$social_ig  = get_theme_mod( 'decorza_social_instagram', '#' );
							$social_fb  = get_theme_mod( 'decorza_social_facebook', '#' );
							?>
							<?php if ( ! empty( $social_pin ) ) : ?>
								<a href="<?php echo esc_url( $social_pin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Pinterest" style="background-color: var(--color-accent); color: var(--color-primary);">
									<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345-.09.375-.291 1.199-.334 1.373-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>
								</a>
							<?php endif; ?>
							<?php if ( ! empty( $social_ig ) ) : ?>
								<a href="<?php echo esc_url( $social_ig ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram" style="background-color: var(--color-accent); color: var(--color-primary);">
									<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
								</a>
							<?php endif; ?>
							<?php if ( ! empty( $social_fb ) ) : ?>
								<a href="<?php echo esc_url( $social_fb ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook" style="background-color: var(--color-accent); color: var(--color-primary);">
									<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

			<!-- Right Column: Form Container -->
			<div class="decorza-contact-form-col">
				<div class="decorza-contact-form-box">
					<h3 style="font-size: 1.6rem; margin-bottom: 0.5rem;"><?php esc_html_e( 'Send Us a Message', 'decorza' ); ?></h3>
					<p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.75rem;">
						<?php esc_html_e( 'Fill out the form below and we will get back to you within 24–48 business hours.', 'decorza' ); ?>
					</p>

					<?php if ( ! empty( $shortcode ) ) : ?>
						<!-- Custom Plugin Shortcode -->
						<div class="decorza-plugin-form-wrap">
							<?php echo do_shortcode( $shortcode ); ?>
						</div>
					<?php else : ?>
						<!-- Built-in DecorZa Contact Form -->
						<?php if ( 'success' === $status ) : ?>
							<div class="decorza-alert decorza-alert-success" role="alert">
								<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
								<span><?php esc_html_e( 'Thank you! Your inquiry has been received. Our team will get back to you shortly.', 'decorza' ); ?></span>
							</div>
						<?php elseif ( 'error' === $status || 'failed' === $status ) : ?>
							<div class="decorza-alert decorza-alert-error" role="alert">
								<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
								<span><?php esc_html_e( 'Oops! Please ensure all required fields are filled out with a valid email address.', 'decorza' ); ?></span>
							</div>
						<?php endif; ?>

						<!-- Dynamic AJAX feedback alert container -->
						<div class="decorza-ajax-alert" style="display: none;" role="alert"></div>

						<form id="decorza-contact-form" method="post" action="" class="decorza-form">
							<?php wp_nonce_field( 'decorza_contact_action', 'decorza_contact_nonce' ); ?>
							
							<!-- Honeypot anti-spam field -->
							<div style="display: none !important;" aria-hidden="true">
								<label for="decorza_hp"><?php esc_html_e( 'Leave this field empty', 'decorza' ); ?></label>
								<input type="text" name="decorza_hp" id="decorza_hp" tabindex="-1" autocomplete="off">
							</div>

							<div class="decorza-form-row decorza-form-row-2">
								<div class="decorza-form-group">
									<label for="contact_name" class="decorza-form-label"><?php esc_html_e( 'Your Name', 'decorza' ); ?> <span class="required">*</span></label>
									<input type="text" id="contact_name" name="contact_name" class="decorza-form-input" placeholder="<?php esc_attr_e( 'e.g. Jane Doe', 'decorza' ); ?>" required>
								</div>
								<div class="decorza-form-group">
									<label for="contact_email" class="decorza-form-label"><?php esc_html_e( 'Your Email', 'decorza' ); ?> <span class="required">*</span></label>
									<input type="email" id="contact_email" name="contact_email" class="decorza-form-input" placeholder="<?php esc_attr_e( 'jane@example.com', 'decorza' ); ?>" required>
								</div>
							</div>

							<div class="decorza-form-group">
								<label for="contact_subject" class="decorza-form-label"><?php esc_html_e( 'Subject / Topic', 'decorza' ); ?></label>
								<select id="contact_subject" name="contact_subject" class="decorza-form-select">
									<option value="<?php esc_attr_e( 'Interior Design Advice', 'decorza' ); ?>"><?php esc_html_e( 'Interior Design Advice & Styling', 'decorza' ); ?></option>
									<option value="<?php esc_attr_e( 'Editorial & Guest Post', 'decorza' ); ?>"><?php esc_html_e( 'Editorial & Guest Article Pitch', 'decorza' ); ?></option>
									<option value="<?php esc_attr_e( 'Brand Sponsorship', 'decorza' ); ?>"><?php esc_html_e( 'Brand Partnership / Product Review', 'decorza' ); ?></option>
									<option value="<?php esc_attr_e( 'General Inquiry', 'decorza' ); ?>"><?php esc_html_e( 'General Inquiry / Hello', 'decorza' ); ?></option>
								</select>
							</div>

							<div class="decorza-form-group">
								<label for="contact_message" class="decorza-form-label"><?php esc_html_e( 'Your Message', 'decorza' ); ?> <span class="required">*</span></label>
								<textarea id="contact_message" name="contact_message" rows="5" class="decorza-form-textarea" placeholder="<?php esc_attr_e( 'Tell us about your space, question, or proposal...', 'decorza' ); ?>" required></textarea>
							</div>

							<div class="decorza-form-submit-wrap">
								<button type="submit" name="decorza_contact_submit" class="decorza-btn decorza-btn-primary decorza-contact-submit-btn">
									<span><?php esc_html_e( 'Send Message', 'decorza' ); ?></span>
									<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
								</button>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
