<?php
/**
 * Blog slider section for homepage
 *
 * @package PersiaPro
 * @since 1.1.0
 */

if ( ! get_theme_mod( 'persiapro_blog_slider_enable', true ) ) {
	return;
}

$count = absint( get_theme_mod( 'persiapro_blog_slider_count', 8 ) );

$posts = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => $count,
	'post_status'    => 'publish',
	'ignore_sticky_posts' => true,
) );

if ( ! $posts->have_posts() ) {
	return;
}

$title          = persiapro_get_theme_mod( 'persiapro_blog_slider_title' );
$subtitle       = persiapro_get_theme_mod( 'persiapro_blog_slider_subtitle' );
$desktop_slides = absint( get_theme_mod( 'persiapro_blog_slider_desktop', 3 ) );
?>

<section class="pp-section pp-blog-slider-section" id="blog">
	<div class="pp-container">
		<header class="pp-section__header">
			<div class="pp-section__header-text">
				<?php if ( $title ) : ?>
					<h2 class="pp-section__title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $subtitle ) : ?>
					<p class="pp-section__subtitle"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
			</div>
			<div class="pp-slider__controls">
				<button type="button" class="pp-slider__btn pp-slider__btn--prev" aria-label="<?php esc_attr_e( 'Previous posts', 'persiapro' ); ?>">
					<span aria-hidden="true">&#8594;</span>
				</button>
				<button type="button" class="pp-slider__btn pp-slider__btn--next" aria-label="<?php esc_attr_e( 'Next posts', 'persiapro' ); ?>">
					<span aria-hidden="true">&#8592;</span>
				</button>
			</div>
		</header>

		<div class="pp-slider" data-slides-desktop="<?php echo esc_attr( $desktop_slides ); ?>" data-slides-mobile="1">
			<div class="pp-slider__track">
				<?php
				while ( $posts->have_posts() ) :
					$posts->the_post();
					?>
					<div class="pp-slider__slide">
						<?php get_template_part( 'template-parts/content', 'slider-post' ); ?>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			<div class="pp-slider__dots" aria-hidden="true"></div>
		</div>

		<?php if ( get_theme_mod( 'persiapro_blog_slider_show_blog_link', true ) ) : ?>
			<div class="pp-section__footer pp-text-center">
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="pp-btn pp-btn--primary">
					<?php echo esc_html( persiapro_get_theme_mod( 'persiapro_blog_slider_archive_text' ) ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
