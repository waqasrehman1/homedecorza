<?php
/**
 * The template for displaying comments
 *
 * @package DecorZa
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="decorza-comments-area">
	<?php if ( have_comments() ) : ?>
		<h3 class="decorza-comments-title">
			<?php
			$comment_count = get_comments_number();
			if ( '1' === $comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One Thought on &ldquo;%1$s&rdquo;', 'decorza' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s Thought on &ldquo;%2$s&rdquo;', '%1$s Thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'decorza' ) ),
					number_format_i18n( $comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h3>

		<ol class="decorza-comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 48,
			) );
			?>
		</ol>

		<?php
		the_comments_navigation( array(
			'prev_text' => '&larr; ' . __( 'Older Comments', 'decorza' ),
			'next_text' => __( 'Newer Comments', 'decorza' ) . ' &rarr;',
		) );
		?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments" style="color: var(--color-text-muted); font-style: italic; margin-top: 1.5rem;">
				<?php esc_html_e( 'Comments are closed for this article.', 'decorza' ); ?>
			</p>
		<?php endif; ?>
	<?php endif; ?>

	<?php
	comment_form( array(
		'title_reply'          => __( 'Share Your Design Perspective', 'decorza' ),
		'title_reply_to'       => __( 'Leave a Reply to %s', 'decorza' ),
		'cancel_reply_link'    => __( 'Cancel Reply', 'decorza' ),
		'label_submit'         => __( 'Post Comment', 'decorza' ),
		'class_submit'         => 'decorza-btn decorza-btn-primary',
		'comment_notes_before' => '<p class="comment-notes" style="font-size: 0.9rem; color: var(--color-text-muted); margin-bottom: 1.25rem;">' . __( 'Your email address will not be published. Required fields are marked *', 'decorza' ) . '</p>',
	) );
	?>
</div>
