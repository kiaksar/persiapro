<?php
/**
 * Theme Customizer
 *
 * @package PersiaPro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customize_register( $wp_customize ) {

	/* ---- Panels ---- */
	$wp_customize->add_panel( 'persiapro_panel_colors', array(
		'title'    => esc_html__( 'PersiaPro Colors', 'persiapro' ),
		'priority' => 30,
	) );

	$wp_customize->add_panel( 'persiapro_panel_typography', array(
		'title'    => esc_html__( 'PersiaPro Typography', 'persiapro' ),
		'priority' => 35,
	) );

	$wp_customize->add_panel( 'persiapro_panel_header', array(
		'title'    => esc_html__( 'PersiaPro Header', 'persiapro' ),
		'priority' => 40,
	) );

	$wp_customize->add_panel( 'persiapro_panel_hero', array(
		'title'    => esc_html__( 'PersiaPro Hero / Banner', 'persiapro' ),
		'priority' => 45,
	) );

	$wp_customize->add_panel( 'persiapro_panel_layout', array(
		'title'    => esc_html__( 'PersiaPro Layout', 'persiapro' ),
		'priority' => 50,
	) );

	$wp_customize->add_panel( 'persiapro_panel_footer', array(
		'title'    => esc_html__( 'PersiaPro Footer', 'persiapro' ),
		'priority' => 55,
	) );

	$wp_customize->add_panel( 'persiapro_panel_blog', array(
		'title'    => esc_html__( 'PersiaPro Blog / Archive', 'persiapro' ),
		'priority' => 60,
	) );

	$wp_customize->add_panel( 'persiapro_panel_advanced', array(
		'title'    => esc_html__( 'PersiaPro Advanced', 'persiapro' ),
		'priority' => 200,
	) );

	persiapro_customizer_colors( $wp_customize );
	persiapro_customizer_typography( $wp_customize );
	persiapro_customizer_header( $wp_customize );
	persiapro_customizer_hero( $wp_customize );
	persiapro_customizer_homepage( $wp_customize );
	persiapro_customizer_layout( $wp_customize );
	persiapro_customizer_footer( $wp_customize );
	persiapro_customizer_footer_contact( $wp_customize );
	persiapro_customizer_blog( $wp_customize );
	persiapro_customizer_advanced( $wp_customize );
}
add_action( 'customize_register', 'persiapro_customize_register' );

/**
 * Sanitize checkbox.
 *
 * @param bool $input Checkbox value.
 * @return bool
 */
function persiapro_sanitize_checkbox( $input ) {
	return (bool) $input;
}

/**
 * Sanitize select.
 *
 * @param string $input   Selected value.
 * @param object $setting Setting object.
 * @return string
 */
function persiapro_sanitize_select( $input, $setting ) {
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return array_key_exists( $input, $choices ) ? $input : $setting->default;
}

/**
 * Sanitize rgba color.
 *
 * @param string $color Color value.
 * @return string
 */
function persiapro_sanitize_rgba( $color ) {
	if ( empty( $color ) || 'transparent' === $color ) {
		return 'transparent';
	}
	if ( false === strpos( $color, 'rgba' ) ) {
		return sanitize_hex_color( $color );
	}
	if ( preg_match( '/rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*([\d.]+))?\s*\)/', $color, $matches ) ) {
		return sprintf( 'rgba(%d,%d,%d,%s)', $matches[1], $matches[2], $matches[3], isset( $matches[4] ) ? $matches[4] : '1' );
	}
	return 'rgba(26,82,118,0.7)';
}

/**
 * Colors customizer section.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customizer_colors( $wp_customize ) {
	$wp_customize->add_section( 'persiapro_colors_general', array(
		'title' => esc_html__( 'General Colors', 'persiapro' ),
		'panel' => 'persiapro_panel_colors',
	) );

	$colors = array(
		'persiapro_color_primary'    => array( '#1a5276', esc_html__( 'Primary Color', 'persiapro' ) ),
		'persiapro_color_secondary'  => array( '#2e86c1', esc_html__( 'Secondary Color', 'persiapro' ) ),
		'persiapro_color_accent'     => array( '#d4a017', esc_html__( 'Accent Color', 'persiapro' ) ),
		'persiapro_color_text'       => array( '#333333', esc_html__( 'Text Color', 'persiapro' ) ),
		'persiapro_color_background' => array( '#ffffff', esc_html__( 'Background Color', 'persiapro' ) ),
	);

	foreach ( $colors as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $data[0],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
			'label'   => $data[1],
			'section' => 'persiapro_colors_general',
		) ) );
	}

	$wp_customize->add_section( 'persiapro_colors_header_footer', array(
		'title' => esc_html__( 'Header & Footer Colors', 'persiapro' ),
		'panel' => 'persiapro_panel_colors',
	) );

	$hf_colors = array(
		'persiapro_color_header_bg'   => array( '#ffffff', esc_html__( 'Header Background', 'persiapro' ) ),
		'persiapro_color_header_text' => array( '#333333', esc_html__( 'Header Text', 'persiapro' ) ),
		'persiapro_color_footer_bg'   => array( '#1a1a2e', esc_html__( 'Footer Background', 'persiapro' ) ),
		'persiapro_color_footer_text' => array( '#cccccc', esc_html__( 'Footer Text', 'persiapro' ) ),
	);

	foreach ( $hf_colors as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $data[0],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
			'label'   => $data[1],
			'section' => 'persiapro_colors_header_footer',
		) ) );
	}
}

/**
 * Typography customizer section.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customizer_typography( $wp_customize ) {
	$wp_customize->add_section( 'persiapro_typography_fonts', array(
		'title' => esc_html__( 'Font Families', 'persiapro' ),
		'panel' => 'persiapro_panel_typography',
	) );

	$font_choices = array();
	foreach ( persiapro_get_font_choices() as $key => $font ) {
		$font_choices[ $key ] = $font['label'];
	}

	$wp_customize->add_setting( 'persiapro_font_body', array(
		'default'           => 'Vazirmatn',
		'sanitize_callback' => 'persiapro_sanitize_select',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_font_body', array(
		'label'   => esc_html__( 'Body Font', 'persiapro' ),
		'section' => 'persiapro_typography_fonts',
		'type'    => 'select',
		'choices' => $font_choices,
	) );

	$wp_customize->add_setting( 'persiapro_font_heading', array(
		'default'           => 'Vazirmatn',
		'sanitize_callback' => 'persiapro_sanitize_select',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_font_heading', array(
		'label'   => esc_html__( 'Heading Font', 'persiapro' ),
		'section' => 'persiapro_typography_fonts',
		'type'    => 'select',
		'choices' => $font_choices,
	) );

	$wp_customize->add_section( 'persiapro_typography_sizes', array(
		'title' => esc_html__( 'Font Sizes', 'persiapro' ),
		'panel' => 'persiapro_panel_typography',
	) );

	$sizes = array(
		'persiapro_font_size_body' => array( 16, esc_html__( 'Body Font Size (px)', 'persiapro' ), 12, 24 ),
		'persiapro_line_height_body' => array( 1.8, esc_html__( 'Body Line Height', 'persiapro' ), 1.2, 3, 0.1 ),
		'persiapro_font_size_h1'   => array( 2.5, esc_html__( 'H1 Size (rem)', 'persiapro' ), 1.5, 4, 0.1 ),
		'persiapro_font_size_h2'   => array( 2, esc_html__( 'H2 Size (rem)', 'persiapro' ), 1.25, 3.5, 0.1 ),
		'persiapro_font_size_h3'   => array( 1.5, esc_html__( 'H3 Size (rem)', 'persiapro' ), 1, 2.5, 0.1 ),
		'persiapro_font_size_h4'   => array( 1.25, esc_html__( 'H4 Size (rem)', 'persiapro' ), 0.875, 2, 0.1 ),
	);

	foreach ( $sizes as $id => $data ) {
		$is_int = is_int( $data[0] ) || ( is_numeric( $data[0] ) && floor( $data[0] ) == $data[0] && strpos( (string) $data[0], '.' ) === false );
		$wp_customize->add_setting( $id, array(
			'default'           => $data[0],
			'sanitize_callback' => $is_int ? 'absint' : 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( $id, array(
			'label'       => $data[1],
			'section'     => 'persiapro_typography_sizes',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => $data[2],
				'max'  => $data[3],
				'step' => isset( $data[4] ) ? $data[4] : 1,
			),
		) );
	}
}

/**
 * Header customizer section.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customizer_header( $wp_customize ) {
	$wp_customize->add_section( 'persiapro_header_options', array(
		'title' => esc_html__( 'Header Options', 'persiapro' ),
		'panel' => 'persiapro_panel_header',
	) );

	$wp_customize->add_setting( 'persiapro_header_sticky', array(
		'default'           => true,
		'sanitize_callback' => 'persiapro_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'persiapro_header_sticky', array(
		'label'   => esc_html__( 'Sticky Header', 'persiapro' ),
		'section' => 'persiapro_header_options',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'persiapro_header_transparent', array(
		'default'           => false,
		'sanitize_callback' => 'persiapro_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'persiapro_header_transparent', array(
		'label'       => esc_html__( 'Transparent Header (Homepage)', 'persiapro' ),
		'description' => esc_html__( 'Makes header transparent on the front page with hero section.', 'persiapro' ),
		'section'     => 'persiapro_header_options',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_section( 'persiapro_header_topbar', array(
		'title' => esc_html__( 'Top Bar', 'persiapro' ),
		'panel' => 'persiapro_panel_header',
	) );

	$wp_customize->add_setting( 'persiapro_topbar_enable', array(
		'default'           => true,
		'sanitize_callback' => 'persiapro_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'persiapro_topbar_enable', array(
		'label'   => esc_html__( 'Enable Top Bar', 'persiapro' ),
		'section' => 'persiapro_header_topbar',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'persiapro_topbar_phone', array(
		'default'           => persiapro_get_defaults()['persiapro_topbar_phone'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_topbar_phone', array(
		'label'   => esc_html__( 'Phone Number', 'persiapro' ),
		'section' => 'persiapro_header_topbar',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'persiapro_topbar_email', array(
		'default'           => persiapro_get_defaults()['persiapro_topbar_email'],
		'sanitize_callback' => 'sanitize_email',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_topbar_email', array(
		'label'   => esc_html__( 'Email Address', 'persiapro' ),
		'section' => 'persiapro_header_topbar',
		'type'    => 'email',
	) );

	$wp_customize->add_section( 'persiapro_header_social', array(
		'title' => esc_html__( 'Social Media Links', 'persiapro' ),
		'panel' => 'persiapro_panel_header',
	) );

	$socials = array(
		'instagram' => esc_html__( 'Instagram URL', 'persiapro' ),
		'telegram'  => esc_html__( 'Telegram URL', 'persiapro' ),
		'linkedin'  => esc_html__( 'LinkedIn URL', 'persiapro' ),
		'twitter'   => esc_html__( 'Twitter / X URL', 'persiapro' ),
		'facebook'  => esc_html__( 'Facebook URL', 'persiapro' ),
		'youtube'   => esc_html__( 'YouTube URL', 'persiapro' ),
		'whatsapp'  => esc_html__( 'WhatsApp URL', 'persiapro' ),
	);

	foreach ( $socials as $key => $label ) {
		// URL setting
		$wp_customize->add_setting( 'persiapro_social_' . $key, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( 'persiapro_social_' . $key, array(
			'label'   => $label,
			'section' => 'persiapro_header_social',
			'type'    => 'url',
		) );

		// Icon image setting
		$wp_customize->add_setting( 'persiapro_social_' . $key . '_icon', array(
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'persiapro_social_' . $key . '_icon', array(
			'label'    => $label . ' ' . esc_html__( 'Icon', 'persiapro' ),
			'section'  => 'persiapro_header_social',
			'settings' => 'persiapro_social_' . $key . '_icon',
		) ) );
	}
}

/**
 * Hero customizer section.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customizer_hero( $wp_customize ) {
	$wp_customize->add_section( 'persiapro_hero_settings', array(
		'title' => esc_html__( 'Hero Settings', 'persiapro' ),
		'panel' => 'persiapro_panel_hero',
	) );

	$wp_customize->add_setting( 'persiapro_hero_enable', array(
		'default'           => true,
		'sanitize_callback' => 'persiapro_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'persiapro_hero_enable', array(
		'label'   => esc_html__( 'Enable Hero Section', 'persiapro' ),
		'section' => 'persiapro_hero_settings',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'persiapro_hero_bg_image', array(
		'default'           => '',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'persiapro_hero_bg_image', array(
		'label'     => esc_html__( 'Background Image', 'persiapro' ),
		'section'   => 'persiapro_hero_settings',
		'mime_type' => 'image',
	) ) );

	$wp_customize->add_setting( 'persiapro_hero_overlay', array(
		'default'           => 'rgba(26,82,118,0.7)',
		'sanitize_callback' => 'persiapro_sanitize_rgba',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_hero_overlay', array(
		'label'   => esc_html__( 'Overlay Color (rgba)', 'persiapro' ),
		'section' => 'persiapro_hero_settings',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'persiapro_hero_height', array(
		'default'           => 600,
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_hero_height', array(
		'label'       => esc_html__( 'Hero Height (px)', 'persiapro' ),
		'section'     => 'persiapro_hero_settings',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 300, 'max' => 900, 'step' => 10 ),
	) );

	$wp_customize->add_setting( 'persiapro_hero_title', array(
		'default'           => esc_html__( 'به شرکت ما خوش آمدید', 'persiapro' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_hero_title', array(
		'label'   => esc_html__( 'Headline', 'persiapro' ),
		'section' => 'persiapro_hero_settings',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'persiapro_hero_subtitle', array(
		'default'           => esc_html__( 'راهکارهای حرفه‌ای برای کسب‌وکار شما', 'persiapro' ),
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_hero_subtitle', array(
		'label'   => esc_html__( 'Subheadline', 'persiapro' ),
		'section' => 'persiapro_hero_settings',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'persiapro_hero_btn1_text', array(
		'default'           => esc_html__( 'شروع کنید', 'persiapro' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_hero_btn1_text', array(
		'label'   => esc_html__( 'Button 1 Text', 'persiapro' ),
		'section' => 'persiapro_hero_settings',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'persiapro_hero_btn1_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'persiapro_hero_btn1_url', array(
		'label'   => esc_html__( 'Button 1 URL', 'persiapro' ),
		'section' => 'persiapro_hero_settings',
		'type'    => 'url',
	) );

	$wp_customize->add_setting( 'persiapro_hero_btn1_style', array(
		'default'           => 'primary',
		'sanitize_callback' => 'persiapro_sanitize_select',
	) );
	$wp_customize->add_control( 'persiapro_hero_btn1_style', array(
		'label'   => esc_html__( 'Button 1 Style', 'persiapro' ),
		'section' => 'persiapro_hero_settings',
		'type'    => 'select',
		'choices' => array(
			'primary'   => esc_html__( 'Primary', 'persiapro' ),
			'secondary' => esc_html__( 'Secondary (Outline White)', 'persiapro' ),
			'accent'    => esc_html__( 'Accent', 'persiapro' ),
			'outline'   => esc_html__( 'Outline', 'persiapro' ),
		),
	) );

	$wp_customize->add_setting( 'persiapro_hero_btn2_text', array(
		'default'           => esc_html__( 'بیشتر بدانید', 'persiapro' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_hero_btn2_text', array(
		'label'   => esc_html__( 'Button 2 Text', 'persiapro' ),
		'section' => 'persiapro_hero_settings',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'persiapro_hero_btn2_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'persiapro_hero_btn2_url', array(
		'label'   => esc_html__( 'Button 2 URL', 'persiapro' ),
		'section' => 'persiapro_hero_settings',
		'type'    => 'url',
	) );

	$wp_customize->add_setting( 'persiapro_hero_btn2_style', array(
		'default'           => 'secondary',
		'sanitize_callback' => 'persiapro_sanitize_select',
	) );
	$wp_customize->add_control( 'persiapro_hero_btn2_style', array(
		'label'   => esc_html__( 'Button 2 Style', 'persiapro' ),
		'section' => 'persiapro_hero_settings',
		'type'    => 'select',
		'choices' => array(
			'primary'   => esc_html__( 'Primary', 'persiapro' ),
			'secondary' => esc_html__( 'Secondary (Outline White)', 'persiapro' ),
			'accent'    => esc_html__( 'Accent', 'persiapro' ),
			'outline'   => esc_html__( 'Outline', 'persiapro' ),
		),
	) );
}

/**
 * Layout customizer section.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customizer_layout( $wp_customize ) {
	$wp_customize->add_section( 'persiapro_layout_global', array(
		'title' => esc_html__( 'Global Layout', 'persiapro' ),
		'panel' => 'persiapro_panel_layout',
	) );

	$wp_customize->add_setting( 'persiapro_layout_style', array(
		'default'           => 'full',
		'sanitize_callback' => 'persiapro_sanitize_select',
	) );
	$wp_customize->add_control( 'persiapro_layout_style', array(
		'label'   => esc_html__( 'Layout Style', 'persiapro' ),
		'section' => 'persiapro_layout_global',
		'type'    => 'select',
		'choices' => array(
			'full'  => esc_html__( 'Full Width', 'persiapro' ),
			'boxed' => esc_html__( 'Boxed', 'persiapro' ),
		),
	) );

	$wp_customize->add_setting( 'persiapro_container_width', array(
		'default'           => 1200,
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_container_width', array(
		'label'       => esc_html__( 'Container Width (px)', 'persiapro' ),
		'section'     => 'persiapro_layout_global',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 960, 'max' => 1600, 'step' => 10 ),
	) );

	$wp_customize->add_setting( 'persiapro_content_padding', array(
		'default'           => 2,
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_content_padding', array(
		'label'       => esc_html__( 'Content Padding (rem)', 'persiapro' ),
		'section'     => 'persiapro_layout_global',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 0.5, 'max' => 5, 'step' => 0.5 ),
	) );

	$wp_customize->add_setting( 'persiapro_sidebar_position', array(
		'default'           => 'left',
		'sanitize_callback' => 'persiapro_sanitize_select',
	) );
	$wp_customize->add_control( 'persiapro_sidebar_position', array(
		'label'   => esc_html__( 'Sidebar Position', 'persiapro' ),
		'section' => 'persiapro_layout_global',
		'type'    => 'select',
		'choices' => array(
			'left'  => esc_html__( 'Left (RTL default)', 'persiapro' ),
			'right' => esc_html__( 'Right', 'persiapro' ),
			'none'  => esc_html__( 'No Sidebar', 'persiapro' ),
		),
	) );

	$wp_customize->add_setting( 'persiapro_back_to_top', array(
		'default'           => true,
		'sanitize_callback' => 'persiapro_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'persiapro_back_to_top', array(
		'label'   => esc_html__( 'Show Back to Top Button', 'persiapro' ),
		'section' => 'persiapro_layout_global',
		'type'    => 'checkbox',
	) );
}

/**
 * Footer customizer section.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customizer_footer( $wp_customize ) {
	$wp_customize->add_section( 'persiapro_footer_options', array(
		'title' => esc_html__( 'Footer Options', 'persiapro' ),
		'panel' => 'persiapro_panel_footer',
	) );

	$wp_customize->add_setting( 'persiapro_footer_columns', array(
		'default'           => 4,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'persiapro_footer_columns', array(
		'label'       => esc_html__( 'Footer Widget Columns', 'persiapro' ),
		'section'     => 'persiapro_footer_options',
		'type'        => 'select',
		'choices'     => array(
			1 => '1',
			2 => '2',
			3 => '3',
			4 => '4',
		),
	) );

	$wp_customize->add_setting( 'persiapro_footer_copyright', array(
		'default'           => sprintf(
			/* translators: %s: current year and site name */
			esc_html__( '© %1$s %2$s. All rights reserved.', 'persiapro' ),
			date_i18n( 'Y' ),
			get_bloginfo( 'name' )
		),
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_footer_copyright', array(
		'label'   => esc_html__( 'Copyright Text', 'persiapro' ),
		'section' => 'persiapro_footer_options',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'persiapro_footer_show_social', array(
		'default'           => true,
		'sanitize_callback' => 'persiapro_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'persiapro_footer_show_social', array(
		'label'   => esc_html__( 'Show Social Icons in Footer', 'persiapro' ),
		'section' => 'persiapro_footer_options',
		'type'    => 'checkbox',
	) );
}

/**
 * Blog customizer section.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customizer_blog( $wp_customize ) {
	$wp_customize->add_section( 'persiapro_blog_options', array(
		'title' => esc_html__( 'Blog Settings', 'persiapro' ),
		'panel' => 'persiapro_panel_blog',
	) );

	$wp_customize->add_setting( 'persiapro_blog_layout', array(
		'default'           => 'grid',
		'sanitize_callback' => 'persiapro_sanitize_select',
	) );
	$wp_customize->add_control( 'persiapro_blog_layout', array(
		'label'   => esc_html__( 'Post Layout', 'persiapro' ),
		'section' => 'persiapro_blog_options',
		'type'    => 'select',
		'choices' => array(
			'grid' => esc_html__( 'Grid', 'persiapro' ),
			'list' => esc_html__( 'List', 'persiapro' ),
		),
	) );

	$wp_customize->add_setting( 'persiapro_excerpt_length', array(
		'default'           => 30,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'persiapro_excerpt_length', array(
		'label'       => esc_html__( 'Excerpt Length (words)', 'persiapro' ),
		'section'     => 'persiapro_blog_options',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 10, 'max' => 100 ),
	) );

	$wp_customize->add_setting( 'persiapro_read_more_text', array(
		'default'           => persiapro_get_defaults()['persiapro_read_more_text'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_read_more_text', array(
		'label'   => esc_html__( 'Read More Text', 'persiapro' ),
		'section' => 'persiapro_blog_options',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'persiapro_show_featured_image', array(
		'default'           => true,
		'sanitize_callback' => 'persiapro_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'persiapro_show_featured_image', array(
		'label'   => esc_html__( 'Show Featured Images', 'persiapro' ),
		'section' => 'persiapro_blog_options',
		'type'    => 'checkbox',
	) );
}

/**
 * Advanced customizer section.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customizer_advanced( $wp_customize ) {
	$wp_customize->add_section( 'persiapro_advanced_options', array(
		'title' => esc_html__( 'Advanced Settings', 'persiapro' ),
		'panel' => 'persiapro_panel_advanced',
	) );

	$wp_customize->add_setting( 'persiapro_custom_css', array(
		'default'           => '',
		'sanitize_callback' => 'wp_strip_all_tags',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'persiapro_custom_css', array(
		'label'       => esc_html__( 'Custom CSS', 'persiapro' ),
		'description' => esc_html__( 'Add custom CSS without editing theme files.', 'persiapro' ),
		'section'     => 'persiapro_advanced_options',
		'type'        => 'textarea',
	) );

	$wp_customize->add_setting( 'persiapro_google_analytics', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'persiapro_google_analytics', array(
		'label'       => esc_html__( 'Google Analytics ID', 'persiapro' ),
		'description' => esc_html__( 'Enter your GA4 Measurement ID (e.g., G-XXXXXXXXXX).', 'persiapro' ),
		'section'     => 'persiapro_advanced_options',
		'type'        => 'text',
	) );
}

/**
 * Selective refresh for customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customize_selective_refresh( $wp_customize ) {
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'persiapro_hero_title', array(
		'selector'        => '.pp-hero__title',
		'render_callback' => function () {
			return esc_html( get_theme_mod( 'persiapro_hero_title', '' ) );
		},
	) );

	$wp_customize->selective_refresh->add_partial( 'persiapro_hero_subtitle', array(
		'selector'        => '.pp-hero__subtitle',
		'render_callback' => function () {
			return esc_html( get_theme_mod( 'persiapro_hero_subtitle', '' ) );
		},
	) );

	$wp_customize->selective_refresh->add_partial( 'persiapro_materials_title', array(
		'selector'            => '.pp-materials .pp-section__title',
		'container_inclusive' => false,
		'render_callback'     => function () {
			return esc_html( persiapro_get_theme_mod( 'persiapro_materials_title' ) );
		},
	) );

	$wp_customize->selective_refresh->add_partial( 'persiapro_materials_subtitle', array(
		'selector'            => '.pp-materials .pp-section__subtitle',
		'container_inclusive' => false,
		'render_callback'     => function () {
			return esc_html( persiapro_get_theme_mod( 'persiapro_materials_subtitle' ) );
		},
	) );

	$wp_customize->selective_refresh->add_partial( 'persiapro_blog_slider_title', array(
		'selector'            => '.pp-blog-slider-section .pp-section__title',
		'container_inclusive' => false,
		'render_callback'     => function () {
			return esc_html( persiapro_get_theme_mod( 'persiapro_blog_slider_title' ) );
		},
	) );

	$wp_customize->selective_refresh->add_partial( 'persiapro_footer_copyright', array(
		'selector'        => '.pp-footer-copyright',
		'render_callback' => function () {
			return wp_kses_post( get_theme_mod( 'persiapro_footer_copyright', '' ) );
		},
	) );
}
add_action( 'customize_register', 'persiapro_customize_selective_refresh' );
