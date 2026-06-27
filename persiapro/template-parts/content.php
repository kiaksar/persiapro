<?php
/**
 * Template part for displaying posts in grid/list
 *
 * @package PersiaPro
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'pp-post-card' ); ?>>
	<?php if ( get_theme_mod( 'persiapro_show_featured_image', true ) && has_post_thumbnail() ) : ?>
		<div class="pp-post-card__image">
			<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php the_post_thumbnail( 'persiapro-card' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="pp-post-card__body">
		<div class="pp-post-card__meta">
			<?php persiapro_posted_on(); ?>
			<?php persiapro_entry_categories(); ?>
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
