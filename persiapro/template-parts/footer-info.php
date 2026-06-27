<?php
/**
 * Enhanced footer with company contact info
 *
 * @package PersiaPro
 * @since 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$address     = persiapro_get_theme_mod( 'persiapro_footer_address' );
$phones      = persiapro_get_footer_phones();
$emails      = persiapro_get_footer_emails();
$about       = get_theme_mod( 'persiapro_footer_about', '' );
$has_menu    = has_nav_menu( 'footer' );
$has_social  = get_theme_mod( 'persiapro_footer_show_social', true );
$has_widgets = false;

for ( $i = 1; $i <= absint( get_theme_mod( 'persiapro_footer_columns', 4 ) ); $i++ ) {
	if ( is_active_sidebar( 'footer-' . $i ) ) {
		$has_widgets = true;
		break;
	}
}

if ( ! $address && empty( $phones ) && empty( $emails ) && ! $about && ! $has_menu && ! $has_widgets ) {
	return;
}
?>

<div class="pp-footer-info">
	<div class="pp-container">
		<div class="pp-footer-info__grid">

			<div class="pp-footer-info__col pp-footer-info__col--about">
				<?php if ( has_custom_logo() ) : ?>
					<div class="pp-footer-info__logo">
						<?php the_custom_logo(); ?>
					</div>
				<?php else : ?>
					<h4 class="pp-footer-info__title"><?php bloginfo( 'name' ); ?></h4>
				<?php endif; ?>

				<?php if ( $about ) : ?>
					<p class="pp-footer-info__about"><?php echo esc_html( $about ); ?></p>
				<?php else : ?>
					<p class="pp-footer-info__about"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>

				<?php if ( $has_social ) : ?>
					<?php persiapro_social_icons( 'footer' ); ?>
				<?php endif; ?>
			</div>

			<?php if ( $has_menu ) : ?>
				<div class="pp-footer-info__col pp-footer-info__col--links">
					<h4 class="pp-footer-info__title"><?php echo esc_html( persiapro_get_theme_mod( 'persiapro_footer_links_title' ) ); ?></h4>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'menu_class'     => 'pp-footer-info__menu',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					) );
					?>
				</div>
			<?php endif; ?>

			<div class="pp-footer-info__col pp-footer-info__col--contact">
				<h4 class="pp-footer-info__title"><?php echo esc_html( persiapro_get_theme_mod( 'persiapro_footer_contact_title' ) ); ?></h4>
				<ul class="pp-footer-info__contact-list">

					<?php if ( $address ) : ?>
						<li class="pp-footer-info__contact-item pp-footer-info__contact-item--address">
							<span class="pp-footer-info__icon" aria-hidden="true">&#128205;</span>
							<span><?php echo nl2br( esc_html( $address ) ); ?></span>
						</li>
					<?php endif; ?>

					<?php foreach ( $phones as $phone ) : ?>
						<li class="pp-footer-info__contact-item">
							<span class="pp-footer-info__icon" aria-hidden="true">&#9742;</span>
							<?php persiapro_phone_link( $phone ); ?>
						</li>
					<?php endforeach; ?>

					<?php foreach ( $emails as $email ) : ?>
						<li class="pp-footer-info__contact-item">
							<span class="pp-footer-info__icon" aria-hidden="true">&#9993;</span>
							<?php persiapro_email_link( $email ); ?>
						</li>
					<?php endforeach; ?>

				</ul>
			</div>

			<?php if ( $has_widgets ) : ?>
				<div class="pp-footer-info__col pp-footer-info__col--widgets">
					<?php get_template_part( 'template-parts/footer', 'widgets', array( 'inline' => true ) ); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>
