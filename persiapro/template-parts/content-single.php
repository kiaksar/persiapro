<?php
/**
 * Template part for displaying single posts
 *
 * @package PersiaPro
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'pp-single-post' ); ?>>
	<header class="pp-single-post__header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="pp-post-card__meta">
			<?php persiapro_posted_on(); ?>
			<?php persiapro_posted_by(); ?>
			<?php persiapro_entry_categories(); ?>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="pp-single-post__featured">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>
	<?php endif; ?>

	<div class="pp-single-post__content entry-content">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'persiapro' ),
			'after'  => '</div>',
		) );
		?>
	</div>

	<footer class="entry-footer">
		<?php
		$tags_list = get_the_tag_list( '', ', ' );
		if ( $tags_list ) {
			printf(
				'<div class="pp-post-tags"><span>%1$s</span> %2$s</div>',
				esc_html__( 'Tags:', 'persiapro' ),
				$tags_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
		?>
	</footer>

	<nav class="pp-post-nav">
		<div class="pp-post-nav__prev">
			<?php previous_post_link( '%link', esc_html__( '&rarr; Previous Post', 'persiapro' ) ); ?>
		</div>
		<div class="pp-post-nav__next">
			<?php next_post_link( '%link', esc_html__( 'Next Post &larr;', 'persiapro' ) ); ?>
		</div>
	</nav>

	<?php
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
	?>
</article>
