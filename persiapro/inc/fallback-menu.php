<?php
/**
 * Fallback menu when no menu is assigned.
 */
function persiapro_fallback_menu() {
	echo '<ul class="pp-nav__list">';
	wp_list_pages( array(
		'title_li' => '',
		'depth'    => 1,
	) );
	echo '</ul>';
}
