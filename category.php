<?php
/**
 * The template for displaying category archive pages
 *
 * Re-uses the unified, full-width Category/Archive Hero Banner template.
 *
 * @package DecorZa
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require wp_normalize_path( get_template_directory() ) . '/archive.php';
