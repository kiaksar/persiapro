<?php
/**
 * Template Name: Landing Page
 * Template Post Type: page
 *
 * @package PersiaPro
 * @since 1.0.0
 */

get_header();
?>

<div id="primary" class="pp-site-content pp-landing-page">
	<main id="main" class="pp-main pp-main--landing">

		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		endwhile;
		?>

	</main>
</div>

<?php
get_footer();
