<?php
/**
 * Enqueue scripts and styles.
 *
 * @package PersiaPro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end styles and scripts.
 */
function persiapro_enqueue_assets() {
	$font_body    = get_theme_mod( 'persiapro_font_body', 'Vazirmatn' );
	$font_heading = get_theme_mod( 'persiapro_font_heading', 'Vazirmatn' );
	$fonts        = array_unique( array( $font_body, $font_heading ) );
	$font_url     = persiapro_google_fonts_url( $fonts );

	if ( $font_url ) {
		wp_enqueue_style(
			'persiapro-google-fonts',
			$font_url,
			array(),
			null
		);
	}

	wp_enqueue_style(
		'persiapro-style',
		get_stylesheet_uri(),
		array(),
		PERSIAPRO_VERSION
	);

	// Always load RTL/LTR direction CSS for language switching support
	wp_enqueue_style(
		'persiapro-rtl',
		PERSIAPRO_URI . '/rtl.css',
		array( 'persiapro-style' ),
		PERSIAPRO_VERSION
	);

	wp_enqueue_style(
		'persiapro-main',
		PERSIAPRO_URI . '/assets/css/main.css',
		array( 'persiapro-style' ),
		PERSIAPRO_VERSION
	);

	if ( is_front_page() ) {
		wp_enqueue_style(
			'persiapro-homepage',
			PERSIAPRO_URI . '/assets/css/homepage.css',
			array( 'persiapro-main' ),
			PERSIAPRO_VERSION
		);
	}

	wp_enqueue_script(
		'persiapro-main',
		PERSIAPRO_URI . '/assets/js/main.js',
		array(),
		PERSIAPRO_VERSION,
		true
	);

	wp_localize_script( 'persiapro-main', 'persiaproData', array(
		'stickyHeader'      => (bool) get_theme_mod( 'persiapro_header_sticky', true ),
		'transparentHeader' => (bool) get_theme_mod( 'persiapro_header_transparent', false ),
		'backToTop'         => (bool) get_theme_mod( 'persiapro_back_to_top', true ),
		'isFrontPage'       => is_front_page(),
		'ajaxUrl'           => admin_url( 'admin-ajax.php' ),
		'nonce'             => wp_create_nonce( 'persiapro_nonce' ),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'persiapro_enqueue_assets' );

/**
 * Output customizer CSS variables inline.
 */
function persiapro_customizer_css() {
	$css = ':root {';
	$css .= '--pp-primary: ' . sanitize_hex_color( get_theme_mod( 'persiapro_color_primary', '#1a5276' ) ) . ';';
	$css .= '--pp-secondary: ' . sanitize_hex_color( get_theme_mod( 'persiapro_color_secondary', '#2e86c1' ) ) . ';';
	$css .= '--pp-accent: ' . sanitize_hex_color( get_theme_mod( 'persiapro_color_accent', '#d4a017' ) ) . ';';
	$css .= '--pp-text: ' . sanitize_hex_color( get_theme_mod( 'persiapro_color_text', '#333333' ) ) . ';';
	$css .= '--pp-bg: ' . sanitize_hex_color( get_theme_mod( 'persiapro_color_background', '#ffffff' ) ) . ';';
	$css .= '--pp-header-bg: ' . sanitize_hex_color( get_theme_mod( 'persiapro_color_header_bg', '#ffffff' ) ) . ';';
	$css .= '--pp-header-text: ' . sanitize_hex_color( get_theme_mod( 'persiapro_color_header_text', '#333333' ) ) . ';';
	$css .= '--pp-footer-bg: ' . sanitize_hex_color( get_theme_mod( 'persiapro_color_footer_bg', '#1a1a2e' ) ) . ';';
	$css .= '--pp-footer-text: ' . sanitize_hex_color( get_theme_mod( 'persiapro_color_footer_text', '#cccccc' ) ) . ';';
	$css .= '--pp-container-width: ' . absint( get_theme_mod( 'persiapro_container_width', 1200 ) ) . 'px;';
	$css .= '--pp-content-padding: ' . floatval( get_theme_mod( 'persiapro_content_padding', 2 ) ) . 'rem;';
	$css .= '--pp-font-body: \'' . esc_attr( get_theme_mod( 'persiapro_font_body', 'Vazirmatn' ) ) . '\', \'Vazir\', \'IRANSans\', Tahoma, sans-serif;';
	$css .= '--pp-font-heading: \'' . esc_attr( get_theme_mod( 'persiapro_font_heading', 'Vazirmatn' ) ) . '\', \'Vazir\', \'IRANSans\', Tahoma, sans-serif;';
	$css .= '--pp-font-size-body: ' . absint( get_theme_mod( 'persiapro_font_size_body', 16 ) ) . 'px;';
	$css .= '--pp-line-height-body: ' . floatval( get_theme_mod( 'persiapro_line_height_body', 1.8 ) ) . ';';
	$css .= '--pp-font-size-h1: ' . floatval( get_theme_mod( 'persiapro_font_size_h1', 2.5 ) ) . 'rem;';
	$css .= '--pp-font-size-h2: ' . floatval( get_theme_mod( 'persiapro_font_size_h2', 2 ) ) . 'rem;';
	$css .= '--pp-font-size-h3: ' . floatval( get_theme_mod( 'persiapro_font_size_h3', 1.5 ) ) . 'rem;';
	$css .= '--pp-font-size-h4: ' . floatval( get_theme_mod( 'persiapro_font_size_h4', 1.25 ) ) . 'rem;';
	$css .= '}';

	$hero_height = absint( get_theme_mod( 'persiapro_hero_height', 600 ) );
	$css        .= '.pp-hero { min-height: ' . $hero_height . 'px; }';

	$overlay = get_theme_mod( 'persiapro_hero_overlay', 'rgba(26,82,118,0.7)' );
	$css    .= '.pp-hero__overlay { background: ' . esc_attr( $overlay ) . '; }';

	$custom_css = get_theme_mod( 'persiapro_custom_css', '' );
	if ( ! empty( $custom_css ) ) {
		$css .= wp_strip_all_tags( $custom_css );
	}

	wp_add_inline_style( 'persiapro-main', $css );
}
add_action( 'wp_enqueue_scripts', 'persiapro_customizer_css', 20 );

/**
 * Build Google Fonts URL.
 *
 * @param array $fonts Font family names.
 * @return string
 */
function persiapro_google_fonts_url( $fonts ) {
	$available = persiapro_get_font_choices();
	$families  = array();

	foreach ( $fonts as $font ) {
		if ( isset( $available[ $font ] ) && ! empty( $available[ $font ]['google'] ) ) {
			$families[] = $available[ $font ]['google'];
		}
	}

	if ( empty( $families ) ) {
		return '';
	}

	return add_query_arg(
		array(
			'family'  => implode( '&family=', $families ),
			'display' => 'swap',
		),
		'https://fonts.googleapis.com/css2'
	);
}

/**
 * Get available font choices.
 *
 * @return array
 */
function persiapro_get_font_choices() {
	return array(
		'Vazirmatn'   => array(
			'label'  => 'Vazirmatn',
			'google' => 'Vazirmatn:wght@300;400;500;600;700',
		),
		'Vazir'       => array(
			'label'  => 'Vazir',
			'google' => 'Vazirmatn:wght@400;700',
		),
		'IRANSans'    => array(
			'label'  => 'IRANSans (Estedad)',
			'google' => 'Estedad:wght@400;600;700',
		),
		'Sahel'       => array(
			'label'  => 'Sahel',
			'google' => 'Vazirmatn:wght@400;700',
		),
		'Samim'       => array(
			'label'  => 'Samim',
			'google' => 'Vazirmatn:wght@400;700',
		),
		'Tahoma'      => array(
			'label'  => 'Tahoma',
			'google' => '',
		),
		'Roboto'      => array(
			'label'  => 'Roboto',
			'google' => 'Roboto:wght@300;400;500;700',
		),
		'Open Sans'   => array(
			'label'  => 'Open Sans',
			'google' => 'Open+Sans:wght@300;400;600;700',
		),
	);
}

/**
 * Enqueue customizer preview script.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function persiapro_customize_preview_init() {
	wp_enqueue_script(
		'persiapro-customizer-preview',
		PERSIAPRO_URI . '/assets/js/customizer-preview.js',
		array( 'customize-preview' ),
		PERSIAPRO_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'persiapro_customize_preview_init' );

/**
 * Output Google Analytics if configured.
 */
function persiapro_google_analytics() {
	$ga_id = get_theme_mod( 'persiapro_google_analytics', '' );
	if ( empty( $ga_id ) || is_customize_preview() ) {
		return;
	}
	?>
	<!-- Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga_id ); ?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '<?php echo esc_js( $ga_id ); ?>');
	</script>
	<?php
}
add_action( 'wp_head', 'persiapro_google_analytics', 99 );
