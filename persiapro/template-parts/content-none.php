<?php
/**
 * Template part for displaying a message when no posts found
 *
 * @package PersiaPro
 * @since 1.0.0
 */
?>

<section class="pp-no-results">
	<h2><?php esc_html_e( 'Nothing Found', 'persiapro' ); ?></h2>

	<?php if ( is_search() ) : ?>
		<p><?php esc_html_e( 'Sorry, no results matched your search. Please try again with different keywords.', 'persiapro' ); ?></p>
		<?php get_search_form(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'It seems we cannot find what you are looking for. Perhaps searching can help.', 'persiapro' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</section>
