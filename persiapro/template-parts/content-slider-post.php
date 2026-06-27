<?php
/**
 * Blog post card for homepage slider
 *
 * @package PersiaPro
 * @since 1.1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'pp-slider-post' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="pp-slider-post__image">
			<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
				<?php the_post_thumbnail( 'persiapro-thumbnail' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="pp-slider-post__body">
		<div class="pp-slider-post__meta">
			<?php persiapro_posted_on(); ?>
		</div>
		<h3 class="pp-slider-post__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>
		<div class="pp-slider-post__excerpt">
			<?php echo esc_html( wp_trim_words( get_the_excerpt(), 15, '&hellip;' ) ); ?>
		</div>
		<?php persiapro_read_more_link(); ?>
	</div>
</article>
