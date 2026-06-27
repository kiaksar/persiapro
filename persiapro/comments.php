<?php
/**
 * Comments template
 *
 * @package PersiaPro
 * @since 1.0.0
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="pp-comments">

	<?php if ( have_comments() ) : ?>
		<h3 class="pp-comments-title">
			<?php
			$comment_count = get_comments_number();
			printf(
				/* translators: 1: comment count */
				esc_html( _n( '%1$s Comment', '%1$s Comments', $comment_count, 'persiapro' ) ),
				number_format_i18n( $comment_count )
			);
			?>
		</h3>

		<ol class="pp-comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 50,
				'callback'    => 'persiapro_comment_callback',
			) );
			?>
		</ol>

		<?php the_comments_navigation(); ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="pp-no-comments"><?php esc_html_e( 'Comments are closed.', 'persiapro' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( array(
		'title_reply'          => esc_html__( 'Leave a Comment', 'persiapro' ),
		'title_reply_to'       => esc_html__( 'Reply to %s', 'persiapro' ),
		'cancel_reply_link'    => esc_html__( 'Cancel Reply', 'persiapro' ),
		'label_submit'         => esc_html__( 'Post Comment', 'persiapro' ),
		'comment_notes_before' => '',
	) );
	?>

</div>
