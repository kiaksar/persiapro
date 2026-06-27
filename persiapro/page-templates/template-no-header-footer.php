<?php
/**
 * Template Name: No Header / Footer
 * Template Post Type: page
 *
 * @package PersiaPro
 * @since 1.0.0
 */

get_header();
?>

<div id="primary" class="pp-site-content">
	<div class="pp-container">
		<main id="main" class="pp-main">

			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'page' );
			endwhile;
			?>

		</main>
	</div>
</div>

<?php
get_footer();
