<?php
/**
 * Archive template
 *
 * @package PersiaPro
 * @since 1.0.0
 */

get_header();
?>

<div id="primary" class="pp-site-content">
	<div class="pp-container">
		<?php persiapro_breadcrumb(); ?>

		<header class="pp-archive-header pp-text-center">
			<?php the_archive_title( '<h1 class="pp-archive-title">', '</h1>' ); ?>
			<?php the_archive_description( '<div class="pp-archive-description">', '</div>' ); ?>
		</header>

		<div class="<?php echo esc_attr( persiapro_layout_classes() ); ?>">
			<main id="main" class="pp-main">

				<?php if ( have_posts() ) : ?>

					<?php
					$layout = get_theme_mod( 'persiapro_blog_layout', 'grid' );
					$list_class = 'grid' === $layout ? 'pp-posts-grid' : 'pp-posts-list';
					?>
					<div class="<?php echo esc_attr( $list_class ); ?>">

						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content', get_post_type() );
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
