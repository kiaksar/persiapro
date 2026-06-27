<?php
/**
 * Admin theme settings page with Customizer deep-links.
 *
 * @package PersiaPro
 * @since 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register admin menu under Appearance.
 */
function persiapro_admin_menu() {
	add_theme_page(
		esc_html__( 'PersiaPro Settings', 'persiapro' ),
		esc_html__( 'PersiaPro', 'persiapro' ),
		'edit_theme_options',
		'persiapro-settings',
		'persiapro_settings_page_render'
	);
}
add_action( 'admin_menu', 'persiapro_admin_menu' );

/**
 * Customizer deep-link helper.
 *
 * @param string $section Section ID.
 * @return string
 */
function persiapro_customize_link( $section ) {
	return add_query_arg(
		array(
			'autofocus[section]' => $section,
			'return'             => rawurlencode( admin_url( 'themes.php?page=persiapro-settings' ) ),
		),
		admin_url( 'customize.php' )
	);
}

/**
 * Render settings page.
 */
function persiapro_settings_page_render() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$sections = array(
		array(
			'title'       => esc_html__( 'Homepage — Materials Section', 'persiapro' ),
			'description' => esc_html__( 'Change the materials title, subtitle, button text, and how many items appear on the homepage.', 'persiapro' ),
			'section'     => 'persiapro_homepage_materials',
			'highlight'   => esc_html__( 'Materials title is here', 'persiapro' ),
		),
		array(
			'title'       => esc_html__( 'Homepage — Blog Slider', 'persiapro' ),
			'description' => esc_html__( 'Blog slider title, subtitle, post count, and "View all" button text.', 'persiapro' ),
			'section'     => 'persiapro_homepage_blog_slider',
		),
		array(
			'title'       => esc_html__( 'Hero / Banner', 'persiapro' ),
			'description' => esc_html__( 'Homepage hero headline, subtitle, background, and CTA buttons.', 'persiapro' ),
			'section'     => 'persiapro_hero_settings',
		),
		array(
			'title'       => esc_html__( 'Footer — Contact Info', 'persiapro' ),
			'description' => esc_html__( 'Address, phone numbers, emails, and section headings.', 'persiapro' ),
			'section'     => 'persiapro_footer_contact',
		),
		array(
			'title'       => esc_html__( 'Header — Top Bar', 'persiapro' ),
			'description' => esc_html__( 'Top bar phone, email, and social links.', 'persiapro' ),
			'section'     => 'persiapro_header_topbar',
		),
		array(
			'title'       => esc_html__( 'Colors', 'persiapro' ),
			'description' => esc_html__( 'Primary, secondary, accent, and header/footer colors.', 'persiapro' ),
			'section'     => 'persiapro_colors_general',
		),
	);

	$github_user = persiapro_github_user();
	$github_repo = persiapro_github_repo();
	$version     = PERSIAPRO_VERSION;
	?>
	<div class="wrap persiapro-admin">
		<h1><?php esc_html_e( 'PersiaPro Theme Settings', 'persiapro' ); ?></h1>
		<p class="description">
			<?php
			printf(
				/* translators: 1: version number, 2: GitHub profile URL */
				esc_html__( 'Version %1$s — by %2$s', 'persiapro' ),
				esc_html( $version ),
				'<a href="' . esc_url( 'https://github.com/' . $github_user ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $github_user ) . '</a>'
			);
			?>
		</p>

		<div class="notice notice-info inline" style="margin: 1em 0 1.5em; padding: 12px;">
			<p>
				<strong><?php esc_html_e( 'Looking for the materials title?', 'persiapro' ); ?></strong>
				<?php esc_html_e( 'Click the first card below — "Homepage — Materials Section" — then edit "Section Title".', 'persiapro' ); ?>
			</p>
		</div>

		<div class="persiapro-admin__grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;max-width:960px;">
			<?php foreach ( $sections as $item ) : ?>
				<div class="card" style="padding:16px;">
					<?php if ( ! empty( $item['highlight'] ) ) : ?>
						<p style="margin:0 0 8px;"><span class="dashicons dashicons-star-filled" style="color:#d4a017;"></span> <strong><?php echo esc_html( $item['highlight'] ); ?></strong></p>
					<?php endif; ?>
					<h2 style="margin-top:0;font-size:1.1em;"><?php echo esc_html( $item['title'] ); ?></h2>
					<p><?php echo esc_html( $item['description'] ); ?></p>
					<a href="<?php echo esc_url( persiapro_customize_link( $item['section'] ) ); ?>" class="button button-primary">
						<?php esc_html_e( 'Customize', 'persiapro' ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>

		<p style="margin-top:2em;">
			<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button">
				<?php esc_html_e( 'Open Full Customizer', 'persiapro' ); ?>
			</a>
			<?php if ( $github_user && $github_repo ) : ?>
				<a href="<?php echo esc_url( 'https://github.com/' . $github_user . '/' . $github_repo . '/releases' ); ?>" class="button" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'View Releases on GitHub', 'persiapro' ); ?>
				</a>
			<?php endif; ?>
		</p>
	</div>
	<?php
}

/**
 * Add link on Themes list page.
 *
 * @param array $actions Theme actions.
 * @return array
 */
function persiapro_theme_action_links( $actions ) {
	$actions['persiapro_settings'] = sprintf(
		'<a href="%1$s">%2$s</a>',
		esc_url( admin_url( 'themes.php?page=persiapro-settings' ) ),
		esc_html__( 'PersiaPro Settings', 'persiapro' )
	);
	return $actions;
}
add_filter( 'theme_action_links_persiapro', 'persiapro_theme_action_links' );
