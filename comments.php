<?php
/**
 * Comments template.
 *
 * @package main-theme
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();

			if ( 1 === $comment_count ) {
				printf(
					/* translators: %s: post title. */
					esc_html__( 'One comment on “%s”', 'main' ),
					esc_html( get_the_title() )
				);
			} else {
				printf(
					/* translators: 1: number of comments, 2: post title. */
					esc_html( _n( '%1$s comment on “%2$s”', '%1$s comments on “%2$s”', $comment_count, 'main' ) ),
					esc_html( number_format_i18n( $comment_count ) ),
					esc_html( get_the_title() )
				);
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 40,
				)
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'main' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>
</section>
