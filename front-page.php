<?php
/**
 * The template for displaying the front page of DecorZa
 *
 * 7 Complete Sections with Selective Refresh & Edit Shortcut support:
 * 1. Hero Banner (CSS Parallax + Gradient Overlay + Dual Button Control)
 * 2. Featured Categories (4-col Grid with Count & Zoom)
 * 3. Latest Articles (3-col Cards with Read Time & Lift + View All Button Control)
 * 4. About Section (2-col Split + Image + Stats & Dual Button Control)
 * 5. Most Popular Posts (Horizontal Cards)
 * 6. Meet Our Writers (Author Profile Cards)
 * 7. Newsletter Signup (Lead Magnet Form + Button Control)
 *
 * @package DecorZa
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<!-- =========================================================================
     SECTION 1: HERO BANNER
     ========================================================================= -->
<?php if ( get_theme_mod( 'decorza_enable_hero', true ) ) : ?>
	<?php
	$hero_img = get_theme_mod( 'decorza_hero_image', '' );
	$hero_bg_style = ! empty( $hero_img ) ? ' style="background-image: url(' . esc_url( $hero_img ) . ');"' : ' style="background: linear-gradient(135deg, #1A252F 0%, #2C3E50 100%);"';
	?>
	<section class="decorza-hero"<?php echo $hero_bg_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="decorza-hero-overlay" aria-hidden="true"></div>
		<div class="decorza-container decorza-hero-content">
			<span class="decorza-hero-tagline"><?php echo esc_html( get_theme_mod( 'decorza_hero_tagline', __( 'HOME DECOR INSPIRATION & GUIDES', 'decorza' ) ) ); ?></span>
			<h1 class="decorza-hero-title"><?php echo esc_html( get_theme_mod( 'decorza_hero_heading', __( 'Transform Your Space with Elegant Decor Ideas', 'decorza' ) ) ); ?></h1>
			<p class="decorza-hero-subtitle"><?php echo esc_html( get_theme_mod( 'decorza_hero_subheading', __( 'Explore modern aesthetics, cozy Scandinavian layouts, architectural lighting, and DIY tips crafted to bring timeless elegance into every room.', 'decorza' ) ) ); ?></p>
			<div class="decorza-hero-cta">
				<?php echo decorza_customize_partial_hero_btn(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- =========================================================================
     SECTION 2: FEATURED CATEGORIES
     ========================================================================= -->
<?php if ( get_theme_mod( 'decorza_enable_categories_sec', true ) ) : ?>
	<section class="decorza-section decorza-categories-section">
		<div class="decorza-container">
			<div class="decorza-section-header">
				<h2 class="decorza-section-title"><?php echo esc_html( get_theme_mod( 'decorza_categories_title', __( 'Explore Categories', 'decorza' ) ) ); ?></h2>
				<p class="decorza-section-subtitle"><?php esc_html_e( 'Handpicked interior design topics to elevate each corner of your sanctuary.', 'decorza' ); ?></p>
			</div>

			<div class="decorza-grid decorza-grid-4">
				<?php
				$categories = get_categories( array(
					'orderby'    => 'count',
					'order'      => 'DESC',
					'number'     => 4,
					'hide_empty' => false,
				) );

				// Predefined decorative background hues for categories if no custom thumbnail
				$cat_gradients = array(
					'linear-gradient(135deg, #2C3E50 0%, #34495E 100%)',
					'linear-gradient(135deg, #785A46 0%, #A07855 100%)',
					'linear-gradient(135deg, #4A5568 0%, #2D3748 100%)',
					'linear-gradient(135deg, #8C6D53 0%, #6E543C 100%)',
				);

				$idx = 0;
				if ( ! empty( $categories ) ) :
					foreach ( $categories as $cat ) :
						$cat_link    = get_category_link( $cat->term_id );
						$cat_img_url = decorza_get_category_image_url( $cat->term_id, 'decorza-card' );
						$grad_bg     = $cat_gradients[ $idx % 4 ];
						$idx++;
						?>
						<a href="<?php echo esc_url( $cat_link ); ?>" class="decorza-category-card<?php echo ! empty( $cat_img_url ) ? ' has-cat-image' : ''; ?>" style="background: <?php echo esc_attr( $grad_bg ); ?>;">
							<?php if ( ! empty( $cat_img_url ) ) : ?>
								<img src="<?php echo esc_url( $cat_img_url ); ?>" alt="<?php echo esc_attr( $cat->name ); ?>" loading="lazy" />
							<?php endif; ?>
							<div class="decorza-category-overlay"></div>
							<div class="decorza-category-content">
								<h3 class="decorza-category-title"><?php echo esc_html( $cat->name ); ?></h3>
								<span class="decorza-category-count">
									<?php /* translators: %s: number of posts */ printf( esc_html( _n( '%s Article', '%s Articles', $cat->count, 'decorza' ) ), esc_html( number_format_i18n( $cat->count ) ) ); ?>
								</span>
							</div>
						</a>
						<?php
					endforeach;
				else :
					// Fallback decor demo cards
					$demo_cats = array(
						array( 'name' => __( 'Living Room', 'decorza' ), 'count' => 24 ),
						array( 'name' => __( 'Modern Kitchen', 'decorza' ), 'count' => 18 ),
						array( 'name' => __( 'Cozy Bedroom', 'decorza' ), 'count' => 31 ),
						array( 'name' => __( 'DIY & Decor Crafts', 'decorza' ), 'count' => 15 ),
					);
					foreach ( $demo_cats as $demo ) :
						$grad_bg = $cat_gradients[ $idx % 4 ];
						$idx++;
						?>
						<div class="decorza-category-card" style="background: <?php echo esc_attr( $grad_bg ); ?>;">
							<div class="decorza-category-overlay"></div>
							<div class="decorza-category-content">
								<h3 class="decorza-category-title"><?php echo esc_html( $demo['name'] ); ?></h3>
								<span class="decorza-category-count"><?php echo esc_html( $demo['count'] . ' Articles' ); ?></span>
							</div>
						</div>
						<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- =========================================================================
     SECTION 3: LATEST ARTICLES (GRID)
     ========================================================================= -->
<?php if ( get_theme_mod( 'decorza_enable_latest_posts_sec', true ) ) : ?>
	<section id="decorza-articles" class="decorza-section decorza-section-alt decorza-latest-section">
		<div class="decorza-container">
			<div class="decorza-section-header">
				<h2 class="decorza-section-title"><?php echo esc_html( get_theme_mod( 'decorza_latest_title', __( 'Latest Articles', 'decorza' ) ) ); ?></h2>
				<p class="decorza-section-subtitle"><?php esc_html_e( 'Fresh perspectives on architectural minimalism, color palettes, and functional aesthetics.', 'decorza' ); ?></p>
			</div>

			<?php
			$posts_count = get_theme_mod( 'decorza_latest_posts_count', 6 );
			$latest_query = new WP_Query( array(
				'posts_per_page'      => $posts_count,
				'ignore_sticky_posts' => 1,
			) );

			if ( $latest_query->have_posts() ) :
				?>
				<div class="decorza-grid decorza-grid-3">
					<?php
					while ( $latest_query->have_posts() ) :
						$latest_query->the_post();
						get_template_part( 'template-parts/content', 'card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>

				<div class="decorza-latest-btn-wrap" style="text-align: center; margin-top: 3.5rem;">
					<?php echo decorza_customize_partial_latest_btn(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<?php
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
			?>
		</div>
	</section>
<?php endif; ?>

<!-- =========================================================================
     SECTION 4: ABOUT HOME DECOR ZA
     ========================================================================= -->
<?php if ( get_theme_mod( 'decorza_enable_about', true ) ) : ?>
	<section id="about" class="decorza-section decorza-about-section">
		<div class="decorza-container">
			<div class="decorza-about-grid">
				<!-- Image Left -->
				<div class="decorza-about-image">
					<?php echo decorza_customize_partial_about_image(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>

				<!-- Content Right -->
				<div class="decorza-about-content">
					<span class="decorza-badge" style="margin-bottom: 1rem;"><?php esc_html_e( 'OUR STORY & PURPOSE', 'decorza' ); ?></span>
					<h2 class="decorza-about-heading" style="font-size: clamp(2rem, 3.5vw, 2.75rem); margin-bottom: 1.25rem;">
						<?php echo esc_html( get_theme_mod( 'decorza_about_heading', __( 'About HomeDecorZa', 'decorza' ) ) ); ?>
					</h2>
					<div class="decorza-about-description" style="font-size: 1.05rem; line-height: 1.7; color: var(--color-text-muted); margin-bottom: 1.5rem;">
						<?php echo wp_kses_post( wpautop( get_theme_mod( 'decorza_about_description', __( 'HomeDecorZa is a dedicated digital sanctuary for interior architecture, home staging, and thoughtful design. We empower homeowners and interior enthusiasts to build living spaces that reflect grace, warmth, and authentic personality.', 'decorza' ) ) ) ); ?>
					</div>

					<!-- 3 Highlights / Stats -->
					<div class="decorza-about-highlights">
						<div class="decorza-stat-item decorza-stat-item-1">
							<?php echo decorza_customize_partial_stat1(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div class="decorza-stat-item decorza-stat-item-2">
							<?php echo decorza_customize_partial_stat2(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div class="decorza-stat-item decorza-stat-item-3">
							<?php echo decorza_customize_partial_stat3(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</div>

					<div class="decorza-about-btn-wrap" style="margin-top: 2rem;">
						<?php echo decorza_customize_partial_about_btn(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- =========================================================================
     SECTION 5: MOST POPULAR POSTS (HORIZONTAL LAYOUT)
     ========================================================================= -->
<?php if ( get_theme_mod( 'decorza_enable_popular_sec', true ) ) : ?>
	<section id="popular" class="decorza-section decorza-section-alt decorza-popular-section">
		<div class="decorza-container">
			<div class="decorza-section-header">
				<h2 class="decorza-section-title"><?php echo esc_html( get_theme_mod( 'decorza_popular_title', __( 'Most Popular', 'decorza' ) ) ); ?></h2>
				<p class="decorza-section-subtitle"><?php esc_html_e( 'Our most celebrated styling formulas, reader favorites, and viral room reveals.', 'decorza' ); ?></p>
			</div>

			<?php
			// Query posts by comment count, with fallback to recent posts
			$popular_query = new WP_Query( array(
				'posts_per_page'      => 3,
				'orderby'             => 'comment_count',
				'order'               => 'DESC',
				'ignore_sticky_posts' => 1,
			) );

			if ( ! $popular_query->have_posts() ) {
				$popular_query = new WP_Query( array(
					'posts_per_page'      => 3,
					'ignore_sticky_posts' => 1,
				) );
			}

			if ( $popular_query->have_posts() ) :
				?>
				<div class="decorza-grid" style="gap: 1.75rem;">
					<?php
					while ( $popular_query->have_posts() ) :
						$popular_query->the_post();
						get_template_part( 'template-parts/content', 'horizontal' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>

<!-- =========================================================================
     SECTION 6: AUTHOR / TEAM SECTION
     ========================================================================= -->
<?php if ( get_theme_mod( 'decorza_enable_authors_sec', true ) ) : ?>
	<section class="decorza-section decorza-authors-section">
		<div class="decorza-container">
			<div class="decorza-section-header">
				<h2 class="decorza-section-title"><?php echo esc_html( get_theme_mod( 'decorza_authors_title', __( 'Meet Our Writers', 'decorza' ) ) ); ?></h2>
				<p class="decorza-section-subtitle"><?php esc_html_e( 'The interior stylists, architects, and colorists behind our design journals.', 'decorza' ); ?></p>
			</div>

			<div class="decorza-grid decorza-grid-3">
				<?php
				$authors = get_users( array(
					'who'     => 'authors',
					'number'  => 3,
					'orderby' => 'post_count',
					'order'   => 'DESC',
				) );

				if ( ! empty( $authors ) ) :
					foreach ( $authors as $user ) :
						$user_posts = count_user_posts( $user->ID );
						$user_bio   = get_the_author_meta( 'description', $user->ID );
						if ( empty( $user_bio ) ) {
							$user_bio = __( 'Specializing in Scandinavian simplicity, organic materials, and intentional home styling.', 'decorza' );
						}
						?>
						<div class="decorza-author-card">
							<div class="decorza-author-avatar">
								<?php echo get_avatar( $user->ID, 100, '', $user->display_name ); ?>
							</div>
							<h3 class="decorza-author-name">
								<a href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>"><?php echo esc_html( $user->display_name ); ?></a>
							</h3>
							<div class="decorza-author-count">
								<?php /* translators: %d: post count */ printf( esc_html( _n( '%d Article Published', '%d Articles Published', $user_posts, 'decorza' ) ), absint( $user_posts ) ); ?>
							</div>
							<p class="decorza-author-bio"><?php echo esc_html( wp_trim_words( $user_bio, 18 ) ); ?></p>
							<div class="decorza-author-socials">
								<a href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>" aria-label="<?php esc_attr_e( 'Author profile', 'decorza' ); ?>" title="<?php esc_attr_e( 'View Author Articles', 'decorza' ); ?>">
									<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
								</a>
							</div>
						</div>
						<?php
					endforeach;
				else :
					// Demo author cards
					$demo_authors = array(
						array( 'name' => 'Sophia Laurent', 'role' => __( 'Lead Stylist', 'decorza' ), 'bio' => __( 'Advocate for natural materials, linen textures, and soft architectural shadows.', 'decorza' ) ),
						array( 'name' => 'Julian Vance', 'role' => __( 'Architectural Editor', 'decorza' ), 'bio' => __( 'Covering mid-century design, sustainable spaces, and spatial flow optimization.', 'decorza' ) ),
						array( 'name' => 'Elena Rossi', 'role' => __( 'DIY & Colorist', 'decorza' ), 'bio' => __( 'Bringing vibrant Mediterranean palettes and clever budget transformations to life.', 'decorza' ) ),
					);
					foreach ( $demo_authors as $d_author ) :
						?>
						<div class="decorza-author-card">
							<div class="decorza-author-avatar">
								<div style="width: 100%; height: 100%; background: var(--color-accent); display: flex; align-items: center; justify-content: center; color: var(--color-primary); font-weight: 700; font-size: 1.5rem;">
									<?php echo esc_html( substr( $d_author['name'], 0, 1 ) ); ?>
								</div>
							</div>
							<h3 class="decorza-author-name"><?php echo esc_html( $d_author['name'] ); ?></h3>
							<div class="decorza-author-count"><?php echo esc_html( $d_author['role'] ); ?></div>
							<p class="decorza-author-bio"><?php echo esc_html( $d_author['bio'] ); ?></p>
						</div>
						<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- =========================================================================
     SECTION 7: NEWSLETTER SIGNUP
     ========================================================================= -->
<?php if ( get_theme_mod( 'decorza_enable_newsletter_sec', true ) ) : ?>
	<?php
	$nl_bg = get_theme_mod( 'decorza_newsletter_bg', '#ECF0F1' );
	?>
	<section class="decorza-newsletter-section" style="background-color: <?php echo esc_attr( $nl_bg ); ?>;">
		<div class="decorza-container">
			<div class="decorza-newsletter-inner">
				<span class="decorza-badge" style="margin-bottom: 0.75rem;"><?php esc_html_e( 'WEEKLY INSPIRATION', 'decorza' ); ?></span>
				<h2 class="decorza-newsletter-title" style="font-size: clamp(2rem, 3.5vw, 2.75rem); margin-bottom: 1rem;">
					<?php echo esc_html( get_theme_mod( 'decorza_newsletter_title', __( 'Stay Inspired', 'decorza' ) ) ); ?>
				</h2>
				<p class="decorza-newsletter-subtext" style="color: var(--color-text-muted); font-size: 1.05rem;">
					<?php echo esc_html( get_theme_mod( 'decorza_newsletter_subtext', __( 'Subscribe to get the latest decor trends, styling formulas, and DIY projects delivered straight to your inbox.', 'decorza' ) ) ); ?>
				</p>

				<?php
				$nl_shortcode = get_theme_mod( 'decorza_newsletter_shortcode', '' );
				if ( ! empty( $nl_shortcode ) ) :
					echo do_shortcode( $nl_shortcode );
				else :
					?>
					<form class="decorza-newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing to DecorZa!');">
						<input type="email" class="decorza-newsletter-input" placeholder="<?php esc_attr_e( 'Enter your email address...', 'decorza' ); ?>" required>
						<div class="decorza-newsletter-btn-wrap" style="display: inline-block;">
							<?php echo decorza_customize_partial_newsletter_btn(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</form>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
get_footer();
