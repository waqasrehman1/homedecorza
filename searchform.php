<?php
/**
 * The template for displaying search forms in DecorZa
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<form role="search" method="get" class="decorza-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="decorza-search-field"><?php esc_html_e( 'Search for:', 'decorza' ); ?></label>
	<input type="search" id="decorza-search-field" class="decorza-search-input" placeholder="<?php esc_attr_e( 'Search articles, room ideas...', 'decorza' ); ?>" value="<?php echo get_search_query(); ?>" name="s" required />
	<button type="submit" class="decorza-search-submit" aria-label="<?php esc_attr_e( 'Search', 'decorza' ); ?>">
		<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
	</button>
</form>
