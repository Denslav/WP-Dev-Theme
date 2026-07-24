<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-' . get_post_type() ); ?>>
	<div class="post-wrapper">
		<?php if ( has_post_thumbnail() ) : ?>
			<a class="post-thumbnail" href="<?php echo esc_url( get_permalink() ); ?>" aria-hidden="true" tabindex="-1">
				<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
			</a>
		<?php endif; ?>

		<div class="post-content">
			<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php main_posted_on(); ?>
				</div>
			<?php endif; ?>

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>

			<a class="read-more" href="<?php echo esc_url( get_permalink() ); ?>">
				<?php esc_html_e( 'Read More', 'main' ); ?>
				<span class="screen-reader-text">: <?php the_title(); ?></span>
			</a>
		</div>
	</div>
</article>
