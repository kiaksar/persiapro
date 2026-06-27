<?php
/**
 * PersiaPro Theme Functions
 *
 * @package PersiaPro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PERSIAPRO_VERSION', '1.3.2' );
define( 'PERSIAPRO_DIR', get_template_directory() );
define( 'PERSIAPRO_URI', get_template_directory_uri() );

/**
 * Load theme includes.
 */
require PERSIAPRO_DIR . '/inc/setup.php';
require PERSIAPRO_DIR . '/inc/defaults.php';
require PERSIAPRO_DIR . '/inc/post-types.php';
require PERSIAPRO_DIR . '/inc/enqueue.php';
require PERSIAPRO_DIR . '/inc/template-tags.php';
require PERSIAPRO_DIR . '/inc/fallback-menu.php';
require PERSIAPRO_DIR . '/inc/customizer.php';
require PERSIAPRO_DIR . '/inc/customizer-homepage.php';
require PERSIAPRO_DIR . '/inc/theme-update.php';
require PERSIAPRO_DIR . '/inc/admin.php';
require PERSIAPRO_DIR . '/inc/woocommerce.php';
