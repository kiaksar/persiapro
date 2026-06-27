<?php
/**
 * Front page template
 *
 * @package PersiaPro
 * @since 1.1.0
 */

get_header();
?>

<div id="primary" class="pp-site-content pp-front-page">
	<?php get_template_part( 'template-parts/home/materials' ); ?>
	<?php get_template_part( 'template-parts/home/blog-slider' ); ?>
</div>

<?php
get_footer();
