<?php
/**
 * Materials archive template
 *
 * @package PersiaPro
 * @since 1.1.0
 */

get_header();
?>

<div id="primary" class="pp-site-content">
	<div class="pp-container">
		<?php persiapro_breadcrumb(); ?>

		<header class="pp-archive-header pp-text-center">
			<h1 class="pp-archive-title"><?php post_type_archive_title(); ?></h1>
			<?php if ( get_theme_mod( 'persiapro_materials_subtitle', '' ) ) : ?>
				<p class="pp-archive-description"><?php echo esc_html( get_theme_mod( 'persiapro_materials_subtitle' ) ); ?></p>
			<?php endif; ?>
		</header>

		<main id="main" class="pp-main">
			<?php if ( have_posts() ) : ?>
				<div class="pp-materials__grid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'material' );
					endwhile;
					?>
				</div>
				<?php persiapro_pagination(); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</main>
	</div>
</div>

<?php
get_footer();
