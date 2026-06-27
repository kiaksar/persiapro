<?php
/**
 * Theme setup and configuration.
 *
 * @package PersiaPro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function persiapro_setup() {
	load_theme_textdomain( 'persiapro', PERSIAPRO_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 250,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff',
	) );

	add_image_size( 'persiapro-hero', 1920, 800, true );
	add_image_size( 'persiapro-card', 640, 400, true );
	add_image_size( 'persiapro-thumbnail', 400, 300, true );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'persiapro' ),
		'footer'  => esc_html__( 'Footer Menu', 'persiapro' ),
	) );
}
add_action( 'after_setup_theme', 'persiapro_setup' );

/**
 * Set content width.
 */
function persiapro_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'persiapro_content_width', 800 );
}
add_action( 'after_setup_theme', 'persiapro_content_width', 0 );

/**
 * Register widget areas.
 */
function persiapro_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'persiapro' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in the sidebar.', 'persiapro' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	$footer_columns = get_theme_mod( 'persiapro_footer_columns', 4 );

	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar( array(
			'name'          => sprintf(
				/* translators: %d: footer column number */
				esc_html__( 'Footer Column %d', 'persiapro' ),
				$i
			),
			'id'            => 'footer-' . $i,
			'description'   => sprintf(
				/* translators: %d: footer column number */
				esc_html__( 'Footer widget area column %d.', 'persiapro' ),
				$i
			),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
}
add_action( 'widgets_init', 'persiapro_widgets_init' );

/**
 * Add body classes based on customizer settings.
 *
 * @param array $classes Body classes.
 * @return array
 */
function persiapro_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( get_theme_mod( 'persiapro_layout_style', 'full' ) === 'boxed' ) {
		$classes[] = 'pp-boxed';
	}

	if ( get_theme_mod( 'persiapro_header_sticky', true ) ) {
		$classes[] = 'pp-has-sticky-header';
	}

	if ( get_theme_mod( 'persiapro_header_transparent', false ) && is_front_page() ) {
		$classes[] = 'pp-has-transparent-header';
	}

	$sidebar = get_theme_mod( 'persiapro_sidebar_position', 'left' );
	if ( is_active_sidebar( 'sidebar-1' ) && ! is_page_template( 'page-templates/template-full-width.php' ) && ! is_page_template( 'page-templates/template-landing.php' ) ) {
		$classes[] = 'pp-has-sidebar';
		$classes[] = 'pp-sidebar-' . sanitize_html_class( $sidebar );
	}

	if ( is_rtl() ) {
		$classes[] = 'pp-rtl';
	}

	if ( is_front_page() ) {
		$classes[] = 'pp-front-page';
	}

	return $classes;
}
add_filter( 'body_class', 'persiapro_body_classes' );

/**
 * Excerpt length filter.
 *
 * @param int $length Excerpt length.
 * @return int
 */
function persiapro_excerpt_length( $length ) {
	return absint( get_theme_mod( 'persiapro_excerpt_length', 30 ) );
}
add_filter( 'excerpt_length', 'persiapro_excerpt_length' );

/**
 * Excerpt more string.
 *
 * @param string $more More string.
 * @return string
 */
function persiapro_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'persiapro_excerpt_more' );

/**
 * Flush rewrite rules on theme activation for custom post types.
 */
function persiapro_activation() {
	persiapro_register_post_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'persiapro_activation' );
