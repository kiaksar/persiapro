<?php
/**
 * Hero section template part
 *
 * @package PersiaPro
 * @since 1.0.0
 */

$bg_image_id = get_theme_mod( 'persiapro_hero_bg_image', '' );
$bg_style    = '';

if ( $bg_image_id ) {
	$bg_url = wp_get_attachment_image_url( $bg_image_id, 'persiapro-hero' );
	if ( $bg_url ) {
		$bg_style = ' style="background-image: url(' . esc_url( $bg_url ) . ');"';
	}
}

$btn1_style = sanitize_html_class( get_theme_mod( 'persiapro_hero_btn1_style', 'primary' ) );
$btn2_style = sanitize_html_class( get_theme_mod( 'persiapro_hero_btn2_style', 'secondary' ) );
?>

<section class="pp-hero"<?php echo $bg_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="pp-hero__overlay"></div>
	<div class="pp-hero__content">
		<?php if ( $title = get_theme_mod( 'persiapro_hero_title', '' ) ) : ?>
			<h1 class="pp-hero__title"><?php echo esc_html( $title ); ?></h1>
		<?php endif; ?>

		<?php if ( $subtitle = get_theme_mod( 'persiapro_hero_subtitle', '' ) ) : ?>
			<p class="pp-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>

		<div class="pp-hero__buttons">
			<?php if ( $btn1_text = get_theme_mod( 'persiapro_hero_btn1_text', '' ) ) : ?>
				<a href="<?php echo esc_url( get_theme_mod( 'persiapro_hero_btn1_url', '#' ) ); ?>" class="pp-btn pp-btn--<?php echo esc_attr( $btn1_style ); ?>">
					<?php echo esc_html( $btn1_text ); ?>
				</a>
			<?php endif; ?>

			<?php if ( $btn2_text = get_theme_mod( 'persiapro_hero_btn2_text', '' ) ) : ?>
				<a href="<?php echo esc_url( get_theme_mod( 'persiapro_hero_btn2_url', '#' ) ); ?>" class="pp-btn pp-btn--<?php echo esc_attr( $btn2_style ); ?>">
					<?php echo esc_html( $btn2_text ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
