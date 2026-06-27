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
 * Get a theme mod with Farsi default fallback.
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

	return get_theme_mod( $key, $default );
}
