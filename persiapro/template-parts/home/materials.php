<?php
/**
 * Materials section for homepage
 *
 * @package PersiaPro
 * @since 1.1.0
 */

if ( ! get_theme_mod( 'persiapro_materials_enable', true ) ) {
	return;
}

$count = absint( get_theme_mod( 'persiapro_materials_count', 6 ) );

$materials = new WP_Query( array(
	'post_type'      => 'pp_material',
	'posts_per_page' => $count,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'post_status'    => 'publish',
) );

if ( ! $materials->have_posts() ) {
	return;
}

$title    = persiapro_get_theme_mod( 'persiapro_materials_title' );
$subtitle = persiapro_get_theme_mod( 'persiapro_materials_subtitle' );
?>

<section class="pp-section pp-materials" id="materials">
	<div class="pp-container">
		<header class="pp-section__header pp-text-center">
			<?php if ( $title ) : ?>
				<h2 class="pp-section__title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( $subtitle ) : ?>
				<p class="pp-section__subtitle"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</header>

		<div class="pp-materials__grid">
			<?php
			while ( $materials->have_posts() ) :
				$materials->the_post();
				get_template_part( 'template-parts/content', 'material' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>

		<?php if ( get_theme_mod( 'persiapro_materials_show_archive_link', true ) ) : ?>
			<div class="pp-section__footer pp-text-center">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'pp_material' ) ); ?>" class="pp-btn pp-btn--outline">
					<?php echo esc_html( persiapro_get_theme_mod( 'persiapro_materials_archive_text' ) ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
