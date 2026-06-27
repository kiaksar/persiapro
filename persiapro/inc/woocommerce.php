<?php
/**
 * WooCommerce compatibility.
 *
 * @package PersiaPro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Declare WooCommerce support.
 */
function persiapro_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'persiapro_woocommerce_setup' );

/**
 * WooCommerce sidebar.
 */
function persiapro_woocommerce_sidebar() {
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		get_sidebar();
	}
}

/**
 * Remove default WooCommerce wrappers.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'persiapro_woocommerce_wrapper_before', 10 );
add_action( 'woocommerce_after_main_content', 'persiapro_woocommerce_wrapper_after', 10 );

/**
 * WooCommerce wrapper start.
 */
function persiapro_woocommerce_wrapper_before() {
	echo '<div id="primary" class="pp-site-content"><div class="pp-container"><main id="main" class="pp-main">';
}

/**
 * WooCommerce wrapper end.
 */
function persiapro_woocommerce_wrapper_after() {
	echo '</main></div></div>';
}
