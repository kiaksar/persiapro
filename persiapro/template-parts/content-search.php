<?php
/**
 * Template part for displaying search results
 *
 * @package PersiaPro
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'pp-post-card' ); ?>>
	<div class="pp-post-card__body">
		<div class="pp-post-card__meta">
			<?php persiapro_posted_on(); ?>
			<span class="pp-post-card__type"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
		</div>

		<h2 class="pp-post-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<div class="pp-post-card__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<?php persiapro_read_more_link(); ?>
	</div>
</article>
