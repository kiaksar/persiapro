<?php
/**
 * Page template
 *
 * @package PersiaPro
 * @since 1.0.0
 */

get_header();
?>

<div id="primary" class="pp-site-content">
	<div class="pp-container">
		<?php persiapro_breadcrumb(); ?>

		<div class="<?php echo esc_attr( persiapro_layout_classes() ); ?>">
			<main id="main" class="pp-main">

				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'page' );
				endwhile;
				?>

			</main>

			<?php
			if ( is_active_sidebar( 'sidebar-1' ) && 'none' !== get_theme_mod( 'persiapro_sidebar_position', 'left' ) ) {
				get_sidebar();
			}
			?>
		</div>
	</div>
</div>

<?php
get_footer();
