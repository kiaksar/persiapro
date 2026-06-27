<?php
/**
 * Material card for homepage grid
 *
 * @package PersiaPro
 * @since 1.1.0
 */
?>

<article id="material-<?php the_ID(); ?>" <?php post_class( 'pp-material-card' ); ?>>
	<div class="pp-material-card__image">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'persiapro-card' ); ?>
		<?php else : ?>
			<div class="pp-material-card__placeholder" aria-hidden="true">
				<span>&#128230;</span>
			</div>
		<?php endif; ?>
	</div>

	<div class="pp-material-card__body">
		<h3 class="pp-material-card__title"><?php the_title(); ?></h3>

		<?php if ( has_excerpt() || get_the_content() ) : ?>
			<div class="pp-material-card__desc">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>

		<a href="<?php echo esc_url( persiapro_get_material_link() ); ?>" class="pp-btn pp-btn--primary pp-material-card__btn">
			<?php echo esc_html( persiapro_get_material_button_text() ); ?>
		</a>
	</div>
</article>
