<?php
/**
 * Custom post types.
 *
 * @package PersiaPro
 * @since 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Materials post type.
 */
function persiapro_register_post_types() {
	$labels = array(
		'name'                  => esc_html__( 'Materials', 'persiapro' ),
		'singular_name'         => esc_html__( 'Material', 'persiapro' ),
		'menu_name'             => esc_html__( 'Materials', 'persiapro' ),
		'add_new'               => esc_html__( 'Add New', 'persiapro' ),
		'add_new_item'          => esc_html__( 'Add New Material', 'persiapro' ),
		'edit_item'             => esc_html__( 'Edit Material', 'persiapro' ),
		'new_item'              => esc_html__( 'New Material', 'persiapro' ),
		'view_item'             => esc_html__( 'View Material', 'persiapro' ),
		'view_items'            => esc_html__( 'View Materials', 'persiapro' ),
		'search_items'          => esc_html__( 'Search Materials', 'persiapro' ),
		'not_found'             => esc_html__( 'No materials found.', 'persiapro' ),
		'not_found_in_trash'    => esc_html__( 'No materials found in Trash.', 'persiapro' ),
		'all_items'             => esc_html__( 'All Materials', 'persiapro' ),
		'featured_image'        => esc_html__( 'Material Image', 'persiapro' ),
		'set_featured_image'    => esc_html__( 'Set material image', 'persiapro' ),
		'remove_featured_image' => esc_html__( 'Remove material image', 'persiapro' ),
		'use_featured_image'    => esc_html__( 'Use as material image', 'persiapro' ),
	);

	register_post_type( 'pp_material', array(
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'materials' ),
		'capability_type'     => 'post',
		'has_archive'         => true,
		'hierarchical'        => false,
		'menu_position'       => 21,
		'menu_icon'           => 'dashicons-products',
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'show_in_rest'        => true,
	) );
}
add_action( 'init', 'persiapro_register_post_types' );

/**
 * Register material meta.
 */
function persiapro_register_material_meta() {
	register_post_meta( 'pp_material', '_pp_material_button_text', array(
		'single'            => true,
		'type'              => 'string',
		'show_in_rest'      => true,
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
	) );

	register_post_meta( 'pp_material', '_pp_material_link_url', array(
		'single'            => true,
		'type'              => 'string',
		'show_in_rest'      => true,
		'sanitize_callback' => 'esc_url_raw',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
	) );
}
add_action( 'init', 'persiapro_register_material_meta' );

/**
 * Add material meta box.
 */
function persiapro_material_meta_box() {
	add_meta_box(
		'persiapro_material_options',
		esc_html__( 'Material Display Options', 'persiapro' ),
		'persiapro_material_meta_box_render',
		'pp_material',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'persiapro_material_meta_box' );

/**
 * Render material meta box.
 *
 * @param WP_Post $post Post object.
 */
function persiapro_material_meta_box_render( $post ) {
	wp_nonce_field( 'persiapro_save_material_meta', 'persiapro_material_meta_nonce' );

	$button_text = get_post_meta( $post->ID, '_pp_material_button_text', true );
	$link_url    = get_post_meta( $post->ID, '_pp_material_link_url', true );
	?>
	<p>
		<label for="pp_material_button_text"><strong><?php esc_html_e( 'Button Text', 'persiapro' ); ?></strong></label>
		<input type="text" id="pp_material_button_text" name="pp_material_button_text" class="widefat" value="<?php echo esc_attr( $button_text ); ?>" placeholder="<?php echo esc_attr( persiapro_get_theme_mod( 'persiapro_materials_btn_text' ) ); ?>">
	</p>
	<p>
		<label for="pp_material_link_url"><strong><?php esc_html_e( 'Custom Link URL', 'persiapro' ); ?></strong></label>
		<input type="url" id="pp_material_link_url" name="pp_material_link_url" class="widefat" value="<?php echo esc_url( $link_url ); ?>" placeholder="<?php echo esc_attr( home_url( '/' ) ); ?>">
		<span class="description"><?php esc_html_e( 'Leave empty to use the material page URL.', 'persiapro' ); ?></span>
	</p>
	<p class="description"><?php esc_html_e( 'Use "Order" in Page Attributes to control homepage display order.', 'persiapro' ); ?></p>
	<?php
}

/**
 * Save material meta.
 *
 * @param int $post_id Post ID.
 */
function persiapro_save_material_meta( $post_id ) {
	if ( ! isset( $_POST['persiapro_material_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['persiapro_material_meta_nonce'] ) ), 'persiapro_save_material_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['pp_material_button_text'] ) ) {
		update_post_meta( $post_id, '_pp_material_button_text', sanitize_text_field( wp_unslash( $_POST['pp_material_button_text'] ) ) );
	}

	if ( isset( $_POST['pp_material_link_url'] ) ) {
		update_post_meta( $post_id, '_pp_material_link_url', esc_url_raw( wp_unslash( $_POST['pp_material_link_url'] ) ) );
	}
}
add_action( 'save_post_pp_material', 'persiapro_save_material_meta' );

/**
 * Get material link URL.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function persiapro_get_material_link( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$custom  = get_post_meta( $post_id, '_pp_material_link_url', true );

	if ( ! empty( $custom ) ) {
		return $custom;
	}

	return get_permalink( $post_id );
}

/**
 * Get material button text.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function persiapro_get_material_button_text( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$text    = get_post_meta( $post_id, '_pp_material_button_text', true );

	if ( ! empty( $text ) ) {
		return $text;
	}

	return persiapro_get_theme_mod( 'persiapro_materials_btn_text' );
}
