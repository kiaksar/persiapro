<?php
/**
 * Footer widgets template part
 *
 * @package PersiaPro
 * @since 1.0.0
 */

$columns = absint( get_theme_mod( 'persiapro_footer_columns', 4 ) );
$inline  = isset( $args['inline'] ) && $args['inline'];
$has_widgets = false;

for ( $i = 1; $i <= $columns; $i++ ) {
	if ( is_active_sidebar( 'footer-' . $i ) ) {
		$has_widgets = true;
		break;
	}
}

if ( ! $has_widgets ) {
	return;
}

$grid_class = 'pp-footer-widgets__grid pp-footer-widgets__grid--' . esc_attr( $columns );
if ( $inline ) {
	$grid_class .= ' pp-footer-widgets__grid--inline';
}
?>

<?php if ( ! $inline ) : ?>
<div class="pp-footer-widgets">
	<div class="pp-container">
<?php endif; ?>

		<div class="<?php echo esc_attr( $grid_class ); ?>">
			<?php for ( $i = 1; $i <= $columns; $i++ ) : ?>
				<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
					<div class="pp-footer-widgets__column">
						<?php dynamic_sidebar( 'footer-' . $i ); ?>
					</div>
				<?php endif; ?>
			<?php endfor; ?>
		</div>

<?php if ( ! $inline ) : ?>
	</div>
</div>
<?php endif; ?>
