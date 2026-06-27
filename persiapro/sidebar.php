<?php
/**
 * Sidebar template
 *
 * @package PersiaPro
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="pp-sidebar widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'persiapro' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
