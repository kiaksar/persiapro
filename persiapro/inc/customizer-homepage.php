<?php
/**
 * Homepage & Materials customizer settings.
 *
 * @package PersiaPro
 * @since 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register homepage customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customizer_homepage( $wp_customize ) {
	$defaults = persiapro_get_defaults();

	$wp_customize->add_panel( 'persiapro_panel_homepage', array(
		'title'       => esc_html__( 'PersiaPro Homepage', 'persiapro' ),
		'description' => esc_html__( 'Materials section title, blog slider, and other homepage blocks.', 'persiapro' ),
		'priority'    => 41,
	) );

	/* Materials section — also available as top-level for easy discovery */
	$wp_customize->add_section( 'persiapro_homepage_materials', array(
		'title'       => esc_html__( 'Homepage — Materials Section', 'persiapro' ),
		'description' => esc_html__( 'Customize the materials/products block title, subtitle, and buttons shown on the front page.', 'persiapro' ),
		'panel'       => 'persiapro_panel_homepage',
		'priority'    => 1,
	) );

	$wp_customize->add_setting( 'persiapro_materials_enable', array(
		'default'           => true,
		'sanitize_callback' => 'persiapro_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'persiapro_materials_enable', array(
		'label'   => esc_html__( 'Show Materials Section', 'persiapro' ),
		'section' => 'persiapro_homepage_materials',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'persiapro_materials_title', array(
		'default'           => $defaults['persiapro_materials_title'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_materials_title', array(
		'label'       => esc_html__( 'Section Title', 'persiapro' ),
		'description' => esc_html__( 'Main heading above the materials grid (e.g. مواد و محصولات ما).', 'persiapro' ),
		'section'     => 'persiapro_homepage_materials',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'persiapro_materials_subtitle', array(
		'default'           => $defaults['persiapro_materials_subtitle'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_materials_subtitle', array(
		'label'   => esc_html__( 'Section Subtitle', 'persiapro' ),
		'section' => 'persiapro_homepage_materials',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'persiapro_materials_count', array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'persiapro_materials_count', array(
		'label'       => esc_html__( 'Number of Materials to Show', 'persiapro' ),
		'section'     => 'persiapro_homepage_materials',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 1, 'max' => 12 ),
	) );

	$wp_customize->add_setting( 'persiapro_materials_btn_text', array(
		'default'           => $defaults['persiapro_materials_btn_text'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_materials_btn_text', array(
		'label'       => esc_html__( 'Default Button Text', 'persiapro' ),
		'description' => esc_html__( 'Used when a material has no custom button text.', 'persiapro' ),
		'section'     => 'persiapro_homepage_materials',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'persiapro_materials_show_archive_link', array(
		'default'           => true,
		'sanitize_callback' => 'persiapro_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'persiapro_materials_show_archive_link', array(
		'label'   => esc_html__( 'Show "View All Materials" Link', 'persiapro' ),
		'section' => 'persiapro_homepage_materials',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'persiapro_materials_archive_text', array(
		'default'           => $defaults['persiapro_materials_archive_text'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_materials_archive_text', array(
		'label'   => esc_html__( 'Archive Link Text', 'persiapro' ),
		'section' => 'persiapro_homepage_materials',
		'type'    => 'text',
	) );

	/* Blog slider section */
	$wp_customize->add_section( 'persiapro_homepage_blog_slider', array(
		'title'       => esc_html__( 'Homepage — Blog Slider', 'persiapro' ),
		'description' => esc_html__( 'Latest posts slider on the front page.', 'persiapro' ),
		'panel'       => 'persiapro_panel_homepage',
		'priority'    => 2,
	) );

	$wp_customize->add_setting( 'persiapro_blog_slider_enable', array(
		'default'           => true,
		'sanitize_callback' => 'persiapro_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'persiapro_blog_slider_enable', array(
		'label'   => esc_html__( 'Show Blog Slider', 'persiapro' ),
		'section' => 'persiapro_homepage_blog_slider',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'persiapro_blog_slider_title', array(
		'default'           => $defaults['persiapro_blog_slider_title'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_blog_slider_title', array(
		'label'   => esc_html__( 'Section Title', 'persiapro' ),
		'section' => 'persiapro_homepage_blog_slider',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'persiapro_blog_slider_subtitle', array(
		'default'           => $defaults['persiapro_blog_slider_subtitle'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_blog_slider_subtitle', array(
		'label'   => esc_html__( 'Section Subtitle', 'persiapro' ),
		'section' => 'persiapro_homepage_blog_slider',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'persiapro_blog_slider_count', array(
		'default'           => 8,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'persiapro_blog_slider_count', array(
		'label'       => esc_html__( 'Number of Posts', 'persiapro' ),
		'section'     => 'persiapro_homepage_blog_slider',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 2, 'max' => 20 ),
	) );

	$wp_customize->add_setting( 'persiapro_blog_slider_desktop', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'persiapro_blog_slider_desktop', array(
		'label'       => esc_html__( 'Visible Posts on Desktop', 'persiapro' ),
		'description' => esc_html__( 'How many posts appear in one row on desktop. Extra posts slide horizontally.', 'persiapro' ),
		'section'     => 'persiapro_homepage_blog_slider',
		'type'        => 'select',
		'choices'     => array(
			2 => '2',
			3 => '3',
			4 => '4',
		),
	) );

	$wp_customize->add_setting( 'persiapro_blog_slider_show_blog_link', array(
		'default'           => true,
		'sanitize_callback' => 'persiapro_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'persiapro_blog_slider_show_blog_link', array(
		'label'   => esc_html__( 'Show "View All Posts" Link', 'persiapro' ),
		'section' => 'persiapro_homepage_blog_slider',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'persiapro_blog_slider_archive_text', array(
		'default'           => $defaults['persiapro_blog_slider_archive_text'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_blog_slider_archive_text', array(
		'label'   => esc_html__( 'Blog Link Text', 'persiapro' ),
		'section' => 'persiapro_homepage_blog_slider',
		'type'    => 'text',
	) );
}

/**
 * Extended footer contact customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customizer_footer_contact( $wp_customize ) {
	$defaults = persiapro_get_defaults();

	$wp_customize->add_section( 'persiapro_footer_contact', array(
		'title' => esc_html__( 'Company Contact Info', 'persiapro' ),
		'panel' => 'persiapro_panel_footer',
	) );

	$wp_customize->add_setting( 'persiapro_footer_about', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_footer_about', array(
		'label'   => esc_html__( 'Company Description', 'persiapro' ),
		'section' => 'persiapro_footer_contact',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'persiapro_footer_address', array(
		'default'           => $defaults['persiapro_footer_address'],
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_footer_address', array(
		'label'   => esc_html__( 'Company Address', 'persiapro' ),
		'section' => 'persiapro_footer_contact',
		'type'    => 'textarea',
	) );

	for ( $i = 1; $i <= 3; $i++ ) {
		$key = 1 === $i ? 'persiapro_footer_phone' : 'persiapro_footer_phone' . $i;
		$wp_customize->add_setting( $key, array(
			'default'           => 1 === $i ? $defaults['persiapro_footer_phone'] : '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => sprintf(
				/* translators: %d: phone number index */
				esc_html__( 'Phone Number %d', 'persiapro' ),
				$i
			),
			'section' => 'persiapro_footer_contact',
			'type'    => 'text',
		) );
	}

	for ( $i = 1; $i <= 3; $i++ ) {
		$key = 1 === $i ? 'persiapro_footer_email' : 'persiapro_footer_email' . $i;
		$wp_customize->add_setting( $key, array(
			'default'           => 1 === $i ? $defaults['persiapro_footer_email'] : '',
			'sanitize_callback' => 'sanitize_email',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => sprintf(
				/* translators: %d: email index */
				esc_html__( 'Email Address %d', 'persiapro' ),
				$i
			),
			'section' => 'persiapro_footer_contact',
			'type'    => 'email',
		) );
	}

	$wp_customize->add_setting( 'persiapro_footer_contact_title', array(
		'default'           => $defaults['persiapro_footer_contact_title'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_footer_contact_title', array(
		'label'   => esc_html__( 'Contact Column Title', 'persiapro' ),
		'section' => 'persiapro_footer_contact',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'persiapro_footer_links_title', array(
		'default'           => $defaults['persiapro_footer_links_title'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_footer_links_title', array(
		'label'       => esc_html__( 'Quick Links Column Title', 'persiapro' ),
		'description' => esc_html__( 'Assign a menu to "Footer Menu" under Appearance → Menus.', 'persiapro' ),
		'section'     => 'persiapro_footer_contact',
		'type'        => 'text',
	) );
}
