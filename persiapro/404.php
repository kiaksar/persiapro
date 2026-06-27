<?php
/**
 * 404 template
 *
 * @package PersiaPro
 * @since 1.0.0
 */

get_header();
?>

<div id="primary" class="pp-site-content">
	<div class="pp-container">
		<main id="main" class="pp-main">
			<section class="pp-404">
				<div class="pp-404__code">404</div>
				<h1><?php esc_html_e( 'Page Not Found', 'persiapro' ); ?></h1>
				<p><?php esc_html_e( 'Sorry, the page you are looking for does not exist or has been moved.', 'persiapro' ); ?></p>
				<?php get_search_form(); ?>
				<p style="margin-top: 2rem;">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pp-btn pp-btn--primary">
						<?php esc_html_e( 'Back to Homepage', 'persiapro' ); ?>
					</a>
				</p>
			</section>
		</main>
	</div>
</div>

<?php
get_footer();
