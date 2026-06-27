<?php
/**
 * Header template
 *
 * @package PersiaPro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hide_header = is_page_template( 'page-templates/template-no-header-footer.php' ) || is_page_template( 'page-templates/template-landing.php' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="pp-site">

<?php if ( ! $hide_header ) : ?>

	<?php if ( get_theme_mod( 'persiapro_topbar_enable', true ) ) : ?>
	<div class="pp-top-bar">
		<div class="pp-container">
			<div class="pp-top-bar__inner">
				<div class="pp-top-bar__contact">
					<?php if ( $phone = persiapro_get_theme_mod( 'persiapro_topbar_phone', '' ) ) : ?>
						<?php persiapro_phone_link( $phone, array( 'show_icon' => true ) ); ?>
					<?php endif; ?>
					<?php if ( $email = persiapro_get_theme_mod( 'persiapro_topbar_email', '' ) ) : ?>
						<?php persiapro_email_link( $email, array( 'show_icon' => true ) ); ?>
					<?php endif; ?>
				</div>
				<?php persiapro_social_icons( 'topbar' ); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<header id="masthead" class="<?php echo esc_attr( persiapro_header_classes() ); ?>">
		<div class="pp-container">
			<div class="pp-header__inner">
				<div class="pp-logo">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pp-logo__text" rel="home">
							<?php bloginfo( 'name' ); ?>
						</a>
					<?php endif; ?>
				</div>

				<button class="pp-nav-toggle" aria-controls="primary-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'persiapro' ); ?>">
					<span aria-hidden="true">&#9776;</span>
				</button>

				<nav id="primary-navigation" class="pp-nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'persiapro' ); ?>">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'     => 'pp-nav__list',
						'container'      => false,
						'fallback_cb'    => 'persiapro_fallback_menu',
					) );
					?>
				</nav>
			</div>
		</div>
	</header>

	<?php if ( persiapro_show_hero() ) : ?>
		<?php get_template_part( 'template-parts/hero' ); ?>
	<?php endif; ?>

<?php endif; ?>
