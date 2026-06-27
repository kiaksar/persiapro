<?php
/**
 * Theme default strings (Farsi-first).
 *
 * @package PersiaPro
 * @since 1.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get all theme default strings.
 *
 * @return array
 */
function persiapro_get_defaults() {
	return array(
		'persiapro_materials_title'           => 'مواد و محصولات ما',
		'persiapro_materials_subtitle'        => 'مجموعه‌ای از مواد و محصولات صنعتی ما را مشاهده کنید',
		'persiapro_materials_btn_text'        => 'مشاهده جزئیات',
		'persiapro_materials_archive_text'    => 'مشاهده همه مواد',
		'persiapro_blog_slider_title'         => 'آخرین اخبار و مقالات',
		'persiapro_blog_slider_subtitle'      => 'از تازه‌ترین مطالب و اخبار ما باخبر شوید',
		'persiapro_blog_slider_archive_text'  => 'مشاهده همه مطالب',
		'persiapro_read_more_text'            => 'ادامه مطلب',
		'persiapro_footer_contact_title'      => 'تماس با ما',
		'persiapro_footer_links_title'        => 'لینک‌های مفید',
		'persiapro_footer_address'            => 'تهران، خیابان ولیعصر، پلاک ۱۲۳',
		'persiapro_footer_phone'              => '+98 21 1234 5678',
		'persiapro_topbar_phone'              => '+98 21 1234 5678',
		'persiapro_footer_email'              => 'info@example.com',
		'persiapro_topbar_email'              => 'info@example.com',
	);
}

/**
 * Get a theme mod with language support via Polylang.
 *
 * @param string $key     Setting key.
 * @param mixed  $default Optional override default.
 * @return mixed
 */
function persiapro_get_theme_mod( $key, $default = null ) {
	$defaults = persiapro_get_defaults();

	if ( null === $default ) {
		$default = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	}

	$value = get_theme_mod( $key, $default );

	// If Polylang is active, try to get translated string
	if ( function_exists( 'pll__' ) ) {
		return pll__( $value );
	}

	return $value;
}

/**
 * Register theme strings for Polylang translation.
 */
function persiapro_register_polylang_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	// Register all translatable strings with current values
	pll_register_string( 'persiapro', 'Materials Title', get_theme_mod( 'persiapro_materials_title', 'مواد و محصولات ما' ), 'PersiaPro Theme', true );
	pll_register_string( 'persiapro', 'Materials Subtitle', get_theme_mod( 'persiapro_materials_subtitle', 'مجموعه‌ای از مواد و محصولات صنعتی ما را مشاهده کنید' ), 'PersiaPro Theme', true );
	pll_register_string( 'persiapro', 'Materials Button Text', get_theme_mod( 'persiapro_materials_btn_text', 'مشاهده جزئیات' ), 'PersiaPro Theme', true );
	pll_register_string( 'persiapro', 'Materials Archive Text', get_theme_mod( 'persiapro_materials_archive_text', 'مشاهده همه مواد' ), 'PersiaPro Theme', true );
	pll_register_string( 'persiapro', 'Blog Slider Title', get_theme_mod( 'persiapro_blog_slider_title', 'آخرین اخبار و مقالات' ), 'PersiaPro Theme', true );
	pll_register_string( 'persiapro', 'Blog Slider Subtitle', get_theme_mod( 'persiapro_blog_slider_subtitle', 'از تازه‌ترین مطالب و اخبار ما باخبر شوید' ), 'PersiaPro Theme', true );
	pll_register_string( 'persiapro', 'Blog Archive Text', get_theme_mod( 'persiapro_blog_slider_archive_text', 'مشاهده همه مطالب' ), 'PersiaPro Theme', true );
	pll_register_string( 'persiapro', 'Read More Text', get_theme_mod( 'persiapro_read_more_text', 'ادامه مطلب' ), 'PersiaPro Theme', true );
	pll_register_string( 'persiapro', 'Footer Contact Title', get_theme_mod( 'persiapro_footer_contact_title', 'تماس با ما' ), 'PersiaPro Theme', true );
	pll_register_string( 'persiapro', 'Footer Links Title', get_theme_mod( 'persiapro_footer_links_title', 'لینک‌های مفید' ), 'PersiaPro Theme', true );
	pll_register_string( 'persiapro', 'Footer Address', get_theme_mod( 'persiapro_footer_address', 'تهران، خیابان ولیعصر، پلاک ۱۲۳' ), 'PersiaPro Theme', true );
}
add_action( 'init', 'persiapro_register_polylang_strings' );
