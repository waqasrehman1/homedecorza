<?php
/**
 * DecorZa Theme Custom Widgets
 *
 * 5 Custom, production-ready widgets tailored for the Home Decor niche:
 * 1. DecorZa_About_Widget
 * 2. DecorZa_Popular_Posts_Widget
 * 3. DecorZa_Categories_Widget
 * 4. DecorZa_Author_Widget
 * 5. DecorZa_Newsletter_Widget
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =============================================================================
// 1. DECORZA: ABOUT WIDGET
// =============================================================================
class DecorZa_About_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'decorza_about_widget',
			__( 'DecorZa: About Widget', 'decorza' ),
			array( 'description' => __( 'Display brand introduction, image, and social media links.', 'decorza' ) )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$title       = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$image_url   = ! empty( $instance['image_url'] ) ? $instance['image_url'] : '';
		$description = ! empty( $instance['description'] ) ? $instance['description'] : '';

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( ! empty( $image_url ) ) {
			echo '<div style="margin-bottom: 1rem;"><img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $title ) . '" style="border-radius: var(--radius-md); width: 100%; height: auto;" loading="lazy"></div>';
		}

		if ( ! empty( $description ) ) {
			echo '<p style="color: var(--color-text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.25rem;">' . esc_html( $description ) . '</p>';
		}

		// Social icons from theme settings
		$facebook  = get_theme_mod( 'decorza_social_facebook', '#' );
		$instagram = get_theme_mod( 'decorza_social_instagram', '#' );
		$pinterest = get_theme_mod( 'decorza_social_pinterest', '#' );
		$twitter   = get_theme_mod( 'decorza_social_twitter', '#' );

		echo '<div class="decorza-footer-socials" style="margin-top: 0.5rem;">';
		if ( ! empty( $pinterest ) ) {
			echo '<a href="' . esc_url( $pinterest ) . '" target="_blank" rel="noopener noreferrer" aria-label="Pinterest" style="background-color: var(--color-accent); color: var(--color-primary);"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345-.09.375-.291 1.199-.334 1.373-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg></a>';
		}
		if ( ! empty( $instagram ) ) {
			echo '<a href="' . esc_url( $instagram ) . '" target="_blank" rel="noopener noreferrer" aria-label="Instagram" style="background-color: var(--color-accent); color: var(--color-primary);"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>';
		}
		if ( ! empty( $facebook ) ) {
			echo '<a href="' . esc_url( $facebook ) . '" target="_blank" rel="noopener noreferrer" aria-label="Facebook" style="background-color: var(--color-accent); color: var(--color-primary);"><svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg></a>';
		}
		echo '</div>';

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title       = ! empty( $instance['title'] ) ? $instance['title'] : __( 'About DecorZa', 'decorza' );
		$image_url   = ! empty( $instance['image_url'] ) ? $instance['image_url'] : '';
		$description = ! empty( $instance['description'] ) ? $instance['description'] : __( 'Curating warm, intentional, and timeless living spaces for modern homes.', 'decorza' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'decorza' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"><?php esc_html_e( 'Image URL:', 'decorza' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>" type="text" value="<?php echo esc_attr( $image_url ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description:', 'decorza' ); ?></label>
			<textarea class="widefat" rows="4" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_textarea( $description ); ?></textarea>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance                = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['image_url']   = ( ! empty( $new_instance['image_url'] ) ) ? esc_url_raw( $new_instance['image_url'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? sanitize_textarea_field( $new_instance['description'] ) : '';
		return $instance;
	}
}

// =============================================================================
// 2. DECORZA: POPULAR POSTS WIDGET
// =============================================================================
class DecorZa_Popular_Posts_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'decorza_popular_posts_widget',
			__( 'DecorZa: Popular Posts', 'decorza' ),
			array( 'description' => __( 'Display most commented or popular home decor posts with thumbnails.', 'decorza' ) )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Popular Articles', 'decorza' );
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 4;

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		$query = new WP_Query( array(
			'posts_per_page'      => $count,
			'orderby'             => 'comment_count',
			'order'               => 'DESC',
			'ignore_sticky_posts' => 1,
		) );

		if ( $query->have_posts() ) {
			echo '<div class="decorza-widget-posts-list">';
			while ( $query->have_posts() ) {
				$query->the_post();
				?>
				<div class="decorza-widget-post-item">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="decorza-widget-post-thumb" aria-hidden="true" tabindex="-1">
							<?php the_post_thumbnail( 'thumbnail', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
						</a>
					<?php else : ?>
						<a href="<?php the_permalink(); ?>" class="decorza-widget-post-thumb decorza-widget-post-thumb-fallback" aria-hidden="true" tabindex="-1">
							<svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
						</a>
					<?php endif; ?>
					<div class="decorza-widget-post-info">
						<h4 class="decorza-widget-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<span class="decorza-widget-post-date"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
					</div>
				</div>
				<?php
			}
			echo '</div>';
			wp_reset_postdata();
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Popular Articles', 'decorza' );
		$count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 4;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'decorza' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of Posts:', 'decorza' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" max="10" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : 4;
		return $instance;
	}
}

// =============================================================================
// 3. DECORZA: CATEGORIES WITH ICONS WIDGET
// =============================================================================
class DecorZa_Categories_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'decorza_categories_widget',
			__( 'DecorZa: Categories with Icons', 'decorza' ),
			array( 'description' => __( 'Display elegant categories list with post count badges.', 'decorza' ) )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Decor Categories', 'decorza' );

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		$categories = get_categories( array(
			'orderby'    => 'count',
			'order'      => 'DESC',
			'hide_empty' => true,
		) );

		if ( ! empty( $categories ) ) {
			echo '<ul class="decorza-widget-category-list">';
			foreach ( $categories as $cat ) {
				echo '<li>';
				echo '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">';
				echo '<span style="display: inline-flex; align-items: center; gap: 0.5rem;"><svg width="14" height="14" fill="var(--color-secondary)" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg> ' . esc_html( $cat->name ) . '</span>';
				echo '</a>';
				echo '<span class="decorza-category-badge-count">' . esc_html( $cat->count ) . '</span>';
				echo '</li>';
			}
			echo '</ul>';
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Decor Categories', 'decorza' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'decorza' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		return $instance;
	}
}

// =============================================================================
// 4. DECORZA: AUTHOR CARD WIDGET
// =============================================================================
class DecorZa_Author_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'decorza_author_widget',
			__( 'DecorZa: Author Card', 'decorza' ),
			array( 'description' => __( 'Display a stylish author/editor profile card in the sidebar.', 'decorza' ) )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$name   = ! empty( $instance['name'] ) ? $instance['name'] : 'Sophia Laurent';
		$role   = ! empty( $instance['role'] ) ? $instance['role'] : __( 'Principal Interior Stylist', 'decorza' );
		$bio    = ! empty( $instance['bio'] ) ? $instance['bio'] : __( 'Obsessed with natural light, warm Scandinavian palettes, and sustainable artisan furnishings.', 'decorza' );
		$avatar = ! empty( $instance['avatar'] ) ? $instance['avatar'] : '';

		echo '<div style="text-align: center;">';
		if ( ! empty( $avatar ) ) {
			echo '<div style="width: 88px; height: 88px; border-radius: 50%; margin: 0 auto 1rem; overflow: hidden; border: 3px solid var(--color-secondary);"><img src="' . esc_url( $avatar ) . '" alt="' . esc_attr( $name ) . '" style="width: 100%; height: 100%; object-fit: cover;"></div>';
		}
		echo '<h3 style="font-size: 1.25rem; margin-bottom: 0.2rem;">' . esc_html( $name ) . '</h3>';
		echo '<p style="font-size: 0.8rem; text-transform: uppercase; color: var(--color-secondary); font-weight: 700; margin-bottom: 0.75rem;">' . esc_html( $role ) . '</p>';
		echo '<p style="font-size: 0.9rem; color: var(--color-text-muted); line-height: 1.55; margin-bottom: 1rem;">' . esc_html( $bio ) . '</p>';
		echo '</div>';

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$name   = ! empty( $instance['name'] ) ? $instance['name'] : 'Sophia Laurent';
		$role   = ! empty( $instance['role'] ) ? $instance['role'] : __( 'Principal Interior Stylist', 'decorza' );
		$bio    = ! empty( $instance['bio'] ) ? $instance['bio'] : __( 'Obsessed with natural light, warm Scandinavian palettes, and sustainable artisan furnishings.', 'decorza' );
		$avatar = ! empty( $instance['avatar'] ) ? $instance['avatar'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php esc_html_e( 'Name:', 'decorza' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'role' ) ); ?>"><?php esc_html_e( 'Role / Title:', 'decorza' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'role' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'role' ) ); ?>" type="text" value="<?php echo esc_attr( $role ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>"><?php esc_html_e( 'Avatar Image URL:', 'decorza' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'avatar' ) ); ?>" type="text" value="<?php echo esc_attr( $avatar ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'bio' ) ); ?>"><?php esc_html_e( 'Short Bio:', 'decorza' ); ?></label>
			<textarea class="widefat" rows="3" id="<?php echo esc_attr( $this->get_field_id( 'bio' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bio' ) ); ?>"><?php echo esc_textarea( $bio ); ?></textarea>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance           = array();
		$instance['name']   = ( ! empty( $new_instance['name'] ) ) ? sanitize_text_field( $new_instance['name'] ) : '';
		$instance['role']   = ( ! empty( $new_instance['role'] ) ) ? sanitize_text_field( $new_instance['role'] ) : '';
		$instance['avatar'] = ( ! empty( $new_instance['avatar'] ) ) ? esc_url_raw( $new_instance['avatar'] ) : '';
		$instance['bio']    = ( ! empty( $new_instance['bio'] ) ) ? sanitize_textarea_field( $new_instance['bio'] ) : '';
		return $instance;
	}
}

// =============================================================================
// 5. DECORZA: NEWSLETTER WIDGET
// =============================================================================
class DecorZa_Newsletter_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'decorza_newsletter_widget',
			__( 'DecorZa: Newsletter', 'decorza' ),
			array( 'description' => __( 'Display email signup form in sidebar or footer.', 'decorza' ) )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$title   = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Stay In The Know', 'decorza' );
		$subtext = ! empty( $instance['subtext'] ) ? $instance['subtext'] : __( 'Get weekly decor tips, seasonal palettes, and exclusive guides.', 'decorza' );

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( ! empty( $subtext ) ) {
			echo '<p style="font-size: 0.95rem; color: var(--color-text-muted); margin-bottom: 1.25rem;">' . esc_html( $subtext ) . '</p>';
		}

		$shortcode = get_theme_mod( 'decorza_newsletter_shortcode', '' );
		if ( ! empty( $shortcode ) ) {
			echo do_shortcode( $shortcode );
		} else {
			?>
			<form class="decorza-widget-newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing to DecorZa!');" style="display: flex; flex-direction: column; gap: 0.75rem;">
				<input type="email" placeholder="<?php esc_attr_e( 'Your email address...', 'decorza' ); ?>" required style="padding: 0.75rem 1rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); background: var(--color-bg); color: var(--color-text); width: 100%;">
				<button type="submit" class="decorza-btn decorza-btn-primary" style="width: 100%; border-radius: var(--radius-sm); padding: 0.75rem;"><?php esc_html_e( 'Subscribe Free', 'decorza' ); ?></button>
			</form>
			<?php
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title   = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Stay In The Know', 'decorza' );
		$subtext = ! empty( $instance['subtext'] ) ? $instance['subtext'] : __( 'Get weekly decor tips, seasonal palettes, and exclusive guides.', 'decorza' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'decorza' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'subtext' ) ); ?>"><?php esc_html_e( 'Subtext:', 'decorza' ); ?></label>
			<textarea class="widefat" rows="3" id="<?php echo esc_attr( $this->get_field_id( 'subtext' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtext' ) ); ?>"><?php echo esc_textarea( $subtext ); ?></textarea>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance            = array();
		$instance['title']   = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['subtext'] = ( ! empty( $new_instance['subtext'] ) ) ? sanitize_textarea_field( $new_instance['subtext'] ) : '';
		return $instance;
	}
}

/**
 * Register all DecorZa Widgets
 */
function decorza_register_custom_widgets() {
	register_widget( 'DecorZa_About_Widget' );
	register_widget( 'DecorZa_Popular_Posts_Widget' );
	register_widget( 'DecorZa_Categories_Widget' );
	register_widget( 'DecorZa_Author_Widget' );
	register_widget( 'DecorZa_Newsletter_Widget' );
}
add_action( 'widgets_init', 'decorza_register_custom_widgets' );
