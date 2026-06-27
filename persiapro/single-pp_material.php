<?php
/**
 * Single material template
 *
 * @package PersiaPro
 * @since 1.1.0
 */

get_header();
?>

<div id="primary" class="pp-site-content">
	<div class="pp-container">
		<?php persiapro_breadcrumb(); ?>

		<main id="main" class="pp-main">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="material-<?php the_ID(); ?>" <?php post_class( 'pp-material-single' ); ?>>
					<header class="pp-material-single__header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="pp-material-single__featured">
							<?php the_post_thumbnail( 'large' ); ?>
						</div>
					<?php endif; ?>

					<div class="pp-material-single__content entry-content">
						<?php the_content(); ?>
					</div>

					<footer class="pp-material-single__footer">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'pp_material' ) ); ?>" class="pp-btn pp-btn--outline">
							<?php esc_html_e( '&rarr; Back to Materials', 'persiapro' ); ?>
						</a>
					</footer>
				</article>
				<?php
			endwhile;
			?>
		</main>
	</div>
</div>

<?php
get_footer();
