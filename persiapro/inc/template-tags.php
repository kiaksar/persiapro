<?php
/**
 * Custom template tags for this theme.
 *
 * @package PersiaPro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display posted-on date.
 */
function persiapro_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	echo '<span class="pp-post-card__date">' . $time_string . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Display post author.
 */
function persiapro_posted_by() {
	echo '<span class="pp-post-card__author">';
	printf(
		/* translators: %s: post author name */
		esc_html__( 'By %s', 'persiapro' ),
		'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
	);
	echo '</span>';
}

/**
 * Display categories.
 */
function persiapro_entry_categories() {
	if ( 'post' === get_post_type() ) {
		$categories = get_the_category();
		if ( $categories ) {
			echo '<span class="pp-post-card__category">';
			echo esc_html( $categories[0]->name );
			echo '</span>';
		}
	}
}

/**
 * Display read more link.
 */
function persiapro_read_more_link() {
	$text = persiapro_get_theme_mod( 'persiapro_read_more_text' );
	printf(
		'<a href="%1$s" class="pp-read-more">%2$s <span aria-hidden="true">&larr;</span></a>',
		esc_url( get_permalink() ),
		esc_html( $text )
	);
}

/**
 * Output a phone link with forced LTR display.
 *
 * @param string $phone   Phone number.
 * @param array  $args    Optional arguments.
 */
function persiapro_phone_link( $phone, $args = array() ) {
	if ( empty( $phone ) ) {
		return;
	}

	$args = wp_parse_args( $args, array(
		'class'      => '',
		'show_icon'  => false,
		'icon'       => '&#9742;',
	) );

	$tel = preg_replace( '/[^0-9+]/', '', $phone );
	$class = trim( 'pp-phone-link ' . $args['class'] );

	echo '<a href="tel:' . esc_attr( $tel ) . '" class="' . esc_attr( $class ) . '">';
	if ( $args['show_icon'] ) {
		echo '<span class="pp-phone-link__icon" aria-hidden="true">' . $args['icon'] . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '<span class="pp-ltr-text" dir="ltr">' . esc_html( $phone ) . '</span>';
	echo '</a>';
}

/**
 * Output an email link with forced LTR display.
 *
 * @param string $email Email address.
 * @param array  $args  Optional arguments.
 */
function persiapro_email_link( $email, $args = array() ) {
	if ( empty( $email ) ) {
		return;
	}

	$args = wp_parse_args( $args, array(
		'class'     => '',
		'show_icon' => false,
		'icon'      => '&#9993;',
	) );

	$class = trim( 'pp-email-link ' . $args['class'] );

	echo '<a href="mailto:' . esc_attr( $email ) . '" class="' . esc_attr( $class ) . '">';
	if ( $args['show_icon'] ) {
		echo '<span class="pp-email-link__icon" aria-hidden="true">' . $args['icon'] . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '<span class="pp-ltr-text" dir="ltr">' . esc_html( $email ) . '</span>';
	echo '</a>';
}

/**
 * Get footer phone numbers (up to 3).
 *
 * @return array
 */
function persiapro_get_footer_phones() {
	$phones = array();

	for ( $i = 1; $i <= 3; $i++ ) {
		$key = 1 === $i ? 'persiapro_footer_phone' : 'persiapro_footer_phone' . $i;
		$phone = persiapro_get_theme_mod( $key, '' );
		if ( ! empty( $phone ) ) {
			$phones[] = $phone;
		}
	}

	return $phones;
}

/**
 * Get footer email addresses (up to 3).
 *
 * @return array
 */
function persiapro_get_footer_emails() {
	$emails = array();

	for ( $i = 1; $i <= 3; $i++ ) {
		$key = 1 === $i ? 'persiapro_footer_email' : 'persiapro_footer_email' . $i;
		$email = persiapro_get_theme_mod( $key, '' );
		if ( ! empty( $email ) && is_email( $email ) ) {
			$emails[] = $email;
		}
	}

	return $emails;
}

/**
 * Display breadcrumb navigation.
 */
function persiapro_breadcrumb() {
	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="pp-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'persiapro' ) . '">';
	echo '<ol class="pp-breadcrumb__list">';

	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'persiapro' ) . '</a></li>';

	if ( is_category() || is_single() ) {
		$categories = get_the_category();
		if ( $categories ) {
			echo '<li><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></li>';
		}
		if ( is_single() ) {
			echo '<li>' . esc_html( get_the_title() ) . '</li>';
		}
	} elseif ( is_page() ) {
		echo '<li>' . esc_html( get_the_title() ) . '</li>';
	} elseif ( is_search() ) {
		echo '<li>' . esc_html__( 'Search Results', 'persiapro' ) . '</li>';
	} elseif ( is_404() ) {
		echo '<li>' . esc_html__( '404 Not Found', 'persiapro' ) . '</li>';
	} elseif ( is_post_type_archive( 'pp_material' ) ) {
		echo '<li>' . esc_html__( 'Materials', 'persiapro' ) . '</li>';
	} elseif ( is_singular( 'pp_material' ) ) {
		echo '<li><a href="' . esc_url( get_post_type_archive_link( 'pp_material' ) ) . '">' . esc_html__( 'Materials', 'persiapro' ) . '</a></li>';
		echo '<li>' . esc_html( get_the_title() ) . '</li>';
	} elseif ( is_archive() ) {
		echo '<li>' . esc_html( get_the_archive_title() ) . '</li>';
	}

	echo '</ol>';
	echo '</nav>';
}

/**
 * Display social icons.
 *
 * @param string $context Display context (topbar, footer).
 */
function persiapro_social_icons( $context = 'footer' ) {
	$networks = array(
		'instagram' => array(
			'label' => 'Instagram',
		),
		'telegram'  => array(
			'label' => 'Telegram',
		),
		'linkedin'  => array(
			'label' => 'LinkedIn',
		),
		'twitter'   => array(
			'label' => 'Twitter / X',
		),
		'facebook'  => array(
			'label' => 'Facebook',
		),
		'youtube'   => array(
			'label' => 'YouTube',
		),
		'whatsapp'  => array(
			'label' => 'WhatsApp',
		),
	);

	$class = 'footer' === $context ? 'pp-footer-social' : 'pp-top-bar__social';
	$has_icons = false;

	// First pass: check if any social link exists
	foreach ( $networks as $key => $network ) {
		$url = get_theme_mod( 'persiapro_social_' . $key, '' );
		if ( ! empty( $url ) ) {
			$has_icons = true;
			break;
		}
	}

	if ( ! $has_icons ) {
		return;
	}

	echo '<div class="' . esc_attr( $class ) . '">';

	foreach ( $networks as $key => $network ) {
		$url = get_theme_mod( 'persiapro_social_' . $key, '' );
		
		if ( ! empty( $url ) ) {
			// Get custom image URL from theme mod
			$icon_url = get_theme_mod( 'persiapro_social_' . $key . '_icon', '' );
			
			// Fallback: you can keep Unicode or use a default image
			if ( empty( $icon_url ) ) {
				$icon_html = '<span class="pp-icon" aria-hidden="true">' . ($networks[$key]['icon'] ?? '&#xf16d;') . '</span>';
			} else {
				$icon_html = '<img src="' . esc_url( $icon_url ) . '" alt="' . esc_attr( $network['label'] ) . '" class="pp-social-icon" width="24" height="24">';
			}

			printf(
				'<a href="%1$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s">%3$s</a>',
				esc_url( $url ),
				esc_attr( $network['label'] ),
				$icon_html
			);
		}
	}

	echo '</div>';
}

/**
 * Check if hero should display.
 *
 * @return bool
 */
function persiapro_show_hero() {
	return is_front_page() && get_theme_mod( 'persiapro_hero_enable', true );
}

/**
 * Get header CSS classes.
 *
 * @return string
 */
function persiapro_header_classes() {
	$classes = array( 'pp-header' );

	if ( get_theme_mod( 'persiapro_header_sticky', true ) ) {
		$classes[] = 'pp-header--sticky';
	}

	if ( get_theme_mod( 'persiapro_header_transparent', false ) && is_front_page() ) {
		$classes[] = 'pp-header--transparent';
	}

	return implode( ' ', $classes );
}

/**
 * Get layout CSS classes.
 *
 * @return string
 */
function persiapro_layout_classes() {
	$classes = array( 'pp-layout' );

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/template-full-width.php' ) || is_page_template( 'page-templates/template-landing.php' ) ) {
		return 'pp-layout';
	}

	$position = get_theme_mod( 'persiapro_sidebar_position', 'left' );

	if ( 'right' === $position ) {
		$classes[] = 'pp-layout--sidebar-left';
	} else {
		$classes[] = 'pp-layout--sidebar';
	}

	return implode( ' ', $classes );
}

/**
 * Display pagination.
 */
function persiapro_pagination() {
	the_posts_pagination( array(
		'mid_size'  => 2,
		'prev_text' => esc_html__( '&rarr; Previous', 'persiapro' ),
		'next_text' => esc_html__( 'Next &larr;', 'persiapro' ),
	) );
}

/**
 * Custom comment callback.
 *
 * @param WP_Comment $comment Comment object.
 * @param array      $args    Arguments.
 * @param int        $depth   Depth.
 */
function persiapro_comment_callback( $comment, $args, $depth ) {
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'pp-comment' ); ?>>
		<article class="pp-comment-body">
			<footer class="pp-comment-meta">
				<?php echo get_avatar( $comment, 50 ); ?>
				<b class="pp-comment-author"><?php comment_author_link(); ?></b>
				<time datetime="<?php comment_time( 'c' ); ?>">
					<?php
					printf(
						/* translators: 1: date, 2: time */
						esc_html__( '%1$s at %2$s', 'persiapro' ),
						get_comment_date(),
						get_comment_time()
					);
					?>
				</time>
			</footer>
			<div class="pp-comment-content">
				<?php comment_text(); ?>
			</div>
			<?php
			comment_reply_link( array_merge( $args, array(
				'depth'     => $depth,
				'max_depth' => $args['max_depth'],
				'before'    => '<div class="pp-comment-reply">',
				'after'     => '</div>',
			) ) );
			?>
		</article>
	<?php
}

/**
 * Display language switcher (Polylang compatible).
 *
 * Shows FA/EN buttons in the top bar for switching between Persian and English.
 */
function persiapro_language_switcher() {
	// Check if Polylang is active
	if ( ! function_exists( 'pll_the_languages' ) ) {
		return;
	}

	$languages = pll_the_languages( array(
		'show_flags' => false,
		'show_names' => false,
		'hide_current' => true,
		'raw' => true,
	) );

	if ( empty( $languages ) ) {
		return;
	}

	$current_lang = pll_current_language();
	$lang_slug = $current_lang ? $current_lang : 'fa';

	echo '<div class="pp-language-switcher">';

	// Current language button (inactive)
	$current_label = 'fa' === $lang_slug ? 'FA' : 'EN';
	echo '<span class="pp-lang-btn pp-lang-btn--current">' . esc_html( $current_label ) . '</span>';

	// Other language buttons (active links)
	foreach ( $languages as $lang ) {
		$label = 'fa' === $lang['slug'] ? 'FA' : 'EN';
		printf(
			'<a href="%1$s" class="pp-lang-btn" hreflang="%2$s">%3$s</a>',
			esc_url( $lang['url'] ),
			esc_attr( $lang['slug'] ),
			esc_html( $label )
		);
	}

	echo '</div>';
}
