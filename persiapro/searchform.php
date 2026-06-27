<?php
/**
 * Search form template
 *
 * @package PersiaPro
 * @since 1.0.0
 */
?>

<form role="search" method="get" class="pp-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="pp-search-field"><?php esc_html_e( 'Search for:', 'persiapro' ); ?></label>
	<input type="search" id="pp-search-field" class="pp-search-field" placeholder="<?php esc_attr_e( 'Search&hellip;', 'persiapro' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
	<button type="submit" class="pp-search-submit"><?php esc_html_e( 'Search', 'persiapro' ); ?></button>
</form>
