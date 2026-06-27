<?php
/**
 * Footer template
 *
 * @package PersiaPro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hide_footer = is_page_template( 'page-templates/template-no-header-footer.php' ) || is_page_template( 'page-templates/template-landing.php' );
?>

<?php if ( ! $hide_footer ) : ?>

	<footer id="colophon" class="pp-footer">
		<?php get_template_part( 'template-parts/footer', 'info' ); ?>

		<div class="pp-footer-bottom">
			<div class="pp-container">
				<div class="pp-footer-bottom__inner">
					<div class="pp-footer-copyright">
						<?php echo wp_kses_post( get_theme_mod( 'persiapro_footer_copyright', '' ) ); ?>
					</div>
				</div>
			</div>
		</div>
	</footer>

<?php endif; ?>

<?php if ( get_theme_mod( 'persiapro_back_to_top', true ) ) : ?>
	<button class="pp-back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'persiapro' ); ?>" title="<?php esc_attr_e( 'Back to top', 'persiapro' ); ?>">
		<span aria-hidden="true">&#8593;</span>
	</button>
<?php endif; ?>

</div><!-- .pp-site -->

<?php wp_footer(); ?>
</body>
</html>
