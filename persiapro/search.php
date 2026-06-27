<?php
/**
 * Search results template
 *
 * @package PersiaPro
 * @since 1.0.0
 */

get_header();
?>

<div id="primary" class="pp-site-content">
	<div class="pp-container">
		<?php persiapro_breadcrumb(); ?>

		<header class="pp-search-header pp-text-center">
			<h1 class="pp-search-title">
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Search Results for: %s', 'persiapro' ),
					'<span>' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>
		</header>

		<div class="<?php echo esc_attr( persiapro_layout_classes() ); ?>">
			<main id="main" class="pp-main">

				<?php if ( have_posts() ) : ?>

					<div class="pp-posts-list">

						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content', 'search' );
						endwhile;
						?>

					</div>

					<?php persiapro_pagination(); ?>

				<?php else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>

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
