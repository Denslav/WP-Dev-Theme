<?php
/**
 * Single post template.
 *
 * @package main-theme
 */

get_header();
?>

<main id="primary" class="site-main single-post-template">
	<div class="container">
		<div class="wrapper">
			<?php
			while ( have_posts() ) {
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-' . get_post_type() ); ?>>
					<header class="entry-header heading">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

						<?php if ( 'post' === get_post_type() ) : ?>
							<div class="entry-meta">
								<?php main_posted_on(); ?>
								<?php main_posted_by(); ?>
							</div>
						<?php endif; ?>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="post-thumbnail">
							<?php the_post_thumbnail( 'large' ); ?>
						</div>
					<?php endif; ?>

					<div class="entry-content content">
						<?php
						the_content();
						wp_link_pages(
							array(
								'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Post pages', 'main' ) . '">' . esc_html__( 'Pages:', 'main' ),
								'after'  => '</nav>',
							)
						);
						?>
					</div>

					<footer class="entry-footer">
						<?php main_entry_footer(); ?>
					</footer>
				</article>

				<?php
				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'main' ) . '</span> <span class="nav-title">%title</span>',
						'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'main' ) . '</span> <span class="nav-title">%title</span>',
					)
				);

				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			}
			?>
		</div>
	</div>
</main>

<?php get_footer(); ?>
